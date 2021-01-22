<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_masakerja extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->personalia = $this->load->database("personalia", true);
  }

  public function MasaKerja($tanggal, $kodeind)
  {
    $sql = "SELECT p.noind, p.nama,s.seksi, to_char(p.masukkerja, 'DD-MM-YYYY') AS masukkerja,to_char(p.masukkerja, 'YYYY-MM-DD') AS pucek
    FROM hrd_khs.tpribadi p inner join hrd_khs.tseksi s on rtrim(p.kodesie)=rtrim(s.kodesie)
    where p.diangkat > '1900-01-02' and p.keluar = '0' and p.masukkerja < TO_DATE('$tanggal','yyyy-mm-dd') 
    and left(noind, 1) in ($kodeind) 
    ORDER BY noind";

    return $this->personalia->query($sql)->result_array();
  }
}
