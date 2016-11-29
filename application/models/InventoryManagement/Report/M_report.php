<?php
class M_report extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
        }
		
		//fungsi filtering untuk report customer
		public function getCustomerData($name,$district,$city,$province,$job,$category){
			if(($name == null) and ($district == null) and ($city == null) and ($province == null) and ($job == "NULL") and ($category == null)){
				$sql = "select * from cr.vi_cr_customer";
			}else{
				
				//cek apakah name terisi
				if($name == null){
					$a = "";
				}else{
					$a = "upper(customer_name) like '%$name%'";
				}
				
				//cek apakah district terisi
				if($district == null){
					$b = "";
					$p1 = "";
				}else{
					if($name == null){
						$b = "upper(district) like '%$district%'";
						$p1 = "";
					}else{
						$b = "upper(district) like '%$district%'";
						$p1 = "and";
					}	
				}
				
				//cek apakah city terisi
				if($city == null){
					$c = "";
					$p2 = "";
				}else{
					if(($name == null) and ($district == null)){
						$c = "upper(city_regency) like '%$city%'";
						$p2 = "";
					}else{
						$c = "upper(city_regency) like '%$city%'";
						$p2 = "and";
					}	
				}
				
				//cek apakah province terisi
				if($province == null){
					$d = "";
					$p3 = "";
				}else{
					if(($name == null) and ($district == null) and ($city == null)){
						$d = "upper(province) like '%$province%'";
						$p3 = "";
					}else{
						$d = "upper(province) like '%$province%'";
						$p3 = "and";
					}	
				}
				
				//cek apakah category terisi
				if($category == null){
					$e = "";
					$p4 = "";
				}else{
					if(($name == null) and ($district == null) and ($city == null) and ($province == null)){
						$e = "customer_category_id = '$category'";
						$p4 = "";
					}else{
						$e = "customer_category_id = '$category'";
						$p4 = "and";
					}	
				}
				
				//cek apakah additional info terisi
				if($job == "NULL"){
					$f = "";
					$p5 = "";
				}else{
					if(($name == null) and ($district == null) and ($city == null) and ($category == null) and ($province == null)){
						$f = "upper(additional_info) like '%$job%'";
						$p5 = "";
					}else{
						$f = "upper(additional_info) like '%$job%'";
						$p5 = "and";
					}	
				}
				
				$sql = "select * from cr.vi_cr_customer where $a $p1 $b $p2 $c $p3 $d $p4 $e $p5 $f ";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//fungsi filtering untuk report sold unit
		public function getSoldUnitData($item_name,$body_number,$engine_number,$district,$city,$province,$buying_type,$owner,$startdate, $enddate){
			if(($item_name == null) and ($body_number == null) and ($engine_number == null) and ($district == null) and ($city == null) and ($province == null) and ($buying_type == null) and ($owner == null) and ($startdate == null)){
				$sql = "select * from cr.vi_cr_customer_ownership";
			}else{
				
				//cek apakah item name terisi
				if($item_name == null){
					$a = "";
				}else{
					$a = "upper(segment1) like '%$item_name%'";
				}
				
				//cek apakah body number terisi
				if($body_number == null){
					$b = "";
					$p1 = "";
				}else{
					if($item_name == null){
						$b = "upper(no_body) like '%$body_number%'";
						$p1 = "";
					}else{
						$b = "upper(no_body) like '%$body_number%'";
						$p1 = "and";
					}	
				}
				
				//cek apakah engine number terisi
				if($engine_number == null){
					$c = "";
					$p2 = "";
				}else{
					if(($item_name == null) and ($body_number == null)){
						$c = "upper(no_engine) like '%$engine_number%'";
						$p2 = "";
					}else{
						$c = "upper(no_engine) like '%$engine_number%'";
						$p2 = "and";
					}	
				}
				
				//cek apakah district terisi
				if($district == null){
					$d = "";
					$p3 = "";
				}else{
					if(($item_name == null) and ($body_number == null) and ($engine_number == null)){
						$d = "upper(district) like '%$district%'";
						$p3 = "";
					}else{
						$d = "upper(district) like '%$district%'";
						$p3 = "and";
					}	
				}
				
				//cek apakah city terisi
				if($city == null){
					$e = "";
					$p4 = "";
				}else{
					if(($item_name == null) and ($body_number == null) and ($engine_number == null) and ($district == null)){
						$e = "upper(city_regency) like '%$city%'";
						$p4 = "";
					}else{
						$e = "upper(city_regency) like '%$city%'";
						$p4 = "and";
					}	
				}
				
				//cek apakah additional info terisi
				if($province == null){
					$f = "";
					$p5 = "";
				}else{
					if(($item_name == null) and ($body_number == null) and ($engine_number == null) and ($district == null) and ($city == null)){
						$f = "upper(province) like '%$province%'";
						$p5 = "";
					}else{
						$f = "upper(province) like '%$province%'";
						$p5 = "and";
					}	
				}
				
				//cek apakah buying type terisi 
				if($buying_type == null){
					$g = "";
					$p6 = "";
				}else{
					if(($item_name == null) and ($body_number == null) and ($engine_number == null) and ($district == null) and ($city == null) and($province == null)){
						$g = "upper(buying_type_name) like '%$buying_type%'";
						$p6 = "";
					}else{
						$g = "upper(buying_type_name) like '%$buying_type%'";
						$p6 = "and";
					}	
				}	
				
				//cek apakah owner name terisi 
				if($owner == null){
					$h = "";
					$p7 = "";
				}else{
					if(($item_name == null) and ($body_number == null) and ($engine_number == null) and ($district == null) and ($city == null) and($province == null) and ($buying_type == null)){
						$h = "upper(customer_name) like '%$owner%'";
						$p7 = "";
					}else{
						$h = "upper(customer_name) like '%$owner%'";
						$p7 = "and";
					}	
				}

				//cek apakah date range terisi 
				if($startdate == null){
					$i = "";
					$p8 = "";
				}else{
					if(($item_name == null) and ($body_number == null) and ($engine_number == null) and ($district == null) and ($city == null) and($province == null) and ($buying_type == null) and ($owner == null)){
						$i = "ownership_date between '$startdate' and '$enddate'";
						$p8 = "";
					}else{
						$i = "ownership_date between '$startdate' and '$enddate'";
						$p8 = "and";
					}	
				}
				
				$sql = "select * from cr.vi_cr_customer_ownership where $a $p1 $b $p2 $c $p3 $d $p4 $e $p5 $f $p6 $g $p7 $h $p8 $i";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//fungsi filtering untuk report troubled part
		public function getTroubledPartData($item_name,$spare_part,$body_number,$category){
			if(($item_name == null) and ($body_number == null) and ($spare_part == null) and ($category == null)){
				$sql = "select * from cr.vi_cr_service_product_lines";
			}else{
				
				//cek apakah item name terisi
				if($item_name == null){
					$a = "";
				}else{
					$a = "upper(segment1) like '%$item_name%'";
				}
				
				//cek apakah body number terisi
				if($body_number == null){
					$b = "";
					$p1 = "";
				}else{
					if($item_name == null){
						$b = "upper(no_body) like '%$body_number%'";
						$p1 = "";
					}else{
						$b = "upper(no_body) like '%$body_number%'";
						$p1 = "and";
					}	
				}
				
				//cek apakah spare_part terisi
				if($spare_part == null){
					$c = "";
					$p2 = "";
				}else{
					if(($item_name == null) and ($body_number == null)){
						$c = "upper(spare_part) like '%$spare_part%'";
						$p2 = "";
					}else{
						$c = "upper(spare_part) like '%$spare_part%'";
						$p2 = "and";
					}	
				}
				
				//cek apakah district terisi
				if($category == null){
					$d = "";
					$p3 = "";
				}else{
					if(($item_name == null) and ($body_number == null) and ($spare_part == null)){
						$d = "upper(problem) like '%$category%'";
						$p3 = "";
					}else{
						$d = "upper(problem) like '%$category%'";
						$p3 = "and";
					}	
				}
				
				$sql = "select * from cr.vi_cr_service_product_lines where $a $p1 $b $p2 $c $p3 $d";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getAdditionalData($id){
			$sql = "select * from cr.vi_cr_customer_additional_info where customer_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getContactData($id){
			$sql = "select * from cr.cr_customer_contacts where connector_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getAllItems(){
			$sql = "select distinct(segment1), item_name from cr.vi_cr_customer_ownership";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getCategoryById($id){
			$sql = "select * from cr.cr_customer_category where customer_category_id='$id'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getItemById($id){
			$sql = "select * from im.im_master_items where segment1='$id'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getUnitById($id){
			$sql = "select * from im.im_master_items where item_id in ($id)";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getItemLikeId($id){
			$sql = "select * from im.im_master_items where (segment1 like '%$id%' or item_name like '%$id%') and category_id = '2'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getEmployeeLikeId($id){
			$sql = "select * from er.vi_er_employee_data where upper(employee_name) like '%$id%' or upper(employee_code) like '%$id%'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getItemLikeIdArray($id){
			$sql = "select * from im.im_master_items where (segment1 like '%$id%' or item_name like '%$id%') and category_id = '2' limit 50";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getItemLines($id,$cust_id){
			$sql = "select * from cr.vi_cr_customer_ownership where (segment1 like '%$id%' or item_name like '%$id%') and customer_id = '$cust_id' limit 50";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getSPLikeName($id){
			$sql = "select * from im.im_master_items where item_name like '%$id%' and category_id = '3'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getSPLikeId($id){
			$sql = "select * from im.im_master_items where segment1 like '%$id%' and category_id = '3'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getSPSearch($id){
			$sql = "select * from im.im_master_items where (segment1 like '%$id%' or item_name like '%$id%') and category_id = '3'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getSPSearchArray($id){
			$sql = "select * from im.im_master_items where (segment1 like '%$id%' or item_name like '%$id%') and category_id = '3' limit 50";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getBNSearch($id){
			$sql = "select distinct(no_body) from cr.vi_cr_customer_ownership where no_body like '%$id%'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getENSearch($id){
			$sql = "select distinct(no_engine) from cr.vi_cr_customer_ownership where no_engine like '%$id%'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getBTSearch($id){
			$sql = "select distinct(buying_type_name) from cr.vi_cr_customer_ownership where upper(buying_type_name) like '%$id%'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getONSearch($id){
			$sql = "select distinct(customer_name) from cr.vi_cr_customer_ownership where customer_name like '%$id%'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getProvinceSearch($id){
			$sql = "select* from dll.dll_province where upper(province_name) like '%$id%'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getCitySearch($id){
			$sql = "select * from dll.dll_city_regency where upper(regency_name) like '%$id%'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getAreaSearch($id){
			$sql = "select area_id, area_name, (select count(*) from dll.dll_province where province_id=area_id) as province, (select count(*) from dll.dll_city_regency where city_regency_id=area_id) as city_regency
					from dll.dll_area where upper(area_name) like '%$id%'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getDistrictSearch($id){
			$sql = "select distinct(area_name) from dll.dll_indonesian_area_all where area_level='3' and upper(area_name) like '%$id%'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getVillageSearch($id){
			$sql = "select distinct(area_name) from dll.dll_indonesian_area_all where area_level='4' and upper(area_name) like '%$id%'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getAllSparePart(){
			$sql = "select * from im.im_master_items where category_id='3'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getAllProblem(){
			$sql = "select * from cr.cr_service_problems order by service_problem_name";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getReportByName($id){
			$sql="select * from cr.cr_report where upper(report_name) like '%$id%' order by report_name limit 50";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getCustomerOwnership($start_date,$end_date,$start_ownership_date,$end_ownership_date,$province_id,$program,$buying_type){
			if($province_id==""){
				$and1 = "";
			}else{
				$and1 = "AND vcc.province_id in ($province_id)";
			}
			if($program==""){
				$and2 = "";
				$and3 = "";
			}else{
				$and2 = "AND csp.service_type in ('$program')";
				$and3 = "AND cch.connect_type in ('$program')";
			}
			if($buying_type==""){
				$and4 = "";
			}else{
				$and4 = "AND vcco.buying_type_id in ($buying_type)";
			}
			if($start_ownership_date==""){
				$and5 = "";
			}else{
				$and5 = "AND vcco.ownership_date between '$start_ownership_date' and '$end_ownership_date'";
			}
			//$sql="select no_engine, customer_name, ownership_date, buying_type_name, city_regency from cr.vi_cr_customer_ownership limit 2";
				$sql="SELECT vcc.customer_name,vcc.customer_id,vcc.city_regency ,vcc.contact,vcco.no_body, vcco.item_name,
					CASE WHEN vcco.item_name like '%H-140R%' OR  vcco.item_name like '%H-140 R%'THEN
					'H-140R'
					ELSE
					'-'
					END AS type, to_char(vcco.ownership_date,'DD-MON-YYYY') ownership_date, vcco.buying_type_name,
					count(vcc.customer_name) over (partition by vcc.customer_name) jumlah
					FROM
					cr.vi_cr_customer_ownership vcco,
					cr.vi_cr_customer vcc
					WHERE
					vcc.customer_id = vcco.customer_id
					$and1 $and4 $and5
					and vcc.customer_id in (
						SELECT csp.customer_id
						FROM 
						cr.cr_service_products csp
						WHERE csp.service_type = 'customer_visit'
						AND csp.service_date between '$start_date' and '$end_date'
						$and2
						UNION
						SELECT cch.customer_id
						FROM 
						cr.cr_connect_headers cch 
						WHERE cch.connect_type = 'call_out'
						$and3
						AND cch.connect_date between '$start_date' and '$end_date'
						)
					order by customer_name,vcco.ownership_date desc;";
			$query = $this->db->query($sql);
			return $query->result_array();
			
		}
		
		public function getProgramMonth($start_date,$end_date,$program){
			if($program==""){
				$and2 = "";
				$and3 = "";
			}else{
				$and2 = "AND csp.service_type in ('$program')";
				$and3 = "AND cch.connect_type in ('$program')";
			}
			//$sql="select no_engine, customer_name, ownership_date, buying_type_name, city_regency from cr.vi_cr_customer_ownership limit 2";
				$sql="SELECT customer_id,service_month,count(customer_id) over (partition by customer_id) total
						FROM(
							SELECT csp.customer_id, 'CV' as type,
							to_char(csp.service_date,'MON-YY') service_month,
							to_char(csp.service_date,'YYMM') order_month
							FROM 
							cr.cr_service_products csp
							WHERE 1=1
							AND csp.service_type = 'customer_visit'
							AND csp.service_date between '$start_date' and '$end_date'
							$and2
							UNION
							SELECT cch.customer_id, 'CO' as type,
							to_char(cch.connect_date,'MON-YY') service_month,
							to_char(cch.connect_date,'YYMM') order_month
							FROM 
							cr.cr_connect_headers cch 
							WHERE 1=1
							AND cch.connect_type = 'call_out'
							AND cch.connect_date between '$start_date' and '$end_date'
							$and3) ABC
						GROUP BY customer_id,service_month,order_month
						ORDER BY customer_id,order_month
						;";
			$query = $this->db->query($sql);
			return $query->result_array();
			
		}
		public function getProgramWeek($start_date,$end_date,$program){
			
			if($program==""){
				$and2 = "";
				$and3 = "";
			}else{
				$and2 = "AND csp.service_type in ('$program')";
				$and3 = "AND cch.connect_type in ('$program')";
			}
			//$sql="select no_engine, customer_name, ownership_date, buying_type_name, city_regency from cr.vi_cr_customer_ownership limit 2";
				$sql="SELECT * ,count(customer_id) over (partition by customer_id,service_month) total
						FROM(
							SELECT customer_id,service_month,service_week, 
							CASE WHEN count(customer_id) over (partition by customer_id,service_month,service_week,type) != 
								count(customer_id) over (partition by customer_id,service_month,service_week)	THEN 'VO'
							ELSE
							type
							END AS type
							FROM(
								SELECT csp.customer_id, 'CV' as type,
								to_char(csp.service_date,'MON-YY') service_month,
								case when to_char(csp.service_date,'DD')::int between 1 and 7 then 1
								when to_char(csp.service_date,'DD')::int between 8 and 14 then 2
								when to_char(csp.service_date,'DD')::int between 15 and 21 then 3
								when to_char(csp.service_date,'DD')::int > 21 then 4
								else NULL
								end service_week
								FROM 
								cr.cr_service_products csp
								WHERE 1=1
								AND csp.service_type = 'customer_visit'
								AND csp.service_date between '$start_date' and '$end_date'
								$and2
								UNION ALL
								SELECT cch.customer_id, 'CO' as type,
								to_char(cch.connect_date,'MON-YY') connect_month,
								case when to_char(cch.connect_date,'DD')::int between 1 and 7 then 1
								when to_char(cch.connect_date,'DD')::int between 8 and 14 then 2
								when to_char(cch.connect_date,'DD')::int between 15 and 21 then 3
								when to_char(cch.connect_date,'DD')::int > 21 then 4
								else NULL
								end connect_week
								FROM 
								cr.cr_connect_headers cch 
								WHERE 1=1
								AND cch.connect_type = 'call_out'
								AND cch.connect_date between '$start_date' and '$end_date'
								$and3) ABC
						) DEF
					GROUP BY customer_id,service_month,service_week,type
					ORDER BY customer_id
					;";
			$query = $this->db->query($sql);
			return $query->result_array();
			
		}
		
		public function getAllServiceKeliling($allcity,$start,$end){
			if($allcity == ""){
				if($start == ""){
					$p1= "";
					$a1= "";
					$p2 = "";
				}else{
					$p1 = "";
					$a1 = "";
					$p2 = "where service_date between '$start' and '$end'";
				}
			}else{
				if($start == ""){
					$a1= "";
					$p1 = "where city_regency_id in ($allcity)";
					$p2= "";
				}else{
					$p1 = "where city_regency_id in ($allcity)";
					$a1 = "and";
					$p2 = "service_date between '$start' and '$end'";				}
				
			}
			$sql="select * from cr.vi_cr_service_keliling $p1 $a1 $p2";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getAllServiceKelilingUnit(){
			$sql = "select a.service_product_id, a.item_name, a.spare_part_name, b.buying_type_name, eea.employee_name,
					c.service_number, c.service_date, upper(a.line_status) as line_status 
					from cr.vi_cr_service_product_lines a
					left join cr.vi_cr_customer_ownership b on a.ownership_id = b.customer_ownership_id
					left join cr.cr_service_products c on a.service_product_id = c.service_product_id
					left join er.er_employee_all eea ON a.technician_id = eea.employee_id
					
					";
			$query = $this->db->query($sql);
			return $query->result_array();
			
		}
		
		public function getAllServiceKelilingResponse(){
			$sql = "select a.*, b.service_number, b.service_date 
					from cr.cr_feedbacks_and_questions a
					left join cr.cr_service_products b on a.service_connect_id = b.service_product_id
					and a.from_table = 'cr_service_products'					
					";
			$query = $this->db->query($sql);
			return $query->result_array();
			
		}
		
		public function getRekapServiceKeliling($start,$end,$allcity,$sort_by){
			if($sort_by == "Unit"){
				$sort  = "ORDER BY rsk.unit desc";
			}else{
				$sort  = "ORDER BY rsk.spare_part desc";
			}
			if($allcity == ""){
					$sql = "select rsk.* 
							from (select a.*, 
								(select count(b.spare_part_name)
								from cr.vi_cr_service_product_lines b
								left join cr.vi_cr_service_products c on b.service_product_id = c.service_product_id
								left join cr.vi_cr_customer d on c.customer_id = d.customer_id 
								where c.service_type like '%service%keliling%' 
									and d.city_regency_id = a.city_regency_id 
									and b.action_date between '$start' and '$end'
								) as spare_part,
								(select count(b.item_name)
								from cr.vi_cr_service_product_lines b
								left join cr.vi_cr_service_products c on b.service_product_id = c.service_product_id
								left join cr.vi_cr_customer d on c.customer_id = d.customer_id 
								where c.service_type like '%service%keliling%' 
									and d.city_regency_id = a.city_regency_id
									and b.action_date between '$start' and '$end'
								) as unit
							from dll.dll_city_regency a) rsk
							where (rsk.spare_part != 0 or rsk.unit !=0)
							$sort";
			}else{
					$sql = "select rsk.*
							from(select a.*, 
								(select count(b.spare_part_name)
								from cr.vi_cr_service_product_lines b
								left join cr.vi_cr_service_products c on b.service_product_id = c.service_product_id
								left join cr.vi_cr_customer d on c.customer_id = d.customer_id 
								where c.service_type like '%service%keliling%' 
									and d.city_regency_id = a.city_regency_id 
									and b.action_date between '$start' and '$end'
								) as spare_part,
								(select count(b.item_name)
								from cr.vi_cr_service_product_lines b
								left join cr.vi_cr_service_products c on b.service_product_id = c.service_product_id
								left join cr.vi_cr_customer d on c.customer_id = d.customer_id 
								where c.service_type like '%service%keliling%' 
									and d.city_regency_id = a.city_regency_id
									and b.action_date between '$start' and '$end'
								) as unit
							from dll.dll_city_regency a
							where a.city_regency_id in ($allcity)) rsk
							where (rsk.spare_part != 0 or rsk.unit !=0)
							$sort";
				
			}
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getDataTroubledPart($start,$end,$customername,$province,$unit,$bodynumber,$activity,$sparepart,$technician,$status){
			if(($start == "") and ($customername == "") and ($province == "") and ($unit == "") and ($bodynumber == "") and ($activity == "") and ($sparepart == "") and ($technician == "") and ($status == "")){
				$sql = "select a.* , b.customer_id, b.service_date, b.service_type, c.customer_name, d.regency_name,b.service_number
					from cr.vi_cr_service_product_lines a
					left join cr.vi_cr_service_products b on a.service_product_id = b.service_product_id
					left join cr.vi_cr_customer c on b.customer_id = c.customer_id
					left join dll.dll_city_regency d on c.city_regency_id = d.city_regency_id
					";
			}else{
				
				if($start == ""){
					$a = "";
				}else{
					$a = "b.service_date between '$start' and '$end'";
				}
				
				if($customername == ""){
					$b = "";
					$p1 = "";
				}else{
					if($start == ""){
						$b = "upper(c.customer_name) like '%$customername%'";
						$p1 = "";
					}else{
						$b = "upper(c.customer_name) like '%$customername%'";
						$p1 = "and";
					}	
				}
				
				if($province == ""){
					$c = "";
					$p2 = "";
				}else{
					if(($start == "") and ($customername == "")){
						$c = "c.province_id in ($province)";
						$p2 = "";
					}else{
						$c = "c.province_id in ($province)";
						$p2 = "and";
					}	
				}
				
				if($unit == ""){
					$d = "";
					$p3 = "";
				}else{
					if(($start == "") and ($customername == "") and ($province == "")){
						$d = "a.segment1 in ($unit)";
						$p3 = "";
					}else{
						$d = "a.segment1 in ($unit)";
						$p3 = "and";
					}	
				}
				
				if($activity == ""){
					$e = "";
					$p4 = "";
				}else{
					if(($start == "") and ($customername == "") and ($province == "") and ($unit == "")){
						$e = "b.service_type in ($activity)";
						$p4 = "";
					}else{
						$e = "b.service_type in ($activity)";
						$p4 = "and";
					}	
				}
				
				if($bodynumber == ""){
					$f = "";
					$p5 = "";
				}else{
					if(($start == "") and ($customername == "") and ($province == "") and ($unit == "") and ($activity == "")){
						$f = "upper(a.no_body) like '%$bodynumber%'";
						$p5 = "";
					}else{
						$f = "upper(a.no_body) like '%$bodynumber%'";
						$p5 = "and";
					}	
				}
				
				if($sparepart == ""){
					$g = "";
					$p6 = "";
				}else{
					if(($start == "") and ($customername == "") and ($province == "") and ($unit == "") and ($activity == "") and ($bodynumber == "")){
						$g = "a.spare_part = '$sparepart'";
						$p6 = "";
					}else{
						$g = "a.spare_part = '$sparepart'";
						$p6 = "and";
					}	
				}
				
				if($technician == ""){
					$h = "";
					$p7 = "";
				}else{
					if(($start == "") and ($customername == "") and ($province == "") and ($unit == "") and ($activity == "") and ($bodynumber == "") and ($sparepart == "")){
						$h = "a.technician_id = '$technician'";
						$p7 = "";
					}else{
						$h = "a.technician_id = '$technician'";
						$p7 = "and";
					}	
				}
				
				if($status == ""){
					$i = "";
					$p8 = "";
				}else{
					if(($start == "") and ($customername == "") and ($province == "") and ($unit == "") and ($activity == "") and ($bodynumber == "") and ($sparepart == "") and ($technician == "")){
						$i = "a.consecutive_number = '$status'";
						$p8 = "";
					}else{
						$i = "a.consecutive_number = '$status'";
						$p8 = "and";
					}	
				}
			$sql = "select a.* , b.customer_id, b.service_date, b.service_type, c.customer_name, d.regency_name,b.service_number
					from cr.vi_cr_service_product_lines a
					left join cr.vi_cr_service_products b on a.service_product_id = b.service_product_id
					left join cr.vi_cr_customer c on b.customer_id = c.customer_id
					left join dll.dll_city_regency d on c.city_regency_id = d.city_regency_id
					where $a $p1 $b $p2 $c $p3 $d $p4 $e $p5 $f $p6 $g $p7 $h $p8 $i
					";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getRekapTroubledPart($unit_id2,$city_id,$spare_part_id,$newstart,$new_end){
			if($unit_id2 == ""){
				$and1  = "";
			}else{
				$and1  = "AND vcspl.item_id in ($unit_id2)";
			}
			if($city_id == ""){
				$and2  = "";
			}else{
				$and2  = "AND vcc.city_regency_id in ($city_id)";
			}
			if($spare_part_id == ""){
				$and3  = "";
			}else{
				$and3  = "AND vcspl.spare_part_id in ($spare_part_id)";
			}
			
			/*$sql = "select distinct a.spare_part, a.spare_part_name, b.segment1, b.item_name, (select count(spare_part) from cr.vi_cr_service_product_lines where spare_part = a.spare_part) as total 
					from cr.vi_cr_service_product_lines a
					left join cr.vi_cr_service_product_lines b on a.spare_part = b.spare_part
					where a.spare_part is not null";*/
			$sql = "select * from
					(select distinct vcspl.spare_part, vcspl.spare_part_name, vcspl.segment1, vcspl.item_name, 
					(select count(spare_part) from cr.vi_cr_service_product_lines where spare_part = vcspl.spare_part) as total 
					from cr.vi_cr_service_product_lines vcspl,
					cr.vi_cr_service_products vcsp left join cr.vi_cr_customer vcc on vcsp.customer_id = vcc.customer_id 
					where vcspl.spare_part is not null
					and vcsp.service_product_id = vcspl.service_product_id
					and vcsp.service_date between '$newstart' and '$new_end'
					$and1 $and2 $and3) tp
					order by tp.total desc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function CountSPPerMonth($spare,$sd,$ed){
			$sql = "select count(*) as jml 
					from cr.vi_cr_service_product_lines a
					left join cr.vi_cr_service_products b on a.service_product_id = b.service_product_id
					where a.spare_part='$spare' and b.service_date between '$sd' and '$ed'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function RekapCustomerVisit($by,$start_date,$end_date){
			if($by==='Activity'){
				$sql = "SELECT 'SERVICE' as activity, count(service_product_id) as freq
					   FROM cr.cr_service_products csp
					   WHERE service_type = 'customer_visit'
					   AND csp.service_date between '$start_date' and '$end_date'
					  UNION ALL
					   SELECT ssaa.additional_activity as activity, count(ssaa.setup_service_additional_activity_id)
					   FROM cr.cr_service_products csp
					   LEFT JOIN cr.cr_service_additional_activities csaa ON csp.service_product_id = csaa.service_product_id
					   LEFT JOIN cr.cr_customers cc ON csp.customer_id = cc.customer_id
					   LEFT JOIN cr.cr_connect_headers cch ON csp.connect_id = cch.connect_id
					   LEFT JOIN cr.cr_setup_service_additional_activities ssaa ON csaa.additional_activity = ssaa.setup_service_additional_activity_id
					   WHERE service_type = 'customer_visit'
						AND csp.service_date between '$start_date' and '$end_date'
					   GROUP BY ssaa.additional_activity
					   HAVING count(ssaa.setup_service_additional_activity_id) > 0
					   order by freq desc";
			}else if($by==='CityRegency'){
				$sql = "SELECT dcr.regency_name,count(csp.service_product_id) as freq
					   FROM cr.cr_service_products csp
						LEFT JOIN cr.cr_customers cc ON csp.customer_id = cc.customer_id
						LEFT JOIN dll.dll_province dp ON dp.province_id = cc.province_id
						   LEFT JOIN dll.dll_city_regency dcr ON dcr.city_regency_id = cc.city_regency_id
						LEFT JOIN dll.dll_village dv ON dv.village_id = cc.village_id
						LEFT JOIN dll.dll_district dd ON dd.district_id = cc.district_id
						WHERE service_type = 'customer_visit'
						AND csp.service_date between '$start_date' and '$end_date'
						GROUP BY dcr.regency_name
						order by count(csp.service_product_id) desc";
			}else if($by==='Province'){
				$sql = "SELECT dp.province_name,count(csp.service_product_id) as freq
					   FROM cr.cr_service_products csp
						LEFT JOIN cr.cr_customers cc ON csp.customer_id = cc.customer_id
						LEFT JOIN dll.dll_province dp ON dp.province_id = cc.province_id
					   LEFT JOIN dll.dll_city_regency dcr ON dcr.city_regency_id = cc.city_regency_id
						LEFT JOIN dll.dll_village dv ON dv.village_id = cc.village_id
						LEFT JOIN dll.dll_district dd ON dd.district_id = cc.district_id
						WHERE service_type = 'customer_visit'
						AND csp.service_date between '$start_date' and '$end_date'
						GROUP BY dp.province_name
						order by freq desc";
			}else{
				$sql = "SELECT to_char(csp.service_date,'Month-YY') as month,count(csp.service_product_id) as freq
					    FROM cr.cr_service_products csp
						WHERE service_type = 'customer_visit'
						AND csp.service_date between '$start_date' and '$end_date'
						GROUP BY to_char(csp.service_date,'Month-YY')
						order by freq desc;";
			}
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function RekapCallOut($by,$province,$start_date,$end_date){
			if($by==='CityRegency'){
				if($province==FALSE){
					$sql = "SELECT vcc.city_regency as city_regency, count(cch.connect_id) as freq
					   FROM cr.cr_connect_headers cch
					   LEFT JOIN cr.vi_cr_customer vcc ON cch.customer_id = vcc.customer_id
					   WHERE cch.connect_type = 'call_out'
					   AND cch.connect_date between '$start_date' and '$end_date'
					   GROUP BY vcc.city_regency
						HAVING count(cch.connect_id) > 0
						ORDER BY 2 desc;";
				}else{
					$sql = "SELECT vcc.city_regency as city_regency, count(cch.connect_id) as freq
					   FROM cr.cr_connect_headers cch
					   LEFT JOIN cr.vi_cr_customer vcc ON cch.customer_id = vcc.customer_id
					   WHERE cch.connect_type = 'call_out'
					   AND cch.connect_date between '$start_date' and '$end_date'
					   AND vcc.province_id in ($province)
					   GROUP BY vcc.city_regency
						HAVING count(cch.connect_id) > 0
						ORDER BY 2 desc;";
				}				
			}else{
				if($province==FALSE){
					$sql = "SELECT vcc.province as province, count(cch.connect_id) as freq
					   FROM cr.cr_connect_headers cch
					   LEFT JOIN cr.vi_cr_customer vcc ON cch.customer_id = vcc.customer_id
					   WHERE cch.connect_type = 'call_out'
					   AND cch.connect_date between '$start_date' and '$end_date'
					   GROUP BY vcc.province
						HAVING count(cch.connect_id) > 0
						ORDER BY 2 desc;";
				}else{
					$sql = "SELECT vcc.province as province, count(cch.connect_id) as freq
					   FROM cr.cr_connect_headers cch
					   LEFT JOIN cr.vi_cr_customer vcc ON cch.customer_id = vcc.customer_id
					   WHERE cch.connect_type = 'call_out'
					   AND cch.connect_date between '$start_date' and '$end_date'
					   AND vcc.province_id in ($province)
					   GROUP BY vcc.province
						HAVING count(cch.connect_id) > 0
						ORDER BY 2 desc;";
				}
				
			}
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getRekapFaq($city_regency,$faq_type,$activity,$start_date,$end_date){
			if($city_regency == ""){
				$and1  = "";
			}else{
				$and1  = "AND faq.city_regency_id in ($city_regency)";
			}
			if($faq_type == ""){
				$and2  = "";
			}else{
				$and2  = "AND faq.faq_type in ($faq_type)";
			}
			if($activity == ""){
				$and3  = "";
			}else{
				$and3  = "AND faq.activity in ($activity)";
			}
			$sql = "SELECT faq.faq_type,faq.faq_description1,count(faq.faq_id) as freq
					FROM (
						SELECT vcc.city_regency_id,csp.service_date as date,cfaq.faq_type,csp.service_type as activity,cfaq.faq_description1,cfaq.faq_id
						FROM cr.cr_service_products csp 
						LEFT JOIN cr.vi_cr_customer vcc ON csp.customer_id = vcc.customer_id
						LEFT JOIN er.er_employee_all ee ON csp.employee_id = ee.employee_id
						JOIN cr.cr_feedbacks_and_questions cfaq ON csp.service_product_id = cfaq.service_connect_id
						WHERE cfaq.from_table = 'cr_service_products'
						UNION ALL
						SELECT vcc.city_regency_id,cch.connect_date as date, cfaq.faq_type,cch.connect_type,cfaq.faq_description1,cfaq.faq_id
						FROM cr.cr_connect_headers cch
						LEFT JOIN cr.vi_cr_customer vcc ON cch.customer_id = vcc.customer_id
						LEFT JOIN er.er_employee_all ee ON cch.employee_id = ee.employee_id
						JOIN cr.cr_feedbacks_and_questions cfaq ON cch.connect_id = cfaq.service_connect_id
						WHERE cfaq.from_table = 'cr_connect_headers'
						) faq
					WHERE 
						faq.date between '$start_date' and '$end_date'
					$and1 $and2 $and3
					group by faq.faq_type,faq.faq_description1
					order by 3 desc,1,2 
					";
			
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getCustomerVisitData($city_id,$buying_type,$start_date,$end_date){
			if($city_id == ""){
				$and1  = "";
			}else{
				$and1  = "AND vcc.city_regency_id in ($city_id)";
			}
			if($buying_type == ""){
				$and2  = "";
				$and3  = "";
			}else{
				$and2  = "AND cspl.buying_type_id in ($buying_type)";
				$and3  = "AND vcco2.buying_type_id in ($buying_type)";
			}
			$sql = "SELECT csp.service_product_id,csp.service_number,
					vcc.customer_name,
					coalesce(vcc.address,'')||', RT '||trim(vcc.rt)||', RW '||trim(vcc.rw)||','||vcc.district||' District, '||vcc.village||
					' Village, '||vcc.city_regency||', '||vcc.province address,
					vcc.contact,
					to_char(csp.service_date,'DD/MM/YYYY') visit_date,
					csp.description,
					cspl.item_name,
					cspl.buying_type_name,
					cspl.ownership_id,
					(select vcspl2.technician_name from cr.vi_cr_service_product_lines vcspl2
					where vcspl2.service_product_id = csp.service_product_id
					order by vcspl2.service_product_line_id
					 limit 1) teknisi,
					(SELECT count(vcspl2.service_product_id)
						FROM (select service_product_id,ownership_id from cr.vi_cr_service_product_lines group by service_product_id,ownership_id) vcspl2
						LEFT JOIN cr.vi_cr_customer_ownership vcco2 ON vcspl2.ownership_id = vcco2.customer_ownership_id
						WHERE vcspl2.service_product_id = csp.service_product_id
						$and3) as jlh_unit_service
					FROM
					cr.cr_service_products csp
					LEFT JOIN cr.vi_cr_customer vcc on csp.customer_id = vcc.customer_id
					LEFT JOIN 
					(select distinct vcspl.service_product_id,ccmbt.buying_type_name,vcspl.item_name,vcspl.ownership_id,vcspl.buying_type_id
					from cr.vi_cr_service_product_lines vcspl,
					cr.cr_customer_master_buying_type ccmbt
					where vcspl.buying_type_id = ccmbt.buying_type_id) cspl on csp.service_product_id = cspl.service_product_id
					WHERE
					csp.service_type = 'customer_visit'
					AND csp.service_date BETWEEN '$start_date' and '$end_date'
					$and1 $and2
					order by csp.service_date desc,csp.service_number
					";
			
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getMonthYear($start_date,$total_month){
			$sql = "select to_char(DATE '$start_date' + (interval '1' month * generate_series(0,$total_month)),'MON-YY') as month;
					";
					
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getMasaPanen($city_id,$buying_type,$start_date,$end_date,$filter){
			if($city_id == ""){
				$and1  = "";
			}else{
				$and1  = "AND vcc.city_regency_id in ($city_id)";
			}
			if($buying_type == ""){
				$and2  = "";
			}else{
				$and2  = "AND ownership.buying_type_id in ($buying_type)";
			}
			if($filter == "OwnershipDate"){
				$sort  = "ORDER BY ownership.ownership_date desc,vcc.city_regency,vcc.customer_name";
			}elseif($filter == "CityRegency"){
				$sort  = "ORDER BY vcc.city_regency,ownership.ownership_date,vcc.customer_name";
			}
			elseif($filter == "CustomerName"){
				$sort  = "ORDER BY vcc.customer_name,vcc.city_regency,ownership.ownership_date";
			}
			else{
				$sort  = "ORDER BY harvest_time";
			}
			$sql = "SELECT vcc.customer_name,vcc.city_regency,vcc.contact,ownership.ownership_date,ownership.buying_type_name,
					(SELECT max(cch.harvest_time) from cr.cr_connect_headers cch 
						WHERE cch.customer_id = vcc.customer_id group by cch.customer_id) as harvest_time
					from cr.vi_cr_customer vcc,
					(SELECT DISTINCT ON (vcco.customer_id) vcco.customer_ownership_id,vcco.customer_id,
						vcco.buying_type_name,vcco.buying_type_id,vcco.ownership_date
					FROM   cr.vi_cr_customer_ownership vcco
					ORDER  BY vcco.customer_id, vcco.ownership_date DESC NULLS LAST) ownership
					WHERE vcc.customer_id = ownership.customer_id
					AND (SELECT max(cch.harvest_time) from cr.cr_connect_headers cch 
						WHERE cch.customer_id = vcc.customer_id group by cch.customer_id) BETWEEN '$start_date' and '$end_date'
					and (SELECT max(cch.harvest_time) from cr.cr_connect_headers cch 
						WHERE cch.customer_id = vcc.customer_id group by cch.customer_id) is not null
					$and1 $and2
					$sort
					";
					
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		////////////////////////////////////////////////////////  Data Call Out /////////////////////////////////////////////////////////
		
		public function getDataCallOut2($city_id,$start_date,$end_date){
			if($city_id == ""){
				$and1  = "";
			}else{
				$and1  = "AND vcc.city_regency_id in ($city_id)";
			}
			$sql = "SELECT vcch.connect_id, vcch.connect_number, (SELECT csp.service_number from cr.cr_service_products csp where csp.connect_id = vcch.connect_id) service_number, 
					vcch.customer_name,vcc.city_regency, vcch.contact_number, vcch.connect_date calling_date, vcch.employee_name as operator, vcch.description,vcch.harvest_time
					,(SELECT count(csp.connect_id)
					FROM cr.vi_cr_service_products csp, cr.vi_cr_service_product_lines cspl
					WHERE csp.service_product_id = cspl.service_product_id
					AND csp.connect_id = vcch.connect_id ) as jlh_unit_sp
					FROM cr.vi_cr_connect_headers vcch
					LEFT JOIN cr.vi_cr_customer vcc ON vcch.customer_id = vcc.customer_id
					WHERE vcch.connect_type = 'call_out'
					AND vcch.connect_date BETWEEN '$start_date' and '$end_date'
					$and1
					";
					
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getDataCallOut($city_id,$start_date,$end_date,$buying_type){
			if($city_id == ""){
				$and1  = "";
			}else{
				$and1  = "AND vcc.city_regency_id in ($city_id)";
			}
			if($buying_type == ""){
				$and2  = "";
			}else{
				$and2  = "AND vcco.buying_type_id in ($buying_type)";
				$and3  = "AND vcco2.buying_type_id in ($buying_type)";
			}
			$sql = "SELECT vcch.connect_id, vcch.connect_number, vcch.customer_name,vcc.city_regency, vcch.contact_number, 
						to_char(vcch.connect_date,'DD-MON-YYYY') calling_date, vcch.employee_name as operator, vcch.description as connect_description,
						vcch.harvest_time,ccu.description as unit_name,vcco.buying_type_name,ccu.use,ccu.body_num,
						(SELECT count(ccu2.connect_id)
						FROM cr.cr_connect_units ccu2
						LEFT JOIN cr.vi_cr_customer_ownership vcco2 ON ccu2.ownership_id = vcco2.customer_ownership_id
						WHERE ccu2.connect_id = ccu.connect_id
						$and3) as jlh_unit_connect
					FROM cr.vi_cr_connect_headers vcch
					LEFT JOIN cr.vi_cr_customer vcc ON vcch.customer_id = vcc.customer_id
					LEFT JOIN cr.cr_connect_units ccu ON vcch.connect_id = ccu.connect_id 
					LEFT JOIN cr.vi_cr_customer_ownership vcco ON ccu.ownership_id = vcco.customer_ownership_id
					LEFT JOIN cr.vi_cr_service_products vcsp ON vcsp.connect_id = ccu.connect_id 
					WHERE vcch.connect_type = 'call_out'
					AND vcch.connect_date BETWEEN '$start_date' and '$end_date'
					$and1 $and2
					order by vcch.connect_date desc,vcch.connect_id
					";
					
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getConnectUnit($connect_id,$buying_type){
			if($buying_type == ""){
				$and1  = "";
			}else{
				$and1  = "AND vcco.buying_type_id in ($buying_type)";
			}
			$sql = "SELECT 	ccu.*,vcco.buying_type_name
					,(SELECT count(csp.connect_id)
					FROM cr.vi_cr_service_products csp, cr.vi_cr_service_product_lines cspl
					WHERE csp.service_product_id = cspl.service_product_id
					AND csp.connect_id = ccu.connect_id
					AND ccu.ownership_id = cspl.ownership_id ) as jlh_unit
					FROM cr.cr_connect_units ccu, cr.vi_cr_customer_ownership vcco
					WHERE ccu.ownership_id = vcco.customer_ownership_id
					AND ccu.connect_id IN ($connect_id)
					$and1
					";
					
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getServiceLines($connect_id){
			
			$sql = "SELECT 	csp.connect_id,cspl.*
					FROM cr.vi_cr_service_products csp, cr.vi_cr_service_product_lines cspl
					WHERE csp.service_product_id = cspl.service_product_id
					AND csp.connect_id IN ($connect_id)
					";
					
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getServiceFaqs($connect_id){
			
			$sql = "SELECT 	faq.*
					FROM cr.cr_feedbacks_and_questions faq
					WHERE faq.from_table = 'cr_connect_headers'
					AND faq.service_connect_id IN ($connect_id)
					";
					
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getRekapComplain($city_id,$category_service,$start_date,$end_date,$sort_by){
			if($city_id == ""){
				$and1  = "";
			}else{
				$and1  = "where vcc.city_regency_id in ($city_id)";
			}
			
			if($category_service == "WithBKE"){
				$and2  = "where claim_number is NOT NULL";
			}elseif($category_service == "NonBKE"){
				$and2  = "where claim_number is NULL";
			}else{
				$and2 = "";
			}
			if($sort_by == "TroubledPart"){
				$sort  = "def.tp desc";
			}else{
				$sort  = "def.complain desc";
			}
			$sql = "SELECT def.* from (
						select vcc.customer_name,vcc.customer_id,vcc.city_regency, COALESCE(complain.complain,0) complain, count(vcspl.item_name) tp
						from    cr.vi_cr_customer vcc
						LEFT JOIN (select * from cr.cr_service_products 
						where service_date between '$start_date' and '$end_date') csp1 on vcc.customer_id = csp1.customer_id 
						LEFT JOIN (select * from cr.vi_cr_service_product_lines
							$and2) vcspl on csp1.service_product_id = vcspl.service_product_id
						LEFT JOIN (select abc.customer_id, count(abc.faq_description1) complain
							from 
							(select cch.customer_id,cch.connect_date as date,faq1.faq_description1
							from cr.cr_connect_headers cch,
							cr.cr_feedbacks_and_questions faq1
							where cch.connect_id = faq1.service_connect_id
							  AND faq1.from_table = 'cr_connect_headers'
							union all
							select csp.customer_id,csp.service_date as date,faq2.faq_description1
							from cr.cr_service_products csp,
							cr.cr_feedbacks_and_questions faq2
							where csp.service_product_id = faq2.service_connect_id
							  AND faq2.from_table = 'cr_service_products') abc
							 where abc.date between '$start_date' and '$end_date'
							group by abc.customer_id) complain ON vcc.customer_id = complain.customer_id
						$and1
						group by vcc.customer_name,vcc.customer_id,vcc.city_regency,complain.complain
						order by vcc.customer_name) def
					WHERE def.complain != 0 or tp != 0
					ORDER BY $sort
					";
					
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getDataTpComplain($city_id,$category_service,$start_date,$end_date){
			if($city_id == ""){
				$and1  = "";
			}else{
				$and1  = "AND vcc.city_regency_id in ($city_id)";
			}
			if($category_service == "WithBKE"){
				$and2  = "where claim_number is NOT NULL";
			}elseif($category_service == "NonBKE"){
				$and2  = "where claim_number is NULL";
			}else{
				$and2 = "";
			}
			/*$sql = "SELECT DISTINCT def.* from (
						select vcc.customer_id,COALESCE(complain.group_date,to_char(csp1.service_date,'Mon-YY')) group_date, COALESCE(complain.complain,0) complain, count(vcspl.item_name) tp
						from    cr.vi_cr_customer vcc
						LEFT JOIN (select * from cr.cr_service_products 
						where service_date between '$start_date' and '$end_date') csp1 on vcc.customer_id = csp1.customer_id 
						LEFT JOIN (select * from cr.vi_cr_service_product_lines
						$and2) vcspl on csp1.service_product_id = vcspl.service_product_id
						LEFT JOIN (select abc.customer_id, abc.group_date,count(abc.faq_description1) complain
							from 
							(select cch.customer_id,cch.connect_date date,to_char(cch.connect_date,'Mon-YY') group_date,faq1.faq_description1
							from cr.cr_connect_headers cch,
							cr.cr_feedbacks_and_questions faq1
							where cch.connect_id = faq1.service_connect_id
							  AND faq1.from_table = 'cr_connect_headers'
							union all
							select csp.customer_id,csp.service_date date,to_char(csp.service_date,'Mon-YY') group_date,faq2.faq_description1
							from cr.cr_service_products csp,
							cr.cr_feedbacks_and_questions faq2
							where csp.service_product_id = faq2.service_connect_id
							  AND faq2.from_table = 'cr_service_products') abc
							 where abc.date between '$start_date' and '$end_date'
							group by abc.customer_id,abc.group_date) complain ON vcc.customer_id = complain.customer_id
						$and1
						group by vcc.customer_id,complain.group_date,complain.complain,csp1.service_date
						order by vcc.customer_id,complain.group_date) def
					WHERE def.complain != 0 or tp != 0";
			*/
			$sql = 	"SELECT   def.customer_id,complain_date,COALESCE(tp_date,sort_date) group_date, complain, sum(tp) tp,
							count(complain_date) over(partition by def.customer_id) total
					FROM (
						SELECT vcc.customer_id,COALESCE(complain.group_date,to_char(csp1.service_date,'Mon-YY')) complain_date, 
							COALESCE(complain.sort_date,to_char(csp1.service_date,'YYMM')) sort_date,
							COALESCE(to_char(csp1.service_date,'Mon-YY'),complain.group_date) tp_date, COALESCE(complain.complain,0) complain, 
							count(vcspl.item_name) tp
						FROM    cr.vi_cr_customer vcc
						LEFT JOIN (select * from cr.cr_service_products 
						where service_date between '$start_date' and '$end_date') csp1 on vcc.customer_id = csp1.customer_id 
						LEFT JOIN (select * from cr.vi_cr_service_product_lines $and2) vcspl on csp1.service_product_id = vcspl.service_product_id
						LEFT JOIN (
							select abc.customer_id, abc.group_date,sort_date,count(abc.faq_description1) complain
							from 
								(select cch.customer_id,cch.connect_date date,to_char(cch.connect_date,'YYMM') sort_date,
								to_char(cch.connect_date,'Mon-YY') group_date,faq1.faq_description1
								from cr.cr_connect_headers cch,
								cr.cr_feedbacks_and_questions faq1
								where cch.connect_id = faq1.service_connect_id
								  AND faq1.from_table = 'cr_connect_headers'
								union all
								select csp.customer_id,csp.service_date date,to_char(csp.service_date,'YYMM') sort_date,
								to_char(csp.service_date,'Mon-YY') group_date,faq2.faq_description1
								from cr.cr_service_products csp,
								cr.cr_feedbacks_and_questions faq2
								where csp.service_product_id = faq2.service_connect_id
								  AND faq2.from_table = 'cr_service_products') abc
								 where abc.date between '$start_date' and '$end_date'
								group by abc.customer_id,abc.group_date,abc.sort_date
							) complain ON vcc.customer_id = complain.customer_id
						where COALESCE(complain.group_date,to_char(csp1.service_date,'Mon-YY')) = COALESCE(to_char(csp1.service_date,'Mon-YY'),complain.group_date)
						$and1
						group by vcc.customer_id,complain.group_date,complain.complain,csp1.service_date,complain.sort_date
						order by vcc.customer_id,complain.group_date
					) def
					WHERE def.complain != 0 or tp != 0
					GROUP BY def.customer_id,complain_date,tp_date, complain,sort_date
					ORDER BY def.customer_id,def.sort_date;
					";
					
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getDataFaq($city_id,$faq_type,$activities,$start_date,$end_date,$sort_by){
			if($city_id == ""){
				$and1  = "";
			}else{
				$and1  = "AND vcc.city_regency_id in ($city_id)";
			}
			if($faq_type == ""){
				$and2  = "";
			}else{
				$and2  = "AND abc.faq_type in ($faq_type)";
			}
			if($activities == ""){
				$and3  = "";
			}else{
				$and3  = "AND abc.activity in ($activities)";
			}
			if($sort_by == "OpenDate"){
				$sort  = "order by abc.open_date";
			}elseif($sort_by == "ResponseDescription"){
				$sort  = "order by abc.faq_description1";
			}else{
				$sort  = "order by abc.response_time";
			}

			$sql = "select vcc.city_regency_id,vcc.city_regency,vcc.customer_name,abc.*
					from 
					(select cch.customer_id,cr.activity_type(cch.connect_type) activity,cch.connect_date open_date,
					case when cch.connect_status = 'CLOSE' then to_char(cch.last_update_date,'YYYY-MM-DD') else NULL end close_date,
					date_part('day',case when cch.connect_status = 'CLOSE' then cch.last_update_date else NULL end-cch.connect_date) response_time,
					faq1.faq_type,faq1.faq_description1,faq1.faq_description2
					from cr.cr_connect_headers cch,
					cr.cr_feedbacks_and_questions faq1
					where cch.connect_id = faq1.service_connect_id
					  AND faq1.from_table = 'cr_connect_headers'
					union all
					select csp.customer_id,cr.activity_type(csp.service_type),csp.service_date,
					case when csp.service_status = 'CLOSE' then to_char(csp.last_update_date,'YYYY-MM-DD') else NULL end close_date,
					date_part('day',case when csp.service_status = 'CLOSE' then csp.last_update_date else NULL end-csp.service_date),
					faq2.faq_type,faq2.faq_description1,faq2.faq_description2
					from cr.cr_service_products csp,
					cr.cr_feedbacks_and_questions faq2
					where csp.service_product_id = faq2.service_connect_id
					  AND faq2.from_table = 'cr_service_products') abc
					,cr.vi_cr_customer vcc
				where vcc.customer_id = abc.customer_id
				and abc.open_date between '$start_date' and '$end_date'
				$and1 $and2 $and3
				$sort";
			
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getDataCallIn($customer_id,$city_regency,$unit_id,$line,$faq_type,$operator_id,$start_date,$end_date){
			if($customer_id == ""){
				$and1  = "";
			}else{
				$and1  = "AND cch.customer_id in ($customer_id)";
			}
			if($city_regency == ""){
				$and2  = "";
			}else{
				$and2  = "AND vcc.city_regency_id in ($city_regency)";
			}
			if($unit_id == ""){
				$and3  = "";
			}else{
				$and3  = "AND cch.customer_id in (select customer_id from cr.vi_cr_customer_ownership where item_id in ($unit_id))";
			}
			if($line == ""){
				$and4  = "";
			}else{
				$and4  = "
					AND cch.line_operator = '$line'";
			}
			if($faq_type == ""){
				$and5  = "";
			}else{
				$and5  = "AND cch.connect_id in (select service_connect_id from cr.cr_feedbacks_and_questions 
								where from_table = 'cr_connect_headers' and faq_type in ('$faq_type'))";
			}
			if($operator_id == ""){
				$and6  = "";
			}else{
				$and6  = "AND cch.employee_id = '$operator_id'";
			}
			
			$sql = "SELECT cch.connect_id,cch.connect_number,vcc.customer_name, vcc.city_regency,
						   cch.contact_number,cch.connect_date,cch.line_operator,eaa.employee_name,
						   cch.description,cch.connect_status, 
						   CASE WHEN
							(SELECT count(csp.connect_id)
							FROM cr.vi_cr_service_product_lines vcspl,cr.cr_service_products csp
							WHERE csp.service_product_id = vcspl.service_product_id
							AND csp.connect_id = cch.connect_id
							group by csp.connect_id) > 0 THEN
							(SELECT count(csp.connect_id)
							FROM cr.vi_cr_service_product_lines vcspl,cr.cr_service_products csp
							WHERE csp.service_product_id = vcspl.service_product_id
							AND csp.connect_id = cch.connect_id
							group by csp.connect_id)
							ELSE
							1
							END jumlah,
							(SELECT count(csp.connect_id)
							FROM cr.vi_cr_service_product_lines vcspl,cr.cr_service_products csp
							WHERE csp.service_product_id = vcspl.service_product_id
							AND csp.connect_id = cch.connect_id
							group by csp.connect_id) jumlah_asli
					FROM cr.vi_cr_customer vcc, cr.cr_connect_headers cch
					LEFT JOIN er.er_employee_all eaa on cch.employee_id = eaa.employee_id
					WHERE cch.customer_id = vcc.customer_id
					AND cch.connect_type = 'call_in'
					AND cch.connect_date BETWEEN '$start_date' and '$end_date'
					$and1 $and2 $and3 $and4 $and5 $and6
					order by cch.connect_date,cch.connect_number"
					;
			/*$sql = "SELECT cch.connect_id,cch.connect_number,vcc.customer_name, vcc.city_regency,
						   cch.contact_number,cch.connect_date,cch.line_operator,eaa.employee_name,
						   cch.description,cch.connect_status,vcspl.spare_part||' - '||vcspl.spare_part_name troubled_part,
						   vcspl.action,count(cch.connect_id) OVER (PARTITION BY cch.connect_id)
					FROM cr.vi_cr_customer vcc, 
					cr.cr_connect_headers cch
					LEFT JOIN er.er_employee_all eaa ON cch.employee_id = eaa.employee_id
					LEFT JOIN cr.cr_service_products csp ON cch.connect_id = csp.connect_id 
					LEFT JOIN cr.vi_cr_service_product_lines vcspl on csp.service_product_id = vcspl.service_product_id
					WHERE cch.customer_id = vcc.customer_id
					AND cch.connect_type = 'call_in'
					AND cch.connect_date BETWEEN '$start_date' and '$end_date'
					$and1 $and2 $and3 $and4 $and5 $and6
					order by cch.connect_date,cch.connect_number;"*/
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getRekapPu($province_id,$buying_type,$start_date,$end_date,$sort_by){
			if($province_id == ""){
				$and1  = "";
			}else{
				$and1  = "AND pu.province_id in ($province_id)";
			}
			if($buying_type == ""){
				$and2  = "";
			}else{
				$and2  = "AND pu.buying_type_id in ($buying_type)";
			}
			if($sort_by == "Jumlah"){
				$sort  = "ORDER BY pu.jumlah desc";
			}elseif($sort_by == "Belum dipakai"){
				$sort  = "ORDER BY pu.jlh_blm_dpakai desc";
			}elseif($sort_by == "Belum diketahui"){
				$sort  = "ORDER BY pu.jlh_blm_diketahui desc";
			}elseif($sort_by == "Sudah dipakai"){
				$sort  = "ORDER BY pu.jlh_sudah_dpakai desc";
			}else{
				$sort  = "ORDER BY pu.jlh_rusak desc";
			}

			$sql = "SELECT PU.* FROM
						(SELECT vcco.buying_type_name,vcco.buying_type_id,vcc.province_id,
						vcc.province,count(vcco.customer_ownership_id) jumlah,
							coalesce((select count(blm_dpakai.ownership_id)
							  from 
								(select ccu.ownership_id,vcco0.buying_type_name,vcc0.province
								from  	cr.cr_connect_headers cch,
									cr.cr_connect_units ccu,
									cr.vi_cr_customer_ownership vcco0,
									cr.vi_cr_customer vcc0
								where 1=1
									and cch.connect_id = ccu.connect_id
									and ccu.ownership_id = vcco0.customer_ownership_id
									and vcco0.customer_id = vcc0.customer_id
									AND vcco0.ownership_date between '$start_date' and '$end_date'
									AND cch.connect_date between '$start_date' and '$end_date'
								group by ccu.ownership_id,vcco0.buying_type_name,vcc0.province
								having sum(ccu.use) = 0) blm_dpakai
							where 
								blm_dpakai.buying_type_name = vcco.buying_type_name
								and  blm_dpakai.province = vcc.province
							group by blm_dpakai.buying_type_name,blm_dpakai.province
							having count(blm_dpakai.ownership_id) is not null),0) jlh_blm_dpakai,--belum dipakai
							coalesce((select count(vcco1.customer_ownership_id)
							   FROM cr.vi_cr_customer_ownership vcco1,
								cr.vi_cr_customer vcc1
							  WHERE vcco1.buying_type_name = vcco.buying_type_name
								and vcc1.province = vcc.province
								and vcco1.customer_id = vcc1.customer_id
								AND vcco1.ownership_date between '$start_date' and '$end_date'
								AND vcco1.customer_ownership_id not in 
								(select ccu.ownership_id from cr.cr_connect_headers cch,cr.cr_connect_units ccu
								where cch.connect_id = ccu.connect_id
								and cch.connect_date between '$start_date' and '$end_date'
								group by ccu.ownership_id
								union all
								select cspl.ownership_id from cr.cr_service_products csp,cr.cr_service_product_lines cspl
								where csp.service_product_id = cspl.service_product_id
								and csp.service_date between '$start_date' and '$end_date'
								group by cspl.ownership_id) 
							group by vcco1.buying_type_name,vcc.province),0) jlh_blm_diketahui,--belum diketahui
							coalesce((select count(vcco1.customer_ownership_id)
							   FROM cr.vi_cr_customer_ownership vcco1,
								cr.vi_cr_customer vcc1
							  WHERE vcco1.buying_type_name = vcco.buying_type_name
								and vcc1.province = vcc.province
								and vcco1.customer_id = vcc1.customer_id
							  AND   vcco1.ownership_date between '$start_date' and '$end_date'
							  AND   vcco1.customer_ownership_id in 
								(select ccu.ownership_id from cr.cr_connect_headers cch,cr.cr_connect_units ccu
								  where cch.connect_id = ccu.connect_id
									and cch.connect_date between '$start_date' and '$end_date'
								group by ccu.ownership_id
								  having sum(ccu.use) > 0
								union all
								select cspl.ownership_id from cr.cr_service_products csp,cr.cr_service_product_lines cspl
								 where csp.service_product_id = cspl.service_product_id
								   and csp.service_date between '$start_date' and '$end_date'
								group by cspl.ownership_id)
							group by vcco1.buying_type_name,vcc.province),0) jlh_sudah_dpakai, --sudah dipakai
							coalesce((select count(vcco2.customer_ownership_id)
							   FROM cr.vi_cr_customer_ownership vcco2,
								cr.vi_cr_customer vcc2
							  WHERE vcco2.buying_type_name = vcco.buying_type_name
								and vcc2.province = vcc.province
								and vcco2.customer_id = vcc2.customer_id
							  AND   vcco2.ownership_date between '$start_date' and '$end_date'
							  AND   vcco2.customer_ownership_id in 
								(select cspl.ownership_id from cr.cr_service_products csp,cr.cr_service_product_lines cspl
								where csp.service_product_id = cspl.service_product_id
								and csp.service_date between '$start_date' and '$end_date'
								group by cspl.ownership_id)
							group by vcco2.buying_type_name,vcc.province),0) jlh_rusak --rusak
						FROM cr.vi_cr_customer_ownership vcco,
							cr.vi_cr_customer vcc
						WHERE vcco.customer_id = vcc.customer_id
						AND vcco.ownership_date between '$start_date' and '$end_date'
						
						GROUP BY vcco.buying_type_name,vcc.province,vcco.buying_type_id,vcc.province_id) PU
				WHERE 1=1
				$and1 $and2
				$sort";
			
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getRusak($province_id,$buying_type,$start_date,$end_date){
			if($province_id == ""){
				$and1  = "";
			}else{
				$and1  = "AND rusak.province_id in ($province_id)";
			}
			if($buying_type == ""){
				$and2  = "";
			}else{
				$and2  = "AND rusak.buying_type_id in ($buying_type)";
			}

			$sql = "select rusak.jlh_rusak, count(rusak.customer_name) jlh_unit,rusak.buying_type_name,rusak.province
					from 
						(select count(cspl.spare_part_id) jlh_rusak,vcco2.buying_type_name,vcc.province,
							vcco2.customer_ownership_id,vcc.customer_name,vcco2.buying_type_id,vcc.province_id
						FROM cr.vi_cr_customer_ownership vcco2,
							cr.vi_cr_customer vcc,
							cr.cr_service_product_lines cspl
						WHERE vcco2.customer_id = vcc.customer_id
						AND   vcco2.customer_ownership_id = cspl.ownership_id
						AND   vcco2.ownership_date between '$start_date' and '$end_date'
						group by vcco2.buying_type_name,vcc.province,vcco2.customer_ownership_id,vcc.customer_name,vcco2.buying_type_id,vcc.province_id) rusak
					where 1=1
					$and1 $and2
					group by rusak.jlh_rusak,rusak.buying_type_name,rusak.province
					order by rusak.buying_type_name,rusak.province,rusak.jlh_rusak desc";
			
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		public function getProvinceTotal($province_id,$buying_type,$start_date,$end_date){
			if($province_id == ""){
				$and1  = "";
			}else{
				$and1  = "AND vcc.province_id in ($province_id)";
			}
			if($buying_type == ""){
				$and2  = "";
			}else{
				$and2  = "AND vcco.buying_type_id in ($buying_type)";
			}
			
			$sql = "SELECT '1' sort,vcc.province, count(vcco.customer_ownership_id) total
					FROM 
					cr.vi_cr_customer vcc,
					cr.vi_cr_customer_ownership vcco
					WHERE
					vcco.customer_id = vcc.customer_id
					AND vcco.ownership_date between '$start_date' AND '$end_date'
					$and1 $and2
					group by vcc.province
					union all
					SELECT '2' sort,'Total' province, count(vcco.customer_ownership_id) total
					FROM 
					cr.vi_cr_customer vcc,
					cr.vi_cr_customer_ownership vcco
					WHERE
					vcco.customer_id = vcc.customer_id
					AND vcco.ownership_date between '$start_date' AND '$end_date'
					$and1 $and2
					order by 1,3 desc,2;";
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getCityTotal($province_id,$buying_type,$start_date,$end_date){
			if($province_id == ""){
				$and1  = "";
			}else{
				$and1  = "AND vcc.province_id in ($province_id)";
			}
			if($buying_type == ""){
				$and2  = "";
			}else{
				$and2  = "AND vcco.buying_type_id in ($buying_type)";
			}
			
			$sql = "SELECT vcc.province, vcc.city_regency, count(vcco.customer_ownership_id) total
					FROM 
					cr.vi_cr_customer vcc,
					cr.vi_cr_customer_ownership vcco
					WHERE
					vcco.customer_id = vcc.customer_id
					AND vcco.ownership_date between '$start_date' AND '$end_date'
					$and1 $and2
					group by vcc.province, vcc.city_regency
					order by vcc.province,count(vcco.customer_ownership_id) desc, vcc.city_regency;";
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getProvincePerMonth($province_id,$buying_type,$start_date,$end_date){
			if($province_id == ""){
				$and1  = "";
			}else{
				$and1  = "AND vcc.province_id in ($province_id)";
			}
			if($buying_type == ""){
				$and2  = "";
			}else{
				$and2  = "AND vcco.buying_type_id in ($buying_type)";
			}
			
			$sql = "SELECT province,month_own,sort_month,count(customer_ownership_id) month_total,
					count(sort_month) over(partition by province) total
					FROM 
					(SELECT vcc.province, to_char(vcco.ownership_date,'MON-YY') month_own,
					to_char(vcco.ownership_date,'YYMM') sort_month,vcco.customer_ownership_id
					FROM 
					cr.vi_cr_customer vcc,
					cr.vi_cr_customer_ownership vcco
					WHERE
					vcco.customer_id = vcc.customer_id
					AND vcco.ownership_date between '$start_date' AND '$end_date'
					$and1 $and2
					) unit_prov
					group by province,month_own,sort_month
					union all
					SELECT 'Total' province,month_own,sort_month,count(customer_ownership_id),
					count(sort_month) over() total
					FROM 
					(SELECT vcc.province, to_char(vcco.ownership_date,'MON-YY') month_own,
					to_char(vcco.ownership_date,'YYMM') sort_month,vcco.customer_ownership_id
					FROM 
					cr.vi_cr_customer vcc,
					cr.vi_cr_customer_ownership vcco
					WHERE
					vcco.customer_id = vcc.customer_id
					AND vcco.ownership_date between '$start_date' AND '$end_date'
					$and1 $and2
					) unit_prov
					group by month_own,sort_month
					order by province,sort_month;";
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getCityPerMonth($province_id,$buying_type,$start_date,$end_date){
			if($province_id == ""){
				$and1  = "";
			}else{
				$and1  = "AND vcc.province_id in ($province_id)";
			}
			if($buying_type == ""){
				$and2  = "";
			}else{
				$and2  = "AND vcco.buying_type_id in ($buying_type)";
			}
			
			$sql = "SELECT province,city_regency,month_own,sort_month,count(customer_ownership_id) month_total,
					count(sort_month) over(partition by province,city_regency) total
					FROM 
					(SELECT vcc.province, vcc.city_regency,to_char(vcco.ownership_date,'MON-YY') month_own,
					to_char(vcco.ownership_date,'YYMM') sort_month,vcco.customer_ownership_id
					FROM 
					cr.vi_cr_customer vcc,
					cr.vi_cr_customer_ownership vcco
					WHERE
					vcco.customer_id = vcc.customer_id
					AND vcco.ownership_date between '$start_date' AND '$end_date'
					$and1 $and2
					) unit_prov
					group by province,month_own,sort_month,city_regency
					order by province,city_regency,sort_month;";
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getResponseTime($start_date,$end_date){
			
			$sql = "SELECT vcch.connect_id, vcch.connect_number, vcsp.service_number, 
							vcch.customer_name,vcc.city_regency, vcch.contact_number, to_char(vcch.connect_date,'DD-MM-YY') calling_date, 
							vcch.employee_name as operator, vcch.description as connect_description,cspl.*,
							CASE WHEN cspl.line_status = 'OPEN' THEN
							EXTRACT(epoch from (cspl.action_date-vcch.connect_date))/86400
							ELSE
							EXTRACT(epoch from (COALESCE(
							(select cslh.action_date from cr.cr_service_line_histories cslh 
							where cslh.service_product_line_id = cspl.service_product_line_id
							and cslh.line_status = 'OPEN'),cspl.action_date)-vcch.connect_date))/86400
							END action_time,
							CASE WHEN cspl.line_status = 'CLOSE' THEN
							EXTRACT(epoch from (cspl.action_date-vcch.connect_date))/86400
							ELSE NULL
							END close_time
					FROM cr.vi_cr_connect_headers vcch,cr.vi_cr_customer vcc,
						cr.vi_cr_service_products vcsp,cr.vi_cr_service_product_lines cspl 
					WHERE vcch.connect_type like 'call%'
					AND vcch.customer_id = vcc.customer_id
					AND vcsp.connect_id = vcch.connect_id
					AND vcch.connect_date between '$start_date' and '$end_date'
					AND cspl.service_product_id = vcsp.service_product_id
					ORDER BY action_time desc, calling_date desc;";
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
}