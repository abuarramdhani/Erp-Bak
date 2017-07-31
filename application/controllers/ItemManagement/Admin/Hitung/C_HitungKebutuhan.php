<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_HitungKebutuhan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		$this->load->model('ItemManagement/Admin/Hitung/M_hitungkebutuhan');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Hitung';
		$data['SubMenuOne'] = 'Hitung Kebutuhan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['HitungKebutuhan'] = $this->M_hitungkebutuhan->HitungKebutuhanList();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ItemManagement/Admin/Hitung/HitungKebutuhan/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	
	public function show_alert($message,$type,$redirect){
		$alert = '
				<div class="alert '.$type.' flyover flyover-top">
					<span style="float: right;cursor:pointer" onclick="$(this).parent().removeClass(\'in\')">
						<b style="color: #fff;">&times;</b>
					</span>
					'.$message.'
				</div>

				<script type="text/javascript">
					$(document).ready(function(){
						setTimeout(function(){
							$(".flyover-top").addClass("in");
						}, 10);
						setTimeout(function(){
							$(".flyover-top").removeClass("in");
						}, 5000);
					});
				</script>
				';
		$this->session->set_flashdata('alert',$alert);
		redirect($redirect);
	}

	public function create(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Hitung';
		$data['SubMenuOne'] = 'Hitung Kebutuhan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ItemManagement/Admin/Hitung/HitungKebutuhan/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function calculate(){
		$modul = $this->input->post('txt_modul');
		$periode = $this->input->post('txt_periode');
		$kodesie = $this->input->post('txt_kodesie');
		$kode_barang = $this->input->post('txt_kode_barang');

		$getSeksi = $this->M_hitungkebutuhan->getSeksi($periode, $kodesie, $kode_barang);
		$getPekerjaan = $this->M_hitungkebutuhan->getPekerjaan($periode, $kodesie, $kode_barang);
		$getBarang = $this->M_hitungkebutuhan->getBarang($periode, $kodesie, $kode_barang);

		$getSummary = $this->M_hitungkebutuhan->getSummary($periode,$kodesie,$kode_barang);

		if ($modul == 'detail') {
			foreach ($getSeksi as $SE) {
				echo '
						<tr>
							<td colspan="5"><b>SEKSI : ('.$SE['kodesie'].') '.$SE['seksi'].'</b></td>
						</tr>
					';
				foreach ($getPekerjaan as $PE) {
					if ($SE['kodesie'] == $PE['kodesie']) {
						echo '
							<tr>
								<td></td>
								<td colspan="4"><b>JOB/NOIND : ('.$PE['pkj_noind'].') '.$PE['pekerjaan'].'</b></td>
							</tr>
						';
						foreach ($getBarang as $BA) {
							if ($PE['pkj_noind'] == $BA['pkj_noind']) {
								echo '
									<tr>
										<td></td>
										<td>'.$BA['kode_standar'].'</td>
										<td>'.$BA['kode_barang'].'</td>
										<td>'.$BA['detail'].'</td>
										<td align="center">'.$BA['jumlah_akhir'].'</td>
									</tr>
								';
							}
						}
						echo '<tr><td colspan="5"></td></tr>';
					}
				}
			}
		}

		if ($modul == 'summary') {
			foreach ($getSummary as $SM) {
				$jumlah_akhir = ceil((($SM['set_buffer']/100)*$SM['jml_akhir'])+$SM['jml_akhir']);
				$jumlah_akhir = $jumlah_akhir-$SM['sisa_stok'];
				echo '
					<tr>
						<td>'.$SM['kode_barang'].'</td>
						<td>'.$SM['detail'].'</td>
						<td>'.$SM['set_buffer'].'%</td>
						<td align="center">'.$SM['jml_akhir'].'</td>
						<td align="center">'.$SM['sisa_stok'].'</td>
						<td align="center">'.$jumlah_akhir.'</td>
					</tr>
				';
			}
		}
		
	}

	public function insert(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$periode = $this->input->post('txt_kode_kebutuhan');
		$periode = $this->input->post('txt_periode');
		$kodesie = $this->input->post('txt_kodesie');
		$kode_barang = $this->input->post('txt_kode_barang');

		$getSeksi = $this->M_hitungkebutuhan->getSeksi($periode, $kodesie, $kode_barang);
		$getPekerjaan = $this->M_hitungkebutuhan->getPekerjaan($periode, $kodesie, $kode_barang);
		$getBarang = $this->M_hitungkebutuhan->getBarang($periode, $kodesie, $kode_barang);

		$getSummary = $this->M_hitungkebutuhan->getSummary($periode,$kodesie,$kode_barang);

		foreach ($getSeksi as $SE) {
			$kodesie = $SE['kodesie'];
			foreach ($getPekerjaan as $PE) {
				if ($SE['kodesie'] == $PE['kodesie']) {
					$kdpekerjaan = $PE['pkj_noind'];
					foreach ($getBarang as $BA) {
						if ($SE['kodesie'] == $BA['kodesie'] && $PE['pkj_noind'] == $BA['pkj_noind']) {
							$kode_barang = $BA['kode_barang'];
							$total_kebutuhan = $BA['jumlah_akhir'];
							$checkBatas = $this->M_hitungkebutuhan->checkBatas($periode, $kodesie, $kdpekerjaan, $kode_barang);
							if ($BA['jumlah_akhir'] == '') {
								$jumlah = 0;
							}
							else{
								$jumlah = $BA['jumlah_akhir'];
							}
							if ($checkBatas->num_rows() == 0) {
								$insert = $this->M_hitungkebutuhan->InsertBatasBon($periode, $kodesie, $kdpekerjaan, $kode_barang, $jumlah);
								$result[] = $insert;
							}
							else{
								$update = $this->M_hitungkebutuhan->UpdateBatasBon($periode, $kodesie, $kdpekerjaan, $kode_barang, $jumlah);
								$result[] = $update;
							}

							$checkKebutuhan = $this->M_hitungkebutuhan->checkKebutuhan($periode, $kode_barang);
							if ($checkKebutuhan->num_rows() != 0) {
								$delete_kebutuhan = $this->M_hitungkebutuhan->deleteKebutuhan($periode, $kode_barang);
							}

							$generate_kebutuhan = $this->M_hitungkebutuhan->GenerateKebutuhan($periode, $kode_barang);
							foreach ($generate_kebutuhan as $gk) {
								$insert = $this->M_hitungkebutuhan->InsertKebutuhan($gk['periode'], $gk['kode_barang'], $gk['total_kebutuhan']);
							}
						}
					}
				}
			}
		}

		/*foreach ($getSummary as $SM) {
			$checkKebutuhan = $this->M_hitungkebutuhan->checkKebutuhan($periode, $SM['kode_barang']);
			if ($checkKebutuhan->num_rows() == 0) {
				$jumlah_akhir = ceil((($SM['set_buffer']/100)*$SM['jml_akhir'])+$SM['jml_akhir']);
				$insert = $this->M_hitungkebutuhan->InsertKebutuhan($periode, $SM['kode_barang'], $jumlah_akhir);
				$result[] = $insert;
			}
			else{
				foreach ($checkKebutuhan->result_array() as $cK) {
					$status = $cK['status'];
					$jumlah_akhir = ceil((($SM['set_buffer']/100)*$SM['jml_akhir'])+$SM['jml_akhir']);
					if ($status == 'NEW') {
						$update = $this->M_hitungkebutuhan->UpdateKebutuhan($periode, $SM['kode_barang'], $jumlah_akhir);
						$result[] = $update;
					}
					else{
						$insert = $this->M_hitungkebutuhan->InsertKebutuhan($periode, $SM['kode_barang'], $jumlah_akhir);
						$result[] = $insert;
					}
				}
			}
		}*/
		if (in_array(0, $result) && in_array(1, $result)) {
			$this->show_alert('Some data Couldn\'t be inserted', 'alert-warning', base_url('ItemManagement/Hitung/HitungKebutuhan'));
		}
		elseif(in_array(0, $result) && !in_array(1, $result)){
			$this->show_alert('All data Couldn\'t be inserted', 'alert-danger', base_url('ItemManagement/Hitung/HitungKebutuhan'));
		}
		else{
			$this->show_alert('All Data Inserted Successfully', 'bg-primary', base_url('ItemManagement/Hitung/HitungKebutuhan'));
		}
	}

	public function changeStatus(){
		$status = $this->input->post('txt_status');
		$data_status = $this->input->post('txt_data_status');

		foreach ($data_status as $ds) {
			$ds_ex = explode('//', $ds);
			$periode = $ds_ex[0];
			$kode_barang = $ds_ex[1];
			$update = $this->M_hitungkebutuhan->UpdateStatus($status, $periode, $kode_barang);
			if ($status == 'READY') {
				$UpdateMasterItem = $this->M_hitungkebutuhan->UpdateMasterItem($periode, $kode_barang);
				$result[] = $UpdateMasterItem;
			}
			$result[] = $update;
		}

		if (in_array(0, $result) && in_array(1, $result)) {
			$this->show_alert('Some data Couldn\'t be updated', 'alert-warning', base_url('ItemManagement/Hitung/HitungKebutuhan'));
		}
		elseif(in_array(0, $result) && !in_array(1, $result)){
			$this->show_alert('All data Couldn\'t be updated', 'alert-danger', base_url('ItemManagement/Hitung/HitungKebutuhan'));
		}
		else{
			$this->show_alert('All Data Inserted Successfully', 'bg-primary', base_url('ItemManagement/Hitung/HitungKebutuhan'));
		}

	}
}
