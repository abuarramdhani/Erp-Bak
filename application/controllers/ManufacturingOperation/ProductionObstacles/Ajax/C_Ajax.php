<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Ajax extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('ManufacturingOperation/ProductionObstacles/M_ajax');
	}

	public function hapus()
	{
		$id = $this->input->post('id');
		$data = $this->M_ajax->delete($id);
		echo json_encode($data);
	}

	public function hapusCabang()
	{
		$id = $this->input->post('id');
		$data = $this->M_ajax->deleteCabang($id);
		echo json_encode($data);
	}

	public function UpdateInduk()
	{
		$id = $this->input->post('id');
		$val = $this->input->post('val');
		$type = $this->input->post('type');
		$data = $this->M_ajax->UpdateInduk($id,$val);

		// echo json_encode($data);
	}

	public function UpdateCabang()
	{
		$id = $this->input->post('id');
		$val = $this->input->post('val');
		$data = $this->M_ajax->UpdateCabang($id,$val);
		echo json_encode($data);
	}
}