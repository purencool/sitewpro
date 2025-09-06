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

    public function RequestHandler(Request $request)
    {
        $default = $request->all();
        if (!isset($default['request_type'])) {
            return response()->json(['status' => 'error', 'message' => 'No type specified.'], 400);
        }

        if (!isset($default['response_format'])) {
            $default['response_format'] = "json";
        }

        $config = new AppConfiguration();
        switch ($default['request_type']) {
            case 'domains_list':
                $return = $config->getListDomains();
                break;
            default:
                return response()->json(['status' => 'error', 'message' => 'Invalid retype specified.'], 400);
        }

        if ($default['response_format'] === "json") {
            return response()->json($return);
        }
        return $return;
    }
}
