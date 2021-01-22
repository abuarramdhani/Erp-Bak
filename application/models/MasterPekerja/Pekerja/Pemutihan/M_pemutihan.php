<?php

class M_pemutihan extends CI_Model
{
  public function __construct()
  {
    parent::__construct();

    $this->personalia = $this->load->database('personalia', true);
  }

  /**
   * Get all request with param or not
   * 
   * @param String $status
   * @return Array<Object>
   */
  public function getAllRequest($status = false)
  {
    $getAll = $this->personalia
      ->select('
        trp.created_at,
        trp.id_req,
        trp.noind,
        tp.nama,
        ts.seksi,
        tlk.lokasi_kerja,
        trp.status_update_by,
        trp.status_req,
        trp.status_update_at,
        trp.feedback,
        trp.distributed_at
      ')
      ->from('hrd_khs.trequest_tpribadi trp')
      ->join('hrd_khs.tpribadi tp', 'tp.noind = trp.noind', 'inner')
      ->join('hrd_khs.tlokasi_kerja tlk', 'tlk.id_ = tp.lokasi_kerja', 'inner')
      ->join('hrd_khs.tseksi ts', 'ts.kodesie = tp.kodesie', 'inner')
      ->order_by('created_at', 'desc');

    if ($status) {
      $getAll->where('status_req', $status);
    }

    return $getAll->get()
      ->result_object();
  }

  /**
   * Get data by id 
   * 
   * @param Integer $id
   * @return Object
   */
  public function getDataById($id)
  {
    return $this->personalia
      ->select()
      ->from('hrd_khs.trequest_tpribadi trp')
      ->where('id_req', $id)
      ->get()
      ->row();
  }

  /**
   * Get request family by id
   * 
   * @param Integer $id
   * @return Array<Object>
   */
  public function getFamilyByPribadiId($id)
  {
    return $this->personalia
      ->select('trtk.*, tmk.jenisanggota')
      ->from('hrd_khs.trequest_tkeluarga trtk')
      ->join('hrd_khs.tmasterkel tmk', 'tmk.nokel = trtk.nokel', 'left')
      ->where('id_trequest_tpribadi', $id)
      ->get()
      ->result_object();
  }

  /**
   * Get data pribadi tabel tpribadi by noind
   * 
   * @param String $noind  Noind pekerja
   * @return Object Object dengan isi kolom
   */
  public function getPribadiByNoind($noind)
  {
    return $this->personalia
      ->select('tp.*, ts.seksi')
      ->from('hrd_khs.tpribadi tp')
      ->join('hrd_khs.tseksi ts', 'ts.kodesie = tp.kodesie')
      ->where('noind', $noind)
      ->get()
      ->row();
  }

  /**
   * :TODO
   * :Please check this
   */
  public function updateStatus($id, $status)
  {
    return $this->personalia
      ->where('id_req', $id)
      ->update('hrd_khs.trequest_tpribadi', []);
  }

  /**
   * set session user who access request
   * 
   * @param Integer $id
   * @param String  $noind
   */
  public function setSessionOfPage($id, $noind)
  {
    return $this->personalia
      ->where('id_req', $id)
      ->update('hrd_khs.trequest_tpribadi', [
        'current_session' => $noind
      ]);
  }

  /**
   * Unset last session user who access request
   * 
   * @param Integer $id
   */
  public function unsetSessionOfPage($id)
  {
    return $this->personalia
      ->where('id_req', $id)
      ->update('hrd_khs.trequest_tpribadi', [
        'current_session' => null
      ]);
  }

  /**
   * Update verify check, ok or nor
   * 
   * @param Integer $id
   * @param String  $field
   * 
   * @return Object
   */
  public function updateVerifyCheck($id, $field)
  {
    return $this->personalia
      ->where('id_req', $id)
      ->update('hrd_khs.trequest_tpribadi', $field);
  }
}
