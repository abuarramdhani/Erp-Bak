<?php
Defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 
 */
class C_Simple extends Ci_Controller
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
		$this->load->model('WasteManagement/MainMenu/M_simple');

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
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'SIMPLE';
		$data['Menu'] = 'Kelola Limbah';
		$data['SubMenuOne'] = 'SIMPLE';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['SimpleData'] = $this->M_simple->getSimpleData();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/Simple/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Read($id){

		$plain_text = str_replace(array('-','_','~'), array('+','/','='), $id);
		$plain_text = $this->encrypt->decode($plain_text);
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'SIMPLE Detail';
		$data['Menu'] = 'Kelola Limbah';
		$data['SubMenuOne'] = 'SIMPLE';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['DetailBelum'] = $this->M_simple->getLimbahKirimByID0($plain_text);
		$data['idSimple'] = $id;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/Simple/V_detail', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Proses(){
		$status = $this->input->post('statusButton');
		$id = $this->input->post('txtInsert');
		$textID = "";
		foreach ($id as $key) {
			if ($textID == '') {
				$textID = "'".$key."'";
			}else{
				$textID = $textID.",'".$key."'";
			}
		}

		if ($status == 'Delete') {
			$this->M_simple->getDeleteKirimInsertBackup($textID);
			echo "	<script type='text/javascript'>
						window.close('_self');
					</script>";
		}else{
			$this->load->library('excel');

			$this->M_simple->updateStatus($textID);

			$simple = $this->M_simple->getExport($textID);

			$this->excel->setActiveSheetIndex(0);

			$this->excel->getActiveSheet()->setTitle('Simple');
			$this->excel->getActiveSheet()->setCellValue('A1', 'Kode Limbah');
			$this->excel->getActiveSheet()->setCellValue('B1', 'Tanggal Dihasilkan/Dikirim');
			$this->excel->getActiveSheet()->setCellValue('C1', 'Masa Simpan (Hari)');
			$this->excel->getActiveSheet()->setCellValue('D1', 'TPS');
			$this->excel->getActiveSheet()->setCellValue('E1', 'Sumber Limbah');
			$this->excel->getActiveSheet()->setCellValue('F1', 'Kode Manifest');
			$this->excel->getActiveSheet()->setCellValue('G1', 'Nama Penghasil/Pengirim');
			$this->excel->getActiveSheet()->setCellValue('H1', 'Jumlah (TON)');
			$this->excel->getActiveSheet()->setCellValue('I1', 'Catatan');

			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

			$this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				)
			);
			$border = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_style_border::BORDER_THIN
					)
				)
			);
			$this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getDefaultStyle()->applyFromArray($style);
			$a = 2;
			foreach ($simple as $row) {
				$this->excel->getActiveSheet()->setCellValue('A'.$a, $row['kode_limbah']);
				$this->excel->getActiveSheet()->setCellValue('B'.$a, $row['tanggal_dihasilkan']);
				$this->excel->getActiveSheet()->setCellValue('C'.$a, $row['masa_simpan']);
				$this->excel->getActiveSheet()->setCellValue('D'.$a, $row['tps']);
				$this->excel->getActiveSheet()->setCellValue('E'.$a, $row['sumber']);
				$this->excel->getActiveSheet()->setCellValue('F'.$a, $row['kode_manifest']);
				$this->excel->getActiveSheet()->setCellValue('G'.$a, $row['pengirim_nama']);
				$this->excel->getActiveSheet()->setCellValue('H'.$a, $row['jumlah']);
				$this->excel->getActiveSheet()->setCellValue('I'.$a, $row['catatan']);
				$a++;
			}
			$a -= 1;
			$this->excel->getActiveSheet()->getStyle('A1:I'.$a)->applyFromArray($border);
			$filename ='SIMPLE.xls';
			header('Content-Type: aplication/vnd.ms-excel');
			header('Content-Disposition:attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');

			$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
			$writer->save('php://output');
		}

	}
	
	public function ExportAll($id){
		$this->load->library('excel');
		$plain_text = str_replace(array('-','_','~'), array('+','/','='), $id);
		$plain_text = $this->encrypt->decode($plain_text);
		$id = $plain_text;

		$simple = $this->M_simple->getExportAll($id);

		$this->excel->setActiveSheetIndex(0);

		$this->excel->getActiveSheet()->setTitle('Simple');
		$this->excel->getActiveSheet()->setCellValue('A1', 'Kode Limbah');
		$this->excel->getActiveSheet()->setCellValue('B1', 'Tanggal Dihasilkan/Dikirim');
		$this->excel->getActiveSheet()->setCellValue('C1', 'Masa Simpan (Hari)');
		$this->excel->getActiveSheet()->setCellValue('D1', 'TPS');
		$this->excel->getActiveSheet()->setCellValue('E1', 'Sumber Limbah');
		$this->excel->getActiveSheet()->setCellValue('F1', 'Kode Manifest');
		$this->excel->getActiveSheet()->setCellValue('G1', 'Nama Penghasil/Pengirim');
		$this->excel->getActiveSheet()->setCellValue('H1', 'Jumlah (TON)');
		$this->excel->getActiveSheet()->setCellValue('I1', 'Catatan');

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

		$this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		$style = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
			)
		);
		$border = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_style_border::BORDER_THIN
				)
			)
		);
		$this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getDefaultStyle()->applyFromArray($style);
		$a = 2;
		foreach ($simple as $row) {
			$this->excel->getActiveSheet()->setCellValue('A'.$a, $row['kode_limbah']);
			$this->excel->getActiveSheet()->setCellValue('B'.$a, $row['tanggal_dihasilkan']);
			$this->excel->getActiveSheet()->setCellValue('C'.$a, $row['masa_simpan']);
			$this->excel->getActiveSheet()->setCellValue('D'.$a, $row['tps']);
			$this->excel->getActiveSheet()->setCellValue('E'.$a, $row['sumber']);
			$this->excel->getActiveSheet()->setCellValue('F'.$a, $row['kode_manifest']);
			$this->excel->getActiveSheet()->setCellValue('G'.$a, $row['pengirim_nama']);
			$this->excel->getActiveSheet()->setCellValue('H'.$a, $row['jumlah']);
			$this->excel->getActiveSheet()->setCellValue('I'.$a, $row['catatan']);
			$a++;
		}
		$a -= 1;
		$this->excel->getActiveSheet()->getStyle('A1:I'.$a)->applyFromArray($border);
		$filename ='SIMPLE.xls';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');


	}

	public function tabelProses($id){
		$plain_text = str_replace(array('-','_','~'), array('+','/','='), $id);
		$plain_text = $this->encrypt->decode($plain_text);
		$list = $this->M_simple->simple_table($plain_text);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $key->tanggal_kirim;
			$row[] = $key->jenis_limbah;
			$row[] = $key->section_name;
			$row[] = $key->berat_kirim;

			$data[] = $row;
		}

		$output = array(
			'draw' => $_POST['draw'], 
			'recordsTotal' =>$this->M_simple->count_all($plain_text),
			'recordsFiltered' => $this->M_simple->count_filtered($plain_text),
			'data' => $data
		);

		echo json_encode($output);
	}

}
?>