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
      <th width="5%" style="text-align : center;">No</th>
      <th width="25%" style="text-align : center;">Lokasi</th>
      <th width="25%" style="text-align : center;">Tanggal</th>
      <th width="15%" style="text-align : center;">Shift 1 Umum Tanggung</th>
      <th width="15%" style="text-align : center;">Shift 2</th>
      <th width="15%" style="text-align : center;">Shift 3</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($JumlahPesanan as $key => $val) :
      ?>
      <tr>
        <td style="text-align : center;"><?= $key + 1 ?></td>
        <td><?= $val['lokasi'] ?></td>
        <td style="text-align : center;"><?= $val['fd_tanggal']; ?></td>
        <td style="text-align : center;"><?= $val['shift_satu_umum']; ?></td>
        <td style="text-align : center;"><?= $val['shift_dua']; ?></td>
        <td style="text-align : center;"><?= $val['shift_tiga']; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>

</table>