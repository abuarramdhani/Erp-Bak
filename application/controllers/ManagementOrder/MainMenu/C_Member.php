<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Member extends CI_Controller {
	
	function __construct()
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
		$this->load->model('ManagementOrder/M_order_in');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
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
		
		$data['Menu'] = 'Member';
		$data['SubMenuOne'] = 'Member';
		$data['SubMenuTwo'] = '';
		$data['action'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['staff']   = $this->M_order_in->staff();
		$data['count']   = $this->M_order_in->countPlotting();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManagementOrder/MainMenu/V_Member', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function getMember(){
		$getMember = $this->M_order_in->staff();
		echo json_encode($getMember);
	}
	
	public function AjaxPlotting($member){
		
		$data = $this->M_order_in->listJob($member);
		$output = array();
		$a=1;
		$i=0;
		
		foreach($data as $k => $value) {
			$output[] = array_values($value);
			$ticket   = $output[$i][0];
			$id		  = $output[$i][1];
			$priority =  $output[$i][3];
			$comment =  $output[$i][4];
			$duedate =  $output[$i][5];
			if(!$comment){
				$class_date = "";
				$readonly = "readonly";
			}else{
				$class_date = "duedate";
				$readonly = "";
			}
			if(empty($priority)){
				$link = "<div id='field_priority".$i."'><input type='number' class='form-control' maxlength='2'  onkeyup='savePriority(\"".$i."\",\"".site_url()."\",\"".$ticket."\")' name='txtPriority' style='width:60px;' id='txtPriority".$i."'></div>";
			}else{
				$link = "<div id='field_priority".$i."'><input type='number' class='form-control' maxlength='2'  onkeyup='savePriority(\"".$i."\",\"".site_url()."\",\"".$ticket."\")' name='txtPriority' style='width:60px;' id='txtPriority".$i."' value='".$output[$i][3]."'></div>";
			}
			$duedate = "<div id='duedate".$a."'><input type='text' class='form-control $class_date' name='txtDueDate' id='txtDueDate".$a."' style='width:90px;' data-id='".$ticket."' value='".$duedate."' $readonly></input></div>";	
			$act = "<a href='http://ictsupport.quick.com/ticket/upload/scp/tickets.php?id=".$id."' target='blank_'><b>".$ticket."</b></a>";
			$todo = "<div id='field_todo".$a."' data-tip='".$comment."'><input type='text' name='txtToDo' id='txtToDo".$a."' value='".$comment."' class='form-control field-todo bg-danger' style='width:100%' data-id='".$ticket."'></input></div>";	
			$sentto = " <a data-toggle='modal' id='showModal' href='#' data-id='".$ticket."'><i class='fa fa-share fa-2x' style='color:orange;text-align:center;'></i></a>";	
			array_pop($output[$i]);
			array_unshift($output[$i], "$act");
			array_unshift($output[$i], "$a");
			array_splice($output[$i], 2, 2);
			array_splice($output[$i], 3, 1);
			array_splice($output[$i], 3, 3);
			array_push($output[$i], "$link");
			array_push($output[$i], "$todo");
			array_push($output[$i], "$duedate");
			if($this->session->userdata('prev')=='fullver_sion'){
				array_push($output[$i], "$sentto");
			}
			$a++;
			$i++;
		}
		echo json_encode(array('data' => $output));
	}
	
}
