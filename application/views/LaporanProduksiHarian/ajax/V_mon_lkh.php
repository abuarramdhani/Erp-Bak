<style media="screen">
  .tbl-lph-2021 thead tr td{
    vertical-align:middle;
    padding: 7px;
  }
  .tbl-lph-2021 tbody tr td{
    vertical-align:middle;
    padding: 6px;
  }
</style>
<div class="table-responsive">
  <table class="table table-bordered tbl_lph_2021" style="width:2630px;text-align:center">
    <thead class="bg-primary">
      <tr>
        <td class="bg-primary" style="width:30px">No</td>
        <td class="bg-primary" style="width:30px"></td>
        <td class="bg-primary" style="width:130px">Operator</td>
        <td style="width:100px">Kode Part</td>
        <td style="width:270px">Nama Part</td>
        <td style="width:200px">Alat Bantu</td>
        <td style="width:130px">Kode Mesin</td>
        <td style="width:100px">Wkt. Mesin</td>
        <td style="width:100px">Kode Proses</td>
        <td style="width:100px">Nama Proses</td>
        <td style="width:100px">Target PPIC</td>
        <td style="width:100px">Hari</td>
        <td style="width:100px">Tanggal</td>
        <td style="width:100px">Target PE</td>
        <td style="width:100px">Aktual</td>
        <td style="width:100px">%TASE</td>
        <td style="width:100px">Hasil Baik</td>
        <td style="width:100px">Repair Man</td>
        <td style="width:100px">Repair Mat</td>
        <td style="width:100px">Repair Mach</td>
        <td style="width:100px">Scrap Man</td>
        <td style="width:100px">Scrap Mat</td>
        <td style="width:100px">Scrap Mach</td>
        <td style="display:none"></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($get as $key => $value): ?>
        <tr>
          <td><?php echo $key+1 ?></td>
          <td></td>
          <td>
            <?php echo $value['operator'] ?>
          </td>
          <td>
            <?php echo $value['kode_komponen'] ?>
          </td>
          <td><?php echo $value['nama_komponen'] ?></td>
          <td>
            <?php echo $value['alat_bantu'] ?>
          </td>
          <td><?php echo str_replace(' ','',$value['kode_mesin']) ?></td>
          <td><?php echo $value['waktu_mesin'] ?></td>
          <td>
            <?php echo $value['kode_proses'] ?>
          </td>
          <td><?php echo $value['nama_proses'] ?></td>
          <td><?php echo $value['plan'] ?></td>
          <td><?php echo $value['hari'] ?></td>
          <td><?php echo $value['tanggal'] ?></td>
          <?php
            if ($value['hari'] == ('Jumat' || 'Sabtu')) {
              $target_harian = $value['target_js'];
            }else {
              $target_harian = $value['target_sk'];
            }
          ?>
          <td>
            <?php echo $target_harian ?>
          </td>
          <td><?php echo $value['aktual'] ?></td>
          <td><?php echo $value['persentase_aktual'] ?></td>
          <td><?php echo $value['hasil_baik'] ?></td>
          <td><?php echo $value['repair_man'] ?></td>
          <td><?php echo $value['repair_mat'] ?></td>
          <td><?php echo $value['repair_mach'] ?></td>
          <td><?php echo $value['scrap_man'] ?></td>
          <td><?php echo $value['scrap_mat'] ?></td>
          <td><?php echo $value['scrap_mach'] ?></td>
          <td hidden><?php echo $value['id'] ?></td>
        </tr>
      <?php endforeach; ?>

    </tbody>
  </table>
</div>
<br>
<div class="row">
  <div class="col-md-4">
    <button type="button" class="btn btn-danger" onclick="deleteselectedrowmonlkh()" name="button"> <i class="fa fa-trash"></i> Delete Selected Row</button>
  </div>
  <div class="col-md-8">
    <form class="" action="<?php echo base_url('LaporanProduksiHarian/action/report_lkh') ?>" method="post" target="_blank">
      <input type="hidden" name="date" id="t22_date" value="">
      <input type="hidden" name="shift" id="t22_shift" value="">
      <button type="submit" class="btn btn-success pull-right lph_export_hasil_kerja" name="button"><i class="fa fa-file-excel-o"></i>  Report Hasil Kerja</button>
    </form>
    <!-- <button type="button" class="btn btn-success pull-right" name="button"> <i class="fa fa-file-excel-o"></i> Report Hasil Kerja</button> -->
  </div>
</div>
<br>
<script type="text/javascript">
$(function() {
    let val_x = $('.123_lph_mon_tgl').val().split(' - ');
    if (val_x[0] != val_x[1]) {
      $('.lph_export_hasil_kerja').attr('disabled', true);
    }else {
      $('.lph_export_hasil_kerja').attr('disabled', false);
      $('#t22_date').val(val_x[0]);
      $('#t22_shift').val($('.lph_pilih_shift_97').val());
    }
})
const table_lph = $('.tbl_lph_2021').DataTable({
  scrollX: true,
  scrollY: 471,
  fixedColumns: {
    leftColumns: 3,
  },
  columnDefs: [
    {orderable: false, targets: [1, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]},
    {
      orderable: false,
      className: 'select-checkbox',
      targets: 1
    }
  ],
  select: {
      style: 'multi',
      selector: 'td:nth-child(2)'
  },
});

function deleteselectedrowmonlkh() {
  let row = table_lph.rows( { selected: true } ).data();
  let count = table_lph.rows( { selected: true } ).count();
  let id_lph_master = [];
  row.each((v,i)=>{
    id_lph_master.push(v[23]); // perhatikan jika menambah kolom
  });
  if (count > 0) {
    $.ajax({
      url: baseurl + 'LaporanProduksiHarian/action/delete_lkh',
      type: 'POST',
      data : {
        id : id_lph_master
      },
      cache: false,
      // async:false,
      dataType: "JSON",
      beforeSend: function() {
        swaLPHLoading('Sedang menghapus data...');
      },
      success: function(result) {
        if (result == 1) {
          swaLPHLarge('success', 'Berhasil menghapus data');
          $('.lph_search').trigger('submit');
        }else {
          swaLPHLarge('warning', 'Tidak berhasil menghapus data');
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        swaLPHLarge('error', 'Terjadi kesalahan');
       console.error();
      }
    })
  }else {
    swaLPHLarge('warning', 'Tidak ada baris yang terpilih!');
  }
}

</script>
