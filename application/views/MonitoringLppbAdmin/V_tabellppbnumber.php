<?php foreach ($invoice as $po_num) { ?>
	<input type="hidden" value="<?= $po_num['ORGANIZATION_ID'] ?>" name="organization_id[]">
	<input type="hidden" value="<?= $po_num['ORGANIZATION_CODE'] ?>" name="organization_code[]">
	<input type="hidden" value="<?= $po_num['LPPB_NUMBER'] ?>" name="lppb_number[]">
	<input type="hidden" value="<?= $po_num['VENDOR_NAME'] ?>" name="vendor_name[]">
	<input type="hidden" value="<?= $po_num['PO_NUMBER'] ?>" name="po_number[]">
	<input type="hidden" value="<?= $po_num['TANGGAL_LPPB'] ?>" name="tanggal_lppb[]">
	<input type="hidden" value="<?= $po_num['STATUS_LPPB'] ?>" name="status[]">
<?php } ?>

<script type="text/javascript">
	var id_gd;
</script>