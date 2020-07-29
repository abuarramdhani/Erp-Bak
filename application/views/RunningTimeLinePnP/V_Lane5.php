<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-6">
              <h4 style="font-weight:bold;"><i class="fa fa-cloud-upload"></i> Setting Job Lane 5</h4>
            </div>
            <div class="col-md-6">
              <div style="float:right">
                <a style="float:right;border:1.5px solid white;margin-left:10px;" href="<?php echo base_url('RunningTimeLinePnP/setting/history') ?>" class="btn btn-primary"><i class="fa fa-hourglass-3"></i> History</a>
                <form action="<?php echo base_url('RunningTimeLinePnP/lane5') ?>" method="post" style="display:inline">
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
            <div class="col-md-12" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
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
              <br>
              <div class="img-area-wipp">

              </div>
              <br>
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                <div class="row">
                  <div class="col-md-12">
                    <h4 style="font-weight:bold;">LINE 5 (<span style="color:#2284af" id="target_pe_line5"><?php !empty($line5[0]['target_pe_max'])?$l5 = $line5[0]['target_pe_max'] : $l5 = ''; echo $l5; ?></span><b>%</b>)</h4>
                  </div>
                </div>
                <br>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left line5wipp tblwiip10" style="font-size:11px;">
                    <thead>
                      <tr class="bg-info">
                        <th class="text-center">No</th>
												<th class="text-center">No Job</th>
												<th class="text-center">Kode</th>
												<th class="text-center">Nama Barang</th>
												<th class="text-center">QTY</th>
												<th class="text-center">Target PE</th>
												<th class="text-center">Ket</th>
												<th class="text-center">Waktu</th>
                      </tr>
                    </thead>
                    <tbody id="tambahisiwipp5" class="length5" data-length=<?php echo sizeof($line5) ?> >
                      <?php foreach ($line5 as $key => $l5): ?>
                        <?php
                        if ($l5['cek_time_record'] == 1) {
                          $style5 = 'style="background:rgba(0, 94, 255, 0.19)"';
                          $none5 = 'style="pointer-events: none;"';
                        }else {
                          $style5 = '';
                          $none5 = '';
                        }
                         ?>
                      <tr class="timer5" data-rtlp="<?php echo $l5['kode_item'] ?>_<?php echo $key+1 ?>">
                        <td class="text-center"><?php echo $key+1 ?></td>
                        <td class="text-center"><?php echo $l5['no_job'] ?></td>
                        <td class="text-center"><?php echo $l5['kode_item'] ?></td>
                        <td><center><?php echo $l5['nama_komponen'] ?></center></td>
                        <td><center><?php echo $l5['qty'] ?></center></td>
                        <td><center><?php echo round($l5['qty']*$l5['target_pe'], 3) ?></center></td>
                        <td><center>
                          <button type="button" style="margin-top: 29px;border-radius: 50px;" class="btn bg-maroon btn-xs btn-flat " onclick="detail_rtlp('<?php echo $l5['kode_item'] ?>', '<?php echo $key+1 ?>')" name="button"><i class="fa fa-eye"></i></button>
                        </center></td>
                        <td class="text-center" <?php echo $none5 ?>>
                          <p id="timer1">
                            <label id="hours5-<?php echo $key ?>">00</label>:<label id="minutes5-<?php echo $key ?>">00</label>:<label id="seconds5-<?php echo $key ?>">00</label>
                          </p>
                          <button style="border-radius: 50px" class="btn bg-primary btn-xs btn-flat" onclick="start5[<?php echo $key ?>]('<?php echo $l5['kode_item'] ?>', '<?php echo '5' ?>', '<?php echo $l5['no_job'] ?>')" id="btnstart5<?php echo $key ?>"> <i class="fa fa-play-circle"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-orange btn-xs btn-flat" onclick="pause5[<?php echo $key ?>]('<?php echo $l5['no_job'] ?>', '<?php echo $l5['kode_item'] ?>', '<?php echo $key ?>')" id="btnlanjut5<?php echo $key ?>" disabled> <i class="fa fa-pause"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-green btn-xs btn-flat" onclick="reset5[<?php echo $key ?>]('<?php echo $l5['no_job'] ?>')" id="btnrestart5<?php echo $key ?>" disabled> <i class="fa fa-repeat"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-red btn-xs btn-flat" onclick="selesai5[<?php echo $key ?>]('<?php echo $l5['kode_item'] ?>', '<?php echo '5' ?>', '<?php echo $l5['no_job'] ?>')" id="btnfinish5<?php echo $key ?>" disabled> <i class="fa fa-stop"></i> </button>
                        </td>
                        <input type="hidden" id="val_to_cek5<?php echo $key ?>" value="first_load">
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
