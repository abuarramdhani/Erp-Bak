<?php 
    class M_lppbqc extends CI_Model {
        public function __construct(){
            $this->load->database();
            // $this->load->library('encrypt');
            $this->oracle = $this->load->database('oracle', true);
            // $this->oracle = $this->load->database('oracle_dev', true);
            $this->personalia = $this->load->database('personalia', true);
        }

        public function getMon($stat){
//             $sql = "SELECT DISTINCT  rt.organization_id, rt.transaction_type,
//             (SELECT MIN (TO_CHAR (rt1.transaction_date, 'DD Mon YYYY'))
//                FROM rcv_transactions rt1
//               WHERE rt.shipment_header_id = rt1.shipment_header_id
//                 AND rt.shipment_line_id = rt1.shipment_line_id
//                 AND rt1.transaction_type = 'TRANSFER') tgl_transfer,
//             (SELECT MIN (TO_CHAR (rt1.transaction_date, 'HH24:MI:SS'))
//                FROM rcv_transactions rt1
//               WHERE rt.shipment_header_id = rt1.shipment_header_id
//                 AND rt.shipment_line_id = rt1.shipment_line_id
//                 AND rt1.transaction_type = 'TRANSFER') jam_transfer,
//             rsh.receipt_num no_lppb, pov.vendor_name, msib.segment1 item,
//             msib.description item_description,
//             TO_CHAR (rsh.shipped_date, 'DD Mon YYYY') tgl_sp,
//             (SELECT rt1.quantity
//                FROM rcv_transactions rt1
//               WHERE rt.shipment_header_id = rt1.shipment_header_id
//                 AND rt.shipment_line_id = rt1.shipment_line_id
//                 AND rt1.transaction_type = 'RECEIVE') jumlah,
//             DECODE (rt.transaction_type, 'ACCEPT', rt.transaction_date, 'REJECT', rt.transaction_date, NULL) tgl_inspeksi,
//             DECODE (rt.transaction_type, 'ACCEPT', rt.quantity, NULL) ok,
//             DECODE (rt.transaction_type, 'REJECT', rt.quantity, NULL) not_ok,
//             DECODE (rt.transaction_type, 'ACCEPT', rt.inspection_quality_code, 'REJECT', rt.inspection_quality_code, rt.comments) keterangan,
//             NULL inspektor, TO_CHAR (klk.tanggal_kirim, 'DD Mon YYYY') tgl_kirim,
//             klk.jam jam_kirim
//        FROM rcv_transactions rt,
//             rcv_shipment_headers rsh,
//             rcv_shipment_lines rsl,
//             po_vendors pov,
//             rcv_supply rcvs,
//             mtl_system_items_b msib,
//             khs_lppbqc_kirim klk
//       WHERE rsh.shipment_header_id = rsl.shipment_header_id
//         AND rsh.shipment_header_id = rt.shipment_header_id
//         AND rsl.shipment_line_id = rt.shipment_line_id
//         AND rsh.vendor_id = pov.vendor_id
//         AND rt.organization_id = rcvs.to_organization_id
//         AND rt.shipment_header_id = rcvs.shipment_header_id
//         AND rt.shipment_line_id = rcvs.shipment_line_id
//         AND rt.transaction_id = rcvs.rcv_transaction_id
//         AND msib.inventory_item_id = rcvs.item_id
//         AND msib.organization_id = rcvs.to_organization_id
//         AND rt.shipment_header_id = klk.shipment_header_id(+)
//         AND rt.shipment_line_id = klk.shipment_line_id(+)
//         AND rt.routing_header_id = 2                        --Inspection Required
//         AND rt.transaction_type IN '$stat'
//    ORDER BY 1, 5";
            $sql = "SELECT   *
            FROM (SELECT DISTINCT 'BELUM QC' transaction_type, rt.organization_id,
                                  (SELECT MIN (TO_CHAR (rt1.transaction_date, 'DD Mon YYYY'))
                                     FROM rcv_transactions rt1
                                    WHERE rt.shipment_header_id = rt1.shipment_header_id
                                      AND rt.shipment_line_id = rt1.shipment_line_id
                                      AND rt1.transaction_type = 'TRANSFER') tgl_transfer,
                                  (SELECT MIN (TO_CHAR (rt1.transaction_date, 'HH24:MI:SS'))
                                     FROM rcv_transactions rt1
                                    WHERE rt.shipment_header_id = rt1.shipment_header_id
                                      AND rt.shipment_line_id = rt1.shipment_line_id
                                      AND rt1.transaction_type = 'TRANSFER') jam_transfer,
                                  rsh.receipt_num no_lppb, pov.vendor_name,
                                  msib.segment1 item,
                                  msib.description item_description,
                                  TO_CHAR (rsh.shipped_date, 'DD Mon YYYY') tgl_sp,
                                  (SELECT rt1.quantity
                                     FROM rcv_transactions rt1
                                    WHERE rt.shipment_header_id = rt1.shipment_header_id
                                      AND rt.shipment_line_id = rt1.shipment_line_id
                                      AND rt1.transaction_type = 'RECEIVE') jumlah,
                                  DECODE (rt.transaction_type,
                                          'ACCEPT', rt.transaction_date,
                                          'REJECT', rt.transaction_date,
                                          NULL
                                         ) tgl_inspeksi,
                                  DECODE (rt.transaction_type,
                                          'ACCEPT', rt.quantity,
                                          0
                                         ) ok,
                                  DECODE (rt.transaction_type,
                                          'REJECT', rt.quantity,
                                          0
                                         ) not_ok,
                                  DECODE (rt.transaction_type,
                                          'ACCEPT', rt.inspection_quality_code,
                                          'REJECT', rt.inspection_quality_code,
                                          rt.comments
                                         ) keterangan,
                                  TO_CHAR (klk.tanggal_kirim, 'DD Mon YYYY') tgl_kirim,
                                  klk.jam jam_kirim
                             FROM rcv_transactions rt,
                                  rcv_shipment_headers rsh,
                                  rcv_shipment_lines rsl,
                                  po_vendors pov,
                                  rcv_supply rcvs,
                                  mtl_system_items_b msib,
                                  khs_lppbqc_kirim klk
                            WHERE rsh.shipment_header_id = rsl.shipment_header_id
                              AND rsh.shipment_header_id = rt.shipment_header_id
                              AND rsl.shipment_line_id = rt.shipment_line_id
                              AND rsh.vendor_id = pov.vendor_id
                              AND rt.organization_id = rcvs.to_organization_id
                              AND rt.shipment_header_id = rcvs.shipment_header_id
                              AND rt.shipment_line_id = rcvs.shipment_line_id
                              AND rt.transaction_id = rcvs.rcv_transaction_id
                              AND msib.inventory_item_id = rcvs.item_id
                              AND msib.organization_id = rcvs.to_organization_id
                              AND rcvs.shipment_header_id = klk.shipment_header_id(+)
                              AND rcvs.shipment_line_id = klk.shipment_line_id(+)
                              AND rt.routing_header_id = 2       --Inspection Required
                              AND rt.transaction_type IN ('RECEIVE', 'TRANSFER')
                  UNION
                  SELECT DISTINCT rt.transaction_type, rt.organization_id,
                                  (SELECT MIN (TO_CHAR (rt1.transaction_date, 'DD Mon YYYY'))
                                     FROM rcv_transactions rt1
                                    WHERE rt.shipment_header_id = rt1.shipment_header_id
                                      AND rt.shipment_line_id = rt1.shipment_line_id
                                      AND rt1.transaction_type = 'TRANSFER') tgl_transfer,
                                  (SELECT MIN (TO_CHAR (rt1.transaction_date, 'HH24:MI:SS'))
                                     FROM rcv_transactions rt1
                                    WHERE rt.shipment_header_id = rt1.shipment_header_id
                                      AND rt.shipment_line_id = rt1.shipment_line_id
                                      AND rt1.transaction_type = 'TRANSFER') jam_transfer,
                                  rsh.receipt_num no_lppb, pov.vendor_name,
                                  msib.segment1 item,
                                  msib.description item_description,
                                  TO_CHAR (rsh.shipped_date, 'DD Mon YYYY') tgl_sp,
                                  (SELECT rt1.quantity
                                     FROM rcv_transactions rt1
                                    WHERE rt.shipment_header_id = rt1.shipment_header_id
                                      AND rt.shipment_line_id = rt1.shipment_line_id
                                      AND rt1.transaction_type = 'RECEIVE') jumlah,
                                  DECODE (rt.transaction_type,
                                          'ACCEPT', rt.transaction_date,
                                          'REJECT', rt.transaction_date,
                                          NULL
                                         ) tgl_inspeksi,
                                  DECODE (rt.transaction_type,
                                          'ACCEPT', rt.quantity,
                                          0
                                         ) ok,
                                  DECODE (rt.transaction_type,
                                          'REJECT', rt.quantity,
                                          0
                                         ) not_ok,
                                  DECODE (rt.transaction_type,
                                          'ACCEPT', rt.inspection_quality_code,
                                          'REJECT', rt.inspection_quality_code,
                                          rt.comments
                                         ) keterangan,
                                  TO_CHAR (klk.tanggal_kirim, 'DD Mon YYYY') tgl_kirim,
                                  klk.jam jam_kirim
                             FROM rcv_transactions rt,
                                  rcv_shipment_headers rsh,
                                  rcv_shipment_lines rsl,
                                  po_vendors pov,
                                  rcv_supply rcvs,
                                  mtl_system_items_b msib,
                                  khs_lppbqc_kirim klk
                            WHERE rsh.shipment_header_id = rsl.shipment_header_id
                              AND rsh.shipment_header_id = rt.shipment_header_id
                              AND rsl.shipment_line_id = rt.shipment_line_id
                              AND rsh.vendor_id = pov.vendor_id
                              AND rt.organization_id = rcvs.to_organization_id
                              AND rt.shipment_header_id = rcvs.shipment_header_id
                              AND rt.shipment_line_id = rcvs.shipment_line_id
                              AND rt.transaction_id = rcvs.rcv_transaction_id
                              AND msib.inventory_item_id = rcvs.item_id
                              AND msib.organization_id = rcvs.to_organization_id
                              AND rcvs.shipment_header_id = klk.shipment_header_id(+)
                              AND rcvs.shipment_line_id = klk.shipment_line_id(+)
                              AND rt.routing_header_id = 2       --Inspection Required
                              AND rt.transaction_type = '$stat')
           WHERE transaction_type = '$stat'
        ORDER BY 1, 5";
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
            FROM rcv_transactions rt,
                 rcv_shipment_headers rsh,
                 rcv_shipment_lines rsl,
                 po_vendors pov,
                 rcv_supply rcvs,
                 mtl_system_items_b msib
           WHERE rsh.shipment_header_id = rsl.shipment_header_id
             AND rsh.shipment_header_id = rt.shipment_header_id
             AND rsl.shipment_line_id = rt.shipment_line_id
             AND rsh.vendor_id = pov.vendor_id
             AND rt.organization_id = rcvs.to_organization_id
             AND rt.shipment_header_id = rcvs.shipment_header_id
             AND rt.shipment_line_id = rcvs.shipment_line_id
             AND rt.transaction_id = rcvs.rcv_transaction_id
             AND msib.inventory_item_id = rcvs.item_id
             AND msib.organization_id = rcvs.to_organization_id
             AND rt.routing_header_id = 2 --Inspection Required
             AND rt.transaction_type IN ('ACCEPT', 'REJECT')
             AND rsh.receipt_num LIKE '%$no_lppb%'
        ORDER BY 1";
            $query = $this->oracle->query($sql);
            return $query->result_array();
        }

        public function getDetail($lppb){
            $sql = "SELECT   rt.organization_id, rt.transaction_type,
            (SELECT MIN (TO_CHAR (rt1.transaction_date, 'DD Mon YYYY'))
               FROM rcv_transactions rt1
              WHERE rt.shipment_header_id = rt1.shipment_header_id
                AND rt.shipment_line_id = rt1.shipment_line_id
                AND rt1.transaction_type = 'TRANSFER') tgl_transfer,
            (SELECT MIN (TO_CHAR (rt1.transaction_date, 'HH24:MI:SS'))
               FROM rcv_transactions rt1
              WHERE rt.shipment_header_id = rt1.shipment_header_id
                AND rt.shipment_line_id = rt1.shipment_line_id
                AND rt1.transaction_type = 'TRANSFER') jam_transfer,
            rsh.receipt_num no_lppb, pov.vendor_name, msib.segment1 item,
            msib.description item_description,
            TO_CHAR (rsh.shipped_date, 'DD Mon YYYY') tgl_sp,
            (SELECT rt1.quantity
               FROM rcv_transactions rt1
              WHERE rt.shipment_header_id = rt1.shipment_header_id
                AND rt.shipment_line_id = rt1.shipment_line_id
                AND rt1.transaction_type = 'RECEIVE') jumlah,
            DECODE (rt.transaction_type, 'ACCEPT', rt.transaction_date, 'REJECT', rt.transaction_date, NULL) tgl_inspeksi,
            DECODE (rt.transaction_type, 'ACCEPT', rt.quantity, 0) ok,
            DECODE (rt.transaction_type, 'REJECT', rt.quantity, 0) not_ok,
            DECODE (rt.transaction_type, 'ACCEPT', rt.inspection_quality_code, 'REJECT', rt.inspection_quality_code, rt.comments) keterangan,
            NULL inspektor, rt.shipment_header_id, rt.shipment_line_id
       FROM rcv_transactions rt,
            rcv_shipment_headers rsh,
            rcv_shipment_lines rsl,
            po_vendors pov,
            rcv_supply rcvs,
            mtl_system_items_b msib
      WHERE rsh.shipment_header_id = rsl.shipment_header_id
        AND rsh.shipment_header_id = rt.shipment_header_id
        AND rsl.shipment_line_id = rt.shipment_line_id
        AND rsh.vendor_id = pov.vendor_id
        AND rt.organization_id = rcvs.to_organization_id
        AND rt.shipment_header_id = rcvs.shipment_header_id
        AND rt.shipment_line_id = rcvs.shipment_line_id
        AND rt.transaction_id = rcvs.rcv_transaction_id
        AND msib.inventory_item_id = rcvs.item_id
        AND msib.organization_id = rcvs.to_organization_id
        AND rt.routing_header_id = 2 --Inspection Required
        AND rsh.receipt_num = '$lppb'
   ORDER BY 1, 5";
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