<?php
class M_monitoringlppbadmin extends CI_Model {
  public function __construct()
  {
    $this->load->database();
    $this->load->library('encrypt');
  }
  public function checkSourceLogin($employee_code)
    {
        $oracle = $this->load->database('erp_db',true);
        $query = "select eea.employee_code, es.section_name
                    from er.er_employee_all eea, er.er_section es
                    where eea.section_code = es.section_code
                    and eea.employee_code = '$employee_code' ";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }
    public function  checkSectionName($id){
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT a.section_id, a.section_name, a.section_keyword 
                  FROM KHS_LPPB_SECTION a
                  WHERE a.section_id = '$id'";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }
    public function  checkGroupBatch($group_batch,$length){
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT COUNT(GROUP_batch) BATCH
                  FROM khs_lppb_batch
                  WHERE GROUP_BATCH = (CASE WHEN GROUP_BATCH LIKE '%$group_batch%' THEN SUBSTR(group_batch, 1, '$length') END)";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }
    public function  checkLengthBatch($group_batch){
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT length(GROUP_BATCH) length
                  FROM khs_lppb_batch
                  WHERE GROUP_BATCH = '$group_batch'";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }
    public function searchNumberLppb($lppb_numberFrom,$lppb_numberTo,$io,$queryStatus)
    {
        $oracle = $this->load->database('oracle',true);
        $query = " SELECT   aa.lppb_number,
                         REPLACE
                            ((RTRIM
                                 (XMLAGG (XMLELEMENT (e, TO_CHAR (aa.po_number) || '@')).EXTRACT
                                    ('//text()').getclobval
                                        (),
                                  '@'
                                 )
                             ),
                             '@',
                             ', '
                            ) po_number,
                             aa.vendor_name, aa.tanggal_lppb, aa.organization_code,
                             aa.organization_id, aa.status_lppb,
                         REPLACE
                            ((RTRIM
                                (XMLAGG (XMLELEMENT (e, TO_CHAR (aa.po_header_id) || '@')).EXTRACT
                                    ('//text()').getclobval
                                        (),
                                  '@'
                                 )
                             ),
                             '@',
                             ', '
                            ) po_header_id
                    FROM (SELECT DISTINCT rsh.receipt_num lppb_number, poh.segment1 po_number,
                                          pov.vendor_name vendor_name,
                                          rsh.creation_date tanggal_lppb,
                                          mp.organization_code, mp.organization_id,
                                          rt.transaction_type status_lppb, poh.po_header_id
                          FROM            rcv_shipment_headers rsh,
                                          rcv_shipment_lines rsl,
                                          po_vendors pov,
                                          po_headers_all poh,
                                          po_lines_all pol,
                                          po_line_locations_all pll,
                                          rcv_transactions rt,
                                          mtl_parameters mp
                                    WHERE rsh.shipment_header_id = rsl.shipment_header_id
                                      AND rsh.shipment_header_id = rt.shipment_header_id
                                      AND rsl.shipment_line_id = rt.shipment_line_id
                                      -- AND pov.vendor_id = rt.vendor_id
                                      -- AND poh.po_header_id = rt.po_header_id
                                      AND pol.po_line_id(+) = rt.po_line_id
                                      AND poh.po_header_id(+) = pol.po_header_id
                                      AND pov.vendor_id(+) = poh.vendor_id
                                      AND pol.po_line_id = pll.po_line_id(+)
                                      AND rsh.ship_to_org_id(+) = mp.organization_id
                                      --AND rt.transaction_id =
                                      --       (SELECT MAX (rts.transaction_id)
                                      --          FROM rcv_transactions rts
                                      --         WHERE rt.shipment_header_id =
                                      --                                  rts.shipment_header_id
                                      --           AND rts.po_line_id = pol.po_line_id)
                                      AND rsh.receipt_num BETWEEN $lppb_numberFrom AND $lppb_numberTo
                                      $io
                                      $queryStatus) aa
                GROUP BY aa.lppb_number,
                         aa.vendor_name,
                         aa.tanggal_lppb,
                         aa.organization_code,
                         aa.organization_id,
                         aa.status_lppb";

        $runQuery = $oracle->query($query);
        // echo"<pre>";echo $query; exit();
        $arr = $runQuery->result_array();
        foreach ($arr as $key => $value) {
          $arr[$key]['PO_NUMBER'] = $this->get_ora_blob_value($arr[$key]['PO_NUMBER']);
          $arr[$key]['PO_HEADER_ID'] = $this->get_ora_blob_value($arr[$key]['PO_HEADER_ID']);
        }
        return $arr;
}

    function get_ora_blob_value($value)
    {
        $size = $value->size();
        $result = $value->read($size);
        return ($result)?$result:NULL;
    }

    public function lppbBatchDetail($batch_number) //,$lppb_number
    {
        $oracle = $this->load->database('oracle',TRUE);
        $query ="SELECT DISTINCT 
                rsh.receipt_num lppb_number,
                a.status_date action_date,
                poh.segment1 po_number, 
                pov.vendor_name vendor_name, 
                rsh.creation_date tanggal_lppb, 
                MP.ORGANIZATION_CODE, 
                MP.ORGANIZATION_ID, 
                rt.transaction_type status_lppb,
                a.po_header_id, 
                a.batch_number, 
                a.batch_detail_id, 
                a.lppb_info, 
                a.status,  
                a.source, 
                a.group_batch 
                FROM rcv_shipment_headers rsh, 
                rcv_shipment_lines rsl, 
                po_vendors pov, 
                po_headers_all poh, 
                po_lines_all pol, 
                po_line_locations_all pll, 
                rcv_transactions rt, 
                MTL_PARAMETERS MP, 
                (SELECT klb.batch_number , 
                klbd.po_header_id , 
                klb.lppb_info , 
                klbd.batch_detail_id , 
                klbd.status , 
                klbd.status_date , 
                klb.source , 
                klb.group_batch , 
                klbd.lppb_number 
                FROM khs_lppb_batch klb, 
                khs_lppb_batch_detail klbd 
                WHERE klb.batch_number = klbd.batch_number 
                AND klb.batch_number = '$batch_number') a
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
                order by a.batch_detail_id";
// echo "<pre>";
// print_r($query);
// exit();
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

    public function getStatus() //toxic
    {
        $oracle = $this->load->database("oracle",true);
      $query = "SELECT DISTINCT 
                rt.transaction_type status_lppb 
                FROM rcv_transactions rt, po_headers_all poh 
                WHERE rt.po_header_id = poh.po_header_id";
      $run = $oracle->query($query);
      return $run->result_array();     
    }

    public function getOpsiGudang($section_name){
      $oracle = $this->load->database("oracle",true);
      $query = "SELECT * FROM KHS_LPPB_SECTION WHERE SECTION_ID NOT IN 18 AND SECTION_NAME = '$section_name' ";
      $run = $oracle->query($query);
      return $run->result_array();
    }
    public function getOpsiGudang2(){
      $oracle = $this->load->database("oracle",true);
      $query = "SELECT * FROM KHS_LPPB_SECTION WHERE SECTION_ID NOT IN 18 ";
      $run = $oracle->query($query);
      return $run->result_array();
    }
    public function getOpsiGudangById($id){
      $oracle = $this->load->database("oracle",true);
      $query = "SELECT * FROM KHS_LPPB_SECTION WHERE SECTION_ID NOT IN 18 AND SECTION_ID = '$id'";
      $run = $oracle->query($query);
      return $run->result_array();
    }
    public function saveLppbNumber($create_date,$lppb_info,$source,$group_batch,$id_gudang)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "INSERT INTO khs_lppb_batch
                      (create_date, 
                      lppb_info, 
                      source, 
                      group_batch, 
                      id_gudang) 
                  values 
                      (to_date('$create_date', 'DD/MM/YYYY HH24:MI:SS'), 
                      '$lppb_info', 
                      '$source', 
                      '$group_batch', 
                      '$id_gudang')";
        $oracle->query($query);
        $ssql = "select max(batch_number) batch_number from khs_lppb_batch";
        $data = $oracle->query($ssql);
        return $data->result_array();
    }
    public function saveLppbNumber2($batch_number,$lppb_number,$status_date, $io_id, $po_number,$po_header_id)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "INSERT INTO khs_lppb_batch_detail
                      (batch_number, 
                      lppb_number, 
                      status, 
                      status_date, 
                      io_id, 
                      po_number, 
                      po_header_id) 
              values ('$batch_number', 
                      '$lppb_number', 
                      '0', 
                      to_date('$status_date', 'DD/MM/YYYY HH24:MI:SS'), 
                      '$io_id', 
                      '$po_number', 
                      '$po_header_id')";
        $run = $oracle->query($query); 
    }
    public function batch_detail_id($batch_number)
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "select batch_detail_id from khs_lppb_batch_detail WHERE batch_number = '$batch_number' ORDER BY BATCH_DETAIL_ID";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

     public function getBdi($po_header_id)
     {
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT batch_detail_id FROM
                 (SELECT batch_detail_id FROM khs_lppb_batch_detail 
                 where po_header_id = $po_header_id
                ORDER BY batch_detail_id DESC)
                WHERE ROWNUM <= 1";
       //  echo "<pre>";
       // print_r($sql);
        $run = $oracle->query($sql);
        return $run->result_array();
       
     }

    public function limitBatchDetId($batch_number)
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT batch_detail_id FROM
                 (SELECT batch_detail_id FROM khs_lppb_batch_detail 
                 where batch_number = $batch_number
                ORDER BY batch_detail_id DESC)
                WHERE ROWNUM <= 1";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    
    public function saveLppbNumber3($batch_detail_id,$action_date)
    {
        $oracle = $this->load->database('oracle', true);
        $query = "INSERT INTO khs_lppb_action_detail_1
                    (batch_detail_id,
                    status,
                    action_date) 
            VALUES ('$batch_detail_id', 
                    '0', to_date('$action_date', 
                    'DD/MM/YYYY HH24:MI:SS'))";
        $oracle->query($query);
        
    }
    public function showKhsLppbBatch($id)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT a.batch_number, a.lppb_info, a.create_date, a.group_batch,
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
                            AND a.batch_number = d.batch_number)checking_kasie_gudang,
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
                   FROM khs_lppb_batch a,
                        khs_lppb_batch_detail b
                   WHERE a.batch_number = b.batch_number
                   AND b.status in (0,1)
                   AND a.id_gudang = '$id'
               ORDER BY a.batch_number DESC";
        // echo "<pre>";print_r($query);exit();
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
        // oci_commit($oracle);
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
        $query = "INSERT INTO khs_lppb_action_detail_1 (status, action_date, batch_detail_id)
                    VALUES ('2', to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'), '$batch_detail_id')";
        $run = $oracle->query($query);
    }
    public function getBatchDetailId($batch_number)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT b.BATCH_DETAIL_ID BATCH_DETAIL_ID, b.lppb_number
                    FROM KHS_LPPB_BATCH_DETAIL b,
                    KHS_LPPB_BATCH a
                    WHERE a.batch_number = '$batch_number'
                    AND a.batch_number = b.batch_number
                    ORDER BY b.lppb_number";
        $run = $oracle->query($query);
        return $run->result_array();
    }

    
    public function saveEditLppbNumber($batch_number)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT BATCH_NUMBER FROM KHS_LPPB_BATCH WHERE BATCH_NUMBER = '$batch_number'";
        // echo "<pre>";
        // print_r($query);
        $run = $oracle->query($query);        
        return $run->result_array();
    }

