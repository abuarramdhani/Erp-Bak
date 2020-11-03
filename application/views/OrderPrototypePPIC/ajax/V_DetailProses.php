<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " <?= $no_urut != '0012' ? 'id="tblopp"' : '' ?> style="font-size:12px;">
    <thead>
      <tr class="bg-success">
        <th style="width:15%"><center>Urutan Proses</center></th>
        <th><center>Proses</center></th>
        <th><center>Seksi</center></th>
        <?php if ($no_urut != '0012') {?>
          <th ><center>Order</center></th>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $key => $g): ?>
        <tr row-nya="<?php echo $no ?>">
          <td><center><?php echo $no; ?></center></td>
          <td><center><?php echo $g['proses'] ?></center></td>
          <td><center><?php echo $g['seksi'] ?></center></td>
          <?php if ($no_urut != '0012') {?>
            <td>
              <center>
                <input type="hidden" class="opp_cek_item_exiting" value="<?php echo $g['id'] ?>_<?php echo $g['id_order'] ?>_<?php echo $g['proses'] ?>_<?php echo $g['seksi'] ?>">
                <button check="plus" type="button" id="opp_idproses_<?php echo $g['id'] ?>" onclick="addtokeranjang('<?php echo $g['id_order'] ?>', '<?php echo $g['proses'] ?>', '<?php echo $g['seksi'] ?>', <?php echo $g['id'] ?>, <?php echo $no_urut ?>)" class="btn btn-success" style="margin-left:1px;padding:5px 7px;font-weight:bold;" name="button">
                  <i class="fa fa-sign-in"></i> Add Order
                </button>
              </center>
            </td>
          <?php } ?>
        </tr>
      <?php $no++; endforeach; ?>

    </tbody>
  </table>
</div>

<script type="text/javascript">
$('#tblopp').DataTable({
  "pageLength": 10,
});
</script>
