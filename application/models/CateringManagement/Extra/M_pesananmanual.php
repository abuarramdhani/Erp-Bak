<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pesananmanual extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);    
    }
    
    public function simpan($id)
    {
    	 $this->personalia->insert('"Catering".tpesanan_manual',$id);
        return;
    }
    public function keep()
    {
    	$sql = "select * from \"Catering\".tpesanan_manual
    			ORDER BY fd_tanggal DESC";
    	$query = $this->personalia->query($sql);
    	return $query->result_array();
    }

    public function read($id) {
        $sql = "select * from \"Catering\".tpesanan_manual
                WHERE id_pesanan='$id'";
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }
    public function edit($id) {
        $sql = "select * from \"Catering\".tpesanan_manual
                WHERE id_pesanan='$id'";
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }
     public function update($tgl_pesanan,$kd_shift,$tempat_makan,$jumlah_pesanan,$submit) 
     {
        $sql = "update \"Catering\".tpesanan_manual
                set fd_tanggal='$tgl_pesanan',fs_kd_shift='$kd_shift',fs_tempat_makan='$tempat_makan',fn_jumlah_pesan='$jumlah_pesanan'
                WHERE id_pesanan='$submit'";
                // echo $sql;exit();
        $query = $this->personalia->query($sql);
        // return $query->result_array();
    }
    public function ubah()
    {
        $sql = "select * from \"Catering\".tpesanan_manual
                ORDER BY fd_tanggal DESC";
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }
    public function delete($id)
    {
           $sql = "Delete from \"Catering\".tpesanan_manual
                WHERE id_pesanan='$id'";
        $query = $this->personalia->query($sql);
    }
} ?>