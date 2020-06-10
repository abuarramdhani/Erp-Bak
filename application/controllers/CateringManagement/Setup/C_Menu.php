<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_Menu extends CI_Controller
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

		$data['Title']			=	'List Menu';
		$data['Menu'] 			= 	'Setup';
		$data['SubMenuOne'] 	= 	'Menu';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_menu->getMenuAll();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Setup/Menu/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function tambah(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'List Menu';
		$data['Menu'] 			= 	'Setup';
		$data['SubMenuOne'] 	= 	'Menu';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Setup/Menu/V_tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function listTanggal(){
		$shift = $this->input->get('shift');
		$lokasi = $this->input->get('lokasi');
		$bulan_tahun = $this->input->get('bulan_tahun');
		$bulan = date('m',strtotime($bulan_tahun));
		$tahun = date('Y',strtotime($bulan_tahun));
		
		$data = array();
		
		$sayur = $this->M_menu->getSayur();
		if (!empty($sayur)) {
			$data['sayur'] = $sayur;
			$data['sayur_jumlah'] = count($sayur);
		}else{
			$data['sayur'] = array();
			$data['sayur_jumlah'] = 0;
		}

		$lauk_utama = $this->M_menu->getlaukUtama();
		if (!empty($lauk_utama)) {
			$data['lauk_utama'] = $lauk_utama;
			$data['lauk_utama_jumlah'] = count($lauk_utama);
		}else{
			$data['lauk_utama'] = array();
			$data['lauk_utama_jumlah'] = 0;
		}

		$lauk_pendamping = $this->M_menu->getlaukPendamping();
		if (!empty($lauk_pendamping)) {
			$data['lauk_pendamping'] = $lauk_pendamping;
			$data['lauk_pendamping_jumlah'] = count($lauk_pendamping);
		}else{
			$data['lauk_pendamping'] = array();
			$data['lauk_pendamping_jumlah'] = 0;
		}

		$buah = $this->M_menu->getBuah();
		if (!empty($buah)) {
			$data['buah'] = $buah;
			$data['buah_jumlah'] = count($buah);
		}else{
			$data['buah'] = array();
			$data['buah_jumlah'] = 0;
		}

		$menu = $this->M_menu->getMenuByLokasiShiftBulanTahun($lokasi,$shift,$bulan,$tahun);
		if (!empty($menu)) {
			$detail = $this->M_menu->getMenuDetailByMenuIdBulanTahun($menu['0']['menu_id'],$tahun,$bulan,$tahun,$bulan);
			if (!empty($detail)) {
				foreach ($detail as $detail_key => $detail_value) {
					$nama_sayur = explode(",", $detail_value['sayur']);
					$sayur_option = "";
					foreach ($sayur as $sayur_key => $sayur_value) {
						$sayur_sama = 0;
						foreach ($nama_sayur as $nama_sayur_key => $nama_sayur_value) {
							if ($sayur_value['text'] == $nama_sayur_value) {
								$sayur_sama = 1;
							}
						}
						if ($sayur_sama == 1) {
							$sayur_option .= "<option selected>".$sayur_value['text']."</option>";
						}else{
							$sayur_option .= "<option>".$sayur_value['text']."</option>";
						}
					}
					$detail[$detail_key]['sayur_option'] = $sayur_option;

					$nama_lauk_utama = explode(",", $detail_value['lauk_utama']);
					$lauk_utama_option = "";
					foreach ($lauk_utama as $lauk_utama_key => $lauk_utama_value) {
						$lauk_utama_sama = 0;
						foreach ($nama_lauk_utama as $nama_lauk_utama_key => $nama_lauk_utama_value) {
							if ($lauk_utama_value['text'] == $nama_lauk_utama_value) {
								$lauk_utama_sama = 1;
							}
						}
						if ($lauk_utama_sama == 1) {
							$lauk_utama_option .= "<option selected>".$lauk_utama_value['text']."</option>";
						}else{
							$lauk_utama_option .= "<option>".$lauk_utama_value['text']."</option>";
						}
					}
					$detail[$detail_key]['lauk_utama_option'] = $lauk_utama_option;

					$nama_lauk_pendamping = explode(",", $detail_value['lauk_pendamping']);
					$lauk_pendamping_option = "";
					foreach ($lauk_pendamping as $lauk_pendamping_key => $lauk_pendamping_value) {
						$lauk_pendamping_sama = 0;
						foreach ($nama_lauk_pendamping as $nama_lauk_pendamping_key => $nama_lauk_pendamping_value) {
							if ($lauk_pendamping_value['text'] == $nama_lauk_pendamping_value) {
								$lauk_pendamping_sama = 1;
							}
						}
						if ($lauk_pendamping_sama == 1) {
							$lauk_pendamping_option .= "<option selected>".$lauk_pendamping_value['text']."</option>";
						}else{
							$lauk_pendamping_option .= "<option>".$lauk_pendamping_value['text']."</option>";
						}
					}
					$detail[$detail_key]['lauk_pendamping_option'] = $lauk_pendamping_option;

					$nama_buah = explode(",", $detail_value['buah']);
					$buah_option = "";
					foreach ($buah as $buah_key => $buah_value) {
						$buah_sama = 0;
						foreach ($nama_buah as $nama_buah_key => $nama_buah_value) {
							if ($buah_value['text'] == $nama_buah_value) {
								$buah_sama = 1;
							}
						}
						if ($buah_sama == 1) {
							$buah_option .= "<option selected>".$buah_value['text']."</option>";
						}else{
							$buah_option .= "<option>".$buah_value['text']."</option>";
						}
					}
					$detail[$detail_key]['buah_option'] = $buah_option;

					
				}
				$data['data'] = $detail;
				$data['isi'] = count($detail);
			}else{
				$data['isi'] = 0;
				$data['data'] = array();
			}
			$data['status'] = "UPDATE";
		}else{
			$tanggal = $this->M_menu->getTanggalByBulanTahun($bulan,$tahun);
			if (!empty($tanggal)) {
				$data['isi'] = count($tanggal);
				$data['data'] = $tanggal;
			}else{
				$data['isi'] = 0;
				$data['data'] = array();
			}
			$data['status'] = "INSERT";
		}

		echo json_encode($data);
	}

	public function simpan(){
		$json_data = file_get_contents('php://input');
		$object_data = json_decode($json_data);
		$shift = $object_data->shift;
		$lokasi = $object_data->lokasi;
		$bulan_tahun = $object_data->bulan_tahun;
		$bulan = date('m',strtotime($bulan_tahun));
		$tahun = date('Y',strtotime($bulan_tahun));
		$data = $object_data->data;
		$data_detail = array();

		$menu = $this->M_menu->getMenuByLokasiShiftBulanTahun($lokasi,$shift,$bulan,$tahun);
		if (!empty($menu)) {
			$menu_id = $menu['0']['menu_id'];
		}else{
			$menu_insert = array(
				'bulan' => $bulan,
				'tahun' => $tahun,
				'shift' => $shift,
				'lokasi' => $lokasi,
				'created_by' => $this->session->user,
				'created_date' => date('Y-m-d H:i:s')
			);
			$menu_id = $this->M_menu->insertMenu($menu_insert);
		}

		foreach ($data as $key => $value) {
			$data_detail = array(
				'menu_id' => $menu_id,
				'tanggal' => $value->tanggal,
				'sayur' => implode(",", $value->sayur),
				'lauk_utama' => implode(",", $value->lauk_utama),
				'lauk_pendamping' => implode(",", $value->lauk_pendamping),
				'buah' => implode(",", $value->buah)
			);

			$menu_detail = $this->M_menu->getMenuDetailByMenuIdTanggal($menu_id,$value->tanggal);
			
			if (!empty($menu_detail)) {
				$this->M_menu->updateMenuDetailByMenuDetailId($data_detail,$menu_detail['0']['menu_detail_id']);
			}else{
				$this->M_menu->insertMenuDetail($data_detail);
			}

		}
		echo "sukses";
	}

	public function delete(){
		$id = $this->input->get('menu_id');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_menu->deleteMenuByMenuId($plaintext_string);
		$this->M_menu->deleteMenuDetailByMenuId($plaintext_string);

		$data_awal = $this->M_menu->getMenuAll();
		$data_akhir = array();
		if (!empty($data_awal)) {
			$bulan = array(
				1 => 'Januari',
				2 => 'Februari',
				3 => 'Maret',
				4 => 'April',
				5 => 'Mei',
				6 => 'Juni',
				7 => 'Juli',
				8 => 'Agustus',
				9 => 'September',
				10 => 'Oktober',
				11 => 'November',
				12 => 'Desember'
			);
			$shift = array(
				1 => 'SHIFT_1_Umum',
				2 => 'SHIFT_2',
				3 => 'SHIFT_3'
			);
			$nomor = 1;
			foreach ($data_awal as $key => $value) {
				$encrypted_string = $this->encrypt->encode($value['menu_id']);
        		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
				$data_akhir[$key]['nomor'] = "<td style=\"text-align: center\">".$nomor."</td>";
				$data_akhir[$key]['action'] = "
				<tr>
					<td style=\"text-align: center\">".$nomor."</td>
					<td style=\"text-align: center\">
						<a href=\"".base_url('CateringManagement/Setup/Menu/detail?menu_id='.$encrypted_string)."\" class=\"btn btn-primary\"><span class=\"fa fa-info-circle\"></span> Detail</a>
						<a target=\"_blank\" href=\"".base_url('CateringManagement/Setup/Menu/pdf?menu_id='.$encrypted_string)."\" class=\"btn btn-danger\"><span class=\"fa fa-file-pdf-o\"></span> PDF</a>
						<a href=\"".base_url('CateringManagement/Setup/Menu/edit?menu_id='.$encrypted_string)."\" class=\"btn btn-info\"><span class=\"fa fa-pencil-square-o\"></span> Edit</a>
						<button 
							id=\"btn-CM-Menu-Hapus\" 
							class=\"btn btn-danger\" 
							data-bulan=\"".$bulan[$value['bulan']]."\" 
							data-tahun=\"".$value['tahun']."\" 
							data-shift=\"".$shift[$value['shift']]."\"
							data-menuid=\"".$encrypted_string."\">
								<span class=\"fa fa-trash\"></span> 
							Hapus
						</button>
					</td>
				</tr>";
				$data_akhir[$key]['bulan_tahun'] = "<td>".$bulan[$value['bulan']].' - '.$value['tahun']."</td>";
				$data_akhir[$key]['shift'] = "<td>".$shift[$value['shift']]."</td>";
				
				$nomor++;
			}
		}
		echo json_encode($data_akhir);
	}

	public function detail(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$id = $this->input->get('menu_id');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['data'] = $this->M_menu->getMenuByMenuId($plaintext_string);
		$data['detail'] = $this->M_menu->getmenuDetailByMenuId($plaintext_string);

		$data['Title']			=	'List Menu';
		$data['Menu'] 			= 	'Setup';
		$data['SubMenuOne'] 	= 	'Menu';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Setup/Menu/V_detail',$data);
		$this->load->view('V_Footer',$data);
	}

	public function pdf(){
		$id = $this->input->get('menu_id');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['data'] = $this->M_menu->getMenuByMenuId($plaintext_string);
		$data['detail'] = $this->M_menu->getmenuDetailByMenuId($plaintext_string);

		$this->load->library('pdf');

	    $pdf = $this->pdf->load();
	    $pdf = new mPDF('utf-8', 'A4', 8, '', 5, 5, 5, 5, 5, 5, 'P');
	    if (!empty($data['data'])) {
	    	$bulan = array(
				1 => 'Januari',
				2 => 'Februari',
				3 => 'Maret',
				4 => 'April',
				5 => 'Mei',
				6 => 'Juni',
				7 => 'Juli',
				8 => 'Agustus',
				9 => 'September',
				10 => 'Oktober',
				11 => 'November',
				12 => 'Desember'
			);
			$shift = array(
				1 => 'SHIFT_1_Umum',
				2 => 'SHIFT_2',
				3 => 'SHIFT_3'
			);
	    	foreach ($data['data'] as $key => $value) {
	    		$filename = 'MENU_BULAN_'.$bulan[$value['bulan']].$value['tahun'].'_'.$shift[$value['shift']].'.pdf';
	    	}
	    }else{
	    	$filename = 'MENU.pdf';
	    }
	    // echo "<pre>";print_r($data['PrintppDetail']);exit();
	    $html = $this->load->view('CateringManagement/Setup/Menu/V_pdf', $data, true);
	    $pdf->WriteHTML($html, 2);
	    // $pdf->Output($filename, 'D');
	    $pdf->Output($filename, 'I');
	}

	public function edit(){
		$id = $this->input->get('menu_id');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['data'] = $this->M_menu->getMenuByMenuId($plaintext_string);
		$data['detail'] = $this->M_menu->getmenuDetailByMenuId($plaintext_string);
	}
} ?>