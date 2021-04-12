<div class="row">
  <div class="col-md-1">
    <a href="<?php echo base_url('CateringManagement/Pesanan/PrediksiCatering/export_excel/' . $Export) ?>" class="btn btn-md btn-success" target="_blank"><i class="fa fa-file-excel-o"></i> Excel</a>
  </div>
  <div style="margin-left : 0px; padding-left : 0%;" class="col-md-1">
    <a href="<?php echo base_url('CateringManagement/Pesanan/PrediksiCatering/export_pdf/' . $Export) ?>" class="btn btn-md btn-danger" target="_blank"><i class="fa fa-file-pdf-o"></i> PDF</a>
  </div>
</div><br>

<table id="tbl_viewprediksicatering" class="table table-striped table-bordered table-hover">

  <thead class="bg-primary">
    <tr>
      <th width="5%" style="text-align : center;">No</th>
      <th width="30%">Tempat Makan</th>
      <th width="20%" style="text-align : center;">Tanggal</th>
      <th width="13%" style="text-align : center;">Jumlah Shift</th>
      <th width="7%" style="text-align : center;">Dirumahkan (NON WFH)</th>
      <th width="7%" style="text-align : center;">Dirumahkan (WFH)</th>
      <th width="7%" style="text-align : center;">Cuti</th>
      <th width="7%" style="text-align : center;">Sakit</th>
      <th width="7%" style="text-align : center;">Dinas Luar</th>
      <th width="7%" style="text-align : center;">Puasa</th>
      <th width="7%" style="text-align : center;">Total</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($PrediksiCatering as $key => $val) :
      ?>
      <tr>
        <td style="text-align : center;"><?= $key + 1 ?></td>
        <td><?= $val['tempat_makan'] ?></td>
        <td style="text-align : center;"><?= $val['tanggal']; ?></td>
        <td style="text-align : center;"><?= $val['jumlah_shift']; ?></td>
        <td style="text-align : center; <?php echo $val['dirumahkan_nonwfh'] != "0" ? "background-color: #ff8888" : ""; ?>"><?= $val['dirumahkan_nonwfh']; ?></td>
        <td style="text-align : center; <?php echo $val['wfh'] != "0" ? "background-color: #ff8888" : ""; ?>"><?= $val['wfh']; ?></td>
        <td style="text-align : center; <?php echo $val['cuti'] != "0" ? "background-color: #ff8888" : ""; ?>"><?= $val['cuti']; ?></td>
        <td style="text-align : center; <?php echo $val['sakit'] != "0" ? "background-color: #ff8888" : ""; ?>"><?= $val['sakit']; ?></td>
        <td style="text-align : center; <?php echo $val['dinas_luar'] != "0" ? "background-color: #ff8888" : ""; ?>"><?= $val['dinas_luar']; ?></td>
        <td style="text-align : center; <?php echo $val['puasa'] != "0" ? "background-color: #ff8888" : ""; ?>"><?= $val['puasa']; ?></td>
        <td style="text-align : center;"><?= $val['total']; ?></td>

      </tr>
    <?php endforeach; ?>
  </tbody>

  <tfoot>
    <tr>
      <td></td>
      <td></td>
      <td style="text-align : right;"><b>Jumlah :</b></td>
      <td style="text-align : center;"><b><?= array_sum(array_column($PrediksiCatering, 'jumlah_shift')); ?></b></td>
      <td style="text-align : center;"><b><?= array_sum(array_column($PrediksiCatering, 'dirumahkan_nonwfh')); ?></b></td>
      <td style="text-align : center;"><b><?= array_sum(array_column($PrediksiCatering, 'wfh')); ?></b></td>
      <td style="text-align : center;"><b><?= array_sum(array_column($PrediksiCatering, 'cuti')); ?></b></td>
      <td style="text-align : center;"><b><?= array_sum(array_column($PrediksiCatering, 'sakit')); ?></b></td>
      <td style="text-align : center;"><b><?= array_sum(array_column($PrediksiCatering, 'dinas_luar')); ?></b></td>
      <td style="text-align : center;"><b><?= array_sum(array_column($PrediksiCatering, 'puasa')); ?></b></td>
      <td style="text-align : center;"><b><?= array_sum(array_column($PrediksiCatering, 'total')); ?></b></td>
    </tr>
  </tfoot>
</table>