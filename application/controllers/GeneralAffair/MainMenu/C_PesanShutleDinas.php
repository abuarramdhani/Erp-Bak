<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_PesanShutleDinas extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('GeneralAffair/MainMenu/M_pesanshutledinas');
		$this->load->model('GeneralAffair/MainMenu/M_location');

		$this->checkSession();
		ini_set('date.timezone', 'Asia/Jakarta');
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

    public function filter_map($data) {
        echo $data;die;
        foreach ($data as $key) {
            return !empty($key);
        }
    }
	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Pemesanan Shuttle Dinas';
		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = 'Pemesanan Shuttle Dinas';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$datamenu1 = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);

		$location = $this->M_location->getlocation($user_id);
		$lokasi = $location['0']['location_code'];
		$i = 0;
		if ($lokasi == '01') {
			foreach ($datamenu1 as $key) {
				$data['UserSubMenuOne'][$i] = array(
					'user_id' => $key['user_id'],
					'user_group_menu_name' => $key['user_group_menu_name'],
					'user_group_menu_id' => $key['user_group_menu_id'],
					'group_menu_list_id' => $key['group_menu_list_id'],
					'menu_sequence' => $key['menu_sequence'],
					'menu_id' => $key['menu_id'],
					'root_id' => $key['root_id'],
					'menu_title' => $key['menu_title'],
					'menu' => $key['menu'],
					'menu_link' => $key['menu_link'],
					'org_id' => $key['org_id'],
				);
				$i++;
			}
		}else{
			foreach ($datamenu1 as $key) {
				if ($key['menu_id'] !== '289' && $key['menu_id'] !== '290' && $key['menu_id'] !== '291' && $key['menu_id'] !== '296' && $key['menu_id'] !== '478') {
					$data['UserSubMenuOne'][$i] = array(
						'user_id' => $key['user_id'],
						'user_group_menu_name' => $key['user_group_menu_name'],
						'user_group_menu_id' => $key['user_group_menu_id'],
						'group_menu_list_id' => $key['group_menu_list_id'],
						'menu_sequence' => $key['menu_sequence'],
						'menu_id' => $key['menu_id'],
						'root_id' => $key['root_id'],
						'menu_title' => $key['menu_title'],
						'menu' => $key['menu'],
						'menu_link' => $key['menu_link'],
						'org_id' => $key['org_id'],
					);
					$i++;
				}
			}
		}

		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['data89'] = $this->M_pesanshutledinas->get89(date('Y-m-d'));
        $data['data910'] = $this->M_pesanshutledinas->get910(date('Y-m-d'));
        $data['data913'] = $this->M_pesanshutledinas->get913(date('Y-m-d'));
        $data['data900'] = $this->M_pesanshutledinas->get900(date('Y-m-d'));
        $data['data811'] = $this->M_pesanshutledinas->get811(date('Y-m-d'));
        $data['data1011'] = $this->M_pesanshutledinas->get1011(date('Y-m-d'));
        $data['data1113'] = $this->M_pesanshutledinas->get1113(date('Y-m-d'));
        $data['data1100'] = $this->M_pesanshutledinas->get1100(date('Y-m-d'));
        $data['data814'] = $this->M_pesanshutledinas->get814(date('Y-m-d'));
        $data['data1014'] = $this->M_pesanshutledinas->get1014(date('Y-m-d'));
        $data['data1314'] = $this->M_pesanshutledinas->get1314(date('Y-m-d'));
        $data['data1400'] = $this->M_pesanshutledinas->get1400(date('Y-m-d'));
        $data['data8'] = $this->M_pesanshutledinas->get8(date('Y-m-d'));
        $data['data10'] = $this->M_pesanshutledinas->get10(date('Y-m-d'));
        $data['data13'] = $this->M_pesanshutledinas->get13(date('Y-m-d'));

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/PesanShutleDinas/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function find()
	{
		$wkt = $this->input->post('param');
		$waktu = date('Y-m-d', strtotime($wkt));

		$data['waktu'] = date('d F Y', strtotime($wkt));
		$data['data89'] = $this->M_pesanshutledinas->get89($waktu);
        $data['data910'] = $this->M_pesanshutledinas->get910($waktu);
        $data['data913'] = $this->M_pesanshutledinas->get913($waktu);
        $data['data900'] = $this->M_pesanshutledinas->get900($waktu);
        $data['data811'] = $this->M_pesanshutledinas->get811($waktu);
        $data['data1011'] = $this->M_pesanshutledinas->get1011($waktu);
        $data['data1113'] = $this->M_pesanshutledinas->get1113($waktu);
        $data['data1100'] = $this->M_pesanshutledinas->get1100($waktu);
        $data['data814'] = $this->M_pesanshutledinas->get814($waktu);
        $data['data1014'] = $this->M_pesanshutledinas->get1014($waktu);
        $data['data1314'] = $this->M_pesanshutledinas->get1314($waktu);
        $data['data1400'] = $this->M_pesanshutledinas->get1400($waktu);
        $data['data8'] = $this->M_pesanshutledinas->get8($waktu);
        $data['data10'] = $this->M_pesanshutledinas->get10($waktu);
        $data['data13'] = $this->M_pesanshutledinas->get13($waktu);

		$view = $this->load->view('GeneralAffair/PesanShutleDinas/V_find', $data);
		echo json_encode($view);

	}

	public function ExportPDF()
	{
		$user = $this->session->user;
		$nama_user = $this->M_pesanshutledinas->getUser($user);
		$wkt = $this->input->post('tgl_pesan');
		$jenis = $this->input->post('GA_btn_shutle');
		$waktu = date('Y-m-d', strtotime($wkt));

		$data['data89'] = $this->M_pesanshutledinas->get89($waktu);
        $data['data910'] = $this->M_pesanshutledinas->get910($waktu);
        $data['data913'] = $this->M_pesanshutledinas->get913($waktu);
        $data['data900'] = $this->M_pesanshutledinas->get900($waktu);
        $data['data811'] = $this->M_pesanshutledinas->get811($waktu);
        $data['data1011'] = $this->M_pesanshutledinas->get1011($waktu);
        $data['data1113'] = $this->M_pesanshutledinas->get1113($waktu);
        $data['data1100'] = $this->M_pesanshutledinas->get1100($waktu);
        $data['data814'] = $this->M_pesanshutledinas->get814($waktu);
        $data['data1014'] = $this->M_pesanshutledinas->get1014($waktu);
        $data['data1314'] = $this->M_pesanshutledinas->get1314($waktu);
        $data['data1400'] = $this->M_pesanshutledinas->get1400($waktu);
        $data['data8'] = $this->M_pesanshutledinas->get8($waktu);
        $data['data10'] = $this->M_pesanshutledinas->get10($waktu);
        $data['data13'] = $this->M_pesanshutledinas->get13($waktu);

		if ($jenis == '1') {
			$this->load->library('pdf');
			$mpdf = $this->pdf->load();
			$pdf = new mPDF('utf-8','A4-L', 8, 5, 10, 10, 30, 15, 8, 20);
			$filename = 'Pemesanan Shuttle Dinas'.date('Y-m-d').'.pdf';

			$html = $this->load->view('GeneralAffair/PesanShutleDinas/V_PDF',$data,true);
			$pdf->setHTMLHeader('
			<table width="100%">
			<tr>
			<td width="50%"><h2><b>Rekap Pemesanan Shuttle Dinas Perusahaan</b></h2></td>
			<td><h4>Dicetak Oleh '.$nama_user.' pada Tanggal '.date('d F Y H:i:s').'</h4></td>
			</tr>
			</table>
			');

			$pdf->WriteHTML($html, 2);
			$pdf->setTitle($filename);
			$pdf->Output($filename, 'I');
		}elseif ($jenis == '2') {
			$this->load->library("Excel");
			$objPHPExcel = new PHPExcel();

			$objPHPExcel->getProperties()->setCreator('KHS ERP')
			->setTitle("REKAP PEMESANAN SHUTTLE DINAS")
			->setSubject("REKAP SHUTTLE DINAS $waktu")
			->setDescription("Rekap Pemesanan Shuttle Dinas")
			->setKeywords("Shuttle");

			$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => '94cfff')
			        )
			    )
			);
			$objPHPExcel->getActiveSheet()->getStyle('A3:A6')->applyFromArray(
			    array(
			        'fill' => array(
			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' => '94cfff')
			        )
			    )
			);
			$style = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        )
		    );

		    $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->mergeCells('A1:B2');
			$objPHPExcel->getActiveSheet()->mergeCells('C1:F1');
			$objPHPExcel->getActiveSheet()->mergeCells('A3:A6');
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(TRUE);
			$objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(TRUE);
			$objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(TRUE);
			$objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(TRUE);
			$objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setWrapText(TRUE);
			$objPHPExcel->getActiveSheet()->getStyle('A2:A6')->getFont()->setBold(TRUE);
			$objPHPExcel->getActiveSheet()->getStyle('C1', 'A3')->getFont()->setBold(TRUE);
			$objPHPExcel->getActiveSheet()->getStyle('C2:F2')->getFont()->setBold(TRUE);
			$objPHPExcel->getActiveSheet()->getStyle('B3:B6')->getFont()->setBold(TRUE);
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth('2');
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth('30');
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth('30');
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth('30');
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth('30');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "PUSAT");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "TUKSONO");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "08:00");//Set Pusat
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', "10:00");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', "13:00");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', "-");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "09:00");//Set Tuksono
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "11:00");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B5', "14:00");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B6', "-");

			if (!empty($data['data89'])) {
				$a = '';
				foreach ($data['data89'] as $key) {
					$a .= $key['pekerja'];
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', str_replace('<br>', ' ,  ', $a));
			}else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "-");
			}
			if (!empty($data['data910'])) {
				$a = '';
				foreach ($data['data910'] as $key) {
					$a .= $key['pekerja'];
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', str_replace('<br>', ' ,  ', $a));
			}else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "-");
			}
			if (!empty($data['data913'])) {
				$a = '';
				foreach ($data['data913'] as $key) {
					$a .= $key['pekerja'];
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', str_replace('<br>', ' ,  ', $a));
			}else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "-");
			}
			if (!empty($data['data900'])) {
				$a = '';
				foreach ($data['data900'] as $key) {
					$a .= $key['pekerja'];
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', str_replace('<br>', ' ,  ', $a));
			}else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "-");
			}
			if (!empty($data['data811'])) {
				$a = '';
				foreach ($data['data811'] as $key) {
					$a .= $key['pekerja'];
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', str_replace('<br>', ' ,  ', $a));
			}else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "-");
			}
			if (!empty($data['data1011'])) {
				$a = '';
				foreach ($data['data1011'] as $key) {
					$a .= $key['pekerja'];
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', str_replace('<br>', ' ,  ', $a));
			}else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "-");
			}
			if (!empty($data['data1113'])) {
				$a = '';
				foreach ($data['data1113'] as $key) {
					$a .= $key['pekerja'];
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', str_replace('<br>', ' ,  ', $a));
			}else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "-");
			}
			if (!empty($data['data1100'])) {
				$a = '';
				foreach ($data['data1100'] as $key) {
					$a .= $key['pekerja'];
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', str_replace('<br>', ' ,  ', $a));
			}else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "-");
			}
			if (!empty($data['data814'])) {
				$a = '';
				foreach ($data['data814'] as $key) {
					$a .= $key['pekerja'];
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C5', str_replace('<br>', ' ,  ', $a));
			}else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C5', "-");
			}
			if (!empty($data['data1014'])) {
				$a = '';
				foreach ($data['data1014'] as $key) {
					$a .= $key['pekerja'];
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D5', str_replace('<br>', ' ,  ', $a));
			}else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D5', "-");
			}
			if (!empty($data['data1314'])) {
				$a = '';
				foreach ($data['data1314'] as $key) {
					$a .= $key['pekerja'];
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E5', str_replace('<br>', ' ,  ', $a));
			}else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E5', "-");
			}
			if (!empty($data['data1400'])) {
				$a = '';
				foreach ($data['data1400'] as $key) {
					$a .= $key['pekerja'];
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F5', str_replace('<br>', ' ,  ', $a));
			}else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F5', "-");
			}
			if (!empty($data['data8'])) {
				$a = '';
				foreach ($data['data8'] as $key) {
					$a .= $key['pekerja'];
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C6', str_replace('<br>', ' ,  ', $a));
			}else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C6', "-");
			}
			if (!empty($data['data10'])) {
				$a = '';
				foreach ($data['data10'] as $key) {
					$a .= $key['pekerja'];
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D6', str_replace('<br>', ' ,  ', $a));
			}else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D6', "-");
			}
			if (!empty($data['data13'])) {
				$a = '';
				foreach ($data['data13'] as $key) {
					$a .= $key['pekerja'];
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E6', str_replace('<br>', ' ,  ', $a));
			}else {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E6', "-");
			}
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F6', "-");

			$objPHPExcel->getActiveSheet()->setTitle('Pemesanan Shuttle Dinas');

			$objPHPExcel->setActiveSheetIndex(0);
			$filename = urlencode("RekapShuttleDinas_".$waktu.".ods");

			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}

	}
}
