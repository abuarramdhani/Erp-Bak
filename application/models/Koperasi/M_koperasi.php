<?php 

defined('BASEPATH') or exit("error");

class M_koperasi extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', true);
    }

    function checkPeriode($periode) {
        //tahun-bulan
        $periode = date('Y-m', strtotime('01-'.$periode));
        $query = "SELECT DISTINCT * FROM \"Presensi\".t_potongan_koperasi WHERE periode = '$periode'";
        return ($this->personalia->query($query)->num_rows()) > 0 ? true: false;
    }

    function insertData($item) {
        $res = $this->personalia->insert('"Presensi.t_potongan_koperasi"', $item);
        return $res;
    }

    function getList() {
        $sql = "select periode ,count(*) FROM \"Presensi\".t_potongan_koperasi where periode in (select distinct periode from \"Presensi\".t_potongan_koperasi) group by periode order by periode desc";
        $data = $this->personalia->query($sql)->result_array();
        return $data;
    }

    function getListDetail($periode) {
        $sqlAll = "SELECT * FROM \"Presensi\".t_potongan_koperasi where periode='$periode'";
        $sqlSum = "SELECT   sum(s_pokok) s_pokok,
                            sum(s_wajib) s_wajib,
                            sum(s_sukarela) s_sukarela,
                            sum(p_uang) p_uang,
                            sum(b_uang) b_uang,
                            sum(bpd_pmotor) bpd_pmotor,
                            sum(bpd_adm) bpd_adm,
                            sum(p_barang) p_barang,
                            sum(b_barang) b_barang,
                            sum(total) total,
                            sum(jumlah) jumlah
          FROM \"Presensi\".t_potongan_koperasi where periode='$periode'";
        
        $result = array(
            'list' => $this->personalia->query($sqlAll)->result_array(),
            'sum' =>  $this->personalia->query($sqlSum)->result_array()
        );
        
        return $result;
    }

    function delList($periode) {
        $sql = "DELETE FROM \"Presensi\".t_potongan_koperasi where periode = '$periode'";
        return $this->personalia->query($sql); //will result true/false
    }
}
