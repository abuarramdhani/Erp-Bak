<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " id="tblmsjdetail_mj" style="font-size:12px;">
    <thead>
      <tr class="bg-primary">
        <th style="width:7%"><center>NO</center></th>
        <th><center>NOMOR FPB</center></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $g): ?>
        <tr>
          <td><center><?php echo $no; ?></center></td>
          <td><center><?php echo $g['NO_FPB'] ?></center></td>
        </tr>
      <?php $no++; endforeach; ?>
    </tr>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $('#tblmsjdetail_mj').DataTable();
</script>
