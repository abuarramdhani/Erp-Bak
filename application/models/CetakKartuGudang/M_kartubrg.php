<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_kartubrg extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle',true);
    }

    public function getdesc($komponen){
        $sql = "select msib.DESCRIPTION 
                from mtl_system_items_b msib
                where msib.SEGMENT1 = '$komponen'
                and msib.ORGANIZATION_ID = 81";
        $query = $this->oracle->query($sql);                             
        return $query->result_array();
    }
 
}
