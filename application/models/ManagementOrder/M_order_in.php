<?php
class M_order_in extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				
        }
		
		
		/*
			LIST STATUS
			7 => HOLDED
			3 => CANCEL
			2 => FINISH
			1 => OPEN
			
		*/
		 public function order_holded()
		{
		  $ticket = $this->load->database('ticket',true);
          $sql = "SELECT 
						kt.ticket_id, kt.number,ktc.subject
					FROM 
						khs_ticket kt,
						khs_ticket__cdata ktc 
					WHERE 
						kt.dept_id='9' 
						AND kt.ticket_id=ktc.ticket_id
						AND kt.status_id='7'
					ORDER BY 
						kt.created ASC";
          $query = $ticket->query($sql);
          return $query->result_array();
		}
		
		public function order_emergency()
		{
			$ticket = $this->load->database('ticket',true);
          $sql = "SELECT 
						kt.ticket_id, kt.number,ktc.subject
					FROM 
						khs_ticket kt,
						khs_ticket__cdata ktc 
					WHERE 
						kt.dept_id='9' 
						AND kt.ticket_id=ktc.ticket_id
						AND kt.status_id='1'
						AND kt.duedate >= NOW()
						AND ktc.priority='4'
					ORDER BY 
						kt.created ASC";
          $query = $ticket->query($sql);
          return $query->result_array();
		}
		
		 public function order_overdue()
		{
			$ticket = $this->load->database('ticket',true);
          $sql = "SELECT 
						kt.ticket_id, kt.number,ktc.subject
					FROM 
						khs_ticket kt,
						khs_ticket__cdata ktc 
					WHERE 
						kt.dept_id='9' 
						AND kt.ticket_id=ktc.ticket_id
						AND kt.status_id='1'
						AND kt.isoverdue='1'
					ORDER BY 
						kt.created ASC";
          $query = $ticket->query($sql);
          return $query->result_array();
		}
		
		public function order_unanswered()
		{
			$ticket = $this->load->database('ticket',true);
          $sql = "SELECT 
						kt.ticket_id, kt.number,ktc.subject
					FROM 
						khs_ticket kt,
						khs_ticket__cdata ktc 
					WHERE 
						kt.dept_id='9' 
						AND kt.ticket_id=ktc.ticket_id
						AND kt.status_id='1'
						AND kt.isoverdue='0'
						AND ktc.priority!='4'
						AND kt.isanswered='0'
						AND (kt.isneedrespon='1' OR kt.isneedrespon IS NULL)
					ORDER BY 
						kt.created ASC";
          $query = $ticket->query($sql);
          return $query->result_array();
		}
		
		public function order_wip()
		{
			$ticket = $this->load->database('ticket',true);
          $sql = "SELECT 
						kt.ticket_id, kt.number,ktc.subject
					FROM 
						khs_ticket kt,
						khs_ticket__cdata ktc 
					WHERE 
						kt.dept_id='9' 
						AND kt.ticket_id=ktc.ticket_id
						AND kt.status_id='1'
						AND kt.isoverdue='0'
						AND ktc.priority!='4'
						AND (kt.isneedrespon=kt.isanswered OR (kt.isanswered='1' AND (kt.isneedrespon IS NULL OR kt.isneedrespon='0')))
					ORDER BY 
						kt.created ASC";
          $query = $ticket->query($sql);
          return $query->result_array();
		}
		
		public function countplotting(){
			
			$sql	   = "SELECT COUNT(*) tot,user_ FROM mo.mo_manage_order where active='1' GROUP BY user_";
			$query     = $this->db->query($sql);
			return $query->result_array();
		}

		public function staff()
		{
		  $ticket = $this->load->database('ticket',true);
          $sql = "SELECT ks.staff_id,ks.firstname,
				(SELECT COUNT(*) FROM khs_ticket kt WHERE kt.dept_id=ks.dept_id AND kt.status_id='2' AND kt.staff_id=ks.staff_id) AS finish
				FROM khs_staff ks WHERE ks.dept_id='9' AND ks.staff_id!='46' AND ks.staff_id!='48' order by finish desc";
          $query = $ticket->query($sql);
          return $query->result_array();
		}
		
		public function getNoTick($ticket){
			$ticket = $this->load->database('ticket',true);
			$sql = "SELECT kt.ticket_id FROM khs_ticket kt WHERE kt.number='$ticket'";
			$query = $ticket->query($sql);
			return $query->result_array();
		}
		
		public function saveClaim($member,$ticket,$subject,$name,$notik,$date,$agent,$active){
			
			$sql	   = "insert into mo.mo_manage_order(id_ticket,number,subject_,user_,name_,date_execute,agent,active) values ('$ticket','$notik','$subject','$member','$name','$date','$agent','$active')";
			$query     = $this->db->query($sql);
			return ;
		}
		
		public function checkPlot($ticket){
			
			$sql	   = "select * from mo.mo_manage_order where id_ticket='$ticket'";
			$query     = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function updateClaim($member,$ticket,$subject,$name,$notik,$date,$agent,$active){
			
			$sql	   = "update mo.mo_manage_order set user_='$member',number='$notik',name_='$name',subject_='$subject',date_execute='$date',active='$active', agent='$agent' where id_ticket='$ticket'";
			$query     = $this->db->query($sql);
			return;
		}
		
		public function plotting($num){
			
			$sql	   = "select * from mo.mo_manage_order where id_ticket='$num'";
			$query     = $this->db->query($sql);
			return $query->row();
		}
		
		public function removePlotting($ticket){
			
			$sql	   = "delete from mo.mo_manage_order where id_ticket='$ticket'";
			$query     = $this->db->query($sql);
			return;
		}
		
		public function getName($member){
			$ticket = $this->load->database('ticket',true);
			$sql = "SELECT ks.firstname FROM khs_staff ks WHERE ks.dept_id='9' and ks.staff_id='$member'";
			$query = $ticket->query($sql);
			return $query->row();
		}
		
		public function saveTodo($todo,$ticket,$date){
			
			$sql	   = "insert into mo.mo_todo (id_ticket,todo,datetime_) values ('$ticket','$todo','$date')";
			$query     = $this->db->query($sql);
			return ;
		}
		
		public function todo($num){
			$sql	   = "SELECT id_ticket,duedate,todo FROM mo.mo_todo WHERE id_ticket='$num' ORDER BY id DESC LIMIT 1 ";
			$query     = $this->db->query($sql);
			return $query->row();
		}
		
		public function updateJob($ticket){
			
			$sql	   = "update mo.mo_manage_order set active='0' where id_ticket='$ticket'";
			$query     = $this->db->query($sql);
			return;
		}
		
		public function listJob($member){
			
			$sql	   = "SELECT pj.id_ticket,pj.number,pj.subject_,pj.priority,
								(SELECT t.todo FROM mo.mo_todo t WHERE t.id_ticket=pj.id_ticket ORDER BY datetime_ DESC LIMIT 1 ) AS todo,
								(SELECT t.duedate FROM mo.mo_todo t WHERE t.id_ticket=pj.id_ticket ORDER BY datetime_ DESC LIMIT 1 ) AS duedate
							FROM mo.mo_manage_order pj 
							WHERE pj.user_='$member' AND pj.active='1' ORDER BY pj.priority,pj.id_plot ASC";
			$query     = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function existTicket($ticket){
			$ticket = $this->load->database('ticket',true);
			$sql	   = "select * from ticket1.khs_ticket where number='$ticket' and status_id in ('2','3') ";
			$query     = $ticket->query($sql);
			return $query->result_array();
		}
		
		public function descJob($member){
			$ticket = $this->load->database('ticket',true);
			$sql = "SELECT 
							kt.ticket_id, kt.number,kt.duedate,kt.created,kt.createdBy,ktc.subject
						FROM 
							khs_ticket kt,
							khs_ticket__cdata ktc 
						WHERE 
							kt.dept_id='9' 
							AND kt.closed IS NULL
							AND kt.ticket_id=ktc.ticket_id
						ORDER BY 
							kt.created ASC";
			$query = $ticket->query($sql);
			return $query->result_array();
		}
		
		public function qtyJob($member){
			$sql	   = "select count(*) as qty from mo.mo_manage_order where user_='$member' and active='1'";
			$query     = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function setPriority($prior,$ticket){
			
			$sql	   = "update mo.mo_manage_order set case when '$prior'='' then priority=null else priority='$prior' end where id_ticket='$ticket'";
			$query     = $this->db->query($sql);
			return;
		}
		
		public function changePlotting($id,$member,$ticket,$name){
			
			$sql	   = "update mo.mo_manage_order set user_='$member', name_='$name' where id_ticket='$ticket'";
			$query     = $this->db->query($sql);
			return;
		}
		
		public function checkTodo($ticket){
			$sql	   = "select * from mo.mo_todo where id_ticket='$ticket'";
			$query     = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function updateDuedate($ticket,$duedate,$date){
			$sql	   = "with updated as (
							UPDATE mo.mo_todo 
								SET datetime_='$date',duedate=(CASE
																		WHEN '$duedate' = '1970-01-01' THEN NULL
																		ELSE '$duedate'
																	  end)
							WHERE id_ticket='$ticket'
							RETURNING *
						)
						select *
						from updated
						ORDER BY id DESC LIMIT 1";
			$query     = $this->db->query($sql);
			return;
		}
		
		public function insertDuedate($ticket,$duedate,$date){
			$sql	   = "INSERT INTO mo.mo_todo (id_ticket,duedate,datetime_) VALUES ('$ticket','$duedate','$date')";
			$query     = $this->db->query($sql);
			return;
		}
		
		public function alertDueDate(){
			$sql	   = "select * from mo.mo_todo where now()>=to_timestamp(datetime_, 'YYYY-MM-DD HH:MI:SS')";
			$query     = $this->db->query($sql);
			return $query->result_array();
		}
		
		function selectTags(){
			$sql	   = "select * from mo.mo_tags";
			$query     = $this->db->query($sql);
			return $query->result_array();
		}
		
		function checkTags($singleTags,$ticket){
			$sql	   = "select * from mo.mo_tags_list where tags_id='$singleTags' and ticket_number='$ticket'";
			$query     = $this->db->query($sql);
			return $query->row();
		}
		
		function tagslist($num){
			$sql	   = "select * from mo.mo_tags_list where ticket_number='$num'";
			$query     = $this->db->query($sql);
			return $query->result_array();
		}
		
		function saveTags($tags,$ticket,$date,$user){
			$sql = "insert into mo.mo_tags_list (tags_id,ticket_number,creation_date,created_by) values ('$tags','$ticket','$date','$user')";
			$query = $this->db->query($sql);
			return;
		}
		
		function count_tags($id){
			$sql	   = "select count(*) as hasil from mo.mo_tags_list where ticket_number='$id'";
			$query     = $this->db->query($sql);
			return $query->row();
		}
		
		function deleteTags($singleTags,$ticket){
			$sql	   = "delete from mo.mo_tags_list where tags_id='$singleTags' and ticket_number='$ticket'";
			$query     = $this->db->query($sql);
			return;
		}
		
		function deleteTagsticket($ticket){
			$sql	   = "delete from mo.mo_tags_list where ticket_number='$ticket'";
			$query     = $this->db->query($sql);
			return;
		}
		
		function sync_ticket(){
			$ticket = $this->load->database('ticket',true);
			$sql = "SELECT kt.ticket_id,kt.number,kt.staff_id,kt.status_id,ktc.priority,ktc.subject,ks.firstname 
					FROM ticket1.khs_ticket kt 
					INNER JOIN ticket1.khs_ticket__cdata ktc ON kt.ticket_id=ktc.ticket_id
					LEFT JOIN ticket1.khs_staff ks ON kt.staff_id=ks.staff_id 
					WHERE kt.dept_id='9' AND kt.status_id='1' and kt.staff_id <> 0";
			$query = $ticket->query($sql);
			return $query->result_array();
		}
		
		function check_local($user,$ticket){
			$sql = "select *
				from mo.mo_manage_order tb1
				where tb1.id_ticket='$ticket' and tb1.user_='$user' and active='1'";
			$query = $this->db->query($sql);
			return $query->row();
		}
		
		function sync_local($user,$ticket,$name){
			$sql = "update mo.mo_manage_order set user_='$user',name_='$name' where id_ticket='$ticket'";
			$query = $this->db->query($sql);
			return;
		}
		
		function checkTicket($ticket){
			$sql = "select *
				from mo.mo_manage_order tb1
				where tb1.id_ticket='$ticket' and active='1'";
			$query = $this->db->query($sql);
			return $query->row();
		}
		
		function checkResponse($id){
			$ticket = $this->load->database('ticket',true);
			$sql = "SELECT isanswered FROM ticket1.khs_ticket WHERE dept_id='9' AND status_id='1' AND number='$id'";
			$query = $ticket->query($sql);
			return $query->row();
		}
		
		function updateTicketServer($id,$member){
			$ticket = $this->load->database('ticket',true);
			$sql = "update ticket1.khs_ticket set staff_id='$member' where number='$id' and staff_id<>0";
			$query = $ticket->query($sql);
			return;
		}
		
}