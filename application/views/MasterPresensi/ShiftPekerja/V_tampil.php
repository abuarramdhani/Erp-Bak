<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?=$Title ?>
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a href="" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form action="<?= base_url('MasterPresensi/ShiftPekerja/UpdateJamIstirahat/tampil') ?>" class="form-horizontal" id="ShiftPekerja" method="post">
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Shift</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control select2" name="txtShift" id="txtShift">
                                                         <option></option>
                                                          <?php foreach ($shift as $k) { ?>
                                                          <option <?= ($k['kd_shift'] == '2')?'selected':''?> value="<?php echo $k['shift'] ?>"><?php echo $k['shift'] ?>
                                                          </option>
                                                          <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Tanggal</label>
                                                <div class="col-lg-4">
                                                    <input required type="text" name="txtTanggalShift" class="form-control MasterPekerja-daterangepickersingledate">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-8 text-right">
                                                <button type="submit" class="btn btn-primary"><span style="font-size: 16px;"></span>Tampil</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="row">
                                    <!-- kita tambahkan label bu bisa disini -->
                                    <div class="col-lg-12"><label>Tanggal : <?php echo date('d F Y', strtotime($tanggal)) ?></label></div>
                                    <div class="col-lg-12"><label>Shift   :          <?php echo $shiftpekerja; ?></label></div>
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table id="tbl_tampil" class="table table-striped table-bordered table-hovered" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Noind</th>
                                                    <th>Kd_Shift</th>
                                                    <th>Kodesie</th>
                                                    <th>Tukar</th>
                                                    <th>Jam_msk</th>
                                                    <th>Jam_akhmsk</th>
                                                    <th>Jam_plg</th>
                                                    <th>Break_mulai</th>
                                                    <th>Break_selesai</th>
                                                    <th>Ist_mulai</th>
                                                    <th>Ist_selesai</th>
                                                    <th>Jam_Kerja</th>
                                                    <th>User_</th>
                                                    <th>Noind_baru</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                    $no=1;
                                                    foreach ($data as $key) {
                                                        ?>
                                                                <tr>
                                                                    <td style="text-align: center;"><?php echo $no; ?></td>
                                                                    <td style="text-align: center;"><?php echo date('d-m-Y', strtotime($key['tanggal'])) ?></td>
                                                                    <td style="text-align: center;"><?php echo $key['noind']; ?></td>
                                                                    <td style="text-align: center;"><?php echo $key['kd_shift']; ?></td>
                                                                    <td style="text-align: center;"><?php echo $key['kodesie']; ?></td>
                                                                    <td style="text-align: center;"><?php echo $key['tukar']; ?></td>
                                                                    <td style="text-align: center;"><?php echo $key['jam_msk']; ?></td>
                                                                    <td style="text-align: center;"><?php echo $key['jam_akhmsk']; ?></td>
                                                                    <td style="text-align: center;"><?php echo $key['jam_plg']; ?></td>
                                                                    <td style="text-align: center;"><?php echo $key['break_mulai']; ?></td>
                                                                    <td style="text-align: center;"><?php echo $key['break_selesai']; ?></td>
                                                                    <td style="text-align: center;"><?php echo $key['ist_mulai']; ?></td>
                                                                    <td style="text-align: center;"><?php echo $key['ist_selesai']; ?></td>
                                                                    <td style="text-align: center;"><?php echo $key['jam_kerja']; ?></td>
                                                                    <td style="text-align: center;"><?php echo $key['user_']; ?></td>
                                                                    <td style="text-align: center;"><?php echo $key['noind_baru']; ?></td>
                                                                </tr>
                                                                <?php
                                                                $no++;

                                                        }
                                                        ?>

                                                        <?php
                                                    
                                            ?>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
 
            
             <?php if ($shiftpekerja == 'SHIFT 2') { ?>
 
                <div class="row">   
                     <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form action="<?php echo base_url('MasterPresensi/ShiftPekerja/UpdateJamIstirahat/update') ?>" class="form-horizontal" method="post">
                                        <input class="hiddenAllData" name='tanggalTampil' value="<?php echo date('d F Y', strtotime($tanggal)) ?>">
	                                    <input class="hiddenAllData" name="shiftTampil" value="<?php echo $shiftpekerja; ?>">
	                                    <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Istirahat Mulai</label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control spl-time-mask" name="txtIstirahatMulai" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Istirahat Selesai</label>
                                                <div class="col-lg-4">
                                                <input type="text" class="form-control spl-time-mask" name="txtIstirahatSelesai" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-8 text-right">
                                                <button target="_blank" type="submit" class="btn btn-primary"><span style="font-size: 16px;"></span>Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
  
             <?php } ?>

             <script type="text/javascript">
             	$(document).ready(function () {
             		$('.hiddenAllData').addClass('hide')
             		$('#tbl_tampil').DataTable();
             	})
             </script>
                </div>
            </div>
        </div>
    </div>
</section>

