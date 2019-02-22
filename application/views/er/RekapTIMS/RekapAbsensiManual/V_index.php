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
                                <form method="post" action="<?php echo base_url('RekapTIMSPromosiPekerja/RekapAbsensiManual');?>" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="txtTanggalRekap" class="control-label col-lg-4">Tanggal Shift</label>
                                                <div class="col-lg-6">
                                                    <input type="text" name="txtTanggalRekap" class="RekapAbsensi-daterangepicker form-control" value="<?php if ( isset($tanggalRekap) ) {echo $tanggalRekap;}?>" />
                                                </div>
                                                <div class="col-lg-2"></div>
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
                            if(isset($rekapAbsensiManual))
                            {
                        ?>
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                                <table class="table table-bordered table-hover table-striped RekapAbsensiManual-Daftar">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">No.</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Tanggal Shift</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Nomor Induk</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Nama</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Departemen</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Bidang</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Unit</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Seksi</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Waktu Masuk</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Waktu Keluar</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Alasan</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Waktu Input</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">User Input</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Waktu Approve</th>
                                            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">User Approve</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no     =   1;
                                            foreach ($rekapAbsensiManual as $rekap)
                                            {
                                        ?>
                                        <tr>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $no;?>
                                            </td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $rekap['tanggal_shift'];?>
                                            </td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $rekap['noind'];?>
                                            </td>
                                            <td style="white-space: nowrap; vertical-align: middle;">
                                                <?php echo $rekap['nama'];?>
                                            </td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $rekap['dept'];?>
                                            </td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $rekap['bidang'];?>
                                            </td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $rekap['unit'];?>
                                            </td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $rekap['seksi'];?>
                                            </td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $rekap['masuk'];?>
                                            </td>
                                            <td style="white-space: nowrap; text-align: center; vertical-align: middle;">
                                                <?php echo $rekap['keluar'];?>
                                            </td>
                                            <td style="white-space: nowrap; vertical-align: middle;">
                                                <?php echo $rekap['alasan'];?>
                                            </td>
                                            <td style="white-space: nowrap; vertical-align: middle;">
                                                <?php echo $rekap['waktu_input'];?>
                                            </td>
                                            <td style="white-space: nowrap; vertical-align: middle;">
                                                <?php echo $rekap['user_input'];?>
                                            </td>
                                            <td style="white-space: nowrap; vertical-align: middle;">
                                                <?php echo $rekap['waktu_approve'];?>
                                            </td>
                                            <td style="white-space: nowrap; vertical-align: middle;">
                                                <?php echo $rekap['user_approve'];?>
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