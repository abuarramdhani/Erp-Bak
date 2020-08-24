<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetkendaraan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); 
        $this->p = $this->load->database('personalia',TRUE);
        date_default_timezone_set('Asia/Jakarta');
    }
    public function pic_kendaraan($p)
    {
        $query = "select noind,nama from hrd_khs.tpribadi where keluar='0' and (nama like '%$p%' or noind like '%$p%')";
        return $this->p->query($query)->result_array();
    }

    public function FleetLokasiKerja()
    {
        $query = "select * from er.er_location";
        return $this->db->query($query)->result_array();
    }
    public function getFleetKendaraan($id = FALSE)
    {
        if ($id === FALSE) {
            $ambilKendaraan     = " select      kdrn.kendaraan_id as kode_kendaraan,
                                                kdrn.nomor_polisi as nomor_polisi,kdrn.nomor_rangka as nomor_rangka,
                                                kdrn.tag_number as tag_number,
                                                jeniskdrn.jenis_kendaraan_id as kode_jenis_kendaraan,
                                                jeniskdrn.jenis_kendaraan as jenis_kendaraan,
                                                merkkdrn.merk_kendaraan_id as kode_merk_kendaraan,
                                                merkkdrn.merk_kendaraan as merk_kendaraan,
                                                merkkdrn.kapasitas_bahanbakar as kapasitas_bahanbakar,
                                                (select location_name from er.er_location where location_code = kdrn.kode_lokasi_kerja) lokasi,
                                                warnakdrn.warna_kendaraan_id as kode_warna_kendaraan,
                                                warnakdrn.warna_kendaraan as warna_kendaraan,
                                                kdrn.tahun_pembuatan as tahun_pembuatan,
                                                kdrn.pic_kendaraan,
                                                kdrn.foto_stnk as foto_stnk,
                                                kdrn.foto_bpkb as foto_bpkb,
                                                kdrn.usable,
                                                kdrn.hak_milik,
                                                kdrn.foto_kendaraan as foto_kendaraan,
                                                to_char(kdrn.start_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                to_char(kdrn.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                    from        ga.ga_fleet_kendaraan as kdrn
                                                join    ga.ga_fleet_jenis_kendaraan as jeniskdrn
                                                    on  jeniskdrn.jenis_kendaraan_id=kdrn.jenis_kendaraan_id
                                                join    ga.ga_fleet_merk_kendaraan as merkkdrn
                                                    on  merkkdrn.merk_kendaraan_id=kdrn.merk_kendaraan_id
                                                join    ga.ga_fleet_warna_kendaraan as warnakdrn
                                                    on  warnakdrn.warna_kendaraan_id=kdrn.warna_kendaraan_id
                               
                                    where       kdrn.end_date = '9999-12-12 00:00:00'
                                    order by    kdrn.kendaraan_id;";

            $query = $this->db->query($ambilKendaraan);
    	} else {
            $ambilKendaraan     ="  select      kdrn.kendaraan_id as kode_kendaraan,
                                                kdrn.nomor_polisi as nomor_polisi,kdrn.nomor_rangka as nomor_rangka,
                                                kdrn.tag_number as tag_number,
                                                jeniskdrn.jenis_kendaraan_id as kode_jenis_kendaraan,
                                                jeniskdrn.jenis_kendaraan as jenis_kendaraan,
                                                merkkdrn.merk_kendaraan_id as kode_merk_kendaraan,
                                                merkkdrn.merk_kendaraan as merk_kendaraan,
                                                merkkdrn.kapasitas_bahanbakar as kapasitas_bahanbakar,
                                                (select location_name from er.er_location where location_code = kdrn.kode_lokasi_kerja) lokasi,
                                                warnakdrn.warna_kendaraan_id as kode_warna_kendaraan,
                                                warnakdrn.warna_kendaraan as warna_kendaraan,
                                                kdrn.tahun_pembuatan as tahun_pembuatan,
                                                kdrn.pic_kendaraan,
                                                kdrn.foto_stnk as foto_stnk,
                                                kdrn.foto_bpkb as foto_bpkb,
                                                kdrn.usable,
                                                kdrn.hak_milik,
                                                kdrn.foto_kendaraan as foto_kendaraan,
                                                to_char(kdrn.start_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                to_char(kdrn.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                    from        ga.ga_fleet_kendaraan as kdrn
                                                join    ga.ga_fleet_jenis_kendaraan as jeniskdrn
                                                    on  jeniskdrn.jenis_kendaraan_id=kdrn.jenis_kendaraan_id
                                                join    ga.ga_fleet_merk_kendaraan as merkkdrn
                                                    on  merkkdrn.merk_kendaraan_id=kdrn.merk_kendaraan_id
                                                join    ga.ga_fleet_warna_kendaraan as warnakdrn
                                                    on  warnakdrn.warna_kendaraan_id=kdrn.warna_kendaraan_id
                               
                                    where       kdrn.kendaraan_id=$id
                                    order by    kdrn.kendaraan_id;";
            $query              =   $this->db->query($ambilKendaraan);
    		// $query = $this->db->get_where('ga.ga_fleet_kendaraan', array('kendaraan_id' => $id));
    	}

    	return $query->result_array();
    }

    public function getFleetKendaraanCabang($lokasi)
    {
        $query = $this->db->query("select      kdrn.kendaraan_id as kode_kendaraan,
                                                kdrn.nomor_polisi as nomor_polisi,kdrn.nomor_rangka as nomor_rangka,
                                                kdrn.tag_number as tag_number,
                                                jeniskdrn.jenis_kendaraan_id as kode_jenis_kendaraan,
                                                jeniskdrn.jenis_kendaraan as jenis_kendaraan,
                                                merkkdrn.merk_kendaraan_id as kode_merk_kendaraan,
                                                merkkdrn.merk_kendaraan as merk_kendaraan,
                                                merkkdrn.kapasitas_bahanbakar as kapasitas_bahanbakar,
                                                (select location_name from er.er_location where location_code = kdrn.kode_lokasi_kerja) lokasi,
                                                warnakdrn.warna_kendaraan_id as kode_warna_kendaraan,
                                                warnakdrn.warna_kendaraan as warna_kendaraan,
                                                kdrn.tahun_pembuatan as tahun_pembuatan,
                                                kdrn.pic_kendaraan,
                                                kdrn.foto_stnk as foto_stnk,
                                                kdrn.foto_bpkb as foto_bpkb,
                                                kdrn.usable,
                                                kdrn.hak_milik,
                                                kdrn.foto_kendaraan as foto_kendaraan,
                                                to_char(kdrn.start_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                to_char(kdrn.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus,
                                                concat_ws('<br/>sampai dengan<br/>', to_char(kdrn.start_date, 'DD-MM-YYYY HH24:MI:SS'), to_char(kdrn.end_date, 'DD-MM-YYYY HH24:MI:SS')) as masa
                                    from        ga.ga_fleet_kendaraan as kdrn
                                                join    ga.ga_fleet_jenis_kendaraan as jeniskdrn
                                                    on  jeniskdrn.jenis_kendaraan_id=kdrn.jenis_kendaraan_id
                                                join    ga.ga_fleet_merk_kendaraan as merkkdrn
                                                    on  merkkdrn.merk_kendaraan_id=kdrn.merk_kendaraan_id
                                                join    ga.ga_fleet_warna_kendaraan as warnakdrn
                                                    on  warnakdrn.warna_kendaraan_id=kdrn.warna_kendaraan_id
                                    where       kdrn.end_date = '9999-12-12 00:00:00' and kdrn.kode_lokasi_kerja='$lokasi'
                                    order by    kdrn.kendaraan_id");
        
        return $query->result_array();
    }

    public function getFleetKendaraanDeleted($id = FALSE)
    {
        if ($id === FALSE) {
            $ambilKendaraan     = " select      kdrn.kendaraan_id as kode_kendaraan,
                                                kdrn.nomor_polisi as nomor_polisi,kdrn.nomor_rangka as nomor_rangka,
                                                kdrn.tag_number as tag_number,
                                                jeniskdrn.jenis_kendaraan_id as kode_jenis_kendaraan,
                                                jeniskdrn.jenis_kendaraan as jenis_kendaraan,
                                                merkkdrn.merk_kendaraan_id as kode_merk_kendaraan,
                                                merkkdrn.merk_kendaraan as merk_kendaraan,
                                                merkkdrn.kapasitas_bahanbakar as kapasitas_bahanbakar,
                                                (select location_name from er.er_location where location_code = kdrn.kode_lokasi_kerja) lokasi,
                                                warnakdrn.warna_kendaraan_id as kode_warna_kendaraan,
                                                warnakdrn.warna_kendaraan as warna_kendaraan,
                                                kdrn.tahun_pembuatan as tahun_pembuatan,
                                                kdrn.pic_kendaraan,
                                                kdrn.foto_stnk as foto_stnk,
                                                kdrn.foto_bpkb as foto_bpkb,
                                                kdrn.foto_kendaraan as foto_kendaraan,
                                                to_char(kdrn.start_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                to_char(kdrn.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                                -- concat_ws('<br/>sampai dengan<br/>', to_char(kdrn.start_date, 'DD-MM-YYYY HH24:MI:SS'), to_char(kdrn.end_date, 'DD-MM-YYYY HH24:MI:SS')) as masa
                                    from        ga.ga_fleet_kendaraan as kdrn
                                                join    ga.ga_fleet_jenis_kendaraan as jeniskdrn
                                                    on  jeniskdrn.jenis_kendaraan_id=kdrn.jenis_kendaraan_id
                                                join    ga.ga_fleet_merk_kendaraan as merkkdrn
                                                    on  merkkdrn.merk_kendaraan_id=kdrn.merk_kendaraan_id
                                                join    ga.ga_fleet_warna_kendaraan as warnakdrn
                                                    on  warnakdrn.warna_kendaraan_id=kdrn.warna_kendaraan_id
                                             
                                    where       kdrn.end_date = '9999-12-12 00:00:00'
                                    order by    kdrn.kendaraan_id;";

            $query = $this->db->query($ambilKendaraan);
        } /*else {
            $ambilKendaraan     ="  select      kdrn.kendaraan_id as kode_kendaraan,
                                                kdrn.nomor_polisi as nomor_polisi,
                                                jeniskdrn.jenis_kendaraan_id as kode_jenis_kendaraan,
                                                jeniskdrn.jenis_kendaraan as jenis_kendaraan,
                                                merkkdrn.merk_kendaraan_id as kode_merk_kendaraan,
                                                merkkdrn.merk_kendaraan as merk_kendaraan,
                                                warnakdrn.warna_kendaraan_id as kode_warna_kendaraan,
                                                warnakdrn.warna_kendaraan as warna_kendaraan,
                                                kdrn.tahun_pembuatan as tahun_pembuatan,
                                                kdrn.foto_stnk as foto_stnk,
                                                kdrn.foto_bpkb as foto_bpkb,
                                                kdrn.foto_kendaraan as foto_kendaraan
                                                to_char(kdrn.start_date, 'DD-MM-YYYY HH24:MI:SS') as tanggal_dibuat,
                                                to_char(kdrn.end_date, 'DD-MM-YYYY HH24:MI:SS') as tanggal_nonaktif
                                                -- concat_ws('<br/>sampai dengan<br/>', to_char(kdrn.start_date, 'DD-MM-YYYY HH24:MI:SS'), to_char(kdrn.end_date, 'DD-MM-YYYY HH24:MI:SS')) as masa
                                    from        ga.ga_fleet_kendaraan as kdrn
                                                join    ga.ga_fleet_jenis_kendaraan as jeniskdrn
                                                    on  jeniskdrn.jenis_kendaraan_id=kdrn.jenis_kendaraan_id
                                                join    ga.ga_fleet_merk_kendaraan as merkkdrn
                                                    on  merkkdrn.merk_kendaraan_id=kdrn.merk_kendaraan_id
                                                join    ga.ga_fleet_warna_kendaraan as warnakdrn
                                                    on  warnakdrn.warna_kendaraan_id=kdrn.warna_kendaraan_id
                                    where       kdrn.kendaraan_id=$id
                                    order by    kdrn.kendaraan_id;";
            $query              =   $this->db->query($ambilKendaraan);
            // $query = $this->db->get_where('ga.ga_fleet_kendaraan', array('kendaraan_id' => $id));
        }
        */

        return $query->result_array();
    }    

    public function setFleetKendaraan($data)
    {
        return $this->db->insert('ga.ga_fleet_kendaraan', $data);
    }

    public function updateFleetKendaraan($data, $id)
    {
        $this->db->where('kendaraan_id', $id);
        $this->db->update('ga.ga_fleet_kendaraan', $data);
    }

    public function deleteFleetKendaraan($id)
    {
        // $this->db->where('kendaraan_id', $id);
        // $this->db->delete('ga.ga_fleet_kendaraan');

        $tanggal_eksekusi       = date('Y-m-d H:i:s');

        $hapusKendaraan         = "     update  ga.ga_fleet_kendaraan
                                        set     end_date='$tanggal_eksekusi'
                                        where   kendaraan_id=".$id.";";
        $query                  =   $this->db->query($hapusKendaraan);
    }

	public function getFleetJenisKendaraan()
	{
        $ambilJenisKendaraan    = "     select  jenkdrn.jenis_kendaraan_id as kode_jenis_kendaraan,
                                                jenkdrn.jenis_kendaraan as jenis_kendaraan
                                        from    ga.ga_fleet_jenis_kendaraan as jenkdrn
                                        where   jenkdrn.end_date='9999-12-12 00:00:00';";
		$query                  = $this->db->query($ambilJenisKendaraan);
		return $query->result_array();
	}


	public function getFleetMerkKendaraan()
	{
        $ambilMerkKendaraan     = "     select  merkkdrn.merk_kendaraan_id as kode_merk_kendaraan,
                                                merkkdrn.merk_kendaraan as merk_kendaraan
                                        from    ga.ga_fleet_merk_kendaraan as merkkdrn
                                        where   merkkdrn.end_date='9999-12-12 00:00:00';";
		$query                  = $this->db->query($ambilMerkKendaraan);

		return $query->result_array();
	}


	public function getFleetWarnaKendaraan()
	{
        $ambilWarnaKendaraan    = "     select  warnakdrn.warna_kendaraan_id as kode_warna_kendaraan,
                                                warnakdrn.warna_kendaraan as warna_kendaraan
                                        from    ga.ga_fleet_warna_kendaraan as warnakdrn
                                        where   warnakdrn.end_date='9999-12-12 00:00:00';";
		$query                  = $this->db->query($ambilWarnaKendaraan);

		return $query->result_array();
	}

}

/* End of file M_fleetkendaraan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetkendaraan.php */
/* Generated automatically on 2017-08-05 13:23:25 */