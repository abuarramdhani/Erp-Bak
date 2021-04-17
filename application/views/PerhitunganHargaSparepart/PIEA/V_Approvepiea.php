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
                <div class="box-body">
                    <div class="panel-body">
                        <table class="table table-bordered table-hover tblPHSViewApproval" style="width: 150%">
                            <thead>
                                <tr class="bg-primary">
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
                                    <th class="t-head-center" style="width: 400px;">Komponen*</th>
                                    <th class="t-head-center" style="width: 100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($approvepiea_rows as $k => $v) : ?>
                                    <tr>
                                        <td><?= $k + 1 ?></td>
                                        <td><?= $v->ORDER_ID ?></td>
                                        <td><?= $v->CREATION_DATE ?></td>
                                        <!-- <td><span class="label bg-yellow" style="width: 90%;"><?= $status ?></span></td> -->
                                        <td><?= $v->PRODUCT ?></td>
                                        <td><?= $v->ITEM_CODE ?></td>
                                        <td><?= $v->ITEM_DESC ?></td>
                                        <td><?= $v->WRAP_FLAG === 'Y' ? 'Ya' : 'Tidak' ?></td>
                                        <td><?= $v->QTY ?></td>
                                        <td><?= $v->CATEGORY ?></td>
                                        <td><?= $v->COMPETITOR_FLAG === 'Y' ? 'Ya' : 'Tidak' ?></td>
                                        <td><?= $v->COMMENTS ?></td>
                                        <td class="text-center">
                                            <!-- <input type="checkbox" class="CheckAprop" id="checkApropMKTMastItem<?= $v->ORDER_ID ?>" /> Master Item
                                            <input type="checkbox" class="CheckAprop" id="checkApropMKTBOM<?= $v->ORDER_ID ?>" /> BOM
                                            <input type="checkbox" class="CheckAprop" id="checkApropMKTRouting<?= $v->ORDER_ID ?>" /> Routing
                                            <br>
                                            <br> -->
                                            <select class="form-control select2" style="width: 200px;" data-placeholder="Master Item" id="checkApropMKTMastItem<?= $v->ORDER_ID ?>">
                                                <option></option>
                                                <option value="Y">Y</option>
                                                <option value="N">N</option>
                                            </select>
                                            <select class="form-control select2" style="width: 75px;" data-placeholder="BOM" id="checkApropMKTBOM<?= $v->ORDER_ID ?>">
                                                <option></option>
                                                <option value="Y">Y</option>
                                                <option value="N">N</option>
                                            </select>
                                            <select class="form-control select2" style="width: 100px;" data-placeholder="Routing" id="checkApropMKTRouting<?= $v->ORDER_ID ?>">
                                                <option></option>
                                                <option value="Y">Y</option>
                                                <option value="N">N</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-sm" onclick="ApprovePIEA(<?= $v->ORDER_ID ?>)">Approve</button>
                                            <button class="btn btn-danger btn-sm" onclick="RejectPIEA(<?= $v->ORDER_ID ?>)">Reject</button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-body">
                        <label>Keterangan : <br>*) Kolom Komponen diisi dengan memilih "Y" apabila ada, atau "N" jika tidak ada, <br> sesuai dengan ada tidaknya masing - masing komponen pada kolom tersebut </label>
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