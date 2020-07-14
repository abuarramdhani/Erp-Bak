<?php
Defined('BASEPATH') or exit('No direct script accsess allowed');
ini_set('error_reporting', E_ALL);
ini_set('display_errors','On');
set_time_limit(0);
/**
 * 
 */
class C_TransferPuasa extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CateringManagement/Puasa/M_transferpuasa');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Transfer Puasa';
		$data['Menu'] = 'Puasa';
		$data['SubMenuOne'] = 'Transfer';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Puasa/TransferPuasa/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Proses(){
		$tgl = $this->input->post('tanggal');
		$periode = $this->input->post('periode');
		$periode = explode(" - ", $periode);
		$pd1 = $periode['0'];
		$pd2 = $periode['1'];
		$this->M_transferpuasa->deletePuasa($tgl,$tgl);
		$pekerjaPuasa = $this->M_transferpuasa->getPekerjaPuasa();
		$angka = 0;
		foreach ($pekerjaPuasa as $key) {
			$this->M_transferpuasa->insertPuasa($tgl,$key['noind'],$key['tempat_makan']);
			$angka++;
		}
		$selanjutnya = $this->M_transferpuasa->getHariSelanjutnya($tgl,$pd1,$pd2);
		foreach ($selanjutnya as $key) {
			echo $key['periode1']." ".$key['periode2']." - ".$key['tgl']." ".$key['bln']." ".$key['thn'];
		}
	}

	public function Batal(){
		$tgl = $this->input->post('tanggal');
		$tgl = explode(" - ", $tgl);
		$awal = $tgl['0'];
		$akhir = $tgl['1'];
		$this->M_transferpuasa->deletePuasa($awal,$akhir);
		echo "sukses membatalkan transfer puasa";
	}
}
?>