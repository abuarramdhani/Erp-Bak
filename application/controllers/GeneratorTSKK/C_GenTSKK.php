<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_GenTSKK extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->library('Excel');
          //load the login model
		$this->load->library('session');
		$this->load->helper(array('url','download'));
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('GeneratorTSKK/M_gentskk');

        date_default_timezone_set('Asia/Jakarta');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }

	public function checkSession()
	{
		if($this->session->is_logged){
		}else{
			redirect();
		}
	}

// ------------------------------------------------- show the dashboard ----------------------------------------- //


public function index()
{
    $this->checkSession();
    $user_id = $this->session->userid;

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
    $data['Title'] = '';
    $data['Menu'] = '';
    $data['SubMenuOne'] = '';
    $data['SubMenuTwo'] = '';

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('GeneratorTSKK/V_Index',$data);
    $this->load->view('V_Footer',$data);
}

public function Input()
{
    $this->checkSession();
    $user_id = $this->session->userid;

    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $data['lihat_elemen'] = $this->M_gentskk->selectData();
    // echo "<pre>"; print_r($data['lihat_elemen']);exit();

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('GeneratorTSKK/V_InputStandar');
    $this->load->view('V_Footer',$data);
}

public function insertData()
{
    $inputan_elemen = $this->input->post('txtInputElemen');

    $this->M_gentskk->insertData($inputan_elemen);
    redirect("GeneratorTSKK/InputStandarElemen");
}

public function deleteElemenKerja($id)
{
    $data = $this->M_gentskk->deleteStandardElement($id);
    redirect("GeneratorTSKK/InputStandarElemen");
}

public function ViewEdit()
{
    $this->checkSession();
    $user_id = $this->session->userid;

    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $data['lihat_header'] = $this->M_gentskk->selectHeaderMonTSKK();
    // $data['id_tabelElemen'] = $this->M_gentskk->selectIdElemen($id);
    // echo "<pre>"; print_r( $data['id_tabelElemen']);exit();
    // echo "<pre>";print_r($data['lihat_header']);

    // for ($i=0; $i < count($data['lihat_header']); $i++) {
    //     $id = $data['lihat_header'][$i]['id_tskk'];
    //     echo "<pre>";print_r($id);
    // }
    // exit();

    // for ($i=0; $i < count($elemen); $i++) {
    //     $data = array(
    //         'id_tskk'       	=> $id[$i]
    //     );
    //     $chckID = $this->M_gentskk->tabelelemen($data);
    // }

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('GeneratorTSKK/V_ViewTSKK');
    $this->load->view('V_Footer',$data);
}

public function deleteData()
{
    $id = $this->input->post('id');
    // echo $id;die;
    // die;
    $data = $this->M_gentskk->deleteHeader($id);
    $data = $this->M_gentskk->deleteObservation($id);
    $data = $this->M_gentskk->deleteElemen($id);
    $data = $this->M_gentskk->deleteTaktTime($id);
    $data = $this->M_gentskk->deleteIrregularJobs($id);

    // redirect("GeneratorTSKK/ViewEdit");
    // redirect("GeneratorTSKK/Generate");
}

public function deleteEdit($seq,$id)
{
    $data = $this->M_gentskk->deleteEdit($seq,$id);
    // redirect('GeneratorTSKK/C_GenTSKK/EditTSKK/'.$id);
}

public function EditTSKK($id)
{
    $this->checkSession();
    $user_id = $this->session->userid;

    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    // $dataId = $this->M_gentskk->selectIdHeader();
    // $id = $dataId[0]['id'];
    $data['status'] = 0;
    $data['lihat_tabelElemen_Edit'] = $this->M_gentskk->getAllElementsWhenEdit($id);
    // echo"<pre>";print_r($data['lihat_tabelElemen_Edit']);
    // exit();
    $data['lihat_hasilObservasi_elemen'] = $this->M_gentskk->getAllObservation($id);
    $data['lihat_hasilObservasi'] = $this->M_gentskk->getAllObservation($id);

    $hitungData = count($data['lihat_hasilObservasi']);
    if (count($data['lihat_hasilObservasi']) < 10){
        for ($i=0; $i < 10 - $hitungData ; $i++) {
            $data['lihat_hasilObservasi'][] = array("id_tskk"=>"",
            "judul_tskk"=>"",
            "tipe"=>"",
            "kode_part"=>"",
            "nama_part"=>"",
            "no_alat_bantu"=>"",
            "seksi"=>"",
            "proses"=>"",
            "kode_proses"=>"",
            "mesin"=>"",
            "proses_ke"=>"",
            "proses_dari"=>"",
            "tanggal"=>"",
            "qty"=>"",
            "operator"=>"",
            "seq"=>"",
            "waktu_1"=>"",
            "waktu_2"=>"",
            "waktu_3"=>"",
            "waktu_4"=>"",
            "waktu_5"=>"",
            "waktu_6"=>"",
            "waktu_7"=>"",
            "waktu_8"=>"",
            "waktu_9"=>"",
            "waktu_10"=>"",
            "x_min"=>"",
            "r"=>"",
            "waktu_distribusi"=>"",
            "waktu_kerja"=>"",
            "keterangan"=>"",
            "takt_time"=>"",
            "jenis_proses"=>"",
            "elemen"=>"",
            "keterangan_elemen"=>"",
            "tipe_urutan"=>"");
        }
    }

        $data['lihat_irregular_jobs'] = $this->M_gentskk->selectIrregularJobs($id);
        $data['lihat_perhitungan_takt_time'] = $this->M_gentskk->selectTaktTimeCalculation($id);
        // echo "<pre>"; echo $id;
        // echo "<pre>";print_r($data['lihat_perhitungan_takt_time']);die;

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('GeneratorTSKK/V_EditTSKK');
    $this->load->view('V_Footer',$data);
}

public function CreateBegin($id)
{
    $this->checkSession();
    $user_id = $this->session->userid;

    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    // $dataId = $this->M_gentskk->selectIdHeader();
    // $id = $dataId[0]['id'];
    $data['status'] = 0;
    $data['lihat_tabelElemen_Edit'] = $this->M_gentskk->getAllElementsWhenEdit($id);
    // echo"<pre>";print_r($data['lihat_tabelElemen_Edit']);
    // exit();
    $data['lihat_hasilObservasi_elemen'] = $this->M_gentskk->getAllObservation($id);
    // echo"<pre>";print_r($data['lihat_hasilObservasi_elemen']);exit();
    $data['lihat_hasilObservasi'] = $this->M_gentskk->getAllObservation($id);
    $hitungData = count($data['lihat_hasilObservasi']);
    if (count($data['lihat_hasilObservasi']) < 10){
        for ($i=0; $i < 10 - $hitungData ; $i++) {
            $data['lihat_hasilObservasi'][] = array("id_tskk"=>"",
            "judul_tskk"=>"",
            "tipe"=>"",
            "kode_part"=>"",
            "nama_part"=>"",
            "no_alat_bantu"=>"",
            "seksi"=>"",
            "proses"=>"",
            "kode_proses"=>"",
            "mesin"=>"",
            "proses_ke"=>"",
            "proses_dari"=>"",
            "tanggal"=>"",
            "qty"=>"",
            "operator"=>"",
            "seq"=>"",
            "waktu_1"=>"",
            "waktu_2"=>"",
            "waktu_3"=>"",
            "waktu_4"=>"",
            "waktu_5"=>"",
            "waktu_6"=>"",
            "waktu_7"=>"",
            "waktu_8"=>"",
            "waktu_9"=>"",
            "waktu_10"=>"",
            "x_min"=>"",
            "r"=>"",
            "waktu_distribusi"=>"",
            "waktu_kerja"=>"",
            "keterangan"=>"",
            "takt_time"=>"",
            "jenis_proses"=>"",
            "elemen"=>"",
            "keterangan_elemen"=>"",
            "tipe_urutan"=>"");
        }
    }
    // echo $id;
    $data['lihat_irregular_jobs'] = $this->M_gentskk->selectIrregularJobs($id);
    $data['lihat_perhitungan_takt_time'] = $this->M_gentskk->selectTaktTimeCalculation($id);

    // echo "<pre>";print_r($data['lihat_perhitungan_takt_time']);die;

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('GeneratorTSKK/V_CreateBegin');
    $this->load->view('V_Footer',$data);
}

public function EditObservasi($id)
{
    $this->checkSession();
    $user_id = $this->session->userid;

    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $data['status'] = 0;
    $data['lihat_tabelElemen_Edit'] = $this->M_gentskk->getAllElementsWhenEdit($id);
    $data['lihat_hasilObservasi_elemen'] = $this->M_gentskk->getAllObservation($id);
    $data['lihat_hasilObservasi'] = $this->M_gentskk->getAllObservation($id);
		$data['product'] = $this->M_gentskk->getTipeProduk('');

    $hitungData = count($data['lihat_hasilObservasi']);
    if (count($data['lihat_hasilObservasi']) < 5){
        for ($i=0; $i < 5- $hitungData ; $i++) {
            $data['lihat_hasilObservasi'][] = array("id_tskk"=>"",
            "judul_tskk"=>"",
            "tipe"=>"",
            "kode_part"=>"",
            "nama_part"=>"",
            "no_alat_bantu"=>"",
            "seksi"=>"",
            "proses"=>"",
            "kode_proses"=>"",
            "mesin"=>"",
            "proses_ke"=>"",
            "proses_dari"=>"",
            "tanggal"=>"",
            "qty"=>"",
            "operator"=>"",
            "seq"=>"",
            "waktu_1"=>"",
            "waktu_2"=>"",
            "waktu_3"=>"",
            "waktu_4"=>"",
            "waktu_5"=>"",
            "waktu_6"=>"",
            "waktu_7"=>"",
            "waktu_8"=>"",
            "waktu_9"=>"",
            "waktu_10"=>"",
            "x_min"=>"",
            "r"=>"",
            "waktu_distribusi"=>"",
            "waktu_kerja"=>"",
            "keterangan"=>"",
            "takt_time"=>"",
            "jenis_proses"=>"",
            "elemen"=>"",
            "keterangan_elemen"=>"",
            "tipe_urutan"=>"");
        }
    }

    $data['lihat_irregular_jobs']        = $this->M_gentskk->selectIrregularJobs($id);
    $data['lihat_perhitungan_takt_time'] = $this->M_gentskk->selectTaktTimeCalculation($id);

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('GeneratorTSKK/V_EditObservasi');
    $this->load->view('V_Footer',$data);
}

public function Display()
{
    $this->checkSession();
    $user_id = $this->session->userid;

    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';

    $data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
    // $data['NoInduk']        = $this->session->user;
    $data['lihat_header']   = $this->M_gentskk->selectHeader();
    // echo"<pre>";print_r($data['lihat_header']);die;

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('GeneratorTSKK/V_GenTSKK');
    $this->load->view('V_Footer',$data);
}

// public function CreateTSKK($id)
public function CreateTSKK()
{
    $this->checkSession();
    $user_id = $this->session->userid;

    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $dataId = $this->M_gentskk->selectIdHeader();
    $id = $dataId[0]['id'];

    $data['lihat_hasilObservasi_elemen'] = $this->M_gentskk->getAllObservation($id);
    // echo"<pre>";print_r($data['lihat_hasilObservasi_elemen']);exit();
    $data['lihat_hasilObservasi'] = $this->M_gentskk->getAllObservation($id);
    $hitungData = count($data['lihat_hasilObservasi']);
    if (count($data['lihat_hasilObservasi']) < 10){
        for ($i=0; $i < 10 - $hitungData ; $i++) {
            $data['lihat_hasilObservasi'][] = array("id_tskk"=>"",
            "judul_tskk"=>"",
            "tipe"=>"",
            "kode_part"=>"",
            "nama_part"=>"",
            "no_alat_bantu"=>"",
            "seksi"=>"",
            "proses"=>"",
            "kode_proses"=>"",
            "mesin"=>"",
            "proses_ke"=>"",
            "proses_dari"=>"",
            "tanggal"=>"",
            "qty"=>"",
            "operator"=>"",
            "seq"=>"",
            "waktu_1"=>"",
            "waktu_2"=>"",
            "waktu_3"=>"",
            "waktu_4"=>"",
            "waktu_5"=>"",
            "waktu_6"=>"",
            "waktu_7"=>"",
            "waktu_8"=>"",
            "waktu_9"=>"",
            "waktu_10"=>"",
            "x_min"=>"",
            "r"=>"",
            "waktu_distribusi"=>"",
            "waktu_kerja"=>"",
            "keterangan"=>"",
            "takt_time"=>"",
            "jenis_proses"=>"",
            "elemen"=>"",
            "keterangan_elemen"=>"",
            "tipe_urutan"=>"");
        }
    }

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('GeneratorTSKK/V_CreateTSKK');
    $this->load->view('V_Footer',$data);
}

