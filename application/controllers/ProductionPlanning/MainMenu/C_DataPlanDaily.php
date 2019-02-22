<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_DataPlanDaily extends CI_Controller {

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
		$this->load->model('ProductionPlanning/MainMenu/M_itemplan');
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
		$data['plan']			= $this->M_dataplan->getDataPlan(FALSE,FALSE,$user_id);
        $data['section']        = $this->M_dataplan->getSection($user_id);
		$data['item'] 		    = $this->M_itemplan->getItemData(FALSE,FALSE,$user_id);
        $data['no']             = 1;
        
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('ProductionPlanning/MainMenu/DataPlan/Daily/V_Index',$data);
        $this->load->view('V_Footer',$data);
    }

    public function Create($message = FALSE)
    {
        $this->checkSession();
        $user_id  = $this->session->userid;
        $no_induk = $this->session->user;
        $data['message'] = $message;
        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['section']        = $this->M_dataplan->getSection($user_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlanning/MainMenu/DataPlan/Daily/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function CreateSubmit()
	{
		$user_id    = $this->session->userid;
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
        	$this->Create($message);
    	}else{
        	$media	= $this->upload->data();
        	$inputFileName 	= 'assets/upload/ProductionPlanning/data-plan/'.$media['file_name'];

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
                    $is = $this->M_itemplan->getItemData($section,$rowData[0][1]);
                    if (!empty($is) && $is[0]['from_inventory'] == NULL) {
                        $getItemTransaction = $this->M_dataplan->getItemTransaction(1,$is[0]['from_inventory'],$is[0]['completion'],$rowData[0][1],$is[0]['locator_id']);
                    }elseif(!empty($is) && $is[0]['from_inventory'] !== NULL){
                        $getItemTransaction = $this->M_dataplan->getItemTransaction(FALSE,$is[0]['from_inventory'],$is[0]['to_inventory'],$rowData[0][1],$is[0]['locator_id']);
                    }
                    $datPoint = "1";
                    if ($getItemTransaction == NULL) {
                        $acvQty = 0;
                        $lastDelv = null;
                    }else{
                        $acvQty = $getItemTransaction[0]['ACHIEVE_QTY'];
                        $lastDelv = date('Y-m-d H:i:s', strtotime($getItemTransaction[0]['LAST_DELIVERY']));
                    }

                    $dataIns = array(
                        'item_code'         => $rowData[0][1],
                        'item_description'  => $rowData[0][2],
                        'priority'          => $rowData[0][3],
                        'need_qty'          => $rowData[0][4],
                        'due_time'          => PHPExcel_Style_NumberFormat::toFormattedString($rowData[0][5], 'm-d-Y hh:mm:ss'),
                        'achieve_qty'       => $acvQty,
                        'last_delivery'     => $lastDelv,
                        'section_id'        => $section,
                        'created_by'        => $user_id,
                        'created_date'      => date("Y-m-d H:i:s")
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
                    $this->M_dataplan->insertDataPlan($dataIns, 'pp.pp_daily_plans');
                }
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
        	$this->Create($message);
        }
	}

	public function DownloadSample()
	{
		$this->load->helper('download');
		force_download('assets/upload/ProductionPlanning/production-planning.xls', NULL);
	}

    public function Edit($id)
    {
        $this->checkSession();
        $user_id  = $this->session->userid;
        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $this->form_validation->set_rules('item', 'priority', 'required');

        if ($this->form_validation->run() === FALSE){
            $data['section']        = $this->M_dataplan->getSection($user_id);
            $data['plan']           = $this->M_dataplan->getDataPlan($id,$sid = FALSE);
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('ProductionPlanning/MainMenu/DataPlan/Daily/V_Edit',$data);
            $this->load->view('V_Footer',$data);
        }else{
            $data = array(
                'item_code' => $this->input->post('item'),
                'item_description' => $this->input->post('desc'),
                'priority' => $this->input->post('priority'),
                'need_qty' => $this->input->post('needQty'),
                'due_time' => $this->input->post('dueTime'),
                'section_id' => $this->input->post('section')
            );

            $this->M_dataplan->update('pp.pp_daily_plans','daily_plan_id',$data,$id);
            redirect(base_url('ProductionPlanning/DataPlanDaily'));
        }
    }

    public function searchDailyPlans()
    {
        $user_id    = $this->session->userid;
        $section    = $this->input->post('section');
        $due_time   = $this->input->post('planTime');
        if (!empty($due_time)) {
            $time   = explode(' - ', $due_time);
            $time1 = $time[0];
            $time2 = $time[1];
        }else{
            $time1 = FALSE;
            $time2 = FALSE;
        }
        $itemCode   = $this->input->post('itemCode');
        $status     = $this->input->post('status');
        $action     = $this->input->post('action');
        $data       = $this->M_dataplan->getDataPlan(FALSE,$section,$user_id,$time1,$time2,$itemCode,$status);
        $no = 1;

        if ($action == 0 || empty($action)) {
            echo '
            <div class="table-responsive" style="overflow:auto;">
                <table class="table table-striped table-bordered table-hover" id="tbdataplan">
                    <thead class="bg-primary">
                        <tr>
                            <td>No</td>
                            <td>Item</td>
                            <td>Description</td>
                            <td style="width:20px;">Priority</td>
                            <td>Due Time</td>
                            <td>Section</td>
                            <td>Need Qty</td>
                            <td>Achieve Qty</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tbody>';
                foreach ($data as $dt) {
                    echo '<tr>
                            <input type="hidden" name="daily_plan_id" value="'.$dt['daily_plan_id'].'">
                            <td>'.$no++."</td>
                            <td>".$dt['item_code']."</td>
                            <td>".$dt['item_description']."</td>
                            <td>".$dt['priority']."</td>
                            <td>".$dt['due_time']."</td>
                            <td>".$dt['section_name']."</td>
                            <td>".$dt['need_qty']."</td>
                            <td>";
                                if ($dt['achieve_qty'] == null) {
                                    echo "0";
                                }else{
                                    echo $dt['achieve_qty'];
                                }
                            echo "</td>
                            <td>".$dt['status']."</td>
                        </tr>";
                }
                echo "</tbody>
                </table>
            </div>";
        }else{
            $val['data']= $data;
            $val['no']  =  $no;

            $this->load->view('ProductionPlanning/MainMenu/DataPlan/Daily/V_EditAjax', $val);
        }
    }
    public function EditAjax($id)
    {
        $name = $this->input->post('name');
        $value = $this->input->post('value');

        $data = array(
            $name => $value
        );

        $this->M_dataplan->update('pp.pp_daily_plans','daily_plan_id',$data,$id);
    }
}