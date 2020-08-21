<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class C_RekapKecelakaan extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('upload');
		$this->load->library('General');
		$this->load->library('pdf');

		$this->load->model('MasterPekerja/Rekap/M_lapkunjungan');
		$this->load->model('MasterPekerja/Rekap/M_rekapkecelakaan');
		$this->load->model('SiteManagement/MainMenu/M_ordermobile');
		$this->load->model('CivilMaintenanceOrder/M_civil');
		$pdf 	=	$this->pdf->load();
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
		$data  = $this->general->loadHeaderandSidemenu('Master Pekerja', 'Rekap Kecelakaan Kerja', 'Rekap', 'Kecelakaan Kerja', '');

		$data['pkj'] = $this->M_ordermobile->getAllpekerja();
		$data['pr'] = date('Y-m').'-01'.' - '.date('Y-m-d');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Rekap/KecelakaanKerja/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function rk_getKecelakaan()
	{
		$pr = $this->input->get('periode');
		$epr = explode(' - ', $pr);
		$data['list'] = $this->M_rekapkecelakaan->rkGetKecelakaan($epr[0], $epr[1]);
		// print_r($data);exit();
		$html = $this->load->view('MasterPekerja/Rekap/KecelakaanKerja/V_Table', $data);
		echo json_encode($html);
	}

	public function get_detailpkjrk()
	{
		$noind = $this->input->get('term');
		$noind = explode(' - ', $noind);
		$noind = $noind[0];
		$data = $this->M_civil->getDetailPkj($noind);
		echo json_encode($data);
	}

	public function rk_addata()
	{
		$user = $this->session->user;

		$id = $this->M_rekapkecelakaan->getLastrck();
		$l = 7-strlen($id);
		$nol = str_repeat('0', $l);
		$id = $nol.$id;

		$noind = $this->input->post('noind');
		$noind = explode(' - ', $noind);
		$noind = $noind[0];
		$dtl = $this->M_civil->getDetailPkj($noind);
		$noind_baru = $dtl[0]['noind_baru'];
		$kodesie = $dtl[0]['kodesie'];
		$tanggal = $this->input->post('tanggal');
		$keterangan = $this->input->post('keterangan');
		$kondisi = $this->input->post('kondisi');
		$penyebab = $this->input->post('penyebab');
		$tindakan = $this->input->post('tindakan');

		$arr = array(
			'id_rkk' => $id,
			'noind' => $noind,
			'noind_baru' => $noind_baru,
			'kodesie' => $kodesie,
			'tanggal' => $tanggal,
			'keterangan' => $keterangan,
			'kondisi' => $kondisi,
			'penyebab' => $penyebab,
			'tindakan' => $tindakan,
			'user_' => $user,
			);
		// print_r($arr);
		$in = $this->M_rekapkecelakaan->addrkc($arr);

		$dtl = $this->M_civil->getDetailPkj($user);
		$noind_baru_pekerja = $dtl[0]['noind_baru'];
		$arrlog = array(
			'wkt'			=>	date('Y-m-d H:i:s'),
			'menu'			=>	"FILE -> REKAP KECELAKAAN KERJA",
			'ket'			=>	"NOIND :".$noind.", KODESIE :".$kodesie.", TANGGAL :".date('d/m/Y', strtotime($tanggal)),
			'noind'			=>	$user,
			'jenis'			=>	"SIMPAN DATA REKAP KECELAKAAN KERJA",
			'program'		=>	"PEKERJA",
			'noind_baru'	=>	$noind_baru_pekerja,
			);
		$this->M_rekapkecelakaan->insrkklog($arrlog);
		if ($in) {
			$data['status'] = 'sukses';
		}else{
			$data['status'] = 'gagal';
		}
		echo json_encode($data);
	}

	public function del_rkkdata()
	{
		$user = $this->session->user;
		$id = $this->input->post('id');
		$kc = $this->M_rekapkecelakaan->getRkk($id)[0];
		$del = $this->M_rekapkecelakaan->delrkkc($id);

		$dtl = $this->M_civil->getDetailPkj($user);
		$noind_baru_pekerja = $dtl[0]['noind_baru'];
		$arrlog = array(
			'wkt'			=>	date('Y-m-d H:i:s'),
			'menu'			=>	"FILE -> REKAP KECELAKAAN KERJA",
			'ket'			=>	"NOIND :".$kc['noind'].", KODESIE :".$kc['kodesie'].", TANGGAL :".date('d/m/Y', strtotime($kc['tanggal'])),
			'noind'			=>	$user,
			'jenis'			=>	"HAPUS DATA REKAP KECELAKAAN KERJA",
			'program'		=>	"PEKERJA",
			'noind_baru'	=>	$noind_baru_pekerja,
			);
		$this->M_rekapkecelakaan->insrkklog($arrlog);

		if ($del) {
			$data['status'] = 'sukses';
		}else{
			$data['status'] = 'gagal';
		}
		echo json_encode($data);
	}

	public function getrkk_data()
	{
		$id = $this->input->get('id');
		$data = $this->M_rekapkecelakaan->getRkk($id);
		echo json_encode($data);
	}

	public function up_rkkdata()
	{
		$user = $this->session->user;
		// print_r($_POST);
		$noind = $this->input->post('noind');
		$noind = explode(' - ', $noind);
		$noind = $noind[0];
		$dtl = $this->M_civil->getDetailPkj($noind);
		$noind_baru = $dtl[0]['noind_baru'];
		$kodesie = $dtl[0]['kodesie'];
		$tanggal = $this->input->post('tanggal');
		$keterangan = $this->input->post('keterangan');
		$kondisi = $this->input->post('kondisi');
		$penyebab = $this->input->post('penyebab');
		$tindakan = $this->input->post('tindakan');
		$id = $this->input->post('id');

		$arr = array(
			'tanggal' => $tanggal,
			'keterangan' => $keterangan,
			'kondisi' => $kondisi,
			'penyebab' => $penyebab,
			'tindakan' => $tindakan,
			'user_' => $user,
			);
		$up = $this->M_rekapkecelakaan->up_rkkc($arr, $id);

		$kc = $this->M_rekapkecelakaan->getRkk($id)[0];
		// print_r($kc);exit();
		$dtl = $this->M_civil->getDetailPkj($user);
		$noind_baru_pekerja = $dtl[0]['noind_baru'];
		$arrlog = array(
			'wkt'			=>	date('Y-m-d H:i:s'),
			'menu'			=>	"FILE -> REKAP KECELAKAAN KERJA",
			'ket'			=>	"NOIND :".$kc['noind'].", KODESIE :".$kc['kodesie'].", TANGGAL :".date('d/m/Y', strtotime($kc['tanggal'])),
			'noind'			=>	$user,
			'jenis'			=>	"EDIT DATA REKAP KECELAKAAN KERJA",
			'program'		=>	"PEKERJA",
			'noind_baru'	=>	$noind_baru_pekerja,
			);
		$this->M_rekapkecelakaan->insrkklog($arrlog);
		if ($up) {
			$data['status'] = 'sukses';
		}else{
			$data['status'] = 'gagal';
		}
		echo json_encode($data);
	}
}