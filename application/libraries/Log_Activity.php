<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log_Activity
{

  function __construct()
  {
    $this->CI = &get_instance();
    date_default_timezone_set('Asia/Jakarta');
    $this->CI->load->model('M_log_all_activity');
  }

  function activity_log($aksi, $detail)
  {
    $param['log_time']   = date('Y-m-d H:i:s');
    $param['log_user']   = $this->CI->session->user;
    $param['log_aksi']   = $aksi;
    $param['log_detail'] = $detail;

    //save to database
    $this->CI->M_log_all_activity->save_log($param);
  }
  function activity_log2($aksi, $detail, $ip)
  {
    $param['log_time']   = date('Y-m-d H:i:s');
    $param['log_user']   = $this->CI->session->user;
    $param['log_aksi']   = $aksi;
    $param['log_detail'] = $detail;
    $param['ip_address'] = $ip;

    //save to database
    $this->CI->M_log_all_activity->save_log($param);
  }
}
