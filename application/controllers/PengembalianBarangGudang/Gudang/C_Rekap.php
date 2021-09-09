<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Rekap extends CI_Controller {
    public function __construct(){
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('html');
        $this->load->library('session');
		$this->load->library('form_validation');
        
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PengembalianBarangGudang/M_pengembalianbrg');
        
        $this->checkSession();
    }

    public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
    }

    public function index(){
		$user = $this->session->username;
        $user_id = $this->session->userid;

        $data['Title'] = 'Rekap Pengembalian Barang';
        $data['Menu'] = 'Rekap';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PengembalianBarangGudang/V_Rekap');
        $this->load->view('V_Footer',$data);
    }

    public function SearchRekapPBG(){
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $data['hasil'] = $this->M_pengembalianbrg->getRekapPBG($tgl_awal, $tgl_akhir);
        $data['tgl_awal'] 	= $tgl_awal; 
        $data['tgl_akhir'] 	= $tgl_akhir; 
        // print_r($data['hasil']); exit();

        $this->load->view('PengembalianBarangGudang/V_TblRekap', $data);
    }

    public function exportDataPBG(){
        $id_pengembalian = $this->input->post('id_pengembalian[]');
        $kode_komponen = $this->input->post('kode_komponen[]');
        $nama_komponen = $this->input->post('nama_komponen[]');
        $qty_komponen = $this->input->post('qty_komponen[]');
        $alasan_pengembalian = $this->input->post('alasan_pengembalian[]');
        $pic_assembly = $this->input->post('pic_assembly[]');
        $pic_gudang = $this->input->post('pic_gudang[]');
        $tgl_input = $this->input->post('tgl_input[]');
        $tgl_order_verifikasi = $this->input->post('tgl_order_verifikasi[]');
        $tgl_verifikasi = $this->input->post('tgl_verifikasi[]');
        $status_verifikasi = $this->input->post('status_verifikasi[]');
        $keterangan = $this->input->post('keterangan[]');
        $locator = $this->input->post('locator[]');
        $status = $this->input->post('status[]');
        $tgl_awal = $this->input->post('tgl_awal[]');
        $tgl_akhir = $this->input->post('tgl_akhir[]');

        $tgl_awal 		= $tgl_awal[0];
        $tgl_akhir 		= $tgl_akhir[0];
        // print_r($tgl_akhir); exit();

        $dataPBG = array();
		for ($i=0; $i < count($id_pengembalian) ; $i++) { 
			$array = array(
                'kode_komponen' 	=> $kode_komponen[$i],
                'nama_komponen' 	=> $nama_komponen[$i],
                'qty_komponen' 	=> $qty_komponen[$i],
                'alasan_pengembalian' 	=> $alasan_pengembalian[$i],
                'pic_assembly' 	=> $pic_assembly[$i],
                'pic_gudang' 	=> $pic_gudang[$i],
                'tgl_input' 	=> $tgl_input[$i],
                'tgl_order_verifikasi' 	=> $tgl_order_verifikasi[$i],
                'tgl_verifikasi' 	=> $tgl_verifikasi[$i],
                'status_verifikasi' 	=> $status_verifikasi[$i],
                'keterangan' 	=> $keterangan[$i],
                'locator' 	=> $locator[$i],
                'status' 	=> $status[$i],
			);
			array_push($dataPBG, $array);
        }
        // echo "<pre>"; print_r($dataPBG); exit();
        
        include APPPATH.'third_party/Excel/PHPExcel.php';
        $excel = new PHPExcel();
        $excel->getProperties()->setCreator('CV. KHS')
	                 ->setLastModifiedBy('Quick')
	                 ->setTitle("PengembalianBrgGdg")
	                 ->setSubject("CV. KHS")
	                 ->setDescription("Pengembalian Barang Gudang")
                     ->setKeywords("PBG");
        // style excel
        $style_title = array(
			'font' => array(
				'bold' => true,
				'size' => 15
			), 
			'alignment' => array(
				'horizontal' 	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
		);
		$style_col = array(
			'font' => array('bold' => true), 
			'alignment' => array(
				'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'			=> true
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
        );
        $style_row = array(
			'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
                'wrap'	 => true
			),
			'borders' => array(
                'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'right' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'bottom'	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'left'	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
        );
        
        // title
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP PENGEMBALIAN BARANG GUDANG");
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "PERIODE : $tgl_awal - $tgl_akhir"); 
		$excel->getActiveSheet()->mergeCells('A1:N1'); 
		$excel->getActiveSheet()->mergeCells('A2:N2');
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);
        $excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_title);
        
        // header
		$excel->setActiveSheetIndex(0)->setCellValue('A4', "NO.");
		$excel->setActiveSheetIndex(0)->setCellValue('B4', "KODE KOMPONEN");
		$excel->setActiveSheetIndex(0)->setCellValue('C4', "NAMA KOMPONEN");
		$excel->setActiveSheetIndex(0)->setCellValue('D4', "QTY KOMPONEN");
		$excel->setActiveSheetIndex(0)->setCellValue('E4', "ALASAN PENGEMBALIAN");
        $excel->setActiveSheetIndex(0)->setCellValue('F4', "PIC ASSEMBLY");
        $excel->setActiveSheetIndex(0)->setCellValue('G4', "PIC GUDANG");
        $excel->setActiveSheetIndex(0)->setCellValue('H4', "TGL INPUT");
        $excel->setActiveSheetIndex(0)->setCellValue('I4', "TGL ORDER VERIFIKASI");
        $excel->setActiveSheetIndex(0)->setCellValue('J4', "TGL VEFIRIKASI");
        $excel->setActiveSheetIndex(0)->setCellValue('K4', "STATUS VERIFIKASI");
        $excel->setActiveSheetIndex(0)->setCellValue('L4', "KETERANGAN");
        $excel->setActiveSheetIndex(0)->setCellValue('M4', "LOCATOR");
        $excel->setActiveSheetIndex(0)->setCellValue('N4', "STATUS");

        // style header
		$excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N4')->applyFromArray($style_col);

        $no=1;
        $numrow = 5;
        for ($i=0; $i < sizeof($dataPBG); $i++) {
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $dataPBG[$i]['kode_komponen']);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $dataPBG[$i]['nama_komponen']);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $dataPBG[$i]['qty_komponen']);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $dataPBG[$i]['alasan_pengembalian']);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $dataPBG[$i]['pic_assembly']);
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $dataPBG[$i]['pic_gudang']);
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $dataPBG[$i]['tgl_input']);
            $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $dataPBG[$i]['tgl_order_verifikasi']);
            $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $dataPBG[$i]['tgl_verifikasi']);
            $excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $dataPBG[$i]['status_verifikasi']);
            $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $dataPBG[$i]['keterangan']);
            $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $dataPBG[$i]['locator']);
            $excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $dataPBG[$i]['status']);

            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);

            $no++;
            $numrow++; 
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(35); 
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('N')->setWidth(10);

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Pengembalian Barang Gudang");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="PengembalianBrgGdg_'.$tgl_awal.'_'.$tgl_akhir.'.xlsx"'); 
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');

    }
}

?>