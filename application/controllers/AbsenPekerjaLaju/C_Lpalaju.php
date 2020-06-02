<?php Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');
/**
* 
*/
class C_Lpalaju extends CI_Controller
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
		$this->load->model('AbsenAtasan/M_absenatasan');
		$this->load->model('SystemIntegration/M_submit');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('AbsenPekerjaLaju/M_pekerjalaju');
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

		$data  = $this->general->loadHeaderandSidemenu('Absen Pekerja Laju', 'List Absensi pekerja Laju', 'List Absensi pekerja Laju', '', '');

		$employee = $this->session->employee;
		$nama = trim($employee);
		$noind = trim($this->session->user);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AbsenPekerjaLaju/ListAbsensiPekerjalaju/V_List_Lapl',$data);
		$this->load->view('V_Footer',$data);
	}

	public function detail($id){
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['dataEmployee'] = $this->M_absenatasan->getListAbsenById($id);

		$noinduk = $data['dataEmployee'][0]['noind'];

		$data['employeeInfo'] = $this->M_absenatasan->getEmployeeInfo($noinduk);
		// echo "<pre>";print_r($data['dataEmployee']);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AbsenPekerjaLaju/ListAbsensiPekerjalaju/V_Approval_Lapl',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ListPekerja(){
		/*

		$array_data = $this->M_absenatasan->getListabsLaju($noind,$nama);

		$list_data = array();
		foreach ($array_data as $key => $value) {
			$list_data[$key] = $value;
			$lokasi_kerja = $this->M_pekerjalaju->getLokasikerjaByNoind($value['noind']);
			$koordinat = $this->M_pekerjalaju->getKoordinatByLokasiKerja($lokasi_kerja->lokasi_kerja);
			$kantor = $koordinat->latitude.','.$koordinat->longitude;
			$rumah = $this->M_pekerjalaju->getKoordinatRumahByNoind($value['noind']);
			if ($value['jenis_absen'] == 'Pulang Kerja' || $value['jenis_absen'] == 'Masuk Kerja') {
				
				if ($value['jenis_absen'] == 'Pulang Kerja') {
					$waktu_barcode = $this->M_pekerjalaju->getAbsenBarcodePulang($value['noind'],$value['waktu']);
					$destination = $value['latitude'].','.$value['longitude'];
					$origin = $kantor;
					$origin_rumah = $destination;
					$destination_rumah = $rumah->latitude.','.$rumah->longitude;
				}elseif ($value['jenis_absen'] == 'Masuk Kerja') {
					$waktu_barcode = $this->M_pekerjalaju->getAbsenBarcodeDatang($value['noind'],$value['waktu']);
					$destination = $kantor;
					$origin = $value['latitude'].','.$value['longitude'];
					$origin_rumah = $rumah->latitude.','.$rumah->longitude;
					$destination_rumah = $origin;
				}

				if (!empty($waktu_barcode) && isset($waktu_barcode->waktu_barcode)) {
					$list_data[$key]['waktu_barcode'] = $waktu_barcode->waktu_barcode;
				}else{
					$list_data[$key]['waktu_barcode'] = "Tidak ada Absen Barcode";
				}
				
				$perkiraan_op = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins='.$origin.'&destinations='.$destination.'&key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw&traffic_model=optimistic&departure_time=now&language=id-ID');
				$hasil_op = json_decode($perkiraan_op);
				$perkiraan_pe = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins='.$origin.'&destinations='.$destination.'&key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw&traffic_model=pessimistic&departure_time=now&language=id-ID');
				$hasil_pe = json_decode($perkiraan_pe);
				$perkiraan = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins='.$origin.'&destinations='.$destination.'&key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw&departure_time=now&language=id-ID');
				$hasil = json_decode($perkiraan);
				$perkiraan_rumah = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins='.$origin_rumah.'&destinations='.$destination_rumah.'&key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw&departure_time=now&language=id-ID');
				$hasil_rumah = json_decode($perkiraan_rumah);
				// print_r($hasil_rumah);
				if ($hasil->status == "OK") {
					$rows = $hasil->rows;
					$row = $rows['0'];
					$elements = $row->elements;
					$element = $elements['0'];
					$duration = $element->duration;
					$distance = $element->distance;
					$duration_text = $duration->text;
					$duration_value = $duration->value;
					$distance_text = $distance->text;
					$distance_value = $distance->value;

					$list_data[$key]['waktu_normal_text'] = $duration_text;
					$list_data[$key]['waktu_normal_value'] = $duration_value;
					$list_data[$key]['jarak_normal_text'] = $distance_text;
					$list_data[$key]['jarak_normal_value'] = $distance_value;
				}else{
					$list_data[$key]['waktu_normal_text'] = "~";
					$list_data[$key]['waktu_normal_value'] = 0;
					$list_data[$key]['jarak_normal_text'] = "~";
					$list_data[$key]['jarak_normal_value'] = 0;
				}

				if ($hasil_rumah->status == "OK") {
					$rows_rumah = $hasil_rumah->rows;
					$row_rumah = $rows_rumah['0'];
					$elements_rumah = $row_rumah->elements;
					$element_rumah = $elements_rumah['0'];
					$duration_rumah = $element_rumah->duration;
					$distance_rumah = $element_rumah->distance;
					$duration_rumah_text = $duration_rumah->text;
					$duration_rumah_value = $duration_rumah->value;
					$distance_rumah_text = $distance_rumah->text;
					$distance_rumah_value = $distance_rumah->value;

					$list_data[$key]['waktu_rumah_text'] = $duration_rumah_text;
					$list_data[$key]['waktu_rumah_value'] = $duration_rumah_value;
					$list_data[$key]['jarak_rumah_text'] = $distance_rumah_text;
					$list_data[$key]['jarak_rumah_value'] = $distance_rumah_value;
				}else{
					$list_data[$key]['waktu_rumah_text'] = "~";
					$list_data[$key]['waktu_rumah_value'] = 0;
					$list_data[$key]['jarak_rumah_text'] = "~";
					$list_data[$key]['jarak_rumah_value'] = 0;
				}

				if ($hasil_pe->status == "OK") {
					$rows_pe = $hasil_pe->rows;
					$row_pe = $rows_pe['0'];
					$elements_pe = $row_pe->elements;
					$element_pe = $elements_pe['0'];
					$duration_in_traffic_pe = $element_pe->duration_in_traffic;
					$text_pe = $duration_in_traffic_pe->text;
					$value_pe = $duration_in_traffic_pe->value;

					$list_data[$key]['waktu_pesimis_text'] = $text_pe;
					$list_data[$key]['waktu_pesimis_value'] = $value_pe;
				}else{
					$list_data[$key]['waktu_pesimis_text'] = "~";
					$list_data[$key]['waktu_pesimis_value'] = 0;
				}

				if ($hasil_op->status == "OK") {
					$rows_op = $hasil_op->rows;
					$row_op = $rows_op['0'];
					$elements_op = $row_op->elements;
					$element_op = $elements_op['0'];
					$duration_in_traffic_op = $element_op->duration_in_traffic;
					$text_op = $duration_in_traffic_op->text;
					$value_op = $duration_in_traffic_op->value;

					$list_data[$key]['waktu_optimis_text'] = $text_op;
					$list_data[$key]['waktu_optimis_value'] = $value_op;
				}else{
					$list_data[$key]['waktu_optimis_text'] = "~";
					$list_data[$key]['waktu_optimis_value'] = 0;
				}

			}else{
				$list_data[$key]['waktu_barcode'] = "Tidak ada Absen Barcode";
				$list_data[$key]['jarak_normal_text'] = "~";
				$list_data[$key]['waktu_normal_value'] = 0;
				$list_data[$key]['waktu_normal_text'] = "~";
				$list_data[$key]['waktu_normal_value'] = 0;
				$list_data[$key]['jarak_rumah_text'] = "~";
				$list_data[$key]['jarak_rumah_value'] = 0;
				$list_data[$key]['waktu_rumah_text'] = "~";
				$list_data[$key]['waktu_rumah_value'] = 0;
				$list_data[$key]['waktu_pesimis_text'] = "~";
				$list_data[$key]['waktu_pesimis_value'] = 0;
				$list_data[$key]['waktu_optimis_text'] = "~";
				$list_data[$key]['waktu_optimis_value'] = 0;
			}

		}

		$data['listData'] = $list_data;

		*/

		$list = $this->M_pekerjalaju->user_table();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			
			$lokasi_kerja = $this->M_pekerjalaju->getLokasikerjaByNoind($key->noind);
			$koordinat = $this->M_pekerjalaju->getKoordinatByLokasiKerja($lokasi_kerja->lokasi_kerja);
			if (!empty($koordinat)) {
				$kantor = $koordinat->latitude.','.$koordinat->longitude;
			}else{
				$kantor = '-7.77465497,110.36132954';
			}
			$rumah = $this->M_pekerjalaju->getKoordinatRumahByNoind($key->noind);

			if ($key->jenis_absen == 'Pulang Kerja' || $key->jenis_absen == 'Masuk Kerja') {
				if ($key->jenis_absen == 'Pulang Kerja') {
					$waktu_barcode_array = $this->M_pekerjalaju->getAbsenBarcodePulang($key->noind,$key->waktu);
					$destination = $key->latitude.','.$key->longitude;
					$origin = $kantor;
					$origin_rumah = $destination;
					$destination_rumah = $rumah->latitude.','.$rumah->longitude;
				}elseif ($key->jenis_absen == 'Masuk Kerja') {
					$waktu_barcode_array = $this->M_pekerjalaju->getAbsenBarcodeDatang($key->noind,$key->waktu);
					$destination = $kantor;
					$origin = $key->latitude.','.$key->longitude;
					$origin_rumah = $rumah->latitude.','.$rumah->longitude;
					$destination_rumah = $origin;
				}

				if (!empty($waktu_barcode_array) && isset($waktu_barcode_array->waktu_barcode)) {
					$waktu_barcode = $waktu_barcode_array->waktu_barcode;
				}else{
					$waktu_barcode = "Tidak ada Absen Barcode";
				}

				$perkiraan_op = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins='.$origin.'&destinations='.$destination.'&key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw&traffic_model=optimistic&departure_time=now&language=id-ID');
				$hasil_op = json_decode($perkiraan_op);
				$perkiraan_pe = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins='.$origin.'&destinations='.$destination.'&key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw&traffic_model=pessimistic&departure_time=now&language=id-ID');
				$hasil_pe = json_decode($perkiraan_pe);
				$perkiraan = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins='.$origin.'&destinations='.$destination.'&key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw&departure_time=now&language=id-ID');
				$hasil = json_decode($perkiraan);
				$perkiraan_rumah = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins='.$origin_rumah.'&destinations='.$destination_rumah.'&key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw&departure_time=now&language=id-ID');
				$hasil_rumah = json_decode($perkiraan_rumah);
				$koor_rumah = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$rumah->latitude.','.$rumah->longitude.'&key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw');
				$hasil_koor_rumah = json_decode($koor_rumah);

				if ($hasil->status == "OK") {
					$rows = $hasil->rows;
					$row = $rows['0'];
					$elements = $row->elements;
					$element = $elements['0'];
					if (isset($element->duration)) {
						$duration = $element->duration;
						$duration_normal_text = $duration->text;
						$duration_normal_value = $duration->value;
					}else{
						$duration_normal_text = "-";
						$duration_normal_value = 0;
					}
					if (isset($element->distance)) {
						$distance = $element->distance;
						$distance_normal_text = $distance->text;
						$distance_normal_value = $distance->value;
					}else{
						$distance_normal_text = "-";
						$distance_normal_value = 0;
					}
				}else{
					$duration_normal_text = "-";
					$duration_normal_value = 0;
					$distance_normal_text = "-";
					$distance_normal_value = 0;
				}

				if ($hasil_rumah->status == "OK") {
					$rows_rumah = $hasil_rumah->rows;
					$row_rumah = $rows_rumah['0'];
					$elements_rumah = $row_rumah->elements;
					$element_rumah = $elements_rumah['0'];
					if (isset($element_rumah->duration)) {
						$duration_rumah = $element_rumah->duration;
						$duration_rumah_text = $duration_rumah->text;
						$duration_rumah_value = $duration_rumah->value;
					}else{	
						$duration_rumah_text = "-";
						$duration_rumah_value = 0;
					}
					if (isset($element_rumah->duration)) {
						$distance_rumah = $element_rumah->distance;
						$distance_rumah_text = $distance_rumah->text;
						$distance_rumah_value = $distance_rumah->value;
					}else{
						$distance_rumah_text = "-";
						$distance_rumah_value = 0;
					}
				}else{
					$duration_rumah_text = "-";
					$duration_rumah_value = 0;
					$distance_rumah_text = "-";
					$distance_rumah_value = 0;
				}

				if ($hasil_pe->status == "OK") {
					$rows_pe = $hasil_pe->rows;
					$row_pe = $rows_pe['0'];
					$elements_pe = $row_pe->elements;
					$element_pe = $elements_pe['0'];
					if (isset($element_rumah->duration)) {
						$duration_pesimis = $element_pe->duration_in_traffic;
						$duration_pesimis_text = $duration_pesimis->text;
						$duration_pesimis_value = $duration_pesimis->value;
					}else{
						$duration_pesimis_text = "-";
						$duration_pesimis_value = 0;
					}
				}else{
					$duration_pesimis_text = "-";
					$duration_pesimis_value = 0;
				}

				if ($hasil_op->status == "OK") {
					$rows_op = $hasil_op->rows;
					$row_op = $rows_op['0'];
					$elements_op = $row_op->elements;
					$element_op = $elements_op['0'];
					if (isset($element_rumah->duration)) {
						$duration_optimis = $element_op->duration_in_traffic;
						$duration_optimis_text = $duration_optimis->text;
						$duration_optimis_value = $duration_optimis->value;
					}else{
						$duration_optimis_text = "-";
						$duration_optimis_value = 0;
					}
				}else{
					$duration_optimis_text = "-";
					$duration_optimis_value = 0;
				}

				if ($hasil_koor_rumah->status == "OK") {
					$alamat_rumah = $hasil_koor_rumah->results[0]->formatted_address."(".$rumah->latitude.",".$rumah->longitude.")";
				}else{
					$alamat_rumah = "-";
				}

			}else{
				$waktu_barcode = "-";

				$duration_normal_text = "-";
				$duration_normal_value = 0;
				$distance_normal_text = "-";
				$distance_normal_value = 0;

				$duration_rumah_text = "-";
				$duration_rumah_value = 0;
				$distance_rumah_text = "-";
				$distance_rumah_value = 0;

				$duration_pesimis_text = "-";
				$duration_pesimis_value = 0;

				$duration_optimis_text = "-";
				$duration_optimis_value = 0;

				$alamat_rumah = "-";
			}
			
			if ($waktu_barcode != "Tidak ada Absen Barcode") {
				$waktu_riil = round(abs(strtotime($key->waktu) - strtotime($waktu_barcode))/60);
				$date = date_create($key->waktu);
				$batas = $duration_pesimis_value;
				if ($waktu_riil > $batas) {
					$style = ' style="color: red"';
					$status = "Melebihi Estimasi Waktu Normal";
				}else{
					$style = ' style="color: black"';
					$status = "OK";
				}
			}else{
				$style = ' style="color: blue"';
				$waktu_riil = 0;
				$status = "Tidak ada Absen Barcode ";
			}
						
			
			$row = array();
			$row[] = $no; // No
			$row[] = "<center>
						<a target=\"_blank\" href=\"".base_url('AbsenPekerjaLaju/list_absen_pkj_laju/list/detail/'.$key->absen_id)."\" class=\"btn btn-primary\">Detail</a>
						</center>"; // Action
			$row[] = $status; // Status
			$row[] = $key->noind; // No Induk
			$row[] = $key->nama; // Nama
			$row[] = $key->jenis_absen; // Jenis Selfi
			$row[] = date_format(date_create($key->waktu),"d-M-Y H:i:s"); // Waktu Selfi
			$row[] = $key->lokasi."(".$key->latitude.",".$key->longitude.")"; // Lokasi
			$row[] = $waktu_barcode; // Waktu Barcode
			$row[] = $distance_normal_text."(".$distance_normal_value." m )"; // Jarak Tempuh Kantor - Titik Selfi
			$row[] = 'normal : '.round($duration_normal_value/60).' Menit<br>Cepat :'.round($duration_optimis_value/60).' Menit<br>Lambat : '.round($duration_pesimis_value/60).' Menit'; // Durasi Gmaps
			$row[] = $waktu_riil.' Menit'; // Durasi riil
			$row[] = $alamat_rumah;
			$row[] = $distance_rumah_text."(".$distance_rumah_value." m )"; // Jarak Tempuh Rumah - Titik Selfi

			$data[] = $row;
		}

		$output = array(
			'draw' => $_POST['draw'],
			'recordsTotal' =>$this->M_pekerjalaju->count_all(),
			'recordsFiltered' => $this->M_pekerjalaju->count_filtered(),
			'data' => $data
		);

		echo json_encode($output);
	}
}