    public function saveEditLppbNumber2($batch_number,$lppb_number,$status_date, $io_id, $po_number,$po_header_id)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "INSERT INTO khs_lppb_batch_detail
                      (batch_number, lppb_number, status, status_date, io_id, po_number, po_header_id) values ('$batch_number', '$lppb_number', '1', to_date('$status_date', 'DD/MM/YYYY HH24:MI:SS'), '$io_id', '$po_number', '$po_header_id')";
       // echo "<pre>";
       // print_r($query);
        $run = $oracle->query($query); 
    }

   
    public function saveEditLppbNumber3($batch_detail_id,$action_date)
    {
        $oracle = $this->load->database('oracle', true);
        $query = "INSERT INTO khs_lppb_action_detail_1
                    (batch_detail_id, status, action_date) VALUES ('$batch_detail_id', '1', to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'))";
       //  echo "<pre>";
       // print_r($query);
        $oracle->query($query);
        
    }

    public function saveEditLppbNumber2Update($batch_number,$lppb_number,$status_date,$io_id,$po_number,$po_header_id)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "UPDATE khs_lppb_batch_detail 
                        SET batch_number = '$batch_number',
                            lppb_number = '$lppb_number',
                            status = '1',
                            status_date = to_date('$status_date', 'DD/MM/YYYY HH24:MI:SS'),
                            io_id = '$io_id',
                            po_number = '$po_number',
                            po_header_id = '$po_header_id'
                            where batch_number='$batch_number'
                            AND po_number = '$po_number'
                            AND po_header_id = '$po_header_id'
                            AND status = '0'";
       // echo "<pre>";
       // print_r($query);
        $oracle->query($query);
    }
    public function saveEditLppbNumber3Update($batch_detail_id,$action_date)
    {
        $oracle = $this->load->database('oracle', true);
        $query = "UPDATE khs_lppb_action_detail_1
                    set batch_detail_id='$batch_detail_id',
                    status='1',
                    action_date=to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS')
                    where batch_detail_id='$batch_detail_id' ";
       //  echo "<pre>";
       // print_r($query);            
        $oracle->query($query);
    }
  
    public function delBatchDetailId($batch_detail_id)
    {
        $oracle = $this->load->database('oracle',true);
        $query2 = "DELETE 
                    FROM khs_lppb_batch_detail
                    WHERE batch_detail_id = '$batch_detail_id' ";
        $run = $oracle->query($query2);
    }
    public function editableLppbNumber($lppb_number,$date,$batch_detail_id){
        $oracle = $this->load->database('oracle',true);
        $query = "UPDATE khs_lppb_batch_detail
                    SET lppb_number = '$lppb_number',
                    status = '1',
                    status_date = to_date('$status_date', 'DD/MM/YYYY HH24:MI:SS')
                    WHERE batch_detail_id = '$batch_detail_id'";
        $run = $oracle->query($query);
    }
    public function showRejectLppb(){
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT a.batch_number, a.lppb_info, a.create_date, a.group_batch,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail c
                           WHERE c.batch_number = a.batch_number
                           AND c.status in (4,7)) jumlah_lppb,
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
                   FROM khs_lppb_batch a,
                        khs_lppb_batch_detail b
                   WHERE a.batch_number = b.batch_number
                   AND (b.status = 4
                   OR b.status = 7)
               ORDER BY a.batch_number DESC";
        $run = $oracle->query($query);
        return $run->result_array();
    }
    public function showRejectDetail($batch_number,$lppb_number)
    {
        $oracle = $this->load->database('oracle',TRUE);
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
                        AND klbd.status in (4,7)
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
    public function finishLppbKasie()
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT a.batch_number, a.lppb_info, a.create_date, a.group_batch,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail c
                           WHERE c.batch_number = a.batch_number
                           AND c.status not in 7) jumlah_lppb,
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
                            AND a.batch_number = d.batch_number) checking_kasie_gudang,
                        (SELECT COUNT (lppb_number)
                           FROM khs_lppb_batch_detail e
                          WHERE e.status = 3
                            AND a.batch_number = e.batch_number)kasie_gudang_approved,
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
               AND c.status = 2
               AND b.status not in 7
               ORDER BY a.batch_number DESC";
        $run = $oracle->query($query);
        return $run->result_array();
    }
    public function finishdetail($batch_number){
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
                a.group_batch
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
                        FROM khs_lppb_batch klb, khs_lppb_batch_detail klbd, khs_lppb_action_detail_1 klad
                        WHERE klb.batch_number = klbd.batch_number
                        AND klbd.batch_detail_id = klad.batch_detail_id
                        AND klb.batch_number = '$batch_number'
                        AND klbd.status in (2,3,4,5,6)) a
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
                    ";
        $run = $oracle->query($query);
        return $run->result_array();
    }
    public function deleteAllRows($batch_number)
    {
        $oracle = $this->load->database('oracle',true);
        $query2 = "DELETE 
                    FROM khs_lppb_batch_detail
                    WHERE batch_number = '$batch_number' ";
        $runQuery2 = $oracle->query($query2);
        // oci_commit($oracle);
    }
    public function cekSessionGudang(){
        $oracle = $this->load->database('oracle',true);
        $query2 = "SELECT * FROM KHS_LPPB_BATCH WHERE BATCH_NUMBER IN (SELECT MAX(BATCH_NUMBER) FROM KHS_LPPB_BATCH) ";
        $run = $oracle->query($query2);
        return $run->result_array();
    }
    public function cekJumlahData($batch_number){ //,$status
        $oracle = $this->load->database('oracle',true);
        $query2 = "SELECT DISTINCT COUNT(klbd.batch_detail_id) jumlah_data
                    FROM khs_lppb_batch klb, khs_lppb_batch_detail klbd
                    WHERE klb.batch_number = klbd.batch_number
                    AND klbd.batch_number = '$batch_number'
                    ";
        $run = $oracle->query($query2);
        return $run->result_array();
    }
}