<input type="hidden" id="cek_rtlp" value="okok">
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-6">
              <h4 style="font-weight:bold;"><i class="fa fa-cloud-upload"></i> Setting Job Lane Lane 3 - 4</h4>
            </div>
            <div class="col-md-6">
              <div style="float:right">
                <a style="float:right;border:1.5px solid white;margin-left:10px;" href="<?php echo base_url('RunningTimeLinePnP/setting/history') ?>" class="btn btn-primary"><i class="fa fa-hourglass-3"></i> History</a>
                <form action="<?php echo base_url('RunningTimeLinePnP/setting34') ?>" method="post" style="display:inline">
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
                <div class="row">
                  <div class="col-md-12">
                    <h4 style="font-weight:bold;background: #abbf2d;color: white;padding: 10px;border-radius: 7px;">LINE 3 (<b style="color:#fff" id="target_pe_line3"><?php !empty($line_3[0]['target_pe_max'])?$l3 = $line_3[0]['target_pe_max'] : $l3 = ''; echo $l3; ?></b><b>%</b>)</h4>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left line3wipp tblwiip10" style="font-size:11px;">
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
                    <tbody id="tambahisiwipp3" class="length3" data-length=<?php echo sizeof($line_3) ?> >
                      <?php foreach ($line_3 as $key => $l3): ?>
                        <?php
                        if ($l3['cek_time_record'] == 1) {
                          $style3 = 'style="background:rgba(0, 94, 255, 0.19)"';
                          $none3 = 'style="pointer-events: none;"';
                        }else {
                          $style3 = '';
                          $none3 = '';
                        }
                         ?>
                      <tr class="timer3" <?php echo $style3 ?> data-rtlp = "<?php echo $l3['kode_item'] ?>_<?php echo $key+1 ?>">
												<td class="text-center"><?php echo $key+1 ?></td>
												<td class="text-center"><?php echo $l3['no_job'] ?></td>
												<td class="text-center"><?php echo $l3['kode_item'] ?></td>
                        <td><center><?php echo $l3['nama_komponen'] ?></center></td>
                        <td class="text-center"><?php echo $l3['qty'] ?></td>
                        <td><center><?php echo round($l3['qty']*$l3['target_pe'], 3) ?>%</center></td>
                        <td><center>
                          <button type="button" style="margin-top: 29px;border-radius: 50px;" class="btn bg-maroon btn-xs btn-flat " onclick="detail_rtlp('<?php echo $l3['kode_item'] ?>', '<?php echo $key+1 ?>')" name="button"><i class="fa fa-eye"></i></button>
                        </center></td>
												<td class="text-center" <?php echo $none3 ?>>
													<p id="timer1">
														<label id="hours3-<?php echo $key ?>">00</label>:<label id="minutes3-<?php echo $key ?>">00</label>:<label id="seconds3-<?php echo $key ?>">00</label>
													</p>
                          <input type="hidden" class="time_start_3" value="<?php echo $l3['start3']['Start'] ?>">
													<button style="border-radius: 50px" class="btn bg-primary btn-xs btn-flat" onclick="start3[<?php echo $key ?>]('<?php echo $l3['kode_item'] ?>', '<?php echo '3' ?>', '<?php echo $l3['no_job'] ?>')" id="btnstart3<?php echo $key ?>"> <i class="fa fa-play-circle"></i> </button>
													<button style="border-radius: 50px" class="btn bg-orange btn-xs btn-flat" onclick="pause3[<?php echo $key ?>]('<?php echo $l3['no_job'] ?>', '<?php echo $l3['kode_item'] ?>', '<?php echo $key ?>')" id="btnlanjut3<?php echo $key ?>" disabled> <i class="fa fa-pause"></i> </button>
													<button style="border-radius: 50px" class="btn bg-green btn-xs btn-flat" onclick="reset3[<?php echo $key ?>]('<?php echo $l3['no_job'] ?>')" id="btnrestart3<?php echo $key ?>" disabled> <i class="fa fa-repeat"></i> </button>
													<button style="border-radius: 50px" class="btn bg-red btn-xs btn-flat" onclick="selesai3[<?php echo $key ?>]('<?php echo $l3['kode_item'] ?>', '<?php echo '3' ?>', '<?php echo $l3['no_job'] ?>')" id="btnfinish3<?php echo $key ?>" disabled> <i class="fa fa-stop"></i> </button>
												</td>
                        <input type="hidden" id="val_to_cek3<?php echo $key ?>" value="first_load">
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
                    <h4 style="font-weight:bold;background: #d43434;color: white;padding: 10px;border-radius: 7px;">LINE 4 (<span style="color:#fff" id="target_pe_line4"><?php !empty($line_4[0]['target_pe_max'])?$l4 = $line_4[0]['target_pe_max'] : $l4 = ''; echo $l4; ?></span><b>%</b>)</h4>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left line4wipp tblwiip10" style="font-size:11px;">
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
                    <tbody id="tambahisiwipp4" class="length4" data-length=<?php echo sizeof($line_4) ?> >
                      <?php foreach ($line_4 as $key => $l4): ?>
                        <?php
                        if ($l4['cek_time_record'] == 1) {
                          $style4 = 'style="background:rgba(0, 94, 255, 0.19)"';
                          $none4 = 'style="pointer-events: none;"';
                        }else {
                          $style4 = '';
                          $none4 = '';
                        }
                         ?>
                      <tr class="timer4" <?php echo $style4 ?> data-rtlp="<?php echo $l4['kode_item'] ?>_<?php echo $key+1 ?>">
                        <td class="text-center"><?php echo $key+1 ?></td>
                        <td class="text-center"><?php echo $l4['no_job'] ?></td>
                        <td class="text-center"><?php echo $l4['kode_item'] ?></td>
                        <td><center><?php echo $l4['nama_komponen'] ?></center></td>
                        <td class="text-center"><?php echo $l4['qty'] ?></td>
                        <td><center><?php echo round($l4['qty']*$l4['target_pe'], 3) ?>%</center></td>
                        <td><center>
                          <button type="button" style="margin-top: 29px;border-radius: 50px;" class="btn bg-maroon btn-xs btn-flat " onclick="detail_rtlp('<?php echo $l4['kode_item'] ?>', '<?php echo $key+1 ?>')" name="button"><i class="fa fa-eye"></i></button>
                        </center></td>
                        <td class="text-center" <?php echo $none4 ?>>
                          <p id="timer1">
                            <label id="hours4-<?php echo $key ?>">00</label>:<label id="minutes4-<?php echo $key ?>">00</label>:<label id="seconds4-<?php echo $key ?>">00</label>
                          </p>
                          <input type="hidden" class="time_start_4" value="<?php echo $l4['start4']['Start'] ?>">
                          <button style="border-radius: 50px" class="btn bg-primary btn-xs btn-flat" onclick="start4[<?php echo $key ?>]('<?php echo $l4['kode_item'] ?>', '<?php echo '4' ?>', '<?php echo $l4['no_job'] ?>')" id="btnstart4<?php echo $key ?>"> <i class="fa fa-play-circle"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-orange btn-xs btn-flat" onclick="pause4[<?php echo $key ?>]('<?php echo $l4['no_job'] ?>', '<?php echo $l4['kode_item'] ?>', '<?php echo $key ?>')" id="btnlanjut4<?php echo $key ?>" disabled> <i class="fa fa-pause"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-green btn-xs btn-flat" onclick="reset4[<?php echo $key ?>]('<?php echo $l4['no_job'] ?>')" id="btnrestart4<?php echo $key ?>" disabled> <i class="fa fa-repeat"></i> </button>
                          <button style="border-radius: 50px" class="btn bg-red btn-xs btn-flat" onclick="selesai4[<?php echo $key ?>]('<?php echo $l4['kode_item'] ?>', '<?php echo '4' ?>', '<?php echo $l4['no_job'] ?>')" id="btnfinish4<?php echo $key ?>" disabled> <i class="fa fa-stop"></i> </button>
                        </td>
                        <input type="hidden" id="val_to_cek4<?php echo $key ?>" value="first_load">
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
