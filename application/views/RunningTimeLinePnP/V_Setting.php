<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-cloud-upload"></i> Setting Job Lane</h4>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-12">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
                <div class="col-md-2"></div>
                <div class="col-md-6" style="padding-bottom:10px;">
                  <label for="">Tentukan Tanggal</label>
                  <input type="text" autocomplete="off" class="form-control txtWIIPdate" placeholder="..." style="width:100%;" name="" value="">
                </div>
                <div class="col-md-2">
                  <button type="button" style="width:100%;margin-top:25px" class="btn bg-maroon" onclick="setDate()" name="button"><i class="fa fa-gears"></i> Submit</button>
                </div>
                <div class="col-md-2"></div>
              </div>
              <br>
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
                        <th class="text-center">No</th>
												<th class="text-center">No Job</th>
												<th class="text-center">Kode</th>
												<th class="text-center">Nama Barang</th>
												<th class="text-center">Target PPIC</th>
												<th class="text-center">Target PE</th>
												<th class="text-center">Plan (%)</th>
												<th class="text-center">Ket</th>
												<th class="text-center">Waktu</th>
                      </tr>
                    </thead>
                    <tbody id="tambahisiwipp" class="length1">
                      <?php foreach ($line_1 as $key => $l1): ?>
                      <tr class="rowbaru_wipp timer1" id="wipprow1">
                        <td>
                          <center><?php echo $key+1 ?></center>
                        </td>
                        <td><center><?php echo $l1['no_job'] ?></center></td>
                        <td><center><?php echo $l1['kode_item'] ?></center></td>
                        <td><center>-</center></td>
                        <td><center>-</center></td>
                        <td><center><?php echo $l1['target_pe'] ?></center></td>
                        <td><center>-</center></td>
                        <td><center>-</center></td>
                        <td>
                          <center>
                          <p id="timer1">
                            <label id="hours1-<?php echo $key ?>">00</label>:<label id="minutes1-<?php echo $key ?>">00</label>:<label id="seconds1-<?php echo $key ?>">00</label>
                          </p>
                          <button style="border-radius: 50px" class="btn bg-primary btn-xs btn-flat" onclick="start1[<?php echo $key ?>]('<?php echo $l1['kode_item'] ?>', '<?php echo '1' ?>')" id="btnstart1<?php echo $key ?>"> <i class="fa fa-play-circle"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-orange btn-xs btn-flat" onclick="pause1[<?php echo $key ?>]()" id="btnlanjut<?php echo $key ?>" disabled> <i class="fa fa-pause"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-green btn-xs btn-flat" onclick="reset1[<?php echo $key ?>]()" id="btnrestart<?php echo $key ?>" disabled> <i class="fa fa-repeat"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-red btn-xs btn-flat" onclick="selesai1[<?php echo $key ?>]('<?php echo $l1['kode_item'] ?>', '<?php echo '1' ?>')" id="btnfinish1<?php echo $key ?>" disabled> <i class="fa fa-stop"></i> </button>
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
                        <th class="text-center">No</th>
                        <th class="text-center">No Job</th>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Nama Barang</th>
                        <th class="text-center">Target PPIC</th>
                        <th class="text-center">Target PE</th>
                        <th class="text-center">Plan (%)</th>
                        <th class="text-center">Ket</th>
                        <th class="text-center">Waktu</th>
                      </tr>
                    </thead>
                    <tbody id="tambahisiwipp2" class="length2" data-length=<?php echo sizeof($line_2) ?>>
                      <?php foreach ($line_2 as $key => $l2): ?>
                      <tr class="rowbaru2_wipp timer2" id="wipp2row1">
                        <td>
                          <center><?php echo $key+1 ?></center>
                        </td>
                        <td><center><?php echo $l2['no_job'] ?></center></td>
                        <td><center><?php echo $l2['kode_item'] ?></center></td>
                        <td><center>-</center></td>
                        <td><center>-</center></td>
                        <td><center><?php echo $l2['target_pe'] ?></center></td>
                        <td><center>-</center></td>
                        <td><center>-</center></td>
                        <td>
                          <center>
                          <p id="timer1">
                            <label id="hours2-<?php echo $key ?>">00</label>:<label id="minutes2-<?php echo $key ?>">00</label>:<label id="seconds2-<?php echo $key ?>">00</label>
                          </p>
                          <button style="border-radius: 50px" class="btn bg-primary btn-xs btn-flat" onclick="start2[<?php echo $key ?>]('<?php echo $l2['kode_item'] ?>', '<?php echo '2' ?>')" id="btnstart2<?php echo $key ?>"> <i class="fa fa-play-circle"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-orange btn-xs btn-flat" onclick="pause2[<?php echo $key ?>]()" id="btnlanjut<?php echo $key ?>" disabled> <i class="fa fa-pause"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-green btn-xs btn-flat" onclick="reset2[<?php echo $key ?>]()" id="btnrestart<?php echo $key ?>" disabled> <i class="fa fa-repeat"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-red btn-xs btn-flat" onclick="selesai2[<?php echo $key ?>]('<?php echo $l2['kode_item'] ?>', '<?php echo '2' ?>')" id="btnfinish2<?php echo $key ?>" disabled> <i class="fa fa-stop"></i> </button>
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
                        <th class="text-center">No</th>
                        <th class="text-center">No Job</th>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Nama Barang</th>
                        <th class="text-center">Target PPIC</th>
                        <th class="text-center">Target PE</th>
                        <th class="text-center">Plan (%)</th>
                        <th class="text-center">Ket</th>
                        <th class="text-center">Waktu</th>
                      </tr>
                    </thead>
                    <tbody id="tambahisiwipp3" class="length3" data-length=<?php echo sizeof($line_3) ?> >
                      <?php foreach ($line_3 as $key => $l3): ?>
                      <tr class="timer3">
												<td class="text-center"><?php echo $key+1 ?></td>
												<td class="text-center"><?php echo $l3['no_job'] ?></td>
												<td class="text-center"><?php echo $l3['kode_item'] ?></td>
												<td class="text-center">-</td>
												<td class="text-center">-</td>
                        <td><center><?php echo $l3['target_pe'] ?></center></td>
                        <td><center>-</center></td>
                        <td><center>-</center></td>
												<td class="text-center">
													<p id="timer1">
														<label id="hours3-<?php echo $key ?>">00</label>:<label id="minutes3-<?php echo $key ?>">00</label>:<label id="seconds3-<?php echo $key ?>">00</label>
													</p>
													<button style="border-radius: 50px" class="btn bg-primary btn-xs btn-flat" onclick="start3[<?php echo $key ?>]('<?php echo $l3['kode_item'] ?>', '<?php echo '3' ?>')" id="btnstart3<?php echo $key ?>"> <i class="fa fa-play-circle"></i> </button>
													<button style="border-radius: 50px" class="btn bg-orange btn-xs btn-flat" onclick="pause3[<?php echo $key ?>]()" id="btnlanjut<?php echo $key ?>" disabled> <i class="fa fa-pause"></i> </button>
													<button style="border-radius: 50px" class="btn bg-green btn-xs btn-flat" onclick="reset3[<?php echo $key ?>]()" id="btnrestart<?php echo $key ?>" disabled> <i class="fa fa-repeat"></i> </button>
													<button style="border-radius: 50px" class="btn bg-red btn-xs btn-flat" onclick="selesai3[<?php echo $key ?>]('<?php echo $l3['kode_item'] ?>', '<?php echo '3' ?>')" id="btnfinish3<?php echo $key ?>" disabled> <i class="fa fa-stop"></i> </button>
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
                        <th class="text-center">No</th>
                        <th class="text-center">No Job</th>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Nama Barang</th>
                        <th class="text-center">Target PPIC</th>
                        <th class="text-center">Target PE</th>
                        <th class="text-center">Plan (%)</th>
                        <th class="text-center">Ket</th>
                        <th class="text-center">Waktu</th>
                      </tr>
                    </thead>
                    <tbody id="tambahisiwipp4" class="length4" data-length=<?php echo sizeof($line_4) ?> >
                      <?php foreach ($line_4 as $key => $l4): ?>
                      <tr class="timer4">
                        <td class="text-center"><?php echo $key+1 ?></td>
                        <td class="text-center"><?php echo $l4['no_job'] ?></td>
                        <td class="text-center"><?php echo $l4['kode_item'] ?></td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                        <td><center><?php echo $l4['target_pe'] ?></center></td>
                        <td><center>-</center></td>
                        <td><center>-</center></td>
                        <td class="text-center">
                          <p id="timer1">
                            <label id="hours4-<?php echo $key ?>">00</label>:<label id="minutes4-<?php echo $key ?>">00</label>:<label id="seconds4-<?php echo $key ?>">00</label>
                          </p>
                          <button style="border-radius: 50px" class="btn bg-primary btn-xs btn-flat" onclick="start4[<?php echo $key ?>]('<?php echo $l4['kode_item'] ?>', '<?php echo '4' ?>')" id="btnstart4<?php echo $key ?>"> <i class="fa fa-play-circle"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-orange btn-xs btn-flat" onclick="pause4[<?php echo $key ?>]()" id="btnlanjut<?php echo $key ?>" disabled> <i class="fa fa-pause"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-green btn-xs btn-flat" onclick="reset4[<?php echo $key ?>]()" id="btnrestart<?php echo $key ?>" disabled> <i class="fa fa-repeat"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-red btn-xs btn-flat" onclick="selesai4[<?php echo $key ?>]('<?php echo $l4['kode_item'] ?>', '<?php echo '4' ?>')" id="btnfinish4<?php echo $key ?>" disabled> <i class="fa fa-stop"></i> </button>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <!-- <div class="col-md-12" style="margin-top:10px">
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
                        <th class="text-center">No</th>
                        <th class="text-center">No Job</th>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Nama Barang</th>
                        <th class="text-center">Target PPIC</th>
                        <th class="text-center">Target PE</th>
                        <th class="text-center">Plan (%)</th>
                        <th class="text-center">Ket</th>
                        <th class="text-center">Waktu</th>
                      </tr>
                    </thead>
                    <tbody id="tambahisiwipp5" class="length5" data-length=<?php echo sizeof($line_5) ?> >
                      <?php foreach ($line_5 as $key => $l5): ?>
                      <tr class="timer5">
                        <td class="text-center"><?php echo $key+1 ?></td>
                        <td class="text-center"><?php echo $l5['no_job'] ?></td>
                        <td class="text-center"><?php echo $l5['kode_item'] ?></td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                        <td><center><?php echo $l5['target_pe'] ?></center></td>
                        <td><center>-</center></td>
                        <td><center>-</center></td>
                        <td class="text-center">
                          <p id="timer1">
                            <label id="hours5-<?php echo $key ?>">00</label>:<label id="minutes5-<?php echo $key ?>">00</label>:<label id="seconds5-<?php echo $key ?>">00</label>
                          </p>
                          <button style="border-radius: 50px" class="btn bg-primary btn-xs btn-flat" onclick="start5[<?php echo $key ?>]('<?php echo $l5['kode_item'] ?>', '<?php echo '5' ?>')" id="btnstart5<?php echo $key ?>"> <i class="fa fa-play-circle"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-orange btn-xs btn-flat" onclick="pause5[<?php echo $key ?>]()" id="btnlanjut<?php echo $key ?>" disabled> <i class="fa fa-pause"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-green btn-xs btn-flat" onclick="reset5[<?php echo $key ?>]()" id="btnrestart<?php echo $key ?>" disabled> <i class="fa fa-repeat"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-red btn-xs btn-flat" onclick="selesai5[<?php echo $key ?>]('<?php echo $l5['kode_item'] ?>', '<?php echo '5' ?>')" id="btnfinish5<?php echo $key ?>" disabled> <i class="fa fa-stop"></i> </button>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div> -->

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
