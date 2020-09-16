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

    // echo "<pre>";print_r($data['lihat_irregular_jobs']);die;

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
    $rencana_produksi   = $this->input->post('txtRencanaProduksi');
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

public function exportExcel(){
    // echo "<pre>"; print_r($_POST); exit();
    set_include_path( get_include_path().PATH_SEPARATOR."..");
    include_once("xlsxwriter.class.php");
     //HEADER
    // echo "<pre>"; print_r($_POST);exit(); 
    $judul            = $this->input->post('judul');
    //PART
    $type             = $this->input->post('type');
    $kode_part        = $this->input->post('kode_part');
    $nama_part        = $this->input->post('nama_part');
    //EQUIPMENT
    $no_mesin         = $this->input->post('no_mesin');
    $nm = explode("; ", trim($no_mesin));
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
    $last_finish      = end($finish);  
    // echo "<pre>"; echo $last_finish;die;
    $waktu            = $this->input->post('waktu');

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
    $waktu_satu_shift   = $this->input->post('waktu_satu_shift');
    $jumlah_shift       = $this->input->post('jumlah_shift');
    $forecast           = $this->input->post('forecast');
    $qty_unit           = $this->input->post('qty_unit');
    $rencana_produksi   = $this->input->post('rencana_kerja');
    $jumlah_hari_kerja  = $this->input->post('jumlah_hari_kerja');

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
        $irregular_jobs         = $this->input->post('irregular_job');
        $ratio_irregular        = $this->input->post('ratio_ij');
        $waktu_irregular        = $this->input->post('waktu_ij');
        $hasil_irregular        = $this->input->post('hasil_ij');
        $jumlah_hasil_irregular = array_sum($hasil_irregular);
    // echo $hasil_irregular;die;

    //checking the length based on cycle time too
        $cycle_time = $last_finish + $jumlah_hasil_irregular + $takt_time;
        $cycle_time_tanpa_irregular = $last_finish + $takt_time;
        $cycleTimeText = $cycle_time + 3;
        // echo"<pre>"; echo $cycle_time;
        // echo"<pre>"; echo "KAGA";

    if ($cycle_time < 450) {
        $end = 450;
    } else {
        // echo $jumlah; exit();
        $g = (int)($cycle_time / 10);
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
        $totalrow = 14 + (sizeof($elemen_kerja)*3) + 8 + $brsIrregular + 6;
        for ($j=0; $j < $totalrow; $j++) { 
            for ($i=0; $i < ($indexAngka + $end); $i++) { 
                $rows[$j][$i] = '';
                $styles[$j][$i] = '';
            }
        }
        
    
    //STYLING CARA BARU
        $row = 14;
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
            for ($j=0; $j <= (($irg*2)+12); $j++) { 
                $baris = $rJum + $j;
                for ($i=0; $i <= 364; $i++) {
                    switch ($j) {
                        case 0:
                            if ($i === 0 || $i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 9) {
                                $styles[$baris][$i]['border']='left,right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 10 || $i === 109 || $i === 186 || $i === 274) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
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
                            } elseif ($i >= 132 && $i <= 184 || $i >= 211 && $i <= 272 || $i >= 299 && $i <= 361) {
                                $styles[$baris][$i]['border']='bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 2:
                            if ($i === 0 || $i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i >= 134 && $i <= 182) {
                                $styles[$baris][$i]['border']='bottom';
                                $styles[$baris][$i]['border-style']='thin';
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
                            } elseif ($i >= 211 && $i <= 272 || $i >= 299 && $i <= 361) {
                                $styles[$baris][$i]['border']='bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 109 || $i === 186 || $i === 274) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
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
                                $styles[$baris][$i]['border']='bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 10 || $i === 109 || $i === 186 || $i === 274) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 13) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            } 
                            break;
                        case 5:
                            if ($i === 0 || $i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 1) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thin';
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
                            } elseif ($i >= 134 && $i <= 182) {
                                $styles[$baris][$i]['border']='bottom';
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
                                $styles[$baris][$i]['border']='left,bottom,right';
                                $styles[$baris][$i]['border-style']='thin';
                            } elseif ($i === 10 || $i === 11) {
                                $styles[$baris][$i]['border']='bottom';
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
                            } elseif ($i > 89 && $i < 364) {
                                $styles[$baris][$i]['border']='bottom';
                                $styles[$baris][$i]['border-style']='thin';
                            }
                            break;
                        case 21:
                            if ($i === 13 || $i === 89 || $i === 242) {
                                $styles[$baris][$i]['border']='right';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 12 || $i === 364) {
                                $styles[$baris][$i]['border']='left';
                                $styles[$baris][$i]['border-style']='thick';
                            } elseif ($i === 32 || $i === 51 || $i === 70 || $i === 272 || $i === 302 || $i === 332) {
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
                        case 22:
                            if ($i > 11 && $i < 364) {
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

        // STYLING IRREGULAR JOB
            $brsIrreg = $rJum + 7;
            $penanda = 0;
            for ($j=0; $j < ($irg*2); $j++) { 
                $brsPake = $brsIrreg + $j;
                for ($i=0; $i < 12; $i++) { 
                    switch ($i) {
                        case 0:
                            if ($penanda === 1 && $j === (($irg*2)-1)) {
                                $styles[$brsPake][$i]['border']='top,left,bottom';
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
                            if ($i === 0) {
                                $styles[$barisnya][$i]['border']='left';
                                $styles[$barisnya][$i]['border-style']='thick';
                            } elseif ($i === 11) {
                                $styles[$barisnya][$i]['border']='left,top';
                                $styles[$barisnya][$i]['border-style']='thin';
                            } else {
                                $styles[$barisnya][$i]['border']='top';
                                $styles[$barisnya][$i]['border-style']='thin';
                            }
                            
                            break;
                        case 5:
                            $styles[$barisnya][$i]['border']='top';
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
            $rows[1][255] = ''; //DATA JML MESIN
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
            $rows[4][255] = ''; //DATA No. Mesin
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
            $rows[7][255] = ''; //DATA Alat Bantu
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
            $rows[$rowJumlahElemen+1][191] = 'Kali / Shift';
            
            $rows[$rowJumlahElemen+1][206] = ' = ';
            $rows[$rowJumlahElemen+1][211] = 'Cycle Time (Tanpa Irregular Job)';
            $rows[$rowJumlahElemen+1][279] = 'Pcs / Shift';
            
            $rows[$rowJumlahElemen+1][294] = ' = ';
            $rows[$rowJumlahElemen+1][299] = 'Waktu 1 Shift x Quantity';

            $rows[$rowJumlahElemen+2][20] = '- Cycletime (Tanpa Irregular Job)';
            $rows[$rowJumlahElemen+2][73] = ' = ';
            $rows[$rowJumlahElemen+2][78] = $cycle_time_tanpa_irregular; //DATA Cycletime (Tanpa Irregular Job)
            $rows[$rowJumlahElemen+2][94] = 'Detik';
            $rows[$rowJumlahElemen+2][132] = '(';
            $rows[$rowJumlahElemen+2][134] = 'Rencana Produksi / Bulan';
            $rows[$rowJumlahElemen+2][183] = ')';
            $rows[$rowJumlahElemen+2][211] = 'Ratio Irregular Job';
            $rows[$rowJumlahElemen+2][299] = 'Cycle Time (Dengan Irregular Job)';
            
            

            $rows[$rowJumlahElemen+3][20] = '- Cycletime (Dengan Irregular Job)';
            $rows[$rowJumlahElemen+3][73] = ' = ';
            $rows[$rowJumlahElemen+3][78] = $cycle_time; //DATA Cycletime (Dengan Irregular Job)
            $rows[$rowJumlahElemen+3][94] = 'Detik';
            $rows[$rowJumlahElemen+3][134] = 'Jumlah Hari Kerja / Bulan';
            $rows[$rowJumlahElemen+3][206] = ' = ';
            $rows[$rowJumlahElemen+3][211] = $cycle_time_tanpa_irregular; //DATA Cycle Time tanpa Irregular
            $rows[$rowJumlahElemen+3][294] = ' = ';
            $rows[$rowJumlahElemen+3][299] = $waktu_satu_shift.' x '.$qty_unit; //DATA Waktu 1 Shift x Qty
            
            
            $rows[$rowJumlahElemen+4][20] = '- Jumlah Hari Kerja / Bulan';
            $rows[$rowJumlahElemen+4][73] = ' = ';
            $rows[$rowJumlahElemen+4][78] = $jumlah_hari_kerja; //DATA Jumlah Hari Kerja / Bulan
            $rows[$rowJumlahElemen+4][94] = 'Detik';
            $rows[$rowJumlahElemen+4][127] = ' = ';
            $rows[$rowJumlahElemen+4][132] = ''; //Data Waktu 1 Shift
            $rows[$rowJumlahElemen+4][211] = ''; //DATA Ratio Irregular Job
            $rows[$rowJumlahElemen+4][299] = $cycle_time; //DATA Cycle Time (Dengan Irregular Job)
            
            
            $rows[$rowJumlahElemen+5][20] = '- Rencana Produksi / Bulan';
            $rows[$rowJumlahElemen+5][73] = ' = ';
            $rows[$rowJumlahElemen+5][78] = $rencana_produksi; //Data Rencana Produksi / Bulan
            $rows[$rowJumlahElemen+5][94] = 'Detik';
            $rows[$rowJumlahElemen+5][132] = '(';
            $rows[$rowJumlahElemen+5][134] = $rencana_produksi; //Data Rencana Produksi / Bulan
            $rows[$rowJumlahElemen+5][183] = ')';
            $rows[$rowJumlahElemen+5][206] = ' = ';
            $rows[$rowJumlahElemen+5][211] = ''; //DATA HASIL 3
            $rows[$rowJumlahElemen+5][230] = 'Kali / Shift';
            $rows[$rowJumlahElemen+5][294] = ' = ';
            $rows[$rowJumlahElemen+5][299] = ''; //DATA HASIL 4
            $rows[$rowJumlahElemen+5][319] = 'Pcs';
            


            $rows[$rowJumlahElemen+6][20] = '- Takt Time';
            $rows[$rowJumlahElemen+6][73] = ' = ';
            $rows[$rowJumlahElemen+6][78] = $takt_time; //DATA Takt Time
            $rows[$rowJumlahElemen+6][94] = 'Detik';
            


            $rows[$rowJumlahElemen+7][20] = '- Qty dalam 1 cycle';
            $rows[$rowJumlahElemen+7][73] = ' = ';
            $rows[$rowJumlahElemen+7][78] = $qty; //DATA Qty dalam 1 Cycle
            $rows[$rowJumlahElemen+7][94] = 'Detik';
            $rows[$rowJumlahElemen+7][127] = ' = ';
            $rows[$rowJumlahElemen+7][132] = ''; //Data HASIL 1
            $rows[$rowJumlahElemen+7][147] = 'Detik';
            
            
            $rows[$rowJumlahElemen+9][18] = '5. Usulan Perbaikan'; 

            $rows[$rowJumlahElemen][114] = '2. Perhitungan Taktime';
            $rows[$rowJumlahElemen][191] = '3. Ratio Irregular Job';
            $rows[$rowJumlahElemen][279] = '4. Jumlah Pcs yang dihasilkan dalam 1 shift';
            $rows[$rowJumlahElemen+2][9] = $jumlah;


            for ($j=0; $j < 10; $j++) { 
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
                                $styles[$barisnya][$i]['halign'] = 'center';
                            } elseif ($i === 73 || $i === 127 || $i === 132 || $i === 206 || $i === 211 || $i === 294 || $i === 299) {
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
                            if ($i === 9 || $i === 73 || $i === 132 || $i === 134 || $i === 183 || $i === 211 || $i === 299) {
                                $styles[$barisnya][$i]['halign'] = 'center';
                            } else {
                                $styles[$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        case 3:
                            $styles[$barisnya][$i]['font-size'] = 8;
                            $styles[$barisnya][$i]['valign'] = 'center';
                            if ($i === 73 || $i === 134 || $i === 211 || $i === 206 || $i ===294 || $i === 299) {
                                $styles[$barisnya][$i]['halign'] = 'center';
                            } else {
                                $styles[$barisnya][$i]['halign'] = 'left';
                            }
                            break;
                        case 4:
                            $styles[$barisnya][$i]['font-size'] = 8;
                            $styles[$barisnya][$i]['valign'] = 'center';
                            if ($i === 73 || $i === 127 || $i === 132 || $i === 211 || $i === 299) {
                                $styles[$barisnya][$i]['halign'] = 'center';
                            } else {
                                $styles[$barisnya][$i]['halign'] = 'left';
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
                            # code...
                            break;
                        case 9:
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
            $rows[$rowJumlahElemen+4][0] = 'No';
            $rows[$rowJumlahElemen+4][1] = 'Irregular Job';
            $rows[$rowJumlahElemen+4][9] = 'Ratio';
            $rows[$rowJumlahElemen+4][10] = 'Waktu';
            $rows[$rowJumlahElemen+4][11] = 'Ratio / Waktu';
            $rows[$rowJumlahElemen+6][9] = 'Kali';
            $rows[$rowJumlahElemen+6][10] = 'Detik';
            
            $styles[$rowJumlahElemen+4][0]['font-size'] = 10;
            $styles[$rowJumlahElemen+4][0]['valign'] = 'center';
            $styles[$rowJumlahElemen+4][0]['halign'] = 'center';
            $styles[$rowJumlahElemen+4][1]['font-size'] = 10;
            $styles[$rowJumlahElemen+4][1]['valign'] = 'center';
            $styles[$rowJumlahElemen+4][1]['halign'] = 'left';
            $styles[$rowJumlahElemen+4][9]['font-size'] = 10;
            $styles[$rowJumlahElemen+4][9]['valign'] = 'center';
            $styles[$rowJumlahElemen+4][9]['halign'] = 'center';
            $styles[$rowJumlahElemen+4][10]['font-size'] = 10;
            $styles[$rowJumlahElemen+4][10]['valign'] = 'center';
            $styles[$rowJumlahElemen+4][10]['halign'] = 'center';
            $styles[$rowJumlahElemen+4][11]['font-size'] = 10;
            $styles[$rowJumlahElemen+4][11]['valign'] = 'center';
            $styles[$rowJumlahElemen+4][11]['halign'] = 'center';
            $styles[$rowJumlahElemen+4][11]['wrap_text'] = true;

            $styles[$rowJumlahElemen+6][9]['font-size'] = 10;
            $styles[$rowJumlahElemen+6][9]['valign'] = 'center';
            $styles[$rowJumlahElemen+6][9]['halign'] = 'center';
            $styles[$rowJumlahElemen+6][10]['font-size'] = 10;
            $styles[$rowJumlahElemen+6][10]['valign'] = 'center';
            $styles[$rowJumlahElemen+6][10]['halign'] = 'center';

        // DATA FOOTER KANAN
            $rowFootKanan = $rowJumlahElemen+13;
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

            $rows[$rowFootKanan+9][243] = 'Form No. : FRM-PDE-03-21 (Rev. 00-26/03/2020)';

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
            $rowDataIrregular = $rowJumlahElemen+5;
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
            $rows[$pakeRowIrregular + ($rowIrregular*2)][0] = 'JUMLAH';
            $styles[$pakeRowIrregular + ($rowIrregular*2)][0]['font-size'] = 10;
            $styles[$pakeRowIrregular + ($rowIrregular*2)][0]['valign'] = 'center';
            $styles[$pakeRowIrregular + ($rowIrregular*2)][0]['halign'] = 'center';
            $rows[$pakeRowIrregular + ($rowIrregular*2)][11] = $jumlah_hasil_irregular;
            $styles[$pakeRowIrregular + ($rowIrregular*2)][11]['font-size'] = 10;
            $styles[$pakeRowIrregular + ($rowIrregular*2)][11]['valign'] = 'center';
            $styles[$pakeRowIrregular + ($rowIrregular*2)][11]['halign'] = 'center';

    
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
                    $styles[$rowflow][$takt_time + 13]['fill'] = '#fc0303';
                    $styles[$rowflow+1][$takt_time + 13]['fill'] = '#fc0303';
                    $styles[$rowflow+2][$takt_time + 13]['fill'] = '#fc0303';
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
        $rows[$rownya + 13][$takt_time + 14] = 'Takt Time = '.$takt_time.' Detik';
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
                $writer->markMergedCell($sheet1, $start_row= $rowjum, $start_col= 0, $end_row=$rowjum+2, $end_col= 8);
                $writer->markMergedCell($sheet1, $start_row= $rowjum, $start_col= 9, $end_row=$rowjum+1, $end_col= 9);
                $writer->markMergedCell($sheet1, $start_row= $rowjum, $start_col= 10, $end_row=$rowjum+1, $end_col= 10);
                $writer->markMergedCell($sheet1, $start_row= $rowjum, $start_col= 11, $end_row=$rowjum+1, $end_col= 11);
                $writer->markMergedCell($sheet1, $start_row= $rowjum+2, $start_col= 9, $end_row=$rowjum+2, $end_col= 11);
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

                // 3
                    $writer->markMergedCell($sheet1, $start_row= $rowjum, $start_col= 191, $end_row=$rowjum, $end_col= 272);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 191, $end_row=$rowjum+2, $end_col= 205);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 206, $end_row=$rowjum+2, $end_col= 210);
                    
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+1, $start_col= 211, $end_row=$rowjum+1, $end_col= 272);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+2, $start_col= 211, $end_row=$rowjum+2, $end_col= 272);

                    $writer->markMergedCell($sheet1, $start_row= $rowjum+3, $start_col= 206, $end_row=$rowjum+4, $end_col= 210);
                    
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+3, $start_col= 211, $end_row=$rowjum+3, $end_col= 272);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+4, $start_col= 211, $end_row=$rowjum+4, $end_col= 272);

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
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+9, $start_col= 18, $end_row=$rowjum+9, $end_col= 107);
                    $writer->markMergedCell($sheet1, $start_row= $rowjum+10, $start_col= 20, $end_row=$rowjum+11, $end_col= 360);


        //ROW HEADER IRREGULAR JOB & Footer kanan
            $rowheadirreg = $rowjum+4;
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
            $writer->markMergedCell($sheet1, $start_row= $rowheadirreg+17, $start_col= 99, $end_row=$rowheadirreg+17, $end_col= 189);
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

    $arr = array(
        'url' =>    $filename
    );
    echo json_encode($arr);
    // header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
    // $writer->writeToStdOut();
/////LUTFI END 
}

public function exportExcelOld(){

    $this->load->library(array('Excel','Excel/PHPExcel/IOFactory')); 

    //HEADER
    // echo "<pre>"; print_r($_POST);exit(); 
    $judul            = $this->input->post('judul');
    //PART
    $type 	          = $this->input->post('type');
    $kode_part 	      = $this->input->post('kode_part');
    $nama_part 	      = $this->input->post('nama_part');
    //EQUIPMENT
    $no_mesin	      = $this->input->post('no_mesin');
    $nm = explode("; ", trim($no_mesin));
    $jenis_mesin      = $this->input->post('jenis_mesin');
    $resource         = $this->input->post('resource');
    $line             = $this->input->post('line');
    $alat_bantu	      = $this->input->post('alat_bantu');
    $ab = explode("; ", $alat_bantu);
    $tools            = $this->input->post('tools');
    $tl = explode("; ", $tools);
    //SDM
    $operator	      = $this->input->post('nama');
    $a = explode(" - ", $operator);
    $nama_operator = $a[0];
    $no_induk = $a[1];
    $jml_operator     = $this->input->post('jumlah_operator');
    $dr_operator      = $this->input->post('dari_operator');
    $seksi 	          = $this->input->post('seksi');
    //PROCESS
    $proses 	      = $this->input->post('proses');
    $kode_proses      = $this->input->post('kode_proses');
    $proses_ke 	      = $this->input->post('proses_ke');
    $qty 	          = $this->input->post('qty');
    $dari 	          = $this->input->post('dari');
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
    $jenis_proses 	  = $this->input->post('jenis_proses_elemen');
    $elemen           = $this->input->post('elemen_kerja');
    $keterangan_elemen= $this->input->post('keterangan_elemen_kerja');
    $tipe_urutan 	  = $this->input->post('tipe_urutan_elemen');
    $start 	          = $this->input->post('mulai');
    $finish 	      = $this->input->post('finish');
    $last_finish      = end($finish);  
    // echo "<pre>"; echo $last_finish;die;
    $waktu 	          = $this->input->post('waktu');

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
                    'jenis_proses'  	=> $jenis_proses[$i],
                    'elemen' 	        => $elemen[$i],
                    'keterangan_elemen' => $keterangan_elemen[$i],
                    'tipe_urutan'   	=> $tipe_urutan[$i],
                    'mulai' 	        => $start[$i],
                    'finish' 	        => $finish[$i],
                    'waktu' 	        => $waktu[$i],
                    'muda'              => $start[$i] - $finish[$i-1],
                    'id_tskk'       	=> $id_tskk
                );
            }else {
                $data = array(
                    'jenis_proses'  	=> $jenis_proses[$i],
                    'elemen' 	        => $elemen[$i],
                    'keterangan_elemen' => $keterangan_elemen[$i],
                    'tipe_urutan'   	=> $tipe_urutan[$i],
                    'mulai' 	        => $start[$i],
                    'finish' 	        => $finish[$i],
                    'waktu' 	        => $waktu[$i],
                    'muda'              => 1,
                    'id_tskk'       	=> $id_tskk
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
                    'jenis_proses'  	=> $jenis_proses[$i],
                    'elemen' 	        => $elemen[$i],
                    'keterangan_elemen' => $keterangan_elemen[$i],
                    'tipe_urutan'   	=> $tipe_urutan[$i],
                    'mulai' 	        => $start[$i],
                    'finish' 	        => $finish[$i],
                    'waktu' 	        => $waktu[$i],
                    'muda'              => $start[$i] - $finish[$i-1],
                    'id_tskk'       	=> $id_tskk
                );
            }else {
                $data = array(
                    'jenis_proses'  	=> $jenis_proses[$i],
                    'elemen' 	        => $elemen[$i],
                    'keterangan_elemen' => $keterangan_elemen[$i],
                    'tipe_urutan'   	=> $tipe_urutan[$i],
                    'mulai' 	        => $start[$i],
                    'finish' 	        => $finish[$i],
                    'waktu' 	        => $waktu[$i],
                    'muda'              => 1,
                    'id_tskk'       	=> $id_tskk
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
    $waktu_satu_shift   = $this->input->post('waktu_satu_shift');
    $jumlah_shift       = $this->input->post('jumlah_shift');
    $forecast           = $this->input->post('forecast');
    $qty_unit           = $this->input->post('qty_unit');
    $rencana_produksi   = $this->input->post('rencana_kerja');
    $jumlah_hari_kerja  = $this->input->post('jumlah_hari_kerja');

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
    
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("ICT_Production")->setTitle("ICT");
  
    $objset = $objPHPExcel->setActiveSheetIndex(0);
    $objget = $objPHPExcel->getActiveSheet();
    $objget->setTitle("TSKK_Shackle");
  
    // ------- SET COLUMN ---------
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(1);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(1);

      $indexSatu=18;
      $indexDua=18;
    
      //set pembulatan dengan mengisi angka
    if ($jumlah < 370) {
        $end = 370;
    } else {
        // echo $jumlah; exit();
        $g = (int)($jumlah / 10);
        $g += 1;
        $end = $g * 10;
        // echo "g = $g <br>jml = $jumlah <br>".$end;
    }
    
    //IRREGULAR JOBS
    $irregular_jobs         = $this->input->post('irregular_job');
    $ratio_irregular        = $this->input->post('ratio_ij');
    $waktu_irregular        = $this->input->post('waktu_ij');
    $hasil_irregular        = $this->input->post('hasil_ij');
    $jumlah_hasil_irregular = array_sum($hasil_irregular);
    // echo $hasil_irregular;die;

    //checking the length based on cycle time too
        $cycle_time = $last_finish + $jumlah_hasil_irregular + $takt_time;
        $cycleTimeText = $cycle_time + 3;
        // echo"<pre>"; echo $cycle_time;
        // echo"<pre>"; echo "KAGA";

    if ($cycle_time < 370) {
        $end = 370;
    } else {
        // echo $jumlah; exit();
        $g = (int)($cycle_time / 10);
        $g += 1;
        $end = $g * 10;
        // echo "g = $g <br>jml = $jumlah <br>".$end;
    }

    //checking the length in relation with takt time
    // if ($takt_time < 370) {
    //     $end = 370;
    // } else {
    //     // echo $jumlah; exit();
    //     $g = (int)($takt_time / 10);
    //     $g += 1;
    //     $end = $g * 10;
    //     // echo "g = $g <br>jml = $jumlah <br>".$end;
    // }

    //MERGING DETIK//
    $indexAngka = 18;
    $indexStart = 1;
    $kolomA   = $this->Kolom($indexAngka);
    $kolomB   = $this->Kolom($indexAngka + $end);
    $kolomJDL = $this->Kolom($indexStart);

    // $objPHPExcel->getActiveSheet()->mergeCells('A1'.':'.($indexJml + 2));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomJDL.'1:'.$kolomB.'1');
        $objget->getStyle($kolomJDL.'1:'.$kolomB.'1')->applyFromArray(
            array(
                'font' => array(
                'bold' => true
                )
            )
        );
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolomJDL.'1', $judul." | ".$nama_pekerja." (".$noind.") : ".$generateDate);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomA.'15:'.$kolomB.'15');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolomA.'15', 'Detik');
    $objPHPExcel->getActiveSheet()->getStyle($kolomJDL.'1')->getFont()->setSize(13);


    $objget->getStyle($kolomA.'15:'.$kolomB.'15')->applyFromArray(
        array(
                'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
            )
        );  

    $objget->getStyle($kolomJDL.'1:'.$kolomB.'1')->applyFromArray(
        array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
            )
        );  

      $val = 0;
      $kolomEnd = $this->Kolom($end + 18);

        //STYLING HORIZONTAL ROWS//
        $objget->getStyle('K8:'.$kolomEnd.(17))->applyFromArray(
            array(
                'borders' => array(
                'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
            )
        );  
        //STYLING HORIZONTAL ROWS//

    for ($i=0; $i < $end + 1 ; $i++) { 
          $col1 = $this->Kolom($indexSatu);
          $col2 = $this->Kolom($indexDua);
          
          if ($i % 10 == 0) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col1.'16',$val);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($col1.'16:'.$col2.'16');
                
                //STYLING THE LINE OF TIME FLOW//PANJANGNYA KE BAWAH//PANJANG UJUNG KE BAWAH
                $objget->getStyle($col1.'16:'.$col2.(($jml_baris * 3) + 20))->applyFromArray(
                    array(
                        'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    )
                );
                //BELUM TENTU
                $objget->getStyle($col1.'16:'.$col2.'16')->applyFromArray(
                    array(
                        'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );

                $objget->getStyle($col1.'17:'.$col2.'17')->applyFromArray(
                    array(
                        'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );

                //STYLING THE VERTICLE LINE OF TIME FLOW//

                $indexSatu = $indexDua + 1;
                $val += 10;
        }

        //URUTAN ANGKA//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col2.'17', $i);
        $objPHPExcel->getActiveSheet()->getColumnDimension($col2)->setWidth(0.58);

        $objget->getStyle($col2.'17')->applyFromArray(
            array(
                'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'ff8b26') //orange
                    )
                )
            );

            $indexDua++;
        $objPHPExcel->getActiveSheet()->getColumnDimension($col2)->setWidth(0.58);
    }

            //KELIPATAN 10//
            $indexAngka = 19;
            $indexKelipatan = 10;
       
            for ($angka=19; $angka < $jumlah+1; $angka++) { 

                $kolomA = $this->Kolom($indexAngka);
                $kolomB = $this->Kolom($indexAngka + 9);

                $indexAngka += 10;
                $indexKelipatan +=10;
              
                    if ($indexAngka + 10 > ($jumlah) + 20) { //set the maximum 
                        break;
                    }
            }    
            
    //GIVE BOLD BORDER FOR TIME FLOW HEADER 

    // $objget->getStyle($col2.'17')->applyFromArray(
    //     array(
    //         'fill' => array(
    //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
    //         'color' => array('rgb' => 'ff8b26') //orange
    //             )
    //         )
    //     );

    $objget->getStyle('R15:'.$kolomEnd.'17')->applyFromArray(
        array(
                'borders' => array(
                'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            )
        ); 
    
    //ADD IMAGE QUICK FOR HEADER//

    $gdImage = imagecreatefrompng('assets/img/logo.png');
    // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
    $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
    $objDrawing->setName('Logo QUICK');$objDrawing->setDescription('Logo QUICK');
    $objDrawing->setImageResource($gdImage);
    $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
    $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
    $objDrawing->setCoordinates('A4');
    //set width, height
    $objDrawing->setWidth(120); //ASW
    $objDrawing->setHeight(135); 
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 
    
// MERGING TO SET THE PAGE HEADER//
$objPHPExcel->getActiveSheet()->mergeCells('A2:C12');   //LOGO 
$objPHPExcel->getActiveSheet()->mergeCells('D2:H3');    //CV KHS
$objPHPExcel->getActiveSheet()->mergeCells('D4:H5');    //YOGYAKARTA
$objPHPExcel->getActiveSheet()->mergeCells('D6:H10');   //KOSONG
$objPHPExcel->getActiveSheet()->mergeCells('D11:H12');  //DEPARTEMEN
$objPHPExcel->getActiveSheet()->mergeCells('I2:P4');    //SEKSI
$objPHPExcel->getActiveSheet()->mergeCells('I5:P12');   //TSKK 

//TABEL HEADER OF ELEMENTS
$objPHPExcel->getActiveSheet()->mergeCells('A15:A17'); //NO
$objPHPExcel->getActiveSheet()->mergeCells('B15:M17'); //ELEMEN KERJA
$objPHPExcel->getActiveSheet()->mergeCells('N15:N17'); //MANUAL
$objPHPExcel->getActiveSheet()->mergeCells('O15:O17'); //AUTO
$objPHPExcel->getActiveSheet()->mergeCells('P15:P17'); //WALK

$objPHPExcel->getActiveSheet()->mergeCells('S2:DF2');  //KETERANGAN
$objPHPExcel->getActiveSheet()->mergeCells('V4:AL4');  //kotak item
$objPHPExcel->getActiveSheet()->mergeCells('AP3:BL5'); //Manual
$objPHPExcel->getActiveSheet()->mergeCells('BP4:CF4'); //kotak kuning
$objPHPExcel->getActiveSheet()->mergeCells('CJ3:DF5'); //cycle time

$objPHPExcel->getActiveSheet()->mergeCells('V7:AL7');  //kotak ijo
$objPHPExcel->getActiveSheet()->mergeCells('AP6:BL8'); //TULISAN Auto (Mesin)
$objPHPExcel->getActiveSheet()->mergeCells('BW6:BY8'); //merah (TAKT TIME)
$objPHPExcel->getActiveSheet()->mergeCells('CJ6:DF8'); //takt time

$objPHPExcel->getActiveSheet()->mergeCells('V10:AL10');  //KOTAK WALK BIRU
$objPHPExcel->getActiveSheet()->mergeCells('AP9:BL11'); //jalan
$objPHPExcel->getActiveSheet()->mergeCells('BP10:CF10'); //panah merah A.K.A muda
$objPHPExcel->getActiveSheet()->mergeCells('CJ9:DF11'); //muda
$objPHPExcel->getActiveSheet()->mergeCells('S12:DF12');  //KETERANGAN KOSONG

//MERGING THE LEFT ROW
$objPHPExcel->getActiveSheet()->mergeCells('S3:AO3'); 
$objPHPExcel->getActiveSheet()->mergeCells('S4:U4'); 
$objPHPExcel->getActiveSheet()->mergeCells('AM4:AO4'); 
$objPHPExcel->getActiveSheet()->mergeCells('S5:AO5'); 
$objPHPExcel->getActiveSheet()->mergeCells('S6:AO6'); 
$objPHPExcel->getActiveSheet()->mergeCells('S7:U7'); 
$objPHPExcel->getActiveSheet()->mergeCells('AM7:AO7'); 
$objPHPExcel->getActiveSheet()->mergeCells('S8:AO8'); 
$objPHPExcel->getActiveSheet()->mergeCells('S9:AO9'); 
$objPHPExcel->getActiveSheet()->mergeCells('S10:U10'); 
$objPHPExcel->getActiveSheet()->mergeCells('AM10:AO10'); 
$objPHPExcel->getActiveSheet()->mergeCells('S11:AO11'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM3:CI3'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM4:BO4'); 
$objPHPExcel->getActiveSheet()->mergeCells('CG4:CI4'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM5:CI5'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM6:CI6'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM7:BV7'); 
$objPHPExcel->getActiveSheet()->mergeCells('BZ7:CI7'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM8:CI8'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM9:CI9'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM10:BO10'); 
$objPHPExcel->getActiveSheet()->mergeCells('CG10:CI10'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM11:CI11'); 

//REVISI
$objPHPExcel->getActiveSheet()->mergeCells('DG2:FJ2'); //revisi 
$objPHPExcel->getActiveSheet()->mergeCells('DG3:DN3'); //no.
$objPHPExcel->getActiveSheet()->mergeCells('DG4:DN4'); //no1.
$objPHPExcel->getActiveSheet()->mergeCells('DG5:DN5'); //no2.
$objPHPExcel->getActiveSheet()->mergeCells('DG6:DN6'); //no3.
$objPHPExcel->getActiveSheet()->mergeCells('DG7:DN7'); //no4.
$objPHPExcel->getActiveSheet()->mergeCells('DG8:DN8'); //no5.
$objPHPExcel->getActiveSheet()->mergeCells('DG9:DN9'); //no6.
$objPHPExcel->getActiveSheet()->mergeCells('DG10:DN10'); //no7.
$objPHPExcel->getActiveSheet()->mergeCells('DG11:DN11'); //no8.
$objPHPExcel->getActiveSheet()->mergeCells('DG12:DN12'); //no9.
$objPHPExcel->getActiveSheet()->mergeCells('DO3:FJ3'); //detail
$objPHPExcel->getActiveSheet()->mergeCells('DO4:FJ4'); //no1.
$objPHPExcel->getActiveSheet()->mergeCells('DO5:FJ5'); //no2.
$objPHPExcel->getActiveSheet()->mergeCells('DO6:FJ6'); //no3.
$objPHPExcel->getActiveSheet()->mergeCells('DO7:FJ7'); //no4.
$objPHPExcel->getActiveSheet()->mergeCells('DO8:FJ8'); //no5.
$objPHPExcel->getActiveSheet()->mergeCells('DO9:FJ9'); //no6.
$objPHPExcel->getActiveSheet()->mergeCells('DO10:FJ10'); //no7.
$objPHPExcel->getActiveSheet()->mergeCells('DO11:FJ11'); //no8.
$objPHPExcel->getActiveSheet()->mergeCells('DO12:FJ12'); //no9.

$objPHPExcel->getActiveSheet()->mergeCells('FK2:GM3'); //tanggal
$objPHPExcel->getActiveSheet()->mergeCells('FK4:GM4'); //no1.
$objPHPExcel->getActiveSheet()->mergeCells('FK5:GM5'); //no2.
$objPHPExcel->getActiveSheet()->mergeCells('FK6:GM6'); //no3.
$objPHPExcel->getActiveSheet()->mergeCells('FK7:GM7'); //no4.
$objPHPExcel->getActiveSheet()->mergeCells('FK8:GM8'); //no5.
$objPHPExcel->getActiveSheet()->mergeCells('FK9:GM9'); //no6.
$objPHPExcel->getActiveSheet()->mergeCells('FK10:GM10'); //no7.
$objPHPExcel->getActiveSheet()->mergeCells('FK11:GM11'); //no8.
$objPHPExcel->getActiveSheet()->mergeCells('FK12:GM12'); //no9.

$objPHPExcel->getActiveSheet()->mergeCells('GN2:IA2'); //PART
$objPHPExcel->getActiveSheet()->mergeCells('GN3:IA3'); //TYPE PRODUK
$objPHPExcel->getActiveSheet()->mergeCells('GN4:IA5'); //ISI TYPE PRODUK
$objPHPExcel->getActiveSheet()->mergeCells('GN6:IA6'); //NAMA PART
$objPHPExcel->getActiveSheet()->mergeCells('GN7:IA8'); //ISI NAMA PART
$objPHPExcel->getActiveSheet()->mergeCells('GN9:IA9'); //KODE PART
$objPHPExcel->getActiveSheet()->mergeCells('GN10:IA10'); //ISI KODE PART
$objPHPExcel->getActiveSheet()->mergeCells('GN11:IA11'); //TANGGAL OBSERVASI
$objPHPExcel->getActiveSheet()->mergeCells('GN12:IA12'); //ISI TANGGAL OBSERVASI

$objPHPExcel->getActiveSheet()->mergeCells('IB2:JL2'); //SDM
$objPHPExcel->getActiveSheet()->mergeCells('IB3:JL3'); //NAMA
$objPHPExcel->getActiveSheet()->mergeCells('IB4:JL4'); //ISI NAMA
$objPHPExcel->getActiveSheet()->mergeCells('IB5:JL5'); //NO INDUK
$objPHPExcel->getActiveSheet()->mergeCells('IB6:JL6'); //ISI NO INDUK
$objPHPExcel->getActiveSheet()->mergeCells('IB7:JL7'); //SEKSI
$objPHPExcel->getActiveSheet()->mergeCells('IB8:JL8'); //ISI SEKSI
$objPHPExcel->getActiveSheet()->mergeCells('IB9:JL9'); //JUMLAH OPERATOR...DARI...
$objPHPExcel->getActiveSheet()->mergeCells('IB10:JL12'); //ISI JUMLAH OPERATOR...DARI...

$objPHPExcel->getActiveSheet()->mergeCells('JM2:KV2'); //EQUIPMENT
$objPHPExcel->getActiveSheet()->mergeCells('JM3:KV3'); //No. mesin
$objPHPExcel->getActiveSheet()->mergeCells('JM4:KD4'); //1.
$objPHPExcel->getActiveSheet()->mergeCells('JM5:KD5'); //2.
$objPHPExcel->getActiveSheet()->mergeCells('JM6:KD6'); //3.
$objPHPExcel->getActiveSheet()->mergeCells('KE4:KV4'); //4.
$objPHPExcel->getActiveSheet()->mergeCells('KE5:KV5'); //5.
$objPHPExcel->getActiveSheet()->mergeCells('KE6:KV6'); //6.
$objPHPExcel->getActiveSheet()->mergeCells('JM7:KV7'); //jenis mesin
$objPHPExcel->getActiveSheet()->mergeCells('JM8:KV8'); //isi jenis mesin
$objPHPExcel->getActiveSheet()->mergeCells('JM9:KV9'); //Resource
$objPHPExcel->getActiveSheet()->mergeCells('JM10:KV10'); //isi Resource
$objPHPExcel->getActiveSheet()->mergeCells('JM11:KV11'); //line
$objPHPExcel->getActiveSheet()->mergeCells('JM12:KV12'); //isi line

$objPHPExcel->getActiveSheet()->mergeCells('KW2:MK2'); //PROCESS
$objPHPExcel->getActiveSheet()->mergeCells('KW3:MK3'); //Proses
$objPHPExcel->getActiveSheet()->mergeCells('KW4:MK4'); //ISI Proses
$objPHPExcel->getActiveSheet()->mergeCells('KW5:MK5'); //Kode Proses
$objPHPExcel->getActiveSheet()->mergeCells('KW6:MK6'); //ISI Kode Proses
$objPHPExcel->getActiveSheet()->mergeCells('KW7:MK7'); //Proses ke ... dari ...
$objPHPExcel->getActiveSheet()->mergeCells('KW8:MK8'); //ISI Proses ke ... dari ...
$objPHPExcel->getActiveSheet()->mergeCells('KW9:MK9'); //Qty/Process
$objPHPExcel->getActiveSheet()->mergeCells('KW10:MK10'); //ISI Qty/Process
$objPHPExcel->getActiveSheet()->mergeCells('KW11:MK11'); //TAKT TIME
$objPHPExcel->getActiveSheet()->mergeCells('KW12:MK12'); //ISI TAKT TIME

$objPHPExcel->getActiveSheet()->mergeCells('ML2:NX2'); //TOOLS
$objPHPExcel->getActiveSheet()->mergeCells('ML3:NX3'); //Tools
$objPHPExcel->getActiveSheet()->mergeCells('ML4:NX4'); //1
$objPHPExcel->getActiveSheet()->mergeCells('ML5:NX5'); //2
$objPHPExcel->getActiveSheet()->mergeCells('ML6:NX6'); //3
$objPHPExcel->getActiveSheet()->mergeCells('ML7:NX7'); //4
$objPHPExcel->getActiveSheet()->mergeCells('ML8:NX8'); //5
$objPHPExcel->getActiveSheet()->mergeCells('ML9:NX9'); //6
$objPHPExcel->getActiveSheet()->mergeCells('ML10:NX10'); //7
$objPHPExcel->getActiveSheet()->mergeCells('ML11:NX11'); //
$objPHPExcel->getActiveSheet()->mergeCells('ML12:NX12'); //

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('I2', $seksi_pembuat)
            ->setCellValue('D2', 'CV KARYA HIDUP SENTOSA')
            ->setCellValue('D4', 'YOGYAKARTA')
            ->setCellValue('D11', 'DEPARTEMEN '.$dept_pembuat)
            // ->setCellValue('A7', 'Jl. Magelang No. 144 Yogyakarta 55241')
            ->setCellValue('I5', 'TABEL STANDAR KERJA KOMBINASI')

            ->setCellValue('S2', 'KETERANGAN')
            ->setCellValue('AP3', 'Manual')
            ->setCellValue('AP6', 'Auto (Mesin)')
            ->setCellValue('AP9', 'Jalan')
            ->setCellValue('CJ3', 'Cycle Time')
            ->setCellValue('CJ6', 'Takt Time')
            ->setCellValue('CJ9', 'Muda')

            ->setCellValue('A15', 'NO')
            ->setCellValue('B15', 'ELEMEN KERJA')

            ->setCellValue('N15', 'MANUAL')
            ->setCellValue('O15', 'AUTO')
            ->setCellValue('P15', 'WALK')

            ->setCellValue('DG2', 'Revisi')
            ->setCellValue('DG3', 'No.')
            ->setCellValue('DO3', 'Detail')
            ->setCellValue('FK2', 'Tanggal')

            //PART GROUPING
            ->setCellValue('GN2', 'PART')
            ->setCellValue('GN3', '  Type Produk')
            ->setCellValue('GN4', $type)
            ->setCellValue('GN6', '  Nama Part')
            ->setCellValue('GN7', $nama_part)
            ->setCellValue('GN9', '  Kode Part')
            ->setCellValue('GN10', $kode_part)
            ->setCellValue('GN11', '  Tanggal Observasi')
            ->setCellValue('GN12', $tanggal)

            //PART SDM
            ->setCellValue('IB2', 'SDM')
            ->setCellValue('IB3', '  Nama')
            ->setCellValue('IB4', $nama_operator) //isinya nama doang
            ->setCellValue('IB5', '  No. Induk')
            ->setCellValue('IB6', $no_induk) //isinya noind doang
            ->setCellValue('IB7', '  Seksi')
            ->setCellValue('IB8', $seksi)
            ->setCellValue('IB9', '  Jumlah operator ... dari ...')
            ->setCellValue('IB10', $jml_operator." dari ".$dr_operator)
            
            //PART EQUIPMENT
            ->setCellValue('JM2', 'EQUIPMENT')
            ->setCellValue('JM3', '  No. Mesin')
            ->setCellValue('JM7', '  Jenis Mesin')
            ->setCellValue('JM8', $jenis_mesin)
            ->setCellValue('JM9', '  Resource')
            ->setCellValue('JM10', $resource)
            ->setCellValue('JM11', '  Line')
            ->setCellValue('JM12', $line)

            //PART PROCESS
            ->setCellValue('KW2', 'PROCESS')
            ->setCellValue('KW3', '  Proses')
            ->setCellValue('KW4', $proses) //isinya nama doang
            ->setCellValue('KW5', '  Kode Proses')
            ->setCellValue('KW6', $kode_proses) //isinya noind doang
            ->setCellValue('KW7', '  Proses ke ... dari ...')
            ->setCellValue('KW8', $proses_ke." dari ".$dari)
            ->setCellValue('KW9', '  Qty/Process')
            ->setCellValue('KW10', $qty)
            ->setCellValue('KW11', '  Takt Time')
            ->setCellValue('KW12', $takt_time." Detik")
            
            //PART TOOLS
            ->setCellValue('ML2', 'TOOLS')
            ->setCellValue('ML3', '  Tools')
            ->setCellValue('ML9', '  Alat Bantu')

            ->setCellValue('U1', '');;

//STYLING TABLE HEADER OF THE CONTENT//
            $objPHPExcel->getActiveSheet()->getStyle("D2:H12")->getFont()->setSize(15);

            //PART GROUP
            $objget->getStyle('GN2:IA2')->applyFromArray(
                array(
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                    'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );
            //ALL BORDERS FOR PART GROUPING
            $objget->getStyle('GN3:IA12')->applyFromArray(
                array(
                    'font' => array(
                        'color' => array('000000'),
                        'bold' => false,
                    )
                )
            );
            //SETTING CENTER ALLIGNMENT FOR PART
            //ISI TYPE PRODUK
            $objget->getStyle('GN4:IA5')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('GN4:IA5')->getAlignment()->setWrapText(true);

            //ISI NAMA PART
            $objget->getStyle('GN7:IA8')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('GN7:IA8')->getAlignment()->setWrapText(true);

            //KODE PART
            $objget->getStyle('GN9:IA9')->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );
            //ISI KODE PART
            $objget->getStyle('GN10:IA10')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('GN10:IA10')->getAlignment()->setWrapText(true);

            //TANGGAL OBSERVASI
            $objget->getStyle('GN11:IA11')->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );
            //ISI TANGGAL OBSERVASI
            $objget->getStyle('GN12:IA12')->applyFromArray(
                array(
                    // 'borders' => array(
                    // 'allborders' => array(
                    //     'style' => PHPExcel_Style_Border::BORDER_THIN
                    //     )
                    // ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                        'font' => array(
                        'color' => array('000000'),
                        'bold' => true,
                        ),
                    )
                );     
                
            //SDM GROUPING GAN//
            $objget->getStyle('IB2:JL2')->applyFromArray(
                array(
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                    'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );
            //ALL BORDERS FOR PART GROUPING
            // $objget->getStyle('IB3:JL12')->applyFromArray(
            //     array(
            //             'borders' => array(
            //             'allborders' => array(
            //                 'style' => PHPExcel_Style_Border::BORDER_THIN
            //             ),
            //             'font' => array(
            //             'color' => array('000000'),
            //             'bold' => true,
            //             ),
            //         )
            //     )
            // );
            //SETTING CENTER ALLIGNMENT FOR PART
            //ISI NAMA
            $objget->getStyle('IB4:JL4')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('IB4:JL4')->getAlignment()->setWrapText(true);

            //ISI NOIND
            $objget->getStyle('IB6:JL6')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('IB6:JL6')->getAlignment()->setWrapText(true);

            //ISI SEKSI
            $objget->getStyle('IB8:JL8')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('IB8:JL8')->getAlignment()->setWrapText(true);
            $objget->getStyle('IB9:JL9')->getAlignment()->setWrapText(true);

            //ISI JUMLAH OPERATOR...DARI...
            $objget->getStyle('IB10:JL12')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                        'font' => array(
                        'color' => array('000000'),
                        'bold' => true,
                        ),
                    )
                );  
            $objget->getStyle('IB10:JL12')->getAlignment()->setWrapText(true);

            //EQUIPMENT GROUPING
            $objget->getStyle('JM2:KV2')->applyFromArray(
                array(
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                    'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );
            //ALL BORDERS FOR EQUIPMENT GROUPING
            // $objget->getStyle('JM3:KV12')->applyFromArray(
            //     array(
            //             'borders' => array(
            //             'allborders' => array(
            //                 'style' => PHPExcel_Style_Border::BORDER_THIN
            //             ),
            //         )
            //     )
            // );
            //SETTING CENTER ALLIGNMENT FOR PART
            //ISI No. mesin
            $objget->getStyle('JM4:KV6')->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'color' => array('000000'),
                        'bold' => true,
                    ),
                )
            );
            $objget->getStyle('JM4:KV6')->getAlignment()->setWrapText(true);

            //styling heading resource
            $objget->getStyle('JM7:KV7')->applyFromArray(
                array(
                    'borders' => array(
                    'top' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
            );

            //ISI Resource
            $objget->getStyle('JM8:KV8')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('JM8:KV8')->getAlignment()->setWrapText(true);
            
            $objget->getStyle('JM10:KV10')->applyFromArray(
                array(
                    'borders' => array(
                        'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'font' => array(
                        'color'=> array('000000'),
                        'bold' => true,
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );
            $objget->getStyle('JM10:KV10')->getAlignment()->setWrapText(true);

            $objget->getStyle('JM11:KV11')->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );   
            
            $objget->getStyle('JM12:KV12')->applyFromArray(
                array(
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );
            $objget->getStyle('JM11:KV11')->getAlignment()->setWrapText(true);

            $objget->getStyle('JM9:KV9')->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );   

            //CREATE LOOPING NO. MESIN //nds

            $no=1;    
            for ($i= 4; $i < 10; $i++) { 
                $nmr_msn = $i-4;
                if ($nmr_msn < count($nm)) {
                    if ($nmr_msn < 3) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('JM'.$i, " ".$no.'.'.$nm[$nmr_msn]);
                    }else{
                        $j = $i-3;
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('KE'.$j, " ".$no.'.'.$nm[$nmr_msn]);
                    }
                }else{
                    if ($nmr_msn < 3) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('JM'.$i, '  -');
                    }else{
                        $j = $i-3;
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('KE'.$i, '  -');                    
                    }
                }
                $no++;
            }
            // die;     

            //CREATE LOOPING ALAT BANTU //nds
            $no=1;    
            for ($i= 10; $i < 13; $i++) { 
                $nmr_msn = $i-10;
                if ($nmr_msn < count($ab)) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('ML'.$i, " ".$no.'.'.$ab[$nmr_msn]);
                }else{
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('ML'.$i, '  -');
                }
                $no++;
            }

            //CREATE LOOPING TOOLS //nds
            $no=1;    
            for ($i= 4; $i < 9; $i++) { 
                $nmr_msn = $i-4;
                if ($nmr_msn < count($ab)) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('ML'.$i, " ".$no.'.'.$tl[$nmr_msn]);
                }else{
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('ML'.$i, '  -');
                }
                $no++;
            }

            //PROCESS GROUPING//
            $objget->getStyle('KW2:MK2')->applyFromArray(
                array(
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                    'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );
            //ALL BORDERS FOR PROCESS GROUPING
            $objget->getStyle('KW3:MK12')->applyFromArray(
                array(
                        // 'borders' => array(
                        // 'allborders' => array(
                        //     'style' => PHPExcel_Style_Border::BORDER_THIN
                        // ),
                        'font' => array(
                        'color' => array('000000'),
                        'bold' => false,
                        ),
                    )
                );
            //SETTING CENTER ALLIGNMENT FOR PART
            //ISI Proses
            $objget->getStyle('KW4:MK4')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('KW4:MK4')->getAlignment()->setWrapText(true);

            //ISI Kode Proses
            $objget->getStyle('KW6:MK6')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('KW6:MK6')->getAlignment()->setWrapText(true);

            //ISI  Proses ke ... dari ...
            $objget->getStyle('KW8:MK8')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('KW8:MK8')->getAlignment()->setWrapText(true);
            $objget->getStyle('KW7:MK7')->getAlignment()->setWrapText(true);

            //ISI Qty/Process
            $objget->getStyle('KW10:MK10')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                        'font' => array(
                        'color' => array('000000'),
                        'bold' => true,
                        ),
                    )
                );  
            $objget->getStyle('KW10:MK10')->getAlignment()->setWrapText(true);

            $objget->getStyle('KW9:MK9')->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );  

            $objget->getStyle('KW11:MK11')->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );  

            $objget->getStyle('KW12:MK12')->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'color' => array('000000'),
                        'bold' => true,
                    ),
                )
            );  

            //TOOLS GROUPING 
            //ALL BORDERS FOR TOOLS
            $objget->getStyle('ML2:NX12')->applyFromArray(
                array(
                    // 'borders' => array(
                    //     'allborders' => array(
                    //         'style' => PHPExcel_Style_Border::BORDER_THIN
                    //     )
                    // ),
                    'font' => array(
                        'color' => array('000000'),
                        'bold' => true,
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );

            $objget->getStyle('ML2:NX2')->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                    )
                );

            $objget->getStyle('ML9:NX9')->applyFromArray(
                array(
                    'borders' => array(
                        'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'font' => array(
                        'color' => array('000000'),
                        'bold' => false,
                    )
                )
            );

            $objget->getStyle('ML3:NX3')->applyFromArray(
                array(
                    'font' => array(
                        'color' => array('000000'),
                        'bold' => false,
                    )
                )
            );

            //SPECIAL FOR MEDIUM BORDER THICKNESS THEAD ELEMENTS TABLE
            $objget->getStyle('A15:A17')->applyFromArray(
                array(
                    'font' => array(
                    'color'=> array('000000'),
                    'bold' => true,
                    ),
                    'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                    ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                    )
                );

            $objget->getStyle('B15:M17')->applyFromArray(
                array(
                    'font' => array(
                    'color'=> array('000000'),
                    'bold' => true,
                    ),
                    'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                    ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                    )
                );
                    
            $objget->getStyle('N15:N17')->applyFromArray(
                array(
                    'font' => array(
                    'color' => array('rgb' => 'ffffff'),
                    'bold' => true,
                    ),
                    'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '000000')
                    )
                )
            );

            $objget->getStyle('O15:O17')->applyFromArray(
                array(
                    'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                            )
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '00ff00')
                        )
                    )
                );

                $objget->getStyle('O15:O17')->applyFromArray(
                    array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                                )   
                            )
                        )
                    );

            $objget->getStyle('P15:P17')->applyFromArray(
                array(
                    'font' => array(
                    'color' => array('rgb' => '000000'),
                    'bold' => true,
                    ),
                    'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '33ffff')
                        )
                    )
                );

