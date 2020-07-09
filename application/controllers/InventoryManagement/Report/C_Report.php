<?php
class C_Report extends CI_Controller {
//a
        public function __construct()
        {
                parent::__construct();
                // $this->load->model('CustomerRelationship/Setting/M_buyingtype');
                // $this->load->model('CustomerRelationship/MainMenu/M_customer');
				// $this->load->model('CustomerRelationship/MainMenu/M_customercontacts');
				// $this->load->model('CustomerRelationship/MainMenu/M_customerdriver');
				// $this->load->model('CustomerRelationship/MainMenu/M_ownership');
				// $this->load->model('CustomerRelationship/MainMenu/M_customergroup');
				// $this->load->model('CustomerRelationship/MainMenu/M_customerrelation');
				// $this->load->model('CustomerRelationship/Setting/M_customercategory');
				// $this->load->model('CustomerRelationship/Setting/M_customeradditional');
				// $this->load->model('CustomerRelationship/M_servicelinestatus');
				// $this->load->model('CustomerRelationship/MainMenu/M_serviceproducts');
				// $this->load->model('EmployeeRecruitment/MainMenu/M_employee');
				// $this->load->model('InventoryManagement/MainMenu/M_item');
				$this->load->model('SystemAdministration/MainMenu/M_user');
				// $this->load->model('SystemAdministration/MainMenu/M_province');
				// $this->load->model('SystemAdministration/MainMenu/M_province');
				$this->load->model('InventoryManagement/Report/M_report');
				$this->load->model('InventoryManagement/MainMenu/M_deliveryrequest');
				$this->load->model('InventoryManagement/Setting/M_deliveryrequestapproval');
				$this->load->model('SystemAdministration/MainMenu/M_organization');
				$this->load->helper('form');
				$this->load->library('form_validation');
				$this->load->library('session');
				$this->load->library('Excel/PHPExcel');
				$this->load->helper('url');
				$this->checkSession();
				
				
        }

		public function checkSession(){
			if($this->session->is_logged){

			}else{
				redirect('');
			}
		}
		
		public function format_date($date){
			$ex = explode("/",$date);
			return $ex[2]."-".$ex[1]."-".$ex[0];
		}
		
		public function format_date_start($date){
			$ex = explode(" ",$date);
			if($ex[0] == "Jan"){
				$ex[0] = "1";
			}else if($ex[0] == "Feb"){
				$ex[0] = "2";
			}else if($ex[0] == "Mar"){
				$ex[0] = "3";
			}else if($ex[0] == "Apr"){
				$ex[0] = "4";
			}else if($ex[0] == "May"){
				$ex[0] = "5";
			}else if($ex[0] == "Jun"){
				$ex[0] = "6";
			}else if($ex[0] == "Jul"){
				$ex[0] = "7";
			}else if($ex[0] == "Aug"){
				$ex[0] = "8";
			}else if($ex[0] == "Sep"){
				$ex[0] = "9";
			}else if($ex[0] == "Oct"){
				$ex[0] = "10";
			}else if($ex[0] == "Nov"){
				$ex[0] = "11";
			}else if($ex[0] == "Dec"){
				$ex[0] = "12";
			}
			return $ex[1]."-".$ex[0]."-1";
		}
		
		public function format_date_end($date){
			$ex = explode(" ",$date);
			if($ex[0] == "Jan"){
				$end = 31;
				$ex[0] = "1";
			}else if($ex[0] == "Feb"){
				if($ex[1]%4==0){
					$end = 29;
				}else{
					$end = 28;
				}
				$ex[0] = "2";
			}else if($ex[0] == "Mar"){
				$end = 31;
				$ex[0] = "3";
			}else if($ex[0] == "Apr"){
				$end = 30;
				$ex[0] = "4";
			}else if($ex[0] == "May"){
				$end = 31;
				$ex[0] = "5";
			}else if($ex[0] == "Jun"){
				$end = 30;
				$ex[0] = "6";
			}else if($ex[0] == "Jul"){
				$end = 31;
				$ex[0] = "7";
			}else if($ex[0] == "Aug"){
				$end = 31;
				$ex[0] = "8";
			}else if($ex[0] == "Sep"){
				$end = 30;
				$ex[0] = "9";
			}else if($ex[0] == "Oct"){
				$end = 31;
				$ex[0] = "10";
			}else if($ex[0] == "Nov"){
				$end = 30;
				$ex[0] = "11";
			}else if($ex[0] == "Dec"){
				$end = 31;
				$ex[0] = "12";
			}
			return $ex[1]."-".$ex[0]."-".$end;
		}
		
		public function populate_multiple($all){
			if($all == null){
				$datas = "";
				
			}else{	
				$i=1;
				$datas = "";
				foreach($all as $ap){
					if($i == 1){
						$datas = "'".$ap."'";
					}else{
						$datas = $datas.",'".$ap."'";
					}
					
					$i++;
				}
			}
			return $datas;
		}
		
		public function populate_multiple2($all){
			if($all == null){
				$datas = "";
				
			}else{	
				$i=1;
				$datas = "";
				foreach($all as $ap){
					if($i == 1){
						$datas = $ap;
					}else{
						$datas = $datas.", ".$ap;
					}
					
					$i++;
				}
			}
			return $datas;
		}
		
		public function populate_multiple_province($all){
			if($all == null){
				$datas = "";
				
			}else{	
				$i=1;
				$datas = "";
				foreach($all as $ap){
					if($i == 1){
						$Province = $this->M_province->getProvinceById($ap);
						foreach($Province as $pr){
							$prname = $pr['province_name'];
						}
						$datas = $prname;
					}else{
						$Province = $this->M_province->getProvinceById($ap);
						foreach($Province as $pr){
							$prname = $pr['province_name'];
						}
						$datas = $datas.", ".$prname;
					}
					
					$i++;
				}
			}
			return $datas;
		}
		
		public function populate_multiple_unit($all){
			if($all == null){
				$datas = "";
				
			}else{	
				$i=1;
				$datas = "";
				foreach($all as $ap){
					if($i == 1){
						$Item = $this->M_report->getUnitById($ap);
						foreach($Item as $pr){
							$prname = $pr['item_name'];
						}
						$datas = $prname;
					}else{
						$Item = $this->M_report->getUnitById($ap);
						foreach($Item as $pr){
							$prname = $pr['item_name'];
						}
						$datas = $datas.", ".$prname;
					}
					
					$i++;
				}
			}
			return $datas;
		}
		
		public function changeMonth($a){
			if($a == "Jan"){
				return "1";
			}else if($a == "Feb"){
				return "2";
			}else if($a == "Mar"){
				return "3";
			}else if($a == "Apr"){
				return "4";
			}else if($a == "May"){
				return "5";
			}else if($a == "Jun"){
				return "6";
			}else if($a == "Jul"){
				return "7";
			}else if($a == "Aug"){
				return "8";
			}else if($a == "Sep"){
				return "9";
			}else if($a == "Oct"){
				return "10";
			}else if($a == "Nov"){
				return "11";
			}else if($a == "Dec"){
				return "12";
			}else{
				return "0";
			}
		}
		
		public function returnMonth($a){
			if($a == "1"){
				return "Jan";
			}else if($a == "2"){
				return "Feb";
			}else if($a == "3"){
				return "Mar";
			}else if($a == "4"){
				return "Apr";
			}else if($a == "5"){
				return "May";
			}else if($a == "6"){
				return "Jun";
			}else if($a == "7"){
				return "Jul";
			}else if($a == "8"){
				return "Aug";
			}else if($a == "9"){
				return "Sep";
			}else if($a == "10"){
				return "Oct";
			}else if($a == "11"){
				return "Nov";
			}else if($a == "12"){
				return "Dec";
			}else{
				return "Aaa";
			}
		}
		
		public function createPDF($title,$html){
			//load mPDF library
			$this->load->library('Pdf');
			//actually, you can pass mPDF parameter on this load() function
			$pdf = $this->pdf->load();
			//$this->mpdf = new mPDF();
			$pdf = new mPDF('utf-8','Legal-L', 0, '', 9, 9, 9, 9); 
			//generate the PDF!
			$pdf->WriteHTML($html);
			//offer it to user via browser download! (The PDF won't be saved on your server HDD)
			$pdf->Output($title, "I");
		}
		
		//  ================================================ BAGIAN REPORT REQUEST FULFILLMENT ========================================================//
		
		//  ================================================ BAGIAN REPORT CUSTOMER ========================================================//
		//memanggil halaman report customer
		public function DataPemenuhanRequest(){
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			
			// $data['Customer'] = $this->M_customer->getCustomer();
			
			// $data['province'] = $this->M_customergroup->getAllProvince();
			$data['Org'] = $this->M_organization->getOrganization();

			$this->load->view('V_Header',$data);
			$this->load->view('InventoryManagement/Report/DataPemenuhanRequest/V_data_pemenuhan_request', $data);
			$this->load->view('V_Footer',$data);
		}

