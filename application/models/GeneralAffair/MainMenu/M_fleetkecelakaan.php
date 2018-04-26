<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetkecelakaan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        date_default_timezone_set('Asia/Jakarta');

    }

    public function getFleetKecelakaan($id = FALSE)
    {
    	if ($id === FALSE) {
            $ambilKecelakaan    = " select  kecelakaan.kecelakaan_id as kode_kecelakaan,
                                            kecelakaan.kendaraan_id as kode_kendaraan,
                                            kdrn.nomor_polisi as nomor_polisi,
                                            to_char(kecelakaan.tanggal_kecelakaan, 'DD-MM-YYYY HH24:MI:SS') as tanggal_kecelakaan,
                                            kecelakaan.sebab as sebab,
                                            kecelakaan.biaya_perusahaan as biaya_perusahaan,
                                            kecelakaan.biaya_pekerja as biaya_pekerja,
                                            kecelakaan.pekerja as id_pekerja,
                                            concat_ws('<br/>', pkj.employee_code, pkj.employee_name) as pekerja,
                                            kecelakaan.status_asuransi as status_asuransi,
                                            to_char(kecelakaan.tanggal_cek_asuransi, 'DD-MM-YYYY') as tanggal_cek_asuransi,
                                            to_char(kecelakaan.tanggal_masuk_bengkel, 'DD-MM-YYYY HH24:MI:SS') as tanggal_masuk_bengkel,
                                            to_char(kecelakaan.tanggal_keluar_bengkel, 'DD-MM-YYYY HH24:MI:SS') as tanggal_keluar_bengkel,
                                            kecelakaan.foto_masuk_bengkel as foto_masuk_bengkel,
                                            kecelakaan.foto_keluar_bengkel as foto_keluar_bengkel,
                                            to_char(kecelakaan.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                            to_char(kecelakaan.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                    from    ga.ga_fleet_kecelakaan as kecelakaan
                                            join    ga.ga_fleet_kendaraan as kdrn
                                                on  kdrn.kendaraan_id=kecelakaan.kendaraan_id
                                            join    er.er_employee_all as pkj
                                                on  pkj.employee_id=kecelakaan.pekerja
                                    where   kecelakaan.end_date='9999-12-12 00:00:00'
                                    order by kecelakaan.tanggal_kecelakaan desc;";

    		$query = $this->db->query($ambilKecelakaan);
    	} else {
            $ambilKecelakaan    = " select  kecelakaan.kecelakaan_id as kode_kecelakaan,
                                            kecelakaan.kendaraan_id as kode_kendaraan,
                                            kdrn.nomor_polisi as nomor_polisi,
                                            to_char(kecelakaan.tanggal_kecelakaan, 'DD-MM-YYYY HH24:MI:SS') as tanggal_kecelakaan,
                                            kecelakaan.sebab as sebab,
                                            kecelakaan.biaya_perusahaan as biaya_perusahaan,
                                            kecelakaan.biaya_pekerja as biaya_pekerja,
                                            kecelakaan.pekerja as id_pekerja,
                                            concat_ws(' - ', pkj.employee_code, pkj.employee_name) as pekerja,
                                            kecelakaan.status_asuransi as status_asuransi,
                                            to_char(kecelakaan.tanggal_cek_asuransi, 'DD-MM-YYYY') as tanggal_cek_asuransi,
                                            to_char(kecelakaan.tanggal_masuk_bengkel, 'DD-MM-YYYY HH24:MI:SS') as tanggal_masuk_bengkel,
                                            to_char(kecelakaan.tanggal_keluar_bengkel, 'DD-MM-YYYY HH24:MI:SS') as tanggal_keluar_bengkel,
                                            kecelakaan.foto_masuk_bengkel as foto_masuk_bengkel,
                                            kecelakaan.foto_keluar_bengkel as foto_keluar_bengkel,
                                            to_char(kecelakaan.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                            to_char(kecelakaan.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                    from    ga.ga_fleet_kecelakaan as kecelakaan
                                            join    ga.ga_fleet_kendaraan as kdrn
                                                on  kdrn.kendaraan_id=kecelakaan.kendaraan_id
                                            join    er.er_employee_all as pkj
                                                on  pkj.employee_id=kecelakaan.pekerja
                                    where   kecelakaan.kecelakaan_id=$id;";

            $query = $this->db->query($ambilKecelakaan);
    	}

    	return $query->result_array();
    }

    public function getFleetKecelakaanCabang($lokasi)
    {
        $query = $this->db->query("select  kecelakaan.kecelakaan_id as kode_kecelakaan,
                                            kecelakaan.kendaraan_id as kode_kendaraan,
                                            kdrn.nomor_polisi as nomor_polisi,
                                            to_char(kecelakaan.tanggal_kecelakaan, 'DD-MM-YYYY HH24:MI:SS') as tanggal_kecelakaan,
                                            kecelakaan.sebab as sebab,
                                            kecelakaan.biaya_perusahaan as biaya_perusahaan,
                                            kecelakaan.biaya_pekerja as biaya_pekerja,
                                            kecelakaan.pekerja as id_pekerja,
                                            concat_ws(' - ', pkj.employee_code, pkj.employee_name) as pekerja,
                                            kecelakaan.status_asuransi as status_asuransi,
                                            to_char(kecelakaan.tanggal_cek_asuransi, 'DD-MM-YYYY') as tanggal_cek_asuransi,
                                            to_char(kecelakaan.tanggal_masuk_bengkel, 'DD-MM-YYYY HH24:MI:SS') as tanggal_masuk_bengkel,
                                            to_char(kecelakaan.tanggal_keluar_bengkel, 'DD-MM-YYYY HH24:MI:SS') as tanggal_keluar_bengkel,
                                            kecelakaan.foto_masuk_bengkel as foto_masuk_bengkel,
                                            kecelakaan.foto_keluar_bengkel as foto_keluar_bengkel,
                                            to_char(kecelakaan.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                            to_char(kecelakaan.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                    from    ga.ga_fleet_kecelakaan as kecelakaan
                                            join    ga.ga_fleet_kendaraan as kdrn
                                                on  kdrn.kendaraan_id=kecelakaan.kendaraan_id
                                            join    er.er_employee_all as pkj
                                                on  pkj.employee_id=kecelakaan.pekerja
                                    where   kecelakaan.kode_lokasi_kerja='$lokasi'
                                            and kecelakaan.end_date='9999-12-12 00:00:00'");
        return $query->result_array();
    }

    public function getFleetKecelakaanDeleted()
    {
        $ambilKecelakaanDeleted     = " select  kecelakaan.kecelakaan_id as kode_kecelakaan,
                                                kecelakaan.kendaraan_id as kode_kendaraan,
                                                kdrn.nomor_polisi as nomor_polisi,
                                                to_char(kecelakaan.tanggal_kecelakaan, 'DD-MM-YYYY HH24:MI:SS') as tanggal_kecelakaan,
                                                kecelakaan.sebab as sebab,
                                                kecelakaan.biaya_perusahaan as biaya_perusahaan,
                                                kecelakaan.biaya_pekerja as biaya_pekerja,
                                                kecelakaan.pekerja as id_pekerja,
                                                concat_ws('<br/>', pkj.employee_code, pkj.employee_name) as pekerja,
                                                kecelakaan.status_asuransi as status_asuransi,
                                                to_char(kecelakaan.tanggal_cek_asuransi, 'DD-MM-YYYY') as tanggal_cek_asuransi,
                                                to_char(kecelakaan.tanggal_masuk_bengkel, 'DD-MM-YYYY HH24:MI:SS') as tanggal_masuk_bengkel,
                                                to_char(kecelakaan.tanggal_keluar_bengkel, 'DD-MM-YYYY HH24:MI:SS') as tanggal_keluar_bengkel,
                                                kecelakaan.foto_masuk_bengkel as foto_masuk_bengkel,
                                                kecelakaan.foto_keluar_bengkel as foto_keluar_bengkel,
                                                to_char(kecelakaan.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                to_char(kecelakaan.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                        from    ga.ga_fleet_kecelakaan as kecelakaan
                                                join    ga.ga_fleet_kendaraan as kdrn
                                                    on  kdrn.kendaraan_id=kecelakaan.kendaraan_id
                                                join    er.er_employee_all as pkj
                                                    on  pkj.employee_id=kecelakaan.pekerja
                                        where   kecelakaan.end_date!='9999-12-12 00:00:00'
                                        order by kecelakaan.tanggal_kecelakaan desc;";
        $query  =   $this->db->query($ambilKecelakaanDeleted);
        return $query->result_array();
    }

    public function setFleetKecelakaan($data)
    {
        return $this->db->insert('ga.ga_fleet_kecelakaan', $data);
    }

    public function updateFleetKecelakaan($data, $id)
    {
        $this->db->where('kecelakaan_id', $id);
        $this->db->update('ga.ga_fleet_kecelakaan', $data);
    }

    public function deleteFleetKecelakaan($id)
    {
        $waktu_eksekusi     = date('Y-m-d H:i:s');

        $deleteKecelakaan   = " update  ga.ga_fleet_kecelakaan
                                set     end_date='$waktu_eksekusi'
                                where   kecelakaan_id=$id";

        $this->db->query($deleteKecelakaan);
    }

	public function getFleetKendaraan()
	{
        $ambilKendaraan     = " select  kdrn.kendaraan_id as kode_kendaraan,
                                        kdrn.nomor_polisi as nomor_polisi
                                from    ga.ga_fleet_kendaraan as kdrn
                                where   kdrn.end_date='9999-12-12 00:00:00';";
        $query = $this->db->query($ambilKendaraan);

        return $query->result_array();
	}


	public function getEmployeeAll()
	{
        $ambilDaftarNama    = " select      pkj.employee_id as id_pekerja,
                                            concat_ws(' - ', pkj.employee_code, pkj.employee_name) as daftar
                                from        er.er_employee_all as pkj
                                where       pkj.resign=0
                                            and     pkj.employee_code!='Z0000'
                                order by    pkj.employee_code;";
        $query              =   $this->db->query($ambilDaftarNama);
        return $query->result_array();
	}
	
	public function getFleetKecelakaanDetail($id)
	{
        $ambilKecelakaanDetail  = " select  *
                                    from    ga.ga_fleet_kecelakaan_detail as kecelakaandtl
                                    where   kecelakaandtl.kecelakaan_id=$id
                                            and     kecelakaandtl.end_date='9999-12-12 00:00:00';";

        $query                  = $this->db->query($ambilKecelakaanDetail);
		
		return $query->result_array();
	}

	public function setFleetKecelakaanDetail($data)
	{
		return $this->db->insert('ga.ga_fleet_kecelakaan_detail', $data);
	}

	public function updateFleetKecelakaanDetail($data, $id)
	{
		$this->db->where('kecelakaan_detail_id', $id);
        $this->db->update('ga.ga_fleet_kecelakaan_detail', $data);
	}

    public function deleteFleetKecelakaanDetail($id)
    {
        $waktu_eksekusi                     = date('Y-m-d H:i:s');
        $deleteKecelakaanDetail             = " update  ga.ga_fleet_kecelakaan_detail
                                                set     end_date='$waktu_eksekusi'
                                                where   kecelakaan_detail_id=$id";
        $query                              =   $this->db->query($deleteKecelakaanDetail);
    }

}

/* End of file M_fleetkecelakaan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetkecelakaan.php */
/* Generated automatically on 2017-08-05 13:58:40 */