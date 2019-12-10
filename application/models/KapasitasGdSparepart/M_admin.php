<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_admin extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function tampilhariini($date) {
        $oracle = $this->load->database('oracle', true);
        $sql = "select JUMLAH_SPB, WAKTU_ALLOCATE, ID,
                to_char(MULAI_ALLOCATE, 'hh24:mi:ss') as MULAI_ALLOCATE,
                to_char(SELESAI_ALLOCATE, 'hh24:mi:ss') as SELESAI_ALLOCATE
                from khs_tampung_admin_spb
                where TO_CHAR(MULAI_ALLOCATE,'DD/MM/YYYY') between '$date' and '$date'
                order by MULAI_ALLOCATE";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function insertAdmin($date, $id) {
        $oracle = $this->load->database('oracle', true);
        $sql = "insert into khs_tampung_admin_spb (MULAI_ALLOCATE, ID)
                VALUES (TO_TIMESTAMP('$date', 'DD-MM-YYYY HH24:MI:SS'), '$id')";
        $query = $oracle->query($sql);
        $query2 = $oracle->query('commit');
        // echo $sql;
    }

    public function updateAdmin($date, $jml_spb, $id, $waktu){
        $oracle = $this->load->database('oracle', true);
        $sql="update khs_tampung_admin_spb set selesai_allocate = TO_TIMESTAMP('$date', 'DD-MM-YYYY HH24:MI:SS'), jumlah_spb = '$jml_spb', waktu_allocate = '$waktu'
                where id = '$id'";
        $query = $oracle->query($sql);      
        $query2 = $oracle->query('commit');             
        // echo $sql; 
    }

    // public function saveWaktu($waktu, $id){
    //     $oracle = $this->load->database('oracle', true);
    //     $sql="update khs_tampung_admin_spb set waktu_allocate = '$waktu'
    //             where id = '$id'";
    //     $query = $oracle->query($sql);      
    //     $query2 = $oracle->query('commit');             
    //     // echo $sql; 
    // }
}