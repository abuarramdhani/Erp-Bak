<div style="margin-bottom:20px">
  <center><b style="font-size:17px" id="presentase_all_co"></b></center>
</div>
<table style="width:100%">
    <?php $all_temuan = $getJumlahGeneralAudite[0]['jumlah_general'];?>
    <tbody>
      <tr>
        <?php foreach ($getStatusGeneralAudite as $key => $status): ?>
        <td style="width:8%;font-weight:bold"><?php echo $status['status'] ?></td>
        <td style="vertical-align:baseline;width:32%">
          <div class="progress" style="margin-bottom:0px">
            <div class="progress-bar progress-bar-info" role="progressbar" style="width:<?php echo $status['persen_per_status'] ?>">
              <span style="color:black"><?php echo $status['persen_per_status'] ?></span>
            </div>
          </div>
        </td>
        <td style="<?php echo $key != 0 ? 'width:10%;' : '' ?>padding-left:10px"><?php echo $status['jumlah_per_status'].' dari '.$all_temuan; ?></td>
        <?php endforeach; ?>
      </tr>
    </tbody>
</table>
<div style="margin-top:20px">
  <center><b style="font-size:17px" id="presentase_all_pp"></b></center>
</div>
<table style="width:100%">
  <tbody>
    <?php foreach ($getGeneralPoinPenyimpangan as $key => $pp): //$i = 0;?>
    <tr>
        <td style="width:50%;font-weight:bold;<?php echo $key != 0 ? 'padding-top:9px' : 'padding-top:12px' ?>"><?php echo $pp['poin_penyimpangan'] ?></td>
        <td style="vertical-align:baseline;width:40%;<?php echo $key != 0 ? 'padding-top:9px' : 'padding-top:12px' ?>">
          <div class="progress" style="margin-bottom:0px">
            <div class="progress-bar" role="progressbar" style="width:<?php echo $pp['persen_per_pp'] ?>">
              <span style="color:black"><?php echo $pp['persen_per_pp'] ?></span>
            </div>
          </div>
        </td>
        <td style="width:10%;padding-left:10px;<?php echo $key != 0 ? 'padding-top:9px' : 'padding-top:12px' ?>"><?php echo $pp['jumlah_per_pp'].' dari '.$all_temuan ?></td>
        <?php //echo ($i+1) % 2 == 0 ? '</tr>' : '' ?>
    <tr>
    <?php endforeach;//$i++; ?>
  </tbody>
</table>
