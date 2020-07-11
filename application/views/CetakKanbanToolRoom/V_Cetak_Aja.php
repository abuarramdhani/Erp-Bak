<?php foreach ($kode_barang as $i => $kode_): ?>
  <?php for ($a=0; $a < $jumlah_cetak[$i]; $a++) { ?>
    <div  width= "49,5%"  style="float: left; margin-left:5px;">
      <table width="100%" style="margin-top: 2px; margin-bottom:10px; border: 1px solid black; padding: 0px;border-collapse: collapse;">
          <tr>
            <th align="center" rowspan="6" style="font-size: 7px; border-right: 1px solid black; border-bottom: 1px solid black;">
              <img style=""  src="<?php echo base_url('assets/img/'.$idunix[$i].'.png');?>">
              <center> <span style="font-size:5px;"><?php echo $idunix[$i] ?></span> </center>
            </th>
          </tr>
          <tr>
            <th align="left" style="width: 80px;font-size: 7px; border-bottom: 1px solid black;padding-left:5px;"><b>ITEM NO</b></th>
            <td align="left" style="font-size: 10px; border-right: 1px solid black;border-bottom: 1px solid black;font-weight:bold">: <?php echo ($a+1).'/'.$jumlah_cetak[$i]; ?></td>
          </tr>
          <tr>
            <th align="left" style="width: 80px;font-size: 7px; border-bottom: 1px solid black;padding-left:5px;"><b>KODE BARANG</b></th>
            <td align="left" style="font-size: 10px; border-right: 1px solid black;border-bottom: 1px solid black;">: <?php echo $kode_; ?></td>
          </tr>
          <tr>
            <th align="left" style="width: 80px;font-size: 7px; border-bottom: 1px solid black;padding-left:5px;"><b>DESKRIPSI</b></th>
            <td align="left" style="font-size: 10px; border-right: 1px solid black;border-bottom: 1px solid black;">: <?php echo $desc[$i]; ?></td>
          </tr>
          <tr>
            <th align="left" style="width: 80px;font-size: 7px; border-bottom: 1px solid black;padding-left:5px;"><b>COST CENTER</b></th>
            <td align="left" style="font-size: 10px; border-right: 1px solid black;border-bottom: 1px solid black;">: <?php echo $cost_center[$i]; ?></td>
          </tr>
          <tr>
            <th align="left" style="width: 80px;font-size: 7px; border-bottom: 1px solid black; height: 13px;padding-left:5px;"><b>NOMOR BPPCT</b></th>
            <td align="left" style="font-size: 10px; border-right: 1px solid black;border-bottom: 1px solid black;">: <?php echo $no_bppbgt[$i]; ?></td>
          </tr>
        <tr>
        </tr>
      </table>
    </div>
  <?php } ?>
<?php endforeach; ?>
