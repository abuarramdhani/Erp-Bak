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
<div class="table-responsive"  id="tb_inputLPPB">
<table class="table table-striped table-bordered table-responsive table-hover text-left tblRkapLppb" id="tb_inputLPPB" style="font-size:14px;">
    <thead>
        <tr class="bg-primary">
            <td width=""><b>No</b></td>
            <!-- <td width=""><b>Item </b></td> -->
            <!-- <td width="20%"><b>Description</b></td> -->
            <!-- <td width=""><b>No.PO</b></td> -->
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
        if ($key['DELIVER_DATE'] != '') {
            
        }else { ?>
            <tr>
                <td><?= $i ?><input type="hidden" name="io<?= $i ?>" id="io<?= $i ?>" value="<?= $io ?>"></td>
                <!-- <td><input type="hidden" name="txtItem<?= $i ?>" value=""></td> -->
                <!-- <td><input type="hidden" name="txtDescription<?= $i ?>" value=""></td> -->
                <!-- <td><input type="hidden" name="txtPO<?= $i ?>" value=""></td> -->
                <td><?= $key['RECEIPT_NUM'] ?><input type="hidden" name="txtRecNum<?= $i ?>" value="<?= $key['RECEIPT_NUM'] ?>"></td>
                <td><?= $key['RECEIPT_DATE'] ?><input type="hidden" name="dateRecDate<?= $i ?>" value="<?= $key['RECEIPT_DATE'] ?>"></td>
                <td><?= $key['RECEIPT_DATE'] ?><input type="hidden" name="dateSudah<?= $i ?>" value="<?= $key['RECEIPT_DATE'] ?>"></td>
                <td class="text-center">
                    <input type="button" class="btn btn-xs btn-warning" <?php if ($key['KIRIM_QC'] !== null){ ?> value="<?= $key['KIRIM_QC'] ?>" disabled="disabled" <?php } else{ ?> value="klik" <?php } ?> onclick="SaveKirimQC1(<?=$i?>,<?= $key['RECEIPT_NUM'] ?>)" name="dateKirimQC<?= $i ?>" id="dateKirimQC<?= $i ?>"/>
                </td>
                <td class="text-center">
                    <input type="button" class="btn btn-xs btn-warning" <?php if ($key['TERIMA_QC'] !== null){ ?> value="<?= $key['TERIMA_QC'] ?>" disabled="disabled" <?php } else{ ?> value="klik" <?php } ?> onclick="SaveTerimaQC1(<?=$i?>,<?= $key['RECEIPT_NUM'] ?>)" name="dateTerimaQC<?= $i ?>" id="dateTerimaQC<?= $i ?>"/>    
                </td>
                <td class="text-center">
                    <input type="button" class="btn btn-xs btn-warning" <?php if ($key['KEMBALI_QC'] !== null){ ?> value="<?= $key['KEMBALI_QC'] ?>" disabled="disabled" <?php } else{ ?> value="klik" <?php } ?> onclick="SaveKembaliQC1(<?=$i?>,<?= $key['RECEIPT_NUM'] ?>)" name="dateKembaliQC<?= $i ?>" id="dateKembaliQC<?= $i ?>"/>    
                </td>
                <td class="text-center">
                    <input type="button" class="btn btn-xs btn-warning" <?php if ($key['KIRIM_GUDANG'] !== null){ ?> value="<?= $key['KIRIM_GUDANG'] ?>" disabled="disabled" <?php } else{ ?> value="klik" <?php } ?> onclick="SaveKirimGudang1(<?=$i?>,<?= $key['RECEIPT_NUM'] ?>)" name="dateKirimGudang<?= $i ?>" id="dateKirimGudang<?= $i ?>"/>    
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
                                <td  class="text-center" bgcolor="red">
                                    <input type="button" class="btn btn-xs btn-warning" <?php if ($key['TERIMA_GUDANG'] !== null){ ?> value="<?= $key['TERIMA_GUDANG'] ?>" disabled="disabled" <?php } else{ ?> value="klik" <?php } ?> onclick="SaveTerimaGudang1(<?=$i?>,<?= $key['RECEIPT_NUM'] ?>)" name="dateTerimaGudang<?= $i ?>" id="dateTerimaGudang<?= $i ?>"/>    
                                </td>
                            <?php }else{?>
                                <td class="text-center">
                                <input type="button" class="btn btn-xs btn-warning" <?php if ($key['TERIMA_GUDANG'] !== null){ ?> value="<?= $key['TERIMA_GUDANG'] ?>" disabled="disabled" <?php } else{ ?> value="klik" <?php } ?> onclick="SaveTerimaGudang1(<?=$i?>,<?= $key['RECEIPT_NUM'] ?>)" name="dateTerimaGudang<?= $i ?>" id="dateTerimaGudang<?= $i ?>"/>    
                                </td>
                <?php }
                    }else{ ?>
                <td class="text-center">
                <input type="button" class="btn btn-xs btn-warning" <?php if ($key['TERIMA_GUDANG'] !== null){ ?> value="<?= $key['TERIMA_GUDANG'] ?>" disabled="disabled" <?php } else{ ?> value="klik" <?php } ?> onclick="SaveTerimaGudang1(<?=$i?>,<?= $key['RECEIPT_NUM'] ?>)" name="dateTerimaGudang<?= $i ?>" id="dateTerimaGudang<?= $i ?>"/>    
                </td>
                <?php } ?>
                <td>
                    <input type="hidden" name="dateDeliver<?= $i ?>" value="<?= $key['DELIVER_DATE'] ?>"><?= $key['DELIVER_DATE'] ?>
                </td>
            </tr>
        <?php $i++; }
        ?>
        <?php
         } 
    } ?>
    </tbody>
</table>
</div>
