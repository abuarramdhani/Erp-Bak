<?php
require_once './session.php';
require_once './connection.php';

$no_spb = $_POST['no_spb'];
$nama_pekerja = $_POST['nama_pekerja'];
$kendaraan = $_POST['kendaraan'];
$status = $_POST['status'];

if (empty($no_spb) || empty($nama_pekerja) || empty($status) || empty($kendaraan)) {
  $data = array(
    'ok' => false,
    'data' => [],
    'msg' => "Data yang dimasukan harus lengkap"
  );
  echo json_encode($data);
  die();
}
header('Content-Type: Application/json');

$cekSPB = $conn_sql->query("SELECT * FROM tpb where no_spb = '$no_spb'");
if ($cekSPB->num_rows != 0) {
  $data = array(
    'ok' => false,
    'data' => [$cekSPB->fetch_assoc()],
    'msg' => "no spb telah digunakan"
  );
  echo json_encode($data);
  die();
}

$query = "INSERT INTO tpb(no_spb, nama_pekerja, kendaraan, last_update_date, status) values(?, ?, ?, now(), ?)";
$stmt = $conn_sql->prepare($query);
$stmt->bind_param("ssss", $no_spb, $nama_pekerja, $kendaraan, $status);
$stmt->execute();

$dataRow = $conn_sql->query("SELECT * FROM tpb where no_spb = '$no_spb'")->fetch_assoc();
$data = array(
  'ok' => true,
  'data' => [$dataRow],
  'msg' => 'Berhasil'
);

echo json_encode($data);
 ?>
