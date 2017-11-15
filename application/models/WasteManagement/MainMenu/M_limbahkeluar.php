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
    		$query = "SELECT limar.*, limnis.jenis_limbah as jenis, 
                            liman.limbah_perlakuan as limbah_perlakuan,
                            limsa.limbah_satuan as satuan_limbah
                            FROM ga.ga_limbah_keluar as limar
                            LEFT JOIN ga.ga_limbah_jenis as limnis
                            ON limar.jenis_limbah = limnis.id_jenis_limbah
                            left join ga.ga_limbah_perlakuan as liman
                            on limar.perlakuan = liman.id_perlakuan
                            left join ga.ga_limbah_satuan limsa
                            on cast(limar.satuan as integer)=limsa.id_satuan
                            Order By limar.tanggal_keluar";                          
    	} else {
    		$query = "SELECT limar.*, limnis.jenis_limbah as jenis, 
                            liman.limbah_perlakuan as limbah_perlakuan,
                            limsa.limbah_satuan as satuan_limbah
                            FROM ga.ga_limbah_keluar as limar
                            LEFT JOIN ga.ga_limbah_jenis as limnis
                            ON limar.jenis_limbah = limnis.id_jenis_limbah
                            left join ga.ga_limbah_perlakuan as liman
                            on limar.perlakuan = liman.id_perlakuan
                            left join ga.ga_limbah_satuan as limsa
                            on cast(limar.satuan as integer)=limsa.id_satuan
                            WHERE id_limbah_keluar = $id 
                            Order By limar.tanggal_keluar";
    	}
        $sql = $this->db->query($query);
    	return $sql->result_array();
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
        $sqlperlakuan = "SELECT * FROM ga.ga_limbah_perlakuan";
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
        $sqlGetUser = "SELECT * FROM ga.ga_limbah_user";
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

        $sqlfilterData = "SELECT limar.*, limnis.jenis_limbah as jenis,
                            liman.limbah_perlakuan as limbah_perlakuan,
                            limsa.limbah_satuan as satuan_limbah
                            FROM ga.ga_limbah_keluar as limar
                            LEFT JOIN ga.ga_limbah_jenis as limnis
                            ON limar.jenis_limbah = limnis.id_jenis_limbah
                            left join ga.ga_limbah_perlakuan as liman
                            on limar.perlakuan = liman.id_perlakuan
                            left join ga.ga_limbah_satuan limsa
                            on cast(limar.satuan as integer)=limsa.id_satuan
                            WHERE limar.konfirmasi_status='1' $condition 
                            Order By limar.tanggal_keluar ";

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
                            dmsi.nama_seksi AS sumber,
                            linis.jenis_limbah AS jenis,
                            liman.limbah_perlakuan AS limbah_perlakuan,
                            limsa.limbah_satuan as satuan_limbah   
                    FROM ga.ga_limbah_transaksi AS limsi 
                        LEFT JOIN dm.dm_seksi AS dmsi
                        ON limsi.sumber_limbah=dmsi.seksi_id
                        LEFT JOIN ga.ga_limbah_jenis AS linis
                        ON limsi.jenis_limbah=linis.id_jenis_limbah
                        LEFT JOIN ga.ga_limbah_perlakuan AS liman
                        ON limsi.perlakuan=liman.id_perlakuan
                        left join ga.ga_limbah_satuan as limsa
                        on cast(limsi.satuan as integer)=limsa.id_satuan
                    WHERE limsi.konfirmasi='1' $condition
                    Order By limsi.tanggal_transaksi";
        $query = $this->db->query($sqlfilterData);
        return $query->result_array();
    }

    public function getLimbahTransaksi($id = FALSE)
    {
        if ($id === FALSE) {
            $sql = "SELECT limsi.*, 
                            dmsi.nama_seksi AS sumber,
                            linis.jenis_limbah AS jenis,
                            liman.limbah_perlakuan AS limbah_perlakuan,
                            limsa.limbah_satuan as satuan_limbah  
                    FROM ga.ga_limbah_transaksi AS limsi 
                        LEFT JOIN dm.dm_seksi AS dmsi
                        ON limsi.sumber_limbah=dmsi.seksi_id
                        LEFT JOIN ga.ga_limbah_jenis AS linis
                        ON limsi.jenis_limbah=linis.id_jenis_limbah
                        LEFT JOIN ga.ga_limbah_perlakuan AS liman
                        ON limsi.perlakuan=liman.id_perlakuan
                        left join ga.ga_limbah_satuan as limsa
                        on cast(limsi.satuan as integer)=limsa.id_satuan
                        Order By limsi.tanggal_transaksi";
        } else {
            $sql = "SELECT limsi.*, 
                            dmsi.nama_seksi AS sumber,
                            linis.jenis_limbah AS jenis,
                            liman.limbah_perlakuan AS limbah_perlakuan,
                            limsa.limbah_satuan as satuan_limbah  
                    FROM ga.ga_limbah_transaksi AS limsi 
                        LEFT JOIN dm.dm_seksi AS dmsi
                        ON limsi.sumber_limbah=dmsi.seksi_id
                        LEFT JOIN ga.ga_limbah_jenis AS linis
                        ON limsi.jenis_limbah=linis.id_jenis_limbah
                        LEFT JOIN ga.ga_limbah_perlakuan AS liman
                        ON limsi.perlakuan=liman.id_perlakuan
                        left join ga.ga_limbah_satuan as limsa
                        on cast(limsi.satuan as integer)=limsa.id_satuan
                    WHERE limsi.id_transaksi = $id
                    Order By limsi.tanggal_transaksi";
        }

        $query = $this->db->query($sql);
        return $query->result_array();
    }

}

/* End of file M_limbahkeluar.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_limbahkeluar.php */
/* Generated automatically on 2017-08-09 12:34:02 */