<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_rekapbon extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getBill()
    {
        $oracle = $this->load->database("oracle",true);
        $query = $oracle->query("
            select distinct
                aia.invoice_num
                ,aia.invoice_type_lookup_code
                ,aia.invoice_currency_code
                ,aia.invoice_amount
                ,aia.amount_paid
                ,aia.invoice_date
                ,aila.line_type_lookup_code
                ,aila.description
                ,aila.amount
            from
                ap_invoices_all aia
                ,ap_invoice_lines_all aila
                ,ap_suppliers asa
                ,ap_supplier_sites_all assa
            where
                1 = 1
                and aia.invoice_id = aila.invoice_id
                and aia.vendor_id = asa.vendor_id
                and asa.vendor_name = 'KHS Employee'
                and aia.cancelled_date is null
                and (aia.INVOICE_AMOUNT <> aia.AMOUNT_PAID or aia.AMOUNT_PAID is null)
                and aia.invoice_type_lookup_code = 'PREPAYMENT'
                and asa.vendor_id = assa.vendor_id
            order by 1
        ");

        return $query->result_array();
    }

    public function getEmployee($noind)
    {
        $personalia = $this->load->database("personalia",true);
        $query = $personalia->query("
            select 
                emp.noind,
                emp.nama,
                emp.jabatan,
                seksi.dept,
                seksi.bidang,
                seksi.unit,
                seksi.seksi 
            from 
                hrd_khs.v_hrd_khs_tpribadi emp 
            join 
                hrd_khs.tseksi seksi on emp.kodesie = seksi.kodesie 
            where  
                emp.noind = '$noind'
        ");
        
        return $query->result_array();
    }

}