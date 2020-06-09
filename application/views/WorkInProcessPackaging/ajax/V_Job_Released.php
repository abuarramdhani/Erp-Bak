<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left tblwiip1" style="font-size:12px;">
    <thead>
      <tr class="bg-info">
        <th><center>NO</center></th>
        <th>NO JOB</th>
        <th>KODE ITEM</th>
        <th>NAMA ITEM</th>
        <th>QTY</th>
        <th>USAGE RATE</th>
        <th>ONHAND YSP</th>
        <th >SCHEDULED START DATE </th>
        <th><center>ACTION </center></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $key => $g): ?>
        <?php
          if ($g['PRIORITY'] == 1) {
            $style = 'style="background:rgba(42, 86, 152, 0.45)"';
          }else {
            $style = '';
          }
         ?>
        <tr row="<?php echo $no ?>" <?php echo $style ?>>
          <td><?php echo $no ?></td>
          <td ><?php echo $g['NO_JOB'] ?></td>
          <td><?php echo $g['KODE_ASSY'] ?></td>
          <td><?php echo $g['DESCRIPTION'] ?></td>
          <td><?php echo $g['START_QUANTITY'] ?></center></td>
          <td ><?php echo abs($g['USAGE_RATE_OR_AMOUNT']) ?></td>
          <td><?php echo $g['ONHAND_YSP'] ?></td>
          <td><?php echo $g['SCHEDULED_START_DATE'] ?></center></td>
          <td><center>
            <button type="button" class="btn btn-md btn-primary cencelWipp" stat="1" onclick="addRKH(<?php echo $no ?>, '<?php echo $g['NO_JOB'] ?>')" name="button"><i class="fa fa-plus-square"></i> <b>Add to RKH</b></button></center></td>
        </tr>
      <?php $no++; endforeach; ?>
    </tbody>
  </table>
  <br>
  <span style="font-weight:bold">*Dark Blue Color = Product Priority</span>
</div>
<script type="text/javascript">
let wipp1 = $('.tblwiip1').DataTable();

function addRKH(n, nj){
  let stat = $(`.tblwiip1 tr[row="${n}"] td center button`).attr(`stat`);
  if (stat==1) {
      $(`.tblwiip1 tr[row="${n}"] td center button`).attr(`stat`, `0`)
      $(`.tblwiip1 tr[row="${n}"] td center button`).removeClass(`btn-primary`)
      $(`.tblwiip1 tr[row="${n}"] td center button`).addClass(`btn-danger`)
      $(`.tblwiip1 tr[row="${n}"] td center button`).html(`<i class="fa fa-close"></i> <b>Cencel</b>`)
      $(`.tblwiip1 tr[row="${n}"]`).toggleClass('selected');
  }else {
      $(`.tblwiip1 tr[row="${n}"] td center button`).attr(`stat`, `1`)
      $(`.tblwiip1 tr[row="${n}"] td center button`).removeClass(`btn-danger`)
      $(`.tblwiip1 tr[row="${n}"] td center button`).addClass(`btn-primary`)
      $(`.tblwiip1 tr[row="${n}"] td center button`).html(`<i class="fa fa-plus-square"></i> <b>Add to RKH</b>`)
      $(`.tblwiip1 tr[row="${n}"]`).removeClass('selected');
  }

  let get = wipp1.rows('.selected').data();
  var bool=$(".btnWIPP").is(":hidden")
  if (Number(get.length) == 0) {
      setTimeout(function () {
        $('.btnWIPP').attr('hidden',!bool);
    }, 300);
  }else {
    setTimeout(function () {
      $('.btnWIPP').removeAttr("hidden");
    }, 300);
  }
}

function getJobReleased() {
  let get = wipp1.rows('.selected').data();
  let getDataWIPP = [];
  for (var i = 0; i < get.length; i++) {
    getDataWIPP.push(get[i])
  }
  let listJobWipp = [];

    getDataWIPP.forEach((v, i) =>{
      let a2134a = `<tr row="${i+1}">
                      <td><center>${i+1}</center></td>
                      <td><center>${v[1]}</center></td>
                      <td><center>${v[2]}</center></td>
                      <td><center>${v[3]}</center></td>
                      <td><center>${v[4]}</center></td>
                      <td><center>${v[5]}</center></td>
                      <td><center>${v[7]}</center></td>
                      <td><center><button type="button" class="btn btn-md btn-primary" name="button" onclick="minusNewRKH(${i+1})"><i class="fa fa-minus-square"></i></button></center></td>
                    </tr>
                  `;
      listJobWipp.push(a2134a);
    })
  $('#create-new-rkh').html(listJobWipp.join(" "));
}

</script>
