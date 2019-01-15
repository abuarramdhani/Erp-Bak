<?php
class M_monitoringlppbakuntansi extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
	}

    public function monitoringLppbAkuntansi()
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT a.batch_number, a.create_date,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail c
                           WHERE c.batch_number = a.batch_number) jumlah_lppb,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail g
                          WHERE g.status = 5
                            AND a.batch_number = g.batch_number) checking_akuntansi,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail h
                          WHERE h.status = 6
                            AND a.batch_number = h.batch_number) akuntansi_approved,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail i
                          WHERE i.status = 7
                            AND a.batch_number = i.batch_number) akuntansi_reject
                   FROM khs_lppb_batch a, KHS_LPPB_BATCH_DETAIL B
               WHERE a.BATCH_NUMBER = b.BATCH_NUMBER
               AND B.STATUS IN (5,6,7)
               ORDER BY a.batch_number DESC";
        $run = $oracle->query($query);
        return $run->result_array();
    }

    public function detailLppbAkuntansi($id){
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT a.*,b.*,(SELECT C.REASON 
              FROM KHS_LPPB_ACTION_DETAIL C 
              WHERE C.STATUS = 4 
              AND C.REASON IS NOT NULL 
              AND C.BATCH_DETAIL_ID = B.BATCH_DETAIL_ID) REASON
                  FROM khs_lppb_batch_detail b, KHS_LPPB_ACTION_DETAIL c, khs_lppb_batch a
                  WHERE a.batch_number = b.batch_number
                  AND a.batch_number = '$id'";
        $run = $oracle->query($query);
        return $run->result_array();
    }

    public function searchNumberLppb($lppb_number)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT rsh.receipt_num lppb_number, poh.segment1 po_number,
                pov.vendor_name vendor_name, rsh.creation_date tanggal_lppb, pol.item_description nama_barang, msib.segment1 kode_barang
           FROM rcv_shipment_headers rsh,
                rcv_shipment_lines rsl,
                po_vendors pov,
                po_headers_all poh,
                po_lines_all pol,
                po_line_locations_all pll,
                rcv_transactions rt,
                mtl_system_items_b msib
          WHERE rsh.shipment_header_id = rsl.shipment_header_id
            AND rsh.shipment_header_id = rt.shipment_header_id
            AND rsl.shipment_line_id = rt.shipment_line_id
            AND pov.vendor_id = rt.vendor_id
            AND poh.po_header_id = rt.po_header_id
            AND pol.po_line_id = rt.po_line_id
            AND poh.po_header_id(+) = pol.po_header_id
            AND pov.vendor_id(+) = poh.vendor_id
            AND pol.po_line_id(+) = pll.po_line_id
            AND rsh.receipt_num = '$lppb_number'
            AND msib.inventory_item_id = pol.item_id
            AND msib.organization_id = 81";
        $run = $oracle->query($query);
        return $run->result_array();
    }

    public function saveProsesAkuntansi($status,$status_date,$batch_number,$batch_detail_id){
        $oracle = $this->load->database('oracle',true);
        $query = "UPDATE khs_lppb_batch_detail
                    SET status = '$status',
                    status_date = to_date('$status_date', 'DD/MM/YYYY HH24:MI:SS')
                    WHERE batch_number = '$batch_number'
                    AND batch_detail_id = '$batch_detail_id'";
        $run = $oracle->query($query);
    }

    public function saveProsesAkuntansi2($status,$reason,$action_date,$batch_detail_id){
        $oracle = $this->load->database('oracle',true);
        $query = "INSERT INTO khs_lppb_action_detail (status, reason, action_date, batch_detail_id)
                    VALUES ('$status', '$reason',to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'), '$batch_detail_id')";
        $run = $oracle->query($query);
    }

    public function inputAlasan($batch_detail_id,$reason)
    {
       $oracle = $this->load->database('oracle',true);
       $query2 = "UPDATE khs_lppb_action_detail 
                  SET reason = '$reason'
                 WHERE batch_detail_id = '$batch_detail_id'
                 AND status = '4' ";
        $runQuery2 = $oracle->query($query2);
        // oci_commit($oracle);
    }

    public function showReason($batch_detail_id)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT REASON
                    FROM KHS_LPPB_ACTION_DETAIL
                    WHERE BATCH_DETAIL_ID = '$batch_detail_id'
                    AND status = 4";
        $run = $oracle->query($query);
    }

    public function getBatchDetailId($batch_number)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT b.BATCH_DETAIL_ID BATCH_DETAIL_ID
                    FROM KHS_LPPB_BATCH_DETAIL b,
                    KHS_LPPB_BATCH a
                    WHERE a.BATCH_NUMBER = '$batch_number'
                    AND a.batch_number = b.batch_number";
        $run = $oracle->query($query);
        return $run->result_array();
    }


}