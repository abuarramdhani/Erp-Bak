<?php
class M_kaizen extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				
        }
		
		function selectMember(){
			$ticket = $this->load->database('ticket',true);
			$sql = "SELECT ks.firstname FROM ticket1.khs_staff ks WHERE ks.dept_id='9'";
			$query = $ticket->query($sql);
			return $query->result_array();
		}
		
		function selectKaizen(){
			$kaizen = $this->load->database('kaizen',true);
			$sql = "select * from kaizen.kaizen";
			$query = $kaizen->query($sql);
			return $query->result_array();
		}
}