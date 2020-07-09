<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Monitoring extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('PresenceManagement/MainMenu/M_monitoring');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	//===========================
	// 	PRESENCE MANAGEMENT START
	//===========================
	
	public function index(){	
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['device'] = $this->M_monitoring->GetLocationSpot();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MainMenu/Monitoring/V_Index',$data);
		$this->load->view('V_Footer',$data);
		$this->session->unset_userdata('change_device');
		$this->session->unset_userdata('name_loc');
		$this->session->unset_userdata('refresh_db');
		$this->session->unset_userdata('active');
		$this->session->unset_userdata('loc');
	}
	
	public function Connect($id){
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id = $this->encrypt->decode($plaintext_string);
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$dataLocal	= $this->M_monitoring->getDataLocalComputer($id);
			if($dataLocal == "failed"){
				redirect('PresenceManagement/Monitoring');
			}else{
				$data['registered'] 	= $dataLocal;
				$data['device'] 		= $this->M_monitoring->GetSpesificDeviceList($id);
				$data['lokasi'] 		= $this->M_monitoring->GetLocation($id);
				$data['UserMenu'] 	= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('PresenceManagement/MainMenu/Monitoring/V_List',$data);
				$this->load->view('V_Footer',$data);
				
				$this->session->unset_userdata('delete');
				$this->session->unset_userdata('update');
				$this->session->unset_userdata('registered');
				$this->session->unset_userdata('register');
			}
	}
	
	public function Show($enc_loc){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$enc_id =  $this->input->get('id');
		$plain_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $enc_id);
		$id = $this->encrypt->decode($plain_id);
		
		$plain_loc=str_replace(array('-', '_', '~'), array('+', '/', '='), $enc_loc);
		$loc = $this->encrypt->decode($plain_loc);

		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['enc_loc'] = $enc_loc;
		$data['enc_id'] = $enc_id;
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		
		$data['person']	= $this->M_monitoring->checkPerson($id,$loc);
		$finger	= $this->M_monitoring->checkFinger($id,$loc);
		$data['finger']	= $finger;
		
		$prefix = $fingerlist = '';
		foreach ($finger as $data_finger)
		{
			$fingerlist .= $prefix . '"' . $data_finger['id_finger'] . '"';
			$prefix = ', ';
		}
		if(empty($fingerlist)){
			$qfinger = "";
		}else{
			$qfinger = "and a.id_finger not in ($fingerlist)";
		}
		$data['all_finger']	= $this->M_monitoring->checkAllFinger($id,$qfinger);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MainMenu/Monitoring/V_Finger',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function Create(){	
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['maxfinger'] = $this->M_monitoring->maxfinger();
		$data['office'] = $this->M_monitoring->office();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MainMenu/Monitoring/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function Delete($enc_loc){
		$enc_id	= $this->input->get('id');
		
		$plain_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $enc_id);
		$id = $this->encrypt->decode($plain_id);
		
		$plain_loc=str_replace(array('-', '_', '~'), array('+', '/', '='), $enc_loc);
		$loc = $this->encrypt->decode($plain_loc);
		
		$delete_hrd_by_finger		= $this->M_monitoring->delete_hrd_by_finger($id,$loc);
		$delete_shift_by_finger		= $this->M_monitoring->delete_shift_by_finger($id,$loc);
		$delete_tmp_by_finger		= $this->M_monitoring->delete_tmp_by_finger($id,$loc);
		$delete_all_finger				= $this->M_monitoring->delete_all_noind($id,$loc);
		
		$this->session->set_flashdata('flashSuccess', 'This is a success message.');
		$ses=array(
			 "delete" => 1
		);

		$this->session->set_userdata($ses);
		redirect('PresenceManagement/Monitoring/Connect/'.$enc_loc.'');
	}
	
	public function ChangeName(){
		
		$loc	= $this->input->post('txtLocation');
		$name		= strtoupper($this->input->post('txtName'));
		$this->M_monitoring->UpdateNameLocation($loc,$name);
		redirect('PresenceManagement/Monitoring');
		
	}
	
	public function Mutation(){
		
		$tgt= $this->input->post('txtTarget');
		$loc= $this->input->post('txtLocation');

		$noind	= $this->input->post('txtID');
		$date	= date('Y-m-d');
		
		$dbworker_hrd	= $this->M_monitoring->get_worker_hrd_local($noind,$loc);
		foreach($dbworker_hrd as $data_worker){
			$noind			= $data_worker['noind'];
			$nama			= $data_worker['nama'];
			$jenkel			= $data_worker['jenkel'];
			$alamat		= $data_worker['alamat'];
			$telepon		= $data_worker['telepon'];
			$nohp			= $data_worker['nohp'];
			$diangkat		= $data_worker['diangkat'];
			$masukkerja	= $data_worker['masukkerja'];
			$kodesie		= $data_worker['kodesie'];
			$keluar			= $data_worker['keluar'];
			$tglkeluar		= $data_worker['tglkeluar'];
			$noind_baru	= $data_worker['noind_baru'];
			$kodestatus	= $data_worker['kode_status_kerja'];
			$lokasi_kerja	= $data_worker['lokasi_kerja'];
			$inserthrd		= $this->M_monitoring->insert_hrd($noind,$nama,$jenkel,$alamat,$telepon,$nohp,$diangkat,$masukkerja,$kodesie,$keluar,$tglkeluar,$noind_baru,$kodestatus,$lokasi_kerja,$tgt);
		}
		
		$dbworker_shift	= $this->M_monitoring->get_worker_shift($noind,$date,$loc);
		foreach($dbworker_shift as $data_worker){
			$noind				= $data_worker['noind'];
			$kd_shift			= $data_worker['kd_shift'];
			$kodesie			= $data_worker['kodesie'];
			$tukar				= $data_worker['tukar'];
			$jam_msk			= $data_worker['jam_msk'];
			$jam_akhmsk	= $data_worker['jam_akhmsk'];
			$jam_plg 			= $data_worker['jam_plg'];
			$break_mulai 	= $data_worker['break_mulai'];
			$break_selesai	= $data_worker['break_selesai'];
			$ist_mulai 		= $data_worker['ist_mulai'];
			$ist_selesai		= $data_worker['ist_selesai'];
			$jam_kerja		= $data_worker['jam_kerja'];
			$user				= $data_worker['user_'];
			$noind_baru		= $data_worker['noind_baru'];
			$insertshift	= $this->M_monitoring->insert_shift($date, $noind, $kd_shift, $kodesie, $tukar, $jam_msk, $jam_akhmsk, $jam_plg, $break_mulai, $break_selesai, $ist_mulai, $ist_selesai, $jam_kerja, $user,$noind_baru,$tgt);
		}
		
		$db_worker_tmppribadi	= $this->M_monitoring->get_worker_tmppribadi($noind,$loc);
		foreach($db_worker_tmppribadi as $data_worker){
			$noind		= $data_worker['noind'];
			$nama		= $data_worker['nama'];
			$kodesie	= $data_worker['kodesie'];
			$dept		= $data_worker['dept'];
			$seksi		= $data_worker['seksi'];
			$pekerjaan	= $data_worker['pekerjaan'];
			$jmlttl		= $data_worker['jmlttl'];
			$pointttl	= $data_worker['pointttl'];
			$nonttl		= $data_worker['nonttl'];
			$photo		= $data_worker['photo'];
			$path_photo	= $data_worker['path_photo'];
			$noind_baru	= $data_worker['noind_baru'];
			$inserttmppribadi 	= $this->M_monitoring->insert_tmppribadi($noind, $nama,$kodesie, $dept, $seksi, $pekerjaan, $jmlttl, $pointttl, $nonttl, $photo, $path_photo, $noind_baru, $tgt);
		}
		
		$finger	= $this->M_monitoring->checkFinger($noind,$loc);
		$prefix = $fingerlist = '';
		foreach ($finger as $data_finger)
		{
			$fingerlist .= $prefix . '"' . $data_finger['id_finger'] . '"';
			$prefix = ', ';
		}
		if(empty($fingerlist)){
			$qfinger = "and id_finger in ('06','07')";
		}else{
			$qfinger = "and id_finger in ($fingerlist)";
		}
		$dbfinger	= $this->M_monitoring->get_finger($noind,$qfinger);
		foreach($dbfinger as $data_finger){
			$id_finger		= $data_finger['id_finger'];
			$noind			= $data_finger['noind'];
			$finger			= $data_finger['finger'];
			$noind_baru	= $data_finger['noind_baru'];
			$insert			= $this->M_monitoring->insert_finger($noind,$noind_baru,$id_finger,$finger,$tgt);
		}
		
		$delete_hrd_by_finger		= $this->M_monitoring->delete_hrd_by_finger($noind,$loc);
		$delete_shift_by_finger		= $this->M_monitoring->delete_shift_by_finger($noind,$loc);
		$delete_tmp_by_finger		= $this->M_monitoring->delete_tmp_by_finger($noind,$loc);
		$delete_all_finger				= $this->M_monitoring->delete_all_noind($noind,$loc);
		
		$plain_txt = $this->encrypt->encode($loc);
		$enc_loc = str_replace(array('+', '/', '='), array('-', '_', '~'), $plain_txt);		
		
		$this->session->set_flashdata('flashSuccess', 'This is a success message.');
		$ses=array(
			 "update" => 1
		);

		$this->session->set_userdata($ses);
		redirect('PresenceManagement/Monitoring/Connect/'.$enc_loc.'');
	}
	
	public function RegisterSection(){
		$date	= date('Y-m-d');
		$loc= $this->input->post('txtLocation');
		$id	= $this->input->post('txtID');
		
		$plain_txt = $this->encrypt->encode($loc);
		$enc_loc = str_replace(array('+', '/', '='), array('-', '_', '~'), $plain_txt);	
		
		$dbhrd_sec	= $this->M_monitoring->get_worker_hrd_sec($id);
		foreach($dbhrd_sec as $data_hrd){
			if($data_hrd['keluar'] == "true"){
					$keluar = "1";
				}else{
					$keluar = "0";
				}
			$noind	= $data_hrd['noind'];
			$nama			= $data_hrd['nama'];
			$jenkel			= $data_hrd['jenkel'];
			$alamat		= $data_hrd['alamat'];
			$telepon		= $data_hrd['telepon'];
			$nohp			= $data_hrd['nohp'];
			$diangkat		= $data_hrd['diangkat'];
			$masukkerja	= $data_hrd['masukkerja'];
			$kodesie		= $data_hrd['kodesie'];
			$tglkeluar		= $data_hrd['tglkeluar'];
			$noind_baru	= $data_hrd['noind_baru'];
			$kodestatus	= $data_hrd['kode_status_kerja'];
			$lokasi_kerja	= $data_hrd['lokasi_kerja'];
				$dbcheck_hrd	= $this->M_monitoring->check_hrd_sec($noind,$loc);
				if($dbcheck_hrd < 1){
					$inserthrd		= $this->M_monitoring->insert_hrd($noind,$nama,$jenkel,$alamat,$telepon,$nohp,$diangkat,$masukkerja,$kodesie,$keluar,$tglkeluar,$noind_baru,$kodestatus,$lokasi_kerja,$loc);
				}
				
				$db_worker_tmppribadi	= $this->M_monitoring->get_worker_tmppribadi_svr($noind,$date);
					foreach($db_worker_tmppribadi as $data_worker){
						$noind		= $data_worker['noind'];
						$nama		= $data_worker['nama'];
						$kodesie	= $data_worker['kodesie'];
						$dept		= $data_worker['dept'];
						$seksi		= $data_worker['seksi'];
						$pekerjaan = $data_worker['pekerjaan'];
						$jmlttl		= 0;
						$pointttl	= 0;
						$nonttl		= $data_worker['point'];
						$photo		= $data_worker['photo'];
						$path_photo	= $data_worker['path_photo'];
						$noind_baru	= $data_worker['noind_baru'];
						$dbcheck_tmp		= $this->M_monitoring->check_tmp_svr($noind,$loc);
						if($dbcheck_tmp < 1){
							$inserttmppribadi 	= $this->M_monitoring->insert_tmppribadi($noind, $nama,$kodesie, $dept, $seksi, $pekerjaan, $jmlttl, $pointttl, $nonttl, $photo, $path_photo, $noind_baru, $loc);
						}
					}

					$dbfinger	= $this->M_monitoring->get_finger_svr($noind);
					foreach($dbfinger as $data_finger){
						$id_finger		= $data_finger['id_finger'];
						$noind			= $data_finger['noind'];
						$finger			= $data_finger['finger'];
						$noind_baru	= $data_finger['noind_baru'];
						$dbcheck_finger		= $this->M_monitoring->check_finger_svr($noind,$id_finger,$loc);
						if($dbcheck_finger < 1){
								$insert	= $this->M_monitoring->insert_finger($noind,$noind_baru,$id_finger,$finger,$loc);
						}
					}
				
				$dbshift_sec	= $this->M_monitoring->get_worker_shift_svr($noind,$date);
				foreach($dbshift_sec as $data_shift){
					$noind				= $data_shift['noind'];
					$tanggal			= $data_shift['tanggal'];
					$kd_shift			= $data_shift['kd_shift'];
					$kodesie			= $data_shift['kodesie'];
					$tukar				= $data_shift['tukar'];
					$jam_msk			= $data_shift['jam_msk'];
					$jam_akhmsk	= $data_shift['jam_akhmsk'];
					$jam_plg 			= $data_shift['jam_plg'];
					$break_mulai 	= $data_shift['break_mulai'];
					$break_selesai	= $data_shift['break_selesai'];
					$ist_mulai 		= $data_shift['ist_mulai'];
					$ist_selesai		= $data_shift['ist_selesai'];
					$jam_kerja		= $data_shift['jam_kerja'];
					$user				= $data_shift['user_'];
					$noind_baru		= $data_shift['noind_baru'];
					$dbcheck_shift		= $this->M_monitoring->check_shift_sec($noind,$tanggal,$loc);
						if($dbcheck_shift < 1){
							$insertshift	= $this->M_monitoring->insert_shift($tanggal, $noind, $kd_shift, $kodesie, $tukar, $jam_msk, $jam_akhmsk, $jam_plg, $break_mulai, $break_selesai, $ist_mulai, $ist_selesai, $jam_kerja, $user,$noind_baru,$loc);
						}
					}
			}
			$this->session->set_flashdata('flashSuccess', 'This is a success message.');
			$ses=array(
				 "register" => 1
			);

			$this->session->set_userdata($ses);
			redirect('PresenceManagement/Monitoring/Connect/'.$enc_loc.'');
		}
	
	public function Register(){
		$date	= date('Y-m-d');
		$loc= $this->input->post('txtLocation');
		$id	= $this->input->post('txtID');
		
		$checkloc = $this->M_monitoring->checkloc($id,$loc);
		
		$plain_txt = $this->encrypt->encode($loc);
		$enc_loc = str_replace(array('+', '/', '='), array('-', '_', '~'), $plain_txt);	
		
		if($checkloc > 0){
			$this->session->set_flashdata('flashSuccess', 'This is a success message.');
			$ses=array(
				 "registered" => 1
			);

			$this->session->set_userdata($ses);
			redirect('PresenceManagement/Monitoring/Connect/'.$enc_loc.'');
		}else{
			$dbworker_hrd	= $this->M_monitoring->get_worker_hrd_svr($id);
			foreach($dbworker_hrd as $data_worker){
				if($data_worker['keluar'] == "true"){
					$keluar = "1";
				}else{
					$keluar = "0";
				}
				$noind			= $data_worker['noind'];
				$nama			= $data_worker['nama'];
				$jenkel			= $data_worker['jenkel'];
				$alamat		= $data_worker['alamat'];
				$telepon		= $data_worker['telepon'];
				$nohp			= $data_worker['nohp'];
				$diangkat		= $data_worker['diangkat'];
				$masukkerja	= $data_worker['masukkerja'];
				$kodesie		= $data_worker['kodesie'];
				$tglkeluar		= $data_worker['tglkeluar'];
				$noind_baru	= $data_worker['noind_baru'];
				$kodestatus	= $data_worker['kode_status_kerja'];
				$lokasi_kerja	= $data_worker['lokasi_kerja'];
				$inserthrd		= $this->M_monitoring->insert_hrd($noind,$nama,$jenkel,$alamat,$telepon,$nohp,$diangkat,$masukkerja,$kodesie,$keluar,$tglkeluar,$noind_baru,$kodestatus,$lokasi_kerja,$loc);
			}
			
			$dbworker_shift	= $this->M_monitoring->get_worker_shift_svr($id,$date);
			foreach($dbworker_shift as $data_worker){
				$noind				= $data_worker['noind'];
				$tanggal			= $data_worker['tanggal'];
				$kd_shift			= $data_worker['kd_shift'];
				$kodesie			= $data_worker['kodesie'];
				$tukar				= $data_worker['tukar'];
				$jam_msk			= $data_worker['jam_msk'];
				$jam_akhmsk	= $data_worker['jam_akhmsk'];
				$jam_plg 			= $data_worker['jam_plg'];
				$break_mulai 	= $data_worker['break_mulai'];
				$break_selesai	= $data_worker['break_selesai'];
				$ist_mulai 		= $data_worker['ist_mulai'];
				$ist_selesai		= $data_worker['ist_selesai'];
				$jam_kerja		= $data_worker['jam_kerja'];
				$user				= $data_worker['user_'];
				$noind_baru		= $data_worker['noind_baru'];
				$insertshift	= $this->M_monitoring->insert_shift($tanggal, $noind, $kd_shift, $kodesie, $tukar, $jam_msk, $jam_akhmsk, $jam_plg, $break_mulai, $break_selesai, $ist_mulai, $ist_selesai, $jam_kerja, $user,$noind_baru,$loc);
			}
			
			$db_worker_tmppribadi	= $this->M_monitoring->get_worker_tmppribadi_svr($id,$date);
			foreach($db_worker_tmppribadi as $data_worker){
				$noind		= $data_worker['noind'];
				$nama		= $data_worker['nama'];
				$kodesie	= $data_worker['kodesie'];
				$dept		= $data_worker['dept'];
				$seksi		= $data_worker['seksi'];
				$pekerjaan	= $data_worker['pekerjaan'];
				$jmlttl		= 0;
				$pointttl	= 0;
				$nonttl		= $data_worker['point'];
				$photo		= $data_worker['photo'];
				$path_photo	= $data_worker['path_photo'];
				$noind_baru	= $data_worker['noind_baru'];
				$inserttmppribadi 	= $this->M_monitoring->insert_tmppribadi($noind, $nama,$kodesie, $dept, $seksi, $pekerjaan, $jmlttl, $pointttl, $nonttl, $photo, $path_photo, $noind_baru, $loc);
			}
			
			$dbfinger	= $this->M_monitoring->get_finger_svr($id);
			foreach($dbfinger as $data_finger){
				$id_finger		= $data_finger['id_finger'];
				$noind			= $data_finger['noind'];
				$finger			= $data_finger['finger'];
				$noind_baru	= $data_finger['noind_baru'];
				$insert			= $this->M_monitoring->insert_finger($noind,$noind_baru,$id_finger,$finger,$loc);
			}
			
			$this->session->set_flashdata('flashSuccess', 'This is a success message.');
			$ses=array(
				 "register" => 1
			);

			$this->session->set_userdata($ses);
			redirect('PresenceManagement/Monitoring/Connect/'.$enc_loc.'');
		}
	}
	
	public function JsonNoind(){
		$q = strtoupper($this->input->get('term')); //variabel kode pegawai
		$loc = $this->input->get('loc'); //variabel kode pegawai
		$result = $this->M_monitoring->getPerson($q,$loc);
		echo json_encode($result);
	}
	
	public function JsonSection(){
		$q = strtoupper($this->input->get('term')); //variabel kode pegawai
		$loc = $this->input->get('loc'); //variabel kode pegawai
		$result = $this->M_monitoring->getSection($q,$loc);
		echo json_encode($result);
	}
	
	public function JsonLocation(){
		$q = strtoupper($this->input->get('term')); //variabel kode lokasi
		$result = $this->M_monitoring->getLocationJson($q);
		echo json_encode($result);
	}
	
	public function SwitchTable(){
		$loc = $this->input->post('loc');
		$dataLocal	= $this->M_monitoring->getDataLocalComputer($loc);
		$no = 0;
		$enc_loc = $this->encrypt->encode($loc);
		$enc_loc = str_replace(array('+', '/', '='), array('-', '_', '~'), $enc_loc);
		foreach($dataLocal as $row){
			$enc_id = $this->encrypt->encode($row['noind']);
			$enc_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $enc_id);											
				if($row['lokasi_kerja'] == "01"){
					$lokasikerja = "KHS PUSAT";
				}elseif($row['lokasi_kerja'] == "02"){
					$lokasikerja = "KHS TUKSONO";
				}else{
					$lokasikerja = "UNREGISTERED";
				}
				
				if($row['keluar'] == 0){
						$status = "no";
						$color	= "green";
					}else{
						$status = "yes";
						$color	= "red";
				}
			$no++;
			echo "<tr>";
				echo "<td align='center'>".$no."</td>";
				echo "<td align='center'>".$row['noind']."</td>";
				echo "<td>".$row['nama']."</td>";
				echo "<td align='center'>".$row['jenkel']."</td>";
				echo "<td align='center'>".$row['kodesie']."</td>";
				echo "<td align='center' style='color:".$color."'>".strtoupper($status)."</td>";
				echo "<td align='center'>".$lokasikerja."</td>";
				echo "<td align='center'>".strtoupper($row['noind_baru'])."</td>";
				echo "<td align='center'>
						<a target='blank_' title='Check Data Fingercode' class='modalcheckfinger btn bg-green btn-xs' href='".site_url('PresenceManagement/Monitoring/Show/'.$enc_loc.'?id='.$enc_id.'')."'><i class='fa fa-hand-paper-o'></i></a>
						<a title='Mutation / Change to another device' data-toggle='modal' data-filter='".$row['nama']."' data-id='".$row['noind']."' class='modalmutation btn bg-orange btn-xs' href='#confirm-mutation'><i class='fa fa-random'></i></a>
						<a title='remove person from this device' href='' data-href='".site_url('PresenceManagement/Monitoring/Delete/'.$enc_loc.'?id='.$enc_id.'')."' data-toggle='modal' data-target='#confirm-delete' class='btn bg-red btn-xs'><i class='fa fa-remove'></i></a>
					 </td>";
			echo "</tr>";
			
			
			
			/*
			
			<td align="center"><?php echo $no ?></td>
			<td align="center"><?php echo $data_registered['noind'] ?></td>
			<td><?php echo $data_registered['nama'] ?></td>
			<td align="center"><?php echo $data_registered['jenkel'] ?></td>
			<td align="center"><?php echo $data_registered['kodesie'] ?></td>
			<td align="center" style="color:<?php echo $color; ?>"><?php echo strtoupper($status) ?></td>
			<td align="center"><?php echo $lokasikerja; ?></td>
			<td align="center"><?php echo strtoupper($data_registered['noind_baru']) ?></td>
			<td align="center">
				<a title="Check Data Fingercode" class="modalcheckfinger btn bg-green btn-xs"  href="<?php echo site_URL('PresenceManagement/Monitoring/Show/'.$enc_loc.'?id='.$enc_id.'') ?>"><i class="fa fa-hand-paper-o"></i> </a> 
				<a title="Mutation / Change to another device" data-toggle="modal" data-filter="<?php echo $data_registered['nama']; ?>" data-id="<?php echo $data_registered['noind']; ?>" class="modalmutation btn bg-orange btn-xs"  href="#confirm-mutation"><i class="fa fa-random"></i></a>
				<a title="remove person from this device" href="" data-href="<?php echo site_URL('PresenceManagement/Monitoring/Delete/'.$enc_loc.'?id='.$enc_id.'') ?>" data-toggle="modal" data-target="#confirm-delete" class="btn bg-red btn-xs"><i class="fa fa-remove"></i></a>
			</td>
			
			*/
		}
	}
	
	public function Access(){
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['registered'] = $this->M_monitoring->GetAccessablePeople();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MainMenu/Monitoring/V_Access',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function Refresh(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['refresh_db'] = $this->M_monitoring->refresh_db();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MainMenu/Monitoring/V_Refresh',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function SaveDevice(){
		$sn	= strtoupper($this->input->post('txtSN'));
		$vc	= strtoupper($this->input->post('txtVC'));
		$ac	= strtoupper($this->input->post('txtAC'));
		$idloc	= $this->input->post('txtIdLocation');
		$loc	= $this->input->post('txtLocation');
		$off	= $this->input->post('txtOffice');
		$ip	= $this->input->post('txtIP');
		$check	= $this->M_monitoring->checkDevice($sn);
		if($check->num_rows()<1){
			$this->M_monitoring->inserttbdevice($sn,$vc,$ac,$idloc);
		}else{
			foreach($check->result_array() as $data_device){
				$this->M_monitoring->updatetbdevice($data_device['sn'],$idloc);
			}
		}
			$this->M_monitoring->inserttblokasi($idloc,$loc,$off);
			$this->M_monitoring->inserttbmysql($idloc,$ip);
			$this->M_monitoring->inserttbpostgres($idloc,$ip);
		redirect('PresenceManagement/Monitoring');
	}
	
	public function UpdateDevice(){
		$id		= $this->input->post('txtIdLocation');
		$device_old	= $this->input->post('txtSN');
		$device_new	= $this->input->post('txt_device_tgt');
		$host	= $this->input->post('txt_host_tgt');
		$name	= $this->input->post('txtLocation');
		
		// echo $id." || ".$device_old." || ".$device_new." || ".$host." || ".$name;
		
		if(!empty($device_new)){
			$set_device	= $this->M_monitoring->set_device($id,$device_new);
			$set_null_device	= $this->M_monitoring->set_null_device($device_old);
			
			$detail_device	= $this->M_monitoring->detail_device($device_new);
			foreach($detail_device as $data_detail_device){
				$sn	= $data_detail_device['sn'];
				$vc	= $data_detail_device['vc'];
				$ac	= $data_detail_device['ac'];
				$change_device_comp	= $this->M_monitoring->change_device_comp($id,$sn,$vc,$ac);
			}
			$set_to_null	 = $this->M_monitoring->set_to_null($device_old);
		}
		
		$change_host_mysql	= $this->M_monitoring->change_host_mysql($id,$host);
		$change_host_postgres	= $this->M_monitoring->change_host_postgres($id,$host);
		
		$this->session->set_flashdata('flashSuccess', 'This is a success message.');
			$ses=array(
				 "change_device" => 1,
				 "name_loc" => $name
			);

			$this->session->set_userdata($ses);
		redirect('PresenceManagement/Monitoring');
	}
	
	public function SettingDev($enc_loc){
		$this->checkSession();
		$user_id = $this->session->userid;
		$plain_loc=str_replace(array('-', '_', '~'), array('+', '/', '='), $enc_loc);
		$loc = $this->encrypt->decode($plain_loc);
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['device'] = $this->M_monitoring->GetSpesificDeviceList($loc);
		$data['office'] = $this->M_monitoring->office();
		$data['tgt_device'] = $this->M_monitoring->DeviceNull();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MainMenu/Monitoring/V_Setting',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function ListPerson(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['person'] = $this->M_monitoring->GetListPerson();
		$data['location'] = $this->M_monitoring->getListLocation();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MainMenu/Monitoring/V_ListPerson',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function Delete_Finger(){
		$enc_loc		= $this->input->get('loc');
		
		$noind	= $this->input->get('noind');
		$fing		= $this->input->get('fing');
		
		$plain_loc=str_replace(array('-', '_', '~'), array('+', '/', '='), $enc_loc);
		$loc = $this->encrypt->decode($plain_loc);
		
		$enc_id = $this->encrypt->encode($noind);
		$enc_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $enc_id);	
		
		$count_finger		= $this->M_monitoring->count_finger($loc,$noind);
		$delete_finger	= $this->M_monitoring->delete_finger($loc,$noind,$fing);
			if($count_finger<=1){
				$delete_person_by_finger	= $this->M_monitoring->delete_person_by_finger($noind,$loc);
				redirect('PresenceManagement/Monitoring/Connect/'.$enc_loc.'');
			}else{
				redirect('PresenceManagement/Monitoring/Show/'.$enc_loc.'?id='.$enc_id.'');
			}
		}
		
		public function Add_Finger($enc_loc){
			$plain_loc = str_replace(array('-', '_', '~'), array('+', '/', '='), $enc_loc);
			$loc = $this->encrypt->decode($plain_loc);
			$enc_id	= $this->input->get('id');
			$id_finger	= $this->input->post('id_finger');
			$finger	= $this->input->post('finger');
			$code	= $this->input->post('code');
			$noind	= $this->input->post('noind');
			$noind_baru	= $this->input->post('noind_baru');
			$count	= count($finger);
			for($p=0;$p<$count;$p++){
				if(isset($id_finger[$p])){
					$var_id_finger = $id_finger[$p];
					$var_finger = $finger[$p];
					$var_code = $code[$p];
					$insert_finger	= $this->M_monitoring->insert_finger($noind,$noind_baru,$var_id_finger,$var_code,$loc);
				}
			}
			redirect('PresenceManagement/Monitoring/Show/'.$enc_loc.'?id='.$enc_id.'');
		}
		
		public function UpdateSection($enc_loc){
			$plain_loc = str_replace(array('-', '_', '~'), array('+', '/', '='), $enc_loc);
			$loc = $this->encrypt->decode($plain_loc);
			$loadSection 	= $this->M_monitoring->loadSection();
			foreach($loadSection as $data_loadSection){
				$kodesie	= $data_loadSection['kodesie'];
				$dept			= $data_loadSection['dept'];
				$bidang		= $data_loadSection['bidang'];
				$unit			= $data_loadSection['unit'];
				$seksi		= $data_loadSection['seksi'];
				$pekerjaan	= $data_loadSection['pekerjaan'];
				$golkerja	= $data_loadSection['golkerja'];
				
				$deleteSection	= $this->M_monitoring->deleteSection($loc);
				$insertSection 	= $this->M_monitoring->insertSection($loc,$kodesie,$dept,$bidang,$unit,$seksi,$pekerjaan,$golkerja);
			}
			
			$this->session->set_flashdata('flashSuccess', 'This is a success message.');
				$ses=array(
					 "refresh_db" => 1,
					 "loc" => $loc
				);

				$this->session->set_userdata($ses);
				redirect('PresenceManagement/Monitoring');
		}
		
		public function CheckPresence(){
			$this->checkSession();
			$user_id = $this->session->userid;
			
			$data['Menu'] = 'Catering List';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';
			
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			
			$loc = $this->input->post('txtLocation');
			$dtStart = $this->input->post('txtDateStart');
			$dtEnd = $this->input->post('txtDateEnd');
			
			$data['frontpresensi']	= $this->M_monitoring->checkFrontpresensi($loc,$dtStart,$dtEnd);
			$data['device'] 		= $this->M_monitoring->GetSpesificDeviceList($loc);
			$data['sesloc'] 		= $loc;
			$data['sesdtStart'] 		= $dtStart;
			$data['sesdtEnd'] 		= $dtEnd;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('PresenceManagement/MainMenu/Monitoring/V_CheckPresence',$data);
			$this->load->view('V_Footer',$data);
		}
		
		public function PresenceAccess(){
			$this->checkSession();
			$user_id = $this->session->userid;
			
			$data['Menu'] = 'Single Access';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';
			
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			
			$data['lokasi']		=	$this->M_monitoring->GetLocationSpot();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('PresenceManagement/MainMenu/Monitoring/V_SingleAccess',$data);
			$this->load->view('V_Footer',$data);
		}

		public function DistribusiCatering(){
			$this->checkSession();
			$user_id = $this->session->userid;
			
			$data['Menu'] = 'Catering List';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';
			
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('PresenceManagement/MainMenu/Monitoring/Catering/V_Index',$data);
			$this->load->view('V_Footer',$data);
		}

		public function ListPresensi($id){
			$this->checkSession();
			$user_id = $this->session->userid;
			
			$data['Menu'] = 'Catering List';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';
			
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			
			$data['data_finger'] = $this->M_monitoring->presensi_per_lokasi_kerja($id);
			$data['id']=$id;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('PresenceManagement/MainMenu/Monitoring/Catering/V_List',$data);
			$this->load->view('V_Footer',$data);
		}

		public function LoadPresensiFinger(){
			$id = $this->input->post('loc');
			echo $id;
		}

		public function DaftarPekerja(){
			$this->checkSession();
			$user_id = $this->session->userid;
			
			$data['Menu'] = 'Single Access';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';
			
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			
			
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('PresenceManagement/MainMenu/Monitoring/V_DaftarPekerja',$data);
			$this->load->view('V_Footer',$data);
		}

		public function SaveLokasiFinger(){
			$this->checkSession();
			
			$noind = $this->input->post('noind');
			$lokasi = $this->input->post('lokasi');

			$getPribadi = $this->M_monitoring->getPribadi($noind);
			$getFpPribadi = $this->M_monitoring->getFpPribadi($noind)->num_rows();
			
			if($getFpPribadi==0) {
				$insertNewFPPribadi = $this->M_monitoring->insertNewFPPribadi($lokasi,$noind);
			}else{
				$insertFPPribadi = $this->M_monitoring->insertFPPribadi($lokasi,$noind);
			}
			
			
				$Noind = $getPribadi[0]['noind'];
				$Nama = $getPribadi[0]['nama'];
				$Jenkel = $getPribadi[0]['jenkel'];
				$Alamat = $getPribadi[0]['alamat'];
				$Telepon = $getPribadi[0]['telepon'];
				$Nohp = $getPribadi[0]['nohp'];
				$Diangkat = $getPribadi[0]['diangkat'];
				$Masukkerja = $getPribadi[0]['masukkerja'];
				$Kodesie = $getPribadi[0]['kodesie'];
				$TglKeluar = $getPribadi[0]['tglkeluar'];
				$Noindbaru = $getPribadi[0]['noind_baru'];
				$Kodestatuskerja = $getPribadi[0]['kode_status_kerja'];
				$Lokasikerja = $getPribadi[0]['lokasi_kerja'];
				$Nik = $getPribadi[0]['nik'];
				$Tmplahir = $getPribadi[0]['templahir'];
				$Tgllahir = $getPribadi[0]['tgllahir'];
				$Keluar = '';

				if ($getPribadi[0]['keluar']===false || $getPribadi[0]['keluar']=='f') {
					$Keluar = 0;
				}else{
					$Keluar = 1;
				}
	
			$insertDataPribadi = $this->M_monitoring->insertDataPribadi($Noind,$Nama,$Jenkel,$Alamat,$Telepon,$Nohp,$Diangkat,$Masukkerja,$Kodesie,$Keluar,$TglKeluar,$Noindbaru,$Kodestatuskerja,$Lokasikerja,$Nik,$Tmplahir,$Tgllahir,$lokasi);

			$getTmpPribadi = $this->M_monitoring->getTmpPribadi($noind);

				$Noind = $getTmpPribadi[0]['noind'];
				$Nama = $getTmpPribadi[0]['nama'];
				$Kodesie = $getTmpPribadi[0]['kodesie'];
				$Dept = $getTmpPribadi[0]['dept'];
				$Seksi = $getTmpPribadi[0]['seksi'];
				$Pekerjaan = $getTmpPribadi[0]['pekerjaan'];
				$Jumlahttl = $getTmpPribadi[0]['jmlttl'];
				$Pointttl = $getTmpPribadi[0]['pointttl'];
				$Nonttl = $getTmpPribadi[0]['nonttl'];
				$Photo = $getTmpPribadi[0]['photo'];
				$Pathphoto = $getTmpPribadi[0]['path_photo'];
				// $Noindbaru = $getTmpPribadi[0]['noind_baru'];
				$Noindbaru = $getPribadi[0]['noind_baru'];
			
			$insertTmpPribadi = $this->M_monitoring->insertTmpPribadi($Noind,$Nama,$Kodesie,$Dept,$Seksi,$Pekerjaan,$Jumlahttl,$Pointttl,$Nonttl,$Photo,$Pathphoto,$Noindbaru,$lokasi);

			$getShiftPekerja = $this->M_monitoring->getShiftPekerja($noind);
			foreach ($getShiftPekerja as $key2) {
				$Tgl = $key2['tanggal'];
				$Noind = $key2['noind'];
				$Kd_shift = $key2['kd_shift'];
				$Kodesie = $key2['kodesie'];
				$Tukar = $key2['tukar'];
				$Jam_msk = $key2['jam_msk'];
				$Jam_akhmsk = $key2['jam_akhmsk'];
				$Jam_plg = $key2['jam_plg'];
				$Break_mulai = $key2['break_mulai'];
				$Break_selesai = $key2['break_selesai'];
				$Ist_mulai = $key2['ist_mulai'];
				$Ist_selesai = $key2['ist_selesai'];
				$Jam_kerja = $key2['jam_kerja'];
				$User = $key2['user_'];
				$Noind_baru = $key2['noind_baru'];

				$insertShiftPekerja = $this->M_monitoring->insertShiftPekerja($Tgl,$Noind,$Kd_shift,$Kodesie,$Tukar,$Jam_msk,$Jam_akhmsk,$Jam_plg,$Break_mulai,$Break_selesai,$Ist_mulai,$Ist_selesai,$Jam_kerja,$User,$Noind_baru,$lokasi);
			}
			

			$getDataJari = $this->M_monitoring->getDataJari($noind);
			foreach ($getDataJari as $key3) {
				$Idfinger = $key3['id_finger'];
				$Noind = $key3['noind'];
				$Finger = $key3['finger'];
				$Noindbaru = $key3['noind_baru'];

				$insertDataJari = $this->M_monitoring->insertDataJari($Idfinger,$Noind,$Finger,$Noindbaru,$lokasi);
			}
			
			echo json_encode(true);
		}

		public function LokasiKerja(){
			$this->checkSession();

			$lokasi = $_GET['p'];
			$data = $this->M_monitoring->getLokasiKerja($lokasi);
			echo json_encode($data);
		}

		public function deleteLokasiFinger($noind,$lokasi){
			$this->checkSession();

			// $host = $this->M_monitoring->getHost($lokasi);
			// // $Path = $host->host."/Absensi/assets/files/Absensi/Photo/".$noind.".JPG";
			// $Path2 = $host->host."/Absensi/assets/files/Absensi/Photo/".$noind.".jpg";
			// print_r(file_exists($Path2));
			// exit();

			// unlink($Path);
			// unlink($Path2);

			$getFpPribadi = $this->M_monitoring->getFpPribadi($noind)->num_rows();
			if ($getFpPribadi>1) {
				$deleteFpPribadi = $this->M_monitoring->deleteFpPribadi($noind,$lokasi);
				$deleteFinger = $this->M_monitoring->deleteFinger($noind,$lokasi);
				$deleteTTMPribadi = $this->M_monitoring->deleteTTMPribadi($noind,$lokasi);
				$deleteShiftPekerja = $this->M_monitoring->deleteShiftPekerja($noind,$lokasi);
				$deleteTPribadi = $this->M_monitoring->deleteTPribadi($noind,$lokasi);
				// unlink($Path);
				// unlink($Path2);

				redirect('PresenceManagement/Monitoring/DaftarPekerja');
			}else{
				echo "minimal 1 lokasi finger";
			}
			
		}

		public function pekerja()
		{
			$this->checkSession();

			$employee = $_GET['p'];
			$employee = strtoupper($employee);
			$data = $this->M_monitoring->getPekerja($employee);
			echo json_encode($data);
		}

		public function DataLokasiFinger(){
			$this->checkSession();

			$cariNama = $this->input->get('nama');
			$data['cariLokasiFinger'] = $this->M_monitoring->getdatapekerjaallfinger($cariNama);

			echo json_encode($data);
		}

		public function ExportPresensi(){
			$this->checkSession();
			$this->load->library('Excel');
			$lokasi = $this->input->post('excelLokasi');
			$NamaLokasi = $this->M_monitoring->ambilNamaLokasi($lokasi);
			$data['lokasi'] = $NamaLokasi[0];
			$data['cetakData'] = $this->M_monitoring->cetakDataPresensiPerLokasi($lokasi);

			$this->load->view('PresenceManagement/MainMenu/Monitoring/V_ExportPresensi',$data);
		}
	
	//=========================
	// 	PRESENCE MANAGEMENT END
	//=========================
}
