<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pelayanan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function tampilhariini() {
        $oracle = $this->load->database('oracle', true);
        $sql = "select to_char(jam_input, 'DD/MM/YYYY HH24:MI:SS') as jam_input, 
                tgl_dibuat, to_char(mulai_pelayanan, 'HH24:MI:SS') as mulai_pelayanan, pic_pelayan,
                jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs, selesai_pelayanan, urgent
                from khs_tampung_spb
                where selesai_pelayanan is null
                order by urgent, tgl_dibuat";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataPelayanan($date) {
        $oracle = $this->load->database('oracle', true);
        $sql = "select to_char(jam_input, 'DD/MM/YYYY HH24:MM:SS') as jam_input, 
                tgl_dibuat,
                jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                to_char(mulai_pelayanan, 'DD/MM/YYYY HH24:MI:SS') as mulai_pelayanan, 
                to_char(mulai_pelayanan, 'HH24:MI:SS') as jam_mulai, 
                to_char(selesai_pelayanan, 'HH24:MI:SS') as jam_selesai,
                to_char(selesai_pelayanan, 'DD/MM/YYYY HH24:MI:SS') as selesai_pelayanan,
                waktu_pelayanan, urgent, pic_pelayan
                from khs_tampung_spb
                where TO_CHAR(selesai_pelayanan,'DD/MM/YYYY') between '$date' and '$date'
                order by urgent, tgl_dibuat";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function SavePelayanan($date, $jenis, $nospb, $pic){
        $oracle = $this->load->database('oracle', true);
        $sql="update khs_tampung_spb set mulai_pelayanan = TO_TIMESTAMP('$date', 'DD-MM-YYYY HH24:MI:SS'), pic_pelayan = '$pic'
                where jenis_dokumen = '$jenis' and no_dokumen = '$nospb'";
        $query = $oracle->query($sql);         
        $query2 = $oracle->query('commit');          
        // echo $sql; 
    }

    public function SelesaiPelayanan($date, $jenis, $nospb, $wkt){
        $oracle = $this->load->database('oracle', true);
        $sql="update khs_tampung_spb set selesai_pelayanan = TO_TIMESTAMP('$date', 'DD-MM-YYYY HH24:MI:SS'), waktu_pelayanan = '$wkt'
                where jenis_dokumen = '$jenis' and no_dokumen = '$nospb'";
        $query = $oracle->query($sql);            
        $query2 = $oracle->query('commit');       
        // echo $sql; 
    }

    public function saveWaktu($jenis, $nospb, $query){
        $oracle = $this->load->database('oracle', true);
        $sql="update khs_tampung_spb $query
                where jenis_dokumen = '$jenis' and no_dokumen = '$nospb'";
        $query = $oracle->query($sql);  
        $query2 = $oracle->query('commit');                 
        // echo $sql; 
    }

    public function getStatus($noSPB) {
        $oracle = $this->load->database('oracle', true);
        $sql = " SELECT mtrh.request_number no_do_spb, msib.segment1 item, msib.description,
        mtrl.uom_code, mmtt.transaction_quantity qty_allocate,
        (SELECT DECODE (wdd.released_status,
                        'B', 'Backordered',
                        'C', 'Shipped',
                        'D', 'Cancelled',
                        'N', 'Not Ready for Release',
                        'R', 'Ready to Release',
                        'S', 'Released to Warehouse',
                        'X', 'Not Applicable',
                        'Y', 'Staged'
                       )
           FROM wsh_delivery_details wdd
          WHERE mtrh.request_number = TO_CHAR (wdd.batch_id) AND ROWNUM = 1) status_shipment,
        mmtt.creation_date tgl_allocate, mp.organization_code,
        (SELECT ooha.order_number
           FROM wsh_delivery_details wdd, oe_order_headers_all ooha
          WHERE mtrh.request_number = TO_CHAR (wdd.batch_id)
            AND wdd.source_header_id = ooha.header_id
            AND ROWNUM = 1) ket
   FROM mtl_txn_request_headers mtrh,
        mtl_txn_request_lines mtrl,
        mtl_system_items_b msib,
        mtl_material_transactions_temp mmtt,
        mtl_parameters mp
  WHERE mtrh.header_id = mtrl.header_id
    AND mtrl.inventory_item_id = msib.inventory_item_id
    AND mtrl.organization_id = msib.organization_id
    AND mmtt.move_order_line_id = mtrl.line_id
    AND mmtt.organization_id = mp.organization_id
    AND mtrh.request_number = '$noSPB'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

}