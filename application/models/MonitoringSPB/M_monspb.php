<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monspb extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }


    public function ListSpb($where)
    {
        $sql = "SELECT * FROM (select distinct
        mtrh.REQUEST_NUMBER NO_SPB
        ,mtrh.CREATION_DATE
        ,nvl(mofo.OOHA_ORDER_NUMBER, mtrl.ATTRIBUTE7) NO_SO
        ,mtrh.DESCRIPTION KETERANGAN
        ,case 
            when (mtrl.LINE_STATUS in (5)) then 'LINE CLOSE/SUDAH TRANSACT'
            when (mtrl.LINE_STATUS in (6)) then 'LINE CANCEL'
            when (mtrl.LINE_STATUS in (3,7)) then 'BELUM TRANSACT'
            else 'LAIN-LAIN' end TRANSACT_STATUS
        ,case when (mtrh.ATTRIBUTE3 = 'INTERORG') then 'SUDAH INTERORG' else 'BELUM INTERORG' end INTERORG_STATUS
        ,(select mp.ORGANIZATION_CODE from mtl_parameters mp where to_char(mp.ORGANIZATION_ID) = SUBSTR(mtrl.REFERENCE,6,4)) IO_TUJUAN
        ,(select min(rt.TRANSACTION_DATE) from rcv_transactions rt where rt.SHIPMENT_HEADER_ID = rsh.SHIPMENT_HEADER_ID) TANGGAL_RECEIPT
        from
        mtl_txn_request_headers mtrh
        ,mtl_txn_request_lines mtrl
        ,khs_mo_from_so_header_tab mofo
        ,rcv_shipment_headers rsh
        where
        mtrh.HEADER_ID = mtrl.HEADER_ID
        and mtrh.TO_SUBINVENTORY_CODE = 'KLR-CBG-FG'
        and mtrh.REQUEST_NUMBER = mofo.MTRH_REQUEST_NUMBER(+)
        and mtrh.CREATION_DATE > to_date('01-01-20', 'DD-MM-YY')
        and mtrh.REQUEST_NUMBER = rsh.SHIPMENT_NUM(+)
        order by mtrh.CREATION_DATE DESC)
        $where";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function DetailSpb($spb)
    {
        $query = $this->oracle->query("select
        mtrh.REQUEST_NUMBER NO_SPB
        ,mtrl.LINE_NUMBER LINE_SPB
        ,msib.SEGMENT1 KODE_ITEM
        ,msib.DESCRIPTION ITEM_DESC
        ,mtrl.QUANTITY QTY
        ,mtrl.QUANTITY_DETAILED QTY_ALLOCATE 
        ,mtrl.QUANTITY_DELIVERED QTY_DELIVER
        ,mp.ORGANIZATION_CODE IO_TUJUAN
        ,mofo.OOHA_ORDER_NUMBER NO_SO
        from
        mtl_txn_request_headers mtrh
        ,mtl_txn_request_lines mtrl
        ,mtl_parameters mp
        ,khs_mo_from_so_header_tab mofo
        ,mtl_system_items_b msib
        where
        mtrh.HEADER_ID = mtrl.HEADER_ID
        and mtrh.TO_SUBINVENTORY_CODE = 'KLR-CBG-FG'
        and SUBSTR(mtrl.REFERENCE,6,4) = mp.ORGANIZATION_ID(+)
        and mtrh.REQUEST_NUMBER = mofo.MTRH_REQUEST_NUMBER(+)
        and mtrl.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
        and msib.ORGANIZATION_ID = 81
        and mtrh.REQUEST_NUMBER = '$spb'");
        return $query->result_array();
    }
    public function selectIO($term)
    {
        $query = $this->oracle->query("select
        mp.ORGANIZATION_CODE
        from
        mtl_parameters mp
        $term");
        return $query->result_array();
    }
}
