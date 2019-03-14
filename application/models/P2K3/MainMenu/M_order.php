<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Order extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia   =   $this->load->database('personalia', TRUE) ;
        $this->erp          =   $this->load->database('erp_db', TRUE);
    }

    public function getSeksi($noind)
    {
        $query = $this->db->query("select el.employee_name as nama,
                                            el.employee_code as code,
                                            es.section_code,
                                            es.department_name as dept,
                                            es.field_name as bidang,
                                            es.unit_name as unit,
                                            es.section_name as section
                                    from er.er_employee_all as el
                                    left join er.er_section as es
                                    on el.section_code=es.section_code
                                    where el.employee_code='$noind'");
        return $query->result_array();
    }

    public function getItem($item){
        $query = $this->db->query("select * from k3.k3_master_item where item like upper('%$item%')");
        return $query->result_array();
    }

    // public function getUnit()
    // {
    //     $query = $this->db->query("select unit_name from er.er_section");
    //     return $query->result_array();
    // }

    public function daftar_pekerjaan($kodesie)
    {
        $this->personalia->select('*');
        $this->personalia->from('hrd_khs.tpekerjaan');
        $this->personalia->where('substring(kdpekerjaan, 1, 7) =', substr($kodesie, 0, 7));

        return $this->personalia->get()->result_array();
    }

    public function kode_pekerjaan($kodesie)
    {
        $this->personalia->select('kdpekerjaan');
        $this->personalia->from('hrd_khs.tpekerjaan');
        $this->personalia->where('substring(kdpekerjaan, 1, 7) =', substr($kodesie, 0, 7));
        
        return $this->personalia->get()->result_array();
    }

    public function save_dataPeriode($data)
    {
        $query = $this->db->insert('k3.k3_kebutuhan', $data);
    } 
    
    public function save_data_apd($lines)
    {
        $query = $this->db->insert('k3.k3_kebutuhan_detail', $lines);
    }

    public function save_data_pekerja($tbl_pekerja)
    {
        $query = $this->db->insert('k3.k3_kebutuhan_pekerja', $tbl_pekerja);
    }

    public function history_log($history)
    {
        $query = $this->db->insert('k3.k3_log', $history);
    }

    public function getNamaApd($kode)
    {
        $this->db->where('kode_item',$kode);
        $query = $this->db->get('k3.k3_master_item');
        return $query->result_array();
    }

    public function tampil_data($kodesie)
    {
               $query = $this ->db->query("select * from k3.k3_kebutuhan_detail tb1 join k3.k3_kebutuhan tb2 on
                                    tb1.id_kebutuhan = tb2.id_kebutuhan join k3.k3_kebutuhan_pekerja tb3 on
                                    tb1.id_kebutuhan_detail = tb3.id_kebutuhan_detail where tb2.kodesie = '$kodesie'
                                    order by tb1.status_updated desc");
        return $query->result_array();
        
        // $this->db->select('*');
        // $this->db->join('k3.k3_kebutuhan_pekerja kp', 'kd.id_kebutuhan_detail = kp.id_kebutuhan_detail');
        // $this->db->order_by('kp.id_kebutuhan_detail'); 
        // $query = $this->db->get('k3.k3_kebutuhan_detail kd');
        // return $query->result_array();
    }

    public function tampil_data_2($kodesie,$m,$y){
        $sql = "select * from k3.k3_kebutuhan_detail tb1 join k3.k3_kebutuhan tb2 on
                                    tb1.id_kebutuhan = tb2.id_kebutuhan join k3.k3_kebutuhan_pekerja tb3 on
                                    tb1.id_kebutuhan_detail = tb3.id_kebutuhan_detail 
                                    where extract(month from tb2.create_timestamp) = '$m'::int 
                                    and extract (year from tb2.create_timestamp) = '$y'::int
                                    and left(tb2.kodesie,7) = left('$kodesie',7)
                                    order by tb1.status_updated desc";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function join_3($id_kebutuhan_detail)
    {
         $query = $this->db->query("select * from k3.k3_kebutuhan t1 inner join k3.k3_kebutuhan_detail t2 on t1.id_kebutuhan = t2.id_kebutuhan inner join k3.k3_kebutuhan_pekerja t3 on t2.id_kebutuhan_detail = t3.id_kebutuhan_detail where t2.id_kebutuhan_detail = '$id_kebutuhan_detail'");
        return $query->result_array();
    } 

    public function update_status($id_kebutuhan_detail,$status1)
    {
       $this->db->where('id_kebutuhan_detail', $id_kebutuhan_detail);
       $this->db->update('k3.k3_kebutuhan_detail',$status1);
       return;
    } 

    public function update_c_status($id_kebutuhan,$status2)
    {
       $this->db->where('id_kebutuhan', $id_kebutuhan);
       $this->db->update('k3.k3_kebutuhan',$status2);
       return;
    } 

    public function tampil_data_edit($id_kebutuhan_detail)
    {
        $this->db->select('*');
        $this->db->join('k3.k3_kebutuhan_pekerja kp', 'kd.id_kebutuhan_detail = kp.id_kebutuhan_detail');
        $this->db->join('k3.k3_kebutuhan kb', 'kd.id_kebutuhan = kb.id_kebutuhan');
        $this->db->order_by('kp.id_kebutuhan_detail'); 
        $this->db->where('kd.id_kebutuhan_detail',$id_kebutuhan_detail);
        $query = $this->db->get('k3.k3_kebutuhan_detail kd');
        return $query->result_array();
    }

    public function ambil_data()
    {
        $query = $this->db->query('select * from k3.k3_kebutuhan kb
                                    join k3.k3_kebutuhan_detail kd on kb.id_kebutuhan = kd.id_kebutuhan 
                                    where extract(month from kb.create_timestamp) = extract(month from current_timestamp)
                                    and extract(year from kb.create_timestamp) = extract(year from current_timestamp)');
        // $this->erp->select('*');
        // $this->erp->from('k3.k3_kebutuhan');
        // $this->erp->where('extract(month from create_timestamp) = extract(month from current_timestamp)');
        // $this->erp->where('extract(year from create_timestamp) = extract(year from current_timestamp)');
        // $query = $this->db->get('k3.k3_kebutuhan');
        return $query->result_array();
    } 

    public function join_2($id_kebutuhan)
    {
        // $this->db->where('id_kebutuhan', $nom);
        // $this->db->select('t2.id_kebutuhan, t2.item, t2.status, t1.periode, t1.create_timestamp, t1.checked_status');
        // $this->db->join('k3.k3_kebutuhan_detail t2', 't2.id_kebutuhan = t1.id_kebutuhan');
        // // $this->db->where('t2.id_kebutuhan', $id_kebutuhan);
        // $query = $this->db->get('k3.k3_kebutuhan t1');
        // $query = $this->db->query('select item, status
        //     from k3.k3_kebutuhan_detail kb
        //     inner join k3.k3_kebutuhan kd on kb.id_kebutuhan = kd.id_kebutuhan
        //     where kb.id_kebutuhan = $id_kebutuhan');
        $query = $this->db->query("select k3.k3_kebutuhan_detail.id_kebutuhan,k3.k3_kebutuhan_detail.item, k3.k3_kebutuhan_detail.status, k3.k3_kebutuhan.periode, k3.k3_kebutuhan.create_timestamp, k3.k3_kebutuhan.checked_status from k3.k3_kebutuhan_detail inner join k3.k3_kebutuhan on k3.k3_kebutuhan_detail.id_kebutuhan=k3.k3_kebutuhan.id_kebutuhan where k3.k3_kebutuhan_detail.id_kebutuhan='$id_kebutuhan'");

        return $query->result_array();
    }

    public function update_kebutuhan_detail($lines,$id_kebutuhan_detail)
    {
        $this->db->where('id_kebutuhan_detail',$id_kebutuhan_detail);
        $this->db->update('k3.k3_kebutuhan_detail', $lines);
        return;
    }  

    public function update_kebutuhan_pekerja($tbl_pekerja,$id_kebutuhan_detail)
    {
        $this->db->where('id_kebutuhan_detail',$id_kebutuhan_detail);
        $this->db->update('k3.k3_kebutuhan_pekerja', $tbl_pekerja);
        return;
    }

    public function history($history)
    {
        $this->db->insert('k3.k3_log', $history);
        return;
    }

    public function ambil_id($id_kebutuhan_detail)
    {
        $this->db->where('id_kebutuhan_detail', $id_kebutuhan_detail);
        $query = $this->db->get('k3.k3_kebutuhan_pekerja');
        return $query->result_array();
    } 

    public function delete_apd($id_kebutuhan_detail)
    {
        $this->db->where('id_kebutuhan_detail',$id_kebutuhan_detail);
        $this->db->delete('k3.k3_kebutuhan_detail');
        return;
    }
    public function delete_apd2($id_kebutuhan_detail)
    {
        $this->db->where('id_kebutuhan_detail',$id_kebutuhan_detail);
        $this->db->delete('k3.k3_kebutuhan_pekerja');
        return;
    }

    public function export_apd()
    {   
        $query = $this->db->get('k3.k3_kebutuhan_detail');
        return $query->result_array();
    }

    public function approve($user1)
    {
        $this->db->select('p2k3_approver');
        $this->db->where('user_name', $user1);
        $query = $this->db->get('sys.sys_user');
        return $query->result_array();
    }

    public function approveString($user1)
    {
        $this->db->select('p2k3_approver');
        $this->db->where('user_name', $user1);
        $query = $this->db->get('sys.sys_user');
        return $query->row()->p2k3_approver;
    }

    public function periode_status($periode)
    {
        $this->db->select('checked_status');
        $this->db->where('periode', $periode);
        $query = $this->db->get('k3.k3_kebutuhan');
        return $query->result_array();
    }

    public function modalView($id_kebutuhan)
    {
       $query = $this->db->query("select item, status
            from k3.k3_kebutuhan_detail kb
            inner join k3.k3_kebutuhan kd on kb.id_kebutuhan = kd.id_kebutuhan
            where kb.id_kebutuhan = '$id_kebutuhan'");
        return $query->result_array();
    }

    public function getNamaSeksi()
    {
       $query = $this->db->query('select distinct tb1.kodesie, tb2.section_name from k3.k3_kebutuhan tb1
                                    inner join er.er_section tb2 on tb1.kodesie = tb2.section_code 
                                    where tb1.kodesie = tb2.section_code');
        return $query->result_array();
    }

    public function getListSeksi($kode_seksi)
    {
        $query = $this ->db->query("select * from k3.k3_kebutuhan_detail tb1 join k3.k3_kebutuhan tb2 on
                                    tb1.id_kebutuhan = tb2.id_kebutuhan join k3.k3_kebutuhan_pekerja tb3 on
                                    tb1.id_kebutuhan_detail = tb3.id_kebutuhan_detail where tb2.kodesie = '$kode_seksi'
                                    order by tb1.status_updated desc");
        return $query->result_array();
    }

    public function updateDocumentApproval($nama_file,$id_kebutuhan){
        $sql = "update k3.k3_kebutuhan set document_approval = '$nama_file' where id_kebutuhan = $id_kebutuhan";
        $this->db->query($sql);
        return ;
    }
}
