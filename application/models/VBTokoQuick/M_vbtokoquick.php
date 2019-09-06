
<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_vbtokoquick extends CI_Model
{
  var $oracle;
  function __construct()
  {
    parent::__construct();
    $this->load->database();
      $this->load->library('encrypt');
      // $this->oracle = $this->load->database('oracle', true);
   }
    public function checkSourceLogin($employee_code)
    {
        $db = $this->load->database();
        $sql = "select eea.employee_code, es.section_name
                    from er.er_employee_all eea, er.er_section es
                    where eea.section_code = es.section_code
                    and eea.employee_code = '$employee_code' ";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

         
}

?>