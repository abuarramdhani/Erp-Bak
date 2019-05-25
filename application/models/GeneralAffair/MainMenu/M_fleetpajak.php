<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetpajak extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        date_default_timezone_set('Asia/Jakarta');
    }

    public function getFleetPajak($id = FALSE)
    {
    	if ($id === FALSE) {
            $ambilPajak     = " select  pjk.pajak_id as kode_pajak,
                                        pjk.periode_akhir_pajak,
                                        (case when pjk.periode_akhir_pajak >= current_date
                                        then (select cast((extract(epoch from pjk.periode_akhir_pajak::timestamp - current_timestamp)) as int)/86400)+1
                                        end) as tgltunggu,
                                        kdrn.nomor_polisi as nomor_polisi,
                                        (select location_name from er.er_location where location_code = kdrn.kode_lokasi_kerja) lokasi,
                                        pjk.kendaraan_id as kode_kendaraan,
                                        to_char(pjk.tanggal_pajak, 'DD-MM-YYYY') as tanggal_pajak,
                                        concat_ws('<br/>sampai dengan<br/>', to_char(pjk.periode_awal_pajak, 'DD-MM-YYYY'), to_char(periode_akhir_pajak,'DD-MM-YYYY')) as periode_pajak,
                                        pjk.biaya as biaya,
                                        to_char(pjk.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                        to_char(pjk.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                from    ga.ga_fleet_pajak as pjk
                                        join    ga.ga_fleet_kendaraan as kdrn
                                            on  kdrn.kendaraan_id=pjk.kendaraan_id
                                where   pjk.end_date='9999-12-12 00:00:00'
                                order by tgltunggu,pjk.tanggal_pajak desc;";

    		$query = $this->db->query($ambilPajak);
    	} else { 
            $ambilPajak     = " select  pjk.pajak_id as kode_pajak,
                                        pjk.periode_akhir_pajak,
                                        (case when pjk.periode_akhir_pajak >= current_date
                                        then (select cast((extract(epoch from pjk.periode_akhir_pajak::timestamp - current_timestamp)) as int)/86400)+1
                                        end) as tgltunggu,
                                        kdrn.nomor_polisi as nomor_polisi,
                                        pjk.kendaraan_id as kode_kendaraan,
                                        (select location_name from er.er_location where location_code = kdrn.kode_lokasi_kerja) lokasi,
                                        to_char(pjk.tanggal_pajak, 'DD-MM-YYYY') as tanggal_pajak,
                                        concat_ws(' - ', to_char(pjk.periode_awal_pajak, 'DD-MM-YYYY'), to_char(periode_akhir_pajak, 'DD-MM-YYYY')) as periode_pajak,
                                        pjk.biaya as biaya,
                                        to_char(pjk.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                        to_char(pjk.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                from    ga.ga_fleet_pajak as pjk
                                        join    ga.ga_fleet_kendaraan as kdrn
                                            on  kdrn.kendaraan_id=pjk.kendaraan_id
                                where   pjk.pajak_id=$id;";

    		$query = $this->db->query($ambilPajak);
    	}

    	return $query->result_array();
    }

    public function getFleetPajakCabang($lokasi)
    {
        $query = $this->db->query("select  pjk.pajak_id as kode_pajak,
                                        pjk.periode_akhir_pajak,
                                        (case when pjk.periode_akhir_pajak >= current_date
                                        then (select cast((extract(epoch from pjk.periode_akhir_pajak::timestamp - current_timestamp)) as int)/86400)+1
                                        end) as tgltunggu,
                                        kdrn.nomor_polisi as nomor_polisi,
                                        pjk.kendaraan_id as kode_kendaraan,
                                        (select location_name from er.er_location where location_code = kdrn.kode_lokasi_kerja) lokasi,
                                        to_char(pjk.tanggal_pajak, 'DD-MM-YYYY') as tanggal_pajak,
                                        concat_ws(' - ', to_char(pjk.periode_awal_pajak, 'DD-MM-YYYY'), to_char(periode_akhir_pajak, 'DD-MM-YYYY')) as periode_pajak,
                                        pjk.biaya as biaya,
                                        to_char(pjk.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                        to_char(pjk.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                from    ga.ga_fleet_pajak as pjk
                                        join    ga.ga_fleet_kendaraan as kdrn
                                            on  kdrn.kendaraan_id=pjk.kendaraan_id
                                where   pjk.kode_lokasi_kerja='$lokasi'
                                        and pjk.end_date='9999-12-12 00:00:00'
                                order by tgltunggu");
        return $query->result_array();
    }

    public function getFleetPajakDeleted()
    {
        $ambilPajakDeleted  = " select  pjk.pajak_id as kode_pajak,
                                        pjk.periode_akhir_pajak,
                                        (case when pjk.periode_akhir_pajak >= current_date
                                        then (select cast((extract(epoch from pjk.periode_akhir_pajak::timestamp - current_timestamp)) as int)/86400)+1
                                        end) as tgltunggu,
                                        kdrn.nomor_polisi as nomor_polisi,
                                        pjk.kendaraan_id as kode_kendaraan,
                                        (select location_name from er.er_location where location_code = kdrn.kode_lokasi_kerja) lokasi,
                                        to_char(pjk.tanggal_pajak, 'DD-MM-YYYY') as tanggal_pajak,
                                        concat_ws('<br/>sampai dengan<br/>', to_char(pjk.periode_awal_pajak, 'DD-MM-YYYY'), to_char(periode_akhir_pajak,'DD-MM-YYYY')) as periode_pajak,
                                        pjk.biaya as biaya,
                                        to_char(pjk.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                        to_char(pjk.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                from    ga.ga_fleet_pajak as pjk
                                        join    ga.ga_fleet_kendaraan as kdrn
                                            on  kdrn.kendaraan_id=pjk.kendaraan_id
                                where   pjk.end_date!='9999-12-12 00:00:00'
                                order by tgltunggu,pjk.tanggal_pajak desc;";
        $query              =   $this->db->query($ambilPajakDeleted);
        return $query->result_array();
    }
    public function setFleetPajak($data)
    {
        return $this->db->insert('ga.ga_fleet_pajak', $data);
    }

    public function updateFleetPajak($data, $id)
    {
        $this->db->where('pajak_id', $id);
        $this->db->update('ga.ga_fleet_pajak', $data);
    }

    public function deleteFleetPajak($id)
    {
        $waktu_eksekusi = date('Y-m-d H:i:s');
        $deletePajak    = " update  ga.ga_fleet_pajak
                            set     end_date='$waktu_eksekusi'
                            where   pajak_id=$id;";

        $this->db->query($deletePajak);
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

/* End of file M_fleetpajak.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetpajak.php */
/* Generated automatically on 2017-08-05 13:29:59 */