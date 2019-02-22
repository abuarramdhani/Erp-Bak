<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class M_mastergajikaryawan extends CI_Model
    {

        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        // Retrieve all employees salaries and their details
        function get_all($year, $month, $dept)
        {

            $sql = "
                WITH tabel_gaji AS (
                    SELECT *
                    FROM pr.pr_riwayat_gaji
                    WHERE pr.pr_riwayat_gaji.tgl_tberlaku > DATE(CONCAT('$year','-','$month','-','01')) 
                        AND pr.pr_riwayat_gaji.tgl_berlaku <= DATE(CONCAT('$year','-','$month','-','01'))
                ), tabel_upamk AS (
                    SELECT *
                    FROM pr.pr_riwayat_upamk
                    WHERE pr.pr_riwayat_upamk.tgl_tberlaku > CURRENT_DATE
                ), tabel_i_mahal AS (
                    SELECT *
                    FROM pr.pr_riwayat_insentif_kemahalan
                    WHERE pr.pr_riwayat_insentif_kemahalan.tgl_tberlaku > CURRENT_DATE
                ), tabel_karyawan_ptkp AS (
                    SELECT pr.pr_master_pekerja.*, 
                    concat(CASE WHEN stat_pajak='K ' THEN 'K' ELSE 'TK' END, 
                        CASE WHEN 
                            COALESCE(CAST(NULLIF(pr.pr_master_pekerja.jt_anak, '') AS INTEGER), 0) 
                            	+ COALESCE(CAST(NULLIF(pr.pr_master_pekerja.jt_bkn_anak, '') AS INTEGER), 0) < 3 
                            		THEN COALESCE(CAST(NULLIF(pr.pr_master_pekerja.jt_anak, '') AS INTEGER), 0) 
                            			+ COALESCE(CAST(NULLIF(pr.pr_master_pekerja.jt_bkn_anak, '') AS INTEGER), 0)
                            ELSE '3' 
                        END) AS status_pajak,
                    pr.pr_master_seksi.dept AS dept 
                    FROM pr.pr_master_pekerja
                    LEFT JOIN pr.pr_master_seksi
                    ON pr.pr_master_pekerja.kodesie = pr.pr_master_seksi.kodesie
                    WHERE COALESCE(NULLIF(pr.pr_master_seksi.dept, ''), '-') = '$dept'
                )
                SELECT tabel_karyawan_ptkp.noind AS no_induk, 
                    tabel_karyawan_ptkp.nama AS nama, 
                    COALESCE(CAST(NULLIF(pr.pr_master_param_ptkp.ptkp_per_tahun, '') AS NUMERIC), 0) AS ptkp,
                    COALESCE(CAST(NULLIF(tabel_gaji.gaji_pokok, '') AS NUMERIC), 0) AS gaji_pokok,
                    COALESCE(CAST(NULLIF(tabel_gaji.i_f, '') AS NUMERIC), 0) * 25 AS i_f,
                    COALESCE(CAST(NULLIF(pr.pr_master_param_komp_jab.ip, '') AS NUMERIC), 0) * 25 AS i_p,
                    COALESCE(CAST(NULLIF(pr.pr_master_param_komp_jab.ik, '') AS NUMERIC), 0) * 25 AS i_k,
                    CASE WHEN 
                        tabel_karyawan_ptkp.kd_status_kerja = 'B' THEN COALESCE(CAST(NULLIF(pr.pr_master_param_komp_umum.ubt, '') AS NUMERIC), 0) * 25
                        ELSE 0
                    END AS ubt,
                    COALESCE(CAST(NULLIF(tabel_upamk.upamk, '') AS NUMERIC), 0) * 25 AS upamk,
                    COALESCE(CAST(NULLIF(tabel_i_mahal.insentif_kemahalan, '') AS NUMERIC), 0) * 25 AS i_mahal,
                    COALESCE(CAST(NULLIF(pr.pr_master_param_tarif_jamsostek.jht_perusahaan, '') AS NUMERIC), 0) / 100 * COALESCE(CAST(NULLIF(tabel_gaji.gaji_pokok, '') AS NUMERIC), 0) AS jht,
                    COALESCE(CAST(NULLIF(pr.pr_master_param_bpjs.jkn_tg_prshn, '') AS NUMERIC), 0) / 100 * COALESCE(CAST(NULLIF(tabel_gaji.gaji_pokok, '') AS NUMERIC), 0) AS jkn,
                    COALESCE(CAST(NULLIF(pr.pr_data_gajian_personalia.pduka, '') AS NUMERIC), 0) AS pot_duka,
                    COALESCE(CAST(NULLIF(pr.pr_data_gajian_personalia.pspsi, '') AS NUMERIC), 0) AS pot_spsi,
                    COALESCE(CAST(NULLIF(pr.pr_data_gajian_personalia.pikop, '') AS NUMERIC), 0) AS pot_ikop,
                    ((COALESCE(CAST(NULLIF(tabel_gaji.gaji_pokok, '') AS NUMERIC), 0))
                        + (COALESCE(CAST(NULLIF(tabel_gaji.i_f, '') AS NUMERIC), 0) * 25)
                        + (COALESCE(CAST(NULLIF(pr.pr_master_param_komp_jab.ip, '') AS NUMERIC), 0) * 25)
                        + (COALESCE(CAST(NULLIF(pr.pr_master_param_komp_jab.ik, '') AS NUMERIC), 0) * 25)
                        + ( CASE WHEN 
                            tabel_karyawan_ptkp.kd_status_kerja = 'B' THEN COALESCE(CAST(NULLIF(pr.pr_master_param_komp_umum.ubt, '') AS NUMERIC), 0) * 25
                            ELSE 0
                        END )
                        + (COALESCE(CAST(NULLIF(tabel_upamk.upamk, '') AS NUMERIC), 0) * 25)
                        + (COALESCE(CAST(NULLIF(tabel_i_mahal.insentif_kemahalan, '') AS NUMERIC), 0) * 25)
                        + (COALESCE(CAST(NULLIF(pr.pr_master_param_tarif_jamsostek.jht_perusahaan, '') AS NUMERIC), 0) / 100 * COALESCE(CAST(NULLIF(tabel_gaji.gaji_pokok, '') AS NUMERIC), 0))
                        + (COALESCE(CAST(NULLIF(pr.pr_master_param_bpjs.jkn_tg_prshn, '') AS NUMERIC), 0) / 100 * COALESCE(CAST(NULLIF(tabel_gaji.gaji_pokok, '') AS NUMERIC), 0))
                        - (COALESCE(CAST(NULLIF(pr.pr_data_gajian_personalia.pduka, '') AS NUMERIC), 0))
                        - (COALESCE(CAST(NULLIF(pr.pr_data_gajian_personalia.pspsi, '') AS NUMERIC), 0))
                        - (COALESCE(CAST(NULLIF(pr.pr_data_gajian_personalia.pikop, '') AS NUMERIC), 0))
                    ) AS thp
                FROM tabel_karyawan_ptkp
                LEFT JOIN pr.pr_master_param_ptkp
                	ON tabel_karyawan_ptkp.status_pajak = pr.pr_master_param_ptkp.status_pajak
                LEFT JOIN tabel_gaji
                	ON tabel_karyawan_ptkp.noind = tabel_gaji.noind
                LEFT JOIN pr.pr_master_param_komp_jab
                	ON tabel_karyawan_ptkp.kd_status_kerja = pr.pr_master_param_komp_jab.kd_status_kerja AND tabel_karyawan_ptkp.kd_jabatan = pr.pr_master_param_komp_jab.kd_jabatan
                CROSS JOIN pr.pr_master_param_komp_umum
                LEFT JOIN tabel_upamk
                	ON tabel_karyawan_ptkp.noind = tabel_upamk.noind
                LEFT JOIN tabel_i_mahal
                	ON tabel_karyawan_ptkp.noind = tabel_i_mahal.noind
                CROSS JOIN pr.pr_master_param_tarif_jamsostek
                CROSS JOIN pr.pr_master_param_bpjs
                LEFT JOIN pr.pr_data_gajian_personalia
                	ON tabel_karyawan_ptkp.noind = pr.pr_data_gajian_personalia.noind
                ORDER BY thp DESC
            ";

            $query = $this->db->query($sql);
            return $query->result_array();
        }

        // Retrieve all department names
        function get_departments()
        {
            $sql = "
                SELECT DISTINCT(dept)
                FROM pr.pr_master_seksi
                ORDER BY pr.pr_master_seksi.dept ASC
            ";

            $query = $this->db->query($sql);
            return $query->result_array();
        }
    }

?>