<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_internal extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }

    public function createInternal($dataInt)
    {
        return $this->db->insert('mfo.mfo_int', $dataInt);
    }

    function getInternal()
    {
        $sql = "SELECT * FROM mfo.mfo_int ORDER BY dater DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function getInternalLess() //CAR Jatuh Tempo
    {
        $sql = "SELECT * FROM mfo.mfo_int WHERE due_date < current_date AND upload_car <> '' ORDER BY dater DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getInternalbyDate($txtTglMFO1, $txtTglMFO2, $slcSeksiFAjx) //CAR Jatuh Tempo
    {
        $sql = "SELECT * FROM mfo.mfo_int WHERE due_date BETWEEN '$txtTglMFO1' AND '$txtTglMFO2' AND seksi_penanggungjawab = '$slcSeksiFAjx'
        AND upload_car <> '' ORDER BY dater DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function delInternal($id)
    {
        $sql    = "DELETE FROM mfo.mfo_int WHERE id_int = '$id'; DELETE FROM mfo.mfo_int_quality_ins WHERE id_int = '$id'";
        $this->db->query($sql);
    }

    public function getCode($term)
    {
        $sql = "SELECT kjb.JENIS_BARANG, msib.SEGMENT1 item, msib.description
        FROM khs_jenis_barang kjb, mtl_system_items_b msib
        WHERE substr(msib.SEGMENT1,1,3) = kjb.KODE_DIGIT
        AND msib.ORGANIZATION_ID = 81
        AND msib.SEGMENT1 LIKE '%$term%'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getNameType($item)
    {
        $sql = "SELECT kjb.JENIS_BARANG, msib.SEGMENT1 item, msib.description
        FROM khs_jenis_barang kjb, mtl_system_items_b msib
        WHERE substr(msib.SEGMENT1,1,3) = kjb.KODE_DIGIT
        AND msib.ORGANIZATION_ID = 81
        AND msib.SEGMENT1 = '$item'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function sortByDate($newtxtTglMFO1, $newtxtTglMFO2, $slcSeksiFAjx)
    {
        $sql = "SELECT * FROM mfo.mfo_int WHERE tanggal BETWEEN '$newtxtTglMFO1' AND '$newtxtTglMFO2'
        AND seksi_penanggungjawab = '$slcSeksiFAjx'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getEditInsp($id)
    {
        $sql = "SELECT * FROM mfo.mfo_int_quality_ins WHERE id_int = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function getAllInsp()
    {
        $sql = "SELECT * FROM mfo.mfo_int_quality_ins";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getOne($id)
    {
        $sql = "SELECT * FROM mfo.mfo_int WHERE id_int = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function updateInternal($id, $dataInt)
    {
        $this->db->where('id_int', $id);
        $this->db->update('mfo.mfo_int', $dataInt);
    }

    function insQi($d_date, $realisasi, $pic, $catatan, $id_int)
    {
        $sql = "INSERT INTO mfo.mfo_int_quality_ins (d_date, realisasi, pic, catatan, id_int)
                VALUES ('$d_date', '$realisasi', '$pic', '$catatan', '$id_int')";
        $this->db->query($sql);
    }
    function updateQi($d_date, $realisasi, $pic, $catatan, $id_int, $id_uq)
    {
        $sql =  "UPDATE mfo.mfo_int_quality_ins SET d_date = '$d_date', realisasi = '$realisasi', pic = '$pic',
        catatan = '$catatan', id_int = '$id_int' WHERE id = '$id_uq'";
        $this->db->query($sql);
    }
    function delQi($id)
    {
        $sql = "DELETE FROM mfo.mfo_int_quality_ins WHERE id = '$id'";
        $this->db->query($sql);
    }
    function disBySeksi($monthGraf, $yearGraf) // Grafik
    {
        $sql = "SELECT DISTINCT COUNT(seksi_penanggungjawab) OVER (PARTITION BY seksi_penanggungjawab), seksi_penanggungjawab
        FROM mfo.mfo_int WHERE EXTRACT(MONTH FROM tanggal) = '$monthGraf'
        AND EXTRACT(YEAR FROM tanggal) = '$yearGraf'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function getTagihan() // Tagihan Car Internal Without Filter
    {
        $sql = "SELECT * FROM mfo.mfo_int WHERE tgl_distr + 6 <= CURRENT_DATE AND upload_car <> '' ORDER BY dater DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function filterCar($newtxtTglMFO1, $newtxtTglMFO2, $slcSeksiFAjx) // Tagihan Car Internal
    {
        $sql = "SELECT * FROM mfo.mfo_int WHERE tgl_distr + 6 <= CURRENT_DATE AND upload_car <> ''
        AND tanggal BETWEEN '$newtxtTglMFO1' AND '$newtxtTglMFO2'
        AND seksi_penanggungjawab = '$slcSeksiFAjx' ORDER BY dater DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
