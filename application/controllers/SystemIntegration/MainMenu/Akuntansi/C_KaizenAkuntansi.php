<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_KaizenAkuntansi extends CI_Controller
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
		$this->load->model('SystemIntegration/M_kaizenakuntansi');
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

		$data['Title']			=	'Kaizen Akuntansi';
		$data['Header']			=	'Kaizen Akuntansi';
		$data['Menu'] 			= 	'Submit Kaizen';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SubmitIde(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Kaizen Akuntansi';
		$data['Header']			=	'Kaizen Akuntansi';
		$data['Menu'] 			= 	'Submit Kaizen';
		$data['SubMenuOne'] 	= 	'Submit Ide';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemIntegration/MainMenu/KaizenAkuntansi/V_SubmitIde',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SimpanIde(){
		$seksi 		= $this->input->post('seksi');
		$judul 		= $this->input->post('judul');
		$dueDate 	= $this->input->post('dueDate');
		$noind 		= $this->session->user;
		$nama 		= trim($this->session->employee);

		$data = array(
			'pencetus_noind'=> $noind,
			'pencetus_nama' => $nama,
			'ide'	 		=> $judul,
			'seksi' 		=> $seksi,
			'due_date_f4' 	=> $dueDate,
			'status' 		=> 'Create Ide'
		);

		$id_kaizen = $this->M_kaizenakuntansi->insertKaizen($data);

		$thread = array(
			'kaizen_id' => $id_kaizen,
			'status' 	=> 'Create Ide',
			'detail' 	=> '(Create Ide) '.$noind.' - '.trim($nama).' telah membuat ide kaizen '.$judul
		);

		$this->M_kaizenakuntansi->insertThreadKaizen($thread);

		echo $id_kaizen;
	}

	public function SubmitF4(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Kaizen Akuntansi';
		$data['Header']			=	'Kaizen Akuntansi';
		$data['Menu'] 			= 	'Submit Kaizen';
		$data['SubMenuOne'] 	= 	'Submit F4';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['ide'] = $this->M_kaizenakuntansi->getKaizenByUserStatus($user,'Create Ide');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemIntegration/MainMenu/KaizenAkuntansi/V_SubmitF4',$data);
		$this->load->view('V_Footer',$data);
	}

	public function uploadSubmitF4(){
		$user = $this->session->user;

		$namaLama	= $_FILES['file']['name'];
		$ekstensi	= pathinfo($namaLama,PATHINFO_EXTENSION);
		$namaBaru	= "SI-KaizenAkuntansi-SubmitF4-".$user."-".str_replace(' ', '_', date('Y-m-d H:i:s')).".".$ekstensi;

		$config = array(
			'upload_path' 	=> './assets/upload_kaizen/',
	        'upload_url' 	=> base_url()  . 'assets/upload_kaizen/',
	        'allowed_types' => 'jpg|gif|png',
	        'overwrite' 	=> false,
	        'file_name' 	=> $namaBaru
	    );

	    $this->load->library('upload', $config);

	    if ($this->upload->do_upload('file')) {
	        $data = $this->upload->data();
	        $array = array(
	            'filelink' => $config['upload_url'] . $data['file_name']
	        );
	        echo stripslashes(json_encode($array));
	    } else {
	        echo json_encode(array('error' => $this->upload->display_errors('', '')));
	    }
	}

	public function getKomponen(){
		$term = $this->input->get('p');
		$term = strtoupper($term);
		$getItem = $this->M_kaizenakuntansi->getMasterItem($term,FALSE);
		echo json_encode($getItem);
	}

	public function SimpanF4(){
		$kaizen_id 		= $this->input->post('kaizen_id');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $kaizen_id);
		$kaizenId = $this->encrypt->decode($plaintext_string);

		$judul 			= $this->input->post('kaizen_judul');
		$nama 			= $this->input->post('nama');
		$noind 			= $this->input->post('noind');
		$kondisi 		= $this->input->post('kondisi');
		$usulan 		= $this->input->post('usulan');
		$pertimbangan 	= $this->input->post('pertimbangan');
		$realisasi 		= $this->input->post('realisasi');
		$komponens 		= $this->input->post('komponen');
		$komponen = '';
		if (isset($komponens) && !empty($komponens)) {
			foreach ($komponens as $key => $value) {
				if ($komponen == '') {
					$komponen .= $value;
				}else{
					$komponen .= ";".$value;
				}
			}
		}

		$data = array(
			'komponen' 			=> $komponen,
			'kondisi_awal' 		=> $kondisi,
			'usulan_kaizen' 	=> $usulan,
			'pertimbangan' 		=> $pertimbangan,
			'tanggal_realisasi' => $realisasi,
			'status' 			=> 'F4 Sudah di Submit',
			'judul'				=> $judul
		);
		$this->M_kaizenakuntansi->updateKaizenByKaizenId($data,$kaizenId);

		$thread = array(
			'kaizen_id' => $kaizenId,
			'status' 	=> 'F4 Sudah di Submit',
			'detail' 	=> '(F4 Sudah di Submit) '.$noind.' - '.trim($nama).' telah submit F4 kaizen dengan judul '.$judul
		);

		$this->M_kaizenakuntansi->insertThreadKaizen($thread);
		echo "sukses";	
	}

	public function CetakF4($kaizen_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $kaizen_id);
		$kaizenId = $this->encrypt->decode($plaintext_string);

		$this->load->library('pdf');
		
		$data['kaizen'] = $this->M_kaizenakuntansi->getKaizenByKaizenId($kaizenId);
		$update = array(
			'status' 			=> 'F4 Belum di Upload'
		);
		$this->M_kaizenakuntansi->updateKaizenByKaizenId($update,$kaizenId);

		$thread = array(
			'kaizen_id' => $kaizenId,
			'status' 	=> 'F4 Belum di Upload',
			'detail' 	=> '(F4 Belum di Upload) '.$this->session->user.' - '.trim($this->session->employee).' telah mencetak PDF F4 kaizen dengan judul '.$data['kaizen'][0]['judul']
		);
		$this->M_kaizenakuntansi->insertThreadKaizen($thread);

	    if ($data['kaizen'][0]['komponen']) {
				$arrayKomponen = explode(';', $data['kaizen'][0]['komponen']);
				foreach ($arrayKomponen as $key => $value) {
					$dataItem = $this->M_kaizenakuntansi->getMasterItem(FALSE,$value);
					$kodeItem = $dataItem[0]['SEGMENT1'];
					$namaItem = $dataItem[0]['ITEM_NAME'];
					$komponen[] = $aa = array('id' => $value, 'code' => $kodeItem, 'name' => $namaItem);
				}

				$data['kaizen'][0]['komponen'] = $komponen;
			}

		$data['section_user'] = $this->M_kaizenakuntansi->getSectAll($data['kaizen'][0]['pencetus_noind']);		

		if (strpos($data['kaizen'][0]['kondisi_awal'], '<img') !== FALSE) {
			$data['kaizen'][0]['kondisi_awal'] = str_replace('<img', '<br><img class="img img-responsive"', $data['kaizen'][0]['kondisi_awal']);
		} else {
			$data['kaizen'][0]['kondisi_awal'] = $data['kaizen'][0]['kondisi_awal'];
		}
		if (strpos($data['kaizen'][0]['usulan_kaizen'], '<img') !== FALSE) {
			$data['kaizen'][0]['usulan_kaizen'] = str_replace('<img', '<br><img class="img img-responsive"', $data['kaizen'][0]['usulan_kaizen']);
		} else {
			$data['kaizen'][0]['usulan_kaizen'] = $data['kaizen'][0]['usulan_kaizen'];
		}
		if (strpos($data['kaizen'][0]['pertimbangan'], '<img') !== FALSE) {
			$data['kaizen'][0]['pertimbangan'] = str_replace('<img', '<br><img class="img img-responsive"', $data['kaizen'][0]['pertimbangan']);
		} else {
			$data['kaizen'][0]['pertimbangan'] = $data['kaizen'][0]['pertimbangan'];
		}
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'F4', 8, '', 5, 5, 10, 15, 0, 0, 'P');
		$pencetus = preg_replace('/(\s)+/', ' ', $data['kaizen'][0]['pencetus_nama']);
		$pencetus = strtolower($pencetus);
		$pencetus = ucwords($pencetus);
		$pencetus = str_replace(' ', '_', $pencetus);
		$filename = 'F4-Kaizen-'.$pencetus.'-'.$data['kaizen'][0]['judul'].'.pdf';
		$today = date('d-M-Y H:i:s');
		$kaizen_id = $data['kaizen_id'][0]['kaizen_id'];

		$stylesheet = file_get_contents(base_url('assets/css/customSI.css'));
		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.min.css'));
		$html = $this->load->view('SystemIntegration/MainMenu/KaizenAkuntansi/V_CetakF4', $data, true);
		$pdf->setHTMLFooter('
				<table width="100%">
					<tr>
						<td style="font-size: 12px ; padding: 2px">Halaman ini di cetak melalui QuickERP - Kaizen Akuntansi, Pada tanggal: '.$today.' oleh : '.$this->session->user.' - '.$this->session->employee.'</td>
					</tr>
				</table>
			');
		$pdf->SetTitle($filename);
		$pdf->WriteHTML($stylesheet, 1);
		$pdf->WriteHTML($stylesheet1, 1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function MyKaizen(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Kaizen Akuntansi';
		$data['Header']			=	'Kaizen Akuntansi';
		$data['Menu'] 			= 	'My Kaizen';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kaizen'] = $this->M_kaizenakuntansi->getKaizenByNoind($user);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemIntegration/MainMenu/KaizenAkuntansi/V_MyKaizen',$data);
		$this->load->view('V_Footer',$data);
	}

	public function UploadF4($kaizen_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $kaizen_id);
		$kaizenId = $this->encrypt->decode($plaintext_string);

		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Kaizen Akuntansi';
		$data['Header']			=	'Kaizen Akuntansi';
		$data['Menu'] 			= 	'My Kaizen';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kaizen'] = $this->M_kaizenakuntansi->getKaizenByKaizenId($kaizenId);
		$data['thread'] = $this->M_kaizenakuntansi->getThreadByKaizenId($kaizenId);
		if ($data['kaizen'][0]['komponen']) {
				$arrayKomponen = explode(';', $data['kaizen'][0]['komponen']);
				foreach ($arrayKomponen as $key => $value) {
					$dataItem = $this->M_kaizenakuntansi->getMasterItem(FALSE,$value);
					$kodeItem = $dataItem[0]['SEGMENT1'];
					$namaItem = $dataItem[0]['ITEM_NAME'];
					$komponen[] = $aa = array('id' => $value, 'code' => $kodeItem, 'name' => $namaItem);
				}

				$data['kaizen'][0]['komponen'] = $komponen;
			}

		$data['section_user'] = $this->M_kaizenakuntansi->getSectAll($data['kaizen'][0]['pencetus_noind']);		

		if (strpos($data['kaizen'][0]['kondisi_awal'], '<img') !== FALSE) {
			$data['kaizen'][0]['kondisi_awal'] = str_replace('<img', '<br><img class="img img-responsive"', $data['kaizen'][0]['kondisi_awal']);
		} else {
			$data['kaizen'][0]['kondisi_awal'] = $data['kaizen'][0]['kondisi_awal'];
		}
		if (strpos($data['kaizen'][0]['usulan_kaizen'], '<img') !== FALSE) {
			$data['kaizen'][0]['usulan_kaizen'] = str_replace('<img', '<br><img class="img img-responsive"', $data['kaizen'][0]['usulan_kaizen']);
		} else {
			$data['kaizen'][0]['usulan_kaizen'] = $data['kaizen'][0]['usulan_kaizen'];
		}
		if (strpos($data['kaizen'][0]['pertimbangan'], '<img') !== FALSE) {
			$data['kaizen'][0]['pertimbangan'] = str_replace('<img', '<br><img class="img img-responsive"', $data['kaizen'][0]['pertimbangan']);
		} else {
			$data['kaizen'][0]['pertimbangan'] = $data['kaizen'][0]['pertimbangan'];
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemIntegration/MainMenu/KaizenAkuntansi/V_UploadF4',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SaveUploadF4($kaizen_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $kaizen_id);
		$kaizenId = $this->encrypt->decode($plaintext_string);

		$namaLama	= $_FILES['file']['name'];
		$ekstensi	= pathinfo($namaLama,PATHINFO_EXTENSION);
		$namaBaru	= "SI-KaizenAkuntansi-UploadF4-".$user."-".str_replace(' ', '_', date('Y-m-d H:i:s')).".".$ekstensi;

		$config = array(
			'upload_path' 	=> './assets/upload_kaizen/',
	        'upload_url' 	=> base_url()  . 'assets/upload_kaizen/',
	        'allowed_types' => 'jpg|gif|png|pdf',
	        'overwrite' 	=> false,
	        'file_name' 	=> $namaBaru
	    );

	    $this->load->library('upload', $config);

	    if ($this->upload->do_upload('file')) {
	    	$data = $this->upload->data();
	        $link = $config['upload_url'] . $data['file_name'];
	        $update = array(
				'status' 			=> 'F4 Sudah di Upload',
				'upload_date_f4' 	=> date('Y-m-d'),
				'path_f4' 			=> $link
			);
			$this->M_kaizenakuntansi->updateKaizenByKaizenId($update,$kaizenId);

			$thread = array(
				'kaizen_id' => $kaizenId,
				'status' 	=> 'F4 Sudah di Upload',
				'detail' 	=> '(F4 Sudah di Upload) '.$this->session->user.' - '.trim($this->session->employee).' telah mengunggah F4 kaizen dengan judul '.$data['kaizen'][0]['judul']
			);
			$this->M_kaizenakuntansi->insertThreadKaizen($thread);
	        redirect(base_url('SystemIntegration/KaizenAkt/MyKaizen'));
	    } else {
	        echo $this->upload->display_errors();
	        exit();
	    }
	}

	public function LihatF4($kaizen_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $kaizen_id);
		$kaizenId = $this->encrypt->decode($plaintext_string);

		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Kaizen Akuntansi';
		$data['Header']			=	'Kaizen Akuntansi';
		$data['Menu'] 			= 	'My Kaizen';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kaizen'] = $this->M_kaizenakuntansi->getKaizenByKaizenId($kaizenId);
		$data['thread'] = $this->M_kaizenakuntansi->getThreadByKaizenId($kaizenId);
		if ($data['kaizen'][0]['komponen']) {
				$arrayKomponen = explode(';', $data['kaizen'][0]['komponen']);
				foreach ($arrayKomponen as $key => $value) {
					$dataItem = $this->M_kaizenakuntansi->getMasterItem(FALSE,$value);
					$kodeItem = $dataItem[0]['SEGMENT1'];
					$namaItem = $dataItem[0]['ITEM_NAME'];
					$komponen[] = $aa = array('id' => $value, 'code' => $kodeItem, 'name' => $namaItem);
				}

				$data['kaizen'][0]['komponen'] = $komponen;
			}

		$data['section_user'] = $this->M_kaizenakuntansi->getSectAll($data['kaizen'][0]['pencetus_noind']);		

		if (strpos($data['kaizen'][0]['kondisi_awal'], '<img') !== FALSE) {
			$data['kaizen'][0]['kondisi_awal'] = str_replace('<img', '<br><img class="img img-responsive"', $data['kaizen'][0]['kondisi_awal']);
		} else {
			$data['kaizen'][0]['kondisi_awal'] = $data['kaizen'][0]['kondisi_awal'];
		}
		if (strpos($data['kaizen'][0]['usulan_kaizen'], '<img') !== FALSE) {
			$data['kaizen'][0]['usulan_kaizen'] = str_replace('<img', '<br><img class="img img-responsive"', $data['kaizen'][0]['usulan_kaizen']);
		} else {
			$data['kaizen'][0]['usulan_kaizen'] = $data['kaizen'][0]['usulan_kaizen'];
		}
		if (strpos($data['kaizen'][0]['pertimbangan'], '<img') !== FALSE) {
			$data['kaizen'][0]['pertimbangan'] = str_replace('<img', '<br><img class="img img-responsive"', $data['kaizen'][0]['pertimbangan']);
		} else {
			$data['kaizen'][0]['pertimbangan'] = $data['kaizen'][0]['pertimbangan'];
		}
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemIntegration/MainMenu/KaizenAkuntansi/V_LihatF4',$data);
		$this->load->view('V_Footer',$data);
	}

	public function HapusF4($kaizen_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $kaizen_id);
		$kaizenId = $this->encrypt->decode($plaintext_string);

		$kaizen = $this->M_kaizenakuntansi->getKaizenByKaizenId($kaizenId);
		$nama = $this->session->employee;
		$noind = $this->session->user;
		$judul = $kaizen[0]['judul'];
		$data = array(
			'komponen' 			=> null,
			'kondisi_awal' 		=> null,
			'usulan_kaizen' 	=> null,
			'pertimbangan' 		=> null,
			'tanggal_realisasi' => null,
			'status' 			=> 'Create Ide',
			'judul'				=> null
		);
		$this->M_kaizenakuntansi->updateKaizenByKaizenId($data,$kaizenId);

		$thread = array(
			'kaizen_id' => $kaizenId,
			'status' 	=> 'F4 Sudah di Hapus',
			'detail' 	=> '(F4 Sudah di Hapus) '.$noind.' - '.trim($nama).' telah menghapus F4 kaizen dengan judul '.$judul
		);

		$this->M_kaizenakuntansi->insertThreadKaizen($thread);
		redirect(base_url('SystemIntegration/KaizenAkt/MyKaizen'));
	}

	public function EditF4($kaizen_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $kaizen_id);
		$kaizenId = $this->encrypt->decode($plaintext_string);

		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Kaizen Akuntansi';
		$data['Header']			=	'Kaizen Akuntansi';
		$data['Menu'] 			= 	'Submit Kaizen';
		$data['SubMenuOne'] 	= 	'Submit F4';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kaizen'] = $this->M_kaizenakuntansi->getKaizenByKaizenId($kaizenId);
		// echo "<pre>";print_r($data['kaizen']);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemIntegration/MainMenu/KaizenAkuntansi/V_SubmitF4',$data);
		$this->load->view('V_Footer',$data);
	}

	public function PengajuanHapusIde($kaizen_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $kaizen_id);
		$kaizenId = $this->encrypt->decode($plaintext_string);

		$kaizen = $this->M_kaizenakuntansi->getKaizenByKaizenId($kaizenId);
		$nama = $this->session->employee;
		$noind = $this->session->user;
		$ide = $kaizen[0]['ide'];
		$data = array(
			'komponen' 			=> null,
			'kondisi_awal' 		=> null,
			'usulan_kaizen' 	=> null,
			'pertimbangan' 		=> null,
			'tanggal_realisasi' => null,
			'status' 			=> 'Pengajuan Hapus Ide',
			'judul'				=> null
		);
		$this->M_kaizenakuntansi->updateKaizenByKaizenId($data,$kaizenId);

		$thread = array(
			'kaizen_id' => $kaizenId,
			'status' 	=> 'Pengajuan Hapus Ide',
			'detail' 	=> '(Pengajuan Hapus Ide) '.$noind.' - '.trim($nama).' telah mengajukan penghapusan ide kaizen '.$ide
		);

		$this->M_kaizenakuntansi->insertThreadKaizen($thread);
		redirect(base_url('SystemIntegration/KaizenAkt/MyKaizen'));
	}

	public function BatalPengajuanHapusIde($kaizen_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $kaizen_id);
		$kaizenId = $this->encrypt->decode($plaintext_string);

		$kaizen = $this->M_kaizenakuntansi->getKaizenByKaizenId($kaizenId);
		$nama = $this->session->employee;
		$noind = $this->session->user;
		$ide = $kaizen[0]['ide'];
		$data = array(
			'komponen' 			=> null,
			'kondisi_awal' 		=> null,
			'usulan_kaizen' 	=> null,
			'pertimbangan' 		=> null,
			'tanggal_realisasi' => null,
			'status' 			=> 'Create Ide',
			'judul'				=> null
		);
		$this->M_kaizenakuntansi->updateKaizenByKaizenId($data,$kaizenId);

		$thread = array(
			'kaizen_id' => $kaizenId,
			'status' 	=> 'Batal Pengajuan Hapus Ide',
			'detail' 	=> '(Batal Pengajuan Hapus Ide) '.$noind.' - '.trim($nama).' telah membatalkan pengajuan hapus ide kaizen '.$ide
		);

		$this->M_kaizenakuntansi->insertThreadKaizen($thread);
		redirect(base_url('SystemIntegration/KaizenAkt/MyKaizen'));
	}

	public function ListPengajuanHapusIde(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'List Pengajuan Hapus Ide';
		$data['Header']			=	'List Pengajuan Hapus Ide';
		$data['Menu'] 			= 	'List Pengajuan Hapus Ide';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kaizen'] = $this->M_kaizenakuntansi->getKaizenByStatus('Pengajuan Hapus Ide');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemIntegration/MainMenu/KaizenAkuntansi/V_ListPengajuanHapusIde',$data);
		$this->load->view('V_Footer',$data);
	}

	public function HapusIde($kaizen_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $kaizen_id);
		$kaizenId = $this->encrypt->decode($plaintext_string);

		$kaizen = $this->M_kaizenakuntansi->getKaizenByKaizenId($kaizenId);
		$nama = $this->session->employee;
		$noind = $this->session->user;
		$ide = $kaizen[0]['ide'];
		$data = array(
			'komponen' 			=> null,
			'kondisi_awal' 		=> null,
			'usulan_kaizen' 	=> null,
			'pertimbangan' 		=> null,
			'tanggal_realisasi' => null,
			'status' 			=> 'Hapus Ide',
			'judul'				=> null
		);
		$this->M_kaizenakuntansi->updateKaizenByKaizenId($data,$kaizenId);

		$thread = array(
			'kaizen_id' => $kaizenId,
			'status' 	=> 'Hapus Ide',
			'detail' 	=> '(Hapus Ide) '.$noind.' - '.trim($nama).' telah menghapus ide kaizen '.$ide
		);

		$this->M_kaizenakuntansi->insertThreadKaizen($thread);
		redirect(base_url('SystemIntegration/KaizenAkt/ListPengajuanHapusIde'));
	}
}

?>