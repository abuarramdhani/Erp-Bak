<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left" <?= $no_urut != '0012' ? 'id="tblopp"' : '' ?> style="font-size:12px;">
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
      <?php $no = 1; foreach ($get as $key => $g): $tampung[] = ['id' => $g['id'], 'proses' => $g['proses'], 'seksi' => $g['seksi']]; ?>
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
<textarea hidden id="opp_tampung_id" rows="8" cols="80"><?php echo json_encode($tampung) ?></textarea>
<script type="text/javascript">
$('#tblopp').DataTable({
  "pageLength": 10,
});

$(document).ready(function () {
  let tampung_ini = JSON.parse($('#opp_tampung_id').text());
  let temp = {};
  let tampung_id_ini = [];
  tampung_ini.forEach((v, i) => {
    temp[v.id] = v;
    tampung_id_ini.push(v.id);
  })
  let opp_keranjang = $('#opp_keranjang').text();
  let arr_keranjang = opp_keranjang.split(',');
  let arr = [];
  arr_keranjang.forEach((v, i) => {
    arr.push(v.split('_'));
  })
  arr.pop();
  arr.forEach((v, i) => {
    if (tampung_id_ini.includes(v[0])) {
      // console.log(v);
      arr[i][2] = temp[v[0]].proses;
      arr[i][3] = temp[v[0]].seksi;
    }
  });
  arr.forEach((v, i) => {
    arr[i] = v.join('_');
  });
  let final = arr.join(',');

  if (final == '') {
    $('#opp_keranjang').text('');
  }else {
    $('#opp_keranjang').text(final+',');
  }
});
</script>
