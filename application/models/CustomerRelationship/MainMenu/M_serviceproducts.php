<?php
class M_serviceproducts extends CI_Model {

		var $oracle;
        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
        		$this->oracle = $this->load->database ( 'oracle', TRUE );
        }
		
		public function getActivity($id = FALSE)
		{		//$id = str_replace("~", " ", $id);
				if ($id === FALSE)
				{		
					$sql1 = "SELECT * FROM
							(SELECT service_product_id,service_number,service_status,service_date,service_type,claim_method,
							description,customer_id,customer_name,province,city_regency,creation_date,'' as contact_number
							FROM cr.vi_cr_service_products
							UNION ALL
							SELECT connect_id,connect_number,connect_status,connect_date,connect_type,other_type,
							description,customer_id,customer_name,province,city_regency,creation_date,
							contact_number
							FROM cr.vi_cr_connect_headers) activity
							ORDER BY activity.service_status DESC,activity.creation_date DESC";						
				}
				else{
					$sql1 = "SELECT * FROM
							(SELECT service_product_id,service_number,service_status,service_date,service_type,claim_method,
							description,customer_id,customer_name,province,city_regency,creation_date,'' as contact_number
							FROM cr.vi_cr_service_products
							UNION ALL
							SELECT connect_id,connect_number,connect_status,connect_date,connect_type,other_type,
							description,customer_id,customer_name,province,city_regency,creation_date,
							contact_number
							FROM cr.vi_cr_connect_headers) activity
							WHERE activity.service_number = '$id'
							ORDER BY activity.service_status DESC,activity.creation_date DESC";						
				}
				
				$query = $this->db->query($sql1);
				return $query->result_array();
		}
		
		public function getServiceProducts($id = FALSE)
		{		//$id = str_replace("~", " ", $id);
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.vi_cr_service_products');					
						$this->db->order_by('creation_date', 'DESC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.vi_cr_service_products');
						//$this->db->like('upper(service_number)', $id);
						$this->db->where('service_product_id', $id);
						$this->db->order_by('creation_date', 'DESC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getServiceProductColumn($column,$where,$parameter)
		{		//$id = str_replace("~", " ", $id);
				
				$this->db->select($column);
				$this->db->from('cr.vi_cr_service_products');
				//$this->db->like('upper(service_number)', $id);
				$this->db->where($where, $parameter);
				$this->db->order_by('service_number', 'ASC');
				
				$query = $this->db->get();
				return $query->result_array();
				
		}
		
		public function getServiceProductNumber($id = FALSE)
		{		//$id = str_replace("~", " ", $id);
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.vi_cr_service_products');
						$this->db->order_by('service_number', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('service_product_id');
						$this->db->from('cr.vi_cr_service_products');
						$this->db->where('service_number', $id);
						//$this->db->where('service_product_id', $id);
						$this->db->order_by('service_number', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getServiceProductLines($id = FALSE)
		{		//$id = str_replace("~", " ", $id);
				if ($id === FALSE)
				{		
						/*$this->db->select('*');
						$this->db->from('cr.vi_cr_service_product_lines');					
						$this->db->order_by('service_product_line_id', 'ASC');*/
						$sql = "SELECT vcspl.*,csp.connect_id
						FROM cr.vi_cr_service_product_lines vcspl,cr.cr_service_products csp
						WHERE csp.service_product_id = vcspl.service_product_id
						ORDER BY csp.connect_id,vcspl.service_product_line_id ASC"
						;
				}
				else{
						/*$this->db->select('*');
						$this->db->from('cr.vi_cr_service_product_lines');	
						$this->db->where('service_product_id', $id);	
						$this->db->order_by('service_product_line_id', 'ASC');*/
						$sql = "SELECT vcspl.*,csp.connect_id
						FROM cr.vi_cr_service_product_lines vcspl,cr.cr_service_products csp
						WHERE csp.service_product_id = vcspl.service_product_id
						AND vcspl.service_product_id in ($id)
						ORDER BY csp.connect_id,vcspl.service_product_line_id ASC"
						;
				}

				$query = $this->db->query($sql);
				return $query->result_array();
		}
		
		public function getServiceProductLinesId()
		{							
						$this->db->select('service_product_line_id');
						$this->db->from('cr.vi_cr_service_product_lines');
						$this->db->limit(1);
						//$this->db->or_like('customer_id', $id);
						$this->db->order_by('service_product_line_id', 'DESC');

						$query = $this->db->get();
						return $query->result_array();
				
		}
		
		public function getConnect($id = FALSE,$number = FALSE)
		{		//$id = str_replace("~", " ", $id);
				if ($id === FALSE && $number === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.vi_cr_connect_headers');					
						$this->db->order_by('connect_number', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				elseif ($id === FALSE)
				{		
						$this->db->select('connect_id');
						$this->db->from('cr.vi_cr_connect_headers');
						$this->db->where('connect_number', $id);
						//$this->db->where('service_product_id', $id);
						$this->db->order_by('connect_number', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.vi_cr_connect_headers');
						//$this->db->like('upper(service_number)', $id);
						$this->db->where('connect_id', $id);
						$this->db->order_by('connect_number', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getConnectId()
		{							
						$this->db->select('connect_id');
						$this->db->from('cr.vi_cr_connect_headers');
						$this->db->limit(1);
						//$this->db->or_like('customer_id', $id);
						$this->db->order_by('connect_id', 'DESC');

						$query = $this->db->get();
						return $query->result_array();
				
		}
		
		public function getConnectUnit($id = FALSE)
		{		//$id = str_replace("~", " ", $id);
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.cr_connect_units');							
						$this->db->order_by('used_unit_id', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.cr_connect_units');	
						$this->db->where('connect_id', $id);	
						$this->db->order_by('used_unit_id', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getServiceProductFaqs($id = FALSE,$from_table)
		{		//$id = str_replace("~", " ", $id);
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.cr_feedbacks_and_questions');
						$this->db->where('from_table', $from_table);						
						$this->db->order_by('faq_id', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						
						$sql = "select * from cr.cr_feedbacks_and_questions 
								where service_connect_id in ($id)
								and from_table = '$from_table' order by faq_id";
						
						$query = $this->db->query($sql);
						return $query->result_array();
				}
		}
		
		public function getServiceProductFaqsTerm($term = FALSE,$type_faq = FALSE)
		{		//$id = str_replace("~", " ", $id);
				if ($type_faq === FALSE){
					if ($term === FALSE)
					{		
							$this->db->select('faq_description1');
							$this->db->distinct();
							$this->db->from('cr.cr_feedbacks_and_questions');						
							$this->db->order_by('faq_description1', 'ASC');
							
							$query = $this->db->get();
							//return $query->result_array();
					}
					else{
							$this->db->select('faq_description1');
							$this->db->distinct();
							$this->db->from('cr.cr_feedbacks_and_questions');	
							$this->db->like('lower(faq_description1)', $term);	
							$this->db->order_by('faq_description1', 'ASC');
							
							$query = $this->db->get();
							//return $query->result_array();
					}
				}else{
					if ($term === FALSE)
					{		
							$this->db->select('faq_description1');
							$this->db->distinct();
							$this->db->from('cr.cr_feedbacks_and_questions');
							$this->db->where('lower(faq_type)', $type_faq);								
							$this->db->order_by('faq_description1', 'ASC');
							
							$query = $this->db->get();
							//return $query->result_array();
					}
					else{
							$this->db->select('faq_description1');
							$this->db->distinct();
							$this->db->from('cr.cr_feedbacks_and_questions');
							$this->db->where('lower(faq_type)', $type_faq);	
							$this->db->like('lower(faq_description1)', $term);	
							$this->db->order_by('faq_description1', 'ASC');
							
							$query = $this->db->get();
							//return $query->result_array();
					}
				}
					
				if($query->num_rows() > 0){
				  foreach ($query->result_array() as $row){
					$row_set[] = htmlentities(stripslashes($row['faq_description1'])); //build an array
				  }
				  echo json_encode($row_set); //format the array into json data
				  //echo 2;
				}
				// echo $query->num_rows();
				// echo 1;
		}
		
		public function getServiceProductAddAct($service_id = FALSE,$serviceAddId = FALSE)
		{		//$id = str_replace("~", " ", $id);
				if ($service_id === FALSE)
				{	if ($serviceAddId === FALSE)
					{		
						
						$sql1 = "SELECT csaa.*,cssaa.additional_activity as additional_activity_desc
								FROM cr.cr_service_additional_activities csaa 
								JOIN cr.cr_setup_service_additional_activities cssaa 
								ON cssaa.setup_service_additional_activity_id=csaa.additional_activity 
								ORDER BY csaa.service_additional_activity_id";
					}
					else{
						$sql1 = "SELECT csaa.*,cssaa.additional_activity as additional_activity_desc
								FROM cr.cr_service_additional_activities csaa 
								JOIN cr.cr_setup_service_additional_activities cssaa 
								ON cssaa.setup_service_additional_activity_id=csaa.additional_activity 
								WHERE csaa.service_additional_activity_id = $serviceAddId
								ORDER BY csaa.service_additional_activity_id";
					}
				}
				else{
					if ($serviceAddId === FALSE)
					{	
						$sql1 = "SELECT csaa.*,cssaa.additional_activity as additional_activity_desc
								FROM cr.cr_service_additional_activities csaa JOIN  cr.cr_setup_service_additional_activities cssaa
								ON cssaa.setup_service_additional_activity_id=csaa.additional_activity 
								WHERE csaa.service_product_id in ($service_id)
								ORDER by csaa.service_additional_activity_id
								";
					}
					else{
						$sql1 = "SELECT csaa.*,cssaa.additional_activity as additional_activity_desc
								FROM cr.cr_service_additional_activities csaa JOIN  cr.cr_setup_service_additional_activities cssaa
								ON cssaa.setup_service_additional_activity_id=csaa.additional_activity 
								WHERE csaa.service_product_id=$service_id
								AND csaa.service_additional_activity_id = $serviceAddId
								ORDER by csaa.service_additional_activity_id
								";
					}						
				}
				$query = $this->db->query($sql1);
				return $query->result_array();
		}
		
		public function getServiceProductAddActTerm($term = FALSE)
		{		//$id = str_replace("~", " ", $id);
				if ($term === FALSE)
				{		
						$this->db->select('*');
						//$this->db->distinct();
						$this->db->from('cr.cr_setup_service_additional_activities');
						$this->db->order_by('additional_activity', 'ASC');
						
						$query = $this->db->get();
						return $query->result();
						//echo 4;
				}
				else{
						$this->db->select('*');
						$this->db->distinct();
						$this->db->from('cr.cr_setup_service_additional_activities');	
						$this->db->like('upper(additional_activity)', $term);						
						$this->db->order_by('additional_activity', 'ASC');
						
						$query = $this->db->get();
						return $query->result();
						
				}
				/*if($query->num_rows() > 0){
				  foreach ($query->result_array() as $row){
					$row_set[] = htmlentities(stripslashes($row['additional_activity'])); //build an array
				  }
				  echo json_encode($row_set); //format the array into json data
				  //echo 2;
				}*/
				//echo $query->num_rows;
		}
				
		public function updateServiceProducts($data, $id)
		{		
		
				$this->db->update('cr.cr_service_products', $data, array('service_product_id' => $id));
				
				//$this->db->update_batch('cr.cr_service_product_lines', $data_lines, 'service_product_line_id');

		}
		
		public function updateServiceProductLines($data_lines, $id)
		{				
				//$this->db->update('cr.cr_service_products', $data, array('service_product_id' => $id));
				
				$this->db->update('cr.cr_service_product_lines', $data_lines, array('service_product_line_id' => $id));

		}
		
		public function updateConnect($data, $id)
		{		
		
				$this->db->update('cr.cr_connect_headers', $data, array('connect_id' => $id));
				
				//$this->db->update_batch('cr.cr_service_product_lines', $data_lines, 'service_product_line_id');

		}
		
		public function updateConnectUnit($data_unit, $id)
		{				
				//$this->db->update('cr.cr_service_products', $data, array('service_product_id' => $id));
				
				$this->db->update('cr.cr_connect_units', $data_unit, array('used_unit_id' => $id));

		}
		
		public function updateServiceProductFaqs($data_faqs, $id)
		{				
				//$this->db->update('cr.cr_service_products', $data, array('service_product_id' => $id));
				
				$this->db->update('cr.cr_feedbacks_and_questions', $data_faqs, array('faq_id' => $id));

		}
		
		public function updateServiceProductAddAct($data_add_act, $id)
		{				
				//$this->db->update('cr.cr_service_products', $data, array('service_product_id' => $id));
				
				$this->db->update('cr.cr_service_additional_activities', $data_add_act, array('service_additional_activity_id' => $id));

		}
		
		public function setServiceProducts($data)
		{	
			
			$this->db->insert('cr.cr_service_products', $data);

		}
		
		public function setConnect($data)
		{	
			
			$this->db->insert('cr.cr_connect_headers', $data);

		}
		
		public function setServiceProductLines($data_lines)
		{	
			/*
			$this->db->insert('cr.cr_service_products', $data);
			$query = $this->db->query('select service_product_id from cr.cr_service_products 
			where service_number = ?',$data['service_number']);
			$row = $query->row();
			
			if($data != ''){
				for($i=0; $i<$count; $i++) {
					$data_lines[$i]['service_product_id'] = $row->service_product_id;
				}
			}
			*/
			$this->db->insert('cr.cr_service_product_lines', $data_lines);		

		}
		
		public function setServiceProductLineHistories($data_lines)
		{	
			
			$this->db->insert('cr.cr_service_line_histories', $data_lines);		

		}
		
		public function setConnectUnit($data_units)
		{	
			$this->db->insert('cr.cr_connect_units', $data_units);		

		}
		
		public function setServiceProductFaqs($data_faqs)
		{	
			
			$this->db->insert('cr.cr_feedbacks_and_questions', $data_faqs);

		}
		
		public function setServiceProductAddAct($data)
		{	
			
			$this->db->insert('cr.cr_service_additional_activities', $data);

		}
		
		public function getFilteredServiceProducts($name,$service_number,$activity,$method,$contact)
		{		//$id = str_replace("~", " ", $id);
			if(($name == null) and ($service_number == null) and ($activity == null) and ($method == null) and ($contact == null)){
				$condition = "";
				
			}else{
				$condition = "where";
			}
			
			if($name == null){
				$a = "";
			}else{
				$a = "upper(customer_name) like '%$name%'";
			}
			
			if($service_number == null){
				$b = "";
				$p1 = "";
			}else{
				$b = "upper(service_number) like '%$service_number%'";
				if($name == null){
					$p1 = "";
				}else{
					$p1 = "and";
				}
			}
			
			if($activity == null){
				$c = "";
				$p2 = "";
			}else{
				$c = "service_type = '$activity'";
				if(($name == null) and ($service_number == null)){
					$p2 = "";
				}else{
					$p2 = "and";
				}
			}
			
			if($method == null){
				$d = "";
				$p3 = "";
			}else{
				$d = "claim_method = '$method'";
				if(($name == null) and ($service_number == null) and ($activity == null)){
					$p3 = "";
				}else{
					$p3 = "and";
				}
			}
			
			if($contact == null){
				$e = "";
				$p4 = "";
			}else{
				$e = "contact_number like '%$contact%'";
				if(($name == null) and ($service_number == null) and ($activity == null)){
					$p4 = "";
				}else{
					$p4 = "and";
				}
			}
			$sql = "SELECT * FROM
					(SELECT service_product_id,service_number,service_status,service_date,service_type,claim_method,
					description,customer_id,customer_name,province,city_regency,creation_date,'' as contact_number
					FROM cr.vi_cr_service_products
					UNION ALL
					SELECT connect_id,connect_number,connect_status,connect_date,connect_type,other_type,
					description,customer_id,customer_name,province,city_regency,creation_date,
					contact_number
					FROM cr.vi_cr_connect_headers
					) activity $condition $a $p1 $b $p2 $c $p3 $d $p4 $e order by service_number";
			//$sql1 = "select * from cr.vi_cr_connect_headers $condition $a $p1 $b $p2 $c $p3 $d order by service_number";
			$query = $this->db->query($sql);
			//$query = $this->db->query($sql1);
			return $query->result_array();
		}
		
		function getServiceHistory($id){
			$sql = "select * from cr.cr_service_line_histories where service_product_line_id ='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		function getServiceLineHistory($id){
			$sql = "select * from cr.vi_cr_service_line_histories where service_product_id ='$id' order by service_line_history_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		function getServiceLineHistoryTop($id){
			$sql = "select * from cr.vi_cr_service_line_histories where service_product_line_id ='$id' order by service_line_history_id DESC limit 1";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		function getServiceLineTop($id){
			$sql = "select * from cr.vi_cr_service_product_lines where service_product_line_id ='$id' limit 1";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		function getActivityNumber($activity,$cust_id,$input){
			if($activity == 'service'){
				$sql = "select * from cr.cr_service_products where customer_id = $cust_id 
				and upper(service_number) like '%$input%' and service_status = 'OPEN' and connect_id is null";
			}
			else{
				$sql = "select * from cr.cr_connect_headers where customer_id = $cust_id 
				and upper(connect_number) like '%$input%' and connect_status = 'OPEN' 
				and connect_id not in (select connect_id from cr.cr_service_products where customer_id = $cust_id
				and connect_id is not null)";
			}
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		function checkForClose($service_id){
			$sql1 = "select * from cr.vi_cr_service_product_lines where service_product_id ='$service_id'";
			$query1 = $this->db->query($sql1);
			//$query1 = $query1->result_array();
			
			$sql2 = "select * from cr.vi_cr_service_product_lines where service_product_id ='$service_id' and line_status='CLOSE'";
			$query2 = $this->db->query($sql2);
			//$query2 = $query2->result_array();
			
			if($query1->num_rows() == $query2->num_rows()){
				$result = 'CLOSE';
			}
			else{
				$result = 'OPEN';
			}
			
			return $result;
		}
		
		function getLastActivityNumber($id){
			//$sql = "select COALESCE(cch.connect_number,'1') AS connect_number from cr.cr_connect_headers cch where cch.connect_type = '$id' order by cch.connect_number desc limit 1";
			$sqlDelete 	= "DELETE from cr.cr_service_product_number_temporary
							where creation_date <= (current_timestamp - INTERVAL '1 DAY')";
			$this->db->query($sqlDelete);

			$sql = "SELECT COALESCE(activity.activity_number,'1') AS activity_number 
					from (select cch.connect_number activity_number, cch.connect_type activity_type from cr.cr_connect_headers cch
						UNION ALL
						select csp.service_number activity_number, csp.service_type activity_type from cr.cr_service_products csp
						UNION ALL
						select cspnt.activity_number activity_number, cspnt.activity_type activity_type from cr.cr_service_product_number_temporary cspnt) activity
					where activity.activity_type = '$id' 
					order by activity.activity_number desc limit 1";
			$query = $this->db->query($sql);
			//return $query->result_array();
			if($query->num_rows() > 0){
					return $query->result_array();
				}else{
					return 0;
			}
		}

		function processClaimHeader($custId,$customerName,$own_address,$own_phone,$province,$City,$District,$Village,$Address,$duration,$shipped,$shipment_date,$reason,$noEvidence,$landCategory,$typeOfSoil,$landDepth,$WeedsItem,$TopographyItem,$Chronology,$created_by)
		{
			$sql	=	"INSERT INTO KHS_EXTERNAL_CLAIM_HEADERS
									(CLAIM_TYPE,
									USER_ID,
									CUST_ACCOUNT_ID,
									OWNER_NAME,
									OWNER_ADDRESS,
									OWNER_PHONE_NUMBER,
									DURATION_OF_USE,
									LOCATION_ADDRESS,
									LOCATION_VILLAGE,
									LOCATION_DISTRICT,
									LOCATION_CITY,
									LOCATION_PROVINCE,
									SHIPPED,
									SHIPMENT_DATE,
									NOT_SHIPPED_REASON,
									NO_EVIDENCE,
									LAND_CATEGORY,
									TYPE_OF_SOIL,
									LAND_DEPTH,
									WEEDS,
									TOPOGRAPHY,
									EVENT_CHRONOLOGY,
									CREATED_BY,
									CREATION_DATE,
									STATUS)
									VALUES (
										'HARVESTER',
										'".$created_by."',
										'".$custId."',
										'".$customerName."',
										'".$own_address."',
										'".$own_phone."',
										'".$duration."',
										'".$Address."',
										'".$Village."',
										'".$District."',
										'".$City."',
										'".$province."',
										'".$shipped."',
										TO_DATE('".$shipment_date."', 'yyyy-mm-dd HH24:MI:SS'),
										'".$reason."',
										'".$noEvidence."',
										'".$landCategory."',
										'".$typeOfSoil."',
										'".$landDepth."',
										'".$WeedsItem."',
										'".$TopographyItem."',
										'".$Chronology."',
										'".$created_by."',
										sysdate,
										'APPROVED'
									)";
			$query = $this->oracle->query($sql);
		}

		function province()
		{
			$sql = "select * from sys.sys_area_province";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function cityRegency($name)
		{
			$sql =	"	SELECT regency_name
						FROM sys.sys_area_city_regency
						WHERE province_id=(SELECT province_id
						FROM sys.sys_area_province
						WHERE province_name='$name'
						GROUP BY province_id)
						GROUP BY regency_name
						ORDER BY regency_name
					";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
			
		public function district($name)
		{
			$sql =	"	SELECT district_name
						FROM sys.sys_area_district
						WHERE city_regency_id=(SELECT city_regency_id
						FROM sys.sys_area_city_regency
						WHERE regency_name='$name'
						GROUP BY city_regency_id)
						GROUP BY district_name
						ORDER BY district_name
					";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
			
		public function village($name)
		{
			$sql =	"	SELECT village_name
						FROM sys.sys_area_village
						WHERE district_id=(SELECT district_id
						FROM sys.sys_area_district
						WHERE district_name='$name'
						GROUP BY district_id)
						GROUP BY village_name
						ORDER BY village_name
					";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function customerDataEC($customerName)
		{
			$sql =	"	SELECT ct.data, cs.oracle_customer_id, cs.address
						FROM cr.cr_customer_contacts ct, cr.cr_customers cs
						WHERE ct.connector_id = cs.customer_id AND cs.customer_name = '".$customerName."'
					";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		/*public function getDataCustOwn()
		{
			$sql =	"	SELECT *
						FROM im.im_master_items
						WHERE oracle_item_id IS NOT NULL AND segment1 = 'AFB0000BA1AZ-0'
					";
			$query = $this->db->query($sql);
			return $query->result_array();
		}*/

		public function approval($plaintext_string,$serviceid,$status,$approver,$approve_date)
		{
			$sql =	"	UPDATE cr.cr_service_products SET
							approval_status = '$status',
							approved_by		= '$approver'
						WHERE service_product_id = '$plaintext_string'
					";
			$query = $this->db->query($sql);

			$sql =	"	INSERT INTO cr.cr_approval_history
									(service_product_id,
									approval_status,
									approved_by,
									approved_date)
							VALUES ('".$serviceid."',
									'$status',
									'".$approver."',
									'".$approve_date."')
					";
			$query = $this->db->query($sql);
		}

		public function noApprove($plaintext_string,$serviceid,$status,$approver,$approve_date,$reason)
		{
			$sql =	"	UPDATE cr.cr_service_products SET
							approval_status 	= '$status',
							approved_by			= '$approver',
							reason_not_approve	= '$reason'
						WHERE service_product_id = '$plaintext_string'
					";
			$query = $this->db->query($sql);

			$sql =	"	INSERT INTO cr.cr_approval_history
									(service_product_id,
									approval_status,
									approved_by,
									approved_date,
									reason_not_approve)
							VALUES ('".$serviceid."',
									'".$status."',
									'".$approver."',
									'".$approve_date."',
									'".$reason."')
					";
			$query = $this->db->query($sql);
		}

		function setNewActivityNumber($activityNumber,$term,$user_id)
		{
			$sql 	= "INSERT 	INTO cr.cr_service_product_number_temporary
            							(activity_number, activity_type, creation_date, created_by)
     							VALUES 	('$activityNumber', '$term', current_timestamp, '$user_id')";
			$query 	= $this->db->query($sql);
		}

		function setNewActivityTemp($dataTemp)
		{
			$save = $this->db->insert('cr.cr_service_product_number_temporary', $dataTemp);
			$last_insert_id = $this->db->insert_id();
			return $last_insert_id;
		}

		function updateActivityData($activityNumber,$term,$user_id,$idTemp)
		{
			$sql 	= "	UPDATE cr.cr_service_product_number_temporary SET
							activity_number 	= '$activityNumber',
							activity_type 		= '$term',
							last_updated_by 	= '$user_id',
							last_update_date 	= current_timestamp
						WHERE service_number_id = '$idTemp'";
			$query 	= $this->db->query($sql);
		}

		function deleteActivityTemp($id)
		{
			$this->db->where('service_number_id',$id);
			$this->db->delete('cr.cr_service_product_number_temporary');

			$sql 	= "DELETE from cr.cr_service_product_number_temporary where creation_date <= (current_timestamp - INTERVAL '1 DAY')";
			$this->db->query($sql);
		}

		function getServiceNumber($id)
		{
			$this->db->select('*');
			$this->db->from('cr.cr_service_product_number_temporary');
			$this->db->where('service_number_id', $id);
			$this->db->order_by('service_number_id', 'ASC');
			
			$query = $this->db->get();
			return $query->result_array();
		}
		function setDataClaimImage($img)
		{
			$this->db->insert('cr.cr_service_product_images', $img);
		}

		public function claimImage($data)
		{	
			$this->db->insert('cr.cr_service_product_line_images', $data);
		}

		function updateTempCustId($data,$idTmp)
		{		
				$this->db->update('cr.cr_service_product_number_temporary', $data, array('service_number_id' => $idTmp));
		}
		
		function getDataClaimImage($id)
		{
			$this->db->select('*');
			$this->db->from('cr.cr_service_product_images');
			$this->db->where('service_number', $id);
			$this->db->order_by('service_product_image_id', 'ASC');
			$query = $this->db->get();
			return $query->result_array();
		}

		function getImageData($id)
		{
			$this->db->select('*');
			$this->db->from('cr.cr_service_product_images');
			$this->db->where('service_number', $id);
			$query = $this->db->get();
			return $query->result_array();
		}

		function getDataSelectedImg($image_id)
		{
			$this->db->select('*');
			$this->db->from('cr.cr_service_product_images');
			$this->db->where('service_product_image_id', $image_id);
			$query = $this->db->get();
			return $query->result_array();
		}

		function setImageDataLine($dataImgLine)
		{
			$this->db->insert('cr.cr_service_product_line_images', $dataImgLine);
			return $this->db->insert_id();
		}

		function getImageLine($rowId,$ownerId)
		{
			$sql = "SELECT service_product_line_image_id
					from cr.cr_service_product_line_images
					where row_id = '$rowId' AND ownership_id = '$ownerId'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		/*function updateImageDataLine($data, $id)
		{
			$this->db->update('cr.cr_service_product_line_images', $data, array('service_product_line_image_id' => $id));
		}*/
}