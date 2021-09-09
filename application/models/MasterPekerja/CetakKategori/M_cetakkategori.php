<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_cetakkategori extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database("personalia", true);
    }

    public function GetNoinduk()
    {
        $sql = "SELECT * FROM hrd_khs.tnoind ORDER BY tnoind";
        return $this->personalia->query($sql)->result_array();
    }

    public function GetPendidikan()
    {
        $sql = "SELECT DISTINCT tpri.pendidikan FROM hrd_khs.tpribadi tpri
        WHERE tpri.pendidikan != '-' AND tpri.pendidikan != '' ORDER BY tpri.pendidikan";
        return $this->personalia->query($sql)->result_array();
    }

    public function GetJenkel()
    {
        $sql = "SELECT DISTINCT tpri.jenkel FROM hrd_khs.tpribadi tpri
        WHERE tpri.jenkel != '-' AND tpri.jenkel != ''";
        return $this->personalia->query($sql)->result_array();
    }

    public function GetLokasi()
    {
        $sql = "SELECT * FROM hrd_khs.tlokasi_kerja";
        return $this->personalia->query($sql)->result_array();
    }

    public function GetKategori($txt, $txt2)
    {
        if ($txt2 == "Dept") {
            $trim = 1;
        } else if ($txt2 == "Unit") {
            $trim = 5;
        } else {
            $trim = 7;
        }
        $sql = "SELECT DISTINCT TRIM ($txt2) $txt2, left(kodesie,$trim) kode FROM hrd_khs.tseksi WHERE TRIM($txt2) != '-' AND $txt2 LIKE '$txt%'";
        return $this->personalia->query($sql)->result_array();
    }

    public function GetStatus()
    {
        $sql = "SELECT DISTINCT tpri.keluar, CASE
        WHEN tpri.keluar= 't' THEN 'Keluar'
        WHEN tpri.keluar= 'f' THEN 'Aktif'
        END status
             FROM hrd_khs.tpribadi tpri";
        return $this->personalia->query($sql)->result_array();
    }

    public function GetFilter($kodeind, $pend, $jenkel,  $lokasi, $kategori, $select, $rangekeluarstart, $rangekeluarend,  $rangemasukstart, $rangemasukend, $status, $masakerja)
    {
        $select = str_replace(';', ',', $select);
        if ($rangekeluarstart == "1000-01-01" && $rangemasukstart == "1000-01-01") {
            $sql = "SELECT DISTINCT tp.noind,$select $masakerja
            FROM hrd_khs.tseksi ts, hrd_khs.tpribadi tp
                LEFT JOIN hrd_khs.tbpjskes tb ON tb.noind = tp.noind
                LEFT JOIN hrd_khs.tbpjstk ttk ON ttk.noind=tp.noind
                LEFT JOIN hrd_khs.tb_master_jab tmj ON tmj.kd_jabatan=tp.kd_jabatan
                LEFT JOIN hrd_khs.tb_status_jabatan tj ON tj.noind=tp.noind
                LEFT JOIN
                    (
                        SELECT
                            tkel.noind,
                            string_agg(tkel.nama, ';') AS nama_keluarga,
                            string_agg(tkel.jenisanggota, ';') AS status_keluarga
                        FROM
                            (
                                SELECT 
                                    tk.noind,
                                    tmk.nokel,
                                    tk.nama as nama,
                                    tmk.jenisanggota as jenisanggota
                                FROM hrd_khs.tkeluarga tk
                                INNER JOIN hrd_khs.tmasterkel tmk ON tmk.nokel = tk.nokel
                                ORDER BY  noind,nokel
                            )as tkel
                        GROUP BY tkel.noind
                    ) AS tk ON tp.noind = tk.noind
                LEFT JOIN (
                    -- cari perpanjangan terakhir setiap noind
                    SELECT 
                        z.noind,
                        z.lama_perpanjangan, 
                        to_char(z.mulai_perpanjangan, 'DD/MM/YYYY') mulai_perpanjangan
                    FROM hrd_khs.tperpanjangan_pkwt z 
                        inner join 
                            (select noind, max(perpanjangan_ke) max_ke 
                                from hrd_khs.tperpanjangan_pkwt 
                                group by noind
                            ) r on r.noind = z.noind and r.max_ke = z.perpanjangan_ke
                ) pkwt ON pkwt.noind = tp.noind
                left join (
                    select tk1.noind,tk1.nama,tk1.nik,tk1.anggota_serumah,
                        tv1.status_vaksin,tv1.jenis_vaksin,tv1.tgl_vaksin_1,tv1.tgl_vaksin_2, tv1.lokasi_vaksin, tv1.kelompok_vaksin
                    from (
                        select tk2.noind,tk2.nama,tk2.nik, 
                            case tk2.serumah 
                            when '1' then 'Serumah'
                            when '0' then 'tidak serumah'
                            else 'Tidak Diketahui'
                            end  as anggota_serumah
                        from hrd_khs.tkeluarga tk2
                        union
                        select tp2.noind,tp2.nama,tp2.nik,'Pekerja' as anggota_serumah
                        from hrd_khs.tpribadi tp2
                    ) tk1
                    left join (
                        select noind,nik,nama,
                            (
                                case string_agg(vaksin_ke, '' order by vaksin_ke)
                                    when '1' then 'Sudah Vaksin 1'
                                    when '12' then 'Sudah Vaksin 2'
                                    when '123' then 'Sudah Vaksin 3'
                                    when '1234' then 'Sudah Vaksin 4'
                                    when '12345' then 'Sudah Vaksin 5'
                                    else string_agg(vaksin_ke, '' order by vaksin_ke)
                                    end
                            ) as status_vaksin,
                            string_agg(distinct jenis_vaksin,',') as jenis_vaksin,
                            string_agg(
                                (
                                    case when vaksin_ke ='1' then tanggal_vaksin::text
                                    else ''
                                    end
                                ),
                                ''
                            ) as tgl_vaksin_1,
                            string_agg(
                                (
                                    case when vaksin_ke ='2' then tanggal_vaksin::text
                                    else ''
                                    end
                                ),
                                ''
                            ) as tgl_vaksin_2,
                            string_agg(distinct lokasi_vaksin,',') as lokasi_vaksin,
                            string_agg(distinct kelompok_vaksin,',') as kelompok_vaksin
                        from hrd_khs.tvaksinasi
                        group by noind,nik,nama
                    ) tv1 on tk1.nik = tv1.nik and tk1.noind = tv1.noind
                ) as tv on tv.noind = tp.noind
            WHERE 
                ts.kodesie = tp.kodesie
                AND tp.kodesie LIKE '$kategori%' AND (tp.noind LIKE '$kodeind%') AND tp.pendidikan LIKE '$pend%' AND tp.jenkel 
                LIKE '$jenkel%' AND tp.lokasi_kerja LIKE '$lokasi%' AND tp.keluar = '$status' order by tp.noind";
            return $this->personalia->query($sql)->result_array();
        } else {
            $sql = "SELECT DISTINCT tp.noind,$select $masakerja
            FROM hrd_khs.tseksi ts, hrd_khs.tpribadi tp
            LEFT JOIN hrd_khs.tbpjskes tb ON tb.noind = tp.noind
            LEFT JOIN hrd_khs.tbpjstk ttk ON ttk.noind=tp.noind
            LEFT JOIN hrd_khs.tb_master_jab tmj ON tmj.kd_jabatan=tp.kd_jabatan
            LEFT JOIN hrd_khs.tb_status_jabatan tj ON tj.noind=tp.noind
            LEFT JOIN
                (
                    SELECT
                        tkel.noind,
                        string_agg(tkel.nama, ';') AS nama_keluarga,
                        string_agg(tkel.jenisanggota, ';') AS status_keluarga
                    FROM
                        (
                            SELECT 
                                tk.noind,
                                tmk.nokel,
                                tk.nama as nama,
                                tmk.jenisanggota as jenisanggota
                            FROM hrd_khs.tkeluarga tk
                            INNER JOIN hrd_khs.tmasterkel tmk ON tmk.nokel = tk.nokel
                            ORDER BY  noind,nokel
                        )as tkel
                    GROUP BY tkel.noind
                ) AS tk ON tp.noind = tk.noind
                left join (
                    select tk1.noind,tk1.nama,tk1.nik,tk1.anggota_serumah,
                        tv1.status_vaksin,tv1.jenis_vaksin,tv1.tgl_vaksin_1,tv1.tgl_vaksin_2, tv1.lokasi_vaksin, tv1.kelompok_vaksin
                    from (
                        select tk2.noind,tk2.nama,tk2.nik, 
                            case tk2.serumah 
                            when '1' then 'Serumah'
                            when '0' then 'tidak serumah'
                            else 'Tidak Diketahui'
                            end  as anggota_serumah
                        from hrd_khs.tkeluarga tk2
                        union
                        select tp2.noind,tp2.nama,tp2.nik,'Pekerja' as anggota_serumah
                        from hrd_khs.tpribadi tp2
                    ) tk1
                    left join (
                        select noind,nik,nama,
                            (
                                case string_agg(vaksin_ke, '' order by vaksin_ke)
                                    when '1' then 'Sudah Vaksin 1'
                                    when '12' then 'Sudah Vaksin 2'
                                    when '123' then 'Sudah Vaksin 3'
                                    when '1234' then 'Sudah Vaksin 4'
                                    when '12345' then 'Sudah Vaksin 5'
                                    else string_agg(vaksin_ke, '' order by vaksin_ke)
                                    end
                            ) as status_vaksin,
                            string_agg(distinct jenis_vaksin,',') as jenis_vaksin,
                            string_agg(
                                (
                                    case when vaksin_ke ='1' then tanggal_vaksin::text
                                    else ''
                                    end
                                ),
                                ''
                            ) as tgl_vaksin_1,
                            string_agg(
                                (
                                    case when vaksin_ke ='2' then tanggal_vaksin::text
                                    else ''
                                    end
                                ),
                                ''
                            ) as tgl_vaksin_2,
                            string_agg(distinct lokasi_vaksin,',') as lokasi_vaksin,
                            string_agg(distinct kelompok_vaksin,',') as kelompok_vaksin
                        from hrd_khs.tvaksinasi
                        group by noind,nik,nama
                    ) tv1 on tk1.nik = tv1.nik and tk1.noind = tv1.noind
                ) as tv on tv.noind = tp.noind
            WHERE ts.kodesie = tp.kodesie 
            AND tp.kodesie LIKE '$kategori%' AND (tp.noind LIKE '$kodeind%') AND tp.pendidikan LIKE '$pend%' AND tp.jenkel 
            LIKE '$jenkel%' AND tp.lokasi_kerja LIKE '$lokasi%' AND tp.keluar = '$status'
            AND (masukkerja > '$rangemasukstart' AND masukkerja < '$rangemasukend'  OR tglkeluar> '$rangekeluarstart' AND tglkeluar< '$rangekeluarend') order by tp.noind";
            return $this->personalia->query($sql)->result_array();
        }
    }

    function getData($kodesie)
    {
        $sql = "select noind,nama,masukkerja,nik,b.seksi
        from hrd_khs.tpribadi a 
        left join hrd_khs.tseksi b
        on a.kodesie = b.kodesie
        where a.kodesie like '$kodesie%'
        and keluar = '0'
        order by noind";
        return $this->personalia->query($sql)->result_array();
    }

    function getDetailByNoind($noind)
    {
        $sql = "select a.nama,b.jenisanggota
        from hrd_khs.tkeluarga a
        left join hrd_khs.tmasterkel b 
        on a.nokel = b.nokel
        where a.noind = '$noind'
        order by a.nokel";
        return $this->personalia->query($sql)->result_array();
    }
}
