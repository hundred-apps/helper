<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;

if (! function_exists('requestable'))
{
    /**
     * @return \Illuminate\Http\Request
     */
    function requestable()
    {
        return request();
    }
}