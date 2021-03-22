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
      $sql = 'SELECT
                  tu.display_name
               FROM
                  tq_users tu
               WHERE
                  tu.display_name IS NOT NULL
               ORDER BY
                  1';
      $query = $getUser->query($sql);

      return $query->result_array();
   }

   public function getItemCat()
   {
      $getUser = $this->load->database('tokoquick', true);
      $sql = 'SELECT
                  tqt.name
               FROM
                  tq_terms tqt
               WHERE
                  tqt.name IS NOT NULL
               ORDER BY
               1';
      $query = $getUser->query($sql);

      return $query->result_array();
   }

   public function getItemName()
   {
      $getUser = $this->load->database('tokoquick', true);
      $sql = 'SELECT
                  tqw.order_item_name
               FROM
                  tq_woocommerce_order_items tqw
               WHERE
                  tqw.order_item_name IS NOT NULL
               GROUP BY
                  tqw.order_item_name';
      $query = $getUser->query($sql);

      return $query->result_array();
   }

   public function export($Name)
   {
      $tokoquick = $this->load->database('tokoquick', true);
      $sql1 = "SELECT  distinct 
                  tu.id user_id, 
                  tu.display_name, 
                  tu.user_email, 
                  tu.user_registered,
                  sfn.meta_value shipping_first_name,
                  sln.meta_value shipping_last_name,
                  bp.meta_value phone_number,
                  sa1.meta_value shipping_addreas_1,
                  sa2.meta_value shipping_addreas_2,
                  sc.meta_value shipping_city,
                  case 
                     when ss.meta_value ='AC' then 'Aceh'
                     when ss.meta_value ='BA' then 'Bali'
                     when ss.meta_value ='BT' then 'Banten'
                     when ss.meta_value ='BE' then 'Bengkulu'
                     when ss.meta_value ='GO' then 'Gorontalo'
                     when ss.meta_value ='JK' then 'Jakarta'
                     when ss.meta_value ='JA' then 'Jambi'
                     when ss.meta_value ='JW' then 'Jawa'
                     when ss.meta_value ='JB' then 'Jawa Barat'
                     when ss.meta_value ='JT' then 'Jawa Tengah'
                     when ss.meta_value ='JI' then 'Jawa Timur'
                     when ss.meta_value ='KA' then 'Kalimantan'
                     when ss.meta_value ='KB' then 'Kalimantan Barat'
                     when ss.meta_value ='KS' then 'Kalimantan Selatan'
                     when ss.meta_value ='KT' then 'Kalimantan Tengah'
                     when ss.meta_value ='KI' then 'Kalimantan Timur'
                     when ss.meta_value ='KU' then 'Kalimantan Utara'
                     when ss.meta_value ='BB' then 'Kepulauan Bangka Belitung'
                     when ss.meta_value ='KR' then 'Kepulauan Riau'
                     when ss.meta_value ='LA' then 'Lampung'
                     when ss.meta_value ='ML' then 'Maluku'
                     when ss.meta_value ='MA' then 'Maluku'
                     when ss.meta_value ='MU' then 'Maluku Utara'
                     when ss.meta_value ='NU' then 'Nusa Tenggara'
                     when ss.meta_value ='NB' then 'Nusa Tenggara Barat'
                     when ss.meta_value ='NT' then 'Nusa Tenggara Timur'
                     when ss.meta_value ='PP' then 'Papua'
                     when ss.meta_value ='PA' then 'Papua'
                     when ss.meta_value ='PB' then 'Papua Barat'
                     when ss.meta_value ='RI' then 'Riau'
                     when ss.meta_value ='SL' then 'Sulawesi'
                     when ss.meta_value ='SR' then 'Sulawesi Barat'
                     when ss.meta_value ='SN' then 'Sulawesi Selatan'
                     when ss.meta_value ='ST' then 'Sulawesi Tengah'
                     when ss.meta_value ='SG' then 'Sulawesi Tenggara'
                     when ss.meta_value ='SA' then 'Sulawesi Utara'
                     when ss.meta_value ='SM' then 'Sumatera'
                     when ss.meta_value ='SB' then 'Sumatera Barat'
                     when ss.meta_value ='SS' then 'Sumatera Selatan'
                     when ss.meta_value ='SU' then 'Sumatera Utara'
                     when ss.meta_value ='YO' then 'Yogyakarta'
                  end shipping_state,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
	               spc.meta_value shipping_postcode,
	               scy.meta_value shipping_country,
                  c_order.post_id nomor_order,
                  tqp.post_date,
                  -- substring(tqp.post_status,4) post_status,
               -- cat.term_id cat_id, 
               -- tqwm.meta_value item_id,
                  item.meta_value,
                  tqw.order_item_name,
                  cat.name cat_name             
               from tq_users tu
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_first_name') sfn on sfn.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_last_name') sln on sln.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'billing_phone') bp on bp.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_address_1') sa1 on sa1.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_address_2') sa2 on sa2.user_id = tu.id
                  left join (select  distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_city') sc on sc.user_id = tu.id
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_state') ss on ss.user_id = tu.id
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_postcode') spc on spc.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_country') scy on scy.user_id = tu.id
                  left join (select distinct tqp.post_id, tqp.meta_value
                     from tq_postmeta tqp
                     where tqp.meta_key = '_customer_user'
                     and tqp.meta_value is not null) c_order on c_order.meta_value = tu.id,
                        tq_woocommerce_order_items tqw,
                        tq_woocommerce_order_itemmeta tqwm
                  left join (select distinct tqp.post_id, tqp.meta_value
                     from tq_postmeta tqp
                     where tqp.meta_key = '_sku'
                     and tqp.meta_value is not null) item on item.post_id = tqwm.meta_value,
                        tq_term_relationships ttr
                  left join (select ttt.parent, ttt.term_id,  tqt.name
                     from tq_term_taxonomy ttt, tq_terms tqt
                     where ttt.parent != 0 
                     and ttt.term_id not in 
                        (select ttt1.parent
                        from tq_term_taxonomy ttt1
                        where ttt1.taxonomy = 'product_cat')
                     and ttt.taxonomy = 'product_cat'
                     and tqt.term_id = ttt.term_id) cat on cat.term_id = ttr.term_taxonomy_id,
                        tq_posts tqp
               where c_order.post_id = tqw.order_id
               and tqw.order_id = tqp.id
               and tqw.order_item_id = tqwm.order_item_id
               and tqwm.meta_value = ttr.object_id
               and cat.term_id is not null
               and tqwm.meta_key = '_product_id'
               and tqw.order_item_type  = 'line_item'
               and tqp.post_status != 'wc-cancelled'
               AND tu.display_name = '$Name' 
   ";
      $query = $tokoquick->query($sql1);
      // echo $sql1;
      // exit();
      return $query->result_array();

      return $sql1;
   }

   public function exportCat($Name, $Cat_Name)
   {
      $tokoquick = $this->load->database('tokoquick', true);
      $sql1 = "SELECT  distinct
                  tu.id user_id, 
                  tu.display_name, 
                  tu.user_email, 
                  tu.user_registered,
                  sfn.meta_value shipping_first_name,
                  sln.meta_value shipping_last_name,
                  bp.meta_value phone_number,
                  sa1.meta_value shipping_addreas_1,
                  sa2.meta_value shipping_addreas_2,
                  sc.meta_value shipping_city,
                  case 
                     when ss.meta_value ='AC' then 'Aceh'
                     when ss.meta_value ='BA' then 'Bali'
                     when ss.meta_value ='BT' then 'Banten'
                     when ss.meta_value ='BE' then 'Bengkulu'
                     when ss.meta_value ='GO' then 'Gorontalo'
                     when ss.meta_value ='JK' then 'Jakarta'
                     when ss.meta_value ='JA' then 'Jambi'
                     when ss.meta_value ='JW' then 'Jawa'
                     when ss.meta_value ='JB' then 'Jawa Barat'
                     when ss.meta_value ='JT' then 'Jawa Tengah'
                     when ss.meta_value ='JI' then 'Jawa Timur'
                     when ss.meta_value ='KA' then 'Kalimantan'
                     when ss.meta_value ='KB' then 'Kalimantan Barat'
                     when ss.meta_value ='KS' then 'Kalimantan Selatan'
                     when ss.meta_value ='KT' then 'Kalimantan Tengah'
                     when ss.meta_value ='KI' then 'Kalimantan Timur'
                     when ss.meta_value ='KU' then 'Kalimantan Utara'
                     when ss.meta_value ='BB' then 'Kepulauan Bangka Belitung'
                     when ss.meta_value ='KR' then 'Kepulauan Riau'
                     when ss.meta_value ='LA' then 'Lampung'
                     when ss.meta_value ='ML' then 'Maluku'
                     when ss.meta_value ='MA' then 'Maluku'
                     when ss.meta_value ='MU' then 'Maluku Utara'
                     when ss.meta_value ='NU' then 'Nusa Tenggara'
                     when ss.meta_value ='NB' then 'Nusa Tenggara Barat'
                     when ss.meta_value ='NT' then 'Nusa Tenggara Timur'
                     when ss.meta_value ='PP' then 'Papua'
                     when ss.meta_value ='PA' then 'Papua'
                     when ss.meta_value ='PB' then 'Papua Barat'
                     when ss.meta_value ='RI' then 'Riau'
                     when ss.meta_value ='SL' then 'Sulawesi'
                     when ss.meta_value ='SR' then 'Sulawesi Barat'
                     when ss.meta_value ='SN' then 'Sulawesi Selatan'
                     when ss.meta_value ='ST' then 'Sulawesi Tengah'
                     when ss.meta_value ='SG' then 'Sulawesi Tenggara'
                     when ss.meta_value ='SA' then 'Sulawesi Utara'
                     when ss.meta_value ='SM' then 'Sumatera'
                     when ss.meta_value ='SB' then 'Sumatera Barat'
                     when ss.meta_value ='SS' then 'Sumatera Selatan'
                     when ss.meta_value ='SU' then 'Sumatera Utara'
                     when ss.meta_value ='YO' then 'Yogyakarta'
                  end shipping_state,                   
                  spc.meta_value shipping_postcode,
                  scy.meta_value shipping_country,
                  c_order.post_id nomor_order,
                  tqp.post_date,
                  -- substring(tqp.post_status,4) post_status,
                  -- cat.term_id cat_id, 
                  -- tqwm.meta_value item_id,
                  item.meta_value,
                  tqw.order_item_name,
                  cat.name cat_name             
               from tq_users tu
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_first_name') sfn on sfn.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_last_name') sln on sln.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'billing_phone') bp on bp.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_address_1') sa1 on sa1.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_address_2') sa2 on sa2.user_id = tu.id
                  left join (select  distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_city') sc on sc.user_id = tu.id
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_state') ss on ss.user_id = tu.id
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_postcode') spc on spc.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_country') scy on scy.user_id = tu.id
                  left join (select distinct tqp.post_id, tqp.meta_value
                     from tq_postmeta tqp
                     where tqp.meta_key = '_customer_user'
                     and tqp.meta_value is not null) c_order on c_order.meta_value = tu.id,
                     tq_woocommerce_order_items tqw,
                     tq_woocommerce_order_itemmeta tqwm
                  left join (select distinct tqp.post_id, tqp.meta_value
                     from tq_postmeta tqp
                     where tqp.meta_key = '_sku'
                     and tqp.meta_value is not null) item on item.post_id = tqwm.meta_value,
                     tq_term_relationships ttr
                  left join (select ttt.parent, ttt.term_id,  tqt.name
                     from tq_term_taxonomy ttt, tq_terms tqt
                     where ttt.parent != 0 
                     and ttt.term_id not in
                        (select ttt1.parent
                        from tq_term_taxonomy ttt1
                        where ttt1.taxonomy = 'product_cat')
                     and ttt.taxonomy = 'product_cat'
                     and tqt.term_id = ttt.term_id) cat on cat.term_id = ttr.term_taxonomy_id,
                        tq_posts tqp
               where c_order.post_id = tqw.order_id
               and tqw.order_id = tqp.id
               and tqw.order_item_id = tqwm.order_item_id
               and tqwm.meta_value = ttr.object_id
               and cat.term_id is not null
               and tqwm.meta_key = '_product_id'
               and tqw.order_item_type  = 'line_item'
               and tqp.post_status != 'wc-cancelled'
               AND tu.display_name = '$Name' 
               AND cat.name like '$Cat_Name' 
   ";
      $query = $tokoquick->query($sql1);
      // echo $sql1;
      // exit();
      return $query->result_array();

      return $sql1;
   }

   public function exportItem($Name, $Cat_Name, $Item_Name)
   {
      $tokoquick = $this->load->database('tokoquick', true);
      $sql1 = "SELECT  distinct tu.id user_id, 
                  tu.display_name, 
                  tu.user_email, 
                  tu.user_registered,
                  sfn.meta_value shipping_first_name,
                  sln.meta_value shipping_last_name,
                  bp.meta_value phone_number,
                  sa1.meta_value shipping_addreas_1,
                  sa2.meta_value shipping_addreas_2,
                  sc.meta_value shipping_city,
                  case 
                     when ss.meta_value ='AC' then 'Aceh'
                     when ss.meta_value ='BA' then 'Bali'
                     when ss.meta_value ='BT' then 'Banten'
                     when ss.meta_value ='BE' then 'Bengkulu'
                     when ss.meta_value ='GO' then 'Gorontalo'
                     when ss.meta_value ='JK' then 'Jakarta'
                     when ss.meta_value ='JA' then 'Jambi'
                     when ss.meta_value ='JW' then 'Jawa'
                     when ss.meta_value ='JB' then 'Jawa Barat'
                     when ss.meta_value ='JT' then 'Jawa Tengah'
                     when ss.meta_value ='JI' then 'Jawa Timur'
                     when ss.meta_value ='KA' then 'Kalimantan'
                     when ss.meta_value ='KB' then 'Kalimantan Barat'
                     when ss.meta_value ='KS' then 'Kalimantan Selatan'
                     when ss.meta_value ='KT' then 'Kalimantan Tengah'
                     when ss.meta_value ='KI' then 'Kalimantan Timur'
                     when ss.meta_value ='KU' then 'Kalimantan Utara'
                     when ss.meta_value ='BB' then 'Kepulauan Bangka Belitung'
                     when ss.meta_value ='KR' then 'Kepulauan Riau'
                     when ss.meta_value ='LA' then 'Lampung'
                     when ss.meta_value ='ML' then 'Maluku'
                     when ss.meta_value ='MA' then 'Maluku'
                     when ss.meta_value ='MU' then 'Maluku Utara'
                     when ss.meta_value ='NU' then 'Nusa Tenggara'
                     when ss.meta_value ='NB' then 'Nusa Tenggara Barat'
                     when ss.meta_value ='NT' then 'Nusa Tenggara Timur'
                     when ss.meta_value ='PP' then 'Papua'
                     when ss.meta_value ='PA' then 'Papua'
                     when ss.meta_value ='PB' then 'Papua Barat'
                     when ss.meta_value ='RI' then 'Riau'
                     when ss.meta_value ='SL' then 'Sulawesi'
                     when ss.meta_value ='SR' then 'Sulawesi Barat'
                     when ss.meta_value ='SN' then 'Sulawesi Selatan'
                     when ss.meta_value ='ST' then 'Sulawesi Tengah'
                     when ss.meta_value ='SG' then 'Sulawesi Tenggara'
                     when ss.meta_value ='SA' then 'Sulawesi Utara'
                     when ss.meta_value ='SM' then 'Sumatera'
                     when ss.meta_value ='SB' then 'Sumatera Barat'
                     when ss.meta_value ='SS' then 'Sumatera Selatan'
                     when ss.meta_value ='SU' then 'Sumatera Utara'
                     when ss.meta_value ='YO' then 'Yogyakarta'
                  end shipping_state,                   
                  spc.meta_value shipping_postcode,
                  scy.meta_value shipping_country,
                  c_order.post_id nomor_order,
                  tqp.post_date,
                  -- substring(tqp.post_status,4) post_status,
                  -- cat.term_id cat_id, 
                  -- tqwm.meta_value item_id,
                  item.meta_value,
                  tqw.order_item_name,
                  cat.name cat_name             
               from tq_users tu
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_first_name') sfn on sfn.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_last_name') sln on sln.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'billing_phone') bp on bp.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_address_1') sa1 on sa1.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_address_2') sa2 on sa2.user_id = tu.id
                  left join (select  distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_city') sc on sc.user_id = tu.id
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_state') ss on ss.user_id = tu.id
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_postcode') spc on spc.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_country') scy on scy.user_id = tu.id
                  left join (select distinct tqp.post_id, tqp.meta_value
                     from tq_postmeta tqp
                     where tqp.meta_key = '_customer_user'
                     and tqp.meta_value is not null) c_order on c_order.meta_value = tu.id,
                        tq_woocommerce_order_items tqw,
                        tq_woocommerce_order_itemmeta tqwm
                  left join (select distinct tqp.post_id, tqp.meta_value
                     from tq_postmeta tqp
                     where tqp.meta_key = '_sku'
                     and tqp.meta_value is not null) item on item.post_id = tqwm.meta_value,
                        tq_term_relationships ttr
                  left join (select ttt.parent, ttt.term_id,  tqt.name
                     from tq_term_taxonomy ttt, tq_terms tqt
                     where ttt.parent != 0 
                     and ttt.term_id not in 
                        (select ttt1.parent
                        from tq_term_taxonomy ttt1
                        where ttt1.taxonomy = 'product_cat')
                     and ttt.taxonomy = 'product_cat'
                     and tqt.term_id = ttt.term_id) cat on cat.term_id = ttr.term_taxonomy_id,
                        tq_posts tqp
               where c_order.post_id = tqw.order_id
               and tqw.order_id = tqp.id
               and tqw.order_item_id = tqwm.order_item_id
               and tqwm.meta_value = ttr.object_id
               and cat.term_id is not null
               and tqwm.meta_key = '_product_id'
               and tqw.order_item_type  = 'line_item'
               and tqp.post_status != 'wc-cancelled'
               AND tu.display_name = '$Name' 
               AND cat.name like '$Cat_Name' 
               and tqw.order_item_name like '$Item_Name'
   ";
      $query = $tokoquick->query($sql1);
      // echo $sql1;
      // exit();
      return $query->result_array();

      return $sql1;
   }

   public function exportCatNam($Cat_Name)
   {
      $tokoquick = $this->load->database('tokoquick', true);
      $sql1 = "SELECT  distinct tu.id user_id, 
                  tu.display_name, 
                  tu.user_email, 
                  tu.user_registered,
                  sfn.meta_value shipping_first_name,
                  sln.meta_value shipping_last_name,
                  bp.meta_value phone_number,
                  sa1.meta_value shipping_addreas_1,
                  sa2.meta_value shipping_addreas_2,
                  sc.meta_value shipping_city,
                  case 
                     when ss.meta_value ='AC' then 'Aceh'
                     when ss.meta_value ='BA' then 'Bali'
                     when ss.meta_value ='BT' then 'Banten'
                     when ss.meta_value ='BE' then 'Bengkulu'
                     when ss.meta_value ='GO' then 'Gorontalo'
                     when ss.meta_value ='JK' then 'Jakarta'
                     when ss.meta_value ='JA' then 'Jambi'
                     when ss.meta_value ='JW' then 'Jawa'
                     when ss.meta_value ='JB' then 'Jawa Barat'
                     when ss.meta_value ='JT' then 'Jawa Tengah'
                     when ss.meta_value ='JI' then 'Jawa Timur'
                     when ss.meta_value ='KA' then 'Kalimantan'
                     when ss.meta_value ='KB' then 'Kalimantan Barat'
                     when ss.meta_value ='KS' then 'Kalimantan Selatan'
                     when ss.meta_value ='KT' then 'Kalimantan Tengah'
                     when ss.meta_value ='KI' then 'Kalimantan Timur'
                     when ss.meta_value ='KU' then 'Kalimantan Utara'
                     when ss.meta_value ='BB' then 'Kepulauan Bangka Belitung'
                     when ss.meta_value ='KR' then 'Kepulauan Riau'
                     when ss.meta_value ='LA' then 'Lampung'
                     when ss.meta_value ='ML' then 'Maluku'
                     when ss.meta_value ='MA' then 'Maluku'
                     when ss.meta_value ='MU' then 'Maluku Utara'
                     when ss.meta_value ='NU' then 'Nusa Tenggara'
                     when ss.meta_value ='NB' then 'Nusa Tenggara Barat'
                     when ss.meta_value ='NT' then 'Nusa Tenggara Timur'
                     when ss.meta_value ='PP' then 'Papua'
                     when ss.meta_value ='PA' then 'Papua'
                     when ss.meta_value ='PB' then 'Papua Barat'
                     when ss.meta_value ='RI' then 'Riau'
                     when ss.meta_value ='SL' then 'Sulawesi'
                     when ss.meta_value ='SR' then 'Sulawesi Barat'
                     when ss.meta_value ='SN' then 'Sulawesi Selatan'
                     when ss.meta_value ='ST' then 'Sulawesi Tengah'
                     when ss.meta_value ='SG' then 'Sulawesi Tenggara'
                     when ss.meta_value ='SA' then 'Sulawesi Utara'
                     when ss.meta_value ='SM' then 'Sumatera'
                     when ss.meta_value ='SB' then 'Sumatera Barat'
                     when ss.meta_value ='SS' then 'Sumatera Selatan'
                     when ss.meta_value ='SU' then 'Sumatera Utara'
                     when ss.meta_value ='YO' then 'Yogyakarta'
                  end shipping_state,                   
                  spc.meta_value shipping_postcode,
                  scy.meta_value shipping_country,
                  c_order.post_id nomor_order,
                  tqp.post_date,
                  -- substring(tqp.post_status,4) post_status,
                  -- cat.term_id cat_id, 
                  -- tqwm.meta_value item_id,
                  item.meta_value,
                  tqw.order_item_name,
                  cat.name cat_name             
               from tq_users tu
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_first_name') sfn on sfn.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_last_name') sln on sln.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'billing_phone') bp on bp.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_address_1') sa1 on sa1.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_address_2') sa2 on sa2.user_id = tu.id
                  left join (select  distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_city') sc on sc.user_id = tu.id
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_state') ss on ss.user_id = tu.id
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_postcode') spc on spc.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_country') scy on scy.user_id = tu.id
                  left join (select distinct tqp.post_id, tqp.meta_value
                     from tq_postmeta tqp
                     where tqp.meta_key = '_customer_user'
                     and tqp.meta_value is not null) c_order on c_order.meta_value = tu.id,
                        tq_woocommerce_order_items tqw,
                        tq_woocommerce_order_itemmeta tqwm
                  left join (select distinct tqp.post_id, tqp.meta_value
                     from tq_postmeta tqp
                     where tqp.meta_key = '_sku'
                     and tqp.meta_value is not null) item on item.post_id = tqwm.meta_value,
                        tq_term_relationships ttr
                  left join (select ttt.parent, ttt.term_id,  tqt.name
                     from tq_term_taxonomy ttt, tq_terms tqt
                     where ttt.parent != 0 
                     and ttt.term_id not in 
                        (select ttt1.parent
                           from tq_term_taxonomy ttt1
                           where ttt1.taxonomy = 'product_cat')
                     and ttt.taxonomy = 'product_cat'
                     and tqt.term_id = ttt.term_id) cat on cat.term_id = ttr.term_taxonomy_id,
                        tq_posts tqp
               where c_order.post_id = tqw.order_id
               and tqw.order_id = tqp.id
               and tqw.order_item_id = tqwm.order_item_id
               and tqwm.meta_value = ttr.object_id
               and cat.term_id is not null
               and tqwm.meta_key = '_product_id'
               and tqw.order_item_type  = 'line_item'
               and tqp.post_status != 'wc-cancelled'
               AND cat.name like '$Cat_Name' 
   ";
      $query = $tokoquick->query($sql1);
      // echo $sql1;
      // exit();
      return $query->result_array();

      return $sql1;
   }

   public function exportCatItem($Cat_Name, $Item_Name)
   {
      $tokoquick = $this->load->database('tokoquick', true);
      $sql1 = "SELECT  distinct tu.id user_id, 
                  tu.display_name, 
                  tu.user_email, 
                  tu.user_registered,
                  sfn.meta_value shipping_first_name,
                  sln.meta_value shipping_last_name,
                  bp.meta_value phone_number,
                  sa1.meta_value shipping_addreas_1,
                  sa2.meta_value shipping_addreas_2,
                  sc.meta_value shipping_city,
                  case 
                     when ss.meta_value ='AC' then 'Aceh'
                     when ss.meta_value ='BA' then 'Bali'
                     when ss.meta_value ='BT' then 'Banten'
                     when ss.meta_value ='BE' then 'Bengkulu'
                     when ss.meta_value ='GO' then 'Gorontalo'
                     when ss.meta_value ='JK' then 'Jakarta'
                     when ss.meta_value ='JA' then 'Jambi'
                     when ss.meta_value ='JW' then 'Jawa'
                     when ss.meta_value ='JB' then 'Jawa Barat'
                     when ss.meta_value ='JT' then 'Jawa Tengah'
                     when ss.meta_value ='JI' then 'Jawa Timur'
                     when ss.meta_value ='KA' then 'Kalimantan'
                     when ss.meta_value ='KB' then 'Kalimantan Barat'
                     when ss.meta_value ='KS' then 'Kalimantan Selatan'
                     when ss.meta_value ='KT' then 'Kalimantan Tengah'
                     when ss.meta_value ='KI' then 'Kalimantan Timur'
                     when ss.meta_value ='KU' then 'Kalimantan Utara'
                     when ss.meta_value ='BB' then 'Kepulauan Bangka Belitung'
                     when ss.meta_value ='KR' then 'Kepulauan Riau'
                     when ss.meta_value ='LA' then 'Lampung'
                     when ss.meta_value ='ML' then 'Maluku'
                     when ss.meta_value ='MA' then 'Maluku'
                     when ss.meta_value ='MU' then 'Maluku Utara'
                     when ss.meta_value ='NU' then 'Nusa Tenggara'
                     when ss.meta_value ='NB' then 'Nusa Tenggara Barat'
                     when ss.meta_value ='NT' then 'Nusa Tenggara Timur'
                     when ss.meta_value ='PP' then 'Papua'
                     when ss.meta_value ='PA' then 'Papua'
                     when ss.meta_value ='PB' then 'Papua Barat'
                     when ss.meta_value ='RI' then 'Riau'
                     when ss.meta_value ='SL' then 'Sulawesi'
                     when ss.meta_value ='SR' then 'Sulawesi Barat'
                     when ss.meta_value ='SN' then 'Sulawesi Selatan'
                     when ss.meta_value ='ST' then 'Sulawesi Tengah'
                     when ss.meta_value ='SG' then 'Sulawesi Tenggara'
                     when ss.meta_value ='SA' then 'Sulawesi Utara'
                     when ss.meta_value ='SM' then 'Sumatera'
                     when ss.meta_value ='SB' then 'Sumatera Barat'
                     when ss.meta_value ='SS' then 'Sumatera Selatan'
                     when ss.meta_value ='SU' then 'Sumatera Utara'
                     when ss.meta_value ='YO' then 'Yogyakarta'
                  end shipping_state,                   
                  spc.meta_value shipping_postcode,
                  scy.meta_value shipping_country,
                  c_order.post_id nomor_order,
                  tqp.post_date,
                  -- substring(tqp.post_status,4) post_status,
                  -- cat.term_id cat_id, 
                  -- tqwm.meta_value item_id,
                  item.meta_value,
                  tqw.order_item_name,
                  cat.name cat_name             
               from tq_users tu
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_first_name') sfn on sfn.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_last_name') sln on sln.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'billing_phone') bp on bp.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_address_1') sa1 on sa1.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_address_2') sa2 on sa2.user_id = tu.id
                  left join (select  distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_city') sc on sc.user_id = tu.id
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_state') ss on ss.user_id = tu.id
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_postcode') spc on spc.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_country') scy on scy.user_id = tu.id
                  left join (select distinct tqp.post_id, tqp.meta_value
                     from tq_postmeta tqp
                     where tqp.meta_key = '_customer_user'
                     and tqp.meta_value is not null) c_order on c_order.meta_value = tu.id,
                        tq_woocommerce_order_items tqw,
                        tq_woocommerce_order_itemmeta tqwm
                  left join (select distinct tqp.post_id, tqp.meta_value
                     from tq_postmeta tqp
                     where tqp.meta_key = '_sku'
                     and tqp.meta_value is not null) item on item.post_id = tqwm.meta_value,
                        tq_term_relationships ttr
                  left join (select ttt.parent, ttt.term_id,  tqt.name
                     from tq_term_taxonomy ttt, tq_terms tqt
                     where ttt.parent != 0 
                     and ttt.term_id not in 
                        (select ttt1.parent
                        from tq_term_taxonomy ttt1
                        where ttt1.taxonomy = 'product_cat')
                     and ttt.taxonomy = 'product_cat'
                     and tqt.term_id = ttt.term_id) cat on cat.term_id = ttr.term_taxonomy_id,
                        tq_posts tqp
               where c_order.post_id = tqw.order_id
               and tqw.order_id = tqp.id
               and tqw.order_item_id = tqwm.order_item_id
               and tqwm.meta_value = ttr.object_id
               and cat.term_id is not null
               and tqwm.meta_key = '_product_id'
               and tqw.order_item_type  = 'line_item'
               and tqp.post_status != 'wc-cancelled'
               AND cat.name like '$Cat_Name' 
               and tqw.order_item_name like '$Item_Name'
   ";
      $query = $tokoquick->query($sql1);
      // echo $sql1;
      // exit();
      return $query->result_array();

      return $sql1;
   }

   public function exportItemNam($Item_Name)
   {
      $tokoquick = $this->load->database('tokoquick', true);
      $sql1 = "SELECT  distinct tu.id user_id, 
                  tu.display_name, 
                  tu.user_email, 
                  tu.user_registered,
                  sfn.meta_value shipping_first_name,
                  sln.meta_value shipping_last_name,
                  bp.meta_value phone_number,
                  sa1.meta_value shipping_addreas_1,
                  sa2.meta_value shipping_addreas_2,
                  sc.meta_value shipping_city,
                  ss.meta_value shipping_state,
                  spc.meta_value shipping_postcode,
                  scy.meta_value shipping_country,
                  c_order.post_id nomor_order,
                  tqp.post_date,
                  -- substring(tqp.post_status,4) post_status,
                  -- cat.term_id cat_id, 
                  -- tqwm.meta_value item_id,
                  item.meta_value,
                  tqw.order_item_name,
                  cat.name cat_name             
               from tq_users tu
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_first_name') sfn on sfn.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_last_name') sln on sln.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'billing_phone') bp on bp.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_address_1') sa1 on sa1.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_address_2') sa2 on sa2.user_id = tu.id
                  left join (select  distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_city') sc on sc.user_id = tu.id
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_state') ss on ss.user_id = tu.id
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_postcode') spc on spc.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_country') scy on scy.user_id = tu.id
                  left join (select distinct tqp.post_id, tqp.meta_value
                     from tq_postmeta tqp
                     where tqp.meta_key = '_customer_user'
                     and tqp.meta_value is not null) c_order on c_order.meta_value = tu.id,
                        tq_woocommerce_order_items tqw,
                        tq_woocommerce_order_itemmeta tqwm
                  left join (select distinct tqp.post_id, tqp.meta_value
                     from tq_postmeta tqp
                     where tqp.meta_key = '_sku'
                     and tqp.meta_value is not null) item on item.post_id = tqwm.meta_value,
                     tq_term_relationships ttr
                  left join (select ttt.parent, ttt.term_id,  tqt.name
                     from tq_term_taxonomy ttt, tq_terms tqt
                     where ttt.parent != 0 
                     and ttt.term_id not in 
                        (select ttt1.parent
                        from tq_term_taxonomy ttt1
                        where ttt1.taxonomy = 'product_cat')
                     and ttt.taxonomy = 'product_cat'
                     and tqt.term_id = ttt.term_id) cat on cat.term_id = ttr.term_taxonomy_id,
                        tq_posts tqp
               where c_order.post_id = tqw.order_id
               and tqw.order_id = tqp.id
               and tqw.order_item_id = tqwm.order_item_id
               and tqwm.meta_value = ttr.object_id
               and cat.term_id is not null
               and tqwm.meta_key = '_product_id'
               and tqw.order_item_type  = 'line_item'
               and tqp.post_status != 'wc-cancelled'
               and tqw.order_item_name like '$Item_Name'
   ";
      $query = $tokoquick->query($sql1);
      // echo $sql1;
      // exit();
      return $query->result_array();

      return $sql1;
   }

   public function exportItemName($Name, $Item_Name)
   {
      $tokoquick = $this->load->database('tokoquick', true);
      $sql1 = "SELECT  distinct tu.id user_id, 
                  tu.display_name, 
                  tu.user_email, 
                  tu.user_registered,
                  sfn.meta_value shipping_first_name,
                  sln.meta_value shipping_last_name,
                  bp.meta_value phone_number,
                  sa1.meta_value shipping_addreas_1,
                  sa2.meta_value shipping_addreas_2,
                  sc.meta_value shipping_city,
                  case 
                     when ss.meta_value ='AC' then 'Aceh'
                     when ss.meta_value ='BA' then 'Bali'
                     when ss.meta_value ='BT' then 'Banten'
                     when ss.meta_value ='BE' then 'Bengkulu'
                     when ss.meta_value ='GO' then 'Gorontalo'
                     when ss.meta_value ='JK' then 'Jakarta'
                     when ss.meta_value ='JA' then 'Jambi'
                     when ss.meta_value ='JW' then 'Jawa'
                     when ss.meta_value ='JB' then 'Jawa Barat'
                     when ss.meta_value ='JT' then 'Jawa Tengah'
                     when ss.meta_value ='JI' then 'Jawa Timur'
                     when ss.meta_value ='KA' then 'Kalimantan'
                     when ss.meta_value ='KB' then 'Kalimantan Barat'
                     when ss.meta_value ='KS' then 'Kalimantan Selatan'
                     when ss.meta_value ='KT' then 'Kalimantan Tengah'
                     when ss.meta_value ='KI' then 'Kalimantan Timur'
                     when ss.meta_value ='KU' then 'Kalimantan Utara'
                     when ss.meta_value ='BB' then 'Kepulauan Bangka Belitung'
                     when ss.meta_value ='KR' then 'Kepulauan Riau'
                     when ss.meta_value ='LA' then 'Lampung'
                     when ss.meta_value ='ML' then 'Maluku'
                     when ss.meta_value ='MA' then 'Maluku'
                     when ss.meta_value ='MU' then 'Maluku Utara'
                     when ss.meta_value ='NU' then 'Nusa Tenggara'
                     when ss.meta_value ='NB' then 'Nusa Tenggara Barat'
                     when ss.meta_value ='NT' then 'Nusa Tenggara Timur'
                     when ss.meta_value ='PP' then 'Papua'
                     when ss.meta_value ='PA' then 'Papua'
                     when ss.meta_value ='PB' then 'Papua Barat'
                     when ss.meta_value ='RI' then 'Riau'
                     when ss.meta_value ='SL' then 'Sulawesi'
                     when ss.meta_value ='SR' then 'Sulawesi Barat'
                     when ss.meta_value ='SN' then 'Sulawesi Selatan'
                     when ss.meta_value ='ST' then 'Sulawesi Tengah'
                     when ss.meta_value ='SG' then 'Sulawesi Tenggara'
                     when ss.meta_value ='SA' then 'Sulawesi Utara'
                     when ss.meta_value ='SM' then 'Sumatera'
                     when ss.meta_value ='SB' then 'Sumatera Barat'
                     when ss.meta_value ='SS' then 'Sumatera Selatan'
                     when ss.meta_value ='SU' then 'Sumatera Utara'
                     when ss.meta_value ='YO' then 'Yogyakarta'
                  end shipping_state,                   
                  spc.meta_value shipping_postcode,
                  scy.meta_value shipping_country,
                  c_order.post_id nomor_order,
                  tqp.post_date,
                  -- substring(tqp.post_status,4) post_status,
                  -- cat.term_id cat_id, 
                  -- tqwm.meta_value item_id,
                  item.meta_value,
                  tqw.order_item_name,
                  cat.name cat_name             
               from tq_users tu
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_first_name') sfn on sfn.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_last_name') sln on sln.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'billing_phone') bp on bp.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_address_1') sa1 on sa1.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_address_2') sa2 on sa2.user_id = tu.id
                  left join (select  distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_city') sc on sc.user_id = tu.id
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_state') ss on ss.user_id = tu.id
                  left join (select distinct  tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_postcode') spc on spc.user_id = tu.id
                  left join (select distinct tqu.user_id, tqu.meta_value
                     from tq_usermeta tqu
                     where tqu.meta_key = 'shipping_country') scy on scy.user_id = tu.id
                  left join (select distinct tqp.post_id, tqp.meta_value
                     from tq_postmeta tqp
                     where tqp.meta_key = '_customer_user'
                     and tqp.meta_value is not null) c_order on c_order.meta_value = tu.id,
                        tq_woocommerce_order_items tqw,
                        tq_woocommerce_order_itemmeta tqwm
                  left join (select distinct tqp.post_id, tqp.meta_value
                     from tq_postmeta tqp
                     where tqp.meta_key = '_sku'
                     and tqp.meta_value is not null) item on item.post_id = tqwm.meta_value,
                        tq_term_relationships ttr
                  left join (select ttt.parent, ttt.term_id,  tqt.name
                     from tq_term_taxonomy ttt, tq_terms tqt
                     where ttt.parent != 0 
                     and ttt.term_id not in 
                        (select ttt1.parent
                        from tq_term_taxonomy ttt1
                        where ttt1.taxonomy = 'product_cat')
                     and ttt.taxonomy = 'product_cat'
                     and tqt.term_id = ttt.term_id) cat on cat.term_id = ttr.term_taxonomy_id,
                     tq_posts tqp
               where c_order.post_id = tqw.order_id
               and tqw.order_id = tqp.id
               and tqw.order_item_id = tqwm.order_item_id
               and tqwm.meta_value = ttr.object_id
               and cat.term_id is not null
               and tqwm.meta_key = '_product_id'
               and tqw.order_item_type  = 'line_item'
               and tqp.post_status != 'wc-cancelled'
               AND tu.display_name = '$Name' 
               and tqw.order_item_name like '$Item_Name'
   ";
      $query = $tokoquick->query($sql1);
      // echo $sql1;
      // exit();
      return $query->result_array();

      return $sql1;
   }

   public function exportAllDate($newDateFrom, $newDateTo)
   {
      $tokoquick = $this->load->database('tokoquick', true);
      $sql1 = "SELECT DISTINCT
                  tqp.post_id order_id, 
                  toi.order_item_id,
                  tp.post_date tgl_pesanan,
                  SUBSTRING(tp.post_status,4) post_status,
                  tqp.meta_value customer_id,
                  cust.display_name, 
                  cust.user_email, 
                  CASE 
                     WHEN cust.jml_order = 1
                        THEN 'New Customer'
                     WHEN cust.jml_order > 1
                        THEN 'Repeate Order'
                     else 'No Order'
                  END customer_category,
                  cust.user_registered,
                  --  cust.shipping_first_name,
                  --    cust.shipping_last_name,
                  cust.phone_number,
                  cust.shipping_addreas_1,
                  cust.shipping_addreas_2,
                  cust.shipping_city,
                  cust.shipping_state,
                  cust.shipping_postcode,
                  cust.shipping_country,
                  produk.sku, 
                  produk.item, 
                  produk.cat_name, 
                  produk.harsat, 
                  produk.qty,
                  produk.berat, 
                  produk.ekspedisi, 
                  produk.biaya_kirim, 
                  produk.metode_bayar
               FROM 
                  tq_posts tp,
                  (SELECT tps.post_id, tps.meta_value
                     FROM tq_postmeta tps
                     WHERE tps.meta_key = '_customer_user') tqp,
                        tq_woocommerce_order_items toi,
                        tq_woocommerce_order_itemmeta toim,
                  (select distinct 
                     tqp.post_id, 
                     tp.post_date tgl_pesanan,
                     -- tp.post_status,
                     substring(tp.post_status,4) post_status,
                     tqp.meta_value customer_id,
                     tu.display_name, 
                     tu.user_email, 
                     tu.user_registered,
                     --  sfn.meta_value shipping_first_name,
                     --    sln.meta_value shipping_last_name,
                     bp.meta_value phone_number,
                     sa1.meta_value shipping_addreas_1,
                     sa2.meta_value shipping_addreas_2,
                     sc.meta_value shipping_city,
                     transaksi.jml_order,
                  case 
                     when ss.meta_value ='AC' then 'Aceh'
                     when ss.meta_value ='BA' then 'Bali'
                     when ss.meta_value ='BT' then 'Banten'
                     when ss.meta_value ='BE' then 'Bengkulu'
                     when ss.meta_value ='GO' then 'Gorontalo'
                     when ss.meta_value ='JK' then 'Jakarta'
                     when ss.meta_value ='JA' then 'Jambi'
                     when ss.meta_value ='JW' then 'Jawa'
                     when ss.meta_value ='JB' then 'Jawa Barat'
                     when ss.meta_value ='JT' then 'Jawa Tengah'
                     when ss.meta_value ='JI' then 'Jawa Timur'
                     when ss.meta_value ='KA' then 'Kalimantan'
                     when ss.meta_value ='KB' then 'Kalimantan Barat'
                     when ss.meta_value ='KS' then 'Kalimantan Selatan'
                     when ss.meta_value ='KT' then 'Kalimantan Tengah'
                     when ss.meta_value ='KI' then 'Kalimantan Timur'
                     when ss.meta_value ='KU' then 'Kalimantan Utara'
                     when ss.meta_value ='BB' then 'Kepulauan Bangka Belitung'
                     when ss.meta_value ='KR' then 'Kepulauan Riau'
                     when ss.meta_value ='LA' then 'Lampung'
                     when ss.meta_value ='ML' then 'Maluku'
                     when ss.meta_value ='MA' then 'Maluku'
                     when ss.meta_value ='MU' then 'Maluku Utara'
                     when ss.meta_value ='NU' then 'Nusa Tenggara'
                     when ss.meta_value ='NB' then 'Nusa Tenggara Barat'
                     when ss.meta_value ='NT' then 'Nusa Tenggara Timur'
                     when ss.meta_value ='PP' then 'Papua'
                     when ss.meta_value ='PA' then 'Papua'
                     when ss.meta_value ='PB' then 'Papua Barat'
                     when ss.meta_value ='RI' then 'Riau'
                     when ss.meta_value ='SL' then 'Sulawesi'
                     when ss.meta_value ='SR' then 'Sulawesi Barat'
                     when ss.meta_value ='SN' then 'Sulawesi Selatan'
                     when ss.meta_value ='ST' then 'Sulawesi Tengah'
                     when ss.meta_value ='SG' then 'Sulawesi Tenggara'
                     when ss.meta_value ='SA' then 'Sulawesi Utara'
                     when ss.meta_value ='SM' then 'Sumatera'
                     when ss.meta_value ='SB' then 'Sumatera Barat'
                     when ss.meta_value ='SS' then 'Sumatera Selatan'
                     when ss.meta_value ='SU' then 'Sumatera Utara'
                     when ss.meta_value ='YO' then 'Yogyakarta'
                  end shipping_state,
                  spc.meta_value shipping_postcode,
                  scy.name shipping_country
                  FROM 
                     (select tps.post_id, tps.meta_value
                     from tq_postmeta tps
                     WHERE tps.meta_key = '_customer_user') tqp,
                     tq_posts tp,
                     tq_users tu
                  -- left join (select distinct  tqu.user_id, tqu.meta_value
                  --       	from tq_usermeta tqu
                  --       	where tqu.meta_key = 'shipping_first_name') sfn on sfn.user_id = tu.id
                  --    	left join (select distinct tqu.user_id, tqu.meta_value
                  --       	from tq_usermeta tqu
                  --       	where tqu.meta_key = 'shipping_last_name') sln on sln.user_id = tu.id
                     left join (select distinct tqu.user_id, tqu.meta_value
                        from tq_usermeta tqu
                        where tqu.meta_key = 'billing_phone') bp on bp.user_id = tu.id
                     left join (select distinct tqu.user_id, tqu.meta_value
                        from tq_usermeta tqu
                        where tqu.meta_key = 'shipping_address_1') sa1 on sa1.user_id = tu.id
                     left join (select distinct tqu.user_id, tqu.meta_value
                        from tq_usermeta tqu
                        where tqu.meta_key = 'shipping_address_2') sa2 on sa2.user_id = tu.id
                     left join (select  distinct tqu.user_id, tqu.meta_value
                        from tq_usermeta tqu
                        where tqu.meta_key = 'shipping_city') sc on sc.user_id = tu.id
                     left join (select distinct  tqu.user_id, tqu.meta_value
                        from tq_usermeta tqu
                        where tqu.meta_key = 'shipping_state') ss on ss.user_id = tu.id
                     left join (select distinct  tqu.user_id, tqu.meta_value
                        from tq_usermeta tqu
                        where tqu.meta_key = 'shipping_postcode') spc on spc.user_id = tu.id
                     left join (select distinct tqu.user_id, tqu.meta_value, tpc.name
                        from tq_usermeta tqu, tq_pps_countries tpc
                        where tqu.meta_value = tpc.iso_code_2
                        and tqu.meta_key = 'shipping_country') scy on scy.user_id = tu.id
                     LEFT JOIN (select distinct tqp.meta_value cust_id,
                        tu.display_name,
                        count(tqp.post_id) jml_order 
                        FROM 
                        (select tps.post_id, tps.meta_value
                           from tq_postmeta tps
                           WHERE tps.meta_key = '_customer_user') tqp,
                              tq_posts tp,
                              tq_users tu
                        where 
                        tqp.post_id = tp.id
                        and tqp.meta_value = tu.id
                        and tp.post_status = 'wc-completed'
                        GROUP BY tqp.meta_value) transaksi ON transaksi.cust_id = tu.id
                  where 
                     tqp.post_id = tp.id
                  and tqp.meta_value = tu.id) cust,
                     (select distinct tqwp.order_id, 
                        tqwp.order_item_id, 
                        tqwmp.sku, 
                        tqwp.item, 
                        cat.name cat_name, 
                        hgqt.harsat, 
                        hgqt.qty,
                        tqwmp.berat,
                        tqwp.ekspedisi, 
                        shiping.biaya_kirim, 
                        payment.metode_bayar
                     from
                        (select distinct line.order_id, line.order_item_id, line.item, kirim.ekspedisi
                           from -- tq_woocommerce_order_items tqw,
                              (select tqw.order_id, tqw.order_item_id, tqw.order_item_name item
                                 from tq_woocommerce_order_items tqw
                                 where tqw.order_item_type  = 'line_item') line, 
                              (select tqw.order_id, tqw.order_item_id, tqw.order_item_name ekspedisi
                                 from tq_woocommerce_order_items tqw
                                 where tqw.order_item_type = 'shipping') kirim
                           where
                              line.order_id = kirim.order_id) tqwp,
                              (select tqwm.order_item_id, item.meta_value sku, weight.meta_value berat
                           from tq_woocommerce_order_itemmeta tqwm,
                              (select distinct tqp.post_id, tqp.meta_value
                                 from tq_postmeta tqp
                                 where tqp.meta_key = '_sku'
                                 and tqp.meta_value is not null) item,
                              (select distinct tqp.post_id, tqp.meta_value
                                 from tq_postmeta tqp
                                 where tqp.meta_key = '_weight'
                                 and tqp.meta_value is not null) weight  
                                 where item.post_id = tqwm.meta_value
                                 and weight.post_id = tqwm.meta_value
                                 and tqwm.meta_key = '_product_id') tqwmp,
                              (select distinct tqp.post_id, tqp.meta_value biaya_kirim
                                 from tq_postmeta tqp
                                 where tqp.meta_key = '_order_shipping'
                                 and tqp.meta_value is not null) shiping,      
                              (select distinct tqp.post_id, tqp.meta_value metode_bayar
                                 from tq_postmeta tqp
                                 where tqp.meta_key = '_payment_method_title'
                                 and tqp.meta_value is not null) payment,
                              (select product_id.order_item_id, 
                                 product_id.meta_value item_id, 
                                 qty.meta_value qty, 
                                 line_total.meta_value/qty.meta_value harsat
                                 from (select tqwm.*
                                    from tq_woocommerce_order_itemmeta tqwm
                                    where tqwm.meta_key = '_product_id') product_id,
                                 (select tqwm.*
                                    from  tq_woocommerce_order_itemmeta tqwm
                                    where tqwm.meta_key = '_qty') qty,
                                 (select tqwm.*
                                    from  tq_woocommerce_order_itemmeta tqwm
                                    where tqwm.meta_key = '_line_total') line_total
                                    where product_id.order_item_id = qty.order_item_id
                                    and qty.order_item_id = line_total.order_item_id) hgqt,
                              (select *
                                 from tq_woocommerce_order_itemmeta
                                 where meta_key = '_product_id') tqwm,
                                 tq_term_relationships ttr
                                 left join (select ttt.parent, ttt.term_id,  tqt.name
                                    from tq_term_taxonomy ttt, tq_terms tqt
                                    where  
                                       ttt.parent != 0 
                                    and ttt.term_id not in 
                                       (select ttt1.parent
                                          from tq_term_taxonomy ttt1
                                          where ttt1.taxonomy = 'product_cat')
                                    and ttt.taxonomy = 'product_cat'
                                    and tqt.term_id = ttt.term_id) cat on cat.term_id = ttr.term_taxonomy_id
                     where tqwmp.order_item_id = tqwp.order_item_id
                     and payment.post_id = tqwp.order_id
                     and shiping.post_id = tqwp.order_id
                     and hgqt.order_item_id = tqwp.order_item_id
                     and tqwp.order_item_id = tqwm.order_item_id
                     and tqwm.meta_value = ttr.object_id
                     and cat.term_id is not NULL) produk			
               WHERE 
               tqp.post_id = tp.id
               AND tqp.post_id = toi.order_id
               AND toi.order_item_id = toim.order_item_id
               AND toim.order_item_id = produk.order_item_id
               AND tqp.meta_value = cust.customer_id
               AND toim.meta_key = '_product_id'
               AND DATE(tp.post_date) BETWEEN '$newDateFrom' AND '$newDateTo'
               ORDER BY	tp.post_date
               -- AND tqp.post_id = 36846
   ";
      $query = $tokoquick->query($sql1);
      // echo $sql1;
      // exit();
      return $query->result_array();

      return $sql1;
   }

   public function exportAll()
   {
      $tokoquick = $this->load->database('tokoquick', true);
      $sql1 = "SELECT DISTINCT
                  tqp.post_id order_id, 
                  toi.order_item_id,
                  tp.post_date tgl_pesanan,
                  SUBSTRING(tp.post_status,4) post_status,
                  tqp.meta_value customer_id,
                  cust.display_name, 
                  cust.user_email, 
                  CASE 
                     WHEN cust.jml_order = 1
                        THEN 'New Customer'
                     WHEN cust.jml_order > 1
                        THEN 'Repeate Order'
                     else 'No Order'
                  END customer_category,
                  cust.user_registered,
                  --  cust.shipping_first_name,
                  --    cust.shipping_last_name,
                  cust.phone_number,
                  cust.shipping_addreas_1,
                  cust.shipping_addreas_2,
                  cust.shipping_city,
                  cust.shipping_state,
                  cust.shipping_postcode,
                  cust.shipping_country,
                  produk.sku, 
                  produk.item, 
                  produk.cat_name, 
                  produk.harsat, 
                  produk.qty,
                  produk.berat, 
                  produk.ekspedisi, 
                  produk.biaya_kirim, 
                  produk.metode_bayar
               FROM 
                  tq_posts tp,
                  (SELECT tps.post_id, tps.meta_value
                     FROM tq_postmeta tps
                     WHERE tps.meta_key = '_customer_user') tqp,
                        tq_woocommerce_order_items toi,
                        tq_woocommerce_order_itemmeta toim,
                  (select distinct 
                     tqp.post_id, 
                     tp.post_date tgl_pesanan,
                     -- tp.post_status,
                     substring(tp.post_status,4) post_status,
                     tqp.meta_value customer_id,
                     tu.display_name, 
                     tu.user_email, 
                     tu.user_registered,
                     --  sfn.meta_value shipping_first_name,
                     --    sln.meta_value shipping_last_name,
                     bp.meta_value phone_number,
                     sa1.meta_value shipping_addreas_1,
                     sa2.meta_value shipping_addreas_2,
                     sc.meta_value shipping_city,
                     transaksi.jml_order,
                  case 
                     when ss.meta_value ='AC' then 'Aceh'
                     when ss.meta_value ='BA' then 'Bali'
                     when ss.meta_value ='BT' then 'Banten'
                     when ss.meta_value ='BE' then 'Bengkulu'
                     when ss.meta_value ='GO' then 'Gorontalo'
                     when ss.meta_value ='JK' then 'Jakarta'
                     when ss.meta_value ='JA' then 'Jambi'
                     when ss.meta_value ='JW' then 'Jawa'
                     when ss.meta_value ='JB' then 'Jawa Barat'
                     when ss.meta_value ='JT' then 'Jawa Tengah'
                     when ss.meta_value ='JI' then 'Jawa Timur'
                     when ss.meta_value ='KA' then 'Kalimantan'
                     when ss.meta_value ='KB' then 'Kalimantan Barat'
                     when ss.meta_value ='KS' then 'Kalimantan Selatan'
                     when ss.meta_value ='KT' then 'Kalimantan Tengah'
                     when ss.meta_value ='KI' then 'Kalimantan Timur'
                     when ss.meta_value ='KU' then 'Kalimantan Utara'
                     when ss.meta_value ='BB' then 'Kepulauan Bangka Belitung'
                     when ss.meta_value ='KR' then 'Kepulauan Riau'
                     when ss.meta_value ='LA' then 'Lampung'
                     when ss.meta_value ='ML' then 'Maluku'
                     when ss.meta_value ='MA' then 'Maluku'
                     when ss.meta_value ='MU' then 'Maluku Utara'
                     when ss.meta_value ='NU' then 'Nusa Tenggara'
                     when ss.meta_value ='NB' then 'Nusa Tenggara Barat'
                     when ss.meta_value ='NT' then 'Nusa Tenggara Timur'
                     when ss.meta_value ='PP' then 'Papua'
                     when ss.meta_value ='PA' then 'Papua'
                     when ss.meta_value ='PB' then 'Papua Barat'
                     when ss.meta_value ='RI' then 'Riau'
                     when ss.meta_value ='SL' then 'Sulawesi'
                     when ss.meta_value ='SR' then 'Sulawesi Barat'
                     when ss.meta_value ='SN' then 'Sulawesi Selatan'
                     when ss.meta_value ='ST' then 'Sulawesi Tengah'
                     when ss.meta_value ='SG' then 'Sulawesi Tenggara'
                     when ss.meta_value ='SA' then 'Sulawesi Utara'
                     when ss.meta_value ='SM' then 'Sumatera'
                     when ss.meta_value ='SB' then 'Sumatera Barat'
                     when ss.meta_value ='SS' then 'Sumatera Selatan'
                     when ss.meta_value ='SU' then 'Sumatera Utara'
                     when ss.meta_value ='YO' then 'Yogyakarta'
                  end shipping_state,
                  spc.meta_value shipping_postcode,
                  scy.name shipping_country
                  FROM 
                     (select tps.post_id, tps.meta_value
                     from tq_postmeta tps
                     WHERE tps.meta_key = '_customer_user') tqp,
                     tq_posts tp,
                     tq_users tu
                  -- left join (select distinct  tqu.user_id, tqu.meta_value
                  --       	from tq_usermeta tqu
                  --       	where tqu.meta_key = 'shipping_first_name') sfn on sfn.user_id = tu.id
                  --    	left join (select distinct tqu.user_id, tqu.meta_value
                  --       	from tq_usermeta tqu
                  --       	where tqu.meta_key = 'shipping_last_name') sln on sln.user_id = tu.id
                     left join (select distinct tqu.user_id, tqu.meta_value
                        from tq_usermeta tqu
                        where tqu.meta_key = 'billing_phone') bp on bp.user_id = tu.id
                     left join (select distinct tqu.user_id, tqu.meta_value
                        from tq_usermeta tqu
                        where tqu.meta_key = 'shipping_address_1') sa1 on sa1.user_id = tu.id
                     left join (select distinct tqu.user_id, tqu.meta_value
                        from tq_usermeta tqu
                        where tqu.meta_key = 'shipping_address_2') sa2 on sa2.user_id = tu.id
                     left join (select  distinct tqu.user_id, tqu.meta_value
                        from tq_usermeta tqu
                        where tqu.meta_key = 'shipping_city') sc on sc.user_id = tu.id
                     left join (select distinct  tqu.user_id, tqu.meta_value
                        from tq_usermeta tqu
                        where tqu.meta_key = 'shipping_state') ss on ss.user_id = tu.id
                     left join (select distinct  tqu.user_id, tqu.meta_value
                        from tq_usermeta tqu
                        where tqu.meta_key = 'shipping_postcode') spc on spc.user_id = tu.id
                     left join (select distinct tqu.user_id, tqu.meta_value, tpc.name
                        from tq_usermeta tqu, tq_pps_countries tpc
                        where tqu.meta_value = tpc.iso_code_2
                        and tqu.meta_key = 'shipping_country') scy on scy.user_id = tu.id
                     LEFT JOIN (select distinct tqp.meta_value cust_id,
                        tu.display_name,
                        count(tqp.post_id) jml_order 
                        FROM 
                        (select tps.post_id, tps.meta_value
                           from tq_postmeta tps
                           WHERE tps.meta_key = '_customer_user') tqp,
                              tq_posts tp,
                              tq_users tu
                        where 
                        tqp.post_id = tp.id
                        and tqp.meta_value = tu.id
                        and tp.post_status = 'wc-completed'
                        GROUP BY tqp.meta_value) transaksi ON transaksi.cust_id = tu.id
                  where 
                     tqp.post_id = tp.id
                  and tqp.meta_value = tu.id) cust,
                     (select distinct tqwp.order_id, 
                        tqwp.order_item_id, 
                        tqwmp.sku, 
                        tqwp.item, 
                        cat.name cat_name, 
                        hgqt.harsat, 
                        hgqt.qty,
                        tqwmp.berat,
                        tqwp.ekspedisi, 
                        shiping.biaya_kirim, 
                        payment.metode_bayar
                     from
                        (select distinct line.order_id, line.order_item_id, line.item, kirim.ekspedisi
                           from -- tq_woocommerce_order_items tqw,
                              (select tqw.order_id, tqw.order_item_id, tqw.order_item_name item
                                 from tq_woocommerce_order_items tqw
                                 where tqw.order_item_type  = 'line_item') line, 
                              (select tqw.order_id, tqw.order_item_id, tqw.order_item_name ekspedisi
                                 from tq_woocommerce_order_items tqw
                                 where tqw.order_item_type = 'shipping') kirim
                           where
                              line.order_id = kirim.order_id) tqwp,
                              (select tqwm.order_item_id, item.meta_value sku, weight.meta_value berat
                           from tq_woocommerce_order_itemmeta tqwm,
                              (select distinct tqp.post_id, tqp.meta_value
                                 from tq_postmeta tqp
                                 where tqp.meta_key = '_sku'
                                 and tqp.meta_value is not null) item,
                              (select distinct tqp.post_id, tqp.meta_value
                                 from tq_postmeta tqp
                                 where tqp.meta_key = '_weight'
                                 and tqp.meta_value is not null) weight  
                                 where item.post_id = tqwm.meta_value
                                 and weight.post_id = tqwm.meta_value
                                 and tqwm.meta_key = '_product_id') tqwmp,
                              (select distinct tqp.post_id, tqp.meta_value biaya_kirim
                                 from tq_postmeta tqp
                                 where tqp.meta_key = '_order_shipping'
                                 and tqp.meta_value is not null) shiping,      
                              (select distinct tqp.post_id, tqp.meta_value metode_bayar
                                 from tq_postmeta tqp
                                 where tqp.meta_key = '_payment_method_title'
                                 and tqp.meta_value is not null) payment,
                              (select product_id.order_item_id, 
                                 product_id.meta_value item_id, 
                                 qty.meta_value qty, 
                                 line_total.meta_value/qty.meta_value harsat
                                 from (select tqwm.*
                                    from tq_woocommerce_order_itemmeta tqwm
                                    where tqwm.meta_key = '_product_id') product_id,
                                 (select tqwm.*
                                    from  tq_woocommerce_order_itemmeta tqwm
                                    where tqwm.meta_key = '_qty') qty,
                                 (select tqwm.*
                                    from  tq_woocommerce_order_itemmeta tqwm
                                    where tqwm.meta_key = '_line_total') line_total
                                    where product_id.order_item_id = qty.order_item_id
                                    and qty.order_item_id = line_total.order_item_id) hgqt,
                              (select *
                                 from tq_woocommerce_order_itemmeta
                                 where meta_key = '_product_id') tqwm,
                                 tq_term_relationships ttr
                                 left join (select ttt.parent, ttt.term_id,  tqt.name
                                    from tq_term_taxonomy ttt, tq_terms tqt
                                    where  
                                       ttt.parent != 0 
                                    and ttt.term_id not in 
                                       (select ttt1.parent
                                          from tq_term_taxonomy ttt1
                                          where ttt1.taxonomy = 'product_cat')
                                    and ttt.taxonomy = 'product_cat'
                                    and tqt.term_id = ttt.term_id) cat on cat.term_id = ttr.term_taxonomy_id
                     where tqwmp.order_item_id = tqwp.order_item_id
                     and payment.post_id = tqwp.order_id
                     and shiping.post_id = tqwp.order_id
                     and hgqt.order_item_id = tqwp.order_item_id
                     and tqwp.order_item_id = tqwm.order_item_id
                     and tqwm.meta_value = ttr.object_id
                     and cat.term_id is not NULL) produk			
               WHERE 
               tqp.post_id = tp.id
               AND tqp.post_id = toi.order_id
               AND toi.order_item_id = toim.order_item_id
               AND toim.order_item_id = produk.order_item_id
               AND tqp.meta_value = cust.customer_id
               AND toim.meta_key = '_product_id'
               ORDER BY	tp.post_date
   ";
      $query = $tokoquick->query($sql1);
      // echo $sql1;
      // exit();
      return $query->result_array();

      return $sql1;
   }
}