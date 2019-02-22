<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterMemo extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('General');
		$this->load->library('MonitoringOJT');		

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringOJT/M_mastermemo');

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

		$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Master Memo', 'Setup', 'Memo');

		$data['daftar_format_memo']		=	$this->M_mastermemo->memo();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/V_MasterMemo_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$this->form_validation->set_rules('txtJenisMemo', 'Jenis Memo', 'required');
		$this->form_validation->set_rules('txaFormatMemo', 'Format Memo', 'required');

		if($this->form_validation->run() === FALSE)
		{
			$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Master Memo', 'Setup', 'Memo');

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringOJT/V_MasterMemo_Create',$data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$user 						=	$this->session->user;
			$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

			$jenis_memo 		=	strtoupper($this->input->post('txtJenisMemo', TRUE));
			$format_memo 		=	$this->input->post('txaFormatMemo');


			$create_memo 		=	array
									(
										'judul'				=>	$jenis_memo,
										'memo'				=>	$format_memo,
										'create_timestamp'	=>	$execution_timestamp,
										'create_user'		=>	$user,
									);
			$id_memo 	=	$this->M_mastermemo->create($create_memo);

			$this->monitoringojt->ojt_history('ojt', 'tb_master_memo', array('id_memo =' => $id_memo), 'CREATE');
			redirect('OnJobTraining/MasterMemo');
		}
	}

	public function read($id_memo)
	{
		$id_memo_decode = $this->general->dekripsi($id_memo);

		$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Master Memo', 'Setup', 'Memo');

		$data['daftar_format_memo']		=	$this->M_mastermemo->memo($id_memo_decode);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/V_MasterMemo_Read',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update($id_memo)
	{
		$this->form_validation->set_rules('txtJenisMemo', 'Jenis Memo', 'required');
		$this->form_validation->set_rules('txaFormatMemo', 'Format Memo', 'required');

		$id_memo_decode = $this->general->dekripsi($id_memo);

		if($this->form_validation->run() === FALSE)
		{
			$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Master Memo', 'Setup', 'Memo');

			$data['daftar_format_memo']		=	$this->M_mastermemo->memo($id_memo_decode);
			$data['id']						=	$id_memo;

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringOJT/V_MasterMemo_Update',$data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$user 						=	$this->session->user;
			$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

			$jenis_memo 		=	strtoupper($this->input->post('txtJenisMemo', TRUE));
			$format_memo 		=	$this->input->post('txaFormatMemo');

			$update_memo 		=	array
										(
											'judul'					=>	$jenis_memo,
											'memo'					=>	$format_memo,
											'last_update_timestamp'	=>	$execution_timestamp,
											'last_update_user'		=>	$user,
										);

			$this->M_mastermemo->update($update_memo, $id_memo_decode);

			$this->monitoringojt->ojt_history('ojt', 'tb_master_memo', array('id_memo =' => $id_memo_decode), 'UPDATE');
			redirect('OnJobTraining/MasterMemo');
		}
	}

	public function delete($id_memo)
	{
		$id_memo_decode = $this->general->dekripsi($id_memo);

		$user 						=	$this->session->user;
		$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

		$this->M_mastermemo->delete($id_memo_decode);

		$this->monitoringojt->ojt_history('ojt', 'tb_master_memo', array('id_memo =' => $id_memo_decode), 'DELETE');
		redirect('OnJobTraining/MasterMemo');
	}

}