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
        <td style="width:30px">No</td>
        <td style="width:30px"></td>
        <td style="width:200px">Operator</td>
        <td style="width:200px">Kode Part</td>
        <td style="width:270px">Nama Part</td>
        <td style="width:200px">Alat Bantu</td>
        <td style="width:130px">Kode Mesin</td>
        <td style="width:100px">Wkt. Mesin</td>
        <td style="width:200px">Kode Proses</td>
        <td style="width:200px">Nama Proses</td>
        <td style="width:100px">Target PPIC</td>
        <td style="width:100px">Target PE</td>
        <!-- <td style="width:100px">T.100%</td> -->
        <td style="width:100px">Aktual</td>
        <td style="width:100px">%TASE</td>
        <td style="width:100px">Hasil Baik</td>
        <td style="width:100px">Repair Man</td>
        <td style="width:100px">Repair Mat</td>
        <td style="width:100px">Repair Mach</td>
        <td style="width:100px">Scrap Man</td>
        <td style="width:100px">Scrap Mat</td>
        <td style="width:100px">Scrap Mach</td>
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
        </tr>
      <?php endforeach; ?>

    </tbody>
  </table>
</div>
<br>
<script type="text/javascript">
const table_lph = $('.tbl_lph_2021').DataTable({
  // ordering: false
})
</script>
