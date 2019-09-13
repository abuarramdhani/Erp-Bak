<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

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

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PerizinanDinas/AtasanApproval/M_index');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;

		// echo "<pre>";
		// print_r($user_id);exit();

		$data['Title'] = 'Data Pesanan';
		$data['Menu'] = 'Catering Management ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['izin'] = $this->M_index->GetIzin($no_induk);
		$arrrr = array();
		foreach($data['izin'] as $key) {
			$nama = explode(', ', $key['noind']);
				$newArr = array();
			foreach ($nama as $row) {
				$pekerja = $this->M_index->pekerja($row);
				$newArr[] = $row.' - '.$pekerja;
			}
			$namapekerja = implode(", ",$newArr);
			$key['namapekerja'] = $namapekerja;
			$arrrr[] = $key;
			// echo "<pre>"; print_r($namapekerja);
		 }
		$data['izin'] = $arrrr;

		$data['IzinApprove'] = $this->M_index->IzinApprove($no_induk);

			// echo "<pre>"; print_r($data['IzinApprove']);exit();
		$approve = array();
		foreach($data['IzinApprove'] as $key) {
			$nama = explode(', ', $key['noind']);
				$newArr = array();
			foreach ($nama as $row) {
				$pekerja = $this->M_index->pekerja($row);
				$newArr[] = $row.' - '.$pekerja;
			}
			$namapekerja = implode(", ",$newArr);
			$key['namapekerja'] = $namapekerja;
			$approve[] = $key;
			// echo "<pre>"; print_r($namapekerja);
		 }
		$data['IzinApprove'] = $approve;

		$data['IzinUnApprove'] = $this->M_index->IzinUnApprove($no_induk);
		$UnApprove = array();
		foreach($data['IzinUnApprove'] as $key) {
			$nama = explode(', ', $key['noind']);
				$newArr = array();
			foreach ($nama as $row) {
				$pekerja = $this->M_index->pekerja($row);
				$newArr[] = $row.' - '.$pekerja;
			}
			$namapekerja = implode(", ",$newArr);
			$key['namapekerja'] = $namapekerja;
			$UnApprove[] = $key;
			// echo "<pre>"; print_r($namapekerja);
		 }
		$data['IzinUnApprove'] = $UnApprove;

		$data['IzinReject'] = $this->M_index->IzinReject($no_induk);
		$Reject = array();
		foreach($data['IzinReject'] as $key) {
			$nama = explode(', ', $key['noind']);
				$newArr = array();
			foreach ($nama as $row) {
				$pekerja = $this->M_index->pekerja($row);
				$newArr[] = $row.' - '.$pekerja;
			}
			$namapekerja = implode(", ",$newArr);
			$key['namapekerja'] = $namapekerja;
			$Reject[] = $key;
			// echo "<pre>"; print_r($namapekerja);
		 }
		$data['IzinReject'] = $Reject;
		
		$today = date('Y-m-d');
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PerizinanDinas/AtasanApproval/V_Index',$data);
		$this->load->view('V_Footer',$data);

	}

	public function update()
	{	
		

		$value = $this->input->post('submit');
		$str = "$value";
		$id = (explode("|",$str));
		$status = $id[0];
		$idizin = $id[1];
		// echo "<pre>";
		// print_r($status);exit();
		$update= $this->M_index->update($status, $idizin);

		if ($status == 1) {
			$data['cekizin'] = $this->M_index->cekIzin($idizin);
		$nama = explode(', ', $data['cekizin'][0]['noind']);

			for ($i=0; $i < count($nama); $i++) { 
				$data = array(
					'izin_id'	=> $idizin,
					'noinduk' 	=> $nama[$i],
				);
				$insert = $this->M_index->taktual_izin($data);
			}
			redirect('PerizinanDinas/AtasanApproval');

		}elseif ($status == 2) {
			$delete = $this->M_index->deletemakan($idizin);
			redirect('PerizinanDinas/AtasanApproval');
		}else{
		redirect('PerizinanDinas/AtasanApproval');
		}
	}

}
?>
