<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterItem extends CI_Controller {

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

		$this->load->model('ItemManagement/Admin/M_masteritem');
		  
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
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['MasterItem'] = $this->M_masteritem->MasterItemList();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ItemManagement/Admin/MasterItem/V_Index',$data);
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
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['SatuanList'] = $this->M_masteritem->SatuanList();
		$data['UkuranList'] = $this->M_masteritem->UkuranList();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ItemManagement/Admin/MasterItem/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function insert(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$kode_barang = strtoupper($this->input->post('txt_kode_barang'));
		$detail = strtoupper($this->input->post('txt_detail'));
		$umur = $this->input->post('txt_umur');
		$satuan = $this->input->post('txt_satuan');
		$stok = $this->input->post('txt_stok');
		$ukuran = $this->input->post('txt_ukuran');
		$dikembalikan = $this->input->post('txt_dikembalikan');
		$peringatan = $this->input->post('txt_peringatan');
		$interval_peringatan = $this->input->post('txt_interval_peringatan');
		$satuan_peringatan = strtoupper($this->input->post('txt_satuan_peringatan'));
		$set_buffer = $this->input->post('txt_set_buffer');
		if ($dikembalikan == '') {
			$dikembalikan = 0;
		}

		if ($peringatan == '') {
			$peringatan = 0;
			$interval_peringatan = 0;
			$satuan_peringatan = 0;
		}

		$CheckItem = $this->M_masteritem->CheckItem($kode_barang);
		if ($CheckItem == 0) {
			$insert = $this->M_masteritem->insert($kode_barang, $detail, $umur, $satuan, $stok, $ukuran, $dikembalikan, $peringatan, $interval_peringatan, $satuan_peringatan, $set_buffer);
			if ($insert == 1) {
				$this->show_alert('Item Created Successfully', 'bg-primary', base_url('ItemManagement/MasterItem'));
			}
			else{
				$this->show_alert('Error Ocured when inserting Item', 'alert-danger', base_url('ItemManagement/MasterItem'));
			}
		}
		else{
			$this->show_alert('Item Code Already Exist', 'alert-danger', base_url('ItemManagement/MasterItem/create'));
		}
	}

	public function edit(){
		$kode_barang = $this->input->post('kode_barang');

		$data['UpdateData'] = $this->M_masteritem->UpdateData($kode_barang);
		$data['SatuanList'] = $this->M_masteritem->SatuanList();
		$data['UkuranList'] = $this->M_masteritem->UkuranList();

		$this->load->view('ItemManagement/Admin/MasterItem/V_Update', $data);
	}

	public function update(){
		$kode_barang_old = $this->input->post('txt_kode_barang_old');
		$kode_barang = strtoupper($this->input->post('txt_kode_barang'));
		$detail = strtoupper($this->input->post('txt_detail'));
		$umur = $this->input->post('txt_umur');
		$satuan = $this->input->post('txt_satuan');
		$stok = $this->input->post('txt_stok');
		$ukuran = $this->input->post('txt_ukuran');
		$dikembalikan = $this->input->post('txt_dikembalikan');
		$peringatan = $this->input->post('txt_peringatan');
		$interval_peringatan = $this->input->post('txt_interval_peringatan');
		$satuan_peringatan = strtoupper($this->input->post('txt_satuan_peringatan'));
		$set_buffer = $this->input->post('txt_set_buffer');

		if ($dikembalikan == '') {
			$dikembalikan = 0;
		}

		if ($peringatan == '') {
			$peringatan = 0;
			$interval_peringatan = 0;
			$satuan_peringatan = 0;
		}

		if ($kode_barang == $kode_barang_old) {
			$update = $this->M_masteritem->update($kode_barang, $detail, $umur, $satuan, $stok, $ukuran, $dikembalikan, $peringatan, $interval_peringatan, $satuan_peringatan, $set_buffer, $kode_barang_old);
			if ($update == 1) {
				$this->show_alert('Item Updated Successfully', 'bg-primary', base_url('ItemManagement/MasterItem'));
			}
			else{
				$this->show_alert('Error Ocured when updating Item', 'alert-danger', base_url('ItemManagement/MasterItem'));
			}
		}
		else{
			$CheckItem = $this->M_masteritem->CheckItem($kode_barang);
			if ($CheckItem == 0) {
				$update = $this->M_masteritem->update($kode_barang, $detail, $umur, $satuan, $stok, $ukuran, $dikembalikan, $peringatan, $interval_peringatan, $satuan_peringatan, $set_buffer, $kode_barang_old);
				if ($update == 1) {
					$this->show_alert('Item Updated Successfully', 'bg-primary', base_url('ItemManagement/MasterItem'));
				}
				else{
					$this->show_alert('Error Ocured when updating Item', 'alert-danger', base_url('ItemManagement/MasterItem'));
				}
			}
			else{
				$this->show_alert('Item Code Already Exist', 'alert-danger', base_url('ItemManagement/MasterItem'));
			}
		}
	}

	public function delete($kode_barang){
		$delete = $this->M_masteritem->delete($kode_barang);
		if ($delete == 1) {
			$this->show_alert('Item Deleted Successfully', 'bg-primary', base_url('ItemManagement/MasterItem'));
		}
		else{
			$this->show_alert('Error Ocured when deleting Item', 'alert-danger', base_url('ItemManagement/MasterItem'));
		}
	}
}
