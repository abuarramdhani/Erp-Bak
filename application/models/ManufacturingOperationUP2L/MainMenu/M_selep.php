<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_selep extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle_dev', TRUE);
    }

    // baru dari mb div
    public function get_io_subinv_locator_tujuan($batch_no)
    {
      return $this->oracle->query("SELECT.ORGANIZATION_CODE org_code
                                        ,fmd.ATTRIBUTE1 org_id
                                        ,fmd.ATTRIBUTE2 subinventory
                                        ,mil.SEGMENT1 locator_code
                                        ,fmd.ATTRIBUTE3 locator_id
                                  from gme_batch_header gbh
                                      ,fm_matl_dtl fmd
                                      ,mtl_parameters mp
                                      ,mtl_item_locations mil
                                  where fmd.FORMULA_ID = gbh.FORMULA_ID
                                    and mp.ORGANIZATION_ID = fmd.ORGANIZATION_ID
                                    and mil.INVENTORY_LOCATION_ID = fmd.ATTRIBUTE3
                                    and gbh.BATCH_NO = '$batch_no'
                                    and fmd.LINE_TYPE = 1")->row_array();
    }

    public function get_io($value='')
    {
      return $this->oracle->query("SELECT mp.ORGANIZATION_ID, mp.ORGANIZATION_CODE
                                   FROM mtl_parameters mp
                                   order by 1")->result_array();
    }

    public function generate_no_kib($batch_no)
    {
      return $this->oracle->query("SELECT  frh.ROUTING_CLASS|| TO_CHAR (SYSDATE, 'RRMM')
                  || LPAD (KHS_CREATE_MO_SEQ.NEXTVAL, 5, '0') NO_KIB
                  FROM GME_BATCH_HEADER gbh,
                  fm_rout_hdr frh
                  WHERE gbh.ROUTING_ID = frh.ROUTING_ID
                  AND gbh.BATCH_NO = '$batch_no'")->row_array();
    }

    //SCHEDULED_QUANTITY => qty handling => misal handling 205 SCHEDULED_QUANTITY = 50 jadi 50 50 50 50 5
    public function get_data_kib($batch_no)
    {
      return $this->oracle->query("SELECT gbh.ORGANIZATION_ID ,
                                  frh.ROUTING_CLASS ROUTING_DEPT_CLASS ,
                                  gbh.PLAN_START_DATE PLANED_DATE,
                                  bcs.SHIFT_NUM PLANSHIFT_NUM,
                                  gob.OPRN_ID,
                                  gmd.INVENTORY_ITEM_ID PRIMARY_ITEM_ID,
                                  gmd.PLAN_QTY SCHEDULED_QUANTITY,
                                  -- NVL(NULL,gmd.PLAN_QTY) QTY_HANDLING,
                                  frh.ROUTING_ID DEPARTMENT_ID,
                                  mp.ORGANIZATION_CODE KIB_GROUP,
                                  'N' inventory_trans_flag,
                                  NULL qty_transaction,
                                  gbh.BATCH_ID order_id,
                                  NULL flag_cancel,
                                  sysdate creation_date,
                                  NULL BATCHSTEP_ID,
                                  -- 'INT-FDY' from_subinventory_code,
                                  '' from_locator_id
                                  FROM GME_BATCH_HEADER gbh ,
                                  fm_rout_hdr frh,
                                  gme_material_details gmd ,
                                  mtl_system_items_b msib ,
                                  mtl_item_categories mic ,
                                  mtl_categories_b mcb ,
                                  gme_batch_steps gbs ,
                                  gmd_operations_b gob ,
                                  gme_batch_step_activities gbsa ,
                                  gmd_operation_activities goa ,
                                  gme_batch_step_resources gbsr ,
                                  cr_rsrc_mst_tl crmt ,
                                  cr_rsrc_mst_b crmb,
                                  bom_calendar_shifts bcs,
                                  GME_BATCH_HEADER gbh2,
                                  fm_rout_hdr frh2,
                                  mtl_parameters mp
                                  WHERE gbh.BATCH_ID = gmd.BATCH_ID
                                  AND gbh.ROUTING_ID = frh.ROUTING_ID
                                  AND gmd.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
                                  AND gmd.ORGANIZATION_ID = msib.ORGANIZATION_ID
                                  AND msib.INVENTORY_ITEM_ID = mic.INVENTORY_ITEM_ID
                                  AND msib.ORGANIZATION_ID = mic.ORGANIZATION_ID
                                  AND mic.CATEGORY_ID = mcb.CATEGORY_ID
                                  --AND mic.CATEGORY_SET_ID = 1100000042
                                  AND gmd.LINE_TYPE = 1
                                  AND gbh.BATCH_ID = gbs.BATCH_ID
                                  AND gbs.OPRN_ID = gob.OPRN_ID
                                  AND gbh.BATCH_ID = gbsa.BATCH_ID
                                  AND gbsa.OPRN_LINE_ID = goa.OPRN_LINE_ID
                                  AND gob.OPRN_ID = goa.OPRN_ID
                                  AND gbs.BATCHSTEP_ID = gbsa.BATCHSTEP_ID
                                  AND gbs.BATCH_ID = gbsr.BATCH_ID
                                  AND gbs.BATCHSTEP_ID = gbsr.BATCHSTEP_ID
                                  AND gbsa.BATCHSTEP_ACTIVITY_ID = gbsr.BATCHSTEP_ACTIVITY_ID
                                  AND gbsr.RESOURCES = crmb.RESOURCES
                                  AND gbsr.RESOURCES = crmt.RESOURCES
                                  --AND crmb.resource_class = decode(crmb.resource_class,'OPERATOR',crmb.resource_class,'MESIN')
                                  AND gbh.ORGANIZATION_ID = mp.ORGANIZATION_ID
                                  AND gbh.BATCH_NO = '$batch_no' --
                                  AND khs_shift (TRUNC(gbh.plan_start_date)) = bcs.shift_num
                                  AND gbh2.ROUTING_ID = frh2.ROUTING_ID
                                  AND gbh2.BATCH_ID = gbh.BATCH_ID
                                  --and msib.INVENTORY_ITEM_ID = ''
                                  AND rownum = 1")->result_array();
    }

    public function insertKIB($data)
    {
      $this->oracle->query("INSERT INTO khs_kib_kanban(
                                        ORGANIZATION_ID,
                                        ROUTING_DEPT_CLASS,
                                        PLANED_DATE,
                                        PLANSHIFT_NUM,
                                        OPRN_ID,
                                        PRIMARY_ITEM_ID,
                                        SCHEDULED_QUANTITY,
                                        QTY_KIB,
                                        DEPARTMENT_ID,
                                        KIBCODE,
                                        KIB_GROUP,
                                        INVENTORY_TRANS_FLAG,
                                        QTY_TRANSACTIONS,
                                        ORDER_ID,
                                        CREATION_DATE,
                                        TO_ORG_ID,
                                        TO_SUBINVENTORY_CODE,
                                        TO_LOCATOR_ID,
                                        ITEM_STATUS,
                                        FROM_SUBINVENTORY_CODE,
                                        FROM_LOCATOR_ID,
                                        QTY_HANDLING,
                                        VERIFY_DATE,
                                        KETERANGAN,
                                        PRINT_FLAG
                                     )
                            VALUES(
                              '{$data[0]['ORGANIZATION_ID']}',
                              '{$data[0]['ROUTING_DEPT_CLASS']}',
                              '{$data[0]['PLANED_DATE']}',
                              '{$data[0]['PLANSHIFT_NUM']}',
                              '{$data[0]['OPRN_ID']}',
                              '{$data[0]['PRIMARY_ITEM_ID']}',
                              '{$data[0]['SCHEDULED_QUANTITY']}',
                              '{$data[0]['QTY_SELEP']}', -- tanya lagi
                              '{$data[0]['DEPARTMENT_ID']}',
                              '{$data[0]['NO_KIB']}',
                              '{$data[0]['KIB_GROUP']}',
                              '{$data[0]['INVENTORY_TRANS_FLAG']}',
                              '{$data[0]['QTY_TRANSACTION']}',
                              '{$data[0]['ORDER_ID']}',
                              SYSDATE,
                              '{$data[0]['TO_ORG_ID']}',
                              '{$data[0]['TO_SUBINVENTORY_CODE']}',
                              '{$data[0]['TO_LOCATOR_ID']}',
                              '1',
                              '{$data[0]['FROM_SUBINVENTORY_CODE']}',
                              '{$data[0]['FROM_LOCATOR_ID']}',
                              '{$data[0]['QTY_HANDLING']}',
                              SYSDATE,
                              '{$data[0]['NO_INDUK']}',
                              'N'
                            )");
        if ($this->oracle->affected_rows()) {
          return 1;
        }else {
          return 0;
        }
    }

    public function SubInv($io)
    {
      return $this->oracle->query("SELECT msi.organization_id, msi.secondary_inventory_name subinv,
                                           msi.description
                                      FROM mtl_secondary_inventories msi
                                     WHERE msi.disable_date IS NULL AND msi.organization_id = $io
                                  ORDER BY msi.secondary_inventory_name")->result_array();
    }

    public function batch_completion($no_batch, $qty)
    {
      $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
      // $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');

      if (!$conn) {
          $e = oci_error();
          trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
      }

      $sql = "BEGIN khscreatebatch.batch_completion($no_batch,$qty,5177); END;";

      //Statement does not change
      $stmt = oci_parse($conn, $sql);

      // But BEFORE statement, Create your cursor
      $cursor = oci_new_cursor($conn);

      // Execute the statement as in your first try
      oci_execute($stmt);

      // and now, execute the cursor
      oci_execute($cursor);
    }

    public function check_onhand($no_batch)
    {
      return $this->oracle->query("SELECT gbh.BATCH_NO
                                        ,gmd.INVENTORY_ITEM_ID
                                        ,gmd.SUBINVENTORY
                                        ,msib.SEGMENT1 item
                                        ,msib.DESCRIPTION
                                        ,khs_inv_qty_att(gbh.ORGANIZATION_ID,gmd.INVENTORY_ITEM_ID,gmd.SUBINVENTORY,'','') att
                                        ,gmd.plan_qty
                                        ,khs_inv_qty_att(gbh.ORGANIZATION_ID,gmd.INVENTORY_ITEM_ID,gmd.SUBINVENTORY,'','') - gmd.plan_qty onhand
                                  from gme_batch_header gbh
                                      ,gme_material_details gmd
                                      ,mtl_system_items_b msib
                                  where gbh.BATCH_ID = gmd.BATCH_ID
                                    and msib.INVENTORY_ITEM_ID = gmd.INVENTORY_ITEM_ID
                                    and msib.ORGANIZATION_ID = gmd.ORGANIZATION_ID
                                    and gbh.BATCH_NO = $no_batch
                                    and gmd.LINE_TYPE = -1")->result_array();
    }

    public function create_batch($item, $recipe_no, $recipe_version, $uom, $subinv, $qty)
    {
        $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
        // $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $response_1 = '';
        $response_2 = '';

        $sql = "BEGIN
                khscreatebatch.create_batch(5177,'OPM','$item','$recipe_no',$recipe_version,'$uom',$qty,'$subinv',:param, :reason);
                END;";

        $stmt = oci_parse($conn, $this->removeNewLine($sql));
        oci_bind_by_name($stmt, ':param', $response_1, 512, SQLT_CHR);
        oci_bind_by_name($stmt, ':reason', $response_2, 512, SQLT_CHR);
        oci_execute($stmt);

        $response = [
          'no_batch' => $response_1,
          'reason' => $response_2
        ];

        return $response;
    }

    private function removeNewLine($text)
    {
        return preg_replace('/\s\s+/', ' ', $text);
    }

    public function get_recipe($component_code)
    {
      // return $component_code;
      return $this->oracle->query("SELECT distinct
      gr.RECIPE_ID,
      gr.RECIPE_NO,
      gr.RECIPE_VERSION,
      msib.SEGMENT1 item,
      msib.INVENTORY_ITEM_ID item_id,
      msib.PRIMARY_UOM_CODE uom
      from
      gmd_recipes gr,
      GMD_RECIPE_VALIDITY_RULES grvr,
      FM_FORM_MST ffm,
      FM_MATL_DTL fmd,
      MTL_SYSTEM_items_b MSIB,
      (select msib2.INVENTORY_ITEM_ID, msib2.SEGMENT1, msib2.DESCRIPTION, fmd2.FORMULA_ID
      from FM_MATL_DTL fmd2,
      mtl_system_items_b msib2
      where msib2.INVENTORY_ITEM_ID = fmd2.INVENTORY_ITEM_ID
      and fmd2.ORGANIZATION_ID = msib2.ORGANIZATION_ID
      and fmd2.LINE_TYPE = '-1'
      ) ingr
      where
      gr.FORMULA_ID=ffm.FORMULA_ID
      and ffm.FORMULA_ID=fmd.FORMULA_ID
      and fmd.INVENTORY_ITEM_ID=msib.INVENTORY_ITEM_ID
      and ffm.OWNER_ORGANIZATION_ID=msib.ORGANIZATION_ID
      and gr.RECIPE_STATUS = 700 --status: Approved for General Use
      and gr.RECIPE_ID = grvr.recipe_id
      and fmd.FORMULA_ID = ingr.FORMULA_ID
      and msib.SEGMENT1 = '$component_code'
      and gr.RECIPE_VERSION = 1
      and grvr.END_DATE is null
      order by 2")->result_array();
    }

    public function getSelep()
    {
        $sql = "SELECT * FROM mo.mo_selep ORDER BY extract(month from selep_date) desc, extract(year from selep_date) desc, extract(day from selep_date), shift, job_id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    // DATATABLE SERVERSIDE CORE
    public function selectSelep($data)
    {
      $explode = strtoupper($data['search']['value']);
        $res = $this->db
            ->query(
                "SELECT kdav.*
                FROM
                    (
                    SELECT
                            skdav.*,
                            ROW_NUMBER () OVER (ORDER BY selep_date DESC) as pagination
                        FROM
                            (
                              SELECT mfo.*
                              FROM
                                  (SELECT * FROM mo.mo_selep ORDER BY extract(month from selep_date) desc, extract(year from selep_date) desc, extract(day from selep_date), shift, job_id) mfo
                              WHERE
                                    (
                                      component_code LIKE '%{$explode}%'
                                      OR component_description LIKE '%{$explode}%'
                                      OR selep_date::text LIKE '%{$explode}%'
                                      OR job_id LIKE '%{$explode}%'
                                      OR shift LIKE '%{$explode}%'
                                    )
                            ) skdav

                    ) kdav
                WHERE
                    pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
            )->result_array();

        return $res;
    }

    public function countAllSelep()
    {
      return $this->db->query(
        "SELECT
            COUNT(*) AS \"count\"
        FROM
        (SELECT selep_id FROM mo.mo_selep ORDER BY extract(month from selep_date) desc, extract(year from selep_date) desc, extract(day from selep_date), shift, job_id) kdo"
        )->row_array();
    }

    public function countFilteredSelep($data)
    {
      $explode = strtoupper($data['search']['value']);
      return $this->db->query(
        "SELECT
              COUNT(*) AS \"count\"
            FROM
            (SELECT * FROM mo.mo_selep ORDER BY extract(month from selep_date) desc, extract(year from selep_date) desc, extract(day from selep_date), shift, job_id) kdo
            WHERE
            (
              component_code LIKE '%{$explode}%'
              OR component_description LIKE '%{$explode}%'
              OR selep_date::text LIKE '%{$explode}%'
              OR job_id LIKE '%{$explode}%'
              OR shift LIKE '%{$explode}%'
            )"
        )->row_array();
    }
    // END SERVERSIDE DATATABLE

    public function getSelepById($id)
    {
        $query = $this->db->get_where('mo.mo_selep', array('selep_id' => $id));
        return $query->result_array();
    }

    public function setSelep($data)
    {
        return $this->db->insert('mo.mo_selep', $data);
    }

    public function setAbsensi($data)
    {
        return $this->db->insert('mo.mo_absensi', $data);
    }

    public function updateSelep($data, $id)
    {
        $this->db->where('selep_id', $id);
        $this->db->update('mo.mo_selep', $data);
    }

    public function deleteSelep($id)
    {
        $sql = "DELETE FROM mo.mo_selep WHERE selep_id = '$id'; DELETE FROM mo.mo_quality_control WHERE selep_id_c = '$id';";
        $this->db->query($sql);
    }

    public function getSelepDate($txtStartDate, $txtEndDate)
    {
        $sql = "SELECT * FROM mo.mo_selep WHERE selep_date BETWEEN '$txtStartDate' AND '$txtEndDate' ORDER BY extract(month from selep_date) desc, extract(year from selep_date) desc, extract(day from selep_date)";
        return $this->db->query($sql)->result_array();
    }

    public function getKodeProses($kode_barang)
    {
        $query = $this->db->query("
        SELECT kode_proses FROM mo.mo_master_item WHERE (kode_barang = '$kode_barang')
        order by kode_proses
        ");
        return $query->result_array();
    }

    //     public function report_kib($batch_no)
    //     {
    //       return $this->oracle->query("SELECT gbh.ORGANIZATION_ID,
    //        gbh.BATCH_NO nojob,
    //        mic.CATEGORY_SET_ID,
    //        kk.KIBCODE nokib,
    //        NVL((select gbsa3.ACTIVITY from gme_batch_step_activities gbsa3
    //               where gbsa3.BATCH_ID = gbsa.BATCH_ID
    //               and gbsa3.BATCHSTEP_ID = (select min(gbsa2.BATCHSTEP_ID) from gme_batch_step_activities gbsa2
    //                where gbsa.BATCH_ID = gbsa2.BATCH_ID
    //                and gbsa2.BATCHSTEP_ID > gbsa.BATCHSTEP_ID )),'FINISH') proseslanjut,
    //        msib.SEGMENT1 kodebarang,
    //        gmd.SUBINVENTORY dari,
    //        ffmb.ATTRIBUTE2 ke,
    //        gbh.PLAN_START_DATE tanggal,
    //        mcb.SEGMENT1 kategori,
    //        msib.DESCRIPTION description,
    //        kk.QTY_KIB,
    //        kk.SCHEDULED_QUANTITY,
    //        grb.ROUTING_CLASS,
    //        gbs.OPRN_ID ,
    //        goa.ACTIVITY kodeproses,
    //        gmd.INVENTORY_ITEM_ID,
    //        gmd.PLAN_QTY ,
    //        msib.UNIT_VOLUME qtyhandling,
    //        gbs.OPRN_ID,
    //        gbh.BATCH_ID,
    //        sysdate,
    //        gbs.BATCHSTEP_ID,
    //        substr(bcs.DESCRIPTION,1,7) shift,
    //        goa.OPRN_LINE_ID,
    //        (select lokasi
    //         from khsinvlokasisimpan mil
    //         where mil.SUBINV = gmd.SUBINVENTORY
    //         and   mil.inventory_item_id(+)     = msib.inventory_item_id
    //         ) Lokasi,
    //        floor(7*gor.PROCESS_QTY/gor.RESOURCE_USAGE) target
    // from gme_batch_header gbh,
    //      khs_kib kk,
    //      gme_batch_steps gbs,
    //      gme_material_details gmd,
    //      gmd_routings_b grb,
    //      mtl_system_items_b msib,
    //      gmd_operation_activities goa,
    //         BOM_CALENDAR_SHIFTS bcs,
    //         BOM_SHIFT_TIMES bst,
    //         bom_shift_dates bd,
    //         GMD_OPERATION_RESOURCES  gor,
    //      mtl_item_categories mic,
    //      mtl_categories_b mcb,
    //      fm_form_mst_b ffmb,
    //      gme_batch_step_activities gbsa
    // where gbh.BATCH_ID = gbs.BATCH_ID
    // and gbh.BATCH_ID = gmd.BATCH_ID
    // and gbh.BATCH_ID = kk.ORDER_ID
    // and gbs.BATCHSTEP_ID = kk.BATCHSTEP_ID
    // and gmd.LINE_TYPE = 1
    // and gbh.ROUTING_ID = grb.ROUTING_ID
    // and msib.INVENTORY_ITEM_ID = gmd.INVENTORY_ITEM_ID
    // and msib.ORGANIZATION_ID = gbh.ORGANIZATION_ID
    // and goa.OPRN_ID = gbs.OPRN_ID
    // and gbh.BATCH_NO = '$batch_no'
    //    and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
    // --   and gor.RESOURCES = goa.ACTIVITY
    //    and gor.PRIM_RSRC_IND = 1
    //         and bcs.CALENDAR_CODE='KHS_CAL'
    //         and bcs.CALENDAR_CODE=bst.CALENDAR_CODE
    //         and bcs.SHIFT_NUM=bst.SHIFT_NUM
    //         and bcs.CALENDAR_CODE=bd.CALENDAR_CODE
    //         and bcs.SHIFT_NUM=bd.SHIFT_NUM
    //         --and bd.seq_num is not null
    //         and bcs.SHIFT_NUM = kk.PLANSHIFT_NUM
    //         and to_char(bd.SHIFT_DATE,'ddmmrr') = to_char(gbh.PLAN_START_DATE ,'ddmmrr')
    //             and msib.INVENTORY_ITEM_ID = mic.INVENTORY_ITEM_ID
    //             and mic.ORGANIZATION_ID = msib.ORGANIZATION_ID
    //             and mic.CATEGORY_ID = mcb.CATEGORY_ID
    //             and mic.CATEGORY_SET_ID = 1100000042
    //                 and gbh.FORMULA_ID = ffmb.FORMULA_ID
    //                 and gbsa.BATCH_ID = gbh.BATCH_ID
    //                 and gbsa.BATCHSTEP_ID = gbs.BATCHSTEP_ID")->result_array();
    //     }
}
