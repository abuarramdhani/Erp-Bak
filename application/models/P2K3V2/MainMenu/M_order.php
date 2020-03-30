<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Order extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia   =   $this->load->database('personalia', TRUE) ;
        $this->erp          =   $this->load->database('erp_db', TRUE);
        $this->oracle       =   $this->load->database('oracle', TRUE);
    }

    public function getSeksi($noind)
    {
        $sql = "select el.employee_name as nama,
                        el.employee_code as code,
                        es.section_code,
                        es.department_name as dept,
                        es.field_name as bidang,
                        es.unit_name as unit,
                        es.section_name as section
                from er.er_employee_all as el
                left join er.er_section as es
                on el.section_code=es.section_code
                where el.employee_code='$noind'";
                // echo $sql;exit();
        $query = $this->db->query($sql);
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
        $kodesie = substr($kodesie, 0,7);
        // $this->personalia->select('*');
        // $this->personalia->from('hrd_khs.tpekerjaan');
        // $this->personalia->where('substring(kdpekerjaan, 1, 7) =', substr($kodesie, 0, 7));
        // $this->personalia->order_by('kdpekerjaan ASC');

        // return $this->personalia->get()->result_array();
        $sql = "select
                    tn.*,
                    (select count(kd_pkj)
                    from
                        hrd_khs.tpribadi ti
                    where
                        ti.kd_pkj = tn.kdpekerjaan
                        and ti.keluar = '0') jumlah
                from
                    hrd_khs.tpekerjaan tn
                where
                    substring(kdpekerjaan, 1, 7) = '$kodesie'
                    order by kdpekerjaan asc
                    ";
        $query = $this->personalia->query($sql);
        return $query->result_array();

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
        $kd = substr($kodesie, 0,7);
        $sql = "select * from k3.k3n_order where kodesie like '$kd%'";
                                    // echo $sql;exit();
               $query = $this ->db->query($sql);
        return $query->result_array();
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
        $sql = "select ttl_order, k3.k3_kebutuhan_detail.id_kebutuhan,k3.k3_kebutuhan_detail.item, k3.k3_kebutuhan_detail.status, k3.k3_kebutuhan.periode, k3.k3_kebutuhan.create_timestamp, k3.k3_kebutuhan.checked_status from k3.k3_kebutuhan_detail inner join k3.k3_kebutuhan on k3.k3_kebutuhan_detail.id_kebutuhan=k3.k3_kebutuhan.id_kebutuhan where k3.k3_kebutuhan_detail.id_kebutuhan='$id_kebutuhan'";
        // echo $sql;
        $query = $this->db->query($sql);

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
        $sql = "select
                    tgl_input::date periode,
                    tgl_approve tgl_approve_atasan,
                    substring(kodesie, 0, 8) kodesie,
                    er.section_name
                from
                    k3.k3n_standar_kebutuhan ks
                left join er.er_section er on
                    substring(er.section_code, 0, 8) = substring(ks.kodesie, 0, 8)
                where
                    status = '1'
                group by
                    tgl_input::date,
                    substring(kodesie, 0, 8),
                    er.section_name,
                    tgl_approve
                order by
                    tgl_approve,
                    er.section_name asc";
       $query = $this->db->query($sql);
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

    public function save_standar($data)
    {
        $query = $this->db->insert('k3.k3n_standar_kebutuhan', $data);
    }

    public function inputPkj($data)
    {
        $query = $this->db->insert('k3.k3n_order', $data);
    }

    public function cektgl($tgl)
    {
        $sql = "select * from k3.k3n_standar_kebutuhan where cast(tgl_input as varchar) like '$tgl%'";
        $query = $this->db->query($sql);

        return $query->num_rows();
    }

    public function getInputstd($kodesie)
    {
        $kodesie = substr($kodesie, 0,7);
        // echo $kodesie;exit();
        $sql = "select ks.*, km.item from k3.k3n_standar_kebutuhan ks
        left join k3.k3_master_item km on km.kode_item = ks.kode_item
        where ks.kodesie like '$kodesie%' order by tgl_input desc, km.item";
        // echo $sql;exit();
        $query = $this->erp->query($sql);

        return $query->result_array();
    }

    public function getInputstd2($tgl, $kodesie)
    {
        $kodesie = substr($kodesie, 0,7);
        $sql = "select ks.jml_kebutuhan_umum, ks.jml_kebutuhan_staff, ks.id, ks.kode_item, ks.jml_item, km.item from k3.k3n_standar_kebutuhan ks
        left join k3.k3_master_item km on km.kode_item = ks.kode_item
        where status = '0' and ks.kodesie like '$kodesie%' order by tgl_input desc";
        // echo $sql;exit();
        $query = $this->erp->query($sql);

        return $query->result_array();
    }

    public function getInputstd3($id)
    {
        // echo $kodesie;exit();
        $sql = "select ks.*, km.item,km.xbulan from k3.k3n_standar_kebutuhan ks
        left join k3.k3_master_item km on km.kode_item = ks.kode_item
        where ks.id = '$id' order by tgl_input desc";
        // echo $sql;exit();
        $query = $this->erp->query($sql);

        return $query->result_array();
    }

    public function delRiwayatKeb($id)
    {
        $sql = "delete from k3.k3n_standar_kebutuhan where id = '$id'";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        return true;
    }

    public function delRiwayatOr($id)
    {
        $sql = "delete from k3.k3n_order where id = '$id'";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        return true;
    }

    public function getInputOrder($kodesie)
    {
        $kodesie = substr($kodesie, 0,7);
        $sql = "select * from k3.k3n_order
        where status = '0' and kodesie like '$kodesie%' order by tgl_input desc";
        // echo $sql;exit();
        $query = $this->erp->query($sql);

        return $query->result_array();
    }

    public function updateSt($st, $id, $noind)
    {
        $tgl = date('Y-m-d H:i:s');
        $sql = "update k3.k3n_standar_kebutuhan set status = '$st', tgl_approve = '$tgl', approve_by = '$noind' where id = '$id'";
        // echo $sql;exit();
        $query = $this->erp->query($sql);

        return $query;
    }

    public function updateOr($st, $id, $noind)
    {
        $tgl = date('Y-m-d H:i:s');
        $sql = "update k3.k3n_order set status = '$st', tgl_approve = '$tgl', approve_by = '$noind' where id = '$id'";
        // echo $sql;exit();
        $query = $this->erp->query($sql);

        return $query;
    }

    public function ceklineOrder($ks)
    {
        $kodesie = substr($ks, 0,7);
        $pr = date('Y-m');
        $pr = date('Y-m',strtotime($pr . "+1 month"));
        $sql = "select * from k3.k3n_order where kodesie like '$kodesie%' and periode = '$pr'";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        // return $query->result_array();
        return $query->num_rows();
    }

    public function listmonitor($ks, $pr)
    {
        $ks = substr($ks, 0,7);
        $sql = "select
                    a.*,
                    b.jml_pekerja,
                    b.periode,
                    coalesce(bon.ttl_bon, 0) jml_bon,
                    b.jml_pekerja_staff
                from
                    (
                        select km.item,
                        ks.jml_kebutuhan_umum, 
                        ks.jml_kebutuhan_staff,
                        ks.kode_item,
                        ks.kd_pekerjaan,
                        ks.jml_item,
                        ks.kodesie,
                        ks.status
                    from
                        k3.k3n_standar_kebutuhan ks
                    inner join (
                        select
                            ks2.kode_item,
                            max(ks2.tgl_approve_tim) maks
                        from
                            k3.k3n_standar_kebutuhan ks2
                        where
                            ks2.kodesie like '$ks%'
                            and ks2.status = '3'
                        group by
                            ks2.kode_item) kz on
                        ks.kode_item = kz.kode_item
                        and ks.tgl_approve_tim = kz.maks,
                        k3.k3_master_item km
                    where
                        ks.kodesie like '$ks%'
                        and ks.status = 3
                        and ks.kode_item = km.kode_item) a
                left join (
                        select kb.periode,
                        kb.item_code,
                        sum(to_number(kb.jml_bon, '99G999D9S')) ttl_bon
                    from
                        k3.k3n_bon kb
                    where
                        kb.periode = '$pr'
                        and kb.kodesie like '$ks%'
                    group by
                        kb.periode,
                        kb.item_code) bon on
                    a.kode_item = bon.item_code,
                    (
                    select
                        ko.jml_pekerja_staff,
                        ko.kd_pekerjaan,
                        ko.jml_pekerja,
                        ko.kodesie,
                        ko.tgl_approve,
                        ko.periode
                    from
                        k3.k3n_order ko
                    where
                        status = 1
                        and kodesie like '$ks%'
                        and periode = '$pr') b
                order by
                    1";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function getOr($t)
    {
        $sql = "SELECT
                    ffv.FLEX_VALUE as COST_CENTER,
                    ffvt.DESCRIPTION as PEMAKAI,
                    ffv.ATTRIBUTE10
                from fnd_flex_values ffv,
                    fnd_flex_values_TL ffvt
                where ffv.FLEX_VALUE_SET_ID=1013709
                    and ffv.ATTRIBUTE10 != ' '
                    and ffv.ATTRIBUTE10 = 'Seksi'
                    and ffv.FLEX_VALUE_ID=ffvt.FLEX_VALUE_ID
                    AND ffv.END_DATE_ACTIVE IS NULL
                    AND ffv.flex_value NOT LIKE '0000'
                    and ffv.ENABLED_FLAG = 'Y'
                    and ffv.SUMMARY_FLAG = 'N'
                    and ffvt.DESCRIPTION like '%$t%'
                order by ffv.FLEX_VALUE
                ";
                // echo $sql;exit();
        $query = $this ->oracle->query($sql);
        return $query->result_array();
    }

    function pemakai_2($pemakai_2)
    {
        $sql = "SELECT
                    ffv.FLEX_VALUE as COST_CENTER,
                    ffvt.DESCRIPTION as PEMAKAI,
                    ffv.ATTRIBUTE10,
                     (case when (substr(ffv.FLEX_VALUE, 0,1)<=6) and (substr(ffv.FLEX_VALUE, 0,1)!=0)
                        then 'AA'
                        when (substr(ffv.FLEX_VALUE, 0,1)>=7)
                        then 'AC'
                    end) kode_cabang
                from fnd_flex_values ffv,
                    fnd_flex_values_TL ffvt
                where ffv.FLEX_VALUE_SET_ID=1013709
                    and ffv.ATTRIBUTE10 != ' '
                    and ffv.FLEX_VALUE = '$pemakai_2'
                    and ffv.FLEX_VALUE_ID=ffvt.FLEX_VALUE_ID
                    AND ffv.END_DATE_ACTIVE IS NULL
                    and ffv.ENABLED_FLAG = 'Y'
                order by ffv.FLEX_VALUE";
        $query = $this ->oracle->query($sql);
        return $query->result_array();
    }
    function lokasi()
    {
        $sql="select
                hla.LOCATION_ID,
                hla.LOCATION_CODE,
                hla.ADDRESS_LINE_1
                from HR_LOCATIONS_ALL hla
                where hla.LOCATION_ID in (29650,142,182,17204,16103,3089,3090,3091,3092)
                order by 2";
        $query=$this->oracle->query($sql);
        return $query->result_array();
    }

    function gudang($lokasi)
    {
        $sql=" SELECT
                msi.ORGANIZATION_ID,
                msi.SECONDARY_INVENTORY_NAME,
                msi.DESCRIPTION,
                mms.STATUS_CODE,
                hla.LOCATION_CODE
                from mtl_secondary_inventories msi
                ,mtl_material_statuses_tl mms
                ,HR_LOCATIONS_ALL hla
                where msi.DISABLE_DATE is null
                and msi.LOCATION_ID=hla.LOCATION_ID(+)
                and msi.STATUS_ID=mms.STATUS_ID
                and (msi.STATUS_ID not like 20 or msi.ATTRIBUTE2 = 'Y')
                and msi.location_id = '$lokasi'";
        $query=$this->oracle->query($sql);
        return $query->result_array();
    }

    public function getNum()
    {
        $tgl = date('Y-m-d');
        $sql = "select max(no_bon) from k3.k3n_bon where tgl_bon::date = '$tgl'";
        $query = $this->erp->query($sql);

        return $query->row()->max;
    }

    function lokator($gudang)
    {
        $sql="select
                    distinct(mil.SUBINVENTORY_CODE),
                    moq.LOCATOR_ID,
                    mil.SEGMENT1,
                    mil.DESCRIPTION
                from
                    mtl_item_locations mil,
                    mtl_onhand_quantities moq
                where
                    mil.SUBINVENTORY_CODE = '$gudang'
                and
                    mil.INVENTORY_LOCATION_ID =moq.LOCATOR_ID";
        $query=$this->oracle->query($sql);
        return $query->result_array();
    }

    function account($fungsi,$cost){
        $sql = "select kba.account_number
                from khs_bppbg_account kba
                where kba.using_category_code = '$fungsi'
                and kba.cost_center = '$cost'";
        $query = $this->oracle->query($sql);
        // echo $sql;
        return $query->row()->ACCOUNT_NUMBER;
    }

    public function cekOrder($ks, $pr)
    {
        $ks = substr($ks, 0,7);
        $sql = "select * from k3.k3n_order where kodesie like '$ks%' and periode = '$pr' and status = '1';";
                                    // echo $sql;exit();
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function maxPekerja($kodesie)
    {
        $ks = substr($kodesie, 0,7);
        $sql = "select * from hrd_khs.tpribadi
                where keluar = '0'
                and kodesie like '$ks%'";
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function getPekerja($ks)
    {
        $ks = substr($ks, 0,7);
        $sql = "select
                    tp.noind,
                    tp.nama,
                    coalesce(tk.pekerjaan, 'STAFF') pekerjaan
                from
                    hrd_khs.tpribadi tp
                left join hrd_khs.tpekerjaan tk on
                    tp.kd_pkj = tk.kdpekerjaan
                where
                    keluar = '0'
                    and kodesie like '$ks%'
                order by
                    1";
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function getEmail($kodesie)
    {
        $ks = substr($kodesie, 0,7);
        $sql = "Select * from k3.k3n_email_seksi where kodesie like '%$ks%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function addEmailSeksi($email, $kodesie, $noind)
    {
        $tgl = date('Y-m-d H:i:s');
        $ks = substr($kodesie, 0,7);
        $sql = "insert into k3.k3n_email_seksi (kodesie, email, last_update_by, last_update_date) values ('$ks', '$email', '$noind', '$tgl');";
        $query = $this->erp->query($sql);
        return true;
    }

    public function editEmailSeksi($id,$email, $noind)
    {
        $tgl = date('Y-m-d H:i:s');
        $sql = "update k3.k3n_email_seksi set email = '$email', last_update_by = '$noind', last_update_date = '$tgl' where id = '$id';";
        $query = $this->erp->query($sql);
        return true;
    }

    public function hapusEmailSeksi($id)
    {
        $sql = "delete from k3.k3n_email_seksi where id = '$id';";
        $query = $this->erp->query($sql);
        return true;
    }

    public function getDetailPekerja($noind)
    {
        $sql = "SELECT * from hrd_khs.tpribadi where noind = '$noind'";
        return $this->personalia->query($sql);
    }
}
