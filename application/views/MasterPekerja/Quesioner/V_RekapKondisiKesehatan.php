<section class="content">
    <div class="row">
        <div class="col-lg-12">
        <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title">Rekap Kondisi Kesehatan</h1>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover" id="tblRekapKondisiKesehatanMP" width="200%">
                        <thead>
                            <tr class="bg-primary">
                                <th class="bg-primary">No</th>
                                <th class="bg-primary">Departement</th>
                                <th class="bg-primary">Unit</th>
                                <th>Lokasi Kerja</th>
                                <th>Total Pekerja</th>
                                <th>Sudah Isi</th>
                                <th>Belum Isi</th>
                                <th>Batuk, Pilek, Sakit Tenggorokan, Demam</th>
                                <th>Batuk, Pilek, Sakit Tenggorokan, Demam + Sesak Nafas</th>
                                <th>Tidak Bisa Cium Bau / Tidak Dapat Merasakan Asin/Manis/Asam.</th>
                                <th>Tidak Masuk Tanpa SK</th>
                                <th>Tidak Masuk Dengan SK Batuk, Pilek, Sakit Tenggorokan, Demam</th>
                                <th>Tidak Masuk Dengan SK Batuk, Pilek, Sakit Tenggorokan, Demam + Sesak Nafas</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=0; foreach ($rekap_kondisi_kesehatan as $key => $list) { $no++; ?>
                            <tr>
                                <td><?= $no;?></td>
                                <td><?= $list['dept'];?></td>
                                <td><?= $list['unit'];?></td>
                                <td><?= $list['lokasi_kerja'];?></td>
                                <td><?= $list['total'];?></td>
                                <td><?= $list['sudah_isi'];?></td>
                                <td><?= $list['belum_isi'];?></td>
                                <td><?= $list['bapil'];?></td>
                                <td><?= $list['bapilsak'];?></td>
                                <td><?= $list['matira'];?></td>
                                <td><?= $list['nonsk'];?></td>
                                <td><?= $list['skbapil'];?></td>
                                <td><?= $list['skbapilsak'];?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</section>