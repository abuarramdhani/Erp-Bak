<?php
class M_monitoringdo extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
        // $this->oracle = $this->load->database('oracle_dev', true);

        $subinv = $this->session->datasubinven;
    }

    public function runapi_interorg($tipe,$request_number,$org,$subinv)
    {
        // echo "BEGIN APPS.KHS_INTERORG_SPB ('$tipe', '$request_number', $org, '$subinv'); END;";
        // $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
        $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        if ($tipe == 'SPB KIT') {
          $sql = "BEGIN APPS.KHS_INTERORG_SPB ('$tipe', '$request_number', $org, '$subinv'); END;";
        }else {
          $sql = "BEGIN APPS.KHS_INTERORG_SPB ('$tipe', '$request_number', NULL, NULL); END;";
        }

        //Statement does not change
        $stmt = oci_parse($conn, $sql);
        // oci_bind_by_name($stmt, ':P_PARAM1', $rm);

        // But BEFORE statement, Create your cursor
        $cursor = oci_new_cursor($conn);

        // Execute the statement as in your first try
        oci_execute($stmt);

        // and now, execute the cursor
        oci_execute($cursor);
    }

    public function subinv_spbkit($org, $term)
    {
      $term = strtoupper($term);
      return $this->oracle->query("SELECT msi.secondary_inventory_name subinv
                                      FROM mtl_secondary_inventories msi
                                     WHERE msi.organization_id = $org
                                       AND msi.disable_date IS NULL
                                       AND msi.reservable_type = 1
                                       AND msi.secondary_inventory_name NOT LIKE 'STAG%'
                                       AND msi.secondary_inventory_name NOT LIKE 'KELUAR%'
                                       AND msi.secondary_inventory_name NOT LIKE 'KLR%'
                                       AND msi.secondary_inventory_name LIKE '%$term%'
                                  ORDER BY 1 ASC")->result_array();
    }

    public function org_spbkit($rn)
    {
      return $this->oracle->query("SELECT DISTINCT kim.transaction_source_name, mp.organization_id,
                mp.organization_code
           FROM khs_inv_mtltransactions kim, mtl_parameters mp
          WHERE REPLACE (kim.REFERENCE, 'IO : ', '') = mp.organization_id
            AND kim.transaction_source_name = '$rn'")->result_array();
    }

    public function closeline($header_id)
    {
      $this->oracle->query("UPDATE mtl_txn_request_lines mtrl
                             SET mtrl.line_status = 5
                           WHERE mtrl.header_id = $header_id
                             AND mtrl.line_status IN (3, 7)
                             AND mtrl.quantity_delivered <> 0
                             AND mtrl.quantity_delivered IS NOT NULL");
      if ($this->oracle->affected_rows()) {
        return 1;
      }else {
        return 0;
      }
    }

    public function cekDObukan($rn)
    {
      $res = $this->oracle->query("SELECT distinct
                                         mtrh.REQUEST_NUMBER
                                        ,case when (select distinct to_char(wdd.BATCH_ID)
                                                      from wsh_delivery_details wdd
                                                     where to_char(wdd.BATCH_ID) = mtrh.REQUEST_NUMBER) = mtrh.REQUEST_NUMBER
                                              then 'DO'
                                              else 'SPB'
                                         end tipe
                                        ,mtrh.ATTRIBUTE4
                                  from mtl_txn_request_headers mtrh
                                  where mtrh.REQUEST_NUMBER = '$rn'")->result_array();
      return $res;
    }

    public function petugas($data)
    {
        $sql = "SELECT
                  employee_code,
                  employee_name
                from
                  er.er_employee_all
                where
                  resign = '0'
                  and (employee_code like '%$data%'
                  or employee_name like '%$data%')
                order by
                  1";

        $response = $this->db->query($sql)->result_array();
        // echo "<pre>";
        // print_r($response);
        // die;
        return $response;
    }

    public function cekapi()
    {
        return $this->session->datasubinven;
    }

    public function updatePlatnumber($data, $rm, $hi)
    {
        $sql = "UPDATE khs_person_delivery
                   SET plat_number = '$data[PLAT_NUMBER]',
                       delivery_flag = '$data[DELIVERY_FLAG]'
                 WHERE request_number = '$rm' AND header_id = '$hi'";
        $query = $this->oracle->query($sql);
        return $sql;
    }

    public function insertDOCetak($data)
    {
        $ip = $this->input->ip_address();
        $sql = "INSERT INTO khs_cetak_do
                            (request_number, order_number, creation_date, nomor_cetak, ip_address)
                     VALUES ('$data[REQUEST_NUMBER]', '$data[ORDER_NUMBER]', SYSDATE, '$data[NOMOR_CETAK]', '$ip')";

        if (!empty($data)) {
            $response = $this->oracle->query($sql);
        } else {
            $response = array(
              'success' => false,
              'message' => 'data is empty, cannot do this action',
              'data' => $data
            );
            die;
        }

        return $response;
    }


    public function updateCetak($id)
    {
        $sql = "UPDATE khs_detail_dospb kdd
                   SET kdd.status = 'C'
                 WHERE kdd.request_number = '$id'
                   AND kdd.status = 'T'";
        $query = $this->oracle->query($sql);

        return $query;
    }

    public function sudah_cetak_blm($id)
    {
      return $this->oracle->query("SELECT status FROM khs_detail_dospb WHERE request_number = '$id'")->row_array();
      // return ['STATUS' => 'T'];
    }

    public function cek_interog_blm($rn)
    {
      return $this->oracle->query("SELECT mtrh.attribute3
                                    FROM mtl_txn_request_headers mtrh
                                   WHERE mtrh.request_number = '$rn' AND mtrh.attribute3 IS NOT NULL")->row_array();
    }

    public function getsubinvksd($value='')
    {
      return $this->oracle->query("SELECT *
                                      FROM khs_subinventory_do ksd
                                     WHERE ksd.tipe = 'UNIT'
                                  ORDER BY 2")->result_array();
    }


    public function GetSudahCetakCekFoCount()
    {
        $sql = "SELECT DISTINCT mtrh.request_number, kpd.person_id petugas
                           FROM hz_cust_site_uses_all hcsua,
                                hz_party_sites hps,
                                hz_locations hzl,
                                hz_cust_acct_sites_all hcas,
                                hz_parties hzp,
                                hz_cust_accounts hca,
                                oe_order_headers_all ooha,
                                oe_order_lines_all oola,
                                wsh_delivery_details wdd,
                                mtl_txn_request_headers mtrh,
                                mtl_txn_request_lines mtrl,
                                khs_approval_do kad,
                                khs_person_delivery kpd,
                                khs_delivery_temp kdt,
                                khs_cetak_do kcd
                          WHERE ooha.header_id = oola.header_id
                            --
                            AND wdd.source_header_number = ooha.order_number
                            --
                            AND kad.no_do = mtrh.request_number
                            --
                            AND kdt.header_id = kpd.header_id
                            AND kcd.request_number = kpd.request_number
                            AND kcd.request_number = mtrh.request_number
                            AND 1 =
                                   CASE
                                      WHEN kdt.serial_status IN ('NON SERIAL', 'SERIAL')
                                      AND kpd.delivery_flag = 'Y'
                                      AND kdt.flag = 'S'
                                         THEN 1                                 --'SUDAH MUAT'
                                   END
                            --
                            AND mtrh.header_id = mtrl.header_id
                            AND mtrh.request_number = TO_CHAR (wdd.batch_id)
                            --
                            AND ooha.sold_to_org_id = hca.cust_account_id(+)
                            AND hca.party_id = hzp.party_id(+)
                            AND ooha.ship_to_org_id = hcsua.site_use_id(+)
                            AND hcsua.cust_acct_site_id = hcas.cust_acct_site_id(+)
                            AND hcas.party_site_id = hps.party_site_id(+)
                            AND hps.location_id = hzl.location_id(+)
                       ORDER BY kpd.person_id, mtrh.request_number";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }


    public function DeleteDOtampung($rm, $ip)
    {
        if (!empty($rm)) {
            if (!empty($ip)) {
                $this->oracle->where('REQUEST_NUMBER', $rm);
                $this->oracle->where('IP_ADDRESS', $ip);
                $this->oracle->delete('KHS_TAMPUNG_BACKORDER');
            } else {
                echo "IP ADDRESS is empty!!";
                die;
            }
        } else {
            echo "REQUEST_NUMBER is empty!!";
            die;
        }
    }

    public function runAPIDO($rm)
    {
        // $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
        $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');

        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $sql =  "BEGIN APPS.KHS_BACKORDER_TRIAL(:P_PARAM1); END;";

        //Statement does not change
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':P_PARAM1', $rm);
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

    public function getAssign()
    {
        $this->db->select('*');
        $this->db->from('pbr.pbr_user');
        $this->db->order_by("no_induk", "asc");
        $query = $this->db->get();
        return $query->result_array();
    }


// ------------------- SIAP ASSIGN -------------------

    public function getDO()
    {
        $subinv = $this->session->datasubinven;
        $query = "SELECT *
                    FROM khs_qweb_siap_assign1 kqsa
                   WHERE TRUNC (kqsa.tgl_kirim) BETWEEN TRUNC (SYSDATE - 2)
                                                    AND TRUNC (SYSDATE + 7)
                     AND kqsa.subinventory = '$subinv'
                ORDER BY kqsa.no_pr, kqsa.header_id";

        $response = $this->oracle->query($query)->result_array();

        if (empty($response)) {
            $response = null;
        }
        return $response;
    }


    public function getDetailData($data)
    {
        $subinv = $this->session->datasubinven;
        $query = "SELECT mtrh.header_id, mtrh.request_number \"DO/SPB\", msib.segment1,
                         mtrl.inventory_item_id, msib.description, mtrl.quantity,
                         (SELECT NVL (SUM (moqd.primary_transaction_quantity), 0) qty
                            FROM mtl_onhand_quantities_detail moqd
                           WHERE moqd.subinventory_code = '$subinv'
                             AND moqd.inventory_item_id = mtrl.inventory_item_id) av_to_res
                    FROM mtl_txn_request_lines mtrl,
                         mtl_txn_request_headers mtrh,
                         mtl_system_items_b msib
                   WHERE mtrh.header_id = mtrl.header_id
                     AND msib.inventory_item_id = mtrl.inventory_item_id
                     AND msib.organization_id = mtrl.organization_id
                     AND mtrh.request_number = '$data'
                     AND mtrl.line_status in (3,7)
                ORDER BY msib.description";

        if (!empty($data)) {
            $response = $this->oracle->query($query)->result_array();
        } else {
            $response = array(
                'success' => false,
                'message' => 'requests_number is empty, cannot do this action'
            );
        }
        return $response;
    }


// ------------------- SUDAH ASSIGN -------------------

    public function sudahdiAssign()
    {
        $subinv = $this->session->datasubinven;
        $sql = "SELECT *
                  FROM khs_qweb_terassign1 kqt
                 WHERE kqt.subinventory = '$subinv'
              ORDER BY CASE
                          WHEN kqt.tgl_kirim IS NULL
                             THEN 1
                          ELSE 0
                       END,
                       TRUNC (kqt.tgl_kirim) DESC,
                       kqt.plat_number,
                       1";
        $response = $this->oracle->query($sql)->result_array();

        return $response;
    }


    public function sudahdiAssign_detail($data)
    {
        $subinv = $this->session->datasubinven;
        $query = "SELECT mtrh.header_id, mtrh.request_number \"DO/SPB\", msib.segment1,
                         mtrl.inventory_item_id, msib.description, mtrl.quantity,
                         (SELECT SUM (moqd.primary_transaction_quantity) qty
                            FROM mtl_onhand_quantities_detail moqd
                           WHERE moqd.subinventory_code = '$subinv'
                             AND moqd.inventory_item_id = mtrl.inventory_item_id) av_to_res
                    FROM mtl_txn_request_lines mtrl,
                         mtl_txn_request_headers mtrh,
                         mtl_system_items_b msib
                   WHERE mtrh.header_id = mtrl.header_id
                     AND msib.inventory_item_id = mtrl.inventory_item_id
                     AND msib.organization_id = mtrl.organization_id
                     AND mtrh.request_number = '$data'
                     AND mtrl.line_status in (3,7)
                ORDER BY msib.description";

        if (!empty($data)) {
            $response = $this->oracle->query($query)->result_array();
        } else {
            $response = array(
            'success' => false,
            'message' => 'requests_number is empty, cannot do this action'
          );
        }
        return $response;
    }

    // public function sudahdiLayani()
    // {
    //     $sql = "SELECT *
    //               FROM khs_qweb_sudah_pelayanan1 kqsp
    //           ORDER BY 1";
    //     $response = $this->oracle->query($sql)->result_array();

    //     return $response;
    // }


    // public function sudahdiLayani_detail($data)
    // {
    //   $subinv = $this->session->datasubinven;
    //   $query = "SELECT DISTINCT mtrh.header_id, mtrh.request_number \"DO/SPB\", kdt.line_number, msib.segment1,
    //                             msib.description, mtrl.quantity qty_req,
    //                             kdt.allocated_quantity qty_allocated,
    //                             -- khs_stock_delivery (mtrl.inventory_item_id,102,'$subinv') stock,
    //                             khs_inv_qty_atr (102,mtrl.inventory_item_id,'$subinv','','') atr,
    //                             kpd.person_id petugas
    //                        FROM mtl_txn_request_lines mtrl,
    //                             mtl_txn_request_headers mtrh,
    //                             mtl_system_items_b msib,
    //                             khs_person_delivery kpd,
    //                             khs_delivery_temp kdt
    //                       WHERE mtrh.header_id = mtrl.header_id
    //                         AND kpd.request_number = mtrh.request_number
    //                         --
    //                         AND kdt.inventory_item_id = mtrl.inventory_item_id
    //                         AND kdt.line_number = mtrl.line_number
    //                         AND kdt.header_id = kpd.header_id
    //                         AND 1 =
    //                                CASE
    //                                   WHEN kdt.serial_status = 'SERIAL'
    //                                   AND kpd.delivery_flag = 'Y'
    //                                   AND kdt.flag = 'E'
    //                                      THEN 1                          --'SELESAI PELAYANAN'
    //                                   WHEN kdt.serial_status = 'NON SERIAL'
    //                                   AND kpd.delivery_flag = 'Y'
    //                                   AND kdt.flag = 'D'
    //                                      THEN 1                          --'SELESAI PELAYANAN'
    //                                END
    //                         --
    //                         AND msib.inventory_item_id = mtrl.inventory_item_id
    //                         AND msib.organization_id = mtrl.organization_id
    //                         AND mtrh.request_number = '$data'
    //                    ORDER BY msib.segment1";

    //     if (!empty($data)) {
    //         $response = $this->oracle->query($query)->result_array();
    //     } else {
    //         $response = array(
    //             'success' => false,
    //             'message' => 'requests_number is empty, cannot do this action'
    //         );
    //     }
    //     return $response;
    // }


// ------------------- SUDAH TRANSACT -------------------

    public function sudahdiMuat()
    {
        $subinv = $this->session->datasubinven;
        $sql = "SELECT *
                  FROM khs_qweb_sudah_muat1 kqsm
                 WHERE kqsm.subinventory = '$subinv'
              ORDER BY CASE
                          WHEN kqsm.tgl_kirim IS NULL
                             THEN 1
                          ELSE 0
                       END,
                       TRUNC (kqsm.tgl_kirim) DESC,
                       kqsm.plat_number,
                       1";
        $response = $this->oracle->query($sql)->result_array();

        return $response;
    }


    public function sudahdiMuat_detail($data)
    {
      $subinv = $this->session->datasubinven;
      $query = "SELECT mtrh.header_id, mtrh.request_number \"DO/SPB\", msib.segment1,
                       mtrl.inventory_item_id, msib.description, mtrl.quantity qty_req,
                       mtrl.quantity_detailed qty_allocated,
                       mtrl.quantity_delivered qty_transact,
                         (SELECT SUM (moqd.primary_transaction_quantity) qty
                            FROM mtl_onhand_quantities_detail moqd
                           WHERE moqd.subinventory_code = '$subinv'
                             AND moqd.inventory_item_id = mtrl.inventory_item_id) av_to_res
                    FROM mtl_txn_request_lines mtrl,
                         mtl_txn_request_headers mtrh,
                         mtl_system_items_b msib,
                         khs_detail_dospb kdd
                   WHERE mtrh.header_id = mtrl.header_id
                     AND msib.inventory_item_id = mtrl.inventory_item_id
                     AND msib.organization_id = mtrl.organization_id
                     AND kdd.request_number = mtrh.request_number
                     AND kdd.inventory_item_id = mtrl.inventory_item_id
                     AND kdd.line_number = mtrl.line_number
                     AND mtrh.request_number = '$data'
                     AND kdd.status = 'T'
                     AND mtrl.line_status = 5
                ORDER BY msib.description";

        if (!empty($data)) {
            $response = $this->oracle->query($query)->result_array();
        } else {
            $response = array(
              'success' => false,
              'message' => 'requests_number is empty, cannot do this action'
            );
        }
        return $response;
    }


// ------------------- SUDAH CETAK -------------------

    public function GetSudahCetak()
    {
        $subinv = $this->session->datasubinven;
        $sql = "SELECT *
                  FROM khs_qweb_sudah_cetak1 kqsc
                 WHERE kqsc.subinventory = '$subinv'
              ORDER BY CASE
                          WHEN kqsc.tgl_kirim IS NULL
                             THEN 1
                          ELSE 0
                       END,
                       TRUNC (kqsc.tgl_kirim) DESC,
                       kqsc.plat_number,
                       1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    //DATATABLE SERVER SIDE SUDAH CETAK
    public function selectDO($data)
    {
      $subinv = $this->session->datasubinven;
      $explode = strtoupper($data['search']['value']);
        $res = $this->oracle
            ->query(
                "SELECT kdav.*
                FROM
                    (
                    SELECT
                            skdav.*,
                            ROW_NUMBER () OVER (ORDER BY TGL_KIRIM DESC) as pagination
                        FROM
                            (
                              SELECT kdo.*
                              FROM
                                  (SELECT *
                                            FROM khs_qweb_sudah_cetak1 kqsc
                                           WHERE kqsc.subinventory = '$subinv'
                                        ORDER BY CASE
                                                    WHEN kqsc.tgl_kirim IS NULL
                                                       THEN 1
                                                    ELSE 0
                                                 END,
                                                 TRUNC (kqsc.tgl_kirim) DESC,
                                                 kqsc.plat_number,
                                                 1) kdo
                              WHERE
                                    (
                                      \"DO/SPB\" LIKE '%{$explode}%'
                                      OR JENIS_KENDARAAN LIKE '%{$explode}%'
                                      OR EKSPEDISI LIKE '%{$explode}%'
                                      OR PLAT_NUMBER LIKE '%{$explode}%'
                                      OR PETUGAS LIKE '%{$explode}%'
                                    )
                            ) skdav

                    ) kdav
                WHERE
                    pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
            )->result_array();

        return $res;
    }

    public function countAllDO()
    {
      $subinv = $this->session->datasubinven;
        return $this->oracle
            ->query(
                "SELECT
                    COUNT(*) AS \"count\"
                FROM
                (SELECT *
                          FROM khs_qweb_sudah_cetak1 kqsc
                         WHERE kqsc.subinventory = '$subinv'
                      ORDER BY CASE
                                  WHEN kqsc.tgl_kirim IS NULL
                                     THEN 1
                                  ELSE 0
                               END,
                               TRUNC (kqsc.tgl_kirim) DESC,
                               kqsc.plat_number,
                               1) kdo"
            )->row_array();
    }

    public function countFilteredDO($data)
    {
      $subinv = $this->session->datasubinven;
        $explode = strtoupper($data['search']['value']);

        return $this->oracle->query(
            "SELECT
                    COUNT(*) AS \"count\"
                FROM
                (SELECT *
                          FROM khs_qweb_sudah_cetak1 kqsc
                         WHERE kqsc.subinventory = '$subinv'
                      ORDER BY CASE
                                  WHEN kqsc.tgl_kirim IS NULL
                                     THEN 1
                                  ELSE 0
                               END,
                               TRUNC (kqsc.tgl_kirim) DESC,
                               kqsc.plat_number,
                               1) kdo
                        WHERE
                         (
                           \"DO/SPB\" LIKE '%{$explode}%'
                           OR JENIS_KENDARAAN LIKE '%{$explode}%'
                           OR EKSPEDISI LIKE '%{$explode}%'
                           OR PLAT_NUMBER LIKE '%{$explode}%'
                           OR PETUGAS LIKE '%{$explode}%'
                         )"
        )->row_array();
    }
    //END SERVERSIDE DATATABLE


    public function GetSudahCetakDetail($data)
    {
        $subinv = $this->session->datasubinven;
        $query = "SELECT mtrh.header_id, mtrh.request_number \"DO/SPB\", msib.segment1,
                         mtrl.inventory_item_id, msib.description, mtrl.quantity qty_req,
                         mtrl.quantity_detailed qty_allocated,
                         mtrl.quantity_delivered qty_transact,
                           (SELECT SUM (moqd.primary_transaction_quantity) qty
                              FROM mtl_onhand_quantities_detail moqd
                             WHERE moqd.subinventory_code = '$subinv'
                               AND moqd.inventory_item_id = mtrl.inventory_item_id) av_to_res
                      FROM mtl_txn_request_lines mtrl,
                           mtl_txn_request_headers mtrh,
                           mtl_system_items_b msib,
                           khs_detail_dospb kdd
                     WHERE mtrh.header_id = mtrl.header_id
                       AND msib.inventory_item_id = mtrl.inventory_item_id
                       AND msib.organization_id = mtrl.organization_id
                       AND kdd.request_number = mtrh.request_number
                       AND kdd.inventory_item_id = mtrl.inventory_item_id
                       AND kdd.line_number = mtrl.line_number
                       AND mtrh.request_number = '$data'
                       AND kdd.status IN ('C','V')
                       AND mtrl.line_status = 5
                  ORDER BY msib.description";

        if (!empty($data)) {
            $response = $this->oracle->query($query)->result_array();
        } else {
            $response = array(
                'success' => false,
                'message' => 'requests_number is empty, cannot do this action'
            );
        }
        return $response;
    }


// ------------------- SIAP INTERORG -------------------

    public function GetSiapInterorg()
    {
        $subinv = $this->session->datasubinven;
        $sql = "SELECT *
                  FROM khs_qweb_sudah_cetak1 kqsc
                 WHERE kqsc.subinventory = '$subinv'
              ORDER BY CASE
                          WHEN kqsc.tgl_kirim IS NULL
                             THEN 1
                          ELSE 0
                       END,
                       TRUNC (kqsc.tgl_kirim) DESC";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }


    public function GetSiapInterorgDetail($data)
    {
        $subinv = $this->session->datasubinven;
        $query = "SELECT mtrh.header_id, mtrh.request_number \"DO/SPB\", msib.segment1,
                         mtrl.inventory_item_id, msib.description, mtrl.quantity qty_req,
                         mtrl.quantity_detailed qty_allocated,
                         mtrl.quantity_delivered qty_transact,
                           (SELECT SUM (moqd.primary_transaction_quantity) qty
                              FROM mtl_onhand_quantities_detail moqd
                             WHERE moqd.subinventory_code = '$subinv'
                               AND moqd.inventory_item_id = mtrl.inventory_item_id) av_to_res
                      FROM mtl_txn_request_lines mtrl,
                           mtl_txn_request_headers mtrh,
                           mtl_system_items_b msib,
                           khs_detail_dospb kdd
                     WHERE mtrh.header_id = mtrl.header_id
                       AND msib.inventory_item_id = mtrl.inventory_item_id
                       AND msib.organization_id = mtrl.organization_id
                       AND kdd.request_number = mtrh.request_number
                       AND kdd.inventory_item_id = mtrl.inventory_item_id
                       AND kdd.line_number = mtrl.line_number
                       AND mtrh.request_number = '$data'
                       AND kdd.status = 'C'
                       AND mtrl.line_status = 5
                  ORDER BY msib.description";

        if (!empty($data)) {
            $response = $this->oracle->query($query)->result_array();
        } else {
            $response = array(
                'success' => false,
                'message' => 'requests_number is empty, cannot do this action'
            );
        }
        return $response;
    }


    public function cekkpd($data)
    {
      $response = $this->oracle->where('ASSIGNER_ID', $data['no_ind'])->where('REQUEST_NUMBER', $data['rn'])->get('KHS_PERSON_DELIVERY')->result_array();
      if (!empty($response)) {
        return 1;
      }else {
        return 0;
      }
    }


    public function cek_checklist($req)
    {
      $sql = "SELECT *
                FROM khs_cetak_checklist_do kccd
               WHERE kccd.request_number = '$req'";

      $response = $this->oracle->query($sql)->num_rows();

      if ($response < 1) {
        return 1;
      }else {
        return 0;
      }
    }


    public function insertDO($data)
    {
        // $user_login = $this->session->user;
        // $date_now = date('d-M-Y');
        // if (!empty($data['HEADER_ID'])) {
        //     if (!empty($data['REQUEST_NUMBER'])) {
        //         if (!empty($data['PERSON_ID'])) {
        //             if (!empty($data['DELIVERY_FLAG'])) {
        //                 if (!empty($data['PLAT_NUMBER'])) {
        //                     $this->oracle->query("INSERT INTO KHS_PERSON_DELIVERY(HEADER_ID
        //                                      ,REQUEST_NUMBER
        //                                      ,PERSON_ID
        //                                      ,DELIVERY_FLAG
        //                                      ,PLAT_NUMBER
        //                                      ,ASSIGNER_ID
        //                                      ,ASSIGN_DATE
        //                                      )
        //                     VALUES ('$data[HEADER_ID]'
        //                             ,'$data[REQUEST_NUMBER]'
        //                             ,'$data[PERSON_ID]'
        //                             ,'$data[DELIVERY_FLAG]'
        //                             ,'$data[PLAT_NUMBER]'
        //                             ,'$user_login'
        //                             ,'$date_now'
        //                             )
        //                     ");
        //                     $response = 1;
        //                 } else {
        //                     $response = 0;
        //                     // $response = array(
        //                     //     'success' => false,
        //                     //     'message' => 'PLAT_NUMBER is empty, cannot do this action'
        //                     // );
        //                 }
        //             } else {
        //                 $response = 0;
        //                 // $response = array(
        //                 //     'success' => false,
        //                 //     'message' => 'DELIVERY_FLAG is empty, cannot do this action'
        //                 // );
        //             }
        //         } else {
        //             $response = 0;
        //             // $response = array(
        //             //     'success' => false,
        //             //     'message' => 'PERSON_ID is empty, cannot do this action'
        //             // );
        //         }
        //     } else {
        //         $response = 0;
        //         // $response = array(
        //         //     'success' => false,
        //         //     'message' => 'REQUEST_NUMBER is empty, cannot do this action'
        //         // );
        //     }
        // } else {
        //     $response = 0;
        //     // $response = array(
        //     //     'success' => false,
        //     //     'message' => 'header id is empty, cannot do this action'
        //     // );
        // }
        $response = 1;
        return $response;
    }


    public function updateDO($data)
    {
        $user_login = $this->session->user;
        $sql = "UPDATE khs_detail_dospb kdd
                   SET kdd.plat_number = '$data[PLAT_NUMBER]',
                       kdd.assign_date = SYSDATE,
                       kdd.assigner_id = '$user_login',
                       kdd.assignee_id = '$data[PERSON_ID]'
                 WHERE kdd.request_number = '$data[REQUEST_NUMBER]'";
        $result = $this->oracle->query($sql);

        if ($result) {
          return 1;
        }
        else {
          return 0;
        }
    }


    public function getDataSelected($id)
    {
        $query = "SELECT DISTINCT mtrh.header_id, mtrh.request_number, kpd.person_id,
                                  kpd.delivery_flag, mtrh.creation_date,
                                  CASE
                                     WHEN (SELECT kim.transaction_source_name
                                             FROM khs_inv_mtltransactions kim
                                            WHERE kim.transaction_source_name =
                                                              mtrh.request_number
                                              AND ROWNUM = 1) = kpd.request_number
                                        THEN 'SPB KIT'
                                     WHEN (SELECT TO_CHAR (wdd.batch_id)
                                             FROM wsh_delivery_details wdd
                                            WHERE TO_CHAR (wdd.batch_id) = mtrh.request_number
                                              AND ROWNUM = 1) = kpd.request_number
                                        THEN 'DO'
                                     ELSE 'SPB'
                                  END delivery_type
                             FROM mtl_txn_request_headers mtrh,
                                  mtl_txn_request_lines mtrl,
                                  khs_person_delivery kpd
                            WHERE mtrh.header_id = mtrl.header_id
                              AND mtrl.quantity_detailed IS NULL
                              AND mtrl.quantity_delivered IS NULL
                              --
                              AND kpd.header_id(+) = mtrh.header_id
                              --
                              AND mtrl.line_status IN (3, 7)
                              AND mtrl.transaction_type_id IN
                                                             (327, 64, 52, 33) -- DO,SPB,SPB KIT
                              AND mtrh.request_number = '$id'
                         ORDER BY 3, 4";

        $response = $this->oracle->query($query)->result_array();

        if (empty($response)) {
            $response = array(
                'success' => true,
                'message' => 'there is no data available.'
            );
        }
        return $response;
    }

    public function dataCetak()
    {
        $query = "SELECT DISTINCT TO_CHAR (wdd.batch_id) no_mo, mtrl.to_subinventory_code,
                                  ship_party.party_name relasi, ship_loc.city kota,
                                  oola.schedule_ship_date rencana_kirim
                             FROM wsh_delivery_details wdd,
                                  mtl_txn_request_headers mtrh,
                                  mtl_txn_request_lines mtrl,
                                  oe_order_headers_all ooha,
                                  oe_order_lines_all oola,
                                  --
                                  hz_locations ship_loc,
                                  hz_cust_site_uses_all ship_su,
                                  hz_party_sites ship_ps,
                                  hz_cust_acct_sites_all ship_cas,
                                  hz_parties ship_party,
                                  --
                                  khs_delivery_temp kdt
                            WHERE mtrl.header_id = mtrh.header_id
                              AND mtrh.request_number = TO_CHAR (wdd.batch_id)
                              AND mtrl.inventory_item_id = wdd.inventory_item_id
                              AND ooha.header_id = wdd.source_header_id
                              AND oola.line_id = wdd.source_line_id
                              --
                              AND wdd.ship_to_site_use_id = ship_su.site_use_id(+)
                              AND ship_su.cust_acct_site_id = ship_cas.cust_acct_site_id(+)
                              AND ship_cas.party_site_id = ship_ps.party_site_id(+)
                              AND ship_loc.location_id(+) = ship_ps.location_id
                              AND ship_ps.party_id = ship_party.party_id
                              --
                              AND kdt.header_id = mtrh.header_id
                              AND kdt.request_number = mtrh.request_number
                              --
                              AND TRUNC (mtrh.creation_date) BETWEEN SYSDATE-30 AND SYSDATE+30
                  UNION
                  SELECT DISTINCT mtrh.request_number no_mo, mtrl.to_subinventory_code,
                                  ood.organization_code relasi, ood.organization_name kota,
                                  mtrh.date_required rencana_kirim
                             FROM mtl_txn_request_headers mtrh,
                                  mtl_txn_request_lines mtrl,
                                  org_organization_definitions ood,
                                  khs_delivery_temp kdt
                            WHERE mtrl.header_id = mtrh.header_id
                              AND SUBSTR (mtrl.REFERENCE, 6, 3) = TO_CHAR (ood.organization_id)
                              --
                              AND kdt.header_id = mtrh.header_id
                              AND kdt.request_number = mtrh.request_number
                              --
                              AND TRUNC (mtrh.creation_date) BETWEEN SYSDATE-30 AND SYSDATE+30";

        $response = $this->oracle->query($query)->result_array();
        if ($response=='') {
            echo "kosong bruhh";
        }
        return $response;
    }

    public function cekSpbDo($id)
    {
        $query = "SELECT kdt.delivery_type
                    FROM khs_detail_dospb kdt
                   WHERE kdt.request_number = '$id'
                   AND kdt.delivery_type like 'SPB%'
                   ";

        $response = $this->oracle->query($query)->result_array();

        if (empty($response)) {
            $response = null;
        }
        return $response;
    }


// ------------------- PDF CONTENT -------------------

    public function headerSurat($id)
    {
      $query = "SELECT *
                from khs_qweb_header_dospb1 kqhd
                where kqhd.REQUEST_NUMBER = '$id'";

      $response = $this->oracle->query($query)->result_array();

      if (empty($response)) {
          $response = null;
      }
      return $response;
    }


    public function bodySurat($data,$tipe)
    {
        if ($tipe == 'DO') {
          // $order = 'kqbd.line_number';
          $from = ', wsh_delivery_details wdd';
          $where = 'AND kqbd.request_number = wdd.batch_id
                    AND kqbd.item_id = wdd.inventory_item_id
                    AND wdd.move_order_line_id = kqbd.line_id';
          $order = 'wdd.source_line_id';
        }
        else {
          $from = '';
          $where = '';
          $order = 'kqbd.item';
        }

        $query = "SELECT *
                    FROM khs_qweb_body_dospb1 kqbd
                         $from
                   WHERE kqbd.request_number = '$data'
                         $where
                ORDER BY $order";

        $response = $this->oracle->query($query)->result_array();

        if (empty($response)) {
            $response = array(
                'success' => false,
                'message' => 'there is no data available.'
            );
        }
        return $response;
    }


    public function serial($data)
    {
        $query = "SELECT *
                    FROM khs_qweb_serial_dospb1 kqsd
                   WHERE kqsd.request_number = '$data'";

        $response = $this->oracle->query($query)->result_array();

        if (empty($response)) {
            $response = null;
        }
        return $response;
    }


    public function footersurat($data)
    {
        $query = "SELECT *
                  from khs_qweb_footer_dospb1 kqfd
                  where kqfd.REQUEST_NUMBER = '$data'";

        $response = $this->oracle->query($query)->result_array();

        if (empty($response)) {
            $response = array(
                'success' => 0,
                'message' => 'there is no data available.'
            );
        }
        return $response;
    }


    public function test($data)
    {
        echo "<pre>";
        print_r($data);
        die;

        $response = 'lalalala';

        return $response;
    }
}
