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
                                        Periodical Maintenance
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="">
                                    <i aria-hidden="true" class="fa fa-refresh fa-2x">
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <!-- <center><b>Input Uraian Kerja</b></center> -->
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 5px">
                                        <!-- <div class="row text-right">
                                        <label style="font-size: 15px"><?php echo date("l, d F Y") ?></label>
                                    </div>
                                    <br> -->
                                        <div class="alert-warning" id="alert-message" style="margin-bottom: 5px"></div>
                                        <form action="#" method="post" id="formInputPME">
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-1">
                                                    <label>Lokasi</label>
                                                </div>
                                                <div class="col-md-4" style="text-align: center;">
                                                    <div class="form-group">
                                                        <!-- <select style="text-align: center" class="select2 form-control" id="lokasiPME" name="lokasi" data-placeholder="Lokasi" required="required"> </select> -->
                                                        <select class="select4 form-control" style="width: 100%" name="lokasi" id="lokasiPME" data-placeholder="Lokasi">
                                                            <option></option>
                                                            <?php foreach ($lokasi as $key => $value) { ?>
                                                                <option value="<?= $value['LOKASI'] ?>"><?= $value['LOKASI'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1" id="loadingLokasi"></div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-1">
                                                    <label>Lantai</label>
                                                </div>
                                                <div class="col-md-4" style="text-align: center;">
                                                    <div class="form-group">

                                                        <select class="form-control select2 lantai" disabled data-placeholder="Lantai" id="lantaiPME" name="lantai" required="required">

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1" id="loadingLantai"></div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-1">
                                                    <label>A r e a</label>
                                                </div>
                                                <div class="col-md-4" style="text-align: center;">
                                                    <div class="form-group">
                                                        <select class="form-control select2 area" disabled data-placeholder="Area" id="areaPME" name="area" required="required">

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1" id="loadingAreaPME"></div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-1">
                                                    <label>Mesin</label>
                                                </div>
                                                <div class="col-md-4" style="text-align: center;">
                                                    <div class="form-group">
                                                        <select class="form-control select2 mesin" disabled data-placeholder="Mesin" id="mesinPME" name="mesin" required="required">

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1" id="loadingMesin"></div>

                                            </div>

                                            <!-- <div class="row">
                                        <div class="col-md-4 " style="text-align: right;">
                                            <label>Nama Mesin</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="nama_mesin" id="nama_mesin" class="form-control" style="width: 100%" placeholder="Nama Mesin">
                                            </div>
                                        </div>
                                    </div> -->


                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-1">
                                                    <label>Kondisi</label>
                                                </div>
                                                <div class="col-md-4" style="text-align: center;">
                                                    <div class="form-group">
                                                        <select id="kondisi_mesin" name="kondisi_mesin" class="form-control select2" style="width: 100%" data-placeholder="Kondisi Mesin">
                                                            <!-- <option value="" disabled="" selected="">Pilih Sub Inventory</option> -->
                                                            <option></option>
                                                            <option>Mati</option>
                                                            <option>Beroperasi</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-1">
                                                    <label>Header</label>
                                                </div>
                                                <div class="col-md-4" style="text-align: center;">
                                                    <div class="form-group">
                                                        <input type="text" name="header" id="header" class="form-control" style="width: 100%;text-align: center;" placeholder="Header">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-1">
                                                    <label>Uraian</label>
                                                </div>
                                                <div class="col-md-4" style="text-align: center;">
                                                    <div class="form-group">
                                                        <input type="text" name="uraian_kerja" id="uraian_kerja" class="form-control" style="width: 100%;text-align: center;" placeholder="Uraian Kerja">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-1"> <label>Standar</label>
                                                </div>
                                                <div class="col-md-4" style="text-align: center;">
                                                    <div class="form-group">
                                                        <input type="text" name="standar" id="standar" class="form-control" style="width: 100%;text-align: center;" placeholder="Standar">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-1"> <label>Periode</label>
                                                </div>
                                                <div class="col-md-4" style="text-align: center;">
                                                    <div class="form-group">
                                                        <select id="periode" name="periode" class="form-control select2" style="width: 100%" data-placeholder="Periode">
                                                            <!-- <option value="" disabled="" selected="">Pilih Sub Inventory</option> -->
                                                            <option></option>
                                                            <option>2 Mingguan</option>
                                                            <option>Tahunan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                    </div>
                                </div>
                            </div>
                            </form>

                            <!-- <div class="panel panel-body"> -->
                            <div class="panel-body">
                                <div class="col-md-6 text-right">
                                    <button id="btnResetPME" class="btn btn-danger"><i class="fa fa-refresh"></i><b> Reset</b></button>
                                    <!-- <input type="button" id="btnreset" class="btn btn-danger" value="reset" /> -->
                                </div>
                                <!-- </div> -->
                                <div class="col-md-4">
                                    <a style="width:80px" href="javascript:void(0);" id="addRowPeriodicalMaintenance" onclick="addRowPeriodicalMaintenance()" class="btn btn-success" title="Insert Table"><i class="fa fa-plus"></i><b> Add </b></a>
                                </div>

                            </div>
                            <form name="Orderform" class="form-horizontal" onsubmit="return validasi();window.location.reload();" action="<?php echo base_url('PeriodicalMaintenance/Input/Insert'); ?>" method="post">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover text-center" style="table-layout: auto;" name="tblPeriodicalMaintenance" id="tblPeriodicalMaintenance">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th>Nama Mesin</th>
                                                    <th>Kondisi Mesin</th>
                                                    <th>Header</th>
                                                    <th>Uraian Kerja</th>
                                                    <th>Standar</th>
                                                    <th>Periode</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbodyPreviousMPE" style="display:none;">

                                            </tbody>
                                            <tbody id="tbodyPeriodicalMaintenance">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="panel-footer">
                                    <div class="row text-right" style="padding-right: 10px">
                                        <button type="submit" title="Insert to Oracle" class="btn btn-success"><b>Insert</b></button>
                                    </div>
                                </div>

                            </form>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- <script type="text/javascript">
    
    $(document).ready(function(){
    $("#btnreset").click(function(){
    /* Single line Reset function executes on click of Reset Button */
    // $("#form")[0].reset();
    $('.select2').val('').trigger("change");
    document.getElementById('nama_mesin').value=''; 
    // document.getElementById('kondisi_mesin').value=''; 
    document.getElementById('header').value=''; 
    document.getElementById('uraian_kerja').value=''; 
    document.getElementById('standar').value=''; 
    // document.getElementById('periode').value=''; 
    });
});

</script> -->