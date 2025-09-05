<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Services\AppConfigurationCreators\AppConfiguration;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function RequestHandler($default = [] )
    {
        $config = new AppConfiguration();
        if (!empty($default)) {
            return $config->getListDomains();
        }
        return response()->json($config->getListDomains());
    }
}
