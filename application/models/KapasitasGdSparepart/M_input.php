<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_input extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function dataSPB($noSPB) {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT 'SPB' jenis_dokumen, mtrh.request_number no_dokumen,
                        msib.segment1 item, msib.description item_desc, mtrl.quantity,
                        mtrh.creation_date mtrl
                FROM mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl,
                        mtl_system_items_b msib
                --                hr_organization_units_v hou
                WHERE mtrh.header_id = mtrl.header_id
                    AND mtrh.organization_id = mtrl.organization_id
                    AND msib.inventory_item_id = mtrl.inventory_item_id
                --            AND hou.organization_id = mtrh.attribute1
                    AND msib.organization_id = 81
                    AND NOT EXISTS (
                    SELECT mtrh1.request_number
                        FROM mtl_txn_request_headers mtrh1, wsh_delivery_details wdd1
                    WHERE mtrh1.request_number = TO_CHAR (wdd1.batch_id)
                        AND mtrh1.request_number = mtrh.request_number)
                    AND mtrh.request_number = '$noSPB'
                UNION ALL
                SELECT DISTINCT 'DOSP' jenis_dokumen, mtrh.request_number no_dokumen,
                                msib.segment1 item, msib.description item_desc, mtrl.quantity,
                                mtrh.creation_date mtrl
                            FROM mtl_txn_request_headers mtrh,
                                mtl_txn_request_lines mtrl,
                                wsh_delivery_details wdd,
                                mtl_system_items_b msib
                        WHERE mtrh.request_number = TO_CHAR (wdd.batch_id)
                            AND mtrh.header_id = mtrl.header_id
                            AND mtrh.organization_id = mtrl.organization_id
                            AND msib.inventory_item_id = mtrl.inventory_item_id
                            AND msib.organization_id = 81
                            AND mtrh.request_number = '$noSPB'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }

    public function cekData($noSPB) {
        $oracle = $this->load->database('oracle', true);
        $sql = "select to_char(jam_input, 'DD/MM/YYYY HH24:MI:SS') as jam_input, 
        jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs
        from khs_tampung_spb
        where no_dokumen = '$noSPB'
        order by jam_input desc";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }


    public function getData($date) {
        $oracle = $this->load->database('oracle', true);
        $sql = "select tgl_dibuat, 
        jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs, urgent, bon
        from khs_tampung_spb
        where TO_CHAR(jam_input,'DD/MM/YYYY') between '$date' and '$date'
        order by urgent, tgl_dibuat";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function saveDataSPB($jam, $jenis_dokumen, $no_dokumen, $jml_item, $jml_pcs, $urgent, $tgl_dibuat, $bon) {
        $oracle = $this->load->database('oracle', true);
        $sql = "insert into khs_tampung_spb (JAM_INPUT, JENIS_DOKUMEN, NO_DOKUMEN, JUMLAH_ITEM, JUMLAH_PCS, URGENT, TGL_DIBUAT, BON)
                VALUES (TO_TIMESTAMP('$jam', 'DD-MM-YYYY HH24:MI:SS'), '$jenis_dokumen', '$no_dokumen', '$jml_item', '$jml_pcs', '$urgent', '$tgl_dibuat', '$bon')";
        $query = $oracle->query($sql);
        $query2 = $oracle->query('commit');
        // echo $sql;
    }

    public function hapusData(){
        $oracle = $this->load->database('oracle', true);
        $sql = "delete from khs_tampung_spb where jenis_dokumen is null and no_dokumen is null";
        $query = $oracle->query($sql);
        $query2 = $oracle->query('commit');
        // echo $sql;
    }

    public function cancelSPB($jenis, $nomor, $date){
        $oracle = $this->load->database('oracle', true);
        $sql = "update khs_tampung_spb set cancel = TO_TIMESTAMP('$date', 'DD-MM-YYYY HH24:MI:SS') where jenis_dokumen = '$jenis' and no_dokumen = '$nomor'";
        $query = $oracle->query($sql);
        $query2 = $oracle->query('commit');
        // echo $sql;
    }

    // public function update($tgl, $nomor){
    //     $oracle = $this->load->database('oracle', true);
    //     $sql="update khs_tampung_spb set tgl_dibuat = TO_TIMESTAMP('$tgl', 'DD-MM-YYYY')
    //             where no_dokumen = '$nomor'";
    //     $query = $oracle->query($sql);         
    //     $query2 = $oracle->query('commit');          
    //     echo $sql; 
    // }
}