		//fungsi export data hasil pencarian ke dalam bentuk excel
		public function ExportDataPemenuhanRequest(){
			$name = strtoupper($this->input->post("txtbyname"));
			$district = strtoupper($this->input->post("txtbydistrict"));
			$city = strtoupper($this->input->post("txtbycity"));
			$province = strtoupper($this->input->post("txtbyprovince"));
			$job = $this->input->post("txtbyjob");
			$cekjob = sizeOf($job);
			if($cekjob == 0){
				$newjob = "NULL";
				$newjob2 = "NULL";
			}else{
				$add = "";
				$add2 = "";
				foreach($job as $jb){
					$add = $add.", ".$jb;
					$add2 = $add2."%".$jb;
				}

				$newjob = substr(strtoupper($add), 2);
				$newjob2 = strtoupper($add2."%");
			}

			$category = $this->input->post("txtbycategory");

			$data['name'] = $name;
			$data['district'] = $district;
			$data['city'] = $city;
			$data['province'] = $province;
			$data['job'] = $newjob;

			if($category != null){
				$cat = $this->M_report->getCategoryById($category);
				foreach($cat as $ct){
					$data['category'] = $ct->customer_category_name;
				}
			}else{
				$data['category'] = $category;
			}


			$data['customer'] = $this->M_report->getCustomerData($name,$district,$city,$province,$newjob2,$category);
			$this->load->view('CustomerRelationship/Report/ReportCustomer/V_cetak_report_customer',$data);

		}


		//  ================================================ BAGIAN REPORT SOLD UNIT ========================================================//
		//memanggil halaman report sold unit
		public function ReportSoldUnit(){
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			
			$data['Customer'] = $this->M_customer->getCustomer();
			
			$data['province'] = $this->M_customergroup->getAllProvince();
			$data['items'] = $this->M_report->getAllItems();

			$this->load->view('V_Header',$data);
			$this->load->view('CustomerRelationship/Report/ReportSoldUnit/V_report_sold_unit', $data);
			$this->load->view('V_Footer',$data);
		}

		//fungsi pencarian dengan ajax
		public function AjaxSoldUnitReport(){
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			
			$item = $this->input->get("item");
			$body_number = $this->input->get("body_number");
			$engine_number = $this->input->get("engine_number");
			$district = $this->input->get("district");
			$city = $this->input->get("city");
			$province = $this->input->get("province");
			$buying_type = $this->input->get("buying_type");
			$owner_name = $this->input->get("customer_name");

			$rangesoldunit = $this->input->get("rangesoldunit");
			if($rangesoldunit == null){
				$startdate = null;
				$enddate = null;
			}else{
				$rsu = explode(' - ',$rangesoldunit);

				$exstart = explode('/',$rsu[0]);
				$startdate = $exstart[2]."-".$exstart[1]."-".$exstart[0];

				$exend = explode('/',$rsu[1]);
				$enddate = $exend[2]."-".$exend[1]."-".$exend[0];
			}

			//echo "Start : ".$startdate."<br />";
			//echo "End   : ".$enddate."<br />";
			$data['soldunit'] = $this->M_report->getSoldUnitData($item,$body_number,$engine_number,$district,$city,$province,$buying_type,$owner_name,$startdate,$enddate);

			$this->load->view("CustomerRelationship/Report/ReportSoldUnit/V_ajax_report_sold_unit",$data);
		}

		//fungsi export report sold unit dalam bentuk excel
		public function ExportSoldUnitReport(){
			$item_name = strtoupper($this->input->post("txtbyitem"));
			$body_number = strtoupper($this->input->post("txtbybodynumber"));
			$engine_number = strtoupper($this->input->post("txtbyenginenumber"));
			$district = strtoupper($this->input->post("txtbydistrict"));
			$city = strtoupper($this->input->post("txtbycity"));
			$province = strtoupper($this->input->post("txtbyprovince"));
			$buying_type = strtoupper($this->input->post("txtbybuyingtype"));
			$owner_name = strtoupper($this->input->post("txtbyownername"));
			$rangesoldunit = strtoupper($this->input->post("txtbyrangesoldunit"));
			if($rangesoldunit == null){
				$startdate = null;
				$enddate = null;
			}else{
				$rsu = explode(' - ',$rangesoldunit);

				$exstart = explode('/',$rsu[0]);
				$startdate = $exstart[2]."-".$exstart[1]."-".$exstart[0];

				$exend = explode('/',$rsu[1]);
				$enddate = $exend[2]."-".$exend[1]."-".$exend[0];
			}

			if($item_name == null){
				$data['item_name'] = $item_name;
			}else{
				$itemById = $this->M_report->getItemById($item_name);
				foreach($itemById as $ib){
					$data['item_name'] = $ib->item_name;
				}
			}
			$data['body_number'] = $body_number;
			$data['engine_number'] = $engine_number;
			$data['district'] = $district;
			$data['city'] = $city;
			$data['province'] = $province;
			$data['buying_type_name'] = $buying_type;
			$data['customer_name'] = $owner_name;
			$data['rangesoldunit'] = $rangesoldunit;

			//echo $startdate."<br />";
			//echo $enddate."<br />";
			$data['soldunit'] = $this->M_report->getSoldUnitData($item_name,$body_number,$engine_number,$district,$city,$province,$buying_type,$owner_name,$startdate,$enddate);

			$this->load->view("CustomerRelationship/Report/ReportSoldUnit/V_cetak_report_sold_unit",$data);
		}


		//  ================================================ BAGIAN REPORT TROUBLED PART ========================================================//
		//memanggil halaman report troubled part
		public function ReportTroubledPart(){
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['Customer'] = $this->M_customer->getCustomer();
			
			$data['province'] = $this->M_customergroup->getAllProvince();
			$data['sparePart'] = $this->M_report->getAllSparePart();
			$data['items'] = $this->M_report->getAllItems();
			$data['problem'] = $this->M_report->getAllProblem();
			$this->load->view('V_Header',$data);
			$this->load->view('CustomerRelationship/Report/ReportTroubledPart/V_report_troubled_part', $data);
			$this->load->view('V_Footer',$data);
		}

		//menanggil fungsi pencarian ajax untuk report troubled part
		public function AjaxTroubledPartReport(){
			$item = $this->input->get("item");
			$spare_part = $this->input->get("spare_part");
			$body_number = $this->input->get("body_number");
			$category = $this->input->get("category");
			/*
			echo $spare_part."<br />";
			echo $item."<br />";
			echo $body_number."<br />";
			echo $category."<br />";
			*/
			$data['troubledPart'] = $this->M_report->getTroubledPartData($item,$spare_part,$body_number,$category);
			//$data['tes'] = "yahalooooo";
			$this->load->view("CustomerRelationship/Report/ReportTroubledPart/V_ajax_report_troubled_part",$data);
		}

		//fungsi export report troubled part dalam bentuk excel
		public function ExportTroubledPartReport(){
			$item = strtoupper($this->input->post("txtbyitem"));
			$spare_part = strtoupper($this->input->post("txtbysparepart"));
			$body_number = strtoupper($this->input->post("txtbybodynumber"));
			$category = strtoupper($this->input->post("txtbycategory"));
			/*
			echo $item."<br />";
			echo $spare_part."<br />";
			echo $body_number."<br />";
			echo $category."<br />";
			*/
			if($item == null){
				$data['item'] = $item;
			}else{
				$itemById = $this->M_report->getItemById($item);
				foreach($itemById as $ib){
					$data['item'] = $ib->item_name;
				}
			}

			if($spare_part == null){
				$data['spare_part'] = $spare_part;
			}else{
				$spById = $this->M_report->getItemById($spare_part);
				foreach($spById as $sb){
					$data['spare_part'] = $sb->item_name;
				}
			}

			$data['body_number'] = $body_number;
			$data['category'] = $category;

			$data['troubledPart'] = $this->M_report->getTroubledPartData($item,$spare_part,$body_number,$category);

			$this->load->view("CustomerRelationship/Report/ReportTroubledPart/V_cetak_report_troubled_part",$data);
		}

		//  ================================================ BAGIAN REPORT MONITORING PROGRAM ========================================================//
		//memanggil halaman report monitoring program
		
		public function MonitoringProgram(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			$data['Customer'] = $this->M_customer->getCustomer();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['Customer'] = $this->M_customer->getCustomer();
			$data['province'] = $this->M_province->getAllProvinceArea();
			$data['buyingtype'] = $this->M_buyingtype->getAllBuyingType();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportMonitoringProgram/V_report_monitoring_program', $data);
			$this->load->view('V_Footer',$data);
			
		}
		
