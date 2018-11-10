<?php defined('BASEPATH')OR die('No direct script access allowed');
class C_Report extends CI_Controller
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	        $this->load->library('Excel');
	          //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('SystemIntegration/M_report');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}

		}

	public function checkSession()
		{
			if ($this->session->is_logged) {
			}else{
				redirect();
			}
		}

	public function index()
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['complexTextAreaCKEditor']	=	FALSE;
			$getMember = $this->M_report->getMember($this->session->kodesie);
			$sectionName = $getMember[0]['seksi'];
			$data['data_seksi'] = $getMember;
			$data['seksi'] = $sectionName;		
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SystemIntegration/MainMenu/Report/V_Index',$data);
			$this->load->view('V_Footer',$data);
			$this->load->view('SystemIntegration/MainMenu/Report/V_Chart',$data);

		}

	public function exportKaizen()
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['complexTextAreaCKEditor']	=	FALSE;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SystemIntegration/MainMenu/Report/V_ExportKaizen',$data);
			$this->load->view('V_Footer',$data);

		}

	public function findexport()
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$this->input->post('txtStartDate');
			$this->input->post('txtEndDate');
			
			$start = date("Y-m-d", strtotime($this->input->post('txtStartDate')));
			$end   = date("Y-m-d", strtotime($this->input->post('txtEndDate')));
			$data['find'] = $this->M_report->getKaizenExport($start, $end);
			$data['start'] = $start;
			$data['end'] = $end;

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SystemIntegration/MainMenu/Report/V_ExportKaizen',$data);
			$this->load->view('V_Footer',$data);
		}

	public function export()
	{
		$start = date("Y-m-d", strtotime($this->input->post('txtStartDate')));
		$end   = date("Y-m-d", strtotime($this->input->post('txtEndDate')));
		
		// $realisasi=$this->input->post('txtRealisasi');
		$data = $this->M_report->getKaizenExport($start, $end);

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("CV. KHS")->setTitle("QUICK");
 
		$objset = $objPHPExcel->setActiveSheetIndex(0);
		$objget = $objPHPExcel->getActiveSheet();
		$objget->setTitle('Sample Sheet');
		$objget->getStyle("A1:I1")->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '92d050')
				),
				'font' => array(
					'color' => array('rgb' => '000000'),
					'bold'  => true,
				)
			)
		);

		$cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I");
		$val = array("No", "No Kaizen" , "Judul", "Kondisi Awal", "Kondisi Setelah Kaizen", "Pertimbangan", "PIC", "Departemen" , "Tanggal Lapor");

		for ($a=0;$a<9; $a++) {
			$objset->setCellValue($cols[$a].'1', $val[$a]);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			$objPHPExcel->getActiveSheet()->getStyle($cols[$a].'1')->applyFromArray($style);
		}

		$baris  = 2;
		$no = 1;
		foreach ($data as $frow) {
			$objset->setCellValue("A".$baris, $no);
			$objset->setCellValue("B".$baris, $frow['no_kaizen']);
			$objset->setCellValue("C".$baris, $frow['judul']);
			$objset->setCellValue("D".$baris, strip_tags($frow['kondisi_awal']));
			$objset->setCellValue("E".$baris, strip_tags($frow['usulan_kaizen']));
			$objset->setCellValue("F".$baris, $frow['pertimbangan']);
			$objset->setCellValue("G".$baris, $frow['pencetus']);
			$objset->setCellValue("H".$baris, $frow['department_name']);
			$objset->setCellValue("I".$baris, '');

			$no++;
			$baris++;
		}

		$objPHPExcel->getActiveSheet()->setTitle('Data Export');

		$objPHPExcel->setActiveSheetIndex(0);  
		$filename = urlencode("Kaizen.xls");

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');                
		$objWriter->save('php://output');
	}
}