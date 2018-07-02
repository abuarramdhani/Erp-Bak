<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-11">
                        <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                    </div>
                    <div class="col-lg-1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                                <form method="post" action="<?php echo base_url('RekapTIMSPromosiPekerja/RekapDataPresensiTim');?>" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="RekapDataPresensiTIM-txtTanggalRekap" class="control-label col-lg-4">Tanggal Shift</label>
                                                <div class="col-lg-6">
                                                    <input type="text" name="txtTanggalRekap" class="RekapDataPresensiTIM-daterangepicker form-control" value="<?php if ( isset($tanggalRekap) ) {echo $tanggalRekap;}?>" required="" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="RekapDataPresensiTIM-cmbKeteranganPresensi" class="control-label col-lg-4">Keterangan Presensi</label>
                                                <div class="col-lg-6">
                                                    <select class="select2 form-control" name="cmbKeteranganPresensi[]" id="RekapDataPresensiTIM-cmbKeteranganPresensi" multiple="multiple">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="RekapDataPresensiTIM-cmbPekerja" class="control-label col-lg-4">Pekerja</label>
                                                <div class="col-lg-6">
                                                    <select class="select2 form-control" name="cmbPekerja[]" id="RekapDataPresensiTIM-cmbPekerja" multiple="multiple">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <button class="btn btn-info btn-lg" type="submit">
                                                Proses
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                            if(isset($rekap_data_presensi_tim))
                            {
                        ?>
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                                <table class="table table-bordered table-hover table-striped RekapDataPresensiTIM-Daftar">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">No.</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Tanggal Shift</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Pekerja</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Waktu Masuk</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Waktu Keluar</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Keterangan</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">User Input</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Waktu Input</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no     =   1;
                                            foreach ($rekap_data_presensi_tim as $rekap)
                                            {
                                        ?>
                                        <tr>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $no;?>
                                            </td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $rekap['tanggal'];?>
                                            </td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $rekap['noind'];?> - <?php echo $rekap['nama'];?>
                                            </td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $rekap['masuk'];?>
                                            </td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $rekap['keluar'];?>
                                            </td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $rekap['nama_keterangan'];?>
                                            </td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $rekap['create_user'];?>
                                            </td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php 
                                                    if ( !(empty($rekap['create_timestamp'])) )
                                                    {
                                                        echo date('Y-m-d', strtotime($rekap['create_timestamp']));
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                                $no++;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>