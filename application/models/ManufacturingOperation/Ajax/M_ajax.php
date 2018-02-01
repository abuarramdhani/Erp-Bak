<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_ajax extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle',true);    
        $this->personalia = $this->load->database('personalia',true);    
    }

    public function getComponent($term = FALSE)
    {
        if ($term==FALSE) {
            $where = "";
        }else{
            $where = "AND msib.SEGMENT1 LIKE '%$term%'";
        }

        $sql = "SELECT msib.SEGMENT1,
                       msib.DESCRIPTION
                FROM mtl_system_Items_b msib
                WHERE (msib.segment1 LIKE '%R1'
                       OR msib.segment1 LIKE '%P1')
                  $where";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getEmployee()
    {
        $sql = "SELECT tp.noind,
                       tp.nama
                FROM hrd_khs.tpribadi tp
                LEFT JOIN hrd_khs.tseksi ts ON tp.kodesie = ts.kodesie
                WHERE ts.dept LIKE '%PRODUKSI%'
                  AND ts.bidang LIKE '%PRODUKSI PENGECORAN LOGAM%'
                  AND ts.bidang NOT LIKE '%PRODUKSI PENGECORAN LOGAM - TKS%'
                  AND (tp.lokasi = 'AA'
                       OR tp.lokasi_kerja = '01')
                ORDER BY tp.noind";

        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function getJobData($jobCode=FALSE, $startDate=FALSE, $endDate=FALSE)
    {
      if ($startDate==FALSE || $endDate==FALSE) {
        $wDate = '';
      }else{
        $wDate = "AND TO_CHAR(wdj.DATE_RELEASED,'YYYY/MM/DD hh:mi:ss') BETWEEN '$startDate' AND '$endDate'";
      }

      if ($jobCode==FALSE) {
        $wJobCode = '';
      }else{
        $wJobCode = "AND we.WIP_ENTITY_NAME LIKE '%$jobCode%'";
      }
      $sql = "SELECT we.WIP_ENTITY_NAME ,
                     TO_CHAR(wdj.DATE_RELEASED,'DD/MM/YYYY hh:mi:ss') RELEASE ,
                     msib.SEGMENT1 ,
                     msib.DESCRIPTION
              FROM mtl_system_items_b msib ,
                   wip_entities we ,
                   wip_discrete_jobs wdj
              WHERE msib.ORGANIZATION_ID = 102
                AND we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
                AND wdj.PRIMARY_ITEM_ID = msib.INVENTORY_ITEM_ID
                AND wdj.ORGANIZATION_ID = msib.ORGANIZATION_ID
                $wDate $wJobCode
              ORDER BY wdj.DATE_RELEASED";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function setRejectComp($data)
    {
      $this->db->insert('mo.mo_replacement_component', $data);
      $id = $this->db->insert_id();
      
      $this->db->select('*');
      $this->db->from('mo.mo_replacement_component');
      $this->db->where('replacement_component_id', $id);
      $query = $this->db->get();
      return $query->result_array();
    }

    public function deleteRejectComp($id)
    {
      $this->db->where('replacement_component_id', $id);
      $this->db->delete('mo.mo_replacement_component');
    }

    public function getRejectComp($id)
    {
      $this->db->select('*');
      $this->db->from('mo.mo_replacement_component');
      $this->db->where('replacement_component_id', $id);
      $query = $this->db->get();
      return $query->result_array();
    }
}