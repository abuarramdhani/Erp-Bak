<?php

class M_car extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->personalia = $this->load->database('personalia', true);

    $this->open_status = CAR_STATUS::OPEN;
  }

  /**
   * 
   * @param Int $id_kecelakaan
   * @return Array<Object>
   */
  public function getCarByIdKecelakaan($id_kecelakaan)
  {
    $cars = $this->db
      ->select("
        k3kkc.*,
        emp.employee_name nama_pic,
        (
          select count(*) from k3.k3k_kecelakaan_car_approval_history 
          where 
            approval_status = '$this->open_status'
            and kecelakaan_car_id = k3kkc.kecelakaan_car_id
        ) open_status_count
      ")
      ->where('id_kecelakaan', $id_kecelakaan)
      ->where('k3kkc.sub_revisi_kecelakaan_car_id', null)
      ->from('k3.k3k_kecelakaan_car k3kkc')
      ->join('er.er_employee_all emp', 'emp.employee_code = k3kkc.noind_pic')
      ->order_by('kecelakaan_car_id')
      ->get()
      ->result_object();

    // map array and find their revisi
    $cars = array_map(function ($item) {
      $item->revisi = $this->getCarRevisiById($item->kecelakaan_car_id);
      return $item;
    }, $cars);

    return $cars;
  }

  /**
   * 
   * @param Int $id_car
   */
  public function getCarById($id_car)
  {
    return $this->db
      ->select('*')
      ->from('k3.k3k_kecelakaan_car')
      ->where('kecelakaan_car_id', $id_car)
      ->get()
      ->row();
  }

  /**
   * 
   * @param Int $id_car
   * @return Array<Object>
   */
  public function getCarRevisiById($id_car)
  {
    return $this->db
      ->select("
        k3kkc.*,
        emp.employee_name nama_pic,
        (
          select count(*) from k3.k3k_kecelakaan_car_approval_history 
          where 
            approval_status = '$this->open_status'
            and kecelakaan_car_id = k3kkc.kecelakaan_car_id
        ) open_status_count
      ")
      ->where('k3kkc.sub_revisi_kecelakaan_car_id', $id_car)
      ->from('k3.k3k_kecelakaan_car k3kkc')
      ->join('er.er_employee_all emp', 'emp.employee_code = k3kkc.noind_pic')
      ->order_by('kecelakaan_car_id')
      ->get()
      ->result_object();
  }

  /**
   * @param Array $data
   * @return Object of Query builder
   */
  public function insertBatchCar($data)
  {
    return $this->db->insert_batch('k3.k3k_kecelakaan_car', $data);
  }

  /**
   * @param Array $cars
   * @return Boolean
   */
  public function updateOrInsertBatchCar($cars)
  {
    try {
      foreach ($cars as $car) {
        if (isset($car['kecelakaan_car_id']) && !empty($car['kecelakaan_car_id'])) {
          // update
          $this->db
            ->update('k3.k3k_kecelakaan_car', $car, [
              'kecelakaan_car_id' => $car['kecelakaan_car_id']
            ]);
        } else {
          unset($car['kecelakaan_car_id']);
          $this->db
            ->insert('k3.k3k_kecelakaan_car', $car);
          // insert riwayat
          $insertedCarId = $this->db->insert_id();
          $this->insertCarApprovalHistory($insertedCarId, $car['approval_status'], $car['created_by'], null);
        }
      }
      return true;
    } catch (Exception $e) {
      return false;
    }
  }

  /**
   * Approval oleh Unit
   * 
   * @param Int    $id_kecelakaan
   * @param String $approval_status CAR_STATUS::<String>
   * @param String $user
   * @return Boolean
   */
  public function approvalUnitCar($id_kecelakaan, $approval_status, $user)
  {
    // get all id will approved
    $id_will_approved = $this->db
      ->select('kecelakaan_car_id')
      ->where('approval_status', CAR_STATUS::PROCESS)
      ->where('id_kecelakaan', $id_kecelakaan)
      ->get('k3.k3k_kecelakaan_car')
      ->result_object();

    // update to verified
    $this->db
      ->set('approval_status', $approval_status)
      ->where('id_kecelakaan', $id_kecelakaan)
      ->where('approval_status', CAR_STATUS::PROCESS)
      ->update('k3.k3k_kecelakaan_car');

    // update to k3k.kecelakaan_kerja
    $this->updateCarHasBeenApprovedByUnit($id_kecelakaan);

    // insert to all car history
    foreach ($id_will_approved as $id) {
      $this->insertCarApprovalHistory($id->kecelakaan_car_id, $approval_status, $user, null);
    }

    return true;
  }

  /**
   * 
   * @param Int $id_car
   * @param String $approval_status CAR_STATUS::<String>
   * @param String $approval_by
   * @param String $notes
   * @return Object
   */
  public function insertCarApprovalHistory($id_car, $approval_status, $approval_by, $notes)
  {
    return $this->db
      ->insert('k3.k3k_kecelakaan_car_approval_history', [
        'kecelakaan_car_id' => $id_car,
        'approval_status' => $approval_status,
        'approval_by' => $approval_by,
        'catatan' => $notes
      ]);
  }

  /**
   * Get car history by car id
   * 
   * @param Int $id_car
   * @return Array<Object>
   */
  public function getApprovalHistoryById($id_car)
  {
    return $this->db
      ->select('
        kcah.*,
        eea.employee_name
      ')
      ->from('k3.k3k_kecelakaan_car_approval_history kcah')
      ->join('er.er_employee_all eea', 'eea.employee_code = kcah.approval_by')
      ->where('kcah.kecelakaan_car_id', $id_car)
      ->order_by('kcah.kecelakaan_car_approval_history_id')
      ->get()
      ->result_object();
  }

  /**
   * 
   * @param Int $id_kecelakaan
   * @param String $approval_status CAR_STATUS::<String>
   * 
   * @return Object
   */
  public function getLastApproval($id_kecelakaan, $approval_status)
  {
    return $this->db
      ->select("
        k3kkcah.approval_status,
        k3kkcah.approval_by || ' - ' ||  eea.employee_name as approval_by,
        k3kkcah.created_at
      ")
      ->from('k3.k3k_kecelakaan_car k3kkc')
      ->join('k3.k3k_kecelakaan_car_approval_history k3kkcah', 'k3kkcah.kecelakaan_car_id = k3kkc.kecelakaan_car_id')
      ->join('er.er_employee_all eea', 'eea.employee_code = k3kkcah.approval_by', 'left')
      ->where('k3kkc.id_kecelakaan', $id_kecelakaan)
      ->where('k3kkcah.approval_status', $approval_status)
      ->order_by('k3kkcah.created_at', 'desc')
      ->limit(1)
      ->get()
      ->row();
  }

  /**
   * Get the number status history who have approval status is $approval_status
   * 
   * @param Int $id_car
   * @param String $approval_status CAR_STATUS::<String>
   * 
   * @return Int
   */
  public function getAmountOfStatusHistory($id_car, $approval_status)
  {
    return $this->db
      ->from('k3.k3k_kecelakaan_car_approval_history')
      ->where('kecelakaan_car_id', $id_car)
      ->where('approval_status', $approval_status)
      ->get()
      ->num_rows();
  }

  /**
   * Approval oleh TIM
   * 
   * @param Int $id_car
   * @param String $approval_by
   * @param String $approval_status CAR_STATUS::<String>
   * 
   * @return Void
   */
  public function approvalTimCar($id_car, $approval_by, $approval_status, $FuncIsAllCarIsClosed)
  {
    // update car with id
    $this->db
      ->set('approval_status', $approval_status)
      ->where('kecelakaan_car_id', $id_car)
      ->update('k3.k3k_kecelakaan_car');

    // :TODO
    // test this

    // get id kecelakaan
    $car = $this->getCarById($id_car);

    // undefined safety
    if ($car) {
      $id_kecelakaan = $car->id_kecelakaan;
      // Select all car
      $cars = $this->getCarByIdKecelakaan($id_kecelakaan);

      //untuk cek apakah semua car sudah closed, @see C_Car->isAllCarIsClosed()
      $isAllCarClosed = $FuncIsAllCarIsClosed($cars);

      // if all car is closed
      if ($isAllCarClosed) {
        // case 1: jika semua sudah closed, maka call $this->updateCarHasBeenApprovedByTim()
        $this->updateCarHasBeenApprovedByTim($id_kecelakaan);
      }

      // if $approval_status is revisi
      if ($approval_status == CAR_STATUS::REVISI) {
        // case 2: jika ada yang revisi / status revisi, maka update ke tabel k3k.kecelakaan_kerja column is_car_tim_approved = false, is_car_unit_approved = false
        $this->updateCarHasBeenRevisedByTim($id_kecelakaan);
      }
    }

    // insert car history
    $this->insertCarApprovalHistory($id_car, $approval_status, $approval_by, null);
  }

  /**
   * 
   * @param Int $id_kecelakaan
   * @return Object
   */
  public function updateCarIfHasBeenCreated($id_kecelakaan)
  {
    return $this->db
      ->update('k3.k3k_kecelakaan', [
        'car_is_created' => true
      ], [
        'id_kecelakaan' => $id_kecelakaan
      ]);
  }

  /**
   * not yet used
   */
  public function updateCarHasBeenApprovedByUnit($id_kecelakaan)
  {
    return $this->db
      ->update('k3.k3k_kecelakaan', [
        'car_unit_is_approved' => true
      ], [
        'id_kecelakaan' => $id_kecelakaan
      ]);
  }

  /**
   * not yet used
   */
  public function updateCarHasBeenApprovedByTim($id_kecelakaan)
  {
    return $this->db
      ->update('k3.k3k_kecelakaan', [
        'car_tim_is_approved' => true
      ], [
        'id_kecelakaan' => $id_kecelakaan
      ]);
  }

  /**
   * not yet used
   */
  public function updateCarHasBeenRevisedByTim($id_kecelakaan)
  {
    return $this->db
      ->update('k3.k3k_kecelakaan', [
        'car_tim_is_approved' => false,
        'car_unit_is_approved' => false,
      ], [
        'id_kecelakaan' => $id_kecelakaan
      ]);
  }

  /**
   * 
   * 
   * @param Int $id_car
   * @param String $notes
   * @return Object
   */
  public function updateNotes($id_car, $notes)
  {
    return $this->db
      ->update('k3.k3k_kecelakaan_car', [
        'notes' => $notes
      ], [
        'kecelakaan_car_id' => $id_car
      ]);
  }

  /**
   * 
   * @param String $keyword
   * @return Object of Employee
   */
  public function getEmployeePIC($keyword = false)
  {
    $keyword = strtolower($keyword);

    return $this->personalia
      ->select('
        noind,
        nama
      ')
      ->from('hrd_khs.tpribadi')
      ->group_start()
      ->like('lower(nama)', $keyword, 'both')
      ->or_like('lower(noind)', $keyword, 'both')
      ->group_end()
      ->where('keluar', false)
      ->limit(50)
      ->get()
      ->result_object();
  }
}
