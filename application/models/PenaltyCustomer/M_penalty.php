<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_penalty extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }
    function DataVendorPenalty()
    {
        $sql = "SELECT * FROM khs_penalty_web_summary";
        $query = $this->oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }
    public function DataVendorPenaltybyrelasiId($relasi_id)
    {
        $sql = "SELECT * FROM khs_penalty_web_detail where RELASI_ID = '$relasi_id'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }
    public function ReciptMethod($org)
    {
        $sql = "SELECT * FROM khs_ar_receipt_method where ORG_ID = $org";
        $query = $this->oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }
    public function CreateMiscRecipt($inv_num, $org_id, $nom_recipt, $recipt_method, $receipt_date, $comments, $induk)
    {
        $message = '';

        $sql = "BEGIN
        khs_create_misc_receipt(
            $org_id
            ,'$inv_num'
            ,$nom_recipt
            ,TO_DATE('$receipt_date', 'yyyy/mm/dd')
            ,TO_DATE('$receipt_date', 'yyyy/mm/dd')
            ,$recipt_method
            ,'$comments'
            ,'$induk'          
            ,:response_hasil
        );
        END;";

        $stmt = oci_parse($this->oracle->conn_id, $this->removeNewLine($sql));
        oci_bind_by_name($stmt, ':response_hasil', $message, 512, SQLT_CHR);
        oci_execute($stmt);

        return $message;
    }
    private function removeNewLine($text)
    {
        return preg_replace('/\s\s+/', ' ', $text);
    }
    public function ReciptMethod2($term)
    {
        $sql = "SELECT * FROM khs_ar_receipt_method";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
}
