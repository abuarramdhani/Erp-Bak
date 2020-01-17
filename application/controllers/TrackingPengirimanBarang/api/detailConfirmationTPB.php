<?php
  include './connection.php';
  include './session.php';
  
  $no_spb = $_POST['no_spb'];
  if (empty($no_spb)) {
    $data = array(
      'ok' => false,
      'msg' => "parameter tidak boleh kosong",
      'data' => []
    );
    echo json_encode($data);die();
  }
  
 $Stmt = $conn_sql->prepare("SELECT LINE_ID
								   ,NO_SPB 'NO SPB'
								   ,SO 
								   ,CUST
								   ,ALAMAT
								   ,KODE_ITEM 'KODE ITEM'
								   ,NAMA_ITEM 'NAMA ITEM'
								   ,CONVERT(QTY, CHAR) 'QTY'
								   ,UOM
								   ,CONFIRMATION_STATUS 
							  FROM tpb_spb 
							 where no_spb = ?");
 $Stmt->bind_param("s", $no_spb);
 $Stmt->execute(); 
 $rows = $Stmt->get_result();
 $dataRow = array();
 while ($row = $rows->fetch_assoc()) {
   $dataRow[] = $row;
 }
  
 $data = array(
   'ok' => true,
   'data' => $dataRow,
   'msg' => "Berhasil"
 );
 
 header('Content-Type: application/json');
 echo json_encode($data);
 ?>
