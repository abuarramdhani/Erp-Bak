<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ItemPlan extends CI_Controller {

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
		$this->load->model('ProductionPlanning/MainMenu/M_itemplan');
		$this->load->model('ProductionPlanning/MainMenu/M_dataplan');
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
		$data['itemData']		= $this->M_itemplan->getItemData();
		$data['no']				= 1;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlanning/MainMenu/ItemPlan/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

    public function Create($message=false)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['message'] = $message;
        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('ProductionPlanning/MainMenu/ItemPlan/V_Create',$data);
        $this->load->view('V_Footer',$data);
    }

    public function CreateUpload()
    {
    	$user_id 	= $this->session->userid;
		$fileName 	= time().'-'.$_FILES['itemData']['name'];
        $config['upload_path'] 		= 'assets/upload/ProductionPlanning/data-plan';
        $config['file_name']		= $fileName;
        $config['allowed_types']	= 'xls|xlsx|csv';
        $config['max_size']			= 2048;
        $this->upload->initialize($config);

        if(! $this->upload->do_upload('itemData') ){
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
			$this->Create($message);
        }else{
        	$media	= $this->upload->data();
        	$inputFileName 	= 'assets/upload/ProductionPlanning/data-plan/'.$media['file_name'];
        	$subInv = $this->M_dataplan->getSection();

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
            $delCheckPoint  = 0;

            for ($row = 7; $row <= $highestRow; $row++){
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                if ($rowData[0][0] != null) {
                    $secID = 0;
                	foreach ($subInv as $si) {
                		if ($si['section_name'] == $rowData[0][3]) {
                			$secID = $si['section_id'];
                		}
                	}
                    $datPoint = "1";
                    $dataIns = array(
                        'item_code'         => $rowData[0][1],
                        'item_description'  => $rowData[0][2],
                        'section_id'        => $secID,
                        'from_inventory'    => $rowData[0][4],
                        'to_inventory'      => $rowData[0][5],
                        'completion'  	    => $rowData[0][6],
                        'created_by'     	=> $user_id,
                        'created_date'      => date('Y-m-d')
                    );
                    if (empty($rowData[0][1]) || empty($rowData[0][3]) || $secID == 0) {
                        $errStock++;
                    }
                }else{
                    $datPoint = null;
                }
                if ($datPoint !=null && $errStock == 0) {
                    $this->M_itemplan->setItemPlan($dataIns,$delCheckPoint);
                    $delCheckPoint = 1;
                }
            }

            unlink($inputFileName);
            if ($errStock > 0) {
                $message = '<div class="row">
                            <div class="col-md-10 col-md-offset-1 col-sm-12">
                                <div id="messUpPP" class="modal fade modal-danger" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                UPLOAD ERROR
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $("#messUpPP").modal("show");
                        </script>';
            }else{
                $message = '<div class="row">
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
            }
            $this->Create($message);
        }
    }

    public function DownloadSample()
    {
        $this->load->helper('download');
        force_download('assets/upload/ProductionPlanning/item-data-plan.xls', NULL);
    }
}