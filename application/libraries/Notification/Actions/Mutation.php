<?php

/**
 * This class is to interaction with model :)
 * TODO: 
 * - Refactor execute method
 * - Simpler life, happier you
 */
class Mutation
{
  const TABLE = 'sys.sys_notification';

  protected $all_target = [];
  protected $all_messageWithUsers = [];

  public function __construct()
  {
    $this->CI = &get_instance();
    // load model
    $this->CI->load->model('Api/Services/Notification/M_notification', 'NotificationModel');
  }

  public function execute($data)
  {
    # code...
    $message = $data->message;

    try {
      if ($data->section_target) {
        $section_users = [];
        foreach ($data->section_target as $kodesie) {
          $getUsersOnSection = $this->CI->NotificationModel->getUsersByKodesie($kodesie);
          $section_users = array_merge($section_users, $getUsersOnSection);
        }

        $this->all_target = array_merge($this->all_target, $section_users);
      }

      if ($data->users_target) {
        $this->all_target = array_merge($this->all_target, $data->users_target);
      }

      $this->all_messageWithUsers = array_map(function ($user) use ($message) {
        $user =  [
          'user' => $user
        ];

        return array_merge($user, $message);
      }, $this->all_target);

      if (count($this->all_target)) {
        $this->CI->NotificationModel->inserBatchNotification($this->all_messageWithUsers);
      }

      // successs
      return [
        'success' => true,
        'sent' => [
          'count' => count($this->all_target),
          'users' => $this->all_target
        ]
      ];
    } catch (Exception $e) {
      // no one user has been sent
      return [
        'success' => false,
        'sent' => [
          'count' => count($this->all_target),
          'users' => $this->all_target
        ],
        'message' => $e->getMessage()
      ];
    }
  }
}
