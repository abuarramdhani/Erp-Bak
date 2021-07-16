<style media="screen">
  .tbl-lph-2021 thead tr td{
    vertical-align:middle;
    padding: 7px;
  }
  .tbl-lph-2021 tbody tr td{
    vertical-align:middle;
    padding: 6px;
  }
  .btn-group{
    margin-bottom: -50px !important;
  }
  .pagination{
    margin-top: -50px !important;
  }
</style>
<div class="table-responsive">
  <table class="table table-bordered tbl_lph_2021" style="width:100%;text-align:center">
    <thead class="bg-primary">
      <tr>
        <td class="bg-primary" style="width:30px">No</td>
        <td class="bg-primary" >Alat Bantu</td>
        <td >Proses AB</td>
        <td >STD. Pakai</td>
        <td>Toleransi</td>
        <td>Pemakaian Ke</td>
        <td>Jumlah</td>
        <td>Kode Part</td>
        <td>Kode Proses</td>
        <td>Nama Part</td>
        <td>Tanggal</td>
      </tr>
    </thead>
    <tbody>
      <?php $total = 0; $no=1; foreach ($get as $key => $value): ?>
          <tr <?php echo $value['fs_proses'] == 'TGL.KIRIM :' ? 'style="background:#dddddd"' : '' ?>>
            <td><?php echo $no++ ?></td>
            <?php if ($key == 0 || $value['fs_no_ab'] != $get[$key - 1]['fs_no_ab'] ) { ?>
              <td><?php echo $value['fs_no_ab'] ?></td>
              <td><?php echo $value['fs_proses'] ?></td>
              <td><?php echo $value['fs_umur_pakai'] ?></td>
              <td><?php echo $value['fs_toleransi'] ?></td>
            <?php }else{ ?>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            <?php } ?>
            <td><?php echo $value['ke'] ?></td>
            <td><?php echo $value['aktual'] ?></td>
            <td><?php echo $value['kode_komponen'] ?></td>
            <td><?php echo $value['kode_proses'] ?></td>
            <td><?php echo $value['nama_komponen'] ?></td>
            <td><?php echo $value['tanggal'] ?></td>
          </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<br>
<div class="row">
  <div class="col-md-4">
  </div>
  <div class="col-md-8">
    <!-- <form class="" action="<?php // echo base_url('LaporanProduksiHarian/action/report_alat_bantu') ?>" method="post" target="_blank"> -->
      <!-- <input type="hidden" name="date" id="t21_range_date" value=""> -->
      <!-- <input type="hidden" name="alat_bantu" id="t21_alat_bantu" value=""> -->
      <!-- <button type="button" class="btn btn-success pull-right lph_export_hasil_kerja" name="button"><i class="fa fa-file-excel-o"></i>  Report Pemakaian Alat Bantu</button> -->
    <!-- </form> -->
    <!-- <button type="button" class="btn btn-success pull-right" name="button"> <i class="fa fa-file-excel-o"></i> Report Hasil Kerja</button> -->
  </div>
</div>
<br>
<script type="text/javascript">
$(function() {

})

let n78_ab = $('.lph_alat_bantu_97').val() == '' ? 'All' : $('.lph_alat_bantu_97').val();
let for_excel_title = `${$('.tanggal_lph_99').val()} - ${n78_ab}`;

const table_lph = $('.tbl_lph_2021').DataTable({
  scrollX: true,
  scrollY: 471,
  ordering: false,
  fixedColumns: {
    leftColumns: 2,
  },
  dom: 'Bfrtip',
  buttons: [
    'pageLength',
    {
      extend: 'excelHtml5',
      title: 'Pemakaian Alat bantu' + for_excel_title,
      exportOptions: {
        columns: ':visible',
        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
      }
    }
   ],
});

</script>
