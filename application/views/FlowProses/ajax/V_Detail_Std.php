<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left dt-fp-std-2" style="font-size:11px;">
    <thead class="bg-primary">
      <tr>
        <th style="text-align:center">No</th>
        <th>Operation Std</th>
        <th>Operation Std Desc</th>
        <th>Operation Group</th>
        <th style="text-align:center">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($get as $key => $value): ?>
        <tr>
          <td style="text-align:center"><?php echo $key+1 ?></td>
          <td><?php echo $value['operation_std'] ?></td>
          <td><?php echo $value['operation_desc'] ?></td>
          <td><?php echo $value['operation_std_group'] ?></td>
          <td>
            <center>
              <a class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure?');" style="border-radius:7px;" href="<?php echo base_url('FlowProses/OperationProcessStandard/delops/'.$value['id']) ?>"> <i class="fa fa-trash"></i></a>
              <button type="button" data-toggle="modal" data-target="#modalfp1" class="btn btn-sm btn-success" style="border-radius:7px;" onclick="fp_update_opration_std('<?php echo $value['id'] ?>', '<?php echo $value['operation_std'] ?>', '<?php echo $value['operation_desc'] ?>', '<?php echo $value['operation_std_group'] ?>')" name="button">
               <i class="fa fa-pencil"></i>
               </button>
            </center>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $('.dt-fp-std-2').DataTable()
</script>
