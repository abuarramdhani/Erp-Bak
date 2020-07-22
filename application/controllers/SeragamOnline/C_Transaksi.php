<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
* 
*/
class C_Transaksi extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->library('Excel');
        $this->load->library('General');
        //load the login model
        $this->load->library('session');

        $this->load->model('M_Index');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('SeragamOnline/M_seragam');

        date_default_timezone_set('Asia/Jakarta');

        if ($this->session->userdata('logged_in')!=true) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
	}

	public function BajuMasuk()
	{
		$user_id = $this->session->userid;
		
		$data  = $this->general->loadHeaderandSidemenu('ERP - Seragam Online', 'Baju Masuk', 'Transaksi', 'Baju Masuk', '');
		$data['tpBaju'] = $this->M_seragam->getTipeBaju('ttipe_baju', '*');
		$data['tUkuran'] = $this->M_seragam->getTipeBaju('tukuran', '*');
		$data['jnsBaju'] = $this->M_seragam->getJnsBaju();

		$data['baju_masuk'] = $this->M_seragam->listbajuMasuk();

		$arrJS = array_column($data['tpBaju'],'satuan');
		$arrJS = implode("','", $arrJS);
		$data['arrJS'] = "['".$arrJS."']";

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SeragamOnline/Transaksi/V_Baju_Masuk',$data);
		$this->load->view('V_Footer',$data);
	}

	public function CelanaMasuk()
	{
		$user_id = $this->session->userid;
		
		$data  = $this->general->loadHeaderandSidemenu('ERP - Seragam Online', 'Celana Masuk', 'Transaksi', 'Celana Masuk', '');
		$data['tjCelana'] = $this->M_seragam->getTipeBaju('tjenis_celana', '*');
		$data['tUkuran'] = $this->M_seragam->getTipeBaju('tukuran', '*');

		$data['list_celana'] = $this->M_seragam->listcelanaMasuk();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SeragamOnline/Transaksi/V_Celana_Masuk',$data);
		$this->load->view('V_Footer',$data);
	}

	public function TopiMasuk()
	{
		$user_id = $this->session->userid;
		
		$data  = $this->general->loadHeaderandSidemenu('ERP - Seragam Online', 'Topi Masuk', 'Transaksi', 'Topi Masuk', '');
		$data['tjTopi'] = $this->M_seragam->getTipeBaju('tjenis_topi', '*');
		$data['tUkuran'] = $this->M_seragam->getTipeBaju('tukuran', '*');

		$data['list_topi'] = $this->M_seragam->listtopiMasuk();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SeragamOnline/Transaksi/V_Topi_Masuk',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getJenisbyTipe()
	{
		$id_tipe = $this->input->get('tipe');
		if (empty($id_tipe)) {
			$data = array();
		}else{
			$data = $this->M_seragam->getJenisbyTipe($id_tipe);
		}
		echo json_encode($data);
	}

	public function add_baju_masuk()
	{
		$user = $this->session->userdata('user');
		$tgl = $this->input->post('tgl');
		$tipe = $this->input->post('tipe');
		$jenis = $this->input->post('jenis');
		$ukuran = $this->input->post('ukuran');
		$jumlah = $this->input->post('jumlah');

		$data = array(
			'tanggal' => $tgl,
			'id_tipe_baju' => $tipe,
			'id_jenis_baju' => $jenis,
			'id_ukuran' => $ukuran,
			'jumlah' => $jumlah,
			'tgl_input' => date('Y-m-d H:i:s'),
			'by' => $user,
			);
		$this->M_seragam->inMaster('tbaju_masuk', $data);
		redirect('SeragamOnline/Transaksi/BajuMasuk');
	}

	public function edit_baju_masuk()
	{
		$id = $this->input->post('id');

		$tgl = $this->input->post('tgl');
		$tipe = $this->input->post('tipe');
		$jenis = $this->input->post('jenis');
		$ukuran = $this->input->post('ukuran');
		$jumlah = $this->input->post('jumlah');

		$data = array(
			'tanggal' => $tgl,
			'id_tipe_baju' => $tipe,
			'id_jenis_baju' => $jenis,
			'id_ukuran' => $ukuran,
			'jumlah' => $jumlah,
			);
		$this->M_seragam->upMaster('tbaju_masuk', $data, $id);
		redirect('SeragamOnline/Transaksi/BajuMasuk');
	}

	public function hapus_baju_masuk()
	{
		$id = $this->input->get('id');
		$this->M_seragam->delMaster('tbaju_masuk', $id);

		redirect('SeragamOnline/Transaksi/BajuMasuk');
	}

	public function hapus_celana_masuk()
	{
		$id = $this->input->get('id');
		$this->M_seragam->delMaster('tcelana_masuk', $id);

		redirect('SeragamOnline/Transaksi/CelanaMasuk');
	}

	public function hapus_topi_masuk()
	{
		$id = $this->input->get('id');
		$this->M_seragam->delMaster('ttopi_masuk', $id);

		redirect('SeragamOnline/Transaksi/TopiMasuk');
	}

	public function add_celana_masuk()
	{
		$user = $this->session->userdata('user');
		$tgl = $this->input->post('tgl');
		$jenis = $this->input->post('jenis');
		$ukuran = $this->input->post('ukuran');
		$jumlah = $this->input->post('jumlah');

		$data = array(
			'tanggal' => $tgl,
			'id_jenis_celana' => $jenis,
			'id_ukuran' => $ukuran,
			'jumlah' => $jumlah,
			'tgl_input' => date('Y-m-d H:i:s'),
			'by' => $user,
			);
		$this->M_seragam->inMaster('tcelana_masuk', $data);
		redirect('SeragamOnline/Transaksi/CelanaMasuk');
	}

	public function edit_celana_masuk()
	{
		$id = $this->input->post('id');

		$tgl = $this->input->post('tgl');
		$jenis = $this->input->post('jenis');
		$ukuran = $this->input->post('ukuran');
		$jumlah = $this->input->post('jumlah');

		$data = array(
			'tanggal' => $tgl,
			'id_jenis_celana' => $jenis,
			'id_ukuran' => $ukuran,
			'jumlah' => $jumlah,
			);
		$this->M_seragam->upMaster('tcelana_masuk', $data, $id);
		redirect('SeragamOnline/Transaksi/CelanaMasuk');
	}

	public function add_topi_masuk()
	{
		$user = $this->session->userdata('user');
		$tgl = $this->input->post('tgl');
		$jenis = $this->input->post('jenis');
		$ukuran = $this->input->post('ukuran');
		$jumlah = $this->input->post('jumlah');

		$data = array(
			'tanggal' => $tgl,
			'id_jenis_topi' => $jenis,
			'jumlah' => $jumlah,
			'tgl_input' => date('Y-m-d H:i:s'),
			'by' => $user,
			);
		$this->M_seragam->inMaster('ttopi_masuk', $data);
		redirect('SeragamOnline/Transaksi/TopiMasuk');
	}

	public function edit_topi_masuk()
	{
		$id = $this->input->post('id');

		$tgl = $this->input->post('tgl');
		$jenis = $this->input->post('jenis');
		$ukuran = $this->input->post('ukuran');
		$jumlah = $this->input->post('jumlah');

		$data = array(
			'tanggal' => $tgl,
			'id_jenis_topi' => $jenis,
			'jumlah' => $jumlah,
			);
		$this->M_seragam->upMaster('ttopi_masuk', $data, $id);
		redirect('SeragamOnline/Transaksi/TopiMasuk');
	}

	public function SeragamKeluar()
	{
		$user_id = $this->session->userid;
		
		$data  = $this->general->loadHeaderandSidemenu('ERP - Seragam Online', 'Seragam Keluar', 'Transaksi', 'Seragam keluar', '');
		$data['tjTopi'] = $this->M_seragam->getTipeBaju('tjenis_topi', '*');
		$data['tUkuran'] = $this->M_seragam->getTipeBaju('tukuran', '*');

		$data['list_topi'] = $this->M_seragam->listtopiMasuk();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SeragamOnline/Transaksi/V_Topi_Masuk',$data);
		$this->load->view('V_Footer',$data);
	}

}