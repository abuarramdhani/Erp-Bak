<?php
class M_scheduler extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				
        }
		
		function getTicket($q){
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
						AND ktc.subject like '%$q%'
					ORDER BY 
						kt.created ASC";
			$query = $ticket->query($sql);
			return $query->result_array();
		}
		
		function getClassificationProject(){
			$sql = "select * from mo.mo_classification_group order by classification_group_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
}