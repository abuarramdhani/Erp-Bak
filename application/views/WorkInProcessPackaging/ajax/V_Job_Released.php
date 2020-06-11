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
            $style = 'style="background:rgba(35, 224, 150, 0.35)"';
          }else {
            $style = '';
          }
         ?>
        <tr row="<?php echo $no ?>">
          <td <?php echo $style ?>><?php echo $no ?></td>
          <td <?php echo $style ?>><?php echo $g['NO_JOB'] ?></td>
          <td <?php echo $style ?>><?php echo $g['KODE_ASSY'] ?></td>
          <td <?php echo $style ?>><?php echo $g['DESCRIPTION'] ?></td>
          <td <?php echo $style ?>><?php echo $g['START_QUANTITY'] ?></center></td>
          <td <?php echo $style ?>><?php echo abs($g['USAGE_RATE_OR_AMOUNT']) ?></td>
          <td <?php echo $style ?>><?php echo $g['ONHAND_YSP'] ?></td>
          <td <?php echo $style ?>><?php echo $g['SCHEDULED_START_DATE'] ?></center></td>
          <td <?php echo $style ?>><center>
            <button type="button" class="btn btn-md btn-primary cencelWipp" stat="1" onclick="addRKH(<?php echo $no ?>, '<?php echo $g['NO_JOB'] ?>')" name="button"><i class="fa fa-plus-square"></i> <b>Add to RKH</b></button></center></td>
        </tr>
      <?php $no++; endforeach; ?>
    </tbody>
  </table>
  <br>
  <span style="font-weight:bold">*Green Color = Product Priority</span>
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
      let a2134a = `<tr hesoyam="ya" row="${i+1}">
                      <td><center>${i+1}</center></td>
                      <td><center>${v[1]}</center></td>
                      <td><center>${v[2]}</center></td>
                      <td><center>${v[3]}</center></td>
                      <td><center>${v[4]}</center></td>
                      <td><center>${v[5]}</center></td>
                      <td><center>${v[7]}</center></td>
                      <td onmouseover="cekhover()">
                        <center>
                          <button type="button" class="btn btn-md btn-primary" name="button" onclick="minusNewRKH(${i+1})"><i class="fa fa-minus-square"></i></button>
                          <button type="button" class="btn btn-md bg-navy" data-toggle="collapse" data-target="#Mycollapse${i}" aria-expanded="false" aria-controls="collapseExample" name="button"><i class="fa fa-cut"></i></button>
                        </center>
                      </td>
                    </tr>
                    <tr collapse-row="${i+1}">
                      <td colspan="8" style="margin:0;padding:0;width:0">
                      <div class="collapse" id="Mycollapse${i}">
                        <div class="card card-body" style="padding-top: 10px; padding-bottom: 20px;border-color:transparent">

                        <div class="row">
                          <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                              <div class="box-header with-border">
                                <div style="float:left">
                                  <h4 style="font-weight:bold;">SPLIT JOB (<span>${v[1]}</span>)</h4>
                                </div>
                              </div>
                              <div class="box-body">
                                <center>
                                  <div id="loading-pbi" style="display:none;">
                                    <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                  </div>
                                </center>
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
                                      <center>
                                        <h4 style="font-weight:bold;display:inline-block;">QTY Avaliable :</h4> <input type="number" value="0" id="qtySplit${i+1}" style="display:inline-block;width:10%;margin-left:10px;" class="form-control" placeholder="QTY">
                                      </center>
                                      <input type="hidden" id="qty_split_save${i+1}" value="${v[4]}" readonly>
                                      <input type="hidden" id="usage_rate_split${i+1}" value="${v[5]}" readonly>
                                      <input type="hidden" id="ssd${i+1}" value="${v[7]}" readonly>
                                      <input type="hidden" id="item_name${i+1}" value="${v[3]}" readonly>
                                      <input type="hidden" id="created_at" value="" readonly>
                                      <br>
                                      <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover text-left line0wipp${i+1}" style="font-size:11px;">
                                          <thead>
                                            <tr class="bg-info">
                                              <th style="width:26%">
                                                <center>JOB</center>
                                              </th>
                                              <th style="width:35%">
                                                <center>ITEM</center>
                                              </th>
                                              <th style="width:17%">
                                                <center>QTY</center>
                                              </th>
                                              <th style="width:17%">
                                                <center>TARGET PE (%)</center>
                                              </th>
                                              <th hidden>
                                                <center>CREATED AT</center>
                                              </th>
                                              <th style="width:5%">
                                                <center><button type="button" class="btn btn-sm bg-navy" onclick="addrowlinewipp_0(${i+1})" style="border-radius:10px;" name="button"><i class="fa fa-plus-square"></i></button></center>
                                              </th>
                                            </tr>
                                          </thead>
                                          <tbody id="tambahisiwipp0${i+1}" class="tbl_row_split">
                                          <tr class="rowbaru0_wipp" id="wipp0row1">
                                            <td>
                                              <center><input type="text" value="${v[1]}" class="form-control" name="job0[]" id="job0${i+1}_wipp1" placeholder="ITEM CODE"></center>
                                            </td>
                                            <td>
                                              <center><input type="text" value="${v[2]}" class="form-control" name="item0[]" id="item0${i+1}_wipp1" placeholder="ITEM"></center>
                                            </td>
                                            <td>
                                              <center><input type="number" value="${v[4]}" class="form-control iminhere${i+1}" oninput="changeQtyValue_(1, ${i+1})" name="qty0[]" id="qty0${i+1}_wipp1" placeholder="QTY"></center>
                                            </td>
                                            <td>
                                              <center><input type="number" value="" class="form-control andhere${i+1}" name="target0[]" id="target0${i+1}_pe1" placeholder="00%"></center>
                                            </td>
                                            <td hidden>
                                              <center><input type="text" value="" class="form-control param"></center>
                                            </td>
                                            <td>
                                              <center><button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp0_(1, ${i+1})" style="border-radius:10px;" name="button"><i class="fa fa-minus-square"></i></button></center>
                                            </td>
                                          </tr>
                                          </tbody>
                                        </table>
                                        <br>
                                        <center class="btnsplit${i+1}" hidden><button type="button" style="margin-bottom:10px !important;" hidden class="btn bg-navy" onclick="saveSplit_(${i+1}, '${v[1]}', '${v[2]}', '${v[3]}', '${v[4]}', '${v[5]}', '${v[7]}')" name="button"><i class="fa fa-sign-in"></i> Append</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        </div>
                      </div>
                      </td>
                    </tr>
                  `;
      listJobWipp.push(a2134a);
    })
  $('#create-new-rkh').html(listJobWipp.join(" "));
}


</script>
