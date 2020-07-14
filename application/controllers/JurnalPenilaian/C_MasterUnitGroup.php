<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterUnitGroup extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->library('General');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('JurnalPenilaian/M_unitgroup');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}

		date_default_timezone_set('Asia/Jakarta');
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}

	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Distribution';
		$data['SubMenuOne'] = 'Master Unit Group';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['namaUnitGroup'] 		= 	$this->M_unitgroup->ambilNamaUnitGroup();
		$data['seksiUnitGroup'] 	= 	$this->M_unitgroup->ambilSeksiUnitGroup();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterDistribution/MasterUserGroup/V_Index',$data);
		$this->load->view('V_Footer',$data);	
	}

	public function modification()
	{
		$namaUnitGroup 		= 	$this->input->post('txtnamaUnitGroup');
		$seksiUnitGroup 	= 	$this->input->post('cmbseksiUnitGroup');
		$idUnitGroup 		= 	$this->input->post('idUnitGroup');

		$jumlahNamaUnitGroup	= 	count($namaUnitGroup);
		$jumlahIDUnitGroup 		= 	count($idUnitGroup);



		for ($i=0; $i < $jumlahNamaUnitGroup; $i++) 
		{ 
			$namaUnitGroup[$i] 	= 	filter_var(strtoupper($namaUnitGroup[$i]), FILTER_SANITIZE_STRING);
		}


		for($j = 0; $j < $jumlahNamaUnitGroup; $j++)
		{
			if($idUnitGroup[$j]=='-')
			{
				// Jika value ID Unit Group adalah '-', maka unit group tersebut merupakan data baru. (CREATE)
				$dataNamaUnitGroup 	= 	array(
											'unit_group' 			=> 	$namaUnitGroup[$j],
											'creation_timestamp'		=>	$this->general->ambilWaktuEksekusi(),
											'last_action_timestamp'	=>	$this->general->ambilWaktuEksekusi()
										);
				$idDBUnitGroup 		= 	$this->M_unitgroup->tambahNamaUnitGroup($dataNamaUnitGroup);

				$jumlahSeksiUnitGroup 	= 	count($seksiUnitGroup[$j]);
				for($k = 0; $k < $jumlahSeksiUnitGroup; $k++)
				{
					$Seksi 	= 	explode(' = ', $seksiUnitGroup[$j][$k]);

					$kodesie 	= 	$Seksi[0];
					$namaSeksi 	= 	$Seksi[1];

					$dataSeksiUnitGroup 	= 	array(
													'id_unit_group' 		=> 	$idDBUnitGroup,
													'kodesie' 				=>	$kodesie,
													'seksi' 				=>	$namaSeksi,
													'creation_timestamp'		=>	$this->general->ambilWaktuEksekusi(),
													'last_action_timestamp'	=>	$this->general->ambilWaktuEksekusi()													
												);
					$idSeksiDBUnitGroup 	= 	$this->M_unitgroup->tambahSeksiUnitGroup($dataSeksiUnitGroup);
				}
			}
			else
			{
				// Jika value ID Unit Group bukan '-', maka unit group tersebut merupakan data baru. (UPDATE)
				$dataNamaUnitGroup 	= 	array(
											'unit_group'			=>	$namaUnitGroup[$j],
											'last_action_timestamp'	=>	$this->general->ambilWaktuEksekusi()
										);
				$this->M_unitgroup->updateNamaUnitGroup($dataNamaUnitGroup, $idUnitGroup[$j]);
				$idDBUnitGroup 		=	$idUnitGroup[$j];

				$jumlahSeksiUnitGroup 	= 	count($seksiUnitGroup[$j]);
				$kodesie 	=	'';
				for($m = 0; $m < $jumlahSeksiUnitGroup; $m++)
				{
					$Seksi 		= 	explode(' = ', $seksiUnitGroup[$j][$m]);
					$kodesie	.= 	"'".$Seksi[0]."'";

					if($m<($jumlahSeksiUnitGroup-1))
					{
						$kodesie 	.= ', ';
					}

				}
				$this->M_unitgroup->hapusSeksiUnitGroup($idDBUnitGroup, $kodesie);

				for($m = 0; $m < $jumlahSeksiUnitGroup; $m++)
				{
					$Seksi 		= 	explode(' = ', $seksiUnitGroup[$j][$m]);

					$statusSeksiUnitGroup 	= 	$this->M_unitgroup->checkExistDataUnitGroup($Seksi[0], $idDBUnitGroup);
					if($statusSeksiUnitGroup==0)
					{
						$kodesie 	=	$Seksi[0];
						$namaSeksi	=	$Seksi[1];
						$dataSeksiUnitGroup 	= 	array(
														'id_unit_group'			=>	$idDBUnitGroup,
														'kodesie'				=>	$kodesie,
														'seksi'					=>	$namaSeksi,
														'creation_timestamp'		=>	$this->general->ambilWaktuEksekusi()														
													);
						$this->M_unitgroup->tambahSeksiUnitGroup($dataSeksiUnitGroup, $idDBUnitGroup);
					}
				}

			}
			echo '<br/>';
		}
		redirect('PenilaianKinerja/MasterUnitGroup');

	}

	public function delete()
	{	
		$idUnitGroup 		=	$this->input->post('txtDeleteIDUnitGroup');
		$dataDeleted 		=	$this->M_unitgroup->ambilDataUnitGroupDeleted($idUnitGroup);

		foreach ($dataDeleted as $deleted) 
		{
			$dataHistory 		=	array(
										'id_unit_group'			=> 	$deleted['id_unit_group'],
										'unit_group'			=>	$deleted['unit_group'],
										'last_action_timestamp'	=>	$deleted['last_action_timestamp'],
										'creation_timestamp'		=>	$deleted['creation_timestamp'],
										'deletion_timestamp'		=>	date('Y-m-d H:i:s')
									);
			$this->M_unitgroup->inputDataUnitGroupDeletedkeHistory($dataHistory);
		}

		$dataDeleted 		=	$this->M_unitgroup->ambilDataUnitGroupListDeleted($idUnitGroup);

		foreach ($dataDeleted as $deleted) 
		{
			$dataHistory 		=	array(
										'id_unit_group_list'	=>	$deleted['id_unit_group_list'],
										'id_unit_group'			=> 	$deleted['id_unit_group'],
										'kodesie'				=>	$deleted['kodesie'],
										'seksi'					=>	$deleted['seksi'],
										'last_action_timestamp'	=>	$deleted['last_action_timestamp'],
										'creation_timestamp'		=>	$deleted['creation_timestamp'],
										'deletion_timestamp'		=>	date('Y-m-d H:i:s')
									);
			$this->M_unitgroup->inputDataUnitGroupListDeletedkeHistory($dataHistory);
		}
		$this->M_unitgroup->deleteUnitGroup($idUnitGroup);
		redirect('PenilaianKinerja/MasterUnitGroup');
	}	
}
