<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pengembalianbrg extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->database();    
    $this->oracle = $this->load->database('oracle', true);
    // $this->oracle = $this->load->database('oracle_dev', true);
    $this->personalia = $this->load->database('personalia', true);
  }

  public function getTipeProduk($term){
    $sql = "SELECT   *
    FROM khs_tipe_produk_gear_trans
    WHERE tipe_produk LIKE '%$term%'
    ORDER BY 1";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getKodeKomponen($kodeproduk, $term){
    $sql = "SELECT DISTINCT component_num item, description,
    component_num || ' - ' || description kode
FROM (SELECT mb1.segment1 assembly_num,
            mb2.inventory_item_id item_id,
            mb2.segment1 component_num, mb2.description,
            bc.item_num, flv.meaning item_type,
            bc.component_quantity qty, mb2.primary_uom_code uom,
            mb1.organization_id, mp.organization_code
       FROM bom.bom_components_b bc,
            bom.bom_structures_b bs,
            inv.mtl_system_items_b mb1,
            inv.mtl_system_items_b mb2,
            fnd_lookup_values flv,
            mtl_parameters mp
      WHERE bs.assembly_item_id = mb1.inventory_item_id
        AND bc.component_item_id = mb2.inventory_item_id
        AND bc.bill_sequence_id = bs.bill_sequence_id
        AND mb1.organization_id = mb2.organization_id
        AND bs.organization_id = mb2.organization_id
        AND bc.disable_date IS NULL
        AND bs.alternate_bom_designator IS NULL
        AND mb1.organization_id = 102
        AND mp.organization_id = mb1.organization_id
        AND mb2.item_type = flv.lookup_code
        AND flv.lookup_type = 'ITEM_TYPE'
        AND mb1.segment1 = '$kodeproduk')
        -- hanya kode finish saja, jika menggunakan query dibawah kode blank (A1-0) masih muncul
--    (SELECT CONNECT_BY_ROOT q_bom.assembly_num root_assembly,
--    q_bom.assembly_num,  q_bom.component_num, q_bom.description, q_bom.item_num,
--    q_bom.item_type, q_bom.qty, q_bom.uom,
--    SUBSTR(SYS_CONNECT_BY_PATH(q_bom.assembly_Num, ' <-- '),5) assembly_path,
--    LEVEL  bom_level, organization_id, organization_code --CONNECT_BY_ISCYCLE is_cycle,
--    FROM(
--    SELECT mb1.segment1 assembly_num, mb2.segment1 component_num, mb2.description,
--    bc.item_num, flv.meaning item_type, bc.component_quantity qty,
--    mb2.primary_uom_code uom, mb1.organization_id, mp.organization_code
--    FROM bom.bom_components_b bc,
--    bom.bom_structures_b bs,
--    inv.mtl_system_items_b mb1,
--    inv.mtl_system_items_b mb2,
--    fnd_lookup_values flv,
--    mtl_parameters mp
--    WHERE bs.assembly_item_id = mb1.inventory_item_id
--    AND bc.component_item_id = mb2.inventory_item_id
--    AND bc.bill_sequence_id = bs.bill_sequence_id
--    AND mb1.organization_id = mb2.organization_id
--    AND bs.organization_id = mb2.organization_id
--    AND bc.disable_date IS NULL
--    AND bs.alternate_bom_designator IS NULL
--    AND mb1.organization_id = 102
--    AND mp.organization_id = mb1.organization_id
--    AND mb2.item_type = flv.lookup_code
--    AND flv.lookup_type = 'ITEM_TYPE') q_bom
--    START WITH  q_bom.assembly_num in ('$kodeproduk')
--    CONNECT BY NOCYCLE PRIOR q_bom.component_num = q_bom.assembly_num
--    ORDER SIBLINGS BY q_bom.assembly_Num)
   WHERE (component_num LIKE '%$term%' OR description LIKE '%$term%')
ORDER BY        1";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getPic($term){
    $sql = "SELECT noind, noind ||' - '|| nama pic
    FROM hrd_khs.tpribadi
    WHERE (noind LIKE '%$term%' or nama LIKE '%$term%')
    ORDER BY 1";
    $query = $this->personalia->query($sql);
    return $query->result_array();
  }

  public function InputPengembalian($data){
    $sql = "INSERT INTO khs_inv_pengembalian_barang
    (proses_assembly, kode_komponen, qty_komponen, alasan_pengembalian, 
    pic_assembly, pic_gudang, tgl_input, 
    status_verifikasi, mo_rej, mo_seksi
    )
    VALUES ('$data[proses_assembly]', '$data[kode_komponen]', $data[qty_komponen], '$data[alasan_pengembalian]', 
    '$data[pic_assembly]', '$data[pic_gudang]', TO_DATE ('$data[tgl_input]', 'YYYY/MM/DD HH24:MI:SS'), 
    '$data[status_verifikasi]', '$data[mo_rej]', '$data[mo_seksi]'
    )";
    $query = $this->oracle->query($sql);
    $query = $this->oracle->query('commit');
  }

  public function getDataInput(){
    $sql = "SELECT   kipb.*, ktpgt.tipe_produk, msib.inventory_item_id,
    msib.description nama_komponen, msib.primary_uom_code uom,
    DECODE (kipb.mo_rej, 0, NULL, kipb.mo_rej) mo_rej_tampil,
    (SELECT mtrl.quantity_delivered
        FROM mtl_txn_request_headers mtrh,
            mtl_txn_request_lines mtrl
      WHERE kipb.mo_rej = mtrh.request_number
        AND mtrh.header_id = mtrl.header_id
        AND mtrl.inventory_item_id = msib.inventory_item_id) cek_trx,
    (SYSDATE - NVL(kipb.tgl_order_verifikasi, SYSDATE)) lt_qc,
    (SYSDATE - NVL(kipb.tgl_verifikasi, SYSDATE)) lt_gudang
    FROM khs_inv_pengembalian_barang kipb,
    khs_tipe_produk_gear_trans ktpgt,
    mtl_system_items_b msib
    WHERE kipb.proses_assembly = ktpgt.kode
    AND kipb.kode_komponen = msib.segment1
    AND msib.organization_id = 81
    --jika sudah verifikasi qc & sudah transact tidak tampil
    AND (kipb.status_verifikasi NOT IN ('OK', 'REPAIR', 'REJECT')
    OR (SELECT mtrl.quantity_delivered
            FROM mtl_txn_request_headers mtrh, mtl_txn_request_lines mtrl
            WHERE kipb.mo_rej = mtrh.request_number
              AND mtrh.header_id = mtrl.header_id
              AND mtrl.inventory_item_id = msib.inventory_item_id) IS NULL
    )
    ORDER BY 1";
    $query = $this->oracle->query($sql);
    return $query->result_array();
}

  public function getDataMon(){
    $sql = "SELECT   kipb.*, ktpgt.tipe_produk, msib.inventory_item_id,
      msib.description nama_komponen, msib.primary_uom_code uom,
      DECODE (kipb.mo_rej, 0, NULL, kipb.mo_rej) mo_rej_tampil,
      DECODE (kipb.mo_seksi, 0, NULL, kipb.mo_seksi) mo_seksi_tampil,
      (SELECT mtrl.quantity_delivered
          FROM mtl_txn_request_headers mtrh,
              mtl_txn_request_lines mtrl
        WHERE kipb.mo_rej = mtrh.request_number
          AND mtrh.header_id = mtrl.header_id
          AND mtrl.inventory_item_id = msib.inventory_item_id) cek_trx,
      (SELECT mtrl.quantity_delivered
          FROM mtl_txn_request_headers mtrh,
              mtl_txn_request_lines mtrl
        WHERE kipb.mo_seksi = mtrh.request_number
          AND mtrh.header_id = mtrl.header_id
          AND mtrl.inventory_item_id = msib.inventory_item_id) cek_trx_seksi,
      NVL(mil.segment1, kipb.locator_penerima_barang) LOCATOR,
      (SYSDATE - NVL(kipb.tgl_order_verifikasi, SYSDATE)) lt_qc,
      (SYSDATE - NVL(kipb.tgl_verifikasi, SYSDATE)) lt_gudang
  FROM khs_inv_pengembalian_barang kipb,
      khs_tipe_produk_gear_trans ktpgt,
      mtl_system_items_b msib,
      mtl_item_locations mil
WHERE kipb.proses_assembly = ktpgt.kode
  AND kipb.kode_komponen = msib.segment1
  AND msib.organization_id = 81
  AND kipb.subinv_penerima_barang = mil.subinventory_code(+)
  AND kipb.locator_penerima_barang = TO_CHAR(mil.inventory_location_id(+))
  --hanya menampilkan yang sudah verifikasi, sudah transact reject blm transact seksi
  AND kipb.status_verifikasi NOT IN ('Belum Verifikasi', 'Menunggu Hasil Verifikasi QC')
  AND (SELECT mtrl.quantity_delivered
          FROM mtl_txn_request_headers mtrh, mtl_txn_request_lines mtrl
        WHERE kipb.mo_rej = mtrh.request_number
          AND mtrh.header_id = mtrl.header_id
          AND mtrl.inventory_item_id = msib.inventory_item_id) IS NOT NULL
  AND (SELECT mtrl.quantity_delivered
          FROM mtl_txn_request_headers mtrh, mtl_txn_request_lines mtrl
        WHERE kipb.mo_seksi = mtrh.request_number
          AND mtrh.header_id = mtrl.header_id
          AND mtrl.inventory_item_id = msib.inventory_item_id) IS NULL
ORDER BY 1";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getDataVerif(){
    $sql = "SELECT   kipb.*, msib.inventory_item_id,
    msib.description nama_komponen, msib.primary_uom_code uom, 
    NVL(mil.segment1, kipb.locator_penerima_barang) LOCATOR,
    (SYSDATE - NVL(kipb.tgl_order_verifikasi, SYSDATE)) lt_qc,
    (SYSDATE - NVL(kipb.tgl_verifikasi, SYSDATE)) lt_gudang
    FROM khs_inv_pengembalian_barang kipb,
    mtl_system_items_b msib,
    mtl_item_locations mil
    WHERE kipb.kode_komponen = msib.segment1
    AND msib.organization_id = 81
    AND kipb.subinv_penerima_barang = mil.subinventory_code(+)
    AND kipb.locator_penerima_barang = TO_CHAR(mil.inventory_location_id(+))
    --hanya menampilkan yang sudah order verifikasi
    AND kipb.status_verifikasi != 'Belum Verifikasi'
    ORDER BY kipb.tgl_order_verifikasi DESC";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function UpdateStatusVerif($id_pengembalian, $status_verifikasi, $tgl_order_verif){
    $sql = "UPDATE khs_inv_pengembalian_barang
    SET status_verifikasi = '$status_verifikasi',
    tgl_order_verifikasi = TO_DATE ('$tgl_order_verif', 'YYYY/MM/DD HH24:MI:SS')
    WHERE id_pengembalian = $id_pengembalian";
    $query = $this->oracle->query($sql);
    $query = $this->oracle->query('commit');
    $response = 1;
    return $response;
  }

  public function getEmailQC(){
    $sql = "SELECT pde.email
    FROM pbg.pbg_data_email pde
    WHERE pde.keterangan = 'QC'";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function UpdateStatusVerifQC($id_pengembalian, $status_verifikasi, $tgl_verif){
    $sql = "UPDATE khs_inv_pengembalian_barang
    SET status_verifikasi = '$status_verifikasi', 
        tgl_verifikasi = TO_DATE ('$tgl_verif', 'YYYY/MM/DD HH24:MI:SS')
    WHERE id_pengembalian = $id_pengembalian";
    $query = $this->oracle->query($sql);
    $query = $this->oracle->query('commit');
  }

  public function UpdateKetVerif($id_pengembalian, $ket_verif){
    $sql = "UPDATE khs_inv_pengembalian_barang
    SET keterangan = '$ket_verif'
    WHERE id_pengembalian = $id_pengembalian";
    $query = $this->oracle->query($sql);
    $query = $this->oracle->query('commit');
  }

  public function UpdateSeksiPenerimaBrg($id_pengembalian, $subinv_penerima_brg, $loc_penerima_brg){
    $sql = "UPDATE khs_inv_pengembalian_barang
    SET subinv_penerima_barang = '$subinv_penerima_brg', locator_penerima_barang = '$loc_penerima_brg'
    WHERE id_pengembalian = $id_pengembalian";
    $query = $this->oracle->query($sql);
    $query = $this->oracle->query('commit');
  }

  public function getEmailGudang(){
    $sql = "SELECT pde.email
    FROM pbg.pbg_data_email pde
    WHERE pde.keterangan = 'GUDANG'";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getData($id_pengembalian){
    $sql = "SELECT kipb.*, msib.inventory_item_id,
    msib.description nama_komponen, NVL(mil.segment1, kipb.locator_penerima_barang) LOCATOR
    FROM khs_inv_pengembalian_barang kipb, mtl_system_items_b msib, mtl_item_locations mil
    WHERE kipb.kode_komponen = msib.segment1
    AND msib.organization_id = 81
    AND kipb.subinv_penerima_barang = mil.subinventory_code(+)
    AND kipb.locator_penerima_barang = TO_CHAR(mil.inventory_location_id(+))
    AND kipb.id_pengembalian = '$id_pengembalian'";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getRekapPBG($tgl_awal, $tgl_akhir){
    $sql = "SELECT   kipb.*, msib.inventory_item_id,
    msib.description nama_komponen, NVL(mil.segment1, kipb.locator_penerima_barang) LOCATOR,
    mo.quantity, mo.quantity_detailed, mo.quantity_delivered,
    (CASE
        WHEN NVL (mo.quantity, 0) =
                                    NVL (mo.quantity_delivered, 0)
        AND kipb.mo_seksi != 0
            THEN 'CLOSE'
        ELSE 'OPEN'
      END
    ) status
    FROM khs_inv_pengembalian_barang kipb,
    mtl_system_items_b msib,
    mtl_item_locations mil,
    (SELECT mtrh.request_number, mtrl.quantity,
            mtrl.quantity_detailed, mtrl.quantity_delivered
        FROM mtl_txn_request_headers mtrh,
            mtl_txn_request_lines mtrl
      WHERE mtrh.header_id = mtrl.header_id) mo
    WHERE kipb.kode_komponen = msib.segment1
    AND msib.organization_id = 81
    AND kipb.subinv_penerima_barang = mil.subinventory_code(+)
    AND kipb.locator_penerima_barang = TO_CHAR(mil.inventory_location_id(+))
    AND mo.request_number(+) = kipb.mo_seksi
    AND TRUNC (kipb.tgl_input) BETWEEN TO_DATE ('$tgl_awal', 'YYYY-MM-DD')
                                AND TO_DATE ('$tgl_akhir', 'YYYY-MM-DD')
    ORDER BY 1";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getEmail(){
    $sql = "SELECT pde.*
    FROM pbg.pbg_data_email pde";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getEmailPic($term){
    $sql = "SELECT ea.internal_mail
    FROM er.er_employee_all ea 
    WHERE ea.employee_code ||' - '|| ea.employee_name = '$term'";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function SaveEmail($pic, $email, $ket){
    $sql = "INSERT INTO pbg.pbg_data_email (pic, email, keterangan)
    VALUES('$pic', '$email', '$ket')";
    $query = $this->db->query($sql);
  }

  public function DeleteEmail($pic, $email, $ket){
    $sql = "DELETE FROM pbg.pbg_data_email 
    WHERE pic = '$pic' 
    AND email = '$email'
    AND keterangan = '$ket'";
    $query = $this->db->query($sql);
  }

  public function checkMoRej($id_pengembalian){
    $sql = "SELECT kipb.mo_rej no_mo
    FROM khs_inv_pengembalian_barang kipb
    WHERE kipb.id_pengembalian = $id_pengembalian AND kipb.mo_rej != 0";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function checkMoSeksi($id_pengembalian){
    $sql = "SELECT kipb.mo_seksi no_mo
    FROM khs_inv_pengembalian_barang kipb
    WHERE kipb.id_pengembalian = $id_pengembalian AND kipb.mo_seksi != 0";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getAtt($id, $fromsub, $fromloc){
    $sql = "SELECT kipb.*, msib.organization_id, msib.inventory_item_id,
    khs_inv_qty_att (msib.organization_id,
                      msib.inventory_item_id,
                      '$fromsub',
                      $fromloc,
                      NULL
                    ) att,
    msib.primary_uom_code
    FROM mtl_system_items_b msib, khs_inv_pengembalian_barang kipb
    WHERE msib.organization_id = 102
    AND kipb.id_pengembalian = '$id'
    AND msib.segment1 = kipb.kode_komponen";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getNoMo(){
    $sql = "SELECT TO_CHAR (SYSDATE, 'RRMM')
    || LPAD (khsseq_mokb.NEXTVAL, 4, '0') no_mo
    FROM DUAL";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  function createTemp($data){
    $sql = "INSERT INTO CREATE_MO_KIB_TEMP(NO_URUT, INVENTORY_ITEM_ID, QUANTITY, UOM, IP_ADDRESS, NO_MO) VALUES 
    ($data[NO_URUT], $data[INVENTORY_ITEM_ID], $data[QUANTITY], '$data[UOM]', '$data[IP_ADDRESS]', '$data[NO_MO]')";
    $this->oracle->trans_start();
    $this->oracle->query($sql);
    $this->oracle->trans_complete();
    // $this->oracle->trans_start();
    // $this->oracle->insert('CREATE_MO_KIB_TEMP',$data);
    // $this->oracle->trans_complete();
  }

  function deleteTemp($ip, $no_mo){
    $sql = "DELETE FROM CREATE_MO_KIB_TEMP WHERE IP_ADDRESS = '$ip' AND NO_MO = '$no_mo' ";
    $this->oracle->trans_start();
    $this->oracle->query($sql);
    $this->oracle->trans_complete();
  }
    
  function createMo($fromsub, $fromloc, $tosub, $toloc, $ip_address, $no_mo, $user_id){
    // echo "<pre>";
    // echo ':P_PARAM1 = '.$fromsub.'<br>'; 
    // echo ':P_PARAM2 = '.$fromloc.'<br>';
    // echo ':P_PARAM3 = '.$tosub.'<br>';
    // echo ':P_PARAM4 = '.$toloc.'<br>';
    // echo ':P_PARAM5 = '.$ip_address.'<br>';
    // echo ':P_PARAM6 = '.$no_mo.'<br>';
    // echo ':P_PARAM7 = '.$user_id.'<br>';
        // exit();
        
    // $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
    $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
      if (!$conn) {
          $e = oci_error();
          trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
      }
      
    $sql =  "BEGIN APPS.KHSCREATEMO.create_header_allocate(:P_PARAM1,:P_PARAM2,:P_PARAM3,:P_PARAM4,:P_PARAM5,:P_PARAM6,:P_PARAM7); END;";

    //Statement does not change
    $stmt = oci_parse($conn,$sql);                     
    oci_bind_by_name($stmt,':P_PARAM1',$fromsub);           
    oci_bind_by_name($stmt,':P_PARAM2',$fromloc); 
    oci_bind_by_name($stmt,':P_PARAM3',$tosub);
    oci_bind_by_name($stmt,':P_PARAM4',$toloc);
    oci_bind_by_name($stmt,':P_PARAM5',$ip_address);
    oci_bind_by_name($stmt,':P_PARAM6',$no_mo);
    oci_bind_by_name($stmt,':P_PARAM7',$user_id);
    
    // But BEFORE statement, Create your cursor
    $cursor = oci_new_cursor($conn);
    
    // Execute the statement as in your first try
    oci_execute($stmt);
    
    // and now, execute the cursor
    oci_execute($cursor);
  }

  public function UpdateMoRej($id_pengembalian, $mo_rej){
    $sql = "UPDATE khs_inv_pengembalian_barang
    SET mo_rej = '$mo_rej'
    WHERE id_pengembalian = $id_pengembalian";
    $query = $this->oracle->query($sql);
    $query = $this->oracle->query('commit');
  }

  public function UpdateMoSeksi($id_pengembalian, $mo_seksi){
    $sql = "UPDATE khs_inv_pengembalian_barang
    SET mo_seksi = '$mo_seksi'
    WHERE id_pengembalian = $id_pengembalian";
    $query = $this->oracle->query($sql);
    $query = $this->oracle->query('commit');
  }

  public function getDataMo($no_mo){
    $sql = "SELECT   mtrh.request_number no_btag, mtrh.move_order_type move_order_type,
    mfg2.meaning move_order_type_name,
    DECODE (mtrh.description, NULL, '', mtrh.description) description,
    mtrl.header_id header_id, msib.segment1 kode_barang,
    msib.description nama_barang,
    mtrl.from_subinventory_code from_subinventory_code,
    mtrl.to_subinventory_code to_subinventory_code, mtrl.from_locator_id,
    mtrl.to_locator_id, mtrl.uom_code uom_code,
    (SELECT segment1
        FROM mtl_item_locations
      WHERE inventory_location_id = mtrl.from_locator_id) from_loc,
    (SELECT segment1
        FROM mtl_item_locations
      WHERE inventory_location_id = mtrl.to_locator_id) to_loc,
    mtrl.quantity qty_minta, mtrl.required_quantity required_quantity,
    mtrl.quantity_delivered quantity_delivered,
    mtrl.quantity_detailed quantity_detailed,
    mtrl.date_required tanggal_btag,
    (SELECT lokasi
        FROM khsinvlokasisimpan
      WHERE inventory_item_id = mtrl.inventory_item_id
        AND subinv = mtrl.from_subinventory_code
        AND ROWNUM = 1) lokasi_asal,
    (SELECT lokasi
        FROM khsinvlokasisimpan
      WHERE inventory_item_id = mtrl.inventory_item_id
        AND subinv = mtrl.to_subinventory_code
        AND ROWNUM = 1) lokasi_tujuan,
    DECODE (mtrl.REFERENCE,
            NULL, '',
            '(' || mtrl.REFERENCE || ')'
            ) refer
    FROM mtl_txn_request_lines mtrl,
    mtl_txn_request_headers mtrh,
    mtl_transaction_types mtt,
    mtl_secondary_inventories mss,
    mtl_secondary_inventories mss1,
    fnd_lookup_values mfg,
    fnd_lookup_values mfg2,
    cst_cost_groups cst,
    cst_cost_groups cst2,
    wms_license_plate_numbers from_wlpn,
    wms_license_plate_numbers to_wlpn,
    mtl_system_items_b msib
    WHERE mtrh.header_id = mtrl.header_id
    AND mtt.transaction_type_id = mtrl.transaction_type_id
    AND mss.secondary_inventory_name(+) = mtrl.from_subinventory_code
    AND mss.organization_id(+) = mtrl.organization_id
    AND mss1.secondary_inventory_name(+) = mtrl.to_subinventory_code
    AND mss1.organization_id(+) = mtrl.organization_id
    AND mfg.lookup_type = 'MTL_TXN_REQUEST_STATUS'
    AND mfg.lookup_code = TO_CHAR (mtrl.line_status)
    AND mfg2.lookup_type = 'MOVE_ORDER_TYPE'
    AND mfg2.lookup_code = TO_CHAR (mtrh.move_order_type)
    AND cst.cost_group_id(+) = mtrl.from_cost_group_id
    AND cst2.cost_group_id(+) = mtrl.to_cost_group_id
    AND mtrl.lpn_id = from_wlpn.lpn_id(+)
    AND mtrl.to_lpn_id = to_wlpn.lpn_id(+)
    AND mtrl.inventory_item_id = msib.inventory_item_id
    AND mtrl.organization_id = msib.organization_id
    AND mtrh.move_order_type = 1
    AND mtrh.organization_id = '102'
    AND mtrh.header_status IN (3, 7)
    AND mtrl.line_status IN (3, 7)
    AND TO_CHAR (mtrh.request_number) = '$no_mo'
    ORDER BY mtrh.request_number ASC";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  // perbedaan dengan query di atas terdapat pada kolom refer
  public function getDataMoSeksi($no_mo){
    $sql = "SELECT   mtrh.request_number no_btag, mtrh.move_order_type move_order_type,
    mfg2.meaning move_order_type_name,
    DECODE (mtrh.description, NULL, '', mtrh.description) description,
    mtrl.header_id header_id, msib.segment1 kode_barang,
    msib.description nama_barang,
    mtrl.from_subinventory_code from_subinventory_code,
    mtrl.to_subinventory_code to_subinventory_code, mtrl.from_locator_id,
    mtrl.to_locator_id, mtrl.uom_code uom_code,
    (SELECT segment1
        FROM mtl_item_locations
      WHERE inventory_location_id = mtrl.from_locator_id) from_loc,
    (SELECT segment1
        FROM mtl_item_locations
      WHERE inventory_location_id = mtrl.to_locator_id) to_loc,
    mtrl.quantity qty_minta, mtrl.required_quantity required_quantity,
    mtrl.quantity_delivered quantity_delivered,
    mtrl.quantity_detailed quantity_detailed,
    mtrl.date_required tanggal_btag,
    (SELECT lokasi
        FROM khsinvlokasisimpan
      WHERE inventory_item_id = mtrl.inventory_item_id
        AND subinv = mtrl.from_subinventory_code
        AND ROWNUM = 1) lokasi_asal,
    (SELECT lokasi
        FROM khsinvlokasisimpan
      WHERE inventory_item_id = mtrl.inventory_item_id
        AND subinv = mtrl.to_subinventory_code
        AND ROWNUM = 1) lokasi_tujuan,
    kipb.keterangan refer
--    DECODE (mtrl.REFERENCE,
--            NULL, '',
--            '(' || mtrl.REFERENCE || ')'
--            ) refer
    FROM mtl_txn_request_lines mtrl,
    mtl_txn_request_headers mtrh,
    mtl_transaction_types mtt,
    mtl_secondary_inventories mss,
    mtl_secondary_inventories mss1,
    fnd_lookup_values mfg,
    fnd_lookup_values mfg2,
    cst_cost_groups cst,
    cst_cost_groups cst2,
    wms_license_plate_numbers from_wlpn,
    wms_license_plate_numbers to_wlpn,
    mtl_system_items_b msib,
    khs_inv_pengembalian_barang kipb
    WHERE mtrh.header_id = mtrl.header_id
    AND mtt.transaction_type_id = mtrl.transaction_type_id
    AND mss.secondary_inventory_name(+) = mtrl.from_subinventory_code
    AND mss.organization_id(+) = mtrl.organization_id
    AND mss1.secondary_inventory_name(+) = mtrl.to_subinventory_code
    AND mss1.organization_id(+) = mtrl.organization_id
    AND mfg.lookup_type = 'MTL_TXN_REQUEST_STATUS'
    AND mfg.lookup_code = TO_CHAR (mtrl.line_status)
    AND mfg2.lookup_type = 'MOVE_ORDER_TYPE'
    AND mfg2.lookup_code = TO_CHAR (mtrh.move_order_type)
    AND cst.cost_group_id(+) = mtrl.from_cost_group_id
    AND cst2.cost_group_id(+) = mtrl.to_cost_group_id
    AND mtrl.lpn_id = from_wlpn.lpn_id(+)
    AND mtrl.to_lpn_id = to_wlpn.lpn_id(+)
    AND mtrl.inventory_item_id = msib.inventory_item_id
    AND mtrl.organization_id = msib.organization_id
    AND mtrh.move_order_type = 1
    AND mtrh.organization_id = '102'
    AND mtrh.header_status IN (3, 7)
    AND mtrl.line_status IN (3, 7)
    AND TO_CHAR (mtrh.request_number) = kipb.mo_seksi
    AND msib.segment1 = kipb.kode_komponen
    AND TO_CHAR (mtrh.request_number) = '$no_mo'
    ORDER BY mtrh.request_number ASC";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function deleteInputan($id_pengembalian){
    $sql = "DELETE FROM khs_inv_pengembalian_barang
    WHERE id_pengembalian = $id_pengembalian";
    $query = $this->oracle->query($sql);            
    $query2 = $this->oracle->query('commit');
  }

  public function SaveUpdate($id_pengembalian, $seksi){
    $sql = "UPDATE khs_inv_pengembalian_barang
    SET locator_penerima_barang = '$seksi'
    WHERE id_pengembalian = $id_pengembalian";
    $query = $this->oracle->query($sql);
    $query = $this->oracle->query('commit');
    $response = 1;
    return $response;
    // $this->oracle->where('id_pengembalian', $id_pengembalian)->update('khs_inv_pengembalian_barang', $data);
    //   if ($this->oracle->affected_rows() == 1) {
    //     return 1;
    //   } else {
    //     return 0;
    // }
  }

  public function getDataBlmVerif(){
    $sql = "SELECT   kipb.*, msib.inventory_item_id,
    msib.description nama_komponen, msib.primary_uom_code uom
    FROM khs_inv_pengembalian_barang kipb,
    mtl_system_items_b msib
    WHERE kipb.kode_komponen = msib.segment1
    AND msib.organization_id = 81
    --hanya menampilkan data yang sudah create verifikasi qc tapi belum input verif oleh qc
    AND kipb.status_verifikasi IN ('Menunggu Hasil Verifikasi QC')
    ORDER BY kipb.tgl_order_verifikasi DESC";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

}

?>