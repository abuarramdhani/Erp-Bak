<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Edit Nomor KDU</b></h1>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="text-right hidden-md hidden-sm hidden-xs">

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11"></div>
                        <div class="col-lg-1 "></div>
                    </div>
                </div>
                <br />
                <div class="">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <form class="col-12" action="<?php echo site_url('EvaluasiTIMS/Setup/SubmitKdu');?>" method="post">
                                    <div class="panel-body">
                                       <div class="row">
                                        <div class="form-inline">
                                            <div class="col-md-12 form-group">
                                                <label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="et_jenis_penilaian">Nomor KDU :</label>
                                                <input disabled="" value="<?php echo $kdu; ?>" style="text-transform: uppercase;" type="text" class="form-control" name="et_kdu" id="et_edit_kdu">
                                                <button type="button" class="btn btn-primary btn_edit_kdu" style="margin-left: 20px;">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="height: 50px;"></div>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <a onclick="window.history.go(-1); return false;" style="margin-right: 20px" class="btn btn-danger">Back</a> 
                                                <button disabled="" type="submit" class="btn btn-success btn_simpan_kdu">Simpan</button> 
                                            </div>
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