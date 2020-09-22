lock<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dpb extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
        
		$this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function getDPBVendorList()
    {
        $sql = "select * from khs_dpb_list_dpb_vendor where approval_flag ='Y'";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getWaitingListApprovalDPBVendor()
    {
        $sql = "select * from khs_dpb_list_dpb_vendor where approval_flag is null";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getWaitingListApprovalDPBKHS()
    {
        $sql = "SELECT DISTINCT dpb.no_pr, dpb.tgl_kirim, dpb.jenis_kendaraan,
                dpb.no_kendaraan, dpb.nama_supir, dpb.vendor_ekspedisi
        FROM khs_dpb_kendaraan dpb
        WHERE dpb.no_pr LIKE 'KHS%' 
                AND dpb.APPROVED_FLAG = 'P'
        ORDER BY dpb.tgl_kirim DESC ";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getPRList()
    {
        $sql = "select * from khs_dpb_list_pr";
        
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    // public function getDPBVendorList()
    // {
    //     $sql = "SELECT distinct
    //                     prha.SEGMENT1               no_pr
    //                     ,to_char(prha.CREATION_DATE,'DD-MON-YYYY hh24:mi:ss')   tgl_pr
    //                     ,case when dpb.jenis_kendaraan is null
    //                     then prha.ATTRIBUTE3
    //                     else dpb.jenis_kendaraan
    //                     end jenis_kendaraan
    //                     ,dpb.NO_KENDARAAN
    //                     ,dpb.NAMA_SUPIR
    //                     ,dpb.VENDOR_EKSPEDISI
    //             --            ,msib.SEGMENT1
    //             FROM po_requisition_headers_all prha,
    //             PO_REQUISITION_LINES_ALL prla,
    //             KHS_DPB_KENDARAAN dpb,
    //             mtl_system_items_b msib
    //             where prha.SEGMENT1 = dpb.NO_PR(+)
    //             and msib.inventory_item_id(+) = prla.item_id
    //             and prha.REQUISITION_HEADER_ID = prla.REQUISITION_HEADER_ID
    //             and prha.AUTHORIZATION_STATUS not in ('REJECTED','CANCELLED')
    //             and msib.SEGMENT1 in ('JASA01','JASA57')
    //             and prha.CREATION_DATE between ('01-FEB-2020') and sysdate
    //             order by tgl_pr desc";
        
    //     $query = $this->oracle->query($sql);
    //     return $query->result_array();
    // }

    public function getDPBVendorDetail($id)
    {
        $sql = "select * from khs_dpb_detail where NO_PR = $id";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    // public function getDPBVendorDetail($id)
    // {
    //     $sql = "((select distinct poh.SEGMENT1 \"NO.PR\"
    //                 ,trunc(poh.CREATION_DATE) \"tgl pr\" 
    //                 , 'UNIT' \"TYPE\"
    //                 , to_char(wdd.BATCH_ID) \"NO.DO\"
    //                 , msib.DESCRIPTION \"ITEM\"
    //                 , msib.PRIMARY_UOM_CODE \"UOM\"
    //                 , min(wdd.REQUESTED_QUANTITY) \"QTY\"
    //                 --, wdd.SOURCE_HEADER_NUMBER \"NO.SO\"
    //                 , ship_party.PARTY_NAME \"RELATION\"
    //                 , ship_loc.CITY \"CITY\"
    //                 , case when dpb.jenis_kendaraan is null
    //                     then poh.ATTRIBUTE3
    //                     else dpb.jenis_kendaraan
    //                     end jenis_kendaraan
    //                 , dpb.NO_KENDARAAN
    //                 , dpb.NAMA_SUPIR
    //                 , dpb.VENDOR_EKSPEDISI
    //                 , dpb.LAIN
    //             from WSH_DELIVERY_DETAILS wdd
    //                 , MTL_SYSTEM_ITEMS_B msib
    //                 , OE_ORDER_LINES_ALL l
    //                 , OE_ORDER_HEADERS_ALL h
    //                 , HZ_LOCATIONS ship_loc
    //                 , HZ_CUST_SITE_USES_ALL ship_su
    //                 , HZ_PARTY_SITES ship_ps
    //                 , HZ_CUST_ACCT_SITES_ALL ship_cas
    //                 , HZ_PARTIES ship_party
    //                 , PO_REQUISITION_HEADERS_ALL poh
    //                 , PO_REQUISITION_LINES_ALL pol
    //                 , khs_dpb_kendaraan dpb
    //             where wdd.TOP_MODEL_LINE_ID = l.LINE_ID (+)
    //                 and l.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID (+)
    //                 and wdd.BATCH_ID is not null
    //             --    and (wdd.SOURCE_HEADER_NUMBER like '___01%'
    //             --        or wdd.SOURCE_HEADER_NUMBER like '____01%')
    //                 and msib.DESCRIPTION is not null
    //                 and wdd.REQUESTED_QUANTITY <> 0
    //                 and l.HEADER_ID = h.HEADER_ID (+)
    //                 and h.SHIP_TO_ORG_ID = ship_su.SITE_USE_ID (+)
    //                 and ship_su.CUST_ACCT_SITE_ID = ship_cas.CUST_ACCT_SITE_ID (+)
    //                 and ship_cas.PARTY_SITE_ID = ship_ps.PARTY_SITE_ID (+)
    //                 and ship_loc.LOCATION_ID (+) = ship_ps.LOCATION_ID
    //                 and ship_ps.PARTY_ID = ship_party.PARTY_ID (+)
    //                 and pol.REQUISITION_HEADER_ID = poh.REQUISITION_HEADER_ID (+)
    //                 and poh.SEGMENT1 = dpb.NO_PR (+)
    //                 and poh.SEGMENT1 = $id
    //                 and (pol.ATTRIBUTE1 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE2 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE3 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE4 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE5 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE6 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE7 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE8 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE9 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE10 = to_char(wdd.BATCH_ID))
    //             group by poh.SEGMENT1
    //                 ,poh.CREATION_DATE
    //                 , wdd.BATCH_ID
    //                 , msib.DESCRIPTION
    //                 , msib.PRIMARY_UOM_CODE
    //                 , wdd.SOURCE_HEADER_NUMBER
    //                 , ship_party.PARTY_NAME
    //                 , ship_loc.CITY
    //                 , poh.ATTRIBUTE3
    //                 , dpb.NO_KENDARAAN
    //                 , dpb.NAMA_SUPIR
    //                 , dpb.VENDOR_EKSPEDISI
    //                 , dpb.LAIN
    //                 , dpb.jenis_kendaraan)
    //             union
    //             (select distinct poh.SEGMENT1 \"NO.PR\"
    //                 ,trunc(poh.CREATION_DATE) \"tgl pr\" 
    //                 , 'IMPLEMENT' \"TYPE\"
    //                 , to_char(wdd.BATCH_ID) \"NO.DO\"
    //                 , wdd.ITEM_DESCRIPTION \"ITEM\"
    //                 , wdd.REQUESTED_QUANTITY_UOM \"UOM\"
    //                 , wdd.REQUESTED_QUANTITY \"QTY\"
    //                 --, wdd.SOURCE_HEADER_NUMBER \"NO.SO\"
    //                 , ship_loc.ADDRESS2 \"RELATION\"
    //                 , ship_loc.CITY \"CITY\"
    //                 , case when dpb.jenis_kendaraan is null
    //                     then poh.ATTRIBUTE3
    //                     else dpb.jenis_kendaraan
    //                     end jenis_kendaraan
    //                 , dpb.NO_KENDARAAN
    //                 , dpb.NAMA_SUPIR
    //                 , dpb.VENDOR_EKSPEDISI
    //                 , dpb.LAIN
    //             from WSH_DELIVERY_DETAILS wdd
    //                 , OE_ORDER_LINES_ALL l
    //                 , OE_ORDER_HEADERS_ALL h
    //                 , HZ_LOCATIONS ship_loc
    //                 , HZ_CUST_SITE_USES_ALL ship_su
    //                 , HZ_PARTY_SITES ship_ps
    //                 , HZ_CUST_ACCT_SITES_ALL ship_cas
    //                 , HZ_PARTIES ship_party
    //                 , PO_REQUISITION_HEADERS_ALL poh
    //                 , PO_REQUISITION_LINES_ALL pol
    //                 , oe_transaction_types_tl ot
    //                 , KHS_DPB_KENDARAAN dpb
    //             --    , QP_LIST_HEADERS_TL pl
    //             where wdd.source_line_id = l.LINE_ID
    //                 and l.HEADER_ID = h.HEADER_ID
    //                 and wdd.BATCH_ID is not null
    //             --    and h.PRICE_LIST_ID = pl.LIST_HEADER_ID
    //                 and h.ORDER_TYPE_ID = ot.transaction_type_id
    //             --    and (wdd.SOURCE_HEADER_NUMBER like '___01%'
    //             --        or wdd.SOURCE_HEADER_NUMBER like '____01%')
    //                 and l.SHIP_TO_ORG_ID = ship_su.SITE_USE_ID (+)
    //                 and ship_su.CUST_ACCT_SITE_ID = ship_cas.CUST_ACCT_SITE_ID (+)
    //                 and ship_cas.PARTY_SITE_ID = ship_ps.PARTY_SITE_ID (+)
    //                 and ship_loc.LOCATION_ID (+) = ship_ps.LOCATION_ID
    //                 and ship_ps.PARTY_ID = ship_party.PARTY_ID (+)
    //                 and pol.REQUISITION_HEADER_ID = poh.REQUISITION_HEADER_ID (+)
    //             --    and pl.NAME like '%Perlengkapan%'
    //                 and ot.name like '%Perlengkapan%'
    //                 and poh.SEGMENT1 = dpb.NO_PR (+)
    //                 and poh.SEGMENT1 =$id
    //                 and (pol.ATTRIBUTE1 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE2 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE3 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE4 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE5 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE6 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE7 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE8 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE9 = to_char(wdd.BATCH_ID)
    //                     or pol.ATTRIBUTE10 = to_char(wdd.BATCH_ID))))
    //             union
    //             ((-- cabang go live -- 
    //             select distinct poh.SEGMENT1 \"NO.PR\"
    //                 ,trunc(poh.CREATION_DATE) \"tgl pr\"
    //                 , 'UNIT' \"TYPE\"
    //                 , kim.TRANSACTION_SOURCE_NAME \"NO.DO\"
    //                 , msib.DESCRIPTION \"ITEM\"
    //                 , msib.PRIMARY_UOM_CODE \"UOM\"
    //                 , min(kim.QTY_TRANSACTION) \"QTY\"
    //                 , decode(substr(mp.ORGANIZATION_CODE,-3,1),
    //                     'J','KHS Jakarta (OU)',
    //                     'M','KHS Medan (OU)',
    //                     'S','KHS Surabaya (OU)',
    //                     'T','KHS Tanjung Karang (OU)',
    //                     'U','KHS Makassar (OU)') \"RELATION\"
    //                 , decode(substr(mp.ORGANIZATION_CODE,-3,1),
    //                     'J','KHS Jakarta (OU)',
    //                     'M','KHS Medan (OU)',
    //                     'S','KHS Surabaya (OU)',
    //                     'T','KHS Tanjung Karang (OU)',
    //                     'U','KHS Makassar (OU)') \"CITY\"
    //                 , case when dpb.jenis_kendaraan is null
    //                     then poh.ATTRIBUTE3
    //                     else dpb.jenis_kendaraan
    //                     end jenis_kendaraan
    //                 , dpb.NO_KENDARAAN
    //                 , dpb.NAMA_SUPIR
    //                 , dpb.VENDOR_EKSPEDISI
    //                 , dpb.LAIN
    //             from KHS_INV_MTLTRANSACTIONS kim
    //                 , MTL_SYSTEM_ITEMS_B msib
    //                 , MTL_TXN_REQUEST_HEADERS mtrh
    //                 , MTL_MATERIAL_TRANSACTIONS mmt
    //                 , MTL_SECONDARY_INVENTORIES msi
    //                 , MTL_PARAMETERS mp
    //                 , PO_REQUISITION_HEADERS_ALL poh
    //                 , PO_REQUISITION_LINES_ALL pol
    //                 , khs_dpb_kendaraan dpb
    //             where kim.TRANSACTION_SOURCE_NAME = mmt.TRANSACTION_SOURCE_NAME
    //                 and msib.inventory_item_id = kim.ASSEMBLY_ITEM_ID
    //                 and msib.ORGANIZATION_ID = 81
    //                 and kim.QTY_TRANSACTION <> 0
    //                 and kim.TRANSACTION_SOURCE_NAME = mtrh.REQUEST_NUMBER
    //                 --and mtrh.ATTRIBUTE3 is not null
    //                 and mmt.TRANSFER_SUBINVENTORY = msi.SECONDARY_INVENTORY_NAME
    //                 and msi.ORGANIZATION_ID = mp.ORGANIZATION_ID
    //                 and pol.REQUISITION_HEADER_ID = poh.REQUISITION_HEADER_ID
    //                 and poh.SEGMENT1 =$id
    //                 and poh.SEGMENT1 = dpb.NO_PR (+)
    //                 and (pol.ATTRIBUTE1 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE2 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE3 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE4 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE5 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE6 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE7 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE8 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE9 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE10 = to_char(kim.TRANSACTION_SOURCE_NAME))
    //             group by poh.SEGMENT1
    //                 ,poh.CREATION_DATE
    //                 , kim.TRANSACTION_SOURCE_NAME
    //                 , msib.SEGMENT1
    //                 , msib.DESCRIPTION
    //                 , msib.PRIMARY_UOM_CODE
    //                 , mp.ORGANIZATION_CODE
    //                 , poh.ATTRIBUTE3
    //                 , dpb.NO_KENDARAAN
    //                 , dpb.NAMA_SUPIR
    //                 , dpb.VENDOR_EKSPEDISI
    //                 , dpb.LAIN
    //                 , dpb.jenis_kendaraan
    //             -- non go live -- 
    //             union all
    //             select distinct poh.SEGMENT1 \"NO.PR\"
    //                 ,trunc(poh.CREATION_DATE) \"tgl pr\"
    //                 , 'UNIT' \"TYPE\"
    //                 , kim.TRANSACTION_SOURCE_NAME \"NO.DO\"
    //                 , msib.DESCRIPTION \"ITEM\"
    //                 , msib.PRIMARY_UOM_CODE \"UOM\"
    //                 , min(kim.QTY_TRANSACTION) \"QTY\"
    //                 , decode(kim.REFERENCE,
    //                     'IO : 141','KHS Jakarta (OU)',
    //                     'IO : 144','KHS Medan (OU)',
    //                     'IO : 121','KHS Surabaya (OU)',
    //                     'IO : 142','KHS Tanjung Karang (OU)',
    //                     'IO : 143','KHS Makassar (OU)') \"RELATION\"
    //                 , decode(kim.REFERENCE,
    //                     'IO : 141','KHS Jakarta (OU)',
    //                     'IO : 144','KHS Medan (OU)',
    //                     'IO : 121','KHS Surabaya (OU)',
    //                     'IO : 142','KHS Tanjung Karang (OU)',
    //                     'IO : 143','KHS Makassar (OU)') \"CITY\"
    //                 , case when dpb.jenis_kendaraan is null
    //                     then poh.ATTRIBUTE3
    //                     else dpb.jenis_kendaraan
    //                     end jenis_kendaraan
    //                 , dpb.NO_KENDARAAN
    //                 , dpb.NAMA_SUPIR
    //                 , dpb.VENDOR_EKSPEDISI
    //                 , dpb.LAIN
    //             from KHS_INV_MTLTRANSACTIONS kim
    //                 , MTL_SYSTEM_ITEMS_B msib
    //                 , MTL_TXN_REQUEST_HEADERS mtrh
    //                 , PO_REQUISITION_HEADERS_ALL poh
    //                 , PO_REQUISITION_LINES_ALL pol
    //                 , khs_dpb_kendaraan dpb
    //             where msib.INVENTORY_ITEM_ID = kim.ASSEMBLY_ITEM_ID
    //                 and msib.ORGANIZATION_ID = 81
    //                 and kim.QTY_TRANSACTION <> 0
    //                 and kim.TRANSACTION_SOURCE_NAME = mtrh.REQUEST_NUMBER
    //                 and mtrh.ATTRIBUTE3 is null
    //                 and pol.REQUISITION_HEADER_ID = poh.REQUISITION_HEADER_ID
    //                 and poh.SEGMENT1 =$id
    //                 and poh.SEGMENT1 = dpb.NO_PR (+)
    //                 and (pol.ATTRIBUTE1 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE2 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE3 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE4 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE5 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE6 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE7 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE8 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE9 = to_char(kim.TRANSACTION_SOURCE_NAME)
    //                     or pol.ATTRIBUTE10 = to_char(kim.TRANSACTION_SOURCE_NAME))
    //             group by poh.SEGMENT1
    //                 ,poh.CREATION_DATE
    //                 , kim.TRANSACTION_SOURCE_NAME
    //                 , msib.SEGMENT1
    //                 , msib.DESCRIPTION
    //                 , msib.PRIMARY_UOM_CODE
    //                 , kim.REFERENCE
    //                 , poh.ATTRIBUTE3
    //                 , dpb.NO_KENDARAAN
    //                 , dpb.NAMA_SUPIR
    //                 , dpb.VENDOR_EKSPEDISI
    //                 , dpb.LAIN
    //                 , dpb.jenis_kendaraan)
    //             union
    //             --START 18 Maret 2016 Ditambahkan untuk SPB yg dari SO
    //             select distinct poh.SEGMENT1 \"NO.PR\"
    //                 ,trunc(poh.CREATION_DATE) \"tgl pr\"
    //                 , 'UNIT' \"TYPE\"
    //                 , kmf.mtrh_request_number \"NO.DO\"
    //                 , msib.DESCRIPTION \"ITEM\"
    //                 , msib.PRIMARY_UOM_CODE \"UOM\"
    //                 , kmf.OOLA_ASSEMBLY_ITEM_QTY \"QTY\"
    //                 , NULL \"RELATION\"
    //                 , NULL \"CITY\"
    //                 , case when dpb.jenis_kendaraan is null
    //                     then poh.ATTRIBUTE3
    //                     else dpb.jenis_kendaraan
    //                     end jenis_kendaraan
    //                 , dpb.NO_KENDARAAN
    //                 , dpb.NAMA_SUPIR
    //                 , dpb.VENDOR_EKSPEDISI
    //                 , dpb.LAIN
    //             from khs_mo_from_so_header_tab kmf
    //                 , MTL_SYSTEM_ITEMS_B msib
    //                 , MTL_TXN_REQUEST_HEADERS mtrh
    //                 , PO_REQUISITION_HEADERS_ALL poh
    //                 , PO_REQUISITION_LINES_ALL pol
    //                 , khs_dpb_kendaraan dpb
    //             where msib.segment1 = kmf.OOLA_ASSEMBLY_ITEM
    //                 and msib.ORGANIZATION_ID = 81
    //                 and kmf.OOLA_ASSEMBLY_ITEM_QTY <> 0
    //                 and kmf.mtrh_request_number = mtrh.REQUEST_NUMBER
    //                 and mtrh.ATTRIBUTE3 is null
    //                 and pol.REQUISITION_HEADER_ID = poh.REQUISITION_HEADER_ID
    //                 and poh.SEGMENT1 =$id
    //                 and poh.SEGMENT1 = dpb.NO_PR (+)
    //                 and (pol.ATTRIBUTE1 = to_char(kmf.mtrh_request_number)
    //                     or pol.ATTRIBUTE2 = to_char(kmf.mtrh_request_number)
    //                     or pol.ATTRIBUTE3 = to_char(kmf.mtrh_request_number)
    //                     or pol.ATTRIBUTE4 = to_char(kmf.mtrh_request_number)
    //                     or pol.ATTRIBUTE5 = to_char(kmf.mtrh_request_number)
    //                     or pol.ATTRIBUTE6 = to_char(kmf.mtrh_request_number)
    //                     or pol.ATTRIBUTE7 = to_char(kmf.mtrh_request_number)
    //                     or pol.ATTRIBUTE8 = to_char(kmf.mtrh_request_number)
    //                     or pol.ATTRIBUTE9 = to_char(kmf.mtrh_request_number)
    //                     or pol.ATTRIBUTE10 = to_char(kmf.mtrh_request_number))
    //             --END 18 Maret 2016 Ditambahkan untuk SPB yg dari SO
    //             union
    //             (-- untuk cabang sudah go live -- 
    //             select distinct poh.SEGMENT1 \"NO.PR\"
    //                 ,trunc(poh.CREATION_DATE) \"tgl pr\"
    //                 , 'SPAREPART' \"TYPE\"
    //                 , mtrh.REQUEST_NUMBER \"NO.DO\"
    //                 , msib.DESCRIPTION \"ITEM\"
    //                 , msib.PRIMARY_UOM_CODE \"UOM\"
    //                 , mtrl.QUANTITY \"QTY\"
    //                 , decode(substr(mp.ORGANIZATION_CODE ,-3,1),
    //                     'J','KHS Jakarta (OU)',
    //                     'M','KHS Medan (OU)',
    //                     'S','KHS Surabaya (OU)',
    //                     'T','KHS Tanjung Karang (OU)',
    //                     'U','KHS Makassar (OU)') \"RELATION\"
    //                 , decode(substr(mp.ORGANIZATION_CODE ,-3,1),
    //                     'J','KHS Jakarta (OU)',
    //                     'M','KHS Medan (OU)',
    //                     'S','KHS Surabaya (OU)',
    //                     'T','KHS Tanjung Karang (OU)',
    //                     'U','KHS Makassar (OU)') \"CITY\"
    //                 , case when dpb.jenis_kendaraan is null
    //                     then poh.ATTRIBUTE3
    //                     else dpb.jenis_kendaraan
    //                     end jenis_kendaraan
    //                 , dpb.NO_KENDARAAN
    //                 , dpb.NAMA_SUPIR
    //                 , dpb.VENDOR_EKSPEDISI
    //                 , dpb.LAIN
    //             from MTL_TXN_REQUEST_HEADERS mtrh
    //                 , MTL_TXN_REQUEST_LINES mtrl
    //                 , MTL_SYSTEM_ITEMS_B msib
    //                 , MTL_SECONDARY_INVENTORIES msi
    //                 , MTL_PARAMETERS mp
    //                 , PO_REQUISITION_HEADERS_ALL poh
    //                 , PO_REQUISITION_LINES_ALL pol
    //                 , khs_dpb_kendaraan dpb
    //             where mtrh.HEADER_ID = mtrl.HEADER_ID
    //                 and mtrh.ORGANIZATION_ID = mtrl.ORGANIZATION_ID
    //                 and mtrl.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
    //                 and mtrl.ORGANIZATION_ID = msib.ORGANIZATION_ID
    //                 and mtrh.ATTRIBUTE2 = msi.SECONDARY_INVENTORY_NAME
    //                 and msi.ORGANIZATION_ID = mp.ORGANIZATION_ID
    //                 --and mtrh.ATTRIBUTE3 is not null
    //                 and LENGTH(mtrh.REQUEST_NUMBER) = 6
    //                 and pol.REQUISITION_HEADER_ID = poh.REQUISITION_HEADER_ID
    //                 and poh.SEGMENT1 =$id
    //                 and poh.SEGMENT1 = dpb.NO_PR (+)
    //                 and (pol.ATTRIBUTE1 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE2 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE3 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE4 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE5 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE6 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE7 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE8 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE9 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE10 = to_char(mtrh.REQUEST_NUMBER))
    //             -- untuk cabang belum go live -- 
    //             union all
    //             select distinct poh.SEGMENT1 \"NO.PR\"
    //                 ,trunc(poh.CREATION_DATE) \"tgl pr\"
    //                 , 'SPAREPART' \"TYPE\"
    //                 , mtrh.REQUEST_NUMBER \"NO.DO\"
    //                 , msib.DESCRIPTION \"ITEM\"
    //                 , msib.PRIMARY_UOM_CODE \"UOM\"
    //                 , mtrl.QUANTITY \"QTY\"
    //                 , decode(mtrl.REFERENCE,
    //                     'IO : 141','KHS Jakarta (OU)',
    //                     'IO : 144','KHS Medan (OU)',
    //                     'IO : 121','KHS Surabaya (OU)',
    //                     'IO : 142','KHS Tanjung Karang (OU)',
    //                     'IO : 143','KHS Makassar (OU)') \"RELATION\"
    //                 , decode(mtrl.REFERENCE,
    //                     'IO : 141','KHS Jakarta (OU)',
    //                     'IO : 144','KHS Medan (OU)',
    //                     'IO : 121','KHS Surabaya (OU)',
    //                     'IO : 142','KHS Tanjung Karang (OU)',
    //                     'IO : 143','KHS Makassar (OU)') \"CITY\"
    //                 , case when dpb.jenis_kendaraan is null
    //                     then poh.ATTRIBUTE3
    //                     else dpb.jenis_kendaraan
    //                     end jenis_kendaraan
    //                 , dpb.NO_KENDARAAN
    //                 , dpb.NAMA_SUPIR
    //                 , dpb.VENDOR_EKSPEDISI
    //                 , dpb.LAIN
    //             from MTL_TXN_REQUEST_HEADERS mtrh
    //                 , MTL_TXN_REQUEST_LINES mtrl
    //                 , MTL_SYSTEM_ITEMS_B msib
    //                 , MTL_SECONDARY_INVENTORIES msi
    //                 , MTL_PARAMETERS mp
    //                 , PO_REQUISITION_HEADERS_ALL poh
    //                 , PO_REQUISITION_LINES_ALL pol
    //                 , khs_dpb_kendaraan dpb
    //             where mtrh.HEADER_ID = mtrl.HEADER_ID
    //                 and mtrh.ORGANIZATION_ID = mtrl.ORGANIZATION_ID
    //                 and mtrl.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
    //                 and mtrl.ORGANIZATION_ID = msib.ORGANIZATION_ID
    //                 and mtrh.ATTRIBUTE2 = msi.SECONDARY_INVENTORY_NAME
    //                 and msi.ORGANIZATION_ID = mp.ORGANIZATION_ID
    //                 and mtrh.ATTRIBUTE3 is null
    //                 and LENGTH(mtrh.REQUEST_NUMBER) = 6
    //                 and mtrh.TO_SUBINVENTORY_CODE like 'KELUAR%'
    //                 and pol.REQUISITION_HEADER_ID = poh.REQUISITION_HEADER_ID
    //                 and poh.SEGMENT1 =$id
    //                 and poh.SEGMENT1 = dpb.NO_PR (+)
    //                 and (pol.ATTRIBUTE1 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE2 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE3 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE4 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE5 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE6 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE7 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE8 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE9 = to_char(mtrh.REQUEST_NUMBER)
    //                     or pol.ATTRIBUTE10 = to_char(mtrh.REQUEST_NUMBER))))
    //             order by 3";

    //     $query = $this->oracle->query($sql);
    //     return $query->result_array();
    // }

    public function getDPBKHSList()
    {
        $sql = "SELECT 
                    DISTINCT dpb.no_pr, 
                    dpb.tgl_kirim, 
                    dpb.jenis_kendaraan,
                    dpb.no_kendaraan,
                    dpb.nama_supir,
                    dpb.vendor_ekspedisi
                FROM 
                    khs_dpb_kendaraan dpb
                WHERE 
                    dpb.no_pr LIKE 'KHS%' 
                AND dpb.APPROVED_FLAG is null
                ORDER BY dpb.tgl_kirim DESC";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getListDPBKHS()
    {
        $sql = "SELECT DISTINCT dpb.NO_PR,
                dpb.JENIS_KENDARAAN,
                dpb.NO_KENDARAAN,
                dpb.CREATION_DATE,
                dpb.KONTAK_SOPIR,
                dpb.NAMA_SUPIR,
                dpb.VENDOR_EKSPEDISI,
                dpb.LAIN,
                dpb.LINE_NUM,
                dpb.DO_NUM,
                dpb.ITEM_NAME,
                dpb.UOM,
                dpb.QTY,
                dpb.NAMA_TOKO,
                dpb.KOTA,
                dpb.TGL_KIRIM
            FROM
                KHS_DPB_KENDARAAN dpb
            WHERE 
                dpb.NO_PR LIKE 'KHS%' 
            AND
                dpb.APPROVED_FLAG = 'Y'
            ORDER BY 
                dpb.TGL_KIRIM DESC";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }


    public function getDPBKHSDetail($id)
    {
        $sql = "SELECT
                    DISTINCT dpb.NO_PR,
                    dpb.JENIS_KENDARAAN,
                    dpb.NO_KENDARAAN,
                    dpb.NAMA_SUPIR,
                    dpb.VENDOR_EKSPEDISI,
                    dpb.LAIN,
                    dpb.LINE_NUM,
                    dpb.DO_NUM,
                    dpb.ITEM_NAME,
                    dpb.UOM,
                    dpb.QTY,
                    dpb.NAMA_TOKO,
                    dpb.KOTA
                FROM
                    KHS_DPB_KENDARAAN dpb
                WHERE
                    dpb.NO_PR = '$id'";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function checkPRNumber($pr_number)
    {
        return $this->oracle
            ->select('NO_PR')
            ->from('KHS_DPB_KENDARAAN')
            ->like('NO_PR', $pr_number, 'after')
            ->order_by('NO_PR', 'DESC')
            ->get()
            ->row_array();
    }

    public function checkIsExist($pr_number)
    {
        return $this->oracle
            ->select('NO_PR')
            ->from('KHS_DPB_KENDARAAN')
            ->where('NO_PR', $pr_number)
            ->get()
            ->result_array();
    }

    public function deleteDPBKHS($id)
    {
        $this->oracle
            ->where('NO_PR', $id)
            ->delete('KHS_DPB_KENDARAAN');        
    }

    public function deleteDetail($pr_number, $line_number)
    {
        $this->oracle
            ->where('NO_PR', $pr_number)
            ->where('LINE_NUM', $line_number)
            ->delete('KHS_DPB_KENDARAAN');
    }

    public function insertNewDetail($data, $estDatang)
    {
        $this->oracle
                ->set('ESTIMASI_DATANG',"TO_DATE('$estDatang','yyyy-mm-dd HH24:MI:SS')",false)
                ->insert('KHS_DPB_KENDARAAN', $data);
    }

    public function insertNewDetailListPR($data)
    {
        $this->oracle->insert('KHS_DPB_KENDARAAN', $data);
    }

    public function insertNewDetailListPR1($data, $tglKirim)
    {
        $this->oracle
                    ->set('TGL_KIRIM',"TO_DATE('$tglKirim','yyyy-mm-dd')",false)
                    ->insert('KHS_DPB_KENDARAAN', $data);
    }

    public function insertNewDetailKHS($data)
    {
        $this->oracle
            ->set('TGL_KIRIM', "TO_DATE('".date('Y-m-d h:i:s')."' ,'yyyy-mm-dd hh24:mi:ss')", FALSE)
            ->insert('KHS_DPB_KENDARAAN', $data);
    }

    public function updateDetail($id, $data,$estDatang)
    {
        $this->oracle
            ->where('NO_PR', $id)
            ->set('ESTIMASI_DATANG',"TO_DATE('$estDatang','yyyy-mm-dd HH24:MI:SS')",false)
            ->update('KHS_DPB_KENDARAAN', $data);
    }

    public function updateDetailListPR($id, $data)
    {
        $this->oracle
            ->where('NO_PR', $id)
            ->update('KHS_DPB_KENDARAAN', $data);
    }

    public function updateDetailListPR1($id, $data, $tglKirim)
    {
        $this->oracle
            ->where('NO_PR', $id)
            ->set('TGL_KIRIM',"TO_DATE('$tglKirim','yyyy-mm-dd')",false)
            ->update('KHS_DPB_KENDARAAN', $data);
    }

    public function updateDetailKHS($pr_number, $line_number, $data)
    {
        $this->oracle
            ->where('NO_PR', $pr_number)
            ->where('LINE_NUM', $line_number)
            ->set('TGL_KIRIM', "TO_DATE('".date('Y-m-d h:i:s')."' ,'yyyy-mm-dd hh24:mi:ss')", FALSE)
            ->update('KHS_DPB_KENDARAAN', $data);
    }

    public function AddDetailInformationList($kode_do)
    {
        return $this->oracle
        ->where('NO_DO_SPB',$kode_do)
        ->get('KHS_DPB_KHS_DETAIL')
        ->result_array();
        
    }

    public function getListApprovalDPBVendor()
    {
        $oracle = $this->load->database('oracle',true);
        $query = $oracle->get_where('KHS_DPB_KENDARAAN', array('APPROVED_FLAG' => NULL));

        return $query->result_array();
    }

    public function getListApprovalDPBKHS()
    {
        $oracle = $this->load->database('oracle',true);
        $query = $oracle->get_where('KHS_DPB_KENDARAAN', array('APPROVED_FLAG' => 'P'));

        return $query->result_array();
    }

    public function ApproveDPB($id, $data)
    {
        $oracle = $this->load->database('oracle',true);
        $oracle->where('NO_PR',$id);
        $oracle->set('APPROVED_DATE',"SYSDATE",false);
        $oracle->update('KHS_DPB_KENDARAAN', $data);
    }

    public function checkOnhand($no_do, $kode_gudang)
    {
        $oracle = $this->load->database('oracle',true);
        $query = $oracle->query("SELECT APPS.KHS_CEK_ATR_DOSPB2('$no_do', 102, '$kode_gudang') as stockonhand FROM dual");

      return $query->result_array();
    }

    public function procedureLockStock($no_do, $kode_gudang, $user)
    {
        $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
		if (!$conn) {
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}
        $oracle = $this->load->database('oracle',true);
        $sql = "BEGIN APPS.KHS_ALLOCATE_NONSERIAL_DOSPB2(:no_do, 102, :kode_gudang, :user); END;";  
        
        $stmt = oci_parse($conn,$sql);
        oci_bind_by_name($stmt,':no_do',$no_do,100);
		oci_bind_by_name($stmt,':kode_gudang',$kode_gudang,100);
        oci_bind_by_name($stmt,':user',$user,100);
        
        // But BEFORE statement, Create your cursor
		// $cursor = oci_new_cursor($conn);
		
		oci_execute($stmt);

		// and now, execute the cursor
		// oci_execute($cursor);
 
		// $message is now populated with the output value
		// print "$message\n";
    }

    public function CekStok($no_do, $kode_gudang)
    {
        $oracle = $this->load->database('oracle',true);
        $query = $oracle->query("WITH param as (select regexp_substr('$no_do','[^,]+', 1, level) p_item from dual
        connect by regexp_substr('$no_do', '[^,]+', 1, level) is not null)                                           
        SELECT
        moqd.subinventory_code
        ,msib.segment1 item_code
        ,msib.DESCRIPTION
        ,tbl1.req_qty
        --,NVL(SUM(moqd.transaction_quantity),0) QTY_ONHAND
        ,(NVL(SUM(moqd.transaction_quantity),0) -    (
        SELECT
        NVL(SUM(mr.RESERVATION_QUANTITY),0)                                          
        FROM
        MTL_RESERVATIONS MR
        ,mtl_system_items_b msib2
        WHERE 
        MR.inventory_item_id = msib2.INVENTORY_ITEM_ID
        and MR.organization_id = msib2.organization_id
        and msib2.segment1 = msib.segment1
        and mr.subinventory_code = moqd.subinventory_code
        )
        -
        (
        select
        NVL(SUM(mmtt.transaction_quantity),0)
        from
        MTL_MATERIAL_TRANSACTIONS_TEMP mmtt
        ,mtl_system_items_b msib3
        where
        msib3.inventory_item_id = mmtt.inventory_item_id
        and msib3.organization_id = mmtt.organization_id
        and msib3.segment1 = msib.segment1
        and mmtt.subinventory_code = moqd.subinventory_code    
        )
        ) ATR
        ,(NVL(SUM(moqd.transaction_quantity),0) -    (
        SELECT
        NVL(SUM(mr.RESERVATION_QUANTITY),0)                                          
        FROM
        MTL_RESERVATIONS MR
        ,mtl_system_items_b msib2
        WHERE 
        MR.inventory_item_id = msib2.INVENTORY_ITEM_ID
        and MR.organization_id = msib2.organization_id
        and msib2.segment1 = msib.segment1
        and mr.subinventory_code = moqd.subinventory_code
        )
        -
        (
        select
        NVL(SUM(mmtt.transaction_quantity),0)
        from
        MTL_MATERIAL_TRANSACTIONS_TEMP mmtt
        ,mtl_system_items_b msib3
        where
        msib3.inventory_item_id = mmtt.inventory_item_id
        and msib3.organization_id = mmtt.organization_id
        and msib3.segment1 = msib.segment1
        and mmtt.subinventory_code = moqd.subinventory_code    
        )
        )
        - tbl1.req_qty ATR_sisa
        from
        mtl_onhand_quantities_detail moqd
        ,mtl_system_items_b msib
        ,(select 
        mtrl.INVENTORY_ITEM_ID
        ,sum(mtrl.QUANTITY) req_qty
        from
        mtl_txn_request_headers mtrh
        ,mtl_txn_request_lines mtrl
        where
        mtrh.HEADER_ID = mtrl.HEADER_ID
        and mtrh.ORGANIZATION_ID = 102
        and mtrh.REQUEST_NUMBER IN (select * from param) --('3916224', '3916226') --(SELECT * FROM param)
        group by mtrl.INVENTORY_ITEM_ID) tbl1
        where
        msib.inventory_item_id = moqd.inventory_item_id
        and msib.organization_id = moqd.organization_id
        and msib.INVENTORY_ITEM_ID = tbl1.INVENTORY_ITEM_ID
        and moqd.subinventory_code = '$kode_gudang'
        group by
        moqd.subinventory_code
        ,msib.segment1
        ,tbl1.req_qty
        ,msib.DESCRIPTION
        having
        (NVL(SUM(moqd.transaction_quantity),0) -    (
        SELECT
        NVL(SUM(mr.RESERVATION_QUANTITY),0)                                          
        FROM
        MTL_RESERVATIONS MR
        ,mtl_system_items_b msib2
        WHERE 
        MR.inventory_item_id = msib2.INVENTORY_ITEM_ID
        and MR.organization_id = msib2.organization_id
        and msib2.segment1 = msib.segment1
        and mr.subinventory_code = moqd.subinventory_code
        )
        -
        (
        select
        NVL(SUM(mmtt.transaction_quantity),0)
        from
        MTL_MATERIAL_TRANSACTIONS_TEMP mmtt
        ,mtl_system_items_b msib3
        where
        msib3.inventory_item_id = mmtt.inventory_item_id
        and msib3.organization_id = mmtt.organization_id
        and msib3.segment1 = msib.segment1
        and mmtt.subinventory_code = moqd.subinventory_code    
        )
        )
        - tbl1.req_qty < 0");

        return $query->result_array();
    }

}