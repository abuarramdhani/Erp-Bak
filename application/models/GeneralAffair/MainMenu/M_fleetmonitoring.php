<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetmonitoring extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('Asia/Jakarta');
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

    public function monitoringNomorPolisi($nomorPolisi)
    {
        $monitor    = " -- Ambil Monitoring Pajak
                        select  'Pajak' as kategori,
                                to_char(pjk.tanggal_pajak, 'DD-MM-YYYY') as tanggal,
                                pjk.tanggal_pajak as tanggal_asli,
                                pjk.biaya as biaya,
                                pjk.pajak_id as kode_detail
                        from    ga.ga_fleet_pajak as pjk
                        where   pjk.end_date='9999-12-12 00:00:00'
                                and pjk.kendaraan_id='$nomorPolisi'
                        union
                        -- Ambil Monitoring KIR
                        select  'KIR' as kategori,
                                to_char(kir.tanggal_kir, 'DD-MM-YYYY') as tanggal,
                                kir.tanggal_kir as tanggal_asli,
                                kir.biaya as biaya,
                                kir.kir_id as kode_detail
                        from    ga.ga_fleet_kir as kir
                        where   kir.end_date='9999-12-12 00:00:00'
                                and kir.kendaraan_id='$nomorPolisi'
                        union
                        -- Ambil Monitoring Maintenance Kendaraan
                        select  'Maintenance Kendaraan' as kategori,
                                to_char(mtckdrn.tanggal_maintenance, 'DD-MM-YYYY') as tanggal,
                                mtckdrn.tanggal_maintenance as tanggal_asli,
                                (
                                    select  sum(mtckdrndtl.biaya) 
                                    from    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl 
                                    where   mtckdrndtl.maintenance_kendaraan_id=mtckdrn.maintenance_kendaraan_id
                                ) as biaya,
                                mtckdrn.maintenance_kendaraan_id as kode_detail
                        from    ga.ga_fleet_maintenance_kendaraan as mtckdrn
                        where   mtckdrn.end_date='9999-12-12 00:00:00'
                                and mtckdrn.kendaraan_id='$nomorPolisi'
                        union
                        -- Ambil Monitoring Kecelakaan
                        select  'Kecelakaan' as kategori,
                                to_char(kecelakaan.tanggal_kecelakaan, 'DD-MM-YYYY') as tanggal,
                                kecelakaan.tanggal_kecelakaan as tanggal_asli,
                                ((kecelakaan.biaya_perusahaan)+(kecelakaan.biaya_pekerja)) as biaya,
                                kecelakaan.kecelakaan_id as kode_detail
                        from    ga.ga_fleet_kecelakaan as kecelakaan
                        where   kecelakaan.end_date='9999-12-12 00:00:00'
                                and kecelakaan.kendaraan_id='$nomorPolisi'
                        order by tanggal_asli desc;";

        $query =    $this->db->query($monitor);
        return $query->result_array();
    }

    public function monitoringNomorPolisiCabang($lokasi,$nomorPolisi)
    {
        $query = $this->db->query("-- Ambil Monitoring Pajak
                        select  'Pajak' as kategori,
                                to_char(pjk.tanggal_pajak, 'DD-MM-YYYY') as tanggal,
                                pjk.tanggal_pajak as tanggal_asli,
                                pjk.biaya as biaya,
                                pjk.pajak_id as kode_detail
                        from    ga.ga_fleet_pajak as pjk
                        where   pjk.end_date='9999-12-12 00:00:00'
                                and pjk.kendaraan_id='$nomorPolisi'
                                and pjk.kode_lokasi_kerja='$lokasi'
                        union
                        -- Ambil Monitoring KIR
                        select  'KIR' as kategori,
                                to_char(kir.tanggal_kir, 'DD-MM-YYYY') as tanggal,
                                kir.tanggal_kir as tanggal_asli,
                                kir.biaya as biaya,
                                kir.kir_id as kode_detail
                        from    ga.ga_fleet_kir as kir
                        where   kir.end_date='9999-12-12 00:00:00'
                                and kir.kendaraan_id='$nomorPolisi'
                                and kir.kode_lokasi_kerja='$lokasi'
                        union
                        -- Ambil Monitoring Maintenance Kendaraan
                        select  'Maintenance Kendaraan' as kategori,
                                to_char(mtckdrn.tanggal_maintenance, 'DD-MM-YYYY') as tanggal,
                                mtckdrn.tanggal_maintenance as tanggal_asli,
                                (
                                    select  sum(mtckdrndtl.biaya) 
                                    from    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl 
                                    where   mtckdrndtl.maintenance_kendaraan_id=mtckdrn.maintenance_kendaraan_id
                                ) as biaya,
                                mtckdrn.maintenance_kendaraan_id as kode_detail
                        from    ga.ga_fleet_maintenance_kendaraan as mtckdrn
                        where   mtckdrn.end_date='9999-12-12 00:00:00'
                                and mtckdrn.kendaraan_id='$nomorPolisi'
                                and mtckdrn.kode_lokasi_kerja='$lokasi'
                        union
                        -- Ambil Monitoring Kecelakaan
                        select  'Kecelakaan' as kategori,
                                to_char(kecelakaan.tanggal_kecelakaan, 'DD-MM-YYYY') as tanggal,
                                kecelakaan.tanggal_kecelakaan as tanggal_asli,
                                ((kecelakaan.biaya_perusahaan)+(kecelakaan.biaya_pekerja)) as biaya,
                                kecelakaan.kecelakaan_id as kode_detail
                        from    ga.ga_fleet_kecelakaan as kecelakaan
                        where   kecelakaan.end_date='9999-12-12 00:00:00'
                                and kecelakaan.kendaraan_id='$nomorPolisi'
                                and kecelakaan.kode_lokasi_kerja='$lokasi'
                        order by tanggal_asli desc");
        
        return $query->result_array();
    }

    public function monitoringKategoriPajak($periodeawal, $periodeakhir)
    {
        $monitoringPajak    = " select      kdrn.nomor_polisi as nomor_polisi,
                                            to_char(pjk.tanggal_pajak, 'DD-MM-YYYY') as tanggal,
                                            pjk.tanggal_pajak as tanggal_asli,
                                            pjk.biaya as biaya
                                from        ga.ga_fleet_pajak as pjk
                                            join    ga.ga_fleet_kendaraan as kdrn
                                                on  kdrn.kendaraan_id=pjk.kendaraan_id
                                where       pjk.tanggal_pajak between '$periodeawal' and '$periodeakhir'
                                            and     pjk.end_date='9999-12-12 00:00:00'
                                order by    tanggal_asli desc;";
        $query              =   $this->db->query($monitoringPajak);
        return $query->result_array();
    }

    public function monitoringKategoriPajakCabang($lokasi,$periodeawal,$periodeakhir)
    {
        $query = $this->db->query("select      kdrn.nomor_polisi as nomor_polisi,
                                            to_char(pjk.tanggal_pajak, 'DD-MM-YYYY') as tanggal,
                                            pjk.tanggal_pajak as tanggal_asli,
                                            pjk.biaya as biaya
                                from        ga.ga_fleet_pajak as pjk
                                            join    ga.ga_fleet_kendaraan as kdrn
                                                on  kdrn.kendaraan_id=pjk.kendaraan_id
                                where       pjk.tanggal_pajak between '$periodeawal' and '$periodeakhir'
                                            and     pjk.end_date='9999-12-12 00:00:00'
                                            and pjk.kode_lokasi_kerja='$lokasi'
                                order by    tanggal_asli desc");
        return $query->result_array();
    }

    public function monitoringKategoriKIR($periodeawal, $periodeakhir)
    {
        $monitoringKIR      = " select      kdrn.nomor_polisi as nomor_polisi,
                                            to_char(kir.tanggal_kir, 'DD-MM-YYYY') as tanggal,
                                            kir.tanggal_kir as tanggal_asli,
                                            kir.biaya as biaya
                                from        ga.ga_fleet_kir as kir
                                            join    ga.ga_fleet_kendaraan as kdrn
                                                on  kdrn.kendaraan_id=kir.kendaraan_id
                                where       kir.tanggal_kir between '$periodeawal' and '$periodeakhir'
                                            and     kir.end_date='9999-12-12 00:00:00'
                                order by    tanggal_asli;";
        $query              =   $this->db->query($monitoringKIR);
        return $query->result_array();
    }

    public function monitoringKategoriKIRCabang($lokasi,$periodeawal,$periodeakhir)
    {
        $query = $this->db->query("select      kdrn.nomor_polisi as nomor_polisi,
                                            to_char(kir.tanggal_kir, 'DD-MM-YYYY') as tanggal,
                                            kir.tanggal_kir as tanggal_asli,
                                            kir.biaya as biaya
                                from        ga.ga_fleet_kir as kir
                                            join    ga.ga_fleet_kendaraan as kdrn
                                                on  kdrn.kendaraan_id=kir.kendaraan_id
                                where       kir.tanggal_kir between '$periodeawal' and '$periodeakhir'
                                            and     kir.end_date='9999-12-12 00:00:00'
                                            and kir.kode_lokasi_kerja='$lokasi'
                                order by    tanggal_asli");
        return $query->result_array();
    }

    public function monitoringKategoriMaintenanceKendaraan($periodeawal, $periodeakhir)
    {
        $monitoringMaintenanceKendaraan      = " select         mtckdrn.maintenance_kendaraan_id as kode_maintenance,
                                                                kdrn.nomor_polisi as nomor_polisi,
                                                                to_char(mtckdrn.tanggal_maintenance, 'DD-MM-YYYY') as tanggal,
                                                                mtckdrn.tanggal_maintenance as tanggal_asli,
                                                                (
                                                                    select  coalesce(sum(mtckdrndtl.biaya),0)
                                                                    from    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl
                                                                    where   mtckdrndtl.maintenance_kendaraan_id=mtckdrn.maintenance_kendaraan_id
                                                                            and     mtckdrndtl.end_date='9999-12-12 00:00:00'
                                                                ) as biaya
                                                    from        ga.ga_fleet_maintenance_kendaraan as mtckdrn
                                                                join    ga.ga_fleet_kendaraan as kdrn
                                                                    on  kdrn.kendaraan_id=mtckdrn.kendaraan_id
                                                    where       mtckdrn.tanggal_maintenance between '$periodeawal' and '$periodeakhir'
                                                                and     mtckdrn.end_date='9999-12-12 00:00:00'
                                                    order by    tanggal_asli desc;";
        $query              =   $this->db->query($monitoringMaintenanceKendaraan);
        return $query->result_array();
    }

    public function monitoringKategoriMaintenanceKendaraanCabang($lokasi,$periodeawal,$periodeakhir)
    {
        $query = $this->db->query("select         mtckdrn.maintenance_kendaraan_id as kode_maintenance,
                                                                kdrn.nomor_polisi as nomor_polisi,
                                                                to_char(mtckdrn.tanggal_maintenance, 'DD-MM-YYYY') as tanggal,
                                                                mtckdrn.tanggal_maintenance as tanggal_asli,
                                                                (
                                                                    select  coalesce(sum(mtckdrndtl.biaya),0)
                                                                    from    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl
                                                                    where   mtckdrndtl.maintenance_kendaraan_id=mtckdrn.maintenance_kendaraan_id
                                                                            and     mtckdrndtl.end_date='9999-12-12 00:00:00'
                                                                ) as biaya
                                                    from        ga.ga_fleet_maintenance_kendaraan as mtckdrn
                                                                join    ga.ga_fleet_kendaraan as kdrn
                                                                    on  kdrn.kendaraan_id=mtckdrn.kendaraan_id
                                                    where       mtckdrn.tanggal_maintenance between '$periodeawal' and '$periodeakhir'
                                                                and     mtckdrn.end_date='9999-12-12 00:00:00'
                                                                and mtckdrn.kode_lokasi_kerja='$lokasi'
                                                    order by    tanggal_asli desc");
        return $query->result_array();
    }

    public function monitoringKategoriKecelakaan($periodeawal, $periodeakhir)
    {
        $monitoringKecelakaan      = " select       kecelakaan.kecelakaan_id as kode_kecelakaan,
                                                    kdrn.nomor_polisi as nomor_polisi,
                                                    to_char(kecelakaan.tanggal_kecelakaan, 'DD-MM-YYYY') as tanggal,
                                                    kecelakaan.tanggal_kecelakaan as tanggal_asli,
                                                    (
                                                        (kecelakaan.biaya_perusahaan)
                                                        +
                                                        (kecelakaan.biaya_pekerja)
                                                    ) as biaya
                                        from        ga.ga_fleet_kecelakaan as kecelakaan
                                                    join    ga.ga_fleet_kendaraan as kdrn
                                                        on  kdrn.kendaraan_id=kecelakaan.kendaraan_id
                                        where       kecelakaan.tanggal_kecelakaan between '$periodeawal' and '$periodeakhir'
                                                    and     kecelakaan.end_date='9999-12-12 00:00:00'
                                        order by    tanggal_asli desc;";
        $query              =   $this->db->query($monitoringKecelakaan);
        return $query->result_array();
    }

    public function monitoringKategoriKecelakaanCabang($lokasi,$periodeawal,$periodeakhir)
    {
        $query = $this->db->query("select       kecelakaan.kecelakaan_id as kode_kecelakaan,
                                                    kdrn.nomor_polisi as nomor_polisi,
                                                    to_char(kecelakaan.tanggal_kecelakaan, 'DD-MM-YYYY') as tanggal,
                                                    kecelakaan.tanggal_kecelakaan as tanggal_asli,
                                                    (
                                                        (kecelakaan.biaya_perusahaan)
                                                        +
                                                        (kecelakaan.biaya_pekerja)
                                                    ) as biaya
                                        from        ga.ga_fleet_kecelakaan as kecelakaan
                                                    join    ga.ga_fleet_kendaraan as kdrn
                                                        on  kdrn.kendaraan_id=kecelakaan.kendaraan_id
                                        where       kecelakaan.tanggal_kecelakaan between '$periodeawal' and '$periodeakhir'
                                                    and     kecelakaan.end_date='9999-12-12 00:00:00'
                                                    and kecelakaan.kode_lokasi_kerja='$lokasi'
                                        order by    tanggal_asli desc");
        return $query->result_array();
    }

    public function getMonitoringKendaraanDetail($periode1,$periode2)
    {
        $query = $this->db->query("select   mtckdrn.maintenance_kendaraan_id as kode_maintenance,
                                            kdrn.nomor_polisi as nomor_polisi,
                                            to_char(mtckdrn.tanggal_maintenance, 'DD-MM-YYYY') as tanggal,
                                            mtckdrn.tanggal_maintenance as tanggal_asli,
                                            mtckdrndtl.jenis_maintenance as jenis_maintenance,
                                            mtckdrndtl.biaya as biaya
                                from        ga.ga_fleet_maintenance_kendaraan as mtckdrn
                                            join    ga.ga_fleet_kendaraan as kdrn
                                                on  kdrn.kendaraan_id=mtckdrn.kendaraan_id
                                            join    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl
                                                on  mtckdrn.maintenance_kendaraan_id=mtckdrndtl.maintenance_kendaraan_id
                                where       mtckdrn.tanggal_maintenance between '$periode1' and '$periode2'
                                            and     mtckdrn.end_date='9999-12-12 00:00:00'
                                order by    tanggal_asli desc");
        return $query->result_array();
    }

}