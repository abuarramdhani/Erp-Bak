<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {


	public function __construct()
    {
        parent::__construct();

        $this->load->library('Log_Activity');
        $this->load->library('General');
        $this->load->library('excel');
        $this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/CetakBPJS/M_cetakttbpjs');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->load->helper('terbilang_helper');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		date_default_timezone_set('Asia/Jakarta');
		$this->checkSession();
    }
	public function checkSession()
	{
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}
    public function index()
    {
    	$this->checkSession();
    	$user_id = $this->session->userid;

    	$data['Menu'] = 'Lain-lain';
    	$data['SubMenuOne'] = 'Tanda Terima BPJS';
    	$data['SubMenuTwo'] = '';

    	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    	$data['data'] = $this->M_cetakttbpjs->ambilData();

    	$this->load->view('V_Header',$data);
    	$this->load->view('V_Sidemenu',$data);
    	$this->load->view('MasterPekerja/CetakBPJS/V_Index',$data);
    	$this->load->view('V_Footer',$data);
    }
    public function data_pekerja()
	{
		$p = strtoupper($this->input->get('term'));
		$data = $this->M_cetakttbpjs->getPekerja($p);
		echo json_encode($data);
	}
	public function insert()
	{
		$this->checkSession();
    	$user_id = $this->session->userid;
		$noind = $this->input->post('tt_noind');
		$data = $this->M_cetakttbpjs->dataBPJS($noind);
		$nama = str_replace(" ","*", $data[0]['nama']);
		$namaa = str_replace("**", "", $nama);
		$namaaa = str_replace("*", " ", $namaa);

		$array_data = array(
							'noind' => trim($data[0]['noind']),
							'nama' => $namaaa,
							'seksi' => $data[0]['seksi'],
							'no_kpj' => trim($data[0]['no_kpj']),
							'jp' => trim($data[0]['jp']),
							'lokasi' => $data[0]['lokasi'],
							'created_timestamp' => date('Y-m-d H:i:s'),
							'created_user' => $this->session->user
						);
		$this->M_cetakttbpjs->insertData($array_data);
        //insert to t_log
        $aksi = 'MASTER PEKERJA';
        $detail = 'Add Data BPJS Noind='.$noind;
        $this->log_activity->activity_log($aksi, $detail);
        //
		redirect('MasterPekerja/TanTerBPJS');
	}

	public function delete($id)
	{
		if ($id == "All") {
			$this->M_cetakttbpjs->deleteDataAll();
            //insert to t_log
            $aksi = 'MASTER PEKERJA';
            $detail = 'Update kk_cetaktanterbpjs status_Cetak All set= 1';
            $this->log_activity->activity_log($aksi, $detail);
            //
		}else{
			$this->M_cetakttbpjs->deleteData($id);
            //insert to t_log
            $aksi = 'MASTER PEKERJA';
            $detail = 'Update kk_cetaktanterbpjs status_Cetak set= 1 ID='.$id;
            $this->log_activity->activity_log($aksi, $detail);
            //
		}
		redirect('MasterPekerja/TanTerBPJS');
	}

	public function export_excel()
	{
        //insert to t_log
        $aksi = 'MASTER PEKERJA';
        $detail = 'Export Excel Data BPJS';
        $this->log_activity->activity_log($aksi, $detail);
        //
		$tgl = date('Y-m-d');
		$data['data'] = $this->M_cetakttbpjs->ambilData();
		$data['filename'] = "Tanda_Terima_BPJS_".$tgl.".xls";
		$data['filename'] = preg_replace('/\s+/', '', $data['filename']);
		$this->load->view('MasterPekerja/CetakBPJS/V_Export_excel',$data);
	}

}
