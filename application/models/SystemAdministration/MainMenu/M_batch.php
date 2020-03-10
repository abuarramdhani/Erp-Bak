<?php

defined('BASEPATH') or exit('tidak ada sistem yang aman');

Class M_batch extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    // @params array
    // @return text, example-> [f2327'', '']
    private function arrayToString($arr) {
        $result = array_map(function ($item) {
            return "'".$item."'";
        }, $arr);

        return $result;
    }

    // @params array from C_Batch.php
    // @return array
    function preview_person($params) {
        $noind = explode(' ', $params['noind']);
        $paramsNoind = implode(', ', $this->arrayToString($noind));

        $querySelect = "SELECT 
        emp.employee_code as noind,
        emp.employee_name as name,
        coalesce(nullif(es.section_name,'-'), nullif(es.unit_name, '-'), nullif(es.field_name, '-'), nullif(es.department_name, '-')) as seksi,
        (select count(user_name) from sys.sys_user where user_name = emp.employee_code limit 1) as account
        FROM er.er_employee_all emp inner join er.er_section es on es.section_code = emp.section_code
        where employee_code in ($paramsNoind)
        order by 2";

        return $this->db->query($querySelect)->result_array();
    }

    // @params array from C_Batch.php
    // @return boolean
    function addResponsbility($params) {
        $noind = explode(' ', $params['noind']);
        $paramsNoind = implode(', ', $this->arrayToString($noind));
        
        $res_id = $params['res_id'];
        $inet = $params['inet'];
        $local = $params['local'];
        $user_id = '568';

        // create an account if not yet have (if created by F2327 xD)
        $queryAddAccount = "INSERT INTO sys.sys_user (user_name, user_password, employee_id, creation_date, created_by) SELECT employee_code, md5('123456'), employee_id ,now(), '568' FROM er.er_employee_all WHERE employee_code in ($paramsNoind) AND employee_code not in ( select user_name from sys.sys_user where user_name in ($paramsNoind) );";
        $queryAddRes     = "INSERT INTO sys.sys_user_application
        (user_group_menu_id, user_id, active, creation_date, created_by, lokal, internet)
        select '$res_id', user_id, 'Y', now(), '$user_id', '$local', '$inet' from sys.sys_user where user_name in ($paramsNoind) and user_name not in (SELECT su.user_name
        FROM sys.sys_user_application sua inner join sys.sys_user su on su.user_id = sua.user_id
        WHERE sua.user_group_menu_id='$res_id' AND su.user_name in ($paramsNoind))";

        $this->db->query($queryAddAccount);
        return $this->db->query($queryAddRes);
    }
}