<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11  text-right">
                            <h1><b><?= $Title ?></b></h1>
                        </div>
                        <div class="col-lg-1 text-right hidden-md hiddem-sm hidden-xs">
                            <a href="<?php echo site_url('WasteManagement/LimbahKelola') ?>" class="btn btn-default btn-lg">
                                <span class="fa fa-wrench fa-2x" />
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">

                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <div style="float: right !important;">
                                        <span style="font-style: normal;">Lokasi Kerja:
                                            <select id="select-location" style="width: 339px; height:28px ; margin-right: 8px ; background-color: white; border: normal;">
                                                <?php
                                                if (!isset($_GET["location"])) {
                                                    $_GET["location"] = '';
                                                }
                                                ?>

                                                <option value="all" <?= ($_GET["location"] == 'all') ? 'selected' : '' ?>>Pilih Semua</option>
                                                <option value="yogyakarta" <?= ($_GET["location"] == 'yogyakarta') ? 'selected' : '' ?>>01 - YOGYAKARTA (PUSAT)</option>
                                                <option value="tuksono" <?= ($_GET["location"] == 'tuksono') ? 'selected' : '' ?>>02 - TUKSONO</option>
                                            </select>
                                            <button id='btn-search' class="btn btn-primary" style="width: 50px; height:27px ; padding: 3px !important;">Cari</button>
                                        </span>
                                    </div>
                                    <table class="datatable table table-striped table-bordered table-hover text-left dataTable-limbahKelola" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th>No</th>
                                                <th>Action</th>
                                                <th>Seksi Asal Limbah</th>
                                                <th style="display: none;">Lokasi Kerja</th>
                                                <th>Pekerja Pengirim</th>
                                                <th>Tanggal Kirim</th>
                                                <th>Waktu Kirim</th>
                                                <th>jenis Limbah</th>
                                                <th>Jumlah</th>
                                                <th>Berat (Kg)</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($Kiriman as $key) :
                                                $status = "";
                                                if ($key['status_kirim'] == "1") {
                                                    $status = "<span class='label label-success'>Approved</span>";
                                                } else if ($key['status_kirim'] == "2") {
                                                    $status = "<span class='label label-danger'>Rejected</span>";
                                                } else if ($key['status_kirim'] == "4") {
                                                    $status = "<span class='label label-warning'>Pending</span>";
                                                }

                                                $encrypted_string = $this->encrypt->encode($key['id_kirim']);
                                                $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                                $read     = base_url("WasteManagement/KirimanMasuk/Read/" . $encrypted_string);
                                                $delete = base_url("WasteManagement/KirimanMasuk/Delete/" . $encrypted_string);
                                                $pending = base_url("WasteManagement/KirimanMasuk/Pending/" . $encrypted_string);
                                            ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td>
                                                        <a href='<?= $read ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Lihat Data'>
                                                            <span class='fa fa-list-alt fa-2x' />
                                                        </a>
                                                        <a href='<?= $delete; ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Hapus Data' onclick='return confirm("Apakah Anda Yakin Ingin Menghapus data ini ?")'>
                                                            <span class='fa fa-trash fa-2x' />
                                                        </a>
                                                    </td>
                                                    <td><?= $key['seksi'] ?></td>
                                                    <td style="display: none;"><?= $key['noind_location'] ?></td>
                                                    <td><?= $key['pekerja'] ?></td>
                                                    <td><?= $key['tanggal'] ?></td>
                                                    <td><?= $key['waktu'] ?></td>
                                                    <td><?= $key['jenis_limbah'] ?></td>
                                                    <td><?= (!$key['id_satuan']) ? $key['jumlah'] : $key['jumlahall'] ?></td>
                                                    <td><?= $key['berat_kirim'] ?></td>
                                                    <td>
                                                        <?= $status; ?>
                                                        <?php if ($key['status_kirim'] == '3' || $key['status_kirim'] == '1') : ?>
                                                            <a href='<?= $pending; ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Ubah Status' onclick='return confirm("Apakah Anda Yakin Ingin Mengubah Status data ini menjadi pending ?")'>
                                                                <span class='icon-wrench icon-2x' />
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php
                                                $i++;
                                            endforeach;
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Action</th>
                                                <th>Seksi Asal Limbah</th>
                                                <th style="display: none;">Lokasi Kerja</th>
                                                <th>Pekerja Pengirim</th>
                                                <th>Tanggal Kirim</th>
                                                <th>Waktu Kirim</th>
                                                <th>jenis Limbah</th>
                                                <th>Jumlah</th>
                                                <th>Berat (Kg)</th>
                                                <th>Status</th>
                                            </tr>
                                        </tfoot>
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
<script type="text/javascript">
    $('#btn-search').off('click').click(function() {
        window.location.href = '<?= base_url('WasteManagement/KirimanMasuk?location=') ?>' + $('#select-location').val();
    });
</script>