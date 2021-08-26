<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_report extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->prod = $this->load->database('oracle', TRUE);
        $this->dev = $this->load->database('oracle_dev', TRUE);
    }

    public function GetSPB($param)
    {
        $query = $this->prod->query(
            "SELECT DISTINCT request_number NUMBER_NYAA
            FROM mtl_txn_request_headers
           WHERE request_number IS NOT NULL AND attribute15 IS NOT NULL $param"
        );
        return $query->result_array();
    }
    public function GetDOSP($param)
    {
        $query = $this->prod->query(
            "SELECT DISTINCT wdd.batch_id NUMBER_NYAA
            FROM wsh_delivery_details wdd,
                 mtl_txn_request_headers mtrh,
                 mtl_txn_request_lines mtrl
           WHERE wdd.batch_id IS NOT NULL
             AND wdd.move_order_line_id IS NOT NULL
             AND wdd.move_order_line_id = mtrl.line_id
             AND mtrl.header_id = mtrh.header_id
             AND mtrh.attribute15 IN ('SADANA', 'JPM', 'TAM') $param"
        );
        return $query->result_array();
    }
    public function getSPBDOSP($param)
    {
        $query = $this->prod->query(
            "select nomor NUMBER_NYAA from 
            (SELECT DISTINCT request_number nomor
                       FROM mtl_txn_request_headers
                      WHERE request_number IS NOT NULL AND attribute15 IS NOT NULL
            UNION
            SELECT DISTINCT to_char(batch_id) nomor
                       FROM wsh_delivery_details
                      WHERE batch_id IS NOT NULL)
            $param"
        );
        return $query->result_array();
    }
    public function PembedaNoSPBDOSP($nomor)
    {
        $query = $this->prod->query("select
            '$nomor' nomor,
            case 
                when (select attribute4 from mtl_txn_request_headers
                      where request_number = '$nomor') is not null
                      then 'SPB'
                when (select distinct batch_id from wsh_delivery_details
                      where batch_id = '$nomor') is not null
                      then 'DOSP'
                else 'Undefined'
            end tipe
        from dual");
        return $query->result_array();
    }
    public function GetEkspedisiperBulan()
    {
        $query = $this->prod->query("SELECT DISTINCT EXTRACT (MONTH FROM kep.creation_date) id_bulan,
        TO_CHAR (kep.creation_date, 'Month') bulan, eksp.ekspedisi
   FROM khs_exp_pengiriman_sp kep,
        (SELECT     TRIM (REGEXP_SUBSTR ('SADANA,TAM',
                                         '[^,]+',
                                         1,
                                         LEVEL
                                        )
                         ) ekspedisi
               FROM DUAL
         CONNECT BY REGEXP_SUBSTR ('SADANA,TAM', '[^,]+', 1, LEVEL) IS NOT NULL
           ORDER BY LEVEL) eksp");
        return $query->result_array();
    }
    public function GetrekapEkspedisiperBulan($bulan, $ekpedisi)
    {
        $query = $this->prod->query("select distinct
        kep.data_id,
        to_char(kep.creation_date) tgl_buat,
        kep.no_resi,
        to_date(kep.tanggal_resi, 'DD/MM/YY') tanggal_resi,
        kep.cost_center,
        eksp.expedisi relasi,
        eksp.exp_type,
        eksp.city,
        kep.value_desc index_type,
        kep.exp_id,
        string_agg(ken.value_num) over (partition by ken.data_id) nomor,
        kep.colly,
        kep.qty
    from
        KHS_EXP_NUMBER_VALUES ken,
        KHS_EXP_RELATIONS ker,
        KHS_EXP_PENGIRIMAN_SP kep,
        (SELECT data_id, expedisi, city, exp_type, 'SPB' tipe
      FROM khs_exp_relations ker, KHS_EXP_PENGIRIMAN_SP kep
     WHERE ker.exp_id = kep.exp_id
       AND extract(month from kep.creation_date) = $bulan
       AND ker.exp_type = '$ekpedisi'
       AND ker.exp_id > 0
    UNION
    SELECT DISTINCT ken.data_id, hp.party_name, hp.city, mtrh.attribute15,
                    'DOSP' tipe
               FROM wsh_delivery_details wdd,
                    mtl_txn_request_lines mtrl,
                    mtl_txn_request_headers mtrh,
                    hz_parties hp,
                    hz_cust_accounts hca,
                    oe_order_headers_all ooha,
                    oe_order_lines_all oola,
                    (select distinct * from KHS_EXP_NUMBER_VALUES k1
                     where k1.value_id = (select min(k2.value_id) from khs_exp_number_values k2 where k2.data_id = k1.data_id)) ken,
                    KHS_EXP_PENGIRIMAN_SP kep
              WHERE mtrl.header_id = mtrh.header_id
                AND mtrl.line_id = wdd.move_order_line_id
                AND mtrh.attribute15 IS NOT NULL
                AND hp.party_id = hca.party_id
                AND wdd.source_line_id = oola.line_id
                AND oola.header_id = ooha.header_id
                AND ooha.sold_to_org_id = hca.cust_account_id
                AND mtrh.attribute15 IS NOT NULL
                AND to_char(wdd.batch_id) = ken.value_num
                AND ken.data_id = kep.data_id
                AND mtrh.attribute15 = '$ekpedisi'
                AND extract(month from kep.creation_date) = $bulan) eksp
    where
        kep.exp_id = ker.exp_id
        and ken.data_id = kep.data_id
        and kep.data_id = eksp.data_id");
        return $query->result_array();
    }
    public function GetrekapEkspedisiperId($id)
    {
        $query = $this->prod->query("select distinct
        kep.data_id,
        to_char(kep.creation_date) tgl_buat,
        kep.no_resi,
        to_date(kep.tanggal_resi, 'DD/MM/YY') tanggal_resi,
        kep.cost_center,
        eksp.expedisi relasi,
        eksp.exp_type,
        eksp.city,
        kep.value_desc index_type,
        kep.exp_id,
        string_agg(ken.value_num) over (partition by ken.data_id) nomor,
        kep.colly,
        kep.qty
    from
        KHS_EXP_NUMBER_VALUES ken,
        KHS_EXP_RELATIONS ker,
        KHS_EXP_PENGIRIMAN_SP kep,
        (SELECT data_id, expedisi, city, exp_type, 'SPB' tipe
      FROM khs_exp_relations ker, KHS_EXP_PENGIRIMAN_SP kep
     WHERE ker.exp_id = kep.exp_id
     AND kep.data_id = $id
       AND ker.exp_id > 0
    UNION
    SELECT DISTINCT ken.data_id, hp.party_name, hp.city, mtrh.attribute15,
                    'DOSP' tipe
               FROM wsh_delivery_details wdd,
                    mtl_txn_request_lines mtrl,
                    mtl_txn_request_headers mtrh,
                    hz_parties hp,
                    hz_cust_accounts hca,
                    oe_order_headers_all ooha,
                    oe_order_lines_all oola,
                    (select distinct * from KHS_EXP_NUMBER_VALUES k1
                     where k1.value_id = (select min(k2.value_id) from khs_exp_number_values k2 where k2.data_id = k1.data_id)) ken,
                    KHS_EXP_PENGIRIMAN_SP kep
              WHERE mtrl.header_id = mtrh.header_id
                AND mtrl.line_id = wdd.move_order_line_id
                AND mtrh.attribute15 IS NOT NULL
                AND hp.party_id = hca.party_id
                AND wdd.source_line_id = oola.line_id
                AND oola.header_id = ooha.header_id
                AND ooha.sold_to_org_id = hca.cust_account_id
                AND mtrh.attribute15 IS NOT NULL
                AND to_char(wdd.batch_id) = ken.value_num
                AND ken.data_id = kep.data_id
                AND kep.data_id = $id) eksp
    where
        kep.exp_id = ker.exp_id
        and ken.data_id = kep.data_id
        and kep.data_id = eksp.data_id");
        return $query->result_array();
    }
    public function getDataNumSPB($numSPB)
    {
        $query = $this->prod->query("select
        mtrh.request_number,
        ker.expedisi,
        ker.city,
        ker.exp_id,
        case 
            when hla.location_code is not null then '3B02'
            else '3J99'
        end cost_center      
    from
        khs_exp_relations ker,
        mtl_txn_request_headers mtrh,
        mtl_secondary_inventories msi,
        hr_locations_all hla
    where 1=1
        and mtrh.attribute4 like '%' || ker.key1 || '%'
        and mtrh.attribute4 like '%' || ker.key2 || '%'
        and mtrh.attribute4 like '%' || ker.key3 || '%'
        and mtrh.attribute4 like '%' || ker.key4 || '%'
        and mtrh.attribute4 like '%' || ker.key5 || '%'
        and mtrh.attribute4 like '%' || ker.key6 || '%'
        and mtrh.attribute4 like '%' || ker.key7 || '%'
        and mtrh.attribute2 = msi.secondary_inventory_name(+)
        and msi.location_id = hla.location_id(+)
        and mtrh.attribute15 like '%' || ker.exp_type || '%'
        and mtrh.request_number = '$numSPB'");
        return $query->result_array();
    }
    public function getDataNumDOSP($numDOSP)
    {
        $query = $this->prod->query("select distinct
        wdd.batch_id,
        hp.party_name,
        wdd.subinventory,
        ooha.sold_to_org_id,
        hp.city,
        case 
            when hp.party_id in (38702, 39056, 39058, 52562)
                then '3B05'
            when upper(city) like '%JKT%'
                 or upper(city) like '%YGY%'
                 or upper(city) like '%JAKARTA%'
                 or upper(city) like '%YOGYAKARTA%'
                 then '3B02'
            else '3J99'
        end tujuan
    from
        oe_order_headers_all ooha,
        oe_order_lines_all oola,
        wsh_delivery_details wdd,
        hz_cust_accounts hca,
        hz_parties hp
    where 1=1
        and wdd.source_line_id = oola.line_id
        and wdd.source_header_id = oola.header_id
        and oola.header_id = ooha.header_id
        and ooha.sold_to_org_id = hca.cust_account_id
        and hca.party_id = hp.party_id
        and wdd.batch_id = $numDOSP");

        return $query->result_array();
    }
    public function cekDataIDExpress($n)
    {
        $query = $this->prod->query(
            "SELECT * FROM KHS_EXP_PENGIRIMAN_SP WHERE DATA_ID= $n"
        );
        return $query->result_array();
    }
    public function InsertDataExpress($jenis_nomor_ekspedisi_express, $dataId, $DateKirimExpress, $no_resi_express, $cost_center_express, $relasi_id_express, $tujuan_express, $colly_express, $berat_express, $biaya_express)
    {
        $this->prod->query(
            "INSERT INTO KHS_EXP_PENGIRIMAN_SP(
                DATA_ID,
                NO_RESI,
                TANGGAL_RESI,
                COST_CENTER,
                EXP_ID,
                VALUE_DESC,
                COLLY,
                QTY
                )VALUES(
                    $dataId,
                    $no_resi_express,
                    TO_DATE('$DateKirimExpress', 'DD/MM/YYYY'), 
                    '$cost_center_express',
                    $relasi_id_express,
                    '$jenis_nomor_ekspedisi_express',
                    $colly_express,
                    $berat_express
                )"
        );
        // return $query->result_array();
    }
    public function InsertDataExpressNum($dataId, $value_num)
    {
        $this->prod->query(
            "INSERT INTO KHS_EXP_NUMBER_VALUES(
                DATA_ID,
                VALUE_NUM
                )VALUES(
                    $dataId,
                    '$value_num'
                )"
        );
    }
    public function DeleteDataExpress($id)
    {
        $this->prod->query(
            "DELETE FROM KHS_EXP_PENGIRIMAN_SP WHERE DATA_ID= $id"
        );
        $this->prod->query(
            "DELETE FROM KHS_EXP_NUMBER_VALUES WHERE DATA_ID= $id"
        );
    }
}
