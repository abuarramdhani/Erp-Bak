<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11 text-right">
                    <h1>Monitoring List Database QTW</h1>
                </div>
                <div class="col-lg-1" style="margin-top: 10px;"><span class="fa fa-2x fa-database" style="color: red; position: absolute; margin-left: -10px; margin-top: 15px;"></span><span class="fa fa-3x fa-tv"></span></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-solid box-primary">
                            <div class="box-header with-border box-primary"><a href="<?= base_url('QuickWisata/DBQTW/create') ?>" class="btn fa fa-2x fa-plus" style="color: grey; background-color: white;"></a></div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table dataTable table-striped tabel-hover" id="tbl_monitoring_qtw">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Action</th>
                                                    <th>Tanggal</th>
                                                    <th>Waktu</th>
                                                    <th>Pemandu</th>
                                                    <th>Asal Instansi</th>
                                                    <th>PIC</th>
                                                    <th style="white-space: nowrap;">Jumlah Peserta</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1;
                                                foreach ($data as $key) {
                                                    $encrypted_string = $this->encrypt->encode($key['id_qtw']);
                                                    $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                                ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td>
                                                            <button class="btn btn-danger" onclick="deleteJadwalQTW('<?= $encrypted_string ?>')"><span class="fa fa-trash">&nbsp;Hapus</span></button>
                                                            <a class="btn btn-primary" href="<?= base_url('QuickWisata/DBQTW/editData?id=' . $encrypted_string) ?>"><span class="fa fa-pencil">&nbsp;Edit</span></a>
                                                        </td>
                                                        <td><?= date('d F Y', strtotime($key['tanggal'])) ?></td>
                                                        <td style="white-space: nowrap;"><?= date('H:i:s', strtotime($key['wkt_mulai'])) . ' - ' . date('H:i:s', strtotime($key['wkt_selesai'])) ?></td>
                                                        <td><?= $key['nama_pemandu'] ?></td>
                                                        <td><?= $key['dtl_institusi'] ?></td>
                                                        <td><?= $key['pic'] . '<br>' . $key['nohp_pic'] ?></td>
                                                        <td><?= $key['total_peserta'] ?></td>
                                                    </tr>
                                                <?php } ?>
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
    </div>
</section>