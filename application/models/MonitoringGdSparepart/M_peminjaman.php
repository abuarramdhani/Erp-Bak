<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_peminjaman extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getPeminjam($term){
        $oracle = $this->load->database('personalia',true);
        $sql = " SELECT distinct noind, nama
            FROM hrd_khs.tpribadi 
            where noind like '%$term%'
            or nama like '%$term%'
            order by noind";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    
    public function getseksi($user){
        $oracle = $this->load->database('personalia',true);
        $sql = "select ts.seksi, ts.unit, tp.nama
                from hrd_khs.tseksi ts, hrd_khs.tpribadi tp
                where tp.kodesie = ts.kodesie
                and tp.noind = '$user'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    
    public function getdatapeminjaman(){
        $oracle = $this->load->database('oracle',true);
        $sql = "select id_peminjaman, to_char(creation_date, 'dd/mm/yyyy hh:mi:ss') creation_date, nama_peminjam, seksi_peminjam,
                        item, deskripsi, qty, alasan, pic, status
                from khs_peminjaman_gudang_e
                order by id_peminjaman desc";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    
    public function savePeminjaman($id, $nama_peminjam, $seksi_peminjam, $kode_barang, $nama_barang, $qty, $alasan, $pic){
        $oracle = $this->load->database('oracle', true);
        $sql = "INSERT INTO KHS_PEMINJAMAN_GUDANG_E (id_peminjaman, creation_date, nama_peminjam, seksi_peminjam, item, deskripsi, qty, alasan, pic, status)
            VALUES ($id,sysdate,'$nama_peminjam','$seksi_peminjam','$kode_barang', '$nama_barang','$qty', '$alasan', '$pic', 0)";

        $query = $oracle->query($sql);
        $query2 = $oracle->query("commit");
    }
  
    public function updatePeminjaman($id){
        $oracle = $this->load->database('oracle', true);
        $sql = "update khs_peminjaman_gudang_e set status = 1 where id_peminjaman = $id";
        $query = $oracle->query($sql);
        $query2 = $oracle->query("commit");
    }



}

