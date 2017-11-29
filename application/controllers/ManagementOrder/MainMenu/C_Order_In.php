<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Order_In extends CI_Controller {
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
	
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Order In';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['action'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['staff']   = $this->M_order_in->staff();
		$data['count']   = $this->M_order_in->countPlotting();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManagementOrder/MainMenu/V_Order_In', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function getMember(){
		$getMember = $this->M_order_in->staff();
		echo json_encode($getMember);
	}
	
	public function saveClaim(){
		$member = $this->input->post('member',true);
		$ticket = str_replace(" ","",$this->input->post('ticket',true));
		$subject = $this->input->post('subject',true);
		$date = date("Y-m-d H:i:s");
		$agent = $this->session->userdata('username');
		$getTick = $this->M_order_in->getNoTick($ticket);
		$active= '1';
		foreach($getTick as $tc){
			$notik = $tc['ticket_id'];
		}
		
		$getName = $this->M_order_in->getName($member);
		$name	 = $getName->firstname;
		$check   = $this->M_order_in->checkPlot($ticket);
		if($check){
			$save = $this->M_order_in->updateClaim($member,$ticket,$subject,$name,$notik,$date,$agent,$active);
			echo $member;
		}else{
			$save = $this->M_order_in->saveClaim($member,$ticket,$subject,$name,$notik,$date,$agent,$active);
			echo $member;
		}
	}
	
	public function removePlotting(){
		$ticket = $this->input->post('ticket');
		$this->M_order_in->removePlotting($ticket);
		echo "success";
	}
	
	public function saveTodo(){
		$todo = $this->input->post('todo',true);
		$ticket = $this->input->post('ticket',true);
		$date = date("Y-m-d H:i:s");
		$save = $this->M_order_in->saveTodo($todo,$ticket,$date);
		echo "success";
	}
	
	public function saveTags(){
		$user = $this->session->userid;
		$tags = $this->input->post('tags',true);
		$ticket = $this->input->post('ticket',true);
		$date = date("Y-m-d H:i:s");
		$singleTags = end($tags);
		$check = $this->M_order_in->checkTags($singleTags,$ticket);
		if(empty($check)){
			$save = $this->M_order_in->saveTags($singleTags,$ticket,$date,$user);
		}
		echo "success";
	}
	
	public function deleteTags(){
		$tags = $this->input->post('tags',true);
		$ticket = $this->input->post('ticket',true);
		$singleTags = end($tags);
		if($tags == null){
			$delete = $this->M_order_in->deleteTagsTicket($ticket);
		}else{
			$delete = $this->M_order_in->deleteTags($singleTags,$ticket);
		}
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
		$data['staff']   = $this->M_order_in->staff();
		$data['count']   = $this->M_order_in->countPlotting();
		$this->load->view('template/V_Header');
		$this->load->view('template/V_Menu',$data);
		$this->load->view('MainMenu/V_Member');
		$this->load->view('template/V_Footer');
	}
	
	public function getPlotting(){
		$member = $this->input->post('member',true);
		$listJob	= $this->M_order_in->listJob($member);
		$descJob	= $this->M_order_in->descJob($member);
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
	
	public function ExistTicket(){
		$data = $this->M_order_in->listJob_all();
		foreach($data as $dt){
				$ticket = $dt['id_ticket'];
				$check = $this->M_order_in->existTicket($ticket);
					if($check){
						$this->M_order_in->updateJob($ticket);
					}
		}
	}
	
	
	public function setPriority(){
		$prior = $this->input->post('prior',true);
		$ticket = $this->input->post('ticket',true);
		$save = $this->M_order_in->setPriority($prior,$ticket);
		echo "Priority has been Set .. !!";
	}
	
	public function CountJob(){
		$member = $this->input->post('member');
		$row_data = $this->M_order_in->qtyJob($member);
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
		$getName = $this->M_order_in->getName($member);
		$name	 = $getName->firstname;
		$save = $this->M_order_in->changePlotting($id,$member,$ticket,$name);
		$checkTicket = $this->M_order_in->updateTicketServer($ticket,$member);
		echo "success";
	}
	
	public function duedateTodo(){
		$ticket = $this->input->post('ticket');
		$duedate = $this->input->post('duedate');
		$duedate = date("Y-m-d",strtotime($duedate));
		$date = date("Y-m-d H:i:s");
		$checkTodo = $this->M_order_in->checkTodo($ticket);
			if($checkTodo){
				$this->M_order_in->updateDuedate($ticket,$duedate,$date);
			}else{
				$this->M_order_in->insertDuedate($ticket,$duedate,$date);
			}
		echo "success";
	}
	
	public function PlottingTable($tab){
		switch ($tab) {
			case "1":
				$data = $this->M_order_in->order_emergency();
				break;
			case "2":
				$data = $this->M_order_in->order_overdue();
				break;
			case "3":
				$data = $this->M_order_in->order_unanswered();
				break;
			case "4":
				$data = $this->M_order_in->order_wip();
				break;
			case "5":
				$data = $this->M_order_in->order_holded();
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
			$todo	 = $this->M_order_in->todo($num);
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
			$plot = $this->M_order_in->plotting($num);
				if(!empty($plot)){
					$name = $plot->name_;
				}else{
					$name = "";
				}
			$staff = $this->M_order_in->staff();
			$tagslist = $this->M_order_in->tagslist($num);
			$selectTags = $this->M_order_in->selectTags();
			$select = "<div id='plotting".$a."'>
						<select name='txsClaim' id='txsClaim".$tab."".$a."' class='form-control field-save' style='width:100%' data-id='".$subject."' data-id-index='".$num."'>
							<option value=''>[ ".$name." ]</option>";
							foreach($staff as $staff_item){
								$select .= "<option value='".$staff_item['staff_id']."'>".$staff_item['firstname']."</option>";
							}
						$select .= "</select>
						</div>";
			$tags = "<div id='field_tags".$a."'>
						<select name='txtTags' id='txtTags".$tab."".$a."' multiple='multiple' class='form-control field-tags select-tags' style='width:170px;font-size:13px;' data-id='".$subject."' data-id-index='".$num."' >
						";
							foreach($selectTags as $selectTags_item){
									$tags .= "<option value='".$selectTags_item['id']."'";
									foreach($tagslist as $tagslist_item){
										if($tagslist_item['tags_id']==$selectTags_item['id']){
											$tags .= "selected";
										}else{
											$tags .= "";
										}
									}
									$tags .= ">".$selectTags_item['tags']."</option>";
							}
						$tags .= "</select>
					</div>";
			$duedate = "<div id='duedate".$a."'><input type='text' class='form-control $class_date' name='txtDueDate' id='txtDueDate".$a."' data-id='".$num."' data-date-format='yyyy-mm-dd' style='width:100px;' value='".$duedate."' $readonly></input></div>";
			$todo = "<div id='field_todo".$a."'><input type='text' name='txtToDo' id='txtToDo".$a."' value='".$comment."' class='form-control field-todo' data-tip='".$comment."' style='width:100%' data-id='".$num."'></input></div>";
			$link = " <a href='http://ictsupport.quick.com/ticket/upload/scp/tickets.php?id=".$tick."' target='blank_'><b>".$num."</b></a>";
			$delete = "<button type='button' class='close field-remove ' style='color:black' data-id='".$num."'>&times;</button>";
			
			array_shift($output[$i]);
			array_unshift($output[$i], "$link");
			array_splice($output[$i], 1, 1);
			array_push($output[$i], "$select");
			array_push($output[$i], "$tags");
			array_push($output[$i], "$todo");
			array_push($output[$i], "$duedate");
				array_push($output[$i], "$delete");
			array_unshift($output[$i], "$a");
			$a++;
			$i++;
		}
		echo json_encode(array('data' => $output));
	}
	
	function CountTags(){
		$id = $this->input->post('ticket',true);
		$count = $this->M_order_in->count_tags($id);
		echo $count->hasil;
	}
	
	function SyncTicket(){
		$getTick = $this->M_order_in->sync_ticket();
		$no=0;
		$active = 1;
		$date = date("Y-m-d H:i:s");
		$agent = $this->session->userdata('username');
		foreach($getTick as $getTick_item){
			$no++;
			$checkTicket = $this->M_order_in->checkTicket($getTick_item['number']);
			if(empty($checkTicket)){
			$saveTicket = $this->M_order_in->saveClaim($getTick_item['staff_id'],$getTick_item['number'],$getTick_item['subject'],$getTick_item['firstname'],$getTick_item['ticket_id'],$date,$agent,$active);
			}else{
				$checkUser = $this->M_order_in->check_local($getTick_item['staff_id'],$getTick_item['number']);
					if(empty($checkUser)){
						$changeTicket = $this->M_order_in->sync_local($getTick_item['staff_id'],$getTick_item['number'],$getTick_item['firstname']);
					}else{
					}
			}
		}
	}
}
