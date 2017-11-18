<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_limbahmaster extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getLimbahJenis($id = FALSE)
    {
        if ($id === FALSE) {
            $sql = "select limnis.id_jenis_limbah,
                            limnis.jenis_limbah as limbah_jenis,
                            liman.limbah_satuan as satuan,
                            limer.sumber as sumber_limbah
                    from ga.ga_limbah_jenis as limnis
                        left join ga.ga_limbah_sumber as limer
                        on limnis.id_jenis_limbah = limer.id_jenis_limbah
                        left join ga.ga_limbah_satuan as liman
                        on limnis.id_jenis_limbah=liman.id_jenis_limbah";
        } else {
            $sql = "select limnis.id_jenis_limbah,
                            limnis.jenis_limbah as limbah_jenis,
                            liman.limbah_satuan as satuan,
                            liman.id_satuan as satuan_id,
                            limer.id_sumber as sumber_id,
                            limer.sumber as sumber_limbah
                    from ga.ga_limbah_jenis as limnis
                        left join ga.ga_limbah_sumber as limer
                        on limnis.id_jenis_limbah = limer.id_jenis_limbah
                        left join ga.ga_limbah_satuan as liman
                        on limnis.id_jenis_limbah=liman.id_jenis_limbah
                    where cast(limnis.id_jenis_limbah as integer)=".$id;
        }

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function setLimbahJenis($data)
    {
        return $this->db->insert('ga.ga_limbah_jenis', $data);
    }

    public function setLimbahSatuan($satuan)
    {
        return $this->db->insert('ga.ga_limbah_satuan', $satuan);
    }

    public function setLimbahSumber($sumber)
    {
        return $this->db->insert('ga.ga_limbah_sumber', $sumber);
    }

    public function updateLimbahJenis($data, $id)
    {
        $this->db->where('id_jenis_limbah', $id);
        $this->db->update('ga.ga_limbah_jenis', $data);
    }

    public function updateLimbahSatuan($satuan, $id)
    {
        $this->db->where('id_satuan', $id);
        $this->db->update('ga.ga_limbah_satuan', $satuan);
    }

    public function updateLimbahSumber($sumber, $id)
    {
        $this->db->where('id_sumber', $id);
        $this->db->update('ga.ga_limbah_sumber', $sumber);
    }

    public function deleteLimbahJenis($id)
    {
        $this->db->where('id_jenis_limbah', $id);
        $this->db->delete('ga.ga_limbah_jenis');
    }
}

/* End of file M_limbahjenis.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_limbahjenis.php */
/* Generated automatically on 2017-11-13 08:49:52 */