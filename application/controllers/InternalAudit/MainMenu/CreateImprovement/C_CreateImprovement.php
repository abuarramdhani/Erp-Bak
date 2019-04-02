<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_CreateImprovement extends CI_Controller
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	        //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('InternalAudit/M_createimprovement');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}

		}

	public function checkSession()
		{
				if ($this->session->is_logged) {
				}else{
					redirect();
				}
		}

	public function index()
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['audit_object'] = $this->M_createimprovement->getAuditObject(null);
			$data['user_select'] = $this->M_createimprovement->getUser();
			$data['section_select'] = $this->M_createimprovement->getSection();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('InternalAudit/MainMenu/V_Style',$data);
			$this->load->view('InternalAudit/MainMenu/CreateImprovement/V_Index',$data);
			$this->load->view('V_Footer',$data);

		}

	public function saveDraftImprove1()
	{
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt','docx','pptx');
		$path = 'assets/upload/InternalAudit/FileHasilAudit/';
		$seksi = $this->input->post('slcSeksi');
		$object_audit = $this->input->post('slcObjectAudit');
		$date_periode = $this->input->post('datePeriod');
		if ($seksi) {
			$seksi = implode('<>', $seksi);
		}

		$data_periode = explode(' - ',$date_periode);
		$period_start = date('Y-m-d',strtotime($data_periode[0])) ;
		$period_end = date('Y-m-d',strtotime($data_periode[1])) ;
		$session_id = $this->session->__ci_last_regenerate;
		$user_id = $this->session->userid;

		// check if draft exist
		$check_existence = $this->M_createimprovement->check_existence($user_id,date('Y-m-d'));
		if ($check_existence) {
			$dataUpdate = array(
							'section' => $seksi,
							'audit_object' => $object_audit,
							'start_period' => $period_start,
							'end_period' => $period_end,
						);
			$id = $check_existence[0]['id'];
			$this->M_createimprovement->update_data($id,$dataUpdate);
		}else{
			// echo "we save it now";
			$dataSave = array(
							'user' => $user_id,
							'date' => date('Y-m-d'),
							'section' => $seksi,
							'audit_object' => $object_audit,
							'start_period' => $period_start,
							'end_period' => $period_end,
						);
			$saveAndGetID = $this->M_createimprovement->saveDraftImprove1($dataSave);
			$id = $saveAndGetID;
		}
		if ($_FILES['fileLapAudit']) {
			$file_name = $_FILES['fileLapAudit']['name'];
			$file_temp = $_FILES['fileLapAudit']['tmp_name'];
			$file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			// $final_image = rand(1000,1000000).$file_name;
			$path = $path.'LaporanAudit'.$id.'.'.$file_ext;

			if (in_array($file_ext, $valid_extensions)) {
				if(move_uploaded_file($file_temp,$path)){
						$dataUpdate = array(
								'file_hasil_audit' => 'LaporanAudit'.$id.'.'.$file_ext
							);
						$this->M_createimprovement->update_data($id,$dataUpdate);
						// echo "success";
					}
			}
		}
		$getAuditObject = $this->M_createimprovement->getAuditObject($object_audit);
		$data_kirim['pic_auditee'] = $getAuditObject[0]['employee_name'];
		echo json_encode($data_kirim);


	}

	public function SaveImprovement()
	{
		// echo "<pre>";
		// print_r($_FILES);
		// print_r($_POST);
		// exit();
		$user_id = $this->session->userid;
		$project_number = $this->input->post('txt_project_number');
		$improve_rekomendasi = $this->input->post('txtImproveRekomendasi');
		$improve_kondisi = $this->input->post('txtImproveKon');
		$improve_kriteria = $this->input->post('txtImproveKrit');
		$improve_akibat = $this->input->post('txtImproveAkib');
		$improve_penyebab = $this->input->post('txtImprovePenyeb');
		$improve_status = $this->input->post('slcStatusImprove');
		$improve_duedate = $this->input->post('dueDateImprove');
		$improve_targetindicator = $this->input->post('targetIndicatorImprove');
		$improve_pic = $this->input->post('slcPicImprove');

		$session_id = $this->session->__ci_last_regenerate;
		$user_id = $this->session->userid;
		$date = date('Y-m-d');

		$getDataHeader = $this->M_createimprovement->getDataHeader($user_id,$date);
		if ($getDataHeader) {
			$id_draft =  $getDataHeader[0]['id'];
			$dataSave1 = $getDataHeader[0];
			$dataSave1['creation_date'] = 'now()';
			$dataSave1['created_by'] = $user_id;
			unset($dataSave1['id']);
			unset($dataSave1['user']);
			unset($dataSave1['date']);
			unset($dataSave1['session']);
			$saveGetId = $this->M_createimprovement->SaveImprovementHeader($dataSave1);
			$id = $saveGetId;

			if ($_FILES['fileProjectNumber']) {
				$file_name = $_FILES['fileProjectNumber']['name'];
				$file_temp = $_FILES['fileProjectNumber']['tmp_name'];
				$file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
				$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt','docx','pptx');
				$path = 'assets/upload/InternalAudit/FileSuratTugas/';
				$path = $path.'SuratTugas'.'_'.$id.'.'.$file_ext;

				if (in_array($file_ext, $valid_extensions)) {
					if(move_uploaded_file($file_temp,$path)){
							$dataUpdate = array(
									'project_number' =>$project_number,
									'file_surat_tugas' => 'SuratTugas'.'_'.$id.'.'.$file_ext
								);
							$this->M_createimprovement->update_data_header($id,$dataUpdate);
						}
				}
			}

			foreach ($improve_rekomendasi as $key => $value) {
				if ($value) {
					$dataSave =  array('improvement_id' => $saveGetId , 
									'rekomendasi' => $improve_rekomendasi[$key], 
									'kondisi' => $improve_kondisi[$key], 
									'kriteria' => $improve_kriteria[$key],
									'akibat' => $improve_akibat[$key],
									'penyebab' => $improve_penyebab[$key],
									'status' => $improve_status[$key],
									'duedate' => ($improve_duedate[$key] ? date('Y-m-d',strtotime($improve_duedate[$key])) : null),
									'target_indicator' => $improve_targetindicator[$key],
									'pic' => $improve_pic[$key],
									'creation_date' => 'now()',
									'created_by' => $user_id);
					$this->M_createimprovement->SaveImprovementList($dataSave);
				}
			}

			$deleteDraft = $this->M_createimprovement->deleteDraft($id_draft);
		}else{
			redirect(base_url('InternalAudit/CreateImprovement'));
		}
		redirect(base_url('InternalAudit/CreateImprovement'));
	}


	public function getDetailAuditor()
	{
		$id = $this->input->post('id');
		$getData = $this->M_createimprovement->getData($id);
		$getDetailAuditee = $this->M_createimprovement->getDetailAuditee($id);
		$getDetailAuditor = $this->M_createimprovement->getDetailAuditor($id);
		$data['detail'] = $getData;
		$data['auditee'] = $getDetailAuditee;
		$data['auditor'] = $getDetailAuditor;

		echo json_encode($data);
	}

	public function getStaffAuditor()
	{
		$term = strtoupper($this->input->post('term'));
		$id_audit_object = $this->input->post('id');
		$auditee = $this->M_createimprovement->getStaffAuditee($term,$id_audit_object);
		echo json_encode($auditee);

	}

}