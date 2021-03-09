<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_laporan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle', true);
        $this->oracle_dev = $this->load->database('oracle_dev', true);
    }
    
    public function getCategory($term){
        $sql = "select * from khs_kategori_item_monitoring $term";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    
    public function getItem($category, $inv, $subcategory){
        $sql = "select * 
                from khs_category_item_monitoring
                where category_name = '$category'
                and inventory_item_id = $inv
                $subcategory";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getSubinv($term){
        $sql = "select msi.SECONDARY_INVENTORY_NAME
                from mtl_secondary_inventories msi
                where msi.DISABLE_DATE is null
                and msi.SECONDARY_INVENTORY_NAME like '%$term%'
                order by 1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getdataLaporan($kategori, $month, $subinv, $kode){
        $sql = "select distinct
                    fin.item
                    ,fin.inventory_item_id
                    ,fin.description
                    ,fin.id_category
                    ,fin.category_name
                    ,fin.ID_SUBCATEGORY
                    ,fin.SUBCATEGORY_NAME
                    ,fin.subinv
                    ,fin.trf_subinv
                    ,fin.tanggal
                    ,fin.bulan
                    ,sum (fin.qty) over (partition by category_name,item,tanggal) qty
                    ,sum (fin.qty) over (partition by category_name,item,bulan) real_prod
                    ,fin.TARGET
                    ,nvl (sum (fin.qty) over (partition by category_name,item,bulan) / target *100,0) kecapaian_target
                from khs_qweb_penc_prod fin
                where fin.BULAN = '$month'
                and fin.ID_CATEGORY = '$kategori'
                and fin.kode = $kode $subinv
                order by fin.CATEGORY_NAME, fin.SUBCATEGORY_NAME, fin.TANGGAL";
        // echo "<pre>";print_r($sql);exit();
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    
    public function getdataLaporanSubcategory($kategori, $month, $subinv, $kode){
        $sql = "select distinct
                    fin.ID_SUBCATEGORY
                    ,fin.SUBCATEGORY_NAME
                from khs_qweb_penc_prod fin
                where fin.BULAN = '$month'
                and fin.ID_CATEGORY = '$kategori'
                and fin.kode = $kode $subinv";
                // echo "<pre>";print_r($sql);exit();
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    
    public function getdataLaporanCompletion($category){
        $bulan = date('m/Y');
        $sql = "select distinct
                    fin.item
                    ,fin.inventory_item_id
                    ,fin.description
                    ,fin.id_category
                    ,fin.category_name
                    ,fin.ID_SUBCATEGORY
                    ,fin.SUBCATEGORY_NAME
                    ,fin.subinv
                    ,fin.trf_subinv
                    ,fin.tanggal
                    ,fin.bulan
                    ,sum (fin.qty) over (partition by category_name,item,tanggal) qty
                    ,sum (fin.qty) over (partition by category_name,item,bulan) real_prod
                    ,fin.TARGET
                    ,nvl (sum (fin.qty) over (partition by category_name,item,bulan) / target *100,0) kecapaian_target
                from khs_qweb_penc_prod fin
                where fin.BULAN = '$bulan'
                and fin.id_category = '$category'
                and fin.kode = 2
                order by fin.CATEGORY_NAME, fin.SUBCATEGORY_NAME, fin.TANGGAL";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getdataLaporanTransaksi($category){
        $bulan = date('m/Y');
        $sql = "select distinct
                    fin.item
                    ,fin.inventory_item_id
                    ,fin.description
                    ,fin.id_category
                    ,fin.category_name
                    ,fin.ID_SUBCATEGORY
                    ,fin.SUBCATEGORY_NAME
                    ,fin.subinv
                    ,fin.trf_subinv
                    ,fin.tanggal
                    ,fin.bulan
                    ,sum (fin.qty) over (partition by category_name,item,tanggal) qty
                    ,sum (fin.qty) over (partition by category_name,item,bulan) real_prod
                    ,fin.TARGET
                    ,nvl (sum (fin.qty) over (partition by category_name,item,bulan) / target *100,0) kecapaian_target
                from khs_qweb_penc_prod fin
                where fin.BULAN = '$bulan'
                and fin.id_category = '$category'
                and fin.kode = 1
                and fin.subinv in ('INT-ASSY', 'INT-PAINT', 'FG-TKS', 'INT-WELD')
                and fin.trf_subinv in ('INT-ASSY', 'INT-PAINT', 'FG-TKS', 'INT-WELD')
                order by fin.CATEGORY_NAME, fin.SUBCATEGORY_NAME, fin.TANGGAL";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    




}
