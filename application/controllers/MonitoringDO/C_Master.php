<?php
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
        $this->load->model('MonitoringDO/M_monitoringdo');

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
        $this->load->view('MonitoringDO/V_Index');
        $this->load->view('V_Footer', $data);
    }

    public function SettingDO()
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
        $this->load->view('MonitoringDO/V_Setting', $data);
        $this->load->view('V_Footer', $data);
    }

    public function countDO()
    {
      $data[0] = '';
      $data[1] = '';
      $data[2] = '';
      $data[3] = '';
      $data[4] = '';
      // $data[0] = sizeof($this->M_monitoringdo->getDO());
      // $data[1] = sizeof($this->M_monitoringdo->sudahdiAssign());
      // $data[2] = sizeof($this->M_monitoringdo->sudahdiLayani());
      // $data[3] = sizeof($this->M_monitoringdo->sudahdiMuat());
      // $data[4] = sizeof($this->M_monitoringdo->GetSudahCetakCekFoCount());
      echo json_encode($data);
    }

    public function GetSetting()
    {
      $datag = $this->M_monitoringdo->getDO();
      // echo "<pre>";
      // print_r($datag);
      // die;
      if (!empty($datag[0]['DO/SPB'])) {
        foreach ($datag as $g) {
            $dataku[] = $g['DO/SPB'];
        }
        $no = 0;
        foreach ($dataku as $k) {
            $datakau[] = $this->M_monitoringdo->getDetailDataPengecekan($k);
            $no++;
        }

        $final = [];
        foreach ($datakau as $f) {
            for ($i=0; $i < sizeof($f); $i++) {
                if ($f[$i]['QUANTITY']>$f[$i]['AV_TO_RES']) {
                    $var = 'false';
                    break;
                } else {
                    $var = 'true';
                }
            }
            array_push($final, $var);
        }

        $finaldestination = [];
        $number = 0;
        foreach ($datag as $d) {
            $d['CHECK'] = $final[$number];
            $number++;
            array_push($finaldestination, $d);
        }
        $data['get'] = $finaldestination;
      }else {
        $data['get'] = $this->M_monitoringdo->getDO();
      }

      $this->load->view('MonitoringDO/V_Ajax_Setting', $data);
    }

    public function InputDO()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        $data['assign'] = $this->M_monitoringdo->getAssign();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('MonitoringDO/V_Input', $data);
        $this->load->view('V_Footer', $data);
    }

    public function InsertManualDo()
    {
        $id = $this->input->post('requests_number');
        $user = $this->input->post('person_id');
        $data = $this->M_monitoringdo->getDataSelected($id);

        echo json_encode($this->M_monitoringdo->insertDO(array(
          'HEADER_ID' => $data[0]['HEADER_ID'],
          'REQUEST_NUMBER' => $id,
          'PERSON_ID' => $user,
          'DELIVERY_FLAG'=> 'N'
      )));
    }

    public function InsertDo()
    {
        echo json_encode($this->M_monitoringdo->insertDO(array(
            'HEADER_ID' => $this->input->post('header_id'),
            'REQUEST_NUMBER' => $this->input->post('requests_number'),
            'PERSON_ID' => strtoupper($this->input->post('person_id')),
            'DELIVERY_FLAG'=> 'N'
        )));
    }

    public function insertPlatnumber()
    {
      $plat = strtoupper($this->input->post('plat_nomer'));
      $rm = $this->input->post('rm');
      $hi = $this->input->post('hi');
      $data = [
        'PLAT_NUMBER' => $plat,
        'DELIVERY_FLAG'=> 'Y',
      ];
      $this->M_monitoringdo->updatePlatnumber($data, $rm, $hi);
      echo json_encode('sukses');
    }

    public function insertDOtampung()
    {

      function get_client_ip() {
          $ipaddress = '';
          if (isset($_SERVER['HTTP_CLIENT_IP']))
              $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
          else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
              $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
          else if(isset($_SERVER['HTTP_X_FORWARDED']))
              $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
          else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
              $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
          else if(isset($_SERVER['HTTP_FORWARDED']))
              $ipaddress = $_SERVER['HTTP_FORWARDED'];
          else if(isset($_SERVER['REMOTE_ADDR']))
              $ipaddress = $_SERVER['REMOTE_ADDR'];
          else
              $ipaddress = 'UNKNOWN';
          return $ipaddress;
      }
      $tampungan = $this->input->post('array_atr');
      array_pop($tampungan);
      $rm = $this->input->post('requests_number');
      foreach ($tampungan as $t) {
        $data = [
          'HEADER_ID' => $this->input->post('header_id'),
          'REQUEST_NUMBER' => $rm,
          'INVENTORY_ITEM_ID' => $t,
          'ORDER_NUMBER' => $this->input->post('order_number'),
          'IP_ADDRESS' => get_client_ip()
        ];
        $this->M_monitoringdo->insertDOtampung($data);
      }

      // $this->M_monitoringdo->runAPIDO($rm);
      $this->M_monitoringdo->DeleteDOtampung($rm, get_client_ip());

      echo json_encode('sukses!!!');
    }

    public function GetDetail()
    {
        $id = $this->input->post('requests_number');
        $data['get'] = $this->M_monitoringdo->getDetailData($id);
        $this->load->view('MonitoringDO/V_Ajax', $data);
    }

    public function GetDetailCheck()
    {
        $id = $this->input->post('requests_number');
        $data = $this->M_monitoringdo->getDetailData($id);
        echo json_encode($data);
    }

    public function GetTransact()
    {
        $data['get'] = $this->M_monitoringdo->sudahdiMuat();
        $this->load->view('MonitoringDO/V_Ajax_Transact', $data);
    }

    public function GetTransactDetail()
    {
        $id = $this->input->post('requests_number');
        $data['get'] = $this->M_monitoringdo->sudahdiMuat_detail($id);
        $this->load->view('MonitoringDO/V_Ajax_Transact_detail', $data);
    }

    public function GetSudahCetak()
    {
       // $data['get'] = $this->M_monitoringdo->sudahCetak();
       $data['get'] = $this->M_monitoringdo->GetSudahCetak();
       $this->load->view('MonitoringDO/V_Ajax_SudahCetak', $data);
    }

    public function GetSudahCetakDetail()
    {
        $id = $this->input->post('requests_number');
        $data['get'] = $this->M_monitoringdo->GetSudahCetakDetail($id);
        $this->load->view('MonitoringDO/V_Ajax_Transact_detail', $data);
    }

    public function GetAssign()
    {
        $data['get'] = $this->M_monitoringdo->sudahdiAssign();
        $this->load->view('MonitoringDO/V_Ajax_Assign', $data);
    }

    public function GetAssignDetail()
    {
        $id = $this->input->post('requests_number');
        $data['get'] = $this->M_monitoringdo->sudahdiAssign_detail($id);
        $this->load->view('MonitoringDO/V_Ajax_Assign_detail', $data);
    }

    public function GetAllocate()
    {
        $data['get'] = $this->M_monitoringdo->sudahdiLayani();
        $this->load->view('MonitoringDO/V_Ajax_Allocate', $data);
    }

    public function GetAllocateDetail()
    {
        $id = $this->input->post('requests_number');
        $data['get'] = $this->M_monitoringdo->sudahdiLayani_detail($id);
        $this->load->view('MonitoringDO/V_Ajax_Allocate_detail', $data);
    }

    public function CetakDO()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        $data['assign'] = $this->M_monitoringdo->getAssign();
        $data['get'] = $this->M_monitoringdo->dataCetak();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('MonitoringDO/V_Cetak', $data);
        $this->load->view('V_Footer', $data);
    }

    public function CetakPDF($id)
    {
        //data trial
        $data['get_header'] = $this->M_monitoringdo->headerSurat($id);
        $data['get_body'] = $this->M_monitoringdo->bodySurat($id);
        $data['get_serial'] = $this->M_monitoringdo->serial($id);
        $data['get_footer'] = $this->M_monitoringdo->footersurat($id);
        $data['totalbody'] = sizeof($data['get_body']);
        $data['totalserial'] = sizeof($data['get_serial']);

        function generateInTicketNumber($length = 5)
        {
          $characters = '0123456789';
          $charactersLength = strlen($characters);
          $randomString = '';
          for ($i = 0; $i < $length; $i++) $randomString .= $characters[rand(0, $charactersLength - 1)];
          return $randomString;
        }

        $datacetak = [
          'REQUEST_NUMBER' => $data['get_header'][0]['NO_DO'],
          'ORDER_NUMBER' => $data['get_header'][0]['NO_SO'],
          'NOMOR_CETAK' => generateInTicketNumber()
        ];
        $this->M_monitoringdo->insertDOCetak($datacetak);

        if (!empty($data['get_serial'])) {
          $s = [];$hasil = [];
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
          $data['header_sub'] = $hasil;
        }

        if (!empty($id)) {
            // ====================== do something =========================
            $this->load->library('Pdf');

            $pdf 		= $this->pdf->load();
            $this->load->library('ciqrcode');
            $pdf 		= new mPDF('utf-8', array(210 , 297), 0, '', 3, 3, 3, 0, 0, 3);

            // ------ GENERATE QRCODE ------
            if (!is_dir('./assets/img/monitoringDOQRCODE')) {
                mkdir('./assets/img/monitoringDOQRCODE', 0777, true);
                chmod('./assets/img/monitoringDOQRCODE', 0777);
            }

            $params['data']		= $data['get_header'][0]['NO_DO'];
            $params['level']	= 'H';
            $params['size']		= 4;
            $params['black']	= array(255,255,255);
            $params['white']	= array(0,0,0);
            $params['savename'] = './assets/img/monitoringDOQRCODE/'.$data['get_header'][0]['NO_DO'].'.png';
            $this->ciqrcode->generate($params);

            ob_end_clean() ;
            $filename 	= 'Cetak_DO_'.date('d-M-Y').'.pdf';
            $aku 				= $this->load->view('MonitoringDO/pdf/V_Pdf', $data, true);
            $pdf->SetHTMLFooter('<table style="width:100%; border-collapse: collapse !important; margin-top:2px;">
        		<tr>
        			<td rowspan="2" style="vertical-align:top;width:40.5%;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;font-size:10px;padding:5px">Catatan :
        				<br><br><br><br><br><br><br>
        			 </td>
        			<td rowspan="3" style="vertical-align:top;width:13%;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;font-size:10px;padding:5px">Penerima Barang :
        				<br><br>
        				Tgl. ________
        				<br><br><br><br><br><br><br><br>
        			</td>
        			<td rowspan="3" style="vertical-align:top;width:12%;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;font-size:10px;padding:5px">Pengirim : <br> <br>
        				Tgl. _______
        				<br><br><br><br><br><br><br><br>
        			</td>
        			<td rowspan="3" style="vertical-align:top;width:11%;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;font-size:10px;padding:5px">Gudang : <br><br>
        				Tgl. _______
        				<br><br><br><br><br><br>'.$data['get_footer'][0]['GUDANG'].'
        			</td>
        			<td colspan="2" style="vertical-align:top;border-right: 1px solid black; border-top: 1px solid black;border-left: 1px solid black;font-size:10px;padding:5px;height:20px!important;">Pemasaran :</td>
        		</tr>
        		<tr>
        			<td rowspan="2" style="vertical-align:top;width:12%;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;font-size:10px;padding:5px">Mengetahui :
        				<br><br><br><br><br><br>'.$data['get_footer'][0]['ADMIN'].'
        			</td>
        			<td rowspan="2" style="vertical-align:top;width:12%;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;border-right: 1px solid black;font-size:10px;padding:5px">Tgl. _______
        				<br><br><br><br><br><br>'.$data['get_footer'][0]['KEPALA'].'
        			</td>
        		</tr>
        		<tr>
        			<td style="vertical-align:top;border-left: 1px solid black;border-bottom: 1px solid black;font-size:10px;padding:5px">Perhatian : Barang yang dibeli tidak dapat dikembalikan, <br> kecuali ada perjanjian sebelumnya.</td>
        		</tr>
        	</table>');
            $pdf->WriteHTML($aku);
            $pdf->Output($filename, 'I');
        // ========================end process=========================
        } else {
            echo json_encode(array(
          'success' => false,
          'message' => 'id is null'
        ));
        }

        if (!unlink($params['savename'])) {
          echo ("Error deleting");
        }else {
          unlink($params['savename']);
        }
    }

    public function PDF2($id)
    {
        //data trial
        $data['get_header'] = $this->M_monitoringdo->headerSurat($id);
        $data['get_body'] = $this->M_monitoringdo->bodySurat($id);
        $data['get_serial'] = $this->M_monitoringdo->serial($id);
        $data['get_footer'] = $this->M_monitoringdo->footersurat($id);
        $data['totalbody'] = sizeof($data['get_body']);
        $data['totalserial'] = sizeof($data['get_serial']);

        function generateInTicketNumber($length = 5)
        {
          $characters = '0123456789';
          $charactersLength = strlen($characters);
          $randomString = '';
          for ($i = 0; $i < $length; $i++) $randomString .= $characters[rand(0, $charactersLength - 1)];
          return $randomString;
        }

        if (!empty($data['get_serial'])) {
          $s = [];$hasil = [];
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
          $data['header_sub'] = $hasil;
        }

        if (!empty($id)) {
            // ====================== do something =========================
            $this->load->library('Pdf');

            $pdf 		= $this->pdf->load();
            $this->load->library('ciqrcode');
            $pdf 		= new mPDF('utf-8', array(210 , 297), 0, '', 3, 3, 3, 0, 0, 3);

            // ------ GENERATE QRCODE ------
            if (!is_dir('./assets/img/monitoringDOQRCODE')) {
                mkdir('./assets/img/monitoringDOQRCODE', 0777, true);
                chmod('./assets/img/monitoringDOQRCODE', 0777);
            }

            $params['data']		= $data['get_header'][0]['NO_DO'];
            $params['level']	= 'H';
            $params['size']		= 4;
            $params['black']	= array(255,255,255);
            $params['white']	= array(0,0,0);
            $params['savename'] = './assets/img/monitoringDOQRCODE/'.$data['get_header'][0]['NO_DO'].'.png';
            $this->ciqrcode->generate($params);

            ob_end_clean() ;
            $filename 	= 'Cetak_DO_'.date('d-M-Y').'.pdf';
            $aku 				= $this->load->view('MonitoringDO/pdf/V_Pdf', $data, true);
            $pdf->SetHTMLFooter('<table style="width:100%; border-collapse: collapse !important; margin-top:2px;">
        		<tr>
        			<td rowspan="2" style="vertical-align:top;width:40.5%;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;font-size:10px;padding:5px">Catatan :
        				<br><br><br><br><br><br><br>
        			 </td>
        			<td rowspan="3" style="vertical-align:top;width:13%;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;font-size:10px;padding:5px">Penerima Barang :
        				<br><br>
        				Tgl. ________
        				<br><br><br><br><br><br><br><br>
        			</td>
        			<td rowspan="3" style="vertical-align:top;width:12%;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;font-size:10px;padding:5px">Pengirim : <br> <br>
        				Tgl. _______
        				<br><br><br><br><br><br><br><br>
        			</td>
        			<td rowspan="3" style="vertical-align:top;width:11%;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;font-size:10px;padding:5px">Gudang : <br><br>
        				Tgl. _______
        				<br><br><br><br><br><br>'.$data['get_footer'][0]['GUDANG'].'
        			</td>
        			<td colspan="2" style="vertical-align:top;border-right: 1px solid black; border-top: 1px solid black;border-left: 1px solid black;font-size:10px;padding:5px;height:20px!important;">Pemasaran :</td>
        		</tr>
        		<tr>
        			<td rowspan="2" style="vertical-align:top;width:12%;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;font-size:10px;padding:5px">Mengetahui :
        				<br><br><br><br><br><br>'.$data['get_footer'][0]['ADMIN'].'
        			</td>
        			<td rowspan="2" style="vertical-align:top;width:12%;border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;border-right: 1px solid black;font-size:10px;padding:5px">Tgl. _______
        				<br><br><br><br><br><br>'.$data['get_footer'][0]['KEPALA'].'
        			</td>
        		</tr>
        		<tr>
        			<td style="vertical-align:top;border-left: 1px solid black;border-bottom: 1px solid black;font-size:10px;padding:5px">Perhatian : Barang yang dibeli tidak dapat dikembalikan, <br> kecuali ada perjanjian sebelumnya.</td>
        		</tr>
        	</table>');
            $pdf->WriteHTML($aku);
            $pdf->Output($filename, 'I');
        // ========================end process=========================
        } else {
            echo json_encode(array(
          'success' => false,
          'message' => 'id is null'
        ));
        }

        if (!unlink($params['savename'])) {
          echo ("Error deleting");
        }else {
          unlink($params['savename']);
        }
    }


    public function cekapi()
    {
      $datag = $this->M_monitoringdo->getDO();
      foreach ($datag as $g) {
          $dataku[] = $g['DO/SPB'];
      }
      $no = 0;
      foreach ($dataku as $k) {
          $datakau[] = $this->M_monitoringdo->getDetailDataPengecekan($k);
          $no++;
      }

      $final = [];
      foreach ($datakau as $f) {
          for ($i=0; $i < sizeof($f); $i++) {
              if ($f[$i]['QUANTITY']>$f[$i]['AV_TO_RES']) {
                  $var = 'false =>'.$f[$i]['DO/SPB'];
              } else {
                  $var = 'true =>'.$f[$i]['DO/SPB'];
              }
          }
          array_push($final, $var);
      }

      $finaldestination = [];
      $number = 0;
      foreach ($datag as $d) {
          $d['CHECK'] = $final[$number];
          $number++;
          array_push($finaldestination, $d);
      }
      $data['get'] = $finaldestination;

      $cekaja = $this->M_monitoringdo->getDetailDataPengecekan('3408360');

      $data['get_header'] = $this->M_monitoringdo->headerSurat('3749115');
      echo "<pre>";
      print_r($data['get_header']);
      die;
    }
}
