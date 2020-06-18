<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_glap extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getMasterItem($id) // function ngawur! tapi bener hehe => penyelamat
    {
        $query = "SELECT DISTINCT * FROM mo.mo_master_item WHERE kode_barang = '$id' LIMIT 1";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    /* -------------------------------- Useful ----------------------- */
    public function vMoulding($tanggal1, $tanggal2) //View Moulding
    {
        $query = "SELECT mm.moulding_id, 
                        mm.component_description,
                        mm.component_code, 
                        mm.production_date, 
                        mm.moulding_quantity, 
                        mm.print_code, 
                        mm.kode_proses,
                        mm.ket_pengurangan,
                        mm.jam_pengurangan,
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

    public function getDetail($id = FALSE) // Berguna haha
    {
        if ($id === FALSE) {
            $query = $this->db->get('mo.mo_moulding_scrap');
        } else {
            $query = $this->db->get_where('mo.mo_moulding_scrap', array('moulding_id' => $id));
        }
        return $query->result_array();
    }

    public function getAbsensi($tanggal1, $tanggal2) //View Absensi
    {
        
        $sql = "SELECT DISTINCT ma.created_date, ma.no_induk, ma.presensi, ma.kode, ma.lembur,  ma.produksi, ma.nilai_ott
                FROM   mo.mo_absensi ma 
                WHERE  ma.created_date BETWEEN '$tanggal1' AND '$tanggal2'
                ORDER  BY ma.created_date, ma.kode, ma.presensi DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}