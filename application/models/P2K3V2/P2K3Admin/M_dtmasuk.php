<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Dtmasuk extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia   =   $this->load->database('personalia', TRUE) ;
        $this->erp          =   $this->load->database('erp_db', TRUE);
        $this->oracle          =   $this->load->database('oracle', TRUE);
    }

    public function daftar_seksi($tgl, $tahun){
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
			$query = $query."(select sum(kd1.ttl_order) from k3.k3_kebutuhan k1 
		inner join k3.k3_kebutuhan_detail kd1 on k1.id_kebutuhan = kd1.id_kebutuhan 
		where km.kode_item = kd1.kode_item 
		and extract(month from kd1.create_date) = '$tgl' 
		and extract (year from kd1.create_date) = '$tahun'
		and k1.kodesie like '$no%') a$k, ";
		$k++;
		}
		$query = $query." (select sum(kd.ttl_order) 
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
    	$ks = substr($ks, 0,7);
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
				where status = '3' and ks.kodesie like '$ks%' and ks.kode_item = '".$key['kode_item']."'
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
    	$sql = "select section_name from er.er_section where section_code like '$ks%' limit 1";
    	$query = $this->erp->query($sql);
        // echo $sql;exit();
        return $query->result_array();
    }

    public function listToApprove($ks, $pr)
    {
        $sql = "select ks.*, km.item from k3.k3n_standar_kebutuhan ks 
        left join k3.k3_master_item km on km.kode_item = ks.kode_item
        where cast(tgl_approve as varchar) like '$pr%' and ks.status = 1 and ks.kodesie like '$ks%'
        order by km.item, ks.tgl_approve asc";
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
                    kb.tgl_approve_tim
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
                    es.section_name
                from
                    k3.k3n_order ko
                left join er.er_section es on
                    substring(es.section_code, 0, 8) = substring(ko.kodesie, 0, 8)
                where
                    ko.periode = '$pr'
                    and ko.tgl_input = (select max(ko2.tgl_input) from k3.k3n_order ko2 where ko2.kodesie = ko.kodesie and ko2.periode = ko.periode)
                group by
                    es.section_name,
                    ko.status, ko.tgl_input
                order by
                    es.section_name asc;";
                // echo $sql;exit();
        $query = $this->erp->query($sql);
        return $query->result_array();
    }

    public function listtobon($ks, $pr)
    {
        $ks = substr($ks, 0,7);
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
        $ks = substr($ks, 0,7);
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

    public function insertBon($data)
    {
        $query = $this->db->insert('k3.k3n_bon', $data);
    }

    public function insertBonIm($data)
    {
        $query = $this->db->insert('im.im_master_bon', $data);
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

    public function allKs($pr)
    {
        $sql = "select distinct(substring(ks.kd_pekerjaan,0,8)) kodesie, (select section_name from er.er_section 
                where substring(section_code,0,8) = substring(ks.kd_pekerjaan,0,8) limit 1) section_name from k3.k3n_standar_kebutuhan ks
                inner join k3.k3n_order ko on substring(ko.kodesie,0,8) = substring(ks.kodesie,0,8) where ko.periode = '$pr'
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

    public function delPeriode($pr)
    {
        $sql = "DELETE from k3.k3n_hitung where periode = '$pr'";
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
        $tgl = substr($id_kebutuhan, 0,2);
        $y = substr($id_kebutuhan,5,9);
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
                    string_agg(mb.kode_barang, ',') kode_barang,
                    string_agg(mb.nama_barang, ',') nama_apd,
                    string_agg(kb.jml_bon, ',') jml_bon,
                    string_agg(mb.satuan, ',') satuan,
                    kb.tgl_bon,
                    kb.kodesie,
                    mb.seksi_bon seksi_pengebon,
                    mb.pemakai seksi_pemakai,
                    mb.penggunaan,
                    mb.keterangan,
                    kb.periode,
                    mb.tujuan_gudang
                from
                    k3.k3n_bon kb,
                    im.im_master_bon mb
                where
                    kb.no_bon = mb.no_bon
                    and kb.item_code = mb.kode_barang
                    and kb.periode = '$pr'
                    and kb.kodesie like '$ks%'
                group by kb.no_bon,
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

    public function editEmail($id,$email)
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

    public function updateRiwayat($id, $jmlUmum, $staffJumlah,$pkj)
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
        echo $sql;exit();
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

    public function stokOracle($kode)
    {
        $sql = "SELECT khs_inv_qty_att ('102',
                        (SELECT msib.inventory_item_id
                           FROM mtl_system_items_b msib
                          WHERE msib.organization_id = 102
                            AND msib.segment1 = '$kode'),
                        'PNL-NPR',
                        783,
                        ''
                        ) as stok
                        FROM DUAL";
        $query = $this->oracle->query($sql);

        // return $query->result_array();
        return $query->row()->STOK;
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
            // echo $sql;;exit();
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}