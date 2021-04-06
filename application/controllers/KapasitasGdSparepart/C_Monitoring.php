<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoring extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('KapasitasGdSparepart/M_monitoring');
        date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession(){
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring Kapasitas Gudang';
		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$date 	= date('d/m/Y');
		$tgl 	= date('d-M-Y');
		$query1 = "where TO_CHAR(jam_input,'DD/MM/YYYY') between '$date' and '$date'";
		$dataMon = $this->M_monitoring->getDataSPB($query1);
		$data['dospb'] = $dataMon;
		$data['jml_spb'] = count($dataMon);
		$pcs = 0;
		for ($p=0; $p < count($dataMon) ; $p++) { 
			$pcs += $dataMon[$p]['JUMLAH_PCS'];
		}
		$data['dopcs'] = $pcs;
		// echo "<pre>";print_r($pcs);exit();

		$query2 = "where TO_CHAR(selesai_pelayanan,'DD/MM/YYYY') between '$date' and '$date' and selesai_pelayanan is not null and (bon != 'PENDING' or bon is null)";
		$pelayanan 	= $this->M_monitoring->getDataSPB($query2);
		$data['pelayanan'] 	= $pelayanan;
		$data['jml_pelayanan'] = count($pelayanan);
		$kurang = "where TO_CHAR(jam_input,'DD/MM/YYYY') between '$date' and '$date' and trunc(selesai_pelayanan) > '$tgl' or selesai_pelayanan is null and (bon != 'PENDING' or bon is null)";
		$data['krgpelayanan'] = $this->M_monitoring->dataKurang($kurang);
		$data['krg_pelayanan'] = count($data['krgpelayanan']);

		$query3 = "where TO_CHAR(selesai_pengeluaran,'DD/MM/YYYY') between '$date' and '$date' and selesai_pengeluaran is not null";
		$pengeluaran = $this->M_monitoring->getDataSPB($query3);
		$data['pengeluaran'] = $pengeluaran;
		$data['jml_pengeluaran'] = count($pengeluaran);
		$kurang = "where selesai_pelayanan is not null and selesai_pengeluaran is null and (bon != 'BON' or bon is null)";
		$data['krgpengeluaran'] = $this->M_monitoring->dataKurang($kurang);
		$data['krg_pengeluaran'] = count($data['krgpengeluaran']);

		$query4 = "where TO_CHAR(selesai_packing,'DD/MM/YYYY') between '$date' and '$date' and selesai_packing is not null";
		$packing = $this->M_monitoring->getDataSPB($query4);
		$data['packing'] = $packing;
		$data['jml_packing'] = count($packing);
		$kurang = "where selesai_pengeluaran is not null and selesai_packing is null and (bon is null or bon = 'BEST')";
		$data['krgpacking'] = $this->M_monitoring->dataKurang($kurang);
		$data['krg_packing'] = count($data['krgpacking']);

		$jml_gd = $this->M_monitoring->getjmlGd($date);
		$data['jml_gd'] = count($jml_gd);

		$cancel = $this->M_monitoring->getcancel($date, $date);
		$data['cancel'] = count($cancel);
		
		$jumlah = array(); $jmlitem = 0;
		for ($i=0; $i < $data['jml_packing'] ; $i++) { 
			$cari = $this->M_monitoring->getTransact($packing[$i]['NO_DOKUMEN']);
			for ($a=0; $a < count($cari) ; $a++) { 
				array_push($jumlah, $cari[$a]['TRANSACTION_QUANTITY']);
			}
			$jmlitem += count($cari);
		}
		$data['jml_selesai'] 		= $data['jml_packing'];
		$data['jml_item_selesai'] 	= $jmlitem;
		$data['jml_pcs_selesai'] 	= array_sum($jumlah);
		$krg = $this->M_monitoring->dataKurangselesai($date, $date);
		$kkrg = 0;
		for ($i=0; $i < count($krg); $i++) { 
			if ($krg[$i]['KURANG'] == '') {
				$kkrg += $krg[$i]['QUANTITY'];
			}else {
				$kkrg += $krg[$i]['KURANG'];
			}
		}
		$cacl = $this->M_monitoring->diCancel($date, $date);
		$kccl = 0;
		for ($i=0; $i < count($cacl); $i++) { 
			$kccl += $cacl[$i]['QUANTITY'];
		}
		$data['krg_selesai'] = $kkrg + $kccl;
		// echo "<pre>"; print_r($data['krg_selesai']); exit();
		// $data['krg_selesai'] = $total - $data['jml_selesai'];

		$htgcoly = $this->jaditoo($packing);

		$data['jml_colly'] = $htgcoly['dus_kecil'] + $htgcoly['dus_sdg'] + $htgcoly['dus_pjg'] + $htgcoly['karung'] + $htgcoly['peti'];
		$data['dus_kecil'] = $htgcoly['dus_kecil'];
		$data['dus_sdg'] = $htgcoly['dus_sdg'];
		$data['dus_pjg'] = $htgcoly['dus_pjg'];
		$data['karung'] = $htgcoly['karung'];
		$data['peti'] = $htgcoly['peti'];
		
		// echo "<pre>"; print_r($dus_kecil); exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KapasitasGdSparepart/V_Monitoring', $data);
		$this->load->view('V_Footer',$data);
	}

	public function searchSPB(){
		$tglAwl = $this->input->post('tglAwl');
		$tglAkh = $this->input->post('tglAkh');

		$tanggal1 	= new DateTime($tglAwl);
		$tanggal2 	= new DateTime($tglAkh);
		$end 		= $tanggal2->modify('+1 day'); 
		$interval 	= new DateInterval('P1D');
		$daterange 	= new DatePeriod($tanggal1, $interval ,$end);
		$i = 0;
		foreach ($daterange as $date) {
			$tanggal[$i] 	= $date->format("d/m/Y");
			$tgl[$i] 		= $date->format("d-M-Y");
			$i++;
		}
		$data['tglAwal'] = $tanggal[0];
		$x = count($tanggal) -1;
		$data['tglAkhir'] = $tanggal[$x];
		
		$hasil= array();
		for ($a=0; $a < count($tanggal) ; $a++) { 
			$date = $tanggal[$a];
			$query1 = "where (BON != 'PENDING' OR BON IS NULL) AND TO_CHAR(jam_input,'DD/MM/YYYY') between '$date' and '$date'";
			$dataMon = $this->M_monitoring->getDataSPB($query1);
			$hasil[$a]['tanggal'] = $tgl[$a];
			$hasil[$a]['dosp'] = $dataMon;
			$hasil[$a]['jml_spb'] = count($dataMon);
			$pcs = 0;
			for ($p=0; $p < count($dataMon) ; $p++) { 
				$pcs += $dataMon[$p]['JUMLAH_PCS'];
			}
			$hasil[$a]['dopcs'] = $pcs;
			
			$query2 = "where TO_CHAR(selesai_pelayanan,'DD/MM/YYYY') between '$date' and '$date' and selesai_pelayanan is not null and (bon != 'PENDING' or bon is null)";
			$pelayanan = $this->M_monitoring->getDataSPB($query2);
			$hasil[$a]['pelayanan'] = $pelayanan;
			$hasil[$a]['jml_pelayanan'] = count($pelayanan);
			if ($date == date('d/m/Y')) {
				$kurang = "where selesai_pelayanan is null and (bon != 'PENDING' or bon is null)";
			}else {
				$d = date('d') - 1;
				if ($date == date(''.$d.'/m/Y')) {
					$tmb = 'or selesai_pelayanan is null';
				}else {
					$tmb = "and trunc(jam_input) <= '$tgl[$a]' or (selesai_pelayanan is null and trunc(jam_input) <= '$tgl[$a]')";
				}
				$kurang = "where (bon != 'PENDING' or bon is null) and TO_CHAR(jam_input,'DD/MM/YYYY') != '".date('d/m/Y')."' and (trunc(selesai_pelayanan) > '$tgl[$a]' ".$tmb.")";
			}
			$hasil[$a]['krgpelayanan'] = $this->M_monitoring->dataKurang($kurang);
			$hasil[$a]['krg_pelayanan'] = count($hasil[$a]['krgpelayanan']);

			$query3 = "where TO_CHAR(selesai_pengeluaran,'DD/MM/YYYY') between '$date' and '$date' and selesai_pengeluaran is not null";
			$pengeluaran = $this->M_monitoring->getDataSPB($query3);
			$hasil[$a]['pengeluaran'] = $pengeluaran;
			$hasil[$a]['jml_pengeluaran'] = count($pengeluaran);
			if ($date == date('d/m/Y')) {
				$kurang = "where selesai_pelayanan is not null and selesai_pengeluaran is null and (bon != 'BON' or bon is null)";
			}else {
				$d = date('d') - 1;
				if ($date == date(''.$d.'/m/Y')) {
					$tmb = 'or selesai_pengeluaran is null';
				}else {
					$tmb = "and trunc(selesai_pelayanan) <= '$tgl[$a]' or (selesai_pengeluaran is null and trunc(selesai_pelayanan) <= '$tgl[$a]')";
				}
				$kurang = "where (bon != 'BON' or bon is null) and TO_CHAR(selesai_pelayanan,'DD/MM/YYYY') != '".date('d/m/Y')."' and (trunc(selesai_pengeluaran) > '$tgl[$a]' ".$tmb.") and selesai_pelayanan is not null";
			}
			$hasil[$a]['krgpengeluaran'] = $this->M_monitoring->dataKurang($kurang);
			$hasil[$a]['krg_pengeluaran'] = count($hasil[$a]['krgpengeluaran']);

			$query4 = "where TO_CHAR(selesai_packing,'DD/MM/YYYY') between '$date' and '$date' and selesai_packing is not null";
			$packing = $this->M_monitoring->getDataSPB($query4);
			$hasil[$a]['packing'] = $packing;
			$hasil[$a]['jml_packing'] = count($packing);
			if ($date == date('d/m/Y')) {
				$kurang = "where selesai_pengeluaran is not null and selesai_packing is null and (bon is null or bon = 'BEST')";
			}else {
				$d = date('d') - 1;
				if ($date == date(''.$d.'/m/Y')) {
					$tmb = 'or selesai_packing is null';
				}else {
					$tmb = "and trunc(selesai_pengeluaran) <= '$tgl[$a]' or (selesai_packing is null and trunc(selesai_pengeluaran) <= '$tgl[$a]')";
				}
				$kurang = "where (bon is null or bon = 'BEST') and TO_CHAR(selesai_pengeluaran,'DD/MM/YYYY') != '".date('d/m/Y')."' and (trunc(selesai_packing) > '$tgl[$a]' ".$tmb.") and selesai_pengeluaran is not null";
			}
			$hasil[$a]['krgpacking'] = $this->M_monitoring->dataKurang($kurang);
			$hasil[$a]['krg_packing'] = count($hasil[$a]['krgpacking']);

			$jml_gd = $this->M_monitoring->getjmlGd2($date);
			$hasil[$a]['jml_gd'] = count($jml_gd);

			$cancel = $this->M_monitoring->getcancel($date, $date);
			$hasil[$a]['cancel'] = count($cancel);

			$jumlah = array(); $jmlitem = 0;
			for ($i=0; $i < $hasil[$a]['jml_packing'] ; $i++) { 
				$cari = $this->M_monitoring->getTransact($packing[$i]['NO_DOKUMEN']);
				for ($b=0; $b < count($cari) ; $b++) { 
					array_push($jumlah, $cari[$b]['TRANSACTION_QUANTITY']);
				}
				$jmlitem += count($cari);
			}
			$hasil[$a]['jml_selesai'] 		= $hasil[$a]['jml_packing'];
			$hasil[$a]['jml_item_selesai'] 	= $jmlitem;
			$hasil[$a]['jml_pcs_selesai'] 	= array_sum($jumlah);
			$krg = $this->M_monitoring->dataKurangselesai($date, $date);
			$kkrg = 0;
			for ($i=0; $i < count($krg); $i++) { 
				if ($krg[$i]['KURANG'] == '') {
					$kkrg += $krg[$i]['QUANTITY'];
				}else {
					$kkrg += $krg[$i]['KURANG'];
				}
			}
			$cacl = $this->M_monitoring->diCancel($date, $date);
			$kccl = 0;
			for ($i=0; $i < count($cacl); $i++) { 
				$kccl += $cacl[$i]['QUANTITY'];
			}
			$hasil[$a]['krg_selesai'] = $kkrg + $kccl;
			// $hasil[$a]['krg_selesai'] = $total - $hasil[$a]['jml_selesai'];

			$htgcoly = $this->jaditoo($packing);

			$hasil[$a]['jml_colly'] = $htgcoly['dus_kecil'] + $htgcoly['dus_sdg'] + $htgcoly['dus_pjg'] + $htgcoly['karung'] + $htgcoly['peti'];
			$hasil[$a]['dus_kecil'] = $htgcoly['dus_kecil'];
			$hasil[$a]['dus_sdg'] = $htgcoly['dus_sdg'];
			$hasil[$a]['dus_pjg'] = $htgcoly['dus_pjg'];
			$hasil[$a]['karung'] = $htgcoly['karung'];
			$hasil[$a]['peti'] = $htgcoly['peti'];
		}
		$data['hasil'] = $hasil;
		// echo "<pre>";print_r($hasil);exit();
		
		$this->load->view('KapasitasGdSparepart/V_TblMonitoring', $data);
	}

	public function jadiin($ket, $nama){
		$spb = 0; $itemspb = 0; $pcsspb = 0;
		$dosp = 0; $itemdosp = 0; $pcsdosp = 0;
		if ($nama == 'selesai') {
			foreach ($ket as $val) {
				if ($val['JENIS_DOKUMEN'] == 'SPB') {
						$spb += 1;
						$itemspb += $val['JML_ITEM_SELESAI'];
						$pcsspb += $val['JML_PCS_SELESAI'];
				}else {
						$dosp += 1;
						$itemdosp += $val['JML_ITEM_SELESAI'];
						$pcsdosp += $val['JML_PCS_SELESAI'];
				}
			}
		}else {
			foreach ($ket as $val) {
				if ($val['JENIS_DOKUMEN'] == 'SPB') {
						$spb += 1;
						$itemspb += $val['JUMLAH_ITEM'];
						$pcsspb += $val['JUMLAH_PCS'];
				}else {
						$dosp += 1;
						$itemdosp += $val['JUMLAH_ITEM'];
						$pcsdosp += $val['JUMLAH_PCS'];
				}
			}
		}
		$tampung = array('0' => array('lembar2' => $spb, 'item2' => $itemspb, 'pcs2' => $pcsspb, 'lembar1' => $dosp, 'item1' => $itemdosp, 'pcs1' => $pcsdosp, ));
		return $tampung;
	}
	
	public function jadiin2($data1, $data2){
		$spb = 0; $itemspb = 0; $pcsspb = 0;
		$dosp = 0; $itemdosp = 0; $pcsdosp = 0;
		$nospb = array(); $item = array();
		foreach ($data1 as $dat) {
			if (!in_array($dat['NO_DOKUMEN'], $nospb)) {
				array_push($nospb, $dat['NO_DOKUMEN']);
				if ($dat['JENIS_DOKUMEN'] == 'SPB') {
					$spb += 1;
				}else {
					$dosp += 1;
				}
			}
			if (!in_array($dat['ITEM'], $item)) {
				if ($dat['JENIS_DOKUMEN'] == 'SPB') {
					$itemspb += 1;
				}else {
					$itemdosp += 1;
				}
			}
			if ($dat['JENIS_DOKUMEN'] == 'SPB') {
				if ($dat['KURANG'] == '') {
					$pcsspb += $dat['QUANTITY'];
				}else {
					$pcsspb += $dat['KURANG'];
				}
			}else {
				if ($dat['KURANG'] == '') {
					$pcsdosp += $dat['QUANTITY'];
				}else {
					$pcsdosp += $dat['KURANG'];
				}
			}
		}
		
		foreach ($data2 as $dat) {
			if (!in_array($dat['NO_DOKUMEN'], $nospb)) {
				array_push($nospb, $dat['NO_DOKUMEN']);
				if ($dat['JENIS_DOKUMEN'] == 'SPB') {
					$spb += 1;
				}else {
					$dosp += 1;
				}
			}
			if (!in_array($dat['ITEM'], $item)) {
				if ($dat['JENIS_DOKUMEN'] == 'SPB') {
					$itemspb += 1;
				}else {
					$itemdosp += 1;
				}
			}
			
			if ($dat['JENIS_DOKUMEN'] == 'SPB') {
					$pcsspb += $dat['QUANTITY'];
			}else {
					$pcsdosp += $dat['QUANTITY'];
			}
		}
		$tampung = array('0' => array('lembar2' => $spb, 'item2' => $itemspb, 'pcs2' => $pcsspb, 'lembar1' => $dosp, 'item1' => $itemdosp, 'pcs1' => $pcsdosp, ));
		return $tampung;
	}


	public function jadibelum($ket){
		$spb = 0; $itemspb = 0; $pcsspb = 0;
		$dosp = 0; $itemdosp = 0; $pcsdosp = 0;
		foreach ($ket as $val) {
			if ($val['JENIS_DOKUMEN'] == 'SPB') {
				if ($val['BON'] == 'PENDING') {
					$spb += 1;
					$itemspb += $val['JUMLAH_ITEM'];
					$pcsspb += $val['JUMLAH_PCS'];
				}
			}else {
				if ($val['BON'] == 'PENDING') {
					$dosp += 1;
					$itemdosp += $val['JUMLAH_ITEM'];
					$pcsdosp += $val['JUMLAH_PCS'];
				}
			}
		}

		$tampung = array('0' => array('lembar2' => $spb, 'item2' => $itemspb, 'pcs2' => $pcsspb, 'lembar1' => $dosp, 'item1' => $itemdosp, 'pcs1' => $pcsdosp, ));
		return $tampung;
	}

	public function jaditoo($pack){
		$dus_kecil = 0;
		$dus_sdg = 0;
		$dus_pjg = 0;
		$karung = 0;
		$peti = 0;
		foreach ($pack as $pck) {
			$cari = $this->M_monitoring->getDataColly($pck['NO_DOKUMEN']);
			if (!empty($cari)) {
				foreach ($cari as $val) {
					if ($val['kode_packing'] == 1) {
						$dus_kecil += 1;
					}elseif ($val['kode_packing'] == 2) {
						$dus_sdg += 1;
					}elseif ($val['kode_packing'] == 3) {
						$dus_pjg += 1;
					}elseif ($val['kode_packing'] == 4) {
						$karung += 1;
					}elseif ($val['kode_packing'] == 5) {
						$peti += 1;
					}
				}
			}
			
			$cari2 = $this->M_monitoring->getDataColly2($pck['NO_DOKUMEN']);
			if (!empty($cari2)) {
				foreach ($cari2 as $val) {
					if ($val['JENIS'] == 'KARDUS KECIL') {
						$dus_kecil += 1;
					}elseif ($val['JENIS'] == 'KARDUS SEDANG') {
						$dus_sdg += 1;
					}elseif ($val['JENIS'] == 'KARDUS PANJANG') {
						$dus_pjg += 1;
					}elseif ($val['JENIS'] == 'KARUNG') {
						$karung += 1;
					}elseif ($val['JENIS'] == 'PETI') {
						$peti += 1;
					}
				}
			}
		}
		
		$tampung = array(
			'dus_kecil' => $dus_kecil,
			'dus_sdg' => $dus_sdg,
			'dus_pjg' => $dus_pjg,
			'karung' => $karung,
			'peti' => $peti,
		);
		return $tampung;
	}

	public function jadigini($ket){
		$urg = 0; $itemurg = 0; $pcsurg = 0;
		$tdk = 0; $itemtdk = 0; $pcstdk = 0;
		$bon = 0; $itembon = 0; $pcsbon = 0;
		$langsung = 0; $itemlangsung = 0; $pcslangsung = 0;
		$besc = 0; $itembesc = 0; $pcsbesc = 0;
		$urg2 = 0; $itemurg2 = 0; $pcsurg2 = 0;
		$tdk2 = 0; $itemtdk2 = 0; $pcstdk2 = 0;
		$bon2 = 0; $itembon2 = 0; $pcsbon2 = 0;
		$langsung2 = 0; $itemlangsung2 = 0; $pcslangsung2 = 0;
		$besc2 = 0; $itembesc2 = 0; $pcsbesc2 = 0;
		foreach ($ket as $val) {
			if ($val['JENIS_DOKUMEN'] == 'DOSP') {
				if ($val['URGENT'] != '') {
					$urg += 1;
					$itemurg += $val['JUMLAH_ITEM'];
					$pcsurg += $val['JUMLAH_PCS'];
				}elseif ($val['URGENT'] == '' && $val['BON'] == '') {
					$tdk += 1;
					$itemtdk += $val['JUMLAH_ITEM'];
					$pcstdk += $val['JUMLAH_PCS'];
				}
				if ($val['BON'] == 'BON') {
					$bon += 1;
					$itembon += $val['JUMLAH_ITEM'];
					$pcsbon += $val['JUMLAH_PCS'];
				}elseif ($val['BON'] == 'LANGSUNG') {
					$langsung += 1;
					$itemlangsung += $val['JUMLAH_ITEM'];
					$pcslangsung += $val['JUMLAH_PCS'];
				}elseif ($val['BON'] == 'BEST') {
					$besc += 1;
					$itembesc += $val['JUMLAH_ITEM'];
					$pcsbesc += $val['JUMLAH_PCS'];
				}
			}else {
				if ($val['URGENT'] != '') {
					$urg2 += 1;
					$itemurg2 += $val['JUMLAH_ITEM'];
					$pcsurg2 += $val['JUMLAH_PCS'];
				}elseif ($val['URGENT'] == '' && $val['BON'] == '') {
					$tdk2 += 1;
					$itemtdk2 += $val['JUMLAH_ITEM'];
					$pcstdk2 += $val['JUMLAH_PCS'];
				}
				if ($val['BON'] == 'BON') {
					$bon2 += 1;
					$itembon2 += $val['JUMLAH_ITEM'];
					$pcsbon2 += $val['JUMLAH_PCS'];
				}elseif ($val['BON'] == 'LANGSUNG') {
					$langsung2 += 1;
					$itemlangsung2 += $val['JUMLAH_ITEM'];
					$pcslangsung2 += $val['JUMLAH_PCS'];
				}elseif ($val['BON'] == 'BEST') {
					$besc2 += 1;
					$itembesc2 += $val['JUMLAH_ITEM'];
					$pcsbesc2 += $val['JUMLAH_PCS'];
				}
			}
		}

		$tampung = array('0' => array('lembar1' => $urg, 'item1' => $itemurg, 'pcs1' => $pcsurg, 'lembar2' => $urg2, 'item2' => $itemurg2, 'pcs2' => $pcsurg2,),
		'1' => array('lembar1' => $tdk, 'item1' => $itemtdk, 'pcs1' => $pcstdk, 'lembar2' => $tdk2, 'item2' => $itemtdk2, 'pcs2' => $pcstdk2, ),
		'2' => array('lembar1' => $bon,	'item1' => $itembon, 'pcs1' => $pcsbon, 'lembar2' => $bon2,	'item2' => $itembon2, 'pcs2' => $pcsbon2,),
		'3' => array('lembar1' => $langsung,	'item1' => $itemlangsung, 'pcs1' => $pcslangsung,'lembar2' => $langsung2,	'item2' => $itemlangsung2, 'pcs2' => $pcslangsung2, ),
		'4' => array('lembar1' => $besc,	'item1' => $itembesc, 'pcs1' => $pcsbesc,'lembar2' => $besc2,	'item2' => $itembesc2, 'pcs2' => $pcsbesc2, ) 
	);
		return $tampung;
	}

	public function exportSPB(){
		$tglAwal = $this->input->post('tglAwal[]');
		$tglAkhir = $this->input->post('tglAkhir[]');

		$dataDOSPB = $this->M_monitoring->dataDOSPB($tglAwal[0], $tglAkhir[0]);

		$dataPlyn = $this->M_monitoring->dataPlyn($tglAwal[0], $tglAkhir[0]);

		$dataKrgPlyn = $this->M_monitoring->dataKrgPlyn($tglAwal[0], $tglAkhir[0]);
		
		$dataPglr = $this->M_monitoring->dataPglr($tglAwal[0], $tglAkhir[0]);

		$dataKrgPglr = $this->M_monitoring->dataKrgPglr($tglAwal[0], $tglAkhir[0]);
	
		$dataPck = $this->M_monitoring->dataPck($tglAwal[0], $tglAkhir[0]);

		$dataKrgPck = $this->M_monitoring->dataKrgPck($tglAwal[0], $tglAkhir[0]);

		$tanggal 		= $this->input->post('tanggalnya[]');
		$jml_selesai 	= $this->input->post('jml_selesai[]');
		$krg_selesai 	= $this->input->post('krg_selesai[]');

		$dataselesai = $this->M_monitoring->dataselesai($tglAwal[0], $tglAkhir[0]);

		$dataCancel = $this->M_monitoring->diCancel($tglAwal[0], $tglAkhir[0]);
		
		$dataKurang = $this->M_monitoring->dataKurangselesai($tglAwal[0], $tglAkhir[0]);
		
		$ket = $this->M_monitoring->dataKeterangan($tglAwal[0], $tglAkhir[0]);
		// echo "<pre>";print_r($dataselesai);exit();

		$dataket = array();
		for ($i=0; $i < count($tanggal); $i++) { 
			$array = array(
				'tanggal'		=> $tanggal[$i],
				'jml_selesai' 	=> $jml_selesai[$i],
				'krg_selesai' 	=> $krg_selesai[$i],
				'total_selesai' => $jml_selesai[$i] + $krg_selesai[$i],
			);
			array_push($dataket, $array);
		}

		$data_colly = array();
		$no_colly = array();
		for ($i=0; $i < count($dataselesai) ; $i++) { 
			$dus_kecil 	= array();
			$dus_sdg 	= array();
			$dus_pjg 	= array();
			$karung 	= array();
			$peti	 	= array();
			$cekcolly = $this->M_monitoring->getDataColly($dataselesai[$i]['NO_DOKUMEN']);
			if (!empty($cekcolly)) {
				foreach ($cekcolly as $val) {
					if ($val['kode_packing'] == 1) {
						array_push($dus_kecil, $val['nomor_do']);
					}elseif ($val['kode_packing'] == 2) {
						array_push($dus_sdg, $val['nomor_do']);
					}elseif ($val['kode_packing'] == 3) {
						array_push($dus_pjg, $val['nomor_do']);
					}elseif ($val['kode_packing'] == 4) {
						array_push($karung, $val['nomor_do']);
					}elseif ($val['kode_packing'] == 5) {
						array_push($peti, $val['nomor_do']);
					}
				}
			}
			$cekcolly2 = $this->M_monitoring->getDataColly2($dataselesai[$i]['NO_DOKUMEN']);
			if (!empty($cekcolly2)) {
				foreach ($cekcolly2 as $val) {
					if ($val['JENIS'] == 'KARDUS KECIL') {
						array_push($dus_kecil, $dataselesai[$i]['NO_DOKUMEN']);
					}elseif ($val['JENIS'] == 'KARDUS SEDANG') {
						array_push($dus_sdg, $dataselesai[$i]['NO_DOKUMEN']);
					}elseif ($val['JENIS'] == 'KARDUS PANJANG') {
						array_push($dus_pjg, $dataselesai[$i]['NO_DOKUMEN']);
					}elseif ($val['JENIS'] == 'KARUNG') {
						array_push($karung, $dataselesai[$i]['NO_DOKUMEN']);
					}elseif ($val['JENIS'] == 'PETI') {
						array_push($peti, $dataselesai[$i]['NO_DOKUMEN']);
					}
				}
			}
			if (!empty($cekcolly) || !empty($cekcolly2)) {
				$array = array(
					'nospb' => $dataselesai[$i]['NO_DOKUMEN'],
					'dus_kecil' => count($dus_kecil),
					'dus_sdg' => count($dus_sdg),
					'dus_pjg' => count($dus_pjg),
					'karung' => count($karung),
					'peti' => count($peti),
				);
				array_push($data_colly, $array);
			}
			if (!in_array($dataselesai[$i]['NO_DOKUMEN'], $no_colly)) {
				array_push($no_colly, $dataselesai[$i]['NO_DOKUMEN']);
			}
		}
		$kcl = 0; $sdg = 0; $pjg = 0; $krg = 0; $peti = 0;
		foreach ($data_colly as $col) {
			$kcl += $col['dus_kecil'];
			$sdg += $col['dus_sdg'];
			$pjg += $col['dus_pjg'];
			$krg += $col['karung'];
			$peti += $col['peti'];
		}
		$coly = array(
			'dus_kecil' => $kcl,
			'dus_sdg' => $sdg,
			'dus_pjg' => $pjg,
			'karung' => $krg,
			'peti' => $peti,
		);

		include APPPATH.'third_party/Excel/PHPExcel.php';
			$excel = new PHPExcel();
			$excel->getProperties()->setCreator('CV. KHS')
						->setLastModifiedBy('Quick')
						->setTitle("Kapasitas Gudang Sparepart")
						->setSubject("CV. KHS")
						->setDescription("Kapasitas Gudang Sparepart")
						->setKeywords("KGS");
			//style
			$style_title = array(
				'font' => array(
					'bold' => true,
					'size' => 15
				), 
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
					'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				),
			);
			$style1 = array(
				'font' => array(
					'bold' => true
				), 
				'alignment' => array(
					'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				),
			);
			$style_col = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'bdeefc'),
				),
				'font' => array('bold' => true), 
				'alignment' => array(
					'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
					'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'		=> true
				),
				'borders' => array(
					'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
					'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
				)
			);
			$style_col2 = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ff9466'),
				),
				'font' => array('bold' => true), 
				'alignment' => array(
					'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
					'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'		=> true
				),
				'borders' => array(
					'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
					'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
				)
			);
			$style_col3 = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ff6666'),
				),
				'font' => array('bold' => true), 
				'alignment' => array(
					'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
					'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'		=> true
				),
				'borders' => array(
					'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
					'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
				)
			);
			$style2 = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
					'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'		 => true
				),
				'borders' => array(
					'top' 		=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
					'right' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
					'bottom' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' 		=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
				)
			);
			$style3 = array(
				'alignment' => array(
					'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'		 => true
				),
				'borders' => array(
					'top' 		=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
					'right' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
					'bottom' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' 		=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
				)
			);

			//TITLE
			$excel->setActiveSheetIndex(0)->setCellValue('A1', "Kapasitas Gudang Sparepart"); 
			$excel->getActiveSheet()->mergeCells('A1:M1'); 
			$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);
			
			// TABEL DOSPB
			$excel->setActiveSheetIndex(0)->setCellValue('A4', "1. DATA DO/SPB MASUK"); 
			$excel->setActiveSheetIndex(0)->setCellValue('A5', "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue('B5', "TANGGAL DIBUAT");
			$excel->setActiveSheetIndex(0)->setCellValue('D5', "JENIS DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue('F5', "NO DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue('H5', "JUMLAH ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue('J5', "JUMLAH PCS");
			$excel->setActiveSheetIndex(0)->setCellValue('L5', "KET");
			$excel->getActiveSheet()->mergeCells('B5:C5'); 
			$excel->getActiveSheet()->mergeCells('D5:E5'); 
			$excel->getActiveSheet()->mergeCells('F5:G5'); 
			$excel->getActiveSheet()->mergeCells('H5:I5'); 
			$excel->getActiveSheet()->mergeCells('J5:K5'); 
			$excel->getActiveSheet()->mergeCells('L5:M5');
			$excel->getActiveSheet()->getStyle('A4')->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I5')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J5')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K5')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('L5')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('M5')->applyFromArray($style_col);

			if (count($dataDOSPB) == 0){
				$excel->setActiveSheetIndex(0)->setCellValue('A6', "No data available in table"); 
				$excel->getActiveSheet()->mergeCells('A6:M6');
				$excel->getActiveSheet()->getStyle('A6')->applyFromArray($style_title);
			}else {
				$no=1;
				$numrow = 6;
					foreach ($dataDOSPB as $val) {
						$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
						$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $val['CREATION_DATE']);
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $val['JENIS_DOKUMEN']);
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $val['NO_DOKUMEN']);
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $val['JUMLAH_ITEM']);
						$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $val['JUMLAH_PCS']);
						$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $val['KETERANGAN'].' '.$val['BON']);
						$excel->getActiveSheet()->mergeCells("B$numrow:C$numrow"); 
						$excel->getActiveSheet()->mergeCells("D$numrow:E$numrow"); 
						$excel->getActiveSheet()->mergeCells("F$numrow:G$numrow"); 
						$excel->getActiveSheet()->mergeCells("H$numrow:I$numrow"); 
						$excel->getActiveSheet()->mergeCells("J$numrow:K$numrow"); 
						$excel->getActiveSheet()->mergeCells("L$numrow:M$numrow"); 
						$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style2);
					$numrow++;
					$no++; 
					}
			}

			$plyn = count($dataDOSPB) + 9;
			$noPlyn = count($dataDOSPB) + 10;
			// TABEL Pelayanan Terlayani
			$excel->setActiveSheetIndex(0)->setCellValue("A$plyn", "2. DATA PELAYANAN TERSELESAIKAN"); 
			$excel->setActiveSheetIndex(0)->setCellValue("A$noPlyn", "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue("B$noPlyn", "TANGGAL DIBUAT");
			$excel->setActiveSheetIndex(0)->setCellValue("C$noPlyn", "JENIS DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue("D$noPlyn", "NO DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue("E$noPlyn", "JUMLAH ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue("F$noPlyn", "JUMLAH PCS");
			$excel->setActiveSheetIndex(0)->setCellValue("G$noPlyn", "TANGGAL MULAI");
			$excel->setActiveSheetIndex(0)->setCellValue("H$noPlyn", "JAM MULAI");
			$excel->setActiveSheetIndex(0)->setCellValue("I$noPlyn", "TANGGAL SELESAI");
			$excel->setActiveSheetIndex(0)->setCellValue("J$noPlyn", "JAM SELESAI");
			$excel->setActiveSheetIndex(0)->setCellValue("K$noPlyn", "WAKTU");
			$excel->setActiveSheetIndex(0)->setCellValue("L$noPlyn", "PIC");
			$excel->setActiveSheetIndex(0)->setCellValue("M$noPlyn", "KET");
			$excel->getActiveSheet()->getStyle("A$plyn")->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle("A$noPlyn")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("B$noPlyn")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("C$noPlyn")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("D$noPlyn")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("E$noPlyn")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("F$noPlyn")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("G$noPlyn")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("H$noPlyn")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("I$noPlyn")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("J$noPlyn")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("K$noPlyn")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("L$noPlyn")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("M$noPlyn")->applyFromArray($style_col);

			if (count($dataPlyn) == 0){
				// echo "kok kosong"; exit();
				$numrow = $noPlyn + 1;
				$excel->setActiveSheetIndex(0)->setCellValue("A$numrow", "No data available in table"); 
				$excel->getActiveSheet()->mergeCells("A$numrow:M$numrow"); 
				$excel->getActiveSheet()->getStyle("A$numrow")->applyFromArray($style_title);
			}else {
				// echo "laini"; exit();
				$no=1;
				$numrow = $noPlyn + 1;
					foreach ($dataPlyn as $val) {
						$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
						$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $val['TGL_DIBUAT']);
						$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $val['JENIS_DOKUMEN']);
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $val['NO_DOKUMEN']);
						$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $val['JML_ITEM_TERLAYANI']);
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $val['JML_PCS_TERLAYANI']);
						$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $val['TGL_MULAI']);
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $val['JAM_MULAI']);
						$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $val['TGL_SELESAI']);
						$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $val['JAM_SELESAI']);
						$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $val['WAKTU_PELAYANAN']);
						$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $val['PIC_PELAYAN']);
						$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $val['KETERANGAN'].' '.$val['BON']);

						$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style2);
					$numrow++;
					$no++; 
					}
			}

			$krgPlyn = $noPlyn + count($dataPlyn) + 4;
			$noKPlyn = $noPlyn + count($dataPlyn) + 5;
			// TABEL Tanggungan Pelayanan
			$excel->setActiveSheetIndex(0)->setCellValue("A$krgPlyn", "2.1 DATA TANGGUNGAN PELAYANAN"); 
			$excel->setActiveSheetIndex(0)->setCellValue("A$noKPlyn", "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue("B$noKPlyn", "TANGGAL DIBUAT");
			$excel->setActiveSheetIndex(0)->setCellValue("D$noKPlyn", "JENIS DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue("F$noKPlyn", "NO DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue("H$noKPlyn", "JUMLAH ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue("J$noKPlyn", "JUMLAH PCS");
			$excel->setActiveSheetIndex(0)->setCellValue("L$noKPlyn", "KET");
			$excel->getActiveSheet()->mergeCells("B$noKPlyn:C$noKPlyn"); 
			$excel->getActiveSheet()->mergeCells("D$noKPlyn:E$noKPlyn"); 
			$excel->getActiveSheet()->mergeCells("F$noKPlyn:G$noKPlyn"); 
			$excel->getActiveSheet()->mergeCells("H$noKPlyn:I$noKPlyn"); 
			$excel->getActiveSheet()->mergeCells("J$noKPlyn:K$noKPlyn"); 
			$excel->getActiveSheet()->mergeCells("L$noKPlyn:M$noKPlyn"); 
			$excel->getActiveSheet()->getStyle("A$krgPlyn")->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle("A$noKPlyn")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("B$noKPlyn")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("C$noKPlyn")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("D$noKPlyn")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("E$noKPlyn")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("F$noKPlyn")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("G$noKPlyn")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("H$noKPlyn")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("I$noKPlyn")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("J$noKPlyn")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("K$noKPlyn")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("L$noKPlyn")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("M$noKPlyn")->applyFromArray($style_col2);

			if (count($dataKrgPlyn) == 0){
				$numrow = $noKPlyn + 1;
				$excel->setActiveSheetIndex(0)->setCellValue("A$numrow", "No data available in table"); 
				$excel->getActiveSheet()->mergeCells("A$numrow:M$numrow"); 
				$excel->getActiveSheet()->getStyle("A$numrow")->applyFromArray($style_title);
			}else {
				$no=1;
				$numrow = $noKPlyn + 1;
					foreach ($dataKrgPlyn as $val) {
						$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
						$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $val['TGL_DIBUAT']);
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $val['JENIS_DOKUMEN']);
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $val['NO_DOKUMEN']);
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $val['JML_ITEM_TERLAYANI']);
						$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $val['JML_PCS_TERLAYANI']);
						$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $val['KETERANGAN'].' '.$val['BON']);
						$excel->getActiveSheet()->mergeCells("B$numrow:C$numrow"); 
						$excel->getActiveSheet()->mergeCells("D$numrow:E$numrow"); 
						$excel->getActiveSheet()->mergeCells("F$numrow:G$numrow"); 
						$excel->getActiveSheet()->mergeCells("H$numrow:I$numrow"); 
						$excel->getActiveSheet()->mergeCells("J$numrow:K$numrow"); 
						$excel->getActiveSheet()->mergeCells("L$numrow:M$numrow"); 
						$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style2);
					$numrow++;
					$no++; 
					}
			}


			$pglr = $noKPlyn + count($dataKrgPlyn) + 4;
			$noPglr = $noKPlyn + count($dataKrgPlyn) + 5;
			// TABEL Pengeluaran Terlayani
			$excel->setActiveSheetIndex(0)->setCellValue("A$pglr", "3. DATA PENGELUARAN TERSELESAIKAN"); 
			$excel->setActiveSheetIndex(0)->setCellValue("A$noPglr", "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue("B$noPglr", "TANGGAL DIBUAT");
			$excel->setActiveSheetIndex(0)->setCellValue("C$noPglr", "JENIS DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue("D$noPglr", "NO DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue("E$noPglr", "JUMLAH ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue("F$noPglr", "JUMLAH PCS");
			$excel->setActiveSheetIndex(0)->setCellValue("G$noPglr", "TANGGAL MULAI");
			$excel->setActiveSheetIndex(0)->setCellValue("H$noPglr", "JAM MULAI");
			$excel->setActiveSheetIndex(0)->setCellValue("I$noPglr", "TANGGAL SELESAI");
			$excel->setActiveSheetIndex(0)->setCellValue("J$noPglr", "JAM SELESAI");
			$excel->setActiveSheetIndex(0)->setCellValue("K$noPglr", "WAKTU");
			$excel->setActiveSheetIndex(0)->setCellValue("L$noPglr", "PIC");
			$excel->setActiveSheetIndex(0)->setCellValue("M$noPglr", "KET");
			$excel->getActiveSheet()->getStyle("A$pglr")->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle("A$noPglr")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("B$noPglr")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("C$noPglr")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("D$noPglr")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("E$noPglr")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("F$noPglr")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("G$noPglr")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("H$noPglr")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("I$noPglr")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("J$noPglr")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("K$noPglr")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("L$noPglr")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("M$noPglr")->applyFromArray($style_col);

			if (count($dataPglr) == 0){
				$numrow = $noPglr + 1;
				$excel->setActiveSheetIndex(0)->setCellValue("A$numrow", "No data available in table"); 
				$excel->getActiveSheet()->mergeCells("A$numrow:M$numrow"); 
				$excel->getActiveSheet()->getStyle("A$numrow")->applyFromArray($style_title);
			}else {
				$no=1;
				$numrow = $noPglr + 1;
					foreach ($dataPglr as $val) {
						$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
						$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $val['TGL_DIBUAT']);
						$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $val['JENIS_DOKUMEN']);
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $val['NO_DOKUMEN']);
						$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $val['JML_ITEM_DIKELUARKAN']);
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $val['JML_PCS_DIKELUARKAN']);
						$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $val['TGL_MULAI']);
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $val['JAM_MULAI']);
						$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $val['TGL_SELESAI']);
						$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $val['JAM_SELESAI']);
						$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $val['WAKTU_PENGELUARAN']);
						$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $val['PIC_PENGELUARAN']);
						$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $val['KETERANGAN'].' '.$val['BON']);

						$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style2);
					$numrow++;
					$no++; 
					}
			}

			$kPglr = $noPglr + count($dataPglr) + 4;
			$noKPglr = $noPglr + count($dataPglr) + 5;
			// TABEL Tanggungan Pengeluaran
			$excel->setActiveSheetIndex(0)->setCellValue("A$kPglr", "3.1 DATA TANGGUNGAN PENGELUARAN"); 
			$excel->setActiveSheetIndex(0)->setCellValue("A$noKPglr", "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue("B$noKPglr", "TANGGAL DIBUAT");
			$excel->setActiveSheetIndex(0)->setCellValue("D$noKPglr", "JENIS DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue("F$noKPglr", "NO DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue("H$noKPglr", "JUMLAH ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue("J$noKPglr", "JUMLAH PCS");
			$excel->setActiveSheetIndex(0)->setCellValue("K$noKPglr", "PIC");
			$excel->setActiveSheetIndex(0)->setCellValue("M$noKPglr", "KET");
			$excel->getActiveSheet()->mergeCells("B$noKPglr:C$noKPglr"); 
			$excel->getActiveSheet()->mergeCells("D$noKPglr:E$noKPglr"); 
			$excel->getActiveSheet()->mergeCells("F$noKPglr:G$noKPglr"); 
			$excel->getActiveSheet()->mergeCells("H$noKPglr:I$noKPglr"); 
			$excel->getActiveSheet()->mergeCells("K$noKPglr:L$noKPglr"); 
			$excel->getActiveSheet()->getStyle("A$kPglr")->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle("A$noKPglr")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("B$noKPglr")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("C$noKPglr")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("D$noKPglr")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("E$noKPglr")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("F$noKPglr")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("G$noKPglr")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("H$noKPglr")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("I$noKPglr")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("J$noKPglr")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("K$noKPglr")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("L$noKPglr")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("M$noKPglr")->applyFromArray($style_col2);

			if (count($dataKrgPglr) == 0){
				$numrow = $noKPglr + 1;
				$excel->setActiveSheetIndex(0)->setCellValue("A$numrow", "No data available in table"); 
				$excel->getActiveSheet()->mergeCells("A$numrow:M$numrow");
				$excel->getActiveSheet()->getStyle("A$numrow")->applyFromArray($style_title);
			}else {
				$no=1;
				$numrow = $noKPglr + 1;
					foreach ($dataKrgPglr as $val) {
						$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
						$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $val['TGL_DIBUAT']);
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $val['JENIS_DOKUMEN']);
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $val['NO_DOKUMEN']);
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $val['JML_ITEM_TERLAYANI']);
						$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $val['JML_PCS_TERLAYANI']);
						$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $val['PIC_PELAYAN']);
						$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $val['KETERANGAN'].' '.$val['BON']);
						$excel->getActiveSheet()->mergeCells("B$numrow:C$numrow"); 
						$excel->getActiveSheet()->mergeCells("D$numrow:E$numrow"); 
						$excel->getActiveSheet()->mergeCells("F$numrow:G$numrow"); 
						$excel->getActiveSheet()->mergeCells("H$numrow:I$numrow"); 
						$excel->getActiveSheet()->mergeCells("K$numrow:L$numrow"); 
						$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style2);
					$numrow++;
					$no++; 
					}
			}

			$pck = $noKPglr + count($dataKrgPglr) + 4;
			$noPck = $noKPglr + count($dataKrgPglr) + 5;
			// TABEL Packing Terlayani
			$excel->setActiveSheetIndex(0)->setCellValue("A$pck", "4. DATA PACKING TERSELESAIKAN"); 
			$excel->setActiveSheetIndex(0)->setCellValue("A$noPck", "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue("B$noPck", "TANGGAL DIBUAT");
			$excel->setActiveSheetIndex(0)->setCellValue("C$noPck", "JENIS DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue("D$noPck", "NO DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue("E$noPck", "JUMLAH ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue("F$noPck", "JUMLAH PCS");
			$excel->setActiveSheetIndex(0)->setCellValue("G$noPck", "TANGGAL MULAI");
			$excel->setActiveSheetIndex(0)->setCellValue("H$noPck", "JAM MULAI");
			$excel->setActiveSheetIndex(0)->setCellValue("I$noPck", "TANGGAL SELESAI");
			$excel->setActiveSheetIndex(0)->setCellValue("J$noPck", "JAM SELESAI");
			$excel->setActiveSheetIndex(0)->setCellValue("K$noPck", "WAKTU");
			$excel->setActiveSheetIndex(0)->setCellValue("L$noPck", "PIC");
			$excel->setActiveSheetIndex(0)->setCellValue("M$noPck", "KET");
			$excel->setActiveSheetIndex(0)->setCellValue("N$noPck", "KARDUS KECIL");
			$excel->setActiveSheetIndex(0)->setCellValue("O$noPck", "KARDUS SEDANG");
			$excel->setActiveSheetIndex(0)->setCellValue("P$noPck", "KARDUS PANJANG");
			$excel->setActiveSheetIndex(0)->setCellValue("Q$noPck", "KARUNG");
			$excel->setActiveSheetIndex(0)->setCellValue("R$noPck", "PETI");
			$excel->getActiveSheet()->getStyle("A$pck")->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle("A$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("B$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("C$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("D$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("E$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("F$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("G$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("H$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("I$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("J$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("K$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("L$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("M$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("N$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("O$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("P$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("Q$noPck")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("R$noPck")->applyFromArray($style_col);

			if (count($dataPck) == 0){
				$numrow = $noPck + 1;
				$excel->setActiveSheetIndex(0)->setCellValue("A$numrow", "No data available in table"); 
				$excel->getActiveSheet()->mergeCells("A$numrow:Q$numrow");
				$excel->getActiveSheet()->getStyle("A$numrow")->applyFromArray($style_title);
			}else {
				$no=1;
				$numrow = $noPck + 1;
					foreach ($dataPck as $val) {
						$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
						$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $val['TGL_DIBUAT']);
						$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $val['JENIS_DOKUMEN']);
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $val['NO_DOKUMEN']);
						$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $val['JML_ITEM_PACKING']);
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $val['JML_PCS_PACKING']);
						$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $val['TGL_MULAI']);
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $val['JAM_MULAI']);
						$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $val['TGL_SELESAI']);
						$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $val['JAM_SELESAI']);
						$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $val['WAKTU_PACKING']);
						$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $val['PIC_PACKING']);
						$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $val['KETERANGAN'].' '.$val['BON']);
						if (in_array($val['NO_DOKUMEN'], $no_colly)) {
							foreach ($data_colly as $dc) {
								if ($dc['nospb'] == $val['NO_DOKUMEN']) {
									$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $dc['dus_kecil']);
									$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $dc['dus_sdg']);
									$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $dc['dus_pjg']);
									$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $dc['karung']);
									$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $dc['peti']);
								}
							}
						}

						$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style2);
					$numrow++;
					$no++; 
					}
			}

			$KPck = $noPck + count($dataPck) + 4;
			$noKPck = $noPck + count($dataPck) + 5;
			// TABEL Tanggungan Packing
			$excel->setActiveSheetIndex(0)->setCellValue("A$KPck", "4.1 DATA TANGGUNGAN PACKING"); 
			$excel->setActiveSheetIndex(0)->setCellValue("A$noKPck", "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue("B$noKPck", "TANGGAL DIBUAT");
			$excel->setActiveSheetIndex(0)->setCellValue("D$noKPck", "JENIS DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue("F$noKPck", "NO DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue("H$noKPck", "JUMLAH ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue("J$noKPck", "JUMLAH PCS");
			$excel->setActiveSheetIndex(0)->setCellValue("K$noKPck", "PIC");
			$excel->setActiveSheetIndex(0)->setCellValue("M$noKPck", "KET");
			$excel->getActiveSheet()->mergeCells("B$noKPck:C$noKPck"); 
			$excel->getActiveSheet()->mergeCells("D$noKPck:E$noKPck"); 
			$excel->getActiveSheet()->mergeCells("F$noKPck:G$noKPck"); 
			$excel->getActiveSheet()->mergeCells("H$noKPck:I$noKPck"); 
			$excel->getActiveSheet()->mergeCells("K$noKPck:L$noKPck"); 
			$excel->getActiveSheet()->getStyle("A$KPck")->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle("A$noKPck")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("B$noKPck")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("C$noKPck")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("D$noKPck")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("E$noKPck")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("F$noKPck")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("G$noKPck")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("H$noKPck")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("I$noKPck")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("J$noKPck")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("K$noKPck")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("L$noKPck")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("M$noKPck")->applyFromArray($style_col2);

			if (count($dataKrgPck) == 0){
				$numrow = $noKPck + 1;
				$excel->setActiveSheetIndex(0)->setCellValue("A$numrow", "No data available in table"); 
				$excel->getActiveSheet()->mergeCells("A$numrow:M$numrow");
				$excel->getActiveSheet()->getStyle("A$numrow")->applyFromArray($style_title);
			}else {
				$no=1;
				$numrow = $noKPck + 1;
					foreach ($dataKrgPck as $val) {
						$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
						$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $val['TGL_DIBUAT']);
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $val['JENIS_DOKUMEN']);
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $val['NO_DOKUMEN']);
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $val['JML_ITEM_TERLAYANI']);
						$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $val['JML_PCS_TERLAYANI']);
						$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $val['PIC_PENGELUARAN']);
						$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $val['KETERANGAN'].' '.$val['BON']);
						$excel->getActiveSheet()->mergeCells("B$numrow:C$numrow"); 
						$excel->getActiveSheet()->mergeCells("D$numrow:E$numrow"); 
						$excel->getActiveSheet()->mergeCells("F$numrow:G$numrow"); 
						$excel->getActiveSheet()->mergeCells("H$numrow:I$numrow"); 
						$excel->getActiveSheet()->mergeCells("K$numrow:L$numrow"); 
						$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style2);
					$numrow++;
					$no++; 
					}
			}

			$sls = $noKPck + count($dataKrgPck) + 4;
			$head = $noKPck + count($dataKrgPck) + 5;
			// Tabel data selesai
			$excel->setActiveSheetIndex(0)->setCellValue("A$sls", "5. DATA DOSP/SPB SELESAI");
			$excel->setActiveSheetIndex(0)->setCellValue("A$head", "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue("B$head", "TANGGAL DIBUAT");
			$excel->setActiveSheetIndex(0)->setCellValue("D$head", "TANGGAL SELESAI");
			$excel->setActiveSheetIndex(0)->setCellValue("F$head", "JENIS DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue("G$head", "NO DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue("I$head", "JUMLAH ITEM AWAL");
			$excel->setActiveSheetIndex(0)->setCellValue("J$head", "JUMLAH PCS AWAL");
			$excel->setActiveSheetIndex(0)->setCellValue("K$head", "JUMLAH ITEM SELESAI");
			$excel->setActiveSheetIndex(0)->setCellValue("L$head", "JUMLAH PCS SELESAI");
			$excel->setActiveSheetIndex(0)->setCellValue("M$head", "KETERANGAN");
			$excel->getActiveSheet()->mergeCells("B$head:C$head"); 
			$excel->getActiveSheet()->mergeCells("D$head:E$head"); 
			$excel->getActiveSheet()->mergeCells("G$head:H$head");  
			$excel->getActiveSheet()->getStyle("A$sls")->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle("A$head")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("B$head")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("C$head")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("D$head")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("E$head")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("F$head")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("G$head")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("H$head")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("I$head")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("J$head")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("K$head")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("L$head")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("M$head")->applyFromArray($style_col);
			$no2=1;
			$numrow2 = $head + 1;
			foreach ($dataselesai as $val) {
				$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow2, $no2);
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow2, $val['TGL_DIBUAT']);
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow2, $val['SELESAI_PACKING']);
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow2, $val['JENIS_DOKUMEN']);
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow2, $val['NO_DOKUMEN']);
				$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow2, $val['JUMLAH_ITEM']);
				$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow2, $val['JUMLAH_PCS']);
				$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow2, $val['JML_ITEM_SELESAI']);
				$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow2, $val['JML_PCS_SELESAI']);
				$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow2, $val['KETERANGAN'].' '.$val['BON']);
				$excel->getActiveSheet()->mergeCells("B$numrow2:C$numrow2"); 
				$excel->getActiveSheet()->mergeCells("D$numrow2:E$numrow2"); 
				$excel->getActiveSheet()->mergeCells("G$numrow2:H$numrow2"); 
				$excel->getActiveSheet()->getStyle('A'.$numrow2)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('B'.$numrow2)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('C'.$numrow2)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('D'.$numrow2)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('E'.$numrow2)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('F'.$numrow2)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('G'.$numrow2)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('H'.$numrow2)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('I'.$numrow2)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('J'.$numrow2)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('K'.$numrow2)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('L'.$numrow2)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('M'.$numrow2)->applyFromArray($style2);
			$numrow2++;
			$no2++; 
			}

			$krg = $head + count($dataselesai) + 4;
			$krgselesai = $head + count($dataselesai) + 5;
			// Tabel data kekurangan
			$excel->setActiveSheetIndex(0)->setCellValue("A$krg", "5.1 KEKURANGAN DATA SELESAI");
			$excel->setActiveSheetIndex(0)->setCellValue("A$krgselesai", "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue("B$krgselesai", "TANGGAL DIBUAT");
			$excel->setActiveSheetIndex(0)->setCellValue("C$krgselesai", "JENIS SPB");
			$excel->setActiveSheetIndex(0)->setCellValue("D$krgselesai", "NO SPB");
			$excel->setActiveSheetIndex(0)->setCellValue("E$krgselesai", "ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue("G$krgselesai", "DESCRIPTION");
			$excel->setActiveSheetIndex(0)->setCellValue("K$krgselesai", "QTY");
			$excel->setActiveSheetIndex(0)->setCellValue("L$krgselesai", "QTY TERLAYANI");
			$excel->setActiveSheetIndex(0)->setCellValue("M$krgselesai", "KURANG");
			$excel->getActiveSheet()->mergeCells("E$krgselesai:F$krgselesai"); 
			$excel->getActiveSheet()->mergeCells("G$krgselesai:J$krgselesai"); 
			$excel->getActiveSheet()->getStyle("A$krg")->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle("A$krgselesai")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("B$krgselesai")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("C$krgselesai")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("D$krgselesai")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("E$krgselesai")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("F$krgselesai")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("G$krgselesai")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("H$krgselesai")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("I$krgselesai")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("J$krgselesai")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("K$krgselesai")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("L$krgselesai")->applyFromArray($style_col2);
			$excel->getActiveSheet()->getStyle("M$krgselesai")->applyFromArray($style_col2);
			$no3=1;
			$numrow3 = $krgselesai + 1;
			foreach ($dataKurang as $val) {
				if ($val['KURANG'] == '') {
					$kurang = $val['QUANTITY'];
				}else {
					$kurang = $val['KURANG'];
				}
				$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow3, $no3);
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow3, $val['TGL_DIBUAT']);
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow3, $val['JENIS_DOKUMEN']);
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow3, $val['NO_DOKUMEN']);
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow3, $val['ITEM']);
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow3, $val['DESCRIPTION']);
				$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow3, $val['QUANTITY']);
				$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow3, $val['QUANTITY_DELIVERED']);
				$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow3, $kurang);
				$excel->getActiveSheet()->mergeCells("E$numrow3:F$numrow3"); 
				$excel->getActiveSheet()->mergeCells("G$numrow3:J$numrow3"); 
				$excel->getActiveSheet()->getStyle('A'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('B'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('C'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('D'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('E'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('F'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('G'.$numrow3)->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle('I'.$numrow3)->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle('H'.$numrow3)->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle('I'.$numrow3)->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle('J'.$numrow3)->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle('K'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('L'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('M'.$numrow3)->applyFromArray($style2);
			$numrow3++;
			$no3++; 
			}
			
			$cancel = $krgselesai + count($dataKurang) + 4;
			$cancelselesai = $krgselesai + count($dataKurang) + 5;
			// Tabel data kekurangan karna cancel
			$excel->setActiveSheetIndex(0)->setCellValue("A$cancel", "5.2 KEKURANGAN DATA SELESAI");
			$excel->setActiveSheetIndex(0)->setCellValue("A$cancelselesai", "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue("B$cancelselesai", "TANGGAL DIBUAT");
			$excel->setActiveSheetIndex(0)->setCellValue("C$cancelselesai", "JENIS SPB");
			$excel->setActiveSheetIndex(0)->setCellValue("D$cancelselesai", "NO SPB");
			$excel->setActiveSheetIndex(0)->setCellValue("E$cancelselesai", "ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue("G$cancelselesai", "DESCRIPTION");
			$excel->setActiveSheetIndex(0)->setCellValue("M$cancelselesai", "QTY CANCEL");
			$excel->getActiveSheet()->mergeCells("E$cancelselesai:F$cancelselesai"); 
			$excel->getActiveSheet()->mergeCells("G$cancelselesai:L$cancelselesai"); 
			$excel->getActiveSheet()->getStyle("A$cancel")->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle("A$cancelselesai")->applyFromArray($style_col3);
			$excel->getActiveSheet()->getStyle("B$cancelselesai")->applyFromArray($style_col3);
			$excel->getActiveSheet()->getStyle("C$cancelselesai")->applyFromArray($style_col3);
			$excel->getActiveSheet()->getStyle("D$cancelselesai")->applyFromArray($style_col3);
			$excel->getActiveSheet()->getStyle("E$cancelselesai")->applyFromArray($style_col3);
			$excel->getActiveSheet()->getStyle("F$cancelselesai")->applyFromArray($style_col3);
			$excel->getActiveSheet()->getStyle("G$cancelselesai")->applyFromArray($style_col3);
			$excel->getActiveSheet()->getStyle("H$cancelselesai")->applyFromArray($style_col3);
			$excel->getActiveSheet()->getStyle("I$cancelselesai")->applyFromArray($style_col3);
			$excel->getActiveSheet()->getStyle("J$cancelselesai")->applyFromArray($style_col3);
			$excel->getActiveSheet()->getStyle("K$cancelselesai")->applyFromArray($style_col3);
			$excel->getActiveSheet()->getStyle("L$cancelselesai")->applyFromArray($style_col3);
			$excel->getActiveSheet()->getStyle("M$cancelselesai")->applyFromArray($style_col3);
			$no3=1;
			$numrow3 = $cancelselesai + 1;
			foreach ($dataCancel as $val) {
				$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow3, $no3);
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow3, $val['TGL_DIBUAT']);
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow3, $val['JENIS_DOKUMEN']);
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow3, $val['NO_DOKUMEN']);
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow3, $val['ITEM']);
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow3, $val['DESCRIPTION']);
				$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow3, $val['QUANTITY']);
				$excel->getActiveSheet()->mergeCells("E$numrow3:F$numrow3"); 
				$excel->getActiveSheet()->mergeCells("G$numrow3:L$numrow3"); 
				$excel->getActiveSheet()->getStyle('A'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('B'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('C'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('D'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('E'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('F'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('G'.$numrow3)->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle('H'.$numrow3)->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle('I'.$numrow3)->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle('J'.$numrow3)->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle('K'.$numrow3)->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle('L'.$numrow3)->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle('M'.$numrow3)->applyFromArray($style2);
			$numrow3++;
			$no3++; 
			}

			$jml = $cancelselesai + count($dataCancel) + 4;
			$jumlah = $cancelselesai + count($dataCancel) + 5;
			// Tabel data jumlah cancel, pending, bon,langsung
			$excel->setActiveSheetIndex(0)->setCellValue("A$jml", "6. JUMLAH DATA");
			$excel->setActiveSheetIndex(0)->setCellValue("A$jumlah", "NO");
			$excel->setActiveSheetIndex(0)->setCellValue("B$jumlah", "TANGGAL");
			$excel->setActiveSheetIndex(0)->setCellValue("D$jumlah", "JUMLAH SELESAI");
			$excel->setActiveSheetIndex(0)->setCellValue("F$jumlah", "JUMLAH KURANG");
			$excel->setActiveSheetIndex(0)->setCellValue("H$jumlah", "TOTAL");
			$excel->getActiveSheet()->mergeCells("B$jumlah:C$jumlah"); 
			$excel->getActiveSheet()->mergeCells("D$jumlah:E$jumlah"); 
			$excel->getActiveSheet()->mergeCells("F$jumlah:G$jumlah"); 
			$excel->getActiveSheet()->mergeCells("H$jumlah:I$jumlah"); 
			$excel->getActiveSheet()->getStyle("A$jml")->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle("A$jumlah")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("B$jumlah")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("C$jumlah")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("D$jumlah")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("E$jumlah")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("F$jumlah")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("G$jumlah")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("H$jumlah")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("I$jumlah")->applyFromArray($style_col);
			$no = 1;
			$numrow4 = $jumlah + 1;
			foreach ($dataket as $val) {
				$total = $val['jml_selesai'] + $val['krg_selesai'];
				$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow4, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow4, $val['tanggal']);
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow4, $val['jml_selesai']);
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow4, $val['krg_selesai']);
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow4, $total);
				$excel->getActiveSheet()->mergeCells("B$numrow4:C$numrow4"); 
				$excel->getActiveSheet()->mergeCells("D$numrow4:E$numrow4"); 
				$excel->getActiveSheet()->mergeCells("F$numrow4:G$numrow4"); 
				$excel->getActiveSheet()->mergeCells("H$numrow4:I$numrow4"); 
				$excel->getActiveSheet()->getStyle('A'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('B'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('C'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('D'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('E'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('F'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('G'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('H'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('I'.$numrow4)->applyFromArray($style2);
				$no++;
				$numrow4++;
			}

			$jml2 = $jumlah + count($dataket) + 4;
			$jml3 = $jumlah + count($dataket) + 5;
			$jumlah2 = $jumlah + count($dataket) + 6;
			$jumlah3 = $jumlah + count($dataket) + 7;
			// Tabel data jumlah cancel, pending, bon,langsung

			$masuk = $this->jadigini($ket);
			$can 	= $this->M_monitoring->getcancel($tglAwal[0], $tglAkhir[0]);
			$cancel = $this->jadigini($can);
			$pdg 	= $this->M_monitoring->jml_pending2();
			$pending = $this->jadibelum($pdg);
			$query = "where selesai_pelayanan is null and (bon != 'PENDING' or bon is null)";
			$plyn 	= $this->M_monitoring->getDataSPB($query);
			$pelayanan = $this->jadiin($plyn, 'plyn');
			$query = "where selesai_pelayanan is not null and selesai_pengeluaran is null and (bon != 'BON' or bon is null)";
			$pglr 	= $this->M_monitoring->getDataSPB($query);
			$pengeluaran = $this->jadiin($pglr, 'pglr');
			$query = "where selesai_pengeluaran is not null and selesai_packing is null and (bon is null or bon = 'BEST')";
			$pck 	= $this->M_monitoring->getDataSPB($query);
			$packing = $this->jadiin($pck, 'pck');
			$dikerjain = $this->jadiin($dataselesai, 'dkr');
			$kurang = $this->jadiin2($dataKurang, $dataCancel);
			$selesai = $this->jadiin($dataselesai, 'selesai');
			
			$excel->setActiveSheetIndex(0)->setCellValue("A$jml2", "6.1 KETERANGAN DATA");
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$jml3, "A. MASUK"); 
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$jumlah2, "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$jumlah2, "KETERANGAN");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$jumlah2, "DO");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$jumlah3, "LEMBAR");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$jumlah3, "ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$jumlah3, "PCS");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$jumlah2, "SPB");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$jumlah3, "LEMBAR");
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$jumlah3, "ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$jumlah3, "PCS");
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$jumlah2, "JUMLAH");
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$jumlah3, "LEMBAR");
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$jumlah3, "ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$jumlah3, "PCS");
			$excel->getActiveSheet()->mergeCells("A$jumlah2:A$jumlah3"); 
			$excel->getActiveSheet()->mergeCells("B$jumlah2:B$jumlah3"); 
			$excel->getActiveSheet()->mergeCells("C$jumlah2:E$jumlah2"); 
			$excel->getActiveSheet()->mergeCells("F$jumlah2:H$jumlah2"); 
			$excel->getActiveSheet()->mergeCells("I$jumlah2:K$jumlah2"); 
			$excel->getActiveSheet()->getStyle('A'.$jml2)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('A'.$jml3)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('A'.$jumlah2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('A'.$jumlah3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B'.$jumlah2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B'.$jumlah3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C'.$jumlah2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C'.$jumlah3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D'.$jumlah2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D'.$jumlah3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E'.$jumlah2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E'.$jumlah3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F'.$jumlah2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F'.$jumlah3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G'.$jumlah2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G'.$jumlah3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H'.$jumlah2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H'.$jumlah3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I'.$jumlah2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I'.$jumlah3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J'.$jumlah2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J'.$jumlah3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K'.$jumlah2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K'.$jumlah3)->applyFromArray($style_col);
	
			$no=1;
			$numrow = $jumlah3 + 1;
			$h4 = $numrow+5;
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, "URGENT");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($numrow+1), 'TIDAK URGENT');
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($numrow+2), "BON");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($numrow+3), "LANGSUNG");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($numrow+4), "BEST");
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$h4, "JUMLAH");
			$excel->getActiveSheet()->mergeCells("A$h4:B$h4"); 
				foreach ($masuk as $val) {
					$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $val['lembar1']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $val['item1']);
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $val['pcs1']);
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $val['lembar2']);
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $val['item2']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $val['pcs2']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, ($val['lembar1'] + $val['lembar2']));
					$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, ($val['item1'] + $val['item2']));
					$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, ($val['pcs1'] + $val['pcs2']));
					$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style3);
					$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style2);
				$numrow++;
				$no++; 
				}
				$awl = $numrow - 5;
				$akh = $numrow - 1;
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$h4, "=SUM(C$awl:C$akh)");
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$h4, "=SUM(D$awl:D$akh)");
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$h4, "=SUM(E$awl:E$akh)");
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$h4, "=SUM(F$awl:F$akh)");
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$h4, "=SUM(G$awl:G$akh)");
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$h4, "=SUM(H$awl:H$akh)");
				$excel->setActiveSheetIndex(0)->setCellValue('I'.$h4, "=SUM(I$awl:I$akh)");
				$excel->setActiveSheetIndex(0)->setCellValue('J'.$h4, "=SUM(J$awl:J$akh)");
				$excel->setActiveSheetIndex(0)->setCellValue('K'.$h4, "=SUM(K$awl:K$akh)");
				$excel->getActiveSheet()->getStyle('A'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('B'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('C'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('D'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('E'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('F'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('G'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('H'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('I'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('J'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('K'.$h4)->applyFromArray($style2);
	
				// TABEL DOSPB
			$h1 = $numrow + 4;
			$h2 = $numrow + 5;
			$h3 = $numrow + 6;
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$h1, "B. CANCEL"); 
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$h2, "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$h2, "KETERANGAN");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$h2, "DO");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$h3, "LEMBAR");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$h3, "ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$h3, "PCS");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$h2, "SPB");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$h3, "LEMBAR");
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$h3, "ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$h3, "PCS");
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$h2, "JUMLAH");
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$h3, "LEMBAR");
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$h3, "ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$h3, "PCS");
			$excel->getActiveSheet()->mergeCells("A$h2:A$h3"); 
			$excel->getActiveSheet()->mergeCells("B$h2:B$h3"); 
			$excel->getActiveSheet()->mergeCells("C$h2:E$h2"); 
			$excel->getActiveSheet()->mergeCells("F$h2:H$h2"); 
			$excel->getActiveSheet()->mergeCells("I$h2:K$h2"); 
			$excel->getActiveSheet()->getStyle('A'.$h1)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('A'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('A'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K'.$h3)->applyFromArray($style_col);
	
			$no=1;
			$numrow2 = $h3 + 1;
			$h4 = $numrow2+5;
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow2, "URGENT");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($numrow2+1), 'TIDAK URGENT');
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($numrow2+2), "BON");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($numrow2+3), "LANGSUNG");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($numrow2+4), "BEST");
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$h4, "JUMLAH");
			$excel->getActiveSheet()->mergeCells("A$h4:B$h4"); 
				foreach ($cancel as $val) {
					$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow2, $no);
					$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow2, $val['lembar1']);
					$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow2, $val['item1']);
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow2, $val['pcs1']);
					$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow2, $val['lembar2']);
					$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow2, $val['item2']);
					$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow2, $val['pcs2']);
					$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow2, ($val['lembar1'] + $val['lembar2']));
					$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow2, ($val['item1'] + $val['item2']));
					$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow2, ($val['pcs1'] + $val['pcs2']));
					$excel->getActiveSheet()->getStyle('A'.$numrow2)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('B'.$numrow2)->applyFromArray($style3);
					$excel->getActiveSheet()->getStyle('C'.$numrow2)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('D'.$numrow2)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('E'.$numrow2)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('F'.$numrow2)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('G'.$numrow2)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('H'.$numrow2)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('I'.$numrow2)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('J'.$numrow2)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('K'.$numrow2)->applyFromArray($style2);
				$numrow2++;
				$no++; 
				}
				$awl = $numrow2 - 5;
				$akh = $numrow2 - 1;
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$h4, "=SUM(C$awl:C$akh)");
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$h4, "=SUM(D$awl:D$akh)");
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$h4, "=SUM(E$awl:E$akh)");
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$h4, "=SUM(F$awl:F$akh)");
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$h4, "=SUM(G$awl:G$akh)");
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$h4, "=SUM(H$awl:H$akh)");
				$excel->setActiveSheetIndex(0)->setCellValue('I'.$h4, "=SUM(I$awl:I$akh)");
				$excel->setActiveSheetIndex(0)->setCellValue('J'.$h4, "=SUM(J$awl:J$akh)");
				$excel->setActiveSheetIndex(0)->setCellValue('K'.$h4, "=SUM(K$awl:K$akh)");
				$excel->getActiveSheet()->getStyle('A'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('B'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('C'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('D'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('E'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('F'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('G'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('H'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('I'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('J'.$h4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('K'.$h4)->applyFromArray($style2);
	
				
			$h1 = $numrow2 + 4;
			$h2 = $numrow2 + 5;
			$h3 = $numrow2 + 6;
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$h1, "C. PACKING"); 
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$h2, "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$h2, "KETERANGAN");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$h2, "DO");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$h3, "LEMBAR");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$h3, "ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$h3, "PCS");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$h2, "SPB");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$h3, "LEMBAR");
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$h3, "ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$h3, "PCS");
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$h2, "JUMLAH");
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$h3, "LEMBAR");
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$h3, "ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$h3, "PCS");
			$excel->getActiveSheet()->mergeCells("A$h2:A$h3"); 
			$excel->getActiveSheet()->mergeCells("B$h2:B$h3"); 
			$excel->getActiveSheet()->mergeCells("C$h2:E$h2"); 
			$excel->getActiveSheet()->mergeCells("F$h2:H$h2"); 
			$excel->getActiveSheet()->mergeCells("I$h2:K$h2"); 
			$excel->getActiveSheet()->getStyle('A'.$h1)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('A'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('A'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K'.$h3)->applyFromArray($style_col);
	
			$no=1;
			$numrow3 = $h3 + 1;
			$h4 = $numrow3 + 2;
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow3, "DIKERJAKAN");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow3, $dikerjain[0]['lembar1']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow3, $dikerjain[0]['item1']);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow3, $dikerjain[0]['pcs1']);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow3, $dikerjain[0]['lembar2']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow3, $dikerjain[0]['item2']);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow3, $dikerjain[0]['pcs2']);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow3, ($dikerjain[0]['lembar1'] + $dikerjain[0]['lembar2']));
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow3, ($dikerjain[0]['item1'] + $dikerjain[0]['item2']));
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow3, ($dikerjain[0]['pcs1'] + $dikerjain[0]['pcs2']));
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($numrow3+1), 'KURANG');
			$excel->setActiveSheetIndex(0)->setCellValue('C'.($numrow3+1), $kurang[0]['lembar1']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow3+1), $kurang[0]['item1']);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.($numrow3+1), $kurang[0]['pcs1']);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.($numrow3+1), $kurang[0]['lembar2']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.($numrow3+1), $kurang[0]['item2']);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.($numrow3+1), $kurang[0]['pcs2']);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.($numrow3+1), ($kurang[0]['lembar1'] + $kurang[0]['lembar2']));
			$excel->setActiveSheetIndex(0)->setCellValue('J'.($numrow3+1), ($kurang[0]['item1'] + $kurang[0]['item2']));
			$excel->setActiveSheetIndex(0)->setCellValue('K'.($numrow3+1), ($kurang[0]['pcs1'] + $kurang[0]['pcs2']));
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$h4, "SELESAI");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$h4, $selesai[0]['lembar1']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$h4, $selesai[0]['item1']);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$h4, $selesai[0]['pcs1']);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$h4, $selesai[0]['lembar2']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$h4, $selesai[0]['item2']);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$h4, $selesai[0]['pcs2']);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$h4, ($selesai[0]['lembar1'] + $selesai[0]['lembar2']));
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$h4, ($selesai[0]['item1'] + $selesai[0]['item2']));
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$h4, ($selesai[0]['pcs1'] + $selesai[0]['pcs2']));
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($numrow3+3), "JUMLAH");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.($numrow3+3), "=SUM(C$numrow3:C$h4)");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow3+3), "=SUM(D$numrow3:D$h4)");
			$excel->setActiveSheetIndex(0)->setCellValue('E'.($numrow3+3), "=SUM(E$numrow3:E$h4)");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.($numrow3+3), "=SUM(F$numrow3:F$h4)");
			$excel->setActiveSheetIndex(0)->setCellValue('G'.($numrow3+3), "=SUM(G$numrow3:G$h4)");
			$excel->setActiveSheetIndex(0)->setCellValue('H'.($numrow3+3), "=SUM(H$numrow3:H$h4)");
			$excel->setActiveSheetIndex(0)->setCellValue('I'.($numrow3+3), "=SUM(I$numrow3:I$h4)");
			$excel->setActiveSheetIndex(0)->setCellValue('J'.($numrow3+3), "=SUM(J$numrow3:J$h4)");
			$excel->setActiveSheetIndex(0)->setCellValue('K'.($numrow3+3), "=SUM(K$numrow3:K$h4)");
				for ($i=1; $i < 5; $i++) { 
					$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow3, $i);
					$excel->getActiveSheet()->getStyle('A'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('B'.$numrow3)->applyFromArray($style3);
					$excel->getActiveSheet()->getStyle('C'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('D'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('E'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('F'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('G'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('H'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('I'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('J'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('K'.$numrow3)->applyFromArray($style2);
					$numrow3++;
				}			
	
				
			$h1 = $numrow3 + 3;
			$h2 = $numrow3 + 4;
			$h3 = $numrow3 + 5;
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$h1, "D. PACKING DALAM COLY"); 
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$h2, "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$h2, "JENIS COLY");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$h2, "JUMLAH");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$h3, "Kardus Kecil");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($h3+1), "Kardus Sedang");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($h3+2), "Kardus Panjang");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($h3+3), "Karung");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($h3+4), "Peti");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$h3, $coly['dus_kecil']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.($h3+1), $coly['dus_sdg']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.($h3+2), $coly['dus_pjg']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.($h3+3), $coly['karung']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.($h3+4), $coly['peti']);
			$excel->getActiveSheet()->getStyle('A'.$h1)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('A'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C'.$h2)->applyFromArray($style_col);
			$no = 1;
			foreach ($coly as $key => $value) {
				$excel->setActiveSheetIndex(0)->setCellValue('A'.$h3, $no);
				$excel->getActiveSheet()->getStyle('A'.$h3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('B'.$h3)->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle('C'.$h3)->applyFromArray($style2);
				$h3 = $h3 + 1;
				$no++;
			}
	
			$h1 = $h3 + 3;
			$h2 = $h3 + 4;
			$h3 = $h3 + 5;
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$h1, "E. DOSP/SPB BELUM DIKERJAKAN"); 
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$h2, "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$h2, "KETERANGAN");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$h2, "DO");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$h3, "LEMBAR");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$h3, "ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$h3, "PCS");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$h2, "SPB");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$h3, "LEMBAR");
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$h3, "ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$h3, "PCS");
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$h2, "JUMLAH");
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$h3, "LEMBAR");
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$h3, "ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$h3, "PCS");
			$excel->getActiveSheet()->mergeCells("A$h2:A$h3"); 
			$excel->getActiveSheet()->mergeCells("B$h2:B$h3"); 
			$excel->getActiveSheet()->mergeCells("C$h2:E$h2"); 
			$excel->getActiveSheet()->mergeCells("F$h2:H$h2"); 
			$excel->getActiveSheet()->mergeCells("I$h2:K$h2"); 
			$excel->getActiveSheet()->getStyle('A'.$h1)->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('A'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('A'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J'.$h3)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K'.$h2)->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K'.$h3)->applyFromArray($style_col);
	
			$no=1;
			$numrow3 = $h3 + 1;
			$h4 = $numrow3+3;
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow3, "PENDING");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow3, $pending[0]['lembar1']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow3, $pending[0]['item1']);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow3, $pending[0]['pcs1']);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow3, $pending[0]['lembar2']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow3, $pending[0]['item2']);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow3, $pending[0]['pcs2']);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow3, ($pending[0]['lembar1'] + $pending[0]['lembar2']));
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow3, ($pending[0]['item1'] + $pending[0]['item2']));
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow3, ($pending[0]['pcs1'] + $pending[0]['pcs2']));
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($numrow3+1), 'PELAYANAN');
			$excel->setActiveSheetIndex(0)->setCellValue('C'.($numrow3+1), $pelayanan[0]['lembar1']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow3+1), $pelayanan[0]['item1']);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.($numrow3+1), $pelayanan[0]['pcs1']);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.($numrow3+1), $pelayanan[0]['lembar2']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.($numrow3+1), $pelayanan[0]['item2']);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.($numrow3+1), $pelayanan[0]['pcs2']);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.($numrow3+1), ($pelayanan[0]['lembar1'] + $pelayanan[0]['lembar2']));
			$excel->setActiveSheetIndex(0)->setCellValue('J'.($numrow3+1), ($pelayanan[0]['item1'] + $pelayanan[0]['item2']));
			$excel->setActiveSheetIndex(0)->setCellValue('K'.($numrow3+1), ($pelayanan[0]['pcs1'] + $pelayanan[0]['pcs2']));
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($numrow3+2), "PENGELUARAN");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.($numrow3+2), $pengeluaran[0]['lembar1']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow3+2), $pengeluaran[0]['item1']);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.($numrow3+2), $pengeluaran[0]['pcs1']);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.($numrow3+2), $pengeluaran[0]['lembar2']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.($numrow3+2), $pengeluaran[0]['item2']);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.($numrow3+2), $pengeluaran[0]['pcs2']);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.($numrow3+2), ($pengeluaran[0]['lembar1'] + $pengeluaran[0]['lembar2']));
			$excel->setActiveSheetIndex(0)->setCellValue('J'.($numrow3+2), ($pengeluaran[0]['item1'] + $pengeluaran[0]['item2']));
			$excel->setActiveSheetIndex(0)->setCellValue('K'.($numrow3+2), ($pengeluaran[0]['pcs1'] + $pengeluaran[0]['pcs2']));
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$h4, "PACKING");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$h4, $packing[0]['lembar1']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$h4, $packing[0]['item1']);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$h4, $packing[0]['pcs1']);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$h4, $packing[0]['lembar2']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$h4, $packing[0]['item2']);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$h4, $packing[0]['pcs2']);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$h4, ($packing[0]['lembar1'] + $packing[0]['lembar2']));
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$h4, ($packing[0]['item1'] + $packing[0]['item2']));
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$h4, ($packing[0]['pcs1'] + $packing[0]['pcs2']));
			$excel->setActiveSheetIndex(0)->setCellValue('B'.($numrow3+4), "JUMLAH");
			$excel->setActiveSheetIndex(0)->setCellValue('C'.($numrow3+4), "=SUM(C$numrow3:C$h4)");
			$excel->setActiveSheetIndex(0)->setCellValue('D'.($numrow3+4), "=SUM(D$numrow3:D$h4)");
			$excel->setActiveSheetIndex(0)->setCellValue('E'.($numrow3+4), "=SUM(E$numrow3:E$h4)");
			$excel->setActiveSheetIndex(0)->setCellValue('F'.($numrow3+4), "=SUM(F$numrow3:F$h4)");
			$excel->setActiveSheetIndex(0)->setCellValue('G'.($numrow3+4), "=SUM(G$numrow3:G$h4)");
			$excel->setActiveSheetIndex(0)->setCellValue('H'.($numrow3+4), "=SUM(H$numrow3:H$h4)");
			$excel->setActiveSheetIndex(0)->setCellValue('I'.($numrow3+4), "=SUM(I$numrow3:I$h4)");
			$excel->setActiveSheetIndex(0)->setCellValue('J'.($numrow3+4), "=SUM(J$numrow3:J$h4)");
			$excel->setActiveSheetIndex(0)->setCellValue('K'.($numrow3+4), "=SUM(K$numrow3:K$h4)");
				for ($i=1; $i < 6; $i++) { 
					$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow3, $i);
					$excel->getActiveSheet()->getStyle('A'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('B'.$numrow3)->applyFromArray($style3);
					$excel->getActiveSheet()->getStyle('C'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('D'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('E'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('F'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('G'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('H'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('I'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('J'.$numrow3)->applyFromArray($style2);
					$excel->getActiveSheet()->getStyle('K'.$numrow3)->applyFromArray($style2);
					$numrow3++;
				}			

			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); 
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(13); 
			$excel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('K')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('L')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$excel->getActiveSheet()->getColumnDimension('N')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('O')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('P')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('R')->setWidth(13);

			// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
			$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
			// Set orientasi kertas jadi LANDSCAPE
			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			// Set judul file excel nya
			$excel->getActiveSheet(0)->setTitle("Kapasitas Gudang Sparepart");
			$excel->setActiveSheetIndex(0);
			// Proses file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="Kapasitas_Gudang_Sparepart.xlsx"'); 
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');


	}

	public function Keterangan(){
		$tglAwal 		= $this->input->post('tglAwal[]');
		$tglAkhir 		= $this->input->post('tglAkhir[]');
		$tanggal 		= $this->input->post('tanggalnya[]');
		$jml_selesai 	= $this->input->post('jml_pcs_selesai[]');
		$krg_selesai 	= $this->input->post('krg_selesai[]');

		$ketdata = array();
		for ($t=0; $t < count($tanggal); $t++) { 
			$ketdata['tgl'][] = $tanggal[$t];
			$ketdata['jml'][] = $jml_selesai[$t];
			$ketdata['krg'][] = $krg_selesai[$t];
		}
		// echo "<pre>";print_r($ketdata);exit();

		$ket 		= $this->M_monitoring->dataKeterangan($tglAwal[0], $tglAkhir[0]);
		$masuk 		= $this->jadigini($ket);
		$can 		= $this->M_monitoring->getcancel($tglAwal[0], $tglAkhir[0]);
		$cancel 	= $this->jadigini($can);
		$pdg 		= $this->M_monitoring->jml_pending2();
		$pending 	= $this->jadibelum($pdg);
		$query		= "where selesai_pelayanan is null and (bon != 'PENDING' or bon is null)";
		$plyn 		= $this->M_monitoring->getDataSPB($query);
		$pelayanan 	= $this->jadiin($plyn, 'plyn');
		$query 		= "where selesai_pelayanan is not null and selesai_pengeluaran is null and (bon != 'BON' or bon is null)";
		$pglr 		= $this->M_monitoring->getDataSPB($query);
		$pengeluaran = $this->jadiin($pglr, 'pglr');
		$query 		= "where selesai_pengeluaran is not null and selesai_packing is null and (bon is null or bon = 'BEST')";
		$pck 		= $this->M_monitoring->getDataSPB($query);
		$packing 	= $this->jadiin($pck, 'pck');
		$dataselesai = $this->M_monitoring->dataselesai($tglAwal[0], $tglAkhir[0]);
		$dataKurang = $this->M_monitoring->dataKurangselesai($tglAwal[0], $tglAkhir[0]);
		$dataCancel = $this->M_monitoring->diCancel($tglAwal[0], $tglAkhir[0]);
		$dikerjain 	= $this->jadiin($dataselesai, 'dkr');
		$kurang 	= $this->jadiin2($dataKurang, $dataCancel);
		$selesai 	= $this->jadiin($dataselesai, 'selesai');

		$cari = $this->jaditoo($dataselesai);
		$coly = array(
			'Kardus Kecil' 	=> $cari['dus_kecil'],
			'Kardus Sedang' => $cari['dus_sdg'],
			'Kardus Panjang' => $cari['dus_pjg'],
			'Karung' 		=> $cari['karung'],
			'Peti' 			=> $cari['peti'],
		);

		$pack = array(
			'0' => $dikerjain[0],
			'1' => $kurang[0],
			'2' => $selesai[0],
		);

		$belum = array(
			'0' => $pending[0],
			'1' => $pelayanan[0],
			'2' => $pengeluaran[0],
			'3' => $packing[0],
		);

		$data['data'] = array(
			'masuk' 	=> $masuk,
			'cancel' 	=> $cancel,
			'packing' 	=> $pack,
			'coly' 		=> $coly,
			'belum' 	=> $belum,
			'tglawal' 	=> $tglAwal[0],
			'tglakhir' 	=> $tglAkhir[0],
			'ket' 		=> $ketdata,
			'tanggal' 	=> $tanggal[0].' s/d '.$tanggal[count($tanggal)-1]
		);
		// echo "<pre>";print_r($data['data']);
		// exit();

		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring Kapasitas Gudang';
		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KapasitasGdSparepart/V_KetMonitoring', $data);
		$this->load->view('V_Footer',$data);
	}

	public function itungcolly($cari_coly, $ket){
		$data['DUS_KECIL'] = $data['DUS_SEDANG'] = $data['DUS_PANJANG'] = 0;
		$data['KARUNG'] = $data['PETI'] = 0;
		foreach ($cari_coly as $val) {
			if ($ket == 'coly1') {
				if ($val['kode_packing'] == 1) {
					$data['DUS_KECIL'] += 1;
				}elseif ($val['kode_packing'] == 2) {
					$data['DUS_SEDANG'] += 1;
				}elseif ($val['kode_packing'] == 3) {
					$data['DUS_PANJANG'] += 1;
				}elseif ($val['kode_packing'] == 4) {
					$data['KARUNG'] += 1;
				}elseif ($val['kode_packing'] == 5) {
					$data['PETI'] += 1;
				}
			}else {
				if ($val['JENIS'] == 'KARDUS KECIL') {
					$data['DUS_KECIL'] += 1;
				}elseif ($val['JENIS'] == 'KARDUS SEDANG') {
					$data['DUS_SEDANG'] += 1;
				}elseif ($val['JENIS'] == 'KARDUS PANJANG') {
					$data['DUS_PANJANG'] += 1;
				}elseif ($val['JENIS'] == 'KARUNG') {
					$data['KARUNG'] += 1;
				}elseif ($val['JENIS'] == 'PETI') {
					$data['PETI'] += 1;
				}
			}
		}
		return $data;
	}

	public function convers_time($waktu){
		$jam = floor($waktu/(60*60));
		$menit = $waktu - $jam * (60 * 60);
		$htgmenit = floor($menit/60) * 60;
		$detik = $menit - $htgmenit;
		return $jam.':'.floor($menit/60).':'.$detik;
	}


	public function report_period(){
		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$getdata = $this->M_monitoring->data_report_period($tgl_awal, $tgl_akhir);
		$datacoly = array();
		$waktu_pelayanan = $waktu_packing = 0;
		foreach ($getdata as $key => $value) {
			$getdata[$key]['DUS_KECIL'] = $getdata[$key]['DUS_SEDANG'] = $getdata[$key]['DUS_PANJANG'] = 0;
			$getdata[$key]['KARUNG'] = $getdata[$key]['PETI'] = $getdata[$key]['JUMLAH'] = 0;
			$cari_coly = $this->M_monitoring->getDataColly($value['NO_DOKUMEN']);
			$cari_coly2 = $this->M_monitoring->getDataColly2($value['NO_DOKUMEN']);
			if (!empty($cari_coly)) {
				$hitung = $this->itungcolly($cari_coly, 'coly1');
				$getdata[$key]['DUS_KECIL'] 	= $hitung['DUS_KECIL'];
				$getdata[$key]['DUS_SEDANG'] 	= $hitung['DUS_SEDANG'];
				$getdata[$key]['DUS_PANJANG'] 	= $hitung['DUS_PANJANG'];
				$getdata[$key]['KARUNG'] 		= $hitung['KARUNG'];
				$getdata[$key]['PETI'] 			= $hitung['PETI'];
			}
			if (!empty($cari_coly2)) {
				$hitung = $this->itungcolly($cari_coly2, 'coly2');
				$getdata[$key]['DUS_KECIL'] 	= $hitung['DUS_KECIL'];
				$getdata[$key]['DUS_SEDANG'] 	= $hitung['DUS_SEDANG'];
				$getdata[$key]['DUS_PANJANG'] 	= $hitung['DUS_PANJANG'];
				$getdata[$key]['KARUNG'] 		= $hitung['KARUNG'];
				$getdata[$key]['PETI'] 			= $hitung['PETI'];
			}
			$waktu_pelayanan += $value['DETIK_PELAYANAN'];
			$waktu_packing += $value['DETIK_PACKING'];
		}
		
		// echo "<pre>";print_r($waktu_packing);exit();
		include APPPATH.'third_party/Excel/PHPExcel.php';
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('CV. KHS')
					->setLastModifiedBy('Quick')
					->setTitle("Kapasitas Gudang Sparepart")
					->setSubject("CV. KHS")
					->setDescription("Kapasitas Gudang Sparepart")
					->setKeywords("KGS");
		
		$style_head = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'ACD4FF'),
			),
			'font' => array('bold' => true), 
			'alignment' => array(
				'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'		=> true
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		
		$style_head2 = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'BDF7C9'),
			),
			'font' => array('bold' => true), 
			'alignment' => array(
				'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'		=> true
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		
		$style_col = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'		 => true
			),
			'borders' => array(
				'top' 		=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 		=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Tanggal Input : ".$tgl_awal." - ".$tgl_akhir.""); 
		$excel->getActiveSheet()->mergeCells("A1:AE1"); 
		
		$excel->setActiveSheetIndex(0)->setCellValue("A3", "No"); // rowspan 3
		$excel->getActiveSheet()->mergeCells("A3:A5"); 
		$excel->getActiveSheet()->getStyle('A3:A5')->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("B3", "Input"); //colspan 2
		$excel->getActiveSheet()->mergeCells("B3:C3"); 
		$excel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("B4", "Tanggal"); // rowspan 2
		$excel->getActiveSheet()->mergeCells("B4:B5"); 
		$excel->getActiveSheet()->getStyle("B4:B5")->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("C4", "Jam");// rowspan 2
		$excel->getActiveSheet()->mergeCells("C4:C5"); 
		$excel->getActiveSheet()->getStyle("C4:C5")->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("D3", "Dokumen"); // colspan 5
		$excel->getActiveSheet()->mergeCells("D3:H3"); 
		$excel->getActiveSheet()->getStyle("D3:H3")->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("D4", "Jenis");// rowspan 2
		$excel->getActiveSheet()->mergeCells("D4:D5"); 
		$excel->getActiveSheet()->getStyle("D4:D5")->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("E4", "Nomor");// rowspan 2
		$excel->getActiveSheet()->mergeCells("E4:E5"); 
		$excel->getActiveSheet()->getStyle("E4:E5")->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("F4", "Jumlah Item");// rowspan 2
		$excel->getActiveSheet()->mergeCells("F4:F5"); 
		$excel->getActiveSheet()->getStyle("F4:F5")->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("G4", "Jumlah Pcs");// rowspan 2
		$excel->getActiveSheet()->mergeCells("G4:G5"); 
		$excel->getActiveSheet()->getStyle("G4:G5")->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("H4", "Ket");// rowspan 2
		$excel->getActiveSheet()->mergeCells("H4:H5"); 
		$excel->getActiveSheet()->getStyle("H4:H5")->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("I3", "Pelayanan"); //colspan 10
		$excel->getActiveSheet()->mergeCells("I3:R3"); 
		$excel->getActiveSheet()->getStyle("I3:R3")->applyFromArray($style_head2);
		$excel->setActiveSheetIndex(0)->setCellValue("I4", "PIC"); // rowspan 2
		$excel->getActiveSheet()->mergeCells("I4:I5"); 
		$excel->getActiveSheet()->getStyle("I4:I5")->applyFromArray($style_head2);
		$excel->setActiveSheetIndex(0)->setCellValue("J4", "Mulai"); //COLSPAN2
		$excel->getActiveSheet()->mergeCells("J4:K4"); 
		$excel->getActiveSheet()->getStyle("J4:K4")->applyFromArray($style_head2);
		$excel->setActiveSheetIndex(0)->setCellValue("J5", "Tanggal");
		$excel->getActiveSheet()->getStyle("J5")->applyFromArray($style_head2);
		$excel->setActiveSheetIndex(0)->setCellValue("K5", "Jam");
		$excel->getActiveSheet()->getStyle("K5")->applyFromArray($style_head2);
		$excel->setActiveSheetIndex(0)->setCellValue("L4", "Selesai"); //COLSPAN2
		$excel->getActiveSheet()->mergeCells("L4:M4"); 
		$excel->getActiveSheet()->getStyle("L4:M4")->applyFromArray($style_head2);
		$excel->setActiveSheetIndex(0)->setCellValue("L5", "Tanggal");
		$excel->getActiveSheet()->getStyle("L5")->applyFromArray($style_head2);
		$excel->setActiveSheetIndex(0)->setCellValue("M5", "Jam");
		$excel->getActiveSheet()->getStyle("M5")->applyFromArray($style_head2);
		$excel->setActiveSheetIndex(0)->setCellValue("N4", "Waktu");// rowspan 2
		$excel->getActiveSheet()->mergeCells("N4:N5"); 
		$excel->getActiveSheet()->getStyle("N4:N5")->applyFromArray($style_head2);
		$excel->setActiveSheetIndex(0)->setCellValue("O4", "Terpenuhi");//COLSPAN2
		$excel->getActiveSheet()->mergeCells("O4:P4"); 
		$excel->getActiveSheet()->getStyle("O4:P4")->applyFromArray($style_head2);
		$excel->setActiveSheetIndex(0)->setCellValue("O5", "Item");
		$excel->getActiveSheet()->getStyle("O5")->applyFromArray($style_head2);
		$excel->setActiveSheetIndex(0)->setCellValue("P5", "Pcs");
		$excel->getActiveSheet()->getStyle("P5")->applyFromArray($style_head2);
		$excel->setActiveSheetIndex(0)->setCellValue("Q4", "Tidak Terpenuhi");//COLSPAN2
		$excel->getActiveSheet()->mergeCells("Q4:R4"); 
		$excel->getActiveSheet()->getStyle("Q4:R4")->applyFromArray($style_head2);
		$excel->setActiveSheetIndex(0)->setCellValue("Q5", "Item");
		$excel->getActiveSheet()->getStyle("Q5")->applyFromArray($style_head2);
		$excel->setActiveSheetIndex(0)->setCellValue("R5", "Pcs");
		$excel->getActiveSheet()->getStyle("R5")->applyFromArray($style_head2);
		$excel->setActiveSheetIndex(0)->setCellValue("S3", "Packing"); //colspan 13
		$excel->getActiveSheet()->mergeCells("S3:AF3"); 
		$excel->getActiveSheet()->getStyle("S3:AF3")->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("S4", "PIC"); // rowspan 2
		$excel->getActiveSheet()->mergeCells("S4:S5"); 
		$excel->getActiveSheet()->getStyle("S4:S5")->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("T4", "Mulai"); //COLSPAN2
		$excel->getActiveSheet()->mergeCells("T4:U4"); 
		$excel->getActiveSheet()->getStyle("T4:U4")->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("T5", "Tanggal");
		$excel->getActiveSheet()->getStyle('T5')->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("U5", "Jam");
		$excel->getActiveSheet()->getStyle('U5')->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("V4", "Selesai"); //COLSPAN2
		$excel->getActiveSheet()->mergeCells("V4:W4"); 
		$excel->getActiveSheet()->getStyle("V4:W4")->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("V5", "Tanggal");
		$excel->getActiveSheet()->getStyle('V5')->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("W5", "Jam");
		$excel->getActiveSheet()->getStyle('W5')->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("X4", "Waktu"); // rowspan 2
		$excel->getActiveSheet()->mergeCells("X4:X5"); 
		$excel->getActiveSheet()->getStyle("X4:X5")->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("Y4", "Item"); // rowspan 2
		$excel->getActiveSheet()->mergeCells("Y4:Y5"); 
		$excel->getActiveSheet()->getStyle("Y4:Y5")->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("Z4", "Pcs"); // rowspan 2
		$excel->getActiveSheet()->mergeCells("Z4:Z5"); 
		$excel->getActiveSheet()->getStyle("Z4:Z5")->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("AA4", "Coly"); //COLSPAN 6
		$excel->getActiveSheet()->mergeCells("AA4:AF4"); 
		$excel->getActiveSheet()->getStyle("AA4:AF4")->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("AA5", "Dus Kecil");
		$excel->getActiveSheet()->getStyle('AA5')->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("AB5", "Dus Sedang");
		$excel->getActiveSheet()->getStyle('AB5')->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("AC5", "Dus Panjang");
		$excel->getActiveSheet()->getStyle('AC5')->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("AD5", "Karung");
		$excel->getActiveSheet()->getStyle('AD5')->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("AE5", "Peti");
		$excel->getActiveSheet()->getStyle('AE5')->applyFromArray($style_head);
		$excel->setActiveSheetIndex(0)->setCellValue("AF5", "Jumlah");
		$excel->getActiveSheet()->getStyle('AF5')->applyFromArray($style_head);

		$no=1;
		$numrow = 6;
			foreach ($getdata as $val) {
				$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $val['TGL_INPUT']);
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $val['JAM_INPUT']);
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $val['JENIS_DOKUMEN']);
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $val['NO_DOKUMEN']);
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $val['JUMLAH_ITEM']);
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $val['JUMLAH_PCS']);
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $val['KETERANGAN'].' '.$val['BON']);
				$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $val['PIC_PELAYAN']);
				$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $val['TGL_MULAI_PELAYANAN']);
				$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $val['JAM_MULAI_PELAYANAN']);
				$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $val['TGL_SELESAI_PELAYANAN']);
				$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $val['JAM_SELESAI_PELAYANAN']);
				$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $val['WAKTU_PELAYANAN']);
				$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, !empty($val['TGL_SELESAI_PELAYANAN']) ? $val['JML_ITEM_TERLAYANI'] : '');
				$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, !empty($val['TGL_SELESAI_PELAYANAN']) ? $val['JML_PCS_TERLAYANI'] : '');
				$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, !empty($val['TGL_SELESAI_PELAYANAN']) ? $val['JUMLAH_ITEM'] - $val['JML_ITEM_TERLAYANI'] : '');
				$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, !empty($val['TGL_SELESAI_PELAYANAN']) ? $val['JUMLAH_PCS'] - $val['JML_PCS_TERLAYANI'] : '');
				$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $val['PIC_PACKING']);
				$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $val['TGL_MULAI_PACKING']);
				$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, $val['JAM_MULAI_PACKING']);
				$excel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, $val['TGL_SELESAI_PACKING']);
				$excel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, $val['JAM_SELESAI_PACKING']);
				$excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, $val['WAKTU_PACKING']);
				$excel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, !empty($val['TGL_SELESAI_PACKING']) ? $val['JML_ITEM_TERLAYANI'] : '');
				$excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, !empty($val['TGL_SELESAI_PACKING']) ? $val['JML_PCS_TERLAYANI'] : '');
				$excel->setActiveSheetIndex(0)->setCellValue('AA'.$numrow, $val['DUS_KECIL'] != 0 ? $val['DUS_KECIL'] : '');
				$excel->setActiveSheetIndex(0)->setCellValue('AB'.$numrow, $val['DUS_SEDANG'] != 0 ? $val['DUS_SEDANG'] : '');
				$excel->setActiveSheetIndex(0)->setCellValue('AC'.$numrow, $val['DUS_PANJANG'] != 0 ? $val['DUS_PANJANG'] : '');
				$excel->setActiveSheetIndex(0)->setCellValue('AD'.$numrow, $val['KARUNG'] != 0 ? $val['KARUNG'] : '');
				$excel->setActiveSheetIndex(0)->setCellValue('AE'.$numrow, $val['PETI'] != 0 ? $val['PETI'] : '');
				$excel->setActiveSheetIndex(0)->setCellValue('AF'.$numrow, "=SUM(AA$numrow:AE$numrow)");

				$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('U'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('V'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('W'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('X'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('Y'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('Z'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('AA'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('AB'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('AC'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('AD'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('AE'.$numrow)->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('AF'.$numrow)->applyFromArray($style_col);
			$numrow++;
			$no++; 
			}

		//TOTAL
		$akhir = $numrow-1;
		$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "=SUM(F6:F$akhir)");
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, "=SUM(G6:G$akhir)");
		$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $this->convers_time($waktu_pelayanan));
		$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, "=SUM(O6:O$akhir)");
		$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, "=SUM(P6:P$akhir)");
		$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, "=SUM(Q6:Q$akhir)");
		$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, "=SUM(R6:R$akhir)");
		$excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, $this->convers_time($waktu_packing));
		$excel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, "=SUM(Y6:Y$akhir)");
		$excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, "=SUM(Z6:Z$akhir)");
		$excel->setActiveSheetIndex(0)->setCellValue('AA'.$numrow, "=SUM(AA6:AA$akhir)");
		$excel->setActiveSheetIndex(0)->setCellValue('AB'.$numrow, "=SUM(AB6:AB$akhir)");
		$excel->setActiveSheetIndex(0)->setCellValue('AC'.$numrow, "=SUM(AC6:AC$akhir)");
		$excel->setActiveSheetIndex(0)->setCellValue('AD'.$numrow, "=SUM(AD6:AD$akhir)");
		$excel->setActiveSheetIndex(0)->setCellValue('AE'.$numrow, "=SUM(AE6:AE$akhir)");
		$excel->setActiveSheetIndex(0)->setCellValue('AF'.$numrow, "=SUM(AF6:AF$akhir)");
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('X'.$numrow)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Y'.$numrow)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Z'.$numrow)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AA'.$numrow)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AB'.$numrow)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AC'.$numrow)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AD'.$numrow)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AE'.$numrow)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AF'.$numrow)->applyFromArray($style_col);

		for($col = 'A'; $col !== 'AG'; $col++) { // autowidth
			$excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("report period");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Report Period.xlsx"'); 
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}
}
