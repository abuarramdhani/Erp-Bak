<?php defined('BASEPATH') or die('No direct script access allowed');

class C_KronologisKK extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('General');

		$this->load->model('M_Index');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Other/KronologisKecelakaanKerja/M_kronologiskk');

		$this->checkSession();
	}

	public function checkSession()
	{
		if (!$this->session->is_logged) redirect('');
	}

	public function index()
	{
		$data  = $this->general->loadHeaderandSidemenu('Kronologis Kecelakaan Kerja', 'Kronologis Kecelakaan Kerja', 'Lain-lain', 'Kronologis Kecelakaan Kerja', '');

		$data['list'] = $this->M_kronologiskk->getAllKronologis();
		// echo "<pre>";
		// print_r($data['list']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Other/KronologisKecelakaanKerja/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function tambah()
	{
		$data  = $this->general->loadHeaderandSidemenu('Kronologis Kecelakaan Kerja', 'Kronologis Kecelakaan Kerja', 'Lain-lain', 'Kronologis Kecelakaan Kerja', '');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Other/KronologisKecelakaanKerja/V_Tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getnokpj()
	{
		$noind = $this->input->get('noind');
		$data = $this->M_kronologiskk->getNoKPJ($noind);
		echo json_encode($data);
	}

	public function simpan()
	{
		$user = $this->session->user;

		$pkj = $this->input->post('pkj');
		$no_kpj = $this->input->post('no_kpj');
		$tanggal = $this->input->post('tanggal');
		$jam = $this->input->post('jam');
		$tempat = $this->input->post('tempat');
		$uraian = $this->input->post('uraian');
		$uraian_kejadian = $this->input->post('uraian_kejadian');
		$perusahaan = $this->input->post('perusahaan');
		$saksi_1 = $this->input->post('saksi_1');
		$saksi_2 = $this->input->post('saksi_2');

		$arr = array(
			'pekerja'			=> $pkj,
			'no_kpj'			=> $no_kpj,
			'tanggal'			=> $tanggal,
			'jam'				=> $jam,
			'tempat'			=> $tempat,
			'uraian_kejadian'	=> $uraian_kejadian,
			'uraian'			=> $uraian,
			'wakil_perusahaan'	=> $perusahaan,
			'saksi_1'			=> $saksi_1,
			'saksi_2'			=> $saksi_2,
			'update_by'			=> $user,
			'update_date'		=> date('Y-m-d H:i:s'),
			);

		$ins = $this->M_kronologiskk->insKronologis($arr);
		if ($ins)
			redirect('MasterPekerja/KronologisKecelakaanKerja');
		else
			echo "Gagal Insert :(";
	}

	public function edit()
	{
		$id = $this->input->get('id');

		$data  = $this->general->loadHeaderandSidemenu('Kronologis Kecelakaan Kerja', 'Kronologis Kecelakaan Kerja', 'Lain-lain', 'Kronologis Kecelakaan Kerja', '');
		$data['kr'] = $this->M_kronologiskk->getKronologisbyID($id);
		// echo "<pre>";
		// print_r($data['kronologis']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Other/KronologisKecelakaanKerja/V_Edit',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update()
	{
		$user = $this->session->user;

		$user = $this->session->user;
		$pkj = $this->input->post('pkj');
		$no_kpj = $this->input->post('no_kpj');
		$tanggal = $this->input->post('tanggal');
		$jam = $this->input->post('jam');
		$tempat = $this->input->post('tempat');
		$uraian = $this->input->post('uraian');
		$uraian_kejadian = $this->input->post('uraian_kejadian');
		$perusahaan = $this->input->post('perusahaan');
		$saksi_1 = $this->input->post('saksi_1');
		$saksi_2 = $this->input->post('saksi_2');
		$id = $this->input->post('id');

		$arr = array(
			'pekerja'			=> $pkj,
			'no_kpj'			=> $no_kpj,
			'tanggal'			=> $tanggal,
			'jam'				=> $jam,
			'tempat'			=> $tempat,
			'uraian'			=> $uraian,
			'uraian_kejadian'	=> $uraian_kejadian,
			'wakil_perusahaan'	=> $perusahaan,
			'saksi_1'			=> $saksi_1,
			'saksi_2'			=> $saksi_2,
			'update_by'			=> $user,
			'update_date'		=> date('Y-m-d H:i:s'),
			);

		$up = $this->M_kronologiskk->upKronologiskk($arr, $id);

		if ($up)
			redirect('MasterPekerja/KronologisKecelakaanKerja');
		else
			echo "Gagal Update :(";
	}

	public function cetak()
	{
		$id = $this->input->get('id');
		$data['kr'] = $this->M_kronologiskk->getKronologisbyID($id);

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf8', "A4", 11, '', 15, 15, 25, 10, 0, 0);
		$filename = 'Kronologis kecelakaan Kerja - '.$data['kr']['pekerja'];

		$html = $this->load->view('MasterPekerja/Other/KronologisKecelakaanKerja/V_PDF', $data, true);

		$pdf->setTitle($filename);
		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet1, 1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}
}