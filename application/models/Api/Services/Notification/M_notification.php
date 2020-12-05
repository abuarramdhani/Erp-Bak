<?php

class M_notification extends CI_Model
{
  protected $table = 'sys.sys_user_notification';
  protected $timestamp = '';

  public function __construct()
  {
    parent::__construct();
    // set timestamp
    $this->timestamp = date('Y-m-d H:i:s');
    // load database ERP
    $this->load->database();
  }

  /**
   * Get all new notification by user
   * where sended_at is null, this way to sever
   * 
   * @param String $user
   * @param Boolean $is_sent -> apakah ingin mengubah status menjadi terkirim ke user ?
   * @return Array<Object> of notification
   * 
   * TODO: 
   * batasi beberapa notifikasi untuk mengantisipasi jika ada banyak notifikasi
   * selebihnya biar melihat halaman notifikasi aja
   * jadi order by created_at desc limit 10
   * - Pastikan data yg diambil adalah notifikasi baru saat client tsb online
   */
  public function getNewNotificationByUser($user, $is_sent = false)
  {
    $newNotification = $this->db
      ->from($this->table)
      ->where('user', $user)
      ->where('sent_at', null)
      ->order_by('created_at', 'desc')
      ->get()
      ->result_object();

    // if want to set is notification set sent to user
    if ($is_sent) {
      $currentTimestamp = $this->timestamp;

      $arrayOfNotificationSent = array_map(function ($item) use ($currentTimestamp) {
        return [
          'user_notification_id' => $item->user_notification_id,
          'sent_at' => $currentTimestamp
        ];
      }, $newNotification);

      if (count($arrayOfNotificationSent)) {
        $this->db->update_batch($this->table, $arrayOfNotificationSent, 'user_notification_id');
      }
    }

    // splice array to max is 10
    return $newNotification;
  }

  /**
   * Get all notification from table where with 50 first
   * deleted_at is empty
   * 
   * @param String $user
   * @return Array<Object>
   * TODO:
   * Mungkin dikasih juga update data
   */
  public function getNotificationByUser($user, $is_sent = false, $limit = 50)
  {
    # code...
    // get all notification by user
    // where deleted_at is null
    // order by created_at desc
    // 

    $allNotification = $this->db
      ->from($this->table)
      ->where('user', $user)
      ->order_by('created_at', 'desc')
      ->limit($limit)
      ->get()
      ->result_object();

    if ($is_sent) {
      $currentTimestamp = $this->timestamp;

      $arrayOfNotificationSent = array_map(function ($item) use ($currentTimestamp) {
        return [
          'user_notification_id' => $item->user_notification_id,
          'sent_at' => $currentTimestamp
        ];
      }, $allNotification);

      if (count($arrayOfNotificationSent)) {
        $this->db->update_batch($this->table, $arrayOfNotificationSent, 'user_notification_id');
      }
    }

    return $allNotification;
  }

  /**
   * Get notification by id
   * 
   * @param Integet $id
   * @return Object
   */
  public function getNotificationById($id)
  {
    return $this->db
      ->from($this->table)
      ->where('user_notification_id', $id)
      ->get()
      ->row();
  }

  /**
   * Update notification set to readed by id
   * 
   * @param Integer $id
   * @return Object
   */
  public function updateNotificationReadedById($id)
  {
    # code...
    // update readed by id
    return $this->db
      ->where('user_notification_id', $id)
      ->update($this->table, [
        'readed_at' => $this->timestamp
      ]);
  }

  /**
   * Update All notification to readed all by user id
   * 
   * @param String $user
   * @return Object
   */
  public function updateNotificationReadedAll($user)
  {
    # code...
    // $x = select all
    // set readed in $x
    $unread = $this->db
      ->select('user_notification_id')
      ->from($this->table)
      ->where_null('readed_at')
      ->where('user', $user)->result_object();

    // map to set readed_at
    $currentTimestamp = $this->timestamp;
    $arrayOfUnread = array_map(function ($item) use ($currentTimestamp) {
      return [
        'user_notification_id' => $item['user_notification_id'],
        'readed_at' => $currentTimestamp
      ];
    }, $unread);

    // update to table
    // update_batch(Table, Array, Where Key)
    return $this->db
      ->where('user', $user)
      ->update_batch($this->table, $arrayOfUnread, 'id');
  }

  /**
   * Set notification to delete by id
   * 
   * @param Integer $id
   * @return Object
   * 
   */
  public function deleteNotificationById($id)
  {
    # code...
    // update to deleted by id
    return $this->db
      ->where('user_notification_id', $id)
      ->update($this->table, [
        'deleted_at' => $this->timestamp
      ]);
  }

  /**
   * Set notification to all is deleted by user
   */
  public function deleteNotificationAll($user)
  {
    # code...
    // $x = select all 
    // set delete in $x 
    $undeleted = $this->db
      ->select('user_notification_id')
      ->from($this->table)
      ->where_null('readed_at')
      ->where('user', $user)->result_object();

    // map to set deleted_at
    $currentTimestamp = $this->timestamp;
    $arrayOfUndeleted = array_map(function ($item) use ($currentTimestamp) {
      return [
        'user_notification_id' => $item['user_notification_id'],
        'deleted_at' => $currentTimestamp
      ];
    }, $undeleted);

    // update to table
    // update_batch(Table, Array, Where Key)
    return $this->db
      ->where('user', $user)
      ->update_batch($this->table, $arrayOfUndeleted, 'user_notification_id');
  }

  /**
   * Get active erp user where like kodesie
   * @param  String $kodesie Kodesie parameter
   * @return Array  of Noind
   */
  public function getUsersByKodesie($kodesie)
  {
    $employees =  $this->db
      ->select('eea.employee_code')
      ->from('sys.sys_user su')
      ->join('er.er_employee_all eea', 'su.employee_id = eea.employee_id')
      ->where('eea.resign', 0)
      ->like('eea.section_code', $kodesie, 'right')
      ->get()
      ->result_object();

    return array_map(function ($employee) {
      return $employee->employee_code;
    }, $employees);
  }

  /**
   * Insert batch of notification
   * @param Array
   * @return Object
   */
  public function inserBatchNotification($array)
  {
    return $this->db->insert_batch($this->table, $array);
  }
}
