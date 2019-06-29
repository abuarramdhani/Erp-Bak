<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Setup Standar Penilaian</b></h1>
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
                                <form class="col-12" method="post" action="<?php echo site_url('EvaluasiTIMS/Setup/SubmitStandarPenilaian'); ?>">
                                    <div class="panel-body">
                                       <div class="row">
                                        <div class="form-inline">
                                            <div class="col-md-12 form-group">
                                                <label style="margin-top: 5px;" class="col-sm-2 col-form-label">Jenis Penilaian :</label>
                                                <select class="form-control et_select_jp" style="text-transform: uppercase;" name="et_select_jp">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Standar</label>
                                            </div>
                                            <div style="margin-top: 5px;" class="col-md-12 form-group">
                                                <label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">M :</label>
                                                <input style="width: 80px;" required="" type="number" class="form-control" name="et_input_t" id="et_input_t">
                                            </div>
                                            <div style="margin-top: 5px;" class="col-md-12 form-group">
                                                <label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">TIM :</label>
                                                <input style="width: 80px;" required="" type="number" class="form-control" name="et_input_tim" id="et_input_tim">
                                            </div>
                                            <div style="margin-top: 5px;" class="col-md-12 form-group">
                                                <label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">TIMS :</label>
                                                <input style="width: 80px;" required="" type="number" class="form-control" name="et_input_tims" id="et_input_tims">
                                            </div>
                                        </div>
                                    </div>
                                    <div style="height: 50px;"></div>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <!-- <a href="<?php echo site_url('EvaluasiTIMS/Setup/StandarPenilaian');?>" style="margin-right: 20px" class="btn btn-danger">Back</a>  -->
                                                <button class="btn btn-success">Simpan</button> 
                                            </div>
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
</section>