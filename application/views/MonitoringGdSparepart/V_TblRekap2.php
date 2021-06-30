<div class="col-md-12">
    <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed">
        <thead class="bg-info">
            <tr>
                <th rowspan="2" style="width5%;">Tanggal</th>
                <th rowspan="2">Jumlah Lembar</th>
                <th rowspan="2">Jumlah Pcs</th>
                <th colspan="2">Status / lembar</th>
                <th rowspan="2">Asal</th>
            </tr>
            <tr>
                <th>Sudah Terlayani / Sudah Input</th>
                <th>Belum Terlayani / Belum Input</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo date("d-M-Y") ?></td>
                <td><?= $masuk?></td>
                <td><?= $pcs?></td>
                <td><?= $sudah?></td>
                <td><?= $belum?></td>
                <td><button type="button" class="btn btn-success" onclick="adddrekap(this)"> Detail</button></td>
            </tr>
                <td colspan="6">
                    <div id="drekapmgs" style="display:none">
                        <table class="datatable table table-bordered table-hover table-striped text-center" style="width: 100%;table-layout:fixed">
                            <thead class="bg-success">
                                <tr>
                                    <th rowspan="2">Asal Gudang</th>
                                    <th colspan="2">Sudah Terlayani / Sudah Input</th>
                                    <th colspan="2">Belum Terlayani / Belum Input</th>
                                </tr>
                                <tr>
                                    <th>Item</th>
                                    <th>Pcs</th>
                                    <th>Item</th>
                                    <th>Pcs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($asal as $key => $val) { ?>
                                <tr>
                                    <td><?= $key?></td>
                                    <td><?= $val['sudah']?></td>
                                    <td><?= $val['pcs_sudah']?></td>
                                    <td><?= $val['belum'] ?></td>
                                    <td><?= $val['pcs_belum']?></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>