		public function ExportReportMonitoringProgram(){
			$ownership_date = $this->input->post("txtPeriod");
			$start_period = $this->input->post("txtStartProgram");
			$end_period = $this->input->post("txtEndProgram");
			$program = $this->input->post("txtProgram");
			$list_province_id = $this->input->post("txtArea");
			$list_buying_type = $this->input->post("txtBuyingType");
			
			if($program == ""){
				$data['program'] = "-";
			}else{
				if($program == "call_out"){
					$data['program'] = "CALL OUT";
				}else{
					$data['program'] = "CUSTOMER VISIT";
				}
			}
			
			if($ownership_date == ""){
				$start_ownership_date = "";
				$end_ownership_date = "";
				$data['start_ownership_date'] = $start_ownership_date;
				$data['end_ownership_date'] = $end_ownership_date;
				$start_date = "1965-01-01";
				$end_date = "2100-12-31";
			}else{
				$ex_per = explode(" - ",$ownership_date);
				$start = $ex_per[0]; 
				$start_ownership_date = $this->format_date($start);
				$end = $ex_per[1]; 
				$end_ownership_date = $this->format_date($end);
				$data['start_ownership_date'] = $start_ownership_date;
				$data['end_ownership_date'] = $end_ownership_date;
			}
			
			$start1 = $this->input->post('txtStartProgram');
			$exstart = explode(' ',$start1);
			$monthStart = $exstart[0];
			$yearStart = $exstart[1];
			$start_date = $this->format_date_start($start1);
			$data['month_from'] = $monthStart."-".$yearStart;
			
			$end1 = $this->input->post('txtEndProgram');
			$exend = explode(' ',$end1);
			$monthEnd = $exend[0];
			$yearEnd = $exend[1];
			$nend = $this->changeMonth($monthEnd);
			$end_date = $this->format_date_end($end1);
			$data['month_to'] =  $monthEnd."-".$yearEnd;
			
			$month_start_date = date('ym', strtotime($start_date));
			$month_end_date = date('ym', strtotime($end_date));
			$total_month = ((intval(substr($month_end_date, 0, 2))-intval(substr($month_start_date, 0, 2)))*12)+
							(intval(substr($month_end_date, 2, 2))-intval(substr($month_start_date, 2, 2)));
				
			if($list_province_id !=""){
				$province_id = implode(',', $list_province_id);
				$province = $this->M_province->getAllProvinceArea($province_id);
				foreach($province as $key=>$provinces){
					$province_list[] = $provinces['province_name'];
				}
				
				$province_name = implode(', ', $province_list);
				$data['province_chosen'] = $province_name;
			}else{
				$province_id = "";
				$data['province_chosen'] = "-";
			}
			
			if($list_buying_type !=""){
				$buying_type = implode(',', $list_buying_type);
				$buying_types = $this->M_buyingtype->getBuyingTypes($buying_type);
				foreach($buying_types as $key=>$values){
					$buying_types_list[] = $values['buying_type_name'];
				}
				$buying_types_name = implode(', ', $buying_types_list);
				$data['buying_type'] = $buying_types_name;
			}else{
				$buying_type = "";
				$data['buying_type'] = "-";
			}
			
			$data['total_month'] = $total_month;
			$data['MonthYear'] = $this->M_report->getMonthYear($start_date,$total_month);
			$data['CustomerOwnership'] = $this->M_report->getCustomerOwnership($start_date,$end_date,$start_ownership_date,$end_ownership_date,$province_id,$program,$buying_type);
			$data['ProgramMonth'] = $this->M_report->getProgramMonth($start_date,$end_date,$program);
			$data['ProgramWeek'] = $this->M_report->getProgramWeek($start_date,$end_date,$program);
			$this->load->view('CustomerRelationship/Report/ReportMonitoringProgram/V_export_monitoring_program',$data);
			
			$html=$this->load->view('CustomerRelationship/Report/ReportMonitoringProgram/V_export_monitoring_program', $data, true); 
		
			//Call PDF function
			$this->createPDF('ReportMonitoringProgram.pdf',$html);
				// echo $start_date;
		}
		
		//  ================================================ BAGIAN REPORT DATA CUSTOMER VISIT ========================================================//
		//memanggil halaman report monitoring program
		
		public function DataCustomerVisit(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			$data['Customer'] = $this->M_customer->getCustomer();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['Customer'] = $this->M_customer->getCustomer();
			$data['province'] = $this->M_province->getAllProvinceArea();
			$data['buyingtype'] = $this->M_buyingtype->getAllBuyingType();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportDataCustomerVisit/V_report_data_customer_visit', $data);
			$this->load->view('V_Footer',$data);
			
		}
		
		public function ExportReportDataCustomerVisit(){
			//$data['tes'] = "tes";
			$period = $this->input->post("txtPeriod");
			$list_buying_type = $this->input->post("txtBuyingType");
			$list_city = $this->input->post("txtArea");
			if($period == null){
				$start_date = "";
				$end_date = "";
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
				$start_date = "1965-01-01";
				$end_date = "2100-12-31";
			}else{
				$ex_per = explode(" - ",$period);
				$start = $ex_per[0]; 
				$start_date = $this->format_date($start);
				$end = $ex_per[1]; 
				$end_date = $this->format_date($end);
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
			}
			if($list_city !=""){
				$city_id = implode(',', $list_city);
				$city = $this->M_province->getRegencies($city_id);
				foreach($city as $key=>$cities){
					$city_list[] = $cities['regency_name'];
				}
				
				$city_name = implode(', ', $city_list);
				$data['city_chosen'] = $city_name;
			}else{
				$city_id = FALSE;
				$data['city_chosen'] = "-";
			}
			if($list_buying_type !=""){
				$buying_type = implode(',', $list_buying_type);
				$buying_types = $this->M_buyingtype->getBuyingTypes($buying_type);
				foreach($buying_types as $key=>$values){
					$buying_types_list[] = $values['buying_type_name'];
				}
				$buying_types_name = implode(', ', $buying_types_list);
				$data['buying_type'] = $buying_types_name;
			}else{
				$buying_type = "";
				$data['buying_type'] = "-";
			}
			$data['CustomerVisit'] = $this->M_report->getCustomerVisitData($city_id,$buying_type,$start_date,$end_date);
			// foreach($data['CustomerVisit'] as $cust_visit){
				// $list_cust_visit[] = $cust_visit['service_product_id'];
			// }
			// $cust_visit_id = implode(",",$list_cust_visit);
			// $data['TroubledPart'] = $this->M_serviceproducts->getServiceProductLines($cust_visit_id);
			// $data['CustomerResponse'] = $this->M_serviceproducts->getServiceProductFaqs($cust_visit_id,'cr_service_products');
			// $data['AdditionalActivity'] = $this->M_serviceproducts->getServiceProductAddAct($cust_visit_id,FALSE);
			//$this->load->view('CustomerRelationship/Report/ReportDataCustomerVisit/V_export_data_customer_visit',$data);
			//$html=$this->load->view('CustomerRelationship/Report/ReportDataCustomerVisit/V_export_data_customer_visit',$data,true); 
			print_r($data['CustomerVisit']);
			//Call PDF function
			//$this->createPDF('DataCustomerVisit.pdf',$html);
		}
		
		//  ================================================ BAGIAN REPORT REKAP CUSTOMER VISIT ========================================================//
		//memanggil halaman report monitoring program
		
		public function RekapCustomerVisit(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			//$data['Customer'] = $this->M_customer->getCustomer();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['Customer'] = $this->M_customer->getCustomer();
			//$data['province'] = $this->M_province->getAllProvinceArea();
			//$data['buyingtype'] = $this->M_buyingtype->getAllBuyingType();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportRekapCustomerVisit/V_report_rekap_customer_visit', $data);
			$this->load->view('V_Footer',$data);
			
		}
		
		public function ExportReportRekapCustomerVisit(){
			
			$period = $this->input->post("txtPeriod");
			if($period == null){
				$start_date = "";
				$end_date = "";
			}else{
				$ex_per = explode(" - ",$period);
				$start = $ex_per[0]; 
				$start_date = $this->format_date($start);
				$end = $ex_per[1]; 
				$end_date = $this->format_date($end);
			}
			$data['start_date'] = $start_date;
			$data['end_date'] = $end_date;
			$data['Activity'] = $this->M_report->RekapCustomerVisit('Activity',$start_date,$end_date);
			$data['CityRegency'] = $this->M_report->RekapCustomerVisit('CityRegency',$start_date,$end_date);
			$data['Province'] = $this->M_report->RekapCustomerVisit('Province',$start_date,$end_date);
			$data['Month'] = $this->M_report->RekapCustomerVisit('Month',$start_date,$end_date);
			$html=$this->load->view('CustomerRelationship/Report/ReportRekapCustomerVisit/V_export_rekap_customer_visit',$data,true);
			$this->createPDF('Report Rekap Customer Visit.pdf',$html);
		}
		
