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
                        <div class="box box-primary <?php if(isset($rekapJamKerja)) {echo 'collapsed-box';};?> box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Parameter Proses Rekap Jam Kerja</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <form method="post" action="<?php echo base_url('RekapTIMSPromosiPekerja/RekapJamKerja');?>" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group text-center">
                                                    <label for="txtTanggalRekap" class="control-label col-lg-12">Tanggal Rekap</label>
                                                    <div class="col-lg-12">
                                                        <input type="text" name="txtTanggalRekap" class="RekapAbsensi-daterangepicker form-control" required="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group text-center">
                                                    <label for="cmbLokasiKerja" class="control-label col-lg-12">Lokasi Kerja</label>
                                                    <div class="col-lg-12">
                                                        <select name="cmbLokasiKerja" class="select2 RekapJamKerja-cmbLokasiKerja" style="width: 100%" required="">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group text-center">
                                                    <label for="chkDenganLembur" class="control-label col-lg-12">Dengan Lembur</label>
                                                    <div class="col-lg-12 text-center">
                                                        <input type="checkbox" name="chkDenganLembur" value="1" />
                                                    </div>
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
                            if(isset($rekapJamKerja))
                            {
                        ?>
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Hasil Rekap Jam Kerja</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <h5>Waktu eksekusi rekap : <b><?php echo $waktuEksekusiRekap;?></b> detik.</h5>
                                    </div>
                                    <div class="col-lg-12">
                                        <table class="table table-bordered" id="RekapJamKerja-hasil">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">No.</th>
                                                    <th style="text-align: center; vertical-align: middle;">Kodesie</th>
                                                    <th style="text-align: center; vertical-align: middle;">Departemen</th>
                                                    <th style="text-align: center; vertical-align: middle;">Bidang</th>
                                                    <th style="text-align: center; vertical-align: middle;">Unit</th>
                                                    <th style="text-align: center; vertical-align: middle;">Seksi</th>
                                                    <th style="text-align: center; vertical-align: middle;">A</th>
                                                    <th style="text-align: center; vertical-align: middle;">B</th>
                                                    <th style="text-align: center; vertical-align: middle;">C</th>
                                                    <th style="text-align: center; vertical-align: middle;">D</th>
                                                    <th style="text-align: center; vertical-align: middle;">E</th>
                                                    <th style="text-align: center; vertical-align: middle;">F</th>
                                                    <th style="text-align: center; vertical-align: middle;">G</th>
                                                    <th style="text-align: center; vertical-align: middle;">H</th>
                                                    <th style="text-align: center; vertical-align: middle;">J</th>
                                                    <th style="text-align: center; vertical-align: middle;">K/P</th>
                                                    <th style="text-align: center; vertical-align: middle;">Q</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $no     =   1;
                                                    foreach ($rekapJamKerja as $hasil) 
                                                    {
                                                ?>
                                                <tr>
                                                     <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo $no;?></td>
                                                     <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo $hasil['kode_seksi'];?></td>
                                                     <td style="white-space: nowrap; vertical-align: middle;"><?php echo $hasil['nama_departemen'];?></td>
                                                     <td style="white-space: nowrap; vertical-align: middle;"><?php echo $hasil['nama_bidang'];?></td>
                                                     <td style="white-space: nowrap; vertical-align: middle;"><?php echo $hasil['nama_unit'];?></td>
                                                     <td style="white-space: nowrap; vertical-align: middle;"><?php echo $hasil['nama_seksi'];?></td>
                                                     <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo round($hasil['A'], 3);?></td>
                                                     <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo round($hasil['B'], 3);?></td>
                                                     <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo round($hasil['C'], 3);?></td>
                                                     <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo round($hasil['D'], 3);?></td>
                                                     <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo round($hasil['E'], 3);?></td>
                                                     <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo round($hasil['F'], 3);?></td>
                                                     <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo round($hasil['G'], 3);?></td>
                                                     <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo round($hasil['H'], 3);?></td>
                                                     <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo round($hasil['J'], 3);?></td>
                                                     <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo round($hasil['K-P'], 3);?></td>
                                                     <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo round($hasil['Q'], 3);?></td>

                                                </tr>
                                                <?php
                                                        $no++;
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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