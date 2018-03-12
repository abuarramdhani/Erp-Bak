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
                                <h3 class="box-title">Parameter Proses Rekap Riwayat Mutasi</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <form method="post" action="<?php echo base_url('RekapTIMSPromosiPekerja/RiwayatMutasi');?>" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="radioJenisPencarian" class="control-label col-lg-2">Jenis Pencarian</label>
                                            <div class="col-lg-2">
                                                <input type="radio" name="radioJenisPencarian" value="noind" id="RekapRiwayatMutasi-radioJenisPencarian-noind">Nomor Induk</input>
                                            </div>
                                            <div class="col-lg-2">
                                                <input type="radio" name="radioJenisPencarian" value="seksi" id="RekapRiwayatMutasi-radioJenisPencarian-seksi">Seksi</input>
                                            </div>
                                            <div class="col-lg-2">
                                                <input type="radio" name="radioJenisPencarian" value="lokasikerja" id="RekapRiwayatMutasi-radioJenisPencarian-lokasikerja">Lokasi Kerja</input>
                                            </div>
                                        </div>
                                        <div id="RekapRiwayatMutasi-parameterNoind">
                                            <div class="form-group">
                                                <label for="RekapRiwayatMutasi-daftarNomorInduk" class="control-label col-lg-2">Nomor Induk</label>
                                                <select class="select2 col-lg-6" name="cmbNoind" id="RekapRiwayatMutasi-daftarNomorInduk" disabled="">
                                                </select>
                                            </div>
                                        </div>
                                        <div id="RekapRiwayatMutasi-parameterSeksi">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label col-lg-4">Departemen Lama</label>
                                                    <select class="select2 col-lg-6" name="cmbDepartemenLama" id="RekapRiwayatMutasi-cmbDepartemenLama" disabled="">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label col-lg-4">Bidang Lama</label>
                                                    <select class="select2 col-lg-6" name="cmbBidangLama" id="RekapRiwayatMutasi-cmbBidangLama" disabled="">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label col-lg-4">Unit Lama</label>
                                                    <select class="select2 col-lg-6" name="cmbUnitLama" id="RekapRiwayatMutasi-cmbUnitLama" disabled="">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label col-lg-4">Seksi Lama</label>
                                                    <select class="select2 col-lg-6" name="cmbSeksiLama" id="RekapRiwayatMutasi-cmbSeksiLama" disabled="">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label col-lg-4">Departemen Baru</label>
                                                    <select class="select2 col-lg-6" name="cmbDepartemenBaru" id="RekapRiwayatMutasi-cmbDepartemenBaru" disabled="">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label col-lg-4">Bidang Baru</label>
                                                    <select class="select2 col-lg-6" name="cmbBidangBaru" id="RekapRiwayatMutasi-cmbBidangBaru" disabled="">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label col-lg-4">Unit Baru</label>
                                                    <select class="select2 col-lg-6" name="cmbUnitBaru" id="RekapRiwayatMutasi-cmbUnitBaru" disabled="">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label col-lg-4">Seksi Baru</label>
                                                    <select class="select2 col-lg-6" name="cmbSeksiBaru" id="RekapRiwayatMutasi-cmbSeksiBaru" disabled="">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="RekapRiwayatMutasi-parameterLokasiKerja">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="RekapRiwayatMutasi-daftarLokasiKerjaLama" class="control-label col-lg-4">Lokasi Kerja</label>
                                                    <select class="select2 col-lg-6 RekapRiwayatMutasi-daftarLokasiKerja" name="cmbLokasiKerjaLama" id="RekapRiwayatMutasi-daftarLokasiKerjaLama" disabled="">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="RekapRiwayatMutasi-daftarLokasiKerjaBaru" class="control-label col-lg-4">Lokasi Kerja</label>
                                                    <select class="select2 col-lg-6 RekapRiwayatMutasi-daftarLokasiKerja" name="cmbLokasiKerjaBaru" id="RekapRiwayatMutasi-daftarLokasiKerjaBaru" disabled="">
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
                            if(isset($rekapRiwayatMutasi))
                            {
                        ?>
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Hasil Rekap Riwayat Mutasi</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-bordered" id="RekapRiwayatMutasi-hasil" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">No.</th>
                                                    <th style="text-align: center; vertical-align: middle;">Tanggal Berlaku</th>
                                                    <th style="text-align: center; vertical-align: middle;">Pekerja</th>
                                                    <th style="text-align: center; vertical-align: middle;">Seksi Asal</th>
                                                    <th style="text-align: center; vertical-align: middle;">Lokasi Kerja Asal</th>
                                                    <th style="text-align: center; vertical-align: middle;">Seksi Baru</th>
                                                    <th style="text-align: center; vertical-align: middle;">Lokasi Kerja Baru</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $no     =   1;
                                                    foreach ($rekapRiwayatMutasi as $hasil) 
                                                    {
                                                ?>
                                                <tr>
                                                     <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo $no;?></td>
                                                     <td style="white-space: nowrap; text-align: center; vertical-align: middle;"><?php echo $hasil['tglberlaku'];?></td>
                                                     <td style="white-space: nowrap; vertical-align: middle;"><?php echo $hasil['pekerja'];?></td>
                                                     <td style="white-space: nowrap; vertical-align: middle;"><?php echo $hasil['seksi_asal'];?></td>
                                                     <td style="white-space: nowrap; vertical-align: middle;"><?php echo $hasil['lokasi_kerja_asal'];?></td>
                                                     <td style="white-space: nowrap; vertical-align: middle;"><?php echo $hasil['seksi_baru'];?></td>
                                                     <td style="white-space: nowrap; vertical-align: middle;"><?php echo $hasil['lokasi_kerja_baru'];?></td>
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