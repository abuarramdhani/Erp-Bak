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
        $query = "SELECT DISTINCT a.batch_number, a.create_date, a.group_batch,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail c
                           WHERE c.status = 5
                           AND c.batch_number = a.batch_number) jumlah_lppb,
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
               AND B.STATUS = 5
               AND (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail c
                           WHERE c.status = 5
                           AND c.batch_number = a.batch_number) <> 0
               ORDER BY a.batch_number DESC";
        $run = $oracle->query($query);
        return $run->result_array();
    }

    public function gudangLppbAkuntansi($id)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT a.batch_number, a.create_date, a.group_batch,
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
               AND B.STATUS = 5
               AND a.id_gudang = '$id'
               ORDER BY a.batch_number DESC";
        // echo "<pre>";
        // print_r($query);
        // exit();
        $run = $oracle->query($query);
        return $run->result_array();
    }

    public function getOpsiGudang(){
      $oracle = $this->load->database("oracle",true);
      $query = "SELECT * FROM KHS_LPPB_SECTION WHERE SECTION_ID NOT IN 18";
      $run = $oracle->query($query);
      return $run->result_array();
    }

    public function getOpsiGudangById($id){
      $oracle = $this->load->database("oracle",true);
      $query = "SELECT * FROM KHS_LPPB_SECTION WHERE SECTION_ID NOT IN 18 AND SECTION_ID = '$id'";
      $run = $oracle->query($query);
      return $run->result_array();
    }

    public function detailLppbAkuntansi($batch_number)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT poh.po_header_id,
                a.lppb_number,
                poh.segment1 po_number,
                pov.vendor_name vendor_name, rsh.creation_date tanggal_lppb,
                MP.ORGANIZATION_CODE, 
                MP.ORGANIZATION_ID,
                rt.transaction_type status_lppb,
                a.batch_number, 
                a.batch_detail_id, 
                a.lppb_info,
                a.status,
                a.status_date,
                a.source,
                a.group_batch,
                a.reason
                   FROM rcv_shipment_headers rsh,
                        rcv_shipment_lines rsl,
                        po_vendors pov,
                        po_headers_all poh,
                        po_lines_all pol,
                        rcv_transactions rt,
                        MTL_PARAMETERS MP,
                        (SELECT klb.batch_number
                        , klbd.po_header_id
                        , klb.lppb_info
                        , klbd.batch_detail_id
                        , klbd.status
                        , klbd.status_date
                        , klb.source
                        , klb.group_batch
                        , klbd.lppb_number
                        , klad.reason
                        FROM khs_lppb_batch klb, khs_lppb_batch_detail klbd, khs_lppb_action_detail_1 klad
                        WHERE klb.batch_number = klbd.batch_number
                        AND klbd.batch_detail_id = klad.batch_detail_id
                        AND klb.batch_number = '$batch_number'
                        AND klbd.status = 5) a
                  WHERE rsh.shipment_header_id = rsl.shipment_header_id
                    AND rsh.shipment_header_id = rt.shipment_header_id
                    AND rsl.shipment_line_id = rt.shipment_line_id
                    AND pov.vendor_id = rt.vendor_id
                    AND poh.po_header_id = rt.po_header_id
                    AND pol.po_line_id = rt.po_line_id
                    AND poh.po_header_id(+) = pol.po_header_id
                    AND pov.vendor_id(+) = poh.vendor_id
                    AND RSH.SHIP_TO_ORG_ID(+) = MP.ORGANIZATION_ID
                    AND rt.transaction_id =
                           (SELECT MAX (rts.transaction_id)
                              FROM rcv_transactions rts
                             WHERE rt.shipment_header_id = rts.shipment_header_id
                               AND rts.po_header_id = pol.po_header_id)
                    AND a.po_header_id = poh.po_header_id
                    AND a.lppb_number = rsh.receipt_num
                    ORDER BY a.batch_detail_id
                    ";
                  // echo "<pre>";
                  // print_r($query);
                  // exit();
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
        $query = "INSERT INTO khs_lppb_action_detail_1 (status, reason, action_date, batch_detail_id)
                    VALUES ('$status', '$reason',to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'), '$batch_detail_id')";
        $run = $oracle->query($query);
    }

    public function inputAlasan($batch_detail_id,$reason)
    {
       $oracle = $this->load->database('oracle',true);
       $query2 = "UPDATE khs_lppb_action_detail_1
                  SET reason = '$reason'
                 WHERE batch_detail_id = '$batch_detail_id'
                 AND status = '4' ";
        $runQuery2 = $oracle->query($query2);
    }

    public function showReason($batch_detail_id)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT REASON
                    FROM KHS_LPPB_ACTION_DETAIL_1
                    WHERE BATCH_DETAIL_ID = '$batch_detail_id'
                    AND status = 4";
        $run = $oracle->query($query);
    }

    public function getBatchDetailId($batch_number)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT a.batch_number batch_number, b.BATCH_DETAIL_ID BATCH_DETAIL_ID, b.lppb_number
                    FROM KHS_LPPB_BATCH_DETAIL b,
                    KHS_LPPB_BATCH a
                    WHERE a.BATCH_NUMBER = '$batch_number'
                    AND a.batch_number = b.batch_number
                    ORDER BY b.lppb_number";
        $run = $oracle->query($query);
        return $run->result_array();
    }

    public function finishLppbAkt()
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT a.batch_number, a.lppb_info, a.create_date, a.group_batch,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail c
                           WHERE c.batch_number = a.batch_number
                           AND c.status = 6) jumlah_lppb,
                         (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail b
                          WHERE b.status = 0
                            AND a.batch_number = b.batch_number) new_draf,
                            (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail c
                          WHERE c.status = 1
                            AND a.batch_number = c.batch_number) admin_edit,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail d
                          WHERE d.status = 2
                            AND a.batch_number = d.batch_number)
                                                                checking_kasie_gudang,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail e
                          WHERE e.status = 3
                            AND a.batch_number = e.batch_number)
                                                                kasie_gudang_approved,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail f
                          WHERE f.status = 4
                            AND a.batch_number = f.batch_number) kasie_gudang_reject,
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
                   FROM khs_lppb_batch a, KHS_LPPB_BATCH_DETAIL B, khs_lppb_action_detail_1 c
               WHERE a.BATCH_NUMBER = b.BATCH_NUMBER
               AND b.batch_detail_id = c.batch_detail_id
               AND c.status = 6
               ORDER BY a.batch_number DESC";
        $run = $oracle->query($query);
        return $run->result_array();
    }

    public function finishdetail($batch_number){
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT poh.po_header_id,
                a.lppb_number,
                poh.segment1 po_number,
                pov.vendor_name vendor_name, 
                rsh.creation_date tanggal_lppb,
                MP.ORGANIZATION_CODE, 
                MP.ORGANIZATION_ID,
                rt.transaction_type status_lppb,
                a.batch_number, 
                a.batch_detail_id, 
                a.lppb_info,
                a.status,
                a.status_date,
                a.source,
                a.group_batch,
                a.reason
                   FROM rcv_shipment_headers rsh,
                        rcv_shipment_lines rsl,
                        po_vendors pov,
                        po_headers_all poh,
                        po_lines_all pol,
                        rcv_transactions rt,
                        MTL_PARAMETERS MP,
                        (SELECT klb.batch_number
                        , klbd.po_header_id
                        , klb.lppb_info
                        , klbd.batch_detail_id
                        , klbd.status
                        , klbd.status_date
                        , klb.source
                        , klb.group_batch
                        , klbd.lppb_number
                        , klad.reason
                        FROM khs_lppb_batch klb, khs_lppb_batch_detail klbd, khs_lppb_action_detail_1 klad
                        WHERE klb.batch_number = klbd.batch_number
                        AND klbd.batch_detail_id = klad.batch_detail_id
                        AND klb.batch_number = '$batch_number'
                        AND klbd.status = 6) a
                  WHERE rsh.shipment_header_id = rsl.shipment_header_id
                    AND rsh.shipment_header_id = rt.shipment_header_id
                    AND rsl.shipment_line_id = rt.shipment_line_id
                    AND pov.vendor_id = rt.vendor_id
                    AND poh.po_header_id = rt.po_header_id
                    AND pol.po_line_id = rt.po_line_id
                    AND poh.po_header_id(+) = pol.po_header_id
                    AND pov.vendor_id(+) = poh.vendor_id
                    AND RSH.SHIP_TO_ORG_ID(+) = MP.ORGANIZATION_ID
                    AND rt.transaction_id =
                           (SELECT MAX (rts.transaction_id)
                              FROM rcv_transactions rts
                             WHERE rt.shipment_header_id = rts.shipment_header_id
                               AND rts.po_header_id = pol.po_header_id)
                    AND a.po_header_id = poh.po_header_id
                    AND a.lppb_number = rsh.receipt_num";
        //             echo "<pre>";
        //             print_r($query);
        //             exit();
        $run = $oracle->query($query);
        return $run->result_array();
    }

    public function rejectlppbakuntansi()
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT a.batch_number, a.lppb_info, a.create_date, a.group_batch,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail c
                           WHERE c.batch_number = a.batch_number
                           AND c.status = 7) jumlah_lppb,
                         (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail b
                          WHERE b.status = 0
                            AND a.batch_number = b.batch_number) new_draf,
                            (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail c
                          WHERE c.status = 1
                            AND a.batch_number = c.batch_number) admin_edit,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail d
                          WHERE d.status = 2
                            AND a.batch_number = d.batch_number)
                                                                checking_kasie_gudang,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail e
                          WHERE e.status = 3
                            AND a.batch_number = e.batch_number)
                                                                kasie_gudang_approved,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail f
                          WHERE f.status = 4
                            AND a.batch_number = f.batch_number) kasie_gudang_reject,
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
                   FROM khs_lppb_batch a, KHS_LPPB_BATCH_DETAIL B, khs_lppb_action_detail_1 c
               WHERE a.BATCH_NUMBER = b.BATCH_NUMBER
               AND b.batch_detail_id = c.batch_detail_id
               AND c.status = 7
               AND c.status not in 6
               ORDER BY a.batch_number DESC";
        $run = $oracle->query($query);
        return $run->result_array();
    }

    public function rejectdetailakuntansi($batch_number,$lppb_number){
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT rsh.receipt_num lppb_number,
                poh.segment1 po_number,
                pov.vendor_name vendor_name, rsh.creation_date tanggal_lppb,
                MP.ORGANIZATION_CODE, 
                MP.ORGANIZATION_ID,
                rt.transaction_type status_lppb,
                a.batch_number, 
                a.batch_detail_id, 
                a.lppb_info,
                a.status,
                a.status_date,
                a.source,
                a.group_batch,
                a.reason
                   FROM rcv_shipment_headers rsh,
                        rcv_shipment_lines rsl,
                        po_vendors pov,
                        po_headers_all poh,
                        po_lines_all pol,
                        po_line_locations_all pll,
                        rcv_transactions rt,
                        MTL_PARAMETERS MP,
                        (SELECT klb.batch_number
                        , klbd.po_header_id
                        , klb.lppb_info
                        , klbd.batch_detail_id
                        , klbd.status
                        , klbd.status_date
                        , klb.source
                        , klb.group_batch
                        , klbd.lppb_number
                        , klad.reason
                        FROM khs_lppb_batch klb, khs_lppb_batch_detail klbd, khs_lppb_action_detail_1 klad
                        WHERE klb.batch_number = klbd.batch_number
                        AND klbd.batch_detail_id = klad.batch_detail_id
                        AND klb.batch_number = '$batch_number'
                        AND klbd.status = 7
                        AND klad.reason is not null) a
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
                               AND rts.po_line_id = pol.po_line_id)
                    AND a.po_header_id = poh.po_header_id
                    AND a.lppb_number = rsh.receipt_num
                    $lppb_number";
        $run = $oracle->query($query);
        return $run->result_array();
    }

    public function cekJumlahData($batch_number,$status){
        $oracle = $this->load->database('oracle',true);
        $query2 = "SELECT DISTINCT COUNT(klbd.batch_detail_id) jumlah_data
                    FROM khs_lppb_batch klb, khs_lppb_batch_detail klbd
                    WHERE klb.batch_number = klbd.batch_number
                    AND klbd.batch_number = '$batch_number'
                    $status";
        $run = $oracle->query($query2);
        return $run->result_array();
    }

}