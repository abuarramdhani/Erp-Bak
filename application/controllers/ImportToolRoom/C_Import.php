<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Import extends CI_Controller
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
		// $this->load->model('ImportToolRoom/M_import');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Import Excel';
		$data['Menu'] = 'Import Excel';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ImportToolRoom/V_Import');
		$this->load->view('V_Footer',$data);
	}

	public function importsheet(){
		require_once APPPATH.'third_party/Excel/PHPExcel.php';
		require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';
			$dataini = array();
			$file_data  = array();
			 // load excel
			$file = $_FILES['excel_file']['tmp_name'];
			$load = PHPExcel_IOFactory::load($file);
			$countsheet = $load->getSheetCount();
			for ($x=0; $x < ($countsheet - 1) ; $x++) { 
				$sheet = $load->getSheet($x)->toArray(null,true,true,true);
				$i=1;
				$data1 = array();
				foreach($sheet as $row) {
					if ($i == 1 || $i == 2) {
					}else {
						if (!empty($row['A'])) {
							$array = array(
								'item' => $row['B'],
								'desc' => $row['C'],
							);
							array_push($data1, $array);
						}
					}
					$i++;
					}
				array_push($dataini, $data1);
				// echo "<pre>";print_r($dataini);exit();
			}

//--------------------------------------------------------------------------------------------------- PDF
			ob_start();
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8',array(295,210), 0, '', 13, 13, 0, 5, 0, 0);
			$filename 	= 'ImportToolRoom.pdf';
			// $tglNama = date("d/m/Y");

			$this->load->library('ciqrcode');

			if(!is_dir('./img'))
			{
				mkdir('./img', 0777, true);
				chmod('./img', 0777);
			}
			
			foreach ($dataini as $get) {
				foreach ($get as $val) {
				$params['data']		= $val['item'];
				$params['level']	= 'H';
				$params['size']		= 10;
				$params['black']	= array(255,255,255);
				$params['white']	= array(0,0,0);
				$params['savename'] = './img/'.($val['item']).'.png';
				$this->ciqrcode->generate($params);
				}
			}
			$x = 0;
			foreach ($dataini as $val) {
				$data['data'] = $val;
				$data['urut'] = $x;
				$html = $this->load->view('ImportToolRoom/V_pdfimport', $data, true);
				ob_end_clean();
				$pdf->WriteHTML($html);			
				$x++;
			}									
				$pdf->Output($filename, 'I');
	}



}