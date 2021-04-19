<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_insert extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }
    public function getdatatagihan()
    {
        $sql = "select * from khs_tagihan_subkon_v";
        $query = $this->oracle->query($sql);
        return $query->result_array();
        // return $sql;

    }
    public function delettagihan()
    {
        $sql = "delete from psub.psub_lppb_subkon";
        $query = $this->db->query($sql);
        return $sql;
    }
    public function InsertTagihan($tagihan)
    {
        $sql = "insert into psub.psub_lppb_subkon (
        quantity_bersih,
        uom_code,
        item_description_po,
        item_description_job,
        receipt_num,
        transaction_date,
        po_unit_price,
        total_price,
        vendor_name,
        transaction_id) values(" .
            $tagihan['QTY_BERSIH'] . ",'" .
            $tagihan['UOM_CODE'] . "','" .
            $tagihan['ITEM_DESCRIPTION_PO'] . "','" .
            $tagihan['ITEM_DESCRIPTION_JOB'] . "','" .
            $tagihan['RECEIPT_NUM'] . "'," .
            "TO_TIMESTAMP('" . $tagihan['TRANSACTION_DATE'] . "','DD-MON-YY ')," .
            $tagihan['PO_UNIT_PRICE'] . "," .
            $tagihan['TOTAL_PRICE'] . ",'" .
            $tagihan['VENDOR_NAME'] . "'," .
            $tagihan['TRANSACTION_ID'] . "
        )";
        $query = $this->db->query($sql);
        return $sql;
    }
}
