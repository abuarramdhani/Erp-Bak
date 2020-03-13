<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller 
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
		$this->load->model('MasterCostCenter/M_cc');

		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index()
	{
		$user_id = $this->session->userid;
		
		$data  = $this->general->loadHeaderandSidemenu('Master Cost Center', 'Master Cost Center', '', '', '');
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterCostCenter/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ListCC()
	{
		$user_id = $this->session->userid;
		
		$data  = $this->general->loadHeaderandSidemenu('Master Cost Center', 'List Cost Center', 'List Cost Center', '', '');

		$data['seksi'] = $this->M_cc->getSeksi();
		$List = $this->M_cc->getListCC();
		$ks = implode("', '", array_column($List, 'seksi'));
		$data['seksi2'] = $this->M_cc->getSeksi($ks);
		$data['cc'] = $this->M_cc->getCC();
		$data['branch'] = $this->M_cc->getBranch();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterCostCenter/ListCC/V_List_CC',$data);
		$this->load->view('V_Footer',$data);
	}

	public function saveCC()
	{
		$seksi = $this->input->post('seksi');
		$getCC = $this->M_cc->getListCC();
		$listSeksi = array_column($getCC, 'seksi');
		if (in_array($seksi, $listSeksi)) {
			$data['hasil'] = '1';// artinya seksi sudah ada dan tidak boleh di insertkan
			$data['pesan'] = 'Gagal Seksi Sudah ada !!';
			echo json_encode($data);
			exit();
		}

		$cost = $this->input->post('cost');
		$cc = explode(' | ', $cost);
		$branch = $this->input->post('branch');

		$arr = array(
			'seksi' => $seksi,
			'cost_center' => $cc[0],
			'nama_cost_center' => $cc[1],
			'branch' => $branch,
			);
		$ins = $this->M_cc->insCC($arr);
		$data['hasil'] = '0';
		echo json_encode($data);
	}

	public function delCC()
	{
		$id = $this->input->get('id');
		$delCC = $this->M_cc->deleteCC($id);
	}

	public function updateCC()
	{
		$seksi = $this->input->post('seksi');
		$id = $this->input->post('id');
		$getCC = $this->M_cc->getListCC();
		$cost = $this->input->post('cost');
		$cc = explode(' | ', $cost);
		$branch = $this->input->post('branch');
		$akun = $this->input->post('akun');

		//update ke dl t_cost_center
		$cek = $this->M_cc->cekTcc($id);
		if (empty($cek)) {
		$arr = array(
			'seksi'	=> $id,
			'cost_center' => $cc[0],
			'nama_cost_center' => $cc[1],
			'branch' => $branch,
			'jenis_akun' => $akun,
			);
		$this->M_cc->insCC($arr);
		}else{
			$up = $this->M_cc->upCCdl($id, $cc[0], $cc[1], $branch, $akun);
		}

		$up = $this->M_cc->upCC($id, $cc[0], $cc[1], $branch, $akun);
		$data['hasil'] = '0';
		echo json_encode($data);
	}

	public function getTableData()
	{
		$data['list'] = $this->M_cc->getListCC();
		$br = array_column($data['list'], 'branch');
		$br = array_filter($br, function($var){
          return ($var != '');
		});
		if (!empty($br)) {
			$br = implode("', '", $br);
			$getBr = $this->M_cc->getBranch($br);
			if (!empty($getBr)) {
				$newBr = array_column($getBr, 'DESCRIPTION', 'FLEX_VALUE');
				for ($i=0; $i < count($data['list']); $i++) {
					if (!empty($data['list'][$i]['branch'])) {
						$data['list'][$i]['nama_branch'] = $newBr[$data['list'][$i]['branch']];
					}else{
						$data['list'][$i]['nama_branch'] = '';
					}
				}
			}
		}else{
			for ($i=0; $i < count($data['list']); $i++) { 
				$data['list'][$i]['nama_branch'] = '';
			}
		}
		$html = $this->load->view('MasterCostCenter/ListCC/V_Table_CC',$data);

		return json_encode($html);
	}

	public function EditCC()
	{
		$id = $this->input->get('id');

		$getCC = $this->M_cc->getListCC($id);
	}

	public function cekSeksi()
	{
		$data['cek'] = $this->M_cc->cekSeksi();
		$html = $this->load->view('MasterCostCenter/ListCC/V_Table_Seksi',$data);
		echo json_encode($html);
	}
}
