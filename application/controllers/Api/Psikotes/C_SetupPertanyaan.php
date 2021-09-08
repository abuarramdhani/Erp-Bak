<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class C_SetupPertanyaan extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
	    $this->load->helper('url');
	    $this->load->library('form_validation');
	    $this->load->model('Api/Psikotes/M_setuppsikotes');
	    $this->load->model('ADMSeleksi/M_setting');
	    date_default_timezone_set('Asia/Jakarta');
	    $this->load->library('Upload');
	}

	function getListSetupPertanyaanAll()
	{
		$getdata = $this->M_setting->get_namates(FALSE); // tabel tsetuppertanyaan
		foreach ($getdata as $key => $value) {
		$pertanyaan = $this->M_setting->get_pertanyaan($value['id_tes']); // tabel tspertanyaan
		$getdata[$key]['pertanyaan'] = $pertanyaan;
			foreach ($pertanyaan as $key2 => $tanya) {
				$file_pertanyaan = $this->M_setting->get_file_pertanyaan($tanya['id_pertanyaan']); // tabel tsfilequestion
				$getdata[$key]['pertanyaan'][$key2]['file_pertanyaan'] = $file_pertanyaan;
				$jawaban = $this->M_setting->get_jawaban($tanya['id_pertanyaan']); // tabel tsjawaban
				$getdata[$key]['pertanyaan'][$key2]['jawaban'] = $jawaban;
			}
		}
		echo json_encode($getdata);
	}

	function AddPertanyaan(){
		// echo 'asdas';
		parse_str($_POST[0], $_POST);
		$debug = $this->input->post('debug');
		if ($debug == '1') {
			print_r($_POST);
			print_r($_FILES);
			exit;
		}
		
		$id_tes = $this->M_setting->get_max_id_tes();
		if ($id_tes == null) {
			$num = 1;
		} else {
			foreach ($id_tes as $md) {
				$num = ($md->max_id) + 1;
			}
		}
		$nama_tes = $this->input->post('nama_tes');
		$jml_soal = $this->input->post('jml_soal');
		$tipe_pilihan = $this->input->post('tipe_pilihan');
		$instruksi_tes = $this->input->post('instruksi_tes');
		$id_pertanyaan = $this->input->post('id_pertanyaan');
		$no_soal = $this->input->post('no_soal');
		$pertanyaan = $this->input->post('pertanyaan');
		$userfile = $this->input->post('userfile');
		$jawaban = $this->input->post('jawaban');
		$file_answer = $this->input->post('file_answer');
		$correct_answer = $this->input->post('correct_answer');
		$menit = $this->input->post('menit');
		$detik = $this->input->post('detik');
		if (isset($_POST['checkinstruksi'])){
			$checkinstruksi = 'Y';
		} else {
			$checkinstruksi = 'N';
		}

		$this->M_setting->SetupPertanyaan($num, $nama_tes, $jml_soal, $tipe_pilihan, $instruksi_tes, $menit, $detik, $checkinstruksi);

		foreach ($no_soal as $i => $questionNumber) {
			$questionText = $pertanyaan[$i];
			$answerText = $jawaban[$i];
			$id_soal = $id_pertanyaan[$i];
			$correctAnswer = $correct_answer[$i];
			if (isset($_POST['userfile']['name'][$i])) {
				$time = time();

				foreach ($_POST['userfile']['name'][$i] as $j => $raw_filename) {
					$file_type = $_POST['userfile']['name'][$i][$j]['ext'];
					$file_name = "question_{$num}_{$time}_{$i}_{$j}.{$file_type}";

					$urlFoto = $_POST['userfile']['name'][$i][$j]['file_url'];
					$foto = $this->curlFoto($urlFoto);
					$file_path = "assets/upload/ADMSeleksi/" . $file_name;
					file_put_contents( $file_path, $foto );

					$this->M_setting->save_file_question($id_soal, $file_name, $file_path, $file_type);
				}
			}

			foreach ($answerText as $j => $answer) {
				$isCorrect = $correctAnswer[$j] ? 1 : 0;  // 1 or 0
				$file_name = null;
				$file_type = null;
				$file_path = null;

				if (isset($_POST['file_answers']['name'][$i][$j])) {
					$file_type = $_POST['file_answers']['name'][$i][$j]['ext'];
					$file_name = "answer_{$num}_{$time}_{$i}_{$j}.{$file_type}";

					$urlFoto = $_POST['file_answers']['name'][$i][$j]['file_url'];
					$foto = $this->curlFoto($urlFoto);
					$file_path = "assets/upload/ADMSeleksi/" . $file_name;
					file_put_contents( $file_path, $foto );
				}

				$this->M_setting->SaveJawaban($id_soal, $answer, $isCorrect, $file_name, $file_type, $file_path);
			}

			$this->M_setting->SavePertanyaan($num, $id_soal, $questionText);
		}
		
		echo 'success';
	}

	private function set_upload_options(){
		$config = array();
		$config['upload_path'] = 'assets/upload/ADMSeleksi';
		$config['allowed_types'] = 'gif|jpg|png|pdf';
		$config['max_size']      = '10000';
		$config['overwrite']     = TRUE;

		return $config;
	}

	function curlFoto($urlFoto)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $urlFoto);

		$data = curl_exec($ch);
		curl_close($ch);

		return $data;
	}

	function getidmaxpertenyaan()
	{
		$data['idpertanyaan'] = $this->M_setting->get_max_id_pertanyaan()[0]->max_id ?: 0;
		echo json_encode($data);
	}

	function getPertanyaan()
	{
		$id_pertanyaan = $this->input->get("id_pertanyaan");
		// print_r($_GET);
		$cek_quest = $this->M_setting->cek_pertanyaan($id_pertanyaan);

		$cek_quest = $this->M_setting->get_pertanyaan_by_id($id_pertanyaan);
		foreach ($cek_quest as $key => $tanya) {
			$file_pertanyaan = $this->M_setting->get_file_pertanyaan($tanya['id_pertanyaan']);
			$cek_quest[$key]['file_pertanyaan'] = $file_pertanyaan;
			$jawaban = $this->M_setting->get_jawaban($tanya['id_pertanyaan']);
			$cek_quest[$key]['jawaban'] = $jawaban;
			$tes = $this->M_setting->get_namates($tanya['id_tes']);
			$cek_quest[$key]['tipe_pilihan'] = $tes[0]['tipe_pilihan'];
		}
		echo json_encode($cek_quest);
	}

	public function execute_edit_question(){
		parse_str($_POST[0], $_POST);
		echo '<pre>';

		$debug = $this->input->post('debug');
		if($debug == '1'){
			print_r($_POST);
			print_r($_FILES);
			exit;
		}
		// pertanyaan
		$id_tes = $this->input->post('id_tes');
		$id_pertanyaan = $this->input->post('id_pertanyaan');
		$pertanyaan = $this->input->post('pertanyaan');
		$rename_question = str_replace("'", "''", $pertanyaan);
		$id_file = $this->input->post("id_file");
		$image_path = $this->input->post("image_path");
		// jawaban
		$id_jawaban = $this->input->post('id_jawaban');
		$jawaban = $this->input->post('jawaban');
		$image_path_ans = $this->input->post("image_path_ans");
		$answer_val = $this->input->post("answer_val");
		// files
		$files = $_FILES;
		// echo "<pre>"; print_r($files); die;
		$time = time();

		if(isset($_POST['userfile']) && !empty($_POST['userfile']['name'])){
			if (!empty($_POST['userfile']['name'])) {
				if (!empty($image_path)) {
					@unlink($image_path);
				}

				$file_type = $_POST['userfile']['name']['ext'];
				$file_name = "question_{$id_tes}_{$time}.{$file_type}";

				$urlFoto = $_POST['userfile']['name']['file_url'];
				$foto = $this->curlFoto($urlFoto);
				$file_path = "assets/upload/ADMSeleksi/" . $file_name;
				file_put_contents( $file_path, $foto );

				if(!empty($image_path)){
					$update_file_image = $this->M_setting->update_file_image($id_file, $file_name, $file_path, $file_type);
				}else{
					$update_file_image = $this->M_setting->save_file_question($id_pertanyaan, $file_name, $file_path, $file_type);
				}
			} 
		} 

		for ($g = 0; $g < count($jawaban); $g++) {
			$txt_id = $id_jawaban[$g];
			$txt_ans = $jawaban[$g];
			$rename_txt_ans = str_replace("'", "''", $txt_ans);
			$txt_ans_status = $answer_val[$g];
			$path_image_ans = $image_path_ans[$g];
			if (isset($_POST['file_answer']['name'][$g]) && !empty($_POST['file_answer']['name'][$g])) {
				$file_type = $_POST['file_answer']['name'][$g]['ext'];
				$file_name = "question_{$id_tes}_{$time}_{$g}.{$file_type}";

				$urlFoto = $_POST['file_answer']['name'][$g]['file_url'];
				$foto = $this->curlFoto($urlFoto);
				$file_path = "assets/upload/ADMSeleksi/" . $file_name;
				file_put_contents( $file_path, $foto );

				$update_file_image = $this->M_setting->update_file_image_ans($txt_id, $file_name, $file_path, $file_type);
			}

			$update_ans = $this->M_setting->update_ans($txt_id, $rename_txt_ans, $txt_ans_status);
		}

		$update_question = $this->M_setting->update_question($id_pertanyaan, $rename_question);

		echo 'success';
	}

	function getPertanyaanbyID()
	{
		$data['idpertanyaan'] = $this->M_setting->get_max_id_pertanyaan()[0]->max_id ?: 0;
		$id_tes = $this->input->get('id_tes');

		$getdata = $this->M_setting->get_namates($id_tes);
		foreach ($getdata as $key => $value) {
			$pertanyaan = $this->M_setting->get_pertanyaan($value['id_tes']); // tabel tspertanyaan
			$getdata[$key]['pertanyaan'] = $pertanyaan;
			foreach ($pertanyaan as $key2 => $tanya) {
				$file_pertanyaan = $this->M_setting->get_file_pertanyaan($tanya['id_pertanyaan']); // tabel tsfilequestion
				$getdata[$key]['pertanyaan'][$key2]['file_pertanyaan'] = $file_pertanyaan;
				$jawaban = $this->M_setting->get_jawaban($tanya['id_pertanyaan']); // tabel tsjawaban
				$getdata[$key]['pertanyaan'][$key2]['jawaban'] = $jawaban;
				$tes = $this->M_setting->get_namates($tanya['id_tes']);
				$getdata[$key]['tipe_pilihan'] = $tes[0]['tipe_pilihan'];
			}
		}
		$data['data'] = $getdata;

		echo json_encode($data);
	}

	public function tambah_soal(){
		parse_str($_POST[0], $_POST);
		echo '<pre>';

		$debug = $this->input->post('debug');
		if ($debug == '1') {
			print_r($_POST);
			print_r($_FILES);
			exit;
		}
		$id_tes = $this->input->post('id_tes');
		$jml_soal = $this->input->post('jml_soal');
		$id_pertanyaan = $this->input->post('id_pertanyaan');
		$no_soal = $this->input->post('no_soal');
		$pertanyaan = $this->input->post('pertanyaan');
		$userfile = $this->input->post('userfile');
		$jawaban = $this->input->post('jawaban');
		$file_answer = $this->input->post('file_answer');
		$correct_answer = $this->input->post('correct_answer');

		$this->M_setting->update_setup($id_tes, $jml_soal);

		foreach ($no_soal as $i => $questionNumber) {
			if(!isset($correct_answer[$i])) continue;
			$questionText = $pertanyaan[$i];
			$answerText = $jawaban[$i];
			$id_soal = $id_pertanyaan[$i];
			$correctAnswer = $correct_answer[$i];
			$cek_pertanyaan = $this->M_setting->cek_pertanyaan($id_soal);

			if ($cek_pertanyaan->num_rows() > 0) {
				//sudah ada
			}else{
				$config = $this->set_upload_options();
				$this->upload->initialize($config);

				if (isset($_POST['userfile']) && isset($_POST['userfile']['name'][$i])) {
					$time = time();

					foreach ($_POST['userfile']['name'][$i] as $j => $raw_filename) {
						$file_type = $_POST['userfile']['name'][$i][$j]['ext'];
						$file_name = "question_{$id_tes}_{$time}_{$i}_{$j}.{$file_type}";

						$urlFoto = $_POST['userfile']['name'][$i][$j]['file_url'];
						$foto = $this->curlFoto($urlFoto);
						$file_path = "assets/upload/ADMSeleksi/" . $file_name;
						file_put_contents( $file_path, $foto );

						$this->M_setting->save_file_question($id_soal, $file_name, $file_path, $file_type);
					}
				}

				foreach ($answerText as $j => $answer) {
					$isCorrect = $correctAnswer[$j] ? 1 : 0;  // 1 or 0
					$fileAnswerName = isset($_POST['file_answers']['name'][$i][$j]) ? $_POST['file_answers']['name'][$i][$j]:false;

					$file_name = null;
					$file_type = null;
					$file_path = null;

					if ($fileAnswerName) {
						$file_type = $_POST['file_answers']['name'][$i][$j]['ext'];
						$file_name = "answer_{$id_tes}_{$time}_{$i}_{$j}.{$file_type}";

						$urlFoto = $_POST['file_answers']['name'][$i][$j]['file_url'];
						$foto = $this->curlFoto($urlFoto);
						$file_path = "assets/upload/ADMSeleksi/" . $file_name;
						file_put_contents( $file_path, $foto );
					}

					$this->M_setting->SaveJawaban($id_soal, $answer, $isCorrect, $file_name, $file_type, $file_path);
				}

				$this->M_setting->SavePertanyaan($id_tes, $id_soal, $questionText);
			}
		}

		echo 'sukses';		
	}
}