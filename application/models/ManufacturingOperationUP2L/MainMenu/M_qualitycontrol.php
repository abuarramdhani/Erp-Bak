<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_qualitycontrol extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getQualityControl()
    {
        $sql = "SELECT * FROM mo.mo_quality_control ORDER BY checking_date, shift, employee";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getQualityControlbyId($id)
    {
        $sql = "SELECT * FROM mo.mo_quality_control WHERE quality_control_id = '$id' ORDER BY last_updated_date ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getEditQualityControl($id)
    {
        $sql = "SELECT * FROM mo.mo_quality_control WHERE quality_control_id = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getSelep()
    {
        $sql = "SELECT * FROM mo.mo_selep WHERE check_qc = FALSE ORDER BY selep_date, shift, job_id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getQualityControlDetail($id)
    {
        $sql = "SELECT *, (selep_quantity-scrap_quantity) checking_ok FROM mo.mo_selep WHERE selep_id = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function setQualityControl($data)
    {
        return $this->db->insert('mo.mo_quality_control', $data);
    }

    public function updateQualityControl($data, $id)
    {
        $this->db->where('quality_control_id', $id);
        $this->db->update('mo.mo_quality_control', $data);
    }

    public function deleteQualityControl($id, $sid)
    {
        $sql = "DELETE FROM mo.mo_quality_control WHERE quality_control_id = '$id';
                UPDATE mo.mo_selep SET check_qc = FALSE, qc_qty_ok = NULL, qc_qty_not_ok = NULL WHERE selep_id = '$sid';";
        $this->db->query($sql);
    }

    public function selectByDate1($dateQCUp2l)
    {
        $sql = "SELECT * FROM mo.mo_selep WHERE selep_date = '$dateQCUp2l' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function selectByDate2($dateQCUp2l)
    {
        $sql = "SELECT * FROM mo.mo_quality_control WHERE checking_date = '$dateQCUp2l' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /* --------------- UNTUK LAPORAN 1 --------------- */
    public function getDetail($id = FALSE)
    {
        if ($id === FALSE) {
            $query = $this->db->get('mo.mo_moulding_scrap');
        } else {
            $query = $this->db->get_where('mo.mo_moulding_scrap', array('moulding_id' => $id));
        }
        return $query->result_array();
    }

    public function getComponent($tanggal1, $tanggal2)
    {
        $query = "SELECT DISTINCT component_code,component_description FROM mo.mo_moulding WHERE production_date  BETWEEN '$tanggal1' AND '$tanggal2'";
        $hasil = $this->db->query($query);
        return $hasil->result_array();
    }

    public function getPrintCode($id)
    {
        $query = $this->db->get_where('mo.mo_moulding', array('component_code' => $id));
        return $query->result_array();
    }

    public function getBongkar($id)
    {
        $query = $this->db->get_where('mo.mo_moulding_bongkar', array('moulding_id' => $id));
        return $query->result_array();
    }

    public function getScrap($id)
    {
        $query = $this->db->get_where('mo.mo_moulding_scrap', array('moulding_id' => $id));
        return $query->result_array();
    }


    /*-------------------------- UNTUK LAPORAN 2 ----------------------------- */
    public function get4CharComp()
    {
        $query = "SELECT DISTINCT LEFT(component_code,4) component_code FROM mo.mo_moulding";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getComponentWhere($id, $tanggal1, $tanggal2)
    {
        $query = "SELECT * FROM mo.mo_moulding WHERE LEFT(component_code,4) LIKE '%" . $id . "%' AND production_date BETWEEN '$tanggal1'  AND '$tanggal2' ";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getMasterItem($id) // function ngawur!
    {
        $query = "SELECT DISTINCT * FROM mo.mo_master_item WHERE kode_barang = '$id' LIMIT 1";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getBongkarWhere($id)
    {
        $query = "SELECT DISTINCT * FROM mo.mo_moulding_bongkar WHERE moulding_id = '" . $id . "' LIMIT 1";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return 0;
        }
    }

    /* ------------------------ LAPORAN 3 n 4 ------------------------ */
    public function getComponentThis($tanggal1, $tanggal2)
    {
        $query = "SELECT *  FROM mo.mo_moulding WHERE production_date  BETWEEN '$tanggal1' AND '$tanggal2' ORDER BY production_date ASC";
        $hasil = $this->db->query($query);
        return $hasil->result_array();
    }

    public function getQtyRejectQC($where)
    {
        $query = "SELECT SUM(scrap_quantity) scrap_quantity FROM mo.mo_quality_control WHERE print_code = '$where' GROUP BY print_code";
        $hasil = $this->db->query($query);
        if ($hasil->num_rows() > 0) {
            return $hasil->result_array();
        } else {
            return 0;
        }
    }

    /* -------------------------------- LAPORAN 4 ----------------------- */
    public function vMoulding($tanggal1, $tanggal2) //View Moulding
    {
        $query = "SELECT mm.moulding_id, 
                        mm.component_code, 
                        mm.production_date, 
                        mm.moulding_quantity, 
                        mm.print_code, 
                        (SELECT sum(ms.quantity) 
                        FROM   mo.mo_moulding_scrap ms 
                        WHERE  ms.moulding_id = mm.moulding_id) scrap_qty, 
                        (SELECT sum(mb.qty) 
                        FROM   mo.mo_moulding_bongkar mb 
                        WHERE  mb.moulding_id = mm.moulding_id) bongkar_qty,
                        ma.kode
                FROM   mo.mo_moulding mm, mo.mo_absensi ma
                WHERE mm.production_date  BETWEEN '$tanggal1' AND '$tanggal2'
                and ma.category_produksi = 'Moulding'
                and ma.id_produksi = mm.moulding_id
                GROUP  BY mm.moulding_id, 
                        mm.moulding_quantity, 
                        mm.component_code, 
                        mm.production_date, 
                        ma.kode
                ORDER  BY mm.production_date, ma.kode";
        $hasil = $this->db->query($query);
        return $hasil->result_array();
    }

    public function vMixing($tanggal1, $tanggal2) //View Mixing
    {
        $sql = "SELECT mm.*, ma.kode FROM mo.mo_mixing mm, mo.mo_absensi ma
                WHERE production_date BETWEEN '$tanggal1' AND '$tanggal2'
                and ma.id_produksi = mm.mixing_id
                and ma.category_produksi = 'Mixing'
                GROUP BY mm.mixing_id, ma.kode
                ORDER BY mm.production_date, ma.kode";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function vCore($tanggal1, $tanggal2) //View Core
    {
        $sql = "SELECT mm.*, ma.kode FROM mo.mo_core mm, mo.mo_absensi ma
                WHERE production_date BETWEEN '$tanggal1' AND '$tanggal2'
                and ma.id_produksi = mm.core_id
                and ma.category_produksi = 'Core'
                GROUP BY mm.core_id, ma.kode
                ORDER BY mm.production_date, ma.kode";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function vOTT($tanggal1, $tanggal2) //View OTT
    {
        $sql = "SELECT * FROM mo.mo_ott
                WHERE otttgl BETWEEN '$tanggal1' AND '$tanggal2'
                ORDER BY otttgl, kode";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /* -------------------------------- LAPORAN 5 ----------------------- */
    public function getAbsensi($tanggal1, $tanggal2)
    {
        
        $sql = "SELECT DISTINCT ma.created_date, ma.no_induk, ma.presensi, ma.kode, ma.lembur,  ma.produksi, ma.nilai_ott
                FROM   mo.mo_absensi ma 
                WHERE  ma.created_date BETWEEN '$tanggal1' AND '$tanggal2'
                ORDER  BY ma.created_date, ma.kode, ma.presensi DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function update_qty_qc($qty, $id)
    {
        $sql = "UPDATE mo.mo_selep SET qc_qty_ok = '$qty' WHERE selep_id = '$id';";
        $this->db->query($sql);
    }
}