<a href="<?php echo base_url('MasterPekerja/Jumlahpekerja/export_excel/' . $export) ?>" target="_blank" class="btn btn-success btn-lg"><i class="fa fa-file-excel-o"></i> Export Excel &nbsp;</a> <br><br>

<table id="CJP_Tabledatap" class="table table-striped table-bordered table-hover">
  <thead class="bg-primary">

    <tr>
      <th colspan="2"></th>
      <th colspan="2" style="text-align: center;">STAFF (B)</th>
      <th colspan="2" style="text-align: center;"> NON STAFF (A)</th>
      <th colspan="2" style="text-align: center;">KONTRAK (H,J,T)</th>
      <th colspan="2" style="text-align: center;">TRAINEE (D,E)</th>
      <th colspan="2" style="text-align: center;">OUTSORC (K,P)</th>
      <th colspan="2" style="text-align: center;">PKL(F)</th>
      <th colspan="2" style="text-align: center;">MAGANG(Q)</th>
      <th colspan="2" style="text-align: center;">TKPW (G)</th>
      <th colspan="2" style="text-align: center;">JUMLAH</th>


    </tr>
    <tr>
      <th width="3%">No</th>
      <th width="7%">Pendidikan</th>

      <th width="5%">L</th>
      <th width="5%">P</th>

      <th width="5%">L</th>
      <th width="5%">P</th>

      <th width="5%">L</th>
      <th width="5%">P</th>

      <th width="5%">L</th>
      <th width="5%">P</th>

      <th width="5%">L</th>
      <th width="5%">P</th>

      <th width="5%">L</th>
      <th width="5%">P</th>

      <th width="5%">L</th>
      <th width="5%">P</th>

      <th width="5%">L</th>
      <th width="5%">P</th>

      <th width="5%">L</th>
      <th width="5%">P</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($JumlahAllPend as $key => $val) :
      ?>
      <tr>
        <td><?= $key + 1 ?></td>
        <td><?= $val['pd']; ?></td>

        <td><?= $val['staffl']; ?></td>
        <td><?= $val['staffp']; ?></td>

        <td><?= $val['nonstaffl']; ?></td>
        <td><?= $val['nonstaffp']; ?></td>

        <td><?= $val['kontrakl']; ?></td>
        <td><?= $val['kontrakp']; ?></td>

        <td><?= $val['trainl']; ?></td>
        <td><?= $val['trainp']; ?></td>

        <td><?= $val['outsorcl']; ?></td>
        <td><?= $val['outsorcp']; ?></td>

        <td><?= $val['pkll']; ?></td>
        <td><?= $val['pklp']; ?></td>

        <td><?= $val['magangl']; ?></td>
        <td><?= $val['magangp']; ?></td>

        <td><?= $val['tkpwl']; ?></td>
        <td><?= $val['tkpwp']; ?></td>

        <td><?= $val['jmll']; ?></td>
        <td><?= $val['jmlp']; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>

  <tfoot>
    <tr>
      <td></td>
      <td class="text-center"><b>TOTAL :</b></td>

      <td><b><?= array_sum(array_column($JumlahAllPend, 'staffl')); ?></b></td>
      <td><b><?= array_sum(array_column($JumlahAllPend, 'staffp')); ?></b></td>

      <td><b><?= array_sum(array_column($JumlahAllPend, 'nonstaffl')); ?></b></td>
      <td><b><?= array_sum(array_column($JumlahAllPend, 'nonstaffp')); ?></b></td>

      <td><b><?= array_sum(array_column($JumlahAllPend, 'kontrakl')); ?></b></td>
      <td><b><?= array_sum(array_column($JumlahAllPend, 'kontrakp')); ?></b></td>

      <td><b><?= array_sum(array_column($JumlahAllPend, 'trainl')); ?></b></td>
      <td><b><?= array_sum(array_column($JumlahAllPend, 'trainp')); ?></b></td>

      <td><b><?= array_sum(array_column($JumlahAllPend, 'outsorcl')); ?></b></td>
      <td><b><?= array_sum(array_column($JumlahAllPend, 'outsorcp')); ?></b></td>

      <td><b><?= array_sum(array_column($JumlahAllPend, 'pkll')); ?></b></td>
      <td><b><?= array_sum(array_column($JumlahAllPend, 'pklp')); ?></b></td>

      <td><b><?= array_sum(array_column($JumlahAllPend, 'magangl')); ?></b></td>
      <td><b><?= array_sum(array_column($JumlahAllPend, 'magangp')); ?></b></td>

      <td><b><?= array_sum(array_column($JumlahAllPend, 'tkpwl')); ?></b></td>
      <td><b><?= array_sum(array_column($JumlahAllPend, 'tkpwp')); ?></b></td>

      <td><b><?= array_sum(array_column($JumlahAllPend, 'jmll')); ?></b></td>
      <td><b><?= array_sum(array_column($JumlahAllPend, 'jmlp')); ?></b></td>
    </tr>
  </tfoot>

</table>