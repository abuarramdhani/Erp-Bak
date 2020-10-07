<?php

class C_Web extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Apidobackup/M_web');
        // $this->checkSession(); 
    }

    // LINE_NUMBER, HEADER_ID, LINE_ID, REQUEST_NUMBER, ITEM, ITEM_ID, DESCRIPTION, UOM_CODE, QUANTITY, REQUIRED_QTY

    public function cekapi()
    {
      // exec khs_insert_dospb_backup(sysdate);
      $data = $this->M_web->param();

      echo "<pre>";
      print_r($data);
      die;
    }

    public function master($value='')
    {
      // exsekusi prosedur
      $this->M_web->run();
      $param = $this->M_web->param();
       foreach ($param as $key => $val) {
        $this->generatePDF($val['DO_SPB']);
      }
      echo "</script>Halaman akan reload setiap 1 Jam</script>";
      echo " <meta http-equiv=refresh content=3600; url=http://erp.quick.com/Apidobackup/engine/master> ";
     
    }

    public function generatePDF($id)
    {
      $data['get_header'] = $this->M_web->headerSurat($id);
      $data['get_body'] = $this->M_web->getBody($id);
      $data['get_serial'] = $this->M_web->serial($id);
      $data['get_footer'] = $this->M_web->footersurat($id);
      $data['totalbody'] = sizeof($data['get_body']);
      $data['totalserial'] = sizeof($data['get_serial']);
      $data['cek_spb_do'] = $this->M_web->cekSpbDo($id);

      if (!empty($data['get_serial'])) {
          $s = [];
          $hasil = [];
          foreach ($data['get_serial'] as $a) {
              array_push($s, $a['DESCRIPTION']);
          }
          $sai = array_unique($s);
          $set = array_values($sai);
          for ($i=0; $i < sizeof($set); $i++) {
              $explode = explode(' ', $set[$i]);
              array_push($hasil, $explode[0]);
          }
          $data['check_header_sub'] = $set;

          foreach ($hasil as $key => $value) {
             $tampungan[$value] = $value;
          }
          $data['header_sub'] = $tampungan;
      }
      if (!empty($id)) {
          // ====================== do something =========================
          $this->load->library('Pdf');
          $pdf        = $this->pdf->load();
          $this->load->library('ciqrcode');
          $pdf        = new mPDF('utf-8', array(210 , 267), 0, '', 3, 3, 3, 0, 0, 0);
          // $pdf->showWatermarkText = true;
          // ------ GENERATE QRCODE ------
          if (!is_dir('./assets/img/monitoringDOQRCODE')) {
              mkdir('./assets/img/monitoringDOQRCODE', 0777, true);
              chmod('./assets/img/monitoringDOQRCODE', 0777);
          }
          // echo "<pre>";
          // print_r($data['get_header'][0]['REQUEST_NUMBER']);
          // die;
          $params['data']     = $data['get_header'][0]['REQUEST_NUMBER'];
          $params['level']    = 'H';
          $params['size']     = 4;
          $params['black']    = array(255,255,255);
          $params['white']    = array(0,0,0);
          $params['savename'] = './assets/img/monitoringDOQRCODE/'.$data['get_header'][0]['REQUEST_NUMBER'].'.png';
          $this->ciqrcode->generate($params);
          ob_end_clean() ;

          $filename   = $id.'.pdf';
          $aku        = $this->load->view('Apidobackup/V_Pdf', $data, true);
            
         

          if (ceil(strlen($data['get_footer'][0]['DESCRIPTION'])/27) == 1) {
            $a = '<br>'.$data['get_footer'][0]['DESCRIPTION'].'<br><br><br><br><br>';
          }elseif (ceil(strlen($data['get_footer'][0]['DESCRIPTION'])/27) == 2) {
            $a = '<br>'.$data['get_footer'][0]['DESCRIPTION'].'<br><br><br><br>';
          }elseif (ceil(strlen($data['get_footer'][0]['DESCRIPTION'])/27) == 3) {
            $a = '<br>'.$data['get_footer'][0]['DESCRIPTION'].'<br><br><br>';
          }elseif (ceil(strlen($data['get_footer'][0]['DESCRIPTION'])/27) == 4) {
            $a = '<br>'.$data['get_footer'][0]['DESCRIPTION'].'<br><br>';
          }elseif (ceil(strlen($data['get_footer'][0]['DESCRIPTION'])/27) == 5) {
            $a = $data['get_footer'][0]['DESCRIPTION'];
          }elseif (ceil(strlen($data['get_footer'][0]['DESCRIPTION'])/27) == 0) {
            $a = '<br><br><br><br><br><br>';
          }
          if (!empty($data['get_footer'][0]['APPROVED_BY'])) {
            $appr = '<center>Approved by <br>'.$data['get_footer'][0]['APPROVED_BY'].'<br><br><br>'.$data['get_footer'][0]['APPROVER_NAME'].'</center>';
          }else {
            $appr = '';
          }
          if (!empty($data['get_footer'][0]['CREATED_BY'])) {
            $appr2 = '<center>Approved by <br>'.$data['get_footer'][0]['CREATED_BY'].'<br><br><br>'.$data['get_footer'][0]['CREATOR_NAME'].'</center>';
          }else {
            $appr2 = '';
          }
          // $newDate = date("m-d-Y", strtotime($orgDate));
          $pdf->SetHTMLFooter('<table style="width:100%; border-collapse: collapse !important; margin-top:2px;overflow: wrap;">
              <tr style="width:100%">
                  <td rowspan="2" style="height:300px;white-space:pre-line;vertical-align:top;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;font-size:10px;padding:5px">Catatan :
              '.strtoupper($a).'
                   </td>
                  <td rowspan="3" style="vertical-align:top;width:98px;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;font-size:10px;padding:5px;">Penerima Barang :
                      <br><br>
                      Tgl. ________
                      <br><br><br><br><br><br><br><br>
                  </td>
                  <td rowspan="3" style="vertical-align:top;width:90px;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;font-size:10px;padding:5px">Pengirim : <br> <br>
                      Tgl. _______
                      <br><br><br><br><br><br><br><br>
                  </td>
            <td rowspan="3" style="vertical-align:top;width:90px;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;font-size:10px;padding:5px">Pengeluaran : <br> <br>
              Tgl. _______
              <br><br><br><br><br><br><br><br>
            </td>
                  <td rowspan="3" style="vertical-align:top;width:95px;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;font-size:10px;padding:5px">Gudang : <br><br>
                      Tgl. '.$data['get_footer'][0]['ASSIGN_DATE'].'
                      <br><br><br><br><br><br>'.$data['get_footer'][0]['ASSIGNER_NAME'].'
                  </td>
                  <td colspan="2" style="vertical-align:top;border-right: 1px solid black; border-top: 1px solid black;border-left: 1px solid black;font-size:10px;padding:5px;height:20px!important;">Pemasaran :</td>
              </tr>
              <tr>
                  <td rowspan="2" style="vertical-align:top;width:100px;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;font-size:10px;padding:5px">Mengetahui :
                      <br><br>'.$appr.'
                  </td>
                  <td rowspan="2" style="vertical-align:top;width:100px;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;border-right: 1px solid black;font-size:10px;padding:5px">Tgl. '.$data['get_footer'][0]['CREATION_DATE'].'
                      <br><br>'.$appr2.'
                  </td>
              </tr>
              <tr>
                  <td style="vertical-align:top;border-left: 1px solid black;border-bottom: 1px solid black;font-size:8.5px;padding:5px;height:60px!important;">Perhatian :<br>Barang yang dibeli tidak dapat dikembalikan, <br> kecuali ada perjanjian sebelumnya.</td>
              </tr>
          </table>
          <i style="font-size:10px;">
            *Putih : Ekspedisi &nbsp;&nbsp;&nbsp;&nbsp;Merah : Marketing &nbsp;&nbsp;&nbsp;&nbsp;Kuning : Akuntansi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hijau : Customer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Biru : Gudang FG
          </i>');
          $pdf->SetFillColor(0,255,0);
          // $pdf->SetAlpha(0.4);
          $pdf->WriteHTML($aku);

          // if(!empty($_POST['FILE_LOCATION'])){
         $pdf->Output('assets/upload/DO_SPB_TAMPUNG/'.$filename, 'F');
          // $sql = "UPDATE KHS_DO_SPB_BACKUP SET FILE_LOCATION=";}
      // ========================end process=========================
      } else {
          echo json_encode(array(
        'success' => false,
        'message' => 'id is null'
      ));
      }
      // if (!unlink($params['savename'])) {
      //     echo("Error deleting");
      // } else {
      //     unlink($params['savename']);
      // }

    //   echo "<script>window.close();</script>";

    }


}
