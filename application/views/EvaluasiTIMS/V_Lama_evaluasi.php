<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Setup Lama Evaluasi</b></h1>
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
                                <form class="col-12" method="post" action="<?php echo site_url('EvaluasiTIMS/Setup/InputLamaEvaluasi');?>">
                                    <div class="panel-body">
                                       <div class="row">
                                        <div class="form-inline">
                                            <div style="font-weight: bold;" class="col-md-12 form-group">
                                                <label style="margin-top: 0px;" class="col-sm-2 col-form-label" for="name">OJT:</label>
                                                <div class="col-md-12">
                                                    <input style="width: 1.2em;" type="radio" class="form-control" name="et_rd_le" id="et_rd_1" value="1"> 1 Bulan
                                                </div>
                                                <div class="col-md-12">
                                                    <input style="width: 100px;" type="radio" class="form-control" name="et_rd_le" id="et_rd_2" value="2"> 2 Bulan
                                                </div>
                                                <div class="col-md-12">
                                                    <input style="width: 100px;" type="radio" class="form-control" name="et_rd_le" id="et_rd_3" value="3"> 3 Bulan
                                                </div>
                                            </div>
                                            <div style="font-weight: bold; margin-top: 50px;" class="col-md-12 form-group">
                                                <label style="margin-top: 0px;" class="col-sm-2 col-form-label" for="name">Non OJT:</label>
                                                <div class="col-md-12">
                                                    <input style="width: 1.2em;" type="radio" class="form-control" name="et_rd_le2" id="evt_rd_1" value="1"> 1 Bulan
                                                </div>
                                                <br>
                                                <div class="col-md-12">
                                                    <input style="width: 1.2em;" type="radio" class="form-control" name="et_rd_le2" id="evt_rd_2" value="2"> 2 Bulan
                                                </div>
                                                <br>
                                                <div class="col-md-12">
                                                    <input style="width: 100px;" type="radio" class="form-control" name="et_rd_le2" id="evt_rd_3" value="3"> 3 Bulan
                                                </div>
                                                <br>
                                                <div class="col-md-12">
                                                    <input style="width: 100px;" type="radio" class="form-control" name="et_rd_le2" id="evt_rd_4" value="4"> 4 Bulan
                                                </div>
                                                <br>
                                                <div class="col-md-12">
                                                    <input style="width: 100px;" type="radio" class="form-control" name="et_rd_le2" id="evt_rd_6" value="6"> 6 Bulan
                                                </div>
                                                <br>
                                                <div class="col-md-12">
                                                    <input style="width: 100px;" type="radio" class="form-control" name="et_rd_le2" id="evt_rd_12" value="12"> 12 Bulan
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="height: 50px;"></div>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <!-- <a href="<?php echo site_url('EvaluasiTIMS/Setup/LamaEvaluasi');?>" style="margin-right: 20px" class="btn btn-danger">Back</a>  -->
                                                <button type="submit" class="btn btn-success btn_et_el" disabled="">Simpan</button> 
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
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<script>
    $(document).ready(function(){
        var cek = '<?php echo $sesi[0]['lama_penilaian']; ?>';
        var cek2 = '<?php echo $sesi[1]['lama_penilaian']; ?>';
        // alert(cek);
        if (cek == '1') {
            $('#et_rd_1').iCheck('check');
        }else if (cek == '2') {
            $('#et_rd_2').iCheck('check');
        }else if (cek == '3') {
            $('#et_rd_3').iCheck('check');
        }
        if(cek2 == '1'){
            $('#evt_rd_1').iCheck('check');
        }else if (cek2 == '2') {
            $('#evt_rd_2').iCheck('check');
        }else if (cek2 == '3') {
            $('#evt_rd_3').iCheck('check');
        }else if (cek2 == '4') {
            $('#evt_rd_4').iCheck('check');
        }else if (cek2 == '6') {
            $('#evt_rd_6').iCheck('check');
        }else if (cek2 == '12') {
            $('#evt_rd_12').iCheck('check');
        }
    })
</script>