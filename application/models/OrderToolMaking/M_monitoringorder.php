<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoringorder extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->lantoma = $this->load->database('lantuma', true);
        // $this->lantoma = $this->load->database('db_lantoolmaking', true);
    }

    public function getseksiunit($user){
        $oracle = $this->load->database('personalia', true);
        $sql = "select ts.seksi, ts.unit, tp.nama
                from hrd_khs.tseksi ts, hrd_khs.tpribadi tp
                where tp.kodesie = ts.kodesie
                and tp.noind = '$user'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function getuser($user){
        $oracle = $this->load->database('oracle', true);
        $sql = "select distinct ppf.ATTRIBUTE3 nama_user
                from per_people_f ppf
                where ppf.ATTRIBUTE3 like '%$user%'
                order  by 1";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    
    public function gettipeproduk(){
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT NVL (ffvt.description, '000') produk_desc
                    FROM fnd_flex_values ffv, fnd_flex_values_tl ffvt
                WHERE ffv.flex_value_set_id = 1013710
                    AND ffv.flex_value_id = ffvt.flex_value_id
                    AND ffv.end_date_active IS NULL
                    AND ffv.summary_flag = 'N'
                    AND ffv.enabled_flag = 'Y'
                ORDER BY 1";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    
    public function get_no_order(){
        $sql = "SELECT oob.no_order
                FROM otm.otm_order_baru oob
                union
                SELECT oom.no_order
                FROM otm.otm_order_modifikasi oom
                union
                SELECT oor.no_order
                FROM otm.otm_order_rekondisi oor
                order by 1 desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function saveorderbaru($no_order, $tgl_order, $seksi_order, $unit_order, $user, $proposal, $no_proposal, $tgl_usul, $jenis, $gambar_kerja, $skets,
    $kode_komponen, $nama_komponen, $tipe_produk, $tgl_rilis, $mesin, $poin, $proses_ke, $dari, $jml_alat, $distribusi, $dimensi, $flow_sebelum, $flow_sesudah,
    $acuan_alat, $layout, $material, $referensi, $assign_order, $pengorder){
         $sql = "insert into otm.otm_order_baru (no_order, tgl_order, seksi, unit, nama_user, file_proposal, no_proposal, tgl_usulan, jenis, gambar_kerja, skets,
                kode_komponen, nama_komponen, tipe_produk, tgl_rilis, mesin, poin, proses_ke, dari, jumlah_alat, distribusi, dimensi, flow_sebelum, flow_sesudah,
                acuan_alat_bantu, layout_alat_bantu, material_blank, referensi, assign_approval, pengorder)
                values('$no_order', to_timestamp('$tgl_order', 'DD/MM/YYYY'), '$seksi_order', '$unit_order', '$user', '$proposal', '$no_proposal', to_timestamp('$tgl_usul', 'DD/MM/YYYY'), '$jenis', '$gambar_kerja', '$skets',
                '$kode_komponen', '$nama_komponen', '$tipe_produk', to_timestamp('$tgl_rilis', 'DD/MM/YYYY'), '$mesin', '$poin', '$proses_ke', '$dari', '$jml_alat', '$distribusi', '$dimensi', '$flow_sebelum', '$flow_sesudah',
                '$acuan_alat', '$layout', '$material', '$referensi', '$assign_order', '$pengorder')";
        $query = $this->db->query($sql);
        // echo "<pre>";print_r($sql);exit();
    }

    public function saveordermodif($no_order, $tgl_order, $seksi_order, $unit_order, $user, $tgl_usul, $jenis, $gambar_kerja, $skets,
    $kode_komponen, $nama_komponen, $tipe_produk, $tgl_rilis, $no_alat, $poin,$proses_ke, $dari, $alasan, $referensi, $assign_order, $pengorder, $inspect_report){
         $sql = "insert into otm.otm_order_modifikasi (no_order, tgl_order, seksi, unit, nama_user, tgl_usulan, jenis, gambar_kerja, skets,
                kode_komponen, nama_komponen, tipe_produk, tgl_rilis, no_alat_bantu, poin, proses_ke, dari, alasan_modifikasi, referensi, assign_approval, pengorder, inspection_report)
                values('$no_order', to_timestamp('$tgl_order', 'DD/MM/YYYY'), '$seksi_order', '$unit_order', '$user', to_timestamp('$tgl_usul', 'DD/MM/YYYY'), '$jenis', '$gambar_kerja', '$skets',
                '$kode_komponen', '$nama_komponen', '$tipe_produk', to_timestamp('$tgl_rilis', 'DD/MM/YYYY'), '$no_alat', '$poin', '$proses_ke', '$dari', '$alasan', '$referensi', '$assign_order', '$pengorder', '$inspect_report')";
                // echo "<pre>";print_r($sql);exit();
        $query = $this->db->query($sql);
    }

    public function saveorderrekon($no_order, $tgl_order, $seksi_order, $unit_order, $user, $tgl_usul, $jenis, $gambar_kerja, $skets,
    $kode_komponen, $nama_komponen, $tipe_produk, $tgl_rilis, $no_alat, $poin,$proses_ke, $dari, $alasan, $referensi, $assign_order, $pengorder, $inspect_report){
         $sql = "insert into otm.otm_order_rekondisi (no_order, tgl_order, seksi, unit, nama_user, tgl_usulan, jenis, gambar_kerja, skets,
                kode_komponen, nama_komponen, tipe_produk, tgl_rilis, no_alat_bantu, poin, proses_ke, dari, alasan_modifikasi, referensi, assign_approval, pengorder, inspection_report)
                values('$no_order', to_timestamp('$tgl_order', 'DD/MM/YYYY'), '$seksi_order', '$unit_order', '$user', to_timestamp('$tgl_usul', 'DD/MM/YYYY'), '$jenis', '$gambar_kerja', '$skets',
                '$kode_komponen', '$nama_komponen', '$tipe_produk', to_timestamp('$tgl_rilis', 'DD/MM/YYYY'), '$no_alat', '$poin', '$proses_ke', '$dari', '$alasan', '$referensi', '$assign_order', '$pengorder', '$inspect_report')";
        $query = $this->db->query($sql);
    }

    public function getdatabaru($query){
        $sql = "select * from otm.otm_order_baru $query order by no_order desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getdatamodif($query){
        $sql = "select * from otm.otm_order_modifikasi $query order by no_order desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getdatarekondisi($query){
        $sql = "select * from otm.otm_order_rekondisi $query order by no_order desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function hitungbaru(){
        $sql = "select no_order from otm.otm_order_baru";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function hitungmodif(){
        $sql = "select no_order  from otm.otm_order_modifikasi";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function hitungrekon(){
        $sql = "select no_order  from otm.otm_order_rekondisi";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function updatefilemodif($query, $no_order){
        $sql = "update otm.otm_order_modifikasi set $query where no_order = '$no_order'";
        $query = $this->db->query($sql);
    }

    public function updatefilerekon($query, $no_order){
        $sql = "update otm.otm_order_rekondisi set $query where no_order = '$no_order'";
        $query = $this->db->query($sql);
    }

    public function updatefilebaru($query, $no_order){
        $sql = "update otm.otm_order_baru set $query where no_order = '$no_order'";
        $query = $this->db->query($sql);
    }

    public function updatemodif($no_order, $assign_order, $estimasi_finish, $no_alat_tm){
        $sql= "update otm.otm_order_modifikasi
                set assign_order = '$assign_order',
                    estimasi_finish = to_timestamp('$estimasi_finish', 'DD/MM/YYYY'),
                    no_alat_tm = '$no_alat_tm'
                where no_order = '$no_order'";
        $query = $this->db->query($sql);
        // echo "<pre>";print_r($sql);exit();
    }

    public function updaterekon($no_order, $assign_order, $estimasi_finish, $no_alat_tm){
        $sql= "update otm.otm_order_rekondisi
                set assign_order = '$assign_order',
                    estimasi_finish = to_timestamp('$estimasi_finish', 'DD/MM/YYYY'),
                    no_alat_tm = '$no_alat_tm'
                where no_order = '$no_order'";
        $query = $this->db->query($sql);
        // echo "<pre>";print_r($sql);exit();
    }

    public function updatebaru($no_order, $assign_order, $estimasi_finish, $no_alat_tm){
        $sql= "update otm.otm_order_baru
                set no_alat_tm = '$no_alat_tm',
                    assign_order = '$assign_order',
                    estimasi_finish = to_timestamp('$estimasi_finish', 'DD/MM/YYYY')
                where no_order = '$no_order'";
        $query = $this->db->query($sql);
        // echo "<pre>";print_r($sql);exit();
    }

    public function assign_order($no){
        $sql = "SELECT su.user_name, vsu.employee_name
                FROM sys.sys_user su,
                sys.sys_user_application sua,
                sys.sys_user_group_menu sugm,
                sys.sys_module smod,
                sys.vi_sys_user vsu
                WHERE su.user_id = sua.user_id
                AND vsu.user_id = su.user_id
                AND sua.user_group_menu_id = sugm.user_group_menu_id
                AND smod.module_id= sugm.module_id
                AND sugm.user_group_menu_id = 2798 -- 2817 prod, 2798 dev id resp. Order Tool Making - Ass Ka Nit Pengorder
                AND su.user_name like'%$no%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function insertrevisi($no, $person, $nama, $isi, $date){
        $sql = "insert into otm.otm_rev_order (no_order, person, kolom_rev, value_rev, date_rev)
                values('$no', $person, '$nama', '$isi',to_timestamp('$date', 'yyyy-mm-dd hh24:mi:ss'))";
        // echo "<pre>";print_r($sql);exit();
        $query = $this->db->query($sql);
    }
    
    public function cekapproval($no_order){
        $sql = "select person as approval from otm.otm_ket_action where no_order = '$no_order'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function cekrevisi($kolom, $no){
        $sql = "select * from otm.otm_rev_order where kolom_rev = '$kolom' and no_order = '$no' order by person desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function cekaction($no_order, $query){
        $sql = "select * from otm.otm_ket_action where no_order = '$no_order' $query order by person desc, action desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function saveaction($no_order, $siapa, $action, $ket, $date){
        $sql = "insert into otm.otm_ket_action (no_order, person, action, keterangan, approve_date)
                values('$no_order', $siapa, '$action', '$ket', to_timestamp('$date', 'yyyy-mm-dd hh24:mi:ss'))";
        $query = $this->db->query($sql);
    }

    public function updateaction($no_order, $siapa, $action, $ket, $date){
        $sql = "update otm.otm_ket_action 
                set keterangan = '$ket', 
                    action = '$action',  
                    approve_date = to_timestamp('$date', 'yyyy-mm-dd hh24:mi:ss')
                where no_order = '$no_order' and person = $siapa";
        $query = $this->db->query($sql);
    }
    
    public function save_torder($data){
        $this->lantoma->trans_start();
        $this->lantoma->insert('torder',$data);
        $this->lantoma->trans_complete();
      }
      
    public function save_torder_detail($data){
        $this->lantoma->trans_start();
        $this->lantoma->insert('torder_detail',$data);
        $this->lantoma->trans_complete();
      }
    
}