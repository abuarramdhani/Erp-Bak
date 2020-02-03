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
		$this->load->library('upload');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PerizinanDinas/AtasanApproval/M_index');

		$this->checkSession();
		date_default_timezone_set("Asia/Jakarta");
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
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
		$data['Menu'] = 'Perizinan Dinas';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$datamenu = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		if ($no_induk == 'B0898' || $no_induk == 'B0720' || $no_induk == 'B0819' || $no_induk == 'B0697' || $no_induk == 'B0696' || $no_induk == 'J1293' || $no_induk == 'B0307') {
			if($no_induk == 'B0898' || $no_induk == 'B0720' || $no_induk == 'B0819'){
				$data['UserMenu'] = $datamenu;
			}else {
				unset($datamenu[1]);
				$data['UserMenu'] = $datamenu;
			}
		}else {
			unset($datamenu[1]);
			unset($datamenu[2]);
			$data['UserMenu'] = $datamenu;
		}

		$data['izin'] = $this->M_index->GetIzin($no_induk);
		$data['IzinApprove'] = $this->M_index->IzinApprove($no_induk);
		$data['IzinUnApprove'] = $this->M_index->IzinUnApprove($no_induk);
		$data['IzinReject'] = $this->M_index->IzinReject($no_induk);

		$today = date('Y-m-d');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PerizinanDinas/AtasanApproval/V_Index',$data);
		$this->load->view('V_Footer',$data);

	}

	public function update()
	{
		$status = $this->input->post('keputusan');
		$idizin = $this->input->post('id');
		$data['cekizin'] = $this->M_index->cekIzin($idizin);
		$tanggal = date('d F Y', strtotime($data['cekizin'][0]['created_date']));
		$ket = $data['cekizin'][0]['keterangan'];
		$berangkat = $data['cekizin'][0]['berangkat'];
		$nama = explode(', ', $data['cekizin'][0]['noind']);
		$getnama = array();
		foreach ($nama as $key) {
			$getnama[] = $this->M_index->pekerja($key);
		}

		$update= $this->M_index->update($status, $idizin);

		if ($status == 1) {
			$no = '0';
			$tujuan = $this->M_index->getTujuanMakan($idizin);
			$updatePekerja = $this->M_index->updatePekerja($no, $idizin);

			if (date('H:i:s') >= '09:30:00') {
				for ($i=0; $i < count($nama); $i++) {
					for ($j=0; $j < count($tujuan) ; $j++) {
						if ($nama[$i] == $tujuan[$j]['noind']) {
							$data = array(
								'izin_id'	=> $idizin,
								'noinduk' 	=> $nama[$i],
								'tujuan' => $tujuan[$j]['tujuan'],
								'created_date' => date('Y-m-d H:i:s')
							);
							$insert = $this->M_index->taktual_izin($data);
						}
					}
				}
			}else {
				for ($i=0; $i < count($nama); $i++) {
					$data = array(
						'izin_id'	=> $idizin,
						'noinduk' 	=> $nama[$i],
						'created_date' => date('Y-m-d H:i:s')
					);
					$insert = $this->M_index->taktual_izin($data);
				}
			}
			$this->EmailAlertAll($getnama, $status, $idizin, $tanggal, $ket, $berangkat);
		}elseif ($status == 2) {
			$no = '5';
			$updatePekerja = $this->M_index->updatePekerja($no, $idizin);
			$this->EmailAlertAll($getnama, $status, $idizin, $tanggal, $ket, $berangkat);
			redirect('PerizinanDinas/AtasanApproval');
		}else{
			redirect('PerizinanDinas/AtasanApproval');
		}
	}

	public function editPekerjaDinas()
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
		$keterangan = $this->input->post('ket');
		$tanggal = date('d F Y');
		$berangkat = $this->input->post('keluar');
		$implode = implode("', '", $pekerja);
		$implode1 = implode(", ", $pekerja);

		$place = '';
		$getpekerja = $this->M_index->getTujuanMakan($id);
		$noinde = array_column($getpekerja, 'noind');
		$result = array_diff($noinde, $pekerja);

		$get = implode("','", $pekerja);
		$get1 = implode("','", $result);
		$getnamaApprove = $this->M_index->pekerja($get);
		$getnamareject = $this->M_index->pekerja($get1);

		if (!empty($result)) {
			foreach ($result as $key) {
				$update2_tpekerja_izin = $this->M_index->updatePekerjaBerangkat($key, '5', $id);
			}
		}

		foreach ($pekerja as $key) {
			$update_tpekerja_izin = $this->M_index->updatePekerjaBerangkat($key, '0', $id);
		}

		if ($pekerja > 1) {
			$place = $this->M_index->getTujuan($id, $implode, true);
			$place1 = array_column($place, 'tujuan');
			$imPlace = implode(", ", $place1);
			$update_tperizinan = $this->M_index->update_tperizinan($implode1, '1', $id, $imPlace);
		}else {
			$place = $this->M_index->getTujuan($id, $pekerja, false);
			$place1 = array_column($place, 'tujuan');
			$update_tperizinan = $this->M_index->update_tperizinan($pekerja, '1', $id, $place1);
		}

		if (date('H:i:s') <= '09:30:00') {
			for ($i=0; $i < count($pekerja); $i++) {
				$newEmployee = $this->M_index->getDataPekerja($pekerja[$i], $id);
					if ($pekerja[$i] == $newEmployee[0]['noind']) {
						$data = array(
							'izin_id'	=> $id,
							'noinduk' 	=> $pekerja[$i],
							'tujuan' => $newEmployee[0]['tujuan'],
							'created_date' => date('Y-m-d H:i:s')
						);
						$insert = $this->M_index->taktual_izin($data);
					}
			}
		}else {
			for ($i=0; $i < count($pekerja); $i++) {
				$data = array(
					'izin_id'	=> $id,
					'noinduk' 	=> $pekerja[$i],
					'created_date' => date('Y-m-d H:i:s')
				);
				$insert = $this->M_index->taktual_izin($data);
			}
		}

		$this->EmailAlert($noinde, $getnamaApprove, $getnamareject, $id, $tanggal, $keterangan, $berangkat);
	}

	public function EmailAlert($noinde, $pekerja, $pekerja1, $id, $tanggal, $keterangan, $berangkat) {
		//email
		$newArr = '<table style="border: 1px solid black; border-collapse: collapse;"><th style="border: 1px solid black; text-align: center">No. Induk<th style="border: 1px solid black; border-collapse: collapse; text-align: center">Nama<th>Status</th>';

		foreach ($pekerja as $key) {
			$newArr .= '<tr><td style="border: 1px solid black; border-collapse: collapse;">'.$key['noind'].'<td style="border: 1px solid black;">'.$key['nama'].'<td style="border: 1px solid black; border-collapse: collapse;"><a style="color: green">Approve</a></td>';
		}
		foreach ($pekerja1 as $key) {
			$newArr .= '<tr><td style="border: 1px solid black; border-collapse: collapse;">'.$key['noind'].'<td style="border: 1px solid black;">'.$key['nama'].'<td style="border: 1px solid black; border-collapse: collapse;"><a style="color: red">Reject</a></td>';
		}
		$newArr .= '</table>';

		foreach ($noinde as $key) {
			$imel = $this->M_index->getImel($key);
			$nama = $this->M_index->pekerja($key);

			$subject = "New!!! Konfirmasi Perizinan Dinas";
			$body = "Hi ".$nama[0]['nama'].",
			<br>Izin Dinas dengan id : $id telah diperiksa oleh atasan, berikut detailnya :
			<br>
			<br>$newArr
			<br><b>Tanggal &emsp;&emsp;:</b> $tanggal
			<br>
			<br><b>Keperluan &nbsp;&nbsp;:</b> $keterangan
			<br>
			<br><b>Jam Berangkat &nbsp;:</b> $berangkat WIB";

			//send Email
			$this->load->library('PHPMailerAutoload');
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
					'allow_self_signed' => true)
				);
				$mail->Username = 'no-reply';
				$mail->Password = '123456';
				$mail->WordWrap = 50;

				// set email content
				$mail->setFrom('no-reply@quick.com', 'Email Sistem');
				$mail->addAddress('rosyidatun_nur_r@quick.com');
				$mail->Subject = $subject;
				$mail->msgHTML($body);

				// check error
				if (!$mail->send()) {
					echo "Mailer Error: ".$mail->ErrorInfo;
					exit();
				}
		}

	}

	public function EmailAlertAll($noinde, $jenis, $id, $tanggal, $keterangan, $berangkat) {
		//email
		$newArr = '<table style="border: 1px solid black; border-collapse: collapse;"><th style="border: 1px solid black; text-align: center">No. Induk<th style="border: 1px solid black; border-collapse: collapse;">Nama<th>Status</th>';

			if ($jenis == '1') {
				foreach ($noinde as $key) {
					$newArr .= '<tr><td style="border: 1px solid black; border-collapse: collapse;">'.$key[0]['noind'].'<td style="border: 1px solid black;">'.$key[0]['nama'].'<td style="border: 1px solid black; border-collapse: collapse;"><a style="color: green">Approve</a></td>';
				}
			}else if($jenis == '2') {
				foreach ($noinde as $key) {
					$newArr .= '<tr><td style="border: 1px solid black; border-collapse: collapse;">'.$key[0]['noind'].'<td style="border: 1px solid black;">'.$key[0]['nama'].'<td style="border: 1px solid black; border-collapse: collapse;"><a style="color: red">Reject</a></td>';
				}
			}
			$newArr .= '</table>';

			foreach ($noinde as $key) {
			$imel = $this->M_index->getImel($key);
			$nama = $this->M_index->pekerja($key);

			$subject = "New!!! Konfirmasi Perizinan Dinas";
			$body = "Hi ".$key[0]['nama'].",
			<br>Izin Dinas dengan id : $id telah diperiksa oleh atasan, berikut detailnya :
			<br>
			<br>$newArr
			<br><b>Tanggal &emsp;&emsp;:</b> $tanggal
			<br>
			<br><b>Keperluan &nbsp;&nbsp;:</b> $keterangan
			<br>
			<br><b>Jam Berangkat &nbsp;:</b> $berangkat WIB";

			//send Email
			$this->load->library('PHPMailerAutoload');
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
					'allow_self_signed' => true)
				);
				$mail->Username = 'no-reply';
				$mail->Password = '123456';
				$mail->WordWrap = 50;

				// set email content
				$mail->setFrom('no-reply@quick.com', 'Email Sistem');
				$mail->addAddress('rosyidatun_nur_r@quick.com');
				$mail->Subject = $subject;
				$mail->msgHTML($body);

				// check error
				if (!$mail->send()) {
					echo "Mailer Error: ".$mail->ErrorInfo;
					exit();
				}
		}

	}

}
?>
