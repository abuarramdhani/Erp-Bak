<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " id="tblMonitoringAssign" style="font-size:12px;width:100%">
    <thead>
      <tr class="bg-primary">
        <th><center>NO</center></th>
        <th><center>NOMOR DO</center></th>
        <th><center>NOMOR SO</center></th>
        <th><center>TUJUAN</center></th>
        <th><center>KOTA</center></th>
        <th><center>PLAT NOMOR</center></th>
        <th><center>ASSIGN</center></th>
        <th><center>DETAIL</center></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $g): ?>
        <tr row-id="<?php echo $no ?>">
          <td><center><?php echo $no; ?></center></td>
          <td><center><?php echo $g['DO/SPB'] ?></center></td>
          <td><center><?php echo $g['NO_SO'] ?></center></td>
          <td><center><?php echo $g['TUJUAN'] ?></center></td>
          <td><center><?php echo $g['KOTA'] ?></center></td>
            <?php
            if ($g['DELIVERY_FLAG'] == 'Y') {
              $attr = 'disabled';
            }elseif($g['DELIVERY_FLAG'] == 'N'){
              $attr = '';
            }

            if ($g['PLAT_NUMBER'] == null) {
              $atribut = '';
            }elseif ($g['PLAT_NUMBER'] != null) {
              $atribut = 'disabled';
            }
             ?>
          <td>
            <input <?php echo $atribut ?> type="text" style="float:left;margin-right:7px;width:70%;height:28px;" name="inputAsiap" id="plat_nomer" value="<?php echo $g['PLAT_NUMBER'] ?>">
            <button <?php echo $attr ?> type="button" class="btn btn-success uppercaseDO" name="buttonAsiap" style="float:left;font-size:10px;" onclick="updateFlag('<?php echo $g['DO/SPB'] ?>', <?php echo $g['HEADER_ID'] ?>, <?php echo $no; ?>)"><i class="fa fa-rocket"></i></button>
          </td>
          <td><center><?php echo $g['PETUGAS'] ?></center></td>
          <td><center><button type="button" class="btn btn-info" name="button" style="font-weight:bold;" onclick="detailAssign('<?php echo $g['DO/SPB'] ?>', <?php echo $no ?>)" data-toggle="modal" data-target="#MyModalAssign"><i class="fa fa-eye"></i></button> </center></td>
        </tr>

      <?php $no++; endforeach; ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $('#tblMonitoringAssign').DataTable();
</script>
