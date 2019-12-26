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
                                <form action="<?php echo base_url('PolaShiftSeksi/TukarShift/saveTS') ?>" method="post">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-3">
                                                <label style="margin-top: 5px;">Tanggal</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control ts_datePick pss_dis_cht" name="tgl_tukar" placeholder="Masukan tanggal (dd-mm-yyyy)" />
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 10px;">
                                            <div class="col-md-3">
                                                <label style="margin-top: 5px;">Tukar dengan Pekerja lain ?</label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="col-md-5">
                                                    <input type="radio" class="form-control" name="tukarpekerja" value="ya" /> Ya
                                                </label>
                                                <label class="col-md-5">
                                                    <input checked type="radio" class="form-control pss_dis_ch" name="tukarpekerja" value="tidak" /> Tidak
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 10px;">
                                            <div class="col-md-3">
                                                <label style="margin-top: 5px;">Inisiatif Perusahaan ?</label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="col-md-5">
                                                    <input type="radio" class="form-control pss_set_range" name="inisiatif" value="perusahaan" /> Perusahaan
                                                </label>
                                                <label class="col-md-5">
                                                    <input checked type="radio" class="form-control pss_dis_ch pss_set_range" name="inisiatif" value="pribadi" /> Pribadi
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-center" style="margin-top: 20px;">
                                            <button type="button" class="btn btn-primary" id="btn_next_tukar">Next</button>
                                        </div>
                                        <div class="col-md-12 pss_formPekerja" style="margin-top: 50px;">
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
</section>
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif');?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>