//STYLING TABLE INFORMATIONS//
            $objget->getStyle('A2:P12')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                            )
                        ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
            );       
                //OVER HERE DUDE
            $objget->getStyle('A2:C12')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                            )
                        ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                );
                
            $objget->getStyle('I2:P4')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'fill' => array( 
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'fcf403')
                        ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                            )
                        ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                );  

            $objget->getStyle('D2:H12')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                            )
                        ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                );  
            
            //font sizing tulisan TSKK
            $objPHPExcel->getActiveSheet()->getStyle("I2:P4")->getFont()->setSize(16);
            $objPHPExcel->getActiveSheet()->getStyle("I5:P12")->getFont()->setSize(22);
            $objPHPExcel->getActiveSheet()->getStyle("B15:M17")->getFont()->setSize(17); 

            //KOTAK KETERANGAN
            $objget->getStyle('S2:DF11')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => false,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'wraptext' => true
                            )
                        )
                ); 

                $objget->getStyle('S2:DF2')->applyFromArray(
                    array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                        ),
                        'fill' => array( 
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'a69bfa')
                        )
                    )
                ); 

                $objget->getStyle('DG3:FJ3')->applyFromArray( 
                    array(
                        'fill' => array( 
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'a69bfa')
                        )
                    )
                ); 

                $objget->getStyle('DG2:FN3')->applyFromArray(
                    array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                        ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                    );    
                    
                $objget->getStyle('DG2:FJ2')->applyFromArray(
                    array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                        ),
                        'fill' => array( 
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'a69bfa')
                        )
                    )
                ); 
            
            // //TANGGAL REVISI
            $objget->getStyle('FK2:GM3')->applyFromArray(
                array(
                        'font' => array(
                            'color' => array('rgb' => '000000'),
                            'bold' => true,
                        ),
                        'fill' => array( 
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'a69bfa')
                        ),
                        'borders' => array(
                            'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                        )
                )
            ); 

            $objget->getStyle('GN2:NX2')->applyFromArray(
                array(
                    'font' => array(
                    'color' => array('rgb' => '000000'),
                    'bold' => true,
                    ),
                    'fill' => array( 
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'a69bfa')
                    )
                )
            );             

            $objget->getStyle('FK4:GM12')->applyFromArray(
                array(
                    'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
            ); 

            // //MANUAL, AUTO, JALAN, CT, TT, MUDA
            $objget->getStyle('S3:BL5')->applyFromArray( 
                array(
                        'borders' => array(
                            'outline' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'font' => array(
                            'color' => array('rgb' => '000000'),
                            'bold' => false,
                        )
                    )
                ); 
            
            //KOTAK ITEM
            $objget->getStyle('V4:AL4')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '000000')
                        )
                    )
                ); 

            // $objget->getStyle('AP3:BL5')->applyFromArray(
            //     array(
            //             'borders' => array(
            //             'outline' => array(
            //             'style' => PHPExcel_Style_Border::BORDER_THIN
            //                 )
            //             )
            //         )
            //     ); 

            $objget->getStyle('BM3:DF5')->applyFromArray( 
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 
             
            //KOTAK KUNING
            $objget->getStyle('BP4:CF4')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'fcf403')
                        )
                    )
                ); 

            //KOTAK IJO
            $objget->getStyle('V7:AL7')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '00ff00')
                        )
                    )
                ); 
            
            $objget->getStyle('AP6:BL8')->getAlignment()->setWrapText(true);

            
                //KOTAK MUDA (MERAH)
                $objget->getStyle('BP10:CF10')->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'fa3eef')
                            )
                        )
                    ); 

                //KOTAK TAKT TIME (MERAH)
                $objget->getStyle('BW6:BY8')->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'fc0303')
                            )
                        )
                    ); 

                //KOTAK BIRU WALK
                $objget->getStyle('V10:AL10')->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '33ffff')
                            )
                        )
                    ); 

            // $objget->getStyle('CJ3:DF5')->applyFromArray(
            //     array(
            //             'borders' => array(
            //             'outline' => array(
            //             'style' => PHPExcel_Style_Border::BORDER_THIN
            //                 )
            //             )
            //         )
            //     ); 

            $objget->getStyle('S6:BL8')->applyFromArray( 
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            // $objget->getStyle('AP6:BL8')->applyFromArray(
            //     array(
            //             'borders' => array(
            //             'outline' => array(
            //             'style' => PHPExcel_Style_Border::BORDER_THIN
            //                 )
            //             )
            //         )
            //     ); 

            $objget->getStyle('BM6:DF8')->applyFromArray( 
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                );   
            
            //KOTAK KETERANGAN TAKT TIME
            // $objget->getStyle('CJ6:DF8')->applyFromArray(
            //     array(
            //             'borders' => array(
            //             'outline' => array(
            //             'style' => PHPExcel_Style_Border::BORDER_THIN
            //                 )
            //             )
            //         )
            //     );  

            //KK 
            $objget->getStyle('S9:BL11')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            // $objget->getStyle('AP9:BL11')->applyFromArray(
            //     array(
            //             'borders' => array(
            //             'outline' => array(
            //             'style' => PHPExcel_Style_Border::BORDER_THIN
            //                 )
            //             )
            //         )
            //     ); 

            $objget->getStyle('BM9:DF11')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 
                
            // $objget->getStyle('CJ9:DF11')->applyFromArray(
            //     array(
            //             'borders' => array(
            //             'outline' => array(
            //             'style' => PHPExcel_Style_Border::BORDER_THIN
            //                 )
            //             )
            //         )
            //     ); 

                $objget->getStyle('S12:DF12')->applyFromArray(
                    array(
                            'borders' => array(
                            'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        )
                    ); 
            //THE END OF KOTAK KETERANGAN//
            
            //KOTAK REVISI
            $objget->getStyle('DG2:FN2')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            $objget->getStyle('DG3:FN12')->applyFromArray(
                array(
                        'borders' => array(
                        'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

        //GIVE BOLD BORDER IN KETERANGAN - TOOLS OUTLINE
        $objget->getStyle('S2:DF12')->applyFromArray( //KETERANGAN
            array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )   
                    )
                )
            );

        $objget->getStyle('DG2:GM12')->applyFromArray( //REVISI - TANGGAL
            array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )   
                    )
                )
            );

        $objget->getStyle('GN2:IA12')->applyFromArray( //PART
            array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )   
                    )
                )
            );

        $objget->getStyle('IB2:JL12')->applyFromArray( //SDM
            array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )   
                    )
                )
            );

        $objget->getStyle('JM2:KV12')->applyFromArray( //EQUIPMENT
            array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )   
                    )
                )
            );

        $objget->getStyle('KW2:MK12')->applyFromArray( //PROCESS
            array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )   
                    )
                )
            );

        $objget->getStyle('ML2:NX12')->applyFromArray( //PROCESS
            array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )   
                    )
                )
            );

        $objPHPExcel->getActiveSheet()->getStyle("S2:NX12")->getFont()->setSize(12);


    //SET TAKT TIME ROWS//
    $kolomMerah = $this->Kolom($takt_time + 18);
    $tulisanTaktTime = $this->Kolom($takt_time + 21);
    $objget->getStyle($kolomMerah.'18:'.$kolomMerah.(($jml_baris * 3) + 20))->applyFromArray(
                array(
                    'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'eb4034')
                    )
                )
            );
    //tulisan takt time
    $objset->setCellValue($tulisanTaktTime.'31', "Takt Time = ".$takt_time." Detik");
    $objget->getStyle($tulisanTaktTime.'31')->applyFromArray(
        array(
            'font' => array(
                'color' => array('000000'),
                'bold' => true,
            ),
            // 'fill' => array(
            //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //     'color' => array('rgb' => 'eb4034')
            // )
        )
    );
    //SET TAKT TIME ROWS

    //BOLDING ALL THE TIME FLOW TABLE 
    $objget->getStyle('R15:'.$kolomEnd.(($jml_baris * 3) + 20))->applyFromArray(
        array(
                'borders' => array(
                'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            )
        ); 


    //SET THE VALUE OF TABLE CONTENT//
    $no = 1;
    $indexArr = 0;
    $defElementKerja = '';
    $indexElementKerja = 18; //TITIK MULAI HORIZONTAL DARI ROW KE 18
    $indexHitam = 19;  //TITIK VERTIKAL DIMULAI DARI DETIK KE-1
    $indexHijau = 0;
    $nLine = false;

    for ($i=18; $i < (18 + (sizeof($elemen_kerja) * 3)); $i+=3) { 
   
            $j = $jenis_proses[$indexArr];
            $tu = $tipe_urutan[$indexArr];
            $s = $start[$indexArr];
            $indexParalel = $s + 11;

                //STYLING
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexElementKerja.':A'.($indexElementKerja + 2)); //NOMOR
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexElementKerja.':M'.($indexElementKerja + 2)); //ELEMEN
                $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexElementKerja.':N'.($indexElementKerja + 2)); //MANUAL    
                $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexElementKerja.':O'.($indexElementKerja + 2)); //AUTO
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexElementKerja.':P'.($indexElementKerja + 2)); //WALK

                $objget->getStyle('N'.$indexElementKerja.':P'.($indexElementKerja + 2))->applyFromArray(
                    array(
                            'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                    );  

                    $objget->getStyle('A'.$indexElementKerja.':A'.($indexElementKerja + 2))->applyFromArray(
                        array(
                                'borders' => array(
                                'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                    )
                                ),
                                'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                )
                            )
                        );  

                    $objget->getStyle('B'.$indexElementKerja.':M'.($indexElementKerja + 2))->applyFromArray(
                        array(
                                'borders' => array(
                                'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                    )
                                ),
                                'alignment' => array(
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                )
                            )
                        );  

                    $kolomEnd = $this->Kolom($end + 18);
                    $objget->getStyle('S'.($indexElementKerja + 2).':'.$kolomEnd.($indexElementKerja + 2))->applyFromArray(
                        array(
                                'borders' => array(
                                'bottom' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                    )
                                ),
                                'alignment' => array(
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                )
                            )
                        );  
    
            if ($j == 'MANUAL') {
                    if ($elemen_kerja[$indexArr] == $defElementKerja){

                        if ($tu = "PARALEL") { 
                            $objset->setCellValue("N".$indexElementKerja, $waktu[$indexArr]);
                                //TIME FLOW
                                $indexArrWaktu = 1;
                                $indexHitam = $s + 18;
                              
                                for ($angka = 0; $angka < $waktu[$indexArr]; $angka++) { 
                                    $kolom = $this->Kolom($indexHitam);
                                        if ($nLine) {

                                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);

                                            $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                                array(
                                                    'font' => array(
                                                    'color' => array('ffffff'),
                                                    'bold' => true,
                                                    ),
                                                )
                                            );
                                            //pararel //LET UNCOMMENT//
                                        // if ($angka == 0) {
                                        //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                        //         array(
                                        //             'fill' => array(
                                        //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        //             'color' => array('rgb' => 'a6a6a6')
                                        //             )
                                        //         )
                                        //     );
                                        //     //tambahin lagi di sini keknya
                                        //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                        //         array(
                                        //             'fill' => array(
                                        //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        //             'color' => array('rgb' => 'a6a6a6')
                                        //             ),
                                        //         )
                                        //     );
                                        //     //tambahin lagi di sini keknya
                                        // }
                                        //BLACK STYLING//
                                        $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                            array(
                                                'fill' => array(
                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('rgb' => '000000')
                                                ),
                                                'font' => array(
                                                'color' => array('rgb' => 'ffffff'),
                                                )
                                            )
                                        );

                                        }else{
                                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                                            $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                                array(
                                                    'font' => array(
                                                    'color' => array('ffffff'),
                                                    'bold' => true,
                                                    ),
                                                )
                                            );
                                                //pararel //LET UNCOMMENT//
                                            // if ($angka == 0) {
                                            //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                            //         array(
                                            //             'fill' => array(
                                            //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            //             'color' => array('rgb' => 'a6a6a6')
                                            //             )
                                            //         )
                                            //     );
                                            //     //tambahin lagi di sini keknya
                                            //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                            //         array(
                                            //             'fill' => array(
                                            //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            //             'color' => array('rgb' => 'a6a6a6')
                                            //             ),
                                            //         )
                                            //     );
                                            //     //tambahin lagi di sini keknya
                                            // }
                                            //BLACK STYLING//
                                            $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                                array(
                                                    'fill' => array(
                                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                    'color' => array('rgb' => '000000')
                                                    ),
                                                    'font' => array(
                                                    'color' => array('rgb' => 'ffffff'),
                                                    )
                                                )
                                            );
                                        }
                    //LET UNCOMMENT//
                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS (AT THE END)
                    // if($angka == $waktu[$indexArr] -1 && $i != (18 + ((sizeof($elemen_kerja) - 1) * 3))){
                    //     $kolomAbu = $this->Kolom($indexHitam + 1);
                    //     $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                    //                 array(
                    //                     'fill' => array(
                    //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //                     'color' => array('rgb' => 'a6a6a6')
                    //                     )
                    //                 )
                    //             );

                    //     // $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray( //gua uncomment nich buat paralel
                    //     //     array(
                    //     //         'fill' => array(
                    //     //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //     //         'color' => array('rgb' => 'a6a6a6')
                    //     //         ),
                    //     //     )
                    //     // );
                    // }
                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS (AT THE END)
    
                                $indexArrWaktu++;
                                $indexHitam++;
                                
                            //ngatur takt time
                            if ($indexHitam - 19 == $takt_time) {
                                $indexHitam = 19;
                            $nLine = true;
                            }
                            //ngatur takt time

                                } 
                                //over here gan
                                $objset->setCellValue("A".$indexElementKerja, $no++);
                                $objset->setCellValue("B".$indexElementKerja, $elemen_kerja[$indexArr]);
                                $indexArr++;
                                   
                                continue;
                        }

                        $objset->setCellValue("N".$indexElementKerja, $waktu[$indexArr]);
                        
                                //TIME FLOW
                                $indexArrWaktu = 1;
                                for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                                    $kolom = $this->Kolom($indexHitam);

                                    if ($nLine) {
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);
                                    }else{
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);
                                    }

                                $indexArrWaktu++;
                                $indexHitam++;

                        //ngatur takt time
                            if ($indexHitam - 19 == $takt_time) {
                            $indexHitam = 19;
                            $nLine = true;
                            }
                        //ngatur takt time

                                } 
                                $indexArr++;
                                continue;
                    } 

                     if ($i !== 18) {$indexElementKerja += 3;}

                //STYLING
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexElementKerja.':A'.($indexElementKerja + 2)); //NOMOR
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexElementKerja.':M'.($indexElementKerja + 2)); //ELEMEN
                $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexElementKerja.':N'.($indexElementKerja + 2)); //MANUAL    
                $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexElementKerja.':O'.($indexElementKerja + 2)); //AUTO
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexElementKerja.':P'.($indexElementKerja + 2)); //WALK

                $objget->getStyle('N'.$indexElementKerja.':P'.($indexElementKerja + 2))->applyFromArray(
                    array(
                            'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                    );  

                    $objget->getStyle('A'.$indexElementKerja.':A'.($indexElementKerja + 2))->applyFromArray(
                        array(
                                'borders' => array(
                                'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                    )
                                ),
                                'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                )
                            )
                        );  

                    $objget->getStyle('B'.$indexElementKerja.':M'.($indexElementKerja + 2))->applyFromArray(
                        array(
                                'borders' => array(
                                'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                    )
                                ),
                                'alignment' => array(
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                )
                            )
                        );  

                     if ($tu == "PARALEL") { 
                        $objset->setCellValue("N".$indexElementKerja, $waktu[$indexArr]);

                            //TIME FLOW
                            $indexArrWaktu = 1;
                            $indexArrMuda = 1;
                            $indexHitam = $s + 18; //imhere
                            $indexhitam2 = $indexHitam;

                            //SET MUDA// ---huehe
                            for ($f=0; $f < $muda[$indexArr]; $f++) { 
                                if ($finish[$indexArr-1] >= $start[$indexArr-1]) {
                                    if($muda[$indexArr] > 1){
                                            $kolomMuda = $this->Kolom($indexhitam2-$muda[$indexArr]);
                                            $objget->getStyle($kolomMuda.($indexElementKerja))->applyFromArray(
                                                        array(
                                                            'fill' => array(
                                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                            'color' => array('rgb' => 'fa3eef')
                                                            ),
                                                            'font' => array(
                                                            'color' => array('ffffff')
                                                            )
                                                        )
                                                    );
                                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolomMuda.($indexElementKerja-1), ' MUDA: '.$muda[$indexArr].' DETIK');
                                            $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray(
                                                array(
                                                    'font' => array(
                                                    'color' => array('000000'),
                                                    'bold' => true,
                                                    ),
                                                )
                                            );
                                            $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray( 
                                                array(
                                                    'fill' => array(
                                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                    'color' => array('rgb' => 'fa3eef')
                                                    ),
                                                )
                                            );         
                                    }
                                    $indexhitam2++;
                                }
                            }   
                            // die;
                            //SET MUDA//

                            for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) {                                 
                                $kolom = $this->Kolom($indexHitam);

                                if ($nLine) {
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);

                                    $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                        array(
                                            'font' => array(
                                            'color' => array('ffffff')
                                            )
                                        )
                                    );
                                    //pararel  //LET UNCOMMENT//
                                    // if ($angka == 0) {
                                    //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                    //         array(
                                    //             'fill' => array(
                                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    //             'color' => array('rgb' => 'a6a6a6')
                                    //             ),
                                    //         )
                                    //     );
                                    // }
                                    //BLACK STYLING//
                                    $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                        array(
                                            'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '000000')
                                            ),
                                            'font' => array(
                                            'color' => array('rgb' => 'ffffff')
                                            )
                                        )
                                    );
                                }else{
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                                    $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                        array(
                                            'font' => array(
                                            'color' => array('ffffff')
                                            )
                                        )
                                    );
                                    //pararel //LET UNCOMMENT//
                                    // if ($angka == 0) {
                                    //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                    //         array(
                                    //             'fill' => array(
                                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    //             'color' => array('rgb' => 'a6a6a6')
                                    //             ),
                                    //         )
                                    //     );
                                    // }
                                    //BLACK STYLING//
                                    $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                        array(
                                            'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '000000')
                                            ),
                                            'font' => array(
                                            'color' => array('rgb' => 'ffffff')
                                            )
                                        )
                                    );
                                }

                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS //LET UNCOMMENT//
                    // if($angka == $waktu[$indexArr] -1 && $i != (18 + ((sizeof($elemen_kerja) - 1) * 3))){
                    //     $kolomAbu = $this->Kolom($indexHitam + 1);
                    //     $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                    //                 array(
                    //                     'fill' => array(
                    //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //                     'color' => array('rgb' => 'a6a6a6')
                    //                     )
                    //                 )
                    //             );
                    //     $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray(
                    //         array(
                    //             'fill' => array(
                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //             'color' => array('rgb' => 'a6a6a6')
                    //             )
                    //         )
                    //     );
                    // }
                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                                
                            $indexArrWaktu++;
                            $indexHitam++;

                        //ngatur takt time
                            if ($indexHitam - 19 == $takt_time) {
                            $indexHitam = 19;
                            $nLine = true;
                            }
                        //ngatur takt time

                            } 
                            //over here gan//KEKNYA DI SINI
                            $nLine = false;

                            $objset->setCellValue("A".$indexElementKerja, $no++);
                            $objset->setCellValue("B".$indexElementKerja, $elemen_kerja[$indexArr]);
                            $indexArr++;
                               
                            continue;
                    }

                    $objset->setCellValue("N".$indexElementKerja, $waktu[$indexArr]);
                    //TIME FLOW MANUAL
                    $indexArrWaktu = 1;
                    $indexArrMuda = 1;
                    $indexHitam = $s + 18; //imhere
                    $indexhitam2 = $indexHitam;

                    //SET MUDA// ---huehe
                    for ($f=0; $f < $muda[$indexArr]; $f++) { 
                        if ($indexArr != 0) {
                            if ($finish[$indexArr-1] >= $start[$indexArr-1]) {
                                if($muda[$indexArr] > 1){
                                        $kolomMuda = $this->Kolom($indexhitam2-$muda[$indexArr]);
                                        $objget->getStyle($kolomMuda.($indexElementKerja))->applyFromArray(
                                                    array(
                                                        'fill' => array(
                                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                        'color' => array('rgb' => 'fa3eef')
                                                        ),
                                                        'font' => array(
                                                        'color' => array('ffffff')
                                                        )
                                                    )
                                                );
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolomMuda.($indexElementKerja-1), ' MUDA: '.$muda[$indexArr].' DETIK');
                                        $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray(
                                            array(
                                                'font' => array(
                                                'color' => array('000000'),
                                                'bold' => true,
                                                ),
                                            )
                                        );
                                        $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray( 
                                            array(
                                                'fill' => array(
                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('rgb' => 'fa3eef')
                                                ),
                                            )
                                        ); 
                                }
                                $indexhitam2++;
                            }
                        }
                    }   
                    // die;
                    //SET MUDA//

                    for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                            $kolom = $this->Kolom($indexHitam); 
                            if ($nLine) {
                                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);

                                //BLACK STYLING//
                                $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                    array(
                                        'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => '000000')
                                        ),
                                        'font' => array(
                                        'color' => array('rgb' => 'ffffff')
                                        )
                                    )
                                );
                            }else{
                                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                                //BLACK STYLING//
                                $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                    array(
                                        'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => '000000')
                                        ),
                                        'font' => array(
                                        'color' => array('rgb' => 'ffffff')
                                        )
                                    )
                                );
                            }
                            

                    //LET UNCOMMENT//
                    //  if ($angka == 0) {
                    //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                    //         array(
                    //             'fill' => array(
                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //             'color' => array('rgb' => 'a6a6a6')
                    //             )
                    //         )
                    //     );
                    // }
                    
                    //LET UNCOMMENT//
                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                    // if($angka == $waktu[$indexArr] - 1 && $i != (18 + ((sizeof($elemen_kerja) - 1) * 3)) ){ 
                    //     $kolomAbu = $this->Kolom($indexHitam + 1);
                    //     $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                    //                 array(
                    //                     'fill' => array(
                    //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //                     'color' => array('rgb' => 'a6a6a6')
                    //                     )
                    //                 )
                    //             );
                    //     $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray( //gua uncomment nich 
                    //         array(
                    //             'fill' => array(
                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //             'color' => array('rgb' => 'a6a6a6')
                    //             ),
                    //         )
                    //     );
                    // }elseif ($angka == 0 && $i != 18) {
                    //     $objget->getStyle($kolomAbu.($indexElementKerja ))->applyFromArray(
                    //         array(
                    //             'fill' => array(
                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //             'color' => array('rgb' => 'a6a6a6')
                    //             )
                    //         )
                    //     );
                    // }
                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS

                    $indexArrWaktu++;
                    $indexHitam++;

                        //ngatur takt time
                          if ($indexHitam - 19 == $takt_time) {
                            $indexHitam = 19;
                            $nLine = true;
                        }
                        //ngatur takt time
                    }
                    $nLine = false;
                    // echo $indexHitam;die(); 

            }elseif ($j == 'AUTO (Inheritance)') {
                    if ($elemen_kerja[$indexArr] == $defElementKerja){

                        $objset->setCellValue("O".$indexElementKerja, $waktu[$indexArr]);

                            //TIME FLOW//
                            $indexHijau = $indexHitam;
                            for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                                $kolom = $this->Kolom($indexHijau);

                                if ($nLine) {
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), ($angka + 1));

                                    //GREEN STYLING//
                                    $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                        array(
                                            'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '00ff00')
                                            )
                                        )
                                    );                                 
                                }else{
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), ($angka + 1));

                                    //GREEN STYLING//
                                    $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                        array(
                                            'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '00ff00')
                                            )
                                        )
                                    ); 
                                }

                        $indexHijau++;

                            //ngatur takt time auto
                            if ($indexHijau - 19 == $takt_time) {
                                $indexHijau = 19;
                                $nLine = true;
                            } 
                            //ngatur takt time
                        }
                        
                        $indexArr++;
                        continue;
                    } 
                    $nLine = false;

                    if ($i !== 9) {$indexElementKerja += 3;}
                    $objset->setCellValue("O".$indexElementKerja, $waktu[$indexArr]);

                        //TIME FLOW//
                        $indexHijau = $indexHitam;
                        for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                            $kolom = $this->Kolom(($indexParalel));

                        if ($nLine) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), ($angka + 1));
                        
                            //GREEN STYLING//
                            $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                array(
                                    'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '00ff00')
                                    )
                                )
                            );  
                        }else{
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), ($angka + 1));
                        
                            //GREEN STYLING//
                            $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                array(
                                    'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '00ff00')
                                    )
                                )
                            );  
                        }
                      
                        $indexParalel++;
                        } 
                        $nLine = false;
                        $indexArr++;
                        continue;
            
            }else if ($j == "AUTO") {
                //here we go again//
                if ($elemen_kerja[$indexArr] == $defElementKerja){

                    if ($tu = "PARALEL") { 
                        $objset->setCellValue("O".$indexElementKerja, $waktu[$indexArr]);
                            //TIME FLOW
                            $indexArrWaktu = 1;
                            $indexHitam = $s + 18;
                          
                            for ($angka = 0; $angka < $waktu[$indexArr]; $angka++) { 
                                $kolom = $this->Kolom($indexHitam);
                                    if ($nLine) {

                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);

                                        $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                            array(
                                                'font' => array(
                                                'color' => array('000000'),
                                                'bold' => true,
                                                ),
                                            )
                                        );
                                        //pararel //LET UNCOMMENT//
                                    // if ($angka == 0) {
                                    //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                    //         array(
                                    //             'fill' => array(
                                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    //             'color' => array('rgb' => 'a6a6a6')
                                    //             )
                                    //         )
                                    //     );
                                    //     //tambahin lagi di sini keknya
                                    //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                    //         array(
                                    //             'fill' => array(
                                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    //             'color' => array('rgb' => 'a6a6a6')
                                    //             ),
                                    //         )
                                    //     );
                                    //     //tambahin lagi di sini keknya
                                    // }
                                    //BLACK STYLING//
                                    $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                        array(
                                            'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '00ff00')
                                            ),
                                            'font' => array(
                                            'color' => array('rgb' => '000000'),
                                            )
                                        )
                                    );

                                    }else{
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                                        $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                            array(
                                                'font' => array(
                                                'color' => array('000000'),
                                                'bold' => true,
                                                ),
                                            )
                                        );
                                            //pararel //LET UNCOMMENT//
                                        // if ($angka == 0) {
                                        //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                        //         array(
                                        //             'fill' => array(
                                        //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        //             'color' => array('rgb' => 'a6a6a6')
                                        //             )
                                        //         )
                                        //     );
                                        //     //tambahin lagi di sini keknya
                                        //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                        //         array(
                                        //             'fill' => array(
                                        //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        //             'color' => array('rgb' => 'a6a6a6')
                                        //             ),
                                        //         )
                                        //     );
                                        //     //tambahin lagi di sini keknya
                                        // }
                                        //BLACK STYLING//
                                        $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                            array(
                                                'fill' => array(
                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('rgb' => '00ff00')
                                                ),
                                                'font' => array(
                                                'color' => array('rgb' => '000000'),
                                                )
                                            )
                                        );
                                    }
