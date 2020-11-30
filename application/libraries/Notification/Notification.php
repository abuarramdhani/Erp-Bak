<?php

namespace Notification;

include APPPATH . "libraries/Notification/Actions/Mutation.php";

use Exception;
use Mutation;

date_default_timezone_set('Asia/Jakarta');

/**
 * Library Api untuk Notifikasi
 * 
 * Api untuk mengelola notifikasi ERP
 * 
 *  
 * @written by DK
 * @date 2020-11-20
 * 
 * TODO :
 * - TESTING
 * - Implement priority
 * - make documentation
 * -
 */
class Notifications
{
  const PRIORITY_LOW = 'low';
  const PRIORITY_MED = 'medium';
  const PRIORITY_HIGH = 'high';
  const PRIORITY_URGENT = 'urgent';

  /**
   * @var Array
   * Variable default 
   */
  // protected $default_notification = array([]);

  /**
   * @var Array
   * variable sementara untuk menyimpan pesan
   */
  protected $message =  [];

  /**
   * @var Array
   * user target to send notification
   */
  protected $users_target = [];

  /**
   * @var String
   * Notification is from ?
   */
  // protected $sender = '';

  /**
   * @var String
   * Batch target
   * menyimpan kodesie mana yg akan dikirim
   */
  protected $section_target = [];

  public function __construct()
  {
    // $this->CI = &get_instance();
    $this->action = new Mutation();
  }

  /**
   * to set variable message
   * 
   * @param String $event_title
   * @param String $event_message
   * @param String $event_priority
   * 
   * @return Notification
   * 
   * TODO:
   * Better use array ?
   */
  public function message($event_title, $event_message, $url, $event_priority = self::PRIORITY_LOW)
  {
    $this->message = [
      'title' => $event_title,
      'message' => $event_message,
      'url' => $url,
      'priority' => $event_priority,
    ];

    return $this;
  }

  /**
   * To send specific no induk
   * Untuk mengatur spesifik target user yang akan dikirimkan notifikasi
   * paramater bisa bertipe array atau noind
   * array example to(['Z0001'])
   * string example to('Z0001')
   * 
   * @param  Mixed        Array|String
   * @return Notification
   */
  public function to($target)
  {
    if (empty($target)) throw new Exception("Target param should be not null");
    $arrayOfUser = $this->users_target;

    if (is_array($target)) {
      $arrayOfUser = array_merge($arrayOfUser, $target);
    } else if (is_string($target)) {
      array_push($arrayOfUser, $target);
    }

    $this->users_target = $arrayOfUser;

    return $this;
  }

  /**
   * To send batch with user section
   * Untuk mengirimkan notifikasi ke semua user dalam seksi
   * 
   * @param  Mixed  String/Array
   * @return Object This
   */
  public function toSection($section_code)
  {
    $arrayOfSection = $this->section_target;
    // send all message
    if (is_string($section_code)) {
      array_push($arrayOfSection, $section_code);
    } else if (is_array($section_code)) {
      $arrayOfSection = array_merge($this->section_target, $section_code);
    } else {
      throw new Exception("Type of section code is not supported, supported is string/array");
    }

    $this->section_target = $arrayOfSection;

    return $this;
  }

  /**
   * To execute send query or insert
   * This is end of chaining method
   * 
   * @param  Void
   * @return Array
   */
  public function send()
  {
    if (empty($this->users_target) && empty($this->section_target)) {
      throw new Exception("Target notification is not yet setted, use ->to() or ->toSection()");
    }

    $data = (object) [
      'message' => $this->message,
      'section_target' => $this->section_target,
      'users_target' => $this->users_target
    ];

    return $this->action->execute($data);
  }
}
