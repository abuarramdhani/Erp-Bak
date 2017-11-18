<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetjeniskendaraan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function getFleetJenisKendaraan($id = FALSE)
    {
    	if ($id === FALSE) {
            $ambilJenisKendaraan    = " select  jeniskdrn.jenis_kendaraan_id as kode_jenis_kendaraan,
                                                jeniskdrn.jenis_kendaraan as jenis_kendaraan,
                                                to_char(jeniskdrn.creation_date,'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat
                                        from    ga.ga_fleet_jenis_kendaraan as jeniskdrn
                                        where   (
                                                    jeniskdrn.end_date='9999-12-12 00:00:00'
                                                    or  jeniskdrn.end_date=null
                                                );";

    		$query = $this->db->query($ambilJenisKendaraan);
    	} else {
            $ambilJenisKendaraan    = " select  jeniskdrn.jenis_kendaraan_id as kode_jenis_kendaraan,
                                                jeniskdrn.jenis_kendaraan as jenis_kendaraan,
                                                to_char(jeniskdrn.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                to_char(jeniskdrn.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                        from    ga.ga_fleet_jenis_kendaraan as jeniskdrn
                                        where   jeniskdrn.jenis_kendaraan_id=$id;";
    		$query = $this->db->query($ambilJenisKendaraan);
    	}

    	return $query->result_array();
    }

    public function getFleetJenisKendaraanDeleted()
    {
        $ambilJenisKendaraanDeleted     = " select  jeniskdrn.jenis_kendaraan_id as kode_jenis_kendaraan,
                                                    jeniskdrn.jenis_kendaraan as jenis_kendaraan,
                                                    to_char(jeniskdrn.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                    to_char(jeniskdrn.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                            from    ga.ga_fleet_jenis_kendaraan as jeniskdrn
                                            where   jeniskdrn.end_date!='9999-12-12 00:00:00';";
        $query                          =   $this->db->query($ambilJenisKendaraanDeleted);
        return $query->result_array();
    }

    public function setFleetJenisKendaraan($data)
    {
        return $this->db->insert('ga.ga_fleet_jenis_kendaraan', $data);
    }

    public function updateFleetJenisKendaraan($data, $id)
    {
        $this->db->where('jenis_kendaraan_id', $id);
        $this->db->update('ga.ga_fleet_jenis_kendaraan', $data);
    }

    public function deleteFleetJenisKendaraan($id)
    {
        $tanggal_eksekusi       = date('Y-m-d H:i:s');
        $DeleteJenisKendaraan   = " update  ga.ga_fleet_jenis_kendaraan
                                            set     end_date='$tanggal_eksekusi'
                                            where   jenis_kendaraan_id=$id;";
        $this->db->query($DeleteJenisKendaraan);
    }
}

/* End of file M_fleetjeniskendaraan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetjeniskendaraan.php */
/* Generated automatically on 2017-08-05 13:18:43 */