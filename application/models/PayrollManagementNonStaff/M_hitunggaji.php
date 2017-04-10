<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_hitunggaji extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getHitungGaji($kodesie, $bln_gaji, $thn_gaji){
        $sql = "
            SELECT
                pab.\"HMS\" as \"IMSNilai\",
                pab.\"HMM\" as \"IMMNilai\",
                pab.\"UBT\" as \"UBTNilai\",
                pab.\"HUPAMK\" as \"UPAMKNilai\",
                pab.\"jam_lembur\" as \"jamLembur\",
                pab.\"jml_izin\",
                pab.\"jml_mangkir\",
                pab.\"DL\",
                pta.\"kurang_bayar\",
                pab.\"tambahan\",
                pta.\"lain_lain\" as \"tambahan_lain\",
                *
            FROM
                pr.pr_master_gaji pma

            LEFT JOIN
                er.er_employee_all eea ON pma.noind = eea.employee_code
            LEFT JOIN
                er.er_section ese ON eea.section_code = ese.section_code
            LEFT JOIN
                pr.pr_absensi pab ON pab.noind = pma.noind
            LEFT JOIN
                pr.pr_tambahan pta ON
                        pta.\"noind\" = pab.\"noind\"
                    AND pta.\"bulan_gaji\" = pab.\"bln_gaji\"
                    AND pta.\"tahun_gaji\" = pab.\"thn_gaji\"

            LEFT JOIN
                pr.pr_potongan ppo ON
                        ppo.\"noind\" = pab.\"noind\"
                    AND ppo.\"bulan_gaji\" = pab.\"bln_gaji\"
                    AND ppo.\"tahun_gaji\" = pab.\"thn_gaji\"

            WHERE
                    pma.\"kodesie\" = '$kodesie'
                AND pab.\"bln_gaji\" = '$bln_gaji'
                AND pab.\"thn_gaji\" = '$thn_gaji'
        ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getAllEmployee($kodesie)
    {
    	// $query = $this->db->get_where('er.er_employee_all', array('section_code' => $kodesie));

    	// return $query->result_array();

        $sql = "
            SELECT

                *

            FROM
                er.er_employee_all eea
            LEFT JOIN er.er_section ese ON eea.section_code = ese.section_code

            WHERE
                    eea.section_code ILIKE '$kodesie%'
        ";

        $query = $this->db->query($sql);
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
                pab.\"HMS\" as \"IMS\",
                pab.\"HMM\" as \"IMM\",
                pab.\"UBT\",
                pab.\"HUPAMK\" as \"UPAMK\",
                pab.\"jam_lembur\" as \"jamLembur\",
                pab.\"jml_izin\",
                pab.\"jml_mangkir\",
                pab.\"DL\",
                pta.\"kurang_bayar\",
                pab.\"tambahan\",
                pta.\"lain_lain\" as \"tambahan_lain\",
                *

            FROM
                pr.pr_absensi pab

            LEFT JOIN
                pr.pr_tambahan pta
                    ON
                        pta.\"noind\" = pab.\"noind\"
                    AND pta.\"bulan_gaji\" = pab.\"bln_gaji\"
                    AND pta.\"tahun_gaji\" = pab.\"thn_gaji\"

            LEFT JOIN
                pr.pr_potongan ppo
                    ON
                        ppo.\"noind\" = pab.\"noind\"
                    AND ppo.\"bulan_gaji\" = pab.\"bln_gaji\"
                    AND ppo.\"tahun_gaji\" = pab.\"thn_gaji\"

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
                        rtrim(pls.kode_barang) as kd_brg,
                        ptb.target_utama_senin_kamis as target_senin_kamis,
                        ptb.target_utama_jumat_sabtu as target_jumat_sabtu
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
                        rtrim(pls.kode_barang) as kd_brg,
                        ptb.target_sementara_senin_kamis as target_senin_kamis,
                        ptb.target_sementara_jumat_sabtu as target_jumat_sabtu
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

    public function deleteHasilHitung($data){
        $this->db->where($data);
        $this->db->delete('pr.pr_hasil_perhitungan_gaji');
    }

    public function setHasilHitung($data)
    {
        return $this->db->insert('pr.pr_hasil_perhitungan_gaji', $data);
    }

    public function getHasilHitungDatatables()
    {
        $sql = "
            SELECT * FROM pr.pr_hasil_perhitungan_gaji php
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = php.noind
            LEFT JOIN er.er_section ese ON ese.section_code = eea.section_code
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getHasilHitungSearch($searchValue)
    {
        $sql = "
            SELECT * FROM pr.pr_hasil_perhitungan_gaji php
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = php.noind
            LEFT JOIN er.er_section ese ON ese.section_code = eea.section_code
            WHERE
                    CAST(php.\"noind\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"kodesie\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"bln_gaji\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"thn_gaji\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"gaji_pokok\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"insentif_prestasi\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"insentif_kelebihan\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"insentif_kondite\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"insentif_masuk_sore\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"insentif_masuk_malam\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"ubt\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"upamk\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"uang_lembur\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"tambah_kurang_bayar\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"tambah_lain\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"uang_dl\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"tambah_pajak\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"denda_insentif_kondite\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"pot_htm\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"pot_lebih_bayar\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"pot_gp\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"pot_uang_dl\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"jht\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"jkn\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"jp\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"spsi\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"duka\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"pot_koperasi\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"pot_hutang_lain\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"pot_dplk\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"tkp\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_insentif_prestasi\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_insentif_kelebihan\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_insentif_kondite\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_ims\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_imm\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_ubt\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_upamk\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_tambah_kurang_bayar\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_pot_htm\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_uang_lembur\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"tgl_pembayaran\" AS TEXT) ILIKE '%$searchValue%'

                OR  eea.employee_name ILIKE '%$searchValue%'
                OR  unit_name ILIKE '%$searchValue%'
                
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getHasilHitungOrderLimit($searchValue, $order_col, $order_dir, $limit, $offset){
        if ($searchValue == NULL || $searchValue == "") {
            $condition = "";
        }
        else{
            $condition = "
                WHERE
                    CAST(php.\"noind\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"kodesie\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"bln_gaji\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"thn_gaji\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"gaji_pokok\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"insentif_prestasi\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"insentif_kelebihan\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"insentif_kondite\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"insentif_masuk_sore\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"insentif_masuk_malam\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"ubt\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"upamk\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"uang_lembur\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"tambah_kurang_bayar\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"tambah_lain\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"uang_dl\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"tambah_pajak\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"denda_insentif_kondite\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"pot_htm\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"pot_lebih_bayar\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"pot_gp\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"pot_uang_dl\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"jht\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"jkn\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"jp\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"spsi\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"duka\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"pot_koperasi\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"pot_hutang_lain\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"pot_dplk\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"tkp\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_insentif_prestasi\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_insentif_kelebihan\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_insentif_kondite\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_ims\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_imm\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_ubt\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_upamk\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_tambah_kurang_bayar\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_pot_htm\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"hitung_uang_lembur\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(php.\"tgl_pembayaran\" AS TEXT) ILIKE '%$searchValue%'

                OR  eea.employee_name ILIKE '%$searchValue%'
                OR  unit_name ILIKE '%$searchValue%'
            ";
        }
        $sql="
            SELECT * FROM pr.pr_hasil_perhitungan_gaji php
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = php.noind
            LEFT JOIN er.er_section ese ON ese.section_code = eea.section_code

            $condition

            ORDER BY \"$order_col\" $order_dir LIMIT $limit OFFSET $offset
            ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getHitungGajiById($id)
    {
        $query = $this->db->select('*')->from('pr.pr_hasil_perhitungan_gaji')->join('er.er_employee_all', 'er.er_employee_all.employee_code=pr.pr_hasil_perhitungan_gaji.noind')->join('er.er_section', 'er.er_section.section_code=er.er_employee_all.section_code')->where('hasil_perhitungan_id', $id)->get();
        return $query->result_array();
    }

    public function getSetelan($setelan_name)
    {
        $query = $this->db->get_where('pr.pr_setelan', array('setelan_name' => $setelan_name));
        // return $query->result();
        foreach ($query->result() as $data) {
            return $data->setelan_value;
        }
    }

}

/* End of file M_kondite.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_kondite.php */
/* Generated automatically on 2017-03-20 13:35:14 */