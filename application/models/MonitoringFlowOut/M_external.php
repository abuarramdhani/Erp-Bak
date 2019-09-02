<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_external extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }

    public function createExternal($dataExt)
    {
        return $this->db->insert('mfo.mfo_ext', $dataExt);
    }

    function getExternal()
    {
        $sql = "SELECT * FROM mfo.mfo_ext ORDER BY dater DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function delExternal($id)
    {
        $sql    = "DELETE FROM mfo.mfo_ext WHERE id_ext = '$id'; DELETE FROM mfo.mfo_ext_quality_ins WHERE id_ext = '$id'";
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
        $sql = "SELECT * FROM mfo.mfo_ext WHERE tanggal BETWEEN '$newtxtTglMFO1' AND '$newtxtTglMFO2'
        AND seksi_penanggungjawab = '$slcSeksiFAjx'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getEditInsp($id)
    {
        $sql = "SELECT * FROM mfo.mfo_ext_quality_ins WHERE id_ext = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getAllInsp()
    {
        $sql = "SELECT * FROM mfo.mfo_ext_quality_ins";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getOne($id)
    {
        $sql = "SELECT * FROM mfo.mfo_ext WHERE id_ext = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function updateExternal($id, $dataExt)
    {
        $this->db->where('id_ext', $id);
        $this->db->update('mfo.mfo_ext', $dataExt);
    }

    function insQi($d_date, $realisasi, $pic, $catatan, $id_ext)
    {
        $sql = "INSERT INTO mfo.mfo_ext_quality_ins (d_date, realisasi, pic, catatan, id_ext)
                VALUES ('$d_date', '$realisasi', '$pic', '$catatan', '$id_ext')";
        $this->db->query($sql);
    }
    function updateQi($d_date, $realisasi, $pic, $catatan, $id_ext, $id_uq)
    {
        $sql =  "UPDATE mfo.mfo_ext_quality_ins SET d_date = '$d_date', realisasi = '$realisasi',
        pic = '$pic', catatan = '$catatan', id_ext = '$id_ext' WHERE id = '$id_uq'";
        $this->db->query($sql);
    }
    function delQi($id)
    {
        $sql = "DELETE FROM mfo.mfo_ext_quality_ins WHERE id = '$id'";
        $this->db->query($sql);
    }
    function disBySeksi($monthGraf, $yearGraf) //Grafik
    {
        $sql = "SELECT DISTINCT COUNT(seksi_penanggungjawab) OVER (PARTITION BY seksi_penanggungjawab), seksi_penanggungjawab
        FROM mfo.mfo_ext WHERE EXTRACT(MONTH FROM tanggal) = '$monthGraf' AND EXTRACT(YEAR FROM tanggal) = '$yearGraf'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function getTagihan() //Tagihan CAR External Without Filter
    {
        $sql="SELECT * FROM mfo.mfo_ext WHERE tgl_distr + 6 <= CURRENT_DATE AND upload_car <> '' ORDER BY dater DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function filterCar($newtxtTglMFO1, $newtxtTglMFO2, $slcSeksiFAjx) //Tagihan CAR External With
    {
        $sql = "SELECT * FROM mfo.mfo_ext WHERE tgl_distr + 6 <= CURRENT_DATE AND upload_car <> ''
        AND tanggal BETWEEN '$newtxtTglMFO1' AND '$newtxtTglMFO2' AND seksi_penanggungjawab = '$slcSeksiFAjx' ORDER BY dater DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
