<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_LihatStock extends CI_Controller
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
		$this->load->model('StockGdSparepart/M_lihatstock');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = 'Lihat Stock';
		$data['Menu'] = 'Lihat Stock';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$UserMenu = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		// echo "<pre>";print_r($UserMenu);exit();
		
		if ($user == 'B0597' || $user == 'B0892') {
			$data['UserMenu'][] = $UserMenu[0];
			$data['UserMenu'][] = $UserMenu[1];
		}else {
			$data['UserMenu'] = $UserMenu;
		}
		// $data['unit'] = $this->M_lihatstock->kodeUnit();
		$data['kode'] = array('0' => 'AAA', '1' => 'AAB', '2' => 'AAC', '3' => 'AAD', '4' => 'AAE', '5' => 'AAF',
							'6' => 'AAG', '7' => 'AAH', '8' => 'AAK', '9' => 'AAL', '10' => 'AAN', '11' => 'ACA',
							'12' => 'ADA', '13' => 'ADB', '14' => 'AFA', '15' => 'AFC', '16' => 'AGC', '17' => 'BAC',
							'18' => 'IAO', '19' => 'IBB', '20' => 'IAA', '21' => 'IAP', '22' => 'IAU', '23' => 'IAB', 
							'24' => 'IBE', '25' => 'IBD', '26' => 'IAG');
		
		$data['nama'] = array('0' => 'TL800', '1' => 'G1000', '2' => 'G600', '3' => 'E85', '4' => 'M1000', '5' => 'KIJANG',
							'6' => 'BOXER', '7' => 'ZEVA', '8' => 'IMPALA', '9' => 'CAPUNG METAL', '10' => 'CAPUNG RAWA', '11' => 'ZENA',
							'12' => 'CAKAR BAJA', '13' => 'CAKAR BAJA MINI', '14' => 'H-110', '15' => 'QH-11', '16' => 'QT-14', '17' => 'OLD',
							'18' => 'V BELT MITSUBOSHI', '19' => 'BEARING NACHI', '20' => 'DIESEL VDE', '21' => 'V BELT BANDO',
							'22' => 'BEARING SKF', '23' => 'DIESEL HDE', '24' => 'CHAIN EK', '25' => 'CHAIN SENQCIA', '26' => 'TR-04');
		// echo "<pre>"; print_r($data['kode']);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StockGdSparepart/V_LihatStock', $data);
		$this->load->view('V_Footer',$data);
	}

	function getKodebarang()
	{
		$term = $this->input->get('term',TRUE);
		$subinv = $this->input->get('subinv',TRUE);
		$term = strtoupper($term);
		$data = $this->M_lihatstock->getKodeBarang($term, $subinv);
		echo json_encode($data);
	}

	function getNamaBarang()
	{
		$par 	= $this->input->post('par');
		$data 	= $this->M_lihatstock->getNamaBarang($par);
    	echo json_encode($data[0]['DESCRIPTION']);
	}

	function getSubinv()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_lihatstock->getSubinv($term);
		echo json_encode($data);
	}
	
	function getLokasiSimpan()
	{
		$term = $this->input->get('term',TRUE);
		$subinv = $this->input->get('subinv',TRUE);
		$term = strtoupper($term);
		$data = $this->M_lihatstock->lokasi_simpan($term, $subinv);
		echo json_encode($data);
	}

	function searchData(){
		$tglAw 			= $this->input->post('tglAw');
		$tglAk 			= $this->input->post('tglAk');
		$subinv 		= $this->input->post('subinv');
		$kode_brg 		= $this->input->post('kode_brg');
		$kode_awal 		= $this->input->post('kode_awal');
		$qty_atas 		= $this->input->post('qty_atas');
		$qty_bawah 		= $this->input->post('qty_bawah');
		$unit 			= $this->input->post('unit');
		$ket 			= $this->input->post('ket');
		$lokasi 		= $this->input->post('lokasi');
		$data['tglAw'] 	= $tglAw;
		$data['tglAk'] 	= $tglAk;
		$data['subinv'] = $subinv;
		$data['kode_brg'] = $kode_brg;

		if ($lokasi != '' && $qty_atas == '' && $qty_bawah == '' && $ket != 'min' && $ket != 'max') {
			$loc = "where lokasi = '$lokasi'";
		}elseif ($lokasi == '') {
			$loc = '';
		}else {
			$loc = "and lokasi = '$lokasi'";
		}

		if ($qty_atas != '' || $qty_bawah != '') {
			$qty = "WHERE onhand >= NVL('$qty_atas', onhand) --qty_atas
					AND onhand <= NVL('$qty_bawah', onhand) --qty_bawah
					$loc";
		}else {
			$qty = $loc;
		}

		if ($ket == '123') { // unit
			$kode = $this->kodeawal($kode_awal);
			$kode2 = $this->kodeunit($unit);
		}else{
			$kode = $this->kodebrg($kode_brg);
			$kode2 = $this->kodeawal($kode_awal);
			if ($ket == 'min') {
				$qty = "WHERE onhand <= min $loc";
			}elseif ($ket == 'max') {
				$qty = "WHERE onhand >= max $loc";
			}
		}
		// echo "<pre>";print_r($qty);exit();
		$data['data'] = $this->M_lihatstock->getData($tglAw, $tglAk, $subinv, $kode, $qty,$kode2);
		// echo "<pre>";print_r($data['data']);exit();
		
		$this->load->view('StockGdSparepart/V_TblLihatStock', $data);
	}

	public function kodebrg($kode){
		if ($kode != '') {
			return "AND msib.segment1 = '$kode'";
		}else {
			return '';
		}
	}
	
	public function kodeawal($kode_awal){
		$kode_awal = strtoupper($kode_awal);
		if ($kode_awal != '') {
			return "AND (msib.segment1 LIKE '%'||'$kode_awal'||'%' or msib.DESCRIPTION LIKE '%'||'$kode_awal'||'%')";
		}else{
			return '';
		}
	}
	
	public function kodeunit($unit){
		if ($unit != ''){
			return "AND msib.segment1 LIKE '$unit'||'%'";
		}else {
			return '';
		}
	}	

	function searchHistory(){
		$data['kode'] 	= $this->input->post('kode');
		$data['nama'] 	= $this->input->post('nama');
		$data['subinv'] = $this->input->post('subinv');
		$data['tglAwl'] = $this->input->post('tglAwl');
		$data['tglAkh'] = $this->input->post('tglAkh');
		$data['onhand'] = $this->input->post('onhand');
		$inout 	= $this->input->post('inout');
		$cari = $this->M_lihatstock->getHistory($data['tglAwl'], $data['tglAkh'], $data['subinv'], $data['kode']);
		// echo "<pre>"; print_r($inout);exit();
		$in = array();
		$out = array();
		$tbody = '';
		$tampungsaldo = array();
		for ($i=0; $i < count($cari) ; $i++) { 
			if ($i == 0) {
				$saldo_awal = $data['onhand'] - $inout;
				if ($cari[$i]['QTY_IN'] == '') {
					$saldo = $saldo_awal + $cari[$i]['QTY_OUT'];
				}else {
					$saldo = $saldo_awal + $cari[$i]['QTY_IN'];
				}
			}else {
				$x = count($tampungsaldo) - 1;
				if ($cari[$i]['QTY_IN'] == '') {
					if ($x < 0) {
						$saldo = $cari[$i]['QTY_OUT'] + $cari[$i-1]['QTY_OUT'];
					}else{
						$saldo = $cari[$i]['QTY_OUT'] + $tampungsaldo[$x];
					}
				}else{
					if ($x < 0) {
						$saldo = $cari[$i]['QTY_IN'] + $cari[$i-1]['QTY_IN'];
					}else{
						$saldo = $cari[$i]['QTY_IN'] + $tampungsaldo[$x];
					}
				}
			}
			$cari[$i]['SALDO'] = $saldo;
			array_push($tampungsaldo, $saldo);
			array_push($in, $cari[$i]['QTY_IN']);
			array_push($out, $cari[$i]['QTY_OUT_MMT']);
		}
		$data['data'] = $cari;

		$data['totalIN'] = array_sum($in);
		$data['totalOUT'] = array_sum($out);
		
		$this->load->view('StockGdSparepart/V_ModalLihatStock', $data);
	}

	public function searchGambarItem(){
		$data['kode'] 	= $this->input->post('kode');
		$data['nama'] 	= $this->input->post('nama');
		$this->load->view('StockGdSparepart/V_ModalGambar', $data);
	}


}