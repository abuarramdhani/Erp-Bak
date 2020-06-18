<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class C_PenjadwalanOtomatis extends CI_Controller
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
		$this->load->model('CateringManagement/Penjadwalan/M_penjadwalanotomatis');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Penjadwalan Otomatis';
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Penjadwalan Otomatis';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['tanggal'] = $this->M_penjadwalanotomatis->getDate();
		// print_r($data['tanggal']);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Penjadwalan/PenjadwalanOtomatis/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Proses(){
		$priode = $this->input->post('txtperiodePenjadwalanOtomatis');
		$lokasi = $this->input->post('txtlokasiPenjadwalanOtomatis');

		$priode = strtolower($priode);
		$periode = explode(" ", $priode);

		$bulanini = $this->M_penjadwalanotomatis->getDate();
		$bulanini = explode("  ", $bulanini['0']['tanggal']);
		$mulai = 1;
		if (strtolower($bulanini['0']) == strtolower($periode['0']) and strtolower($bulanini['1']) == strtolower($periode['1'])) {
			$mulai = $this->M_penjadwalanotomatis->getDateNow();
			$mulai = $mulai['0']['tanggal'];
		}

		if (strlen($mulai) == 1) {
			$mulai = "0".$mulai;
		}

		$this->M_penjadwalanotomatis->deleteAllByPeriode($periode,$mulai,$lokasi);
		$katering = $this->M_penjadwalanotomatis->getCateringActive($lokasi);
		$jumlah = $this->M_penjadwalanotomatis->getCateringCount($lokasi);
		$jumlah = $jumlah['0']['jml2'];
		foreach ($katering as $kat) {
			$urutan = $this->M_penjadwalanotomatis->getCateringUrutan($kat['fs_kd_katering'],$periode,$mulai,$lokasi);
			if ($jumlah < $urutan['0']['fn_urutan_jadwal']) {
				$urutan2 = $this->M_penjadwalanotomatis->getCateringNonActiveUrutan($kat['fs_kd_katering'],$periode,$mulai,$lokasi);
				$urut = $urutan2['0']['fn_urutan_jadwal'];
			}else{
				$urut = $urutan['0']['fn_urutan_jadwal'];
			}
			
			$awal = $this->M_penjadwalanotomatis->getFirstDay($periode);
			$akhir = $this->M_penjadwalanotomatis->getLastDay($periode);
			
			
			

			$awal = $awal['0']['tanggal'];
			$akhir = $akhir['0']['tanggal'];
			$harilm = '0';
			$index = 0;

			if ($mulai !== 1) {
				$awal = $mulai;
			}
			
			// echo $mulai;exit();
			for ($i=1; $i <= $akhir; $i++) { 
				$day = $this->M_penjadwalanotomatis->getDay($periode,$i);
				
				foreach ($day as $days) {
					if ($days['hari'] == '2') {
						$urut = intval($urut) + 1;
						if ($urut > $jumlah) {
							$urut = '1';
						}
					}
					//cek hari libur & puasa
					$lbr = '0';
					$puasa = $this->M_penjadwalanotomatis->getPuasa($periode,$i);
					$libur = $this->M_penjadwalanotomatis->getLibur($periode,$i);
					if (!empty($libur) and $days['hari'] !== '1') {
						$hari = "L";
						$lbr = '1';
					}elseif (!empty($puasa)) {
						$hari = "P";
						if ($days['hari'] == '1') {
							$hari = $days['hari'];
						}
					}else{
						$hari = $days['hari'];
					}

					$detailJadwal = $this->M_penjadwalanotomatis->getDetailJadwal($hari,$urut);
					
					if (intval($i) >= intval($mulai)) {
						$arrData = array(
							'fd_tanggal' 		=> $days['lengkap'],
							'fs_kd_katering' 	=> $kat['fs_kd_katering'],
							'fn_urutan_jadwal' 	=> $urut,
							'lokasi' 			=> $lokasi.''
						);

						$this->M_penjadwalanotomatis->insertUrutanJadwal($arrData);

						foreach ($detailJadwal as $key => $dtlJdwl) {
							$array = array(
								'fd_tanggal' 		=> $days['lengkap'],
								'fs_kd_katering' 	=> $kat['fs_kd_katering'],
								'fs_tujuan_shift1' 	=> $dtlJdwl['fs_tujuan_shift1'],
								'fs_tujuan_shift2' 	=> $dtlJdwl['fs_tujuan_shift2'],
								'fs_tujuan_shift3' 	=> $dtlJdwl['fs_tujuan_shift3'],
								'lokasi'			=> $lokasi.'',
								'fb_tanda' 			=> '0'
							);
						}

						$this->M_penjadwalanotomatis->insertJadwal($array);
					}

					$harilm = $days['hari'];
				}
			}
		}

		$encrypted_periode = $this->encrypt->encode($priode);
        $encrypted_periode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_periode);
		// redirect(site_url('CateringManagement/PenjadwalanOtomatis/Finish/'.$encrypted_periode));
		redirect(site_url('CateringManagement/PenjadwalanCatering/Distribusi/'.$encrypted_periode));
	}

	public function Finish($periode){
		$periode_text = str_replace(array('-','_','~'), array('+','/','='), $periode);
		$periode_text = $this->encrypt->decode($periode_text);

		$user_id = $this->session->userid;

		$data['Title'] = 'Penjadwalan Otomatis';
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Penjadwalan Otomatis';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['tanggal'] = $this->M_penjadwalanotomatis->getDate();
		$data['sukses'] = $periode_text;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Penjadwalan/PenjadwalanOtomatis/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

}
?>