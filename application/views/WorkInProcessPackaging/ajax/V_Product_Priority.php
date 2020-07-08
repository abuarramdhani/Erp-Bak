<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left tblwiip2" style="font-size:12px;">
    <thead>
      <tr class="bg-info">
        <th style="width:5%"><center>No</center></th>
        <th style="width:30%"><center>KODE ITEM</center></th>
        <th style="width:55%"><center>NAMA ITEM</center></th>
        <th><center>ACTION </center></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($pp as $key => $p): ?>
        <tr>
          <td><?php echo $key+1 ?></td>
          <td><?php echo $p['kode_item'] ?></td>
          <td><?php echo $p['nama_item'] ?></td>
          <td>
            <center>
            <button type="button" class="btn btn-md bg-maroon" name="button" onclick="product_priority_delete(<?php echo $p['id'] ?>)"><i class="fa fa-trash"></i> <b>Delete</b></button>
          </center>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $('.tblwiip2').DataTable();
</script>
