<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_splkasie extends CI_Controller {
	function __construct() {
        parent::__construct();

        $this->load->library('session');

		$this->load->model('SPLSeksi/M_splseksi');
		$this->load->model('SPLSeksi/M_splkasie');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		date_default_timezone_set('Asia/Jakarta');
    }

    public function checkSession(){
		if($this->session->is_logged){
			// any
		}else{
			redirect('');
		}
	}

    public function menu($a, $b, $c){
    	$this->checkSession();
    	$user_id = $this->session->userid;

		$data['Menu'] = $a;
		$data['SubMenuOne'] = $b;
		$data['SubMenuTwo'] = $c;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		return $data;
    }

    public function index(){
		$data = $this->menu('', '', '');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/Kasie/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function data_spl(){
		$user = $this->session->user;
		$filter = array("username" => $user);
		$data_confirm = $this->M_splkasie->show_confirm($filter);

		if(empty($data_confirm)){
			$data = $this->menu('', '', '');
			$data['lokasi'] = $this->M_splseksi->show_lokasi();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SPLSeksi/Kasie/V_data_spl',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$this->confirm_spl();
		}
	}

	public function cut_kodesie($id){
		$z = 0;
		for($x=-1; $x>=-strlen($id); $x--){
			if(substr($id, $x, 1) == "0"){
				$z++;
			}else{
				break;
			}
		}

		$data = substr($id, 0, strlen($id)-$z);
		return $data;
	}

	public function data_spl_filter(){
		$user = $this->session->user;
		$dari = $this->input->post('dari');
		$dari = date_format(date_create($dari), "Y-m-d");
		$sampai = $this->input->post('sampai');
		$sampai = date_format(date_create($sampai), "Y-m-d");
		$status = $this->input->post('status');
		$lokasi = $this->input->post('lokasi');
		$noind = $this->input->post('noind');
		$kodesie = $this->input->post('kodesie');

		// get akses seksi
		$akses_sie = array();
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach($akses_kue as $ak){
			$akses_sie[] = $this->cut_kodesie($ak['kodesie']);
			foreach($akses_spl as $as){
				$akses_sie[] = $this->cut_kodesie($as['kodesie']);
			}
		}
		
		$data_spl = array();
		$show_list_spl = $this->M_splkasie->show_spl($dari, $sampai, $status, $lokasi, $noind, $akses_sie, $kodesie);
		foreach($show_list_spl as $sls){
			$index = array();
			
			if($sls['Status'] == "01"){
				$index[] = '<input type="checkbox" name="splid[]" 
					value="'.$sls['ID_SPL'].'" style="width:20px; height:20px; vertical-align:bottom;">';
			}else{
				$index[] = "";
			}

			$index[] = $sls['Tgl_Lembur'];
			$index[] = $sls['Noind'];
			$index[] = $sls['nama'];
			$index[] = $sls['kodesie'];
			$index[] = $sls['seksi'];
			$index[] = $sls['Pekerjaan'];
			$index[] = $sls['nama_lembur'];
			$index[] = $sls['Jam_Mulai_Lembur'];
			$index[] = $sls['Jam_Akhir_Lembur'];
			$index[] = $sls['Break'];
			$index[] = $sls['Istirahat'];
			$index[] = $sls['target'];
			$index[] = $sls['realisasi'];
			$index[] = $sls['alasan_lembur'];
			$index[] = $sls['Deskripsi']." ".$sls['User_'];
			$index[] = $sls['Tgl_Berlaku'];
			
			$data_spl[] = $index;
		}
		echo json_encode($data_spl);
	}

	public function data_spl_submit(){
		$user = $this->session->user;
		$namae = $this->session->employee;
		$id = $this->input->post('splid');

		if(!empty($id)){
			$splid = "";
			foreach($id as $id){
				$splid .= $id.", ";
			}
			$pass = uniqid();

			$data_email = $this->M_splkasie->show_email_addres($user);
			if(!empty($data_email)){
				$addres = $data_email->address;
				$this->send_email($addres, $namae, $pass);
			}

			$data_splr = array(
				"username" => $user,
				"password" => $pass,
				"spl_id" => $splid);
			$to_splr = $this->M_splkasie->save_confirm($data_splr);

			redirect(base_url('ALK/ConfLembur'));
		}else{
			redirect(base_url('ALK/ListLembur'));
		}
	}

	public function confirm_spl(){
		$data = $this->menu('', '', '');
		$result = $this->input->get('result');
		if(!empty($result) && $result==1){
			$data['result'] = array("callout-success", "Succes!", "Data berhasil di proses");
		}elseif(!empty($result) && $result==0){
			$data['result'] = array("callout-warning", "Error!", "Pastikan data yang anda masukkan benar");
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/Kasie/V_confirm_spl',$data);
		$this->load->view('V_Footer',$data);
	}

	public function confirm_spl_submit(){
		$user = $this->session->user;
		$pass = $this->input->post('passcode');
		$status = $this->input->post('approve');
		$keterangan = $this->input->post('keterangan');

		$filter = array("username" => $user, "password" => $pass);
		$data_confirm = $this->M_splkasie->show_confirm($filter);

		if(!empty($data_confirm)){
			$spl_id = explode(", ", $data_confirm->spl_id);
			foreach($spl_id as $si){
				$data_spl = $this->M_splseksi->show_current_spl('', '', '', $si);

				foreach($data_spl as $ds){
					// Generate ID Riwayat
					$maxid = $this->M_splseksi->show_maxid("splseksi.tspl_riwayat", "ID_Riwayat");
					if(empty($maxid)){
						$splr_id = "0000000001";
					}else{
						$splr_id = $maxid->id;	
						$splr_id = substr("0000000000", 0, 10-strlen($splr_id)).$splr_id;
					}

					// Approv or Cancel
					if($status == "21"){
						$log_jenis = "Approve";
						$spl_ket = $keterangan." (Approve By Kasie)";
					}else{
						$log_jenis = "Cancel";
						$spl_ket = $keterangan." (Cancel By Kasie)";
					}

					// Insert data
					$log_ket = "Noind:".$ds['Noind']." Tgl:".$ds['Tgl_Lembur']." Kd:".$ds['Kd_Lembur'].
						" Jam:".$ds['Jam_Mulai_Lembur']."-".$ds['Jam_Akhir_Lembur']." Break:".$ds['Break'].
						" Ist:".$ds['Istirahat']." Pek:".$ds['Pekerjaan']."<br />";

					$data_log = array(
						"wkt" => date('Y-m-d H:i:s'),
						"menu" => "Kasie",
						"jenis" => $log_jenis,
						"ket" => $log_ket,
						"noind" => $user);
					$to_log = $this->M_splseksi->save_log($data_log);

					$data_spl = array(
						"Tgl_Berlaku" => date('Y-m-d H:i:s'),
						"Status" => $status,
						"User_" => $user);
					$to_spl = $this->M_splseksi->update_spl($data_spl, $si);
					
					$data_splr = array(
						"ID_Riwayat" => $splr_id,
						"ID_SPL" => $si,
						"Tgl_Berlaku" => date('Y-m-d H:i:s'),
						"Tgl_Tdk_Berlaku" => date('Y-m-d H:i:s'),
						"Tgl_Lembur" => $ds['Tgl_Lembur'],
						"Noind" => $ds['Noind'],
						"Noind_Baru" => "0000000",
						"Kd_Lembur" => $ds['Kd_Lembur'],
						"Jam_Mulai_Lembur" => $ds['Jam_Mulai_Lembur'],
						"Jam_Akhir_Lembur" => $ds['Jam_Akhir_Lembur'],
						"Break" => $ds['Break'],
						"Istirahat" => $ds['Istirahat'],
						"Pekerjaan" => $ds['Pekerjaan'],
						"Status" => $status,
						"User_" => $user,
						"Revisi" => "0",
						"Keterangan" => $spl_ket,
						"target" => $ds['target'],
						"realisasi" => $ds['realisasi'],
						"alasan_lembur" => $ds['alasan_lembur']);
					$to_splr = $this->M_splseksi->save_splr($data_splr);
				}
			}

			$drop_confirm = $this->M_splkasie->drop_confirm($user);
			redirect(base_url('ALK/ConfLembur?result=1'));
		}else{
			redirect(base_url('ALK/ConfLembur?result=0'));
		}
	}

	public function send_email($addres, $user, $subjec) {
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
			'allow_self_signed' => true));
        $mail->Username = 'no-reply@quick.com';
        $mail->Password = '123456';
        $mail->WordWrap = 50;
		
        // set email content
        $mail->setFrom('no-reply@quick.com', 'Email Sistem');
        $mail->addAddress($addres);
        $mail->Subject = "Approval Lembur Kasie";

		$mail->msgHTML('
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://wwwhtml4/loose.dtd"> 				
			<html>
				<head> 			 	
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> 			  	
					<title>Mail Generated By System</title>
				</head> 				
				<body>
					Kepada Yth Bpk/Ibu '.$user.'<br><br>

					Passcode verifikasi approval lembur anda adalah <b> '.$subjec.' </b><br/><br/>

					Terimakasih, <br/><br/><br/>
					<b style="text-decoration: underline;">Pengelola</b>
					<h6><i>(Pesan ini dibentuk otomatis oleh System.)</i></h6>
				</body> 				
			</html>');
		
		if(!$mail->send()){
			echo "Mailer Error: " . $mail->ErrorInfo;
		}else{
			//echo "Message sent!";
		}
	}


}