<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_DataCatMasuk extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('QuickDataCat/MainMenu/M_datacatmasuk');
		$this->load->model('QuickDataCat/MainMenu/M_inputdatacatmasuk');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->checkSession();
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	public function index()
	{
		
		$user_id = $this->session->userid;
		// echo $user_id;
		// exit();
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['action'] = 'QuickDataCat/DataCatMasuk/insert_act';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['data_cat_masuk'] = $this->M_datacatmasuk->getDataCatMasuk($data);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('QuickDataCat/MainMenu/V_InputDataCatMasuk', $data);
		$this->load->view('V_Footer',$data);
		$this->session->unset_userdata('success_insert');
	}
	
	public function insert_act(){
		
		$user_id = $this->session->userid;
				
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$kode_cat				= $this->input->post('slcKodeCat');
		$cat					= $this->input->post('txtDescription');
		$tglexpired             = $this->input->post('txtExpiredDate');
		$quantity               = $this->input->post('txtQuantity');
        $bukti					= $this->input->post('txtBukti');
        $petugas				= strtoupper($this->input->post('txtPetugas'));
		
		$i=0;
		foreach($tglexpired as $loop){
			$data = array (
				'paint_code'		=> $kode_cat,
				'paint_description'	=> $cat,
				'expired_date'	    => $tglexpired[$i],
				'quantity'	        => $quantity[$i],
				'evidence_number'	=> $bukti,
				'employee'	 		=> $petugas,
				'sysdate'			=> "now()"
			);
			$this->M_inputdatacatmasuk->TambahDataCatMasuk($data);
			$expired = $tglexpired[$i];
			$quant   = $quantity[$i];
			$checkcode = $this->M_inputdatacatmasuk->cekKodeExpCat($kode_cat,$expired);
			if ($checkcode>0) {
				$this->M_inputdatacatmasuk->updateOnHand($kode_cat,$expired,$quant);	
			}
			else {
				$this->M_inputdatacatmasuk->insertOnHand($kode_cat,$expired,$quant,$cat);
			}

			$i++;
		}
		$this->session->set_flashdata('message', 'Create Record Success');
		$ses=array(
					 "success_insert" => 1
				);
		$this->session->set_userdata($ses);
		redirect('QuickDataCat/DataCatMasuk');
	}
	
	public function getKodeCatMasuk(){	 
		$id = strtoupper($this->input->get('term'));
		$data = $this->M_inputdatacatmasuk->getKodeCatMasukSelect2($id);
		echo json_encode($data);
	}

	public function getDescriptionMasuk(){
		$kode_cat = $this->input->post('id');
		$data = $this->M_inputdatacatmasuk->getDescriptionMasuk($kode_cat);
		if(empty($data)){
			echo "";
		}else{
		foreach($data as $data_item){
			$description=$data_item['DESCRIPTION'];
		}
		echo $description;
		}
	}
	
		public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}
}
