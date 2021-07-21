<?php 
defined('BASEPATH') or exit("No Direct Script Access Allowed");

/**
 * 
 */
class C_PresensiHariIni extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/DataPresensi/M_presensihariini');
		
	}

	function checkSession()
	{
		if (!$this->session->is_logged) redirect('');
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Title'] = 'Presensi Hari ini';
		$data['Header'] = 'Presensi Hari ini';
		$data['Menu'] = 'Data Presensi';
		$data['SubMenuOne'] = 'Presensi Hari ini';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_original'] = $this->M_presensihariini->getPresensiOriginalHariIni();
		$data['data_penyesuaian'] = $this->M_presensihariini->getPresensiPenyesuaianHariIni();
		
		$data['email'] = $this->M_presensihariini->getEmailPekerja($this->session->user);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/DataPresensi/PresensiHariIni/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function detail($params)
	{
		$data = $this->M_presensihariini->getPresensiDetail($params);
		echo json_encode($data);
	}

	public function Pusat()
	{
		$data['data_penyesuaian'] = $this->M_presensihariini->getPresensiPenyesuaianHariIni();
		// echo "page under maintenance";
		$this->load->view('MasterPresensi/DataPresensi/PresensiHariIni/V_Pusat',$data);
	}

	public function Tuksono()
	{
		$data['data_penyesuaian'] = $this->M_presensihariini->getPresensiPenyesuaianHariIni();
		// echo "page under maintenance";
		$this->load->view('MasterPresensi/DataPresensi/PresensiHariIni/V_Tuksono',$data);
	}

	public function updateData()
	{
		$data = $this->M_presensihariini->getPresensiPenyesuaianHariIni();
		$p_wfo 		= 0;
		$p_wfh		= 0;
		$p_off		= 0;
		$p_ttl		= 0;
		$p_fb_wfo	= 0;
		$p_fb_wfh	= 0;
		$p_fb_off	= 0;
		$p_fb_ttl	= 0;
		$p_nfb_wfo	= 0;
		$p_nfb_wfh	= 0;
		$p_nfb_off	= 0;
		$p_nfb_ttl	= 0;
		$p_ttl		= 0;
		$t_wfo		= 0;
		$t_wfh		= 0;
		$t_off		= 0;
		$t_ttl		= 0;
		$t_fb_wfo	= 0;
		$t_fb_wfh	= 0;
		$t_fb_off	= 0;
		$t_ttl		= 0;
		$waktu 		= date('Y-m-d H:i:s');
		
		if (isset($data) && !empty($data)) {
			foreach ($data as $key => $value) {
				if ($value['lokasi'] == "Pusat") {
					if ($value['jenis'] == "Fabrikasi") {
						$p_fb_wfo	= $value['jumlah_wfo'];
						$p_fb_wfh	= $value['jumlah_wfh'];
						$p_fb_off	= $value['jumlah_off'];
					}elseif($value['jenis'] = "Non Fabrikasi"){
						$p_nfb_wfo	= $value['jumlah_wfo'];
						$p_nfb_wfh	= $value['jumlah_wfh'];
						$p_nfb_off	= $value['jumlah_off'];
					}
				}elseif ($value['lokasi'] == "Tuksono") {
					if ($value['jenis'] == "Fabrikasi") {
						$t_fb_wfo	= $value['jumlah_wfo'];
						$t_fb_wfh	= $value['jumlah_wfh'];
						$t_fb_off	= $value['jumlah_off'];
					}
				}
			}
			$p_fb_ttl 	= $p_fb_wfo + $p_fb_wfh + $p_fb_off;
			$p_nfb_ttl 	= $p_nfb_wfo + $p_nfb_wfh + $p_nfb_off;
			$p_ttl		= $p_wfo + $p_wfh + $p_off;

			$t_fb_ttl 	= $t_fb_wfo + $t_fb_wfh + $t_fb_off;
			$t_ttl		= $t_wfo + $t_wfh + $t_off;
		}

		$result = array(
			'p_fb_wfo'	=> $p_fb_wfo,
			'p_fb_wfh'	=> $p_fb_wfh,
			'p_fb_off'	=> $p_fb_off,
			'p_fb_ttl'	=> $p_fb_ttl,
			'p_nfb_wfo'	=> $p_nfb_wfo,
			'p_nfb_wfh'	=> $p_nfb_wfh,
			'p_nfb_off'	=> $p_nfb_off,
			'p_nfb_ttl'	=> $p_nfb_ttl,
			'p_ttl'		=> $p_ttl,
			't_fb_wfo'	=> $t_fb_wfo,
			't_fb_wfh'	=> $t_fb_wfh,
			't_fb_off'	=> $t_fb_off,
			't_fb_ttl'	=> $t_fb_ttl,
			't_ttl'		=> $t_ttl,
			'waktu'		=> $waktu
		);
		echo json_encode($result);
	}

	public function sendEmail()
	{
		date_default_timezone_set('Asia/Jakarta');
		setlocale (LC_TIME, "id_ID.utf8");

		$filename = "PresensiHariIni_".date('Y-m-d H:i:s')."_".($this->session->user).".xls";
		$data = $this->M_presensihariini->getDatDdetailExcel();
		$this->load->library('excel');
		$excel = $this->excel;
		$excel->setActiveSheetIndex(0);
		$objexcel = $excel->getActiveSheet();

		$objexcel->setCellValue('A1','No');
		$objexcel->setCellValue('B1','Dept');
		$objexcel->setCellValue('C1','Bidang');
		$objexcel->setCellValue('D1','Unit');
		$objexcel->setCellValue('E1','Seksi');
		$objexcel->setCellValue('F1','No. Induk');
		$objexcel->setCellValue('G1','Nama');
		$objexcel->setCellValue('H1','Waktu Absen');
		$objexcel->setCellValue('I1','Lokasi Absen');
		$objexcel->setCellValue('J1','Shift');
		$objexcel->setCellValue('K1','Lokasi Kerja');
		$objexcel->setCellValue('L1','Versi Original');
		$objexcel->setCellValue('M1','Versi Penyesuaian');
		$objexcel->setCellValue('N1','Status');

		if(!empty($data)){
			$row = 2;
			foreach($data as $key => $value){
				$objexcel->setCellValue('A'.($row),$key+1);
				$objexcel->setCellValue('B'.($row),$value['dept']);
				$objexcel->setCellValue('C'.($row),$value['bidang']);
				$objexcel->setCellValue('D'.($row),$value['unit']);
				$objexcel->setCellValue('E'.($row),$value['seksi']);
				$objexcel->setCellValue('F'.($row),$value['noind']);
				$objexcel->setCellValue('G'.($row),$value['nama']);
				$objexcel->setCellValue('H'.($row),$value['waktu']);
				$objexcel->setCellValue('I'.($row),$value['lokasi']);
				$objexcel->setCellValue('J'.($row),$value['shift']);
				$objexcel->setCellValue('K'.($row),$value['tempat']);
				$objexcel->setCellValue('L'.($row),$value['jenis_1']);
				$objexcel->setCellValue('M'.($row),$value['jenis_2']);
				$objexcel->setCellValue('N'.($row),$value['kategori']);
				$row++;
			}
		}

		$writer = PHPExcel_IOFactory::createWriter($excel,'Excel5');
		$writer->save(str_replace(__FILE__,'assets/generated/PresensiHariIni/'.$filename,__FILE__));

		$email = $this->input->post('email');

		$this->load->library('PHPMailerAutoload');

		$message = '<p>Bersama ini kami informasikan data absen '.date('Y-m-d H:i:s').'.</p>';

		$mail = new PHPMailer();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';

		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tls';
		$mail->Username = 'notification.hrd.khs1@gmail.com';
		$mail->Password = 'tes123123123';
		$mail->WordWrap = 50;
		$mail->setFrom('noreply@quick.co.id', 'Quick ERP Mobile');
		$mail->addAddress($email);
		$mail->Subject = 'Monitoring Absen '.date('Y-m-d H:i:s');
		$mail->msgHTML($message);
		$mail->AltBody = 'Data Absen';
		$mail->addAttachment('assets/generated/PresensiHariIni/'.$filename);
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "success";
		}
	}
}
?>