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
		// echo $jenis_inputEquipment; die;
    $no_mesin	      = $this->input->post('txtNoMesin[]');
    $no_mesin         = implode("; ", $no_mesin);
    // echo "<pre>";echo $no_mesin;
    $jenis_mesin      = $this->input->post('txtJenisMesin[]');
    $jm = implode("; ", $jenis_mesin);
    $jenis_mesin = trim(preg_replace('/\s\s+/', ' ', $jm));
    $resource         = $this->input->post('txtResource[]');
    $rsc = implode("; ", $resource);
    $resource = trim(preg_replace('/\s\s+/', ' ', $rsc));
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
                  $sang_pembuat,$creationDate);

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
						'start_together'		=> $startTimeTogether[$i]
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
            'irregular_job' 	    => $irregular_jobs[$i],
            'ratio'                 => $ratio_irregular[$i],
            'waktu'   	            => $waktu_irregular[$i],
            'hasil_irregular_job'   => $hasil_irregular[$i],
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

      //set pembulatan dengan mengisi angka
    if ($jumlah < 450) {
        $end = 450;
    } else {
        // echo $jumlah; exit();
        $g = (int)($jumlah / 10);
        $g += 1;
        $end = $g * 10;
        // echo "g = $g <br>jml = $jumlah <br>".$end;
    }

    //IRREGULAR JOBS

		if ($idnya == 'paklut') {
			$irregular_jobs         = $this->input->post('irregular_job');
			$ratio_irregular        = $this->input->post('ratio_ij');
			$waktu_irregular        = $this->input->post('waktu_ij');
			$hasil_irregular        = $this->input->post('hasil_ij');
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
    if ($akhir < 450) {
        $end = 450;
    } else {
        // echo $jumlah; exit();
        // $g = (int)($cycle_time / 10);
        $g = (int)($akhir / 10);
        $g += 1;
        $end = $g * 10;
        // echo "g = $g <br>jml = $jumlah <br>".$end;
    }

    //MERGING DETIK//
    // $indexAngka = 18; // LAMA
    $indexAngka = 14;
    $indexStart = 1;
    $kolomA   = $this->Kolom($indexAngka);
    $kolomB   = $this->Kolom($indexAngka + $end);
    $kolomJDL = $this->Kolom($indexStart);
/////LUTFI IN DE HAUS
    //MULAI PAKE XLSXWriternya
    $writer = new XLSXWriter();
    // $writer->setTitle('TSKK');
    // $writer->setSubject('Tabel Standar Kerja Kombinasi');
    // $writer->setAuthor('#L');
    // $writer->setCompany('ICT - Produksi');
    // // $writer->setKeywords($keywords);
    // $writer->setDescription('Tabel Standar Kerja Kombinasi');
    // $writer->setTempDir(sys_get_temp_dir());

    $sheet1 = 'TSKK';
    $width = array();
    for ($i=0; $i < ($indexAngka + $end); $i++) {
        if($i == 0) {
            $width[$i] = 4.5;
        } elseif ($i >= 1 && $i <=11) {
            $width[$i] = 8.30;
        } else {
            $width[$i] = 0.34;
        }
    }
    // STYLING HEADER
        $col_options['widths'] = $width;
        $col_options['halign'] = 'center';
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
                $rows[$j][$i] = '';
                $styles[$j][$i] = '';
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
                    $borderstyle = null; //thin, medium, thick, dashDot, dashDotDot, dashed, dotted, double, hair, mediumDashDot, mediumDashDotDot, mediumDashed, slantDashDot
                    $bordercolor = null;
                    $color = null;
                    $fill = null;
                    $valign = null; //bottom, center, distributed
                    $halign = null; //general, left, right, justify, center

            //BORDER, BORDER-STYLE, BORDER COLOR
                    if ($j == 0) {
                        if ($i == 0) {
                            $border = 'left,top';
                            $borderstyle = 'thick';
                        }elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
                            $border = 'right,top';
                            $borderstyle = 'thick';
                        } elseif ($i < 363) {
                            $border = 'top';
                            $borderstyle = 'thick';
                        } else {

                        }
                    } elseif ($j == 1) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thick';
                        } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
                            $border='right';
                            $borderstyle='thick';
                        } elseif ($i >= 186 && $i < 306) {
                            $border='top';
                            $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 2) {
                        if ($i == 0) {
                            $border = 'left';
                            $borderstyle = 'thick';
                        } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
                            $border='right';
                            $borderstyle='thick';
                        } elseif ($i >= 307 && $i < 363) {
                                $border='top';
                                $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 3) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thick';
                        } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
                            $border='right';
                            $borderstyle='thick';
                        } elseif ($i >= 9 && $i < 185) {
                            $border='top';
                            $borderstyle='thin';
                        } elseif ($i >= 186 && $i < 306) {
                            $border='top,bottom';
                            $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 4) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thick';
                        } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
                            $border='right';
                            $borderstyle='thick';
                        } elseif ($i >= 307 && $i < 363) {
                            $border='top';
                            $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 5) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thick';
                        } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
                            $border='right';
                            $borderstyle='thick';
                        } else {

                        }
                    } elseif ($j == 6) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thick';
                        } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
                            $border='right';
                            $borderstyle='thick';
                        } elseif ($i >= 186 && $i < 306) {
                            $border='top,bottom';
                            $borderstyle='thin';
                        } elseif ($i >= 307 && $i < 363) {
                            $border='top';
                            $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 7) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thick';
                        } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
                            $border='right';
                            $borderstyle='thick';
                        } else {

                        }
                    } elseif ($j == 8) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thick';
                        } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
                            $border='right';
                            $borderstyle='thick';
                        } else {

                        }
                    } elseif ($j == 9) {
                        if ($i > 363) {
                            $border='bottom';
                            $borderstyle='thick';
                        } elseif ($i == 12 || $i == 13) {
                            $border='top';
                            $borderstyle='thick';
                        } else {
                            $border='top,bottom';
                            $borderstyle='thick';
                        }
                    } elseif ($j == 10) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thick';
                        } elseif ($i == 1 || $i == 9 || $i == 10 || $i == 11) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 12) {
                            $border='left';
                            $borderstyle='thick';
                        } elseif ($i == 13 || $i == ($indexAngka + $end - 1)) {
                            $border='right';
                            $borderstyle='thick';
                        } elseif ($i < ($indexAngka + $end)) {
                            $border='bottom';
                            $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 11) {
                        if ($i == 0) {
                            $border='left';
                            $borderstyle='thick';
                        } elseif ($i == 1 || $i == 9 || $i == 10 || $i == 11) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 12) {
                            $border='left';
                            $borderstyle='thick';
                        } elseif ($i == 13 || $i == ($indexAngka + $end - 1)) {
                            $border='right';
                            $borderstyle='thick';
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
                            $borderstyle='thick';
                        } elseif ($i == 1 || $i == 9 || $i == 10 || $i == 11) {
                            $border='left';
                            $borderstyle='thin';
                        } elseif ($i == 12) {
                            $border='left';
                            $borderstyle='thick';
                        } elseif ($i == 13 || $i == ($indexAngka + $end - 1)) {
                            $border='right';
                            $borderstyle='thick';
                        } elseif ($i < ($indexAngka + $end) && $i >= 14) {
                                $border='right';
                                $borderstyle='thin';
                        } else {

                        }
                    } elseif ($j == 13) {
                        if ($i == 12 || $i == 13) {

                        } else {
                            $border='top,bottom';
                            $borderstyle='thick';
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
                        }elseif ($i == 186 || $i == 230 || $i == 255 || $i == 280 || $i == 307) {
                            $fontsize = 7;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'left';
                        } elseif ($i == 322) {
                            $fontsize = 7;
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
                            $halign = 'left';
                        }elseif ($i == 186 || $i == 230 || $i == 255 || $i == 280) {
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
                            $halign = 'left';
                        } elseif ($i == 307) {
                            $fontsize = 7;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'left';
                        } elseif ($i == 322) {
                            $fontsize = 7;
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
                        } elseif ($i == 186 || $i == 230 || $i == 255 || $i == 280) {
                            $fontsize = 7;
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
                            $halign = 'left';
                        }elseif ($i == 186 || $i == 230 || $i == 255 || $i == 280) {
                            $fontsize = 8;
                            $fontstyle = 'bold';
                            $valign = 'center';
                            $halign = 'center';
                        } elseif ($i == 307) {
                            $fontsize = 7;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'left';
                        } elseif ($i == 322) {
                            $fontsize = 7;
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
                            $halign = 'left';
                        } elseif ($i == 186 || $i == 230 || $i == 255 || $i == 280) {
                            $fontsize = 7;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'left';
                        } elseif ($i == 307) {
                            $fontsize = 7;
                            // $fontstyle = '';
                            $valign = 'center';
                            $halign = 'left';
                        } elseif ($i == 322) {
                            $fontsize = 7;
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
                        if ($i == 186 || $i == 230 || $i == 255 || $i == 280) {
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
                        $styles[$j][$i]['font'] = $font;
                    }
                    if (isset($fontsize)) {
                        $styles[$j][$i]['font-size'] = $fontsize;
                    }
                    if (isset($fontstyle)) {
                        $styles[$j][$i]['font-style'] = $fontstyle;
                    }
                    if (isset($border)) {
                        $styles[$j][$i]['border'] = $border;
                    }
                    if (isset($borderstyle)) {
                        $styles[$j][$i]['border-style'] = $borderstyle;
                    }
                    if (isset($bordercolor)) {
                        $styles[$j][$i]['border-color'] = $bordercolor;
                    }
                    if (isset($color)) {
                        $styles[$j][$i]['color'] = $color;
                    }
                    if (isset($fill)) {
                        $styles[$j][$i]['fill'] = $fill;
                    }
                    if (isset($valign)) {
                        $styles[$j][$i]['valign'] = $valign;
                    }
                    if (isset($halign)) {
                        $styles[$j][$i]['halign'] = $halign;
                    }
                    if(!isset($font) && !isset($fontsize) && !isset($fontstyle) && !isset($border) && !isset($borderstyle) && !isset($bordercolor) && !isset($color) && !isset($fill) && !isset($valign) && !isset($halign)) {
                        $styles[$j][$i] = array();
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
                            $styles[$rowelemen][$i]['border']='left';
                            $styles[$rowelemen][$i]['border-style']='thin';
                        } elseif ($i === 12) {
                            $styles[$rowelemen][$i]['border']='left';
                            $styles[$rowelemen][$i]['border-style']='thick';
                        } elseif ($i === 13 || $i == ($indexAngka + $end - 1)) {
                            $styles[$rowelemen][$i]['border']='right';
                            $styles[$rowelemen][$i]['border-style']='thick';
                        } elseif ($i > 13) {
                            if (($i-14)%10 == 0) {
                                $styles[$rowelemen][$i]['border']='left';
                                $styles[$rowelemen][$i]['border-style']='thin';
                            }
                        }
                        break;
                    case 1:
                        if ($i === 0 || $i === 1 || $i === 9 || $i === 10 || $i === 11) {
                            $styles[$rowelemen][$i]['border']='left';
                            $styles[$rowelemen][$i]['border-style']='thin';
                        } elseif ($i === 12) {
                            $styles[$rowelemen][$i]['border']='left';
                            $styles[$rowelemen][$i]['border-style']='thick';
                        } elseif ($i === 13 || $i == ($indexAngka + $end - 1)) {
                            $styles[$rowelemen][$i]['border']='right';
                            $styles[$rowelemen][$i]['border-style']='thick';
                        } elseif ($i > 13) {
                            if (($i-14)%10 == 0) {
                                $styles[$rowelemen][$i]['border']='left';
                                $styles[$rowelemen][$i]['border-style']='thin';
                            }
                        }
                        break;
                    case 2:
                        if ($i === 0 || $i === 1 || $i === 9 || $i === 10 || $i === 11) {
                            $styles[$rowelemen][$i]['border']='left,bottom';
                            $styles[$rowelemen][$i]['border-style']='thin';
                        } elseif ($i === 12) {
                            $styles[$rowelemen][$i]['border']='left';
                            $styles[$rowelemen][$i]['border-style']='thick';
                        } elseif ($i < 13) {
                            $styles[$rowelemen][$i]['border']='bottom';
                            $styles[$rowelemen][$i]['border-style']='thin';
                        } elseif ($i === 13 || $i == ($indexAngka + $end - 1)) {
                            $styles[$rowelemen][$i]['border']='right';
                            $styles[$rowelemen][$i]['border-style']='thick';
                        } elseif ($i > 13) {
                            if (($i-14)%10 == 0) {
                                $styles[$rowelemen][$i]['border']='left,bottom';
                                $styles[$rowelemen][$i]['border-style']='thin';
                            } else {
                                $styles[$rowelemen][$i]['border']='bottom';
                                $styles[$rowelemen][$i]['border-style']='thin';
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
                } elseif ($i <= 363) {
                    $styles[$jumlahrow + $rowmulai][$i]['border']='top,bottom';
                    $styles[$jumlahrow + $rowmulai][$i]['border-style']='thick';
                } else {
                    $styles[$jumlahrow + $rowmulai][$i]['border']='top';
                    $styles[$jumlahrow + $rowmulai][$i]['border-style']='thick';
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
                for ($i=0; $i <= 364; $i++) {
                    switch ($j) {
                        case 0:
                            if ($i === 0 || $i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
																$styles[$baris-1][$i]['border']='left';
																$styles[$baris-1][$i]['border-style']='thick';
																$styles[$baris-2][$i]['border']='left';
																$styles[$baris-2][$i]['border-style']='thick';
                            } elseif ($i === 10 ||$i === 9) {
															$styles[$baris][$i]['border']='left,right';
															$styles[$baris][$i]['border-style']='thin';
															$styles[$baris-1][$i]['border']='left,right';
															$styles[$baris-1][$i]['border-style']='thin';
															$styles[$baris-2][$i]['border']='left,right';
															$styles[$baris-2][$i]['border-style']='thin';
                            } elseif ($i === 109 || $i === 186 || $i === 274) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
																$styles[$baris-1][$i]['border']='right';
																$styles[$baris-1][$i]['border-style']='thin';
																$styles[$baris-2][$i]['border']='right';
																$styles[$baris-2][$i]['border-style']='thin';
                            }elseif ($i === 11) {
																$styles[$baris-1][$i]['border']='right';
																$styles[$baris-1][$i]['border-style']='thick';
																$styles[$baris-2][$i]['border']='right';
																$styles[$baris-2][$i]['border-style']='thick';
                            } elseif ($i === 13) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
																$styles[$baris-1][$i]['border']='right';
																$styles[$baris-1][$i]['border-style']='thick';
																$styles[$baris-2][$i]['border']='right';
																$styles[$baris-2][$i]['border-style']='thick';
                            }
                            break;
                        case 1:
                            if ($i === 0 || $i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 9) {
                                $styles[$baris][$i]['border']='left,bottom,right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 10) {
                                $styles[$baris][$i]['border']='right,bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 11) {
                                $styles[$baris][$i]['border']='bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 109 || $i === 186 || $i === 274) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i >= 132 && $i <= 184 || $i >= 211 && $i <= 230 || $i >= 232 && $i <= 254 || $i >= 260 && $i <= 272 || $i >= 299 && $i <= 361) {
                                $styles[$baris-2][$i]['border']='bottom';
                                $styles[$baris-2][$i]['border-style']='thin';
                            }
                            break;
                        case 2:
                            if ($i === 0 || $i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i >= 134 && $i <= 182) {
                                $styles[$baris-2][$i]['border']='bottom';
                                $styles[$baris-2][$i]['border-style']='thin';
                            } elseif ($i === 9) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 109 || $i === 186 || $i === 274) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 3:
                            if ($i < 12) {
                                $styles[$baris][$i]['border']='top,bottom';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 13) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i >= 299 && $i <= 361  ) {
                                $styles[$baris-2][$i]['border']='bottom';
                                $styles[$baris-2][$i]['border-style']='thin';
                            }elseif ($i >= 134 && $i <= 183) {
															$styles[$baris][$i]['border']='bottom';
															$styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 109 || $i === 186 || $i === 274) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            }

														 if (sizeof($waktu_irregular) <= 4) {
																 foreach ($waktu_irregular as $key => $val) {
																	 if ($key == 0) {
																		 $kolom_end = 221;
																		 $kolom_start = $key;
																	 }else {
								 										if ($key == 2) {
								 											$plus_kolom = 5;
								 										}elseif ($key == 3) {
								 											$plus_kolom = 10;
								 										}else {
								 											$plus_kolom = 0;
								 										}
								 										$kolom_end = 226 + ((10* $key) + $plus_kolom);
								 										$kolom_start = 15 * $key;
								 									}
																	 if ($i >= 211 + $kolom_start && $i <= $kolom_end ) { // thiss
																	 $styles[$baris-2][$i]['border']='bottom';
																	 $styles[$baris-2][$i]['border-style']='thin';
																 }
															 }
														 }

                            break;
                        case 4:
                            if ($i === 0 || $i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 1) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 9) {
                                $styles[$baris][$i]['border']='left,right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i >= 132 && $i <= 184) {
                                $styles[$baris-2][$i]['border']='bottom';
                                $styles[$baris-2][$i]['border-style']='thin';
                            } elseif ($i === 10 || $i === 109 || $i === 186 || $i === 274) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            }
                            break;
                        case 5:
														if ($i === 0 || $i === 12 || $i === 14 || $i === 364) {
														    $styles[$baris][$i]['border']='left';
														    $styles[$baris][$i]['border-style']='thick';
														}elseif ($i === 9 || $i === 10 || $i === 11) {
														    $styles[$baris][$i]['border']='top';
														    $styles[$baris][$i]['border-style']='thin';
														} elseif ($i === 109 || $i === 186 || $i === 274) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 6:
                            if ($i === 0 || $i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 1) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 9) {
                                $styles[$baris][$i]['border']='top,left,bottom,right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 10 || $i === 11) {
                                $styles[$baris][$i]['border']='top,bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 109 || $i === 186 || $i === 274) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 7:
                            if ($i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 13) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 109 || $i === 186 || $i === 274) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 8:
                            if ($i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 13) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 109 || $i === 186 || $i === 274) {
                                $styles[$baris][$i]['border']='right,bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i > 13 && $i < 364) {
                                $styles[$baris][$i]['border']='bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 9:
                            if ($i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 13) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            }
                            break;
                        case 10:
                            if ($i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 13) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            }
                            break;
                        case 11:
                            if ($i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 13) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            }
                            break;
                        case 12:
                            if ($i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i > 13 && $i < 364) {
                                $styles[$baris][$i]['border']='top,bottom';
                                $styles[$baris][$i]['border-style']='thick';
                            }
                            break;
                        case 13:
                            if ($i === 13 || $i === 89 || $i === 242) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 215) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 189 || $i === 272 || $i === 302 || $i === 332) {
                                $styles[$baris][$i]['border']='right,bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i > 89 && $i < 190 || $i > 242 && $i < 364) {
                                $styles[$baris][$i]['border']='bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 14:
                            if ($i === 13 || $i === 89 || $i === 242) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 272 || $i === 302 || $i === 332) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 98 || $i === 189 || $i === 215) {
                                $styles[$baris][$i]['border']='right,bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i > 89 && $i < 243) {
                                $styles[$baris][$i]['border']='bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 15:
                            if ($i === 13 || $i === 89 || $i === 242) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 272 || $i === 302 || $i === 332) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 98 || $i === 189 || $i === 215) {
                                $styles[$baris][$i]['border']='right,bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i > 12 && $i < 243) {
                                $styles[$baris][$i]['border']='bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 16:
                            if ($i === 13 || $i === 89 || $i === 242) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 272 || $i === 302 || $i === 332) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 98 || $i === 189 || $i === 215) {
                                $styles[$baris][$i]['border']='right,bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i > 89 && $i < 243) {
                                $styles[$baris][$i]['border']='bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 17:
                            if ($i === 13 || $i === 89 || $i === 242) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 272 || $i === 302 || $i === 332) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 98 || $i === 189 || $i === 215) {
                                $styles[$baris][$i]['border']='right,bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i > 89 && $i < 243) {
                                $styles[$baris][$i]['border']='bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 18:
                            if ($i === 13 || $i === 89 || $i === 242) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 272 || $i === 302 || $i === 332) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 98 || $i === 189 || $i === 215) {
                                $styles[$baris][$i]['border']='right,bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i > 12 && $i < 243) {
                                $styles[$baris][$i]['border']='bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 19:
                            if ($i === 13 || $i === 89 || $i === 242) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 272 || $i === 302 || $i === 332) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 98 || $i === 189 || $i === 215) {
                                $styles[$baris][$i]['border']='right,bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i > 89 && $i < 243) {
                                $styles[$baris][$i]['border']='bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 20:
                            if ($i === 13 || $i === 89 || $i === 242) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 32 || $i === 51 || $i === 70) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 98 || $i === 189 || $i === 215 || $i === 272 || $i === 302 || $i === 332) {
                                $styles[$baris][$i]['border']='right,bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i > 80 && $i < 364) {
                                $styles[$baris][$i]['border']='bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 21:
														if ($i === 0) {
															$styles[$baris][$i]['border']='left';
															$styles[$baris][$i]['border-style']='thick';
														}elseif ($i === 13 ||$i === 11 || $i === 363 || $i === 89 || $i === 242) {
															$styles[$baris][$i]['border']='right';
															$styles[$baris][$i]['border-style']='thick';
														}elseif ($i === 32 ||$i === 10 ||$i === 32 || $i === 51 || $i === 70 || $i === 272 || $i === 302 || $i === 332 || $i === 98 || $i === 189 || $i === 215) {
															$styles[$baris][$i]['border']='right';
															$styles[$baris][$i]['border-style']='thin';
														}
                            // if ( $i === 13 || $i === 89 || $i === 242) {
                            //     $styles[$baris][$i]['border']='right';
                            //     $styles[$baris][$i]['border-style']='thick';
                            // } elseif ($i === 12 || $i === 364) {
                            //     $styles[$baris][$i]['border']='left';
                            //     $styles[$baris][$i]['border-style']='thick';
                            // } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 272 || $i === 302 || $i === 332) {
                            //     $styles[$baris][$i]['border']='right';
                            //     $styles[$baris][$i]['border-style']='thin';
                            // } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 98 || $i === 189 || $i === 215) {
                            //     $styles[$baris][$i]['border']='right';
                            //     $styles[$baris][$i]['border-style']='thin';
                            // } elseif  ($i > 11 && $i < 364) {
											      //     $styles[$baris][$i]['border']='bottom';
											      //     $styles[$baris][$i]['border-style']='thick';
					                  // }elseif ($i > 0 && $i <= 13) {
														// 		$styles[$baris][$i]['border']='bottom';
														// 		$styles[$baris][$i]['border-style']='thick';
					                  // }elseif ($i === 0 ) {
														// 	$styles[$baris][$i]['border']='bottom,left';
														// 	$styles[$baris][$i]['border-style']='thick';
					                  // }elseif ($i === 10) {
														// 	$styles[$baris][$i]['border']='bottom';
														// 	$styles[$baris][$i]['border-style']='thick';
					                  // }elseif ($i === 10) {
														// 	$styles[$baris][$i]['border']='right';
														// 	$styles[$baris][$i]['border-style']='thin';
					                  // }
                            break;
                        case 22:

												if ($i >= 0 && $i < 364) {
															$styles[$baris][$i]['border']='top';
															$styles[$baris][$i]['border-style']='thick';
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
														$styles[$brsPake][$i]['border']='left';
														$styles[$brsPake][$i]['border-style']='thick';
                            if ($penanda === 1 && $j === (($irg*2)-1)) {
                                $styles[$brsPake][$i]['border']='top,bottom';
                                $styles[$brsPake][$i]['border-style']='thin';
                            } elseif ($penanda === 0) {
                                $styles[$brsPake][$i]['border']='top,left';
                                $styles[$brsPake][$i]['border-style']='thin';
                            } else {
                                $styles[$brsPake][$i]['border']='left';
                                $styles[$brsPake][$i]['border-style']='thin';
                            }
                            break;
                        case 1 || 9 || 10 || 11:
                            if ($penanda === 0) {
                                $styles[$brsPake][$i]['border']='top,left';
                                $styles[$brsPake][$i]['border-style']='thin';
                            } else {
															$styles[$brsPake][$i]['border']='left';
															$styles[$brsPake][$i]['border-style']='thin';
                            }
                            break;

                        default:
                            if ($penanda === 0) {
                                $styles[$brsPake][$i]['border']='top';
                                $styles[$brsPake][$i]['border-style']='thin';
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
														$styles[$barisnya+1][$i]['border']='bottom,left';
														$styles[$barisnya+1][$i]['border-style']='thin';
                            if ($i === 0) {
                                // $styles[$barisnya][$i]['border']='left';
                                // $styles[$barisnya][$i]['border-style']='thick';
                            }elseif ($i === 1) {
															$styles[$barisnya][$i]['border']='left,top';
															$styles[$barisnya][$i]['border-style']='thin';
                            } elseif ($i === 11) {
                                $styles[$barisnya][$i]['border']='left,top,bottom';
                                $styles[$barisnya][$i]['border-style']='thin';

                            }elseif ($i == 9 || $i == 10) {
																$styles[$barisnya][$i]['border']='left,top';
																$styles[$barisnya][$i]['border-style']='thin';
                            } else {
                                $styles[$barisnya][$i]['border']='top';
                                $styles[$barisnya][$i]['border-style']='thin';
                            }
                            break;
												case 1:
												if ($i === 0) {
														$styles[$barisnya][$i]['border']='bottom';
														$styles[$barisnya][$i]['border-style']='thin';
												}
													break;
												// case 5:
												// 		$styles[$barisnya][$i]['border']='bottom';
												// 		$styles[$barisnya][$i]['border-style']='thick';
												// 		break;
                        case 6:
                            $styles[$barisnya][$i]['border']='bottom';
                            $styles[$barisnya][$i]['border-style']='thick';
                            break;
                        default:
                            if ($i === 0) {
                                $styles[$barisnya][$i]['border']='left';
                                $styles[$barisnya][$i]['border-style']='thick';
                            } elseif ($i === 11) {
                                $styles[$barisnya][$i]['border']='left';
                                $styles[$barisnya][$i]['border-style']='thin';
                            }
                            break;
                    }
                }
            }

    //STYLING CARA LAMA
        // //STYLE ROW 1
            //     for ($i=0; $i <= 363; $i++) {
            //         if ($i == 0) {
            //             $style1[$i] = array('border'=>'left,top', 'border-style'=>'thick');
            //         } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
            //             $style1[$i] = array('border'=>'right,top', 'border-style'=>'thick');
            //         } else {
            //             $style1[$i] = array('border'=>'top', 'border-style'=>'thick');
            //         }
            //     }
        // //STYLE ROW 2
            //     for ($i=0; $i <= 363; $i++) {
            //         if ($i == 0) {
            //             $style2[$i] = array('border'=>'left', 'border-style'=>'thick');
            //         } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
            //             $style2[$i] = array('border'=>'right', 'border-style'=>'thick');
            //         } elseif ($i >= 186 && $i < 306) {
            //             $style2[$i] = array('border'=>'top', 'border-style'=>'thin');
            //         } else {
            //             $style2[$i] = array();
            //         }
            //     }
        // //STYLE ROW 3
            //     for ($i=0; $i <= 363; $i++) {
            //         if ($i == 0) {
            //             $style3[$i] = array('border'=>'left', 'border-style'=>'thick');
            //         } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
            //             $style3[$i] = array('border'=>'right', 'border-style'=>'thick');
            //         } elseif ($i >= 307 && $i < 363) {
            //             if ($i == 307 || $i == 322) {
            //                 $style3[$i] = array('font-size'=>9, 'valign'=>'center','border'=>'top', 'border-style'=>'thin');
            //             }else {
            //                 $style3[$i] = array('border'=>'top', 'border-style'=>'thin');
            //             }
            //         } else {

            //                 $style3[$i] = array();

            //         }
            //     }
        // //STYLE ROW 4
            //     for ($i=0; $i <= 363; $i++) {
            //         if ($i == 0) {
            //             $style4[$i] = array('border'=>'left', 'border-style'=>'thick');
            //         } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
            //             $style4[$i] = array('border'=>'right', 'border-style'=>'thick');
            //         } elseif ($i >= 9 && $i < 185) {
            //             $style4[$i] = array('border'=>'top', 'border-style'=>'thin');
            //         } elseif ($i >= 186 && $i < 306) {
            //             $style4[$i] = array('border'=>'top,bottom', 'border-style'=>'thin');
            //         } else {
            //             $style4[$i] = array();
            //         }
            //     }
        // //STYLE ROW 5
            //     for ($i=0; $i <= 363; $i++) {
            //         if ($i == 0) {
            //             $style5[$i] = array('border'=>'left', 'border-style'=>'thick');
            //         } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
            //             $style5[$i] = array('border'=>'right', 'border-style'=>'thick');
            //         } elseif ($i >= 307 && $i < 363) {
            //             $style5[$i] = array('border'=>'top', 'border-style'=>'thin');
            //         } else {
            //             $style5[$i] = array();
            //         }
            //     }
        // //STYLE ROW 6
            //     for ($i=0; $i <= 363; $i++) {
            //         if ($i == 0) {
            //             $style6[$i] = array('border'=>'left', 'border-style'=>'thick');
            //         } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
            //             $style6[$i] = array('border'=>'right', 'border-style'=>'thick');
            //         } else {
            //             $style6[$i] = array();
            //         }
            //     }
        // //STYLE ROW 7
            //     for ($i=0; $i <= 363; $i++) {
            //         if ($i == 0) {
            //             $style7[$i] = array('border'=>'left', 'border-style'=>'thick');
            //         } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
            //             $style7[$i] = array('border'=>'right', 'border-style'=>'thick');
            //         } elseif ($i >= 186 && $i < 306) {
            //             $style7[$i] = array('border'=>'top,bottom', 'border-style'=>'thin');
            //         } elseif ($i >= 307 && $i < 363) {
            //             $style7[$i] = array('border'=>'top', 'border-style'=>'thin');
            //         } else {
            //             $style7[$i] = array();
            //         }
            //     }
        // //STYLE ROW 8
            //     for ($i=0; $i <= 363; $i++) {
            //         if ($i == 0) {
            //             $style8[$i] = array('border'=>'left', 'border-style'=>'thick');
            //         } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
            //             $style8[$i] = array('border'=>'right', 'border-style'=>'thick');
            //         } else {
            //             $style8[$i] = array();
            //         }
            //     }
        // //STYLE ROW 9
            //     for ($i=0; $i <= 363; $i++) {
            //         if ($i == 0) {
            //             $style9[$i] = array('border'=>'left', 'border-style'=>'thick');
            //         } elseif ($i == 8 || $i == 185 || $i == 229 || $i == 254 || $i == 279 || $i == 229 || $i == 306 || $i == 363) {
            //             $style9[$i] = array('border'=>'right', 'border-style'=>'thick');
            //         } else {
            //             $style9[$i] = array();
            //         }
            //     }

        // $styles = array(
        //     $style1,$style2,$style3,$style4,$style5,$style6,$style7,$style8,$style9,$style10,$style11
        //   );


    // SET DATA
        // DATA ROW 1
            $rows[0][9] = $seksi_pembuat; // DATA SEKSI PEMBUAT
            $rows[0][186] = 'Tipe';
            $rows[0][230] = 'Seksi';
            $rows[0][255] = 'Jml. Mesin';
            $rows[0][280] = 'Proses ke .. dari ..';
            $rows[0][307] = 'Doc. No.';
            $rows[0][322] = ' : ';
            $rows[0][324] = ''; //DATA DOC NO
        // DATA ROW 2
            $rows[1][2] = 'CV. KARYA HIDUP SENTOSA';
            $rows[1][186] = $type; //DATA TIPE
            $rows[1][230] = $seksi; //DATA SEKSI
            $rows[1][255] = sizeof($no_mesin); //DATA JML MESIN
            $rows[1][280] = $jml_operator." dari ".$dr_operator; //DATA Proses ke .. dari ..

        // DATA ROW 3
            $rows[2][2] = 'Jl. Magelang No. 144 Yogyakarta 55241';
            $rows[2][307] = 'Rev. No.';
            $rows[2][322] = ' : ';
            $rows[2][324] = ''; //DATA Rev NO

        // DATA ROW 4
            $rows[3][9] = 'TABEL STANDAR KERJA KOMBINASI';
            $rows[3][186] = 'Nama Part';
            $rows[3][230] = 'Line';
            $rows[3][255] = 'No. Mesin';
            $rows[3][280] = 'Qty/Proses';

        // DATA ROW 5
            $rows[4][2] = 'Yogyakarta';
            $rows[4][186] = $nama_part; //DATA Nama Part
            $rows[4][230] = $line; //DATA Line
            $rows[4][255] = $nm; //DATA No. Mesin
            $rows[4][280] = $qty; //DATA Qty/Proses
            $rows[4][307] = 'Rev. Date';
            $rows[4][322] = ' : ';
            $rows[4][324] = ''; //DATA Rev Date

        // DATA ROW 6
        // DATA ROW 7
            $rows[6][2] = 'DEPARTEMEN '.$dept_pembuat; //DATA DEPARTEMEN PEMBUAT
            $rows[6][186] = 'Kode Part';
            $rows[6][230] = 'Takt Time';
            $rows[6][255] = 'Alat Bantu';
            $rows[6][280] = 'Tgl Observasi';
            $rows[6][307] = 'Page';
            $rows[6][322] = ' : ';
            $rows[6][324] = ''; //DATA Page
        // DATA ROW 8
            $rows[7][2] = '';
            $rows[7][186] = $kode_part; //DATA Kode Part
            $rows[7][230] = $takt_time.' Detik'; //DATA Takt Time
            $rows[7][255] = $alat_bantu; //DATA Alat Bantu
            $rows[7][280] = $tanggal; //DATA Tgl Observasi

        // DATA ROW 9
        // DATA ROW 10
        // DATA ROW 11
            $rows[10][0] = 'NO';
            $rows[10][1] = 'ELEMEN KERJA';
            $rows[10][9] = 'MANUAL';
            $rows[10][10] = 'AUTO';
            $rows[10][11] = 'WALK';
            $rows[10][14] = 'Detik';

        // DATA & STYLE ROW 12 & 13
            $headtime = 10;
            $indexheadtime = $indexAngka;
            $time = 1;
            for ($i= $indexAngka; $i < ($indexAngka + $end); $i++) {
                if ($i == $indexheadtime) {
                    $rows[11][$indexheadtime] = $headtime;
                    $headtime += 10;
                    $indexheadtime += 10;
                    $styles[11][$i]['font-size'] = 8;
                    $styles[11][$i]['valign'] = 'center';
                    $styles[11][$i]['halign'] = 'right';
                }
                $rows[12][$i] = $time;
                $styles[12][$i]['font-size'] = 8;
                $styles[12][$i]['valign'] = 'center';
                $styles[12][$i]['halign'] = 'center';
                $time++;
            }

        // DATA & STYLE ELEMEN KERJA
            $rownya = 14;
            for ($j=0; $j < sizeof($elemen_kerja); $j++) {
                $rowkerja = $rownya + ($j *3);
                $rows[$rowkerja][0] = $j+1;
                $rows[$rowkerja][1] = $elemen_kerja[$j];

                switch ($jenis_proses[$j]) {
                    case 'MANUAL':
                        $rows[$rowkerja][9] = $waktu[$j];
                        $styles[$rowkerja][9]['font-size'] = 10;
                        $styles[$rowkerja][9]['valign'] = 'center';
                        $styles[$rowkerja][9]['halign'] = 'center';
                        break;
                    case 'AUTO':
                        $rows[$rowkerja][10] = $waktu[$j];
                        $styles[$rowkerja][10]['font-size'] = 10;
                        $styles[$rowkerja][10]['valign'] = 'center';
                        $styles[$rowkerja][10]['halign'] = 'center';
                        break;
                    case 'WALK':
                        $rows[$rowkerja][11] = $waktu[$j];
                        $styles[$rowkerja][11]['font-size'] = 10;
                        $styles[$rowkerja][11]['valign'] = 'center';
                        $styles[$rowkerja][11]['halign'] = 'center';
                        break;
                    default:
                        # code...
                        break;
                }

                $styles[$rowkerja][0]['font-size'] = 10;
                $styles[$rowkerja][0]['valign'] = 'center';
                $styles[$rowkerja][0]['halign'] = 'center';
                $styles[$rowkerja][1]['font-size'] = 10;
                $styles[$rowkerja][1]['valign'] = 'center';
                $styles[$rowkerja][1]['halign'] = 'left';
            }

        // DATA & STYLE JUMLAH
            $rowJumlahElemen = $rownya + (sizeof($elemen_kerja)*3 +1);
            $rows[$rowJumlahElemen][0] = 'JUMLAH';
            $rows[$rowJumlahElemen][9] = $jumlah_manual;
            $rows[$rowJumlahElemen][10] = $jumlah_auto;
            $rows[$rowJumlahElemen][11] = $jumlah_walk;
            $rows[$rowJumlahElemen][18] = '1. Keterangan';
            $rows[$rowJumlahElemen+1][20] = '- Waktu 1 Shift';
            $rows[$rowJumlahElemen+1][73] = ' = ';
            $rows[$rowJumlahElemen+1][78] = $waktu_satu_shift; //DATA Waktu 1 Shift
            $rows[$rowJumlahElemen+1][94] = 'Detik';
            $rows[$rowJumlahElemen+1][112] = 'Takt Time';

            $rows[$rowJumlahElemen+1][127] = ' = ';
            $rows[$rowJumlahElemen+1][132] = 'Waktu 1 Shift';
            $rows[$rowJumlahElemen+1][191] = 'Waktu / Shift'; // rev 2 okto

            $rows[$rowJumlahElemen+1][206] = ' = ';
						$rows[$rowJumlahElemen+1][211] = 'W1';
						$rows[$rowJumlahElemen+1][228] = '+';
						$rows[$rowJumlahElemen+1][232] = 'W2';
						$rows[$rowJumlahElemen+1][249] = '+...+';
						$rows[$rowJumlahElemen+1][260] = 'Wn';
            $rows[$rowJumlahElemen+1][279] = 'Pcs / Shift';

            $rows[$rowJumlahElemen+1][294] = ' = ';
            $rows[$rowJumlahElemen+1][299] = 'Waktu 1 Shift x Qty dlm 1 cycle';

            $rows[$rowJumlahElemen+2][20] = '- Cycletime (Tanpa Irregular Job)';
            $rows[$rowJumlahElemen+2][73] = ' = ';
            $rows[$rowJumlahElemen+2][78] = $cycle_time_tanpa_irregular; //DATA Cycletime (Tanpa Irregular Job)
            $rows[$rowJumlahElemen+2][94] = 'Detik';
            $rows[$rowJumlahElemen+2][132] = '(';
            $rows[$rowJumlahElemen+2][134] = 'Rencana Produksi / Bulan';
            $rows[$rowJumlahElemen+2][183] = ')';
            $rows[$rowJumlahElemen+2][211] = 'R1';
						$rows[$rowJumlahElemen+2][232] = 'R2';
						$rows[$rowJumlahElemen+2][260] = 'Rn';
            $rows[$rowJumlahElemen+2][299] = 'Cycle Time (Dengan Irregular Job)';


            $rows[$rowJumlahElemen+3][20] = '- Cycletime (Dengan Irregular Job)';
            $rows[$rowJumlahElemen+3][73] = ' = ';
            $rows[$rowJumlahElemen+3][78] = $cycle_time; //DATA Cycletime (Dengan Irregular Job)
            $rows[$rowJumlahElemen+3][94] = 'Detik';
            $rows[$rowJumlahElemen+3][134] = 'Jumlah Hari Kerja / Bulan';
            $rows[$rowJumlahElemen+3][206] = ' = ';
						// foreach ($waktu_irregular as $key => $val) {
						//   $tampung_hasil_irregular[] = $val.'/'.$ratio_irregular[$key];
						// }
						// $rows[$rowJumlahElemen+3][211] = $waktu_irregular[0].'/'.$ratio_irregular[0]; //DATA Cycle Time tanpa Irregular
						//AREA WAKTU IRREGULAR
						if (sizeof($waktu_irregular) <= 4) {
								foreach ($waktu_irregular as $key => $val) {
									if ($key == 0) {
										$kolom_end = 221;
										$kolom_start = $key;
									}else {
										if ($key == 2) {
											$plus_kolom = 5;
										}elseif ($key == 3) {
											$plus_kolom = 10;
										}else {
											$plus_kolom = 0;
										}
										$kolom_end = 226 + ((10* $key) + $plus_kolom);
										$kolom_start = 15 * $key;
									}

									$rows[$rowJumlahElemen+3][211 + $kolom_start] = $val; //DATA Waktu Irregular Job
									$rows[$rowJumlahElemen+4][211 + $kolom_start] = $ratio_irregular[$key]; //DATA Ratio Irregular Job

									if ($key != (sizeof($waktu_irregular)-1)) {
										$rows[$rowJumlahElemen+3][$kolom_end+1] = '+'; //DATA Waktu Irregular Job
									}
							}
						}else {
							foreach ($waktu_irregular as $key => $val) {
							  $tampung_hasil_irregular[] = $val/$ratio_irregular[$key];
							}
							$rows[$rowJumlahElemen+3][211] = implode(' + ', $tampung_hasil_irregular); //DATA Cycle Time tanpa Irregular
						}
						//END
						// $rows[$rowJumlahElemen+3][211] = $waktu_irregular[0]; //DATA Cycle Time tanpa Irregular
            $rows[$rowJumlahElemen+3][294] = ' = ';
            $rows[$rowJumlahElemen+3][299] = $waktu_satu_shift.' x '.$qty; //DATA Waktu 1 Shift x Qty dlm 1 cycle


            $rows[$rowJumlahElemen+4][20] = '- Jumlah Hari Kerja / Bulan';
            $rows[$rowJumlahElemen+4][73] = ' = ';
            $rows[$rowJumlahElemen+4][78] = $jumlah_hari_kerja; //DATA Jumlah Hari Kerja / Bulan
            $rows[$rowJumlahElemen+4][94] = 'Hari';
            $rows[$rowJumlahElemen+4][127] = ' = ';
            $rows[$rowJumlahElemen+4][132] = $waktu_satu_shift; //Data Waktu 1 Shift
            // $rows[$rowJumlahElemen+4][211] = $ratio_irregular[0]; //DATA Ratio Irregular Job
            $rows[$rowJumlahElemen+4][299] = $cycle_time; //DATA Cycle Time (Dengan Irregular Job)


            $rows[$rowJumlahElemen+5][20] = '- Rencana Produksi / Bulan';
            $rows[$rowJumlahElemen+5][73] = ' = ';
            $rows[$rowJumlahElemen+5][78] = $rencana_produksi; //Data Rencana Produksi / Bulan
            $rows[$rowJumlahElemen+5][94] = 'Pcs';
            $rows[$rowJumlahElemen+5][132] = '(';
            $rows[$rowJumlahElemen+5][134] = $rencana_produksi; //Data Rencana Produksi / Bulan
            $rows[$rowJumlahElemen+5][183] = ')';
            $rows[$rowJumlahElemen+5][206] = ' = ';
            $rows[$rowJumlahElemen+5][211] = $jumlah_hasil_irregular; //DATA HASIL 3
            $rows[$rowJumlahElemen+5][230] = 'Detik'; //rev3
            $rows[$rowJumlahElemen+5][294] = ' = ';
            $rows[$rowJumlahElemen+5][299] = ($waktu_satu_shift*$qty)/$cycle_time; //DATA HASIL 4
            $rows[$rowJumlahElemen+5][319] = 'Pcs';


            $rows[$rowJumlahElemen+6][20] = '- Takt Time';
            $rows[$rowJumlahElemen+6][73] = ' = ';
            $rows[$rowJumlahElemen+6][78] = $takt_time; //DATA Takt Time
            $rows[$rowJumlahElemen+6][94] = 'Detik';
            $rows[$rowJumlahElemen + 6][134] = $jumlah_hari_kerja;


            $rows[$rowJumlahElemen+7][20] = '- Qty dalam 1 cycle';
            $rows[$rowJumlahElemen+7][73] = ' = ';
            $rows[$rowJumlahElemen+7][78] = $qty; //DATA Qty dalam 1 Cycle
						$rows[$rowJumlahElemen+7][94] = 'Pcs';
            $rows[$rowJumlahElemen+7][127] = ' = ';
            $rows[$rowJumlahElemen+7][132] = $takt_time; //Data HASIL 1
            $rows[$rowJumlahElemen+7][147] = 'Detik';

						$rows[$rowJumlahElemen+8][20] = '- Forecast ';
						$rows[$rowJumlahElemen+8][73] = ' = ';
						$rows[$rowJumlahElemen+8][78] = $forecast; //DATA forecast
						$rows[$rowJumlahElemen+8][94] = 'Unit';

						$rows[$rowJumlahElemen+9][20] = '- Qty / Unit ';
						$rows[$rowJumlahElemen+9][73] = ' = ';
						$rows[$rowJumlahElemen+9][78] = $qty_unit; //DATA qty_unit
						$rows[$rowJumlahElemen+9][94] = 'Unit';

            $rows[$rowJumlahElemen+11][18] = '5. Usulan Perbaikan';

            $rows[$rowJumlahElemen][114] = '2. Perhitungan Taktime';
            $rows[$rowJumlahElemen][191] = '3. Waktu Irregular Job';
            $rows[$rowJumlahElemen][279] = '4. Jumlah Pcs yang dihasilkan dalam 1 shift';
            $rows[$rowJumlahElemen+4][9] = $jumlah; //rev4


            for ($j=0; $j < 12; $j++) {
                $barisnya = $rowJumlahElemen + $j;
                for ($i=0; $i < 364; $i++) {
                    switch ($j) {
                        case 0:
                            if ($i === 0 || $i === 9 || $i === 10 || $i === 11) {
                                $styles[$barisnya][$i]['font-size'] = 10;
                                $styles[$barisnya][$i]['valign'] = 'center';
                                $styles[$barisnya][$i]['halign'] = 'center';
                            } elseif ($i === 18 || $i === 114 || $i === 191 || $i === 279) {
                                $styles[$barisnya][$i]['font-size'] = 8;
                                $styles[$barisnya][$i]['font-style'] = 'bold';
                                $styles[$barisnya][$i]['valign'] = 'center';
                                $styles[$barisnya][$i]['halign'] = 'left';
                            } else {
                                $styles[$barisnya][$i]['font-size'] = 8;
                                $styles[$barisnya][$i]['valign'] = 'center';
                                $styles[$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        case 1:
                            $styles[$barisnya][$i]['font-size'] = 8;
                            $styles[$barisnya][$i]['valign'] = 'center';
                            if ($i === 112 || $i === 191 || $i === 279) {
                                $styles[$barisnya][$i]['wrap_text'] = true;
                                $styles[$barisnya][$i]['halign'] = 'center'; //hiahia
                            } elseif ($i === 73 || $i === 127 || $i === 132 || $i === 206 || $i === 211 || $i === 232 || $i === 260 || $i === 294 || $i === 299) {
                                $styles[$barisnya][$i]['halign'] = 'center';
                            } else {
                                $styles[$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        case 2:
                            if ($i === 9) {
                                $styles[$barisnya][$i]['font-size'] = 10;
                            } else {
                                $styles[$barisnya][$i]['font-size'] = 8;
                            }
                            $styles[$barisnya][$i]['valign'] = 'center';
                            if ($i === 9 || $i === 73 || $i === 132 || $i === 134 || $i === 183 || $i === 211 || $i === 232 || $i === 260 || $i === 299) {
                                $styles[$barisnya][$i]['halign'] = 'center';
                            } else {
                                $styles[$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        case 3:
                            $styles[$barisnya][$i]['font-size'] = 8;
                            $styles[$barisnya][$i]['valign'] = 'center';
                            if ( $i === 73 || $i === 134 || $i === 211 || $i === 206 || $i === 226 || $i === 241 || $i === 256 || $i ===294 || $i === 299) {
                                $styles[$barisnya][$i]['halign'] = 'center';
                            } else {
                                $styles[$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        case 4:
														$styles[$barisnya][$i]['valign'] = 'center';
                            if ( $i === 73 || $i === 127 || $i === 132 || $i === 211 || $i === 226 || $i === 241 || $i === 256 || $i === 299) {
                              $styles[$barisnya][$i]['halign'] = 'center';
															$styles[$barisnya][$i]['font-size'] = 8;

                            }elseif ($i === 9) {
															$styles[$barisnya][$i]['font-size'] = 10;
                            	$styles[$barisnya][$i]['valign'] = 'center';
															$styles[$barisnya][$i]['halign'] = 'center';
                            } else {
															$styles[$barisnya][$i]['halign'] = 'left';
															$styles[$barisnya][$i]['font-size'] = 8;
                            }
                            break;
                        case 5:
                            $styles[$barisnya][$i]['font-size'] = 8;
                            $styles[$barisnya][$i]['valign'] = 'center';
                            if ($i === 73 || $i === 132 || $i === 206 || $i === 211 || $i === 294 || $i === 299 || $i === 134 || $i === 183) {
                                $styles[$barisnya][$i]['halign'] = 'center';
                            } else {
                                $styles[$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        case 6:
                            $styles[$barisnya][$i]['font-size'] = 8;
                            $styles[$barisnya][$i]['valign'] = 'center';
                            if ($i === 73 || $i === 134) {
                                $styles[$barisnya][$i]['halign'] = 'center';
                            } else {
                                $styles[$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        case 7:
                            $styles[$barisnya][$i]['font-size'] = 8;
                            $styles[$barisnya][$i]['valign'] = 'center';
                            if ($i === 73 || $i === 132) {
                                $styles[$barisnya][$i]['halign'] = 'center';
                            } else {
                                $styles[$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        case 8:
														$styles[$barisnya][$i]['font-size'] = 8;
														$styles[$barisnya][$i]['valign'] = 'center';
														$styles[$barisnya][$i]['halign'] = 'left';
                            break;
                        case 9:
														$styles[$barisnya][$i]['font-size'] = 8;
														$styles[$barisnya][$i]['valign'] = 'center';
														$styles[$barisnya][$i]['halign'] = 'left';
                            break;
												case 11:
                            if ($i === 18) {
                                $styles[$barisnya][$i]['font-size'] = 8;
                                $styles[$barisnya][$i]['font-style'] = 'bold';
                                $styles[$barisnya][$i]['valign'] = 'center';
                                $styles[$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }

        // DATA & STYLE HEADER IRREGULAR JOB
            $rows[$rowJumlahElemen+6][0] = 'No';
            $rows[$rowJumlahElemen+6][1] = 'Irregular Job';
            $rows[$rowJumlahElemen+6][9] = 'Ratio';
            $rows[$rowJumlahElemen+6][10] = 'Waktu';
            $rows[$rowJumlahElemen+6][11] = 'Ratio / Waktu';
            $rows[$rowJumlahElemen+8][9] = 'Kali';
            $rows[$rowJumlahElemen+8][10] = 'Detik';

            $styles[$rowJumlahElemen+6][0]['font-size'] = 10;
            $styles[$rowJumlahElemen+6][0]['valign'] = 'center';
            $styles[$rowJumlahElemen+6][0]['halign'] = 'center';
            $styles[$rowJumlahElemen+6][1]['font-size'] = 10;
            $styles[$rowJumlahElemen+6][1]['valign'] = 'center';
            $styles[$rowJumlahElemen+6][1]['halign'] = 'left';
            $styles[$rowJumlahElemen+6][9]['font-size'] = 10;
            $styles[$rowJumlahElemen+6][9]['valign'] = 'center';
            $styles[$rowJumlahElemen+6][9]['halign'] = 'center';
            $styles[$rowJumlahElemen+6][10]['font-size'] = 10;
            $styles[$rowJumlahElemen+6][10]['valign'] = 'center';
            $styles[$rowJumlahElemen+6][10]['halign'] = 'center';
            $styles[$rowJumlahElemen+6][11]['font-size'] = 10;
            $styles[$rowJumlahElemen+6][11]['valign'] = 'center';
            $styles[$rowJumlahElemen+6][11]['halign'] = 'center';
            $styles[$rowJumlahElemen+6][11]['wrap_text'] = true;

            $styles[$rowJumlahElemen+8][9]['font-size'] = 10;
            $styles[$rowJumlahElemen+8][9]['valign'] = 'center';
            $styles[$rowJumlahElemen+8][9]['halign'] = 'center';
            $styles[$rowJumlahElemen+8][10]['font-size'] = 10;
            $styles[$rowJumlahElemen+8][10]['valign'] = 'center';
            $styles[$rowJumlahElemen+8][10]['halign'] = 'center';

        // DATA FOOTER KANAN
            $rowFootKanan = $rowJumlahElemen+15;
            $styles[$rowFootKanan+1][19]['fill'] = '#000000'; //manual
            $styles[$rowFootKanan+1][57]['fill'] = '#fcf403'; //cycletime
            $styles[$rowFootKanan+3][59]['fill'] = '#fc0303'; //taktime
            $styles[$rowFootKanan+4][59]['fill'] = '#fc0303';
            $styles[$rowFootKanan+5][59]['fill'] = '#fc0303';
            $styles[$rowFootKanan+4][19]['fill'] = '#65eb00'; //auto
            $styles[$rowFootKanan+7][19]['fill'] = '#00dbc5'; //walk
            $styles[$rowFootKanan+7][57]['fill'] = '#fa3eed'; //muda
            // $styles[$rowFootKanan][0]['valign'] = 'center';
            // $styles[$rowFootKanan][0]['halign'] = 'center';
            $rows[$rowFootKanan][33] = 'Manual';
            $rows[$rowFootKanan][71] = 'Cycle Time';
            $rows[$rowFootKanan][90] = 'Revisi';
            $rows[$rowFootKanan][190] = 'Tanggal';
            $rows[$rowFootKanan][216] = 'Oleh';
            $rows[$rowFootKanan][243] = 'Menyetujui';
            $rows[$rowFootKanan][273] = 'Diperiksa 2';
            $rows[$rowFootKanan][303] = 'Diperiksa 1';
            $rows[$rowFootKanan][333] = 'Dibuat';

            $rows[$rowFootKanan+1][90] = 'No.';
            $rows[$rowFootKanan+1][99] = 'Detail';

            $rows[$rowFootKanan+3][33] = 'Auto (Mesin)';
            $rows[$rowFootKanan+3][71] = 'Takt Time';

            $rows[$rowFootKanan+6][33] = 'Jalan';
            $rows[$rowFootKanan+6][71] = 'Muda';

            $rows[$rowFootKanan+8][243] = 'Tgl :';
            $rows[$rowFootKanan+8][273] = 'Tgl :';
            $rows[$rowFootKanan+8][303] = 'Tgl :';
            $rows[$rowFootKanan+8][333] = 'Tgl :';

						$rows[$rowFootKanan+9][231] = 'Form No. : FRM-PDE-03-21 (Rev. 00-26/03/2020)';
						// echo "<pre>";
						// print_r($rows[$rowFootKanan]);
						// die;
            for ($j=0; $j < 10; $j++) {
                $rowpakefoot = $rowFootKanan + $j;
                for ($i=0; $i < 364; $i++) {
                    switch ($j) {
                        case 0:
                            if ($i === 33 || $i === 71 || $i === 90 || $i === 190 || $i === 216 || $i === 243 || $i === 273 || $i === 303 || $i === 333) {
                                if ($i != 33) {
                                    $styles[$rowpakefoot][$i]['wrap_text'] = true;
                                }
                                $styles[$rowpakefoot][$i]['halign'] = 'center';
                                $styles[$rowpakefoot][$i]['font-size'] = 8;
                                $styles[$rowpakefoot][$i]['valign'] = 'center';
                                if ($i === 90 || $i === 190 || $i === 216) {
                                    $styles[$rowpakefoot][$i]['font-style'] = 'bold';
                                }

                            }
                            break;
                        case 1:
                            if ($i === 90 || $i === 99) {
                                $styles[$rowpakefoot][$i]['halign'] = 'center';
                                $styles[$rowpakefoot][$i]['font-size'] = 8;
                                $styles[$rowpakefoot][$i]['valign'] = 'center';
                                $styles[$rowpakefoot][$i]['font-style'] = 'bold';
                            }
                            break;
                        case 3:
                            if ($i === 33 || $i === 71) {
                                $styles[$rowpakefoot][$i]['wrap_text'] = true;
                                $styles[$rowpakefoot][$i]['halign'] = 'center';
                                if ($i === 33) {
                                    $styles[$rowpakefoot][$i]['font-size'] = 7;
                                } else {
                                    $styles[$rowpakefoot][$i]['font-size'] = 7;
                                }
                                $styles[$rowpakefoot][$i]['valign'] = 'center';
                            }
                            break;
                        case 6:
                            if ($i === 33 || $i === 71) {
                                $styles[$rowpakefoot][$i]['wrap_text'] = true;
                                $styles[$rowpakefoot][$i]['halign'] = 'center';
                                $styles[$rowpakefoot][$i]['font-size'] = 8;
                                $styles[$rowpakefoot][$i]['valign'] = 'center';
                            }
                            break;
                        case 8:
                            if ($i === 243 || $i === 273 || $i === 303 || $i === 333) {
                                $styles[$rowpakefoot][$i]['wrap_text'] = true;
                                $styles[$rowpakefoot][$i]['halign'] = 'left';
                                $styles[$rowpakefoot][$i]['font-size'] = 8;
                                $styles[$rowpakefoot][$i]['valign'] = 'center';
                            }
                            break;
                        case 9:
                        if ($i === 243) {
                            // $styles[$rowpakefoot][$i]['wrap_text'] = true;
                            // $styles[$rowpakefoot][$i]['halign'] = 'left';
                            $styles[$rowpakefoot][$i]['font-size'] = 8;
                            // $styles[$rowpakefoot][$i]['valign'] = 'center';
                        }
                        break;
                        default:
                            # code...
                            break;
                    }
                }
            }

        // DATA IRREGULAR JOB
            $rowDataIrregular = $rowJumlahElemen+7;
            for ($i=1; $i <= sizeof($irregular_jobs); $i++) {
                $pakeRowIrregular = $rowDataIrregular + ($i * 2);
                $rows[$pakeRowIrregular][0] = $i;
                $styles[$pakeRowIrregular][0]['font-size'] = 10;
                $styles[$pakeRowIrregular][0]['valign'] = 'center';
                $rows[$pakeRowIrregular][1] = $irregular_jobs[$i-1];
                $styles[$pakeRowIrregular][1]['font-size'] = 10;
                $styles[$pakeRowIrregular][1]['valign'] = 'center';
                $rows[$pakeRowIrregular][9] = $ratio_irregular[$i-1];
                $styles[$pakeRowIrregular][9]['font-size'] = 10;
                $styles[$pakeRowIrregular][9]['valign'] = 'center';
                $styles[$pakeRowIrregular][9]['halign'] = 'center';
                $rows[$pakeRowIrregular][10] = $waktu_irregular[$i-1];
                $styles[$pakeRowIrregular][10]['font-size'] = 10;
                $styles[$pakeRowIrregular][10]['valign'] = 'center';
                $styles[$pakeRowIrregular][10]['halign'] = 'center';
                $rows[$pakeRowIrregular][11] = $hasil_irregular [$i-1];
                $styles[$pakeRowIrregular][11]['font-size'] = 10;
                $styles[$pakeRowIrregular][11]['valign'] = 'center';
                $styles[$pakeRowIrregular][11]['halign'] = 'center';
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
            $rows[$pakeRowIrregular + (($rowIrregular*2) - $min001)][0] = 'JUMLAH';
            $styles[$pakeRowIrregular + (($rowIrregular*2) - $min001)][0]['font-size'] = 10;
            $styles[$pakeRowIrregular + (($rowIrregular*2) - $min001)][0]['valign'] = 'center';
            $styles[$pakeRowIrregular + (($rowIrregular*2) - $min001)][0]['halign'] = 'center';
            $rows[$pakeRowIrregular + (($rowIrregular*2) - $min001)][11] = $jumlah_hasil_irregular;
            $styles[$pakeRowIrregular + (($rowIrregular*2) - $min001)][11]['font-size'] = 10;
            $styles[$pakeRowIrregular + (($rowIrregular*2) - $min001)][11]['valign'] = 'center';
            $styles[$pakeRowIrregular + (($rowIrregular*2) - $min001)][11]['halign'] = 'center';


    // TIME FLOW
        for ($j=0; $j < sizeof($elemen_kerja); $j++) {
            $rowflow = $rownya + ($j * 3);
            if ($muda[$j] > 1) {
                $startmuda[$j] = $start[$j]-$muda[$j];
                $finishmuda[$j] = $start[$j]-1;
            } else {
                $startmuda[$j]= -2;
                $finishmuda[$j] = -1;
            }
            for ($i=0; $i < $cycle_time; $i++) {
                if ($i >= $start[$j] && $i <= $finish[$j]) {
                    if ($jenis_proses[$j] === 'MANUAL') {
                        $warna = '#000000';
                    } elseif ($jenis_proses[$j] === 'AUTO') {
                        $warna = '#65eb00';
                    } elseif ($jenis_proses[$j] === 'WALK') {
                        $warna = '#00dbc5';
                    }
                    $styles[$rowflow + 1][$i+13]['fill'] = $warna;
                    $rows[$rowflow + 1][$i+13] = $i-$start[$j]+1;
                    //Garis Takttime
										if ($takt_time == '-') {
											$styles[$rowflow][$takt_time + 13]['fill'] = '#ffffff';
											$styles[$rowflow+1][$takt_time + 13]['fill'] = '#ffffff';
											$styles[$rowflow+2][$takt_time + 13]['fill'] = '#ffffff';
										}else {
											$styles[$rowflow][$takt_time + 13]['fill'] = '#fc0303';
											$styles[$rowflow+1][$takt_time + 13]['fill'] = '#fc0303';
											$styles[$rowflow+2][$takt_time + 13]['fill'] = '#fc0303';
										}

                    //Garis Cycletime
                    $styles[$rowflow][$cycle_time + 13]['fill'] = '#fcf403';
                    $styles[$rowflow+1][$cycle_time + 13]['fill'] = '#fcf403';
                    $styles[$rowflow+2][$cycle_time + 13]['fill'] = '#fcf403';
                }
                if ($i >= $startmuda[$j] && $i <= $finishmuda[$j]) {
                    $styles[$rowflow][$i+13]['fill'] = '#fa3eef';
                    $styles[$rowflow-1][$i+13]['fill'] = '#fa3eef';
                    if ($i === $finishmuda[$j]) {
                        $rows[$rowflow-1][$i+13] = 'Muda: '.$muda[$j].' Detik';
                    }
                }
            }
        }
        //Irregular Job
            for ($i=0; $i < $jumlah_hasil_irregular; $i++) {
                $styles[$rownya][$last_finish + 14 + $i]['fill'] = '#2a61ad';
                $rows[$rownya][$last_finish + 14 + $i] = $i +1;
            }
        $styles[$rownya + 13][$takt_time + 14]['font-size'] = 10;
				if ($takt_time == '-') {
					$rows[$rownya + 13][$takt_time + 14] = '';
				}else {
					$rows[$rownya + 13][$takt_time + 14] = 'Takt Time = '.$takt_time.' Detik';
				}
        //CycleTime
        $rows[$rownya][$cycle_time + 14] = 'Cycle Time = '.$cycle_time.' Detik';
        // $rows[$rownya + 13][$cycle_time + 14] = 'Cycle Time = '.$cycle_time.' Detik';




    $writer->writeSheetHeader($sheet1, $header, $col_options);      //WRITE HEADER
    for ($i=0; $i < sizeof($rows); $i++) {
        $writer->writeSheetRow($sheet1, $rows[$i], $styles[$i]);    //WRITE ROWS
    }

    //LAYOUT HEADER, FORMATTING MERGE CELL
        $writer->markMergedCell($sheet1, $start_row=0, $start_col=0, $end_row=0, $end_col=($indexAngka + $end)-1); // TEXT IDENTITAS TSKK
        //ROW 1
            $writer->markMergedCell($sheet1, $start_row=1, $start_col=0, $end_row=9, $end_col=1); //LOGO QUICK
            $writer->markMergedCell($sheet1, $start_row=1, $start_col=2, $end_row=1, $end_col=8); //BLANK
            $writer->markMergedCell($sheet1, $start_row=1, $start_col=9, $end_row=3, $end_col=185); //SEKSI GEDE
            $writer->markMergedCell($sheet1, $start_row=1, $start_col=186, $end_row=1, $end_col=229); //TIPE
            $writer->markMergedCell($sheet1, $start_row=1, $start_col=230, $end_row=1, $end_col=254); //SEKSI
            $writer->markMergedCell($sheet1, $start_row=1, $start_col=255, $end_row=1, $end_col=279); //JML MESIN
            $writer->markMergedCell($sheet1, $start_row=1, $start_col=280, $end_row=1, $end_col=306); //PROSES KE
            $writer->markMergedCell($sheet1, $start_row=1, $start_col=307, $end_row=2, $end_col=321); //DOC NO
            $writer->markMergedCell($sheet1, $start_row=1, $start_col=322, $end_row=2, $end_col=323); //TITIK 2
            $writer->markMergedCell($sheet1, $start_row=1, $start_col=324, $end_row=2, $end_col=363); //BLANK

        //ROW 2
            $writer->markMergedCell($sheet1, $start_row=2, $start_col=2, $end_row=2, $end_col=8); //CV KHS
            $writer->markMergedCell($sheet1, $start_row=2, $start_col=186, $end_row=3, $end_col=229); //DATA TIPE
            $writer->markMergedCell($sheet1, $start_row=2, $start_col=230, $end_row=3, $end_col=254); //DATA SEKSI
            $writer->markMergedCell($sheet1, $start_row=2, $start_col=255, $end_row=3, $end_col=279); //DATA JML MESIN
            $writer->markMergedCell($sheet1, $start_row=2, $start_col=280, $end_row=3, $end_col=306); //DATA PROSES KE

        //ROW 3
            $writer->markMergedCell($sheet1, $start_row=3, $start_col=2, $end_row=4, $end_col=8); //ALAMAT
            $writer->markMergedCell($sheet1, $start_row=3, $start_col=307, $end_row=4, $end_col=321); //REV NO
            $writer->markMergedCell($sheet1, $start_row=3, $start_col=322, $end_row=4, $end_col=323); //TITIK 2
            $writer->markMergedCell($sheet1, $start_row=3, $start_col=324, $end_row=4, $end_col=363); //BLANK

        //ROW 4
            $writer->markMergedCell($sheet1, $start_row=4, $start_col=9, $end_row=9, $end_col=185); //TABEL STANDAR KERJA KOMBINASI
            $writer->markMergedCell($sheet1, $start_row=4, $start_col=186, $end_row=4, $end_col=229); //NAMA PART
            $writer->markMergedCell($sheet1, $start_row=4, $start_col=230, $end_row=4, $end_col=254); //LINE
            $writer->markMergedCell($sheet1, $start_row=4, $start_col=255, $end_row=4, $end_col=279); //NO MESIN
            $writer->markMergedCell($sheet1, $start_row=4, $start_col=280, $end_row=4, $end_col=306); //QTY/PROSES

        //ROW 5
            $writer->markMergedCell($sheet1, $start_row=5, $start_col=2, $end_row=5, $end_col=8); //YOGYAKARTA
            $writer->markMergedCell($sheet1, $start_row=5, $start_col=186, $end_row=6, $end_col=229); //DATA NAMA PART
            $writer->markMergedCell($sheet1, $start_row=5, $start_col=230, $end_row=6, $end_col=254); //DATA LINE
            $writer->markMergedCell($sheet1, $start_row=5, $start_col=255, $end_row=6, $end_col=279); //DATA NO MESIN
            $writer->markMergedCell($sheet1, $start_row=5, $start_col=280, $end_row=6, $end_col=306); //DATA QTY/PROSES
            $writer->markMergedCell($sheet1, $start_row=5, $start_col=307, $end_row=6, $end_col=321); //REV DATE
            $writer->markMergedCell($sheet1, $start_row=5, $start_col=322, $end_row=6, $end_col=323); //TITIK 2
            $writer->markMergedCell($sheet1, $start_row=5, $start_col=324, $end_row=6, $end_col=363); //BLANK

        //ROW 6
            $writer->markMergedCell($sheet1, $start_row=6, $start_col=2, $end_row=6, $end_col=8); //BLANK

        //ROW 7
            $writer->markMergedCell($sheet1, $start_row=7, $start_col=2, $end_row=7, $end_col=8); //DEPARTEMEN
            $writer->markMergedCell($sheet1, $start_row=7, $start_col=186, $end_row=7, $end_col=229); //KODE PART
            $writer->markMergedCell($sheet1, $start_row=7, $start_col=230, $end_row=7, $end_col=254); //TAKT TIME
            $writer->markMergedCell($sheet1, $start_row=7, $start_col=255, $end_row=7, $end_col=279); //ALAT BANTU
            $writer->markMergedCell($sheet1, $start_row=7, $start_col=280, $end_row=7, $end_col=306); //TGL OBSERVASI
            $writer->markMergedCell($sheet1, $start_row=7, $start_col=307, $end_row=9, $end_col=321); //PAGE
            $writer->markMergedCell($sheet1, $start_row=7, $start_col=322, $end_row=9, $end_col=323); //TITIK 2
            $writer->markMergedCell($sheet1, $start_row=7, $start_col=324, $end_row=9, $end_col=363); //BLANK

        //ROW 8
            $writer->markMergedCell($sheet1, $start_row=8, $start_col=2, $end_row=9, $end_col=8); //BLANK
            $writer->markMergedCell($sheet1, $start_row=8, $start_col=186, $end_row=9, $end_col=229); //DATA KODE PART
            $writer->markMergedCell($sheet1, $start_row=8, $start_col=230, $end_row=9, $end_col=254); //DATA TAKT TIME
            $writer->markMergedCell($sheet1, $start_row=8, $start_col=255, $end_row=9, $end_col=279); //DATA ALAT BANTU
            $writer->markMergedCell($sheet1, $start_row=8, $start_col=280, $end_row=9, $end_col=306); //DATA TGL OBSERVASI

        //ROW 9
        //ROW 10
            $writer->markMergedCell($sheet1, $start_row=11, $start_col=0, $end_row=13, $end_col=0); //HEAD NO
            $writer->markMergedCell($sheet1, $start_row=11, $start_col=1, $end_row=13, $end_col=8); //HEAD ELEMEN KERJA
            $writer->markMergedCell($sheet1, $start_row=11, $start_col=9, $end_row=13, $end_col=9); //HEAD MANUAL
            $writer->markMergedCell($sheet1, $start_row=11, $start_col=10, $end_row=13, $end_col=10); //HEAD AUTO
            $writer->markMergedCell($sheet1, $start_row=11, $start_col=11, $end_row=13, $end_col=11); //HEAD WALK
            $writer->markMergedCell($sheet1, $start_row=11, $start_col=14, $end_row=11, $end_col=($indexAngka + $end)-1); //HEAD DETIK

        //ROW 11
            for ($i= $indexAngka; $i < ($indexAngka + $end); $i+=10) {
                $fin = $i + 9;
                $writer->markMergedCell($sheet1, $start_row=12, $start_col= $i, $end_row=12, $end_col= $fin);
            }

        //ROW ELEMEN KERJA
            for ($i=0; $i < sizeof($elemen_kerja); $i++) {
                $rowstart = 15 + ($i * 3);
                $rowend = $rowstart + 2;
                $writer->markMergedCell($sheet1, $start_row= $rowstart, $start_col= 0, $end_row=$rowend, $end_col= 0);
                $writer->markMergedCell($sheet1, $start_row= $rowstart, $start_col= 1, $end_row=$rowend, $end_col= 8);
                $writer->markMergedCell($sheet1, $start_row= $rowstart, $start_col= 9, $end_row=$rowend, $end_col= 9);
                $writer->markMergedCell($sheet1, $start_row= $rowstart, $start_col= 10, $end_row=$rowend, $end_col= 10);
                $writer->markMergedCell($sheet1, $start_row= $rowstart, $start_col= 11, $end_row=$rowend, $end_col= 11);
            }

        //ROW JUMLAH & KETERANGAN
            $rowjum = 15 + (sizeof($elemen_kerja) * 3) + 1;
            //JUMLAH
                $writer->markMergedCell($sheet1, $start_row= $rowjum, $start_col= 0, $end_row=$rowjum+4, $end_col= 8);
                $writer->markMergedCell($sheet1, $start_row= $rowjum, $start_col= 9, $end_row=$rowjum+3, $end_col= 9);
                $writer->markMergedCell($sheet1, $start_row= $rowjum, $start_col= 10, $end_row=$rowjum+3, $end_col= 10);
	              $writer->markMergedCell($sheet1, $start_row= $rowjum, $start_col= 11, $end_row=$rowjum+3, $end_col= 11);
                $writer->markMergedCell($sheet1, $start_row= $rowjum+4, $start_col= 9, $end_row=$rowjum+4, $end_col= 11);
            //KETERANGAN
                // 1
                    $writer->markMergedCell($sheet1, $start_row= $rowjum, $start_col= 18, $end_row=$rowjum, $end_col= 107);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 20, $end_row=$rowjum+1, $end_col= 72);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 73, $end_row=$rowjum+1, $end_col= 77);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 78, $end_row=$rowjum+1, $end_col= 93);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 94, $end_row=$rowjum+1, $end_col= 107);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+2, $start_col= 20, $end_row=$rowjum+2, $end_col= 72);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+2, $start_col= 73, $end_row=$rowjum+2, $end_col= 77);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+2, $start_col= 78, $end_row=$rowjum+2, $end_col= 93);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+2, $start_col= 94, $end_row=$rowjum+2, $end_col= 107);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+3, $start_col= 20, $end_row=$rowjum+3, $end_col= 72);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+3, $start_col= 73, $end_row=$rowjum+3, $end_col= 77);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+3, $start_col= 78, $end_row=$rowjum+3, $end_col= 93);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+3, $start_col= 94, $end_row=$rowjum+3, $end_col= 107);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+4, $start_col= 20, $end_row=$rowjum+4, $end_col= 72);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+4, $start_col= 73, $end_row=$rowjum+4, $end_col= 77);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+4, $start_col= 78, $end_row=$rowjum+4, $end_col= 93);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+4, $start_col= 94, $end_row=$rowjum+4, $end_col= 107);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+5, $start_col= 20, $end_row=$rowjum+5, $end_col= 72);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+5, $start_col= 73, $end_row=$rowjum+5, $end_col= 77);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+5, $start_col= 78, $end_row=$rowjum+5, $end_col= 93);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+5, $start_col= 94, $end_row=$rowjum+5, $end_col= 107);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+6, $start_col= 20, $end_row=$rowjum+6, $end_col= 72);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+6, $start_col= 73, $end_row=$rowjum+6, $end_col= 77);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+6, $start_col= 78, $end_row=$rowjum+6, $end_col= 93);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+6, $start_col= 94, $end_row=$rowjum+6, $end_col= 107);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+7, $start_col= 20, $end_row=$rowjum+7, $end_col= 72);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+7, $start_col= 73, $end_row=$rowjum+7, $end_col= 77);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+7, $start_col= 78, $end_row=$rowjum+7, $end_col= 93);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+7, $start_col= 94, $end_row=$rowjum+7, $end_col= 107);

										$writer->markMergedCell($sheet1, $start_row= $rowjum+8, $start_col= 20, $end_row=$rowjum+8, $end_col= 72);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+8, $start_col= 73, $end_row=$rowjum+8, $end_col= 77);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+8, $start_col= 78, $end_row=$rowjum+8, $end_col= 93);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+8, $start_col= 94, $end_row=$rowjum+8, $end_col= 107);

										$writer->markMergedCell($sheet1, $start_row= $rowjum+9, $start_col= 20, $end_row=$rowjum+9, $end_col= 72);
										$writer->markMergedCell($sheet1, $start_row= $rowjum+9, $start_col= 73, $end_row=$rowjum+9, $end_col= 77);
										$writer->markMergedCell($sheet1, $start_row= $rowjum+9, $start_col= 78, $end_row=$rowjum+9, $end_col= 93);
										$writer->markMergedCell($sheet1, $start_row= $rowjum+9, $start_col= 94, $end_row=$rowjum+9, $end_col= 107);
										 //al e01821

                // 2
                    $writer->markMergedCell($sheet1, $start_row= $rowjum, $start_col= 114, $end_row=$rowjum, $end_col= 184);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 112, $end_row=$rowjum+3, $end_col= 126);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 127, $end_row=$rowjum+3, $end_col= 131);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 132, $end_row=$rowjum+1, $end_col= 184);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+2, $start_col= 132, $end_row=$rowjum+3, $end_col= 133);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+2, $start_col= 134, $end_row=$rowjum+2, $end_col= 182);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+2, $start_col= 183, $end_row=$rowjum+3, $end_col= 184);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+3, $start_col= 134, $end_row=$rowjum+3, $end_col= 182);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+4, $start_col= 127, $end_row=$rowjum+6, $end_col= 131);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+4, $start_col= 132, $end_row=$rowjum+4, $end_col= 184);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+5, $start_col= 132, $end_row=$rowjum+6, $end_col= 133);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+5, $start_col= 134, $end_row=$rowjum+5, $end_col= 182);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+5, $start_col= 183, $end_row=$rowjum+6, $end_col= 184);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+6, $start_col= 134, $end_row=$rowjum+6, $end_col= 182);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+7, $start_col= 127, $end_row=$rowjum+8, $end_col= 131);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+7, $start_col= 132, $end_row=$rowjum+8, $end_col= 146);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+7, $start_col= 147, $end_row=$rowjum+8, $end_col= 161);

								// REV 20-10-2020
                // 3
                    $writer->markMergedCell($sheet1, $start_row= $rowjum, $start_col= 191, $end_row=$rowjum, $end_col= 272);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 191, $end_row=$rowjum+2, $end_col= 205);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 206, $end_row=$rowjum+2, $end_col= 210);

										$writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 211, $end_row=$rowjum+1, $end_col= 227);
										$writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 232, $end_row=$rowjum+1, $end_col= 248);
										$writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 260, $end_row=$rowjum+1, $end_col= 272);

										$writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 228, $end_row=$rowjum+2, $end_col= 231);
										$writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 249, $end_row=$rowjum+2, $end_col= 259);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+2, $start_col= 211, $end_row=$rowjum+2, $end_col= 227);
										$writer->markMergedCell($sheet1, $start_row= $rowjum+2, $start_col= 232, $end_row=$rowjum+2, $end_col= 248);
										$writer->markMergedCell($sheet1, $start_row= $rowjum+2, $start_col= 260, $end_row=$rowjum+2, $end_col= 272);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+3, $start_col= 206, $end_row=$rowjum+4, $end_col= 210);

                    // $writer->markMergedCell($sheet1, $start_row= $rowjum+3, $start_col= 211, $end_row=$rowjum+3, $end_col= 221);
                    // $writer->markMergedCell($sheet1, $start_row= $rowjum+4, $start_col= 211, $end_row=$rowjum+4, $end_col= 221);
										if (sizeof($waktu_irregular) <= 4) {
											foreach ($waktu_irregular as $key => $val) {
												if ($key == 0) {
													$kolom_end = 221;
													$kolom_start = $key;
												}else {
													if ($key == 2) {
														$plus_kolom = 5;
													}elseif ($key == 3) {
														$plus_kolom = 10;
													}else {
														$plus_kolom = 0;
													}
													$kolom_end = 226 + ((10* $key) + $plus_kolom);
													$kolom_start = 15 * $key;
												}
												$writer->markMergedCell($sheet1, $start_row= $rowjum+3, $start_col= 211 + $kolom_start, $end_row=$rowjum+3, $end_col=$kolom_end);
		                    $writer->markMergedCell($sheet1, $start_row= $rowjum+4, $start_col= 211 + $kolom_start, $end_row=$rowjum+4, $end_col=$kolom_end);

												$writer->markMergedCell($sheet1, $start_row= $rowjum+3, $start_col= $kolom_end+1, $end_row=$rowjum+4, $end_col=$kolom_end+4);
											}
										}else {
											$writer->markMergedCell($sheet1, $start_row= $rowjum+3, $start_col= 211, $end_row=$rowjum+4, $end_col= 272);
										}

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+5, $start_col= 206, $end_row=$rowjum+5, $end_col= 210);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+5, $start_col= 211, $end_row=$rowjum+5, $end_col= 229);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+5, $start_col= 230, $end_row=$rowjum+5, $end_col= 259);


                // 4
                    $writer->markMergedCell($sheet1, $start_row= $rowjum, $start_col= 279, $end_row=$rowjum, $end_col= 361);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 279, $end_row=$rowjum+2, $end_col= 293);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 294, $end_row=$rowjum+2, $end_col= 298);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 299, $end_row=$rowjum+1, $end_col= 361);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+2, $start_col= 299, $end_row=$rowjum+2, $end_col= 361);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+3, $start_col= 294, $end_row=$rowjum+4, $end_col= 298);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+3, $start_col= 299, $end_row=$rowjum+3, $end_col= 361);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+4, $start_col= 299, $end_row=$rowjum+4, $end_col= 361);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+5, $start_col= 294, $end_row=$rowjum+5, $end_col= 298);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+5, $start_col= 299, $end_row=$rowjum+5, $end_col= 318);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+5, $start_col= 319, $end_row=$rowjum+5, $end_col= 333);

                // USULAN
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+11, $start_col= 18, $end_row=$rowjum+11, $end_col= 107);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+12, $start_col= 20, $end_row=$rowjum+13, $end_col= 360);


        //ROW HEADER IRREGULAR JOB & Footer kanan
            $rowheadirreg = $rowjum+6;
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg, $start_col= 0, $end_row=$rowheadirreg+2, $end_col= 0);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg, $start_col= 1, $end_row=$rowheadirreg+2, $end_col= 8);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg, $start_col= 9, $end_row=$rowheadirreg+1, $end_col= 9);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg, $start_col= 10, $end_row=$rowheadirreg+1, $end_col= 10);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg, $start_col= 11, $end_row=$rowheadirreg+1, $end_col= 11);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+2, $start_col= 10, $end_row=$rowheadirreg+2, $end_col= 11);

            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+9, $start_col= 14, $end_row=$rowheadirreg+9, $end_col= 32);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+9, $start_col= 33, $end_row=$rowheadirreg+11, $end_col= 51);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+9, $start_col= 52, $end_row=$rowheadirreg+9, $end_col= 70);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+9, $start_col= 71, $end_row=$rowheadirreg+11, $end_col= 89);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+9, $start_col= 90, $end_row=$rowheadirreg+9, $end_col= 189);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+9, $start_col= 190, $end_row=$rowheadirreg+10, $end_col= 215);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+9, $start_col= 216, $end_row=$rowheadirreg+10, $end_col= 242);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+9, $start_col= 243, $end_row=$rowheadirreg+9, $end_col= 272);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+9, $start_col= 273, $end_row=$rowheadirreg+9, $end_col= 302);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+9, $start_col= 303, $end_row=$rowheadirreg+9, $end_col= 332);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+9, $start_col= 333, $end_row=$rowheadirreg+9, $end_col= 363);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+10, $start_col= 14, $end_row=$rowheadirreg+10, $end_col= 18);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+10, $start_col= 19, $end_row=$rowheadirreg+10, $end_col= 27);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+10, $start_col= 28, $end_row=$rowheadirreg+10, $end_col= 32);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+10, $start_col= 52, $end_row=$rowheadirreg+10, $end_col= 56);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+10, $start_col= 57, $end_row=$rowheadirreg+10, $end_col= 65);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+10, $start_col= 66, $end_row=$rowheadirreg+10, $end_col= 70);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+10, $start_col= 90, $end_row=$rowheadirreg+10, $end_col= 98);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+10, $start_col= 99, $end_row=$rowheadirreg+10, $end_col= 189);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+10, $start_col= 243, $end_row=$rowheadirreg+10, $end_col= 272);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+10, $start_col= 273, $end_row=$rowheadirreg+10, $end_col= 302);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+10, $start_col= 303, $end_row=$rowheadirreg+10, $end_col= 332);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+10, $start_col= 333, $end_row=$rowheadirreg+10, $end_col= 363);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+11, $start_col= 14, $end_row=$rowheadirreg+11, $end_col= 32);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+11, $start_col= 52, $end_row=$rowheadirreg+11, $end_col= 70);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+11, $start_col= 90, $end_row=$rowheadirreg+11, $end_col= 98);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+11, $start_col= 99, $end_row=$rowheadirreg+11, $end_col= 189);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+11, $start_col= 190, $end_row=$rowheadirreg+11, $end_col= 215);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+11, $start_col= 216, $end_row=$rowheadirreg+11, $end_col= 242);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+11, $start_col= 243, $end_row=$rowheadirreg+14, $end_col= 272);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+11, $start_col= 273, $end_row=$rowheadirreg+14, $end_col= 302);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+11, $start_col= 303, $end_row=$rowheadirreg+14, $end_col= 332);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+11, $start_col= 333, $end_row=$rowheadirreg+14, $end_col= 363);

            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+12, $start_col= 14, $end_row=$rowheadirreg+12, $end_col= 32);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+12, $start_col= 33, $end_row=$rowheadirreg+14, $end_col= 51);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+12, $start_col= 52, $end_row=$rowheadirreg+12, $end_col= 58);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+12, $start_col= 59, $end_row=$rowheadirreg+12, $end_col= 63);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+12, $start_col= 64, $end_row=$rowheadirreg+12, $end_col= 70);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+12, $start_col= 71, $end_row=$rowheadirreg+14, $end_col= 89);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+12, $start_col= 90, $end_row=$rowheadirreg+12, $end_col= 98);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+12, $start_col= 99, $end_row=$rowheadirreg+12, $end_col= 189);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+12, $start_col= 190, $end_row=$rowheadirreg+12, $end_col= 215);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+12, $start_col= 216, $end_row=$rowheadirreg+12, $end_col= 242);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+13, $start_col= 14, $end_row=$rowheadirreg+13, $end_col= 18);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+13, $start_col= 19, $end_row=$rowheadirreg+13, $end_col= 27);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+13, $start_col= 28, $end_row=$rowheadirreg+13, $end_col= 32);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+13, $start_col= 52, $end_row=$rowheadirreg+13, $end_col= 58);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+13, $start_col= 59, $end_row=$rowheadirreg+13, $end_col= 63);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+13, $start_col= 64, $end_row=$rowheadirreg+13, $end_col= 70);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+13, $start_col= 90, $end_row=$rowheadirreg+13, $end_col= 98);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+13, $start_col= 99, $end_row=$rowheadirreg+13, $end_col= 189);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+13, $start_col= 190, $end_row=$rowheadirreg+13, $end_col= 215);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+13, $start_col= 216, $end_row=$rowheadirreg+13, $end_col= 242);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+14, $start_col= 14, $end_row=$rowheadirreg+14, $end_col= 32);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+14, $start_col= 52, $end_row=$rowheadirreg+14, $end_col= 58);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+14, $start_col= 59, $end_row=$rowheadirreg+14, $end_col= 63);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+14, $start_col= 64, $end_row=$rowheadirreg+14, $end_col= 70);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+14, $start_col= 90, $end_row=$rowheadirreg+14, $end_col= 98);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+14, $start_col= 99, $end_row=$rowheadirreg+14, $end_col= 189);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+14, $start_col= 190, $end_row=$rowheadirreg+14, $end_col= 215);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+14, $start_col= 216, $end_row=$rowheadirreg+14, $end_col= 242);

            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+15, $start_col= 14, $end_row=$rowheadirreg+15, $end_col= 32);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+15, $start_col= 33, $end_row=$rowheadirreg+17, $end_col= 51);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+15, $start_col= 52, $end_row=$rowheadirreg+15, $end_col= 70);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+15, $start_col= 71, $end_row=$rowheadirreg+17, $end_col= 89);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+15, $start_col= 90, $end_row=$rowheadirreg+15, $end_col= 98);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+15, $start_col= 99, $end_row=$rowheadirreg+15, $end_col= 189);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+15, $start_col= 190, $end_row=$rowheadirreg+15, $end_col= 215);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+15, $start_col= 216, $end_row=$rowheadirreg+15, $end_col= 242);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+15, $start_col= 243, $end_row=$rowheadirreg+16, $end_col= 272);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+15, $start_col= 273, $end_row=$rowheadirreg+16, $end_col= 302);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+15, $start_col= 303, $end_row=$rowheadirreg+16, $end_col= 332);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+15, $start_col= 333, $end_row=$rowheadirreg+16, $end_col= 363);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+16, $start_col= 14, $end_row=$rowheadirreg+16, $end_col= 18);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+16, $start_col= 19, $end_row=$rowheadirreg+16, $end_col= 27);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+16, $start_col= 28, $end_row=$rowheadirreg+16, $end_col= 32);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+16, $start_col= 52, $end_row=$rowheadirreg+16, $end_col= 56);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+16, $start_col= 57, $end_row=$rowheadirreg+16, $end_col= 65);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+16, $start_col= 66, $end_row=$rowheadirreg+16, $end_col= 70);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+16, $start_col= 90, $end_row=$rowheadirreg+16, $end_col= 98);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+16, $start_col= 99, $end_row=$rowheadirreg+16, $end_col= 189);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+16, $start_col= 190, $end_row=$rowheadirreg+16, $end_col= 215);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+16, $start_col= 216, $end_row=$rowheadirreg+16, $end_col= 242);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+17, $start_col= 14, $end_row=$rowheadirreg+17, $end_col= 32);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+17, $start_col= 52, $end_row=$rowheadirreg+17, $end_col= 70);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+17, $start_col= 90, $end_row=$rowheadirreg+17, $end_col= 98);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+17, $start_colForm= 99, $end_row=$rowheadirreg+17, $end_col= 189);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+17, $start_col= 190, $end_row=$rowheadirreg+17, $end_col= 215);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+17, $start_col= 216, $end_row=$rowheadirreg+17, $end_col= 242);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+17, $start_col= 243, $end_row=$rowheadirreg+17, $end_col= 272);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+17, $start_col= 273, $end_row=$rowheadirreg+17, $end_col= 302);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+17, $start_col= 303, $end_row=$rowheadirreg+17, $end_col= 332);
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+17, $start_col= 333, $end_row=$rowheadirreg+17, $end_col= 363);

        //ROW LIST IRREGULAR JOB
            $irreg = $rowheadirreg+3;
            for ($j=0; $j < $irg; $j++) {
                $brs = $irreg + ($j*2);
                $writer->markMergedCell($sheet1, $start_row= $brs, $start_col= 0, $end_row=$brs+1, $end_col= 0);
                $writer->markMergedCell($sheet1, $start_row= $brs, $start_col= 1, $end_row=$brs+1, $end_col= 8);
                $writer->markMergedCell($sheet1, $start_row= $brs, $start_col= 9, $end_row=$brs+1, $end_col= 9);
                $writer->markMergedCell($sheet1, $start_row= $brs, $start_col= 10, $end_row=$brs+1, $end_col= 10);
                $writer->markMergedCell($sheet1, $start_row= $brs, $start_col= 11, $end_row=$brs+1, $end_col= 11);
            }
        //ROW JUMLAH IRREGULAR
            $jmlRowIrreg = $irreg + ($irg * 2);
            $writer->markMergedCell($sheet1, $start_row= $jmlRowIrreg, $start_col= 0, $end_row=$jmlRowIrreg+4, $end_col= 10);
            $writer->markMergedCell($sheet1, $start_row= $jmlRowIrreg, $start_col= 11, $end_row=$jmlRowIrreg+4, $end_col= 11);


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


/////LUTFI END
}

}

?>
