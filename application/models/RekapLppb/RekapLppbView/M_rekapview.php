<?php defined('BASEPATH') or die('No direct script access allowed');
class M_rekapview extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle',true);
        // $this->db = $this->load->database('oracle',true);
    }

    public function getDataRekap($prmmonth){
		$sql= "SELECT rec.*, 
                        NVL (ww.kirim_qc, NULL ) kirim_qc, 
                        NVL (ww.terima_qc, NULL) terima_qc,
                        NVL (ww.kembali_qc, NULL) kembali_qc, 
                        NVL (ww.kirim_gudang, NULL) kirim_gudang,
                        NVL (ww.terima_gudang, NULL) terima_gudang
                FROM (SELECT DISTINCT rsh.receipt_num, rsh.creation_date receipt_date,
                                        msib.segment1 item, msib.description description,
                                        pha.segment1 po, rt.transaction_type,
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
                                    -- AND rsh.receipt_num = '286683' ini yg dinyalain
                --                    and pha.SEGMENT1 = '19018662'
                                and to_char(rsh.CREATION_DATE ,'MON-YYYY') = nvl('$prmmonth',to_char(rsh.CREATION_DATE , 'MON-YYYY'))
                --                    and msib.INVENTORY_ITEM_ID = ''
                --                    and rsh.RECEIPT_NUM between nvl(:P_LPPB_FROM,rsh.RECEIPT_NUM) and nvl(:P_LPPB_TO,rsh.RECEIPT_NUM)
                                    ----------------------------------------------
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
                                ORDER BY rsh.receipt_num, rt.transaction_date, msib.segment1) rec,
                        khs_waktu_lppb ww
                WHERE rec.receipt_num = ww.receipt_num(+) 
                AND rec.po = ww.po(+)
                AND rec.item_id = ww.ITEM_ID(+)
                ORDER BY rec.receipt_num , rec.receipt_date";
        $query = $this->oracle->query($sql);                             
        return $query->result_array();
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
                                ORDER BY rsh.receipt_num, rt.transaction_date, msib.segment1) rec";
        $query = $this->oracle->query($sql);                             
        return $query->result_array();
    }
}