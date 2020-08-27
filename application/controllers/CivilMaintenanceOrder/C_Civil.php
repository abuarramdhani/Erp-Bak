<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

setlocale(LC_ALL, 'id_ID.utf8');
/**
* 
*/
class C_Civil extends CI_Controller
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
		$this->load->library('upload');
		$this->load->library('General');
		$this->load->library('KonversiBulan');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CivilMaintenanceOrder/M_civil');

		$this->load->library('upload');

		date_default_timezone_set('Asia/Jakarta');

		if($this->session->is_logged === false) redirect('');
	}

	public function index()
	{
		$user = $this->session->user;

		$data  = $this->general->loadHeaderandSidemenu('Civil Maintenance', 'Civil Maintenance Order', '', '', '');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Hardware/V_Index',$data);// nitip view
		$this->load->view('V_Footer',$data);
	}

	public function list_order()
	{
		$user = $this->session->user;

		$data  = $this->general->loadHeaderandSidemenu('Civil Maintenance', 'List Order', 'Order', 'List Order', '');

		$data['list'] = $this->M_civil->getListOrder();
		$data['approve'] = $this->M_civil->getApprover();
		$orderid = $this->session->orderid;
		if (isset($orderid) && !empty($orderid)) {
			$data['order_id'] = $orderid;
			$this->session->orderid = "";
		}
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CivilMaintenanceOrder/Order/V_List_Order',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create_order()
	{
		$user = $this->session->user;

		$data  = $this->general->loadHeaderandSidemenu('Civil Maintenance', 'Input Order', 'Order', 'Input Order', '');

		$data['judul'] = $this->M_civil->listJnsPkj();
		$data['claz'] = '';
		if(in_array($user, ['T0007', 'B0720', 'B0560']))
		$data['claz'] = 'cmo_slcJnsOrder';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CivilMaintenanceOrder/Order/V_Input_Order',$data);
		$this->load->view('V_Footer',$data);
	}

	final function get_detailpkj()
	{
		$noind = $this->input->get('term');
		$data = $this->M_civil->getDetailPkj($noind);
		echo json_encode($data);
	}

	public function getJnsPkj()
	{

		$data = $this->M_civil->listJnsPkj();
		echo json_encode($data);
	}

	public function getJnsPkjDetail()
	{
		$id = $this->input->get('id');
		$data = $this->M_civil->listJnsPkjDetail($id);
		echo json_encode($data);
	}

	public function getJnsOrder()
	{
		$data = $this->M_civil->getTableJenisOrder();
		echo json_encode($data);
	}

	public function save_order()
	{
		// echo "<pre>";
		// print_r($_POST);
		// print_r($_FILES);
		// exit();

		$dari = $this->input->post('dari');
		$kodesie = $this->input->post('kodesie');
		$lokasi = $this->input->post('lokasi');
		$tglorder = $this->input->post('tglorder');
		$penerima = $this->input->post('penerima');
		$tglterima = $this->input->post('tglterima');
		$jnsPekerjaan = $this->input->post('jnsPekerjaan');
		$jnsOrder = $this->input->post('jnsOrder');
		$voip = $this->input->post('voipOrder');
		$ket = $this->input->post('ket');
		$nolog = $this->input->post('nolog');
		$status = $this->input->post('status');
		$tglbutuh = $this->input->post('tglbutuh');
		$alasan = $this->input->post('alasan');

		$data = array(
			'pengorder'			=>	$dari,
			'kodesie_pengorder'	=>	$kodesie,
			'lokasi_pengorder'	=>	$lokasi,
			'tgl_order'			=>	$tglorder,
			'penerima_order'	=>	'B0560',//Eko Prasetyo
			'tgl_terima'		=>	$tglterima,
			'jenis_pekerjaan_id'=>	$jnsPekerjaan,
			'jenis_order_id'	=>	$jnsOrder,
			'ket'				=>	$ket,
			'tgl_dibutuhkan'	=>	$tglbutuh,
			'voip'				=>	$voip,
			'status_id'			=>	1,//open
			'alasan'			=>  $alasan,
			'status'			=>  $status
			);
		$ins = $this->M_civil->insertOrder($data);

		//insert lampiran
		$this->insert_lampiran($ins);

		//insert cvl_order_pekerjaan
		$pekerjaan = $this->input->post('tbl_pekerjaan');
		$qty = $this->input->post('tbl_qty');
		$satuan = $this->input->post('tbl_satuan');
		$keter = $this->input->post('tbl_ket');
		for ($i=0; $i < count($qty); $i++) { 
			$arr = array(
				'order_id'		=>	$ins,
				'pekerjaan'		=>	$pekerjaan[$i],
				'qty'			=>	$qty[$i],
				'satuan'		=>	$satuan[$i],
				'keterangan'	=>	$keter[$i],
				);
			$this->M_civil->insCVP($arr);
		}

		//insert cvl_order_approver
		$jns_appr = $this->input->post('tbl_japprove');
		$aprover = $this->input->post('tbl_approver');
		$stat = $this->input->post('tbl_status');
		for ($i=0; $i < count($stat); $i++) { 
			$arr = array(
				'order_id'			=>	$ins,
				'jenis_approver'	=>	$jns_appr[$i],
				'approver'			=>	$aprover[$i],
				'status_approval'	=>	$stat[$i],
				);
			// $this->M_civil->insCOA($arr); disable 
		}

		$thread = array(
			'order_id'		=>	$ins,
			'thread_detail'	=>	'Create Order',
			'thread_date'	=>	date('Y-m-d H:i:s'),
			'thread_by'		=>	$this->session->user
			);
		$this->M_civil->saveThread($thread);

		$this->session->orderid = $ins;
		redirect('civil-maintenance-order/order/list_order');
	}

	private function set_upload_options()
	{   
		$config = array();
		$config['upload_path'] = 'assets/upload/CivilMaintenance';
		$config['allowed_types'] = '*';
		$config['overwrite']     = 1;

		return $config;
	}

	public function edit_order($id)
	{
		$user = $this->session->user;

		$data  = $this->general->loadHeaderandSidemenu('Civil Maintenance', 'Edit Order', '', '', '');

		$data['order'] = $this->M_civil->getListOrderid($id)->row_array();
		$data['lampiran'] = $this->M_civil->getListlampiran($id);
		$data['ket'] = $this->M_civil->getKetByid($id);
		$data['approve'] = $this->M_civil->getApproverbyId($id);
		$data['status_order'] = $this->M_civil->listSto();
		// echo "<pre>";
		// print_r($data['lapiran']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CivilMaintenanceOrder/Order/V_Edit_Order',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update_order()
	{
		$dari = $this->input->post('dari');
		$kodesie = $this->input->post('kodesie');
		$lokasi = $this->input->post('lokasi');
		$tglorder = $this->input->post('tglorder');
		$penerima = $this->input->post('penerima');
		$tglterima = $this->input->post('tglterima');
		$jnsPekerjaan = $this->input->post('jnsPekerjaan');
		$jnsOrder = $this->input->post('jnsOrder');
		$voip = $this->input->post('voipOrder');
		$keterangan = $this->input->post('ket');
		$nolog = $this->input->post('nolog');
		$tglbutuh = $this->input->post('tglbutuh');
		$status = $this->input->post('status');
		$id = $this->input->post('id');

		$data = array(
			'pengorder'			=>	$dari,
			'kodesie_pengorder'	=>	$kodesie,
			'lokasi_pengorder'	=>	$lokasi,
			'tgl_order'			=>	$tglorder,
			'penerima_order'	=>	$penerima,
			'tgl_terima'		=>	$tglterima,
			'jenis_pekerjaan_id'=>	$jnsPekerjaan,
			'jenis_order_id'	=>	$jnsOrder,
			'ket'				=>	$keterangan,
			'nomor_log'			=>	$nolog,
			'tgl_dibutuhkan'	=>	$tglbutuh,
			'voip'				=>	$voip,
			'status_id'			=>	$status,
			);
		$ins = $this->M_civil->updateOrder($data, $id);

		$thread = array(
			'order_id'		=>	$id,
			'thread_detail'	=>	'Update Order',
			'thread_date'	=>	date('Y-m-d H:i:s'),
			'thread_by'		=>	$this->session->user
			);
		$this->M_civil->saveThread($thread);

		redirect('civil-maintenance-order/order/list_order');
	}

	public function edit_lampiran($id)
	{
		$user = $this->session->user;

		$data  = $this->general->loadHeaderandSidemenu('Civil Maintenance', 'Edit Lampiran', '', '', '');

		$data['lampiran'] = $this->M_civil->getListlampiran($id);
		$data['id'] = $id;
		// echo "<pre>";
		// print_r($data['lapiran']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CivilMaintenanceOrder/Order/V_Edit_Lampiran',$data);
		$this->load->view('V_Footer',$data);
	}

	public function insert_lampiran($id = '')
	{
		$this->load->library('upload');
		$dataInfo = array();
		$files = $_FILES;
		$cpt = count($_FILES['tbl_lampiran']['name']);
		for($i=0; $i<$cpt; $i++)
		{   
			$cpt2 = count($files['tbl_lampiran']['name'][$i]);
			for ($j=0; $j < $cpt2; $j++) { 
				$filename = $files['tbl_lampiran']['name'][$i][$j];
				if(!empty($filename)){
					$_FILES['tbl_lampiran']['name']= str_replace(' ', '_', $files['tbl_lampiran']['name'][$i][$j]);
					$_FILES['tbl_lampiran']['type']= $files['tbl_lampiran']['type'][$i][$j];
					$_FILES['tbl_lampiran']['tmp_name']= $files['tbl_lampiran']['tmp_name'][$i][$j];
					$_FILES['tbl_lampiran']['error']= $files['tbl_lampiran']['error'][$i][$j];
					$_FILES['tbl_lampiran']['size']= $files['tbl_lampiran']['size'][$i][$j];    

					$this->upload->initialize($this->set_upload_options());
					if ($this->upload->do_upload('tbl_lampiran')) {
		                $this->upload->data();
		            } else {
		                $errorinfo = $this->upload->display_errors();
						echo $errorinfo;exit();
		            }
		            $ext = pathinfo($filename, PATHINFO_EXTENSION);
		            $arr = array(
		            	'order_id'	=>	$id,
		            	'path'		=>	'assets/upload/CivilMaintenance/'.str_replace(' ', '_', $filename),
		            	'file_type'	=>	$files['tbl_lampiran']['type'][$i][$j],
		            	'pekerjaan' =>  $_POST['tbl_pekerjaan'][$i]
		            	);
		            $upload = $this->M_civil->insertAttachment($arr);
				}
	        }        
		}


		if (isset($redirek)) {
			redirect('civil-maintenance-order/order/view_order/'.$id);
		}
	}

	public function update_lampiran($id = '')
	{
		if(empty($id)){
			//ketika update lampiran saja
			$id = $this->input->post('id');
			$thread = array(
				'order_id'		=>	$id,
				'thread_detail'	=>	'Update Lampiran',
				'thread_date'	=>	date('Y-m-d H:i:s'),
				'thread_by'		=>	$this->session->user
				);
			$this->M_civil->saveThread($thread);
			$redirek = true;
		}
		$this->load->library('upload');
		$dataInfo = array();
		$files = $_FILES;
		$cpt = count($_FILES['lampiran']['name'])-1;
		echo $cpt;exit();
		for($i=0; $i<$cpt; $i++)
		{           
			$filename = $files['lampiran']['name'][$i];
			if(empty($filename)) continue;

			$_FILES['lampiran']['name']= str_replace(' ', '_', $files['lampiran']['name'][$i]);
			$_FILES['lampiran']['type']= $files['lampiran']['type'][$i];
			$_FILES['lampiran']['tmp_name']= $files['lampiran']['tmp_name'][$i];
			$_FILES['lampiran']['error']= $files['lampiran']['error'][$i];
			$_FILES['lampiran']['size']= $files['lampiran']['size'][$i];    

			$this->upload->initialize($this->set_upload_options());
			if ($this->upload->do_upload('lampiran')) {
                $this->upload->data();
            } else {
                $errorinfo = $this->upload->display_errors();
				echo $errorinfo;exit();
            }
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $arr = array(
            	'order_id'	=>	$id,
            	'path'	=>	'assets/upload/CivilMaintenance/'.str_replace(' ', '_', $filename),
            	'file_type'	=>	$files['lampiran']['type'][$i],
            	);
            $upload = $this->M_civil->insertAttachment($arr);
		}

		if (isset($redirek)) {
			redirect('civil-maintenance-order/order/view_order/'.$id);
		}
	}

	public function del_file()
	{
		$id = $this->input->post('id');
		$link = $this->M_civil->getAttachmentbyId($id)->row_array();
		unlink($link['path']);
		$del = $this->M_civil->delAttachment($id);

		$thread = array(
				'order_id'		=>	$link['order_id'],
				'thread_detail'	=>	'Delete File Attachment '.$id.' ('.$link['path'].')',
				'thread_date'	=>	date('Y-m-d H:i:s'),
				'thread_by'		=>	$this->session->user
				);
		$this->M_civil->saveThread($thread);

		return true;
	}

	public function del_order($id)
	{
		$del = $this->M_civil->delOrder($id);
		$thread = array(
				'order_id'		=>	$id,
				'thread_detail'	=>	'Delete Order',
				'thread_date'	=>	date('Y-m-d H:i:s'),
				'thread_by'		=>	$this->session->user
				);
		$this->M_civil->saveThread($thread);
		redirect('civil-maintenance-order/order/list_order');
	}

	public function view_order($id)
	{
		$user = $this->session->user;

		$data  = $this->general->loadHeaderandSidemenu('Civil Maintenance', 'View Order #'.$id, '', '', '');

		$data['order'] = $this->M_civil->getListOrderid($id)->row_array();
		$data['lampiran'] = $this->M_civil->getListlampiran($id);
		$data['status_order'] = $this->M_civil->listSto();
		$data['ket'] = $this->M_civil->getKetByid($id);
		$data['approve'] = $this->M_civil->getApproverbyId($id);
		$data['id'] = $id;
		$data['chat'] = $this->M_civil->getChatbyId($id);
		// echo "<pre>";
		// print_r($data['lapiran']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CivilMaintenanceOrder/Order/V_View_Order',$data);
		$this->load->view('V_Footer',$data);
	}

	public function download_file($attach_id)
	{
		// echo $attach_id;
		if (is_numeric($attach_id) === false) die('File Not Found :(');
		@$file_url = $this->M_civil->getAttachmentbyId($attach_id)->row()->path;
		$file = base_url().$file_url;
		// echo $file_url;exit();
		if(!file_exists(FCPATH.$file_url) || empty($file_url) || !$file_url) die('File Not Found :(');

		header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        ob_clean();
        flush();
        readfile($file);
        exit;
	}

	public function up_kolomOrder()
	{
		$id = $this->input->post('id');
		$val = $this->input->post('val');
		$kolom = $this->input->post('kolom');

		$thread = array(
				'order_id'		=>	$id,
				'thread_detail'	=>	'Update Status Order Menjadi '.$val,
				'thread_date'	=>	date('Y-m-d H:i:s'),
				'thread_by'		=>	$this->session->user
				);
		$this->M_civil->saveThread($thread);

		$arr = array(
			$kolom 	=> $val
			);
		$this->M_civil->updateOrder($arr, $id);
		echo json_encode('okey');
	}

	public function up_kolomApprover()
	{
		$id = $this->input->post('id');
		$val = $this->input->post('val');
		$kolom = $this->input->post('kolom');

		$thread = array(
				'order_id'		=>	$id,
				'thread_detail'	=>	'Update Order Approver kolom '.$kolom.' Menjadi '.$val,
				'thread_date'	=>	date('Y-m-d H:i:s'),
				'thread_by'		=>	$this->session->user
				);
		$this->M_civil->saveThread($thread);

		$arr = array(
			$kolom 	=> $val
			);
		$this->M_civil->upCOA($arr, $id);
		echo json_encode('okey');
	}

	public function del_kolomApprover()
	{
		$id = $this->input->post('id');

		$thread = array(
				'order_id'		=>	$id,
				'thread_detail'	=>	'Delete Order Approver '.$id,
				'thread_date'	=>	date('Y-m-d H:i:s'),
				'thread_by'		=>	$this->session->user
				);
		$this->M_civil->saveThread($thread);

		$this->M_civil->delCOA($id);
		echo json_encode('okey');
	}

	public function edit_approval($id)
	{
		$user = $this->session->user;

		$data  = $this->general->loadHeaderandSidemenu('Civil Maintenance', 'Edit Keterangan', '', '', '');

		$data['approve'] = $this->M_civil->getApproverbyId($id);
		$data['id'] = $id;
		// echo "<pre>";
		// print_r($data['lapiran']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CivilMaintenanceOrder/Order/V_Edit_Approval',$data);
		$this->load->view('V_Footer',$data);
	}

	public function add_approver()
	{
		$jns_appr = $this->input->post('tbl_japprove');
		$aprover = $this->input->post('tbl_approver');
		$stat = $this->input->post('tbl_status');
		$id = $this->input->post('id');
		for ($i=0; $i < count($aprover); $i++) { 
			$arr = array(
				'order_id'			=>	$id,
				'jenis_approver'	=>	$jns_appr[$i],
				'approver'			=>	$aprover[$i],
				'status_approval'	=>	0,
				);
			$this->M_civil->insCOA($arr);
		}
		$thread = array(
				'order_id'		=>	$id,
				'thread_detail'	=>	'Add Approver '.$id,
				'thread_date'	=>	date('Y-m-d H:i:s'),
				'thread_by'		=>	$this->session->user
				);
		$this->M_civil->saveThread($thread);
		redirect('civil-maintenance-order/order/edit_approval/'.$id);
	}

	public function edit_keterangan($id)
	{
		$user = $this->session->user;

		$data  = $this->general->loadHeaderandSidemenu('Civil Maintenance', 'Edit Keterangan', '', '', '');

		$data['ket'] = $this->M_civil->getKetByid($id);
		$data['lampiran'] = $this->M_civil->getListlampiran($id);
		$data['id'] = $id;
		// echo "<pre>";
		// print_r($data['lapiran']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CivilMaintenanceOrder/Order/V_Edit_Keterangan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function up_kolomKeterangan()
	{
		$id = $this->input->post('id');
		$val = $this->input->post('val');
		$kolom = $this->input->post('kolom');

		$thread = array(
				'order_id'		=>	$id,
				'thread_detail'	=>	'Update Order Keterangan kolom '.$kolom.' Menjadi '.$val,
				'thread_date'	=>	date('Y-m-d H:i:s'),
				'thread_by'		=>	$this->session->user
				);
		$this->M_civil->saveThread($thread);

		$arr = array(
			$kolom 	=> $val
			);
		$this->M_civil->upCVP($arr, $id);
		echo json_encode('okey');
	}

	public function del_kolomKeterangan()
	{
		$id = $this->input->post('id');

		$thread = array(
				'order_id'		=>	$id,
				'thread_detail'	=>	'Delete Order Keterangan '.$id,
				'thread_date'	=>	date('Y-m-d H:i:s'),
				'thread_by'		=>	$this->session->user
				);
		$this->M_civil->saveThread($thread);

		$this->M_civil->delCVP($id);
		echo json_encode('okey');
	}

	public function add_keterangan()
	{
		$pekerjaan = $this->input->post('tbl_pekerjaan');
		$qty = $this->input->post('tbl_qty');
		$satuan = $this->input->post('tbl_satuan');
		$keter = $this->input->post('tbl_ket');
		$id = $this->input->post('id');
		for ($i=0; $i < count($qty); $i++) { 
			$arr = array(
				'order_id'		=>	$id,
				'pekerjaan'		=>	$pekerjaan[$i],
				'qty'			=>	$qty[$i],
				'satuan'		=>	$satuan[$i],
				'keterangan'	=>	$keter[$i],
				);
			$this->M_civil->insCVP($arr);
		}

		$this->insert_lampiran($id);

		$thread = array(
				'order_id'		=>	$id,
				'thread_detail'	=>	'Add Keterangan '.$id,
				'thread_date'	=>	date('Y-m-d H:i:s'),
				'thread_by'		=>	$this->session->user
				);
		$this->M_civil->saveThread($thread);
		redirect('civil-maintenance-order/order/edit_keterangan/'.$id);
	}

	public function add_lampiran_pekerjaan(){
		$id = $this->input->post('id_order');
		$pekerjaan = $this->input->post('pekerjaan');
		
		$this->load->library('upload');
		$dataInfo = array();
		$files = $_FILES;
		$cpt = count($_FILES['tbl_lampiran']['name']);
		// echo $cpt;exit();
		for($i=0; $i<$cpt; $i++)
		{   
			$cpt2 = count($_FILES['tbl_lampiran']['name'][$i]);
			for ($j=0; $j < $cpt2; $j++) { 
				$filename = $files['tbl_lampiran']['name'][$i][$j];
				if(empty($filename)) continue;

				$_FILES['tbl_lampiran']['name']= str_replace(' ', '_', $files['tbl_lampiran']['name'][$i][$j]);
				$_FILES['tbl_lampiran']['type']= $files['tbl_lampiran']['type'][$i][$j];
				$_FILES['tbl_lampiran']['tmp_name']= $files['tbl_lampiran']['tmp_name'][$i][$j];
				$_FILES['tbl_lampiran']['error']= $files['tbl_lampiran']['error'][$i][$j];
				$_FILES['tbl_lampiran']['size']= $files['tbl_lampiran']['size'][$i][$j];    

				$this->upload->initialize($this->set_upload_options());
				if ($this->upload->do_upload('tbl_lampiran')) {
	                $this->upload->data();
	            } else {
	                $errorinfo = $this->upload->display_errors();
					echo $errorinfo;exit();
	            }
	            $ext = pathinfo($filename, PATHINFO_EXTENSION);
	            $arr = array(
	            	'order_id'	=>	$id,
	            	'path'		=>	'assets/upload/CivilMaintenance/'.str_replace(' ', '_', $filename),
	            	'file_type'	=>	$files['tbl_lampiran']['type'][$i][$j],
	            	'pekerjaan' =>  $pekerjaan
	            	);
	            $upload = $this->M_civil->insertAttachment($arr);
				
	        }        
		}

		$thread = array(
				'order_id'		=>	$id,
				'thread_detail'	=>	'Add Lampiran Keterangan '.$id,
				'thread_date'	=>	date('Y-m-d H:i:s'),
				'thread_by'		=>	$this->session->user
				);
		$this->M_civil->saveThread($thread);
		redirect('civil-maintenance-order/order/edit_keterangan/'.$id);
	}

	public function upload_imageChat()
	{
		$config = array('upload_path' => './assets/upload/CivilMaintenance/Thread/',
			'upload_url' => base_url()  . './assets/upload/CivilMaintenance/Thread/',
			'allowed_types' => 'jpg|gif|png',
			'overwrite' => false,
			);

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if ($this->upload->do_upload('file')) {
			$data = $this->upload->data();
			$array = array(
				'filelink' => $config['upload_url'] . $data['file_name']
				);
			echo stripslashes(json_encode($array));
		} else {
			echo json_encode(array('error' => $this->upload->display_errors('', '')));
		}
	}

	public function post_chat()
	{
		$body = $this->input->post('txtIsi');
		$id = $this->input->post('id');
		$user = $this->session->user;

		$arr = array(
			'post_body'	=>	$body,
			'post_by'	=>	$user,
			'post_date'	=>	date('Y-m-d H:i:s'),
			'order_id'	=>	$id
			);
		$this->M_civil->insPost($arr);
		redirect('civil-maintenance-order/order/view_order/'.$id);
	}

	public function cetak_order($id)
	{
		$data['order'] = $this->M_civil->getListOrderid($id)->row_array();
		$data['lampiran'] = $this->M_civil->getListlampiran($id);
		$data['status_order'] = $this->M_civil->listSto();
		$data['ket'] = $this->M_civil->getKetByid($id);
		$data['approve'] = $this->M_civil->getApproverbyId($id);
		$data['id'] = $id;
		$data['chat'] = $this->M_civil->getChatbyId($id);
		$isi = $this->load->view('CivilMaintenanceOrder/Order/V_Cetak_Order', $data, true);

		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216,330), 11, "timesnewroman", 10, 10, 10, 30, 0, 0, 'P');
		$filename	=	'E-Order - Civil Maintenance.pdf';

		$pdf->AddPage();
		$pdf->SetTitle('E-Order - Civil Maintenance');
		$pdf->WriteHTML($isi);

		$pdf->Output($filename, 'I');
	}

	public function setApproveOrder()
	{
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$arr = array(
			'status_approval'	=>	$status
			);

		$this->M_civil->upCOA($arr, $id);
	}
}