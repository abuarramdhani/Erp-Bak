<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_order extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getSeksi($seksi){
    	$query = $this->db->query("select      seksi.section_code as kode_seksi,
                                            seksi.section_name as nama_seksi
                                from        er.er_section as seksi
                                where       seksi.job_name='-'
                                            and     seksi.section_name!='-'
                                            and     right(seksi.section_code,2)='00'
                                            and 	seksi.section_name like upper('%$seksi%')
                                order by    nama_seksi");
    	return $query->result_array();
    }

    public function listOrder()
    {
        $query = $this->db->query("select so.*,
                                            (select seksi.section_name
                                            from er.er_section as seksi
                                            where seksi.section_code=so.seksi_order) as nama_seksi
                                    from sm.sm_order as so
                                    order by so.tgl_order desc");
        return $query->result_array();
    }

    public function FilterDataOrder($tgl1,$tgl2,$seksi,$jenis){
        $query = $this->db->query("select so.*,
                                            (select concat_ws(' - ', seksi.unit_name, seksi.section_name)
                                            from er.er_section as seksi
                                            where seksi.section_code=so.seksi_order) as nama_seksi
                                    from sm.sm_order as so
                                    where ((tgl_order + interval '7 day') > now())
                                          and (so.tgl_order between '$tgl1' and '$tgl2')
                                            $seksi $jenis
                                    order by so.tgl_order desc");
        return $query->result_array();
    }

    public function ReadHeader($id)
    {
        $query = $this->db->query("select so.*,
                                            (select seksi.section_name
                                            from er.er_section as seksi
                                            where seksi.section_code=so.seksi_order) as nama_seksi
                                    from sm.sm_order as so
                                    where so.id_order=$id");
        return $query->result_array();
    }

    public function ReadLines($id)
    {
        $query = $this->db->query("select * from sm.sm_order_detail where id_order=$id order by id_order_detail");
        return $query->result_array();
    }

    public function CekStatusOrder($status,$id)
    {
        $query = $this->db->query("update sm.sm_order set remarks='$status', status=3 where id_order='$id' and status=1 and tgl_terima!=null");
        return $query;
    }

    public function RejectFromAdmin($id)
    {
        $query = $this->db->query("update sm.sm_order set status=2 where id_order='$id'");
        return $query;
    }

    public function RejectbySystem()
    {
        $query = $this->db->query("update sm.sm_order 
                                    set status=4
                                    where ((tgl_order + interval '7 day') < now()) and status=0");
        return $query;
    }
}