<?php
class M_trackinglppb extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
	}

  public function detail($batch_detail_id, $section_id)
  {
    $oracle = $this->load->database('oracle',TRUE);
    $query = "SELECT DISTINCT rsh.receipt_num lppb_number, poh.segment1 po_number,
                pov.vendor_name vendor_name, rsh.creation_date tanggal_lppb, klbd.batch_number batch_number,
                klb.SOURCE SOURCE,
                rsh.creation_date create_date,
                MP.ORGANIZATION_CODE ORGANIZATION_CODE, 
                MP.ORGANIZATION_ID, 
                klb.lppb_info,
                kls.section_name,
                kls.section_id,
                klb.source,
                msib.segment1 gudang_code,
                pol.item_description gudang_description
           FROM rcv_shipment_headers rsh,
                rcv_shipment_lines rsl,
                po_vendors pov,
                po_headers_all poh,
                po_lines_all pol,
                po_line_locations_all pll,
                rcv_transactions rt,
                mtl_system_items_b msib,
                khs_lppb_batch_detail klbd,
                khs_lppb_batch klb,
                khs_lppb_section kls,
                MTL_PARAMETERS MP
          WHERE rsh.shipment_header_id = rsl.shipment_header_id
            AND rsh.shipment_header_id = rt.shipment_header_id
            AND rsl.shipment_line_id = rt.shipment_line_id
            AND pov.vendor_id = rt.vendor_id
            AND poh.po_header_id = rt.po_header_id
            AND pol.po_line_id = rt.po_line_id
            AND poh.po_header_id(+) = pol.po_header_id
            AND pov.vendor_id(+) = poh.vendor_id
            AND pol.po_line_id(+) = pll.po_line_id
            AND msib.inventory_item_id = pol.item_id
            AND msib.organization_id = 81
            AND rsh.receipt_num = klbd.lppb_number
            AND klb.batch_number = klbd.batch_number
            AND RSH.SHIP_TO_ORG_ID(+) = MP.ORGANIZATION_ID
            AND rt.transaction_id =
                           (SELECT MAX (rts.transaction_id)
                              FROM rcv_transactions rts
                             WHERE rt.shipment_header_id = rts.shipment_header_id
                               AND rts.po_line_id = pol.po_line_id
                               AND rts.transaction_type IN
                                      ('REJECT', 'DELIVER', 'ACCEPT', 'RECEIVE','TRANSFER', 'RETURN TO SUPPLIER'))
            AND klbd.batch_detail_id = '$batch_detail_id'
            AND klbd.io_id = mp.organization_id
            AND klbd.po_header_id = poh.po_header_id
            AND kls.section_id = '$section_id'";

    // echo "<pre>";
    // print_r($query);
    // exit();  
    $run = $oracle->query($query);
    return $run->result_array();
  }

  public function monitoringLppb($kriteria)
  {
    $oracle = $this->load->database('oracle',TRUE);
    $query = "SELECT DISTINCT 
              rsh.receipt_num                 lppb_number,
              kls.section_name,         
              kls.section_id,
              poh.segment1                    po_number,
              pov.vendor_name                 vendor_name, 
              MP.ORGANIZATION_CODE            ORGANIZATION_CODE, 
              MP.ORGANIZATION_ID,
              rt.transaction_type             status_lppb,
              klb.SOURCE,
              rsh.creation_date               create_date,
              klbd.status,
                  (SELECT MAX(a.action_date) 
                    FROM khs_lppb_action_detail_1 a 
                      WHERE a.status = 5 
                        AND a.batch_detail_id = klad.batch_detail_id) GUDANG_KIRIM,
                  (SELECT MAX(a.action_date) 
                    FROM khs_lppb_action_detail_1 a 
                      WHERE a.status = 6 
                        AND a.batch_detail_id = klad.batch_detail_id ) AKUNTANSI_TERIMA, 
              klbd.batch_number,
              klbd.batch_detail_id
FROM            rcv_shipment_headers rsh,
                khs_lppb_section kls,
                rcv_shipment_lines rsl,
                po_vendors pov,
                po_headers_all poh,
                po_lines_all pol,
                po_line_locations_all pll,
                rcv_transactions rt,
                MTL_PARAMETERS MP,
                khs_lppb_batch klb,
                khs_lppb_batch_detail klbd,
                khs_lppb_action_detail_1 klad
WHERE rsh.shipment_header_id = rsl.shipment_header_id
AND rsh.shipment_header_id = rt.shipment_header_id
AND rsl.shipment_line_id = rt.shipment_line_id
AND pov.vendor_id = rt.vendor_id
AND poh.po_header_id = rt.po_header_id
AND pol.po_line_id = rt.po_line_id
AND poh.po_header_id(+) = pol.po_header_id
AND pov.vendor_id(+) = poh.vendor_id
AND pol.po_line_id(+) = pll.po_line_id
AND RSH.SHIP_TO_ORG_ID(+) = MP.ORGANIZATION_ID
AND rt.transaction_id =
                 (SELECT MAX (rts.transaction_id)
                    FROM rcv_transactions rts
                       WHERE rt.shipment_header_id = rts.shipment_header_id
                          AND rts.po_line_id = pol.po_line_id
                          AND rts.transaction_type IN
                          ('REJECT', 'DELIVER', 'ACCEPT', 'RECEIVE','TRANSFER', 'RETURN TO SUPPLIER'))
AND rsh.receipt_num = klbd.lppb_number
AND klb.batch_number = klbd.batch_number
AND klbd.batch_detail_id = klad.batch_detail_id
AND klbd.io_id = MP.ORGANIZATION_ID
AND klbd.po_header_id = poh.po_header_id
                    $kriteria";
    // echo "<pre>";
    // print_r($query);
    // exit();             
    $run = $oracle->query($query);
    return $run->result_array();
  }

  public function getVendorName()
  {
    $oracle = $this->load->database('oracle',TRUE);
    $query = "SELECT DISTINCT pov.vendor_name vendor_name
           FROM rcv_shipment_headers rsh,
                rcv_shipment_lines rsl,
                po_vendors pov,
                po_headers_all poh,
                po_lines_all pol,
                po_line_locations_all pll,
                rcv_transactions rt,
                mtl_system_items_b msib,
                khs_lppb_batch_detail klbd,
                khs_lppb_batch klb
          WHERE rsh.shipment_header_id = rsl.shipment_header_id
            AND rsh.shipment_header_id = rt.shipment_header_id
            AND rsl.shipment_line_id = rt.shipment_line_id
            AND pov.vendor_id = rt.vendor_id
            AND poh.po_header_id = rt.po_header_id
            AND pol.po_line_id = rt.po_line_id
            AND poh.po_header_id(+) = pol.po_header_id
            AND pov.vendor_id(+) = poh.vendor_id
            AND pol.po_line_id(+) = pll.po_line_id
            AND msib.inventory_item_id = pol.item_id
            AND msib.organization_id = 81
            AND rsh.receipt_num = klbd.lppb_number
            AND klb.batch_number = klbd.batch_number";
    $run = $oracle->query($query);
    return $run->result_array();
  }

  public function getInventory(){
      $oracle = $this->load->database("oracle",true);
      $query = "SELECT 
                    MP.ORGANIZATION_CODE, 
                    MP.ORGANIZATION_ID
                  FROM 
                    MTL_PARAMETERS MP
                  ORDER BY
                    MP.ORGANIZATION_CODE";
      $run = $oracle->query($query);
      return $run->result_array();
    }
    public function getOpsiGudang()
    {
      $oracle = $this->load->database('oracle',true);
      $query="SELECT section_name, section_id FROM khs_lppb_section";
      $runQuery = $oracle->query($query);
      return $runQuery->result_array();
    }

    public function historylppb($batch_number){
      $oracle = $this->load->database("oracle",true);
      $query = "SELECT action_date, CASE
                WHEN STATUS = '0' THEN 'NEW/DRAF'
                WHEN STATUS = '1' THEN 'ADMIN EDIT'
                WHEN STATUS = '2' THEN 'CHECKING KASIE GUDANG'
                WHEN STATUS = '3' THEN 'KASIE GUDANG APPROVE'
                WHEN STATUS = '4' THEN 'KASIE GUDANG REJECT'
                WHEN STATUS = '5' THEN 'CHECKING AKUNTANSI'
                WHEN STATUS = '6' THEN 'AKUNTANSI APPROVE'
                WHEN STATUS = '7' THEN 'AKUNTANSI REJECT'
                ELSE 'Unknown'
                END AS status
                FROM khs_lppb_action_detail_1
                WHERE batch_number = '$batch_number' 
                ORDER BY ACTION_DATE DESC";
      $run = $oracle->query($query);
      return $run->result_array();
    }

    public function searchVendor($q)
    {
      $oracle = $this->load->database('oracle',true);

      $query = $oracle->query("SELECT 
      pv.VENDOR_NAME
      from
      po_vendors pv
      WHERE pv.VENDOR_NAME LIKE '%$q%'");
      return $query->result_array();
    }

}