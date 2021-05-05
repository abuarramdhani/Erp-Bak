<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RequestKadep extends CI_Controller
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
		$this->load->model('MiscellaneousMng/M_request');
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

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Request Miscellaneous';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['view'] = 'Kadep';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_Request', $data);
		$this->load->view('V_Footer',$data);
    }

	public function DetailMiscellaneous($no){
		$user = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Request Miscellaneous';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$id_head			= $this->input->post('idheader'.$no.'');
		$data['id_header']	= $id_head;
		$data['no_dokumen'] = $this->input->post('nodoc'.$no.'');
		$data['io'] 		= $this->input->post('io'.$no.'');
		$data['tgl'] 		= $this->input->post('tgl_transact'.$no.'');
		$data['status'] 	= $this->input->post('status'.$no.'');
		$data['requester'] 	= $this->input->post('pic'.$no.'');
		$nama_pic			= $this->M_request->getUser($data['requester']);
		$data['nama_req'] 	= $nama_pic[0]['nama'];
		$data['ket']		= $no;
		$getdata = $this->M_request->cekitemrequest("where id_header = $id_head order by id_item asc");
		foreach ($getdata as $key => $val) {
			$getdata[$key]['status'] = $this->getStatus2($val['id_item']); //cari status approve/reject per item
		}
		$data['data'] = $getdata;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_DetailKadep', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function getStatus2($id){
		$reject = '';
		$cari = $this->M_request->cariReject($id);
		// echo "<pre>";print_r($cari);exit();
		if ($cari[0]['pic'] != '') {
			$reject = 'Reject|'.$cari[0]['note'];
		}
		return $reject;
	}


	public function submitKadep(){
		$id_header 	= $this->input->post('id_header');
		$id_item 	= $this->input->post('id_item[]');
		$revqty 	= $this->input->post('revqty[]');
		$action 	= $this->input->post('action[]');
		$note 		= $this->input->post('note[]');
		$ket 		= $this->input->post('ket');
		$pic 		= $this->session->user;
		$tgl 		= date('Y-m-d H:i:s');
		for ($i=0; $i < count($id_item); $i++) { 
			$cek = $this->M_request->getdataKadep('where id_item = '.$id_item[$i].'');
			if (empty($cek)) {
				$act = empty($action[$i]) ? 'Approve' : $action[$i];
				$qty = empty($revqty[$i]) ? 'null' : $revqty[$i];
				$this->M_request->saveKadep($id_item[$i], $qty, $act, $note[$i], $pic, $tgl);
			}
		}
		$this->M_request->updateHeader('Proses Approve Ka. Seksi Akt Biaya', $id_header);
		if ($ket == 'approvemanualCosting') { 
			// approve manual digunakan untuk menggantikan approve kadep, jika kadep tidak bisa approve -> approve lewat misc costing
			redirect(base_url("MiscellaneousCosting/Request"));
		}else {
			redirect(base_url("MiscellaneousKadep/Request"));
		}
	}
}