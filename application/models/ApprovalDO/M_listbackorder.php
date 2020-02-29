<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_listbackorder extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        
		$this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function getListBackorder()
    {
        $sql = "SELECT DISTINCT
                    wdd.SOURCE_HEADER_NUMBER
                FROM
                    wsh_delivery_details wdd
                WHERE
                    wdd.ORG_ID = 82
                AND
                    wdd.RELEASED_STATUS = 'B'
                --and wdd.SOURCE_HEADER_NUMBER = 1120010000014
                ORDER BY
                    SOURCE_HEADER_NUMBER";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
}