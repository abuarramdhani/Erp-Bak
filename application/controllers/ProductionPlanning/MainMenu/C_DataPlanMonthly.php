<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_DataPlanMonthly extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('Excel');
        $this->load->library('upload');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ProductionPlanning/MainMenu/M_dataplan');
		$this->load->model('ProductionPlanning/Settings/GroupSection/M_groupsection');
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['plan']			= $this->M_dataplan->getMonthlyPlan();
		$data['no']				= 1;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlanning/MainMenu/DataPlan/Monthly/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create($message=FALSE)
	{
		$this->checkSession();
		$user_id  = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';

			$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['section'] 		= $this->M_dataplan->getSection($user_id);
			$data['message'] 		= $message;

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ProductionPlanning/MainMenu/DataPlan/Monthly/V_Create',$data);
			$this->load->view('V_Footer',$data);
	}

	public function CreateSubmit()
	{
		$this->checkSession();
		$user_id  = $this->session->userid;

		$fileName 				= time().'-'.$_FILES['planData']['name'];
	    $config['upload_path']	= 'assets/upload/ProductionPlanning/data-plan';
	    $config['file_name']	= $fileName;
	    $config['allowed_types']= 'xls|xlsx|csv';
	    $config['max_size']		= 2048;
	    $this->upload->initialize($config);

        if(! $this->upload->do_upload('planData') ){
        	$error = $this->upload->display_errors();
       		$msg =	'<div class="row">
	 					<div class="col-md-10 col-md-offset-1 col-sm-12">
	 						<div id="messUpPP" class="modal fade modal-danger" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	 							<div class="modal-dialog modal-lg" role="document">
	 								<div class="modal-content">
	 									<div class="modal-body">
	 										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	 											<span aria-hidden="true">&times;</span>
	 										</button>';
	 										$msg .= $error;
		 									$msg .= '
		 								</div>
		 							</div>
			 					</div>
		 					</div>
			 			</div>
           		    </div>
            		<script type="text/javascript">
						$("#messUpPP").modal("show");
					</script>';
			$this->Create($msg);
	    }else{
	        $media			= $this->upload->data();
	        $inputFileName 	= 'assets/upload/ProductionPlanning/data-plan/'.$media['file_name'];
    		$section = $this->M_dataplan->getSection();

            try{
            	$inputFileType  = PHPExcel_IOFactory::identify($inputFileName);
            	$objReader      = PHPExcel_IOFactory::createReader($inputFileType);
            	$objPHPExcel    = $objReader->load($inputFileName);
            }catch(Exception $e){
            	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }

            $sheet          = $objPHPExcel->getSheet(0);
            $highestRow     = $sheet->getHighestRow();
            $highestColumn  = $sheet->getHighestColumn();
            $errStock       = 0;

            for ($row = 4; $row <= $highestRow; $row++){
            	$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            	if ($rowData[0][0] != null) {
            		$datPoint = "1";
            		foreach ($section as $sc) {
            			if (strtoupper($sc['section_name']) == strtoupper($rowData[0][1])) {
            				$section_id = $sc['section_id'];
            				$sectionError = '';
            			}else{
            				$errStock++;
            				$sectionError = 'Nama Seksi Ada yang tidak sesuai.';
            			}
            		}

            		$value = array(
						'section_id'			=> $section_id,
						'plan_time'				=> date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($rowData[0][2])),
						'monthly_plan_quantity' => $rowData[0][3],
						'created_by'			=> $user_id,
						'created_date'			=> date("Y-m-d H:i:s")
					);
	    echo "<pre>";
	    print_r($value);
	    echo "</pre>";
	    exit();
                    if (!is_numeric($rowData[0][4])) {
                        $errStock++;
                    }
                    if (empty($rowData[0][1])||empty($rowData[0][2]) || empty($rowData[0][3]) || empty($rowData[0][4]) || empty($rowData[0][5])) {
                        $errStock++;
                    }
                }else{
                    $datPoint = null;
                }

                // if ($datPoint !=null && $errStock == 0) {
                //  $this->M_dataplan->insertDataPlan($dataIns, 'pp.pp_daily_plans');
                // }
            }

            	unlink($inputFileName);
            }
			

			// $this->M_dataplan->insertDataPlan($value, 'pp.pp_monthly_plans');
			// redirect(base_url('ProductionPlanning/DataPlanMonthly'));
	}

	public function Edit($id)
	{
		$this->checkSession();
		$user_id  = $this->session->userid;
		$this->form_validation->set_rules('planQTY', 'required');
		if ($this->form_validation->run() === FALSE){
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';

			$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['plan']			= $this->M_dataplan->getMonthlyPlan($id);

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ProductionPlanning/MainMenu/DataPlan/Monthly/V_Edit',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$section 	= $this->input->post('sectionName');
			$planTime 	= date('Y-m-d', strtotime($this->input->post('planTime')));
			$value = array(
				'plan_time'				=> $planTime,
				'monthly_plan_quantity' => $this->input->post('planQTY'),
				'last_updated_by'		=> $user_id,
				'last_updated_date'		=> date("Y-m-d H:i:s")
			);

			$this->M_dataplan->update('pp.pp_monthly_plans','monthly_plan_id',$value,$id);
			redirect(base_url('ProductionPlanning/DataPlanMonthly'));
		}
	}

	public function DownloadSample()
	{
		$this->load->helper('download');
        force_download('assets/upload/ProductionPlanning/monthly-planning.xls', NULL);
	}
}