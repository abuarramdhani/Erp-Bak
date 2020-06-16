<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class C_WebPatroli extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');
		$this->load->library('KonversiBulan');
		$this->load->model('PatroliSatpam/M_patrolis');

		if(strpos(current_url(), 'qrcode_patroli') === false)
		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user_id = $this->session->userid;

		$data  = $this->general->loadHeaderandSidemenu('Patroli Satpam', 'Patroli Satpam', '', '', '');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Hardware/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function slokasi()
	{
		$user_id = $this->session->userid;

		$data  = $this->general->loadHeaderandSidemenu('Patroli Satpam', 'Setting Lokasi', 'Setting', 'Lokasi', '');
		$data['ask'] = $this->M_patrolis->getAll_pertanyaan();
		$data['lokasi'] = $this->M_patrolis->getAllPos();
		$data['lokasi_json'] = json_encode($this->M_patrolis->getAllPos());
		// echo "<pre>";
		// print_r($data['lokasi_json']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PatroliSatpam/Web/V_Setting_Lokasi',$data);
		$this->load->view('V_Footer',$data);
	}
	public function spertanyaan()
	{
		$user_id = $this->session->userid;
		$data  = $this->general->loadHeaderandSidemenu('Patroli Satpam', 'Setting Pertanyaan', 'Setting', 'Pertanyaan', '');
		$data['ask'] = $this->M_patrolis->getAll_pertanyaan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PatroliSatpam/Web/V_Setting_Pertanyaan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function addask()
	{
		$pertanyaan = $this->input->post('pertanyaan');
		$arr = array('pertanyaan'=>$pertanyaan);
		$ins = $this->M_patrolis->insertPertanyaan($arr);
		if ($ins) 
			redirect('PatroliSatpam/web/spertanyaan');
		else
			echo "Insert data failed!";
	}

	public function delask()
	{
		$id = $this->input->get('id');
		$del = $this->M_patrolis->hapusPertanyaan($id);
		if ($del) 
			redirect('PatroliSatpam/web/spertanyaan');
		else
			echo "Delete data failed!";
	}

	public function upask()
	{
		$id = $this->input->post('id');
		$pertanyaan = $this->input->post('pertanyaan');
		$arr = array(
			'pertanyaan' => $pertanyaan,
			);
		$up = $this->M_patrolis->updatePertanyaan($arr, $id);
		if ($up) 
			redirect('PatroliSatpam/web/spertanyaan');
		else
			echo "Update data failed!";
	}

	public function add_lokasi()
	{
		$user_id = $this->session->userid;
		$data  = $this->general->loadHeaderandSidemenu('Patroli Satpam', 'Tambah Lokasi', 'Setting', 'Lokasi', '');
		$data['ask'] = $this->M_patrolis->getAll_pertanyaan();
		$data['lokasi_json'] = json_encode($this->M_patrolis->getAllPos());
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PatroliSatpam/Web/V_Add_Lokasi',$data);
		$this->load->view('V_Footer',$data);
	}

	public function save_lokasi()
	{
		echo "<pre>";
		print_r($_POST);
		$lokasi = $this->input->post('lokasi');
		$lat = $this->input->post('lat');
		$long = $this->input->post('long');
		$list_pertanyaan = implode(',', $this->input->post('ask'));
		$id = $this->M_patrolis->getIdTitik();
		$data = array(
				'id'				=>	$id,
				'lokasi'			=>	$lokasi,
				'latitude'			=>	$lat,
				'longitude'			=>	$long,
				'list_pertanyaan'	=>	$list_pertanyaan,
			);

		$ins = $this->M_patrolis->insertTitik($data);
		if ($ins)
			redirect('PatroliSatpam/web/slokasi');
	}

	public function update_lokasi()
	{
		echo "<pre>";
		print_r($_POST);
		// exit();
		$lokasi = $this->input->post('lokasi');
		$lat = $this->input->post('lat');
		$long = $this->input->post('long');
		$id = $this->input->post('id');
		$list_pertanyaan =  implode(',', $this->input->post('pertanyaan'));
		$data = array(
				'lokasi'			=>	$lokasi,
				'latitude'			=>	$lat,
				'longitude'			=>	$long,
				'list_pertanyaan'	=>	$list_pertanyaan,
			);
		$up = $this->M_patrolis->updateTitik($data, $id);
		if ($up)
			redirect('PatroliSatpam/web/slokasi');
	}

	public function dellokasi()
	{
		$id = $this->input->get('id');
		$del = $this->M_patrolis->deleteLoaksi($id);
		if ($del) {
			redirect('PatroliSatpam/web/slokasi');
		}
	}

	public function rekap_data()
	{
		$user_id = $this->session->userid;
		$data  = $this->general->loadHeaderandSidemenu('Patroli Satpam', 'Rekap Data', 'Rekap', 'Rekap Harian', '');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PatroliSatpam/Web/V_Rekap_Data',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getAllPkjTpribadi()
	{
		$noind = strtoupper($this->input->get('s'));
		$pkj = $this->M_patrolis->getPekerjaTpribadi($noind);
		echo json_encode($pkj);
	}

	public function get_rekap_data()
	{
		$pr = $this->input->post('pr');
		$pr = explode(' - ', $pr);
		$pkj = $this->input->post('pkj');
		$data = $this->M_patrolis->getRekapDataHarian($pr, $pkj);
		$x = 1;
		$arr = array();
		foreach ($data as $key) {
			$i1 = $x;
			$i2 = $key['noind'].' - '.$key['nama'];
			$i3 = $key['ronde'];
			$i4 = $key['pos'];
			$i5 = $key['tgl_shift'];
			$i6 = $key['tgl_patroli'];
			$i7 = $key['latitude'].', '.$key['longitude'];
			$i8	= $this->vincentyGreatCircleDistance($key['latitude'], $key['longitude'], $key['lat_asli'], $key['long_asli']);
			$i9 = '<a title="Google Map" target="_blank" href="https://www.google.com/maps/search/?api=1&query='.$key['latitude'].','.$key['longitude'].'" class="btn btn-success"><i class="fa fa-map-marker"></i></a>';
			$x++;
			$arr[] = array($i1, $i2, $i3, $i4, $i5, $i6, $i7, $i8);
		}
		echo json_encode($arr);
	}

	/**
    * Calculates the great-circle distance between two points, with
    * the Vincenty formula.
    * @param float $latitudeFrom Latitude of start point in [deg decimal]
    * @param float $longitudeFrom Longitude of start point in [deg decimal]
    * @param float $latitudeTo Latitude of target point in [deg decimal]
    * @param float $longitudeTo Longitude of target point in [deg decimal]
    * @param float $earthRadius Mean earth radius in [m]
    * @return float Distance between points in [m] (same as earthRadius)
    */
	public static function vincentyGreatCircleDistance(
		$latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
	{
  		// convert from degrees to radians
		$latFrom = deg2rad($latitudeFrom);
		$lonFrom = deg2rad($longitudeFrom);
		$latTo = deg2rad($latitudeTo);
		$lonTo = deg2rad($longitudeTo);

		$lonDelta = $lonTo - $lonFrom;
		$a = pow(cos($latTo) * sin($lonDelta), 2) +
		pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
		$b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

		$angle = atan2(sqrt($a), $b);
		return round($angle * $earthRadius, 2);
	}

	public function rekap_bulanan()
	{
		$user_id = $this->session->userid;
		$data  = $this->general->loadHeaderandSidemenu('Patroli Satpam', 'Rekap Bulanan', 'Rekap', 'Rekap Bulanan', 'Cetak Laporan');
		$data['list'] = $this->M_patrolis->getTrekapJenis(1);
		// echo "<pre>";
		// print_r($data['list']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PatroliSatpam/Web/V_Rekap_Bulanan_Laporan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function add_rekap_bulanan()
	{
		$user_id = $this->session->userid;
		$data  = $this->general->loadHeaderandSidemenu('Patroli Satpam', 'Rekap Bulanan', 'Rekap', 'Rekap Bulanan', 'Cetak Laporan');
		$data['jenis'] = 'laporan';
		$pr = $this->input->get('pr');
		$data['periode'] = '';
		$data['reon'] = '';
		if (strlen($pr) == 7) {
			$pr = explode('-', $pr);
			$data['periode'] = $pr[1].' - '.$pr[0];
			$data['reon'] = 'readonly';
			$data['id'] = $this->input->get('id');;
		}
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PatroliSatpam/Web/V_Rekap_Bulanan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function add_rekap_temuan()
	{
		$user_id = $this->session->userid;
		$data  = $this->general->loadHeaderandSidemenu('Patroli Satpam', 'Rekap Bulanan', 'Rekap', 'Rekap Bulanan', 'Cetak Temuan');
		$data['jenis'] = 'temuan';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PatroliSatpam/Web/V_Rekap_Bulanan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function rekap_temuan()
	{
		$user_id = $this->session->userid;
		$data  = $this->general->loadHeaderandSidemenu('Patroli Satpam', 'Rekap Bulanan', 'Rekap', 'Rekap Bulanan', 'Cetak Temuan');
		$data['list'] = $this->M_patrolis->getTrekapJenis(2);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PatroliSatpam/Web/V_Rekap_Bulanan_Temuan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function cetak_laporan()
	{
		$user = $this->session->user;
		// print_r($user);exit();
		$pr = $this->input->post('periodeR');
		$id = $this->input->post('id');
		if (strlen($pr) != 9) {
			echo "periode not valid";
			exit();
		}
		$getID = $this->M_patrolis->getRekapID();
		if (!empty($id)) {
			$getID = $id;
		}
		$filename = 'Cetak_Laporan_patroli_Satpam_'.$getID.'.pdf';
		$expr = explode(' - ', $pr);
		$arr = array(
				'id'			=>	$getID,
				'periode'		=>	$expr[1].'-'.$expr[0],
				'jenis'			=>	1,
				'filename'		=>	$filename,
				'create_date'	=>	date('Y-m-d H:i:s'),
				'create_by'		=>	$user,
			);
		if (!empty($id)) {
			$this->M_patrolis->upCetakan($arr, $id);
		}else{
			$this->M_patrolis->insCetakan($arr);
		}
		$pr = explode(' - ', $pr);
		$periode_db = $pr[1].'-'.$pr[0];
		$last = date('t', strtotime($pr[1].'-'.$pr[0].'-01'));
		$awal = date('Y-m-d', strtotime($pr[1].'-'.$pr[0].'-01'));
		$akhir = date('Y-m-t', strtotime($pr[1].'-'.$pr[0].'-01'));
		for ($i=1; $i <= $last; $i++) { 
			$x = (strlen($i) == 1) ? '0'.$i:$i;
			$tgl = $pr[1].'-'.$pr[0].'-'.$x;
			$data['list'][] = $this->M_patrolis->getKolomRekap($tgl);
			$data['satpam'][] = $this->M_patrolis->getSatpambyShift($tgl);
		}
		$data['max'] = count($this->M_patrolis->getAllPos());
		$data['last'] = $last;
		$data['month'] = date('m', strtotime($pr[1].'-'.$pr[0].'-01'));
		$data['year'] = date('y', strtotime($pr[1].'-'.$pr[0].'-01'));
		$data['fullyear'] = date('Y', strtotime($pr[1].'-'.$pr[0].'-01'));
		$bulan = date('F', strtotime($pr[1].'-'.$pr[0].'-01'));
		$data['bulan'] = $this->konversibulan->KonversiKeBulanIndonesia($bulan);
		$data['kesimpulan'] = $this->M_patrolis->getKesimpulanbyId($periode_db);
		$data['putaran'] = $this->M_patrolis->getPutaranperLok($awal, $akhir);

		// echo "<pre>";
		// print_r($data['putaran']);exit();

		$this->load->library('Pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8',array(210,330), 7,'',5,5,5,5,0,0,'L');
		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
		$html = $this->load->view('PatroliSatpam/Web/V_Cetak_Laporan', $data, true);

		// $pdf->WriteHTML($stylesheet);
		$pdf->WriteHTML($html);
		$pdf->Output('assets/upload/PatroliSatpam/Cetakan/'.$filename, 'F');
		// $pdf->Output($filename, 'I');
		redirect('PatroliSatpam/web/patroli_read_file?id='.$getID);
	}

	public function patroli_read_file()
	{
		$id = $this->input->get('id');
		$kolomFile = $this->M_patrolis->getRekapbyID($id);
		$filenya = $kolomFile[0]['filename'];
		// exit();
		$file = './assets/upload/PatroliSatpam/Cetakan/'.$filenya;
		$filename = 'Cetak_Laporan_patroli_Satpam_.pdf'; /* Note: Always use .pdf at the end. */
		// echo $filename;exit();

		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' . $filename . '"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($file));
		header('Accept-Ranges: bytes');

		@readfile($file);
	}

	public function get_kesimpulan()
	{
		$pr = $this->input->get('pr');
		if (strlen($pr) != 9) {
			echo "periode not valid";
			exit();
		}
		$pr = explode(' - ', $pr);
		$pr = $pr[1].'-'.$pr[0];
		$data = $this->M_patrolis->getKesimpulanbyId($pr);
		$arr = array();
		$x=1;
		foreach ($data as $key) {
			$a1 = $x;
			$a2 = $key['kesimpulan'];
			$a3 = '<button type="button" value="'.$key['id'].'" class="btn btn-primary pts_btnUpKs">
					<i class="fa fa-edit"></i>
					</button>
					<button type="button" value="'.$key['id'].'" class="btn btn-danger pts_btnDelKs">
					<i class="fa fa-trash"></i>
					</button>';
			$arr[] = array($a1, $a2, $a3);
			$x++;
		}
		echo json_encode($arr);
	}

	public function add_kesimpulan()
	{
		$pr = $this->input->post('pr');
		$pr = explode(' - ', $pr);
		$pr = $pr[1].'-'.$pr[0];
		$isi = $this->input->post('isi');

		$arr = array('periode' => $pr, 'kesimpulan'	=>	$isi);
		$add = $this->M_patrolis->ins_kesimpulan($arr);
		if ($add) {
			echo json_encode(true);
		}
	}

	public function del_kesimpulan()
	{
		$id = $this->input->post('id');
		$del = $this->M_patrolis->hapusKesimpulan($id);
		if ($del) {
			echo json_encode(true);
		}
	}

	public function up_kesimpulan()
	{
		$id = $this->input->post('idnya');
		$kes = $this->input->post('kesimpulan');
		$arr = array('kesimpulan' => $kes);
		$up = $this->M_patrolis->upkesimpulan($arr, $id);
		if ($up) {
			echo json_encode(true);
		}
	}

	public function cetak_temuan()
	{
		$user = $this->session->user;
		$this->load->library('Pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8',array(210,330), 7,'',5,5,5,5,0,0,'P');
		$pdf->allow_charset_conversion = true;
		// $pdf->showImageErrors = true;
		$pdf->charset_in = 'iso-8859-4';
		$range = $this->input->post('tgl');
		if (strlen($range) < 10) {
			echo "tanggal not valid";
			exit();
		}
		$getID = $this->M_patrolis->getRekapID();
		$filename = 'Cetak_Temuan_patroli_Satpam_'.$getID.'.pdf';
		$expr = explode(' - ', $pr);
		$arr = array(
				'id'			=>	$getID,
				'periode'		=>	$range,
				'jenis'			=>	2,
				'filename'		=>	$filename,
				'create_date'	=>	date('Y-m-d H:i:s'),
				'create_by'		=>	$user,
			);
		$this->M_patrolis->insCetakan($arr);
		$pr = explode(' - ', $range);
		$pr[1] = date('Y-m-d', strtotime($pr[1].'+1 day'));

		$data['max'] = count($this->M_patrolis->getAllPos());
		$data['st'] = 1;
		$begin = new DateTime($pr[0]);
		$end = new DateTime($pr[1]);

		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);

		foreach ($period as $dt) {
			$tgl = $dt->format("Y-m-d");
			echo $tgl;
			$data['tanggal'] = $tgl;

			$jawaban = $this->M_patrolis->getJawabanCT($tgl);
			$arr = array();
			foreach ($jawaban as $key) {
				$posn = $key['pos'];
				$arr[$posn]['pos'] = $posn; //value pos dan indexnya akan sama
				if(empty($arr[$posn]['pertanyaan']))
					$arr[$posn]['pertanyaan'] = $key['ask'];

				$arr[$posn]['jawaban'.$key['ronde']] = explode(',', $key['jawaban']);
			}
		
			$data['jawaban'] = $arr;
			$data['temuan'] = $this->M_patrolis->getTemuanCT($tgl);
			$data['temuan'] = array_column($data['temuan'], 'deskripsi', 'pos');
			$data['file'] = $this->M_patrolis->getAttachCT($tgl);
			$data['file'] = array_column($data['file'], 'nama_file', 'pos');
			$pertanyaan = $this->M_patrolis->getAll_pertanyaan();
			$data['pertanyaan'] = array_column($pertanyaan, 'pertanyaan', 'id_pertanyaan');
			// echo "<pre>";
			// print_r($data['jawaban']);exit();

			$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
			$html = $this->load->view('PatroliSatpam/Web/V_Cetak_Temuan', $data, true);
			$pdf->WriteHTML($html);
			// break;
		}
		// exit();
		$pdf->Output('assets/upload/PatroliSatpam/Cetakan/'.$filename, 'F');
		// $pdf->Output($filename, 'I');
		redirect('PatroliSatpam/web/patroli_read_file?id='.$getID);
	}

	public function get_map_id()
	{
		$data['id'] = $this->input->post('id');
		$data['lokasi_json'] = json_encode($this->M_patrolis->getAllPos());
		$view = $this->load->view('PatroliSatpam/Web/V_Rekap_Map', $data);
		echo json_encode($view);
	}

	public function del_rekap_file()
	{
		$id = $this->input->post('id');
		$del = $this->M_patrolis->delTrekap($id);

		if($del)
			return true;
	}

	public function cek_cetak_laporan()
	{
		$pr = $this->input->get('pr');
		$pr = explode(' - ', $pr);
		$periode_db = $pr[1].'-'.$pr[0];
		$cek = $this->M_patrolis->getRekapbyPeriode($periode_db)->result_array();

		if (!empty($cek)) {
			$data['ada'] = true;
		}else{
			$data['ada'] = false;
		}
		echo json_encode($data);
	}

	public function cetak_qr_patroli()
	{
		$id = $this->input->get('id');
		$lk = $this->M_patrolis->getPosbyId($id);
		$data['kode']= $lk[0]['lokasi'];
		$data['pos']= $lk[0]['id'];
		// echo $data['qr'];exit();
		$this->load->library('Pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8',array(100,130), 7,'',5,5,5,5,0,0,'P');
		$pdf->curlAllowUnsafeSslRequests = true;
		$pdf->allow_charset_conversion = true;
		// $pdf->showImageErrors = true;
		$pdf->debug = true;
		$pdf->charset_in = 'iso-8859-4';
		$filename = 'Patroli Qrcode.pdf';
		$html = $this->load->view('PatroliSatpam/Web/V_Cetak_Qrcode', $data, true);
		// echo $html;
		// exit();
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'I');
	}

	public function qrcode_patroli($kode='')
	{
		header("Content-Type: image/png");
		$this->load->library('ciqrcode');
		if (empty($kode)) {
			$kode = $this->input->get('kode');
		}
		$params['data'] = $kode;
		$params['size'] = 1024;
		$params['level'] = 'H';
	    $this->ciqrcode->generate($params);
	}
}