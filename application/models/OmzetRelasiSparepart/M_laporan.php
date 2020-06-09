<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_laporan extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function GetReport($tahun,$org_id,$order_type)
    {
        $ho = 'Dalam Negeri';
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT 
        DATA.CUST_ACCOUNT_ID,
        DATA.ACCOUNT_NUMBER,
        DATA.PARTY_NAME,
        DATA.ORDER_TYPE,
        DATA.JAN,
        DATA.FEB,
        DATA.MAR,
        DATA.APR,
        DATA.MAY,
        DATA.JUN,
        DATA.JUL,
        DATA.AUG,
        DATA.SEP,
        DATA.OKT,
        DATA.NOV,
        DATA.DEC,
        (
            NVL(DATA.JAN,0) + NVL(DATA.FEB,0) +
            NVL(DATA.MAR,0) + NVL(DATA.APR,0) + 
            NVL(DATA.MAY,0) + NVL(DATA.JUN,0) + 
            NVL(DATA.JUL,0) + NVL(DATA.AUG,0) +
            NVL(DATA.SEP,0) + NVL(DATA.OKT,0) +
            NVL(DATA.NOV,0) + NVL(DATA.DEC,0)
        ) JUMLAH
     FROM
        (SELECT DISTINCT
            SUB_DATA.CUST_ACCOUNT_ID,
            SUB_DATA.ACCOUNT_NUMBER,
            SUB_DATA.PARTY_NAME,
            SUB_DATA.ORDER_TYPE,
        ( 
         select floor(sum(nvl(TAB.amount,0)) - sum(nvl(TAB.adjustment,0))) 
         from
            HZ_CUST_ACCOUNTS SUB_HCA,
            (
            SELECT DISTINCT
                RCTLA.EXTENDED_AMOUNT amount
                ,(select distinct
                        case when arta.name = 'Kurang Byr Beda Discount' and sum(aaa.amount) >5000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Bi. Administrasi' and sum(aaa.amount) >30000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Beda Hrg Jual' then
                        sum(NVL(aaa.amount,0))
                        else
                        0
                        end adjustment
                   from 
                       ar_adjustments_all aaa,ar_receivables_trx_all arta
                   where 
                       aaa.receivables_trx_id = arta.receivables_trx_id
                       and aaa.customer_trx_id = rcta.customer_trx_id
                       and aaa.status != 'W'
                   group by arta.name) adjustment,
                   RCTA.SOLD_TO_CUSTOMER_ID,
                   SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) BULAN
            FROM
                RA_CUSTOMER_TRX_ALL RCTA
                ,RA_CUSTOMER_TRX_LINES_ALL RCTLA
                ,OE_ORDER_HEADERS_ALL OOHA
                ,OE_TRANSACTION_TYPES_TL OTTT
                ,MTL_SYSTEM_ITEMS_B MSIB
            WHERE
                RCTA.CUSTOMER_TRX_ID = RCTLA.CUSTOMER_TRX_ID
                AND TO_NUMBER(SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 8, 4)) = $tahun
                AND SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) = 'JAN'
                AND OOHA.ORG_ID = $org_id
                AND OOHA.ORDER_NUMBER = RCTA.CT_REFERENCE
                AND OOHA.ORDER_TYPE_ID = OTTT.TRANSACTION_TYPE_ID
                AND RCTLA.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND RCTLA.EXTENDED_AMOUNT != 0
                AND UPPER (TRIM (REPLACE (OTTT.NAME, ' ', ''))) LIKE CASE WHEN $order_type = 1 THEN '%TRAKTOR%SAP%'
                                                                            WHEN $order_type = 2 THEN '%HDE%SHDE%'
                                                                            WHEN $order_type = 3 THEN '%VDE%SVDE%'
                                                                            WHEN $order_type = 4 THEN '%VBELTMITSUBOSHI%' 
                                                                            WHEN $order_type = 5 THEN '%VBELTBANDO%'
                                                                            WHEN $order_type = 6 THEN '%BEARINGNACHI%'
                                                                            WHEN $order_type = 7 THEN '%BEARINGSKF%'
                                                                            WHEN $order_type = 8 THEN '%RUBBERROLL%'
                                                                        END
                AND (ottt.DESCRIPTION like decode('$ho','Luar Negeri','%LN','%DN') or ottt.DESCRIPTION like decode('$ho','Luar Negeri','%Luar Negeri%','%Dalam Negeri%'))) TAB
            WHERE
                SUB_DATA.CUST_ACCOUNT_ID = SUB_HCA.CUST_ACCOUNT_ID
                AND SUB_HCA.CUST_ACCOUNT_ID = TAB.SOLD_TO_CUSTOMER_ID
        --        AND TAB.BULAN = SUB_DATA.BULAN
        )JAN,
        ( 
         select floor(sum(nvl(TAB.amount,0)) - sum(nvl(TAB.adjustment,0))) 
         from
            HZ_CUST_ACCOUNTS SUB_HCA,
            (
            SELECT DISTINCT
                RCTLA.EXTENDED_AMOUNT amount
                ,(select distinct
                        case when arta.name = 'Kurang Byr Beda Discount' and sum(aaa.amount) >5000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Bi. Administrasi' and sum(aaa.amount) >30000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Beda Hrg Jual' then
                        sum(NVL(aaa.amount,0))
                        else
                        0
                        end adjustment
                   from 
                       ar_adjustments_all aaa,ar_receivables_trx_all arta
                   where 
                       aaa.receivables_trx_id = arta.receivables_trx_id
                       and aaa.customer_trx_id = rcta.customer_trx_id
                       and aaa.status != 'W'
                   group by arta.name) adjustment,
                   RCTA.SOLD_TO_CUSTOMER_ID,
                   SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) BULAN
            FROM
                RA_CUSTOMER_TRX_ALL RCTA
                ,RA_CUSTOMER_TRX_LINES_ALL RCTLA
                ,OE_ORDER_HEADERS_ALL OOHA
                ,OE_TRANSACTION_TYPES_TL OTTT
                ,MTL_SYSTEM_ITEMS_B MSIB
            WHERE
                RCTA.CUSTOMER_TRX_ID = RCTLA.CUSTOMER_TRX_ID
                AND TO_NUMBER(SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 8, 4)) = $tahun
                AND SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) = 'FEB'
                AND OOHA.ORG_ID = $org_id
                AND OOHA.ORDER_NUMBER = RCTA.CT_REFERENCE
                AND OOHA.ORDER_TYPE_ID = OTTT.TRANSACTION_TYPE_ID
                AND RCTLA.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND RCTLA.EXTENDED_AMOUNT != 0
                AND UPPER (TRIM (REPLACE (OTTT.NAME, ' ', ''))) LIKE CASE WHEN $order_type = 1 THEN '%TRAKTOR%SAP%'
                                                                            WHEN $order_type = 2 THEN '%HDE%SHDE%'
                                                                            WHEN $order_type = 3 THEN '%VDE%SVDE%'
                                                                            WHEN $order_type = 4 THEN '%VBELTMITSUBOSHI%' 
                                                                            WHEN $order_type = 5 THEN '%VBELTBANDO%'
                                                                            WHEN $order_type = 6 THEN '%BEARINGNACHI%'
                                                                            WHEN $order_type = 7 THEN '%BEARINGSKF%'
                                                                            WHEN $order_type = 8 THEN '%RUBBERROLL%'
                                                                        END
                AND (ottt.DESCRIPTION like decode('$ho','Luar Negeri','%LN','%DN') or ottt.DESCRIPTION like decode('$ho','Luar Negeri','%Luar Negeri%','%Dalam Negeri%'))) TAB
            WHERE
                SUB_DATA.CUST_ACCOUNT_ID = SUB_HCA.CUST_ACCOUNT_ID
                AND SUB_HCA.CUST_ACCOUNT_ID = TAB.SOLD_TO_CUSTOMER_ID
        )FEB,
        ( 
         select floor(sum(nvl(TAB.amount,0)) - sum(nvl(TAB.adjustment,0))) 
         from
            HZ_CUST_ACCOUNTS SUB_HCA,
            (
            SELECT DISTINCT
                RCTLA.EXTENDED_AMOUNT amount
                ,(select distinct
                        case when arta.name = 'Kurang Byr Beda Discount' and sum(aaa.amount) >5000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Bi. Administrasi' and sum(aaa.amount) >30000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Beda Hrg Jual' then
                        sum(NVL(aaa.amount,0))
                        else
                        0
                        end adjustment
                   from 
                       ar_adjustments_all aaa,ar_receivables_trx_all arta
                   where 
                       aaa.receivables_trx_id = arta.receivables_trx_id
                       and aaa.customer_trx_id = rcta.customer_trx_id
                       and aaa.status != 'W'
                   group by arta.name) adjustment,
                   RCTA.SOLD_TO_CUSTOMER_ID,
                   SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) BULAN
            FROM
                RA_CUSTOMER_TRX_ALL RCTA
                ,RA_CUSTOMER_TRX_LINES_ALL RCTLA
                ,OE_ORDER_HEADERS_ALL OOHA
                ,OE_TRANSACTION_TYPES_TL OTTT
                ,MTL_SYSTEM_ITEMS_B MSIB
            WHERE
                RCTA.CUSTOMER_TRX_ID = RCTLA.CUSTOMER_TRX_ID
                AND TO_NUMBER(SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 8, 4)) = $tahun
                AND SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) = 'MAR'
                AND OOHA.ORG_ID = $org_id
                AND OOHA.ORDER_NUMBER = RCTA.CT_REFERENCE
                AND OOHA.ORDER_TYPE_ID = OTTT.TRANSACTION_TYPE_ID
                AND RCTLA.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND RCTLA.EXTENDED_AMOUNT != 0
                AND UPPER (TRIM (REPLACE (OTTT.NAME, ' ', ''))) LIKE CASE WHEN $order_type = 1 THEN '%TRAKTOR%SAP%'
                                                                            WHEN $order_type = 2 THEN '%HDE%SHDE%'
                                                                            WHEN $order_type = 3 THEN '%VDE%SVDE%'
                                                                            WHEN $order_type = 4 THEN '%VBELTMITSUBOSHI%' 
                                                                            WHEN $order_type = 5 THEN '%VBELTBANDO%'
                                                                            WHEN $order_type = 6 THEN '%BEARINGNACHI%'
                                                                            WHEN $order_type = 7 THEN '%BEARINGSKF%'
                                                                            WHEN $order_type = 8 THEN '%RUBBERROLL%'
                                                                        END
                AND (ottt.DESCRIPTION like decode('$ho','Luar Negeri','%LN','%DN') or ottt.DESCRIPTION like decode('$ho','Luar Negeri','%Luar Negeri%','%Dalam Negeri%'))) TAB
            WHERE
                SUB_DATA.CUST_ACCOUNT_ID = SUB_HCA.CUST_ACCOUNT_ID
                AND SUB_HCA.CUST_ACCOUNT_ID = TAB.SOLD_TO_CUSTOMER_ID
        --        AND TAB.BULAN = SUB_DATA.BULAN
        )MAR,
        ( 
         select floor(sum(nvl(TAB.amount,0)) - sum(nvl(TAB.adjustment,0))) 
         from
            HZ_CUST_ACCOUNTS SUB_HCA,
            (
            SELECT DISTINCT
                RCTLA.EXTENDED_AMOUNT amount
                ,(select distinct
                        case when arta.name = 'Kurang Byr Beda Discount' and sum(aaa.amount) >5000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Bi. Administrasi' and sum(aaa.amount) >30000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Beda Hrg Jual' then
                        sum(NVL(aaa.amount,0))
                        else
                        0
                        end adjustment
                   from 
                       ar_adjustments_all aaa,ar_receivables_trx_all arta
                   where 
                       aaa.receivables_trx_id = arta.receivables_trx_id
                       and aaa.customer_trx_id = rcta.customer_trx_id
                       and aaa.status != 'W'
                   group by arta.name) adjustment,
                   RCTA.SOLD_TO_CUSTOMER_ID,
                   SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) BULAN
            FROM
                RA_CUSTOMER_TRX_ALL RCTA
                ,RA_CUSTOMER_TRX_LINES_ALL RCTLA
                ,OE_ORDER_HEADERS_ALL OOHA
                ,OE_TRANSACTION_TYPES_TL OTTT
                ,MTL_SYSTEM_ITEMS_B MSIB
            WHERE
                RCTA.CUSTOMER_TRX_ID = RCTLA.CUSTOMER_TRX_ID
                AND TO_NUMBER(SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 8, 4)) = $tahun
                AND SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) = 'APR'
                AND OOHA.ORG_ID = $org_id
                AND OOHA.ORDER_NUMBER = RCTA.CT_REFERENCE
                AND OOHA.ORDER_TYPE_ID = OTTT.TRANSACTION_TYPE_ID
                AND RCTLA.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND RCTLA.EXTENDED_AMOUNT != 0
                AND UPPER (TRIM (REPLACE (OTTT.NAME, ' ', ''))) LIKE CASE WHEN $order_type = 1 THEN '%TRAKTOR%SAP%'
                                                                            WHEN $order_type = 2 THEN '%HDE%SHDE%'
                                                                            WHEN $order_type = 3 THEN '%VDE%SVDE%'
                                                                            WHEN $order_type = 4 THEN '%VBELTMITSUBOSHI%' 
                                                                            WHEN $order_type = 5 THEN '%VBELTBANDO%'
                                                                            WHEN $order_type = 6 THEN '%BEARINGNACHI%'
                                                                            WHEN $order_type = 7 THEN '%BEARINGSKF%'
                                                                            WHEN $order_type = 8 THEN '%RUBBERROLL%'
                                                                        END
                AND (ottt.DESCRIPTION like decode('$ho','Luar Negeri','%LN','%DN') or ottt.DESCRIPTION like decode('$ho','Luar Negeri','%Luar Negeri%','%Dalam Negeri%'))) TAB
            WHERE
                SUB_DATA.CUST_ACCOUNT_ID = SUB_HCA.CUST_ACCOUNT_ID
                AND SUB_HCA.CUST_ACCOUNT_ID = TAB.SOLD_TO_CUSTOMER_ID
        --        AND TAB.BULAN = SUB_DATA.BULAN
        )APR,
        ( 
         select floor(sum(nvl(TAB.amount,0)) - sum(nvl(TAB.adjustment,0))) 
         from
            HZ_CUST_ACCOUNTS SUB_HCA,
            (
            SELECT DISTINCT
                RCTLA.EXTENDED_AMOUNT amount
                ,(select distinct
                        case when arta.name = 'Kurang Byr Beda Discount' and sum(aaa.amount) >5000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Bi. Administrasi' and sum(aaa.amount) >30000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Beda Hrg Jual' then
                        sum(NVL(aaa.amount,0))
                        else
                        0
                        end adjustment
                   from 
                       ar_adjustments_all aaa,ar_receivables_trx_all arta
                   where 
                       aaa.receivables_trx_id = arta.receivables_trx_id
                       and aaa.customer_trx_id = rcta.customer_trx_id
                       and aaa.status != 'W'
                   group by arta.name) adjustment,
                   RCTA.SOLD_TO_CUSTOMER_ID,
                   SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) BULAN
            FROM
                RA_CUSTOMER_TRX_ALL RCTA
                ,RA_CUSTOMER_TRX_LINES_ALL RCTLA
                ,OE_ORDER_HEADERS_ALL OOHA
                ,OE_TRANSACTION_TYPES_TL OTTT
                ,MTL_SYSTEM_ITEMS_B MSIB
            WHERE
                RCTA.CUSTOMER_TRX_ID = RCTLA.CUSTOMER_TRX_ID
                AND TO_NUMBER(SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 8, 4)) = $tahun
                AND SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) = 'MAY'
                AND OOHA.ORG_ID = $org_id
                AND OOHA.ORDER_NUMBER = RCTA.CT_REFERENCE
                AND OOHA.ORDER_TYPE_ID = OTTT.TRANSACTION_TYPE_ID
                AND RCTLA.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND RCTLA.EXTENDED_AMOUNT != 0
                AND UPPER (TRIM (REPLACE (OTTT.NAME, ' ', ''))) LIKE CASE WHEN $order_type = 1 THEN '%TRAKTOR%SAP%'
                                                                            WHEN $order_type = 2 THEN '%HDE%SHDE%'
                                                                            WHEN $order_type = 3 THEN '%VDE%SVDE%'
                                                                            WHEN $order_type = 4 THEN '%VBELTMITSUBOSHI%' 
                                                                            WHEN $order_type = 5 THEN '%VBELTBANDO%'
                                                                            WHEN $order_type = 6 THEN '%BEARINGNACHI%'
                                                                            WHEN $order_type = 7 THEN '%BEARINGSKF%'
                                                                            WHEN $order_type = 8 THEN '%RUBBERROLL%'
                                                                        END
                AND (ottt.DESCRIPTION like decode('$ho','Luar Negeri','%LN','%DN') or ottt.DESCRIPTION like decode('$ho','Luar Negeri','%Luar Negeri%','%Dalam Negeri%'))) TAB
            WHERE
                SUB_DATA.CUST_ACCOUNT_ID = SUB_HCA.CUST_ACCOUNT_ID
                AND SUB_HCA.CUST_ACCOUNT_ID = TAB.SOLD_TO_CUSTOMER_ID
        --        AND TAB.BULAN = SUB_DATA.BULAN
        )MAY,
        ( 
         select floor(sum(nvl(TAB.amount,0)) - sum(nvl(TAB.adjustment,0))) 
         from
            HZ_CUST_ACCOUNTS SUB_HCA,
            (
            SELECT DISTINCT
                RCTLA.EXTENDED_AMOUNT amount
                ,(select distinct
                        case when arta.name = 'Kurang Byr Beda Discount' and sum(aaa.amount) >5000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Bi. Administrasi' and sum(aaa.amount) >30000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Beda Hrg Jual' then
                        sum(NVL(aaa.amount,0))
                        else
                        0
                        end adjustment
                   from 
                       ar_adjustments_all aaa,ar_receivables_trx_all arta
                   where 
                       aaa.receivables_trx_id = arta.receivables_trx_id
                       and aaa.customer_trx_id = rcta.customer_trx_id
                       and aaa.status != 'W'
                   group by arta.name) adjustment,
                   RCTA.SOLD_TO_CUSTOMER_ID,
                   SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) BULAN
            FROM
                RA_CUSTOMER_TRX_ALL RCTA
                ,RA_CUSTOMER_TRX_LINES_ALL RCTLA
                ,OE_ORDER_HEADERS_ALL OOHA
                ,OE_TRANSACTION_TYPES_TL OTTT
                ,MTL_SYSTEM_ITEMS_B MSIB
            WHERE
                RCTA.CUSTOMER_TRX_ID = RCTLA.CUSTOMER_TRX_ID
                AND TO_NUMBER(SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 8, 4)) = $tahun
                AND SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) = 'JUN'
                AND OOHA.ORG_ID = $org_id
                AND OOHA.ORDER_NUMBER = RCTA.CT_REFERENCE
                AND OOHA.ORDER_TYPE_ID = OTTT.TRANSACTION_TYPE_ID
                AND RCTLA.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND RCTLA.EXTENDED_AMOUNT != 0
                AND UPPER (TRIM (REPLACE (OTTT.NAME, ' ', ''))) LIKE CASE WHEN $order_type = 1 THEN '%TRAKTOR%SAP%'
                                                                            WHEN $order_type = 2 THEN '%HDE%SHDE%'
                                                                            WHEN $order_type = 3 THEN '%VDE%SVDE%'
                                                                            WHEN $order_type = 4 THEN '%VBELTMITSUBOSHI%' 
                                                                            WHEN $order_type = 5 THEN '%VBELTBANDO%'
                                                                            WHEN $order_type = 6 THEN '%BEARINGNACHI%'
                                                                            WHEN $order_type = 7 THEN '%BEARINGSKF%'
                                                                            WHEN $order_type = 8 THEN '%RUBBERROLL%'
                                                                        END
                AND (ottt.DESCRIPTION like decode('$ho','Luar Negeri','%LN','%DN') or ottt.DESCRIPTION like decode('$ho','Luar Negeri','%Luar Negeri%','%Dalam Negeri%'))) TAB
            WHERE
                SUB_DATA.CUST_ACCOUNT_ID = SUB_HCA.CUST_ACCOUNT_ID
                AND SUB_HCA.CUST_ACCOUNT_ID = TAB.SOLD_TO_CUSTOMER_ID
        --        AND TAB.BULAN = SUB_DATA.BULAN
        )JUN,
        ( 
         select floor(sum(nvl(TAB.amount,0)) - sum(nvl(TAB.adjustment,0))) 
         from
            HZ_CUST_ACCOUNTS SUB_HCA,
            (
            SELECT DISTINCT
                RCTLA.EXTENDED_AMOUNT amount
                ,(select distinct
                        case when arta.name = 'Kurang Byr Beda Discount' and sum(aaa.amount) >5000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Bi. Administrasi' and sum(aaa.amount) >30000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Beda Hrg Jual' then
                        sum(NVL(aaa.amount,0))
                        else
                        0
                        end adjustment
                   from 
                       ar_adjustments_all aaa,ar_receivables_trx_all arta
                   where 
                       aaa.receivables_trx_id = arta.receivables_trx_id
                       and aaa.customer_trx_id = rcta.customer_trx_id
                       and aaa.status != 'W'
                   group by arta.name) adjustment,
                   RCTA.SOLD_TO_CUSTOMER_ID,
                   SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) BULAN
            FROM
                RA_CUSTOMER_TRX_ALL RCTA
                ,RA_CUSTOMER_TRX_LINES_ALL RCTLA
                ,OE_ORDER_HEADERS_ALL OOHA
                ,OE_TRANSACTION_TYPES_TL OTTT
                ,MTL_SYSTEM_ITEMS_B MSIB
            WHERE
                RCTA.CUSTOMER_TRX_ID = RCTLA.CUSTOMER_TRX_ID
                AND TO_NUMBER(SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 8, 4)) = $tahun
                AND SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) = 'JUL'
                AND OOHA.ORG_ID = $org_id
                AND OOHA.ORDER_NUMBER = RCTA.CT_REFERENCE
                AND OOHA.ORDER_TYPE_ID = OTTT.TRANSACTION_TYPE_ID
                AND RCTLA.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND RCTLA.EXTENDED_AMOUNT != 0
                AND UPPER (TRIM (REPLACE (OTTT.NAME, ' ', ''))) LIKE CASE WHEN $order_type = 1 THEN '%TRAKTOR%SAP%'
                                                                            WHEN $order_type = 2 THEN '%HDE%SHDE%'
                                                                            WHEN $order_type = 3 THEN '%VDE%SVDE%'
                                                                            WHEN $order_type = 4 THEN '%VBELTMITSUBOSHI%' 
                                                                            WHEN $order_type = 5 THEN '%VBELTBANDO%'
                                                                            WHEN $order_type = 6 THEN '%BEARINGNACHI%'
                                                                            WHEN $order_type = 7 THEN '%BEARINGSKF%'
                                                                            WHEN $order_type = 8 THEN '%RUBBERROLL%'
                                                                        END
                AND (ottt.DESCRIPTION like decode('$ho','Luar Negeri','%LN','%DN') or ottt.DESCRIPTION like decode('$ho','Luar Negeri','%Luar Negeri%','%Dalam Negeri%'))) TAB
            WHERE
                SUB_DATA.CUST_ACCOUNT_ID = SUB_HCA.CUST_ACCOUNT_ID
                AND SUB_HCA.CUST_ACCOUNT_ID = TAB.SOLD_TO_CUSTOMER_ID
        --        AND TAB.BULAN = SUB_DATA.BULAN
        )JUL,
        ( 
         select floor(sum(nvl(TAB.amount,0)) - sum(nvl(TAB.adjustment,0))) 
         from
            HZ_CUST_ACCOUNTS SUB_HCA,
            (
            SELECT DISTINCT
                RCTLA.EXTENDED_AMOUNT amount
                ,(select distinct
                        case when arta.name = 'Kurang Byr Beda Discount' and sum(aaa.amount) >5000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Bi. Administrasi' and sum(aaa.amount) >30000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Beda Hrg Jual' then
                        sum(NVL(aaa.amount,0))
                        else
                        0
                        end adjustment
                   from 
                       ar_adjustments_all aaa,ar_receivables_trx_all arta
                   where 
                       aaa.receivables_trx_id = arta.receivables_trx_id
                       and aaa.customer_trx_id = rcta.customer_trx_id
                       and aaa.status != 'W'
                   group by arta.name) adjustment,
                   RCTA.SOLD_TO_CUSTOMER_ID,
                   SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) BULAN
            FROM
                RA_CUSTOMER_TRX_ALL RCTA
                ,RA_CUSTOMER_TRX_LINES_ALL RCTLA
                ,OE_ORDER_HEADERS_ALL OOHA
                ,OE_TRANSACTION_TYPES_TL OTTT
                ,MTL_SYSTEM_ITEMS_B MSIB
            WHERE
                RCTA.CUSTOMER_TRX_ID = RCTLA.CUSTOMER_TRX_ID
                AND TO_NUMBER(SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 8, 4)) = $tahun
                AND SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) = 'AUG'
                AND OOHA.ORG_ID = $org_id
                AND OOHA.ORDER_NUMBER = RCTA.CT_REFERENCE
                AND OOHA.ORDER_TYPE_ID = OTTT.TRANSACTION_TYPE_ID
                AND RCTLA.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND RCTLA.EXTENDED_AMOUNT != 0
                AND UPPER (TRIM (REPLACE (OTTT.NAME, ' ', ''))) LIKE CASE WHEN $order_type = 1 THEN '%TRAKTOR%SAP%'
                                                                            WHEN $order_type = 2 THEN '%HDE%SHDE%'
                                                                            WHEN $order_type = 3 THEN '%VDE%SVDE%'
                                                                            WHEN $order_type = 4 THEN '%VBELTMITSUBOSHI%' 
                                                                            WHEN $order_type = 5 THEN '%VBELTBANDO%'
                                                                            WHEN $order_type = 6 THEN '%BEARINGNACHI%'
                                                                            WHEN $order_type = 7 THEN '%BEARINGSKF%'
                                                                            WHEN $order_type = 8 THEN '%RUBBERROLL%'
                                                                        END
                AND (ottt.DESCRIPTION like decode('$ho','Luar Negeri','%LN','%DN') or ottt.DESCRIPTION like decode('$ho','Luar Negeri','%Luar Negeri%','%Dalam Negeri%'))) TAB
            WHERE
                SUB_DATA.CUST_ACCOUNT_ID = SUB_HCA.CUST_ACCOUNT_ID
                AND SUB_HCA.CUST_ACCOUNT_ID = TAB.SOLD_TO_CUSTOMER_ID
        --        AND TAB.BULAN = SUB_DATA.BULAN
        )AUG,
        ( 
         select floor(sum(nvl(TAB.amount,0)) - sum(nvl(TAB.adjustment,0))) 
         from
            HZ_CUST_ACCOUNTS SUB_HCA,
            (
            SELECT DISTINCT
                RCTLA.EXTENDED_AMOUNT amount
                ,(select distinct
                        case when arta.name = 'Kurang Byr Beda Discount' and sum(aaa.amount) >5000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Bi. Administrasi' and sum(aaa.amount) >30000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Beda Hrg Jual' then
                        sum(NVL(aaa.amount,0))
                        else
                        0
                        end adjustment
                   from 
                       ar_adjustments_all aaa,ar_receivables_trx_all arta
                   where 
                       aaa.receivables_trx_id = arta.receivables_trx_id
                       and aaa.customer_trx_id = rcta.customer_trx_id
                       and aaa.status != 'W'
                   group by arta.name) adjustment,
                   RCTA.SOLD_TO_CUSTOMER_ID,
                   SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) BULAN
            FROM
                RA_CUSTOMER_TRX_ALL RCTA
                ,RA_CUSTOMER_TRX_LINES_ALL RCTLA
                ,OE_ORDER_HEADERS_ALL OOHA
                ,OE_TRANSACTION_TYPES_TL OTTT
                ,MTL_SYSTEM_ITEMS_B MSIB
            WHERE
                RCTA.CUSTOMER_TRX_ID = RCTLA.CUSTOMER_TRX_ID
                AND TO_NUMBER(SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 8, 4)) = $tahun
                AND SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) = 'SEP'
                AND OOHA.ORG_ID = $org_id
                AND OOHA.ORDER_NUMBER = RCTA.CT_REFERENCE
                AND OOHA.ORDER_TYPE_ID = OTTT.TRANSACTION_TYPE_ID
                AND RCTLA.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND RCTLA.EXTENDED_AMOUNT != 0
                AND UPPER (TRIM (REPLACE (OTTT.NAME, ' ', ''))) LIKE CASE WHEN $order_type = 1 THEN '%TRAKTOR%SAP%'
                                                                            WHEN $order_type = 2 THEN '%HDE%SHDE%'
                                                                            WHEN $order_type = 3 THEN '%VDE%SVDE%'
                                                                            WHEN $order_type = 4 THEN '%VBELTMITSUBOSHI%' 
                                                                            WHEN $order_type = 5 THEN '%VBELTBANDO%'
                                                                            WHEN $order_type = 6 THEN '%BEARINGNACHI%'
                                                                            WHEN $order_type = 7 THEN '%BEARINGSKF%'
                                                                            WHEN $order_type = 8 THEN '%RUBBERROLL%'
                                                                        END
                AND (ottt.DESCRIPTION like decode('$ho','Luar Negeri','%LN','%DN') or ottt.DESCRIPTION like decode('$ho','Luar Negeri','%Luar Negeri%','%Dalam Negeri%'))) TAB
            WHERE
                SUB_DATA.CUST_ACCOUNT_ID = SUB_HCA.CUST_ACCOUNT_ID
                AND SUB_HCA.CUST_ACCOUNT_ID = TAB.SOLD_TO_CUSTOMER_ID
        --        AND TAB.BULAN = SUB_DATA.BULAN
        )SEP,
        ( 
         select floor(sum(nvl(TAB.amount,0)) - sum(nvl(TAB.adjustment,0))) 
         from
            HZ_CUST_ACCOUNTS SUB_HCA,
            (
            SELECT DISTINCT
                RCTLA.EXTENDED_AMOUNT amount
                ,(select distinct
                        case when arta.name = 'Kurang Byr Beda Discount' and sum(aaa.amount) >5000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Bi. Administrasi' and sum(aaa.amount) >30000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Beda Hrg Jual' then
                        sum(NVL(aaa.amount,0))
                        else
                        0
                        end adjustment
                   from 
                       ar_adjustments_all aaa,ar_receivables_trx_all arta
                   where 
                       aaa.receivables_trx_id = arta.receivables_trx_id
                       and aaa.customer_trx_id = rcta.customer_trx_id
                       and aaa.status != 'W'
                   group by arta.name) adjustment,
                   RCTA.SOLD_TO_CUSTOMER_ID,
                   SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) BULAN
            FROM
                RA_CUSTOMER_TRX_ALL RCTA
                ,RA_CUSTOMER_TRX_LINES_ALL RCTLA
                ,OE_ORDER_HEADERS_ALL OOHA
                ,OE_TRANSACTION_TYPES_TL OTTT
                ,MTL_SYSTEM_ITEMS_B MSIB
            WHERE
                RCTA.CUSTOMER_TRX_ID = RCTLA.CUSTOMER_TRX_ID
                AND TO_NUMBER(SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 8, 4)) = $tahun
                AND SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) = 'OKT'
                AND OOHA.ORG_ID = $org_id
                AND OOHA.ORDER_NUMBER = RCTA.CT_REFERENCE
                AND OOHA.ORDER_TYPE_ID = OTTT.TRANSACTION_TYPE_ID
                AND RCTLA.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND RCTLA.EXTENDED_AMOUNT != 0
                AND UPPER (TRIM (REPLACE (OTTT.NAME, ' ', ''))) LIKE CASE WHEN $order_type = 1 THEN '%TRAKTOR%SAP%'
                                                                            WHEN $order_type = 2 THEN '%HDE%SHDE%'
                                                                            WHEN $order_type = 3 THEN '%VDE%SVDE%'
                                                                            WHEN $order_type = 4 THEN '%VBELTMITSUBOSHI%' 
                                                                            WHEN $order_type = 5 THEN '%VBELTBANDO%'
                                                                            WHEN $order_type = 6 THEN '%BEARINGNACHI%'
                                                                            WHEN $order_type = 7 THEN '%BEARINGSKF%'
                                                                            WHEN $order_type = 8 THEN '%RUBBERROLL%'
                                                                        END
                AND (ottt.DESCRIPTION like decode('$ho','Luar Negeri','%LN','%DN') or ottt.DESCRIPTION like decode('$ho','Luar Negeri','%Luar Negeri%','%Dalam Negeri%'))) TAB
            WHERE
                SUB_DATA.CUST_ACCOUNT_ID = SUB_HCA.CUST_ACCOUNT_ID
                AND SUB_HCA.CUST_ACCOUNT_ID = TAB.SOLD_TO_CUSTOMER_ID
        --        AND TAB.BULAN = SUB_DATA.BULAN
        )OKT,
        ( 
         select floor(sum(nvl(TAB.amount,0)) - sum(nvl(TAB.adjustment,0))) 
         from
            HZ_CUST_ACCOUNTS SUB_HCA,
            (
            SELECT DISTINCT
                RCTLA.EXTENDED_AMOUNT amount
                ,(select distinct
                        case when arta.name = 'Kurang Byr Beda Discount' and sum(aaa.amount) >5000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Bi. Administrasi' and sum(aaa.amount) >30000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Beda Hrg Jual' then
                        sum(NVL(aaa.amount,0))
                        else
                        0
                        end adjustment
                   from 
                       ar_adjustments_all aaa,ar_receivables_trx_all arta
                   where 
                       aaa.receivables_trx_id = arta.receivables_trx_id
                       and aaa.customer_trx_id = rcta.customer_trx_id
                       and aaa.status != 'W'
                   group by arta.name) adjustment,
                   RCTA.SOLD_TO_CUSTOMER_ID,
                   SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) BULAN
            FROM
                RA_CUSTOMER_TRX_ALL RCTA
                ,RA_CUSTOMER_TRX_LINES_ALL RCTLA
                ,OE_ORDER_HEADERS_ALL OOHA
                ,OE_TRANSACTION_TYPES_TL OTTT
                ,MTL_SYSTEM_ITEMS_B MSIB
            WHERE
                RCTA.CUSTOMER_TRX_ID = RCTLA.CUSTOMER_TRX_ID
                AND TO_NUMBER(SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 8, 4)) = $tahun
                AND SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) = 'NOV'
                AND OOHA.ORG_ID = $org_id
                AND OOHA.ORDER_NUMBER = RCTA.CT_REFERENCE
                AND OOHA.ORDER_TYPE_ID = OTTT.TRANSACTION_TYPE_ID
                AND RCTLA.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND RCTLA.EXTENDED_AMOUNT != 0
                AND UPPER (TRIM (REPLACE (OTTT.NAME, ' ', ''))) LIKE CASE WHEN $order_type = 1 THEN '%TRAKTOR%SAP%'
                                                                            WHEN $order_type = 2 THEN '%HDE%SHDE%'
                                                                            WHEN $order_type = 3 THEN '%VDE%SVDE%'
                                                                            WHEN $order_type = 4 THEN '%VBELTMITSUBOSHI%' 
                                                                            WHEN $order_type = 5 THEN '%VBELTBANDO%'
                                                                            WHEN $order_type = 6 THEN '%BEARINGNACHI%'
                                                                            WHEN $order_type = 7 THEN '%BEARINGSKF%'
                                                                            WHEN $order_type = 8 THEN '%RUBBERROLL%'
                                                                        END
                AND (ottt.DESCRIPTION like decode('$ho','Luar Negeri','%LN','%DN') or ottt.DESCRIPTION like decode('$ho','Luar Negeri','%Luar Negeri%','%Dalam Negeri%'))) TAB
            WHERE
                SUB_DATA.CUST_ACCOUNT_ID = SUB_HCA.CUST_ACCOUNT_ID
                AND SUB_HCA.CUST_ACCOUNT_ID = TAB.SOLD_TO_CUSTOMER_ID
        --        AND TAB.BULAN = SUB_DATA.BULAN
        )NOV,
        ( 
         select floor(sum(nvl(TAB.amount,0)) - sum(nvl(TAB.adjustment,0))) 
         from
            HZ_CUST_ACCOUNTS SUB_HCA,
            (
            SELECT DISTINCT
                RCTLA.EXTENDED_AMOUNT amount
                ,(select distinct
                        case when arta.name = 'Kurang Byr Beda Discount' and sum(aaa.amount) >5000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Bi. Administrasi' and sum(aaa.amount) >30000 then
                        sum(NVL(aaa.amount,0))
                        when arta.name = 'Kurang Byr Beda Hrg Jual' then
                        sum(NVL(aaa.amount,0))
                        else
                        0
                        end adjustment
                   from 
                       ar_adjustments_all aaa,ar_receivables_trx_all arta
                   where 
                       aaa.receivables_trx_id = arta.receivables_trx_id
                       and aaa.customer_trx_id = rcta.customer_trx_id
                       and aaa.status != 'W'
                   group by arta.name) adjustment,
                   RCTA.SOLD_TO_CUSTOMER_ID,
                   SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) BULAN
            FROM
                RA_CUSTOMER_TRX_ALL RCTA
                ,RA_CUSTOMER_TRX_LINES_ALL RCTLA
                ,OE_ORDER_HEADERS_ALL OOHA
                ,OE_TRANSACTION_TYPES_TL OTTT
                ,MTL_SYSTEM_ITEMS_B MSIB
            WHERE
                RCTA.CUSTOMER_TRX_ID = RCTLA.CUSTOMER_TRX_ID
                AND TO_NUMBER(SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 8, 4)) = $tahun
                AND SUBSTR((TO_CHAR(RCTA.TRX_DATE, 'DD-MON-YYYY')), 4, 3) = 'DEC'
                AND OOHA.ORG_ID = $org_id
                AND OOHA.ORDER_NUMBER = RCTA.CT_REFERENCE
                AND OOHA.ORDER_TYPE_ID = OTTT.TRANSACTION_TYPE_ID
                AND RCTLA.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND RCTLA.EXTENDED_AMOUNT != 0
                AND UPPER (TRIM (REPLACE (OTTT.NAME, ' ', ''))) LIKE CASE WHEN $order_type = 1 THEN '%TRAKTOR%SAP%'
                                                                            WHEN $order_type = 2 THEN '%HDE%SHDE%'
                                                                            WHEN $order_type = 3 THEN '%VDE%SVDE%'
                                                                            WHEN $order_type = 4 THEN '%VBELTMITSUBOSHI%' 
                                                                            WHEN $order_type = 5 THEN '%VBELTBANDO%'
                                                                            WHEN $order_type = 6 THEN '%BEARINGNACHI%'
                                                                            WHEN $order_type = 7 THEN '%BEARINGSKF%'
                                                                            WHEN $order_type = 8 THEN '%RUBBERROLL%'
                                                                        END
                AND (ottt.DESCRIPTION like decode('$ho','Luar Negeri','%LN','%DN') or ottt.DESCRIPTION like decode('$ho','Luar Negeri','%Luar Negeri%','%Dalam Negeri%'))) TAB
            WHERE
                SUB_DATA.CUST_ACCOUNT_ID = SUB_HCA.CUST_ACCOUNT_ID
                AND SUB_HCA.CUST_ACCOUNT_ID = TAB.SOLD_TO_CUSTOMER_ID
        --        AND TAB.BULAN = SUB_DATA.BULAN
        )DEC
        FROM
            (
            select DISTINCT 
                hca.cust_account_id, 
                substr((to_char(rct.trx_date, 'DD-MON-YYYY')), 4, 3) bulan,
                HP.PARTY_NAME,
                HCA.ACCOUNT_NUMBER,
                OTTT.NAME ORDER_TYPE
              from
                oe_order_headers_all h,
                oe_transaction_types_tl ottt,
                ra_customer_trx_all rct,
                ra_cust_trx_types_all rctta,
                ra_customer_trx_lines_all rctl,
                ra_cust_trx_line_gl_dist_all rctd,
                gl_code_combinations gcc,
                fnd_flex_value_sets ffvs,
                fnd_flex_values_vl ffv,
                gl_code_combinations gcc1,
                fnd_flex_values_vl ffv1,
                mtl_system_items_b msi,
                mtl_item_categories_v cat,
                mtl_category_accounts_v mca
               ,hz_parties hp
               ,hz_cust_accounts hca
              where
                h.order_number=rct.ct_reference
                and rct.cust_trx_type_id = rctta.cust_trx_type_id
                and rctta.name = 'Inv. Penj. Lokal'
                and h.order_type_id = ottt.transaction_type_id
                and rct.customer_trx_id = rctl.customer_trx_id
                and rctl.customer_trx_line_id = rctd.customer_trx_line_id
                and rctl.extended_amount != 0
                and rctd.code_combination_id = gcc.code_combination_id
                and gcc.segment3 = ffv.flex_value
                and ffvs.flex_value_set_name = 'KHS_Account'
                and ffvs.flex_value_set_id = ffv.flex_value_set_id
                and (rctd.account_class = 'REV' or rctd.account_class = 'TAX')
                and rctl.inventory_item_id = msi.inventory_item_id
                and rctl.warehouse_id = msi.organization_id
                and cat.inventory_item_id = msi.inventory_item_id
                and cat.organization_id = msi.organization_id 
                and cat.category_set_name = 'KHS KELOMPOK PENJUALAN' 
                and cat.category_id = mca.category_id
                and cat.organization_id = mca.organization_id
                and mca.material_account = gcc1.code_combination_id
                and gcc1.segment5 = ffv1.flex_value
                and ffv1.flex_value_set_id = 1013710
                and hp.party_id (+) = hca.party_id
                and hca.cust_account_id (+) = rct.sold_to_customer_id
                and msi.segment1 not like 'JAD%'
                --parameter
                and h.org_id=$org_id
                and upper (trim (replace (ottt.name, ' ', ''))) like case when $order_type = 1 then '%TRAKTOR%SAP%'
                                                                            when $order_type = 2 then '%HDE%SHDE%'
                                                                            when $order_type = 3 then '%VDE%SVDE%'
                                                                            when $order_type = 4 then '%VBELTMITSUBOSHI%' 
                                                                            when $order_type = 5 then '%VBELTBANDO%'
                                                                            when $order_type = 6 then '%BEARINGNACHI%'
                                                                            when $order_type = 7 then '%BEARINGSKF%'
                                                                            when $order_type = 8 then '%RUBBERROLL%'
                                                                        end
                and (ottt.description like decode('$ho','Luar Negeri','%LN','%DN') or ottt.description like decode('$ho','Luar Negeri','%Luar Negeri%','%Dalam Negeri%'))
                and to_number(substr((to_char(rct.trx_date, 'DD-MON-YYYY')), 8, 4)) = $tahun
                --parameter
            order by
                hca.cust_account_id
                ) SUB_DATA
        ORDER BY
            CUST_ACCOUNT_ID)DATA");

        return $query->result_array();
    }



}