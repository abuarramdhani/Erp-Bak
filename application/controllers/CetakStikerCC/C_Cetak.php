<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Cetak extends CI_Controller
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
		$this->load->model('CetakStikerCC/M_cetak');

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
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Cetak Stiker Cost Center';
		$data['Menu'] = 'Cetak';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CetakStikerCC/V_Input');
		$this->load->view('V_Footer',$data);
	}

	public function format_date($date)
	{
		$ss = explode("/",$date);
		return $ss[2]."-".$ss[1]."-".$ss[0];
	}

	function suggestions()
	{
		
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_cetak->getDataCost($term);
		echo json_encode($data);
		// Console.log ($term)

	}


	function getItemDetail(){
		$param = $this->input->post('params');
		// baris 
		$last = end($param);
		// echo "<pre>";
		// print_r($last);
		// exit();
		$data = $this->M_cetak->getData($last);
		$html_select = '';
		echo json_encode($data);
		// 
	}

	public function Insert() {
		redirect(base_url('CetakStikerCC/Report/'));
	//-----------------------END CODE----------------------------------------
	} 
	public function Report()
	{
		ob_start();

		$center = $_POST['center'];
		$seksi = $_POST['seksi'];
		$tag = $_POST['tag'];
		$kode = $_POST['kode'];
		$desc = $_POST['desc'];
		$tgl = $_POST['tgl'];

		$data['center'] = $center;
		$data['seksi'] = $seksi;
		$data['tag'] = $tag;
		$data['kode'] = $kode;
		$data['desc'] = $desc;
		$data['tgl'] = $tgl;

		$this->load->library('pdf');
		// $mpdf->useFixedNormalLineHeight = false;
		// $mpdf->useFixedTextBaseline = false;
		// $mpdf->adjustFontDescLineheight = 0.5;
		$pdf = $this->pdf->load();
    	$pdf = new mPDF('utf-8',array(297,210), 0, '', 10, 0, 4, 0, 0, 0); //----- A5-L
		// $tglNama = date("d/m/Y");
    	$filename = 'Stiker Cost Center'.'.pdf';
    	$html = $this->load->view('CetakStikerCC/V_Print', $data, true);		//-----> Fungsi Cetak PDF
    	ob_end_clean();
    	$pdf->WriteHTML($html);												//-----> Pakai Library MPDF
    	$pdf->Output($filename, 'I');
    }
	
	public function Import(){
		// $this->checkSession();
		// $user_id = $this->session->userid;

		// $data['Menu'] = 'Dashboard';
		// $data['SubMenuOne'] = '';
		// $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		// $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		// $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		// $data['data_input']  = array();
		
		// $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);

		// for ($i=0; $i < sizeof($file_data); $i++) { 
		// 		$data['cc'] = $file_data[$i]['COST_CENTER'];
		// 		$data['temp'][$i] = $this->M_cetak->getAtta($data['cc']);
		// }

		// for ($a=0; $a < sizeof($data['cc']); $a++) { 
		// 	$o =  $data['temp'];
		// }

		// $datalist['list'] = $o;

		// $this->load->view('V_Header',$data);
		// $this->load->view('V_Sidemenu',$data);
		// $this->load->view('CetakStikerCC/V_Tabel',$datalist);
		// $this->load->view('V_Footer',$data);
	// }

		require_once APPPATH.'third_party/Excel/PHPExcel.php';
     	require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';

     	$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['data_input']  = array();
     
		$file_data  = array();
		 // load excel
		  $file = $_FILES['excel_file']['tmp_name'];
		  $load = PHPExcel_IOFactory::load($file);
		  $sheets = $load->getActiveSheet()->toArray(null,true,true,true);

		$i=0;
	  	foreach($sheets as $row) {
		 //   $a = array($row['A']
			// );
		   	if ($i != 0) {
		   		$file_data[] = $row['A'];
		   	}
		   	$i++;
	  	}

	  	for ($i=0; $i < sizeof($file_data); $i++) { 
				$data['cc'] = $file_data[$i];
				$data['temp'][$i] = $this->M_cetak->getAtta($data['cc']);
		}
	 	

		for ($a=0; $a < sizeof($data['cc']); $a++) { 
		$o =  $data['temp'];
		}

		$datalist['list'] = $o;
		
		// echo "<pre>";
		// print_r($datalist['list']);
		// exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CetakStikerCC/V_Tabel',$datalist);
		$this->load->view('V_Footer',$data);
	}

public function Export(){

	require_once APPPATH.'third_party/Excel/PHPExcel.php';
	require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';

		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

	$worksheet->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "COST_CENTER");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "7H02");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "7K01");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "7J35");

	$worksheet->getStyle('A1')->getFont()->setSize(12); 
	$worksheet->getStyle('A2')->getFont()->setSize(12); 
	$worksheet->getStyle('A3')->getFont()->setSize(12); 
	$worksheet->getStyle('A4')->getFont()->setSize(12); 

	$worksheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$worksheet->getDefaultRowDimension()->setRowHeight(-1);
	$worksheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$worksheet->setTitle('CostCenter');
	$objPHPExcel->setActiveSheetIndex(0);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="LayoutCostCenter.xls"');
	ob_end_clean();
	$objWriter->save("php://output");



}




}