<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_menu extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);
    }

    public function getMenuByLokasiShiftBulanTahun($lokasi,$shift,$bulan,$tahun){
        $sql = "select *
                from \"Catering\".t_menu
                where lokasi = ?
                and shift = ?
                and bulan = ?
                and tahun = ?";
        return $this->personalia->query($sql,array($lokasi,$shift,$bulan,$tahun))->result_array();
    }

    public function getTanggalByBulanTahun($bulan,$tahun){
        $sql = "select to_char(dates.dates::date,'dd')::int as tanggal
                from generate_series(
                    concat(?,'-',?,'-01')::date,
                    concat(?,'-',?,'-01')::date + interval '1 month' - interval '1 day', 
                    interval '1 day'
                ) as dates;";
        return $this->personalia->query($sql,array($tahun,$bulan,$tahun,$bulan))->result_array();
    }

    public function getSayur(){
        $sql = "select distinct unnest(string_to_array(t.sayur, ',')) as text
                from \"Catering\".t_menu_detail t
                order by 1";
        return $this->personalia->query($sql)->result_array();
    }

    public function getLaukUtama(){
        $sql = "select distinct unnest(string_to_array(t.lauk_utama, ',')) as text
                from \"Catering\".t_menu_detail t
                order by 1";
        return $this->personalia->query($sql)->result_array();
    }

    public function getLaukPendamping(){
        $sql = "select distinct unnest(string_to_array(t.lauk_pendamping, ',')) as text
                from \"Catering\".t_menu_detail t
                order by 1";
        return $this->personalia->query($sql)->result_array();
    }

    public function getBuah(){
        $sql = "select distinct unnest(string_to_array(t.buah, ',')) as text
                from \"Catering\".t_menu_detail t
                order by 1";
        return $this->personalia->query($sql)->result_array();
    }

    public function insertMenu($data){
        $this->personalia->insert("\"Catering\".t_menu",$data);
        return $this->personalia->insert_id();
    }

    public function updateMenuByMenuId($data,$menu_id){
        $this->personalia->where('menu_id', $menu_id);
        $this->personalia->update('"Catering".t_menu', $data);
    }

    public function insertMenuDetail($data){
        $this->personalia->insert("\"Catering\".t_menu_detail",$data);
        return $this->personalia->insert_id();   
    }

    public function updateMenuDetailByMenuDetailId($data,$menu_detail_id){
        $this->personalia->where('menu_detail_id',$menu_detail_id);
        $this->personalia->update("\"Catering\".t_menu_detail",$data);
    }

    public function getMenuDetailByMenuIdTanggal($menu_id,$tanggal){
        $sql = "select *
                from \"Catering\".t_menu_detail
                where menu_id = ?
                and tanggal = ?";
        return $this->personalia->query($sql,array($menu_id,$tanggal))->result_array();
    }

    public function getMenuDetailByMenuIdBulanTahun($menu_id,$tahun,$bulan,$tahun,$bulan){
        $sql = "select to_char(dates.dates::date,'dd')::int as tanggal,tmd.sayur,tmd.lauk_utama,tmd.lauk_pendamping,tmd.buah
                from generate_series(
                    concat(?,'-',?,'-01')::date,
                    concat(?,'-',?,'-01')::date + interval '1 month' - interval '1 day', 
                    interval '1 day'
                ) as dates
                left join \"Catering\".t_menu_detail tmd
                on to_char(dates.dates::date,'dd')::int = tmd.tanggal
                and tmd.menu_id = ?
                order by 1;";
        return $this->personalia->query($sql,array($tahun,$bulan,$tahun,$bulan,$menu_id))->result_array();
    }

    public function getMenuAll(){
        $sql = "select *
                from \"Catering\".t_menu
                order by tahun desc, bulan desc, shift";
        return $this->personalia->query($sql)->result_array();
    }

    public function deleteMenuByMenuId($menu_id){
        $this->personalia->where('menu_id',$menu_id);
        $this->personalia->delete('"Catering".t_menu');
    }

    public function deleteMenuDetailByMenuId($menu_id){
        $this->personalia->where('menu_id',$menu_id);
        $this->personalia->delete('"Catering".t_menu_detail');
    }

    public function getMenuByMenuId($menu_id){
        $sql = "select *
                from \"Catering\".t_menu
                where menu_id = ?";
        return $this->personalia->query($sql,array($menu_id))->result_array();
    }

    public function getmenuDetailByMenuId($menu_id){
        $sql = "select *
                from \"Catering\".t_menu_detail
                where menu_id = ?
                order by tanggal";
        return $this->personalia->query($sql,array($menu_id))->result_array();
    }

    public function getMenuForExport($awal_bulan, $akhir_bulan, $where_tahun, $where_bulan, $where_shift, $where_lokasi, $lokasi, $shift){
        $where = $where_tahun." and ".$where_bulan;
        if ($where_shift != "") {
            $where .= " and ".$where_shift;
        }
        if ($where_lokasi != "") {
            $where .= " and ".$where_lokasi;
        }

        $sql = "select coalesce(tbl2.menu_id,0) as menu_id,
                    coalesce(tbl2.menu_detail_id,0) as menu_detail_id,
                    coalesce(tbl2.tahun,extract(year from tbl1.tbl1)) as tahun,
                    coalesce(tbl2.bulan,extract(month from tbl1.tbl1)) as bulan,
                    coalesce(tbl2.tanggal,extract(day from tbl1.tbl1)) as tanggal,
                    coalesce(tbl2.shift, $shift) as shift,
                    coalesce(tbl2.lokasi, $lokasi) as lokasi,
                    coalesce(tbl2.sayur,'') as sayur,
                    coalesce(tbl2.lauk_utama,'') as lauk_utama,
                    coalesce(tbl2.lauk_pendamping,'') as lauk_pendamping,
                    coalesce(tbl2.buah,'') as buah
                from generate_series(
                    $awal_bulan, $akhir_bulan, interval '1 day'
                ) as tbl1 
                left join (
                    select t1.menu_id,
                        t2.menu_detail_id,
                        t1.tahun,
                        t1.bulan,
                        t2.tanggal,
                        t1.shift,
                        t1.lokasi,
                        t2.sayur,
                        t2.lauk_utama,
                        t2.lauk_pendamping,
                        t2.buah
                    from \"Catering\".t_menu t1 
                    left join \"Catering\".t_menu_detail t2 
                    on t1.menu_id = t2.menu_id
                    where $where
                ) as tbl2
                on tbl1.tbl1 = concat(tbl2.tahun,'-',tbl2.bulan,'-',tbl2.tanggal)::date";
        return $this->personalia->query($sql)->result_array();
    }

} ?>