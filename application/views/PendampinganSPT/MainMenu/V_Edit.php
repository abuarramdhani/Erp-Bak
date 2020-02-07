<!-- Custom Style -->
<style>
    label {
        font-weight: normal;
    }
    .form-group {
        margin-bottom: 3px !important;
    }    
    .input-group-addon > .fa {
        width: 15px;
    }
    .swal-font-small {
        font-size: 1.5rem !important;
    }
    .tooltip {
        position: fixed;
    }
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Data Pendampingan SPT <small> <span class="spnPSPTDate"></span></small></h1>
    <span class="hidden status spnPSPTStatus" status="<?= $this->session->status ?>"></span>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
                <div class="box box-primary container-fluid ">
                    <div class="box-header with-border text-center">
                        <h4><b>EDIT DATA PENDAFTAR PENDAMPINGAN SURAT PAJAK TAHUNAN</b></h3>
                        <h5>- PEKERJA CV. KARYA HIDUP SENTOSA YANG MEMILIKI NPWP -</h4>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-body">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><i class="fa fa-user"></i> Data Pendaftar</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="txtPSPTRegisterId" class="col-sm-3 control-label">No. Pendaftar</label>
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-list-ol"></i></span>
                                                    <input type="text" class="form-control" placeholder="Nomor Pendaftaran" id="txtPSPTRegisterId" value="<?= $RegisteredSPTDetail['nomor_pendaftaran'] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="txtPSPTWorkerName" class="col-sm-3 control-label">Nama</label>
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                    <input type="text" class="form-control" placeholder="Nama Pekerja" id="txtPSPTWorkerName" value="<?= $RegisteredSPTDetail['nama'] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="txtPSPTWorkerStats" class="col-sm-3 control-label">Status Pekerja</label>
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-signal"></i></span>
                                                    <input type="text" class="form-control" placeholder="Status Pekerja" id="txtPSPTWorkerStats" value="<?= $RegisteredSPTDetail['status_pekerja'] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="txtPSPTSection" class="col-sm-3 control-label">Seksi</label>
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                                    <input type="text" class="form-control" placeholder="Seksi Pekerja" id="txtPSPTSection" value="<?= $RegisteredSPTDetail['seksi'] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="txtPSPTWorkLocation" class="col-sm-3 control-label">Lokasi Kerja</label>
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                                    <input type="text" class="form-control" placeholder="Lokasi Kerja" id="txtPSPTWorkLocation" value="<?= $RegisteredSPTDetail['lokasi_kerja'] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="txtPSPTTRN" class="col-sm-3 control-label">NPWP</label>
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-list-ol"></i></span>
                                                    <input type="text" class="form-control" placeholder="Nomor Pokok Wajib Pajak" id="txtPSPTTRN" value="<?= $RegisteredSPTDetail['nomor_npwp'] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><i class="fa fa-edit"></i> Edit Data Pendaftar</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="txtPSPTSchedule" class="col-sm-3 control-label">Jadwal</label>
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                                    <input type="text" class="form-control" placeholder="Jadwal" id="txtPSPTSchedule" value="<?= $RegisteredSPTDetail['jadwal'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="txtPSPTRoom" class="col-sm-3 control-label">Ruangan</label>
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-institution"></i></span>
                                                    <input type="text" class="form-control" placeholder="Ruangan" id="txtPSPTRoom" value="<?= $RegisteredSPTDetail['lokasi'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="txtPSPTEFIN" class="col-sm-3 control-label">EFIN</label>
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-list-ol"></i></span>
                                                    <input type="text" class="form-control" placeholder="EFIN" id="txtPSPTEFIN" value="<?= $RegisteredSPTDetail['efin'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="txtPSPTEmail" class="col-sm-3 control-label">Email</label>
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa">@</i></span>
                                                    <input type="email" class="form-control" placeholder="Email" id="txtPSPTEmail" value="<?= $RegisteredSPTDetail['email'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>                               
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="txtPSPTReportDate" class="col-sm-3 control-label">Tanggal Lapor</label>
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-calendar-check-o "></i></span>
                                                    <input type="text" class="form-control" placeholder="Tanggal Lapor" id="txtPSPTReportDate" value="<?= $RegisteredSPTDetail['tanggal_lapor'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 hidden">
                                            <div class="form-group">
                                                <label for="txtPSPTRDataId" class="col-sm-3 control-label">Hidden Id</label>
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-calendar-check-o "></i></span>
                                                    <input type="hidden" id="txtPSPTHiddenId" value="<?= $RegisteredSPTDetail['id'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="button" class="btn btn-primary pull-right btnPSPTSaveEdit"><i class="fa fa-floppy-o"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /. box -->
            </form>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->