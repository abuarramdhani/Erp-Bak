<?php
class M_monitoringLppbAdmin extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
	}

    public function searchNumberLppb($lppb_number)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT rsh.receipt_num lppb_number, poh.segment1 po_number,
                pov.vendor_name vendor_name, rsh.creation_date tanggal_lppb
           FROM rcv_shipment_headers rsh,
                rcv_shipment_lines rsl,
                po_vendors pov,
                po_headers_all poh,
                po_lines_all pol,
                po_line_locations_all pll,
                rcv_transactions rt
          WHERE rsh.shipment_header_id = rsl.shipment_header_id
            AND rsh.shipment_header_id = rt.shipment_header_id
            AND rsl.shipment_line_id = rt.shipment_line_id
            AND pov.vendor_id = rt.vendor_id
            AND poh.po_header_id = rt.po_header_id
            AND pol.po_line_id = rt.po_line_id
            AND poh.po_header_id(+) = pol.po_header_id
            AND pov.vendor_id(+) = poh.vendor_id
            AND pol.po_line_id(+) = pll.po_line_id
            AND rsh.receipt_num = '$lppb_number'";
        $run = $oracle->query($query);
        return $run->result_array();
    }

    public function saveLppbNumber($create_date,$lppb_info)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "INSERT INTO khs_lppb_batch
                      (create_date, lppb_info) values (to_date('$create_date', 'DD/MM/YYYY HH24:MI:SS'), '$lppb_info')";
        $oracle->query($query);

        $ssql = "select batch_number from khs_lppb_batch where create_date = to_date('$create_date', 'DD/MM/YYYY HH24:MI:SS') and lppb_info = '$lppb_info' ";
        $data = $oracle->query($ssql);

        return $data->result_array();

        // print_r($aa);exit();
        // return  $oracle->insert_id();
    }

    public function saveLppbNumber2($batch_number,$lppb_number,$status_date)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "INSERT INTO khs_lppb_batch_detail
                      (batch_number, lppb_number, status, status_date) values ('$batch_number', '$lppb_number', '0', to_date('$status_date', 'DD/MM/YYYY HH24:MI:SS'))";
        $oracle->query($query); 

        $sql = "select batch_detail_id from khs_lppb_batch_detail where batch_number='$batch_number' and lppb_number ='$lppb_number' and status=0 order by batch_detail_id desc ";
        $run = $oracle->query($sql);
        return $run->result_array();

        // print_r($hasil);exit(); 
        // return  $oracle->insert_id();
    }

    public function saveLppbNumber3($batch_detail_id,$action_date)
    {
        $oracle = $this->load->database('oracle', true);
        $query = "INSERT INTO khs_lppb_action_detail
                    (batch_detail_id,status,action_date) VALUES ('$batch_detail_id', '0', to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'))";
        $oracle->query($query);
    }

    public function showKhsLppbBatch()
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT a.batch_number, a.lppb_info, a.create_date,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail c
                           WHERE c.batch_number = a.batch_number) jumlah_lppb,
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
                   FROM khs_lppb_batch a
               ORDER BY a.batch_number DESC";
        $run = $oracle->query($query);
        return $run->result_array();
    }

    public function showLppbNumberDetail($id){
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT *
                  FROM khs_lppb_batch a, khs_lppb_batch_detail b
                  WHERE a.batch_number = b.batch_number
                  AND a.batch_number = '$id'";
        $run = $oracle->query($query);
        return $run->result_array();
    }

    public function deleteNumberBatch($batch_number)
    {
        $oracle = $this->load->database('oracle',true);
        $query1 = "DELETE 
                    FROM khs_lppb_batch
                    WHERE batch_number = '$batch_number' ";
        $runQuery1 = $oracle->query($query1);

        $query2 = "DELETE 
                    FROM khs_lppb_batch_detail
                    WHERE batch_number = '$batch_number' ";
        $runQuery2 = $oracle->query($query2);
        oci_commit($oracle);
    }

    public function submitToKasieGudang($status_date,$batch_number){
        $oracle = $this->load->database('oracle',true);
        $query = "UPDATE khs_lppb_batch_detail
                    SET status = '2',
                    status_date = to_date('$status_date', 'DD/MM/YYYY HH24:MI:SS')
                    WHERE batch_number = '$batch_number'";
        $run = $oracle->query($query);
    }

    public function submitToKasieGudang2($action_date,$batch_detail_id){
        $oracle = $this->load->database('oracle',true);
        $query = "INSERT INTO khs_lppb_action_detail (status, action_date, batch_detail_id)
                    VALUES ('2', to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'), '$batch_detail_id')";
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

    public function saveEditLppbNumber($lppb_info)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "INSERT INTO khs_lppb_batch
                      (lppb_info) values ('$lppb_info')";
        $oracle->query($query);

        $ssql = "select batch_number from khs_lppb_batch where create_date = to_date('$create_date', 'DD/MM/YYYY HH24:MI:SS') and lppb_info = '$lppb_info' ";
        $data = $oracle->query($ssql);

        return $data->result_array();
    }

    public function saveEditLppbNumber2($batch_number,$lppb_number,$status_date)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "INSERT INTO khs_lppb_batch_detail
                      (batch_number, lppb_number, status, status_date) values ('$batch_number', '$lppb_number', '1', to_date('$status_date', 'DD/MM/YYYY HH24:MI:SS'))";
        $oracle->query($query); 

        $sql = "select batch_detail_id from khs_lppb_batch_detail where batch_number='$batch_number' and lppb_number ='$lppb_number' and status=1 order by batch_detail_id desc ";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function saveEditLppbNumber3($batch_detail_id,$action_date)
    {
        $oracle = $this->load->database('oracle', true);
        $query = "INSERT INTO khs_lppb_action_detail
                    (batch_detail_id,status,action_date) VALUES ('$batch_detail_id', '1', to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'))";
        $oracle->query($query);
    }

    public function delBatchDetailId($batch_detail_id)
    {
        $conn = $this->load->database('oracle',true);
        $query2 = "DELETE 
                    FROM khs_lppb_batch_detail
                    WHERE batch_detail_id = '$batch_detail_id' ";
        $run = $conn->query($query2);
        oci_commit($conn);
    }

}