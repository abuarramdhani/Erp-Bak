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
    $sql = "select distinct ffvv.FLEX_VALUE                                                 cost_center
    ,NVL(SUBSTR(bor.DESCRIPTION, 0, INSTR(bor.DESCRIPTION, '-')-1), bor.DESCRIPTION)||'- '||kdmr.NO_MESIN seksi_nomesin
    ,kdmr.TAG_NUMBER                                                          tag_number
    ,bor.RESOURCE_CODE                                                        kode_resource
    ,bor.DESCRIPTION deskripsi
    ,bor.LAST_UPDATE_DATE                                                     tanggal_update
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
select ffvv.FLEX_VALUE                                                          cost_center
    ,case substr(xc.VALUE_CONSTANT,0,2)
          when 'SM'
          then 'SHEET METAL TUKSONO'
          when 'PO'
          then 'POTONG AS TUKSONO'
          else 'FOUNDRY'
     end ||' - '||                                                                      
    trim(
          substr(gmd.MACHINE,instr(gmd.MACHINE,'-',1,1)+1
                            ,(instr(gmd.MACHINE,'-',1,2) 
                                  - instr(gmd.MACHINE,'-',1,1)
                                  )-1
                    )
             )                                                                seksi_nomesin
    ,trim(
          substr(gmd.MACHINE,1
                            ,instr(gmd.MACHINE,'-')-1
                   )
           )                                                                  tag_number
    ,gmd.RESOURCES                                                            kode_resource
    ,gmd.RESOURCE_DESC                                                        deskripsi
    ,gmd.LAST_UPDATE_DATE                                                     tanggal_update 
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
order by 1,3";

    $query = $oracle->query($sql);
    return $query->result_array();
        //  return $sql;
  }

  public function getAtta($cc) {
    $oracle = $this->load->database('oracle', true);
    $sql = "select distinct ffvv.FLEX_VALUE                                                 cost_center
    ,NVL(SUBSTR(bor.DESCRIPTION, 0, INSTR(bor.DESCRIPTION, '-')-1), bor.DESCRIPTION)||'- '||kdmr.NO_MESIN seksi_nomesin
    ,kdmr.TAG_NUMBER                                                          tag_number
    ,bor.RESOURCE_CODE                                                        kode_resource
    ,bor.DESCRIPTION deskripsi
    ,bor.LAST_UPDATE_DATE                                                     tanggal_update
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
and ffvv.FLEX_VALUE LIKE '%$cc%'
UNION
select ffvv.FLEX_VALUE                                                          cost_center
    ,case substr(xc.VALUE_CONSTANT,0,2)
          when 'SM'
          then 'SHEET METAL TUKSONO'
          when 'PO'
          then 'POTONG AS TUKSONO'
          else 'FOUNDRY'
     end ||' - '||                                                                      
    trim(
          substr(gmd.MACHINE,instr(gmd.MACHINE,'-',1,1)+1
                            ,(instr(gmd.MACHINE,'-',1,2) 
                                  - instr(gmd.MACHINE,'-',1,1)
                                  )-1
                    )
             )                                                                seksi_nomesin
    ,trim(
          substr(gmd.MACHINE,1
                            ,instr(gmd.MACHINE,'-')-1
                   )
           )                                                                  tag_number
    ,gmd.RESOURCES                                                             kode_resource
    ,gmd.RESOURCE_DESC                                                        deskripsi
    ,gmd.LAST_UPDATE_DATE                                                     tanggal_update 
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
and ffvv.FLEX_VALUE LIKE '%$cc%'
order by 1,3";

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