<?php
defined("BASEPATH") or die("This script cannot access directly");

setlocale(LC_ALL, 'id_ID.utf8');
date_default_timezone_set('Asia/Jakarta');


/**
 * Ez debugging
 */
function debug($arr)
{
  echo "<pre>";
  print_r($arr);
  die;
}

/**
 * Helper Class
 * Http Response
 */
class Response
{
  /**
   * @var Array
   * http response status
   */
  protected $code = array(
    100 => 'Continue',
    200 => 'OK',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    403 => 'Forbidden',
    404 => 'Not Found',
    500 => 'Internal Server Error'
  );

  /**
   * Send Json response
   * @param String { JSON }
   * @param Integer { Code } | Optional
   */
  public static function json($json, $code = 200)
  {
    header("Content-Type: application/json; charset=utf-8");
    http_response_code($code);
    if (is_string($json)) {
      echo $json;
    } else {
      echo json_encode($json);
    }
  }

  /**
   * Send HTML response
   * @param String { HTML text }
   */
  public static function html($string)
  {
    header("Content-Type: text/html; charset=utf-8");
    http_response_code(200);
    echo $string;
  }
}

/**
 * @author /DK/
 * Rest api controller untuk aplikasi master pekerja->kesepakatan kerja
 */
class C_Api extends CI_Controller
{
  protected $user_logged;

  public function __construct()
  {
    parent::__construct();

    $this->load->model('MasterPekerja/Pekerja/KesepakatanKerja/M_KesepakatanKerja', 'modelKesepakatan');

    // login first to using this api
    $this->user_logged = $this->session->user;
  }

  /**
   * get surat kesepakatan kerja
   * 
   * if one of this param is empty
   * will get this current month
   * GET
   * @param GET month
   * @param GET year
   */
  public function kesepakatan_kerja()
  {
    $month = $this->input->get('month') ?: date('m');
    $year = $this->input->get('year') ?: date('Y');
    $keyword = $this->input->get('keyword') ?: false;

    $month = str_pad($month, 2, '0', STR_PAD_LEFT);

    $data = $this->modelKesepakatan->getKesepakatanKerja($month, $year, $keyword);

    return Response::json($data);
  }

  /**
   * Update(simpan) Data Tkesepakatan Kerja by noind
   * 
   * @param POST $id_kk
   * @param POST $tgldiangkat
   * @param POST $tglevaluasi
   * @param POST $tglpemanggilan
   * @param POST $tgltandatangan
   * @param POST $keterangan
   * 
   * @return JSON
   */
  public function update_kesepakatan_kerja()
  {
    $post = $this->input->post();
    // run validaton

    try {
      $id_kk = @$post['id_kk'];
      // this key is same with the table
      // i prefer to write again this key than using var from client
      $data = [
        'tgldiangkat' => $post['tgldiangkat'],
        'tglevaluasi' => $post['tglevaluasi'] ?: NULL,
        'tglpemanggilan' => $post['tglpemanggilan'] ?: NULL,
        'tgltandatangan' => $post['tgltandatangan'] ?: NULL,
        'keterangan' => $post['keterangan'],
        'user_' => $this->user_logged,
      ];

      // remove null/empty values
      $filtered_data = array_filter($data, function ($item) {
        return !empty($item);
      });

      $dataResponse = [];
      // do update or insert
      // it will insert if client not request id_kk param
      if ($id_kk) {
        $update = $this->modelKesepakatan->updateKesepakatanKerja($id_kk, $data);
        if (!$update) throw new Exception("Error to update database");
      } else {
        $insertAndGenerateId = $this->modelKesepakatan->insertKesepakatanKerja(
          array_merge(['noind' => $post['noind']], $data)
        );
        if (!$insertAndGenerateId) throw new Exception("Error to update database");
        $dataResponse['id_kk'] = $insertAndGenerateId;
      }

      Response::json(json_encode([
        'success' => true,
        'message' => 'Sucessfully update data',
        'data' => $dataResponse
      ]), 200);
    } catch (Exception $error) {
      Response::json(
        json_encode([
          'success' => false,
          'message' => 'Something error: ' . $error,
          'code' => 500
        ]),
        500
      );
    }
  }

  /**
   * Get upah pekerja
   * 
   * @return Json
   */
  public function get_upah()
  {
    try {
      $arrayOfUpah = $this->modelKesepakatan->getUpah();

      return Response::json([
        'success' => true,
        'data' => $arrayOfUpah
      ]);
    } catch (Exception $e) {
      return Response::json([
        'success' => false,
        'message' => "Something is error, 500"
      ], 500);
    }
  }

