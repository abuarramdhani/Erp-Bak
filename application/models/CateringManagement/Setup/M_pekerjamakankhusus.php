<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pekerjamakankhusus extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);
    }

    public function getPekerjaByKey($key){
    	$sql = "select noind,trim(nama) as nama
    			from hrd_khs.tpribadi 
    			where (
    				upper(trim(nama)) like upper(trim(concat('%',?,'%')))
    				or upper(trim(noind)) like upper(trim(concat(?,'%'))) 
    			)
    			and keluar = '0'";
    	return $this->personalia->query($sql,array($key,$key))->result_array();
    }

    public function updatePekerjaMakanKhususByPekerjaMenuKhususId($data,$pekerja_menu_khusus_id){
    	$this->personalia->where('pekerja_menu_khusus_id',$pekerja_menu_khusus_id);
    	$this->personalia->update('"Catering".t_pekerja_menu_khusus',$data);
    }

    public function insertPekerjaMakanKhusus($data){
    	$this->personalia->insert('"Catering".t_pekerja_menu_khusus',$data);
    }

    public function getPekerjaMakanKhususAll(){
    	$sql = "select t1.*,trim(t2.nama) as nama
    			from \"Catering\".t_pekerja_menu_khusus t1
    			left join hrd_khs.tpribadi t2
    			on t1.noind = t2.noind";
    	return $this->personalia->query($sql)->result_array();
    }

    public function getPekerjaMakanKhususByNoindSayurLaukUtamaLaukPendampingBuah($pekerja,$sayur,$lauk_utama,$lauk_pendamping,$buah){
    	$sql = "select *
    			from \"Catering\".t_pekerja_menu_khusus
    			where noind = ?
    			and menu_sayur = ?
    			and menu_lauk_utama = ?
    			and menu_lauk_pendamping = ?
    			and menu_buah = ?";
    	return $this->personalia->query($sql,array($pekerja,$sayur,$lauk_utama,$lauk_pendamping,$buah))->result_array();
    }

    public function getPekerjaMakanKhususById($id){
    	$sql = "select t1.*,trim(t2.nama) as nama
    			from \"Catering\".t_pekerja_menu_khusus t1
    			left join hrd_khs.tpribadi t2
    			on t1.noind = t2.noind
    			where t1.pekerja_menu_khusus_id = ?";
    	return $this->personalia->query($sql,array($id))->row();
    }

    public function deletePekerjaMakanKhususById($id){
    	$this->personalia->where('pekerja_menu_khusus_id',$id);
    	$this->personalia->delete('"Catering".t_pekerja_menu_khusus');
    }

    public function getPekerjaMakanKhususByStatusLokasi($where_lokasi,$where_status){
        $where = "";
        if ($where_lokasi !== "") {
            $where = " where ".$where_lokasi;
        }
        if ($where_status !== "") {
            if ($where !== "") {
                $where .= " and ".$where_status;
            }else{
                $where = " where ".$where_status;
            }
        }
        $sql = "select t1.*
                from \"Catering\".t_pekerja_menu_khusus t1 
                inner join hrd_khs.tpribadi t2 
                on t1.noind = t2.noind
                inner join \"Catering\".ttempat_makan t3
                on t2.tempat_makan = t3.fs_tempat_makan
                $where";
        return $this->personalia->query($sql)->result_array();
    }

} ?>