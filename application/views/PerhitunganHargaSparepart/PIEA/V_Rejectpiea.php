<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Permintaan Perhitungan Harga Sparepart</h1>
</section>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12 container">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-table"></i> Daftar Rejected PIEA</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="panel-body">
                        <table class="table table-bordered table-hover tblPHSViewApproval" style="width: 150%">
                            <thead>
                                <tr class="bg-red">
                                    <th class="t-head-center">No.</th>
                                    <th class="t-head-center">Order Id</th>
                                    <th class="t-head-center">Tanggal Dibuat</th>
                                    <!-- <th class="t-head-center">Status</th> -->
                                    <th class="t-head-center">Produk</th>
                                    <th class="t-head-center">Kode Barang</th>
                                    <th class="t-head-center">Deskripsi</th>
                                    <th class="t-head-center">Bungkus</th>
                                    <th class="t-head-center">Isi/bungkus</th>
                                    <th class="t-head-center">Kategori Part</th>
                                    <th class="t-head-center">Info Pesaing</th>
                                    <!-- <th class="t-head-center">Referensi Harga<br>(DPP)</th> -->
                                    <th class="t-head-center">Keterangan</th>
                                    <th class="t-head-center">Alasan</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rejectpiea_rows as $k => $v) { ?>
                                    <tr>
                                        <td><?= $k + 1 ?></td>
                                        <td><?= $v['ORDER_ID'] ?></td>
                                        <td><?= $v['CREATION_DATE'] ?></td>
                                        <!-- <td><span class="label bg-yellow" style="width: 90%;"><?= $status ?></span></td> -->
                                        <td><?= $v['PRODUCT'] ?></td>
                                        <td><?= $v['ITEM_CODE'] ?></td>
                                        <td><?= $v['ITEM_DESC'] ?></td>
                                        <td><?= $v['WRAP_FLAG'] === 'Y' ? 'Ya' : 'Tidak' ?></td>
                                        <td><?= $v['QTY'] ?></td>
                                        <td><?= $v['CATEGORY'] ?></td>
                                        <td><?= $v['COMPETITOR_FLAG'] === 'Y' ? 'Ya' : 'Tidak' ?></td>
                                        <td><?= $v['COMMENTS'] ?></td>
                                        <td><?= $v['COMMENTS_REJECT'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

<div class="modal fade" id="mdl_approve_mkt_kasi" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Set Approver PIEA</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="approve_mkt_kasi"></div>
            </div>
        </div>

    </div>
</div>