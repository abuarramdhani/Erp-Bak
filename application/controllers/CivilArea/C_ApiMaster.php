<?php

class C_ApiMaster extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    // check sesssion
    $this->checkSession();

    $this->user = $this->session->user;

    $this->load->library('form_validation');
    $this->load->model('CivilArea/M_lantai');
    $this->load->model('CivilArea/M_area');
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
   * Add new Area
   */
  public function addArea()
  {
    $value = $this->input->post('value');

    // check if not exist
    $isExist = $this->M_area->getArea($value); // Object / NULL

    try {
      if ($isExist) throw new Exception("Area is exist");

      // do insert new area
      $execute = $this->M_area->addArea($value);

      return response()->json([
        'code' => '200',
        'message' => 'Ok'
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'code' => '400',
        'message' => $e->getMessage()
      ], 400);
    }
  }

  /**
   * Add new Floor
   */
  public function addFloor()
  {
    $value = $this->input->post('value');

    // check if not exist
    $isExist = $this->M_lantai->getFloor($value); // Object / NULL

    try {
      if ($isExist) throw new Exception("Floor is exist");

      // do insert new area
      $execute = $this->M_lantai->addFloor($value);

      return response()->json([
        'code' => '200',
        'message' => 'Ok'
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'code' => '400',
        'message' => $e->getMessage()
      ], 400);
    }
  }
}
