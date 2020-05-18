<?php 
Defined('BASEPATH') or exit('No direct script accsess allowed');
/**
 * 
 */
class C_Undangan extends CI_Controller
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
		$this->load->model('ADMPelatihan/M_undangan');

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

		$data['Title'] = 'Cetak Undangan';
		$data['Menu'] = 'Lain - Lain';
		$data['SubMenuOne'] = 'Cetak Undangan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}

		$undangan = $this->M_undangan->getUndangan();
		$angka = 0;
		$bulan = array(
			'',
			'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember');
		foreach ($undangan as $key) {
			$peserta = explode(";", $key['peserta']);
			$pesertahtml1 = "";
			$pesertahtml2 = "";
			$banyak = 0;
			foreach ($peserta as $value) {
				$nama = $this->M_undangan->getPekerjaKHS($value);
				if ($pesertahtml1 == "") {
						$pesertahtml1 = $value." - ".$nama['0']['nama'];
				}else{
					if ($banyak < 3) {
						$pesertahtml1 = $pesertahtml1."<br>".$value." - ".$nama['0']['nama'];
					}else{
						if ($pesertahtml2 == ""){
							$pesertahtml2 = $value." - ".$nama['0']['nama'];
						}else{
							$pesertahtml2 = $pesertahtml2."<br>".$value." - ".$nama['0']['nama'];
						}	
					}
				}
				$banyak++;
			}
			$arrUndangan[$angka] = array(
				'angka' 	=> $angka+1,
				'tanggal' 	=> $key['tanggal']." ".$bulan[intval($key['bulan'])]." ".$key['tahun'],
				'peserta1' 	=> $pesertahtml1,
				'peserta2' 	=> $pesertahtml2,
				'keterangan'=> $key['keterangan'],
				'id' 		=> $key['id_undangan'],
				'acara' 	=> $key['acara'],
				'tempat' 	=> $key['tempat']
			);
			$angka++;
		}
		if (isset($arrUndangan)) {
			$data['tabel'] = $arrUndangan;
		}
		
		// echo "<pre>";print_r($arrUndangan);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Undangan/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Create Undangan';
		$data['Menu'] = 'Lain - Lain';
		$data['SubMenuOne'] = 'Cetak Undangan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}

		$this->form_validation->set_rules('required');
		if ($this->form_validation->run() === FALSE){
		$data['pekerja'] = $this->M_undangan->getPekerjaKHS();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Undangan/V_create',$data);
		$this->load->view('V_Footer',$data);
		}else{
			$tanggal = $this->input->post('txtTanggalUndanganPelatihan');
			$waktu = $this->input->post('txtWaktuUndanganPelatihan');
			$tempat = $this->input->post('txtTempatUndanganPelatihan');
			$acara = $this->input->post('txtAcaraUndanganPelatihan');
			$approval = $this->input->post('txtApprovalUndanganPelatihan');
			$tmpPeserta = $this->input->post('txtPesertaUndanganPelatihan');
			
			$peserta = "";
			$angka = 0;
			foreach ($tmpPeserta as $value) {
				if ($peserta == "") {
					$peserta = $value;
				}else{
					$peserta = $peserta.";".$value;
				}
				$angka++;
			}
			$keterangan = '';
			if ($angka <= 3) {
				$keterangan = '3';
			}else{
				$keterangan = '15';
			}
			$arrUndangan = array(
				'tanggal' => $tanggal." ".$waktu,
				'acara' => $acara,
				'tempat' => $tempat,
				'approval' => $approval,
				'peserta' => $peserta,
				'keterangan' => $keterangan,
				'create_by' => $this->session->user
			);
			$this->M_undangan->insertUndangan($arrUndangan);

			redirect(site_url('ADMPelatihan/Cetak/Undangan'));
		}
	}

	public function Edit($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$user_id = $this->session->userid;

		$data['Title'] = 'Edit Undangan';
		$data['Menu'] = 'Lain - Lain';
		$data['SubMenuOne'] = 'Cetak Undangan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}

		$this->form_validation->set_rules('required');
		if ($this->form_validation->run() === FALSE){
			$data['pekerja'] = $this->M_undangan->getPekerjaKHS();
			$data['encrypted_string'] = $id;
			$data['undangan'] = $this->M_undangan->getUndanganByID($plaintext_string);
			// echo "<pre>";print_r($data['undangan']);exit();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ADMPelatihan/Undangan/V_edit',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$tanggal = $this->input->post('txtTanggalUndanganPelatihan');
			$waktu = $this->input->post('txtWaktuUndanganPelatihan');
			$tempat = $this->input->post('txtTempatUndanganPelatihan');
			$acara = $this->input->post('txtAcaraUndanganPelatihan');
			$approval = $this->input->post('txtApprovalUndanganPelatihan');
			$tmpPeserta = $this->input->post('txtPesertaUndanganPelatihan');
			
			$peserta = "";
			$angka = 0;
			foreach ($tmpPeserta as $value) {
				if ($peserta == "") {
					$peserta = $value;
				}else{
					$peserta = $peserta.";".$value;
				}
				$angka++;
			}
			$keterangan = '';
			if ($angka <= 3) {
				$keterangan = '3';
			}else{
				$keterangan = '15';
			}
			$arrUndangan = array(
				'tanggal' => $tanggal." ".$waktu,
				'acara' => $acara,
				'tempat' => $tempat,
				'approval' => $approval,
				'peserta' => $peserta,
				'keterangan' => $keterangan
			);
			$this->M_undangan->updateUndangan($plaintext_string,$arrUndangan);

			redirect(site_url('ADMPelatihan/Cetak/Undangan'));
		}
	}

	public function Cetak($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$data['undangan'] = $this->M_undangan->getUndanganByID($plaintext_string);
		foreach ($data['undangan'] as $key) {
			$peserta = explode(";", $key['peserta']);
			$angka = 0;
			foreach ($peserta as $val) {
				$nama = $this->M_undangan->getPekerjaKHS($val);
				$data['peserta'][$angka] = $nama['0']['nama'];
				$angka++;
			}
		}
		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('','A4',0,'',0,0,0,0,0,0);
		$filename = 'Undangan.pdf';
		

		$html = $this->load->view('ADMPelatihan/Undangan/V_cetak', $data, true);

		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function CetakUndanganPelatihan($id){
		$data['undangan'] = $this->M_undangan->getTraining($id);
		$data['peserta'] = $this->M_undangan->getTrainingParticipant($id);
		
		// $angka = 0;
		// foreach ($peserta as $key) {
		// 	$nama = $this->M_undangan->getPekerjaKHS($key['noind']);
		// 	$data['peserta'][$angka] = $nama['0'];
		// 	$angka++;
		// }
		// $this->load->library('pdf');

		// $pdf = $this->pdf->load();
		// $pdf = new mPDF('','A4',0,'',0,0,0,0,0,0);
		// $filename = 'Undangan.pdf';
		

		// $html = $this->load->view('ADMPelatihan/Undangan/V_cetak', $data, true);

		// $stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		// $pdf->WriteHTML($stylesheet1,1);
		// $pdf->WriteHTML($html, 2);
		// $pdf->Output($filename, 'I');
		$user_id = $this->session->userid;

		$data['Title'] = 'Create Undangan';
		$data['Menu'] = 'Lain - Lain';
		$data['SubMenuOne'] = 'Cetak Undangan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}

		$data['pekerja'] = $this->M_undangan->getPekerjaKHS();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Undangan/V_create_2',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Delete($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$this->M_undangan->deleteUndangan($plaintext_string);
		redirect(site_url('ADMPelatihan/Cetak/Undangan'));
	}

	public function cariUndangan(){
		$tanggal = $this->input->post('tanggal');
		$data = $this->M_undangan->getUndanganByTanggal($tanggal);
		echo json_encode($data);
	}

	public function CariUndanganLengkap(){
		$sch_id = $this->input->post('schedule_id');
		$data = $this->M_undangan->getTraining($sch_id);
		echo json_encode($data);
	}

	public function CariUndanganPeserta(){
		$sch_id = $this->input->post('schedule_id');
		$data = $this->M_undangan->getTrainingParticipant($sch_id);
		echo json_encode($data);
	}
}

?>