<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_khususImport extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    // public function someFunction()
    // {
    //     $oracle = $this->load->database('oracle', true);
    //     $sql = "";
    //     $query = $oracle->query($sql);
    //     return $query->result_array();
    // }

}
