
<div class="col-md-12">
  <div class="row">
    <div class="col-md-6">
      <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
        <div class="row">
            <div class="col-md-9">
              <h4 style="font-weight:bold;">LINE 1 (<b style="color:#2284af" id="target_pe_line1"><?php !empty($line_1[0]['target_pe_max'])?$l1 = $line_1[0]['target_pe_max'] : $l1 = ''; echo $l1; ?></b><b>%</b>)</h4>
            </div>
            <div class="col-md-3">
              <button type="button" style="float:right" name="button" class="btn btn-danger" data-toggle="modal" data-target="#wipp4" onclick="setTargetPe(1)"><i class="fa fa-wifi"></i> Set Target</button>
            </div>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover text-left line1wipp" style="font-size:11px;">
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
                <th style="width:5%">
                  <center><button type="button" class="btn btn-sm bg-navy" onclick="addrowlinewipp()" style="border-radius:10px;" name="button"><i class="fa fa-plus-square"></i></button></center>
                </th>
              </tr>
            </thead>
            <tbody id="tambahisiwipp">

              <?php foreach ($line_1 as $key => $l1): ?>
              <tr class="rowbaru_wipp" id="wipprow1">
                <td>
                  <center>
                    <!-- <select class="form-control select2" id="job_wipp1" name="job[]" style="width:100%" required>
                      <option value="">AAA123213EA</option>
                    </select> -->
                    <input type="text" class="form-control" id="job_wipp<?php echo $key+1 ?>" name="job1[]" value="<?php echo $l1['no_job'] ?>" readonly>
                  </center>
                </td>
                <td>
                  <center><input type="text" class="form-control" name="item1[]" id="item_wipp<?php echo $key+1 ?>" placeholder="ITEM" value="<?php echo $l1['kode_item'] ?>" readonly></center>
                </td>
                <td>
                  <center><input type="text" class="form-control" name="qty1[]" id="qty_wipp<?php echo $key+1 ?>" placeholder="QTY" value="<?php echo $l1['qty'] ?>" readonly></center>
                </td>
                <td>
                  <center><input type="text" class="form-control" name="target1[]" id="target_pe<?php echo $key+1 ?>" placeholder="20%" value="<?php echo $l1['target_pe'] ?>" readonly></center>
                </td>
                <td>
                  <center><button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp(<?php echo $key+1 ?>)" style="border-radius:10px;" name="button"><i class="fa fa-minus-square"></i></button></center>
                </td>
              </tr>
              <input type="hidden" name="id_job_list1[]" value="<?php echo $l1['id_job_list'] ?>">
              <input type="hidden" name="id_split1[]" value="<?php echo $l1['id_split'] ?>">
             <?php endforeach; ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
        <div class="row">
            <div class="col-md-9">
              <h4 style="font-weight:bold;">LINE 2 (<b style="color:#2284af" id="target_pe_line2"><?php !empty($line_2[0]['target_pe_max'])?$l2 = $line_2[0]['target_pe_max'] : $l2 = ''; echo $l2; ?></b><b>%</b>)</h4>
            </div>
            <div class="col-md-3">
              <button type="button" style="float:right" name="button" class="btn btn-danger" data-toggle="modal" data-target="#wipp4" onclick="setTargetPe(2)"><i class="fa fa-wifi"></i> Set Target</button>
            </div>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover text-left line2wipp" style="font-size:11px;">
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
                <th style="width:5%">
                  <center><button type="button" class="btn btn-sm bg-navy" onclick="addrowlinewipp2()" style="border-radius:10px;" name="button"><i class="fa fa-plus-square"></i></button></center>
                </th>
              </tr>
            </thead>
            <tbody id="tambahisiwipp2">
              <?php foreach ($line_2 as $key => $l2): ?>
              <tr class="rowbaru2_wipp" id="wipp2row1">
                <td>
                  <center>
                    <!-- <select class="form-control select2" id="job2_wipp1" name="job2[]" style="width:100%" required>
                      <option value="">AAA123213EA</option>
                    </select> -->
                    <input type="text" class="form-control" id="job2_wipp<?php echo $key+1 ?>" name="job2[]" value="<?php echo $l2['no_job'] ?>" readonly>
                  </center>
                </td>
                <td>
                  <center><input type="text" class="form-control" name="item2[]" id="item2_wipp<?php echo $key+1 ?>" placeholder="ITEM" value="<?php echo $l2['kode_item'] ?>" readonly></center>
                </td>
                <td>
                  <center><input type="text" class="form-control" name="qty2[]" id="qty2_wipp<?php echo $key+1 ?>" placeholder="QTY" value="<?php echo $l2['qty'] ?>" readonly></center>
                </td>
                <td>
                  <center><input type="text" class="form-control" name="target2[]" id="target2_pe<?php echo $key+1 ?>" placeholder="20%" value="<?php echo $l2['target_pe'] ?>" readonly></center>
                </td>
                <td>
                  <center><button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp2(<?php echo $key+1 ?>)" style="border-radius:10px;" name="button"><i class="fa fa-minus-square"></i></button></center>
                </td>
              </tr>
              <input type="hidden" name="id_job_list2[]" value="<?php echo $l2['id_job_list'] ?>">
              <input type="hidden" name="id_split2[]" value="<?php echo $l2['id_split'] ?>">
             <?php endforeach; ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="col-md-12">
  <div class="row">
    <div class="col-md-6" style="margin-top:15px;">
      <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
        <div class="row">
            <div class="col-md-9">
              <h4 style="font-weight:bold;">LINE 3 (<b style="color:#2284af" id="target_pe_line3"><?php !empty($line_3[0]['target_pe_max'])?$l3 = $line_3[0]['target_pe_max'] : $l3 = ''; echo $l3; ?></b><b>%</b>)</h4>
            </div>
            <div class="col-md-3">
              <button type="button" style="float:right" name="button" class="btn btn-danger" data-toggle="modal" data-target="#wipp4" onclick="setTargetPe(3)"><i class="fa fa-wifi"></i> Set Target</button>
            </div>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover text-left line3wipp" style="font-size:11px;">
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
                <th style="width:5%">
                  <center><button type="button" class="btn btn-sm bg-navy" onclick="addrowlinewipp3()" style="border-radius:10px;" name="button"><i class="fa fa-plus-square"></i></button></center>
                </th>
              </tr>
            </thead>
            <tbody id="tambahisiwipp3">
              <?php foreach ($line_3 as $key => $l3): ?>
                <tr class="rowbaru3_wipp" id="wipp3row1">
                  <td>
                    <center>
                      <!-- <select class="form-control select3" id="job3_wipp1" name="job3[]" style="width:100%" required>
                        <option value="">AAA133313EA</option>
                      </select> -->
                      <input type="text" class="form-control" id="job3_wipp<?php echo $key+1 ?>" name="job3[]" value="<?php echo $l3['no_job'] ?>" readonly>
                    </center>
                  </td>
                  <td>
                    <center><input type="text" class="form-control" name="item3[]" id="item3_wipp<?php echo $key+1 ?>" value="<?php echo $l3['kode_item'] ?>" placeholder="ITEM" readonly></center>
                  </td>
                  <td>
                    <center><input type="text" class="form-control" name="qty3[]" id="qty3_wipp<?php echo $key+1 ?>" value="<?php echo $l3['qty'] ?>" placeholder="QTY" readonly></center>
                  </td>
                  <td>
                    <center><input type="text" class="form-control" name="target3[]" id="target3_pe<?php echo $key+1 ?>" value="<?php echo $l3['target_pe'] ?>" placeholder="30%" readonly></center>
                  </td>
                  <td>
                    <center><button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp3(<?php echo $key+1 ?>)" style="border-radius:10px;" name="button"><i class="fa fa-minus-square"></i></button></center>
                  </td>
                </tr>
                <input type="hidden" name="id_job_list3[]" value="<?php echo $l3['id_job_list'] ?>">
                <input type="hidden" name="id_split3[]" value="<?php echo $l3['id_split'] ?>">
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-6" style="margin-top:15px;">
      <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
        <div class="row">
            <div class="col-md-9">
              <h4 style="font-weight:bold;">LINE 4 (<span style="color:#2284af" id="target_pe_line4"><?php !empty($line_4[0]['target_pe_max'])?$l4 = $line_4[0]['target_pe_max'] : $l4 = ''; echo $l4; ?></span><b>%</b>) ADA DOS</h4>
            </div>
            <div class="col-md-3">
              <button type="button" style="float:right" name="button" class="btn btn-danger" data-toggle="modal" data-target="#wipp4" onclick="setTargetPe(4)"><i class="fa fa-wifi"></i> Set Target</button>
            </div>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover text-left line4wipp" style="font-size:11px;">
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
                <th style="width:5%">
                  <center><button type="button" class="btn btn-sm bg-navy" onclick="addrowlinewipp4()" style="border-radius:10px;" name="button"><i class="fa fa-plus-square"></i></button></center>
                </th>
              </tr>
            </thead>
            <tbody id="tambahisiwipp4">
              <?php foreach ($line_4 as $key => $l4): ?>
                <tr class="rowbaru4_wipp" id="wipp4row1">
                  <td>
                    <center>
                      <!-- <select class="form-control select4" id="job4_wipp1" name="job4[]" style="width:100%" required>
                        <option value="">AAA144414EA</option>
                      </select> -->
                      <input type="text" class="form-control" id="job4_wipp<?php echo $key+1 ?>" name="job4[]" value="<?php echo $l4['no_job'] ?>" readonly>
                    </center>
                  </td>
                  <td>
                    <center><input type="text" class="form-control" name="item4[]" id="item4_wipp<?php echo $key+1 ?>" value="<?php echo $l4['kode_item'] ?>" placeholder="ITEM" readonly></center>
                  </td>
                  <td>
                    <center><input type="text" class="form-control" name="qty4[]" id="qty4_wipp<?php echo $key+1 ?>" value="<?php echo $l4['qty'] ?>" placeholder="QTY" readonly></center>
                  </td>
                  <td>
                    <center><input type="text" class="form-control" name="target4[]" id="target4_pe<?php echo $key+1 ?>" value="<?php echo $l4['target_pe'] ?>" placeholder="40%" readonly></center>
                  </td>
                  <td>
                    <center><button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp4(<?php echo $key+1 ?>)" style="border-radius:10px;" name="button"><i class="fa fa-minus-square"></i></button></center>
                  </td>
                </tr>
                <input type="hidden" name="id_job_list4[]" value="<?php echo $l4['id_job_list'] ?>">
                <input type="hidden" name="id_split4[]" value="<?php echo $l4['id_split'] ?>">
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-md-12" style="margin-top:15px;">
  <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
    <div class="row">
        <div class="col-md-9">
          <h4 style="font-weight:bold;">LINE 5 (<span style="color:#2284af" id="target_pe_line5"><?php !empty($line_5[0]['target_pe_max'])?$l5 = $line_5[0]['target_pe_max'] : $l5 = ''; echo $l5; ?></span><b>%</b>) ADA DOS</h4>
        </div>
        <div class="col-md-3">
          <button type="button" style="float:right" name="button" class="btn btn-danger" data-toggle="modal" data-target="#wipp4" onclick="setTargetPe(5)"><i class="fa fa-wifi"></i> Set Target</button>
        </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover text-left line5wipp" style="font-size:11px;">
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
            <th style="width:5%">
              <center><button type="button" class="btn btn-sm bg-navy" onclick="addrowlinewipp5()" style="border-radius:10px;" name="button"><i class="fa fa-plus-square"></i></button></center>
            </th>
          </tr>
        </thead>
        <tbody id="tambahisiwipp5">
          <?php foreach ($line_5 as $key => $l5): ?>
            <tr class="rowbaru5_wipp" id="wipp5row1">
              <td>
                <center>
                  <!-- <select class="form-control select5" id="job5_wipp1" name="job5[]" style="width:100%" required>
                    <option value="">AAA155515EA</option>
                  </select> -->
                  <input type="text" class="form-control" id="job5_wipp<?php echo $key+1 ?>" name="job5[]" value="<?php echo $l5['no_job'] ?>" readonly>
                </center>
              </td>
              <td>
                <center><input type="text" class="form-control" name="item5[]" id="item5_wipp<?php echo $key+1 ?>" value="<?php echo $l5['kode_item'] ?>" placeholder="ITEM" readonly></center>
              </td>
              <td>
                <center><input type="text" class="form-control" name="qty5[]" id="qty5_wipp<?php echo $key+1 ?>" value="<?php echo $l5['qty'] ?>" placeholder="QTY" readonly></center>
              </td>
              <td>
                <center><input type="text" class="form-control" name="target5[]" id="target5_pe<?php echo $key+1 ?>" value="<?php echo $l5['target_pe'] ?>" placeholder="50%" readonly></center>
              </td>
              <td>
                <center><button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp5(1)" style="border-radius:10px;" name="button"><i class="fa fa-minus-square"></i></button></center>
              </td>
            </tr>
            <input type="hidden" name="id_job_list5[]" value="<?php echo $l5['id_job_list'] ?>">
            <input type="hidden" name="id_split5[]" value="<?php echo $l5['id_split'] ?>">
          <?php endforeach; ?>

        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="col-md-12">
  <br>
  <center>
    <div style="background:#ffffff !important; border-radius:7px;padding:10px;width:91px">
      <button type="submit" class="btn btn-md btn-primary" name="button"><i class="fa fa-hdd-o"></i> <b>Save</b></button>
    </div>
  </center>
</div>
