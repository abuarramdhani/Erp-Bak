<?php
Defined('BASEPATH') or exit('No direct script accsess allowed');
/**
 * 
 */
set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_SetupPuasa extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CateringManagement/Puasa/M_setuppuasa');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Setup Puasa';
		$data['Menu'] = 'Puasa';
		$data['SubMenuOne'] = 'Setup Puasa';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['muslim'] = $this->M_setuppuasa->getMuslimTidakPuasa();
		$data['nonmuslim'] = $this->M_setuppuasa->getNonMuslimPuasa();
		
		if (isset($_GET['ket']) && isset($_GET['noind'])) {
			$data['ket'] = $_GET['ket'];
			$data['noind'] = $_GET['noind'];
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Puasa/SetupPuasa/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Download(){
		$this->load->library('excel');

		$dataP = $this->M_setuppuasa->getPekerjaAll();
		$this->excel->getActiveSheet()->setCellValue('A1','Noind');
		$this->excel->getActiveSheet()->setCellValue('B1','Nama');
		$this->excel->getActiveSheet()->setCellValue('C1','Seksi');
		$this->excel->getActiveSheet()->setCellValue('D1','Unit');
		$this->excel->getActiveSheet()->setCellValue('E1','Bidang');
		$this->excel->getActiveSheet()->setCellValue('F1','Dept');
		$this->excel->getActiveSheet()->setCellValue('G1','Agama');
		$this->excel->getActiveSheet()->setCellValue('H1','Puasa');
		$index_x = 2;
		if (!empty($dataP)) {
			foreach ($dataP as $dt) {
				$this->excel->getActiveSheet()->setCellValue('A'.$index_x,$dt['noind']);
				$this->excel->getActiveSheet()->setCellValue('B'.$index_x,$dt['nama']);
				$this->excel->getActiveSheet()->setCellValue('C'.$index_x,$dt['seksi']);
				$this->excel->getActiveSheet()->setCellValue('D'.$index_x,$dt['unit']);
				$this->excel->getActiveSheet()->setCellValue('E'.$index_x,$dt['bidang']);
				$this->excel->getActiveSheet()->setCellValue('F'.$index_x,$dt['dept']);
				$this->excel->getActiveSheet()->setCellValue('G'.$index_x,$dt['agama']);
				$this->excel->getActiveSheet()->setCellValue('H'.$index_x,$dt['puasa']);
				$index_x++;
			}
		}

		$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

		$this->excel->getActiveSheet()->duplicateStyleArray(
					array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_HAIR)
						),
						'alignment' => array(
							'wrap' => true,
							'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
						)
					),'A1:H'.($index_x - 1));
		$this->excel->getActiveSheet()->duplicateStyleArray(
					array(
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
						),
						'fill' =>array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'startcolor' => array(
								'argb' => '00ffff00')
						)
					),'A1:H1');

		$this->excel->getActiveSheet()->freezePaneByColumnAndRow(2, 2);

		$filename ='Daftar_Puasa_Pekerja.xls';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		ob_end_clean();

		$writer->save('php://output');
	}

	public function Upload(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Setup Puasa';
		$data['Menu'] = 'Puasa';
		$data['SubMenuOne'] = 'Setup Puasa';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		if (isset($_GET['ket'])) {
			$data['ket'] = $_GET['ket'];
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Puasa/SetupPuasa/V_upload',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SaveUpload(){
		$this->load->library('upload');
		$this->load->library('excel');

		$noind = $this->session->user;
		if (!empty($_FILES['flPuasaPekerja']['name'])) {
			$direktori						= $_FILES['flPuasaPekerja']['name'];
			$ekstensi						= pathinfo($direktori,PATHINFO_EXTENSION);
			$xls							= "CM-PekerjaPuasa-".$noind."-".str_replace(' ', '_', date('Y-m-d H:i:s')).".".$ekstensi;
			$config['upload_path']          = './assets/upload/CateringManagement/SetupPuasa';
			$config['allowed_types']        = 'xls';
        	$config['file_name']		 	= $xls;
        	$config['overwrite'] 			= TRUE;
        	$this->upload->initialize($config);
    		if ($this->upload->do_upload('flPuasaPekerja'))
    		{
        		$this->upload->data();
    		}
    		else
    		{
    			$errorinfo = $this->upload->display_errors();
    			echo $errorinfo;
    		}

    		$objPHPExcel = PHPExcel_IOFactory::load("./assets/upload/CateringManagement/SetupPuasa/".$xls);
    		$sheet = $objPHPExcel->getSheet(0);
    		$highestRow = $sheet->getHighestRow();
    		$highestColumn = $sheet->getHighestColumn();

			$rowData = $sheet->rangeToArray('A2:'.$highestColumn.$highestRow,null,true,false);
			// echo "<pre>";print_r($rowData);
			foreach ($rowData as $dt) {
				$noind = $dt['0'];
				$status = $dt['7'];

				$stat = array("TIDAK PUASA","PUASA");
				if (in_array($status, $stat)) {
					$this->M_setuppuasa->updatePuasaByNoind($noind,array_search($status, $stat, true));
				}
			}

			redirect(base_url('CateringManagement/Puasa/Setup/Upload?ket=sukses'));
    	}else{
    		redirect(base_url('CateringManagement/Puasa/Setup/Upload?ket=empty'));
    	}
	}

	public function Puasa(){
		$noind = $this->input->get('noind');

		$this->M_setuppuasa->updatePuasaByNoind($noind,'1');

		redirect(base_url('CateringManagement/Puasa/Setup?ket=sukses&noind='.$noind));
	}

	public function TidakPuasa(){
		$noind = $this->input->get('noind');

		$this->M_setuppuasa->updatePuasaByNoind($noind,'0');

		redirect(base_url('CateringManagement/Puasa/Setup?ket=sukses&noind='.$noind));
	}

}

?>	