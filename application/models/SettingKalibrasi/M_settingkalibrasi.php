<?php if 
(!defined('BASEPATH')) exit('No direct script access allowed');

class M_settingkalibrasi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle', true);
        //$this->oracle_dev = $this->load->database('oracle_dev', true);
        $this->personalia = $this->load->database('personalia', true);
    }

    public function setting()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getKalibrasi()
    {
      return $this->db->query("SELECT sk.id id,
                               sk.no_alat_ukur no_alat_ukur,
                               sk.jenis_alat_ukur jenis_alat_ukur,
                               sk.last_calibration last_calibration,
                               sk.next_calibration next_calibration,
                               sk.lead_time lead_time,
                               sk.status status
                        FROM sca.setting_kalibrasi sk
                        WHERE sk.status='ACTIVE'
                        ORDER BY id
                        ")->result_array();
    }

    
    public function getKalibrasiInactive()
    {
      return $this->db->query("SELECT sk.id id,
                               sk.no_alat_ukur no_alat_ukur,
                               sk.jenis_alat_ukur jenis_alat_ukur,
                               sk.last_calibration last_calibration,
                               sk.next_calibration next_calibration,
                               sk.lead_time lead_time,
                               sk.status status
                        FROM sca.setting_kalibrasi sk
                        WHERE sk.status='INACTIVE'
                        ORDER BY id
                        ")->result_array();
    }

    public function checkNoAlatUkur($no_alat_ukur)
    {
      return $this->db->query("SELECT sk.no_alat_ukur
                        FROM sca.setting_kalibrasi sk
                        WHERE sk.no_alat_ukur = '$no_alat_ukur'")->result_array();
    }

    public function tambahKalibrasi($data)
    {
      return $this->db->insert('sca.setting_kalibrasi', $data);
    }

    public function deleteKalibrasi($id)
    {
      return $this->db->query("DELETE FROM sca.setting_kalibrasi WHERE id = '$id'");
    }

    public function updateKalibrasi($id, $no_alat_ukur, $jenis_alat_ukur, $last_calibration, $next_calibration, $lead_time, $status)
    {
        return $this->db->query("UPDATE sca.setting_kalibrasi
                            SET no_alat_ukur = '$no_alat_ukur',
                                jenis_alat_ukur = '$jenis_alat_ukur',
                                last_calibration = '$last_calibration',
                                next_calibration = '$next_calibration',
                                lead_time = '$lead_time',
                                status = '$status'
                            WHERE id = '$id'");
    }
 
    public function checkNoAlatUkurExcept($no_alat_ukur, $no_alat_ukur_first)
    {
      return $this->db->query("SELECT sk.no_alat_ukur
                        FROM sca.setting_kalibrasi sk
                        WHERE sk.no_alat_ukur != '$no_alat_ukur_first'
                        AND sk.no_alat_ukur = '$no_alat_ukur'")->result_array();
    }
}