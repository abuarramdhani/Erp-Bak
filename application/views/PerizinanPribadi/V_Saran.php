<div class="box box-primary box-solid">
    <div class="box-header with-border text-center">Rekap Kritik dan Saran Aplikasi Perizinan</div>
    <div class="box-body">
        <div id="ikp-ok">
            <table class="table table-striped table-bordered table-hover tabel_rekap" data-export-title="Rekap Pekerja Izin Keluar Pribadi" style="width: 100%">
                <thead>
                    <tr class="bg-primary">
                        <th class="text-center bg-primary" style="white-space: nowrap; width: 5%;">No</th>
                        <th class="text-center bg-primary" style="white-space: nowrap;">Tanggal</th>
                        <th class="text-center" style="white-space: nowrap;">Pekerja</th>
                        <th class="text-center" style="white-space: nowrap;">Saran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($data as $row) { ?>
                        <tr>
                            <td style="white-space: nowrap;"><?= $no; ?></td>
                            <td style="white-space: nowrap;"><?= date("d F Y", strtotime($row['created_date'])); ?></td>
                            <td style="white-space: nowrap;"><?= $row['noind'] ?></td>
                            <td style="white-space: nowrap;"><?= $row['saran'] ?></td>
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