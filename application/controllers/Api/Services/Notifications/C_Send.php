<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * To Send notification on ERP
 * 
 */

class C_Send extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->library('Notification');
  }

  /**
   * Send request using API
   * single user
   * 
   */
  public function send()
  {
    $to = $this->input->post('to');
    $title = $this->input->post('title');
    $message = $this->input->post('message');
    $url_referer = $this->input->post('referer');

    $validation = $this->form_validation
      ->set_data($this->input->post())
      ->set_rules('title', 'title', 'required')
      ->set_rules('message', 'message', 'required')
      ->set_error_delimiters('', '');
      
     if (is_array($to)) {
      $validation
        ->set_rules('to[]', 'to', 'required');
    } else {
      $validation
        ->set_rules('to', 'to', 'required');
    }

    if (is_array($to)) {
      $validation->set_rules('to[]', 'to', 'required');
    } else {
      $validation->set_rules('to', 'to', 'required');
    }

    try {
      if ($this->form_validation->run() === false) throw new Exception($this->form_validation->error_string());

      $send = Notification::make()
        ->message($title, $message, $url_referer)
        ->to($to) // destination
        ->send(); // execute

      if (!$send['success']) throw new Exception("Failed to send");

      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode([
          'code' => 200,
          'success' => true,
          'message' => 'success'
        ]));
    } catch (Exception $e) {
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(400)
        ->set_output(json_encode([
          'code' => 400,
          'success' => false,
          'message' => $e->getMessage()
        ]));
    }
  }

  /**
   * Send request using API
   * multiple user on section
   * 
   */
  public function section()
  {
    $to = $this->input->post('to');
    $title = $this->input->post('title');
    $message = $this->input->post('message');
    $url_referer = $this->input->post('referer');

    $this->form_validation
      ->set_data($this->input->post())
      ->set_rules('to', 'to', 'required')
      ->set_rules('title', 'title', 'required')
      ->set_rules('message', 'message', 'required')
      ->set_error_delimiters('', '');

    try {
      if ($this->form_validation->run() === false) throw new Exception($this->form_validation->error_string());

      $send = Notification::make()
        ->message($title, $message, $url_referer)
        ->toSection($to) // destination
        ->send(); // execute

      if (!$send['success']) throw new Exception("Failed to send");

      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode([
          'code' => 200,
          'success' => false,
          'message' => 'success'
        ]));
    } catch (Exception $e) {
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(400)
        ->set_output(json_encode([
          'code' => 400,
          'success' => false,
          'message' => $e->getMessage()
        ]));
    }
  }
}
