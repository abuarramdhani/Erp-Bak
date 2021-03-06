<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class C_Paramedik extends CI_Controller
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

	public function index()
	{
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;


		$data['Title'] = 'Approval Paramedik';
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

		$data['list'] = $this->M_index->GetIzinPribadiPerPekerja("WHERE ip.jenis_ijin = '2' AND ip.appr_atasan = 't'");
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PerizinanPribadi/Paramedik/V_Paramedik_Index.php', $data);
		$this->load->view('V_Footer', $data);
	}

	public function approve()
	{
		$user = $this->session->userdata('user');
		$id = $this->input->post('id');
		$keterangan = $this->input->post('ket');

		$arr = array(
			'paramedik' => $user,
			'appr_paramedik' => 't',
			'tgl_appr_paramedik' => date('Y-m-d H:i:s'),
			'ket_sakit' => ucwords(rtrim($keterangan)),
		);
		$this->M_index->updateTizin($id, $arr);
		$this->kirimEmailAtasan($id);
		redirect('PerizinanPribadi/PSP/ApproveParamedik');
	}

	public function reject()
	{
		$user = $this->session->userdata('user');
		$id = $this->input->post('id');
		$keterangan = $this->input->post('ket');
		$arr = array(
			'paramedik' => $user,
			'appr_paramedik' => 'f',
			'tgl_appr_paramedik' => date('Y-m-d H:i:s'),
			'ket_sakit' => ucwords(rtrim($keterangan)),
		);
		$this->M_index->updateTizin($id, $arr);
		redirect('PerizinanPribadi/PSP/ApproveParamedik');
	}

	function kirimEmailAtasan($id)
	{
		$detail = $this->M_index->GetIzinbyId($id)->row_array();
		$ket = $detail['ket_sakit'];
		$tanggal = $detail['created_date'];
		$wkt_keluar = $detail['wkt_keluar'];
		$daftarNama = $detail['noind'] . ' - ' . $detail['nama_pkj'];
		$atasan = $detail['email_internal'];
		$nama_atasan = $detail['nama_atasan'];
		$keputusan_paramedik = $detail['appr_paramedik'] == 't' ? 'menyetujui' : 'menolak';

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
		$mail->addAddress($atasan);
		$subject = "New!!! Hasil Diagnosa Pekerja Sakit";
		$body = "Hi " . $nama_atasan . ",
				<br>Memberitahukan bahwa paramedik " . $keputusan_paramedik . " permohonan izin pekerja dengan detail sbb :
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

		$mail->Subject = $subject;
		$mail->msgHTML($body);

		// check error
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		}
	}
}
