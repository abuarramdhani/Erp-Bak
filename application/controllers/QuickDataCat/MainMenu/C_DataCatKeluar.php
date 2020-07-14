<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_DataCatKeluar extends CI_Controller {
	function __construct()
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
		$this->load->model('QuickDataCat/MainMenu/M_datacatkeluar');
		$this->load->model('QuickDataCat/MainMenu/M_inputdatacatkeluar');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}
	
	public function Index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['action'] = 'QuickDataCat/DataCatKeluar/TambahDataCatKeluar';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		
		$data['data_cat_keluar'] = $this->M_datacatkeluar->getDataCatKeluar($data);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('QuickDataCat/MainMenu/V_InputDataCatKeluar', $data);
		$this->load->view('V_Footer',$data);
		$this->session->unset_userdata('success_insert');
	}
	
	public function getKodeCatKeluar()
	{	 
		$id = strtoupper($this->input->get('term'));
		$data = $this->M_inputdatacatkeluar->getKodeCatKeluarSelect2($id);
		echo json_encode($data);
	}

	public function tableSearch()
	{
		$kode_cat = $this->input->get('kode_cat');
		//$data['Customer'] = $this->M_customer->getFilteredCustomer($nama,$village,$city,$category);
		$data['DataExpDate'] = $this->M_inputdatacatkeluar->getExpiredDate($kode_cat);
		$this->load->view('QuickDataCat/Additional/V_tablesearch',$data);
	
	}
	
	public function getDescriptionKeluar()
	{
		$kode_cat = $this->input->post('id');
		$data = $this->M_inputdatacatkeluar->getDescriptionKeluar($kode_cat);
		if(empty($data)){
			echo "";
		}else{
		foreach($data as $data_item){
			$description=$data_item['paint_description'];
			
		}
		echo $description;
		}
	}
	
	public function getExpiredDateKeluar()
	{
		$kode_cat = $this->input->post('id');
		$data = $this->M_inputdatacatkeluar->getDescriptionKeluar($kode_cat);
		if(empty($data)){
			echo "";
		}else{
		foreach($data as $data_item){
			$description=$data_item['expired_date'];
			echo json_encode($description);
		}

		}
	}
	
	public function getQuantityKeluar()
	{
		$kode_cat = $this->input->post('id');
		$data = $this->M_inputdatacatkeluar->getDescriptionKeluar($kode_cat);
		if(empty($data)){
			echo "";
		}else{
		foreach($data as $data_item){
			$description=$data_item['quantity'];
			echo $description;
		}
		
		}
	}
	
	public function getBuktiKeluar()
	{
		$kode_cat = $this->input->post('id');
		$data = $this->M_inputdatacatkeluar->getBuktiKeluar($kode_cat);
		if(empty($data)){
			echo "";
		}else{
		foreach($data as $data_item){
			$bukti=$data_item['evidence_number'];
		}
		echo $bukti;
		}
	}
	
	public function getPetugasKeluar()
	{
		$kode_cat = $this->input->post('id');
		$data = $this->M_inputdatacatkeluar->getPetugasKeluar($kode_cat);
		if(empty($data)){
			echo "";
		}else{
		foreach($data as $data_item){
			$petugas=$data_item['employee'];
		}
		echo $petugas;
		}
	}
	
	public function TambahDataCatKeluar()
	{
		$tglexpired                 = $this->input->post('txtExpiredDate');
		$quantity                   = $this->input->post('txtQuantity');
		$onhand 				    = $this->input->post('txtOnHand');
		$kode_cat					= $this->input->post('slcKodeCat');
		$cat 						= $this->input->post('txtDescription');
        $bukti				 		= $this->input->post('txtBukti');
        $petugas					= strtoupper($this->input->post('txtPetugas'));
		$row = sizeof($tglexpired);
		for($i=0;$i<$row;$i++){
			if ($quantity[$i]==""  ){
									empty($data);
						}
			elseif ($quantity[$i]<=$onhand[$i]) {
				$data = array (
				'paint_code'		=> $kode_cat,
				'paint_description'	=> $cat,
				'expired_date'	    => $tglexpired[$i],
				'quantity'	        => $quantity[$i],
				'on_hand'			=> $onhand[$i],
				'evidence_number'	=> $bukti,
				'employee'	 		=> $petugas,
				'sysdate'			=> "now()"
			);
			$expired = $tglexpired[$i];
			$quant 	 = $quantity[$i];
			$this->M_inputdatacatkeluar->TambahDataCatKeluar($data);
			$this->M_inputdatacatkeluar->KurangOnHAnd($kode_cat,$quant,$expired);
				 }
			elseif ($quantity[$i]>$onhand[$i]) {
				$error = '<div id="eror" class="alert alert-dismissible" role="alert" style="background-color:#963030; text-align:center; color:white; width: 290px; "><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>username/Password salah!</div>';
                redirect('C_InputDataCatKeluar',$error);
			}
			$this->M_inputdatacatkeluar->HapusDataCatKeluar($data,$kode_cat);
					//	elseif ($quantity[$i]>$onhand[$i])
		}
			$this->session->set_flashdata('message', 'Create Record Success');
			$ses=array(
						 "success_insert" => 1
					);
			$this->session->set_userdata($ses);
			redirect('QuickDataCat/C_InputDataCatKeluar'); 
}
	
}