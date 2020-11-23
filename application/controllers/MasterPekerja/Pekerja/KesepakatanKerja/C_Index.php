<?php
defined("BASEPATH") or die("This script cannot access directly");

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

class C_Index extends CI_Controller
{
  protected $user_logged;

  public function __construct()
  {
    parent::__construct();


    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('MasterPekerja/Pekerja/KesepakatanKerja/M_KesepakatanKerja', 'modelKesepakatan');

    $this->load->helper('terbilang');

    $this->user_logged = @$this->session->user ?: null;
    $this->user_id = $this->session->userid ?: null;

    $this->sessionCheck();
  }

  private function sessionCheck()
  {
    return $this->user_logged or redirect(base_url('MasterPekerja'));
  }

  /**
   * Index view
   */
  public function index()
  {
    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = 'Pekerja';
    $data['SubMenuTwo'] = 'Kesepakatan Kerja';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->user_id, $this->session->responsibility_id);

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MasterPekerja/Pekerja/KesepakatanKerja/V_Index', $data);
    $this->load->view('MasterPekerja/Pekerja/KesepakatanKerja/V_Footer', $data);
    // $this->load->view('V_Footer', $data);
  }

  /**
   * PRINT pdf
   * 
   * @param GET Noind
   * @param GET Signer
   * @param GET Loker
   * @param GET Upah(input manual)
   * 
   * REFACTORING THIS
   * REFACTORING THIS
   */
  public function print_pdf()
  {
    $this->load->library('pdf');
    $this->pdf->load();

    $arrayOfLoker = [
      'pst' => [
        'value' => 1,
        'name' => 'KHS Pusat'
      ],
      'tks' => [
        'value' => 2,
        'name' => 'KHS Tuksono'
      ],
      'mlt' => [
        'value' => 3,
        'name' => 'KHS Mlati'
      ]
    ];

    try {
      $request = $this->input->post();
      if (!$request) throw new Exception("Page is expired");
      // debug($request);
      // this is like array descructor, and assign key as new variabel
      extract($request);
      // if batch is null then assign selected noind to array
      $batch_noind = $this->input->post('batch_noind') ?: [$this->input->post('noind')];
      $arrayOfDownload = [];

      foreach ($batch_noind as $noind) {

        $lokerValue = $arrayOfLoker[$loker]['value'];
        $lokerName = $arrayOfLoker[$loker]['name'];
        // debug($lokerValue);

        // tpribadi 
        $dataWorker = $this->modelKesepakatan->getPribadi($noind, 'noind, nama, lmkontrak, diangkat, akhkontrak, seksi');
        $dataSigner = $this->modelKesepakatan->getPribadi($signer, 'noind, nama, jabatan');
        // debug($dataSigner);

        // replacer value
        $unique_char_style = [
          '$' => [
            'style' => 'bold',
            'value' => $upah
          ],
          '@' => [
            'style' => 'bold',
            'value' => $dataWorker->lmkontrak . " (" . trim(number_to_words($dataWorker->lmkontrak)) . ")"
          ],
          '#' => [
            'style' => 'bold',
            'value' => strftime('%d %B %Y', strtotime($dataWorker->diangkat))
          ],
          '%' => [
            'style' => 'bold',
            'value' => strftime('%d %B %Y', strtotime($dataWorker->akhkontrak))
          ],
          '^' => [
            'style' => 'normal',
            'value' => ucwords(strtolower(trim($dataWorker->seksi)))
          ]
        ];

        // apply style to html code
        $unique_char_style = array_map(function ($item) {
          if ($item['style'] == 'bold') return "<b>{$item['value']}</b>";
          if ($item['style'] == 'italic') return "<i>{$item['value']}</i>";
          if ($item['style'] == 'underline') return "<u>{$item['value']}</u>";

          return $item['value'];
        }, $unique_char_style);
        // debug($unique_char_style);

        // filter loker 
        $template = array_map(function ($arrOfPasal) use ($lokerValue) {
          // replace template to values
          $arrOfPasal['item'] = array_filter($arrOfPasal['item'], function ($item) use ($lokerValue) {
            return in_array($item['lokasi'], ['0', $lokerValue]);
          });

          return $arrOfPasal;
        }, $template);

        // render template special code to string
        $parsedTemplate = array_map(function ($arrOfPasal) use ($unique_char_style) {
          // replace template to values
          $arrOfPasal['item'] = array_map(function ($item) use ($unique_char_style) {
            $item['isi'] = str_replace(array_keys($unique_char_style), array_values($unique_char_style), $item['isi']);
            return $item;
          }, $arrOfPasal['item']);

          return $arrOfPasal;
        }, $template);

        $compiled_data = [
          'signer' => $dataSigner,
          'data' => $parsedTemplate, // HERE
        ];

        $compiled_footer = [
          'worker' => $dataWorker,
          'loker_name' => $lokerName,
          'orientasi_type' => "Kontrak Non staff",
        ];

        // debug($compiled_data);

        // $pdf   =  new mPDF('utf-8', array(216, 297), 10, "timesnewroman", 20, 20, 20, 20, 0, 0, 'P');
        //$mode='',$format='A4',$default_font_size=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P'
        $pdf   =  new mPDF('utf-8', 'A4', 10, "timesnewroman", 15, 15, 35, 35, 10, 10, 'P');

        $filename  =  "Kesepakatan_Kerja_{$noind}_" . date('Y-m-d_His') . '.pdf';
        $header = $this->load->view('MasterPekerja/Pekerja/KesepakatanKerja/TemplatePDF/V_Header', [], TRUE);
        $body = $this->load->view('MasterPekerja/Pekerja/KesepakatanKerja/TemplatePDF/V_Content', $compiled_data, TRUE);
        $footer = $this->load->view('MasterPekerja/Pekerja/KesepakatanKerja/TemplatePDF/V_Footer', $compiled_footer, TRUE);

        $pdf->debug = true;

        $pdf->AddPage();
        $pdf->SetHTMLHeader($header, '', true);
        $pdf->SetHTMLFooter($footer, '', true);
        $pdf->WriteHTML($body);
        $pdf->setTitle($filename);

        // save temporary
        $path = "assets/upload/kesepakatan_kerja/$filename";
        $fullPath = base_url() . $path;
        $pdf->Output($path, 'f');

        // echo base64_encode($pdf->Output($filename, 'S'));
        // echo $pdf->Output($filename, 'S');

        array_push($arrayOfDownload, array(
          'filename' => $filename,
          'path' => $path,
          'full_path' => $fullPath
        ));
      }

      echo json_encode($arrayOfDownload);
    } catch (Exception $e) {
      // look be nothing
      echo $e->getMessage();
    }
  }


  /**
   * @deprecated It is not used
   */
  // thisbackup export pdf with usinng token base64
  public function print_pdf_backup()
  {
    $this->load->library('pdf');
    $this->pdf->load();

    $arrayOfLoker = [
      'pst' => [
        'value' => 1,
        'name' => 'KHS Pusat'
      ],
      'tks' => [
        'value' => 2,
        'name' => 'KHS Tuksono'
      ],
      'mlt' => [
        'value' => 3,
        'name' => 'KHS Mlati'
      ]
    ];

    try {
      $request = $this->input->post();
      if (!isset($request['token'])) throw new Exception("token is invalid");

      // base64 string
      $decrypt_token = base64_decode($request['token']);
      $arrOfData = [];
      // parse url query and assign to variable
      parse_str($decrypt_token, $arrOfData);
      // debug($arrOfData);
      // this will declare variable from array, like array destructing in php 7
      extract($request);

      $lokerValue = $arrayOfLoker[$loker]['value'];
      $lokerName = $arrayOfLoker[$loker]['name'];
      // debug($arrOfData);

      // if (!isset($get['key'])) throw new Exception("key param is empty");

      // // parse base64 to string
      // $json = base64_decode($get['key']);
      // // decode string json to array
      // $data = json_decode($json, true);

      // /**
      //  * noind, ke, no_surat, kode_arsip, atasan, hubker
      //  */
      // if (!($data && isset($data['noind']) && isset($data['ke']))) throw new Exception("Key is invalid");

      // /**
      //  * rules example
      //  * set_rules('name', 'label', 'rules[required|min_length|max_length|unique|integer|string]', 'message Array | optional')
      //  * set_message('rules', 'message')
      //  */
      // $this->form_validation
      //   ->set_data($data)
      //   ->set_rules('noind', 'Nomor Induk', 'required')
      //   ->set_rules('ke', 'Surat Ke', 'required')
      //   ->set_message('required', 'Error: Field {field} Bad request')
      //   ->run();

      // if (!$this->form_validation->run()) throw new Exception(validation_errors());

      // $memo = $this->M_pekerjakeluar->getOneMemoOrientation($data['noind'], $data['ke']);
      // if (!$memo) throw new Exception("Memo not found");

      // $memo->no_surat = $data['no_surat'];
      // $memo->kode_arsip = $data['kode_arsip'];
      // $memo->atasan /*Array */ = $this->M_pekerjakeluar->getAtasanSeksi($memo->kodesie, $data['atasan']);
      // $memo->hubker /*Array */ = $this->M_pekerjakeluar->getAtasanHubker($data['hubker']);


      /**
       * get perjanjian
       * 
       */

      // template backup1
      $data = $template ?: $this->modelKesepakatan->getPerjanjianKerja($lokerValue);
      // tpribadi 
      $dataWorker = $this->modelKesepakatan->getPribadi($noind, 'noind, nama, lmkontrak, diangkat, tglkeluar, seksi');
      $dataSigner = $this->modelKesepakatan->getPribadi($signer, 'noind, nama, jabatan');
      // debug($dataSigner);
      // grouping array

      // replacer value
      $unique_char_style = [
        '$' => [
          'style' => 'bold',
          'value' => $upah
        ],
        '@' => [
          'style' => 'bold',
          'value' => $dataWorker->lmkontrak . " (" . trim(number_to_words($dataWorker->lmkontrak)) . ")"
        ],
        '#' => [
          'style' => 'bold',
          'value' => strftime('%d %B %Y', strtotime($dataWorker->diangkat))
        ],
        '%' => [
          'style' => 'bold',
          'value' => strftime('%d %B %Y', strtotime($dataWorker->tglkeluar))
        ],
        '^' => [
          'style' => 'normal',
          'value' => ucwords(strtolower(trim($dataWorker->seksi)))
        ]
      ];

      // apply style to html code
      $unique_char_style = array_map(function ($item) {
        if ($item['style'] == 'bold') return "<b>{$item['value']}</b>";
        if ($item['style'] == 'italic') return "<i>{$item['value']}</i>";
        if ($item['style'] == 'underline') return "<u>{$item['value']}</u>";

        return $item['value'];
      }, $unique_char_style);
      // debug($unique_char_style);

      // template backup2
      $newdata = [];
      foreach ($data as $item) {
        $id = substr($item['kd_baris'], 1, 1);
        $newdata[$id][] = $item;
      }
      // debug($newdata);
      //

      // template 3
      $endData = [];
      foreach ($newdata as $i => $item) {
        $endData[$i]['title'] = array_shift($item);
        $endData[$i]['count_sub'] = count(array_filter($item, function ($item) {
          return $item['sub'] > 0;
        }));
        // render template special code to string
        $item = array_map(function ($item) use ($unique_char_style) {
          $item['isi'] = str_replace(array_keys($unique_char_style), array_values($unique_char_style), $item['isi']);

          return $item;
        }, $item);
        $endData[$i]['item'] = $item;
      }
      // debug($endData);

      $compiled_data = [
        'signer' => $dataSigner,
        'data' => $endData,
      ];

      $compiled_footer = [
        'worker' => $dataWorker,
        'loker_name' => $lokerName,
        'orientasi_type' => "Orientasi Non staff",
      ];

      // debug($compiled_data);

      // $pdf   =  new mPDF('utf-8', array(216, 297), 10, "timesnewroman", 20, 20, 20, 20, 0, 0, 'P');
      //$mode='',$format='A4',$default_font_size=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P'
      $pdf   =  new mPDF('utf-8', 'A4', 10, "timesnewroman", 15, 15, 35, 35, 10, 10, 'P');

      $filename  =  'Memo Perpanjangan Orientasi' . '.pdf';
      $header = $this->load->view('MasterPekerja/Pekerja/KesepakatanKerja/TemplatePDF/V_Header', [], TRUE);
      $body = $this->load->view('MasterPekerja/Pekerja/KesepakatanKerja/TemplatePDF/V_Content', $compiled_data, TRUE);
      $footer = $this->load->view('MasterPekerja/Pekerja/KesepakatanKerja/TemplatePDF/V_Footer', $compiled_footer, TRUE);

      $pdf->debug = true;

      $pdf->AddPage();
      $pdf->SetHTMLHeader($header, '', true);
      $pdf->SetHTMLFooter($footer, '', true);
      $pdf->WriteHTML($body);
      $pdf->setTitle($filename);

      // render pdf 
      $pdf->Output($filename, 'I');
    } catch (Exception $e) {
      // look be nothing
      echo $e->getMessage();
    }
  }
  /**
   * 
   */
}
