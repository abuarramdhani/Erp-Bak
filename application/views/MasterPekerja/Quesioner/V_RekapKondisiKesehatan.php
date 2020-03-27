<section class="content">
    <div class="row">
        <div class="col-lg-12">
        <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title">Rekap Kondisi Kesehatan</h1>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover" id="tblRekapKondisiKesehatanMP" width="100%">
                        <thead>
                            <tr class="bg-primary">
                                <th>No</th>
                                <th>Department</th>
                                <th>Unit</th>
                                <th>Lokasi Kerja</th>
                                <th>bapil</th>
                                <th>bapilsak</th>
                                <th>hansak</th>
                                <th>sudah isi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=0; foreach ($rekap_kondisi_kesehatan as $key => $list) { $no++; ?>
                            <tr>
                                <td><?= $no;?></td>
                                <td><?= $list['dept'];?></td>
                                <td><?= $list['unit'];?></td>
                                <td><?= $list['lokasi_kerja'];?></td>
                                <td><?= $list['bapil'];?></td>
                                <td><?= $list['bapilsak'];?></td>
                                <td><?= $list['hansak'];?></td>
                                <td><?= $list['sudah_isi'];?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</section>