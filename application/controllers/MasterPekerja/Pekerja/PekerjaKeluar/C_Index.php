<?php
defined('BASEPATH') or exit('No direct script access allowed');
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
		echo $json;
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
 * Main class for this file
 */
class C_Index extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('General');
		$this->load->library('Log_Activity');
		// $this->load->library('Image');

		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Pekerja/PekerjaKeluar/M_pekerjakeluar');

		if ($this->session->userdata('logged_in') != TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		// $this->checkSession();

		$this->user_logged = @$this->session->user ?: 'unknown';
	}

	/**
	 * Check Session
	 * @return void
	 */
	private function checkSession()
	{
		if (!$this->session->is_logged) {
			redirect('');
		}
	}

	/**
	 * INDEX PAGE
	 * @return void
	 */
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Pekerja';
		$data['SubMenuOne'] = 'Edit Data Pekerja';
		$data['SubMenuTwo'] = 'Edit Data Pekerja';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPekerja/Pekerja/PekerjaKeluar/V_Index', $data);
		$this->load->view('MasterPekerja/Pekerja/PekerjaKeluar/V_Footer', $data);
	}

	/**
	 * View / page
	 * @param GET {noind} String
	 * @param GET {keluar} String
	 */
	public function viewEdit()
	{
		$this->checkSession();
		$menu_url = 'MasterPekerja/DataPekerjaKeluar';
		$user_id = $this->session->userid;

		$noind 					= $this->input->get('noind');
		$keluar = $this->input->get('keluar');
		$data['edit'] = $this->input->get('edit');
		$data['link'] = 'viewEdit?keluar='.$keluar.'&noind='.$noind;

		if (empty($noind)) return redirect($menu_url);

		$pekerja = $this->M_pekerjakeluar->dataPekerja($noind); //ArrObject
		// if searched worker is none, then redirect to base
		if (!$pekerja) return redirect($menu_url);

		/**
		 * Search provinsi, kabupaten, kecamatan, desa in mysql db_daerah 
		 * Find actual location with id
		 * 
		 */
		// Object
		$location = $this->M_pekerjakeluar->findLocation($pekerja->prop, $pekerja->kab, $pekerja->kec, $pekerja->desa);
		if (!trim($pekerja->prop) || !trim($pekerja->kab) || !trim($pekerja->kec) || !trim($pekerja->desa)) {
			$location = (object)array();
		}
		// debug($location);
		$kodesie 		= $pekerja->kodesie;

		// database erp.er_employee_all
		$kontak 		= $this->M_pekerjakeluar->kontakPekerja($noind); //array

		$pekerjaan  = $this->M_pekerjakeluar->getPekerjaan($noind); //ArrObject
		$listPekerjaan = $this->M_pekerjakeluar->getListPekerja($kodesie);
		$seksi 	= $this->M_pekerjakeluar->dataSeksi($kodesie); //Array
		$statjabatan = $this->M_pekerjakeluar->getStatusJabatan($noind); //ArrObject
		$reffjabatan = $this->M_pekerjakeluar->getReffJabatan($noind); //Array
		$non_perpanjang = $this->M_pekerjakeluar->getTKeterangan($noind); // boolean
		$pekerja_keluar = $this->M_pekerjakeluar->checkPekerjaKeluar($noind); // boolean
		// debug($pekerja_keluar);

		// array
		$lokasikerja = $this->M_pekerjakeluar->getLokasiKerja();
		// prevent lokasikerja or asal_lokasi is -
		array_push($lokasikerja, ['id_' => '-', 'lokasi_kerja' => '-']);
		$sebabkeluar = $this->M_pekerjakeluar->getSebabKeluar();
		$listJabatanDL = $this->M_pekerjakeluar->getListJabatanDL();
		$listAnggotaKel = $this->M_pekerjakeluar->getListAnggotaKeluarga();
		$listAtasan = $this->M_pekerjakeluar->getAtasanSeksi($kodesie);
		$listAtasanHubker = $this->M_pekerjakeluar->getAtasanHubker();
		$listAtasan3 = $this->M_pekerjakeluar->getAtasan3();

		// declare here for easy debugging
		$datapekerja	= array(
			/**Data Pribadi */
			'photo' 	          => $pekerja->path_photo ?: $pekerja->photo,
			// 'photo_base64'			=> Image::toBase64($pekerja->path_photo ?: $pekerja->photo),
			'noind' 	          => $pekerja->noind,
			'nama' 		          => $pekerja->nama,
			'jenkel'						=> $pekerja->jenkel,
			'agama'							=> $pekerja->agama, // real data => KRISTEN|KATHOLIK|Katolik|-|lain2|BUDHA|ISLAM|Kristen|LAIN-LAIN|Lain2|Katolik|?|HINDU|KATHOLIK|Islam
			'templahir'         => $pekerja->templahir,
			'tgllahir' 	        => date('d-m-Y', strtotime($pekerja->tgllahir)),
			'goldarah'					=> $pekerja->goldarah, // real data => B|0| |A|-|O|AB
			'nik' 		          => $pekerja->nik,
			'no_kk' 		        => $pekerja->no_kk,
			/**Alamat Pekerja */
			'alamat' 	          => $pekerja->alamat,
			'desa_id'						=> @$location->id_kel ?: $pekerja->desa ?: NULL,
			'desa' 		          => @$location->desa ?: $pekerja->desa ?: NULL,
			'kec_id'						=> @$location->id_kec ?: $pekerja->kec ?: NULL,
			'kec' 		          => @$location->kecamatan ?: $pekerja->kec ?: NULL,
			'kab_id'						=> @$location->id_kab ?: $pekerja->kab ?: NULL,
			'kab' 		          => @$location->kabupaten ?: $pekerja->kab ?: NULL,
			'prop_id'						=> @$location->id_prov ?: $pekerja->prop ?: NULL,
			'prop' 		          => @$location->provinsi ?: $pekerja->prop ?: NULL,
			'kodepos' 	        => $pekerja->kodepos,
			'statrumah' 	      => $pekerja->statrumah, // real data => RK|RS|R|-| 
			'telepon' 	        => $pekerja->telepon,
			'nohp' 	   	        => $pekerja->nohp,
			'email'             => $pekerja->email,
			'almt_kost'					=> $pekerja->almt_kost,
			/**Pendidikan */
			'gelard'						=> $pekerja->gelard,
			'gelarb'						=> $pekerja->gelarb,
			'pendidikan'				=> $pekerja->pendidikan,
			'jurusan'						=> $pekerja->jurusan,
			'sekolah'						=> $pekerja->sekolah,
			/**Anak dan keluarga */
			'jumanak' 					=> $pekerja->jumanak,
			'jumsdr'						=> $pekerja->jumsdr,
			/**Lain-lain */
			'email_internal'    => $pekerja->email_internal,
			'external_mail'    	=> @$kontak->external_mail,
			'telkomsel_mygroup' => $pekerja->telkomsel_mygroup,
			'pidgin_account'    => $pekerja->pidgin_account,

			/**Dari seksi hubungan kerja */
			'nokeb' 	        	=> $pekerja->nokeb,
			'diangkat' 	        => (new DateTime($pekerja->diangkat))->format('d-m-Y'),
			'masukkerja'        => (new DateTime($pekerja->masukkerja))->format('d-m-Y'),
			'status_diangkat'   => $pekerja->status_diangkat === 't',
			/**Penempatan Jabatan skip */
			/** */
			'kd_jbt_dl'					=> $pekerja->kd_jbt_dl,
			'jabatan' 	        => $pekerja->jabatanref,
			'pekerjaan'         => $pekerjaan->pekerjaan,
			'kd_pkj'						=> $pekerja->kd_pkj,
			'golkerja'					=> $pekerja->golkerja,
			'jenispekerjaan'		=> $pekerjaan->jenispekerjaan === 't', // direct = false, indirect = true
			'npwp'							=> $pekerja->npwp,
			'ruang'							=> $pekerja->ruang,
			'lmkontrak'         => $pekerja->lmkontrak,
			'akhkontrak'        => (new DateTime($pekerja->akhkontrak))->format('d-m-Y'),
			/**Pengaturan Loker */
			'kantor_asal'				=> $pekerja->kantor_asal,
			'lokasi_kerja'			=> $pekerja->lokasi_kerja,
			/**Status jabatan & upah */
			'upah_jabatan'			=> $statjabatan->nama_jabatan,
			'status_jabatan'		=> $statjabatan->nama_status,
			/**SPSI & Koperasi */
			'tglspsi'						=> (new DateTime($pekerja->tglspsi))->format('d-m-Y'),
			'nospsi'						=> $pekerja->nospsi,
			'tglkop'						=> (new DateTime($pekerja->tglkop))->format('d-m-Y'),
			'nokoperasi'				=> $pekerja->nokoperasi,
			/**Putus Hubungan Kerja */
			'tglkeluar'         => (new DateTime($pekerja->tglkeluar))->format('d-m-Y'),
			'sebabklr'          => $pekerja->sebabklr,

			/**Pernikahan */
			'statnikah'					=> $pekerja->statnikah,
			'tglnikah'					=> (new DateTime($pekerja->tglnikah))->format('d-m-Y'),
			/**BPJS */
			'bpjs_kes'					=> $pekerja->bpjs_kes === 't', // t meaning true
			'tglberlaku_kes'		=> $pekerja->tglberlaku_kes ? (new DateTime($pekerja->tglberlaku_kes))->format('d-m-Y') : '',
			'bpjs_ket'					=> $pekerja->bpjs_ket === 't', // t meaning true
			'tglberlaku_ket'		=> $pekerja->tglberlaku_ket ? (new DateTime($pekerja->tglberlaku_ket))->format('d-m-Y') : '',
			'bpjs_jht'					=> $pekerja->bpjs_jht === 't',
			'tglberlaku_jht'		=> $pekerja->tglberlaku_jht ? (new DateTime($pekerja->tglberlaku_jht))->format('d-m-Y') : '',
			'nokes'							=> $pekerja->nokes,
			'noket'							=> $pekerja->noket,
			'faskes'						=> $pekerja->faskes,
			/**Pajak */
			'statpajak'					=> $pekerja->statpajak,
			'jtanak'						=> $pekerja->jtanak,
			'jtbknanak'					=> $pekerja->jtbknanak,

			// lain 
			'kodesie'						=> $pekerja->kodesie,
			'kd_pekerjaan'      => $pekerjaan->kd_pekerjaan,
			'seksi' 	          => $seksi->seksi,
			'unit' 		          => $seksi->unit,
			'bidang' 	          => $seksi->bidang,
			'dept' 		          => $seksi->dept,

			// lain 
			'jenis_baju'        => $pekerja->jenis_baju,
			'uk_baju'           => $pekerja->uk_baju,
			'uk_celana'         => $pekerja->uk_celana,
			'uk_sepatu'         => $pekerja->uk_sepatu,
		);

		// remove whitespace right and left all key
		$data['data'] = array_map(function ($item) {
			return trim($item);
		}, $datapekerja);

		$data['reffjabatan']		= $reffjabatan;
		$data['arrlokasikerja'] = $lokasikerja;
		$data['arrsebabkeluar'] = $sebabkeluar;
		$data['arrlistpekerjaan'] = $listPekerjaan;
		$data['arrjabatandl'] = $listJabatanDL;
		$data['listanggotakel'] = $listAnggotaKel;
		// $data['anggotakeluarga'] = $anggotaKeluarga; // NOT USED - replace by api
		$data['atasan3'] = $listAtasan3;
		$data['atasanhubker'] = $listAtasanHubker;
		$data['atasan'] = $listAtasan;
		// checkbox
		$data['non_perpanjang'] = $non_perpanjang;
		$data['pekerja_keluar'] = $pekerja_keluar;

		// html select element
		$data['param'] = array(
			'noind' => $noind,
			'keluar' => $pekerja->keluar,
			'text' => $noind . ' - ' . $pekerja->nama
		);

		$kode = substr($noind, 0,1);
		$ar = array('J', 'H', 'K', 'P', 'T', 'C');
		$ar2 = array('B', 'A');
		if (in_array($kode, $ar)) {
			$st = 'PKWT';
		}else{
			$st = 'Kontrak';
		}
		$data['st'] = $st;
		$data['st2'] = (in_array($kode, $ar2)) ? 'tetap':'kontrak';

		//pkwt
		$data['lpkwt'] = $this->M_pekerjakeluar->getLpkwt($noind);

		$lama = $this->getLamaperpanjangan($noind);
		$data['lama'] = $lama;

		// debug($data);

		$data['Menu'] = 'Pekerja';
		$data['SubMenuOne'] = 'Edit Data Pekerja';
		$data['SubMenuTwo'] = 'Edit Data Pekerja';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPekerja/Pekerja/PekerjaKeluar/V_Edit', $data);
		$this->load->view('MasterPekerja/Pekerja/PekerjaKeluar/V_Footer', $data);
		// $this->load->view('V_Footer', $data);
	}

	/**
	 * Get data pekerja [JSON]
	 * @param GET { rd_keluar }
	 * @param GET { term }
	 * @return void
	 */
	public function data_pekerja()
	{
		$keyword 	= strtoupper($this->input->get('term'));
		$keluar 	= $this->input->get('keluar'); //boolean
		$data 		= $this->M_pekerjakeluar->getPekerja($keyword, $keluar);

		return Response::json(json_encode($data));
	}

	/**
	 * Get data pekerjaan
	 * @return void
	 */
	public function data_pekerjaan()
	{
		$pekerja 	    = strtoupper($this->input->get('term'));
		$kd_pekerjaan = $this->input->get('kd_pekerjaan');
		$data = $this->M_pekerjakeluar->getkdPekerja($pekerja, $kd_pekerjaan);

		Response::json(json_encode($data));
	}

	/**
	 * REST API - GET
	 * MasterPekerja/DataPekerjaKeluar/data_seksi
	 * @param GET {params} String
	 * @param GET {noind} String
	 */
	public function data_seksi()
	{
		$param = strtoupper($this->input->get('params'));
		$noind = strtoupper($this->input->get('noind'));
		if (!$param || !$noind) return false;

		$data = $this->M_pekerjakeluar->getAllSeksi($noind, $param);

		Response::json(json_encode($data));
	}

	/**
	 * REST API - POST
	 * MasterPekerja/DataPekerjaKeluar/add_jabatan
	 * @param POST {noind} String
	 * @param POST {kodesie} String
	 */
	public function add_jabatan()
	{
		$noind = $this->input->post('noind');
		$kodesie = $this->input->post('kodesie');
		if (!$noind || !$kodesie) return false;

		$this->M_pekerjakeluar->insertJabatan($noind, $kodesie);
		// log
		$this->log_activity->activity_log(
			'INSERT TREFJABATAN',
			"$noind -> $kodesie"
		);

		Response::json(json_encode(['success' => true]));
	}

	/**
	 * REST API - POST
	 * MasterPekerja/DataPekerjaKeluar/delete_jabatan
	 * @param POST {noind} String
	 * @param POST {kodesie} String
	 */
	public function delete_jabatan()
	{
		$noind = $this->input->post('noind');
		$kodesie = $this->input->post('kodesie');

		if (!$noind || !$kodesie) return false;

		$this->M_pekerjakeluar->deleteJabatan($noind, $kodesie);
		// insert log
		$this->log_activity->activity_log(
			'DELETE TREFJABATAN',
			"$noind -> $kodesie"
		);

		Response::json(json_encode(['success' => true]));
	}

	/**
	 * REST API - POST
	 * MasterPekerja/DataPekerjaKeluar/update_jabatan
	 * @param: 
	 * @param POST {noind} String
	 * @param POST {kodesie_from} String
	 * @param POST {kodesie_to} 
	 */
	public function update_jabatan()
	{
		$noind = $this->input->post('noind');
		$kodesie_from = $this->input->post('kodesie_from');
		$kodesie_to = $this->input->post('kodesie_to');

		if (!$noind || !$kodesie_from || !$kodesie_to) return false;
		// debug([
		// 	$noind,
		// 	$kodesie_from,
		// 	$kodesie_to
		// ]);

		$this->M_pekerjakeluar->updateJabatan($noind, $kodesie_from, $kodesie_to);
		// insert log
		$this->log_activity->activity_log(
			'UPDATE TREFJABATAN',
			"$noind, from: $kodesie_from, to: $kodesie_to"
		);

		Response::json(json_encode(['success' => true]));
	}

	/**
	 * REST API - POST
	 * MasterPekerja/DataPekerjaKeluar/update_jabatan
	 * @param POST {noind} String
	 * @param POST {kantor_asal} String
	 * @param POST {lokasi_kerja} String
	 */
	public function update_lokasi_kerja()
	{
		$user_logged = $this->session->user;
		$noind = $this->input->post('noind');
		$kantor_asal = $this->input->post('kantor_asal');
		$lokasi_kerja = $this->input->post('lokasi_kerja');

		if (!$noind || !$kantor_asal || !$lokasi_kerja) return false;

		$this->M_pekerjakeluar->updateLokasiKerja($noind, $kantor_asal, $lokasi_kerja);
		// insert log
		// $this->log_activity->activity_log(
		// 	'UPDATE LOKASI KERJA',
		// 	"$noind, kantor asal: $kantor_asal, lokasi kerja: $lokasi_kerja"
		// );

		/**
		 * INSERT Log di hrd_khs.tlog
		 */
		$log = array(
			'wkt' => date('Y-m-d H:i:s'),
			'menu' => 'FILE -> PEKERJA -> KANTOR & LOKASI',
			'ket'	=> "NOIND->$noind",
			'noind' => $user_logged,
			'jenis' => "Noind : $noind, Kantor : $kantor_asal, Lokasi : $lokasi_kerja",
			'program' => 'PEKERJA'
		);

		// do insert LOG
		$this->M_pekerjakeluar->insertLog($log);

		Response::json(json_encode(['success' => true]));
	}

	/**
	 * REST API - GET
	 * MasterPekerja/DataPekerjaKeluar/refjabatan
	 * @param GET {noind} String
	 */
	public function refjabatan()
	{
		$noind = $this->input->get('noind');
		if (!$noind) return false;

		$data = $this->M_pekerjakeluar->getReffJabatan($noind);

		Response::json(json_encode($data));
	}

	/**
	 * @REST API - POST
	 * @url: MasterPekerja/PekerjaKeluar/update
	 * @param *
	 * @return JSON
	 * @style Ruwet
	 */
	public function update()
	{
		try {
			//jika akh kontrak di ganti tgl keluar +1 day :D
			if (isset($_POST['akhkontrak'])) {
				$_POST['tglkeluar'] = '-';
			}
			$user_logged = $this->session->user;
			$noind = $this->input->post('noind');
			if (empty($noind)) throw new Exception("Noind param is empty");

			$prov = $this->input->post('prop') ? ($this->M_pekerjakeluar->ambilProv($this->input->post('prop')) ?: $this->input->post('prop')) : ''; // string
			$kab 	= $this->input->post('kab') ? ($this->M_pekerjakeluar->ambilKab($this->input->post('kab')) ?: $this->input->post('kab')) : ''; // string
			$kec 	= $this->input->post('kec') ? ($this->M_pekerjakeluar->ambilKec($this->input->post('kec')) ?: $this->input->post('kec')) : ''; // string
			$desa = $this->input->post('desa') ? ($this->M_pekerjakeluar->ambilDesa($this->input->post('desa')) ?: $this->input->post('desa')) : ''; // string

			/**
			 * @database Personalia
			 * @schema hrd_khs
			 * @table tpribadi
			 */
			$tpribadi	= array(
				'nama' 		          => $this->input->post('nama'),
				'jenkel'						=> $this->input->post('jenkel'),
				'agama'							=> $this->input->post('agama'), // real data => KRISTEN|KATHOLIK|Katolik|-|lain2|BUDHA|ISLAM|Kristen|LAIN-LAIN|Lain2|Katolik|?|HINDU|KATHOLIK|Islam
				'templahir'         => $this->input->post('templahir'),
				'tgllahir' 	        => $this->input->post('tgllahir') ? date('Y-m-d', strtotime($this->input->post('tgllahir'))) : '',
				'goldarah'					=> $this->input->post('goldarah'), // real data => B|0| |A|-|O|AB
				'nik' 		          => $this->input->post('nik'),
				'no_kk' 		        => $this->input->post('no_kk'),
				'alamat' 	          => $this->input->post('alamat'),
				'desa' 		          => $desa,
				'kec' 		          => $kec,
				'kab' 		          => $kab,
				'prop' 		          => $prov,
				'kodesie'						=> $this->input->post('kodesie'),
				'kodepos' 	        => $this->input->post('kodepos'),
				'statrumah' 	      => $this->input->post('statrumah'), // real data => RK|RS|R|-| 
				'telepon' 	        => $this->input->post('telepon'),
				'nohp' 	   	        => $this->input->post('nohp'),
				'email'             => $this->input->post('email'),
				'almt_kost'					=> $this->input->post('almt_kost'),
				'gelard'						=> $this->input->post('gelard'),
				'gelarb'						=> $this->input->post('gelarb'),
				'pendidikan'				=> $this->input->post('pendidikan'),
				'jurusan'						=> $this->input->post('jurusan'),
				'sekolah'						=> $this->input->post('sekolah'),
				'jumanak' 					=> $this->input->post('jumanak'),
				'jumsdr'						=> $this->input->post('jumsdr'),
				'email_internal'    => $this->input->post('email_internal'),
				'telkomsel_mygroup' => $this->input->post('telkomsel_mygroup'),
				'pidgin_account'    => $this->input->post('pidgin_account'),
				'nokeb' 	        	=> $this->input->post('nokeb'),
				'diangkat' 	        => $this->input->post('diangkat') ? date('Y-m-d', strtotime($this->input->post('diangkat'))) : '',
				'masukkerja'        => $this->input->post('masukkerja') ? date('Y-m-d', strtotime($this->input->post('masukkerja'))) : '',
				'status_diangkat'   => $this->input->post('status_diangkat'),
				'kd_jbt_dl'					=> $this->input->post('kd_jbt_dl'),
				// 'jabatan' 	        => $this->input->post('jabatan'),
				'kd_pkj'						=> $this->input->post('kd_pkj'),
				'golkerja'					=> $this->input->post('golkerja'),
				'npwp'							=> $this->input->post('npwp'),
				'ruang'							=> $this->input->post('ruang'),
				'lmkontrak'         => $this->input->post('lmkontrak'),
				'akhkontrak'        => $this->input->post('akhkontrak') ? date('Y-m-d', strtotime($this->input->post('akhkontrak'))) : '',
				'kantor_asal'				=> $this->input->post('kantor_asal'),
				'lokasi_kerja'			=> $this->input->post('lokasi_kerja'),
				// 'upah_jabatan'			=> $this->input->post('upah_jabatan'),
				// 'status_jabatan'		=> $this->input->post('status_jabatan'),
				'tglspsi'						=> $this->input->post('tglspsi') ? date('Y-m-d', strtotime($this->input->post('tglspsi'))) : '',
				'nospsi'						=> $this->input->post('nospsi'),
				'tglkop'						=> $this->input->post('tglkop') ? date('Y-m-d', strtotime($this->input->post('tglkop'))) : '',
				'nokoperasi'				=> $this->input->post('nokoperasi'),
				'tglkeluar'         => $this->input->post('akhkontrak') ? date('Y-m-d', strtotime($this->input->post('akhkontrak').'+1 day')) : '',
				'sebabklr'          => $this->input->post('sebabklr'),
				'statnikah'					=> $this->input->post('statnikah'),
				'tglnikah'					=> $this->input->post('tglnikah') ? date('Y-m-d', strtotime($this->input->post('tglnikah'))) : '',
				'bpjs_kes'					=> $this->input->post('bpjs_kes'), // t meaning true
				'tglberlaku_kes'		=> $this->input->post('tglberlaku_kes') ? date('Y-m-d', strtotime($this->input->post('tglberlaku_kes'))) : '',
				'bpjs_ket'					=> $this->input->post('bpjs_ket'), // t meaning true
				'tglberlaku_ket'		=> $this->input->post('tglberlaku_ket') ? date('Y-m-d', strtotime($this->input->post('tglberlaku_ket'))) : '',
				'bpjs_jht'					=> $this->input->post('bpjs_jht'),
				'tglberlaku_jht'		=> $this->input->post('tglberlaku_jht') ? date('Y-m-d', strtotime($this->input->post('tglberlaku_jht'))) : '',
				'statpajak'					=> $this->input->post('statpajak'),
				'jtanak'						=> $this->input->post('jtanak'),
				'jtbknanak'					=> $this->input->post('jtbknanak'),
				'jenis_baju'        => $this->input->post('jenis_baju'),
				'uk_baju'           => $this->input->post('uk_baju'),
				'uk_celana'         => $this->input->post('uk_celana'),
				'uk_sepatu'         => $this->input->post('uk_sepatu'),
			);

			$tpekerjaan = array(
				// hrd_khs.tpekerjaan
				'jenispekerjaan'    => $this->input->post('jenispekerjaan'), // labour / indirect labour
			);

			$er_employee_all = array(
				// erp employe all
				'external_mail'    => $this->input->post('external_mail'),
			);

			// debug($tpribadi);
			// filter array yg kosong
			$tpribadi_filtered = array_filter($tpribadi, function ($key) {
				return isset($_POST[$key]);
			}, ARRAY_FILTER_USE_KEY);
			// $tpekerjaan_filtered = array_filter($tpekerjaan, function ($key) {
			// 	return isset($_POST[$key]);
			// }, ARRAY_FILTER_USE_KEY);
			$er_employee_all_filtered = array_filter($er_employee_all, function ($key) {
				return isset($_POST[$key]);
			}, ARRAY_FILTER_USE_KEY);
			// debug($er_employee_all_filtered);

			// debug($tpribadi_filtered);

			/**
			 * ----------------------
			 * checkbox non perpanjang
			 * Tabel Keterangan
			 * ----------------------
			 */
			if ($this->input->post('non_perpanjang')) {
				$stat = ($this->input->post('non_perpanjang') === 'true');
				$this->M_pekerjakeluar->updateTKeterangan($noind, $stat);
			}

			/**
			 * ----------------------
			 * checkbox pekerja keluar
			 * Pekerja Keluar
			 * ----------------------
			 */
			if ($this->input->post('pekerja_keluar')) {
				$pekerja_keluar_checked = $this->input->post('pekerja_keluar') == 'true' ? true : false;
				if ($pekerja_keluar_checked) {
					$tglkeluar = $this->M_pekerjakeluar->getTanggalKeluarPekerja($noind); // string
					$tglhapus = date('Y-m-d', strtotime($tglkeluar . ' +190 days'));
					$tglhapusgaji = date('Y-m-d', strtotime($tglkeluar . ' +740 days'));

					$this->M_pekerjakeluar->updatePekerjaKeluar($noind, $tglhapus, $tglhapusgaji);
					// tpribadi
					$tpribadi_filtered['keluar'] = 't'; // true
				} else {
					// belum diimplementasikan
					// $this->M_pekerjakeluar->deletePekerjaKeluar($noind);
					// ini diganti dengan memo penghapusan pekerja keluar
				}
			}

			/**
			 * ----------------------
			 * Memo Perpanjangan  👍(≖‿‿≖👍)
			 * ----------------------
			 */
			if ($this->input->post('new_memo_perpanjangan_orientasi') == "true") {
				$tgl_akhir = new DateTime($this->input->post('diangkat'));

				$newCountMemo = (int)$this->M_pekerjakeluar->getCountMemoOrientasi($noind) + 1;
				$lastIdMemo = (int)$this->M_pekerjakeluar->getLastIdMemoOrientasi() + 1;

				$data_memo = array(
					'id'		=> str_pad($lastIdMemo, 10, '0', STR_PAD_LEFT), // e.g: 0000000110
					'noind' => $noind,
					'ke'		=> str_pad($newCountMemo, 2, '0', STR_PAD_LEFT), // e.g: '03'
					'mulai' => $this->input->post('tgl_diangkat_before'),
					'akhir' => $tgl_akhir->modify('-1 day')->format('Y-m-d'), // tgl - 1 day !important
					'user_' => $user_logged,
					'noind_baru' => null
				);

				// table column: id: String, noind: String, ke: String, mulai: Date, akhir: Date, user_: String, noind_baru: NULL
				$this->M_pekerjakeluar->insertMemoOrientasi($data_memo);
			}

			/**
			 * ----------------------
			 * Update Data Pekerja
			 * ----------------------
			 */
			// hrd_khs.tpribadi
			if (!empty($tpribadi_filtered)) $this->M_pekerjakeluar->updateDataPekerja($tpribadi_filtered, $noind);
			// erp.er_employee_all
			if (!empty($er_employee_all_filtered)) $this->M_pekerjakeluar->updateEmployee($er_employee_all_filtered, $noind);

			// $this->M_pekerjakeluar->updatePekerjaan($tpekerjaan_filtered, $noind); //Todo: i have no idea

			/**
			 * INSERT Log di hrd_khs.tlog
			 */
			$jenis = "SAVE->MODIFIKASI DATA PEKERJA";
			$jenis .= (isset($tpribadi['keluar']) && $tpribadi['keluar'] == 't') ? "(KELUAR)" : '';

			$log = array(
				'wkt' => date('Y-m-d H:i:s'),
				'menu' => 'FILE->PEKERJA(ERP)',
				'ket'	=> "NOIND->$noind",
				'noind' => $user_logged,
				'jenis' => $jenis,
				'program' => 'PEKERJA'
			);

			// do insert LOG
			$this->M_pekerjakeluar->insertLog($log);

			Response::json(json_encode(array(
				'success' => true,
				'message' => "Successfully update",
			)));
		} catch (Exception $e) {
			Response::json(json_encode(array(
				'success' => false,
				'message' => "Error {$e->getMessage()}",
			)));
		}
	}

	/**
	 * @DEPRECATED , replace by update() function
	 * WIll be not used
	 */
	public function updateData()
	{
		$user_id 	= $this->session->userid;
		$noind		= $this->input->post('txt_noindukLama');
		$prop 		= $this->input->post('slc_provinsi_pekerja');
		$kab 		= $this->input->post('slc_kabupaten_pekerja');
		$kec 		= $this->input->post('slc_kecamatan_pekerja');
		$desa 		= $this->input->post('slc_desa_pekerja');
		$ambil_prov = $this->M_pekerjakeluar->ambilProv($prop); // string
		$ambil_kab 	= $this->M_pekerjakeluar->ambilKab($kab); // string
		$ambil_kec 	= $this->M_pekerjakeluar->ambilKec($kec); // string
		$ambil_desa = $this->M_pekerjakeluar->ambilDesa($desa); // string

		if ($ambil_prov != null) {
			$data 	 	= array(
				'noind' 	=> $this->input->post('txt_noinduk'),
				'nama' 		=> $this->input->post('txt_namaPekerja'),
				'templahir' => $this->input->post('txt_kotaLahir'),
				'tgllahir' 	=> $this->input->post('txt_tanggalLahir'),
				'nik' 		=> $this->input->post('txt_nikPekerja'),
				'alamat' 	=> $this->input->post('txt_alamatPekerja'),
				'desa' 		=> $ambil_desa,
				'kec' 		=> $ambil_kec,
				'kab' 		=> $ambil_kab,
				'prop' 		=> $ambil_prov,
				'kodepos' 	=> $this->input->post('txt_kodePosPekerja'),
				'telepon' 	=> $this->input->post('txt_teleponPekerja'),
				'nohp' 		=> $this->input->post('txt_nohpPekerja'),
				'diangkat' 	=> $this->input->post('txt_tglDiangkat'),
				'masukkerja' => $this->input->post('txt_tglMasukKerja'),
				'lmkontrak' => $this->input->post('txt_lamaKontrak'),
				'akhkontrak' => $this->input->post('txt_akhirKontrak'),
				'jabatan' 	=> $this->input->post('txt_jabatanPekerja'),
				'tglkeluar' => $this->input->post('txt_tglkeluar'),
				'sebabklr' 	=> $this->input->post('txt_sebabkeluar'),
				'uk_baju' 	=> $this->input->post('txt_ukuranbaju'),
				'uk_celana' => $this->input->post('txt_ukurancelana'),
				'uk_sepatu' => $this->input->post('txt_ukuransepatu'),
				'kd_pkj' => $this->input->post('txt_pekerjaanPekerja'),
				'status_diangkat' => $this->input->post('rd_diangkat'),
				'email_internal' 	=> $this->input->post('txt_internalmail'),
				'telkomsel_mygroup' => $this->input->post('txt_telkomselmygroup'),
				'email' 	=> $this->input->post('txt_externalmail'),
				'pidgin_account' 	=> $this->input->post('txt_pidginaccount')
			);

			/*$mail 		= array(
								'internal_mail' 	=> $this->input->post('txt_internalmail'),
								'telkomsel_mygroup' => $this->input->post('txt_telkomselmygroup'),
								'external_mail' 	=> $this->input->post('txt_externalmail'),
								'pidgin_account' 	=> $this->input->post('txt_pidginaccount'),

								);*/

			$this->M_pekerjakeluar->updateDataPekerja($data, $noind);
			//insert to t_log
			$aksi = 'MASTER PEKERJA';
			$detail = 'Update Data Pekerja Keluar Noind = ' . $noind;
			$this->log_activity->activity_log($aksi, $detail);
			//
			/*$this->M_pekerjakeluar->updateDataPekerjaa($mail,$noind);*/
			$history 	= array(
				'noind' 		=> $this->input->post('txt_noindukLama'),
				'aktifitas' 	=> 'UPDATE',
				'date_time' 	=> date('Y-m-d H:i:s'),
				'last_updated_by' => $this->session->user,
			);
			$this->M_pekerjakeluar->historyUpdatePekerja($history);
			$tlog 	= array(
				'wkt'			=> date('Y-m-d H:i:s'),
				'menu'			=> 'MASTER PEKERJA -> EDIT DATA PEKERJA',
				'ket'			=> 'NO IND->' . $this->input->post('txt_noindukLama'),
				'noind'			=> $this->session->user,
				'jenis' 		=> 'EDIT -> DATA PEKERJA',
				'program'		=> 'ERP',
				'noind_baru'	=> 'NULL',

			);
			$this->M_pekerjakeluar->historyTlog($tlog);
			print "<script type='text/javascript'>alert('Data telah berhasil diubah. Mohon cek kembali');</script>";

			if (print "<script type='text/javascript'>alert('Data telah berhasil diubah. Mohon cek kembali');</script>" != null) {
				$data['Menu'] = 'Dashboard';
				$data['SubMenuOne'] = '';
				$data['SubMenuTwo'] = '';

				$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

				$this->load->view('V_Header', $data);
				$this->load->view('V_Sidemenu', $data);
				$this->load->view('MasterPekerja/Pekerja/PekerjaKeluar/V_Index', $data);
				$this->load->view('V_Footer', $data);
			}
		} else {
			$data 	 	= array(
				'noind' 	=> $this->input->post('txt_noinduk'),
				'nama' 		=> $this->input->post('txt_namaPekerja'),
				'templahir' => $this->input->post('txt_kotaLahir'),
				'tgllahir' 	=> $this->input->post('txt_tanggalLahir'),
				'nik' 		=> $this->input->post('txt_nikPekerja'),
				'alamat' 	=> $this->input->post('txt_alamatPekerja'),
				'kodepos' 	=> $this->input->post('txt_kodePosPekerja'),
				'telepon' 	=> $this->input->post('txt_teleponPekerja'),
				'nohp' 		=> $this->input->post('txt_nohpPekerja'),
				'diangkat' 	=> $this->input->post('txt_tglDiangkat'),
				'masukkerja' => $this->input->post('txt_tglMasukKerja'),
				'lmkontrak' => $this->input->post('txt_lamaKontrak'),
				'akhkontrak' => $this->input->post('txt_akhirKontrak'),
				'jabatan' 	=> $this->input->post('txt_jabatanPekerja'),
				'tglkeluar' => $this->input->post('txt_tglkeluar'),
				'sebabklr' 	=> $this->input->post('txt_sebabkeluar'),
				'uk_baju' 	=> $this->input->post('txt_ukuranbaju'),
				'uk_celana' => $this->input->post('txt_ukurancelana'),
				'uk_sepatu' => $this->input->post('txt_ukuransepatu'),
				'kd_pkj' => $this->input->post('txt_pekerjaanPekerja'),
				'status_diangkat' => $this->input->post('rd_diangkat'),
				'email_internal' 	=> $this->input->post('txt_internalmail'),
				'telkomsel_mygroup' => $this->input->post('txt_telkomselmygroup'),
				'email' 	=> $this->input->post('txt_externalmail'),
				'pidgin_account' 	=> $this->input->post('txt_pidginaccount')
			);

			/*$mail 		= array(
								'internal_mail' 	=> $this->input->post('txt_internalmail'),
								'telkomsel_mygroup' => $this->input->post('txt_telkomselmygroup'),
								'external_mail' 	=> $this->input->post('txt_externalmail'),
								'pidgin_account' 	=> $this->input->post('txt_pidginaccount'),

								);*/

			$this->M_pekerjakeluar->updateDataPekerja($data, $noind);
			/*$this->M_pekerjakeluar->updateDataPekerjaa($mail,$noind);*/
			$history 	= array(
				'noind' 		=> $this->input->post('txt_noindukLama'),
				'aktifitas' 	=> 'UPDATE',
				'date_time' 	=> date('Y-m-d H:i:s'),
				'last_updated_by' => $this->session->user,
			);
			$this->M_pekerjakeluar->historyUpdatePekerja($history);
			$tlog 	= array(
				'wkt'			=> date('Y-m-d H:i:s'),
				'menu'			=> 'MASTER PEKERJA -> EDIT DATA PEKERJA',
				'ket'			=> 'NO IND->' . $this->input->post('txt_noindukLama'),
				'noind'			=> $this->session->user,
				'jenis' 		=> 'EDIT -> DATA PEKERJA',
				'program'		=> 'ERP',
				'noind_baru'	=> 'NULL',

			);
			$this->M_pekerjakeluar->historyTlog($tlog);
			print "<script type='text/javascript'>alert('Data telah berhasil diubah. Mohon cek kembali');</script>";
			if (print "<script type='text/javascript'>alert('Data telah berhasil diubah. Mohon cek kembali');</script>" != null) {
				$data['Menu'] = 'Dashboard';
				$data['SubMenuOne'] = '';
				$data['SubMenuTwo'] = '';

				$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

				$this->load->view('V_Header', $data);
				$this->load->view('V_Sidemenu', $data);
				$this->load->view('MasterPekerja/Pekerja/PekerjaKeluar/V_Index', $data);
				$this->load->view('V_Footer', $data);
			};
		}
	}

	/** TODO: done this [Experimental]
	 * Module find daerah
	 * @param { Provinsi } String
	 * @param { Kabupaten } String
	 * @param { Kecamatan } String
	 * @param { Desa } String
	 * @return { Prop, Kab, Kec, Desa } Array
	 */
	public function findAddress($prop, $kab, $kec, $des)
	{
		return array(
			'provinsi' => '',
			'kabupaten' => '',
			'kecamatan' => '',
			'desa' => ''
		);
	}

	/**
	 * REST API - get data keluarga by nomor induk
	 * @method GET
	 * @return void
	 * @response JSON
	 */
	public function keluarga_read()
	{
		try {
			$noind = $this->input->get('noind');

			$family /* Array */ = $this->M_pekerjakeluar->getFamily($noind);
			$familyCount = $this->M_pekerjakeluar->getFamilyCount($noind);

			Response::json(json_encode(array(
				'success' => true,
				'data' => $family,
				'count' => [
					'childs' => $familyCount->count_childs,
					'siblings' => $familyCount->count_siblings
				]
			)));
		} catch (Exception $e) {
			Response::json(json_encode(array(
				'success' => false,
				'message' => $e->getMessage()
			)), 400);
		}
	}

	/**
	 * REST API - add data keluarga
	 * @method POST
	 * @return void
	 * @response JSON
	 */
	public function keluarga_add()
	{
		try {
			$noind = $this->input->post('noind');
			$data = $this->input->post('data');

			if (!$noind || !$data) throw "Bad Request (Empty Param)";

			$data['noind'] = $noind;
			$data['tgllahir'] = $data['tgllahir'] ? (new DateTime($data['tgllahir']))->format('Y-m-d') : '1900-01-01';

			$execute = $this->M_pekerjakeluar->insertFamily($data);
			if (!$execute) throw new Exception("Error When Inserting to database");

			// update count of child & sibling in hrd_khs.tpribadi
			$this->M_pekerjakeluar->updateCountFamily($noind);

			Response::json(json_encode(array(
				'success' => true,
				'message' => "Success insert new member family for $noind"
			)));
		} catch (Exception $e) {
			Response::json(json_encode(array(
				'success' => false,
				'message' => $e->getMessage()
			)), 400);
		}
	}

	/**
	 * REST API - edit/update data keluarga
	 * @method POST
	 * @return void
	 * @response JSON
	 */
	public function keluarga_update()
	{
		try {
			$noind = $this->input->post('noind');
			$data = $this->input->post('data');
			$nokel = $this->input->post('nokel');

			if (!$noind || !$data || !$nokel) throw new Exception("Bad Request (Empty Param)");
			$data['noind'] = $noind;
			$data['tgllahir'] = (new DateTime($data['tgllahir']))->format('Y-m-d') ?: '1900-01-01';

			$execute = $this->M_pekerjakeluar->updateFamily($noind, $nokel, $data);
			if (!$execute) throw new Exception("Error When Update to database");

			// update count of child & sibling in hrd_khs.tpribadi
			$this->M_pekerjakeluar->updateCountFamily($noind);

			Response::json(json_encode(array(
				'success' => true,
				'message' => "Success update member family $nokel for $noind"
			)));
		} catch (Exception $e) {
			Response::json(json_encode(array(
				'success' => false,
				'message' => $e->getMessage()
			)), 400);
		}
	}

	/**
	 * REST API - delete data keluarga
	 * @method POST
	 * @return void
	 * @response JSON
	 */
	public function keluarga_delete()
	{
		try {
			$noind = $this->input->post('noind');
			$nokel = $this->input->post('nokel');

			if (!$noind || !$nokel) throw new Exception("Bad Request (Empty Param)");

			$execute = $this->M_pekerjakeluar->deleteFamily($noind, $nokel);
			if (!$execute) throw new Exception("Error When Deleting to database");

			// update count of child & sibling in hrd_khs.tpribadi
			$this->M_pekerjakeluar->updateCountFamily($noind);

			Response::json(json_encode(array(
				'success' => true,
				'message' => "Success delete member family $nokel for $noind"
			)));
		} catch (Exception $e) {
			Response::json(json_encode(array(
				'success' => false,
				'message' => $e->getMessage()
			)), 400);
		}
	}

	public function provinsiPekerja()
	{
		$provinsi 	= $this->input->get('term');
		$data 		= $this->M_pekerjakeluar->getProvinsi($provinsi);

		Response::json(json_encode($data));
	}

	public function kabupatenPekerja()
	{

		$id_prov 	= $this->input->get('prov');
		$kabupaten 	= strtoupper($this->input->get('term'));
		$data 		= $this->M_pekerjakeluar->getKabupaten($kabupaten, $id_prov);

		Response::json(json_encode($data));
	}

	public function kecamatanPekerja()
	{

		$id_kab 	= $this->input->get('kab');
		$kecamatan = strtoupper($this->input->get('term'));
		$data 		= $this->M_pekerjakeluar->getKecamatan($kecamatan, $id_kab);

		Response::json(json_encode($data));
	}

	public function desaPekerja()
	{
		$id_kec = $this->input->get('kec');
		$desa 	= strtoupper($this->input->get('term'));
		$data 	= $this->M_pekerjakeluar->getDesa($desa, $id_kec);

		Response::json(json_encode($data));
	}

	/**
	 * REST API
	 * @url
	 * @param GET { noind }
	 * @response JSON
	 */
	public function getMemoPerpanjangOrientasi()
	{
		try {
			$get = $this->input->get();

			$validation = $this->form_validation
				->set_data($get)
				->set_rules('noind', 'Nomor induk', 'required')
				->set_message('required', 'Error: Field {field} Bad request')
				->run();

			if (!$validation) throw new Exception(validation_errors());

			$data = $this->M_pekerjakeluar->getMemoOrientation($get['noind']);

			Response::json(json_encode(array(
				'success' => true,
				'data' => $data
			)));
		} catch (Exception $e) {
			Response::json(json_encode(array(
				'success' => false,
				'message' => $e->getMessage()
			)), 400);
		}
	}

	/**
	 * @url Masterpekerja/EditPekerjaKeluar/generatePDFMemoOrientasi
	 * @param GET { Key } String
	 * @return RenderPDF new tab {PDF} Blob
	 */
	public function generatePDFMemoOrientasi()
	{
		$this->load->library('pdf');
		$get = $this->input->get();

		try {
			if (!isset($get['key'])) throw new Exception("key param is empty");

			// parse base64 to string
			$json = base64_decode($get['key']);
			// decode string json to array
			$data = json_decode($json, true);

			/**
			 * noind, ke, no_surat, kode_arsip, atasan, hubker
			 */
			if (!($data && isset($data['noind']) && isset($data['ke']))) throw new Exception("Key is invalid");

			/**
			 * rules example
			 * set_rules('name', 'label', 'rules[required|min_length|max_length|unique|integer|string]', 'message Array | optional')
			 * set_message('rules', 'message')
			 */
			$this->form_validation
				->set_data($data)
				->set_rules('noind', 'Nomor Induk', 'required')
				->set_rules('ke', 'Surat Ke', 'required')
				->set_message('required', 'Error: Field {field} Bad request')
				->run();

			if (!$this->form_validation->run()) throw new Exception(validation_errors());

			$memo = $this->M_pekerjakeluar->getOneMemoOrientation($data['noind'], $data['ke']);
			if (!$memo) throw new Exception("Memo not found");

			$memo->no_surat = $data['no_surat'];
			$memo->kode_arsip = $data['kode_arsip'];
			$memo->atasan /*Array */ = $this->M_pekerjakeluar->getAtasanSeksi($memo->kodesie, $data['atasan']);
			$memo->hubker /*Array */ = $this->M_pekerjakeluar->getAtasanHubker($data['hubker']);
			$memo->atasan3 = $this->M_pekerjakeluar->getAtasan3($data['atasan3']);;

			$this->pdf->load();

			$pdf 	=	new mPDF('utf-8', array(216, 297), 10, "timesnewroman", 20, 20, 20, 20, 0, 0, 'P');

			$filename	=	'Memo Perpanjangan Orientasi' . '.pdf';
			$html = $this->load->view('MasterPekerja/Pekerja/PekerjaKeluar/V_PDFMemoOrientasi', $memo, TRUE);

			$pdf->AddPage();
			$pdf->WriteHTML($html);
			$pdf->setTitle($filename);
			$pdf->Output($filename, 'I');
		} catch (Exception $e) {
			// look be nothing
			echo $e->getMessage();
		}
	}

	/**
	 * Replace data-data pekerja, seperti: tpribadi, tkeluarga, tjabatan
	 * @param POST { Noind } target
	 * @param POST { Noind } 
	 * @method POST ONLY
	 */
	public function replaceDataPekerja()
	{
		/**
		 * @database
		 * hrd_khs
		 */
		$post = $this->input->post();
		$noind_target = $post['noind']; // noind yg dirubah
		$noind_dest = $post['noind_dest']; // noind yg diambil

		try {
			/**
			 * UPDATE TPRIBADI
			 */
			$this->M_pekerjakeluar->replacePribadi($noind_target, $noind_dest);

			/**
			 * UPDATE TKELUARGA
			 */
			$this->M_pekerjakeluar->replaceKeluarga($noind_target, $noind_dest);

			/**
			 * UPDATE TJAMSOSTEK
			 */
			$this->M_pekerjakeluar->replaceJamsostek($noind_target, $noind_dest);

			/**
			 * TODO:
			 * add -> -nik-, -email-, bpjs kesehatan & bpjs ketanaga kerjaan(no, faskes) dll
			 */

			/**
			 * UPDATE BPJS KESEHATAN
			 */
			$this->M_pekerjakeluar->replaceBPJSKes($noind_target, $noind_dest);

			/**
			 * UPDATE BPJS KETENAGA KERJAAN
			 */
			$this->M_pekerjakeluar->replaceBPJSKet($noind_target, $noind_dest);

			/**
			 * INSERT LOG
			 */
			$log = array(
				'wkt' => date('Y-m-d H:i:s'),
				'menu' => 'FILE -> PEKERJA -> KANTOR & LOKASI',
				'ket'	=> "NOIND->$noind_target->$noind_dest",
				'noind' => $this->user_logged,
				'jenis' => "SAVE->UPDATE DATA PEKERJA",
				'program' => 'PEKERJA'
			);

			// do insert LOG
			$this->M_pekerjakeluar->insertLog($log);

			Response::json(json_encode(
				array(
					'success' => true,
					'message' => "Success replace other no ind data"
				)
			));
		} catch (Exception $th) {
			Response::json(json_encode(
				array(
					'success' => false,
					'message' => "Failed: {$th->getMessage()}"
				)
			), 400);
		}
	}

	public function add_perpanjangan()
	{
		$user = $this->session->user;
		// print_r($_POST);
		$mulair = $this->input->post('mulai');
		$mulai = date('Y-m-d', strtotime($mulair));
		$lama = $this->input->post('lama');
		$berakhirr = $this->input->post('berakhir');
		$berakhir = date('Y-m-d', strtotime($berakhirr));
		$tgl_keluar = date('d-m-Y', strtotime($berakhir. '+1 day'));
		$tgl_keluar_ins = date('Y-m-d', strtotime($berakhir. '+1 day'));
		$noind = $this->input->post('noind');
		$kode = substr($noind, 0,1);

		$dataPpj = $this->M_pekerjakeluar->getLpkwt($noind);
		$ppj_ke = count($dataPpj)+1;
		$now = date('Y-m-d H:i:s');

		$arr = array(
			'noind' => $noind,
			'perpanjangan_ke' => $ppj_ke,
			'lama_perpanjangan' => $lama,
			'berakhirnya_perpanjangan' => $berakhir,
			'create_date' => $now,
			'create_by' => $user,
			'last_update_date' => $now,
			'last_update_by' => $user,
			'mulai_perpanjangan' => $mulai,
			);
		$ins = $this->M_pekerjakeluar->insPPJ($arr);
		$arr2 = array(
			'akhkontrak'	=>	$berakhir,
			'tglkeluar'	=>	$tgl_keluar_ins,
			);
		$up = $this->M_pekerjakeluar->upktkklr($arr2, $noind);

		//uncomment lama ini jika ambil dari default
		// $lama = $this->getLamaperpanjangan($noind);

		// print_r($arr);
		$bck_mulai = date('d-m-Y', strtotime($berakhir.'+1 day'));
		$bck_akhir = date('d-m-Y', strtotime($berakhir. '+ '.$lama.' month'));
		$bck_tr = 	'<tr idnya ="'.$ins.'">
						<td>'.$ppj_ke.'</td>
						<td>'.$mulair.'</td>
						<td>'.$lama.'</td>
						<td>'.$berakhirr.'</td>
					</tr>';
		$back = array(
			'ppj'	=>	'Tambah Data Perpanjangan Ke '.($ppj_ke+1),
			'mulai'	=>	$bck_mulai,
			'berakhir'	=>	$bck_akhir,
			'keluar'	=>	$tgl_keluar,
			'tr'	=>	$bck_tr
			);

		echo json_encode($back);
	}

	public function edit_perpanjangan()
	{
		$user = $this->session->user;
		// print_r($_POST);
		$mulair = $this->input->post('mulai');
		$mulai = date('Y-m-d', strtotime($mulair));
		$lama = $this->input->post('lama');
		$berakhirr = $this->input->post('berakhir');
		$berakhir = date('Y-m-d', strtotime($berakhirr));
		$tgl_keluar = date('d-m-Y', strtotime($berakhir. '+1 day'));
		$tgl_keluar_ins = date('Y-m-d', strtotime($berakhir. '+1 day'));
		$id = $this->input->post('id');
		$now = date('Y-m-d H:i:s');
		$arr = array(
			'lama_perpanjangan' => $lama,
			'berakhirnya_perpanjangan' => $berakhir,
			'last_update_date' => $now,
			'last_update_by' => $user,
			'mulai_perpanjangan' => $mulai,
			);
		$up = $this->M_pekerjakeluar->upPPJ($arr, $id);
		$noind = $this->M_pekerjakeluar->getNoindPPJ($id);
		$max = $this->M_pekerjakeluar->getMaxtpkwt($noind);
		$arr2 = array(
			'akhkontrak'	=>	$berakhir,
			'tglkeluar'	=>	$tgl_keluar_ins,
			);
		if ($max == $id)
		$up = $this->M_pekerjakeluar->upktkklr($arr2, $noind);

		$bck_mulai = date('d-m-Y', strtotime($berakhir));
		$bck_akhir = date('d-m-Y', strtotime($berakhir));
		$back = array(
			'mulai'	=>	$bck_mulai,
			'lama'	=>	$lama,
			'berakhir'	=>	$bck_akhir,
			'keluar'	=>	$tgl_keluar,
			'ganti'	=>	$max==$id
			);
		echo json_encode($back);
	}

	public function delete_perpanjangan()
	{
		$back['change'] = 'false';
		// return json_encode($back);
		// exit();
		$id = $this->input->post('id');
		$noind = $this->M_pekerjakeluar->getNoindPPJ($id);
		$kode = substr($noind, 0,1);
		$lama = $this->getLamaperpanjangan($noind);
		//cek tingal 1 atau tidak, kalau iya update
		$ppj_all = $this->M_pekerjakeluar->getLpkwt($noind);
		$ttl = count($ppj_all);
		if ($ttl == 1) {
			$ppj = $this->M_pekerjakeluar->getLpkwt2($noind);
			$akhir = date('d-m-Y', strtotime($ppj['mulai_perpanjangan'].'-1 day'));
			$akhirk = date('d-m-Y', strtotime($ppj['mulai_perpanjangan']));
			$kontrak = date('Y-m-d', strtotime($akhir));
			$keluar = date('Y-m-d', strtotime($akhirk));
			$arr = array(
				'akhkontrak'	=>	$kontrak,
				'tglkeluar'	=>	$keluar,
				);
			$up = $this->M_pekerjakeluar->upktkklr($arr, $noind);

			$back['change'] = 'true';
			$back['akhir'] = $akhir;
			$back['akhirk'] = $akhirk;
			$back['m_awal'] = $akhirk;
			$back['m_akhir'] = date('d-m-Y', strtotime($akhirk.'+ '.$lama.' month -1 day'));
		}

		$delete = $this->M_pekerjakeluar->delPPJ($id);
		$ppj = $this->M_pekerjakeluar->getLpkwt2($noind);
		// jika lebih dari 1
		if (count($ppj) > 0 && $ppj_all > 1) {
			$akhir = date('d-m-Y', strtotime($ppj['berakhirnya_perpanjangan']));
			$akhirk = date('d-m-Y', strtotime($ppj['berakhirnya_perpanjangan']. '+ 1 day'));
			$kontrak = date('Y-m-d', strtotime($akhir));
			$keluar = date('Y-m-d', strtotime($akhirk));
			$arr = array(
				'akhkontrak'	=>	$kontrak,
				'tglkeluar'	=>	$keluar,
				);
			$up = $this->M_pekerjakeluar->upktkklr($arr, $noind);

			$back['change'] = 'true';
			$back['akhir'] = $akhir;
			$back['akhirk'] = $akhirk;
			$back['m_awal'] = $akhirk;
			$back['m_akhir'] = date('d-m-Y', strtotime($akhirk.'+ '.$lama.' month -1 day'));
		}
		echo json_encode($back);
	}

	public function get_tbl_perpanjangan()
	{
		$noind = $this->input->get('noind');
		$data['lpkwt'] = $this->M_pekerjakeluar->getLpkwt($noind);
		$html = $this->load->view('MasterPekerja/Pekerja/PekerjaKeluar/V_Table_');
	}

	public function getLamaperpanjangan($noind)
	{
		//param $kode important
		//return lama
		$pkj = $this->M_pekerjakeluar->dataPekerja($noind);
		$kd_jab = $pkj->kd_jabatan;

		$kode = substr($noind, 0,1);
		$ar3bln = array('K', 'P');
		$ar6bln = array('G');
		$ar12bln = array('H', 'T', 'J');
		if (in_array($kode, $ar3bln)) {
			$lama = '3';
		}elseif (in_array($kode, $ar12bln)) {
			$lama = '12';
		}elseif (in_array($kode, $ar6bln)) {
			$lama = '6';
		}elseif($kode == 'C' && $kd_jab == '18'){
			$lama = '3';
		}elseif ($kode == 'C' && $kd_jab != '18') {
			$lama = '12';
		}else{
			$lama = '0';
		}

		return $lama;
	}
}
