<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_monitoringsalesorder extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle',TRUE);
    }

    public function do_outstanding(){
        $query= "select distinct so_header_id, order_number, to_char(creation_date,'yyyy-mm-dd HH24:MI:SS') creation_date from khs_do_gudang order by order_number DESC";
        $hasil = $this->oracle->query($query);
        return $hasil->result_array();
    }

    public function do_done(){
        $query = "select distinct so_header_id, order_number, to_char(creation_date,'yyyy-mm-dd HH24:MI:SS') creation_date from KHS_DONE_SO_GUDANG order by order_number DESC";
        $hasil = $this->oracle->query($query);
        return $hasil->result_array();
    }

    public function do_detail($order_number){
        $query="SELECT distinct order_number, kode_barang, nama_barang, qty, uom, lokasi
        from khs_do_gudang WHERE order_number = '".$order_number."'";
        $hasil = $this->oracle->query($query);
        return $hasil->result_array();
    }

    public function do_detail_done($order_number){
        $query="SELECT distinct order_number, kode_barang, nama_barang, qty, uom, lokasi
        from KHS_DONE_SO_GUDANG WHERE ORDER_NUMBER = '".$order_number."'";
        $hasil = $this->oracle->query($query);
        return $hasil->result_array();
    }

    public function select_item($order_number){
        $query="SELECT * FROM khs_do_gudang WHERE order_number = '".$order_number."'";
        $hasil = $this->oracle->query($query);
        return $hasil->result_array();
    }

    public function insert_done($so_header, $order_number,$kode_barang,$nama_barang,$qty,$uom,$lokasi){
        $query = "INSERT into KHS_DONE_SO_GUDANG values('$so_header','$order_number','$kode_barang','$nama_barang','$qty','$uom','$lokasi',sysdate)";
        $this->oracle->query($query);
        // echo $query;
        // exit;
        $querydel = "DELETE FROM  khs_do_gudang WHERE ORDER_NUMBER = '".$order_number."' AND KODE_BARANG = '".$kode_barang."'";
        $this->oracle->query($querydel);
    }

    public function fetch_count(){
        $query = "SELECT count(DISTINCT ORDER_NUMBER) as total from khs_do_gudang";
        $hasil = $this->oracle->query($query);
        return $hasil->result_array();
    }
}
?>
