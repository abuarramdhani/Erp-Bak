<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
date_default_timezone_set('Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_SimForklift extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Other/SimForklift/M_simforklift');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'SIM Forklift';
		$data['Menu'] 			= 	'Lain-lain';
		$data['SubMenuOne'] 	= 	'SIM Forklift';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_simforklift->getSimForkliftAll();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Other/SimForklift/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function tambah(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'SIM Forklift';
		$data['Menu'] 			= 	'Lain-lain';
		$data['SubMenuOne'] 	= 	'SIM Forklift';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Other/SimForklift/V_Tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function cariPekerja($noind = FALSE){
		if ($noind == FALSE) {
			$key = $this->input->get('term');
			$data = $this->M_simforklift->getPekerjaByKey($key);
		}else{
			$data = $this->M_simforklift->getPekerjaByNoind($noind);
		}
		echo json_encode($data);
	}

	public function simpan(){
		$noind	= $this->input->post('noind');
		$nama	= $this->input->post('nama');
		$seksi	= $this->input->post('seksi');
		$jenis	= $this->input->post('jenis');
		$awal	= $this->input->post('awal'); 
		$akhir	= $this->input->post('akhir');

		$awal = "1 ".$awal;
		$akhir = "1 ".$akhir;

		$data = array(
			'noind' => $noind,
			'nama' => $nama,
			'seksi' => $seksi,
			'jenis' => $jenis,
			'mulai_berlaku' => $awal,
			'selesai_berlaku' => $akhir,
			'file_pdf' => '',
			'file_image' => '',
			'file_corel' => '',
			'created_by' => $this->session->user,
		);
		$this->M_simforklift->insertSimForklift($data);
		echo "sukses";
	}

	public function cetakpdf(){
		$id = $this->input->get('data');
		$pekerja = array();
		foreach ($id as $key) {
			$pekerja[] = $this->M_simforklift->getSimForkliftById($key);
		}
		
		$data['pekerja'] = $pekerja;
		$pdf = $this->pdf->load();
	    $pdf = new mPDF('utf-8', 'F4-L', 12, '', 5, 5, 5, 5, 5, 5);
	    $filename = 'SIM_FORKLIFT'.'.pdf';
	    $html = $this->load->view('MasterPekerja/Other/SimForklift/V_Pdf', $data, true);
	    $pdf->WriteHTML($html);
	    $pdf->Output($filename, 'I');
	}

	public function cetakimg(){
		echo "<pre>";
		print_r($_GET);
	}

	public function cetakcrl(){
		echo "<pre>";
		print_r($_GET);
	}

}

?>