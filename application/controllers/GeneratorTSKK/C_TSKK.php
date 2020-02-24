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
    $data = $this->M_gentskk->deleteElemen($id);      
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

    $data['lihat_header'] = $this->M_gentskk->selectHeader();
    // echo "<pre>"; print_r( $data['lihat_header']);exit();

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('GeneratorTSKK/V_ViewTSKK');
    $this->load->view('V_Footer',$data);
}

public function deleteData($id)
{
    $data = $this->M_gentskk->deleteHeader($id);
    $data = $this->M_gentskk->deleteTable($id);     
    redirect("GeneratorTSKK/ViewEdit");
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

    $data['lihat_semua'] = $this->M_gentskk->selectAll($id);
    // echo "<pre>"; print_r( $data['lihat_semua']);exit();

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('GeneratorTSKK/V_EditTSKK');
    $this->load->view('V_Footer',$data);
}

public function Display()
{
    $this->checkSession();
    $user_id = $this->session->userid;
    
    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';
    
    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('GeneratorTSKK/V_GenTSKK');
    $this->load->view('V_Footer',$data);
}

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
            "tipe_urutan"=>"" );
        }
    }

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('GeneratorTSKK/V_CreateTSKK');
    $this->load->view('V_Footer',$data);
}

public function saveObservation(){
    // echo "<pre>"; print_r($_POST); exit();
    $judul          = $this->input->post('txtTitle');
    $type 	        = $this->input->post('txtType');
    $kode_part 	    = $this->input->post('txtKodepart');
    $nama_part 	    = $this->input->post('txtNamaPart');
    $no_alat 	    = $this->input->post('txtNoAlat');
    $seksi 	        = $this->input->post('txtSeksi');
    $proses 	    = $this->input->post('txtProses');
    $kode_proses    = $this->input->post('txtKodeProses');
    $mesin 	        = $this->input->post('txtMesin');
    $proses_ke 	    = $this->input->post('txtProsesKe');
    $dari 	        = $this->input->post('txtDari');
    $tanggal        = $this->input->post('txtTanggal');
    $qty 	        = $this->input->post('txtQty');
    $operator 	    = $this->input->post('txtOperator');

    $saveHeader     = $this->M_gentskk->InsertHeaderTSKK($judul,$type,$kode_part,$nama_part,$no_alat,$seksi,$proses,$kode_proses,$mesin,$proses_ke,$dari,$tanggal,$qty,$operator);
    // exit();
    
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
    $tipe_urutan 	  = $this->input->post('slcTipeUrutan[]');
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

        $insert = $this->M_gentskk->saveObservation($data);
    }

    // $data['lihat_observasi'] = $this->M_gentskk->selectObservation($id);
    $data['lihat_hasilObservasi'] = $this->M_gentskk->getAllObservation($id);

    redirect('GeneratorTSKK/Generate/CreateTSKK');

}

