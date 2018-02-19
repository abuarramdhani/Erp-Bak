<?php
clASs M_creditlimit extends CI_Model {

	var $oracle;
    public function __construct()
    {
        parent::__construct();
        $this->postgre = $this->load->database ( 'erp', TRUE );
    }
	
	public function showData()
	{
		$sql = "SELECT *
 				FROM pe.pe_table_order";
		
		$query = $this->postgre->query($sql);
		return $query->result_array();
	}

	public function seksi()
	{
		$sql = "SELECT seksi
				FROM pe.pe_seksi";

		$query = $this->postgre->query($sql);
		return $query->result_array();
	}

		public function order()
	{
		$sql = "SELECT order_
				FROM pe.pe_order";

		$query = $this->postgre->query($sql);
		return $query->result_array();
	}

		public function jenisOrder()
	{
		$sql = "SELECT jenis_order
				FROM pe.pe_jenis_order";

		$query = $this->postgre->query($sql);
		return $query->result_array();
	}
}
?>