<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');
/**
* 
*/
class C_Index extends CI_Controller
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
		$this->load->model('ADMSeleksi/M_index');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'ADM Seleksi';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMSeleksi/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function InputBiodata()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Input Biodata';
		$data['Menu'] = 'Input Biodata';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMSeleksi/V_Input_Biodata',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SubmitBiodata()
	{
		// echo "<pre>";
		// print_r($_POST);exit();
		$msg = 'yes';
		$key = 'q~ui./^ck,1/*2)3';
		$encrypted_string = $this->encrypt->encode($msg, $key);
		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
		// echo $encrypted_string;exit();
		
		$nik = strtoupper($this->input->post('nik'));
		$nama = strtoupper($this->input->post('nama'));
		$email = $this->input->post('email');
		$tmp_lahir = strtoupper($this->input->post('tmp_lahir'));
		$tgl_lahir = strtoupper($this->input->post('tgl_lahir'));
		$jen_kel = strtoupper($this->input->post('jen_kel'));
		$agama = strtoupper($this->input->post('agama'));
		$alamat = strtoupper($this->input->post('alamat'));
		$kota = strtoupper($this->input->post('kota'));
		$no_hp = strtoupper($this->input->post('no_hp'));
		$no_wa = strtoupper($this->input->post('no_wa'));
		$pendidikan = strtoupper($this->input->post('pendidikan'));
		$institusi = strtoupper($this->input->post('institusi'));
		$jurusan = strtoupper($this->input->post('jurusan'));
		$ijazah = strtoupper($this->input->post('ijazah'));
		$no_ijazah = strtoupper($this->input->post('no_ijazah'));
		$nilai_ijazah = strtoupper($this->input->post('nilai_ijazah'));
		$penempatan = strtoupper($this->input->post('penempatan'));
		$pekerjaan = strtoupper($this->input->post('pekerjaan'));

		$checkBiodata = $this->M_index->checkBiodata($nik);
		$checkAccount = $this->M_index->checkAccount($nik);

		if ($checkBiodata < 1) {
			$data = array(
				'pekerjaan' => $pekerjaan, 
				'penempatan' => $penempatan, 
				'no_id' => $nik, 
				'nama' => $nama, 
				'tmp_lahir' => $tmp_lahir, 
				'tgl_lahir' => $tgl_lahir, 
				'jen_kel' => $jen_kel, 
				'agama' => $agama, 
				'kota' => $kota, 
				'alamat' => $alamat, 
				'no_hp' => $no_wa, 
				'no_telp' => $no_hp, 
				'pendidikan' => $pendidikan, 
				'sekolah' => $institusi, 
				'jurusan' => $jurusan, 
				'status' => $no_ijazah, 
				'diploma' => $no_ijazah, 
				'nilai' => $nilai_ijazah,
				'creation_date' => date('Y-m-d H:i:s'),
				);
			$insert	=	$this->M_index->insertBiodata($data);
		}
		if ($checkAccount < 1) {
			$akun = array(
				'no_id' => $nik, 
				'nama' => $nama, 
				'asal_kota' => $kota, 
				'email' => $email, 
				'password' => md5($nik), 
				'approval' => $encrypted_string,
				'tgl_register' => date('Y-m-d H:i:s'),

				);
			$add = $this->M_index->insertAkun($akun);
		}
			redirect('ADMSeleksi/Menu/InputBiodata');
	}

	function getkotaLahir()
	{
		$p = $this->input->get('term');
		$data = $this->M_index->getKotaLahir($p);
		echo json_encode($data);
	}

	function jsonKota2(){
		$q = strtoupper($this->input->get('term'));
		$dataKota = $this->M_index->dataKota2($q);
		echo json_encode($dataKota);
	}

	function list_institusi()
	{
		$q = strtoupper($this->input->get('term'));
		$dataInstitutsi = $this->M_index->dataInstitusi($q);
		echo json_encode($dataInstitutsi);
	}

	function list_jurusan()
	{
		$q = strtoupper($this->input->get('term'));
		$dataJurusan = $this->M_index->dataJurusan($q);
		echo json_encode($dataJurusan);
	}

	function penempatan()
	{
		$q = strtoupper($this->input->get('term'));
		$dataPenempatan = $this->M_index->dataPenempatan($q);
		echo json_encode($dataPenempatan);
	}

	function getJenjang()
	{
		$q = strtoupper($this->input->get('term'));
		$dataJenjang = $this->M_index->dataJenjang($q);
		echo json_encode($dataJenjang);
	}
	function avail_job()
	{
		$penempatan = $this->input->get('penempatan');
		$id_penempatan = $this->M_index->getIdPenempatan($penempatan);
		$id = $id_penempatan[0]['id'];
		$p = strtoupper($this->input->get('term'));

		$data = $this->M_index->pekerjaan_j($p,$id);
		echo json_encode($data);
	}

	public function checkData()
	{
		$nik = $this->input->get('nik');
		// echo $nik;
		$checkBiodata = $this->M_index->checkBiodata($nik);
		$checkAccount = $this->M_index->checkAccount($nik);
		if ($checkBiodata < 1 && $checkAccount < 1) {
			echo json_encode('aman');
		}else{
			echo json_encode('tidak');
		}
	}
}