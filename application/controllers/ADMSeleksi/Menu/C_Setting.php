<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');

class C_Setting extends CI_Controller{
  function __construct(){
    parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('Upload');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ADMSeleksi/M_setting');

		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
  }

	public function checkSession(){
		if ($this->session->is_logged) {

		} else {
			redirect('index');
		}
	}
    
  public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'ADM Seleksi';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$getdata = $this->M_setting->get_namates(FALSE); // tabel tsetuppertanyaan
		// echo "<pre>"; print_r($getdata); die;
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
		$data['data'] = $getdata;
		// echo "<pre>"; print_r($getdata); die;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ADMSeleksi/Setting/V_LihatPertanyaan', $data);
		$this->load->view('V_Footer', $data);
	}
		
	public function CreateNew(){
		$user_id = $this->session->userid;

		$data['Title'] = 'ADM Seleksi';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['idpertanyaan'] = $this->M_setting->get_max_id_pertanyaan()[0]->max_id ?: 0;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ADMSeleksi/Setting/V_SetupPertanyaan', $data);
		$this->load->view('V_Footer', $data);
	}

	private function set_upload_options(){
		$config = array();
		$config['upload_path'] = 'assets/upload/ADMSeleksi';
		$config['allowed_types'] = 'gif|jpg|png|pdf';
		$config['max_size']      = '1000';
		$config['overwrite']     = TRUE;

		return $config;
	}

	public function AddPertanyaan(){
		// echo "<pre>"; print_r($_FILES); die;
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
		// $checkinstruksi = $this->input->post('checkinstruksi');
		if (isset($_POST['checkinstruksi'])){
			$checkinstruksi = 'Y';
		} else {
			$checkinstruksi = 'N';
		}

		// echo "<pre>"; print_r($checkinstruksi); die;

		$this->M_setting->SetupPertanyaan($num, $nama_tes, $jml_soal, $tipe_pilihan, $instruksi_tes, $menit, $detik, $checkinstruksi);

		foreach ($no_soal as $i => $questionNumber) {
			$questionText = $pertanyaan[$i]; // string
			$answerText = $jawaban[$i]; //array
			$id_soal = $id_pertanyaan[$i]; //array
			$correctAnswer = $correct_answer[$i]; // array

			$config = $this->set_upload_options();
			$this->upload->initialize($config);

			if (isset($_FILES['userfile'])) {
				$time = time();
				// print_r($time); exit;

				foreach ($_FILES['userfile']['name'][$i] as $j => $raw_filename) {
					// $filename = "question_{$questionNumber}_{$num}_{$time}_{$raw_filename}";
					$filename = "question_{$num}_{$time}_{$raw_filename}";

					$_FILES['uploaded']['name'] = $filename;
					$_FILES['uploaded']['type'] = $_FILES['userfile']['type'][$i][$j];
					$_FILES['uploaded']['tmp_name'] = $_FILES['userfile']['tmp_name'][$i][$j];
					$_FILES['uploaded']['error'] = $_FILES['userfile']['error'][$i][$j];
					$_FILES['uploaded']['size'] = $_FILES['userfile']['size'][$i][$j];

					if ($this->upload->do_upload('uploaded')) {
						$uploadedFile = $this->upload->data();
						$file_path = "assets/upload/ADMSeleksi/" . $uploadedFile['file_name'];

						// $this->M_setting->save_file_question($id_soal, $questionNumber, $uploadedFile['file_name'], $file_path, $uploadedFile['file_type']);
						$this->M_setting->save_file_question($id_soal, $uploadedFile['file_name'], $file_path, $uploadedFile['file_type']);
					} else {

					}
				}
			}

			foreach ($answerText as $j => $answer) {
				$isCorrect = $correctAnswer[$j] ? 1 : 0;  // 1 or 0
				$fileAnswerName = $_FILES['file_answers']['name'][$i][$j];

				$file_name = null;
				$file_type = null;
				$file_path = null;

				if ($fileAnswerName) {
					// $_FILES['file_answer']['name'] = "answer_" . $questionNumber . "_" . $num . "_" . time() . "_" . $_FILES['file_answers']['name'][$i][$j];
					$_FILES['file_answer']['name'] = "answer_" . $num . "_" . time() . "_" . $_FILES['file_answers']['name'][$i][$j];
					$_FILES['file_answer']['type'] = $_FILES['file_answers']['type'][$i][$j];
					$_FILES['file_answer']['tmp_name'] = $_FILES['file_answers']['tmp_name'][$i][$j];
					$_FILES['file_answer']['error'] = $_FILES['file_answers']['error'][$i][$j];
					$_FILES['file_answer']['size'] = $_FILES['file_answers']['size'][$i][$j];
					
					$this->upload->do_upload("file_answer");
					$uploadedFile = $this->upload->data();

					$file_name = $uploadedFile['file_name'];
					$file_type = $uploadedFile['file_type'];
					$file_path = "assets/upload/ADMSeleksi/" . $uploadedFile['file_name'];
				}

				// $this->M_setting->SaveJawaban($id_soal, $questionNumber, $answer, $isCorrect, $file_name, $file_type, $file_path);
				$this->M_setting->SaveJawaban($id_soal, $answer, $isCorrect, $file_name, $file_type, $file_path);
			}

			// $this->M_setting->SavePertanyaan($num, $id_soal, $questionNumber, $questionText);
			$this->M_setting->SavePertanyaan($num, $id_soal, $questionText);
		}
		
		redirect('ADMSeleksi/Setting/SetupPertanyaan');
	}

	public function Edit(){
		$user_id = $this->session->userid;

		$data['Title'] = 'ADM Seleksi';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		
		$id_pertanyaan = $this->input->get("id_pertanyaan");

		$cek_quest = $this->M_setting->get_pertanyaan_by_id($id_pertanyaan); // tabel tspertanyaan
			foreach ($cek_quest as $key => $tanya) {
				$file_pertanyaan = $this->M_setting->get_file_pertanyaan($tanya['id_pertanyaan']); // tabel tsfilequestion
				$cek_quest[$key]['file_pertanyaan'] = $file_pertanyaan;
				$jawaban = $this->M_setting->get_jawaban($tanya['id_pertanyaan']); // tabel tsjawaban
				$cek_quest[$key]['jawaban'] = $jawaban;
				$tes = $this->M_setting->get_namates($tanya['id_tes']);
				$cek_quest[$key]['tipe_pilihan'] = $tes[0]['tipe_pilihan'];
			}
		$data['data'] = $cek_quest;
		// echo "<pre>"; print_r($cek_quest); die;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ADMSeleksi/Setting/V_EditPertanyaan', $data);
		$this->load->view('V_Footer', $data);
	}

	public function execute_edit_question(){
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

		if(isset($_FILES['userfile'])){
		// if (!empty($image_path)) {
			// $_FILES['userfile']['name'] = "question_" . $num_soal . "_" . $id_tes . "_" . time() . "_" . $files['userfile']['name'][$k];
			$_FILES['userfile']['name'] = "question_" . $id_tes . "_" . time() . "_" . $files['userfile']['name'];
			$_FILES['userfile']['type'] = $files['userfile']['type'];
			$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'];
			$_FILES['userfile']['error'] = $files['userfile']['error'];
			$_FILES['userfile']['size'] = $files['userfile']['size'];

			if (!empty($files['userfile']['name'])) {
				if (!empty($image_path)) {
					unlink($image_path);
				}

				$this->upload->initialize($this->set_upload_options());
				$this->upload->do_upload();

				$uploadedFile = $this->upload->data();
				$docpath = "assets/upload/ADMSeleksi/" . $uploadedFile['file_name'];

				if(!empty($image_path)){
					$update_file_image = $this->M_setting->update_file_image($id_file, $uploadedFile['file_name'], $docpath, $uploadedFile['file_type']);
				}else{
					$update_file_image = $this->M_setting->save_file_question($id_pertanyaan, $uploadedFile['file_name'], $docpath, $uploadedFile['file_type']);
				}
			} 
		} 

		for ($g = 0; $g < count($jawaban); $g++) {
			$txt_id = $id_jawaban[$g];
			$txt_ans = $jawaban[$g];
			$rename_txt_ans = str_replace("'", "''", $txt_ans);
			$txt_ans_status = $answer_val[$g];
			$path_image_ans = $image_path_ans[$g];
			// echo "<pre>"; print_r($path_image_ans); die;

			// if (!empty($path_image_ans)) {
			if (!empty($files['file_answer']['name'][$g])) {
				// echo "<pre>"; print_r($path_image_ans); die;

				// $_FILES['file_answer']['name'] = "answer_" . $num_soal . "_" . $id_tes . "_" . time() . "_" . $files['file_answer']['name'][$g];
				$_FILES['file_answer']['name'] = "answer_" . $id_tes . "_" . time() . "_" . $files['file_answer']['name'][$g];
				$_FILES['file_answer']['type'] = $files['file_answer']['type'][$g];
				$_FILES['file_answer']['tmp_name'] = $files['file_answer']['tmp_name'][$g];
				$_FILES['file_answer']['error'] = $files['file_answer']['error'][$g];
				$_FILES['file_answer']['size'] = $files['file_answer']['size'][$g];

				// if (!empty($files['file_answer']['name'][$g])) {
				unlink($path_image_ans);

				$this->upload->initialize($this->set_upload_options());
				$this->upload->do_upload("file_answer");

				$uploadedFile = $this->upload->data();
				$docpath = "assets/upload/ADMSeleksi/" . $uploadedFile['file_name'];

				$update_file_image = $this->M_setting->update_file_image_ans($txt_id, $uploadedFile['file_name'], $docpath, $uploadedFile['file_type']);
				// } 
			}

			$update_ans = $this->M_setting->update_ans($txt_id, $rename_txt_ans, $txt_ans_status);
		}

		$update_question = $this->M_setting->update_question($id_pertanyaan, $rename_question);

		redirect('ADMSeleksi/Setting/SetupPertanyaan');
	}

	public function Preview(){
		$user_id = $this->session->userid;

		$data['Title'] = 'ADM Seleksi';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		
		$id_pertanyaan = $this->input->get("id_pertanyaan");
		$cek_quest = $this->M_setting->cek_pertanyaan($id_pertanyaan);

		$cek_quest = $this->M_setting->get_pertanyaan_by_id($id_pertanyaan); // tabel tspertanyaan
			foreach ($cek_quest as $key => $tanya) {
				$file_pertanyaan = $this->M_setting->get_file_pertanyaan($tanya['id_pertanyaan']); // tabel tsfilequestion
				$cek_quest[$key]['file_pertanyaan'] = $file_pertanyaan;
				$jawaban = $this->M_setting->get_jawaban($tanya['id_pertanyaan']); // tabel tsjawaban
				$cek_quest[$key]['jawaban'] = $jawaban;
				$tes = $this->M_setting->get_namates($tanya['id_tes']);
				$cek_quest[$key]['tipe_pilihan'] = $tes[0]['tipe_pilihan'];
			}
		$data['data'] = $cek_quest;
		// echo "<pre>"; print_r($cek_quest); die;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ADMSeleksi/Setting/V_PreviewPertanyaan', $data);
		$this->load->view('V_Footer', $data);
	}

	public function TambahSoal($id_tes){
		$user_id = $this->session->userid;

		$data['Title'] = 'ADM Seleksi';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['idpertanyaan'] = $this->M_setting->get_max_id_pertanyaan()[0]->max_id ?: 0;

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
		// echo "<pre>"; print_r($getdata); die;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ADMSeleksi/Setting/V_TambahPertanyaan', $data);
		$this->load->view('V_Footer', $data);
	}

	public function execute_tambah_soal(){
		$id_tes = $this->input->post('id_tes');
		$jml_soal = $this->input->post('jml_soal');
		$id_pertanyaan = $this->input->post('id_pertanyaan');
		$no_soal = $this->input->post('no_soal');
		$pertanyaan = $this->input->post('pertanyaan');
		$userfile = $this->input->post('userfile');
		$jawaban = $this->input->post('jawaban');
		$file_answer = $this->input->post('file_answer');
		$correct_answer = $this->input->post('correct_answer');
		// echo "<pre>"; print_r($jawaban); 
		// echo "<pre>"; print_r($pertanyaan); die;

		$this->M_setting->update_setup($id_tes, $jml_soal);

		foreach ($no_soal as $i => $questionNumber) {
			$questionText = $pertanyaan[$i]; // string
			$answerText = $jawaban[$i]; //array
			$id_soal = $id_pertanyaan[$i]; //array
			$correctAnswer = $correct_answer[$i]; // array
			$cek_pertanyaan = $this->M_setting->cek_pertanyaan($id_soal);
			// echo "<pre>"; print_r($cek_pertanyaan->num_rows());
			if ($cek_pertanyaan->num_rows() > 0) {
				//sudah ada
			}else{
				$config = $this->set_upload_options();
				$this->upload->initialize($config);

				if (isset($_FILES['userfile'])) {
					$time = time();
					// print_r($time); exit;

					foreach ($_FILES['userfile']['name'][$i] as $j => $raw_filename) {
						// $filename = "question_{$questionNumber}_{$id_tes}_{$time}_{$raw_filename}";
						$filename = "question_{$id_tes}_{$time}_{$raw_filename}";

						$_FILES['uploaded']['name'] = $filename;
						$_FILES['uploaded']['type'] = $_FILES['userfile']['type'][$i][$j];
						$_FILES['uploaded']['tmp_name'] = $_FILES['userfile']['tmp_name'][$i][$j];
						$_FILES['uploaded']['error'] = $_FILES['userfile']['error'][$i][$j];
						$_FILES['uploaded']['size'] = $_FILES['userfile']['size'][$i][$j];

						if ($this->upload->do_upload('uploaded')) {
							$uploadedFile = $this->upload->data();
							$file_path = "assets/upload/ADMSeleksi/" . $uploadedFile['file_name'];

							// $this->M_setting->save_file_question($id_soal, $questionNumber, $uploadedFile['file_name'], $file_path, $uploadedFile['file_type']);
							$this->M_setting->save_file_question($id_soal, $uploadedFile['file_name'], $file_path, $uploadedFile['file_type']);
						} else {

						}
					}
				}

				foreach ($answerText as $j => $answer) {
					$isCorrect = $correctAnswer[$j] ? 1 : 0;  // 1 or 0
					$fileAnswerName = $_FILES['file_answers']['name'][$i][$j];

					$file_name = null;
					$file_type = null;
					$file_path = null;

					if ($fileAnswerName) {
						// $_FILES['file_answer']['name'] = "answer_" . $questionNumber . "_" . $id_tes . "_" . time() . "_" . $_FILES['file_answers']['name'][$i][$j];
						$_FILES['file_answer']['name'] = "answer_" . $id_tes . "_" . time() . "_" . $_FILES['file_answers']['name'][$i][$j];
						$_FILES['file_answer']['type'] = $_FILES['file_answers']['type'][$i][$j];
						$_FILES['file_answer']['tmp_name'] = $_FILES['file_answers']['tmp_name'][$i][$j];
						$_FILES['file_answer']['error'] = $_FILES['file_answers']['error'][$i][$j];
						$_FILES['file_answer']['size'] = $_FILES['file_answers']['size'][$i][$j];
						
						$this->upload->do_upload("file_answer");
						$uploadedFile = $this->upload->data();

						$file_name = $uploadedFile['file_name'];
						$file_type = $uploadedFile['file_type'];
						$file_path = "assets/upload/ADMSeleksi/" . $uploadedFile['file_name'];
					}

					// $this->M_setting->SaveJawaban($id_soal, $questionNumber, $answer, $file_name, $file_type, $file_path);
					$this->M_setting->SaveJawaban($id_soal, $answer, $isCorrect, $file_name, $file_type, $file_path);
				}

				$this->M_setting->SavePertanyaan($id_tes, $id_soal, $questionText);
				// $this->M_setting->SavePertanyaan($id_tes, $id_soal, $questionNumber, $questionText);
			}
		}
		
		redirect('ADMSeleksi/Setting/SetupPertanyaan');
	}

}

?>