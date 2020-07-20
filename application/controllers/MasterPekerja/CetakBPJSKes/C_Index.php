<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {


	public function __construct()
    {
        parent::__construct();

        $this->load->library('General');
        $this->load->library('Log_Activity');
        $this->load->library('excel');
        $this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/CetakBPJSKes/M_cetakttbpjskes');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->load->helper('terbilang_helper');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
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
    	$data['SubMenuOne'] = 'Tanda Terima BPJS Kesehatan';
    	$data['SubMenuTwo'] = '';

    	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    	$data['data'] = $this->M_cetakttbpjskes->ambilData();

    	$this->load->view('V_Header',$data);
    	$this->load->view('V_Sidemenu',$data);
    	$this->load->view('MasterPekerja/CetakBPJSKes/V_Index',$data);
    	$this->load->view('V_Footer',$data);
    }
    public function data_pekerja()
	{
		$p = strtoupper($this->input->get('term'));
		$data = $this->M_cetakttbpjskes->getPekerja($p);
		echo json_encode($data);
	}
	public function insert()
	{
		$this->checkSession();
    	$user_id = $this->session->userid;
		$noind = $this->input->post('tt_noind');
		$data = $this->M_cetakttbpjskes->dataBPJS($noind);
		$nama = str_replace(" ","*", $data[0]['nama']);
		$namaa = str_replace("**", "", $nama);
		$namaaa = str_replace("*", " ", $namaa);

		$array_data = array(
							'noind' => trim($data[0]['noind']),
							'nama' => $namaaa,
							'seksi' => $data[0]['seksi'],
							'no_kes' => trim($data[0]['no_kes']),
							'lokasi' => $data[0]['lokasi'],
							'created_timestamp' => date('Y-m-d H:i:s'),
							'created_user' => $this->session->user
						);
		$this->M_cetakttbpjskes->insertData($array_data);
        //insert to t_log
        $aksi = 'MASTER PEKERJA';
        $detail = 'Add BPJS Kesehatan Noind='.trim($data[0]['noind']);
        $this->log_activity->activity_log($aksi, $detail);
        //
		redirect('MasterPekerja/TanTerBPJSKes');
	}

	public function delete($id)
	{
		if ($id == "All") {
			$this->M_cetakttbpjskes->deleteDataAll();
            //insert to t_log
            $aksi = 'MASTER PEKERJA';
            $detail = 'Update kk_cetaktanterbpjs kesehatan status_Cetak All set= 1';
            $this->log_activity->activity_log($aksi, $detail);
            //
		}else{
			$this->M_cetakttbpjskes->deleteData($id);
            //insert to t_log
            $aksi = 'MASTER PEKERJA';
            $detail = 'Update kk_cetaktanterbpjs kesehatan status_Cetak set= 1 ID='.$id;
            $this->log_activity->activity_log($aksi, $detail);
            //
		}
		redirect('MasterPekerja/TanTerBPJSKes');
	}

	public function export_excel()
	{
        //insert to t_log
        $aksi = 'MASTER PEKERJA';
        $detail = 'Export Excel BPJS Kesehatan';
        $this->log_activity->activity_log($aksi, $detail);
        //
		$tgl = date('Y-m-d');
		$data['data'] = $this->M_cetakttbpjskes->ambilData();
		$data['filename'] = "Tanda_Terima_BPJS_Kesehatan".$tgl.".xls";
		$data['filename'] = preg_replace('/\s+/', '', $data['filename']);
		$this->load->view('MasterPekerja/CetakBPJSKes/V_Export_excel',$data);
	}

}
