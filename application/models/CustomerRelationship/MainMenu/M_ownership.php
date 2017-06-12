<?php
class M_ownership extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
        }
		
		public function getOwnership($id = FALSE)
		{		
				// $this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_ownership');
						$this->db->where('ownership_change_date', NULL);
						$this->db->order_by('customer_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						//$query = $this->db->get_where('cr.vi_cr_customer_ownership',array('customer_id' => $id));
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_ownership');
						$this->db->where('ownership_change_date', NULL);
						$this->db->where('customer_id', $id);
						$this->db->order_by('customer_name', 'ASC');
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getOwnershipId($id = FALSE)
		{		
				// $this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_ownership');
						$this->db->where('ownership_change_date', NULL);
						$this->db->order_by('customer_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						//$query = $this->db->get_where('cr.vi_cr_customer_ownership',array('customer_ownership_id' => $id));
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_ownership');
						$this->db->where('ownership_change_date', NULL);
						$this->db->where('customer_ownership_id', $id);
						$this->db->order_by('customer_name', 'ASC');
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getOwnershipService($id = FALSE,$cust = FALSE)
		{		
				if ($id === FALSE)
				{		$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_ownership');
						$this->db->where('customer_id',$cust);
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_ownership');
						$this->db->where('customer_id',$cust);
						$this->db->like('segment1',$id);
						$this->db->order_by('item_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function postUpdate($data, $id)
		{		
			// $this->load->helper('url');
			$this->db->where('customer_ownership_id',$id);
			$this->db->update('cr.cr_customer_ownership', $data); 
		}
		
		public function setOwnership($data)
		{
			//$this->load->helper('url');
			return $this->db->insert('cr.cr_customer_ownership', $data);
		}
		
		public function getOwnershipData($cust_id,$item_id){
			$sql = "select * from cr.vi_cr_customer_ownership where customer_id='$cust_id' and customer_ownership_id='$item_id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getOwnershipFromBuyType($buy_type){
			$sql = "select * from cr.vi_cr_customer_ownership where customer_id='$cust_id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getGoverment(){
			$sql = "SELECT  party.party_name       BILL_CUST_NAME 
					FROM   hz_cust_accounts cust, 
							hz_cust_acct_sites_all acct, 
							hz_cust_site_uses_all ship, 
							hz_party_sites party_site,
							hz_locations loc,
							hz_parties party 
					 WHERE  cust.cust_account_id = acct.cust_account_id   
					 AND    acct.cust_acct_site_id = ship.cust_acct_site_id 
					 AND    acct.ORG_ID = ship.ORG_ID   
					 AND    ship.SITE_USE_CODE = 'BILL_TO' 
					 AND    cust.status = 'A' 
					 and    loc.location_id = party_site.location_id 
					 and     acct.party_site_id = party_site.party_site_id 
					 and        cust.party_id = party.party_id 
					 AND party.party_name  like '%DINAS %'
					 group by party.party_name 
					 order by party.party_name";
			$oracle =  $this->load->database('oracle',TRUE);
			$query = $oracle->query($sql);
			return $query->result_array();
		}
}