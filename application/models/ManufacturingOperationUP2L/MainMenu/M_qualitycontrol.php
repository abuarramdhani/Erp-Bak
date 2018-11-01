<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_qualitycontrol extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getQualityControl($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('mo.mo_quality_control');
    	} else {
    		$query = $this->db->get_where('mo.mo_quality_control', array('quality_control_id' => $id));
    	}

    	return $query->result_array();
    }

    public function getQualityControlDetail($id)
    {
        $query = $this->db->get_where('mo.mo_moulding', array('moulding_id' => $id));

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

    public function deleteQualityControl($id)
    {
        $this->db->where('quality_control_id', $id);
        $this->db->delete('mo.mo_quality_control');
    }


    
    /* --------------- UNTUK LAPORAN 1 --------------- */ 

    public function getDetail($id = FALSE)
    {
        if ($id === FALSE && $kode === FALSE) {
            $query = $this->db->get('mo.mo_moulding_scrap');
        }else{
            $query = $this->db->get_where('mo.mo_moulding_scrap', array('moulding_id' => $id));
        }

        return $query->result_array();

        
    }

    public function getComponent($tanggal1,$tanggal2){
        $query = "SELECT DISTINCT component_code,component_description  FROM mo.mo_moulding WHERE production_date  BETWEEN '$tanggal1' AND '$tanggal2'";
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

    /*-------------------------- UNTUK LAPORAN 2 ----------------------------- */


    public function get4CharComp(){
        $query = "SELECT DISTINCT LEFT(component_code,4) component_code FROM mo.mo_moulding";
        $result = $this->db->query($query);
        return $result->result_array();

    }


    public function getComponentWhere($id,$tanggal1,$tanggal2){
        $query = "SELECT * FROM mo.mo_moulding WHERE LEFT(component_code,4) LIKE '%".$id."%' AND production_date BETWEEN '$tanggal1'  AND '$tanggal2' ";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    
    public function getMasterItem($id){
        $query = "SELECT DISTINCT * FROM mo.mo_master_item WHERE kode_barang = '".$id."' LIMIT 1";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getBongkarWhere($id){
        $query ="SELECT DISTINCT * FROM mo.mo_moulding_bongkar WHERE moulding_id = '".$id."' LIMIT 1";
        $result = $this->db->query($query);
        if($result->num_rows() > 0){
            return $result->result_array();       
        }else{
            return 0;
        }
        
    }



    /* ------------------------ LAPORAN 3 ------------------------ */

    public function getComponentThis($tanggal1,$tanggal2){
        $query = "SELECT *  FROM mo.mo_moulding WHERE production_date  BETWEEN '$tanggal1' AND '$tanggal2' ORDER BY production_date ASC";
        $hasil = $this->db->query($query);

        return $hasil->result_array();

    }

    public function getQtyRejectQC($where){
        $query = "SELECT SUM(scrap_quantity) scrap_quantity FROM mo.mo_quality_control WHERE print_code = '$where' GROUP BY print_code";
        $hasil = $this->db->query($query);

        if($hasil->num_rows() > 0){
            return $hasil->result_array();
        }else{
            return 0;
        }
    }





    /* -------------------------------- LAPORAN 5 ----------------------- */
    public function getEmployee($tanggal1,$tanggal2){
        $sql = "SELECT * FROM mo.mo_moulding mm ,mo.mo_moulding_employee me WHERE mm.moulding_id = me.moulding_id AND mm.production_date BETWEEN '$tanggal1' AND '$tanggal2' ORDER BY production_date ASC";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function getAbsensi($tanggal1,$tanggal2){
        $sql = "SELECT ma.*,ma.created_date kerad,
        case 
        when ma.category_produksi = 'Moulding'
        then (select mis.print_code
        from mo.mo_moulding mis
        where mis.moulding_id = ma.id_produksi)
        when ma.category_produksi = 'Core'
        then (select mcs.print_code
        from mo.mo_core mcs
        where mcs.core_id = ma.id_produksi)
        else null 
            end print_code
        FROM mo.mo_absensi ma
        WHERE ma.created_date
        BETWEEN '$tanggal1' AND '$tanggal2' ORDER BY ma.created_date DESC";
        $result = $this->db->query($sql);
        return $result->result_array();
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