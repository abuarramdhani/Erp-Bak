<!DOCTYPE html>
<html>
<head>
    <table width="100%">
        <tr>
            <td width="100%;" style="text-align: center; font-family: times; font-size: 14px;"><h2><b>Data Rekap Tambahan Makan Pekerja Dinas</b></h2></td>
        </tr>
        <tr>
            <td style="text-align: center; padding-bottom: 50px; font-family: times; font-size: 11px;"><h4>Dicetak Oleh Seksi General Affair pada Tanggal <?php echo date('d F Y H:i:s'); ?> WIB</h4></td>
        </tr>
    </table>
</head>
<body>
	<div style="width: 100%">
		<div style="width: 100%">
		</div>
        <?php
        $i = 0;
        $newArr = array();
        foreach ($tambahan as $key):
            $newArr[date('Y-m-d', strtotime($key['fd_tanggal']))][] = $key;
         endforeach;

         foreach ($newArr as $key) {
             echo '<b>Tanggal : '.array_keys($newArr)[$i].'</b>';
             ?>
           <table  class="table table-bordered" width="100%" border="1" style="border: 1px solid black; border-collapse: collapse;">
            <thead>
              <tr>
                <td style="font-family: times; font-size: 12px; text-align: center; font-weight: bold; background-color: #bfeff5; width: 5%;">No</td>
                <td style="font-family: times; font-size: 12px; text-align: center; font-weight: bold; background-color: #bfeff5; width: 10%">No. Induk</td>
                <td style="font-family: times; font-size: 12px; text-align: center; font-weight: bold; background-color: #bfeff5; width: 25%">Nama</td>
                <td style="font-family: times; font-size: 12px; text-align: center; font-weight: bold; background-color: #bfeff5; width: 15%">Tujuan</td>
                <td style="font-family: times; font-size: 12px; text-align: center; font-weight: bold; background-color: #bfeff5; width: 45%">Keperluan</td>
              </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1;

                    $a = 0;
                    foreach ($key as $na) {
                        ?>
                        <tr>
                            <td style="text-align: center; font-family: times; font-size: 12px;"><?php echo $no; ?></td>
                            <td style="text-align: center; font-family: times; font-size: 12px;"><?php echo $na['fs_noind']; ?></td>
                            <td style="font-family: times; font-size: 12px;"><?php echo $na['fs_nama']; ?></td>
                            <td style="font-family: times; font-size: 12px;"><?php echo $na['fs_tempat_makan']; ?></td>
                            <td style="font-family: times; font-size: 12px;"><?php echo ucwords(mb_strtolower($na['fs_ket'])); ?></td>
                        </tr>
                    <?php $no++; $a++; } ?>
           </tbody>
           </table>
           <br>
       <?php $i++; }?>
  </div>
</body>
<pagebreak>
<head>
    <table width="100%">
        <tr>
            <td width="100%;" style="text-align: center; font-family: times; font-size: 14px;"><h2><b>Data Rekap Pengurangan Makan Pekerja Dinas</b></h2></td>
        </tr>
        <tr>
            <td style="text-align: center; padding-bottom: 50px; font-family: times; font-size: 11px;"><h4>Dicetak Oleh Seksi General Affair pada Tanggal <?php echo date('d F Y H:i:s'); ?> WIB</h4></td>
        </tr>
    </table>
</head>
<tbody style="font-family: times; font-size: 12px;">
    <?php
    $i = 0;
    $newArr = array();
    foreach ($kurang as $key):
        $newArr[date('Y-m-d', strtotime($key['fd_tanggal']))][] = $key;
    endforeach;

    foreach ($newArr as $key) {
        echo '<b>Tanggal : '.array_keys($newArr)[$i].'</b>';
        ?>
        <table  class="table table-bordered" width="100%" border="1" style="border: 1px solid black; border-collapse: collapse;">
            <thead>
                <tr>
                    <td style="font-family: times; font-size: 12px; text-align: center; font-weight: bold; background-color: #bfeff5; width: 5%;">No</td>
                    <td style="font-family: times; font-size: 12px; text-align: center; font-weight: bold; background-color: #bfeff5; width: 10%">No. Induk</td>
                    <td style="font-family: times; font-size: 12px; text-align: center; font-weight: bold; background-color: #bfeff5; width: 25%">Nama</td>
                    <td style="font-family: times; font-size: 12px; text-align: center; font-weight: bold; background-color: #bfeff5; width: 15%">Tempat Makan</td>
                    <td style="font-family: times; font-size: 12px; text-align: center; font-weight: bold; background-color: #bfeff5; width: 45%">Keperluan</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;

                $a = 0;
                foreach ($key as $na) {
                    ?>
                    <tr>
                        <td style="text-align: center; font-family: times; font-size: 12px;"><?php echo $no; ?></td>
                        <td style="text-align: center; font-family: times; font-size: 12px;"><?php echo $na['fs_noind']; ?></td>
                        <td style="font-family: times; font-size: 12px;"><?php echo $na['fs_nama']; ?></td>
                        <td style="font-family: times; font-size: 12px;"><?php echo $na['fs_tempat_makan']; ?></td>
                        <td style="font-family: times; font-size: 12px;"><?php echo ucwords(mb_strtolower($na['fs_ket'])); ?></td>
                    </tr>
                    <?php $no++; $a++; } ?>
                </tbody>
            </table>
            <br>
            <?php $i++; }?>
</tbody>
</html>
