<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_launchpickrelease extends CI_Model
{    
    public function __construct()
    {
        parent::__construct();
        
		$this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function getSOList()
    {
        $sql = "SELECT distinct wdd.SOURCE_HEADER_NUMBER
                from wsh_delivery_details wdd,
                    wsh_delivery_assignments wda
                where wdd.DELIVERY_DETAIL_ID = wda.DELIVERY_DETAIL_ID
                and wdd.BATCH_ID is null
                and wda.DELIVERY_ID is not null
                and wdd.ORG_ID = 82";
        
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function launchReleaseDO($delivery_id)
    {
        $this->oracle->query("BEGIN APPS.KHS_LAUNCH_PICK_RELEASE($delivery_id); END;");
    }

}