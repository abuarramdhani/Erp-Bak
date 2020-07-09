<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Cronjob extends CI_Controller {

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
		$this->load->model('PresenceManagement/MainMenu/M_cronjob');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	public function ActivatedDevice($enc_loc){
		$plain_loc	= str_replace(array('-', '_', '~'), array('+', '/', '='), $enc_loc);
		$loc 			= $this->encrypt->decode($plain_loc);
		
		$check	= $this->M_cronjob->checkActiveLoc($loc);
		foreach($check as $data_check){
			$stat	= $data_check['status_'];
		}
		
		if($stat == 0){
			$change = 1;
		}else{
			$change = 0;
		}
		
		$update	= $this->M_cronjob->changeActive($change,$loc);
		
		$this->session->set_flashdata('flashSuccess', 'This is a success message.');
			$ses=array(
				 "active" => 1,
				 "loc" => $change
			);

			$this->session->set_userdata($ses);
			redirect('PresenceManagement/Monitoring');
	}
	
	public function Refresh_Database($enc_loc){
				$date		= date('Y-m-d');
				$plain_loc	= str_replace(array('-', '_', '~'), array('+', '/', '='), $enc_loc);
				$loc 			= $this->encrypt->decode($plain_loc);
				$worker		= $this->M_cronjob->getWorker($loc);
				foreach($worker as $data_worker){
					if($data_worker['keluar']==1){
						$noind=$data_worker['noind'];
						$delete_finger	= $this->M_cronjob->deleteFinger($loc,$noind);
						$delete_worker	= $this->M_cronjob->deleteWorker($loc,$noind);
						$delete_shift		= $this->M_cronjob->deleteShift($loc,$noind,$date);
						$delete_tmp		= $this->M_cronjob->deleteTmp($loc,$noind);
					}
				}
				
				//check duplicate finger
				$duplicate	= $this->M_cronjob->checkDuplicateFinger($loc);
				foreach($duplicate as $data_duplicate){
					$finger	= $data_duplicate['finger'];
					$checkid	= $this->M_cronjob->checkid($loc,$finger);
						foreach($checkid as $data_checkid){
							$noind	=	$data_checkid['noind'];
							$checkhrd	= $this->M_cronjob->getWorkerSpec($loc,$noind);
								foreach( $checkhrd->result_array() as $data_checkhrd){
									if($data_checkhrd['keluar'] == 1){
										$delete_finger	= $this->M_cronjob->deleteFinger($loc,$noind);
										$delete_worker	= $this->M_cronjob->deleteWorker($loc,$noind);
										$delete_shift		= $this->M_cronjob->deleteShift($loc,$noind,$date);
										$delete_tmp		= $this->M_cronjob->deleteTmp($loc,$noind);
									}
									}
									if($checkhrd->num_rows() < 1 ){
										$delete_finger	= $this->M_cronjob->deleteFinger($loc,$noind);
										$delete_worker	= $this->M_cronjob->deleteWorker($loc,$noind);
										$delete_shift		= $this->M_cronjob->deleteShift($loc,$noind,$date);
										$delete_tmp		= $this->M_cronjob->deleteTmp($loc,$noind);
									}
						}
				}
				$this->session->set_flashdata('flashSuccess', 'This is a success message.');
				$ses=array(
					 "refresh_db" => 1,
					 "loc" => $loc
				);

				$this->session->set_userdata($ses);
				redirect('PresenceManagement/Monitoring');
		}
		
	public function Cronjob_Hrd(){
		// $deletePgHrd	= $this->M_cronjob->deletePgHrd();
		echo "test";
	}
	
	public function CronjobRefreshDatabase(){
		$timeStart	= date("H:i:s");
		$date		= date('Y-m-d');
		$loc	= $this->M_cronjob->load_loc();
		foreach($loc as $data_loc){
			$loc	= $data_loc['id_lokasi'];
			$worker		= $this->M_cronjob->getWorker($loc);
				foreach($worker as $data_worker){
					if($data_worker['keluar']==1){
						$noind=$data_worker['noind'];
						$delete_finger	= $this->M_cronjob->deleteFinger($loc,$noind);
						$delete_worker	= $this->M_cronjob->deleteWorker($loc,$noind);
						$delete_shift		= $this->M_cronjob->deleteShift($loc,$noind,$date);
						$delete_tmp		= $this->M_cronjob->deleteTmp($loc,$noind);
					}
				}
				
				//check duplicate finger
				$duplicate	= $this->M_cronjob->checkDuplicateFinger($loc);
				foreach($duplicate as $data_duplicate){
					$finger	= $data_duplicate['finger'];
					$checkid	= $this->M_cronjob->checkid($loc,$finger);
						foreach($checkid as $data_checkid){
							$noind	=	$data_checkid['noind'];
							$checkhrd	= $this->M_cronjob->getWorkerSpec($loc,$noind);
								foreach( $checkhrd->result_array() as $data_checkhrd){
									if($data_checkhrd['keluar'] == 1){
										$delete_finger	= $this->M_cronjob->deleteFinger($loc,$noind);
										$delete_worker	= $this->M_cronjob->deleteWorker($loc,$noind);
										$delete_shift		= $this->M_cronjob->deleteShift($loc,$noind,$date);
										$delete_tmp		= $this->M_cronjob->deleteTmp($loc,$noind);
									}
									}
									if($checkhrd->num_rows() < 1 ){
										$delete_finger	= $this->M_cronjob->deleteFinger($loc,$noind);
										$delete_worker	= $this->M_cronjob->deleteWorker($loc,$noind);
										$delete_shift		= $this->M_cronjob->deleteShift($loc,$noind,$date);
										$delete_tmp		= $this->M_cronjob->deleteTmp($loc,$noind);
									}
						}
				}
		}
		$db = "postgres_absen";
		$act = "fprefreshhrd";
		$location = "-";
		$timeStop	= date("H:i:s");
		$insert_log	= $this->M_cronjob->insert_log($db,$act,$timeStart,$timeStop,$date,$location);
		echo "success";
	}
	
	public function UpdateSection(){
		$timeStart	= date("H:i:s");
		$date	= date("Y-m-d");
		$loc	= $this->M_cronjob->load_loc();
		foreach($loc as $data_loc){
			$id_loc	= $data_loc['id_lokasi'];
			$LoadSection	= $this->M_cronjob->getSection();
			foreach($LoadSection as $data_LoadSection){
				$kodesie	= $data_LoadSection['kodesie'];
				$dept	= $data_LoadSection['dept'];
				$bidang	= $data_LoadSection['bidang'];
				$unit	= $data_LoadSection['unit'];
				$seksi	= $data_LoadSection['seksi'];
				$pekerjaan	= $data_LoadSection['pekerjaan'];
				$golkerja	= $data_LoadSection['golkerja'];
					$checkSection	= $this->M_cronjob->checkSection($kodesie,$id_loc);
					if($checkSection < 1){
						$insertSection 	= $this->M_cronjob->insertSection($kodesie, $dept, $bidang, $unit, $seksi, $pekerjaan, $golkerja,$id_loc);
					}
			}
		}
		$db = "postgres_absen";
		$act = "fpupdateseksi";
		$location = "-";
		$timeStop	= date("H:i:s");
		$insert_log	= $this->M_cronjob->insert_log($db,$act,$timeStart,$timeStop,$date,$location);
		echo "success";
	}
	

	
}
