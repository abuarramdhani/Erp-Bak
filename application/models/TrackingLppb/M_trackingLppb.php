<?php
class M_trackingLppb extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
	}

  public function searchKriteria()
  {
    $oracle = $this->load->database('oracle',TRUE);
    $query = "SELECT DISTINCT rsh.receipt_num lppb_number, poh.segment1 po_number,
                pov.vendor_name vendor_name, rsh.creation_date tanggal_lppb
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

  public function monitoringLppb($kriteria)
  {
    $oracle = $this->load->database('oracle',TRUE);
    $query = "SELECT DISTINCT rsh.receipt_num lppb_number, poh.segment1 po_number,
                pov.vendor_name vendor_name, rsh.creation_date tanggal_lppb, pol.item_description nama_barang, msib.segment1 kode_barang, klb.create_date gudang_input, (SELECT max(a.action_date) FROM khs_lppb_action_detail a WHERE a.batch_detail_id = klbd.batch_detail_id
                AND a.status = 3) gudang_kirim, (SELECT MAX(b.action_date) FROM khs_lppb_action_detail b WHERE b.batch_detail_id = klbd.batch_detail_id
                AND b.status = 6) akuntansi_terima
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
            AND klb.batch_number = klbd.batch_number
            $kriteria";
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

}