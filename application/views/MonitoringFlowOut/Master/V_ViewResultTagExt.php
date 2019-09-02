<div class="box-header with-border">
    <b>Tagihan External</b>
</div>
<div class="box-body">
    <div class="panel-body">
        <div class="row">
            <div class="table-responsive">
                <table class="datatable table table-striped table-bordered table-hover" id="tCar">
                    <thead class="bg-primary">
                        <tr>
                            <th style="width:3%;">No</th>
                            <th style="width:9%">Tgl</th>
                            <th style="width:20%">Kode Komp</th>
                            <th style="width:20%">Nama Komp</th>
                            <th style="width:">Tipe</th>
                            <th style="width:">Possible Failure</th>
                            <th style="width:">Kronologi Masalah</th>
                            <th style="width:">Seksi PJ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($allTagihan as $key => $tagihanAll) { $tanggalnew = date('d-m-Y', strtotime($tagihanAll['tanggal'])) ?>
                        <tr>
                            <td style="text-align:center;"><?= $i++; ?></td>
                            <td><?= $tanggalnew ?></td>
                            <td><?= $tagihanAll['component_code_ext'] ?></td>
                            <td><?= $tagihanAll['component_name'] ?></td>
                            <td><?= $tagihanAll['type'] ?></td>
                            <td><?= $tagihanAll['possible_fail'] ?></td>
                            <td><?= $tagihanAll['kronologi_p'] ?></td>
                            <td><?= $tagihanAll['seksi_penanggungjawab'] ?></td>
                        </tr>
                        <?php
                                                }
                                                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>