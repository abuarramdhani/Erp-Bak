<?php
class M_monitoringdo extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // $this->oracle = $this->load->database('oracle_dev', true);
        $this->oracle = $this->load->database('oracle', true);

        $subinv = $this->session->datasubinven;
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
        $sql = "INSERT INTO khs_cetak_do
                            (request_number, order_number, creation_date, nomor_cetak)
                     VALUES ('$data[REQUEST_NUMBER]', '$data[ORDER_NUMBER]', SYSDATE, '$data[NOMOR_CETAK]')";

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

    public function GetSudahCetak()
    {
        $sql = "SELECT *
                  FROM khs_qweb_sudah_cetak1 kqsc
              ORDER BY 1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }


    public function GetSudahCetakDetail($data)
    {
        $subinv = $this->session->datasubinven;
        $query = "SELECT DISTINCT mtrh.header_id, mtrh.request_number \"DO/SPB\", msib.segment1,
                                  msib.description, mtrl.quantity qty_req,
                                  kdt.allocated_quantity qty_allocated,
                                  mtrl.quantity_delivered qty_transact,
                                  khs_inv_qty_atr (102,mtrl.inventory_item_id,'$subinv','','') atr,
                                  kpd.person_id petugas
                             FROM mtl_txn_request_lines mtrl,
                                  mtl_txn_request_headers mtrh,
                                  mtl_system_items_b msib,
                                  khs_person_delivery kpd,
                                  khs_delivery_temp kdt,
                                  khs_cetak_do kcd
                            WHERE mtrh.header_id = mtrl.header_id
                              AND kpd.request_number = mtrh.request_number
                              AND kcd.request_number = mtrh.request_number
                              --
                              AND kdt.inventory_item_id = mtrl.inventory_item_id
                              AND kdt.header_id = kpd.header_id
                              AND 1 =
                                     CASE
                                        WHEN kdt.serial_status IN ('NON SERIAL', 'SERIAL')
                                        AND kpd.delivery_flag = 'Y'
                                        AND kdt.flag = 'T'
                                           THEN 1                                 --'SUDAH MUAT'
                                     END
                              --
                              AND msib.inventory_item_id = mtrl.inventory_item_id
                              AND msib.organization_id = mtrl.organization_id
                              AND mtrh.request_number = '$data'
                         ORDER BY msib.segment1";

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

    public function getDO()
    {
        $response = $this->oracle->query("  SELECT *
                                              FROM khs_qweb_siap_assign1 kqsa
                                             WHERE TRUNC (kqsa.creation_date) = TRUNC (SYSDATE)
                                          ORDER BY kqsa.no_pr, kqsa.header_id")->result_array();
        // echo "<pre>";
        // print_r($response);
        // die;

        if (empty($response)) {
            $response = null;
        }
        return $response;
    }


    public function getDetailData($data)
    {
        $subinv = $this->session->datasubinven;
        $query = "SELECT DISTINCT mtrh.header_id, mtrh.request_number \"DO/SPB\", msib.segment1,
                                  mtrl.inventory_item_id, msib.description, mtrl.quantity,
                                  -- khs_stock_delivery (mtrl.inventory_item_id,102,'$subinv') + mtrl.quantity av_to_res
                                  khs_inv_qty_atr (102,mtrl.inventory_item_id,'$subinv','','') av_to_res
                             FROM mtl_txn_request_lines mtrl,
                                  mtl_txn_request_headers mtrh,
                                  mtl_system_items_b msib
                            WHERE mtrh.header_id = mtrl.header_id
                              AND msib.inventory_item_id = mtrl.inventory_item_id
                              AND msib.organization_id = mtrl.organization_id
                              AND mtrh.request_number = '$data'
                         ORDER BY msib.segment1";

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

    public function sudahdiAssign()
    {   
        $sql = "SELECT *
                  FROM khs_qweb_terassign1 kqt
              ORDER BY 1";
        $response = $this->oracle->query($sql)->result_array();

        return $response;
    }


    public function sudahdiAssign_detail($data)
    {
        $subinv = $this->session->datasubinven;
        $query = "SELECT DISTINCT mtrh.header_id, mtrh.request_number \"DO/SPB\", msib.segment1,
                                mtrl.inventory_item_id, msib.description, mtrl.quantity qty_req,
                                -- khs_stock_delivery (mtrl.inventory_item_id,102,'$subinv') + mtrl.quantity av_to_res
                                khs_inv_qty_atr (102,mtrl.inventory_item_id,'$subinv','','') atr
                           FROM mtl_txn_request_lines mtrl,
                                mtl_txn_request_headers mtrh,
                                mtl_system_items_b msib
                          WHERE mtrh.header_id = mtrl.header_id
                            AND msib.inventory_item_id = mtrl.inventory_item_id
                            AND msib.organization_id = mtrl.organization_id
                            AND mtrh.request_number = '$data'
                       ORDER BY msib.segment1";

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

    public function sudahdiLayani()
    {
        $sql = "SELECT *
                  FROM khs_qweb_sudah_pelayanan1 kqsp
              ORDER BY 1";
        $response = $this->oracle->query($sql)->result_array();

        return $response;
    }


    public function sudahdiLayani_detail($data)
    {
      $subinv = $this->session->datasubinven;
      $query = "SELECT DISTINCT mtrh.header_id, mtrh.request_number \"DO/SPB\", msib.segment1,
                                msib.description, mtrl.quantity qty_req,
                                kdt.allocated_quantity qty_allocated,
                                -- khs_stock_delivery (mtrl.inventory_item_id,102,'$subinv') stock,
                                khs_inv_qty_atr (102,mtrl.inventory_item_id,'$subinv','','') atr,
                                kpd.person_id petugas
                           FROM mtl_txn_request_lines mtrl,
                                mtl_txn_request_headers mtrh,
                                mtl_system_items_b msib,
                                khs_person_delivery kpd,
                                khs_delivery_temp kdt
                          WHERE mtrh.header_id = mtrl.header_id
                            AND kpd.request_number = mtrh.request_number
                            --
                            AND kdt.inventory_item_id = mtrl.inventory_item_id
                            AND kdt.header_id = kpd.header_id
                            AND 1 =
                                   CASE
                                      WHEN kdt.serial_status = 'SERIAL'
                                      AND kpd.delivery_flag = 'Y'
                                      AND kdt.flag = 'E'
                                         THEN 1                          --'SELESAI PELAYANAN'
                                      WHEN kdt.serial_status = 'NON SERIAL'
                                      AND kpd.delivery_flag = 'Y'
                                      AND kdt.flag = 'D'
                                         THEN 1                          --'SELESAI PELAYANAN'
                                   END
                            --
                            AND msib.inventory_item_id = mtrl.inventory_item_id
                            AND msib.organization_id = mtrl.organization_id
                            AND mtrh.request_number = '$data'
                       ORDER BY msib.segment1";

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


    public function sudahdiMuat()
    {
        $sql = "SELECT *
                  FROM khs_qweb_sudah_muat1 kqsm
              ORDER BY 1";
        $response = $this->oracle->query($sql)->result_array();

        return $response;
    }


    public function sudahdiMuat_detail($data)
    {
      $subinv = $this->session->datasubinven;
      $query = "SELECT DISTINCT mtrh.header_id, mtrh.request_number \"DO/SPB\", msib.segment1,
                                msib.description, mtrl.quantity qty_req,
                                kdt.allocated_quantity qty_allocated,
                                mtrl.quantity_delivered qty_transact, kpd.person_id petugas
                           FROM mtl_txn_request_lines mtrl,
                                mtl_txn_request_headers mtrh,
                                mtl_system_items_b msib,
                                khs_person_delivery kpd,
                                khs_delivery_temp kdt
                          WHERE mtrh.header_id = mtrl.header_id
                            AND kpd.request_number = mtrh.request_number
                            --
                            AND kdt.inventory_item_id = mtrl.inventory_item_id
                            AND kdt.header_id = kpd.header_id
                            AND 1 =
                                   CASE
                                      WHEN kdt.serial_status IN ('NON SERIAL', 'SERIAL')
                                      AND kpd.delivery_flag = 'Y'
                                      AND kdt.flag = 'T'
                                         THEN 1                                 --'SUDAH MUAT'
                                   END
                            --
                            AND msib.inventory_item_id = mtrl.inventory_item_id
                            AND msib.organization_id = mtrl.organization_id
                            AND mtrh.request_number = '$data'
                       ORDER BY msib.segment1";

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


    public function insertDO($data)
    {
        if (!empty($data['HEADER_ID'])) {
            if (!empty($data['REQUEST_NUMBER'])) {
                if (!empty($data['PERSON_ID'])) {
                    if (!empty($data['DELIVERY_FLAG'])) {
                        if (!empty($data['PLAT_NUMBER'])) {
                            $this->oracle->query("INSERT INTO KHS_PERSON_DELIVERY(HEADER_ID
                                             ,REQUEST_NUMBER
                                             ,PERSON_ID
                                             ,DELIVERY_FLAG
                                             ,PLAT_NUMBER
                                             )
                            VALUES ('$data[HEADER_ID]'
                                   ,'$data[REQUEST_NUMBER]'
                                   ,'$data[PERSON_ID]'
                                   ,'$data[DELIVERY_FLAG]'
                                   ,'$data[PLAT_NUMBER]'
                                   )
                            ");
                            $response = 1;
                        } else {
                            $response = 0;
                            // $response = array(
                            //     'success' => false,
                            //     'message' => 'PLAT_NUMBER is empty, cannot do this action'
                            // );
                        }
                    } else {
                        $response = 0;
                        // $response = array(
                        //     'success' => false,
                        //     'message' => 'DELIVERY_FLAG is empty, cannot do this action'
                        // );
                    }
                } else {
                    $response = 0;
                    // $response = array(
                    //     'success' => false,
                    //     'message' => 'PERSON_ID is empty, cannot do this action'
                    // );
                }
            } else {
                $response = 0;
                // $response = array(
                //     'success' => false,
                //     'message' => 'REQUEST_NUMBER is empty, cannot do this action'
                // );
            }
        } else {
            $response = 0;
            // $response = array(
            //     'success' => false,
            //     'message' => 'header id is empty, cannot do this action'
            // );
        }
        return $response;
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

    public function headerSurat($id)
    {
        $query = "SELECT *
                    FROM khs_qweb_sudah_muat1 kqsm
                   WHERE kqsm.\"DO/SPB\" = '$id'";

        $response = $this->oracle->query($query)->result_array();

        if (empty($response)) {
            $response = null;
        }
        return $response;
    }

    public function headerSurat2($id)
    {
        $query = "SELECT *
                    FROM khs_qweb_sudah_cetak1 kqsc
                   WHERE kqsc.\"DO/SPB\" = '$id'";

        $response = $this->oracle->query($query)->result_array();

        if (empty($response)) {
            $response = null;
        }
        return $response;
    }


    public function bodySurat($id)
    {
        $query = "SELECT mtrh.header_id, mtrh.request_number, msib.segment1 item,
                         msib.description, mtrl.uom_code, NVL (mtrl.quantity, 0) quantity,
                         NVL (mtrl.quantity_delivered, 0) transact_qty,
                         NVL (mtrl.quantity_detailed, 0) allocated_qty,
                         NVL (kdt.required_quantity, 0) required_quantity,
                         NVL (kdt.allocated_quantity, 0) qty_terlayani
                    FROM mtl_txn_request_headers mtrh,
                         mtl_txn_request_lines mtrl,
                         khs_delivery_temp kdt,
                         mtl_system_items_b msib
                   WHERE mtrh.header_id = mtrl.header_id
                     AND mtrh.header_id = kdt.header_id
                     AND kdt.inventory_item_id = mtrl.inventory_item_id
                     AND kdt.organization_id = mtrl.organization_id
                     --
                     AND msib.inventory_item_id = mtrl.inventory_item_id
                     AND msib.organization_id = mtrl.organization_id
                     --
                     AND mtrl.transaction_type_id IN (327, 64, 52, 33)         -- DO,SPB,SPB KIT
                     AND NVL (mtrl.quantity_delivered, 0) <> 0
                     --
                     AND mtrh.request_number = '$id'";

        $response = $this->oracle->query($query)->result_array();

        if (empty($response)) {
            $response = array(
                'success' => false,
                'message' => 'there is no data available.'
            );
        }
        return $response;
    }

    public function serial($id)
    {
        $query = "SELECT mtrh.header_id, mtrh.request_number, msib.segment1 item,
                         msib.description, ksnt.serial_number
                    FROM mtl_txn_request_headers mtrh,
                         mtl_txn_request_lines mtrl,
                         khs_delivery_temp kdt,
                         khs_serial_number_temp ksnt,
                         mtl_system_items_b msib
                   WHERE mtrh.header_id = mtrl.header_id
                     --
                     AND kdt.header_id = mtrh.header_id
                     AND kdt.inventory_item_id = mtrl.inventory_item_id
                     AND kdt.organization_id = mtrl.organization_id
                     AND ksnt.header_id = mtrl.header_id
                     AND ksnt.inventory_item_id = mtrl.inventory_item_id
                     --
                     AND msib.inventory_item_id = mtrl.inventory_item_id
                     AND msib.organization_id = mtrl.organization_id
                     --
                     AND mtrl.transaction_type_id IN (327, 64, 52, 33)       -- DO,SPB,SPB KIT
                     --
                     AND mtrh.request_number = '$id'
                ORDER BY msib.segment1";

        $response = $this->oracle->query($query)->result_array();

        if (empty($response)) {
            $response = null;
        }
        return $response;
    }

    public function footersurat($data)
    {
        $query = "SELECT DISTINCT kad.request_by, ppf.full_name ADMIN, kad.approved_by,
                                  ppf1.full_name kepala, kad.approved_date tanggal,
                                  kdt.request_number nomor_do, kdt.person_id,
                                  ppf2.full_name gudang
                             FROM khs_approval_do kad,
                                  khs_delivery_temp kdt,
                                  per_people_f ppf,
                                  per_people_f ppf1,
                                  per_people_f ppf2
                            WHERE kad.no_do = kdt.request_number
                              AND kad.request_by = ppf.national_identifier
                              AND kad.approved_by = ppf1.national_identifier
                              AND kdt.person_id = ppf2.national_identifier
                              AND kdt.request_number = '$data'
                              AND kad.status = 'Approved'";

        $response = $this->oracle->query($query)->result_array();

        if (empty($response)) {
            $response = array(
                'success' => true,
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