<script>
        $(document).ready(function () {
        $('#tbl_tanpa_surat').dataTable({
            "scrollX": true,
            ordering: false,
            paging : false,
            info : false,
            searching : false
        });
        $('#tbl_tanpa_surat2').dataTable({
            "scrollX": true,
        });
        });
</script>
<form method="post" action="<?= base_url("MonitoringGdSparepart/Monitoring/saveTanpaSurat")?>">
    <div class="panel-body box box-info box-solid">
        <div class="panel-body">
            <table class="table table-hover table-bordered table-striped text-center" id="tbl_tanpa_surat" style="width:100%">
                <thead class="bg-success">
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Uom</th>
                        <th>Qty</th>
                        <th>Jumlah OK</th>
                        <th>Jumlah Not OK</th>
                        <th>Keterangan</th>
                        <th>Action</th>
                        <th>PIC</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="body_tanpa_surat">
                    <tr>
                        <td><select id="kode_barang1" name="kode_barang[]" class="form-control select2 getkodebrgsurat" style="width:200px" data-placeholder="kode barang" onchange="getDescBarang(1)"></select></td>
                        <td><input id="nama_barang1" name="nama_barang[]" class="form-control" style="width:300px" placeholder="nama barang" readonly></td>
                        <td><input id="uom1" name="uom[]" class="form-control" style="width:100px" placeholder="uom" readonly></td>
                        <td><input type="number" id="qty1" name="qty[]" class="form-control" style="width:100px" placeholder="quantity" autocomplete="off"></td>
                        <td><input type="number" id="jml_ok1" name="jml_ok[]" class="form-control" style="width:100px" placeholder="jumlah ok" autocomplete="off"></td>
                        <td><input type="number" id="jml_not1" name="jml_not[]" class="form-control" style="width:100px" placeholder="jumlah not ok" autocomplete="off"></td>
                        <td><input id="keterangan1" name="keterangan[]" class="form-control" style="width:200px" placeholder="keterangan" autocomplete="off"></td>
                        <td><input id="action1" name="action[]" class="form-control" style="width:200px" placeholder="action" autocomplete="off"></td>
                        <td><select id="pic1" name="pic[]" class="form-control select2 picGDSP" style="width:200px" data-placeholder="pic"></select></td>
                        <td><button type="button" id="btn_tambah" class="btn" onclick="tmb_tanpa_surat(this)"><i class="fa fa-plus"></i></button>
                            <input type="hidden" class="nomor" value="1">    
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="panel-body text-center">
            <button id="btn_save" class="btn btn-md btn-success">Save <i class="fa fa-check"></i></button>
        </div>
    </div>
</form>
<br>
<div class="panel-body">
    <table class="table table-hover table-bordered table-striped text-center" id="tbl_tanpa_surat2" style="width:100%">
        <thead class="bg-primary">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th style="width:15%">Kode Barang</th>
                <th style="width:40%">Nama Barang</th>
                <th>Uom</th>
                <th>Qty</th>
                <th>Jumlah OK</th>
                <th>Jumlah Not OK</th>
                <th>Keterangan</th>
                <th>Action</th>
                <th>PIC</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; foreach ($value as $key => $val) { ?>
            <tr>
                <td><?= $no?></td>
                <td><?= $val['TANGGAL']?></td>
                <td><?= $val['ITEM']?></td>
                <td><?= $val['DESCRIPTION']?></td>
                <td><?= $val['UOM']?></td>
                <td><?= $val['QTY']?></td>
                <td><?= $val['JML_OK']?></td>
                <td><?= $val['JML_NOT_OK']?></td>
                <td><?= $val['KETERANGAN']?></td>
                <td><?= $val['ACTION']?></td>
                <td><?= $val['PIC']?></td>
            </tr>
        <?php $no++; }?>
        </tbody>
    </table>
</div>
