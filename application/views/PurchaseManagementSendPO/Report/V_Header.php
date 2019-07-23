  <table  style="width: 100%;" >
      <tr>
        <td style="width: 100%; text-align: left;" ><p style="font-size:10px;"><b>CV KARYA HIDUP SENTOSA<br>YOGYAKARTA</b></p></td>
        <td style="height: 20%; width: 20%; text-align: right; border-right: 0px solid black" class="konten" rowspan="3" >
                <img  style=" float:right; width:20%; padding: 0;margin-top: 5mm;  height:auto;" src="img/".<?php echo $DETAIL[0]['DATALIST'][0]['MOVE_ORDER_NO'].".png"; ?>" />
        </td>
      </tr>
      <tr>
        <td style="font-size:12px;text-align: center;"><p  class="text-center" ><b>PICK LIST GUDANG (ODM)</b></p></td>
      </tr>
  </table>
  
  <table width="100%">
    <tr>
      <td>Tanggal Cetak</td><td>:<?php echo $DETAIL[0]['DATALIST'][0]['PRINT_DATE']; ?></td>
      <td>Hal</td><td>:</td>
    </tr>
    <tr>
      <td>Lokasi</td><td>:<?php echo $DETAIL[0]['DATALIST'][0]['LOKASI']; ?></td>
      <td>Batch No</td><td>:<?php echo $DETAIL[0]['DATALIST'][0]['BATCH_NO']; ?></td>
    </tr>
    <tr>
      <td>Tanggal Dipakai</td><td>:<?php echo $DETAIL[0]['DATALIST'][0]['DATE_REQUIRED']; ?></td>
      <td>Departement</td><td>:<?php echo $DETAIL[0]['DATALIST'][0]['ROUTING_CLASS']; ?></td>
    </tr>
    <tr>
      <td>Shift</td><td>:<?php echo $DETAIL[0]['DATALIST'][0]['SCHEDULE']; ?></td>
    </tr>
  </table>

