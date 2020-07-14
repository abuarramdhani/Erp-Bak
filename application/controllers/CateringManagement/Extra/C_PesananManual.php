<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_PesananManual extends CI_Controller
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
		$this->load->model('CateringManagement/Extra/M_pesananmanual');

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

		$data['Title'] = 'Data Pesanan';
		$data['Menu'] = 'Catering Management ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['simpan']= $this->M_pesananmanual->keep();
		// $data['update']= $this->M_pesananmanual->ubah();
		// $data['hapus']= $this->M_pesananmanual->delete();
		// echo '<pre>';print_r($data['simpan']); exit();

		$today = date('Y-m-d');
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/PesananManual/V_PesananManual');
		$this->load->view('V_Footer',$data);

	}
	public function simpan()
	{
		$tgl_pesanan = $this->input->post('tanggal_pesanan');
		$tgl_pesanan = date('Y-m-d');
		$kd_shift = $this->input->post('shift_pesanan');
		$tempat_makan = $this->input->post('tempat_makan');
		$pesanan_staf = $this->input->post('jumlah_pesanan_staf');
		$pesanan_nonstaf = $this->input->post('jumlah_pesanan_nonstaf');
		$jumlah_pesanan = $this->input->post('jumlah_pesanan');

		$array = array(
					'fd_tanggal' => $tgl_pesanan,
					'fs_tempat_makan' => $tempat_makan,
					'fs_kd_shift' => $kd_shift,
					'fn_jumlah_pesan' => $jumlah_pesanan,
				);
		// print_r($array); exit();
		
		$simpan= $this->M_pesananmanual->simpan($array);
		
		redirect('CateringManagement/Extra/PesananManual');

	}
		public function Read($id)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Data Pesanan';
		$data['Menu'] = 'Catering Management ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['read'] = $this->M_pesananmanual->read($id);
		// print_r($this->M_pesananmanual->read($id)); exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/PesananManual/V_read',$data);
		$this->load->view('V_Footer',$data);
	}
	

	public function Edit($id)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Data Pesanan';
		$data['Menu'] = 'Catering Management ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['edit'] = $this->M_pesananmanual->edit($id);

		// print_r($this->M_pesananmanual->edit($id)); exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/PesananManual/V_edit');
		$this->load->view('V_Footer',$data);
	}

	public function update()
	{
		// print_r($_POST); exit();
		$tgl_pesanan 	= $this->input->post('tanggal_pesanan');
		// $tgl_pesanan 	= date('Y-m-d');
		$kd_shift 		= $this->input->post('shift_pesanan');
		$tempat_makan 	= $this->input->post('tempat_makan');
		$jumlah_pesanan = $this->input->post('jumlah_pesanan');
		$submit 		= $this->input->post('submit');
		
		$update= $this->M_pesananmanual->update($tgl_pesanan,$kd_shift,$tempat_makan,$jumlah_pesanan,$submit);
		
		redirect('CateringManagement/Extra/PesananManual');
	}	
	public function hapus($id)
	{
		// echo $id;
		// exit();
		$this->M_pesananmanual->delete($id);
		redirect(base_url('CateringManagement/Extra/PesananManual'));
	}
}
?>
