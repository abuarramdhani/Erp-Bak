<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_Tugas extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Surat/Tugas/M_tugas');
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

	public function index(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Surat Tugas';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Tugas';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['data'] = $this->M_tugas->getSuratTugasAll();

		$data['insert_id'] = $this->session->id_surat_tugas;
		$this->session->id_surat_tugas = "";

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Tugas/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Tambah(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Surat Tugas';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Tugas';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Tugas/V_tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Simpan(){
		$data = array(
			'no_surat' => $this->input->post('txtMPSuratTugasNomor'),
			'noind' => $this->input->post('slcMPSuratTugasPekerja'),
			'approver' => $this->input->post('slcMPSuratTugasApprover'),
			'isi_surat' => $this->input->post('txtMPSuratTugasSurat'),
			'tgl_dicetak' => $this->input->post('txtMPSuratTugasTanggal'),
			'tgl_dibuat' => date('Y-m-d H:i:s'),
			'user_' => $this->session->user
		);

		$id_insert = $this->M_tugas->insertSuratTugas($data);

		$this->session->id_surat_tugas = $id_insert;

		redirect(base_url('MasterPekerja/Surat/SuratTugas'));
	}

	public function Pekerja(){
		$key = $this->input->get('term');
		$data = $this->M_tugas->getPekerjaByKey($key);
		echo json_encode($data);
	}

	public function Detail(){
		$noind = $this->input->get('noind');
		$data = $this->M_tugas->getDetailPekerjaByNoind($noind);
		$index = 0;
		foreach ($data as $dt) {
			if ($dt['lokasi_kerja'] == '01' or $dt['lokasi_kerja'] == '03' or $dt['lokasi_kerja'] == '04') {
				$data[$index]['nomor_surat'] = '001/PS/KE-A/04/20';
			} elseif ($dt['lokasi_kerja'] == '02') {
				$data[$index]['nomor_surat'] = '002/PS/KE-A/04/20';
			}else{
				$data[$index]['nomor_surat'] = "bukan pusat / tuksono";
			}
			$index++;
		}
		echo json_encode($data[0]);
	}

	public function Preview(){
		$noind 		= $this->input->get('noind');
		$nomor 		= $this->input->get('nomor');
		$approver 	= $this->input->get('approver');
		$tanggal 	= $this->input->get('tanggal');
		$pekerja = $this->M_tugas->getDetailPekerjaByNoind($noind);
		$appr = $this->M_tugas->getDetailPekerjaByNoind($approver);
		$surat_array = $this->M_tugas->getSuratTugasTemplate();
		$surat_text = $surat_array[0]['isi_surat'];
		$surat_text = str_replace("tugas_nomor_surat", $nomor, $surat_text);
		$surat_text = str_replace("tugas_nama" , $pekerja[0]['nama'], $surat_text);
		$surat_text = str_replace("tugas_noind" , $pekerja[0]['noind'], $surat_text);
		$surat_text = str_replace("tugas_seksi" , $pekerja[0]['seksi'], $surat_text);
		$surat_text = str_replace("tugas_alamat" , $pekerja[0]['alamat'], $surat_text);
		$surat_text = str_replace("tugas_nik" , $pekerja[0]['nik'], $surat_text);
		$surat_text = str_replace("tugas_lokasi_kerja" , $pekerja[0]['lokasi_kerja_text'], $surat_text);
		$surat_text = str_replace("tugas_tanggal_dibuat" , date('d F Y',strtotime($tanggal)), $surat_text);
		$surat_text = str_replace("tugas_approver_nama" , $appr[0]['nama'], $surat_text);
		$surat_text =str_replace("tugas_approver_jabatan" ,  ucwords(strtolower($appr[0]['jabatan'])), $surat_text);


		$data = array(
			'surat' => $surat_text,
			'get_' => $_GET,
			'pekerja' => $pekerja,
			'approver' => $appr,
			'surat_asli' => $surat_array
		);
		echo json_encode($data);
	}

	public function Ubah($id_encoded){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_encoded);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$id = $plaintext_string;

		$data['data'] = $this->M_tugas->getSuratTugasById($id);
		$data['id_encoded'] = $id_encoded;

		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Surat Tugas';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Tugas';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Tugas/V_ubah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Hapus($id_encoded){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_encoded);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$id = $plaintext_string;

		$this->M_tugas->deleteSuratTugasByID($id);

		redirect(base_url('MasterPekerja/Surat/SuratTugas'));
	}

	public function PDF($id_encoded){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_encoded);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$id = $plaintext_string;
		
		$data['data'] = $this->M_tugas->getSuratTugasById($id);

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 10, "timesnewroman", 20, 20, 50, 20, 20, 5);
		$filename = 'Surat Tugas Pekerja'.$value.'.pdf';
		// $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_pcetak', $data);
		$html = $this->load->view('MasterPekerja/Surat/Tugas/V_cetak', $data, true);
	//	$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-MasterPekerja oleh ".$this->session->user." pada tgl. ".strftime('%d/%h/%Y %H:%M:%S').". Halaman {PAGENO} dari {nb}</i>");
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

}

?>