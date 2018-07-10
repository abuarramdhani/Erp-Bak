<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_order extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function setOrder($data)
    {
        return $this->db->insert('sm.sm_order', $data);
    }

    public function saveOrderDetail($lines)
    {
        return $this->db->insert('sm.sm_order_detail',$lines);
    }

    public function listOrder($user)
    {
        $query = $this->db->query("select so.*,
                                            (select seksi.section_name
                                            from er.er_section as seksi
                                            where seksi.section_code=so.seksi_order) as nama_seksi
                                    from sm.sm_order as so
                                    where so.created_by='$user' 
                                        and so.status!=3
                                    order by so.no_order");
        return $query->result_array();
    }

    public function cekNoOrder()
    {
        $query = $this->db->query("select max(no_order) as no_order
                                    from sm.sm_order
                                    where to_char(tgl_order, 'YYYY-MM')=to_char(now(),'YYYY-MM')");
        return $query->result_array();
    }

    public function Header($id)
    {
        $query = $this->db->query("select so.*,
                                            es.section_name as nama_seksi,
                                            es.department_name as nama_dept
                                    from sm.sm_order as so
                                    left join er.er_section as es
                                    on so.seksi_order=es.section_code
                                    where so.id_order=$id");
        return $query->result_array();
    }

    public function Lines($id)
    {
        $query = $this->db->query("select * from sm.sm_order_detail where id_order=$id order by id_order_detail");
        return $query->result_array();
    }

    public function RejectbySystem()
    {
        $query = $this->db->query("update sm.sm_order 
                                    set status=4, status_date=now()
                                    where ((tgl_order + interval '7 day') < now()) and status=0");
        return $query;
    }
}

/* End of file M_order.php */
/* Location: ./application/models/OrderSiteManagement/MainMenu/M_order.php */
/* Generated automatically on 2018-06-26 09:50:15 */