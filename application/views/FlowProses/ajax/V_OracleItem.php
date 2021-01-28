<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left datatable-ItemOracle-fp" style="font-size:11px;">
    <thead class="bg-primary">
      <tr>
        <th style="width:5%;text-align:center">No</th>
        <th style="width:20%">Component Code</th>
        <th>Description</th>
        <th style="width:15%; text-align:center">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($get as $key => $value): ?>
        <tr>
          <td style="text-align:center"><?php echo $key+1 ?></td>
          <td style="text-align:left"><?php echo $value['code_component'] ?></td>
          <td style="text-align:left"><?php echo $value['description'] ?></td>
          <td>
            <center><button type="button" class="btn btn-danger fp_del_item_oracle" onclick="del_item_oracle('<?php echo $value['id'] ?>')" style="border-radius:7px;" name="button"> <i class="fa fa-trash"></i> <b>Delete</b> </button> </center>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $('.datatable-ItemOracle-fp').DataTable()
</script>
