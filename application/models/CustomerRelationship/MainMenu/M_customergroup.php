<?php
class M_customergroup extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
        }

		public function getCustomerGroup($id = FALSE)
		{
				$this->load->helper('url');
				if ($id === FALSE)
				{
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_group');
						$this->db->order_by('customer_group_name', 'ASC');

						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$query = $this->db->get_where('cr.vi_cr_customer_group', array('customer_group_id' => $id));
						return $query->result_array();
				}
		}

		public function getCustomerGroupActive($id = FALSE)
		{
				$this->load->helper('url');
				if ($id === FALSE)
				{
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_group');
						$this->db->where('end_date', NULL);
						$this->db->order_by('customer_group_name', 'ASC');

						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$query = $this->db->get_where('cr.vi_cr_customer_group', array('customer_group_id' => $id, 'end_date' => NULL));
						return $query->result_array();
				}
		}

		public function getCustomerGroupName($id = FALSE)
		{
				$this->load->helper('url');
				if ($id === FALSE)
				{
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_group');
						//$this->db->where('end_date', NULL);
						$this->db->order_by('customer_group_name', 'ASC');

						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_group');
						//$this->db->where('end_date', NULL);
						$this->db->like('upper(customer_group_name)', $id);
						//$this->db->or_like('customer_id', $id);
						$this->db->order_by('customer_group_name', 'ASC');

						$query = $this->db->get();
						return $query->result_array();
				}
		}

		public function getCustomerGroupMember($id = FALSE)
		{
				$this->load->helper('url');
				if ($id === FALSE)
				{
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_group_customers');
						$this->db->order_by('customer_name', 'ASC');

						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_group_customers');
						$this->db->where('customer_group_id', $id);
						$this->db->where('customer_name IS NOT NULL');
						$this->db->order_by('customer_name', 'ASC');

						$query = $this->db->get();
						return $query->result_array();

						//$query = $this->db->get_where('cr.vi_cr_customer_group', array('customer_group_id' => $id));
						//return $query->result_array();
				}
		}

		public function postUpdate($data, $id)
		{		$this->load->helper('url');
				$this->db->where('customer_group_id',$id);
				$this->db->update('cr.cr_customer_group', $data);

		}

		public function setCustomerGroup($data)
		{
			$this->load->helper('url');

			//$slug = url_title($this->input->post('title'), 'dash', TRUE);

			return $this->db->insert('cr.cr_customer_group', $data);
		}

		public function getFilteredCustomerGroup($name,$village,$city,$province)
		{

			if(($name == null) and ($village == null) and ($city == null) and ($province == null)){
				$condition = "";

			}else{
				$condition = "where";
			}

			if($name == null){
				$a = "";
			}else{
				$a = "upper(customer_group_name) like '%$name%'";
			}

			if($village == null){
				$b = "";
				$p1 = "";
			}else{
				$b = "upper(village) like '%$village%'";
				if($name == null){
					$p1 = "";
				}else{
					$p1 = "and";
				}
			}

			if($city == null){
				$c = "";
				$p2 = "";
			}else{
				$c = "upper(city_regency) like '%$city%'";
				if(($name == null) and ($village == null)){
					$p2 = "";
				}else{
					$p2 = "and";
				}
			}

			if($province == null){
				$d = "";
				$p3 = "";
			}else{
				$d = "province_id = '$province'";
				if(($name == null) and ($village == null) and ($city == null)){
					$p3 = "";
				}else{
					$p3 = "and";
				}
			}

			$query = $this->db->query("select * from cr.vi_cr_customer_group $condition $a $p1 $b $p2 $c $p3 $d order by customer_group_name");
			return $query->result_array();

		}

		public function getCustomerGroupByKey($id){
			$sql = "select * from cr.vi_cr_customer_group where upper(customer_group_name) like '%$id%' order by customer_group_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
}

