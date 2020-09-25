<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
date_default_timezone_set('Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_SimForklift extends CI_Controller
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
		$this->load->model('MasterPekerja/Other/SimForklift/M_simforklift');

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

		$data['Title']			=	'SIM Forklift';
		$data['Menu'] 			= 	'Lain-lain';
		$data['SubMenuOne'] 	= 	'SIM Forklift';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_simforklift->getSimForkliftAll();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Other/SimForklift/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function tambah(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'SIM Forklift';
		$data['Menu'] 			= 	'Lain-lain';
		$data['SubMenuOne'] 	= 	'SIM Forklift';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Other/SimForklift/V_Tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function cariPekerja($noind = FALSE){
		if ($noind == FALSE) {
			$key = $this->input->get('term');
			$data = $this->M_simforklift->getPekerjaByKey($key);
		}else{
			$data = $this->M_simforklift->getPekerjaByNoind($noind);
		}
		echo json_encode($data);
	}

	public function simpan(){
		$noind	= $this->input->post('noind');
		$nama	= $this->input->post('nama');
		$seksi	= $this->input->post('seksi');
		$jenis	= $this->input->post('jenis');
		$awal	= $this->input->post('awal'); 
		$akhir	= $this->input->post('akhir');

		$awal = "1 ".$awal;
		$akhir = "1 ".$akhir;

		$data = array(
			'noind' => $noind,
			'nama' => $nama,
			'seksi' => $seksi,
			'jenis' => $jenis,
			'mulai_berlaku' => $awal,
			'selesai_berlaku' => $akhir,
			'file_pdf' => '',
			'file_image' => '',
			'file_corel' => '',
			'created_by' => $this->session->user,
		);
		$this->M_simforklift->insertSimForklift($data);
		echo "sukses";
	}

	public function cetakpdf(){
		$id = $this->input->get('data');
		$pekerja = array();
		foreach ($id as $key) {
			$pekerja[] = $this->M_simforklift->getSimForkliftById($key);
		}
		
		$data['pekerja'] = $pekerja;
		$pdf = $this->pdf->load();
	    $pdf = new mPDF('utf-8', 'F4-L', 12, '', 5, 5, 5, 5, 5, 5);
	    $filename = 'SIM_FORKLIFT'.'.pdf';
	    $html = $this->load->view('MasterPekerja/Other/SimForklift/V_Pdf', $data, true);
	    $pdf->WriteHTML($html);
	    $pdf->Output($filename, 'I');
	}

	public function cetakimg(){
		$id = $this->input->get('data');
		$pekerja = array();
		foreach ($id as $key) {
			$pekerja[] = $this->M_simforklift->getSimForkliftById($key);
		}
		// Create the size of image or blank image 
		$jumlah_pekerja = count($pekerja);
		$jumlah_samping = 5;
		if ($jumlah_pekerja > $jumlah_samping) {
			$lebar = 204 * $jumlah_samping;
			$tinggi = ceil($jumlah_pekerja/$jumlah_samping)*648;
		}else{
			$lebar = 204 * $jumlah_pekerja;
			$tinggi = 648;
		}

		$image = imagecreatetruecolor($lebar, $tinggi); 
		
		$bulan = array(
			1 => 'Januari',
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
			'Desember'
		);

		// Set the background color of image 
		$background_color = imagecolorallocate($image, 0, 153, 0); 
		  
		// Set the text color of image 
		$text_front_utama = imagecolorallocate($image, 255, 255, 255); 
		$text_front_cadangan = imagecolorallocate($image, 255, 255, 0); 
		$text_back_black = imagecolorallocate($image, 0, 0, 0); 
		$text_back_white = imagecolorallocate($image, 255, 255, 255); 
		  
		// Function to create image which contains string. 
		for ($i=0; $i < ceil($jumlah_pekerja/$jumlah_samping); $i++) { 
			$coor_y = $i * 648;
			for ($j=($jumlah_samping*$i); $j < ($jumlah_samping*$i) + $jumlah_samping; $j++) { 
				if (isset($pekerja[$j])) {
					$data = $pekerja[$j];
					if ($data->jenis == "Utama") {
						$front = imagecreatefrompng(base_url('assets/img/SimForklift/front_utama.png'));
						$text_color = $text_front_utama;
					}elseif ($data->jenis == "Cadangan") {
						$front = imagecreatefrompng(base_url('assets/img/SimForklift/front_cadangan.png'));
						$text_color = $text_front_cadangan;
					}
					$photo = imagecreatefromjpeg($data->photo);
					imagecopyresized(
						$image, 
						$front, 
						(($j-($jumlah_samping*$i)) * 204), 
						$coor_y, 
						0, 
						0, 
						204, 
						324,
						imagesx($front), 
						imagesy($front)					
					);
					imagecopyresized(
						$image, 
						$photo,
						34 + (($j-($jumlah_samping*$i)) * 204), 
						30 + $coor_y, 
						0, 
						0, 
						135,
						180, 
						imagesx($photo), 
						imagesy($photo)
					);
					imagestring(
						$image, 
						5, 
						10 + (($j-($jumlah_samping*$i)) * 204), 
						210 + $coor_y,  
						$data->nama, 
						$text_color
					); 
					imagestring(
						$image, 
						5, 
						10 + (($j-($jumlah_samping*$i)) * 204), 
						230 + $coor_y,  
						$data->noind, 
						$text_color
					); 
					imagestring(
						$image, 
						5, 
						10 + (($j-($jumlah_samping*$i)) * 204), 
						250 + $coor_y,  
						$data->seksi, 
						$text_color
					); 
					
				}
				
			}
			for ($j=($jumlah_samping*$i); $j < ($jumlah_samping*$i) + $jumlah_samping; $j++) { 
				if (isset($pekerja[$j])) {
					$data = $pekerja[$j];
					$text_white = $text_back_white;
					$text_black = $text_back_black;
					$back = imagecreatefrompng(base_url('assets/img/SimForklift/back.png'));
					$barcode = imagecreatefrompng(base_url('assets/plugins/barcode.php?size=60&text='.$data->noind));
					$photo = imagecreatefromjpeg($data->photo);
					imagecopyresized(
						$image, 
						$back, 
						(($j-($jumlah_samping*$i)) * 204), 
						$coor_y + 324, 
						0, 
						0, 
						204, 
						324,
						imagesx($front), 
						imagesy($front)					
					);
					imagecopyresized(
						$image, 
						$barcode,
						28 + (($j-($jumlah_samping*$i)) * 204), 
						260 + $coor_y + 324, 
						0, 
						0, 
						150,
						40, 
						imagesx($barcode), 
						imagesy($barcode)
					);
					imagestring(
						$image, 
						5, 
						50 + (($j-($jumlah_samping*$i)) * 204), 
						60 + $coor_y + 324,  
						"SIM FORKLIFT", 
						$text_white
					); 
					imagestring(
						$image, 
						2, 
						15 + (($j-($jumlah_samping*$i)) * 204), 
						78 + $coor_y + 324,  
						"SURAT IJIN MENGEMUDI FORKLIFT", 
						$text_white
					); 
					imagestring(
						$image, 
						5, 
						80 + (($j-($jumlah_samping*$i)) * 204), 
						300 + $coor_y + 324,  
						$data->noind, 
						$text_black
					);  
					imagestring(
						$image, 
						3, 
						10 + (($j-($jumlah_samping*$i)) * 204), 
						100 + $coor_y + 324,  
						"KETENTUAN:", 
						$text_black
					); 
					imagestring(
						$image, 
						2, 
						10 + (($j-($jumlah_samping*$i)) * 204), 
						115 + $coor_y + 324,  
						"1. SIM harus dibawa dan", 
						$text_black
					); 
					imagestring(
						$image, 
						2, 
						30 + (($j-($jumlah_samping*$i)) * 204), 
						130 + $coor_y + 324,  
						"dikenakan di depan saku", 
						$text_black
					); 
					imagestring(
						$image, 
						2, 
						30 + (($j-($jumlah_samping*$i)) * 204), 
						145 + $coor_y + 324,  
						"pada saat mengemudikan", 
						$text_black
					); 
					imagestring(
						$image, 
						2, 
						30 + (($j-($jumlah_samping*$i)) * 204), 
						160 + $coor_y + 324,  
						"forklift.", 
						$text_black
					); 
					imagestring(
						$image, 
						2, 
						10 + (($j-($jumlah_samping*$i)) * 204), 
						175 + $coor_y + 324,  
						"2. SIM tidak boleh dipinjamkan /", 
						$text_black
					); 
					imagestring(
						$image, 
						2, 
						30 + (($j-($jumlah_samping*$i)) * 204), 
						190 + $coor_y + 324,  
						"digunakan orang lain.", 
						$text_black
					); 
					imagestring(
						$image, 
						2, 
						32 + (($j-($jumlah_samping*$i)) * 204), 
						215 + $coor_y + 324,  
						"Yogyakarta, ".$bulan[intval(date('m',strtotime($data->mulai_berlaku)))].' '.date('Y',strtotime($data->mulai_berlaku)), 
						$text_black
					); 
					imagestring(
						$image, 
						2, 
						140 + (($j-($jumlah_samping*$i)) * 204), 
						230 + $coor_y + 324,  
						"TIM UP2L", 
						$text_black
					); 
					imagestring(
						$image, 
						2, 
						10 + (($j-($jumlah_samping*$i)) * 204), 
						245 + $coor_y + 324,  
						"Berlaku: s/d ".$bulan[intval(date('m',strtotime($data->selesai_berlaku)))].' '.date('Y',strtotime($data->selesai_berlaku)), 
						$text_black
					); 
					
				}
				
			}
		}
		  
		header("Content-Type: image/png"); 
		  
		imagepng($image); 
		imagedestroy($image); 
	}

	public function cetakcrl(){
		echo "<pre>";
		print_r($_GET);
	}

}

?>