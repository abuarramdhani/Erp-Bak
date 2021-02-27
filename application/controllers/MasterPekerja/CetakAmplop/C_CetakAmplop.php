<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');


class C_CetakAmplop extends CI_Controller
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
		$this->load->model('MasterPekerja/CetakAmplop/M_cetakamplop');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Cetak Amplop';
		$data['Menu'] = 'Lain-lain';
		$data['SubMenuOne'] = 'Cetak Amplop';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['DataPekerja'] = $this->M_cetakamplop->getDataWorker();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/CetakAmplop/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function cetakAmplop(){
		$noind = $this->input->post('noind');
		 $nick = $this->input->post('name');
		
		$count = count($noind);
		$data['worker'] = array();
		for($i=0;$i<$count;$i++){
			$Card = $this->M_cetakamplop->getWorker($noind[$i]);
			
			array_push($data['worker'], $Card);
			//insert to t_log
			$aksi = 'MASTER PEKERJA';
			$detail = 'Cetak Amplop Noind='.$noind[$i];
			$this->log_activity->activity_log($aksi, $detail);
			//
		}
		// echo "<pre>";
		// print_r($data['worker']);exit();

		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', array(210,150), 8, '', 5, 5, 10, 15, 0, 0, 'P');
		$filename = 'CetakAmplop.pdf';

		$html = $this->load->view('MasterPekerja/CetakAmplop/V_cetakamplop', $data, true);
		$pdf->WriteHTML($html, 2);
		$pdf->setTitle($filename);
		$pdf->Output($filename, 'D');

	}

	public function pekerja()
	{
		$this->checkSession();

		$employee = $_GET['p'];
		$employee = strtoupper($employee);
		$data = $this->M_cetakamplop->getPekerja($employee);
		echo json_encode($data);
	}

	public function DataAmplop(){
		$this->checkSession();

		$noind = $this->input->get('nama');
	
		$data['worker'] = array();
		foreach ($noind as $key) {
			$DataID = $this->M_cetakamplop->DataPekerja($key);
			
	

			array_push($data['worker'], $DataID);
		}

		echo json_encode($data);

	}

	public function cetakAmplop2(){
		
		$data['nama'] = $this->input->post('nama_pkj');
		$data['alamat'] = $this->input->post('alamat_pkj');
		$data['pengirim'] = $this->input->post('pengirim');
		$panjang = $this->input->post('panjang');
		$lebar = $this->input->post('lebar');
		$mkanan = $this->input->post('mkanan');
		$mkiri = $this->input->post('mkiri');
		$matas = $this->input->post('matas');
		$mbawah = $this->input->post('mbawah');
		$orientasi = $this->input->post('orientasi');
		$format = $this->input->post('format');
		$uf = 13;
		$data['wid'] = 400;
		$data['br'] = ['<br>'];
		if ($format == 'C6') {
			$uf = 10;
		}elseif ($format == 'C5') {
			$uf = 10;
			$data['wid'] = 300;
			$data['br'] = [];
		}
		$data['border'] = true;
		if ($format == 'C7/C6' || $format == 'C7') {
			$uf = 10;
			$matas = 10;
		}

		//alamat
		if ($format == 'C5'){
			if (strlen($data['alamat']) > 90) {
				$data['wid2'] = 75;
			}else{
				$data['wid2'] = 60;
			}
		}
		if ($format == 'C4'){
			if (strlen($data['alamat']) > 70) {
				$data['wid2'] = 75;
			}else{
				$data['wid2'] = 60;
			}
		}
		$data['format'] = $format;

		$this->load->library('pdf');
		$data['atas'] = $matas;

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', array($lebar,$panjang), $uf, '', $mkiri, $mkanan, $matas, $mbawah, 0, 0, $orientasi);
		$filename = 'CetakAmplop.pdf';

		$html = $this->load->view('MasterPekerja/CetakAmplop/V_cetakamplop2rev', $data, true);
		$css = '@media print {  
				  @page {
				    size: 118mm 229mm potrait;
				    font-size: 12; 
				  }
				}';
		// $pdf->WriteHTML($css,1);
		$pdf->WriteHTML($html, 2);
		$pdf->setTitle($filename);
		$pdf->Output($filename, 'I');

	}

	public function Amplop2()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Cetak Amplop';
		$data['Menu'] = 'Lain-lain';
		$data['SubMenuOne'] = 'Cetak Amplop';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['DataPekerja'] = $this->M_cetakamplop->getDataWorker();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/CetakAmplop/V_Index2', $data);
		$this->load->view('V_Footer',$data);
	}

	public function tableAmplop2()
	{
		$noind = $this->input->get('noind');
		$noind = implode("','", $noind);
		$pkj = $this->M_cetakamplop->getDetailPkj($noind);
		$data['pkj'] = $pkj;
		$view = $this->load->view('MasterPekerja/CetakAmplop/V_Table_Amplop2', $data, true);
		echo $view;
	}
}
