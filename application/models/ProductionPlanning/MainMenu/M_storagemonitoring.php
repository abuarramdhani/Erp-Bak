<?php
class M_storagemonitoring extends CI_Model {

  public function __construct()
  {
    $this->load->database();
    $this->oracle = $this->load->database ('oracle', TRUE);
  }

  public function getStoragePP($id=FALSE)
  {
    if($id==FALSE){
      $this->db->select('*');
      $this->db->from('pp.pp_storage');
      $this->db->order_by('storage_name');
      $query = $this->db->get();
    }else{
      $query = $this->db->get_where('pp.pp_storage', array('storage_name' => $id));
    }
    
    return $query->result_array();
  }

  public function getPlanStorage($storage_name)
  {
    $sql = "SELECT pdp.*,
              (case when pdp.achieve_qty>=pdp.need_qty then 'OK' else 'NOT OK' end) status
            from pp.pp_daily_plans pdp,
              (select psg.storage_name, pid.*
              from
                pp.pp_storage psg left join pp.pp_item_data pid on psg.storage_id = pid.storage_id
              where storage_name = '$storage_name') a
            where
              pdp.item_code = a.item_code
              and (case when pdp.achieve_qty is null then 0 else pdp.achieve_qty end) < pdp.need_qty
              AND pdp.due_time <=
                (
                  case when to_char(current_timestamp, 'HH24:MI:SS') >= to_char(to_timestamp('05:59:59', 'HH24:MI:SS'), 'HH24:MI:SS')
                    then to_timestamp((to_char(TIMESTAMP 'tomorrow', 'DD-MM-YYYY') || ' 05:59:59'), 'DD-MM-YYYY HH24:MI:SS')
                    else to_timestamp((to_char(TIMESTAMP 'today', 'DD-MM-YYYY') || ' 05:59:59'), 'DD-MM-YYYY HH24:MI:SS')
                  end
                )
            order by pdp.priority, pdp.due_time asc";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getDailyAchieve($storage_name)
  {
    $sql = "select
              (case when a.to_inventory = null then a.completion else a.to_inventory end) gudang,
              coalesce(round(
                cast((
                  sum(pdp.achieve_qty)
                ) as decimal) / cast((
                  sum(pdp.need_qty)
                ) as decimal) * 100
              ,2),0) || ' %' percentage
            from
              pp.pp_daily_plans pdp,
              (
                select psg.storage_name, pid.*
                from
                  pp.pp_storage psg left join pp.pp_item_data pid on psg.storage_id = pid.storage_id
                  where storage_name = '$storage_name') a
            where
              pdp.item_code = a.item_code
              AND pdp.due_time between
                (
                  case when to_char(current_timestamp, 'HH24:MI:SS') >= to_char(to_timestamp('05:59:59', 'HH24:MI:SS'), 'HH24:MI:SS')
                    then to_timestamp((to_char(TIMESTAMP 'today', 'DD-MM-YYYY') || ' 05:59:59'), 'DD-MM-YYYY HH24:MI:SS')
                    else to_timestamp((to_char(TIMESTAMP 'tomorrow', 'DD-MM-YYYY') || ' 05:59:59'), 'DD-MM-YYYY HH24:MI:SS')
                  end
                )
                and
                (
                  case when to_char(current_timestamp, 'HH24:MI:SS') >= to_char(to_timestamp('05:59:59', 'HH24:MI:SS'), 'HH24:MI:SS')
                    then to_timestamp((to_char(TIMESTAMP 'tomorrow', 'DD-MM-YYYY') || ' 05:59:59'), 'DD-MM-YYYY HH24:MI:SS')
                    else to_timestamp((to_char(TIMESTAMP 'today', 'DD-MM-YYYY') || ' 05:59:59'), 'DD-MM-YYYY HH24:MI:SS')
                  end
                )
            group by 1";
    $query = $this->db->query($sql);
    return $query->result_array();
  }
}