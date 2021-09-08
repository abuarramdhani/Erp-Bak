<?php
defined("BASEPATH") or die("This script cannot access directly");

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
/**
 * Ez debugging
 */
if (!function_exists('debug')) {
  function debug($arr)
  {
    echo "<pre>";
    print_r($arr);
    die;
  }
}

class C_DeklarasiSehat extends CI_Controller
{
  /**
   * user logged, created by session
   */
  protected $user_logged;
  /**
   * Select param item and type of param
   */
  // protected $param;

  public function __construct()
  {
    parent::__construct();

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('MasterPekerja/Pekerja/DeklarasiSehat/M_deklarasisehat', 'ds');

    // load another class
    // $this->load->library('../controllers/MasterPekerja/Pekerja/PencarianPekerja/Data_Pencarian');

    // $this->table_head_default = $this->data_pencarian->table_head_default; // array
    // $this->table_head_jabatan = $this->data_pencarian->table_head_jabatan; // array
    // $this->param = $this->data_pencarian->param; // array

    $this->user_logged = @$this->session->user ?: null;
    $this->user_id = $this->session->userid ?: null;

    $this->sessionCheck();
  }

  private function sessionCheck()
  {
    return $this->user_logged or redirect(base_url('MasterPekerja'));
  }

  /**
   * Pages
   * @url MasterPekerja/DeklarasiSehat
   *
   */
  public function index()
  {
    $data['Menu'] = 'Pekerja';
    $data['SubMenuOne'] = 'Deklarasi Sehat';
    $data['SubMenuTwo'] = 'Deklarasi Sehat';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->user_id, $this->session->responsibility_id);

