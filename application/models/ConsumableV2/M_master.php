<?php
class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle_dev', true);
        $this->personalia = $this->load->database('personalia', true);
    }

    public function getItem($value)
    {
      return $this->oracle->query("SELECT msib.inventory_item_id, msib.segment1, msib.description, msib.primary_uom_code,
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
      $noind = $this->session->user;
      $kodesie = $this->personalia->query("SELECT substring(kodesie, 1, 7) kodesie from hrd_khs.tpribadi where noind = '$noind'")->row_array();
      $kodesie = $kodesie['kodesie'];
      foreach ($post['item_id'] as $key => $value) {
        $this->oracle->query("INSERT INTO KHS_CSM_KEBUTUHAN
                              (KODESIE, ITEM_ID, REQ_QUANTITY, CREATION_DATE, CREATED_BY)
                              VALUES ('$kodesie',
                                      '$value',
                                      '{$post['qty_kebutuhan'][$key]}',
                                      SYSDATE,
                                      '$noind'
                                    )");
      }
      if ($this->oracle->affected_rows()) {
        return 'done';
      }else {
        return 0;
      }
    }

    public function delkebutuhan($id)
    {
      $this->oracle->query("DELETE FROM KHS_CSM_KEBUTUHAN WHERE item_id = $id");
      if ($this->oracle->affected_rows()) {
        $c = 'done';
      }else {
        $c= 500;
      }
      return $c;
    }

    // public function employee($data)
  	// {
  	// 		$sql = "SELECT
  	// 						employee_code,
  	// 						employee_name
  	// 					from
  	// 						er.er_employee_all
  	// 					where
  	// 						resign = '0'
  	// 						and (employee_code like '%$data%'
  	// 						or employee_name like '%$data%')
  	// 					order by
  	// 						1";
  	// 		$response = $this->db->query($sql)->result_array();
  	// 		return $response;
  	// }

  	public function selectKebutuhan($data)
  	{
  		$val = strtoupper($data['search']['value']);
  			$res = $this->oracle
  					->query(
  							"SELECT kdav.*
  							FROM
  									(
  									SELECT
  													skdav.*,
  													ROW_NUMBER () OVER (ORDER BY tgl_buat DESC) as pagination
  											FROM
  													(
                              SELECT kck.*, TO_CHAR(kck.creation_date, 'DD/MM/YYYY HH:MI:SS') tgl_buat, msib.segment1, msib.description, msib.primary_uom_code
                              FROM KHS_CSM_KEBUTUHAN kck, mtl_system_items_b msib
                              WHERE kck.item_id = msib.inventory_item_id
                              AND msib.organization_id = 81
                              AND (
                                msib.segment1 LIKE '%$val%'
                                OR msib.description LIKE '%$val%'
                                OR kck.creation_date LIKE '%$val%'
                                OR kck.created_by LIKE '%$val%'
                              )
  													) skdav
  									) kdav
  							WHERE
  									pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
  					)->result_array();

  			return $res;
  	}

  	public function countAllKebutuhan()
  	{
  		return $this->oracle->query(
  			"SELECT
  					COUNT(*) AS \"count\"
  			FROM
  			(SELECT kck.*, msib.segment1, msib.description
        FROM KHS_CSM_KEBUTUHAN kck, mtl_system_items_b msib
        WHERE kck.item_id = msib.inventory_item_id
        AND msib.organization_id = 81) bla"
  			)->row_array();
  	}

  	public function countFilteredKebutuhan($data)
  	{
  		$val = strtoupper($data['search']['value']);
  		return $this->oracle->query(
  			"SELECT
  						COUNT(*) AS \"count\"
  					FROM
            (
              SELECT kck.*, msib.segment1, msib.description
              FROM KHS_CSM_KEBUTUHAN kck, mtl_system_items_b msib
              WHERE kck.item_id = msib.inventory_item_id
              AND msib.organization_id = 81
              AND (
                msib.segment1 LIKE '%$val%'
                OR msib.description LIKE '%$val%'
                OR kck.creation_date LIKE '%$val%'
                OR kck.created_by LIKE '%$val%'
              )
          ) bla"
  			)->row_array();
  	}


}
