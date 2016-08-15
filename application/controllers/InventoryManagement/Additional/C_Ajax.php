<?php
class C_Ajax extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
				$this->load->model('InventoryManagement/Setting/M_deliveryrequestapproval');
				$this->load->model('InventoryManagement/MainMenu/M_deliveryrequest');
				$this->load->model('SystemAdministration/MainMenu/M_user');
				$this->load->helper('form');
				$this->load->library('form_validation');
				$this->load->library('session');
				$this->load->helper('url');

        }

		public function GetLastRequestNumber()
		{		
				if (isset($_POST['term'])){
					$term = $_POST['term'];//term = id dari karakter yang kita ketikkan
				}
				
				$org_id = $this->session->org_id;
				
				if($org_id == 82){
					$head = 'AA';
				}elseif($org_id == 121){
					$head = 'CA';
				}elseif($org_id == 141){
					$head = 'BA';
				}elseif($org_id == 142){
					$head = 'BB';
				}elseif($org_id == 143){
					$head = 'CB';
				}elseif($org_id == 144){
					$head = 'BC';
				}elseif($org_id == 145){
					$head = 'CE';
				}
				
				if($term == 'UNIT'){
					$type = '01';
				}elseif($term == 'SPARE PART'){
					$type = '02';
				}
				$date = date("ym");// "ym" 2 digit year & month
				$search = $head.$date.$type
				$data = $this->M_deliveryrequest->getLastRequestNumber($search);
				
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
