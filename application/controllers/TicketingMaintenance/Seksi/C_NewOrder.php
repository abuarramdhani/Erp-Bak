<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class C_NewOrder extends CI_Controller
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
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		// echo $noind;exit();
		$user_id = $this->session->userid;
		// echo $user_id;exit();
//

		$data['Title'] = 'New Order';
		$data['Menu'] = 'Ticketing Maintenance Seksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$noind = $this->session->user;
		$data['getSeksiUnit'] = $this->M_seksi->detectSeksiUnit($noind);
		$split = $data['getSeksiUnit'][0];
		$seksi = $split['seksi'];
		$unit = $split['unit'];

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TicketingMaintenance/Seksi/NewOrder/V_newOrder', $data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$status = 'open';

		$noind = $this->session->user;
		$data['getSeksiUnit'] = $this->M_seksi->detectSeksiUnit($noind);
		$split = $data['getSeksiUnit'][0];
		$seksi = $split['seksi'];

		$kode = $this->M_seksi->selectKodeSeksi($seksi);
		$kode_seksi = $kode[0]['kode_seksi'];
			if ($kode_seksi == null) {
				$kode_seksi = "XXX";
			}

		$now = date('Y/m');
		$date = explode("/", $now);
		$year = $date[0];
		$month = $date[1];
		$count_month = strlen($month);
			if ($count_month == 1) {
				$month = "0"."".$month;
			}

		$no_order = $kode_seksi."-".$month."-".$year; //generate no order di awal
		// echo "<pre>"; echo $no_order;

		$checkOrder = $this->M_seksi->checkOrder($no_order); 
		$co = $checkOrder[0]['nomor'];
		$nOrder = explode("-", $co);
		$urutan_order = $nOrder[3]; //urutan max order
		$format = $nOrder[0]."-".$nOrder[1]."-".$nOrder[2]; //format order tanpa urutan diambil dari max order

		$add = $urutan_order+1;

		$count = strlen($urutan_order);
		if ($count == 1) {
			$ordering = "00"."".$urutan_order;
		}elseif ($count == 2) {
			$ordering = "0"."".$urutan_order;
		}else {
			$ordering = $urutan_order;
		}

		//SET ORDER NUMBER//
			if ($no_order !== $format) {
				$nomor_order = $kode_seksi."-".$month."-".$year."-001";
			}else{
				$ordering_number = intval($ordering);
				// echo "<pre>"; echo $ordering_number;
				$orderingNumber = sprintf('%03d', $ordering_number+1);
				$nomor_order = $kode_seksi."-".$month."-".$year."-".$orderingNumber;
			}		

		// echo "<pre>"; echo "final result: "; echo $nomor_order;
		// die;
		$data = array(
			'no_order' => $nomor_order,
			'seksi' => $this->input->post('seksi'),
			'tgl_order' => date("Y-m-d H:i:s"),
			'unit' => $this->input->post('unit'),
			'nama_mesin' => $this->input->post('txtJenisMesin'),
			'nomor_mesin' => $this->input->post('txtNoMesin'),
			'line' => $this->input->post('line'),
			'kerusakan' => $this->input->post('kerusakan'),
			'kondisi_mesin' => $this->input->post('kondisi'),
			'need_by_date' => $this->input->post('need_you'),
			'reason_need_by_date' => $this->input->post('your_reason'),
			'running_hour' => $this->input->post('runningHour'),
			'status_order' => 'open',
			'noind_pengorder' => $noind
		);
		// echo "<pre>";print_r($data);die;
		$this->M_seksi->create($data);

		redirect(base_url('TicketingMaintenance/Seksi/MyOrder'));
	}
	
	public function NoMesin()
	{
    $nm = $this->input->GET('nm',TRUE);
    $nm = strtoupper($nm);  
    $noMesin = $this->M_seksi->SelectNoMesin($nm);
    echo json_encode($noMesin);
	}

	public function jenisMesin() 
	{   
    $param = $this->input->post('params');
    // $last = end($param);
    $jenis = $this->M_seksi->jenisMesin($param);

    echo json_encode($jenis);
	} 

	public function editOrder($id)
	{
		$user = $this->session->username;
		// echo $noind;exit();
		$user_id = $this->session->userid;
		// echo $user_id;exit();

		$data['Title'] = 'New Order';
		$data['Menu'] = 'Ticketing Maintenance Seksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$noind = $this->session->user;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['getOrderData'] = $this->M_seksi->viewById($id,$noind);
		
		$data['getSeksiUnit'] = $this->M_seksi->detectSeksiUnit($noind);
		$split = $data['getSeksiUnit'][0];
		$seksi = $split['seksi'];
		$unit = $split['unit'];

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TicketingMaintenance/Seksi/NewOrder/V_editOrder', $data);
		$this->load->view('V_Footer',$data);
	}

	public function saveEditOrder($nomor_order)
	{
		$nomor_mesin = $this->input->post('txtNoMesin');
		$nama_mesin = $this->input->post('txtJenisMesin');
		$line = $this->input->post('line');
		$kerusakan = $this->input->post('kerusakan');
		$kondisi_mesin = $this->input->post('kondisi');
		$need_by_date = $this->input->post('need_you');
		$reason_need_by_date = $this->input->post('your_reason');
		$running_hour = $this->input->post('runningHour');

		// echo "<pre>";print_r($data);die;
		$editOrder = $this->M_seksi->editDataOrder($nomor_order, $nomor_mesin, $nama_mesin, $line, $kerusakan,
					 $kondisi_mesin, $need_by_date, $reason_need_by_date, $running_hour);

		redirect(base_url('TicketingMaintenance/Seksi/MyOrder'));
	}


}