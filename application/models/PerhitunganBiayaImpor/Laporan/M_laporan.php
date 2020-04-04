<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_laporan extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function getAdditionalCost($reqId)
    {
        $oracle = $this->load->database('oracle',true);
        $query = $oracle->query("select * from KHS_BIAYA_IMPOR where REQUEST_ID='$reqId'");
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

}