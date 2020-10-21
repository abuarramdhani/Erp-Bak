<?php
class M_pbi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
        // $this->oracle = $this->load->database('oracle_dev', true);
        $this->personalia = $this->load->database('personalia', true);
    }

    public function delete_pbi($no_doc)
    {
      $this->oracle->delete('KHS_KIRIM_INTERNAL', ['DOC_NUMBER' => $no_doc]);
      if ($this->oracle->affected_rows() == 1) {
          return 1;
      } else {
          return 0;
      }
    }

    public function edit_pbi($no_doc, $data)
    {
      $this->oracle->where('DOC_NUMBER', $no_doc)->update('KHS_KIRIM_INTERNAL', $data);
      if ($this->oracle->affected_rows() == 1) {
          return 1;
      } else {
          return 0;
      }
    }

    public function updateApproval($data, $fpb)
    {
      $this->oracle->query("UPDATE
                  KHS_KIRIM_INTERNAL
              SET
                  APPROVE_DATE = SYSDATE,
                  FLAG_APPROVE_ASET = '$data'
              WHERE DOC_NUMBER = '$fpb'");
      return 1;
    }

    public function atasan_employee($data)
    {
      $user_login = $this->session->user;
      $res = $this->personalia->query("SELECT
                                        distinct tp.noind,
                                        trim(tp.nama) nama,
                                        tp.email_internal,
                                        tp.kd_jabatan
                                      from
                                        hrd_khs.trefjabatan tj,
                                        hrd_khs.tpribadi tp,
                                        (
                                        select
                                          tp2.*
                                        from
                                          hrd_khs.tpribadi tp2
                                        where
                                          tp2.noind = '$user_login' ) tpp
                                      where
                                        tj.noind = tp.noind
                                        and tp.keluar = '0'
                                        and substring(tp.kodesie, 1, 1) = substring(tpp.kodesie, 1, 1)
                                        and tp.kd_jabatan <= '11'
                                        and tj.noind <> tpp.noind
                                        and (tp.nama like '%$data%'
                                        or tp.noind like '%$data%')
                                      order by
                                        tp.kd_jabatan desc,
                                        tp.noind")->result_array();
        return $res;
    }

    public function generateTicketPBI()
    {
      $response = $this->oracle->query("SELECT trim('FPB'
                                              ||to_char(sysdate,'RRMMDD')
                                              ||lpad(khs_fpb_num.nextval,3,'0')) no_fpb
                                        from dual")->row_array();
      return $response['NO_FPB'];
    }

    public function cek_no_mo($mo)
    {
      $res = $this->oracle->select('NO_MOVE_ORDER')->where('NO_MOVE_ORDER', $mo)->get('KHS_KIRIM_INTERNAL')->row();
      return $res;
    }

    public function getDetailMo($val)
    {
      $res = $this->oracle->query("SELECT msib.segment1, msib.description, mtrl.quantity, mtrl.uom_code,
                 mp.organization_id from_org_id, mp.organization_code from_io,
                 mtrl.from_subinventory_code, mp2.organization_id to_org_id,
                 mp2.organization_code to_io, mtrl.to_subinventory_code,
                 CASE
                    WHEN SUBSTR (msib.segment1, 1, 1) = 'N'
                       THEN 'ASSET'
                    WHEN msib.inventory_item_flag = 'Y'
                    AND msib.item_type <> '3085'
                       THEN 'INVENTORY'
                    ELSE 'EXPENSE'
                 END jenis,
                 mtrh.transaction_type_id
            FROM mtl_txn_request_headers mtrh,
                 mtl_txn_request_lines mtrl,
                 mtl_system_items_b msib,
                 mtl_secondary_inventories msi,
                 mtl_secondary_inventories msi2,
                 mtl_parameters mp,
                 mtl_parameters mp2
           WHERE mtrh.header_id = mtrl.header_id
             AND mtrl.inventory_item_id = msib.inventory_item_id
             AND msib.organization_id = mtrl.organization_id
             AND msi.secondary_inventory_name(+) = mtrl.from_subinventory_code
             AND msi2.secondary_inventory_name(+) = mtrl.to_subinventory_code
             AND mp.organization_id(+) = msi.organization_id
             AND mp2.organization_id(+) = msi2.organization_id
             AND mtrl.line_status IN (3, 7)
             AND mtrh.request_number IN ('$val')")->result_array();

       if (empty($res)) {
         return 0;
       }else {
         return $res;
       }
    }

    public function updatePeneriamaan($d)
    {
        $user_login = $this->session->user;
        $this->oracle->query("UPDATE
                    KHS_KIRIM_INTERNAL
                SET
                    STATUS = '6',
                    RECEIVE_DATE_SEKSI = SYSDATE,
                    RECEIVED_BY_SEKSI = '$user_login'
                WHERE
                    DOC_NUMBER = '$d'
                AND STATUS = '5'
        ");
        return 1;
    }

    public function GetMasterDD()
    {
        $response = $this->personalia->select('seksi')
                                   ->join('hrd_khs.tseksi', 'hrd_khs.tseksi.kodesie = hrd_khs.tpribadi.kodesie', 'left')
                                   ->where('noind', $this->session->user)
                                   ->get('hrd_khs.tpribadi')
                                   ->row();

        $sql = "SELECT distinct kki.doc_number, kki.user_tujuan, kki.seksi_tujuan, kki.tujuan, kki.seksi_kirim, kki.status, kki.created_by, to_char(kki.creation_date,'DD-MON-YYYY HH24:MI:SS') creation_date,
                 CASE
                    WHEN kki.status = 1
                       THEN 'Dipersiapkan Seksi Pengirim'
                    WHEN kki.status = 2
                       THEN 'Diterima Gudang Pengeluaran'
                    WHEN kki.status = 3
                       THEN 'Surat Jalan Telah Dibuat'
                    WHEN kki.status = 4
                       THEN 'Dikirim ke Lokasi Tujuan'
                    WHEN kki.status = 5
                       THEN 'Diterima Gudang Penerimaan'
                    WHEN kki.status = 6
                       THEN 'Diterima Seksi Tujuan'
                 END status2,
                 (SELECT ksi.no_suratjalan
                    FROM khs_sj_internal ksi
                   WHERE ksi.no_fpb = kki.doc_number) no_surat_jalan
              FROM khs_kirim_internal kki
              WHERE kki.seksi_tujuan = '$response->seksi'
              AND kki.status >= '5'
              ORDER BY kki.doc_number DESC";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function GetMaster()
    {
        $sql = "SELECT *
                FROM KHS_KIRIM_INTERNAL";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function GetMasterByApproval()
    {
      $user_login = $this->session->user;
      $sql = "SELECT distinct kki.doc_number, kki.NO_TRANSFER_ASET, kki.FLAG_APPROVE_ASET, kki.user_tujuan, kki.seksi_tujuan, kki.tujuan, kki.seksi_kirim, kki.status, to_char(kki.creation_date,'DD-MON-YYYY HH24:MI:SS') creation_date,
               CASE
                  WHEN kki.status = 1
                     THEN 'Dipersiapkan Seksi Pengirim'
                  WHEN kki.status = 2
                     THEN 'Diterima Gudang Pengeluaran'
                  WHEN kki.status = 3
                     THEN 'Surat Jalan Telah Dibuat'
                  WHEN kki.status = 4
                     THEN 'Dikirim ke Lokasi Tujuan'
                  WHEN kki.status = 5
                     THEN 'Diterima Gudang Penerimaan'
                  WHEN kki.status = 6
                     THEN 'Diterima Seksi Tujuan'
               END status2,
               (SELECT ksi.no_suratjalan
                  FROM khs_sj_internal ksi
                 WHERE ksi.no_fpb = kki.doc_number) no_surat_jalan
            FROM khs_kirim_internal kki
            WHERE kki.APPROVED_BY = '$user_login'
            ORDER BY kki.doc_number DESC";
      $query = $this->oracle->query($sql);
      return $query->result_array();
      return $res;
    }

    public function GetMasterD()
    {
        $response = $this->personalia->select('seksi')
                                   ->join('hrd_khs.tseksi', 'hrd_khs.tseksi.kodesie = hrd_khs.tpribadi.kodesie', 'left')
                                   ->where('noind', $this->session->user)
                                   ->get('hrd_khs.tpribadi')
                                   ->row();

        $sql = "SELECT distinct kki.doc_number, kki.user_tujuan,
                                kki.seksi_tujuan, kki.tujuan,
                                kki.keterangan, kki.type,
                                kki.seksi_kirim, kki.status,
                                kki.flag_approve_aset, kki.no_transfer_aset,
                                to_char(kki.creation_date,'DD-MON-YYYY HH24:MI:SS') creation_date,
                 CASE
                    WHEN kki.status = 1
                       THEN 'Dipersiapkan Seksi Pengirim'
                    WHEN kki.status = 2
                       THEN 'Diterima Gudang Pengeluaran'
                    WHEN kki.status = 3
                       THEN 'Surat Jalan Telah Dibuat'
                    WHEN kki.status = 4
                       THEN 'Dikirim ke Lokasi Tujuan'
                    WHEN kki.status = 5
                       THEN 'Diterima Gudang Penerimaan'
                    WHEN kki.status = 6
                       THEN 'Diterima Seksi Tujuan'
                 END status2,
                 (SELECT DISTINCT ksi.no_suratjalan
                    FROM khs_sj_internal ksi
                   WHERE ksi.no_fpb = kki.doc_number) no_surat_jalan
              FROM khs_kirim_internal kki
              WHERE kki.seksi_kirim = '$response->seksi'
              ORDER BY kki.doc_number DESC";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function Cetak($d)
    {
        $response = $this->oracle->distinct()
                                 ->select('*')
                                 ->where("DOC_NUMBER", $d)
                                 ->get('KHS_KIRIM_INTERNAL')
                                 ->result_array();
        return $response;
    }

    public function jenisBarang($d)
    {
        $response = $this->oracle->distinct()
                                 ->select('ITEM_TYPE')
                                 ->where("DOC_NUMBER", $d)
                                 ->get('KHS_KIRIM_INTERNAL')
                                 ->result_array();
        return $response;
    }

    public function Detail($d)
    {
        $sql = "SELECT kki.*,
         CASE
            WHEN kki.status = 1
               THEN 'Dipersiapkan Seksi Pengirim'
            WHEN kki.status = 2
               THEN 'Diterima Gudang Pengeluaran'
            WHEN kki.status = 3
               THEN 'Surat Jalan Telah Dibuat'
            WHEN kki.status = 4
               THEN 'Dikirim ke Lokasi Tujuan'
            WHEN kki.status = 5
               THEN 'Diterima Gudang Penerimaan'
            WHEN kki.status = 6
               THEN 'Diterima Seksi Tujuan'
         END status2,
         (SELECT ksi.no_suratjalan
            FROM khs_sj_internal ksi
           WHERE ksi.no_fpb = kki.doc_number) no_surat_jalan
      FROM khs_kirim_internal kki
      WHERE kki.doc_number = '$d'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function lastDocumentNumber($value)
    {
        $sql = "SELECT MAX(SUBSTR(kki.doc_number, -3)) doc_number
                FROM  KHS_KIRIM_INTERNAL kki
                WHERE kki.doc_number LIKE '$value%'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function insert($data)
    {
        if (!empty($data['USER_TUJUAN'])) {
            // $this->oracle->insert('KHS_KIRIM_INTERNAL', $data);
            $this->oracle->query("INSERT INTO KHS_KIRIM_INTERNAL(DOC_NUMBER
                           ,SEKSI_KIRIM
                           ,TUJUAN
                           ,USER_TUJUAN
                           ,LINE_NUM
                           ,ITEM_CODE
                           ,ITEM_TYPE
                           ,DESCRIPTION
                           ,QUANTITY
                           ,UOM
                           ,STATUS
                           ,CREATION_DATE
                           ,CREATED_BY
                           ,SEKSI_TUJUAN
                           ,KETERANGAN
                           ,NO_TRANSFER_ASET
                           ,TYPE
                           ,APPROVED_BY
                           )
          VALUES ('$data[DOC_NUMBER]'
                 ,'$data[SEKSI_KIRIM]'
                 ,'$data[TUJUAN]'
                 ,'$data[USER_TUJUAN]'
                 ,'$data[LINE_NUM]'
                 ,'$data[ITEM_CODE]'
                 ,'$data[ITEM_TYPE]'
                 ,'$data[DESCRIPTION]'
                 ,'$data[QUANTITY]'
                 ,'$data[UOM]'
                 ,'$data[STATUS]'
                 , SYSDATE
                 ,'$data[CREATED_BY]'
                 ,'$data[SEKSI_TUJUAN]'
                 ,'$data[KETERANGAN]'
                 ,'$data[NO_TRANSFER_ASET]'
                 ,'$data[TYPE]'
                 ,'$data[ATASAN]')
          ");
            $response = 1;
            return $response;
        } else {
            $response = 'USER_TUJUAN TIDAK BOLEH KOSONG';
            echo $response;
            die;
        }
    }

    public function deleteMO($mo)
    {
      $this->oracle->delete('KHS_KIRIM_INTERNAL', ['DOC_NUMBER' => $mo]);
    }

    public function insertMO($data)
    {
        if (!empty($data['USER_TUJUAN'])) {
            // $this->oracle->insert('KHS_KIRIM_INTERNAL', $data);
            $user_login = $this->session->user;
            $this->oracle->query("INSERT INTO KHS_KIRIM_INTERNAL(DOC_NUMBER
                           ,SEKSI_KIRIM
                           ,TUJUAN
                           ,USER_TUJUAN
                           ,LINE_NUM
                           ,ITEM_CODE
                           ,ITEM_TYPE
                           ,DESCRIPTION
                           ,QUANTITY
                           ,UOM
                           ,STATUS
                           ,CREATION_DATE
                           ,CREATED_BY
                           ,SEKSI_TUJUAN
                           ,KETERANGAN
                           ,NO_MOVE_ORDER
                           ,TYPE
                           ,RECEIVED_BY
                           ,RECEIVE_DATE
                           )
          VALUES ('$data[DOC_NUMBER]'
                 ,'$data[SEKSI_KIRIM]'
                 ,'$data[TUJUAN]'
                 ,'$data[USER_TUJUAN]'
                 ,'$data[LINE_NUM]'
                 ,'$data[ITEM_CODE]'
                 ,'$data[ITEM_TYPE]'
                 ,'$data[DESCRIPTION]'
                 ,'$data[QUANTITY]'
                 ,'$data[UOM]'
                 ,'$data[STATUS]'
                 , SYSDATE
                 ,'$data[CREATED_BY]'
                 ,'$data[SEKSI_TUJUAN]'
                 ,'$data[KETERANGAN]'
                 ,'$data[MO]'
                 ,'$data[TYPE]'
                 ,'$user_login'
                 , SYSDATE)
          ");
            $response = 1;
            return $response;
        } else {
            $response = 'USER_TUJUAN TIDAK BOLEH KOSONG';
            echo $response;
            die;
        }
    }

    public function listCode($d)
    {
        $sql = "SELECT msib.segment1, msib.description
                FROM mtl_system_items_b msib
               WHERE msib.organization_id = 81
                 AND msib.inventory_item_status_code = 'Active'
                 AND SUBSTR (msib.segment1, 1, 1) <> 'J'
                 AND (msib.segment1 LIKE '%$d%'
                 OR msib.description LIKE '%$d%')
            ORDER BY 1";
        //tambah segment1 untuk liat munculin  berdasrkan itiem_code;
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function autofill($d)
    {
        $sql = "SELECT msib.segment1, msib.description, msib.primary_uom_code,
                   CASE
                      WHEN SUBSTR (msib.segment1, 1, 1) = 'N'
                         THEN 'ASSET'
                      WHEN msib.inventory_item_flag = 'Y'
                      AND msib.item_type <> '3085'
                         THEN 'INVENTORY'
                      ELSE 'EXPENSE'
                   END jenis
                FROM mtl_system_items_b msib
               WHERE msib.organization_id = 81
                 AND msib.inventory_item_status_code = 'Active'
                 AND SUBSTR (msib.segment1, 1, 1) <> 'J'
                 AND msib.segment1 = '$d'
            ORDER BY 1";
        //tambah segment1 untuk liat munculin  berdasrkan itiem_code;
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function cekComponent($value)
    {
        $response = $this->oracle->select('ITEM_CODE')
                                 ->where('ITEM_CODE', $value)
                                 ->get('KHS_KIRIM_INTERNAL')
                                 ->row();
        if (!empty($response)) {
            $response = 1;
        } else {
            $response = 0;
        }
        return $response;
    }

    public function getSeksi($data)
    {
        $response = $this->personalia->distinct()
                                   ->select('seksi')
                                   ->like('seksi', $data, 'after')
                                   ->order_by("seksi", "asc")
                                   ->get('hrd_khs.tseksi')
                                   ->result_array();
        return $response;
    }

    public function getSeksiku($a)
    {
        $response = $this->personalia->select('seksi')
                                   ->join('hrd_khs.tseksi', 'hrd_khs.tseksi.kodesie = hrd_khs.tpribadi.kodesie', 'left')
                                   ->where('noind', $a)
                                   ->get('hrd_khs.tpribadi')
                                   ->row();
        return $response;
    }

    public function employee($data)
    {
        $sql = "SELECT
              	employee_code,
              	employee_name
              from
              	er.er_employee_all
              where
              	resign = '0'
                and (employee_code like '%$data%'
              	or employee_name like '%$data%')
              order by
              	1";
        $response = $this->db->query($sql)->result_array();
        return $response;
    }

    public function getJadwal()
    {
        $sql = "SELECT   *
                  FROM khs_jadwal_hiwing
              ORDER BY 1";
        $response = $this->oracle->query($sql)->result_array();
        return $response;
    }
}
