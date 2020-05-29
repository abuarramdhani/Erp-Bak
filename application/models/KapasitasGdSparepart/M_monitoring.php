<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoring extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getDataSPB($query) {
        $oracle = $this->load->database('oracle', true);
        $sql ="select to_char(jam_input, 'DD/MM/YYYY HH24:MI:SS') as jam_input, 
                tgl_dibuat, 
                to_char(jam_input, 'DD/MM/YYYY') as tgl_input, 
                to_char(jam_input, 'HH24:MI:SS') as jam_input2,
                jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                to_char(mulai_pelayanan, 'DD/MM/YYYY HH24:MI:SS') as mulai_pelayanan, 
                to_char(mulai_pelayanan, 'DD/MM/YYYY') as tgl_mulai_pelayanan, 
                to_char(mulai_pelayanan, 'HH24:MI:SS') as jam_mulai_pelayanan, 
                to_char(selesai_pelayanan, 'DD/MM/YYYY HH24:MI:SS') as selesai_pelayanan,waktu_pelayanan,
                to_char(selesai_pelayanan, 'DD/MM/YYYY') as tgl_selesai_pelayanan,
                to_char(selesai_pelayanan, 'HH24:MI:SS') as jam_selesai_pelayanan,
                to_char(mulai_pengeluaran, 'DD/MM/YYYY HH24:MI:SS') as mulai_pengeluaran, 
                to_char(mulai_pengeluaran, 'DD/MM/YYYY') as tgl_mulai_pengeluaran, 
                to_char(mulai_pengeluaran, 'HH24:MI:SS') as jam_mulai_pengeluaran, 
                to_char(selesai_pengeluaran, 'DD/MM/YYYY HH24:MI:SS') as selesai_pengeluaran, waktu_pengeluaran,
                to_char(selesai_pengeluaran, 'DD/MM/YYYY') as tgl_selesai_pengeluaran, 
                to_char(selesai_pengeluaran, 'HH24:MI:SS') as jam_selesai_pengeluaran, 
                to_char(mulai_packing, 'DD/MM/YYYY HH24:MI:SS') as mulai_packing, 
                to_char(selesai_packing, 'DD/MM/YYYY HH24:MI:SS') as selesai_packing, waktu_packing,
                to_char(mulai_packing, 'DD/MM/YYYY') as tgl_mulai_packing, 
                to_char(mulai_packing, 'HH24:MI:SS') as jam_mulai_packing, 
                to_char(selesai_packing, 'DD/MM/YYYY') as tgl_selesai_packing,
                to_char(selesai_packing, 'HH24:MI:SS') as jam_selesai_packing,
                urgent, pic_pelayan, pic_pengeluaran, pic_packing, bon
                from khs_tampung_spb
                $query
                and cancel is null
                order by urgent, tgl_dibuat";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataKurang($querykrg){
        $oracle = $this->load->database('oracle', true);
        $sql="select to_char(jam_input, 'DD/MM/YYYY HH24:MI:SS') as jam_input, 
                tgl_dibuat, bon,
                to_char(jam_input, 'DD/MM/YYYY') as tgl_input, 
                to_char(jam_input, 'HH24:MI:SS') as jam_input2,
                jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs, selesai_pengeluaran,
                selesai_pelayanan, selesai_packing, urgent, pic_pelayan, pic_pengeluaran, pic_packing
                from khs_tampung_spb
                $querykrg
                and cancel is null
                order by urgent, tgl_dibuat";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function getjmlGd($date) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT distinct no_document FROM KHS_MONITORING_GD_SP WHERE TO_CHAR(CREATION_DATE,'DD/MM/YYYY') between '$date' and '$date'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getjmlGd2($date) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT distinct no_document 
                FROM KHS_MONITORING_GD_SP
                where TO_CHAR(CREATION_DATE,'DD/MM/YYYY') between '$date' and '$date'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getcancel($date) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT * 
                FROM khs_tampung_spb
                where TO_CHAR(cancel,'DD/MM/YYYY') between '$date' and '$date'
                and cancel is not null";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getTransact($nospb) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT mtrh.request_number no_spb, msib.segment1 item, msib.description, mtrl.quantity,
                mmt.transaction_quantity, mmt.transaction_uom, mmt.SUBINVENTORY_CODE,
                (CASE
                        WHEN mtrl.quantity > mmt.transaction_quantity
                            THEN 'U'
                        ELSE NULL
                        END
                    ) ket
                FROM mtl_txn_request_headers mtrh,
                    mtl_txn_request_lines mtrl,
                    mtl_system_items_b msib,
                    mtl_material_transactions mmt
                WHERE mtrh.request_number = '$nospb'
                    AND mtrl.header_id = mtrh.header_id
                    AND mtrl.inventory_item_id = msib.inventory_item_id
                    AND mtrl.organization_id = msib.organization_id
                    AND mmt.move_order_line_id = mtrl.line_id
                    AND mmt.inventory_item_id = mtrl.inventory_item_id
                    AND (mmt.SUBINVENTORY_CODE like 'KLR%' OR mmt.SUBINVENTORY_CODE like 'STAGE%')";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataDOSPB($date1, $date2) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT kts.jam_input, mtrh.creation_date, kts.jenis_dokumen, kts.no_dokumen,
                        kts.jumlah_item, kts.jumlah_pcs, kts.urgent keterangan, kts.bon
                FROM khs_tampung_spb kts, mtl_txn_request_headers mtrh
                WHERE kts.CANCEL IS NULL
                    AND kts.no_dokumen = mtrh.request_number
                    AND (BON != 'PENDING' OR BON IS NULL)
                    AND TRUNC(kts.jam_input) BETWEEN to_date('$date1','DD/MM/YYYY') AND to_date('$date2','DD/MM/YYYY')
                    order by kts.urgent, kts.jam_input";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataPlyn($date1, $date2) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT  kts.jam_input, kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen,
                        COUNT (mtrl.inventory_item_id) jml_item_terlayani, 
                        SUM (mtrl.quantity_detailed) jml_pcs_terlayani,
                        TO_CHAR (kts.mulai_pelayanan, 'DD/MM/YYYY') tgl_mulai,
                        TO_CHAR (kts.mulai_pelayanan, 'HH24:MI:SS') jam_mulai,
                        TO_CHAR (kts.selesai_pelayanan, 'DD/MM/YYYY') tgl_selesai,
                        TO_CHAR (kts.selesai_pelayanan, 'HH24:MI:SS') jam_selesai,
                        kts.waktu_pelayanan, kts.pic_pelayan, kts.urgent keterangan, kts.bon
                FROM khs_tampung_spb kts,
                        mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl
                WHERE kts.CANCEL IS NULL
                    AND kts.no_dokumen = mtrh.request_number
                    AND mtrh.header_id = mtrl.header_id
                    AND mtrl.line_status <> 6
                    AND kts.mulai_pelayanan IS NOT NULL
                    AND kts.selesai_pelayanan IS NOT NULL
                    AND TRUNC(kts.selesai_pelayanan) BETWEEN to_date('$date1','DD/MM/YYYY') AND to_date('$date2','DD/MM/YYYY')
                GROUP BY kts.tgl_dibuat,
                        kts.jenis_dokumen,
                        kts.no_dokumen,
                        TO_CHAR (kts.mulai_pelayanan, 'DD/MM/YYYY'),
                        TO_CHAR (kts.mulai_pelayanan, 'HH24:MI:SS'),
                        TO_CHAR (kts.selesai_pelayanan, 'DD/MM/YYYY'),
                        TO_CHAR (kts.selesai_pelayanan, 'HH24:MI:SS'),
                        kts.waktu_pelayanan,
                        kts.pic_pelayan,
                        kts.urgent,
                        kts.bon,
                        kts.jam_input
                ORDER BY kts.urgent, kts.tgl_dibuat, kts.no_dokumen";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataKrgPlyn($date1, $date2) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT  kts.jam_input, kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen,
                        COUNT (mtrl.inventory_item_id) jml_item_terlayani,
                        SUM (mtrl.quantity) jml_pcs_terlayani, kts.urgent keterangan,
                        kts.bon
                FROM khs_tampung_spb kts,
                        mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl,
                        mtl_system_items_b msib
                WHERE kts.CANCEL IS NULL
                    AND kts.no_dokumen = mtrh.request_number
                    AND mtrh.header_id = mtrl.header_id
                    AND mtrl.inventory_item_id = msib.inventory_item_id
                    AND mtrl.organization_id = msib.organization_id
                --     AND kts.mulai_pelayanan IS NULL
                    AND kts.selesai_pelayanan IS NULL
                    AND mtrl.line_status <> 6
                    AND (kts.bon != 'PENDING' or kts.bon is null)
                    AND (TRUNC(kts.jam_input) <= to_date('$date2','DD/MM/RR') or selesai_packing is null)
                GROUP BY kts.tgl_dibuat,
                        kts.jenis_dokumen,
                        kts.no_dokumen,
                        kts.urgent,
                        kts.bon,
                        kts.jam_input
                ORDER BY kts.urgent, kts.tgl_dibuat --, kts.no_dokumen";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataPglr($date1, $date2) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT  kts.jam_input, kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen,
                        COUNT (mtrl.inventory_item_id) jml_item_dikeluarkan, 
                        SUM (mtrl.quantity_detailed) jml_pcs_dikeluarkan,
                        TO_CHAR (kts.mulai_pengeluaran, 'DD/MM/YYYY') tgl_mulai,
                        TO_CHAR (kts.mulai_pengeluaran, 'HH24:MI:SS') jam_mulai,
                        TO_CHAR (kts.selesai_pengeluaran, 'DD/MM/YYYY') tgl_selesai,
                        TO_CHAR (kts.selesai_pengeluaran, 'HH24:MI:SS') jam_selesai,
                        kts.waktu_pengeluaran, kts.pic_pengeluaran, kts.urgent keterangan, kts.bon
                FROM khs_tampung_spb kts,
                        mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl
                WHERE kts.CANCEL IS NULL
                    AND kts.no_dokumen = mtrh.request_number
                    AND mtrh.header_id = mtrl.header_id
                    AND mtrl.line_status <> 6
                    AND kts.mulai_pengeluaran IS NOT NULL
                    AND kts.selesai_pengeluaran IS NOT NULL
                    AND (kts.bon IS NULL OR kts.bon = 'BON')
                    AND TRUNC(kts.selesai_pengeluaran) BETWEEN to_date('$date1','DD/MM/YYYY') AND to_date('$date2','DD/MM/YYYY')
                GROUP BY kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen,
                        TO_CHAR (kts.mulai_pengeluaran, 'DD/MM/YYYY'),
                        TO_CHAR (kts.mulai_pengeluaran, 'HH24:MI:SS'),
                        TO_CHAR (kts.selesai_pengeluaran, 'DD/MM/YYYY'),
                        TO_CHAR (kts.selesai_pengeluaran, 'HH24:MI:SS'), 
                        kts.waktu_pengeluaran, kts.pic_pengeluaran, kts.urgent, kts.bon, kts.jam_input
                ORDER BY kts.urgent, kts.tgl_dibuat, kts.no_dokumen";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataKrgPglr($date1, $date2) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT  kts.jam_input, kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen,
                        COUNT (mtrl.inventory_item_id) jml_item_terlayani,
                        SUM (mtrl.quantity) jml_pcs_terlayani, kts.pic_pelayan,
                        kts.urgent keterangan, kts.bon
                FROM khs_tampung_spb kts,
                        mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl,
                        mtl_system_items_b msib
                WHERE kts.CANCEL IS NULL
                    AND kts.no_dokumen = mtrh.request_number
                    AND mtrh.header_id = mtrl.header_id
                    AND mtrl.inventory_item_id = msib.inventory_item_id
                    AND mtrl.organization_id = msib.organization_id
                    AND kts.selesai_pelayanan IS NOT NULL
                --     AND kts.mulai_pengeluaran IS NULL
                    AND kts.selesai_pengeluaran IS NULL
                    AND mtrl.line_status <> 6
                    AND (kts.bon IS NULL OR kts.bon != 'BON')
                    AND (TRUNC(kts.jam_input) <= to_date('$date2','DD/MM/RR') or selesai_packing is null)
                GROUP BY kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen, kts.urgent, kts.bon, 
                        kts.pic_pelayan, kts.jam_input
                ORDER BY kts.urgent, kts.tgl_dibuat, kts.no_dokumen";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataPck($date1, $date2) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT  kts.jam_input, kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen,
                        COUNT (mtrl.inventory_item_id) jml_item_packing, 
                        SUM (mtrl.quantity_detailed) jml_pcs_packing,
                        TO_CHAR (kts.mulai_packing, 'DD/MM/YYYY') tgl_mulai,
                        TO_CHAR (kts.mulai_packing, 'HH24:MI:SS') jam_mulai,
                        TO_CHAR (kts.selesai_packing, 'DD/MM/YYYY') tgl_selesai,
                        TO_CHAR (kts.selesai_packing, 'HH24:MI:SS') jam_selesai,
                        kts.waktu_packing, kts.pic_packing, kts.urgent keterangan, kts.bon
                FROM khs_tampung_spb kts,
                        mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl
                WHERE kts.CANCEL IS NULL
                    AND kts.no_dokumen = mtrh.request_number
                    AND mtrh.header_id = mtrl.header_id
                    AND mtrl.quantity_delivered is not null
                --     AND kts.mulai_packing IS NOT NULL
                    AND kts.selesai_packing IS NOT NULL
                    AND (kts.bon IS NULL OR kts.bon = 'BEST')
                    AND TRUNC(kts.selesai_packing) BETWEEN to_date('$date1','DD/MM/YYYY') AND to_date('$date2','DD/MM/YYYY')
                GROUP BY kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen,
                        TO_CHAR (kts.mulai_packing, 'DD/MM/YYYY'),
                        TO_CHAR (kts.mulai_packing, 'HH24:MI:SS'),
                        TO_CHAR (kts.selesai_packing, 'DD/MM/YYYY'),
                        TO_CHAR (kts.selesai_packing, 'HH24:MI:SS'), kts.waktu_packing,
                        kts.pic_packing, kts.urgent, kts.bon, kts.jam_input
                ORDER BY kts.urgent, kts.tgl_dibuat, kts.no_dokumen";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataKrgPck($date1, $date2) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT  kts.jam_input, kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen,
                        COUNT (mtrl.inventory_item_id) jml_item_terlayani,
                        SUM (mtrl.quantity) jml_pcs_terlayani,
                        kts.urgent keterangan, kts.bon, kts.pic_pengeluaran
                FROM khs_tampung_spb kts,
                        mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl,
                        mtl_system_items_b msib
                WHERE kts.CANCEL IS NULL
                    AND kts.no_dokumen = mtrh.request_number
                    AND mtrh.header_id = mtrl.header_id
                    AND mtrl.inventory_item_id = msib.inventory_item_id
                    AND mtrl.organization_id = msib.organization_id
                    AND kts.selesai_pengeluaran IS NOT NULL
                --     AND kts.mulai_packing IS NULL
                    AND kts.selesai_packing IS NULL
                    AND mtrl.line_status <> 6
                    AND (kts.bon IS NULL OR bon = 'BEST')
                    AND (TRUNC(kts.jam_input) <= to_date('$date2','DD/MM/RR') or selesai_packing is null)
                GROUP BY kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen, kts.urgent, kts.bon, kts.jam_input, kts.pic_pengeluaran
                ORDER BY kts.urgent, kts.tgl_dibuat, kts.no_dokumen";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataselesai($date1, $date2) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT   kts.tgl_dibuat, kts.selesai_packing, kts.jenis_dokumen,
                        kts.no_dokumen, COUNT (mtrl.inventory_item_id) jumlah_item, SUM (mtrl.quantity) jumlah_pcs,
                        COUNT (mtrl.inventory_item_id) jml_item_selesai,
                        SUM (mtrl.quantity_delivered) jml_pcs_selesai, kts.urgent keterangan,
                        kts.bon
                FROM khs_tampung_spb kts,
                        mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl
                WHERE kts.CANCEL IS NULL
                    AND kts.selesai_packing IS NOT NULL
                    AND kts.no_dokumen = mtrh.request_number
                    AND mtrh.header_id = mtrl.header_id
                    AND TRUNC(kts.selesai_packing) BETWEEN to_date('$date1','DD/MM/YYYY') AND to_date('$date2','DD/MM/YYYY')
                GROUP BY kts.tgl_dibuat,
                        kts.selesai_packing,
                        kts.jenis_dokumen,
                        kts.no_dokumen,
                        kts.jumlah_item,
                        kts.jumlah_pcs,
                        kts.urgent,
                        kts.bon
                ORDER BY kts.urgent, kts.tgl_dibuat, kts.no_dokumen";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }


    public function dataKurangselesai($date1, $date2) {
        $oracle = $this->load->database('oracle', true);
        $sql ="select * from
                (SELECT kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen, msib.segment1 item,
                                        msib.description, mtrl.quantity, mtrl.quantity_delivered,
                                        (mtrl.quantity - mtrl.quantity_delivered) kurang
                                FROM khs_tampung_spb kts,
                                        mtl_txn_request_headers mtrh,
                                        mtl_txn_request_lines mtrl,
                                        mtl_system_items_b msib
                                WHERE kts.CANCEL IS NULL
                                    AND kts.no_dokumen = mtrh.request_number
                                    AND mtrh.header_id = mtrl.header_id
                                    AND mtrl.inventory_item_id = msib.inventory_item_id
                                    AND mtrl.organization_id = msib.organization_id
                                    AND (mtrl.quantity <> mtrl.quantity_delivered or mtrl.quantity_delivered is null)
                                    AND mtrl.quantity <> 0
                                    AND mtrl.line_status <> 6
                                    AND kts.selesai_packing IS NOT NULL
                                    AND TRUNC(kts.selesai_packing) BETWEEN to_date('$date1','DD/MM/YYYY') AND to_date('$date2','DD/MM/YYYY')
                --                    order by msib.segment1
                UNION
                SELECT kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen, msib.segment1 item,
                                        msib.description, wdd.SRC_REQUESTED_QUANTITY quantity, mtrl.quantity_delivered,
                                        (wdd.SRC_REQUESTED_QUANTITY - mtrl.quantity_delivered) kurang
                                FROM khs_tampung_spb kts,
                                        wsh_delivery_details wdd,
                                        mtl_txn_request_headers mtrh,
                                        mtl_txn_request_lines mtrl,
                                        mtl_system_items_b msib
                                WHERE kts.CANCEL IS NULL
                                    AND kts.no_dokumen = mtrh.request_number
                                    AND mtrh.header_id = mtrl.header_id
                                    AND mtrl.inventory_item_id = msib.inventory_item_id
                                    AND mtrl.organization_id = msib.organization_id
                                    and to_char(wdd.batch_id) = mtrh.request_number
                                    and wdd.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
                                    AND (wdd.SRC_REQUESTED_QUANTITY <> mtrl.quantity_delivered or mtrl.quantity_delivered is null)
                                    AND wdd.SRC_REQUESTED_QUANTITY <> 0
                                    AND mtrl.line_status <> 6
                                    AND kts.selesai_packing IS NOT NULL
                                    AND TRUNC(kts.selesai_packing) BETWEEN to_date('$date1','DD/MM/YYYY') AND to_date('$date2','DD/MM/YYYY'))
                                    order by 4";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function diCancel($date1, $date2) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen, msib.segment1 item,
                        msib.description, mtrl.quantity, mtrl.quantity_delivered,
                        (mtrl.quantity - mtrl.quantity_delivered) kurang
                FROM khs_tampung_spb kts,
                        mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl,
                        mtl_system_items_b msib
                WHERE kts.CANCEL IS NULL
                    AND kts.no_dokumen = mtrh.request_number
                    AND mtrh.header_id = mtrl.header_id
                    AND mtrl.inventory_item_id = msib.inventory_item_id
                    AND mtrl.organization_id = msib.organization_id
                    AND (mtrl.quantity <> mtrl.quantity_delivered or mtrl.quantity_delivered is null)
                    AND kts.selesai_packing IS NOT NULL
                    AND mtrl.line_status = 6
                   -- AND mtrh.REQUEST_NUMBER = ''
                AND TRUNC(kts.selesai_packing) BETWEEN to_date('$date1','DD/MM/YYYY') AND to_date('$date2','DD/MM/YYYY')
                UNION
                SELECT kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen, msib.segment1 item,
                        msib.description, wdd.SRC_REQUESTED_QUANTITY quantity, mtrl.quantity_delivered,
                        (wdd.SRC_REQUESTED_QUANTITY - mtrl.quantity_delivered) kurang
                FROM khs_tampung_spb kts,
                        wsh_delivery_details wdd,
                        mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl,
                        mtl_system_items_b msib
                WHERE kts.CANCEL IS NULL
                    AND kts.no_dokumen = mtrh.request_number
                    AND mtrh.header_id = mtrl.header_id
                    AND mtrl.inventory_item_id = msib.inventory_item_id
                    AND mtrl.organization_id = msib.organization_id
                    AND (wdd.SRC_REQUESTED_QUANTITY <> mtrl.quantity_delivered or mtrl.quantity_delivered is null)
                    and to_char(wdd.batch_id) = mtrh.request_number
                    and wdd.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
                    AND kts.selesai_packing IS NOT NULL
                    AND mtrl.line_status = 6
                    --AND mtrh.REQUEST_NUMBER = ''
                AND TRUNC(kts.selesai_packing) BETWEEN to_date('$date1','DD/MM/YYYY') AND to_date('$date2','DD/MM/YYYY')
                order by 4";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }
    
    public function jml_pending2() {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT * FROM KHS_TAMPUNG_SPB where bon = 'PENDING' and cancel is null";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getDataColly($no){
        $oracle = $this->load->database('khs_packing', true);
        $sql ="select * from sp_packing_trx where nomor_do = '$no'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function dataKeterangan($date1, $date2) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT   *
                FROM khs_tampung_spb
                WHERE TRUNC(jam_input) BETWEEN to_date('$date1','DD/MM/YYYY') AND to_date('$date2','DD/MM/YYYY')
                AND CANCEL IS NULL
                ORDER BY jam_input";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }
    
    public function inicancel($date1, $date2) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT   *
                FROM khs_tampung_spb
                WHERE TRUNC(jam_input) BETWEEN to_date('$date1','DD/MM/YYYY') AND to_date('$date2','DD/MM/YYYY')
                AND cancel is not null
                ORDER BY jam_input";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    // public function datapack($date1, $date2) {
    //     $oracle = $this->load->database('oracle', true);
    //     $sql ="SELECT   *
    //             FROM khs_tampung_spb
    //             WHERE TRUNC(mulai_packing) BETWEEN to_date('$date1','DD/MM/YYYY') AND to_date('$date2','DD/MM/YYYY')
    //             AND cancel is null
    //             AND selesai_packing is not null
    //             ORDER BY jam_input";
    //     $query = $oracle->query($sql);
    //     return $query->result_array();
    //     // echo $sql;
    // }
    
    // public function dikerjakan() {
    //     $oracle = $this->load->database('oracle', true);
    //     $sql ="select * from khs_tampung_spb 
    //     where mulai_packing is not null
    //     and selesai_packing is null ";
    //     $query = $oracle->query($sql);
    //     return $query->result_array();
    //     // echo $sql;
    // }


}

