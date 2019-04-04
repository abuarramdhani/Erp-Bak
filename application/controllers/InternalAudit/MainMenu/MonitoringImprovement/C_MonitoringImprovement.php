<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_MonitoringImprovement extends CI_Controller
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
			$this->load->model('InternalAudit/M_monitoringimprovement');
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
			$getDataImprovement = $this->M_monitoringimprovement->getDataImprovement(null);
			$Improvement = array();
			$JmlComplete = 0;
			$pathFileHasil = base_url('assets/upload/InternalAudit/FileHasilAudit/');
			$pathFileSurat = base_url('assets/upload/InternalAudit/FileSuratTugas/');
				foreach ($getDataImprovement as $key => $value) {
					$progress = $JmlComplete = 0;
					$getDetailImprovement = $this->M_monitoringimprovement->getDetailImprovement($value['id']);
					foreach ($getDetailImprovement as $kD => $vD) {
						if ($vD['status'] == '1') {
							$JmlComplete += 1;
						}
					}
					if (count($getDetailImprovement) > 0) {
						$progress = ($JmlComplete/count($getDetailImprovement) ) *100;
					}else{
						$progress = 0;
					}
					if ($progress < 50) {
						$sign_progress = 'btn-default';
					}elseif ($progress < 100) {
						$sign_progress = 'btn-warning';
					}else{
						$sign_progress = 'bg-success';
					}

					if ($progress == 100) {
						$sign_print = 'bg-info';
					}else{
						$sign_print = 'bg-default disabled';
					}

					$Improvement[$key]['no'] = $key+1;
					$Improvement[$key]['id'] = $value['id'];
					$Improvement[$key]['section_name'] = str_replace('<>', ' ;<br/>', $value['section']);
					$Improvement[$key]['audit_object_id'] = $value['audit_object'];
					$Improvement[$key]['audit_object_name'] = $value['audit_object_name'];
					$Improvement[$key]['start_period'] = $value['start_period'] ? date('d/M/Y',strtotime($value['start_period'])) : '--';
					$Improvement[$key]['end_period'] = $value['end_period'] ? date('d/M/Y',strtotime($value['end_period'])) : '--';
					$Improvement[$key]['project_number'] = $value['project_number'];
					$Improvement[$key]['file_surat_tugas'] = $value['file_surat_tugas'];
					$Improvement[$key]['link_file_st'] = $pathFileSurat.'/'.$value['file_surat_tugas'];
					$Improvement[$key]['file_hasil_audit'] = $value['file_hasil_audit'];
					$Improvement[$key]['link_file_ha'] = $pathFileHasil.'/'.$value['file_hasil_audit'];
					$Improvement[$key]['progress'] = $progress;
					$Improvement[$key]['sign_progress'] =$sign_progress;
					$Improvement[$key]['sign_print'] =$sign_print;

				}

			// exit();
			$data['dataImprovement'] = $Improvement;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('InternalAudit/MainMenu/V_Style',$data);
			$this->load->view('InternalAudit/MainMenu/MonitoringImprovement/V_Index',$data);
			$this->load->view('V_Footer',$data);

		}

	public function Detail($id)
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$getDetailImprovement = $this->M_monitoringimprovement->getDetailImprovement($id);
			$DetailImprovement = array();
			$data['improvement_id'] = $id;

				foreach ($getDetailImprovement as $key => $value) {
					$type_progress = '';
					$a = new DateTime(date('Y-m-d'));
					$b = new DateTime($value["duedate"]);
					$c = $a->diff($b);
					$diff = $c->days;

					if ($value['status'] == '0') {
						if ($a < $b) {
							if ($diff < 7) {
								$duedate_sign = "btn-warning faa-flash faa-slow animated";
							}else{
								$duedate_sign = "btn-default";
							}
						}elseif ($a == $b) {
								$duedate_sign = "btn-danger faa-flash faa-slow animated";
						}else{
								$duedate_sign = "btn-danger faa-flash faa-slow animated";
						}
					}else{
						$duedate_sign = "btn-default";
					}

					$getProgress =  $this->M_monitoringimprovement->getProgress($value['id']);
					if ($getProgress) {
						$last_modified_date = ($getProgress[0]['creation_date']) 
											  ? date('d-M-Y H:i:s',strtotime($getProgress[0]['creation_date'])) 
											  : '--'  ;
						$last_modified_by = $getProgress[0]['created_by'] ? $getProgress[0]['created_by_name'] : ' -- ';
						$last_modified_by_id = $getProgress[0]['created_by'] ?  $getProgress[0]['created_by'] :  '';
						
						$id_progress = $getProgress[0]['id'];
						$getUpdateHistory = $this->M_monitoringimprovement->getUpdateHistory($id_progress);
						$type_progress = $getUpdateHistory[0]['type'];

					}else{
						$last_modified_date = $value['update_date'] ? date('d-M-Y H:i:s',strtotime($value['update_date'])) 
										: ($value['creation_date'] ? date('d-M-Y H:i:s',strtotime($value['creation_date'])) : '--' ) ;
						$last_modified_by = $value['updated_by'] ? $value['updated_by_name'] 
										: ($value['created_by'] ? $value['created_by_name'] : ' -- ');
						$last_modified_by_id =  $value['updated_by'] ?  $value['updated_by'] :  $value['created_by'];
					}

					$DetailImprovement[$key]['id'] = $value['id'];
					$DetailImprovement[$key]['no'] = $key+1;
					$DetailImprovement[$key]['type_progress'] = $type_progress;
					$DetailImprovement[$key]['improvement_id'] = $value['improvement_id'];
					$DetailImprovement[$key]['improve_rekomendasi'] = $value['rekomendasi'];
					$DetailImprovement[$key]['improve_kondisi'] = $value['kondisi'];
					$DetailImprovement[$key]['improve_kriteria'] = $value['kriteria'];
					$DetailImprovement[$key]['improve_akibat'] = $value['akibat'];
					$DetailImprovement[$key]['improve_penyebab'] = $value['penyebab'];
					$DetailImprovement[$key]['status_id'] = $value['status'];
					$DetailImprovement[$key]['status_name'] = $value['status_name'];
					$DetailImprovement[$key]['duedate'] = $value['duedate'];
					$DetailImprovement[$key]['duedate_sign'] = $duedate_sign;
					$DetailImprovement[$key]['target_indicator'] = $value['target_indicator'];
					$DetailImprovement[$key]['pic_id'] = $value['pic'];
					$DetailImprovement[$key]['pic_name'] = $value['pic_name'];
					$DetailImprovement[$key]['last_modified_date'] = $last_modified_date;
					$DetailImprovement[$key]['last_modified_by'] = $last_modified_by;
					$DetailImprovement[$key]['last_modified_by_id'] = $last_modified_by_id;
				}
			// echo "<pre>";
			// print_r($getDetailImprovement);
			// exit();
			$data['detailImprovement'] = $DetailImprovement;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('InternalAudit/MainMenu/V_Style',$data);
			$this->load->view('InternalAudit/MainMenu/MonitoringImprovement/V_Detail',$data);
			$this->load->view('V_Footer',$data);
		}


	public function DetailCompletion($id)
	{
		$data['jenis'] = 'completion_report';
		$this->load->view('InternalAudit/V_Temp',$data);
	}

	public function getDetailProgressHistory()
	{
		$imp_list_id = $this->input->post('imp_list_id');
		$imp_id = $this->input->post('imp_id');
		$getProgress = $this->M_monitoringimprovement->getProgress($imp_list_id);
		$progress = array();
		$path_fileprogress = base_url('assets/upload/InternalAudit/FileProgress/');
		$date_modified = '';
		$attachment_sign = '';
		$modified_by = '';
		$link_attachment = '';
		foreach ($getProgress as $key => $value) {
			$attachment_sign = $value['attachment_file'] ? 'btn-success' : 'btn-default';
			$link_attachment = $value['attachment_file'] ? $path_fileprogress.'/'.$value['attachment_file'] : '#';

			$getUpdateHistory = $this->M_monitoringimprovement->getUpdateHistory($value['id']);
			$modified_by = $getUpdateHistory[0]['updated_by_name'];
			$date_modified = date('d/m/Y H:i:s',strtotime($getUpdateHistory[0]['update_date']));
			if (count($getUpdateHistory) > 1) {
				$sign_show_history = '1';
			}else{
				$sign_show_history = '0';
			}

			$type = $getUpdateHistory[0]['type'];


			if ($getUpdateHistory[0]['type'] == '5' || $getUpdateHistory[0]['type'] == '6') {
				$sign_req_close = 'bg-request';
			}else{
				$sign_req_close = '';
			}

			$progress[$key]['id'] = $value['id'];
			$progress[$key]['no'] = $key+1;
			$progress[$key]['date'] = $date_modified;
			$progress[$key]['description'] = $value['description'];
			$progress[$key]['attachment'] = $value['attachment_file'];
			$progress[$key]['link_attachment'] = $link_attachment;
			$progress[$key]['attachment_sign'] = $attachment_sign;
			$progress[$key]['modified_by'] = $modified_by;
			$progress[$key]['modified_by_id'] = $getUpdateHistory[0]['updated_by'];
			$progress[$key]['auditor_response'] = $value['auditor_response'];
			$progress[$key]['sign_show_history'] = $sign_show_history;
			$progress[$key]['type'] = $type;
			$progress[$key]['sign_req_close'] = $sign_req_close;
		}
		$data['imp_list_id'] = $imp_list_id;
		$data['imp_id'] = $imp_id;
		$data['progress'] = $progress;
		$data['jenis'] = 'detail_progress_auditor';
		$this->load->view('InternalAudit/V_Temp',$data);
	}

	public function DeleteImprovement()
	{
		$id =  $this->input->post('improvement_id');
		$dirHA = './assets/upload/InternalAudit/FileHasilAudit/';
		$dirST = './assets/upload/InternalAudit/FileSuratTugas/';
		$dirPG = './assets/upload/InternalAudit/FileProgress/';
		$getDataImprovement = $this->M_monitoringimprovement->getDataImprovement($id);
		$getDetailImprovement = $this->M_monitoringimprovement->getProgressByImprovementId($id);
		foreach ($getDataImprovement as $key => $value) {
			if ($value['file_hasil_audit']) {
				$fileHA = $dirHA.$value['file_hasil_audit'];
					if (is_file($fileHA)) {
						unlink($fileHA);
					}
			}
			if ($value['file_surat_tugas']) {
				$fileST = $dirST.$value['file_surat_tugas'];
					if (is_file($fileST)) {
						unlink($fileST);
					}
			}
		}
		foreach ($getDetailImprovement as $key2 => $value2) {
			if ($value2['attachment_file']) {
				$filePG = $dirPG.$value2['attachment_file'];
				if (is_file($filePG)) {
						unlink($filePG);
				}
			}
		}
		$this->M_monitoringimprovement->DeleteImprovement($id);
		$this->M_monitoringimprovement->DeleteImprovementList($id);
		$this->M_monitoringimprovement->DeleteProgressImprovement($id);
		redirect('InternalAudit/MonitoringImprovement');
	}

	public function SaveResponse()
	{
		$user_id = $this->session->userid;
		$id = $this->input->post('id_response');
		$id_detail = $this->input->post('id_detail');
		$id_imp = $this->input->post('id_improvement');
		$response = $this->input->post('auditorReply');
		$approve = $this->input->post('approveAuditor');
		$type = 3;
		if ($approve) {
			$type = 6;
		}

		$dataUpdate1 = array('status' => '1',
								'update_date' => 'now()',
								'updated_by' => $user_id);
		$this->M_monitoringimprovement->updateImprovementList($id_detail,$dataUpdate1);


		$dataUpdate = array('auditor_response' => $response,
							'update_date' => 'now()',
							'updated_by' => $user_id );
		$this->M_monitoringimprovement->UpdateProgress($id,$dataUpdate);

		$dataSave2 = array( 
				'progress_id' => $id,
				'auditor_response' => $response,
				'update_date' => 'now()',
				'updated_by' => $user_id,
				'type' => $type
			);
		$this->M_monitoringimprovement->SaveProgressHistory($dataSave2);
		redirect(base_url('InternalAudit/MonitoringImprovement/Detail/'.$id_imp));

	}

	public function Edit($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['section_select'] = $this->M_monitoringimprovement->getSection();
		$data['audit_object'] = $this->M_monitoringimprovement->getAuditObjectSelect(null);
		$getDataImprovement = $this->M_monitoringimprovement->getDataImprovement($id);
		foreach ($getDataImprovement as $key => $value) {
			$linkfileHA = ($value['file_hasil_audit']) ? base_url('assets/upload/InternalAudit/FileHasilAudit/'.$value['file_hasil_audit']) : '';
			$linkfileST = ($value['file_surat_tugas']) ? base_url('assets/upload/InternalAudit/FileSuratTugas/'.$value['file_surat_tugas']) : '';
			$dataImprovement['id'] = $value['id'];
			$dataImprovement['seksi'] = explode('<>', $value['section']);
			$dataImprovement['audit_object'] = $value['audit_object'];
			$dataImprovement['period'] = date('m/d/Y',strtotime($value['start_period'])).' - '.date('m/d/Y',strtotime($value['end_period']));
			$dataImprovement['fileHA'] = $value['file_hasil_audit'];
			$dataImprovement['linkfileHA'] = $linkfileHA;
			$dataImprovement['fileST'] = $value['file_surat_tugas'];
			$dataImprovement['linkfileST'] = $linkfileST;
			$dataImprovement['project_number'] = $value['project_number'];
		}
		$data['dataImprovement'] = $dataImprovement;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('InternalAudit/MainMenu/V_Style',$data);
		$this->load->view('InternalAudit/MainMenu/MonitoringImprovement/V_Edit',$data);
		$this->load->view('V_Footer',$data);

	}

	public function DeleteImprovementList()
	{
		$id =  $this->input->post('improvement_list_id');
		$improvement_id =  $this->input->post('improvement_id');
		$dirPG = './assets/upload/InternalAudit/FileProgress/';
		$getDetailImprovement = $this->M_monitoringimprovement->getProgressByImprovemenListtId($id);
		foreach ($getDetailImprovement as $key2 => $value2) {
			if ($value2['attachment_file']) {
				$filePG = $dirPG.$value2['attachment_file'];
				if (is_file($filePG)) {
						unlink($filePG);
				}
			}
		}
		$this->M_monitoringimprovement->DeleteProgressByImprovementListId($id);
		$this->M_monitoringimprovement->DeleteImprovementListByImprovementListId($id);
		redirect('InternalAudit/MonitoringImprovement/Detail/'.$improvement_id);
	}

	public function SaveEdit()
	{
		$user_id = $this->session->userid;
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt','docx','pptx');
		$dataUpdate = array();
		$improvement_id = $this->input->post('id_improvement');
		$section = $this->input->post('slcSeksi');
		$audit_object = $this->input->post('slcObjectAudit');
		$period = $this->input->post('datePeriod');
		$project_number = $this->input->post('txtNomorProject');
		$data_periode = explode(' - ',$period);
		$period_start = date('Y-m-d',strtotime($data_periode[0]));
		$period_end = date('Y-m-d',strtotime($data_periode[1]));
		if ($section) {
			$section = implode('<>', $section);
		}

		$dataUpdate = array(
							'section' => $section,
							'audit_object' => $audit_object,
							'start_period' => $period_start,
							'end_period' => $period_end,
							'project_number' => $project_number,
						);

		if (file_exists($_FILES['fileLapAudit']['tmp_name']) || is_uploaded_file($_FILES['fileLapAudit']['tmp_name'])){
			$file_name = $_FILES['fileLapAudit']['name'];
			$file_temp = $_FILES['fileLapAudit']['tmp_name'];
			$file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$path = 'assets/upload/InternalAudit/FileHasilAudit/';
			$path = $path.'LaporanAudit'.$improvement_id.'.'.$file_ext;

			if (in_array($file_ext, $valid_extensions)) {
				$nama_file = 'FileProgress'.$improvement_id.'.'.$file_ext;
				if(move_uploaded_file($file_temp,$path)){
						$dataUpdate['file_hasil_audit'] ='LaporanAudit'.$improvement_id.'.'.$file_ext;
					}
			}
		}

		if (file_exists($_FILES['fileProjectNumber']['tmp_name']) || is_uploaded_file($_FILES['fileProjectNumber']['tmp_name'])){
				$file_name = $_FILES['fileProjectNumber']['name'];
				$file_temp = $_FILES['fileProjectNumber']['tmp_name'];
				$file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
				$path = 'assets/upload/InternalAudit/FileSuratTugas/';
				$path = $path.'SuratTugas'.'_'.$improvement_id.'.'.$file_ext;

				if (in_array($file_ext, $valid_extensions)) {
					$nama_file = 'SuratTugas'.'_'.$improvement_id.'.'.$file_ext;
					if(move_uploaded_file($file_temp,$path)){
							$dataUpdate['file_surat_tugas'] = 'SuratTugas'.'_'.$improvement_id.'.'.$file_ext;
						}
				}
		}

		$dataUpdate['update_date'] = 'now()';
		$dataUpdate['update_by'] = $user_id;

		$this->M_monitoringimprovement->SaveUpdateImprovement($improvement_id,$dataUpdate);
		redirect('InternalAudit/MonitoringImprovement');
	}

	public function AddNewImprovement($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$getDataImprovement = $this->M_monitoringimprovement->getDataImprovement($id);
		$audit_object  = $getDataImprovement[0]['audit_object'];
		$getDataPIC = $this->M_createimprovement->getData($audit_object);
		$getAuditeeOption = $this->M_createimprovement->getDetailAuditee($audit_object);
		foreach ($getDataPIC as $key => $value) {
			$getAuditeeOption[] = $value;
		}
		$data['auditeeOption'] = $getAuditeeOption;
		$DetailImprovement = array();
		$data['improvement_id'] = $id;

		$data['detailImprovement'] = $DetailImprovement;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('InternalAudit/MainMenu/V_Style',$data);
		$this->load->view('InternalAudit/MainMenu/MonitoringImprovement/V_AddNewImprovement',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SaveNewImprovement()
	{
		$user_id = $this->session->userid;
		$improvement_id = $this->input->post('improvement_id');
		$improve_rekomendasi = $this->input->post('txtImproveRekomendasi');
		$improve_kondisi = $this->input->post('txtImproveKon');
		$improve_kriteria = $this->input->post('txtImproveKrit');
		$improve_akibat = $this->input->post('txtImproveAkib');
		$improve_penyebab = $this->input->post('txtImprovePenyeb');
		$improve_status = $this->input->post('slcStatusImprove');
		$improve_duedate = $this->input->post('dueDateImprove');
		$improve_targetindicator = $this->input->post('targetIndicatorImprove');
		$improve_pic = $this->input->post('slcPicImprove');

		foreach ($improve_rekomendasi as $key => $value) {
			$dataSave =  array('improvement_id' => $improvement_id , 
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

		redirect('InternalAudit/MonitoringImprovement/Detail/'.$improvement_id);

	}


	public function EditDetail($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getDataImprovementList = $this->M_monitoringimprovement->getDataImprovementList($id);
		$id_improvement = $getDataImprovementList[0]['improvement_id'];
		$getDataImprovement = $this->M_monitoringimprovement->getDataImprovement($id_improvement);
		$audit_object  = $getDataImprovement[0]['audit_object'];
		$getDataPIC = $this->M_createimprovement->getData($audit_object);
		$getAuditeeOption = $this->M_createimprovement->getDetailAuditee($audit_object);
		foreach ($getDataPIC as $key => $value) {
			$getAuditeeOption[] = $value;
		}
		$data['auditeeOption'] = $getAuditeeOption;
		$DetailImprovement = array();
		$data['improvement_id'] = $id_improvement;
		$data['improvement_list_id'] = $id;
		$data['data_improve'] = $getDataImprovementList;

		$data['detailImprovement'] = $DetailImprovement;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('InternalAudit/MainMenu/V_Style',$data);
		$this->load->view('InternalAudit/MainMenu/MonitoringImprovement/V_EditImprovement',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SaveEditImprovement()
	{
		$user_id = $this->session->userid;
		$improvement_id = $this->input->post('improvement_id');
		$improvement_list_id = $this->input->post('improvement_list_id');
		$improve_rekomendasi = $this->input->post('txtImproveRekomendasi');
		$improve_kondisi = $this->input->post('txtImproveKon');
		$improve_kriteria = $this->input->post('txtImproveKrit');
		$improve_akibat = $this->input->post('txtImproveAkib');
		$improve_penyebab = $this->input->post('txtImprovePenyeb');
		$improve_status = $this->input->post('slcStatusImprove');
		$improve_duedate = $this->input->post('dueDateImprove');
		$improve_targetindicator = $this->input->post('targetIndicatorImprove');
		$improve_pic = $this->input->post('slcPicImprove');

		foreach ($improve_rekomendasi as $key => $value) {
			$dataUpdate =  array(
							'rekomendasi' => $improve_rekomendasi[$key], 
							'kondisi' => $improve_kondisi[$key], 
							'kriteria' => $improve_kriteria[$key],
							'akibat' => $improve_akibat[$key],
							'penyebab' => $improve_penyebab[$key],
							'status' => $improve_status[$key],
							'duedate' => ($improve_duedate[$key] ? date('Y-m-d',strtotime($improve_duedate[$key])) : null),
							'target_indicator' => $improve_targetindicator[$key],
							'pic' => $improve_pic[$key],
							'update_date' => 'now()',
							'updated_by' => $user_id);
			$this->M_monitoringimprovement->updateImprovementList($improvement_list_id,$dataUpdate);
		}

		redirect('InternalAudit/MonitoringImprovement/Detail/'.$improvement_id);
	}

}