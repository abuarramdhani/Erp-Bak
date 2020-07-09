<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
// nggak disentuh total sama edwin
class C_MasterPersonal extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('Excel');
        $this->load->library('upload');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_masterpersonal');
		$this->load->model('ManufacturingOperationUP2L/Ajax/M_ajax');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index($message=FALSE)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Master';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = 'Master Personal';
		$data['SubMenuTwo'] = '';


		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['message'] 		= $message;

		$data['master'] = $this->M_masterpersonal->monitor();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperationUP2L/master/V_MasterPersonal', $data);
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
		$data['message'] 		= $message;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperationUP2L/master/V_MasterPersonal',$data);
		$this->load->view('V_Footer',$data);
	}

	public function CreateSubmit()
	{	
		$this->checkSession();
		$user_id  = $this->session->userid;

		$fileName 				= time().'-'.$_FILES['Item']['name'];
	    $config['upload_path']	= 'assets/download/ManufacturingOperationUP2L/masterPersonal/';
	    $config['file_name']	= $fileName;
	    $config['allowed_types']= '*';
	    $config['max_size']		= 2048;
	    $this->upload->initialize($config);

        if(! $this->upload->do_upload('Item') ){
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
	        $inputFileName 	= 'assets/download/ManufacturingOperationUP2L/masterPersonal/'.$media['file_name'];
    		// $section 		= $this->M_dataplan->getSection();

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


            // echo $highestRow;
            // exit();


            for ($row = 3; $row <= $highestRow; $row++){
            	$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

            	if ($rowData[0][0] != null) {
            		$datPoint = "1";
        			// $secCheckPoint = 0;
            		// foreach ($section as $sc) {
            		// 	if ($secCheckPoint == 0 && strtoupper(preg_replace('/\s+/', '', $sc['section_name'])) == strtoupper(preg_replace('/\s+/', '', $rowData[0][1]))) {
            		// 		$section_id = $sc['section_id'];
            		// 		$secCheckPoint = 1;
            		// 	}
            		// }

            		$value = array(
						'nama'			=> $rowData[0][1],
						'no_induk'		=> $rowData[0][2],
						'created_by'	=> $user_id,
						'creation_date'	=> date("Y-m-d H:i:s")
					);

					// if ($secCheckPoint == 0) {
					// 	$sectionError = 'Nama Seksi Ada yang tidak sesuai. '.strtoupper(preg_replace('/\s+/', '', $rowData[0][1]));
     //    				$errStock++;
					// }else{
					// 	$sectionError = '';
					// }

                    // if (!is_numeric($rowData[0][6])) {
                    //     $errStock++;
                    //     $qtyError = 'Target_sk pada baris ke-'.$row.' tidak Numeric.';
                    // }elseif (!is_numeric($rowData[0][6])) {
                    // 	$errStock++;
                    //     $qtyError = 'Target_js pada baris ke-'.$row.' tidak Numeric.';
                    // }
                    // else{
                    //     $qtyError = '';
                    // }
                    if (empty($rowData[0][1])||empty($rowData[0][2])) {
                        $errStock++;
                        $emptyError = 'Data pada baris ke-'.$row.' kosong.';
                    }else{
                        $emptyError = '';
                    }
                }else{
                    $datPoint = null;
                }

                if ($datPoint !=null && $errStock == 0) {
                	$this->M_masterpersonal->insert($value, 'mo.mo_master_personal');
                	
                }
            }

		unlink($inputFileName);
        	
        	if ($errStock > 0) {
        		$msg =	'<div class="row">
	 					<div class="col-md-10 col-md-offset-1 col-sm-12">
	 						<div id="messUpPP" class="modal fade modal-danger" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	 							<div class="modal-dialog modal-lg" role="document">
	 								<div class="modal-content">
	 									<div class="modal-body">
	 										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	 											<span aria-hidden="true">&times;</span>
	 										</button>';
	 										$msg .= $errStock.'<br>';
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
        		$this->index($msg);
        		redirect(base_url('ManufacturingOperationUP2L/MasterPersonal'));
        	}else{
            	$msg =	'<div class="row">
	 					<div class="col-md-10 col-md-offset-1 col-sm-12">
	 						<div id="messUpPP" class="modal fade modal-success" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	 							<div class="modal-dialog modal-lg" role="document">
	 								<div class="modal-content">
	 									<div class="modal-body">
	 										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	 											<span aria-hidden="true">&times;</span>
	 										</button>
	 										UPLOAD COMPLETE!
		 								</div>
		 							</div>
			 					</div>
		 					</div>
			 			</div>
           		    </div>
            		<script type="text/javascript">
						$("#messUpPP").modal("show");
					</script>';
        		$this->index($msg);
        		redirect(base_url('ManufacturingOperationUP2L/MasterPersonal'));
        	}
        }
	}

	public function updateMasPer()
	{
		$tgl = date('Y-m-d');
		$user_id = $this->session->userid;
		$nama = $this->input->post('tNama');
		$noInduk = $this->input->post('tNoInduk');
		$id = $this->input->post('txtId');
		

		$data = $this->M_masterpersonal->updateMasterPerson($nama,$noInduk,$tgl,$user_id,$id);
		redirect(base_url('ManufacturingOperationUP2L/MasterPersonal'));

	}

	public function insertMasPer()
	{
		$tgl = date('Y-m-d');
		$user_id = $this->session->userid;
		$nama = $this->input->post('tNama');
		$noInduk = $this->input->post('tNoInduk');
		// $creation_date = date('d/m/y');

		$data = $this->M_masterpersonal->insertMasPer($nama,$noInduk,$tgl,$user_id);
		redirect(base_url('ManufacturingOperationUP2L/MasterPersonal'));

	}


}