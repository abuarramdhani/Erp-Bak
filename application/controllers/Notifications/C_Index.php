<?php

class C_Index extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->auth();
    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('Api/Services/Notification/M_notification', 'NotificationModel');

    $this->user = $this->session->user;
    $this->userid = $this->session->userid;
  }

  public function auth()
  {
    if (!($this->session->is_logged)) {
      redirect('/?redirect=' . current_url());
    }
  }

  public function index()
  {
    // notification length
    $length = 100;
    $allNotifications = $this->NotificationModel->getNotificationByUser($this->user, true, $length);

    $data['Menu'] = 'Laporan';
    $data['SubMenuOne'] = '';
    $data['UserMenu'] = $this->M_user->getUserMenu($this->userid, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->userid, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->userid, $this->session->responsibility_id);

    $data['allNotifications'] = $allNotifications;

    $this->load->view('V_Header', $data);
    $this->load->view('Notifications/V_Index', $data);
    $this->load->view('V_Footer');
  }

  /**
   * To redirect url
   * and set to updated
   */
  public function redirect($id)
  {
    // set to readed
    $id = intval($id);

    $notification = $this->NotificationModel->getNotificationById($id);

    // validation if valid user
    if (!$notification) return show_404();
    if ($notification->user !== $this->user) return show_404();
    if (!$notification->url) return show_404();

    // update set to readed
    if (!$notification->readed_at) {
      $this->NotificationModel->updateNotificationReadedById($notification->user_notification_id);
    }

    return redirect($notification->url);
  }
}
