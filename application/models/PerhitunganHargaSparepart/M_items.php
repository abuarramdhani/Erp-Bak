<?php
defined('BASEPATH') or die('No direct script access allowed');

class M_items extends CI_Model
{
  private $oracle;

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->oracle = $this->load->database('oracle', true);
  }

  public function getItemsByKeyword($keyword)
  {
    return $this->oracle
      ->query(
        "SELECT
          inventory_item_id AS \"id\",
          segment1 AS \"code\",
          description AS \"description\"
        FROM
          mtl_system_items_b
        WHERE
          segment1 LIKE '%{$keyword}%'
          AND organization_id = 81"
      )
      ->result();
  }
}
