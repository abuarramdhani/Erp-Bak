<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_DataMasuk extends CI_Controller
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
		$this->load->library('ciqrcode');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('P2K3/MainMenu/M_order');
		$this->load->model('P2K3/P2K3Admin/M_dtmasuk');
		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){
		} else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;
		$user1 = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Input Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$noind = $this->session->user;

		$kodesie 					= $this->session->kodesie;
		$data['seksi'] 				= $this->M_order->getSeksi($noind);
		$data['tampil_data'] 		= $this->M_order->tampil_data($kodesie);
		// $data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($kodesie);
		// $data['approve'] 			= $this->M_order->approve($user1);
		$data['approveString'] 		= $this->M_order->approveString($user1);
		$data['namaSeksi']			= $this->M_order->getNamaSeksi();
		// $tanggal 					= $this->input->post('txtTanggalex', TRUE);
		$data['tanggalnow']						= date('m - Y');
		// echo $data['tanggalnow']; exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3/Order/V_list_all', $data);
		$this->load->view('V_Footer',$data);
	}

	public function cek()
	{
		$tanggalex = $this->input->post('txtTanggalex');
        $tanggalex = explode(' - ', $tanggalex);
        $tgl = $tanggalex[0];
        $tahun = $tanggalex[1];
        $daftar_seksi = $this->M_dtmasuk->daftar_seksi($tgl, $tahun);
        $daftar_apd = $this->M_dtmasuk->daftar_apd($daftar_seksi, $tgl, $tahun);
        if (!empty($daftar_seksi) && !empty($daftar_apd)) {
        	$this->export();
        }else{
        	$message = "Data Kosong";
			echo "<script type='text/javascript'>alert('$message');
			history.go(-1);</script>";
			// header('Location: '.$_SERVER['REQUEST_URI']);
        }
	}

	public function export()
    {   
		$this->load->library(array('Excel','Excel/PHPExcel/IOFactory'));
        // echo "<pre>";
        $tanggalex = $this->input->post('txtTanggalex');
        $tanggalex = explode(' - ', $tanggalex);
        $tgl = $tanggalex[0];
        $tahun = $tanggalex[1];
        $daftar_seksi = $this->M_dtmasuk->daftar_seksi($tgl, $tahun);
        $daftar_apd = $this->M_dtmasuk->daftar_apd($daftar_seksi, $tgl, $tahun);
        	
        // print_r($daftar_apd); exit();
        // print_r($tanggalex); exit();
        // echo $tgl; exit();
		
		$objPHPExcel = new PHPExcel();

             $objPHPExcel->getProperties()->setCreator('KHS ERP')
             ->setTitle("DAFTAR KEBUTUHAN SARANA P2K3")
             ->setSubject("SARANA P2K3")
             ->setDescription("Laporan Kebutuhan Sarana P2K3")
             ->setKeywords("Kebutuhan Sarana P2K3");

     	$style_col = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            // 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi di tengah secara horizontal (left)
            // 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi di tengah secara horizontal (right)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
           'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'bababa')
          )
        );  

        $style_col1 = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );
        $style_col2 = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
          'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'bababa')
          )
        );

        $style_row = array(
          'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );

        $style_heading = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
          'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '0099ff')
          )
        );

        $styleArray = array(
		      'borders' => array(
		          'allborders' => array(
		              'style' => PHPExcel_Style_Border::BORDER_THIN
		          )
		      )
		  );

        $style_col_rev = array(
          'font' => array('bold' => false), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            // 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text jadi di tengah secara horizontal (left)
            // 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT // Set text jadi di tengah secara horizontal (right)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
           'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'bababa')
          )
        );

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DAFTAR KEBUTUHAN SARANA P2K3");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:O2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "Sarana APD");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Kode Item");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "Durasi");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "Total APD");
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
        $objPHPExcel->getActiveSheet()->mergeCells('C3:C4');
        $objPHPExcel->getActiveSheet()->mergeCells('D3:D4');
        $objPHPExcel->getActiveSheet()->mergeCells('E3:E4');
        $objPHPExcel->getActiveSheet()->getStyle('A3:A4')->getFont()->setBold(TRUE)->setSize(9); // Set bold kolom A1
        $objPHPExcel->getActiveSheet()->getStyle('A3:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A3:A4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B3:B4')->getFont()->setBold(TRUE)->setSize(9); // Set bold kolom A1
        $objPHPExcel->getActiveSheet()->getStyle('B3:B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B3:B4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C3:C4')->getFont()->setBold(TRUE)->setSize(9); // Set bold kolom A1
        $objPHPExcel->getActiveSheet()->getStyle('C3:C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C3:C4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D3:D4')->getFont()->setBold(TRUE)->setSize(9); // Set bold kolom A1
        $objPHPExcel->getActiveSheet()->getStyle('D3:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D3:D4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E3:E4')->getFont()->setBold(TRUE)->setSize(9); // Set bold kolom A1
        $objPHPExcel->getActiveSheet()->getStyle('E3:E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E3:E4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A3:A4')->applyFromArray($style_heading);
        $objPHPExcel->getActiveSheet()->getStyle('B3:B4')->applyFromArray($style_heading);
        $objPHPExcel->getActiveSheet()->getStyle('C3:C4')->applyFromArray($style_heading);
        $objPHPExcel->getActiveSheet()->getStyle('D3:D4')->applyFromArray($style_heading);
        $objPHPExcel->getActiveSheet()->getStyle('E3:E4')->applyFromArray($style_heading);

        //<----kolom nomor----->
        $no = 6;
        $kolom_no = 1;
        foreach ($daftar_apd as $row) {
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$no, $kolom_no);
	        $objPHPExcel->getActiveSheet()->getStyle('A'.$no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $objPHPExcel->getActiveSheet()->getStyle('A'.$no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	        $objPHPExcel->getActiveSheet()->getStyle('A'.$no)->applyFromArray($style_row);
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$no, $row['item']);
	        $objPHPExcel->getActiveSheet()->getStyle('B'.$no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $objPHPExcel->getActiveSheet()->getStyle('B'.$no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	        $objPHPExcel->getActiveSheet()->getStyle('B'.$no)->applyFromArray($style_row);
	        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$no, $row['kode_item']);
	        $objPHPExcel->getActiveSheet()->getStyle('C'.$no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $objPHPExcel->getActiveSheet()->getStyle('C'.$no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	        $objPHPExcel->getActiveSheet()->getStyle('C'.$no)->applyFromArray($style_row);
	        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$no, $row['jumlah_total']);
	        $objPHPExcel->getActiveSheet()->getStyle('E'.$no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $objPHPExcel->getActiveSheet()->getStyle('E'.$no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	        $objPHPExcel->getActiveSheet()->getStyle('E'.$no)->applyFromArray($style_row);
        	$no++;
        	$kolom_no++;
        }
        //<------daftar nama seksi--------->
        // $range = range('F','G');
        $no_naker = 5;
        foreach ($daftar_seksi as $column) {
        	PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
        	$kolom_new = PHPExcel_Cell::stringFromColumnIndex($no_naker);
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom_new.'4', $column['seksi']);
        	$objPHPExcel->getActiveSheet()->getStyle($kolom_new.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $objPHPExcel->getActiveSheet()->getStyle($kolom_new.'4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        	$objPHPExcel->getActiveSheet()->getStyle($kolom_new.'4')->applyFromArray($style_col_rev);
          $objPHPExcel->getActiveSheet()->getStyle($kolom_new.'4')->getFont()->setBold(false)->setSize(9); // Set bold kolom A1
        	// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        	$no_naker++;
        }
 
        $a = count($daftar_seksi);
        $horizontal = 4 + $a;
        $kolom_new = PHPExcel_Cell::stringFromColumnIndex($horizontal);
        $objPHPExcel->getActiveSheet()->mergeCells('F3:'.$kolom_new.'3');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', 'Seksi');
        $objPHPExcel->getActiveSheet()->getStyle('F3:G3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->applyFromArray(
		    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);
		$objPHPExcel->getActiveSheet()->getStyle($kolom_new.'3')->applyFromArray($style_col1);
		$objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col1);

		 PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
        // foreach(range('A', 'Z') as $columnID) {
        //     $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        //         ->setAutoSize(true);
        // }

        $a = count($daftar_seksi);
        $c = 1;
        $horizontal = 5;
        for ($i=0; $i < $a; $i++) { 
        $vertical = 6;
        	foreach ($daftar_apd as $daftarh) {
        	$kolom_new = PHPExcel_Cell::stringFromColumnIndex($horizontal);
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom_new.$vertical, $daftarh['a'.$c]);
        	$objPHPExcel->getActiveSheet()->getStyle($kolom_new.$vertical)->applyFromArray($style_row);
        	$objPHPExcel->getActiveSheet()->getStyle($kolom_new.$vertical)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
     		$vertical++;
        	}
        	$horizontal++;
        $c++;
        }
       //  foreach ($daftar_seksi as $daftarv) {
       //  	foreach ($daftar_apd as $daftarh) {
       //  	$kolom_new = PHPExcel_Cell::stringFromColumnIndex($horizontal);
       //  	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom_new.$vertical, $daftarh['a'.$a]);
     		// $vertical++;
       //  	}
       //  	$horizontal++;
       //  }


        $objPHPExcel->getActiveSheet()->setTitle('DAFTAR KEBUTUHAN P2K3');

        $objPHPExcel->setActiveSheetIndex(0);  
        $filename = urlencode("Daftar Kebutuhan P2K3".date("Y-m-d").".ods");
           
          header('Content-Type: application/vnd.ms-excel'); //mime type
          header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
          header('Cache-Control: max-age=0'); //no cache

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');                
        $objWriter->save('php://output');
        // redirect('p2k3adm/datamasuk/');

	}
}