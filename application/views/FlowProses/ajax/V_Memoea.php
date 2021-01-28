<div class="table-responsive" style="margin-top:20px;">
  <table class="table table-striped table-bordered table-hover text-left datatable-memo-fp-00121" style="font-size:11px;">
    <thead class="bg-primary">
      <tr>
        <th style="text-align:center; width:5%">
            No
        </th>
        <th>
            Memo Number
        </th>
        <th>Product Name</th>
        <th style="text-align:center">Status</th>
        <th style="text-align:center;width:20%">
           Detail Component
        </th>
    </tr>
    </thead>
    <tbody>
      <?php $no=1; foreach ($get as $key => $v){ ?>
        <tr>
          <td style="text-align:center"><?php echo $no ?> </td>
          <td><?php echo $v['memo_number'] ?> </td>
          <td><?php echo $v['product_name'] ?></td>
          <td style="vertical-align:middle" id="fp_status_<?php echo $v['memo_id']  ?>"><center>
            <?php
              if ($v['status'] == 0) {
                echo '<span class="btn-warning" name="button" style="padding:4px;border-radius:5px;width:70%;font-weight:bold">Unsetting</span>';
              }else {
                echo '<span class="btn-success" name="button" style="padding:4px;border-radius:5px;width:70%;font-weight:bold">Approved!</span>';
              }
            ?>
          </center>
          </td>
          <td> <center> <button type="button" class="btn btn-primary" style="" data-toggle="modal" data-target="#modalfpmemocomponent" onclick="cek_memo_component('<?php echo $v['memo_number'] ?>', <?php echo $v['memo_id'] ?>, '<?php echo $type ?>')" name="button"> <i class="fa fa-cube"></i> Detail</button> </center> </td>
        </tr>
      <?php $no++; } ?>
    </tbody>
  </table>
</div>

<script type="text/javascript">
  let table_fp_1210210 = $('.datatable-memo-fp-00121').DataTable()
  $('#product_fp_memo').change(function() {
  table_fp_1210210.search($(this).val()).draw();
  })
</script>
