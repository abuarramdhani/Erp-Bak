<?php
defined('BASEPATH') OR die('No direct script access allowed');

class C_UserData {
  private $ci;

  public function __construct()
  {
    $this->ci = get_instance();
  }

  public function checkLoginSession()
  {
    $this->ci->session->is_logged or redirect();
  }

  public function getUserMenu()
  {    
    $user_id = $this->ci->session->userid;
    $resp_id = $this->ci->session->responsibility_id;

    return (object) [
			'UserMenu' => $this->ci->user->getUserMenu($user_id, $resp_id),
			'UserSubMenuOne' => $this->ci->user->getMenuLv2($user_id, $resp_id),
			'UserSubMenuTwo' => $this->ci->user->getMenuLv3($user_id, $resp_id),
		];
  }
}
