<?php
class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle_dev', true);
    }

    public function getItem($value)
    {
      return $this->oracle->query("SELECT msib.segment1, msib.description, msib.primary_uom_code,
                                   msib.postprocessing_lead_time
                                 + msib.preprocessing_lead_time
                                 + msib.full_lead_time leadtime,
                                 NVL (msib.minimum_order_quantity, 0) moq,
                                 NVL (msib.min_minmax_quantity, 0) min_stock,
                                 NVL (msib.max_minmax_quantity, 0) max_stock
                            FROM mtl_system_items_b msib
                            WHERE msib.organization_id = 81 AND (msib.segment1 like '%$value%'or msib.description like '%$value%')")->result_array();
    }

    public function savekebutuhan($post)
    {
      $no_indk = $this->session->user;
      foreach ($post['item_code'] as $key => $value) {
        $this->oracle->query("INSERT INTO KHS_CONSUMABLEV2_SEKSI
                              (item_code, description, quantity, creation_date, created_by)
                              VALUES ('{$post['item_code'][$key]}',
                                      '{$post['description'][$key]}',
                                      '{$post['qty_kebutuhan'][$key]}',
                                      SYSDATE,
                                      '$no_indk'
                                    )");
      }
      if ($this->oracle->affected_rows()) {
        return 'done';
      }else {
        return 0;
      }
    }

    public function getkebutuhan($value='')
    {
      return $this->oracle->get('KHS_CONSUMABLEV2_SEKSI')->result_array();
    }


}