		$data['pertanyaan'] = $this->ds->getPernyataanDeklarasi();

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MasterPekerja/Pekerja/DeklarasiSehat/V_Index', $data);
    $this->load->view('MasterPekerja/Pekerja/DeklarasiSehat/V_Footer', $data);
    // $this->load->view('V_Footer', $data);
  }

	public function getSeksi($value='')
	{
		$term = strtoupper($this->input->post('term'));
		echo json_encode($this->ds->getSeksi($term));
	}

	public function employee($value='')
	{
		$term = strtoupper($this->input->post('term'));
		echo json_encode($this->ds->employee($term, $this->input->post('kodesie')));
	}

	public function getDataFiltered($value='')
	{
		if ($this->user_logged) {
			$data['master'] = $this->ds->masterdeklarasisehat($this->input->post());
			$data['pertanyaan'] = $this->ds->getPernyataanDeklarasi();
			// debug($data['master']);
			$this->load->view('MasterPekerja/Pekerja/DeklarasiSehat/V_Ajax_filter_data', $data);
		}
	}

  public function excelds(){

    $this->load->library(array('Excel','Excel/PHPExcel/IOFactory'));
    $tanggal_awal = $this->input->post('tanggal_awal');
    $tanggal_akhir = $this->input->post('tanggal_akhir');
    $seksi = !empty($this->input->post('seksi')) ? $this->input->post('seksi') : 'Semua Seksi';
    $noind = !empty($this->input->post('noind')) ? $this->input->post('noind') : 'Semua Pekerja';
    $pertanyaan = $this->input->post('pertanyaan');
    $master_data = $this->ds->masterdeklarasisehat($this->input->post());
    $header_pertanyaan = $this->ds->getPernyataanDeklarasi();

    if (empty($master_data)) {
      echo json_encode('kosong');
      die;
    }

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("ICT")->setTitle("ICT");

    $objset = $objPHPExcel->setActiveSheetIndex(0);
    $objget = $objPHPExcel->getActiveSheet();
    $objget->setTitle("Deklarasi Sehat");

    // ------- SET COLUMN --------- //
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);

    // //ADD IMAGE QUICK FOR HEADER//

    // $gdImage = imagecreatefrompng('assets/img/logo.png');
    // // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
    // $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
    // $objDrawing->setName('Logo QUICK');$objDrawing->setDescription('Logo QUICK');
    // $objDrawing->setImageResource($gdImage);
    // $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
    // $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
    // $objDrawing->setCoordinates('B1');
    // //set width, height
    // $objDrawing->setWidth(60);
    // $objDrawing->setHeight(85);
    // $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    //SET CELL VALUE FOR THE HEADER
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B1', "Menampilkan Data Deklarasi Sehat Berdasarkan Tanggal: $tanggal_awal sampai $tanggal_akhir, Seksi: $seksi, Pekerja: $noind")
            ->setCellValue('B2', "No")
            ->setCellValue('C2', "Nama Pekerja")
            ->setCellValue('D2', "Seksi")
            ->setCellValue('E2', "No. Induk")
            ->setCellValue('F2', "Pertanyaan")
            ;
    // MERGING TO SET THE PAGE HEADER//
    $objget->mergeCells('B1:G1');
    $objget->mergeCells('B2:B3');
    $objget->mergeCells('C2:C3');
    $objget->mergeCells('D2:D3');
    $objget->mergeCells('E2:E3');

    $hrf1 = 'F';
    foreach ($header_pertanyaan as $key => $value) {
      $tidak = substr($value['aspek'], 0,7) == 'aspek_2' ? 'Tidak ' : '';
      $objset->setCellValue($hrf1++.'3', $tidak.' '.$value['pertanyaan']);
    }
    $objget->mergeCells('F2:'.$hrf1.'2');

    //STYLE HEADER
    $objget->getRowDimension('1')->setRowHeight(25);
    $objget->getColumnDimension('B')->setWidth(4);
    $objget->getColumnDimension('C')->setWidth(15);
    $objget->getColumnDimension('D')->setWidth(25);
    $objget->getColumnDimension('E')->setWidth(10);

    $objget->getColumnDimension('F')->setWidth(35);
    $objget->getColumnDimension('G')->setWidth(35);
    $objget->getColumnDimension('H')->setWidth(20);
    $objget->getColumnDimension('I')->setWidth(10);
    $objget->getColumnDimension('J')->setWidth(15);
    $objget->getColumnDimension('K')->setWidth(15);
    $objget->getColumnDimension('L')->setWidth(15);
    $objget->getColumnDimension('M')->setWidth(30);
    $objget->getColumnDimension('N')->setWidth(20);
    $objget->getColumnDimension('O')->setWidth(20);
    $objget->getColumnDimension('P')->setWidth(10);
    $objget->getColumnDimension('Q')->setWidth(20);

    $objget->getStyle('B1:B1')->applyFromArray(
      array(
              'font' => array(
                'color' => array('2272bd'),
              ),
              'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              ),
          )
      );

    $objget->getStyle('B2:'.$hrf1.'3')->applyFromArray(
      array(
              'font' => array(
                'color' => array('000000'),
                'bold' => true,
              ),
    					'borders' => array(
    					'allborders' => array(
    					'style' => PHPExcel_Style_Border::BORDER_THIN
    							)
    					),
              'fill' => array(
                  'type' => PHPExcel_Style_Fill::FILL_SOLID,
                  'color' => array('rgb' => 'a2e0ff')
              ),
              'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              ),
          )
      );

    //WRAP TEXT
    $objget->getStyle('F3:'.$hrf1.'3')->getAlignment()->setWrapText(true);

    //SET CELL VALUE FOR CONTENT
    $baris  = 4;
    $no = 1;
    foreach ($master_data as $key => $value) {
      $objset->setCellValue("B".$baris, $no++);
      $objset->setCellValue("C".$baris, $value['nama']);
      $objset->setCellValue("D".$baris, $value['seksi']);
      $objset->setCellValue("E".$baris, $value['noind']);

      $hrf2 = 'F';
      foreach ($header_pertanyaan as $key2 => $value2) {
        if ($value[$value2['aspek']] == 't') {
           $objset->setCellValue($hrf2.$baris, '✔️');
        }else {
          $objget->getStyle($hrf2.$baris.':'.$hrf2.$baris)->applyFromArray(
            array(
              'fill' => array(
                  'type' => PHPExcel_Style_Fill::FILL_SOLID,
                  'color' => array('rgb' => 'e9614e')
              ),
            )
          );
        }
        $hrf2++;
      }

      $baris++;
    };

    //STYLE CONTENT
    $objget->getStyle('B4:'.$hrf2.$baris)->applyFromArray(
      array(
    				'borders' => array(
    				'allborders' => array(
    				'style' => PHPExcel_Style_Border::BORDER_THIN
    						)
    				),
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
          )
      );

    //WRAP TEXT
    $objget->getStyle('B4:'.$hrf2.$baris)->getAlignment()->setWrapText(true);

    //GARIS DI GAMBAR
    // $objget->getStyle('B1:C6')->applyFromArray(
    //   array(
    //           'borders' => array(
    //           'allborders' => array(
    //           'style' => PHPExcel_Style_Border::BORDER_THIN
    //               )
    //           )
    //       )
    //   );

    $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
    $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_WorkSheet_PageSetup::PAPERSIZE_A4);
    $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
    $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.20);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.20);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.20);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.20);

    $objPHPExcel->setActiveSheetIndex(0);
    $date_export = date('dmyhis');
    $filename = urlencode("Lembar_Observasi_Deklarasi_Sehat_$date_export.xlsx"); //FILE NAME//
    $filename = str_replace("+", " ", $filename);

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    //
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('./assets/upload/GeneratorTSKK/'.$filename);
    echo json_encode($filename);
    // redirect("blabl/ViewEdit");
  }

  public function hapus_file($value='')
  {
    unlink('./assets/upload/GeneratorTSKK/'.$this->input->post('filename'));
    echo json_encode(1);
  }

  public function pdf()
  {
    $data['tanggal_awal'] = $this->input->post('tanggal_awal');
    $data['tanggal_akhir'] = $this->input->post('tanggal_akhir');
    $data['seksi'] = !empty($this->input->post('seksi')) ? $this->input->post('seksi') : 'Semua Seksi';
    $data['noind'] = !empty($this->input->post('noind')) ? $this->input->post('noind') : 'Semua Pekerja';
    $pertanyaan = $this->input->post('pertanyaan');
    $data['get'] = $this->ds->masterdeklarasisehat($this->input->post());
    $data['pertanyaan'] = $this->ds->getPernyataanDeklarasi();

    if (empty($data['get'])) {
      echo json_encode('kosong');
      die;
    }

    // ====================== do something =========================
    $this->load->library('pdf');

    $pdf 		= $this->pdf->load();
    $pdf 		= new mPDF('utf-8', array(267,210), 0, 'calibri', 3, 3, 3, 0, 0, 0);

    $date_export = date('dmyhis');
    $filename = urlencode("Lembar_Observasi_Deklarasi_Sehat_$date_export.pdf"); //FILE NAME//
    $isi 				= $this->load->view('MasterPekerja/Pekerja/DeklarasiSehat/V_PDF', $data, true);
    $waktu = date('d/M/Y H:i:s');
    $pdf->SetHTMLFooter("<table style='width: 100%;border-top: 1px solid black;'>
        <tr>
          <td style='vertical-align: middle;'><i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP Master Pekerja pada oleh ".$this->session->user." - ".$this->session->employee." tgl. ".$waktu." WIB.</i></td>
          <td style='text-align: right;vertical-align: middle;'>{PAGENO} of {nb}</td>
        </tr>
      </table>");
    $pdf->WriteHTML($isi);
    $pdf->Output('./assets/upload/GeneratorTSKK/'.$filename, 'F');
    echo json_encode($filename);
  }

}
