<?php

/**
 * Global function to print single variable
 */
if (!function_exists('debug')) {
  function debug($var)
  {
    echo "<pre>";
    print_r($var);
    exit();
  }
}

/**
 * global function of response
 * laravel style
 */
if (!function_exists('response')) {
  function response()
  {
    class Response
    {
    }

    return new Response;
  }
}
