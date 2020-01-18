<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_detail extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        
		$this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function getDetailDO($do_number)
    {
        $sql = "select aa.ORDER_NUMBER             no_so
                        ,aa.REQUEST_NUMBER          no_do
                        ,aa.PARTY_NAME              nama_cust
                        ,aa.address1                alamat
                        ,aa.SEGMENT1                kode_barang
                        ,aa.DESCRIPTION             nama_barang
                        ,aa.QUANTITY                req_qty
                        ,aa.qty_atr                 qty_atr
                        ,aa.PRIMARY_UOM_CODE        uom
                        ,REPLACE
                        ((RTRIM
                            (XMLAGG (XMLELEMENT (e, TO_CHAR (aa.lokasi) || '@')).EXTRACT
                                                                            ('//text()').getclobval
                                                                                    (),
                            '@'
                            )
                        ),
                        '@',
                        ','
                        ) lokasi_gudang
                from
                (
                SELECT distinct
                        mtrh.REQUEST_NUMBER 
                        ,ooha.ORDER_NUMBER
                        ,party.PARTY_NAME
                        ,ship_loc.address1
                        ,msib.SEGMENT1
                        ,msib.DESCRIPTION
                        ,mtrl.QUANTITY
                        ,khs_stock_delivery(mtrl.INVENTORY_ITEM_ID,102,'FG-TKS') qty_atr
                        ,msib.PRIMARY_UOM_CODE
                        ,ooo.LOKASI
                    from mtl_txn_request_lines mtrl
                        ,mtl_txn_request_headers mtrh
                        ,mtl_system_items_b msib
                        ,khs_approval_do kad
                        ,wsh_delivery_details wdd
                        ,oe_order_lines_all oola
                        ,oe_order_headers_all ooha
                        ,hz_parties party
                        ,hz_cust_accounts hca
                        -- ship to 
                        ,hz_cust_site_uses_all ship_su
                        ,hz_party_sites ship_ps
                        ,hz_locations ship_loc
                        ,hz_cust_acct_sites_all ship_cas
                        --
                        ,khsinvlokasisimpan ooo
                    where mtrh.HEADER_ID = mtrl.HEADER_ID
                    and kad.NO_DO(+) = mtrh.REQUEST_NUMBER
                    and msib.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
                    and msib.ORGANIZATION_ID = mtrl.ORGANIZATION_ID
                    and mtrh.REQUEST_NUMBER = to_char(wdd.BATCH_ID)
                    and mtrl.inventory_item_id = wdd.inventory_item_id
                    and wdd.SOURCE_HEADER_NUMBER = ooha.ORDER_NUMBER
                    and ooha.HEADER_ID = oola.HEADER_ID
                    and ooha.sold_to_org_id = hca.cust_account_id
                    and hca.party_id = party.party_id
                    AND ooha.ship_to_org_id = ship_su.site_use_id(+)
                    AND ship_su.cust_acct_site_id = ship_cas.cust_acct_site_id(+)
                    AND ship_cas.party_site_id = ship_ps.party_site_id(+)
                    AND ship_loc.location_id(+) = ship_ps.location_id
                    and msib.INVENTORY_ITEM_ID = ooo.INVENTORY_ITEM_ID(+)
                    and wdd.BATCH_ID = $do_number
                    )aa
                group by aa.REQUEST_NUMBER
                ,aa.ORDER_NUMBER
                ,aa.PARTY_NAME
                ,aa.address1
                ,aa.SEGMENT1
                ,aa.DESCRIPTION
                ,aa.QUANTITY
                ,aa.qty_atr
                ,aa.PRIMARY_UOM_CODE";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getDetailBackorder($so_number)
    {
        $sql = "SELECT aa.SOURCE_HEADER_NUMBER      no_so,
                        aa.PARTY_NAME                nama_cust,
                        aa.address1                  alamat,
                        aa.SEGMENT1                  kode_barang,
                        aa.ITEM_DESCRIPTION          nama_barang,
                        aa.REQUESTED_QUANTITY        req_qty,
                        aa.REQUESTED_QUANTITY_UOM    uom,
                        REPLACE
                            ((RTRIM
                                (XMLAGG (XMLELEMENT (e, TO_CHAR (aa.lokasi) || '@')).EXTRACT
                                                                                    ('//text()').getclobval
                                                                                            (),
                                '@'
                                )
                            ),
                            '@',
                            ','
                            ) lokasi_gudang
                from 
                (select distinct wdd.SOURCE_HEADER_NUMBER
                                , party.PARTY_NAME              
                                , ship_loc.address1
                                , msib.SEGMENT1
                                , wdd.ITEM_DESCRIPTION
                                , wdd.REQUESTED_QUANTITY
                                , wdd.REQUESTED_QUANTITY_UOM
                                , ooo.LOKASI
                from wsh_delivery_details        wdd,
                    oe_order_lines_all          oola,
                    oe_order_headers_all        ooha,
                    mtl_system_items_b          msib,
                    khsinvlokasisimpan          ooo,
                    hz_parties                  party,
                    hz_cust_accounts            hca,
                    -- ship to 
                    hz_cust_site_uses_all      ship_su,
                    hz_party_sites             ship_ps,
                    hz_locations               ship_loc,
                    hz_cust_acct_sites_all     ship_cas
                where ooha.ORDER_NUMBER = wdd.SOURCE_HEADER_NUMBER
                and wdd.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
                and msib.INVENTORY_ITEM_ID = ooo.INVENTORY_ITEM_ID(+)
                AND ooha.sold_to_org_id = hca.cust_account_id
                AND hca.party_id = party.party_id
                and ooha.HEADER_ID = oola.HEADER_ID
                --
                AND ooha.ship_to_org_id = ship_su.site_use_id(+)
                AND ship_su.cust_acct_site_id = ship_cas.cust_acct_site_id(+)
                AND ship_cas.party_site_id = ship_ps.party_site_id(+)
                AND ship_loc.location_id(+) = ship_ps.location_id
                and wdd.SOURCE_HEADER_NUMBER = $so_number
                and wdd.RELEASED_STATUS = 'B')aa
                group by aa.SOURCE_HEADER_NUMBER,
                        aa.PARTY_NAME,
                        aa.address1,
                        aa.SEGMENT1,
                        aa.ITEM_DESCRIPTION,
                        aa.REQUESTED_QUANTITY,
                        aa.REQUESTED_QUANTITY_UOM";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getDetailLaunchPickRelease($so_number)
    {
        $sql = "SELECT aa.SOURCE_HEADER_NUMBER          no_so,
                        aa.PARTY_NAME                    nama_cust,
                        aa.address1                      alamat,
                        aa.SEGMENT1                      kode_barang,
                        aa.ITEM_DESCRIPTION              nama_barang,
                        aa.REQUESTED_QUANTITY            req_qty,
                        aa.REQUESTED_QUANTITY_UOM        uom,
                        REPLACE
                            ((RTRIM
                                (XMLAGG (XMLELEMENT (e, TO_CHAR (aa.lokasi) || '@')).EXTRACT
                                                                                    ('//text()').getclobval
                                                                                            (),
                                '@'
                                )
                            ),
                            '@',
                            ','
                            ) lokasi_gudang,
                        aa.DELIVERY_ID
                from
                (
                select distinct wdd.SOURCE_HEADER_NUMBER
                                ,party.PARTY_NAME
                                ,ship_loc.address1
                                ,wda.DELIVERY_ID
                                ,msib.SEGMENT1
                                ,wdd.ITEM_DESCRIPTION
                                ,wdd.REQUESTED_QUANTITY
                                ,wdd.REQUESTED_QUANTITY_UOM
                                ,ooo.LOKASI
                from wsh_delivery_details wdd,
                    wsh_delivery_assignments wda,
                    mtl_system_items_b msib,
                    khsinvlokasisimpan  ooo,
                    hz_parties party,
                    hz_cust_accounts hca,
                    oe_order_headers_all ooha,
                    -- ship to 
                    hz_cust_site_uses_all ship_su,
                    hz_party_sites ship_ps,
                    hz_locations ship_loc,
                    hz_cust_acct_sites_all ship_cas
                where wdd.DELIVERY_DETAIL_ID = wda.DELIVERY_DETAIL_ID
                and msib.INVENTORY_ITEM_ID = wdd.INVENTORY_ITEM_ID
                and msib.INVENTORY_ITEM_ID = ooo.INVENTORY_ITEM_ID(+)
                and ooha.sold_to_org_id = hca.cust_account_id
                and ooha.ORDER_NUMBER = wdd.SOURCE_HEADER_NUMBER
                and hca.party_id = party.party_id
                AND ooha.ship_to_org_id = ship_su.site_use_id(+)
                AND ship_su.cust_acct_site_id = ship_cas.cust_acct_site_id(+)
                AND ship_cas.party_site_id = ship_ps.party_site_id(+)
                AND ship_loc.location_id(+) = ship_ps.location_id
                and wdd.BATCH_ID is null
                and wda.DELIVERY_ID is not null
                and wdd.ORG_ID = 82
                and wdd.SOURCE_HEADER_NUMBER ='$so_number'
                )aa
                group by
                        aa.SOURCE_HEADER_NUMBER,
                        aa.PARTY_NAME,
                        aa.address1,
                        aa.SEGMENT1,
                        aa.ITEM_DESCRIPTION,
                        aa.REQUESTED_QUANTITY,
                        aa.REQUESTED_QUANTITY_UOM,
                        aa.delivery_id";
                
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

}