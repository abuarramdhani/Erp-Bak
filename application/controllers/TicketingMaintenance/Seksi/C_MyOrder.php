<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MyOrder extends CI_Controller
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
		$this->load->model('TicketingMaintenance/M_seksi');

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
		$noind = $this->session->user;
		$data['getSeksiUnit'] = $this->M_seksi->detectSeksiUnit($noind);
		$split = $data['getSeksiUnit'][0];
		$seksi = $split['seksi'];

		$data['Title'] = 'My Order';
		$data['Menu'] = 'Ticketing Maintenance Seksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['order'] = $this->M_seksi->view($seksi);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TicketingMaintenance/Seksi/MyOrder/V_myOrder', $data);
		$this->load->view('V_Footer',$data);
	}

	public function detail($id)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'My Order';
		$data['Menu'] = 'Ticketing Maintenance Seksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['noind'] = $this->session->user;
		$noind = $data['noind'];
		$data['orderDetail'] = $this->M_seksi->viewById($id,$noind);
		$data['noInduk'] = $this->session->user;

		$data['orderById'] = $this->M_seksi->viewById($id,$noind); //select data order
		$no_order = $data['orderById'][0]['no_order'];
		$data['viewLaporanPerbaikan'] = $this->M_seksi->viewLaporanPerbaikan($no_order); //select laporan perbaikan

		if ($data['viewLaporanPerbaikan'] == null) {
			$data['viewLaporanPerbaikan'] = null;
			$data['viewKeterlambatan'] = $this->M_seksi->viewKeterlambatan($id);
			// echo "<pre>";echo 'here I am'; print_r($data['viewKeterlambatan']);exit();
		}else{
			$data['viewLaporanPerbaikan'] = $this->M_seksi->viewLaporanPerbaikan($no_order);
			$id_laporan = $data['viewLaporanPerbaikan'][0]['id_laporan']; //get id laporan
			$data['viewLangkahPerbaikan'] = $this->M_seksi->viewLangkahPerbaikan($id_laporan); //select langkah perbaikan
	
			// $getId = $this->M_agent->slcIdReparasi($no_order);
			// echo "<pre>";print_r($getId);
			// exit();
			
			// if ($getId == null) {
			// 	$getId = null;
			// }else{
			$getId = $this->M_seksi->slcIdReparasi($no_order);
			// }
			$id_reparasi = $getId[0]['id'];
			// $data['viewReparasi'] = $this->M_seksi->viewDataReparasi($id,$id_reparasi); //select data reparasi
			// $data['viewPelaksanaReparasi'] = $this->M_agent->viewPelaksanaReparasi($id_reparasi);
			if ($id_reparasi !== null) {
				$data['viewAllReparation'] = $this->M_seksi->slcAllReparation($id);
			}else{
				$data['viewAllReparation'] = null;
			}
			// echo "<pre>";print_r($data['viewAllReparation']);exit();

			$data['viewSparepart'] = $this->M_seksi->viewSparePart($id);
			$data['viewKeterlambatan'] = $this->M_seksi->viewKeterlambatan($id);
		}
		// echo "<pre>";print_r($data['viewReparasi']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TicketingMaintenance/Seksi/MyOrder/V_myOrderDetail', $data);
		$this->load->view('V_Footer',$data);
	}

	public function search()
	{
		$status = $this->input->post('status');
		$tanggal_awal = $this->input->post('tanggal_awal');
		$tanggal_akhir = $this->input->post('tanggal_akhir');

		$this->seksi->search($status, $tanggal_awal, $tanggal_akhir);
	}

	public function	closeOrder()
	{
		// $noind = $this->session->user;
		// $status = 'close';
		// $now = date('Y/m/d h:i:s', time());
		$id = $this->input->post('id');
		$noind = $this->input->post('noind');
		$status = $this->input->post('status');
		$now = $this->input->post('now');

		$updateClose = $this->M_seksi->closeOrder($noind,$status,$now,$id);
		// redirect('TicketingMaintenance/Seksi/MyOrder/');
	}

}