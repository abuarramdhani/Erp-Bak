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
                                        <form action="<?= base_url('MasterPresensi/ShiftPekerja/UpdateJamIstirahat/tampil') ?>" class="form-horizontal" id="form_presensiH" method="post">
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
            </div>
        </div>
    </div>
</section>