public function resaveObservation(){
        
    $dataId = $this->M_gentskk->selectIdHeader();
    $id = $dataId[0]['id'];
    // echo"<pre>";print_r($_POST);exit();
    $judul          = $this->input->post('txtTitle');
    $type 	        = $this->input->post('txtType');
    $kode_part 	    = $this->input->post('txtKodepart');
    $nama_part 	    = $this->input->post('txtNamaPart');
    $no_alat 	    = $this->input->post('txtNoAlat');
    $seksi 	        = $this->input->post('txtSeksi');
    $proses 	    = $this->input->post('txtProses');
    $kode_proses    = $this->input->post('txtKodeProses');
    $mesin 	        = $this->input->post('txtMesin');
    $proses_ke 	    = $this->input->post('txtProsesKe');
    $dari 	        = $this->input->post('txtDari');
    $tanggal        = $this->input->post('txtTanggal');
    $qty 	        = $this->input->post('txtQty');
    $operator 	    = $this->input->post('txtOperator');

    $updateHeader = $this->M_gentskk->UpdateHeaderTSKK($id,$judul,$type,$kode_part,$nama_part,$no_alat,$seksi,$proses,$kode_proses,$mesin,$proses_ke,$dari,$tanggal,$qty,$operator);
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

public function kodePart()
{
    $variable = $this->input->GET('variable',TRUE);
    $variable = strtoupper($variable);  
    $kode = $this->M_gentskk->kodePart($variable);
    echo json_encode($kode);
} 

public function namaPart()
{   
    $variable = $this->input->GET('variable',TRUE);
    $variable = strtoupper($variable); 
    $kode = $this->M_gentskk->kodePart($variable);
    $kode_part = $_POST['kode']; //get data from js in array
    $kode_part = implode(" ", $kode_part);  //memecah data jadi string

    if (strlen($kode_part) < 18) { //menghitung jumlah huruf data string sebelumnya
        $kode_part = str_replace(' ', '', $kode_part); //ngereplace spasi jadi non spasi
        $kode_part = "'".$kode_part."'"; //ditambah petik 1 biar bisa dijalin di query
    }else{
        $kode_part = explode(" ",$kode_part); //menghilangkan spasi jadi array
		$kode_part = array_map(function ($kode_part) { return "'$kode_part'"; }, $kode_part); //ditambah petik di dalam array
		$kode_part = implode(" OR  msib.SEGMENT1 =",$kode_part); //nambah msib setiap awal data start data ke2
    }
    
$name = $this->M_gentskk->namaPart($kode_part); //jalankan query
// echo "<pre>";
// print_r($name);exit();
foreach($name as $key) { //mengeluarkan variable di array terakhir yg dibutuhkan
    $nama = $key['DESCRIPTION']; 
    $newArr[] = $nama; //variabel buat ngegabungin menjadi array 1D

    $desc = implode(", ",$newArr); //menjadikan string dan dipisahkan dengan koma
    // echo "<pre>"; print_r($namapekerja);
 }
$name = $desc; //isi $name uda jadi $decs yg berbentuk string
    
    if( ! empty($kode)){ 
        $callback = array(
         'status' => 'success', 
         'description' => $name,
         );
        }else{
        $callback = array('status' => 'failed'); 
        }
    echo json_encode($callback);
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

public function Kolom($jumlah){
    //KONVERSI ANGKA KE NAMA KOLOM
    $digitpertama = NULL;
    $digitkedua = NULL;
    $digitketiga = NULL;
    $jumlahdigit2 = NULL;
    $huruf1 = NULL;
    $huruf2 = NULL;
    $huruf3 = NULL;
    $jumlahdigit = floor($jumlah / 26);
    $digitketiga = $jumlah % 26;
    if($jumlahdigit > 26 && $jumlah != 702){ //3 DIGIT
       $jumlahdigit2 = $jumlahdigit / 26;
        if ($digitketiga != 0){
            $digitkedua = $jumlahdigit % 26;
            $digitpertama = floor($jumlahdigit2);
        } else {
            $digitkedua = ($jumlahdigit % 26)-1;
            if(floor($jumlahdigit2) == 1){
                $digitpertama = floor($jumlahdigit2);
            } else {
                $digitpertama = floor($jumlahdigit2)-1;
            }
            $digitketiga = 26;
        }
        if($digitkedua == 0){
            $digitkedua = 26;
        }
        $huruf1 = $this->AngkaToChar($digitpertama);
        $huruf2 = $this->AngkaToChar($digitkedua);
        $huruf3 = $this->AngkaToChar($digitketiga);
        return $huruf1.$huruf2.$huruf3;
    } else { //2 DIGIT
        if($digitketiga != 0){
            if ($jumlahdigit != 0){
                $digitpertama = $jumlahdigit;
            } else {
                $digitpertama = NULL;
            }
            $digitkedua = $digitketiga;
        } else {
            $digitpertama = $jumlahdigit-1;
            $digitkedua = 26;
            $digitketiga = 26;
        }
        if($digitkedua == 0){
            $digitkedua = 26;
        }   
        $huruf1 = $this->AngkaToChar($digitpertama);
        $huruf2 = $this->AngkaToChar($digitkedua);
        return $huruf1.$huruf2;
    }
}

public function deleteFile($id){

    $judul          = $this->input->post('judul');
    $tanggal        = $this->input->post('tanggal');

    unlink('./assets/upload/GeneratorTSKK/TSKK_'.$judul.'_'.$tanggal.'.xlsx');
}

public function exportExcel(){

    $this->load->library(array('Excel','Excel/PHPExcel/IOFactory')); 

    $dataId = $this->M_gentskk->selectIdHeader();
    $id = $dataId[0]['id'];

    //HEADER//
    //   echo "<pre>"; print_r($_POST); exit();
    $judul          = $this->input->post('judul');
    $type 	        = $this->input->post('type');
    $kode_part 	    = $this->input->post('kode_part');
    $nama_part 	    = $this->input->post('nama_part');
    $no_alat 	    = $this->input->post('no_alat');
    $seksi 	        = $this->input->post('seksi');
    $proses 	    = $this->input->post('proses');
    $kode_proses    = $this->input->post('kode_proses');
    $mesin 	        = $this->input->post('mesin');
    $proses_ke 	    = $this->input->post('proses_ke');
    $dari 	        = $this->input->post('dari');
    $tanggal        = $this->input->post('tanggal');
    $qty 	        = $this->input->post('qty');
    $operator 	    = $this->input->post('operator');

    $updateHeader = $this->M_gentskk->UpdateHeaderTSKK($id,$judul,$type,$kode_part,$nama_part,$no_alat,$seksi,$proses,$kode_proses,$mesin,$proses_ke,$dari,$tanggal,$qty,$operator);

    //dihapus duls ye, baru diinsert
    $deleteElement =  $this->M_gentskk->deleteObservation($id); 

    //DATA FOR OBSERVATION SHEET
    $waktu_1          = $this->input->post('waktu_1');
    $waktu_2          = $this->input->post('waktu_2');
    $waktu_3          = $this->input->post('waktu_3');
    $waktu_4          = $this->input->post('waktu_4');
    $waktu_5          = $this->input->post('waktu_5');
    $waktu_6          = $this->input->post('waktu_6');
    $waktu_7          = $this->input->post('waktu_7');
    $waktu_8          = $this->input->post('waktu_8');
    $waktu_9          = $this->input->post('waktu_9');
    $waktu_10         = $this->input->post('waktu_10');
    $x_min            = $this->input->post('x_min');
    $range            = $this->input->post('range');
    $waktu_distribusi = $this->input->post('waktu_distribusi');
    $waktu_kerja      = $this->input->post('waktu_kerja');
    $keterangan       = $this->input->post('keterangan');
    $takt_time        = $this->input->post('takt_time');
    //DATA FOR OBSERVATION SHEET AND ELEMENT TABLE
    $jenis_proses 	  = $this->input->post('jenis_proses');
    $elemen           = $this->input->post('elemen_kerja');
    $keterangan_elemen= $this->input->post('keterangan_elemen');
    $tipe_urutan 	  = $this->input->post('tipe_urutan');
    
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

    // $deleteElemenKerja = $this->M_gentskk->deleteElemen($id);     

       //TABLE ELEMENT//
       $start 	           = $this->input->post('mulai');
       $finish 	           = $this->input->post('finish');
       $waktu 	           = $this->input->post('waktu');

    //    echo "<pre>";print_r($start);exit();
       
       for ($i=0; $i < count($elemen); $i++) { 
           $data = array(
               'jenis_proses'  	    => $jenis_proses[$i],
               'elemen' 	        => $elemen[$i],
               'keterangan_elemen'  => $keterangan_elemen[$i],
               'tipe_urutan'   	    => $tipe_urutan[$i],
               'mulai' 	            => $start[$i],
               'finish' 	        => $finish[$i],
               'waktu' 	            => $waktu[$i],
               'id_tskk'       	    => $id
           );

           if ($data['jenis_proses'] != null) {
           $insert = $this->M_gentskk->tabelelemen($data); 
           }
       }
    
    //Make "elemen kerja" from combination of "elemen & keterangan"//
    $elemen_kerja =  array();

    for ($i=0; $i < count($elemen) ; $i++) { 
        $elemen_kerja[$i] = $elemen[$i]." ".$keterangan[$i];
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
                }else {
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
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(4);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(0.58);

      $indexSatu=11;
      $indexDua=11;
    
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

    //MERGING DETIK//
    $indexAngka = 11;
    $kolomA = $this->Kolom($indexAngka);
    $kolomB = $this->Kolom($indexAngka + $end);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomA.'12:'.$kolomB.'12');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolomA.'12', 'Detik');

    $objget->getStyle($kolomA.'12:'.$kolomB.'12')->applyFromArray(
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

      $val = 0;
      $kolomEnd = $this->Kolom($end + 11);

                    //STYLING HORIZONTAL ROWS//
                    $objget->getStyle('K8:'.$kolomEnd.(14))->applyFromArray(
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
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col1.'13',$val);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($col1.'13:'.$col2.'13');
                
                //STYLING THE LINE OF TIME FLOW//
                $objget->getStyle($col1.'13:'.$col2.(($jml_baris * 3) + 14))->applyFromArray(
                    array(
                        'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    )
                );
                //BELUM TENTU
                $objget->getStyle($col1.'13:'.$col2.'13')->applyFromArray(
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
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col2.'14', $i);
        $objPHPExcel->getActiveSheet()->getColumnDimension($col2)->setWidth(0.58);

            $indexDua++;
        $objPHPExcel->getActiveSheet()->getColumnDimension($col2)->setWidth(0.58);
    }

        //KELIPATAN 10//
            $indexAngka = 12;
            $indexKelipatan = 10;
       
            for ($angka=12; $angka < $jumlah+1; $angka++) { 

                $kolomA = $this->Kolom($indexAngka);
                $kolomB = $this->Kolom($indexAngka + 9);
              
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolomA.'13', $indexKelipatan);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomA.'13:'.$kolomB.'13');
                $objPHPExcel->getActiveSheet()->getColumnDimension($kolomB)->setWidth(0.58);

                $objget->getStyle($kolomA.'13:'.$kolomB.'13')->applyFromArray(
                    array(
                        'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                    )
                );

                $indexAngka += 10;
                $indexKelipatan +=10;
              
                    if ($indexAngka + 10 > ($jumlah) + 20) { //set the maximum 
                        break;
                    }
            }
    
    //ADD IMAGE QUICK FOR HEADER//

    $gdImage = imagecreatefrompng('assets/img/logo.png');
    // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
    $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
    $objDrawing->setName('Logo QUICK');$objDrawing->setDescription('Logo QUICK');
    $objDrawing->setImageResource($gdImage);
    $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
    $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
    $objDrawing->setCoordinates('C2');
    //set width, height
    $objDrawing->setWidth(50); 
    $objDrawing->setHeight(75); 
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 
    
// MERGING TO SET THE PAGE HEADER//
$objPHPExcel->getActiveSheet()->mergeCells('B2:I2');   //header title
$objPHPExcel->getActiveSheet()->mergeCells('B3:I3');   
$objPHPExcel->getActiveSheet()->mergeCells('B4:I4');
$objPHPExcel->getActiveSheet()->mergeCells('B5:I5');
$objPHPExcel->getActiveSheet()->mergeCells('B6:I6');
$objPHPExcel->getActiveSheet()->mergeCells('B7:I10');

$objPHPExcel->getActiveSheet()->mergeCells('B12:B14'); //NO
$objPHPExcel->getActiveSheet()->mergeCells('C12:F14'); //ELEMEN KERJA
$objPHPExcel->getActiveSheet()->mergeCells('G12:G14'); //MANUAL
$objPHPExcel->getActiveSheet()->mergeCells('H12:H14'); //AUTO
$objPHPExcel->getActiveSheet()->mergeCells('I12:I14'); //WALK

$objPHPExcel->getActiveSheet()->mergeCells('K2:AE4');   //kotak item
$objPHPExcel->getActiveSheet()->mergeCells('AF2:AZ4'); //Manual
$objPHPExcel->getActiveSheet()->mergeCells('BA2:BU4'); //kotak kuning
$objPHPExcel->getActiveSheet()->mergeCells('BV2:CP4'); //cycle time

$objPHPExcel->getActiveSheet()->mergeCells('K5:AE7');   //kotak ijo
$objPHPExcel->getActiveSheet()->mergeCells('AF5:AZ7');  //Auto (Mesin)
$objPHPExcel->getActiveSheet()->mergeCells('BA5:BU7'); //merah
$objPHPExcel->getActiveSheet()->mergeCells('BV5:CP7'); //takt time

$objPHPExcel->getActiveSheet()->mergeCells('K8:AE10');  //gelombang item
$objPHPExcel->getActiveSheet()->mergeCells('AF8:AZ10'); //jalan
$objPHPExcel->getActiveSheet()->mergeCells('BA8:BU10'); //panah merah
$objPHPExcel->getActiveSheet()->mergeCells('BV8:CP10'); //muda

$objPHPExcel->getActiveSheet()->mergeCells('CQ2:EX2'); //revisi
$objPHPExcel->getActiveSheet()->mergeCells('CQ3:CX3'); //no.
$objPHPExcel->getActiveSheet()->mergeCells('CQ4:CX4'); //no1.
$objPHPExcel->getActiveSheet()->mergeCells('CQ5:CX5'); //no2.
$objPHPExcel->getActiveSheet()->mergeCells('CQ6:CX6'); //no3.
$objPHPExcel->getActiveSheet()->mergeCells('CQ7:CX7'); //no4.
$objPHPExcel->getActiveSheet()->mergeCells('CQ8:CX8'); //no5.
$objPHPExcel->getActiveSheet()->mergeCells('CQ9:CX9'); //no6.
$objPHPExcel->getActiveSheet()->mergeCells('CQ10:CX10'); //no7.
$objPHPExcel->getActiveSheet()->mergeCells('CY3:EX3'); //detail
$objPHPExcel->getActiveSheet()->mergeCells('CY4:EX4'); //no1.
$objPHPExcel->getActiveSheet()->mergeCells('CY5:EX5'); //no2.
$objPHPExcel->getActiveSheet()->mergeCells('CY6:EX6'); //no3.
$objPHPExcel->getActiveSheet()->mergeCells('CY7:EX7'); //no4.
$objPHPExcel->getActiveSheet()->mergeCells('CY8:EX8'); //no5.
$objPHPExcel->getActiveSheet()->mergeCells('CY9:EX9'); //no6.
$objPHPExcel->getActiveSheet()->mergeCells('CY10:EX10'); //no7.

$objPHPExcel->getActiveSheet()->mergeCells('EY2:GE3'); //tanggal
$objPHPExcel->getActiveSheet()->mergeCells('EY4:GE4'); //no1.
$objPHPExcel->getActiveSheet()->mergeCells('EY5:GE5'); //no2.
$objPHPExcel->getActiveSheet()->mergeCells('EY6:GE6'); //no3.
$objPHPExcel->getActiveSheet()->mergeCells('EY7:GE7'); //no4.
$objPHPExcel->getActiveSheet()->mergeCells('EY8:GE8'); //no5.
$objPHPExcel->getActiveSheet()->mergeCells('EY9:GE9'); //no6.
$objPHPExcel->getActiveSheet()->mergeCells('EY10:GE10'); //no7.
$objPHPExcel->getActiveSheet()->mergeCells('EY10:GE10'); //no8.

$objPHPExcel->getActiveSheet()->mergeCells('GF2:HM2'); //TIPE
$objPHPExcel->getActiveSheet()->mergeCells('GF3:HM4'); //ISINYA TIPE
$objPHPExcel->getActiveSheet()->mergeCells('HN2:IU2'); //TAKT TIME
$objPHPExcel->getActiveSheet()->mergeCells('HN3:IU4'); //ISINYA TAKT TIME
$objPHPExcel->getActiveSheet()->mergeCells('GF5:IU5'); //NAMA PART
$objPHPExcel->getActiveSheet()->mergeCells('GF6:IU7'); //ISINYA NAMA PART
$objPHPExcel->getActiveSheet()->mergeCells('GF8:IU8'); //KODE PART
$objPHPExcel->getActiveSheet()->mergeCells('GF9:IU10'); //ISINYA KODE PART

$objPHPExcel->getActiveSheet()->mergeCells('IV2:KK2'); //SEKSI
$objPHPExcel->getActiveSheet()->mergeCells('IV3:KK3'); //ISI SEKSI
$objPHPExcel->getActiveSheet()->mergeCells('IV4:KK4'); //LINE
$objPHPExcel->getActiveSheet()->mergeCells('IV5:KK5'); //ISI LINE
$objPHPExcel->getActiveSheet()->mergeCells('IV6:KK6'); //JUMLAH OPERATOR
$objPHPExcel->getActiveSheet()->mergeCells('IV7:KK7'); //ISI JUMLAH OPERATOR
$objPHPExcel->getActiveSheet()->mergeCells('IV8:KK8'); //MENYETUJUI
$objPHPExcel->getActiveSheet()->mergeCells('IV9:KK10'); //ISI MENYETUJUI

$objPHPExcel->getActiveSheet()->mergeCells('KL2:MA2'); //JML MESIN
$objPHPExcel->getActiveSheet()->mergeCells('KL3:MA3'); //ISI JML MESIN
$objPHPExcel->getActiveSheet()->mergeCells('KL4:MA4'); //NO MESIN
$objPHPExcel->getActiveSheet()->mergeCells('KL5:MA5'); //ISI NO MESIN
$objPHPExcel->getActiveSheet()->mergeCells('KL6:MA6'); //ALAT BANTU
$objPHPExcel->getActiveSheet()->mergeCells('KL7:MA7'); //ISI ALAT BANTU
$objPHPExcel->getActiveSheet()->mergeCells('KL8:MA8'); //DIPERIKSA
$objPHPExcel->getActiveSheet()->mergeCells('KL9:MA10'); //ISI DIPERIKSA

$objPHPExcel->getActiveSheet()->mergeCells('MB2:NQ2'); //Proses Ke....dari....
$objPHPExcel->getActiveSheet()->mergeCells('MB3:NQ3'); //ISI Proses Ke....dari....
$objPHPExcel->getActiveSheet()->mergeCells('MB4:NQ4'); //Qty/Proses
$objPHPExcel->getActiveSheet()->mergeCells('MB5:NQ5'); //ISI Qty/Proses
$objPHPExcel->getActiveSheet()->mergeCells('MB6:NQ6'); //Tanggal
$objPHPExcel->getActiveSheet()->mergeCells('MB7:NQ7'); //ISI Tanggal
$objPHPExcel->getActiveSheet()->mergeCells('MB8:NQ8'); //Dibuat
$objPHPExcel->getActiveSheet()->mergeCells('MB9:NQ10'); //ISI Dibuat

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B3', 'PRODUCTION ENGINEERING')
            ->setCellValue('B4', 'CV KHS YOGYAKARTA')
            ->setCellValue('B5', 'Jl. Magelang No. 144 Yogyakarta 55241')
            ->setCellValue('B7', 'TABEL STANDAR KERJA KOMBINASI')
            ->setCellValue('AF2', 'Manual')
            ->setCellValue('AF5', 'Auto (Mesin)')
            ->setCellValue('AF8', 'Jalan')
            ->setCellValue('BV2', 'Cycle Time')
            ->setCellValue('BV5', 'Takt Time')
            ->setCellValue('BV8', 'Muda')

            ->setCellValue('B12', 'NO')
            ->setCellValue('C12', 'ELEMEN KERJA')

            ->setCellValue('G12', 'MANUAL')
            ->setCellValue('H12', 'AUTO')
            ->setCellValue('I12', 'WALK')

            ->setCellValue('CQ2', 'Revisi')
            ->setCellValue('CQ3', 'No.')
            ->setCellValue('CY3', 'Detail')

            ->setCellValue('EY2', 'Tanggal')

            ->setCellValue('GF2', 'Tipe')
            ->setCellValue('GF3', $type)
            ->setCellValue('HN2', 'Takt Time')
            ->setCellValue('HN3', $takt_time)
            ->setCellValue('GF5', 'Nama Part')
            ->setCellValue('GF6', $nama_part)
            ->setCellValue('GF8', 'Kode Part')
            ->setCellValue('GF9', $kode_part)

            ->setCellValue('IV2', 'Seksi')
            ->setCellValue('IV3', $seksi)
            ->setCellValue('IV4', 'Line')
            // ->setCellValue('IV5', $)
            ->setCellValue('IV6', 'Jumlah Operator')
            ->setCellValue('IV8', 'Menyetujui')

            ->setCellValue('KL2', 'Jml. Mesin')
            ->setCellValue('KL4', 'No. Mesin')
            ->setCellValue('KL5', $mesin)
            ->setCellValue('KL6', 'Alat Bantu')
            ->setCellValue('KL8', 'Diperiksa')

            ->setCellValue('MB2', 'Proses Ke....dari....')
            ->setCellValue('MB3', $proses_ke." dari ".$dari)
            ->setCellValue('MB4', 'Qty/Proses')
            ->setCellValue('MB5', $qty)
            ->setCellValue('MB6', 'Tanggal')
            ->setCellValue('MB7', $tanggal)
            ->setCellValue('MB8', 'Dibuat')

            ->setCellValue('U1', '');;

//STYLING TABLE HEADER OF THE CONTENT//
            $objget->getStyle('B12:B14')->applyFromArray(
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

            $objget->getStyle('C12:F14')->applyFromArray(
                array(
                    'font' => array(
                    'color'=> array('000000'),
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
                    )
                );
                    
            $objget->getStyle('G12:G14')->applyFromArray(
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
                    'color' => array('rgb' => '000000')
                    )
                )
            );

            $objget->getStyle('H12:H14')->applyFromArray(
                array(
                    'font' => array(
                    'color' => array('rgb' => '000000'),
                    'bold' => true,
                    'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
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

                $objget->getStyle('H12:H14')->applyFromArray(
                    array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                )   
                            )
                        )
                    );

            $objget->getStyle('I12:I14')->applyFromArray(
                array(
                    'font' => array(
                    'color' => array('rgb' => '000000'),
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
                            'color' => array('rgb' => '33ffff')
                        )
                    )
                );

// //STYLING TABLE INFORMATIONS//
            $objget->getStyle('B2:I6')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                            )
                        )
                );       

            $objget->getStyle('B7:I10')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                );   
                
            $objget->getStyle('K2:CP10')->applyFromArray(
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

            $objget->getStyle('CQ2:EX3')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
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

            $objget->getStyle('EY2:GE2')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
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

            //tipe
            $objget->getStyle('GF2:HM2')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        )
                ); 

            //takt time
            $objget->getStyle('HN2:IU2')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        )
                ); 

            //nama part
            $objget->getStyle('GF4:IU4')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        )
                ); 

            //kode part
            $objget->getStyle('GF7:IU7')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                        ),
                    )
                ); 

            $objget->getStyle('K2:AE4')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    )
                ); 

            //MANUAL, AUTO, JALAN, CT, TT, MUDA
            $objget->getStyle('AF2:CP10')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'font' => array(
                            'color' => array('rgb' => '000000'),
                            'bold' => true,
                        )
                    )
                ); 

            $objget->getStyle('BA2:BU4')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            $objget->getStyle('BV2:CP4')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 
                
            $objget->getStyle('K5:AE7')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            $objget->getStyle('AF5:AZ7')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            $objget->getStyle('BA5:BU7')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            $objget->getStyle('BV5:CP7')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                );   
                
            $objget->getStyle('K8:AE10')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                );  

            $objget->getStyle('AF8:AZ10')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            $objget->getStyle('BA8:BU10')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            $objget->getStyle('BV8:CP10')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 
                
            $objget->getStyle('CQ2:EX2')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            $objget->getStyle('CQ3:CX3')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            $objget->getStyle('CY3:EX3')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            $objget->getStyle('CQ4:EX10')->applyFromArray(
                array(
                        'borders' => array(
                        'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            $objget->getStyle('EY3:GE10')->applyFromArray(
                array(
                        'borders' => array(
                        'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            //TIPE DAN ISINYA
            $objget->getStyle('GF2:HM4')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    )
                ); 

            $objget->getStyle('GF3:HM4')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                            )
                    )
                );

            //TAKT TIME DAN ISINYA
            $objget->getStyle('HN2:IU4')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    )
                ); 

            $objget->getStyle('HN3:IU4')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                        ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                        )
                    )
                );   
                
            //NAMA PART DAN ISINYA
            $objget->getStyle('GF5:IU7')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    )
                ); 

            $objget->getStyle('GF6:IU7')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                            )
                    )
                ); 

            //KODE PART DAN ISINYA
            $objget->getStyle('GF8:IU10')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            // 'wraptext' => true
                        )
                    )
                ); 

            $objget->getStyle('GF9:IU10')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                        )
                    )
                ); 

            //SEKSI DAN ISINYA
            $objget->getStyle('IV2:KK3')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            // 'wraptext' => true
                        )
                    )
                ); 

            $objget->getStyle('IV3:KK3')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                            )
                    )
                ); 

            //LINE DAN ISINYA
            $objget->getStyle('IV4:KK5')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            // 'wraptext' => true
                        )
                    )
                ); 

            $objget->getStyle('IV5:KK5')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                            )
                    )
                );
                
            //JUMLAH OPERATOR DAN ISINYA
            $objget->getStyle('IV6:KK7')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            // 'wraptext' => true
                        )
                    )
                ); 

            $objget->getStyle('IV7:KK7')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                            )
                    )
                );

            //MENYETUJUI DAN ISINYA
            $objget->getStyle('IV8:KK10')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            // 'wraptext' => true
                        )
                    )
                ); 

            $objget->getStyle('IV9:KK10')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                            )
                    )
                );                

            //JML MESIN DAN ISINYA
            $objget->getStyle('KL2:MA3')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    )
                ); 

            $objget->getStyle('KL3:MA3')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                            )
                    )
                );

            //NO MESIN DAN ISINYA
            $objget->getStyle('KL4:MA5')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    )
                ); 

            $objget->getStyle('KL5:MA5')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                            )
                    )
                );  
                
            //ALAT BANTU DAN ISINYA
            $objget->getStyle('KL6:MA7')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    )
                ); 

            $objget->getStyle('KL7:MA7')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                            )
                    )
                );                   

            //DIPERIKSA DAN ISINYA
            $objget->getStyle('KL8:MA10')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    )
                ); 

            $objget->getStyle('KL9:MA10')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                            )
                    )
                );  

            //Proses Ke....dari.... DAN ISINYA
            $objget->getStyle('MB2:NQ3')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
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

            $objget->getStyle('KL9:MA10')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                            )
                    )
                );  

            //QTY/PROSES DAN ISINYA
            $objget->getStyle('MB4:NQ5')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    )
                ); 

            $objget->getStyle('MB5:NQ5')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                            )
                    )
                ); 
                
            //TANGGAL DAN ISINYA
            $objget->getStyle('MB6:NQ7')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    )
                ); 

            $objget->getStyle('MB7:NQ7')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                            )
                    )
                );  

            //DIBUAT DAN ISINYA
            $objget->getStyle('MB8:NQ10')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    )
                ); 

            $objget->getStyle('MB9:NQ10')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                            )
                    )
                );  

    //SET TAKT TIME ROWS
    $kolomMerah = $this->Kolom($takt_time + 11);
    $objget->getStyle($kolomMerah.'15:'.$kolomMerah.(($jml_baris * 3) + 14))->applyFromArray(
                array(
                    'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'eb4034')
                    )
                )
            );
    //SET TAKT TIME ROWS

    //SET THE VALUE OF TABLE CONTENT//
    $no = 1;
    $indexArr = 0;
    $defElementKerja = '';
    $indexElementKerja = 15;
    $indexHitam = 12;
    $indexHijau = 0;
    for ($i=15; $i < (15 + (sizeof($elemen_kerja) * 3))  ; $i+=3) { 
   
            $j = $jenis_proses[$indexArr];
            $tu = $tipe_urutan[$indexArr];
            $s = $start[$indexArr];
            $indexParalel = $s + 11;

                //STYLING
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexElementKerja.':B'.($indexElementKerja + 2)); //NOMOR
                $objPHPExcel->getActiveSheet()->mergeCells('C'.$indexElementKerja.':F'.($indexElementKerja + 2)); //ELEMEN
                $objPHPExcel->getActiveSheet()->mergeCells('G'.$indexElementKerja.':G'.($indexElementKerja + 2)); //MANUAL    
                $objPHPExcel->getActiveSheet()->mergeCells('H'.$indexElementKerja.':H'.($indexElementKerja + 2)); //AUTO
                $objPHPExcel->getActiveSheet()->mergeCells('I'.$indexElementKerja.':I'.($indexElementKerja + 2)); //WALK

                $objget->getStyle('G'.$indexElementKerja.':I'.($indexElementKerja + 2))->applyFromArray(
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

                    $objget->getStyle('B'.$indexElementKerja.':B'.($indexElementKerja + 2))->applyFromArray(
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

                    $objget->getStyle('C'.$indexElementKerja.':F'.($indexElementKerja + 2))->applyFromArray(
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

                    $kolomEnd = $this->Kolom($end + 11);
                    $objget->getStyle('L'.($indexElementKerja + 2).':'.$kolomEnd.($indexElementKerja + 2))->applyFromArray(
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
                            $objset->setCellValue("G".$indexElementKerja, $waktu[$indexArr]);
                                //TIME FLOW
                                $indexArrWaktu = 1;
                                $indexHitam = $s + 11;
                              
                                for ($angka = 0; $angka < $waktu[$indexArr]; $angka++) { 
                                    $kolom = $this->Kolom($indexHitam);
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                                    $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                        array(
                                            'font' => array(
                                            'color' => array('ffffff'),
                                            'bold' => true,
                                            ),
                                        )
                                    );
                                    //pararel
                                if ($angka == 0) {
                                    $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                        array(
                                            'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => 'a6a6a6')
                                            )
                                        )
                                    );
                                    //tambahin lagi di sini keknya
                                    // $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                    //     array(
                                    //         'fill' => array(
                                    //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    //         'color' => array('rgb' => 'a6a6a6')
                                    //         ),
                                    //     )
                                    // );
                                    //tambahin lagi di sini keknya
                                }
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

                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS (AT THE END)
                    if($angka == $waktu[$indexArr] -1 && $i != (15 + ((sizeof($elemen_kerja) - 1) * 3))){
                        $kolomAbu = $this->Kolom($indexHitam + 1);
                        $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                                    array(
                                        'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'a6a6a6')
                                        )
                                    )
                                );

                        // $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray( //gua uncomment nich buat paralel
                        //     array(
                        //         'fill' => array(
                        //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        //         'color' => array('rgb' => 'a6a6a6')
                        //         ),
                        //     )
                        // );

                    }
                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS (AT THE END)
    
                                $indexArrWaktu++;
                                $indexHitam++;
                                } 
    
                                $objset->setCellValue("B".$indexElementKerja, $no++);
                                $objset->setCellValue("C".$indexElementKerja, $elemen_kerja[$indexArr]);
                                $indexArr++;
                                   
                                continue;
                        }

                        $objset->setCellValue("G".$indexElementKerja, $waktu[$indexArr]);
                            
                                //TIME FLOW
                                $indexArrWaktu = 1;
                                for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                                    $kolom = $this->Kolom($indexHitam);
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                                $indexArrWaktu++;
                                $indexHitam++;
                                } 
                                $indexArr++;
                                continue;
                            
                    } 

                     if ($i !== 15) {$indexElementKerja += 3;}

                //STYLING
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexElementKerja.':B'.($indexElementKerja + 2)); //NOMOR
                $objPHPExcel->getActiveSheet()->mergeCells('C'.$indexElementKerja.':F'.($indexElementKerja + 2)); //ELEMEN
                $objPHPExcel->getActiveSheet()->mergeCells('G'.$indexElementKerja.':G'.($indexElementKerja + 2)); //MANUAL    
                $objPHPExcel->getActiveSheet()->mergeCells('H'.$indexElementKerja.':H'.($indexElementKerja + 2)); //AUTO
                $objPHPExcel->getActiveSheet()->mergeCells('I'.$indexElementKerja.':I'.($indexElementKerja + 2)); //WALK

                $objget->getStyle('G'.$indexElementKerja.':I'.($indexElementKerja + 2))->applyFromArray(
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

                    $objget->getStyle('B'.$indexElementKerja.':B'.($indexElementKerja + 2))->applyFromArray(
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

                    $objget->getStyle('C'.$indexElementKerja.':F'.($indexElementKerja + 2))->applyFromArray(
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
                        $objset->setCellValue("G".$indexElementKerja, $waktu[$indexArr]);

                            //TIME FLOW
                            $indexArrWaktu = 1;
                            $indexHitam = $s + 11; 
                            for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                                
                                $kolom = $this->Kolom($indexHitam);
                                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                                $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                    array(
                                        'font' => array(
                                        'color' => array('ffffff')
                                        )
                                    )
                                );
                                //pararel
                                if ($angka == 0) {
                                    $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                        array(
                                            'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => 'a6a6a6')
                                            ),
                                        )
                                    );
                                }
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

                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                    if($angka == $waktu[$indexArr] -1 && $i != (15 + ((sizeof($elemen_kerja) - 1) * 3))){
                        $kolomAbu = $this->Kolom($indexHitam + 1);
                        $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                                    array(
                                        'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'a6a6a6')
                                        )
                                    )
                                );
                        $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray(
                            array(
                                'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'a6a6a6')
                                )
                            )
                        );
                    }
                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                                
                            $indexArrWaktu++;
                            $indexHitam++;
                            } 

                            $objset->setCellValue("B".$indexElementKerja, $no++);
                            $objset->setCellValue("C".$indexElementKerja, $elemen_kerja[$indexArr]);
                            $indexArr++;
                               
                            continue;
                    }

                    $objset->setCellValue("G".$indexElementKerja, $waktu[$indexArr]);
                    //TIME FLOW MANUAL
                    $indexArrWaktu = 1;
                    for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                        $kolom = $this->Kolom($indexHitam); 
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

                     if ($angka == 0) {
                        $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                            array(
                                'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'a6a6a6')
                                )
                            )
                        );
                    }
                    
                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                    if($angka == $waktu[$indexArr] - 1 && $i != (15 + ((sizeof($elemen_kerja) - 1) * 3)) ){ 
                        $kolomAbu = $this->Kolom($indexHitam + 1);
                        $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                                    array(
                                        'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'a6a6a6')
                                        )
                                    )
                                );
                        // $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray( //gua uncomment nich 
                        //     array(
                        //         'fill' => array(
                        //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        //         'color' => array('rgb' => 'a6a6a6')
                        //         ),
                        //     )
                        // );
                    }elseif ($angka == 0 && $i != 15) {
                        $objget->getStyle($kolomAbu.($indexElementKerja ))->applyFromArray(
                            array(
                                'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'a6a6a6')
                                )
                            )
                        );
                    }
                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS

                    $indexArrWaktu++;
                    $indexHitam++;
                    }
                    // echo $indexHitam;die(); 

            }elseif ($j == 'AUTO (Inheritance)') {
                    if ($elemen_kerja[$indexArr] == $defElementKerja){

                        $objset->setCellValue("H".$indexElementKerja, $waktu[$indexArr]);
                        
                        //TIME FLOW//
                        $indexHijau = $indexHitam;
                        for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                            $kolom = $this->Kolom($indexHijau);
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

                        $indexHijau++;
                        } 
                        $indexArr++;
                        continue;
                   
                    } 
                    // if ($i !== 9) {$indexElementKerja += 3;}
                    $objset->setCellValue("H".$indexElementKerja, $waktu[$indexArr]);

                        //TIME FLOW//
                        $indexHijau = $indexHitam;
                        for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                            $kolom = $this->Kolom(($indexParalel));
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

                        $indexParalel++;
                        } 
                        $indexArr++;
                        continue;
            
            }else if ($j == "AUTO") {

                    if ($elemen_kerja[$indexArr] == $defElementKerja){

                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS (AT THE END)
                    if($angka == $waktu[$indexArr] -1 && $i != (15 + ((sizeof($elemen_kerja) - 1) * 3))){
                        $kolomAbu = $this->Kolom($indexHitam + 1);
                        $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                                    array(
                                        'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'a6a6a6')
                                        )
                                    )
                                );
    
                                $objset->setCellValue("B".$indexElementKerja, $no++);
                                $objset->setCellValue("C".$indexElementKerja, $elemen_kerja[$indexArr]);
                                $indexArr++;
                                   
                                continue;
                        }

                        $objset->setCellValue("H".$indexElementKerja, $waktu[$indexArr]);
                            
                                //TIME FLOW
                                $indexArrWaktu = 1;
                                for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                                    $kolom = $this->Kolom($indexHitam);
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                                $indexArrWaktu++;
                                $indexHitam++;
                                } 
                                $indexArr++;
                                continue;
                            
                    } 

                     if ($i !== 15) {$indexElementKerja += 3;}

                    $objset->setCellValue("H".$indexElementKerja, $waktu[$indexArr]);
                    //TIME FLOW MANUAL
                    $indexArrWaktu = 1;
                    for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                        $kolom = $this->Kolom($indexHitam); 
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                     //GREEN STYLING//
                     $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                         array(
                             'fill' => array(
                             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                             'color' => array('rgb' => '00ff00')
                             )
                         )
                     );

                     if ($angka == 0) {
                        $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                            array(
                                'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'a6a6a6')
                                )
                            )
                        );
                    }
                    
                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                    if($angka == $waktu[$indexArr] - 1 && $i != (15 + ((sizeof($elemen_kerja) - 1) * 3)) ){ 
                        $kolomAbu = $this->Kolom($indexHitam + 1);
                        $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                                    array(
                                        'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'a6a6a6')
                                        )
                                    )
                                );
                        $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray( //gua uncomment nich 
                            array(
                                'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'a6a6a6')
                                ),
                            )
                        );
                    }elseif ($angka == 0 && $i != 15) {
                        $objget->getStyle($kolomAbu.($indexElementKerja ))->applyFromArray(
                            array(
                                'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'a6a6a6')
                                )
                            )
                        );
                    }
                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS

                    $indexArrWaktu++;
                    $indexHitam++;
                    }
                    // echo $indexHitam;die(); 

            }else if ($j == "WALK (Inheritance)"){

                if ($elemen_kerja[$indexArr] == $defElementKerja){

                    //STYLING
                    $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexElementKerja.':B'.($indexElementKerja + 2)); //NOMOR
                    $objPHPExcel->getActiveSheet()->mergeCells('C'.$indexElementKerja.':F'.($indexElementKerja + 2)); //ELEMEN
                    $objPHPExcel->getActiveSheet()->mergeCells('G'.$indexElementKerja.':G'.($indexElementKerja + 2)); //MANUAL    
                    $objPHPExcel->getActiveSheet()->mergeCells('H'.$indexElementKerja.':H'.($indexElementKerja + 2)); //AUTO
                    $objPHPExcel->getActiveSheet()->mergeCells('I'.$indexElementKerja.':I'.($indexElementKerja + 2)); //WALK
    
                    $objget->getStyle('G'.$indexElementKerja.':I'.($indexElementKerja + 2))->applyFromArray(
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
    
                        $objget->getStyle('B'.$indexElementKerja.':B'.($indexElementKerja + 2))->applyFromArray(
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
    
                        $objget->getStyle('C'.$indexElementKerja.':F'.($indexElementKerja + 2))->applyFromArray(
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
                            $objset->setCellValue("I".$indexElementKerja, $waktu[$indexArr]);
                                //TIME FLOW
                                $indexArrWaktu = 1;
                                $indexHitam = $s + 11;
                                for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                                    $kolom = $this->Kolom($indexParalel);
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);
                                    
                                     //BLACK STYLING//
                                     $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                        array(
                                            'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '808080')
                                            )
                                        )
                                    );
    
                                $indexArrWaktu++;
                                $indexParalel++;
                                } 
    
                                $objset->setCellValue("B".$indexElementKerja, $no++);
                                $objset->setCellValue("C".$indexElementKerja, $elemen_kerja[$indexArr]);
                                $indexArr++;
                                   
                                continue;
                        }
    
                            $objset->setCellValue("I".$indexElementKerja, $waktu[$indexArr]);
                            
                            //TIME FLOW//
                            $indexHijau = $indexHitam;
                            for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                                $kolom = $this->Kolom($indexHijau);
                                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), ($angka + 1));
    
                            //GREY STYLING//
                            $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                array(
                                    'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '808080')
                                    )
                                )
                            );   
    
                            $indexHijau++;
                            $indexHitam++;
                            } 
                            $indexArr++;
                            continue;
                       
                        } 
                        // if ($i !== 9) {$indexElementKerja += 3;}
                        $objset->setCellValue("I".$indexElementKerja, $waktu[$indexArr]);
    
                            //TIME FLOW//
                            $indexHijau = $indexHitam;
                            for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                                $kolom = $this->Kolom(($indexParalel - 1));
                                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), ($angka + 1));
                            
                            //GREEN STYLING//
                            $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                array(
                                    'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '808080')
                                    )
                                )
                            );   
    
                            $indexParalel++;
                            } 
                            $indexArr++;
                            continue;

            }else{
                    if ($elemen_kerja[$indexArr] == $defElementKerja){

                        $objset->setCellValue("I".$indexElementKerja, $waktu[$indexArr]);

                    //TIME FLOW//
                    for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                        $kolom = $this->Kolom($indexHitam);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), ($angka + 1));
                
                    //GREY STYLING//
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

                    $indexHitam++;
                    } 
                    $indexArr++;
                    continue;

                    } 
                    if ($i !== 15) {$indexElementKerja += 3;}

                    $objset->setCellValue("I".$indexElementKerja, $waktu[$indexArr]);

                        //TIME FLOW WALK
                        $indexArrAbu = 1;
                        for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                            $kolom = $this->Kolom($indexHitam);
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrAbu);
                    
                        //GREY STYLING//
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

                        //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                        if($angka == $waktu[$indexArr] -1 && $i != (15 + ((sizeof($elemen_kerja) - 1) * 3))){
                            $kolomAbu = $this->Kolom($indexHitam + 1);
                            $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                                        array(
                                            'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => 'a6a6a6')
                                            )
                                        )
                                    );
                            $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray(
                                array(
                                    'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => 'a6a6a6')
                                    )
                                )
                            );
                        }
                        //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS

                        $indexHitam++;
                        $indexArrAbu++;
                        $indexParalel++;
                    }
            }

            if($elemen_kerja[$indexArr] != $defElementKerja){
                //STYLING
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexElementKerja.':B'.($indexElementKerja + 2)); //NOMOR
                $objPHPExcel->getActiveSheet()->mergeCells('C'.$indexElementKerja.':F'.($indexElementKerja + 2)); //ELEMEN
                $objPHPExcel->getActiveSheet()->mergeCells('G'.$indexElementKerja.':G'.($indexElementKerja + 2)); //MANUAL    
                $objPHPExcel->getActiveSheet()->mergeCells('H'.$indexElementKerja.':H'.($indexElementKerja + 2)); //AUTO
                $objPHPExcel->getActiveSheet()->mergeCells('I'.$indexElementKerja.':I'.($indexElementKerja + 2)); //WALK

                $objget->getStyle('G'.$indexElementKerja.':I'.($indexElementKerja + 2))->applyFromArray(
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

                    $objget->getStyle('B'.$indexElementKerja.':B'.($indexElementKerja + 2))->applyFromArray(
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

                    $objget->getStyle('C'.$indexElementKerja.':F'.($indexElementKerja + 2))->applyFromArray(
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
                $objset->setCellValue("B".$indexElementKerja, $no++);
                $objset->setCellValue("C".$indexElementKerja, $elemen_kerja[$indexArr]);
            }
            $defElementKerja = $elemen_kerja[$indexArr];
            $indexArr++;
        };//die();
        $objPHPExcel->getActiveSheet()->mergeCells('C12:F13'); //ELEMEN KERJA

        //SET TOTAL TIMES//
        $indexJml = $indexElementKerja + 3;
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexJml.':F'.($indexJml + 2)); 
        $objset->setCellValue("B".$indexJml, "JUMLAH");
        $objPHPExcel->getActiveSheet()->mergeCells('G'.$indexJml.':G'.($indexJml + 1)); 
        $objset->setCellValue("G".$indexJml, $jumlah_manual);
        $objPHPExcel->getActiveSheet()->mergeCells('H'.$indexJml.':H'.($indexJml + 1)); 
        $objset->setCellValue("H".$indexJml, $jumlah_auto);
        $objPHPExcel->getActiveSheet()->mergeCells('I'.$indexJml.':I'.($indexJml + 1)); 
        $objset->setCellValue("I".$indexJml, $jumlah_walk);
        $objPHPExcel->getActiveSheet()->mergeCells('G'.($indexJml + 2).':I'.($indexJml + 2)); 
        $objset->setCellValue("G".($indexJml + 2), $jumlah);
        
        //STYLING OF TOTAL TIMES//
        $objget->getStyle('B'.$indexJml.':F'.($indexJml + 2))->applyFromArray(
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

        $objget->getStyle('G'.$indexJml.':G'.($indexJml + 1))->applyFromArray(
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


        $objget->getStyle('H'.$indexJml.':H'.($indexJml + 1))->applyFromArray(
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

        $objget->getStyle('I'.$indexJml.':I'.($indexJml + 1))->applyFromArray(
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

        $objget->getStyle('G'.($indexJml + 2).':I'.($indexJml + 2))->applyFromArray(
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

    // //     //SET IRREGULAR JOB//
    //     $indexIrregular = $indexJml + 4;
    //     $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexIrregular.':B'.($indexIrregular + 2)); 
    //     $objset->setCellValue("B".$indexIrregular, "NO");
    //     $objPHPExcel->getActiveSheet()->mergeCells('C'.$indexIrregular.':F'.($indexIrregular + 2)); 
    //     $objset->setCellValue("C".$indexIrregular, "Irregular Job");
    //     $objPHPExcel->getActiveSheet()->mergeCells('G'.$indexIrregular.':G'.($indexIrregular + 1)); 
    //     $objset->setCellValue("G".$indexIrregular, "Ratio");
    //     $objPHPExcel->getActiveSheet()->mergeCells('H'.$indexIrregular.':H'.($indexIrregular + 1)); 
    //     $objset->setCellValue("H".$indexIrregular, "Waktu");
    //     $objPHPExcel->getActiveSheet()->mergeCells('I'.$indexIrregular.':I'.($indexIrregular + 1));
    //     $objset->setCellValue("I".$indexIrregular, "Waktu/Ratio");
    //     $objPHPExcel->getActiveSheet()->mergeCells('G'.($indexIrregular + 2).':G'.($indexIrregular + 2)); 
    //     $objset->setCellValue("G".($indexIrregular + 2), "Kali");
    //     $objPHPExcel->getActiveSheet()->mergeCells('H'.($indexIrregular + 2).':I'.($indexIrregular + 2)); 
    //     $objset->setCellValue("H".($indexIrregular + 2), "Detik");
    //     //buat isinye irregular job ye//
    //     $objPHPExcel->getActiveSheet()->mergeCells('B'.($indexIrregular + 3).':H'.($indexIrregular + 4)); 
    //     $objset->setCellValue("B".($indexIrregular + 3), "JUMLAH");
    //     $objPHPExcel->getActiveSheet()->mergeCells('I'.($indexIrregular + 3).':I'.($indexIrregular + 4)); 
    //     $objset->setCellValue("I".($indexIrregular + 3), " ");

    //     //STYLING IRREGULAR JOBS//
    //     $objget->getStyle('B'.$indexIrregular.':F'.($indexIrregular + 2))->applyFromArray(
    //         array(
    //                 'borders' => array(
    //                 'allborders' => array(
    //                 'style' => PHPExcel_Style_Border::BORDER_THIN
    //                     )
    //                 ),
    //                 'alignment' => array(
    //                     'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //                     'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    //                 ),
    //                 'fill' => array(
    //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
    //                     'color' => array('rgb' => 'ff00ff')
    //                     )
    //             )
    //         ); 

    //     $objget->getStyle('G'.$indexIrregular.':I'.($indexIrregular + 2))->applyFromArray(
    //         array(
    //                 'borders' => array(
    //                 'allborders' => array(
    //                 'style' => PHPExcel_Style_Border::BORDER_THIN
    //                     )
    //                 ),
    //                 'alignment' => array(
    //                     'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //                     'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    //                 ),
    //                 'fill' => array(
    //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
    //                     'color' => array('rgb' => 'f3e6ff')
    //                     )
    //             )
    //         ); 

    //     $objget->getStyle('B'.($indexIrregular + 3).':H'.($indexIrregular + 4))->applyFromArray(
    //         array(
    //                 'borders' => array(
    //                 'allborders' => array(
    //                 'style' => PHPExcel_Style_Border::BORDER_THIN
    //                     )
    //                 ),
    //                 'alignment' => array(
    //                     'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //                     'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    //                 ),
    //             )
    //         ); 

    //     $objget->getStyle('I'.($indexIrregular + 3).':I'.($indexIrregular + 4))->applyFromArray(
    //         array(
    //                 'borders' => array(
    //                 'allborders' => array(
    //                 'style' => PHPExcel_Style_Border::BORDER_THIN
    //                     )
    //                 ),
    //                 'alignment' => array(
    //                     'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //                     'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    //                 )
    //                 // $objPHPExcel->getAlignment()->setWrapText(true);
    //             )
    //         ); 

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