<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoring extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        // $this->oracle = $this->load->database('oracle', true);
        // $this->oracle_dev = $this->load->database('oracle_dev', true);
        $this->personalia = $this->load->database('personalia', true);
    }
    
    public function update_approve($id_order, $action, $date, $user, $alasan){
        $sql = "update oth.torder
                set status = $action,
                approve_date = '$date',
                approved_by = '$user',
                reject_reason = '$alasan'
                where order_number = '$id_order'";
        $query = $this->db->query($sql);
    }
    
    public function update_approve2($id_order, $action, $date, $user, $alasan, $id_rev){
        $sql = "update oth.trevisi
                set status = $action,
                approve_date = '$date',
                approved_by = '$user',
                reject_reason = '$alasan'
                where order_number = '$id_order'
                and revision_number = $id_rev";
        $query = $this->db->query($sql);
    }

    public function getdataorder($status){
        $sql = "select oh.order_number, oh.order_type,
                oh.handling_type, oh.handling_name,
                oh.design, oh.quantity, oh.due_date, oh.order_reason,
                oh.creation_date, oh.created_by,
                oh.section, oh.status, oh.approve_date,
                oh.approved_by, oh.reject_reason,
                oh.revision, 0 revision_number
                from oth.torder oh 
                where oh.status = $status
                union
                select ot.order_number, ot.order_type,
                ot.handling_type, ot.handling_name,
                ot.design, ot.quantity, ot.due_date, ot.order_reason,
                ot.creation_date, ot.created_by,
                ot.section, ot.status, ot.approve_date,
                ot.approved_by, ot.reject_reason,
                ot.revision, ot.revision_number
                from oth.trevisi ot
                where ot.status = $status
                order by 9";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getdata_plotting(){
        $sql = "select oh.order_number, oh.order_type,
                oh.handling_type, oh.handling_name,
                oh.design, oh.quantity, oh.due_date, oh.order_reason,
                oh.creation_date, oh.created_by,
                oh.section, oh.status, oh.approve_date,
                oh.approved_by, oh.reject_reason,
                oh.revision, 0 revision_number,
                op.plot_startdate, op.plot_enddate
                from oth.torder oh FULL JOIN oth.tplot op
                on oh.order_number = op.order_number
                where oh.status = 2
                union
                select ot.order_number, ot.order_type,
                ot.handling_type, ot.handling_name,
                ot.design, ot.quantity, ot.due_date, ot.order_reason,
                ot.creation_date, ot.created_by,
                ot.section, ot.status, ot.approve_date,
                ot.approved_by, ot.reject_reason,
                ot.revision, ot.revision_number,
                op.plot_startdate, op.plot_enddate
                from oth.trevisi ot FULL JOIN oth.tplot op
                on ot.order_number = op.order_number
                where ot.status = 2
                order by 18";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getdata_inprogress(){
        $sql = "select oh.order_number, oh.order_type,
                oh.handling_type, oh.handling_name,
                oh.design, oh.quantity, oh.due_date, oh.order_reason,
                oh.creation_date, oh.created_by,
                oh.section, oh.status, oh.approve_date,
                oh.approved_by, oh.reject_reason,
                oh.revision, 0 revision_number,
                op.plot_startdate, op.plot_enddate,
                os.pengecatan_qty, os.action,
                os.date_dummy
                from oth.torder oh FULL JOIN oth.tplot op
                on oh.order_number = op.order_number
                FULL JOIN oth.tprogress os
                on oh.order_number = os.order_number
                where oh.status = 2
                union
                select ot.order_number, ot.order_type,
                ot.handling_type, ot.handling_name,
                ot.design, ot.quantity, ot.due_date, ot.order_reason,
                ot.creation_date, ot.created_by,
                ot.section, ot.status, ot.approve_date,
                ot.approved_by, ot.reject_reason,
                ot.revision, ot.revision_number,
                op.plot_startdate, op.plot_enddate,
                os.pengecatan_qty, os.action,
                os.date_dummy
                from oth.trevisi ot FULL JOIN oth.tplot op
                on ot.order_number = op.order_number
                FULL JOIN oth.tprogress os
                on ot.order_number = os.order_number
                where ot.status = 2
                order by 18";
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

    public function insert_plotting($data)
    {
        $this->db->trans_start();
        $this->db->insert('oth.tplot',$data);
        $this->db->trans_complete();
    }
    
    public function update_status($status, $id_order){
        $sql = "update oth.torder
                set status = $status
                where order_number = '$id_order'";
        $query = $this->db->query($sql);
    }
    
    public function update_status2($status, $id_order, $id_rev){
        $sql = "update oth.trevisi
                set status = $status
                where order_number = '$id_order'
                and revision_number = $id_rev";
        $query = $this->db->query($sql);
    }
    
    public function update_mulai_progres($id_order, $date){
        $sql = "insert into oth.tprogress (order_number, start_date, action)
                values('$id_order', '$date', 0)";
        $query = $this->db->query($sql);
    }
    
    public function update_action_selesai($id_order, $action, $date, $waktunya){
        $date = $date != 'NULL' ? "'$date'" : $date;
        $sql = "update oth.tprogress
                set action = $action,
                date_dummy = $date
                $waktunya
                where order_number = '$id_order'";
        $query = $this->db->query($sql);
    }
    
    public function update_selesai_progres($id_order, $end_date, $waktunya){
        $sql = "update oth.tprogress
                set finish_date = '$end_date',
                time = '$waktunya',
                date_dummy = NULL
                where order_number = '$id_order'";
        $query = $this->db->query($sql);
    }
    
    public function update_persiapan_progres($id_order, $persiapan){
        $sql = "update oth.tprogress
                set persiapan_qty = $persiapan
                where order_number = '$id_order'";
        $query = $this->db->query($sql);
    }
    
    public function update_pengelasan_progres($id_order, $pengelasan){
        $sql = "update oth.tprogress
                set pengelasan_qty = $pengelasan
                where order_number = '$id_order'";
        $query = $this->db->query($sql);
    }
    
    public function update_pengecatan_progres($id_order, $pengecatan){
        $sql = "update oth.tprogress
                set pengecatan_qty = $pengecatan
                where order_number = '$id_order'";
        $query = $this->db->query($sql);
    }

    public function getdata_achiev($tgl_awal, $tgl_akhir){
        $sql = "select oh.order_number, oh.order_type,
                oh.handling_type, oh.handling_name,
                oh.design, oh.quantity, oh.due_date, oh.order_reason,
                oh.creation_date, oh.created_by,
                oh.section, oh.status, oh.approve_date,
                oh.approved_by, oh.reject_reason,
                oh.revision, op.persiapan_qty, op.pengelasan_qty, 
                op.pengecatan_qty, op.finish_date
                from oth.torder oh FULL JOIN oth.tprogress op
                on oh.order_number = op.order_number
                where oh.status = 3
                and date_trunc('day', op.finish_date) between to_date('$tgl_awal', 'yyyy-mm-dd') and to_date('$tgl_akhir', 'yyyy-mm-dd')
                union
                select ot.order_number, ot.order_type,
                ot.handling_type, ot.handling_name,
                ot.design, ot.quantity, ot.due_date, ot.order_reason,
                ot.creation_date, ot.created_by,
                ot.section, ot.status, ot.approve_date,
                ot.approved_by, ot.reject_reason,
                ot.revision, op.persiapan_qty, op.pengelasan_qty, 
                op.pengecatan_qty, op.finish_date
                from oth.trevisi ot FULL JOIN oth.tprogress op
                on ot.order_number = op.order_number
                where ot.status = 3
                and date_trunc('day', op.finish_date) between to_date('$tgl_awal', 'yyyy-mm-dd') and to_date('$tgl_akhir', 'yyyy-mm-dd')
                order by 20 asc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    

}
