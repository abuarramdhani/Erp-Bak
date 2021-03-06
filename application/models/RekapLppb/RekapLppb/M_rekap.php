<?php defined('BASEPATH') or die('No direct script access allowed');
class M_rekap extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle',true);
        // $this->db = $this->load->database('oracle',true);
    }

    public function getDataRekap($prmmonth, $io){
        $sql = "SELECT   rec.*,
                NVL (TO_CHAR (ww.kirim_qc, 'DD/MM/YYYY HH24:MI:SS'), NULL) kirim_qc,
                NVL (TO_CHAR (ww.terima_qc, 'DD/MM/YYYY HH24:MI:SS'), NULL) terima_qc,
                NVL (TO_CHAR (ww.kembali_qc, 'DD/MM/YYYY HH24:MI:SS'), NULL) kembali_qc,
                NVL (TO_CHAR (ww.kirim_gudang, 'DD/MM/YYYY HH24:MI:SS'), NULL) kirim_gudang,
                NVL (TO_CHAR (ww.terima_gudang, 'DD/MM/YYYY HH24:MI:SS'), NULL) terima_gudang
        FROM (SELECT DISTINCT rsh.ship_to_org_id, rsh.receipt_num, 
                                msib.segment1 item, msib.description description,
                                pha.segment1 po, 
                                rsh.creation_date receipt_date, 
                                rt.transaction_type, rt.transaction_date, 
                                rt.quantity, rsl.shipment_line_id, 
                                rsl.item_id,
                                (SELECT DISTINCT rt_deliver.transaction_date
                                            FROM rcv_transactions rt_deliver
                                            WHERE rt.shipment_header_id = rt_deliver.shipment_header_id
                                            AND rt.shipment_line_id = rt_deliver.shipment_line_id
                                            AND rt_deliver.transaction_type = 'DELIVER'
                                            AND ROWNUM = 1) deliver_date,
                                (SELECT MAX (rt_qc.transaction_date)
                                    FROM rcv_transactions rt_qc
                                WHERE rt.shipment_header_id = rt_qc.shipment_header_id
                                    AND rt.shipment_line_id = rt_qc.shipment_line_id
                                    AND rt_qc.transaction_type IN ('ACCEPT', 'REJECT')) tgl_qc
                            FROM rcv_shipment_headers rsh,
                                rcv_shipment_lines rsl,
                                mtl_system_items_b msib,
                                po_headers_all pha,
                                po_line_locations_all plla,
                                po_requisition_headers_all prha,
                                po_requisition_lines prl,
                                rcv_transactions rt
                        WHERE rsh.ship_to_org_id = '$io'
                            AND rsh.receipt_num IS NOT NULL
                            -- parameter---------------------------------
                            and to_char(rsh.CREATION_DATE ,'MON-YYYY') = nvl('$prmmonth',to_char(rsh.CREATION_DATE , 'MON-YYYY'))
                            ---------------------------------------------
                            AND rsh.shipment_header_id = rt.shipment_header_id
                            AND rsl.shipment_header_id = rsh.shipment_header_id
                            AND rsl.shipment_line_id = rt.shipment_line_id
                            AND rt.transaction_type = 'RECEIVE'
                            --
                            AND rsl.item_id = msib.inventory_item_id
                            AND rsh.ship_to_org_id = msib.organization_id
                            --
                            AND pha.po_header_id(+) = rt.po_header_id
                            AND pha.po_header_id = plla.po_header_id
                            AND plla.po_line_id = rt.po_line_id
                            AND prl.requisition_line_id(+) = rt.requisition_line_id
                            AND prl.requisition_header_id = prha.requisition_header_id(+)
                            AND NVL (prha.org_id, -99) = NVL (prl.org_id, -99)
                            AND (rsh.receipt_num NOT IN (
                                        SELECT rsh1.receipt_num
                                        FROM rcv_transactions rt1,
                                            rcv_shipment_headers rsh1,
                                            rcv_shipment_lines rsl1
                                        WHERE rsl1.shipment_header_id = rsh1.shipment_header_id
                                        AND rsh1.shipment_header_id = rt1.shipment_header_id
                                        AND rsl1.shipment_line_id = rt1.shipment_line_id
                                        --
                                        AND rt1.transaction_type LIKE 'RETURN%'
                                        AND rsh1.receipt_num = rsh.receipt_num)
                                OR rsh.receipt_num NOT IN (
                                        SELECT rsh1.receipt_num
                                        FROM rcv_transactions rt1,
                                            rcv_shipment_headers rsh1,
                                            rcv_shipment_lines rsl1
                                        WHERE rsl1.shipment_header_id = rsh1.shipment_header_id
                                        AND rsh1.shipment_header_id = rt1.shipment_header_id
                                        AND rsl1.shipment_line_id = rt1.shipment_line_id
                                        --
                                        AND rt1.transaction_type = 'CORRECT'
                                        AND (rt1.quantity * -1) <= rt.quantity
                                        AND rsh1.receipt_num = rsh.receipt_num
                                        AND rt1.shipment_header_id = rt.shipment_header_id
                                        AND rt1.shipment_line_id = rt.shipment_line_id)
                                )
                        ORDER BY rsh.receipt_num, rt.transaction_date, msib.segment1) rec,
                khs_waktu_lppb ww
        WHERE rec.receipt_num = ww.receipt_num(+) 
            --AND rec.po = ww.po(+)
            --AND rec.item_id = ww.ITEM_ID(+)
            AND rec.ship_to_org_id = ww.io(+)
        ORDER BY rec.receipt_num, rec.receipt_date";
        $query = $this->oracle->query($sql);                             
        return $query->result_array();
        // return $sql;
    }
    
    public function getSelisih($prmbulan){
		$sql= "SELECT distinct 
                    count(rec.receipt_date) over (partition by to_char(rec.receipt_date,'MON-YYYY')) receipt_date
                    ,count(rec.deliver_date) over (partition by to_char(rec.receipt_date,'MON-YYYY')) deliver_date
                    ,to_char(rec.receipt_date,'MON-YYYY') bulan
                    ,to_char(rec.receipt_date,'YYMM') bulan_urut
                    ,(count(rec.receipt_date) over (partition by to_char(rec.receipt_date,'MON-YYYY')) - count(rec.deliver_date) over (partition by to_char(rec.receipt_date,'MON-YYYY'))) selisih
                FROM (SELECT DISTINCT rsh.receipt_num, rsh.creation_date receipt_date,
                                        msib.segment1 item, msib.description description,
                                        pha.segment1 PO, rt.transaction_type,
                                        rt.transaction_date, rt.quantity,
                                        rsl.shipment_line_id, rsl.item_id,
                                        (SELECT distinct rt_deliver.transaction_date
                                            FROM rcv_transactions rt_deliver
                                        WHERE rt.shipment_header_id =
                                                    rt_deliver.shipment_header_id
                                            AND rt.shipment_line_id =
                                                                    rt_deliver.shipment_line_id
                                            AND rt_deliver.transaction_type = 'DELIVER'
                                            AND ROWNUM=1 )
                                                                                deliver_date
                                    FROM rcv_shipment_headers rsh,
                                        rcv_shipment_lines rsl,
                                        mtl_system_items_b msib,
                                        po_headers_all pha,
                                        po_line_locations_all plla,
                                        po_requisition_headers_all prha,
                                        po_requisition_lines prl,
                                        rcv_transactions rt
                                WHERE rsh.ship_to_org_id = 102
                                    AND rsh.receipt_num IS NOT NULL
                                    -- parameter---------------------------------
                --                    AND rsh.receipt_num = '286683'
                --                    and pha.SEGMENT1 = '19018662'
                --                    and rsh.CREATION_DATE between to_date('01'||'SEP-2019') and last_day (to_date('01'||'SEP-2019'))
                                    and to_char(rsh.CREATION_DATE ,'MON-YYYY') = nvl('$prmbulan',to_char(rsh.CREATION_DATE , 'MON-YYYY'))
                --                    and msib.INVENTORY_ITEM_ID = ''
                --                    and rsh.RECEIPT_NUM between nvl(:P_LPPB_FROM,rsh.RECEIPT_NUM) and nvl(:P_LPPB_TO,rsh.RECEIPT_NUM)
                                    AND rsh.shipment_header_id = rt.shipment_header_id
                                    AND rsl.shipment_header_id = rsh.shipment_header_id
                                    AND rsl.shipment_line_id = rt.shipment_line_id
                                    AND rt.transaction_type = 'RECEIVE'
                                    --
                                    AND rsl.item_id = msib.inventory_item_id
                                    AND rsh.ship_to_org_id = msib.organization_id
                                    --
                                    AND pha.po_header_id(+) = rt.po_header_id
                                    AND pha.po_header_id = plla.po_header_id
                                    AND plla.po_line_id = rt.po_line_id
                                    AND prl.requisition_line_id(+) = rt.requisition_line_id
                                    AND prl.requisition_header_id = prha.requisition_header_id(+)
                                    AND NVL (prha.org_id, -99) = NVL (prl.org_id, -99)
                                    AND rsh.RECEIPT_NUM not in (select rsh1.RECEIPT_NUM
                                                                  from rcv_transactions rt1
                                                                      ,rcv_shipment_headers rsh1
                                                                      ,rcv_shipment_lines rsl1
                                                                 where rsl1.SHIPMENT_HEADER_ID = rsh1.SHIPMENT_HEADER_ID
                                                                   and rsh1.SHIPMENT_HEADER_ID = rt1.SHIPMENT_HEADER_ID
                                                                   and rsl1.SHIPMENT_LINE_ID = rt1.SHIPMENT_LINE_ID
                                                                   --
                                                                   and (rt1.TRANSACTION_TYPE = 'CORRECT'
                                                                    or rt1.TRANSACTION_TYPE like 'RETURN%')
                                                                   and rsh1.RECEIPT_NUM = rsh.RECEIPT_NUM)                     
                                ORDER BY rsh.receipt_num, rt.transaction_date, msib.segment1) rec";
        $query = $this->oracle->query($sql);                             
        return $query->result_array();
    }
    
    public function cekdata($itemid,$recnum,$po,$io){
		$sql= "SELECT * from KHS_WAKTU_LPPB where item_id='$itemid' and receipt_num='$recnum' and po='$po' and io = '$io'";
        $query = $this->oracle->query($sql);                             
        return $query->result_array();
    }
    
    public function Updatedata($itemid,$recnum,$po,$queryupdate,$io){
		$sql= "UPDATE KHS_WAKTU_LPPB 
        $queryupdate
        WHERE PO = '$po'
        AND RECEIPT_NUM = '$recnum'
        AND ITEM_ID = '$itemid'
        AND IO = '$io'";
        $query = $this->oracle->query($sql);                             
        echo $sql;
    }
    public function Insertdata($itemid,$recnum,$po,$queryinsert,$ket,$io){
		$sql= "INSERT INTO KHS_WAKTU_LPPB (item_id, receipt_num, po, io , $ket)
        values ('$itemid','$recnum','$po','$io',$queryinsert)";
        $query = $this->oracle->query($sql);                             
        echo $sql;
    }
}