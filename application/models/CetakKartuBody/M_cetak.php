<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_cetak extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle',true);
    }

    public function ceknomor($komponen){
        $sql = "select * from ckb.ckb_no_serial where item = '$komponen' order by no_serial desc";
        $query = $this->db->query($sql);                             
        return $query->result_array();
    }

    public function getKomponen($term){
        $sql = "select produk
        from khskartubody
        where produk like '%$term%'
        order by 1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function cekserial($no, $komponen){
        $sql = "select * from ckb.ckb_no_serial where no_serial = '$no' and item = '$komponen'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function saveSerial($no, $item){
        $sql = "insert into ckb.ckb_no_serial (no_serial, item, flag) values ('$no', '$item', 'N')";
        $query = $this->db->query($sql);
        $query2 = $this->db->query('commit');
        // echo $sql;
    }
 
}
