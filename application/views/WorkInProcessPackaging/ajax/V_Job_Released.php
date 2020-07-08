
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left tblwipp1" style="font-size:12px;">
    <thead>
      <tr class="bg-info">
        <th><center>NO</center></th>
        <th>KODE ITEM</th>
        <th>NAMA ITEM</th>
        <th>ONHAND INT-P&P</th>
        <th>MIN</th>
        <th>MAX</th>
        <th><center>ACTION </center></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1; foreach ($get_unique as $key => $g):
      if ($g['PRIORITY'] == 1) {
        $style = 'style="background:rgba(35, 224, 150, 0.35)"';
      }else {
        $style = '';
      }
      ?>
        <tr data-no="<?php echo $no ?>">
          <td <?php echo $style ?>><center><?php echo $no ?></center></td>
          <td <?php echo $style ?>><?php echo $g['KODE_ASSY'] ?></td>
          <td <?php echo $style ?>><?php echo $g['DESCRIPTION'] ?></td>
          <td <?php echo $style ?>><?php echo $g['QTY_ONHAND'] ?></td>
          <td <?php echo $style ?>><?php echo $g['MIN'] ?></td>
          <td <?php echo $style ?>><?php echo $g['MAX'] ?></td>
          <td <?php echo $style ?>><center>
            <button type="button" class="btn btn-md btn-primary cencelWipp" stat="1" onclick="detail_wipp_1(<?php echo $no ?>, '<?php echo $g['KODE_ASSY'] ?>')" name="button"><i class="fa fa-eye"></i> <b>Job Detail</b></button></center></td>
        </tr>
      <?php $no++; endforeach; ?>
    </tbody>
  </table>
  <br><br>
  <span style="font-weight:bold">*Green Color = Product Priority</span>
</div>
<script type="text/javascript">

let wipp1_1 = $('.tblwipp1').DataTable({
  paging : false,
  scrollY : "500px",
})

function format_wipp( d, kode_item ){
  return `<div class="JobReleaseArea${kode_item}"> </div>`;
}

function detail_wipp_1(no, kode_item) {
  let tr = $(`tr[data-no=${no}]`);
  let row = wipp1_1.row( tr );
  if ( row.child.isShown() ) {
      row.child.hide();
      tr.removeClass('shown');
  }
  else {
      row.child( format_wipp(row.data(), kode_item)).show();
      tr.addClass('shown');
      $.ajax({
        url: baseurl + 'WorkInProcessPackaging/JobManager/getitembykodeitem',
        type: 'POST',
        async: true,
        data: {
          kode_item: kode_item,
        },
        beforeSend: function() {
          $('.JobReleaseArea'+kode_item).html(`<div id="loadingArea0">
                                                <center><img style="width: 3%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                              </div>`)
        },
        success: function(result) {
          $('.JobReleaseArea'+kode_item).html(result)
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
  }
}

</script>
