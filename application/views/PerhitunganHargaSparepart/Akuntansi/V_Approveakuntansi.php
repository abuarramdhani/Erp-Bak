<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Permintaan Perhitungan Harga Sparepart</h1>
</section>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12 container">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-table"></i> Daftar Permintaan Approval</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <form class="frm_Appr_Akt" enctype="multipart/form-data" method="post">

                    <div class="box-body">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover tblPHSViewApproval" style="width: 150%">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="t-head-center"><input type="checkbox" class="CheckSprAll"></th>
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
                                        <!-- <th class="t-head-center" style="width: 200px;">File*</th>
                                        <th class="t-head-center" style="width: 100px;">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $angka = 1;
                                    foreach ($approveakuntansi_rows as $k => $v) { ?>
                                        <tr>
                                            <td><input type="checkbox" class="CheckSprlist" data-row="<?= $angka ?>"></td>
                                            <td><?= $k + 1 ?></td>
                                            <td><?= $v['ORDER_ID'] ?>
                                                <input type="hidden" class="no_order_nya" data-row="<?= $angka ?>" value="<?= $v['ORDER_ID'] ?>">
                                            </td>
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
                                        </tr>
                                    <?php $angka++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-1"><label>Action</label></div>
                            <div class="col-md-3">
                                <input type="file" class="form-control" onchange="ChangeButtonApproveAkt()" name="ref_harga" id="ref_harga" style="width: 250px;" />
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success btn-sm" id="btnApprAkt" disabled="disabled">Approve</button>
                                <a class="btn btn-danger btn-sm" onclick="RejectAkt()">Reject</a>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->