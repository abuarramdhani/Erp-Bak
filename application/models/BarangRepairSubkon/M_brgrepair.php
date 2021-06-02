<?php 
    class M_brgrepair extends CI_Model {
        public function __construct(){
            $this->load->database();
            $this->oracle = $this->load->database('oracle', true);
            // $this->oracle = $this->load->database('oracle_dev', true);
        }

        public function getSubkon($data){
            $sql = "SELECT   vendor_name
            FROM po_vendors
           WHERE vendor_name LIKE '%$data%'
        ORDER BY 1";
            $query = $this->oracle->query($sql);
            return $query->result_array();
        }

        public function getBrgRepair($status){
            $sql = "SELECT   rt.organization_id, rsh.receipt_num, msib.segment1 kode_barang,
            msib.description, rt.shipment_header_id, rt.shipment_line_id,
            rt.quantity jumlah_repair, pha.segment1 no_po,
            pov.vendor_name nama_subkon, pla.closed_code
       FROM rcv_shipment_headers rsh,
            rcv_shipment_lines rsl,
            rcv_transactions rt,
            po_vendors pov,
            mtl_system_items_b msib,
            po_headers_all pha,
            po_lines_all pla
      WHERE rsh.shipment_header_id = rsl.shipment_header_id
        AND rsh.shipment_header_id = rt.shipment_header_id
        AND rsl.shipment_line_id = rt.shipment_line_id
        AND rsh.vendor_id = pov.vendor_id
        AND msib.inventory_item_id = rsl.item_id
        AND msib.organization_id = rt.organization_id
        AND rt.po_header_id = pha.po_header_id
        AND rt.po_line_id = pla.po_line_id
        --pembatasan
        AND rt.transaction_type = 'RETURN TO VENDOR'
        AND pla.closed_code = '$status'
   ORDER BY 1, 2, 3";
            $query = $this->oracle->query($sql);
            return $query->result_array();
        }

        public function getBrgRepairSearch($periode, $subkon, $status){
            $periode == null? $periodesearch = '' : $periodesearch = "AND TO_CHAR (rt.creation_date, 'MM/YYYY') = '$periode'";
            $subkon == null? $subkonsearch = '' : $subkonsearch = "AND pov.vendor_name = '$subkon'";

            $sql = "SELECT   rt.organization_id, rsh.receipt_num, msib.segment1 kode_barang,
            msib.description, rt.shipment_header_id, rt.shipment_line_id,
            rt.quantity jumlah_repair, pha.segment1 no_po,
            pov.vendor_name nama_subkon, pla.closed_code
       FROM rcv_shipment_headers rsh,
            rcv_shipment_lines rsl,
            rcv_transactions rt,
            po_vendors pov,
            mtl_system_items_b msib,
            po_headers_all pha,
            po_lines_all pla
      WHERE rsh.shipment_header_id = rsl.shipment_header_id
        AND rsh.shipment_header_id = rt.shipment_header_id
        AND rsl.shipment_line_id = rt.shipment_line_id
        AND rsh.vendor_id = pov.vendor_id
        AND msib.inventory_item_id = rsl.item_id
        AND msib.organization_id = rt.organization_id
        AND rt.po_header_id = pha.po_header_id
        AND rt.po_line_id = pla.po_line_id
        --pembatasan
        AND rt.transaction_type = 'RETURN TO VENDOR'
        AND pla.closed_code = '$status'
        $periodesearch
        $subkonsearch
   ORDER BY 1, 2, 3";
            $query = $this->oracle->query($sql);
            return $query->result_array();
        }

    }
?>