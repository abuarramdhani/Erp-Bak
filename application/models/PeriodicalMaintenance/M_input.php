<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_input extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library('encrypt');
    $this->oracle = $this->load->database('oracle_dev', TRUE);
  }

  public function getDataPrevious($mesin)
  {
    $sql = "SELECT * FROM khs_periodical_maintenance
            WHERE NAMA_MESIN = '$mesin'
            ORDER BY 1";
    $query = $this->oracle->query($sql);
    return $query->result_array();
    // echo $sql;
  }

  public function Insert($nama_mesin, $kondisi_mesin, $header, $uraian_kerja, $standar, $periode)

  {
    $sql = "INSERT INTO khs_periodical_maintenance (NAMA_MESIN, KONDISI_MESIN, HEADER, SUB_HEADER, STANDAR, PERIODE)
    VALUES ('$nama_mesin', '$kondisi_mesin', '$header', '$uraian_kerja', '$standar', '$periode')";
    $query = $this->oracle->query($sql);
    // echo $sql;
    // exit;
  }

  public function getLokasi()
  {
    $sql = "SELECT DISTINCT fvl.DESCRIPTION Lokasi
    from
    fa_additions_b fab
    ,fa_additions_tl fat
    ,fa_books fb
    ,fa_distribution_history fdh
    ,fa_locations fl
    ,fa_asset_keywords fak
    ,fa_asset_keywords fak1
    ,fnd_flex_values ffv
    ,fnd_flex_values_vl fvl
    ,fnd_flex_values ffv2
    ,fnd_flex_values_vl fvl2
    ,fnd_flex_values ffv3
    ,fnd_flex_values_vl fvl3
    where
    fat.asset_id = fab.asset_id
    and fb.asset_id = fab.asset_id
    and fb.DATE_INEFFECTIVE is null
    and fdh.asset_id = fab.asset_id
    and fdh.date_ineffective is null
    and fl.location_id = fdh.location_id
    and fak.code_combination_id = fab.ASSET_KEY_CCID
    and fak1.code_combination_id = fab.ASSET_KEY_CCID
    and ffv.FLEX_VALUE_SET_ID in ('1013835')
    and ffv.FLEX_VALUE_ID=fvl.FLEX_VALUE_ID
    and ffv.FLEX_VALUE_SET_ID=fvl.FLEX_VALUE_SET_ID
    and fl.segment1 = ffv.FLEX_VALUE   
    and ffv2.FLEX_VALUE_SET_ID in ('1013836')
    and ffv2.FLEX_VALUE_ID=fvl2.FLEX_VALUE_ID
    and ffv2.FLEX_VALUE_SET_ID=fvl2.FLEX_VALUE_SET_ID
    and fl.segment2 = ffv2.FLEX_VALUE 
    and ffv3.FLEX_VALUE_SET_ID in ('1013837')
    and ffv3.FLEX_VALUE_ID=fvl3.FLEX_VALUE_ID
    and ffv3.FLEX_VALUE_SET_ID=fvl3.FLEX_VALUE_SET_ID
    and fl.segment3 = ffv3.FLEX_VALUE
    and ffv3.PARENT_FLEX_VALUE_LOW = ffv.FLEX_VALUE 
    --and fl.segment1 like 'TKS%' 
    and fb.book_type_code = 'KHS CORP BOOK'--:P_BOOK
    order by 1";
    // return $sql;
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getLantai($term)
  {
    $sql = "SELECT DISTINCT 
          fvl.DESCRIPTION Lokasi
          ,fvl2.DESCRIPTION Lantai
          from
          fa_additions_b fab
          ,fa_additions_tl fat
          ,fa_books fb
          ,fa_distribution_history fdh
          ,fa_locations fl
          ,fa_asset_keywords fak
          ,fa_asset_keywords fak1
          ,fnd_flex_values ffv
          ,fnd_flex_values_vl fvl
          ,fnd_flex_values ffv2
          ,fnd_flex_values_vl fvl2
          ,fnd_flex_values ffv3
          ,fnd_flex_values_vl fvl3
          where
          fat.asset_id = fab.asset_id
          and fb.asset_id = fab.asset_id
          and fb.DATE_INEFFECTIVE is null
          and fdh.asset_id = fab.asset_id
          and fdh.date_ineffective is null
          and fl.location_id = fdh.location_id
          and fak.code_combination_id = fab.ASSET_KEY_CCID
          and fak1.code_combination_id = fab.ASSET_KEY_CCID
          and ffv.FLEX_VALUE_SET_ID in ('1013835')
          and ffv.FLEX_VALUE_ID=fvl.FLEX_VALUE_ID
          and ffv.FLEX_VALUE_SET_ID=fvl.FLEX_VALUE_SET_ID
          and fl.segment1 = ffv.FLEX_VALUE   
          and ffv2.FLEX_VALUE_SET_ID in ('1013836')
          and ffv2.FLEX_VALUE_ID=fvl2.FLEX_VALUE_ID
          and ffv2.FLEX_VALUE_SET_ID=fvl2.FLEX_VALUE_SET_ID
          and fl.segment2 = ffv2.FLEX_VALUE 
          and ffv3.FLEX_VALUE_SET_ID in ('1013837')
          and ffv3.FLEX_VALUE_ID=fvl3.FLEX_VALUE_ID
          and ffv3.FLEX_VALUE_SET_ID=fvl3.FLEX_VALUE_SET_ID
          and fl.segment3 = ffv3.FLEX_VALUE
          and ffv3.PARENT_FLEX_VALUE_LOW = ffv.FLEX_VALUE 
          --and fl.segment1 like 'TKS%' 
          and fb.book_type_code = 'KHS CORP BOOK'--:P_BOOK
          and fvl.DESCRIPTION = '$term' --:P_LOKASI
          order by 2";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getArea($lokasi, $lantai)
  {
    $sql = "SELECT DISTINCT 
          fvl.DESCRIPTION Lokasi
          ,fvl2.DESCRIPTION Lantai
          ,fvl3.DESCRIPTION Area
          from
          fa_additions_b fab
          ,fa_additions_tl fat
          ,fa_books fb
          ,fa_distribution_history fdh
          ,fa_locations fl
          ,fa_asset_keywords fak
          ,fa_asset_keywords fak1
          ,fnd_flex_values ffv
          ,fnd_flex_values_vl fvl
          ,fnd_flex_values ffv2
          ,fnd_flex_values_vl fvl2
          ,fnd_flex_values ffv3
          ,fnd_flex_values_vl fvl3
          where
          fat.asset_id = fab.asset_id
          and fb.asset_id = fab.asset_id
          and fb.DATE_INEFFECTIVE is null
          and fdh.asset_id = fab.asset_id
          and fdh.date_ineffective is null
          and fl.location_id = fdh.location_id
          and fak.code_combination_id = fab.ASSET_KEY_CCID
          and fak1.code_combination_id = fab.ASSET_KEY_CCID
          and ffv.FLEX_VALUE_SET_ID in ('1013835')
          and ffv.FLEX_VALUE_ID=fvl.FLEX_VALUE_ID
          and ffv.FLEX_VALUE_SET_ID=fvl.FLEX_VALUE_SET_ID
          and fl.segment1 = ffv.FLEX_VALUE   
          and ffv2.FLEX_VALUE_SET_ID in ('1013836')
          and ffv2.FLEX_VALUE_ID=fvl2.FLEX_VALUE_ID
          and ffv2.FLEX_VALUE_SET_ID=fvl2.FLEX_VALUE_SET_ID
          and fl.segment2 = ffv2.FLEX_VALUE 
          and ffv3.FLEX_VALUE_SET_ID in ('1013837')
          and ffv3.FLEX_VALUE_ID=fvl3.FLEX_VALUE_ID
          and ffv3.FLEX_VALUE_SET_ID=fvl3.FLEX_VALUE_SET_ID
          and fl.segment3 = ffv3.FLEX_VALUE
          and ffv3.PARENT_FLEX_VALUE_LOW = ffv.FLEX_VALUE 
          --and fl.segment1 like 'TKS%' 
          and fb.book_type_code = 'KHS CORP BOOK'--:P_BOOK
          and fvl.DESCRIPTION = '$lokasi' --:P_LOKASI
          and fvl2.DESCRIPTION = '$lantai'
          order by 3";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getMesin($lokasi, $lantai, $area)
  {
    $sql = "SELECT DISTINCT 
          fab.ASSET_NUMBER
          ,fat.DESCRIPTION Mesin
          ,fvl.DESCRIPTION Lokasi
          ,fvl2.DESCRIPTION Lantai
          ,fvl3.DESCRIPTION Area
          ,fak.segment2 cost_center
          ,fb.date_placed_in_service acquisition_date
          ,(fb.LIFE_IN_MONTHS/12) usefull_life
          from
          fa_additions_b fab
          ,fa_additions_tl fat
          ,fa_books fb
          ,fa_distribution_history fdh
          ,fa_locations fl
          ,fa_asset_keywords fak
          ,fa_asset_keywords fak1
          ,fnd_flex_values ffv
          ,fnd_flex_values_vl fvl
          ,fnd_flex_values ffv2
          ,fnd_flex_values_vl fvl2
          ,fnd_flex_values ffv3
          ,fnd_flex_values_vl fvl3
          where
          fat.asset_id = fab.asset_id
          and fb.asset_id = fab.asset_id
          and fb.DATE_INEFFECTIVE is null
          and fdh.asset_id = fab.asset_id
          and fdh.date_ineffective is null
          and fl.location_id = fdh.location_id
          and fak.code_combination_id = fab.ASSET_KEY_CCID
          and fak1.code_combination_id = fab.ASSET_KEY_CCID
          and ffv.FLEX_VALUE_SET_ID in ('1013835')
          and ffv.FLEX_VALUE_ID=fvl.FLEX_VALUE_ID
          and ffv.FLEX_VALUE_SET_ID=fvl.FLEX_VALUE_SET_ID
          and fl.segment1 = ffv.FLEX_VALUE   
          and ffv2.FLEX_VALUE_SET_ID in ('1013836')
          and ffv2.FLEX_VALUE_ID=fvl2.FLEX_VALUE_ID
          and ffv2.FLEX_VALUE_SET_ID=fvl2.FLEX_VALUE_SET_ID
          and fl.segment2 = ffv2.FLEX_VALUE 
          and ffv3.FLEX_VALUE_SET_ID in ('1013837')
          and ffv3.FLEX_VALUE_ID=fvl3.FLEX_VALUE_ID
          and ffv3.FLEX_VALUE_SET_ID=fvl3.FLEX_VALUE_SET_ID
          and fl.segment3 = ffv3.FLEX_VALUE
          and ffv3.PARENT_FLEX_VALUE_LOW = ffv.FLEX_VALUE 
          --and fl.segment1 like 'TKS%' 
          and fb.book_type_code = 'KHS CORP BOOK'--:P_BOOK
          and fvl.DESCRIPTION = '$lokasi' --:P_LOKASI
          and fvl2.DESCRIPTION = '$lantai'
          and fvl3.DESCRIPTION  = '$area'
          order by fab.ASSET_NUMBER";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }
}
