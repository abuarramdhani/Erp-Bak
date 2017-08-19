<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Plotting extends CI_Controller {
   function __construct() 
   {
        parent::__construct();
		$this->load->model('M_plotting');
    }
	
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userdata('username');
		$user['user_id'] = $user_id;
		 
		$this->load->view('template/V_Header');
		$this->load->view('template/V_Menu',$user);
		$this->load->view('MainMenu/V_Plotting');
		$this->load->view('template/V_Footer');
	}
	
	public function getMember(){
		$getMember = $this->M_plotting->staff();
		echo json_encode($getMember);
	}
	
	public function saveClaim(){
		$member = $this->input->post('member',true);
		$ticket = str_replace(" ","",$this->input->post('ticket',true));
		$subject = $this->input->post('subject',true);
		$date = date("Y-m-d H:i:s");
		$agent = $this->session->userdata('username');
		$getTick = $this->M_plotting->getNoTick($ticket);
		$active= '1';
		foreach($getTick as $tc){
			$notik = $tc['ticket_id'];
		}
		
		$getName = $this->M_plotting->getName($member);
		$name	 = $getName->firstname;
		$check   = $this->M_plotting->checkPlot($ticket);
		if($check){
			$save = $this->M_plotting->updateClaim($member,$ticket,$subject,$name,$notik,$date,$agent,$active);
			echo $member;
		}else{
			$save = $this->M_plotting->saveClaim($member,$ticket,$subject,$name,$notik,$date,$agent,$active);
			echo $member;
		}
	}
	
	public function removePlotting(){
		$ticket = $this->input->post('ticket');
		$this->M_plotting->removePlotting($ticket);
		echo "success";
	}
	
	public function saveTodo(){
		$todo = $this->input->post('todo',true);
		$ticket = $this->input->post('ticket',true);
		$date = date("Y-m-d H:i:s");
		$save = $this->M_plotting->saveTodo($todo,$ticket,$date);
		echo "success";
	}
	
	public function checkSession(){
		if($this->session->userdata('is_logged')){
		}else{
			redirect();
		}
	}
	
	public function member(){
		$this->checkSession();
		$user_id = $this->session->userdata('username');
		$data['user_id'] = $user_id;
		$data['staff']   = $this->M_plotting->staff();
		$data['count']   = $this->M_plotting->countPlotting();
		$this->load->view('template/V_Header');
		$this->load->view('template/V_Menu',$data);
		$this->load->view('MainMenu/V_Member');
		$this->load->view('template/V_Footer');
	}
	
	public function getPlotting(){
		$member = $this->input->post('member',true);
		$listJob	= $this->M_plotting->listJob($member);
		$descJob	= $this->M_plotting->descJob($member);
		$i = 0;
		foreach($listJob as $row){
			foreach($descJob as $rw){
			if($row['id_ticket'] == $rw['number']){
				$i++;
				echo "<tr>";
					echo "<td align='center'>".$i."</td>";
					echo "<td align='center'>".$row['id_ticket']."</td>";
					echo "<td align='center'>".$rw['subject']."</td>";
				echo "</tr>";
				}
			}
		}
	}
	
	public function ExistTicket($id){
		$data = $this->M_plotting->listJob($id);
		foreach($data as $dt){
				$ticket = $dt['id_ticket'];
				$check = $this->M_plotting->existTicket($ticket);
					if($check){
						$this->M_plotting->updateJob($ticket);
					}
		}
	}
	
	public function AjaxPlotting($member){
		
		$data = $this->M_plotting->listJob($member);
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
	
	public function setPriority(){
		$prior = $this->input->post('prior',true);
		$ticket = $this->input->post('ticket',true);
		$save = $this->M_plotting->setPriority($prior,$ticket);
		echo "Priority has been Set .. !!";
	}
	
	public function CountJob(){
		$member = $this->input->post('member');
		$row_data = $this->M_plotting->qtyJob($member);
		if(empty($row_data)){
			echo "0";
		}else{
			foreach($row_data as $rd){
				$count = $rd['qty'];
			}
			echo $count;
		}
	}
	
	public function changePlotting(){
		$id = $this->input->post('id');
		$member = $this->input->post('member');
		$ticket = $this->input->post('ticket');
		$getName = $this->M_plotting->getName($member);
		$name	 = $getName->firstname;
		$save = $this->M_plotting->changePlotting($id,$member,$ticket,$name);
		echo "success";
	}
	
	public function duedateTodo(){
		$ticket = $this->input->post('ticket');
		$duedate = $this->input->post('duedate');
		$duedate = date("Y-m-d",strtotime($duedate));
		$date = date("Y-m-d H:i:s");
		$checkTodo = $this->M_plotting->checkTodo($ticket);
			if($checkTodo){
				$this->M_plotting->updateDuedate($ticket,$duedate,$date);
			}else{
				$this->M_plotting->insertDuedate($ticket,$duedate,$date);
			}
		echo "success";
	}
	
	public function PlottingTable($tab){
		switch ($tab) {
			case "1":
				$data = $this->M_plotting->order_emergency();
				break;
			case "2":
				$data = $this->M_plotting->order_overdue();
				break;
			case "3":
				$data = $this->M_plotting->order_unanswered();
				break;
			case "4":
				$data = $this->M_plotting->order_wip();
				break;
			case "5":
				$data = $this->M_plotting->order_holded();
				break;
		}
		
		$output = array();
		$a=1;
		$i=0;
		$member = "";
		$comment = "";
		foreach($data as $k => $value) {
			$output[] = array_values($value);
			$tick = $output[$i][0];
			$num = $output[$i][1];
			$subject = $output[$i][2];
			$t = 0;
			$todo	 = $this->M_plotting->todo($num);
				if(!empty($todo)){
					$comment = $todo->todo;
					$duedate = $todo->duedate;
					if($comment == ''){
						$class_date = "";
						$readonly = "readonly";
					}else{
						$class_date = "duedate";
						$readonly = "";
					}
				}else{
					$comment = "";
					$duedate = "";
					$readonly = "readonly";
					$class_date = "";
				}
			$plot = $this->M_plotting->plotting($num);
				if(!empty($plot)){
					$name = $plot->name_;
				}else{
					$name = "";
				}
			if($this->session->userdata('prev')=='fullver_sion'){
			$select = "<div id='plotting".$a."'>
						<select name='txsClaim' id='txsClaim".$tab."".$a."' class='form-control field-save' style='width:100%' data-id='".$subject."' data-id-index='".$num."'>
							<option value=''>[ ".$name." ]</option>
							<option value='33'>Gilardi</option>
							<option value='18'>Paulus</option>
							<option value='19'>Alfian</option>
							<option value='49'>Junawi</option>
							<option value='50'>R</option>
							<option value='53'>Rezaldi</option>
							<option value='60'>Brian</option>
							<option value='62'>Godeliva</option>
							<option value='65'>Adnan</option>
						</select>
						</div>";
			}else{
				$select = "<div id='plotting".$a."'><input class='form-control' style='width:100%;' value='".$name."' data-id='".$num."' readonly></input></div>";
			}
			$duedate = "<div id='duedate".$a."'><input type='text' class='form-control $class_date' name='txtDueDate' id='txtDueDate".$a."' data-id='".$num."' value='".$duedate."' $readonly></input></div>";
			$todo = "<div id='field_todo".$a."'><input type='text' name='txtToDo' id='txtToDo".$a."' value='".$comment."' class='form-control field-todo' data-tip='".$comment."' style='width:100%' data-id='".$num."'></input></div>";
			$link = " <a href='http://ictsupport.quick.com/ticket/upload/scp/tickets.php?id=".$tick."' target='blank_'><b>".$num."</b></a>";
			$delete = "<button type='button' class='close field-remove ' style='color:black' data-id='".$num."'>&times;</button>";
			
			array_shift($output[$i]);
			array_unshift($output[$i], "$link");
			array_splice($output[$i], 1, 1);
			array_push($output[$i], "$select");
			array_push($output[$i], "$todo");
			array_push($output[$i], "$duedate");
			if($this->session->userdata('prev')=='fullver_sion'){
				array_push($output[$i], "$delete");
			}
			array_unshift($output[$i], "$a");
			$a++;
			$i++;
		}
		echo json_encode(array('data' => $output));
	}
}
