<div class="row">
  <div class="col-md-1">
    <a href="<?php echo base_url('CateringManagement/Extra/ExportJumlahPesanan/export_excel/' . $Export) ?>" class="btn btn-md btn-success" target="_blank"><i class="fa fa-file-excel-o"></i> Excel</a>
  </div>
  <div style="margin-left : 0px; padding-left : 0%;" class="col-md-1">
    <a href="<?php echo base_url('CateringManagement/Extra/ExportJumlahPesanan/export_pdf/' . $Export) ?>" class="btn btn-md btn-danger" target="_blank"><i class="fa fa-file-pdf-o"></i> PDF</a>
  </div>
</div><br>

<table id="tbl_viewjumlahpesanan" class="table table-striped table-bordered table-hover">

  <thead class="bg-primary">
    <tr>
      <th width="3%" style="text-align : center;">No</th>
      <th style="text-align : center;">Lokasi</th>
      <th style="text-align : center;">Tanggal</th>
      <th style="text-align : center;">Shift</th>
      <th style="text-align : center;">Jumlah</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($JumlahPesanan as $key => $val) :
      ?>
      <tr>
        <td style="text-align : center;"><?= $key + 1 ?></td>
        <td><?= $val['lokasi'] ?></td>
        <td style="text-align : center;"><?= $val['fd_tanggal']; ?></td>
        <td><?= $val['shift']; ?></td>
        <td style="text-align : center;"><?= $val['jumlah']; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>

</table>