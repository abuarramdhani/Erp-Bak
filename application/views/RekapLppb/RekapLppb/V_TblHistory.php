<script>
        $(document).ready(function () {
        $('.tblRkapLppb').dataTable({
            "scrollX": true,
        });
        
        });
</script>

<div class="table-responsive"  id="tb_historyLppb">
<table class="table table-striped table-bordered table-responsive table-hover text-left tblRkapLppb" style="font-size:14px;">
    <thead>
        <tr class="bg-primary">
            <td width=""><b>No</b></td>
            <td width=""><b>Item </b></td>
            <td width="20%"><b>Description</b></td>
            <td width=""><b>No.PO</b></td>
            <td width=""><b>No. Receipt</b></td>
            <td width=""><b>Receipt Date</b></td>
            <td width=""><b>Sudah LPPB</b></td>
            <td width=""><b>Kirim QC</b></td>
            <td width=""><b>Proses QC</b></td>
            <td width=""><b>Terima QC</b></td>
            <td width=""><b>Kembali QC</b></td>
            <td width=""><b>Kirim Gudang</b></td>
            <td width=""><b>Terima Gudang</b></td>
            <td width=""><b>Deliver</b></td>
        </tr>
    </thead>
    <tbody>
    <?php 
    $i=1;
    if (empty($data)) {
    } else {
    foreach ($data as $key) { 
        if ($key['DELIVER_DATE'] == '') {
            $td = 'bg-warning';
        }else {
            $td = '';
        }
        ?>
            <tr>
                <td class="<?= $td?>"><?= $i ?></td>
                <td class="<?= $td?>"><?= $key['ITEM'] ?><input type="hidden" name="txtItem<?= $i ?>" value="<?= $key['ITEM'] ?>"></td>
                <td class="<?= $td?>"><?= $key['DESCRIPTION'] ?><input type="hidden" name="txtDescription<?= $i ?>" value="<?= $key['DESCRIPTION'] ?>"></td>
                <td class="<?= $td?>"><?= $key['PO'] ?><input type="hidden" name="txtPO<?= $i ?>" value="<?= $key['PO'] ?>"></td>
                <td class="<?= $td?>"><?= $key['RECEIPT_NUM'] ?><input type="hidden" name="txtRecNum<?= $i ?>" value="<?= $key['RECEIPT_NUM'] ?>"></td>
                <td class="<?= $td?>"><?= $key['RECEIPT_DATE'] ?><input type="hidden" name="dateRecDate<?= $i ?>" value="<?= $key['RECEIPT_DATE'] ?>"></td>
                <td class="<?= $td?>"><?= $key['RECEIPT_DATE'] ?><input type="hidden" name="dateSudah<?= $i ?>" value="<?= $key['RECEIPT_DATE'] ?>"></td>
                <td class="<?= $td?>"><?= $key['KIRIM_QC'] ?><input type="hidden" name="dateKirimQC<?= $i ?>" value="<?= $key['KIRIM_QC'] ?>"></td>
                <td class="<?= $td?>"><?= $key['TGL_QC'] ?><input type="hidden" name="prosesQC<?= $i ?>" value="<?= $key['TGL_QC'] ?>"></td>
                <td class="<?= $td?>"><?= $key['TERIMA_QC'] ?><input type="hidden" name="dateTerimaQC<?= $i ?>" value="<?= $key['TERIMA_QC'] ?>"></td>
                <td class="<?= $td?>"><?= $key['KEMBALI_QC'] ?><input type="hidden" name="dateKembaliQC<?= $i ?>" value="<?= $key['KEMBALI_QC'] ?>"></td>
                <td class="<?= $td?>"><?= $key['KIRIM_GUDANG'] ?><input type="hidden" name="dateKirimGd<?= $i ?>" value="<?= $key['KIRIM_GUDANG'] ?>"></td>
                <?php 
                if ($key['TERIMA_GUDANG'] !== null){
                    $tgl1 = $key['TERIMA_GUDANG'];
                    $tgl2 = $key['KIRIM_GUDANG'];
                    $nextdate = date('Y-m-d', strtotime($tgl2 .' +1 day'));
                    $date = date('Y-m-d', strtotime($tgl1));
                    // echo $nextdate;
                            if ( $date > $nextdate ) {
                                ?>
                                <td bgcolor="red">
                                <?= $key['TERIMA_GUDANG'] ?><input type="hidden" name="dateTerimaGd<?= $i ?>" value="<?= $key['TERIMA_GUDANG'] ?>">
                                </td>
                            <?php }else{?>
                                <td class="<?= $td?>">
                                    <?= $key['TERIMA_GUDANG'] ?><input type="hidden" name="dateTerimaGd<?= $i ?>" value="<?= $key['TERIMA_GUDANG'] ?>">
                                </td>
                <?php }
                    }else{ ?>
                <td class="<?= $td?>">
                    <?= $key['TERIMA_GUDANG'] ?><input type="hidden" name="dateTerimaGd<?= $i ?>" value="<?= $key['TERIMA_GUDANG'] ?>">
                </td>
                <?php } ?>
                <td class="<?= $td?>">
                    <input type="hidden" name="dateDeliver<?= $i ?>" value="<?= $key['DELIVER_DATE'] ?>"><?= $key['DELIVER_DATE'] ?>
                </td>
            </tr>            
        <?php  
            $i++;} 
    } ?>
    </tbody>
</table>
</div>