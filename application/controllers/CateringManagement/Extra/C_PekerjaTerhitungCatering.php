<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_PekerjaTerhitungCatering extends CI_Controller
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
		$this->load->model('CateringManagement/Extra/M_pekerjaterhitungcatering');
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

		$data['Title']			=	'Pekerja Terhitung Catering';
		$data['Menu'] 			= 	'Extra';
		$data['SubMenuOne'] 	= 	'Pekerja Terhitung Catering';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['tempat_makan'] = $this->M_pekerjaterhitungcatering->getTempatMakanAll();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/PekerjaTerhitungCatering/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getList(){
		$tanggal = $this->input->get('tanggal');
		$shift = $this->input->get('shift');
		$tempat_makan = $this->input->get('tempat_makan');
		$lokasi = $this->input->get('lokasi');
		$jenis = $this->input->get('jenis');

		if (trim(strtolower($jenis)) == trim(strtolower('Refresh Makan Terakhir'))) {
			$data = $this->M_pekerjaterhitungcatering->getPesananDetailByTanggalShiftLokasiTempatMakan($tanggal,$shift,$lokasi,$tempat_makan);	
		}else{
			if ($lokasi == '1') {
				$lokasi = "'1','3'";
			}else{
				$lokasi = "'2'";
			}
			if ($shift == 1) {
				$data = $this->M_pekerjaterhitungcatering->getListShiftSatu($tanggal,$tempat_makan,$lokasi);
			}elseif($shift == 2){
				$data = $this->M_pekerjaterhitungcatering->getListShiftDua($tanggal,$tempat_makan,$lokasi);
			}else{
			    $data = array();
			}
		}
				
		echo json_encode($data);
	}

}

?>