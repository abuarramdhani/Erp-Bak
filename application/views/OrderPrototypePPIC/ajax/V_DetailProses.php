<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " id="tblopp" style="font-size:12px;">
    <thead>
      <tr class="bg-success">
        <th style="width:15%"><center>Urutan Proses</center></th>
        <th><center>Proses</center></th>
        <th><center>Seksi</center></th>
        <th ><center>Order</center></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $key => $g): ?>
        <tr>
          <td><center><?php echo $key+1; ?></center></td>
          <td><center><?php echo $g['proses'] ?></center></td>
          <td><center><?php echo $g['seksi'] ?></center></td>
          <td>
            <center>
              <input type="hidden" class="opp_cek_item_exiting" value="<?php echo $g['id'] ?>_<?php echo $g['id_order'] ?>_<?php echo $g['proses'] ?>_<?php echo $g['seksi'] ?>">
              <button check="plus" type="button" id="opp_idproses_<?php echo $g['id'] ?>" onclick="addtokeranjang('<?php echo $g['id_order'] ?>', '<?php echo $g['proses'] ?>', '<?php echo $g['seksi'] ?>', <?php echo $g['id'] ?>)" class="btn btn-success" style="margin-left:1px;padding:5px 7px;font-weight:bold;" name="button">
                <i class="fa fa-sign-in"></i> Add Order
              </button>
            </center>
          </td>
        </tr>
      <?php $no++; endforeach; ?>
    </tr>
    </tbody>
  </table>
</div>

<script type="text/javascript">
$('#tblopp').DataTable({
  "pageLength": 10,
});
</script>
