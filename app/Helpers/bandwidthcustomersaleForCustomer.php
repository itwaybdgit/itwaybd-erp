<?php

namespace App\Helpers;

use App\Models\TransactionHistory;

trait bandwidthcustomersaleForCustomer
{

    protected function reformatForRelationalColumnName(array $columnsName)
    {
        $columns = [];
        foreach ($columnsName as $columnName) {
            if (array_key_exists('data', $columnName)) {
                if (array_key_exists('relation', $columnName)) {
                    $columns[] = [
                        'label' => $columnName['label'],
                        'data' => $columnName['relation'] . '_' . $columnName['data'],
                        'searchable' => $columnName['searchable'],
                        'relation' => $columnName['relation'],
                    ];
                } else {
                    $columns[] = $columnName;
                }
            }
        }
        return $columns;
    }
    /**
     * This method is for proces and return html table row
     * @var $modal instance
     * @var $tableColumnsName
     * @var $routeName
     * @var $show_action
     * @var $action as array
     * @return string
     */
    public function getDataResponse($model, $tableColumnsName, $routeName, $show_action = true, $actions = ['edit',  'destroy'])
    {
        /**
         * Sortable column list mgenerate
         */
        $sortableColumns = [];
        foreach ($tableColumnsName as $columnName) {
            if (array_key_exists('data', $columnName)) {
                if (isset($columnName['orderable']) && $columnName['orderable'] == true) {
                    $sortableColumns[] = $columnName['data'];
                } else {
                    $sortableColumns[] = $columnName['data'];
                }
            }
        }
        // end
        // dd(request(), request('columns.4.search.value'));
        $totalData = $model->count();
        $limit = request('length');
        $start = request('start');
        $order = $sortableColumns[request('order.0.column')];
        $dir = request('order.0.dir');
        if (empty(request('search.value'))) {
            $results = $model->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir);
            foreach ($tableColumnsName as $key => $tableColumns) {
                if (array_key_exists('customesearch', $tableColumns) && request('columns.' . $key . '.search.value')) {
                    $value = trim(request('columns.' . $key . '.search.value'), '"');
                    $results =  $results->where($tableColumns['customesearch'],  $value . "%");
                }
            }
            $results = $results->get();
            $totalFiltered = $totalData;
        } else {
            $search = request('search.value');

            // $results = $model->where(function($query) use ($tableColumnsName,$search){
            //     foreach ($tableColumnsName as $tableColumns) {
            //         if ($tableColumns['searchable'] && array_key_exists('data', $tableColumns) && !array_key_exists('relation', $tableColumns)) {
            //             $query = $query->orWhere($tableColumns['data'], 'like', '%' . $search . '%');
            //         }
            //     }
            // });

            $results =  $model->whereHas('customer', function ($local) use ($tableColumnsName,$search) {
                foreach ($tableColumnsName as $tableColumns) {
                    if ($tableColumns['searchable'] && array_key_exists('data', $tableColumns) && array_key_exists('relation', $tableColumns)) {
                        $local->where("company_name", 'like', '%' . $search . '%')->orWhere($tableColumns['data'], 'like', '%' . $search . '%');
                    }
                 }
              })->orWhere('invoice_no','like', '%' . $search . '%');


            $results =  $results->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $results->count();
            // foreach ($tableColumnsName as $tableColumns) {
            //     if ($tableColumns['searchable'] && array_key_exists('data', $tableColumns)) {
            //         $totalFiltered =  $totalFiltered->orWhere($tableColumns['data'], 'like', "%{$search}%");
            //     }
            // }
        }
        $data = array();
        // dd($sortableColumns);
        if ($results) {
            $count = count($results);
            foreach ($results as $key => $item) {
                foreach ($tableColumnsName as $columnItem) {
                    if (array_key_exists('data', $columnItem)) {
                        $columnName = $columnItem['data'];

                        $nestedData[$columnItem['data']] = $item->$columnName ?? 'N/A';

                        if (isset($columnItem['relation']) && !empty($columnItem['relation']) && !isset($columnItem['fun'])) {
                            $relation = $columnItem['relation'];
                            $relatedData = $item->$relation;
                            $nestedData[$columnItem['relation'] . '_' . $columnItem['data']] = $relatedData->$columnName ?? "N/A";

                            if (isset($columnItem['isdate'])) {
                                $nestedData[$columnItem['relation'] . '_' . $columnItem['data']] = date('d-m-Y', strtotime($relatedData->$columnName));
                            }
                        }

                        if (isset($columnItem['relation']) && !empty($columnItem['relation']) && isset($columnItem['fun'])) {
                            $relation = $columnItem['relation'];
                            $relatedData = $item->$relation();
                            $nestedData[$columnItem['relation'] . '_' . $columnItem['data']] = $relatedData[$columnName] ?? "N/A";

                            if (isset($columnItem['isdate'])) {
                                $nestedData[$columnItem['relation'] . '_' . $columnItem['data']] = date('d-m-Y', strtotime($relatedData->$columnName));
                            }
                        }

                        if ($columnItem['data'] == 'id') {
                            $nestedData['id'] = $count - $key;
                        }

                        if ($columnItem['data'] == 'total') {
                            $nestedData['total'] = number_format($item->total) ?? 0;
                        }

                        if ($columnItem['data'] == 'received_amount') {
                            $upgradation = TransactionHistory::whereMonth('date_',date('m'))->where('model_id',$item->customer_id)->selectRaw('sum(amount) as amount, sum(discount) as discount')->first();

                            $nestedData['received_amount'] = $upgradation->amount ?? 0;
                        }
                        if ($columnItem['data'] == 'discount') {
                            $upgradation = TransactionHistory::whereMonth('date_',date('m'))->where('model_id',$item->customer_id)->selectRaw('sum(amount) as amount, sum(discount) as discount')->first();

                            $nestedData['discount'] = $upgradation->discount ?? 0;
                        }

                        if (isset($columnItem['isdate'])) {
                            // dd(date('d-m-Y', strtotime($item->$columnName)));
                            $nestedData[$columnItem['data']] = date('d-m-Y', strtotime($item->$columnName));
                        }

                        if (array_key_exists('checked', $columnItem)) {
                            $nestedData[$columnItem['data']] = $this->checkedBtn($item->id, $routeName, $columnItem['data'], $item->$columnName, $columnItem['checked']);
                        }

                        if ($columnItem['data'] == 'action' && $show_action) {

                            $nestedData['action'] = '';

                            foreach ($actions as $action) {
                                if (!empty($action) && !is_array($action)) {
                                    if (strtolower($action) == 'show') {
                                        $nestedData['action'] .= $this->showBtn(route($routeName . '.show', $item->id));
                                    } else if (strtolower($action) == 'edit') {
                                        $nestedData['action'] .= $this->editBtn(route($routeName . '.edit', $item->id));
                                    } else if (strtolower($action) == 'destroy') {
                                        $nestedData['action'] .= $this->destroyBtn(route($routeName . '.destroy', $item->id));
                                    }
                                } else if (is_array($action)) {
                                        $nestedData['action'] .= $this->customBtn(
                                            route($routeName . '.' . $action['method_name'], $item->id),
                                            $action['class'],
                                            $action['fontawesome'],
                                            $action['text'],
                                            $action['title'],
                                            $action['code'] ?? "",
                                        );
                              }

                            }
                        }
                    }
                }

                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval(request('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        return $json_data;
    }
}
