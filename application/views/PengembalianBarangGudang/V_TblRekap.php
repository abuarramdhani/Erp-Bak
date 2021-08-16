<script>
$(document).ready(function () {
    $('.TblRkpPBG').DataTable({
        scrollX: true,
        scrollY:  500,
        scrollCollapse: true,
        paging:false,
        info:true,
        ordering:false
    });
})
</script>
<div class="col-md-12">
    <form action="<?php echo base_url('PengembalianBarangGudang/Rekap/exportDataPBG'); ?>" method="post">
        <table class="datatable table table-bordered table-hover table-striped text-center TblRkpPBG" id="TblRkpPBG" style="width: 100%;table-layout:fixed">
            <thead class="bg-info">
                <tr>
                    <th>No</th>
                    <th>Kode Komponen</th>
                    <th>Nama Komponen</th>
                    <th>Qty Komponen</th>
                    <th>Alasan Pengembalian</th>
                    <th>PIC Assembly</th>
                    <th>PIC Gudang</th>
                    <th>Tgl Input</th>
                    <th>Tgl Order Verifikasi</th>
                    <th>Tgl Verifikasi</th>
                    <th>Status Verifikasi QC</th>
                    <th>Keterangan</th>
                    <th>Seksi Penerima Barang</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; $i=0; foreach($hasil as $v){ ?>
                <tr>
                    <td>
                        <?= $no?>
                        <input type="hidden" name="id_pengembalian[]" id="id_pengembalian" value="<?= $v['ID_PENGEMBALIAN']?>">
                        <input type="hidden" name="tgl_awal[]" id="tgl_awal" value="<?= $tgl_awal ?>">
                        <input type="hidden" name="tgl_akhir[]" id="tgl_akhir" value="<?= $tgl_akhir ?>">
                    </td>
                    <td><input type="hidden" name="kode_komponen[]" id="kode_komponen" value="<?= $v['KODE_KOMPONEN']?>"><?= $v['KODE_KOMPONEN']?></td>
                    <td><input type="hidden" name="nama_komponen[]" id="nama_komponen" value="<?= $v['NAMA_KOMPONEN']?>"><?= $v['NAMA_KOMPONEN']?></td>
                    <td><input type="hidden" name="qty_komponen[]" id="qty_komponen" value="<?= $v['QTY_KOMPONEN']?>"><?= $v['QTY_KOMPONEN']?></td>
                    <td><input type="hidden" name="alasan_pengembalian[]" id="alasan_pengembalian" value="<?= $v['ALASAN_PENGEMBALIAN']?>"><?= $v['ALASAN_PENGEMBALIAN']?></td>
                    <td><input type="hidden" name="pic_assembly[]" id="pic_assembly" value="<?= $v['PIC_ASSEMBLY']?>"><?= $v['PIC_ASSEMBLY']?></td>
                    <td><input type="hidden" name="pic_gudang[]" id="pic_gudang" value="<?= $v['PIC_GUDANG']?>"><?= $v['PIC_GUDANG']?></td>
                    <td><input type="hidden" name="tgl_input[]" id="tgl_input" value="<?= $v['TGL_INPUT']?>"><?= $v['TGL_INPUT']?></td>
                    <td><input type="hidden" name="tgl_order_verifikasi[]" id="tgl_order_verifikasi" value="<?= $v['TGL_ORDER_VERIFIKASI']?>"><?= $v['TGL_ORDER_VERIFIKASI']?></td>
                    <td><input type="hidden" name="tgl_verifikasi[]" id="tgl_verifikasi" value="<?= $v['TGL_VERIFIKASI']?>"><?= $v['TGL_VERIFIKASI']?></td>
                    <td><input type="hidden" name="status_verifikasi[]" id="status_verifikasi" value="<?= $v['STATUS_VERIFIKASI']?>"><?= $v['STATUS_VERIFIKASI']?></td>
                    <td><input type="hidden" name="keterangan[]" id="keterangan" value="<?= $v['KETERANGAN']?>"><?= $v['KETERANGAN']?></td>
                    <td><input type="hidden" name="locator[]" id="locator" value="<?= $v['LOCATOR']?>"><?= $v['LOCATOR']?></td>
                    <td><input type="hidden" name="status[]" id="status" value="<?= $v['STATUS']?>"><?= $v['STATUS']?></td>
                </tr>
                <?php $no++; $i++; } ?>
            </tbody>
        </table>
        <div class="text-center">
            <button type="submit" title="Export" class="btn btn-success"><i class="fa fa-download"></i> Export Excel</button>
        </div>
    </form>
</div>