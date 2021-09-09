<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_order extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        // $this->oracle = $this->load->database('oracle', true);
        // $this->oracle_dev = $this->load->database('oracle_dev', true);
        $this->personalia = $this->load->database('personalia', true);
    }
        
    public function getSeksi($term)
    {
      return $this->personalia->query("SELECT tp.noind, tp.nama, ts.seksi
                                       from hrd_khs.tpribadi tp, hrd_khs.tseksi ts
                                       where tp.kodesie = ts.kodesie
                                       and tp.keluar = '0'
                                       and (tp.nama like '%$term%'
                                       or tp.noind like '%$term%')")->result_array();
    }
    

    public function input_order($data)
    {
        $this->db->trans_start();
        $this->db->insert('oth.torder',$data);
        $this->db->trans_complete();
    }
    
    public function input_revisi($data)
    {
        $this->db->trans_start();
        $this->db->insert('oth.trevisi',$data);
        $this->db->trans_complete();
    }

    public function getdataorder(){
        $sql = "select *
                from oth.torder";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getsaranahandling($term){
        $sql = "select *
                from dbh.master_handling
                where upper(nama_handling) like '%$term%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function update_revisi($id_order){
        $sql = "update oth.torder
                set revision = 'Y'
                where order_number = '$id_order'";
        $query = $this->db->query($sql);
    }
    
    public function update_revisi2($id_order, $revnum){
        $sql = "update oth.trevisi
                set revision = 'Y'
                where order_number = '$id_order'
                and revision_number = $revnum";
        $query = $this->db->query($sql);
    }
    
    public function getdata_status($user){
        $sql = "select oh.order_number, oh.handling_name,
                oh.creation_date, oh.created_by, oh.status,
                oh.revision, op.persiapan_qty, op.pengelasan_qty, 
                op.pengecatan_qty, op.start_date, ot.plot_enddate
                from oth.torder oh FULL JOIN oth.tprogress op
                on oh.order_number = op.order_number
                FULL JOIN oth.tplot ot
                on oh.order_number = ot.order_number
                where oh.created_by = '$user'
                and oh.revision = 'N'
                union
                select oh.order_number, oh.handling_name,
                oh.creation_date, oh.created_by, oh.status,
                oh.revision, op.persiapan_qty, op.pengelasan_qty, 
                op.pengecatan_qty, op.start_date, ot.plot_enddate
                from oth.trevisi oh FULL JOIN oth.tprogress op
                on oh.order_number = op.order_number
                FULL JOIN oth.tplot ot
                on oh.order_number = ot.order_number
                where oh.created_by = '$user'
                and oh.revision = 'N'
                order by 3 desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getdata_revisi($id_order){
        $sql = "select oh.order_number, oh.order_type,
                oh.handling_type, oh.handling_name,
                oh.design, oh.quantity, oh.due_date, oh.order_reason,
                oh.creation_date, oh.created_by,
                oh.section, oh.status, oh.approve_date,
                oh.approved_by, oh.reject_reason,
                oh.revision
                from oth.torder oh
                where oh.order_number = '$id_order'
                and oh.revision = 'N'
                union
                select oh.order_number, oh.order_type,
                oh.handling_type, oh.handling_name,
                oh.design, oh.quantity, oh.due_date, oh.order_reason,
                oh.creation_date, oh.created_by,
                oh.section, oh.status, oh.approve_date,
                oh.approved_by, oh.reject_reason,
                oh.revision
                from oth.trevisi oh
                where oh.order_number = '$id_order'
                and oh.revision = 'N'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getPengorder($user){
        $sql = "select ts.seksi, ts.unit, tp.nama
                from hrd_khs.tseksi ts, hrd_khs.tpribadi tp
                where tp.kodesie = ts.kodesie
                and tp.noind = '$user'";
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

}
