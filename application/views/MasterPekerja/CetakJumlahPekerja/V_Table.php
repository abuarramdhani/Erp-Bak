<a href="<?php echo base_url('MasterPekerja/Jumlahpekerja/excel_pendidikan/' . $export) ?>" class="btn btn-lg btn-success" target="blank_"><i class="fa fa-file-excel-o"></i> Export Excel</a> <br> <br>

<table id="CJP_Tabledata" class="table table-striped table-bordered table-hover">

  <thead class="bg-primary">
    <tr>
      <th colspan="4"></th>
      <th colspan="4" style="text-align: center; ">NON STAFF</th>
      <th colspan="5" style="text-align: center;">STAFF</th>
    </tr>
    <tr>
      <th width="3%">No</th>
      <th>Dept</th>
      <th>Unit</th>
      <th>Seksi</th>

      <th>Tetap (A)</th>
      <th>Train (E)</th>
      <th>PKL (F)</th>
      <th>Kont (H,T)</th>

      <th>Tetap (B)</th>
      <th>Train (D)</th>
      <th>TKPW (G)</th>
      <th>Magang (Q)</th>
      <th>Kont (J)</th>

      <th>OS <br> (K,P)</th>
      <th>Jml</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($JumlahAll as $key => $val) :
      ?>
      <tr>
        <td><?= $key + 1 ?></td>
        <td><?= $val['d']; ?></td>
        <td><?= $val['u']; ?></td>
        <td><?= $val['s']; ?></td>

        <td><?= $val['tetap']; ?></td>
        <td><?= $val['train']; ?></td>
        <td><?= $val['pkl']; ?></td>
        <td><?= $val['kontrak']; ?></td>

        <td><?= $val['stetap']; ?></td>
        <td><?= $val['strain']; ?></td>
        <td><?= $val['stkpw']; ?></td>
        <td><?= $val['skp']; ?></td>
        <td><?= $val['skontrak']; ?></td>

        <td><?= $val['os']; ?></td>

        <td><?= $val['tetap'] +  $val['train']
                + $val['pkl']
                + $val['kontrak']
                + $val['stetap']
                + $val['strain']
                + $val['stkpw']
                + $val['skp']
                + $val['skontrak']
                + $val['os']; ?></td>

      </tr>
    <?php endforeach; ?>
  </tbody>

  <tfoot>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td class="text-center"><b>TOTAL :</b></td>

      <td><b><?= array_sum(array_column($JumlahAll, 'tetap')); ?></b></td>
      <td><b><?= array_sum(array_column($JumlahAll, 'train')); ?></b></td>
      <td><b><?= array_sum(array_column($JumlahAll, 'pkl')); ?></b></td>
      <td><b><?= array_sum(array_column($JumlahAll, 'kontrak')); ?></b></td>

      <td><b><?= array_sum(array_column($JumlahAll, 'stetap')); ?></b></td>
      <td><b><?= array_sum(array_column($JumlahAll, 'strain')); ?></b></td>
      <td><b><?= array_sum(array_column($JumlahAll, 'pkl')); ?></b></td>
      <td><b><?= array_sum(array_column($JumlahAll, 'skp')); ?></b></td>
      <td><b><?= array_sum(array_column($JumlahAll, 'skontrak')); ?></b></td>

      <td><b><?= array_sum(array_column($JumlahAll, 'os')); ?></b></td>

      <td><b><?= array_sum(array_column($JumlahAll, 'jml')); ?></b></td>
    </tr>
  </tfoot>

</table>