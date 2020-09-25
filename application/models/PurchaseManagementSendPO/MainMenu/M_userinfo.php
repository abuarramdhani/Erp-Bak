<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_userinfo extends CI_Model
{
    private $personalia;

    private $pg_personalia_debug;

    public function __construct()
    {
        $this->personalia = $this->load->database('personalia', true);
        $this->disableDatabaseDebug();
    }

    public function __destruct()
    {
        $this->restoreDatabaseDebug();
    }

    private function disableDatabaseDebug()
    {
        $this->pg_personalia_debug = $this->personalia->db_debug;
        $this->personalia->pg_personalia_debug = false;
    }

    private function restoreDatabaseDebug()
    {
        $this->personalia->db_debug = $this->pg_personalia_debug;
    }

    public function selectUserInformation($conditional_data)
    {
        $result = $this->personalia
            ->select('nama as name')
            ->where($conditional_data)
            ->get('hrd_khs.tpribadi');

        if (!$result) {
            $db_error = $this->personalia->error();
            throw new Exception("Terjadi error pada database dengan error code {$db_error['code']} dengan pesan {$db_error['message']}");
        }

        return $result->row();
    }
}
