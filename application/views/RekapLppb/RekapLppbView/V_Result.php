<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
         $(document).ready(function () {
            $('.tblRekapLppbview').dataTable({
                "scrollX": true,
			});
         });
    </script>
<table class="table table-striped table-bordered table-responsive table-hover text-left tblRekapLppbview" id="" style="font-size:14px;">
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
    foreach ($data as $key) { ?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $key['ITEM'] ?></td>
            <td><?= $key['DESCRIPTION'] ?></td>
            <td><?= $key['PO'] ?></td>
            <td><?= $key['RECEIPT_NUM'] ?></td>
            <td><?= $key['RECEIPT_DATE'] ?></td>
            <td><?= $key['RECEIPT_DATE'] ?></td>
            <td><?= $key['KIRIM_QC'] ?></td>
            <td><?= $key['TERIMA_QC'] ?></td>
            <td><?= $key['KEMBALI_QC'] ?></td>
            <td><?= $key['KIRIM_GUDANG'] ?></td>
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
                                <?= $key['TERIMA_GUDANG']?>
                            </td>
                        <?php }else{?>
                            <td>
                                <?= $key['TERIMA_GUDANG']?>
                            </td>
            <?php }
                }else{ ?>
            <td >
                <?= $key['TERIMA_GUDANG']?>
            </td>
            <?php } ?>
            <td><?= $key['DELIVER_DATE'] ?></td>
        </tr><?php
        $i++; } 
    } ?>
    </tbody>
</table>