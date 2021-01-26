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
if (!class_exists('Response')) {
  /**
   * Helper Class
   * Http Response
   */
  class Response
  {
    /**
     * @var Array
     * http response status
     */
    protected $code = array(
      100 => 'Continue',
      200 => 'OK',
      400 => 'Bad Request',
      401 => 'Unauthorized',
      403 => 'Forbidden',
      404 => 'Not Found',
      500 => 'Internal Server Error'
    );

    /**
     * Send Json response
     * @param Mixed
     * @param Integer { Code } | Optional
     */
    public static function json($var, $code = 200)
    {
      header("Content-Type: application/json; charset=utf-8");
      http_response_code($code);
      echo json_encode($var);
    }

    /**
     * Send HTML response
     * @param String { HTML text }
     */
    public static function html($string)
    {
      header("Content-Type: text/html; charset=utf-8");
      http_response_code(200);
      echo $string;
    }
  }

  function response()
  {
    return new Response;
  }
}
