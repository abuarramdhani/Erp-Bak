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

		$query2 = "where TO_CHAR(selesai_pelayanan,'DD/MM/YYYY') between '$date' and '$date' and selesai_pelayanan is not null and (bon != 'PENDING' or bon is null)";
		$pelayanan 	= $this->M_monitoring->getDataSPB($query2);
		$data['pelayanan'] 	= $pelayanan;
		$data['jml_pelayanan'] = count($pelayanan);
		$kurang = "where TO_CHAR(jam_input,'DD/MM/YYYY') between '$date' and '$date' and trunc(selesai_pelayanan) > '$tgl' or selesai_pelayanan is null";
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
		$total = 0;
		$nopck = array();
		for ($i=0; $i < $data['jml_packing'] ; $i++) { 
			$total += $packing[$i]['JUMLAH_PCS'];
			array_push($nopck, $packing[$i]['NO_DOKUMEN']);
		}
		$kurang = "where selesai_pengeluaran is not null and selesai_packing is null and bon is null";
		$data['krgpacking'] = $this->M_monitoring->dataKurang($kurang);
		$data['krg_packing'] = count($data['krgpacking']);

		$jml_gd = $this->M_monitoring->getjmlGd($date);
		$data['jml_gd'] = count($jml_gd);

		$cancel = $this->M_monitoring->getcancel($date);
		$data['cancel'] = count($cancel);
		
		$jumlah = array();
		for ($i=0; $i < $data['jml_packing'] ; $i++) { 
			$cari = $this->M_monitoring->getTransact($packing[$i]['NO_DOKUMEN']);
			for ($a=0; $a < count($cari) ; $a++) { 
				array_push($jumlah, $cari[$a]['TRANSACTION_QUANTITY']);
			}
		}
		$data['jml_selesai'] = array_sum($jumlah);
		$data['krg_selesai'] = $total - $data['jml_selesai'];

		$data['jml_colly'] = 0;
		$data['dus_kecil'] = 0;
		$data['dus_bsr'] = 0;
		$data['dus_sdg'] = 0;
		$data['karung'] = 0;
		for ($i=0; $i < count($nopck); $i++) { 
			$cari = $this->M_monitoring->getDataColly($nopck[$i]);
			if (!empty($cari)) {
				$data['jml_colly'] += $cari[0]['JML_COLLY'];
				$data['dus_kecil'] += $cari[0]['KARDUS_KECIL'];
				$data['dus_sdg'] += $cari[0]['KARDUS_SEDANG'];
				$data['dus_bsr'] += $cari[0]['KARDUS_BESAR'];
				$data['karung'] += $cari[0]['KARUNG'];
			}
		}
		
		// echo "<pre>"; print_r($data['jml_colly']); exit();

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
			$query1 = "where TO_CHAR(jam_input,'DD/MM/YYYY') between '$date' and '$date'";
			$dataMon = $this->M_monitoring->getDataSPB($query1);
			$hasil[$a]['tanggal'] = $tgl[$a];
			$hasil[$a]['dosp'] = $dataMon;
			$hasil[$a]['jml_spb'] = count($dataMon);
			
			$query2 = "where TO_CHAR(selesai_pelayanan,'DD/MM/YYYY') between '$date' and '$date' and selesai_pelayanan is not null and (bon != 'PENDING' or bon is null)";
			$pelayanan = $this->M_monitoring->getDataSPB($query2);
			$hasil[$a]['pelayanan'] = $pelayanan;
			$hasil[$a]['jml_pelayanan'] = count($pelayanan);
			if ($date == date('d/m/Y')) {
				$kurang = "where selesai_pelayanan is null";
			}else {
				$kurang = "where trunc(jam_input) < '$tgl[$a]' and trunc(selesai_pelayanan) > '$tgl[$a]'";
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
				$kurang = "where (bon != 'LANGSUNG' or bon is null) and TO_CHAR(selesai_pelayanan,'DD/MM/YYYY') between '$date' and '$date' and trunc(selesai_pengeluaran) > '$tgl[$a]'";
			}
			$hasil[$a]['krgpengeluaran'] = $this->M_monitoring->dataKurang($kurang);
			$hasil[$a]['krg_pengeluaran'] = count($hasil[$a]['krgpengeluaran']);

			$query4 = "where TO_CHAR(selesai_packing,'DD/MM/YYYY') between '$date' and '$date' and selesai_packing is not null";
			$packing = $this->M_monitoring->getDataSPB($query4);
			$hasil[$a]['packing'] = $packing;
			$hasil[$a]['jml_packing'] = count($packing);
			$total = 0;
			$nopck = array();
			for ($i=0; $i < $hasil[$a]['jml_packing'] ; $i++) { 
				$total += $packing[$i]['JUMLAH_PCS'];
				array_push($nopck, $packing[$i]['NO_DOKUMEN']);
			}
			if ($date == date('d/m/Y')) {
				$kurang = "where selesai_pengeluaran is not null and selesai_packing is null and bon is null";
			}else {
				$kurang = "where bon is null and TO_CHAR(selesai_pengeluaran,'DD/MM/YYYY') between '$date' and '$date' and trunc(selesai_packing) > '$tgl[$a]'";
			}
			$hasil[$a]['krgpacking'] = $this->M_monitoring->dataKurang($kurang);
			$hasil[$a]['krg_packing'] = count($hasil[$a]['krgpacking']);

			$jml_gd = $this->M_monitoring->getjmlGd2($date);
			$hasil[$a]['jml_gd'] = count($jml_gd);

			$cancel = $this->M_monitoring->getcancel($date);
			$hasil[$a]['cancel'] = count($cancel);

			$jumlah = array();
			for ($i=0; $i < $hasil[$a]['jml_packing'] ; $i++) { 
				$cari = $this->M_monitoring->getTransact($packing[$i]['NO_DOKUMEN']);
				for ($b=0; $b < count($cari) ; $b++) { 
					array_push($jumlah, $cari[$b]['TRANSACTION_QUANTITY']);
				}
			}
			$hasil[$a]['jml_selesai'] = array_sum($jumlah);
			$hasil[$a]['krg_selesai'] = $total - $hasil[$a]['jml_selesai'];

			$hasil[$a]['jml_colly'] = 0;
			$hasil[$a]['dus_kecil'] = 0;
			$hasil[$a]['dus_bsr'] = 0;
			$hasil[$a]['dus_sdg'] = 0;
			$hasil[$a]['karung'] = 0;
			for ($i=0; $i < count($nopck); $i++) { 
				$cari = $this->M_monitoring->getDataColly($nopck[$i]);
				if (!empty($cari)) {
					$hasil[$a]['jml_colly'] += $cari[0]['JML_COLLY'];
					$hasil[$a]['dus_kecil'] += $cari[0]['KARDUS_KECIL'];
					$hasil[$a]['dus_sdg'] += $cari[0]['KARDUS_SEDANG'];
					$hasil[$a]['dus_bsr'] += $cari[0]['KARDUS_BESAR'];
					$hasil[$a]['karung'] += $cari[0]['KARUNG'];
				}
			}
		}
		$data['hasil'] = $hasil;
		// echo "<pre>";print_r($hasil);exit();
		
		$this->load->view('KapasitasGdSparepart/V_TblMonitoring', $data);
	}

	public function exportSPB(){
		$tglAwal = $this->input->post('tglAwal[]');
		$tglAkhir = $this->input->post('tglAkhir[]');

		$tgl_dospb 		= $this->input->post('tgl_dospb[]');
		$jenis_dospb 	= $this->input->post('jenis_dospb[]');
		$no_dospb 		= $this->input->post('no_dospb[]');
		$jml_item_dospb = $this->input->post('jml_item_dospb[]');
		$jml_pcs_dospb 	= $this->input->post('jml_pcs_dospb[]');
		$urgent_dospb 	= $this->input->post('urgent_dospb[]');

		$dataDOSPB = $this->M_monitoring->dataDOSPB($tglAwal[0], $tglAkhir[0]);

		// $dataDOSPB = array();
		// for ($i=0; $i <count($no_dospb) ; $i++) { 
		// 	$array = array(
		// 		'tgl_dospb'			=> $tgl_dospb[$i],
		// 		'jenis_dospb' 		=> $jenis_dospb[$i],
		// 		'no_dospb' 			=> $no_dospb[$i],
		// 		'jml_item_dospb' 	=> $jml_item_dospb[$i],
		// 		'jml_pcs_dospb' 	=> $jml_pcs_dospb[$i],
		// 		'urgent' 			=> $urgent_dospb[$i],
		// 	);
		// 	array_push($dataDOSPB, $array);
		// }

		$tgl_plyn 			= $this->input->post('tgl_plyn[]');
		$jam_plyn 			= $this->input->post('jam_plyn[]');
		$jenis_plyn 		= $this->input->post('jenis_plyn[]');
		$no_plyn 			= $this->input->post('no_plyn[]');
		$jml_item_plyn 		= $this->input->post('jml_item_plyn[]');
		$jml_pcs_plyn 		= $this->input->post('jml_pcs_plyn[]');
		$tgl_mulai_plyn 	= $this->input->post('tgl_mulai_plyn[]');
		$jam_mulai_plyn 	= $this->input->post('jam_mulai_plyn[]');
		$tgl_selesai_plyn 	= $this->input->post('tgl_selesai_plyn[]');
		$jam_selesai_plyn 	= $this->input->post('jam_selesai_plyn[]');
		$waktu_pelayanan 	= $this->input->post('waktu_pelayanan[]');
		$pic_plyn 			= $this->input->post('pic_plyn[]');
		$urgent_plyn 		= $this->input->post('urgent_plyn[]');

		$dataPlyn = $this->M_monitoring->dataPlyn($tglAwal[0], $tglAkhir[0]);

		// $dataPlyn = array();
		// for ($i=0; $i <count($no_plyn) ; $i++) { 
		// 	$array = array(
		// 		'tgl_plyn'			=> $tgl_plyn[$i],
		// 		'jam_plyn'			=> $jam_plyn[$i],
		// 		'jenis_plyn' 		=> $jenis_plyn[$i],
		// 		'no_plyn' 			=> $no_plyn[$i],
		// 		'jml_item_plyn' 	=> $jml_item_plyn[$i],
		// 		'jml_pcs_plyn' 		=> $jml_pcs_plyn[$i],
		// 		'tgl_mulai_plyn' 	=> $tgl_mulai_plyn[$i],
		// 		'jam_mulai_plyn' 	=> $jam_mulai_plyn[$i],
		// 		'tgl_selesai_plyn' 	=> $tgl_selesai_plyn[$i],
		// 		'jam_selesai_plyn' 	=> $jam_selesai_plyn[$i],
		// 		'waktu_pelayanan' 	=> $waktu_pelayanan[$i],
		// 		'pic' 				=> $pic_plyn[$i],
		// 		'urgent' 			=> $urgent_plyn[$i],
		// 	);
		// 	array_push($dataPlyn, $array);
		// }

		$tgl_krgplyn 		= $this->input->post('tgl_krgplyn[]');
		$jenis_krgplyn 		= $this->input->post('jenis_krgplyn[]');
		$no_krgplyn 		= $this->input->post('no_krgplyn[]');
		$jml_item_krgplyn 	= $this->input->post('jml_item_krgplyn[]');
		$jml_pcs_krgplyn 	= $this->input->post('jml_pcs_krgplyn[]');
		$urgent_krgplyn 	= $this->input->post('urgent_krgplyn[]');

		$dataKrgPlyn = $this->M_monitoring->dataKrgPlyn($tglAwal[0], $tglAkhir[0]);
		// echo "<pre>";print_r($dataKrgPlyn);exit();

		// $dataKrgPlyn = array();
		// for ($i=0; $i <count($no_krgplyn) ; $i++) { 
		// 	$array = array(
		// 		'tgl_krgplyn'		=> $tgl_krgplyn[$i],
		// 		'jenis_krgplyn' 	=> $jenis_krgplyn[$i],
		// 		'no_krgplyn' 		=> $no_krgplyn[$i],
		// 		'jml_item_krgplyn' 	=> $jml_item_krgplyn[$i],
		// 		'jml_pcs_krgplyn' 	=> $jml_pcs_krgplyn[$i],
		// 		'urgent' 			=> $urgent_krgplyn[$i],
		// 	);
		// 	array_push($dataKrgPlyn, $array);
		// }
		
		$tgl_pglr 			= $this->input->post('tgl_pglr[]');
		$jam_pglr 			= $this->input->post('jam_pglr[]');
		$jenis_pglr 		= $this->input->post('jenis_pglr[]');
		$no_pglr 			= $this->input->post('no_pglr[]');
		$jml_item_pglr 		= $this->input->post('jml_item_pglr[]');
		$jml_pcs_pglr 		= $this->input->post('jml_pcs_pglr[]');
		$tgl_mulai_pglr 	= $this->input->post('tgl_mulai_pglr[]');
		$jam_mulai_pglr 	= $this->input->post('jam_mulai_pglr[]');
		$tgl_selesai_pglr 	= $this->input->post('tgl_selesai_pglr[]');
		$jam_selesai_pglr	= $this->input->post('jam_selesai_pglr[]');
		$waktu_pengeluaran 	= $this->input->post('waktu_pengeluaran[]');
		$pic_pglr 			= $this->input->post('pic_pglr[]');
		$urgent_pglr 		= $this->input->post('urgent_pglr[]');
		
		$dataPglr = $this->M_monitoring->dataPglr($tglAwal[0], $tglAkhir[0]);
		// echo "<pre>";print_r($dataPglr);exit();

		// $dataPglr = array();
		// for ($i=0; $i <count($no_pglr) ; $i++) { 
		// 	$array = array(
		// 		'tgl_pglr'				=> $tgl_pglr[$i],
		// 		'jam_pglr'				=> $jam_pglr[$i],
		// 		'jenis_pglr' 			=> $jenis_pglr[$i],
		// 		'no_pglr' 				=> $no_pglr[$i],
		// 		'jml_item_pglr' 		=> $jml_item_pglr[$i],
		// 		'jml_pcs_pglr' 			=> $jml_pcs_pglr[$i],
		// 		'tgl_mulai_pglr' 		=> $tgl_mulai_pglr[$i],
		// 		'jam_mulai_pglr' 		=> $jam_mulai_pglr[$i],
		// 		'tgl_selesai_pglr' 		=> $tgl_selesai_pglr[$i],
		// 		'jam_selesai_pglr' 		=> $jam_selesai_pglr[$i],
		// 		'waktu_pengeluaran' 	=> $waktu_pengeluaran[$i],
		// 		'pic' 					=> $pic_pglr[$i],
		// 		'urgent' 				=> $urgent_pglr[$i],
		// 	);
		// 	array_push($dataPglr, $array);
		// }

		$tgl_krgpglr 		= $this->input->post('tgl_krgpglr[]');
		$jenis_krgpglr 		= $this->input->post('jenis_krgpglr[]');
		$no_krgpglr 		= $this->input->post('no_krgpglr[]');
		$jml_item_krgpglr 	= $this->input->post('jml_item_krgpglr[]');
		$jml_pcs_krgpglr 	= $this->input->post('jml_pcs_krgpglr[]');
		$pic_krgpglr 		= $this->input->post('pic_krgpglr[]');
		$urgent_krgpglr 	= $this->input->post('urgent_krgpglr[]');

		$dataKrgPglr = $this->M_monitoring->dataKrgPglr($tglAwal[0], $tglAkhir[0]);
		// echo "<pre>";print_r($dataKrgPglr);exit();
		
		// $dataKrgPglr = array();
		// for ($i=0; $i <count($no_krgpglr) ; $i++) { 
		// 	$array = array(
		// 		'tgl_krgpglr'		=> $tgl_krgpglr[$i],
		// 		'jenis_krgpglr' 	=> $jenis_krgpglr[$i],
		// 		'no_krgpglr' 		=> $no_krgpglr[$i],
		// 		'jml_item_krgpglr' 	=> $jml_item_krgpglr[$i],
		// 		'jml_pcs_krgpglr' 	=> $jml_pcs_krgpglr[$i],
		// 		'pic' 			=> $pic_krgpglr[$i],
		// 		'urgent' 			=> $urgent_krgpglr[$i],
		// 	);
		// 	array_push($dataKrgPglr, $array);
		// }
		
		$tgl_pck 			= $this->input->post('tgl_pck[]');
		$jam_pck 			= $this->input->post('jam_pck[]');
		$jenis_pck 			= $this->input->post('jenis_pck[]');
		$no_pck 			= $this->input->post('no_pck[]');
		$jml_item_pck 		= $this->input->post('jml_item_pck[]');
		$jml_pcs_pck 		= $this->input->post('jml_pcs_pck[]');
		$tgl_mulai_pck 		= $this->input->post('tgl_mulai_pck[]');
		$jam_mulai_pck 		= $this->input->post('jam_mulai_pck[]');
		$tgl_selesai_pck 	= $this->input->post('tgl_selesai_pck[]');
		$jam_selesai_pck 	= $this->input->post('jam_selesai_pck[]');
		$waktu_packing 		= $this->input->post('waktu_packing[]');
		$pic_pck 			= $this->input->post('pic_pck[]');
		$urgent_pck 		= $this->input->post('urgent_pck[]');

		$dataPck = $this->M_monitoring->dataPck($tglAwal[0], $tglAkhir[0]);
		// echo "<pre>";print_r($dataPck);exit();

		// $dataPck = array();
		// for ($i=0; $i <count($no_pck) ; $i++) { 
		// 	$array = array(
		// 		'tgl_pck'			=> $tgl_pck[$i],
		// 		'jam_pck'			=> $jam_pck[$i],
		// 		'jenis_pck' 		=> $jenis_pck[$i],
		// 		'no_pck' 			=> $no_pck[$i],
		// 		'jml_item_pck' 		=> $jml_item_pck[$i],
		// 		'jml_pcs_pck' 		=> $jml_pcs_pck[$i],
		// 		'tgl_mulai_pck' 	=> $tgl_mulai_pck[$i],
		// 		'jam_mulai_pck' 	=> $jam_mulai_pck[$i],
		// 		'tgl_selesai_pck' 	=> $tgl_selesai_pck[$i],
		// 		'jam_selesai_pck' 	=> $jam_selesai_pck[$i],
		// 		'waktu_packing' 	=> $waktu_packing[$i],
		// 		'pic' 				=> $pic_pck[$i],
		// 		'urgent' 			=> $urgent_pck[$i],
		// 	);
		// 	array_push($dataPck, $array);
		// }

		$tgl_krgpck 		= $this->input->post('tgl_krgpck[]');
		$jenis_krgpck 		= $this->input->post('jenis_krgpck[]');
		$no_krgpck 			= $this->input->post('no_krgpck[]');
		$jml_item_krgpck 	= $this->input->post('jml_item_krgpck[]');
		$jml_pcs_krgpck 	= $this->input->post('jml_pcs_krgpck[]');
		$pic_krgpck 		= $this->input->post('pic_krgpck[]');
		$urgent_krgpck 		= $this->input->post('urgent_krgpck[]');

		$dataKrgPck = $this->M_monitoring->dataKrgPck($tglAwal[0], $tglAkhir[0]);
		// echo "<pre>";print_r($dataKrgPck);exit();

		// $dataKrgPck = array();
		// for ($i=0; $i <count($no_krgpck) ; $i++) { 
		// 	$array = array(
		// 		'tgl_krgpck'		=> $tgl_krgpck[$i],
		// 		'jenis_krgpck' 		=> $jenis_krgpck[$i],
		// 		'no_krgpck' 		=> $no_krgpck[$i],
		// 		'jml_item_krgpck' 	=> $jml_item_krgpck[$i],
		// 		'jml_pcs_krgpck' 	=> $jml_pcs_krgpck[$i],
		// 		'pic' 				=> $pic_krgpck[$i],
		// 		'urgent' 			=> $urgent_krgpck[$i],
		// 	);
		// 	array_push($dataKrgPck, $array);
		// }

		$tanggal 		= $this->input->post('tanggalnya[]');
		$jml_selesai 	= $this->input->post('jml_selesai[]');
		$krg_selesai 	= $this->input->post('krg_selesai[]');

		$dataselesai = $this->M_monitoring->dataselesai($tglAwal[0], $tglAkhir[0]);
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
		$dicancel = array();
		$itemkurang = array();
		for ($i=0; $i < count($no_pck) ; $i++) { 
			$kurang = $this->M_monitoring->diCancel($no_pck[$i]);
			if (!empty($kurang)) {
			for ($a=0; $a < count($kurang); $a++) { 
					$array = array(
						'TGL_DIBUAT'	=> $tgl_pck[$i],
						'JENIS_DOKUMEN'	=> $kurang[$a]['JENIS_DOKUMEN'],
						'NO_DOKUMEN'	=> $kurang[$a]['NO_DOKUMEN'],
						'ITEM' 			=> $kurang[$a]['ITEM'],
						'DESCRIPTION' 	=> $kurang[$a]['DESCRIPTION'],
						'QUANTITY' 		=> $kurang[$a]['QUANTITY'],
						'QUANTITY_DELIVERED'	=> $kurang[$a]['QUANTITY_DELIVERED'],
						'KURANG' 		=> $kurang[$a]['KURANG'],
					);
					array_push($dicancel, $array);

					if (!in_array($kurang[$a]['ITEM'], $itemkurang)) {
						array_push($itemkurang, $kurang[$a]['ITEM']);
					}
				}
			}
		}
		
		$dataCancel = array();
		for ($i=0; $i < count($itemkurang) ; $i++) { 
			foreach($dicancel as $val) { 
				if ($itemkurang[$i] == $val['ITEM']) {
					array_push($dataCancel, $val);
				}
			}
		}
		// echo "<pre>";print_r($dataCancel);exit();
		$dataKurang = $this->M_monitoring->dataKurangselesai($tglAwal[0], $tglAkhir[0]);

		$jml_cancel 	= $this->M_monitoring->jml_cancel($tglAwal[0], $tglAkhir[0]);
		$jml_pending 	= $this->M_monitoring->jml_pending($tglAwal[0], $tglAkhir[0]);
		$jml_bon 		= $this->M_monitoring->jml_bon($tglAwal[0], $tglAkhir[0]);
		$jml_langsung 	= $this->M_monitoring->jml_langsung($tglAwal[0], $tglAkhir[0]);
		$jml_urgent 	= $this->M_monitoring->jml_urgent($tglAwal[0], $tglAkhir[0]);
		$jml_tdkurgent 	= $this->M_monitoring->jml_tdkurgent($tglAwal[0], $tglAkhir[0]);


		// $dataCancel = $this->M_monitoring->dataCancel($tglAwal[0], $tglAkhir[0]);
		// echo "<pre>";print_r($dataket);exit();
		
		// echo "<pre>"; print_r($dataKurang); exit();

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

			if (count($dataPck) == 0){
				$numrow = $noPck + 1;
				$excel->setActiveSheetIndex(0)->setCellValue("A$numrow", "No data available in table"); 
				$excel->getActiveSheet()->mergeCells("A$numrow:M$numrow");
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
				$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow3, $no3);
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow3, $val['TGL_DIBUAT']);
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow3, $val['JENIS_DOKUMEN']);
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow3, $val['NO_DOKUMEN']);
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow3, $val['ITEM']);
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow3, $val['DESCRIPTION']);
				$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow3, $val['QUANTITY']);
				$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow3, $val['QUANTITY_DELIVERED']);
				$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow3, $val['KURANG']);
				$excel->getActiveSheet()->mergeCells("E$numrow3:F$numrow3"); 
				$excel->getActiveSheet()->mergeCells("G$numrow3:J$numrow3"); 
				$excel->getActiveSheet()->getStyle('A'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('B'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('C'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('D'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('E'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('F'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('G'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('I'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('H'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('I'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('J'.$numrow3)->applyFromArray($style2);
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
				$excel->getActiveSheet()->getStyle('G'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('H'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('I'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('J'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('K'.$numrow3)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('L'.$numrow3)->applyFromArray($style2);
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
			$jumlah2 = $jumlah + count($dataket) + 5;
			// Tabel data jumlah cancel, pending, bon,langsung
			$excel->setActiveSheetIndex(0)->setCellValue("A$jml2", "6.1 KETERANGAN DATA");
			$excel->setActiveSheetIndex(0)->setCellValue("A$jumlah2", "CANCEL");
			$excel->setActiveSheetIndex(0)->setCellValue("C$jumlah2", "PENDING");
			$excel->setActiveSheetIndex(0)->setCellValue("E$jumlah2", "BON");
			$excel->setActiveSheetIndex(0)->setCellValue("G$jumlah2", "LANGSUNG");
			$excel->setActiveSheetIndex(0)->setCellValue("I$jumlah2", "URGENT");
			$excel->setActiveSheetIndex(0)->setCellValue("K$jumlah2", "TIDAK URGENT");
			$excel->getActiveSheet()->mergeCells("A$jumlah2:B$jumlah2"); 
			$excel->getActiveSheet()->mergeCells("C$jumlah2:D$jumlah2"); 
			$excel->getActiveSheet()->mergeCells("E$jumlah2:F$jumlah2"); 
			$excel->getActiveSheet()->mergeCells("G$jumlah2:H$jumlah2"); 
			$excel->getActiveSheet()->mergeCells("I$jumlah2:J$jumlah2"); 
			$excel->getActiveSheet()->mergeCells("K$jumlah2:L$jumlah2"); 
			$excel->getActiveSheet()->getStyle("A$jml2")->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle("A$jumlah2")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("B$jumlah2")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("C$jumlah2")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("D$jumlah2")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("E$jumlah2")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("F$jumlah2")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("G$jumlah2")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("H$jumlah2")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("I$jumlah2")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("J$jumlah2")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("K$jumlah2")->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle("L$jumlah2")->applyFromArray($style_col);
			$numrow4 = $jumlah2 + 1;
				$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow4, $jml_cancel[0]['CANCEL']);
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow4, $jml_pending[0]['PENDING']);
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow4, $jml_bon[0]['BON']);
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow4, $jml_langsung[0]['LANGSUNG']);
				$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow4, $jml_urgent[0]['URGENT']);
				$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow4, $jml_tdkurgent[0]['TDK_URGENT']);
				$excel->getActiveSheet()->mergeCells("A$numrow4:B$numrow4"); 
				$excel->getActiveSheet()->mergeCells("C$numrow4:D$numrow4"); 
				$excel->getActiveSheet()->mergeCells("E$numrow4:F$numrow4"); 
				$excel->getActiveSheet()->mergeCells("G$numrow4:H$numrow4"); 
				$excel->getActiveSheet()->mergeCells("I$numrow4:J$numrow4"); 
				$excel->getActiveSheet()->mergeCells("K$numrow4:L$numrow4"); 
				$excel->getActiveSheet()->getStyle('A'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('B'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('C'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('D'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('E'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('F'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('G'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('H'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('I'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('J'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('K'.$numrow4)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('L'.$numrow4)->applyFromArray($style2);
			

			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(13); 
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
}
