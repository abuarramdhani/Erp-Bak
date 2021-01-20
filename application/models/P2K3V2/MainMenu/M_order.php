<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Order extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia   =   $this->load->database('personalia', TRUE);
        $this->erp          =   $this->load->database('default', true);
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

    public function getItem($item)
    {
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
        if (gettype($kodesie) == 'string') {
            $kodesie = substr($kodesie, 0, 7);
        } elseif (gettype($kodesie) == 'array') {
            $kodesie = implode("', '", $kodesie);
        }
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
                    substring(kdpekerjaan, 1, 7) in ('$kodesie')
                    order by kdpekerjaan asc
                    ";
        // echo $sql;exit();
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
        $this->db->where('kode_item', $kode);
        $query = $this->db->get('k3.k3_master_item');
        return $query->result_array();
    }

    public function tampil_data($kodesie)
    {
        $kd = substr($kodesie, 0, 7);
        $sql = "select * from k3.k3n_order where kodesie like '$kd%'";
        // echo $sql;exit();
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function tampil_data_2($kodesie, $m, $y)
    {
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

    public function update_status($id_kebutuhan_detail, $status1)
    {
        $this->db->where('id_kebutuhan_detail', $id_kebutuhan_detail);
        $this->db->update('k3.k3_kebutuhan_detail', $status1);
        return;
    }

    public function update_c_status($id_kebutuhan, $status2)
    {
        $this->db->where('id_kebutuhan', $id_kebutuhan);
        $this->db->update('k3.k3_kebutuhan', $status2);
        return;
    }

    public function tampil_data_edit($id_kebutuhan_detail)
    {
        $this->db->select('*');
        $this->db->join('k3.k3_kebutuhan_pekerja kp', 'kd.id_kebutuhan_detail = kp.id_kebutuhan_detail');
        $this->db->join('k3.k3_kebutuhan kb', 'kd.id_kebutuhan = kb.id_kebutuhan');
        $this->db->order_by('kp.id_kebutuhan_detail');
        $this->db->where('kd.id_kebutuhan_detail', $id_kebutuhan_detail);
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

    public function update_kebutuhan_detail($lines, $id_kebutuhan_detail)
    {
        $this->db->where('id_kebutuhan_detail', $id_kebutuhan_detail);
        $this->db->update('k3.k3_kebutuhan_detail', $lines);
        return;
    }

    public function update_kebutuhan_pekerja($tbl_pekerja, $id_kebutuhan_detail)
    {
        $this->db->where('id_kebutuhan_detail', $id_kebutuhan_detail);
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
        $this->db->where('id_kebutuhan_detail', $id_kebutuhan_detail);
        $this->db->delete('k3.k3_kebutuhan_detail');
        return;
    }
    public function delete_apd2($id_kebutuhan_detail)
    {
        $this->db->where('id_kebutuhan_detail', $id_kebutuhan_detail);
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
        $query = $this->db->query("select * from k3.k3_kebutuhan_detail tb1 join k3.k3_kebutuhan tb2 on
                                    tb1.id_kebutuhan = tb2.id_kebutuhan join k3.k3_kebutuhan_pekerja tb3 on
                                    tb1.id_kebutuhan_detail = tb3.id_kebutuhan_detail where tb2.kodesie = '$kode_seksi'
                                    order by tb1.status_updated desc");
        return $query->result_array();
    }

    public function updateDocumentApproval($nama_file, $id_kebutuhan)
    {
        $sql = "update k3.k3_kebutuhan set document_approval = '$nama_file' where id_kebutuhan = $id_kebutuhan";
        $this->db->query($sql);
        return;
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
        $kodesie = substr($kodesie, 0, 7);
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
        if (gettype($kodesie) == 'string') {
            $kodesie = substr($kodesie, 0, 7);
        } elseif (gettype($kodesie) == 'array') {
            $kodesie = implode("', '", $kodesie);
        }
        // $kodesie = substr($kodesie, 0,7);
        $sql = "select ks.*, km.item from k3.k3n_standar_kebutuhan ks
        left join k3.k3_master_item km on km.kode_item = ks.kode_item
        where status = '0' and ks.kodesie in ('$kodesie') order by tgl_input desc";
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
        $kodesie = substr($kodesie, 0, 7);
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
        $kodesie = substr($ks, 0, 7);
        $pr = date('Y-m');
        $pr = date('Y-m', strtotime($pr . "+1 month"));
        $sql = "select * from k3.k3n_order where kodesie like '$kodesie%' and periode = '$pr'";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        // return $query->result_array();
        return $query->num_rows();
    }

    public function listmonitor($ks, $pr)
    {
        $ks = substr($ks, 0, 7);
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
        $query = $this->oracle->query($sql);
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
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    function lokasi()
    {
        $sql = "select
                hla.LOCATION_ID,
                hla.LOCATION_CODE,
                hla.ADDRESS_LINE_1
                from HR_LOCATIONS_ALL hla
                where hla.LOCATION_ID in (29650,142,182,17204,16103,3089,3090,3091,3092)
                order by 2";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    function gudang($lokasi)
    {
        $sql = " SELECT
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
        $query = $this->oracle->query($sql);
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
        $sql = "select
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
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }


    function account($fungsi, $cost)
    {
        $cost = substr($cost, 0, 1);

        $sql = "SELECT kba.ACCOUNT_NUMBER
                FROM  khs_bppbg_account_v2 kba
                WHERE kba.USING_CATEGORY_CODE LIKE '$fungsi'
                AND COST_CENTER_PREFIX = '$cost'";
        $query = $this->oracle->query($sql);
        // echo $sql;
        return $query->row()->ACCOUNT_NUMBER;
    }

    public function cekOrder($ks, $pr)
    {
        $ks = substr($ks, 0, 7);
        $sql = "select * from k3.k3n_order where kodesie like '$ks%' and periode = '$pr' and status = '1';";
        // echo $sql;exit();
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function maxPekerja($kodesie)
    {
        $ks = substr($kodesie, 0, 7);
        $sql = "select * from hrd_khs.tpribadi
                where keluar = '0'
                and kodesie like '$ks%'";
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function getPekerja($ks)
    {
        $ks = substr($ks, 0, 7);
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
        $ks = substr($kodesie, 0, 7);
        $sql = "Select * from k3.k3n_email_seksi where kodesie like '%$ks%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function addEmailSeksi($email, $kodesie, $noind)
    {
        $tgl = date('Y-m-d H:i:s');
        $ks = substr($kodesie, 0, 7);
        $sql = "insert into k3.k3n_email_seksi (kodesie, email, last_update_by, last_update_date) values ('$ks', '$email', '$noind', '$tgl');";
        $query = $this->erp->query($sql);
        return true;
    }

    public function editEmailSeksi($id, $email, $noind)
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

    public function getTrefjabatan($noind)
    {
        $sql = "select
                    substring(t.kodesie,0,8) kodesie,
                    ts.seksi
                from
                    hrd_khs.trefjabatan t
                left join hrd_khs.tseksi ts on
                    ts.kodesie = t.kodesie
                where
                    noind = '$noind'
                group by
                    t.kodesie ,
                    ts.seksi";
        return $this->personalia->query($sql)->result_array();
    }

    public function cekSeksiDibawah($ks)
    {
        //seksi di bawahnya yang tidak memiliki atasan
        $ks = substr($ks, 0, 5);
        $sql = "select
                    distinct(substring(kodesie,1,7)) kodesie,
                    seksi
                from
                    hrd_khs.tseksi ts
                where
                    ts.kodesie like '$ks%'
                    and (select
                        count(noind)
                    from
                        hrd_khs.tpribadi t
                    where
                        t.keluar = false
                        and substring(t.kodesie,1,7) = substring(ts.kodesie,1,7)
                        and substring(noind, 1, 1) in ('B','D','J')) = 0";
        return $this->personalia->query($sql)->result_array();
    }

    public function cekSeksiDibawah2($ks)
    {
        //seksi di bawahnya yang tidak memiliki atasan
        $ks = substr($ks, 0, 6);
        $sql = "select
                    distinct(substring(kodesie,1,7)) kodesie,
                    seksi
                from
                    hrd_khs.tseksi ts
                where
                    ts.kodesie like '$ks%'
                    and (select
                        count(noind)
                    from
                        hrd_khs.tpribadi t
                    where
                        t.keluar = false
                        and substring(t.kodesie,1,7) = substring(ts.kodesie,1,7)
                        and substring(noind, 1, 1) in ('B','D','J')) = 0
                    and (select
                        count(noind)
                    from
                        hrd_khs.tpribadi t
                    where
                        t.keluar = false
                        and substring(t.kodesie,1,5) = substring(ts.kodesie,1,5)
                        and substring(noind, 1, 1) in ('B','D','J')
                        and t.kd_jabatan <= '08') = 0";
                        // echo $sql;exit();
        return $this->personalia->query($sql)->result_array();
    }

    public function getTertinggi($ks)
    {
        //tertinggi di kodesi 6 digit
        $ks = substr($ks, 0, 6);
        $sql = "select
                    trim(noind) noind,
                    nama,
                    kodesie,
                    kd_jabatan
                from
                    hrd_khs.tpribadi
                where
                    kodesie like '$ks%'
                    and keluar = false
                    and kd_jabatan = (
                    select
                        min(kd_jabatan) kd_jabatan
                    from
                        hrd_khs.tpribadi
                    where
                        kodesie like '$ks%'
                        and keluar = false)";
         return $this->personalia->query($sql)->row()->noind;
    }

    /**
     * DK -> bon sepatu safety
     */
    /**
     *  @params: null
     *  @return Array<Array>
     */
    public function getSafetyShoes($kode_gudang = 'PNL-DM')
    {
        $sql = "SELECT msib.inventory_item_id, msib.segment1 item_code, msib.description,
                    khs_inv_qty_att ('102', msib.inventory_item_id, '$kode_gudang', '', '') stock,
                    msib.PRIMARY_UOM_CODE uom
                FROM mtl_system_items_b msib
                WHERE msib.organization_id = '102'
                    AND msib.inventory_item_status_code = 'Active'
                    AND msib.segment1 IN
                        (
                            'PP1AA42', 'PP1AA43', 'PP1AA01', 'PP1AA02', 'PP1AA03', 'PP1AA04',
                            'PP1AA05', 'PP1AA06', 'PP1AA07', 'PP1AA08', 'PP1AA09', 'PP1AA10',
                            'PP1AA11', 'PP1AA12', 'PP1AA13', 'PP1AA14', 'PP1AA15', 'PP1AA16',
                            'PP1AA17', 'PP1AA18', 'PP1AA19', 'PP1AA20', 'PP1AA21', 'PP1AA22',
                            'PP1AA23', 'PP1AA24', 'PP1AA25', 'PP1AA26', 'PP1AA27', 'PP1AA28',
                            'PP1AA29', 'PP1AA30', 'PP1AA31', 'PP1AC01', 'PP1AC07', 'PP1TS05',
                            'PP1AC05', 'PP1KR02', 'PP1KR05', 'PP1KR04', 'PP1KE01', 'PP1KE02',
                            'PP1KR03', 'PP1BS02', 'PP1BS01', 'PP1BS04', 'PP1KR01', 'PP1KR09',
                            'PP1AC04', 'PP1KR06', 'PP1TS06'
                        )
                    AND msib.DESCRIPTION LIKE 'SEPATU%'
                ORDER BY msib.description";
        return $this->oracle->query($sql)->result_array();
    }

    /** 
     *  @params: String kode gudang
     *  @return: Array
     */
    public function getStockSafetyShoes($gudang)
    {
        $sql = "SELECT msib.inventory_item_id, msib.segment1 item_code, msib.description,
                    khs_inv_qty_att ('102', msib.inventory_item_id, '$gudang', '', '') stock,
                    msib.PRIMARY_UOM_CODE uom
                FROM mtl_system_items_b msib
                WHERE msib.organization_id = '102'
                    AND msib.inventory_item_status_code = 'Active'
                    AND msib.segment1 IN
                        (
                            'PP1AA42', 'PP1AA43', 'PP1AA01', 'PP1AA02', 'PP1AA03', 'PP1AA04',
                            'PP1AA05', 'PP1AA06', 'PP1AA07', 'PP1AA08', 'PP1AA09', 'PP1AA10',
                            'PP1AA11', 'PP1AA12', 'PP1AA13', 'PP1AA14', 'PP1AA15', 'PP1AA16',
                            'PP1AA17', 'PP1AA18', 'PP1AA19', 'PP1AA20', 'PP1AA21', 'PP1AA22',
                            'PP1AA23', 'PP1AA24', 'PP1AA25', 'PP1AA26', 'PP1AA27', 'PP1AA28',
                            'PP1AA29', 'PP1AA30', 'PP1AA31', 'PP1AC01', 'PP1AC07', 'PP1TS05',
                            'PP1AC05', 'PP1KR02', 'PP1KR05', 'PP1KR04', 'PP1KE01', 'PP1KE02',
                            'PP1KR03', 'PP1BS02', 'PP1BS01', 'PP1BS04', 'PP1KR01', 'PP1KR09',
                            'PP1AC04', 'PP1KR06', 'PP1TS06'
                        )
                    AND msib.DESCRIPTION LIKE 'SEPATU%'
                ORDER BY msib.description";
        return $this->oracle->query($sql)->result_array();
    }

    /**
     *  @params: String nomor apd, String $gudang
     *  @return: Object
     */
    public function getStockSafetyShoesById($no_apd, $gudang)
    {
        $sql = "SELECT msib.inventory_item_id, msib.segment1 item_code, msib.description,
                    khs_inv_qty_att ('102', msib.inventory_item_id, '$gudang', '', '') stock,
                    msib.PRIMARY_UOM_CODE uom
                FROM mtl_system_items_b msib
                WHERE msib.organization_id = '102'
                    AND msib.inventory_item_status_code = 'Active'
                    AND msib.segment1 = '$no_apd'
                ORDER BY msib.description";
        return $this->oracle->query($sql)->row();
    }

    /** 
     * @params: String -> kodesie, String -> keyword, Array -> except worker
     * @return Array<Array>
     */
    public function getSemuaPekerja($kodesie, $q, $exceptWorker)
    {
        $this->personalia
            ->select(['noind', 'nama', 'kodesie'])
            ->where('keluar', '0')
            ->where_not_in('noind', $exceptWorker)
            ->like('kodesie', substr($kodesie, 0, 7), 'after')
            ->group_start()
            ->like('noind', $q, 'after')
            ->or_like('nama', strtoupper($q), 'after')
            ->group_end()
            ->limit(10)
            ->get_compiled_select('hrd_khs.tpribadi', FALSE);

        return $this->personalia->get()->result_array();
    }

    /** 
     * @params: String -> nomor induk
     * @return Object
     */
    public function getLatestBonSafetyShoes($noind)
    {
        $sql = "SELECT noind, seksi, create_timestamp::date as date, no_bon FROM k3.tbon_sepatu WHERE noind = '$noind' ORDER BY create_timestamp DESC LIMIT 1";
        return $this->db->query($sql)->row();
        // abaikan
        $this->db
            ->select(['noind', 'seksi', 'create_timestamp as "date"'])
            ->where('noind', $noind)
            ->limit(1)
            ->order_by('create_timestamp', 'DESC')
            ->get_compiled_select('k3.tbon_sepatu', FALSE);
        return $this->db->get()->row();
    }

    /**
     * @insert ke database postgre k3 & oracle
     * @params: Array [[noind, item_code]], String Nobon
     * @return Boolean
     */
    public function insertBonSafetyShoes($data, $nobon)
    {
        $logged_user = $this->session->user;
        $user_logged = $this->session->user;
        $lokasi = '142';
        $gudang = 'PNL-NPR';
        $lokator = '783';

        $pkj_lok = $this->getDetailPekerja($user_logged)->row()->lokasi_kerja;
        if (intval($pkj_lok) == 2) {
            $lokasi = '16103';
            $gudang = 'PNL-TKS';
        } else {
            $lokasi = '142';
            $gudang = 'PNL-DM';
        }

        try {
            foreach ($data as $item) {
                $apd = $this->getStockSafetyShoesById($item['item_code'], $gudang);
                $sepatu = trim(substr($apd->DESCRIPTION, 0, strlen($apd->DESCRIPTION) - 2));
                $ukuran = trim(substr($apd->DESCRIPTION, -2, 2));

                $terakhir_bon = $this->getLatestBonSafetyShoes($item['noind']);

                $terakhir_bon = $terakhir_bon ? date('d-m-Y', strtotime($terakhir_bon->date)) : '';

                $sql = "SELECT 
                        tp.noind, tp.nama, tp.kodesie, ts.seksi, tpk.pekerjaan, '$ukuran' uk_sepatu, '{$item['item_code']}' item_code, '$sepatu' jenis_sepatu, now() create_timestamp, '$logged_user' user_, '$nobon' no_bon
                    FROM 
                        hrd_khs.tpribadi tp 
                        inner join hrd_khs.tseksi ts on tp.kodesie = ts.kodesie
                        left join hrd_khs.tpekerjaan tpk on tp.kd_pkj = tpk.kdpekerjaan
                    WHERE 
                        noind = '{$item['noind']}'
                    ";
                $item_data = $this->personalia->query($sql)->result_array()['0'];

                // oracle
                $generate_new_id = $this->M_dtmasuk->getIdOr();
                $cost_center = $this->getCostCenter($item_data['kodesie']);
                $account = $this->account('APD', $cost_center);
                $kode_cabang = $this->pemakai_2($cost_center);

                $nick_name = implode(' ', array_slice(explode(' ', $item_data['nama']), 0, 2));

                $dataBonOracle = array(
                    'NO_ID'          =>    $generate_new_id,
                    'KODE_BARANG'    =>    $item_data['item_code'],
                    'NAMA_BARANG'    =>    $item_data['jenis_sepatu'] . " " . $item_data['uk_sepatu'],
                    'SATUAN'         =>    'SET',
                    'PERMINTAAN'     =>    1,
                    'KETERANGAN'     =>    $item['noind'] . " - $nick_name ({$item['reason']}) | $terakhir_bon",
                    'COST_CENTER'    =>    $cost_center,
                    'PENGGUNAAN'     =>    'SAFETY SHOES',
                    'SEKSI_BON'      =>    $item_data['seksi'],
                    'TUJUAN_GUDANG'  =>    $gudang,
                    'TANGGAL'        =>    date('d M Y'),
                    'NO_BON'         =>    $nobon,
                    'PEMAKAI'        =>    $cost_center,
                    'JENIS_PEMAKAI'  =>    'Seksi',
                    'LOKASI'         =>    $lokasi,
                    'LOKATOR'        =>    $lokator,
                    'ACCOUNT'        =>    $account,
                    'KODE_CABANG'    =>    $kode_cabang['0']['KODE_CABANG'],
                    'EXP'            =>    'N',
                );
                $this->insertBonIm($dataBonOracle);

                // postgre k3_bon
                $data_bon = [
                    'tgl_bon' => date('Y-m-d H:i:s'),
                    'periode' => date('Y-m'),
                    'kodesie' => substr($item_data['kodesie'], 0, 7),
                    'item_code' => $item_data['item_code'],
                    'jml_bon' => 1,
                    'input_by' => $logged_user,
                    'jml_kebutuhan' => NULL,
                    'sisa_saldo' => NULL,
                    'no_bon' => $nobon,
                ];

                // insert k3n_bon
                $this->db->insert('k3.k3n_bon', $data_bon);
                // id k3n_bon terakhir
                $id = $this->db->insert_id();
                $item_data['id'] = $id;

                unset($item_data['kodesie']);
                $item_data['id_oracle'] = $generate_new_id;
                $item_data['alasan'] = $item['reason'];
                // insert t_bon sepatu
                $this->db->insert('k3.tbon_sepatu', $item_data);
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @params: String nomor bon
     * @return Array
     */
    public function getBonSafetyShoesById($no_bon)
    {
        $sql = "SELECT tbs.*, ers.oracle_cost_code
                FROM k3.tbon_sepatu tbs
                    inner join er.er_employee_all era on era.employee_code = tbs.noind
                    inner join er.er_section ers on ers.section_code = era.section_code
                WHERE tbs.no_bon = '$no_bon'";
        return $this->db->query($sql)->result_array();

        // hmm useless
        $this->db->where('no_bon', $no_bon);
        return $this->db->get('k3.tbon_sepatu')->result_array();
    }

    /**
     * @params: String kodesie
     * @return String cost_center
     */
    public function getCostCenter($kodesie)
    {
        $sql = "SELECT ers.oracle_cost_code
                FROM  er.er_section ers
                WHERE ers.section_code = '$kodesie'";
        return $this->db->query($sql)->row()->oracle_cost_code;
    }

    /**
     * @insert ke database oracle
     * @params: Array Bon
     * @return void
     */
    public function insertBonIm($data)
    {
        $this->oracle->trans_start();
        $this->oracle->insert('IM_MASTER_BON', $data);
        $this->oracle->trans_complete();
    }

    // /*

    // */
    // public function getBonSepatu($month, $section)
    // {
    //     $sql = "SELECT ts.*
    //             FROM k3.tbon_sepatu ts 
    //                 inner join er.er_employee_all era on era.employee_code = ts.noind
    //             WHERE 
    //                 era.section_code like '$section%'
    //             and to_char(ts.create_timestamp, 'YYYY-MM') = '$month'
    //     ";
    //     $tbon_sepatu = $this->db->query($sql)->result_array();
    // }

    public function getNobondtl($nobon)
    {
        $sql = "SELECT * from k3.tbon_sepatu where no_bon = '$nobon'";
        return $this->db->query($sql)->result_array();
    }

    public function getBonSpt($id)
    {
        $sql = "SELECT * from k3.tbon_sepatu where id_oracle = '$id'";
        $row = $this->db->query($sql)->num_rows();
        if ($row == 1) {
            return $this->db->query($sql)->row_array();
        }else{
            echo "Terdapat Anomali Data";exit();
        }
    }

    public function insertHpsBonSpt($data)
    {
        $this->db->insert('k3.tbon_sepatu_hapus', $data);
        return $this->db->affected_rows();
    }

    public function delSptPost($id)
    {
        $this->db->where('id_oracle', $id);
        $this->db->delete('k3.tbon_sepatu');
        return $this->db->affected_rows();
    }

    public function delSptOrc($id)
    {
        $this->oracle->where('NO_ID', $id);
        $this->oracle->delete('APPS.IM_MASTER_BON');
        return $this->oracle->affected_rows();
    }
}
