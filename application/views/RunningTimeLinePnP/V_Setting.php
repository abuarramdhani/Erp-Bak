<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-6">
              <h4 style="font-weight:bold;"><i class="fa fa-cloud-upload"></i> Setting Job Lane Lane 1 - 2</h4>
            </div>
            <div class="col-md-6">
              <div style="float:right">
                <a style="display:inline;float:right;border:1.5px solid white;margin-left:10px;" href="<?php echo base_url('RunningTimeLinePnP/setting/history') ?>" class="btn btn-primary"><i class="fa fa-hourglass-3"></i> History</a>
                <form action="<?php echo base_url('RunningTimeLinePnP/setting') ?>" method="post" style="display:inline">
                  <select class="select2 form-control" style="display:inline;float:right;margin-left:5px;" name="jenis" required>
                    <?php if ($jenis == 'R' || $jenis == '') {
                      echo ' <option value="R" selected>Reguler</option>
                             <option value="L">Lembur</option>';
                    }elseif ($jenis == 'L') {
                      echo ' <option value="R">Reguler</option>
                             <option value="L" selected>Lembur</option>';
                    }
                    ?>
                  </select>
                  <button type="submit" style="display:inline;float:right;background:white;color:black;border:1.5px solid white;margin-left:5px;" href="<?php echo base_url('RunningTimeLinePnP/setting/history') ?>" class="btn btn-primary"><i class="fa fa-legal"></i> Submit</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-12">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
                <!-- <input type="text" autocomplete="off" class="form-control txtWIIPdate" placeholder="..." style="width:100%;" name="" value=""> -->
                <!-- <div class="col-md-2">
                  <button type="button" style="width:100%;margin-top:25px" class="btn bg-maroon" onclick="setDate()" name="button"><i class="fa fa-gears"></i> Submit</button>
                </div> -->
                <div class="row">
                  <div class="col-md-6">
                    <label for="">Data Tanggal <?php echo date('Y-m-d'); ?> (<?php echo $jenis=='R'||$jenis==''?'Reguler':'Lembur' ?>)</label>
                  </div>
                  <div class="col-md-6">
                    <div style="margin-top:2px;float:right">
                      <div style="width: 20%;color:transparent; border:1px solid #5e5e5e;display:inline;background:#f4f4f4">______</div> <span style="display:inline"> : Job Belum Selesai</span>
                      <div style="width: 20%;color:transparent; margin-top: 5px;border:1px solid #5e5e5e; background:rgba(0, 94, 255, 0.19);display:inline;margin-left:5px;">______</div> <span style="display:inline"> : Job Sudah Selesai</span>
                    </div>
                  </div>
                </div>
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
                      <?php
                      if ($l1['cek_time_record'] == 1) {
                        $style = 'style="background:rgba(0, 94, 255, 0.19)"';
                        $none = 'style="pointer-events: none;"';
                      }else {
                        $style = '';
                        $none = '';
                      }
                       ?>
                      <tr class="rowbaru_wipp timer1" id="wipprow1" <?php echo $style ?> data-rtlp = "<?php echo $l1['kode_item'] ?>_<?php echo $key+1 ?>">
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
                        <td <?php echo $none ?>>
                          <center>
                          <p id="timer1">
                            <label id="hours1-<?php echo $key ?>">00</label>:<label id="minutes1-<?php echo $key ?>">00</label>:<label id="seconds1-<?php echo $key ?>">00</label>
                          </p>
                          <button style="border-radius: 50px" class="btn bg-primary btn-xs btn-flat" onclick="start1[<?php echo $key ?>]('<?php echo $l1['kode_item'] ?>', '<?php echo '1' ?>', '<?php echo $l1['no_job'] ?>', '<?php echo $key ?>')" id="btnstart1<?php echo $key ?>"> <i class="fa fa-play-circle"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-orange btn-xs btn-flat" onclick="pause1[<?php echo $key ?>]('<?php echo $l1['no_job'] ?>', '<?php echo $l1['kode_item'] ?>', '<?php echo $key ?>')" id="btnlanjut1<?php echo $key ?>" disabled> <i class="fa fa-pause"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-green btn-xs btn-flat" onclick="reset1[<?php echo $key ?>]()" id="btnrestart1<?php echo $key ?>" disabled> <i class="fa fa-repeat"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-red btn-xs btn-flat" onclick="selesai1[<?php echo $key ?>]('<?php echo $l1['kode_item'] ?>', '<?php echo '1' ?>', '<?php echo $l1['no_job'] ?>')" id="btnfinish1<?php echo $key ?>" disabled> <i class="fa fa-stop"></i> </button>
                          </center>
                          <input type="hidden" id="val_to_cek1<?php echo $key ?>" value="first_load">
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
                        <?php
                        if ($l2['cek_time_record'] == 1) {
                          $style2 = 'style="background:rgba(0, 94, 255, 0.19)"';
                          $none2 = 'style="pointer-events: none;"';
                        }else {
                          $style2 = '';
                          $none2 = '';
                        }
                         ?>
                      <tr class="rowbaru2_wipp timer2" <?php echo $style2 ?> id="wipp2row1" data-rtlp = "<?php echo $l2['kode_item'] ?>_<?php echo $key+1 ?>">
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
                        <td <?php echo $none2 ?>>
                          <center>
                          <p id="timer1">
                            <label id="hours2-<?php echo $key ?>">00</label>:<label id="minutes2-<?php echo $key ?>">00</label>:<label id="seconds2-<?php echo $key ?>">00</label>
                          </p>
                          <button style="border-radius: 50px" class="btn bg-primary btn-xs btn-flat" onclick="start2[<?php echo $key ?>]('<?php echo $l2['kode_item'] ?>', '<?php echo '2' ?>', '<?php echo $l2['no_job'] ?>')" id="btnstart2<?php echo $key ?>"> <i class="fa fa-play-circle"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-orange btn-xs btn-flat" onclick="pause2[<?php echo $key ?>]('<?php echo $l2['no_job'] ?>', '<?php echo $l2['kode_item'] ?>', '<?php echo $key ?>')" id="btnlanjut2<?php echo $key ?>" disabled> <i class="fa fa-pause"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-green btn-xs btn-flat" onclick="reset2[<?php echo $key ?>]()" id="btnrestart2<?php echo $key ?>" disabled> <i class="fa fa-repeat"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-red btn-xs btn-flat" onclick="selesai2[<?php echo $key ?>]('<?php echo $l2['kode_item'] ?>', '<?php echo '2' ?>', '<?php echo $l2['no_job'] ?>')" id="btnfinish2<?php echo $key ?>" disabled> <i class="fa fa-stop"></i> </button>
                          </center>
                        </td>
                        <input type="hidden" id="val_to_cek2<?php echo $key ?>" value="first_load">
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