		//  ================================================ BAGIAN REPORT DATA CALL OUT ========================================================//
		//memanggil halaman report monitoring program
		
		public function DataCallOut(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			//$data['Customer'] = $this->M_customer->getCustomer();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['province'] = $this->M_province->getAllProvinceArea();
			$data['buyingtype'] = $this->M_buyingtype->getAllBuyingType();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportDataCallOut/V_report_data_call_out', $data);
			$this->load->view('V_Footer',$data);
			
		}
		
		public function ExportReportDataCallOut(){
			$period = $this->input->post("txtPeriod");
			$list_buying_type = $this->input->post("txtBuyingType");
			$list_area = $this->input->post("txtArea");
			if($period == null){
				$start_date = "";
				$end_date = "";
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
				$start_date = "1965-01-01";
				$end_date = "2100-12-31";
			}else{
				$ex_per = explode(" - ",$period);
				$start = $ex_per[0]; 
				$start_date = $this->format_date($start);
				$end = $ex_per[1]; 
				$end_date = $this->format_date($end);
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
			}
			
			if($list_area !=""){
				$area_id = implode(',', $list_area);
				$area = $this->M_province->getRegencyAndProvince($area_id);
				foreach($area as $key=>$cities){
						$city_name_list[] = $cities['province_name'];
					}
				$area = $this->M_province->getRegencyByRegencyProvince($area_id);
				foreach($area as $key=>$cities){
						$city_list[] = $cities['city_regency_id'];
					}
				$city_name = implode(', ', $city_name_list);
				$city_id = implode(', ', $city_list);
				$data['city_chosen'] = $city_name;
			}else{
				$city_id = FALSE;
				$data['city_chosen'] = "-";
			}
			if($list_buying_type !=""){
				$buying_type = implode(',', $list_buying_type);
				$buying_types = $this->M_buyingtype->getBuyingTypes($buying_type);
				foreach($buying_types as $key=>$values){
					$buying_types_list[] = $values['buying_type_name'];
				}
				$buying_types_name = implode(', ', $buying_types_list);
				$data['buying_type'] = $buying_types_name;
			}else{
				$buying_type = "";
				$data['buying_type'] = "-";
			}
			
			//$data['CallOut'] = $this->M_report->getDataCallOut($city_id,$start_date,$end_date);
			$data['CallOut'] = $this->M_report->getDataCallOut($city_id,$start_date,$end_date,$buying_type);
			foreach($data['CallOut'] as $key=>$id){
					$connect_id[] = $id['connect_id'];
			}
				
			$connect_ids = implode(', ', $connect_id);
			$data['CustomerResponse'] = $this->M_report->getServiceFaqs($connect_ids);
			$this->load->view('CustomerRelationship/Report/ReportDataCallOut/V_export_data_call_out',$data);
			$html=$this->load->view('CustomerRelationship/Report/ReportDataCallOut/V_export_data_call_out',$data,true);
			$this->createPDF('Report Data Call Out.pdf',$html);
			//print_r($data['Faqs']);
			//echo $list_buying_type;
		}
		
		//  ================================================ BAGIAN REPORT REKAP CALL OUT ========================================================//
		//memanggil halaman report monitoring program
		
		public function RekapCallOut(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			//$data['Customer'] = $this->M_customer->getCustomer();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			//$data['province'] = $this->M_province->getAllProvinceArea();
			//$data['buyingtype'] = $this->M_buyingtype->getAllBuyingType();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportRekapCallOut/V_report_rekap_call_out', $data);
			$this->load->view('V_Footer',$data);
			
		}
		
		public function ExportReportRekapCallOut(){
			//$data['tes'] = "tes";
			$period = $this->input->post("txtPeriod");
			$list_province_id = $this->input->post("txtProvince");
			if($period == null){
				$start_date = "";
				$end_date = "";
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
				$start_date = "1965-01-01";
				$end_date = "2100-12-31";
			}else{
				$ex_per = explode(" - ",$period);
				$start = $ex_per[0]; 
				$start_date = $this->format_date($start);
				$end = $ex_per[1]; 
				$end_date = $this->format_date($end);
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
			}
			if($list_province_id !=""){
				$province_id = implode(',', $list_province_id);
				$province = $this->M_province->getAllProvinceArea($province_id);
				foreach($province as $key=>$provinces){
					$province_list[] = $provinces['province_name'];
				}
				
				$province_name = implode(', ', $province_list);
				$data['province_chosen'] = $province_name;
			}else{
				$province_id = FALSE;
				$data['province_chosen'] = "-";
			}			
			
			$data['CityRegency'] = $this->M_report->RekapCallOut('CityRegency',$province_id,$start_date,$end_date);
			$data['Province'] = $this->M_report->RekapCallOut('Province',$province_id,$start_date,$end_date);
			
			$html=$this->load->view('CustomerRelationship/Report/ReportRekapCallOut/V_export_rekap_call_out',$data,true);;
			$this->createPDF('Report Rekap Call Out.pdf',$html);
		}
		
		//================================================ BAGIAN REPORT MONITORING MASA PANEN ========================================================//
		//memanggil halaman report monitoring program
		
		public function MonitoringMasaPanen(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			$data['Customer'] = $this->M_customer->getCustomer();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['province'] = $this->M_province->getAllProvinceArea();
			$data['buyingtype'] = $this->M_buyingtype->getAllBuyingType();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportMonitoringMasaPanen/V_report_monitoring_masa_panen', $data);
			$this->load->view('V_Footer',$data);
			
		}
		
		public function ExportReportMonitoringMasaPanen(){
			//$data['tes'] = "tes";
			$period = $this->input->post("txtPeriod");
			$list_buying_type = $this->input->post("txtBuyingType");
			$list_city = $this->input->post("txtArea");
			$filter = $this->input->post("txtFilter");
			if($period == null){
				$start_date = "";
				$end_date = "";
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
				$start_date = "2014-01-01";
				$end_date = "2015-12-31";
			}else{
				$ex_per = explode(" - ",$period);
				$start = $ex_per[0]; 
				$start_date = $this->format_date($start);
				$end = $ex_per[1]; 
				$end_date = $this->format_date($end);
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
			}
			if($list_city !=""){
				$city_id = implode(',', $list_city);
				$city = $this->M_province->getRegencies($city_id);
				foreach($city as $key=>$cities){
					$city_list[] = $cities['regency_name'];
				}
				
				$city_name = implode(', ', $city_list);
				$data['city_chosen'] = $city_name;
			}else{
				$city_id = FALSE;
				$data['city_chosen'] = "-";
			}
			if($list_buying_type !=""){
				$buying_type = implode(',', $list_buying_type);
				$buying_types = $this->M_buyingtype->getBuyingTypes($buying_type);
				foreach($buying_types as $key=>$values){
					$buying_types_list[] = $values['buying_type_name'];
				}
				$buying_types_name = implode(', ', $buying_types_list);
				$data['buying_type'] = $buying_types_name;
			}else{
				$buying_type = "";
				$data['buying_type'] = "-";
			}
			$data['filter'] = $filter;
			$month_start_date = date('ym', strtotime($start_date));
			$month_end_date = date('ym', strtotime($end_date));
			$total_month = ((intval(substr($month_end_date, 0, 2))-intval(substr($month_start_date, 0, 2)))*12)+
							(intval(substr($month_end_date, 2, 2))-intval(substr($month_start_date, 2, 2)));
			$data['total_month'] = $total_month;
			$data['MonthYear'] = $this->M_report->getMonthYear($start_date,$total_month);
			$data['MasaPanen'] = $this->M_report->getMasaPanen($city_id,$buying_type,$start_date,$end_date,$filter);
			$data['CustomerResponse'] = $this->M_serviceproducts->getServiceProductFaqs(FALSE,'cr_service_products');
			//$this->load->view('CustomerRelationship/Report/ReportMonitoringMasaPanen/V_export_monitoring_masa_panen',$data);
			$html =$this->load->view('CustomerRelationship/Report/ReportMonitoringMasaPanen/V_export_monitoring_masa_panen',$data,true);
			
			$this->createPDF('MonitoringMasaPanen.pdf',$html);
		}
		
		//  ================================================ BAGIAN REPORT DATA SERVICE KELILING ========================================================//
		//memanggil halaman report monitoring program
		
		public function DataServiceKeliling(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			$data['Customer'] = $this->M_customer->getCustomer();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['province'] = $this->M_province->getAllProvinceArea();
			$data['buyingtype'] = $this->M_buyingtype->getAllBuyingType();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportDataServiceKeliling/V_report_data_service_keliling', $data);
			$this->load->view('V_Footer',$data);
			
		}
		
