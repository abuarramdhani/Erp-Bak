<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class M_tukarshiftdanabsenhariini extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->personalia = $this->load->database('personalia', TRUE);
  }

  public function GetDataShiftAbsen()
  {
    $sql = "select a.noind1 as noind,b.nama,c.seksi,b.tempat_makan,'Tukar Shift' as jenis,
      concat('Tukar: ',trim(a.shift1),' => ',trim(a.shift2)) as alasan,a.appr_,a.approve_timestamp
      from \"Presensi\".tinput_tukar_shift a 
      inner join hrd_khs.tpribadi b 
      on a.noind1 = b.noind
      inner join hrd_khs.tseksi c 
      on b.kodesie = c.kodesie
      where trim(a.noind1) != ''
      and a.status = '02'
      and (
        a.tanggal1 = current_date 
        or a.tanggal2 = current_date
      ) and a.approve_timestamp::date = current_date
      union 
      select a.noind2,b.nama,c.seksi,b.tempat_makan,'Tukar Shift' as jenis,
        concat('Tukar: ',trim(a.shift2),' => ',trim(a.shift1)) as alasan,
        a.appr_,a.approve_timestamp
      from \"Presensi\".tinput_tukar_shift a 
      inner join hrd_khs.tpribadi b 
      on a.noind2 = b.noind
      inner join hrd_khs.tseksi c 
      on b.kodesie = c.kodesie
      where trim(a.noind2) != ''
      and a.status = '02'	
      and (
        a.tanggal1 = current_date 
        or a.tanggal2 = current_date
      ) 
      and a.approve_timestamp::date = current_date			
      union				
      select a.noind,b.nama,c.seksi,b.tempat_makan,'Absen Manual' as jenis,a.ket,a.appr_,a.approve_timestamp
      from \"Presensi\".tinput_presensi_manual a 
      inner join hrd_khs.tpribadi b 
      on a.noind = b.noind
      inner join hrd_khs.tseksi c 
      on b.kodesie = c.kodesie
      where a.status = '02'
      and a.tanggal = current_date  
      and a.approve_timestamp::date = current_date 
      order by approve_timestamp desc  ";
    return $this->personalia->query($sql)->result_array();
  }
}