  /**
   * Get item perjanjian kerja
   * 
   * return Json
   */
  public function get_item_perjanjian_kerja()
  {
    // if request with noind then add job desk from database
    $noind = $this->input->get('noind');
    try {
      $arrayOfData = $this->modelKesepakatan->getPerjanjianKerja('0', false); // when true, this just select sub

      $newdata = [];
      foreach ($arrayOfData as $item) {
        $id = substr($item['kd_baris'], 1, 1);
        $newdata[$id][] = $item;
      }
      // debug($newdata);

      $reconstruct_data = [];
      $index = 0;
      foreach ($newdata as $i => $item) {
        $reconstruct_data[$index]['pasal'] = $i;
        $reconstruct_data[$index]['title'] = array_shift($item);
        $reconstruct_data[$index]['count_sub'] = count(array_filter($item, function ($item) {
          return $item['sub'] > 0;
        })) ?: 1;
        $reconstruct_data[$index]['item'] = $item;
        $index++;
      }
      // debug($reconstruct_data);
      // SET JOB DESK from database
      // PASAL 3  
      if ($noind) {
        $job_desk = $this->modelKesepakatan->get_job_desk(false, $noind); // by (kodesie, noind)
        $first_sub = array_shift($reconstruct_data[2]['item']);
        $line_code = (int)$first_sub['kd_baris'];

        $line_code++;
        $arrOfNewJob = [];

        // create new array with right template
        foreach ($job_desk as $item) {
          $line_code++;
          $arrOfNewJob[] = [
            'kd_baris' => str_pad($line_code, 4, '0', STR_PAD_LEFT),
            'isi' => ucfirst(strtolower($item['pekerjaan'])),
            'align' => 'l',
            'sub' => '0',
            'lokasi' => '0'
          ];
        }

        // default end value
        array_push(
          $arrOfNewJob,
          [
            'kd_baris' => str_pad($line_code, 4, '0', STR_PAD_LEFT),
            'isi' => ucfirst(strtolower('Pekerjaan sejenis dalam lingkup pekerjaan yang ada di Seksi ^, CV. Karya Hidup Sentosa yang dalam pelaksanaan pemberian tugasnya akan ditentukan secara tersendiri melalui Kepala Seksi Madya ^ atau staff yang ditunjuk untuk mewakilinya.')),
            'align' => 'l',
            'sub' => '0',
            'lokasi' => '0'
          ]
        );

        // append to first arrray
        array_unshift($arrOfNewJob, $first_sub);

        $reconstruct_data[2]['item'] = $arrOfNewJob;
      }

      return Response::json([
        'success' => true,
        'data' => $reconstruct_data
      ]);
    } catch (\Exception $error) {
      return Response::json([
        'success' => false,
        'message' => "Something is error, 500"
      ], 500);
    }
  }

  /**
   * Update all item perjanjian kerja
   * 
   * @return JSON
   */
  public function update_item_perjanjian_kerja()
  {
    $template = $this->input->post('template');

    try {
      if (empty($template)) throw new Exception("Param is required");

      $doUpdate = $this->modelKesepakatan->updateTemplatePerjanjianKerja($template);

      if (!$doUpdate) throw new Exception("Failed to update template");

      return Response::json([
        'message' => 'success'
      ]);
    } catch (Exception $e) {
      return Response::json([
        'code' => 400,
        'message' => $e->getMessage()
      ], 400);
    }
  }

  /**
   * Get signer (Penanda tangan)
   * 
   * @param POST string of keyword
   * 
   * @return JSON
   */
  public function get_signer()
  {
    try {
      $keyword = $this->input->get('keyword');

      $data = $this->modelKesepakatan->getSigner($keyword);
      return Response::json([
        'success' => true,
        'data' => $data
      ]);
    } catch (\Exception $error) {
      return Response::json([
        'success' => false,
        'message' => "Something is error, 500"
      ], 500);
    }
  }

  /**
   * Set salary in tperjanjian table
   * 
   * @param POST work_place enum(pst,tks,mlt)
   * @param POST salary string
   * 
   * @return JSON
   */
  public function set_salary()
  {
    $work_place = $this->input->post('work_place');
    $salary = $this->input->post('salary');

    try {
      $enum_work_place = ['pst', 'tks', 'mlt'];

      if (!in_array($work_place, $enum_work_place)) throw new Exception("Loker param is wrong");
      if (!$salary) throw new Exception("Salary param should not be empty");

      $response_execute = $this->modelKesepakatan->update_salary($work_place, $salary);

      if (!$response_execute) throw new Exception("Something is happen in server");

      return Response::json([
        'message' => "Successfully update salary for workplace $work_place"
      ]);
    } catch (Exception $error) {
      return Response::json([
        'message' => $error->getMessage()
      ], 500);
    }
  }
}
