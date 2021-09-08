<?php defined('BASEPATH') or exit('No direct script access allowed');
class M_pipeline extends CI_Model
{

	public function __construct(){
        parent::__construct();

        $this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    // oracle db
    public function get_max_request($table){
        $sql = "SELECT MAX(REQUEST_ID) REQ_ID FROM $table";
        $data = $this->oracle->query($sql);
        return $data->result_array();
    }

    public function get_data_sales(){
    	$sql = "SELECT request_id, tanggal, bulan, tahun,
                       tahun || '-' || bulan || '-' || tanggal tgl_transaksi, cabang,
                       '-' item, '-' item_desc, quantity, '-' status
                  FROM khs_lpb_hari
                 WHERE request_id = (SELECT MAX (request_id)
                                       FROM khs_lpb_hari)
                UNION
                SELECT request_id, NVL (tanggal, 0) tanggal, NVL (bulan, 0) bulan,
                       NVL (tahun, 0) tahun,
                       NVL2 (tahun,
                             tahun || '-' || bulan || '-' || tanggal,
                             ''
                            ) tgl_transaksi,
                       cabang, item, item_desc, quantity, status
                  FROM khs_lpb_type
                 WHERE request_id = (SELECT MAX (request_id)
                                       FROM khs_lpb_type)";
    	$data = $this->oracle->query($sql);
    	return $data->result_array();
    }

    public function get_data_sales_detail(){
        $sql = "SELECT *
                  FROM khs_lpb_penjualan_detail
                 WHERE request_id = (SELECT MAX (request_id)
                                       FROM khs_lpb_penjualan_detail)";
        $data = $this->oracle->query($sql);
        return $data->result_array();
    }

    public function get_support_data($table, $pk){
        $sql = "SELECT cst_tab.*
              FROM $table cst_tab, khs_lpb_uploaded_status klu 
             WHERE cst_tab.$pk = klu.value_id
               AND klu.source_table = '$table'
                AND klu.status = 'N'";
        $data = $this->oracle->query($sql);
        return $data->result_array();
    }

    public function update_uploaded_column($table, $id){
        $this->oracle->query("UPDATE khs_lpb_uploaded_status SET STATUS = 'Y' WHERE source_table = '$table' AND value_id = $id");
    }

    // postgre db
    public function check_data_availability($table, $column, $value){
        $check = $this->db->query('SELECT COUNT(*) FROM mb.'.$table.' WHERE "'.$column.'" = '.$value);
        return $check->result_array();
    }

    public function insert_sales_data($table ,$data){
        $this->db->insert_batch('mb.'.$table, $data);
    }

    public function insert_supporting_data($table, $data){
        $column = array_keys($data)[0];
        $value = $data[$column];

        $this->db->insert("mb.".$table, $data);
        $this->update_uploaded_column($table, $value);
    }

    public function update_supporting_data($table, $data){
        $column = array_keys($data)[0];
        $value = $data[$column];

        $this->db
                ->where($column, $value)
                ->update('mb.'.$table, $data);

        $this->update_uploaded_column($table, $value);
    }

    // Function tambahan

    public function get_all_skip_date($db){

      if ($db == 'ORACLE'){
        $query = $this->oracle->query("SELECT DATE_ID FROM KHS_LPB_SKIP_DATE");
      } else if ($db == 'POSTGRES'){
        $query = $this->db->query('SELECT "DATE_ID" FROM mb.khs_lpb_skip_date');
      }

      return $query->result_array();
    }

    public function delete_data($table, $column, $value){
      $this->db->query('DELETE FROM mb.'.$table.' WHERE "'.$column.'" = '.$value);
    }

}
?>