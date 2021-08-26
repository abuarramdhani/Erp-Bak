<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class M_deklarasi extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', true);
    }

    function insDeklarasi($data)
    {
        $this->personalia->insert('hrd_khs.deklarasi_sehat', $data);
        return $this->personalia->affected_rows();
    }

    function getDeklaraibyNoind($noind)
    {
        $sql = "SELECT
					*
				from
					hrd_khs.deklarasi_sehat
				where
					noind = '$noind'
				order by
					waktu_input desc,
					id_deklarasi desc";
        return $this->personalia->query($sql)->result_array();
    }

    function getDeklaraibyID($id)
    {
        $this->personalia->where('id_deklarasi', $id);
        return $this->personalia->get('hrd_khs.deklarasi_sehat')->row_array();
    }

    function updDeklarasi($data, $id)
    {
        $this->personalia->where('id_deklarasi', $id);
        $this->personalia->update('hrd_khs.deklarasi_sehat', $data);
        return $this->personalia->affected_rows();
    }

    function delDeklarasi($id)
    {
        $this->personalia->where('id_deklarasi', $id);
        $this->personalia->delete('hrd_khs.deklarasi_sehat');
        return $this->personalia->affected_rows();
    }

    function getAllPernyataan()
    {
        $sql = "SELECT * FROM hrd_khs.deklarasi_sehat_pertanyaan dsp order by aspek";
        return $this->personalia->query($sql)->result_array();
    }

    function getDetailPKJ($noind)
    {
        $this->personalia->where('noind', $noind);
        return $this->personalia->get('hrd_khs.tpribadi')->row_array();
    }

    function cekNIK($nik)
    {
        $sql = "SELECT * FROM hrd_khs.tpribadi WHERE trim(nik) = '$nik' AND keluar in ('f', '0') limit 1";
        return $this->personalia->query($sql)->row_array();
    }
}
