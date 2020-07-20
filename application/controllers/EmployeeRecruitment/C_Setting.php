<?php defined('BASEPATH')OR exit('No direct script access allowed');
class C_Setting extends CI_Controller
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
			$this->load->library('General');
			$this->load->model('SystemAdministration/MainMenu/M_user');

			  //$this->load->library('Database');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('EmployeeRecruitment/m_testcorrection');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
					  //redirect('');
				$this->session->set_userdata('Responsbility', 'some_value');
			}
		}

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

	function index()
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$user_name = $this->session->user;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			// $data['jenis_soal'] = $this->m_testcorrection->getJenisSoal();
			$getJenis = $this->m_testcorrection->getJenisSoal();
			$jenis =  array();
			$i = 0; foreach ($getJenis as $jns) {
				// echo $jenis['jenis_soal'];
				$getJumlahSoal = $this->m_testcorrection->getJumlahSoal($jns['jenis_soal']);
				$jenis[$i]['jenis_soal'] = $jns['jenis_soal'];
				$jenis[$i]['jumlah'] = $getJumlahSoal;
				$i++;
			}
			$data['jenis_soal'] = $jenis;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('EmployeeRecruitment/Setting/V_Index',$data);
			$this->load->view('V_Footer',$data);
		}

	function edit($id,$msg=null)
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$user_name = $this->session->user;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			// $data['jenis_soal'] = $this->m_testcorrection->getJenisSoal();
			// $data['jenis_soal'] = $jenis;
			$data['rule'] = $this->m_testcorrection->getRule($id);
			$data['id'] = $id;
			// if ($msg) {
				$data['msg'] = $msg;
			// }
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('EmployeeRecruitment/Setting/V_Edit',$data);
			$this->load->view('V_Footer',$data);
		}

	function saveedit()
		{
			$jenis_soal = $this->input->post('txtJenis');
			$nomer = $this->input->post('nomer');
			$id = $this->input->post('idNo');
			$type = $this->input->post('slcType');
			$sub = $this->input->post('subTest');
			$key = $this->input->post('txtKey');
			$scrBtl = $this->input->post('scrBtl');
			$scrSlh = $this->input->post('scrSlh');
			$idKeep = array();

			$a = 0 ; foreach ($id as $val) {
				if ($val != null) {
					$id_rule = $id[$a];
					$data =array('nomor' => $nomer[$a],
								'type' => $type[$a],
								'sub_test' => $sub[$a],
								'jenis_soal' => $jenis_soal,
								'kunci' => $key[$a],
								'score_betul' => $scrBtl[$a],
								'score_salah' => $scrSlh[$a] );
					$this->m_testcorrection->updateRule($id_rule,$data);
					array_push($idKeep, $id_rule);
				}else{
					$nomer[$a] = $a+1;
					$data2 = array(
								'nomor' => $nomer[$a],
								'type' => $type[$a],
								'sub_test' => $sub[$a],
								'jenis_soal' => $jenis_soal,
								'kunci' => $key[$a],
								'score_betul' => $scrBtl[$a],
								'score_salah' => $scrSlh[$a] );
					$saveandget = $this->m_testcorrection->insertRule($data2);
					array_push($idKeep, $saveandget);

				}
					$a++;
			}
			$idNoDel = implode("','", $idKeep);
			$this->m_testcorrection->deleteRule($idNoDel,$jenis_soal);
			$msg= "Update Success!";
			$this->edit($jenis_soal,$msg);
		}

	function addnew($tmp=null)
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$user_name = $this->session->user;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['tmp'] = $tmp;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('EmployeeRecruitment/Setting/V_New',$data);
			$this->load->view('V_Footer',$data);
		}

	function saveadd()
		{
			$jenis_soal = $this->input->post('txtJenis');
			$jumlah_soal = $this->input->post('jmlSoal');
			$datatmp = array();
			$datatmp['jenis_soal'] = $jenis_soal;
			$datatmp['jumlah_soal'] = $jumlah_soal;

			if ($this->input->post('insRule') !== null) {
				$jenis_soal = $this->input->post('txtJenis');
				$nomer = $this->input->post('nomer');
				$type = $this->input->post('slcType');
				$sub = $this->input->post('subTest');
				$key = $this->input->post('txtKey');
				$scrBtl = $this->input->post('scrBtl');
				$scrSlh = $this->input->post('scrSlh');

				$a = 0; foreach ($nomer as $val) {
					$nomer[$a] = $a+1;
					$data = array(
							'nomor' => $nomer[$a],
							'type' => $type[$a],
							'jenis_soal' => $jenis_soal,
							'sub_test' => $sub[$a],
							'kunci' => $key[$a],
							'score_betul' => $scrBtl[$a],
							'score_salah' => $scrSlh[$a]
					);
					$this->m_testcorrection->insertRule($data);
					$a++; }

					$msg= "Insert Success!";
					$this->edit($jenis_soal,$msg);
			}else{
				$this->addnew($datatmp);
			}
		}

	function delete()
		{
			$jenis_soal = $this->input->post('jenis_soal');
			$this->m_testcorrection->delete($jenis_soal);
			$this->index();

		}
}