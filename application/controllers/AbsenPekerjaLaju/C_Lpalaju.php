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
		$array_data = $this->M_absenatasan->getList($noind,$nama);
		// echo "<pre>";print_r($array_data);exit();

		$list_data = array();
		foreach ($array_data as $key => $value) {
			$list_data[$key] = $value;
			$lokasi_kerja = $this->M_pekerjalaju->getLokasikerjaByNoind($value['noind']);
			$koordinat = $this->M_pekerjalaju->getKoordinatByLokasiKerja($lokasi_kerja->lokasi_kerja);
			$kantor = $koordinat->latitude.','.$koordinat->longitude;
			if ($value['jenis_absen'] == 'Pulang Kerja') {
				$waktu_barcode = $this->M_pekerjalaju->getAbsenBarcodePulang($value['noind'],$value['waktu']);
				$destination = $value['latitude'].','.$value['longitude'];
				$origin = $kantor;
			}elseif ($value['jenis_absen'] == 'Masuk Kerja') {
				$waktu_barcode = $this->M_pekerjalaju->getAbsenBarcodeDatang($value['noind'],$value['waktu']);
				$destination = $kantor;
				$origin = $value['latitude'].','.$value['longitude'];
			}else{
				echo "Ada Data memiliki jenis absen selain pulang kerja dan masuk kerja";exit();
			}
			$list_data[$key]['waktu_barcode'] = $waktu_barcode->waktu_barcode;
			
			$perkiraan_op = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins='.$origin.'&destinations='.$destination.'&key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw&traffic_model=optimistic&departure_time=now&language=id-ID');
			$hasil_op = json_decode($perkiraan_op);
			$perkiraan_pe = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins='.$origin.'&destinations='.$destination.'&key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw&traffic_model=pessimistic&departure_time=now&language=id-ID');
			$hasil_pe = json_decode($perkiraan_pe);
			$perkiraan = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metrics&origins='.$origin.'&destinations='.$destination.'&key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw&departure_time=now&language=id-ID');
			$hasil = json_decode($perkiraan);

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

			// $list_data[$key]['gmaps'] = $hasil_op;
		}
		echo "<pre>";print_r($list_data);exit();

		$data['listData'] = $list_data;
		
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
}