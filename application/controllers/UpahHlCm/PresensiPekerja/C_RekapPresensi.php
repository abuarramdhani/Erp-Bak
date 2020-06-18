<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class C_RekapPresensi extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('Log_Activity');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('UpahHlCm/M_presensipekerja');
		$this->load->model('UpahHlCm/M_prosesgaji');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }

	//HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['periodeGaji'] = $this->M_prosesgaji->getCutOffGaji();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/PresensiPekerja/V_indexRekap',$data);
		$this->load->view('V_Footer',$data);

	}

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}

	public function cetakpdf()
	{
		$this->load->library('pdf');

		$data['periode'] = $this->input->post('periode');
		$periodew = explode(' - ', $data['periode']);
		$tanggalawal = date('Y-m-d',strtotime($periodew[0]));
		$tanggalakhir = date('Y-m-d',strtotime($periodew[1]));
		$tgl = date('F-Y',strtotime($tanggalakhir));

		$data['RekapPresensi'] = $this->M_presensipekerja->getRekapPresensi($tanggalawal,$tanggalakhir);
		// echo "<pre>";print_r($data['RekapPresensi']);exit();
		$submit = $this->input->post('txtSubmit');
		if ($submit == 'Cetak Pdf') {
			//insert to t_log
			$aksi = 'UPAH HLCM';
			$detail = 'Rekap Presensi Cetak PDF '.$data['periode'];
			$this->log_activity->activity_log($aksi, $detail);
			//
			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', 'A4-L', 8, '', 10, 10, 10, 10, 10, 5);
			$filename = 'Rekap-'.$tgl.'.pdf';
			// $this->load->view('UpahHlCm/PresensiPekerja/V_cetakRekapPresensi', $data);
			$html = $this->load->view('UpahHlCm/PresensiPekerja/V_cetakRekapPresensi', $data, true);
			$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-HLCM pada oleh ".$this->session->user." ".$this->session->employee." tgl. ".date('d/m/Y H:i:s').". Halaman {PAGENO} dari {nb}</i>");
			$pdf->WriteHTML($html, 2);
			$pdf->Output($filename, 'I');
		}elseif($submit == 'Simpan Data'){
			// echo "<pre>";print_r($data['RekapPresensi']);
			$data_simpan = array(
	    		'tgl_awal_periode' => $tanggalawal,
	    		'tgl_akhir_periode' => $tanggalakhir,
	    		'created_by' => $this->session->user,
	    		'isi' => json_encode($data),
	    		'asal' => 'Rekap Presensi',
	    		'keterangan' => $this->input->post('txtKeterangan')
	    	);
	    	$this->M_presensipekerja->insertArsip($data_simpan);

			//insert to t_log
			$aksi = 'UPAH HLCM';
			$detail = 'Rekap Presensi INSERT data di hlcm_proses_detail';
			$this->log_activity->activity_log($aksi, $detail);
			//

	    	$user_id = $this->session->userid;

			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';

			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

	    	$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('UpahHlCm/PresensiPekerja/V_simpanRekapPresensi',$data);
			$this->load->view('V_Footer',$data);
		}else{
			//insert to t_log
			$aksi = 'UPAH HLCM';
			$detail = 'Rekap Presensi Cetak Excel '.$data['periode'];
			$this->log_activity->activity_log($aksi, $detail);
			//
			$this->load->library('excel');
			$worksheet = $this->excel->getActiveSheet();

			$period = explode(' - ', $data['periode']);

			$worksheet->setCellValue('A1','REKAP PRESENSI');
			$worksheet->mergeCells('A1:O1');
			$worksheet->setCellValue('A2','PERIODE TANGGAL : '.date('d F Y',strtotime($period[0]))." - ".date('d F Y',strtotime($period[1])));
			$worksheet->mergeCells('A2:O2');
			$worksheet->setCellValue('A3','NO');
			$worksheet->setCellValue('B3','NO INDUK');
			$worksheet->setCellValue('C3','NAMA');
			$worksheet->setCellValue('D3','LOKASI KERJA');
			$worksheet->setCellValue('E3','STATUS');
			$worksheet->setCellValue('F3','GAJI');
			$worksheet->setCellValue('J3','TAMBAHAN');
			$worksheet->setCellValue('M3','POTONGAN');
			$worksheet->setCellValue('F4','Gaji Pokok');
			$worksheet->setCellValue('G4','Lembur');
			$worksheet->setCellValue('H4','Uang Makan');
			$worksheet->setCellValue('I4','Uang Makan Puasa');
			$worksheet->setCellValue('J4','Gaji Pokok');
			$worksheet->setCellValue('K4','Lembur');
			$worksheet->setCellValue('L4','Uang Makan');
			$worksheet->setCellValue('M4','Gaji Pokok');
			$worksheet->setCellValue('N4','Lembur');
			$worksheet->setCellValue('O4','Uang Makan');

			$worksheet->mergeCells('A3:A4');
			$worksheet->mergeCells('B3:B4');
			$worksheet->mergeCells('C3:C4');
			$worksheet->mergeCells('D3:D4');
			$worksheet->mergeCells('E3:E4');
			$worksheet->mergeCells('F3:I3');
			$worksheet->mergeCells('J3:L3');
			$worksheet->mergeCells('M3:O3');

			if (isset($data['RekapPresensi']) and !empty($data['RekapPresensi'])) {
				$nomor = 1;
				foreach ($data['RekapPresensi'] as $key) {
					$worksheet->setCellValue('A'.($nomor + 4),$nomor);
					$worksheet->setCellValue('B'.($nomor + 4),$key['noind']);
					$worksheet->setCellValue('C'.($nomor + 4),$key['nama']);
					$worksheet->setCellValue('D'.($nomor + 4),$key['lokasi']);
					$worksheet->setCellValue('E'.($nomor + 4),$key['pekerjaan']);
					$worksheet->setCellValue('F'.($nomor + 4),$key['gp_gaji']);
					$worksheet->setCellValue('G'.($nomor + 4),$key['lembur_gaji']);
					$worksheet->setCellValue('H'.($nomor + 4),$key['um_gaji']);
					$worksheet->setCellValue('I'.($nomor + 4),$key['ump_gaji']);
					$worksheet->setCellValue('J'.($nomor + 4),$key['gp_tambahan']);
					$worksheet->setCellValue('K'.($nomor + 4),$key['lembur_tambahan']);
					$worksheet->setCellValue('L'.($nomor + 4),$key['um_tambahan']);
					$worksheet->setCellValue('M'.($nomor + 4),$key['gp_potongan']);
					$worksheet->setCellValue('N'.($nomor + 4),$key['lembur_potongan']);
					$worksheet->setCellValue('O'.($nomor + 4),$key['um_potongan']);
					$worksheet->getStyle("F".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("G".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("H".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("I".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("J".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("K".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("L".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("M".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("N".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("O".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$nomor++;
				}
			}

			$worksheet->getColumnDimension('A')->setWidth('5');
			$worksheet->getColumnDimension('B')->setWidth('10');
			$worksheet->getColumnDimension('C')->setWidth('20');
			$worksheet->getColumnDimension('D')->setWidth('20');
			$worksheet->getColumnDimension('E')->setWidth('10');
			$worksheet->getColumnDimension('F')->setWidth('10');
			$worksheet->getColumnDimension('G')->setWidth('10');
			$worksheet->getColumnDimension('H')->setWidth('10');
			$worksheet->getColumnDimension('I')->setWidth('10');
			$worksheet->getColumnDimension('J')->setWidth('10');
			$worksheet->getColumnDimension('K')->setWidth('10');
			$worksheet->getColumnDimension('L')->setWidth('10');
			$worksheet->getColumnDimension('M')->setWidth('10');
			$worksheet->getColumnDimension('N')->setWidth('10');
			$worksheet->getColumnDimension('O')->setWidth('10');
			$worksheet->getStyle('F4:O4')->getAlignment()->setWrapText(true);
			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			),'A1:O1');
			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'fill' =>array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'startcolor' => array(
						'argb' => '00ccffcc')
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN)
				)
			),'A3:O4');
			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN)
				)
			),'A5:O'.($nomor + 3));

			$filename ='RekapPresensi-'.$tgl.'.xls';
			header('Content-Type: aplication/vnd.ms-excel');
			header('Content-Disposition:attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
			$writer->save('php://output');
		}
	}
}
