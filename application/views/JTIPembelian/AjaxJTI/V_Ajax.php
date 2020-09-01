<style media="screen">
  .dataTables_length{
    margin-left: -360px !important;
  }
  .dataTables_info{
    margin-left: -260px !important;
  }
</style>
<table class="table table-striped table-bordered table-hover text-left pembelianJTI dataTable" id="tableJTIP" style="font-size:12px;">
  <thead>
    <tr class="bg-primary">
      <th rowspan="2"><center>NO</center></th>
      <th rowspan="2"><center>NO.DOK</center></th>
      <th rowspan="2"><center>JENIS.DOK</center></th>
      <th rowspan="2"><center>TIPE</center></th>
      <th rowspan="2"><center>NAMA DRIVER</center></th>
      <th rowspan="2"><center>NOMOR TIKET</center></th>
      <th rowspan="2"><center>NO POLISI</center></th>
      <th rowspan="2"><center>WAKTU DATANG</center></th>
      <th colspan="3"><center>BERAT TIMBANG</center></th>
      <th rowspan="2"><center>NOTIFIKASI</center></th>
      <th rowspan="2"><center>RESPONSE</center></th>
      <th rowspan="2"><center>AKSI</center></th>
    </tr>
    <tr class="bg-primary">
      <th style="border-top:0px solid white;"><center>KE_1</center></th>
      <th style="border-right:1px solid white;border-top:0px solid white;"><center>KE_2</center></th>
      <th style="border-right:1px solid white;border-top:0px solid white;"><center>SELISIH</center></th>
    </tr>
  </thead>
  <tbody>

    <?php $no = 1; foreach ($get as $g): ?>
      <?php if(!empty($g['report']) && $g['done'] == 'f') {
        $sty = 'style="background:#ff994f"';
      }elseif(!empty($g['ticket_number_2']) && $g['done'] == 't'){
        $sty = 'style="background:#39faa3"';
      }elseif (!empty($g['ticket_number_2']) && $g['notifid'] == null) {
        $sty = 'style="background:#39faa3"';
      }else {
        $sty = '';
      }?>
      <tr <?php echo $sty; ?> row-id = <?php echo $no ?> >
        <td><center><?php echo $no ?></center></td>
        <td><center><?php echo $g['document_number'] ?> </center></td>
        <td><center><?php echo $g['document_type'] ?></center></td>
        <td><center><?php echo $g['type'] ?></center></td>
        <td><center style="font-weight:bold" onclick="jtieditmodal('<?php echo $g['document_number'] ?>', '<?php echo $g['name'] ?>', <?php echo $g['driver_id'] ?>)" data-toggle="modal" data-target="#JTIUPDATE"><?php echo $g['name'] ?></center></td>
        <td><center><?php echo empty($g['ticket_number']) ? '-' : $g['ticket_number']  ?></center></td>
        <td><center><?php echo empty($g['vehicle_number']) ? '-' : $g['vehicle_number'] ?></center></td>
        <td><center><?php echo empty($g['created_at']) ? '-' : substr($g['created_at'], 0, 19) ?></center></td>
        <td><center><?php echo empty($g['weight']) ? '-' : $g['weight'].' Kg' ?></center></td>
        <td><center><?php echo empty($g['weight_2']) ? '-' : $g['weight_2'].' Kg' ?></center></td>
        <?php
        if (!empty($g['ticket_number'])) {
          $cek = explode('-', $g['ticket_number']);
          if ($cek[1] == 'O') {
            $selisih = $g['weight'] - $g['weight_2'];
          }else {
            $selisih = $g['weight_2'] - $g['weight'];
          }
        }
        ?>
        <td><center><?php echo empty($selisih) ? '-' : $selisih.' Kg' ?></center></td>
        <td><center></center><?php echo empty($g['report']) ? '<center>-</center>' : $g['report'] ?> </td>
        <td>
          <center>
            <?php if(!empty($g['report'])) { ?>
              <button onclick="jtipembelianklikmodal(<?php echo $no ?>)" type="button" class="btn btn-info" name="button" style="font-weight:bold;" data-toggle="modal" data-target="#MyModalJTIPembelian"><i class="fa fa-send"></i></button>
            <?php }else{ ?>
              <button type="button" class="btn btn-info" disabled><i class="fa fa-send"></i></button>
            <?php } ?>
          </center>
        </td>
        <td>
          <button type="button" class="btn btn-danger" onclick="jtip_delete('<?php echo $g['document_id'] ?>', '<?php echo $g['driver_id'] ?>')" ><i class="fa fa-trash"></i></button>
        </td>

        <input type="hidden" id="JTInotifid" value="<?php echo $g['notifid'] ?>">
        <input type="hidden" id="JTIReport" value="<?php echo $g['report'] ?>">
        <input type="hidden" id="JTIResponse" value="<?php echo $g['response'] ?>">
      </tr>
    <?php $no++; endforeach; ?>
  </tbody>
</table>
