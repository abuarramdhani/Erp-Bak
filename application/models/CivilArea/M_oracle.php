<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_oracle extends CI_Model
{
  public function __construct()
  {
    $this->oracle = $this->load->database('oracle', true);
  }

  /**
   * Get Const Center (Area Seksi)
   * 
   * @param void
   * @return Array<Object> Cost center
   */
  public function getCostCenter()
  {
    $sql = "SELECT
        ffv.FLEX_VALUE as COST_CENTER,
        ffvt.DESCRIPTION as SECTION,
        kbbc.LOCATION,
        kbbc.BRANCH,
        kbbc.COST_CENTER_TYPE
    FROM fnd_flex_values ffv,
        fnd_flex_values_TL ffvt,
        khs_bppbg_branch_cc kbbc
    WHERE 
        ffv.FLEX_VALUE_SET_ID=1013709
        and ffv.ATTRIBUTE10 != ' '
        and ffv.ATTRIBUTE10 = 'Seksi'
        and ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
        and ffv.END_DATE_ACTIVE IS NULL
        and ffv.flex_value NOT LIKE '0000'
        and ffv.ENABLED_FLAG = 'Y'
        and ffv.SUMMARY_FLAG = 'N'
        and (
        (
            ffv.FLEX_VALUE = kbbc.COST_CENTER
            and kbbc.LOCATION IN ('PUSAT', 'TUKSONO')
        ) or (
            -- COST CENTER KHUSUS YANG INGIN DITAMPILKAN
            -- PENAMPUNGAN MARKETING CABANG (Branch Yogyakarta)
            ffv.FLEX_VALUE = '3J99' and kbbc.LOCATION = 'YOGYAKARTA'
        )
        )
    order by ffv.FLEX_VALUE
    ";

    $query = $this->oracle->query($sql);
    return $query->result_object();
  }
}
