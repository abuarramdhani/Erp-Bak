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
<table class="datatable table-bordered table-hover table-striped text-center tbl-lph-2021" style="width:1800px">
  <thead class="bg-primary">
    <tr>
      <td rowspan="2">No</td>
      <td rowspan="2">Urut Job</td>
      <td rowspan="2" style="width:140px">Nama Operator</td>
      <td rowspan="2">No Induk</td>
      <td rowspan="2" style="width:100px">Kode Mesin</td>
      <td rowspan="2">No Batch</td>
      <td rowspan="2"style="width:120px">Kode Komponen</td>
      <td rowspan="2" style="width:250px">Nama Komponen</td>
      <td rowspan="2">Plan</td>
      <td rowspan="2">FOQ</td>
      <td colspan="2" style="border-bottom:0px">Target</td>
      <td colspan="2" style="border-bottom:0px">% Pencapaian Target Operator</td>
      <td rowspan="2">Jml % Target OP S-K</td>
      <td rowspan="2">Jml % Target OP J-S</td>
      <td rowspan="2">PROSES</td>
      <td rowspan="2">Resource</td>
      <td rowspan="2">Hasil</td>
      <td rowspan="2">Repair</td>
      <td rowspan="2">Scrap</td>
      <td rowspan="2">Hari</td>
      <td rowspan="2" style="width:110px">Tanggal</td>
      <td rowspan="2">Shift</td>
    </tr>
    <tr>
      <td style="width:60px !important;">S-K</td>
      <td style="width:60px !important;">J-S</td>
      <td style="width:60px !important;">S-K</td>
      <td style="width:60px !important;border-right:1px solid white">J-S</td>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($get as $key => $value): ?>
      <tr>
        <td><?php echo $key+1 ?></td>
        <td><?php echo $value['urut_job'] ?></td>
        <td><?php echo $value['nama_operator'] ?></td>
        <td><?php echo $value['no_induk'] ?></td>
        <td><?php echo $value['kode_mesin'] ?></td>
        <td><?php echo $value['no_batch'] ?></td>
        <td><?php echo $value['kode_komponen'] ?></td>
        <td><?php echo $value['nama_komponen'] ?></td>
        <td><?php echo $value['plan'] ?></td>
        <td><?php echo $value['foq'] ?></td>
        <td><?php echo $value['target_sk'] ?></td>
        <td><?php echo $value['target_js'] ?></td>
        <td><?php echo $value['persen_target_sk'] ?></td>
        <td><?php echo $value['persen_target_js'] ?></td>
        <td><?php echo $value['persen_jml_target_sk'] ?></td>
        <td><?php echo $value['persen_jml_target_js'] ?></td>
        <td><?php echo $value['proses'] ?></td>
        <td><?php echo $value['resource'] ?></td>
        <td><?php echo $value['hasil'] ?></td>
        <td><?php echo $value['repair'] ?></td>
        <td><?php echo $value['scrap'] ?></td>
        <td><?php echo $value['hari'] ?></td>
        <td><?php echo $value['tanggal'] ?></td>
        <td><?php echo $value['shift'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<br>

<script type="text/javascript">
const tableckmb = $('.tbl-lph-2021').DataTable({
  ordering: false
})
</script>
