<?php defined('BASEPATH') or die('No direct script access allowed');
class M_monitoring extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle',true);
        $this->oracle_dev = $this->load->database('oracle',true);
    }

    public function getIO(){
        $sql="select distinct ood.ORGANIZATION_CODE from org_organization_definitions ood where ood.DISABLE_DATE is NULL";
        $query = $this->oracle_dev->query($sql);                             
        return $query->result_array();

    }
    public function getHeader($tgl_mulai, $tgl_akhir, $atr, $nopo, $atr2, $io)
	{
        $sql = "$atr2
                select distinct 
                    kbdo.NO_PO
                    ,kbdo.NO_SJ
                    ,ppf.FULL_NAME                                               buyer
                    ,(select mp.ORGANIZATION_CODE
                        from mtl_parameters mp
                        where mp.ORGANIZATION_ID = plla.SHIP_TO_ORGANIZATION_ID
                        )                                                                 org
                    ,kbdo.ITEM
                    ,kbdo.ITEM_ID
                    ,kbdo.ITEM_DESCRIPTION
                    ,pla.QUANTITY                                                 pesanan --> dari plla
                    ,nvl((select sum(kbdo.QTY) 
                            from khs_barang_datang_ok kbdo 
                            where kbdo.NO_PO = pha.SEGMENT1
                                and kbdo.ITEM = msib.SEGMENT1),'0')      diterima
                    ,hrl.LOCATION_CODE                                        lokasi
                    ,kbdo.TANGGAL_DATANG
                    ,null status                                            --> dari plla
                from khs_barang_datang_ok kbdo
                    ,per_people_f ppf
                    ,mtl_system_items_b msib
                    ,po_headers_all pha
                    ,po_lines_all pla
                    ,po_line_locations_all plla
                    ,po_distributions_all pda
                    ,hr_locations_all hrl
                    ,mtl_parameters mp
                where msib.INVENTORY_ITEM_ID = kbdo.ITEM_ID
                and msib.SEGMENT1 = kbdo.ITEM
                and ppf.PERSON_ID = msib.BUYER_ID
                --
                and pla.ITEM_ID = kbdo.ITEM_ID
                and pha.PO_HEADER_ID = pla.PO_HEADER_ID
                and pla.PO_LINE_ID = plla.PO_LINE_ID
                and plla.PO_HEADER_ID = pha.PO_HEADER_ID
                and plla.PO_LINE_ID = pla.PO_LINE_ID
                and pda.PO_HEADER_ID = pha.PO_HEADER_ID
                and pda.PO_LINE_ID = plla.PO_LINE_ID
                and pda.LINE_LOCATION_ID = plla.LINE_LOCATION_ID
                and pda.DELIVER_TO_LOCATION_ID = hrl.LOCATION_ID
                and plla.SHIP_TO_ORGANIZATION_ID = mp.ORGANIZATION_ID
                --
                and nvl(pla.CANCEL_FLAG,'N') = 'N'  -- parameter
                $io $nopo $atr
                --- paramtet
                and kbdo.TANGGAL_DATANG between TO_DATE('$tgl_mulai','YYYY-MM-DD') and TO_DATE('$tgl_akhir','YYYY-MM-DD')
                and pha.SEGMENT1 = kbdo.NO_PO
                order by 1";
        $query = $this->oracle_dev->query($sql);                             
        return $query->result_array();
        // return $sql;
    }

    public function getSearch($no_sj, $tgl_mulai, $tgl_akhir)
	{
		$sql= "SELECT tbh.no_po no_po, 
                tbh.no_sj no_sj, 
                tbh.created_date created_date, 
                tbh.note, 
                tbh.supplier, 
                tbl.item ,
                tbl.item_description, 
                tbl.qty, 
                tbl.subinv, 
                tbl.no_id
                from 
                khs_tampung_barang_header tbh, 
                khs_tampung_barang_line tbl
                where tbh.no_id = tbl.no_id
                and tbh.no_sj ='$no_sj'
                and (tbh.created_date BETWEEN '$tgl_mulai 00:01:00' AND '$tgl_akhir 23:59:59')
                order by no_sj asc";
        $query = $this->oracle_dev->query($sql);                             
        return $query->result_array();
        // return $sql;
    }

    // public function getIditem($indxitem)
	// {
    //     $sql= " SELECT DISTINCT msib.inventory_item_id, msib.segment1
    //     FROM mtl_system_items_b msib
    //    WHERE msib.segment1 = 'AAB1A0F031AY-0';
    //             ";
    //     $query = $this->db->query($sql);                             
    //     return $query->result_array();
    //     // return $sql;
    // }

    public function getStatusitem($idItem)
	{
        $sql= "SELECT distinct
                    rsh.RECEIPT_NUM 
                    ,rsh.CREATION_DATE                                                        receipt_date
                    ,pha.SEGMENT1                                                             po
                    ,rt.TRANSACTION_TYPE
                    ,rt.TRANSACTION_DATE
                    ,rsl.SHIPMENT_LINE_ID
                    ,rsl.ITEM_ID
                    ,rt.quantity																qty
                from rcv_shipment_headers rsh
                    ,rcv_shipment_lines rsl
                    ,rcv_transactions rt
                    --
                    ,po_headers_all pha
                    ,po_line_locations_all plla
                    ,po_requisition_headers_all prha
                    ,po_requisition_lines prl
                where rsh.SHIP_TO_ORG_ID = 102
                and rsh.SHIPMENT_HEADER_ID = rt.SHIPMENT_HEADER_ID
                and rsl.SHIPMENT_HEADER_ID = rsh.SHIPMENT_HEADER_ID
                and rsl.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
                --
                and pha.PO_HEADER_ID(+) = rt.PO_HEADER_ID
                and pha.PO_HEADER_ID = plla.PO_HEADER_ID
                and plla.PO_LINE_ID = rt.PO_LINE_ID
                and prl.REQUISITION_LINE_ID(+) = rt.REQUISITION_LINE_ID
                and prl.REQUISITION_HEADER_ID = prha.REQUISITION_HEADER_ID(+)
                --
                and nvl(prha.ORG_ID, -99) = nvl(PRL.ORG_ID, -99)
                and rsh.RECEIPT_NUM is not null
                -- parameter
                and pha.SEGMENT1 = nvl(19009783,pha.SEGMENT1)
                -- and rsl.ITEM_ID = '15581'
                --  and rt.TRANSACTION_DATE between nvl(:P_DATE_FROM,rt.TRANSACTION_DATE) and nvl(:P_DATE_TO,rt.TRANSACTION_DATE)
                --  and rsh.RECEIPT_NUM between nvl(:P_LPPB_FROM,rsh.RECEIPT_NUM) and nvl(:P_LPPB_TO,rsh.RECEIPT_NUM)
                order by rt.TRANSACTION_DATE
                ";
        $query = $this->oracle->query($sql);                             
        return $query->result_array();
        // return $sql;
    }
    public function getBody($recnum, $itemid, $numpo, $loc)
	{
		$sql= "SELECT distinct      rt.TRANSACTION_TYPE
                ,msib.SEGMENT1                              ITEM
                ,msib.DESCRIPTION                           DESKRIPSI
                ,pha.SEGMENT1                               PO
                ,rt.quantity     qty
                ,to_char(rt.TRANSACTION_DATE, 'MM MON YYYY HH24:MI:SS') as TGL
                ,rsl.SHIPMENT_LINE_ID
                ,rsl.ITEM_ID
                ,msib.INVENTORY_ITEM_ID
                ,rsh.RECEIPT_NUM RECEIPT
                ,to_char(rsh.CREATION_DATE  , 'MM MON YYYY HH24:MI:SS') as receipt_date
            from rcv_shipment_headers rsh
                ,rcv_shipment_lines rsl
                ,rcv_transactions rt
                --
                ,po_headers_all pha
                ,MTL_SYSTEM_ITEMS_B msib
                ,po_line_locations_all plla
                ,po_requisition_headers_all prha
                ,po_requisition_lines prl
            where rsh.SHIP_TO_ORG_ID = (SELECT msi.organization_id
                                          FROM mtl_secondary_inventories msi, mtl_parameters mp
                                         WHERE msi.organization_id = mp.organization_id
                                           AND msi.secondary_inventory_name = '$loc')
            and rsh.SHIPMENT_HEADER_ID = rt.SHIPMENT_HEADER_ID
            and rsl.SHIPMENT_HEADER_ID = rsh.SHIPMENT_HEADER_ID
            and rsl.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
            --
            and pha.PO_HEADER_ID(+) = rt.PO_HEADER_ID
            and pha.PO_HEADER_ID = plla.PO_HEADER_ID
            and plla.PO_LINE_ID = rt.PO_LINE_ID
            and prl.REQUISITION_LINE_ID(+) = rt.REQUISITION_LINE_ID
            and prl.REQUISITION_HEADER_ID = prha.REQUISITION_HEADER_ID(+)
            --
            and nvl(prha.ORG_ID, -99) = nvl(PRL.ORG_ID, -99)
            and rsh.RECEIPT_NUM = '$recnum'
            and rsl.ITEM_ID = $itemid -- item
            and msib.INVENTORY_ITEM_ID = $itemid -- ITEM
            -- parameter
            and pha.SEGMENT1 = $numpo
            order by to_char(rt.TRANSACTION_DATE, 'MM MON YYYY HH24:MI:SS') desc";
        $query = $this->oracle_dev->query($sql);                             
        return $query->result_array();
        // return $sql;
    }
    public function getBodyHeader($po,$invitemid)
	{
        $sql = "SELECT distinct  rt.TRANSACTION_TYPE
                    ,msib.SEGMENT1                              ITEM
                    ,msib.DESCRIPTION                           DESKRIPSI
                    ,pha.SEGMENT1                               PO
            --                ,plla.QUANTITY                              QTY_PO
                    ,rt.quantity                                QTY_SUB
                    ,(select distinct sum(rt1.QUANTITY) over (partition by rt1.TRANSACTION_TYPE
                                            ,rsh1.RECEIPT_NUM
                                            ,rsl1.ITEM_ID) cek
                    from rcv_transactions rt1
                        ,rcv_shipment_headers rsh1
                        ,rcv_shipment_lines rsl1
                    where rt1.SHIPMENT_LINE_ID = rsl1.SHIPMENT_LINE_ID
                    and rt1.SHIPMENT_HEADER_ID = rsh1.SHIPMENT_HEADER_ID
                    and rsh1.SHIPMENT_HEADER_ID = rsl1.SHIPMENT_HEADER_ID
                    and rsh1.RECEIPT_NUM = rsh.RECEIPT_NUM
                    and rsl1.ITEM_ID = rsl.ITEM_ID
                    and rt1.TRANSACTION_TYPE = rt.TRANSACTION_TYPE
                    ) QTY
                    ,rsl.QUANTITY_RECEIVED                     RECEIVED
                    ,to_char(rt.TRANSACTION_DATE, 'MM MON YYYY HH24:MI:SS') as TGL
                    ,rsl.SHIPMENT_LINE_ID
            --                ,rsl.ITEM_ID
                    ,msib.INVENTORY_ITEM_ID
                    ,rsh.RECEIPT_NUM RECEIPT
                    ,to_char(rt.TRANSACTION_DATE  , 'MM MON YYYY HH24:MI:SS') as transaction_date
                    ,(rsl.QUANTITY_RECEIVED - rt.quantity) IS_DONE
                from rcv_shipment_headers rsh
                    ,rcv_shipment_lines rsl
                    ,rcv_transactions rt
                    --
                    ,po_headers_all pha
                    ,MTL_SYSTEM_ITEMS_B msib
                    ,po_line_locations_all plla
                    ,po_requisition_headers_all prha
                    ,po_requisition_lines prl
                    ,khs_barang_datang_ok kbdo
                WHERE rsh.SHIPMENT_HEADER_ID = rt.SHIPMENT_HEADER_ID
                and rsl.SHIPMENT_HEADER_ID = rsh.SHIPMENT_HEADER_ID
                and rsl.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
                --
                and pha.PO_HEADER_ID(+) = rt.PO_HEADER_ID
                and pha.PO_HEADER_ID = plla.PO_HEADER_ID
                and plla.PO_LINE_ID = rt.PO_LINE_ID
                and prl.REQUISITION_LINE_ID(+) = rt.REQUISITION_LINE_ID
                and prl.REQUISITION_HEADER_ID = prha.REQUISITION_HEADER_ID(+)
                --
                and nvl(prha.ORG_ID, -99) = nvl(PRL.ORG_ID, -99)
                and rsl.ITEM_ID = '$invitemid' 
                and msib.INVENTORY_ITEM_ID = '$invitemid' 
                -- parameter
                and pha.SEGMENT1 = '$po'
                and pha.SEGMENT1 = kbdo.NO_PO
                and rsl.ITEM_ID = kbdo.ITEM_ID
                and rsh.SHIPMENT_NUM = kbdo.NO_SJ
                and rt.TRANSACTION_DATE = ( select max(rt1.TRANSACTION_DATE)
                                            from rcv_transactions rt1
                                            where rt1.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID )";
        $query = $this->oracle_dev->query($sql);                           
        return $query->result_array();
        // return $sql;
    }
    public function getBodyFromHeader($noidtabel,$nopo)
	{

        if (empty($nopo)) {
            $sql= "SELECT * from khs_tampung_barang_line tbl where tbl.no_id = '$noidtabel' and tbl.no_po is null";
        } else {
            $sql= "SELECT * from khs_tampung_barang_line tbl where tbl.no_id = '$noidtabel' and tbl.no_po='$nopo'";
        }
        $query = $this->oracle->query($sql);                             
        return $query->result_array();
        // return $sql;
    }
    public function getLastProcess($paramitemid,$paramnopo,$paramrecnum)
	{
		$sql= "SELECT distinct
                       rt.TRANSACTION_TYPE type
                from po_headers_all pha
                    ,rcv_shipment_headers rsh
                    ,rcv_shipment_lines rsl
                    ,rcv_transactions rt
                    ,mtl_system_items_b msib
                where rsh.SHIPMENT_HEADER_ID = rsl.SHIPMENT_HEADER_ID
                  and rsh.SHIPMENT_HEADER_ID = rt.SHIPMENT_HEADER_ID
                  and rsl.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
                  and rt.PO_HEADER_ID = pha.PO_HEADER_ID
                AND msib.INVENTORY_ITEM_ID = nvl('$paramitemid',msib.INVENTORY_ITEM_ID)
                  and rsh.RECEIPT_NUM = nvl('$paramrecnum',rsh.RECEIPT_NUM)
                  and pha.SEGMENT1 = nvl('$paramnopo',pha.SEGMENT1)
                  and rt.TRANSACTION_DATE = ( select max(rt1.TRANSACTION_DATE)
                                                from rcv_transactions rt1
                                               where rt1.SHIPMENT_HEADER_ID = rt.SHIPMENT_HEADER_ID )";
        $query = $this->oracle->query($sql);                             
        return $query->result_array();
        // return $sql;
    }
    public function getRecNum($paramitemid,$paramnopo)
	{
		$sql= "SELECT distinct rsh.RECEIPT_NUM
        from rcv_shipment_lines rsl
            ,rcv_shipment_headers rsh
            ,po_headers_all pha
            ,mtl_system_items_b msib
        where pha.SEGMENT1 = '$paramnopo'
          and msib.INVENTORY_ITEM_ID = '$paramitemid'
          and rsl.PO_HEADER_ID = pha.PO_HEADER_ID
          and rsl.SHIPMENT_HEADER_ID = rsh.SHIPMENT_HEADER_ID
          and rsh.CREATION_DATE = (select max(rsh.CREATION_DATE)
                                     from rcv_shipment_headers rsh
                                         ,rcv_shipment_lines rsl
                                    where rsh.SHIPMENT_HEADER_ID = rsl.SHIPMENT_HEADER_ID
                                      and rsl.PO_HEADER_ID = pha.PO_HEADER_ID)";
        $query = $this->oracle->query($sql);                             
        return $query->result_array();
        // return $sql;
    }

    public function getProcess($paramitemid,$paramnopo,$paramrecnum)
	{
		$sql= "SELECT distinct
                    rsh.RECEIPT_NUM 
                    ,rsh.CREATION_DATE                                                        receipt_date
                    ,to_char(TRANSACTION_DATE, 'hh24:mi:ss')                                  TRANSACTION_TIME
                    ,pha.SEGMENT1                                                             po
                    ,rt.TRANSACTION_TYPE
                    ,rt.TRANSACTION_DATE
                    ,rsl.SHIPMENT_LINE_ID
                    ,rsl.ITEM_ID
                    ,rt.quantity																qty
                from rcv_shipment_headers rsh
                    ,rcv_shipment_lines rsl
                    ,rcv_transactions rt
                    --
                    ,po_headers_all pha
                    ,po_line_locations_all plla
                    ,po_requisition_headers_all prha
                    ,po_requisition_lines prl
                where rsh.SHIP_TO_ORG_ID = 102
                and rsh.RECEIPT_NUM ='$paramrecnum'
                and rsh.SHIPMENT_HEADER_ID = rt.SHIPMENT_HEADER_ID
                and rsl.SHIPMENT_HEADER_ID = rsh.SHIPMENT_HEADER_ID
                and rsl.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
                --
                and pha.PO_HEADER_ID(+) = rt.PO_HEADER_ID
                and pha.PO_HEADER_ID = plla.PO_HEADER_ID
                and plla.PO_LINE_ID = rt.PO_LINE_ID
                and prl.REQUISITION_LINE_ID(+) = rt.REQUISITION_LINE_ID
                and prl.REQUISITION_HEADER_ID = prha.REQUISITION_HEADER_ID(+)
                --
                and nvl(prha.ORG_ID, -99) = nvl(PRL.ORG_ID, -99)
                and rsh.RECEIPT_NUM is not null
                -- parameter
                and pha.SEGMENT1 = nvl('$paramnopo',pha.SEGMENT1)
                and rsl.ITEM_ID = '$paramitemid'
                --  and rt.TRANSACTION_DATE between nvl(:P_DATE_FROM,rt.TRANSACTION_DATE) and nvl(:P_DATE_TO,rt.TRANSACTION_DATE)
                --  and rsh.RECEIPT_NUM between nvl(:P_LPPB_FROM,rsh.RECEIPT_NUM) and nvl(:P_LPPB_TO,rsh.RECEIPT_NUM)
                order by rt.TRANSACTION_DATE";
        $query = $this->oracle->query($sql);                             
        return $query->result_array();
        // return $sql;
    }
    
    public function get23($noidtabel)
	{
		$sql= "SELECT distinct
                rsh.RECEIPT_NUM 
                ,rsh.CREATION_DATE                                                        receipt_date
                ,pha.SEGMENT1                                                             po
                ,rt.TRANSACTION_TYPE
                ,rt.TRANSACTION_DATE
                ,rsl.SHIPMENT_LINE_ID
                ,rsl.ITEM_ID
                ,rt.quantity																qty
            from rcv_shipment_headers rsh
                ,rcv_shipment_lines rsl
                ,rcv_transactions rt
                --
                ,po_headers_all pha
                ,po_line_locations_all plla
                ,po_requisition_headers_all prha
                ,po_requisition_lines prl
            where rsh.SHIP_TO_ORG_ID = 102
            and rsh.SHIPMENT_HEADER_ID = rt.SHIPMENT_HEADER_ID
            and rsl.SHIPMENT_HEADER_ID = rsh.SHIPMENT_HEADER_ID
            and rsl.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
            --
            and pha.PO_HEADER_ID(+) = rt.PO_HEADER_ID
            and pha.PO_HEADER_ID = plla.PO_HEADER_ID
            and plla.PO_LINE_ID = rt.PO_LINE_ID
            and prl.REQUISITION_LINE_ID(+) = rt.REQUISITION_LINE_ID
            and prl.REQUISITION_HEADER_ID = prha.REQUISITION_HEADER_ID(+)
            --
            and nvl(prha.ORG_ID, -99) = nvl(PRL.ORG_ID, -99)
            and rsh.RECEIPT_NUM is not null
            -- parameter
            and pha.SEGMENT1 = nvl(19009783,pha.SEGMENT1)
            and rsl.ITEM_ID = '10322'
            --  and rt.TRANSACTION_DATE between nvl(:P_DATE_FROM,rt.TRANSACTION_DATE) and nvl(:P_DATE_TO,rt.TRANSACTION_DATE)
            --  and rsh.RECEIPT_NUM between nvl(:P_LPPB_FROM,rsh.RECEIPT_NUM) and nvl(:P_LPPB_TO,rsh.RECEIPT_NUM)
            order by rt.TRANSACTION_DATE;";
        $query = $this->oracle->query($sql);                             
        return $query->result_array();
        // return $sql;
    }
}

