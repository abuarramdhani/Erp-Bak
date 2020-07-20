<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_KlikBCAchecking_Check extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		include APPPATH . 'libraries/simple_html_dom.php';
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		  //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('AccountPayables/M_klikbcachecking_check');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
	}

	//HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		
			$data['bca'] 	= Array();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AccountPayables/KlikBCAChecking/Check/V_Index',$data);
		$this->load->view('AccountPayables/KlikBCAChecking/Check/V_Index2',$data);
		$this->load->view('AccountPayables/KlikBCAChecking/Check/V_Index3',$data);
		$this->load->view('V_Footer',$data);
	}

	public function show(){
		
		$start 			= $this->input->POST('start');
		$end 			= $this->input->POST('end');
		$data['bca'] 	= $this->M_klikbcachecking_check->ShowBCA($start,$end);
		$this->load->view('AccountPayables/KlikBCAChecking/Check/V_Index2',$data);
	}

	function validate(){
		$start			= $this->input->post('TxtStartDate');
		$end			= $this->input->post('TxtEndDate');
		
		$Referencee		= $this->M_klikbcachecking_check->ShowBCA($start,$end);

		foreach ($Referencee as $rf) {
			$checking_id		= $rf['checking_id'];
			$berita				= $rf['berita'];
			$no_rek_penerima	= $rf['no_rek_penerima'];
			$nama_penerima		= $rf['nama_penerima'];
			$jumlah				= $rf['jumlah'];

			if($rf['oracle_checking'] !== 'Y' AND $rf['oracle_checking'] !== 'T' ){
				$oc = $this->M_klikbcachecking_check->GetOcracleMatch($berita);
				if(!empty($oc)){
					$oracle_berita				= $oc[0]['PAY_NUMBER'];
					$oracle_no_rek_penerima		= $oc[0]['REK_TUJUAN'];
					$oracle_nama_penerima		= $oc[0]['ACCT_TUJUAN'];
					$oracle_jumlah				= round($oc[0]['AMOUNT']);
				}else{
					$oracle_berita				= '-';
					$oracle_no_rek_penerima		= '-';
					$oracle_nama_penerima		= '-';
					$oracle_jumlah				= '0';
				}
				$this->M_klikbcachecking_check->InsertOracleToPostgre($checking_id,$oracle_berita,$oracle_no_rek_penerima,$oracle_nama_penerima,$oracle_jumlah);
				
				$ck = $this->M_klikbcachecking_check->GetOracleInPostgre($checking_id);
				print_r($ck);
				if( $ck[0]['berita']			== $ck[0]['pay_num_oracle'] AND
					$ck[0]['no_rek_penerima']	== $ck[0]['rek_tujuan'] AND
					$ck[0]['inisial_penerima']	== $ck[0]['inisial_tujuan'] AND
					$ck[0]['jumlah']			== $ck[0]['jumlah_oracle']
				){
					$oracle_checking = 'Y';
				}else{
					$oracle_checking = 'T';
				}
				$this->M_klikbcachecking_check->VerifyOracleChecking($checking_id,$oracle_checking);
			}
		}

		//LAPORAN
		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('utf-8', array(210,330), 0, '', 0, 0, 25, 0, 0, 0, 'L');

		$filename = 'KlikBCA-Checking-Report';
		$this->checkSession();

		$data['Referencee'] = $this->M_klikbcachecking_check->ShowBCA($start,$end);

		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
		$head = $this->load->view('AccountPayables/KlikBCAChecking/Check/V_ReportHeader', $data, true);
		$html = $this->load->view('AccountPayables/KlikBCAChecking/Check/V_Report', $data, true);
		$foot = $this->load->view('AccountPayables/KlikBCAChecking/Check/V_ReportFooter', $data, true);

		$pdf->SetHTMLHeader($head);
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->SetHTMLFooter($foot);
		$pdf->Output($filename, 'I');
	}

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}
}