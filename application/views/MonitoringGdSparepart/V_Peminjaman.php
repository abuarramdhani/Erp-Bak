<script>
        $(document).ready(function () {
        $('#tbl_input').dataTable({
            "scrollX": true,
            ordering: false,
            paging : false,
            info : false,
            searching : false
        });
        });
</script>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-body">
                                <div class="col-md-12">
                                    <h2><i class="fa fa-cubes" style="font-size:35px"></i><?= $Title?></h2>
                                </div>
                                <br><br><br>
                                <div class="panel-body">
                                <p class="text-right"><?= date('l, d F Y')?></p>
                                <form method="post" action="<?= base_url("MonitoringGdSparepart/PeminjamanBarang/savePeminjaman")?>">
                                <div class="panel-body box box-info box-solid">
                                    <div class="panel-body">
                                        <table class="table table-hover table-bordered table-striped text-center" id="tbl_input" style="width:100%">
                                            <thead class="bg-info">
                                                <tr>
                                                    <th>Nama Peminjam</th>
                                                    <th>Seksi</th>
                                                    <th>Kode Barang</th>
                                                    <th>Nama Barang</th>
                                                    <th>Qty</th>
                                                    <th>Alasan</th>
                                                    <th>PIC</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="body_peminjam">
                                                <tr>
                                                    <td><select id="nama_peminjam1" name="nama_peminjam[]" class="form-control select2 getpeminjam" style="width:200px" data-placeholder="nama peminjam" onchange="getSeksi(1)" required></select></td>
                                                    <td><input id="seksi_peminjam1" name="seksi_peminjam[]" class="form-control" style="width:300px" placeholder="seksi peminjam" readonly></td>
                                                    <td><select id="kode_barang1" name="kode_barang[]" class="form-control select2 getkodebrgpeminjaman" style="width:200px" data-placeholder="kode barang" onchange="getDescBarang(1)" required></select></td>
                                                    <td><input id="nama_barang1" name="nama_barang[]" class="form-control" style="width:300px" placeholder="nama barang" readonly></td>
                                                    <td><input type="number" id="qty1" name="qty[]" class="form-control" style="width:100px" placeholder="quantity" autocomplete="off" required></td>
                                                    <td><textarea id="alasan1" name="alasan[]" placeholder="alasan" style="width:300px" ></textarea></td>
                                                    <td><select id="pic1" name="pic[]" class="form-control select2 picGDSP" style="width:200px" data-placeholder="pic" required></select></td>
                                                    <td><button type="button" id="btn_tambah" class="btn" onclick="tmb_peminjam(this)"><i class="fa fa-plus"></i></button>
                                                        <input type="hidden" class="nomor" value="1">    
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="panel-body text-center">
                                        <button id="btn_save" class="btn btn-md btn-success"><i class="fa fa-check"></i> Input</button>
                                    </div>
                                </div>
                                </form>
                                <br>
                                <div class="panel-body" id="tbl_peminjaman"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>