<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_agent extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', true);
        $this->oracle = $this->load->database('oracle', true);
    }

    public function viewOrder()
    {
        $sql = "SELECT * FROM tm.order
                ORDER BY no_order";
        return $this->db->query($sql)->result_array();
    }

    public function viewById($id)
    {
        $sql = "SELECT * FROM tm.order WHERE no_order = '$id'
                ORDER BY no_order";
        // echo $sql;exit();
        return $this->db->query($sql)->result_array();
    }

    public function viewOnlyId($id)
    {
        $sql = "SELECT no_order FROM tm.order WHERE no_order = '$id'";
        return $this->db->query($sql)->result_array();
    }

    public function viewLaporanPerbaikan($id)
    {
        $sql = "SELECT * FROM tm.laporan_perbaikan WHERE no_order = '$id'";
        return $this->db->query($sql)->result_array();
    }

    public function viewLangkahPerbaikan($id)
    {
        $sql = "SELECT * FROM tm.langkah_perbaikan WHERE id_laporan = '$id'
                ORDER BY urutan";
        return $this->db->query($sql)->result_array();
    }

    public function viewAllLangkahPerbaikan($id_laporan)
    {
        $sql = "SELECT * FROM tm.laporan_perbaikan lp, tm.langkah_perbaikan hp
                WHERE lp.id_laporan = '$id_laporan' AND hp.id_laporan = '$id_laporan'
                ORDER BY hp.urutan";
        return $this->db->query($sql)->result_array();
    }

    public function insertLaporanPerbaikan($no_order,$kerusakan,$penyebab,$langkah_pencegahan,$ver_perbaikan)
    {
        $sql = "INSERT INTO tm.laporan_perbaikan(no_order, kerusakan, penyebab_kerusakan, langkah_pencegahan, verifikasi_perbaikan) 
        values('$no_order','$kerusakan','$penyebab','$langkah_pencegahan','$ver_perbaikan')";
        // echo $sql;
        // exit();
        $query = $this->db->query($sql);
    }

    public function updateLaporanPerbaikan($kerusakan,$penyebab,$langkah_pencegahan,$ver_perbaikan,$id_laporan,$no_order)
    {
        $sql = "UPDATE tm.laporan_perbaikan
                SET
                -- SET no_order ='$no_order',
                kerusakan = '$kerusakan',
                penyebab_kerusakan = '$penyebab', 
                langkah_pencegahan = '$langkah_pencegahan',
                verifikasi_perbaikan = '$ver_perbaikan' 
                WHERE id_laporan = '$id_laporan' AND no_order='$no_order'";
        // echo $sql;
        // exit();
        $query = $this->db->query($sql);
    }

    public function deleteLangkahPerbaikan($id_laporan)
    {
        $sql = "DELETE FROM tm.langkah_perbaikan 
                WHERE id_laporan='$id_laporan'";

        $query = $this->db->query($sql);
    }

    function selectIdLaporanPerbaikan($no_order) 
	{
		$sql = "SELECT MAX (id_laporan) id 
                FROM tm.laporan_perbaikan 
                WHERE no_order='$no_order'";
				
        return $this->db->query($sql)->result_array();
    }

    function selectIdLapEr() 
	{
		$sql = "SELECT id_laporan 
				FROM tm.laporan_perbaikan";
				
        return $this->db->query($sql)->result_array();
    }
    
    function slcIdLaporanPerbaikan($id_laporan)
    {
        $sql = "SELECT id_laporan FROM tm.laporan_perbaikan 
                WHERE id_laporan = '$id_laporan'";
        return $this->db->query($sql)->result_array();
    }

    public function insertLangkahPerbaikan($langkah)
    {
    	$this->db->insert('tm.langkah_perbaikan',$langkah);
        return;
    }

    function Pelaksana($pls)
	{
        $sql = "SELECT noind, nama FROM hrd_khs.tpribadi 
                WHERE nama LIKE '%$pls%' 
                OR noind LIKE '%$pls%'";

        // $sql = "SELECT noind, nama FROM hrd_khs.tpribadi tp, hrd_khs.tseksi ts
        // WHERE tp.nama LIKE '%$pls%' 
        // OR tp.noind LIKE '%$pls%'
        // AND ts.seksi = '$seksi'
        // AND ts.unit = '$unit'";
            
        return $this->personalia->query($sql)->result_array();
    }

    function selectNamaPengorder()
    {
        $sql = "SELECT * ,(select employee_name from er.er_employee_all 
                where employee_code = tm.noind_pengorder) as name FROM tm.order tm ORDER BY no_order";
        return $this->db->query($sql)->result_array();   
    }

    function getIdReparasi($no_induk)
    {
        $sql = "SELECT id_laporan FROM tm.laporan_perbaikan WHERE no_order = '$no_induk'";
        return $this->db->query($sql)->result_array();
    }

    function slcIdReparasi($no_order)
    {
        $sql = "SELECT MAX (id_reparasi) id 
        FROM tm.reparasi";
        
        return $this->db->query($sql)->result_array();
    }

    function selectIdReparasi($no_order)
    {
        $sql = "SELECT * FROM tm.reparasi
                WHERE no_order = '$no_order'";
        return $this->db->query($sql)->result_array();
    }

    function insertReparasi($no_order,$tgl_reparasi,$jam_mulai,$jam_selesai)
    {
        $sql = "INSERT INTO tm.reparasi(no_order, tgl_reparasi, jam_mulai_reparasi, jam_selesai_reparasi) 
        values('$no_order','$tgl_reparasi','$jam_mulai','$jam_selesai')";
        // echo $sql;
        // exit();
        $query = $this->db->query($sql);
    }

    function insertPelaksanaReparasi($pelaksana)
    {
    	$this->db->insert('tm.pelaksana_reparasi',$pelaksana);
        return;
    }

    function slcAllReparation($id)
    {
        $sql= "SELECT *,(select string_agg(trim(nama), ', ') 
               from tm.pelaksana_reparasi where id_reparasi = rp.id_reparasi) as nama from tm.reparasi rp where rp.no_order = '$id'";
        
        return $this->db->query($sql)->result_array();
    }

    function viewDataReparasi($id_reparasi)
    {
        $sql = "SELECT * FROM tm.reparasi
                WHERE no_order = '$id_reparasi'";
        return $this->db->query($sql)->result_array();
    }

    function viewPelaksanaReparasi($id_reparasi)
    {
        $sql = "SELECT * FROM tm.pelaksana_reparasi
                WHERE id_reparasi = '$id_reparasi'";
        return $this->db->query($sql)->result_array();
    }
    
    function viewReparasi($id)
    {
        $sql = "SELECT * FROM tm.reparasi
                WHERE no_order = '$id'";
        return $this->db->query($sql)->result_array();
    }
    
    function deleteRiwayatReparasi($id_reparasi)
    {
        $sql = "DELETE FROM tm.reparasi
        WHERE id_reparasi='$id_reparasi'";
        // echo $sql;exit();
        $query = $this->db->query($sql);
    }

    function deletePelaksanaReparasi($id_reparasi)
    {
        $sql = "DELETE FROM tm.pelaksana_reparasi
        WHERE id_reparasi='$id_reparasi'";
        // echo $sql;exit();
        $query = $this->db->query($sql);
    }

    function insertSparepart($no_order,$nama,$spesifikasi,$jumlah)
    {
        $sql = "INSERT INTO tm.spare_part(no_order, nama_sparepart, spesifikasi, jumlah) 
        values('$no_order','$nama','$spesifikasi','$jumlah')";
        // echo $sql;
        // exit();
        $query = $this->db->query($sql);
    }

    public function viewSparePart($id)
    {
        $sql = "SELECT * FROM tm.spare_part WHERE no_order = '$id'";
        return $this->db->query($sql)->result_array();
    }

    public function deleteSparepart($id)
    {
		$sql = "DELETE FROM tm.spare_part
                WHERE id_sparepart='$id'";
                // AND no_order = '$no_order'
		// echo $sql;exit();
        $query = $this->db->query($sql);    
    }

    public function insertKeterlambatan($no_order,$alasan,$mulai,$selesai)
    {
        $sql = "INSERT INTO tm.keterlambatan(no_order, alasan, waktu_mulai, waktu_selesai) 
        values('$no_order','$alasan','$mulai','$selesai')";
        // echo $sql;
        // exit();
        $query = $this->db->query($sql);
    }

    public function viewKeterlambatan($id)
    {
        $sql = "SELECT * FROM tm.keterlambatan WHERE no_order = '$id'";
        // echo $sql; exit();
        return $this->db->query($sql)->result_array();
    }

    public function updateLastResponse($now,$id)
    {
        $sql = "UPDATE tm.order 
                SET last_response = '$now'
                WHERE no_order = '$id'";
        // echo $sql;exit();
        $query = $this->db->query($sql);
    }

    public function savePerkiraanSelesai($noind,$tgl_order_diterima,$perkiraan_selesai,$id)
    {
        $sql = "UPDATE tm.order
                SET noind_penerima = '$noind',
                    tgl_order_diterima ='$tgl_order_diterima',
                    perkiraan_selesai = '$perkiraan_selesai'
                WHERE no_order='$id'";
        // echo $sql;
        // exit();
        $query = $this->db->query($sql);
    }

    public function saveReject($tgl_reject,$reason,$id)
    {
        $sql = "UPDATE tm.order
                SET reject ='$tgl_reject',
                alasan_reject ='$reason'
                WHERE no_order='$id'";
        // echo $sql;
        // exit();
        $query = $this->db->query($sql);        
    }

    public function updateStatus($status,$no_order)
    {
        $sql = "UPDATE tm.order
        SET status_order ='$status'
        WHERE no_order='$no_order'";
        // echo $sql;
        // exit();
        $query = $this->db->query($sql);    
    }

    public function saveDone($noind,$now,$id)
    {
        $sql = "UPDATE tm.order
        SET noind_penyelesai ='$noind',
            tgl_order_selesai ='$now'
        WHERE no_order='$id'";
        // echo $sql;
        // exit();
        $query = $this->db->query($sql);    
    }

    public function slcStatus($no_order)
    {
        $sql = "SELECT status_order FROM tm.order
                WHERE no_order = '$no_order'";
        return $this->db->query($sql)->result_array();
    }

    public function slcSparepart($sp)
    {
        $sql = "SELECT msib.segment1 item, msib.description
                FROM mtl_system_items_b msib
                WHERE msib.organization_id = 81
                AND msib.segment1 LIKE '%$sp%'
                OR msib.description LIKE '%$sp%'";
	   $query = $this->oracle->query($sql);
       return $query->result_array();
       //    return $sql;
    }

    public function viewLateById($id)
    {
        $sql = "SELECT * FROM tm.keterlambatan WHERE no_order = '$id'";
        // echo $sql;exit();
        return $this->db->query($sql)->result_array();
    }

    public function updateDueDate($update_duedate,$id)
    {
        $sql = "UPDATE tm.order 
                SET perkiraan_selesai = '$update_duedate'
                WHERE no_order = '$id'";
        // echo $sql;exit();
        $query = $this->db->query($sql);
    }

    public function slcTanggalMax($no_order)
    {
        $sql = "SELECT MAX(waktu_selesai) FROM tm.keterlambatan
                WHERE no_order = '$no_order'";
        return $this->db->query($sql)->result_array();
    }

	function Seksi($term)
	{
        
        $sql = "SELECT DISTINCT seksi FROM hrd_khs.tseksi
                WHERE seksi LIKE '%$term%' ";

        return $this->personalia->query($sql)->result_array();
    }
    
    function saveMasterKodeSeksi($nama_seksi,$kode_seksi)
    {
        $sql = "INSERT INTO tm.master_kode_seksi(nama_seksi, kode_seksi) 
        values('$nama_seksi','$kode_seksi')";
        // echo $sql;
        // exit();
        $query = $this->db->query($sql);        
    }

    function viewKodeSeksi()
    {
        $sql = "SELECT * FROM tm.master_kode_seksi
                ORDER BY id_seksi";
        return $this->db->query($sql)->result_array();

    }

    function selectSeksiMaster($nama_seksi)
    {
        $sql = "SELECT nama_seksi FROM tm.master_kode_seksi
                WHERE nama_seksi = '$nama_seksi'";
        // echo $sql;exit();
        return $this->db->query($sql)->result_array();
    }

    public function updateMasterKodeSeksi($kode_seksi,$nama_seksi)
    {
        $sql = "UPDATE tm.master_kode_seksi 
                SET kode_seksi = '$kode_seksi'
                WHERE nama_seksi = '$nama_seksi'";
        // echo $sql;exit();
        $query = $this->db->query($sql);
    }

    public function deleteKodeSeksi($id)
    {
		$sql = "DELETE FROM tm.master_kode_seksi
                WHERE id_seksi='$id'";
                // AND no_order = '$no_order'
		// echo $sql;exit();
        $query = $this->db->query($sql);    
    }
     
    //RECAP BY DATE RANGE
    function selectRekapReparasi($tgl_reparasi_awal,$tgl_reparasi_akhir)
    {
        $sql = "SELECT r.*, o.nama_mesin, o.seksi, o.tgl_order, ((DATE_PART('hour', jam_selesai_reparasi::time - jam_mulai_reparasi::time) * 60 +
                DATE_PART('minute', jam_selesai_reparasi::time - jam_mulai_reparasi::time)) +
                DATE_PART('second', jam_selesai_reparasi::time - jam_mulai_reparasi::time)) as range FROM tm.reparasi r
                inner join tm.order o on o.no_order = r.no_order and r.tgl_reparasi between '$tgl_reparasi_awal' and '$tgl_reparasi_akhir' 
                order by 1";
        // echo $sql;exit();

        return $this->db->query($sql)->result_array();
    }

    //RECAP BY MACHINES
   function selectRecapByMesin($nama_mesin)
   {
        $sql = "SELECT r.*, o.nama_mesin, o.seksi, o.tgl_order, ((DATE_PART('hour', jam_selesai_reparasi::time - jam_mulai_reparasi::time) * 60 +
                DATE_PART('minute', jam_selesai_reparasi::time - jam_mulai_reparasi::time)) +
                DATE_PART('second', jam_selesai_reparasi::time - jam_mulai_reparasi::time)) as range FROM tm.reparasi r
                inner join tm.order o on o.no_order = r.no_order WHERE o.nomor_mesin IN ('$nama_mesin')
                order by 1";
        // echo $sql;die;
        return $this->db->query($sql)->result_array();
   }

   //RECAP BY SEKSI
   function selectRecapBySeksi($seksi)
   {
        $sql = "SELECT r.*, o.nama_mesin, o.seksi, o.tgl_order, ((DATE_PART('hour', jam_selesai_reparasi::time - jam_mulai_reparasi::time) * 60 +
                DATE_PART('minute', jam_selesai_reparasi::time - jam_mulai_reparasi::time)) +
                DATE_PART('second', jam_selesai_reparasi::time - jam_mulai_reparasi::time)) as range FROM tm.reparasi r
                inner join tm.order o on o.no_order = r.no_order WHERE o.seksi= '$seksi'
                order by 1";

        return $this->db->query($sql)->result_array();
   }

   function selectNamaMesin($ms)
   {
       $low     = strtolower($ms);
       $lcfirst = lcfirst($ms);
       $ucfirst = ucfirst($ms);
       $ucwords = ucwords($ms);

       $sql = "SELECT DISTINCT nama_mesin, nomor_mesin  FROM tm.order 
               WHERE nama_mesin LIKE '%$ms%'
               OR nomor_mesin LIKE '%$ms%'
            --    OR nama_mesin LIKE '%$low%'
            --    nama_mesin LIKE '%$lcfirst%' OR nama_mesin LIKE '%$ucfirst%'
            --    OR nama_mesin LIKE '%$ucwords%'
               ";
    //    echo $sql;exit();
       return $this->db->query($sql)->result_array();
   }

   function selectNamaSeksi($sk)
   {
       $low     = strtolower($sk);
       $lcfirst = lcfirst($sk);
       $ucfirst = ucfirst($sk);
       $ucwords = ucwords($sk);

       $sql = "SELECT DISTINCT seksi FROM tm.order 
               WHERE seksi LIKE '%$sk%'
            --    OR nama_mesin LIKE '%$low%'
            --    nama_mesin LIKE '%$lcfirst%' OR nama_mesin LIKE '%$ucfirst%'
            --    OR nama_mesin LIKE '%$ucwords%'
               ";
       // echo $sql;exit();
       return $this->db->query($sql)->result_array();
   }




} 