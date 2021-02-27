<?php

class C_Api extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    // check sesssion
    $this->checkSession();

    $this->user = $this->session->user;

    $this->load->library('form_validation');
    $this->load->model('CivilArea/M_civilarea');
  }

  /**
   * Check session
   */
  protected function checkSession()
  {
    if (!$this->session->is_logged) {
      response()->json([
        'code' => '401',
        'message' => 'Unauthorized'
      ], 401);
      die;
    }
  }

  /**
   * Get area detail
   * 
   * @param void
   * @return json
   */
  public function getAreaDetail()
  {
    // this can be null or string
    $cost_center = $this->input->get('cost_center');

    try {
      $cost_center_detail = $this->M_civilarea->getCostCenterAreaDetail($cost_center);

      return response()->json([
        'code' => 200,
        'message' => 'Successfully',
        'data' => $cost_center_detail
      ]);
    } catch (Exception $e) {
      return response()->json([
        'code' => '500',
        'message' => 'Internal Server Error'
      ], 500);
    }
  }

  /**
   * to Delete area
   * 
   * @param Void
   * @return json
   */
  public function removeAreaDetail()
  {
    $id = $this->input->post('id');

    try {
      $deleteArea = $this->M_civilarea->deleteAreaDetail($id);

      if (!$deleteArea) throw new Exception("Error");

      return response()->json([
        'code' => 200,
        'message' => 'Successfully remove',
        'data' => []
      ]);
    } catch (Exception $e) {
      return response()->json([
        'code' => '500',
        'message' => 'Internal Server Error'
      ], 500);
    }
  }

  /**
   * To add area data
   * 
   */
  public function addAreaDetail()
  {
    $data = $this->input->post();

    $this->form_validation
      ->set_data($data)
      ->set_rules('cost_center', 'Cost Center', 'required')
      ->set_rules('area', 'Area', 'required')
      ->set_rules('lokasi', 'Lokasi', 'required')
      ->set_rules('gedung', 'Nama Gedung', 'required')
      ->set_rules('lantai', 'Lantai', 'required')
      ->set_rules('luas_area', 'Luas Area', 'required|numeric');

    try {
      if (!$this->form_validation->run()) throw new Exception($this->form_validation->error_string());

      $splittedCostCenter = explode('_', $data['cost_center']);
      $cost_center = $splittedCostCenter[0];
      $branch = $splittedCostCenter[1];

      $current_datetime = date('Y-m-d H:i:s');
      $id = $this->M_civilarea->insertAreaDetail([
        'cost_center' => $cost_center,
        'branch' => $branch,
        'nama_area' => $data['area'],
        'lokasi' => $data['lokasi'],
        'nama_gedung' => $data['gedung'],
        'lantai' => $data['lantai'],
        'luas_area' => $data['luas_area'],
        'created_by' => $this->user,
        'created_at' => $current_datetime
      ]);

      if (!$id) throw new Exception("System error");

      return response()->json([
        'code' => 200,
        'message' => 'Successfully add new area',
        'data' => [
          'id' => $id,
          'created_at' => $current_datetime,
          'created_by' => $this->user,
          'created_by_name' => $this->session->employee
        ]
      ]);
    } catch (Exception $e) {
      return response()->json([
        'code' => '400',
        'message' => $e->getMessage()
      ], 400);
    }
  }

  /**
   * To add area data
   * 
   */
  public function updateAreaDetail()
  {
    $data = $this->input->post();

    $this->form_validation
      ->set_data($data)
      ->set_rules('id', 'Id', 'required')
      ->set_rules('area', 'Area', 'required')
      ->set_rules('lokasi', 'Lokasi', 'required')
      ->set_rules('gedung', 'Nama Gedung', 'required')
      ->set_rules('lantai', 'Lantai', 'required')
      ->set_rules('luas_area', 'Luas Area', 'required|numeric');

    try {
      if (!$this->form_validation->run()) throw new Exception($this->form_validation->error_string());

      $current_datetime = date('Y-m-d H:i:s');
      $update = $this->M_civilarea->updateAreaDetail($data['id'], [
        'nama_area' => $data['area'],
        'lokasi' => $data['lokasi'],
        'nama_gedung' => $data['gedung'],
        'lantai' => $data['lantai'],
        'luas_area' => $data['luas_area'],
        'updated_by' => $this->user,
        'updated_at' => $current_datetime
      ]);

      if (!$update) throw new Exception("System error");

      return response()->json([
        'code' => 200,
        'message' => 'Successfully update area',
        'data' => [
          'updated_by' => $this->user,
          'updated_by_name' => $this->session->employee,
          'updated_at' => $current_datetime
        ]
      ]);
    } catch (Exception $e) {
      return response()->json([
        'code' => '400',
        'message' => $e->getMessage()
      ], 400);
    }
  }
}
