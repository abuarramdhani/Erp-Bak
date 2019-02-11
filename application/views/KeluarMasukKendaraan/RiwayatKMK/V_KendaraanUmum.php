<section class="content">
    <div class="inner" >
    <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b>Kendaraan Dinas Luar</b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('KeluarMasukKendaraan/KendaraanDinas');?>">
                                    <i class="icon-desktop icon-2x"></i>
                                    <span ><br /></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Tabel Riwayat Keluar Masuk Kendaraan Dinas Luar
                            </div>
                            <div class="box-body">
                           <!--  <form method="post" action="<?php echo base_url('KeluarMasukKendaraan/KendaraanUmum'); ?>">
                            <div class="col-md-2">
                                <input type="text" class="form-control tgl-KMK" name="tgl-DL" value="<?php echo $tgl; ?>" />
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary"> GO </button>
                            </div>
                            </form> -->
                                <div class="table-responsive col-md-12" style="margin-top: 20px;">
                                    <table class="table table-striped table-bordered table-hover text-center" id="tbl_KMK">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th width="5%">No</th>
                                                <th width="10%">Tanggal</th>
                                                <th width="5%">Status</th>
                                                <th width="25%">Kendaraan</th>
                                                <th width="10%">Nomor Polisi</th>
                                                <th width="35%">Sopir</th>
                                                <th width="10%">Waktu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $no = 1;
                                         foreach ($RiwayatDL as $key) { ?>
                                            <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $key['tanggal']; ?></td>
                                            <?php if ($key['status_'] == '1') { ?>
                                                <td><i class="glyphicon glyphicon-arrow-down" style="color: blue;"></i></td>
                                            <?php }else{ ?>
                                                <td><i class="glyphicon glyphicon-arrow-up" style="color: red;"></i></td>
                                                <?php } ?>
                                                <td><?php echo $key['merk_kendaraan']; ?></td>
                                                <td><?php echo $key['nomor_polisi']; ?></td>
                                                <td><?php echo $key['employee_name']; ?></td>
                                                <td><?php echo $key['waktu']; ?></td>
                                            </tr>
                                        <?php $no++; } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
</section>