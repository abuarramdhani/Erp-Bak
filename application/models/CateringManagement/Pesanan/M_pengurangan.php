<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pengurangan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);
    }

    public function getActiveEmployeebyKey($key){
    	$sql= "select noind,trim(nama) as nama
				from hrd_khs.tpribadi
				where keluar = '0'
				and (
					upper(noind) like concat(upper(?),'%')
					or 
					upper(nama) like concat('%',upper(?),'%')
					)";
    	return $this->personalia->query($sql,array($key,$key))->result_array();
    }

    public function getListPenguranganByTanggal($tanggal){
        $sql = "select
                        trim(ts.shift) shift,
                        tpp.fs_tempat_makanpg,
                        fn_jml_tdkpesan,
                        fs_tempat_makan,
                        fb_tm,
                        id_pengurangan,
                       case when fb_kategori = '1' then 
                            'Tidak Makan ( Ganti Uang )'
                        when fb_kategori = '2' then 
                            'Pindah Tempat Makan'
                        when fb_kategori = '3' then 
                            'Tugas Ke Pusat'
                        when fb_kategori = '4' then 
                            'Tugas Ke Tuksono'
                        when fb_kategori = '5' then 
                            'Tugas Ke Mlati'
                        when fb_kategori = '6' then 
                            'Tugas Luar'
                        when fb_kategori = '7' then 
                            'Dinas Perusahaan ( Kunjungan Kerja / Layat / dll )'
                        when fb_kategori = '8' then 
                            'Tidak Makan ( Tidak diganti Uang )'
                        when fb_kategori is null then 
                            case when fb_tm = '1' then 
                                'Tidak Makan ( Tidak diganti Uang )'
                            else 
                                'Pindah Tempat Makan'
                            end
                        end as fb_kategori
                From \"Catering\".tpenguranganpesanan tpp
                left join \"Presensi\".tshift ts 
                on ts.kd_shift = tpp.fs_kd_shift
                Where 
                    tpp.fs_kd_shift = ts.kd_shift
                    and tpp.fd_tanggal= ?";
        return $this->personalia->query($sql,array($tanggal))->result_array();
    }

    public function getKatering(){
        $sql = "select 
                    fs_tempat_makan,
                    case when fs_lokasi = '1' then 
                        'Yogyakarta'
                    when fs_lokasi = '2' then 
                        'Tuksono'
                    when fs_lokasi = '3' then 
                        'Mlati'
                    else
                        'Tidak Diketahui'
                    end as lokasi
                from \"Catering\".ttempat_makan
                order by fs_lokasi,fs_tempat_makan";
        return $this->personalia->query($sql)->result_array();
    }

    public function getPenguranganByIdPengurangan($id_pengurangan){
        $sql = "select *
                From \"Catering\".tpenguranganpesanan tpp
                left join \"Presensi\".tshift ts 
                on ts.kd_shift = tpp.fs_kd_shift
                Where tpp.id_pengurangan = ?";
        return $this->personalia->query($sql,array($id_pengurangan))->row();
    }

    public function getPenguranganDetailByIdPengurangan($id_pengurangan){
        $sql = "select *
                from \"Catering\".tpenguranganpesanan_detail
                where id_pengurangan = ? ";
        return $this->personalia->query($sql,array($id_pengurangan))->result_array();
    }

    public function getTotalTambahanByTempatMakanTanggalShift($tempat_makan,$tanggal,$shift){
        $sql = "select coalesce(
                    (
                        select sum(fn_jumlah_pesanan)
                        from \"Catering\".tpesanantambahan
                        where fd_tanggal = ?
                        and fs_tempat_makan = ?
                        and fs_kd_shift = ?
                    ),
                    0
                ) as jumlah";
        return $this->personalia->query($sql, array($tanggal, $tempat_makan, $shift))->row();
    }

    public function getTotalPenguranganByTempatMakanTanggalShift($tempat_makan,$tanggal,$shift){
        $sql = "select coalesce(
                    (
                        select sum(fn_jml_tdkpesan)
                        from \"Catering\".tpenguranganpesanan
                        where fd_tanggal = ?
                        and fs_tempat_makan = ?
                        and fs_kd_shift = ?
                    ),
                    0
                ) as jumlah";
        return $this->personalia->query($sql, array($tanggal, $tempat_makan, $shift))->row();
    }

    public function updatePesananByTempatMakanTanggalShift($data,$tempat_makan,$tanggal,$shift){
        $this->personalia->where('fs_tempat_makan',$tempat_makan);
        $this->personalia->where('fd_tanggal',$tanggal);
        $this->personalia->where('fs_kd_shift',$shift);
        $this->personalia->update('"Catering".tpesanan',$data);
    }

    public function deletePenguranganDetailByIdPengurangan($id_pengurangan){
        $this->personalia->where('id_pengurangan',$id_pengurangan);
        $this->personalia->delete('"Catering".tpenguranganpesanan_detail');
    }

    public function deletePenguranganByIdPengurangan($id_pengurangan){
        $this->personalia->where('id_pengurangan',$id_pengurangan);
        $this->personalia->delete('"Catering".tpenguranganpesanan');
    }

    public function getPesananByTempatMakanTanggalShift($tempat_makan,$tanggal,$shift){
        $sql = "select *
                from \"Catering\".tpesanan
                where fd_tanggal = ?
                and fs_tempat_makan = ?
                and fs_kd_shift = ?";
        return $this->personalia->query($sql, array($tanggal, $tempat_makan, $shift))->row();
    }

    public function getPenguranganDetailByIdPenguranganNoind($id_pengurangan,$noind){
        $sql = "select *
                from \"Catering\".tpenguranganpesanan_detail
                where id_pengurangan = ?
                and fs_noind = ? ";
        return $this->personalia->query($sql,array($id_pengurangan,$noind))->result_array();
    }

    public function insertPenguranganDetail($id_pengurangan,$noind){
        $sql = "insert into \"Catering\".tpenguranganpesanan_detail 
                (id_pengurangan, fs_noind, fs_nama, fs_ket)
                select ?,noind,trim(nama),trim(jabatan)
                from hrd_khs.tpribadi
                where noind = ? ";
        return $this->personalia->query($sql,array($id_pengurangan,$noind));
    }

    public function updatePenguranganJumlahByIdPengurangan($id_pengurangan){
        $sql = "update \"Catering\".tpenguranganpesanan
                set fn_jml_tdkpesan = (
                    select count(distinct fs_noind)
                    from \"Catering\".tpenguranganpesanan_detail
                    where id_pengurangan = ?
                )
                where id_pengurangan = ?";
        return $this->personalia->query($sql,array($id_pengurangan,$id_pengurangan));
    }

    public function getLokasiTempatMakanByTempatMakan($tempat_makan){
        $sql = "select *
                from \"Catering\".ttempat_makan
                where fs_tempat_makan = ? ";
        return $this->personalia->query($sql, array($tempat_makan))->row();
    }

    public function insertPesanan($data){
        $this->personalia->insert('"Catering".tpesanan',$data);
    }

    public function insertPengurangan($data){
        $this->personalia->insert('"Catering".tpenguranganpesanan',$data);
        return $this->personalia->insert_id();
    }

    public function getPenerimaByKeyTempatMakan($key,$tempat_makan){
        $sql = "select noind,trim(nama) as nama
                from hrd_khs.tpribadi
                where keluar = '0'
                and (
                    upper(noind) like concat(upper(?),'%')
                    or upper(nama) like concat('%',upper(?),'%')
                )
                and tempat_makan = ?";
        return $this->personalia->query($sql, array($key,$key,$tempat_makan))->result_array();
    }

    public function getTempatMakanBaruByKeyTempatMakanKategori($key,$tempat_makan,$kategori){
        $sql = "select fs_tempat_makan,
                    case when fs_lokasi = '1' then 
                        'Yogyakarta'
                    when fs_lokasi = '2' then 
                        'Tuksono'
                    when fs_lokasi = '3' then 
                        'Mlati'
                    else
                        'Tidak Diketahui'
                    end as lokasi
                from \"Catering\".ttempat_makan
                where upper(fs_tempat_makan) like upper(concat('%',?,'%'))
                and upper(fs_tempat_makan) != ?
                $kategori";
        return $this->personalia->query($sql, array($key,$tempat_makan))->result_array();   
    }

}

?>