<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;display:inline;"><i class="fa fa-cloud-upload"></i> Setting Job Lane 5</h4>
          <a style="display:inline;float:right;border:1.5px solid white;" href="<?php echo base_url('RunningTimeLinePnP/setting/history') ?>" class="btn btn-primary"><i class="fa fa-hourglass-3"></i> History</a>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-12" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
                  <label for="">Data Tanggal <?php echo date('Y-m-d'); ?></label>
                <!-- <input type="text" autocomplete="off" class="form-control txtWIIPdate" placeholder="..." style="width:100%;" name="" value=""> -->
                <!-- <div class="col-md-2">
                  <button type="button" style="width:100%;margin-top:25px" class="btn bg-maroon" onclick="setDate()" name="button"><i class="fa fa-gears"></i> Submit</button>
                </div> -->
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
                        <td class="text-center">
                          <p id="timer1">
                            <label id="hours5-<?php echo $key ?>">00</label>:<label id="minutes5-<?php echo $key ?>">00</label>:<label id="seconds5-<?php echo $key ?>">00</label>
                          </p>
                          <button style="border-radius: 50px" class="btn bg-primary btn-xs btn-flat" onclick="start5[<?php echo $key ?>]('<?php echo $l5['kode_item'] ?>', '<?php echo '5' ?>', '<?php echo $l5['no_job'] ?>')" id="btnstart5<?php echo $key ?>"> <i class="fa fa-play-circle"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-orange btn-xs btn-flat" onclick="pause5[<?php echo $key ?>]()" id="btnlanjut5<?php echo $key ?>" disabled> <i class="fa fa-pause"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-green btn-xs btn-flat" onclick="reset5[<?php echo $key ?>]()" id="btnrestart5<?php echo $key ?>" disabled> <i class="fa fa-repeat"></i> </button>
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
