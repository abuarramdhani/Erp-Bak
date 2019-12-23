<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pengeluaran extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function tampilhariini() {
        $oracle = $this->load->database('oracle', true);
        $sql = "select to_char(jam_input, 'DD/MM/YYYY HH24:MM:SS') as jam_input,
                tgl_dibuat, to_char(mulai_pengeluaran, 'HH24:MI:SS') as mulai_pengeluaran,  pic_pengeluaran,
                jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs, selesai_pengeluaran,
                selesai_pelayanan, urgent
                from khs_tampung_spb
                where selesai_pelayanan is not null
                and selesai_pengeluaran is null
                order by urgent, tgl_dibuat";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataPengeluaran($date) {
        $oracle = $this->load->database('oracle', true);
        $sql = "select to_char(jam_input, 'DD/MM/YYYY HH24:MI:SS') as jam_input, 
                tgl_dibuat,
                jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                to_char(mulai_pengeluaran, 'DD/MM/YYYY HH24:MI:SS') as mulai_pengeluaran, 
                to_char(mulai_pengeluaran, 'HH24:MI:SS') as jam_mulai, 
                to_char(selesai_pengeluaran, 'HH24:MI:SS') as jam_selesai,
                to_char(selesai_pengeluaran, 'DD/MM/YYYY HH24:MI:SS') as selesai_pengeluaran, 
                waktu_pengeluaran, urgent, pic_pengeluaran  
                from khs_tampung_spb
                where TO_CHAR(selesai_pengeluaran,'DD/MM/YYYY') between '$date' and '$date'
                order by urgent, tgl_dibuat";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function SavePengeluaran($date, $jenis, $nospb,$pic){
        $oracle = $this->load->database('oracle', true);
        $sql="update khs_tampung_spb set mulai_pengeluaran = TO_TIMESTAMP('$date', 'DD-MM-YYYY HH24:MI:SS'), pic_pengeluaran = '$pic'
                where jenis_dokumen = '$jenis' and no_dokumen = '$nospb'";
        $query = $oracle->query($sql);              
        $query2 = $oracle->query('commit');     
        // echo $sql; 
    }

    public function SelesaiPengeluaran($date, $jenis, $nospb, $wkt, $pic){
        $oracle = $this->load->database('oracle', true);
        $sql="update khs_tampung_spb set selesai_pengeluaran = TO_TIMESTAMP('$date', 'DD-MM-YYYY HH24:MI:SS'), waktu_pengeluaran = '$wkt', pic_pelayan = '$pic'
                where jenis_dokumen = '$jenis' and no_dokumen = '$nospb'";
        $query = $oracle->query($sql);             
        $query2 = $oracle->query('commit');      
        // echo $sql; 
    }

    public function saveWaktu($jenis, $nospb, $query){
        $oracle = $this->load->database('oracle', true);
        $sql="update khs_tampung_spb $query
                where jenis_dokumen = '$jenis' and no_dokumen = '$nospb'";
        $query = $oracle->query($sql);       
        $query2 = $oracle->query('commit');            
        // echo $sql; 
    }
}