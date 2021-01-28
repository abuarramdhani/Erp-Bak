<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left dt-fp-std-2" style="font-size:11px;">
    <thead class="bg-primary">
      <tr>
        <th style="text-align:center;width:5%">No</th>
        <th>Operation Code</th>
        <th>Operation Desc</th>
        <th style="text-align:center;width:10%">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($get as $key => $value): ?>
        <tr>
          <td style="text-align:center"><?php echo $key+1 ?></td>
          <td><?php echo $value['opr_code'] ?></td>
          <td><?php echo $value['opr_desc'] ?></td>
          <td><center> - </center></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $('.dt-fp-std-2').DataTable()
</script>