public function saveObservation(){
    // echo "<pre>"; print_r($_POST);die;
    $judul            = $this->input->post('txtTitle');
    $takt_time        = $this->input->post('taktTime');
    $nd               = $this->input->post('inputInsert');
    //PART
    $jenis_inputPart  = $this->input->post('terdaftar');
    $type 	          = $this->input->post('txtType');
    if ($type == null) {
        $type 	      = $this->input->post('txtTypeT');
    }
    $kode_part 	      = $this->input->post('txtKodepart[]');
    if ($kode_part == null) {
        $kode 	          = $this->input->post('txtKodepartT');
    }else{
        $kode_part 	      = $this->input->post('txtKodepart[]');
        $kode = implode(",", $kode_part);
    }
    $nama_part 	      = $this->input->post('txtNamaPart');
    if ($nama_part == null) {
        $nama_part 	          = $this->input->post('txtNamaPartT');
    }
    //EQUIPMENT
		$jenis_inputEquipment  = $this->input->post('equipmenTerdaftar');
		$jenis_inputEquipmentMesin  = $this->input->post('equipmenTerdaftarMesin');
		// echo $jenis_inputEquipment; die;
    $no_mesin	      = $this->input->post('txtNoMesin[]');
		if ($no_mesin == null) {
				$no_mesin	      = $this->input->post('txtNoMesinT');
		}else{
				$no_mesin = implode("; ", $no_mesin);
		}
    // echo "<pre>";echo $no_mesin;
    $jenis_mesin      = $this->input->post('txtJenisMesin[]');
		if (empty($jenis_mesin[0])) {
				$jenis_mesin = $this->input->post('txtJenisMesinT');
		}else{
				$jenis_mesin = implode("; ", $jenis_mesin);
		}

    // $jenis_mesin = trim(preg_replace('/\s\s+/', ' ', $jm));
    $resource         = $this->input->post('txtResource[]');
		if (empty($resource[0])) {
				$resource = $this->input->post('txtResourceT');
		}else{
				$resource = implode("; ", $resource);
		}
    // $resource = trim(preg_replace('/\s\s+/', ' ', $rsc));
    $line             = $this->input->post('txtLine');
    $alat_bantu	      = $this->input->post('txtAlatBantu[]');
    if ($alat_bantu == null) {
        $alat_bantu	      = $this->input->post('txtAlatBantuT');
    }else{
        $alat_bantu	      = $this->input->post('txtAlatBantu[]');
        $alat_bantu = implode("; ", $alat_bantu);
    }
    // echo "<pre>";echo $alat_bantu;
    $tools            = $this->input->post('txtTools[]');
    if ($tools == null) {
        $tools            = $this->input->post('txtToolsT');
    }else{
        $tools            = $this->input->post('txtTools[]');
        $tools = implode("; ", $tools);
    }
    //SDM
    $operator	      = $this->input->post('txtNama[]');
    $nm = implode(", ", $operator);
    $jml_operator     = $this->input->post('txtJmlOperator');
    $dr_operator      = $this->input->post('txtDariOperator');
    $seksi 	          = $this->input->post('txtSeksi');
    //PROCESS
    $proses 	      = $this->input->post('txtProses');
    $kode_proses      = $this->input->post('txtKodeProses');
    $proses_ke 	      = $this->input->post('txtProsesKe');
    $dari 	          = $this->input->post('txtDariProses');
    $tanggal          = $this->input->post('txtTanggal');
    $qty 	          = $this->input->post('txtQtyProses');
    // die;
    //SEKSI PEMBUAT
    $noind = $this->session->user;
    $data['getSeksiUnit'] = $this->M_gentskk->detectSeksiUnit($noind);
    $split = $data['getSeksiUnit'][0];
    $seksi_pembuat = $split['seksi'];
    $dept_pembuat = $split['dept'];
    $noind = $this->session->user;
    $name = $this->M_gentskk->selectNamaPekerja($noind);
    $nama_pekerja = $name[0]['nama'];
    $sang_pembuat = $noind." - ".$nama_pekerja;
    $creationDate = date('Y/m/d h:i:s', time());
    // echo "<pre>"; print_r($name);
    // echo "<pre>"; print_r($nama_pekerja);
    // echo "<pre>"; echo $creationDate;
    // $split = $data['getSeksiUnit'][0];
    // $seksi = $split['seksi'];
    // die;

        if ($nd == null) {
            $nilai_distribusi = 0;
        }else{
            $nilai_distribusi = $nd;
        }
    $saveHeader = $this->M_gentskk->InsertHeaderTSKK($judul,$type,$kode,$nama_part,$seksi,
                  $proses,$kode_proses,$jenis_mesin,$proses_ke,$dari,$tanggal,$qty,$nm,
                  $nilai_distribusi,$takt_time,$no_mesin,$resource,$line,$alat_bantu,$tools,
                  $jml_operator,$dr_operator,$seksi_pembuat,$jenis_inputPart,$jenis_inputEquipment,
                  $sang_pembuat,$creationDate, $jenis_inputEquipmentMesin);

    // echo"<pre>";print_r($saveHeader);
    // die;
    $dataId = $this->M_gentskk->selectIdHeader();
    $id = $dataId[0]['id'];

    $waktu_1          = $this->input->post('waktu1[]');
    $waktu_2          = $this->input->post('waktu2[]');
    $waktu_3          = $this->input->post('waktu3[]');
    $waktu_4          = $this->input->post('waktu4[]');
    $waktu_5          = $this->input->post('waktu5[]');
    $waktu_6          = $this->input->post('waktu6[]');
    $waktu_7          = $this->input->post('waktu7[]');
    $waktu_8          = $this->input->post('waktu8[]');
    $waktu_9          = $this->input->post('waktu9[]');
    $waktu_10         = $this->input->post('waktu10[]');
    $x_min            = $this->input->post('xmin[]');
    $range            = $this->input->post('range[]');
    $waktu_distribusi = $this->input->post('wDistribusi[]');
    $waktu_kerja      = $this->input->post('wKerja[]');
    $keterangan       = $this->input->post('keterangan[]');
    $takt_time        = $this->input->post('taktTime');
    $jenis_proses 	  = $this->input->post('slcJenisProses[]');
    $elemen           = $this->input->post('txtSlcElemen[]');
    $keterangan_elemen= $this->input->post('elemen[]');
    $tipe_urutan 	  = $this->input->post('checkBoxParalel[]');
		// Waktu Mulai Bersamaan
		$startTimeTogether =  $this->input->post('start_time_together[]');
		$endTimeTogether =  $this->input->post('end_time_together[]');

    // echo "<pre>"; print_r($jenis_proses);exit;

    for ($i=0; $i < count($elemen); $i++) {

        if ($waktu_1[$i] != ''){
            $w1             = $waktu_1[$i];
        }else{
            $w1 	        = null;
        }

        if ($waktu_2[$i] != ''){
            $w2             = $waktu_2[$i];
        }else{
            $w2 	        = null;
        }

        if ($waktu_3[$i] != ''){
            $w3             = $waktu_3[$i];
        }else{
            $w3 	        = null;
        }

        if ($waktu_4[$i] != ''){
            $w4             = $waktu_4[$i];
        }else{
            $w4 	        = null;
        }

        if ($waktu_5[$i] != ''){
            $w5             = $waktu_5[$i];
        }else{
            $w5 	        = null;
        }

        if ($waktu_6[$i] != ''){
            $w6            = $waktu_6[$i];
        }else{
            $w6 	       = null;
        }

        if ($waktu_7[$i] != ''){
            $w7            = $waktu_7[$i];
        }else{
            $w7	           = null;
        }

        if ($waktu_8[$i] != ''){
            $w8            = $waktu_8[$i];
        }else{
            $w8 	       = null;
        }

        if ($waktu_9[$i] != ''){
            $w9            = $waktu_9[$i];
        }else{
            $w9 	       = null;
        }

        if ($waktu_10[$i] != ''){
            $w10           = $waktu_10[$i];
        }else{
            $w10 	       = null;
        }

        if ($x_min[$i] != ''){
            $xm            = $x_min[$i];
        }else{
            $xm 	       = null;
        }

        if ($range[$i] != ''){
            $r            = $range[$i];
        }else{
            $r 	          = null;
        }

        if ($waktu_distribusi[$i] != ''){
            $w_dst         = $waktu_distribusi[$i];
        }else{
            $w_dst 	       = null;
        }

        if ($waktu_kerja[$i] != ''){
            $wk            = $waktu_kerja[$i];
        }else{
            $wk 	       = null;
        }

        if ($keterangan[$i] != ''){
            $ktr           = $keterangan[$i];
        }else{
            $ktr 	       = null;
        }

        if ($jenis_proses[$i] != ''){
            $jp            = $jenis_proses[$i];
        }else{
            $jp 	       = null;
        }

        if ($elemen[$i] != ''){
            $elm           = $elemen[$i];
        }else{
            $elm 	       = null;
        }

        if ($keterangan_elemen[$i] != ''){
            $ktr_elm       = $keterangan_elemen[$i];
        }else{
            $ktr_elm 	   = null;
        }

				if ($startTimeTogether[$i] == ''){
						$startTimeTogether[$i] = null;
				}

				if ($endTimeTogether[$i] == ''){
						$endTimeTogether[$i] = null;
				}

        if (!empty($tipe_urutan)) {
            if (array_key_exists($i,$tipe_urutan)){
                $tu            = $tipe_urutan[$i];
            }else{
                $tu 	       = 'SERIAL';
            }
        }else {
                $tu 	       = 'SERIAL';
        }

            $data = array(
            'id_tskk'  	        => $id,
            'waktu_1' 	        => $w1,
            'waktu_2'           => $w2,
            'waktu_3'   	    => $w3,
            'waktu_4' 	        => $w4,
            'waktu_5' 	        => $w5,
            'waktu_6' 	        => $w6,
            'waktu_7'       	=> $w7,
            'waktu_8'       	=> $w8,
            'waktu_9'       	=> $w9,
            'waktu_10'       	=> $w10,
            'x_min'       	    => $xm,
            'r'       	        => $r,
            'waktu_distribusi'  => $w_dst,
            'waktu_kerja'       => $wk,
            'keterangan'       	=> $ktr,
            'takt_time'       	=> $takt_time,
            'jenis_proses'      => $jp,
            'elemen'        	=> $elm,
            'keterangan_elemen' => $ktr_elm,
            'tipe_urutan'       => $tu,
						'start_together'		=> $startTimeTogether[$i],
						'end_together'		=> $endTimeTogether[$i]
            );
        // echo "<pre>";print_r($data);
        $insert = $this->M_gentskk->saveObservation($data);
    }

    //IRREGULAR JOBS
    $irregular_jobs         = $this->input->post('txtIrregularJob[]');
    $ratio_irregular        = $this->input->post('txtRatioIrregular[]');
    $waktu_irregular        = $this->input->post('txtWaktuIrregular[]');
    $hasil_irregular        = $this->input->post('txtHasilWaktuIrregular[]');

    for ($i=0; $i < count($ratio_irregular); $i++) {
            $data = array(
            'id_irregular_job'      => $id,
            'irregular_job' 	    => empty($irregular_jobs[$i]) ? NULL : $irregular_jobs[$i],
            'ratio'                 => empty($ratio_irregular[$i]) ? NULL : $ratio_irregular[$i],
            'waktu'   	            => empty($waktu_irregular[$i]) ? NULL : $waktu_irregular[$i],
            'hasil_irregular_job'   => empty($hasil_irregular[$i]) ? NULL : $hasil_irregular[$i],
            );
        // echo "<pre>";print_r($data);
        $insertIrregularJobs = $this->M_gentskk->saveIrregularJobs($data);
    }

    //PERHITUNGAN TAKT TIME
    $waktu_satu_shift   = $this->input->post('txtWaktu1Shift');
    $jumlah_shift       = $this->input->post('txtJumlahShift');
    $forecast           = $this->input->post('txtForecast');
    $qty_unit           = $this->input->post('txtQtyUnit');
    $rencana_produksi   = $forecast * $qty_unit;
    $jumlah_hari_kerja  = $this->input->post('txtJumlahHariKerja');

    $insertTaktTime = $this->M_gentskk->saveTaktTime($id,$waktu_satu_shift,$jumlah_shift,$forecast,$qty_unit,$rencana_produksi,$jumlah_hari_kerja);

    $data['lihat_hasilObservasi'] = $this->M_gentskk->getAllObservation($id);

    redirect('GeneratorTSKK/Generate/');
}

public function resaveObservation(){

    $dataId = $this->M_gentskk->selectIdHeader();
    $id = $dataId[0]['id'];
    // echo"<pre>";print_r($_POST);exit();
    $judul            = $this->input->post('txtTitle');
    $type 	          = $this->input->post('txtType');
    $kode_part 	      = $this->input->post('txtKodepart');
    $nama_part 	      = $this->input->post('txtNamaPart');
    $no_alat 	      = $this->input->post('txtNoAlat');
    $seksi 	          = $this->input->post('txtSeksi');
    $proses 	      = $this->input->post('txtProses');
    $kode_proses      = $this->input->post('txtKodeProses');
    $mesin 	          = $this->input->post('txtMesin');
    $proses_ke 	      = $this->input->post('txtProsesKe');
    $dari 	          = $this->input->post('txtDari');
    $tanggal          = $this->input->post('txtTanggal');
    $qty 	          = $this->input->post('txtQty');
    $operator 	      = $this->input->post('txtOperator');
    $nilai_distribusi = $this->input->post('inputInsert');

    $updateHeader = $this->M_gentskk->UpdateHeaderTSKK($id,$judul,$type,$kode_part,$nama_part,$no_alat,$seksi,$proses,$kode_proses,$mesin,$proses_ke,$dari,$tanggal,$qty,$operator,$nilai_distribusi);
    // echo $updateHeader;
    // exit();

    //dihapus duls ye, baru diinsert//
    $deleteElement =  $this->M_gentskk->deleteObservation($id);

    $waktu_1          = $this->input->post('fanny[]');
    $waktu_2          = $this->input->post('waktu2[]');
    $waktu_3          = $this->input->post('waktu3[]');
    $waktu_4          = $this->input->post('waktu4[]');
    $waktu_5          = $this->input->post('waktu5[]');
    $waktu_6          = $this->input->post('waktu6[]');
    $waktu_7          = $this->input->post('waktu7[]');
    $waktu_8          = $this->input->post('waktu8[]');
    $waktu_9          = $this->input->post('waktu9[]');
    $waktu_10         = $this->input->post('waktu10[]');
    $x_min            = $this->input->post('xmin[]');
    $range            = $this->input->post('range[]');
    $waktu_distribusi = $this->input->post('wDistribusi[]');
    $waktu_kerja      = $this->input->post('wKerja[]');
    $keterangan       = $this->input->post('keterangan[]');
    $takt_time        = $this->input->post('taktTime');
    $jenis_proses 	  = $this->input->post('slcJenisProses[]');
    $elemen           = $this->input->post('txtSlcElemen[]');
    $keterangan_elemen= $this->input->post('julia[]');
    $tipe_urutan 	  = $this->input->post('slcTipeUrutan[]');

    for ($i=0; $i < count($elemen); $i++) {

        if ($waktu_1[$i] != ''){
            $w1             = $waktu_1[$i];
        }else{
            $w1 	        = null;
        }

        if ($waktu_2[$i] != ''){
            $w2             = $waktu_2[$i];
        }else{
            $w2 	        = null;
        }

        if ($waktu_3[$i] != ''){
            $w3             = $waktu_3[$i];
        }else{
            $w3 	        = null;
        }

        if ($waktu_4[$i] != ''){
            $w4             = $waktu_4[$i];
        }else{
            $w4 	        = null;
        }

        if ($waktu_5[$i] != ''){
            $w5             = $waktu_5[$i];
        }else{
            $w5 	        = null;
        }

        if ($waktu_6[$i] != ''){
            $w6            = $waktu_6[$i];
        }else{
            $w6 	       = null;
        }

        if ($waktu_7[$i] != ''){
            $w7            = $waktu_7[$i];
        }else{
            $w7	           = null;
        }

        if ($waktu_8[$i] != ''){
            $w8            = $waktu_8[$i];
        }else{
            $w8 	       = null;
        }

        if ($waktu_9[$i] != ''){
            $w9            = $waktu_9[$i];
        }else{
            $w9 	       = null;
        }

        if ($waktu_10[$i] != ''){
            $w10           = $waktu_10[$i];
        }else{
            $w10 	       = null;
        }

        if ($x_min[$i] != ''){
            $xm            = $x_min[$i];
        }else{
            $xm 	       = null;
        }

        if ($range[$i] != ''){
            $r            = $range[$i];
        }else{
            $r 	          = null;
        }

        if ($waktu_distribusi[$i] != ''){
            $w_dst         = $waktu_distribusi[$i];
        }else{
            $w_dst 	       = null;
        }

        if ($waktu_kerja[$i] != ''){
            $wk            = $waktu_kerja[$i];
        }else{
            $wk 	       = null;
        }

        if ($keterangan[$i] != ''){
            $ktr           = $keterangan[$i];
        }else{
            $ktr 	       = null;
        }

        if ($jenis_proses[$i] != ''){
            $jp            = $jenis_proses[$i];
        }else{
            $jp 	       = null;
        }

        if ($elemen[$i] != ''){
            $elm           = $elemen[$i];
        }else{
            $elm 	       = null;
        }

        if ($keterangan_elemen[$i] != ''){
            $ktr_elm       = $keterangan_elemen[$i];
        }else{
            $ktr_elm 	   = null;
        }

        if ($tipe_urutan[$i] != ''){
            $tu            = $tipe_urutan[$i];
        }else{
            $tu 	       = null;
        }

            $data = array(
            'id_tskk'  	        => $id,
            'waktu_1' 	        => $w1,
            'waktu_2'           => $w2,
            'waktu_3'   	    => $w3,
            'waktu_4' 	        => $w4,
            'waktu_5' 	        => $w5,
            'waktu_6' 	        => $w6,
            'waktu_7'       	=> $w7,
            'waktu_8'       	=> $w8,
            'waktu_9'       	=> $w9,
            'waktu_10'       	=> $w10,
            'x_min'       	    => $xm,
            'r'       	        => $r,
            'waktu_distribusi'  => $w_dst,
            'waktu_kerja'       => $wk,
            'keterangan'       	=> $ktr,
            'takt_time'       	=> $takt_time,
            'jenis_proses'      => $jp,
            'elemen'        	=> $elm,
            'keterangan_elemen' => $ktr_elm,
            'tipe_urutan'       => $tu,
            );
        if ($data['jenis_proses'] != null) {
            $insert = $this->M_gentskk->saveObservation($data);
        }
    }

    // $data['lihat_hasilObservasi'] = $this->M_gentskk->getAllObservation($id);

    redirect('GeneratorTSKK/Generate/CreateTSKK');
}

public function tipeProduk()
{
    $tp = $this->input->GET('tp',TRUE);
    $tipeProduk = $this->M_gentskk->getTipeProduk($tp);
    echo json_encode($tipeProduk);
}

public function kodePart()
{
    $variable = $this->input->GET('variable',TRUE);
    $variable = strtoupper($variable);
    $kode = $this->M_gentskk->kodePart($variable);
    echo json_encode($kode);
}

public function namaPart()
{
    $param = $this->input->post('params');
    if ($param !== '') {
        $last = $param[0];
    }

    if ($param != '') {
        $name = $this->M_gentskk->namaPart($last); //jalankan query
        echo json_encode($name);
    }else {
        $name = '';
        echo json_encode($name);
    }
}

public function NoMesin()
{
    $nm = $this->input->GET('nm',TRUE);
    $nm = strtoupper($nm);
    $noMesin = $this->M_gentskk->SelectNoMesin($nm);
    echo json_encode($noMesin);
}

public function jenisMesin()
{
    $param = $this->input->post('params');
        if ($param !== '') {
            $jenis = $this->M_gentskk->jenisMesin($param);
            echo json_encode($jenis);
        }else{
            $jenis = '';
            echo json_encode($jenis);
        }
}

public function resourceMesin()
{
    $param = $this->input->post('params');
        if ($param !== '') {

            $resource = $this->M_gentskk->Resource($param);

            echo json_encode($resource);
        }else{
            $resource = '';
            echo json_encode($resource);
        }
}

public function AlatBantu()
{
    $ab = $this->input->GET('ab',TRUE);
    $ab = strtoupper($ab);
    $alatBantu = $this->M_gentskk->selectAlatBantu($ab);
    echo json_encode($alatBantu);
}

public function Tools()
{
    $tl = $this->input->GET('tl',TRUE);
    $tl = strtoupper($tl);
    $tools = $this->M_gentskk->selectTools($tl);
    echo json_encode($tools);
}

public function Seksi()
{
    $term = $this->input->GET('term',TRUE);
    $term = strtoupper($term);
    $seksi = $this->M_gentskk->Seksi($term);
    echo json_encode($seksi);
}

public function Mesin()
{
    $mach = $this->input->GET('mach',TRUE);
    $mach = strtoupper($mach);
    $mesin = $this->M_gentskk->Mesin($mach);
    echo json_encode($mesin);
}

public function Operator()
{
    $opr = $this->input->GET('opr',TRUE);
    $opr = strtoupper($opr);
    $operator = $this->M_gentskk->Operator($opr);
    echo json_encode($operator);
}

public function ElemenKerja()
{
    $elk = $this->input->GET('elk',TRUE);
    // $elk = strtoupper($elk);
    $elm_krj = $this->M_gentskk->ElemenKerja($elk);
    echo json_encode($elm_krj);
}

public function CrossDelete($id)
{
    $newID  = $this->M_gentskk->cariId($id);

    $id_del = $newID[0]['id_tskk'];

    $deleteElement =  $this->M_gentskk->deleteElement($id_del);

    //TABLE//
    $jenis_proses 	= $this->input->post('slcJenisProses[]');
    $elemen         = $this->input->post('txtSlcElemen[]');
    $keterangan 	= $this->input->post('elemen[]');
    $tipe_urutan 	= $this->input->post('slcTipeUrutan[]');
    $start 	        = $this->input->post('mulai[]');
    $finish 	    = $this->input->post('finish[]');
    $waktu 	        = $this->input->post('waktu[]');

    //insert lagi cuy
    for ($i=0; $i < count($jenis_proses); $i++) {
        $data = array(
            'jenis_proses'  	  => $jenis_proses[$i],
            'elemen' 	          => $elemen[$i],
            'keterangan_elemen'   => $keterangan[$i],
            'tipe_urutan'   	  => $tipe_urutan[$i],
            'mulai' 	          => $start[$i],
            'finish' 	          => $finish[$i],
            'waktu' 	          => $waktu[$i],
            'id_tskk'       	  => $id,
        );

        $insert = $this->M_gentskk->tabelelemen($data);
    }
}

public function AngkaToChar($sisa){
    if ($sisa == 1){
        $kolom = 'A';
      }elseif ($sisa == 2) {
        $kolom = 'B';
      }elseif ($sisa == 3) {
        $kolom = 'C';
      }elseif ($sisa == 4) {
        $kolom = 'D';
      }elseif ($sisa == 5) {
        $kolom = 'E';
      }elseif ($sisa == 6) {
        $kolom = 'F';
      }elseif ($sisa == 7) {
        $kolom = 'G';
      }elseif ($sisa == 8) {
        $kolom = 'H';
      }elseif ($sisa == 9) {
        $kolom = 'I';
      }elseif ($sisa == 10) {
        $kolom = 'J';
      }elseif ($sisa == 11) {
        $kolom = 'K';
      }elseif ($sisa == 12) {
        $kolom = 'L';
      }elseif ($sisa == 13) {
        $kolom = 'M';
      }elseif ($sisa == 14) {
        $kolom = 'N';
      }elseif ($sisa == 15) {
        $kolom = 'O';
      }elseif ($sisa == 16) {
        $kolom = 'P';
      }elseif ($sisa == 17) {
        $kolom = 'Q';
      }elseif ($sisa == 18) {
        $kolom = 'R';
      }elseif ($sisa == 19) {
        $kolom = 'S';
      }elseif ($sisa == 20) {
        $kolom = 'T';
      }elseif ($sisa == 21) {
        $kolom = 'U';
      }elseif ($sisa == 22) {
        $kolom = 'V';
      }elseif ($sisa == 23) {
        $kolom = 'W';
      }elseif ($sisa == 24) {
        $kolom = 'X';
      }elseif ($sisa == 25) {
        $kolom = 'Y';
      }elseif ($sisa == 26) {
        $kolom = 'Z';
      } else {
          $kolom = NULL;
      }
      return $kolom;
}