		public function ExportReportDataServiceKeliling(){
			$period = $this->input->post("txtPeriod");
			if($period == null){
				$start = "";
				$end = "";
				$data['start_date'] = "-";
				$data['end_date'] = "-";
			}else{
				$ex_per = explode(" - ",$period);
				$start = $ex_per[0]; 
				$ex_st = explode("/",$start);
				$start = $ex_st[2]."-".$ex_st[1]."-".$ex_st[0];
				$end = $ex_per[1]; 
				$ex_ed = explode("/",$end);
				$end = $ex_ed[2]."-".$ex_ed[1]."-".$ex_ed[0];
				$data['start_date'] = $start;
				$data['end_date'] = $end;
			}
			$city = $this->input->post("txtArea");
			if($city == null){
				$allcity = "";
				$data['city_chosen'] = "-";
			}else{	
				$i=1;
				$allcity = "";
				foreach($city as $ct){
					if($i == 1){
						$allcity = "'".$ct."'";
					}else{
						$allcity = $allcity.",'".$ct."'";
					}
					
					$i++;
				}
				$city = $this->M_province->getRegencies($allcity);
				foreach($city as $key=>$cities){
					$city_list[] = $cities['regency_name'];
				}
				
				$city_name = implode(', ', $city_list);
				$data['city_chosen'] = $city_name;
			}
			//echo $allcity;
			
			$data['AllServiceKeliling'] = $this->M_report->getAllServiceKeliling($allcity,$start,$end);
			$data['AllServiceKelilingUnit'] = $this->M_report->getAllServiceKelilingUnit();
			$data['AllServiceKelilingResponse'] = $this->M_report->getAllServiceKelilingResponse();
			
			$html=$this->load->view('CustomerRelationship/Report/ReportDataServiceKeliling/V_export_data_service_keliling',$data, true);
			
			
			//Call PDF function
			$this->createPDF('tes.pdf',$html);
		}
		
		//  ================================================ BAGIAN REPORT REKAP SERVICE KELILING ========================================================//
		//memanggil halaman report monitoring program
		
		public function RekapServiceKeliling(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			$data['Customer'] = $this->M_customer->getCustomer();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['province'] = $this->M_province->getAllProvinceArea();
			$data['buyingtype'] = $this->M_buyingtype->getAllBuyingType();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportRekapServiceKeliling/V_report_rekap_service_keliling', $data);
			$this->load->view('V_Footer',$data);
			
		}
		
		public function ExportReportRekapServiceKeliling(){
			$data['tes'] = "tess";
			$period = $this->input->post("txtPeriod");
			$city = $this->input->post("txtArea");
			$sort_by = $this->input->post("txtSortBy");
			if($period == null){
				$start_date = "";
				$end_date = "";
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
				$start_date = "1965-01-01";
				$end_date = "2100-12-31";
			}else{
				$ex_per = explode(" - ",$period);
				$start = $ex_per[0]; 
				$start_date = $this->format_date($start);
				$end = $ex_per[1]; 
				$end_date = $this->format_date($end);
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
			}
			
			if($city !=""){
				$city_id = implode(',', $city);
				$city = $this->M_province->getRegencies($city_id);
				foreach($city as $key=>$cities){
					$city_list[] = $cities['regency_name'];
				}
				
				$city_name = implode(', ', $city_list);
				$data['city_chosen'] = $city_name;
			}else{
				$city_id = FALSE;
				$data['city_chosen'] = "-";
			}
			
			$data['RekapServiceKeliling'] = $this->M_report->getRekapServiceKeliling($start_date,$end_date,$city_id,$sort_by);
			$html = $this->load->view('CustomerRelationship/Report/ReportRekapServiceKeliling/V_export_rekap_service_keliling', $data,true);
			
			$this->createPDF('RekapServiceKeliling.pdf',$html);
		}
		//  ================================================ BAGIAN REPORT DATA CALL IN ========================================================//
		//memanggil halaman report monitoring program
		
		public function DataCallIn(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			$data['Customer'] = $this->M_customer->getCustomer();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['province'] = $this->M_province->getAllProvinceArea();
			$data['buyingtype'] = $this->M_buyingtype->getAllBuyingType();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportDataCallIn/V_report_data_call_in', $data);
			$this->load->view('V_Footer',$data);
			
		}
		
		public function ExportReportDataCallIn(){
			$data['tes'] = "tes";
			$period = $this->input->post("txtPeriod");
			$customer_id = $this->input->post("txtCustomer");
			$list_city = $this->input->post("txtArea");
			$unit_id = $this->input->post("txtBuyingType");
			$line = $this->input->post("txtLine");
			$faq_type = $this->input->post("txtResponse");
			$operator_id = (int)$this->input->post("txtOperator");
			if($period == null){
				$start_date = "";
				$end_date = "";
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
				$start_date = "1965-01-01";
				$end_date = "2100-12-31";
			}else{
				$ex_per = explode(" - ",$period);
				$start = $ex_per[0]; 
				$start_date = $this->format_date($start);
				$end = $ex_per[1]; 
				$end_date = $this->format_date($end);
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
			}
			if($customer_id !=""){
				$customer_id2 = implode(',', $customer_id);
				$customer = $this->M_customer->getCustomer($customer_id2,'INTEGER');
				foreach($customer as $key=>$customers){
					$cust_list[] = $customers['customer_name'];
				}
				
				$cust_name = implode(', ', $cust_list);
				$data['customer'] = $customer_id2;
			}else{
				$customer_id2 = FALSE;
				$data['customer'] = "-";
			}
			if($list_city !=""){
				$city_id = implode(',', $list_city);
				$city = $this->M_province->getRegencies($city_id);
				foreach($city as $key=>$cities){
					$city_list[] = $cities['regency_name'];
				}
				
				$city_name = implode(', ', $city_list);
				$data['city_chosen'] = $city_name;
			}else{
				$city_id = FALSE;
				$data['city_chosen'] = "-";
			}
			if($unit_id !=""){
				$unit_id2 = implode(',', $unit_id);
				$unit = $this->M_item->getItemId($unit_id2);
				foreach($unit as $key=>$values){
					$unit_list[] = $values['item_name'];
				}
				$unit_list_name = implode(', ', $unit_list);
				$data['unit'] = $unit_list_name;
			}else{
				$unit = "";
				$data['unit'] = "-";
			}
			if($faq_type !=""){
				$faq_type_name = implode('\',\'', $faq_type);
				$data['faq_type'] = $faq_type_name;
			}else{
				$data['faq_type'] = "-";
			}
			if($operator_id !=""){
				$operator = $this->M_employee->getEmployee($operator_id);
				foreach($operator as $key=>$values){
					$operator_list[] = $values['employee_name'];
				}
				$operator_list_name = implode(', ', $operator_list);
				$data['operator'] = $operator_list_name;
			}else{
				$operator_id = "";
				$data['operator'] = "-";
			}
			if($line !=""){
				$data['line'] = $line;
			}else{
				$data['line'] = "-";
			}
			$data['CallIn'] = $this->M_report->getDataCallIn($customer_id2,$city_id,$unit_id,$line,$faq_type_name,$operator_id,$start_date,$end_date);
			$data['TroubledPart'] = $this->M_serviceproducts->getServiceProductLines();
			$data['CustomerResponse'] = $this->M_serviceproducts->getServiceProductFaqs(FALSE,'cr_connect_headers');
			//$this->load->view('CustomerRelationship/Report/ReportDataCallIn/V_export_data_call_in',$data);
			$html = $this->load->view('CustomerRelationship/Report/ReportDataCallIn/V_export_data_call_in',$data,true);
			
			$this->createPDF('DataCallIn.pdf',$html);
		}
		
		//  ================================================ BAGIAN REPORT DATA TROUBLED PART ========================================================//
		//memanggil halaman report monitoring program
		
		public function DataTroubledPart(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			$data['Customer'] = $this->M_customer->getCustomer();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['province'] = $this->M_province->getAllProvinceArea();
			$data['buyingtype'] = $this->M_buyingtype->getAllBuyingType();
			// $data['ServiceLineStatus'] = $this->M_servicelinestatus->getServiceLineStatus();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportDataTroubledPart/V_report_data_troubled_part', $data);
			$this->load->view('V_Footer',$data);
			
		}
			
