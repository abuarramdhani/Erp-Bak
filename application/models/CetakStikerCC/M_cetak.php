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
    $sql = "SELECT   gcc.segment4 cost_center,
    NVL (SUBSTR (br.description, 0, INSTR (br.description, '-') - 1),
         br.description
        )
 || '- '
 || kdmr.no_mesin seksi_nomesin,
 kdmr.tag_number tag_number, br.resource_code kode_resource,
 br.description deskripsi, MAX (br.last_update_date) tanggal_update
FROM     bom_departments bd,
 bom_resources br,
 bom_department_resources bdr,
 gl_code_combinations gcc,
 khs_daftar_mesin_resource kdmr
WHERE bd.department_id = bdr.department_id
AND bdr.resource_id = br.resource_id
AND br.absorption_account = gcc.code_combination_id
AND br.resource_id = kdmr.resource_id(+)
AND bdr.attribute3 IS NULL
AND bd.disable_date IS NULL
AND br.disable_date IS NULL
AND gcc.segment4 LIKE '%$term%'
GROUP BY gcc.segment4,
    NVL (SUBSTR (br.description, 0, INSTR (br.description, '-') - 1),
         br.description
        )
 || '- '
 || kdmr.no_mesin,
 kdmr.tag_number,
 br.resource_code,
 br.description
UNION
SELECT   xsrd.value_constant cost_center,
    CASE SUBSTR (xc.value_constant, 0, 2)
       WHEN 'SM'
          THEN 'SHEET METAL TUKSONO'
       WHEN 'PO'
          THEN 'POTONG AS TUKSONO'
       ELSE 'FOUNDRY'
    END
 || ' - '
 || kdmro.no_mesin seksi_nomesin,
 kdmro.tag_number, gor.resources kode_resource,
 crm.resource_desc deskripsi, gor.last_update_date
FROM gmd_operations gos,
 gmd_operation_activities goa,
 gmd_operation_resources gor,
 cr_rsrc_mst crm,
 khs_daftar_mesin_resource_opm kdmro,
 xla_conditions xc,
 xla_seg_rule_details xsrd
WHERE gos.owner_organization_id = 101
AND gos.oprn_no LIKE '%RESOURCE'
AND gos.oprn_id = goa.oprn_id
AND goa.oprn_line_id = gor.oprn_line_id
AND gor.resources = crm.resources
AND gor.resources = kdmro.resources
AND gor.oprn_line_id = kdmro.oprn_line_id
AND gor.resources = xc.value_constant
AND xc.segment_rule_detail_id = xsrd.segment_rule_detail_id
AND gos.operation_status = 700 -- Approved for General Use
AND xsrd.value_constant LIKE '%$term%'
ORDER BY 1, 3";

    $query = $oracle->query($sql);
    return $query->result_array();
        //  return $sql;
  }

  public function getAtta($cc) {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT   gcc.segment4 cost_center,
    NVL (SUBSTR (br.description, 0, INSTR (br.description, '-') - 1),
         br.description
        )
 || '- '
 || kdmr.no_mesin seksi_nomesin,
 kdmr.tag_number tag_number, br.resource_code kode_resource,
 br.description deskripsi, MAX (br.last_update_date) tanggal_update
FROM     bom_departments bd,
 bom_resources br,
 bom_department_resources bdr,
 gl_code_combinations gcc,
 khs_daftar_mesin_resource kdmr
WHERE bd.department_id = bdr.department_id
AND bdr.resource_id = br.resource_id
AND br.absorption_account = gcc.code_combination_id
AND br.resource_id = kdmr.resource_id(+)
AND bdr.attribute3 IS NULL
AND bd.disable_date IS NULL
AND br.disable_date IS NULL
AND gcc.segment4 LIKE '%$cc%'
GROUP BY gcc.segment4,
    NVL (SUBSTR (br.description, 0, INSTR (br.description, '-') - 1),
         br.description
        )
 || '- '
 || kdmr.no_mesin,
 kdmr.tag_number,
 br.resource_code,
 br.description
UNION
SELECT   xsrd.value_constant cost_center,
    CASE SUBSTR (xc.value_constant, 0, 2)
       WHEN 'SM'
          THEN 'SHEET METAL TUKSONO'
       WHEN 'PO'
          THEN 'POTONG AS TUKSONO'
       ELSE 'FOUNDRY'
    END
 || ' - '
 || kdmro.no_mesin seksi_nomesin,
 kdmro.tag_number, gor.resources kode_resource,
 crm.resource_desc deskripsi, gor.last_update_date
FROM gmd_operations gos,
 gmd_operation_activities goa,
 gmd_operation_resources gor,
 cr_rsrc_mst crm,
 khs_daftar_mesin_resource_opm kdmro,
 xla_conditions xc,
 xla_seg_rule_details xsrd
WHERE gos.owner_organization_id = 101
AND gos.oprn_no LIKE '%RESOURCE'
AND gos.oprn_id = goa.oprn_id
AND goa.oprn_line_id = gor.oprn_line_id
AND gor.resources = crm.resources
AND gor.resources = kdmro.resources
AND gor.oprn_line_id = kdmro.oprn_line_id
AND gor.resources = xc.value_constant
AND xc.segment_rule_detail_id = xsrd.segment_rule_detail_id
AND gos.operation_status = 700 -- Approved for General Use
AND xsrd.value_constant LIKE '%$cc%'
ORDER BY 1, 3";

    $query = $oracle->query($sql);
    return $query->result_array();
        //  return $sql;
  }


  public function getDataCost($term) {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT DISTINCT gcc.segment4 cost_center
    FROM bom_departments bd,
         bom_resources br,
         bom_department_resources bdr,
         gl_code_combinations gcc,
         khs_daftar_mesin_resource kdmr
   WHERE bd.department_id = bdr.department_id
     AND bdr.resource_id = br.resource_id
     AND br.absorption_account = gcc.code_combination_id
     AND br.resource_id = kdmr.resource_id(+)
     AND bdr.attribute3 IS NULL
     AND bd.disable_date IS NULL
     AND br.disable_date IS NULL
     AND gcc.segment4 LIKE '%$term%'
GROUP BY gcc.segment4,
            NVL (SUBSTR (br.description,
                         0,
                         INSTR (br.description, '-') - 1
                        ),
                 br.description
                )
         || '- '
         || kdmr.no_mesin,
         kdmr.tag_number,
         br.resource_code,
         br.description
UNION
SELECT DISTINCT xsrd.value_constant cost_center
    FROM gmd_operations gos,
         gmd_operation_activities goa,
         gmd_operation_resources gor,
         cr_rsrc_mst crm,
         khs_daftar_mesin_resource_opm kdmro,
         xla_conditions xc,
         xla_seg_rule_details xsrd
   WHERE gos.owner_organization_id = 101
     AND gos.oprn_no LIKE '%RESOURCE'
     AND gos.oprn_id = goa.oprn_id
     AND goa.oprn_line_id = gor.oprn_line_id
     AND gor.resources = crm.resources
     AND gor.resources = kdmro.resources
     AND gor.oprn_line_id = kdmro.oprn_line_id
     AND gor.resources = xc.value_constant
     AND xc.segment_rule_detail_id = xsrd.segment_rule_detail_id
     AND gos.operation_status = 700 -- Approved for General Use
     AND xsrd.value_constant LIKE '%$term%'
ORDER BY 1";

    $query = $oracle->query($sql);
    return $query->result_array();
     
  }
}