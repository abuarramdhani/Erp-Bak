<?php
  require_once './session.php';
  require_once './connection.php';

 $no_spb = $_POST['no_spb'];
 $status = $_POST['status'];
 $kendaraan = $_POST['kendaraan'];

 if (empty($no_spb) || empty($status) || empty($kendaraan)) {
   $data = array(
     'ok' => false,
     'msg' => "Data tidak boleh kosong",
     'data' => []
   );
   echo json_encode($data);die();
 }

 $stmt = $conn_sql->prepare("UPDATE tpb SET kendaraan = ?, last_update_date = now(), status = ?, start_date = now() where no_spb = ?");
 $stmt->bind_param("sss", $kendaraan, $status, $no_spb);
 $stmt->execute();

 $newStmt = $conn_sql->prepare("SELECT * FROM tpb where no_spb = ?");
 $newStmt->bind_param("s", $no_spb);
 $newStmt->execute();
 $dataRow[] = $newStmt->get_result()->fetch_assoc();
 $data = array(
   'ok' => true,
   'msg' => "Berhasil",
   'data' => $dataRow
 );

 echo json_encode($data);

 $query = "SELECT distinct mtrh.REQUEST_NUMBER \"NO_SPB\"
                					,mtrh.ATTRIBUTE7 \"SO\"
                					,party.PARTY_NAME \"CUST\"
                					,ship_loc.address1 \"ALAMAT\"
                					,msib.SEGMENT1 \"KODE_ITEM\"
                					,msib.DESCRIPTION \"NAMA_ITEM\"
                					,mtrl.quantity \"QTY\"
                					,msib.PRIMARY_UOM_CODE \"UOM\"
                			FROM mtl_txn_request_headers mtrh
                  	 		  ,mtl_txn_request_lines mtrl
                  	 		  ,MTL_SYSTEM_ITEMS_B msib
                  				,oe_order_headers_all ooha
                  				,hz_parties party
                  				,hz_cust_accounts cust_acct
                  				,hz_locations ship_loc
                  				,hz_cust_site_uses_all ship_su
                  				,hz_cust_acct_sites_all ship_cas
                  				,hz_party_sites ship_ps
                    where mtrh.HEADER_ID(+) = mtrl.header_id
                			and mtrl.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
                			and mtrh.ATTRIBUTE7 = ooha.ORDER_NUMBER
                			and ooha.sold_to_org_id = cust_acct.cust_account_id(+)
                			and cust_acct.party_id = party.party_id(+)
                			and ooha.ship_to_org_id = ship_su.site_use_id(+)
                			and ship_su.cust_acct_site_id = ship_cas.cust_acct_site_id(+)
                			and ship_cas.party_site_id = ship_ps.party_site_id(+)
                			and ship_loc.location_id(+) = ship_ps.location_id
                			and mtrh.REQUEST_NUMBER = :no_spb";
  $stmt2 = oci_parse($conn, $query);
  oci_bind_by_name($stmt2, ':no_spb', $no_spb);
  oci_execute($stmt2);
  $dataRows = array();
  while ($row = oci_fetch_assoc($stmt2)) {
	   $dataRows[] = $row;
  }

  foreach($dataRows as $key => $value){
    $no_spb     = $value['NO_SPB'];
    $so         = $value['SO'];
    $cust       = $value['CUST'];
    $alamat     = $value['ALAMAT'];
    $kode_item  = $value['KODE_ITEM'];
    $nama_item  = $value['NAMA_ITEM'];
    $qty        = $value['QTY'];
    $uom        = $value['UOM'];

	  $query = "INSERT INTO tpb_spb(no_spb, so, cust, alamat, kode_item, nama_item, qty, uom, confirmation_status) values(?,?,?,?,?,?,?,?, NULL)";
    $stmt3 = $conn_sql->prepare($query);
    $stmt3->bind_param("ssssssss", $no_spb, $so, $cust, $alamat, $kode_item, $nama_item, $qty, $uom);
    $stmt3->execute();
  }
  
?>