		public function ExportReportDataTroubledPart(){
			$status = $this->input->post("txtStatus");
			if($status == ""){
				$statusname = "";
			}else{
				$Stt = $this->M_servicelinestatus->getServiceLineStatusById($status);
				foreach($Stt as $st){
					$statusname = $st['service_line_status_name'];
				}
			}
			$technician = $this->input->post("txtTechnician");
			if($technician == ""){
				$employeename = "";
			}else{
				$Tech = $this->M_employee->getEmployeeById($technician);
				foreach($Tech as $te){
					$employeename = $te['employee_name'];
				}
			}
			$sparepart = $this->input->post("txtSparePart");
			if($sparepart == ""){
				$spname = "";
			}else{
				$Item = $this->M_report->getUnitById($sparepart);
				foreach($Item as $pr){
					$spname = $pr['item_name'];
				}
			}
			$customername = $this->input->post("txtCustomerName");
			$bodynumber = $this->input->post("txtBodyNumber");
			$period = $this->input->post("txtPeriod");
			if($period == null){
				$start = "";
				$end = "";
			}else{
				$ex_per = explode(" - ",$period);
				$start = $ex_per[0]; 
				$start = $this->format_date($start);
				$end = $ex_per[1]; 
				$end = $this->format_date($end);
			}
			$allprovince = $this->input->post("txtProvince");
			$province = $this->populate_multiple($allprovince);
			$province2 = $this->populate_multiple_province($allprovince);
			$allunit = $this->input->post("txtUnit");
			$unit = $this->populate_multiple($allunit);
			$unit2 = $this->populate_multiple_unit($allunit);
			$allactivity = $this->input->post("txtActivity");
			$activity = $this->populate_multiple($allactivity);
			$activity2 = $this->populate_multiple2($allactivity);
			
			$data['DataTroubledPart'] = $this->M_report->getDataTroubledPart($start,$end,$customername,$province,$unit,$bodynumber,$activity,$sparepart,$technician,$status);
			$data['period'] = $period;
			$data['customername'] = $customername;
			$data['province'] = $province2;
			$data['unit'] = $unit2;
			$data['bodynumber'] = $bodynumber;
			$data['activity'] = $activity2;
			$data['sparepart'] = $spname;
			$data['technician'] = $employeename;
			$data['status'] = $statusname;
			$html =$this->load->view('CustomerRelationship/Report/ReportDataTroubledPart/V_export_data_troubled_part',$data,true);
			
			$this->createPDF('DataTroubledPart.pdf',$html);
			
		}
		
		//  ================================================ BAGIAN REPORT REKAP TROUBLED PART ========================================================//
		//memanggil halaman report monitoring program
		
		public function RekapTroubledPart(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			$data['Customer'] = $this->M_customer->getCustomer();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['province'] = $this->M_province->getAllProvinceArea();
			$data['buyingtype'] = $this->M_buyingtype->getAllBuyingType();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportRekapTroubledPart/V_report_rekap_troubled_part', $data);
			$this->load->view('V_Footer',$data);
			
		}
		
		public function ExportReportRekapTroubledPart(){
			$unit_id = $this->input->post('txtUnit');
			$list_area = $this->input->post('txtArea');
			$spare_part = $this->input->post('txtSparePart');
			
			$data['tes'] = "tes";
			$start = $this->input->post('txtStartProgram');
			$exstart = explode(' ',$start);
			$monthStart = $exstart[0];
			$yearStart = $exstart[1];
			$nstart = $this->changeMonth($monthStart);
			$newstart = $yearStart."/".$nstart."/1";
			$data['month_from'] = $monthStart."-".$yearStart;
			
			$end = $this->input->post('txtEndProgram');
			$exend = explode(' ',$end);
			$monthEnd = $exend[0];
			$yearEnd = $exend[1];
			$nend = $this->changeMonth($monthEnd);
			$newend = $yearEnd."/".$nend."/25";
			$new_end = $this->format_date_end($end);
			$data['month_to'] =  $monthEnd."-".$yearEnd;
			
			$datetime1 = date_create($newstart);
			$datetime2 = date_create($new_end);
			
			$interval = date_diff($datetime1, $datetime2);
			 echo $newstart."===".$new_end;
			$mm = $interval->format('%m');
			$yy = $interval->format('%y');
			
			$total = (12*$yy) + $mm;
			
			$tt = $nstart + $total;
			$data['nstart'] = $nstart;
			$data['waw'] = $nstart;
			$data['tt'] = $tt;
			//echo $tt;
			// echo $mm."/".$yy."/".$tt."/".$nstart;
			  // echo date_format($datetime2,'d-M-Y');
			//$bulan = array();
			$awal = $nstart;
			$awal2 = $nstart;
			while($nstart <= $tt){
				if($nstart > 36){
					$bl = $nstart - 36;
					$yeara = $yearStart + 3;
				}else if($nstart > 24){
					$bl = $nstart - 24;
					$yeara = $yearStart + 2;
				}else if($nstart > 12){
					$bl = $nstart - 12;
					$yeara = $yearStart + 1;
				}else{
					$bl = $nstart;
					$yeara = $yearStart;
				}
				$nama = $this->returnMonth($bl);
				//echo $nama."<br />";format_date_end
				$data['bulan'.$nstart] = $nama."<br />".$yeara;
				$nstart++;
			}
			
			if($list_area !=""){
				$area_id = implode(', ', $list_area);
				$area = $this->M_province->getRegencyByRegencyProvince($area_id);
				foreach($area as $key=>$cities){
					$city_list[] = $cities['city_regency_id'];
				}
				$city_id = implode(', ', $city_list);
				$city = $this->M_province->getRegencyAndProvince($area_id);
				foreach($city as $key=>$cities){
					$city_list2[] = $cities['province_name'];
				}
				
				$city_name = implode(', ', $city_list2);
				$data['city_chosen'] = $city_name;
			}else{
				$city_id = FALSE;
				$data['city_chosen'] = "-";
			}
			if($unit_id !=""){
				$unit_id2 = implode(',', $unit_id);
				$unit = $this->M_item->getItemId($unit_id2);
				foreach($unit as $key=>$values){
					$unit_list[] = $values['item_name'];
				}
				$unit_list_name = implode(', ', $unit_list);
				$data['unit'] = $unit_list_name;
			}else{
				$unit_id2 = "";
				$data['unit'] = "-";
			}
			if($spare_part == ""){
				$data['spare_part'] = "-";
				$spare_part_id = "";
			}else{
				$spare_part_id = implode(',', $spare_part);
				$Item = $this->M_report->getUnitById($spare_part_id);
				foreach($Item as $pr){
					$spname[] = $pr['item_name'];
				}
				$spare_part_name = implode(', ', $spname);
				$data['spare_part'] = $spare_part_name;
			}
			
			$tes = $this->M_report->getRekapTroubledPart($unit_id2,$city_id,$spare_part_id,$newstart,$new_end);
			// print_r($tes);
			$p = 0;
			foreach($tes as $ts => $dt){
				$j=1;
				while($awal <= $tt){
					$spare = $tes[$p]['spare_part'];
					if($awal > 36){
						$blf = $awal - 36;
						$yearf = $yearStart + 3;
					}else if($awal > 24){
						$blf = $awal - 24;
						$yearf = $yearStart + 2;
					}else if($awal > 12){
						$blf = $awal - 12;
						$yearf = $yearStart + 1;
					}else{
						$blf = $awal;
						$yearf = $yearStart;
					}
					if($blf == 2){
						$ee = 28;
					}else if(($blf == 1) or ($blf == 3) or ($blf == 5) or ($blf == 7) or ($blf == 8) or ($blf == 10) or ($blf == 12)){
						$ee = 31;
					}else{
						$ee = 30;
					}
					// $year = intval($yearStart)+floor(($j-1)/12);
					$sd = $yearf."-".$blf."-1";
					$ed = $yearf."-".$blf."-".$ee;
					$cSP = $this->M_report->CountSPPerMonth($spare,$sd,$ed);
					foreach($cSP as $cs){
						$jml = $cs['jml'];
					}
					$tes[$p]["a".$j] = $jml;
					// $tes[$p]["year"] = $year;
					$awal++;
					$j++;
				}
				
				$awal = $awal2;
				$p++;
			}
			$data['RekapTroubledPart'] = $tes;
			//echo json_encode($tes);
			//$this->load->view('CustomerRelationship/Report/ReportRekapTroubledPart/V_export_rekap_troubled_part',$data);
			$html = $this->load->view('CustomerRelationship/Report/ReportRekapTroubledPart/V_export_rekap_troubled_part',$data,true);
			$this->createPDF('DataTroubledPart.pdf',$html);
		}
		
		//  ================================================ BAGIAN REPORT REKAP COMPLAIN ========================================================//
		//memanggil halaman report monitoring program
		
		public function RekapComplain(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			$data['Customer'] = $this->M_customer->getCustomer();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['province'] = $this->M_province->getAllProvinceArea();
			$data['buyingtype'] = $this->M_buyingtype->getAllBuyingType();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportRekapComplain/V_report_rekap_complain', $data);
			$this->load->view('V_Footer',$data);
			
		}
		
