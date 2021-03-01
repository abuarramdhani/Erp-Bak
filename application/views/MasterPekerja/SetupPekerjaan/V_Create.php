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
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/SetupPekerjaan'); ?>"><span class="icon-wrench icon-2x"></span></a>
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
                                    <form class="form-horizontal" method="post" action="<?php echo site_url('MasterPekerja/SetupPekerjaan/create'); ?>">
                                        <div class="form-group">
                                            <label for="cmbDepartemen" class="control-label col-lg-2">Departemen</label>
                                            <div class="col-lg-4">
                                                <select name="cmbDepartemen" data-placeholder="Departement" class="select2 setupPekerjaan-cmbDepartemen" style="width: 100%" required="">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="cmbBidang" class="control-label col-lg-2">Bidang</label>
                                            <div class="col-lg-4">
                                                <select name="cmbBidang" data-placeholder="Bidang" class="select2 setupPekerjaan-cmbBidang" style="width: 100%" required>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="cmbUnit" class="control-label col-lg-2">Unit</label>
                                            <div class="col-lg-4">
                                                <select name="cmbUnit" data-placeholder="Unit" class="select2 setupPekerjaan-cmbUnit" style="width: 100%" required>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="cmbSeksi" class="control-label col-lg-2">Seksi</label>
                                            <div class="col-lg-4">
                                                <select name="cmbSeksi" data-placeholder="Seksi" class="select2 setupPekerjaan-cmbSeksi" style="width: 100%" required>
                                                </select>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label for="txtKodeUrut" class="col-lg-2 control-label">Kode Pekerjaan</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKodeUrut" class="form-control" id="txtKodeUrut" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="txtPekerjaan" class="col-lg-2 control-label">Pekerjaan</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="txtPekerjaan" class="form-control" id="txtPekerjaan" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtLearningPeriode" class="col-lg-2 control-label">Learning Periode</label>
                                            <div class="form-group">
                                                <div class="col-lg-2">
                                                    <input type="text" name="txtLearningPeriodelama" class="form-control" id="txtLearningPeriodelama" required>
                                                </div>

                                                <div class="col-lg-2">
                                                    <select class="select2" name="txtLearningPeriodejenis" id="txtLearningPeriodejenis" style="width: 100%">
                                                        <option value="H">Hari</option>
                                                        <option value="M">Minggu</option>
                                                        <option value="B">Bulan</option>
                                                    </select>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtJenisPekerjaan" class="col-lg-2 control-label">Jenis Pekerjaan</label>
                                            <div class="col-lg-6">
                                                <label style="padding-left: 0px;" class="radio-inline"><input type="radio" name="rd_labour" value="false"> Direct Labour</label>
                                                <label style="padding-left: 0px;" class="radio-inline"><input type="radio" name="rd_labour" checked="true" value="true"> Indirect Labour </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtJenisBaju" class="col-lg-2 control-label">Jenis Baju</label>
                                            <div class="col-lg-10">
                                                <label style="padding-left: 0px;" class="radio-inline"><input type="radio" name="rd_kancing" checked="true" value="Kancing Lengan Pendek"> Kancing Lengan Pendek</label>
                                                <label style="padding-left: 0px;" class="radio-inline"><input type="radio" name="rd_kancing" value="Kancing Lengan Panjang "> Kancing Lengan Panjang
                                                </label>
                                                <label style="padding-left: 0px;" class="radio-inline">
                                                    <input type="radio" name="rd_kancing" value="Kancing Rekat Panjang"> Kancing Rekat Panjang</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtJenisCelana" class="col-lg-2 control-label">Jenis Celana</label>
                                            <div class="col-lg-6">
                                                <label style="padding-left: 0px;" class="radio-inline"><input type="radio" name="rd_celana" checked="true" value="Celana Krem"> Celana Krem</label>
                                                <label style="padding-left: 0px;" class="radio-inline"><input type="radio" name="rd_celana" value="Celana Merah"> Celana Merah </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtJenisCelana" class="col-lg-2 control-label">Status</label>
                                            <div class="col-lg-6">
                                                <label style="padding-left: 0px;" class="radio-inline"><input type="radio" name="rd_status" checked="true" value="false"> Aktif</label>
                                                <label style="padding-left: 0px;" class="radio-inline"><input type="radio" name="rd_status" value="true"> Tidak Aktif </label>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <div class="col-lg-6 text-right">
                                                <a href="javascript:history.back(1);" class="btn btn-primary">Back</a>
                                                <button type="submit" class="btn btn-primary">Save </button>
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