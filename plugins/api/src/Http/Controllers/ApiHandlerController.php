<?php

namespace Progmix\Api\Http\Controllers;

use Progmix\Api\Models\Api;
use Progmix\Api\Models\ApiLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Juzaweb\CMS\Http\Controllers\BackendController;

class ApiHandlerController extends BackendController
{
    public function index($any, Request $request)
    {
        $api = Api::find($request->api_id);
        $merged_params = $request->merged_params;
        $attemptId = $request->attempt_id;

        $origin_url = $api->origin_url;
        $params = json_decode($api->params);
        if ($params != null) {
            foreach ($params as $param => $value) {
                if ($value) {
                    $origin_url = str_replace('{' . $param . '}', $value, $origin_url);
                } else {
                    $origin_url = str_replace('{' . $param . '}',  $merged_params[$param], $origin_url);
                }
            }
        }

        $headers = json_decode($api->headers, true);
        $body = json_decode($api->body, true);
        $method = strtolower($api->method);

        $startTime = microtime(true);
        $apiLog = new ApiLog();
        $apiLog->start = now()->format('Y-m-d H:i:s');
        $apiLog->api_id = $api->id;
        $apiLog->attempt_id = $attemptId;
        $apiLog->request = json_encode($api->edge_url);
        $apiLog->response = null;
        $apiLog->type = 'edge/origin';
        $apiLog->ip = $request->ip();
        $apiLog->status_code = null;
        $apiLog->duration = null;
        $apiLog->end = null;
        $apiLog->save();

        if ($method == 'get') {
            $response = Http::$method($origin_url);
        } else {
            $response = Http::withHeaders($headers)->$method($origin_url, $body);
        }

        $apiLog->status_code = $response->status();

        if (floor($apiLog->status_code / 100) == 2) {
            $apiLog->response =  json_encode($response->body());
        } else {
             //the object is the same as returned message
            $apiLog->response = json_encode(['error' => $api->message]);
        }

        $endTime = microtime(true);
        $duration = number_format($endTime - $startTime, 3);

        $apiLog->end =  now()->format('Y-m-d H:i:s');
        $apiLog->duration = $duration;
        $apiLog->save();

        return $response->json();
    }
}
