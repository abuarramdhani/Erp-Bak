<?php defined('BASEPATH')OR die('No direct script access allowed');
class C_Submit extends CI_Controller {

	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		if(!$this->session->userdata('logged_in')) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('SystemIntegration/M_submit');
		$this->load->model('SystemIntegration/M_log');
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
			// $data['master_item'] = $this->M_submit->getMasterItem();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SystemIntegration/MainMenu/Submit/V_Index',$data);
			$this->load->view('V_Footer',$data);

		}


   public function upload()
		 {
		   $config = array('upload_path' => './assets/upload_kaizen/',
		                'upload_url' => base_url()  . './assets/upload_kaizen/',
		                'allowed_types' => 'jpg|gif|png',
		                'overwrite' => false,
		    );

		    $this->load->library('upload', $config);

		    if ($this->upload->do_upload('file')) {
		        $data = $this->upload->data();
		        $array = array(
		            'filelink' => $config['upload_url'] . $data['file_name']
		        );
		        echo stripslashes(json_encode($array));
		    } else {
		        echo json_encode(array('error' => $this->upload->display_errors('', '')));
		    }
		}

	public function create()
	{
		$this->checkSession();
		$data['user'] = $this->session->userdata('logged_in');

		$this->form_validation->set_rules('txtJudul', 'Judul Ide Kaizen', 'required');
		$this->form_validation->set_rules('txtNoInduk', 'Nomor Induk', 'required');
		$this->form_validation->set_rules('txtPencetus', 'Pencetus Ide Kaizen', 'required');
		$this->form_validation->set_rules('txtRencanaRealisasi', 'Rencana Realisasi', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('SystemIntegration/MainMenu/Submit/V_Index',$data);
			$this->load->view('V_Footer');
		} else {
			if (strpos($this->input->post('txtKondisiAwal'), '<img src') !== false) {
    			$kondisi_awal = str_replace('<img src', '<img class="img img-responsive" src', $this->input->post('txtKondisiAwal'));
			} else {
				$kondisi_awal = $this->input->post('txtKondisiAwal');
			}
			if (strpos($this->input->post('txtUsulan'), '<img src') !== false) {
    			$usulan_kaizen = str_replace('<img src', '<img class="img img-responsive" src', $this->input->post('txtUsulan'));
			} else {
				$usulan_kaizen = $this->input->post('txtUsulan');
			}
			if (strpos($this->input->post('txtPertimbangan'), '<img src') !== false) {
    			$pertimbangan = str_replace('<img src', '<img class="img img-responsive" src', $this->input->post('txtPertimbangan'));
			} else {
				$pertimbangan = $this->input->post('txtPertimbangan');
			}
			$komponen = $this->input->post('slcKomponen');
			$komponen = implode(',', $komponen);
			$data = array(
				'judul' => $this->input->post('txtJudul'),
				'pencetus' => $this->input->post('txtPencetus'),
				'noinduk' => $this->input->post('txtNoInduk'),
				'kondisi_awal' => $kondisi_awal,
				'usulan_kaizen' => $usulan_kaizen,
				'pertimbangan' => $pertimbangan,
				'rencana_realisasi' => date("Y-m-d", strtotime($this->input->post('txtRencanaRealisasi'))),
				'created_date' => date('Y-m-d'),
				'status' => 0,
				'user_id' => $this->session->userdata('userid'),
				'komponen' => $komponen
			);

			$this->M_submit->setKaizen($data);
			$kaizen_id = $this->db->insert_id();

			//log thread
			$getTemplateLog = $this->M_log->getTemplateLog(0);
				$title = $getTemplateLog[0]['title'];
				$body = $getTemplateLog[0]['body'];
			$detail =  "($title) - ";
			$detail .= sprintf($body, $this->input->post('txtPencetus') , $this->input->post('txtJudul'));

			$datalog =array(
				'kaizen_id' => $kaizen_id,
				'status' => 0,
				'detail' => $detail,
				'waktu' => date('Y-m-d h:i:s'),
				 );
			$this->M_log->save_log($datalog);
			//insert to t_log
				$aksi = 'KAIZEN GENERATOR';
				$detail = 'Membuat Kaizen id='.$kaizen_id;
				$this->log_activity->activity_log($aksi, $detail);
			//
			//helper_log($kaizen_id,0,$detail,date('Y-m-d h:i:s'));
			redirect('SystemIntegration/KaizenGenerator/View/'.$kaizen_id);
		}
	}

	public function view($id) {
		$this->checkSession();
		$this->load->model('SystemIntegration/M_approvalkaizen');
		$user_id = $this->session->userid;
		$noinduk = $this->session->userdata['user'];
		$data['Menu'] = 'View Kaizen';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['user'] = $this->session->userdata('logged_in');
		$data['kaizen'] = $this->M_submit->getKaizen($id, FALSE);
		$data['thread'] = $this->M_log->ShowLog($id);

		//get form input approval
		$form_approval = array();
		if ($data['kaizen'] && in_array($data['kaizen'][0]['status'], $needthisform = array(0, 1))) {
			$getKodeJabatan = $this->M_submit->getKodeJabatan($noinduk);
			if (($getKodeJabatan >= 13) && ($getKodeJabatan != 19) && ($getKodeJabatan != 16)) {
				$atasan1 = $this->M_submit->getAtasan($noinduk, 1);
				$atasan2 = $this->M_submit->getAtasan($noinduk, 2);

				$form_approval[0]['title'] = 'Atasan 1';
				$form_approval[0]['level'] = '1';
				$form_approval[0]['namefrm'] = 'SlcAtasanLangsung';
				$form_approval[0]['option'] = $atasan1;

				$form_approval[1]['title'] = 'Atasan 2';
				$form_approval[1]['level'] = '2';
				$form_approval[1]['namefrm'] = 'SlcAtasanAtasanLangsung';
				$form_approval[1]['option'] = $atasan2;
			} else {
				$atasan2 = $this->M_submit->getAtasan($noinduk, 2);
				$form_approval[0]['title'] = 'Atasan';
				$form_approval[0]['level'] = '2';
				$form_approval[0]['namefrm'] = 'SlcAtasanAtasanLangsung';
				$form_approval[0]['option'] = $atasan2;
			}
		} else if($data['kaizen'][0]['status'] == 6) {
			$atasan1 = $this->M_submit->getAtasan($noinduk, 1);
			$form_approval[0]['title'] = 'Atasan';
			$form_approval[0]['level'] = '6';
			$form_approval[0]['namefrm'] = 'SlcAtasanLangsung';
			$form_approval[0]['option'] = $atasan1;
		}

		$data['form_approval'] = $form_approval;
		$data['kaizen'][0]['employee_code'] = '';
		$data['section_user'] = $this->M_approvalkaizen->getSectAll($data['kaizen'][0]['noinduk']);
		if ($data['kaizen'][0]['komponen']) {
			$arrayKomponen = explode(',', $data['kaizen'][0]['komponen']);
			foreach ($arrayKomponen as $key => $value) {
				$dataItem = $this->M_submit->getMasterItem(FALSE,$value);
				$kodeItem = $dataItem[0]['SEGMENT1'];
				$namaItem = $dataItem[0]['ITEM_NAME'];
				$komponen[] = $aa = array('id' => $value, 'code' => $kodeItem, 'name' => $namaItem);
			}
			$data['kaizen'][0]['komponen'] = $komponen;
		}

		$reason_app = array();
		$reason_rev = array();
		$reason_rej = array();
		$data['kaizen'][0]['status_app'] = '';

		// $a = 0; for ($i=1; $i < 3; $i++) {
		// 	$getApprovalLvl = $this->M_submit->getApprover($data['kaizen'][0]['kaizen_id'], $i);
		// 	$data['kaizen'][0]['status_app']['level'.$i] = $getApprovalLvl ? $getApprovalLvl[0]['status'] : 0;
		// 	$data['kaizen'][0]['status_app']['staff'.$i] = $getApprovalLvl ? $getApprovalLvl[0]['employee_name'] : '';
		// 	$data['kaizen'][0]['status_app']['staff_code'.$i] = $getApprovalLvl ? $getApprovalLvl[0]['employee_code'] :'' ;
		// 	$data['kaizen'][0]['status_app']['reason'.$i] = $getApprovalLvl ? $getApprovalLvl[0]['reason'] :'';
		// 		if ($getApprovalLvl) {
		// 			if ($getApprovalLvl[0]['status'] == 4 ) {
		// 				array_push($reason_rev, $data['kaizen'][0]['status_app']['reason'.$i]);
		// 			}elseif ($data['kaizen'][0]['status'] == 5) {
		// 				array_push($reason_rej, $data['kaizen'][0]['status_app']['reason'.$i]);
		// 			}elseif ($data['kaizen'][0]['status'] == 3) {
		// 				array_push($reason_app, $data['kaizen'][0]['status_app']['reason'.$i]);
		// 			}
		// 		}
		// 	$a++;
		// }

		$a = 0;
		$getAllApprover = $this->M_submit->getApprover($data['kaizen'][0]['kaizen_id'],FALSE);
		foreach ($getAllApprover as $key => $value) {
			$data['kaizen'][0]['status_app'][$value['level']]['level'] = $value['level'];
			$data['kaizen'][0]['status_app'][$value['level']]['staff'] = $value['employee_name'];
			$data['kaizen'][0]['status_app'][$value['level']]['staff_code'] = $value['employee_code'];
			$data['kaizen'][0]['status_app'][$value['level']]['reason'] = $value['reason'];
			if ($value['status'] == 4 ) {
				array_push($reason_rev, $value['reason']);
			} else if ($value['status'] == 5) {
				array_push($reason_rej, $value['reason']);
			} else if ($value['status'] == 3) {
				array_push($reason_app, $value['reason']);
			}
			$a++;
		}
		$data['kaizen'][0]['reason_app'] = implode(',<br>', $reason_app);
		$data['kaizen'][0]['reason_rev'] = implode(',<br>', $reason_rev);
		$data['kaizen'][0]['reason_rej'] = implode(',<br>', $reason_rej);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('SystemIntegration/MainMenu/Submit/V_ViewKaizen', $data);
		$this->load->view('V_Footer');
	}


	public function edit($id)
		{
			//insert to t_log
				$aksi = 'KAIZEN GENERATOR';
				$detail = 'Edit Kaizen id='.$id;
				$this->log_activity->activity_log($aksi, $detail);
			//
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'View Kaizen';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['user'] = $this->session->userdata('logged_in');
			$data['kaizen'] = $this->M_submit->getKaizen($id, FALSE);
			$data['thread'] = $this->M_log->ShowLog($id);

			if ($data['kaizen'][0]['komponen']) {
				$arrayKomponen = explode(',', $data['kaizen'][0]['komponen']);
				foreach ($arrayKomponen as $key => $value) {
					$dataItem = $this->M_submit->getMasterItem(FALSE,$value);
					$kodeItem = $dataItem[0]['SEGMENT1'];
					$namaItem = $dataItem[0]['ITEM_NAME'];
					$komponen[] = $aa = array('id' => $value, 'code' => $kodeItem, 'name' => $namaItem);
				}

				$data['kaizen'][0]['komponen'] = $komponen;
			}

			$this->form_validation->set_rules('txtJudul', 'Judul Ide Kaizen', 'required');
			$this->form_validation->set_rules('txtNoInduk', 'Nomor Induk', 'required');
			$this->form_validation->set_rules('txtPencetus', 'Pencetus Ide Kaizen', 'required');
			$this->form_validation->set_rules('txtKondisiAwal', 'Kondisi Awal', 'required');
			$this->form_validation->set_rules('txtUsulan', 'Usulan Kaizen', 'required');
			$this->form_validation->set_rules('txtPertimbangan', 'Pertimbangan Ide Kaizen', 'required');
			$this->form_validation->set_rules('txtRencanaRealisasi', 'Rencana Realisasi', 'required');

			if ($this->form_validation->run() === FALSE) {
				$this->load->view('V_Header', $data);
				$this->load->view('V_Sidemenu', $data);
				$this->load->view('SystemIntegration/MainMenu/Submit/V_Edit', $data);
				$this->load->view('V_Footer');
			} else {
				if (strpos($this->input->post('txtKondisiAwal'), '<img src') !== false) {
    			$kondisi_awal = str_replace('<img src', '<img class="img img-responsive" src', $this->input->post('txtKondisiAwal'));
				} else {
					$kondisi_awal = $this->input->post('txtKondisiAwal');
				}
				if (strpos($this->input->post('txtUsulan'), '<img src') !== false) {
	    			$usulan_kaizen = str_replace('<img src', '<img class="img img-responsive" src', $this->input->post('txtUsulan'));
				} else {
					$usulan_kaizen = $this->input->post('txtUsulan');
				}
				if (strpos($this->input->post('txtPertimbangan'), '<img src') !== false) {
	    			$pertimbangan = str_replace('<img src', '<img class="img img-responsive" src', $this->input->post('txtPertimbangan'));
				} else {
					$pertimbangan = $this->input->post('txtPertimbangan');
				}
				$komponen = $this->input->post('slcKomponen');
				if (isset($komponen)) {
					$komponen = implode(',', $komponen);
				}else{
					$komponen = '';
				}
				$status_new = $data['kaizen'][0]['status'] == 4 ? '1' : ($data['kaizen'][0]['status'] == 1 ? '1' : '0');
				$data = array(
					'judul' => $this->input->post('txtJudul'),
					'pencetus' => $this->input->post('txtPencetus'),
					'noinduk' => $this->input->post('txtNoInduk'),
					'kondisi_awal' => $this->input->post('txtKondisiAwal'),
					'usulan_kaizen' => $this->input->post('txtUsulan'),
					'pertimbangan' => $this->input->post('txtPertimbangan'),
					'rencana_realisasi' => date("Y-m-d", strtotime($this->input->post('txtRencanaRealisasi'))),
					'updated_date' => date('Y-m-d h:i:s'),
					'status_date' => date('Y-m-d h:i:s'),
					'status' => $status_new,
					'komponen' => $komponen,
				);

				$this->M_submit->saveUpdate($id,$data);
				//log thread
				$getTemplateLog = $this->M_log->getTemplateLog(1);
					$title = $getTemplateLog[0]['title'];
					$body = $getTemplateLog[0]['body'];
				$detail =  "($title) - ";
				$detail .= sprintf($body, $this->input->post('txtPencetus') , $this->input->post('txtJudul'));

				$datalog =array(
					'kaizen_id' => $id,
					'status' => $status_new,
					'detail' => $detail,
					'waktu' => date('Y-m-d h:i:s'),
					 );
				$this->M_log->save_log($datalog);
				redirect(base_url("SystemIntegration/KaizenGenerator/View/$id"));
			}


		}

	public function delete($id)
		{
			//insert to t_log
			$aksi = 'KAIZEN GENERATOR';
			$detail = 'Delete Kaizen id='.$id;
			$this->log_activity->activity_log($aksi, $detail);
			//
			$this->M_submit->UpdateStatus($id,8);
			redirect(base_url('SystemIntegration/KaizenGenerator/MyKaizen/index'));
		}

	public function getItem()
	{
		$term = $this->input->get('p');
		$term = strtoupper($term);
		$getItem = $this->M_submit->getMasterItem($term,FALSE);
		echo json_encode($getItem);
	}

	public function pdf($id)
	{
		//insert to t_log
		$aksi = 'KAIZEN GENERATOR';
		$detail = 'Export PDF Kaizen id='.$id;
		$this->log_activity->activity_log($aksi, $detail);
		//
		$this->checkSession();
		$this->load->library('pdf');
		$this->load->model('SystemIntegration/M_approvalkaizen');

		$data['kaizen'] = $this->M_submit->getKaizen($id, FALSE);
		if ($data['kaizen'][0]['komponen']) {
				$arrayKomponen = explode(',', $data['kaizen'][0]['komponen']);
				foreach ($arrayKomponen as $key => $value) {
					$dataItem = $this->M_submit->getMasterItem(FALSE,$value);
					$kodeItem = $dataItem[0]['SEGMENT1'];
					$namaItem = $dataItem[0]['ITEM_NAME'];
					$komponen[] = $aa = array('id' => $value, 'code' => $kodeItem, 'name' => $namaItem);
				}

				$data['kaizen'][0]['komponen'] = $komponen;
			}


		$data['kaizen_id'] =$this->M_submit->getKaizen($id, FALSE);
		$data['section_user'] = $this->M_approvalkaizen->getSectAll($data['kaizen'][0]['noinduk']);
		$data['set_approve'] = $this->M_log->ShowLogByTitle($id,'(Set Approver)');
		$getAllApprover = $this->M_approvalkaizen->getApprover($data['kaizen'][0]['kaizen_id'],FALSE);
		// $jmlMaxApp =  count($getAllApprover);
				$data['persetujuan'][0]['level'] = '0';
				$data['persetujuan'][0]['staff'] = $data['kaizen'][0]['pencetus'];
				$data['persetujuan'][0]['staff_code'] = $data['kaizen'][0]['noinduk'];
				$data['persetujuan'][0]['reason'] = '0';
				$data['persetujuan'][0]['tanggal'] = $data['set_approve'][0]['waktu'];
		$i = 1; foreach ($getAllApprover as $key => $value) {
			if ($value['level'] != '6') {
				$data['persetujuan'][$i]['level'] = $value['level'];
				$data['persetujuan'][$i]['staff'] = $value['employee_name'];
				$data['persetujuan'][$i]['staff_code'] = $value['employee_code'];
				$data['persetujuan'][$i]['reason'] = $value['reason'];
				$getTanggal = $this->M_log->ShowLogByTitle($id,'(Approval Approved) - '.$value['employee_name']);
				$data['persetujuan'][$i]['tanggal'] = $getTanggal[0]['waktu'];
				$i++;
			}
		}

		if (strpos($data['kaizen'][0]['kondisi_awal'], '<img') !== FALSE) {
			$data['kaizen'][0]['kondisi_awal'] = str_replace('<img', '<br><img class="img img-responsive"', $data['kaizen'][0]['kondisi_awal']);
		} else {
			$data['kaizen'][0]['kondisi_awal'] = $data['kaizen'][0]['kondisi_awal'];
		}
		if (strpos($data['kaizen'][0]['usulan_kaizen'], '<img') !== FALSE) {
			$data['kaizen'][0]['usulan_kaizen'] = str_replace('<img', '<br><img class="img img-responsive"', $data['kaizen'][0]['usulan_kaizen']);
		} else {
			$data['kaizen'][0]['usulan_kaizen'] = $data['kaizen'][0]['usulan_kaizen'];
		}
		if (strpos($data['kaizen'][0]['kondisi_akhir'], '<img') !== FALSE) {
			$data['kaizen'][0]['kondisi_akhir'] = str_replace('<img', '<br><img class="img img-responsive"', $data['kaizen'][0]['kondisi_akhir']);
		} else {
			$data['kaizen'][0]['kondisi_akhir'] = $data['kaizen'][0]['kondisi_akhir'];
		}
		if (strpos($data['kaizen'][0]['pertimbangan'], '<img') !== FALSE) {
			$data['kaizen'][0]['pertimbangan'] = str_replace('<img', '<br><img class="img img-responsive"', $data['kaizen'][0]['pertimbangan']);
		} else {
			$data['kaizen'][0]['pertimbangan'] = $data['kaizen'][0]['pertimbangan'];
		}
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 8, '', 5, 5, 10, 15, 0, 0, 'P');
		$pencetus = preg_replace('/(\s)+/', ' ', $data['kaizen'][0]['pencetus']);
		$pencetus = strtolower($pencetus);
		$pencetus = ucwords($pencetus);
		$pencetus = str_replace(' ', '_', $pencetus);
		$filename = 'Kaizen-'.$pencetus.'-'.$data['kaizen'][0]['judul'].'.pdf';
		$today = date('d-M-Y H:i:s');
		$kaizen_id = $data['kaizen_id'][0]['kaizen_id'];

		$data['title'] = 'Update Kaizen';
		$data['breadcrumb'] = 'Kaizen';
		$data['subtitle'] = '';
		$data['user'] = $this->session->userdata('logged_in');

		$stylesheet = file_get_contents(base_url('assets/css/customSI.css'));
		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.min.css'));
		$html = $this->load->view('SystemIntegration/MainMenu/V_ExportPdf', $data, true);
		$pdf->setHTMLFooter('
				<table width="100%">
					<tr>
						<td style="font-size: 12px ; padding: 2px">Halaman ini di cetak melalui QuickERP - Kaizen Generator, Pada tanggal: '.$today.' ID Kaizen : '.$kaizen_id .'</td>
					</tr>
				</table>
			');
		$pdf->SetTitle($filename);
		$pdf->WriteHTML($stylesheet, 1);
		$pdf->WriteHTML($stylesheet1, 1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function realisasi($id)
	{
		//insert to t_log
		$aksi = 'KAIZEN GENERATOR';
		$detail = 'Realisasi Kaizen id='.$id;
		$this->log_activity->activity_log($aksi, $detail);
		//
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Realisasi Kaizen';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['user'] = $this->session->userdata('logged_in');
		$data['kaizen'] = $this->M_submit->getKaizen($id, FALSE);
		$data['thread'] = $this->M_log->ShowLog($id);

			if ($data['kaizen'][0]['komponen']) {
				$arrayKomponen = explode(',', $data['kaizen'][0]['komponen']);
				foreach ($arrayKomponen as $key => $value) {
					$dataItem = $this->M_submit->getMasterItem(FALSE,$value);
					$kodeItem = $dataItem[0]['SEGMENT1'];
					$namaItem = $dataItem[0]['ITEM_NAME'];
					$komponen[] = $aa = array('id' => $value, 'code' => $kodeItem, 'name' => $namaItem);
				}

				$data['kaizen'][0]['komponen'] = $komponen;
			}

		$this->form_validation->set_rules('txtKondisiAkhir', 'Kondisi Setelah Kaizen', 'required');
		$this->form_validation->set_rules('txtTanggalRealisasi', 'Rencana Realisasi', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('SystemIntegration/MainMenu/Submit/V_Realisasi', $data);
			$this->load->view('V_Footer');
		}else{
			$kondisi_akhir = $this->input->post('txtKondisiAkhir');
			$tgl_realisasi = $this->input->post('txtTanggalRealisasi');
			$realisasi_kaizen = $this->input->post('chkSosialisasiRealisasi');
			$standarisasi_kaizen = $this->input->post('chkStandarisasiRealisasi');
			$standarisasi_kaizen_thread = $this->input->post('txtStandarisasi');
			$sosialisasi_kaizen = $this->input->post('chkSosialisasiRealisasi');
			$sosialisasi_pelaksanaan  = $this->input->post('txtTanggalPelaksanaan');
			$sosialisasi_method  = $this->input->post('txtMetodeSosialisasi');


			if ($realisasi_kaizen && $sosialisasi_kaizen) {
				$data = array(
						'kondisi_akhir' => $this->input->post('txtKondisiAkhir'),
						'tgl_realisasi' => date("Y-m-d h:i:s", strtotime($this->input->post('txtTanggalRealisasi'))),
						'updated_date' => date('Y-m-d h:i:s'),
						'status_date' => date('Y-m-d h:i:s'),
						'status' => 6,
						'standarisasi_kaizen' => $standarisasi_kaizen_thread,
						'sosialisasi_pelaksanaan' => date("Y-m-d", strtotime($sosialisasi_pelaksanaan)),
						'sosialisasi_kaizen' => $sosialisasi_method
					);

					$this->M_submit->saveUpdate($id,$data);

					//log thread
					$getTemplateLog = $this->M_log->getTemplateLog(6);
						$title = $getTemplateLog[0]['title'];
						$body = $getTemplateLog[0]['body'];
					$detail =  "($title) - ";
					$detail .= sprintf($body, $this->input->post('txtPencetus'));

					$datalog =array(
						'kaizen_id' => $id,
						'status' => 6,
						'detail' => $detail,
						'waktu' => date('Y-m-d h:i:s'),
						 );
					$this->M_log->save_log($datalog);

			}else{
					$data = array(
							'kondisi_akhir' => $this->input->post('txtKondisiAkhir'),
							'tgl_realisasi' => date("Y-m-d h:i:s", strtotime($this->input->post('txtTanggalRealisasi'))),
							'updated_date' =>date('Y-m-d h:i:s'),
						);
					$this->M_submit->saveUpdate($id,$data);
			}

			redirect(base_url("SystemIntegration/KaizenGenerator/View/$id"));
		}

	}
}
