<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_KaizenAkuntansi extends CI_Controller
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
		$this->load->model('SystemIntegration/M_kaizenakuntansi');
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

	public function index(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Kaizen Akuntansi';
		$data['Header']			=	'Kaizen Akuntansi';
		$data['Menu'] 			= 	'Submit Kaizen';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		// $this->load->view('CateringManagement/Extra/IzinDinasPTM/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SubmitIde(){
		// echo "<pre>";print_r($_SESSION);exit();
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Kaizen Akuntansi';
		$data['Header']			=	'Kaizen Akuntansi';
		$data['Menu'] 			= 	'Submit Kaizen';
		$data['SubMenuOne'] 	= 	'Submit Ide';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemIntegration/MainMenu/KaizenAkuntansi/V_SubmitIde',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SimpanIde(){
		$seksi 		= $this->input->post('seksi');
		$judul 		= $this->input->post('judul');
		$dueDate 	= $this->input->post('dueDate');
		$noind 		= $this->session->user;
		$nama 		= trim($this->session->employee);

		$data = array(
			'pencetus_noind'=> $noind,
			'pencetus_nama' => $nama,
			'judul' 		=> $judul,
			'seksi' 		=> $seksi,
			'due_date_f4' 	=> $dueDate,
			'status' 		=> 'Create Ide'
		);

		$id_kaizen = $this->M_kaizenakuntansi->insertKaizen($data);

		$thread = array(
			'kaizen_id' => $id_kaizen,
			'status' 	=> 'Create Ide',
			'detail' 	=> '(Create Ide) '.$noind.' - '.$nama.' telah membuat ide kaizen dengan judul "'.$judul.'"'
		);

		$this->M_kaizenakuntansi->insertThreadKaizen($thread);

		echo $id_kaizen;
	}

	public function SubmitF4(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Kaizen Akuntansi';
		$data['Header']			=	'Kaizen Akuntansi';
		$data['Menu'] 			= 	'Submit Kaizen';
		$data['SubMenuOne'] 	= 	'Submit F4';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['ide'] = $this->M_kaizenakuntansi->getKaizenByUserStatus($user,'Create Ide');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemIntegration/MainMenu/KaizenAkuntansi/V_SubmitF4',$data);
		$this->load->view('V_Footer',$data);
	}

	public function uploadSubmitF4(){
		$user = $this->session->user;

		$namaLama	= $_FILES['file']['name'];
		$ekstensi	= pathinfo($namaLama,PATHINFO_EXTENSION);
		$namaBaru	= "SI-KaizenAkuntansi-".$user."-".str_replace(' ', '_', date('Y-m-d H:i:s')).".".$ekstensi;

		$config = array(
			'upload_path' 	=> './assets/upload_kaizen/',
	        'upload_url' 	=> base_url()  . './assets/upload_kaizen/',
	        'allowed_types' => 'jpg|gif|png',
	        'overwrite' 	=> false,
	        'file_name' 	=> $namaBaru
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

	public function getKomponen(){
		$term = $this->input->get('p');
		$term = strtoupper($term);
		$getItem = $this->M_kaizenakuntansi->getMasterItem($term,FALSE);
		echo json_encode($getItem);
	}

	public function SimpanF4(){
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		// exit();
		$judul 			= $this->input->post('judul');
		$kaizenId 		= $this->input->post('kaizen_id');
		$nama 			= $this->input->post('nama');
		$noind 			= $this->input->post('noind');
		$kondisi 		= $this->input->post('kondisi');
		$usulan 		= $this->input->post('usulan');
		$pertimbangan 	= $this->input->post('pertimbangan');
		$realisasi 		= $this->input->post('realisasi');
		$komponens 		= $this->input->post('komponen');
		$komponen = '';
		if (isset($komponens) && !empty($komponens)) {
			foreach ($komponens as $key => $value) {
				if ($komponen == '') {
					$komponen .= $value;
				}else{
					$komponen .= ";".$value;
				}
			}
		}

		$data = array(
			'komponen' 			=> $komponen,
			'kondisi_awal' 		=> $kondisi,
			'usulan_kaizen' 	=> $usulan,
			'pertimbangan' 		=> $pertimbangan,
			'tanggal_realisasi' => $realisasi,
			'status' 			=> 'Submit F4'
		);
		$this->M_kaizenakuntansi->updateKaizenByKaizenId($data,$kaizenId);

		$thread = array(
			'kaizen_id' => $kaizenId,
			'status' 	=> 'Submit F4',
			'detail' 	=> '(Submit F4) '.$noind.' - '.$nama.' telah submit F4 ide kaizen dengan judul "'.$judul.'"'
		);

		$this->M_kaizenakuntansi->insertThreadKaizen($thread);
		echo "sukses";	
	}
}

?>