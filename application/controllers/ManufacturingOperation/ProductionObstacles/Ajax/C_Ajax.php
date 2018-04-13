<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Ajax extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('ManufacturingOperation/ProductionObstacles/M_ajax');
	}

	public function hapus()
	{
		$id = $this->input->post('id');
		$data = $this->M_ajax->delete($id);
		echo json_encode($data);
	}

	public function hapusCabang()
	{
		$id = $this->input->post('id');
		$data = $this->M_ajax->deleteCabang($id);
		echo json_encode($data);
	}

	public function UpdateInduk()
	{
		$id = $this->input->post('id');
		$val = $this->input->post('val');
		$type = $this->input->post('type');
		$data = $this->M_ajax->UpdateInduk($id,$val);

		echo json_encode($data);
	}

	public function UpdateCabang()
	{
		$id = $this->input->post('id');
		$val = $this->input->post('val');
		$data = $this->M_ajax->UpdateCabang($id,$val);
		if ($data==true) {
			echo '1';
		}else{
			echo '0asdasdasda';
		}
	}

	public function select2Induk()
	{	
		$term= $this->input->post('term');
		$data = $this->M_ajax->selectInduk($term);
		echo json_encode($data);
	}

	public function select2Cabang()
	{	
		$term = $this->input->post('term');
		$type = $this->input->post('type');
		$data = $this->M_ajax->selectCabang($type,$term);
		echo json_encode($data);
	}

	public function updateindukCabang()
	{
		$induk = $this->input->post('ind');
		$id = $this->input->post('id');
		$data = $this->M_ajax->updateindukCabang($induk,$id);
		echo json_encode($data);
		
	}


	public function searchHambatan()
	{
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
		$type = $this->input->post('type');
		$data = $this->M_ajax->searchHambatan($tgl1,$tgl2,$type);
		$x=1;
		foreach ($data as $k) {
			echo '<tr>
				<td>'.$x.'</td>
				<td>'.$k['induk'].'</td>
				<td>'.$k['cabang'].'</td>
				<td>'.$k['total'].'</td>
				<td>'.$k['frekuensi'].'</td>
			</tr>';
			$x++;
		}
	}

	public function exportHamMesin()
	{
		$tgl1 = $this->input->post('tgl_hambatan1');
		$tgl2 = $this->input->post('tgl_hambatan2');
		$type = $this->input->post('typeCetak');

		$this->load->library('Excel');
		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();
		$styleThead = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'FFFFFF'),
				'size'	=> 14,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$styleBorder = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$styleTitle = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'	=> 24,
			),
			'alignment' => array(
            	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        	)
		);

		$styleTitle1 = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'	=> 14,
			),
			'alignment' => array(
            	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        	)
		);

		$data = $this->M_ajax->reportHambatan($tgl1,$tgl2,$type);

		$worksheet->getColumnDimension('A')->setWidth(5);
		$worksheet->getColumnDimension('B')->setWidth(30);
		$worksheet->getColumnDimension('C')->setWidth(30);
		$worksheet->getColumnDimension('D')->setWidth(30);


		$worksheet->getStyle('A6:D6')->applyFromArray($styleThead);
		$worksheet	->getStyle('A6:D6')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('337ab7');

		// ----------------- Set table header -----------------
		$worksheet->mergeCells('A1:D1');
		$worksheet->getStyle('A1:D1')->applyFromArray($styleTitle);
		$worksheet->mergeCells('A3:D3');
		$worksheet->getStyle('A3:D3')->applyFromArray($styleTitle1);
		$worksheet->mergeCells('A5:D5');
		$worksheet->getStyle('A5:D5')->applyFromArray($styleTitle1);
		// $worksheet->getStyle("A1:L1")->getFont()->setSize(18);
		$worksheet->setCellValue('A1', 'Laporan Hambatan produksi Cetakan Logam');
		$worksheet->setCellValue('A3', 'Hambatan Mesin tanggal '.$tgl1.' s/d '.$tgl2);
		$worksheet->setCellValue('A5', 'Kategori :Umum');

		$worksheet->setCellValue('A6', 'NO');
		$worksheet->setCellValue('B6', 'Jenis Hambatan');
		$worksheet->setCellValue('C6', 'Total lama waktu (Jam)');
		$worksheet->setCellValue('D6', 'Frekuensi');

		// ----------------- Set table body -----------------
		$no = 1;
		$highestRow = $worksheet->getHighestRow()+1;
		foreach ($data as $dt) {
			$worksheet->getStyle('A'.$highestRow.':D'.$highestRow)->applyFromArray($styleBorder);
			
			$worksheet->setCellValue('A'.$highestRow, $no++);
			$worksheet->setCellValue('B'.$highestRow, $dt['hambatan']);
			$worksheet->setCellValue('C'.$highestRow, $dt['total']);
			$worksheet->setCellValue('D'.$highestRow, $dt['frekuensi']);
			$highestRow++;
		}

		// ----------------- Final Process -----------------
		$worksheet->setTitle('Storage Location');
		// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="DataHambatan'.time().'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save("php://output");

	}
}