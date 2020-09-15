<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_consumable extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->personalia = $this->load->database('personalia', true);
    $this->oracle = $this->load->database('oracle', true);
  }

  public function itemmm($term)
  {
    $sql = "SELECT DISTINCT msib.segment1 item_code, msib.description,
    msib.primary_uom_code
FROM mtl_system_items_b msib, mtl_onhand_quantities_detail moqd
WHERE msib.organization_id = 102
AND msib.organization_id = moqd.organization_id
AND msib.inventory_item_id = moqd.inventory_item_id
AND moqd.subinventory_code IN ('PNL-DM', 'PNL-TKS')
AND msib.inventory_item_status_code = 'Active'
AND (msib.segment1 LIKE '%$term%' OR msib.description LIKE '%$term%')
ORDER BY 1";

    $query = $this->oracle->query($sql);
    return $query->result_array();
  }
  public function getDescUom($item)
  {
    $sql = "SELECT msib.description DESKRIPSI, msib.primary_uom_code SATUAN
    FROM mtl_system_items_b msib
   WHERE msib.organization_id = 102
     AND msib.inventory_item_status_code = 'Active'
     AND msib.segment1 = '$item'
ORDER BY 1";

    $query = $this->oracle->query($sql);
    return $query->result_array();
  }
  public function getIdOr()
  {
    $sql = "SELECT max(NO_ID) baris from im_master_bon";

    $query = $this->oracle->query($sql);
    return $query->row()->BARIS + 1;
  }
  public function InsertMasterItem($item_code, $item_desc, $uom, $created_by, $creation_date)
  {
    $sql = "insert into csm.csm_master_item ( item_code, item_desc, uom, created_by, creation_date )  values ('$item_code', '$item_desc', '$uom', '$created_by' , '$creation_date')";

    $query = $this->db->query($sql);
    return $sql;
  }
  public function selectmasteritem()
  {
    $sql = "SELECT * FROM csm.csm_master_item";

    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function selectkebutuhan()
  {
    $sql = "SELECT * FROM csm.csm_standar_kebutuhan";

    $query = $this->db->query($sql);
    return $query->result_array();
  }
  public function selectkebutuhan2($kodesie)
  {
    $sql = "SELECT * FROM csm.csm_standar_kebutuhan where kodesie ='$kodesie' and approve_status ='0'";

    $query = $this->db->query($sql);
    return $query->result_array();
  }
  public function selectkebutuhaninput($kodesie)
  {
    $sql = "SELECT * FROM csm.csm_standar_kebutuhan where kodesie ='$kodesie'";

    $query = $this->db->query($sql);
    return $query->result_array();
  }
  public function selectkebutuhanapproved()
  {
    $sql = "SELECT * FROM csm.csm_standar_kebutuhan where approve_status ='1'";

    $query = $this->db->query($sql);
    return $query->result_array();
  }
  public function selectkebutuhan3($kodesie)
  {
    $sql = "SELECT * FROM csm.csm_standar_kebutuhan where kodesie ='$kodesie' and approve_status ='1' order by creation_date desc";

    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function selectkebutuhan4($kodesie, $tanggalbon)
  {
    $sql = "select
    ch.kodesie,
    ch.item_code,
    cmi.item_desc,
    ch.qty qty_kebutuhan,
    coalesce(bon.ttl, 0) qty_dibon,
    ch.qty-coalesce(bon.ttl, 0) sisa_saldo
  from
    csm.csm_hitung ch
  left join (
      select cb.kodesie,
      cb.periode,
      cb.item_code,
      coalesce(sum(cb.qty_bon), 0) ttl
    from
      csm.csm_bon cb
    group by
      cb.periode,
      cb.item_code,
      cb.kodesie) bon on
    ch.item_code = bon.item_code
    and ch.periode = bon.periode
    and ch.kodesie = bon.kodesie,
    csm.csm_master_item cmi
  where
    ch.item_code = cmi.item_code
    and ch.periode = '$tanggalbon'
    and ch.kodesie = '$kodesie'
  order by
    1,
    2";

    $query = $this->db->query($sql);
    return $query->result_array();
  }
  public function selectkebutuhann($kodesie)
  {
    $sql = "SELECT * 
    FROM csm.csm_standar_kebutuhan 
    where kodesie ='$kodesie' 
    and approve_status ='3'";

    $query = $this->db->query($sql);
    return $query->result_array();
  }
  public function getkebutuhanbyItem($code)
  {
    $sql = "SELECT * FROM csm.csm_standar_kebutuhan 
    where approve_status ='3'
    and item_code ='$code' 
    order by id desc";
    $query = $this->db->query($sql);
    return $query->result_array();
  }
  public function selectkebutuhanapprovedbyPPIC()
  {
    $sql = "SELECT * 
    FROM csm.csm_standar_kebutuhan 
    where approve_status ='3'";

    $query = $this->db->query($sql);
    return $query->result_array();
  }
  public function selectkebutuhanapprovedbyPPICwithcode($code)
  {
    $sql = "SELECT * 
    FROM csm.csm_standar_kebutuhan 
    where approve_status ='3' 
    and item_code ='$code'
    order by id desc";

    $query = $this->db->query($sql);
    return $query->result_array();
  }
  public function selectdatabon($no_bon)
  {
    $sql = "SELECT * FROM csm.csm_bon where no_bon ='$no_bon'";

    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function selectdatabon1($kodesie, $item)
  {
    $sql = "SELECT * FROM csm.csm_bon where item_code ='$item' and kodesie ='$kodesie' order by id desc";

    $query = $this->db->query($sql);
    return $query->result_array();
  }


  public function getItemMaster($term)
  {
    $sql = "SELECT item_code, item_desc FROM csm.csm_master_item where item_code||' - '||item_desc like '%$term%' ";

    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getDescItemMaster($item)
  {
    $sql = "SELECT * FROM csm.csm_master_item where item_code='$item'";

    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function carikodesie($noind)
  {
    $sql = "SELECT substring(em.section_code,1,7) kodesie FROM er.er_employee_all em where em.employee_code = '$noind'";

    $query = $this->db->query($sql);
    return $query->result_array();
  }
  public function insertkebutuhan($item_code, $quantity, $kodesie, $created_by, $creation_date)
  {
    $sql = "insert into csm.csm_standar_kebutuhan (item_code, quantity, kodesie, approve_status, creation_date, created_by )  values ('$item_code', '$quantity', '$kodesie', '0' , '$creation_date' , '$created_by')";

    $query = $this->db->query($sql);
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
  public function dataSeksibykodesie()
  {
    $sql = "select
    distinct substring(es.section_code, 1, 7) kodesie,
    es.department_name dept,
    es.field_name bidang,
    es.unit_name unit,
    es.section_name seksi
  from
    csm.csm_standar_kebutuhan csk,
    er.er_section es
  where
    csk.kodesie = substring(es.section_code, 1, 7)";

    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function UpdateApprove($id, $item, $approved_by, $approve_date)
  {
    $sql = "UPDATE csm.csm_standar_kebutuhan SET approve_status = '1', approve_date='$approve_date', approved_by='$approved_by' where item_code = '$item' and id='$id'";

    $query = $this->db->query($sql);
    return $sql;
  }
  public function UpdateReject($id, $item, $approved_by, $approve_date)
  {
    $sql = "UPDATE csm.csm_standar_kebutuhan SET approve_status = '2', approve_date = '$approve_date', approved_by = '$approved_by'  where item_code = '$item' and id='$id'";

    $query = $this->db->query($sql);
    return $sql;
  }
  public function UpdateApprovePPIC($id, $item, $approved_by, $approve_date)
  {
    $sql = "UPDATE csm.csm_standar_kebutuhan SET approve_status = '3' , ppic_approve_date='$approve_date', ppic_approve_by='$approved_by' where item_code = '$item' and id='$id'";

    $query = $this->db->query($sql);
    return $sql;
  }
  public function UpdateRejectPPIC($id, $item, $approved_by, $approve_date)
  {
    $sql = "UPDATE csm.csm_standar_kebutuhan SET approve_status = '4', ppic_approve_date='$approve_date', ppic_approve_by='$approved_by' where item_code = '$item' and id='$id'";

    $query = $this->db->query($sql);
    return $sql;
  }
  public function Insertbon($item_code, $qty_kebutuhan, $qty_bon, $qty_saldo, $input_by, $bon_date, $kodesie, $no_bon, $periodebon)
  {
    $sql = "insert into csm.csm_bon (kodesie, bon_date, item_code, qty_bon, input_by, qty_kebutuhan, qty_saldo, no_bon, periode )  values ('$kodesie', '$bon_date', '$item_code', '$qty_bon', '$input_by', '$qty_kebutuhan', '$qty_saldo', '$no_bon','$periodebon')";

    $query = $this->db->query($sql);
    return $sql;
  }
  public function getDataSeksi($term)
  {
    $sql = "SELECT ffv.FLEX_VALUE as COST_CENTER,
                    ffvt.DESCRIPTION as PEMAKAI,
                    ffv.ATTRIBUTE10
                from fnd_flex_values ffv,
                    fnd_flex_values_TL ffvt
                where ffv.FLEX_VALUE_SET_ID=1013709
                    and ffv.ATTRIBUTE10 != ' '
                    and ffv.ATTRIBUTE10 = 'Seksi'
                    and ffv.FLEX_VALUE_ID=ffvt.FLEX_VALUE_ID
                    AND ffv.END_DATE_ACTIVE IS NULL
                    AND ffv.flex_value NOT LIKE '0000'
                    and ffv.ENABLED_FLAG = 'Y'
                    and ffv.SUMMARY_FLAG = 'N'
                    and ffvt.DESCRIPTION like '%$term%'
                order by ffv.FLEX_VALUE
                ";
    // echo $sql;exit();
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }
  function getBranch($cost)
  {
    $sql = "SELECT ffv.FLEX_VALUE as COST_CENTER,
                    ffvt.DESCRIPTION as PEMAKAI,
                    ffv.ATTRIBUTE10,
                     (case when (substr(ffv.FLEX_VALUE, 0,1)<=6) and (substr(ffv.FLEX_VALUE, 0,1)!=0)
                        then 'AA'
                        when (substr(ffv.FLEX_VALUE, 0,1)>=7)
                        then 'AC'
                    end) kode_cabang
                from fnd_flex_values ffv,
                    fnd_flex_values_TL ffvt
                where ffv.FLEX_VALUE_SET_ID=1013709
                    and ffv.ATTRIBUTE10 != ' '
                    and ffv.FLEX_VALUE = '$cost'
                    and ffv.FLEX_VALUE_ID=ffvt.FLEX_VALUE_ID
                    AND ffv.END_DATE_ACTIVE IS NULL
                    and ffv.ENABLED_FLAG = 'Y'
                order by ffv.FLEX_VALUE";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }
  public function getDetailPekerja($noind)
  {
    $sql = "SELECT * from hrd_khs.tpribadi where noind = '$noind'";
    return $this->personalia->query($sql);
  }
  function listPenggunaan($c)
  {
    $sql = "SELECT distinct cost_center_prefix,
				       using_category,
				       using_category_code
				from khs_bppbg_account_v2
				where cost_center_prefix ='$c'
				order by 3";
    $query = $this->oracle->query($sql);
    return $query->result_array();
    // return $sql;
  }
  public function getdescPenggunaan($untuk, $c)
  {
    $sql = "SELECT distinct cost_center_prefix,
    using_category,
    using_category_code
from khs_bppbg_account_v2
where cost_center_prefix = '$c'
AND using_category_code = '$untuk'
order by 3";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }
  function account($fungsi, $cost)
  {
    $sql = "select kba.account_number
            from khs_bppbg_account kba
            where kba.using_category_code = '$fungsi'
            and kba.cost_center = '$cost'";
    $query = $this->oracle->query($sql);
    return $query->row()->ACCOUNT_NUMBER;
  }
  public function insertBonIm($data)
  {
    $this->oracle->trans_start();
    $this->oracle->insert('IM_MASTER_BON', $data);
    $this->oracle->trans_complete();
    // $query = $this->oracle->insert('im_master_bon', $data);
  }
  public function selectdatabonmonseksi($seksi, $periode)
  {
    $sql = "SELECT DISTINCT ib.no_bon, ib.tanggal, ib.seksi_bon, ib.tujuan_gudang,
    ib.keterangan
FROM im_master_bon ib
WHERE SUBSTR (ib.no_bon, 1, 1) = '8'
$periode
AND ib.seksi_bon = '$seksi'
ORDER BY 1";

    $query = $this->oracle->query($sql);
    return $query->result_array();
  }
  public function selectdatabonmonppic($where)
  {
    $sql = "SELECT DISTINCT ib.no_bon, ib.tanggal, ib.seksi_bon, ib.tujuan_gudang, ib.keterangan 
    FROM im_master_bon ib 
    $where 
    ORDER BY 1 ";

    $query = $this->oracle->query($sql);
    return $query->result_array();
    // return $sql;
  }
  public function getDataBon($id)
  {
    $sql = "SELECT * FROM im_master_bon WHERE no_id = '$id' ORDER BY no_id";

    $query = $this->oracle->query($sql);
    return $query->result_array();
  }
  public function getDataBonbyNobon($no)
  {
    $sql = "SELECT * FROM im_master_bon WHERE no_bon = '$no'";

    $query = $this->oracle->query($sql);
    return $query->result_array();
  }
  public function getSieFromInputKebutuhan()
  {
    $sql = "select distinct created_by from csm.csm_standar_kebutuhan";

    $query = $this->db->query($sql);
    return $query->result_array();
  }
  public function getDataNeedbyseksi($seksi)
  {
    $sql = "select * from csm.csm_standar_kebutuhan $seksi";

    $query = $this->db->query($sql);
    return $query->result_array();
  }
  public function cekjabatan($noind)
  {
    $sql = "select kd_jabatan from hrd_khs.tpribadi where noind = '$noind'";

    $query = $this->personalia->query($sql);
    return $query->result_array();
  }
  public function detailbon($no_bon)
  {
    $sql = "SELECT ib.kode_barang, ib.nama_barang, ib.permintaan, ib.penyerahan, ib.satuan, ib.flag
    FROM im_master_bon ib
    WHERE ib.no_bon = '$no_bon'
    ORDER BY 2";

    $query = $this->oracle->query($sql);
    return $query->result_array();
  }
}
