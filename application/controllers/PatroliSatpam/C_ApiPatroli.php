<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class C_ApiPatroli extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		$this->load->library('Log_Activity');
		$this->load->model('PatroliSatpam/M_patrolis');
	}

	public function get_pos()
	{
		$noind = $this->input->get('noind');
		$ronde = $this->input->get('ronde');
		$tshift = date('Y-m-d');
		if (date('H:i:s') < '12:00:00') {
			$tshift = date('Y-m-d', strtotime('-1 days'));
		}
		// $tshift = '2020-06-17';
		$pos = $this->M_patrolis->getPos($noind, $tshift, $ronde);
		echo json_encode($pos);
	}

	public function ins_ptrl_scan()
	{
		$noind = $this->input->post('noind');
		$kode = $this->input->post('kode');
		// $tshift = $this->input->post('tshift');
		// $tpatroli = $this->input->post('tpatroli');
		// $wkt = $this->input->post('wkt');
		$lat = $this->input->post('lat');
		$long = $this->input->post('long');
		$ronde = $this->input->post('ronde');
		$pos = $this->input->post('pos');
		$tanggal = $this->input->post('tanggal');

		$tshift = date('Y-m-d');
		if (date('H:i:s') < '12:00:00') {
			$tshift = date('Y-m-d', strtotime('-1 days'));
		}

		$arr = array(
			'noind' => $noind,
			'tgl_shift' => $tshift,
			'tgl_patroli' => date('Y-m-d H:i:s', strtotime($tanggal)),
			'latitude' => $lat,
			'longitude' => $long,
			'jam_patroli' => date('H:i:s', strtotime($tanggal)),
			'ronde' => $ronde,
			'pos' => $pos,
			'kode' => $kode,
			'tgl_server' => date('Y-m-d H:i:s'),
			);
		$ins = $this->M_patrolis->ins_patroli($arr);
		
		echo json_encode($ins);
	}

	public function ins_temuan()
	{
		$id = $this->input->post('id_patroli');
		$noind = $this->input->post('noind');
		$deskripsi = $this->input->post('deskripsi');
		$lat = $this->input->post('lat');
		$long = $this->input->post('long');

		$arr = array(
			'noind' => $noind,
			'deskripsi' => $deskripsi,
			'create_timestamp' => date('Y-m-d H:i:s'),
			'id_patroli' => $id,
			'latitude' => $lat,
			'longitude' => $long,
			);
		$ins = $this->M_patrolis->ins_temuan($arr);
		$r['success'] = $ins;
		echo json_encode($r);
	}

	public function cek_pos()
	{
		$noind = $this->input->get('noind');
		$ronde = $this->input->get('ronde');
		$pos = $this->input->get('pos');

		if (date('H:i:s') < '12:00:00') {
			$tshift = date('Y-m-d', strtotime('-1 days'));
		}else{
			$tshift = date('Y-m-d');
		}

		$data = $this->M_patrolis->cek_pos($noind, $ronde, $pos, $tshift);
		echo json_encode($data);
	}

	public function cek_temuan()
	{
		$id = $this->input->get('id');
		$data = $this->M_patrolis->chek_temuan($id);
		echo json_encode($data);
	}

	public function save_gambar()
	{

	}

	public function cek_pos_pertanyaan()
	{
		$id = $this->input->get('id');
		$data = $this->M_patrolis->chek_jawaban($id);
		echo json_encode($data);
	}

	public function get_pertanyaan()
	{
		$id = $this->input->get('id');
		$id_patroli = $this->input->get('id_patroli');
		if (!empty($id_patroli)) {
			$data = $this->M_patrolis->getlist_pertanyaan_done($id_patroli);
		}
		if(empty($data)){	
			$patroli = $this->M_patrolis->getPosbyId($id);
			$data = $this->M_patrolis->getlist_pertanyaan($patroli[0]['list_pertanyaan']);
		}
		echo json_encode($data);
	}

	public function ins_jawaban()
	{
		$arr = $this->input->post('arr');
		$arr = json_decode($arr, true);// jadikan array
		// print_r($arr);exit();
		$id = $arr['id'];
		$noind = $arr['noind'];
		$id_patroli = $arr['id_patroli'];
		$jawaban = $arr['jawaban'];
		$patroli = $this->M_patrolis->getPosbyId($id);

		$data = $this->M_patrolis->getlist_pertanyaan($patroli[0]['list_pertanyaan']);
		if (count($data) != count($jawaban)) {
			$d['success'] = false;
			$d['pesan'] = "Jumlah pertanyaan/jawaban berbeda";
			echo json_encode($d[d]);
			return;
		}
		$newArr = [];
		$date = date('Y-m-d H:i:s');
		for ($i=0; $i < count($data); $i++) { 
			$newArr[$i]['id_pertanyaan'] = $data[$i]['id_pertanyaan'];
			$newArr[$i]['id_patroli'] = $id_patroli;
			$newArr[$i]['jawaban'] = ($jawaban[$i] == 'Ya') ? 1:0;
			$newArr[$i]['create_date'] = $date;
			$newArr[$i]['noind'] = $noind;
		}
		
		$ins = $this->M_patrolis->insBJawaban($newArr);
		$d['success'] = $ins;
		$d['pesan'] = "Berhasil input data!!";
		echo json_encode($d);
	}

	public function upImg()
	{
		$this->load->library('upload');
		if(!is_dir('./assets/upload/PatroliSatpam'))
		{
			mkdir('./assets/upload/PatroliSatpam', 0777, true);
			chmod('./assets/upload/PatroliSatpam', 0777);
		}

		$cpt = count($_FILES['event_images']['name']);
		// echo $cpt;
		$arrayName = array();
		$files = $_FILES;
		for($i=0; $i<$cpt; $i++){
			$filename = $files['event_images']['name'][$i];
			if(empty($filename)) continue;

			$_FILES['event_images']['name']= str_replace(' ', '_', $files['event_images']['name'][$i]);
			$arrayName[] = $_FILES['event_images']['name'];
			$_FILES['event_images']['type']= $files['event_images']['type'][$i];
			$_FILES['event_images']['tmp_name']= $files['event_images']['tmp_name'][$i];
			$_FILES['event_images']['error']= $files['event_images']['error'][$i];
			$_FILES['event_images']['size']= $files['event_images']['size'][$i];    

			$this->upload->initialize($this->init_config());
			if ($this->upload->do_upload('event_images')){
				$this->upload->data();
			}else{
				$errorinfo = $this->upload->display_errors();
				echo $errorinfo;exit();
			}
		}

		if (!empty($arrayName)) {
			foreach ($arrayName as $key) {
				$id = explode('_', $key);
				$id = explode('.', $id[count($id)-1]);
				//ambil id dari filenamnya
				$data = array(
					'id_patroli'	=>	$id[0],
					'nama_file'		=>	$key
					);
				$ins = $this->M_patrolis->insAttach($data);
			}
		}
		// $d['success'] ='okey';
		// echo json_encode($d);
	}

	function init_config()
	{
		$config = array();
		$config['upload_path'] = 'assets/upload/PatroliSatpam';
		$config['allowed_types'] = '*';
		$config['overwrite']     = 1;

		return $config;
	}

	public function get_atach_id()
	{
		$id_patroli = $this->input->get('id_patroli');

		$data = $this->M_patrolis->getAttchId($id_patroli);
		echo json_encode($data);
	}

	public function get_profile()
	{
		$noind = strtoupper($this->input->get('noind'));
		$data = $this->M_patrolis->getProfile($noind);
		echo json_encode($data);
	}

	public function list_ronde()
	{
		if (date('H:i:s') < '12:00:00') {
			$tshift = date('Y-m-d', strtotime('-1 days'));
		}else{
			$tshift = date('Y-m-d');
		}
		$ronde[] = $this->M_patrolis->getRonde($tshift, 1);
		$ronde[] = $this->M_patrolis->getRonde($tshift, 2);
		$ronde[] = $this->M_patrolis->getRonde($tshift, 3);
		$ronde[] = $this->M_patrolis->getRonde($tshift, 4);
		$x = 0;
		foreach ($ronde as $key) {
			if ($key != null) {
				$data['ronde'][] = $key;
				$x++;
			}
		}
		if ($x == 0) {
			$data['ronde'] = array('ronde'=>1, 'selesai'=>0);
		}
		$data['max_ronde'] = 4;
		echo json_encode($data);
	}

	public function list_rondeID()
	{
		$rond = $this->input->get('id');//id ronde
		if (date('H:i:s') < '12:00:00') {
			$tshift = date('Y-m-d', strtotime('-1 days'));
		}else{
			$tshift = date('Y-m-d');
		}
		$allPos = $this->M_patrolis->getAllPos();
		$cekScan = $this->M_patrolis->getScann($tshift, $rond);
		$c = count($allPos);
		if ($c == $cekScan['patroli'] && $c == $cekScan['temuan'] && $c == $cekScan['jawaban'])
			$selesai = 1;
		else
			$selesai = 0;

		$data['selesai'] = $selesai;
		echo json_encode($data);
	}
	
	public function get_qr_patroli()
	{
		$id = $this->input->get('id_patroli');
		$lk = $this->M_patrolis->getPosbyId($id);
		$data['kode']= $lk[0]['lokasi'];
		echo json_encode($data);
	}

	public function cek_pos_terakhir()
	{
		$lokasi = $this->input->get('lokasi');
		if (date('H:i:s') < '12:00:00') {
			$tshift = date('Y-m-d', strtotime('-1 days'));
		}else{
			$tshift = date('Y-m-d');
		}
		$ronde = $this->M_patrolis->posTerakhir($tshift);
		if ($ronde != 0) {
			$p = $this->M_patrolis->getScann($tshift, $ronde);
			if (($p['temuan'] == $p['patroli'] && $p['jawaban'] == $p['patroli']))
				$ronde = 0;
		}
		//0 artinya bisa tidak langsung redirect ke mapActifity
		$data['ronde'] = $ronde;
		echo json_encode($data);
	}

	public function login_satpam()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$password_md5 = md5($password);
		$log = $this->M_patrolis->loginSatpam($username,$password_md5);

		if($log){

			$response["error"] = FALSE;
			echo json_encode($response);
		}else{
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Username / Password salah";
			echo json_encode($response);
		}
	}
}