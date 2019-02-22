<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetkir extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        date_default_timezone_set('Asia/Jakarta');
    }

    public function getFleetKir($id = FALSE)
    {
    	if ($id === FALSE) {
            $ambilKIR       = " select  kir.kir_id as kode_kir,
                                        kdrn.nomor_polisi as nomor_polisi,
                                        kir.kendaraan_id as kode_kendaraan,
                                        (select location_name from er.er_location where location_code = kdrn.kode_lokasi_kerja) lokasi,
                                        to_char(kir.tanggal_kir, 'DD-MM-YYYY') as tanggal_kir,
                                        concat_ws('<br/>sampai dengan<br/>', to_char(kir.periode_awal_kir, 'DD-MM-YYYY'), to_char(kir.periode_akhir_kir, 'DD-MM-YYYY')) as periode_kir,
                                        kir.biaya as biaya,
                                        to_char(kir.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                        to_char(kir.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                from    ga.ga_fleet_kir as kir
                                        join    ga.ga_fleet_kendaraan as kdrn
                                            on  kdrn.kendaraan_id=kir.kendaraan_id
                                where   kir.end_date='9999-12-12 00:00:00'
                                order by kir.tanggal_kir desc;";

    		$query = $this->db->query($ambilKIR);
    	} else {
            $ambilKIR       = " select  kir.kir_id as kode_kir,
                                        kdrn.nomor_polisi as nomor_polisi,
                                        kir.kendaraan_id as kode_kendaraan,
                                        (select location_name from er.er_location where location_code = kdrn.kode_lokasi_kerja) lokasi,
                                        to_char(kir.tanggal_kir, 'DD-MM-YYYY') as tanggal_kir,
                                        concat_ws(' - ', to_char(kir.periode_awal_kir, 'DD-MM-YYYY'), to_char(kir.periode_akhir_kir, 'DD-MM-YYYY')) as periode_kir,
                                        kir.biaya as biaya,
                                        to_char(kir.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                        to_char(kir.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                from    ga.ga_fleet_kir as kir
                                        join    ga.ga_fleet_kendaraan as kdrn
                                            on  kdrn.kendaraan_id=kir.kendaraan_id
                                where   kir.kir_id=$id;";

    		$query = $this->db->query($ambilKIR);
    	}

    	return $query->result_array();
    }

    public function getFleetKirCabang($lokasi)
    {
        $query = $this->db->query("select  kir.kir_id as kode_kir,
                                        kdrn.nomor_polisi as nomor_polisi,
                                        kir.kendaraan_id as kode_kendaraan,
                                        (select location_name from er.er_location where location_code = kdrn.kode_lokasi_kerja) lokasi,
                                        to_char(kir.tanggal_kir, 'DD-MM-YYYY') as tanggal_kir,
                                        concat_ws(' - ', to_char(kir.periode_awal_kir, 'DD-MM-YYYY'), to_char(kir.periode_akhir_kir, 'DD-MM-YYYY')) as periode_kir,
                                        kir.biaya as biaya,
                                        to_char(kir.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                        to_char(kir.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                from    ga.ga_fleet_kir as kir
                                        join    ga.ga_fleet_kendaraan as kdrn
                                            on  kdrn.kendaraan_id=kir.kendaraan_id
                                where   kir.kode_lokasi_kerja='$lokasi'
                                        and kir.end_date='9999-12-12 00:00:00'");
        return $query->result_array();
    }

    public function getFleetKirDeleted()
    {
        $ambilKIRDeleted    = " select  kir.kir_id as kode_kir,
                                        kdrn.nomor_polisi as nomor_polisi,
                                        kir.kendaraan_id as kode_kendaraan,
                                        (select location_name from er.er_location where location_code = kdrn.kode_lokasi_kerja) lokasi,
                                        to_char(kir.tanggal_kir, 'DD-MM-YYYY') as tanggal_kir,
                                        concat_ws('<br/>sampai dengan<br/>', to_char(kir.periode_awal_kir, 'DD-MM-YYYY'), to_char(kir.periode_akhir_kir, 'DD-MM-YYYY')) as periode_kir,
                                        kir.biaya as biaya,
                                        to_char(kir.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                        to_char(kir.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                from    ga.ga_fleet_kir as kir
                                        join    ga.ga_fleet_kendaraan as kdrn
                                            on  kdrn.kendaraan_id=kir.kendaraan_id
                                where   kir.end_date!='9999-12-12 00:00:00'
                                order by kir.tanggal_kir desc;";
        $query              =   $this->db->query($ambilKIRDeleted);
        return $query->result_array();
    }

    public function setFleetKir($data)
    {
        return $this->db->insert('ga.ga_fleet_kir', $data);
    }

    public function updateFleetKir($data, $id)
    {
        $this->db->where('kir_id', $id);
        $this->db->update('ga.ga_fleet_kir', $data);
    }

    public function deleteFleetKir($id)
    {
        $waktu_eksekusi     =   date('Y-m-d H:i:s');

        $deleteKIR      = " update  ga.ga_fleet_kir
                            set     end_date='$waktu_eksekusi'
                            where   kir_id=$id;";
        $this->db->query($deleteKIR);
    }

	public function getFleetKendaraan($query_lokasi)
	{
        $ambilKendaraan = "     select  kdrn.kendaraan_id as kode_kendaraan,
                                        kdrn.nomor_polisi as nomor_polisi
                                from    ga.ga_fleet_kendaraan as kdrn
                                where   kdrn.end_date='9999-12-12 00:00:00' $query_lokasi;";

        $query = $this->db->query($ambilKendaraan);

        return $query->result_array();
	}

}

/* End of file M_fleetkir.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetkir.php */
/* Generated automatically on 2017-08-05 13:31:35 */