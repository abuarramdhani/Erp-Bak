<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_EditTSKK extends CI_Controller {

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

	//need attention
	public function resaveEditObservation($id){

		//HEADER
		$judul            = $this->input->post('txtTitle');
		$takt_time        = $this->input->post('taktTime');
		$nd               = $this->input->post('inputInsert');
		//PART
		$jenis_inputPart  = $this->input->post('terdaftar');
		$type 	          = $this->input->post('txtType');
		// echo $type;die;
		if ($type == null) {
			$type 	          = $this->input->post('txtTypeT');
		}else{
			$type 	          = $this->input->post('txtType');
		}

		$kode_part 	      = $this->input->post('txtKodepart[]');
		if ($kode_part == null) {
			$kode 	          = $this->input->post('txtKodepartT');
		}else{
			$kode_part 	      = $this->input->post('txtKodepart[]');
			$kode = implode(", ", $kode_part);
		}

		$nama_part 	      = $this->input->post('txtNamaPart');
		if ($nama_part == null) {
			$nama_part 	          = $this->input->post('txtNamaPartT');
		}else{
			$nama_part 	      = $this->input->post('txtNamaPart');
		}
		
		//EQUIPMENT
		$jenis_inputEquipment  = $this->input->post('equipmenTerdaftar');
		$no_mesin	      	   = $this->input->post('txtNoMesin[]');
		$no_mesin 		  	   = implode("; ", $no_mesin);
		$jenis_mesin      = $this->input->post('txtJenisMesin[]');
		$jm = implode("; ", $jenis_mesin);
		$jenis_mesin = trim(preg_replace('/\s\s+/', ' ', $jm));

		$resource         = $this->input->post('txtResource[]');
		$rsc = implode("; ", $resource);
		$resource = trim(preg_replace('/\s\s+/', '; ', $rsc));
		$line             = $this->input->post('txtLine');		
		$alat_bantu	      = $this->input->post('txtAlatBantu[]');
		if ($alat_bantu == null) {
			$alat_bantu	      = $this->input->post('txtAlatBantuT');
		}else {
			$alat_bantu	      = $this->input->post('txtAlatBantu[]');
			$alat_bantu = implode("; ", $alat_bantu);
		}
		$tools            = $this->input->post('txtTools[]');
		if ($tools == null) {
			$tools            = $this->input->post('txtToolsT');
		}else {
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
		// die;	
		$qty 	          = $this->input->post('txtQtyProses');
		// exit();
		//SEKSI PEMBUAT
		$noind = $this->session->user;
		$data['getSeksiUnit'] = $this->M_gentskk->detectSeksiUnit($noind);
		$split = $data['getSeksiUnit'][0];
		$seksi_pembuat = $split['seksi'];
		$noind = $this->session->user;
		$name = $this->M_gentskk->selectNamaPekerja($noind);
		$nama_pekerja = $name[0]['nama'];
		$sang_pembuat = $noind." - ".$nama_pekerja;
		$creationDate = date('Y/m/d h:i:s', time());
		
			if ($nd == null) {
				$nilai_distribusi = 0;
			}else{
				$nilai_distribusi = $nd;
			}

		$updateHeader = $this->M_gentskk->UpdateHeaderTSKK($id,$judul,$type,$kode,$nama_part,$seksi,
					  $proses,$kode_proses,$jenis_mesin,$proses_ke,$dari,$tanggal,$qty,$nm,
					  $nilai_distribusi,$takt_time,$no_mesin,$resource,$line,$alat_bantu,$tools,
					  $jml_operator,$dr_operator,$seksi_pembuat,$jenis_inputPart,$jenis_inputEquipment,
					  $sang_pembuat,$creationDate);
		
		//LEMBAR OBSERVASI ELEMEN KERJA
		$deleteElement 	  = $this->M_gentskk->deleteObservation($id); 
	
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
	
			// if (array_key_exists($i,$tipe_urutan)){
			// 	$tu            = $tipe_urutan[$i];
			// }else{
			// 	$tu 	       = 'SERIAL';
			// }
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
				// echo"<pre>";print_r($data);
			if ($data['jenis_proses'] != null) {
				$insert = $this->M_gentskk->saveObservation($data);
			}
		}

		//IRREGULAR JOBS
		$deleteIrregularJobs =  $this->M_gentskk->deleteIrregularJobs($id); 	

		$irregular_jobs  = $this->input->post('txtIrregularJob[]');
		$ratio_irregular = $this->input->post('txtRatioIrregular[]');
		$waktu_irregular = $this->input->post('txtWaktuIrregular[]');
		$hasil_irregular = $this->input->post('txtHasilWaktuIrregular[]');
	
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

		//UPDATE TAKT TIME CALCULATION
		$waktu_satu_shift   = $this->input->post('txtWaktu1Shift');
		$jumlah_shift       = $this->input->post('txtJumlahShift');
		$forecast           = $this->input->post('txtForecast');
		$qty_unit           = $this->input->post('txtQtyUnit');
		$rencana_produksi   = $this->input->post('txtForecast');
		$jumlah_hari_kerja  = $this->input->post('txtJumlahHariKerja');

		$checkTaktTime = $this->M_gentskk->selectTaktTimeCalculation($id);
		// echo"<pre>";print_r($checkTaktTime);die;
		if (!empty($checkTaktTime)) {
			$updateTaktTime = $this->M_gentskk->updateTaktTime($id,$waktu_satu_shift,$jumlah_shift,$forecast,$qty_unit,$rencana_produksi,$jumlah_hari_kerja);
		}else{
			$insertTaktTime = $this->M_gentskk->saveTaktTime($id,$waktu_satu_shift,$jumlah_shift,$forecast,$qty_unit,$rencana_produksi,$jumlah_hari_kerja);
		}

		// exit();
	
		redirect('GeneratorTSKK/Generate/');
	}

	public function ReCreateTSKK($id)
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
		$data['status'] = 1;
		$data['lihat_tabelElemen_Edit'] = $this->M_gentskk->getAllElementsWhenEdit($id); //TE

		$data['lihat_hasilObservasi_elemen'] = $this->M_gentskk->getAllObservation($id); //TO

		$data['lihat_hasilObservasi'] = $this->M_gentskk->getAllObservation($id);
		// echo"<pre>";print_r($data['lihat_tabelElemen_Edit']);exit();		

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
    	
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneratorTSKK/V_EditTSKK');
		$this->load->view('V_Footer',$data);
	}

}
?>