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
    		$query = "SELECT limar.*, limnis.jenis_limbah as jenis
                            FROM ga.ga_limbah_keluar as limar
                            LEFT JOIN ga.ga_limbah_jenis as limnis
                            ON limar.jenis_limbah = limnis.id_jenis_limbah";                          
    	} else {
    		$query = "SELECT limar.*, limnis.jenis_limbah as jenis
                            FROM ga.ga_limbah_keluar as limar
                            LEFT JOIN ga.ga_limbah_jenis as limnis
                            ON limar.jenis_limbah = limnis.id_jenis_limbah
                            WHERE id_limbah_keluar = $id";
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

    public function filterData($tanggalawal = FALSE,$tanggalakhir = FALSE, $jenislimbah = FALSE)
    {   
        $condition = '';
        if($jenislimbah != '') {
            $condition = "and limar.jenis_limbah='$jenislimbah'";
        } elseif($tanggalawal === '') {
            $condition = "and limar.tanggal_keluar BETWEEN '$tanggalawal' AND '$tanggalakhir'";
        }

        if($jenislimbah == true && $tanggalawal == true) {
            $condition = "and limar.jenis_limbah='$jenislimbah' and limar.tanggal_keluar BETWEEN '$tanggalawal' AND '$tanggalakhir'";
        }

        if($jenislimbah=='' && $tanggalawal=='') {
            $condition = '';
        }

        $sqlfilterData = "SELECT limar.*, limnis.jenis_limbah as jenis
                            FROM ga.ga_limbah_keluar as limar
                            LEFT JOIN ga.ga_limbah_jenis as limnis
                            ON limar.jenis_limbah = limnis.id_jenis_limbah
                            WHERE limar.konfirmasi_status='1'".$condition;
        $query = $this->db->query($sqlfilterData);
        return $query->result_array();
    }


}

/* End of file M_limbahkeluar.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_limbahkeluar.php */
/* Generated automatically on 2017-08-09 12:34:02 */