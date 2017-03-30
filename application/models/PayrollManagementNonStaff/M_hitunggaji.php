<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_hitunggaji extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllEmployee($kodesie)
    {
    	$query = $this->db->get_where('er.er_employee_all', array('section_code' => $kodesie));

    	return $query->result_array();
    }

    public function getMasterGaji($noind, $kodesie)
    {
        $query = $this->db->get_where('pr.pr_master_gaji', array('noind' => $noind, 'kodesie' => $kodesie));

        return $query->result_array();
    }

    public function getKomponenAbsensi($noind, $kodesie, $bln_gaji, $thn_gaji, $gajiPokok, $insentifMasukSore, $insentifMasukMalam, $UBT, $UPAMK)
    {

        $sql = "
            SELECT

                (CAST(pab.\"HMS\" as numeric) * '$insentifMasukSore') as \"insentifMasukSore\",
                (CAST(pab.\"HMM\" as numeric) * '$insentifMasukMalam') as \"insentifMasukMalam\",
                (CAST(pab.\"UBT\" as numeric) * '$UBT') as \"UBT\",
                (CAST(pab.\"HUPAMK\" as numeric) * '$UPAMK') as \"UPAMK\",
                (CAST(pab.\"jam_lembur\" as numeric) * ($gajiPokok/173)) as \"uang_lembur\",
                (CAST((pab.\"jml_izin\" + pab.\"jml_mangkir\") as numeric) * ($gajiPokok/30)) as \"potHTM\",
                pab.\"DL\",
                (pta.\"kurang_bayar\" + pab.\"tambahan\") as \"tambahan_kurang_bayar\" ,
                pta.\"lain_lain\" as \"tambahan_lain\"

            FROM
                pr.pr_absensi pab

            LEFT JOIN
                pr.pr_tambahan pta
                    ON
                        pta.\"noind\" = pab.\"noind\"
                    AND pta.\"bulan_gaji\" = pab.\"bln_gaji\"
                    AND pta.\"tahun_gaji\" = pab.\"thn_gaji\"

            WHERE
                    pab.\"noind\" = '$noind'
                AND pab.\"kodesie\" = '$kodesie'
                AND pab.\"bln_gaji\" = '$bln_gaji'
                AND pab.\"thn_gaji\" = '$thn_gaji'
        ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getPotongan($noind, $bln_gaji, $thn_gaji)
    {

        $sql = "
            SELECT

                *

            FROM
                pr.pr_potongan ppo

            WHERE
                    ppo.\"noind\" = '$noind'
                AND ppo.\"bulan_gaji\" = '$bln_gaji'
                AND ppo.\"tahun_gaji\" = '$thn_gaji'
        ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getLKHSeksi($noind, $firstdate, $lastdate)
    {

        $sql = "
            SELECT * FROM
            (
                    (
                    SELECT
                        *,
                        (pls.jml_barang-pls.reject) as jml_baik,
                        ptb.target_utama as target,
                        (100/ptb.target_utama) as proposional_target,
                        (ptb.waktu_setting/ptb.target_utama) as cycle_time,
                        ((pls.jml_barang-pls.reject)*(100/ptb.target_utama)) as pencapaian
                    FROM
                        pr.pr_lkh_seksi pls
                    LEFT JOIN
                        pr.pr_target_benda ptb
                            ON
                                rtrim(pls.kode_barang) = rtrim(ptb.kode_barang)
                            AND rtrim(pls.kode_proses) = rtrim(ptb.kode_proses)

                    WHERE
                            rtrim(pls.kode_barang_target_sementara) = ''
                        OR  rtrim(pls.kode_proses_target_sementara) = ''
                    )

                UNION

                    (
                    SELECT
                        *,
                        (pls.jml_barang-pls.reject) as jml_baik,
                        ptb.target_sementara as target,
                        (100/ptb.target_sementara) as proposional_target,
                        (ptb.waktu_setting/ptb.target_sementara) as cycle_time,
                        ((pls.jml_barang-pls.reject)*(100/ptb.target_sementara)) as pencapaian
                    FROM
                        pr.pr_lkh_seksi pls
                    LEFT JOIN
                        pr.pr_target_benda ptb
                            ON
                                rtrim(pls.kode_barang_target_sementara) = rtrim(ptb.kode_barang)
                            AND rtrim(pls.kode_proses_target_sementara) = rtrim(ptb.kode_proses)

                    WHERE
                            rtrim(pls.kode_barang_target_sementara) != ''
                        OR  rtrim(pls.kode_proses_target_sementara) != ''
                    )
            )

            AS

            t(lkhSeksi)

            WHERE
                    \"noind\" = '$noind'
                AND \"tgl\" BETWEEN '$firstdate' AND '$lastdate'

            ORDER BY
                tgl ASC
        ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getInsentifKondite($noind, $kodesie, $firstdate, $lastdate)
    {

        $sql = "
            SELECT

                *

            FROM
                pr.pr_kondite pko

            WHERE
                    pko.\"noind\" = '$noind'
                AND pko.\"kodesie\" = '$kodesie'
                AND pko.\"tanggal\" BETWEEN '$firstdate' AND '$lastdate'
        ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

}

/* End of file M_kondite.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_kondite.php */
/* Generated automatically on 2017-03-20 13:35:14 */