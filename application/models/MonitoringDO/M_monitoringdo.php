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
        $sql = "UPDATE KHS_PERSON_DELIVERY SET PLAT_NUMBER = '$data[PLAT_NUMBER]', DELIVERY_FLAG = '$data[DELIVERY_FLAG]' WHERE REQUEST_NUMBER = '$rm' AND HEADER_ID = '$hi'";
        $query = $this->oracle->query($sql);
        return $sql;
    }

    public function insertDOCetak($data)
    {
        if (!empty($data)) {
            $response = $this->oracle->query("INSERT INTO KHS_CETAK_DO (REQUEST_NUMBER, ORDER_NUMBER, CREATION_DATE, NOMOR_CETAK)
          VALUES('$data[REQUEST_NUMBER]','$data[ORDER_NUMBER]',SYSDATE,'$data[NOMOR_CETAK]')");
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
                FROM khs_qweb_sudah_cetak1 kqsc";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }


    public function GetSudahCetakDetail($data)
    {
      $subinv = $this->session->datasubinven;
        if (!empty($data)) {
            $response = $this->oracle->query("SELECT distinct
                   mtrh.HEADER_ID
                  ,mtrh.REQUEST_NUMBER \"DO/SPB\"
                  ,msib.SEGMENT1
                  ,msib.DESCRIPTION
                  ,mtrl.QUANTITY qty_req
                  ,kdt.ALLOCATED_QUANTITY qty_allocated
                  ,mtrl.QUANTITY_DELIVERED qty_transact
                  ,khs_stock_delivery(mtrl.INVENTORY_ITEM_ID,102,'$subinv') stock
                  ,khs_inv_qty_atr(102,mtrl.INVENTORY_ITEM_ID,'$subinv','','') atr
                  ,kpd.PERSON_ID petugas
            from mtl_txn_request_lines mtrl
                ,mtl_txn_request_headers mtrh
                ,mtl_system_items_b msib
                ,khs_approval_do kad
                ,khs_person_delivery kpd
                ,khs_delivery_temp kdt
            where mtrh.HEADER_ID = mtrl.HEADER_ID
              and kad.NO_DO = mtrh.REQUEST_NUMBER
              and kad.NO_DO = kpd.REQUEST_NUMBER
              --
              and kdt.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
              and kdt.HEADER_ID = kpd.HEADER_ID
              and 1 = case when kdt.SERIAL_STATUS in ('NON SERIAL','SERIAL')
                            and kpd.DELIVERY_FLAG = 'Y'
                            and kdt.FLAG = 'T'
                           then 1 --'SUDAH MUAT'
                      end
              --
              and msib.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
              and msib.ORGANIZATION_ID = mtrl.ORGANIZATION_ID
              and mtrh.REQUEST_NUMBER = '$data'
            order by msib.SEGMENT1")->result_array();
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
        $sql = "SELECT distinct
                 mtrh.REQUEST_NUMBER
                ,kpd.PERSON_ID petugas
          from hz_cust_site_uses_all hcsua
              ,hz_party_sites hps
              ,hz_locations hzl
              ,hz_cust_acct_sites_all hcas
              ,hz_parties hzp
              ,hz_cust_accounts hca
              --
              ,oe_order_headers_all ooha
              ,oe_order_lines_all oola
              ,wsh_delivery_details wdd
              --
              ,mtl_txn_request_headers mtrh
              ,mtl_txn_request_lines mtrl
              ,khs_approval_do kad
              ,khs_person_delivery kpd
              --
              ,khs_delivery_temp kdt
              ,khs_cetak_do kcd
          where ooha.HEADER_ID = oola.HEADER_ID
            --
            and wdd.SOURCE_HEADER_NUMBER = ooha.ORDER_NUMBER
            --
            and kad.NO_DO = mtrh.REQUEST_NUMBER
            --
            and kdt.HEADER_ID = kpd.HEADER_ID
            and kcd.REQUEST_NUMBER = kpd.REQUEST_NUMBER
            and kcd.REQUEST_NUMBER = mtrh.REQUEST_NUMBER
            and 1 = case when kdt.SERIAL_STATUS in ('NON SERIAL','SERIAL')
                         and kpd.DELIVERY_FLAG = 'Y'
                         and kdt.FLAG = 'S'
                    then 1 --'SUDAH MUAT'
                    end
            --
            and mtrh.HEADER_ID = mtrl.HEADER_ID
            and mtrh.REQUEST_NUMBER = to_char(wdd.BATCH_ID)
            --
            and ooha.SOLD_TO_ORG_ID = hca.CUST_ACCOUNT_ID(+)
            and hca.PARTY_ID = hzp.PARTY_ID(+)
            and ooha.SHIP_TO_ORG_ID = hcsua.SITE_USE_ID(+)
            and hcsua.CUST_ACCT_SITE_ID = hcas.CUST_ACCT_SITE_ID(+)
            and hcas.PARTY_SITE_ID = hps.PARTY_SITE_ID(+)
            and hps.LOCATION_ID = hzl.LOCATION_ID(+)
          order by kpd.PERSON_ID
                  ,mtrh.REQUEST_NUMBER";
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
        // $datacustom = '24-Mar-20';
        $response = $this->oracle->query("SELECT DISTINCT kqsa.*
                                                     FROM khs_qweb_siap_assign1 kqsa
                                                    WHERE TRUNC (kqsa.creation_date) = TRUNC (SYSDATE)
                                                 ORDER BY kqsa.creation_date")->result_array();
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
                                khs_stock_delivery (mtrl.inventory_item_id,102,'$subinv') + mtrl.quantity av_to_res
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
                FROM khs_qweb_terassign1 kqt";
        $response = $this->oracle->query($sql)->result_array();

        return $response;
    }


    public function sudahdiAssign_detail($data)
    {
        $subinv = $this->session->datasubinven;
        if (!empty($data)) {
            $response = $this->oracle->query("SELECT distinct
                   mtrh.HEADER_ID
                  ,mtrh.REQUEST_NUMBER \"DO/SPB\"
                  ,msib.SEGMENT1
                  ,msib.DESCRIPTION
                  ,mtrl.QUANTITY qty_req
                  ,khs_stock_delivery(mtrl.INVENTORY_ITEM_ID,102,'$subinv') + mtrl.quantity stock
                  ,khs_inv_qty_atr(102,mtrl.INVENTORY_ITEM_ID,'$subinv','','') atr
                  ,kpd.PERSON_ID petugas
            from mtl_txn_request_lines mtrl
                ,mtl_txn_request_headers mtrh
                ,mtl_system_items_b msib
                ,khs_approval_do kad
                ,khs_person_delivery kpd
            where mtrh.HEADER_ID = mtrl.HEADER_ID
              and kad.NO_DO = mtrh.REQUEST_NUMBER
              and kad.NO_DO = kpd.REQUEST_NUMBER
              and kpd.PERSON_ID is not null
              --
              and kpd.HEADER_ID not in (select kdt.HEADER_ID
                                          from khs_delivery_temp kdt
                                         where kdt.HEADER_ID = kpd.HEADER_ID)
              --
              and msib.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
              and msib.ORGANIZATION_ID = mtrl.ORGANIZATION_ID
              and mtrh.REQUEST_NUMBER = '$data'
            order by msib.SEGMENT1")->result_array();
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
                FROM khs_qweb_sudah_pelayanan1 kqsp";
        $response = $this->oracle->query($sql)->result_array();

        return $response;
    }


    public function sudahdiLayani_detail($data)
    {
      $subinv = $this->session->datasubinven;
        if (!empty($data)) {
            $response = $this->oracle->query("SELECT distinct
                 mtrh.HEADER_ID
                ,mtrh.REQUEST_NUMBER \"DO/SPB\"
                ,msib.SEGMENT1
                ,msib.DESCRIPTION
                ,mtrl.QUANTITY qty_req
                ,kdt.ALLOCATED_QUANTITY qty_allocated
                ,khs_stock_delivery(mtrl.INVENTORY_ITEM_ID,102,'$subinv') stock
                ,khs_inv_qty_atr(102,mtrl.INVENTORY_ITEM_ID,'$subinv','','') atr
                ,kpd.PERSON_ID petugas
          from mtl_txn_request_lines mtrl
              ,mtl_txn_request_headers mtrh
              ,mtl_system_items_b msib
              ,khs_approval_do kad
              ,khs_person_delivery kpd
              ,khs_delivery_temp kdt
          where mtrh.HEADER_ID = mtrl.HEADER_ID
            and kad.NO_DO = mtrh.REQUEST_NUMBER
            and kad.NO_DO = kpd.REQUEST_NUMBER
            --
            and kdt.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
            and kdt.HEADER_ID = kpd.HEADER_ID
            and 1 = case when kdt.SERIAL_STATUS = 'SERIAL'
                          and kpd.DELIVERY_FLAG = 'Y'
                          and kdt.FLAG = 'O'
                         then 1 --'SELESAI PELAYANAN'
                         when kdt.SERIAL_STATUS = 'NON SERIAL'
                          and kpd.DELIVERY_FLAG = 'Y'
                          and kdt.FLAG = 'Y'
                         then 1 --'SELESAI PELAYANAN'
                    end
            --
            and msib.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
            and msib.ORGANIZATION_ID = mtrl.ORGANIZATION_ID
            and mtrh.REQUEST_NUMBER = '$data'
              order by msib.SEGMENT1")->result_array();
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
                FROM khs_qweb_sudah_muat1 kqsm";
        $response = $this->oracle->query($sql)->result_array();

        return $response;
    }


    public function sudahdiMuat_detail($data)
    {
      $subinv = $this->session->datasubinven;
        if (!empty($data)) {
            $response = $this->oracle->query("SELECT distinct
                   mtrh.HEADER_ID
                  ,mtrh.REQUEST_NUMBER \"DO/SPB\"
                  ,msib.SEGMENT1
                  ,msib.DESCRIPTION
                  ,mtrl.QUANTITY qty_req
                  ,kdt.ALLOCATED_QUANTITY qty_allocated
                  ,mtrl.QUANTITY_DELIVERED qty_transact
                  ,khs_stock_delivery(mtrl.INVENTORY_ITEM_ID,102,'$subinv') stock
                  ,khs_inv_qty_atr(102,mtrl.INVENTORY_ITEM_ID,'$subinv','','') atr
                  ,kpd.PERSON_ID petugas
            from mtl_txn_request_lines mtrl
                ,mtl_txn_request_headers mtrh
                ,mtl_system_items_b msib
                ,khs_approval_do kad
                ,khs_person_delivery kpd
                ,khs_delivery_temp kdt
            where mtrh.HEADER_ID = mtrl.HEADER_ID
              and kad.NO_DO = mtrh.REQUEST_NUMBER
              and kad.NO_DO = kpd.REQUEST_NUMBER
              --
              and kdt.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
              and kdt.HEADER_ID = kpd.HEADER_ID
              -- and 1 = case when kdt.SERIAL_STATUS in ('NON SERIAL','SERIAL')
              --               and kpd.DELIVERY_FLAG = 'Y'
              --               and kdt.FLAG = 'S'
              --              then 1 --'SUDAH MUAT'
              --         end
              and 1 = case when kdt.SERIAL_STATUS in ('NON SERIAL','SERIAL')
                    and kpd.DELIVERY_FLAG = 'Y'
                    and kdt.FLAG = 'T' --in ('S','B')
                   then 1 --'SUDAH MUAT'
              end
              --
              and msib.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
              and msib.ORGANIZATION_ID = mtrl.ORGANIZATION_ID
              and mtrh.REQUEST_NUMBER = '$data'
            order by msib.SEGMENT1")->result_array();
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
        $response = $this->oracle->query("SELECT distinct
             mtrh.HEADER_ID
            ,mtrh.REQUEST_NUMBER
            ,kpd.PERSON_ID
            ,kpd.DELIVERY_FLAG
            ,mtrh.CREATION_DATE
            ,case when (select kim.TRANSACTION_SOURCE_NAME
                 from khs_inv_mtltransactions kim
                where kim.TRANSACTION_SOURCE_NAME = mtrh.REQUEST_NUMBER
                  and rownum = 1
                 ) = kpd.REQUEST_NUMBER
         then 'SPB KIT'
         when (select to_char(wdd.BATCH_ID)
                 from wsh_delivery_details wdd
                where to_char(wdd.BATCH_ID) = mtrh.REQUEST_NUMBER
                  and rownum = 1
                 ) = kpd.REQUEST_NUMBER
         then 'DO'
         else 'SPB'
    end delivery_type
      from mtl_txn_request_headers mtrh
          ,mtl_txn_request_lines mtrl
          --
          ,khs_person_delivery kpd
      where mtrh.HEADER_ID = mtrl.HEADER_ID
        and mtrl.QUANTITY_DETAILED is null
        and mtrl.QUANTITY_DELIVERED is null
        --
        and kpd.HEADER_ID(+) = mtrh.HEADER_ID
        --
        and mtrl.LINE_STATUS in (3,7)
        and mtrl.TRANSACTION_TYPE_ID in (327,64,52,33) -- DO,SPB,SPB KIT
        and mtrh.REQUEST_NUMBER = '$id'
      order by 3,4 ")->result_array();

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
        $response = $this->oracle->query("SELECT DISTINCT TO_CHAR(wdd.batch_id) no_mo, mtrl.to_subinventory_code,
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
                AND TRUNC (mtrh.creation_date) BETWEEN sysdate-30 AND sysdate+30
    --            AND wdd.batch_id = --3482551
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
                AND TRUNC (mtrh.creation_date) BETWEEN sysdate-30 AND sysdate+30
    --            AND mtrh.request_number = '3456136'")->result_array();
        if ($response=='') {
            echo "kosong bruhh";
        }
        return $response;
    }

    public function headerSurat($id)
    {
        $response = $this->oracle->query("SELECT *
                                            FROM khs_qweb_sudah_muat1 kqsm
                                           WHERE kqsm.\"DO/SPB\" = '$id'")->result_array();

        if (empty($response)) {
            $response = null;
        }
        return $response;
    }

    public function headerSurat2($id)
    {
        $response = $this->oracle->query("SELECT *
                                            FROM khs_qweb_sudah_cetak1 kqsc
                                           WHERE kqsc.\"DO/SPB\" = '$id'")->result_array();

        if (empty($response)) {
            $response = null;
        }
        return $response;
    }


    public function bodySurat($id)
    {
        $response = $this->oracle->query("SELECT mtrh.HEADER_ID
            ,mtrh.REQUEST_NUMBER
            ,msib.SEGMENT1 item
            ,msib.DESCRIPTION
            ,mtrl.UOM_CODE
            ,nvl(mtrl.QUANTITY,0) quantity
            ,nvl(mtrl.QUANTITY_DELIVERED,0) transact_qty
            ,nvl(mtrl.QUANTITY_DETAILED,0) allocated_qty
            ,nvl(kdt.REQUIRED_QUANTITY,0) required_quantity
            ,nvl(kdt.ALLOCATED_QUANTITY,0) qty_terlayani
      from mtl_txn_request_headers mtrh
          ,mtl_txn_request_lines mtrl
          --
          ,khs_delivery_temp kdt
          --
          ,mtl_system_items_b msib
      where mtrh.HEADER_ID = mtrl.HEADER_ID
        and mtrh.HEADER_ID = kdt.HEADER_ID
        and kdt.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
        and kdt.ORGANIZATION_ID = mtrl.ORGANIZATION_ID
        --
        and msib.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
        and msib.ORGANIZATION_ID = mtrl.ORGANIZATION_ID
        --
        and mtrl.TRANSACTION_TYPE_ID in (327,64,52,33) -- DO,SPB,SPB KIT
        and nvl(mtrl.QUANTITY_DELIVERED,0) <> 0
        --
        and mtrh.REQUEST_NUMBER = '$id'")->result_array();

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
        $response = $this->oracle->query("SELECT mtrh.HEADER_ID
      ,mtrh.REQUEST_NUMBER
      ,msib.SEGMENT1 item
      ,msib.DESCRIPTION
      ,ksnt.SERIAL_NUMBER
      from mtl_txn_request_headers mtrh
          ,mtl_txn_request_lines mtrl
          --
          ,khs_delivery_temp kdt
          ,khs_serial_number_temp ksnt
          --
          ,mtl_system_items_b msib
      where mtrh.HEADER_ID = mtrl.HEADER_ID
        --
        and kdt.HEADER_ID = mtrh.HEADER_ID
        and kdt.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
        and kdt.ORGANIZATION_ID = mtrl.ORGANIZATION_ID
        and ksnt.HEADER_ID = mtrl.HEADER_ID
        and ksnt.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
        --
        and msib.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
        and msib.ORGANIZATION_ID = mtrl.ORGANIZATION_ID
        --
        and mtrl.TRANSACTION_TYPE_ID in (327,64,52,33) -- DO,SPB,SPB KIT
        --
        and mtrh.REQUEST_NUMBER = '$id'
      order by msib.SEGMENT1")->result_array();

        if (empty($response)) {
            $response = null;
        }
        return $response;
    }

    public function footersurat($data)
    {
        $response = $this->oracle->query("SELECT distinct kad.REQUEST_BY
        ,ppf.FULL_NAME admin
        ,kad.APPROVED_BY
        ,ppf1.FULL_NAME kepala
        ,kad.APPROVED_DATE tanggal
        ,kdt.REQUEST_NUMBER nomor_do
        ,kdt.PERSON_ID
        ,ppf2.FULL_NAME Gudang
        from
        khs_approval_do kad,
        khs_delivery_temp kdt,
        per_people_f ppf,
        per_people_f ppf1,
        per_people_f ppf2
        where kad.NO_DO = kdt.REQUEST_NUMBER
        and kad.REQUEST_BY = ppf.NATIONAL_IDENTIFIER
        and kad.APPROVED_BY = ppf1.NATIONAL_IDENTIFIER
        and kdt.PERSON_ID = ppf2.NATIONAL_IDENTIFIER
        and kdt.REQUEST_NUMBER = '$data'
        and kad.STATUS = 'Approved'")->result_array();

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
