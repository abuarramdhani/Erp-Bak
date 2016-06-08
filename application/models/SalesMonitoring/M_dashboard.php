<?php
class M_dashboard extends CI_Model {

        public function __construct()
        {
            $this->load->database();
			$this->load->library('encrypt');
        }
		
		//count Pricelist Index
		public function countPricelistindex()
		{
			$sql = "select count(pricelist_index_id) from sf.pricelist_index";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//count Sales Order
		public function countSalesomset()
		{
			$sql = "select count(sales_omset_id) from sf.sales_omset";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//count Sales Target
		public function countSalesTarget()
		{
			$sql = "select count(sales_target_id) from sf.sales_target";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
}
?>