<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// nggak disentuh total sama edwin
class M_ajax extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle',true);    
        $this->personalia = $this->load->database('personalia',true);
        $this->load->database();    
    }

    public function getComponent($term)
    {
        $sql = "SELECT mst.nama_barang,
                       mst.kode_barang,
                       mst.kode_proses
                FROM mo.mo_master_item mst
                WHERE (mst.nama_barang LIKE '%$term%'
                       OR mst.kode_barang LIKE '%$term%')
              ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getEmployee($term = FALSE)
    {
        if($term == FALSE){
          $where ="";
        }else{
          $where = "WHERE upper(msp.nama) LIKE upper('%$term%')";
        }

        $sql = "SELECT msp.nama ,
                       msp.no_induk,
                       msp.id
                from mo.mo_master_personal msp
               $where
                ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

     public function getScrap($term)
    {
        $sql = "SELECT mss.description ,
                       mss.scrap_code,
                       mss.id
                from mo.mo_master_scrap mss
                WHERE upper(mss.description) LIKE upper('%$term%')
                ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getDatePrintCode($date){
      $this->db->select("*");
      $this->db->from("mo.mo_selep");
      $this->db->where("selep_date",$date);

      $result = $this->db->get();

      return $result->result_array();

    }


    public function setQualityControl(
      $checking_date, $print_code, $checking_quantity, $scrap_quantity,
			$remaining_quantity, $component_code, $employee,
			$component_description, $selep_quantity, $shift, $check_qc, $id, $repair_quantity
    )
    {
      $sql = "INSERT INTO mo.mo_quality_control(checking_date, print_code, checking_quantity, scrap_quantity,
                                                remaining_quantity, component_code, employee,
                                                component_description, selep_quantity, shift, repair_qty, selep_id_c)
      VALUES ('$checking_date', '$print_code', '$checking_quantity', '$scrap_quantity',
              '$remaining_quantity', '$component_code', '$employee',
              '$component_description', '$selep_quantity', '$shift', '$repair_quantity', '$id'); --INPUT BIASA KE SELEP
              UPDATE mo.mo_selep SET qc_qty_not_ok = '$scrap_quantity', qc_qty_ok = '$checking_quantity', check_qc = '$check_qc', repair_qty = '$repair_quantity' WHERE selep_id = '$id';";
              //INPUT DI TABEL SELEP TENTANG CHECKING OKE BUAT XFIN
      $this->db->query($sql);
    }
    
    public function addScrap($id,$qty,$code,$desc)
    {
      $sql="insert into mo.mo_moulding_scrap (moulding_id, type_scrap, kode_scrap, quantity) values ('$id','$desc','$code','$qty')";
      $query = $this->db->query($sql);

    }

    public function addBongkar($id,$qty)
    {
      $sql="insert into mo.mo_moulding_bongkar (moulding_id, qty) values ('$id','$qty')";
      $query = $this->db->query($sql);

    }

    public function viewScrap($id)
    {
      $sql = "select * from mo.mo_moulding_scrap
              where moulding_id = $id";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    public function viewBongkar($id)
    {
      $sql = "select * from mo.mo_moulding_bongkar
              where moulding_id = $id";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function getJobData($jobCode=FALSE, $startDate=FALSE, $endDate=FALSE)
    {
      if ($startDate==FALSE || $endDate==FALSE) {
        $wDate = '';
      }else{
        $wDate = "AND TO_CHAR(wdj.DATE_RELEASED,'YYYY/MM/DD hh:mi:ss') BETWEEN '$startDate' AND '$endDate'";
      }

      if ($jobCode==FALSE) {
        $wJobCode = '';
      }else{
        $wJobCode = "AND we.WIP_ENTITY_NAME LIKE '%$jobCode%'";
      }
      $sql = "SELECT we.WIP_ENTITY_NAME ,
                     TO_CHAR(wdj.DATE_RELEASED,'DD/MM/YYYY hh:mi:ss') RELEASE ,
                     msib.SEGMENT1 ,
                     msib.DESCRIPTION
              FROM mtl_system_items_b msib ,
                   wip_entities we ,
                   wip_discrete_jobs wdj
              WHERE msib.ORGANIZATION_ID = 102
                AND we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
                AND wdj.PRIMARY_ITEM_ID = msib.INVENTORY_ITEM_ID
                AND wdj.ORGANIZATION_ID = msib.ORGANIZATION_ID
                $wDate $wJobCode
              ORDER BY wdj.DATE_RELEASED";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function setRejectComp($data)
    {
      $this->db->insert('mo.mo_replacement_component', $data);
      $id = $this->db->insert_id();
      
      $this->db->select('*');
      $this->db->from('mo.mo_replacement_component');
      $this->db->where('replacement_component_id', $id);
      $query = $this->db->get();
      return $query->result_array();
    }

    public function deleteRejectComp($id)
    {
      $this->db->where('replacement_component_id', $id);
      $this->db->delete('mo.mo_replacement_component');
    }

    public function getRejectComp($id)
    {
      $this->db->select('*');
      $this->db->from('mo.mo_replacement_component');
      $this->db->where('replacement_component_id', $id);
      $query = $this->db->get();
      return $query->result_array();
    }

     public function deleteItem($id)
    {
      $this->db->where('id', $id);
      $this->db->delete('mo.mo_master_item');
    }

     public function deleteScrap($id)
    {
      $this->db->where('id', $id);
      $this->db->delete('mo.mo_master_scrap');
    }

      public function deletePerson($id)
    {
      $this->db->where('id', $id);
      $this->db->delete('mo.mo_master_personal');
    }

    public function editItem($id)
    {
      $this->db->select('*');
      $this->db->from('mo.mo_master_item');
      $this->db->where('id', $id);
      $query = $this->db->get();
      return $query->result_array();
    }

    public function editScrap($id)
    {
      $this->db->select('*');
      $this->db->from('mo.mo_master_scrap');
      $this->db->where('id', $id);
      $query = $this->db->get();
      return $query->result_array();
    }


    public function editPerson($id)
    {
      $this->db->select('*');
      $this->db->from('mo.mo_master_personal');
      $this->db->where('id', $id);
      $query = $this->db->get();
      return $query->result_array();
    }

    public function getShift($tanggal)
    {
      $query = $this->oracle->query("
        select BCS.DESCRIPTION
        from BOM_SHIFT_TIMES bst,
        BOM_CALENDAR_SHIFTS bcs,
        bom_shift_dates bsd
        where bst.CALENDAR_CODE = bcs.CALENDAR_CODE
        and bst.SHIFT_NUM = bcs.SHIFT_NUM
        and bcs.CALENDAR_CODE='KHS_CAL'
        and bst.shift_num = bsd.shift_num
        and bst.calendar_code=bsd.calendar_code
        and bsd.SEQ_NUM is not null
        and bsd.shift_date=trunc(to_date('$tanggal','YYYY/MM/DD'))
        ORDER BY BCS.SHIFT_NUM asc
      ");
      return $query->result_array();
    }
    public function getAllShift($term)
    {
      $query = $this->oracle->query("
        select distinct BCS.DESCRIPTION
        from BOM_SHIFT_TIMES bst,
        BOM_CALENDAR_SHIFTS bcs,
        bom_shift_dates bsd
        where bst.CALENDAR_CODE = bcs.CALENDAR_CODE
        and bst.SHIFT_NUM = bcs.SHIFT_NUM
        and bcs.CALENDAR_CODE='KHS_CAL'
        and bst.shift_num = bsd.shift_num
        and bst.calendar_code=bsd.calendar_code
        and bsd.SEQ_NUM is not null
        and BCS.DESCRIPTION like '%$term%'
        ORDER BY BCS.DESCRIPTION asc
      ");
      return $query->result_array();
    }
}