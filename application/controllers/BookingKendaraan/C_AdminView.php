<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_AdminView extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('BookingKendaraan/M_carimobil');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }

	public function checkSession()
	{
		if($this->session->is_logged){		
		}else{
			redirect();
		}
	}

	//------------------------show the dashboard-----------------------------
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['Title'] = 'Admin Booking';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$username = $this->session->user;
		$nm = $this->M_carimobil->ambilNamaPic($username);
		$nama = $nm[0]['nama'];
		$data['data'] = $this->M_carimobil->ambilDataRequest($nama);
		$p = $data['data'];
		if (empty($p)) {
			$data['pengemudi'] = "";
			$data['pemohon'] = "";
		}else{
			$jml = count($p);
			$id_pen="";
			$id_pem="";
			for ($i=0; $i < $jml; $i++) { 
				if ($i == 0) {
					if ($jml == 1) {
						$id_pen = "'".$p[$i]['pengemudi']."'";
						$id_pem = "'".$p[$i]['pemohon']."'";
					}else{
						$id_pen = "'".$p[$i]['pengemudi'];
						$id_pem = "'".$p[$i]['pemohon'];
					}
				}else{
					if ($i == $jml-1) {
						$id_pen = $id_pen."','".$p[$i]['pengemudi']."'";
						$id_pem = $id_pem."','".$p[$i]['pemohon']."'";
					}else{
						$id_pen = $id_pen."','".$p[$i]['pengemudi'];
						$id_pem = $id_pem."','".$p[$i]['pemohon'];
					}
				}
			}
			$data['pengemudi'] = $this->M_carimobil->ambilNamaPengemudi($id_pen);
			$data['pemohon'] = $this->M_carimobil->ambilNamaPemohon($id_pem);
		}
		

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BookingKendaraan/V_AdminView',$data);
		$this->load->view('V_Footer',$data);
	}

	function confirm($id)
	{
		$array = array(
						'confirmed' => 1,
					);
		$this->M_carimobil->updateConfirmed($id,$array);
		redirect('AdminBookingKendaraan/RequestKendaraan');
	}

	function cancel($id)
	{
		$array = array(
						'confirmed' => 2,
					);
		$this->M_carimobil->updateConfirmed($id,$array);
		redirect('AdminBookingKendaraan/RequestKendaraan');
	}
	
}