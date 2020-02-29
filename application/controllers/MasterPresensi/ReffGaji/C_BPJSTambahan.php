<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);

class C_BPJSTambahan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('General');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/ReffGaji/M_bpjstambahan');
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

		$data['Title']			=	'BPJS Tambahan';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'BPJS Tambahan';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['user'] = $this->session->user;
		// $data['data'] = $this->M_bpjstambahan->getPekerja();
		$data['data'] = array();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/BPJSTambahan/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function showFamily(){
		$noind = $this->input->post('noind');
		$data = $this->M_bpjstambahan->getKeluarga($noind);
		echo json_encode($data);
	}

	public function tambah(){
		$noind = $this->input->post('noind');
		$nama = $this->input->post('nama');
		$this->M_bpjstambahan->tambah($noind,$nama);
		//insert to t_log
		$aksi = 'MASTER PRESENSI';
		$detail = 'Menambah Tanggungan Noind='.$noind.' Nama='.$nama;
		$this->log_activity->activity_log($aksi, $detail);
		//
		echo "selesai";
	}

	public function hapus(){
		$noind = $this->input->post('noind');
		$nama = $this->input->post('nama');
		$this->M_bpjstambahan->hapus($noind,$nama);
		//insert to t_log
		$aksi = 'MASTER PRESENSI';
		$detail = 'Mengurangi Tanggungan Noind='.$noind.' Nama='.$nama;
		$this->log_activity->activity_log($aksi, $detail);
		//
		echo "selesai";
	}

	public function refresh(){
		$data = $this->M_bpjstambahan->getPekerja();
		echo json_encode($data);
	}

	public function ListPekerja(){
		$list = $this->M_bpjstambahan->user_table();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $key->noind;
			$row[] = $key->nama;
			$row[] = $key->seksi;
			$row[] = $key->jumlah;
			$row[] = '<button type="button"
								class="btn btn-sm modal-trigger-MPR-BPJSTambahan"
								data-noind ="'.($key->noind).'"
								style="background-image: linear-gradient(70deg, #2ABB9B 70%, #16A085 30%);color: white">
									<span class="fa fa-pencil"></span>
								</button>';

			$data[] = $row;
		}

		$output = array(
			'draw' => $_POST['draw'],
			'recordsTotal' =>$this->M_bpjstambahan->count_all(),
			'recordsFiltered' => $this->M_bpjstambahan->count_filtered(),
			'data' => $data
		);

		echo json_encode($output);
	}
}

?>
