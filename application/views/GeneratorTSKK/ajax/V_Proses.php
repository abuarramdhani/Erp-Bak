<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left dt-gentskk" style="font-size:11px;">
    <thead class="bg-primary">
      <tr>
        <th style="text-align:center;width:5%">No</th>
        <th>Nama Proses</th>
        <th style="width:20%">Kode Proses</th>
        <th style="text-align:center;width:10%">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($get as $key => $value): ?>
        <tr>
          <td style="text-align:center"><?php echo $key+1 ?></td>
          <td><?php echo $value['PROSES'] ?></td>
          <td><?php echo $value['KODE_PROSES'] ?></td>
          <td>
            <center>
              <button type="button" class="btn btn-danger btn-sm" style="border-radius:7px;" onclick="delprosesgtskk(<?php echo $value['ID_PROSES'] ?>)" name="button"><i class="fa fa-trash"></i></button>
              <button type="button" data-toggle="modal" data-target="#modalgtskk_u1" class="btn btn-sm btn-success" style="border-radius:7px;" onclick="ambildataprosesby('<?php echo $value['ID_PROSES'] ?>', '<?php echo $value['PROSES'] ?>', '<?php echo $value['KODE_PROSES'] ?>')" name="button">
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
  $('.dt-gentskk').DataTable();
</script>
