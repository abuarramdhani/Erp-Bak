<?php
class M_salesmonitoring extends CI_Model {

        public function __construct()
        {
            $this->load->database();
			$this->load->library('encrypt');
        }
		
}
?>