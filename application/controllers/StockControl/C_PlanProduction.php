<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_PlanProduction extends CI_Controller {

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

		$this->load->model('StockControl/M_plan_production');
		  
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
		$data['Title'] = 'List Plan';
		$data['Menu'] = 'Plan Production';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['plan_production'] = $this->M_plan_production->plan_list();
		$data['alert'] = $this->session->flashdata('alert');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StockControl/PlanProduction/V_PlanProduction',$data);
		$this->load->view('V_Footer',$data);
	}

	public function insert($plan_date = NULL,$qty_plan = NULL,$error = NULL)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'New Plan';
		$data['Menu'] = 'Plan Production';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['plan_date'] = $plan_date;
		$data['qty_plan'] = $qty_plan;
		$data['alert'] = $error;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StockControl/PlanProduction/V_NewPlanProduction',$data);
		$this->load->view('V_Footer',$data);
	}

	public function save()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit Plan';
		$data['Menu'] = 'Plan Production';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plan_date = $this->input->post('txt_plan_date');
		$qty_plan = $this->input->post('txt_qty_plan');

		$ex_plan_date = explode(' ', $plan_date);
		$plan_date = $ex_plan_date[0].' 00:00:00';
		
		$check_plan_date = $this->M_plan_production->check_date($plan_date);

		$alert = '
			<div class="alert alert-success flyover flyover-top">
				<button type="button" class="close" data-dismiss="alert"><b style="color: #fff;">&times;</b></button>
				Data Insert Successfully
			</div>

			<script type="text/javascript">
				$(document).ready(function(){
					$(".flyover-top").addClass("in");
					setTimeout(function(){
						$(".flyover-top").removeClass("in");
					}, 3000);
				});
			</script>
		';

		if ($check_plan_date == '0') {
			$insert = $this->M_plan_production->insert($plan_date,$qty_plan);
			$this->session->set_flashdata('alert', $alert);
			redirect('StockControl/plan-production');
		}
		else{
			$alert = '
				<div class="alert alert-danger flyover flyover-top">
					<button type="button" class="close" data-dismiss="alert"><b style="color: #fff;">&times;</b></button>
					Plan Date Already Exist
				</div>

				<script type="text/javascript">
					$(document).ready(function(){
						$(".flyover-top").addClass("in");
						setTimeout(function(){
							$(".flyover-top").removeClass("in");
						}, 3000);
					});
				</script>
			';
			$this->insert($plan_date,$qty_plan,$alert);
		}

	}

	public function edit($plan_id,$error = NULL)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit Plan';
		$data['Menu'] = 'Plan Production';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['plan_production'] = $this->M_plan_production->plan_list($plan_id);
		$data['alert'] = $error;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StockControl/PlanProduction/V_EditPlanProduction',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update($plan_id,$plan_date)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit Plan';
		$data['Menu'] = 'Plan Production';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plan_date = str_replace('_', ' ', $plan_date);
		$new_plan_date = $this->input->post('txt_plan_date');
		$qty_plan = $this->input->post('txt_qty_plan');

		$ex_plan_date = explode(' ', $plan_date);
		$plan_date = $ex_plan_date[0].' 00:00:00';

		$check_plan_date = $this->M_plan_production->check_date($new_plan_date);

		$alert = '
			<div class="alert alert-success flyover flyover-top">
				<button type="button" class="close" data-dismiss="alert"><b style="color: #fff;">&times;</b></button>
				Data Update Successfully
			</div>

			<script type="text/javascript">
				$(document).ready(function(){
					$(".flyover-top").addClass("in");
					setTimeout(function(){
						$(".flyover-top").removeClass("in");
					}, 3000);
				});
			</script>
		';

		if ($check_plan_date == '0') {
			$update = $this->M_plan_production->update($plan_id,$new_plan_date,$qty_plan);
			$this->session->set_flashdata('alert', $alert);
			redirect('StockControl/plan-production');
		}
		else{
			if ($plan_date == $new_plan_date) {
				$update = $this->M_plan_production->update($plan_id,$new_plan_date,$qty_plan);
				$this->session->set_flashdata('alert', $alert);
				redirect('StockControl/plan-production');
			}
			else{
				$alert = '
					<div class="alert alert-danger flyover flyover-top">
						<button type="button" class="close" data-dismiss="alert"><b style="color: #fff;">&times;</b></button>
						Plan Date Already Exist
					</div>

					<script type="text/javascript">
						$(document).ready(function(){
							$(".flyover-top").addClass("in");
							setTimeout(function(){
								$(".flyover-top").removeClass("in");
							}, 3000);
						});
					</script>
				';
				$this->edit($plan_id,$alert);
			}
		}
	}

	public function delete($plan_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Delete Plan';
		$data['Menu'] = 'Plan Production';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->M_plan_production->delete($plan_id);
		$alert = '
			<div class="alert alert-success flyover flyover-top">
				<button type="button" class="close" data-dismiss="alert"><b style="color: #fff;">&times;</b></button>
				Data Delete Successfully
			</div>

			<script type="text/javascript">
				$(document).ready(function(){
					$(".flyover-top").addClass("in");
					setTimeout(function(){
						$(".flyover-top").removeClass("in");
					}, 3000);
				});
			</script>
		';

		$this->session->set_flashdata('alert', $alert);
		redirect('StockControl/plan-production');
	}
}
