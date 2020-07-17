<?php
defined('BASEPATH') or exit('o');

class Lembur extends CI_Controller
{
  function __construct()
  {
    $this->CI = &get_instance();
    $this->CI->load->model('SPLSeksi/M_splseksi');
  }

  // last update 07/04/2020
  public function hitung_jam_lembur($noind, $kode_lembur, $tgl, $mulai, $selesai, $break, $istirahat)
  {
    $shift_kemarin = $this->CI->M_splseksi->show_current_shift(date('Y-m-d', strtotime($tgl . ' -1 day')), $noind);
    if (!empty($shift_kemarin) && trim($shift_kemarin[0]['kd_shift']) == '3')
      $tgl = date('Y-m-d', strtotime($tgl . ' -1 day'));

    $shift = $this->CI->M_splseksi->selectShift($noind, $tgl);
    $day   = date('w', strtotime($tgl));

    $hari_indo = "Minggu Senin Selasa Rabu Kamis Jumat Sabtu";
    $array_hari = explode(' ', $hari_indo);
    $bedaHari = strtotime($mulai) > strtotime($selesai) ? true : false;
    //--------------------core variable
    $KET      = $this->CI->M_splseksi->getKeteranganJamLembur($noind);
    // $JENIS_HARI	= $this->M_splseksi->getJenisHari($tgl, $noind); // useless, u can delete it
    $JENIS_HARI = $shift ? 'Biasa' : 'Libur';
    $HARI     = $array_hari[$day];
    //-----------------------
    $treffjamlembur = $this->CI->M_splseksi->treffjamlembur($KET, $JENIS_HARI, $HARI);

    //----cari berapa menit lemburnya
    $first = explode(':', $mulai);
    $second = explode(':', $selesai);

    if (count($first) == 1) {
      $first[1] = 00;
    }

    if (count($second) == 1) {
      $second[1] = 00;
    }

    $a = $first[0] * 60 + $first[1];
    $b = $second[0] * 60 + $second[1];

    if ($a > $b) {
      $zero = 24 * 60; // 1 day in minutes
      $z = $zero - $a;
      $lama_lembur = $z + $b;
    } else {
      $lama_lembur = $b - $a;
    }

    if ($kode_lembur == '005') {
      $shiftmsk = strtotime($tgl . " " . $shift->jam_msk);
      $shiftklr = strtotime($shift->jam_plg) < strtotime($shift->jam_msk) ?
        strtotime('+1 day ' . $tgl . " " . $shift->jam_plg) :
        strtotime($tgl . " " . $shift->jam_plg);

      $jamshift = $shiftklr - $shiftmsk;
      $jamshift = $jamshift / 60;
      $result = $lama_lembur - $jamshift;
    } else {
      $result = $lama_lembur;
    }
    //-----end cari menit lembur
    //-----------------------core variable
    $MENIT_LEMBUR = $result;
    //buat jaga jaga error
    $BREAK = $break == 'Y' ? 15 : 0;
    $ISTIRAHAT = $istirahat == 'Y' ? 45 : 0;

    $allShift = $this->CI->M_splseksi->selectAllShift($tgl);

    if (!empty($allShift)) {
      if ($istirahat == 'Y') { //jika pekerja memilih istirahat
        $ISTIRAHAT = 0;
        $distinct_start = [];

        foreach ($allShift as $item) {
          $is_rest_yesterday = (strtotime($item['ist_mulai']) < strtotime($mulai)) && (strtotime($item['ist_selesai']) < strtotime($mulai));

          $rest_start = $is_rest_yesterday ? strtotime('+1 day ' . $tgl . " " . $item['ist_mulai']) : strtotime($tgl . " " . $item['ist_mulai']);
          $rest_end   = $is_rest_yesterday ? strtotime('+1 day ' . $tgl . " " . $item['ist_selesai']) : strtotime($tgl . " " . $item['ist_selesai']);

          // lembur datang pulang
          if (
            $kode_lembur == '005'
            && $rest_start >= $shiftmsk
            && $rest_end <= $shiftklr
          ) {
            continue;
          }

          if ($rest_start == $rest_end) {
            continue;
          }

          //biar jam break tidak terdouble
          if (in_array($rest_start, $distinct_start)) {
            continue;
          } else {
            $distinct_start[] = $rest_start;
          }

          $overtime_start = strtotime($tgl . " " . $mulai);
          $overtime_end   = (strtotime($mulai)  > strtotime($selesai)) ? strtotime('+1 day ' . $tgl . " " . $selesai) : strtotime($tgl . " " . $selesai);

          if (($rest_start >= $overtime_start && $rest_end <= $overtime_end)) { // jika jam istirahat masuk range lembur
            $ISTIRAHAT = $ISTIRAHAT + 45;
          } else if ($rest_start >= $overtime_start && $rest_end >= $overtime_end && $rest_start <= $overtime_end) {
            $ISTIRAHAT = $ISTIRAHAT + (45 + ($overtime_end - $rest_end) / 60);
          }
        }
        $ISTIRAHAT = floor($ISTIRAHAT);
      }

      if ($break == 'Y') { //jika pekerja memilih istirahat
        $BREAK = 0;
        $distinct_start = [];

        foreach ($allShift as $item) {
          $break_start = (strtotime($item['break_mulai']) < strtotime($mulai)) ? strtotime('+1 day ' . $tgl . " " . $item['break_mulai']) : strtotime($tgl . " " . $item['break_mulai']);
          $break_end   = (strtotime($item['break_selesai']) < strtotime($mulai)) ? strtotime('+1 day ' . $tgl . " " . $item['break_selesai']) : strtotime($tgl . " " . $item['break_selesai']);

          // lembur datang dan pulang
          if (
            $kode_lembur == '005'
            && $break_start >= $shiftmsk
            && $break_end <= $shiftklr
          ) {
            continue;
          }

          //jika tidak ada istirahat, lewati
          if ($break_start == $break_end) {
            continue;
          }

          //biar jam break tidak terdouble
          if (in_array($break_start, $distinct_start)) {
            continue;
          } else {
            $distinct_start[] = $break_start;
          }

          $overtime_start = strtotime($tgl . " " . $mulai);
          $overtime_end   = (strtotime($mulai)  > strtotime($selesai)) ? strtotime('+1 day ' . $tgl . " " . $selesai) : strtotime($tgl . " " . $selesai);

          if ($break_start >= $overtime_start && $break_end <= $overtime_end) { // jika jam istirahat masuk range lembur
            $BREAK = $BREAK + 15;
          } else if ($break_start >= $overtime_start && $break_end >= $overtime_end && $break_start <= $overtime_end) {
            $BREAK = $BREAK + (15 + ($overtime_end - $break_end) / 60);
          }
        }
        $BREAK = floor($BREAK);
      }
    }

    //----------------------
    $estimasi = 0;
    if (!empty($treffjamlembur)) :
      $total_lembur = $MENIT_LEMBUR - ($BREAK + $ISTIRAHAT);
      $i = 0;
      while ($total_lembur > 0) {
        $jml_jam = $treffjamlembur[$i]['jml_jam'] * 60;
        $pengali = $treffjamlembur[$i]['pengali'];

        if ($total_lembur > $jml_jam) {

          $estimasi = $estimasi + $jml_jam * $pengali / 60;
          $total_lembur = $total_lembur - $jml_jam;
        } else {

          $estimasi = $estimasi + ($total_lembur * $pengali / 60);
          $estimasi = number_format($estimasi, 2);
          $total_lembur = 0;
        }
        $i++;
      }
    else :
      $estimasi = "tdk bisa diproses";
    endif;

    return $estimasi;
  }
}
