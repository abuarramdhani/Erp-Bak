<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_dbhandling extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
        $this->personalia = $this->load->database('personalia', true);
    }
    public function insertmasterhandling($namahandling, $kodehandling)
    {
        $sql = "insert into dbh.master_handling(kode_handling, nama_handling) values('$kodehandling', '$namahandling')";

        $query = $this->db->query($sql);
        return $query;
    }

    public function selectmasterhandling()
    {
        $sql = "select * from dbh.master_handling";

        $query = $this->db->query($sql);
        return $query->result_array();;
    }

    public function selectdatatoedit($id)
    {
        $sql = "select * from dbh.master_handling where id_master_handling = '$id'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function updatemasterhandling($id, $namahandling, $kodehandling)
    {
        $sql = "update dbh.master_handling set nama_handling = '$namahandling', kode_handling = '$kodehandling' where id_master_handling = '$id'";

        $query = $this->db->query($sql);
        return $query;
    }
    public function insertmasterprosesseksi($identitasseksi, $namaseksi)
    {
        $sql = "insert into dbh.master_proses_seksi(identitas_seksi, seksi) values('$identitasseksi', '$namaseksi')";

        $query = $this->db->query($sql);
        return $query;
    }
    public function selectmasterprosesseksi()
    {
        $sql = "select * from dbh.master_proses_seksi";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function selectdatatoedit2($id)
    {
        $sql = "select * from dbh.master_proses_seksi where id_proses_seksi = '$id'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function updatemasterprosesseksi($identitasseksi, $namaseksi, $id)
    {
        $sql = "update dbh.master_proses_seksi set identitas_seksi = '$identitasseksi', seksi = '$namaseksi' where id_proses_seksi = '$id'";

        $query = $this->db->query($sql);
        return $query;
    }
    public function checkkodehandling($kode)
    {
        $sql = "select * from dbh.master_handling where kode_handling = '$kode'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function hapusdatamasterhandling($id)
    {
        $sql = "delete from dbh.master_handling where id_master_handling = '$id'";

        $query = $this->db->query($sql);
        return $query;
    }
    public function hapusdatamasterproses($id)
    {
        $sql = "delete from dbh.master_proses_seksi where id_proses_seksi = '$id'";

        $query = $this->db->query($sql);
        return $query;
    }
    public function selectproduk($term)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "select ffv.FLEX_VALUE ,ffvt.DESCRIPTION from fnd_flex_values ffv ,fnd_flex_values_tl ffvt 
        where ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID 
        and ffv.FLEX_VALUE_SET_ID = 1013710 
        and ffv.END_DATE_ACTIVE is null 
        and ffv.ENABLED_FLAG = 'Y' 
        and (upper(ffv.FLEX_VALUE) like upper('%$term%') or upper(ffvt.DESCRIPTION) like upper('%$term%'))";
        // return $sql;
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    public function selectsarana($term)
    {
        $sql = "select * from dbh.master_handling where kode_handling like upper ('%$term%') or nama_handling like upper ('%$term%')";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function selectmasterseksi($id)
    {
        $sql = "select * from dbh.master_proses_seksi where identitas_seksi='$id'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function checkkodestatus($kode)
    {
        $sql = "select * from dbh.status_komponen where kode_status = '$kode'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function selectstatuskomp()
    {
        $sql = "select * from dbh.status_komponen";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function insertstatkomp($status, $kode, $id)
    {
        $sql = "insert into dbh.status_komponen(id_status_komponen, status, kode_status) values('$id','$status','$kode')";

        $query = $this->db->query($sql);
        return $query;
    }
    public function selectstatuskompbyid($id)
    {
        $sql = "select * from dbh.status_komponen where id_status_komponen = '$id'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function updatestatkomp($nama, $kode, $id)
    {
        $sql = "update dbh.status_komponen set status='$nama', kode_status='$kode' where id_status_komponen = '$id'";

        $query = $this->db->query($sql);
        return $query;
    }
    public function deletestatkomp($id)
    {
        $sql = "delete from dbh.status_komponen where id_status_komponen = '$id'";

        $query = $this->db->query($sql);
        return $query;
    }
    public function selectstatuskompp($term)
    {
        $sql = "select * from dbh.status_komponen where kode_status like upper ('%$term%') or status like upper ('%$term%')";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function kodekomp($term)
    {

        $sql = "SELECT DISTINCT msib.segment1, msib.description
           FROM mtl_system_items_b msib
          WHERE msib.inventory_item_status_code = 'Active'
            AND (   msib.description LIKE '%$term%'
                 OR msib.segment1 LIKE '%$term%'
                )
            AND msib.organization_id IN (101, 102) --OPM, ODM
       ORDER BY msib.segment1";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function desckomp($kode)
    {
        $sql = "select msib.segment1 ,msib.description
                       from mtl_system_items_b msib
                       where msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                       AND msib.SEGMENT1 = '$kode'";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function cekKode($kode)
    {
        $sql = "select * from dbh.data_handling where kode_komponen = '$kode'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function dataEdit($kode, $rev)
    {
        $sql = "select * from dbh.data_handling where kode_komponen = '$kode' and rev_no = '$rev'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function insertdatahandling($lastupdate_date, $lastupdate_by, $doc_no, $kode, $desc, $status_komp, $kode_produk, $nama_produk, $sarana, $qty, $berat, $seksi, $proses, $keterangan)
    {
        $sql = "insert into dbh.data_handling(doc_number, rev_no, last_update_date, kode_komponen, nama_komponen, kode_produk, id_master_handling, qty_handling, berat, seksi, proses, status, last_update_by, id_status_komponen, requester, nama_produk, keterangan)
        values('$doc_no', 0, '$lastupdate_date', '$kode', '$desc', '$kode_produk', '$sarana', $qty, $berat, '$seksi', '$proses', 'active', '$lastupdate_by', '$status_komp', '-', '$nama_produk', '$keterangan')";

        $query = $this->db->query($sql);
        return $query;
    }
    public function insertdatahandlingrev($rev_no, $lastupdate_date, $lastupdate_by, $doc_no, $kode, $desc, $status_komp, $kode_produk, $nama_produk, $sarana, $qty, $berat, $seksi, $proses, $keterangan)
    {
        $sql = "insert into dbh.data_handling(doc_number, rev_no, last_update_date, kode_komponen, nama_komponen, kode_produk, id_master_handling, qty_handling, berat, seksi, proses, status, last_update_by, id_status_komponen, requester, nama_produk, keterangan)
        values('$doc_no', '$rev_no', '$lastupdate_date', '$kode', '$desc', '$kode_produk', '$sarana', $qty, $berat, '$seksi', '$proses', 'active', '$lastupdate_by', '$status_komp', '-', '$nama_produk', '$keterangan')";

        $query = $this->db->query($sql);
        return $query;
    }
    public function getIdHandling()
    {
        $sql = "select lastval()";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function insertproseshandling($id, $urutan_proses, $proses_seksi)
    {
        $sql = "insert into dbh.proses_seksi(id_handling, urutan, id_proses_seksi) values('$id', '$urutan_proses', '$proses_seksi')";

        $query = $this->db->query($sql);
        return $query;
    }
    public function insertgambar($id, $urutangambarproseslinear)
    {
        $sql = "insert into dbh.gambar(id_handling, urutan) values('$id', '$urutangambarproseslinear')";

        $query = $this->db->query($sql);
        return $query;
    }
    public function cariidproseseksi($proses_seksi)
    {
        $sql = "select * from dbh.master_proses_seksi where seksi = '$proses_seksi'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function selectdatahandling()
    {
        $sql = "select handling.* from dbh.data_handling handling, 
        (select max(rev_no) rev_no, kode_komponen from dbh.data_handling where status = 'active' group by kode_komponen ) max
where handling.kode_komponen = max.kode_komponen
and handling.rev_no = max.rev_no order by handling.last_update_date DESC";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function selectdatahandlingbysarana($sarana)
    {
        $sql = "select handling.* from dbh.data_handling handling, 
        (select max(rev_no) rev_no, kode_komponen from dbh.data_handling where status = 'active' group by kode_komponen ) max
where handling.kode_komponen = max.kode_komponen 
and id_master_handling = '$sarana'
and handling.rev_no = max.rev_no order by handling.last_update_date DESC";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function selectdatahandlingbyprod($produk)
    {
        $sql = "select handling.* from dbh.data_handling handling, 
        (select max(rev_no) rev_no, kode_komponen from dbh.data_handling where status = 'active' group by kode_komponen ) max
where handling.kode_komponen = max.kode_komponen 
and kode_produk = '$produk'
and handling.rev_no = max.rev_no order by handling.last_update_date DESC";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function selectdatahandlingseksi($seksi)
    {
        $sql = "select handling.* from dbh.data_handling handling, 
        (select max(rev_no) rev_no, kode_komponen from dbh.data_handling where status = 'active' group by kode_komponen ) max
where handling.kode_komponen = max.kode_komponen 
and seksi = '$seksi'
and handling.rev_no = max.rev_no order by handling.last_update_date DESC";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function selectdatahandlingbyid($id)
    {
        $sql = "select * from dbh.data_handling where id_handling = '$id'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getGambar($id)
    {
        $sql = "select * from dbh.gambar where id_handling = '$id'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function getProses($id)
    {
        $sql = "select * from dbh.proses_seksi where id_handling = '$id'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function selectdatahandlingbykom($komp)
    {
        $sql = "select * from dbh.data_handling 
       where kode_komponen = '$komp' and status = 'active'
       order by rev_no desc";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function getnewdatahandbystat()
    {
        $sql = "select * from dbh.data_handling 
        where status != 'active'
        and rev_no = -1
        order by last_update_date desc";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function getrevdatahandbystat()
    {
        $sql = "select * from dbh.data_handling 
        where status != 'active'
        and rev_no = -2
        order by last_update_date desc";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function insertdatahandlingseksi($lastupdate_date, $lastupdate_by, $doc_no, $kode, $desc, $status_komp, $kode_produk, $nama_produk, $sarana, $qty, $berat, $seksi, $proses, $keterangan)
    {
        $sql = "insert into dbh.data_handling(doc_number,rev_no, last_update_date, kode_komponen, nama_komponen, kode_produk, id_master_handling, qty_handling, berat, seksi, proses, status, last_update_by, id_status_komponen, requester, nama_produk, keterangan)
        values('$doc_no','-1', '$lastupdate_date', '$kode', '$desc', '$kode_produk', '$sarana', $qty, $berat, '$seksi', '$proses', 'request', '$lastupdate_by', '$status_komp', '$lastupdate_by', '$nama_produk', '$keterangan')";

        $query = $this->db->query($sql);
        return $query;
    }
    public function insertdatahandlingrev2($lastupdate_date, $lastupdate_by, $doc_no, $kode, $desc, $status_komp, $kode_produk, $nama_produk, $sarana, $qty, $berat, $seksi, $proses, $keterangan)
    {
        $sql = "insert into dbh.data_handling(doc_number, rev_no, last_update_date, kode_komponen, nama_komponen, kode_produk, id_master_handling, qty_handling, berat, seksi, proses, status, last_update_by, id_status_komponen, requester, nama_produk, keterangan)
        values('$doc_no', '-2', '$lastupdate_date', '$kode', '$desc', '$kode_produk', '$sarana', $qty, $berat, '$seksi', '$proses', 'request', '$lastupdate_by', '$status_komp', '$lastupdate_by', '$nama_produk', '$keterangan')";

        $query = $this->db->query($sql);
        return $query;
    }
    public function updateterima($id, $rev)
    {
        $sql = "update dbh.data_handling set status = 'active', rev_no='$rev' where id_handling = '$id'";

        $query = $this->db->query($sql);
        return $query;
    }
    public function updatereject($id)
    {
        $sql = "update dbh.data_handling set status = 'reject' where id_handling = '$id'";

        $query = $this->db->query($sql);
        return $query;
    }
    public function _daftar()
    {
        $sql = "select distinct seksi from dbh.data_handling";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function select_produk()
    {
        $sql = "select distinct kode_produk, nama_produk from dbh.data_handling";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function select_sarana()
    {
        $sql = "select distinct id_master_handling from dbh.data_handling";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function select_seksi()
    {
        $sql = "select distinct seksi from dbh.data_handling";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function select2_seksi($term)
    {
        $sql = "select distinct seksi from hrd_khs.tseksi ts                 
       where seksi like '%$term%'
       and seksi != '-'
       and seksi != '-                                                 '                                                              
       order by seksi";

        $query = $this->personalia->query($sql);
        return $query->result_array();
    }
}