public function Kolom($c){
    //KONVERSI ANGKA KE NAMA KOLOM
    $c = intval($c);
    if ($c <= 0) return '';

    $letter = '';

    while($c != 0){
       $p = ($c - 1) % 26;
       $c = intval(($c - $p) / 26);
       $letter = chr(65 + $p) . $letter;
    }

    return $letter;
}

public function deleteFile($id){

    $judul          = $this->input->post('judul');
    $tanggal        = $this->input->post('tanggal');

    unlink('./assets/upload/GeneratorTSKK/TSKK_'.$judul.'_'.$tanggal.'.xlsx');
}

public function exportExcel($idnya){
    // echo "<pre>"; print_r($id); exit();
		set_include_path( get_include_path().PATH_SEPARATOR."..");
		include_once("xlsxwriter.class.php");
		if ($idnya == 'paklut') {
			//HEADER
		 // echo "<pre>"; print_r($_POST);exit();
		 $judul            = $this->input->post('judul');

		 //PART
		 $type             = $this->input->post('type');
		 $kode_part        = $this->input->post('kode_part');
		 $nama_part        = $this->input->post('nama_part');
		 //EQUIPMENT
		 $no_mesin         = $this->input->post('no_mesin');
		 $nm = implode("; ", $no_mesin);
		 $jenis_mesin      = $this->input->post('jenis_mesin');
		 $resource         = $this->input->post('resource');
		 $line             = $this->input->post('line');
		 $alat_bantu       = $this->input->post('alat_bantu');
		 $ab = explode("; ", $alat_bantu);
		 $tools            = $this->input->post('tools');
		 $tl = explode("; ", $tools);
		 //SDM
		 $operator         = $this->input->post('nama');
		 $a = explode(" - ", $operator);
		 $nama_operator = $a[0];
		 $no_induk = $a[1];
		 $jml_operator     = $this->input->post('jumlah_operator');
		 $dr_operator      = $this->input->post('dari_operator');
		 $seksi            = $this->input->post('seksi');
		 //PROCESS
		 $proses           = $this->input->post('proses');
		 $kode_proses      = $this->input->post('kode_proses');
		 $proses_ke        = $this->input->post('proses_ke');
		 $qty              = $this->input->post('qty');
		 $dari             = $this->input->post('dari');
		 //ACTIVITY
		 $tanggal          = $this->input->post('tanggal');
		 //SEKSI PEMBUAT
		 $noind = $this->session->user;
		 $data['getSeksiUnit'] = $this->M_gentskk->detectSeksiUnit($noind);
		 $split = $data['getSeksiUnit'][0];
		 $seksi_pembuat = $split['seksi'];
		 $dept_pembuat = $split['dept'];

		 //TSKK PRINTER :v
		 $noind = $this->session->user;
		 $name = $this->M_gentskk->selectNamaPekerja($noind);
		 $nama_pekerja = $name[0]['nama'];
		 $creationDate = date('d-M-Y');
		 $generateDate = str_replace("-", " ", $creationDate);

		 //DATA FOR TSKK (elements table)
		 $id_tskk          = $this->input->post('id');

		 $takt_time        = $this->input->post('takt_time');
		 if ($takt_time != '-') {
			 $takt_time = $takt_time * $qty;
		 }
		 $jenis_proses     = $this->input->post('jenis_proses_elemen');
		 $elemen           = $this->input->post('elemen_kerja');
		 $keterangan_elemen= $this->input->post('keterangan_elemen_kerja');
		 $tipe_urutan      = $this->input->post('tipe_urutan_elemen');
		 $start            = $this->input->post('mulai');
		 $finish           = $this->input->post('finish');
		 $last_finish      = max($finish);
		 // echo "<pre>"; echo $last_finish;die;
		 $waktu            = $this->input->post('waktu');

		}else {
			// code...

		$newID           = $this->M_gentskk->selectAll($idnya);
		$getIrregularJob = $this->M_gentskk->selectIrregularJobs($idnya);
		// echo "<pre>";print_r($getIrregularJob);exit();

		//HEADER//
		// echo "<pre>"; print_r($_POST);exit();
		$judul            = $newID[0]['judul_tskk'];
		//PART
		$type 	          = $newID[0]['tipe'];
		$kode_part 	      = $newID[0]['kode_part'];
		$nama_part 	      = $newID[0]['nama_part'];
		//EQUIPMENT
		$no_mesin	      = $newID[0]['no_mesin'];
		$nm = explode("; ", trim($no_mesin));
		$jenis_mesin      = $newID[0]['mesin'];
		$resource         = $newID[0]['resource_mesin'];
		$line             = $newID[0]['line_process'];
		$alat_bantu	      = $newID[0]['alat_bantu'];
		$ab = explode("; ", $alat_bantu);

		$tools            = $newID[0]['tools'];
		$tl = explode("; ", $tools);
		//SDM
		$operator	      = $newID[0]['operator'];
		$a = explode(" - ", $operator);
		$nama_operator = $a[0];
		$no_induk = $a[1];

		$jml_operator     = $newID[0]['jumlah_operator'];
		$dr_operator      = $newID[0]['jumlah_operator_dari'];
		$seksi 	          = $newID[0]['seksi'];
		//PROCESS
		$proses 	      = $newID[0]['proses'];
		$kode_proses      = $newID[0]['kode_proses'];
		$proses_ke 	      = $newID[0]['proses_ke'];
		$qty 	          = $newID[0]['qty'];
		$dari 	          = $newID[0]['proses_dari'];
		//ACTIVITY
		$tanggal          = $newID[0]['tanggal'];
		//SEKSI PEMBUAT
		$noind = $this->session->user;
		$data['getSeksiUnit'] = $this->M_gentskk->detectSeksiUnit($noind);
		$split = $data['getSeksiUnit'][0];
		$seksi_pembuat = $split['seksi'];
		$dept_pembuat = $split['dept'];

		//DATA FOR TSKK (elements table)
		$id_tskk          = $newID[0]['id_tskk'];
		$takt_time        = $newID[0]['takt_time'];

		$jenis_proses 	  = array_column($newID, 'jenis_proses');
		$elemen           = array_column($newID, 'elemen');
		$keterangan_elemen= array_column($newID, 'keterangan_elemen');
		$tipe_urutan 	  = array_column($newID, 'tipe_urutan');
		$start 	          = array_column($newID, 'mulai');
		$finish 	      = array_column($newID, 'finish');

		$last_finish      = max($finish);
		$waktu 	          = array_column($newID, 'waktu');

		//TSKK PRINTER :v
		$noind = $this->session->user;
		$name = $this->M_gentskk->selectNamaPekerja($noind);
		$nama_pekerja = $name[0]['nama'];
		$creationDate = date('d-M-Y');
		$generateDate = str_replace("-", " ", $creationDate);
	}
// echo "-------------";
// echo "<pre>";
// print_r($waktu);
// echo "-------------";
// echo "<pre>";
// print_r($last_finish);die;

	if (count($elemen) < 40) {
		for ($i= 0; $i < 40; $i++) {

			if (!empty($elemen[$i])) {
				$elemen_[$i] = $elemen[$i];
				$keterangan_elemen_[$i] = $keterangan_elemen[$i];
				$jenis_proses_[$i] = $jenis_proses[$i];
				$tipe_urutan_[$i] = $tipe_urutan[$i];
				$start_[$i] = $start[$i];
				$finish_[$i] = $finish[$i];
				$waktu_[$i] = $waktu[$i];
			}else {
				$elemen_[$i] = '';
				$keterangan_elemen_[$i] = '';
				$jenis_proses_[$i] = '';
				$tipe_urutan_[$i] = '';
				$start_[$i] = '';
				$finish_[$i] = '';
				$waktu_[$i] = '';
			}

		}

			// inisiasi elemen kembali karna elemen memiliki nilai max
			$elemen = $elemen_;
			$keterangan_elemen = $keterangan_elemen_;
			$jenis_proses = $jenis_proses_;
			$tipe_urutan = $tipe_urutan_;
			$start = $start_;
			$finish = $finish_;
			$waktu = $waktu_;
	}


	if ($takt_time == 99999) {
		$takt_time = '-';
	}


     //PENGHITUNGAN MUDA
    for ($i=0; $i < count($elemen) ; $i++) {

        if ($i != 0) {
            if ($jenis_proses[$i-1] != 'AUTO') {
                $muda[$i] = $start[$i] - $finish[$i-1]-1;
                $mudaAuto[$i] = false;
            }elseif ($jenis_proses[$i-1] == 'AUTO' && $i > 1) {
                $muda[$i] = $start[$i] - $finish[$i-2]-1;
                $mudaAuto[$i] = true;
            }
        }else{
            $muda[$i] = 1;
            $mudaAuto[$i] = 'tidakMuda';
        }
    }
    // die;

    $selectIdElemen = $this->M_gentskk->selectIdElemen($id_tskk);
    if ($selectIdElemen == null) {
        $id = null;
    }else{
        $id = $selectIdElemen[0]['id_tskk'];
    }

    if ($id != null) {
        $deleteElemen = $this->M_gentskk->deleteElemen($id);
        // echo count($elemen);
        for ($i=0; $i < count($elemen); $i++) {
            if ($i != 0) {
                $data = array(
                    'jenis_proses'      => $jenis_proses[$i],
                    'elemen'            => $elemen[$i],
                    'keterangan_elemen' => $keterangan_elemen[$i],
                    'tipe_urutan'       => $tipe_urutan[$i],
                    'mulai'             => $start[$i],
                    'finish'            => $finish[$i],
                    'waktu'             => $waktu[$i],
                    'muda'              => $start[$i] - $finish[$i-1],
                    'id_tskk'           => $id_tskk
                );
            }else {
                $data = array(
                    'jenis_proses'      => $jenis_proses[$i],
                    'elemen'            => $elemen[$i],
                    'keterangan_elemen' => $keterangan_elemen[$i],
                    'tipe_urutan'       => $tipe_urutan[$i],
                    'mulai'             => $start[$i],
                    'finish'            => $finish[$i],
                    'waktu'             => $waktu[$i],
                    'muda'              => 1,
                    'id_tskk'           => $id_tskk
                );
            }

            if ($data['jenis_proses'] != null) {
                $insert = $this->M_gentskk->tabelelemen($data);
            }
        // echo "<pre>";print_r($data);
        }
    }else{
        for ($i=0; $i < count($elemen); $i++) {
            if ($i != 0) {
                $data = array(
                    'jenis_proses'      => $jenis_proses[$i],
                    'elemen'            => $elemen[$i],
                    'keterangan_elemen' => $keterangan_elemen[$i],
                    'tipe_urutan'       => $tipe_urutan[$i],
                    'mulai'             => $start[$i],
                    'finish'            => $finish[$i],
                    'waktu'             => $waktu[$i],
                    'muda'              => $start[$i] - $finish[$i-1],
                    'id_tskk'           => $id_tskk
                );
            }else {
                $data = array(
                    'jenis_proses'      => $jenis_proses[$i],
                    'elemen'            => $elemen[$i],
                    'keterangan_elemen' => $keterangan_elemen[$i],
                    'tipe_urutan'       => $tipe_urutan[$i],
                    'mulai'             => $start[$i],
                    'finish'            => $finish[$i],
                    'waktu'             => $waktu[$i],
                    'muda'              => 1,
                    'id_tskk'           => $id_tskk
                );
            }

            if ($data['jenis_proses'] != null) {
                $insert = $this->M_gentskk->tabelelemen($data);
            }
        // echo "<pre>";print_r($data);
        }
    // exit();

    }

    //DATA FOR NOTES AND TAKT TIME CALCULATION
		if ($idnya == 'paklut') {
			$waktu_satu_shift   = $this->input->post('waktu_satu_shift');
			$jumlah_shift       = $this->input->post('jumlah_shift');
			$forecast           = $this->input->post('forecast');
			$qty_unit           = $this->input->post('qty_unit');
			$rencana_produksi   = $forecast*$qty_unit;
			$jumlah_hari_kerja  = $this->input->post('jumlah_hari_kerja');
		}else {
			$dataTakTime        = $this->M_gentskk->selectTaktTimeCalculation($id_tskk);
			// echo "<pre>";print_r($dataTakTime);die;
			$waktu_satu_shift   = $dataTakTime[0]['waktu_satu_shift'];
			$jumlah_shift       = $dataTakTime[0]['jumlah_shift'];
			$forecast           = $dataTakTime[0]['forecast'];
			$qty_unit           = $dataTakTime[0]['qty_unit'];
			$rencana_produksi   = $dataTakTime[0]['forecast'] * $dataTakTime[0]['qty_unit'];
			$jumlah_hari_kerja  = $dataTakTime[0]['jumlah_hari_kerja'];
		}


    //Make "elemen kerja" from combination of "elemen & keterangan"//
    $elemen_kerja =  array();

    for ($i=0; $i < count($elemen) ; $i++) {
        // $elemen_kerja[$i] = $elemen[$i]." ".$keterangan_elemen[$i];
        $elemen_kerja[$i] = "   ".$elemen[$i]." ".$keterangan_elemen[$i];
        // $elemen_kerja[$i] = $elemen[$i];
    }

//COUNT THE TOTAL TIMES :
       $indexArr = 0;
       $jumlah = 0;
       $jumlah_manual = 0;
       $jumlah_auto = 0;
       $jumlah_walk = 0;
       $jml_baris = 1; //BLM TNT
       $elemenWaktu = $elemen_kerja[0];


       for($i=0; $i < count($waktu); $i++){
           if ($elemenWaktu != $elemen_kerja[$i]) {
               $jml_baris++;
           }
            $j = $jenis_proses[$i];
                if ($j == 'MANUAL') {
                    $jumlah_manual=$waktu[$i]+$jumlah_manual;
                }elseif ($j == 'AUTO' || $j == 'AUTO (Inheritance)') {
                    $jumlah_auto=$waktu[$i]+$jumlah_auto;
                }else{
                    $jumlah_walk=$waktu[$i]+$jumlah_walk;
                }
        $jumlah=$waktu[$i]+$jumlah;
      }

    $indexSatu=18;
      $indexDua=18;

      //set pembulatan dengan mengisi angka, x_X
    // if ($jumlah < 600) {
    //     $end = 600;
    // } else {
    //     // echo $jumlah; exit();
    //     $g = (int)($jumlah / 10);
    //     $g += 1;
    //     $end = $g * 10;
    //     // echo "g = $g <br>jml = $jumlah <br>".$end;
    // }

    //IRREGULAR JOBS

		if ($idnya == 'paklut') {
			$irregular_jobs         = $this->input->post('irregular_job');
			$ratio_irregular        = $this->input->post('ratio_ij');
			$waktu_irregular        = $this->input->post('waktu_ij');
			$hasil_irregular        = !empty($this->input->post('hasil_ij')) ? $this->input->post('hasil_ij') : [];
			$jumlah_hasil_irregular = array_sum($hasil_irregular);
		}else {
			//IRREGULAR JOBS
			$dataIrregularJob       = $this->M_gentskk->selectIrregularJobs($id_tskk);
			$irregular_jobs         = array_column($dataIrregularJob, 'irregular_job');
			$ratio_irregular        = array_column($dataIrregularJob, 'ratio');
			$waktu_irregular        = array_column($dataIrregularJob, 'waktu');
			$hasil_irregular        = array_column($dataIrregularJob, 'hasil_irregular_job');
			$jumlah_hasil_irregular = array_sum($hasil_irregular);
		}

    // echo $hasil_irregular;die;

    //checking the length based on cycle time too
        $cycle_time = $last_finish + $jumlah_hasil_irregular;
        $cycle_time_tanpa_irregular = $last_finish;
        $cycleTimeText = $cycle_time + 3;
        // echo"<pre>"; echo $cycle_time;
        // echo"<pre>"; echo "KAGA";

    if ($jumlah >= $takt_time) {
        $akhir = $jumlah;
    } else {
        $akhir = $takt_time;
    }

    // if ($cycle_time < 450) {

    // if ($akhir <= 600) {
        // $end = 600;
    // } else {
    //     // echo $jumlah; exit();
    //     // $g = (int)($cycle_time / 10);
    //     $g = (int)($akhir / 10);
    //     $g += 1;
    //     $end = $g * 10;
    //     // echo "g = $g <br>jml = $jumlah <br>".$end;
    // }

    //MERGING DETIK//
    // $indexAngka = 18; // LAMA
    $indexAngka = 14;
    $indexStart = 1;
    //LUTFI IN DE HAUS
    //MULAI PAKE XLSXWriternya
    $writer = new XLSXWriter();
    // $writer->setTitle('TSKK kerr');
    // $writer->setSubject('Tabel Standar Kerja Kombinasi');
    // $writer->setAuthor('#L');
    // $writer->setCompany('ICT - Produksi');
    // // $writer->setKeywords($keywords);
    // $writer->setDescription('Tabel Standar Kerja Kombinasi');
    // $writer->setTempDir(sys_get_temp_dir());

    $sheet1 = 'TSKK';

		//aldi custom 2021
		$page_setup = [
			'orientation' => 'landscape', // choose 'landscape' or 'portrait'
			'scale' => 50,                // percent
			// 'fit_to_width' => 1,        // When "Fit to page", specify the number of pages
			// 'fit_to_height' => 1,       // When "Fit to page", specify the number of pages
			'paper_size' => 8,            // 9=xlPaperA4 : specify XlPaperSize value. see https://msdn.microsoft.com/vba/excel-vba/articles/xlpapersize-enumeration-excel
			//'horizontal_dpi' => 600,
			//'vertical_dpi' => 600,
			//'first_page_number' => 1,
			//'use_first_page_number' => false,

			// Specify margin in inches (not in centimeters)
			'margin_left' => 0.2,
			'margin_right' => 0.2,
			'margin_top' => 0.2,
			'margin_bottom' => 0.2,
			'margin_header' => 0,
			'margin_footer' => 0,
			'horizontal_centered' => true,
			'vertical_centered' => true,

			// Header\Footer can be customized.
			// for details on how to write, refer to 'Remarks' of https://msdn.microsoft.com/library/documentformat.openxml.spreadsheet.evenheader.aspx
			'header' => '',      // ex. fixed-text
			'footer' => '', // ex. page number

			// 'print_area' => 'A1:F5',
			// 'print_titles' => '$1:$1',
			// Note : When setting multiple ranges, specify by array. ex. 'print_titles' => ['$1:$1', '$A:$A'],

			'page_order' => 'downThenOver', // choose 'overThenDown' or 'downThenOver'
			//'grid_lines' => false,
			//'black_and_white' => false,
			//'draft' => false,
			'headings' => false,
			//'cell_comments' => 'none',    // 'asDisplayed', 'atEnd', 'none' can be selected
			//'errors' => 'displayed',      // 'blank', 'dash', 'displayed', 'NA' can be selected

			//'use_printer_defaults' => true,
			//'copies' => 1,
			];

    if ($cycle_time > $takt_time) {
      $paling_lama = $cycle_time;
    }else {
      $paling_lama = $takt_time;
    }

    $loop_ = ceil($paling_lama/600);
    for ($x=1; $x <=$loop_; $x++) {

    $end = 600;

		$kolomA   = $this->Kolom($indexAngka);
		$kolomB   = $this->Kolom($indexAngka + $end);
		$kolomJDL = $this->Kolom($indexStart);

    $width = array();
    for ($i=0; $i < ($indexAngka + $end); $i++) {
        if($i == 0) {
            $width[$i] = 4.5;
        } elseif ($i >= 1 && $i <=8) {
            $width[$i] = 7.30;
        } elseif ($i >= 9 && $i <=11) {
            $width[$i] = 6.30;
        } else {
            $width[$i] = 0.34;
        }
    }
    // STYLING HEADER
        $col_options['widths'] = $width;
        $col_options['halign'] = 'center';
				$col_options['page_setup'] = $page_setup;
    // SET DATA HEADER
        $header = array(
        $judul.' | '.$nama_pekerja.' ('.$noind.') : '.$generateDate=>'string' //text
        );

    //inisiasi awal array tiap row
        $jmlIrregular = sizeof($irregular_jobs);
        if ($jmlIrregular <=5) {
            $brsIrregular = 10;
        } else {
            $brsIrregular = $jmlIrregular * 2;
        }
        $totalrow = 14 + (sizeof($elemen_kerja)*3) + 8 + $brsIrregular + 8;
        for ($j=0; $j < $totalrow; $j++) {
            for ($i=0; $i < ($indexAngka + $end); $i++) {
                $rows[$x][$j][$i] = '';
                $styles[$x][$j][$i] = '';
            }
        }


    //STYLING CARA BARU
        $row = 16;
        $col = ($indexAngka + $end) + 1;
        for ($j=0; $j < $row; $j++) {
            for ($i=0; $i<= $col; $i++) {
            //RESET NULL STYLE EVERY LOOP
                    $font = null;
                    $fontsize = null;
                    $fontstyle = null; //bold, italic, underline, strikethrough or multiple ie: 'bold,italic'
                    $border = null; //left, right, top, bottom, or multiple ie: 'top,left'
                    $borderstyle = null; //thin, medium, thin, dashDot, dashDotDot, dashed, dotted, double, hair, mediumDashDot, mediumDashDotDot, mediumDashed, slantDashDot
                    $bordercolor = null;
                    $color = null;
                    $fill = null;
                    $valign = null; //bottom, center, distributed
                    $halign = null; //general, left, right, justify, center

            //BORDER, BORDER-STYLE, BORDER COLOR
                    if ($j == 0) {
                        if ($i == 0) {
                            $border = 'left,top';
                            $borderstyle = 'thin';
                        }elseif ($i == 8 || $i == 185 || $i == 319 || $i == 400 || $i == 449 || $i == 490  || $i == 613) {
                            $border = 'right,top';
                            $borderstyle = 'thin';
                        } elseif ($i < 613) {
                            $border = 'top';
                            $borderstyle = 'thin';
                        } else {

                        }
                    } elseif ($j == 1) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 8 || $i == 185 || $i == 319 || $i == 400 || $i == 449 || $i == 490  || $i == 613) {
                            $border='right';
                            $borderstyle='thin';
                        } elseif ($i >= 186 && $i < 490) {
                            $border='top';
                            $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 2) {
                        if ($i == 0) {
                            $border = 'left';
                            $borderstyle = 'thin';
                        } elseif ($i == 8 || $i == 185 || $i == 319 || $i == 400 || $i == 449 || $i == 490  || $i == 613) {
                            $border='right';
                            $borderstyle='thin';
                        } elseif ($i >= 491 && $i < 613) {
                                $border='top';
                                $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 3) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 8 || $i == 185 || $i == 319 || $i == 400 || $i == 449 || $i == 490  || $i == 613) {
                            $border='right';
                            $borderstyle='thin';
                        } elseif ($i >= 9 && $i < 185) {
                            $border='top';
                            $borderstyle='thin';
                        } elseif ($i >= 186 && $i < 490) {
                            $border='top,bottom';
                            $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 4) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 8 || $i == 185 || $i == 319 || $i == 400 || $i == 449 || $i == 490  || $i == 613) {
                            $border='right';
                            $borderstyle='thin';
                        } elseif ($i >= 491 && $i < 613) {
                            $border='top';
                            $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 5) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 8 || $i == 185 || $i == 319 || $i == 400 || $i == 449 || $i == 490  || $i == 613) {
                            $border='right';
                            $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 6) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 8 || $i == 185 || $i == 319 || $i == 400 || $i == 449 || $i == 490  || $i == 613) {
                            $border='right';
                            $borderstyle='thin';
                        } elseif ($i >= 186 && $i < 490) {
                            $border='top,bottom';
                            $borderstyle='thin';
                        } elseif ($i >= 491 && $i < 613) {
                            $border='top';
                            $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 7) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 8 || $i == 185 || $i == 319 || $i == 400 || $i == 449 || $i == 490  || $i == 613) {
                            $border='right';
                            $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 8) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 8 || $i == 185 || $i == 319 || $i == 400 || $i == 449 || $i == 490  || $i == 613) {
                            $border='right';
                            $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 9) {
                        if ($i > 613) {
                            $border='bottom';
                            $borderstyle='thin';
                        } elseif ($i == 12 || $i == 13) {
                            $border='top';
                            $borderstyle='thin';
                        } else {
                            $border='top,bottom';
                            $borderstyle='thin';
                        }
                    } elseif ($j == 10) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 1 || $i == 9 || $i == 10 || $i == 11) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 12) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 13 || $i == ($indexAngka + $end - 1)) {
                            $border='right';
                            $borderstyle='thin';
                        } elseif ($i < ($indexAngka + $end)) {
                            $border='bottom';
                            $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 11) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 1 || $i == 9 || $i == 10 || $i == 11) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 12) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 13 || $i == ($indexAngka + $end - 1)) {
                            $border='right';
                            $borderstyle='thin';
                        } elseif ($i < ($indexAngka + $end) && $i >= 14) {
                            if (($i-14)%10 == 0) {
                                $border='left,bottom';
                                $borderstyle='thin';
                            } else {
                                $border='bottom';
                                $borderstyle='thin';
                            }
                        } else {

                        }
                    } elseif ($j == 12) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 1 || $i == 9 || $i == 10 || $i == 11) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 12) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 13 || $i == ($indexAngka + $end - 1)) {
                            $border='right';
                            $borderstyle='thin';
                        } elseif ($i < ($indexAngka + $end) && $i >= 14) {
                                $border='right';
                                $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 13) {
                        if ($i == 12 || $i == 13) {

                        } else {
                            $border='top,bottom';
                            $borderstyle='thin';
                        }
                    }
            //FONT, FONT-SIZE, FONT-STYLE, VALIGN, HALIGN
                    if ($j == 0) {
                        if ($i == 9) {
                            $fontsize = 18;
                            $fontstyle = 'bold';
                            $valign = 'center';
                            $halign = 'center';
                            $fill = '#fcba03';
                        }elseif ($i == 186 || $i == 320 || $i == 401 || $i == 450 || $i == 491) {
                            $fontsize = 9;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'left';
                        } elseif ($i == 522) {
                            $fontsize = 9;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'center';
                        } elseif ($i == 324) {
                            $fontsize = 8;
                            $fontstyle = 'bold';
                            $valign = 'center';
                            $halign = 'center';
                        } else {

                        }
                    } elseif ($j == 1) {
                        if ($i == 2) {
                            $fontsize = 14;
                            $fontstyle = 'bold';
                            $valign = 'center';
                            $halign = 'center';
                        }elseif ($i == 186 || $i == 320 || $i == 401 || $i == 450) {
                            $fontsize = 8;
                            $fontstyle = 'bold';
                            $valign = 'center';
                            $halign = 'center';
                        } else {

                        }
                    } elseif ($j == 2) {
                        if ($i == 2) {
                            $fontsize = 12;
                            $fontstyle = 'bold';
                            $valign = 'bottom';
                            $halign = 'center';
                        } elseif ($i == 491) {
                            $fontsize = 9;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'left';
                        } elseif ($i == 522) {
                            $fontsize = 9;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'center';
                        } elseif ($i == 324) {
                            $fontsize = 8;
                            $fontstyle = 'bold';
                            $valign = 'center';
                            $halign = 'center';
                        } else {

                        }
                    } elseif ($j == 3) {
                        if ($i == 9) {
                            $fontsize = 20;
                            $fontstyle = 'bold';
                            $valign = 'center';
                            $halign = 'center';
                        } elseif ($i == 186 || $i == 320 || $i == 401 || $i == 450) {
                            $fontsize = 9;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'left';
                        } else {

                        }
                    } elseif ($j == 4) {
                        if ($i == 2) {
                            $fontsize = 13;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'center';
                        }elseif ($i == 186 || $i == 320 || $i == 401 || $i == 450) {
                            $fontsize = 8;
                            $fontstyle = 'bold';
                            $valign = 'center';
                            $halign = 'center';
                        } elseif ($i == 491) {
                            $fontsize = 9;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'left';
                        } elseif ($i == 522) {
                            $fontsize = 9;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'center';
                        } elseif ($i == 324) {
                            $fontsize = 8;
                            $fontstyle = 'bold';
                            $valign = 'center';
                            $halign = 'center';
                        } else {

                        }
                    } elseif ($j == 5) {
                    } elseif ($j == 6) {
                        if ($i == 2) {
                            $fontsize = 13;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'center';
                        } elseif ($i == 186 || $i == 320 || $i == 401 || $i == 450 || $i == 491) {
                            $fontsize = 9;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'left';
                        } elseif ($i == 491) {
                            $fontsize = 9;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'left';
                        } elseif ($i == 522) {
                            $fontsize = 9;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'center';
                        } elseif ($i == 324) {
                            $fontsize = 8;
                            $fontstyle = 'bold';
                            $valign = 'center';
                            $halign = 'center';
                        } else {

                        }
                    } elseif ($j == 7) {
                        if ($i == 186 || $i == 320 || $i == 401 || $i == 450) {
                            $fontsize = 8;
                            $fontstyle = 'bold';
                            $valign = 'center';
                            $halign = 'center';
                        } else {

                        }
                    } elseif ($j == 8) {
                    } elseif ($j == 9) {
                    } elseif ($j == 10) {
                        if ($i == 0 || $i == 1 || $i == 9 || $i == 10 || $i == 11 || $i == 14) {
                            if ($i === 9) {
                                $fill = '#000000';
                                $color = '#ffffff';
                            } elseif ($i === 10) {
                                $fill = '#65eb00';
                            } elseif ($i === 11) {
                                $fill = '#00dbc5';
                            }
                            $fontsize = 8;
                            // $fontstyle = 'bold';
                            $valign = 'center';
                            $halign = 'center';
                        }
                    }

            //SET STYLE
                    if (isset($font)) {
                        $styles[$x][$j][$i]['font'] = $font;
                    }
                    if (isset($fontsize)) {
                        $styles[$x][$j][$i]['font-size'] = $fontsize;
                    }
                    if (isset($fontstyle)) {
                        $styles[$x][$j][$i]['font-style'] = $fontstyle;
                    }
                    if (isset($border)) {
                        $styles[$x][$j][$i]['border'] = $border;
                    }
                    if (isset($borderstyle)) {
                        $styles[$x][$j][$i]['border-style'] = $borderstyle;
                    }
                    if (isset($bordercolor)) {
                        $styles[$x][$j][$i]['border-color'] = $bordercolor;
                    }
                    if (isset($color)) {
                        $styles[$x][$j][$i]['color'] = $color;
                    }
                    if (isset($fill)) {
                        $styles[$x][$j][$i]['fill'] = $fill;
                    }
                    if (isset($valign)) {
                        $styles[$x][$j][$i]['valign'] = $valign;
                    }
                    if (isset($halign)) {
                        $styles[$x][$j][$i]['halign'] = $halign;
                    }
                    if(!isset($font) && !isset($fontsize) && !isset($fontstyle) && !isset($border) && !isset($borderstyle) && !isset($bordercolor) && !isset($color) && !isset($fill) && !isset($valign) && !isset($halign)) {
                        $styles[$x][$j][$i] = array();
                    }
            }
        }

    //STYLING ELEMEN KERJA
        $jumlahrow = sizeof($elemen_kerja)*3;
        $rowmulai = 14;
        $indexelemenrow = 0;
        for ($j=0; $j < $jumlahrow; $j++) {
            $rowelemen = $rowmulai + $j;
            for ($i=0; $i <= $col; $i++) {
                switch ($indexelemenrow) {
                    case 0:
                        if ($i === 0 || $i === 1 || $i === 9 || $i === 10 || $i === 11) {
                            $styles[$x][$rowelemen][$i]['border']='left';
                            $styles[$x][$rowelemen][$i]['border-style']='thin';
                        } elseif ($i === 12) {
                            $styles[$x][$rowelemen][$i]['border']='left';
                            $styles[$x][$rowelemen][$i]['border-style']='thin';
                        } elseif ($i === 13 || $i == ($indexAngka + $end - 1)) {
                            $styles[$x][$rowelemen][$i]['border']='right';
                            $styles[$x][$rowelemen][$i]['border-style']='thin';
                        } elseif ($i > 13) {
                            if (($i-14)%10 == 0) {
                                $styles[$x][$rowelemen][$i]['border']='left';
                                $styles[$x][$rowelemen][$i]['border-style']='thin';
                            }
                        }
                        break;
                    case 1:
                        if ($i === 0 || $i === 1 || $i === 9 || $i === 10 || $i === 11) {
                            $styles[$x][$rowelemen][$i]['border']='left';
                            $styles[$x][$rowelemen][$i]['border-style']='thin';
                        } elseif ($i === 12) {
                            $styles[$x][$rowelemen][$i]['border']='left';
                            $styles[$x][$rowelemen][$i]['border-style']='thin';
                        } elseif ($i === 13 || $i == ($indexAngka + $end - 1)) {
                            $styles[$x][$rowelemen][$i]['border']='right';
                            $styles[$x][$rowelemen][$i]['border-style']='thin';
                        } elseif ($i > 13) {
                            if (($i-14)%10 == 0) {
                                $styles[$x][$rowelemen][$i]['border']='left';
                                $styles[$x][$rowelemen][$i]['border-style']='thin';
                            }
                        }
                        break;
                    case 2:
                        if ($i === 0 || $i === 1 || $i === 9 || $i === 10 || $i === 11) {
                            $styles[$x][$rowelemen][$i]['border']='left,bottom';
                            $styles[$x][$rowelemen][$i]['border-style']='thin';
                        } elseif ($i === 12) {
                            $styles[$x][$rowelemen][$i]['border']='left';
                            $styles[$x][$rowelemen][$i]['border-style']='thin';
                        } elseif ($i < 13) {
                            $styles[$x][$rowelemen][$i]['border']='bottom';
                            $styles[$x][$rowelemen][$i]['border-style']='thin';
                        } elseif ($i === 13 || $i == ($indexAngka + $end - 1)) {
                            $styles[$x][$rowelemen][$i]['border']='right';
                            $styles[$x][$rowelemen][$i]['border-style']='thin';
                        } elseif ($i > 13) {
                            if (($i-14)%10 == 0) {
                                $styles[$x][$rowelemen][$i]['border']='left,bottom';
                                $styles[$x][$rowelemen][$i]['border-style']='thin';
                            } else {
                                $styles[$x][$rowelemen][$i]['border']='bottom';
                                $styles[$x][$rowelemen][$i]['border-style']='thin';
                            }
                        }
                        break;

                    default:
                        # code...
                        break;
                }
            }
            $indexelemenrow++;
            if ($indexelemenrow === 3) {
                $indexelemenrow = 0;
            }
        }
        //STYLING ROW TERAKHIR ELEMEN
            for ($i=0; $i < $col; $i++) {
                if ($i == 12 || $i == 13) {
                    # code...
                } elseif ($i <= 614) {
                    $styles[$x][$jumlahrow + $rowmulai][$i]['border']='top,bottom';
                    $styles[$x][$jumlahrow + $rowmulai][$i]['border-style']='thin';
                } else {
                    $styles[$x][$jumlahrow + $rowmulai][$i]['border']='top';
                    $styles[$x][$jumlahrow + $rowmulai][$i]['border-style']='thin';
                }
            }

        // STYLING JUMLAH
            $rJum = 14 + sizeof($elemen_kerja)*3 + 1;
            if ($jmlIrregular <= 5) {
                $irg = 5;
            } else {
                $irg = $jmlIrregular;
            }
            for ($j=0; $j <= (($irg*2)+13); $j++) {
                $baris = ($rJum + $j)+2;
								$sda[] = $baris;
                for ($i=0; $i <= 614; $i++) {
                    switch ($j) {
                        case 0:
                            if ($i === 0 || $i === 12) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
																$styles[$x][$baris-1][$i]['border']='left';
																$styles[$x][$baris-1][$i]['border-style']='thin';
																$styles[$x][$baris-2][$i]['border']='left';
																$styles[$x][$baris-2][$i]['border-style']='thin';
                            }elseif ($i === 613) {
															$styles[$x][$baris][$i]['border']='right';
															$styles[$x][$baris][$i]['border-style']='thin';
															$styles[$x][$baris-1][$i]['border']='right';
															$styles[$x][$baris-1][$i]['border-style']='thin';
															$styles[$x][$baris-2][$i]['border']='right';
															$styles[$x][$baris-2][$i]['border-style']='thin';
                            } elseif ($i === 10 ||$i === 9) {
															$styles[$x][$baris][$i]['border']='left,right';
															$styles[$x][$baris][$i]['border-style']='thin';
															$styles[$x][$baris-1][$i]['border']='left,right';
															$styles[$x][$baris-1][$i]['border-style']='thin';
															$styles[$x][$baris-2][$i]['border']='left,right';
															$styles[$x][$baris-2][$i]['border-style']='thin';
                            } elseif ($i === 258 || $i === 377 || $i === 495) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
																$styles[$x][$baris-1][$i]['border']='right';
																$styles[$x][$baris-1][$i]['border-style']='thin';
																$styles[$x][$baris-2][$i]['border']='right';
																$styles[$x][$baris-2][$i]['border-style']='thin';
                            }elseif ($i === 11) {
																$styles[$x][$baris-1][$i]['border']='right';
																$styles[$x][$baris-1][$i]['border-style']='thin';
																$styles[$x][$baris-2][$i]['border']='right';
																$styles[$x][$baris-2][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
																$styles[$x][$baris-1][$i]['border']='right';
																$styles[$x][$baris-1][$i]['border-style']='thin';
																$styles[$x][$baris-2][$i]['border']='right';
																$styles[$x][$baris-2][$i]['border-style']='thin';
                            }
                            break;
                        case 1:
                            if ($i === 0 || $i === 12) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 9) {
                                $styles[$x][$baris][$i]['border']='left,bottom,right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 10) {
                                $styles[$x][$baris][$i]['border']='right,bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 11) {
                                $styles[$x][$baris][$i]['border']='bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 258 || $i === 377 || $i === 495) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i >= 299 && $i <= 372 || $i >= 421 && $i <= 440 || $i >= 443 && $i <= 465 || $i >= 471 && $i <= 490 || $i >= 521 && $i <= 608) {
                                $styles[$x][$baris-2][$i]['border']='bottom';
                                $styles[$x][$baris-2][$i]['border-style']='thin';
                            }
                            break;
                        case 2:
                            if ($i === 0 || $i === 12) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            }  elseif ($i >= 301 && $i <= 371) {
                                $styles[$x][$baris-2][$i]['border']='bottom';
                                $styles[$x][$baris-2][$i]['border-style']='thin';
                            } elseif ($i === 9) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 258 || $i === 377 || $i === 495) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 3:
                            if ($i < 12) {
                                $styles[$x][$baris][$i]['border']='top,bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i >= 521 && $i <= 608  ) {
                                $styles[$x][$baris-2][$i]['border']='bottom';
                                $styles[$x][$baris-2][$i]['border-style']='thin';
                            }elseif ($i >= 301 && $i <= 371) {
															$styles[$x][$baris][$i]['border']='bottom';
															$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 258 || $i === 377 || $i === 495) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            }

														if (!empty($waktu_irregular)) {
															if (sizeof($waktu_irregular) <= 4) {
																	foreach ($waktu_irregular as $key => $val) {
																		if ($key == 0) {
																			$kolom_end = 431;
																			$kolom_start = $key;
																		}else {
																		 if ($key == 2) {
																			 $plus_kolom = 5;
																		 }elseif ($key == 3) {
																			 $plus_kolom = 10;
																		 }else {
																			 $plus_kolom = 0;
																		 }
																		 $kolom_end = 436 + ((10* $key) + $plus_kolom);
																		 $kolom_start = 15 * $key;
																	 }
																		if ($i >= 421 + $kolom_start && $i <= $kolom_end ) { // thiss
																		$styles[$x][$baris-2][$i]['border']='bottom';
																		$styles[$x][$baris-2][$i]['border-style']='thin';

																	}
																}
															}
														}

                            break;
                        case 4:
                            if ($i === 0 || $i === 12) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            }  elseif ($i === 1) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 9) {
                                $styles[$x][$baris][$i]['border']='left,right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i >= 299 && $i <= 372) {
                                $styles[$x][$baris-2][$i]['border']='bottom';
                                $styles[$x][$baris-2][$i]['border-style']='thin';
                            } elseif ($i === 10 || $i === 258 || $i === 377 || $i === 495) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 5:
														if ($i === 0 || $i === 12 || $i === 14 ) {
														    $styles[$x][$baris][$i]['border']='left';
														    $styles[$x][$baris][$i]['border-style']='thin';
														} elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            }elseif ($i === 9 || $i === 10 || $i === 11) {
														    $styles[$x][$baris][$i]['border']='top';
														    $styles[$x][$baris][$i]['border-style']='thin';
														} elseif ($i === 258 || $i === 377 || $i === 495) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 6:
                            if ($i === 0 || $i === 12) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 1) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 9) {
                                $styles[$x][$baris][$i]['border']='top,left,bottom,right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 10 || $i === 11) {
                                $styles[$x][$baris][$i]['border']='top,bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 258 || $i === 377 || $i === 495) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 7:
                            if ($i === 12) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 258 || $i === 377 || $i === 495) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 8:
                            if ($i === 12) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 258 || $i === 377 || $i === 495) {
                                $styles[$x][$baris][$i]['border']='right,bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i > 13 && $i < 614) {
                                $styles[$x][$baris][$i]['border']='bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 9:
                            if ($i === 12) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 10:
                            if ($i === 12 ) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 11:
                            if ($i === 12 ) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 12:
                            if ($i === 12 ) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i > 13 && $i < 614) {
                                $styles[$x][$baris][$i]['border']='top,bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 13:
                            if ($i === 13 || $i === 89 || $i === 431) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 12 ) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 381) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 329 || $i === 492 || $i === 554 || $i === 332) {
                                $styles[$x][$baris][$i]['border']='right,bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i > 89 && $i < 330 || $i > 431 && $i < 614) {
                                $styles[$x][$baris][$i]['border']='bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 14:
                            if ($i === 13 || $i === 89 || $i === 431) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 12 ) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 492 || $i === 554 || $i === 332) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 98 || $i === 329 || $i === 381) {
                                $styles[$x][$baris][$i]['border']='right,bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i > 89 && $i < 432) {
                                $styles[$x][$baris][$i]['border']='bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 15:
                            if ($i === 13 || $i === 89 || $i === 431) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 12 ) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 492 || $i === 553 || $i === 554) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 98 || $i === 329 || $i === 381) {
                                $styles[$x][$baris][$i]['border']='right,bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i > 12 && $i < 432) {
                                $styles[$x][$baris][$i]['border']='bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 16:
                            if ($i === 13 || $i === 89 || $i === 431) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 12 ) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 492 || $i === 553 || $i === 554) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 98 || $i === 329 || $i === 381) {
                                $styles[$x][$baris][$i]['border']='right,bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i > 89 && $i < 432) {
                                $styles[$x][$baris][$i]['border']='bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 17:
                            if ($i === 13 || $i === 89 || $i === 431) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 12 ) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 492 || $i === 553 || $i === 554) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 98 || $i === 329 || $i === 381) {
                                $styles[$x][$baris][$i]['border']='right,bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i > 89 && $i < 432) {
                                $styles[$x][$baris][$i]['border']='bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 18:
                            if ($i === 13 || $i === 89 || $i === 431) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 12 ) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 492 || $i === 553 || $i === 554) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 98 || $i === 329 || $i === 381) {
                                $styles[$x][$baris][$i]['border']='right,bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i > 12 && $i < 432) {
                                $styles[$x][$baris][$i]['border']='bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 19:
                            if ($i === 13 || $i === 89 || $i === 431) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 12 ) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 492 || $i === 553 || $i === 554) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 98 || $i === 329 || $i === 381) {
                                $styles[$x][$baris][$i]['border']='right,bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i > 89 && $i < 432) {
                                $styles[$x][$baris][$i]['border']='bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 20:
                            if ($i === 13 || $i === 89 || $i === 431) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 12 ) {
                                $styles[$x][$baris][$i]['border']='left';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 613) {
																$styles[$x][$baris][$i]['border']='right';
																$styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 32 || $i === 51 || $i === 70) {
                                $styles[$x][$baris][$i]['border']='right';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i === 98 || $i === 329 || $i === 381 || $i === 492 || $i === 553 || $i === 554) {
                                $styles[$x][$baris][$i]['border']='right,bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            } elseif ($i > 80 && $i < 614) {
                                $styles[$x][$baris][$i]['border']='bottom';
                                $styles[$x][$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 21:
														if ($i === 0) {
															$styles[$x][$baris][$i]['border']='left';
															$styles[$x][$baris][$i]['border-style']='thin';
														} elseif ($i === 13 ||$i === 11 || $i === 613 || $i === 89 || $i === 431) {
															$styles[$x][$baris][$i]['border']='right';
															$styles[$x][$baris][$i]['border-style']='thin';
														}elseif ($i === 32 ||$i === 10 ||$i === 32 || $i === 51 || $i === 70 || $i === 492 || $i === 553 || $i === 554 || $i === 98 || $i === 329 || $i === 381) {
															$styles[$x][$baris][$i]['border']='right';
															$styles[$x][$baris][$i]['border-style']='thin';
														}
                            break;
                        case 22:

												if ($i >= 0 && $i < 614) {
															$styles[$x][$baris][$i]['border']='top';
															$styles[$x][$baris][$i]['border-style']='thin';
												}
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }
						// echo "<pre>";print_r($sda);die;

        // STYLING IRREGULAR JOB
            $brsIrreg = $rJum + 7;
            $penanda = 0;
            for ($j=0; $j < ($irg*2)+2; $j++) {
                $brsPake = $brsIrreg + $j;
                for ($i=0; $i < 12; $i++) {
                    switch ($i) {
                        case 0:
														$styles[$x][$brsPake][$i]['border']='left';
														$styles[$x][$brsPake][$i]['border-style']='thin';
                            if ($penanda === 1 && $j === (($irg*2)-1)) {
                                $styles[$x][$brsPake][$i]['border']='top,bottom';
                                $styles[$x][$brsPake][$i]['border-style']='thin';
                            } elseif ($penanda === 0) {
                                $styles[$x][$brsPake][$i]['border']='top,left';
                                $styles[$x][$brsPake][$i]['border-style']='thin';
                            } else {
                                $styles[$x][$brsPake][$i]['border']='left';
                                $styles[$x][$brsPake][$i]['border-style']='thin';
                            }
                            break;
                        case 1 || 9 || 10 || 11:
                            if ($penanda === 0) {
                                $styles[$x][$brsPake][$i]['border']='top,left';
                                $styles[$x][$brsPake][$i]['border-style']='thin';
                            } else {
															$styles[$x][$brsPake][$i]['border']='left';
															$styles[$x][$brsPake][$i]['border-style']='thin';
                            }
                            break;

                        default:
                            if ($penanda === 0) {
                                $styles[$x][$brsPake][$i]['border']='top';
                                $styles[$x][$brsPake][$i]['border-style']='thin';
                            }
                            break;
                    }
                }
                $penanda++;
                if ($penanda === 2) {
                    $penanda = 0;
                }
            }

        // STYLING JUMLAH IRREGULAR
            $jmlIrreg = $brsIrreg + ($irg*2);
            for ($j=0; $j < 6; $j++) {
                $barisnya = $jmlIrreg + $j;
                for ($i=0; $i < 12; $i++) {
                    switch ($j) {
                        case 0:
														$styles[$x][$barisnya+1][$i]['border']='bottom,left';
														$styles[$x][$barisnya+1][$i]['border-style']='thin';
                            if ($i === 0) {
                                // $styles[$x][$barisnya][$i]['border']='left';
                                // $styles[$x][$barisnya][$i]['border-style']='thin';
                            }elseif ($i === 1) {
															$styles[$x][$barisnya][$i]['border']='left,top';
															$styles[$x][$barisnya][$i]['border-style']='thin';
                            } elseif ($i === 11) {
                                $styles[$x][$barisnya][$i]['border']='left,top,bottom';
                                $styles[$x][$barisnya][$i]['border-style']='thin';

                            }elseif ($i == 9 || $i == 10) {
																$styles[$x][$barisnya][$i]['border']='left,top';
																$styles[$x][$barisnya][$i]['border-style']='thin';
                            } else {
                                $styles[$x][$barisnya][$i]['border']='top';
                                $styles[$x][$barisnya][$i]['border-style']='thin';
                            }
                            break;
												case 1:
												if ($i === 0) {
														$styles[$x][$barisnya][$i]['border']='bottom';
														$styles[$x][$barisnya][$i]['border-style']='thin';
												}
													break;
												// case 5:
												// 		$styles[$x][$barisnya][$i]['border']='bottom';
												// 		$styles[$x][$barisnya][$i]['border-style']='thin';
												// 		break;
                        case 6:
                            $styles[$x][$barisnya][$i]['border']='bottom';
                            $styles[$x][$barisnya][$i]['border-style']='thin';
                            break;
                        default:
                            if ($i === 0) {
                                $styles[$x][$barisnya][$i]['border']='left';
                                $styles[$x][$barisnya][$i]['border-style']='thin';
                            } elseif ($i === 11) {
                                $styles[$x][$barisnya][$i]['border']='left';
                                $styles[$x][$barisnya][$i]['border-style']='thin';
                            }
                            break;
                    }
                }
            }

    // SET DATA
        // DATA ROW 1
            $rows[$x][0][9] = $seksi_pembuat; // DATA SEKSI PEMBUAT
            $rows[$x][0][186] = 'Tipe';
            $rows[$x][0][320] = 'Seksi';
            $rows[$x][0][401] = 'Jml. Mesin';
            $rows[$x][0][450] = 'Proses ke .. dari ..';
            $rows[$x][0][491] = 'Doc. No.';
            $rows[$x][0][522] = ' : ';
            $rows[$x][0][324] = ''; //DATA DOC NO
        // DATA ROW 2
            $rows[$x][1][2] = 'CV. KARYA HIDUP SENTOSA';
            $rows[$x][1][186] = $type; //DATA TIPE
            $rows[$x][1][320] = $seksi; //DATA SEKSI
            $rows[$x][1][401] = sizeof($no_mesin); //DATA JML MESIN
            $rows[$x][1][450] = $jml_operator." dari ".$dr_operator; //DATA Proses ke .. dari ..

        // DATA ROW 3
            $rows[$x][2][2] = 'Jl. Magelang No. 144 Yogyakarta 55241';
            $rows[$x][2][491] = 'Rev. No.';
            $rows[$x][2][522] = ' : ';
            $rows[$x][2][324] = ''; //DATA Rev NO

        // DATA ROW 4
            $rows[$x][3][9] = 'TABEL STANDAR KERJA KOMBINASI';
            $rows[$x][3][186] = 'Nama Part';
            $rows[$x][3][320] = 'Line';
            $rows[$x][3][401] = 'No. Mesin';
            $rows[$x][3][450] = 'Qty/Proses';

        // DATA ROW 5
            $rows[$x][4][2] = 'Yogyakarta';
            $rows[$x][4][186] = $nama_part; //DATA Nama Part
						$styles[$x][4][186]['wrap_text']='true';
            $rows[$x][4][320] = $line; //DATA Line
            $rows[$x][4][401] = $nm; //DATA No. Mesin
            $rows[$x][4][450] = $qty; //DATA Qty/Proses
            $rows[$x][4][491] = 'Rev. Date';
            $rows[$x][4][522] = ' : ';
            $rows[$x][4][324] = ''; //DATA Rev Date

        // DATA ROW 6
        // DATA ROW 7
            $rows[$x][6][2] = 'DEPARTEMEN '.$dept_pembuat; //DATA DEPARTEMEN PEMBUAT
            $rows[$x][6][186] = 'Kode Part';
            $rows[$x][6][320] = 'Takt Time';
            $rows[$x][6][401] = 'Alat Bantu';
            $rows[$x][6][450] = 'Tgl Observasi';
            $rows[$x][6][491] = 'Page';
            $rows[$x][6][522] = ' : ';
            $rows[$x][6][324] = ''; //DATA Page
        // DATA ROW 8
            $rows[$x][7][2] = '';
            $rows[$x][7][186] = $kode_part; //DATA Kode Part
            $rows[$x][7][320] = $takt_time.' Detik'; //DATA Takt Time
            $rows[$x][7][401] = $alat_bantu; //DATA Alat Bantu
            $rows[$x][7][450] = $tanggal; //DATA Tgl Observasi

        // DATA ROW 9
        // DATA ROW 10
        // DATA ROW 11
            $rows[$x][10][0] = 'NO';
            $rows[$x][10][1] = 'ELEMEN KERJA';
            $rows[$x][10][9] = 'MANUAL';
            $rows[$x][10][10] = 'AUTO';
            $rows[$x][10][11] = 'WALK';
            $rows[$x][10][14] = 'Detik';

        // DATA & STYLE ROW 12 & 13
            if ($x > 1) {
              $xy = $x-1;
              $headtime = 10 + (600 * $xy);
            }else {
              $headtime = 10;
            }

            $indexheadtime = $indexAngka;
            $time = 1;
            for ($i= $indexAngka; $i < ($indexAngka + $end); $i++) {
                if ($i == $indexheadtime) {
                    $rows[$x][11][$indexheadtime] = $headtime;
                    $headtime += 10;
                    $indexheadtime += 10;
                    $styles[$x][11][$i]['font-size'] = 8;
                    $styles[$x][11][$i]['valign'] = 'center';
                    $styles[$x][11][$i]['halign'] = 'right';
                }
                $rows[$x][12][$i] = $time;
                $styles[$x][12][$i]['font-size'] = 8;
                $styles[$x][12][$i]['valign'] = 'center';
                $styles[$x][12][$i]['halign'] = 'center';
                $time++;
            }

        // DATA & STYLE ELEMEN KERJA
            $rownya = 14;
            for ($j=0; $j < sizeof($elemen_kerja); $j++) {
                $rowkerja = $rownya + ($j *3);
                $rows[$x][$rowkerja][0] = $j+1;
                $rows[$x][$rowkerja][1] = $elemen_kerja[$j];

                switch ($jenis_proses[$j]) {
                    case 'MANUAL':
                        $rows[$x][$rowkerja][9] = $waktu[$j];
												$styles[$x][$rowkerja][9]['font-size'] = 10;
                        $styles[$x][$rowkerja][9]['valign'] = 'center';
                        $styles[$x][$rowkerja][9]['halign'] = 'center';
                        break;
                    case 'AUTO':
                        $rows[$x][$rowkerja][10] = $waktu[$j];
                        $styles[$x][$rowkerja][10]['font-size'] = 10;
                        $styles[$x][$rowkerja][10]['valign'] = 'center';
                        $styles[$x][$rowkerja][10]['halign'] = 'center';
                        break;
                    case 'WALK':
                        $rows[$x][$rowkerja][11] = $waktu[$j];
                        $styles[$x][$rowkerja][11]['font-size'] = 10;
                        $styles[$x][$rowkerja][11]['valign'] = 'center';
                        $styles[$x][$rowkerja][11]['halign'] = 'center';
                        break;
                    default:
                        # code...
                        break;
                }

                $styles[$x][$rowkerja][0]['font-size'] = 10;
                $styles[$x][$rowkerja][0]['valign'] = 'center';
                $styles[$x][$rowkerja][0]['halign'] = 'center';
                $styles[$x][$rowkerja][1]['font-size'] = 10;
                $styles[$x][$rowkerja][1]['valign'] = 'center';
								$styles[$x][$rowkerja][1]['halign'] = 'left';

            }

						for ($jj=0; $jj < sizeof($elemen_kerja) * 3; $jj++) {
							$styles[$x][$jj+14]['height'] = 9;
						}

        // DATA & STYLE JUMLAH
            $rowJumlahElemen = $rownya + (sizeof($elemen_kerja)*3 +1);
            $rows[$x][$rowJumlahElemen][0] = 'JUMLAH';
            $rows[$x][$rowJumlahElemen][9] = $jumlah_manual;
            $rows[$x][$rowJumlahElemen][10] = $jumlah_auto;
            $rows[$x][$rowJumlahElemen][11] = $jumlah_walk;
            $rows[$x][$rowJumlahElemen][18] = '1. Keterangan';
            $rows[$x][$rowJumlahElemen+1][20] = '- Waktu 1 Shift';
            $rows[$x][$rowJumlahElemen+1][93] = ' = ';
            $rows[$x][$rowJumlahElemen+1][98] = $waktu_satu_shift; //DATA Waktu 1 Shift
            $rows[$x][$rowJumlahElemen+1][124] = 'Detik';
            $rows[$x][$rowJumlahElemen+1][263] = 'Takt Time';

            $rows[$x][$rowJumlahElemen+1][294] = ' = ';
            $rows[$x][$rowJumlahElemen+1][299] = 'Waktu 1 Shift';
            $rows[$x][$rowJumlahElemen+1][382] = 'Waktu / Shift'; // rev 2 okto

            $rows[$x][$rowJumlahElemen+1][416] = ' = ';
						$rows[$x][$rowJumlahElemen+1][421] = 'W1';
						$rows[$x][$rowJumlahElemen+1][438] = '+';
						$rows[$x][$rowJumlahElemen+1][443] = 'W2';
						$rows[$x][$rowJumlahElemen+1][460] = '+...+';
						$rows[$x][$rowJumlahElemen+1][471] = 'Wn';
            $rows[$x][$rowJumlahElemen+1][500] = 'Pcs / Shift';

            $rows[$x][$rowJumlahElemen+1][516] = ' = ';
            $rows[$x][$rowJumlahElemen+1][521] = 'Waktu 1 Shift x Qty dlm 1 cycle';

            $rows[$x][$rowJumlahElemen+2][20] = '- Cycletime (Tanpa Irregular Job)';
            $rows[$x][$rowJumlahElemen+2][93] = ' = ';
            $rows[$x][$rowJumlahElemen+2][98] = $cycle_time_tanpa_irregular; //DATA Cycletime (Tanpa Irregular Job)
            $rows[$x][$rowJumlahElemen+2][124] = 'Detik';
            $rows[$x][$rowJumlahElemen+2][299] = '(';
            $rows[$x][$rowJumlahElemen+2][301] = 'Rencana Produksi / Bulan';
            $rows[$x][$rowJumlahElemen+2][371] = ')';
            $rows[$x][$rowJumlahElemen+2][421] = 'R1';
						$rows[$x][$rowJumlahElemen+2][443] = 'R2';
						$rows[$x][$rowJumlahElemen+2][471] = 'Rn';
            $rows[$x][$rowJumlahElemen+2][521] = 'Cycle Time (Dengan Irregular Job)';


            $rows[$x][$rowJumlahElemen+3][20] = '- Cycletime (Dengan Irregular Job)';
            $rows[$x][$rowJumlahElemen+3][93] = ' = ';
            $rows[$x][$rowJumlahElemen+3][98] = $cycle_time; //DATA Cycletime (Dengan Irregular Job)
            $rows[$x][$rowJumlahElemen+3][124] = 'Detik';
            $rows[$x][$rowJumlahElemen+3][301] = 'Jumlah Hari Kerja / Bulan';
            $rows[$x][$rowJumlahElemen+3][416] = ' = ';
						// foreach ($waktu_irregular as $key => $val) {
						//   $tampung_hasil_irregular[] = $val.'/'.$ratio_irregular[$key];
						// }
						// $rows[$x][$rowJumlahElemen+3][211] = $waktu_irregular[0].'/'.$ratio_irregular[0]; //DATA Cycle Time tanpa Irregular
						//AREA WAKTU IRREGULAR
						if (!empty($waktu_irregular)) {
							if (sizeof($waktu_irregular) <= 4) {
									foreach ($waktu_irregular as $key => $val) {
										if ($key == 0) {
											$kolom_end = 431;
											$kolom_start = $key;
										}else {
											if ($key == 2) {
												$plus_kolom = 5;
											}elseif ($key == 3) {
												$plus_kolom = 10;
											}else {
												$plus_kolom = 0;
											}
											$kolom_end = 436 + ((10* $key) + $plus_kolom);
											$kolom_start = 15 * $key;
										}

										$rows[$x][$rowJumlahElemen+3][421 + $kolom_start] = $val; //DATA Waktu Irregular Job
										$rows[$x][$rowJumlahElemen+4][421 + $kolom_start] = $ratio_irregular[$key]; //DATA Ratio Irregular Job
										$styles[$x][$rowJumlahElemen+3][421 + $kolom_start]['valign']='center';
										$styles[$x][$rowJumlahElemen+4][421 + $kolom_start]['valign'] = 'center';

										if ($key != (sizeof($waktu_irregular)-1)) {
											$rows[$x][$rowJumlahElemen+3][$kolom_end+1] = '+'; //DATA Waktu Irregular Job
										}
								}
							}else {
								foreach ($waktu_irregular as $key => $val) {
								  $tampung_hasil_irregular[] = $val/$ratio_irregular[$key];
								}
								$rows[$x][$rowJumlahElemen+3][421] = implode(' + ', $tampung_hasil_irregular); //DATA Cycle Time tanpa Irregular
							}
						}

						//END
						// $rows[$x][$rowJumlahElemen+3][211] = $waktu_irregular[0]; //DATA Cycle Time tanpa Irregular
            $rows[$x][$rowJumlahElemen+3][516] = ' = ';
            $rows[$x][$rowJumlahElemen+3][521] = $waktu_satu_shift.' x '.$qty; //DATA Waktu 1 Shift x Qty dlm 1 cycle


            $rows[$x][$rowJumlahElemen+4][20] = '- Jumlah Hari Kerja / Bulan';
            $rows[$x][$rowJumlahElemen+4][93] = ' = ';
            $rows[$x][$rowJumlahElemen+4][98] = $jumlah_hari_kerja; //DATA Jumlah Hari Kerja / Bulan
            $rows[$x][$rowJumlahElemen+4][124] = 'Hari';
            $rows[$x][$rowJumlahElemen+4][294] = ' = ';
            $rows[$x][$rowJumlahElemen+4][299] = $waktu_satu_shift; //Data Waktu 1 Shift
            // $rows[$x][$rowJumlahElemen+4][211] = $ratio_irregular[0]; //DATA Ratio Irregular Job
            $rows[$x][$rowJumlahElemen+4][521] = $cycle_time; //DATA Cycle Time (Dengan Irregular Job)


            $rows[$x][$rowJumlahElemen+5][20] = '- Rencana Produksi / Bulan';
            $rows[$x][$rowJumlahElemen+5][93] = ' = ';
            $rows[$x][$rowJumlahElemen+5][98] = $rencana_produksi; //Data Rencana Produksi / Bulan
            $rows[$x][$rowJumlahElemen+5][124] = 'Pcs';
            $rows[$x][$rowJumlahElemen+5][299] = '(';
            $rows[$x][$rowJumlahElemen+5][301] = $rencana_produksi; //Data Rencana Produksi / Bulan
            $rows[$x][$rowJumlahElemen+5][371] = ')';
            $rows[$x][$rowJumlahElemen+5][416] = ' = ';
            $rows[$x][$rowJumlahElemen+5][421] = $jumlah_hasil_irregular; //DATA HASIL 3
            $rows[$x][$rowJumlahElemen+5][440] = 'Detik'; //rev3
            $rows[$x][$rowJumlahElemen+5][516] = ' = ';
            $rows[$x][$rowJumlahElemen+5][521] = ($waktu_satu_shift*$qty)/$cycle_time; //DATA HASIL 4
            $rows[$x][$rowJumlahElemen+5][542] = 'Pcs';


            $rows[$x][$rowJumlahElemen+6][20] = '- Takt Time';
            $rows[$x][$rowJumlahElemen+6][93] = ' = ';
            $rows[$x][$rowJumlahElemen+6][98] = $takt_time; //DATA Takt Time
            $rows[$x][$rowJumlahElemen+6][124] = 'Detik';
            $rows[$x][$rowJumlahElemen + 6][301] = $jumlah_hari_kerja;


            $rows[$x][$rowJumlahElemen+7][20] = '- Qty dalam 1 cycle';
            $rows[$x][$rowJumlahElemen+7][93] = ' = ';
            $rows[$x][$rowJumlahElemen+7][98] = $qty; //DATA Qty dalam 1 Cycle
						$rows[$x][$rowJumlahElemen+7][124] = 'Pcs';
            $rows[$x][$rowJumlahElemen+7][294] = ' = ';
            $rows[$x][$rowJumlahElemen+7][299] = $takt_time; //Data HASIL 1
            $rows[$x][$rowJumlahElemen+7][320] = 'Detik';

						$rows[$x][$rowJumlahElemen+8][20] = '- Forecast ';
						$rows[$x][$rowJumlahElemen+8][93] = ' = ';
						$rows[$x][$rowJumlahElemen+8][98] = $forecast; //DATA forecast
						$rows[$x][$rowJumlahElemen+8][124] = 'Unit';

						$rows[$x][$rowJumlahElemen+9][20] = '- Qty / Unit ';
						$rows[$x][$rowJumlahElemen+9][93] = ' = ';
						$rows[$x][$rowJumlahElemen+9][98] = $qty_unit; //DATA qty_unit
						$rows[$x][$rowJumlahElemen+9][124] = 'Unit';

            $rows[$x][$rowJumlahElemen+11][18] = '5. Usulan Perbaikan';

            $rows[$x][$rowJumlahElemen][263] = '2. Perhitungan Taktime';
            $rows[$x][$rowJumlahElemen][382] = '3. Waktu Irregular Job';
            $rows[$x][$rowJumlahElemen][500] = '4. Jumlah Pcs yang dihasilkan dalam 1 shift';
            $rows[$x][$rowJumlahElemen+4][9] = $jumlah; //rev4


            for ($j=0; $j < 12; $j++) {
                $barisnya = $rowJumlahElemen + $j;
                for ($i=0; $i < 614; $i++) {
                    switch ($j) {
                        case 0:
                            if ($i === 0 || $i === 9 || $i === 10 || $i === 11) {
                                $styles[$x][$barisnya][$i]['font-size'] = 10;
                                $styles[$x][$barisnya][$i]['valign'] = 'center';
                                $styles[$x][$barisnya][$i]['halign'] = 'center';
                            } elseif ($i === 18 || $i === 263 || $i === 382 || $i === 500) {
                                $styles[$x][$barisnya][$i]['font-size'] =10;
                                $styles[$x][$barisnya][$i]['font-style'] = 'bold';
                                $styles[$x][$barisnya][$i]['valign'] = 'center';
                                $styles[$x][$barisnya][$i]['halign'] = 'left';
                            } else {
                                $styles[$x][$barisnya][$i]['font-size'] = 10;
                                $styles[$x][$barisnya][$i]['valign'] = 'center';
                                $styles[$x][$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        case 1:
                            $styles[$x][$barisnya][$i]['font-size'] = 10;
                            $styles[$x][$barisnya][$i]['valign'] = 'center';
                            if ($i === 263 || $i === 382 || $i === 500) {
                                $styles[$x][$barisnya][$i]['wrap_text'] = true;
                                $styles[$x][$barisnya][$i]['halign'] = 'center'; //hiahia
                            } elseif ($i === 93 || $i === 294 || $i === 299 || $i === 416 || $i === 421 || $i === 460 || $i === 443 || $i === 471 || $i === 516 || $i === 521) {
                                $styles[$x][$barisnya][$i]['halign'] = 'center';
                            } else {
                                $styles[$x][$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        case 2:
                            if ($i === 9) {
                                $styles[$x][$barisnya][$i]['font-size'] = 10;
                            } else {
                                $styles[$x][$barisnya][$i]['font-size'] = 10;
                            }
                            $styles[$x][$barisnya][$i]['valign'] = 'center';
                            if ($i === 9 || $i === 93 || $i === 299 || $i === 301 || $i === 371 || $i === 421 || $i === 443 || $i === 471 || $i === 521) {
                                $styles[$x][$barisnya][$i]['halign'] = 'center';
                            } else {
                                $styles[$x][$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        case 3:
                            $styles[$x][$barisnya][$i]['font-size'] = 10;
                            $styles[$x][$barisnya][$i]['valign'] = 'center';
                            if ( $i === 93 || $i === 301 || $i === 421 || $i === 416 || $i === 226 || $i === 241 || $i === 256 || $i ===516 || $i === 521) {
                                $styles[$x][$barisnya][$i]['halign'] = 'center';
                            } else {
                                $styles[$x][$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        case 4:
														$styles[$x][$barisnya][$i]['valign'] = 'center';
                            if ( $i === 93 || $i === 294 || $i === 299 || $i === 421 || $i === 226 || $i === 241 || $i === 256 || $i === 521) {
                              $styles[$x][$barisnya][$i]['halign'] = 'center';
															$styles[$x][$barisnya][$i]['font-size'] = 10;

                            }elseif ($i === 9) {
															$styles[$x][$barisnya][$i]['font-size'] = 10;
                            	$styles[$x][$barisnya][$i]['valign'] = 'center';
															$styles[$x][$barisnya][$i]['halign'] = 'center';
                            } else {
															$styles[$x][$barisnya][$i]['halign'] = 'left';
															$styles[$x][$barisnya][$i]['font-size'] = 10;
                            }
                            break;
                        case 5:
                            $styles[$x][$barisnya][$i]['font-size'] = 10;
                            $styles[$x][$barisnya][$i]['valign'] = 'center';
                            if ($i === 93 || $i === 299 || $i === 416 || $i === 421 || $i === 516 || $i === 521 || $i === 301 || $i === 371) {
                                $styles[$x][$barisnya][$i]['halign'] = 'center';
                            } else {
                                $styles[$x][$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        case 6:
                            $styles[$x][$barisnya][$i]['font-size'] = 10;
                            $styles[$x][$barisnya][$i]['valign'] = 'center';
                            if ($i === 93 || $i === 301) {
                                $styles[$x][$barisnya][$i]['halign'] = 'center';
                            } else {
                                $styles[$x][$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        case 7:
                            $styles[$x][$barisnya][$i]['font-size'] = 10;
                            $styles[$x][$barisnya][$i]['valign'] = 'center';
                            if ($i === 93 || $i === 299) {
                                $styles[$x][$barisnya][$i]['halign'] = 'center';
                            } else {
                                $styles[$x][$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        case 8:
														$styles[$x][$barisnya][$i]['font-size'] = 10;
														$styles[$x][$barisnya][$i]['valign'] = 'center';
														$styles[$x][$barisnya][$i]['halign'] = 'left';
                            break;
                        case 9:
														$styles[$x][$barisnya][$i]['font-size'] = 10;
														$styles[$x][$barisnya][$i]['valign'] = 'center';
														$styles[$x][$barisnya][$i]['halign'] = 'left';
                            break;
												case 11:
                            if ($i === 18) {
                                $styles[$x][$barisnya][$i]['font-size'] = 10;
                                $styles[$x][$barisnya][$i]['font-style'] = 'bold';
                                $styles[$x][$barisnya][$i]['valign'] = 'center';
                                $styles[$x][$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }

        // DATA & STYLE HEADER IRREGULAR JOB
            $rows[$x][$rowJumlahElemen+6][0] = 'No';
            $rows[$x][$rowJumlahElemen+6][1] = 'Irregular Job';
            $rows[$x][$rowJumlahElemen+6][9] = 'Ratio';
            $rows[$x][$rowJumlahElemen+6][10] = 'Waktu';
            $rows[$x][$rowJumlahElemen+6][11] = 'Ratio / Waktu';
            $rows[$x][$rowJumlahElemen+8][9] = 'Kali';
            $rows[$x][$rowJumlahElemen+8][10] = 'Detik';

            $styles[$x][$rowJumlahElemen+6][0]['font-size'] = 10;
            $styles[$x][$rowJumlahElemen+6][0]['valign'] = 'center';
            $styles[$x][$rowJumlahElemen+6][0]['halign'] = 'center';
            $styles[$x][$rowJumlahElemen+6][1]['font-size'] = 10;
            $styles[$x][$rowJumlahElemen+6][1]['valign'] = 'center';
            $styles[$x][$rowJumlahElemen+6][1]['halign'] = 'left';
            $styles[$x][$rowJumlahElemen+6][9]['font-size'] = 10;
            $styles[$x][$rowJumlahElemen+6][9]['valign'] = 'center';
            $styles[$x][$rowJumlahElemen+6][9]['halign'] = 'center';
            $styles[$x][$rowJumlahElemen+6][10]['font-size'] = 10;
            $styles[$x][$rowJumlahElemen+6][10]['valign'] = 'center';
            $styles[$x][$rowJumlahElemen+6][10]['halign'] = 'center';
            $styles[$x][$rowJumlahElemen+6][11]['font-size'] = 10;
            $styles[$x][$rowJumlahElemen+6][11]['valign'] = 'center';
            $styles[$x][$rowJumlahElemen+6][11]['halign'] = 'center';
            $styles[$x][$rowJumlahElemen+6][11]['wrap_text'] = true;

            $styles[$x][$rowJumlahElemen+8][9]['font-size'] = 10;
            $styles[$x][$rowJumlahElemen+8][9]['valign'] = 'center';
            $styles[$x][$rowJumlahElemen+8][9]['halign'] = 'center';
            $styles[$x][$rowJumlahElemen+8][10]['font-size'] = 10;
            $styles[$x][$rowJumlahElemen+8][10]['valign'] = 'center';
            $styles[$x][$rowJumlahElemen+8][10]['halign'] = 'center';

        // DATA FOOTER KANAN
            $rowFootKanan = $rowJumlahElemen+15;
            $styles[$x][$rowFootKanan+1][19]['fill'] = '#000000'; //manual
            $styles[$x][$rowFootKanan+1][57]['fill'] = '#fcf403'; //cycletime
            $styles[$x][$rowFootKanan+3][59]['fill'] = '#fc0422'; //taktime
            $styles[$x][$rowFootKanan+4][59]['fill'] = '#fc0422';
            $styles[$x][$rowFootKanan+5][59]['fill'] = '#fc0422';
            $styles[$x][$rowFootKanan+4][19]['fill'] = '#65eb00'; //auto
            $styles[$x][$rowFootKanan+7][19]['fill'] = '#00dbc5'; //walk
            $styles[$x][$rowFootKanan+7][57]['fill'] = '#fa3eed'; //muda
            // $styles[$x][$rowFootKanan][0]['valign'] = 'center';
            // $styles[$x][$rowFootKanan][0]['halign'] = 'center';
            $rows[$x][$rowFootKanan][33] = 'Manual';
            $rows[$x][$rowFootKanan][71] = 'Cycle Time';
            $rows[$x][$rowFootKanan][90] = 'Revisi';
            $rows[$x][$rowFootKanan][330] = 'Tanggal';
            $rows[$x][$rowFootKanan][382] = 'Oleh';
            $rows[$x][$rowFootKanan][432] = 'Menyetujui';
            $rows[$x][$rowFootKanan][493] = 'Diperiksa 2';
            $rows[$x][$rowFootKanan][494] = 'Diperiksa 1';
            $rows[$x][$rowFootKanan][555] = 'Dibuat';

            $rows[$x][$rowFootKanan+1][90] = 'No.';
            $rows[$x][$rowFootKanan+1][99] = 'Detail';

            $rows[$x][$rowFootKanan+3][33] = 'Auto (Mesin)';
            $rows[$x][$rowFootKanan+3][71] = 'Takt Time';

            $rows[$x][$rowFootKanan+6][33] = 'Jalan';
            $rows[$x][$rowFootKanan+6][71] = 'Muda';

            $rows[$x][$rowFootKanan+8][432] = 'Tgl :';
            $rows[$x][$rowFootKanan+8][493] = 'Tgl :';
            $rows[$x][$rowFootKanan+8][494] = 'Tgl :';
            $rows[$x][$rowFootKanan+8][555] = 'Tgl :';

						$rows[$x][$rowFootKanan+9][500] = 'Form No. : FRM-PDE-03-21 (Rev. 00-26/03/2020)';
						// echo "<pre>";
						// print_r($rows[$x][$rowFootKanan]);
						// die;
            for ($j=0; $j < 10; $j++) {
                $rowpakefoot = $rowFootKanan + $j;
                for ($i=0; $i < 614; $i++) {
                    switch ($j) {
                        case 0:
                            if ($i === 33 || $i === 71 || $i === 90 || $i === 330 || $i === 382 || $i === 432 || $i === 493 || $i === 494 || $i === 555) {
                                if ($i != 33) {
                                    $styles[$x][$rowpakefoot][$i]['wrap_text'] = true;
                                }
                                $styles[$x][$rowpakefoot][$i]['halign'] = 'center';
                                $styles[$x][$rowpakefoot][$i]['font-size'] = 10;
                                $styles[$x][$rowpakefoot][$i]['valign'] = 'center';
                                if ($i === 90 || $i === 330 || $i === 382) {
                                    $styles[$x][$rowpakefoot][$i]['font-style'] = 'bold';
                                }

                            }
                            break;
                        case 1:
                            if ($i === 90 || $i === 99) {
                                $styles[$x][$rowpakefoot][$i]['halign'] = 'center';
                                $styles[$x][$rowpakefoot][$i]['font-size'] = 10;
                                $styles[$x][$rowpakefoot][$i]['valign'] = 'center';
                                $styles[$x][$rowpakefoot][$i]['font-style'] = 'bold';
                            }
                            break;
                        case 3:
                            if ($i === 33 || $i === 71) {
                                $styles[$x][$rowpakefoot][$i]['wrap_text'] = true;
                                $styles[$x][$rowpakefoot][$i]['halign'] = 'center';
                                if ($i === 33) {
                                    $styles[$x][$rowpakefoot][$i]['font-size'] = 10;
                                } else {
                                    $styles[$x][$rowpakefoot][$i]['font-size'] = 10;
                                }
                                $styles[$x][$rowpakefoot][$i]['valign'] = 'center';
                            }
                            break;
                        case 6:
                            if ($i === 33 || $i === 71) {
                                $styles[$x][$rowpakefoot][$i]['wrap_text'] = true;
                                $styles[$x][$rowpakefoot][$i]['halign'] = 'center';
                                $styles[$x][$rowpakefoot][$i]['font-size'] = 10;
                                $styles[$x][$rowpakefoot][$i]['valign'] = 'center';
                            }
                            break;
                        case 8:
                            if ($i === 432 || $i === 493 || $i === 494 || $i === 555) {
                                $styles[$x][$rowpakefoot][$i]['wrap_text'] = true;
                                $styles[$x][$rowpakefoot][$i]['halign'] = 'left';
                                $styles[$x][$rowpakefoot][$i]['font-size'] = 10;
                                $styles[$x][$rowpakefoot][$i]['valign'] = 'center';
                            }
                            break;
                        case 9:
                        if ($i === 432) {
                            // $styles[$x][$rowpakefoot][$i]['wrap_text'] = true;
                            // $styles[$x][$rowpakefoot][$i]['halign'] = 'left';
                            $styles[$x][$rowpakefoot][$i]['font-size'] = 10;
                            // $styles[$x][$rowpakefoot][$i]['valign'] = 'center';
                        }
                        break;
                        default:
                            # code...
                            break;
                    }
                }
            }

					// DATA IRREGULAR JOB
					if (!empty($irregular_jobs)) {
						$rowDataIrregular = $rowJumlahElemen+7;
            for ($i=1; $i <= sizeof($irregular_jobs); $i++) {
                $pakeRowIrregular = $rowDataIrregular + ($i * 2);
                $rows[$x][$pakeRowIrregular][0] = $i;
                $styles[$x][$pakeRowIrregular][0]['font-size'] = 10;
                $styles[$x][$pakeRowIrregular][0]['valign'] = 'center';
                $rows[$x][$pakeRowIrregular][1] = $irregular_jobs[$i-1];
                $styles[$x][$pakeRowIrregular][1]['font-size'] = 10;
                $styles[$x][$pakeRowIrregular][1]['valign'] = 'center';
                $rows[$x][$pakeRowIrregular][9] = $ratio_irregular[$i-1];
                $styles[$x][$pakeRowIrregular][9]['font-size'] = 10;
                $styles[$x][$pakeRowIrregular][9]['valign'] = 'center';
                $styles[$x][$pakeRowIrregular][9]['halign'] = 'center';
                $rows[$x][$pakeRowIrregular][10] = $waktu_irregular[$i-1];
                $styles[$x][$pakeRowIrregular][10]['font-size'] = 10;
                $styles[$x][$pakeRowIrregular][10]['valign'] = 'center';
                $styles[$x][$pakeRowIrregular][10]['halign'] = 'center';
                $rows[$x][$pakeRowIrregular][11] = $hasil_irregular [$i-1];
                $styles[$x][$pakeRowIrregular][11]['font-size'] = 10;
                $styles[$x][$pakeRowIrregular][11]['valign'] = 'center';
                $styles[$x][$pakeRowIrregular][11]['halign'] = 'center';
            }
            if (sizeof($irregular_jobs) <= 5) {
                $rowIrregular = 5;
            } else {
                $rowIrregular = sizeof($irregular_jobs);
            }

						if (sizeof($irregular_jobs) > 1) {
								$min001 = count($irregular_jobs) + (count($irregular_jobs) - 2);
						}else {
							$min001 = 0;
						}
            $rows[$x][$pakeRowIrregular + (($rowIrregular*2) - $min001)][0] = 'JUMLAH';
            $styles[$x][$pakeRowIrregular + (($rowIrregular*2) - $min001)][0]['font-size'] = 10;
            $styles[$x][$pakeRowIrregular + (($rowIrregular*2) - $min001)][0]['valign'] = 'center';
            $styles[$x][$pakeRowIrregular + (($rowIrregular*2) - $min001)][0]['halign'] = 'center';
            $rows[$x][$pakeRowIrregular + (($rowIrregular*2) - $min001)][11] = $jumlah_hasil_irregular;
            $styles[$x][$pakeRowIrregular + (($rowIrregular*2) - $min001)][11]['font-size'] = 10;
            $styles[$x][$pakeRowIrregular + (($rowIrregular*2) - $min001)][11]['valign'] = 'center';
            $styles[$x][$pakeRowIrregular + (($rowIrregular*2) - $min001)][11]['halign'] = 'center';
					}


    // TIME FLOW (MASTER)
				$n_ = $x - 1;
				$nn = $n_ * 600;

        for ($j=0; $j < sizeof($elemen_kerja); $j++) {
            $rowflow = $rownya + ($j * 3);
            if ($muda[$j] > 1) {
                $startmuda[$j] = $start[$j]-$muda[$j];
                $finishmuda[$j] = $start[$j]-1;
            } else {
                $startmuda[$j]= -2;
                $finishmuda[$j] = -1;
            }

						if ($nn < $cycle_time) {
							for ($i=$nn; $i < $cycle_time; $i++) {
								// ng kene ! bagian row detik
									if (($i >= $start[$j] && $i <= $finish[$j])) {
											if ($jenis_proses[$j] === 'MANUAL') {
													$warna = '#000000';
											} elseif ($jenis_proses[$j] === 'AUTO') {
													$warna = '#65eb00';
											} elseif ($jenis_proses[$j] === 'WALK') {
													$warna = '#00dbc5';
											}

											if ($i > 1*$nn && $i < 600*$x) {
												$styles[$x][$rowflow + 1][($i+13) - $nn]['fill'] = $warna;
												$rows[$x][$rowflow + 1][($i+13) - $nn] = $i-$start[$j]+1;
											}

									}
									if ($jenis_proses[$j] != 'AUTO') {
										if (($i >= $startmuda[$j] && $i <= $finishmuda[$j]) && ($startmuda[$j] <= 600*$x && $finishmuda[$j] <= 600*$x)) {
												$styles[$x][$rowflow][$i+13]['fill'] = '#fa3eef';
												$styles[$x][$rowflow-1][$i+13]['fill'] = '#fa3eef';
												if ($i === $finishmuda[$j]) {
													if ($i > 1*$nn && $i < 600*$x) {
														$rows[$x][$rowflow-1][$i+13] = 'Muda: '.$muda[$j].' Detik ';
													}
												}
										}
									}
							}
						}

						// //Garis Takttime
						if ($takt_time == '-') {
							$styles[$x][$rowflow][($takt_time + 13) - $nn]['fill'] = '#ffffff';
							$styles[$x][$rowflow+1][($takt_time + 13) - $nn]['fill'] = '#ffffff';
							$styles[$x][$rowflow+2][($takt_time + 13) - $nn]['fill'] = '#ffffff';
						}else {
							if ($takt_time > 1*$nn && $takt_time < 600*$x) {
								$styles[$x][$rowflow][($takt_time + 13) - $nn]['fill'] = '#fc0494';
								$styles[$x][$rowflow+1][($takt_time + 13) - $nn]['fill'] = '#fc0494';
								$styles[$x][$rowflow+2][($takt_time + 13) - $nn]['fill'] = '#fc0494';
							}
						}
						// //Garis Cycletime
						if ($cycle_time > 1*$nn && $cycle_time < 600*$x) {
							$styles[$x][$rowflow][($cycle_time + 13) - $nn]['fill'] = '#fcf403';
							$styles[$x][$rowflow+1][($cycle_time + 13) - $nn]['fill'] = '#fcf403';
							$styles[$x][$rowflow+2][($cycle_time + 13) - $nn]['fill'] = '#fcf403';
						}
        }

        //Irregular Job
				if ($last_finish > 1*$nn && $last_finish < 600*$x) {
					for ($i=0; $i < $jumlah_hasil_irregular; $i++) {
							$styles[$x][$rownya][(($last_finish + 14) - $nn) + $i]['fill'] = '#2a61ad';
							$rows[$x][$rownya][(($last_finish + 14) - $nn) + $i] = $i +1;
					}
				}

				if ($takt_time == '-') {
					$rows[$x][$rownya + 13][$takt_time + 14] = '';
				}else {
					if ($takt_time > 1*$nn && $takt_time < 600*$x) {
						$styles[$x][$rownya + 13][($takt_time + 14) - $nn]['font-size'] = 10;
						$rows[$x][$rownya + 13][($takt_time + 14) - $nn] = 'Takt Time = '.$takt_time.' Detik';
					}
				}

        //CycleTime
				if ($cycle_time > 1*$nn && $cycle_time < 600*$x ) {
					$rows[$x][$rownya][($cycle_time + 14) - $nn] = 'Cycle Time = '.$cycle_time.' Detik';
				}
        // $rows[$x][$rownya + 13][$cycle_time + 14] = 'Cycle Time = '.$cycle_time.' Detik';
			// echo sizeof($rows[$x]);

			$writer->writeSheetHeader($sheet1.'_'.$x, $header, $col_options);      //WRITE HEADER
			for ($i=0; $i < sizeof($rows[$x]); $i++) {
			    $writer->writeSheetRow($sheet1.'_'.$x, $rows[$x][$i], $styles[$x][$i]);    //WRITE ROWS
			}

			//LAYOUT HEADER, FORMATTING MERGE CELL
			    $writer->markMergedCell($sheet1.'_'.$x, $start_row=0, $start_col=0, $end_row=0, $end_col=($indexAngka + $end)-1); // TEXT IDENTITAS TSKK
			    //ROW 1
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=1, $start_col=0, $end_row=9, $end_col=1); //LOGO QUICK
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=1, $start_col=2, $end_row=1, $end_col=8); //BLANK
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=1, $start_col=9, $end_row=3, $end_col=185); //SEKSI GEDE
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=1, $start_col=186, $end_row=1, $end_col=319); //TIPE
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=1, $start_col=320, $end_row=1, $end_col=400); //SEKSI
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=1, $start_col=401, $end_row=1, $end_col=449); //JML MESIN
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=1, $start_col=450, $end_row=1, $end_col=490); //PROSES KE
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=1, $start_col=491, $end_row=2, $end_col=521); //DOC NO
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=1, $start_col=522, $end_row=2, $end_col=523); //TITIK 2
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=1, $start_col=524, $end_row=2, $end_col=613); //BLANK

			    //ROW 2
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=2, $start_col=2, $end_row=2, $end_col=8); //CV KHS
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=2, $start_col=186, $end_row=3, $end_col=319); //DATA TIPE
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=2, $start_col=320, $end_row=3, $end_col=400); //DATA SEKSI
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=2, $start_col=401, $end_row=3, $end_col=449); //DATA JML MESIN
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=2, $start_col=450, $end_row=3, $end_col=490); //DATA PROSES KE

			    //ROW 3
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=3, $start_col=2, $end_row=4, $end_col=8); //ALAMAT
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=3, $start_col=491, $end_row=4, $end_col=521); //REV NO
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=3, $start_col=522, $end_row=4, $end_col=523); //TITIK 2
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=3, $start_col=524, $end_row=4, $end_col=613); //BLANK

			    //ROW 4
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=4, $start_col=9, $end_row=9, $end_col=185); //TABEL STANDAR KERJA KOMBINASI
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=4, $start_col=186, $end_row=4, $end_col=319); //NAMA PART
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=4, $start_col=320, $end_row=4, $end_col=400); //LINE
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=4, $start_col=401, $end_row=4, $end_col=449); //NO MESIN
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=4, $start_col=450, $end_row=4, $end_col=490); //QTY/PROSES

			    //ROW 5
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=5, $start_col=2, $end_row=5, $end_col=8); //YOGYAKARTA
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=5, $start_col=186, $end_row=6, $end_col=319); //DATA NAMA PART
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=5, $start_col=320, $end_row=6, $end_col=400); //DATA LINE
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=5, $start_col=401, $end_row=6, $end_col=449); //DATA NO MESIN
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=5, $start_col=450, $end_row=6, $end_col=490); //DATA QTY/PROSES
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=5, $start_col=491, $end_row=6, $end_col=521); //REV DATE
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=5, $start_col=522, $end_row=6, $end_col=523); //TITIK 2
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=5, $start_col=524, $end_row=6, $end_col=613); //BLANK

			    //ROW 6
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=6, $start_col=2, $end_row=6, $end_col=8); //BLANK

			    //ROW 7
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=7, $start_col=2, $end_row=7, $end_col=8); //DEPARTEMEN
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=7, $start_col=186, $end_row=7, $end_col=319); //KODE PART
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=7, $start_col=320, $end_row=7, $end_col=400); //TAKT TIME
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=7, $start_col=401, $end_row=7, $end_col=449); //ALAT BANTU
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=7, $start_col=450, $end_row=7, $end_col=490); //TGL OBSERVASI
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=7, $start_col=491, $end_row=9, $end_col=521); //PAGE
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=7, $start_col=522, $end_row=9, $end_col=523); //TITIK 2
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=7, $start_col=524, $end_row=9, $end_col=613); //BLANK

			    //ROW 8
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=8, $start_col=2, $end_row=9, $end_col=8); //BLANK
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=8, $start_col=186, $end_row=9, $end_col=319); //DATA KODE PART
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=8, $start_col=320, $end_row=9, $end_col=400); //DATA TAKT TIME
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=8, $start_col=401, $end_row=9, $end_col=449); //DATA ALAT BANTU
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=8, $start_col=450, $end_row=9, $end_col=490); //DATA TGL OBSERVASI

			    //ROW 9
			    //ROW 10
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=11, $start_col=0, $end_row=13, $end_col=0); //HEAD NO
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=11, $start_col=1, $end_row=13, $end_col=8); //HEAD ELEMEN KERJA
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=11, $start_col=9, $end_row=13, $end_col=9); //HEAD MANUAL
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=11, $start_col=10, $end_row=13, $end_col=10); //HEAD AUTO
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=11, $start_col=11, $end_row=13, $end_col=11); //HEAD WALK
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row=11, $start_col=14, $end_row=11, $end_col=($indexAngka + $end)-1); //HEAD DETIK

			    //ROW 11
			        for ($i= $indexAngka; $i < ($indexAngka + $end); $i+=10) {
			            $fin = $i + 9;
			            $writer->markMergedCell($sheet1.'_'.$x, $start_row=12, $start_col= $i, $end_row=12, $end_col= $fin);
			        }

			    //ROW ELEMEN KERJA
			        for ($i=0; $i < sizeof($elemen_kerja); $i++) {
			            $rowstart = 15 + ($i * 3);
			            $rowend = $rowstart + 2;
			            $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowstart, $start_col= 0, $end_row=$rowend, $end_col= 0);
			            $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowstart, $start_col= 1, $end_row=$rowend, $end_col= 8);
			            $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowstart, $start_col= 9, $end_row=$rowend, $end_col= 9);
			            $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowstart, $start_col= 10, $end_row=$rowend, $end_col= 10);
			            $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowstart, $start_col= 11, $end_row=$rowend, $end_col= 11);
			        }

			    //ROW JUMLAH & KETERANGAN
			        $rowjum = 15 + (sizeof($elemen_kerja) * 3) + 1;
			        //JUMLAH
			            $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum, $start_col= 0, $end_row=$rowjum+4, $end_col= 8);
			            $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum, $start_col= 9, $end_row=$rowjum+3, $end_col= 9);
			            $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum, $start_col= 10, $end_row=$rowjum+3, $end_col= 10);
			            $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum, $start_col= 11, $end_row=$rowjum+3, $end_col= 11);
			            $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+4, $start_col= 9, $end_row=$rowjum+4, $end_col= 11);
			        //KETERANGAN
			            // 1
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum, $start_col= 18, $end_row=$rowjum, $end_col= 137);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 20, $end_row=$rowjum+1, $end_col= 92);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 93, $end_row=$rowjum+1, $end_col= 97);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 98, $end_row=$rowjum+1, $end_col= 123);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 124, $end_row=$rowjum+1, $end_col= 137);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+2, $start_col= 20, $end_row=$rowjum+2, $end_col= 92);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+2, $start_col= 93, $end_row=$rowjum+2, $end_col= 97);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+2, $start_col= 98, $end_row=$rowjum+2, $end_col= 123);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+2, $start_col= 124, $end_row=$rowjum+2, $end_col= 137);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+3, $start_col= 20, $end_row=$rowjum+3, $end_col= 92);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+3, $start_col= 93, $end_row=$rowjum+3, $end_col= 97);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+3, $start_col= 98, $end_row=$rowjum+3, $end_col= 123);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+3, $start_col= 124, $end_row=$rowjum+3, $end_col= 137);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+4, $start_col= 20, $end_row=$rowjum+4, $end_col= 92);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+4, $start_col= 93, $end_row=$rowjum+4, $end_col= 97);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+4, $start_col= 98, $end_row=$rowjum+4, $end_col= 123);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+4, $start_col= 124, $end_row=$rowjum+4, $end_col= 137);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+5, $start_col= 20, $end_row=$rowjum+5, $end_col= 92);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+5, $start_col= 93, $end_row=$rowjum+5, $end_col= 97);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+5, $start_col= 98, $end_row=$rowjum+5, $end_col= 123);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+5, $start_col= 124, $end_row=$rowjum+5, $end_col= 137);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+6, $start_col= 20, $end_row=$rowjum+6, $end_col= 92);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+6, $start_col= 93, $end_row=$rowjum+6, $end_col= 97);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+6, $start_col= 98, $end_row=$rowjum+6, $end_col= 123);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+6, $start_col= 124, $end_row=$rowjum+6, $end_col= 137);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+7, $start_col= 20, $end_row=$rowjum+7, $end_col= 92);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+7, $start_col= 93, $end_row=$rowjum+7, $end_col= 97);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+7, $start_col= 98, $end_row=$rowjum+7, $end_col= 123);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+7, $start_col= 124, $end_row=$rowjum+7, $end_col= 137);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+8, $start_col= 20, $end_row=$rowjum+8, $end_col= 92);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+8, $start_col= 93, $end_row=$rowjum+8, $end_col= 97);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+8, $start_col= 98, $end_row=$rowjum+8, $end_col= 123);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+8, $start_col= 124, $end_row=$rowjum+8, $end_col= 137);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+9, $start_col= 20, $end_row=$rowjum+9, $end_col= 92);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+9, $start_col= 93, $end_row=$rowjum+9, $end_col= 97);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+9, $start_col= 98, $end_row=$rowjum+9, $end_col= 123);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+9, $start_col= 124, $end_row=$rowjum+9, $end_col= 137);
			                 //al e01821

			            // 2
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum, $start_col= 263, $end_row=$rowjum, $end_col= 372);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 263, $end_row=$rowjum+3, $end_col= 293);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 294, $end_row=$rowjum+3, $end_col= 298);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 299, $end_row=$rowjum+1, $end_col= 372);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+2, $start_col= 299, $end_row=$rowjum+3, $end_col= 300);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+2, $start_col= 301, $end_row=$rowjum+2, $end_col= 370);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+2, $start_col= 371, $end_row=$rowjum+3, $end_col= 372);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+3, $start_col= 301, $end_row=$rowjum+3, $end_col= 370);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+4, $start_col= 294, $end_row=$rowjum+6, $end_col= 298);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+4, $start_col= 299, $end_row=$rowjum+4, $end_col= 372);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+5, $start_col= 299, $end_row=$rowjum+6, $end_col= 300);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+5, $start_col= 301, $end_row=$rowjum+5, $end_col= 370);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+5, $start_col= 371, $end_row=$rowjum+6, $end_col= 372);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+6, $start_col= 301, $end_row=$rowjum+6, $end_col= 370);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+7, $start_col= 294, $end_row=$rowjum+8, $end_col= 298);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+7, $start_col= 299, $end_row=$rowjum+8, $end_col= 319);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+7, $start_col= 320, $end_row=$rowjum+8, $end_col= 334);

			            // REV 20-10-2020
			            // 3
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum, $start_col= 382, $end_row=$rowjum, $end_col= 490);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 382, $end_row=$rowjum+2, $end_col= 415);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 416, $end_row=$rowjum+2, $end_col= 420);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 421, $end_row=$rowjum+1, $end_col= 437);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 443, $end_row=$rowjum+1, $end_col= 459);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 471, $end_row=$rowjum+1, $end_col= 490);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 438, $end_row=$rowjum+2, $end_col= 442);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 460, $end_row=$rowjum+2, $end_col= 470);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+2, $start_col= 421, $end_row=$rowjum+2, $end_col= 437);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+2, $start_col= 443, $end_row=$rowjum+2, $end_col= 459);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+2, $start_col= 471, $end_row=$rowjum+2, $end_col= 490);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+3, $start_col= 416, $end_row=$rowjum+4, $end_col= 420);

			                // $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+3, $start_col= 211, $end_row=$rowjum+3, $end_col= 221);
			                // $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+4, $start_col= 211, $end_row=$rowjum+4, $end_col= 221);

											if (!empty($waktu_irregular)) {
												if (sizeof($waktu_irregular) <= 4) {
				                  foreach ($waktu_irregular as $key => $val) {
				                    if ($key == 0) {
				                      $kolom_end = 431;
				                      $kolom_start = $key;
				                    }else {
				                      if ($key == 2) {
				                        $plus_kolom = 5;
				                      }elseif ($key == 3) {
				                        $plus_kolom = 10;
				                      }else {
				                        $plus_kolom = 0;
				                      }
				                      $kolom_end = 436 + ((10* $key) + $plus_kolom);
				                      $kolom_start = 15 * $key;
				                    }
				                    $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+3, $start_col= 421 + $kolom_start, $end_row=$rowjum+3, $end_col=$kolom_end);
				                    $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+4, $start_col= 421 + $kolom_start, $end_row=$rowjum+4, $end_col=$kolom_end);

				                    $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+3, $start_col= $kolom_end+1, $end_row=$rowjum+4, $end_col=$kolom_end+4);
				                  }
				                }else {
				                  $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+3, $start_col= 421, $end_row=$rowjum+4, $end_col= 482);
				                }
											}

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+5, $start_col= 416, $end_row=$rowjum+5, $end_col= 420);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+5, $start_col= 421, $end_row=$rowjum+5, $end_col= 439);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+5, $start_col= 440, $end_row=$rowjum+5, $end_col= 460);


			            // 4
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum, $start_col= 500, $end_row=$rowjum, $end_col= 608);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 500, $end_row=$rowjum+2, $end_col= 515);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 516, $end_row=$rowjum+2, $end_col= 520);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+1, $start_col= 521, $end_row=$rowjum+1, $end_col= 608);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+2, $start_col= 521, $end_row=$rowjum+2, $end_col= 608);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+3, $start_col= 516, $end_row=$rowjum+4, $end_col= 520);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+3, $start_col= 521, $end_row=$rowjum+3, $end_col= 608);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+4, $start_col= 521, $end_row=$rowjum+4, $end_col= 608);

			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+5, $start_col= 516, $end_row=$rowjum+5, $end_col= 520);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+5, $start_col= 521, $end_row=$rowjum+5, $end_col= 541);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+5, $start_col= 542, $end_row=$rowjum+5, $end_col= 556);

			            // USULAN
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+11, $start_col= 18, $end_row=$rowjum+11, $end_col= 137);
			                $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowjum+12, $start_col= 20, $end_row=$rowjum+13, $end_col= 360);


			    //ROW HEADER IRREGULAR JOB & Footer kanan
			        $rowheadirreg = $rowjum+6;
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg, $start_col= 0, $end_row=$rowheadirreg+2, $end_col= 0);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg, $start_col= 1, $end_row=$rowheadirreg+2, $end_col= 8);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg, $start_col= 9, $end_row=$rowheadirreg+1, $end_col= 9);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg, $start_col= 10, $end_row=$rowheadirreg+1, $end_col= 10);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg, $start_col= 11, $end_row=$rowheadirreg+1, $end_col= 11);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+2, $start_col= 10, $end_row=$rowheadirreg+2, $end_col= 11);

			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+9, $start_col= 14, $end_row=$rowheadirreg+9, $end_col= 32);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+9, $start_col= 33, $end_row=$rowheadirreg+11, $end_col= 51);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+9, $start_col= 52, $end_row=$rowheadirreg+9, $end_col= 70);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+9, $start_col= 71, $end_row=$rowheadirreg+11, $end_col= 89);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+9, $start_col= 90, $end_row=$rowheadirreg+9, $end_col= 329);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+9, $start_col= 330, $end_row=$rowheadirreg+10, $end_col= 381);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+9, $start_col= 382, $end_row=$rowheadirreg+10, $end_col= 431);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+9, $start_col= 432, $end_row=$rowheadirreg+9, $end_col= 492);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+9, $start_col= 493, $end_row=$rowheadirreg+9, $end_col= 553);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+9, $start_col= 494, $end_row=$rowheadirreg+9, $end_col= 554);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+9, $start_col= 555, $end_row=$rowheadirreg+9, $end_col= 613);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+10, $start_col= 14, $end_row=$rowheadirreg+10, $end_col= 18);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+10, $start_col= 19, $end_row=$rowheadirreg+10, $end_col= 27);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+10, $start_col= 28, $end_row=$rowheadirreg+10, $end_col= 32);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+10, $start_col= 52, $end_row=$rowheadirreg+10, $end_col= 56);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+10, $start_col= 57, $end_row=$rowheadirreg+10, $end_col= 65);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+10, $start_col= 66, $end_row=$rowheadirreg+10, $end_col= 70);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+10, $start_col= 90, $end_row=$rowheadirreg+10, $end_col= 98);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+10, $start_col= 99, $end_row=$rowheadirreg+10, $end_col= 329);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+10, $start_col= 432, $end_row=$rowheadirreg+10, $end_col= 492);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+10, $start_col= 493, $end_row=$rowheadirreg+10, $end_col= 553);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+10, $start_col= 494, $end_row=$rowheadirreg+10, $end_col= 554);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+10, $start_col= 555, $end_row=$rowheadirreg+10, $end_col= 613);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+11, $start_col= 14, $end_row=$rowheadirreg+11, $end_col= 32);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+11, $start_col= 52, $end_row=$rowheadirreg+11, $end_col= 70);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+11, $start_col= 90, $end_row=$rowheadirreg+11, $end_col= 98);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+11, $start_col= 99, $end_row=$rowheadirreg+11, $end_col= 329);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+11, $start_col= 330, $end_row=$rowheadirreg+11, $end_col= 381);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+11, $start_col= 382, $end_row=$rowheadirreg+11, $end_col= 431);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+11, $start_col= 432, $end_row=$rowheadirreg+14, $end_col= 492);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+11, $start_col= 493, $end_row=$rowheadirreg+14, $end_col= 553);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+11, $start_col= 494, $end_row=$rowheadirreg+14, $end_col= 554);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+11, $start_col= 555, $end_row=$rowheadirreg+14, $end_col= 613);

			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+12, $start_col= 14, $end_row=$rowheadirreg+12, $end_col= 32);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+12, $start_col= 33, $end_row=$rowheadirreg+14, $end_col= 51);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+12, $start_col= 52, $end_row=$rowheadirreg+12, $end_col= 58);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+12, $start_col= 59, $end_row=$rowheadirreg+12, $end_col= 63);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+12, $start_col= 64, $end_row=$rowheadirreg+12, $end_col= 70);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+12, $start_col= 71, $end_row=$rowheadirreg+14, $end_col= 89);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+12, $start_col= 90, $end_row=$rowheadirreg+12, $end_col= 98);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+12, $start_col= 99, $end_row=$rowheadirreg+12, $end_col= 329);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+12, $start_col= 330, $end_row=$rowheadirreg+12, $end_col= 381);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+12, $start_col= 382, $end_row=$rowheadirreg+12, $end_col= 431);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+13, $start_col= 14, $end_row=$rowheadirreg+13, $end_col= 18);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+13, $start_col= 19, $end_row=$rowheadirreg+13, $end_col= 27);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+13, $start_col= 28, $end_row=$rowheadirreg+13, $end_col= 32);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+13, $start_col= 52, $end_row=$rowheadirreg+13, $end_col= 58);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+13, $start_col= 59, $end_row=$rowheadirreg+13, $end_col= 63);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+13, $start_col= 64, $end_row=$rowheadirreg+13, $end_col= 70);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+13, $start_col= 90, $end_row=$rowheadirreg+13, $end_col= 98);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+13, $start_col= 99, $end_row=$rowheadirreg+13, $end_col= 329);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+13, $start_col= 330, $end_row=$rowheadirreg+13, $end_col= 381);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+13, $start_col= 382, $end_row=$rowheadirreg+13, $end_col= 431);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+14, $start_col= 14, $end_row=$rowheadirreg+14, $end_col= 32);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+14, $start_col= 52, $end_row=$rowheadirreg+14, $end_col= 58);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+14, $start_col= 59, $end_row=$rowheadirreg+14, $end_col= 63);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+14, $start_col= 64, $end_row=$rowheadirreg+14, $end_col= 70);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+14, $start_col= 90, $end_row=$rowheadirreg+14, $end_col= 98);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+14, $start_col= 99, $end_row=$rowheadirreg+14, $end_col= 329);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+14, $start_col= 330, $end_row=$rowheadirreg+14, $end_col= 381);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+14, $start_col= 382, $end_row=$rowheadirreg+14, $end_col= 431);

			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+15, $start_col= 14, $end_row=$rowheadirreg+15, $end_col= 32);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+15, $start_col= 33, $end_row=$rowheadirreg+17, $end_col= 51);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+15, $start_col= 52, $end_row=$rowheadirreg+15, $end_col= 70);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+15, $start_col= 71, $end_row=$rowheadirreg+17, $end_col= 89);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+15, $start_col= 90, $end_row=$rowheadirreg+15, $end_col= 98);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+15, $start_col= 99, $end_row=$rowheadirreg+15, $end_col= 329);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+15, $start_col= 330, $end_row=$rowheadirreg+15, $end_col= 381);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+15, $start_col= 382, $end_row=$rowheadirreg+15, $end_col= 431);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+15, $start_col= 432, $end_row=$rowheadirreg+16, $end_col= 492);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+15, $start_col= 493, $end_row=$rowheadirreg+16, $end_col= 553);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+15, $start_col= 494, $end_row=$rowheadirreg+16, $end_col= 554);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+15, $start_col= 555, $end_row=$rowheadirreg+16, $end_col= 613);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+16, $start_col= 14, $end_row=$rowheadirreg+16, $end_col= 18);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+16, $start_col= 19, $end_row=$rowheadirreg+16, $end_col= 27);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+16, $start_col= 28, $end_row=$rowheadirreg+16, $end_col= 32);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+16, $start_col= 52, $end_row=$rowheadirreg+16, $end_col= 56);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+16, $start_col= 57, $end_row=$rowheadirreg+16, $end_col= 65);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+16, $start_col= 66, $end_row=$rowheadirreg+16, $end_col= 70);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+16, $start_col= 90, $end_row=$rowheadirreg+16, $end_col= 98);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+16, $start_col= 99, $end_row=$rowheadirreg+16, $end_col= 329);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+16, $start_col= 330, $end_row=$rowheadirreg+16, $end_col= 381);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+16, $start_col= 382, $end_row=$rowheadirreg+16, $end_col= 431);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+17, $start_col= 14, $end_row=$rowheadirreg+17, $end_col= 32);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+17, $start_col= 52, $end_row=$rowheadirreg+17, $end_col= 70);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+17, $start_col= 90, $end_row=$rowheadirreg+17, $end_col= 98);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+17, $start_colForm= 99, $end_row=$rowheadirreg+17, $end_col= 329);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+17, $start_col= 330, $end_row=$rowheadirreg+17, $end_col= 381);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+17, $start_col= 382, $end_row=$rowheadirreg+17, $end_col= 431);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+17, $start_col= 432, $end_row=$rowheadirreg+17, $end_col= 492);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+17, $start_col= 493, $end_row=$rowheadirreg+17, $end_col= 553);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+17, $start_col= 494, $end_row=$rowheadirreg+17, $end_col= 554);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $rowheadirreg+17, $start_col= 555, $end_row=$rowheadirreg+17, $end_col= 613);

			    //ROW LIST IRREGULAR JOB
			        $irreg = $rowheadirreg+3;
			        for ($j=0; $j < $irg; $j++) {
			            $brs = $irreg + ($j*2);
			            $writer->markMergedCell($sheet1.'_'.$x, $start_row= $brs, $start_col= 0, $end_row=$brs+1, $end_col= 0);
			            $writer->markMergedCell($sheet1.'_'.$x, $start_row= $brs, $start_col= 1, $end_row=$brs+1, $end_col= 8);
			            $writer->markMergedCell($sheet1.'_'.$x, $start_row= $brs, $start_col= 9, $end_row=$brs+1, $end_col= 9);
			            $writer->markMergedCell($sheet1.'_'.$x, $start_row= $brs, $start_col= 10, $end_row=$brs+1, $end_col= 10);
			            $writer->markMergedCell($sheet1.'_'.$x, $start_row= $brs, $start_col= 11, $end_row=$brs+1, $end_col= 11);
			        }
			    //ROW JUMLAH IRREGULAR
			        $jmlRowIrreg = $irreg + ($irg * 2);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $jmlRowIrreg, $start_col= 0, $end_row=$jmlRowIrreg+4, $end_col= 10);
			        $writer->markMergedCell($sheet1.'_'.$x, $start_row= $jmlRowIrreg, $start_col= 11, $end_row=$jmlRowIrreg+4, $end_col= 11);

		}
    $filename = 'New_TSKK_'.$judul.'_'.$tanggal.'.xlsx';
    $writer->writeToFile('./assets/upload/GeneratorTSKK/'.$filename);

		if ($idnya == 'paklut') {
			$arr = array(
					'url' => $filename
			);
			echo json_encode($arr);
		}else {
			header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
			$writer->writeToStdOut();
		}


//LUTFI END
}


}

?>