		public function ExportReportRekapComplain(){
			$data['tes'] = "tes";
			//$period = $this->input->post("txtPeriod");
			$start = $this->input->post("txtStartDate");
			$end = $this->input->post("txtEndDate");
			$category_service = $this->input->post("txtCategoryService");
			$list_area = $this->input->post("txtArea");
			$sort_by = $this->input->post("txtSortBy");
			/*if($period == null){
				$start_date = "";
				$end_date = "";
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
				$start_date = "2014-01-01";
				$end_date = "2015-12-31";
			}else{
				$ex_per = explode(" - ",$period);
				$start = $ex_per[0]; 
				$start_date = $this->format_date($period);
				$end = $ex_per[1]; 
				$end_date = $this->format_date($period);
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
			}*/
			
			
			$start_date = $this->format_date_start($start);
			$end_date = $this->format_date_end($end);
			$data['start_date'] = $start_date;
			$data['end_date'] = $end_date;
			/*if($list_area !=""){
				$area_id = implode(',', $list_area);
				$area = $this->M_province->getRegencies($area_id);
				foreach($area as $key=>$cities){
					$city_list[] = $cities['regency_name'];
				}
				
				$city_name = implode(', ', $city_list);
				$data['city_chosen'] = $city_name;
			}else{
				$city_id = FALSE;
				$data['city_chosen'] = "-";
			}*/
			if($list_area != ""){
				$area_id = implode(',', $list_area);
				$area = $this->M_province->getRegencyAndProvince($area_id);
				
				foreach($area as $key=>$cities){
						$city_name_list[] = $cities['province_name'];
					}
				$area = $this->M_province->getRegencyByRegencyProvince($area_id);
				foreach($area as $key=>$cities){
						$city_list[] = $cities['city_regency_id'];
					}
				$city_name = implode(', ', $city_name_list);
				$city_id = implode(', ', $city_list);
				$data['city_chosen'] = $city_name;
			}else{
				$city_id = "";
				$data['city_chosen'] = "-";
			}
			
			$data['category_service'] = $category_service;
			
			$month_start_date = date('ym', strtotime($start_date));
			$month_end_date = date('ym', strtotime($end_date));
			$total_month = ((intval(substr($month_end_date, 0, 2))-intval(substr($month_start_date, 0, 2)))*12)+
							(intval(substr($month_end_date, 2, 2))-intval(substr($month_start_date, 2, 2)));
			$data['total_month'] = $total_month;
			$data['date1'] = $this->format_date_start($start);
			$data['date2'] = $list_area;
			$data['MonthYear'] = $this->M_report->getMonthYear($start_date,$total_month);
			$data['RekapComplain'] = $this->M_report->getRekapComplain($city_id,$category_service,$start_date,$end_date,$sort_by);
			$data['DataTpComplain'] = $this->M_report->getDataTpComplain($city_id,$category_service,$start_date,$end_date);
			//$this->load->view('CustomerRelationship/Report/ReportRekapComplain/V_export_rekap_complain',$data);
			$html =$this->load->view('CustomerRelationship/Report/ReportRekapComplain/V_export_rekap_complain',$data,true);
			
			$this->createPDF('RekapComplain.pdf',$html);
		}
		
		//  ================================================ BAGIAN REPORT DATA KELUHAN DAN MASUKAN ========================================================//
		//memanggil halaman report monitoring program
		
		public function DataKeluhanMasukan(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			$data['Customer'] = $this->M_customer->getCustomer();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['province'] = $this->M_province->getAllProvinceArea();
			$data['buyingtype'] = $this->M_buyingtype->getAllBuyingType();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportDataKeluhanMasukan/V_report_data_keluhan_masukan', $data);
			$this->load->view('V_Footer',$data);
			
		}
		
		public function ExportReportDataKeluhanMasukan(){
			$data['tes'] = "tes";
			$period = $this->input->post("txtPeriod");
			$activity = $this->input->post("txtActivity");
			$faq_category = $this->input->post("txtResponse");
			$list_area = $this->input->post("txtArea");
			$sort_by = $this->input->post("txtSortBy");
			if($period == null){
				$start_date = "";
				$end_date = "";
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
				$start_date = "1965-01-01";
				$end_date = "2100-12-31";
			}else{
				$ex_per = explode(" - ",$period);
				$start = $ex_per[0]; 
				$start_date = $this->format_date($start);
				$end = $ex_per[1]; 
				$end_date = $this->format_date($end);
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
			}
			$area_id = implode(',', $list_area);
			$area = $this->M_province->getRegencyAndProvince($area_id);
			foreach($area as $key=>$cities){
					$city_name_list[] = $cities['province_name'];
				}
			$area = $this->M_province->getRegencyByRegencyProvince($area_id);
			foreach($area as $key=>$cities){
					$city_list[] = $cities['city_regency_id'];
				}
			$city_name = implode(', ', $city_name_list);
			$city_id = implode(', ', $city_list);
			$data['city_chosen'] = $city_name;
			if($faq_category !=""){
				$faq_type = '\''.implode('\',\'', $faq_category).'\'';
				$faq_type_list = implode(',', $faq_category);
				$data['faq_type'] = $faq_type_list;
			}else{
				$faq_type = "";
				$data['faq_type'] = "-";
			}
			if($activity !=""){
				$activities = '\''.implode('\',\'', $activity).'\'';
				foreach($activity as $key => $value)
				{	if($value ==='service_keliling'){
						$value = 'Service Keliling';
					}
					else if($value ==='customer_visit'){
						$value = 'Customer Visit';
					}
					else if($value ==='customer_visit'){
						$value = 'Customer Visit';
					}
					else if($value ==='call_out'){
						$value = 'Call Out';
					}
					else if($value ==='call_in'){
						$value = 'Call In';
					}
					else if($value ==='social'){
						$value = 'Social Media';
					}
					else if($value ==='email'){
						$value = 'Email';
					}
					else if($value ==='others'){
						$value = 'Others';
					}
					$activity[$key] = $value;
				}
				$activity_list = implode(',', $activity);
				$data['activities'] = $activity_list;
			}else{
				$activities = "";
				$data['activities'] = "-";
			}
			$data['DataComplainFaQ'] = $this->M_report->getDataFaq($city_id,$faq_type,$activities,$start_date,$end_date,$sort_by);
			$this->load->view('CustomerRelationship/Report/ReportDataKeluhanMasukan/V_export_data_keluhan_masukan',$data);
			$html =$this->load->view('CustomerRelationship/Report/ReportDataKeluhanMasukan/V_export_data_keluhan_masukan',$data,true);
			
			$this->createPDF('DataKeluhanMasukan.pdf',$html);
		}
		
		//  ================================================ BAGIAN REPORT REKAP KELUHAN DAN MASUKAN ========================================================//
		//memanggil halaman report monitoring program
		
		public function RekapKeluhanMasukan(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			$data['Customer'] = $this->M_customer->getCustomer();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['province'] = $this->M_province->getAllProvinceArea();
			$data['buyingtype'] = $this->M_buyingtype->getAllBuyingType();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportRekapKeluhanMasukan/V_report_rekap_keluhan_masukan', $data);
			$this->load->view('V_Footer',$data);
			
		}
		
		public function ExportReportRekapKeluhanMasukan(){
			//$data['tes'] = "tes";
			$period = $this->input->post("txtPeriod");
			$activity = $this->input->post("txtActivity");
			$faq_category = $this->input->post("txtResponse");
			$list_city = $this->input->post("txtProvince");
			if($period == null){
				$start_date = "";
				$end_date = "";
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
				$start_date = "1965-01-01";
				$end_date = "2100-12-31";
			}else{
				$ex_per = explode(" - ",$period);
				$start = $ex_per[0]; 
				$start_date = $this->format_date($start);
				$end = $ex_per[1]; 
				$end_date = $this->format_date($end);
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
			}
			if($list_city !=""){
				$city_id = implode(',', $list_city);
				$city = $this->M_province->getRegencies($city_id);
				foreach($city as $key=>$cities){
					$city_list[] = $cities['regency_name'];
				}
				
				$city_name = implode(', ', $city_list);
				$data['city_chosen'] = $city_name;
			}else{
				$city_id = FALSE;
				$data['city_chosen'] = "-";
			}
			if($faq_category !=""){
				$faq_type = '\''.implode('\',\'', $faq_category).'\'';
				$faq_type_list = implode(',', $faq_category);
				$data['faq_type'] = $faq_type_list;
			}else{
				$faq_type = "";
				$data['faq_type'] = "-";
			}
			if($activity !=""){
				$activities = '\''.implode('\',\'', $activity).'\'';
				foreach($activity as $key => $value)
				{	if($value ==='service_keliling'){
						$value = 'Service Keliling';
					}
					else if($value ==='customer_visit'){
						$value = 'Customer Visit';
					}
					else if($value ==='customer_visit'){
						$value = 'Customer Visit';
					}
					else if($value ==='call_out'){
						$value = 'Call Out';
					}
					else if($value ==='call_in'){
						$value = 'Call In';
					}
					else if($value ==='social'){
						$value = 'Social Media';
					}
					else if($value ==='email'){
						$value = 'Email';
					}
					else if($value ==='others'){
						$value = 'Others';
					}
					$activity[$key] = $value;
				}
				$activity_list = implode(',', $activity);
				$data['activities'] = $activity_list;
			}else{
				$activities = "";
				$data['activities'] = "-";
			}
			$data['period'] = $period;
			$data['tes'] = $activity;
			$data['RekapComplainFaQ'] = $this->M_report->getRekapFaq($city_id,$faq_type,$activities,$start_date,$end_date);
			$this->load->view('CustomerRelationship/Report/ReportRekapKeluhanMasukan/V_export_rekap_keluhan_masukan',$data);
			$html =$this->load->view('CustomerRelationship/Report/ReportRekapKeluhanMasukan/V_export_rekap_keluhan_masukan',$data,true);
			
			$this->createPDF('ReportRekapKeluhanMasukan.pdf',$html);
		}
		
