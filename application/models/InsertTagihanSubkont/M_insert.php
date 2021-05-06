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
        shipment_num,
        quantity_receive,
        quantity_bersih,
        uom_code,
        item_description_po,
        item_description_job,
        receipt_num,
        transaction_date,
        po_unit_price,
        total_price,
        vendor_name,
        transaction_id,
        po_num) values(" .
            $tagihan['SHIPMENT_NUM'] . ",'" .
            $tagihan['QTY_RECEIVE'] . ",'" .
            $tagihan['QTY_BERSIH'] . ",'" .
            $tagihan['UOM_CODE'] . "','" .
            $tagihan['ITEM_DESCRIPTION_PO'] . "','" .
            $tagihan['ITEM_DESCRIPTION_JOB'] . "','" .
            $tagihan['RECEIPT_NUM'] . "'," .
            "TO_TIMESTAMP('" . $tagihan['TRANSACTION_DATE'] . "','DD-MON-YY ')," .
            $tagihan['PO_UNIT_PRICE'] . "," .
            $tagihan['TOTAL_PRICE'] . ",'" .
            $tagihan['VENDOR_NAME'] . "'," .
            $tagihan['TRANSACTION_ID'] . "," .
            $tagihan['NO_PO'] . "
        )";
        $query = $this->db->query($sql);
        return $sql;
    }
    public function getData($param)
    {
        $response['data'] = $this->db->query("SELECT *
        FROM psub.psub_lppb_subkon p
        WHERE p.vendor_name = '$param'
        AND NOT EXISTS (select 1 from psub.psub_tagihan_subkon where transaction_id = p.transaction_id)")->result_array();
        $response['message'] = 'success';
        $response['success'] = true;

        if (empty($response['data'])) {
            $response = array(
                'data'        => [],
                'success' => false,
                'message' => 'Data Not Found'
            );
        }
        return $response;
        // $sql = "select * from psub.psub_lppb_subkon where vendor_name = '$param'";
        // $query = $this->db->query($sql);
        // return $query->result_array();
    }
    public function ListTagihan()
    {
        $sql = "select
        pts.nomor_tagihan,       
        pts.vendor_name,        
       count(pts.nomor_tagihan) jml_item,    
       sum(pts.total_price)total        
       from psub.psub_tagihan_subkon pts
       group by pts.nomor_tagihan, pts.vendor_name";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function ListTagihanbyNom($nom)
    {
        $sql = "select * from psub.psub_tagihan_subkon where nomor_tagihan = '$nom'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function getDatabyId($id)
    {
        $sql = "select * from psub.psub_lppb_subkon where id = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function InsertToPSUBTagihan($data, $transaction_date, $created_date)
    {
        if (!empty($data)) {
            $response['success'] = true;
            $this->db
                ->set('TRANSACTION_DATE', "TO_TIMESTAMP('$transaction_date','YYYY-MM-DD')", false)
                ->set('CREATION_DATE', "TO_TIMESTAMP('$created_date','YYYY-MM-DD')", false)
                ->set('LAST_UPDATE_DATE', "TO_TIMESTAMP('$created_date','YYYY-MM-DD')", false)
                ->insert('psub.psub_tagihan_subkon', $data);
        } else {
            $response['message'] = 'Failed Insert';
        }

        return $response;
    }
    public function ListTagihanbyTID($nom)
    {
        $sql = "select * from psub.psub_tagihan_subkon where transaction_id = $nom";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function getVendorName($name)
    {
        $sql = "SELECT DISTINCT a2.vendor_name,
        apss.address_line1
     || ' '
     || apss.city
     || ' '
     || apss.zip ADDRESS
FROM ap_suppliers a2, ap_supplier_sites_all apss
WHERE a2.vendor_id = apss.vendor_id
 AND a2.vendor_name = '$name'
 AND ROWNUM = 1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function getNomorTagihan($vendor)
    {
        $sql = "select distinct nomor_tagihan from psub.psub_tagihan_subkon where vendor_name = '$vendor'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function loginTagihanSubkon($usr)
    {
        $sql = "
            select psub.password from psub.psub_subkon_user as psub
            where psub.username = upper(trim('$usr'))
            ";
        $query = $this->db->query($sql);
        $row = $query->num_rows();
        if ($row == 1) {
            return true;
        } else {
            return false;
        }
    }

    function loginSubkon($usr, $pwd)
    {
        $sql = "
              select * from psub.psub_subkon_user as psub
              where psub.username = upper(trim('$usr'))
              and psub.password = '$pwd' 
      ";
        $query = $this->db->query($sql);
        $row = $query->num_rows();
        if ($row == 1) {
            return true;
        } else {
            return false;
        }
    }


    function getDetailSubkon($usr)
    {
        $sql = "select psub.* from psub.psub_subkon_user as psub
    where psub.username = upper(trim('$usr'))
    ";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
