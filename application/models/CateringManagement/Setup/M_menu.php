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

} ?>