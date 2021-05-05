<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_bppbg extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle', true);
    }

    public function search($term){
        $sql = "SELECT imb.no_bon
        FROM im_master_bon imb
       WHERE imb.no_bon LIKE '%$term%'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getData($bppbg){
        $sql = "SELECT imb.kode_barang, imb.nama_barang, imb.ACCOUNT, imb.cost_center,
        imb.seksi_bon, imb.pemakai, imb.tujuan_gudang, imb.tanggal
   FROM im_master_bon imb
  WHERE imb.no_bon = $bppbg";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
}

?>