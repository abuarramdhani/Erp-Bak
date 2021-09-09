<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Management extends CI_Controller
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
		$this->load->library('upload');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PeriodicalMaintenance/M_management');

		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Management Uraian Kerja';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);


		$admin = ['a' => 'T0015', 'b' => 'B0847', 'c' => 'B0655', 'd' => 'B0908'];
		if (empty(array_search($this->session->user, $admin))) {
			unset($data['UserMenu'][0]);
			unset($data['UserMenu'][1]);
			unset($data['UserMenu'][2]);
		}

		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


		$data['mesin'] = $this->M_management->getMesin();


		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PeriodicalMaintenance/V_Management', $data);
		$this->load->view('V_Footer', $data);
	}

	public function search()
	{
		$mesin 	= $this->input->post('mesin');

		$dataGET = $this->M_management->getAll($mesin);
		// echo "<pre>"; 
		// print_r($dataGET); exit();
		// pengelompokan data
		$array_sudah = array();
		$array_terkelompok = array();
		foreach ($dataGET as $key => $value) {
			if (!in_array($value['KONDISI_MESIN'], $array_sudah)) {
				array_push($array_sudah, $value['KONDISI_MESIN']);
				$getBody = $this->M_management->getDetail($value['NAMA_MESIN'], $value['KONDISI_MESIN']);

				$array_terkelompok[$value['KONDISI_MESIN']]['header'] = $value;
				$array_terkelompok[$value['KONDISI_MESIN']]['body'] = $getBody;
			}
		}
		$data['value'] = $array_terkelompok;
		$data['top'] = $this->M_management->getTop($mesin);
		$data['gambar'] = $this->M_management->getGambar($mesin);

		// echo "<pre>"; 
		// print_r($data); exit();

		$this->load->view('PeriodicalMaintenance/V_Result', $data);
	}

	// editTopManagement
	public function editTopManagement()
	{
		$id = $this->input->post('id');
		$dataa = $this->M_management->getTop($id);


		$edittop = '
		<div class="panel-body">                            
			<div class="col-md-5" style="text-align: right;"><label>Doc. No :</label></div>                                        
				<div class="col-md-5" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="nodoc" name="nodoc" value="' . $dataa[0]['NO_DOKUMEN'] . '" /></div>
				<input type="hidden" name="idTopEdit" id="idTopEdit" value="' . $id . '"/>
			</div>
			<div class="panel-body">                            
				<div class="col-md-5" style="text-align: right;"><label>Rev. No :</label></div>                                        
				<div class="col-md-5" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="norev" name="norev" value="' . $dataa[0]['NO_REVISI'] . '" /></div>
			</div>
			<div class="panel-body">                            
			<div class="col-md-5" style="text-align: right;"><label>Rev. Date :</label></div>                                        
			<div class="col-md-5" style="text-align: left;">
				<div class="input-group date">
					<input type="text" class="form-control pull-right" id="revdate" name="revdate" placeholder="DD/MM/YYYY" autocomplete="off" value="' . $dataa[0]['TANGGAL_REVISI'] . '">
					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
				</div>
			</div>
			</div>
			<div class="panel-body">                            
				<div class="col-md-5" style="text-align: right;"><label>Catatan Revisi :</label></div>                                        
				<div class="col-md-5" style="text-align: left;">
				<textarea style="width: 100%;text-align: left;" id="noterev" maxlength="500" name="noterev" class="form-control" >' . $dataa[0]['CATATAN_REVISI'] . '</textarea>
				</div>
			</div>
			<div class="panel-body">
				<div class="col-md-12" style="text-align:right"><button class="btn btn-success save-edit-top">Save</button></div>
			</div>';

		// <input type="text" autocomplete="off" required="required" class="form-control" id="revdate" name="revdate" value="' . $dataa[0]['TANGGAL_REVISI'] . '" />
		// <input type="text" autocomplete="off" required="required" class="form-control" id="noterev" name="noterev" value="' . $dataa[0]['CATATAN_REVISI'] . '" />

		echo $edittop;
	}

	// updateTopManagement
	public function updateTopManagement()
	{
		$id = $this->input->post('id');
		$noDoc = $this->input->post('noDoc');
		$noRev = $this->input->post('noRev');
		$revDate = $this->input->post('revDate');
		$noteRev = $this->input->post('noteRev');


		$this->M_management->updateTopManagement($id, $noDoc, $noRev, $revDate, $noteRev);
	}


	public function editSubManagement()
	{
		$id = $this->input->post('id');
		$dataa = $this->M_management->selectDataToEdit($id);

		if ($dataa[0]['PERIODE'] == "2 Mingguan") {
			$opsi = '<option selected>2 Mingguan</option>
			<option>Tahunan</option>';
		} else {
			$opsi = '<option>2 Mingguan</option>
			<option selected>Tahunan</option>';
		}

		$editmasterhandling = '
		<div class="panel-body">                            
			<div class="col-md-5" style="text-align: right;"><label>Uraian Kerja</label></div>                                        
				<div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="subHeaderEdit" name="subHeaderEdit" value="' . $dataa[0]['SUB_HEADER'] . '" /></div>
				<input type="hidden" name="idRowEdit" id="idRowEdit" value="' . $id . '"/>
			</div>
			<div class="panel-body">                            
				<div class="col-md-5" style="text-align: right;"><label>Standar</label></div>                                        
				<div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="standarEdit" name="standarEdit" value="' . $dataa[0]['STANDAR'] . '" /></div>
			</div>
			<div class="panel-body">                            
			<div class="col-md-5" style="text-align: right;"><label>Periode</label></div>                                        
			<div class="col-md-4" style="text-align: left;">
			<select id="periodeEdit" name="periodeEdit" class="form-control select2" style="width: 100%" data-placeholder="Periode" value="' . $dataa[0]['PERIODE'] . '">
			<option></option>
			<option>Harian</option>
			<option>Mingguan</option>
			<option>2 Mingguan</option>
			<option>Bulanan</option>
			<option>2 Bulanan</option>
			<option>3 Bulanan</option>
			<option>4 Bulanan</option>
			<option>5 Bulanan</option>
			<option>6 Bulanan</option>
			<option>8 Bulanan</option>
			<option>9 Bulanan</option>
			<option>Tahunan</option>
			<option>2 Tahunan</option>
			<option>3 Tahunan</option>
			<option>4 Tahunan</option>
			<option>5 Tahunan</option>
		</select>
			</div>
		</div>
			<div class="panel-body">
				<div class="col-md-12" style="text-align:right"><button class="btn btn-success button-save-edit">Save</button></div>
			</div>';


		echo $editmasterhandling;
	}

	public function updateSubManagement()
	{
		$id = $this->input->post('id');
		$subHeader = $this->input->post('subHeader');
		$standar = $this->input->post('standar');
		$periode = $this->input->post('periode');

		$this->M_management->updateSubManagement($id, $subHeader, $standar, $periode);
	}

	public function deleteSubManagement()
	{
		$id = $this->input->post('id');
		$this->M_management->deleteSubManagement($id);
	}

	public function upload()
	{

		// $name, $id = 0, $nama_file, 

		$mesin 	= $this->input->post('mesin');
		$temp_name = $_FILES['gambarMPA']['name']['0'];
		$imge = explode(".", $temp_name);

		$name = $mesin . '.' . $imge[1];

		// echo"<pre>"; print_r($name);exit;

		$path = './assets/upload/PeriodicalMaintenanceMPA/';

		if(!is_dir('./assets/upload/PeriodicalMaintenanceMPA/'))
		{
			mkdir('./assets/upload/PeriodicalMaintenanceMPA/', 0777, true);
			chmod('./assets/upload/PeriodicalMaintenanceMPA/', 0777);
		}

		// chmod('.assets/upload/PeriodicalMaintenanceMPA/', 0777);


		$config['upload_path']          = './assets/upload/PeriodicalMaintenanceMPA/';
		$config['allowed_types'] 		= 'gif|jpg|png';
		// $config['max_size']				= 1024;
		$config['file_name']		 	= $name;
		$config['overwrite'] 			= TRUE;


		// $this->load->library('upload');
		// $this->upload->initialize($config);

		$this->load->library('upload', $config);

		$this->upload->initialize($config); //Make this line must be here.
		
		if (!move_uploaded_file($temp_name, "assets/upload/PeriodicalMaintenanceMPA/" .$name)) {
			// echo "not mashok"; exit;

			$errorinfo = $this->upload->display_errors();
			echo $errorinfo;
			// exit();

		} else {
			
			// echo "masuk"; exit;

			if (file_exists("assets/upload/PeriodicalMaintenanceMPA/" .$name)) {
				$this->upload->data();

				redirect('PeriodicalMaintenance/Management');
			} else {
				$this->upload->data();
				$this->M_management->insertGambarMPA($mesin, $name);

				redirect('PeriodicalMaintenance/Management');
			}
		}


		// $mesin 	= $this->input->post('mesin');
		// $temp_name = $_FILES['gambarMPA']['tmp_name'];
		// $j = 1;
		// if (!is_dir('.assets/upload/PeriodicalMaintenanceMPA')) {
		// 	mkdir('.assets/upload/PeriodicalMaintenanceMPA', 0777, true);
		// 	chmod('.assets/upload/PeriodicalMaintenanceMPA', 0777);
		// } else {
		// 	chmod('.assets/upload/PeriodicalMaintenanceMPA', 0777);
		// }
		// for ($i = 0; $i < sizeof($temp_name); $i++) {
		// 	$img = $_FILES['gambarMPA']['name'][$i];
		// 	$imge = explode(".", $img);
		// 	$filename = "assets/upload/PeriodicalMaintenanceMPA/" . $mesin . '_' . $j . '.' . $imge[1];
		// 	if (file_exists($filename)) {
		// 		move_uploaded_file($temp_name[$i], $filename);
		// 	} else {
		// 		move_uploaded_file($temp_name[$i], $filename);
		// 	}
		// 	$j++;
		// 	$this->M_management->insertGambarMPA($mesin, $filename);
		// }

		// redirect('PeriodicalMaintenance/Management');
	}

	public function Uploadimg()
	{

		//For size

		// echo $_FILES["gambarMPA"]["size"]['0']; exit;

		if($_FILES["gambarMPA"]["size"]['0']>2097152) 
			{
			echo "File size should be less than 2MB";	
			exit;
			}

		// for extention

		$img = $_FILES['gambarMPA']['name']['0'];
		$ext = explode(".", $img);

		// echo $ext[1];	
		// 	exit;

		if($ext[1]=='jpg' || $ext[1]=='gif' || $ext[1]=='png' || $ext[1]=='jpeg' || $ext[1]=='JPG' || $ext[1]=='JPEG')
		{
		// echo "write the code to upload file";
		}
		else
		{
		echo "Only image file is allowed";
		exit;
		}

		$mesin 	= $this->input->post('mesin');
		$temp_name = $_FILES['gambarMPA']['tmp_name'];
		$j = 1;
		if (!is_dir('.assets/upload/PeriodicalMaintenanceMPA')) {
			mkdir('.assets/upload/PeriodicalMaintenanceMPA', 0777, true);
			chmod('.assets/upload/PeriodicalMaintenanceMPA', 0777);
		} else {
			chmod('.assets/upload/PeriodicalMaintenanceMPA', 0777);
		}
		for ($i = 0; $i < sizeof($temp_name); $i++) {
			$img = $_FILES['gambarMPA']['name'][$i];
			$imge = explode(".", $img);
			$filename = "assets/upload/PeriodicalMaintenanceMPA/" . $mesin . '_' . $j . '.' . $imge[1];
			if (file_exists($filename)) {
				move_uploaded_file($temp_name[$i], $filename);
			} else {
				move_uploaded_file($temp_name[$i], $filename);
				$this->M_management->insertGambarMPA($mesin, $filename);
			}
			$j++;
		}

		redirect('PeriodicalMaintenance/Management');
	}

	public function deleteImageMPA()
	{
        $this->checkSession();
		$user_id = $this->session->userid;
        $employee_code = $this->session->user;
        
        $mesin 	= $this->input->post('mesin');
		$path = $this->input->post('path');   

		unlink($path);
		$this->M_management->deleteImageMPA($mesin);
	}
	
	public function cetakForm(){

		$mesin = $this->input->post('list_mesin');
		$data['mesin'] = $mesin;
		$data['header'] = $this->M_management->getDataHeader($mesin);
		$data['gambar'] = $this->M_management->getDataGambar($mesin);

		$datapdf = $this->M_management->getdatapdf($mesin);

		$array_Resource = array();
		for ($i = 0; $i < sizeof($datapdf); $i++) {
			if ($datapdf[$i]['KONDISI_MESIN'] == null) {
				$alter[$i] = '';
			} else {
				$alter[$i] = $datapdf[$i]['KONDISI_MESIN'];
			}
			if ($datapdf[$i]['HEADER'] == null) {
				$altar[$i] = '';
			} else {
				$altar[$i] = $datapdf[$i]['HEADER'];
			}
			$array_Resource['KONDISI_MESIN'][$alter[$i]][$i] = $datapdf[$i]['SUB_HEADER'];
			$array_Resource['HEADER'][$alter[$i]][$i] = $datapdf[$i]['HEADER'];
			$array_Resource['HEADER'][$altar[$i]][$i] = $datapdf[$i]['HEADER'];
		}

		$array_pdf = array();
		$i = 0;
		foreach ($datapdf as $pdf) {

			$array_pdf[$i]['NAMA_MESIN'] = $pdf['NAMA_MESIN'];
			$array_pdf[$i]['KONDISI_MESIN'] = $pdf['KONDISI_MESIN'];
			$array_pdf[$i]['HEADER'] = $pdf['HEADER'];
			$array_pdf[$i]['SUB_HEADER'] = $pdf['SUB_HEADER'];
			$array_pdf[$i]['STANDAR'] = $pdf['STANDAR'];
			$array_pdf[$i]['PERIODE'] = $pdf['PERIODE'];
			$i++;
		}

		$data['arrayR'] = $array_Resource;
		$data['datapdf'] = $array_pdf;

		// echo "<pre>";
		// print_r(sizeof($data['datapdf']));
		// exit();

		// ob_start();
		// $this->load->library('pdf');
		// $pdf = $this->pdf->load();
		// $pdf = new mPDF('utf-8', 'f4', 0, '', 3, 3, 35, 3, 3, 3); //----- A5-L
		// $tglNama = date("d/m/Y-H:i:s");
		// $filename = 'Periodical_Maintenance_' . $tglNama . '.pdf';
		// $head = $this->load->view('PeriodicalMaintenance/V_Head', $data, true);
		// $html = $this->load->view('PeriodicalMaintenance/V_Detail', $data, true);
		// $foot = $this->load->view('PeriodicalMaintenance/V_Foot', $data, true);

		// ob_end_clean();
		// $pdf->shrink_tables_to_fit = 0;
		// $pdf->setHTMLHeader($head);
		// $pdf->setHTMLFooter($foot);												//-----> Pakai Library MPDF
		// $pdf->WriteHTML($html);

		// $pdf->Output($filename, 'I');

		ob_start();
		$this->load->library('Pdf');
		$pdf = $this->pdf->load();

		$margin_left = 3; // sizes are defines in millimetres
		$margin_right = 3;
		$margin_top = 40;
		$margin_bottom = 100;
		$header = 3;
		$footer = 3;
		$orientation = "P"; // can be P (Portrait) or L (Landscape)
		$pdf=new mPDF('utf-8',array(210,330), 0, '', $margin_left, $margin_right, $margin_top, $margin_bottom, $header, $footer, $orientation);

		$tglNama = date("d/m/Y-H:i:s");
		$filename = 'Periodical_Maintenance_' . $tglNama . '.pdf';
		$head = $this->load->view('PeriodicalMaintenance/V_Head', $data, true);
		$html = $this->load->view('PeriodicalMaintenance/V_Detail', $data, true);
		$foot = $this->load->view('PeriodicalMaintenance/V_Foot', $data, true);
		$html2 = $this->load->view('PeriodicalMaintenance/V_Cetakan_Lampiran', $data, true);

		ob_end_clean();
		$pdf->shrink_tables_to_fit = 1;
		$pdf->use_kwt = true; 
		$pdf->setHTMLHeader($head);
		$pdf->setHTMLFooter($foot);
		$pdf->WriteHTML($html);
		if(sizeof($data['gambar'])>0){
			$pdf->WriteHTML($html2);
		}

		$pdf->Output($filename, 'I');
	}
}
