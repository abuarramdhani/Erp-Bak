<?php

class C_Api extends CI_Controller
{
  const PENDING = 'pending';
  const REVISI = 'revision';
  const REJECT = 'reject';
  const ACCEPT = 'accept';
  const CANCEL = 'cancel';

  public function __construct()
  {
    parent::__construct();

    $this->user = $this->session->user;
    $this->checkSession();
    $this->load->model('MasterPekerja/Pekerja/Pemutihan/M_pemutihan', 'ModelPemutihan');
  }

  private function checkSession()
  {
    if (!$this->session->is_logged) {
      header('Content-Type: application/json');
      http_response_code(401);

      echo json_encode(array(
        'status_code' => 401,
        'message' => 'Unauthorized'
      ));
      die;
    }
  }

  /**
   * Datatable serverside end point
   * @method POST
   * 
   * 
   */
  public function getRequestDatatable()
  {
    # code...
  }

  /**
   * GET All pending
   * 
   */
  public function list_pending_datatable()
  {
    $pending = $this->ModelPemutihan->getAllRequest(self::PENDING);

    return response()->json([
      'data' => $pending
    ]);
  }

  /**
   * Get specific date of list
   * Request with last sync time
   */
  public function get_datatable_new()
  {
    $datetime = $this->input->get('timestamp');

    $datetime = date('c', strtotime($datetime)) ?: false;

    $pending = $this->ModelPemutihan->getPendingAboveTime($datetime);

    return response()->json([
      'data' => $pending
    ]);
  }

  /**
   * To delete session logged on table trequest_pemutihan
   * This cannot cancelable
   */
  public function delete_request_session()
  {
    ignore_user_abort();
    $id = $this->input->post('id');

    $this->ModelPemutihan->unsetSessionOfPage($id);

    return json_encode(200);
  }
}
