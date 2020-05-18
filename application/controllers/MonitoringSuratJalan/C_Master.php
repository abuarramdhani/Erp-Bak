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
        $this->load->model('MonitoringSuratJalan/M_msj');

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
        $this->load->view('MonitoringSuratJalan/V_Index');
        $this->load->view('V_Footer', $data);
    }

    // ============================Terima FPB====================================

    public function TerimaFPB()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['get'] = $this->M_msj->get(1);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('MonitoringSuratJalan/V_TerimaFPB');
        $this->load->view('V_Footer', $data);
    }

    public function Detail()
    {
        $term = strtoupper($this->input->post('nodoc'));
        $data['get'] = $this->M_msj->Detail($term);

        $this->load->view('MonitoringSuratJalan/Detail/V_Detail', $data);
    }

    public function Detail_SJ()
    {
        $term = strtoupper($this->input->post('no_sj'));
        $data['get'] = $this->M_msj->Detail_SJ($term);

        $this->load->view('MonitoringSuratJalan/Detail/V_Detail_SJ', $data);
    }

    public function Update2()
    {
        if (!$this->input->is_ajax_request()) {
            echo "You haven't access!!!";
            die;
        } else {
            $doc = $this->input->post('nodoc');
            foreach ($doc as $key => $d) {
                $this->M_msj->Update2($d);
            }
            echo json_encode($doc);
        }
    }

    // =============================input surat jalan ==========================
    public function InputSuratJalan()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['get'] = $this->M_msj->get(2);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('MonitoringSuratJalan/V_InputSuratJalan');
        $this->load->view('V_Footer', $data);
    }

    public function Update3()
    {
        if (!$this->input->is_ajax_request()) {
            echo "You haven't access!!!";
            die;
        } else {
            //==========generate document_number=====
            $time 				= date('ym');
            $lastNumber   = $this->M_msj->lastDocumentNumber('SJ'.$time);
            if (empty($lastNumber[0]['NO_SJ'])) {
                $newNumber = 'SJ'.$time.'00001';
            } else {
                $newNumber = $lastNumber[0]['NO_SJ']+1;
                if (strlen($newNumber) < 5) {
                    $newNumber = str_pad($newNumber, 5, "0000", STR_PAD_LEFT);
                }
                $newNumber = 'SJ'.$time.$newNumber;
            }
            //==========end generate========

            $doc = $this->input->post('nodoc');
            foreach ($doc as $key => $d) {
                $data = [
                  'no_sj'     => $newNumber,
                  'nodoc'     => $d,
                  'dari'      => $this->input->post('dari'),
                  'ke'        => $this->input->post('ke'),
                  'jn'        => $this->input->post('jn'),
                  'sopir_ind' => $this->input->post('sopir_ind'),
                  'sopir_name'=> $this->input->post('sopir_name'),
                  'plat'      => strtoupper($this->input->post('plat'))
                ];
                // echo "<pre>";
                // print_r($data);
                $this->M_msj->UpdateAndInsert($data);
            }
            $n100s = [
              'NO_DOC' => $newNumber,
              'STATUS' => 1
            ];
            echo json_encode($n100s);
        }
    }

    public function Employee()
    {
        $term = strtoupper($this->input->post('term'));
        echo json_encode($this->M_msj->Employee($term));
    }

    public function getName()
    {
        $term = strtoupper($this->input->post('noind'));
        echo json_encode($this->M_msj->Employee($term));
    }
    // ========================= monitoring ====================================

    public function Monitoring()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['get'] = $this->M_msj->getSj();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('MonitoringSuratJalan/V_Monitoring');
        $this->load->view('V_Footer', $data);
    }

    public function getEdit()
    {
        $sj = $this->input->post('sj');
        echo json_encode($this->M_msj->getEdit($sj));
    }

    public function updateSJ()
    {
        if (!$this->input->is_ajax_request()) {
            echo "You haven't access!!!";
            die;
        } else {
            echo json_encode($this->M_msj->updateSJ([
          'NAMA_SUPIR' => $this->input->post('nama_sopir'),
          'NO_INDUK' => $this->input->post('noind_sopir'),
          'PLAT_NUMBER' => strtoupper($this->input->post('plat')),
        ], $this->input->post('no_sj')));
        }
    }
    // ========================= END MONITORING AREA================================

    // =========================== CETAKAN AREA ====================================

    public function Cetak($doc)
    {
        if (!empty($doc)) {
          $dataCek = $this->M_msj->getSjRow($doc);

          if (empty($dataCek[0]['PRINT_DATE'])) {
            $this->M_msj->updatePrintDate($doc);
          }

          $data['get'] = $this->M_msj->getFPB($doc);
          // echo "<PRE>";
          // print_r($dataCek);die;
          // ====================== do something =========================
          $this->load->library('Pdf');

          $pdf 		= $this->pdf->load();
          $this->load->library('ciqrcode');
          // if (sizeof($data['ge']) > 10) {
          if (sizeof($data['get']['Item']) > 10) {
            $pdf 		= new mPDF('utf-8', array(210 , 148), 0, '', 3, 3, 5, 5, 4.3, 4.1);
          }else {
            $pdf 		= new mPDF('utf-8', array(210 , 148), 0, '', 3, 3, 35, 0, 4.3, 4.1);
          }

          // ------ GENERATE QRCODE ------
          if (!is_dir('./assets/upload/QR_MSJ')) {
              mkdir('./assets/upload/QR_MSJ', 0777, true);
              chmod('./assets/upload/QR_MSJ', 0777);
          }

          $params['data']		= $data['get']['Header'][0]['NO_SURATJALAN'];
          $params['level']	= 'H';
          $params['size']		= 5;
          $params['black']	= array(255,255,255);
          $params['white']	= array(0,0,0);
          $params['savename'] = './assets/upload/QR_MSJ/'.$data['get']['Header'][0]['NO_SURATJALAN'].'.png';
          $this->ciqrcode->generate($params);

          ob_end_clean() ;
          $filename 	= $doc.'.pdf';

          $pdf->defaultheaderline = 0;
          $pdf->defaultfooterline = 0;
          if (sizeof($data['get']['Item']) > 10) {
            // if (sizeof($data['ge']) > 10) {
            $pdf->WriteHTML($this->load->view('MonitoringSuratJalan/Pdf/V_Pdf_10', $data, true));
          }else {
            $pdf->SetHeader($this->load->view('MonitoringSuratJalan/Pdf/V_Pdf_Header', $data, true));
            $pdf->SetFooter($this->load->view('MonitoringSuratJalan/Pdf/V_Pdf_Footer', $data, true));
            $pdf->WriteHTML($this->load->view('MonitoringSuratJalan/Pdf/V_Pdf', $data, true));
          }

          $pdf->Output($filename, 'I');

          if (!unlink($params['savename'])) {
              echo("Error deleting");
          } else {
              unlink($params['savename']);
          }

          $this->M_msj->updateCetak($doc);

      } else {
          echo json_encode(array(
            'success' => false,
            'message' => 'id is null'
          ));
      }

    }

    // =========================== END CETAKAN AREA ====================================


    // ============================ CHECK API AREA =====================================

    public function cekapi()
    {
        $term = 'CABANG';
        $data = $this->M_msj->getMaster();
        // $data = $this->M_msj->getFPB('SJ200500001');
        echo "<pre>";
        print_r($data);
        die;
    }
}
