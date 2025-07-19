<?php

namespace App\Http\Controllers\Backend\Hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\AdjustTransformer;
use App\Models\Position;
use App\Services\Hrm\AreaService;
use App\Services\InventorySetup\AdjustService;
use App\Transformers\Transformers;
use Illuminate\Validation\ValidationException;

class AreaController extends Controller
{

    /**
     * @var adjustService
     */
    private $systemService;
    /**
     * @var adjustTransformer
     */
    private $systemTransformer;

    /**
     * CategoryController constructor.
     * @param adjustService $systemService
     * @param adjustTransformer $systemTransformer
     */
    public function __construct(AreaService $areaService, Transformers $transformers)
    {
        $this->systemService = $areaService;
        $this->systemTransformer = $transformers;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Area List';
        return view('backend.pages.hrm.area.index', get_defined_vars());
    }

    public function dataProcessing(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Area';
        return view('backend.pages.hrm.area.create', get_defined_vars());
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        try {
            $this->validate($request, $this->systemService->storeValidation($request));
        } catch (ValidationException $e) {
            session()->flash('error', 'Validation error !!');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        $this->systemService->store($request);
        session()->flash('success', 'Data successfully save!!');
        return redirect()->route('hrm.area.index');
    }
    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (!is_numeric($id)) {
            session()->flash('error', 'Edit id must be numeric!!');
            return redirect()->back();
        }
        $editInfo =   $this->systemService->details($id);
        if (!$editInfo) {
            session()->flash('error', 'Edit info is invalid!!');
            return redirect()->back();
        }
        $title = 'Add New Position';
        $model = Position::findOrFail($id);
        return view('backend.pages.hrm.area.edit', get_defined_vars());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if (!is_numeric($id)) {
            session()->flash('error', 'Edit id must be numeric!!');
            return redirect()->back();
        }
        $editInfo = $this->systemService->details($id);
        if (!$editInfo) {
            session()->flash('error', 'Edit info is invalid!!');
            return redirect()->back();
        }
        try {
            $this->validate($request, $this->systemService->updateValidation($request, $id));
        } catch (ValidationException $e) {
            session()->flash('error', 'Validation error !!');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        $this->systemService->update($request, $id);
        session()->flash('success', 'Data successfully updated!!');
        return redirect()->route('hrm.area.index');
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function statusUpdate($id, $status)
    {
        if (!is_numeric($id)) {
            return response()->json($this->systemTransformer->invalidId($id), 200);
        }
        $detailsInfo =   $this->systemService->details($id);
        if (!$detailsInfo) {
            return response()->json($this->systemTransformer->notFound($detailsInfo), 200);
        }
        $statusInfo =  $this->systemService->statusUpdate($id, $status);
        if ($statusInfo) {
            return response()->json($this->systemTransformer->statusUpdate($statusInfo), 200);
        }
    }


    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy($id)
    {
        if (!is_numeric($id)) {
            return response()->json($this->systemTransformer->invalidId($id), 200);
        }
        $detailsInfo =   $this->systemService->details($id);
        if (!$detailsInfo) {
            return response()->json($this->systemTransformer->notFound($detailsInfo), 200);
        }
        $deleteInfo =  $this->systemService->destroy($id);
        if ($deleteInfo) {
            return response()->json($this->systemTransformer->delete($deleteInfo), 200);
        }
    }
}
