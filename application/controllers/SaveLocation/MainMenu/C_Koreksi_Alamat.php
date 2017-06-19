<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Koreksi_Alamat extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('date');
		$this->load->library('session');
	    $this->load->helper('url');
		$this->load->model('lokasi-simpan/M_Koreksi_Alamat');
			if ($this->session->userdata('logged') != TRUE) 
			{
				redirect(base_url('login'));
			}

	}

	public function locator_val()
	{
		$sub_inv = $this->input->post('sub_inv');
		$loc = $this->M_Koreksi_Alamat->locator_val($sub_inv);
		echo '<option></option>';
		foreach ($loc as $location ) {
			echo '<option value="'.$location['SEGMENT1'].'" >'.$location['SEGMENT1'].'</option>';
		}
	}

	public function searchcomponent()
	{
		$org_id = $this->input->get('org');
		$sub_inv = $this->input->get('sub_inv');
		$item = $this->input->get('item');
		$locator = $this->input->get('locator');
		
		$data['Component'] = $this->M_Koreksi_Alamat->getSearchComponent($org_id,$sub_inv,$item,$locator);
		$this->load->view('lokasi-simpan/lokasi-simpan/V_tablesearchcomponent',$data);
	}

	public function searchAssy()
	{
		$org_id = $this->input->get('org');
		$sub_inv = $this->input->get('sub_inv');
		$kode_assy = $this->input->get('kode_assy');
		$data['Assy'] = $this->M_Koreksi_Alamat->getSearchAssy($org_id,$sub_inv,$kode_assy);
		$this->load->view('lokasi-simpan/lokasi-simpan/V_tablesearchassy',$data);
	}

	public function save_alamat()
	{
		$user = $this->session->userdata('username');
		$alamat	= $this->input->post('alamat');
		$item	= $this->input->post('item');
		$kode_assy	= $this->input->post('kode_assy');
		$type_assy	= $this->input->post('type_assy');
		$sub_inv	= $this->input->post('sub_inv');

		$this->M_Koreksi_Alamat->save_alamat($user, $alamat, $item, $kode_assy, $type_assy, $sub_inv);
	}

	public function save_lmk()
	{
		$user = $this->session->userdata('username');
		$item	= $this->input->post('item');
		$kode_assy	= $this->input->post('kode_assy');
		$type_assy	= $this->input->post('type_assy');
		$sub_inv	= $this->input->post('sub_inv');
		$lmk	= $this->input->post('lmk');

		$this->M_Koreksi_Alamat->save_lmk($user, $lmk,$item , $kode_assy, $type_assy, $sub_inv);
	}

	public function save_picklist()
	{
		$user = $this->session->userdata('username');
		$item	= $this->input->post('item');
		$kode_assy	= $this->input->post('kode_assy');
		$type_assy	= $this->input->post('type_assy');
		$sub_inv	= $this->input->post('sub_inv');
		$picklist	= $this->input->post('picklist');

		$this->M_Koreksi_Alamat->save_picklist($user, $picklist,$item, $kode_assy, $type_assy, $sub_inv);
	}



}