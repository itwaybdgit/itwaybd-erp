<?php

namespace App\Helpers\DataProcessingFile;

use App\Models\Customer;
use App\Models\MacReseller;
use Carbon\Carbon;

trait MacResellerDataProcessing
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
            $results = $model->where('id', 'like', "%{$search}%");
            foreach ($tableColumnsName as $tableColumns) {
                if ($tableColumns['searchable'] && array_key_exists('data', $tableColumns)) {
                    $results =  $results->orWhere($tableColumns['data'], 'like', "%{$search}%");
                }
            }
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
            foreach ($results as $key => $item) {
                foreach ($tableColumnsName as $columnItem) {
                    if (array_key_exists('data', $columnItem)) {
                        $columnName = $columnItem['data'];

                        $nestedData[$columnItem['data']] = $item->$columnName ?? 'N/A';

                        if (isset($columnItem['relation']) && !empty($columnItem['relation'])) {
                            $relation = $columnItem['relation'];
                            $relatedData = $item->$relation;
                            $nestedData[$columnItem['relation'] . '_' . $columnItem['data']] = $relatedData->$columnName ?? "N/A";
                        }

                        if ($columnItem['data'] == 'recharge_balance') {
                            $nestedData['recharge_balance'] = $item->$columnName ?? '0.00';
                        }

                        if ($columnItem['data'] == 'curent_bill') {
                            $customers = Customer::where('company_id', $item->getUser->company_id)->whereIn('disabled', ['false', 10])->get();
                            $charge = 0;
                            $rate = 0;
                            foreach ($customers as $customer) {
                                if ($customer->protocol_type_id == 3) {
                                    if (isset($item->tariff->package)) {
                                        $rate = $item->tariff->package->where('m_profile_id', $customer->m_p_p_p_profile)->pluck('rate')->first();
                                    }
                                } elseif ($customer->protocol_type_id == 1) {
                                    if ($customer->protocol_type_id == 3) {
                                        $rate = $item->tariff->package->where('m_static_id', $customer->queue_id)->pluck('rate')->first();
                                    }
                                }

                                $dateAsString = Carbon::parse($item->created_at)->format('Y-m');
                                if ($dateAsString == date('Y-m')) {
                                    $dateAsString = Carbon::parse($item->created_at)->format('Y-m-d');
                                    $date = Carbon::parse(Carbon::now()->endOfMonth()->format('Y-m-d'));
                                    $diff = $date->diffInDays($dateAsString);
                                    $rate = (int) (($rate / 30) * $diff);
                                }
                                $charge += $rate;
                            }
                            $nestedData['curent_bill'] = $charge;
                        }

                        if ($columnItem['data'] == 'active_customer') {
                            $customers = Customer::where('company_id', $item->getUser->company_id)->whereIn('disabled', ['false', 10])->count();
                            $nestedData['active_customer'] = $customers;
                        }
                        if ($columnItem['data'] == 'inactive_customer') {
                            $customers = Customer::where('company_id', $item->getUser->company_id)->where('disabled', 'true')->count();
                            $nestedData['inactive_customer'] = $customers;
                        }

                        if ($columnItem['data'] == 'id') {
                            $nestedData['id'] = $item->id;
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
