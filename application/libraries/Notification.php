<?php

require_once(APPPATH . "libraries/Notification/Notification.php");

class Notification extends \Notification\Notifications
{
  public function __construct()
  {
    parent::__construct();
  }

  static function make()
  {
    return new \Notification\Notifications;
  }
}
