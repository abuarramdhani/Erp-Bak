<?php
class M_Pengecekan extends CI_Model{

	var $oracle;
    public function __construct(){
    	parent::__construct();
      	$this->load->database();
      	$this->oracle = $this->load->database('oracle', TRUE);
  		$this->load->library('encrypt');
  		$this->load->helper('url');
    }

    function loadDataCek($SJ){
    	$sql = "SELECT po, vendor, 
				TO_CHAR(receipt_date, 'DD MON YYYY'), 
				TO_CHAR(sp_date, 'DD MON YYYY'), 
				item_name, item_description, 
				qty_sj, qty_actual 
				FROM khs_data_receipt_ppb 
				WHERE no_sj = '$SJ'";
		$query = $this->oracle->query($sql);
		return $query->result();
    }

    function updateData($qtyActual,$SJ,$itemName,$itemDesc){
    	$sql="UPDATE khs_data_receipt_ppb 
			  SET qty_actual = $qtyActual
			  WHERE no_sj = '$SJ' 
			  AND ITEM_NAME='$itemName' 
			  AND ITEM_DESCRIPTION='$itemDesc'";
		echo $sql;
		$query = $this->oracle->query($sql);
    }
    //uppercase
}