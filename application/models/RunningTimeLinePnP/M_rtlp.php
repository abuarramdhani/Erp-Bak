<?php
class M_rtlp extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // $this->oracle = $this->load->database('oracle', true);
        // $this->oracle = $this->load->database('oracle_dev', true);
        $this->personalia = $this->load->database('personalia', true);
    }

    public function getline1($date)
    {
        $response = $this->db->where('line', 1)->where('date_target', $date)->get('wip_pnp.line_data')->result_array();
        return $response;
    }

    public function getline2($date)
    {
        $response = $this->db->where('line', 2)->where('date_target', $date)->get('wip_pnp.line_data')->result_array();
        return $response;
    }

    public function getline3($date)
    {
        $response = $this->db->where('line', 3)->where('date_target', $date)->get('wip_pnp.line_data')->result_array();
        return $response;
    }

    public function getline4($date)
    {
        $response = $this->db->where('line', 4)->where('date_target', $date)->get('wip_pnp.line_data')->result_array();
        return $response;
    }

    public function getline5($date)
    {
        $response = $this->db->where('line', 5)->where('date_target', $date)->get('wip_pnp.line_data')->result_array();
        return $response;
    }

    public function SetStart($data)
    {
      $cek = $this->db->where('Komponen', $data['Komponen'])->get('wip_pnp.Time_Record')->row();
      if (!empty($cek)) {
        $this->db->where('Komponen', $data['Komponen'])->update('wip_pnp.Time_Record', $data);
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
      $cek = $this->db->where('Komponen', $data['Komponen'])->get('wip_pnp.Time_Record')->row();
      if (!empty($cek)) {
         $this->db->where('Komponen', $data['Komponen'])->update('wip_pnp.Time_Record', $data);
         $check = $this->db->where('Line', $data['Line'])->get('wip_pnp.running_line')->row();
         if (!empty($check)) {
           $this->db->where('Line', $data['Line'])->update('wip_pnp.running_line', ['Line' => $data['Line'], 'Component_Code' => NULL]);
           return 1;
         }
      }else {
        return 0;
      }
    }

}
