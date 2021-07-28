<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Order extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('PHPMailerAutoload');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('OrderHandling/M_order');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

    //------------------------------------------------ INPUT ORDER------------------------------------------------------
	public function Input_Order()
	{
		$username = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Order Tim Handling';
		$data['Menu'] = 'Input Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderHandling/V_Order', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function getsaranahandling(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_order->getsaranahandling($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}
    
    public function save_input_order(){
		$jenis = $this->input->post('jenis_order');
        
		if ($jenis == 1) {
			$order_num = 'C'.date('dmyHis');
		}elseif ($jenis == 2) {
			$order_num = 'R'.date('dmyHis');
		}else {
			$order_num = 'D'.date('dmyHis');
		}
		// echo "<pre>";print_r($jenis);exit();

        if (!empty($_FILES['file_design']['name'])) {
			$format = explode(".", $_FILES['file_design']['name']);
			$file_design = $order_num.'.'.$format[1];
            if(!is_dir('./assets/upload/OrderTimHandling/design'))
            {
                mkdir('./assets/upload/OrderTimHandling/design', 0777, true);
                chmod('./assets/upload/OrderTimHandling/design', 0777);
            }
            $filename = './assets/upload/OrderTimHandling/design/'.$file_design;
            move_uploaded_file($_FILES['file_design']['tmp_name'],$filename);
        }else {
            $file_design = '';
		}
		
        $datanya = array(
			'order_number' 	=> $order_num,
			'order_type' 	=> $jenis,
            'handling_type' => $this->input->post('sarana_handling'),
            'handling_name' => $this->input->post('nama_handling'),
            'design' 		=> $file_design,
            'quantity' 		=> $this->input->post('jumlah_order'),
            'due_date'		=> $this->input->post('due_date'),
            'order_reason' 	=> $this->input->post('alasan_order'),
            'creation_date' => date('Y-m-d H:i:s'),
            'created_by' 	=> $this->session->user,
            'section' 		=> substr($this->session->kodesie,0,7),
			'status' 		=> 0,
			'revision'		=> 'N'
        );
        $this->M_order->input_order($datanya);
        redirect(base_url('OrderHandling/InputOrder'));
    }


    //-------------------------------------------------------- STATUS ORDER -----------------------------------------------------------------------
    
	public function Status_Order()
	{
		$username = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Order Tim Handling';
		$data['Menu'] = 'Status Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderHandling/V_Status', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function getstatus($status){
		$name = $status == -1 ? 'Rejected' : (
			$status == 0 ? 'Proses Approve' : (
				$status == 1 ? 'Proses Plotting' : (
					$status == 2 ? 'In Progress' : (
						$status == 3 ? 'Finished' : ''
					)
				)
			)
		);
		return $name;
	}
    
    public function data_status(){
		$getdata = $this->M_order->getdata_status($this->session->user);
		foreach ($getdata as $key => $value) {
			$getdata[$key]['status_name'] = $this->getstatus($value['status']);
		}
		// echo "<pre>";print_r($getdata);exit();
		$data['data'] = $getdata;
		$this->load->view('OrderHandling/ajax/V_Status_Table', $data);
	}
	
	public function revisi_order(){
		$getdata = $this->M_order->getdata_revisi($this->input->post('id_order'));
		foreach ($getdata as $key => $value) {
			$getdata[$key]['order_type_name'] = $value['order_type'] == 1 ? 'Pembuatan Sarana Handling' : (
				$value['order_type'] == 2 ? 'Repair Sarana Handling' : (
					$value['order_type'] == 3 ? 'Perusakan Komponen Reject' : ''
				)
			);
			$getdata[$key]['handling_type_name'] = $value['handling_type'] == 1 ? 'Sarana Handling Yang Tersedia' : (
				$value['handling_type'] == 2 && $value['order_type'] == 1 ? 'Buat Baru' : (
					$value['handling_type'] == 3 && $value['order_type'] == 3 ? 'Nama Komponen' : 'Lain-lain'
				)
			);
		}
		$data['data'] = $getdata;
		// echo "<pre>";print_r($getdata);exit();
		$this->load->view('OrderHandling/ajax/V_Mdl_Revisi', $data);
	}
	
	public function save_revisi_order(){
        $id_order = $this->input->post('id_order');
		$revisi = $this->db->select('oh.*')->where("oh.order_number = '".$id_order."'")->get('oth.trevisi oh')->result_array();
		
        if (!empty($_FILES['file_design']['name'])) {
			$format = explode(".", $_FILES['file_design']['name']);
			$file_design = $id_order.'-'.(count($revisi)+1).'.'.$format[1];
            if(!is_dir('./assets/upload/OrderTimHandling/design'))
            {
                mkdir('./assets/upload/OrderTimHandling/design', 0777, true);
                chmod('./assets/upload/OrderTimHandling/design', 0777);
            }
            $filename = './assets/upload/OrderTimHandling/design/'.$file_design;
            move_uploaded_file($_FILES['file_design']['tmp_name'],$filename);
		}else {
			$file_design = $this->input->post('file_design_name');
		}
		
        $datanya = array(
			'order_number' 	=> $id_order,
			'order_type' 	=> $this->input->post('jenis_order'),
            'handling_type' => $this->input->post('sarana_handling'),
            'handling_name' => $this->input->post('nama_handling'),
            'design' 		=> $file_design,
            'quantity' 		=> $this->input->post('qty'),
            'due_date'		=> $this->input->post('due_date'),
            'order_reason' 	=> $this->input->post('alasan_order'),
            'creation_date' => date('Y-m-d H:i:s'),
            'created_by' 	=> $this->session->user,
            'section' 		=> substr($this->session->kodesie,0,7),
			'status' 		=> 0,
			'revision'		=> 'N',
			'revision_number' => (count($revisi)+1)
        );
        $this->M_order->input_revisi($datanya);
		$this->M_order->update_revisi($id_order);
		$this->M_order->update_revisi2($id_order, (count($revisi)));

		redirect(base_url("OrderHandling/StatusOrder"));
	}
	

}