<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;display:inline;"><i class="fa fa-cloud-upload"></i> Setting Job Lane Lane 1 - 2</h4>
          <a style="display:inline;float:right;border:1.5px solid white;" href="<?php echo base_url('RunningTimeLinePnP/setting/history') ?>" class="btn btn-primary"><i class="fa fa-hourglass-3"></i> History</a>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-12">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
                  <label for="">Data Tanggal 2020-06-12 (Trial)</label>
                <!-- <input type="text" autocomplete="off" class="form-control txtWIIPdate" placeholder="..." style="width:100%;" name="" value=""> -->
                <!-- <div class="col-md-2">
                  <button type="button" style="width:100%;margin-top:25px" class="btn bg-maroon" onclick="setDate()" name="button"><i class="fa fa-gears"></i> Submit</button>
                </div> -->
              </div>
            </div>
            <div class="col-md-6" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
                <h4 style="font-weight:bold;">LINE 1 (<b style="color:#2284af" id="target_pe_line1"><?php !empty($line_1[0]['target_pe_max'])?$l1 = $line_1[0]['target_pe_max'] : $l1 = ''; echo $l1; ?></b><b>%</b>)</h4>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left line1wipp tblwiip10" style="font-size:11px;">
                    <thead>
                      <tr class="bg-info">
                        <th class="text-center">No</th>
												<th class="text-center">No Job</th>
												<th class="text-center">Kode</th>
												<th class="text-center">Nama Barang</th>
												<th class="text-center">QTY</th>
												<th class="text-center">Target PPIC</th>
												<th class="text-center">Ket</th>
												<th class="text-center">Waktu</th>
                      </tr>
                    </thead>
                    <tbody id="tambahisiwipp" class="length1">
                      <?php foreach ($line_1 as $key => $l1): ?>
                      <tr class="rowbaru_wipp timer1" id="wipprow1" data-rtlp = "<?php echo $l1['kode_item'] ?>_<?php echo $key+1 ?>">
                        <td>
                          <center><?php echo $key+1 ?></center>
                        </td>
                        <td><center><?php echo $l1['no_job'] ?></center></td>
                        <td><center><?php echo $l1['kode_item'] ?></center></td>
                        <td><center><?php echo $l1['nama_komponen'] ?></center></td>
                        <td><center><?php echo $l1['qty'] ?></center></td>
                        <td><center><?php echo round($l1['qty']*$l1['target_pe'], 3) ?>%</center></td>
                        <td><center>
                          <button type="button" style="margin-top: 29px;border-radius: 50px;" class="btn bg-maroon btn-xs btn-flat " onclick="detail_rtlp('<?php echo $l1['kode_item'] ?>', '<?php echo $key+1 ?>')" name="button"><i class="fa fa-eye"></i></button>
                        </center></td>
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

            <div class="col-md-6" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
                <div class="row">
                  <div class="col-md-12">
                    <h4 style="font-weight:bold;">LINE 2 (<b style="color:#2284af" id="target_pe_line2"><?php !empty($line_2[0]['target_pe_max'])?$l2 = $line_2[0]['target_pe_max'] : $l2 = ''; echo $l2; ?></b><b>%</b>)</h4>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left line2wipp tblwiip10" style="font-size:11px;">
                    <thead>
                      <tr class="bg-info">
                        <th class="text-center">No</th>
                        <th class="text-center">No Job</th>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Nama Barang</th>
                        <th class="text-center">QTY</th>
                        <th class="text-center">Target PPIC</th>
                        <th class="text-center">Ket</th>
                        <th class="text-center">Waktu</th>
                      </tr>
                    </thead>
                    <tbody id="tambahisiwipp2" class="length2" data-length=<?php echo sizeof($line_2) ?>>
                      <?php foreach ($line_2 as $key => $l2): ?>
                      <tr class="rowbaru2_wipp timer2" id="wipp2row1" data-rtlp = "<?php echo $l2['kode_item'] ?>_<?php echo $key+1 ?>">
                        <td>
                          <center><?php echo $key+1 ?></center>
                        </td>
                        <td><center><?php echo $l2['no_job'] ?></center></td>
                        <td><center><?php echo $l2['kode_item'] ?></center></td>
                        <td><center><?php echo $l2['nama_komponen'] ?></center></td>
                        <td class="text-center"><?php echo $l2['qty'] ?></td>
                        <td><center><?php echo round($l2['qty']*$l2['target_pe'], 3) ?>%</center></td>
                        <td><center>
                          <button type="button" style="margin-top: 29px;border-radius: 50px;" class="btn bg-maroon btn-xs btn-flat " onclick="detail_rtlp('<?php echo $l2['kode_item'] ?>', '<?php echo $key+1 ?>')" name="button"><i class="fa fa-eye"></i></button>
                        </center></td>
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

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
