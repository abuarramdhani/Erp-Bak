<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RequestAkt extends CI_Controller
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
        
        $data['view'] = 'Akuntansi';

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
		$branch 			= $this->M_request->getBranchIO($data['io']); // cari branch berdasarkan io -> untuk COA
		$data['branch'] 	= !empty($branch) ? $branch[0]['BRANCH'] : '';
		$data['tgl'] 		= $this->input->post('tgl_transact'.$no.'');
		$data['status'] 	= $this->input->post('status'.$no.'');
		$data['requester'] 	= $this->input->post('pic'.$no.'');
		$nama_pic			= $this->M_request->getUser($data['requester']);
		$data['nama_req'] 	= $nama_pic[0]['nama'];
		$data['ket']		= $no;
		$getdata = $this->M_request->cekitemrequest("where id_header = $id_head order by id_item asc");
		foreach ($getdata as $key => $val) {
			$status = $this->getStatus2($val['id_item']); //status approve/reject per item
			$getdata[$key]['status'] = $status;
			if ($status == '') {// tidak reject
				$getdata[$key]['coaa'] 	= $this->buatCOAyuk($val['kode_item'], $val['cost_center']);
			}
		}
		$data['data'] = $getdata;
		// echo "<pre>";print_r($getdata);
		// exit();
		
		$data['linkket'] = 'MiscellaneousAkt/Request/submitAkt';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_DetailCosting', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function buatCOAyuk($item, $cost){
		//urutan COA
		//company(1) - branch - account(isi manual) - cost center - product - region(000) - future(000)
		$kode = substr($item,0,3);
		if ($kode == 'AAA' || $kode == 'AAB' || $kode == 'AAC' || $kode == 'AGC' || $kode == 'ADA' || $kode == 'AFA') {
			$kode = $kode;
		}else {
			$kode = '000';
		}
		$coa = '-'.$cost.'-'.$kode.'-000-000';
		return $coa;
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
	
	public function submitAkt(){
		$id_header 	= $this->input->post('id_header');
		$id_item 	= $this->input->post('id_item[]');
		$action 	= $this->input->post('action[]');
		$note 		= $this->input->post('note[]');
		$pic 		= $this->session->user;
		$tgl 		= date('Y-m-d H:i:s');

		for ($i=0; $i < count($id_item); $i++) { 
			$cek = $this->M_request->getdataAkt('where id_item = '.$id_item[$i].'');
			if (empty($cek)) {
				$act = empty($action[$i]) ? 'Approve' : $action[$i];
				$this->M_request->saveAkt($id_item[$i], $act, $note[$i], $pic, $tgl);
			}
		}
		$this->M_request->updateHeader('Siap Input Ka. Seksi Akt Biaya', $id_header);

		redirect(base_url("MiscellaneousAkt/Request"));
	}

}