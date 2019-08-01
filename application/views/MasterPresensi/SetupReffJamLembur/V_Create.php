<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b><?=$Title ?></b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPresensi/SetupReffJamLembur'); ?>"><span class="icon-wrench icon-2x"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">

                            </div>
                            <div class="box-body">
                                <div class="col-lg-12">
                                    <form class="form-horizontal" method="post" action="<?php echo site_url('MasterPresensi/SetupReffJamLembur/create'); ?>">
                                        
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Keterangan</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtketerangan" class="form-control" id="ReffJamLemburKeterangan" placeholder="Keterangan" required>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="control-label col-lg-4">Jenis Hari</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtjenishari" class="form-control" id="ReffJamLemburJenisHari" placeholder="Jenis Hari" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Hari</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txthari" class="form-control" id="ReffJamLemburHari" placeholder="Hari" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Urutan</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txturutan" class="form-control" id="ReffJamLemburUrutan" placeholder="Urutan" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Jumlah Jam</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtjumlahjam" class="form-control" id="ReffJamLemburJumlahJam" placeholder="Jumlah Jam" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Pengali</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtpengali" class="form-control" id="ReffJamLemburPengali" placeholder="Pengali" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-8 text-right">
                                                <a href="javascript:history.back(1);" class="btn btn-primary">Back</a>
                                                <button type="submit" class="btn btn-primary">Submit</button>
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
