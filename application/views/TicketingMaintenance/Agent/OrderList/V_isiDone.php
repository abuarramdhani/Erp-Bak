<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b><?= $Title ?></b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?= base_url('TicketingMaintenance/Agent/OrderList/detail/'.$id[0]['no_order']); ?>">
                                    <i class="fa fa-ticket fa-2x"></i>
                                    <br />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="col-lg-12">
                    <div class="row">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <b>Input Form Reparasi</b>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                <form autocomplete="off" action="<?= base_url('TicketingMaintenance/Agent/OrderList/saveReparasi/'.$id[0]['no_order']); ?>" method="post">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-7">
                                            <input type="hidden" name="no_order" value="<?= $id[0]['no_order'] ?>"> <br />
                                            <div class="form-group">
                                                <label for="waktu_mulai" class="control-label">Pelaksana</label>
                                                <!-- <input type="text" name="pelaksana" class="form-control time-form" id="pelaksanaReparasi" placeholder="Input Pelaksana Reparasi" required> -->
                                                <select class="form-control select2" id="pelaksanaReparasi" name="pelaksana[]" data-placeholder="Input Pelaksana Reparasi" required multiple></select>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="waktu_mulai" class="control-label">Tanggal</label>
                                                <input type="text" name="tanggal" class="form-control time-form1 ajaxOnChange" placeholder="Input Tanggal" required>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="waktu_mulai" class="control-label">Jam</label>
                                                <input type="time" name="jamMulai" class="form-control jamMulai" id="txtJamMulai" placeholder="23:59:59" required>
                                            </div> <br />
                                            <!-- <div class="form-group">
                                                <label for="waktu_selesai" class="control-label">Keterangan</label>
                                                <input type="text" name="keteranganReparasi" class="form-control keterangan" id="txtketerangan" placeholder="Input Keterangan" required>
                                            </div> <br /> -->
                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="row text-right" style="margin:1px;">
                                        <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i></i>  Save</button>
                                        <a href="<?php echo site_url('TicketingMaintenance/Agent/OrderList/detail/'.$id[0]['no_order']); ?>" class="btn btn-danger btn-lg"><i class="fa fa-arrow-left"></i></i>  Back</a>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>