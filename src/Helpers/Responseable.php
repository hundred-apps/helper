<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;

if (! function_exists('responseable'))
{
    /**
     * @param array $data
     * @param int $status
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    function responseable($data, $status, $message)
    {
        return response()->json([ 'message' => $message ?? Response::$statusTexts[$status] , 'data' => $data, ], $status);
    }
}