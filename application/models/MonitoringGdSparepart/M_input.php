<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_input extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getInput($atr) {
        $oracle = $this->load->database('oracle', true);
        $sql = "
                select mmt.SHIPMENT_NUMBER  no_interorg
                ,count(mmt.INVENTORY_ITEM_ID) over (partition by mmt.SHIPMENT_NUMBER)     jumlah
                ,mmt.TRANSACTION_DATE
                ,msib.SEGMENT1                                           item
                ,msib.DESCRIPTION
                ,mmt.TRANSACTION_QUANTITY*-1				qty
                ,mmt2.QTY_RECEIPT
                ,mmt.TRANSACTION_UOM                              uom
                ,decode(mmt.TRANSACTION_TYPE_ID,12,'Barang Masuk',21,'Barang Keluar','-') type
                ,coalesce(
                        (select mtt.TRANSACTION_TYPE_NAME
                            from mtl_transaction_types mtt
                            where mtt.TRANSACTION_TYPE_ID = mmt2.TYPE_ID)
                        ,(select mtt.TRANSACTION_TYPE_NAME
                            from mtl_transaction_types mtt
                            where mtt.TRANSACTION_TYPE_ID = mmt.TRANSACTION_TYPE_ID)      
                            )                                                         type_name
        from mtl_material_transactions mmt
            ,mtl_system_items_b msib
            ,(select mmt2.TRANSACTION_QUANTITY qty_receipt
                    ,mmt2.ORGANIZATION_ID org
                    ,mmt2.SHIPMENT_NUMBER shipment_num
                    ,mmt2.INVENTORY_ITEM_ID item_id
                    ,mmt2.TRANSACTION_TYPE_ID type_id
                from mtl_material_transactions mmt2
                where mmt2.TRANSACTION_TYPE_ID = 12 -- Intransit Receipt
                ) mmt2
        where msib.INVENTORY_ITEM_ID = mmt.INVENTORY_ITEM_ID
            and msib.ORGANIZATION_ID = mmt.ORGANIZATION_ID
            $atr
            and mmt.TRANSACTION_TYPE_ID = 21 -- Intransit Shipment
            --
            and mmt2.ORG(+) = mmt.TRANSFER_ORGANIZATION_ID
            and mmt2.SHIPMENT_NUM(+) = mmt.SHIPMENT_NUMBER
            and mmt2.ITEM_ID(+) = mmt.INVENTORY_ITEM_ID
            and mmt.ORGANIZATION_ID in (102,225) -- YSP
            and mmt.transfer_subinventory = 'SP-YSP'
        -- order by item
        ";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }

    public function getInputKIB($atr) {
        $oracle = $this->load->database('oracle', true);
        $sql = "
                select kk.KIBCODE no_interorg
                        ,msib.SEGMENT1 item
                        ,msib.DESCRIPTION
                        ,msib.PRIMARY_UOM_CODE uom
                        ,wdj.QUANTITY_COMPLETED qty
                        ,kk.QTY_KIB qbt
                        ,kk.VERIFY_DATE creation_date
                from khs_kib kk
                    ,mtl_system_items_b msib 
                    ,wip_discrete_jobs wdj   
                where kk.PRIMARY_ITEM_ID = msib.INVENTORY_ITEM_ID
                    and kk.ORGANIZATION_ID = msib.ORGANIZATION_ID
                    and kk.ORDER_ID = wdj.WIP_ENTITY_ID 
                    and kk.PRIMARY_ITEM_ID = wdj.PRIMARY_ITEM_ID 
                    $atr";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }


    public function getInputLPPB($atr){
        $oracle = $this->load->database('oracle', true);
        $sql = "
                SELECT  DISTINCT
                POH.SEGMENT1
            ,(case when HRL.LOCATION_CODE = 'SP-YSP'
                        then 'LATIFA H'
                    when HRL.LOCATION_CODE IN ('KOM1-DM','KOM2-DM','KOM3-DM')
                        then 'INTAN/PRETTY'
                    when HRL.LOCATION_CODE = 'PNL-DM'
                        then 'BUDI RENA'
                    when HRL.LOCATION_CODE in ('MAT-DM','BLK-DM','MAT-PM')
                        then 'VIVIN V'
                END) gd
                ,rsl.shipment_line_id
                ,POH.PO_HEADER_ID
                ,RSL.PO_LINE_ID ,     
                DECODE(RSH.RECEIPT_SOURCE_CODE, 'VENDOR',     POV.VENDOR_NAME, 'CUSTOMER', NULL, ORG.NAME) SUPPLIER,
                RT.TRANSACTION_TYPE,
                POVS.ADDRESS_LINE1 ,
                POVS.CITY,    
                RSH.RECEIPT_NUM no_interorg,
                (select decode(POL.NOTE_TO_RECEIVER,null,null,pol.NOTE_TO_RECEIVER||'; ') 
                        ||decode(pla.ATTRIBUTE10,null,null,'MODEL:'||pla.ATTRIBUTE10||'; ')
                        ||decode(pla.ATTRIBUTE11,null,null,'BRAND:'||pla.ATTRIBUTE11||'; ')
                        ||decode(pla.ATTRIBUTE12,null,null,'MADE IN: '||pla.ATTRIBUTE12)
                    from po_lines_all pla
                    where pla.PO_HEADER_ID = poh.PO_HEADER_ID
                    and pla.PO_LINE_ID = rt.PO_LINE_ID) note_to_receiver, 
                RSH.SHIPMENT_NUM, 
                RSH.SHIPPED_DATE,
                RSH.CREATION_DATE RECEIPT_DATE,
                (select min(RT1.TRANSACTION_DATE) from RCV_TRANSACTIONS RT1
                where rt1.shipment_header_id = rsh.shipment_header_id) transaction_date,
                RSH.COMMENTS,
                rt.QUANTITY QTY,
            --    RT.QUANTITY + DECODE( (SELECT      
            --            DISTINCT(RTA.QUANTITY) TRANSACT_QTY    
            --        FROM
            --            RCV_SHIPMENT_HEADERS RSHA,
            --            RCV_TRANSACTIONS RTA
            --        WHERE
            --            RSHA.RECEIPT_NUM IS NOT NULL 
            --            AND RSHA.SHIPMENT_HEADER_ID = RTA.SHIPMENT_HEADER_ID
            --            AND RTA.TRANSACTION_TYPE = 'CORRECT'
            --            AND RTA.SHIPMENT_LINE_ID = RT.SHIPMENT_LINE_ID
            --            AND RSHA.RECEIPT_NUM =RSH.RECEIPT_NUM
            --            AND RSHA.SHIP_TO_ORG_ID =RSH.SHIP_TO_ORG_ID ),NULL,0,
            --                (SELECT      
            --                DISTINCT(RTA.QUANTITY) TRANSACT_QTY    
            --            FROM
            --                RCV_SHIPMENT_HEADERS RSHA,
            --                RCV_TRANSACTIONS RTA
            --            WHERE
            --                RSHA.RECEIPT_NUM IS NOT NULL 
            --                AND RSHA.SHIPMENT_HEADER_ID = RTA.SHIPMENT_HEADER_ID
            --                AND RTA.TRANSACTION_TYPE = 'CORRECT'
            --                AND RTA.SHIPMENT_LINE_ID = RT.SHIPMENT_LINE_ID
            --                AND RSHA.RECEIPT_NUM =RSH.RECEIPT_NUM
            --                AND RSHA.SHIP_TO_ORG_ID =RSH.SHIP_TO_ORG_ID)) TRANSACT_QTY,
                RT.UOM_CODE UOM,
                msib.SEGMENT1 item,   
                RSL.COMMENTS KOMEN,
                RSL.ITEM_DESCRIPTION description,
                DECODE(RT.SOURCE_DOCUMENT_CODE , 'PO', POH.SEGMENT1,    'RMA', OEH.ORDER_NUMBER, PRH.SEGMENT1) ORDER_NUM,
                HRL.LOCATION_CODE,
                DECODE(RRH.ROUTING_NAME,'Inspection Required',MP.ORGANIZATION_CODE||RSH.RECEIPT_NUM||'Q',MP.ORGANIZATION_CODE||RSH.RECEIPT_NUM) nolppb,
                DECODE(RSH.SHIP_TO_ORG_ID,'101',  
                ( decode((SELECT          
                            DISTINCT(substr(prl1.REFERENCE_NUM,1,8))
                        FROM
                            PO_LINES_ALL PLA1,    
                            PO_LINE_LOCATIONS_ALL PLLA1,
                            PO_HEADERS_ALL PHA1,
                            PO_REQUISITION_LINES_ALL PRL1 
                        WHERE            
                            PHA1.SEGMENT1 = POH.SEGMENT1
                            AND PLA1.PO_HEADER_ID = PHA1.PO_HEADER_ID                 
                            AND PLLA1.PO_LINE_ID = (
                                                        SELECT distinct
                                                            PLLA.PO_LINE_ID
                                                        FROM
                                                            PO_LINES_ALL PLA
                                                            ,PO_LINE_LOCATIONS_ALL PLLA           
                                                        WHERE
                                                            PLA.PO_HEADER_ID = POH.PO_HEADER_ID
                                                            AND PLA.PO_LINE_ID = RSL.PO_LINE_ID
                                                            AND PLLA.PO_LINE_ID = PLA.PO_LINE_ID    
                                                            and (PLLA.CANCEL_FLAG <> 'Y' or plla.CANCEL_FLAG is null)     
                                                    )      
                            AND PLA1.PO_LINE_ID = PLLA1.PO_LINE_ID
                            AND PRL1.LINE_LOCATION_ID = PLLA1.LINE_LOCATION_ID 
                            and rownum=1
                            )
                        ,'PPManual',(
                                    SELECT
                                        substr(PRL1.REFERENCE_NUM,10)          
                                    FROM
                                        PO_LINES_ALL PLA1,    
                                        PO_LINE_LOCATIONS_ALL PLLA1,
                                        PO_HEADERS_ALL PHA1,
                                        PO_REQUISITION_LINES_ALL PRL1 
                                    WHERE            
                                        PHA1.SEGMENT1 = POH.SEGMENT1
                                        AND PLA1.PO_HEADER_ID = PHA1.PO_HEADER_ID                            
                                        AND PLLA1.PO_LINE_ID = (
                                                                    SELECT
                                                                        PLLA.PO_LINE_ID
                                                                    FROM
                                                                        PO_LINES_ALL PLA
                                                                        ,PO_LINE_LOCATIONS_ALL PLLA           
                                                                    WHERE
                                                                        PLA.PO_HEADER_ID = POH.PO_HEADER_ID
                                                                        AND PLA.PO_LINE_ID =  RSL.PO_LINE_ID
                                                                        AND PLLA.PO_LINE_ID = PLA.PO_LINE_ID    
                                                                        and (PLLA.CANCEL_FLAG <> 'Y'or plla.CANCEL_FLAG is null)
                                                                )        
                                    AND PLA1.PO_LINE_ID = PLLA1.PO_LINE_ID
                                    AND PRL1.LINE_LOCATION_ID = PLLA1.LINE_LOCATION_ID                            
                                    )
                        ,'') 
                    ),            
                    (
                    select distinct 
                        WE.WIP_ENTITY_NAME 
                    From 
                        WIP_ENTITIES WE
                    where WE.WIP_ENTITY_ID =RT.WIP_ENTITY_ID     
                    ))NO_JOB 
            ,(SELECT
                    KLS.LOKASI 
                FROM
                    KHSINVLOKASISIMPAN KLS
                WHERE                      --memunculkan lokasi untuk barang jasa-edited by arif-20141127
                    KLS.INVENTORY_ITEM_ID = case when msib.SEGMENT1 not like 'JAC%' then
                                                    msib.INVENTORY_ITEM_ID
                                                else (
                                                        (
                                                        select msi.inventory_item_id
                                                        from   mtl_system_items msi
                                                        where  substr(msib.segment1, 4, length(msib.segment1)-4)||'-0' = msi.segment1
                                                        and    msi.organization_id = msib.organization_id
                                                        )
                                                        )
                                            end
                    AND KLS.SUBINV = HRL.LOCATION_CODE
                    AND rownum=1
                ) LOKASI_SIMPAN                 
            FROM mtl_system_items_b msib
                ,mtl_parameters mp
                ,hr_all_organization_units_tl org
                ,rcv_transactions rt
                ,rcv_shipment_headers rsh
                ,rcv_shipment_lines rsl
                ,rcv_routing_headers rrh
                ,po_headers_all poh
                ,oe_order_headers_all  oeh
                ,po_requisition_headers_all prh    
                ,po_requisition_lines_all prl
                ,po_line_locations_all pol
                ,po_vendor_sites_all povs
                ,po_vendors pov
                ,hr_locations hrl
                ,(select * 
                    from rcv_transactions) rct
                ,(select * 
                    from po_headers_all) pha
            where RSH.RECEIPT_NUM IS NOT NULL 
            and POV.VENDOR_ID (+) = RSH.VENDOR_ID
            and USERENV('LANG') = ORG.LANGUAGE(+)
            and ORG.ORGANIZATION_ID (+) = RSH.ORGANIZATION_ID
            and POVS.VENDOR_SITE_ID (+) = RSH.VENDOR_SITE_ID    
            and RSH.SHIPMENT_HEADER_ID = RT.SHIPMENT_HEADER_ID   
            and RT.TRANSACTION_TYPE = 'RECEIVE'    
            and RSL.SHIPMENT_LINE_ID = RT.SHIPMENT_LINE_ID
            and OEH.HEADER_ID (+) = RT.OE_ORDER_HEADER_ID 
            and POH.PO_HEADER_ID (+) = RT.PO_HEADER_ID
            and PRL.REQUISITION_LINE_ID (+) = RT.REQUISITION_LINE_ID
            and PRH.REQUISITION_HEADER_ID (+) = PRL.REQUISITION_HEADER_ID          
            and NVL(PRH.ORG_ID, -99) = NVL(PRL.ORG_ID, -99)
            and RSL.ITEM_ID = msib.INVENTORY_ITEM_ID
            and msib.ORGANIZATION_ID = RSH.SHIP_TO_ORG_ID
            and RT.LOCATION_ID = HRL.LOCATION_ID (+)
            and RRH.ROUTING_HEADER_ID (+) = RT.ROUTING_HEADER_ID
            and RSH.SHIP_TO_ORG_ID = MP.ORGANIZATION_ID
            and PHA.PO_HEADER_ID(+) = POL.PO_HEADER_ID
            and RCT.PO_HEADER_ID (+) = POL.PO_HEADER_ID
            and POL.PO_LINE_ID(+) = RT.PO_LINE_ID
            -- parameter
            --  and trunc(rt.TRANSACTION_DATE) between '01-JAN-2019' and '30-JUN-2019'
            $atr
            and hrl.LOCATION_CODE = 'SP-YSP'
            --  and RSH.SHIP_TO_ORG_ID =:ORGANIZATION";

        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function save($NO_INTERORG,$JENIS_DOKUMEN,$ITEM,$DESCRIPTION,$UOM,$QTY,$CREATION_DATE,$STATUS,$PIC)
    {
      $oracle = $this->load->database('oracle', true);
      $sql = "INSERT INTO KHS_MONITORING_GD_SP (no_document,jenis_dokumen,item,description,uom,qty,creation_date,status,pic)
          VALUES ('$NO_INTERORG','$JENIS_DOKUMEN','$ITEM','$DESCRIPTION','$UOM','$QTY',(TO_DATE('".$CREATION_DATE."','yyyy/mm/dd hh24:mi:ss')),'$STATUS','$PIC')";

      $query = $oracle->query($sql);
    //   return $query->result_array();
    // return $sql;
    // echo $sql;
    }

    public function ceknodoc($no_document){
        $oracle = $this->load->database('oracle', true);
      $sql = "SELECT NO_DOCUMENT FROM KHS_MONITORING_GD_SP WHERE NO_DOCUMENT = '$no_document'";

      $query = $oracle->query($sql);
      return $query->result_array();
    }

    public function ceknoKIB($no_document){
        $oracle = $this->load->database('oracle', true);
      $sql = "SELECT NO_DOCUMENT FROM KHS_MONITORING_GD_SP WHERE NO_DOCUMENT = 'PACKG$no_document'";

      $query = $oracle->query($sql);
      return $query->result_array();
    }

}

