<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_report extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    
    /* --------------- UNTUK LAPORAN 3 --------------- */ 
     
     public function getDetail($id = FALSE)
    {
        if ($id === FALSE) {
            $query = $this->db->get('mo.mo_moulding_scrap');
        }else{
            $query = $this->db->get_where('mo.mo_moulding_scrap', array('moulding_id' => $id));
        }
        return $query->result_array();
    }


    public function getComponent($tanggal1,$tanggal2){
        $query = "SELECT *  FROM mo.mo_moulding WHERE production_date  BETWEEN '$tanggal1' AND '$tanggal2' ORDER BY production_date ASC";
        $hasil = $this->db->query($query);

        return $hasil->result_array();

    }

    public function getPrintCode($id){
        $query = $this->db->get_where('mo.mo_moulding', array('component_code' => $id));
        
        return $query->result_array();
    }

    public function getBongkar($id){
        $query = $this->db->get_where('mo.mo_moulding_bongkar',array('moulding_id' => $id));
        return $query->result_array();        
    }


    // public function getQuantity($kode,$id){
    //     $query = $this->db->get_where('mo.mo_moulding_scrap', array('moulding_id' => $id,'scrap_code' => $kode));
    //     if($query->num_rows() > 0){
    //         return $query->result_array();
    //     }else{
    //         return 0;
    //     }
    // }

}

/* End of file M_qualitycontrol.php */
/* Location: ./application/models/ManufacturingOperation/MainMenu/M_qualitycontrol.php */
/* Generated automatically on 2017-12-20 14:51:22 */