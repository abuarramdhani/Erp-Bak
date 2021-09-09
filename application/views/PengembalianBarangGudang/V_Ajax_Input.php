<div class="panel-body">
    <input type="hidden" name="user" id="user" value="<?= $user?>">
    <table class="datatable table table-bordered table-hover table-striped text-center" id="tblInputPengembalian" style="width: 100%;">
        <thead class="bg-primary">
            <tr>
                <th>No</th>
                <th><input type="checkbox" class="checkedAllPBG"></th>
                <th>Proses Assembly</th>
                <th>Kode Komponen</th>
                <th>Nama Komponen</th>
                <th>Qty Komponen</th>
                <th>Alasan Pengembalian</th>
                <th>PIC Assembly</th>
                <th>PIC Gudang</th>
                <th>Status Verifikasi</th>
                <th>MO Reject</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; foreach ($input as $v) { 
            if($v['LT_QC'] > 2){
                $penanda = 'bg-danger';
            }else{
                $penanda = '';
            }
            
        ?>
            
            <tr>
                <td class="text-center <?= $penanda ?>"><?= $no ?></td>
                <td class="text-center <?= $penanda ?>">
                    <input type="checkbox"  class="ch_komp_pbg" name="ch_komp[]" value="<?= $v['ID_PENGEMBALIAN'].'+'; ?>">
                    <input type="hidden" name="selectedKompPBG" value="">
                    <input type="hidden" name="id_pengembalian[]" value="<?= $v['ID_PENGEMBALIAN'] ?>">
                </td>
                <td class="text-center <?= $penanda ?>"><?= $v['TIPE_PRODUK'] ?></td>
                <td class="<?= $penanda ?>"><?= $v['KODE_KOMPONEN'] ?></td>
                <td class="<?= $penanda ?>"><?= $v['NAMA_KOMPONEN'] ?></td>
                <td class="text-center <?= $penanda ?>"><?= $v['QTY_KOMPONEN'] ?></td>
                <td class="<?= $penanda ?>"><?= $v['ALASAN_PENGEMBALIAN'] ?></td>
                <td class="<?= $penanda ?>"><?= $v['PIC_ASSEMBLY'] ?></td>
                <td class="<?= $penanda ?>"><?= $v['PIC_GUDANG'] ?></td>
                <td class="<?= $penanda ?>"><?= $v['STATUS_VERIFIKASI'] ?></td>
                <td class="text-center <?= $penanda ?>"><?= $v['MO_REJ_TAMPIL'] ?></td>
                <td class="text-center <?= $penanda ?>">
                    <a class="btn btn-danger btn-sm" onclick="btnDeletePBG(`<?= $v['ID_PENGEMBALIAN']?>`)">
                        <i class="fa fa-trash"></i>&nbsp; Hapus
                    </a>
                </td>
            </tr>
        <?php $no++; }?>
        </tbody>
    </table>
</div>

<div class="text-right">
    <button type="button" class="btn btn-success pull-right" disabled="disabled" id="btnOrderVerif" onclick="orderverifselectedPBG()">
        <b>Order Verifikasi QC </b><b id="jmlSlcPBG"></b>
    </button>
    <br><br>
    <form method="post" target="_blank" id="createallMORej" action="<?php echo base_url('PengembalianBarangGudang/Input/createallMORej'); ?>">
        <input type="hidden" name="selectedKompPBG2" value="">
		<?php foreach ($input as $key => $v) { ?>
        <input type="hidden" name="id_pengembalian2[]" value="<?= $v['ID_PENGEMBALIAN'] ?>">
        <input type="hidden" name="tipe_produk[]" value="<?= $v['TIPE_PRODUK'] ?>">
        <input type="hidden" name="id_komponen[]" value="<?= $v['INVENTORY_ITEM_ID'] ?>">
		<input type="hidden" name="kode_komponen[]" value="<?= $v['KODE_KOMPONEN'] ?>">
		<input type="hidden" name="nama_komponen[]" value="<?= $v['NAMA_KOMPONEN'] ?>">
		<input type="hidden" name="qty_komponen[]" value="<?= $v['QTY_KOMPONEN'] ?>">
        <input type="hidden" name="uom[]" value="<?= $v['UOM'] ?>">
		<input type="hidden" name="alasan_pengembalian[]" value="<?= $v['ALASAN_PENGEMBALIAN'] ?>">
		<input type="hidden" name="pic_assembly[]" value="<?= $v['PIC_ASSEMBLY'] ?>">
		<input type="hidden" name="pic_gudang[]" value="<?= $v['PIC_GUDANG'] ?>">
		<input type="hidden" name="status_verifikasi[]" value="<?= $v['STATUS_VERIFIKASI'] ?>">
		<?php } ?>
        <button type="button" class="btn btn-success pull-right" disabled="disabled" id="btnCreateMoRej" onclick="document.getElementById('createallMORej').submit();">
            <b>Create MO Reject </b><b id="jmlSlcPBG2"></b>
        </button>
	</form>
</div>

<script type="text/javascript">
    $('.ch_komp_pbg').on('click',function(){
        var a = 0;
        var jml = 0;
        var val = '';
        $('input[name="ch_komp[]"]').each(function(){``
            if ($(this).is(":checked") === true ) {
                a = 1;
                jml +=1;
                val += $(this).val();
            }
        });
        if (a == 0) {
            $('#btnOrderVerif').attr("disabled","disabled");
            $('#jmlSlcPBG').text('');
            $('#jmlSlcPBG2').text('');
            $('#btnCreateMoRej').attr("disabled","disabled");
        }else{
            $('#btnOrderVerif').removeAttr("disabled");
            $('#jmlSlcPBG').text('('+jml+')');
            $('#jmlSlcPBG2').text('('+jml+')');
            $('input[name="selectedKompPBG"]').val(val);
            $('input[name="selectedKompPBG2"]').val(val);
            $('#btnCreateMoRej').removeAttr("disabled");  
            
        }

    });

    $('.checkedAllPBG').on('click', function(){
        var check = 0;
        var a = 0;
        var jml = 0;
        var val = '';
        if ($(this).is(":checked")) {
            check = 1;
        }else{
            check = 0;
        }
        $('input[name="ch_komp[]"]').each(function(){
            if (check == 1) {
                $(this).prop('checked', true);
            }else{
                $(this).prop('checked', false);
            }
        });

        $('input[name="ch_komp[]"]').each(function(){
            if ($(this).is(":checked") === true ) {
                a = 1;
                jml +=1;
                val += $(this).val();
            }
        });
        if (a == 0) {
            $('#btnOrderVerif').attr("disabled","disabled");
            $('#btnCreateMoRej').attr("disabled","disabled");
            $('#jmlSlcPBG').text('');
            $('#jmlSlcPBG2').text('');
        }else{
            $('#btnOrderVerif').removeAttr("disabled");
            $('#btnCreateMoRej').removeAttr("disabled");
            $('#jmlSlcPBG').text('('+jml+')');
            $('#jmlSlcPBG2').text('('+jml+')');
            $('input[name="selectedKompPBG"]').val(val);
            $('input[name="selectedKompPBG2"]').val(val);
        }
    });

</script>