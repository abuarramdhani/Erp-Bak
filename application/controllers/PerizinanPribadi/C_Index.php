<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Index extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PerizinanPribadi/M_index');
		$this->load->model('ADMSeleksi/M_penyerahan');

		$this->checkSession();
		date_default_timezone_set("Asia/Jakarta");
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if ($this->session->is_logged) {
		} else {
			redirect('');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;

		$data['Title'] = 'Approve Atasan';
		$data['Menu'] = 'Perizinan Pribadi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$datamenu = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$aksesRahasia = $this->M_index->allowedAccess('1');
		$paramedik = array_column($aksesRahasia, 'noind');

		$admin_hubker = $this->M_index->allowedAccess('2');
		$admin_hubker = array_column($admin_hubker, 'noind');

		if (in_array($no_induk, $paramedik)) {
			$data['UserMenu'] = $datamenu;
		} elseif (in_array($no_induk, $admin_hubker)) {
			unset($datamenu[0]);
			unset($datamenu[1]);
			$data['UserMenu'] = array_values($datamenu);
		} else {
			unset($datamenu[1]);
			unset($datamenu[2]);
			unset($datamenu[3]);
			$data['UserMenu'] = array_values($datamenu);
		}

		$today = date('Y-m-d');

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PerizinanPribadi/V_Index', $data);
		$this->load->view('V_Footer', $data);
	}

	public function index1()
	{
		//alur di approve IKP,
		// tizin_pribadi && tizin_pribadi_detail
		// status - baru insert, ditampilkan un approve
		// status 1 approve
		// status 2 reject
		// status 3 keluar_ikp

		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;

		$data['Title'] = 'Approve Atasan';
		$data['Menu'] = 'Perizinan Pribadi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$datamenu = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$paramedik = $this->M_index->allowedAccess('1');
		$paramedik = array_column($paramedik, 'noind');

		$admin_hubker = $this->M_index->allowedAccess('2');
		$admin_hubker = array_column($admin_hubker, 'noind');

		if (in_array($no_induk, $paramedik)) {
			$data['UserMenu'] = $datamenu;
		} elseif (in_array($no_induk, $admin_hubker)) {
			unset($datamenu[0]);
			unset($datamenu[1]);
			$data['UserMenu'] = array_values($datamenu);
		} else {
			unset($datamenu[1]);
			unset($datamenu[2]);
			unset($datamenu[3]);
			$data['UserMenu'] = array_values($datamenu);
		}

		$data['nama'] = $this->M_index->getAllNama();
		$data['izin'] = $this->M_index->GetIzin($no_induk, '');
		$data['IzinPribadi'] = $this->M_index->GetIzin($no_induk, '1');
		$data['IzinSakit'] = $this->M_index->GetIzin($no_induk, '2');
		$data['IzinDinas'] = $this->M_index->GetIzin($no_induk, '3');

		$today = date('Y-m-d');

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PerizinanPribadi/V_IKP', $data);
		$this->load->view('V_Footer', $data);
	}

	public function update()
	{
		$status = $this->input->post('keputusan');
		$idizin = $this->input->post('id');
		$keputusan = ($status) ? '1' : '2';
		$this->M_index->update($status, $idizin, $keputusan);
		$this->M_index->updateTizinPribadiDetail($idizin, $keputusan);

		$cek_izin = $this->M_index->getPekerjaEdit($idizin);
		if ($cek_izin[0]['jenis_ijin'] == '2' && $keputusan == '1') {
			$this->kirimEmailParamedik($idizin);
		}

		redirect('IKP/ApprovalAtasan');
	}

	public function editPekerjaIKP()
	{
		$id = $this->input->post('id');

		$pekerja = $this->M_index->getPekerjaEdit($id);
		echo json_encode($pekerja);
	}

	public function updatePekerja()
	{
		$id = $this->input->post('id');
		$jenis = $this->input->post('jenis');
		$pekerja = $this->input->post('pekerja');
		$implode = implode("', '", $pekerja);
		$implode1 = implode(", ", $pekerja);

		$getpekerja = $this->M_index->getPekerja($id);
		$noinde = array_column($getpekerja, 'noind');
		$result = array_diff($noinde, $pekerja);
		$diserahkan = $this->M_index->getSerahkan($implode, $id);
		$ar = array();
		foreach ($diserahkan as $key) {
			if (!empty($key['diserahkan'])) {
				$ar[] = $key['diserahkan'];
			} else {
				$ar[] = '-';
			}
		}

		$imserahkan = implode(", ", $ar);

		if (!empty($result)) {
			foreach ($result as $key) {
				$update2_tpekerja_izin = $this->M_index->updatePekerjaBerangkat($key, '2', $id);
			}
		}

		foreach ($pekerja as $key) {
			$update_tpekerja_izin = $this->M_index->updatePekerjaBerangkat($key, '1', $id);
		}

		if ($pekerja > 1) {
			$update_tperizinan = $this->M_index->update_tperizinan($implode1, '1', $id, $imserahkan);
		} else {
			$update_tperizinan = $this->M_index->update_tperizinan($pekerja, '1', $id, $imserahkan);
		}
	}

	function kirimEmailParamedik($id)
	{
		$detail = $this->M_index->GetIzinbyId($id)->row_array();
		$ket = $detail['keperluan'];
		$tanggal = $detail['created_date'];
		$wkt_keluar = $detail['wkt_keluar'];
		$daftarNama = $detail['noind'] . ' - ' . $detail['nama_pkj'];

		$this->load->library('PHPMailerAutoload');

		//send Email
		$mail = new PHPMailer();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';

		// set smtp
		$mail->isSMTP();
		$mail->Host = 'm.quick.com';
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		$mail->Username = 'no-reply';
		$mail->Password = '123456';
		$mail->WordWrap = 50;

		// set email content
		$mail->setFrom('no-reply@quick.com', 'Email Sistem');
		$emailUser = $this->M_index->emailParamedik();
		foreach ($emailUser as $key) {
			$mail->addAddress($key['email_internal']);
			$subject = "New!!! Approval Izin Sakit Perusahaan";
			$body = "Hi " . $key['nama'] . ",
				<br>Anda mendapat permintaan approve paramedik dengan detail sbb :
				<br>
				<br>
				<table>
					<tr>
						<td style='width: 100px;'><b>ID Izin</b></td>
						<td>:</td>
						<td>$id</td>
					</tr>
					<tr>
						<td style='width: 100px;'><b>Tanggal</b></td>
						<td>:</td>
						<td>$tanggal</td>
					</tr>
					<tr>
						<td style='width: 100px;'><b>Pekerja</b></td>
						<td>:</td>
						<td>$daftarNama</td>
					</tr>
					<tr>
						<td style='width: 100px;'><b>Keterangan</b></td>
						<td>:</td>
						<td>$ket</td>
					</tr>
					<tr>
						<td style='width: 100px;'><b>Keluar</b></td>
						<td>:</td>
						<td>$wkt_keluar</td>
					</tr>
				</table>
				<br><br>
				<hr>
				<br>untuk melihat/ merespon izin ini, silahkan <a href='http://erp.quick.com/IKP/ApprovalAtasan'>login</a> ke ERP";
		}

		$mail->Subject = $subject;
		$mail->msgHTML($body);

		// check error
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		}
	}

	//untuk rekap kritik dan saran

	public function indexSaran()
	{
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;

		$data['Title'] = 'Rekap Kritik dan Saran';
		$data['Menu'] = 'Perizinan Pribadi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$datamenu = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$aksesRahasia = $this->M_index->allowedAccess('1');
		$paramedik = array_column($aksesRahasia, 'noind');

		$admin_hubker = $this->M_index->allowedAccess('2');
		$admin_hubker = array_column($admin_hubker, 'noind');

		if (in_array($no_induk, $paramedik)) {
			$data['UserMenu'] = $datamenu;
		} elseif (in_array($no_induk, $admin_hubker)) {
			unset($datamenu[0]);
			unset($datamenu[1]);
			$data['UserMenu'] = array_values($datamenu);
		} else {
			unset($datamenu[1]);
			unset($datamenu[2]);
			unset($datamenu[3]);
			$data['UserMenu'] = array_values($datamenu);
		}

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PerizinanPribadi/V_RekapSaran', $data);
		$this->load->view('V_Footer', $data);
	}

	public function tempelSaran()
	{
		$tanggal = $_GET['tanggal'];
		$jenis   = $_GET['valButton'];
		$noind   = $this->session->user;
		$kd_sie  = $this->session->kodesie;
		$nama    = $this->M_index->getNamaByNoind($noind);
		$seksi   = $this->M_penyerahan->getJabatanPreview($kd_sie);

		if (!empty($tanggal)) {
			$explode = explode(" - ", $tanggal);
			$tanggal_awal = str_replace("/", '-', $explode[0]);
			$tanggal_akhir = str_replace("/", '-', $explode[1]);
			$tgl_awal = date('Y-m-d', strtotime($tanggal_awal));
			$tgl_akhir = date('Y-m-d', strtotime($tanggal_akhir));
			$param = "where created_date::date between '$tgl_awal' and '$tgl_akhir'";
			$param2 = "and tpi.created_date::date between '$tgl_awal' and '$tgl_akhir'";
			$data['data'] = $this->M_index->getRekapSaran($param, $param2);
		} else {
			$data['data'] = $this->M_index->getRekapSaran();
		}

		if ($jenis == 'Excel') {
			$this->load->library("Excel");
			$this->load->view('PerizinanPribadi/V_ExcelSaran', $data);
		} elseif ($jenis == 'PDF') {
			if (empty($tanggal)) {
				$tanggal = "All Periode";
			} else {
				if ($tgl_awal == $tgl_akhir) {
					$tanggal = date('d F Y', strtotime($tgl_awal));
				} else {
					$tanggal = date('d/m/Y', strtotime($tgl_awal)) . ' - ' . date('d/m/Y', strtotime($tgl_akhir));
				}
			}
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', 'A4-P', 10, 8, 10, 10, 30, 15, 8, 20);
			$filename = 'Rekap Kritik dan Saran.pdf';

			$html = $this->load->view('PerizinanPribadi/V_PDFSaran', $data, true);
			$pdf->setHTMLHeader('
				<table width="100%">
					<tr>
						<td width="50%"><h2><b>Rekap Kritik dan Saran Perizinan</b></h2></td>
						<td style="text-align: right;"><h5>Dicetak Oleh ' . $noind . ' - ' . $nama . ' pada Tanggal ' . date('d M Y H:i:s') . '</h5></td>
					</tr>
                    <tr>
						<td>Periode tarik : ' . $tanggal . '</td>
						<td style="text-align: right;"><h5>Seksi : ' . ucwords(mb_strtolower($seksi)) . '</h5></td>
					</tr>
				</table>
			');

			$pdf->WriteHTML($html, 2);
			$pdf->setTitle($filename);
			$pdf->Output($filename, 'I');
		} else {
			$html = $this->load->view('PerizinanPribadi/V_Saran', $data);
			echo json_encode($html);
		}
	}
}
