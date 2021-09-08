<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_laporan extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function getAdditionalCost($reqId, $data_item=null)
    {
        $oracle = $this->load->database('oracle',true);
        if($data_item)
        {
            $query = $oracle->query("
            select
                data_item.sort_num,
                kbi.*
            from
                khs_biaya_impor kbi,
                (select
                    rownum sort_num, 
                    trim(regexp_substr('$data_item','[^,]+', 1, level) ) item 
                from dual 
                connect by regexp_substr('$data_item', '[^,]+', 1, level) is not null
                order by level) data_item
            where
                replace(kbi.deskripsi, '  ', ' ') = replace(data_item.item, '  ', ' ')
                and kbi.request_id = '$reqId'
            order by 1
            ");
        } else {
            $query = $oracle->query("select * from KHS_BIAYA_IMPOR where REQUEST_ID='$reqId'");
        }
        return $query->result_array();
    }

    public function getDetailPO($reqId)
    {
        $oracle = $this->load->database('oracle',true);
        $query = $oracle->query("select * from KHS_BIAYA_IMPOR_PO where REQUEST_ID='$reqId'");
        return $query->result_array();
    }

    public function getDetail($reqId)
    {
        $oracle = $this->load->database('oracle',true);
        $query = $oracle->query("select * from KHS_BIAYA_IMPOR where REQUEST_ID='$reqId'");
        return $query->result_array();
    }

    public function getBeaMasuk($reqId)
    {
        $oracle = $this->load->database('oracle',true);
        $query = $oracle->query("SELECT * from KHS_BIAYA_IMPOR where REQUEST_ID='$reqId' AND DESKRIPSI = 'BEA MASUK'");
        return $query->result_array();
    }

    public function updateDataPO($reqid,$kodebarang,$rate)
    {
        $oracle = $this->load->database('oracle',true);
        $oracle->where('REQUEST_ID',$reqid);
        $oracle->where('KODE_BARANG',$kodebarang);
        $oracle->update('KHS_BIAYA_IMPOR_PO',$rate);
    }

    public function updateDataLocalTransport($reqid,$localTransport)
    {
        $oracle = $this->load->database('oracle',true);
        $oracle->where('REQUEST_ID',$reqid);
        $oracle->where('DESKRIPSI','Local Transport and Shipping');
        $oracle->update('KHS_BIAYA_IMPOR',$localTransport);
    }

    public function tambahAdditionInfo($addInfo)
    {
        $oracle = $this->load->database('oracle',true);
        $oracle->insert('KHS_BIAYA_IMPOR',$addInfo);
    }

    public function updateDataBiayaSurvey($reqid,$biayaSurvey)
    {
        $oracle = $this->load->database('oracle',true);
        $oracle->where('REQUEST_ID',$reqid);
        $oracle->where('DESKRIPSI','Biaya Survey');
        $oracle->update('KHS_BIAYA_IMPOR',$biayaSurvey);
    }

    public function updateAdditionalCost($reqid,$additional_cost)
    {
        $oracle = $this->load->database('oracle',true);
        $oracle->where('REQUEST_ID',$reqid);
        $oracle->update('KHS_BIAYA_IMPOR',$additional_cost);
    }

    public function getHistory()
    {
        $oracle = $this->load->database('oracle',true);
        $query = $oracle->query("SELECT
        DISTINCT bi.REQUEST_ID,
        bi.NO_URUT_PERHITUNGAN,
        bip.VENDOR_NAME,
        bi.NO_BL,
        bip.NO_PO
    FROM
        KHS_BIAYA_IMPOR bi,
        KHS_BIAYA_IMPOR_PO bip
    WHERE
        bi.REQUEST_ID = bip.REQUEST_ID");

        return $query->result_array();
    }

    public function HapusAdditionalCost($request_id,$deskripsi)
    {
        $oracle = $this->load->database('oracle',true);
        $oracle->where('REQUEST_ID',$request_id);
        $oracle->where('DESKRIPSI',$deskripsi);
        $oracle->delete('KHS_BIAYA_IMPOR');
    }

    public function HapusLine($kode_barang,$no_po,$qty_po,$io,$request_id)
    {
        $oracle = $this->load->database('oracle',true);
        $oracle->where('KODE_BARANG',$kode_barang);
        $oracle->where('NO_PO',$no_po);
        $oracle->where('QTY_PO',$qty_po);
        $oracle->where('IO',$io);
        $oracle->where('REQUEST_ID',$request_id);
        $oracle->delete('KHS_BIAYA_IMPOR_PO');
    }

    public function getnopo($request_id)
    {
        $oracle = $this->load->database('oracle',true);
        $query = $oracle->query("SELECT
        rtrim (xmlagg (xmlelement (e, to_char(NO_PO ) || ',')).extract ('//text()'), ',') NO_PO
        from      
        (select distinct 
        no_po 
        from 
        khs_biaya_impor_po
        where
        REQUEST_ID = $request_id
        )");

        return $query->result_array();
    }
    public function getVendor($request_id)
    {
        $oracle = $this->load->database('oracle',true);
        $query = $oracle->query("SELECT
        rtrim (xmlagg (xmlelement (e, to_char(vendor_name ) || ' | ')).extract ('//text()'), ',') vendor_name
        from      
        (select distinct 
        vendor_name 
        from 
        khs_biaya_impor_po
        where
        REQUEST_ID = $request_id
        )");

        return $query->result_array();
    }

    public function EditAdditionalCost($request_id, $deskripsi, $price)
    {
        $oracle = $this->load->database('oracle',true);
        $oracle->where('DESKRIPSI',$deskripsi);
        $oracle->where('REQUEST_ID',$request_id);
        $oracle->update('KHS_BIAYA_IMPOR', array('HARGA' => $price, ));
    }

    public function get_location_code($po){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT string_agg (location_code) location_code
                  FROM (SELECT DISTINCT hl.location_code
                          FROM po_headers_all pha,
                               po_line_locations_all plla,
                               hr_locations_all hl
                         WHERE pha.po_header_id = plla.po_header_id
                           AND plla.ship_to_location_id = hl.location_id
                           AND pha.segment1 IN ($po))";
        $data = $oracle->query($sql);
        return $data->result_array();
    }

}