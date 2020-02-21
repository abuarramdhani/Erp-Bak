<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 *
 */
class C_Index extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('Log_Activity');
    $this->load->library('General');
    $this->load->library('pdf');
    $this->load->library('session');
    $this->load->library('KonversiBulan');

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('MasterPekerja/Surat/GajiPekerjaCutoff/M_indexinfo');

    date_default_timezone_set('Asia/Jakarta');
    $this->checkSession();
  }

  public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

  public function index()
  {
    $data 	=	$this->general->loadHeaderandSidemenu('Master Pekerja - Quick ERP', 'Cetak Pemberitahuan Gaji Pekerja Cutoff', 'Surat', 'Memo Pekerja Cutoff');

    $data['database'] = $this->M_indexinfo->getDataAll();

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('MasterPekerja/Surat/GajiPekerjaCutoff/V_Index',$data);
    $this->load->view('V_Footer',$data);
  }

  public function create_Info()
  {
    $data 	=	$this->general->loadHeaderandSidemenu('Master Pekerja - Quick ERP', 'Cetak Pemberitahuan Gaji Pekerja Cutoff', 'Surat', 'Memo Pekerja Cutoff');

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('MasterPekerja/Surat/GajiPekerjaCutoff/V_Create',$data);
    $this->load->view('V_Footer',$data);
  }

  public function ajaxGetSeksiByNoind()
  {
    $noind = $this->input->post('noind');
    echo json_encode($this->M_indexinfo->getDetailTambahan($noind));
  }

  public function getDataPeriode()
  {
    $periode     = $this->input->post('ajaxPeriode');
    $explode     = explode(' ', $periode);
    $thisMonth   = $explode[0];
    $bulanAngka  = $this->konversibulan->KonversiBulanInggrisKeAngka($thisMonth);

    $tperiode        = $explode[1].$bulanAngka;
    $getPeriode      = $this->M_indexinfo->getPeriode($tperiode);
    if(empty($getPeriode)):
      echo "null";
      die;
    endif;
    $awalIndex = $this->konversibulan->KonversiAngkaKeBulan(date('m', strtotime($getPeriode[0]['tanggal_awal'])));
    $akhirIndex = $this->konversibulan->KonversiAngkaKeBulan(date('m', strtotime($getPeriode[0]['tanggal_akhir'])));

    $data['awal']    = date('d', strtotime($getPeriode[0]['tanggal_awal'])).' '.$awalIndex.' '.date('Y', strtotime($getPeriode[0]['tanggal_awal']));
    $data['akhir']   = date('d', strtotime($getPeriode[0]['tanggal_akhir'])).' '.$akhirIndex.' '.date('Y', strtotime($getPeriode[0]['tanggal_akhir']));
    $data['staf']    = $this->M_indexinfo->getPekerjaStafSP3();
    $data['nonstaf'] = $this->M_indexinfo->getPekerjaNonStafSP3();
    $data['hubker']         = $this->M_indexinfo->getHubker();

    $view = $this->load->view('MasterPekerja/Surat/GajiPekerjaCutoff/V_Periodik',$data);

    echo json_encode($view);
  }

  public function getAlasan()
  {
    $jenis = $this->input->post('jenis');
    if (!empty($jenis)) {
      $data = $this->M_indexinfo->getAlasan();
    }else {
      $data = '';
    }
    echo ($data);
  }

  public function getTabel()
  {
    $noindnstaf = $this->input->post('noindnstaf');

    if ($noindnstaf > 1) {
      $return1 = implode("', '", $noindnstaf);
      $return2 = "'$return1'";
      $detailPrevnStaf  = $this->M_indexinfo->getDetailTambahanPrev(true, $return2);
    }else {
      $detailPrevnStaf  = $this->M_indexinfo->getDetailTambahanPrev(false, $noindnstaf);
    }

    $data['new'] = array_unique(array_column($detailPrevnStaf, 'seksi'));
    $data['head'] = $this->M_indexinfo->newAtasan();
    $view = $this->load->view('MasterPekerja/Surat/GajiPekerjaCutoff/V_Tabel', $data);

    echo json_encode($view);
  }

  public function isi_memo_cutoff()
  {
    $jenis          = $this->input->post('jenis');
    $tertanda       = $this->input->post('approval');
    $alasan         = $this->input->post('alasan');
    $staf           = $this->input->post('allnoind');
    $nstaf          = $this->input->post('nstaf');
    $noAtasan       = $this->input->post('noindA');
    $periodeLayar   = $this->input->post('periodeBaru');
    $seksi          = $this->input->post('seksiName');


    $tertanda       = $this->M_indexinfo->getTertandaM($tertanda);

    $explodeYear    = explode(' ', $periodeLayar);
    $thisMonth      = $explodeYear[0];
    $bulanAsli      = $this->konversibulan->KonversiKeBulanIndonesia($thisMonth);

    if ($thisMonth == 'January') {
      $bulane = 'Februari';
    }elseif ($thisMonth == 'February') {
      $bulane = 'Maret';
    }elseif ($thisMonth == 'March') {
      $bulane = 'April';
    }elseif ($thisMonth == 'April') {
      $bulane = 'Mei';
    }elseif ($thisMonth == 'May') {
      $bulane = 'Juni';
    }elseif ($thisMonth == 'June') {
      $bulane = 'Juli';
    }elseif ($thisMonth == 'July') {
      $bulane = 'Agustus';
    }elseif ($thisMonth == 'August') {
      $bulane = 'September';
    }elseif ($thisMonth == 'September') {
      $bulane = 'Oktober';
    }elseif ($thisMonth == 'October') {
      $bulane = 'November';
    }elseif ($thisMonth == 'November') {
      $bulane = 'Desember';
    }elseif ($thisMonth == 'December') {
      $bulane = 'Januari';
    }

    $waktuBerjalan = $bulanAsli.' '.$explodeYear[1];
    if ($thisMonth == 'December') {
      $bulanDepan = $bulane.' '.($explodeYear[1]+1);
    }else {
      $bulanDepan = $bulane.' '.$explodeYear[1];
    }

    if ($jenis == 'staf') {
        if ($staf > 1) {
          $Staf = implode("', '", $staf);
          $newStaf = "'$Staf'";
          $detailPekerja  = $this->M_indexinfo->getDetailTambahanPrev(true, $newStaf);
        }else {
          $detailPekerja  = $this->M_indexinfo->getDetailTambahanPrev(false, $staf);
        }

        for ($i=0; $i < count($detailPekerja) ; $i++) {
          if (trim($detailPekerja[$i]['jenkel']) == 'L') {
            $jk = 'Sdr. ';
          }elseif (trim($detailPekerja[$i]['jenkel']) == 'P') {
            $jk = 'Sdri. ';
          }
          if (empty($detailPekerja[$i]['bidang']) || $detailPekerja[$i]['bidang'] == '-' || $detailPekerja[$i]['bidang'] == ''){
            $seksiPekerjaStaf = 'Departemen '.ucwords(mb_strtolower($detailPekerja[$i]['dept']));
          }else if(empty($detailPekerja[$i]['unit']) || $detailPekerja[$i]['unit'] == '-' || $detailPekerja[$i]['unit'] == ''){
            $seksiPekerjaStaf = 'Bidang '.ucwords(mb_strtolower($detailPekerja[$i]['bidang']));
          }else if(empty($detailPekerja[$i]['seksi']) || $detailPekerja[$i]['seksi'] == '-' || $detailPekerja[$i]['seksi'] == '') {
            $seksiPekerjaStaf = 'Unit '.ucwords(mb_strtolower($detailPekerja[$i]['unit']));
          }else {
            $seksiPekerjaStaf = 'Seksi '.ucwords(mb_strtolower($detailPekerja[$i]['seksi']));
          }

          $template[$i] = $this->M_indexinfo->getTemplateStaf();
          $parameter_diubah[$i] = array
          (
            '[pekerja]',
            '[seksi]',
            '[alasan]',
            '[periode_gaji]',
            '[bulan_depan]',
            '[last_date]',
            '[today]',
            '[approval]',
            '[jbtn_approval]'
          );
          $parameter_replace[$i] = array
          (
            $jk.ucwords(mb_strtolower($detailPekerja[$i]['nama'])),
            $seksiPekerjaStaf,
            $alasan,
            $waktuBerjalan,
            $bulanDepan,
            date('t', strtotime($thisMonth)),
            date('d').' '.$bulanAsli.' '.date('Y'),
            ucwords(mb_strtolower($tertanda[0]['nama'])),
            ucwords(mb_strtolower($tertanda[0]['jabatan']))
          );
          $cetakTemplate[$i] = str_replace($parameter_diubah[$i], $parameter_replace[$i], $template[$i]);
        }
        $newTempStaf = implode('', $cetakTemplate);
        $data['isi_txt_memo_cutoff'] = $newTempStaf;
        echo json_encode($data);

    }elseif ($jenis == 'nonstaf') {
      $i = 0;
      foreach ($noAtasan as $key) {
        $noind[] = explode('  -  ', $key);
        $no[] = $noind[$i][0];
        $jabatan[] = $noind[$i][2];
        $i++;
      }
      foreach ($jabatan as $v) {
        $saveTemporary  = array(
          'jabatan'  => $v
        );
        $this->M_indexinfo->saveTemporaryJabatan($saveTemporary);
      };
      foreach ($seksi as $value) {
        $saveTemporary  = array(
          'seksi'  => $value
        );
        $this->M_indexinfo->saveTemporary($saveTemporary);
      };
      foreach ($no as $key) {
        $save = array(
          'noind' => $key
        );
        $this->M_indexinfo->saveTemporaryAtasan($save);
      }

      // Punya pekerja
      if ($nstaf != 1) {
        $nstaf = implode("', '", $nstaf);
        $newStaf = "'$nstaf'";
        $detailnonStaf  = $this->M_indexinfo->getDataPekerjaPreviewNonstaf(true, $newStaf);
      }else {
        $detailnonStaf  = $this->M_indexinfo->getDataPekerjaPreviewNonstaf(false, $nstaf);
      }
      foreach ($detailnonStaf as $key) {
        $new[$key['kodesie']][] = $key;
      }

      foreach ($new as $key) {
        $allSeksi[$key['0']['seksi']] = $key;
      }
      //endpekerja


      //ini datanya atasan
      $atasanPerSurat = $this->M_indexinfo->getAtasanPerSurat();
      foreach ($atasanPerSurat as $key) {
        $seksiAtasan[] = $key['seksi'];
      }

      $k = 0;
      foreach ($allSeksi as $keya) {
          $j = array_search($keya[0]['seksi'], $seksiAtasan);

            $atasan[$k]       = $atasanPerSurat[$j]['nama'];
            $seksiAtasan[$k]  = $atasanPerSurat[$j]['jabatan'];
            $tabelPeserta[$k] = '<table style="width: 90%; border: 1px solid black; border-collapse: collapse; text-align: center; margin-left: 10%;">
                                  <tbody>
                                  <tr>
                                  <td style="text-align: center; width:4%; border: 1px solid black; background-color: grey;">
                                  <strong>
                                  No
                                  </strong>
                                  </td>
                                  <td style="text-align: center; width: 11%; border: 1px solid black; background-color: grey;">
                                  <strong>
                                  No<br>
                                  Induk
                                  </strong>
                                  </td>
                                  <td style="text-align: center; width: 35%; border: 1px solid black; background-color: grey;">
                                  <strong>
                                  Nama
                                  </strong>
                                  </td>
                                  <td style="text-align: center; width: 25%; border: 1px solid black; background-color: grey;">
                                  <strong>
                                  Seksi
                                  </strong>
                                  </td>
                                  <td style="text-align: center; width: 25%; border: 1px solid black; background-color: grey;">
                                  <strong>
                                  Keterangan
                                  </strong>
                                  </td>
                                  </tr>';
              $unik = 1;
              foreach ($keya as $key) {
                $tabelPeserta[$k] .= "<tr><td style='text-align: center; border: 1px solid black;'>{$unik}</td><td style='text-align: center; border: 1px solid black;'>{$key['noind']}</td><td style='text-align: center; border: 1px solid black;'>{$key['nama']}</td><td style='text-align: center; border: 1px solid black;'>{$key['seksi']}</td><td style='text-align: center; border: 1px solid black;'>{$key['ket']}</td></tr>";
                $unik++;
              }
              $tabelPeserta[$k] .= "</tbody></table>";

              if (trim($atasanPerSurat[$j]['jenkel']) == 'L') {
                $jk = 'Bp. ';
              }elseif (trim($atasanPerSurat[$j]['jenkel']) == 'P') {
                $jk = 'Ibu. ';
              }else {
                $jk = '';
              }

              $templateNonStaf[$k] = $this->M_indexinfo->getTemplateNonStaf();
              $par_ubah[$k] = array
                          (
                            '[pekerja]',
                            '[seksi]',
                            '[alasan]',
                            '[tabel_list_peserta]',
                            '[periode_gaji]',
                            '[bulan_depan]',
                            '[last_date]',
                            '[today]',
                            '[approval]',
                            '[jbtn_approval]'
                          );
              $par_ganti[$k] = array
                            (
                              $jk.ucwords(mb_strtolower($atasanPerSurat[$j]['nama'])),
                              ucwords(mb_strtolower($atasanPerSurat[$j]['jabatan'])),
                              $alasan,
                              $tabelPeserta[$k],
                              $waktuBerjalan,
                              $bulanDepan,
                              date('t', strtotime($thisMonth)),
                              date('d').' '.$bulanAsli.' '.date('Y'),
                              ucwords(mb_strtolower($tertanda[0]['nama'])),
                              ucwords(mb_strtolower($tertanda[0]['jabatan']))
                            );
              $cetakTemplateNonStaf[$k] = str_replace($par_ubah[$k], $par_ganti[$k], $templateNonStaf[$k]);
              $k++;
            }
          $templatenew = implode('', $cetakTemplateNonStaf);
          $data['isi_txt_memo_cutoff'] = $templatenew;

          echo json_encode($data);
          //untuk delete temporary-nya ini
          $this->M_indexinfo->deleteTemporarySeksi();
          $this->M_indexinfo->deleteTemporaryAtasan();
          $this->M_indexinfo->deleteTemporaryJabatan();
    }
  }

  public function saveInfo()
  {
    $user     = $this->session->user;
    $periode  = $this->input->post('monthpickerq');
    $jenis    = $this->input->post('MPK_infoPekerja');
    $isi      = $this->input->post('MPK_txtaIsi');
    $alasan   = $this->input->post('txtaAlasan');
    $tertanda = $this->input->post('cmbtertandaCutoff');
    //insert to t_log
    $aksi = 'MASTER PEKERJA';
    $detail = 'Create Memo Gaji Pekerja Cutoff Periode= '.$periode;
    $this->log_activity->activity_log($aksi, $detail);
    //
    if ($jenis == 'staf') {
      if (!empty($isi)) {
        $saveMemo = array
        (
          'periode'     => $periode,
          'staff'        => 't',
          'isi_memo'    => $isi,
          'update_by'   => $user,
          'update_date' => date('Y-m-d H:i:s')
        );
        $proses = $this->M_indexinfo->saveMemoStaf($saveMemo);
        redirect('MasterPekerja/Surat/gajipekerjacutoff');
      }
    }elseif ($jenis == 'nonstaf') {
      if (!empty($isi)) {
        $saveMemo = array
        (
          'periode'     => $periode,
          'staff'        => 'f',
          'isi_memo'    => $isi,
          'update_by'   => $user,
          'update_date' => date('Y-m-d H:i:s')
        );
        $proses = $this->M_indexinfo->saveMemoStaf($saveMemo);
        redirect('MasterPekerja/Surat/gajipekerjacutoff');
      }
    }
  }

  public function exportPDF($id)
  {
      //insert to t_log
      $aksi = 'MASTER PEKERJA';
      $detail = 'Export PDF Memo Gaji Pekerja Cutoff ID='.$id;
      $this->log_activity->activity_log($aksi, $detail);
      //
    $date = date('Y-m-d');

    $this->load->library('pdf');
    $pdf = $this->pdf->load();
    $pdf = new mPDF('utf-8','A4-P', 11, 11, 11, 11, 5, 8);
    $data = $this->M_indexinfo->getDataPrint($id);

    $filename = 'Memo Pemberitahuan Pembayaran Gaji Pekerja ter-Cutoff'.$date.'.pdf';

    $pdf->WriteHTML($data[0]['isi_memo']);
    $pdf->setTitle($filename);
    $pdf->Output($filename, 'I');
  }

  public function updateMemo($id)
  {
    $data 	=	$this->general->loadHeaderandSidemenu('Master Pekerja - Quick ERP', 'Update Pemberitahuan Gaji Pekerja Cutoff', 'Surat', 'Memo Pekerja Cutoff');

    $data['getData'] = $this->M_indexinfo->getDataPrint($id);
    $data['hubker'] = $this->M_indexinfo->getHubker();
    // print_r($data['getData']);die;
    $data['tahun'] = str_split($data['getData'][0]['periode'], 4);
    $bulan = $data['tahun'][1];
    $data['bulan'] = $this->konversibulan->KonversiAngkaKeBulan($bulan);

    $periode = $this->M_indexinfo->getPerUpdate($data['getData'][0]['periode']);
    $data['awal']   = date('d', strtotime($periode[0]['tanggal_awal']));
    $data['akhir']  = date('d', strtotime($periode[0]['tanggal_akhir']));
    $data['alasan'] = $this->M_indexinfo->getAlasan();

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('MasterPekerja/Surat/GajiPekerjaCutoff/V_Update',$data);
    $this->load->view('V_Footer',$data);
  }

  public function deleteMemo($id)
  {
    $this->M_indexinfo->deleteMemo($id);
    //insert to t_log
    $aksi = 'MASTER PEKERJA';
    $detail = 'Delete Memo Gaji Pekerja Cutoff ID='.$id;
    $this->log_activity->activity_log($aksi, $detail);
    //
    redirect('MasterPekerja/Surat/gajipekerjacutoff');
  }

}
?>
