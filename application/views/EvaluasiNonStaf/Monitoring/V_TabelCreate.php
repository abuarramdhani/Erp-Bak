<div class="col-lg-12">
  <table class="table table-bordered dataTable text-center">
    <thead class="bg-primary">
      <tr>
        <td width="5%">NO</td>
        <td width="10%">NO. INDUK</td>
        <td>NAMA</td>
        <td>SEKSI</td>
        <td>GOL</td>
        <td>STATUS</td>
        <td>TGL. MASUK</td>
        <td>ACTION</td>
      </tr>
    </thead>
    <tbody id="bodyPekerjaCreate">
      <?php $no=1;
      if (empty($create)) { ?>
        <tr>
          <td colspan="8">Mohon Maaf Data Tidak Ditemukan :(</td>
        </tr>
      <?php }else{
      foreach ($create as $key){ ?>
        <tr>
          <td><?php echo $no; ?></td>
          <td class="noindPekerjaCreate"><?php echo $key['noind'] ?></td>
          <td><?php echo $key['nama'] ?></td>
          <td><?php echo $key['tempat'] ?></td>
          <td><?php echo $key['gol'] ?></td>
          <td>-</td>
          <td><?php echo $key['tgl_masuk'] ?></td>
          <td><button class="fa fa-close minPekerejaCreate btn btn-danger"></button></td>
        </tr>
      <?php $no++;}} ?>
    </tbody>
  </table>
</div>
