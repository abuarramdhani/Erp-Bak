<div class="form-group" id="gantiHariRekap">
<center>
  <div class="col-lg-12 form-group bg-info" style=" font-weight:bold; margin-bottom: 15px;">
    <!-- <label style="font-size:16px; text-align:center;">Rekap Data Perizinan Dinas <?php if (!empty($tanggal)) {
      echo 'Tanggal '.$tanggal;
    }else {
      echo '';
    } ?> Sebelum Jam 09:00:00 WIB</label><br><br> -->
    <?php if(isset($tanggal)){echo "====================== Rekap Data Perizinan Dinas Tanggal : ".$tanggal." Sebelum Jam 09:00:00 WIB ======================";}else {
      echo "======================== Rekap Data Perizinan Dinas Sebelum Jam 09:00:00 WIB ========================";
    } ?><br>

  </div>
</center>
<table class="datatable approveCatering table table-striped table-bordered table-hover text-left" style="font-size:12px; width: 100%">
  <thead class="bg-primary">
    <tr>
      <th style="width: 30px;">No</th>
      <th>Tempat Makan</th>
      <th>Tambahan</th>
    </tr>
  </thead>
  <tbody>
    <?php
      if (empty($rekapan)) {
        # code...
      }else{
        $no=1;
        foreach ($rekapan as $key) { ?>
          <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $key['0']; ?></td>
            <td><?php echo count($key); ?></td>
          </tr>
          <?php
          $no++;
        } } ?>
  </tbody>
</table>
</div>
