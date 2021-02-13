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

    public function item($d)
    {
      $sql = "SELECT msib.INVENTORY_ITEM_ID, msib.segment1, msib.description, msib.primary_uom_code
              FROM mtl_system_items_b msib
             WHERE msib.organization_id = 102
               AND msib.inventory_item_status_code = 'Active'
               AND SUBSTR (msib.segment1, 1, 1) <> 'J'
               AND (msib.segment1 LIKE '%$d%'
                    OR msib.description LIKE '%$d%')
          ORDER BY 1";
      //tambah segment1 untuk liat munculin  berdasrkan itiem_code;
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function SubInv($value='')
    {
      return $this->oracle->query("SELECT DISTINCT msi.secondary_inventory_name subinv, description
                                   FROM mtl_secondary_inventories msi
                                   WHERE msi.disable_date  IS NULL
                                   ORDER BY msi.secondary_inventory_name")->result_array();
    }

    public function locator($subinv)
    {
      return $this->oracle->query("SELECT mil.inventory_location_id, mil.segment1 LOCATOR
                                   FROM mtl_item_locations mil
                                   WHERE mil.subinventory_code = '$subinv'
                                   AND mil.disable_date IS NULL
                                   ORDER BY 1")->result_array();
    }

    public function onhand($org_id, $inv_id, $subinv, $loc_id)
    {
      if (!empty($loc_id)) {
        return $this->oracle->query("SELECT khs_inv_qty_oh($org_id, $inv_id, '$subinv', $loc_id, null) onhand FROM dual")->result_array();
      }else {
        return $this->oracle->query("SELECT khs_inv_qty_oh($org_id, $inv_id, '$subinv', null, null) onhand FROM dual")->result_array();
      }
    }

    public function generate_doc_num($value='')
    {
      $data = $this->oracle->query("SELECT TRIM ( TO_CHAR (SYSDATE, 'RRMM')
                                           || LPAD (khs_pengiriman_barang_bekas_s.NEXTVAL, 4, '0')
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
                                      AND msib.organization_id = 102
                              		AND msib.inventory_item_status_code = 'Active'
                              	 	AND SUBSTR (msib.segment1, 1, 1) <> 'J'")->result_array();
    }

    public function ambilItem($id)
    {
      return $this->oracle->query("SELECT pbb.berat_timbang, pbb.no_urut_timbang, msib.segment1, msib.description
        FROM KHS_PENGIRIMAN_BARANG_BEKAS pbb, mtl_system_items_b msib
        WHERE ID_PBB = $id
        AND msib.INVENTORY_ITEM_ID = pbb.INVENTORY_ITEM_ID
        AND msib.organization_id = 102")->row_array();
    }

    /*
    | -------------------------------------------------------------------------
    | UPDATE BERAT TIMBANG
    | -------------------------------------------------------------------------
    */
    public function updateBeratTimbang($post)
    {
      $this->oracle->where('ID_PBB', $post['ID_PBB'])->update('KHS_PENGIRIMAN_BARANG_BEKAS', $post);
      if ($this->oracle->affected_rows() == 1) {
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
        $uhuk = explode(' ~ ', $data['seksi_n_cc']);
        $seksi = $uhuk[0];
        $cost_center = $uhuk[1];

        if (!empty($data['locator'])) {
          $locator = $data['locator'];
        }else {
          $locator = NULL;
        }

        $item = explode(' - ', $data['item_code']);
        $item_code = $item[0];
        $uom = $item[1];
        $inv_item_id = $item[2];

        $doc_no = $this->generate_doc_num();

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
                               )
                              VALUES ('$doc_no'
                                     ,'PBB-S'
                                     ,'$seksi'
                                     ,'$cost_center'
                                     ,'{$data['subinv']}'
                                     ,'$locator'
                                     ,'$inv_item_id'
                                     ,'$item_code'
                                     ,'{$data['onhand']}'
                                     ,'{$data['jumlah']}'
                                     ,'$uom'
                                     ,SYSDATE
                                     ,NULL
                                    )
                                ");
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

        foreach ($data['item_code'] as $key => $item_code) {

          $item = explode(' - ', $item_code);
          $item_code = $item[0];
          $uom = $item[1];
          $inv_item_id = $item[2];

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
