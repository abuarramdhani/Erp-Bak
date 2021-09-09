<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class C_HasilTes extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('General');
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');

    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->library('KonversiBulan');

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('ADMSeleksi/M_hasiltes');
    $this->load->model('ADMSeleksi/M_penjadwalan');

    $this->checkSession();
  }

  public function checkSession()
  {
    if ($this->session->is_logged) {
      // code...
    }else {
      redirect('index');
    }
  }
  //================================= MONITORING HASIL PSIKOTEST ===========================================================================================
  
  public function MonitoringHasilTes() // HASIL TES
  {
    $user = $this->session->username;
    $data 	=	$this->general->loadHeaderandSidemenu('Hasil Test Psikotest - Quick ERP', 'Monitoring Hasil Tes', 'Setting / Setup', 'Monitoring Hasil Tes');

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('ADMSeleksi/HasilTes/V_Mon_Hasil', $data);
    $this->load->view('V_Footer',$data);
  }
  
    public function get_nama_peserta(){
        $tipe = $this->input->get('tipe',TRUE);
        $tanggal = DateTime::createFromFormat('d/m/Y', $this->input->get('tanggal',TRUE))->format('Y-m-d');
        // $kode = $tipe.'_'.DateTime::createFromFormat('d/m/Y', $tanggal)->format('dmy');
        $term = $this->input->get('term',TRUE);
        $term = strtoupper($term);
        $data = $this->M_hasiltes->get_nama_peserta($term, $tipe, $tanggal);
        // echo "<pre>";print_r($data);exit();
        echo json_encode($data);
    }


    public function search(){
        $tipe       = $this->input->post('tipe');
        $tanggal    = $this->input->post('tanggal');
        $tes        = $this->input->post('tes');
        $peserta    = $this->input->post('peserta');

        $tanggal = !empty($tanggal) ? "and a.tgl_test = '". DateTime::createFromFormat('d/m/Y', $tanggal)->format('Y-m-d')."'" : '';
        $nama_peserta = !empty($peserta) ? "and a.nama_peserta = '$peserta'" : '';
        $nama_tes = !empty($tes) ? "and a.id_test = $tes" : '';
            
        $getdata = $this->M_hasiltes->data_hasil_tes($tipe, $tanggal, $nama_peserta, $nama_tes);
        // echo "<pre>";print_r($nama_tes);exit();
        $data['data'] = $getdata;
        $this->load->view("ADMSeleksi/HasilTes/V_Collect_Table", $data);
    }

    public function detailtes($kode){
      $user = $this->session->username;
      $data 	=	$this->general->loadHeaderandSidemenu('Hasil Test Psikotest - Quick ERP', 'Detail Hasil Tes', 'Setting / Setup', 'Monitoring Hasil Tes');
      
      $kode = explode("_", $kode);
      $kode_akses = $kode[0];
      $id_tes = $kode[1];
      $getdata = $this->M_hasiltes->detail_tes($kode_akses, $id_tes);
      $data['data'] = $this->olah_hasil($getdata);
      // echo "<pre>";print_r($data['data']);exit();
      $this->load->view('V_Header',$data);
      $this->load->view('V_Sidemenu',$data);
      $this->load->view('ADMSeleksi/HasilTes/V_Detail_tes', $data);
      $this->load->view('V_Footer',$data);
    }

    public function exportdetail($kode){
      $kode = explode("_", $kode);
      $kode_akses = $kode[0];
      $id_tes = $kode[1];
      $getdata = $this->M_hasiltes->detail_tes($kode_akses, $id_tes);
      $data = $this->olah_hasil($getdata);
      // echo "<pre>";print_r($data);exit();
      $this->export_excel($data);
    }

    public function olah_hasil($getdata){
      $datanya = array();
      foreach ($getdata as $key => $value) {
        $datanya[$value['nik']][$value['nama_tes']][] = $value;
      }
      // echo "<pre>";print_r($datanya);exit();
      return $datanya;
    }

    public function export_excel($data){
      include APPPATH.'third_party/Excel/PHPExcel.php';
      $excel = new PHPExcel();
      // $excel->getProperties()->setCreator('CV. KHS')
      //       ->setLastModifiedBy('CV. KHS')
      //       ->setTitle("Monitoring Job Produksi")
      //       ->setSubject("Laporan Produksi")
      //       ->setDescription("Laporan Produksi");

      $style_title = array(
        'alignment' => array(
          // 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
          'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
      );
      $style1 = array(
        'fill' => array(
          'type' => PHPExcel_Style_Fill::FILL_SOLID,
        ),
        'font' => array(
          'bold' => true,
        ), 
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
          'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
          'wrap' => true,
        ),
        'borders' => array(
          'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
          'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
          'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
        )
      );
      $style2 = array(
        'alignment' => array(
          'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
          'wrap' => true,
        ),
        'borders' => array(
          'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
          'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
          'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
        )
      );
      $style3 = array(
        'alignment' => array(
          'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
        ),
        'borders' => array(
          'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
          'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
          'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
        )
        
      );

      $excel->setActiveSheetIndex(0)->setCellValue('A1', "DETAIL HASIL TES"); 
      $excel->getActiveSheet()->mergeCells("A1:K1"); 
      $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);
      $num = 3; $noj = 1;
          foreach ($data as $key => $val2) {
            foreach ($val2 as $key2 => $val) {
          // echo "<pre>";print_r($val2);exit();
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$num, 'KODE TES '); 
            $excel->setActiveSheetIndex(0)->setCellValue('A'.($num+1), 'TANGGAL TES '); 
            $excel->setActiveSheetIndex(0)->setCellValue('A'.($num+2), 'NAMA PESERTA '); 
            $excel->setActiveSheetIndex(0)->setCellValue('A'.($num+3), 'NAMA TES '); 
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$num, ': '.$val[0]['kode_test']); 
            $excel->setActiveSheetIndex(0)->setCellValue('B'.($num+1), ': '.DateTime::createFromFormat('Y-m-d', $val[0]['tgl_test'])->format('d-m-Y')); 
            $excel->setActiveSheetIndex(0)->setCellValue('B'.($num+2), ': '.$val[0]['nama_peserta']); 
            $excel->setActiveSheetIndex(0)->setCellValue('B'.($num+3), ': '.$val[0]['nama_tes']); 
            $excel->getActiveSheet()->getStyle('A'.$num)->applyFromArray($style_title);
            $excel->getActiveSheet()->getStyle('A'.($num+1))->applyFromArray($style_title);
            $excel->getActiveSheet()->getStyle('A'.($num+2))->applyFromArray($style_title);
            $excel->getActiveSheet()->getStyle('A'.($num+3))->applyFromArray($style_title);
            $excel->getActiveSheet()->getStyle('B'.$num)->applyFromArray($style_title);
            $excel->getActiveSheet()->getStyle('B'.($num+1))->applyFromArray($style_title);
            $excel->getActiveSheet()->getStyle('B'.($num+2))->applyFromArray($style_title);
            $excel->getActiveSheet()->getStyle('B'.($num+3))->applyFromArray($style_title);

            $excel->setActiveSheetIndex(0)->setCellValue('A'.($num+5), "NO.");
            $excel->getActiveSheet()->getStyle('A'.($num+5))->applyFromArray($style1);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.($num+5), "JAWABAN");
            $excel->getActiveSheet()->getStyle('B'.($num+5))->applyFromArray($style1);

            $numrow = $num+6; $no = 1;
            foreach ($val as $key3 => $v) {
              $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
              $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $v['cek']);
              $excel->getActiveSheet()->getStyle("A$numrow")->applyFromArray($style3);
              $excel->getActiveSheet()->getStyle("B$numrow")->applyFromArray($style2);
              $numrow++;
              $no++;
            }
          $num = $numrow + 3;
          }
        }

      
      for($col = 'A'; $col !== 'AA'; $col++) { // autowidth
        $excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
      } 
      $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
      // Set orientasi kertas jadi LANDSCAPE
      $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
      // Set judul file excel nya
      $excel->setActiveSheetIndex();
      // Proses file excel
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="Detail-Hasil-Tes.xlsx"'); 
      header('Cache-Control: max-age=0');
      $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
      $write->save('php://output');
	
    }

  public function search_monitoring(){
    $ket        = $this->input->post('ket');
    $data['id'] = $this->input->post('id');
    $data['data']    = $this->M_hasiltes->data_psikotest($ket);
    $this->load->view('ADMSeleksi/HasilTes/V_Mon_Table', $data);
  }

  public function Lihat_detail(){
    $user = $this->session->username;
    $data 	=	$this->general->loadHeaderandSidemenu('Hasil Test Psikotest - Quick ERP', 'Monitoring Hasil Tes', 'Setting / Setup', 'Monitoring Hasil Tes');

    $kode = $this->input->post('collect_peserta');
    if (empty($kode)) {
      echo "<script>
                alert('Check Nama Peserta terlebih dahulu!');
            </script>" ;
      exit();
    }
    $pisah = explode("+", $kode);
    $kode = '';
    for ($i=0; $i < count($pisah) ; $i++) { 
      if ($pisah[$i] != '') {
        $kode = $i == 0 ? "'".$pisah[$i]."'" : $kode.", '".$pisah[$i]."'";
      }
    }
    $getdata = $this->M_hasiltes->getdata_hasil($kode);
    $data['data'] = $this->olah_hasil($getdata);
    // echo "<pre>";print_r($data['data']);exit();
    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('ADMSeleksi/HasilTes/V_Detail_Tes', $data);
    $this->load->view('V_Footer',$data);
  }
  
  public function Export_detail(){
    $kode = $this->input->post('collect_peserta');
    if (empty($kode)) {
      echo "<script>
                alert('Check Nama Peserta terlebih dahulu!');
            </script>" ;
      exit();
    }
    $pisah = explode("+", $kode);
    $kode = '';
    for ($i=0; $i < count($pisah) ; $i++) { 
      if ($pisah[$i] != '') {
        $kode = $i == 0 ? "'".$pisah[$i]."'" : $kode.", '".$pisah[$i]."'";
      }
    }
    $getdata = $this->M_hasiltes->getdata_hasil($kode);
    $data = $this->olah_hasil($getdata);
    // echo "<pre>";print_r($data);exit();
    $this->export_excel($data);
  }

  public function hapus_hasil_tes(){
    $kode = $this->input->post('kode');
    $id_tes = $this->input->post('id_tes');
    $this->M_hasiltes->delete_jawaban($kode, $id_tes);
    $this->M_hasiltes->delete_sesi($kode, $id_tes);
    $this->M_hasiltes->delete_peserta($kode, $id_tes);
    $this->M_penjadwalan->insert_log(date('Y-m-d H:i:s'), 'MONITORING HASIL TES', "HAPUS HASIL TES, kode akses ".$kode.", id tes ".$id_tes."", $this->session->user, "HAPUS DATA HASIL TES", "MONITORING HASIL TES");
  
  }

}