<?php defined('BASEPATH') or die('No direct script access allowed');
class C_MonitoringImprovement extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('form');

		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('InternalAudit/M_monitoringimprovement');

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
			$arrayAuditObject = array(); $auditObject = '';
			$getAuditObject = $this->M_monitoringimprovement->getAuditObject($user_id);
			if ($getAuditObject) {
				foreach ($getAuditObject as $key => $value) {
					array_push($arrayAuditObject, $value['audit_object']);
				}
				$auditObject = implode("','", $arrayAuditObject);
			}
			$getDataImprovement = $this->M_monitoringimprovement->getDataImprovementAuditee($auditObject);
			$Improvement = array();
			$JmlComplete = 0;
			$pathFileHasil = base_url('assets/upload/InternalAudit/FileHasilAudit/');
			$pathFileSurat = base_url('assets/upload/InternalAudit/FileSuratTugas/');
				foreach ($getDataImprovement as $key => $value) {
					$JmlComplete =0;
					$getDetailImprovement = $this->M_monitoringimprovement->getDetailImprovement($value['id']);
					foreach ($getDetailImprovement as $kD => $vD) {
						if ($vD['status'] == '1') {
							$JmlComplete += 1;
						}
					}
					$progress = ($JmlComplete/count($getDetailImprovement) ) *100;
					if ($progress < 50) {
						$sign_progress = 'btn-default';
					}elseif ($progress < 100) {
						$sign_progress = 'btn-warning';
					}else{
						$sign_progress = 'bg-success';
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
					

				}

			// exit();
			$data['dataImprovement'] = $Improvement;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('InternalAudit/MainMenu/V_Style',$data);
			$this->load->view('InternalAudit/MainMenu/Auditee/MonitoringImprovement/V_Index',$data);
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

				foreach ($getDetailImprovement as $key => $value) {
					$a = new DateTime(date('Y-m-d'));
					$b = new DateTime($value["duedate"]);
					$c = $a->diff($b);
					$diff = $c->days;

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

					$getProgress =  $this->M_monitoringimprovement->getProgress($value['id']);
					if ($getProgress) {
						$last_modified_date = ($getProgress[0]['creation_date']) 
											  ? date('d-M-Y H:i:s',strtotime($getProgress[0]['creation_date'])) 
											  : '--'  ;
						$last_modified_by = $getProgress[0]['created_by'] ? $getProgress[0]['created_by_name'] : ' -- ';
					}else{
						$last_modified_date = $value['update_date'] ? date('d-M-Y H:i:s',strtotime($value['update_date'])) 
										: ($value['creation_date'] ? date('d-M-Y H:i:s',strtotime($value['creation_date'])) : '--' ) ;
						$last_modified_by = $value['updated_by'] ? $value['updated_by_name'] 
										: ($value['created_by'] ? $value['created_by_name'] : ' -- ');
					}


					$DetailImprovement[$key]['id'] = $value['id'];
					$DetailImprovement[$key]['no'] = $key+1;
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
				}
			$data['detailImprovement'] = $DetailImprovement;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('InternalAudit/MainMenu/V_Style',$data);
			$this->load->view('InternalAudit/MainMenu/Auditee/MonitoringImprovement/V_Detail',$data);
			$this->load->view('V_Footer',$data);
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


			if ($getUpdateHistory[0]['type'] == '5') {
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
			$progress[$key]['auditor_response'] = $value['auditor_response'];
			$progress[$key]['sign_show_history'] = $sign_show_history;
			$progress[$key]['type'] = $type;
			$progress[$key]['sign_req_close'] = $sign_req_close;
		}
		$data['imp_list_id'] = $imp_list_id;
		$data['imp_id'] = $imp_id;
		$data['progress'] = $progress;
		$data['jenis'] = 'detail_progress';
		$this->load->view('InternalAudit/V_Temp',$data);
	}

	public function SaveProgress()
	{
		$user_id = $this->session->userid;
		$improvement_id = $this->input->post('improvement_id');
		$improvement_list_id = $this->input->post('improvement_list_id');
		$description = $this->input->post('txtDescProgress');
		$type = $this->input->post('typeProgress');
		$nama_file = '';
		$dataSave = array(
				'improvement_id' => $improvement_id,
				'improvement_list_id' => $improvement_list_id,
				'description' => $description,
				'creation_date' => 'now()',
				'created_by' => $user_id
			);
		if (!$type) {
			$type = '1';
		}
		$saveGetId = $this->M_monitoringimprovement->SaveProgress($dataSave);
		$id = $saveGetId;
		
		if ($_FILES['fileProgress']) {
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt','docx','pptx');
			$file_name = $_FILES['fileProgress']['name'];
			$file_temp = $_FILES['fileProgress']['tmp_name'];
			$file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$path = 'assets/upload/InternalAudit/FileProgress/';
			$path = $path.'FileProgress'.$id.'.'.$file_ext;

			if (in_array($file_ext, $valid_extensions)) {
				$nama_file = 'FileProgress'.$id.'.'.$file_ext;
				if(move_uploaded_file($file_temp,$path)){
						$dataUpdate = array(
								'attachment_file' => 'FileProgress'.$id.'.'.$file_ext
							);
						$this->M_monitoringimprovement->UpdateProgress($id,$dataUpdate);
					}
			}else{
				$description .= '<br/> <extensi attachment_file tidak sesuai : '.$file_ext.'>';
			}
		}
		$dataSave2 = array( 
				'progress_id' => $id,
				'description' => $description,
				'attachment_file' => $nama_file,
				'update_date' => 'now()',
				'updated_by' => $user_id,
				'type' => $type
			);
		$this->M_monitoringimprovement->SaveProgressHistory($dataSave2);

		redirect(base_url('InternalAudit/MonitoringImprovementAuditee/Detail/'.$improvement_id));
	}

	public function saveEditProgress()
	{
		$user_id = $this->session->userid;
		$id = $this->input->post('id');
		$improvement_id = $this->input->post('improvement_id');
		$improvement_list_id = $this->input->post('improvement_list_id');
		$description = $this->input->post('txtDescProgress');
		$type = $this->input->post('typeProgress');
		$nama_file = '';
		$dataUpdate = array(
				'improvement_id' => $improvement_id,
				'improvement_list_id' => $improvement_list_id,
				'description' => $description,
				'update_date' => 'now()',
				'updated_by' => $user_id
			);
		$this->M_monitoringimprovement->UpdateProgress($id,$dataUpdate);
		if (!$type) {
			$type = '1';
		}
		
		if ($_FILES['fileProgress']) {
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt','docx','pptx');
			$file_name = $_FILES['fileProgress']['name'];
			$file_temp = $_FILES['fileProgress']['tmp_name'];
			$file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$path = 'assets/upload/InternalAudit/FileProgress/';
			$path = $path.'FileProgress'.$id.'.'.$file_ext;

			if (in_array($file_ext, $valid_extensions)) {
				$nama_file = 'FileProgress'.$id.'.'.$file_ext;
				if(move_uploaded_file($file_temp,$path)){
						$dataUpdate = array(
								'attachment_file' => 'FileProgress'.$id.'.'.$file_ext
							);
						$this->M_monitoringimprovement->UpdateProgress($id,$dataUpdate);
					}
			}else{
				$description .= '<br/> <extensi attachment_file tidak sesuai : '.$file_ext.'>';
			}
		}
		$dataSave2 = array( 
				'progress_id' => $id,
				'description' => $description,
				'attachment_file' => $nama_file,
				'update_date' => 'now()',
				'updated_by' => $user_id,
				'type' => $type
			);
		$this->M_monitoringimprovement->SaveProgressHistory($dataSave2);

		redirect(base_url('InternalAudit/MonitoringImprovementAuditee/Detail/'.$improvement_id));
	}

}