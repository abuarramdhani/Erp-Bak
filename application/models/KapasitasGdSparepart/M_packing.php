<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_packing extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function tampilhariini() {
        $oracle = $this->load->database('oracle', true);
        $sql = "select to_char(jam_input, 'DD/MM/YYYY HH24:MI:SS') as jam_input, 
                tgl_dibuat, to_char(mulai_packing, 'HH24:MI:SS') as mulai_packing, pic_packing,
                jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs, selesai_packing,
                selesai_pengeluaran, urgent, waktu_packing, bon
                from khs_tampung_spb
                where selesai_pengeluaran is not null
                and selesai_packing is null
                and cancel is null
                and (bon != 'PENDING' or bon is null)
                order by urgent, tgl_dibuat";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataPacking($date) {
        $oracle = $this->load->database('oracle', true);
        $sql = "select to_char(jam_input, 'DD/MM/YYYY HH24:MI:SS') as jam_input, 
                tgl_dibuat,
                jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                to_char(mulai_packing, 'DD/MM/YYYY HH24:MI:SS') as mulai_packing, 
                to_char(mulai_packing, 'HH24:MI:SS') as jam_mulai, 
                to_char(selesai_packing, 'HH24:MI:SS') as jam_selesai,
                to_char(selesai_packing, 'DD/MM/YYYY HH24:MI:SS') as selesai_packing, 
                waktu_packing, urgent, pic_packing, bon
                from khs_tampung_spb
                where TO_CHAR(selesai_packing,'DD/MM/YYYY') between '$date' and '$date'
                and cancel is null
                order by urgent, tgl_dibuat";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function SavePacking($date, $jenis, $nospb, $pic){
        $oracle = $this->load->database('oracle', true);
        $sql="update khs_tampung_spb set mulai_packing = TO_TIMESTAMP('$date', 'DD-MM-YYYY HH24:MI:SS'), pic_packing = '$pic'
                where jenis_dokumen = '$jenis' and no_dokumen = '$nospb'";
        $query = $oracle->query($sql);      
        $query2 = $oracle->query('commit');             
        // echo $sql; 
    }

    public function SelesaiPacking($date, $jenis, $nospb, $wkt, $pic){
        $oracle = $this->load->database('oracle', true);
        $sql="update khs_tampung_spb set selesai_packing = TO_TIMESTAMP('$date', 'DD-MM-YYYY HH24:MI:SS'), waktu_packing = '$wkt', pic_packing = '$pic'
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

    public function cekMulai($nospb, $jenis){
        $oracle = $this->load->database('oracle', true);
        $sql = "select * from khs_tampung_spb where no_dokumen = '$nospb' and jenis_dokumen = '$jenis'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function waktuPacking($nospb, $jenis, $waktu){
        $oracle = $this->load->database('oracle', true);
        $sql = "update khs_tampung_spb set waktu_packing = '$waktu'
                    where no_dokumen = '$nospb' and jenis_dokumen = '$jenis'";
        $query = $oracle->query($sql);      
        $query2 = $oracle->query('commit');          
    }

    public function insertColly($nospb, $jml_colly, $kardus_kecil, $kardus_sdg, $kardus_bsr, $karung){
        $oracle = $this->load->database('oracle', true);
        $sql = "insert into khs_sp_packaging (no_dokumen, jml_colly, kardus_kecil, kardus_sedang, kardus_besar, karung)
                values('$nospb', '$jml_colly', '$kardus_kecil', '$kardus_sdg', '$kardus_bsr', '$karung')";
        $query = $oracle->query($sql);      
        $query2 = $oracle->query('commit');   
    }
}