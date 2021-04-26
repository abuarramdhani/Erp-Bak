<?php

class M_exportreport extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->library('encrypt');
    }

    public function getUser()
    {
        $getUser = $this->load->database('tokoquick', true);
        $sql ="SELECT DISTINCT 
        tqp.meta_value cust_id,
        tu.display_name-- , COUNT(tqp.post_id) jml_order
        FROM (SELECT tps.post_id, tps.meta_value
                FROM tq_postmeta tps
                WHERE tps.meta_key = '_customer_user') 
        tqp,
        tq_posts tp,
        tq_users tu
        WHERE 
        tqp.post_id = tp.id 
        AND tqp.meta_value = tu.id 
        AND tp.post_status = 'wc-completed'
                ORDER BY
                    tu.display_name ASC";
        $query = $getUser->query($sql);

        return $query->result_array();
    }

    public function getItemCat()
    {
        $getUser = $this->load->database('tokoquick', true);
        $sql ="SELECT ttt.parent, ttt.term_id,  tqt.name
        from tq_term_taxonomy ttt, tq_terms tqt
        where  
            ttt.parent != 0 
            and ttt.term_id not in (select ttt1.parent
                                    from tq_term_taxonomy ttt1
                                    where ttt1.taxonomy = 'product_cat')
            and ttt.taxonomy = 'product_cat'
            and tqt.term_id = ttt.term_id
                ORDER BY
                tqt.name ASC";
        $query = $getUser->query($sql);

        return $query->result_array();
    }

    public function exportDateCustCat($newDateFrom, $newDateTo, $CustId, $TermId)
    {
        $tokoquick = $this->load->database('tokoquick', true);
        $sql1 = "SELECT distinct
            tqp.post_id order_id, 
            toi.order_item_id,
            tp.post_date tgl_pesanan, SUBSTRING(tp.post_status,4) post_status,
            tqp.meta_value customer_id,
            cust.display_name, 
            cust.user_email, CASE WHEN cust.jml_order = 1 THEN 'New Customer' WHEN cust.jml_order > 1 THEN 'Repeate Order' ELSE 'No Order' END customer_category,
            cust.user_registered,
            cust.phone_number,
            cust.shipping_addreas_1,
            cust.shipping_addreas_2,
            cust.shipping_city,
            cust.shipping_state,
            cust.shipping_postcode,
            cust.shipping_country,
            produk.sku, 
            produk.item, 
            produk.cat_id,
            produk.cat_name, 
            produk.harsat, 
            produk.qty,
            produk.berat, 
            produk.ekspedisi, 
            produk.biaya_kirim, 
            produk.metode_bayar
        FROM 
            tq_posts tp,
            (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp,
            tq_woocommerce_order_items toi,
            tq_woocommerce_order_itemmeta toim,
        (	
        SELECT DISTINCT tqp.post_id, 
            tp.post_date tgl_pesanan,
        -- tp.post_status,
        SUBSTRING(tp.post_status,4) post_status,
            tqp.meta_value customer_id,
            tu.display_name, 
        tu.user_email, 
        tu.user_registered,
            bp.meta_value phone_number,
            sa1.meta_value shipping_addreas_1,
            sa2.meta_value shipping_addreas_2,
            sc.meta_value shipping_city,
            transaksi.jml_order,
        CASE WHEN ss.meta_value ='AC' THEN 'Aceh' WHEN ss.meta_value ='BA' THEN 'Bali' WHEN ss.meta_value ='BT' THEN 'Banten' WHEN ss.meta_value ='BE' THEN 'Bengkulu' WHEN ss.meta_value ='GO' THEN 'Gorontalo' WHEN ss.meta_value ='JK' THEN 'Jakarta' WHEN ss.meta_value ='JA' THEN 'Jambi' WHEN ss.meta_value ='JW' THEN 'Jawa' WHEN ss.meta_value ='JB' THEN 'Jawa Barat' WHEN ss.meta_value ='JT' THEN 'Jawa Tengah' WHEN ss.meta_value ='JI' THEN 'Jawa Timur' WHEN ss.meta_value ='KA' THEN 'Kalimantan' WHEN ss.meta_value ='KB' THEN 'Kalimantan Barat' WHEN ss.meta_value ='KS' THEN 'Kalimantan Selatan' WHEN ss.meta_value ='KT' THEN 'Kalimantan Tengah' WHEN ss.meta_value ='KI' THEN 'Kalimantan Timur' WHEN ss.meta_value ='KU' THEN 'Kalimantan Utara' WHEN ss.meta_value ='BB' THEN 'Kepulauan Bangka Belitung' WHEN ss.meta_value ='KR' THEN 'Kepulauan Riau' WHEN ss.meta_value ='LA' THEN 'Lampung' WHEN ss.meta_value ='ML' THEN 'Maluku' WHEN ss.meta_value ='MA' THEN 'Maluku' WHEN ss.meta_value ='MU' THEN 'Maluku Utara' WHEN ss.meta_value ='NU' THEN 'Nusa Tenggara' WHEN ss.meta_value ='NB' THEN 'Nusa Tenggara Barat' WHEN ss.meta_value ='NT' THEN 'Nusa Tenggara Timur' WHEN ss.meta_value ='PP' THEN 'Papua' WHEN ss.meta_value ='PA' THEN 'Papua' WHEN ss.meta_value ='PB' THEN 'Papua Barat' WHEN ss.meta_value ='RI' THEN 'Riau' WHEN ss.meta_value ='SL' THEN 'Sulawesi' WHEN ss.meta_value ='SR' THEN 'Sulawesi Barat' WHEN ss.meta_value ='SN' THEN 'Sulawesi Selatan' WHEN ss.meta_value ='ST' THEN 'Sulawesi Tengah' WHEN ss.meta_value ='SG' THEN 'Sulawesi Tenggara' WHEN ss.meta_value ='SA' THEN 'Sulawesi Utara' WHEN ss.meta_value ='SM' THEN 'Sumatera' WHEN ss.meta_value ='SB' THEN 'Sumatera Barat' WHEN ss.meta_value ='SS' THEN 'Sumatera Selatan' WHEN ss.meta_value ='SU' THEN 'Sumatera Utara' WHEN ss.meta_value ='YO' THEN 'Yogyakarta' END shipping_state,
            spc.meta_value shipping_postcode,
            scy.name shipping_country
        FROM 
            (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_billing_phone') bp ON bp.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_address_1') sa1 ON sa1.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_address_2') sa2 ON sa2.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_city') sc ON sc.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_state') ss ON ss.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_postcode') spc ON spc.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value, tpc.name
        FROM tq_postmeta tqp1, tq_pps_countries tpc
        WHERE tqp1.meta_value = tpc.iso_code_2 AND tqp1.meta_key = '_shipping_country') scy ON scy.post_id = tqp.post_id,
        tq_posts tp,
        tq_users tu
        LEFT JOIN (
        SELECT DISTINCT tqp.meta_value cust_id,
                                    tu.display_name, COUNT(tqp.post_id) jml_order
        FROM 
                                    (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp,
                            tq_posts tp,
                            tq_users tu
        WHERE 
                            tqp.post_id = tp.id AND tqp.meta_value = tu.id AND tp.post_status = 'wc-completed'
        GROUP BY tqp.meta_value) transaksi ON transaksi.cust_id = tu.id
        WHERE 
                tqp.post_id = tp.id AND tqp.meta_value = tu.id ) cust,
        (
        SELECT DISTINCT tqwp.order_id, 
            tqwp.order_item_id, 
            tqwmp.sku, 
            tqwp.item, 
            cat.term_id cat_id,
            cat.name cat_name, 
            hgqt.harsat, 
            hgqt.qty,
            tqwmp.berat,
            tqwp.ekspedisi, 
            shiping.biaya_kirim, 
            payment.metode_bayar
        FROM
            (
        SELECT DISTINCT line.order_id, line.order_item_id, line.item, kirim.ekspedisi
        FROM -- tq_woocommerce_order_items tqw,
            (
        SELECT tqw.order_id, tqw.order_item_id, tqw.order_item_name item
        FROM tq_woocommerce_order_items tqw
        WHERE tqw.order_item_type = 'line_item') line, 
            (
        SELECT tqw.order_id, tqw.order_item_id, tqw.order_item_name ekspedisi
        FROM tq_woocommerce_order_items tqw
        WHERE tqw.order_item_type = 'shipping') kirim
        WHERE
            line.order_id = kirim.order_id) tqwp,
            (
        SELECT tqwm.order_item_id, item.meta_value sku, weight.meta_value berat
        FROM tq_woocommerce_order_itemmeta tqwm,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_sku' AND tqp.meta_value IS NOT NULL) item,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_weight' AND tqp.meta_value IS NOT NULL) weight
        WHERE item.post_id = tqwm.meta_value AND weight.post_id = tqwm.meta_value AND tqwm.meta_key = '_product_id') tqwmp,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value biaya_kirim
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_order_shipping' AND tqp.meta_value IS NOT NULL) shiping, 
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value metode_bayar
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_payment_method_title' AND tqp.meta_value IS NOT NULL) payment,
            (
        SELECT product_id.order_item_id, 
            product_id.meta_value item_id, 
            qty.meta_value qty, 
            line_total.meta_value/qty.meta_value harsat
        FROM (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_product_id') product_id,
            (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_qty') qty,
            (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_line_total') line_total
        WHERE product_id.order_item_id = qty.order_item_id AND qty.order_item_id = line_total.order_item_id) hgqt,
            (
        SELECT *
        FROM tq_woocommerce_order_itemmeta
        WHERE meta_key = '_product_id') tqwm,
            tq_term_relationships ttr
        LEFT JOIN (
                SELECT ttt.parent, ttt.term_id, tqt.name
                FROM tq_term_taxonomy ttt, tq_terms tqt
                WHERE 
                    ttt.parent != 0 AND ttt.term_id NOT in (
                SELECT ttt1.parent
                FROM tq_term_taxonomy ttt1
                WHERE ttt1.taxonomy = 'product_cat') AND ttt.taxonomy = 'product_cat' AND tqt.term_id = ttt.term_id) cat ON cat.term_id = ttr.term_taxonomy_id
                WHERE tqwmp.order_item_id = tqwp.order_item_id AND payment.post_id = tqwp.order_id AND shiping.post_id = tqwp.order_id AND hgqt.order_item_id = tqwp.order_item_id 
                AND tqwp.order_item_id = tqwm.order_item_id AND tqwm.meta_value = ttr.object_id AND cat.term_id IS NOT NULL) produk
        WHERE 
        tqp.post_id = tp.id 
        and tqp.post_id = toi.order_id 
        AND toi.order_item_id = toim.order_item_id 
        AND toim.order_item_id = produk.order_item_id
        AND tqp.meta_value = cust.customer_id 
        AND tqp.post_id = cust.post_id
        AND toim.meta_key = '_product_id' 
        AND toim.meta_key = '_product_id'
        AND DATE(tp.post_date) BETWEEN '$newDateFrom' AND '$newDateTo'
        AND tqp.meta_value = '$CustId'
        AND produk.cat_id = '$TermId'
        ORDER BY	tp.post_date
        ";
        $query = $tokoquick->query($sql1);
        return $query->result_array();

        return $sql1;
    }

    public function exportDateCust($newDateFrom, $newDateTo, $CustId)
    {
        $tokoquick = $this->load->database('tokoquick', true);
        $sql1 = "SELECT distinct
            tqp.post_id order_id, 
            toi.order_item_id,
            tp.post_date tgl_pesanan, SUBSTRING(tp.post_status,4) post_status,
            tqp.meta_value customer_id,
            cust.display_name, 
            cust.user_email, CASE WHEN cust.jml_order = 1 THEN 'New Customer' WHEN cust.jml_order > 1 THEN 'Repeate Order' ELSE 'No Order' END customer_category,
            cust.user_registered,
            cust.phone_number,
            cust.shipping_addreas_1,
            cust.shipping_addreas_2,
            cust.shipping_city,
            cust.shipping_state,
            cust.shipping_postcode,
            cust.shipping_country,
            produk.sku, 
            produk.item, 
            produk.cat_id,
            produk.cat_name, 
            produk.harsat, 
            produk.qty,
            produk.berat, 
            produk.ekspedisi, 
            produk.biaya_kirim, 
            produk.metode_bayar
        FROM 
            tq_posts tp,
            (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp,
            tq_woocommerce_order_items toi,
            tq_woocommerce_order_itemmeta toim,
        (	
        SELECT DISTINCT tqp.post_id, 
            tp.post_date tgl_pesanan,
        -- tp.post_status,
        SUBSTRING(tp.post_status,4) post_status,
            tqp.meta_value customer_id,
            tu.display_name, 
        tu.user_email, 
        tu.user_registered,
            bp.meta_value phone_number,
            sa1.meta_value shipping_addreas_1,
            sa2.meta_value shipping_addreas_2,
            sc.meta_value shipping_city,
            transaksi.jml_order,
        CASE WHEN ss.meta_value ='AC' THEN 'Aceh' WHEN ss.meta_value ='BA' THEN 'Bali' WHEN ss.meta_value ='BT' THEN 'Banten' WHEN ss.meta_value ='BE' THEN 'Bengkulu' WHEN ss.meta_value ='GO' THEN 'Gorontalo' WHEN ss.meta_value ='JK' THEN 'Jakarta' WHEN ss.meta_value ='JA' THEN 'Jambi' WHEN ss.meta_value ='JW' THEN 'Jawa' WHEN ss.meta_value ='JB' THEN 'Jawa Barat' WHEN ss.meta_value ='JT' THEN 'Jawa Tengah' WHEN ss.meta_value ='JI' THEN 'Jawa Timur' WHEN ss.meta_value ='KA' THEN 'Kalimantan' WHEN ss.meta_value ='KB' THEN 'Kalimantan Barat' WHEN ss.meta_value ='KS' THEN 'Kalimantan Selatan' WHEN ss.meta_value ='KT' THEN 'Kalimantan Tengah' WHEN ss.meta_value ='KI' THEN 'Kalimantan Timur' WHEN ss.meta_value ='KU' THEN 'Kalimantan Utara' WHEN ss.meta_value ='BB' THEN 'Kepulauan Bangka Belitung' WHEN ss.meta_value ='KR' THEN 'Kepulauan Riau' WHEN ss.meta_value ='LA' THEN 'Lampung' WHEN ss.meta_value ='ML' THEN 'Maluku' WHEN ss.meta_value ='MA' THEN 'Maluku' WHEN ss.meta_value ='MU' THEN 'Maluku Utara' WHEN ss.meta_value ='NU' THEN 'Nusa Tenggara' WHEN ss.meta_value ='NB' THEN 'Nusa Tenggara Barat' WHEN ss.meta_value ='NT' THEN 'Nusa Tenggara Timur' WHEN ss.meta_value ='PP' THEN 'Papua' WHEN ss.meta_value ='PA' THEN 'Papua' WHEN ss.meta_value ='PB' THEN 'Papua Barat' WHEN ss.meta_value ='RI' THEN 'Riau' WHEN ss.meta_value ='SL' THEN 'Sulawesi' WHEN ss.meta_value ='SR' THEN 'Sulawesi Barat' WHEN ss.meta_value ='SN' THEN 'Sulawesi Selatan' WHEN ss.meta_value ='ST' THEN 'Sulawesi Tengah' WHEN ss.meta_value ='SG' THEN 'Sulawesi Tenggara' WHEN ss.meta_value ='SA' THEN 'Sulawesi Utara' WHEN ss.meta_value ='SM' THEN 'Sumatera' WHEN ss.meta_value ='SB' THEN 'Sumatera Barat' WHEN ss.meta_value ='SS' THEN 'Sumatera Selatan' WHEN ss.meta_value ='SU' THEN 'Sumatera Utara' WHEN ss.meta_value ='YO' THEN 'Yogyakarta' END shipping_state,
            spc.meta_value shipping_postcode,
            scy.name shipping_country
        FROM 
            (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_billing_phone') bp ON bp.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_address_1') sa1 ON sa1.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_address_2') sa2 ON sa2.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_city') sc ON sc.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_state') ss ON ss.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_postcode') spc ON spc.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value, tpc.name
        FROM tq_postmeta tqp1, tq_pps_countries tpc
        WHERE tqp1.meta_value = tpc.iso_code_2 AND tqp1.meta_key = '_shipping_country') scy ON scy.post_id = tqp.post_id,
        tq_posts tp,
        tq_users tu
        LEFT JOIN (
        SELECT DISTINCT tqp.meta_value cust_id,
                                    tu.display_name, COUNT(tqp.post_id) jml_order
        FROM 
                                    (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp,
                            tq_posts tp,
                            tq_users tu
        WHERE 
                            tqp.post_id = tp.id AND tqp.meta_value = tu.id AND tp.post_status = 'wc-completed'
        GROUP BY tqp.meta_value) transaksi ON transaksi.cust_id = tu.id
        WHERE 
                tqp.post_id = tp.id AND tqp.meta_value = tu.id ) cust,
        (
        SELECT DISTINCT tqwp.order_id, 
            tqwp.order_item_id, 
            tqwmp.sku, 
            tqwp.item, 
            cat.term_id cat_id,
            cat.name cat_name, 
            hgqt.harsat, 
            hgqt.qty,
            tqwmp.berat,
            tqwp.ekspedisi, 
            shiping.biaya_kirim, 
            payment.metode_bayar
        FROM
            (
        SELECT DISTINCT line.order_id, line.order_item_id, line.item, kirim.ekspedisi
        FROM -- tq_woocommerce_order_items tqw,
            (
        SELECT tqw.order_id, tqw.order_item_id, tqw.order_item_name item
        FROM tq_woocommerce_order_items tqw
        WHERE tqw.order_item_type = 'line_item') line, 
            (
        SELECT tqw.order_id, tqw.order_item_id, tqw.order_item_name ekspedisi
        FROM tq_woocommerce_order_items tqw
        WHERE tqw.order_item_type = 'shipping') kirim
        WHERE
            line.order_id = kirim.order_id) tqwp,
            (
        SELECT tqwm.order_item_id, item.meta_value sku, weight.meta_value berat
        FROM tq_woocommerce_order_itemmeta tqwm,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_sku' AND tqp.meta_value IS NOT NULL) item,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_weight' AND tqp.meta_value IS NOT NULL) weight
        WHERE item.post_id = tqwm.meta_value AND weight.post_id = tqwm.meta_value AND tqwm.meta_key = '_product_id') tqwmp,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value biaya_kirim
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_order_shipping' AND tqp.meta_value IS NOT NULL) shiping, 
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value metode_bayar
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_payment_method_title' AND tqp.meta_value IS NOT NULL) payment,
            (
        SELECT product_id.order_item_id, 
            product_id.meta_value item_id, 
            qty.meta_value qty, 
            line_total.meta_value/qty.meta_value harsat
        FROM (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_product_id') product_id,
            (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_qty') qty,
            (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_line_total') line_total
        WHERE product_id.order_item_id = qty.order_item_id AND qty.order_item_id = line_total.order_item_id) hgqt,
            (
        SELECT *
        FROM tq_woocommerce_order_itemmeta
        WHERE meta_key = '_product_id') tqwm,
            tq_term_relationships ttr
        LEFT JOIN (
                SELECT ttt.parent, ttt.term_id, tqt.name
                FROM tq_term_taxonomy ttt, tq_terms tqt
                WHERE 
                    ttt.parent != 0 AND ttt.term_id NOT in (
                SELECT ttt1.parent
                FROM tq_term_taxonomy ttt1
                WHERE ttt1.taxonomy = 'product_cat') AND ttt.taxonomy = 'product_cat' AND tqt.term_id = ttt.term_id) cat ON cat.term_id = ttr.term_taxonomy_id
                WHERE tqwmp.order_item_id = tqwp.order_item_id AND payment.post_id = tqwp.order_id AND shiping.post_id = tqwp.order_id AND hgqt.order_item_id = tqwp.order_item_id 
                AND tqwp.order_item_id = tqwm.order_item_id AND tqwm.meta_value = ttr.object_id AND cat.term_id IS NOT NULL) produk
        WHERE 
        tqp.post_id = tp.id 
        and tqp.post_id = toi.order_id 
        AND toi.order_item_id = toim.order_item_id 
        AND toim.order_item_id = produk.order_item_id
        AND tqp.meta_value = cust.customer_id 
        AND tqp.post_id = cust.post_id
        AND toim.meta_key = '_product_id'
        AND DATE(tp.post_date) BETWEEN '$newDateFrom' AND '$newDateTo'
        AND tqp.meta_value = '$CustId'
        ORDER BY	tp.post_date
        ";
        $query = $tokoquick->query($sql1);;
        return $query->result_array();

        return $sql1;
    }

    public function exportCust($CustId)
    {
        $tokoquick = $this->load->database('tokoquick', true);
        $sql1 = "SELECT distinct
            tqp.post_id order_id, 
            toi.order_item_id,
            tp.post_date tgl_pesanan, SUBSTRING(tp.post_status,4) post_status,
            tqp.meta_value customer_id,
            cust.display_name, 
            cust.user_email, CASE WHEN cust.jml_order = 1 THEN 'New Customer' WHEN cust.jml_order > 1 THEN 'Repeate Order' ELSE 'No Order' END customer_category,
            cust.user_registered,
            cust.phone_number,
            cust.shipping_addreas_1,
            cust.shipping_addreas_2,
            cust.shipping_city,
            cust.shipping_state,
            cust.shipping_postcode,
            cust.shipping_country,
            produk.sku, 
            produk.item, 
            produk.cat_id,
            produk.cat_name, 
            produk.harsat, 
            produk.qty,
            produk.berat, 
            produk.ekspedisi, 
            produk.biaya_kirim, 
            produk.metode_bayar
        FROM 
            tq_posts tp,
            (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp,
            tq_woocommerce_order_items toi,
            tq_woocommerce_order_itemmeta toim,
        (	
        SELECT DISTINCT tqp.post_id, 
            tp.post_date tgl_pesanan,
        SUBSTRING(tp.post_status,4) post_status,
            tqp.meta_value customer_id,
            tu.display_name, 
        tu.user_email, 
        tu.user_registered,
            bp.meta_value phone_number,
            sa1.meta_value shipping_addreas_1,
            sa2.meta_value shipping_addreas_2,
            sc.meta_value shipping_city,
            transaksi.jml_order,
        CASE WHEN ss.meta_value ='AC' THEN 'Aceh' WHEN ss.meta_value ='BA' THEN 'Bali' WHEN ss.meta_value ='BT' THEN 'Banten' WHEN ss.meta_value ='BE' THEN 'Bengkulu' WHEN ss.meta_value ='GO' THEN 'Gorontalo' WHEN ss.meta_value ='JK' THEN 'Jakarta' WHEN ss.meta_value ='JA' THEN 'Jambi' WHEN ss.meta_value ='JW' THEN 'Jawa' WHEN ss.meta_value ='JB' THEN 'Jawa Barat' WHEN ss.meta_value ='JT' THEN 'Jawa Tengah' WHEN ss.meta_value ='JI' THEN 'Jawa Timur' WHEN ss.meta_value ='KA' THEN 'Kalimantan' WHEN ss.meta_value ='KB' THEN 'Kalimantan Barat' WHEN ss.meta_value ='KS' THEN 'Kalimantan Selatan' WHEN ss.meta_value ='KT' THEN 'Kalimantan Tengah' WHEN ss.meta_value ='KI' THEN 'Kalimantan Timur' WHEN ss.meta_value ='KU' THEN 'Kalimantan Utara' WHEN ss.meta_value ='BB' THEN 'Kepulauan Bangka Belitung' WHEN ss.meta_value ='KR' THEN 'Kepulauan Riau' WHEN ss.meta_value ='LA' THEN 'Lampung' WHEN ss.meta_value ='ML' THEN 'Maluku' WHEN ss.meta_value ='MA' THEN 'Maluku' WHEN ss.meta_value ='MU' THEN 'Maluku Utara' WHEN ss.meta_value ='NU' THEN 'Nusa Tenggara' WHEN ss.meta_value ='NB' THEN 'Nusa Tenggara Barat' WHEN ss.meta_value ='NT' THEN 'Nusa Tenggara Timur' WHEN ss.meta_value ='PP' THEN 'Papua' WHEN ss.meta_value ='PA' THEN 'Papua' WHEN ss.meta_value ='PB' THEN 'Papua Barat' WHEN ss.meta_value ='RI' THEN 'Riau' WHEN ss.meta_value ='SL' THEN 'Sulawesi' WHEN ss.meta_value ='SR' THEN 'Sulawesi Barat' WHEN ss.meta_value ='SN' THEN 'Sulawesi Selatan' WHEN ss.meta_value ='ST' THEN 'Sulawesi Tengah' WHEN ss.meta_value ='SG' THEN 'Sulawesi Tenggara' WHEN ss.meta_value ='SA' THEN 'Sulawesi Utara' WHEN ss.meta_value ='SM' THEN 'Sumatera' WHEN ss.meta_value ='SB' THEN 'Sumatera Barat' WHEN ss.meta_value ='SS' THEN 'Sumatera Selatan' WHEN ss.meta_value ='SU' THEN 'Sumatera Utara' WHEN ss.meta_value ='YO' THEN 'Yogyakarta' END shipping_state,
            spc.meta_value shipping_postcode,
            scy.name shipping_country
        FROM 
            (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_billing_phone') bp ON bp.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_address_1') sa1 ON sa1.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_address_2') sa2 ON sa2.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_city') sc ON sc.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_state') ss ON ss.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_postcode') spc ON spc.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value, tpc.name
        FROM tq_postmeta tqp1, tq_pps_countries tpc
        WHERE tqp1.meta_value = tpc.iso_code_2 AND tqp1.meta_key = '_shipping_country') scy ON scy.post_id = tqp.post_id,
        tq_posts tp,
        tq_users tu
        LEFT JOIN (
        SELECT DISTINCT tqp.meta_value cust_id,
                                    tu.display_name, COUNT(tqp.post_id) jml_order
        FROM 
                                    (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp,
                            tq_posts tp,
                            tq_users tu
        WHERE 
                            tqp.post_id = tp.id AND tqp.meta_value = tu.id AND tp.post_status = 'wc-completed'
        GROUP BY tqp.meta_value) transaksi ON transaksi.cust_id = tu.id
        WHERE 
                tqp.post_id = tp.id AND tqp.meta_value = tu.id ) cust,
        (
        SELECT DISTINCT tqwp.order_id, 
            tqwp.order_item_id, 
            tqwmp.sku, 
            tqwp.item, 
            cat.term_id cat_id,
            cat.name cat_name, 
            hgqt.harsat, 
            hgqt.qty,
            tqwmp.berat,
            tqwp.ekspedisi, 
            shiping.biaya_kirim, 
            payment.metode_bayar
        FROM
            (
        SELECT DISTINCT line.order_id, line.order_item_id, line.item, kirim.ekspedisi
        FROM
            (
        SELECT tqw.order_id, tqw.order_item_id, tqw.order_item_name item
        FROM tq_woocommerce_order_items tqw
        WHERE tqw.order_item_type = 'line_item') line, 
            (
        SELECT tqw.order_id, tqw.order_item_id, tqw.order_item_name ekspedisi
        FROM tq_woocommerce_order_items tqw
        WHERE tqw.order_item_type = 'shipping') kirim
        WHERE
            line.order_id = kirim.order_id) tqwp,
            (
        SELECT tqwm.order_item_id, item.meta_value sku, weight.meta_value berat
        FROM tq_woocommerce_order_itemmeta tqwm,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_sku' AND tqp.meta_value IS NOT NULL) item,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_weight' AND tqp.meta_value IS NOT NULL) weight
        WHERE item.post_id = tqwm.meta_value AND weight.post_id = tqwm.meta_value AND tqwm.meta_key = '_product_id') tqwmp,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value biaya_kirim
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_order_shipping' AND tqp.meta_value IS NOT NULL) shiping, 
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value metode_bayar
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_payment_method_title' AND tqp.meta_value IS NOT NULL) payment,
            (
        SELECT product_id.order_item_id, 
            product_id.meta_value item_id, 
            qty.meta_value qty, 
            line_total.meta_value/qty.meta_value harsat
        FROM (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_product_id') product_id,
            (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_qty') qty,
            (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_line_total') line_total
        WHERE product_id.order_item_id = qty.order_item_id AND qty.order_item_id = line_total.order_item_id) hgqt,
            (
        SELECT *
        FROM tq_woocommerce_order_itemmeta
        WHERE meta_key = '_product_id') tqwm,
            tq_term_relationships ttr
        LEFT JOIN (
                SELECT ttt.parent, ttt.term_id, tqt.name
                FROM tq_term_taxonomy ttt, tq_terms tqt
                WHERE 
                    ttt.parent != 0 AND ttt.term_id NOT in (
                SELECT ttt1.parent
                FROM tq_term_taxonomy ttt1
                WHERE ttt1.taxonomy = 'product_cat') AND ttt.taxonomy = 'product_cat' AND tqt.term_id = ttt.term_id) cat ON cat.term_id = ttr.term_taxonomy_id
                WHERE tqwmp.order_item_id = tqwp.order_item_id AND payment.post_id = tqwp.order_id AND shiping.post_id = tqwp.order_id AND hgqt.order_item_id = tqwp.order_item_id 
                AND tqwp.order_item_id = tqwm.order_item_id AND tqwm.meta_value = ttr.object_id AND cat.term_id IS NOT NULL) produk
        WHERE 
        tqp.post_id = tp.id 
        and tqp.post_id = toi.order_id 
        AND toi.order_item_id = toim.order_item_id 
        AND toim.order_item_id = produk.order_item_id
        AND tqp.meta_value = cust.customer_id 
        AND tqp.post_id = cust.post_id
        AND toim.meta_key = '_product_id'
        AND tqp.meta_value = '$CustId'
        ORDER BY	tp.post_date
        ";
        $query = $tokoquick->query($sql1);
        return $query->result_array();

        return $sql1;
    }

    public function exportCat($CustId, $TermId)
    {
        $tokoquick = $this->load->database('tokoquick', true);
        $sql1 = "SELECT distinct
            tqp.post_id order_id, 
            toi.order_item_id,
            tp.post_date tgl_pesanan, SUBSTRING(tp.post_status,4) post_status,
            tqp.meta_value customer_id,
            cust.display_name, 
            cust.user_email, CASE WHEN cust.jml_order = 1 THEN 'New Customer' WHEN cust.jml_order > 1 THEN 'Repeate Order' ELSE 'No Order' END customer_category,
            cust.user_registered,
            cust.phone_number,
            cust.shipping_addreas_1,
            cust.shipping_addreas_2,
            cust.shipping_city,
            cust.shipping_state,
            cust.shipping_postcode,
            cust.shipping_country,
            produk.sku, 
            produk.item, 
            produk.cat_id,
            produk.cat_name, 
            produk.harsat, 
            produk.qty,
            produk.berat, 
            produk.ekspedisi, 
            produk.biaya_kirim, 
            produk.metode_bayar
        FROM 
            tq_posts tp,
            (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp,
            tq_woocommerce_order_items toi,
            tq_woocommerce_order_itemmeta toim,
        (	
        SELECT DISTINCT tqp.post_id, 
            tp.post_date tgl_pesanan,
        -- tp.post_status,
        SUBSTRING(tp.post_status,4) post_status,
            tqp.meta_value customer_id,
            tu.display_name, 
        tu.user_email, 
        tu.user_registered,
            bp.meta_value phone_number,
            sa1.meta_value shipping_addreas_1,
            sa2.meta_value shipping_addreas_2,
            sc.meta_value shipping_city,
            transaksi.jml_order,
        CASE WHEN ss.meta_value ='AC' THEN 'Aceh' WHEN ss.meta_value ='BA' THEN 'Bali' WHEN ss.meta_value ='BT' THEN 'Banten' WHEN ss.meta_value ='BE' THEN 'Bengkulu' WHEN ss.meta_value ='GO' THEN 'Gorontalo' WHEN ss.meta_value ='JK' THEN 'Jakarta' WHEN ss.meta_value ='JA' THEN 'Jambi' WHEN ss.meta_value ='JW' THEN 'Jawa' WHEN ss.meta_value ='JB' THEN 'Jawa Barat' WHEN ss.meta_value ='JT' THEN 'Jawa Tengah' WHEN ss.meta_value ='JI' THEN 'Jawa Timur' WHEN ss.meta_value ='KA' THEN 'Kalimantan' WHEN ss.meta_value ='KB' THEN 'Kalimantan Barat' WHEN ss.meta_value ='KS' THEN 'Kalimantan Selatan' WHEN ss.meta_value ='KT' THEN 'Kalimantan Tengah' WHEN ss.meta_value ='KI' THEN 'Kalimantan Timur' WHEN ss.meta_value ='KU' THEN 'Kalimantan Utara' WHEN ss.meta_value ='BB' THEN 'Kepulauan Bangka Belitung' WHEN ss.meta_value ='KR' THEN 'Kepulauan Riau' WHEN ss.meta_value ='LA' THEN 'Lampung' WHEN ss.meta_value ='ML' THEN 'Maluku' WHEN ss.meta_value ='MA' THEN 'Maluku' WHEN ss.meta_value ='MU' THEN 'Maluku Utara' WHEN ss.meta_value ='NU' THEN 'Nusa Tenggara' WHEN ss.meta_value ='NB' THEN 'Nusa Tenggara Barat' WHEN ss.meta_value ='NT' THEN 'Nusa Tenggara Timur' WHEN ss.meta_value ='PP' THEN 'Papua' WHEN ss.meta_value ='PA' THEN 'Papua' WHEN ss.meta_value ='PB' THEN 'Papua Barat' WHEN ss.meta_value ='RI' THEN 'Riau' WHEN ss.meta_value ='SL' THEN 'Sulawesi' WHEN ss.meta_value ='SR' THEN 'Sulawesi Barat' WHEN ss.meta_value ='SN' THEN 'Sulawesi Selatan' WHEN ss.meta_value ='ST' THEN 'Sulawesi Tengah' WHEN ss.meta_value ='SG' THEN 'Sulawesi Tenggara' WHEN ss.meta_value ='SA' THEN 'Sulawesi Utara' WHEN ss.meta_value ='SM' THEN 'Sumatera' WHEN ss.meta_value ='SB' THEN 'Sumatera Barat' WHEN ss.meta_value ='SS' THEN 'Sumatera Selatan' WHEN ss.meta_value ='SU' THEN 'Sumatera Utara' WHEN ss.meta_value ='YO' THEN 'Yogyakarta' END shipping_state,
            spc.meta_value shipping_postcode,
            scy.name shipping_country
        FROM 
            (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_billing_phone') bp ON bp.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_address_1') sa1 ON sa1.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_address_2') sa2 ON sa2.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_city') sc ON sc.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_state') ss ON ss.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_postcode') spc ON spc.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value, tpc.name
        FROM tq_postmeta tqp1, tq_pps_countries tpc
        WHERE tqp1.meta_value = tpc.iso_code_2 AND tqp1.meta_key = '_shipping_country') scy ON scy.post_id = tqp.post_id,
        tq_posts tp,
        tq_users tu
        LEFT JOIN (
        SELECT DISTINCT tqp.meta_value cust_id,
                                    tu.display_name, COUNT(tqp.post_id) jml_order
        FROM 
                                    (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp,
                            tq_posts tp,
                            tq_users tu
        WHERE 
                            tqp.post_id = tp.id AND tqp.meta_value = tu.id AND tp.post_status = 'wc-completed'
        GROUP BY tqp.meta_value) transaksi ON transaksi.cust_id = tu.id
        WHERE 
                tqp.post_id = tp.id AND tqp.meta_value = tu.id ) cust,
        (
        SELECT DISTINCT tqwp.order_id, 
            tqwp.order_item_id, 
            tqwmp.sku, 
            tqwp.item, 
            cat.term_id cat_id,
            cat.name cat_name, 
            hgqt.harsat, 
            hgqt.qty,
            tqwmp.berat,
            tqwp.ekspedisi, 
            shiping.biaya_kirim, 
            payment.metode_bayar
        FROM
            (
        SELECT DISTINCT line.order_id, line.order_item_id, line.item, kirim.ekspedisi
        FROM -- tq_woocommerce_order_items tqw,
            (
        SELECT tqw.order_id, tqw.order_item_id, tqw.order_item_name item
        FROM tq_woocommerce_order_items tqw
        WHERE tqw.order_item_type = 'line_item') line, 
            (
        SELECT tqw.order_id, tqw.order_item_id, tqw.order_item_name ekspedisi
        FROM tq_woocommerce_order_items tqw
        WHERE tqw.order_item_type = 'shipping') kirim
        WHERE
            line.order_id = kirim.order_id) tqwp,
            (
        SELECT tqwm.order_item_id, item.meta_value sku, weight.meta_value berat
        FROM tq_woocommerce_order_itemmeta tqwm,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_sku' AND tqp.meta_value IS NOT NULL) item,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_weight' AND tqp.meta_value IS NOT NULL) weight
        WHERE item.post_id = tqwm.meta_value AND weight.post_id = tqwm.meta_value AND tqwm.meta_key = '_product_id') tqwmp,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value biaya_kirim
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_order_shipping' AND tqp.meta_value IS NOT NULL) shiping, 
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value metode_bayar
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_payment_method_title' AND tqp.meta_value IS NOT NULL) payment,
            (
        SELECT product_id.order_item_id, 
            product_id.meta_value item_id, 
            qty.meta_value qty, 
            line_total.meta_value/qty.meta_value harsat
        FROM (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_product_id') product_id,
            (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_qty') qty,
            (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_line_total') line_total
        WHERE product_id.order_item_id = qty.order_item_id AND qty.order_item_id = line_total.order_item_id) hgqt,
            (
        SELECT *
        FROM tq_woocommerce_order_itemmeta
        WHERE meta_key = '_product_id') tqwm,
            tq_term_relationships ttr
        LEFT JOIN (
                SELECT ttt.parent, ttt.term_id, tqt.name
                FROM tq_term_taxonomy ttt, tq_terms tqt
                WHERE 
                    ttt.parent != 0 AND ttt.term_id NOT in (
                SELECT ttt1.parent
                FROM tq_term_taxonomy ttt1
                WHERE ttt1.taxonomy = 'product_cat') AND ttt.taxonomy = 'product_cat' AND tqt.term_id = ttt.term_id) cat ON cat.term_id = ttr.term_taxonomy_id
                WHERE tqwmp.order_item_id = tqwp.order_item_id AND payment.post_id = tqwp.order_id AND shiping.post_id = tqwp.order_id AND hgqt.order_item_id = tqwp.order_item_id 
                AND tqwp.order_item_id = tqwm.order_item_id AND tqwm.meta_value = ttr.object_id AND cat.term_id IS NOT NULL) produk
        WHERE 
        tqp.post_id = tp.id 
        and tqp.post_id = toi.order_id 
        AND toi.order_item_id = toim.order_item_id 
        AND toim.order_item_id = produk.order_item_id
        AND tqp.meta_value = cust.customer_id 
        AND tqp.post_id = cust.post_id
        AND toim.meta_key = '_product_id'
        AND tqp.meta_value = '$CustId'
        AND produk.cat_id = '$TermId'
        ORDER BY	tp.post_date 
        ";
        $query = $tokoquick->query($sql1);
        return $query->result_array();

        return $sql1;
    }

    public function exportDateCat($newDateFrom, $newDateTo, $TermId)
    {
        $tokoquick = $this->load->database('tokoquick', true);
        $sql1 = "SELECT distinct
            tqp.post_id order_id, 
            toi.order_item_id,
            tp.post_date tgl_pesanan, SUBSTRING(tp.post_status,4) post_status,
            tqp.meta_value customer_id,
            cust.display_name, 
            cust.user_email, CASE WHEN cust.jml_order = 1 THEN 'New Customer' WHEN cust.jml_order > 1 THEN 'Repeate Order' ELSE 'No Order' END customer_category,
            cust.user_registered,
            cust.phone_number,
            cust.shipping_addreas_1,
            cust.shipping_addreas_2,
            cust.shipping_city,
            cust.shipping_state,
            cust.shipping_postcode,
            cust.shipping_country,
            produk.sku, 
            produk.item, 
            produk.cat_id,
            produk.cat_name, 
            produk.harsat, 
            produk.qty,
            produk.berat, 
            produk.ekspedisi, 
            produk.biaya_kirim, 
            produk.metode_bayar
        FROM 
            tq_posts tp,
            (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp,
            tq_woocommerce_order_items toi,
            tq_woocommerce_order_itemmeta toim,
        (	
        SELECT DISTINCT tqp.post_id, 
            tp.post_date tgl_pesanan,
        SUBSTRING(tp.post_status,4) post_status,
            tqp.meta_value customer_id,
            tu.display_name, 
        tu.user_email, 
        tu.user_registered,
            bp.meta_value phone_number,
            sa1.meta_value shipping_addreas_1,
            sa2.meta_value shipping_addreas_2,
            sc.meta_value shipping_city,
            transaksi.jml_order,
        CASE WHEN ss.meta_value ='AC' THEN 'Aceh' WHEN ss.meta_value ='BA' THEN 'Bali' WHEN ss.meta_value ='BT' THEN 'Banten' WHEN ss.meta_value ='BE' THEN 'Bengkulu' WHEN ss.meta_value ='GO' THEN 'Gorontalo' WHEN ss.meta_value ='JK' THEN 'Jakarta' WHEN ss.meta_value ='JA' THEN 'Jambi' WHEN ss.meta_value ='JW' THEN 'Jawa' WHEN ss.meta_value ='JB' THEN 'Jawa Barat' WHEN ss.meta_value ='JT' THEN 'Jawa Tengah' WHEN ss.meta_value ='JI' THEN 'Jawa Timur' WHEN ss.meta_value ='KA' THEN 'Kalimantan' WHEN ss.meta_value ='KB' THEN 'Kalimantan Barat' WHEN ss.meta_value ='KS' THEN 'Kalimantan Selatan' WHEN ss.meta_value ='KT' THEN 'Kalimantan Tengah' WHEN ss.meta_value ='KI' THEN 'Kalimantan Timur' WHEN ss.meta_value ='KU' THEN 'Kalimantan Utara' WHEN ss.meta_value ='BB' THEN 'Kepulauan Bangka Belitung' WHEN ss.meta_value ='KR' THEN 'Kepulauan Riau' WHEN ss.meta_value ='LA' THEN 'Lampung' WHEN ss.meta_value ='ML' THEN 'Maluku' WHEN ss.meta_value ='MA' THEN 'Maluku' WHEN ss.meta_value ='MU' THEN 'Maluku Utara' WHEN ss.meta_value ='NU' THEN 'Nusa Tenggara' WHEN ss.meta_value ='NB' THEN 'Nusa Tenggara Barat' WHEN ss.meta_value ='NT' THEN 'Nusa Tenggara Timur' WHEN ss.meta_value ='PP' THEN 'Papua' WHEN ss.meta_value ='PA' THEN 'Papua' WHEN ss.meta_value ='PB' THEN 'Papua Barat' WHEN ss.meta_value ='RI' THEN 'Riau' WHEN ss.meta_value ='SL' THEN 'Sulawesi' WHEN ss.meta_value ='SR' THEN 'Sulawesi Barat' WHEN ss.meta_value ='SN' THEN 'Sulawesi Selatan' WHEN ss.meta_value ='ST' THEN 'Sulawesi Tengah' WHEN ss.meta_value ='SG' THEN 'Sulawesi Tenggara' WHEN ss.meta_value ='SA' THEN 'Sulawesi Utara' WHEN ss.meta_value ='SM' THEN 'Sumatera' WHEN ss.meta_value ='SB' THEN 'Sumatera Barat' WHEN ss.meta_value ='SS' THEN 'Sumatera Selatan' WHEN ss.meta_value ='SU' THEN 'Sumatera Utara' WHEN ss.meta_value ='YO' THEN 'Yogyakarta' END shipping_state,
            spc.meta_value shipping_postcode,
            scy.name shipping_country
        FROM 
            (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_billing_phone') bp ON bp.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_address_1') sa1 ON sa1.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_address_2') sa2 ON sa2.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_city') sc ON sc.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_state') ss ON ss.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_postcode') spc ON spc.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value, tpc.name
        FROM tq_postmeta tqp1, tq_pps_countries tpc
        WHERE tqp1.meta_value = tpc.iso_code_2 AND tqp1.meta_key = '_shipping_country') scy ON scy.post_id = tqp.post_id,
        tq_posts tp,
        tq_users tu
        LEFT JOIN (
        SELECT DISTINCT tqp.meta_value cust_id,
                                    tu.display_name, COUNT(tqp.post_id) jml_order
        FROM 
                                    (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp,
                            tq_posts tp,
                            tq_users tu
        WHERE 
                            tqp.post_id = tp.id AND tqp.meta_value = tu.id AND tp.post_status = 'wc-completed'
        GROUP BY tqp.meta_value) transaksi ON transaksi.cust_id = tu.id
        WHERE 
                tqp.post_id = tp.id AND tqp.meta_value = tu.id ) cust,
        (
        SELECT DISTINCT tqwp.order_id, 
            tqwp.order_item_id, 
            tqwmp.sku, 
            tqwp.item, 
            cat.term_id cat_id,
            cat.name cat_name, 
            hgqt.harsat, 
            hgqt.qty,
            tqwmp.berat,
            tqwp.ekspedisi, 
            shiping.biaya_kirim, 
            payment.metode_bayar
        FROM
            (
        SELECT DISTINCT line.order_id, line.order_item_id, line.item, kirim.ekspedisi
        FROM
            (
        SELECT tqw.order_id, tqw.order_item_id, tqw.order_item_name item
        FROM tq_woocommerce_order_items tqw
        WHERE tqw.order_item_type = 'line_item') line, 
            (
        SELECT tqw.order_id, tqw.order_item_id, tqw.order_item_name ekspedisi
        FROM tq_woocommerce_order_items tqw
        WHERE tqw.order_item_type = 'shipping') kirim
        WHERE
            line.order_id = kirim.order_id) tqwp,
            (
        SELECT tqwm.order_item_id, item.meta_value sku, weight.meta_value berat
        FROM tq_woocommerce_order_itemmeta tqwm,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_sku' AND tqp.meta_value IS NOT NULL) item,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_weight' AND tqp.meta_value IS NOT NULL) weight
        WHERE item.post_id = tqwm.meta_value AND weight.post_id = tqwm.meta_value AND tqwm.meta_key = '_product_id') tqwmp,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value biaya_kirim
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_order_shipping' AND tqp.meta_value IS NOT NULL) shiping, 
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value metode_bayar
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_payment_method_title' AND tqp.meta_value IS NOT NULL) payment,
            (
        SELECT product_id.order_item_id, 
            product_id.meta_value item_id, 
            qty.meta_value qty, 
            line_total.meta_value/qty.meta_value harsat
        FROM (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_product_id') product_id,
            (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_qty') qty,
            (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_line_total') line_total
        WHERE product_id.order_item_id = qty.order_item_id AND qty.order_item_id = line_total.order_item_id) hgqt,
            (
        SELECT *
        FROM tq_woocommerce_order_itemmeta
        WHERE meta_key = '_product_id') tqwm,
            tq_term_relationships ttr
        LEFT JOIN (
                SELECT ttt.parent, ttt.term_id, tqt.name
                FROM tq_term_taxonomy ttt, tq_terms tqt
                WHERE 
                    ttt.parent != 0 AND ttt.term_id NOT in (
                SELECT ttt1.parent
                FROM tq_term_taxonomy ttt1
                WHERE ttt1.taxonomy = 'product_cat') AND ttt.taxonomy = 'product_cat' AND tqt.term_id = ttt.term_id) cat ON cat.term_id = ttr.term_taxonomy_id
                WHERE tqwmp.order_item_id = tqwp.order_item_id AND payment.post_id = tqwp.order_id AND shiping.post_id = tqwp.order_id AND hgqt.order_item_id = tqwp.order_item_id 
                AND tqwp.order_item_id = tqwm.order_item_id AND tqwm.meta_value = ttr.object_id AND cat.term_id IS NOT NULL) produk
        WHERE 
        tqp.post_id = tp.id 
        and tqp.post_id = toi.order_id 
        AND toi.order_item_id = toim.order_item_id 
        AND toim.order_item_id = produk.order_item_id
        AND tqp.meta_value = cust.customer_id 
        AND tqp.post_id = cust.post_id
        AND toim.meta_key = '_product_id'
        AND DATE(tp.post_date) BETWEEN '$newDateFrom' AND '$newDateTo' 
        AND produk.cat_id = '$TermId'
        ORDER BY	tp.post_date
        ";
        $query = $tokoquick->query($sql1);;
        return $query->result_array();

        return $sql1;
    }

    public function exportCatNam($TermId)
    {
        $tokoquick = $this->load->database('tokoquick', true);
        $sql1 = "SELECT distinct
            tqp.post_id order_id, 
            toi.order_item_id,
            tp.post_date tgl_pesanan, SUBSTRING(tp.post_status,4) post_status,
            tqp.meta_value customer_id,
            cust.display_name, 
            cust.user_email, CASE WHEN cust.jml_order = 1 THEN 'New Customer' WHEN cust.jml_order > 1 THEN 'Repeate Order' ELSE 'No Order' END customer_category,
            cust.user_registered,
            cust.phone_number,
            cust.shipping_addreas_1,
            cust.shipping_addreas_2,
            cust.shipping_city,
            cust.shipping_state,
            cust.shipping_postcode,
            cust.shipping_country,
            produk.sku, 
            produk.item, 
            produk.cat_id,
            produk.cat_name, 
            produk.harsat, 
            produk.qty,
            produk.berat, 
            produk.ekspedisi, 
            produk.biaya_kirim, 
            produk.metode_bayar
        FROM 
            tq_posts tp,
            (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp,
            tq_woocommerce_order_items toi,
            tq_woocommerce_order_itemmeta toim,
        (	
        SELECT DISTINCT tqp.post_id, 
            tp.post_date tgl_pesanan,
        -- tp.post_status,
        SUBSTRING(tp.post_status,4) post_status,
            tqp.meta_value customer_id,
            tu.display_name, 
        tu.user_email, 
        tu.user_registered,
            bp.meta_value phone_number,
            sa1.meta_value shipping_addreas_1,
            sa2.meta_value shipping_addreas_2,
            sc.meta_value shipping_city,
            transaksi.jml_order,
        CASE WHEN ss.meta_value ='AC' THEN 'Aceh' WHEN ss.meta_value ='BA' THEN 'Bali' WHEN ss.meta_value ='BT' THEN 'Banten' WHEN ss.meta_value ='BE' THEN 'Bengkulu' WHEN ss.meta_value ='GO' THEN 'Gorontalo' WHEN ss.meta_value ='JK' THEN 'Jakarta' WHEN ss.meta_value ='JA' THEN 'Jambi' WHEN ss.meta_value ='JW' THEN 'Jawa' WHEN ss.meta_value ='JB' THEN 'Jawa Barat' WHEN ss.meta_value ='JT' THEN 'Jawa Tengah' WHEN ss.meta_value ='JI' THEN 'Jawa Timur' WHEN ss.meta_value ='KA' THEN 'Kalimantan' WHEN ss.meta_value ='KB' THEN 'Kalimantan Barat' WHEN ss.meta_value ='KS' THEN 'Kalimantan Selatan' WHEN ss.meta_value ='KT' THEN 'Kalimantan Tengah' WHEN ss.meta_value ='KI' THEN 'Kalimantan Timur' WHEN ss.meta_value ='KU' THEN 'Kalimantan Utara' WHEN ss.meta_value ='BB' THEN 'Kepulauan Bangka Belitung' WHEN ss.meta_value ='KR' THEN 'Kepulauan Riau' WHEN ss.meta_value ='LA' THEN 'Lampung' WHEN ss.meta_value ='ML' THEN 'Maluku' WHEN ss.meta_value ='MA' THEN 'Maluku' WHEN ss.meta_value ='MU' THEN 'Maluku Utara' WHEN ss.meta_value ='NU' THEN 'Nusa Tenggara' WHEN ss.meta_value ='NB' THEN 'Nusa Tenggara Barat' WHEN ss.meta_value ='NT' THEN 'Nusa Tenggara Timur' WHEN ss.meta_value ='PP' THEN 'Papua' WHEN ss.meta_value ='PA' THEN 'Papua' WHEN ss.meta_value ='PB' THEN 'Papua Barat' WHEN ss.meta_value ='RI' THEN 'Riau' WHEN ss.meta_value ='SL' THEN 'Sulawesi' WHEN ss.meta_value ='SR' THEN 'Sulawesi Barat' WHEN ss.meta_value ='SN' THEN 'Sulawesi Selatan' WHEN ss.meta_value ='ST' THEN 'Sulawesi Tengah' WHEN ss.meta_value ='SG' THEN 'Sulawesi Tenggara' WHEN ss.meta_value ='SA' THEN 'Sulawesi Utara' WHEN ss.meta_value ='SM' THEN 'Sumatera' WHEN ss.meta_value ='SB' THEN 'Sumatera Barat' WHEN ss.meta_value ='SS' THEN 'Sumatera Selatan' WHEN ss.meta_value ='SU' THEN 'Sumatera Utara' WHEN ss.meta_value ='YO' THEN 'Yogyakarta' END shipping_state,
            spc.meta_value shipping_postcode,
            scy.name shipping_country
        FROM 
            (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_billing_phone') bp ON bp.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_address_1') sa1 ON sa1.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_address_2') sa2 ON sa2.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_city') sc ON sc.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_state') ss ON ss.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_postcode') spc ON spc.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value, tpc.name
        FROM tq_postmeta tqp1, tq_pps_countries tpc
        WHERE tqp1.meta_value = tpc.iso_code_2 AND tqp1.meta_key = '_shipping_country') scy ON scy.post_id = tqp.post_id,
        tq_posts tp,
        tq_users tu
        LEFT JOIN (
        SELECT DISTINCT tqp.meta_value cust_id,
                                    tu.display_name, COUNT(tqp.post_id) jml_order
        FROM 
                                    (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp,
                            tq_posts tp,
                            tq_users tu
        WHERE 
                            tqp.post_id = tp.id AND tqp.meta_value = tu.id AND tp.post_status = 'wc-completed'
        GROUP BY tqp.meta_value) transaksi ON transaksi.cust_id = tu.id
        WHERE 
                tqp.post_id = tp.id AND tqp.meta_value = tu.id ) cust,
        (
        SELECT DISTINCT tqwp.order_id, 
            tqwp.order_item_id, 
            tqwmp.sku, 
            tqwp.item, 
            cat.term_id cat_id,
            cat.name cat_name, 
            hgqt.harsat, 
            hgqt.qty,
            tqwmp.berat,
            tqwp.ekspedisi, 
            shiping.biaya_kirim, 
            payment.metode_bayar
        FROM
            (
        SELECT DISTINCT line.order_id, line.order_item_id, line.item, kirim.ekspedisi
        FROM -- tq_woocommerce_order_items tqw,
            (
        SELECT tqw.order_id, tqw.order_item_id, tqw.order_item_name item
        FROM tq_woocommerce_order_items tqw
        WHERE tqw.order_item_type = 'line_item') line, 
            (
        SELECT tqw.order_id, tqw.order_item_id, tqw.order_item_name ekspedisi
        FROM tq_woocommerce_order_items tqw
        WHERE tqw.order_item_type = 'shipping') kirim
        WHERE
            line.order_id = kirim.order_id) tqwp,
            (
        SELECT tqwm.order_item_id, item.meta_value sku, weight.meta_value berat
        FROM tq_woocommerce_order_itemmeta tqwm,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_sku' AND tqp.meta_value IS NOT NULL) item,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_weight' AND tqp.meta_value IS NOT NULL) weight
        WHERE item.post_id = tqwm.meta_value AND weight.post_id = tqwm.meta_value AND tqwm.meta_key = '_product_id') tqwmp,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value biaya_kirim
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_order_shipping' AND tqp.meta_value IS NOT NULL) shiping, 
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value metode_bayar
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_payment_method_title' AND tqp.meta_value IS NOT NULL) payment,
            (
        SELECT product_id.order_item_id, 
            product_id.meta_value item_id, 
            qty.meta_value qty, 
            line_total.meta_value/qty.meta_value harsat
        FROM (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_product_id') product_id,
            (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_qty') qty,
            (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_line_total') line_total
        WHERE product_id.order_item_id = qty.order_item_id AND qty.order_item_id = line_total.order_item_id) hgqt,
            (
        SELECT *
        FROM tq_woocommerce_order_itemmeta
        WHERE meta_key = '_product_id') tqwm,
            tq_term_relationships ttr
        LEFT JOIN (
                SELECT ttt.parent, ttt.term_id, tqt.name
                FROM tq_term_taxonomy ttt, tq_terms tqt
                WHERE 
                    ttt.parent != 0 AND ttt.term_id NOT in (
                SELECT ttt1.parent
                FROM tq_term_taxonomy ttt1
                WHERE ttt1.taxonomy = 'product_cat') AND ttt.taxonomy = 'product_cat' AND tqt.term_id = ttt.term_id) cat ON cat.term_id = ttr.term_taxonomy_id
                WHERE tqwmp.order_item_id = tqwp.order_item_id AND payment.post_id = tqwp.order_id AND shiping.post_id = tqwp.order_id AND hgqt.order_item_id = tqwp.order_item_id 
                AND tqwp.order_item_id = tqwm.order_item_id AND tqwm.meta_value = ttr.object_id AND cat.term_id IS NOT NULL) produk
        WHERE 
        tqp.post_id = tp.id 
        and tqp.post_id = toi.order_id 
        AND toi.order_item_id = toim.order_item_id 
        AND toim.order_item_id = produk.order_item_id
        AND tqp.meta_value = cust.customer_id 
        AND tqp.post_id = cust.post_id
        AND toim.meta_key = '_product_id'
        AND produk.cat_id = '$TermId'
        ORDER BY	tp.post_date
        ";
        $query = $tokoquick->query($sql1);
        return $query->result_array();

        return $sql1;
    }

    public function exportAllDate($newDateFrom, $newDateTo)
    {
        $tokoquick = $this->load->database('tokoquick', true);
        $sql1 = "SELECT distinct
            tqp.post_id order_id, 
            toi.order_item_id,
            tp.post_date tgl_pesanan, SUBSTRING(tp.post_status,4) post_status,
            tqp.meta_value customer_id,
            cust.display_name, 
            cust.user_email, CASE WHEN cust.jml_order = 1 THEN 'New Customer' WHEN cust.jml_order > 1 THEN 'Repeate Order' ELSE 'No Order' END customer_category,
            cust.user_registered,
            cust.phone_number,
            cust.shipping_addreas_1,
            cust.shipping_addreas_2,
            cust.shipping_city,
            cust.shipping_state,
            cust.shipping_postcode,
            cust.shipping_country,
            produk.sku, 
            produk.item, 
            produk.cat_id,
            produk.cat_name, 
            produk.harsat, 
            produk.qty,
            produk.berat, 
            produk.ekspedisi, 
            produk.biaya_kirim, 
            produk.metode_bayar
        FROM 
            tq_posts tp,
            (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp,
            tq_woocommerce_order_items toi,
            tq_woocommerce_order_itemmeta toim,
        (	
        SELECT DISTINCT tqp.post_id, 
            tp.post_date tgl_pesanan,
        -- tp.post_status,
        SUBSTRING(tp.post_status,4) post_status,
            tqp.meta_value customer_id,
            tu.display_name, 
        tu.user_email, 
        tu.user_registered,
            bp.meta_value phone_number,
            sa1.meta_value shipping_addreas_1,
            sa2.meta_value shipping_addreas_2,
            sc.meta_value shipping_city,
            transaksi.jml_order,
        CASE WHEN ss.meta_value ='AC' THEN 'Aceh' WHEN ss.meta_value ='BA' THEN 'Bali' WHEN ss.meta_value ='BT' THEN 'Banten' WHEN ss.meta_value ='BE' THEN 'Bengkulu' WHEN ss.meta_value ='GO' THEN 'Gorontalo' WHEN ss.meta_value ='JK' THEN 'Jakarta' WHEN ss.meta_value ='JA' THEN 'Jambi' WHEN ss.meta_value ='JW' THEN 'Jawa' WHEN ss.meta_value ='JB' THEN 'Jawa Barat' WHEN ss.meta_value ='JT' THEN 'Jawa Tengah' WHEN ss.meta_value ='JI' THEN 'Jawa Timur' WHEN ss.meta_value ='KA' THEN 'Kalimantan' WHEN ss.meta_value ='KB' THEN 'Kalimantan Barat' WHEN ss.meta_value ='KS' THEN 'Kalimantan Selatan' WHEN ss.meta_value ='KT' THEN 'Kalimantan Tengah' WHEN ss.meta_value ='KI' THEN 'Kalimantan Timur' WHEN ss.meta_value ='KU' THEN 'Kalimantan Utara' WHEN ss.meta_value ='BB' THEN 'Kepulauan Bangka Belitung' WHEN ss.meta_value ='KR' THEN 'Kepulauan Riau' WHEN ss.meta_value ='LA' THEN 'Lampung' WHEN ss.meta_value ='ML' THEN 'Maluku' WHEN ss.meta_value ='MA' THEN 'Maluku' WHEN ss.meta_value ='MU' THEN 'Maluku Utara' WHEN ss.meta_value ='NU' THEN 'Nusa Tenggara' WHEN ss.meta_value ='NB' THEN 'Nusa Tenggara Barat' WHEN ss.meta_value ='NT' THEN 'Nusa Tenggara Timur' WHEN ss.meta_value ='PP' THEN 'Papua' WHEN ss.meta_value ='PA' THEN 'Papua' WHEN ss.meta_value ='PB' THEN 'Papua Barat' WHEN ss.meta_value ='RI' THEN 'Riau' WHEN ss.meta_value ='SL' THEN 'Sulawesi' WHEN ss.meta_value ='SR' THEN 'Sulawesi Barat' WHEN ss.meta_value ='SN' THEN 'Sulawesi Selatan' WHEN ss.meta_value ='ST' THEN 'Sulawesi Tengah' WHEN ss.meta_value ='SG' THEN 'Sulawesi Tenggara' WHEN ss.meta_value ='SA' THEN 'Sulawesi Utara' WHEN ss.meta_value ='SM' THEN 'Sumatera' WHEN ss.meta_value ='SB' THEN 'Sumatera Barat' WHEN ss.meta_value ='SS' THEN 'Sumatera Selatan' WHEN ss.meta_value ='SU' THEN 'Sumatera Utara' WHEN ss.meta_value ='YO' THEN 'Yogyakarta' END shipping_state,
            spc.meta_value shipping_postcode,
            scy.name shipping_country
        FROM 
            (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_billing_phone') bp ON bp.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_address_1') sa1 ON sa1.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_address_2') sa2 ON sa2.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_city') sc ON sc.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_state') ss ON ss.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_postcode') spc ON spc.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value, tpc.name
        FROM tq_postmeta tqp1, tq_pps_countries tpc
        WHERE tqp1.meta_value = tpc.iso_code_2 AND tqp1.meta_key = '_shipping_country') scy ON scy.post_id = tqp.post_id,
        tq_posts tp,
        tq_users tu
        LEFT JOIN (
        SELECT DISTINCT tqp.meta_value cust_id,
                                    tu.display_name, COUNT(tqp.post_id) jml_order
        FROM 
                                    (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp,
                            tq_posts tp,
                            tq_users tu
        WHERE 
                            tqp.post_id = tp.id AND tqp.meta_value = tu.id AND tp.post_status = 'wc-completed'
        GROUP BY tqp.meta_value) transaksi ON transaksi.cust_id = tu.id
        WHERE 
                tqp.post_id = tp.id AND tqp.meta_value = tu.id ) cust,
        (
        SELECT DISTINCT tqwp.order_id, 
            tqwp.order_item_id, 
            tqwmp.sku, 
            tqwp.item, 
            cat.term_id cat_id,
            cat.name cat_name, 
            hgqt.harsat, 
            hgqt.qty,
            tqwmp.berat,
            tqwp.ekspedisi, 
            shiping.biaya_kirim, 
            payment.metode_bayar
        FROM
            (
        SELECT DISTINCT line.order_id, line.order_item_id, line.item, kirim.ekspedisi
        FROM -- tq_woocommerce_order_items tqw,
            (
        SELECT tqw.order_id, tqw.order_item_id, tqw.order_item_name item
        FROM tq_woocommerce_order_items tqw
        WHERE tqw.order_item_type = 'line_item') line, 
            (
        SELECT tqw.order_id, tqw.order_item_id, tqw.order_item_name ekspedisi
        FROM tq_woocommerce_order_items tqw
        WHERE tqw.order_item_type = 'shipping') kirim
        WHERE
            line.order_id = kirim.order_id) tqwp,
            (
        SELECT tqwm.order_item_id, item.meta_value sku, weight.meta_value berat
        FROM tq_woocommerce_order_itemmeta tqwm,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_sku' AND tqp.meta_value IS NOT NULL) item,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_weight' AND tqp.meta_value IS NOT NULL) weight
        WHERE item.post_id = tqwm.meta_value AND weight.post_id = tqwm.meta_value AND tqwm.meta_key = '_product_id') tqwmp,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value biaya_kirim
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_order_shipping' AND tqp.meta_value IS NOT NULL) shiping, 
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value metode_bayar
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_payment_method_title' AND tqp.meta_value IS NOT NULL) payment,
            (
        SELECT product_id.order_item_id, 
            product_id.meta_value item_id, 
            qty.meta_value qty, 
            line_total.meta_value/qty.meta_value harsat
        FROM (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_product_id') product_id,
            (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_qty') qty,
            (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_line_total') line_total
        WHERE product_id.order_item_id = qty.order_item_id AND qty.order_item_id = line_total.order_item_id) hgqt,
            (
        SELECT *
        FROM tq_woocommerce_order_itemmeta
        WHERE meta_key = '_product_id') tqwm,
            tq_term_relationships ttr
        LEFT JOIN (
                SELECT ttt.parent, ttt.term_id, tqt.name
                FROM tq_term_taxonomy ttt, tq_terms tqt
                WHERE 
                    ttt.parent != 0 AND ttt.term_id NOT in (
                SELECT ttt1.parent
                FROM tq_term_taxonomy ttt1
                WHERE ttt1.taxonomy = 'product_cat') AND ttt.taxonomy = 'product_cat' AND tqt.term_id = ttt.term_id) cat ON cat.term_id = ttr.term_taxonomy_id
                WHERE tqwmp.order_item_id = tqwp.order_item_id AND payment.post_id = tqwp.order_id AND shiping.post_id = tqwp.order_id AND hgqt.order_item_id = tqwp.order_item_id 
                AND tqwp.order_item_id = tqwm.order_item_id AND tqwm.meta_value = ttr.object_id AND cat.term_id IS NOT NULL) produk
        WHERE 
        tqp.post_id = tp.id 
        and tqp.post_id = toi.order_id 
        AND toi.order_item_id = toim.order_item_id 
        AND toim.order_item_id = produk.order_item_id
        AND tqp.meta_value = cust.customer_id 
        AND tqp.post_id = cust.post_id
        AND toim.meta_key = '_product_id' 
        AND DATE(tp.post_date) BETWEEN '$newDateFrom' AND '$newDateTo'
        ";
        $query = $tokoquick->query($sql1);
        return $query->result_array();

        return $sql1;
    }

    public function exportAll()
    {
        $tokoquick = $this->load->database('tokoquick', true);
        $sql1 = "SELECT distinct
            tqp.post_id order_id, 
            toi.order_item_id,
            tp.post_date tgl_pesanan, SUBSTRING(tp.post_status,4) post_status,
            tqp.meta_value customer_id,
            cust.display_name, 
            cust.user_email, CASE WHEN cust.jml_order = 1 THEN 'New Customer' WHEN cust.jml_order > 1 THEN 'Repeate Order' ELSE 'No Order' END customer_category,
            cust.user_registered,
            cust.phone_number,
            cust.shipping_addreas_1,
            cust.shipping_addreas_2,
            cust.shipping_city,
            cust.shipping_state,
            cust.shipping_postcode,
            cust.shipping_country,
            produk.sku, 
            produk.item, 
            produk.cat_id,
            produk.cat_name, 
            produk.harsat, 
            produk.qty,
            produk.berat, 
            produk.ekspedisi, 
            produk.biaya_kirim, 
            produk.metode_bayar
        FROM 
            tq_posts tp,
            (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp,
            tq_woocommerce_order_items toi,
            tq_woocommerce_order_itemmeta toim,
        (	
        SELECT DISTINCT tqp.post_id, 
            tp.post_date tgl_pesanan,
        SUBSTRING(tp.post_status,4) post_status,
            tqp.meta_value customer_id,
            tu.display_name, 
        tu.user_email, 
        tu.user_registered,
            bp.meta_value phone_number,
            sa1.meta_value shipping_addreas_1,
            sa2.meta_value shipping_addreas_2,
            sc.meta_value shipping_city,
            transaksi.jml_order,
        CASE WHEN ss.meta_value ='AC' THEN 'Aceh' WHEN ss.meta_value ='BA' THEN 'Bali' WHEN ss.meta_value ='BT' THEN 'Banten' WHEN ss.meta_value ='BE' THEN 'Bengkulu' WHEN ss.meta_value ='GO' THEN 'Gorontalo' WHEN ss.meta_value ='JK' THEN 'Jakarta' WHEN ss.meta_value ='JA' THEN 'Jambi' WHEN ss.meta_value ='JW' THEN 'Jawa' WHEN ss.meta_value ='JB' THEN 'Jawa Barat' WHEN ss.meta_value ='JT' THEN 'Jawa Tengah' WHEN ss.meta_value ='JI' THEN 'Jawa Timur' WHEN ss.meta_value ='KA' THEN 'Kalimantan' WHEN ss.meta_value ='KB' THEN 'Kalimantan Barat' WHEN ss.meta_value ='KS' THEN 'Kalimantan Selatan' WHEN ss.meta_value ='KT' THEN 'Kalimantan Tengah' WHEN ss.meta_value ='KI' THEN 'Kalimantan Timur' WHEN ss.meta_value ='KU' THEN 'Kalimantan Utara' WHEN ss.meta_value ='BB' THEN 'Kepulauan Bangka Belitung' WHEN ss.meta_value ='KR' THEN 'Kepulauan Riau' WHEN ss.meta_value ='LA' THEN 'Lampung' WHEN ss.meta_value ='ML' THEN 'Maluku' WHEN ss.meta_value ='MA' THEN 'Maluku' WHEN ss.meta_value ='MU' THEN 'Maluku Utara' WHEN ss.meta_value ='NU' THEN 'Nusa Tenggara' WHEN ss.meta_value ='NB' THEN 'Nusa Tenggara Barat' WHEN ss.meta_value ='NT' THEN 'Nusa Tenggara Timur' WHEN ss.meta_value ='PP' THEN 'Papua' WHEN ss.meta_value ='PA' THEN 'Papua' WHEN ss.meta_value ='PB' THEN 'Papua Barat' WHEN ss.meta_value ='RI' THEN 'Riau' WHEN ss.meta_value ='SL' THEN 'Sulawesi' WHEN ss.meta_value ='SR' THEN 'Sulawesi Barat' WHEN ss.meta_value ='SN' THEN 'Sulawesi Selatan' WHEN ss.meta_value ='ST' THEN 'Sulawesi Tengah' WHEN ss.meta_value ='SG' THEN 'Sulawesi Tenggara' WHEN ss.meta_value ='SA' THEN 'Sulawesi Utara' WHEN ss.meta_value ='SM' THEN 'Sumatera' WHEN ss.meta_value ='SB' THEN 'Sumatera Barat' WHEN ss.meta_value ='SS' THEN 'Sumatera Selatan' WHEN ss.meta_value ='SU' THEN 'Sumatera Utara' WHEN ss.meta_value ='YO' THEN 'Yogyakarta' END shipping_state,
            spc.meta_value shipping_postcode,
            scy.name shipping_country
        FROM 
            (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_billing_phone') bp ON bp.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_address_1') sa1 ON sa1.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_address_2') sa2 ON sa2.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_city') sc ON sc.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_state') ss ON ss.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value
        FROM tq_postmeta tqp1
        WHERE tqp1.meta_key = '_shipping_postcode') spc ON spc.post_id = tqp.post_id
        LEFT JOIN (
        SELECT DISTINCT tqp1.post_id, tqp1.meta_value, tpc.name
        FROM tq_postmeta tqp1, tq_pps_countries tpc
        WHERE tqp1.meta_value = tpc.iso_code_2 AND tqp1.meta_key = '_shipping_country') scy ON scy.post_id = tqp.post_id,
        tq_posts tp,
        tq_users tu
        LEFT JOIN (
        SELECT DISTINCT tqp.meta_value cust_id,
                                    tu.display_name, COUNT(tqp.post_id) jml_order
        FROM 
                                    (
        SELECT tps.post_id, tps.meta_value
        FROM tq_postmeta tps
        WHERE tps.meta_key = '_customer_user') tqp,
                            tq_posts tp,
                            tq_users tu
        WHERE 
                            tqp.post_id = tp.id AND tqp.meta_value = tu.id AND tp.post_status = 'wc-completed'
        GROUP BY tqp.meta_value) transaksi ON transaksi.cust_id = tu.id
        WHERE 
                tqp.post_id = tp.id AND tqp.meta_value = tu.id ) cust,
        (
        SELECT DISTINCT tqwp.order_id, 
            tqwp.order_item_id, 
            tqwmp.sku, 
            tqwp.item, 
            cat.term_id cat_id,
            cat.name cat_name, 
            hgqt.harsat, 
            hgqt.qty,
            tqwmp.berat,
            tqwp.ekspedisi, 
            shiping.biaya_kirim, 
            payment.metode_bayar
        FROM
            (
        SELECT DISTINCT line.order_id, line.order_item_id, line.item, kirim.ekspedisi
        FROM
            (
        SELECT tqw.order_id, tqw.order_item_id, tqw.order_item_name item
        FROM tq_woocommerce_order_items tqw
        WHERE tqw.order_item_type = 'line_item') line, 
            (
        SELECT tqw.order_id, tqw.order_item_id, tqw.order_item_name ekspedisi
        FROM tq_woocommerce_order_items tqw
        WHERE tqw.order_item_type = 'shipping') kirim
        WHERE
            line.order_id = kirim.order_id) tqwp,
            (
        SELECT tqwm.order_item_id, item.meta_value sku, weight.meta_value berat
        FROM tq_woocommerce_order_itemmeta tqwm,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_sku' AND tqp.meta_value IS NOT NULL) item,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_weight' AND tqp.meta_value IS NOT NULL) weight
        WHERE item.post_id = tqwm.meta_value AND weight.post_id = tqwm.meta_value AND tqwm.meta_key = '_product_id') tqwmp,
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value biaya_kirim
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_order_shipping' AND tqp.meta_value IS NOT NULL) shiping, 
            (
        SELECT DISTINCT tqp.post_id, tqp.meta_value metode_bayar
        FROM tq_postmeta tqp
        WHERE tqp.meta_key = '_payment_method_title' AND tqp.meta_value IS NOT NULL) payment,
            (
        SELECT product_id.order_item_id, 
            product_id.meta_value item_id, 
            qty.meta_value qty, 
            line_total.meta_value/qty.meta_value harsat
        FROM (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_product_id') product_id,
            (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_qty') qty,
            (
        SELECT tqwm.*
        FROM tq_woocommerce_order_itemmeta tqwm
        WHERE tqwm.meta_key = '_line_total') line_total
        WHERE product_id.order_item_id = qty.order_item_id AND qty.order_item_id = line_total.order_item_id) hgqt,
            (
        SELECT *
        FROM tq_woocommerce_order_itemmeta
        WHERE meta_key = '_product_id') tqwm,
            tq_term_relationships ttr
        LEFT JOIN (
                SELECT ttt.parent, ttt.term_id, tqt.name
                FROM tq_term_taxonomy ttt, tq_terms tqt
                WHERE 
                    ttt.parent != 0 AND ttt.term_id NOT in (
                SELECT ttt1.parent
                FROM tq_term_taxonomy ttt1
                WHERE ttt1.taxonomy = 'product_cat') AND ttt.taxonomy = 'product_cat' AND tqt.term_id = ttt.term_id) cat ON cat.term_id = ttr.term_taxonomy_id
                WHERE tqwmp.order_item_id = tqwp.order_item_id AND payment.post_id = tqwp.order_id AND shiping.post_id = tqwp.order_id AND hgqt.order_item_id = tqwp.order_item_id 
                AND tqwp.order_item_id = tqwm.order_item_id AND tqwm.meta_value = ttr.object_id AND cat.term_id IS NOT NULL) produk
        WHERE 
        tqp.post_id = tp.id 
        and tqp.post_id = toi.order_id 
        AND toi.order_item_id = toim.order_item_id 
        AND toim.order_item_id = produk.order_item_id
        AND tqp.meta_value = cust.customer_id 
        AND tqp.post_id = cust.post_id
        AND toim.meta_key = '_product_id' 
        ORDER BY	tp.post_date
        ";
        $query = $tokoquick->query($sql1);
        return $query->result_array();

        return $sql1;
    }
}