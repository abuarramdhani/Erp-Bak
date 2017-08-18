<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_limbah extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getLimbah($id = FALSE)
    {
        if($id === FALSE) {
    	   $sql = "SELECT galim.*, dmsi.nama_seksi AS seksi, linis.jenis_limbah AS limbahjenis  
                    FROM ga.ga_limbah as galim 
                        left join dm.dm_seksi as dmsi
                            on galim.seksi_kirim=dmsi.seksi_id
                        left join ga.ga_limbah_jenis as linis
                            on galim.jenis_limbah=linis.id_jenis_limbah
                        Order By galim.tanggal_kirim";
        } else {
            $sql = "SELECT galim.*, dmsi.nama_seksi AS seksi, linis.jenis_limbah AS limbahjenis  
                    FROM ga.ga_limbah as galim 
                        left join dm.dm_seksi as dmsi
                            on galim.seksi_kirim=dmsi.seksi_id
                        left join ga.ga_limbah_jenis as linis
                            on galim.jenis_limbah=linis.id_jenis_limbah 
                    WHERE galim.limbah_id = $id
                    Order By galim.tanggal_kirim";
        }


        $query = $this->db->query($sql);
    	return $query->result_array();
    }

    public function setLimbah($data)
    {
        return $this->db->insert('ga.ga_limbah', $data);
    }

    public function updateLimbah($data, $id)
    {
        $this->db->where('limbah_id', $id);
        $this->db->update('ga.ga_limbah', $data);
    }

    public function deleteLimbah($id)
    {
        $this->db->where('limbah_id', $id);
        $this->db->delete('ga.ga_limbah');
    }

    public function getSeksi() 
    {
        $sqlgetSeksi = "SELECT * FROM dm.dm_seksi";
        $query = $this->db->query($sqlgetSeksi);
        return $query->result_array();
    }

    public function getJenisLimbah()
    {
        $sqlgetJenisLimbah = "SELECT * FROM ga.ga_limbah_jenis";
        $query = $this->db->query($sqlgetJenisLimbah);
        return $query->result_array();
    } 

}

/* End of file M_limbah.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_limbah.php */
/* Generated automatically on 2017-07-31 10:47:07 */