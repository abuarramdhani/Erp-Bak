<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PolaShiftSeksi/TukarShift');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <span ><br /></span>
                                </a>                             
                            </div>
                        </div>
                    </div>
                </div>
                <br />

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                        <div class="col-md-12">
                            Create Tukar Shift
                        </div>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-3">
                                                <label style="margin-top: 5px;">Tanggal</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control" value="<?php echo substr($tukar[0]['tanggal1'], 0, 11) ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 10px;">
                                            <div class="col-md-3">
                                                <label style="margin-top: 5px;">Tukar dengan Pekerja lain ?</label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="col-md-5">
                                                    <input type="radio" class="form-control" <?= strlen(rtrim($tukar[0]['noind2'])) >= 5 ? 'checked':'disabled' ?>/> Ya
                                                </label>
                                                <label class="col-md-5">
                                                    <input type="radio" class="form-control" <?= strlen(rtrim($tukar[0]['noind2'])) < 5 ? 'checked':'disabled' ?> /> Tidak
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 10px;">
                                            <div class="col-md-3">
                                                <label style="margin-top: 5px;">Inisiatif Perusahaan ?</label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="col-md-5">
                                                    <input type="radio" class="form-control" <?= $tukar[0]['optperusahaan'] == 't' ? 'checked':'disabled' ?> /> Perusahaan
                                                </label>
                                                <label class="col-md-5">
                                                    <input  type="radio" class="form-control pss_dis_ch" <?= $tukar[0]['optpekerja'] == 't' ? 'checked':'disabled' ?>/> Pribadi
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 pss_formPekerja" style="margin-top: 50px;">
                                            <div class="col-md-6 pss_data_pkj" style="" id="pss_data_pkj_1">
                                                <div class="col-md-12 text-center" style="margin-top: 10px;">
                                                    <label>Pekerja 1</label>
                                                </div>
                                                <div class="col-md-12" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        <label style="margin-top: 5px;">Noind</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input disabled="" class="form-control" value="<?php echo $tukar[0]['noind1'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        <label style="margin-top: 5px;">Nama</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input class="form-control pss_nama" placeholder="Nama" readonly="" value="<?php echo $tukar[0]['nama1'] ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        <label style="margin-top: 5px;">Tanggal</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input class="form-control pss_tgl" placeholder="Tanggal" readonly="" value="<?php echo substr($tukar[0]['tanggal1'], 0, 11) ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        <label style="margin-top: 5px;">Shift</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input class="form-control pss_shift" readonly="" value="<?php echo $tukar[0]['shift1'] ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-center" style="margin-top: 10px; margin-bottom: 10px;">
                                                <?php if ($tukar[0]['status'] == '03'): ?>
                                                    <label style="color: red">Rejected by <?= $tukar[0]['reject_by'] ?></label>
                                                <?php else: ?>
                                                    <?php if (1==2): ?>
                                                        <button class="btn btn-success pss_app_now" level="1" isduo="<?php echo empty(rtrim($tukar[0]['noind2'])) ? 'y':'n'; ?>"><i class="fa fa-check"></i> Approve</button>
                                                        <button class="btn btn-danger pss_rej_now"><i class="fa fa-times"></i> Reject</button>
                                                    <?php else: ?>
                                                        <?php if (empty($tukar[0]['approve1_tgl'])): ?>
                                                            <label style="color: #7f7f7f">Menunggu Approval</label>
                                                        <?php else: ?>
                                                            <label style="color: #00a65a">Sudah di Approve</label>
                                                        <?php endif ?>
                                                    <?php endif ?>
                                                <?php endif ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pss_data_pkj" style="" id="pss_data_pkj_2">
                                                <div class="col-md-12 text-center" style="margin-top: 10px;">
                                                    <label>Pekerja 2</label>
                                                </div>
                                                <div class="col-md-12" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        <label style="margin-top: 5px;">Noind</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input class="form-control" disabled="" value="<?php echo strlen(rtrim($tukar[0]['noind2'])) >= 5 ? $tukar[0]['noind2']:$tukar[0]['noind1'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        <label style="margin-top: 5px;">Nama</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input class="form-control pss_nama" placeholder="Nama" readonly="" value="<?php echo strlen(rtrim($tukar[0]['noind2'])) >= 5 ? $tukar[0]['nama2']:$tukar[0]['nama1'] ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        <label style="margin-top: 5px;">Tanggal</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input class="form-control pss_tgl" placeholder="Tanggal" readonly="" value="<?php echo substr($tukar[0]['tanggal1'], 0, 11) ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        <label style="margin-top: 5px;">Shift</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input class="form-control pss_shift" placeholder="Shift" readonly="" value="<?php echo $tukar[0]['shift2'] ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-center" style="margin-top: 10px; margin-bottom: 10px;">
                                               <?php if ($tukar[0]['status'] == '03'): ?>
                                                    <label style="color: red">Rejected by <?= $tukar[0]['reject_by'] ?></label>
                                                <?php else: ?>
                                                    <?php if (1==2): ?>
                                                        <button class="btn btn-success pss_app_now" level="2"><i class="fa fa-check"></i> Approve</button>
                                                        <button class="btn btn-danger pss_rej_now"><i class="fa fa-times"></i> Reject</button>
                                                    <?php else: ?>
                                                        <?php if (empty($tukar[0]['approve2_tgl'])): ?>
                                                            <label style="color: #7f7f7f">Menunggu Approval</label>
                                                        <?php else: ?>
                                                            <label style="color: #00a65a">Sudah di Approve</label>
                                                        <?php endif ?>
                                                    <?php endif ?>
                                                <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-center" style="margin-top: 30px;">
                                        <label>
                                            <input style="width: 300px" class="form-control" readonly="" value="<?php echo $tukar[0]['appr_'].' - '.$tukar[0]['nama3'] ?>">
                                        </label>
                                        </div>
                                        <div class="col-md-12 text-center" style="margin-top: 10px; margin-bottom: 10px;">
                                        <?php if ($tukar[0]['status'] == '03'): ?>
                                            <label style="color: red">Rejected by <?= $tukar[0]['reject_by'] ?></label>
                                        <?php else: ?>
                                            <?php if (1==2): ?>
                                                <button class="btn btn-success pss_app_now" level="3"><i class="fa fa-check"></i> Approve</button>
                                                <button class="btn btn-danger pss_rej_now"><i class="fa fa-times"></i> Reject</button>
                                            <?php else: ?>
                                                <?php if (empty($tukar[0]['approval_timestamp'])): ?>
                                                    <label style="color: #7f7f7f">Menunggu Approval</label>
                                                <?php else: ?>
                                                    <label style="color: #00a65a">Sudah di Approve</label>
                                                <?php endif ?>
                                            <?php endif ?>
                                        <?php endif ?>
                                        </div>
                                        <div class="col-md-12 text-center" style="margin-top: 10px; margin-bottom: 10px;">
                                            <?php if (!empty($tukar[0]['alasan']) && $tukar[0]['status'] == '03'): ?>
                                                <label>Alasan Reject</label>
                                                <p><?= $tukar[0]['alasan'] ?></p>
                                            <?php endif ?>
                                        </div>
                                        <input hidden="" id="pss_tukar" value="<?php echo $tukar[0]['tukar_id'] ?>">
                                        <div class="col-md-12">
                                            <a href="<?php echo base_url('PolaShiftSeksi/TukarShift') ?>" class="btn btn-warning"><< Kembali</a>
                                        </div>
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
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif');?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>