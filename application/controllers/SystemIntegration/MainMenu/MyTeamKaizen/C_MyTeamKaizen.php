<?php defined('BASEPATH')OR die('No direct script access allowed');
class C_MyTeamKaizen extends CI_Controller
{
	
	function __construct()
		{
			parent::__construct();
			date_default_timezone_set('Asia/Jakarta');
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	          //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('SystemIntegration/M_myteamkaizen');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}

		}

	public function checkSession()
		{
				if ($this->session->is_logged) {
				}else{
					redirect();
				}
		}

	public function index()
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$user_code = $this->session->user;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


			$data['kaizen'] = $this->M_myteamkaizen->getKaizenTeam($user_code, FALSE);
			$data['kaizen_unchecked'] = $this->M_myteamkaizen->getKaizenTeam($user_code, 2);
			$data['kaizen_approved_ide'] = $this->M_myteamkaizen->getKaizenTeam($user_code, 3);
			$data['kaizen_approved'] = $this->M_myteamkaizen->getKaizenTeam($user_code, 9);
			$data['kaizen_revised'] = $this->M_myteamkaizen->getKaizenTeam($user_code, 4);
			$data['kaizen_rejected'] = $this->M_myteamkaizen->getKaizenTeam($user_code, 5);

			//all
			// $i = 0; foreach ($data['kaizen'] as $key => $value) {
				// $a = 0; for ($x=1; $x < 4; $x++) { 
				// $getApprovalLvl = $this->M_myteamkaizen->getApprover($value['kaizen_id'], $x);
				// $data['kaizen'][$i]['status_app'][$a]['level'.$x] = $getApprovalLvl ? $getApprovalLvl[0]['status'] : 0;
				// $data['kaizen'][$i]['status_app'][$a]['staff'.$x] = $getApprovalLvl ? $getApprovalLvl[0]['employee_name'] : '';
				// $data['kaizen'][$i]['status_app'][$a]['staff_code'.$x] = $getApprovalLvl ? $getApprovalLvl[0]['employee_code'] :'' ;
				// $data['kaizen'][$i]['status_app'][$a]['reason'.$x] = $getApprovalLvl ? $getApprovalLvl[0]['reason'] :'';
				// 	$a++;
				// }
				// $i++;
			// 	$getAllApprover = $this->M_mykaizen->getApprover($value['kaizen_id'],FALSE);
			// 	$a = 0; foreach ($getAllApprover as $key => $value) {
			// 		if ($value['level'] != 6):
			// 		$data['kaizen'][$i]['status_app'][$a]['level']=$value['level'];
			// 		$data['kaizen'][$i]['status_app'][$a]['status']=$value['status'];
			// 		$data['kaizen'][$i]['status_app'][$a]['staff']=$value['employee_name'];
			// 		$data['kaizen'][$i]['status_app'][$a]['staff_code']=$value['employee_code'];
			// 		$data['kaizen'][$i]['status_app'][$a]['reason']=$value['reason'];
			// 		endif;
			// 		$a++;
			// 	}
			// 	$i++;
			// }
			// // unchecked
			// $i = 0; foreach ($data['kaizen_unchecked'] as $key => $value) {
			// 	$getAllApprover = $this->M_mykaizen->getApprover($value['kaizen_id'],FALSE);
			// 	$a = 0; foreach ($getAllApprover as $key => $value) {
			// 		if ($value['level'] != 6):
			// 		$data['kaizen_unchecked'][$i]['status_app'][$a]['level']=$value['level'];
			// 		$data['kaizen_unchecked'][$i]['status_app'][$a]['status']=$value['status'];
			// 		$data['kaizen_unchecked'][$i]['status_app'][$a]['staff']=$value['employee_name'];
			// 		$data['kaizen_unchecked'][$i]['status_app'][$a]['staff_code']=$value['employee_code'];
			// 		$data['kaizen_unchecked'][$i]['status_app'][$a]['reason']=$value['reason'];
			// 		endif;
			// 		$a++;
			// 	}
			// 	$i++;
			// }

