<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_PekerjaMakanKhusus extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CateringManagement/Setup/M_pekerjamakankhusus');
		$this->load->model('CateringManagement/Setup/M_menu');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'List Pekerja Makan Khusus';
		$data['Menu'] 			= 	'Setup';
		$data['SubMenuOne'] 	= 	'Pekerja Makan Khusus';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['data'] = $this->M_pekerjamakankhusus->getPekerjaMakanKhususAll();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Setup/PekerjaMakanKhusus/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function tambah(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Makan Khusus';
		$data['Menu'] 			= 	'Setup';
		$data['SubMenuOne'] 	= 	'Pekerja Makan Khusus';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['sayur'] = $this->M_menu->getSayur();
		$data['lauk_utama'] = $this->M_menu->getLaukUtama();
		$data['lauk_pendamping'] = $this->M_menu->getLaukPendamping();
		$data['buah'] = $this->M_menu->getBuah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Setup/PekerjaMakanKhusus/V_tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getPekerja(){
		$key = $this->input->Get('term');
		$data = $this->M_pekerjamakankhusus->getPekerjaByKey($key);
		echo json_encode($data);
	}

	public function simpan(){
		$pekerja = $this->input->post('pekerja');
		$sayur = $this->input->post('sayur');
		$lauk_utama = $this->input->post('lauk_utama');
		$lauk_pendamping = $this->input->post('lauk_pendamping');
		$buah = $this->input->post('buah');
		$sayur_pengganti = $this->input->post('sayur_pengganti');
		$lauk_utama_pengganti = $this->input->post('lauk_utama_pengganti');
		$lauk_pendamping_pengganti = $this->input->post('lauk_pendamping_pengganti');
		$buah_pengganti = $this->input->post('buah_pengganti');
		$pekerja_makan_khusus_id = $this->input->post('pekerja_makan_khusus_id');
		$tanggal_mulai = $this->input->post('tanggal_mulai');
		$tanggal_selesai = $this->input->post('tanggal_selesai');

		$khusus = $this->M_pekerjamakankhusus->getPekerjaMakanKhususByNoindSayurLaukUtamaLaukPendampingBuah($pekerja,$sayur,$lauk_utama,$lauk_pendamping,$buah);
		if (!empty($khusus)) {
			$data_update = array(
				'pengganti_sayur' => $sayur_pengganti,
				'pengganti_lauk_utama' => $lauk_utama_pengganti,
				'pengganti_lauk_pendamping' => $lauk_pendamping_pengganti,
				'pengganti_buah' => $buah_pengganti,
				'updated_by' => $this->session->user,
				'updated_date' => date('Y-m-d H:i:s'),
				'tanggal_mulai' => $tanggal_mulai,
				'tanggal_selesai' => $tanggal_selesai
			);
			$this->M_pekerjamakankhusus->updatePekerjaMakanKhususByPekerjaMenuKhususId($data_update,$khusus[0]['pekerja_menu_khusus_id']);
		}elseif ($pekerja_makan_khusus_id !== "0") {
			$data_update = array(
				'menu_sayur' => $sayur,
				'menu_lauk_utama' => $lauk_utama,
				'menu_lauk_pendamping' => $lauk_pendamping,
				'menu_buah' => $buah,
				'pengganti_sayur' => $sayur_pengganti,
				'pengganti_lauk_utama' => $lauk_utama_pengganti,
				'pengganti_lauk_pendamping' => $lauk_pendamping_pengganti,
				'pengganti_buah' => $buah_pengganti,
				'updated_by' => $this->session->user,
				'updated_date' => date('Y-m-d H:i:s'),
				'tanggal_mulai' => $tanggal_mulai,
				'tanggal_selesai' => $tanggal_selesai
			);
			$this->M_pekerjamakankhusus->updatePekerjaMakanKhususByPekerjaMenuKhususId($data_update,$pekerja_makan_khusus_id);
		}else{
			$data_insert = array(
				'noind' => $pekerja,
				'menu_sayur' => $sayur,
				'menu_lauk_utama' => $lauk_utama,
				'menu_lauk_pendamping' => $lauk_pendamping,
				'menu_buah' => $buah,
				'pengganti_sayur' => $sayur_pengganti,
				'pengganti_lauk_utama' => $lauk_utama_pengganti,
				'pengganti_lauk_pendamping' => $lauk_pendamping_pengganti,
				'pengganti_buah' => $buah_pengganti,
				'created_by' => $this->session->user,
				'created_date' => date('Y-m-d H:i:s'),
				'tanggal_mulai' => $tanggal_mulai,
				'tanggal_selesai' => $tanggal_selesai
			);
			$this->M_pekerjamakankhusus->insertPekerjaMakanKhusus($data_insert);
		}
	}

	public function edit(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$id = $this->input->get('id');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['data'] = $this->M_pekerjamakankhusus->getPekerjaMakanKhususById($plaintext_string);

		$data['Title']			=	'Pekerja Makan Khusus';
		$data['Menu'] 			= 	'Setup';
		$data['SubMenuOne'] 	= 	'Pekerja Makan Khusus';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['sayur'] = $this->M_menu->getSayur();
		$data['lauk_utama'] = $this->M_menu->getLaukUtama();
		$data['lauk_pendamping'] = $this->M_menu->getLaukPendamping();
		$data['buah'] = $this->M_menu->getBuah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Setup/PekerjaMakanKhusus/V_tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function delete(){
		$id = $this->input->get('id');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_pekerjamakankhusus->deletePekerjaMakanKhususById($plaintext_string);

		$data_awal = $this->M_pekerjamakankhusus->getPekerjaMakanKhususAll();
		$data_akhir = array();
		if (!empty($data_awal)) {
			foreach ($data_awal as $key => $value) {
				$encrypted_string = $this->encrypt->encode($value['pekerja_menu_khusus_id']);
	    		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

				$data_akhir[$key]['action'] = "<a href=\"".base_url('CateringManagement/Setup/PekerjaMakanKhusus/edit?id='.$encrypted_string)."\" class=\"btn btn-info\"><span class=\"fa fa-pencil-square-o\"></span> Edit</a>
						<button class=\"btn btn-danger btn-CM-PekerjaMakanKhusus-Hapus\" data-id=\"".$encrypted_string."\"><span class=\"fa fa-trash\"></span> Hapus</button>";
				$data_akhir[$key]['pekerja'] = $value['noind'].' - '.$value['nama'];
				$data_akhir[$key]['menu'] = $value['menu_sayur'].' - '.$value['menu_lauk_utama'].' - '.$value['menu_lauk_pendamping'].' - '.$value['menu_buah'];
				$data_akhir[$key]['pengganti'] = $value['pengganti_sayur'].' - '.$value['pengganti_lauk_utama'].' - '.$value['pengganti_lauk_pendamping'].' - '.$value['pengganti_buah'];
				$data_akhir[$key]['tanggal_mulai'] = $value['tanggal_mulai'];
				$data_akhir[$key]['tanggal_selesai'] = $value['tanggal_selesai'];
				
			}
		}

		echo json_encode($data_akhir);
	}

} ?>