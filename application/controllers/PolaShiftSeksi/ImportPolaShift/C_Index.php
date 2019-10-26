<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Index extends CI_Controller
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

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PolaShiftSeksi/ImportPolaShift/M_index');

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
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;

		// echo "<pre>";
		// print_r($user_id);exit();

		$data['Title'] = 'Import Pola Shift';
		$data['Menu'] = 'Catering Management ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PolaShiftSeksi/ImportPolaShift/V_Index', $data);
		$this->load->view('V_Footer',$data);

	}

	public function daftar_seksi()
	{
		$keyword 	 	=	strtoupper($this->input->get('term', TRUE));
		$tseksi			=	$this->M_index->tseksi($keyword);
		echo json_encode($tseksi);
	}

	public function DocumentProcess()
	{
		$PeriodeShift			=	$this->input->post('periodeshift');
		$KodeSeksi				=	$this->input->post('kodeseksi');
		$ImportDocument			=	$this->input->post('importdocument');
		// echo "<pre>"; print_r($PeriodeShift); echo "<pre>"; print_r($KodeSeksi); echo "<pre>";print_r($ImportDocument); exit();

		$file = $_FILES['importdocument']['tmp_name'];
		// echo $file;
		$this->load->library(array('Excel','Excel/PHPExcel/IOFactory'));
		$objPHPExcel = PHPExcel_IOFactory::createReaderForFile($file);
		// $objPHPExcel = new PHPExcel();
		$objPHPExcel->setReadDataOnly(true);

		$inputFileType = PHPExcel_IOFactory::identify($file);
	    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
	    // $objPHPExcel = $objReader->load($inputFileName);

		$objPHPExcel = $objPHPExcel->load($file);
		// exit();
		$objWorksheet = $objPHPExcel->getActiveSheet();

		$readData = array();
		$tmpData = array();
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$worksheetTitle = $worksheet->getTitle();
			$highestRow = $worksheet->getHighestRow();
			$highestColumn =  $worksheet->getHighestColumn();
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			// $nsColumn = ord($highestColumn) - 64;
			$index = 0;
			$data = array();

			for ($row=2; $row <= $highestRow ; $row++) {
				$val = array();
				for ($col=0; $col <= $highestColumnIndex ; $col++) {
					$cell = $worksheet->getCellByColumnAndRow($col, $row);
					$val[]= $cell->getValue();
				}

			$hmm[] = $val;
			}
		}
		$data['document'] = $hmm;
		// echo "<pre>";print_r($data['document']); exit();

		$daftarnoind			=	$this->M_index->ambilDaftarnoind($KodeSeksi, $PeriodeShift);
		// echo "<pre>";print_r($daftarnoind); exit();
		$datapekerja = array();
		foreach ($daftarnoind as $noind) {
			$id 		=	$noind['noind'];
			$polashift[$id]	=	$this->M_index->ambilDaftarPolaShift($KodeSeksi, $PeriodeShift, $id);
		}

		// echo "<pre>";print_r($polashift); exit();

		$data['polashift'] = $polashift;

		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;

		$data['Title'] = 'Import Pola Shift';
		$data['Menu'] = 'Catering Management ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PolaShiftSeksi/ImportPolaShift/V_Process', $data);
		$this->load->view('V_Footer',$data);
	
	}

}
?>
