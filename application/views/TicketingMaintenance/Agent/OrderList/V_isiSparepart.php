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
                        <!---->
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
                                <b style="margin-right:700px; margin-left:50px;"><?= 'No Order : '.$id[0]['no_order']?></b>
                                <b>Input Form Sparepart</b>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                <form autocomplete="off" action="<?= base_url('TicketingMaintenance/Agent/OrderList/saveSparepart/'.$id[0]['no_order']); ?>" method="post">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-7"><br>
                                        <input type="radio" name="terdaftar" value="Terdaftar" checked> <label for="norm" class="control-label">&nbsp;&nbsp;Terdaftar </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									    <input type="radio" name="terdaftar" value="TidakTerdaftar"><label for="norm" class="control-label">&nbsp;&nbsp; Tidak Terdaftar </label><br>
                                            <input type="hidden" name="no_order" value="<?= $id[0]['no_order'] ?>"> <br />
                                            <div class="form-group terdaftar">
                                                <label for="nm_spr" class="control-label">Nama Spare Part</label>
                                                <!-- <input type="text" name="nm_spr" id="sparepartAgent" class="form-control" placeholder="Nama Sparepart" required> -->
                                                <select style="height: 35px;" class="form-control select2 sparepart" id="sparepartAgent" name="nm_spr" data-placeholder="Nama Sparepart" tabindex="-1" aria-hidden="true">
												</select>
                                            </div>
                                            <div class="form-group tdkTerdaftar" style="display:none">
                                                <label for="nm_spr" class="control-label">Nama Spare Part</label>
                                                <input type="text" name="nm_sprT" id="sparepartAgentT" class="form-control" placeholder="Nama Sparepart">
                                            </div>
                                            <div class="form-group">
                                                <label for="spek_spr" class="control-label">Spesifikasi</label>
                                                <input type="text" name="spek_spr" class="form-control" placeholder="Spesifikasi" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="jml_spr" class="control-label">Jumlah</label>
                                                <input type="text" name="jml_spr" class="form-control" placeholder="Jumlah" required>
                                            </div>
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>