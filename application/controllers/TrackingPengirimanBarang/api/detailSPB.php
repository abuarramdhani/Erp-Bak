<?php
  include './connection.php';
  include './session.php';

  $no_spb = $_POST['no_spb'];
  if (empty($no_spb)) {
    echo json_encode(array(
      'ok' => false,
      'msg' => 'parameter tidak boleh kosong',
      'data' => []
    ));die();
  }
  $query = "SELECT distinct mtrh.REQUEST_NUMBER \"NO SPB\"
                ,mtrh.ATTRIBUTE7 \"SO\"
                ,party.PARTY_NAME \"CUST\"
                ,ship_loc.address1 \"ALAMAT\"
                ,msib.SEGMENT1 \"KODE ITEM\"
                ,msib.DESCRIPTION \"NAMA ITEM\"
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
AND ooha.sold_to_org_id = cust_acct.cust_account_id(+)
AND cust_acct.party_id = party.party_id(+)
and ooha.ship_to_org_id = ship_su.site_use_id(+)
AND ship_su.cust_acct_site_id = ship_cas.cust_acct_site_id(+)
AND ship_cas.party_site_id = ship_ps.party_site_id(+)
AND ship_loc.location_id(+) = ship_ps.location_id
and mtrh.REQUEST_NUMBER = :no_spb";
  $stmt = oci_parse($conn, $query);
  oci_bind_by_name($stmt, ':no_spb', $no_spb);
  oci_execute($stmt);

  $dataRows = array();
  while ($row = oci_fetch_assoc($stmt)) {
    $dataRows[] = $row;
  }

  $data = array(
    'ok' => true,
    'data' => $dataRows,
    'msg' => "Berhasil",
    'err' => oci_error()
  );

  header('Content-Type: application/json');
  echo json_encode($data);
 ?>
