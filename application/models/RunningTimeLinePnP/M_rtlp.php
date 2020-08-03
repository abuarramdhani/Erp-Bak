<?php
class M_rtlp extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // $this->oracle = $this->load->database('oracle_dev', true);
        $this->personalia = $this->load->database('personalia', true);
    }

    public function reset($no_job, $line, $start_reset)
    {
      $this->db->where('No_Job', $no_job)
               ->where('Line', $line)
               ->update('wip_pnp.Time_Record', ['Start' => $start_reset]);
      if ($this->db->affected_rows() == 1) {
        return 1;
      }
    }

    public function detail_pause($no_job, $line)
    {
      $res = $this->db->where('No_Job', $no_job)
                      ->where('Line', $line)
                      ->get('wip_pnp.Time_Break')
                      ->result_array();
      return $res;
    }

    public function insertTimePause($data)
    {
      $this->db->insert('wip_pnp.Time_Break', $data);
      return 1;
    }

    public function updateTimePause($data)
    {
      $idmax = $this->db->select_max('id_break')->where('Line', $data['Line'])->get('wip_pnp.Time_Break')->row_array();
      $this->db->where('id_break', $idmax['id_break'])
               ->update('wip_pnp.Time_Break', $data);
      return 1;
    }

    public function getHistory()
    {
      $res = $this->db->order_by('Id', 'desc')->get('wip_pnp.Time_Record')->result_array();
      return $res;
    }

    public function getNamaKomponen($value)
    {
      $res = $this->db->distinct()->select('nama_item')->where('kode_item', $value)->get('wip_pnp.job_list')->row();
      return $res;
    }

    public function getline1($date)
    {
        $x = explode('_', $date);
        $response = $this->db->where('line', 1)->where('date_target', $x[0])->where('type', $x[1])->get('wip_pnp.line_data')->result_array();
        return $response;
    }

    public function getline2($date)
    {
        $x = explode('_', $date);
        $response = $this->db->where('line', 2)->where('date_target', $x[0])->where('type', $x[1])->get('wip_pnp.line_data')->result_array();
        return $response;
    }

    public function getline3($date)
    {
        $x = explode('_', $date);
        $response = $this->db->where('line', 3)->where('date_target', $x[0])->where('type', $x[1])->get('wip_pnp.line_data')->result_array();
        return $response;
    }

    public function getline4($date)
    {
        $x = explode('_', $date);
        $response = $this->db->where('line', 4)->where('date_target', $x[0])->where('type', $x[1])->get('wip_pnp.line_data')->result_array();
        return $response;
    }

    public function getline5($date)
    {
        $x = explode('_', $date);
        $response = $this->db->where('line', 5)->where('date_target', $x[0])->where('type', $x[1])->get('wip_pnp.line_data')->result_array();
        return $response;
    }

    public function SetStart($data)
    {
      $cek = $this->db->where('No_Job', $data['No_Job'])->where('Line', $data['Line'])->get('wip_pnp.Time_Record')->row();
      if (!empty($cek)) {
        $this->db->where('No_Job', $data['No_Job'])->where('Line', $data['Line'])->update('wip_pnp.Time_Record', $data);
        if ($this->db->affected_rows() == 1) {
          $check = $this->db->where('Line', $data['Line'])->get('wip_pnp.running_line')->row();
          if (empty($check)) {
            $this->db->insert('wip_pnp.running_line', ['Line' => $data['Line'], 'Component_Code' => $data['Komponen']]);
            return 1;
          }else {
            $this->db->where('Line', $data['Line'])->update('wip_pnp.running_line', ['Line' => $data['Line'], 'Component_Code' => $data['Komponen']]);
            return 1;
          }
        }else {
          return 0;
        }
      }else {
        $this->db->insert('wip_pnp.Time_Record', $data);
        if ($this->db->affected_rows() == 1) {
          $check = $this->db->where('Line', $data['Line'])->get('wip_pnp.running_line')->row();
          if (empty($check)) {
            $this->db->insert('wip_pnp.running_line', ['Line' => $data['Line'], 'Component_Code' => $data['Komponen']]);
            return 1;
          }else {
            $this->db->where('Line', $data['Line'])->update('wip_pnp.running_line', ['Line' => $data['Line'], 'Component_Code' => $data['Komponen']]);
            return 1;
          }
        }else {
          return 0;
        }
      }

    }

    public function SetFinish($data)
    {
      $cek = $this->db->where('No_Job', $data['No_Job'])->where('Line', $data['Line'])->get('wip_pnp.Time_Record')->row();
      if (!empty($cek)) {
         $this->db->where('No_Job', $data['No_Job'])->where('Line', $data['Line'])->update('wip_pnp.Time_Record', $data);
         $check = $this->db->where('Line', $data['Line'])->get('wip_pnp.running_line')->row();
         if (!empty($check)) {
           $this->db->where('Line', $data['Line'])->update('wip_pnp.running_line', ['Line' => $data['Line'], 'Component_Code' => NULL]);
           return 1;
         }
      }else {
        return 0;
      }
    }

    public function getDetailBom($kodebarang)
    {
        $this->oracle = $this->load->database('oracle', true);
        
        $sql = "SELECT
        rownum line_id
        ,CONNECT_BY_ROOT q_bom.assembly_num root_assembly
        -- ,q_bom.component_num
        -- ,q_bom.component_id
        ,q_bom.description
        -- ,q_bom.item_num
        -- ,q_bom.item_type
        ,q_bom.qty
        ,q_bom.uom
        -- ,SUBSTR(SYS_CONNECT_BY_PATH(q_bom.assembly_Num, ' <-- '),5) assembly_path
        -- ,LEVEL  bom_level
        -- ,organization_id
        -- ,organization_code
        -- ,item_cost--,  CONNECT_BY_ISCYCLE is_cycle
         FROM
         (SELECT mb1.segment1 assembly_num, mb2.segment1 component_num,
                 mb2.inventory_item_id component_id, mb2.description,
                 bc.item_num, flv.meaning item_type, bc.component_quantity qty,
                 mb2.primary_uom_code uom, mb1.organization_id, mp.organization_code,
                 (SELECT cic.item_cost
                    FROM cst_item_costs cic
                   WHERE mb2.inventory_item_id = cic.inventory_item_id
                     AND mb2.organization_id = cic.organization_id
                     AND cic.cost_type_id = 1020--KHSStandar
                 ) item_cost
          FROM   bom.bom_components_b bc,
                 bom.bom_structures_b bs,
                 inv.mtl_system_items_b mb1,
                 inv.mtl_system_items_b mb2,
                 fnd_lookup_values flv,
                 mtl_parameters mp
          WHERE  bs.assembly_item_id = mb1.inventory_item_id
             AND bc.component_item_id = mb2.inventory_item_id
             AND bc.bill_sequence_id = bs.bill_sequence_id
             AND mb1.organization_id = mb2.organization_id
             AND bs.organization_id = mb2.organization_id
             AND bc.disable_date IS NULL
             AND bs.alternate_bom_designator IS NULL
             AND mb1.organization_id = NVL (102, mb1.organization_id) --in (102,386)
             AND mp.organization_id = mb1.organization_id
             AND mb2.item_type = flv.lookup_code
             AND flv.lookup_type = 'ITEM_TYPE'
         ) q_bom
         WHERE
         q_bom.component_num LIKE 'MGA%'
       START WITH  q_bom.assembly_Num IN ('$kodebarang')
       CONNECT BY NOCYCLE PRIOR q_bom.component_num = q_bom.assembly_num
       ORDER SIBLINGS BY q_bom.assembly_Num, q_bom.item_num";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

}
