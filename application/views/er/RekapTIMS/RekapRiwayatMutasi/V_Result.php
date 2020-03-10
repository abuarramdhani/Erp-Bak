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
                            <th style="text-align: center; vertical-align: middle;">No Induk</th>
                            <th style="text-align: center; vertical-align: middle;">Nama</th>
                            <th style="text-align: center; vertical-align: middle;">No BPJS Kesehatan</th>
                            <th style="text-align: center; vertical-align: middle;">No BPJS Ketenagakerjaan</th>
                            <th style="text-align: center; vertical-align: middle;">NIK</th>
                            <th style="text-align: center; vertical-align: middle;">Tgl Lahir</th>
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
                             <td style="white-space: nowrap; vertical-align: middle;"><?php echo $hasil['noind'];?></td>
                             <td style="white-space: nowrap; vertical-align: middle;"><?php echo $hasil['nama'];?></td>
                             <td style="white-space: nowrap; vertical-align: middle;"><?php echo $hasil['bpjskes'];?></td>
                             <td style="white-space: nowrap; vertical-align: middle;"><?php echo $hasil['bpjstk'];?></td>
                             <td style="white-space: nowrap; vertical-align: middle;"><?php echo $hasil['nik'];?></td>
                             <td style="white-space: nowrap; vertical-align: middle;"><?php echo date('d-m-Y', strtotime($hasil['lahir']));?></td>
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
