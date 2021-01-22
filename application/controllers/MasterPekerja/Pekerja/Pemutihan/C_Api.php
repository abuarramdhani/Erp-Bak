<?php

class C_Api extends CI_Controller
{
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

  public function list_pending_datatable()
  {
    print_r($_GET);
  }

  public function delete_request_session()
  {
    ignore_user_abort();
    $id = $this->input->post('id');

    $this->ModelPemutihan->unsetSessionOfPage($id);

    return json_encode(200);
  }
}
