<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Penjadwalan extends CI_Controller {

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
		$this->load->model('ADMPelatihan/M_penjadwalan');
		$this->load->model('ADMPelatihan/M_record');
		$this->load->model('ADMPelatihan/M_penjadwalanpackage');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	//HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Penjadwalan Pelatihan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}
		
		$data['training'] = $this->M_penjadwalan->GetTraining();
		$data['ptctype'] = $this->M_penjadwalan->GetParticipantType();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Penjadwalan/V_Index',$data);
		$this->load->view('V_Footer',$data);	
	}
	
	//HALAMAN CREATE PENJADWALAN
	public function create($id, $alert = FALSE){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Penjadwalan Pelatihan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}
		
		$data['details'] = $this->M_penjadwalan->GetTrainingId($id);
		$data['purpose'] = $this->M_penjadwalan->GetObjectiveId($id);
		$data['room'] = $this->M_penjadwalan->GetRoom();
		$data['trainer'] = $this->M_penjadwalan->GetTrainer();
		$data['number'] = 1;
		$data['ptctype'] = $this->M_penjadwalan->GetParticipantType();
		$data['GetEvaluationType'] = $this->M_penjadwalan->GetEvaluationType();
		$data['alert'] = $alert;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Penjadwalan/V_Create',$data);
		$this->load->view('V_Footer',$data);	
	}

	

	//HALAMAN CREATE PENJADWALAN PAKET VERSI BARU
	// public function createbypackage($pse,$alert = FALSE){
	public function createbypackage($pse){
		$this->checkSession();
		$user_id 				= $this->session->userid;
		
		$data['Menu'] 			= 'Penjadwalan';
		$data['SubMenuOne'] 	= 'Penjadwalan Pelatihan';
		$data['SubMenuTwo'] 	= '';
		
		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne']	= $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo']	= $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}
		
		$data['number'] = 1;
		$data['pse'] 			= $pse;
		$data['packscheduling'] = $this->M_penjadwalan->GetPackageSchedulingId($pse);
		$package_id 			= $data['packscheduling'][0]['package_id'];
		$data['traininglist'] 	= $this->M_penjadwalan->GetTrainingList($package_id);
		$data['daynumber']		= $this->M_penjadwalan->GetDayNumber($package_id);
		$data['room'] 			= $this->M_penjadwalan->GetRoom();
		$data['trainer'] 		= $this->M_penjadwalan->GetTrainer();
		$data['GetEvaluationType'] = $this->M_penjadwalan->GetEvaluationType();
		$data['ptctype'] = $this->M_penjadwalan->GetParticipantType();
		// $data['alert'] = $alert;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Penjadwalan/V_CreatebyPackage',$data);
		$this->load->view('V_Footer',$data);	
	}

	//HALAMAN CREATE PENJADWALAN PAKET SINGLE
	// public function createbypackagesingle($pse,$ptr,$alert = FALSE){
	public function createbypackagesingle($pse,$ptr){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Penjadwalan Pelatihan';
		$data['SubMenuTwo'] = '';
		
		$data['number'] = 1;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}
		$data['ptctype'] = $this->M_penjadwalan->GetParticipantType();
		$data['pse'] = $pse;
		$data['details'] = $this->M_penjadwalan->GetTrainingIdMPE($ptr);
		$data['packscheduling'] = $this->M_penjadwalan->GetPackageSchedulingId($pse);
		$data['room'] = $this->M_penjadwalan->GetRoom();
		$data['trainer'] = $this->M_penjadwalan->GetTrainer();
		$data['GetEvaluationType'] = $this->M_penjadwalan->GetEvaluationType();
		// $data['alert'] = $alert;

		// Ambil status hari pertama sebagai start date 
		$data['GetStartDate'] = $this->M_penjadwalan->GetStartDate($pse);
	
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Penjadwalan/V_CreatebyPackageSingle',$data);
		$this->load->view('V_Footer',$data);	
	}

	//MENGAMBIL DAFTAR PEKERJA (BERHUBUNGAN DENGAN AJAX/JAVASCRIPT)
	public function GetTrainer(){
		$term = $this->input->get("term");
		$data = $this->M_penjadwalan->GetTrainer($term);
		$count = count($data);
		echo "[";
		foreach ($data as $data) {
			$count--;
			echo '{"NoInduk":"'.$data['noind'].'","Nama":"'.$data['trainer_name'].'","NoId":"'.$data['trainer_id'].'"}';
			if ($count !== 0) {
				echo ",";
			}
		}
		echo "]";
	}

	//MENGAMBIL DAFTAR TUJUAN PELATIHAN (BERHUBUNGAN DENGAN AJAX/JAVASCRIPT)
	public function GetObjective(){
		$term = $this->input->get("term");
		$data = $this->M_penjadwalan->GetObjective($term);
		echo json_encode($data);
	}

	//MENAMBAHKAN DATA PENJADWALAN YANG SUDAH DIBUAT KE DATABASE
	public function add(){		
		$package_scheduling_id	= 0;
		$package_training_id	= 0;
		$training_id			= $this->input->post('txtTrainingId');

		$scheduling_name		= $this->input->post('txtNamaPelatihan');

		$date					= $this->input->post('txtTanggalPelaksanaan');
		$start_time				= $this->input->post('txtWaktuMulai');
		$end_time				= $this->input->post('txtWaktuSelesai');
		$room 					= $this->input->post('slcRuang');
		
		$participant_type		= $this->input->post('slcPeserta');
		$participant_number		= $this->input->post('txtJumlahPeserta');
		$standar_nilai			= $this->input->post('txtStandarNilai');

		$evaluasi		= $this->input->post('slcEvaluasi');
		$evaluasi2 		= implode(',', $evaluasi);
		$sifat			= $this->input->post('slcSifat');
		$jenis			= $this->input->post('txtJenis');
		
		$GetAlert 		= $this->M_penjadwalan->GetAlert($date,$start_time,$end_time,$room,$training_id);
		$GetTrainerAlert= $this->M_penjadwalan->GetTrainer();
		$count 			= count($GetAlert);
		$alerttrainer	= explode(',', $GetAlert[0]['trainer']);
		$trainerName 	= array();

		if ($count == 0) {
		$trainer		= $this->input->post('slcTrainer');
		$trainers 		= implode(',', $trainer);

		$insertId 		= $this->M_penjadwalan->AddSchedule($package_scheduling_id,$package_training_id,$training_id,$scheduling_name,$date,$start_time,$end_time,$room,$participant_type,$participant_number,$evaluasi2,$sifat,$trainers,$jenis,$standar_nilai);

		$maxid			= $this->M_penjadwalan->GetMaxIdScheduling();
		$pkgid 			= $maxid[0]->scheduling_id;
		
		$objective		= $this->input->post('slcObjective');
			$i=0;
			foreach($objective as $loop){
				$data_objective[$i] = array(
					'training_id' 	=> $pkgid,
					'purpose' 		=> $objective[$i],
				);

		$pp		= $this->M_penjadwalan->pp($objective[$i]);
					// if( !empty($objective[$i]) )
				if( $pp[0]['count']==NULL or $pp[0]['count']==0 ){
					$this->M_penjadwalan->AddObjective($data_objective[$i]);
				}
				$i++;
			}


		$participant	= $this->input->post('slcEmployee');
			
			$j=0;
			foreach($participant as $loop){
				$dataemployee	= $this->M_penjadwalan->GetEmployeeData($loop);
					foreach ($dataemployee as $de) {
						$noind		= $de['noind'];
						$name		= $de['nama'];
					}
				$data_participant[$j] = array(
					'scheduling_id' 	=> $pkgid,
					'participant_name' 	=> $name,
					'noind' 			=> $noind,
					'status'			=> '0',
				);
				if( !empty($participant[$j]) ){
					$this->M_penjadwalan->AddParticipant($data_participant[$j]);
				}
				$j++;
			}
		redirect('ADMPelatihan/Record');
		}else{
			$alert = '<div class="row">
		 					<div class="col-md-10 col-md-offset-1 col-sm-12">
		 						<div id="alertJadwal" class="modal fade bs-example-modal-lg modal-danger" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		 							 <div class="modal-dialog modal-lg" role="document">
		 							 <div class="modal-content">
		 							 <div class="modal-body">
		 							Hari dan Ruangan sudah dijadwalkan untuk Training ';
		 							$alert .= $GetAlert[0]['training_name'];
		 							foreach ($alerttrainer as $at) {
		 								foreach ($GetTrainerAlert as $gta) {
		 									if ($at == $gta['trainer_id']) {
		 										$trainerName[] = $gta['trainer_name'];
		 									}
		 								}
		 							}
		 							if (!empty($trainerName)) {
		 								$cetakTrain = implode(', ', $trainerName);
		 								$alert .= ' dengan trainer '.$cetakTrain;
		 							}
		 							$alert .= '!
		 							 </div>
		 							 </div>
		 						   </div>
			 					</div>
			 				</div>
            	        </div>
            	        <script type="text/javascript">
							$("#alertJadwal").modal("show");
						</script>';
			$this->create($training_id, $alert);
		}
		
	}

	//MENAMBAHKAN DATA PENJADWALAN YANG SUDAH DIBUAT KE DATABASE
	public function addbypackage()
	{

		$package_scheduling_id	= $this->input->post('txtPackageSchedulingId');
		$package_training_id	= $this->input->post('txtPackageTrainingId');
		$training_id			= $this->input->post('txtTrainingId');

		$scheduling_name		= $this->input->post('txtNamaPelatihan');
		$standar_kelulusan		= $this->input->post('txtStandarNilai');
		$date 					= $this->input->post('txtTanggalPelaksanaan');
		$room					= $this->input->post('slcRuang');
		$sifat					= $this->input->post('slcSifat');
		$jenis					= $this->input->post('txtjenis');

		$participant			= $this->input->post('slcEmployee');
		$participant_type		= $this->input->post('txtPeserta');
		$participant_number		= $this->input->post('txtJumlahPeserta');

		// // ALERT----------------------------------------------------------------------------------------------------------------------------
		// $GetAlertPackage = array();
		// for ($m=0; $m < count($training_id); $m++) { 
		// 	$GetAlertPackage[]= $this->M_penjadwalan->GetAlertPackage($date[$m],$room[$m],$training_id[$m]);
		// }
		
		
		// $dataAlert = 0;
		// for ($n=0; $n < count($training_id); $n++) { 
		// 	if (!empty($GetAlertPackage[$n])) {
		// 		$dataAlert++;
		// 	}
		// }
		
		// $GetTrainerAlert= $this->M_penjadwalan->GetTrainerPackage();

		// $AlertVal=array();
		// foreach ($GetAlertPackage as $key => $value) {
		// 	if (!empty($GetAlertPackage[$key])) {
		// 		foreach ($value as $v) {
		// 			if (!in_array($v,$AlertVal)) {
		// 				array_push($AlertVal, $v);
		// 			}
		// 		}
		// 	}
		// }		

		// if ($dataAlert == 0) {
		$i=0;
		$x=1;
		$chk = array();
		foreach($scheduling_name as $loop){
			//VARIABEL UNTUK NUMBERING
			$arr=$i+1;
			//NUMBERING
			$trainers			= $this->input->post('slcTrainer'.$arr);
			
			$chk[$i]			= $this->input->post('chk'.$x++);
			$chkim[$i] 			= implode(',', $chk[$i]);

			//ARRAY YANG AKAN DI INPUT
			$data_schedule[$i] = array(
				'package_scheduling_id'	=> $package_scheduling_id,
				'package_training_id'	=> $package_training_id[$i],
				'training_id'			=> $training_id[$i],
				'scheduling_name'		=> $scheduling_name[$i],
				'standar_kelulusan'		=> $standar_kelulusan[$i],
				'date'					=> $date[$i],
				'room'					=> $room[$i],
				'participant_type'		=> $participant_type,
				'trainer'				=> implode(',', $trainers),
				'participant_number'	=> $participant_number,
				'evaluation'			=> $chkim[$i],
				'sifat'					=> $sifat,
				'training_type'			=> $jenis
			);
			// ALERT------------------------------------------------------------------------------------------------------------

			//INPUT KE TABEL SCHEDULING PACKAGE
			$this->M_penjadwalan->AddMultiSchedule($data_schedule[$i]);
			
			//AMBIL ID DARI SCHEDULING PACKAGE YANG BARUSAN DI INPUT
			$maxid			= $this->M_penjadwalan->GetMaxIdScheduling();
			$pkgid 			= $maxid[0]->scheduling_id;
			
			// //INPUT PARTICIPANT
				$j=0;
				foreach($participant as $loop){
					$dataemployee	= $this->M_penjadwalan->GetEmployeeData($loop);
					foreach ($dataemployee as $de) {
						$noind		= $de['noind'];
						$name		= $de['nama'];
					}
					$data_participant[$j] = array(
						'scheduling_id' 	=> $pkgid,
						'participant_name' 	=> $name,
						'noind' 			=> $noind,
						'status'			=> '0',
					);
					if( !empty($participant[$j]) ){
						$this->M_penjadwalan->AddParticipant($data_participant[$j]);
					}
					$j++;
				}
			$i++;
		}

		//AMBIL TANGGAL TERBESAR DAN TERKECIL
		$first			= $this->M_penjadwalan->GetPackageStartDate($package_scheduling_id);
		$last			= $this->M_penjadwalan->GetPackageEndDate($package_scheduling_id);
		$startdate		= $first[0]->date;
		$enddate		= $last[0]->date;
		//UPDATE PENJADWALAN PACKAGE
		$this->M_penjadwalan->UpdatePackageScheduling($participant_number,$startdate,$enddate,$package_scheduling_id);



		redirect('ADMPelatihan/PenjadwalanPackage/Schedule/'.$package_scheduling_id);
		// }else{
		// 	$nomor = 1;
		// 	$alert = '<div class="row">
		//  					<div class="col-md-10 col-md-offset-1 col-sm-12">
		//  						<div id="alertJadwal" class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		//  							 <div class="modal-dialog modal-lg" role="document">
		//  							 <div class="modal-content">
		//  							 <div class="modal-header">
		//  							 	<h2 style="color: red" >Tanggal dan Ruangan sudah dijadwalkan untuk:</h2>
		//  							 </div>
		//  							 <div class="modal-body">
		// 								<table class="table table-stripped table-hover">
		// 									<thead>
		// 										<td>No</td>
		// 										<td>Tanggal</td>
		// 										<td>Trainer</td>
		// 										<td>Ruangan</td>
		// 										<td>Training</td>
		// 									</thead>
		// 									<tbody>';
		// 										foreach ($AlertVal as $av) {
		// 										$alert .= 
		// 										'<tr>
		// 											<td>'.$nomor++.'</td>
		// 											<td>'.$av['date'].'</td>
		// 											<td>';
		// 												$trainerRow = explode(',', $av['trainer']);
		// 												foreach ($GetTrainerAlert as $ta) {
		// 													foreach ($trainerRow as $tr) {
		// 														if ($tr == $ta['trainer_id']) {
		// 															$alert .= $ta['trainer_name'];
		// 														}
		// 													}
		// 												}
		// 											$alert .= '</td>
		// 											<td>'.$av['room'].'</td>
		// 											<td>'.$av['training_name'].'</td>
		// 										</tr>';
		// 										}
		// 									$alert .= 
		// 									'</tbody>
		// 								</table>
		// 								<hr>
		// 								<h6><i>*Data tersebut muncul berdasarkan "hari keberapa". Apabila dalam satu hari ada lebih dari 1 pelatihan, maka akan muncul semua pelatihan dalam hari tersebut.</i></h6>
		//  							 </div>
		//  							 </div>
		//  						   </div>
		// 	 					</div>
		// 	 				</div>
  //           	        </div>
  //           	        <script type="text/javascript">
		// 					$("#alertJadwal").modal("show");
		// 				</script>';
		$this->createbypackage($package_scheduling_id, $alert);
		// }
	}

	//MENAMBAHKAN DATA PENJADWALAN YANG SUDAH DIBUAT KE DATABASE
	public function addbypackageSingle(){
		
		$package_scheduling_id	= $this->input->post('txtPackageSchedulingId');
		$package_training_id	= $this->input->post('txtPackageTrainingId');
		$training_id			= $this->input->post('txtTrainingId');
		
		$scheduling_name		= $this->input->post('txtNamaPelatihan');
		$standar_kelulusan		= $this->input->post('txtStandarNilai');

		$date 					= $this->input->post('txtTanggalPelaksanaan');
		$room					= $this->input->post('slcRuang');
		$startdate 				= $this->input->post('txtStartDate');
		
		$participant			= $this->input->post('slcEmployee');
		$participant_type		= $this->input->post('txtPeserta');
		$participant_number		= $this->input->post('txtJumlahPeserta');
		$evaluasi				= $this->input->post('slcEvaluasi');
		$evaluasi2 				= implode(',', $evaluasi);
		$sifat					= $this->input->post('slcSifat');
		$jenis					= $this->input->post('txtStartDate');

		// $GetAlertPackage= $this->M_penjadwalan->GetAlertPackage($date,$room,$training_id);
		// $GetTrainerAlert= $this->M_penjadwalan->GetTrainer();
		// $count 			= count($GetAlertPackage);
		// $alerttrainer	= explode(',', $GetAlertPackage[0]['trainer']);
		// $trainerName 	= array();

		// if ($count == 0) {
		$trainer		= $this->input->post('slcTrainer');
		$trainers 		= implode(',', $trainer);
		

		// isi start date paket		
		if ($startdate==0) {
			$this->M_penjadwalan->UpdateStartDate($date,$package_scheduling_id);
		}
		// Add penjadwalan
		$this->M_penjadwalan->AddSingleSchedule($package_scheduling_id,$package_training_id,$training_id,$scheduling_name,$date,$room,$participant_type,$participant_number,$evaluasi2,$trainers,$sifat,$jenis,$standar_kelulusan);
		
		$maxid			= $this->M_penjadwalan->GetMaxIdScheduling();
		$pkgid 			= $maxid[0]->scheduling_id;

		$j=0;
				foreach($participant as $loop){
					$dataemployee	= $this->M_penjadwalan->GetEmployeeData($loop);
					foreach ($dataemployee as $de) {
						$noind		= $de['noind'];
						$name		= $de['nama'];
					}
					$data_participant[$j] = array(
						'scheduling_id' 	=> $pkgid,
						'participant_name' 	=> $name,
						'noind' 			=> $noind,
						'status'			=> '0',
					);
					if( !empty($participant[$j]) ){
						$this->M_penjadwalan->AddParticipant($data_participant[$j]);
					}
					$j++;
				}			
		redirect('ADMPelatihan/PenjadwalanPackage/Schedule/'.$package_scheduling_id);
		// }
		// else{
		// 	$alert = '<div class="row">
		//  					<div class="col-md-10 col-md-offset-1 col-sm-12">
		//  						<div id="alertJadwal" class="modal fade bs-example-modal-lg modal-danger" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		//  							 <div class="modal-dialog modal-lg" role="document">
		//  							 <div class="modal-content">
		//  							 <div class="modal-body">
		//  							Hari dan Ruangan sudah dijadwalkan untuk Training ';
		//  							$alert .= $GetAlertPackage[0]['training_name'];
		//  							foreach ($alerttrainer as $at) {
		//  								foreach ($GetTrainerAlert as $gta) {
		//  									if ($at == $gta['trainer_id']) {
		//  										$trainerName[] = $gta['trainer_name'];
		//  									}
		//  								}
		//  							}
		//  							if (!empty($trainerName)) {
		//  								$cetakTrain = implode(', ', $trainerName);
		//  								$alert .= ' dengan trainer '.$cetakTrain;
		//  							}
		//  							$alert .= '!
		//  							 </div>
		//  							 </div>
		//  						   </div>
		// 	 					</div>
		// 	 				</div>
  //           	        </div>
  //           	        <script type="text/javascript">
		// 					$("#alertJadwal").modal("show");
		// 				</script>';
		// 	echo "<pre>";
		// 	print_r($alert);
		// 	echo "</pre>";
		// 	exit();
		// 	// $this->create($training_id, $alert);
		// }
	}

	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
}
