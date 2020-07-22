<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-cloud-upload"></i> Label Manager (<?php
          $x = explode('_', $param);
          echo $x[0] ?> - <?php echo $x[1] == 'R'?'Reguler':'Lembur' ?>)</h4>
        </div>
        <center>
          <h4 style="font-weight:bold">JOB LIST</h4>
        </center>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">

            <div class="col-md-12">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
                <div class="row">
                  <div class="col-md-12">
                    <h4 style="font-weight:bold;">LINE 1 (<b style="color:#2284af" id="target_pe_line1"><?php !empty($line_1[0]['target_pe_max'])?$l1 = $line_1[0]['target_pe_max'] : $l1 = ''; echo $l1; ?></b><b>%</b>)</h4>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left line1wipp tblwiip" style="font-size:11px;">
                    <thead>
                      <tr class="bg-info">
                        <th style="width:26%">
                          <center>JOB</center>
                        </th>
                        <th style="width:25%">
                          <center>ITEM</center>
                        </th>
                        <th style="width:17%">
                          <center>QTY</center>
                        </th>
                        <th style="width:15%">
                          <center>LABEL KECIL</center>
                        </th>
                        <th style="width:20%">
                          <center>LABEL BESAR</center>
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
                            <input style="width:100%;" type="text" class="form-control" id="job_wipp<?php echo $key+1 ?>" name="job1[]" value="<?php echo $l1['no_job'] ?>" readonly>
                          </center>
                        </td>
                        <td>
                          <center><input style="width:100%;" type="text" class="form-control" name="item1[]" id="item_wipp<?php echo $key+1 ?>" placeholder="ITEM" value="<?php echo $l1['kode_item'] ?>" readonly></center>
                        </td>
                        <td>
                          <center><input style="width:100%;" type="text" class="form-control" name="qty1[]" id="qty_wipp<?php echo $key+1 ?>" placeholder="QTY" value="<?php echo $l1['qty'] ?>" readonly></center>
                        </td>
                        <td>
                          <center>
                            <a class="btn btn-sm bg-navy" style="border-radius:3px;padding:7px;margin-top:0;" target="_blank" href="<?php echo base_url('WorkInProcessPackaging/JobManager/LabelKecil/'.$l1['kode_item'].'_'.ceil($l1['qty']*abs($l1['QTY_BOM'])).'')?>"><i class="fa fa-print"></i> PRINT
                              (<?php echo ceil($l1['qty']*abs($l1['QTY_BOM'])) ?>)</a>
                          </center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-sm bg-navy" onclick="print_besar('<?php echo $l1['kode_item'] ?>', '<?php echo $key ?>', 1)" style="border-radius:3px;padding:7px;margin-top:0;" name="button"><i class="fa fa-print"></i> PRINT</button>
                            <input type="number" class="form-control" id="qtyl1_<?php echo $key ?>" style="width:30%;display:inline;margin-left:10px;">
                          </center>
                        </td>
                      </tr>
                      <?php endforeach; ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-12" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
                <div class="row">
                  <div class="col-md-12">
                    <h4 style="font-weight:bold;">LINE 2 (<b style="color:#2284af" id="target_pe_line2"><?php !empty($line_2[0]['target_pe_max'])?$l2 = $line_2[0]['target_pe_max'] : $l2 = ''; echo $l2; ?></b><b>%</b>)</h4>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left line2wipp tblwiip" style="font-size:11px;">
                    <thead>
                      <tr class="bg-info">
                        <th style="width:26%">
                          <center>JOB</center>
                        </th>
                        <th style="width:25%">
                          <center>ITEM</center>
                        </th>
                        <th style="width:17%">
                          <center>QTY</center>
                        </th>
                        <th style="width:15%">
                          <center>LABEL KECIL</center>
                        </th>
                        <th style="width:20%">
                          <center>LABEL BESAR</center>
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
                            <input style="width:100%;" type="text" class="form-control" id="job2_wipp<?php echo $key+1 ?>" name="job2[]" value="<?php echo $l2['no_job'] ?>" readonly>
                          </center>
                        </td>
                        <td>
                          <center><input style="width:100%;" type="text" class="form-control" name="item2[]" id="item2_wipp<?php echo $key+1 ?>" placeholder="ITEM" value="<?php echo $l2['kode_item'] ?>" readonly></center>
                        </td>
                        <td>
                          <center><input style="width:100%;" type="text" class="form-control" name="qty2[]" id="qty2_wipp<?php echo $key+1 ?>" placeholder="QTY" value="<?php echo $l2['qty'] ?>" readonly></center>
                        </td>
                        <td>
                          <center>
                            <a class="btn btn-sm bg-navy" style="border-radius:3px;padding:7px;margin-top:0;" target="_blank" href="<?php echo base_url('WorkInProcessPackaging/JobManager/LabelKecil/'.$l2['kode_item'].'_'.ceil($l2['qty']*abs($l2['QTY_BOM'])).'')?>"><i class="fa fa-print"></i> PRINT
                              (<?php echo ceil($l2['qty']*abs($l2['QTY_BOM'])) ?>)</a>
                          </center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-sm bg-navy" onclick="print_besar('<?php echo $l2['kode_item'] ?>', '<?php echo $key ?>', 2)" style="border-radius:3px;padding:7px;margin-top:0;" name="button"><i class="fa fa-print"></i> PRINT</button>
                            <input type="number" class="form-control" id="qtyl2_<?php echo $key ?>" style="width:30%;display:inline;margin-left:10px;">
                          </center>
                        </td>
                      </tr>
                      <?php endforeach; ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-12" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
                <div class="row">
                  <div class="col-md-12">
                    <h4 style="font-weight:bold;">LINE 3 (<b style="color:#2284af" id="target_pe_line3"><?php !empty($line_3[0]['target_pe_max'])?$l3 = $line_3[0]['target_pe_max'] : $l3 = ''; echo $l3; ?></b><b>%</b>)</h4>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left line3wipp tblwiip" style="font-size:11px;">
                    <thead>
                      <tr class="bg-info">
                        <th style="width:26%">
                          <center>JOB</center>
                        </th>
                        <th style="width:25%">
                          <center>ITEM</center>
                        </th>
                        <th style="width:17%">
                          <center>QTY</center>
                        </th>
                        <th style="width:15%">
                          <center>LABEL KECIL</center>
                        </th>
                        <th style="width:20%">
                          <center>LABEL BESAR</center>
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
                            <input style="width:100%;" type="text" class="form-control" id="job3_wipp<?php echo $key+1 ?>" name="job3[]" value="<?php echo $l3['no_job'] ?>" readonly>
                          </center>
                        </td>
                        <td>
                          <center><input style="width:100%;" type="text" class="form-control" name="item3[]" id="item3_wipp<?php echo $key+1 ?>" value="<?php echo $l3['kode_item'] ?>" placeholder="ITEM" readonly></center>
                        </td>
                        <td>
                          <center><input style="width:100%;" type="text" class="form-control" name="qty3[]" id="qty3_wipp<?php echo $key+1 ?>" value="<?php echo $l3['qty'] ?>" placeholder="QTY" readonly></center>
                        </td>
                        <td>
                          <center>
                            <a class="btn btn-sm bg-navy" style="border-radius:3px;padding:7px;margin-top:0;" target="_blank" href="<?php echo base_url('WorkInProcessPackaging/JobManager/LabelKecil/'.$l3['kode_item'].'_'.ceil($l3['qty']*abs($l3['QTY_BOM'])).'')?>"><i class="fa fa-print"></i> PRINT(<?php echo
                            ceil($l3['qty']*abs($l3['QTY_BOM'])) ?>)</a>
                          </center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-sm bg-navy" onclick="print_besar('<?php echo $l3['kode_item'] ?>', '<?php echo $key ?>', 3)" style="border-radius:3px;padding:7px;margin-top:0;" name="button"><i class="fa fa-print"></i> PRINT</button>
                            <input type="number" class="form-control" id="qtyl3_<?php echo $key ?>" style="width:30%;display:inline;margin-left:10px;">
                          </center>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-12" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
                <div class="row">
                  <div class="col-md-12">
                    <h4 style="font-weight:bold;">LINE 4 (<span style="color:#2284af" id="target_pe_line4"><?php !empty($line_4[0]['target_pe_max'])?$l4 = $line_4[0]['target_pe_max'] : $l4 = ''; echo $l4; ?></span><b>%</b>)</h4>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left line4wipp tblwiip" style="font-size:11px;">
                    <thead>
                      <tr class="bg-info">
                        <th style="width:26%">
                          <center>JOB</center>
                        </th>
                        <th style="width:25%">
                          <center>ITEM</center>
                        </th>
                        <th style="width:17%">
                          <center>QTY</center>
                        </th>
                        <th style="width:15%">
                          <center>LABEL KECIL</center>
                        </th>
                        <th style="width:20%">
                          <center>LABEL BESAR</center>
                        </th>
                      </tr>
                    </thead>
                    <tbody id="tambahisiwipp4">
                      <?php foreach ($line_4 as $key => $l4): ?>
                      <tr class="rowbaru4_wipp" id="wipp4row1">
                        <td>
                          <center>
                            <input style="width:100%;" type="text" class="form-control" id="job4_wipp<?php echo $key+1 ?>" name="job4[]" value="<?php echo $l4['no_job'] ?>" readonly>
                          </center>
                        </td>
                        <td>
                          <center><input style="width:100%;" type="text" class="form-control" name="item4[]" id="item4_wipp<?php echo $key+1 ?>" value="<?php echo $l4['kode_item'] ?>" placeholder="ITEM" readonly></center>
                        </td>
                        <td>
                          <center><input style="width:100%;" type="text" class="form-control" name="qty4[]" id="qty4_wipp<?php echo $key+1 ?>" value="<?php echo $l4['qty'] ?>" placeholder="QTY" readonly></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-sm bg-navy" onclick="print_kecil('<?php echo $l4['kode_item'] ?>', '<?php echo $key ?>', 4)" style="border-radius:3px;padding:7px;margin-top:0;" name="button"><i class="fa fa-print"></i> PRINT</button>
                            <input type="number" class="form-control" id="qtyll4_<?php echo $key ?>" style="width:45%;display:inline;margin-left:10px;">
                          </center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-sm bg-navy" onclick="print_besar('<?php echo $l4['kode_item'] ?>', '<?php echo $key ?>', 4)" style="border-radius:3px;padding:7px;margin-top:0;" name="button"><i class="fa fa-print"></i> PRINT</button>
                            <input type="number" class="form-control" id="qtyl4_<?php echo $key ?>" style="width:45%;display:inline;margin-left:10px;">
                          </center>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-12" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                <div class="row">
                  <div class="col-md-12">
                    <h4 style="font-weight:bold;">LINE 5 (<span style="color:#2284af" id="target_pe_line5"><?php !empty($line_5[0]['target_pe_max'])?$l5 = $line_5[0]['target_pe_max'] : $l5 = ''; echo $l5; ?></span><b>%</b>)</h4>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left line5wipp tblwiip" style="font-size:11px;">
                    <thead>
                      <tr class="bg-info">
                        <th style="width:26%">
                          <center>JOB</center>
                        </th>
                        <th style="width:25%">
                          <center>ITEM</center>
                        </th>
                        <th style="width:17%">
                          <center>QTY</center>
                        </th>
                        <th style="width:15%">
                          <center>LABEL KECIL</center>
                        </th>
                        <th style="width:20%">
                          <center>LABEL BESAR</center>
                        </th>
                      </tr>
                    </thead>
                    <tbody id="tambahisiwipp5">
                      <?php foreach ($line_5 as $key => $l5): ?>
                      <tr class="rowbaru5_wipp" id="wipp5row1">
                        <td>
                          <center>
                            <input style="width:100%;" type="text" class="form-control" id="job5_wipp<?php echo $key+1 ?>" name="job5[]" value="<?php echo $l5['no_job'] ?>" readonly>
                          </center>
                        </td>
                        <td>
                          <center><input style="width:100%;" type="text" class="form-control" name="item5[]" id="item5_wipp<?php echo $key+1 ?>" value="<?php echo $l5['kode_item'] ?>" placeholder="ITEM" readonly></center>
                        </td>
                        <td>
                          <center><input style="width:100%;" type="text" class="form-control" name="qty5[]" id="qty5_wipp<?php echo $key+1 ?>" value="<?php echo $l5['qty'] ?>" placeholder="QTY" readonly></center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-sm bg-navy" onclick="print_kecil('<?php echo $l5['kode_item'] ?>', '<?php echo $key ?>', 5)" style="border-radius:3px;padding:7px;margin-top:0;" name="button"><i class="fa fa-print"></i> PRINT</button>
                            <input type="number" class="form-control" id="qtyll5_<?php echo $key ?>" style="width:45%;display:inline;margin-left:10px;">
                          </center>
                        </td>
                        <td>
                          <center>
                            <button type="button" class="btn btn-sm bg-navy" onclick="print_besar('<?php echo $l5['kode_item'] ?>', '<?php echo $key ?>', 5)" style="border-radius:3px;padding:7px;margin-top:0;" name="button"><i class="fa fa-print"></i> PRINT</button>
                            <input type="number" class="form-control" id="qtyl5_<?php echo $key ?>" style="width:45%;display:inline;margin-left:10px;">
                          </center>
                        </td>
                      </tr>
                      <?php endforeach; ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
