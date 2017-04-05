<?php

CONTROLLER LOAD VIEW
	//HALAMAN CREATE PENJADWALAN PAKET
	public function createbypackage($pse,$ptr){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Penjadwalan Pelatihan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['pse'] = $pse;
		$data['details'] = $this->M_penjadwalan->GetTrainingIdMPE($ptr);
		$data['packscheduling'] = $this->M_penjadwalan->GetPackageSchedulingId($pse);
		$data['room'] = $this->M_penjadwalan->GetRoom();
		$data['trainer'] = $this->M_penjadwalan->GetTrainer();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Penjadwalan/V_CreatebyPackage',$data);
		$this->load->view('V_Footer',$data);	
	}

CONTROLLER ADD DATA
	//MENAMBAHKAN DATA PENJADWALAN YANG SUDAH DIBUAT KE DATABASE
	public function addbypackage(){
		$package_scheduling_id	= $this->input->post('txtPackageSchedulingId');
		$package_training_id	= $this->input->post('txtPackageTrainingId');
		$training_id			= $this->input->post('txtTrainingId');
		
		$scheduling_name		= $this->input->post('txtNamaPelatihan');

		$date 					= $this->input->post('txtTanggalPelaksanaan');
		$start_time				= $this->input->post('txtWaktuMulai');
		$end_time				= $this->input->post('txtWaktuSelesai');
		$room					= $this->input->post('slcRuang');
		
		$participant_type		= $this->input->post('txtPeserta');
		$participant_number		= $this->input->post('txtJumlahPeserta');
		
		$chk1			= $this->input->post('chk1');
		$chk2			= $this->input->post('chk2');
		$chk3			= $this->input->post('chk3');
		$evaluasi		= $chk1.$chk2.$chk3;
		
		$trainer		= $this->input->post('slcTrainer');
		$trainers 		= implode(',', $trainer);
		
		$this->M_penjadwalan->AddSchedule($package_scheduling_id,$package_training_id,$training_id,$scheduling_name,$date,$start_time,$end_time,$room,$participant_type,$participant_number,$evaluasi,$trainers);
		
		$maxid			= $this->M_penjadwalan->GetMaxIdScheduling();
		$pkgid 			= $maxid[0]->scheduling_id;
		
		$objective		= $this->input->post('slcObjective');
				
			$i=0;
			foreach($objective as $loop){
				$data_objective[$i] = array(
					'scheduling_id' 		=> $pkgid,
					'objective' 		=> $objective[$i],
				);
				if( !empty($objective[$i]) ){
					$this->M_penjadwalan->AddObjective($data_objective[$i]);
				}
				$i++;
			}

			if($participant_type==0){
				$participant	= $this->input->post('slcEmployee');$j=0;
				foreach($participant as $loop){
					$dataemployee	= $this->M_penjadwalan->GetEmployeeData($loop);
						foreach ($dataemployee as $de) {
							$noind		= $de['employee_code'];
							$name		= $de['employee_name'];
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
			}elseif($participant_type==1){
				$participant	= $this->input->post('slcApplicant');$j=0;
				foreach($participant as $loop){
					$dataemployee	= $this->M_penjadwalan->GetApplicantData($loop);
						foreach ($dataemployee as $de) {
							$noind		= $de['kodelamaran'];
							$name		= $de['nama'];
						}
					$data_participant[$j] = array(
						'scheduling_id' 	=> $pkgid,
						'participant_name' 	=> $name,
						'noapplicant'		=> $noind,
						'status'			=> '0',
					);
					if( !empty($participant[$j]) ){
						$this->M_penjadwalan->AddParticipant($data_participant[$j]);
					}
					$j++;
				}
			}
			
		redirect('ADMPelatihan/PenjadwalanPackage/Schedule/'.$package_scheduling_id);
	}

?>