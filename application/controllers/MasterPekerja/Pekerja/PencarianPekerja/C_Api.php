<?php

defined("BASEPATH") or die("This script cannot access directly");

setlocale(LC_ALL, 'id_ID.utf8');
date_default_timezone_set('Asia/Jakarta');

/**
 * Ez debugging
 */
function debug($arr)
{
  echo "<pre>";
  print_r($arr);
  die;
}

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
   * @param Any { JSON }
   * @param Integer { Code } | Optional
   */
  public static function json($json, $code = 200)
  {
    header("Content-Type: application/json; charset=utf-8");
    http_response_code($code);
    echo json_encode($json);
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

/**
 * @author /DK/
 * Rest api controller untuk aplikasi master pekerja->pencarian pekerja
 */
class C_Api extends CI_Controller
{
  protected $user_logged;
  protected $table_head_default;
  protected $table_head_jabatan;
  protected $param;

  public function __construct()
  {
    parent::__construct();

    $this->load->library('form_validation');
    $this->load->model('MasterPekerja/Pekerja/PencarianPekerja/M_pencarianpekerja', 'modelPencarian');

    // load another controller
    $this->load->library('../controllers/MasterPekerja/Pekerja/PencarianPekerja/Data_Pencarian');

    $this->table_head_default = $this->data_pencarian->table_head_default; // array
    $this->table_head_jabatan = $this->data_pencarian->table_head_jabatan; // array
    $this->param = $this->data_pencarian->param; // array

    // login first to using this api
    $this->user_logged = $this->session->user;
  }

  /**
   * Api find related worker
   * 
   * @param GET param (column name)
   * @param GET keyword
   */
  public function find()
  {
    // debug($this->C_Index);

    try {
      $get = $this->input->get();
      $keyword = $this->input->get('keyword');
      $param = $this->input->get('param');
      $is_out = $this->input->get('out'); // pekerja aktif (t/f)
      $limit = $this->input->get('limit');

      $validation = $this->form_validation
        ->set_data($get)
        ->set_rules('keyword', 'keyword', 'required')
        ->set_rules('param', 'Param', 'required')
        // ->set_rules('limit', 'limit', 'optional')
        ->set_message('required', 'Error: Field {field} Bad request')
        ->run();

      // check valid param
      if (!$validation) throw new Exception(validation_errors());
      // check valid param on interface
      if (!$this->param[$param]) throw new Exception("Param is not valid");

      $param_type = $this->param[$param]['type'];

      if ($param == 'jabatan') {
        $data = $this->modelPencarian->findWorkerPosition($keyword, $is_out, $limit);
        Response::json(
          array(
            'success' => true,
            'data' => [
              'table_head' => $this->table_head_jabatan,
              'table_body' => $data,
              'table_keys' => count($data) ? array_keys($data[0]) : []
            ]
          )
        );
      } else {
        $data = $this->modelPencarian->findWorker($param, $param_type, $keyword, $is_out, $limit);
        Response::json(
          array(
            'success' => true,
            'data' => [
              'table_head' => $this->table_head_default,
              'table_body' => $data,
              'table_keys' => count($data) ? array_keys($data[0]) : []
            ]
          )
        );
      }
    } catch (Exception $error) {
      Response::json(
        [
          'success' => false,
          'message' => "erorr: " . $error->getMessage()
        ],
        500
      );
    }
  }
}
