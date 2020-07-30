<?php
//hello
defined('BASEPATH') or exit('No direct script access allowed');

class C_Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->library('Excel');
        //load the login model
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->model('M_Index');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        //local
        $this->load->model('PengirimanBarangInternal/M_pbi');

        date_default_timezone_set('Asia/Jakarta');

        if ($this->session->userdata('logged_in')!=true) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect();
        }
    }

    //------------------------show the dashboard-----------------------------
    public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PengirimanBarangInternal/V_Index');
        $this->load->view('V_Footer', $data);
    }

    // ============================INPUT AREA====================================
    public function delete_pbi()
    {
      if ($this->input->is_ajax_request()) {
        $res =  $this->M_pbi->delete_pbi($this->input->post('no_doc'));
        echo json_encode($res);
      }else {
        echo "Akses Diblokir";
      }

    }

    public function edit_pbi()
    {
      if ($this->input->is_ajax_request()) {
        $data = [
          'NO_TRANSFER_ASET' => $this->input->post('no_transfer_asset'),
          'KETERANGAN' => $this->input->post('keterangan'),
          'USER_TUJUAN' => $this->input->post('user_tujuan'),
          'SEKSI_TUJUAN' => $this->input->post('seksi_tujuan')
        ];
        $final = $this->M_pbi->edit_pbi($this->input->post('no_doc'), $data);
        echo json_encode($final);
      }else {
        echo "Akses Diblokir!";
      }
    }

    public function seksi_tujuan()
    {
        $term = strtoupper($this->input->post('term'));
        echo json_encode($this->M_pbi->getSeksi($term));
    }

    public function listCode()
    {
        $term = strtoupper($this->input->post('term'));
        echo json_encode($this->M_pbi->listCode($term));
    }

    public function employee()
    {
        $term = strtoupper($this->input->post('term'));
        echo json_encode($this->M_pbi->employee($term));
    }

    public function atasan_employee()
    {
        $term = strtoupper($this->input->post('term'));
        echo json_encode($this->M_pbi->atasan_employee($term));
    }


    public function autofill()
    {
        $term = strtoupper($this->input->post('code'));
        $cek = $this->M_pbi->autofill($term);
        if (!empty($cek)) {
          echo json_encode($cek);
        }else {
          echo json_encode(0);
        }
    }

    public function cekComponent()
    {
        $term = strtoupper($this->input->post('code'));
        echo json_encode($this->M_pbi->cekComponent($term));
    }

    public function getSeksiku()
    {
        $no_ind = $this->session->user;
        $data = $this->M_pbi->getSeksiku($no_ind);
        echo json_encode($data);
    }

    public function getSeksimu()
    {
        $no_ind = $this->input->post('code');
        $data = $this->M_pbi->getSeksiku($no_ind);
        echo json_encode($data);
    }

    public function input()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        $data['error'] = '';

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PengirimanBarangInternal/V_input');
        $this->load->view('V_Footer', $data);
    }

    public function SaveAssets()
    {
      //==========generate document_number=====
      $newNumber = $this->M_pbi->generateTicketPBI();
      //==========end generate========

      // ======== header data ===========
      $nama_pengirim  = $this->input->post('nama_pengirim');
      $seksi_pengirim = $this->input->post('seksi_pengirim');
      $seksi_tujuan   = $this->input->post('seksi_tujuan'); // SADARNYA BLAKANGAN ~_-
      $user_tujuan    = $this->input->post('employee_seksi_tujuan');
      $tujuan         = $this->input->post('tujuan');
      $no_trans       = $this->input->post('no_trans');
      $type           = $this->input->post('type');
      $atasan         = $this->input->post('atasan');
      // ======== line data ===========
      $line           = $this->input->post('line_number');
      $item_code      = $this->input->post('item_code');
      $description    = $this->input->post('description');
      $quantity       = $this->input->post('quantity');
      $uom            = $this->input->post('uom');
      $item_type      = $this->input->post('item_type');
      $keterangan     = $this->input->post('keterangan');

      foreach ($line as $key => $l) {
          $data = [
            'DOC_NUMBER'      => $newNumber,
            'SEKSI_KIRIM'     => $seksi_pengirim,
            'SEKSI_TUJUAN'    => $seksi_tujuan,
            'TUJUAN'          => $tujuan,
            'USER_TUJUAN'     => $user_tujuan,
            'LINE_NUM'        => $line[$key],
            'ITEM_CODE'       => strtoupper($item_code[$key]),
            'ITEM_TYPE'       => strtoupper($item_type[$key]),
            'DESCRIPTION'     => strtoupper($description[$key]),
            'QUANTITY'        => $quantity[$key],
            'UOM'             => $uom[$key],
            'STATUS'          => 1,
            'CREATED_BY'      => $this->session->user,
            'TYPE'            => $type,
            'NO_TRANSFER_ASET'=> strtoupper($no_trans),
            'ATASAN'          => $atasan,
            'KETERANGAN'      => strtoupper($keterangan)
          ];
          $res = $this->M_pbi->insert($data);
      }
      $data = [
        'res'=> $res,
        'fpb'=> $newNumber
      ];
      echo json_encode($data);
    }

    public function updateApproval()
    {
      $res = $this->M_pbi->updateApproval($this->input->post('app_stat'), $this->input->post('nodoc'));
      echo json_encode($res);
    }

    public function SendEmail()
    {
      $no_trans       = $this->input->post('no_trans');
      $atasan         = $this->input->post('atasan');
      $fpb            = $this->input->post('fpb');
      $seksi_tujuan   = $this->input->post('seksi_tujuan');
      $user_tujuan    = $this->input->post('employee_seksi_tujuan');
      $tujuan         = $this->input->post('tujuan');

      $nama_atasan    = $this->M_pbi->atasan_employee($atasan);
      $nama_user_tjn  = $this->M_pbi->employee($user_tujuan);
      $user_login     = $this->session->user;
      $nama_user_login= $this->session->employee;
      // ======== line data ===========
      $item_code = $this->input->post('item_code');
      foreach ($item_code as $key => $value) {
        $dataline[] = [
          'line_number' => $this->input->post('line_number')[$key],
          'item_code' => $value,
          'description' => $this->input->post('description')[$key],
          'quantity' => $this->input->post('quantity')[$key],
          'uom' => $this->input->post('uom')[$key],
          'item_type' => $this->input->post('item_type')[$key],
        ];
      }

      foreach ($dataline as $key => $value) {
        $html[] = '<tr>
          <td class="tg-baqh">'.($key+1).'</td>
          <td class="tg-0lax">'.$value['item_code'].'</td>
          <td class="tg-0lax">'.$value['description'].'</td>
          <td class="tg-0lax">'.$value['quantity'].'</td>
          <td class="tg-0lax">'.$value['uom'].'</td>
        </tr>';
      }
      $tampung = implode(' ', $html);
      // simon_hertoyo@quick.com;
       // $nama_atasan[0]['email_internal'];
      $PBIemail 		=  'simon_hertoyo@quick.com';
      $PBIccemail 	=  '';
      // $PBRbccemail 	=  $this->input->post('PBRbccemail');
      $PBIsubject		=  'Approval Pengiriman Barang Internal Asset - '.$fpb;
      $PBIisi				=  'Kepada Yth. Bapak/Ibu <b>'.$nama_atasan[0]['nama'].' ('.$atasan.')</b> <br><br>
                        Anda memiliki tanggungan Approval untuk Pengiriman Barang Internal (Asset) dari
                        <b>'.$nama_user_login.' ('.$user_login.') </b>, dengan detail sebagai berikut : <br><br>
                        No. FPB : <b>'.$fpb.'</b><br>
                        No. Transfer Asset : <b>'.$no_trans.'</b><br>
                        Tujuan : <b>'.$tujuan.'</b><br>
                        User Tujuan : <b>'.$nama_user_tjn[0]['employee_name'].' ('.$user_tujuan.')</b><br>
                        Seksi : <b>'.$seksi_tujuan.'</b><br><br>
                        <style type="text/css">
                        .tg  {border-collapse:collapse;border-spacing:0;}
                        .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:13px;
                          overflow:hidden;padding:10px 5px;word-break:normal;}
                        .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:13px;
                          font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
                        .tg .tg-zwpx{background-color:#dae8fc;font-size:13px;font-weight:bold;text-align:left;vertical-align:top}
                        .tg .tg-za0e{background-color:#dae8fc;border-color:#000000;color:#000000;font-size:13px;font-weight:bold;text-align:center;
                          vertical-align:top}
                        .tg .tg-baqh{text-align:center;vertical-align:top}
                        .tg .tg-0lax{text-align:left;vertical-align:top}
                        </style>
                        <table class="tg">
                        <thead>
                          <tr>
                            <th class="tg-za0e">No.</th>
                            <th class="tg-zwpx"><span style="font-weight:bold;font-style:normal">Kode Item</span></th>
                            <th class="tg-zwpx">Deskripsi</th>
                            <th class="tg-zwpx">Quantity</th>
                            <th class="tg-zwpx">UOM</th>
                          </tr>
                        </thead>
                        <tbody>
                        '.$tampung.'
                        </tbody>
                        </table>
                        <br>
                        Silahkan login ERP untuk melakukan approval atau klik link berikut : <br>
                        <a href="http://192.168.168.196/khs-erp-pbi/PengirimanBarangInternal/Approval">Approval Pengiriman Barang Internal (Asset)</a>
                        <br><br>
                        Terima kasih.';
      $toEmail			= preg_replace('/\s+/', '', explode(',', $PBIemail));
      $ccEmail			= preg_replace('/\s+/', '', explode(',', $PBIccemail));
      //$bccEmail		= preg_replace('/\s+/', '', explode(',', $PBRbccemail));

      if (empty($PBIisi)) {
          $PBIisi = '';
      }

      // Load library email
      $this->load->library('PHPMailerAutoload');
      $mail = new PHPMailer();
      $mail->SMTPDebug = 0;
      $mail->Debugoutput = 'html';

      // Set connection SMTP Webmail
      $mail->isSMTP();
      $mail->Host 			= 'mail.quick.com';
      $mail->Port 			= 25;
      $mail->SMTPAuth 	= true;
      //$mail->SMTPDebug = 1;
      //$mail->SMTPSecure = 'ssl';
      $mail->SMTPOptions = array(
          'ssl' => array(
              'verify_peer' => false,
              'verify_peer_name' => false,
              'allow_self_signed' => true)
          );

      $mail->Username = 'no-reply@quick.com';
      $mail->Password = '123456';
      $mail->WordWrap = 50;

      // Set email content to sent
      $mail->setFrom('no-reply@quick.com', 'ERP PBI');
      foreach ($ccEmail as $key => $ccE) {
          $mail->AddCC($ccE);
      }
      foreach ($toEmail as $key => $toE) {
          $mail->addAddress($toE);
      }

      //this is for Attachment
      // if (isset($_FILES['PBRfile_att']) && $_FILES['PBRfile_att']['error'] == UPLOAD_ERR_OK) {
      //     $mail->AddAttachment($_FILES['PBRfile_att']['tmp_name'], $_FILES['PBRfile_att']['name']);
      // };
      $mail->Subject = $PBIsubject;
      $mail->msgHTML($PBIisi);

      // Send email
      if (!$mail->send()) {
          echo json_encode($mail->ErrorInfo);
      } else {
          echo json_encode('Message sent!');
      }
    }

    public function SaveNon()
    {
      //==========generate document_number=====
    //   $time 				= date('ymd');
    //   $lastNumber   = $this->M_pbi->lastDocumentNumber('FPB'.$time);
    //   if (empty($lastNumber[0]['DOC_NUMBER'])) {
    //       $newNumber = 'FPB'.$time.'001';
    //   } else {
    //       $newNumber = $lastNumber[0]['DOC_NUMBER']+1;
    //       if (strlen($newNumber) < 3) {
    //           $newNumber = str_pad($newNumber, 3, "00", STR_PAD_LEFT);
    //       }
    //       $newNumber = 'FPB'.$time.$newNumber;
    //   }
      $newNumber = $this->M_pbi->generateTicketPBI();
      //==========end generate========

      // ======== header data ===========
      $nama_pengirim  = $this->input->post('nama_pengirim');
      $seksi_pengirim = $this->input->post('seksi_pengirim');
      $seksi_tujuan   = $this->input->post('seksi_tujuan'); // SADARNYA BLAKANGAN ~_-
      $user_tujuan    = $this->input->post('employee_seksi_tujuan');
      $tujuan         = $this->input->post('tujuan');
      $type           = $this->input->post('type');
      // ======== line data ===========
      $line           = $this->input->post('line_number');
      $item_code      = $this->input->post('item_code');
      $description    = $this->input->post('description');
      $quantity       = $this->input->post('quantity');
      $uom            = $this->input->post('uom');
      $item_type      = $this->input->post('item_type');
      $keterangan     = $this->input->post('keterangan');

      foreach ($line as $key => $l) {
          $data = [
        'DOC_NUMBER'      => $newNumber,
        'SEKSI_KIRIM'     => $seksi_pengirim,
        'SEKSI_TUJUAN'    => $seksi_tujuan,
        'TUJUAN'          => $tujuan,
        'USER_TUJUAN'     => $user_tujuan,
        'LINE_NUM'        => $line[$key],
        'ITEM_CODE'       => strtoupper($item_code[$key]),
        'ITEM_TYPE'       => strtoupper($item_type[$key]),
        'DESCRIPTION'     => strtoupper($description[$key]),
        'QUANTITY'        => $quantity[$key],
        'UOM'             => $uom[$key],
        'STATUS'          => 1,
        'CREATED_BY'      => $this->session->user,
        'MO'              => '',
        'NO_TRANSFER_ASET'=> '',
        'TYPE'            => $type,
        'ATASAN'          => '',
        'KETERANGAN'      => strtoupper($keterangan)
      ];
          $this->M_pbi->insert($data);
      }
      echo '<script type="text/javascript">
            function openWindows(){
                window.open("'.base_url('PengirimanBarangInternal/Cetak/'.$newNumber).'");
                window.location.replace("'.base_url('PengirimanBarangInternal/Input').'");
            }
            openWindows();
          </script>';
    }

    public function cek_no_mo()
    {
      foreach ($this->input->post('mo') as $key => $v) {
        $hasil = $this->M_pbi->cek_no_mo($v);
        if (!empty($hasil->NO_MOVE_ORDER)) {
          $cek = 0;
          break;
        }else {
          $cek = 1;
        }
      }
      $data = [
        'status' => $cek,
        'mo' => $v
      ];
      echo json_encode($data);
    }

    public function getDetailMo()
    {
      if ($this->input->is_ajax_request()) {
        $param = $this->input->post('mo');
        // foreach ($param as $key => $value) {
          echo json_encode($this->M_pbi->getDetailMo($param));
        // }
      }
    }

    public function hapusMO($monya)
    {
      $this->M_pbi->deleteMO($monya);
    }

    public function Save()
    {
        $mo        = $this->input->post('mo');
        $cek_no_mo = $this->M_pbi->cek_no_mo($mo);
        if (empty($cek_no_mo->NO_MOVE_ORDER)) {
          //==========generate document_number=====
        //   $time 				= date('ymd');
        //   $lastNumber   = $this->M_pbi->lastDocumentNumber('FPB'.$time);
        //   if (empty($lastNumber[0]['DOC_NUMBER'])) {
        //       $newNumber = 'FPB'.$time.'001';
        //   } else {
        //       $newNumber = $lastNumber[0]['DOC_NUMBER']+1;
        //       if (strlen($newNumber) < 3) {
        //           $newNumber = str_pad($newNumber, 3, "00", STR_PAD_LEFT);
        //       }
        //       $newNumber = 'FPB'.$time.$newNumber;
        //   }
          $newNumber = $this->M_pbi->generateTicketPBI();
          //==========end generate========

          // ======== header data ===========
          $tujuan         = $this->input->post('tujuan');
          $type           = $this->input->post('type');
          // ======== line data ===========
          $nama_pengirim  = $this->input->post('nama_pengirim');
          $seksi_pengirim = $this->input->post('seksi_pengirim');
          $seksi_tujuan   = $this->input->post('seksi_tujuan'); // SADARNYA BLAKANGAN ~_-
          $user_tujuan    = $this->input->post('employee_seksi_tujuan');

          $line           = $this->input->post('line_number');
          $item_code      = $this->input->post('item_code');
          $description    = $this->input->post('description');
          $quantity       = $this->input->post('quantity');
          $uom            = $this->input->post('uom');
          $item_type      = $this->input->post('item_type');
          $item_mo        = $this->input->post('item_mo');
          $keterangan     = $this->input->post('keterangan');

          foreach ($line as $key => $l) {
              $data = [
            'DOC_NUMBER'    => $newNumber,
            'SEKSI_KIRIM'   => $seksi_pengirim[$key],
            'SEKSI_TUJUAN'  => $seksi_tujuan[$key],
            'TUJUAN'        => $tujuan,
            'USER_TUJUAN'   => $user_tujuan[$key],
            'LINE_NUM'      => $line[$key],
            'ITEM_CODE'     => strtoupper($item_code[$key]),
            'ITEM_TYPE'     => strtoupper($item_type[$key]),
            'DESCRIPTION'   => strtoupper($description[$key]),
            'QUANTITY'      => $quantity[$key],
            'UOM'           => $uom[$key],
            'STATUS'        => 2,
            'CREATED_BY'    => $nama_pengirim[$key],
            'MO'            => $item_mo[$key],
            'TYPE'          => $type,
            'KETERANGAN'    => strtoupper($keterangan)
          ];
              $this->M_pbi->insertMO($data);
          }
          $this->checkSession();
          $user_id = $this->session->userid;

          $data['Menu'] = 'Dashboard';
          $data['SubMenuOne'] = '';

          $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
          $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
          $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

          $data['error'] = '<br><div class="alert alert-success alert-dismissible no-border fade in mb-2" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">
                                  <i class="icon-cross2"></i>
                                </span>
                              </button>
                              <strong>Data telah berhasil disimpan !</strong>
                            </div>';

          $this->load->view('V_Header', $data);
          $this->load->view('V_Sidemenu', $data);
          $this->load->view('PengirimanBarangInternal/V_input', $data);
          $this->load->view('V_Footer', $data);

        }else {
          $this->checkSession();
          $user_id = $this->session->userid;

          $data['Menu'] = 'Dashboard';
          $data['SubMenuOne'] = '';

          $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
          $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
          $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

          $data['error'] = '<br><div class="alert alert-danger alert-dismissible no-border fade in mb-2" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">
                                  <i class="icon-cross2"></i>
                                </span>
                              </button>
                              <strong>Peringatan!</strong> No MO <b>'.$mo.'</b> telah ada di database.
                            </div>';

          $this->load->view('V_Header', $data);
          $this->load->view('V_Sidemenu', $data);
          $this->load->view('PengirimanBarangInternal/V_input', $data);
          $this->load->view('V_Footer', $data);
        }

    }

    // =========================MONITORING AREA====================================

    public function monitoring()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['get'] = $this->M_pbi->GetMasterD();

        foreach ($data['get'] as $key => $g) {
            $seksi = $this->M_pbi->getSeksiku($g['USER_TUJUAN']);
            if (!empty($seksi)) {
              $data['seksi_tujuan'][] = $seksi->seksi;
            }else {
              $data['seksi_tujuan'][] = $g['USER_TUJUAN'];
            }
        }

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PengirimanBarangInternal/V_monitoring');
        $this->load->view('V_Footer', $data);
    }

    public function monitoring_ajx()
    {
        $data['get'] = $this->M_pbi->GetMasterD();

        foreach ($data['get'] as $key => $g) {
            $seksi = $this->M_pbi->getSeksiku($g['USER_TUJUAN']);
            if (!empty($seksi)) {
              $data['seksi_tujuan'][] = $seksi->seksi;
            }else {
              $data['seksi_tujuan'][] = $g['USER_TUJUAN'];
            }
        }
        $this->load->view('PengirimanBarangInternal/ajax/V_monitoring', $data);
    }

    public function Detail()
    {
        $term = strtoupper($this->input->post('nodoc'));
        $data['get'] = $this->M_pbi->Detail($term);

        $this->load->view('PengirimanBarangInternal/V_Detail', $data);
    }

    public function DetailApp()
    {
        $term = strtoupper($this->input->post('nodoc'));
        $data['get'] = $this->M_pbi->Detail($term);

        $this->load->view('PengirimanBarangInternal/V_Detail_App', $data);
    }

    public function monitoringPenerimaan()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['get'] = $this->M_pbi->GetMasterDD();
        foreach ($data['get'] as $key => $g) {
            $seksi = $this->M_pbi->getSeksiku($g['USER_TUJUAN']);
            if (!empty($seksi)) {
              $data['seksi_tujuan'][] = $seksi->seksi;
            }else {
              $data['seksi_tujuan'][] = $g['USER_TUJUAN'];
            }
        }

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PengirimanBarangInternal/V_monitoring_penerimaan');
        $this->load->view('V_Footer', $data);
    }

    public function updatePeneriamaan()
    {
        $doc = $this->input->post('doc');
        echo json_encode($this->M_pbi->updatePeneriamaan($doc));
    }
    // ========================= END MONITORING AREA====================================

    // =========================== CETAKAN AREA ====================================

    public function Cetak($doc)
    {
        $data['get'] = $this->M_pbi->Cetak($doc);
        $data['seksi_tujuan'] = $this->M_pbi->getSeksiku($data['get'][0]['USER_TUJUAN']);
        $data['nama_pengirim'] = $this->M_pbi->employee($data['get'][0]['CREATED_BY']);
        $data['user_tujuan'] = $this->M_pbi->employee($data['get'][0]['USER_TUJUAN']);
        $jb = $this->M_pbi->jenisBarang($doc);
        foreach ($jb as $key => $j) {
            $jx[] = $j['ITEM_TYPE'];
        }
        $data['jenisbarang'] = implode(' / ', $jx);

        if (!empty($doc)) {
            // ====================== do something =========================
            $this->load->library('Pdf');

            $pdf 		= $this->pdf->load();
            $this->load->library('ciqrcode');
            $pdf 		= new mPDF('utf-8', array(210 , 148), 0, '', 3, 3, 3, 0, 0, 3);

            // ------ GENERATE QRCODE ------
            if (!is_dir('./assets/img/PBIQRCode')) {
                mkdir('./assets/img/PBIQRCode', 0777, true);
                chmod('./assets/img/PBIQRCode', 0777);
            }

            $params['data']		= $data['get'][0]['DOC_NUMBER'];
            $params['level']	= 'H';
            $params['size']		= 5;
            $params['black']	= array(255,255,255);
            $params['white']	= array(0,0,0);
            $params['savename'] = './assets/img/PBIQRCode/'.$data['get'][0]['DOC_NUMBER'].'.png';
            $this->ciqrcode->generate($params);

            ob_end_clean() ;
            $filename 	= $doc.'.pdf';
            $isi 				= $this->load->view('PengirimanBarangInternal/pdf/V_Pdf', $data, true);
            $pdf->WriteHTML($isi);
            $pdf->Output($filename, 'I');
        } else {
            echo json_encode(array(
      'success' => false,
      'message' => 'id is null'
    ));
        }

        if (!unlink($params['savename'])) {
            echo("Error deleting");
        } else {
            unlink($params['savename']);
        }
    }

    // =========================== END CETAKAN AREA ====================================

    // =================================== APPROVAL ====================================

    public function Approval()
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Dashboard';
      $data['SubMenuOne'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
      $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

      $data['get'] = $this->M_pbi->GetMasterByApproval();

      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('PengirimanBarangInternal/V_monitoring_approval');
      $this->load->view('V_Footer', $data);
    }

    // ============================ CHECK AREA =====================================
    public function cekapi()
    {
        $term = 'CABANG';
        $data = $this->M_pbi->GetMaster();
        echo "<pre>";
        print_r($data);
        die;
    }
}