			// //approved_ide
			// $i = 0; foreach ($data['kaizen_approved_ide'] as $key => $value) {
			// 	$getAllApprover = $this->M_mykaizen->getApprover($value['kaizen_id'],FALSE);
			// 	$a = 0; foreach ($getAllApprover as $key => $value) {
			// 		if ($value['level'] != 6):
			// 		$data['kaizen_approved_ide'][$i]['status_app'][$a]['level']=$value['level'];
			// 		$data['kaizen_approved_ide'][$i]['status_app'][$a]['status']=$value['status'];
			// 		$data['kaizen_approved_ide'][$i]['status_app'][$a]['staff']=$value['employee_name'];
			// 		$data['kaizen_approved_ide'][$i]['status_app'][$a]['staff_code']=$value['employee_code'];
			// 		$data['kaizen_approved_ide'][$i]['status_app'][$a]['reason']=$value['reason'];
			// 		endif;
			// 		$a++;
			// 	}
			// 	$i++;
			// }

			
			// //approved
			// $i = 0; foreach ($data['kaizen_approved'] as $key => $value) {
			// 	$getAllApprover = $this->M_mykaizen->getApprover($value['kaizen_id'],FALSE);
			// 	$a = 0; foreach ($getAllApprover as $key => $value) {
			// 		if ($value['level'] != 6):
			// 		$data['kaizen_approved'][$i]['status_app'][$a]['level']=$value['level'];
			// 		$data['kaizen_approved'][$i]['status_app'][$a]['status']=$value['status'];
			// 		$data['kaizen_approved'][$i]['status_app'][$a]['staff']=$value['employee_name'];
			// 		$data['kaizen_approved'][$i]['status_app'][$a]['staff_code']=$value['employee_code'];
			// 		$data['kaizen_approved'][$i]['status_app'][$a]['reason']=$value['reason'];
			// 		endif;
			// 		$a++;
			// 	}
			// 	$i++;
			// }


			// //revised
			// $i = 0; foreach ($data['kaizen_revised'] as $key => $value) {
			// 	$getAllApprover = $this->M_mykaizen->getApprover($value['kaizen_id'],FALSE);
			// 	$a = 0; foreach ($getAllApprover as $key => $value) {
			// 		if ($value['level'] != 6):
			// 		$data['kaizen_revised'][$i]['status_app'][$a]['level']=$value['level'];
			// 		$data['kaizen_revised'][$i]['status_app'][$a]['status']=$value['status'];
			// 		$data['kaizen_revised'][$i]['status_app'][$a]['staff']=$value['employee_name'];
			// 		$data['kaizen_revised'][$i]['status_app'][$a]['staff_code']=$value['employee_code'];
			// 		$data['kaizen_revised'][$i]['status_app'][$a]['reason']=$value['reason'];
			// 		endif;
			// 		$a++;
			// 	}
			// 	$i++;
			// }

			// //rejected
			// $i = 0; foreach ($data['kaizen_rejected'] as $key => $value) {
			// 	$getAllApprover = $this->M_mykaizen->getApprover($value['kaizen_id'],FALSE);
			// 	$a = 0; foreach ($getAllApprover as $key => $value) {
			// 		if ($value['level'] != 6):
			// 		$data['kaizen_rejected'][$i]['status_app'][$a]['level']=$value['level'];
			// 		$data['kaizen_rejected'][$i]['status_app'][$a]['status']=$value['status'];
			// 		$data['kaizen_rejected'][$i]['status_app'][$a]['staff']=$value['employee_name'];
			// 		$data['kaizen_rejected'][$i]['status_app'][$a]['staff_code']=$value['employee_code'];
			// 		$data['kaizen_rejected'][$i]['status_app'][$a]['reason']=$value['reason'];
			// 		endif;
			// 		$a++;
			// 	}
			// 	$i++;
			// }
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SystemIntegration/MainMenu/MyTeamKaizen/V_Index',$data);
			$this->load->view('V_Footer',$data);


		}
}