<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_car extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
        $this->personalia = $this->load->database('personalia', true);
    }
    function InsertDataCAR($id, $supplier, $po, $line, $item_code, $item_desc, $uom, $qty_po, $received_date_po, $shipment_date, $lppb, $act_receipt_date, $qty_receipt, $notes, $detail_rootcause, $rootcause_category, $car_type, $nc_scope, $created_by, $created_date, $no_car, $date_source)
    {
        $sql = "insert into khs_psup_car_vendor(
        CAR_ID,
        SUPPLIER_NAME,
        PO_NUMBER,
        LINE,
        ITEM_CODE,
        ITEM_DESCRIPTION,
        UOM,
        QTY_PO,
        RECEIVED_DATE_PO,
        SHIPMENT_DATE,
        LPPB_NUMBER,
        ACTUAL_RECEIPT_DATE,
        QTY_RECEIPT,
        NOTES,
        DETAIL_ROOTCAUSE,
        ROOTCAUSE_CATEGORI,
        CAR_TYPE,
        NC_SCOPE,
        CREATED_BY,
        CREATED_DATE,
        ACTIVE_FLAG,
        CAR_NUM,
        DATE_OF_DATA_SOURCE
    ) values (
        $id, 
        '$supplier',
        '$po', 
        $line,
        '$item_code',
        '$item_desc',
        '$uom', 
        $qty_po, 
        TO_TIMESTAMP('$received_date_po', 'DD-MM-YY'), 
        TO_TIMESTAMP('$shipment_date', 'DD-MM-YY'), 
        '$lppb', 
        TO_TIMESTAMP('$act_receipt_date', 'DD-MM-YY'), 
        $qty_receipt, 
        '$notes', 
        '$detail_rootcause', 
        '$rootcause_category', 
        '$car_type', 
        '$nc_scope', 
        '$created_by', 
        TO_TIMESTAMP('$created_date', 'YYYY-MM-DD HH24:MI:SS'),
        'B',
        '$no_car',
        TO_TIMESTAMP('$date_source', 'DD-MM-YY')
    )";
        $query = $this->oracle->query($sql);
        // return $query->result_array();
        return $sql;
    }
    public function getIdOr()
    {
        $sql = "SELECT max(CAR_ID) baris from khs_psup_car_vendor";

        $query = $this->oracle->query($sql);
        return $query->row()->BARIS + 1;
    }
    public function Listcar()
    {
        $sql = "SELECT DISTINCT car_num, active_flag,TO_CHAR (created_date, 'DD-MON-YYYY HH24:MI:SS') created_date,
        (CASE
            WHEN active_flag = 'B'
               THEN 10
            WHEN active_flag = 'E'
               THEN 20
            WHEN active_flag = 'A'
               THEN 30
            WHEN active_flag = 'F'
               THEN 40
            WHEN active_flag = 'R'
               THEN 50
            ELSE NULL
         END) num
   FROM khs_psup_car_vendor
ORDER BY num";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function Listcarr()
    {
        $sql = "SELECT DISTINCT car_num, active_flag,TO_CHAR (created_date, 'DD-MON-YYYY HH24:MI:SS') created_date,
        (CASE
            WHEN active_flag = 'E'
               THEN 10
            WHEN active_flag = 'B'
               THEN 20
            WHEN active_flag = 'A'
               THEN 30
            WHEN active_flag = 'F'
               THEN 40
            WHEN active_flag = 'R'
               THEN 50
            ELSE NULL
         END) num
   FROM khs_psup_car_vendor
ORDER BY num";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function ListsupplierbyNoCAR($no_car)
    {
        $sql = "Select distinct supplier_name,car_num from khs_psup_car_vendor where car_num = '$no_car' ORDER BY 1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function ListbyCAR($car)
    {
        $sql = "Select * from khs_psup_car_vendor where car_num = '$car' order by car_id";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function pembandingToInsert($supplier)
    {
        $sql = "SELECT   kpcv.*, TO_CHAR (kpcv.created_date, 'DD-MON-YYYY HH24:MI:SS') created_date
        FROM khs_psup_car_vendor kpcv
       WHERE kpcv.supplier_name = '$supplier'
    ORDER BY kpcv.created_date desc";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function nocar($car)
    {
        $sql = "Select car_num from khs_psup_car_vendor where car_num = '$car'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function GetApprover($term)
    {
        $sql = "SELECT * from hrd_khs.tpribadi where noind like '%$term%' or nama like '%$term%'";
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }
    public function SendReqAppr($no_car, $approver_car)
    {
        $sql = "update khs_psup_car_vendor set approve_to = '$approver_car' , active_flag = 'E' where car_num = '$no_car'";
        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function ListtoApprove($noind)
    {
        $sql = "Select distinct supplier_name, car_num from khs_psup_car_vendor where approve_to = '$noind' and active_flag = 'E' ORDER BY 1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function UpdateApprove($no_car, $approve_date)
    {
        $sql = "update khs_psup_car_vendor set approve_date = TO_TIMESTAMP('$approve_date', 'DD-MM-YY') where car_num = '$no_car'";
        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function UpdateFlag($flag, $no_car)
    {
        $sql = "update khs_psup_car_vendor set active_flag = '$flag' where car_num = '$no_car'";
        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function UpdateFlagReject($flag, $alasan, $no_car)
    {
        $sql = "update khs_psup_car_vendor set active_flag = '$flag', reject_reason='$alasan' where car_num = '$no_car'";
        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function dataToEdit($car)
    {
        $sql = "Select * from khs_psup_car_vendor where car_num = '$car'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function deleteCAR($no_car)
    {
        $sql = "delete from khs_psup_car_vendor where car_num = '$no_car'";
        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function deleteItem($id)
    {
        $sql = "delete from khs_psup_car_vendor where car_id = '$id'";
        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function getItem($term)
    {
        $sql = "SELECT  msib.segment1 KODE, msib.description DESKRIPSI
        FROM mtl_system_items_b msib
       WHERE msib.organization_id = 81
         AND msib.inventory_item_status_code = 'Active'
         AND msib.segment1 like '%$term%' or msib.description like '%$term%'
    ORDER BY 1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function getDescandUom($item)
    {
        $sql = "SELECT msib.description DESKRIPSI, msib.primary_uom_code SATUAN
        FROM mtl_system_items_b msib
       WHERE msib.organization_id = 81
         AND msib.inventory_item_status_code = 'Active'
         AND msib.segment1 = '$item'
    ORDER BY 1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function UpdateCAR($car_po_num, $car_line, $car_item_code, $car_item_desc, $car_uom, $car_qty_po, $car_receive_date, $car_ship_date, $car_lppb, $car_act_receive_date, $car_qty_receipt, $car_notes, $car_detail_rootcause, $car_rootcause_category, $car_id)
    {
        $sql = "update khs_psup_car_vendor 
        set po_number = '$car_po_num',
        line =$car_line,
        item_code = '$car_item_code',
        item_description = '$car_item_desc',
        uom = '$car_uom',
        qty_po = $car_qty_po,
        received_date_po = TO_TIMESTAMP('$car_receive_date', 'DD-MM-YY'),
        shipment_date = TO_TIMESTAMP('$car_ship_date', 'DD-MM-YY'),
        lppb_number= '$car_lppb',
        actual_receipt_date = TO_TIMESTAMP('$car_act_receive_date', 'DD-MM-YY'),
        qty_receipt = $car_qty_receipt,
        notes = '$car_notes',
        detail_rootcause = '$car_detail_rootcause',
        rootcause_categori = '$car_rootcause_category'
        where car_id = $car_id
        ";
        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function getPeriode($no_car)
    {
        $sql = "Select TO_CHAR (kpcv.date_of_data_source, 'Mon YYYY') created_date from khs_psup_car_vendor kpcv where kpcv.car_num = '$no_car'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function getAttendance($po)
    {
        $sql = "SELECT DISTINCT VENDOR_CONTACT FROM KHS.KHS_CETAK_PO_LANDSCAPE WHERE SEGMENT1 = '$po'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function getPO($no_car)
    {
        $sql = "SELECT DISTINCT PO_NUMBER FROM khs_psup_car_vendor WHERE CAR_NUM = '$no_car'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function getNamaApprover($noind)
    {
        $sql = "SELECT trim(nama) as nama from hrd_khs.tpribadi where noind = '$noind'";
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }
    public function getEmailVendor($po)
    {
        $sql = "SELECT DISTINCT EMAIL FROM KHS.KHS_CETAK_PO_LANDSCAPE WHERE SEGMENT1 = '$po'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    // public function HapusAll()
    // {
    //     $sql = "delete from khs_psup_car_vendor";
    //     $query = $this->oracle->query($sql);
    //     return $sql;
    // }
}
