<?php 
    class M_lppbqc extends CI_Model {
        public function __construct(){
            $this->load->database();
            // $this->load->library('encrypt');
            // $this->oracle = $this->load->database('oracle', true);
            $this->oracle = $this->load->database('oracle_dev', true);
            $this->personalia = $this->load->database('personalia', true);
        }

        public function getMon($stat){
            // $oracle = $this->load->database('oracle_dev',true);
//             $sql = "SELECT   rt.organization_id,
//             TO_CHAR (rt.transaction_date, 'DD Mon YYYY') tanggal,
//             TO_CHAR (rt.transaction_date, 'HH24:MI:SS') jam,
//             rsh.receipt_num no_lppb, pov.vendor_name, rsl.item_description,
//             TO_CHAR (rsh.shipped_date, 'DD Mon YYYY') tgl_sp, rt.quantity,
//             (CASE
//                 WHEN rt.transaction_type = 'TRANSFER'
//                    THEN rt.comments
//                 ELSE rt.inspection_quality_code
//              END
//             ) keterangan
//        FROM rcv_shipment_headers rsh,
//             po_vendors pov,
//             rcv_shipment_lines rsl,
//             rcv_transactions rt,
//             khs_lppbqc_max_transaction klmt
//       WHERE rsh.vendor_id = pov.vendor_id
//         AND rsh.shipment_header_id = rsl.shipment_header_id
//         AND rsh.shipment_header_id = rt.shipment_header_id
//         AND rsl.shipment_line_id = rt.shipment_line_id
//         AND rt.shipment_header_id = klmt.shipment_header_id
//         AND rt.shipment_line_id = klmt.shipment_line_id
//         AND rt.transaction_id = klmt.transaction_id
//         AND rt.transaction_type = '$stat'
//    ORDER BY rt.organization_id, rt.transaction_date";
            $sql = "SELECT   rt.organization_id,
            (CASE
                WHEN rt.transaction_type = 'TRANSFER'
                   THEN TO_CHAR (rt.transaction_date, 'DD Mon YYYY')
                ELSE (SELECT TO_CHAR (rt1.transaction_date, 'DD Mon YYYY')
                        FROM rcv_transactions rt1
                       WHERE rt.shipment_header_id = rt1.shipment_header_id
                         AND rt.shipment_line_id = rt1.shipment_line_id
                         AND rt1.transaction_type = 'TRANSFER')
             END
            ) tgl_transfer,
            (CASE
                WHEN rt.transaction_type = 'TRANSFER'
                   THEN TO_CHAR (rt.transaction_date, 'HH24:MI:SS')
                ELSE (SELECT TO_CHAR (rt1.transaction_date, 'HH24:MI:SS')
                        FROM rcv_transactions rt1
                       WHERE rt.shipment_header_id = rt1.shipment_header_id
                         AND rt.shipment_line_id = rt1.shipment_line_id
                         AND rt1.transaction_type = 'TRANSFER')
             END
            ) jam_transfer,
            rsh.receipt_num no_lppb, pov.vendor_name, rsl.item_description,
            TO_CHAR (rsh.shipped_date, 'DD Mon YYYY') tgl_sp,
            (CASE
                WHEN rt.transaction_type = 'TRANSFER'
                   THEN rt.quantity
                ELSE (SELECT rt1.quantity
                        FROM rcv_transactions rt1
                       WHERE rt.shipment_header_id = rt1.shipment_header_id
                         AND rt.shipment_line_id = rt1.shipment_line_id
                         AND rt1.transaction_type = 'TRANSFER')
             END
            )jumlah,
            (CASE
                WHEN rt.transaction_type = 'TRANSFER'
                   THEN NULL
                ELSE TO_CHAR (rt.transaction_date, 'DD Mon YYYY')
             END
            )tgl_inspeksi,
            (CASE
                WHEN rt.transaction_type = 'ACCEPT'
                   THEN rt.quantity
                ELSE NULL
             END
            ) ok,
            (CASE
                WHEN rt.transaction_type = 'REJECT'
                   THEN rt.quantity
                ELSE NULL
             END
            ) not_ok,
            (CASE
                WHEN rt.transaction_type = 'TRANSFER'
                   THEN rt.comments
                ELSE rt.inspection_quality_code
             END
            ) keterangan,
            NULL inspektor, TO_CHAR (klk.tanggal_kirim, 'DD Mon YYYY') tgl_kirim, 
            klk.jam jam_kirim
       FROM rcv_shipment_headers rsh,
            po_vendors pov,
            rcv_shipment_lines rsl,
            rcv_transactions rt,
            khs_lppbqc_max_transaction klmt,
            khs_lppbqc_kirim klk
      WHERE rsh.vendor_id = pov.vendor_id
        AND rsh.shipment_header_id = rsl.shipment_header_id
        AND rsh.shipment_header_id = rt.shipment_header_id
        AND rsl.shipment_line_id = rt.shipment_line_id
        AND rt.shipment_header_id = klmt.shipment_header_id
        AND rt.shipment_line_id = klmt.shipment_line_id
        AND rt.transaction_id = klmt.transaction_id
        AND rt.shipment_header_id = klk.shipment_header_id(+)
        AND rt.shipment_line_id = klk.shipment_line_id(+)
        AND rt.transaction_type = '$stat'
   ORDER BY rt.organization_id, rt.transaction_date";
            $query = $this->oracle->query($sql);
            return $query->result_array();
        }

        public function getNoInduk($data){
            $sql = "SELECT employee_code
            FROM er.er_employee_all
            WHERE resign = '0'
            AND employee_code LIKE '%$data%'
            ORDER BY 1";
            $query = $this->db->query($sql);
            return $query->result_array();
        }

        public function getNama($no_induk){
            $response = $this->personalia->select('nama')
                                        ->where('noind', $no_induk)
                                        ->get('hrd_khs.tpribadi')
                                        ->row();
            return $response;
        }

        public function getNoLppb($no_lppb){
            $sql = "SELECT DISTINCT rsh.receipt_num no_lppb
            FROM rcv_shipment_headers rsh,
                 po_vendors pov,
                 rcv_shipment_lines rsl,
                 rcv_transactions rt,
                 khs_lppbqc_max_transaction klmt
           WHERE rsh.vendor_id = pov.vendor_id
             AND rsh.shipment_header_id = rsl.shipment_header_id
             AND rsh.shipment_header_id = rt.shipment_header_id
             AND rsl.shipment_line_id = rt.shipment_line_id
             AND rt.shipment_header_id = klmt.shipment_header_id
             AND rt.shipment_line_id = klmt.shipment_line_id
             AND rt.transaction_id = klmt.transaction_id
             AND rt.transaction_type IN ('TRANSFER', 'ACCEPT', 'REJECT')
             AND rsh.receipt_num LIKE '%$no_lppb%'
        ORDER BY 1";
            $query = $this->oracle->query($sql);
            return $query->result_array();
        }

        public function getDetail($lppb){
//             $sql = "SELECT   rt.organization_id, rsh.receipt_num no_lppb, pov.vendor_name,
//             msib.segment1 item, rsl.item_description, rt.quantity,
//             (CASE
//                 WHEN rt.transaction_type = 'TRANSFER'
//                    THEN NVL(rt.comments, ' ')
//                 ELSE NVL(rt.inspection_quality_code, ' ')
//              END
//             ) keterangan
//        FROM rcv_shipment_headers rsh,
//             po_vendors pov,
//             rcv_shipment_lines rsl,
//             rcv_transactions rt,
//             khs_lppbqc_max_transaction klmt,
//             mtl_system_items_b msib
//       WHERE rsh.vendor_id = pov.vendor_id
//         AND rsh.shipment_header_id = rsl.shipment_header_id
//         AND rsh.shipment_header_id = rt.shipment_header_id
//         AND rsl.shipment_line_id = rt.shipment_line_id
//         AND rt.shipment_header_id = klmt.shipment_header_id
//         AND rt.shipment_line_id = klmt.shipment_line_id
//         AND rt.transaction_id = klmt.transaction_id
//         AND rsh.ship_to_org_id = msib.organization_id
//         AND rsl.item_id = msib.inventory_item_id
//         AND rt.transaction_type IN ('TRANSFER', 'ACCEPT', 'REJECT')
//         AND rsh.receipt_num = '$lppb'
//    ORDER BY rt.organization_id, rt.transaction_date";
            $sql = "SELECT   rt.organization_id, rsh.receipt_num no_lppb, pov.vendor_name,
            msib.segment1 item, rsl.item_description,
            (CASE
                WHEN rt.transaction_type = 'TRANSFER'
                   THEN rt.quantity
                ELSE (SELECT rt1.quantity
                        FROM rcv_transactions rt1
                       WHERE rt.shipment_header_id = rt1.shipment_header_id
                         AND rt.shipment_line_id = rt1.shipment_line_id
                         AND rt1.transaction_type = 'TRANSFER')
             END
            ) jumlah,
            (CASE
                WHEN rt.transaction_type = 'ACCEPT'
                   THEN rt.quantity
                ELSE 0
             END
            ) ok,
            (CASE
                WHEN rt.transaction_type = 'REJECT'
                   THEN rt.quantity
                ELSE 0
             END
            ) not_ok,
            (CASE
                WHEN rt.transaction_type = 'TRANSFER'
                   THEN NVL (rt.comments, ' ')
                ELSE NVL (rt.inspection_quality_code, ' ')
             END
            ) keterangan,
            rt.shipment_header_id, rt.shipment_line_id
       FROM rcv_shipment_headers rsh,
            po_vendors pov,
            rcv_shipment_lines rsl,
            rcv_transactions rt,
            khs_lppbqc_max_transaction klmt,
            mtl_system_items_b msib
      WHERE rsh.vendor_id = pov.vendor_id
        AND rsh.shipment_header_id = rsl.shipment_header_id
        AND rsh.shipment_header_id = rt.shipment_header_id
        AND rsl.shipment_line_id = rt.shipment_line_id
        AND rt.shipment_header_id = klmt.shipment_header_id
        AND rt.shipment_line_id = klmt.shipment_line_id
        AND rt.transaction_id = klmt.transaction_id
        AND rsh.ship_to_org_id = msib.organization_id
        AND rsl.item_id = msib.inventory_item_id
        AND rt.transaction_type IN ('TRANSFER', 'ACCEPT', 'REJECT')
        AND rsh.receipt_num = '$lppb'
   ORDER BY rt.organization_id, rt.transaction_date";
            $query = $this->oracle->query($sql);
            return $query->result_array();
        }

        public function getIDKirim(){
            $response = $this->oracle->query("SELECT TRIM (TO_CHAR (SYSDATE, 'RRMMDD') || LPAD (khs_lppbqc_num.NEXTVAL, 3, '0')) id_kirim
            FROM DUAL")->row_array();
            return $response['ID_KIRIM'];
        }

        public function insert($data){
            $this->oracle->query("INSERT INTO khs_lppbqc_kirim
            (id_kirim, no_induk_pengirim,
             nama_pengirim,
             tanggal_kirim,
             jam, line_num, shipment_header_id,
             shipment_line_id, no_lppb,
             nama_vendor, kode_komponen,
             nama_komponen, jumlah, ok,
             not_ok, keterangan, status
            )
     VALUES ('$data[ID_KIRIM]', '$data[NO_INDUK_PENGIRIM]',
             '$data[NAMA_PENGIRIM]',
             TO_TIMESTAMP ('$data[TANGGAL_KIRIM]', 'Day/DD Mon YYYY'),
             '$data[JAM]', '$data[LINE_NUM]', '$data[SHIPMENT_HEADER_ID]',
             '$data[SHIPMENT_LINE_ID]', '$data[NO_LPPB]',
             '$data[NAMA_VENDOR]', '$data[KODE_KOMPONEN]',
             '$data[NAMA_KOMPONEN]', '$data[JUMLAH]', '$data[OK]',
             '$data[NOT_OK]', '$data[KETERANGAN]', '$data[STATUS]'
            )");
            $response = 1;
            return $response;
        } 

        public function getTerima(){
            $sql = "SELECT klk.id_kirim, klk.line_num, klk.no_lppb, klk.nama_vendor,
            klk.nama_komponen, klk.jumlah, klk.ok, klk.not_ok, klk.keterangan,
            klk.no_induk_pengirim,
            TO_CHAR (klk.tanggal_kirim, 'DD Mon YYYY') tanggal_kirim, klk.jam,
            klk.status
            FROM khs_lppbqc_kirim klk
            ORDER BY klk.id_kirim DESC, klk.line_num";
            $query = $this->oracle->query($sql);
            return $query->result_array();
        }

        public function sdhTerima($id_kirim, $line_num, $status){
            $sql = "UPDATE khs_lppbqc_kirim
            SET status = $status
            WHERE id_kirim = $id_kirim AND line_num = $line_num";
            $query = $this->oracle->query($sql);
            $query = $this->oracle->query('commit');
        }

    }
?>