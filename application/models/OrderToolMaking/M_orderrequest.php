<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_orderrequest extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getseksiunit($user){
        $oracle = $this->load->database('personalia', true);
        $sql = "select ts.seksi, ts.unit
                from hrd_khs.tseksi ts, hrd_khs.tpribadi tp
                where tp.kodesie = ts.kodesie
                and tp.noind = '$user'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function getdatabaru($query){
        $sql = "select * from otm.otm_order_baru $query";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getdatamodif($data){
        $sql = "select * from otm.otm_order_modifikasi $data";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getdatarekondisi($query){
        $sql = "select * from otm.otm_order_rekondisi $query";
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


    public function updateorder($no_order, $user, $no_proposal, $tgl_usul, $jenis, 
    $kode_komponen, $nama_komponen, $tipe_produk, $tgl_rilis, $no_alat_bantu, $poin, $proses_ke, $dari, $alasan, $referensi){
        $sql= "update otm.otm_order_modifikasi
                set nama_user = '$user',
                    no_proposal = '$no_proposal',
                    tgl_usulan = to_timestamp('$tgl_usul', 'DD/MM/YYYY'),
                    jenis = '$jenis',
                    kode_komponen = '$kode_komponen',
                    nama_komponen = '$nama_komponen',
                    tipe_produk = '$tipe_produk',
                    tgl_rilis = to_timestamp('$tgl_rilis', 'DD/MM/YYYY'),
                    no_alat_bantu = '$no_alat_bantu',
                    poin = '$poin',
                    proses_ke = '$proses_ke', dari = '$dari',
                    alasan_modifikasi = '$alasan',
                    referensi = '$referensi'
                where no_order = '$no_order'";
        $query = $this->db->query($sql);
        // echo "<pre>";print_r($sql);exit();
    }

    
    public function updatemodif($no_order, $user, $no_proposal, $tgl_usul, $jenis, 
    $kode_komponen, $nama_komponen, $tipe_produk, $tgl_rilis, $no_alat_bantu, $poin, $proses_ke, $dari, $alasan, $referensi, $action, $keterangan){
        $sql= "update otm.otm_order_modifikasi
                set nama_user = '$user',
                    no_proposal = '$no_proposal',
                    tgl_usulan = to_timestamp('$tgl_usul', 'DD/MM/YYYY'),
                    jenis = '$jenis',
                    kode_komponen = '$kode_komponen',
                    nama_komponen = '$nama_komponen',
                    tipe_produk = '$tipe_produk',
                    tgl_rilis = to_timestamp('$tgl_rilis', 'DD/MM/YYYY'),
                    no_alat_bantu = '$no_alat_bantu',
                    poin = '$poin',
                    proses_ke = '$proses_ke', dari = '$dari',
                    alasan_modifikasi = '$alasan',
                    referensi = '$referensi',
                    action = '$action',
                    keterangan = '$keterangan'
                where no_order = '$no_order'";
        $query = $this->db->query($sql);
        // echo "<pre>";print_r($sql);exit();
    }

    public function updaterekon($no_order, $user, $no_proposal, $tgl_usul, $jenis, 
    $kode_komponen, $nama_komponen, $tipe_produk, $tgl_rilis, $no_alat_bantu, $poin, $proses_ke, $dari, $alasan, $referensi, $action, $keterangan){
        $sql= "update otm.otm_order_rekondisi
                set nama_user = '$user',
                    no_proposal = '$no_proposal',
                    tgl_usulan = to_timestamp('$tgl_usul', 'DD/MM/YYYY'),
                    jenis = '$jenis',
                    kode_komponen = '$kode_komponen',
                    nama_komponen = '$nama_komponen',
                    tipe_produk = '$tipe_produk',
                    tgl_rilis = to_timestamp('$tgl_rilis', 'DD/MM/YYYY'),
                    no_alat_bantu = '$no_alat_bantu',
                    poin = '$poin',
                    proses_ke = '$proses_ke', dari = '$dari',
                    alasan_modifikasi = '$alasan',
                    referensi = '$referensi',
                    action = '$action',
                    keterangan = '$keterangan'
                where no_order = '$no_order'";
        $query = $this->db->query($sql);
        // echo "<pre>";print_r($sql);exit();
    }

    public function updatebaru($no_order, $user, $proposal, $no_proposal, $tgl_usul, $jenis, $gambar_kerja, $skets,
    $kode_komponen, $nama_komponen, $tipe_produk, $tgl_rilis, $mesin, $poin, $proses_ke, $dari, $jml_alat, $distribusi, $dimensi, $flow_sebelum, $flow_sesudah,
    $acuan_alat, $layout, $material, $referensi, $action, $keterangan){
        $sql= "update otm.otm_order_baru
                set nama_user = '$user',
                    no_proposal = '$no_proposal',
                    tgl_usulan = to_timestamp('$tgl_usul', 'DD/MM/YYYY'),
                    jenis = '$jenis',
                    kode_komponen = '$kode_komponen',
                    nama_komponen = '$nama_komponen',
                    tipe_produk = '$tipe_produk',
                    tgl_rilis = to_timestamp('$tgl_rilis', 'DD/MM/YYYY'),
                    mesin = '$mesin',
                    poin = '$poin',
                    proses_ke = '$proses_ke', dari = '$dari',
                    jumlah_alat = '$jml_alat', distribusi = '$distribusi',
                    dimensi = '$dimensi',
                    flow_sebelum = '$flow_sebelum', flow_sesudah = '$flow_sesudah',
                    acuan_alat_bantu = '$acuan_alat', layout_alat_bantu = '$layout',
                    material_blank = '$material',
                    referensi = '$referensi',
                    action = '$action',
                    keterangan = '$keterangan'
                where no_order = '$no_order'";
        $query = $this->db->query($sql);
        // echo "<pre>";print_r($sql);exit();
    }

}