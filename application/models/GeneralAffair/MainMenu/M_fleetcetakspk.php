<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetcetakspk extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getFleetCetakSpk($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->query("select fcspk.*,
                                                fkn.nomor_polisi as no_pol,
                                                fmk.maintenance_kategori as maintenance_kategori,
                                                fbl.nama_bengkel as nama_bengkel,
                                                fbl.alamat_bengkel as alamat_bengkel,
                                                fmkn.merk_kendaraan as merk_kendaraan
                                        from    ga.ga_fleet_cetak_spk as fcspk
                                            left join ga.ga_fleet_kendaraan as fkn
                                            on  fcspk.kendaraan_id=fkn.kendaraan_id
                                            left join ga.ga_fleet_maintenance_kategori as fmk
                                            on  fcspk.maintenance_kategori_id=fmk.maintenance_kategori_id 
                                            left join ga.ga_fleet_bengkel as fbl
                                            on  fcspk.id_bengkel=fbl.bengkel_id
                                            join ga.ga_fleet_merk_kendaraan as fmkn
                                            on fkn.merk_kendaraan_id=fmkn.merk_kendaraan_id");
    	} else {
    		$query = $this->db->query("select fcspk.*,
                                                fkn.nomor_polisi as no_pol,
                                                fmk.maintenance_kategori as maintenance_kategori,
                                                fbl.nama_bengkel as nama_bengkel,
                                                fbl.alamat_bengkel as alamat_bengkel,
                                                fmkn.merk_kendaraan as merk_kendaraan
                                        from    ga.ga_fleet_cetak_spk as fcspk
                                            left join ga.ga_fleet_kendaraan as fkn
                                            on  fcspk.kendaraan_id=fkn.kendaraan_id
                                            left join ga.ga_fleet_maintenance_kategori as fmk
                                            on  fcspk.maintenance_kategori_id=fmk.maintenance_kategori_id 
                                            left join ga.ga_fleet_bengkel as fbl
                                            on  fcspk.id_bengkel=fbl.bengkel_id
                                            join ga.ga_fleet_merk_kendaraan as fmkn
                                            on fkn.merk_kendaraan_id=fmkn.merk_kendaraan_id
                                        where fcspk.surat_id=$id");
    	}

    	return $query->result_array();
    }

    public function getFleetCetakSpkCabang($lokasi)
    {
        $query = $this->db->query("select fcspk.*,
                                                fkn.nomor_polisi as no_pol,
                                                fmk.maintenance_kategori as maintenance_kategori,
                                                fbl.nama_bengkel as nama_bengkel,
                                                fbl.alamat_bengkel as alamat_bengkel,
                                                fmkn.merk_kendaraan as merk_kendaraan
                                        from    ga.ga_fleet_cetak_spk as fcspk
                                            left join ga.ga_fleet_kendaraan as fkn
                                            on  fcspk.kendaraan_id=fkn.kendaraan_id
                                            left join ga.ga_fleet_maintenance_kategori as fmk
                                            on  fcspk.maintenance_kategori_id=fmk.maintenance_kategori_id 
                                            left join ga.ga_fleet_bengkel as fbl
                                            on  fcspk.id_bengkel=fbl.bengkel_id
                                            join ga.ga_fleet_merk_kendaraan as fmkn
                                            on fkn.merk_kendaraan_id=fmkn.merk_kendaraan_id
                                        where fcspk.kode_lokasi_kerja='$lokasi'");
        return $query->result_array();
    }

    public function setFleetCetakSpk($data)
    {
        return $this->db->insert('ga.ga_fleet_cetak_spk', $data);
    }

    public function setFleetCetakSpkDetail($lines)
    {
        return $this->db->insert('ga.ga_fleet_cetak_spk_detail', $lines);
    }

    public function updateFleetCetakSpk($data, $id)
    {
        $this->db->where('surat_id', $id);
        $this->db->update('ga.ga_fleet_cetak_spk', $data);
    }

    public function updateFleetCetakSpkDetail($lines, $id_lines)
    {
        $this->db->where('spk_detail_id', $id_lines);
        $this->db->update('ga.ga_fleet_cetak_spk_detail', $lines);
    }

    public function deleteFleetCetakSpk($id)
    {
        $this->db->where('surat_id', $id);
        $this->db->delete('ga.ga_fleet_cetak_spk');
    }

    public function deleteFleetCetakSpkDetail($id)
    {
        $this->db->where('spk_detail_id', $id);
        $this->db->delete('ga.ga_fleet_cetak_spk_detail');
    }

    public function deleteAllFleetSPKMaintenance($id)
    {
        $this->db->where('surat_id', $id);
        $this->db->delete('ga.ga_fleet_cetak_spk_detail');
    }

	public function getFleetKendaraan($query_lokasi)
	{
		$ambilKendaraan     = " select  kdrn.kendaraan_id as kendaraan_id,
                                        kdrn.nomor_polisi as nomor_polisi
                                from    ga.ga_fleet_kendaraan as kdrn
                                where   kdrn.end_date='9999-12-12 00:00:00' $query_lokasi;";
        $query = $this->db->query($ambilKendaraan);

        return $query->result_array();
	}


	public function getFleetMaintenanceKategori()
	{
		$query = $this->db->get('ga.ga_fleet_maintenance_kategori');

		return $query->result_array();
	}


	public function getFleetBengkel()
	{
		$query = $this->db->get('ga.ga_fleet_bengkel');

		return $query->result_array();
	}

    public function getFleetCetakSpkDetail($id)
    {
        $query = $this->db->get_where('ga.ga_fleet_cetak_spk_detail', array('surat_id' => $id));

        return $query->result_array();
    }

    public function getFleetSPKDetailMaintenance($id)
    {
        $query = $this->db->query("select  fcsd.*,
                                            fjk.jenis_kendaraan
                                    from    ga.ga_fleet_cetak_spk_detail as fcsd
                                        join ga.ga_fleet_cetak_spk as fcs
                                        on fcsd.surat_id=fcs.surat_id
                                        join ga.ga_fleet_kendaraan as fkn
                                        on fcs.kendaraan_id=fkn.kendaraan_id
                                        join ga.ga_fleet_jenis_kendaraan as fjk
                                        on fkn.jenis_kendaraan_id=fjk.jenis_kendaraan_id
                                    where fcsd.surat_id=$id");
        return $query->result_array();
    }

}

/* End of file M_fleetcetakspk.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetcetakspk.php */
/* Generated automatically on 2018-04-11 10:41:51 */