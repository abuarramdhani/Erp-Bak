<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_minmax extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function insertData($item, $min, $max, $uom){
        $oracle = $this->load->database('oracle', true);
        $sql = "insert into khs_sp_minmax (item, min, max, uom, last_update, last_update_by)
                values ('$item', '$min', '$max', '$uom', sysdate, 225)";
        $query = $oracle->query($sql);
        $query = $oracle->query('commit');
    }

    public function getdata(){
        $oracle = $this->load->database('oracle', true);
        $sql = "select * from khs_sp_minmax";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function cekimport($item){
        $oracle = $this->load->database('oracle', true);
        $sql = "select * from khs_sp_minmax where item = '$item'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    
    public function updateData($item, $min, $max){
        $oracle = $this->load->database('oracle', true);
        $sql = "update khs_sp_minmax set min = '$min', max = '$max' where item = '$item'";
        $query = $oracle->query($sql);
        $query = $oracle->query('commit');
    }

}