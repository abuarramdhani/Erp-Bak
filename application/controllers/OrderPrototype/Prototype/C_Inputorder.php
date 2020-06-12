<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Inputorder extends CI_Controller
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
		$this->load->model('OrderPrototype/M_order');

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

		$data['Title'] = 'Input Order';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $data['noorder'] = $this->noorder();
		$data['tgl_order'] = date('d-M-Y');

		$proses = $this->M_order->selectproses();

		// echo "<pre>";print_r($proses);exit();

		$data['proses'] = $proses;


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderPrototype/Prototype/V_InputOrder',$data);
		$this->load->view('V_Footer',$data);
	}

	public function format_date($date)
	{
		$ss = explode("/",$date);
		return $ss[2]."-".$ss[1]."-".$ss[0];
	}
	public function noorder()
	{
		$back = 1;

		check:

		$tahun = date('y');
		$bulan = date('m');
		// $hari = date('d');

		$no_order = 'E-'.$tahun.$bulan.str_pad($back, 3, "0", STR_PAD_LEFT);
		$check = $this->M_order->ceknomororder($no_order);
		
		if (!empty($check)) {
			$back++;
			GOTO check;
		}

		return $no_order;
	}

	public function sugestproses()
	{
		$data = $this->M_order->selectproses();
		echo json_encode($data);
	}

	public function InsertOrder()
	{

		$komp_order = $this->input->post('komp_order');
		$namakomp_order = $this->input->post('namakomp_order');
		$due_order = $this->input->post('due_order');
		$type_order = $this->input->post('type_order');
		$qty_order = $this->input->post('qty_order');
		$asmat_order = $this->input->post('asmat_order');
		$tglkirim_order = $this->input->post('tglkirim_order');
		$ket_order = $this->input->post('ket_order');
		$proses_order = $this->input->post('proses_order[]');
		$no_order = $this->noorder();
		$tgl_order = $this->input->post('tgl_order');
		$img_order = $this->input->post('img_order');
		$urutanproses = $this->input->post('urutanproses[]');


		// echo "<pre>";print_r($urutanproses);exit();
		if ($tglkirim_order == "-") {
			$this->M_order->insertorder2($no_order ,$tgl_order, $due_order, $komp_order, $namakomp_order, $type_order, $qty_order, $ket_order);
		} else{
			$this->M_order->insertorder($no_order ,$tgl_order, $due_order, $komp_order, $namakomp_order, $type_order, $qty_order, $tglkirim_order, $ket_order);
		}

		$i=0;
		foreach ($proses_order as $proses) {
			$this->M_order->insertorderproses($no_order ,$proses, $urutanproses[$i]);
			$i++;
		}

		if(!is_dir('./img')) 
		{
			mkdir('./img', 0777, true);
			chmod('./img', 0777);
		}

		$filename = "img/".$no_order.'.png'; 
		$temp_name = $_FILES['img_order']['tmp_name'];
		// Check if file already exists
		if (file_exists($filename)) {
			move_uploaded_file($temp_name,$filename); 
		}else{
			move_uploaded_file($temp_name,$filename); 
				
			}
			redirect(base_url('OrderPro/monorderpro'));
	}

}