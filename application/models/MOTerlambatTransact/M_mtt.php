<?php
class M_mtt extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // $this->oracle = $this->load->database('oracle_dev', true);
        $this->oracle = $this->load->database('oracle', true);
        $this->personalia = $this->load->database('personalia', true);
    }

    public function Update($alasan, $nama, $line_id)
    {
      $this->oracle->query("UPDATE
                  mtl_txn_request_lines
              SET
                  attribute12 = '$alasan',
                  attribute13 = '$nama',
                  attribute14 = SYSDATE,
              WHERE line_id = '$line_id'");

      if ($this->oracle->affected_rows() == 1) {
          return 1;
      }else {
          return 0;
      }

    }

    public function get()
    {
      $res = $this->oracle->query("SELECT mtrl.line_id ,mtrh.REQUEST_NUMBER, mtrh.CREATION_DATE,
                                    to_char( mtrh.CREATION_DATE, 'HH24:MI:SS' ) waktu,
                                    mtrh.attribute11 DELIVERY_DATE,
                                    mtrh.ATTRIBUTE12 DELIVERY_TIME,
                                    mtrh.ATTRIBUTE10 RECEIVED_BY,
                                    mtrl.FROM_SUBINVENTORY_CODE ,
                                    KHS_GET_DIFF(to_date(mtrh.ATTRIBUTE11||mtrh.ATTRIBUTE12,'DD-MON-YYHH24:MI:SS'),sysdate) durasi,
                                    mil.SEGMENT1 FROM_LOCATOR,
                                    msib.SEGMENT1,
                                    msib.DESCRIPTION,
                                    mtrl.QUANTITY,
                                    nvl(mtrl.QUANTITY_DELIVERED,0) QUANTITY_DELIVERED,
                                    ml.MEANING STATUS,
                                    CASE
                                      WHEN ROUND((sysdate-to_date(mtrh.ATTRIBUTE11||mtrh.ATTRIBUTE12,'DD-MON-YYHH24:MI:SS'))*24) >= 1 THEN 1
                                      ELSE 0
                                    END kode,
                                    mtrl.ATTRIBUTE12 ALASAN
                                    from mtl_txn_request_headers mtrh,
                                    mtl_txn_request_lines mtrl,
                                    mtl_system_items_b msib,
                                    mfg_lookups ml,
                                    mtl_item_locations mil
                                    where mtrh.HEADER_ID = mtrl.HEADER_ID
                                    and mtrl.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
                                    and mtrl.ORGANIZATION_ID = msib.ORGANIZATION_ID
                                    and mtrh.HEADER_STATUS = ml.LOOKUP_CODE
                                    and ml.LOOKUP_TYPE = 'MTL_TXN_REQUEST_STATUS'
                                    and mtrl.FROM_LOCATOR_ID = mil.INVENTORY_LOCATION_ID(+)
                                    and mtrl.LINE_STATUS = 3
                                    and mtrl.TO_SUBINVENTORY_CODE = 'FG-TKS'
                                    and mtrl.FROM_SUBINVENTORY_CODE not like 'SS-ODM'
                                    -- and ROUND((sysdate-to_date(mtrh.ATTRIBUTE11||mtrh.ATTRIBUTE12,'DD-MON-YYHH24:MI:SS'))*24) >= 1
                                    order by mtrh.CREATION_DATE asc, mtrl.ATTRIBUTE12 asc")->result_array();
      return $res;
    }

    public function getByLineID($line_id)
    {
      $res = $this->oracle->query("SELECT mtrl.line_id ,mtrh.REQUEST_NUMBER, mtrh.CREATION_DATE,
                                    to_char( mtrh.CREATION_DATE, 'HH24:MI:SS' ) waktu,
                                    mtrh.attribute11 DELIVERY_DATE,
                                    mtrh.ATTRIBUTE12 DELIVERY_TIME,
                                    mtrh.ATTRIBUTE10 RECEIVED_BY,
                                    mtrl.FROM_SUBINVENTORY_CODE ,
                                    KHS_GET_DIFF(to_date(mtrh.ATTRIBUTE11||mtrh.ATTRIBUTE12,'DD-MON-YYHH24:MI:SS'),sysdate) durasi,
                                    mil.SEGMENT1 FROM_LOCATOR,
                                    msib.SEGMENT1,
                                    msib.DESCRIPTION,
                                    mtrl.QUANTITY,
                                    nvl(mtrl.QUANTITY_DELIVERED,0) QUANTITY_DELIVERED,
                                    ml.MEANING STATUS,
                                    CASE
                                      WHEN ROUND((sysdate-to_date(mtrh.ATTRIBUTE11||mtrh.ATTRIBUTE12,'DD-MON-YYHH24:MI:SS'))*24) >= 1 THEN 1
                                      ELSE 0
                                    END kode,
                                    mtrl.ATTRIBUTE12 ALASAN
                                    from mtl_txn_request_headers mtrh,
                                    mtl_txn_request_lines mtrl,
                                    mtl_system_items_b msib,
                                    mfg_lookups ml,
                                    mtl_item_locations mil
                                    where mtrh.HEADER_ID = mtrl.HEADER_ID
                                    and mtrl.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
                                    and mtrl.ORGANIZATION_ID = msib.ORGANIZATION_ID
                                    and mtrh.HEADER_STATUS = ml.LOOKUP_CODE
                                    and ml.LOOKUP_TYPE = 'MTL_TXN_REQUEST_STATUS'
                                    and mtrl.FROM_LOCATOR_ID = mil.INVENTORY_LOCATION_ID(+)
                                    and mtrl.LINE_STATUS = 3
                                    and mtrl.TO_SUBINVENTORY_CODE = 'FG-TKS'
                                    and mtrl.FROM_SUBINVENTORY_CODE not like 'SS-ODM'
                                    -- and ROUND((sysdate-to_date(mtrh.ATTRIBUTE11||mtrh.ATTRIBUTE12,'DD-MON-YYHH24:MI:SS'))*24) >= 1
                                    and mtrl.line_id = '$line_id'
                                    order by mtrh.CREATION_DATE asc")->row_array();
      return $res['ALASAN'];

    }


}
