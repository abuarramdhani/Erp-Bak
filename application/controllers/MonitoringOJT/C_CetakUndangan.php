<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_CetakUndangan extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('General');
		$this->load->library('MonitoringOJT');		

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringOJT/M_cetakundangan');

		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index()
	{

		$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Cetak Undangan', 'Cetak', 'Undangan');

		$data['daftar_cetak_undangan']		=	$this->M_cetakundangan->undangan_cetak();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/V_CetakUndangan_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$this->form_validation->set_rules('txtJenisUndangan', 'Jenis Undangan', 'required');
		$this->form_validation->set_rules('txaFormatUndangan', 'Format Undangan', 'required');

		if($this->form_validation->run() === FALSE)
		{
			$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Master Undangan', 'Setup', 'Undangan');

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringOJT/V_MasterUndangan_Create',$data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$user 						=	$this->session->user;
			$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

			$jenis_undangan 		=	strtoupper($this->input->post('txtJenisUndangan', TRUE));
			$format_undangan 		=	$this->input->post('txaFormatUndangan');


			$create_undangan 		=	array
										(
											'judul'				=>	$jenis_undangan,
											'undangan'			=>	$format_undangan,
											'create_timestamp'	=>	$execution_timestamp,
											'create_user'		=>	$user,
										);
			$id_undangan 		=	$this->M_cetakundangan->create($create_undangan);

			$this->monitoringojt->ojt_history('ojt', 'tb_master_undangan', array('id_undangan =' => $id_undangan), 'CREATE');
			redirect('OnJobTraining/MasterUndangan');
		}
	}

	public function read($id_undangan)
	{
		$id_undangan_decode = $this->general->dekripsi($id_undangan);

		$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Master Undangan', 'Setup', 'Undangan');

		$data['daftar_format_undangan']		=	$this->M_cetakundangan->undangan($id_undangan_decode);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/V_MasterUndangan_Read',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update($id_undangan)
	{
		$this->form_validation->set_rules('txtJenisUndangan', 'Jenis Undangan', 'required');
		$this->form_validation->set_rules('txaFormatUndangan', 'Format Undangan', 'required');

		$id_undangan_decode = $this->general->dekripsi($id_undangan);

		if($this->form_validation->run() === FALSE)
		{
			$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Master Undangan', 'Setup', 'Undangan');

			$data['daftar_format_undangan']		=	$this->M_cetakundangan->undangan($id_undangan_decode);
			$data['id']							=	$id_undangan;

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringOJT/V_MasterUndangan_Update',$data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$user 						=	$this->session->user;
			$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

			$jenis_undangan 		=	strtoupper($this->input->post('txtJenisUndangan', TRUE));
			$format_undangan 		=	$this->input->post('txaFormatUndangan');

			$update_undangan 		=	array
										(
											'judul'					=>	$jenis_undangan,
											'undangan'					=>	$format_undangan,
											'last_update_timestamp'	=>	$execution_timestamp,
											'last_update_user'		=>	$user,
										);

			$this->M_cetakundangan->update($update_undangan, $id_undangan_decode);

			$this->monitoringojt->ojt_history('ojt', 'tb_master_undangan', array('id_undangan =' => $id_undangan_decode), 'UPDATE');
			redirect('OnJobTraining/MasterUndangan');
		}
	}

	public function delete($id_undangan)
	{
		$id_undangan_decode = $this->general->dekripsi($id_undangan);

		$user 						=	$this->session->user;
		$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

		$this->M_cetakundangan->delete($id_undangan_decode);

		$this->monitoringojt->ojt_history('ojt', 'tb_master_undangan', array('id_undangan =' => $id_undangan_decode), 'DELETE');
		redirect('OnJobTraining/MasterUndangan');
	}

}