<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_cetak extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library('encrypt');
    $this->load->library('csvimport');
    $this->oracle = $this->load->database('oracle', true);
    $this->oracle_dev = $this->load->database('oracle_dev',TRUE);    
  }

public function getData($term) {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT DISTINCT ffvv.flex_value cost_center,
    NVL (SUBSTR (bor.description,
                 0,
                 INSTR (bor.description, '-') - 1
                ),
         bor.description
        )
 || '- '
 || kdmr.no_mesin seksi_nomesin,
 kdmr.tag_number tag_number, bor.resource_code kode_resource,
 bor.description deskripsi,
 MAX (bor.last_update_date) tanggal_update
FROM bom_resources bor,
 bom_department_resources bdr,
 bom_departments bd,
 khs_daftar_mesin_resource kdmr,
 gl_code_combinations gcc,
 fnd_flex_values_vl ffvv
WHERE gcc.code_combination_id = bor.absorption_account
AND bor.resource_id = bdr.resource_id
AND bdr.department_id = bd.department_id
AND bor.resource_id = kdmr.resource_id
AND ffvv.flex_value_set_id = 1013709
AND ffvv.end_date_active IS NULL
AND bor.disable_date IS NULL
AND SUBSTR (ffvv.flex_value, 0, 1) IN
                               ('4', '5', '7', '8') --fabrikasi
AND ffvv.flex_value = gcc.segment4
AND ffvv.flex_value LIKE '%$term%'
GROUP BY ffvv.flex_value,
    NVL (SUBSTR (bor.description,
                 0,
                 INSTR (bor.description, '-') - 1
                ),
         bor.description
        )
 || '- '
 || kdmr.no_mesin,
 kdmr.tag_number,
 bor.resource_code,
 bor.description
UNION
SELECT   ffvv.flex_value cost_center,
CASE SUBSTR (xc.value_constant, 0, 2)
WHEN 'SM'
   THEN 'SHEET METAL TUKSONO'
WHEN 'PO'
   THEN 'POTONG AS TUKSONO'
ELSE 'FOUNDRY'
END
|| ' - '
|| TRIM (SUBSTR (gmd.machine,
           INSTR (gmd.machine, '-', 1, 1) + 1,
             (  INSTR (gmd.machine, '-', 1, 2)
              - INSTR (gmd.machine, '-', 1, 1)
             )
           - 1
          )
  ) seksi_nomesin,
TRIM (SUBSTR (gmd.machine, 1, INSTR (gmd.machine, '-') - 1)
) tag_number,
gmd.resources kode_resource, gmd.resource_desc deskripsi,
gmd.last_update_date tanggal_update
FROM xla_seg_rules_fvl xsrf,
xla_seg_rule_details xsrd,
xla_conditions xc,
fnd_flex_values_vl ffvv,
(SELECT   gor.resources, MAX (gor.last_update_date) last_update_date,
    goa.activity, gop.effective_end_date end_date,
    res.resource_class, res.resource_desc, res.machine
FROM gmd_operations gop,
    gmd_operation_activities goa,
    gmd_operation_resources gor,
    khs_opm_resource_and_machine res
WHERE gop.oprn_id = goa.oprn_id
AND goa.oprn_line_id = gor.oprn_line_id
AND res.oprn_line_id = gor.oprn_line_id
AND res.resources = gor.resources
AND gor.attribute1 IS NOT NULL
GROUP BY gor.resources,
    goa.activity,
    gop.effective_end_date,
    res.resource_class,
    res.resource_desc,
    res.machine) gmd
WHERE xsrf.segment_rule_code = 'KHS_RCA_CC'
AND xsrf.segment_rule_code = xsrd.segment_rule_code
AND xsrf.application_id = xsrd.application_id
AND xsrd.segment_rule_detail_id = xc.segment_rule_detail_id(+)
AND xsrd.application_id = xc.application_id(+)
AND ffvv.flex_value = xsrd.value_constant
AND ffvv.end_date_active IS NULL
AND gmd.resources(+) = xc.value_constant
AND gmd.resource_class = 'MESIN'
AND gmd.end_date IS NULL
AND ffvv.flex_value LIKE '%$term%'
ORDER BY 1, 3";

    $query = $oracle->query($sql);
    return $query->result_array();
        //  return $sql;
  }

  public function getAtta($cc) {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT DISTINCT ffvv.flex_value cost_center,
    NVL (SUBSTR (bor.description,
                 0,
                 INSTR (bor.description, '-') - 1
                ),
         bor.description
        )
 || '- '
 || kdmr.no_mesin seksi_nomesin,
 kdmr.tag_number tag_number, bor.resource_code kode_resource,
 bor.description deskripsi,
 MAX (bor.last_update_date) tanggal_update
FROM bom_resources bor,
 bom_department_resources bdr,
 bom_departments bd,
 khs_daftar_mesin_resource kdmr,
 gl_code_combinations gcc,
 fnd_flex_values_vl ffvv
WHERE gcc.code_combination_id = bor.absorption_account
AND bor.resource_id = bdr.resource_id
AND bdr.department_id = bd.department_id
AND bor.resource_id = kdmr.resource_id
AND ffvv.flex_value_set_id = 1013709
AND ffvv.end_date_active IS NULL
AND bor.disable_date IS NULL
AND SUBSTR (ffvv.flex_value, 0, 1) IN
                               ('4', '5', '7', '8') --fabrikasi
AND ffvv.flex_value = gcc.segment4
AND ffvv.flex_value LIKE '%$cc%'
GROUP BY ffvv.flex_value,
    NVL (SUBSTR (bor.description,
                 0,
                 INSTR (bor.description, '-') - 1
                ),
         bor.description
        )
 || '- '
 || kdmr.no_mesin,
 kdmr.tag_number,
 bor.resource_code,
 bor.description
UNION
SELECT   ffvv.flex_value cost_center,
CASE SUBSTR (xc.value_constant, 0, 2)
WHEN 'SM'
   THEN 'SHEET METAL TUKSONO'
WHEN 'PO'
   THEN 'POTONG AS TUKSONO'
ELSE 'FOUNDRY'
END
|| ' - '
|| TRIM (SUBSTR (gmd.machine,
           INSTR (gmd.machine, '-', 1, 1) + 1,
             (  INSTR (gmd.machine, '-', 1, 2)
              - INSTR (gmd.machine, '-', 1, 1)
             )
           - 1
          )
  ) seksi_nomesin,
TRIM (SUBSTR (gmd.machine, 1, INSTR (gmd.machine, '-') - 1)
) tag_number,
gmd.resources kode_resource, gmd.resource_desc deskripsi,
gmd.last_update_date tanggal_update
FROM xla_seg_rules_fvl xsrf,
xla_seg_rule_details xsrd,
xla_conditions xc,
fnd_flex_values_vl ffvv,
(SELECT   gor.resources, MAX (gor.last_update_date) last_update_date,
    goa.activity, gop.effective_end_date end_date,
    res.resource_class, res.resource_desc, res.machine
FROM gmd_operations gop,
    gmd_operation_activities goa,
    gmd_operation_resources gor,
    khs_opm_resource_and_machine res
WHERE gop.oprn_id = goa.oprn_id
AND goa.oprn_line_id = gor.oprn_line_id
AND res.oprn_line_id = gor.oprn_line_id
AND res.resources = gor.resources
AND gor.attribute1 IS NOT NULL
GROUP BY gor.resources,
    goa.activity,
    gop.effective_end_date,
    res.resource_class,
    res.resource_desc,
    res.machine) gmd
WHERE xsrf.segment_rule_code = 'KHS_RCA_CC'
AND xsrf.segment_rule_code = xsrd.segment_rule_code
AND xsrf.application_id = xsrd.application_id
AND xsrd.segment_rule_detail_id = xc.segment_rule_detail_id(+)
AND xsrd.application_id = xc.application_id(+)
AND ffvv.flex_value = xsrd.value_constant
AND ffvv.end_date_active IS NULL
AND gmd.resources(+) = xc.value_constant
AND gmd.resource_class = 'MESIN'
AND gmd.end_date IS NULL
AND ffvv.flex_value LIKE '%$cc%'
ORDER BY 1, 3";

    $query = $oracle->query($sql);
    return $query->result_array();
        //  return $sql;
  }


  public function getDataCost($term) {
    $oracle = $this->load->database('oracle', true);
    $sql = "select distinct ffvv.FLEX_VALUE                                                 cost_center
    from bom_resources bor
  ,bom_department_resources bdr
  ,bom_departments bd
  ,khs_daftar_mesin_resource kdmr
  ,gl_code_combinations gcc
  ,fnd_flex_values_vl ffvv
where gcc.CODE_COMBINATION_ID = bor.ABSORPTION_ACCOUNT
and bor.RESOURCE_ID = bdr.RESOURCE_ID
and bdr.DEPARTMENT_ID = bd.DEPARTMENT_ID
and bor.RESOURCE_ID = kdmr.RESOURCE_ID
and ffvv.FLEX_VALUE_SET_ID = 1013709 
and ffvv.END_DATE_ACTIVE is null
and bor.DISABLE_DATE is null
and substr(ffvv.FLEX_VALUE,0,1) in ('4','5','7','8') --fabrikasi
and ffvv.FLEX_VALUE = gcc.SEGMENT4
and ffvv.FLEX_VALUE LIKE '%$term%'
UNION
select distinct ffvv.FLEX_VALUE                                                          cost_center 
from xla_seg_rules_fvl xsrf
  ,xla_seg_rule_details xsrd
  ,xla_conditions xc
  ,fnd_flex_values_vl ffvv
  ,(select gor.RESOURCES
          ,gor.LAST_UPDATE_DATE 
          ,goa.ACTIVITY
          ,gop.EFFECTIVE_END_DATE end_date
          ,res.RESOURCE_CLASS
          ,res.RESOURCE_DESC
          ,res.MACHINE                                
     from gmd_operations gop
         ,gmd_operation_activities goa
         ,gmd_operation_resources gor
         ,khs_opm_resource_and_machine res
    where gop.OPRN_ID = goa.OPRN_ID
      and goa.OPRN_LINE_ID = gor.OPRN_LINE_ID
      and res.OPRN_LINE_ID = gor.OPRN_LINE_ID
      and res.RESOURCES = gor.RESOURCES
      and gor.ATTRIBUTE1 is not null ) gmd
where xsrf.SEGMENT_RULE_CODE = 'KHS_RCA_CC'
and xsrf.SEGMENT_RULE_CODE = xsrd.SEGMENT_RULE_CODE
and xsrf.APPLICATION_ID = xsrd.APPLICATION_ID
and xsrd.SEGMENT_RULE_DETAIL_ID = xc.SEGMENT_RULE_DETAIL_ID(+)
and xsrd.APPLICATION_ID = xc.APPLICATION_ID(+)
and ffvv.FLEX_VALUE = xsrd.VALUE_CONSTANT 
and ffvv.END_DATE_ACTIVE is null
and gmd.RESOURCES(+) = xc.VALUE_CONSTANT
and gmd.RESOURCE_CLASS = 'MESIN'
and gmd.END_DATE is null
and ffvv.FLEX_VALUE LIKE '%$term%'
order by 1";

    $query = $oracle->query($sql);
    return $query->result_array();
     
  }
}