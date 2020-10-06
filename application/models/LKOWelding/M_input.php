<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_input extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
        $this->personalia = $this->load->database('personalia', true);
    }

    public function listEmployee($term)
    {
        $sql = "select noind, trim(nama) as nama from hrd_khs.tpribadi where noind like '%$term%' or nama like '%$term%' ";

        $query = $this->personalia->query($sql);
        return $query->result_array();
    }
    public function getName($noind)
    {
        $sql = "select trim(nama) as nama from hrd_khs.tpribadi where noind = '$noind'";

        $query = $this->personalia->query($sql);
        return $query->result_array();
    }
    public function getIdOr()
    {
        $sql = "SELECT max(LKO_ID) baris from khs_laporan_kerja_operator";

        $query = $this->oracle->query($sql);
        return $query->row()->BARIS + 1;
    }
    public function insertLKO($idOr, $seksi, $ind, $nama, $work, $created_by, $creation_date, $tgl, $tgt, $act, $percent, $shift, $ket, $mk, $i, $bk, $tkp, $kp, $ks, $kk, $pk)
    {
        $sql = "insert into khs_laporan_kerja_operator(LKO_ID,SEKSI,NO_INDUK,NAMA_PEKERJA,URAIAN_PEKERJAAN,CREATED_BY,CREATION_DATE,TANGGAL,PENCAPAIAN_TGT,PENCAPAIAN_ACT,PENCAPAIAN_PERSEN,SHIFT,KETERANGAN,KONDITE_MK,KONDITE_I,KONDITE_BK,KONDITE_TKP,KONDITE_KP,KONDITE_KS,KONDITE_KK,KONDITE_PK) values ($idOr, '$seksi', '$ind', '$nama', '$work', '$created_by',TO_TIMESTAMP('$creation_date', 'DD-MM-YYYY'), TO_TIMESTAMP('$tgl', 'DD-MM-YYYY'), $tgt, $act, $percent,'$shift', '$ket', '$mk', '$i', '$bk', '$tkp', '$kp', '$ks', '$kk', '$pk')";
        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function dataSeksi($noind)
    {
        $sql = "select
    substring(em.section_code, 1, 7) kodesie,
    es.department_name dept,
    es.field_name bidang,
    es.unit_name unit,
    es.section_name seksi
  from
    er.er_employee_all em,
    er.er_section es
  where
    es.section_code = em.section_code
    and em.employee_code = '$noind'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function selectLKO()
    {
        $sql = "SELECT * from khs_laporan_kerja_operator order by lko_id";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function LKObyTgl($tanggal)
    {
        $sql = "SELECT * FROM khs_laporan_kerja_operator WHERE TRUNC (tanggal) = TO_DATE ('$tanggal', 'DD-MM-YYYY') order by lko_id";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function EditData($id)
    {
        $sql = "SELECT * FROM khs_laporan_kerja_operator WHERE LKO_ID = '$id' order by lko_id";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function updateLKO($id, $work, $tgt, $act, $percent, $shift, $ket, $mk, $i, $bk, $tkp, $kp, $ks, $kk, $pk)
    {
        $sql = "update KHS_LAPORAN_KERJA_OPERATOR set URAIAN_PEKERJAAN = '$work',
        PENCAPAIAN_TGT='$tgt',
        PENCAPAIAN_ACT='$act',
        PENCAPAIAN_PERSEN='$percent',
        SHIFT='$shift',
        KETERANGAN ='$ket',
        KONDITE_MK='$mk',
        KONDITE_I='$i',
        KONDITE_BK='$bk',
        KONDITE_TKP='$tkp',
        KONDITE_KP='$kp',
        KONDITE_KS='$ks',
        KONDITE_KK='$kk',
        KONDITE_PK='$pk'
        where LKO_ID ='$id'";

        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function DeleteData($id)
    {
        $sql = "delete from KHS_LAPORAN_KERJA_OPERATOR where LKO_ID = '$id'";
        $query = $this->oracle->query($sql);
        return $sql;
    }
}
