<?php
class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle_dev', true);
    }

    public function getSeksi($value='')
    {
      return $this->oracle->query("SELECT ffv.FLEX_VALUE as COST_CENTER,
                              		ffvt.DESCRIPTION ||' - '||kbbc.LOCATION as PEMAKAI,
                              		ffv.ATTRIBUTE10,
                              		kbbc.BRANCH kode_cabang
                              		,kbbc.COST_CENTER_TYPE
                              	      from fnd_flex_values ffv,
                              		fnd_flex_values_TL ffvt,
                              		khs_bppbg_branch_cc kbbc
                              	      where ffv.FLEX_VALUE_SET_ID=1013709
                              		and ffv.ATTRIBUTE10 != ' '
                              		and ffv.FLEX_VALUE_ID=ffvt.FLEX_VALUE_ID
                              		AND ffv.END_DATE_ACTIVE IS NULL
                              		and ffv.ENABLED_FLAG = 'Y'
                              		and ffv.FLEX_VALUE = kbbc.COST_CENTER
                              		and kbbc.COST_CENTER_TYPE = 'SEKSI' -- 'RESOURCE'
                              	  order by ffv.FLEX_VALUE")->result_array();
    }

    public function item($d, $subinv, $locator, $org_id)
    {
      $sql = "SELECT msi.organization_id, msi.secondary_inventory_name subinv,
                   msi.description, mil.segment1 locators, msib.inventory_item_id,
                   msib.segment1, msib.description item_desc,
                   NVL (SUM (moqd.transaction_quantity), 0) oh, msib.primary_uom_code
              FROM mtl_secondary_inventories msi,
                   mtl_item_locations mil,
                   mtl_system_items_b msib,
                   mtl_onhand_quantities_detail moqd
             WHERE msi.disable_date IS NULL
               -- AND msi.organization_id IN (101, 102)
               AND msi.organization_id = mil.organization_id(+)
               AND msi.secondary_inventory_name = mil.subinventory_code(+)
               AND msi.organization_id = msib.organization_id
               AND msib.organization_id = moqd.organization_id
               AND msi.secondary_inventory_name = moqd.subinventory_code
               -- AND mil.inventory_location_id = moqd.locator_id
               AND msib.inventory_item_id = moqd.inventory_item_id
               AND msi.organization_id = $org_id --102
               AND msi.secondary_inventory_name = '$subinv' --'AFVAL-DM'
               AND NVL (mil.segment1, 0) IN (NVL ('$locator', NVL (mil.segment1, 0))) --'ASSEMBLING'
               AND (msib.segment1 LIKE '%$d%'
                    OR msib.description LIKE '%$d%')
          GROUP BY msi.organization_id,
                   msi.secondary_inventory_name,
                   msi.description,
                   mil.segment1,
                   msib.inventory_item_id,
                   msib.segment1,
                   msib.description,
                   msib.primary_uom_code
          ORDER BY msi.secondary_inventory_name";
      //tambah segment1 untuk liat munculin  berdasrkan itiem_code;
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getItemTujuan($value='')
    {
      return $this->oracle->query("SELECT msib.INVENTORY_ITEM_ID, msib.SEGMENT1, msib.DESCRIPTION from mtl_system_items_b msib
                                  where msib.SEGMENT1 like 'DA%'
                                  and msib.ORGANIZATION_ID = 102
                                  and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'")->result_array();
    }

    public function item_pbbns($d)
    {
      $sql = "SELECT msib.INVENTORY_ITEM_ID, msib.segment1, msib.description, msib.primary_uom_code, msib.organization_id
              FROM mtl_system_items_b msib
             WHERE msib.organization_id IN (101, 102)
               AND msib.inventory_item_status_code = 'Active'
               AND (msib.segment1 LIKE '%$d%'
                    OR msib.description LIKE '%$d%')
              ORDER BY 1";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function get_io($value='')
    {
      return $this->oracle->query("SELECT mp.ORGANIZATION_ID, mp.ORGANIZATION_CODE
                                   FROM mtl_parameters mp
                                   order by 1")->result_array();
    }

    public function SubInv($io)
    {
      return $this->oracle->query("SELECT msi.organization_id, msi.secondary_inventory_name subinv,
                                           msi.description
                                      FROM mtl_secondary_inventories msi
                                     WHERE msi.disable_date IS NULL AND msi.organization_id = $io
                                  ORDER BY msi.secondary_inventory_name")->result_array();
    }

    public function locator($subinv)
    {
      return $this->oracle->query("SELECT mil.inventory_location_id, mil.segment1 LOCATOR
                                   FROM mtl_item_locations mil
                                   WHERE mil.subinventory_code = '$subinv'
                                   AND mil.organization_id IN (101, 102)
                                   AND mil.disable_date IS NULL
                                   ORDER BY 1")->result_array();
    }

    public function onhand($org_id, $inv_id, $subinv, $loc_id)
    {
      // if (!empty($loc_id)) {
      //   return $this->oracle->query("SELECT khs_inv_qty_oh($org_id, $inv_id, '$subinv', $loc_id, null) onhand FROM dual")->result_array();
      // }else {
      //   return $this->oracle->query("SELECT khs_inv_qty_oh($org_id, $inv_id, '$subinv', null, null) onhand FROM dual")->result_array();
      // }
    }

    public function generate_doc_num($value='')
    {
      $data = $this->oracle->query("SELECT TRIM (   TO_CHAR (SYSDATE, 'RRMM')
                                               || LPAD (apps.khs_no_document_pkb_s.NEXTVAL, 4, '0')
                                            ) document_number
                                    FROM DUAL")->row_array();
      return $data['DOCUMENT_NUMBER'];
    }

    public function no_document($value='')
    {
      return $this->oracle->query("SELECT DISTINCT DOCUMENT_NUMBER FROM KHS_PENGIRIMAN_BARANG_BEKAS ORDER BY 1 DESC")->result_array();
    }

    public function detail_document($doc_no)
    {
      return $this->oracle->query("SELECT pbb.*,
                                           msib.description,
                                      	  (SELECT NVL(mil.segment1, NULL) FROM mtl_item_locations mil
                                        	 WHERE mil.inventory_location_id = pbb.id_locator
                                        	 AND mil.disable_date IS NULL) locator
                                      FROM KHS_PENGIRIMAN_BARANG_BEKAS pbb
                                      	 ,mtl_system_items_b msib
                                      WHERE pbb.DOCUMENT_NUMBER = '$doc_no'
                                      AND msib.INVENTORY_ITEM_ID = pbb.INVENTORY_ITEM_ID
                                      AND msib.organization_id = pbb.org_id
                              		AND msib.inventory_item_status_code = 'Active'
                              	 	AND SUBSTR (msib.segment1, 1, 1) <> 'J'
                                  ORDER BY pbb.id_pbb ASC")->result_array();
    }

    public function ambilItem($id)
    {
      return $this->oracle->query("SELECT pbb.berat_timbang, pbb.no_urut_timbang, msib.segment1, msib.description
        FROM KHS_PENGIRIMAN_BARANG_BEKAS pbb, mtl_system_items_b msib
        WHERE ID_PBB = $id
        AND msib.INVENTORY_ITEM_ID = pbb.INVENTORY_ITEM_ID
        AND msib.organization_id = 102")->row_array();
    }

    public function cek_apakah_sudah_trasact($doc_no)
    {
      return $this->oracle->query("SELECT document_number from KHS_PENGIRIMAN_BARANG_BEKAS where DOCUMENT_NUMBER = '$doc_no' AND STATUS = 'SUDAH TRANSACT'")->row_array();
    }

    /*
    | -------------------------------------------------------------------------
    | RUN PROCEDURE
    | -------------------------------------------------------------------------
    */
    function pbb_api_transact($no_doc)
    {
        $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
        // $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');

        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // exec khs_ascp_estimasi_kebutuhan (4, 66452, 102);
        $sql =  "BEGIN khs_miscellaneous_trial($no_doc); END;";

        //Statement does not change
        $stmt = oci_parse($conn, $sql);
        // oci_bind_by_name($stmt, ':P_PARAM1', $rm);
        //---
        // if (!$data) {
        // $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        // trigger_error(htmlentities($e['message']), E_USER_ERROR);
        // }
        //---
        // But BEFORE statement, Create your cursor
        $cursor = oci_new_cursor($conn);

        // Execute the statement as in your first try
        oci_execute($stmt);

        // and now, execute the cursor
        oci_execute($cursor);
    }

    public function insert_misc_issue_receipt($master)
    {
      $doc_num = $master['doc_num'];
      $berat_timbang = $master['berat_timbang']; // jumlah berat_timbang harus sama dengan $data dan id
      $data = $this->oracle->query("SELECT * FROM KHS_PENGIRIMAN_BARANG_BEKAS WHERE DOCUMENT_NUMBER = '$doc_num' AND STATUS IS NULL ORDER BY id_pbb ASC")->result_array();
      // echo "<pre>";print_r($data);
      // die;
      foreach ($data as $key => $value) {
        $this->oracle->query("INSERT INTO khs_misc_issue_receipt
                              (
                              no_dokumen,
                              account,
                              cost_center,
                              item_id_asal,
                              qty_asal,
                              io_asal,
                              subinv_asal,
                              locator_asal,
                              item_id_tujuan,
                              qty_tujuan,
                              io_tujuan,
                              subinv_tujuan,
                              locator_tujuan
                              )
                              VALUES
                              (
                              '{$value['DOCUMENT_NUMBER']}', --' no_dokumen
                              '511101', --' account
                              '{$value['COST_CENTER']}', --' cost_center
                              {$value['INVENTORY_ITEM_ID']}, --' item_id_asal
                              {$value['JUMLAH']}, --' qty_asal
                              {$value['ORG_ID']}, --' io_asal
                              '{$value['SUB_INVENTORY']}', --' subinv_asal
                              '{$value['ID_LOCATOR']}', --' locator_asal
                              {$master['item_id_tujuan']}, --' item_id_tujuan
                              {$berat_timbang[$key]}, --' qty_tujuan
                              102, --' io_tujuan
                              '{$master['subinv_tujuan']}', --' subinv_tujuan
                              '{$master['locator_tujuan']}'--' locator_tujuan
                             )");
      }
      if ($this->oracle->affected_rows()) {
        return 1;
      }else {
        return 0;
      }


    }

    /*
    | -------------------------------------------------------------------------
    | TRANSACT AREA
    | -------------------------------------------------------------------------
    */
    public function pbb_transact($doc_no)
    {
      $this->pbb_api_transact($doc_no); // run api

      $this->oracle->where('DOCUMENT_NUMBER', $doc_no)->update('KHS_PENGIRIMAN_BARANG_BEKAS', ['STATUS' => "SUDAH TRANSACT"]);
      if ($this->oracle->affected_rows()) {
        return 1;
      }else {
        return 0;
      }
    }

    /*
    | -------------------------------------------------------------------------
    | UPDATE BERAT TIMBANG
    | -------------------------------------------------------------------------
    */
    public function updateBeratTimbang($post)
    {
      $this->oracle->where('ID_PBB', $post['ID_PBB'])->update('KHS_PENGIRIMAN_BARANG_BEKAS', $post);
      if ($this->oracle->affected_rows()) {
        return 1;
      }else {
        return 0;
      }
    }

    /*
    | -------------------------------------------------------------------------
    | INSERT PBB STOK
    | -------------------------------------------------------------------------
    */
    public function insertPBBS($data)
    {
      if (!empty($data)) {
        $subinv_ = explode(' - ', $data['subinv']);
        $subinv = $subinv_[0];
        $org_id = $subinv_[1];

        $uhuk = explode(' ~ ', $data['seksi_n_cc']);
        $seksi = $uhuk[0];
        $cost_center = $uhuk[1];

        if (!empty($data['locator'])) {
          $locator = $data['locator'];
        }else {
          $locator = NULL;
        }

        $doc_no = $this->generate_doc_num();

        foreach ($data['item_code'] as $key => $value) {
          $item = explode(' - ', $value);
          $item_code = $item[0];
          $uom = $item[1];
          $inv_item_id = $item[2];
          $onhand = $item[3];
          $jumlah = $data['jumlah'][$key];

          $this->oracle->query("INSERT INTO KHS_PENGIRIMAN_BARANG_BEKAS (DOCUMENT_NUMBER
                                 ,TYPE_DOCUMENT
                                 ,SEKSI
                                 ,COST_CENTER
                                 ,SUB_INVENTORY
                                 ,ID_LOCATOR
                                 ,INVENTORY_ITEM_ID
                                 ,ITEM
                                 ,ONHAND
                                 ,JUMLAH
                                 ,UOM
                                 ,CREATED_DATE
                                 ,BERAT_TIMBANG
                                 ,ORG_ID
                                 )
                                VALUES ('$doc_no'
                                       ,'PBB-S'
                                       ,'$seksi'
                                       ,'$cost_center'
                                       ,'$subinv'
                                       ,'$locator'
                                       ,'$inv_item_id'
                                       ,'$item_code'
                                       ,'$onhand'
                                       ,'$jumlah'
                                       ,'$uom'
                                       ,SYSDATE
                                       ,NULL
                                       ,$org_id
                                      )
                                  ");
        }

        if ($this->oracle->affected_rows() == 1) {
          return $doc_no;
        }else {
          echo "<h1>Koneksi Terputus...</h1>";
          die;
        }
      }

    }

    /*
    | -------------------------------------------------------------------------
    | INSERT PBB NON STOK
    | -------------------------------------------------------------------------
    */
    public function insertPBBNS($data)
    {
      if (!empty($data)) {
        $uhuk = explode(' ~ ', $data['seksi_n_cc']);
        $seksi = $uhuk[0];
        $cost_center = $uhuk[1];

        $doc_no = $this->generate_doc_num();

        foreach ($data['item_code'] as $key => $value) {

          $item = explode(' - ', $value);
          $item_code = $item[0];
          $uom = $item[1];
          $inv_item_id = $item[2];
          $org_id = $item[3];

          $this->oracle->query("INSERT INTO KHS_PENGIRIMAN_BARANG_BEKAS (DOCUMENT_NUMBER
                                 ,TYPE_DOCUMENT
                                 ,SEKSI
                                 ,COST_CENTER
                                 ,SUB_INVENTORY
                                 ,ID_LOCATOR
                                 ,INVENTORY_ITEM_ID
                                 ,ITEM
                                 ,ONHAND
                                 ,JUMLAH
                                 ,UOM
                                 ,CREATED_DATE
                                 ,BERAT_TIMBANG
                                 ,ORG_ID
                                 )
                                VALUES ('$doc_no'
                                       ,'PBB-NS'
                                       ,'$seksi'
                                       ,'$cost_center'
                                       ,NULL
                                       ,NULL
                                       ,'$inv_item_id'
                                       ,'$item_code'
                                       ,NULL
                                       ,'{$data['jumlah'][$key]}'
                                       ,'$uom'
                                       ,SYSDATE
                                       ,NULL
                                       ,$org_id
                                      )
                                  ");
        }

        if ($this->oracle->affected_rows() == 1) {
          return $doc_no;
        }else {
          echo "<h1>Koneksi Terputus...</h1>";
          die;
        }
      }

    }


}
