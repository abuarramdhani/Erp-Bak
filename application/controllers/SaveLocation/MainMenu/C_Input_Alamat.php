<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Input_Alamat extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('date');
			   $this->load->library('session');
	   $this->load->helper('url');
		$this->load->model('lokasi-simpan/M_Input_Alamat');
			if ($this->session->userdata('logged') != TRUE) 
			{
				redirect(base_url('login'));
			}

	}

	public function getSubinventori()
	{
		// $id = strtoupper($this->input->get('term'));
		$org_id =$this->input->post('org_id');
		$data = $this->M_Input_Alamat->getSubinventori($org_id);
		echo '
			<option value="muach" disabled selected>-- Choose One --</option>
		';
		foreach ($data as $d) {
			echo '<option value="'.$d['SECONDARY_INVENTORY_NAME'].'">'.$d['SECONDARY_INVENTORY_NAME'].'</option>';
		}
	}

	public function getItem()
	{
		$assy 	=$this->input->post('assy');
		$org_id	= $this->input->post('org_id');
		if ($assy == '') {
			$sub_inv 	= $this->input->post('sub_inv');
			$data 		= $this->M_Input_Alamat->getKomponenKode($org_id,$sub_inv);
			echo '
				<option value="muach" disabled selected>-- Choose One --</option>
			';
			foreach ($data as $d) {
				echo '<option value="'.$d['SEGMENT1'].'" data-desc="'.$d['DESCRIPTION'].'">'.$d['SEGMENT1'].' | '.$d['DESCRIPTION'].'</option>';
			}
		}else{
			$id = strtoupper($this->input->get('term'));
			$data = $this->M_Input_Alamat->getItem($id,$org_id,$assy);
			echo json_encode($data);
		}
		// $org =$this->input->get('org');
	}


	public function getAssy()
	{
		$id = strtoupper($this->input->get('term'));
		$org =$this->input->get('org');
		$item =$this->input->get('item');
		$data = $this->M_Input_Alamat->getAssy($id,$org,$item);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();
		echo json_encode($data);
	}

	public function getDescriptionItem()
	{
		$kode_item = $this->input->post('id');
		$data = $this->M_Input_Alamat->getDescriptionItem($kode_item);
		if (empty($data)){
			echo "";
		}
		else {
			foreach ($data as $dataitem) {
				$description = $dataitem['DESCRIPTION'];
			}
			echo $description;
		}

	}

	public function getDescriptionAssy()
	{
		$kode_assy = $this->input->post('id');
		$data = $this->M_Input_Alamat->getDescriptionAssy($kode_assy);
		if (empty($data)){
			echo "";
		}
		else {
			foreach ($data as $dataitem) {
				$description = $dataitem['DESCRIPTION'];
			}
			echo $description;
		}

	}
	public function getTypeAssy()
	{
		$kode_assy = $this->input->post('id');
		$data = $this->M_Input_Alamat->getTypeAssy($kode_assy);
		if (empty($data)){
			echo "";
		}
		else {
			foreach ($data as $dataitem) {
				$type = $dataitem['SEGMENT2'];
			}
			echo $type;
		}

	}

	public function SaveInput()
	{
		$user = $this->session->userdata('username');
		$org_id = $this->input->post('txtOrg');
		$sub_inv = $this->input->post('SlcSubInventori');
		$kode_assy = $this->input->post('SlcKodeAssy');
		$type_assy = $this->input->post('txtTypeAssy');
		$kode_item_save = $this->input->post('SlcItem');
		$locator = $this->input->post('txtLocator');
		$alamat_simpan_save = $this->input->post('txtAlamat');
		$lppbmokib_save = $this->input->post('txtLmk');
		$picklist_save = $this->input->post('txtPicklist');
		if ($lppbmokib_save == null) {$lppbmokib_save ="0";}
		if ($picklist_save  == null) {$picklist_save  ="0";}

	 	$sql1 ="select user_id from FND_USER where user_name ='$user'";
	    $query1= $this->db->query($sql1);
	    $username = $query1->result_array();
	    $user_name = $username[0]['USER_ID'];

		$checkData = $this->M_Input_Alamat->CekData2($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item_save,$locator);
		if ($checkData>0) {
			$this->M_Input_Alamat->UpdateData2($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item_save,$locator,$alamat_simpan_save,$lppbmokib_save,$picklist_save,$user_name);
		}
		else{
			$this->M_Input_Alamat->insertData2($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item_save,$locator,$alamat_simpan_save,$lppbmokib_save,$picklist_save,$user_name);
		}
		 $message = '<div class="row"> <div class="col-md-6 col-md-offset-3 " style="margin-top: 20px">
                           <div id="eror" class="alert alert-dismissible " role="alert" style="background-color:#22ad54; text-align:center; color:white; "><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Input Success.</div>  </div>
                      </div>';
         $this->input_comp($message);

	}

	public function SaveInputAssy()
	{	
		$user = $this->session->userdata('username');
		$org_id = $this->input->post('txtOrg');
		$sub_inv = $this->input->post('SlcSubInventori2');
		$kode_assy = $this->input->post('SlcKodeAssy2');
		$type_assy = $this->input->post('txtTypeAssy2');
		$kode_item = $this->input->post('SlcItem2[]');
		$locator = $this->input->post('txtLocator2');
		$alamat_simpan = $this->input->post('txtAlamat2[]');
		$lppbmokib = $this->input->post('txtLmk2[]');
		$picklist = $this->input->post('txtPicklist2[]');
		$sql1 ="select user_id from FND_USER where user_name ='$user'";
	    $query1= $this->db->query($sql1);
	    $username = $query1->result_array();
	    $user_name = $username[0]['USER_ID'];

		$i=0;
		foreach($kode_item as $loop){
			$kode_item_save		= $kode_item[$i];
			$alamat_simpan_save 	= $alamat_simpan[$i];	
			$lppbmokib_save 		= $lppbmokib[$i];
			$picklist_save 		= $picklist[$i];

			$checkData = $this->M_Input_Alamat->CekData2($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item_save,$locator);
			if ($checkData>0) {
				$this->M_Input_Alamat->UpdateData2($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item_save,$locator,$alamat_simpan_save,$lppbmokib_save,$picklist_save,$user_name);
			}
			else{
				$this->M_Input_Alamat->insertData2($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item_save,$locator,$alamat_simpan_save,$lppbmokib_save,$picklist_save,$user_name);
			}

			$i++;
		}

			 $message = '<div class="row"> <div class="col-md-6 col-md-offset-3 " style="margin-top: 20px">
	                           <div id="eror" class="alert alert-dismissible " role="alert" style="background-color:#22ad54; text-align:center; color:white; "><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Input Success.</div>  </div>
	                      </div>';
	         $this->input_assy($message);
		
	}

	

}
