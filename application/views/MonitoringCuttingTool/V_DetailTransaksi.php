<script>
    $(document).ready(function () {
        $('.tbldettrans').dataTable({
            "scrollX": true,
        });
    
    });
</script>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-default box-solid">
                        <!-- <div class="box-header text-center" style="font-size:15px"><strong>Daftar Transaksi</strong></div> -->
                            <div class="box-body">
                                <div class="panel-body" style="margin-left:-40px">
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label>Kode Barang</label>
                                        </div>
                                        <div class="col-md-10">
                                            : <?= $item?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label>Deskripsi</label>
                                        </div>
                                        <div class="col-md-10">
                                            : <?= $desc?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label>Bulan Transaksi</label>
                                        </div>
                                        <div class="col-md-10">
                                            : <?= $bulan?>
                                        </div>
                                    </div>
                                </div>
                                <div class="box box-info box-solid">
                                <div class="box-header text-center" style="font-size:15px"><strong>Daftar Transaksi Masuk</strong></div>
                                <div class="panel-body">
                                    <!-- <h3 style="text-align:center">Daftar Transaksi Masuk</h3> -->
                                    <div class="table-responsive">
                                        <table class="datatable table table-bordered table-hover table-striped text-center text-nowrap tbldettrans" style="width: 100%;">
                                            <thead class="bg-info">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Komponen</th>
                                                    <th>Deskripsi Komponen</th>
                                                    <th>Transaction QTY</th>
                                                    <th>UOM</th>
                                                    <th>Transaction Source Name</th>
                                                    <th>Creation Date</th>
                                                    <th>Last Update</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no = 1; foreach ($datain as $key => $value) {?>
                                                <tr>
                                                    <td><?= $no?></td>
                                                    <td><?= $value['SEGMENT1']?></td>
                                                    <td style="text-align:left;"><?= $value['DESCRIPTION']?></td>
                                                    <td><?= $value['TRANSACTION_QUANTITY']?></td>
                                                    <td><?= $value['TRANSACTION_UOM']?></td>
                                                    <td><?= $value['TRANSACTION_SOURCE_NAME']?></td>
                                                    <td><?= $value['CREATION_DATE']?></td>
                                                    <td><?= $value['LAST_UPDATE_DATE']?></td>
                                                </tr>
                                            <?php $no++; }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                </div>
                                <br><br>
                                <div class="box box-danger box-solid">
                                <div class="box-header text-center" style="font-size:15px"><strong>Daftar Transaksi Keluar</strong></div>
                                <div class="panel-body">
                                    <!-- <h3 style="text-align:center">Daftar Transaksi Keluar</h3> -->
                                    <div class="table-responsive">
                                        <table class="datatable table table-bordered table-hover table-striped text-center text-nowrap tbldettrans" style="width: 100%;">
                                            <thead style="background-color:#FFB197">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Komponen</th>
                                                    <th>Deskripsi Komponen</th>
                                                    <th>Transaction QTY</th>
                                                    <th>UOM</th>
                                                    <th>Transaction Source Name</th>
                                                    <th>Creation Date</th>
                                                    <th>Last Update</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no = 1; foreach ($dataout as $key => $value) {?>
                                                <tr>
                                                    <td><?= $no?></td>
                                                    <td><?= $value['SEGMENT1']?></td>
                                                    <td style="text-align:left;"><?= $value['DESCRIPTION']?></td>
                                                    <td><?= $value['TRANSACTION_QUANTITY']?></td>
                                                    <td><?= $value['TRANSACTION_UOM']?></td>
                                                    <td><?= $value['TRANSACTION_SOURCE_NAME']?></td>
                                                    <td><?= $value['CREATION_DATE']?></td>
                                                    <td><?= $value['LAST_UPDATE_DATE']?></td>
                                                </tr>
                                            <?php $no++; }?>
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
    </div>
</section>

