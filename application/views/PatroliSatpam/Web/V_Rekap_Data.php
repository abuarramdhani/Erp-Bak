<style>
    .pts_tbl_rkp tbody tr td:nth-child(1),
    .pts_tbl_rkp tbody tr td:nth-child(3),
    .pts_tbl_rkp tbody tr td:nth-child(4),
    .pts_tbl_rkp tbody tr td:nth-child(9),
    .pts_tbl_rkp tbody tr td:nth-child(8)
    {
        text-align: center;
    }
    .dataTables_filter{
        float: right;
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b><?= $Title ?></b></h1>
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
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="col-md-3">
                                                <label style="margin-top: 5px;">Periode</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input class="form-control pts_daterange" name="periode" autocomplete="false" />
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 10px;">
                                            <div class="col-md-3">
                                                <label style="margin-top: 5px;">Pekerja</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-control pts_getPekerja" multiple="" name="pekerja">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12 text-right" style="margin-top: 10px; padding-right: 15px;">
                                                <button class="btn btn-primary" id="pts_btn_rdata">
                                                    Cari
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12" id="pts_tblrekapdata" style="overflow-x:scroll;">
                                        <table class="table table-bordered table-striped table-hover pts_tbl_rkp">
                                            <thead class="bg-primary">
                                                <th style="width: 0px;">No</th>
                                                <th style="width: 200px;">Noind</th>
                                                <th style="width: 0px;">Ronde</th>
                                                <th style="width: 0px;">Pos</th>
                                                <th>Tgl Shift</th>
                                                <th>Waktu Scan</th>
                                                <th>Lat, Long</th>
                                                <th>Jarak ke<br>titik scan(m)</th>
                                                <!-- <th>Action</th> -->
                                            </thead>
                                        </table>
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
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>