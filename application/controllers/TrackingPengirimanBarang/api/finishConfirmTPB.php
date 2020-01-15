<?php
  include './connection.php';
  include './session.php';
  
  $no_spb = $_POST['no_spb'];
  $line_id = $_POST['line_id'];
  $confirmation_status = $_POST['confirmation_status'];
  $note = $_POST['note'];
  $confirmed_by = $_POST['confirmed_by'];
  
  if (empty($no_spb) || empty($line_id)) {
    $data = array(
      'ok' => false,
      'msg' => "parameter tidak boleh kosong",
      'data' => []
    );
    echo json_encode($data);die();
  }
  
 $Stmt = $conn_sql->prepare("UPDATE tpb_spb
							    SET confirmation_status = ?
							  WHERE LINE_ID = ?");
 $Stmt->bind_param("ss", $confirmation_status, $line_id);
 $Stmt->execute(); 
 
 $NewStmt = $conn_sql->prepare("SELECT LINE_ID
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
							 where no_spb = ?
							   and line_id = ?");
 $NewStmt->bind_param("ss", $no_spb, $line_id);
 $NewStmt->execute(); 
 $rows = $NewStmt->get_result();
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
 
 //update header
  $countConfirmStmt = $conn_sql->prepare("select count(confirmation_status) jumlah
									        from tpb_spb
										   where no_spb = ?");
  $countConfirmStmt->bind_param("s", $no_spb);
  $countConfirmStmt->execute(); 
  $hasilCountConfirms = $countConfirmStmt->get_result();
  $hasilCountConfirm = $hasilCountConfirms->fetch_assoc();
  
  $countDataStmt = $conn_sql->prepare("select count(kode_item) jumlah
									 	 from tpb_spb
									    where no_spb = ?");
  $countDataStmt->bind_param("s", $no_spb);
  $countDataStmt->execute(); 
  $hasilCountDatas = $countDataStmt->get_result();
  $hasilCountData = $hasilCountDatas->fetch_assoc();
 
  if($hasilCountConfirm == $hasilCountData){
	  $updateHeaderStmt = $conn_sql->prepare("update tpb
											     set confirmation = (select *
																	   from (select distinct confirmation_status from tpb_spb where no_spb = ? and confirmation_status = 'Y'
																	          UNION 
																			 select distinct confirmation_status from tpb_spb where no_spb = ? and confirmation_status = 'N'
																		     order by confirmation_status) confirm
																	  LIMIT 1),
													 note = ?,
													 confirmed_by = ?,
													 last_update_date = now(),
													 end_date = now(),
													 status = 'onFinish'
									    where no_spb = ?");
	  $updateHeaderStmt->bind_param("sssss", $no_spb, $no_spb, $note, $confirmed_by, $no_spb);
	  $updateHeaderStmt->execute();	  
  }
 
 ?>
