<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class M_log_all_activity extends CI_Model
{

  function __construct()
  {
    $this->load->database();
  }

  public function save_log($param)
  {
    return $this->db->insert('sys.sys_log_activity', $param);
  }
  public function otp_log($param)
  {
    return $this->db->insert('sys.sys_log_otp', $param);
  }
}
