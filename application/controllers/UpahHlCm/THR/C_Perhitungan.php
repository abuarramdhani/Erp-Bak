<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
date_default_timezone_set('Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_Perhitungan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('UpahHlCm/M_thr');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Perhitungan THR';
		$data['Menu'] 			= 	'Proses Gaji';
		$data['SubMenuOne'] 	= 	'Perhitungan THR';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_thr->getTHRAll();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/THR/V_indexperhitungan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function proses(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Perhitungan THR';
		$data['Menu'] 			= 	'Proses Gaji';
		$data['SubMenuOne'] 	= 	'Perhitungan THR';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/THR/V_prosesperhitungan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function hitung(){
		$tgl_proses = date('Y-m-d H:i:s');

		$this->load->library('upload');
		$this->load->library('excel');
		
		$noind = $this->session->user;
		$user_id = $this->session->userid;
		$user = $this->session->user;

		if (!empty($_FILES['flHLCMBulanTHR']['name'])) {
			$direktori						= $_FILES['flHLCMBulanTHR']['name'];
			$ekstensi						= pathinfo($direktori,PATHINFO_EXTENSION);
			$xls							= "HLCM-THRBulan-".$noind."-".str_replace(' ', '_', date('Y-m-d H:i:s')).".".$ekstensi;
			$config['upload_path']          = './assets/upload/THRHLCM';
			$config['allowed_types']        = 'xls';
        	$config['file_name']		 	= $xls;
        	$config['overwrite'] 			= TRUE;
        	$this->upload->initialize($config);
    		if ($this->upload->do_upload('flHLCMBulanTHR'))
    		{
        		$this->upload->data();
    		}
    		else
    		{
    			$errorinfo = $this->upload->display_errors();
    			echo $errorinfo;
    		}
    	}else{
    		redirect(base_url('HitungHlcm/THR/Perhitungan/proses'));
    	}

		$tanggal 	= $this->input->post('txtHLCMIdulFitri');
		$awal 		= $this->input->post('txtHLCMPeriodeAwalTHR');
		$akhir 		= $this->input->post('txtHLCMPeriodeAkhirTHR');

		$objPHPExcel = PHPExcel_IOFactory::load("./assets/upload/THRHLCM/".$xls);
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		$rowData = $sheet->rangeToArray('A2:'.$highestColumn.$highestRow,null,true,false);
		
		$tampung = array();
		if (!empty($rowData)) {

			$index = 0;

			foreach ($rowData as $dt) {
				$noind 	= $dt[1];
				$nama 	= $dt[2];
				$lokasi	= $dt[3];
				$masuk 	= $dt[4];
				$masa 	= $dt[5];
				$bulan 	= $dt[6];

				$tampung[$index] = array(
					'noind'	=> $noind,
					'nama'	=> $nama,
					'lokasi'=> $lokasi,
					'masuk'	=> $masuk,
					'masa'	=> $masa,
					'bulan' => $bulan
				);
				
				if (intval($bulan) == 12) {
					$rata = $this->M_thr->getAverageGPByNoindAwalAkhir($noind,trim($awal),trim($akhir));
					if(!empty($rata)) {
						$thr = $rata[0]['rata'];
					}else{
						$thr = 0;
					}
				}else{
					$rata = $this->M_thr->getAverageGPByNoindAwalAkhir($noind,trim($awal),trim($akhir));
					if(!empty($rata)) {
						$thr = (intval($bulan)/12) * $rata[0]['rata'];
					}else{
						$thr = 0;
					}
				}
				$tampung[$index]['thr'] = $thr;

				$cek_thr = $this->M_thr->getTHRByIdulFitriNoind($tanggal,$tampung[$index]['noind']);
				if(count($cek_thr) > 0){

					$data_thr = array(
						'tgl_proses' 		=> $tgl_proses,
						'tgl_idul_fitri' 	=> $tanggal,
						'periode_awal'		=> $awal,
						'periode_akhir'		=> $akhir,
						'noind' 			=> $tampung[$index]['noind'],
						'tgl_masuk' 		=> $tampung[$index]['masuk'],
						'masa_kerja' 		=> $tampung[$index]['masa'],
						'nominal_thr' 		=> $tampung[$index]['thr'],
						'proses_by' 		=> $user
					);

					$this->M_thr->updateTHRByID($cek_thr['0']['id_thr'],$data_thr);

					$data_thr_history = array(
						'id_thr'			=> $cek_thr['0']['id_thr'],
						'tgl_proses' 		=> $tgl_proses,
						'tgl_idul_fitri' 	=> $tanggal,
						'periode_awal'		=> $awal,
						'periode_akhir'		=> $akhir,
						'noind' 			=> $tampung[$index]['noind'],
						'tgl_masuk' 		=> $tampung[$index]['masuk'],
						'masa_kerja' 		=> $tampung[$index]['masa'],
						'nominal_thr' 		=> $tampung[$index]['thr'],
						'proses_by' 		=> $user,
						'tgl_input'			=> $cek_thr['0']['tgl_proses'],
						'input_by'			=> $cek_thr['0']['proses_by']
					);

					$this->M_thr->insertTHRHistory($data_thr_history);

				}else{

					$data_thr = array(
						'tgl_proses' 		=> $tgl_proses,
						'tgl_idul_fitri' 	=> $tanggal,
						'periode_awal'		=> $awal,
						'periode_akhir'		=> $akhir,
						'noind' 			=> $tampung[$index]['noind'],
						'tgl_masuk' 		=> $tampung[$index]['masuk'],
						'masa_kerja' 		=> $tampung[$index]['masa'],
						'nominal_thr' 		=> $tampung[$index]['thr'],
						'proses_by' 		=> $user
					);

					$id_thr = $this->M_thr->insertTHR($data_thr);

					$data_thr_history = array(
						'id_thr'			=> $id_thr,
						'tgl_proses' 		=> $tgl_proses,
						'tgl_idul_fitri' 	=> $tanggal,
						'periode_awal'		=> $awal,
						'periode_akhir'		=> $akhir,
						'noind' 			=> $tampung[$index]['noind'],
						'tgl_masuk' 		=> $tampung[$index]['masuk'],
						'masa_kerja' 		=> $tampung[$index]['masa'],
						'nominal_thr' 		=> $tampung[$index]['thr'],
						'proses_by' 		=> $user,
						'tgl_input'			=> $tgl_proses,
						'input_by'			=> $user
					);

					$this->M_thr->insertTHRHistory($data_thr_history);

				}

				$index++;
			}
		}

		$data['Title']			=	'Perhitungan THR';
		$data['Menu'] 			= 	'Proses Gaji';
		$data['SubMenuOne'] 	= 	'Perhitungan THR';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $tampung;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/THR/V_prosesperhitungan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function cetak(){
		$tanggal 	= $this->input->get('tanggal');
		$lokasi 	= $this->input->get('lokasi');
		$data['tanggal'] = $tanggal;

		if (!empty($lokasi)) {
			$data['data'] = $this->M_thr->getTHRByTanggalLokasi($tanggal,$lokasi);
		}else{
			$data['data'] = $this->M_thr->getTHRByTanggal($tanggal);
		}

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('','A4', 8, '', 10, 10, 10, 10, 10, 5);
		$filename = "Perhitungan THR HLCM Idul Fitri ".$tanggal.".pdf";
		$html = $this->load->view('UpahHlCm/THR/V_cetakperhitungan', $data, true);
		// print_r($data['data']);exit();
		// $this->load->view('UpahHlCm/THR/V_cetakperhitunganbulan', $data);exit();

		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-HLCM oleh ".$this->session->user." pada tgl. ".date('d/m/Y H:i:s').". Halaman {PAGENO} dari {nb}</i> ");
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function delete(){
		$tanggal 	= $this->input->get('tanggal');
		$lokasi 	= $this->input->get('lokasi');
		$noind 		= $this->input->get('noind');

		if (!empty($lokasi)) {
			$data['data'] = $this->M_thr->deleteTHRByTanggalLokasi($tanggal,$lokasi);
		}else{
			if (!empty($noind)) {
				$data['data'] = $this->M_thr->deleteTHRByTanggalNoind($tanggal,$noind);
			}else{
				$data['data'] = $this->M_thr->deleteTHRByTanggal($tanggal);
			}
		}

		redirect(base_url('HitungHlcm/THR/Perhitungan'));
	}

	public function read(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$tanggal 	= $this->input->get('tanggal');
		$lokasi 	= $this->input->get('lokasi');

		$data['Title']			=	'Perhitungan THR';
		$data['Menu'] 			= 	'Proses Gaji';
		$data['SubMenuOne'] 	= 	'Perhitungan THR';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		if (!empty($lokasi)) {
			$data['data'] = $this->M_thr->getTHRByTanggalLokasi($tanggal,$lokasi);
		}else{
			$data['data'] = $this->M_thr->getTHRByTanggal($tanggal);
		}
		
		$data['tanggal'] = $tanggal;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/THR/V_readperhitungan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function export(){
		$tanggal 	= $this->input->get('tanggal');
		$lokasi 	= $this->input->get('lokasi');

		if (!empty($lokasi)) {
			$data = $this->M_thr->getTHRByTanggalLokasi($tanggal,$lokasi);
		}else{
			$data = $this->M_thr->getTHRByTanggal($tanggal);
		}

		$this->load->library('excel');
		$worksheet = $this->excel->getActiveSheet();
		$worksheet->setCellValue('A1','NO');
		$worksheet->setCellValue('B1','NO INDUK');
		$worksheet->setCellValue('C1','NAMA');
		$worksheet->setCellValue('D1','LOKASI KERJA');
		$worksheet->setCellValue('E1','MASUK KERJA');
		$worksheet->setCellValue('F1','MASA KERJA');
		$worksheet->setCellValue('G1','NOMINAL THR');

		$nomor = 1;
		if (!empty($data)) {
			foreach ($data as $dt) {
				$worksheet->setCellValue('A'.($nomor+1),$nomor);
				$worksheet->setCellValue('B'.($nomor+1),$dt['noind']);
				$worksheet->setCellValue('C'.($nomor+1),$dt['employee_name']);
				$worksheet->setCellValue('D'.($nomor+1),$dt['location_name']);
				$worksheet->setCellValue('E'.($nomor+1),$dt['tgl_masuk']);
				$worksheet->setCellValue('F'.($nomor+1),$dt['masa_kerja']);
				$worksheet->setCellValue('G'.($nomor+1),number_format($dt['nominal_thr'],2,',','.'));
				$nomor++;
			}
		}

		$worksheet->getColumnDimension('A')->setWidth('5');
		$worksheet->getColumnDimension('B')->setWidth('10');
		$worksheet->getColumnDimension('C')->setWidth('20');
		$worksheet->getColumnDimension('D')->setWidth('20');
		$worksheet->getColumnDimension('E')->setWidth('20');
		$worksheet->getColumnDimension('F')->setWidth('30');
		$worksheet->getColumnDimension('G')->setWidth('20');

		$worksheet->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN)
				),
				'fill' =>array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'startcolor' => array(
						'argb' => '00C0C0C0')
				),
				'font' => array(
					'bold' => true
				)
			),'A1:G1');

		$worksheet->duplicateStyleArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN)
				)
			),'A1:G'.($nomor));

		$filename = "Perhitungan Bulan THR HLCM Idul Fitri ".$tanggal.".xls";
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}

}

?>