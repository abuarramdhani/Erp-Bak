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
                                    <form class="form-horizontal" method="post" action="<?php echo site_url('MasterPekerja/SetupPekerjaan/update/' . $id); ?>">
                                        <?php foreach ($editSetupPekerjaan as $edit) { ?>
                                            <div class="form-group">
                                                <label for="cmbDepartemen" class="control-label col-lg-2">Departemen</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="cmbDepartemen" class="form-control" id="cmbDepartemen" value="<?php echo $edit['dept']; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbBidang" class="control-label col-lg-2">Bidang</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="cmbBidang" class="form-control" id="cmbBidang" value="<?php echo $edit['bidang']; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbUnit" class="control-label col-lg-2">Unit</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="cmbUnit" class="form-control" id="cmbUnit" value="<?php echo $edit['unit']; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbSeksi" class="control-label col-lg-2">Seksi</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="cmbSeksi" class="form-control" id="cmbSeksi" value="<?php echo $edit['seksi']; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtKodeUrut" class="col-lg-2 control-label">Kode Pekerjaan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="txtKodeUrut" class="form-control" id="txtKodeUrut" value="<?php echo $edit['kdpekerjaan']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtPekerjaan" class="col-lg-2 control-label">Pekerjaan</label>
                                                <div class="col-lg-6">
                                                    <input type="text" name="txtPekerjaan" class="form-control" id="txtPekerjaan" value="<?php echo $edit['pekerjaan']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtLearningPeriodelama" class="col-lg-2 control-label">Learning Periode</label>
                                                <div class="form-group">
                                                    <div class="col-lg-2">
                                                        <input type="text" name="txtLearningPeriodelama" class="form-control" id="txtLearningPeriodelama" value="<?php echo $edit['learningperiode']; ?>">
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <select class="select2" name="txtLearningPeriodejenis" id="txtLearningPeriodejenis" style="width: 100%">
                                                            <?php
                                                            $wkt = array(
                                                                0 => array(
                                                                    'a' => 'H',
                                                                    'b' => 'Hari'
                                                                ),
                                                                1 => array(
                                                                    'a' => 'M',
                                                                    'b' => 'Minggu'
                                                                ),
                                                                2 => array(
                                                                    'a' => 'B',
                                                                    'b' => 'Bulan'
                                                                )
                                                            );

                                                            foreach ($wkt as $w) {
                                                                $slc = "";
                                                                if ($w['b'] == $edit['waktu']) {
                                                                    $slc = "selected";
                                                                }
                                                                echo "<option value='" . $w['a'] . "' $slc>" . $w['b'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtJenisPekerjaan" class="col-lg-2 control-label">Jenis Pekerjaan</label>
                                                <div class="col-lg-6">
                                                    <label style="padding-left: 0px;" class="radio-inline">
                                                        <input type="radio" name="rd_labour" <?php if ($edit['jenispekerjaan'] == 'f') {
                                                                                                    echo "checked";
                                                                                                } ?> value="false"> Direct Labour</label>
                                                    <label style="padding-left: 0px;" class="radio-inline"><input type="radio" name="rd_labour" <?php if ($edit['jenispekerjaan'] == 't') {
                                                                                                                                                    echo "checked";
                                                                                                                                                } ?> value="true"> Indirect Labour </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtJenisBaju" class="col-lg-2 control-label">Jenis Baju</label>
                                                <div class="col-lg-10">
                                                    <label style="padding-left: 0px;" class="radio-inline"><input type="radio" name="rd_kancing" <?php if ($edit['jenisbaju'] == 'Kancing Lengan Pendek') {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> value="Kancing Lengan Pendek"> Kancing Lengan Pendek</label>
                                                    <label style="padding-left: 0px;" class="radio-inline"><input type="radio" name="rd_kancing" <?php if ($edit['jenisbaju'] == 'Kancing Lengan Panjang') {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> value="Kancing Lengan Panjang "> Kancing Lengan Panjang
                                                    </label>
                                                    <label style="padding-left: 0px;" class="radio-inline">
                                                        <input type="radio" name="rd_kancing" <?php if ($edit['jenisbaju'] == 'Kancing Rekat Panjang') {
                                                                                                    echo "checked";
                                                                                                } ?> value="Kancing Rekat Panjang"> Kancing Rekat Panjang</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtJenisCelana" class="col-lg-2 control-label">Jenis Celana</label>
                                                <div class="col-lg-6">
                                                    <label style="padding-left: 0px;" class="radio-inline"><input type="radio" name="rd_celana" <?php if ($edit['jeniscelana'] == 'Celana Krem') {
                                                                                                                                                    echo "checked";
                                                                                                                                                } ?> value="Celana Krem"> Celana Krem</label>
                                                    <label style="padding-left: 0px;" class="radio-inline"><input type="radio" name="rd_celana" <?php if ($edit['jeniscelana'] == 'Celana Merah') {
                                                                                                                                                    echo "checked";
                                                                                                                                                } ?> value="Celana Merah"> Celana Merah </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtStatus" class="col-lg-2 control-label">Status</label>
                                                <div class="col-lg-6">
                                                    <label style="padding-left: 0px;" class="radio-inline"><input type="radio" name="rd_status" <?php if ($edit['status'] == 'f') {
                                                                                                                                                    echo "checked";
                                                                                                                                                } ?> value="false"> Aktif</label>
                                                    <label style="padding-left: 0px;" class="radio-inline"><input type="radio" name="rd_status" <?php if ($edit['status'] == 't') {
                                                                                                                                                    echo "checked";
                                                                                                                                                } ?> value="true"> Tidak Aktif </label>
                                                </div>
                                            </div>

                                        <?php } ?>
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