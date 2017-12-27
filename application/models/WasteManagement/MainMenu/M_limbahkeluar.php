<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_limbahkeluar extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getLimbahKeluar($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = "SELECT limar.* ,
                            limnis.jenis_limbah,
                            limnis.id_jenis_limbah,
                            liman.limbah_perlakuan
                        from ga.ga_limbah_keluar as limar
                            left join ga.ga_limbah_jenis as limnis
                            on limar.jenis_limbah = limnis.id_jenis_limbah
                            left join ga.ga_limbah_perlakuan as liman
                            on limar.perlakuan = liman.id_perlakuan";                          
    	} else {
    		$query = "SELECT limar.* ,
                            limnis.jenis_limbah,
                            limnis.id_jenis_limbah,
                            liman.limbah_perlakuan
                        from ga.ga_limbah_keluar as limar
                            left join ga.ga_limbah_jenis as limnis
                            on limar.jenis_limbah = limnis.id_jenis_limbah
                            left join ga.ga_limbah_perlakuan as liman
                            on limar.perlakuan = liman.id_perlakuan
                        WHERE id_limbah_keluar = '".$id."'";
    	}
        $sql = $this->db->query($query);
    	return $sql->result_array();
    }

    function LimbahWaiting(){
        $sql    = "SELECT limar.* ,
                            limnis.jenis_limbah,
                            limnis.id_jenis_limbah,
                            liman.limbah_perlakuan
                        from ga.ga_limbah_keluar as limar
                            left join ga.ga_limbah_jenis as limnis
                            on limar.jenis_limbah = limnis.id_jenis_limbah
                            left join ga.ga_limbah_perlakuan as liman
                            on limar.perlakuan = liman.id_perlakuan
                        where konfirmasi_status='0'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function setLimbahKeluar($data)
    {
        return $this->db->insert('ga.ga_limbah_keluar', $data);
    }

    public function updateLimbahKeluar($data, $id)
    {
        $this->db->where('id_limbah_keluar', $id);
        $this->db->update('ga.ga_limbah_keluar', $data);
    }

    public function deleteLimbahKeluar($id)
    {
        $this->db->where('id_limbah_keluar', $id);
        $this->db->delete('ga.ga_limbah_keluar');
    }

    public function getJenisLimbah()
    {
        $sqlgetJenisLimbah = "SELECT * FROM ga.ga_limbah_jenis";
        $query = $this->db->query($sqlgetJenisLimbah);
        return $query->result_array();
    }

    public function getPerlakuan()
    {
        $sqlperlakuan = "SELECT * FROM ga.ga_limbah_perlakuan order by id_perlakuan";
        $query = $this->db->query($sqlperlakuan);
        return $query->result_array();
    }

    public function getSatuan()
    {
        $sqlgetSatuan = "SELECT * FROM ga.ga_limbah_satuan";
        $query = $this->db->query($sqlgetSatuan);
        return $query->result_array();
    }

    public function approval($id)
    {
        $sqlApproval = "UPDATE ga.ga_limbah_keluar
                            SET konfirmasi_status=1
                            WHERE id_limbah_keluar=$id";
        $query = $this->db->query($sqlApproval);
    }

    public function reject($id)
    {
        $sqlReject = "UPDATE ga.ga_limbah_keluar
                            SET konfirmasi_status=2
                            WHERE id_limbah_keluar=$id";
        $query = $this->db->query($sqlReject);
    }

    public function getUser()
    {
        $sqlGetUser = "SELECT * FROM ga.ga_limbah_user Order by nama";
        $query = $this->db->query($sqlGetUser);
        return $query->result_array();
    }

    public function filterLimbahKeluar($tanggalawal = FALSE,$tanggalakhir = FALSE, $jenislimbah = FALSE)
    {   
        $condition = '';
        if($jenislimbah == '' && $tanggalawal == '') {
            $condition = '';
        } else if($jenislimbah == true || $tanggalawal == true) {
            if($jenislimbah == true && $tanggalawal == true) {
                $condition = "and limar.jenis_limbah='$jenislimbah' and limar.tanggal_keluar BETWEEN '$tanggalawal' AND '$tanggalakhir'";
            } elseif($jenislimbah != '') {
                $condition = "and limar.jenis_limbah='$jenislimbah'";    
            } elseif($tanggalawal != '') {
                $condition = "and limar.tanggal_keluar BETWEEN '$tanggalawal' AND '$tanggalakhir'";    
            }
        }

        $sqlfilterData = "SELECT limar.* ,
                            limnis.jenis_limbah,
                            liman.limbah_perlakuan
                        from ga.ga_limbah_keluar as limar
                            left join ga.ga_limbah_jenis as limnis
                            on limar.jenis_limbah = limnis.id_jenis_limbah
                            left join ga.ga_limbah_perlakuan as liman
                            on limar.perlakuan = liman.id_perlakuan
                            WHERE limar.konfirmasi_status='1' $condition 
                            Order By limar.tanggal_keluar";

        $query = $this->db->query($sqlfilterData);
        return $query->result_array();
    }

    public function filterLimbahMasuk($tanggalawal = FALSE,$tanggalakhir = FALSE, $jenislimbah = FALSE)
    {
        $condition = '';
        if($jenislimbah == '' && $tanggalawal == '') {
            $condition = '';
        } else if($jenislimbah == true || $tanggalawal == true) {
            if($jenislimbah == true && $tanggalawal == true) {
                $condition = "and limsi.jenis_limbah='$jenislimbah' and limsi.tanggal_transaksi BETWEEN '$tanggalawal' AND '$tanggalakhir'";
            } elseif($jenislimbah != '') {
                $condition = "and limsi.jenis_limbah='$jenislimbah'";   
            } elseif($tanggalawal != '') {
                $condition = "and limsi.tanggal_transaksi BETWEEN '$tanggalawal' AND '$tanggalakhir'";    
            }
        }

        $sqlfilterData = "SELECT limsi.*,
                            limnis.jenis_limbah,
                            liman.limbah_perlakuan,
                            dmsi.nama_seksi
                    from ga.ga_limbah_transaksi as limsi
                        left join ga.ga_limbah_jenis limnis
                            on limsi.jenis_limbah = limnis.id_jenis_limbah
                        left join ga.ga_limbah_perlakuan as liman
                            on limsi.perlakuan = liman.id_perlakuan
                        left join dm.dm_seksi as dmsi
                            on limsi.sumber_limbah=dmsi.seksi_id
                    WHERE limsi.konfirmasi='1' $condition
                    Order By limsi.tanggal_transaksi";
        $query = $this->db->query($sqlfilterData);
        return $query->result_array();
    }

    public function getLimbahTransaksi($id = FALSE)
    {
        if ($id === FALSE) {
            $sql = "SELECT limsi.*,
                            limnis.jenis_limbah,
                            liman.limbah_perlakuan,
                            dmsi.nama_seksi
                    from ga.ga_limbah_transaksi as limsi
                        left join ga.ga_limbah_jenis limnis
                            on limsi.jenis_limbah = limnis.id_jenis_limbah
                        left join ga.ga_limbah_perlakuan as liman
                            on limsi.perlakuan = liman.id_perlakuan
                        left join dm.dm_seksi as dmsi
                            on limsi.sumber_limbah=dmsi.seksi_id";
        } else {
            $sql = "SELECT limsi.*,
                            limnis.jenis_limbah,
                            liman.limbah_perlakuan,
                            dmsi.nama_seksi
                    from ga.ga_limbah_transaksi as limsi
                        left join ga.ga_limbah_jenis limnis
                            on limsi.jenis_limbah = limnis.id_jenis_limbah
                        left join ga.ga_limbah_perlakuan as liman
                            on limsi.perlakuan = liman.id_perlakuan
                        left join dm.dm_seksi as dmsi
                            on limsi.sumber_limbah=dmsi.seksi_id
                    WHERE limsi.id_transaksi = '".$id."'";
        }

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function selectSatuanLimbah($id_JenisLimbah){
        $sql="select * from ga.ga_limbah_satuan where id_jenis_limbah='".$id_JenisLimbah."'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function selectSumberLimbah($id_JenisLimbah){
        $sql="select * from ga.ga_limbah_sumber where id_jenis_limbah='".$id_JenisLimbah."'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}

/* End of file M_limbahkeluar.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_limbahkeluar.php */
/* Generated automatically on 2017-08-09 12:34:02 */