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
		$this->load->model('StorageLocation/MainMenu/M_ajax');
		$this->load->model('StorageLocation/MainMenu/M_monitoring');
	}

	public function GetSubinventori()
	{
		$org_id = $this->input->post('org_id');
		$data 	= $this->M_monitoring->getSubinventori($org_id);
		echo '<option value="muach" disabled selected>-- Choose One --</option>';
		foreach ($data as $d) {
			echo '<option value="'.$d['SECONDARY_INVENTORY_NAME'].'">'.$d['SECONDARY_INVENTORY_NAME'].'</option>';
		}
	}

	public function locator()
	{
		$sub_inv 	= $this->input->post('sub_inv');
		$loc 		= $this->M_monitoring->locator($sub_inv);
		if ($loc == NULL) {
			echo 0;
		}else{
			echo '<option value="muach" disabled selected>-- Choose One --</option>';
			foreach ($loc as $location ) {
				echo '<option value="'.$location['SEGMENT1'].'" >'.$location['SEGMENT1'].'</option>';
			}
		}
	}

	public function getComponentCode()
	{
		$term	= strtoupper($this->input->post('term'));
		$org_id	= $this->input->post('org_id');
		$as 	= $this->input->post('assy');
		if (!empty($as)) {
			$a = explode('|', $as);
			$assy = $a[0];
			$data 	= $this->M_ajax->getCompCodeByAssy($term,$org_id,$assy);
		}else{
			$data 	= $this->M_ajax->getComponentCode($term,$org_id);
		}
		echo json_encode($data);
	}


	public function GetAssy()
	{
		$org_id	= $this->input->post('org_id');
		$item 	= $this->input->post('item');
		if ($item == '' || $item == NULL) {
			$term 	= strtoupper($this->input->post('term'));
			$data 	= $this->M_ajax->getRemoteAssy($org_id,$term);
			echo json_encode($data);
		}else{
			$data 	= $this->M_ajax->getAssy($org_id,$item);
			echo '
				<option value="muach" disabled selected>-- Choose One --</option>
			';
			foreach ($data as $d) {
				echo '<option value="'.$d['SEGMENT1'].'" data-desc="'.$d['DESCRIPTION'].'" data-type="'.$d['ASSTYPE'].'">'.$d['SEGMENT1'].' | '.$d['DESCRIPTION'].'</option>';
			}
		}
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
