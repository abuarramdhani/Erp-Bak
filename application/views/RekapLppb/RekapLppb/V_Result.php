<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
         $(document).ready(function () {
            $('.datepickRekap').datepicker({
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'yy-mm-dd',
            });
            $('.tblRkapLppb').dataTable({
                "scrollX": true,
            });
            
         });
    </script>
<table class="table table-striped table-bordered table-responsive table-hover text-left tblRkapLppb" id="" style="font-size:14px;">
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
            <td class="<?= $td?>">
                <input type="text" value="<?php if ($key['KIRIM_QC'] !== null){ echo date("m/d/Y", strtotime($key['KIRIM_QC'])); }?>" onchange="SaveKirimQC(<?=$i?>,'<?= $key['ITEM_ID'] ?>',<?= $key['RECEIPT_NUM'] ?>,<?= $key['PO'] ?>)" name="dateKirimQC<?= $i ?>" id="dateKirimQC<?= $i ?>" class="datepickRekap" />
            </td>
            <td class="<?= $td?>">
                <input value="<?php if ($key['TERIMA_QC'] !== null){ echo date("m/d/Y", strtotime($key['TERIMA_QC'])); }?>" onchange="SaveTerimaQC(<?=$i?>,'<?= $key['ITEM_ID'] ?>',<?= $key['RECEIPT_NUM'] ?>,<?= $key['PO'] ?>)" name="dateTerimaQC<?= $i ?>" id="dateTerimaQC<?= $i ?>" class="datepickRekap" />
            </td>
            <td class="<?= $td?>">
                <input value="<?php if ($key['KEMBALI_QC'] !== null){ echo date("m/d/Y", strtotime($key['KEMBALI_QC'])); }?>" onchange="SaveKembaliQC(<?=$i?>,'<?= $key['ITEM_ID'] ?>',<?= $key['RECEIPT_NUM'] ?>,<?= $key['PO'] ?>)" name="dateKembaliQC<?= $i ?>" id="dateKembaliQC<?= $i ?>" class="datepickRekap" />
            </td>
            <td class="<?= $td?>">
                <input value="<?php if ($key['KIRIM_GUDANG'] !== null){ echo date("m/d/Y", strtotime($key['KIRIM_GUDANG'])); }?>" onchange="SaveKirimGudang(<?=$i?>,'<?= $key['ITEM_ID'] ?>',<?= $key['RECEIPT_NUM'] ?>,<?= $key['PO'] ?>)" name="dateKirimGudang<?= $i ?>" id="dateKirimGudang<?= $i ?>" class="datepickRekap" />
            </td>
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
                                <input value="<?php if ($key['TERIMA_GUDANG'] !== null){ echo date("m/d/Y", strtotime($key['TERIMA_GUDANG'])); }?>" onchange="SaveTerimaGudang(<?=$i?>,'<?= $key['ITEM_ID'] ?>',<?= $key['RECEIPT_NUM'] ?>,<?= $key['PO'] ?>)" name="dateTerimaGudang<?= $i ?>" id="dateTerimaGudang<?= $i ?>" class="datepickRekap" />
                            </td>
                        <?php }else{?>
                            <td class="<?= $td?>">
                                <input value="<?php if ($key['TERIMA_GUDANG'] !== null){ echo date("m/d/Y", strtotime($key['TERIMA_GUDANG'])); }?>" onchange="SaveTerimaGudang(<?=$i?>,'<?= $key['ITEM_ID'] ?>',<?= $key['RECEIPT_NUM'] ?>,<?= $key['PO'] ?>)" name="dateTerimaGudang<?= $i ?>" id="dateTerimaGudang<?= $i ?>" class="datepickRekap" />
                            </td>
            <?php }
                }else{ ?>
            <td class="<?= $td?>">
                <input value="<?php if ($key['TERIMA_GUDANG'] !== null){ echo date("m/d/Y", strtotime($key['TERIMA_GUDANG'])); }?>" onchange="SaveTerimaGudang(<?=$i?>,'<?= $key['ITEM_ID'] ?>',<?= $key['RECEIPT_NUM'] ?>,<?= $key['PO'] ?>)" name="dateTerimaGudang<?= $i ?>" id="dateTerimaGudang<?= $i ?>" class="datepickRekap" />
            </td>
            <?php } ?>
            <td class="<?= $td?>">
                <input type="hidden" name="dateDeliver<?= $i ?>" value="<?= $key['DELIVER_DATE'] ?>"><?= $key['DELIVER_DATE'] ?>
            </td>
        </tr><?php
        $i++; } 
    } ?>
    </tbody>
</table>
