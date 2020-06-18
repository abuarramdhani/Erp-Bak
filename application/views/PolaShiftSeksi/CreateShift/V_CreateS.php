<style>
    label{
        margin-top: 5px;
    }
    .tenx{
        margin-top: 10px;
    }
    .nopad{
        padding-left: 0px;
    }
</style>
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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PolaShiftSeksi/ImportPolaShift');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <span ><br /></span>
                                </a>                             
                            </div>
                        </div>
                    </div>
                </div>
                <br />

                <div class="row pss_coba_document">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-1">
                                                <label>Periode</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input placeholder="Pilih Periode" class="form-control p2k3_tanggal_periode" id="ipscekdate">
                                            </div>
                                        </div>
                                        <div class="col-md-12 tenx">
                                            <div class="col-md-1">
                                                <label>Pekerja</label>
                                            </div>
                                            <div class="col-md-11">
                                                <select multiple="" required="" class="form-control pss_getAllnoindName" style="width: 100%">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="ips_weekshift" class="col-md-12" style="margin-top: 50px;"></div>
                                        <div id="ips_tblweekshift" class="col-md-12" style="margin-top: 50px;">
                                        <button id="pssbtnhpsbrs" style="float: right; display: none;" class="btn btn-danger">Hapus Baris</button>
                                            <table class="table table-bordered pss_tbl_slcDel" id="psstblsh">
                                                <thead>
                                                </thead>
                                            </table>
                                            <tbody class="test">

                                            </tbody>
                                        </div>
                                        <div id="pssdivsavehid" class="col-md-12" style="margin-top: 30px;" hidden="">
                                            <label for="txtKodesieBaru" class="col-md-2 control-label" style="margin-top: 5px; padding-left: 0px;">Pilih Atasan :</label>
                                            <div class="col-md-4">
                                                <select class="form-control ips_get_atasan" style="width: 100%">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                            <div class="col-md-1">
                                                <button disabled="" class="btn btn-success" id="btn_ips_save">Save Data</button>
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
    </div>
</section>
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif');?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>