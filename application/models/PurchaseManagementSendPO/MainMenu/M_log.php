<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_log extends CI_Model
{
    private $oracle;

    private $oracle_util;

    private $db_debug;

    public function __construct()
    {
        $this->oracle = $this->load->database('oracle', true);
        $this->oracle_util = $this->load->dbutil($this->oracle, true);
        $this->checkConnection();
        $this->disableDatabaseDebug();
    }

    public function __destruct()
    {
        $this->restoreDatabaseDebug();
    }

    private function checkConnection() {
        if(!$this->oracle_util->list_databases()) {
            throw new Exception('Tidak dapat terhubung ke Database Oracle');
        }
    }

    private function disableDatabaseDebug()
    {
        $this->db_debug = $this->oracle->db_debug;
        $this->oracle->db_debug = false;
    }

    private function restoreDatabaseDebug()
    {
        $this->oracle->db_debug = $this->db_debug;
    }

    public function update($conditional_data, $set_data, $update_data)
    {
        $result = $this->oracle
            ->set(strtoupper($set_data), strtoupper('sysdate'), false)
            ->where(array_change_key_case($conditional_data, CASE_UPPER))
            ->update(strtoupper('apps.khs_psup_po_logbook'), array_change_key_case($update_data, CASE_UPPER));

        if (!$result) {
            $db_error = $this->oracle->error();
            throw new Exception("Terjadi error pada database dengan error code {$db_error['code']} dengan pesan {$db_error['message']}");
        }

        $affected_rows = $this->oracle->affected_rows();

        if (!$affected_rows) {
            throw new Exception('Tidak terdapat baris data yang berhasil diperbarui');
        }

        return $affected_rows;
    }

    public function selectVendorName($conditional_data)
    {
        $result = $this->oracle
            ->select(strtoupper('vendor_name') . ' as vendor_name')
            ->where(array_change_key_case($conditional_data, CASE_UPPER))
            ->get(strtoupper('apps.khs_psup_po_logbook'));

        if (!$result) {
            $db_error = $this->oracle->error();
            throw new Exception("Terjadi error pada database dengan error code {$db_error['code']} dengan pesan {$db_error['message']}");
        }

        $row_result = $result->row();

        if (!count($row_result)) {
            throw new Exception('Tidak ditemukan data vendor name dengan pha segment 1 terkait');
        }

        return $row_result->vendor_name;
    }
}
