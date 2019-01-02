<?php
set_time_limit(0);
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class C_TarikFingerspot extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('TarikFingerspot/M_tarikfingerspot');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Tarik FingerSpot';
		$data['Menu'] = 'tarik Fingerspot';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TarikFingerspot/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function TarikData($tanggal=FALSE){
		$user_id = $this->session->userid;

		$data['Title'] = 'Tarik FingerSpot';
		$data['Menu'] = 'tarik Fingerspot';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->form_validation->set_rules('required');	
		if($this->form_validation->run() === TRUE){

			$tanggal = $this->input->post('txtTanggalTarikFinger');
			$data['table'] = $this->M_tarikfingerspot->getAttLog($tanggal);
			$encrypted_string = $this->encrypt->encode($tanggal);
            $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
			$data['tanggal'] = $encrypted_string;

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('TarikFingerspot/V_tarikdata',$data);
			$this->load->view('V_Footer',$data);
		}else{
			if (isset($tanggal) and !empty($tanggal)) {

				$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $tanggal);
				$plaintext_string = $this->encrypt->decode($plaintext_string);

				$log = $this->M_tarikfingerspot->getAttLog($plaintext_string);
				$no = 0;
				$insert = array();
				foreach ($log as $key) {

					$data_presensi = array(
						'tanggal' => $key['tanggal'],
						'waktu' => $key['waktu'],
						'noind' => $key['noind'],
						'kodesie' => $key['kodesie'],
						'noind_baru' => $key['noind_baru'],
						'user_' => $key['user_']
					);
					$cek = $this->M_tarikfingerspot->cekPresensi($data_presensi);
					
					if ($cek == '0') {
						//	Kirim ke FrontPresensi.tpresensi
						//	{
								$data_presensi['transfer']	=	TRUE;
			 					$this->M_tarikfingerspot->insert_presensi('"FrontPresensi"', 'tpresensi', $data_presensi);
						//	}

						//	Kirim ke Catering.tpresensi
						//	{
			 					$data_presensi['transfer']	=	FALSE;
			 					$this->M_tarikfingerspot->insert_presensi('"Catering"', 'tpresensi', $data_presensi);
						//	}

						//	Kirim ke Presensi.tprs_shift
						//	{
			 					$data_presensi['transfer']	=	FALSE;
			 					$data_presensi['user_']		=	'CRON';
			 					$this->M_tarikfingerspot->insert_presensi('"Presensi"', 'tprs_shift', $data_presensi);
						//	}
			 			$insert[$no] = $key;
			 			$no++;
					}	
				}
				echo "Data Diinsert : ".$no."<br><br>";
				foreach ($insert as $key) {
					print_r($key);echo "<br>";
				}
			}else{

				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('TarikFingerspot/V_tarikdata',$data);
				$this->load->view('V_Footer',$data);
			}
		}
		
	}
}
?>