<?php 
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class C_PengajuanLibur extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('form_validation');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CateringManagement/Penjadwalan/M_pengajuanlibur');
		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Pengajuan Libur';
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Pengajuan Libur';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->form_validation->set_rules('required');
		if ($this->form_validation->run() === TRUE){
			$periode = $this->input->post('txtperiodePengajuanLibur');
			$encrypted_periode = $this->encrypt->encode($periode);
	        $encrypted_periode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_periode);
			redirect(site_url('CateringManagement/PengajuanLibur/Read/'.$encrypted_periode));
		}
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Penjadwalan/PengajuanLibur/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Read($periode){
		$periode_text = str_replace(array('-','_','~'), array('+','/','='), $periode);
		$periode_text = $this->encrypt->decode($periode_text);
		$user_id = $this->session->userid;

		$data['Title'] = 'Pengajuan Libur';
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Pengajuan Libur';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$TanggalPengajuanLibur = $this->M_pengajuanlibur->getTanggalPengajuanLibur($periode_text);
		$angka = 0;
		foreach ($TanggalPengajuanLibur as $key) {
			$PengajuanLiburByTanggal = $this->M_pengajuanlibur->getPengajuanLiburByTanggal($key['fd_tanggal']);
			foreach ($PengajuanLiburByTanggal as $value) {
				$arrData = array(
					'tanggal' => $value['fd_tanggal'],
					'libur' => $value['fs_kd_katering_libur'],
					'pengganti' => $value['fs_kd_katering_pengganti']
				);
				$tanggal = "";
				$PengajuanLiburByTanggalKd = $this->M_pengajuanlibur->getPengajuanLiburByTanggalKd($arrData);
				if (empty($PengajuanLiburByTanggalKd)) {

					$arrSelect[$angka] = array(
						'a' => $value['tanggal'],
						'b' => $value['tanggal'],
						'c' => $value['bulan'],
						'fd_tanggal' => $value['tanggal']." ".$value['bulan'], 
						'fs_kd_katering_libur' => $value['fs_kd_katering_libur'], 
						'nama_katering_libur' => $value['nama_katering_libur'], 
						'fs_kd_katering_pengganti' => $value['fs_kd_katering_pengganti'], 
						'nama_katering_pengganti' => $value['nama_katering_pengganti'], 
					);
					$angka++;
				}else{
					while (!empty($PengajuanLiburByTanggalKd)) {
						foreach ($PengajuanLiburByTanggalKd as $PL) {
							$arrData = array(
								'tanggal' => $PL['fd_tanggal'],
								'libur' => $PL['fs_kd_katering_libur'],
								'pengganti' => $PL['fs_kd_katering_pengganti']
							);
							$tanggal = $PL['tanggal'];
						}
						$PengajuanLiburByTanggalKd = $this->M_pengajuanlibur->getPengajuanLiburByTanggalKd($arrData);
						if (empty($PengajuanLiburByTanggalKd)) {

							$arrSelect[$angka] = array(
								'a' => $value['tanggal'],
								'b' => $tanggal,
								'c' => $value['bulan'],
								'fd_tanggal' => $value['tanggal']." - ".$tanggal." ".$value['bulan'], 
								'fs_kd_katering_libur' => $value['fs_kd_katering_libur'], 
								'nama_katering_libur' => $value['nama_katering_libur'], 
								'fs_kd_katering_pengganti' => $value['fs_kd_katering_pengganti'], 
								'nama_katering_pengganti' => $value['nama_katering_pengganti'], 
							);
							$angka++;
						}
					}
				}
			}
		}
		$data['encrypted_link'] = $periode;
		if (isset($arrSelect)) {
			$data['table'] = $arrSelect;
		}
		$data['select'] = $periode_text;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Penjadwalan/PengajuanLibur/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create($periode,$check=FALSE){
		$periode_text = str_replace(array('-','_','~'), array('+','/','='), $periode);
		$periode_text = $this->encrypt->decode($periode_text);

		$user_id = $this->session->userid;

		$data['Title'] = 'Tambah Pengajuan Libur';
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Pengajuan Libur';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Catering'] = $this->M_pengajuanlibur->getCatering();

		$this->form_validation->set_rules('required');
		if ($this->form_validation->run() === TRUE){
			$tanggal = $this->input->post('txtPengajuanLiburCateringCreate');
			$libur = $this->input->post('txtLiburCatering');
			$pengganti = $this->input->post('txtPenggantiCatering');
			$tanggal = explode(" - ", $tanggal);
			$arrData = array(
				'awal' 		=> $tanggal['0'],
				'akhir' 	=> $tanggal['1'],
				'libur' 	=> $libur,
				'pengganti' => $pengganti
			);
			$check = $this->M_pengajuanlibur->getPengajuanLiburByData($arrData);
			if (empty($check)) {
				$this->M_pengajuanlibur->insertPengajuanLibur($arrData);
				redirect(site_url('CateringManagement/PengajuanLibur/Read/'.$periode));
			}else{
				redirect(site_url('CateringManagement/PengajuanLibur/Create/'.$periode.'/1'));
			}
			
		}else{
			if ($check==TRUE) {
				$data['check'] = "Sudah Ada";
			}
			$data['periode'] = $periode_text;
			$data['encrypted_link'] = $periode;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CateringManagement/Penjadwalan/PengajuanLibur/V_create.php',$data);
			$this->load->view('V_Footer',$data);
		}
	}

	public function Edit($periode,$datapengajuan){
		$periode_text = str_replace(array('-','_','~'), array('+','/','='), $periode);
		$periode_text = $this->encrypt->decode($periode_text);
		$data_text = str_replace(array('-','_','~'), array('+','/','='), $datapengajuan);
		$data_text = $this->encrypt->decode($data_text);
		$isi = explode("-", $data_text);

		$user_id = $this->session->userid;

		$data['Title'] = 'Edit Pengajuan Libur';
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Pengajuan Libur';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Catering'] = $this->M_pengajuanlibur->getCatering();

		$this->form_validation->set_rules('required');
		if ($this->form_validation->run() === TRUE){
			$pengganti = $this->input->post('txtPenggantiCatering');
			$arrData = array(
				'awal' 		=> $isi['0']." ".$isi['2'],
				'akhir' 	=>$isi['1']." ".$isi['2'],
				'libur' 	=> $isi['3'],
				'pengganti' => $pengganti
			);
			$this->M_pengajuanlibur->updatePengajuanLibur($arrData);
			redirect(site_url('CateringManagement/PengajuanLibur/Read/'.$periode));
		}else{
			$data['periode'] = $periode_text;
			$data['encrypted_link'] = $periode."/".$datapengajuan;
			$data['isi'] = $isi;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CateringManagement/Penjadwalan/PengajuanLibur/V_edit.php',$data);
			$this->load->view('V_Footer',$data);
		}
	}

	public function Delete($periode,$datapengajuan){
		$periode_text = str_replace(array('-','_','~'), array('+','/','='), $periode);
		$periode_text = $this->encrypt->decode($periode_text);
		$data_text = str_replace(array('-','_','~'), array('+','/','='), $datapengajuan);
		$data_text = $this->encrypt->decode($data_text);
		$isi = explode("-", $data_text);

		$arrData = array(
			'awal' 		=> $isi['0']." ".$isi['2'],
			'akhir' 	=>$isi['1']." ".$isi['2'],
			'libur' 	=> $isi['3'],
			'pengganti' => $isi['4']
		);
		$this->M_pengajuanlibur->deletePengajuanLibur($arrData);
		redirect(site_url('CateringManagement/PengajuanLibur/Read/'.$periode));
	}
}
?>