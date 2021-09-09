<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_komisi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
        $this->personalia = $this->load->database('personalia', true);
    }
    public function getLineId($n)
    {
        $sql = "select * from KHS_KOMISI_PENJ_HEADERS where PROGRAM_ID = $n";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function InsertHeaderKomisi($header) //,$memo_date, $due_date)
    {
        $this->oracle
            // ->set('MEMO_DATE', "TO_TIMESTAMP('$memo_date', 'DD/MM/YY HH24:MI:SS')", false)
            // ->set('DUE_DATE', "TO_TIMESTAMP('$due_date', 'DD/MM/YY HH24:MI:SS')", false)
            ->insert('KHS_KOMISI_PENJ_HEADERS', $header);
    }
    public function InsertLineKomisi($line)
    {
        $this->oracle
            ->insert('KHS_KOMISI_PENJ_ITEM', $line);
    }
    public function CreateInvoice($program_id, $user)
    {
        $message = '';

        $sql = "BEGIN
        KHS_INV_KOMISI_PENJ(
                $program_id
                ,'$user'
                ,:response_hasil
            );   
        END;";

        $stmt = oci_parse($this->oracle->conn_id, $this->removeNewLine($sql));
        oci_bind_by_name($stmt, ':response_hasil', $message, 512, SQLT_CHR);
        oci_execute($stmt);

        // return $message;
    }
    private function removeNewLine($text)
    {
        return preg_replace('/\s\s+/', ' ', $text);
    }
    public function SelectNoMemo()
    {
        $sql = "select distinct MEMO_NUM, PROGRAM_ID from KHS_KOMISI_PENJ_HEADERS where INVOICED is NULL";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function UpdateInvoiced($id)
    {
        $sql = "update KHS_KOMISI_PENJ_HEADERS set INVOICED = 'Y' where PROGRAM_ID = $id";

        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function ValidasiMemo($memo)
    {
        $sql = "SELECT COUNT(*) hasil FROM KHS_KOMISI_PENJ_HEADERS WHERE MEMO_NUM =  '$memo'";
        $query = $this->oracle->query($sql);
        return $sql;
    }
}
