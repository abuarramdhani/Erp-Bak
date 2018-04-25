<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetmonitoringlast extends CI_Model
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
        $monitor    = " select      'Pajak' as kategori,
                                    pjk.pajak_id as kode_detail,
                                    to_char(pjk.tanggal_pajak, 'DD-MM-YYYY') as tanggal,
                                    pjk.tanggal_pajak as tanggal_asli,
                                    pjk.biaya as biaya,
                                    pjk.creation_date as waktu_dibuat
                        from        ga.ga_fleet_pajak as pjk
                        where       pjk.kendaraan_id=$nomorPolisi
                                    and     pjk.end_date='9999-12-12 00:00:00'
                                    and     pjk.tanggal_pajak=(
                                            select  max(pjk.tanggal_pajak)
                                            from    ga.ga_fleet_pajak as pjk
                                            where   pjk.kendaraan_id=$nomorPolisi
                                                    and pjk.end_date='9999-12-12 00:00:00'
                                            )
                        union
                        select      'KIR' as kategori,
                                    kir.kir_id as kode_detail,
                                    to_char(kir.tanggal_kir, 'DD-MM-YYYY') as tanggal,
                                    kir.tanggal_kir as tanggal_asli,
                                    kir.biaya as biaya,
                                    kir.creation_date as waktu_dibuat
                        from        ga.ga_fleet_kir as kir
                        where       kir.kendaraan_id=$nomorPolisi
                                    and     kir.end_date='9999-12-12 00:00:00'
                                    and     kir.tanggal_kir=(
                                            select  max(kir.tanggal_kir)
                                            from    ga.ga_fleet_kir as kir
                                            where   kir.end_date='9999-12-12 00:00:00'
                                                    and kir.kendaraan_id=$nomorPolisi
                                            )
                        union
                        select      'Maintenance' as kategori,
                                    mtckdrn.maintenance_kendaraan_id as kode_detail,
                                    to_char(mtckdrn.tanggal_maintenance, 'DD-MM-YYYY') as tanggal,
                                    mtckdrn.tanggal_maintenance as tanggal_asli,
                                    (
                                        select  (
                                                    sum(mtckdrndtl.biaya)
                                                )
                                        from    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl
                                        where   mtckdrndtl.maintenance_kendaraan_id=mtckdrn.maintenance_kendaraan_id
                                                and     mtckdrndtl.end_date='9999-12-12 00:00:00'
                                    ) as biaya,
                                    mtckdrn.creation_date as waktu_dibuat
                        from        ga.ga_fleet_maintenance_kendaraan as mtckdrn
                        where       mtckdrn.end_date='9999-12-12 00:00:00'
                                    and     mtckdrn.kendaraan_id=$nomorPolisi
                                    and     mtckdrn.tanggal_maintenance=(
                                            select  max(mtckdrn.tanggal_maintenance)
                                            from    ga.ga_fleet_maintenance_kendaraan as mtckdrn
                                            where   mtckdrn.end_date='9999-12-12 00:00:00'
                                                    and     mtckdrn.kendaraan_id=$nomorPolisi
                                            )
                        union
                        select      'Kecelakaan' as kategori,
                                    kecelakaan.kecelakaan_id as kode_detail,
                                    to_char(kecelakaan.tanggal_kecelakaan, 'DD-MM-YYYY') as tanggal,
                                    kecelakaan.tanggal_kecelakaan as tanggal_asli,
                                    (
                                        (kecelakaan.biaya_pekerja)
                                        +
                                        (kecelakaan.biaya_perusahaan)
                                    ) as biaya,
                                    kecelakaan.creation_date as waktu_dibuat
                        from        ga.ga_fleet_kecelakaan as kecelakaan
                        where       kecelakaan.end_date='9999-12-12 00:00:00'
                                    and     kecelakaan.kendaraan_id=$nomorPolisi
                                    and     kecelakaan.tanggal_kecelakaan=(
                                            select  max(kecelakaan.tanggal_kecelakaan)
                                            from    ga.ga_fleet_kecelakaan as kecelakaan
                                            where   kecelakaan.end_date='9999-12-12 00:00:00'
                                                    and     kecelakaan.kendaraan_id=$nomorPolisi
                                            )
                        order by    tanggal_asli desc;";

        $query =    $this->db->query($monitor);
        return $query->result_array();
    }

    public function monitoringNomorPolisiCabang($nomorPolisi,$lokasi)
    {
        $query = $this->db->query("select      'Pajak' as kategori,
                                    pjk.pajak_id as kode_detail,
                                    to_char(pjk.tanggal_pajak, 'DD-MM-YYYY') as tanggal,
                                    pjk.tanggal_pajak as tanggal_asli,
                                    pjk.biaya as biaya,
                                    pjk.creation_date as waktu_dibuat
                        from        ga.ga_fleet_pajak as pjk
                        where       pjk.kendaraan_id=$nomorPolisi
                                    and     pjk.kode_lokasi_kerja=$lokasi
                                    and     pjk.end_date='9999-12-12 00:00:00'
                                    and     pjk.tanggal_pajak=(
                                            select  max(pjk.tanggal_pajak)
                                            from    ga.ga_fleet_pajak as pjk
                                            where   pjk.kendaraan_id=$nomorPolisi
                                                    and pjk.end_date='9999-12-12 00:00:00'
                                            )
                        union
                        select      'KIR' as kategori,
                                    kir.kir_id as kode_detail,
                                    to_char(kir.tanggal_kir, 'DD-MM-YYYY') as tanggal,
                                    kir.tanggal_kir as tanggal_asli,
                                    kir.biaya as biaya,
                                    kir.creation_date as waktu_dibuat
                        from        ga.ga_fleet_kir as kir
                        where       kir.kendaraan_id=$nomorPolisi
                                    and     kir.kode_lokasi_kerja=$lokasi
                                    and     kir.end_date='9999-12-12 00:00:00'
                                    and     kir.tanggal_kir=(
                                            select  max(kir.tanggal_kir)
                                            from    ga.ga_fleet_kir as kir
                                            where   kir.end_date='9999-12-12 00:00:00'
                                                    and kir.kendaraan_id=$nomorPolisi
                                            )
                        union
                        select      'Maintenance' as kategori,
                                    mtckdrn.maintenance_kendaraan_id as kode_detail,
                                    to_char(mtckdrn.tanggal_maintenance, 'DD-MM-YYYY') as tanggal,
                                    mtckdrn.tanggal_maintenance as tanggal_asli,
                                    (
                                        select  (
                                                    sum(mtckdrndtl.biaya)
                                                )
                                        from    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl
                                        where   mtckdrndtl.maintenance_kendaraan_id=mtckdrn.maintenance_kendaraan_id
                                                and     mtckdrndtl.end_date='9999-12-12 00:00:00'
                                    ) as biaya,
                                    mtckdrn.creation_date as waktu_dibuat
                        from        ga.ga_fleet_maintenance_kendaraan as mtckdrn
                        where       mtckdrn.end_date='9999-12-12 00:00:00'
                                    and     mtckdrn.kode_lokasi_kerja=$lokasi
                                    and     mtckdrn.kendaraan_id=$nomorPolisi
                                    and     mtckdrn.tanggal_maintenance=(
                                            select  max(mtckdrn.tanggal_maintenance)
                                            from    ga.ga_fleet_maintenance_kendaraan as mtckdrn
                                            where   mtckdrn.end_date='9999-12-12 00:00:00'
                                                    and     mtckdrn.kendaraan_id=$nomorPolisi
                                            )
                        union
                        select      'Kecelakaan' as kategori,
                                    kecelakaan.kecelakaan_id as kode_detail,
                                    to_char(kecelakaan.tanggal_kecelakaan, 'DD-MM-YYYY') as tanggal,
                                    kecelakaan.tanggal_kecelakaan as tanggal_asli,
                                    (
                                        (kecelakaan.biaya_pekerja)
                                        +
                                        (kecelakaan.biaya_perusahaan)
                                    ) as biaya,
                                    kecelakaan.creation_date as waktu_dibuat
                        from        ga.ga_fleet_kecelakaan as kecelakaan
                        where       kecelakaan.end_date='9999-12-12 00:00:00'
                                    and     kecelakaan.kode_lokasi_kerja=$lokasi
                                    and     kecelakaan.kendaraan_id=$nomorPolisi
                                    and     kecelakaan.tanggal_kecelakaan=(
                                            select  max(kecelakaan.tanggal_kecelakaan)
                                            from    ga.ga_fleet_kecelakaan as kecelakaan
                                            where   kecelakaan.end_date='9999-12-12 00:00:00'
                                                    and     kecelakaan.kendaraan_id=$nomorPolisi
                                            )
                        order by    tanggal_asli desc");
        return $query->result_array();
    }

    public function monitoringKategoriPajak()
    {
        $monitoringPajak    = " select      pjk.kendaraan_id as kode_kendaraan,
                                            (
                                                select  kdrn.nomor_polisi
                                                from    ga.ga_fleet_kendaraan as kdrn
                                                where   kdrn.end_date='9999-12-12 00:00:00'
                                                        and     kdrn.kendaraan_id=pjk.kendaraan_id
                                            ) as nomor_polisi,
                                            (
                                                select  pja.pajak_id
                                                from    ga.ga_fleet_pajak as pja
                                                where   pja.kendaraan_id=pjk.kendaraan_id
                                                        and     pja.end_date='9999-12-12 00:00:00'
                                                        and     pja.tanggal_pajak=(
                                                                select  max(pjb.tanggal_pajak)
                                                                from    ga.ga_fleet_pajak as pjb
                                                                where   pjb.kendaraan_id=pjk.kendaraan_id
                                                                        and     pjb.end_date='9999-12-12 00:00:00'
                                                                )
                                            ) as kode_detail,
                                            to_char(max(pjk.tanggal_pajak), 'DD-MM-YYYY') as tanggal,
                                            max(pjk.tanggal_pajak) as tanggal_asli,
                                            (
                                                select  pjc.biaya
                                                from    ga.ga_fleet_pajak as pjc
                                                where   pjc.end_date='9999-12-12 00:00:00'
                                                        and     pjc.pajak_id=(
                                                        		select  pja.pajak_id
                                                				from    ga.ga_fleet_pajak as pja
                                               	 				where   pja.kendaraan_id=pjk.kendaraan_id
                                                        				and     pja.end_date='9999-12-12 00:00:00'
                                                        				and     pja.tanggal_pajak=(
                                                                				select  max(pjb.tanggal_pajak)
                                                                				from    ga.ga_fleet_pajak as pjb
                                                                				where   pjb.kendaraan_id=pjk.kendaraan_id
                                                                        				and     pjb.end_date='9999-12-12 00:00:00'
                                                                				)
                                                        		)
                                            ) as biaya                                            
                                from        ga.ga_fleet_pajak as pjk
                                where       pjk.end_date='9999-12-12 00:00:00'
                                group by    kode_kendaraan
                                order by    tanggal_asli desc, kode_kendaraan asc;";
        $query              =   $this->db->query($monitoringPajak);
        return $query->result_array();
    }

    public function monitoringKategoriPajakCabang($lokasi)
    {
        $query = $this->db->query("select      pjk.kendaraan_id as kode_kendaraan,
                                            (
                                                select  kdrn.nomor_polisi
                                                from    ga.ga_fleet_kendaraan as kdrn
                                                where   kdrn.end_date='9999-12-12 00:00:00'
                                                        and     kdrn.kendaraan_id=pjk.kendaraan_id
                                            ) as nomor_polisi,
                                            (
                                                select  pja.pajak_id
                                                from    ga.ga_fleet_pajak as pja
                                                where   pja.kendaraan_id=pjk.kendaraan_id
                                                        and     pja.end_date='9999-12-12 00:00:00'
                                                        and     pja.tanggal_pajak=(
                                                                select  max(pjb.tanggal_pajak)
                                                                from    ga.ga_fleet_pajak as pjb
                                                                where   pjb.kendaraan_id=pjk.kendaraan_id
                                                                        and     pjb.end_date='9999-12-12 00:00:00'
                                                                )
                                            ) as kode_detail,
                                            to_char(max(pjk.tanggal_pajak), 'DD-MM-YYYY') as tanggal,
                                            max(pjk.tanggal_pajak) as tanggal_asli,
                                            (
                                                select  pjc.biaya
                                                from    ga.ga_fleet_pajak as pjc
                                                where   pjc.end_date='9999-12-12 00:00:00'
                                                        and     pjc.pajak_id=(
                                                                select  pja.pajak_id
                                                                from    ga.ga_fleet_pajak as pja
                                                                where   pja.kendaraan_id=pjk.kendaraan_id
                                                                        and     pja.end_date='9999-12-12 00:00:00'
                                                                        and     pja.tanggal_pajak=(
                                                                                select  max(pjb.tanggal_pajak)
                                                                                from    ga.ga_fleet_pajak as pjb
                                                                                where   pjb.kendaraan_id=pjk.kendaraan_id
                                                                                        and     pjb.end_date='9999-12-12 00:00:00'
                                                                                )
                                                                )
                                            ) as biaya                                            
                                from        ga.ga_fleet_pajak as pjk
                                where       pjk.end_date='9999-12-12 00:00:00'
                                        and pjk.kode_lokasi_kerja=$lokasi
                                group by    kode_kendaraan
                                order by    tanggal_asli desc, kode_kendaraan asc");
        return $query->result_array();
    }

    public function monitoringKategoriKIR()
    {
        $monitoringKIR      = " select      kir.kendaraan_id as kode_kendaraan,
                                            (
                                                select  kdrn.nomor_polisi
                                                from    ga.ga_fleet_kendaraan as kdrn
                                                where   kdrn.end_date='9999-12-12 00:00:00'
                                                        and     kdrn.kendaraan_id=kir.kendaraan_id
                                            ) as nomor_polisi,
                                            (
                                                select  kir1.kir_id
                                                from    ga.ga_fleet_kir as kir1
                                                where   kir1.kendaraan_id=kir.kendaraan_id
                                                        and     kir1.end_date='9999-12-12 00:00:00'
                                                        and     kir1.tanggal_kir=(
                                                                select  max(kir2.tanggal_kir)
                                                                from    ga.ga_fleet_kir as kir2
                                                                where   kir2.kendaraan_id=kir.kendaraan_id
                                                                        and     kir2.end_date='9999-12-12 00:00:00'
                                                                )
                                            ) as kode_detail,
                                            to_char(max(kir.tanggal_kir), 'DD-MM-YYYY') as tanggal,
                                            max(kir.tanggal_kir) as tanggal_asli,
                                            (
                                                select  kir3.biaya
                                                from    ga.ga_fleet_kir as kir3
                                                where   kir3.end_date='9999-12-12 00:00:00'
                                                		and 	kir3.kir_id=(
                                                				select  kir1.kir_id
                                                				from    ga.ga_fleet_kir as kir1
                                                				where   kir1.kendaraan_id=kir.kendaraan_id
                                                        				and     kir1.end_date='9999-12-12 00:00:00'
                                                        				and     kir1.tanggal_kir=(
                                                                				select  max(kir2.tanggal_kir)
                                                                				from    ga.ga_fleet_kir as kir2
                                                                				where   kir2.kendaraan_id=kir.kendaraan_id
                                                                        				and     kir2.end_date='9999-12-12 00:00:00'
                                                                				)                                                				
                                                				)
                                            ) as biaya       
                                from        ga.ga_fleet_kir as kir
                                where       kir.end_date='9999-12-12 00:00:00'
                                group by    kode_kendaraan
                                order by    tanggal_asli desc, kode_kendaraan asc;";
        $query              =   $this->db->query($monitoringKIR);
        return $query->result_array();
    }

    public function monitoringKategoriKIRCabang($lokasi)
    {
        $query = $this->db->query("select      kir.kendaraan_id as kode_kendaraan,
                                            (
                                                select  kdrn.nomor_polisi
                                                from    ga.ga_fleet_kendaraan as kdrn
                                                where   kdrn.end_date='9999-12-12 00:00:00'
                                                        and     kdrn.kendaraan_id=kir.kendaraan_id
                                            ) as nomor_polisi,
                                            (
                                                select  kir1.kir_id
                                                from    ga.ga_fleet_kir as kir1
                                                where   kir1.kendaraan_id=kir.kendaraan_id
                                                        and     kir1.end_date='9999-12-12 00:00:00'
                                                        and     kir1.tanggal_kir=(
                                                                select  max(kir2.tanggal_kir)
                                                                from    ga.ga_fleet_kir as kir2
                                                                where   kir2.kendaraan_id=kir.kendaraan_id
                                                                        and     kir2.end_date='9999-12-12 00:00:00'
                                                                )
                                            ) as kode_detail,
                                            to_char(max(kir.tanggal_kir), 'DD-MM-YYYY') as tanggal,
                                            max(kir.tanggal_kir) as tanggal_asli,
                                            (
                                                select  kir3.biaya
                                                from    ga.ga_fleet_kir as kir3
                                                where   kir3.end_date='9999-12-12 00:00:00'
                                                        and     kir3.kir_id=(
                                                                select  kir1.kir_id
                                                                from    ga.ga_fleet_kir as kir1
                                                                where   kir1.kendaraan_id=kir.kendaraan_id
                                                                        and     kir1.end_date='9999-12-12 00:00:00'
                                                                        and     kir1.tanggal_kir=(
                                                                                select  max(kir2.tanggal_kir)
                                                                                from    ga.ga_fleet_kir as kir2
                                                                                where   kir2.kendaraan_id=kir.kendaraan_id
                                                                                        and     kir2.end_date='9999-12-12 00:00:00'
                                                                                )                                                               
                                                                )
                                            ) as biaya       
                                from        ga.ga_fleet_kir as kir
                                where       kir.end_date='9999-12-12 00:00:00'
                                        and kir.kode_lokasi_kerja=$lokasi
                                group by    kode_kendaraan
                                order by    tanggal_asli desc, kode_kendaraan asc");
        return $query->result_array();
    }

    public function monitoringKategoriMaintenanceKendaraan()
    {
        $monitoringMaintenanceKendaraan      = "    select      mtckdrn.kendaraan_id as kode_kendaraan,
                                                                (
                                                                    select  kdrn.nomor_polisi
                                                                    from    ga.ga_fleet_kendaraan as kdrn
                                                                    where   kdrn.end_date='9999-12-12 00:00:00'
                                                                            and     kdrn.kendaraan_id=mtckdrn.kendaraan_id
                                                                ) as nomor_polisi,
                                                                (
                                                                    select  mtckdrn1.maintenance_kendaraan_id
                                                                    from    ga.ga_fleet_maintenance_kendaraan as mtckdrn1
                                                                    where   mtckdrn1.kendaraan_id=mtckdrn.kendaraan_id
                                                                            and     mtckdrn1.end_date='9999-12-12 00:00:00'
                                                                            and     mtckdrn1.tanggal_maintenance=(
                                                                                    select  max(mtckdrn2.tanggal_maintenance)
                                                                                    from    ga.ga_fleet_maintenance_kendaraan as mtckdrn2
                                                                                    where   mtckdrn2.kendaraan_id=mtckdrn.kendaraan_id
                                                                                            and     mtckdrn2.end_date='9999-12-12 00:00:00'
                                                                                    )
                                                                ) as kode_detail,           
                                                                to_char(max(mtckdrn.tanggal_maintenance), 'DD-MM-YYYY') as tanggal,
                                                                max(mtckdrn.tanggal_maintenance) as tanggal_asli,
                                                                (
                                                                    select  sum(mtckdrndtl.biaya)
                                                                    from    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl
                                                                    where   mtckdrndtl.end_date='9999-12-12 00:00:00'
                                                                            and     mtckdrndtl.maintenance_kendaraan_id=(
                                                                                    select  mtckdrn1.maintenance_kendaraan_id
                                                                                    from    ga.ga_fleet_maintenance_kendaraan as mtckdrn1
                                                                                    where   mtckdrn1.kendaraan_id=mtckdrn.kendaraan_id
                                                                                            and     mtckdrn1.end_date='9999-12-12 00:00:00'
                                                                                            and     mtckdrn1.tanggal_maintenance=(
                                                                                                    select  max(mtckdrn2.tanggal_maintenance)
                                                                                                    from    ga.ga_fleet_maintenance_kendaraan as mtckdrn2
                                                                                                    where   mtckdrn2.kendaraan_id=mtckdrn.kendaraan_id
                                                                                                            and     mtckdrn2.end_date='9999-12-12 00:00:00'
                                                                                                    )                       
                                                                                    )
                                                                ) as biaya              
                                                    from        ga.ga_fleet_maintenance_kendaraan as mtckdrn
                                                    where       mtckdrn.end_date='9999-12-12 00:00:00'
                                                    group by    kode_kendaraan
                                                    order by    tanggal_asli desc, kode_kendaraan asc;";
        $query              =   $this->db->query($monitoringMaintenanceKendaraan);
        return $query->result_array();
    }

    public function monitoringKategoriMaintenanceKendaraanCabang($lokasi)
    {
        $query = $this->db->query("select      mtckdrn.kendaraan_id as kode_kendaraan,
                                                                (
                                                                    select  kdrn.nomor_polisi
                                                                    from    ga.ga_fleet_kendaraan as kdrn
                                                                    where   kdrn.end_date='9999-12-12 00:00:00'
                                                                            and     kdrn.kendaraan_id=mtckdrn.kendaraan_id
                                                                ) as nomor_polisi,
                                                                (
                                                                    select  mtckdrn1.maintenance_kendaraan_id
                                                                    from    ga.ga_fleet_maintenance_kendaraan as mtckdrn1
                                                                    where   mtckdrn1.kendaraan_id=mtckdrn.kendaraan_id
                                                                            and     mtckdrn1.end_date='9999-12-12 00:00:00'
                                                                            and     mtckdrn1.tanggal_maintenance=(
                                                                                    select  max(mtckdrn2.tanggal_maintenance)
                                                                                    from    ga.ga_fleet_maintenance_kendaraan as mtckdrn2
                                                                                    where   mtckdrn2.kendaraan_id=mtckdrn.kendaraan_id
                                                                                            and     mtckdrn2.end_date='9999-12-12 00:00:00'
                                                                                    )
                                                                ) as kode_detail,           
                                                                to_char(max(mtckdrn.tanggal_maintenance), 'DD-MM-YYYY') as tanggal,
                                                                max(mtckdrn.tanggal_maintenance) as tanggal_asli,
                                                                (
                                                                    select  sum(mtckdrndtl.biaya)
                                                                    from    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl
                                                                    where   mtckdrndtl.end_date='9999-12-12 00:00:00'
                                                                            and     mtckdrndtl.maintenance_kendaraan_id=(
                                                                                    select  mtckdrn1.maintenance_kendaraan_id
                                                                                    from    ga.ga_fleet_maintenance_kendaraan as mtckdrn1
                                                                                    where   mtckdrn1.kendaraan_id=mtckdrn.kendaraan_id
                                                                                            and     mtckdrn1.end_date='9999-12-12 00:00:00'
                                                                                            and     mtckdrn1.tanggal_maintenance=(
                                                                                                    select  max(mtckdrn2.tanggal_maintenance)
                                                                                                    from    ga.ga_fleet_maintenance_kendaraan as mtckdrn2
                                                                                                    where   mtckdrn2.kendaraan_id=mtckdrn.kendaraan_id
                                                                                                            and     mtckdrn2.end_date='9999-12-12 00:00:00'
                                                                                                    )                       
                                                                                    )
                                                                ) as biaya              
                                                    from        ga.ga_fleet_maintenance_kendaraan as mtckdrn
                                                    where       mtckdrn.end_date='9999-12-12 00:00:00'
                                                            and mtckdrn.kode_lokasi_kerja=$lokasi
                                                    group by    kode_kendaraan
                                                    order by    tanggal_asli desc, kode_kendaraan asc");
        return $query->result_array();
    }

    public function monitoringKategoriKecelakaan()
    {
        $monitoringKecelakaan      = "  select      kecelakaan.kendaraan_id as kode_kendaraan,
                                                    (
                                                        select  kdrn.nomor_polisi
                                                        from    ga.ga_fleet_kendaraan as kdrn
                                                        where   kdrn.end_date='9999-12-12 00:00:00'
                                                                and     kdrn.kendaraan_id=kecelakaan.kendaraan_id
                                                    ) as nomor_polisi,
                                                    (
                                                        select  kecelakaan1.kecelakaan_id
                                                        from    ga.ga_fleet_kecelakaan as kecelakaan1
                                                        where   kecelakaan1.kendaraan_id=kecelakaan.kendaraan_id
                                                                and     kecelakaan1.end_date='9999-12-12 00:00:00'
                                                                and     kecelakaan1.tanggal_kecelakaan=(
                                                                        select  max(kecelakaan2.tanggal_kecelakaan)
                                                                        from    ga.ga_fleet_kecelakaan as kecelakaan2
                                                                        where   kecelakaan2.kendaraan_id=kecelakaan.kendaraan_id
                                                                                and     kecelakaan2.end_date='9999-12-12 00:00:00'
                                                                        )
                                                    ) as kode_detail,           
                                                    to_char(max(kecelakaan.tanggal_kecelakaan), 'DD-MM-YYYY') as tanggal,
                                                    max(kecelakaan.tanggal_kecelakaan) as tanggal_asli,
                                                    (
                                                        select  (
                                                                    kecelakaan3.biaya_pekerja
                                                                    +
                                                                    kecelakaan3.biaya_perusahaan
                                                                )
                                                        from    ga.ga_fleet_kecelakaan as kecelakaan3
                                                        where   kecelakaan3.end_date='9999-12-12 00:00:00'
                                                                and     kecelakaan3.kecelakaan_id=(
                                                                		select  kecelakaan1.kecelakaan_id
                                                        				from    ga.ga_fleet_kecelakaan as kecelakaan1
                                                        				where   kecelakaan1.kendaraan_id=kecelakaan.kendaraan_id
                                                                				and     kecelakaan1.end_date='9999-12-12 00:00:00'
                                                                				and     kecelakaan1.tanggal_kecelakaan=(
                                                                        		select  max(kecelakaan2.tanggal_kecelakaan)
                                                                        		from    ga.ga_fleet_kecelakaan as kecelakaan2
                                                                        		where   kecelakaan2.kendaraan_id=kecelakaan.kendaraan_id
                                                                                		and     kecelakaan2.end_date='9999-12-12 00:00:00'
                                                                				)
                                                                		)
                                                    ) as biaya              
                                        from        ga.ga_fleet_kecelakaan as kecelakaan
                                        where       kecelakaan.end_date='9999-12-12 00:00:00'
                                        group by    kode_kendaraan
                                        order by    tanggal_asli desc, kode_kendaraan asc;";
        $query              =   $this->db->query($monitoringKecelakaan);
        return $query->result_array();
    }

    public function monitoringKategoriKecelakaanCabang($lokasi)
    {
        $query = $this->db->query("select      kecelakaan.kendaraan_id as kode_kendaraan,
                                                    (
                                                        select  kdrn.nomor_polisi
                                                        from    ga.ga_fleet_kendaraan as kdrn
                                                        where   kdrn.end_date='9999-12-12 00:00:00'
                                                                and     kdrn.kendaraan_id=kecelakaan.kendaraan_id
                                                    ) as nomor_polisi,
                                                    (
                                                        select  kecelakaan1.kecelakaan_id
                                                        from    ga.ga_fleet_kecelakaan as kecelakaan1
                                                        where   kecelakaan1.kendaraan_id=kecelakaan.kendaraan_id
                                                                and     kecelakaan1.end_date='9999-12-12 00:00:00'
                                                                and     kecelakaan1.tanggal_kecelakaan=(
                                                                        select  max(kecelakaan2.tanggal_kecelakaan)
                                                                        from    ga.ga_fleet_kecelakaan as kecelakaan2
                                                                        where   kecelakaan2.kendaraan_id=kecelakaan.kendaraan_id
                                                                                and     kecelakaan2.end_date='9999-12-12 00:00:00'
                                                                        )
                                                    ) as kode_detail,           
                                                    to_char(max(kecelakaan.tanggal_kecelakaan), 'DD-MM-YYYY') as tanggal,
                                                    max(kecelakaan.tanggal_kecelakaan) as tanggal_asli,
                                                    (
                                                        select  (
                                                                    kecelakaan3.biaya_pekerja
                                                                    +
                                                                    kecelakaan3.biaya_perusahaan
                                                                )
                                                        from    ga.ga_fleet_kecelakaan as kecelakaan3
                                                        where   kecelakaan3.end_date='9999-12-12 00:00:00'
                                                                and     kecelakaan3.kecelakaan_id=(
                                                                        select  kecelakaan1.kecelakaan_id
                                                                        from    ga.ga_fleet_kecelakaan as kecelakaan1
                                                                        where   kecelakaan1.kendaraan_id=kecelakaan.kendaraan_id
                                                                                and     kecelakaan1.end_date='9999-12-12 00:00:00'
                                                                                and     kecelakaan1.tanggal_kecelakaan=(
                                                                                select  max(kecelakaan2.tanggal_kecelakaan)
                                                                                from    ga.ga_fleet_kecelakaan as kecelakaan2
                                                                                where   kecelakaan2.kendaraan_id=kecelakaan.kendaraan_id
                                                                                        and     kecelakaan2.end_date='9999-12-12 00:00:00'
                                                                                )
                                                                        )
                                                    ) as biaya              
                                        from        ga.ga_fleet_kecelakaan as kecelakaan
                                        where       kecelakaan.end_date='9999-12-12 00:00:00'
                                                and kecelakaan.kode_lokasi_kerja=$lokasi
                                        group by    kode_kendaraan
                                        order by    tanggal_asli desc, kode_kendaraan asc");
        return $query->result_array();
    }

}