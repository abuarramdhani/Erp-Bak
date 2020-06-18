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
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Lihat Stock';
		$data['Menu'] = 'Lihat Stock';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $data['unit'] = $this->M_lihatstock->kodeUnit();
		$data['kode'] = array('0' => 'AAA', '1' => 'AAB', '2' => 'AAC', '3' => 'AAD', '4' => 'AAE', '5' => 'AAF',
							'6' => 'AAG', '7' => 'AAH', '8' => 'AAK', '9' => 'AAL', '10' => 'AAN', '11' => 'ACA',
							'12' => 'ADA', '13' => 'ADB', '14' => 'AFA', '15' => 'AFC', '16' => 'AGC', '17' => 'BAC',
							'18' => 'IAO', '19' => 'IBB', '20' => 'IAA', '21' => 'IAP', '22' => 'IAU', '23' => 'IAB');
		
		$data['nama'] = array('0' => 'TL800', '1' => 'G1000', '2' => 'G600', '3' => 'E85', '4' => 'M1000', '5' => 'KIJANG',
							'6' => 'BOXER', '7' => 'ZEVA', '8' => 'IMPALA', '9' => 'CAPUNG METAL', '10' => 'CAPUNG RAWA', '11' => 'ZENA',
							'12' => 'CAKAR BAJA', '13' => 'CAKAR BAJA MINI', '14' => 'H-110', '15' => 'QH-11', '16' => 'QT-14', '17' => 'OLD',
							'18' => 'MITSUBOSHI', '19' => 'BEARING NACHI', '20' => 'DIESEL VDE', '21' => 'V BELT BANDO',
							'22' => 'BEARING SKF', '23' => 'DIESEL HDE');
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

	function searchData(){
		$tglAw 			= $this->input->post('tglAw');
		$tglAk 			= $this->input->post('tglAk');
		$subinv 		= $this->input->post('subinv');
		$kode_brg 		= $this->input->post('kode_brg');
		$kode_awal 		= $this->input->post('kode_awal');
		$qty_atas 		= $this->input->post('qty_atas');
		$qty_bawah 		= $this->input->post('qty_bawah');
		// $unit 			= $this->input->post('unit2');
		$data['tglAw'] 	= $tglAw;
		$data['tglAk'] 	= $tglAk;
		$data['subinv'] = $subinv;
		$data['kode_brg'] = $kode_brg;
		// echo "<pre>"; print_r($kode_awal);exit();

		if ($qty_atas != '' || $qty_bawah != '') {
			$qty = "WHERE onhand >= NVL('$qty_atas', onhand) --qty_atas
					AND onhand <= NVL('$qty_bawah', onhand) --qty_bawah";
		}else {
			$qty = '';
		}

		if ($kode_brg != '') {
			$kode = "AND msib.segment1 = '$kode_brg'";
		}else {
			$kode = '';
		}

		$kode_awal = strtoupper($kode_awal);
		if ($kode_awal != '') {
			$kode_awl = "AND (msib.segment1 LIKE '%'||'$kode_awal'||'%' or msib.DESCRIPTION LIKE '%'||'$kode_awal'||'%')";
		}else{
			$kode_awl = '';
		}
		$data['data'] = $this->M_lihatstock->getData($tglAw, $tglAk, $subinv, $kode, $qty,$kode_awl);
		// echo "<pre>";print_r($data['data']);exit();
		
		$this->load->view('StockGdSparepart/V_TblLihatStock', $data);
	}

	function searchData2(){
		$tglAw 			= $this->input->post('tglAw');
		$tglAk 			= $this->input->post('tglAk');
		$subinv 		= $this->input->post('subinv');
		$unit 			= $this->input->post('unit');
		$kode_brg 		= $this->input->post('kode_brg');
		$kode_awal 		= $this->input->post('kode_awal');
		$qty_atas 		= $this->input->post('qty_atas');
		$qty_bawah 		= $this->input->post('qty_bawah');
		$data['tglAw'] 	= $tglAw;
		$data['tglAk'] 	= $tglAk;
		$data['subinv'] = $subinv;
		// echo "<pre>"; print_r($kode_brg);exit();

		if ($qty_atas != '' || $qty_bawah != '') {
			$qty = "WHERE onhand >= NVL('$qty_atas', onhand) --qty_atas
					AND onhand <= NVL('$qty_bawah', onhand) --qty_bawah";
		}else {
			$qty = '';
		}

		if ($kode_brg != '') {
			$kode = "AND msib.segment1 = '$kode_brg'";
		}else {
			$kode = '';
		}

		if ($unit != ''){
			$kode_unit = "AND msib.segment1 LIKE '$unit'||'%'";
		}else {
			$kode_unit = '';
		}
		$data['data'] = $this->M_lihatstock->getData($tglAw, $tglAk, $subinv, $kode, $qty,$kode_unit);
		// echo "<pre>";print_r($data['data']);exit();
		
		$this->load->view('StockGdSparepart/V_TblLihatStock', $data);
	}

	function searchHistory(){
		$kode 	= $this->input->post('kode');
		$nama 	= $this->input->post('nama');
		$subinv = $this->input->post('subinv');
		$tglAwl = $this->input->post('tglAwl');
		$tglAkh = $this->input->post('tglAkh');
		$onhand = $this->input->post('onhand');
		$inout 	= $this->input->post('inout');
		$cari = $this->M_lihatstock->getHistory($tglAwl, $tglAkh, $subinv, $kode);
		// echo "<pre>"; print_r($inout);exit();
		$in = array();
		$out = array();
		$tbody = '';
		$no = 1;
		$tampungsaldo = array();
		for ($i=0; $i < count($cari) ; $i++) { 
			if ($i == 0) {
				$saldo_awal = $onhand - $inout;
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
			array_push($tampungsaldo, $saldo);
			$tbody .= '<tr>
							<td>'.$no.'</td>
							<td>'.$cari[$i]['NO_BUKTI'].'</td>
							<td>'.$cari[$i]['TRANSACTION_DATE'].'</td>
							<td>'.$cari[$i]['TRANSACTION_TYPE_NAME'].'</td>
							<td>'.$cari[$i]['UOM'].'</td>
							<td>'.$cari[$i]['QTY_IN'].'</td>
							<td>'.$cari[$i]['QTY_OUT_MMT'].'</td>
							<td class="bg-success">'.$saldo.'</td>
							<td>'.$cari[$i]['TRANSACT_BY'].'</td>
							<td>'.$cari[$i]['TRANSACTION_DATE'].'</td>
						</tr>';
			array_push($in, $cari[$i]['QTY_IN']);
			array_push($out, $cari[$i]['QTY_OUT_MMT']);
			$no++;
		}

		$totalIN = array_sum($in);
		$totalOUT = array_sum($out);

		$output = '<div class="panel-body">
						<div class="col-md-12">
							<div class="col-md-2">
								<label>Kode Barang</label>
							</div>
							<div class="col-md-10">: '.$kode.'</div>
						</div>
						<div class="col-md-12">
							<div class="col-md-2">
								<label>Deskripsi Barang</label>
							</div>
							<div class="col-md-10">: '.$nama.'</div>
						</div>
						<div class="col-md-12">
							<div class="col-md-2">
								<label>SubInventory</label>
							</div>
							<div class="col-md-10">: '.$subinv.'</div>
						</div>
						<div class="col-md-12">
							<div class="col-md-2">
								<label>Periode</label>
							</div>
							<div class="col-md-10">: '.$tglAwl.' - '.$tglAkh.'</div>
						</div>
					</div>
				<div class="panel-body">
                	<div class="table-responsive">
						<table class="datatable table table-bordered table-hover table-striped text-center myTable" id="myTable" style="width: 100%;">
							<thead class="bg-info">
								<tr>
									<th>No</th>
									<th>Bukti Transaksi</th>
									<th>Tanggal Transaksi</th>
									<th>Jenis Transaksi</th>
									<th>Satuan</th>
									<th>In</th>
									<th>Out</th>
									<th>Saldo</th>
									<th>Created By</th>
									<th>Jam dibuat</th>
								</tr>
							</thead>
							<tbody>
								'.$tbody.'
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4"></td>
									<td>Total : </td>
									<td><b>'.$totalIN.'</b></td>
									<td><b>'.$totalOUT.'</b></td>
									<td class="bg-success"><b>'.$onhand.'</b></td>
									<td colspan="2"></td>
								</tr>
							</tfoot>
						</table>
					</div>
            	</div>';
		echo $output;
	}


}