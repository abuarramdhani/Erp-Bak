<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ExportReport extends CI_Controller {

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
		// load the login model
		$this->load->library('session');
		// $this->load->library('Database');
		$this->load->library('Excel');
    $this->load->model('M_Index');
    $this->load->model('ECommerce/M_exportreport');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			//redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
	}	

	public function checkSession()
  {
		if($this->session->is_logged)
    {

		}else
    {
			redirect();
		}
  }

  public function index()
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    //$data['user'] = $usr;
    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    // $data['tableAll'] = $this->M_exportreport->exportAll();
    $data['tableExport'] = 1;
    $data['NamaUser'] = $this->M_exportreport->getUser();
    $data['ItemCat'] = $this->M_exportreport->getItemCat();
    $data['ItemName'] = $this->M_exportreport->getItemName();

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('ECommerce/V_ExportReport',$data);
    $this->load->view('V_Footer',$data);
  }

  public function tableExport()
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    //$data['user'] = $usr;
    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';
        
    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $dateFrom   = $this->input->post('dateBegin');
    $data['dateFrom'] = $dateFrom;

    $dateTo     = $this->input->post('dateEnd');
    $data['dateTo'] = $dateTo;

    $Name = $this->input->post('user_id');
    $Cat_Name = $this->input->post('cat_name');
    $Item_Name = $this->input->post('item_name');
    $data['tableExcelDate'] = '1' ;

    $data['NamaUser'] = $this->M_exportreport->getUser();
    $data['ItemCat'] = $this->M_exportreport->getItemCat();
    $data['ItemName'] = $this->M_exportreport->getItemName();

    // echo($Name);
    // echo($Cat_Name);
    // echo($Item_Name);

    if(isset($Name) && empty($Cat_Name) && empty($Item_Name))
    {
      // echo"1";die;

      $data['tableExport'] = $this->M_exportreport->export($Name);

    } 
    if(isset($Name) && isset($Cat_Name) && empty($Item_Name))
    {
      // echo"12";die;

        $data['tableExport'] = $this->M_exportreport->exportCat($Name, $Cat_Name);

    }
    if(isset($Name) && isset($Cat_Name) && isset($Item_Name))
    {
      // echo"123";die;

      $data['tableExport'] = $this->M_exportreport->exportItem($Name, $Cat_Name, $Item_Name);

    }
    if(empty($Name) && isset($Cat_Name) && empty($Item_Name))
    {
      // echo"2";die;
      $data['tableExport'] = $this->M_exportreport->exportCatNam($Cat_Name);

    }
    if(empty($Name) && isset($Cat_Name) && isset($Item_Name))
    {
      // echo"23";die;

      $data['tableExport'] = $this->M_exportreport->exportCatItem($Cat_Name, $Item_Name);

    }
    if(empty($Name) && empty($Cat_Name) && isset($Item_Name))
    {
      // echo"3";die;

      $data['tableExport'] = $this->M_exportreport->exportItemNam($Item_Name);

    }
    if(isset($Name) && empty($Cat_Name) && isset($Item_Name))
    {
      // echo"13";die;

      $data['tableExport'] = $this->M_exportreport->exportItemName($Name, $Item_Name);

    }

    // echo "<pre>";
    // print_r($data['tableExport']);
    // die;

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('ECommerce/V_ExportReportTable',$data);
    $this->load->view('V_Footer',$data);
  }

  public function getItemByDate()
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    //$data['user'] = $usr;
    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $data['NamaUser'] = $this->M_exportreport->getUser();
    $data['ItemCat'] = $this->M_exportreport->getItemCat();
    $data['ItemName'] = $this->M_exportreport->getItemName();

    $dateFrom   = $this->input->post('dateBegin');
    $data['dateFrom'] = $dateFrom;

    $dateTo     = $this->input->post('dateEnd');
    $data['dateTo'] = $dateTo;
    // echo "<pre>";print_r($dateFrom);print_r($dateTo);die;

    // $datenewf = str_replace('/', '-', $dateFrom);  
    // $datenewt = str_replace('/', '-', $dateTo); 

    $newDateFrom = date("Y-m-d", strtotime($dateFrom)); 
    $newDateTo = date("Y-m-d", strtotime($dateTo));  

    // echo "<pre>";print_r($newDateFrom);print_r($newDateTo);
      
    $data['tableExcelDate'] = $this->M_exportreport->exportAllDate($newDateFrom,$newDateTo);
    $data['tableExport'] = '1' ;
      
    // echo "<pre>";print_r($data['tableExcelDate']);

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('ECommerce/V_ExportReportTable',$data);
    $this->load->view('V_Footer',$data);
  }

  public function getItemByDateExport()
  {
    $this->load->library('Excel');

    $objPHPExcel = new PHPExcel();

    $style_col = array(
      'font' => array('bold' => true),
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
      )
    );

    $style_row = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
      )
    );

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT PELANGGAN DARI TOKOQUICK");
    $objPHPExcel->getActiveSheet()->mergeCells('A1:V2');
    $objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
    $objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
    $objPHPExcel->getActiveSheet()->mergeCells('C3:C4');
    $objPHPExcel->getActiveSheet()->mergeCells('D3:D4');
    $objPHPExcel->getActiveSheet()->mergeCells('E3:E4');
    $objPHPExcel->getActiveSheet()->mergeCells('F3:F4');
    $objPHPExcel->getActiveSheet()->mergeCells('G3:G4');
    $objPHPExcel->getActiveSheet()->mergeCells('H3:H4');
    $objPHPExcel->getActiveSheet()->mergeCells('I3:M3');
    $objPHPExcel->getActiveSheet()->mergeCells('N3:N4');
    $objPHPExcel->getActiveSheet()->mergeCells('O3:O4');
    $objPHPExcel->getActiveSheet()->mergeCells('P3:P4');
    $objPHPExcel->getActiveSheet()->mergeCells('Q3:Q4');
    $objPHPExcel->getActiveSheet()->mergeCells('R3:R4');
    $objPHPExcel->getActiveSheet()->mergeCells('S3:S4');
    $objPHPExcel->getActiveSheet()->mergeCells('T3:T4');
    $objPHPExcel->getActiveSheet()->mergeCells('U3:U4');
    $objPHPExcel->getActiveSheet()->mergeCells('V3:V4');
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A3:V4')->getFill()->applyFromArray(
      array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => 'E9ECEB')
      )
    );

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Nomor Order");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "Tgl Pemesanan");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Status Order");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "Nama Pelanggan");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "Email");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "Customer Category");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "Registration Date");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "No.Telp");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "Shipping Address");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "Alamat");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Kecamatan");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4', "Kota/Kabupaten");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4', "Provinsi");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M4', "Kode Pos");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "Order Item Code");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "Order Item Name");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "Category");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q3', "Harga Per Pcs");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3', "Qty Beli");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S3', "Berat Per Item");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T3', "Expedisi (Pengiriman)");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U3', "Biaya Kirim");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V3', "Metode Pembayaran");

    foreach(range('A','V') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
      ->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle($columnID.'3')->applyFromArray($style_col);
    } 
    foreach(range('A','V') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
    foreach(range('I','M') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
      ->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle($columnID.'4')->applyFromArray($style_col);
    }
    foreach(range('I','M') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
    foreach(range('A','V') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
      ->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle($columnID.'4')->applyFromArray($style_col);
    }
    foreach(range('A4','V4') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }

    $dateFrom   = $this->input->post('dateBegin');
    $data['dateFrom'] = $dateFrom;

    $dateTo     = $this->input->post('dateEnd');
    $data['dateTo'] = $dateTo;

    // $datenewf = str_replace('/', '-', $dateFrom);  
    $newDateFrom = date("Y-m-d", strtotime($dateFrom));

    // $datenewt = str_replace('/', '-', $dateTo);  
    $newDateTo = date("Y-m-d", strtotime($dateTo));  

    // echo "<pre>";print_r($newDateFrom);print_r($newDateTo);
    $dataReport = $this->M_exportreport->exportAllDate($newDateFrom,$newDateTo);

    // echo "<pre>";print_r($dataReport);

    $no = 1;
    $numrow = 5;
    foreach($dataReport as $data)
    {
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $data['order_id']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['tgl_pesanan']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['post_status']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['display_name']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['user_email']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['customer_category']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['user_registered']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['phone_number']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['shipping_addreas_1']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['shipping_addreas_2']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data['shipping_city']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data['shipping_state']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $data['shipping_postcode']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $data['sku']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $data['item']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $data['cat_name']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow,'Rp '. number_format($data['harsat'],2, ",", "."));
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $data['qty']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $data['berat']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $data['ekspedisi']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$numrow,'Rp '. number_format($data['biaya_kirim'], 2, ",", "."));
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, $data['metode_bayar']);

      $objPHPExcel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('U'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('V'.$numrow)->applyFromArray($style_row);

      $no++;
      $numrow++;
    }
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(false);

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(23);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(23);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
    $today = date("m.d.y");
    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle('Admin Digital E-Commerce');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Report Excel E-Commerse'.$today.'.xlsx"');
    $objWriter->save("php://output");
  }

  public function exportexcel()
  {
    $this->load->library('Excel');

    $objPHPExcel = new PHPExcel();

    $style_col = array(
      'font' => array('bold' => true),
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
      )
    );

    $style_row = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
      )
    );

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT PELANGGAN DARI TOKOQUICK");
    $objPHPExcel->getActiveSheet()->mergeCells('A1:M2');
    $objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
    $objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
    $objPHPExcel->getActiveSheet()->mergeCells('C3:C4');
    $objPHPExcel->getActiveSheet()->mergeCells('D3:D4');
    $objPHPExcel->getActiveSheet()->mergeCells('E3:E4');
    $objPHPExcel->getActiveSheet()->mergeCells('F3:J3');
    $objPHPExcel->getActiveSheet()->mergeCells('K3:K4');
    $objPHPExcel->getActiveSheet()->mergeCells('L3:L4');
    $objPHPExcel->getActiveSheet()->mergeCells('M3:M4');
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A3:M4')->getFill()->applyFromArray(
      array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => 'E9ECEB')
      )
    );
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "Shipping Address");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Nomor Order");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "Nama Pelanggan");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Email");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "Registration Date");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "No.Telp");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Alamat");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "Kecamatan");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "Kota/Kabupaten");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "Provinsi");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Kode Pos");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "Order Item Code");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "Order Item Name");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "Category");

    foreach(range('A','M') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
      ->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle($columnID.'3')->applyFromArray($style_col);
    }    
    foreach(range('A','M') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
    foreach(range('F','J') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
      ->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle($columnID.'4')->applyFromArray($style_col);
    }
    foreach(range('F','J') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
    foreach(range('A','M') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
      ->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle($columnID.'4')->applyFromArray($style_col);
    }
    foreach(range('A4','M4') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }     

    $Name = $this->input->post('user_id');
    $Cat_Name = $this->input->post('cat_name');
    $Item_Name = $this->input->post('item_name');
    if(isset($Name) && empty($Cat_Name) && empty($Item_Name))
    {
      // echo"1";die;

      $dataReport = $this->M_exportreport->export($Name);

    } 
    if(isset($Name) && isset($Cat_Name) && empty($Item_Name))
    {
      // echo"12";die;
      
      $dataReport = $this->M_exportreport->exportCat($Name, $Cat_Name);
      
    }
    if(isset($Name) && isset($Cat_Name) && isset($Item_Name))
    {
      // echo"123";die;
      
      $dataReport = $this->M_exportreport->exportItem($Name, $Cat_Name, $Item_Name);
      
    }
    if(empty($Name) && isset($Cat_Name) && empty($Item_Name))
    {
      // echo"2";die;
      $dataReport = $this->M_exportreport->exportCatNam($Cat_Name);
      
    }
    if(empty($Name) && isset($Cat_Name) && isset($Item_Name))
    {
      // echo"23";die;
      
      $dataReport = $this->M_exportreport->exportCatItem($Cat_Name, $Item_Name);
      
    }
    if(empty($Name) && empty($Cat_Name) && isset($Item_Name))
    {
      // echo"3";die;
      
      $dataReport = $this->M_exportreport->exportItemNam($Item_Name);
      
    }
    if(isset($Name) && empty($Cat_Name) && isset($Item_Name))
    {
      // echo"13";die;
      
      $dataReport = $this->M_exportreport->exportItemName($Name, $Item_Name);
      
    }
    
    // echo "<pre>";print_r($dataReport);die();
    
    $no = 1;
    $numrow = 5;
    foreach($dataReport as $data)
    {
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $data['nomor_order']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['display_name']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['user_email']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['user_registered']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['phone_number']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['shipping_addreas_1']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['shipping_addreas_2']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['shipping_city']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['shipping_state']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['shipping_postcode']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data['meta_value']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data['order_item_name']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $data['cat_name']);
      
      $objPHPExcel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);

      $no++;
      $numrow++;
    }
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(23);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(17);
    $today = date("m.d.y");
    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
    
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle('Admin Digital E-Commerce');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    // header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    // header("Cache-Control: no-store, no-cache, must-revalidate");
    // header("Cache-Control: post-check=0, pre-check=0", false);
    // header("Pragma: no-cache");
    // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // header('Content-Disposition: attachment;filename="Report Excel E-Commerse'.$today.'.xlsx"');
    $objWriter->save("php://output");
  }

  public function tableExportAll()
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    //$data['user'] = $usr;
    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';
    
    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    // $Name = $this->input->post('user_id');
    // $Cat_Name = $this->input->post('cat_name');
    // $Item_Name = $this->input->post('item_name');

    // $data['NamaUser'] = $this->M_exportreport->getUser();
    // $data['ItemCat'] = $this->M_exportreport->getItemCat();
    // $data['ItemName'] = $this->M_exportreport->getItemName();
    $id= $this->M_exportreport->exportAll();  
    // echo($Name);
    // echo($Cat_Name);
    // echo($Item_Name);
    // $id = $this->M_productcomponent->infoGambarComponent($gambar);
    
    // echo "<pre>";
    // print_r(id);
    // die;

    $data = [];
    $no = 1;
    foreach($id as $row)
    {
      $sub_array = [];
      $sub_array[] = '<center>'.$no++.'</center>';
      $sub_array[] = $row['order_id'];
      $sub_array[] = $row['tgl_pesanan'];
      $sub_array[] = $row['post_status'];
      $sub_array[] = $row['display_name'];
      $sub_array[] = $row['user_email'];
      $sub_array[] = $row['customer_category'];
      $sub_array[] = $row['user_registered'];
      $sub_array[] = $row['phone_number'];
      $sub_array[] = $row['shipping_addreas_1'];
      $sub_array[] = $row['shipping_addreas_2'];
      $sub_array[] = $row['shipping_city'];
      $sub_array[] = $row['shipping_state'];
      $sub_array[] = $row['shipping_postcode'];
      $sub_array[] = $row['sku'];
      $sub_array[] = $row['item'];
      $sub_array[] = $row['cat_name'];
      $sub_array[] = 'Rp ' .number_format($row['harsat'], 2, ",", ".");
      $sub_array[] = $row['qty'];
      $sub_array[] = $row['berat'];
      $sub_array[] = $row['ekspedisi'];
      $sub_array[] = 'Rp ' .number_format($row['biaya_kirim'], 2, ",", ".");
      $sub_array[] = $row['metode_bayar'];

      $data[] = $sub_array;

    }
    $output = 
    [
      'data' => $data
    ];
    die($this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($output))
        ->_display());   
    
    // $this->load->view('V_Header',$data);
    // $this->load->view('V_Sidemenu',$data);
    // $this->load->view('ECommerce/V_ExportReport',$data);
    // $this->load->view('V_Footer',$data);
  }

  public function exportexcelAll()
  {
    $this->load->library('Excel');

    $objPHPExcel = new PHPExcel();

    $style_col = array(
      'font' => array('bold' => true),
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
      )
    );

    $style_row = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
      )
    );

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT PELANGGAN DARI TOKOQUICK");
    $objPHPExcel->getActiveSheet()->mergeCells('A1:V2');
    $objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
    $objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
    $objPHPExcel->getActiveSheet()->mergeCells('C3:C4');
    $objPHPExcel->getActiveSheet()->mergeCells('D3:D4');
    $objPHPExcel->getActiveSheet()->mergeCells('E3:E4');
    $objPHPExcel->getActiveSheet()->mergeCells('F3:F4');
    $objPHPExcel->getActiveSheet()->mergeCells('G3:G4');
    $objPHPExcel->getActiveSheet()->mergeCells('H3:H4');
    $objPHPExcel->getActiveSheet()->mergeCells('I3:M3');
    $objPHPExcel->getActiveSheet()->mergeCells('N3:N4');
    $objPHPExcel->getActiveSheet()->mergeCells('O3:O4');
    $objPHPExcel->getActiveSheet()->mergeCells('P3:P4');
    $objPHPExcel->getActiveSheet()->mergeCells('Q3:Q4');
    $objPHPExcel->getActiveSheet()->mergeCells('R3:R4');
    $objPHPExcel->getActiveSheet()->mergeCells('S3:S4');
    $objPHPExcel->getActiveSheet()->mergeCells('T3:T4');
    $objPHPExcel->getActiveSheet()->mergeCells('U3:U4');
    $objPHPExcel->getActiveSheet()->mergeCells('V3:V4');
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A3:V4')->getFill()->applyFromArray(
      array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => 'E9ECEB')
      )
    );

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Nomor Order");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "Tgl Pemesanan");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Status Order");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "Nama Pelanggan");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "Email");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "Customer Category");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "Registration Date");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "No.Telp");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "Shipping Address");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "Alamat");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Kecamatan");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4', "Kota/Kabupaten");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4', "Provinsi");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M4', "Kode Pos");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "Order Item Code");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "Order Item Name");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "Category");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q3', "Harga Per Pcs");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3', "Qty Beli");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S3', "Berat Per Item");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T3', "Expedisi (Pengiriman)");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U3', "Biaya Kirim");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V3', "Metode Pembayaran");

    foreach(range('A','V') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
      ->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle($columnID.'3')->applyFromArray($style_col);
    } 
    foreach(range('A','V') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
    foreach(range('I','M') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
      ->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle($columnID.'4')->applyFromArray($style_col);
    }
    foreach(range('I','M') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
    foreach(range('A','V') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
      ->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle($columnID.'4')->applyFromArray($style_col);
    }
    foreach(range('A4','V4') as $columnID) 
    {
      $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }

    $dataReport = $this->M_exportreport->exportAll();

    // echo "<pre>";print_r($dataReport);

    $table = [];
    foreach($dataReport as $row)
    {
      $sub_array = [];
      $sub_array['order_id'] = $row['order_id'];
      $sub_array['tgl_pesanan'] = $row['tgl_pesanan'];
      $sub_array['post_status'] = $row['post_status'];
      $sub_array['display_name'] = $row['display_name'];
      $sub_array['user_email'] = $row['user_email'];
      $sub_array['customer_category'] = $row['customer_category'];
      $sub_array['user_registered'] = $row['user_registered'];
      $sub_array['phone_number'] = $row['phone_number'];
      $sub_array['shipping_addreas_1'] = $row['shipping_addreas_1'];
      $sub_array['shipping_addreas_2'] = $row['shipping_addreas_2'];
      $sub_array['shipping_city'] = $row['shipping_city'];
      $sub_array['shipping_state'] = $row['shipping_state'];
      $sub_array['shipping_postcode'] = $row['shipping_postcode'];
      $sub_array['sku'] = $row['sku'];
      $sub_array['item'] = $row['item'];
      $sub_array['cat_name'] = $row['cat_name'];
      $sub_array['harsat'] = $row['harsat'];
      $sub_array['qty'] = $row['qty'];
      $sub_array['berat'] = $row['berat'];
      $sub_array['ekspedisi'] = $row['ekspedisi'];
      $sub_array['biaya_kirim'] = $row['biaya_kirim'];
      $sub_array['metode_bayar'] = $row['metode_bayar'];

      $table[] = $sub_array;
    }
    // echo "<pre>";
    // print_r($table);
    // die;

    $no = 1;
    $numrow = 5;
    foreach($table as $data)
    {
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $data['order_id']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['tgl_pesanan']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['post_status']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['display_name']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['user_email']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['customer_category']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['user_registered']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['phone_number']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['shipping_addreas_1']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['shipping_addreas_2']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data['shipping_city']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data['shipping_state']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $data['shipping_postcode']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $data['sku']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $data['item']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $data['cat_name']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow,'Rp '. number_format($data['harsat'], 2, ",","."));
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $data['qty']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $data['berat']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $data['ekspedisi']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$numrow,'Rp '. number_format($data['biaya_kirim'], 2, ",","."));
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, $data['metode_bayar']);

      $objPHPExcel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('U'.$numrow)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('V'.$numrow)->applyFromArray($style_row);

      $no++;
      $numrow++;
    }
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(false);
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(false);

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(23);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(23);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
    $today = date("m.d.y");
    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle('Admin Digital E-Commerce');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Report Excel E-Commerse'.$today.'.xlsx"');
    $objWriter->save("php://output");
  }
}