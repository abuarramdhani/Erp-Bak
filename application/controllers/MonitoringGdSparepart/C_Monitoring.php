<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoring extends CI_Controller
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
		$this->load->model('MonitoringGdSparepart/M_monitoring');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring';
		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringGdSparepart/V_Monitoring', $data);
		$this->load->view('V_Footer',$data);
	}

	public function search() {

		$no_document	= $this->input->post('no_document');
		$jenis_dokumen	= $this->input->post('jenis_dokumen');
		$tglAwal		= $this->input->post('tglAwal');
		$tglAkhir		= $this->input->post('tglAkhir');
		$pic			= $this->input->post('pic');
		$item			= $this->input->post('item');

		$dataGET = $this->M_monitoring->getSearch($no_document, $jenis_dokumen,  $tglAwal, $tglAkhir, $pic, $item);
		// echo "<pre>"; print_r ($dataGET); exit();


		$array_sudah = array();
		$array_terkelompok = array();
		foreach ($dataGET as $key => $value) {
			if (in_array($value['NO_DOCUMENT'], $array_sudah)) {
				
			}else if ($value['ITEM'] == $item){
				array_push($array_sudah, $value['NO_DOCUMENT']);
				if ($no_document == 'NO_DOCUMENT') {
					$getBody = $dataGET;
					$getKet = $this->M_monitoring->getKet($no_document);
					$hitung_bd = count($getBody);
					$hitung_ket = count($getKet);
					if ($hitung_bd == $hitung_ket) {
						$status= 'Sudah terlayani';
					} else {
						$status = 'Belum terlayani';
					}
				}else {
					$getBody = $dataGET;
					$getKet = $this->M_monitoring->getKet($no_document);
					$hitung_bd = count($getBody);
					$hitung_ket = count($getKet);
					if ($hitung_bd == $hitung_ket) {
						$status= 'Sudah terlayani';
					} else {
						$status = 'Belum terlayani';
					}
				}
				$array_terkelompok[$value['NO_DOCUMENT']]['header'] = $value; 
				$array_terkelompok[$value['NO_DOCUMENT']]['header']['statusket'] = $status; 
				$array_terkelompok[$value['NO_DOCUMENT']]['body'] = $getBody; 
			}else{
				array_push($array_sudah, $value['NO_DOCUMENT']);
				if ($no_document == 'NO_DOCUMENT') {
					$getBody = $this->M_monitoring->getSearch($value['NO_DOCUMENT'], $no_document, $jenis_dokumen, $tglAwal, $tglAkhir, $pic, $item);
					$getKet = $this->M_monitoring->getKet($no_document);
					$hitung_bd = count($getBody);
					$hitung_ket = count($getKet);
					if ($hitung_bd == $hitung_ket) {
						$status= 'Sudah terlayani';
					} else {
						$status = 'Belum terlayani';
					}
					
				}else {
					$getBody = $this->M_monitoring->getSearch($value['NO_DOCUMENT'], $no_document, $jenis_dokumen, $tglAwal, $tglAkhir, $pic, $item);
					$getKet = $this->M_monitoring->getKet($value['NO_DOCUMENT']);
					$hitung_bd = count($getBody);
					$hitung_ket = count($getKet);
					if ($hitung_bd == $hitung_ket) {
						$status= 'Sudah terlayani';
					} else {
						$status = 'Belum terlayani';
					}
				}

				$array_terkelompok[$value['NO_DOCUMENT']]['header'] = $value; 
				$array_terkelompok[$value['NO_DOCUMENT']]['header']['statusket'] = $status; 
				$array_terkelompok[$value['NO_DOCUMENT']]['body'] = $getBody; 
				}
			}
		
		// echo "<pre>"; 
		// print_r($getBody);
		// print_r($array_sudah);
		// print_r($array_terkelompok);
		// exit();		

		$data['value'] = $array_terkelompok;
		// echo "<pre>";
		// print_r($data['value']);
		// exit();

		$this->load->view('MonitoringGdSparepart/V_Result', $data);
	}


	public function getUpdate(){
		$nitem = $this->input->post('item[]');
		$jok = $this->input->post('jml_ok[]');
		$not = $this->input->post('jml_not_ok[]');
		$ket = $this->input->post('keterangan[]');
		// echo "<pre>"; print_r ($_POST); exit();
		
		for ($i=0; $i < count($nitem); $i++) { 
			$item = $nitem[$i];
			$jml_ok = $jok[$i];
			$jml_not_ok = $not[$i];
			$keterangan = $ket[$i];

			if (!empty($jml_ok) && !empty($jml_not_ok) && !empty($keterangan)) {
				$this->M_monitoring->dataUpdate($item, $jml_ok, $jml_not_ok, $keterangan);
			}

			// echo"<pre>";
			// print_r($update);
		}
		// exit;

		redirect(base_url('MonitoringGdSparepart/Monitoring/'));
	}
}