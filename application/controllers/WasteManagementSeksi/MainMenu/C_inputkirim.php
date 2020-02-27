<?php
Defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_inputkirim extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->library('encrypt');
          //load the login model
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('WasteManagementSeksi/MainMenu/M_kirim');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function getSession(){
		if ($this->session->is_logged) {

		}else{
			redirect('');
		}
	}

	public function index(){
		$this->getSession();

		$user_id = $this->session->userid;

		$data['Title'] = 'Input Kirim Limbah';
		$data['Menu'] = 'Kirim Limbah';
		$data['SubMenuOne'] = 'Input Kirim Limbah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$limbah = $this->M_kirim->getLimbahKirim();

		$location = $this->input->get('location');
		$location_code = '';

		if($location) {
			$location_code = ($location == 'yogyakarta') ? '01' : '02';
		}
	
		$data_limbah = array_filter($limbah, function ($limbah) use ($location_code) {
			if($location_code == '') return true;

			return $limbah['lokasi_kerja'] == $location_code;
		});

		// note : 
		// 1: approved by waste management
		// 2: rejected by waste management
		// 3: kirim limbah baru
		// 4: approved by kasie
		// 5: rejected by kasie

		$data['LimbahKirim'] = $data_limbah;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagementSeksi/InputKirimLimbah/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create(){
		$this->getSession();
		
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Create Kirim Limbah';
		$data['Menu'] = 'Kirim Limbah';
		$data['SubMenuOne'] = 'Input Kirim Limbah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['JenisLimbah'] = $this->M_kirim->getLimJenis($kodesie);
		$data['SatuanLimbah'] = $this->M_kirim->getSatLim();

		$data['Seksi'] = $this->M_kirim->getSekNamaByKodesie($kodesie);
		$data['Seksi2'] = $this->M_kirim->getSekNama();
		$data['Lokasi'] = $this->M_kirim->getLokasi();

		if (empty($_POST)) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('WasteManagementSeksi/InputKirimLimbah/V_create',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$id = $this->M_kirim->getKirimID();
			if ($id['0']['id'] == null) {
				$id['0']['id'] = "1";
			}
			$datapost = array(
				'id_kirim' => $id['0']['id'],
				'tanggal' => $this->input->post('txtTanggalKirimLimbah'),
				'waktu' => $this->input->post('txtWaktuKirimLimbah'),
				'jenis_limbah' => $this->input->post('txtJenisLimbah'),
				'pengirim' => $this->input->post('txtPengirimLimbah'),
				'lokasi_kerja' => $this->input->post('txtLokasi'),
				'kondisi' => $this->input->post('txtKondisi'),
				'jumlah' => $this->input->post('txtJumlah'),
				'keterangan' => $this->input->post('txtKeterangan'),
				'id_satuan' => $this->input->post('txtSatuan')
			);

			$this->M_kirim->insertKirimLimbah($datapost);

			$encrypted_string = $this->encrypt->encode($id['0']['id']);
			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

			redirect(site_url('WasteManagementSeksi/InputKirimLimbah'));
		}
	}

	public function EditKirim($id){
		$this->getSession();

		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['Title'] = 'Edit Kirim Limbah';
		$data['Menu'] = 'Kirim Limbah';
		$data['SubMenuOne'] = 'Input Kirim Limbah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['JenisLimbah'] = $this->M_kirim->getLimJenis($kodesie);
		$data['Seksi'] = $this->M_kirim->getSekNamaByKodesie($kodesie);
		$data['KirimLimbah'] = $this->M_kirim->getLimKirim($plaintext_string);

		$data['SatuanLimbah'] = $this->M_kirim->getSatLimbyLim($data['KirimLimbah']['0']['id_jenis_limbah']);
		// echo "<pre>";
		// print_r($data['SatuanLimbah']);
		if(empty($data['KirimLimbah']['0']['id_satuan'])){
			$data['LimbahSatuan'] = $this->M_kirim->getSatlimOld($data['KirimLimbah']['0']['id_jenis_limbah']);
		}else{
			$data['LimbahSatuan'] = $this->M_kirim->getSatlimbyID($data['KirimLimbah']['0']['id_satuan']);
		}
		// print_r($data['LimbahSatuan']);exit;
		$data['Lokasi'] = $this->M_kirim->getLokasi();

		if (empty($_POST)) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('WasteManagementSeksi/InputKirimLimbah/V_edit',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$datapost = array(
				'id_kirim' => $plaintext_string,
				'tanggal' => $this->input->post('txtTanggalKirimLimbah'),
				'waktu' => $this->input->post('txtWaktuKirimLimbah'),
				'jenis_limbah' => $this->input->post('txtJenisLimbah'),
				'lokasi_kerja' => $this->input->post('txtLokasi'),
				'kondisi' => $this->input->post('txtKondisi'),
				'jumlah' => $this->input->post('txtJumlah'),
				'keterangan' => $this->input->post('txtKeterangan'),
				'id_satuan' => $this->input->post('txtSatuan')
			);

			$this->M_kirim->UpdateLimKirim($datapost);
			redirect(site_url('WasteManagementSeksi/InputKirimLimbah'));
		}

	}

	public function DelKirim($id){
		$this->getSession();

		$user_id = $this->session->userid;

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['Title'] = 'Edit Kirim Limbah';
		$data['Menu'] = 'Kirim Limbah';
		$data['SubMenuOne'] = 'Input Kirim Limbah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->M_kirim->delLimKirim($plaintext_string);
		$data['LimbahKirim'] = $this->M_kirim->getLimbahKirim();

		redirect(base_url('WasteManagementSeksi/InputKirimLimbah'));
	}


	function cetak($id) {
		$this->load->library('pdf');

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8','A5-L',5, 0, 20, 20, 10, 0, 0);

		$filename	=	'FORM PENGIRIMAN LIMBAH B3.pdf';

		$data['data_limbah'] = $this->M_kirim->getdatalimbahkirim($plaintext_string);

		$html = $this->load->view('WasteManagementSeksi/InputKirimLimbah/V_pdf',$data,true);

		$pdf->AddPage();
		$pdf->WriteHTML($html);
		$pdf->setTitle($filename);
		$pdf->Output($filename, 'I');
	}

	public function Cari(){
		$kode = $this->input->post('kodesie');
		$data = $this->M_kirim->getEmployeeCodeName($kode);
		$opsi = "<option></option>";
		foreach ($data as $key) {
			$opsi = $opsi."<option value='".$key['employee_code']."' data-name='".$key['employee_name']."' >".$key['employee_code']."</option>";
		}

		echo $opsi;
	}

	public function ajaxSatuan(){
		$id = $_POST['id'];
		$data = $this->M_kirim->getSatuan($id);
		$opsi = "<option></option>";
		foreach ($data as $key) {
			$opsi = $opsi."<option value='".$key['id_satuan_all']."'>".$key['limbah_satuan_all']."</option>";
		}

		echo $opsi;
	}
}
?>
