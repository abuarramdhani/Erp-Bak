<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_sysuser extends CI_Model
{
    private $pg_erp_debug;

    public function __construct()
    {
        $this->load->database();
        $this->disableDatabaseDebug();
    }

    public function __destruct()
    {
        $this->restoreDatabaseDebug();
    }

    private function disableDatabaseDebug()
    {
        $this->pg_erp_debug = $this->db->db_debug;
        $this->db->pg_erp_debug = false;
    }

    private function restoreDatabaseDebug()
    {
        $this->db->db_debug = $this->pg_erp_debug;
    }

    public function selectUserIdentity($conditional_data)
    {
        $result = $this->db
            ->select('user_id')
            ->where($conditional_data)
            ->get('sys.sys_user');

        if (!$result) {
            $db_error = $this->db->error();
            throw new Exception("Terjadi error pada database dengan error code {$db_error['code']} dengan pesan {$db_error['message']}");
        }

        $row_result = $result->row();

        if (!count($row_result)) {
            throw new Exception('Username dan password yang anda berikan tidak sesuai');
        }

        return $row_result->user_id;
    }
}
