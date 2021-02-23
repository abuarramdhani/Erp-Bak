<?php

class M_civil_monitoring extends CI_Model
{
  protected $table;

  public function __construct()
  {
    parent::__construct();

    $this->load->database();

    $this->table = (object) array(
      'employee' => 'er.er_employee_all',
      'section' => 'er.er_section',
      'order' => 'cvl.cvl_order',
      'order_status' => 'cvl.cvl_order_status',
      'order_jadwal' => 'cvl.cvl_order_jadwal',
      'order_jadwal_detail' => 'cvl.cvl_order_jadwal_detail',
      'order_pekerjaan' => 'cvl.cvl_order_pekerjaan'
    );
  }

  /**
   * Get all orders
   */
  public function getAllOrders()
  {
    $query = $this->db
      ->select("
        co.order_id,
        cos.status_id,
        cos.status,
        cos.status_color,
        (select string_agg(pekerjaan, ',') from cvl.cvl_order_pekerjaan where order_id = co.order_id) as pekerjaan,
        eea.employee_code noind,
        eea.employee_name nama,
        es.section_name seksi,
        co.tgl_order,
        co.tgl_terima,
        co.tgl_dibutuhkan,
        (select tanggal from cvl.cvl_order_jadwal where order_id = co.order_id order by tanggal asc limit 1) tgl_dikerjakan,
        (select count(distinct tanggal) from cvl.cvl_order_jadwal where order_id = co.order_id) jumlah_hari,
        co.tgl_close tgl_selesai
      ")
      ->from($this->table->order . " co")
      ->join($this->table->order_status . " cos", 'co.status_id = cos.status_id')
      ->join($this->table->employee . " eea", 'eea.employee_code = co.pengorder')
      ->join($this->table->section . " es", 'es.section_code = eea.section_code')
      ->order_by('order_id', 'desc');

    return $query->get()->result_object();
  }

  /**
   * Get specific order by order id
   * @param Integer $order_id
   */
  public function getOrder($order_id)
  {
    return $this->db
      ->select('*')
      ->from($this->table->order)
      ->where('order_id', $order_id)
      ->get()
      ->row();
  }

  /**
   * Update status by order id
   */
  public function update_order_status($order_id, $status_id)
  {
    return $this->db
      ->where('order_id', $order_id)
      ->update($this->table->order, [
        'status_id' => $status_id
      ]);
  }

  /**
   * Set close date order
   */
  public function updateCloseDate($order_id, $date, $user)
  {
    return $this->db
      ->where('order_id', $order_id)
      ->update(
        $this->table->order,
        [
          'tgl_close' => $date,
          'closed_by' => $user
        ]
      );
  }

  /**
   * Update tanggal terima by order id
   */
  public function update_acc_date($order_id, $date)
  {
    return $this->db
      ->where('order_id', $order_id)
      ->update($this->table->order, [
        'tgl_terima' => $date
      ]);
  }

  /**
   * Get all schdule date by order id
   */
  public function getSchedule($order_id)
  {
    return $this->db
      ->select("to_char(tanggal, 'YYYY-MM-DD') as start, pekerjaan as title, status")
      ->from($this->table->order_jadwal)
      ->where('order_id', $order_id)
      ->order_by('tanggal', 'asc')
      ->get()
      ->result_object();
  }

  /**
   * Get schedule detail by order id
   */
  public function getScheduleDetail($order_id)
  {
    return $this->db
      ->select("to_char(tanggal, 'YYYY-MM-DD') tanggal, keterangan")
      ->from($this->table->order_jadwal_detail)
      ->where('order_id', $order_id)
      ->order_by('tanggal', 'asc')
      ->get()
      ->result_object();
  }

  /**
   * Remove schedule by order id and date
   */
  public function removeSchedule($order_id, $tanggal)
  {

    $this->db->delete($this->table->order_jadwal_detail, [
      'order_id' => $order_id,
      'tanggal' => $tanggal
    ]);

    $this->db->delete($this->table->order_jadwal, [
      'order_id' => $order_id,
      'tanggal' => $tanggal
    ]);
  }

  /**
   * Update schedule
   * this will remove and insert
   */
  public function updateSchedule($order_id, $status, $tanggal, $jobs)
  {
    $this->removeSchedule($order_id, $tanggal);
    // insert schedule
    $param = [
      'order_id' => $order_id,
      'tanggal' => $tanggal,
      'status' => $status
    ];

    $batch = array_map(function ($job) use ($param) {
      return [
        'order_id' => $param['order_id'],
        'tanggal' => $param['tanggal'],
        'status' => $param['status'],
        'pekerjaan' => $job
      ];
    }, $jobs);

    // is optional return or not
    if (count($batch) > 0) {
      return $this->db
        ->insert_batch($this->table->order_jadwal, $batch);
    } else {
      return true;
    }
  }

  /**
   * Update schedule detail
   * this will update 
   */
  public function updateScheduleDetail($order_id, $tanggal, $keterangan)
  {
    // delete
    $this->db->delete($this->table->order_jadwal_detail, [
      'order_id' => $order_id,
      'tanggal' => $tanggal
    ]);
    // insert
    $this->db->insert($this->table->order_jadwal_detail, [
      'order_id' => $order_id,
      'tanggal' => $tanggal,
      'keterangan' => $keterangan
    ]);
  }
}
