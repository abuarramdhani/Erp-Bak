<?php
class C_Ajax extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('CustomerRelationship/MainMenu/M_serviceproducts');
				$this->load->model('CustomerRelationship/MainMenu/M_customer');
				$this->load->model('CustomerRelationship/MainMenu/M_ownership');
				$this->load->model('EmployeeRecruitment/MainMenu/M_employee');
				$this->load->model('CustomerRelationship/MainMenu/M_customergroup');
				$this->load->model('CustomerRelationship/Setting/M_buyingtype');
				$this->load->model('InventoryManagement/MainMenu/M_item');
				$this->load->model('CustomerRelationship/Setting/M_customercategory');
				$this->load->model('CustomerRelationship/MainMenu/M_customercontacts');
				$this->load->model('CustomerRelationship/Setting/M_customeradditional');
				//$this->load->model('CustomerRelationship/MainMenu/M_servicelinestatus');
				$this->load->model('CustomerRelationship/Setting/M_serviceproblem');
				$this->load->model('CustomerRelationship/Report/M_report');
				$this->load->model('CustomerRelationship/MainMenu/M_customerdriver');
				$this->load->model('SystemAdministration/MainMenu/M_user');
				$this->load->model('SystemAdministration/MainMenu/M_province');
				$this->load->helper('form');
				$this->load->library('form_validation');
				$this->load->library('session');
				$this->load->helper('url');

        }

		//======================================== MODAL PENCARIAN REPORT ===================================================== //

		// Memanggil halaman modal
		public function ModalReport($responsibility_id){
			$data['responsibility_id'] = $responsibility_id;
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Modal/ModalReport',$data);
		}

		// Memanggil halaman result pencarian
		public function ResultReport(){
			$id = strtoupper($this->input->post("id"));
			$responsibility_id = $this->input->post("responsibility");
			$user_id = $this->session->userid;
			// $data['responsibility_id'] = $this->input->post("responsibility");
			$data['Report'] = $this->M_user->getUserReport($id,$responsibility_id,$user_id);
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Result/ResultReport',$data);
		}

		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

		//======================================== MODAL PENCARIAN DATA CUSTOMER ===================================================== //

		// Memanggil halaman modal
		public function ModalCustomer(){
			//$data['Customer'] = $this->M_customer->getCustomer();
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Modal/ModalCustomer');
		}

		// Memanggil halaman result pencarian
		public function ResultCustomer(){
			$id = strtoupper($this->input->post("id"));
			$data['Customer'] = $this->M_customer->getCustomerByName($id);
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Result/ResultCustomer',$data);
		}

		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

		//======================================== MODAL PENCARIAN DATA CUSTOMER BELUM PUNYA CUST GROUP ===================================================== //

		// Memanggil halaman modal
		public function ModalCustomerNoGroup(){
			//$data['Customer'] = $this->M_customer->getCustomer();
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Modal/ModalCustomerNoGroup');
		}

		// Memanggil halaman result pencarian
		public function ResultCustomerNoGroup(){
			$id = strtoupper($this->input->post("id"));
			$data['CustomerNoGroup'] = $this->M_customer->getCustomerNoGroup($id);
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Result/ResultCustomerNoGroup',$data);
		}

		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

		
		//======================================== MODAL PENCARIAN DATA DRIVER ===================================================== //

		// Memanggil halaman modal
		public function ModalDriver(){
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Modal/ModalDriver');
		}

		// Memanggil halaman result pencarian
		public function ResultDriver(){
			$id = strtoupper($this->input->post("id"));
			$data['Driver'] = $this->M_customerdriver->getDriverByName($id);
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Result/ResultDriver',$data);
		}

		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

		//======================================== MODAL PENCARIAN DATA OWNER ===================================================== //

		// Memanggil halaman modal
		public function ModalOwner(){
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Modal/ModalOwner');
		}

		// Memanggil halaman result pencarian
		public function ResultOwner(){
			$id = strtoupper($this->input->post("id"));
			$data['Owner'] = $this->M_customer->getOwnerByName($id);
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Result/ResultOwner',$data);
		}

		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

		//======================================== MODAL PENCARIAN DATA ITEM ===================================================== //

		// Memanggil halaman modal
		public function ModalItem(){
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Modal/ModalItem');
		}
		
		// Memanggil halaman result pencarian
		public function ResultItem(){
			$id = strtoupper($this->input->post("id"));
			$data['Item'] = $this->M_report->getItemLikeIdArray($id);
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Result/ResultItem',$data);
		}
		
		
		public function ModalItemLines($i,$cid){
			$data['i'] = $i;
			$data['cid'] = $cid;
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Modal/ModalItemLines',$data);
		}

		// Memanggil halaman result pencarian
		public function ResultItemLines($i,$cid){
			$id = strtoupper($this->input->post("id"));
			$data['row'] = $i;
			$data['Item'] = $this->M_report->getItemLines($id,$cid);
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Result/ResultItemLines',$data);
		}
		
		
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

		//======================================== MODAL PENCARIAN DATA HARVESTER ===================================================== //

		// Memanggil halaman modal
		public function ModalHarvester(){
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Modal/ModalHarvester');
		}

		// Memanggil halaman result pencarian
		public function ResultHarvester(){
			$id = strtoupper($this->input->post("id"));
			$cust = $this->input->post("cust");
			$data['rowid'] = $rowid;
			$data['Item'] = $this->M_ownership->getOwnershipService($id,$cust);
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Result/ResultHarvester',$data);
		}
		
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

		//======================================== MODAL PENCARIAN DATA SPARE PART ===================================================== //

		// Memanggil halaman modal
		public function ModalSparePart(){
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Modal/ModalSparePart');
		}

		// Memanggil halaman result pencarian
		public function ResultSparePart(){
			$id = strtoupper($this->input->post("id"));
			$data['SparePart'] = $this->M_report->getSPSearchArray($id);
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Result/ResultSparePart',$data);
		}

		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

		//======================================== MODAL PENCARIAN DATA EMPLOYEE ===================================================== //

		// Memanggil halaman modal
		public function ModalEmployee(){
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Modal/ModalEmployee');
		}

		// Memanggil halaman result pencarian
		public function ResultEmployee(){
			$id = strtoupper($this->input->post("id"));
			$data['Employee'] = $this->M_employee->getEmployeeByKey($id);
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Result/ResultEmployee',$data);
		}

		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

		//======================================== MODAL PENCARIAN DATA BUYING TYPE ===================================================== //

		// Memanggil halaman modal
		public function ModalBuyingType(){
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Modal/ModalBuyingType');
		}

		// Memanggil halaman result pencarian
		public function ResultBuyingType(){
			$id = strtoupper($this->input->post("id"));
			$data['BuyingType'] = $this->M_buyingtype->getBuyingTypeByKey($id);
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Result/ResultBuyingType',$data);
		}

		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

		//======================================== MODAL PENCARIAN DATA ADDITIONAL INFO ===================================================== //

		// Memanggil halaman modal
		public function ModalAdditionalInfo(){
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Modal/ModalAdditionalInfo');
		}

		// Memanggil halaman result pencarian
		public function ResultAdditionalInfo(){
			$id = strtoupper($this->input->post("id"));
			$data['AdditionalInfo'] = $this->M_customeradditional->getAdditionalInfoByKey($id);
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Result/ResultAdditionalInfo',$data);
		}

		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

		//======================================== MODAL PENCARIAN DATA CUSTOMER GROUP ===================================================== //

		// Memanggil halaman modal
		public function ModalCustomerGroup(){
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Modal/ModalCustomerGroup');
		}

		// Memanggil halaman result pencarian
		public function ResultCustomerGroup(){
			$id = strtoupper($this->input->post("id")); 
			$data['CustomerGroup'] = $this->M_customergroup->getCustomerGroupByKey($id);
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Result/ResultCustomerGroup',$data);
		}

		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

		//======================================== MODAL PENCARIAN DATA CUSTOMER CATEGORY ===================================================== //

		// Memanggil halaman modal
		public function ModalCustomerCategory(){
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Modal/ModalCustomerCategory');
		}

		// Memanggil halaman result pencarian
		public function ResultCustomerCategory(){
			$id = strtoupper($this->input->post("id"));
			$data['CustomerCategory'] = $this->M_customercategory->getCustomerCategoryByKey($id);
			$this->load->view('CustomerRelationship/Additional/AjaxModal/Result/ResultCustomerCategory',$data);
		}

		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

		//ajax for load regency data based on province id
		public function GetRegency(){
			$id = $this->input->post("id");
			$regency = $this->M_province->getRegencyByProvince($id);
			echo "<option value=''>-- Option --</option>";
			foreach($regency as $rg){
				echo "<option value=".$rg['city_regency_id'].">".strtoupper($rg['regency_name'])."</option>";
			}
		}

		//ajax for load district data based on province id and regency id
		public function GetDistrict(){
			$id = $this->input->post("id");
			$prov_id = $this->input->post("prov_id");
			$district = $this->M_province->getDistrictByRegency($id);
			echo "<option value=''>-- Option --</option>";
			foreach($district as $rg){
				echo "<option value=".$rg['district_id'].">".strtoupper($rg['district_name'])."</option>";
			}
		}

		//ajax for load village data based on province id, regency id, and district_id
		public function GetVillage(){
			$dis_id = $this->input->post("dis_id");
			$reg_id = $this->input->post("reg_id");
			$prov_id = $this->input->post("prov_id");
			$village = $this->M_province->getVillageByDistrict($dis_id);
			echo "<option value=''>-- Option --</option>";
			foreach($village as $rg){
				echo "<option value=".$rg['village_id'].">".strtoupper($rg['village_name'])."</option>";
			}
		}
		
		// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
		// tambahan pencarian
		
		public function GetCustomerProduct(){
			$cust_id = $this->input->post("id");
			$CustomerProduct = $this->M_ownership->getOwnershipService($id=false,$cust_id);
			echo "<option value=''></option>";
			foreach($CustomerProduct as $cp){
				echo "<option value='".$cp['customer_ownership_id']."'>".$cp['item_name']." / ".strtoupper($cp['buying_type_name'])." / ".strtoupper($cp['no_body'])." / ".strtoupper($cp['no_engine'])."</option>";
			}
		}
		
		public function CheckProductWarranty(){
			$cust_id = $this->input->post("id");
			$ownership_id = $this->input->post("item_id");
			
			//echo $cust_id." / ".$item_id;
			
			$CustomerProduct = $this->M_ownership->getOwnershipData($cust_id,$ownership_id);
			foreach($CustomerProduct as $cp){
				$war_date = $cp['warranty_expired_date'];
			}
			
			$now = date('Y-m-d');
			//$diff=date_diff($war_date,$now);
			//echo $diff;
			
			if($war_date == null){
				echo "N";
			}else{
				$date1=date_create($now);
				$date2=date_create($war_date);
				$diff=date_diff($date1,$date2);
				$sign = $diff->format("%R%");
				if($sign == "+"){
					echo "Y";
				}else{
					echo "N";
				}
			}
			
			/*
			echo "<option value=''></option>";
			foreach($CustomerProduct as $cp){
				echo "<option value='".$cp['item_id']."'>".$cp['item_name']."</option>";
			}
			*/
		}
		
		public function SearchCategoryDriver()
		{		
				if (isset($_POST['term'])){
					$term = $_POST['term'];//term = id dari karakter yang kita ketikkan
					if($term == '')
					{	$term = NULL; }
					$data = $this->M_customercategory->getCustomerCategoryDriver($term);
				//echo json_encode($data['AdditionalActivity']);
				}
				echo $data[0]['driver'];
		}
		
		public function ContactNumber()
		{						
				//if (isset($_GET['term'])){
					$term = $_GET['term'];
					$type = $_GET['type'];
					$cust_id = $_GET['cust'];//term = id dari karakter yang kita ketikkan
					if($term == '')
					{	$term = NULL; }
					if($cust_id == '')
					{	$cust_id = FALSE; }
					$data = $this->M_customercontacts->getCustomerContacts(FALSE,$type,$cust_id,$term);
				//echo json_encode($data['AdditionalActivity']);
				//}
				//echo $data;
				echo json_encode($data);
				//print_r($data);
		}
		
		public function GetLastActivityNumber()
		{		
				if (isset($_POST['term'])){
					$term = $_POST['term'];//term = id dari karakter yang kita ketikkan
					if($term == '')
					{	$term = NULL; }
					$data = $this->M_serviceproducts->getLastActivityNumber($term);
				//echo json_encode($data['AdditionalActivity']);
				}
				
				if($term == 'call_in'){
					$head = 'CI';
				}elseif($term == 'call_out'){
					$head = 'CO';
				}elseif($term == 'social'){
					$head = 'SM';
				}elseif($term == 'email'){
					$head = 'EM';
				}elseif($term == 'service_keliling'){
					$head = 'SK';
				}elseif($term == 'customer_visit'){
					$head = 'CV';
				}elseif($term == 'visit_us'){
					$head = 'VU';
				}elseif($term == 'kirim_part'){
					$head = 'KP';
				}
				$year_now = date("y");
				
				if($data != 0){
					$year_activity = substr($data[0]['activity_number'],2,2);
					$running_number = intval($year_now.substr($data[0]['activity_number'],4,4))+1;
					
					if($year_now == $year_activity){
						echo $head.$running_number;
					}else{
						echo $head.$year_now."0001";
					}
					//echo $data[0]['activity_number']." ".$year_now." ".$running_number;
				}else{
					echo $head.$year_now."0001";;
				}
				
		}
}
