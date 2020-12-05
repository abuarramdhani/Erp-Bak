<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Notification services
 * 
 * This user depend on session
 * 
 */

class C_Index extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->library('Notification');

    $this->auth();

    $this->load->model('Api/Services/Notification/M_notification', 'NotificationModel');
    $this->user = $this->session->user;
  }

  /**
   * This is for middleware :v
   * before access this api
   * user is must authorize
   */
  protected function auth()
  {
    if ($this->session->is_logged != true) {
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'code' => '401',
          'info' => "Non Authorized",
          'message' => "Please signin first !"
        ]))
        ->_display();
      exit();
    }
  }

  /**
   * To get all notification
   * 
   * @method POST
   * @url /api/services/notification
   */
  public function index()
  {
    // is it from client ?
    // this will mark if the new notifiction has been sent to client -> status will updated to sent
    $client = ($this->input->post('client') == 1);
    $data = $this->NotificationModel->getNotificationByUser($this->user, $client);
    // header('Content-Type: application/json');
    // echo json_encode($data);
    // die;
    return $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(json_encode($data));
  }

  /**
   * Get new notification on this session
   * @method POST
   * @url /api/services/notification/new
   */
  public function newNotification()
  {
    // is it from client ?
    // this will mark if the new notifiction has been sent to client -> status will updated to sent
    $client = ($this->input->post('client') == 1);

    $data = $this->NotificationModel->getNewNotificationByUser($this->user, $client);
    // header('Content-Type: application/json');
    // echo json_encode($data);
    // die;
    return $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(json_encode($data));
  }

  /**
   * Get all notification
   * @method POST
   * @url /api/services/notification/all
   */
  public function allNotification()
  {
    $data = $this->NotificationModel->getNotificationByUser($this->user);

    return $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(json_encode($data));
  }

  /**
   * To set notification is readed
   * @url /api/services/notification/read
   * @method POST
   * 
   */
  public function setRead()
  {
    // maybe use encryption is good
    try {
      $id = $this->input->post('id');
      $execute = $this->NotificationModel->updateNotificationReadedById($id);
      if (!$execute) throw new Exception("Something was happen");
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode([
          'success' => true,
          'message' => "Successfully"
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
   * To set all notification that is readed by user
   * @method POST
   * @url /api/services/notification/read/all
   * 
   */
  public function setReadAll()
  {
    try {
      $execute = $this->NotificationModel->updateNotificationReadedAll($this->user);
      if (!$execute) throw new Exception("Something was happen");
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(400)
        ->set_output(json_encode([
          'code' => 400,
          'success' => false,
          'message' => "Successfully"
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
   * To notification status is deleted
   * @method POST
   * @url /api/services/notification/delete
   * 
   */
  public function setDelete()
  {
    try {

      $id = $this->input->post('id');
      $execute = $this->NotificationModel->deleteNotificationById($id);

      if (!$execute) throw new Exception("Something was happen");

      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(400)
        ->set_output(json_encode([
          'code' => 400,
          'success' => false,
          'message' => "Successfully"
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
   * To set all notification is deleted
   * @method POST
   * @url /api/services/notification/delete/all
   */
  public function setDeleteAll()
  {
    try {
      $execute = $this->NotificationModel->deleteNotificationAll($this->user);
      if (!$execute) throw new Exception("Something was happen");
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(400)
        ->set_output(json_encode([
          'code' => 400,
          'success' => false,
          'message' => "Successfully"
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
   * For debugging on production >:)
   */
  public function check()
  {
    $to = $this->input->post('to');
    $message = $this->input->post('message');
    $title = $this->input->post('title');
    $url = $this->input->post('url');

    $send = Notification::make()
      ->message($title, $message, $url)
      ->to($to)
      ->send();

    echo $send ? "OK" : "Not OK";
  }
}
