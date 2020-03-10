<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class C_Memo extends CI_Controller {

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
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('UpahHlCm/M_cetakdata');
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
		$this->load->view('UpahHlCm/MenuCetak/V_Memo',$data);
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
		$data['nmr_memo'] = $this->input->post('nmr_memo');

		$data['periode'] = $this->input->post('periode');
		$data['tujuan'] = $this->input->post('tujuan_surat');
		$periodew = explode(' - ', $data['periode']);
		$tanggalawal = date('Y-m-d',strtotime($periodew[0]));
		$tanggalakhir = date('Y-m-d',strtotime($periodew[1]));
		$status = $this->input->post('statusPekerja');
		$tgl = date('F-Y',strtotime($tanggalawal));
		$noind = "";
		$ttd = $this->M_prosesgaji->getApproval("Memo");
		$kom = $this->M_prosesgaji->getHlcmSlipGajiPrint($tanggalawal,$tanggalakhir,$noind,$status);
		$nom = $this->M_prosesgaji->ambilNominalGaji();
		$potongan_tambahan = $this->M_cetakdata->ambilPotTam($tanggalawal,$tanggalakhir);
		
		// echo "<pre>";
		// print_r($kom);
		// exit();
		$total_p_ktukang ="";
		$total_p_tukang ="";
		$total_p_serabutan ="";
		$total_p_tenaga ="";
		$total_t_ktukang ="";
		$total_t_tukang ="";
		$total_t_serabutan ="";
		$total_t_tenaga ="";
		foreach ($kom as $key) {
			if (!empty($potongan_tambahan)) {
				
				foreach ($potongan_tambahan as $pot_tam) {
					if($key['noind'] == $pot_tam['noind']){
						$key['total_bayar'] += $pot_tam['total_gp'] + $pot_tam['total_um'] + $pot_tam['total_lembur'];
					}
				}
				
			}
			if ($key['lokasi_kerja'] == '01') {
				if ($key['pekerjaan'] == 'KEPALA TUKANG') {
					$total_p_ktukang += $key['total_bayar'];
				}
				if ($key['pekerjaan'] == 'TUKANG') {
					$total_p_tukang += $key['total_bayar'];
				}
				if ($key['pekerjaan'] == 'SERABUTAN') {
					$total_p_serabutan += $key['total_bayar'];
				}
				if ($key['pekerjaan'] == 'TENAGA') {
					$total_p_tenaga += $key['total_bayar'];
				}
			}
			if ($key['lokasi_kerja'] == '02') {
				if ($key['pekerjaan'] == 'KEPALA TUKANG') {
					$total_t_ktukang += $key['total_bayar'];
				}
				if ($key['pekerjaan'] == 'TUKANG') {
					$total_t_tukang += $key['total_bayar'];
				}
				if ($key['pekerjaan'] == 'SERABUTAN') {
					$total_t_serabutan += $key['total_bayar'];
				}
				if ($key['pekerjaan'] == 'TENAGA') {
					$total_t_tenaga += $key['total_bayar'];
				}
			}
		}
		$total_pusat = $total_p_ktukang+$total_p_tukang+$total_p_serabutan+$total_p_tenaga;
		$total_tuksono = $total_t_ktukang+$total_t_tukang+$total_t_serabutan+$total_t_tenaga;
		$totalsemua = $total_pusat+$total_tuksono;
		$data['total'] = array(
								'p_ktukang' => $total_p_ktukang,
								'p_tukang' => $total_p_tukang,
								'p_serabutan' => $total_p_serabutan,
								'p_tenaga' => $total_p_tenaga,
								't_ktukang' => $total_t_ktukang,
								't_tukang' => $total_t_tukang,
								't_serabutan' => $total_t_serabutan,
								't_tenaga' => $total_t_tenaga,
								'total_p' => $total_pusat,
								'total_t' => $total_tuksono,
								'total_semua' => $totalsemua,
							);
		// echo "<pre>";
		// print_r($data['total']);
		// exit();
		$type = $this->input->post('txtSubmit');
		if ($type == 'Cetak Pdf') {
			$data['ttd'] = $ttd;
			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', 'F4', 8, '', 12, 15, 15, 15, 10, 20);
			$filename = 'Memo-'.$tgl.'.pdf';

			$html = $this->load->view('UpahHlCm/MenuCetak/V_cetakMemo', $data, true);
			$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-HLCM pada oleh ".$this->session->user." tgl. ".date('d/m/Y H:i:s').". Halaman {PAGENO} dari {nb}</i>");
			$pdf->WriteHTML($html, 2);
			$pdf->Output($filename, 'I');
		}else{
			$this->load->library('excel');
			$worksheet = $this->excel->getActiveSheet();

			$worksheet->setCellValue('B1','MEMO');
			$worksheet->setCellValue('B2','SEKSI ELECTRONIC DATA PROCESSING');
			$worksheet->setCellValue('B3','CV. KARYA HIDUP SENTOSA');
			$worksheet->setCellValue('B4','JL. MAGELANG NO. 144 YOGYAKARTA');
			$worksheet->mergeCells('B1:F1');
			$worksheet->mergeCells('B2:F2');
			$worksheet->mergeCells('B3:F3');
			$worksheet->mergeCells('B4:F4');

			$worksheet->setCellValue('A6','No');
			$worksheet->setCellValue('A7','Hal');
			$worksheet->setCellValue('B6',':'.$data['nmr_memo']);
			$period = explode(' - ', $data['periode']);
			$worksheet->setCellValue('B7',': Transfer Upah Pekerja Harian Lepas '.date('d/m/Y',strtotime($period[0])).' - '.date('d/m/Y',strtotime($period[1])));
			$worksheet->mergeCells('B6:G6');
			$worksheet->mergeCells('B7:G7');

			$worksheet->setCellValue('A9','Kepada Yth:');
			$worksheet->setCellValue('A10',$data['tujuan']);
			$worksheet->setCellValue('A11','Ditempat');
			$worksheet->mergeCells('A9:G9');
			$worksheet->mergeCells('A10:G10');
			$worksheet->mergeCells('A11:G11');

			$worksheet->setCellValue('A13','Dengan hormat,');
			$worksheet->mergeCells('A13:G13');
			
			$worksheet->setCellValue('A14','Dengan ini mohon agar dilakukan transfer uang untuk pembayaran upah pekerja harian lepas KHS Pusat dan Tuksono ,periode ('.date('d/m/Y',strtotime($period[0])).' - '.date('d/m/Y',strtotime($period[1])).')');
			$worksheet->mergeCells('A14:G14');

			$worksheet->setCellValue('B15','KEPALA TUKANG');
			$worksheet->setCellValue('B16','TUKANG');
			$worksheet->setCellValue('B17','SERABUTAN');
			$worksheet->setCellValue('B18','TENAGA');

			$worksheet->setCellValue('C15',"Rp ".number_format(ceil($total_t_ktukang),2,',','.'));
			$worksheet->setCellValue('C16',"Rp ".number_format(ceil($total_t_tukang),2,',','.'));
			$worksheet->setCellValue('C17',"Rp ".number_format(ceil($total_t_serabutan),2,',','.'));
			$worksheet->setCellValue('C18',"Rp ".number_format(ceil($total_t_tenaga),2,',','.'));

			$worksheet->setCellValue('E15','KEPALA TUKANG');
			$worksheet->setCellValue('E16','TUKANG');
			$worksheet->setCellValue('E17','SERABUTAN');
			$worksheet->setCellValue('E18','TENAGA');

			$worksheet->setCellValue('F15',"Rp ".number_format(ceil($total_p_ktukang),2,',','.'));
			$worksheet->setCellValue('F16',"Rp ".number_format(ceil($total_p_tukang),2,',','.'));
			$worksheet->setCellValue('F17',"Rp ".number_format(ceil($total_p_serabutan),2,',','.'));
			$worksheet->setCellValue('F18',"Rp ".number_format(ceil($total_p_tenaga),2,',','.'));

			$worksheet->setCellValue('B20','TOTAL TUKSONO');

			$worksheet->setCellValue('C20',"Rp ".number_format(ceil($total_tuksono),2,',','.'));

			$worksheet->setCellValue('E20','TOTAL KHS PUSAT');

			$worksheet->setCellValue('F20',"Rp ".number_format(ceil($total_pusat),2,',','.'));

			$worksheet->setCellValue('B22','TOTAL SEMUA');

			$worksheet->setCellValue('C22',"Rp ".number_format(ceil($totalsemua),2,',','.'));

			$worksheet->setCellValue('A24','Demikian memo ini kami sampaikan. Atas perhatian dan kerjasamanya kami sampaikan banyak terimakasih.');
			$worksheet->mergeCells('A24:G24');
			$tgl = date('d');
				$month=date('m');
				if ($month=='01') {
					$tgl .= " Januari ";
				}elseif ($month=='02') {
					$tgl .= " Februari ";
				}elseif ($month=='03') {
					$tgl .= " Maret ";
				}elseif ($month=='04') {
					$tgl .= " April ";
				}elseif ($month=='05') {
					$tgl .= " Mei ";
				}elseif ($month=='06') {
					$tgl .= " Juni ";
				}elseif ($month=='07') {
					$tgl .= " Juli ";
				}elseif ($month=='08') {
					$tgl .= " Agustus ";
				}elseif ($month=='09') {
					$tgl .= " September ";
				}elseif ($month=='10') {
					$tgl .= " Oktober ";
				}elseif ($month=='11') {
					$tgl .= " November ";
				}elseif ($month=='12') {
					$tgl .= " Desember ";
				};
				$tgl .= date('Y');
			$worksheet->setCellValue('E26','Yogyakarta, '.$tgl);
			$worksheet->mergeCells('E26:F26');

			$worksheet->setCellValue('C34','Mengetahui');
			$worksheet->setCellValue('E27','Dibuat Oleh');
			$worksheet->setCellValue('B27','Menyetujui');
			$worksheet->mergeCells('B27:C27');
			$worksheet->mergeCells('E27:F27');
			$worksheet->mergeCells('C34:E34');

			foreach ($ttd as $ttd_mengetahui) {
				if ($ttd_mengetahui['posisi'] == "mengetahui") {
					$worksheet->setCellValue('C38',ucwords(strtolower($ttd_mengetahui['nama'])));
					$worksheet->setCellValue('C39',ucwords(strtolower($ttd_mengetahui['jabatan'])));
				}
			}
			
			$worksheet->mergeCells('B31:C31');
			$worksheet->mergeCells('B32:C32');
			$worksheet->getStyle('B31')->getFont()->setUnderline(true);

			foreach ($ttd as $ttd_dibuat) {
				if ($ttd_dibuat['posisi'] == "dibuat") {
					$worksheet->setCellValue('E31',ucwords(strtolower($ttd_dibuat['nama'])));
					$worksheet->setCellValue('E32',ucwords(strtolower($ttd_dibuat['jabatan'])));
				}
			}
			
			$worksheet->mergeCells('E31:F31');
			$worksheet->mergeCells('E32:F32');
			$worksheet->getStyle('E31')->getFont()->setUnderline(true);

			foreach ($ttd as $ttd_dibuat) {
				if ($ttd_dibuat['posisi'] == "menyetujui") {
					$worksheet->setCellValue('B31',ucwords(strtolower($ttd_dibuat['nama'])));
					$worksheet->setCellValue('B32',ucwords(strtolower($ttd_dibuat['jabatan'])));
				}
			}
			
			$worksheet->mergeCells('C38:E38');
			$worksheet->mergeCells('C39:E39');
			$worksheet->getStyle('C38')->getFont()->setUnderline(true);

			$imagestr = new PHPExcel_Worksheet_Drawing();
			$imagestr->setName('logo');
			$imagestr->setDescription('logo');
			$imagestr->setPath('./assets/img/logo.png');
			$imagestr->setCoordinates('A1');
			$imagestr->setResizeProportional(false);
			$imagestr->setWidth(80);
			$imagestr->setHeight(85);
			$imagestr->setWorksheet($this->excel->getActiveSheet());


			$worksheet->getRowDimension(14)->setRowHeight(40);
			$worksheet->getRowDimension(24)->setRowHeight(40);

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'alignment' => array(
					'wrap' => true,
					'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'font' => array(
					'bold' =>true,
					'size' => 16
				)
			),'B1:B4');

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'font' => array(
					'bold' =>true
				)
			),'A10:A11');

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'alignment' => array(
					'wrap' => true,
					'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			),'B26:E39');
			
			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'alignment' => array(
					'wrap' => true,
					'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
				)
			),'A14:A24');

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN)
				)
			),'B15:C18');

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'borders' => array(
					'bottom' => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK)
				)
			),'A4:G4');

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN)
				)
			),'B20:C20');

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN)
				)
			),'B22:C22');

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN)
				)
			),'E15:F18');

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN)
				)
			),'E20:F20');

			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('3');
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('18');
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('2');
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('18');
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth('3');
			$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_WorkSheet_PageSetup::PAPERSIZE_A4);
			$this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
			$filename ='Memo-'.$tgl.'.xls';
			header('Content-Type: aplication/vnd.ms-excel');
			header('Content-Disposition:attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
			$writer->save('php://output');
		}
	}
}
