<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class C_SuratPernyataan extends CI_Controller
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
		$this->load->library('general');
		$this->load->library('KonversiBulan');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Other/M_suratpernyataan');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index()
	{
		$data  = $this->general->loadHeaderandSidemenu('Master Pekerja', 'Surat Pernyataan', 'Lain-lain', 'Surat Pernyataan', '');
        // print_r($loker);exit();
        $data['list'] = $this->M_suratpernyataan->getlSuper();
        $listRs = $this->M_suratpernyataan->getlRS();
        $data['listRs'] = array_column($listRs, 'nmppk', 'id');
        // print_r($data['listRs']);
        // exit();

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('MasterPekerja/Other/SuratPernyataan/V_Index',$data);
        $this->load->view('V_Footer',$data);
	}

	public function addsuper()
	{
		$data  = $this->general->loadHeaderandSidemenu('Master Pekerja', 'Create Surat Pernyataan', 'Lain-lain', 'Surat Pernyataan', '');
        // print_r($loker);exit();

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('MasterPekerja/Other/SuratPernyataan/V_Create',$data);
        $this->load->view('V_Footer',$data);
	}

	public function getrsklinik()
	{
		$txt = $this->input->get('txt');
		$txt = strtoupper($txt);
		$data = $this->M_suratpernyataan->getrsKlinik($txt);
		echo json_encode($data);
	}

	public function get_hubkerd()
	{
		$txt = $this->input->get('txt');
		$txt = strtoupper($txt);
		$data = $this->M_suratpernyataan->get_lhibkerd($txt);
		echo json_encode($data);
	}

	public function preview_super()
	{
		// print_r($_GET);
		if (count($_GET) < 6) die('Harap Isi Semua Data :D');

		$data['pekerja'] = $this->input->get('pekerja');
		$data['tgl_jkk'] = $this->input->get('tgl_jkk');
		$data['klinik'] = $this->input->get('klinik');
		$data['hubker'] = $this->input->get('hubker');
		$data['nohp'] = $this->input->get('nohp');
		$data['tgl_pernyataan'] = $this->input->get('tgl_pernyataan');
		$data['tgl_cetak'] = $this->input->get('tgl_cetak');

		$data['hari_pernyataan'] = $this->konversibulan->convertke_Hari_Indonesia(date('D', strtotime($data['tgl_cetak'])));
		// echo $data['hari_pernyataan'];exit();
		$data['detail_hubker'] = $this->M_suratpernyataan->getDetailPKJ($data['hubker']);
		$data['detail_pekerja'] = $this->M_suratpernyataan->getDetailPKJ($data['pekerja']);
		// print_r($data['detail_hubker']);exit();
		$data['detail_klinik'] = $this->M_suratpernyataan->getDetailKlinik($data['klinik']);

		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216,297), 10, "Arial", 15, 15, 15, 15, 0, 0, 'P');
		$filename = "Surat Pernyataan.pdf";
		
		$html  = $this->load->view('MasterPekerja/Other/SuratPernyataan/V_Layout',$data,true);
		$pdf->WriteHTML($html);
		$pdf->setTitle($filename);
		$pdf->Output($filename, 'I');
	}

	public function submit_pernyataan()
	{
		// print_r($_POST);
		if (count($_POST) != 7) die('Harap Isi Semua Data :D');
		$user = $this->session->user;
		$pekerja = $this->input->post('pekerja');
		$tgl_jkk = $this->input->post('tgl_jkk');
		$klinik = $this->input->post('klinik');
		$hubker = $this->input->post('hubker');
		$nohp = $this->input->post('nohp');
		$tgl_pernyataan = $this->input->post('tgl_pernyataan');
		$tgl_cetak = $this->input->post('tgl_cetak');

		$nohp = implode(',', $nohp);
		$now = date('Y-m-d H:i:s');

		$arr = array(
			'hubker' => $hubker,
			'pekerja' => $pekerja,
			'tgl_jkk' => $tgl_jkk,
			'rs_klinik_id' => $klinik,
			'create_date' => $now,
			'create_by' => $user,
			'last_update_by' => $user,
			'last_update_date' => $now,
			'tgl_cetak' => $tgl_cetak,
			'tgl_pernyataan' => $tgl_pernyataan,
			'no_hp' => $nohp,
			);
		// print_r($arr);
		$ins = $this->M_suratpernyataan->insSuper($arr);

		redirect('MasterPekerja/surat_pernyataan');
	}

	public function cetak_super()
	{
		$id = $this->input->get('id');
		if(!is_numeric($id)) die('ID not Found :(');
		$list = $this->M_suratpernyataan->getSuperbyID($id);
		if (empty($list)) die('ID not Found :(');
		
		$data['pekerja'] = $list['pekerja'];
		$data['tgl_jkk'] = $list['tgl_jkk'];
		$data['klinik'] = $list['rs_klinik_id'];
		$data['hubker'] = $list['hubker'];
		$data['nohp'] = explode(',',$list['no_hp']);
		$data['tgl_pernyataan'] = $list['tgl_pernyataan'];
		$data['tgl_cetak'] = $list['tgl_cetak'];

		$data['hari_pernyataan'] = $this->konversibulan->convertke_Hari_Indonesia(date('D', strtotime($data['tgl_cetak'])));
		// echo $data['hari_pernyataan'];exit();
		$data['detail_hubker'] = $this->M_suratpernyataan->getDetailPKJ($data['hubker']);
		$data['detail_pekerja'] = $this->M_suratpernyataan->getDetailPKJ($data['pekerja']);
		// print_r($data['detail_hubker']);exit();
		$data['detail_klinik'] = $this->M_suratpernyataan->getDetailKlinik($data['klinik']);

		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216,297), 10, "Arial", 15, 15, 15, 15, 0, 0, 'P');
		$filename = "Surat Pernyataan.pdf";
		
		$html  = $this->load->view('MasterPekerja/Other/SuratPernyataan/V_Layout',$data,true);
		$pdf->WriteHTML($html);
		$pdf->setTitle($filename);
		$pdf->Output($filename, 'I');
	}

	public function edit_super()
	{
		
		$data  = $this->general->loadHeaderandSidemenu('Master Pekerja', 'Edit Surat Pernyataan', 'Lain-lain', 'Surat Pernyataan', '');
		$id = $this->input->get('id');
		if(!is_numeric($id)) die('ID not Found :(');
		$data['l'] = $this->M_suratpernyataan->getSuperbyID($id);
		if (empty($data['l'])) die('ID not Found :(');
		$listRs = $this->M_suratpernyataan->getlRS();
        $data['listRs'] = array_column($listRs, 'nmppk', 'id');
        // print_r($loker);exit();

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('MasterPekerja/Other/SuratPernyataan/V_Edit',$data);
        $this->load->view('V_Footer',$data);
	}

	public function update_pernyataan()
	{
		print_r($_POST);
		if (count($_POST) != 8) die('Harap Isi Semua Data :D');

		$user = $this->session->user;
		$pekerja = $this->input->post('pekerja');
		$tgl_jkk = $this->input->post('tgl_jkk');
		$klinik = $this->input->post('klinik');
		$hubker = $this->input->post('hubker');
		$nohp = $this->input->post('nohp');
		$tgl_pernyataan = $this->input->post('tgl_pernyataan');
		$tgl_cetak = $this->input->post('tgl_cetak');
		$id = $this->input->post('id');

		$nohp = implode(',', $nohp);
		$now = date('Y-m-d H:i:s');

		$arr = array(
			'hubker' => $hubker,
			'pekerja' => $pekerja,
			'tgl_jkk' => $tgl_jkk,
			'rs_klinik_id' => $klinik,
			'last_update_by' => $user,
			'last_update_date' => $now,
			'tgl_cetak' => $tgl_cetak,
			'tgl_pernyataan' => $tgl_pernyataan,
			'no_hp' => $nohp,
			);
		// print_r($arr);
		$up = $this->M_suratpernyataan->upSuper($arr, $id);

		redirect('MasterPekerja/surat_pernyataan');
	}
}