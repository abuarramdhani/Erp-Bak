<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_receive extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();    
  }

  public function historyPO($datefrom,$dateto) {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT DISTINCT kpr.po_number, kpr.shipment_number, kpr.lppb_number,
                            kpr.input_date
                       FROM khs_po_receive kpr
                      WHERE (kpr.flag = 'D' OR kpr.flag = 'O')
                        AND kpr.input_date BETWEEN TO_DATE ('$datefrom"." 00:00:00',
                                                            'DD/MM/YYYY HH24:MI:SS'
                                                           )
                                               AND TO_DATE ('$dateto"." 23:59:59',
                                                            'DD/MM/YYYY HH24:MI:SS'
                                                           )
                   ORDER BY input_date ASC";
    $query = $oracle->query($sql);
    return $query->result_array();
  }


  public function detailPO($po,$sj) {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT DISTINCT kpr.po_number, kpr.shipment_number,
                            kpr.quantity_receipt qty_recipt, kpr.lppb_number,
                            kpr.inventory_item_id ID, msib.segment1 item,
                            msib.description, kpr.serial_status
                       FROM khs_po_receive kpr, mtl_system_items_b msib
                      WHERE kpr.organization_id = msib.organization_id
                        AND kpr.inventory_item_id = msib.inventory_item_id
            --              and kpr.FLAG = 'D'
                        AND kpr.shipment_number = '$sj'
                        AND kpr.po_number = '$po'";
    $query = $oracle->query($sql);
    return $query->result_array();
  }


  public function serial_number($po,$id,$sj) {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT DISTINCT krs.po_number, krs.inventory_item_id, krs.serial_number
                       FROM khs_receipt_serial krs, khs_po_receive kpr
                      WHERE krs.organization_id = kpr.organization_id
                        AND krs.inventory_item_id = kpr.inventory_item_id
                        AND krs.po_number = kpr.po_number
                        AND krs.po_header_id = kpr.po_header_id
                        AND krs.po_line_id = kpr.po_line_id
                        AND krs.po_number = '$po'
                        AND krs.shipment_number = '$sj'
                        AND krs.inventory_item_id = '$id'
                   ORDER BY serial_number";

    $query = $oracle->query($sql);
    return $query->result_array();
  }


  public function lppb_number($po,$sj) {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT DISTINCT rsh.receipt_num
                       FROM rcv_shipment_lines rsl,
                            rcv_shipment_headers rsh,
                            po_headers_all pha
                      WHERE pha.segment1 = '$po'
                        AND rsh.shipment_num = NVL ('$sj', rsh.shipment_num)
                        AND rsl.po_header_id = pha.po_header_id
                        AND rsl.shipment_header_id = rsh.shipment_header_id
                        AND rsh.creation_date IN (
                               SELECT rsh.creation_date
                                 FROM rcv_shipment_headers rsh, rcv_shipment_lines rsl
                                WHERE rsh.shipment_header_id = rsl.shipment_header_id
                                  AND rsl.po_header_id = pha.po_header_id)";
    $query = $oracle->query($sql);
    return $query->result_array();
  }


  public function getPO($nolppb) {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT DISTINCT pha.segment1 po, rsh.shipment_num sp
                       FROM rcv_shipment_lines rsl,
                            rcv_shipment_headers rsh,
                            po_headers_all pha
                      WHERE rsh.receipt_num = '$nolppb'
                        AND rsl.po_header_id = pha.po_header_id
                        AND rsl.shipment_header_id = rsh.shipment_header_id
                        AND rsh.creation_date IN (
                               SELECT rsh.creation_date
                                 FROM rcv_shipment_headers rsh, rcv_shipment_lines rsl
                                WHERE rsh.shipment_header_id = rsl.shipment_header_id
                                  AND rsl.po_header_id = pha.po_header_id)";
    $query = $oracle->query($sql);
    return $query->result_array();
  }


  public function getLocator($kodeitem) {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT DISTINCT mil.segment1 LOCATOR
                       FROM mtl_item_locations mil,
                            mtl_system_items_b msib,
                            khs_po_receive kpr
                      WHERE mil.organization_id = msib.organization_id
                        AND mil.inventory_item_id = msib.inventory_item_id
                        AND kpr.organization_id = mil.organization_id
                        AND msib.segment1 = '$kodeitem'";
    $query = $oracle->query($sql);
    return $query->result_array();
  }
 

  public function insertserial($lppbnumber,$iddelive,$qtydelive,$podelive,$commentsdelive,$serialnumdelive,$pilihloc) {
    $oracle = $this->load->database('oracle', true);
    $sql = "INSERT INTO khs_delivery_po_temp_serial (no_receipt, inventory_item_id, quantity, po_number, status,
             LOCATOR, comments, serial) VALUES ('$lppbnumber', $iddelive, '$qtydelive', '$podelive', 'DELIVER',
             '$pilihloc', '$commentsdelive', '$serialnumdelive')";
    $query = $oracle->query($sql);
  }


  public function insertnonserial($lppbnumber,$iddelive,$qtydelive,$podelive,$commentsdelive,$pilihloc) {
    $oracle = $this->load->database('oracle', true);
    $sql = "INSERT INTO khs_delivery_po_temp3 (no_receipt, inventory_item_id, quantity, po_number, status,
             LOCATOR, comments) VALUES ('$lppbnumber', $iddelive, '$qtydelive', '$podelive', 'DELIVER',
             '$pilihloc', '$commentsdelive')";
    $query = $oracle->query($sql);
  }


  public function runAPI($lppb,$po)
  {
      // $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
      $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');

      if (!$conn) {
           $e = oci_error();
          trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
      }
  
      $sql = "BEGIN APPS.khs_trial_deliver2 (:P_PARAM1,:P_PARAM2); END;";

      //Statement does not change
      $stmt = oci_parse($conn,$sql);                     
      oci_bind_by_name($stmt,':P_PARAM1',$lppb);
      oci_bind_by_name($stmt,':P_PARAM2',$po);

      // But BEFORE statement, Create your cursor
      $cursor = oci_new_cursor($conn);
      
      // Execute the statement as in your first try
      oci_execute($stmt);
      
      // and now, execute the cursor
      oci_execute($cursor);

    // $query = $oracle->query($sql);
    // echo "<pre>";print_r($sql);exit();
  }


  public function deletefromtemporaryserial()
  {
    $oracle = $this->load->database('oracle', true);
    $sql = "DELETE FROM KHS_DELIVERY_PO_TEMP_SERIAL";
    $query = $oracle->query($sql);
  }


  public function deletefromtemporary() {
    $oracle = $this->load->database('oracle', true);
    $sql = "DELETE FROM khs_delivery_po_temp3";
    $query = $oracle->query($sql);
  }
}