<?php

namespace Modules\Crm\Http\Controllers;

use App\Helpers\apiResponse;
use App\Helpers\Component;
use Modules\Crm\Helpers\DataProcessing;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        apiResponse,
        DataProcessing,
        Component;
}
