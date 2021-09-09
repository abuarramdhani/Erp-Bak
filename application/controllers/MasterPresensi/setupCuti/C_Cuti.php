<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Cuti extends CI_Controller
{
   function __construct()
   {
      parent::__construct();

      $this->load->library('Log_Activity');
      $this->load->library('session');
      $this->load->library('general');
      $this->load->helper('url');
      $this->load->model('MasterPresensi/SetupCuti/M_cuti');
   }

   public function index()
   {
      $data  = $this->general->loadHeaderandSidemenu('Master Presensi', 'Master Presensi', 'Setup Cuti', '', '');
      $data['cuti'] = $this->M_cuti->getCuti();
      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('MasterPresensi/SetupCuti/V_Cuti', $data);
      $this->load->view('V_Footer', $data);
   }

   public function insertCuti()
   {
      // Check If Input Already Exist
      $inputCuti = $this->input->post('inputCuti');
      list($kodeCuti, $namaCuti, $maxHari) = $inputCuti;

      $cuti_exist = current($this->M_cuti->checkCuti($kodeCuti, $namaCuti));

      $num_rows = count($cuti_exist);

      if ($num_rows > 1) {
         $this->M_cuti->updateCuti($cuti_exist, $kodeCuti, $namaCuti, $maxHari);
         $this->M_cuti->insertLog(date('Y-m-d H:i:s'), "SETUP->CUTI", "Kode->$kodeCuti Max Hari->$maxHari", $this->session->user, 'SIMPAN->EDIT DATA', 'MASTER PRESENSI');
         return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
               'code' => 200,
               'message' => "Berhasil Update Cuti",
               'alteredData' => $inputCuti
            ]));
      }
      $this->M_cuti->insertLog(date('Y-m-d H:i:s'), "SETUP->CUTI", "Kode->$kodeCuti Nama->$namaCuti Max Hari->$maxHari", $this->session->user, 'SIMPAN->TAMBAH DATA', 'MASTER PRESENSI');
      $this->M_cuti->insertCuti($inputCuti);

      return $this->output
         ->set_content_type('application/json')
         ->set_output(json_encode([
            'code' => 200,
            'message' => "Berhasil Input Cuti",
            'alteredData' => $inputCuti
         ]));
   }

   public function deleteCuti()
   {
      $inputCuti = $this->input->post('inputCuti');
      list($kode_cuti, $nama_cuti, $maxHari) = $inputCuti;
      $this->M_cuti->deleteCuti($kode_cuti, $nama_cuti);

      $this->M_cuti->insertLog(date('Y-m-d H:i:s'), "SETUP->CUTI", "Kode->$kode_cuti Nama->$nama_cuti Max Hari->$maxHari", $this->session->user, 'HAPUS DATA', 'MASTER PRESENSI');
      return $this->output
         ->set_content_type('application/json')
         ->set_output(json_encode([
            'code' => 200,
            'message' => "Berhasil Menghapus Cuti",
            'alteredData' => $inputCuti
         ]));
   }

   public function exportPdf()
   {
      $cuti = $this->M_cuti->getCuti();
      $data['cuti'] = $cuti;
      $content = $this->load->view('MasterPresensi/SetupCuti/pdf.php', $data, true);
      $pdf     =  $this->pdf->load();
      $pdf     =  new mPDF('utf-8', 'A4', 10, "verdana", 20, 20, 10, 20, 0, 0, 'P', ['default_font' => 'verdana']);
      $filename = 'DAFTAR CUTI CV.KARYA HIDUP SENTOSA.pdf';
      $footer = "
			Dicetak melalui Quick ERP - Master Presensi Setup Cuti pada " . date('Y-m-d H:i:s') . " oleh " . $this->session->user . " - " . $this->session->employee . "
		";
      $pdf->SetFooter($footer);
      $pdf->WriteHTML($content, 0);
      $pdf->Output($filename, 'D');
   }
}
