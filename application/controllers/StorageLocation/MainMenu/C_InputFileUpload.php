<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_InputFileUpload extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('StorageLocation/MainMenu/M_inputfileupload');
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('Excel');
        $this->load->library('upload');
		$this->checkSession();
	}

	public function checkSession(){
		if($this->session->is_logged){
		}else{
			redirect('');
		}
	}

	public function index($message = NULL)
	{
		$data = array (
			'message' => $message,
            );
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['title'] = 'Input Data From File';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StorageLocation/MainMenu/V_Upload',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Download()
	{
		force_download('assets/upload/StorageLocation/template/Template_SL.xlsx',NULL);
	}

	public function DoUpload()
	{
        $user_name 	= $this->session->userdata('user');
        $fileName 	= time().$_FILES['datafile']['name'];
        $config['upload_path'] = 'assets/upload/StorageLocation/import';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;

        $this->upload->initialize($config);
         
        if(! $this->upload->do_upload('datafile') ){
            $errorinfo = $this->upload->display_errors();
          	$message = '<div class="row">
          					<div class="col-md-6 col-md-offset-3" style="margin-top: 20px">
          						<div id="eror" class="alert alert-dismissible" role="alert" style="background-color:#c53838; text-align:center; color:white; ">
          							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
          								<span aria-hidden="true">&times;</span>
          							</button>';
                                    $message .= $errorinfo;
          							$message .= '
          						</div>
          					</div>
                      	</div>';
            $this->index($message);
        }else{
        	$media 			= $this->upload->data();
        	$inputFileName 	= 'assets/upload/StorageLocation/import/'.$media['file_name'];

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
            $dataErr        = array();

            for ($row = 3; $row <= $highestRow; $row++){
            	$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            	if ($rowData[0][0] != null) {
                    $data = "1";
                    $org_id         = $rowData[0][1];
                    $sub_inv        = $rowData[0][2];
                    $kode_assy      = $rowData[0][3];
                    $type_assy      = $rowData[0][4];
                    $kode_item      = $rowData[0][5];
                    $locator        = $rowData[0][6];
                    $alamat_simpan  = $rowData[0][7];
                    $lppbmokib      = $rowData[0][8];
                    $picklist       = $rowData[0][9];
                    $username_save  = $user_name;

                    if (!is_numeric($lppbmokib)) {
                        $errStock++;
                        // array_push($dataErr[$row][], 'LPPB  / MO / KIB', $row, $lppbmokib);
                    }elseif (strlen($lppbmokib)>1) {
                        $errStock++;
                        // array_push($dataErr[$row][], 'LPPB  / MO / KIB', $row, $lppbmokib);
                    }

                    if (!is_numeric($picklist)) {
                        $errStock++;
                        // array_push($dataErr[$row][], 'PICKLIST', $row, $picklist);
                    }elseif (strlen($picklist)>1) {
                        $errStock++;
                        // array_push($dataErr[$row][], 'PICKLIST', $row, $picklist);
                    }

                    if (empty($org_id)||empty($sub_inv) || empty($kode_assy) || empty($type_assy) || empty($kode_item)) {
                        $errStock++;
                    }
                }else {
                	$data = null;
                }

                if ($data !=null && $errStock == 0) {
                	// $checkData = $this->M_inputfileupload->cekData($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item,$locator);
                	// if ($checkData>0) {
                		// $this->M_inputfileupload->updateData($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item,$locator,$alamat_simpan,$lppbmokib,$picklist,$username_save);
                	// }else{
                		$this->M_inputfileupload->insertData($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item,$locator,$alamat_simpan,$lppbmokib,$picklist,$username_save);
                	// }
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
                                            <td>Organization ID</td>
                                            <td>Sub Inventory</td>
                                            <td>Assembly</td>
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
                                                <td>1                                    *(1 untuk Yes, 0 untuk No)
</td>
                                                <td>0                                    *(1 untuk Yes, 0 untuk No)</td>
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
                                                <td>(1 untuk Yes, 0 untuk No)
</td>
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
            $this->index($message);
        }
    }
}