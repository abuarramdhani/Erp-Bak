<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_usermng extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle', true);
    }
    
    public function getUserMjp($term){
        $oracle = $this->load->database('personalia',true);
        $sql = " SELECT distinct noind, nama
            FROM hrd_khs.tpribadi 
            where noind like '%$term%'
            or nama like '%$term%'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function getUser($term){
        $sql = "select * from khs_user_item_monitoring $term";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function saveUser($jenis, $user){
        $sql = "insert into khs_user_item_monitoring (jenis, no_induk)
        values('$jenis', '$user')";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }

    public function updateUser($jenis, $user){
        $sql = "update khs_user_item_monitoring set jenis = '$jenis'
                where no_induk = '$user'";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }
    
    public function deleteUser($jenis, $user){
        $sql = "delete from khs_user_item_monitoring 
                where no_induk = '$user' and jenis = '$jenis'";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }


}