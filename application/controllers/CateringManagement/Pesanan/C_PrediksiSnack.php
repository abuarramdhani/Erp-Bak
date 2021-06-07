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
                $pekerja_dl = array();
    			$noind_array = $this->M_prediksisnack->getNoindByTempatMakanShiftTanggal($value['tempat_makan'],$value['shift'],$tanggal);
    			if (!empty($noind_array)) {
    				foreach ($noind_array as $key2 => $value2) {
    					$dinas_luar = $this->M_prediksisnack->getDinasLuarByNoind($value2['noind']);
    					if (!empty($dinas_luar)) {
    						foreach ($dinas_luar as $key3 => $value3) {
	    						$absen = $this->M_prediksisnack->getAbsenSetelahPulangByTimestampNoind($value3['tgl_pulang'],$value3['noind']);
	    						if (empty($absen)) {
		    						$prediksi[$key]['dinas_luar'] += 1;
                                    $pekerja_dl[] = $value3;
	    						}
    						}
    					}
    				}
    			}

    			$prediksi[$key]['total'] = $prediksi[$key]['jumlah_shift'] - ( $prediksi[$key]['dirumahkan'] + $prediksi[$key]['cuti'] + $prediksi[$key]['sakit'] + $prediksi[$key]['dinas_luar'] + $prediksi[$key]['puasa'] );
    			$data_insert = array(
    				'id_prediksi' 	=> $id_prediksi,
    				'tempat_makan' 	=> $prediksi[$key]['tempat_makan'],
    				'shift'      	=> $prediksi[$key]['shift'],
                    'jumlah_shift'  => $prediksi[$key]['jumlah_shift'],
    				'dirumahkan' 	=> $prediksi[$key]['dirumahkan'],
    				'cuti' 			=> $prediksi[$key]['cuti'],
    				'sakit' 		=> $prediksi[$key]['sakit'],
                    'dinas_luar'    => $prediksi[$key]['dinas_luar'],
    				'puasa' 	    => $prediksi[$key]['puasa'],
    				'total' 		=> $prediksi[$key]['total']
    			);
    			$id_detail = $this->M_prediksisnack->insertPrediksiDetail($data_insert);
                
                if (!empty($pekerja_dl)) {
                    foreach($pekerja_dl as $pdl){
                        $data_dl = $pdl;
                        $data_dl['id_prediksi_snack_detail'] = $id_detail;
                        $this->M_prediksisnack->insertPrediksiDL($data_dl);
                    }
                }
                $this->M_prediksisnack->insertPrediksiPekerja($id_detail,$tanggal,$prediksi[$key]['shift'],$lokasi,$prediksi[$key]['tempat_makan']);
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
        $data['Header'] = 'Prediksi Snack Shift 1 & Umum / '.$tanggal." / ".($lokasi == "1" ? "Pusat" : "Tuksono");
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

    public function pekerja(){
        if (!isset($_GET['id'])) {
            exit("Error, required data not found");
        }
        $ids = explode(",",$_GET['id']);
        $head = $this->M_prediksisnack->getPrediksiSnackDetailByIdDetail($ids);
        
        $this->load->library('pdf');

        $body = "";
        $panjang_nama = 28;
        foreach ($ids as $id) {
            $rows = "";
            $shift = "";
            $data = $this->M_prediksisnack->getPrediksiSnackPekerjaByIdDetail($id);
            for($i=0;$i<ceil(count($data)/2);$i++) {

                $rows .= "<tr>
                    <td style='text-align: center;'>".($i+1)."</td>
                    <td style='text-align: center;'>".$data[$i]['noind']."</td>
                    <td>".substr($data[$i]['nama'], 0, $panjang_nama)."</td>
                    <td style='".($data[$i]['keterangan'] != "" ? 'color: red' : '')."'>
                        ".$data[$i]['keterangan']."
                    </td>
                    <td></td>";
                    if (isset($data[$i + ceil(count($data)/2)])) {
                        $rows .= "
                            <td style='text-align: center;'>".(ceil(count($data)/2) + $i + 1)."</td>
                            <td style='text-align: center;'>".($data[$i + ceil(count($data)/2)]['noind'])."</td>
                            <td>".substr($data[$i + ceil(count($data)/2)]['nama'], 0, $panjang_nama)."</td>
                            <td style='".($data[$i + ceil(count($data)/2)]['keterangan'] != "" ? 'color: red' : '')."'>
                                ".$data[$i + ceil(count($data)/2)]['keterangan']."
                            </td>
                        </tr>";
                    }else{
                        $rows .= "
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>";
                    }
                $shift = $data[$i]['shift'];
            }
            
            $body .= "<div style='padding-top: 20px'>
                <span style='font-weight: bold;'>$shift</span>
                <table style='border: 1px solid black;border-collapse: collapse;width: 100%;' border='1' >
                    <thead>
                        <tr>
                            <th style='width: 5%'>No.</th>
                            <th style='width: 7%'>No.Induk</th>
                            <th style='width: 25%'>Nama</th>
                            <th style='width: 12%'>Ket</th>
                            <th style='width: 2%;border-top: 0px solid white;border-bottom: 0px;'>&nbsp;</th>
                            <th style='width: 5%'>No.</th>
                            <th style='width: 7%'>No.Induk</th>
                            <th style='width: 25%'>Nama</th>
                            <th style='width: 12%'>Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        $rows
                    </tbody>
                </table>
            </div>";
        }

        $template = "
        <div>
            <table style='width: 100%;border: 1px solid black;border-collapse: collapse;' border='1'>
                <tr>
                    <td rowspan='2' style='text-align: center;font-size: 24pt;width: 55%;'>PREDIKSI SNACK</td>
                    <td style='font-size: 9pt;width: 15%;padding-left: 3mm;'>Tempat Makan : </td>
                    <td style='font-size: 9pt;width: 15%;padding-left: 3mm;'>Lokasi : </td>
                    <td style='font-size: 9pt;width: 15%;padding-left: 3mm;'>Tanggal : </td>
                </tr>
                <tr>
                    <td style='padding-left: 3mm;'>".$head->tempat_makan."</td>
                    <td style='padding-left: 3mm;'>".($head->lokasi == "1" ? "Pusat" : "Tuksono")."</td>
                    <td style='padding-left: 3mm;'>".$head->tanggal."</td>
                </tr>
            </table>
            <table style='width: 100%;border: 1px solid black;border-collapse: collapse;margin-top: 2mm' border='1'>
                <tr>
                    <td style='width: ".(100/11)."%;text-align: center;'>S. Umum</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>S. 1</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>S. 1 Satpam</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>S. 1 PU</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>S. Dapur Umum</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>Cuti</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>Dirumahkan</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>Sakit</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>Dinas Luar</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>Puasa</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>Total</td>
                </tr>
                <tr>
                    <td style='width: ".(100/11)."%;text-align: center;'>".$head->shift_umum."</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>".$head->shift_1."</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>".$head->shift_1_satpam."</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>".$head->shift_1_pu."</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>".$head->shift_dapur_umum."</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>".$head->cuti."</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>".$head->dirumahkan."</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>".$head->sakit."</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>".$head->dinas_luar."</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>".$head->puasa."</td>
                    <td style='width: ".(100/11)."%;text-align: center;'>".$head->total."</td>
                </tr>
            </table>
        </div>
        $body
        ";
        // echo $template;exit();

        $mpdf = $this->pdf->load();
        $mpdf = new mPDF('utf8', 'A4-L',0,'mono');
        $mpdf->SetHTMLFooter("<table style=\"width: 100%\"><tr><td><i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-CateringManagement oleh " . $this->session->user . " - " . $this->session->employee . " pada tgl. " . date('Y/M/d H:i:s') . "</i></td><td  rowspan=\"2\" style=\"vertical-align: middle; font-size: 8pt; text-align: right;\">Halaman {PAGENO} dari {nb}</td></tr></table>");
        $filename = 'Prediksi_Catering_' . $tanggal . '.pdf';
        $mpdf->WriteHTML($template);
        $mpdf->setTitle($filename);
        $mpdf->Output($filename, 'I');
    }

}
?>