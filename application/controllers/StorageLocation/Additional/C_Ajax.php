<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Ajax extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('StorageLocation/MainMenu/M_Ajax');
		$this->load->model('StorageLocation/MainMenu/M_Monitoring');
	}

	public function GetSubinventori()
	{
		$org_id = $this->input->post('org_id');
		$data 	= $this->M_Monitoring->getSubinventori($org_id);
		echo '<option value="muach" disabled selected>-- Choose One --</option>';
		foreach ($data as $d) {
			echo '<option value="'.$d['SECONDARY_INVENTORY_NAME'].'">'.$d['SECONDARY_INVENTORY_NAME'].'</option>';
		}
	}

	public function locator()
	{
		$sub_inv 	= $this->input->post('sub_inv');
		$loc 		= $this->M_Monitoring->locator($sub_inv);
		echo '<option value="muach" disabled selected>-- Choose One --</option>';
		foreach ($loc as $location ) {
			echo '<option value="'.$location['SEGMENT1'].'" >'.$location['SEGMENT1'].'</option>';
		}
	}

	public function getComponentCode()
	{
		$assy 	=$this->input->post('assy');
		$org_id	= $this->input->post('org_id');
		if ($assy == '') {
			$sub_inv 	= $this->input->post('sub_inv');
			$data 		= $this->M_Ajax->getComponentCode($org_id,$sub_inv);
			echo '
				<option value="muach" disabled selected>-- Choose One --</option>
			';
			foreach ($data as $d) {
				echo '<option value="'.$d['SEGMENT1'].'" data-desc="'.$d['DESCRIPTION'].'">'.$d['SEGMENT1'].' | '.$d['DESCRIPTION'].'</option>';
			}
		}else{
			$id = strtoupper($this->input->get('term'));
			$data = $this->M_Ajax->getItem($id,$org_id,$assy);
			echo json_encode($data);
		}
	}


	public function getAssy()
	{
		$id = strtoupper($this->input->get('term'));
		$org =$this->input->get('org');
		$item =$this->input->get('item');
		$data = $this->M_Input_Alamat->getAssy($id,$org,$item);
		echo json_encode($data);
	}

	public function getDescriptionItem()
	{
		$kode_item = $this->input->post('id');
		$data = $this->M_Input_Alamat->getDescriptionItem($kode_item);
		if (empty($data)){
			echo "";
		}else {
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
		}else {
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
}
