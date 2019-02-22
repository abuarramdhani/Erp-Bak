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
                                <form method="post" action="<?php echo base_url('RekapTIMSPromosiPekerja/SinkronisasiKonversiPresensi/');?>" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="SinkronisasiKonversiPresensi-txtTanggalSinkronisasi" class="control-label col-lg-4">Tanggal Shift Sinkronisasi</label>
                                                <div class="col-lg-6">
                                                    <input type="text" name="txtTanggalSinkronisasi" class="SinkronisasiKonversiPresensi-daterangepicker form-control" value="<?php if ( isset($tanggal_sinkronisasi) ) {echo $tanggal_sinkronisasi;}?>" required="" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="SinkronisasiKonversiPresensi-cmbKodeStatusKerja" class="control-label col-lg-4">Kode Status Kerja</label>
                                                <div class="col-lg-6">
                                                    <select class="select2 form-control" name="cmbKodeStatusKerja[]" id="SinkronisasiKonversiPresensi-cmbKodeStatusKerja" multiple="multiple">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="SinkronisasiKonversiPresensi-cmbNoind" class="control-label col-lg-4">Nomor Induk Pekerja</label>
                                                <div class="col-lg-6">
                                                    <select class="select2 form-control" name="cmbNoind[]" id="SinkronisasiKonversiPresensi-cmbNoind" multiple="multiple">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="SinkronisasiKonversiPresensi-cmbKodeShift" class="control-label col-lg-4">Kode Shift</label>
                                                <div class="col-lg-6">
                                                    <select class="select2 form-control" name="cmbKodeShift[]" id="SinkronisasiKonversiPresensi-cmbKodeShift" multiple="multiple">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="SinkronisasiKonversiPresensi-cmbKodesie" class="control-label col-lg-4">Kodesie</label>
                                                <div class="col-lg-6">
                                                    <select class="select2 form-control" name="cmbKodesie[]" id="SinkronisasiKonversiPresensi-cmbKodesie" multiple="multiple">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="SinkronisasiKonversiPresensi-cmbLokasiKerja" class="control-label col-lg-4">Lokasi Kerja</label>
                                                <div class="col-lg-6">
                                                    <select class="select2 form-control" name="cmbLokasiKerja[]" id="SinkronisasiKonversiPresensi-cmbLokasiKerja" multiple="multiple">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="SinkronisasiKonversiPresensi-cmbJabatan" class="control-label col-lg-4">Jabatan</label>
                                                <div class="col-lg-6">
                                                    <select class="select2 form-control" name="cmbJabatan[]" id="SinkronisasiKonversiPresensi-cmbJabatan" multiple="multiple">
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
                            if(isset($tabel_konversi_presensi))
                            {
                        ?>
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                                <table class="table table-bordered table-hover table-striped SinkronisasiKonversiPresensi-data">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">No.</th>
                                            <?php
                                                foreach ($table_columns as $columns)
                                                {
                                                    if ( array_key_exists($columns['column_name'], $tabel_konversi_presensi[0]) )
                                                    {
                                                    
                                            ?>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;"><?php echo $columns['column_name'];?></th>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no     =   1;
                                            foreach ($tabel_konversi_presensi as $hasil)
                                            {
                                        ?>
                                        <tr>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $no;?>
                                            </td>
                                            <?php
                                                
                                                foreach ($table_columns as $columns)
                                                {
                                                    if ( array_key_exists($columns['column_name'], $hasil) )
                                                    {
                                            ?>
                                            <td style="white-space: nowrap; vertical-align: middle;">
                                                <?php echo $hasil[$columns['column_name']];?>
                                            </td>
                                            <?php
                                                    }
                                                }
                                            ?>
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