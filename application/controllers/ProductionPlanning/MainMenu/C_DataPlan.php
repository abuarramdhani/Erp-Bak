<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_DataPlan extends CI_Controller {

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
		$data['plan']			= $this->M_dataplan->getDataPlan();
		$data['no']				= 1;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlanning/MainMenu/DataPlan/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function CreatePage($message = FALSE)
	{
		$this->checkSession();
		$user_id  = $this->session->userid;
		$no_induk = $this->session->user;
		$data['message'] = $message;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['section'] 		= $this->M_dataplan->getSection($user_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlanning/MainMenu/DataPlan/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create()
	{
		$user_id  = $this->session->userid;
		$section 	= $this->input->post('section');
		$fileName 	= time().'-'.$_FILES['dataPlan']['name'];
        $config['upload_path'] = 'assets/upload/ProductionPlanning/data-plan';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 2048;
        $this->upload->initialize($config);

        if(! $this->upload->do_upload('dataPlan') ){
        	$error = $this->upload->display_errors();
        	$message =	'<div class="row">
		 					<div class="col-md-10 col-md-offset-1 col-sm-12">
		 						<div id="messUpPP" class="modal fade modal-danger" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		 							<div class="modal-dialog modal-lg" role="document">
		 								<div class="modal-content">
		 									<div class="modal-body">
		 										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		 											<span aria-hidden="true">&times;</span>
		 										</button>';
		 										$message .= $error;
		 										$message .= '
		 									</div>
		 								</div>
			 						</div>
			 					</div>
				 			</div>
            		    </div>
            		    <script type="text/javascript">
							$("#messUpPP").modal("show");
						</script>';
            	$this->CreatePage($message);
        	}else{
	        	$media	= $this->upload->data();
	        	$inputFileName 	= 'assets/upload/ProductionPlanning/data-plan/'.$media['file_name'];

	        	try{
                	$inputFileType 	= PHPExcel_IOFactory::identify($inputFileName);
                	$objReader 		= PHPExcel_IOFactory::createReader($inputFileType);
                	$objPHPExcel 	= $objReader->load($inputFileName);
            	}catch(Exception $e){
            		die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            	}

            	$sheet 			= $objPHPExcel->getSheet(0);
            	$highestRow 	= $sheet->getHighestRow();
            	$highestColumn 	= $sheet->getHighestColumn();
            	$errStock       = 0;

            	for ($row = 4; $row <= $highestRow; $row++){
            		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            		if ($rowData[0][0] != null) {
                    	$datPoint = "1";
                    	$dataIns = array(
                    		'item_code' 		=> $rowData[0][1],
                    		'item_description' 	=> $rowData[0][2],
                    		'priority' 			=> $rowData[0][3],
                    		'need_qty' 			=> $rowData[0][4],
                    		'due_time' 			=> date('d-m-Y', PHPExcel_Shared_Date::ExcelToPHP($rowData[0][5])),
                    		'section_id' 		=> $section
                    	);

                    	if (!is_numeric($rowData[0][4])) {
                    		$errStock++;
                    	}
                    	if (empty($rowData[0][1])||empty($rowData[0][2]) || empty($rowData[0][3]) || empty($rowData[0][4]) || empty($rowData[0][5])) {
                        	$errStock++;
                    	}
            		}else{
                		$datPoint = null;
            		}

                	if ($datPoint !=null && $errStock == 0) {
                		$this->M_dataplan->insertDataPlan($dataIns);
                	}
            	// echo '<pre>';
            	// print_r($rowData);
            	// print_r($dataIns);
            	// echo '</pre>';
            	}

            	unlink($inputFileName);
            	if ($errStock > 0) {
            		$message = '
                    	<div class="modal fade" id="uploadMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                        <h2 class="modal-title" id="myModalLabel"><b>Format Data Tidak Sesuai!</b></h2>
                                        <small>Mohon sesuaikan format data yg akan diinputkan, berikut contoh yang benar.</small>
                                    </div>
                                    <br>
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead class="bg-warning text-center" style="font-weight:bold; vertical-align:middle;">
                                            <td>No</td>
                                            <td>ITEM</td>
                                            <td>DESCRIPTION</td>
                                            <td>PRIORITY</td>
                                            <td>Type Assembly</td>
                                            <td>Item</td>
                                            <td>Locator</td>
                                            <td>Alamat</td>
                                            <td>LPPB  / MO / KIB</td>
                                            <td>PICKLIST</td>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>102</td>
                                                <td>KOM2-DM</td>
                                                <td>AAG1000AA1AZ-6</td>
                                                <td>BOXER</td>
                                                <td>AAF1BA0391AY-0</td>
                                                <td>SELATAN</td>
                                                <td>PANGGUNG TIMUR</td>
                                                <td>1</td>
                                                <td>0</td>
                                            </tr>
                                            <tr style="color:red;">
                                                <td>(Harus Diisi)</td>
                                                <td>(Not Null)</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>(1 untuk Yes, 0 untuk No)</td>
                                                <td>(1 untuk Yes, 0 untuk No)</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $("#uploadMessage").modal("show");
                        });
                    </script>';
            	}else{
            		$message = '<div class="row">
                                <div class="col-md-12">
                                    <div id="eror" class="alert alert-dismissible alert-success" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        Upload Completed!
                                    </div>
                                </div>
                            </div>';
            	}
            	$this->CreatePage($message);
	        }
	}

	public function DownloadSample()
	{
		$this->load->helper('download');
		force_download('assets/upload/ProductionPlanning/production-planning.xls', NULL);
	}
}