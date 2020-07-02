<?php

/**
 *
 */
class Access extends CI_Model
{

  function __construct()
  {
    $this->load->database();
  }

  function CanAccess()
  {
    $user_id      = $this->session->userid;
    $current_url  = rtrim($_SERVER['REQUEST_URI'], "/");
    $menu_url     = explode("/", $current_url)[1];
    $key_query    = explode("/", $current_url)[1]."%";
    $sql = " SELECT sm.menu_link
             FROM
              sys.sys_user_application sua
             INNER JOIN sys.vi_sys_user_group_menu vsugm ON sua.user_group_menu_id = vsugm.user_group_menu_id
             INNER JOIN sys.sys_menu_group umg ON umg.group_menu_id = vsugm.group_menu_id
             INNER JOIN sys.sys_menu_group_list mgl ON mgl.group_menu_id = umg.group_menu_id
             INNER JOIN sys.sys_menu sm ON sm.menu_id = mgl.menu_id
             WHERE
              sua.user_id = '$user_id' AND sm.menu_link NOT IN('','#') AND sm.menu_link LIKE '$key_query'";
    $result = $this->db->query($sql)->result_array();
    $main_url = "";
    if(!empty($result)){
      $main_url = explode("/", $result[0]['menu_link'])[0];
      $real_url = "/".$main_url;
    }
    $canAccess = true;
    if($menu_url == $main_url){
      if ($current_url == $real_url) {
        $canAccess = true;
      }else{
        foreach ($result as $key) {
          if(strstr($current_url, $key['menu_link'])){
            $canAccess = true;
            break;
          }else{
            $canAccess = false;
          }
        }
      }
    }else{
      $canAccess = false;
    }
    return $canAccess;
  }

  function page()
  {
    $access = $this->CanAccess();
    $access = true;
    if(!$access){
      echo "
      <div style='position: absolute; left: 0; right: 0; top: 30%; bottom: 0;'>
        <center><img style='width: 100px; height: auto;' src=".base_url('assets/img/logo.png')." /></center>
        <center><h2 style='font-family: Arial, Helvetica, sans-serif;'>Halaman ini tidak bisa di akses</h2></center>
      </div>
      ";
      die;
    }
  }
}
