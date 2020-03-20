<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class C_GLap extends CI_Controller
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
		$this->load->library('Excel');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_selep');
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_glap');

		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) { } else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Generate Laporan';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/GLap/V_index');
		$this->load->view('V_Footer', $data);
	}

	/*EXPORT*/
	public function createLaporan1() // Monitoring Produksi
	{
		$tanggal1 = $this->input->post('tanggal_awal');
		$tanggal2 = $this->input->post('tanggal_akhir');

		// =================== START OF AMBIL DATA & DEKLARASI ARRAY =================== //
		$vMould = $this->M_glap->vMoulding($tanggal1, $tanggal2);
		$vMixing = $this->M_glap->vMixing($tanggal1, $tanggal2);
		$vCore = $this->M_glap->vCore($tanggal1, $tanggal2);
		$vOTT = $this->M_glap->vOTT($tanggal1, $tanggal2);
		
		$jadi = array();
		$o = 0;
		foreach ($vMould as $vol) {
			$scrap = $this->M_glap->getDetail($vol['moulding_id']);

			$jadi[$o]['jenis'] = 'Moulding';
			$jadi[$o]['id'] = $vol['moulding_id'];
			$jadi[$o]['Tanggal'] = $vol['production_date'];
			$jadi[$o]['KodeKomponen'] = $vol['component_code'] .'  =>  '. $vol['component_description'];
			$jadi[$o]['Kode4dg'] = substr($vol['component_code'], 0, 4);
			$jadi[$o]['KodeCor'] = $vol['print_code'];
			$jadi[$o]['HasilCor'] = $vol['moulding_quantity'];
			$jadi[$o]['HasilBaik'] = $vol['bongkar_qty'] - $vol['scrap_qty'];
			$jadi[$o]['Reject'] = (empty($vol['scrap_qty']) ? '0' : $vol['scrap_qty'] );
			$jadi[$o]['IP'] = ($vol['moulding_quantity'] - $vol['bongkar_qty']) ;
			$jadi[$o]['RC'] = '0';
			$jadi[$o]['DF'] = '0';
			$jadi[$o]['CR'] = '0';
			$jadi[$o]['TK'] = '0';
			$jadi[$o]['PR'] = '0';
			$jadi[$o]['KP'] = '0';
			$jadi[$o]['CT'] = '0';
			$jadi[$o]['TS'] = '0';
			$jadi[$o]['CO'] = '0';
			$jadi[$o]['CW'] = '0';
			$jadi[$o]['SC'] = '0';
			$jadi[$o]['PH'] = '0';
			$jadi[$o]['SG'] = '0';
			$jadi[$o]['GS'] = '0';
			$jadi[$o]['CP'] = '0';
			$jadi[$o]['TT'] = '0';
			$jadi[$o]['BC'] = '0';
			$jadi[$o]['KS'] = '0';
			$jadi[$o]['NK'] = '0';
			$jadi[$o]['MS'] = '0';
			$jadi[$o]['RT'] = '0';
			$jadi[$o]['PK'] = '0';
			foreach ($scrap as $key) {
				if ($key['kode_scrap'] == 'RC') {
					$jadi[$o]['RC'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'DF') {
					$jadi[$o]['DF'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'CR') {
					$jadi[$o]['CR'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'TK') {
					$jadi[$o]['TK'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'PR') {
					$jadi[$o]['PR'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'KP') {
					$jadi[$o]['KP'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'CT') {
					$jadi[$o]['CT'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'TS') {
					$jadi[$o]['TS'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'CO') {
					$jadi[$o]['CO'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'CW') {
					$jadi[$o]['CW'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'SC') {
					$jadi[$o]['SC'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'PH') {
					$jadi[$o]['PH'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'SG') {
					$jadi[$o]['SG'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'GS') {
					$jadi[$o]['GS'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'CP') {
					$jadi[$o]['CP'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'TT') {
					$jadi[$o]['TT'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'BC') {
					$jadi[$o]['BC'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'KS') {
					$jadi[$o]['KS'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'NK') {
					$jadi[$o]['NK'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'MS') {
					$jadi[$o]['MS'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'RT') {
					$jadi[$o]['RT'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'PK') {
					$jadi[$o]['PK'] += $key['quantity'];
				} else { }
			}
			$o++;
		}
	
		foreach ($vMixing as $vol) {
			$jadi[$o]['jenis'] = 'Mixing';
			$jadi[$o]['id'] = $vol['mixing_id'];
			$jadi[$o]['Tanggal'] = $vol['production_date'];
			$jadi[$o]['KodeKomponen'] = $vol['component_code'] .'  =>  '. $vol['component_description'];
			$jadi[$o]['Kode4dg'] = substr($vol['component_code'], 0, 4);
			$jadi[$o]['KodeCor'] = '';
			$jadi[$o]['HasilCor'] = $vol['mixing_quantity'];
			$jadi[$o]['HasilBaik'] = $vol['mixing_quantity'];
			$jadi[$o]['Reject'] = '0';
			$jadi[$o]['IP'] = '0';
			$jadi[$o]['RC'] = '0';
			$jadi[$o]['DF'] = '0';
			$jadi[$o]['CR'] = '0';
			$jadi[$o]['TK'] = '0';
			$jadi[$o]['PR'] = '0';
			$jadi[$o]['KP'] = '0';
			$jadi[$o]['CT'] = '0';
			$jadi[$o]['TS'] = '0';
			$jadi[$o]['CO'] = '0';
			$jadi[$o]['CW'] = '0';
			$jadi[$o]['SC'] = '0';
			$jadi[$o]['PH'] = '0';
			$jadi[$o]['SG'] = '0';
			$jadi[$o]['GS'] = '0';
			$jadi[$o]['CP'] = '0';
			$jadi[$o]['TT'] = '0';
			$jadi[$o]['BC'] = '0';
			$jadi[$o]['KS'] = '0';
			$jadi[$o]['NK'] = '0';
			$jadi[$o]['MS'] = '0';
			$jadi[$o]['RT'] = '0';
			$jadi[$o]['PK'] = '0';
			$o++;
		}
		
		foreach ($vCore as $vol) {
			$jadi[$o]['jenis'] = 'Core';
			$jadi[$o]['id'] = $vol['core_id'];
			$jadi[$o]['Tanggal'] = $vol['production_date'];
			$jadi[$o]['KodeKomponen'] = $vol['component_code'] .'  =>  '. $vol['component_description'];
			$jadi[$o]['Kode4dg'] = substr($vol['component_code'], 0, 4);
			$jadi[$o]['KodeCor'] = '';
			$jadi[$o]['HasilCor'] = $vol['core_quantity'];
			$jadi[$o]['HasilBaik'] = $vol['core_quantity'];
			$jadi[$o]['Reject'] = '0';
			$jadi[$o]['IP'] = '0';
			$jadi[$o]['RC'] = '0';
			$jadi[$o]['DF'] = '0';
			$jadi[$o]['CR'] = '0';
			$jadi[$o]['TK'] = '0';
			$jadi[$o]['PR'] = '0';
			$jadi[$o]['KP'] = '0';
			$jadi[$o]['CT'] = '0';
			$jadi[$o]['TS'] = '0';
			$jadi[$o]['CO'] = '0';
			$jadi[$o]['CW'] = '0';
			$jadi[$o]['SC'] = '0';
			$jadi[$o]['PH'] = '0';
			$jadi[$o]['SG'] = '0';
			$jadi[$o]['GS'] = '0';
			$jadi[$o]['CP'] = '0';
			$jadi[$o]['TT'] = '0';
			$jadi[$o]['BC'] = '0';
			$jadi[$o]['KS'] = '0';
			$jadi[$o]['NK'] = '0';
			$jadi[$o]['MS'] = '0';
			$jadi[$o]['RT'] = '0';
			$jadi[$o]['PK'] = '0';
			$o++;
		}

		foreach ($vOTT as $vol) {
			$jadi[$o]['jenis'] = 'OTT';
			$jadi[$o]['id'] = $vol['id'];
			$jadi[$o]['Tanggal'] = $vol['otttgl'];
			$jadi[$o]['KodeKomponen'] = 'OTT';
			$jadi[$o]['Kode4dg'] = 'OTT';
			$jadi[$o]['KodeCor'] = '';
			$jadi[$o]['HasilCor'] = '0';
			$jadi[$o]['HasilBaik'] = '0';
			$jadi[$o]['Reject'] = '0';
			$jadi[$o]['IP'] = '0';
			$jadi[$o]['RC'] = '0';
			$jadi[$o]['DF'] = '0';
			$jadi[$o]['CR'] = '0';
			$jadi[$o]['TK'] = '0';
			$jadi[$o]['PR'] = '0';
			$jadi[$o]['KP'] = '0';
			$jadi[$o]['CT'] = '0';
			$jadi[$o]['TS'] = '0';
			$jadi[$o]['CO'] = '0';
			$jadi[$o]['CW'] = '0';
			$jadi[$o]['SC'] = '0';
			$jadi[$o]['PH'] = '0';
			$jadi[$o]['SG'] = '0';
			$jadi[$o]['GS'] = '0';
			$jadi[$o]['CP'] = '0';
			$jadi[$o]['TT'] = '0';
			$jadi[$o]['BC'] = '0';
			$jadi[$o]['KS'] = '0';
			$jadi[$o]['NK'] = '0';
			$jadi[$o]['MS'] = '0';
			$jadi[$o]['RT'] = '0';
			$jadi[$o]['PK'] = '0';
			$o++;
		}

		$arrayKode = array();
		foreach($jadi as $item) {
			if(!in_array($item['KodeKomponen'], $arrayKode)) {
				$arrayKode[] = $item['KodeKomponen'];
			}
		}

		$hasil = array();
		for ($ak=0; $ak < sizeof($arrayKode); $ak++) { 
			$i = 0;
			for ($jd=0; $jd < sizeof($jadi); $jd++) { 
				if($arrayKode[$ak] == $jadi[$jd]['KodeKomponen']) {
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['jenis'] = $jadi[$jd]['jenis'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['id'] = $jadi[$jd]['id'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['Tanggal'] = $jadi[$jd]['Tanggal'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['KodeKomponen'] = $jadi[$jd]['KodeKomponen'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['KodeCor'] = $jadi[$jd]['KodeCor'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['HasilCor'] = $jadi[$jd]['HasilCor'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['HasilBaik'] = $jadi[$jd]['HasilBaik'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['Reject'] = $jadi[$jd]['Reject'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['IP'] = $jadi[$jd]['IP'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['RC'] = $jadi[$jd]['RC'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['DF'] = $jadi[$jd]['DF'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['CR'] = $jadi[$jd]['CR'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['TK'] = $jadi[$jd]['TK'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['PR'] = $jadi[$jd]['PR'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['KP'] = $jadi[$jd]['KP'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['CT'] = $jadi[$jd]['CT'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['TS'] = $jadi[$jd]['TS'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['CO'] = $jadi[$jd]['CO'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['CW'] = $jadi[$jd]['CW'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['SC'] = $jadi[$jd]['SC'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['PH'] = $jadi[$jd]['PH'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['SG'] = $jadi[$jd]['SG'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['GS'] = $jadi[$jd]['GS'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['CP'] = $jadi[$jd]['CP'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['TT'] = $jadi[$jd]['TT'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['BC'] = $jadi[$jd]['BC'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['KS'] = $jadi[$jd]['KS'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['NK'] = $jadi[$jd]['NK'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['MS'] = $jadi[$jd]['MS'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['RT'] = $jadi[$jd]['RT'];
					$hasil[$jadi[$jd]['KodeKomponen']][$i]['PK'] = $jadi[$jd]['PK'];
					$i++;
				}
				
			}
		}
		// =================== END OF AMBIL DATA & DEKLARASI ARRAY =================== //

		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

		$header = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				)
			)
		);
		$bold = array(
			'font'  => array(
				'bold'  => true,
			)
		);
		$body = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		// =================== START OF DECLARE HEADER & STYLING =================== //
		$worksheet->setCellValue('B1', 'MONITORING PRODUKSI UP2L')->getStyle('B1')->applyFromArray($bold);
		$worksheet->setCellValue('B2', date("d-m-Y", strtotime($tanggal1)) . ' s/d ' . date("d-m-Y", strtotime($tanggal2)))->getStyle('B2')->applyFromArray($bold);

		$worksheet->setCellValue('A4', 'NO');
		$worksheet->setCellValue('B4', 'KODE COR');
		$worksheet->setCellValue('C4', 'CETAK');
		$worksheet->setCellValue('D4', 'RC');
		$worksheet->setCellValue('E4', 'DF');
		$worksheet->setCellValue('F4', 'CR');
		$worksheet->setCellValue('G4', 'TK'); //Tdk ada
		$worksheet->setCellValue('H4', 'PR'); //Tdk ada
		$worksheet->setCellValue('I4', 'KP');
		$worksheet->setCellValue('J4', 'CT');
		$worksheet->setCellValue('K4', 'TS');
		$worksheet->setCellValue('L4', 'CO'); //Tdk ada
		$worksheet->setCellValue('M4', 'CW');
		$worksheet->setCellValue('N4', 'SC'); //Tdk ada
		$worksheet->setCellValue('O4', 'PH');
		$worksheet->setCellValue('P4', 'SG'); //Tdk ada
		$worksheet->setCellValue('Q4', 'GS');
		$worksheet->setCellValue('R4', 'CP');
		$worksheet->setCellValue('S4', 'TT');
		$worksheet->setCellValue('T4', 'BC');
		$worksheet->setCellValue('U4', 'KS');
		$worksheet->setCellValue('V4', 'NK');
		$worksheet->setCellValue('W4', 'MS');
		$worksheet->setCellValue('X4', 'RT');
		$worksheet->setCellValue('Y4', 'PK'); //Tdk ada
		// $worksheet->setCellValue('Z4', 'LL');
		$worksheet->setCellValue('Z4', 'JML REJ');
		$worksheet->setCellValue('AA4', 'BAIK');
		$worksheet->setCellValue('AB4', 'IP');
		$worksheet->setCellValue('AC4', 'TGL');
		// =================== END OF DECLARE HEADER & STYLING =================== //

		$worksheet->getRowDimension('4')->setRowHeight(30);

		$highestRow = $worksheet->getHighestRow() + 1;

		$no = 1;

		// =================== START OF DECLARE CONTENT & STYLING =================== //
		foreach ($hasil as $nameOf => $thisArr) {
			
			for( $x = "A"; ; $x++) {
				$worksheet->getStyle($x.'4')->applyFromArray($header);
				$worksheet->getColumnDimension($x)->setAutoSize(true);
				$worksheet->getStyle($x . $highestRow)->applyFromArray($body);
				if( $x == "AC") break;
			}

			$worksheet->setCellValue('A' . $highestRow, 'NAMA KOMPONEN : ' . $nameOf)->mergeCells('A' . $highestRow . ':AC' . $highestRow)->getStyle('A' . $highestRow . ':AC' . $highestRow)->applyFromArray($body);
			$highestRow++;
			foreach ($thisArr as $thisVal) {
				$worksheet->setCellValue('A' . $highestRow, $no);
				$worksheet->setCellValue('B' . $highestRow, $thisVal['KodeCor']);
				$worksheet->setCellValue('C' . $highestRow, $thisVal['HasilCor']);
				$worksheet->setCellValue('D' . $highestRow, $thisVal['RC']);
				$worksheet->setCellValue('E' . $highestRow, $thisVal['DF']);
				$worksheet->setCellValue('F' . $highestRow, $thisVal['CR']);
				$worksheet->setCellValue('G' . $highestRow, $thisVal['TK']);
				$worksheet->setCellValue('H' . $highestRow, $thisVal['PR']);
				$worksheet->setCellValue('I' . $highestRow, $thisVal['KP']);
				$worksheet->setCellValue('J' . $highestRow, $thisVal['CT']);
				$worksheet->setCellValue('K' . $highestRow, $thisVal['TS']);
				$worksheet->setCellValue('L' . $highestRow, $thisVal['CO']);
				$worksheet->setCellValue('M' . $highestRow, $thisVal['CW']);
				$worksheet->setCellValue('N' . $highestRow, $thisVal['SC']);
				$worksheet->setCellValue('O' . $highestRow, $thisVal['PH']);
				$worksheet->setCellValue('P' . $highestRow, $thisVal['SG']);
				$worksheet->setCellValue('Q' . $highestRow, $thisVal['GS']);
				$worksheet->setCellValue('R' . $highestRow, $thisVal['CP']);
				$worksheet->setCellValue('S' . $highestRow, $thisVal['TT']);
				$worksheet->setCellValue('T' . $highestRow, $thisVal['BC']);
				$worksheet->setCellValue('U' . $highestRow, $thisVal['KS']);
				$worksheet->setCellValue('V' . $highestRow, $thisVal['NK']);
				$worksheet->setCellValue('W' . $highestRow, $thisVal['MS']);
				$worksheet->setCellValue('X' . $highestRow, $thisVal['RT']);
				$worksheet->setCellValue('Y' . $highestRow, $thisVal['PK']);
				$worksheet->setCellValue('Z' . $highestRow, $thisVal['Reject']);
				$worksheet->setCellValue('AA' . $highestRow, $thisVal['HasilBaik']);
				$worksheet->setCellValue('AB' . $highestRow, $thisVal['IP']);
				$worksheet->setCellValue('AC' . $highestRow, $thisVal['Tanggal']);

				$worksheet->getStyle('A' . $highestRow . ':AC' . $highestRow)->applyFromArray($body);
				$highestRow++;
				$no++;
			}
			$highestRow++;
		}
		// =================== END OF DECLARE CONTENT & STYLING =================== //

		$worksheet->setTitle('Monthly_Planning');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="MONPROD.xls"');
		$objWriter->save("php://output");
	}

	public function createLaporan2() // Evaluasi Produksi
	{
		$tanggal1 = $this->input->post('tanggal_awal');
		$tanggal2 = $this->input->post('tanggal_akhir');

		// =================== START OF AMBIL DATA & DEKLARASI ARRAY =================== //
		$vMould = $this->M_glap->vMoulding($tanggal1, $tanggal2);
		
		$jadi = array();
		$o = 0;
		foreach ($vMould as $vol) {
			$master = $this->M_glap->getMasterItem($vol['component_code']);
			$scrap = $this->M_glap->getDetail($vol['moulding_id']);

			$TonageBeik_f = (($master[0]['berat']) * ($vol['bongkar_qty'] - $vol['scrap_qty']));
			$TonageIP_f = ($master[0]['berat'] * ($vol['moulding_quantity'] - $vol['bongkar_qty']));
			$TonageReject_f = ($vol['scrap_qty'] * $master[0]['berat']);

			$jadi[$o]['jenis'] = 'Moulding';
			$jadi[$o]['id'] = $vol['moulding_id'];
			$jadi[$o]['Tanggal'] = $vol['production_date'];
			$jadi[$o]['KodeKomponen'] = $vol['component_code'];
			$jadi[$o]['NamaKomponen'] = $vol['component_description'];
			$jadi[$o]['Kode4dg'] = substr($vol['component_code'], 0, 3);
			$jadi[$o]['HasilCor'] = $vol['moulding_quantity'];
			$jadi[$o]['HasilBaik'] = $vol['bongkar_qty'] - $vol['scrap_qty'];
			$jadi[$o]['Berat'] = $master[0]['berat'];
			$jadi[$o]['Reject'] = (empty($vol['scrap_qty']) ? '0' : $vol['scrap_qty'] );
			$jadi[$o]['IP'] = ($vol['moulding_quantity'] - $vol['bongkar_qty']) ;
			$jadi[$o]['TonageBaik'] = $TonageBeik_f;
			$jadi[$o]['TonageIP'] = $TonageIP_f;
			$jadi[$o]['TonageReject'] = $TonageReject_f;
			$jadi[$o]['ProsentaseReject'] = '0';
			$jadi[$o]['PreBaik'] = ($vol['bongkar_qty'] - $vol['scrap_qty']) + ($vol['moulding_quantity'] - $vol['bongkar_qty']);
			$jadi[$o]['MS'] = '0';
			$jadi[$o]['DF'] = '0';
			$jadi[$o]['KP'] = '0';
			$jadi[$o]['CT'] = '0';
			$jadi[$o]['TS'] = '0';
			$jadi[$o]['GS'] = '0';
			$jadi[$o]['CP'] = '0';
			$jadi[$o]['RT'] = '0';
			$jadi[$o]['CW'] = '0';
			$jadi[$o]['TT'] = '0';
			$jadi[$o]['BC'] = '0';
			$jadi[$o]['PH'] = '0';
			$jadi[$o]['KS'] = '0';
			$jadi[$o]['NK'] = '0';
			$jadi[$o]['CR'] = '0';
			$jadi[$o]['RC'] = '0';
			$jadi[$o]['LL'] = '0';
			foreach ($scrap as $key) {
				if ($key['kode_scrap'] == 'MS') {
					$jadi[$o]['MS'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'DF') {
					$jadi[$o]['DF'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'KP') {
					$jadi[$o]['KP'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'CT') {
					$jadi[$o]['CT'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'TS') {
					$jadi[$o]['TS'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'GS') {
					$jadi[$o]['GS'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'CP') {
					$jadi[$o]['CP'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'RT') {
					$jadi[$o]['RT'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'CW') {
					$jadi[$o]['CW'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'TT') {
					$jadi[$o]['TT'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'BC') {
					$jadi[$o]['BC'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'PH') {
					$jadi[$o]['PH'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'KS') {
					$jadi[$o]['KS'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'NK') {
					$jadi[$o]['NK'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'CR') {
					$jadi[$o]['CR'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'RC') {
					$jadi[$o]['RC'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'LL') {
					$jadi[$o]['LL'] += $key['quantity'];
				} else { }
			}
			$o++;
		}

		$arrayKode = array();

		foreach($jadi as $item) {
			if(!in_array($item['Kode4dg'], $arrayKode)) {
				$arrayKode[] = $item['Kode4dg'];
			}
		}

		$hasil = array();
		for ($ak=0; $ak < sizeof($arrayKode); $ak++) {
			$i = 0;
			for ($jd=0; $jd < sizeof($jadi); $jd++) {
				if($arrayKode[$ak] == $jadi[$jd]['Kode4dg']) {
					$hasil[$jadi[$jd]['Kode4dg']][$i]['jenis'] = $jadi[$jd]['jenis'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['id'] = $jadi[$jd]['id'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['Tanggal'] = $jadi[$jd]['Tanggal'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['KodeKomponen'] = $jadi[$jd]['KodeKomponen'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['NamaKomponen'] = $jadi[$jd]['NamaKomponen'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['Kode4dg'] = $jadi[$jd]['Kode4dg'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['HasilCor'] = $jadi[$jd]['HasilCor'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['HasilBaik'] = $jadi[$jd]['HasilBaik'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['Berat'] = $jadi[$jd]['Berat'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['Reject'] = $jadi[$jd]['Reject'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['IP'] = $jadi[$jd]['IP'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['TonageBaik'] = $jadi[$jd]['TonageBaik'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['TonageIP'] = $jadi[$jd]['TonageIP'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['TonageReject'] = $jadi[$jd]['TonageReject'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['ProsentaseReject'] = $jadi[$jd]['ProsentaseReject'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['PreBaik'] = $jadi[$jd]['PreBaik'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['MS'] = $jadi[$jd]['MS'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['DF'] = $jadi[$jd]['DF'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['KP'] = $jadi[$jd]['KP'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['CT'] = $jadi[$jd]['CT'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['TS'] = $jadi[$jd]['TS'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['GS'] = $jadi[$jd]['GS'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['CP'] = $jadi[$jd]['CP'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['RT'] = $jadi[$jd]['RT'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['CW'] = $jadi[$jd]['CW'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['TT'] = $jadi[$jd]['TT'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['BC'] = $jadi[$jd]['BC'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['PH'] = $jadi[$jd]['PH'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['KS'] = $jadi[$jd]['KS'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['NK'] = $jadi[$jd]['NK'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['CR'] = $jadi[$jd]['CR'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['RC'] = $jadi[$jd]['RC'];
					$hasil[$jadi[$jd]['Kode4dg']][$i]['LL'] = $jadi[$jd]['LL'];
					$i++;
				}
				
			}
		}

		// =================== START OF AMBIL DATA & DEKLARASI ARRAY =================== //

		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

		// =================== START OF TEMPLATE STYLING =================== //
		$bold = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
			)
		);
		$header = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
			)
		);
		// =================== END OF TEMPLATE STYLING =================== //

		// =================== START OF DECLARE HEADER & STYLING =================== //
		$worksheet->getColumnDimension('A')->setWidth(8);
		$worksheet->getColumnDimension('B')->setWidth(30);
		$worksheet->getColumnDimension('C')->setWidth(30);
		
		for( $x = "A"; ; $x++) {
			$worksheet->mergeCells($x.'8:'.$x.'9');
			if( $x == "Q") break;
		}
		for( $x = "D"; ; $x++) {
			$worksheet->getColumnDimension($x)->setWidth(10);
			if( $x == "Q") break;
		}
		for( $x = "R"; ; $x++) {
			$worksheet->getColumnDimension($x)->setWidth(5);
			if( $x == "AI") break;
		}
		
		$worksheet->mergeCells('A1:C1');
		$worksheet->mergeCells('A2:C2');
		$worksheet->mergeCells('A3:C3');
		$worksheet->mergeCells('A4:C4');
		$worksheet->mergeCells('A5:C5');

		$worksheet->setCellValue('A1', 'CV. Karya Hidup Sentosa')->getStyle('A1')->applyFromArray($bold);
		$worksheet->setCellValue('A2', 'Yogyakarta')->getStyle('A2')->applyFromArray($bold);
		$worksheet->setCellValue('A4', 'LAPORAN EVALUASI PRODUKSI PENGECORAN LOGAM')->getStyle('A4')->applyFromArray($bold);
		$worksheet->setCellValue('A5', "Tgl : " . date('d-m-Y', strtotime($tanggal1)) . " s/d " . date('d-m-Y', strtotime($tanggal2)))->getStyle('A5')->applyFromArray($bold);
		$worksheet->setCellValue('A8', 'No');
		$worksheet->setCellValue('B8', 'Kode Komponen');
		$worksheet->setCellValue('C8', 'Nama Komponen');
		$worksheet->setCellValue('D8', 'Fkt. Pengali'); //Tdk diisi
		$worksheet->setCellValue('E8', 'Berat Komp(Kg)');
		$worksheet->setCellValue('F8', 'Renc. Prod. (Pcs)'); //Tdk diisi
		$worksheet->setCellValue('G8', 'Jmlh Cetak (Pcs)');
		$worksheet->setCellValue('H8', 'Hasil Baik (Pcs)');
		$worksheet->setCellValue('I8', '% Renc'); //Tdk diisi
		$worksheet->setCellValue('J8', 'Tonage Baik (Kg)');
		$worksheet->setCellValue('K8', 'IP (Pcs)');
		$worksheet->setCellValue('L8', 'Tonage IP (Kg)');
		$worksheet->setCellValue('M8', 'Jumlah Reject (Pcs)');
		$worksheet->setCellValue('N8', 'Tonage Reject (Kg)');
		$worksheet->setCellValue('O8', '% Reject');
		$worksheet->setCellValue('P8', 'Pre Baik (Pcs)');
		$worksheet->setCellValue('Q8', 'diksi % Renc'); // Tdk diisi
		$worksheet->setCellValue('R8', 'MS');
		$worksheet->setCellValue('S8', 'DF');
		$worksheet->setCellValue('T8', 'KP');
		$worksheet->setCellValue('U8', 'CT');
		$worksheet->setCellValue('V8', 'TS');
		$worksheet->setCellValue('W8', 'GS');
		$worksheet->setCellValue('X8', 'CP');
		$worksheet->setCellValue('Y8', 'RT');
		$worksheet->setCellValue('Z8', 'CW');
		$worksheet->setCellValue('AA8', 'TT');
		$worksheet->setCellValue('AB8', 'BC');
		$worksheet->setCellValue('AC8', 'PH');
		$worksheet->setCellValue('AD8', 'KS');
		$worksheet->setCellValue('AE8', 'NK');
		$worksheet->setCellValue('AF8', 'CR');
		$worksheet->setCellValue('AG8', 'RC');
		$worksheet->setCellValue('AH8', 'LL');
		$worksheet->getStyle('A8:AH8')->applyFromArray($header);
		$worksheet->getStyle('A8:Q8')->getAlignment()->setWrapText(true); 
		// =================== END OF DECLARE HEADER & STYLING =================== //

		$highestRow = $worksheet->getHighestRow() + 1;
		$no = 1;
		// =================== START OF DECLARE CONTENT =================== //
		
		foreach ($hasil as $tri => $isi) {
			$kode[$tri][] = $isi[0]['KodeKomponen'];
			$tridigit[] = $tri; 
			for ($pi=0; $pi < sizeof($isi); $pi++) { 
				if ($isi[0]['KodeKomponen'] != $isi[$pi]['KodeKomponen']) {
					$kode[$tri][] = $isi[$pi]['KodeKomponen'];
				}
				
			}
		}
		foreach ($tridigit as $td) {
			foreach ($kode[$td] as $inti) {
				$nilai = 0;
				for ($dn=0; $dn < sizeof($hasil[$td]); $dn++) { 
					if ($inti == $hasil[$td][$dn]['KodeKomponen']) {
						$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['KodeKomponen'] = $hasil[$td][$dn]['KodeKomponen'];
						if ($nilai == FALSE) {
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['KodeKomponen'] = $hasil[$td][$dn]['KodeKomponen'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['NamaKomponen'] = $hasil[$td][$dn]['NamaKomponen'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['HasilCor'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['HasilBaik'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['Berat'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['Reject'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['IP'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['TonageBaik'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['TonageIP'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['TonageReject'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['ProsentaseReject'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['PreBaik'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['MS'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['DF'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['KP'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['CT'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['TS'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['GS'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['CP'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['RT'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['CW'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['TT'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['BC'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['PH'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['KS'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['NK'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['CR'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['RC'] = $nilai;
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['LL'] = $nilai;

							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['HasilCor'] +=  $hasil[$td][$dn]['HasilCor'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['HasilBaik'] += $hasil[$td][$dn]['HasilBaik'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['Berat'] += $hasil[$td][$dn]['Berat'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['Reject'] += $hasil[$td][$dn]['Reject'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['IP'] += $hasil[$td][$dn]['IP'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['TonageBaik'] += $hasil[$td][$dn]['TonageBaik'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['TonageIP'] += $hasil[$td][$dn]['TonageIP'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['TonageReject'] += $hasil[$td][$dn]['TonageReject'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['ProsentaseReject'] += $hasil[$td][$dn]['ProsentaseReject'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['PreBaik'] += $hasil[$td][$dn]['PreBaik'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['MS'] += $hasil[$td][$dn]['MS'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['DF'] += $hasil[$td][$dn]['DF'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['KP'] += $hasil[$td][$dn]['KP'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['CT'] += $hasil[$td][$dn]['CT'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['TS'] += $hasil[$td][$dn]['TS'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['GS'] += $hasil[$td][$dn]['GS'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['CP'] += $hasil[$td][$dn]['CP'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['RT'] += $hasil[$td][$dn]['RT'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['CW'] += $hasil[$td][$dn]['CW'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['TT'] += $hasil[$td][$dn]['TT'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['BC'] += $hasil[$td][$dn]['BC'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['PH'] += $hasil[$td][$dn]['PH'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['KS'] += $hasil[$td][$dn]['KS'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['NK'] += $hasil[$td][$dn]['NK'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['CR'] += $hasil[$td][$dn]['CR'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['RC'] += $hasil[$td][$dn]['RC'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['LL'] += $hasil[$td][$dn]['LL'];
							$nilai++;
						} else {
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['HasilCor'] +=  $hasil[$td][$dn]['HasilCor'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['HasilBaik'] += $hasil[$td][$dn]['HasilBaik'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['Berat'] += $hasil[$td][$dn]['Berat'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['Reject'] += $hasil[$td][$dn]['Reject'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['IP'] += $hasil[$td][$dn]['IP'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['TonageBaik'] += $hasil[$td][$dn]['TonageBaik'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['TonageIP'] += $hasil[$td][$dn]['TonageIP'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['TonageReject'] += $hasil[$td][$dn]['TonageReject'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['ProsentaseReject'] += $hasil[$td][$dn]['ProsentaseReject'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['PreBaik'] += $hasil[$td][$dn]['PreBaik'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['MS'] += $hasil[$td][$dn]['MS'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['DF'] += $hasil[$td][$dn]['DF'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['KP'] += $hasil[$td][$dn]['KP'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['CT'] += $hasil[$td][$dn]['CT'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['TS'] += $hasil[$td][$dn]['TS'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['GS'] += $hasil[$td][$dn]['GS'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['CP'] += $hasil[$td][$dn]['CP'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['RT'] += $hasil[$td][$dn]['RT'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['CW'] += $hasil[$td][$dn]['CW'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['TT'] += $hasil[$td][$dn]['TT'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['BC'] += $hasil[$td][$dn]['BC'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['PH'] += $hasil[$td][$dn]['PH'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['KS'] += $hasil[$td][$dn]['KS'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['NK'] += $hasil[$td][$dn]['NK'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['CR'] += $hasil[$td][$dn]['CR'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['RC'] += $hasil[$td][$dn]['RC'];
							$akhirat[$td][$hasil[$td][$dn]['KodeKomponen']]['LL'] += $hasil[$td][$dn]['LL'];
						}
					}
				}
			}
		}

		$vTotCetak = 0;
		$vTotBaik = 0;
		$vTotReject = 0;
		$vTotIp = 0;
		$vTotTonBaik = 0;
		$vTotTonReject = 0;
		$vTotTonIp = 0;
		$MS = 0;
		$DF = 0;
		$KP = 0;
		$CT = 0;
		$TS = 0;
		$GS = 0;
		$CP = 0;
		$RT = 0;
		$CW = 0;
		$TT = 0;
		$BC = 0;
		$PH = 0;
		$KS = 0;
		$NK = 0;
		$CR = 0;
		$RC = 0;
		$LL = 0;
		
		foreach ($akhirat as $ke => $dunia) {
			$worksheet->mergeCells('B'.$highestRow.':C'.$highestRow);
			$worksheet->setCellValue('B'. $highestRow, 'Tractor  : '.$ke);
			$highestRow++;
			foreach ($dunia as $alam) {
				$worksheet->setCellValue('A'. $highestRow, $no); // No
				$worksheet->setCellValue('B'. $highestRow, $alam['KodeKomponen']); //Komponen Kode
				$worksheet->setCellValue('C'. $highestRow, $alam['NamaKomponen']); // Nama Komponen
				$worksheet->setCellValue('D'. $highestRow, ''); //Faktor Pengali (tdk di-isi)
				$worksheet->setCellValue('E'. $highestRow, $alam['Berat']); //Berat Komponen
				$worksheet->setCellValue('F'. $highestRow, ''); //Rencana Produksi (tdk di-isi)
				$worksheet->setCellValue('G'. $highestRow, $alam['HasilCor']); //Jumlah Mould
				$worksheet->setCellValue('H'. $highestRow, $alam['HasilBaik']); // Hasil Baik
				$worksheet->setCellValue('I'. $highestRow, ''); // %Renc (tdk di-isi)
				$worksheet->setCellValue('J'. $highestRow, $alam['TonageBaik']); // Tonage Baik
				$worksheet->setCellValue('K'. $highestRow, $alam['IP']); //IP
				$worksheet->setCellValue('L'. $highestRow, $alam['TonageIP']); // Tonage IP
				$worksheet->setCellValue('M'. $highestRow, $alam['Reject']); // Jumlah Reject
				$worksheet->setCellValue('N'. $highestRow, $alam['TonageReject']); // Tonage Reject
				if (($alam['TonageReject'] + $alam['TonageBaik']) > 0) {
					$worksheet->setCellValue('O'. $highestRow, round($alam['TonageReject'] / ($alam['TonageReject'] + $alam['TonageBaik']) * 100, 2) ); // % Reject
				} else {
					$worksheet->setCellValue('O'. $highestRow, '0'); // % Reject
				}
				
				$worksheet->setCellValue('P'. $highestRow, $alam['PreBaik']); //Pre Baik
				$worksheet->setCellValue('Q'. $highestRow, ''); // Prediksi % Renc (tdk di-isi)
				$worksheet->setCellValue('R'. $highestRow, $alam['MS']); // SCRAP
				$worksheet->setCellValue('S'. $highestRow, $alam['DF']); // SCRAP
				$worksheet->setCellValue('T'. $highestRow, $alam['KP']); // SCRAP
				$worksheet->setCellValue('U'. $highestRow, $alam['CT']); // SCRAP
				$worksheet->setCellValue('V'. $highestRow, $alam['TS']); // SCRAP
				$worksheet->setCellValue('W'. $highestRow, $alam['GS']); // SCRAP
				$worksheet->setCellValue('X'. $highestRow, $alam['CP']); // SCRAP
				$worksheet->setCellValue('Y'. $highestRow, $alam['RT']); // SCRAP
				$worksheet->setCellValue('Z'. $highestRow, $alam['CW']); // SCRAP
				$worksheet->setCellValue('AA'. $highestRow, $alam['TT']); // SCRAP
				$worksheet->setCellValue('AB'. $highestRow, $alam['BC']); // SCRAP
				$worksheet->setCellValue('AC'. $highestRow, $alam['PH']); // SCRAP
				$worksheet->setCellValue('AD'. $highestRow, $alam['KS']); // SCRAP
				$worksheet->setCellValue('AE'. $highestRow, $alam['NK']); // SCRAP
				$worksheet->setCellValue('AF'. $highestRow, $alam['CR']); // SCRAP
				$worksheet->setCellValue('AG'. $highestRow, $alam['RC']); // SCRAP
				$worksheet->setCellValue('AH'. $highestRow, $alam['LL']); // SCRAP
				
				$vTotCetak += $alam['HasilCor'];
				$vTotBaik += $alam['HasilBaik'];
				$vTotReject += $alam['Reject'];
				$vTotIp += $alam['IP'];
				$vTotTonBaik += $alam['TonageBaik'];
				$vTotTonReject += $alam['TonageReject'];
				$vTotTonIp += $alam['TonageIP'];
				// =
				$MS += $alam['MS'];
				$DF += $alam['DF'];
				$KP += $alam['KP'];
				$CT += $alam['CT'];
				$TS += $alam['TS'];
				$GS += $alam['GS'];
				$CP += $alam['CP'];
				$RT += $alam['RT'];
				$CW += $alam['CW'];
				$TT += $alam['TT'];
				$BC += $alam['BC'];
				$PH += $alam['PH'];
				$KS += $alam['KS'];
				$NK += $alam['NK'];
				$CR += $alam['CR'];
				$RC += $alam['RC'];
				$LL += $alam['LL'];
				$allScr = $MS + $DF + $KP + $CT + $TS + $GS + $CP + $RT + $CW + $TT + $BC + $PH + $KS + $NK + $CR + $RC + $LL;
				$no++;
				$highestRow++;
			}

			// =================== START OF RUMUS PALING BAWAH =================== //

			$highestRow1 = ($highestRow - count($dunia));
			$highestRow2 = ($highestRow - 1);
			
			$vCetak = '=(SUM(G'.$highestRow1.':G'.($highestRow2).'))';
			$vBaik = '=(SUM(H'.$highestRow1.':H'.($highestRow2).'))';
			$vReject = '=(SUM(M'.$highestRow1.':M'.($highestRow2).'))';
			$vIp = '=(SUM(K'.$highestRow1.':K'.($highestRow2).'))';
			$vTonBaik = '=(SUM(J'.$highestRow1.':J'.($highestRow2).'))';
			$vTonReject = '=(SUM(N'.$highestRow1.':N'.($highestRow2).'))';
			$vTonIp = '=(SUM(L'.$highestRow1.':L'.($highestRow2).'))';

			$pBaik = '=(ROUNDDOWN(((H' . ($highestRow+1) . '+K' . ($highestRow+1) . ')/G'. ($highestRow+1) . '*100),2))';
			$pTonBaik = '=(ROUNDDOWN((J'.($highestRow+1).'/(J'.($highestRow+1).'+L'.($highestRow+1).'+N'.($highestRow+1).')*100),2))';
			$pReject = '=(ROUNDDOWN(((M'.($highestRow+1).'/G'.($highestRow+1).')*100),2))';
			$pTonReject = '=(ROUNDDOWN((N'.($highestRow+1).'/(J'.($highestRow+1).'+L'.($highestRow+1).'+N'.($highestRow+1).')*100),2))';
			// =================== END OF RUMUS PALING BAWAH =================== //

			$highestRow++;

			// =================== START OF CONTENT PALING BAWAH =================== //
			$worksheet->setCellValue('C'. $highestRow, 'Sub Total Produksi');
			$worksheet->setCellValue('G'. $highestRow, $vCetak); //CETAK
			$worksheet->setCellValue('H'. $highestRow, $vBaik); //BAIK
			$worksheet->setCellValue('J'. $highestRow, $vTonBaik); //TON. BAIK
			$worksheet->setCellValue('K'. $highestRow, $vIp); //IP
			$worksheet->setCellValue('L'. $highestRow, $vTonIp); //TON. IP
			$worksheet->setCellValue('M'. $highestRow, $vReject); //JUM. REJ
			$worksheet->setCellValue('N'. $highestRow, $vTonReject); //TON. REJ
			// =================== END OF CONTENT PALING BAWAH =================== //

			// =================== START OF RUMUS PALING BAWAH (SCRAP/REJECT) =================== //
			for( $x = "R"; ; $x++) {
				$worksheet->setCellValue($x . $highestRow, '=(SUM('.$x.$highestRow1.':'. $x . ($highestRow - 2).'))');
				$worksheet->setCellValue($x. ($highestRow+1), '=('.$x.''.$highestRow.'/$AI$'. $highestRow .'*100)');
				if( $x == "AH") break;
			}

			$worksheet->setCellValue('AI'. $highestRow, '=(SUM(R'.$highestRow.':AH'. $highestRow.'))'); //JUMLAH TOTAL DI SCRAPNYA
			// =================== END OF RUMUS PALING BAWAH (SCRAP/REJECT) =================== //

			$highestRow++;

			// =================== END OF RUMUS PALING BAWAH SENDIRI =================== //
			$worksheet->setCellValue('C'. $highestRow, 'Prosentase (%)');
			$worksheet->setCellValue('H'. $highestRow, $pBaik);
			$worksheet->setCellValue('J'. $highestRow, $pTonBaik);
			$worksheet->setCellValue('M'. $highestRow, $pReject);
			$worksheet->setCellValue('N'. $highestRow, $pTonReject);
			// =================== END OF RUMUS PALING BAWAH SENDIRI =================== //
			$highestRow = $highestRow + 3;
		}
		$highestRow = $highestRow + 3;
		// =================== END OF DECLARE CONTENT =================== //

		// =================== START OF CONTENT PALING BAWAH =================== //
		$worksheet->setCellValue('C'. $highestRow, 'Total Produksi');
		$worksheet->setCellValue('G'. $highestRow, $vTotCetak); //CETAK
		$worksheet->setCellValue('H'. $highestRow, $vTotBaik); //BAIK
		$worksheet->setCellValue('J'. $highestRow, $vTotTonBaik); //TON. BAIK
		$worksheet->setCellValue('K'. $highestRow, $vTotIp); //IP
		$worksheet->setCellValue('L'. $highestRow, $vTotTonIp); //TON. IP
		$worksheet->setCellValue('M'. $highestRow, $vTotReject); //JUM. REJ
		$worksheet->setCellValue('N'. $highestRow, $vTotTonReject); //TON. REJ
		$worksheet->setCellValue('O'. $highestRow, ''); //TON. % REJ
		$worksheet->setCellValue('R'. $highestRow, $MS); // SCR
		$worksheet->setCellValue('S'. $highestRow, $DF); // SCR
		$worksheet->setCellValue('T'. $highestRow, $KP); // SCR
		$worksheet->setCellValue('U'. $highestRow, $CT); // SCR
		$worksheet->setCellValue('V'. $highestRow, $TS); // SCR
		$worksheet->setCellValue('W'. $highestRow, $GS); // SCR
		$worksheet->setCellValue('X'. $highestRow, $CP); // SCR
		$worksheet->setCellValue('Y'. $highestRow, $RT); // SCR
		$worksheet->setCellValue('Z'. $highestRow, $CW); // SCR
		$worksheet->setCellValue('AA'. $highestRow, $TT); // SCR
		$worksheet->setCellValue('AB'. $highestRow, $BC); // SCR
		$worksheet->setCellValue('AC'. $highestRow, $PH); // SCR
		$worksheet->setCellValue('AD'. $highestRow, $KS); // SCR
		$worksheet->setCellValue('AE'. $highestRow, $NK); // SCR
		$worksheet->setCellValue('AF'. $highestRow, $CR); // SCR
		$worksheet->setCellValue('AG'. $highestRow, $RC); // SCR
		$worksheet->setCellValue('AH'. $highestRow, $LL); // SCR
		$worksheet->setCellValue('AI'. $highestRow, $allScr); // all
		$highestRow++;

		$pTotHasilBaik = round((($vTotBaik + $vTotIp) / $vTotCetak * 100),2);
		if (($vTotTonBaik+$vTotTonReject) > 0) {
			$pTotTonaBaik = round((($vTotTonBaik/($vTotTonBaik+$vTotTonReject)*100)),2);
			$PTotTonaReject = round((($vTotTonReject/($vTotTonReject + $vTotTonBaik) * 100)),2);
		} else {
			$pTotTonaBaik = 0;
			$PTotTonaReject = 0;
		}
		$pTotReject = round(($vTotTonReject / $vTotCetak * 100),2);
		
		if ($allScr == 0) {
			$pMS = 0;
			$pDF = 0;
			$pKP = 0;
			$pCT = 0;
			$pTS = 0;
			$pGS = 0;
			$pCP = 0;
			$pRT = 0;
			$pCW = 0;
			$pTT = 0;
			$pBC = 0;
			$pPH = 0;
			$pKS = 0;
			$pNK = 0;
			$pCR = 0;
			$pRC = 0;
			$pLL = 0;
		} else {
			$pMS = $MS/$allScr*100;
			$pDF = $DF/$allScr*100;
			$pKP = $KP/$allScr*100;
			$pCT = $CT/$allScr*100;
			$pTS = $TS/$allScr*100;
			$pGS = $GS/$allScr*100;
			$pCP = $CP/$allScr*100;
			$pRT = $RT/$allScr*100;
			$pCW = $CW/$allScr*100;
			$pTT = $TT/$allScr*100;
			$pBC = $BC/$allScr*100;
			$pPH = $PH/$allScr*100;
			$pKS = $KS/$allScr*100;
			$pNK = $NK/$allScr*100;
			$pCR = $CR/$allScr*100;
			$pRC = $RC/$allScr*100;
			$pLL = $LL/$allScr*100;
		}
		
		$worksheet->setCellValue('C'. $highestRow, 'Total Prosentase (%)');
		$worksheet->setCellValue('H'. $highestRow, $pTotHasilBaik);
		$worksheet->setCellValue('J'. $highestRow, $pTotTonaBaik);
		$worksheet->setCellValue('M'. $highestRow, $pTotReject);
		$worksheet->setCellValue('N'. $highestRow, $PTotTonaReject);
		$worksheet->setCellValue('R'. $highestRow, $pMS); // SCR Prosentase
		$worksheet->setCellValue('S'. $highestRow, $pDF); // SCR Prosentase
		$worksheet->setCellValue('T'. $highestRow, $pKP); // SCR Prosentase
		$worksheet->setCellValue('U'. $highestRow, $pCT); // SCR Prosentase
		$worksheet->setCellValue('V'. $highestRow, $pTS); // SCR Prosentase
		$worksheet->setCellValue('W'. $highestRow, $pGS); // SCR Prosentase
		$worksheet->setCellValue('X'. $highestRow, $pCP); // SCR Prosentase
		$worksheet->setCellValue('Y'. $highestRow, $pRT); // SCR Prosentase
		$worksheet->setCellValue('Z'. $highestRow, $pCW); // SCR Prosentase
		$worksheet->setCellValue('AA'. $highestRow, $pTT); // SCR Prosentase
		$worksheet->setCellValue('AB'. $highestRow, $pBC); // SCR Prosentase
		$worksheet->setCellValue('AC'. $highestRow, $pPH); // SCR Prosentase
		$worksheet->setCellValue('AD'. $highestRow, $pKS); // SCR Prosentase
		$worksheet->setCellValue('AE'. $highestRow, $pNK); // SCR Prosentase
		$worksheet->setCellValue('AF'. $highestRow, $pCR); // SCR Prosentase
		$worksheet->setCellValue('AG'. $highestRow, $pRC); // SCR Prosentase
		$worksheet->setCellValue('AH'. $highestRow, $pLL); // SCR Prosentase

		// =================== END OF CONTENT PALING BAWAH =================== //
		
		$worksheet->setTitle('Monthly_Planning');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="EVAPROD.xls"');
		$objWriter->save("php://output");
	}

	// LAPORAN 3 - 6 ITU DIBERIKAN KEPADA AKUNTANSI DAN PERSONALIA, JANGAN DIKASIH STYLING DAN JGN UBAH LEBAR KOLOM/BARIS
	// LAPORAN.E ITU DI PROSES DENGAN SOFTWARE FOX BASE(FOXPRO)
	/*
		maka, user dikasih tau : setelah download, itu terus kolom yang ada isi nya tanggal, formatnya diganti Date bukan Number, untuk kolom samping
		kanan itu pilih yg atas sendiri 12/12/99 dijamin bisa.
	*/

	public function createLaporan3() // DET_TRAN
	{
		$tanggal1 = $this->input->post('tanggal_awal');
		$tanggal2 = $this->input->post('tanggal_akhir');

		// =================== START OF AMBIL DATA & DEKLARASI ARRAY =================== //
		$vMould = $this->M_glap->vMoulding($tanggal1, $tanggal2);
		$vMixing = $this->M_glap->vMixing($tanggal1, $tanggal2);
		$vCore = $this->M_glap->vCore($tanggal1, $tanggal2);
		$vOTT = $this->M_glap->vOTT($tanggal1, $tanggal2);
		
		$jadi = array();
		$o = 0;
		foreach ($vMould as $vol) {
			$scrap = $this->M_glap->getDetail($vol['moulding_id']);
			$kodeProses = $this->M_glap->getMasterItem($vol['component_code']);
			$jadi[$o]['jenis'] = 'Moulding';
			$jadi[$o]['id'] = $vol['moulding_id'];
			$jadi[$o]['Tanggal'] = $vol['production_date'];
			$jadi[$o]['KodeKelompok'] = $vol['kode'];
			$jadi[$o]['KodeCor'] = $vol['print_code'];
			$jadi[$o]['KodeKomponen'] = $vol['component_code'];
			$jadi[$o]['KodeProses'] = (empty($vol['kode_proses']) ? $kodeProses[0]['kode_proses'] : $vol['kode_proses']);
			$jadi[$o]['HasilCor'] = $vol['moulding_quantity'];
			$jadi[$o]['HasilBaik'] = $vol['bongkar_qty'] - $vol['scrap_qty'];
			$jadi[$o]['RC'] = '';
			$jadi[$o]['DF'] = '';
			$jadi[$o]['CR'] = '';
			$jadi[$o]['TK'] = '';
			$jadi[$o]['PR'] = '';
			$jadi[$o]['KP'] = '';
			$jadi[$o]['CT'] = '';
			$jadi[$o]['TS'] = '';
			$jadi[$o]['CO'] = '';
			$jadi[$o]['CW'] = '';
			$jadi[$o]['SC'] = '';
			$jadi[$o]['PH'] = '';
			$jadi[$o]['SG'] = '';
			$jadi[$o]['GS'] = '';
			$jadi[$o]['CP'] = '';
			$jadi[$o]['TT'] = '';
			$jadi[$o]['BC'] = '';
			$jadi[$o]['KS'] = '';
			$jadi[$o]['NK'] = '';
			$jadi[$o]['MS'] = '';
			$jadi[$o]['RT'] = '';
			$jadi[$o]['PK'] = '';
			$jadi[$o]['ket_pengurangan'] = $vol['ket_pengurangan'];
			$jadi[$o]['jam_pengurangan'] = $vol['jam_pengurangan'];
			foreach ($scrap as $key) {
				if ($key['kode_scrap'] == 'RC') {
					$jadi[$o]['RC'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'DF') {
					$jadi[$o]['DF'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'CR') {
					$jadi[$o]['CR'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'TK') {
					$jadi[$o]['TK'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'PR') {
					$jadi[$o]['PR'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'KP') {
					$jadi[$o]['KP'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'CT') {
					$jadi[$o]['CT'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'TS') {
					$jadi[$o]['TS'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'CO') {
					$jadi[$o]['CO'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'CW') {
					$jadi[$o]['CW'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'SC') {
					$jadi[$o]['SC'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'PH') {
					$jadi[$o]['PH'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'SG') {
					$jadi[$o]['SG'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'GS') {
					$jadi[$o]['GS'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'CP') {
					$jadi[$o]['CP'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'TT') {
					$jadi[$o]['TT'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'BC') {
					$jadi[$o]['BC'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'KS') {
					$jadi[$o]['KS'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'NK') {
					$jadi[$o]['NK'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'MS') {
					$jadi[$o]['MS'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'RT') {
					$jadi[$o]['RT'] += $key['quantity'];
				} else if ($key['kode_scrap'] == 'PK') {
					$jadi[$o]['PK'] += $key['quantity'];
				} else { }
			}
			$jadi[$o]['Rej'] = '0'; // jumlah reject type-nya
			$jadi[$o]['Reject'] = (empty($vol['scrap_qty']) ? '0' : $vol['scrap_qty'] );
			$jadi[$o]['IP'] = ($vol['moulding_quantity'] - $vol['bongkar_qty']) ;
			$jadi[$o]['Keterangan'] = '';
			$o++;
		}
	
		foreach ($vMixing as $vol) {
			$kodeProses = $this->M_glap->getMasterItem($vol['component_code']);
			$jadi[$o]['jenis'] = 'Mixing';
			$jadi[$o]['id'] = $vol['mixing_id'];
			$jadi[$o]['Tanggal'] = $vol['production_date'];
			$jadi[$o]['KodeKelompok'] = $vol['kode'];
			$jadi[$o]['KodeCor'] = $vol['print_code'];
			$jadi[$o]['KodeKomponen'] = $vol['component_code'];
			$jadi[$o]['KodeProses'] = (empty($vol['kode_proses']) ? $kodeProses[0]['kode_proses'] : $vol['kode_proses']);
			$jadi[$o]['HasilCor'] = $vol['mixing_quantity'];
			$jadi[$o]['HasilBaik'] = $vol['mixing_quantity'];
			$jadi[$o]['RC'] = '0';
			$jadi[$o]['DF'] = '0';
			$jadi[$o]['CR'] = '0';
			$jadi[$o]['TK'] = '0';
			$jadi[$o]['PR'] = '0';
			$jadi[$o]['KP'] = '0';
			$jadi[$o]['CT'] = '0';
			$jadi[$o]['TS'] = '0';
			$jadi[$o]['CO'] = '0';
			$jadi[$o]['CW'] = '0';
			$jadi[$o]['SC'] = '0';
			$jadi[$o]['PH'] = '0';
			$jadi[$o]['SG'] = '0';
			$jadi[$o]['GS'] = '0';
			$jadi[$o]['CP'] = '0';
			$jadi[$o]['TT'] = '0';
			$jadi[$o]['BC'] = '0';
			$jadi[$o]['KS'] = '0';
			$jadi[$o]['NK'] = '0';
			$jadi[$o]['MS'] = '0';
			$jadi[$o]['RT'] = '0';
			$jadi[$o]['PK'] = '0';
			$jadi[$o]['Rej'] = '0';
			$jadi[$o]['Reject'] = '0';
			$jadi[$o]['IP'] = '0';
			$jadi[$o]['Keterangan'] = '';
			$o++;
		}
		
		foreach ($vCore as $vol) {
			$kodeProses = $this->M_glap->getMasterItem($vol['component_code']);
			$jadi[$o]['jenis'] = 'Core';
			$jadi[$o]['id'] = $vol['core_id'];
			$jadi[$o]['Tanggal'] = $vol['production_date'];
			$jadi[$o]['KodeKelompok'] = $vol['kode'];
			$jadi[$o]['KodeCor'] = $vol['print_code'];
			$jadi[$o]['KodeKomponen'] = $vol['component_code'];
			$jadi[$o]['KodeProses'] = (empty($vol['kode_proses']) ? $kodeProses[0]['kode_proses'] : $vol['kode_proses']);
			$jadi[$o]['HasilCor'] = $vol['core_quantity'];
			$jadi[$o]['HasilBaik'] = $vol['core_quantity'];
			$jadi[$o]['RC'] = '0';
			$jadi[$o]['DF'] = '0';
			$jadi[$o]['CR'] = '0';
			$jadi[$o]['TK'] = '0';
			$jadi[$o]['PR'] = '0';
			$jadi[$o]['KP'] = '0';
			$jadi[$o]['CT'] = '0';
			$jadi[$o]['TS'] = '0';
			$jadi[$o]['CO'] = '0';
			$jadi[$o]['CW'] = '0';
			$jadi[$o]['SC'] = '0';
			$jadi[$o]['PH'] = '0';
			$jadi[$o]['SG'] = '0';
			$jadi[$o]['GS'] = '0';
			$jadi[$o]['CP'] = '0';
			$jadi[$o]['TT'] = '0';
			$jadi[$o]['BC'] = '0';
			$jadi[$o]['KS'] = '0';
			$jadi[$o]['NK'] = '0';
			$jadi[$o]['MS'] = '0';
			$jadi[$o]['RT'] = '0';
			$jadi[$o]['PK'] = '0';
			$jadi[$o]['Rej'] = '0';
			$jadi[$o]['Reject'] = '0';
			$jadi[$o]['IP'] = '0';
			$jadi[$o]['Keterangan'] = '';
			$o++;
		}

		foreach ($vOTT as $vol) {
			$jadi[$o]['jenis'] = 'OTT';
			$jadi[$o]['id'] = $vol['id'];
			$jadi[$o]['Tanggal'] = $vol['otttgl'];
			$jadi[$o]['KodeKelompok'] = $vol['kode'];
			$jadi[$o]['KodeCor'] = $vol['kode_cor'];
			$jadi[$o]['KodeKomponen'] = 'OTT';
			$jadi[$o]['KodeProses'] = '';
			$jadi[$o]['HasilCor'] = '0';
			$jadi[$o]['HasilBaik'] = '0';
			$jadi[$o]['RC'] = '0';
			$jadi[$o]['DF'] = '0';
			$jadi[$o]['CR'] = '0';
			$jadi[$o]['TK'] = '0';
			$jadi[$o]['PR'] = '0';
			$jadi[$o]['KP'] = '0';
			$jadi[$o]['CT'] = '0';
			$jadi[$o]['TS'] = '0';
			$jadi[$o]['CO'] = '0';
			$jadi[$o]['CW'] = '0';
			$jadi[$o]['SC'] = '0';
			$jadi[$o]['PH'] = '0';
			$jadi[$o]['SG'] = '0';
			$jadi[$o]['GS'] = '0';
			$jadi[$o]['CP'] = '0';
			$jadi[$o]['TT'] = '0';
			$jadi[$o]['BC'] = '0';
			$jadi[$o]['KS'] = '0';
			$jadi[$o]['NK'] = '0';
			$jadi[$o]['MS'] = '0';
			$jadi[$o]['RT'] = '0';
			$jadi[$o]['PK'] = '0';
			$jadi[$o]['Rej'] = '0';
			$jadi[$o]['Reject'] = '0';
			$jadi[$o]['IP'] = '0';
			$jadi[$o]['Keterangan'] = '';
			$o++;
		}
	
		array_multisort(array_column($jadi, 'Tanggal'), SORT_ASC,
						array_column($jadi, 'KodeKelompok'),     SORT_ASC ,
						$jadi);
		// =================== END OF AMBIL DATA & DEKLARASI ARRAY =================== //
		
		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

		$worksheet->getColumnDimension('A')->setWidth(15);
		$worksheet->getColumnDimension('B')->setWidth(10);
		$worksheet->getColumnDimension('C')->setWidth(10);
		$worksheet->getColumnDimension('E')->setWidth(10);
		$worksheet->getColumnDimension('D')->setWidth(25);
		$worksheet->getColumnDimension('F')->setWidth(10);
		$worksheet->getColumnDimension('AC')->setWidth(8);
		$worksheet->getColumnDimension('AD')->setWidth(8);
		$worksheet->getColumnDimension('AE')->setWidth(8);
		$worksheet->getColumnDimension('BE')->setWidth(15);
		for( $x = "G"; ; $x++) {
			$worksheet->getColumnDimension($x)->setWidth(5);
			if( $x == "AB") break;
		}
		for ($y='AF'; ; $y++) { 
			$worksheet->getColumnDimension($y)->setWidth(5);
			if( $y == "BA") break;
		}

		$worksheet->setCellValue('A1', 'TGL,D');
		$worksheet->setCellValue('B1', 'KODEKLP,C,1');
		$worksheet->setCellValue('C1', 'KODECOR,C,10');
		$worksheet->setCellValue('D1', 'KODE_KOM,C,20');
		$worksheet->setCellValue('E1', 'KODEPRO,C,10');
		$worksheet->setCellValue('F1', 'HSL_COR,N,9,0');
		$worksheet->setCellValue('G1', 'RU_RC,N,9,0');
		$worksheet->setCellValue('H1', 'RU_DF,N,9,0');
		$worksheet->setCellValue('I1', 'RU_CR,N,9,0');
		$worksheet->setCellValue('J1', 'RU_TK,N,9,0');
		$worksheet->setCellValue('K1', 'RU_PR,N,9,0');
		$worksheet->setCellValue('L1', 'RU_KP,N,9,0');
		$worksheet->setCellValue('M1', 'RU_CT,N,9,0');
		$worksheet->setCellValue('N1', 'RU_TS,N,9,0');
		$worksheet->setCellValue('O1', 'RU_CO,N,9,0');
		$worksheet->setCellValue('P1', 'RU_CW,N,9,0');
		$worksheet->setCellValue('Q1', 'RU_SC,N,9,0');
		$worksheet->setCellValue('R1', 'RU_PH,N,9,0');
		$worksheet->setCellValue('S1', 'RU_SG,N,9,0');
		$worksheet->setCellValue('T1', 'RU_GS,N,9,0');
		$worksheet->setCellValue('U1', 'RU_CP,N,9,0');
		$worksheet->setCellValue('V1', 'RU_TT,N,9,0');
		$worksheet->setCellValue('W1', 'RU_BC,N,9,0');
		$worksheet->setCellValue('X1', 'RU_KS,N,9,0');
		$worksheet->setCellValue('Y1', 'RU_NK,N,9,0');
		$worksheet->setCellValue('Z1', 'RU_MS,N,9,0');
		$worksheet->setCellValue('AA1', 'RU_RT,N,9,0');
		$worksheet->setCellValue('AB1', 'RU_PK,N,9,0');
		$worksheet->setCellValue('AC1', 'REJUP2L,N,9,0');
		$worksheet->setCellValue('AD1', 'IPUP2L,N,9,0');
		$worksheet->setCellValue('AE1', 'BAIKUP2L,N,9,0');
		$worksheet->setCellValue('AF1', 'RC_RC,N,9,0');
		$worksheet->setCellValue('AG1', 'RC_DF,N,9,0');
		$worksheet->setCellValue('AH1', 'RC_CR,N,9,0');
		$worksheet->setCellValue('AI1', 'RC_TK,N,9,0');
		$worksheet->setCellValue('AJ1', 'RC_PR,N,9,0');
		$worksheet->setCellValue('AK1', 'RC_KP,N,9,0');
		$worksheet->setCellValue('AL1', 'RC_CT,N,9,0');
		$worksheet->setCellValue('AM1', 'RC_TS,N,9,0');
		$worksheet->setCellValue('AN1', 'RC_CO,N,9,0');
		$worksheet->setCellValue('AO1', 'RC_CW,N,9,0');
		$worksheet->setCellValue('AP1', 'RC_SC,N,9,0');
		$worksheet->setCellValue('AQ1', 'RC_PH,N,9,0');
		$worksheet->setCellValue('AR1', 'RC_SG,N,9,0');
		$worksheet->setCellValue('AS1', 'RC_GS,N,9,0');
		$worksheet->setCellValue('AT1', 'RC_CP,N,9,0');
		$worksheet->setCellValue('AU1', 'RC_TT,N,9,0');
		$worksheet->setCellValue('AV1', 'RC_BC,N,9,0');
		$worksheet->setCellValue('AW1', 'RC_KS,N,9,0');
		$worksheet->setCellValue('AX1', 'RC_NK,N,9,0');
		$worksheet->setCellValue('AY1', 'RC_MS,N,9,0');
		$worksheet->setCellValue('AZ1', 'RC_RT,N,9,0');
		$worksheet->setCellValue('BA1', 'RC_PK,N,9,0');
		$worksheet->setCellValue('BB1', 'REJQC,N,9,0');
		$worksheet->setCellValue('BC1', 'BAIKAKHIR,N,9,0');
		$worksheet->setCellValue('BD1', 'REJECT,N,9,0');
		$worksheet->setCellValue('BE1', 'KET,C,30');
		// $worksheet->setCellValue('BF1', 'KETERANGAN_PENGURANGAN_TARGET');
		// $worksheet->setCellValue('BG1', 'JAM_PENGURANGAN');
		// =================== END OF HEADER & STYLING =================== //

		$highestRow = $worksheet->getHighestRow() + 1;

		// =================== START OF CONTENT & STYLING =================== //
		foreach ($jadi as $akhir) {
			$tgl = explode('-', date('d-m-Y', strtotime($akhir['Tanggal'])));
			$worksheet->setCellValue('A' . $highestRow, PHPExcel_Shared_Date::FormattedPHPToExcel($tgl[2], $tgl[1], $tgl[0]));
			$worksheet->setCellValue('B' . $highestRow, $akhir['KodeKelompok']);
			$worksheet->setCellValue('C' . $highestRow, $akhir['KodeCor']);
			$worksheet->setCellValue('D' . $highestRow, $akhir['KodeKomponen']);
			$worksheet->setCellValue('E' . $highestRow, $akhir['KodeProses']);
			$worksheet->setCellValue('F' . $highestRow, $akhir['HasilCor']);
			$worksheet->setCellValue('G' . $highestRow, (empty($akhir['RC']) ? 0 : $akhir['RC'])); // Tenary Operator
			$worksheet->setCellValue('H' . $highestRow, (empty($akhir['DF']) ? 0 : $akhir['DF'])); // konsepnya jika nilai $akhir['DF'] == kosong
			$worksheet->setCellValue('I' . $highestRow, (empty($akhir['CR']) ? 0 : $akhir['CR'])); // maka nilainya diganti dengan '0'
			$worksheet->setCellValue('J' . $highestRow, (empty($akhir['TK']) ? 0 : $akhir['TK']));
			$worksheet->setCellValue('K' . $highestRow, (empty($akhir['PR']) ? 0 : $akhir['PR']));
			$worksheet->setCellValue('L' . $highestRow, (empty($akhir['KP']) ? 0 : $akhir['KP']));
			$worksheet->setCellValue('M' . $highestRow, (empty($akhir['CT']) ? 0 : $akhir['CT']));
			$worksheet->setCellValue('N' . $highestRow, (empty($akhir['TS']) ? 0 : $akhir['TS']));
			$worksheet->setCellValue('O' . $highestRow, (empty($akhir['CO']) ? 0 : $akhir['CO']));
			$worksheet->setCellValue('P' . $highestRow, (empty($akhir['CW']) ? 0 : $akhir['CW']));
			$worksheet->setCellValue('Q' . $highestRow, (empty($akhir['SC']) ? 0 : $akhir['SC']));
			$worksheet->setCellValue('R' . $highestRow, (empty($akhir['PH']) ? 0 : $akhir['PH']));
			$worksheet->setCellValue('S' . $highestRow, (empty($akhir['SG']) ? 0 : $akhir['SG']));
			$worksheet->setCellValue('T' . $highestRow, (empty($akhir['GS']) ? 0 : $akhir['GS']));
			$worksheet->setCellValue('U' . $highestRow, (empty($akhir['CP']) ? 0 : $akhir['CP']));
			$worksheet->setCellValue('V' . $highestRow, (empty($akhir['TT']) ? 0 : $akhir['TT']));
			$worksheet->setCellValue('W' . $highestRow, (empty($akhir['BC']) ? 0 : $akhir['BC']));
			$worksheet->setCellValue('X' . $highestRow, (empty($akhir['KS']) ? 0 : $akhir['KS']));
			$worksheet->setCellValue('Y' . $highestRow, (empty($akhir['NK']) ? 0 : $akhir['NK']));
			$worksheet->setCellValue('Z' . $highestRow, (empty($akhir['MS']) ? 0 : $akhir['MS']));
			$worksheet->setCellValue('AA' . $highestRow, (empty($akhir['RT']) ? 0 : $akhir['RT']));
			$worksheet->setCellValue('AB' . $highestRow, (empty($akhir['PK']) ? 0 : $akhir['PK']));
			$worksheet->setCellValue('AC' . $highestRow, $akhir['Reject']); //rej up2l
			$worksheet->setCellValue('AD' . $highestRow, $akhir['IP']);
			$worksheet->setCellValue('AE' . $highestRow, $akhir['HasilBaik']);
			$worksheet->setCellValue('AF' . $highestRow, (empty($akhir['RC']) ? 0 : $akhir['RC']));
			$worksheet->setCellValue('AG' . $highestRow, (empty($akhir['DF']) ? 0 : $akhir['DF']));
			$worksheet->setCellValue('AH' . $highestRow, (empty($akhir['CR']) ? 0 : $akhir['CR']));
			$worksheet->setCellValue('AI' . $highestRow, (empty($akhir['TK']) ? 0 : $akhir['TK']));
			$worksheet->setCellValue('AJ' . $highestRow, (empty($akhir['PR']) ? 0 : $akhir['PR']));
			$worksheet->setCellValue('AK' . $highestRow, (empty($akhir['KP']) ? 0 : $akhir['KP']));
			$worksheet->setCellValue('AL' . $highestRow, (empty($akhir['CT']) ? 0 : $akhir['CT']));
			$worksheet->setCellValue('AM' . $highestRow, (empty($akhir['TS']) ? 0 : $akhir['TS']));
			$worksheet->setCellValue('AN' . $highestRow, (empty($akhir['CO']) ? 0 : $akhir['CO']));
			$worksheet->setCellValue('AO' . $highestRow, (empty($akhir['CW']) ? 0 : $akhir['CW']));
			$worksheet->setCellValue('AP' . $highestRow, (empty($akhir['SC']) ? 0 : $akhir['SC']));
			$worksheet->setCellValue('AQ' . $highestRow, (empty($akhir['PH']) ? 0 : $akhir['PH']));
			$worksheet->setCellValue('AR' . $highestRow, (empty($akhir['SG']) ? 0 : $akhir['SG']));
			$worksheet->setCellValue('AS' . $highestRow, (empty($akhir['GS']) ? 0 : $akhir['GS']));
			$worksheet->setCellValue('AT' . $highestRow, (empty($akhir['CP']) ? 0 : $akhir['CP']));
			$worksheet->setCellValue('AU' . $highestRow, (empty($akhir['TT']) ? 0 : $akhir['TT']));
			$worksheet->setCellValue('AV' . $highestRow, (empty($akhir['BC']) ? 0 : $akhir['BC']));
			$worksheet->setCellValue('AW' . $highestRow, (empty($akhir['KS']) ? 0 : $akhir['KS']));
			$worksheet->setCellValue('AX' . $highestRow, (empty($akhir['NK']) ? 0 : $akhir['NK']));
			$worksheet->setCellValue('AY' . $highestRow, (empty($akhir['MS']) ? 0 : $akhir['MS']));
			$worksheet->setCellValue('AZ' . $highestRow, (empty($akhir['RT']) ? 0 : $akhir['RT']));
			$worksheet->setCellValue('BA' . $highestRow, (empty($akhir['PK']) ? 0 : $akhir['PK']));
			$worksheet->setCellValue('BB' . $highestRow, $akhir['Rej']); //rejqc (scrap)
			$worksheet->setCellValue('BC' . $highestRow, $akhir['HasilBaik']);
			$worksheet->setCellValue('BD' . $highestRow, $akhir['Reject']); //reject (scrap)
			$worksheet->setCellValue('BE' . $highestRow, $akhir['ket_pengurangan'].' ('.$akhir['jam_pengurangan'].')');
			// $worksheet->setCellValue('BE' . $highestRow, $akhir['Keterangan']);
			// $worksheet->setCellValue('BF' . $highestRow, $akhir['ket_pengurangan']);
			// $worksheet->setCellValue('BG' . $highestRow, $akhir['jam_pengurangan']);
			$highestRow++;
		}
		// =================== END OF CONTENT & STYLING =================== //

		$worksheet->setTitle('Monthly_Planning');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="DET_TRAN.DBF"');
		$objWriter->save("php://output");
	}

	public function createLaporan4() // BPKEKAT
	{
		
		$tanggal1 = $this->input->post('tanggal_awal');
		$tanggal2 = $this->input->post('tanggal_akhir');

		// =================== START OF AMBIL DATA & DEKLARASI ARRAY =================== //
		$vMould = $this->M_glap->vMoulding($tanggal1, $tanggal2);
		$vMixing = $this->M_glap->vMixing($tanggal1, $tanggal2);
		$vCore = $this->M_glap->vCore($tanggal1, $tanggal2);
		$vOTT = $this->M_glap->vOTT($tanggal1, $tanggal2);
		
		$jadi = array();
		$o = 0;
		foreach ($vMould as $vol) {
			$kodeProses = $this->M_glap->getMasterItem($vol['component_code']);
			$jadi[$o]['jenis'] = 'Moulding';
			$jadi[$o]['id'] = $vol['moulding_id'];
			$jadi[$o]['Tanggal'] = $vol['production_date'];
			$jadi[$o]['KodeKelompok'] = $vol['kode'];
			$jadi[$o]['KodeCor'] = $vol['print_code'];
			$jadi[$o]['KodeKomponen'] = $vol['component_code'];
			$jadi[$o]['KodeProses'] = (empty($vol['kode_proses']) ? $kodeProses[0]['kode_proses'] : $vol['kode_proses']);
			$jadi[$o]['HasilCor'] = $vol['moulding_quantity'];
			$jadi[$o]['HasilBaik'] = $vol['bongkar_qty'] - $vol['scrap_qty'];
			$jadi[$o]['Rmurnic'] = 0;
			$jadi[$o]['Rbebdc'] = 0;
			$jadi[$o]['Rintc'] = 0;
			$jadi[$o]['Rmurnit'] = 0;
			$jadi[$o]['Rbebdt'] = 0;
			$jadi[$o]['Rintt'] = 0;
			$jadi[$o]['Rmurnif'] = 0;
			$jadi[$o]['Rbebdf'] = 0;
			$jadi[$o]['Rintf'] = 0;
			$jadi[$o]['Rejc25'] = (empty($vol['scrap_qty']) ? '0' : $vol['scrap_qty']);
			$jadi[$o]['Rejt25'] = (empty($vol['scrap_qty']) ? '0' : $vol['scrap_qty']);
			$jadi[$o]['ket_pengurangan'] = $vol['ket_pengurangan'];
			$jadi[$o]['jam_pengurangan'] = $vol['jam_pengurangan'];
			$o++;
		}
	
		foreach ($vMixing as $vol) {
			$kodeProses = $this->M_glap->getMasterItem($vol['component_code']);
			$jadi[$o]['jenis'] = 'Mixing';
			$jadi[$o]['id'] = $vol['mixing_id'];
			$jadi[$o]['Tanggal'] = $vol['production_date'];
			$jadi[$o]['KodeKelompok'] = $vol['kode'];
			$jadi[$o]['KodeCor'] = $vol['print_code'];
			$jadi[$o]['KodeKomponen'] = $vol['component_code'];
			$jadi[$o]['KodeProses'] = (empty($vol['kode_proses']) ? $kodeProses[0]['kode_proses'] : $vol['kode_proses']);
			$jadi[$o]['HasilCor'] = $vol['mixing_quantity'];
			$jadi[$o]['HasilBaik'] = $vol['mixing_quantity'];
			$jadi[$o]['Rmurnic'] = 0;
			$jadi[$o]['Rbebdc'] = 0;
			$jadi[$o]['Rintc'] = 0;
			$jadi[$o]['Rmurnit'] = 0;
			$jadi[$o]['Rbebdt'] = 0;
			$jadi[$o]['Rintt'] = 0;
			$jadi[$o]['Rmurnif'] = 0;
			$jadi[$o]['Rbebdf'] = 0;
			$jadi[$o]['Rintf'] = 0;
			$jadi[$o]['Rejc25'] = 0;
			$jadi[$o]['Rejt25'] = 0;
			$o++;
		}
		
		foreach ($vCore as $vol) {
			$kodeProses = $this->M_glap->getMasterItem($vol['component_code']);
			$jadi[$o]['jenis'] = 'Core';
			$jadi[$o]['id'] = $vol['core_id'];
			$jadi[$o]['Tanggal'] = $vol['production_date'];
			$jadi[$o]['KodeKelompok'] = $vol['kode'];
			$jadi[$o]['KodeCor'] = $vol['print_code'];
			$jadi[$o]['KodeKomponen'] = $vol['component_code'];
			$jadi[$o]['KodeProses'] = (empty($vol['kode_proses']) ? $kodeProses[0]['kode_proses'] : $vol['kode_proses']);
			$jadi[$o]['HasilCor'] = $vol['core_quantity'];
			$jadi[$o]['HasilBaik'] = $vol['core_quantity'];
			$jadi[$o]['Rmurnic'] = 0;
			$jadi[$o]['Rbebdc'] = 0;
			$jadi[$o]['Rintc'] = 0;
			$jadi[$o]['Rmurnit'] = 0;
			$jadi[$o]['Rbebdt'] = 0;
			$jadi[$o]['Rintt'] = 0;
			$jadi[$o]['Rmurnif'] = 0;
			$jadi[$o]['Rbebdf'] = 0;
			$jadi[$o]['Rintf'] = 0;
			$jadi[$o]['Rejc25'] = 0;
			$jadi[$o]['Rejt25'] = 0;
			$o++;
		}

		foreach ($vOTT as $vol) {
			$jadi[$o]['jenis'] = 'OTT';
			$jadi[$o]['id'] = $vol['id'];
			$jadi[$o]['Tanggal'] = $vol['otttgl'];
			$jadi[$o]['KodeKelompok'] = $vol['kode'];
			$jadi[$o]['KodeCor'] = $vol['kode_cor'];
			$jadi[$o]['KodeKomponen'] = 'OTT';
			$jadi[$o]['KodeProses'] = '';
			$jadi[$o]['HasilCor'] = '';
			$jadi[$o]['HasilBaik'] = '';
			$jadi[$o]['Rmurnic'] = 0;
			$jadi[$o]['Rbebdc'] = 0;
			$jadi[$o]['Rintc'] = 0;
			$jadi[$o]['Rmurnit'] = 0;
			$jadi[$o]['Rbebdt'] = 0;
			$jadi[$o]['Rintt'] = 0;
			$jadi[$o]['Rmurnif'] = 0;
			$jadi[$o]['Rbebdf'] = 0;
			$jadi[$o]['Rintf'] = 0;
			$jadi[$o]['Rejc25'] = 0;
			$jadi[$o]['Rejt25'] = 0;
			$o++;
		}
	
		array_multisort(array_column($jadi, 'Tanggal'), SORT_ASC,
						array_column($jadi, 'KodeKelompok'),     SORT_ASC ,
						$jadi);
		// =================== END OF AMBIL DATA & DEKLARASI ARRAY =================== //

		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

		$worksheet->getColumnDimension('A')->setWidth(15);
		$worksheet->getColumnDimension('B')->setWidth(17);
		$worksheet->getColumnDimension('C')->setWidth(12);
		$worksheet->getColumnDimension('D')->setWidth(18);
		$worksheet->getColumnDimension('E')->setWidth(15);
		for( $x = "F"; ; $x++) {
			$worksheet->getColumnDimension($x)->setWidth(12);
			if( $x == "R") break;
		}

		$worksheet->setCellValue('A1', 'TGL,D');
		$worksheet->setCellValue('B1', 'KODEKLP,C,1');
		$worksheet->setCellValue('C1', 'KODECOR,C,10');
		$worksheet->setCellValue('D1', 'KODE_KOM,C,20');
		$worksheet->setCellValue('E1', 'KODEPRO,C,9');
		$worksheet->setCellValue('F1', 'HSL_COR,N,9,0');
		$worksheet->setCellValue('G1', 'BAIK,N,9,0');
		$worksheet->setCellValue('H1', 'RMURNIC,N,9,0');
		$worksheet->setCellValue('I1', 'RBEBDC,N,9,0');
		$worksheet->setCellValue('J1', 'RINTC,N,9,0');
		$worksheet->setCellValue('K1', 'RMURNIT,N,9,0');
		$worksheet->setCellValue('L1', 'RBEBDT,N,9,0');
		$worksheet->setCellValue('M1', 'RINTT,N,9,0');
		$worksheet->setCellValue('N1', 'RMURNIF,N,9,0');
		$worksheet->setCellValue('O1', 'RBEBDF,N,9,0');
		$worksheet->setCellValue('P1', 'RINTF,N,9,0');
		$worksheet->setCellValue('Q1', 'REJC25,N,9,0');
		$worksheet->setCellValue('R1', 'REJT25,N,9,0');
		// $worksheet->setCellValue('S1', 'KETERANGAN');
		// $worksheet->setCellValue('T1', 'JAM_PENGURANGAN');

		$highestRow = $worksheet->getHighestRow() + 1;

		// =================== START OF CONTENT & STYLING =================== //
		foreach ($jadi as $akhir) {
			$tgl = explode('-', date('d-m-Y', strtotime($akhir['Tanggal'])));
			$worksheet->setCellValue('A' . $highestRow, PHPExcel_Shared_Date::FormattedPHPToExcel($tgl[2], $tgl[1], $tgl[0]));
			$worksheet->setCellValue('B' . $highestRow, $akhir['KodeKelompok']);
			$worksheet->setCellValue('C' . $highestRow, $akhir['KodeCor']);
			$worksheet->setCellValue('D' . $highestRow, $akhir['KodeKomponen']);
			$worksheet->setCellValue('E' . $highestRow, $akhir['KodeProses']); 
			$worksheet->setCellValue('F' . $highestRow, $akhir['HasilCor']); 
			$worksheet->setCellValue('G' . $highestRow, $akhir['HasilBaik']); 
			$worksheet->setCellValue('H' . $highestRow, $akhir['Rmurnic']);
			$worksheet->setCellValue('I' . $highestRow, $akhir['Rbebdc']);
			$worksheet->setCellValue('J' . $highestRow, $akhir['Rintc']);
			$worksheet->setCellValue('K' . $highestRow, $akhir['Rmurnit']);
			$worksheet->setCellValue('L' . $highestRow, $akhir['Rbebdt']);
			$worksheet->setCellValue('M' . $highestRow, $akhir['Rintt']);
			$worksheet->setCellValue('N' . $highestRow, $akhir['Rmurnif']);
			$worksheet->setCellValue('O' . $highestRow, $akhir['Rbebdf']);
			$worksheet->setCellValue('P' . $highestRow, $akhir['Rintf']);
			$worksheet->setCellValue('Q' . $highestRow, $akhir['Rejc25']);
			$worksheet->setCellValue('R' . $highestRow, $akhir['Rejt25']);
			// $worksheet->setCellValue('S' . $highestRow, $akhir['ket_pengurangan'].' ('.$akhir['jam_pengurangan'].')');
			// $worksheet->setCellValue('T' . $highestRow, $akhir['jam_pengurangan']);
			$highestRow++;
		}
		// =================== END OF CONTENT & STYLING =================== //

		$worksheet->setTitle('Monthly_Planning');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="BPKEAKT.DBF"');
		$objWriter->save("php://output");
	}

	public function createLaporan5() // IND_TRAN
	{
		$tanggal1 = $this->input->post('tanggal_awal');
		$tanggal2 = $this->input->post('tanggal_akhir');

		$section = $this->M_glap->getAbsensi($tanggal1, $tanggal2);

		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

		$worksheet->getColumnDimension('A')->setWidth(15);
		$worksheet->getColumnDimension('B')->setWidth(10);
		$worksheet->getColumnDimension('C')->setWidth(20);
		$worksheet->getColumnDimension('D')->setWidth(15);
		$worksheet->getColumnDimension('E')->setWidth(10);
		$worksheet->getColumnDimension('F')->setWidth(10);
		$worksheet->getColumnDimension('I')->setWidth(10);

		$worksheet->setCellValue('A1', 'TGL,D');
		$worksheet->setCellValue('B1', 'NOIND,C,5');
		$worksheet->setCellValue('C1', 'KODEKLP,C,1');
		$worksheet->setCellValue('D1', 'KODECOR,C,5');
		$worksheet->setCellValue('E1', 'PRESENSI,C,5');
		$worksheet->setCellValue('F1', 'PRODUKSI,C,1');
		$worksheet->setCellValue('G1', 'NIL_OTT,N,5,0');
		$worksheet->setCellValue('H1', 'WH,N,5,0');
		$worksheet->setCellValue('I1', 'LEMBUR,L');

		$highestRow = $worksheet->getHighestRow() + 1;
		
		foreach ($section as $sc) {
			$xTgl = explode('-', $sc['created_date']);

			if ($xTgl[2] < 10) $xTgl[2] = substr($xTgl[2], 1, 1);

			switch ($xTgl[1]) {
				case '01': $kodecor = $xTgl[2].'A'; break;
				case '02': $kodecor = $xTgl[2].'B'; break;
				case '03': $kodecor = $xTgl[2].'C'; break;
				case '04': $kodecor = $xTgl[2].'D'; break;
				case '05': $kodecor = $xTgl[2].'E'; break;
				case '06': $kodecor = $xTgl[2].'F'; break;
				case '07': $kodecor = $xTgl[2].'G'; break;
				case '08': $kodecor = $xTgl[2].'H'; break;
				case '09': $kodecor = $xTgl[2].'J'; break;
				case '10': $kodecor = $xTgl[2].'K'; break;
				case '11': $kodecor = $xTgl[2].'L'; break;
				case '12': $kodecor = $xTgl[2].'M'; break;
				default: break;
			}
			
			switch (substr($xTgl[0], 3, 1)) {
				case '0': $kodecor .= 'N '; break;
				case '1': $kodecor .= 'P '; break;
				case '2': $kodecor .= 'Q '; break;
				case '3': $kodecor .= 'R '; break;
				case '4': $kodecor .= 'S '; break;
				case '5': $kodecor .= 'U '; break;
				case '6': $kodecor .= 'V '; break;
				case '7': $kodecor .= 'W '; break;
				case '8': $kodecor .= 'Y '; break;
				case '9': $kodecor .= 'Z '; break;
				default: break;
			}
			$lembur = '';
			$produksi = '';
			if(empty($sc['kode'])) $kodecor = '';
			if ($sc['lembur'] == 'f') $lembur = 'SALAH'; else $lembur = 'BENAR';
			if ($sc['produksi'] == 'T') $produksi = 'N'; else $produksi = 'Y';
			

			$tgl = explode('-', date('d-m-Y', strtotime($sc['created_date'])));

			$all = explode(',', $sc['no_induk']);
			foreach ($all as $no_ind) {
				$worksheet->setCellValue('A' . $highestRow, PHPExcel_Shared_Date::FormattedPHPToExcel($tgl[2], $tgl[1], $tgl[0]));
				$worksheet->setCellValue('B' . $highestRow, $no_ind);
				$worksheet->setCellValue('C' . $highestRow, $sc['kode']);
				$worksheet->setCellValue('D' . $highestRow, $kodecor);
				$worksheet->setCellValue('E' . $highestRow, $sc['presensi']);
				$worksheet->setCellValue('F' . $highestRow, $produksi);
				$worksheet->setCellValue('G' . $highestRow, $sc['nilai_ott']);
				$worksheet->setCellValue('H' . $highestRow, '');//WH
				$worksheet->setCellValue('I' . $highestRow, $lembur);
				$highestRow++;
			}
		}

		$worksheet->setTitle('Monthly_Planning');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="IND_TRAN.DBF"');
		$objWriter->save("php://output");
	}

	public function createLaporan6() // XFIN
	{
		$user_id = $this->session->userid;

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("ICT");
		$objPHPExcel->getProperties()->setTitle("XFIN");
		$objPHPExcel->setActiveSheetIndex(0);
		$objset = $objPHPExcel->getActiveSheet();

		$objset->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objset->getPageSetup()->setFitToWidth(1);

		//BETWEEN
		$txtStartDate = $this->input->post('tanggal_awal');
		$txtEndDate = $this->input->post('tanggal_akhir');
		$selepdate = $this->M_selep->getSelepDate($txtStartDate, $txtEndDate);
		
		//false
		$f = false;

		//TH KOLOM
		$cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X");
		$val = array(
			"TGL,D", "SHIFT,C,1", "KELOMPOK,C,5", "KODECOR,C,5", "KODEBRG,C,20", "NAMABRG,C,40", "KODEPRO,C,9", "JUMLAH,N,9,0", "BAIK,N,9,0", "REPAIR,N,9,0",
			"REJECT,N,9,0", "KETERANGAN,C,30", "RGER_RT,N,9,0", "RGER_PH,N,9,0", "RGER_CW,N,9,0", "RINT_RT,N,9,0", "RINT_PH,N,9,0", "RINT_CW,N,9,0", "CASTING,N,9,0",
			"NOBP,C,9", "TGLBP,D", "CETAKBP,L", "NOBP_GB,C,9", "CETAKBP_GB,L"
		);

		for ($a = 0; $a < 24; $a++) {
			$objset->setCellValue($cols[$a] . '1', $val[$a]);
			$objset->getColumnDimension('A')->setWidth(13); //TGL
			$objset->getColumnDimension('B')->setWidth(15); //SHIFT
			$objset->getColumnDimension('C')->setWidth(25); //KELOMPOK
			$objset->getColumnDimension('D')->setWidth(10); //KODECOR
			$objset->getColumnDimension('E')->setWidth(25); //KODEBRG
			$objset->getColumnDimension('F')->setWidth(30); //NAMABRG
			for( $x = "G"; ; $x++) {
				$objset->getColumnDimension($x)->setWidth(10);
				if( $x == "W") break;
			}
			$objset->getColumnDimension('U')->setWidth(13); //TGLBP
			$objset->getColumnDimension('V')->setWidth(10); //CETAKBP
			$objset->getColumnDimension('W')->setWidth(10); //NOBP_GB
			$objset->getColumnDimension('X')->setWidth(14); //CETAKBP_GB
		}
		$baris  = 2;
		//KODE BARANG
		$monthCode = array(
			array('month' => 1, 'code' => 'A'),
			array('month' => 2, 'code' => 'B'),
			array('month' => 3, 'code' => 'C'),
			array('month' => 4, 'code' => 'D'),
			array('month' => 5, 'code' => 'E'),
			array('month' => 6, 'code' => 'F'),
			array('month' => 7, 'code' => 'G'),
			array('month' => 8, 'code' => 'H'),
			array('month' => 9, 'code' => 'J'),
			array('month' => 10, 'code' => 'K'),
			array('month' => 11, 'code' => 'L'),
			array('month' => 12, 'code' => 'M')
		);
		$yearCode = array(
			array('year' => 0, 'code' => 'N'),
			array('year' => 1, 'code' => 'P'),
			array('year' => 2, 'code' => 'Q'),
			array('year' => 3, 'code' => 'R'),
			array('year' => 4, 'code' => 'S'),
			array('year' => 5, 'code' => 'U'),
			array('year' => 6, 'code' => 'V'),
			array('year' => 7, 'code' => 'W'),
			array('year' => 8, 'code' => 'Y'),
			array('year' => 9, 'code' => 'Z'),
		);

		foreach ($selepdate as $sd) {
			$baik = $sd['qc_qty_ok'];
			$origDate = $sd['selep_date'];
			$newDate = date("d-m-Y", strtotime($origDate));
			$brg = (explode("|", $sd['component_code']));

			$val = explode('-', $newDate);
			
			//PISAH
			foreach ($monthCode as $value) {
				if ($val[1] == $value['month']) {
					$bulan = $value['code'];
				}
			}
			
			foreach ($yearCode as $v) {
				if (substr($val[2], -1) == $v['year']) {
					$tahun = $v['code'];
				}
			}

			//ISI
			$tgl = explode('-', date('d-m-Y', strtotime($newDate)));
			$kode_barang = $this->M_selep->getKodeProses($brg[0]);
			$tglBp = date('d-m-Y', strtotime($newDate. ' + 3 days'));		
			$tglu = explode('-', $tglBp);
			
			$sPekerja = explode(',', $sd['job_id']);
			for ($p=0; $p < count($sPekerja); $p++) { 
				$objset->setCellValue('A' . $baris, PHPExcel_Shared_Date::FormattedPHPToExcel($tgl[2], $tgl[1], $tgl[0])); //tgl
				$objset->setCellValue('B' . $baris, substr($sd['shift'], 6, 1)); //SHIFT
				$objset->setCellValue('C' . $baris, $sPekerja[$p]); //KELOMPOK
				$objset->setCellValue('D' . $baris, $bulan . '' . $tahun); //KODECOR
				$objset->setCellValue('E' . $baris, $brg[0]); //KODEBRG
				$objset->setCellValue('F' . $baris, $sd['component_description']); //NAMABRG
				foreach ($kode_barang as $codebrg) {
					$kod = (empty($sd['kode_proses']) ? $codebrg['kode_proses'] : $sd['kode_proses']);
					$objset->setCellValue('G' . $baris, $kod); //KODEPRO
				}
				$objset->setCellValue('H' . $baris, $sd['selep_quantity']); //JML
				$objset->setCellValue('I' . $baris, $baik); //BAIK
				$objset->setCellValue('J' . $baris, $sd['repair_qty']); //REPAIR
				$objset->setCellValue('K' . $baris, $sd['qc_qty_not_ok']); //REJECT
				$objset->setCellValue('L' . $baris, $sd['keterangan']); //KETERANGAN
				$objset->setCellValue('M' . $baris, "0"); //RGER_RT
				$objset->setCellValue('N' . $baris, "0"); //RGER_PH
				$objset->setCellValue('O' . $baris, "0"); //RGER_CW
				$objset->setCellValue('P' . $baris, "0"); //RINT_RT
				$objset->setCellValue('Q' . $baris, "0"); //RINT_PH
				$objset->setCellValue('R' . $baris, "0"); //RINT_CW
				$objset->setCellValue('S' . $baris, "0"); //CASTING
				$objset->setCellValue('T' . $baris, "0"); //NOBP
				$objset->setCellValue('U' . $baris, PHPExcel_Shared_Date::FormattedPHPToExcel($tglu[2], $tglu[1], $tglu[0])); //tgl bp
				$objset->setCellValue('V' . $baris, $f); //CETAKBP
				$objset->setCellValue('W' . $baris, ""); //NOBP_GB
				$objset->setCellValue('X' . $baris, $f); //CETAKBP_GB
				$baris++;
			}
		}
		$filename = "XFIN.DBF";

		header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
}
