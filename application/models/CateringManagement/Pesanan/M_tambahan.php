<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_tambahan extends CI_Model
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

    public function getListTambahanByTanggal($tanggal){
        $sql = "select  
                    count(tamb.fs_tempat_makan), 
                    tamb.fs_tempat_makan,
                    shf.shift, 
                    tamb.fn_jumlah_pesanan,
                    case when tamb.fb_kategori = '1' then 
                        'Lembur'
                    when tamb.fb_kategori = '2' then 
                        'Shift Tanggung'
                    when tamb.fb_kategori = '3' then 
                        'Tugas Ke Pusat'
                    when tamb.fb_kategori = '4' then 
                        'Tugas Ke Tuksono'
                    when tamb.fb_kategori = '5' then 
                        'Tugas Ke Mlati'
                    when tamb.fb_kategori = '6' then 
                        'Tamu'
                    when tamb.fb_kategori = '7' then 
                        'Cadangan'
                    end fb_kategori, 
                    tamb.id_tambahan, 
                    tamb.fs_pemohon, 
                    tamb.fs_keterangan
                 from \"Catering\".tpesanantambahan tamb 
                 left join \"Presensi\".tshift shf
                 on tamb.fs_kd_shift = shf.kd_shift
                 Where tamb.fd_tanggal= ?
                 group by tamb.fs_tempat_makan, shf.shift, tamb.fn_jumlah_pesanan, tamb.fb_kategori,
                     tamb.id_tambahan , tamb.fs_pemohon, tamb.fs_keterangan
                 order by shf.shift,tamb.fb_kategori,tamb.fs_tempat_makan";
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

    public function getTambahanByIdTambahan($id_tambahan){
        $sql = "select *,
                    (
                        select trim(nama)
                        from hrd_khs.tpribadi tp
                        where tp.noind = tamb.fs_pemohon
                    ) as nama_pemohon
                From \"Catering\".tpesanantambahan tamb
                left join \"Presensi\".tshift ts 
                on ts.kd_shift = tamb.fs_kd_shift
                Where tamb.id_tambahan = ? ";
        return $this->personalia->query($sql,array($id_tambahan))->row();
    }

    public function getTambahanDetailByIdTambahan($id_tambahan){
        $sql = "select *
                from \"Catering\".tpesanantambahan_detail
                where id_tambahan = ? ";
        return $this->personalia->query($sql,array($id_tambahan))->result_array();
    }

    public function getUrutanByTanggalTempatMakanShift($tanggal,$tempat_makan,$shift){
        $sql = "select fs_tanda 
                from \"Catering\".tpesanan 
                where fd_tanggal= ?
                and fs_kd_shift = ?
                and fs_tempat_makan = ? ";
        return $this->personalia->query($sql,array($tanggal,$shift,$tempat_makan))->row();
    }

    public function getTambahanDetailByIdTambahanNoind($id_tambahan, $noind){
        $sql = "select *
                from \"Catering\".tpesanantambahan_detail
                where id_tambahan = ?
                and fs_noind = ? ";
        return $this->personalia->query($sql,array($id_tambahan,$noind))->result_array();
    }

    public function insertTambahanDetail($id_tambahan,$noind){
        $sql = "insert into \"Catering\".tpesanantambahan_detail 
                (id_tambahan, fs_noind, fs_nama, fs_ket)
                select ?,noind,trim(nama),trim(jabatan)
                from hrd_khs.tpribadi
                where noind = ? ";
        return $this->personalia->query($sql,array($id_tambahan,$noind));
    }

    public function updateTambahanJumlahByIdTambahan($id_tambahan){
        $sql = "update \"Catering\".tpesanantambahan
                set fn_jumlah_pesanan = (
                    select count(distinct fs_noind)
                    from \"Catering\".tpesanantambahan_detail
                    where id_tambahan = ?
                )
                where id_tambahan = ?";
        return $this->personalia->query($sql,array($id_tambahan,$id_tambahan));
    }

    public function updateTambahanByIdTambahan($id_tambahan,$data){
        $this->personalia->where('id_tambahan',$id_tambahan);
        $this->personalia->update('"Catering".tpesanantambahan',$data);
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

    public function getPesananByTempatMakanTanggalShift($tempat_makan,$tanggal,$shift){
        $sql = "select *
                from \"Catering\".tpesanan
                where fd_tanggal = ?
                and fs_tempat_makan = ?
                and fs_kd_shift = ?";
        return $this->personalia->query($sql, array($tanggal, $tempat_makan, $shift))->row();
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

    public function insertTambahan($data){
        $this->personalia->insert('"Catering".tpesanantambahan',$data);
        return $this->personalia->insert_id();
    }

    public function deleteTambahanDetailByIdTambahan($id_tambahan){
        $this->personalia->where('id_tambahan',$id_tambahan);
        $this->personalia->delete('"Catering".tpesanantambahan_detail');
    }

    public function deleteTambahanByIdTambahan($id_tambahan){
        $this->personalia->where('id_tambahan',$id_tambahan);
        $this->personalia->delete('"Catering".tpesanantambahan');
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

}

?>