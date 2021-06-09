<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_laporan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle', true);
        // $this->oracle_dev = $this->load->database('oracle_dev', true);
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
    
    public function getItem2($category, $bulan){
        $sql = "SELECT msib.segment1 item, msib.description, msib.inventory_item_id,
                        (SELECT SUM (NVL (kpimd.value_plan, 0)
                                    + NVL (kpimd.value_plan_month, 0)
                                    )
                        FROM khs_plan_item_monitoring kpim,
                                khs_plan_item_monitoring_date kpimd
                        WHERE kpim.plan_id = kpimd.plan_id
                            AND msib.inventory_item_id = kpim.inventory_item_id
                            AND kpim.MONTH = '$bulan' --'202104'
                            AND mkim.id_category || mcim.id_subcategory =
                                                        kpim.id_category || kpim.id_subcategory)
                                                                                        target,
                        ksi.id_category, ksi.id_subcategory, ksi.subcategory_name
                FROM khs_category_item_monitoring mcim,
                        khs_kategori_item_monitoring mkim,
                        (SELECT ksi.id_category || ksi.id_subcategory konek, ksi.id_category,
                                ksi.id_subcategory, ksi.subcategory_name
                        FROM khs_subcategory_item ksi) ksi,
                        mtl_system_items_b msib
                WHERE msib.inventory_item_id = mcim.inventory_item_id
                    AND msib.organization_id = mcim.organization_id
                    AND mcim.category_name = mkim.id_category
                    AND mcim.flag = 'Y'
                    AND ksi.konek(+) = mcim.category_name || mcim.id_subcategory
                    AND mkim.id_category = $category
                    order by 6,1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getsubcategory($kategori, $bulan){
        $sql = "SELECT   id_category, id_subcategory, subcategory_name, SUM (targetnya) target
                    FROM (SELECT mkim.id_category, mcim.id_subcategory, ksi.subcategory_name,
                                (SELECT SUM (NVL (kpimd.value_plan, 0) + NVL (kpimd.value_plan_month, 0))
                                    FROM khs_plan_item_monitoring kpim,
                                        khs_plan_item_monitoring_date kpimd
                                WHERE kpim.plan_id = kpimd.plan_id
                                    AND msib.inventory_item_id = kpim.inventory_item_id
                                    AND kpim.MONTH = '$bulan'
                                    AND mkim.id_category || mcim.id_subcategory = kpim.id_category || kpim.id_subcategory)targetnya
                            FROM khs_category_item_monitoring mcim,
                                khs_kategori_item_monitoring mkim,
                                (SELECT ksi.id_category || ksi.id_subcategory konek,
                                        ksi.id_subcategory, ksi.subcategory_name
                                    FROM khs_subcategory_item ksi) ksi,
                                mtl_system_items_b msib
                        WHERE msib.inventory_item_id = mcim.inventory_item_id
                            AND msib.organization_id = mcim.organization_id
                            AND mcim.category_name = mkim.id_category
                            AND mcim.flag = 'Y'
                            AND ksi.konek(+) = mcim.category_name || mcim.id_subcategory
                            AND mkim.id_category = $kategori)
                GROUP BY subcategory_name, id_category, id_subcategory, subcategory_name";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getSubinv($term){
        $sql = "select distinct msi.SECONDARY_INVENTORY_NAME
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
                and fin.kode = $kode $subinv";
        // echo "<pre>";print_r($sql);exit();
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getdataLaporanSP($kategori, $month){
        $sql = "select *
                from khs_qweb_penc_prod_sparepart sp
                where sp.ID_CATEGORY = $kategori
                and sp.BULAN = '$month'
                order by sp.ID_SUBCATEGORY, sp.ITEM, sp.TANGGAL";
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
    
    public function gettargetPlan($kategori, $subkategori, $inv, $bulan){
        $sql = "select kpimd.VALUE_PLAN_MONTH
                from khs_plan_item_monitoring kpim,
                khs_plan_item_monitoring_date kpimd
                where kpim.MONTH = '$bulan'
                and kpim.ID_CATEGORY = $kategori
                and kpim.ID_SUBCATEGORY = $subkategori
                and kpim.INVENTORY_ITEM_ID = '$inv'
                and kpim.PLAN_ID = kpimd.PLAN_ID";
                // echo "<pre>";print_r($sql);exit();
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    
    public function getdataLaporanCompletion($category, $bulan){
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

    public function getdataLaporanTransaksi($category, $bulan, $tujuan){
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
                and fin.subinv in ('FG-TKS')
                and fin.trf_subinv in ($tujuan)
                order by fin.DESCRIPTION, fin.CATEGORY_NAME, fin.SUBCATEGORY_NAME, fin.TANGGAL";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    




}