//LET UNCOMMENT//
                //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS (AT THE END)
                // if($angka == $waktu[$indexArr] -1 && $i != (18 + ((sizeof($elemen_kerja) - 1) * 3))){
                //     $kolomAbu = $this->Kolom($indexHitam + 1);
                //     $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                //                 array(
                //                     'fill' => array(
                //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //                     'color' => array('rgb' => 'a6a6a6')
                //                     )
                //                 )
                //             );

                //     // $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray( //gua uncomment nich buat paralel
                //     //     array(
                //     //         'fill' => array(
                //     //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //     //         'color' => array('rgb' => 'a6a6a6')
                //     //         ),
                //     //     )
                //     // );

                // }
                //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS (AT THE END)

                            $indexArrWaktu++;
                            $indexHitam++;
                            
                        //ngatur takt time
                        if ($indexHitam - 19 == $takt_time) {
                            $indexHitam = 19;
                        $nLine = true;
                        }
                        //ngatur takt time

                            } 

                            $objset->setCellValue("A".$indexElementKerja, $no++);
                            $objset->setCellValue("B".$indexElementKerja, $elemen_kerja[$indexArr]);
                            $indexArr++;
                               
                            continue;
                    }

                    $objset->setCellValue("O".$indexElementKerja, $waktu[$indexArr]);
                        
                            //TIME FLOW
                            $indexArrWaktu = 1;
                            for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                                $kolom = $this->Kolom($indexHitam);

                                if ($nLine) {
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);
                                }else{
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);
                                }

                            $indexArrWaktu++;
                            $indexHitam++;

                    //ngatur takt time
                        if ($indexHitam - 19 == $takt_time) {
                        $indexHitam = 19;
                        $nLine = true;
                        }
                    //ngatur takt time

                            } 
                            $indexArr++;
                            continue;
                } 

                 if ($i !== 18) {$indexElementKerja += 3;}

            //STYLING
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexElementKerja.':A'.($indexElementKerja + 2)); //NOMOR
            $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexElementKerja.':M'.($indexElementKerja + 2)); //ELEMEN
            $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexElementKerja.':N'.($indexElementKerja + 2)); //MANUAL    
            $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexElementKerja.':O'.($indexElementKerja + 2)); //AUTO
            $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexElementKerja.':P'.($indexElementKerja + 2)); //WALK

            $objget->getStyle('N'.$indexElementKerja.':P'.($indexElementKerja + 2))->applyFromArray(
                array(
                        'borders' => array(
                        'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );  

                $objget->getStyle('A'.$indexElementKerja.':A'.($indexElementKerja + 2))->applyFromArray(
                    array(
                            'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                    );  

                $objget->getStyle('B'.$indexElementKerja.':M'.($indexElementKerja + 2))->applyFromArray(
                    array(
                            'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
                            'alignment' => array(
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                    );  

                 if ($tu == "PARALEL") { 
                    $objset->setCellValue("O".$indexElementKerja, $waktu[$indexArr]);

                        //TIME FLOW
                        $indexArrWaktu = 1;
                        $indexArrMuda = 1;
                        $indexHitam = $s + 18; //imhere
                        $indexhitam2 = $indexHitam;

                        //SET MUDA// ---huehe
                        // for ($f=0; $f < $muda[$indexArr]; $f++) { 
                        //     if ($finish[$indexArr-1] >= $start[$indexArr-1]) {
                        //         if($muda[$indexArr] > 1){
                        //             $kolomMuda = $this->Kolom($indexhitam2-$muda[$indexArr]);
                        //             $objget->getStyle($kolomMuda.($indexElementKerja))->applyFromArray(
                        //                         array(
                        //                             'fill' => array(
                        //                             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        //                             'color' => array('rgb' => 'fa3eef')
                        //                             ),
                        //                             'font' => array(
                        //                             'color' => array('ffffff')
                        //                             )
                        //                         )
                        //                     );
                        //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolomMuda.($indexElementKerja-1), ' MUDA: '.$muda[$indexArr].' DETIK');
                        //             $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray(
                        //                 array(
                        //                     'font' => array(
                        //                     'color' => array('000000'),
                        //                     'bold' => true,
                        //                     ),
                        //                 )
                        //             );
                        //             $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray( 
                        //                 array(
                        //                     'fill' => array(
                        //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        //                     'color' => array('rgb' => 'fa3eef')
                        //                     ),
                        //                 )
                        //             );
                        //         }
                        //         $indexhitam2++;
                        //     }
                        // }   
                        //SET MUDA//

                        for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                            $kolom = $this->Kolom($indexHitam);

                            if ($nLine) {
                                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);

                                $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                    array(
                                        'font' => array(
                                        'color' => array('000000')
                                        )
                                    )
                                );
                                //pararel //LET UNCOMMENT//
                                // if ($angka == 0) {
                                //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                //         array(
                                //             'fill' => array(
                                //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                //             'color' => array('rgb' => 'a6a6a6')
                                //             ),
                                //         )
                                //     );
                                // }
                                //BLACK STYLING//
                                $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                    array(
                                        'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => '00ff00')
                                        ),
                                        'font' => array(
                                        'color' => array('rgb' => '000000')
                                        )
                                    )
                                );
                            }else{
                                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                                $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                    array(
                                        'font' => array(
                                        'color' => array('ffffff')
                                        )
                                    )
                                );
                                //pararel //LET UNCOMMENT//
                                // if ($angka == 0) {
                                //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                //         array(
                                //             'fill' => array(
                                //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                //             'color' => array('rgb' => 'a6a6a6')
                                //             ),
                                //         )
                                //     );
                                // }
                                //BLACK STYLING//
                                $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                    array(
                                        'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => '00ff00')
                                        ),
                                        'font' => array(
                                        'color' => array('rgb' => '000000')
                                        )
                                    )
                                );
                            }

                //LET UNCOMMENT//
                //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                // if($angka == $waktu[$indexArr] -1 && $i != (18 + ((sizeof($elemen_kerja) - 1) * 3))){
                //     $kolomAbu = $this->Kolom($indexHitam + 1);
                //     $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                //                 array(
                //                     'fill' => array(
                //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //                     'color' => array('rgb' => 'a6a6a6')
                //                     )
                //                 )
                //             );
                //     $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray(
                //         array(
                //             'fill' => array(
                //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //             'color' => array('rgb' => 'a6a6a6')
                //             )
                //         )
                //     );
                // }
                //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                            
                        $indexArrWaktu++;
                        $indexHitam++;

                    //ngatur takt time
                        if ($indexHitam - 19 == $takt_time) {
                        $indexHitam = 19;
                        $nLine = true;
                        }
                    //ngatur takt time

                        } 
                        $nLine = false;

                        $objset->setCellValue("A".$indexElementKerja, $no++);
                        $objset->setCellValue("B".$indexElementKerja, $elemen_kerja[$indexArr]);
                        $indexArr++;
                           
                        continue;
                }

                $objset->setCellValue("O".$indexElementKerja, $waktu[$indexArr]);
                //TIME FLOW MANUAL
                $indexArrWaktu = 1;
                for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                        $kolom = $this->Kolom($indexHitam); 
                        if ($nLine) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);

                            //BLACK STYLING//
                            $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                array(
                                    'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '00ff00')
                                    ),
                                    'font' => array(
                                    'color' => array('rgb' => '000000')
                                    )
                                )
                            );
                        }else{
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                            //BLACK STYLING//
                            $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                array(
                                    'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '00ff00')
                                    ),
                                    'font' => array(
                                    'color' => array('rgb' => '000000')
                                    )
                                )
                            );
                        }
                    // }
                
                //LET UNCOMMENT//
                //  if ($angka == 0) {
                //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                //         array(
                //             'fill' => array(
                //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //             'color' => array('rgb' => 'a6a6a6')
                //             )
                //         )
                //     );
                // }
                
                //LET UNCOMMENT//
                //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                // if($angka == $waktu[$indexArr] - 1 && $i != (18 + ((sizeof($elemen_kerja) - 1) * 3)) ){ 
                //     $kolomAbu = $this->Kolom($indexHitam + 1);
                //     $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                //                 array(
                //                     'fill' => array(
                //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //                     'color' => array('rgb' => 'a6a6a6')
                //                     )
                //                 )
                //             );
                //     // $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray( //gua uncomment nich 
                //     //     array(
                //     //         'fill' => array(
                //     //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //     //         'color' => array('rgb' => 'a6a6a6')
                //     //         ),
                //     //     )
                //     // );
                // }elseif ($angka == 0 && $i != 18) {
                //     $objget->getStyle($kolomAbu.($indexElementKerja ))->applyFromArray(
                //         array(
                //             'fill' => array(
                //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //             'color' => array('rgb' => 'a6a6a6')
                //             )
                //         )
                //     );
                // }
                //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS

                $indexArrWaktu++;
                $indexHitam++;

                    //ngatur takt time
                      if ($indexHitam - 19 == $takt_time) {
                        $indexHitam = 19;
                        $nLine = true;
                    }
                    //ngatur takt time
                }
                $nLine = false;
                // echo $indexHitam;die(); 

                //over here dude
            // }
            // else if ($j == "WALK (Inheritance)"){

            //     if ($elemen_kerja[$indexArr] == $defElementKerja){

            //         //STYLING
            //         $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexElementKerja.':A'.($indexElementKerja + 2)); //NOMOR
            //         $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexElementKerja.':M'.($indexElementKerja + 2)); //ELEMEN
            //         $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexElementKerja.':N'.($indexElementKerja + 2)); //MANUAL    
            //         $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexElementKerja.':O'.($indexElementKerja + 2)); //AUTO
            //         $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexElementKerja.':P'.($indexElementKerja + 2)); //WALK
    
            //         $objget->getStyle('N'.$indexElementKerja.':P'.($indexElementKerja + 2))->applyFromArray(
            //             array(
            //                     'borders' => array(
            //                     'allborders' => array(
            //                     'style' => PHPExcel_Style_Border::BORDER_THIN
            //                         )
            //                     ),
            //                     'alignment' => array(
            //                         'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            //                         'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            //                     ),
            //                 )
            //             );  
    
            //             $objget->getStyle('A'.$indexElementKerja.':A'.($indexElementKerja + 2))->applyFromArray(
            //                 array(
            //                         'borders' => array(
            //                         'allborders' => array(
            //                         'style' => PHPExcel_Style_Border::BORDER_THIN
            //                             )
            //                         ),
            //                         'alignment' => array(
            //                             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            //                             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            //                         )
            //                     )
            //                 );  
    
            //             $objget->getStyle('B'.$indexElementKerja.':M'.($indexElementKerja + 2))->applyFromArray(
            //                 array(
            //                         'borders' => array(
            //                         'allborders' => array(
            //                         'style' => PHPExcel_Style_Border::BORDER_THIN
            //                             )
            //                         ),
            //                         'alignment' => array(
            //                             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            //                         )
            //                     )
            //                 );  
    
            //              if ($tu == "PARALEL") { 
            //                 $objset->setCellValue("P".$indexElementKerja, $waktu[$indexArr]);
            //                     //TIME FLOW
            //                     $indexArrWaktu = 1;
            //                     $indexArrMuda = 1;
            //                     $indexHitam = $s + 18; //imhere
            //                     $indexhitam2 = $indexHitam;
    
            //                     //SET MUDA// ---huehe
            //                     for ($f=0; $f < $muda[$indexArr]; $f++) { 
            //                         if($muda[$indexArr] > 1){
            //                             $kolomMuda = $this->Kolom($indexhitam2-$muda[$indexArr]);
            //                             // echo $kolomMuda;die;
            //                             $objget->getStyle($kolomMuda.($indexElementKerja))->applyFromArray(
            //                                         array(
            //                                             'fill' => array(
            //                                             'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //                                             'color' => array('rgb' => 'fc0303')
            //                                             )
            //                                         )
            //                                     );
                
            //                             $objget->getStyle($kolomMuda.($indexElementKerja -1))->applyFromArray( //gua uncomment nich buat paralel
            //                                 array(
            //                                     'fill' => array(
            //                                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //                                     'color' => array('rgb' => 'fc0303')
            //                                     ),
            //                                 )
            //                             );
            //                         }
            //                         $indexhitam2++;
            //                     }   
            //                     //SET MUDA//

            //                     for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
            //                         $kolom = $this->Kolom($indexParalel);
            //                         $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);
                                    
            //                          //RED STYLING//
            //                          $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
            //                             array(
            //                                 'fill' => array(
            //                                 'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //                                 'color' => array('rgb' => 'ff0000')
            //                                 )
            //                             )
            //                         );
    
            //                     $indexArrWaktu++;
            //                     $indexParalel++;
            //                     } 
    
            //                     $objset->setCellValue("A".$indexElementKerja, $no++);
            //                     $objset->setCellValue("B".$indexElementKerja, $elemen_kerja[$indexArr]);
            //                     $indexArr++;
                                   
            //                     continue;
            //             }
    
            //                 $objset->setCellValue("P".$indexElementKerja, $waktu[$indexArr]);
                            
            //                 //TIME FLOW//
            //                 $indexHijau = $indexHitam;
            //                 for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
            //                     $kolom = $this->Kolom($indexHijau);
            //                     $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), ($angka + 1));
    
            //                 //RED STYLING//
            //                 $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
            //                     array(
            //                         'fill' => array(
            //                         'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //                         'color' => array('rgb' => 'ff0000')
            //                         )
            //                     )
            //                 );   
    
            //                 $indexHijau++;
            //                 $indexHitam++;

            //             //ngatur takt time
            //             if ($indexHitam - 19 == $takt_time) {
            //                 $indexHitam = 19;
            //                 $nLine = true;
            //             }
            //             //ngatur takt time   

            //                 } 
            //                 $indexArr++;
            //                 continue;
                       
            //             } 
            //             // if ($i !== 9) {$indexElementKerja += 3;}
            //             $objset->setCellValue("P".$indexElementKerja, $waktu[$indexArr]);
    
            //             //TIME FLOW//
            //             $indexHijau = $indexHitam;
            //             for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
            //                 $kolom = $this->Kolom(($indexParalel - 1));
            //                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), ($angka + 1));
                        
            //             //RED STYLING//
            //             $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
            //                 array(
            //                     'fill' => array(
            //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //                     'color' => array('rgb' => 'ff0000')
            //                     )
            //                 )
            //             );   

            //             $indexParalel++;
            //             } 
            //             $indexArr++;
            //             continue;

            //         $nLine = false;
            
            // //over here dude, good luck, muachhh WALK :*
            } else {
                    // if ($elemen_kerja[$indexArr] == $defElementKerja){

                    //     $objset->setCellValue("P".$indexElementKerja, $waktu[$indexArr]);

                    // //TIME FLOW//
                    // for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                    //     $kolom = $this->Kolom($indexHitam);

                    //     if ($nLine) {
                    //         $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), ($angka + 1));
                
                    //         //GREY STYLING//
                    //         $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                    //             array(
                    //                 'fill' => array(
                    //                 'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //                 'color' => array('rgb' => '33ffff')
                    //                 ),
                    //                 'font' => array(
                    //                 'color' => array('rgb' => '000000')
                    //                 )
                    //             )
                    //         ); 
                    //     }else{
                    //         $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), ($angka + 1));
                
                    //         //GREY STYLING//
                    //         $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                    //             array(
                    //                 'fill' => array(
                    //                 'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //                 'color' => array('rgb' => '33ffff')
                    //                 ),
                    //                 'font' => array(
                    //                 'color' => array('rgb' => '000000')
                    //                 )
                    //             )
                    //         );   
                    //     }

                    // $indexHitam++;

                    //     //ngatur takt time
                    //     if ($indexHitam - 19 == $takt_time) {
                    //         $indexHitam = 19;
                    //         $nLine = true;
                    //     }
                    //     //ngatur takt time

                    // } 
                    // $indexArr++;
                    // continue;
                    // $nLine = false;

                    // } 
                    if ($i !== 18) {$indexElementKerja += 3;}
                    
                //STYLING
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexElementKerja.':A'.($indexElementKerja + 2)); //NOMOR
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexElementKerja.':M'.($indexElementKerja + 2)); //ELEMEN
                $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexElementKerja.':N'.($indexElementKerja + 2)); //MANUAL    
                $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexElementKerja.':O'.($indexElementKerja + 2)); //AUTO
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexElementKerja.':P'.($indexElementKerja + 2)); //WALK

                $objget->getStyle('N'.$indexElementKerja.':P'.($indexElementKerja + 2))->applyFromArray(
                    array(
                            'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                    );  

                    $objget->getStyle('A'.$indexElementKerja.':A'.($indexElementKerja + 2))->applyFromArray(
                        array(
                                'borders' => array(
                                'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                    )
                                ),
                                'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                )
                            )
                        );  

                    $objget->getStyle('B'.$indexElementKerja.':M'.($indexElementKerja + 2))->applyFromArray(
                        array(
                                'borders' => array(
                                'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                    )
                                ),
                                'alignment' => array(
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                )
                            )
                        );  

                    //begin dude//
                    if ($tu = "PARALEL") { 
                        $objset->setCellValue("P".$indexElementKerja, $waktu[$indexArr]);
                            //TIME FLOW
                            $indexArrWaktu = 1;
                            $indexArrMuda = 1;
                            $indexHitam = $s + 18; //imhere
                            $indexhitam2 = $indexHitam;

                            //SET MUDA// ---huehe
                            for ($f=0; $f < $muda[$indexArr]; $f++) { 
                                if ($finish[$indexArr-1] >= $start[$indexArr-1]) {
                                    if($muda[$indexArr] > 1){
                                        $kolomMuda = $this->Kolom($indexhitam2-$muda[$indexArr]);
                                        // echo $kolomMuda;die;
                                        $objget->getStyle($kolomMuda.($indexElementKerja))->applyFromArray(
                                                    array(
                                                        'fill' => array(
                                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                        'color' => array('rgb' => 'fa3eef')
                                                        ),
                                                        'font' => array(
                                                        'color' => array('ffffff')
                                                        )
                                                    )
                                                );
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolomMuda.($indexElementKerja-1), ' MUDA: '.$muda[$indexArr].' DETIK');
                                        $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray(
                                            array(
                                                'font' => array(
                                                'color' => array('000000'),
                                                'bold' => true,
                                                ),
                                            )
                                        );
                                        $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray( 
                                            array(
                                                'fill' => array(
                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('rgb' => 'fa3eef')
                                                ),
                                            )
                                        );
                                    }
                                    $indexhitam2++;
                                }
                            }   
                            //SET MUDA//
                          
                            for ($angka = 0; $angka < $waktu[$indexArr]; $angka++) { 
                                $kolom = $this->Kolom($indexHitam);
                                    if ($nLine) {

                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);

                                        $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                            array(
                                                'font' => array(
                                                'color' => array('000000'),
                                                'bold' => true,
                                                ),
                                            )
                                        );
                                        //pararel
                                    // if ($angka == 0) {
                                    //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                    //         array(
                                    //             'fill' => array(
                                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    //             'color' => array('rgb' => 'a6a6a6')
                                    //             )
                                    //         )
                                    //     );
                                    //     //tambahin lagi di sini keknya
                                    //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                    //         array(
                                    //             'fill' => array(
                                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    //             'color' => array('rgb' => 'a6a6a6')
                                    //             ),
                                    //         )
                                    //     );
                                    //     //tambahin lagi di sini keknya
                                    // }
                                    //BLACK STYLING//
                                    $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                        array(
                                            'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '33ffff')
                                            ),
                                            'font' => array(
                                            'color' => array('rgb' => '000000'),
                                            )
                                        )
                                    );

                                    }else{
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                                        $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                            array(
                                                'font' => array(
                                                'color' => array('000000'),
                                                'bold' => true,
                                                ),
                                            )
                                        );
                                            //pararel
                                        // if ($angka == 0) {
                                        //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                        //         array(
                                        //             'fill' => array(
                                        //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        //             'color' => array('rgb' => 'a6a6a6')
                                        //             )
                                        //         )
                                        //     );
                                        //     //tambahin lagi di sini keknya
                                        //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                        //         array(
                                        //             'fill' => array(
                                        //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        //             'color' => array('rgb' => 'a6a6a6')
                                        //             ),
                                        //         )
                                        //     );
                                        //     //tambahin lagi di sini keknya
                                        // }
                                        //BLACK STYLING//
                                        $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                            array(
                                                'fill' => array(
                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('rgb' => '33ffff')
                                                ),
                                                'font' => array(
                                                'color' => array('rgb' => '000000'),
                                                )
                                            )
                                        );
                                    }

                //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS (AT THE END)
                // if($angka == $waktu[$indexArr] -1 && $i != (18 + ((sizeof($elemen_kerja) - 1) * 3))){
                //     $kolomAbu = $this->Kolom($indexHitam + 1);
                //     $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                //                 array(
                //                     'fill' => array(
                //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //                     'color' => array('rgb' => 'a6a6a6')
                //                     )
                //                 )
                //             );

                //     // $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray( //gua uncomment nich buat paralel
                //     //     array(
                //     //         'fill' => array(
                //     //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //     //         'color' => array('rgb' => 'a6a6a6')
                //     //         ),
                //     //     )
                //     // );

                // }
                //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS (AT THE END)

                            $indexArrWaktu++;
                            $indexHitam++;
                            
                        //ngatur takt time
                        if ($indexHitam - 19 == $takt_time) {
                            $indexHitam = 19;
                        $nLine = true;
                        }
                        //ngatur takt time

                            } 

                            $objset->setCellValue("A".$indexElementKerja, $no++);
                            $objset->setCellValue("B".$indexElementKerja, $elemen_kerja[$indexArr]);
                            $indexArr++;
                               
                            continue;
                    }
                    $nLine = false;

                //last dude//

                    $objset->setCellValue("P".$indexElementKerja, $waktu[$indexArr]);

                        //TIME FLOW WALK
                        $indexArrAbu = 1;
                        $indexArrMuda = 1;
                        $indexHitam = $s + 18; //imhere
                        $indexhitam2 = $indexHitam;
    
                        //SET MUDA// ---huehe
                        for ($f=0; $f < $muda[$indexArr]; $f++) { 
                            if ($indexArr != 0) {
                                if ($finish[$indexArr-1] >= $start[$indexArr-1]) {
                                    if($muda[$indexArr] > 1){
                                            $kolomMuda = $this->Kolom($indexhitam2-$muda[$indexArr]);
                                            $objget->getStyle($kolomMuda.($indexElementKerja))->applyFromArray(
                                                        array(
                                                            'fill' => array(
                                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                            'color' => array('rgb' => 'fa3eef')
                                                            ),
                                                            'font' => array(
                                                            'color' => array('ffffff')
                                                            )
                                                        )
                                                    );
                                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolomMuda.($indexElementKerja-1), ' MUDA: '.$muda[$indexArr].' DETIK');
                                            $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray(
                                                array(
                                                    'font' => array(
                                                    'color' => array('000000'),
                                                    'bold' => true,
                                                    ),
                                                )
                                            );
                                            $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray( 
                                                array(
                                                    'fill' => array(
                                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                    'color' => array('rgb' => 'fa3eef')
                                                    ),
                                                )
                                            ); 
                                    }
                                    $indexhitam2++;
                                }
                            }
                        } 
                        //SET MUDA

                        for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                            $kolom = $this->Kolom($indexHitam);
                        
                        if ($nLine = false) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrAbu);
                    
                            //GREY STYLING//
                            $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                array(
                                    'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '33ffff')
                                    ),
                                    'font' => array(
                                    'color' => array('rgb' => '000000')
                                    )
                                )
                            ); 
                        }else{
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrAbu);
                    
                            //GREY STYLING//
                            $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                array(
                                    'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '33ffff')
                                    ),
                                    'font' => array(
                                    'color' => array('rgb' => '000000')
                                    )
                                )
                            ); 
                        }
 
                        //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                        // if($angka == $waktu[$indexArr] - 1 && $i != (18 + ((sizeof($elemen_kerja) - 1) * 3))){
                        //     $kolomAbu = $this->Kolom($indexHitam + 1);
                        //     $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                        //                 array(
                        //                     'fill' => array(
                        //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        //                     'color' => array('rgb' => 'a6a6a6')
                        //                     )
                        //                 )
                        //             );
                        //     $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray(
                        //         array(
                        //             'fill' => array(
                        //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        //             'color' => array('rgb' => 'a6a6a6')
                        //             )
                        //         )
                        //     );
                        // }
                        //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS

                        $indexHitam++;
                        $indexArrAbu++;
                        $indexParalel++;

                            //ngatur takt time
                            if ($indexHitam - 19 == $takt_time) {
                                $indexHitam = 19;
                                $nLine = true;
                            }
                            //ngatur takt time
                    }
                $nLine = false;
            }

            if($elemen_kerja[$indexArr] != $defElementKerja){
                //STYLING
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexElementKerja.':A'.($indexElementKerja + 2)); //NOMOR
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexElementKerja.':M'.($indexElementKerja + 2)); //ELEMEN
                $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexElementKerja.':N'.($indexElementKerja + 2)); //MANUAL    
                $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexElementKerja.':O'.($indexElementKerja + 2)); //AUTO
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexElementKerja.':P'.($indexElementKerja + 2)); //WALK

                $objget->getStyle('N'.$indexElementKerja.':P'.($indexElementKerja + 2))->applyFromArray(
                    array(
                            'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                    );  

                    $objget->getStyle('A'.$indexElementKerja.':A'.($indexElementKerja + 2))->applyFromArray(
                        array(
                                'borders' => array(
                                'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                    )
                                ),
                                'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                )
                            )
                        );  

                    $objget->getStyle('B'.$indexElementKerja.':M'.($indexElementKerja + 2))->applyFromArray(
                        array(
                                'borders' => array(
                                'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                    )
                                ),
                                'alignment' => array(
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                )
                            )
                        );  
                //STYLING
                $objset->setCellValue("A".$indexElementKerja, $no++);
                $objset->setCellValue("B".$indexElementKerja, $elemen_kerja[$indexArr]);
            }
            $defElementKerja = $elemen_kerja[$indexArr];
            $indexArr++;
        };//die();
        // $objPHPExcel->getActiveSheet()->mergeCells('C12:F13'); //ELEMEN KERJA

        //SET TOTAL TIMES//
        $indexJml = $indexElementKerja + 3;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexJml.':M'.($indexJml + 2)); 
        $objset->setCellValue("A".$indexJml, "JUMLAH");
        $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexJml.':N'.($indexJml + 1)); 
        $objset->setCellValue("N".$indexJml, $jumlah_manual);
        $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexJml.':O'.($indexJml + 1)); 
        $objset->setCellValue("O".$indexJml, $jumlah_auto);
        $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexJml.':P'.($indexJml + 1)); 
        $objset->setCellValue("P".$indexJml, $jumlah_walk);
        $objPHPExcel->getActiveSheet()->mergeCells('N'.($indexJml + 2).':P'.($indexJml + 2)); 
        $objset->setCellValue("N".($indexJml + 2), $jumlah);

        // $objPHPExcel->getActiveSheet()->mergeCells('K'.$indexJml.':'.($kolomB + 2)); 
        // $objset->setCellValue("K".$indexJml, "CATATAN:");

        //STYLING OF TOTAL TIMES//
        $objget->getStyle('A'.$indexJml.':M'.($indexJml + 2))->applyFromArray(
            array(
                    'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );  

        $objget->getStyle('N'.$indexJml.':N'.($indexJml + 1))->applyFromArray(
            array(
                    'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )
                    ),
                    'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );  


        $objget->getStyle('O'.$indexJml.':O'.($indexJml + 1))->applyFromArray(
            array(
                    'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );          

        $objget->getStyle('P'.$indexJml.':P'.($indexJml + 1))->applyFromArray(
            array(
                    'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );          

        $objget->getStyle('N'.($indexJml + 2).':P'.($indexJml + 2))->applyFromArray(
            array(
                    'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
            ) 
        );

        //BOLDING THE OUTLINE BORDER FOR ELEMENTS TABLE//
        $objget->getStyle('A15'.':P'.($indexJml + 2))->applyFromArray(
            array(
                    'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )
                    )
                )
            ); 

        //SELECT DATA IRREGULAR JOBS
        $data['lihat_irregular_jobs'] = $this->M_gentskk->selectIrregularJobs($id_tskk);
        // echo"<pre>";print_r($data['lihat_irregular_jobs']);
        // die;

        //SET IRREGULAR JOB//
        $indexIrregular = $indexJml + 4;
        $indexIsiKiriIrregular  = $indexIrregular + 3;
        $indexIsiKananIrregular = $indexIrregular + 4;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexIrregular.':A'.($indexIrregular + 2)); 
        $objset->setCellValue("A".$indexIrregular, "NO");
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexIrregular.':M'.($indexIrregular + 2)); 
        $objset->setCellValue("B".$indexIrregular, "Irregular Job");
        $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexIrregular.':N'.($indexIrregular + 1)); 
        $objset->setCellValue("N".$indexIrregular, "Ratio");
        $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexIrregular.':O'.($indexIrregular + 1)); 
        $objset->setCellValue("O".$indexIrregular, "Waktu");
        $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexIrregular.':P'.($indexIrregular + 1));
        $objset->setCellValue("P".$indexIrregular, "Waktu/    Ratio");
        $objget->getStyle('P'.$indexIrregular.':P'.($indexIrregular + 1))->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->mergeCells('N'.($indexIrregular + 2).':N'.($indexIrregular + 2)); 
        $objset->setCellValue("N".($indexIrregular + 2), "Kali");
        $objPHPExcel->getActiveSheet()->mergeCells('O'.($indexIrregular + 2).':P'.($indexIrregular + 2)); 
        $objset->setCellValue("O".($indexIrregular + 2), "Detik");

        //buat isinye irregular job ye// which is cycle time flow
        if (!empty($data['lihat_irregular_jobs'])) {
            $number = 1;
            $pointKiri   = $indexIrregular + 3;
            $pointKanan  = $indexIrregular + 4;
            $jumlahKiri  = ($indexIrregular + 3) + (count($data['lihat_irregular_jobs']) * 2);
            $jumlahKanan = $jumlahKiri + 1;
            
            //SET IRREGULAR JOB TIME FLOW
            $jumlah_hasil_irregular = array_sum($hasil_irregular);
                // TIME FLOW
                $indexArr = 0;
                $indexArrWaktu = 1;
                $indexIrregularJob = $last_finish + 1;
                $irregularJobPoint = $jumlah_hasil_irregular;
                $indexIJ = $indexIrregularJob + 18;
                $indexCT = $indexIrregularJob - $jumlah_hasil_irregular - 10;

                for ($angka =  0; $angka < $irregularJobPoint; $angka++) { 
                    $kolom = $this->Kolom($indexIJ);

                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.(18), $indexArrWaktu);
                        //BLUE STYLING//
                        $objget->getStyle($kolom.(18))->applyFromArray(
                            array(
                                'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '2a61ad') //dark blue 
                                ),
                                'font' => array(
                                'color' => array('rgb' => 'ffffff'),
                                )
                            )
                        );

                    $indexIJ++;
                    $indexArrWaktu++;
                }
                $indexArr++;

                // $kolomTeksIrregular = $this->Kolom($indexIJ + 1);
                // $objset->setCellValue($kolomTeksIrregular.'18', "Irregular Job = ".$jumlah_hasil_irregular." Detik");
                // $objget->getStyle($kolomTeksIrregular.'18')->applyFromArray(
                //     array(
                //         'font' => array(
                //         'color' => array('000000'),
                //         'bold' => true,
                //         ),
                //     )
                // ); //awokawok

                $kolomTeksCycleTime = $this->Kolom($indexIJ);
                $objset->setCellValue($kolomTeksCycleTime.'18', "Cycle Time = ".$cycle_time." Detik"); //need to be merge
                $objget->getStyle($kolomTeksCycleTime.'18')->applyFromArray(
                    array(
                        'font' => array(
                        'color' => array('000000'),
                        'bold' => true,
                        ),
                    )
                );

                //SET CYCLE TIME ROWS
                $kolomKuning    = $this->Kolom($cycle_time + 18);
                $kolomCycleTime = $this->Kolom($cycleTimeText + 18);
                $objget->getStyle($kolomKuning.'18:'.$kolomKuning.'20')->applyFromArray(
                    array(
                        'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'fcf403')
                        )
                    )
                );
                //SET CYCLE TIME ROWS
            
            //SET IRREGULAR JOB ELEMENTS
            foreach ($data['lihat_irregular_jobs'] as $irr) {
                $objPHPExcel->getActiveSheet()->mergeCells('A'.($pointKiri).':A'.($pointKanan)); 
                $objset->setCellValue("A".($pointKiri), $number);
    
                $objPHPExcel->getActiveSheet()->mergeCells('B'.($pointKiri).':M'.($pointKanan)); 
                $objset->setCellValue("B".($pointKiri), "   ".$irr['irregular_job']);    
                
                $objPHPExcel->getActiveSheet()->mergeCells('N'.($pointKiri).':N'.($pointKanan)); 
                $objset->setCellValue("N".($pointKiri), $irr['ratio']);
    
                $objPHPExcel->getActiveSheet()->mergeCells('O'.($pointKiri).':O'.($pointKanan)); 
                $objset->setCellValue("O".($pointKiri), $irr['waktu']);
    
                $objPHPExcel->getActiveSheet()->mergeCells('P'.($pointKiri).':P'.($pointKanan)); 
                $objset->setCellValue("P".($pointKiri), $irr['hasil_irregular_job']);
    
                //STYLING
                $objget->getStyle('A'.($pointKiri).':A'.($pointKanan))->applyFromArray(
                    array(
                            'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            ),
                        )
                    ); 
    
                $objget->getStyle('B'.($pointKiri).':M'.($pointKanan))->applyFromArray(
                    array(
                            'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            ),
                        )
                    ); 
    
    
                $objget->getStyle('N'.($pointKiri).':P'.($pointKanan))->applyFromArray(
                    array(
                            'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            ),
                        )
                    ); 
            
                //JUMLAH IRREGULAR JOB
                $objPHPExcel->getActiveSheet()->mergeCells('A'.($jumlahKiri).':O'.($jumlahKanan)); 
                $objset->setCellValue("A".($jumlahKiri), "JUMLAH");
    
                $objPHPExcel->getActiveSheet()->mergeCells('P'.($jumlahKiri).':P'.($jumlahKanan)); 
                $objset->setCellValue("P".($jumlahKiri), $jumlah_hasil_irregular);
    
                //STYLING JUMLAH
                $objget->getStyle('A'.($jumlahKiri).':O'.($jumlahKanan))->applyFromArray(
                    array(
                            'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            ),
                        )
                    ); 
    
                $objget->getStyle('P'.($jumlahKiri).':P'.($jumlahKanan))->applyFromArray(
                    array(
                            'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                    ); 
    
            $number++;
            $pointKiri+=2;
            $pointKanan+=2;
            }        
        }else{
            $objPHPExcel->getActiveSheet()->mergeCells('A'.($indexIrregular+3).':A'.($indexIrregular+4)); 
            $objset->setCellValue("A".($indexIrregular+3), " ");

            $objPHPExcel->getActiveSheet()->mergeCells('B'.($indexIrregular+3).':M'.($indexIrregular+4)); 
            $objset->setCellValue("B".($indexIrregular+3), " ");    
            
            $objPHPExcel->getActiveSheet()->mergeCells('N'.($indexIrregular+3).':N'.($indexIrregular+4)); 
            $objset->setCellValue("N".($indexIrregular+3), " ");

            $objPHPExcel->getActiveSheet()->mergeCells('O'.($indexIrregular+3).':O'.($indexIrregular+4)); 
            $objset->setCellValue("O".($indexIrregular+3), " ");

            $objPHPExcel->getActiveSheet()->mergeCells('P'.($indexIrregular+3).':P'.($indexIrregular+4)); 
            $objset->setCellValue("P".($indexIrregular+3), " ");

            //STYLING
            $objget->getStyle('A'.($indexIrregular+3).':A'.($indexIrregular+4))->applyFromArray(
                array(
                        'borders' => array(
                        'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                    )
                ); 

            $objget->getStyle('B'.($indexIrregular+3).':M'.($indexIrregular+4))->applyFromArray(
                array(
                        'borders' => array(
                        'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                    )
                ); 


            $objget->getStyle('N'.($indexIrregular+3).':P'.($indexIrregular+4))->applyFromArray(
                array(
                        'borders' => array(
                        'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                    )
                ); 
        
            //JUMLAH IRREGULAR JOB
            $objPHPExcel->getActiveSheet()->mergeCells('A'.($indexIrregular+5).':O'.($indexIrregular+6)); 
            $objset->setCellValue("A".($indexIrregular+5), "JUMLAH");

            $objPHPExcel->getActiveSheet()->mergeCells('P'.($indexIrregular+5).':P'.($indexIrregular+6)); 
            $objset->setCellValue("P".($indexIrregular+5), " ");

            //STYLING JUMLAH
            $objget->getStyle('A'.($indexIrregular+5).':O'.($indexIrregular+6))->applyFromArray(
                array(
                        'borders' => array(
                        'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                    )
                ); 

            $objget->getStyle('P'.($indexIrregular+5).':P'.($indexIrregular+6))->applyFromArray(
                array(
                        'borders' => array(
                        'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                ); 
        }


       //STYLING IRREGULAR JOBS//
        $objget->getStyle('A'.$indexIrregular.':M'.($indexIrregular + 2))->applyFromArray(
            array(                        
                    'font' => array(
                        'color' => array('rgb' => 'ffffff'),
                        'bold' => true,
                    ),
                    'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),         
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '2810e0')
                    )
                )
            ); 

        $objget->getStyle('N'.$indexIrregular.':P'.($indexIrregular + 2))->applyFromArray(
            array(
                    'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'a69bfa')
                    )
                )
            ); 

    //KETERANGAN// 
    $objPHPExcel->getActiveSheet()->mergeCells('R'.$indexJml.':DX'.($indexJml));   
    $objset->setCellValue("R".$indexJml, "   1. Keterangan");
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml + 1).':DX'.($indexJml + 1));   

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml + 2).':BZ'.($indexJml + 2));   //Waktu 1 Shift
    $objset->setCellValue("R".($indexJml + 2), "   - Waktu 1 Shift");
        $objget->getStyle('R'.($indexJml + 2).':DX'.($indexJml + 2))->applyFromArray(
        array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                    )
                )
            )
        ); 

    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml + 2).':CC'.($indexJml + 2));   
    $objset->setCellValue("CA".($indexJml + 2), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml + 2).':DC'.($indexJml + 2));   
    $objset->setCellValue("CD".($indexJml + 2), $waktu_satu_shift); //idk
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml + 2).':DR'.($indexJml + 2));   
    $objset->setCellValue("DD".($indexJml + 2), "Detik");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml + 2).':DX'.($indexJml + 2));   

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml + 3).':BZ'.($indexJml + 3));  //Cycle Time (Tanpa Irregular Job) 
    $objset->setCellValue("R".($indexJml + 3), "   - Cycle Time (Dengan Irregular Job)");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml + 3).':CC'.($indexJml + 3));   
    $objset->setCellValue("CA".($indexJml + 3), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml + 3).':DC'.($indexJml + 3));   
    $objset->setCellValue("CD".($indexJml + 3), $cycle_time);
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml + 3).':DR'.($indexJml + 3));   
    $objset->setCellValue("DD".($indexJml + 3), "Detik");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml + 3).':DX'.($indexJml + 3));  

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml + 4).':BZ'.($indexJml + 4));  //Jumlah Hari Kerja / Bulan 
    $objset->setCellValue("R".($indexJml + 4), "   - Jumlah Hari Kerja / Bulan");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml + 4).':CC'.($indexJml + 4));   
    $objset->setCellValue("CA".($indexJml + 4), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml + 4).':DC'.($indexJml + 4));   
    // $objset->setCellValue("CD".($indexJml + 4), number_format($jumlah_hari_kerja)); //idk
    $objset->setCellValue("CD".($indexJml + 4), $jumlah_hari_kerja); //idk
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml + 4).':DR'.($indexJml + 4));   
    $objset->setCellValue("DD".($indexJml + 4), "Hari");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml + 4).':DX'.($indexJml + 4)); 

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml + 5).':BZ'.($indexJml + 5));  //Forecast 
    $objset->setCellValue("R".($indexJml + 5), "   - Forecast");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml + 5).':CC'.($indexJml + 5));   
    $objset->setCellValue("CA".($indexJml + 5), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml + 5).':DC'.($indexJml + 5));   
    $objset->setCellValue("CD".($indexJml + 5), $forecast);
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml + 5).':DR'.($indexJml + 5));   
    $objset->setCellValue("DD".($indexJml + 5), "Unit");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml + 5).':DX'.($indexJml + 5)); 

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml + 6).':BZ'.($indexJml + 6));  //Qty/Unit 
    $objset->setCellValue("R".($indexJml + 6), "   - Qty / Unit");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml + 6).':CC'.($indexJml + 6));   
    $objset->setCellValue("CA".($indexJml + 6), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml + 6).':DC'.($indexJml + 6));   
    $objset->setCellValue("CD".($indexJml + 6), $qty_unit);
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml + 6).':DR'.($indexJml + 6));   
    $objset->setCellValue("DD".($indexJml + 6), " ");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml + 6).':DX'.($indexJml + 6)); 

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml + 7).':BZ'.($indexJml +7));  //Rencana Produksi / Bulan 
    $objset->setCellValue("R".($indexJml +7), "   - Rencana Produksi / Bulan");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml +7).':CC'.($indexJml +7));   
    $objset->setCellValue("CA".($indexJml +7), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml +7).':DC'.($indexJml +7));   
    $objset->setCellValue("CD".($indexJml +7), $rencana_produksi);
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml +7).':DR'.($indexJml +7));   
    $objset->setCellValue("DD".($indexJml +7), "Pcs");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml +7).':DX'.($indexJml +7)); 

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +8).':BZ'.($indexJml +8));  //Takt Time 
    $objset->setCellValue("R".($indexJml +8), "   - Takt Time");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml +8).':CC'.($indexJml +8));   
    $objset->setCellValue("CA".($indexJml +8), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml +8).':DC'.($indexJml +8));   
    $objset->setCellValue("CD".($indexJml +8), $takt_time); //idk
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml +8).':DR'.($indexJml +8));   
    $objset->setCellValue("DD".($indexJml +8), "Detik");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml +8).':DX'.($indexJml +8)); 

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +9).':BZ'.($indexJml +9));  //Qty dalam 1 Cycle 
    $objset->setCellValue("R".($indexJml +9), "   - Qty dalam 1 Cycle");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml +9).':CC'.($indexJml +9));   
    $objset->setCellValue("CA".($indexJml +9), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml +9).':DC'.($indexJml +9));   
    $objset->setCellValue("CD".($indexJml +9), " ");
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml +9).':DR'.($indexJml +9));   
    $objset->setCellValue("DD".($indexJml +9), "Pcs");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml +9).':DX'.($indexJml +9)); 

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +10).':BZ'.($indexJml +10));  //Handling Time
    $objset->setCellValue("R".($indexJml +10), "   - Handling Time [Σ(Manual + Walk)]");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml +10).':CC'.($indexJml +10));   
    $objset->setCellValue("CA".($indexJml +10), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml +10).':DC'.($indexJml +10));   
    $objset->setCellValue("CD".($indexJml +10), ($jumlah_manual + $jumlah_walk)); //idk
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml +10).':DR'.($indexJml +10));   
    $objset->setCellValue("DD".($indexJml +10), "Detik");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml +10).':DX'.($indexJml +10));    

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +11).':BZ'.($indexJml +11));  //Machining Time
    $objset->setCellValue("R".($indexJml +11), "   - Machining Time [Σ Auto]");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml +11).':CC'.($indexJml +11));   
    $objset->setCellValue("CA".($indexJml +11), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml +11).':DC'.($indexJml +11));   
    $objset->setCellValue("CD".($indexJml +11), $jumlah_auto); //idk
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml +11).':DR'.($indexJml +11));   
    $objset->setCellValue("DD".($indexJml +11), "Detik");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml +11).':DX'.($indexJml +11));    

    //SET A BOX FOR NOTES (13 - 21)
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +13).':IN'.($indexJml +13));    
    $objset->setCellValue('R'.($indexJml +13), "   CATATAN :");
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +14).':IN'.($indexJml +14));    
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +15).':IN'.($indexJml +15));    
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +16).':IN'.($indexJml +16));    
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +17).':IN'.($indexJml +17));    
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +18).':IN'.($indexJml +18));    
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +19).':IN'.($indexJml +19));    
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +20).':IN'.($indexJml +20));    
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +21).':IN'.($indexJml +21));      

    $objget->getStyle('R'.($indexJml +13).':IN'.($indexJml +21))->applyFromArray(
        array(                
                'font' => array(
                    'color' => array('rgb' => '000000'),
                    'bold' => true,
                ),
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            )
        ); 

    $objget->getStyle('A'.$indexIrregular.':P'.($indexIrregular + 17))->applyFromArray(
        array(
                'borders' => array(
                'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            )
        ); 

    $objget->getStyle('R'.$indexJml.':DX'.($indexJml + 11))->applyFromArray(
        array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        ); 

    $objget->getStyle('CD'.($indexJml + 2).':DC'.($indexJml + 11))->applyFromArray(
        array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        ); 

    //THE END OF KETERANGAN STYLING 

    //BOLDING SIGNATURE OUTLINE
    $objget->getStyle('IO'.($indexJml +13).':NX'.($indexJml +21))->applyFromArray(
        array(
                'borders' => array(
                'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            )
        ); 

    //PERHITUNGAN TAKT TIME//
    $objPHPExcel->getActiveSheet()->mergeCells('DY'.$indexJml.':IN'.($indexJml));   
    $objset->setCellValue("DY".$indexJml, "   2. Perhitungan Takt Time");
    $objget->getStyle('DY'.$indexJml.':IN'.($indexJml))->applyFromArray(
        array(
            'borders' => array(
                'top' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )  
        )
    ); 
    $objPHPExcel->getActiveSheet()->mergeCells('DY'.($indexJml + 1).':IN'.($indexJml + 1)); 

    $objPHPExcel->getActiveSheet()->mergeCells('DY'.($indexJml + 2).':FI'.($indexJml + 4)); 
    $objPHPExcel->getActiveSheet()->mergeCells('IM'.($indexJml + 2).':IN'.($indexJml + 4)); 
    $objset->setCellValue("DY".($indexJml + 2), "Takt Time");
    $objget->getStyle('DY'.($indexJml + 2).':FI'.($indexJml + 4))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    ); 

    $objPHPExcel->getActiveSheet()->mergeCells('FJ'.($indexJml + 2).':FN'.($indexJml + 4)); 
    $objset->setCellValue("FJ".($indexJml + 2), "=");
    $objget->getStyle('FJ'.($indexJml + 2).':FN'.($indexJml + 4))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('FQ'.($indexJml + 3).':FQ'.($indexJml + 4)); 
    $objset->setCellValue("FQ".($indexJml + 3), "(");
    $objget->getStyle('FQ'.($indexJml + 3).':FQ'.($indexJml + 4))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('IJ'.($indexJml + 3).':IJ'.($indexJml + 4)); 
    $objset->setCellValue("IJ".($indexJml + 3), ")");
    $objget->getStyle('IJ'.($indexJml + 3).':IJ'.($indexJml + 4))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('FO'.($indexJml + 2).':IL'.($indexJml + 2));  
    $objset->setCellValue("FO".($indexJml + 2), "Waktu 1 Shift");
        $objget->getStyle('FO'.($indexJml + 2).':IL'.($indexJml + 2))->applyFromArray(
            array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        );   

    $objPHPExcel->getActiveSheet()->mergeCells('FS'.($indexJml + 3).':IH'.($indexJml + 3));  
    $objset->setCellValue("FS".($indexJml + 3), "Rencana Produksi / Bulan");
        $objget->getStyle('FS'.($indexJml + 3).':IH'.($indexJml + 3))->applyFromArray(
            array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        ); 
        
    $objPHPExcel->getActiveSheet()->mergeCells('FS'.($indexJml + 4).':IH'.($indexJml + 4));  
    $objset->setCellValue("FS".($indexJml + 4), "Jumlah Hari Kerja / Bulan");
        $objget->getStyle('FS'.($indexJml + 4).':IH'.($indexJml + 4))->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        ); 

//just change the position
    $objPHPExcel->getActiveSheet()->mergeCells('FJ'.($indexJml + 6).':FN'.($indexJml + 8)); 
    $objset->setCellValue("FJ".($indexJml + 6), "=");
    $objget->getStyle('FJ'.($indexJml + 6).':FN'.($indexJml + 8))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('FQ'.($indexJml + 7).':FQ'.($indexJml + 8)); 
    $objset->setCellValue("FQ".($indexJml + 7), "(");
    $objget->getStyle('FQ'.($indexJml + 7).':FQ'.($indexJml + 8))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('IJ'.($indexJml + 7).':IJ'.($indexJml + 8)); 
    $objset->setCellValue("IJ".($indexJml + 7), ")");
    $objget->getStyle('IJ'.($indexJml + 7).':IJ'.($indexJml + 8))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('FO'.($indexJml + 6).':IL'.($indexJml + 6));  
    $objset->setCellValue("FO".($indexJml + 6), $waktu_satu_shift." detik");
        $objget->getStyle('FO'.($indexJml + 6).':IL'.($indexJml + 6))->applyFromArray(
            array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        );   

    $objPHPExcel->getActiveSheet()->mergeCells('FS'.($indexJml + 7).':IH'.($indexJml + 7));  
    $objset->setCellValue("FS".($indexJml + 7), $rencana_produksi);
        $objget->getStyle('FS'.($indexJml + 7).':IH'.($indexJml + 7))->applyFromArray(
            array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        ); 
        
    $objPHPExcel->getActiveSheet()->mergeCells('FS'.($indexJml + 8).':IH'.($indexJml + 8));  
    $objset->setCellValue("FS".($indexJml + 8), $jumlah_hari_kerja);
        $objget->getStyle('FS'.($indexJml + 8).':IH'.($indexJml + 8))->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        ); 

    $objPHPExcel->getActiveSheet()->mergeCells('FJ'.($indexJml + 9).':FN'.($indexJml + 9)); 
    $objset->setCellValue("FJ".($indexJml + 9), "=");
    $objget->getStyle('FJ'.($indexJml + 9).':FN'.($indexJml + 9))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('FO'.($indexJml + 9).':GH'.($indexJml + 9)); 
    $objset->setCellValue("FO".($indexJml + 9), $takt_time);
    $objget->getStyle('FO'.($indexJml + 9).':GH'.($indexJml + 9))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('GI'.($indexJml + 9).':GZ'.($indexJml + 9)); 
    $objset->setCellValue("GI".($indexJml + 9), "Detik");
    $objget->getStyle('GI'.($indexJml + 9).':GZ'.($indexJml + 9))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objget->getStyle('DY'.$indexJml.':IN'.($indexJml + 11))->applyFromArray(
        array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            )
        ); 

    //THE END OF PERHITUNGAN TAKT TIME

    //3. TARGET//
    $objPHPExcel->getActiveSheet()->mergeCells('IO'.$indexJml.':NX'.($indexJml));   
    $objset->setCellValue("IO".$indexJml, "   3. Jumlah Pcs yang dihasilkan dalam 1 shift");
    $objget->getStyle('IO'.$indexJml.':NX'.($indexJml))->applyFromArray(
        array(
            'borders' => array(
                'top' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )  
        )
    ); 
    $objPHPExcel->getActiveSheet()->mergeCells('IO'.($indexJml + 1).':NX'.($indexJml + 1)); 

    $objPHPExcel->getActiveSheet()->mergeCells('IO'.($indexJml + 2).':JY'.($indexJml + 3)); 
    $objset->setCellValue("IO".($indexJml + 2), "Pcs / Shift");
    $objget->getStyle('IO'.($indexJml + 2).':JY'.($indexJml + 3))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    ); 

    $objPHPExcel->getActiveSheet()->mergeCells('JZ'.($indexJml + 2).':KD'.($indexJml + 3)); 
    $objset->setCellValue("JZ".($indexJml + 2), "=");
    $objget->getStyle('JZ'.($indexJml + 2).':KD'.($indexJml + 3))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('KE'.($indexJml + 2).':NM'.($indexJml + 2));  
    $objset->setCellValue("KE".($indexJml + 2), "Waktu 1 Shift x Quantity");
        $objget->getStyle('KE'.($indexJml + 2).':NM'.($indexJml + 2))->applyFromArray(
            array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        );   

    $objPHPExcel->getActiveSheet()->mergeCells('KE'.($indexJml + 3).':NM'.($indexJml + 3));  
    $objset->setCellValue("KE".($indexJml + 3), "Cycle Time (Dengan Irregular Job)");
        $objget->getStyle('KE'.($indexJml + 3).':NM'.($indexJml + 3))->applyFromArray(
            array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        ); 
        
    $objPHPExcel->getActiveSheet()->mergeCells('JZ'.($indexJml + 6).':KD'.($indexJml +7)); 
    $objset->setCellValue("JZ".($indexJml + 6), "=");
    $objget->getStyle('JZ'.($indexJml + 6).':KD'.($indexJml +7))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('KE'.($indexJml + 6).':NM'.($indexJml + 6));  
    $objset->setCellValue("KE".($indexJml + 6), $waktu_satu_shift."       x       ".$qty_unit);
        $objget->getStyle('KE'.($indexJml + 6).':NM'.($indexJml + 6))->applyFromArray(
            array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        );   

    $objPHPExcel->getActiveSheet()->mergeCells('KE'.($indexJml + 7).':NM'.($indexJml + 7));  
    $objset->setCellValue("KE".($indexJml + 7), $cycle_time);
        $objget->getStyle('KE'.($indexJml + 7).':NM'.($indexJml + 7))->applyFromArray(
            array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        ); 

    $objPHPExcel->getActiveSheet()->mergeCells('JZ'.($indexJml + 9).':KD'.($indexJml + 9)); 
    $objset->setCellValue("JZ".($indexJml + 9), "=");
    $objget->getStyle('JZ'.($indexJml + 9).':KD'.($indexJml + 9))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

        //CALCULATION FOR TARGET
        $atas   = $waktu_satu_shift * $qty_unit;
        $target = $atas / $cycle_time;
        $target_result = floor($target);
        // echo"<pre>"; echo $target;
        // die;

    $objPHPExcel->getActiveSheet()->mergeCells('KE'.($indexJml + 9).':LB'.($indexJml + 9)); 
    $objset->setCellValue("KE".($indexJml + 9), $target_result);
    $objget->getStyle('KE'.($indexJml + 9).':LB'.($indexJml + 9))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('LC'.($indexJml + 9).':LQ'.($indexJml + 9)); 
    $objset->setCellValue("LC".($indexJml + 9), "Pcs");
    $objget->getStyle('LC'.($indexJml + 9).':LQ'.($indexJml + 9))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objget->getStyle('IO'.$indexJml.':NX'.($indexJml + 11))->applyFromArray(
        array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            )
        ); 

    $objPHPExcel->getActiveSheet()->mergeCells('NN'.($indexJml + 2).':NX'.($indexJml + 2));   
    $objget->getStyle('NN'.($indexJml + 2).':NX'.($indexJml + 2))->applyFromArray(
        array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                    )
                )
            )
        ); 
    
    $objget->getStyle('KE'.($indexJml + 3).':NM'.($indexJml + 3))->applyFromArray( 
        array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                    )
                )
            )
        ); 

    $objget->getStyle('KE'.($indexJml + 7).':NM'.($indexJml + 7))->applyFromArray( 
        array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                    )
                )
            )
        ); 

    //THE END OF TARGET

            //SIGNATURE
    
    //MENYETUJUI 
    $objPHPExcel->getActiveSheet()->mergeCells('JK'.($indexJml + 14).':KM'.($indexJml + 14)); 
    $objset->setCellValue('JK'.($indexJml + 14), "Menyetujui");
    $objget->getStyle('JK'.($indexJml + 14).':KM'.($indexJml + 14))->applyFromArray(
        array(
                'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'a2a8a8')
                )
            )
        );
    
        $objget->getStyle('JK'.($indexJml + 15).':KM'.($indexJml + 18))->applyFromArray(
            array(
                    'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );

    $objPHPExcel->getActiveSheet()->mergeCells('JK'.($indexJml + 15).':KM'.($indexJml + 17));   
    $objPHPExcel->getActiveSheet()->mergeCells('JK'.($indexJml + 18).':KM'.($indexJml + 18));   
    $objPHPExcel->getActiveSheet()->mergeCells('JK'.($indexJml +19).':KM'.($indexJml +19)); 
    $objset->setCellValue('JK'.($indexJml +19), "Tgl :");
    $objget->getStyle('JK'.($indexJml +19).':KM'.($indexJml +19))->applyFromArray(
        array(
                'borders' => array(
                'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

    //DIPERIKSA 2 
    $objPHPExcel->getActiveSheet()->mergeCells('KN'.($indexJml + 14).':LQ'.($indexJml + 14)); 
    $objset->setCellValue('KN'.($indexJml + 14), "Diperiksa 2");
    $objget->getStyle('KN'.($indexJml + 14).':LQ'.($indexJml + 14))->applyFromArray(
        array(
                'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'a2a8a8')
                )
            )
        );
    
        $objget->getStyle('KN'.($indexJml + 15).':LQ'.($indexJml + 18))->applyFromArray(
            array(
                    'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );

    $objPHPExcel->getActiveSheet()->mergeCells('KN'.($indexJml + 15).':LQ'.($indexJml + 17));   
    $objPHPExcel->getActiveSheet()->mergeCells('KN'.($indexJml + 18).':LQ'.($indexJml + 18));   
    $objPHPExcel->getActiveSheet()->mergeCells('KN'.($indexJml + 19).':LQ'.($indexJml + 19)); 
    $objset->setCellValue('KN'.($indexJml + 19), "Tgl :");
    $objget->getStyle('KN'.($indexJml + 19).':LQ'.($indexJml + 19))->applyFromArray(
        array(
                'borders' => array(
                'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

    //DIPERIKSA 1 
    $objPHPExcel->getActiveSheet()->mergeCells('LR'.($indexJml + 14).':MU'.($indexJml + 14)); 
    $objset->setCellValue('LR'.($indexJml + 14), "Diperiksa 1");
    $objget->getStyle('LR'.($indexJml + 14).':MU'.($indexJml + 14))->applyFromArray(
        array(
                'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'a2a8a8')
                )
            )
        );
    
        $objget->getStyle('LR'.($indexJml + 15).':MU'.($indexJml + 18))->applyFromArray(
            array(
                    'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );

    $objPHPExcel->getActiveSheet()->mergeCells('LR'.($indexJml + 15).':MU'.($indexJml + 17));   
    $objPHPExcel->getActiveSheet()->mergeCells('LR'.($indexJml + 18).':MU'.($indexJml + 18));   
    $objPHPExcel->getActiveSheet()->mergeCells('LR'.($indexJml + 19).':MU'.($indexJml + 19)); 
    $objset->setCellValue('LR'.($indexJml + 19), "Tgl :");
    $objget->getStyle('LR'.($indexJml + 19).':MU'.($indexJml + 19))->applyFromArray(
        array(
                'borders' => array(
                'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

    //DIBUAT
    $objPHPExcel->getActiveSheet()->mergeCells('MV'.($indexJml +14).':NW'.($indexJml +14)); 
    $objset->setCellValue('MV'.($indexJml +14), "Dibuat");
    $objget->getStyle('MV'.($indexJml +14).':NW'.($indexJml +14))->applyFromArray(
        array(
                'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'a2a8a8')
                )
            )
        );
    
        $objget->getStyle('MV'.($indexJml + 15).':NW'.($indexJml + 18))->applyFromArray(
            array(
                    'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );

    $objPHPExcel->getActiveSheet()->mergeCells('MV'.($indexJml + 15).':NW'.($indexJml + 17));   
    $objPHPExcel->getActiveSheet()->mergeCells('MV'.($indexJml + 18).':NW'.($indexJml + 18));   
    $objPHPExcel->getActiveSheet()->mergeCells('MV'.($indexJml + 19).':NW'.($indexJml + 19)); 
    $objset->setCellValue('MV'.($indexJml + 19), "Tgl :");
    $objget->getStyle('MV'.($indexJml + 19).':NW'.($indexJml + 19))->applyFromArray(
        array(
                'borders' => array(
                'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

    // $objPHPExcel->getActiveSheet()->mergeCells('A'.($indexJml + 11).':NX'.($indexJml + 19));  

    $objget->getStyle('A'.($indexJml + 21).':NX'.($indexJml + 21))->applyFromArray(
        array(
                'borders' => array(
                'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            )
        );
    //SIGNATURE//

    $objPHPExcel->getActiveSheet()->getStyle('A15:NX'.($indexJml + 21))->getFont()->setSize(11); //font size over all
    $objPHPExcel->getActiveSheet()->getStyle('R'.$indexJml.':NX'.($indexJml))->getFont()->setSize(15); //heading keterangan dan perhitungan takt time
    $objPHPExcel->getActiveSheet()->getStyle('B15:M17')->getFont()->setSize(17);

    //no form
    $objPHPExcel->getActiveSheet()->mergeCells('JK'.($indexJml + 21).':NW'.($indexJml + 21));   
    $objset->setCellValue('JK'.($indexJml + 21), "Form No. : FRM-PDE-03-21 (Rev. 00-05/11/2021)");

    $objget->getStyle('JK'.($indexJml + 21).':NW'.($indexJml + 21))->applyFromArray(
        array(
                'font' => array(
                    'color' => array('rgb' => '000000'),
                    'bold' => true,
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
            )
        );
    
    $objget->getStyle('R'.($indexJml + 2).':BZ'.($indexJml + 2))->applyFromArray( 
        array(
                'borders' => array(
                    'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                    )
                )
            )
        ); 

    $objget->getStyle('CA'.($indexJml + 2).':CC'.($indexJml + 2))->applyFromArray( 
        array(
                'borders' => array(
                    'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                    )
                )
            )
        ); 

    $objPHPExcel->getActiveSheet()->setTitle('TSKK'); 
    $objPHPExcel->setActiveSheetIndex(0);
    $filename = urlencode("TSKK_".$judul."_".$tanggal.".xlsx"); //FILE NAME//
    $filename = str_replace("+", " ", $filename);
    
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('./assets/upload/GeneratorTSKK/'.$filename);
    
    $arr = array(
        'url' =>    $filename
    );
    echo json_encode($arr);
    }
}

?>