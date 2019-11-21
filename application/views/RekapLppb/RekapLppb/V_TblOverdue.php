<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
         $(document).ready(function () {
            // $('.datepickRekap').datepicker({
            //     autoclose: true,
            //     todayHighlight: true,
            //     dateFormat: 'yy-mm-dd',
            // });
            // $('.datepickBulan').datepicker({
            //     format: 'M-yyyy',
            //     viewMode: "months",
            //     minViewMode: "months",
            //     autoClose: true
            // });
            $('.tblRkapLppb').dataTable({
                "scrollX": true,
            });
            
         });
    </script>

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
                <td><?= $i ?></td>
                <td><?= $key['ITEM'] ?><input type="hidden" name="txtItem<?= $i ?>" value="<?= $key['ITEM'] ?>"></td>
                <td><?= $key['DESCRIPTION'] ?><input type="hidden" name="txtDescription<?= $i ?>" value="<?= $key['DESCRIPTION'] ?>"></td>
                <td><?= $key['PO'] ?><input type="hidden" name="txtPO<?= $i ?>" value="<?= $key['PO'] ?>"></td>
                <td><?= $key['RECEIPT_NUM'] ?><input type="hidden" name="txtRecNum<?= $i ?>" value="<?= $key['RECEIPT_NUM'] ?>"></td>
                <td><?= $key['RECEIPT_DATE'] ?><input type="hidden" name="dateRecDate<?= $i ?>" value="<?= $key['RECEIPT_DATE'] ?>"></td>
                <td><?= $key['RECEIPT_DATE'] ?><input type="hidden" name="dateSudah<?= $i ?>" value="<?= $key['RECEIPT_DATE'] ?>"></td>
                <td><?= $key['KIRIM_QC'] ?><input type="hidden" name="dateKirimQC<?= $i ?>" value="<?= $key['KIRIM_QC'] ?>"></td>
                <td><?= $key['TERIMA_QC'] ?><input type="hidden" name="dateTerimaQC<?= $i ?>" value="<?= $key['TERIMA_QC'] ?>"></td>
                <td><?= $key['KEMBALI_QC'] ?><input type="hidden" name="dateKembaliQC<?= $i ?>" value="<?= $key['KEMBALI_QC'] ?>"></td>
                <td><?= $key['KIRIM_GUDANG'] ?><input type="hidden" name="dateKirimGd<?= $i ?>" value="<?= $key['KIRIM_GUDANG'] ?>"></td>
                <td><?= $key['TERIMA_GUDANG'] ?><input type="hidden" name="dateTerimaGd<?= $i ?>" value="<?= $key['TERIMA_GUDANG'] ?>"></td>
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