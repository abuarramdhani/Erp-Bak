<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_listekatalog extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        
		$this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function getDOList()
    {
        $sql = "SELECT DISTINCT wdd.batch_id, wdd.source_header_number, kad.status, wdd.SOURCE_HEADER_TYPE_NAME
        FROM wsh_delivery_details wdd, khs_approval_do kad
        WHERE TO_CHAR (wdd.batch_id) = kad.no_do(+)
         AND wdd.org_id = 82
         AND wdd.SOURCE_HEADER_TYPE_NAME like '%Tender%'
         AND wdd.released_status = 'S'
         AND kad.status IS NULL
        ORDER BY source_header_number";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getSPBList()
    {
        $sql = "SELECT 
                    mtrh.request_number no_spb, 
                    mtrh.from_subinventory_code 
                    from_subinv,
                    mtrh.to_subinventory_code to_subinv
                FROM mtl_txn_request_headers mtrh, mtl_txn_request_lines mtrl, fnd_user fu
                WHERE mtrh.header_id = mtrl.header_id
                    AND mtrh.CREATED_BY = fu.USER_ID
                    AND fu.USER_NAME = 'AA PMP4 TR 02'
                    AND mtrl.transaction_type_id IN (327, 64)
                    AND mtrl.line_status IN (3, 7)
                    AND mtrh.header_status IN (3, 7)
                    AND NVL (mtrl.quantity_detailed, 0) = 0
                    AND NVL (mtrl.quantity_delivered, 0) = 0
                    AND mtrh.from_subinventory_code = 'FG-TKS'
                GROUP BY mtrh.request_number,
                        mtrh.from_subinventory_code,
                        mtrh.to_subinventory_code";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getSPBListB0445()
    {
        $sql = "SELECT mtrh.request_number no_spb, mtrh.from_subinventory_code from_subinv, mtrh.to_subinventory_code to_subinv, kad.TANGGAL_PERMINTAAN_KIRIM    
        FROM mtl_txn_request_headers mtrh, mtl_txn_request_lines mtrl, fnd_user fu, khs_approval_do kad
       WHERE mtrh.header_id = mtrl.header_id
         AND mtrh.CREATED_BY = fu.USER_ID
         AND fu.USER_NAME = 'AA PMP4 TR 02'
         AND mtrh.REQUEST_NUMBER = kad.NO_DO(+)
         AND mtrl.transaction_type_id IN (327, 64)
         AND mtrl.line_status IN (3, 7)
         AND mtrh.header_status IN (3, 7)
         AND NVL (mtrl.quantity_detailed, 0) = 0
         AND NVL (mtrl.quantity_delivered, 0) = 0
         AND NOT EXISTS (
                    select prla.attribute1, prla.REQUISITION_LINE_ID 
                    from po_requisition_lines_all prla 
                    where 
                    prla.ITEM_ID IN (25156, 1479004, 1101174) 
                    and mtrh.request_number in (prla.ATTRIBUTE1, prla.ATTRIBUTE2, prla.ATTRIBUTE3, prla.ATTRIBUTE4, prla.ATTRIBUTE5, prla.ATTRIBUTE6, prla.ATTRIBUTE12, prla.ATTRIBUTE13)
                )
    GROUP BY mtrh.request_number,
             mtrh.from_subinventory_code,
             mtrh.to_subinventory_code,
             kad.TANGGAL_PERMINTAAN_KIRIM";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getDOListB0445()
    {
        $sql = "SELECT DISTINCT wdd.batch_id, wdd.source_header_number, kad.status, wdd.SOURCE_HEADER_TYPE_NAME, kad.TANGGAL_PERMINTAAN_KIRIM
            FROM wsh_delivery_details wdd, khs_approval_do kad
        WHERE TO_CHAR (wdd.batch_id) = kad.no_do
            AND wdd.org_id = 82
            AND wdd.SOURCE_HEADER_TYPE_NAME like '%Tender%'
            AND wdd.released_status = 'S'
            AND kad.status = 'Approved'
            AND NOT EXISTS (
                select prla.attribute1, prla.REQUISITION_LINE_ID 
                from po_requisition_lines_all prla 
                where 
                prla.ITEM_ID IN (25156, 1479004, 1101174) 
                and kad.NO_DO in (prla.ATTRIBUTE1, prla.ATTRIBUTE2, prla.ATTRIBUTE3, prla.ATTRIBUTE4, prla.ATTRIBUTE5, prla.ATTRIBUTE6, prla.ATTRIBUTE12, prla.ATTRIBUTE13)
            )
        ORDER BY source_header_number";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
}