		//  ================================================ BAGIAN REPORT REKAP PENGGUNAAN UNIT ========================================================//
		//memanggil halaman report monitoring program
		
		public function RekapPenggunaanUnit(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			$data['Customer'] = $this->M_customer->getCustomer();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['province'] = $this->M_province->getAllProvinceArea();
			$data['buyingtype'] = $this->M_buyingtype->getAllBuyingType();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportRekapPenggunaanUnit/V_report_rekap_penggunaan_unit', $data);
			$this->load->view('V_Footer',$data);
			
		}
		
		public function ExportReportRekapPenggunaanUnit(){
			$data['tes'] = "tes";
			$period = $this->input->post("txtPeriod");
			$list_buying_type = $this->input->post("txtBuyingType");
			$list_province_id = $this->input->post("txtProvince");
			$sort_by = $this->input->post("txtSortBy");
			$data['sort_by'] = $sort_by ;
			
			if($period == null){
				$start_date = "";
				$end_date = "";
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
				$start_date = "1965-01-01";
				$end_date = "2100-12-31";
			}else{
				$ex_per = explode(" - ",$period);
				$start = $ex_per[0]; 
				$start_date = $this->format_date($start);
				$end = $ex_per[1]; 
				$end_date = $this->format_date($end);
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
			}
			if($list_buying_type !=""){
				$buying_type = implode(',', $list_buying_type);
				$buying_types = $this->M_buyingtype->getBuyingTypes($buying_type);
				foreach($buying_types as $key=>$values){
					$buying_types_list[] = $values['buying_type_name'];
				}
				$buying_types_name = implode(', ', $buying_types_list);
				$data['buying_type'] = $buying_types_name;
			}else{
				$buying_type = "";
				$data['buying_type'] = "-";
			}
			if($list_province_id !=""){
				$province_id = implode(',', $list_province_id);
				$province = $this->M_province->getAllProvinceArea($province_id);
				foreach($province as $key=>$provinces){
					$province_list[] = $provinces['province_name'];
				}
				
				$province_name = implode(', ', $province_list);
				$data['province_chosen'] = $province_name;
			}else{
				$province_id = FALSE;
				$data['province_chosen'] = "-";
			}
			
			$data['RekapPenggunaanUnit'] = $this->M_report->getRekapPu($province_id,$buying_type,$start_date,$end_date,$sort_by);	
			$data['RusakPerUnit'] = $this->M_report->getRusak($province_id,$buying_type,$start_date,$end_date);			
			$this->load->view('CustomerRelationship/Report/ReportRekapPenggunaanUnit/V_export_rekap_penggunaan_unit',$data);
			$html = $this->load->view('CustomerRelationship/Report/ReportRekapPenggunaanUnit/V_export_rekap_penggunaan_unit',$data,true);
			
			$this->createPDF('RekapPenggunaanUnit.pdf',$html);
		}
		
		//  ================================================ BAGIAN REPORT REKAP PENJUALAN UNIT ========================================================//
			
		public function RekapPenjualanUnit(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			$data['Customer'] = $this->M_customer->getCustomer();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['province'] = $this->M_province->getAllProvinceArea();
			$data['buyingtype'] = $this->M_buyingtype->getAllBuyingType();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportRekapPenjualanUnit/V_report_rekap_penjualan_unit', $data);
			$this->load->view('V_Footer',$data);
			
		}
		
		public function ExportReportRekapPenjualanUnit(){
			
			$period = $this->input->post("txtPeriod");
			$list_buying_type = $this->input->post("txtBuyingType");
			$list_province_id = $this->input->post("txtArea");
			
			if($period == null){
				$start_date = "";
				$end_date = "";
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
				$start_date = "1965-01-01";
				$end_date = "2100-12-31";
			}else{
				$ex_per = explode(" - ",$period);
				$start = $ex_per[0]; 
				$start_date = $this->format_date($start);
				$end = $ex_per[1]; 
				$end_date = $this->format_date($end);
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
			}
			if($list_buying_type !=""){
				$buying_type = implode(',', $list_buying_type);
				$buying_types = $this->M_buyingtype->getBuyingTypes($buying_type);
				foreach($buying_types as $key=>$values){
					$buying_types_list[] = $values['buying_type_name'];
				}
				$buying_types_name = implode(', ', $buying_types_list);
				$data['buying_type'] = $buying_types_name;
			}else{
				$buying_type = "";
				$data['buying_type'] = "-";
			}
			if($list_province_id !=""){
				$province_id = implode(',', $list_province_id);
				$province = $this->M_province->getAllProvinceArea($province_id);
				foreach($province as $key=>$provinces){
					$province_list[] = $provinces['province_name'];
				}
				
				$province_name = implode(', ', $province_list);
				$data['province_chosen'] = $province_name;
			}else{
				$province_id = FALSE;
				$data['province_chosen'] = "-";
			}

			
			$month_start_date = date('ym', strtotime($start_date));
			$month_end_date = date('ym', strtotime($end_date));
			$total_month = ((intval(substr($month_end_date, 0, 2))-intval(substr($month_start_date, 0, 2)))*12)+
							(intval(substr($month_end_date, 2, 2))-intval(substr($month_start_date, 2, 2)));
			$data['total_month'] = $total_month;
			$data['MonthYear'] = $this->M_report->getMonthYear($start_date,$total_month);
			$data['ProvinceTotal'] = $this->M_report->getProvinceTotal($province_id,$buying_type,$start_date,$end_date);
			$data['CityTotal'] = $this->M_report->getCityTotal($province_id,$buying_type,$start_date,$end_date);
			$data['ProvincePerMonth'] = $this->M_report->getProvincePerMonth($province_id,$buying_type,$start_date,$end_date);
			$data['CityPerMonth'] = $this->M_report->getCityPerMonth($province_id,$buying_type,$start_date,$end_date);
			$this->load->view('CustomerRelationship/Report/ReportRekapPenjualanUnit/V_export_rekap_penjualan_unit',$data);
			$html = $this->load->view('CustomerRelationship/Report/ReportRekapPenjualanUnit/V_export_rekap_penjualan_unit',$data,true);
			
			$this->createPDF('RekapPenjualanUnit.pdf',$html);
		}
		
		//  ================================================ BAGIAN REPORT RESPONSE TIME ========================================================//
			
		public function ResponseTime(){
			
			//echo "repot monitoring";
			
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Report';
			$data['SubMenuOne'] = '';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Report/ReportResponseTime/V_report_response_time', $data);
			$this->load->view('V_Footer',$data);
			
		}
		
		public function ExportResponseTime(){
			
			$period = $this->input->post("txtPeriod");
			
			if($period == null){
				$start_date = "";
				$end_date = "";
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
				$start_date = "1965-01-01";
				$end_date = "2100-12-31";
			}else{
				$ex_per = explode(" - ",$period);
				$start = $ex_per[0]; 
				$start_date = $this->format_date($start);
				$end = $ex_per[1]; 
				$end_date = $this->format_date($end);
				$data['start_date'] = $start_date;
				$data['end_date'] = $end_date;
			}
			
			$data['ResponseTime'] = $this->M_report->getResponseTime($start_date,$end_date);
			$this->load->view('CustomerRelationship/Report/ReportResponseTime/V_export_response_time',$data);
			$html = $this->load->view('CustomerRelationship/Report/ReportResponseTime/V_export_response_time',$data,true);
			
			$this->createPDF('ResponseTime.pdf',$html);
		}
}
