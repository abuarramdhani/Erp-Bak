<?php 
Defined('BASEPATH') or exit('No direct Script access allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_PrediksiSnack extends CI_Controller
{
  
    function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');

        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('form_validation');

        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('CateringManagement/Pesanan/M_prediksisnack');

        $this->checkSession();
    }

    public function checkSession(){
        if(!$this->session->is_logged){
            redirect('');
        }
    }

    public function index(){
        $user_id = $this->session->userid;

        $data['Title'] = 'Prediksi Snack Shift 1 & Umum';
        $data['Menu'] = 'Prediksi Snack';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
     
        if (isset($_SESSION['kode_lokasi_kerja'])) {
        	if ($_SESSION['kode_lokasi_kerja'] == '01') {
	        	$data['lokasi'] = '1';
        	}elseif ($_SESSION['kode_lokasi_kerja'] == '02') {
        		$data['lokasi'] = '2';
        	}
        }
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('CateringManagement/Pesanan/PrediksiSnack/V_index.php',$data);
        $this->load->view('V_Footer',$data);
    }

    public function Proses(){
    	$tanggal 	= $this->input->get('tanggal');
    	$shift 		= $this->input->get('shift');
    	$lokasi 	= $this->input->get('lokasi');

    	$array_insert = array(
    		'tanggal' 		=> $tanggal,
    		'shift' 		=> $shift,
    		'lokasi' 		=> $lokasi,
    		'created_by' 	=> $this->session->user
    	);
    	$id_prediksi = $this->M_prediksisnack->insertPrediksi($array_insert);

    	$prediksi = $this->M_prediksisnack->getPrediksiSnackByTanggalShiftLokasi($tanggal,$shift,$lokasi);
    	if (!empty($prediksi)) {
    		foreach ($prediksi as $key => $value) {
    			$noind_array = $this->M_prediksisnack->getNoindByTempatMakanShiftTanggal($value['tempat_makan'],$shift,$tanggal);
    			if (!empty($noind_array)) {
    				foreach ($noind_array as $key2 => $value2) {
    					$dinas_luar = $this->M_prediksisnack->getDinasLuarByNoind($value2['noind']);
    					if (!empty($dinas_luar)) {
    						foreach ($dinas_luar as $key3 => $value3) {
	    						$absen = $this->M_prediksisnack->getAbsenSetelahPulangByTimestampNoind($value3['tgl_pulang'],$value3['noind']);
	    						if (empty($absen)) {
		    						$prediksi[$key]['dinas_luar'] += 1;
	    						}
    						}
    					}
    				}
    			}

    			$prediksi[$key]['total'] = $prediksi[$key]['jumlah_shift'] - ( $prediksi[$key]['dirumahkan'] + $prediksi[$key]['cuti'] + $prediksi[$key]['sakit'] + $prediksi[$key]['dinas_luar'] );
    			$data_insert = array(
    				'id_prediksi' 	=> $id_prediksi,
    				'tempat_makan' 	=> $prediksi[$key]['tempat_makan'],
    				'jumlah_shift' 	=> $prediksi[$key]['jumlah_shift'],
    				'dirumahkan' 	=> $prediksi[$key]['dirumahkan'],
    				'cuti' 			=> $prediksi[$key]['cuti'],
    				'sakit' 		=> $prediksi[$key]['sakit'],
    				'dinas_luar' 	=> $prediksi[$key]['dinas_luar'],
    				'total' 		=> $prediksi[$key]['total']
    			);
    			$this->M_prediksisnack->insertPrediksiDetail($data_insert);
    		}
    		$data = array(
    			'status' => 'sukses',
    			'text' => $id_prediksi."_".$tanggal."_".$shift."_".$lokasi
    		);
    		echo json_encode($data);
    	}else{
    		echo "Data Shift kosong";

    	}
    }

    public function lihat($text){
    	$txt = explode("_", $text);
    	$id_prediksi = $txt[0];
    	$tanggal = $txt[1];
    	$shift = $txt[2];
    	$lokasi = $txt[3];

    	$user_id = $this->session->userid;

        $data['Title'] = 'Prediksi Snack Shift 1 & Umum';
        $data['Menu'] = 'Prediksi Snack';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['tanggal'] = $tanggal;
        $data['shift'] = $shift;
        $data['lokasi'] = $lokasi;

        $data['prediksi'] = $this->M_prediksisnack->getDataPrediksiSnackDetailByIdPrediksi($id_prediksi);

    	$this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('CateringManagement/Pesanan/PrediksiSnack/V_result.php',$data);
        $this->load->view('V_Footer',$data);
    }

    public function daftar($text){
    	$txt = explode("_", $text);
    	$tanggal = $txt[0];
    	$shift = $txt[1];
    	$lokasi = $txt[2];

    	$user_id = $this->session->userid;

        $data['Title'] = 'Prediksi Snack Shift 1 & Umum';
        $data['Menu'] = 'Prediksi Snack';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['tanggal'] = $tanggal;
        $data['shift'] = $shift;
        $data['lokasi'] = $lokasi;

        $data['prediksi'] = $this->M_prediksisnack->getDataPrediksiSnackByTanggalShiftLokasi($tanggal,$shift,$lokasi);

    	$this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('CateringManagement/Pesanan/PrediksiSnack/V_list.php',$data);
        $this->load->view('V_Footer',$data);
    }

    public function history(){
    	$user_id = $this->session->userid;

        $data['Title'] = 'Prediksi Snack Shift 1 & Umum';
        $data['Menu'] = 'Prediksi Snack';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['prediksi'] = $this->M_prediksisnack->getDataPrediksiSnackAll();

    	$this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('CateringManagement/Pesanan/PrediksiSnack/V_history.php',$data);
        $this->load->view('V_Footer',$data);
    }

}
?>