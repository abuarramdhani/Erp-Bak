<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_CetakCard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('upload');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Other/M_cetakcard');

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

		$user_id = $this->session->userid;


		$data['Title'] = 'Cetak ID Card';
		$data['Menu'] = 'Lain-lain';
		$data['SubMenuOne'] = 'Cetak ID Card';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['DataPekerja'] = $this->M_cetakcard->getDataWorker();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Other/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function cetakIDCard(){
		$noind = $this->input->post('noind');
		// $nama = $this->input->post('name');
		$nick = $this->input->post('nick');
		$checked = ($_POST['noind_baru'] == 1) ? true : false;

		$count = count($nick);
		$data['worker'] = array();
		for($i=0;$i<$count;$i++){
			$Card = $this->M_cetakcard->getWorker($noind[$i],$nick[$i], $checked);
			array_push($data['worker'], $Card);
			//insert to t_log
			$aksi = 'MASTER PEKERJA';
			$detail = 'Cetak ID CARD Noind='.$noind[$i];
			$this->log_activity->activity_log($aksi, $detail);
			//
		}

		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 8, '', 5, 5, 10, 15, 0, 0, 'P');
		$filename = 'ID_Card.pdf';

		$html = $this->load->view('MasterPekerja/Other/V_cetakcard', $data, true);

		$pdf->WriteHTML($html, 2);
		$pdf->setTitle($filename);
		$pdf->Output($filename, 'D');

	}

	public function pekerja()
	{
		$this->checkSession();

		$employee = $_GET['p'];
		$employee = strtoupper($employee);
		$data = $this->M_cetakcard->getPekerja($employee);
		echo json_encode($data);
	}

	public function DataIDCard(){
		$this->checkSession();

		$noind = $this->input->get('nama');
		$data['worker'] = array();
		foreach ($noind as $key) {
			$DataID = $this->M_cetakcard->DataPekerja($key);
			array_push($data['worker'], $DataID);
		}

		echo json_encode($data);

	}

}
