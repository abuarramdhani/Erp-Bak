<?php

use C_SetupCutoff as GlobalC_SetupCutoff;

defined('BASEPATH') or exit('No direct script access allowed');

class HelperFunction
{
   public function __construct()
   {
   }
   static function convertTodate($number)
   {
      $year = substr($number, 0, 4);
      $month = (int)substr($number, 4, 2);
      $months = [
         1 => 'Januari',
         2 => 'Februari',
         3 => 'Maret',
         4 => 'April',
         5 => 'Mei',
         6 => 'Juni',
         7 => 'Juli',
         8 => 'Agustus',
         9 => 'September',
         10 => 'Oktober',
         11 => 'November',
         12 => 'Desember',
      ];
      return trim($months[$month] . ' ' . $year);
   }
   static function convertToNumber($date)
   {
      $date = explode(' ', $date);
      $year = $date[1];
      $month = $date[0];
      $months = [
         'January' => '01',
         'February' => '02',
         'March' => '03',
         'April' => '04',
         'May' => '05',
         'June' => '06',
         'July' => '07',
         'August' => '08',
         'September' => '09',
         'October' => '10',
         'November' => '11',
         'December' => '12',
      ];
      return trim($year . $months[$month]);
   }
}

class C_SetupCutoff extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      $this->load->library('Log_Activity');
      $this->load->library('session');
      $this->load->library('general');
      $this->load->helper('url');
      $this->load->model('MasterPresensi/SetupCutoff/M_setupcutoff');
   }

   public function index()
   {

      $data  = $this->general->loadHeaderandSidemenu('Master Presensi', 'Master Presensi', 'Setup Cuti', '', '');
      $data['cutoff'] = $this->M_setupcutoff->getCutoff();
      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('MasterPresensi/SetupCutoff/V_SetupCutoff', $data);
      $this->load->view('V_Footer', $data);
   }
   public function insertCutoff()
   {
      $inputCutoff = $this->input->post('dataCutoff');
      $max_id = $this->input->post('max_id');
      $inputCutoff['periode'] = HelperFunction::convertToNumber($inputCutoff['periode']);
      $checkCutoff = count($this->M_setupcutoff->checkCutoff($inputCutoff['id_cutoff']));
      if ($checkCutoff <= 0) {
         $this->M_setupcutoff->insertCutoff($inputCutoff);
         $inputCutoff['periodeTxt'] = HelperFunction::convertTodate($inputCutoff['periode']);

         $ket = "PERIODE:" . $inputCutoff['periodeTxt'] . " TGL:" . $inputCutoff['tanggal_awal'] . " - " . $inputCutoff['tanggal_akhir'] . " OS:" . ($inputCutoff['os'] > 0 ? 'Yes' : 'No') . " ID:" . ((int)$max_id + 1);
         $this->M_setupcutoff->insertLog(date('Y-m-d H:i:s'), 'SETUP -> CUTOFF', $ket, $this->session->user, 'SIMPAN -> EDIT DATA', 'MASTER PRESENSI ERP');

         return $this->output->set_content_type('application/json')
            ->set_output(json_encode([
               'code' => 200,
               'message' => "Berhasil Input Cutoff",
               'alteredData' => $inputCutoff,
               'action' => 0
            ]));
      }

      $this->M_setupcutoff->updateCutoff($inputCutoff);
      $inputCutoff['periodeTxt'] = HelperFunction::convertTodate($inputCutoff['periode']);
      $ket = "PERIODE:" . $inputCutoff['periodeTxt'] . " TGL:" . $inputCutoff['tanggal_awal'] . " - " . $inputCutoff['tanggal_akhir'] . " OS:" . ($inputCutoff['os'] > 0 ? 'Yes' : 'No') . " ID:" . $inputCutoff['id_cutoff'];
      $this->M_setupcutoff->insertLog(date('Y-m-d H:i:s'), 'SETUP -> CUTOFF', $ket, $this->session->user, 'SIMPAN -> EDIT DATA', 'MASTER PRESENSI ERP');
      return $this->output->set_content_type('application/json')
         ->set_output(json_encode([
            'code' => 200,
            'message' => "Berhasil Update Cutoff",
            'alteredData' => $inputCutoff,
            'action' => 1
         ]));
   }
   public function deleteCutoff()
   {
      $alteredId = $this->input->post('id_cutoff');
      $inputCutoff = $this->input->post('dataCutoff');

      $this->M_setupcutoff->deleteCutoff($alteredId);

      $ket = "PERIODE:" . $inputCutoff['periode'] . " TGL:" . $inputCutoff['tanggal_awal'] . " - " . $inputCutoff['tanggal_akhir'] . " OS:" . ($inputCutoff['os'] > 0 ? 'Yes' : 'No') . " ID:" . $inputCutoff['id_cutoff'];
      $this->M_setupcutoff->insertLog(date('Y-m-d H:i:s'), 'SETUP -> CUTOFF', $ket, $this->session->user, 'SIMPAN -> EDIT DATA', 'MASTER PRESENSI ERP');

      return $this->output->set_content_type('application/json')
         ->set_output(json_encode([
            'code' => 200,
            'message' => "Berhasil Menghapus Cutoff",
            'alteredData' => $alteredId,
            'action' => 2
         ]));
   }
   public function exportPdf()
   {
      $cutoff = $this->M_setupcutoff->getCutoff();
      $data['cutoff'] = $cutoff;
      $content = $this->load->view('MasterPresensi/SetupCutoff/pdf.php', $data, true);
      $pdf     =  $this->pdf->load();
      $pdf     =  new mPDF('utf-8', 'A4', 10, "verdana", 20, 20, 10, 20, 0, 0, 'P', ['default_font' => 'verdana']);
      $filename = 'DAFTAR CUTOFF CV.KARYA HIDUP SENTOSA.pdf';
      $footer = "
			Dicetak melalui Quick ERP - Master Presensi Setup Cuti pada " . date('Y-m-d H:i:s') . " oleh " . $this->session->user . " - " . $this->session->employee . "
		";
      $pdf->SetFooter($footer);
      $pdf->WriteHTML($content, 0);
      $pdf->Output($filename, 'D');
   }
}
