<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Dtmasuk extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia   =   $this->load->database('personalia', TRUE);
        $this->erp          =   $this->load->database('erp_db', TRUE);
        $this->oracle          =   $this->load->database('oracle', TRUE);
    }

    public function daftar_seksi($tgl, $tahun)
    {
        $query = "select distinct left(kb.kodesie, 7) kodesie, es.section_name seksi from k3.k3_kebutuhan kb
					join er.er_section es on es.section_code = kb.kodesie
					where extract(month from kb.create_timestamp) = '$tgl' 
					and extract (year from kb.create_timestamp) = '$tahun'
					order by es.section_name asc";
        // echo $query;
        // exit();
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function daftar_apd($seksi, $tgl, $tahun)
    {
        // print_r($seksi);
        // exit();
        $query = "select km.*, 
	";

        $k = '1';
        foreach ($seksi as $row) {
            $no = $row['kodesie'];
            // $k = 1;
            $query = $query . "(select sum(kd1.ttl_order) from k3.k3_kebutuhan k1 
		inner join k3.k3_kebutuhan_detail kd1 on k1.id_kebutuhan = kd1.id_kebutuhan 
		where km.kode_item = kd1.kode_item 
		and extract(month from kd1.create_date) = '$tgl' 
		and extract (year from kd1.create_date) = '$tahun'
		and k1.kodesie like '$no%') a$k, ";
            $k++;
        }
        $query = $query . " (select sum(kd.ttl_order) 
		from k3.k3_kebutuhan_detail kd 
		where km.kode_item = kd.kode_item
		and extract(month from kd.create_date) = '$tgl' 
		and extract (year from kd.create_date) = '$tahun') jumlah_total from k3.k3_master_item km
		order by km.item asc";
        // echo $query;
        // exit();
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getSeksiApprove($item)
    {
        $sql = "select section_name, substring(section_code,0,8) section_code from er.er_section 
        where section_code like '%$item%' or section_name like '%$item%'
        group by section_name, substring(section_code,0,8) ";
        // echo $sql;exit();
        $query = $this->erp->query($sql);

        return $query->result_array();
    }

    public function getSeksiApprove2($item)
    {
        $sql = "select substring(section_code,0,8), section_name from er.er_section
                where section_name not in('-', '')
                group by section_name, substring(section_code,0,8)
                order by section_name";
        // echo $sql;exit();
        $query = $this->erp->query($sql);

        return $query->result_array();
    }

    public function getListAprove($ks, $baru)
    {
        $ks = substr($ks, 0, 7);
        // $sql = "select ks.id, ks.kode_item, ks.jml_item, km.item from k3.k3n_standar_kebutuhan ks
        // left join k3.k3_master_item km on km.kode_item = ks.kode_item
        // where status = '3' and ks.kodesie like '$ks%' and tgl_approve_tim = '$baru' order by tgl_input desc";
        // echo $sql;exit();
        $sql = "select distinct ks.kode_item, km.item from k3.k3n_standar_kebutuhan ks left join
                k3.k3_master_item km on km.kode_item = ks.kode_item
                where status = '3' and ks.kodesie like '$ks%' order by km.item asc";
        $result = $this->erp->query($sql)->result_array();
        $data = array();
        $angka = 0;
        foreach ($result as $key) {
            $sql = "select ks.*, km.item from k3.k3n_standar_kebutuhan ks
				left join k3.k3_master_item km on km.kode_item = ks.kode_item
				where status = '3' and ks.kodesie like '$ks%' and ks.kode_item = '" . $key['kode_item'] . "'
				order by tgl_approve_tim desc
				limit 1;";
            $query = $this->erp->query($sql)->result_array();
            foreach ($query as $value) {
                $data[$angka] = $value;
            }
            $angka++;
        }
        return $data;
    }

    public function cekseksi($ks)
    {
        $sql = "select section_code, section_name from er.er_section where section_code like '$ks%' limit 1";
        $query = $this->erp->query($sql);
        // echo $sql;exit();
        return $query->result_array();
    }

    public function listToApprove($ks, $pr, $app)
    {
        $sql = "select
                    ks.*,
                    km.item
                from
                    k3.k3n_standar_kebutuhan ks
                left join k3.k3_master_item km on
                    km.kode_item = ks.kode_item
                where
                    tgl_approve = '$app'
                    and tgl_input::date = '$pr'
                    and ks.status = 1
                    and ks.kodesie like '$ks%'
                order by
                    km.item,
                    ks.tgl_approve asc";
        // echo $sql;exit();
        $query = $this->erp->query($sql);

        return $query->result_array();
    }

    public function listDahApprove($ks, $pr)
    {
        $sql = "select
                    kb.kode_item,
                    km.item,
                    kb.kd_pekerjaan,
                    kb.jml_item,
                    kb.jml_kebutuhan_staff,
                    kb.jml_kebutuhan_umum,
                    kb.kodesie,
                    kb.tgl_approve_tim,
                    kb.keterangan,
                    kb.lampiran
                from
                    k3.k3n_standar_kebutuhan kb,
                    k3.k3_master_item km
                where
                    kb.kode_item = km.kode_item
                    and kb.kodesie like '$ks%'
                    and kb.status = 3
                    and tgl_approve_tim = (
                    select
                        max(kb2.tgl_approve_tim)
                    from
                        k3.k3n_standar_kebutuhan kb2
                    where
                        kb2.kodesie = kb.kodesie
                        and kb2.status = kb.status
                        and kb.kode_item = kb2.kode_item )
                order by 2";
        // echo $sql;exit();
        $query = $this->erp->query($sql);

        return $query->result_array();
    }

    public function daftarKerjaan($ks)
    {
        $sql = "select *, km.item from k3.k3n_standar_kebutuhan ks 
		left join k3.k3_master_item km on km.kode_item = ks.kode_item
		where cast(tgl_approve as varchar) like '$pr%' and ks.kodesie like '$ks%'";
        $query = $this->erp->query($sql);

        return $query->result_array();
    }

    public function updateTIM($id, $action, $noind)
    {

        $tgl = date('Y-m-d H:i:s');
        $sql = "update k3.k3n_standar_kebutuhan set status = '$action', tgl_approve_tim = '$tgl', approve_tim_by = '$noind'
    			where id = '$id'";
        $query = $this->erp->query($sql);
    }

    public function cek_terbaru($ks)
    {
        $sql = "select tgl_approve_tim from k3.k3n_standar_kebutuhan
				where tgl_approve_tim is not null and kodesie like '$ks%' and status = '3'
				order by tgl_approve_tim desc limit 1;";
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function getOrder($pr)
    {
        $sql = " select 
                    ko.status,
                    es.section_name,
                    substring(es.section_code, 0, 8) section_code
                from
                    k3.k3n_order ko
                left join er.er_section es on
                    substring(es.section_code, 0, 8) = substring(ko.kodesie, 0, 8)
                where
                    ko.periode = '$pr'
                    and ko.tgl_input = (select max(ko2.tgl_input) from k3.k3n_order ko2 where ko2.kodesie = ko.kodesie and ko2.periode = ko.periode)
                group by
                    es.section_name,
                    ko.status, ko.tgl_input,
                    substring(es.section_code, 0, 8)
                order by
                    es.section_name asc;";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function getOrder2($pr)
    {
        $sql = "select
                    distinct ko.kodesie,
                    es.section_name
                from
                    k3.k3n_order ko,
                    er.er_section es
                where
                    substring(es.section_code, 1, 7) = ko.kodesie
                    and ko.kodesie not in (
                        select distinct ks.kodesie
                    from
                        k3.k3n_standar_kebutuhan ks)
                order by 2;";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function listtobon($ks, $pr)
    {
        $ks = substr($ks, 0, 7);
        // $sql = "select
        //             mon.periode ,
        //             mon.item_kode ,
        //             mon.item ,
        //             sum(to_number(mon.jml_kebutuhan, '999G999D9S')) jml_kebutuhan ,
        //             sum(mon.ttl_bon) ttl_bon ,
        //             sum(mon.sisa_saldo) sisa_saldo
        //         from
        //             (
        //                 select kh.*,
        //                 km.item,
        //                 coalesce(bon.ttl_bon, 0) ttl_bon,
        //                 to_number(kh.jml_kebutuhan, '999G999D9S')-coalesce(bon.ttl_bon, 0) sisa_saldo
        //             from
        //                 k3.k3_master_item km,
        //                 k3.k3n_hitung kh
        //             left join (
        //                 select
        //                     kb.periode,
        //                     kb.item_code,
        //                     sum(to_number(kb.jml_bon, '999G999D9S')) ttl_bon
        //                 from
        //                     k3.k3n_bon kb
        //                 where
        //                     kb.periode = '$pr'
        //                 group by
        //                     kb.periode,
        //                     kb.item_code) bon on
        //                 kh.item_kode = bon.item_code
        //             where
        //                 km.kode_item = kh.item_kode
        //                 and kh.periode = '$pr'
        //                 and kh.kodesie like '$ks%') mon
        //         group by
        //             mon.periode ,
        //             mon.item_kode ,
        //             mon.item";
        $sql = "select
                    a.*,
                    b.jml_pekerja,
                    b.periode,
                    coalesce(bon.ttl_bon, 0) bon,
                    b.jml_pekerja_staff
                from
                    (
                        select km.item,
                        ks.jml_kebutuhan_umum, 
                        ks.jml_kebutuhan_staff,
                        km.satuan,
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
                        sum(to_number(kb.jml_bon, '999G999D9S')) ttl_bon
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

    public function listtobon2($ks, $pr)
    {
        $ks = substr($ks, 0, 7);
        $sql = "select
                    mon.periode ,
                    mon.item_kode ,
                    mon.item ,
                    sum(mon.jml_kebutuhan) jml_kebutuhan ,
                    sum(mon.ttl_bon) ttl_bon ,
                    sum(mon.sisa_saldo) sisa_saldo
                from
                    (
                    select
                        kh.periode,
                        kh.item_kode,
                        km.item,
                        sum(kh.jml_kebutuhan::int) jml_kebutuhan,
                        coalesce(bon.ttl_bon, 0) ttl_bon,
                        sum(kh.jml_kebutuhan::int)-coalesce(bon.ttl_bon, 0) sisa_saldo
                    from
                        k3.k3_master_item km,
                        k3.k3n_hitung kh
                    left join (
                        select
                            kb.periode,
                            kb.kodesie,
                            kb.item_code,
                            sum(jml_bon::int) ttl_bon
                        from
                            k3.k3n_bon kb
                        where
                            kb.kodesie like '$ks%'
                            and kb.periode = '$pr'
                        group by
                            kb.periode,
                            kb.kodesie,
                            kb.item_code) bon on
                        kh.kodesie = bon.kodesie
                        and kh.item_kode = bon.item_code
                        and kh.periode = bon.periode
                    where
                        kh.item_kode = km.kode_item
                        and kh.periode = '$pr'
                        and kh.kodesie like '$ks%'
                    group by
                        kh.periode,
                        kh.item_kode,
                        km.item,
                        bon.ttl_bon) mon
                group by
                    mon.periode ,
                    mon.item_kode ,
                    mon.item
                order by
                    3";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function listtobonHitung($ks, $pr)
    {
        $ks = substr($ks, 0, 7);
        $sql = "select
                    kh.periode,
                    kh.item_kode kode_item,
                    km.item,
                    kh.jml_kebutuhan,
                    km.satuan,
                    sum(coalesce(bon.jml_bon::int, 0)) bon
                from
                    k3.k3n_hitung kh
                left join k3.k3n_bon bon on
                    kh.periode = bon.periode
                    and kh.kodesie = bon.kodesie
                    and kh.item_kode = bon.item_code ,
                    k3.k3_master_item km
                where
                    kh.item_kode = km.kode_item
                    and kh.kodesie like '$ks%'
                    and kh.periode = '$pr'
                group by
                    kh.periode,
                    kh.item_kode,
                    km.item,
                    km.satuan,
                    kh.jml_kebutuhan
                order by
                    3";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function listtobonHitung2($ks, $pr)
    {
        $ks = substr($ks, 0, 7);
        $sql = "select
                    a.periode,
                    a.kode_item item_kode,
                    a.item,
                    sum(a.jml_kebutuhan::int) jml_kebutuhan,
                    sum(a.bon) ttl_bon,
                    sum(a.sisa_saldo) sisa_saldo
                from
                    (
                        select kh.periode,
                        kh.item_kode kode_item,
                        km.item,
                        kh.kodesie,
                        kh.jml_kebutuhan,
                        sum(coalesce(bon.jml_bon::int, 0)) bon,
                        kh.jml_kebutuhan::int - sum(coalesce(bon.jml_bon::int, 0)) sisa_saldo
                    from
                        k3.k3n_hitung kh
                    left join k3.k3n_bon bon on
                        kh.periode = bon.periode
                        and kh.kodesie = bon.kodesie
                        and kh.item_kode = bon.item_code ,
                        k3.k3_master_item km
                    where
                        kh.item_kode = km.kode_item
                        and kh.periode = '$pr'
                    group by
                        kh.periode,
                        kh.item_kode,
                        kh.jml_kebutuhan,
                        km.item,
                        kh.kodesie) a
                where
                    a.kodesie like '$ks%'
                group by
                    a.periode,
                    a.kode_item,
                    a.item
                order by
                    3";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        return $query->result_array();
    }
    public function listperhitungan($pr)
    {
        $minPr = explode('-', $pr);
        $y = $minPr[0];
        $m = ($minPr[1] - 1);
        if (strlen($m) < 2) {
            $m = '0' . $m;
        }

        if ($m == '0' || $m == '00') {
            $m = '12';
            $y = $y - 1;
        }
        $newPr = $y . '-' . $m;
        $sql = "select
                    mon.periode ,
                    mon.item_kode ,
                    mon.item ,
                    sum(mon.jml_kebutuhan) jml_kebutuhan ,
                    sum(mon.ttl_bon) ttl_bon ,
                    sum(mon.sisa_saldo) sisa_saldo
                from
                    (
                    select
                        kh.periode,
                        kh.item_kode,
                        km.item,
                        sum(kh.jml_kebutuhan::int) jml_kebutuhan,
                        coalesce(bon.ttl_bon, 0) ttl_bon,
                        sum(kh.jml_kebutuhan::int)-coalesce(bon.ttl_bon, 0) sisa_saldo
                    from
                        k3.k3_master_item km,
                        k3.k3n_hitung kh
                    left join (
                        select
                            kb.periode,
                            kb.item_code,
                            sum(jml_bon::int) ttl_bon
                        from
                            k3.k3n_bon kb
                        where
                            kb.kodesie like '%'
                            and kb.periode = '$newPr'
                        group by
                            kb.periode,
                            kb.item_code) bon on
                        kh.item_kode = bon.item_code
                    where
                        kh.item_kode = km.kode_item
                        and kh.periode = '$pr'
                        and kh.kodesie like '%'
                    group by
                        kh.periode,
                        kh.item_kode,
                        km.item,
                        bon.ttl_bon) mon
                group by
                    mon.periode ,
                    mon.item_kode ,
                    mon.item
                order by
                    3";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function listperhitunganBySeksi($pr, $lik = 'not like')
    {
        $minPr = explode('-', $pr);
        $y = $minPr[0];
        $m = ($minPr[1] - 1);
        if (strlen($m) < 2) {
            $m = '0' . $m;
        }

        if ($m == '0' || $m == '00') {
            $m = '12';
            $y = $y - 1;
        }
        $newPr = $y . '-' . $m;
        $sql = "select
                    mon.periode ,
                    mon.item_kode ,
                    mon.item ,
                    sum(mon.jml_kebutuhan) jml_kebutuhan ,
                    sum(mon.ttl_bon) ttl_bon ,
                    sum(mon.sisa_saldo) sisa_saldo,
                    mon.list_no_bon
                from
                    (
                    select
                        kh.periode,
                        kh.item_kode,
                        km.item,
                        sum(kh.jml_kebutuhan::int) jml_kebutuhan,
                        coalesce(bon.ttl_bon, 0) ttl_bon,
                        sum(kh.jml_kebutuhan::int)-coalesce(bon.ttl_bon, 0) sisa_saldo,
                        bon.list_no_bon
                    from
                        k3.k3_master_item km,
                        k3.k3n_hitung kh
                    left join (
                        select
                            kb.periode,
                            kb.item_code,
                            sum(jml_bon::int) ttl_bon,
                            string_agg(kb.no_bon::text, ',') list_no_bon
                        from
                            k3.k3n_bon kb
                        where
                            kb.periode = '$newPr'
                            and kb.kodesie in (
                            select
                                distinct(substring(section_code , 0, 8) ) kodesie
                            from
                                er.er_section es
                            where
                                trim(section_name) $lik '%TKS')
                        group by
                            kb.periode,
                            kb.item_code) bon on
                        kh.item_kode = bon.item_code
                    where
                        kh.item_kode = km.kode_item
                        and kh.periode = '$pr'
                        and kh.kodesie in (
                        select
                            distinct(substring(section_code , 0, 8) ) kodesie
                        from
                            er.er_section es
                        where
                            trim(section_name) $lik '%TKS')
                    group by
                        kh.periode,
                        kh.item_kode,
                        km.item,
                        bon.list_no_bon,
                        bon.ttl_bon) mon
                group by
                    mon.periode ,
                    mon.item_kode ,
                    mon.item,
                    mon.list_no_bon
                order by
                    3;";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function insertBon($data)
    {
        $query = $this->db->insert('k3.k3n_bon', $data);
    }

    public function getIdOr()
    {
        $sql = "SELECT max(NO_ID) baris from im_master_bon";

        $query = $this->oracle->query($sql);
        return $query->row()->BARIS + 1;
    }

    public function insertBonIm($data)
    {
        $this->oracle->trans_start();
        $this->oracle->insert('IM_MASTER_BON', $data);
        $this->oracle->trans_complete();
        // $query = $this->oracle->insert('im_master_bon', $data);
    }

    public function getlistHitung($pr, $ks)
    {
        $sql = "select
                    ks.jml_kebutuhan_staff,
                    ks.jml_kebutuhan_umum,
                    km.item,
                    ks.kode_item,
                    ks.kd_pekerjaan,
                    ks.jml_item,
                    ks.kodesie,
                    ks.tgl_approve_tim,
                    ko.jml_pekerja,
                    ko.periode,
                    ko.jml_pekerja_staff
                from
                    k3.k3_master_item km,
                    (
                        select ko.jml_pekerja_staff,
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
                        and periode = '$pr') ko,
                    k3.k3n_standar_kebutuhan ks
                inner join (
                        select substring(ks2.kodesie, 0, 8),
                        ks2.kode_item,
                        max(ks2.tgl_approve_tim) maks
                    from
                        k3.k3n_standar_kebutuhan ks2
                    where
                        ks2.status = 3
                    group by
                        ks2.kode_item,
                        substring(ks2.kodesie, 0, 8)) kz on
                    ks.kode_item = kz.kode_item
                    and ks.tgl_approve_tim = kz.maks
                where
                    km.kode_item = ks.kode_item
                    and ks.status = 3
                    and ks.kodesie like '$ks%'
                    and substring(ks.kodesie, 0, 8) = substring(ko.kodesie, 0, 8)
                order by
                    3";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function allKs($pr, $ks = '')
    {
        $and = '';
        if (strlen($ks) > 5) {
            $and = "and ko.kodesie like '$ks%'";
        }
        $sql = "select distinct(substring(ks.kodesie,0,8)) kodesie, (select section_name from er.er_section 
                where substring(section_code,0,8) = substring(ks.kodesie,0,8) limit 1) section_name from k3.k3n_standar_kebutuhan ks
                inner join k3.k3n_order ko on substring(ko.kodesie,0,8) = substring(ks.kodesie,0,8) where ko.periode = '$pr' $and
                and ko.status = '1'
                order by 2 asc";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function inpHitung($data)
    {
        $query = $this->db->insert('k3.k3n_hitung', $data);
    }

    public function toHitung($pr)
    {
        $sql = "SELECT kh.periode, km.item, kh.item_kode, sum(to_number(kh.jml_kebutuhan,'999G999D9S')) ttl_kebutuhan, coalesce(kb.ttl_bon, '0')
                ttl_bon
                FROM k3.k3n_hitung kh left join (select periode, item_code, sum(to_number(jml_bon,'999G999D9S')) ttl_bon
                from k3.k3n_bon
                group by item_code, periode) kb on kh.item_kode = kb.item_code and kh.periode = kb.periode
                left join k3.k3_master_item km on km.kode_item = kh.item_kode 
                where kh.periode = '$pr'
                group by kh.periode, kh.item_kode, kb.ttl_bon, km.item
                order by 2";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function delPeriode($pr, $ks = '', $apd = [])
    {
        $and = '';
        if ($apd != '') {
            $apd = implode("', '", $apd);
            $and = "and item_kode in ('$apd')";
        }
        $sql = "DELETE from k3.k3n_hitung where periode = '$pr' and kodesie like '$ks%' $and";
        $query = $this->erp->query($sql);
    }

    public function getjmlSeksi()
    {
        $sql = "SELECT count (distinct substring(ks.kodesie,1,8)) FROM k3.k3n_standar_kebutuhan ks;";
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function getjmlSeksiDepan($pr)
    {
        $sql = "select count(*) from(select distinct es.section_name from k3.k3n_order ko 
                left join er.er_section es on substring(es.section_code,0,8) = substring(ko.kodesie,0,8) 
                where ko.periode = '$pr' group by es.section_name, ko.status order by es.section_name asc) jumlah;";
        $query = $this->erp->query($sql);
        return $query->row()->count;
    }

    public function detail_seksi($id_kebutuhan)
    {
        $tgl = substr($id_kebutuhan, 0, 2);
        $y = substr($id_kebutuhan, 5, 9);
        // echo $y;exit();
        $sql = "select
                    ttl.*
                from
                    (
                        select distinct substring(ks.kodesie, 0, 8) kodesie,
                        es.section_name seksi
                    from
                        k3.k3n_standar_kebutuhan ks,
                        er.er_section es
                    where
                        substring(ks.kodesie, 0, 8) = substring(es.section_code, 0, 8)) ttl
                where
                    ttl.kodesie not in (
                    select
                        substring(ko.kodesie, 0, 8)
                    from
                        k3.k3n_order ko
                    where
                        ko.periode = '$y-$tgl' 
                        ) order by 2 asc;";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function monitorbon($ks, $pr)
    {
        $sql = "select
                    kb.no_bon,
                    string_agg(mb.kode_barang, ';') kode_barang,
                    string_agg(mb.nama_barang, ';') nama_apd,
                    string_agg(kb.jml_bon, ';') jml_bon,
                    string_agg(mb.satuan, ';') satuan,
                    kb.tgl_bon,
                    kb.kodesie,
                    mb.seksi_bon seksi_pengebon,
                    mb.pemakai seksi_pemakai,
                    mb.penggunaan,
                    mb.keterangan,
                    kb.periode,
                    mb.tujuan_gudang,
                    string_agg(mb.penyerahan, ';') qty_transact,
                    string_agg(mb.flag, ';') transact
                from
                    k3.k3n_bon kb,
                    im.im_master_bon mb
                where
                    kb.no_bon = mb.no_bon
                    and kb.item_code = mb.kode_barang
                    and kb.periode = '$pr'
                    and kb.kodesie like '$ks%'
                group by
                    kb.no_bon,
                    kb.tgl_bon,
                    kb.kodesie,
                    mb.seksi_bon,
                    mb.pemakai,
                    mb.penggunaan,
                    mb.keterangan,
                    kb.periode,
                    mb.tujuan_gudang
                order by
                    1,
                    3";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function monitorbonOracle($ks, $pr)
    {
        if ($ks == '') {
            $seksi = "mb.seksi_bon like '%%'";
        } else {
            $seksi = "mb.seksi_bon = '$ks'";
        }
        $sql = "SELECT   mb.no_bon,
                         RTRIM (XMLAGG (XMLELEMENT (e, mb.kode_barang || ';') ORDER by mb.nama_barang).EXTRACT ('//text()'),';') kode_barang,
                         RTRIM (XMLAGG (XMLELEMENT (e, mb.nama_barang || ';') ORDER by mb.nama_barang).EXTRACT ('//text()'),';') nama_apd,
                         RTRIM (XMLAGG (XMLELEMENT (e, mb.permintaan || ';') ORDER by mb.nama_barang).EXTRACT ('//text()'),';') jml_bon,
                         RTRIM (XMLAGG (XMLELEMENT (e, mb.satuan || ';') ORDER by mb.nama_barang).EXTRACT ('//text()'),';') satuan,
                         mb.tanggal tgl_bon, mb.seksi_bon seksi_pengebon,
                         mb.pemakai seksi_pemakai, mb.penggunaan, mb.keterangan,
                         mb.tujuan_gudang,
                         RTRIM (XMLAGG (XMLELEMENT (e, mb.penyerahan || ';') ORDER by mb.nama_barang).EXTRACT ('//text()'),';') qty_transact,
                         RTRIM (XMLAGG (XMLELEMENT (e, mb.flag || ';') ORDER by mb.nama_barang).EXTRACT ('//text()'),';') transact
                    FROM im_master_bon mb
                   WHERE mb.keterangan LIKE '%$pr' and $seksi
                GROUP BY mb.no_bon,
                         mb.tanggal,
                         mb.seksi_bon,
                         mb.pemakai,
                         mb.penggunaan,
                         mb.keterangan,
                         mb.tujuan_gudang
                ORDER BY 1, 3";
        // $sql = "DELETE from im_master_bon where no_bon in ('920060601', '920060602', '920060603', '920060604', '920060605', '920060606')";
        // echo $sql;exit();
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getBonSafetyShoes($seksi, $periode)
    {
        $periode = $periode . '-01';
        $periode = date('M Y', strtotime($periode));
        $filterseksi = '';;
        if ($seksi == '') {
            $filterseksi = "mb.seksi_bon like '%%'";
        } else {
            $filterseksi = "mb.seksi_bon = '$seksi'";
        }

        $sql = "SELECT   mb.no_bon,
                         mb.no_id,
                         RTRIM (XMLAGG (XMLELEMENT (e, mb.kode_barang || ';') ORDER by mb.nama_barang).EXTRACT ('//text()'),';') kode_barang,
                         RTRIM (XMLAGG (XMLELEMENT (e, mb.nama_barang || ';') ORDER by mb.nama_barang).EXTRACT ('//text()'),';') nama_apd,
                         RTRIM (XMLAGG (XMLELEMENT (e, mb.permintaan || ';') ORDER by mb.nama_barang).EXTRACT ('//text()'),';') jml_bon,
                         RTRIM (XMLAGG (XMLELEMENT (e, mb.satuan || ';') ORDER by mb.nama_barang).EXTRACT ('//text()'),';') satuan,
                         mb.tanggal tgl_bon, mb.seksi_bon seksi_pengebon,
                         mb.pemakai seksi_pemakai, mb.penggunaan, mb.keterangan,
                         mb.tujuan_gudang,
                         RTRIM (XMLAGG (XMLELEMENT (e, mb.penyerahan || ';') ORDER by mb.nama_barang).EXTRACT ('//text()'),';') qty_transact,
                         RTRIM (XMLAGG (XMLELEMENT (e, mb.flag || ';') ORDER by mb.nama_barang).EXTRACT ('//text()'),';') transact
                    FROM im_master_bon mb
                   WHERE mb.tanggal LIKE '%$periode' and $filterseksi and mb.penggunaan = 'SAFETY SHOES'
                GROUP BY mb.no_bon,
                         mb.no_id,
                         mb.tanggal,
                         mb.seksi_bon,
                         mb.pemakai,
                         mb.penggunaan,
                         mb.keterangan,
                         mb.tujuan_gudang
                ORDER BY 1, 3";

        $query = $this->oracle->query($sql);
        $bonOracle =  $query->result_array();

        // cari nama
        $arr_id = array_map(function ($item) {
            return $item['NO_ID'];
        }, $bonOracle);

        // jika ada isinya
        if ($bonOracle) {
            $nama = $this->erp->select('*')->where_in('id_oracle', $arr_id)->get('k3.tbon_sepatu')->result_array();
            $nama = array_column($nama, 'nama', 'id_oracle');
            for ($i = 0; $i < count($bonOracle); $i++) {
                $bonOracle[$i]['NAMA'] = $nama[$bonOracle[$i]['NO_ID']];
            }
        }

        return $bonOracle;
    }

    public function monitorbonOracleById($id)
    {
        $query = $this->oracle->query("SELECT *
           FROM im_master_bon mb
          WHERE mb.no_bon = '$id'
        ORDER BY no_id asc");
        return $query->result_array();
    }

    public function getEmail()
    {
        $sql = "select * from k3.k3n_email order by email asc";
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function addEmail($email)
    {
        $sql = "insert into k3.k3n_email (email) values ('$email');";
        $query = $this->erp->query($sql);
        return true;
    }

    public function editEmail($id, $email)
    {
        $sql = "update k3.k3n_email set email = '$email' where id = '$id';";
        $query = $this->erp->query($sql);
        return true;
    }

    public function hapusEmail($id)
    {
        $sql = "delete from k3.k3n_email where id = '$id';";
        $query = $this->erp->query($sql);
        return true;
    }

    public function updateRiwayat($id, $jmlUmum, $staffJumlah, $pkj)
    {
        $sql = "update k3.k3n_standar_kebutuhan set jml_item = '$pkj', jml_kebutuhan_umum = '$jmlUmum', jml_kebutuhan_staff = '$staffJumlah' where id = '$id';";
        // echo $sql;exit();
        $query = $this->erp->query($sql);
        return true;
    }

    public function getBulan($item)
    {
        $sql = "select * from k3.k3_master_item where kode_item = '$item'";
        $query = $this->erp->query($sql);
        return $query->row()->xbulan;
    }

    public function getFoto($item)
    {
        $sql = "select * from k3.k3_master_item where kode_item = '$item' or item = '$item'";
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function GetMasterItem()
    {
        $sql = "select * from k3.k3_master_item order by item asc";
        $query = $this->erp->query($sql);

        return $query->result_array();
    }

    public function updete($data, $kode)
    {
        $this->db->where('kode_item', $kode);
        $this->db->update('k3.k3_master_item', $data);

        // print_r($this->db->last_query());    exit();
        return true;
    }

    public function delItem($id)
    {
        $sql = "delete from k3.k3_master_item where id = '$id'";
        echo $sql;
        exit();
        $query = $this->db->query($sql);
    }

    public function getItemOracle()
    {
        $sql = "SELECT   msib.segment1 kode_item, msib.description item,
                         msib.primary_uom_code satuan
                    FROM mtl_system_items_b msib
                   WHERE msib.organization_id = 102
                     AND msib.inventory_item_status_code = 'Active'
                     AND msib.segment1 LIKE 'PP1%'
                ORDER BY 1";
        $query = $this->oracle->query($sql);

        return $query->result_array();
    }

    public function insertItem($data)
    {
        $query = $this->db->insert('k3.k3_master_item', $data);
    }

    public function getItemin($val)
    {
        $sql = "select ks.*, km.item from k3.k3n_standar_kebutuhan ks 
                left join k3.k3_master_item km on km.kode_item = ks.kode_item where ks.id in ($val);";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function stokOracle($kode, $gudang = 'PNL-NPR')
    {
        if ($gudang == 'PNL-NPR') {
            $locator = 783;
        } else {
            $locator = '';
        }
        $sql = "SELECT khs_inv_qty_att ('102',
                        (SELECT msib.inventory_item_id
                           FROM mtl_system_items_b msib
                          WHERE msib.organization_id = 102
                            AND msib.segment1 = '$kode'),
                        '$gudang',
                        '$locator',
                        ''
                        ) as stok
                        FROM DUAL";
        $query = $this->oracle->query($sql);

        // return $query->result_array();
        return $query->row()->STOK;
    }

    public function OutstandingPO($kode)
    {
        $sql = "SELECT pha.segment1 po_num, pla.line_num po_line_num, msib.segment1 kode_item,
                    plla.quantity po_qty,
                    plla.quantity - plla.quantity_received outstanding_po_qty,
                    ppf.full_name requester,
                    hla.LOCATION_CODE
                FROM po_headers_all pha,
                    po_lines_all pla,
                    po_line_locations_all plla,
                    po_distributions_all pda,
                    po_req_distributions_all prda,
                    po_requisition_lines_all prla,
                    per_people_f ppf,
                    mtl_system_items_b msib,
                    HR_LOCATIONS_all hla
                WHERE pha.po_header_id = pla.po_header_id
                    AND plla.po_line_id = pla.po_line_id
                    AND plla.po_header_id = pha.po_header_id
                    AND (plla.cancel_flag = 'N' OR plla.cancel_flag IS NULL)
                    AND (plla.closed_flag = 'N' OR plla.closed_flag IS NULL)
                    AND pla.po_line_id = pda.po_line_id
                    AND pda.req_distribution_id = prda.distribution_id
                    AND prla.requisition_line_id = prda.requisition_line_id
                    AND prla.to_person_id = ppf.person_id
                    AND NVL (ppf.effective_end_date, SYSDATE + 1) > SYSDATE
                    AND (plla.quantity - plla.quantity_received) != 0
                    AND pla.item_id = msib.inventory_item_id
                    AND plla.ship_to_organization_id = msib.organization_id
                    and plla.SHIP_TO_LOCATION_ID = hla.LOCATION_ID
                    -- AND msib.segment1 in('PP1K309','PP1KR01','PP1BS01', 'PP1BS04')
                    AND msib.segment1 = '$kode'";
        // echo $sql;exit();
        $query = $this->oracle->query($sql);
        // echo "<pre>";
        // print_r($query->result_array());exit();
        return $query->result_array();
        // return $query->row()->STOK;
    }

    public function getBon($id)
    {
        $sql = "select
                    kb.*,
                    km.item,
                    km.satuan,
                    ib.account,
                    ib.tanggal,
                    ib.seksi_bon,
                    ib.pemakai,
                    ib.cost_center,
                    ib.kode_cabang
                from
                    k3.k3n_bon kb
                left join k3.k3_master_item km on
                    km.kode_item = kb.item_code
                left join im.im_master_bon ib on
                    ib.no_bon = kb.no_bon
                where kb.no_bon = '$id'";
        echo $sql;
        exit();
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function cekDuplikat()
    {
        $sql = "select
                    distinct a.*,
                    es.section_name
                from
                    (
                        select kb.kode_item,
                        km.item,
                        kb.kodesie,
                        count(km.item) duplicate
                    from
                        k3.k3n_standar_kebutuhan kb,
                        k3.k3_master_item km
                    where
                        kb.kode_item = km.kode_item
                        and kb.status = 3
                        and kb.tgl_approve_tim = (
                        select
                            max(kb2.tgl_approve_tim)
                        from
                            k3.k3n_standar_kebutuhan kb2
                        where
                            kb2.kodesie = kb.kodesie
                            and kb2.kode_item = kb.kode_item
                            and kb2.status = kb.status )
                    group by
                        kb.kode_item,
                        km.item,
                        kb.kodesie ) a,
                    er.er_section es
                where
                    a.duplicate > 1
                    and a.kodesie = substring(es.section_code, 1, 7)
                order by
                    3,
                    2";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getStokGudang($gudang = 'PNL-NPR')
    {
        if ($gudang == 'PNL-NPR') {
            $locator = 783;
        } else {
            $locator = '';
        }
        $sql = "SELECT   msib.inventory_item_id, msib.segment1 item_code, msib.description,
                         khs_inv_qty_att ('102', msib.inventory_item_id, '$gudang', '$locator', '') stock,
                         msib.PRIMARY_UOM_CODE uom
                    FROM mtl_system_items_b msib
                   WHERE msib.organization_id = 102
                     AND msib.inventory_item_status_code = 'Active'
                     AND msib.segment1 IN
                            ('PP1AA42', 'PP1AA43', 'PP1AA01', 'PP1AA02', 'PP1AA03', 'PP1AA04',
                             'PP1AA05', 'PP1AA06', 'PP1AA07', 'PP1AA08', 'PP1AA09', 'PP1AA10',
                             'PP1AA11', 'PP1AA12', 'PP1AA13', 'PP1AA14', 'PP1AA15', 'PP1AA16',
                             'PP1AA17', 'PP1AA18', 'PP1AA19', 'PP1AA20', 'PP1AA21', 'PP1AA22',
                             'PP1AA23', 'PP1AA24', 'PP1AA25', 'PP1AA26', 'PP1AA27', 'PP1AA28',
                             'PP1AA29', 'PP1AA30', 'PP1AA31', 'PP1AC01', 'PP1AC07', 'PP1TS05',
                             'PP1AC05', 'PP1KR02', 'PP1KR05', 'PP1KR04', 'PP1KE01', 'PP1KE02',
                             'PP1KR03', 'PP1BS02', 'PP1BS01', 'PP1BS04', 'PP1KR01', 'PP1KR09',
                             'PP1AC04', 'PP1KR06', 'PP1TS06')
                ORDER BY msib.description";
        return $this->oracle->query($sql)->result_array();
    }

    public function getApdmaster()
    {
        $sql = "SELECT * from k3.k3_master_item";
        return $this->db->query($sql)->result_array();
    }

    public function getdetail_pkj_mkk($noind)
    {
        $sql = "select
                    t.*,
                    date_part('year', age(t.tgllahir)) age,
                    (
                        CASE
                            when date_part('year',age(CURRENT_DATE, t.masukkerja)) > 0 then concat(date_part('year',age(CURRENT_DATE, t.masukkerja)), ' Tahun ', date_part('month',age(CURRENT_DATE, t.masukkerja)), ' Bulan ', date_part('day',age(CURRENT_DATE, t.masukkerja)), ' Hari')
                            when date_part('month',age(CURRENT_DATE, t.masukkerja)) > 0 then concat(date_part('month',age(CURRENT_DATE, t.masukkerja)), ' Bulan ', date_part('day',age(CURRENT_DATE, t.masukkerja)), ' Hari')
                            else concat(date_part('day',age(CURRENT_DATE, t.masukkerja)), ' Hari')
                        END
                    ) masa_kerja,
                    t2.seksi,
                    t2.unit,
                    t2.bidang,
                    t2.dept,
                    t3.lokasi_kerja lokasi_kerja_nama,
                    now()::date - t.masukkerja::date
                from
                    hrd_khs.tpribadi t
                    left join hrd_khs.tseksi t2 on t2.kodesie = t.kodesie
                    left join hrd_khs.tlokasi_kerja t3 on t3.id_ = t.lokasi_kerja
                where
                    t.noind = '$noind'";
        $result = $this->personalia->query($sql)->row_array();


        // find on surat first, if null then show from tpribadi

        $result['masa_kerja_seksi'] = $this->getPostMasaKerjaKecelakaanFromSurat($noind) ?: $result['masa_kerja'];

        return $result;
    }

    /**
     * Cari pekerja aktif dengan keyword noind / nama
     * Pekerja aktif adalah keluar = false
     * 
     * 
     * @param String $keyword
     * @return Array<Object>
     */
    public function findActiveEmployeeWithKeyword($keyword, $kodesie = false)
    {
        $keywordLowerCase = strtolower($keyword);
        $query =  $this->personalia
            ->select('
                noind,
                trim(nama) nama,
                kodesie,
                kd_jabatan
            ')
            ->from('hrd_khs.tpribadi')
            ->where('keluar', false)
            ->group_start()
            ->like('LOWER(noind)', $keywordLowerCase, 'right')
            ->or_like('LOWER(nama)', $keywordLowerCase, 'both')
            ->group_end();

        if ($kodesie) {
            $query->where('LEFT(kodesie, 7) = ', substr($kodesie, 0, 7));
        }

        return $query->get()->result_object();
    }


    /**
     * Cari surat perbantuan aktif dengan noind/nama
     * 
     * @param String $keyword
     */
    public function findActivePerbantuanWithKeyword($keyword, $kodesie = false)
    {
        $keywordLowerCase = strtolower($keyword);
        $today = date('Y-m-d');

        $query = $this->personalia
            ->select('
                noind,
                trim(nama) nama,
                kodesie_baru as kodesie
            ')
            ->from('"Surat".tsurat_perbantuan')
            ->where('tanggal_mulai_perbantuan <= ', $today)
            ->where('tanggal_selesai_perbantuan >= ', $today)
            ->group_start()
            ->like('LOWER(noind)', $keywordLowerCase, 'right')
            ->or_like('LOWER(nama)', $keywordLowerCase, 'both')
            ->group_end();

        if ($kodesie) {
            $query->where('LEFT(kodesie_baru, 7) = ', substr($kodesie, 0, 7));
        }

        return $query->get()->result_object();
    }

    /**
     * Get employee by noind 
     * 
     * @param String $noind
     * @return Object of employee
     */
    public function getEmployeeByNoind($noind)
    {
        return $this->personalia->get_where('hrd_khs.tpribadi', [
            'noind' => $noind
        ])->row();
    }

    /**
     * ??
     */
    public function getMasaKerja($noinduk, $tgl)
    {
        $noinduk = "'$noinduk'";
        $sql = "select      masa_kerja.nik,
                                masa_kerja.tgllahir,
                                (
                                    masa_kerja.total_tahun
                                    +
                                    (
                                        case    when    masa_kerja.total_bulan>11
                                                        then    floor(masa_kerja.total_bulan/12)
                                                else    0
                                        end
                                    )
                                    +
                                    (
                                        case    when    masa_kerja.total_hari>364
                                                        then    floor(masa_kerja.total_hari/365)
                                                else    0
                                        end
                                    )
                                ) as tahun,
                                (
                                    (
                                        case    when    masa_kerja.total_bulan>11
                                                        then    masa_kerja.total_bulan-(floor(masa_kerja.total_bulan/12)*12)
                                                else    masa_kerja.total_bulan
                                        end
                                    )
                                    +
                                    (
                                        case    when    masa_kerja.total_hari>29
                                                        then    floor(masa_kerja.total_hari/30)
                                                else    0
                                        end
                                    )
                                ) as bulan,
                                (
                                    (
                                        case    when    masa_kerja.total_hari>29
                                                        then    masa_kerja.total_hari-(floor(masa_kerja.total_hari/30)*30)
                                                else    masa_kerja.total_hari
                                        end
                                    )
                                ) as hari
                    from        (
                                    select      master_masa_kerja.nik,
                                                master_masa_kerja.tgllahir,
                                                sum(extract(year from master_masa_kerja.masa_kerja)) as total_tahun,
                                                sum(extract(month from master_masa_kerja.masa_kerja)) as total_bulan,
                                                sum(extract(day from master_masa_kerja.masa_kerja)) as total_hari
                                    from        (
                                                    select      pri.*,
                                                                (
                                                                    case    when    pri.keluar=false
                                                                                    then    (
                                                                                                age('$tgl', pri.masukkerja)
                                                                                            )

                                                                                    else    (
                                                                                                age(pri.tglkeluar, pri.masukkerja)
                                                                                            )

                                                                    end
                                                                ) as masa_kerja
                                                    from        (
                                                                    select      pri.noind,
                                                                                pri.nik,
                                                                                pri.tgllahir,
                                                                                pri.kode_status_kerja,
                                                                                pri.keluar,
                                                                                pri.masukkerja,
                                                                                pri.diangkat,
                                                                                pri.tglkeluar,
                                                                                pri.akhkontrak
                                                                    from        hrd_khs.v_hrd_khs_tpribadi as pri
                                                                    where       pri.noind in($noinduk)

                                                                ) as pri
                                                ) master_masa_kerja
                                    group by    master_masa_kerja.nik,
                                                master_masa_kerja.tgllahir
                                ) as masa_kerja";
        $query = $this->personalia->query($sql);
        return $query->row_array();
    }

    /**
     * ??
     */
    public function getMasaKerja2($noinduk, $tgl)
    {
        $noinduk = "'$noinduk'";
        $sql2 = "select         masa_kerja.nik,
                                masa_kerja.tgllahir,
                                (
                                    masa_kerja.total_tahun
                                    +
                                    (
                                        case    when    masa_kerja.total_bulan>11
                                                        then    floor(masa_kerja.total_bulan/12)
                                                else    0
                                        end
                                    )
                                    +
                                    (
                                        case    when    masa_kerja.total_hari>364
                                                        then    floor(masa_kerja.total_hari/365)
                                                else    0
                                        end
                                    )
                                ) as tahun,
                                (
                                    (
                                        case    when    masa_kerja.total_bulan>11
                                                        then    masa_kerja.total_bulan-(floor(masa_kerja.total_bulan/12)*12)
                                                else    masa_kerja.total_bulan
                                        end
                                    )
                                    +
                                    (
                                        case    when    masa_kerja.total_hari>29
                                                        then    floor(masa_kerja.total_hari/30)
                                                else    0
                                        end
                                    )
                                ) as bulan,
                                (
                                    (
                                        case    when    masa_kerja.total_hari>29
                                                        then    masa_kerja.total_hari-(floor(masa_kerja.total_hari/30)*30)
                                                else    masa_kerja.total_hari
                                        end
                                    )
                                ) as hari
                    from        (
                                    select      master_masa_kerja.nik,
                                                master_masa_kerja.tgllahir,
                                                sum(extract(year from master_masa_kerja.masa_kerja)) as total_tahun,
                                                sum(extract(month from master_masa_kerja.masa_kerja)) as total_bulan,
                                                sum(extract(day from master_masa_kerja.masa_kerja)) as total_hari
                                    from        (
                                                    select      pri.*,
                                                                (
                                                                    case    when    pri.keluar=false
                                                                                    then    (
                                                                                                case    when (select count(*) from hrd_khs.tpribadi A
                                                                                                left join hrd_khs.tb_status_jabatan B on A.noind=B.noind
                                                                                                where B.status_data='01' and B.kd_jabatan='14' and ( A.keluar='0') and A.noind = pri.noind) > 0
                                                                                                    then
                                                                                                        (
                                                                                                            select age('$tgl',A.diangkat)
                                                                                                            from hrd_khs.tpribadi A
                                                                                                            left join hrd_khs.tb_status_jabatan B
                                                                                                            on A.noind = B.noind
                                                                                                            where A.nik = pri.nik
                                                                                                            and A.kode_status_kerja = 'A'
                                                                                                            limit 1
                                                                                                        )
                                                                                                    else    (
                                                                                                                age('$tgl','$tgl')
                                                                                                            )
                                                                                                    end
                                                                                            )

                                                                            else    (
                                                                                        case    when    pri.kode_status_kerja in ('A', 'B','J', 'H')
                                                                                                        then    (
                                                                                                                    age(pri.tglkeluar, pri.diangkat)
                                                                                                                )
                                                                                                else    (
                                                                                                            age(pri.tglkeluar, pri.masukkerja)
                                                                                                        )
                                                                                        end
                                                                                    )
                                                                    end
                                                                ) as masa_kerja
                                                    from        (
                                                                    select      pri.noind,
                                                                                pri.nik,
                                                                                pri.tgllahir,
                                                                                pri.kode_status_kerja,
                                                                                pri.keluar,
                                                                                pri.masukkerja,
                                                                                pri.diangkat,
                                                                                pri.tglkeluar,
                                                                                pri.akhkontrak
                                                                    from        hrd_khs.v_hrd_khs_tpribadi as pri
                                                                    where       pri.noind = $noinduk
                                                                ) as pri
                                                ) master_masa_kerja
                                    group by    master_masa_kerja.nik,
                                                master_masa_kerja.tgllahir
                                ) as masa_kerja";
        $query2 = $this->personalia->query($sql2);
        return $query2->row_array();
    }

    /**
     * ??
     */
    public function getMasaKerja3($noinduk, $tgl)
    {
        $noinduk = "'$noinduk'";
        $sql3 = "select         masa_kerja.nik,
                                masa_kerja.tgllahir,
                                (
                                    masa_kerja.total_tahun
                                    +
                                    (
                                        case    when    masa_kerja.total_bulan>11
                                                        then    floor(masa_kerja.total_bulan/12)
                                                else    0
                                        end
                                    )
                                    +
                                    (
                                        case    when    masa_kerja.total_hari>364
                                                        then    floor(masa_kerja.total_hari/365)
                                                else    0
                                        end
                                    )
                                ) as tahun,
                                (
                                    (
                                        case    when    masa_kerja.total_bulan>11
                                                        then    masa_kerja.total_bulan-(floor(masa_kerja.total_bulan/12)*12)
                                                else    masa_kerja.total_bulan
                                        end
                                    )
                                    +
                                    (
                                        case    when    masa_kerja.total_hari>29
                                                        then    floor(masa_kerja.total_hari/30)
                                                else    0
                                        end
                                    )
                                ) as bulan,
                                (
                                    (
                                        case    when    masa_kerja.total_hari>29
                                                        then    masa_kerja.total_hari-(floor(masa_kerja.total_hari/30)*30)
                                                else    masa_kerja.total_hari
                                        end
                                    )
                                ) as hari
                    from        (
                                    select      master_masa_kerja.nik,
                                                master_masa_kerja.tgllahir,
                                                sum(extract(year from master_masa_kerja.masa_kerja)) as total_tahun,
                                                sum(extract(month from master_masa_kerja.masa_kerja)) as total_bulan,
                                                sum(extract(day from master_masa_kerja.masa_kerja)) as total_hari
                                    from        (
                                                    select      pri.*,
                                                                (
                                                                    case    when    pri.keluar=false
                                                                                    then    (
                                                                                                age('$tgl', pri.diangkat)
                                                                                            )

                                                                                    else    (
                                                                                                age(pri.tglkeluar, pri.diangkat)
                                                                                            )

                                                                    end
                                                                ) as masa_kerja
                                                    from        (
                                                                    select      pri.noind,
                                                                                pri.nik,
                                                                                pri.tgllahir,
                                                                                pri.kode_status_kerja,
                                                                                pri.keluar,
                                                                                pri.masukkerja,
                                                                                pri.diangkat,
                                                                                pri.tglkeluar,
                                                                                pri.akhkontrak
                                                                    from        hrd_khs.v_hrd_khs_tpribadi as pri
                                                                    where       pri.noind in($noinduk)

                                                                ) as pri
                                                ) master_masa_kerja
                                    group by    master_masa_kerja.nik,
                                                master_masa_kerja.tgllahir
                                ) as masa_kerja";
        // echo $sql3;exit();
        $query3 = $this->personalia->query($sql3);
        return $query3->row_array();
    }

    public function getShiftByPKJ($noind, $tgl)
    {
        $sql = "select
                    *
                from
                    \"Presensi\".tshiftpekerja t
                where
                    noind = '$noind'
                    and tanggal = '$tgl'";
        return $this->personalia->query($sql)->row_array();
    }

    public function insk3k_kecelakaan($data)
    {
        $this->db->insert('k3.k3k_kecelakaan', $data);
        return $this->db->insert_id();
    }

    public function insk3k_kecelakaan_lain($data, $table)
    {
        $id_kecelakaan = $data[0]['id_kecelakaan'];

        $this->db->delete($table, [
            'id_kecelakaan' => $id_kecelakaan
        ]);

        $this->db->insert_batch($table, $data);
        return $this->db->affected_rows() > 0;
    }

    public function insertKecelakaanApd($table, $data)
    {
        return $this->db->insert_batch($table, $data);
    }

    public function upk3k_kecelakaan($data, $id)
    {
        $this->db->where('id_kecelakaan', $id);
        $this->db->update('k3.k3k_kecelakaan', $data);
        return $this->db->affected_rows() > 0;
    }

    public function getK3K($year, $kodesie = false)
    {
        $withSection = "";

        if (gettype($kodesie) == 'string') {
            $withSection = "AND LEFT(kk.user_kodesie, 7) = LEFT('$kodesie', 7)";
        } elseif (gettype($kodesie) == 'array') {
            $trefjabatan = implode("', '", $kodesie);
            $withSection = "AND LEFT(kk.user_kodesie,5) IN ('$trefjabatan')";
        }

        $sql = "SELECT
                    kk.id_kecelakaan,
                    kk.noind,
                    eea.employee_name nama,
                    kk.waktu_kecelakaan,
                    kk.lokasi_kerja,
                    kk.lokasi_kerja_kecelakaan,
                    kk.tkp,
                    kk.car_is_created,
                    es.section_name seksi,
                    es.unit_name unit,
                    es.department_name dept,
                    kk.user_created_by,
                    kk.user_created_at,
                    car_tim_is_approved,
                    car_unit_is_approved
                from
                    k3.k3k_kecelakaan kk
                    left join er.er_employee_all eea on eea.employee_code = kk.noind
                    left join er.er_section es on es.section_code = kk.kodesie::text
                where 
                    kk.waktu_kecelakaan::text like '$year%'
                    $withSection
                order by kk.user_created_at desc
                ";
        return $this->db->query($sql)->result_array();
    }

    public function getKecelakaanKerjaByUnit($year, $unitKodesie)
    {
        $withSection = "";

        if (!empty($unitKodesie)) {
            if (is_string($unitKodesie)) {
                $withSection = "AND LEFT(kk.user_kodesie, 5) = LEFT('$unitKodesie', 5)";
            } else if (is_array($unitKodesie)) {
                $stringKodesie = implode(', ', array_map(function ($it) {
                    return "'$it'";
                }, $unitKodesie));
                $withSection = "AND LEFT(kk.user_kodesie, 5) in ($stringKodesie)";
            }
        }

        $sql = "SELECT
                    kk.id_kecelakaan,
                    kk.noind,
                    eea.employee_name nama,
                    kk.waktu_kecelakaan,
                    kk.lokasi_kerja,
                    kk.lokasi_kerja_kecelakaan,
                    kk.tkp,
                    kk.car_is_created,
                    es.section_name seksi,
                    es.unit_name unit,
                    es.department_name dept,
                    kk.user_created_by,
                    kk.user_created_at,
                    car_tim_is_approved,
                    car_unit_is_approved
                from
                    k3.k3k_kecelakaan kk
                    left join er.er_employee_all eea on eea.employee_code = kk.noind
                    left join er.er_section es on es.section_code = kk.kodesie::text
                where 
                    kk.waktu_kecelakaan::text like '$year%'
                    and kk.car_is_created = true
                    $withSection
                ";
        return $this->db->query($sql)->result_array();
    }

    public function delK3K($table, $id)
    {
        $this->db->where('id_kecelakaan', $id);
        $this->db->delete($table);
        return $this->db->affected_rows();
        // echo $this->db->get_compiled_delete($table);
        // echo "<br>";
    }

    public function getKecelakaan($id_kecelakaan)
    {
        return $this->db
            ->select("
                kk.*,
                el.location_name as lokasi_kerja_kecelakaan,
                replace(replace(replace(age(date(kk.tgl_masuk_pos), date(kk.waktu_kecelakaan))::VARCHAR,'years', 'Tahun'),'mons','Bulan'),'days','Hari') as masuk_pos
            ")
            ->from('k3.k3k_kecelakaan kk')
            ->join('er.er_location el', 'el.location_code = kk.lokasi_kerja_kecelakaan', 'left')
            ->where('id_kecelakaan', $id_kecelakaan)
            ->get()
            ->row_array();
    }

    public function getAllk3k($table, $id)
    {
        $this->db
            ->where('id_kecelakaan', $id);
        // echo $this->db->get_compiled_select($table);
        return $this->db->get($table)->result_array();
    }

    /**
     * Cari tkp dari data kecelakaan yg pernah diinput
     */
    public function getlistTKP($txt)
    {
        $sql = "SELECT distinct tkp FROM k3.k3k_kecelakaan
                where tkp like '%$txt%'";
        return $this->db->query($sql)->result_array();
    }

    public function getKKLain($table, $order, $id)
    {
        $this->db->where('id_kecelakaan', $id);
        $this->db->order_by($order, 'ASC');
        return $this->db->get($table)->result_array();
    }

    public function delK3K_lain($table, $id)
    {
        $this->db->where('id_kecelakaan', $id);
        $this->db->delete($table);
        return $this->db->affected_rows() > 0;
    }

    public function getDatak3k($ym)
    {
        $sql = "SELECT kkk.*,es.*,
                (select eea.employee_name from er.er_employee_all eea where eea.employee_code = kkk.noind) nama,
                (select eea.employee_name from er.er_employee_all eea where eea.employee_code = kkk.pic) nama_pic,
                (select string_agg(kkbt.bagian_tubuh::text, ',') from k3.k3k_bagian_tubuh kkbt where kkbt.id_kecelakaan = kkk.id_kecelakaan) bagian_tubuh,
                (select string_agg(kkkk.kategori::text, ',') from k3.k3k_kategori_kecelakaan kkkk where kkkk.id_kecelakaan = kkk.id_kecelakaan) kategori,
                (select string_agg(kkfk.faktor::text, ',') from k3.k3k_faktor_kecelakaan kkfk where kkfk.id_kecelakaan = kkk.id_kecelakaan) faktor,
                (select string_agg(kkpa.penggunaan_apd::text, ',') from k3.k3k_penggunaan_apd kkpa where kkpa.id_kecelakaan = kkk.id_kecelakaan) apd
                FROM k3.k3k_kecelakaan kkk
                left join er.er_section es on es.section_code = kkk.kodesie::text
                where kkk.waktu_kecelakaan::text like '$ym%'
                order by kkk.waktu_kecelakaan";
        return $this->db->query($sql)->result_array();
    }

    public function getAllk3k2($tabel)
    {
        // $sql = "SELECT * from $table";
        return $this->db->get($tabel)->result_array();
    }

    /**
     * PLEASE CHECK THIS QUERY
     * kk.lokasi_kerja_kecelakaan
     */
    public function getTtlBagian($id_bagian, $year)
    {
        $sql = "SELECT
                    count(*) ttl
                from
                    k3.k3k_kecelakaan kk
                left join k3.k3k_bagian_tubuh kkbt on
                    kkbt.id_kecelakaan = kk.id_kecelakaan
                where
                    kkbt.bagian_tubuh = $id_bagian
                    and kk.lokasi_kerja_kecelakaan in ('01', '02') 
                    and kk.waktu_kecelakaan::text like '$year%'";
        return $this->db->query($sql)->row()->ttl;
    }

    public function getTtlBagianLok($id_bagian, $year, $lokasi)
    {
        $sql = "SELECT
                    count(*) ttl
                from
                    k3.k3k_kecelakaan kk
                left join k3.k3k_bagian_tubuh kkbt on
                    kkbt.id_kecelakaan = kk.id_kecelakaan
                where
                    kkbt.bagian_tubuh = $id_bagian
                    and kk.lokasi_kerja_kecelakaan like '$lokasi%'
                    and kk.waktu_kecelakaan::text like '$year%'";
        return $this->db->query($sql)->row()->ttl;
    }

    public function getTtlKategori($id_kategori, $year)
    {
        $sql = "SELECT
                    count(*) ttl
                from
                    k3.k3k_kecelakaan kk
                left join k3.k3k_kategori_kecelakaan kkbt on
                    kkbt.id_kecelakaan = kk.id_kecelakaan
                where
                    kkbt.kategori = $id_kategori
                    and kk.waktu_kecelakaan::text like '$year%'";
        return $this->db->query($sql)->row()->ttl;
    }

    public function getTtlFaktor($id_kategori, $year)
    {
        $sql = "SELECT
                    count(*) ttl
                from
                    k3.k3k_kecelakaan kk
                left join k3.k3k_faktor_kecelakaan kkbt on
                    kkbt.id_kecelakaan = kk.id_kecelakaan
                where
                    kkbt.faktor = $id_kategori
                    and kk.waktu_kecelakaan::text like '$year%'";
        return $this->db->query($sql)->row()->ttl;
    }

    public function getTtlLoker($id_loker, $year) //lokasikerja
    {
        $loker = "lokasi_kerja_kecelakaan in ('01', '02') and";

        if ($id_loker) {
            $loker = "lokasi_kerja_kecelakaan like '$id_loker%' and";
        }

        $sql = "SELECT 
                    count(*) ttl 
                FROM 
                    k3.k3k_kecelakaan kkk 
                WHERE 
                    $loker
                    kkk.waktu_kecelakaan::text like '$year%'";
        // echo $sql;exit();
        return $this->db->query($sql)->row()->ttl;;
    }

    public function getTtlStopsix($id, $year)
    {
        $sql = "SELECT count(*) ttl from k3.k3k_kecelakaan kkk where kriteria_stop_six = '$id'
                and kkk.waktu_kecelakaan::text like '$year%'";
        return $this->db->query($sql)->row()->ttl;
    }

    public function getTtlrange2($id, $year)
    {
        $sql = "SELECT count(*) ttl from k3.k3k_kecelakaan kkk where range_waktu2 = '$id'
                and kkk.waktu_kecelakaan::text like '$year%'";
        return $this->db->query($sql)->row()->ttl;
    }

    public function getTtlunsafe($id, $year)
    {
        $sql = "SELECT count(*) ttl from k3.k3k_kecelakaan kkk where unsafe = '$id'
                and kkk.waktu_kecelakaan::text like '$year%'";
        return $this->db->query($sql)->row()->ttl;
    }

    public function getTtldept($id, $year)
    {
        if ($id) $t = 'not';
        else $t = '';
        $sql = "SELECT count(*) ttl from k3.k3k_kecelakaan kkk where kodesie::text $t like '$id%'
                and kkk.waktu_kecelakaan::text like '$year%'";
        return $this->db->query($sql)->row()->ttl;
    }

    public function getTtljp($id, $year)
    {
        $sql = "SELECT count(*) ttl from k3.k3k_kecelakaan kkk where jenis_pekerjaan::text like '$id%'
                and kkk.waktu_kecelakaan::text like '$year%'";
        return $this->db->query($sql)->row()->ttl;
    }

    public function getTtlkolom($id, $year, $kolom)
    {
        $sql = "SELECT count(*) ttl from k3.k3k_kecelakaan kkk where $kolom::text like '$id%'
                and kkk.waktu_kecelakaan::text like '$year%' and kkk.lokasi_kerja_kecelakaan in ('01', '02')";
        return $this->db->query($sql)->row()->ttl;
    }

    public function getTtlkolomLok($id, $year, $kolom, $lokasi = '')
    {
        $sql = "SELECT count(*) ttl from k3.k3k_kecelakaan kkk where $kolom::text like '$id%'
                and kkk.waktu_kecelakaan::text like '$year%' and kkk.lokasi_kerja_kecelakaan like '$lokasi%'";
        return $this->db->query($sql)->row()->ttl;
    }

    public function getTtlapd($id, $year)
    {
        $sql = "SELECT
                    count(*) ttl
                from
                    k3.k3k_kecelakaan kk
                left join k3.k3k_penggunaan_apd kkbt on
                    kkbt.id_kecelakaan = kk.id_kecelakaan
                where
                    kkbt.penggunaan_apd = $id
                    and kk.waktu_kecelakaan::text like '$year%'";
        return $this->db->query($sql)->row()->ttl;
    }

    public function getKecelakaanUnit($year)
    {
        $sql = "select
                    es.unit_name,
                    count(*) jml
                from
                    k3.k3k_kecelakaan kkk
                left join er.er_section es on
                    es.section_code = kkk.kodesie::text
                where
                    kkk.waktu_kecelakaan::text like '$year%'
                group by
                    es.unit_name
                order by
                    jml desc
                limit 5";
        return $this->db->query($sql)->result_array();
    }

    public function getKecelakaanSeksi($year, $lokasi)
    {
        $sql = "select
                    es.section_name,
                    count(*) jml
                from
                    k3.k3k_kecelakaan kkk
                left join er.er_section es on
                    es.section_code = kkk.kodesie::text
                where
                    kkk.waktu_kecelakaan::text like '$year%'
                    and kkk.lokasi_kerja_kecelakaan = '$lokasi'
                group by
                    es.section_name
                order by
                    jml desc
                limit 5";
        // echo $sql;exit();
        return $this->db->query($sql)->result_array();
    }

    public function getTglKecelakaan($year)
    {
        $sql = "select
                    distinct left(waktu_kecelakaan::text, 10) tgl
                from
                    k3.k3k_kecelakaan kkk
                where
                    waktu_kecelakaan::text like '$year%'
                order by
                    tgl asc";
        return $this->db->query($sql)->result_array();
    }

    public function getRekapLaka($tgl, $lokasi)
    {
        $sql = "select
                    count(*) ttl
                from
                    hrd_khs.tpribadi t
                where
                    left(noind, 1) not in ('Z', 'L', 'M')
                    and tglkeluar > '$tgl'
                    and masukkerja <= '$tgl'
                    and lokasi_kerja = '$lokasi'
                    and (masukkerja >= '1945-01-01')";
        return $this->personalia->query($sql)->row()->ttl;
    }

    public function getLaka($tgl, $lokasi)
    {
        $sql = "SELECT
                    count(*) ttl
                from
                    k3.k3k_kecelakaan kkk
                where
                    kkk.lokasi_kerja_kecelakaan::text like '999'
                    and kkk.lokasi_kerja = '$lokasi'
                    and kkk.waktu_kecelakaan::text like '$tgl%'";
        return $this->db->query($sql)->row()->ttl;
    }

    public function getTranscT($id_oracle, $nobon)
    {
        $sql = "SELECT   *
                FROM im_master_bon mb
                where NO_BON = '$nobon'
                and NO_ID in ($id_oracle)";
        return $this->oracle->query($sql)->result_array();
    }

    public function getTbonSpatu($id_oracle)
    {
        if (empty($id_oracle)) return false;
        if (is_array($id_oracle)) {
            $id_oracle = implode(',', $id_oracle);
        }
        $sql = "SELECT * FROM k3.tbon_sepatu where id_oracle in ($id_oracle)";
        return $this->db->query($sql)->result_array();
    }
    public function getRefJabatan($noind, $trim = 9)
    {
        return $this->personalia
            ->select("
                left(kodesie, '$trim') as kodesie
            ")
            ->where('noind', $noind)
            ->from('hrd_khs.trefjabatan')
            ->get()
            ->result_array();
    }

    private function getDifferenceDateFromNow($date)
    {
        $sql = "
            select (
                CASE
                    when date_part('year',age(CURRENT_DATE, $date)) > 0 then concat(date_part('year',age(CURRENT_DATE, $date)), ' Tahun ', date_part('month',age(CURRENT_DATE, $date)), ' Bulan ', date_part('day',age(CURRENT_DATE, $date)), ' Hari')
                    when date_part('month',age(CURRENT_DATE, $date)) > 0 then concat(date_part('month',age(CURRENT_DATE, $date)), ' Bulan ', date_part('day',age(CURRENT_DATE, $date)), ' Hari')
                    else concat(date_part('day',age(CURRENT_DATE, $date)), ' Hari')
                END
            ) masa_kerja
        ";

        return $this->personalia->query($sql)->row()->masa_kerja;
    }

    /**
     * Only support for
     * Surat.tsurat_perbantuan
     * Surat.tsurat_mutasi
     * Surat.tsurat_rotasi
     * Surat.tsurat_promosi
     * Surat.tsurat_demosi
     */
    public function getActiveSuratChanges($table, $noind)
    {
        $sql = "
            SELECT 
                tanggal_berlaku as tanggal,
                (
                    CASE
                        when date_part('year',age(CURRENT_DATE, tanggal_berlaku)) > 0 then concat(date_part('year',age(CURRENT_DATE, tanggal_berlaku)), ' Tahun ', date_part('month',age(CURRENT_DATE, tanggal_berlaku)), ' Bulan ', date_part('day',age(CURRENT_DATE, tanggal_berlaku)), ' Hari')
                        when date_part('month',age(CURRENT_DATE, tanggal_berlaku)) > 0 then concat(date_part('month',age(CURRENT_DATE, tanggal_berlaku)), ' Bulan ', date_part('day',age(CURRENT_DATE, tanggal_berlaku)), ' Hari')
                        else concat(date_part('day',age(CURRENT_DATE, tanggal_berlaku)), ' Hari')
                    END
                ) masa_kerja
            FROM $table 
            WHERE
                noind = '$noind'
                and tanggal_berlaku <= CURRENT_DATE
            ORDER BY 
                tanggal_berlaku DESC
            LIMIT 1
        ";

        return $this->personalia->query($sql)->row_array();
    }

    public function getActiveSuratPerbantuan($noind)
    {
        $sql = "
            SELECT
                tanggal_mulai_perbantuan as tanggal,
                (
                    CASE
                        WHEN date_part('year', age(CURRENT_DATE, tanggal_mulai_perbantuan::date)) > 0 
                            THEN concat(
                                date_part('year', age(CURRENT_DATE, tanggal_mulai_perbantuan::date)), 
                                ' Tahun ', 
                                date_part('month', age(CURRENT_DATE, tanggal_mulai_perbantuan::date)), 
                                ' Bulan ', 
                                date_part('day', age(CURRENT_DATE, tanggal_mulai_perbantuan::date)), 
                                ' Hari'
                            )
                        WHEN date_part('month', age(CURRENT_DATE, tanggal_mulai_perbantuan::date)) > 0 
                            THEN concat(
                                date_part('month', age(CURRENT_DATE, tanggal_mulai_perbantuan::date)), 
                                ' Bulan ', 
                                date_part('day', age(CURRENT_DATE, tanggal_mulai_perbantuan::date)), 
                                ' Hari'
                            )
                        ELSE 
                            concat(
                                date_part('day', age(CURRENT_DATE, tanggal_mulai_perbantuan::date)), 
                                ' Hari'
                            )
                    END
                ) masa_kerja
            FROM \"Surat\".tsurat_perbantuan
            WHERE 
                noind = '$noind'
                and tanggal_mulai_perbantuan <= CURRENT_DATE
                and tanggal_selesai_perbantuan >= CURRENT_DATE
            ORDER BY 
                tanggal_mulai_perbantuan DESC
            LIMIT 1";

        return $this->personalia->query($sql)->row_array();
    }

    /**
     * Untuk mencari masa kerja saat di seksi
     * 
     * tabel terkait:
     * Surat.tsurat_perbantuan
     * Surat.tsurat_mutasi
     * Surat.tsurat_rotasi
     * Surat.tsurat_promosi
     * Surat.tsurat_demosi
     */
    public function getPostMasaKerjaKecelakaanFromSurat($noind)
    {
        $today = date('Y-m-d');

        // Get latest surat / surat yang masih berlaku pada saat tanggal $today

        $allSurat = [];

        $perbantuan = $this->getActiveSuratPerbantuan($noind);
        if (!empty($perbantuan)) array_push($allSurat, $perbantuan);

        $mutasi = $this->getActiveSuratChanges('"Surat".tsurat_mutasi', $noind);
        if (!empty($mutasi)) array_push($allSurat, $mutasi);

        $rotasi = $this->getActiveSuratChanges('"Surat".tsurat_rotasi', $noind);
        if (!empty($rotasi)) array_push($allSurat, $rotasi);

        $promosi = $this->getActiveSuratChanges('"Surat".tsurat_promosi', $noind);
        if (!empty($promosi)) array_push($allSurat, $promosi);

        $demosi = $this->getActiveSuratChanges('"Surat".tsurat_demosi', $noind);
        if (!empty($demosi)) array_push($allSurat, $demosi);


        if (empty($allSurat)) return null;

        // sort last date / tanggal berlaku paling akhir
        usort($allSurat, function ($a, $b) {
            return $a['tanggal'] - $b['tanggal'];
        });

        return $allSurat[0]['masa_kerja'];
    }

    public function GetPeriodeSepatu()
    {
        return $this->db->query("select trim(pk.periode) periode, es.* from \"k3\".tbon_sepatu_periode pk left join \"er\".er_section es on es.section_code = pk.kodesie")->result_array();
    }

    public function UpdatePeriodeSepatu($kodesie, $periode)
    {
        $this->db->query("update \"k3\".tbon_sepatu_periode set periode = '$periode' where left(kodesie, 7) = '$kodesie'");
    }

    public function getMoq($item)
    {
        $sql = "SELECT msib.segment1, msib.description, msib.minimum_order_quantity
                  FROM mtl_system_items_b msib
                WHERE msib.organization_id = 81 AND msib.segment1 = '$item'";
        return $this->oracle->query($sql)->row_array();
    }

    function getttlTransactAPD($no_bon, $apd, $pr = '')
    {
        if ($pr == '') {
            $pr = date('Y-m');
        }
        $sql = "SELECT
                    sum(PENYERAHAN) transact
                FROM
                    im_master_bon
                WHERE
                    no_bon IN($no_bon)
                    AND kode_barang = '$apd'
                    -- AND keterangan LIKE '%$pr'";
        if (empty($this->oracle->query($sql)->row()->TRANSACT)) {
            return 0;
        }
        return $this->oracle->query($sql)->row()->TRANSACT;
    }

    function getSeksiNotPeriode()
    {
        $sql = "SELECT
                    *
                from
                    er.er_section es
                where
                    trim(section_name) != '-'
                    and section_name not like '***%'
                    and section_code like '%00'
                    and section_code not in (
                    select
                        tsp.kodesie
                    from
                        k3.tbon_sepatu_periode tsp)";
        return $this->db->query($sql)->result_array();
    }

    function addPeriodeSepatu($data)
    {
        $this->db->insert('k3.tbon_sepatu_periode', $data);
        return $this->db->affected_rows();
    }
}
