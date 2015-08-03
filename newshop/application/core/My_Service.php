<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Service
{
    public function __construct()
    {
        log_message('debug', "Service Class Initialized");
    }

    public function __get($key)
    {
        $CI = & get_instance();
        return $CI->$key;
    }
}

