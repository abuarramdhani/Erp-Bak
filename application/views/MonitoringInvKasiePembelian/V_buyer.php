    <div class="row">
		      <div class="col-md-12">
		      	<input id="hdnBerkasPurc" type="hidden" value="<?php echo $param[0]['STATUS_BERKAS_PURC']?>">
		      	<center>
		      		<span><b>DEFAULT BUYER BERDASARKAN PO</b></span>
		      		<input disabled type="text" class="form-control text-center" style="width: 400px;margin-bottom: 10px;margin-top: 10px;" id="defaultBuyer" name="txtBuyerDefault" value="<?php echo $default[0]['BUYER']?>">
		      		<select id="selectBuyer" name="selectBuyer" class="form-control select2 selectBuyer" style="width:400px;" required="required">
						<option value="" > Pilih Buyer </option>
						<?php foreach ($buyer as $k) { ?>
						<option value="<?php echo $k['NO_INDUK'] ?>"><?php echo $k['NO_INDUK'] ?> - <?php echo $k['NAMA_BUYER'] ?></option>
						<?php } ?>
					</select>
					<textarea placeholder="Masukkan Note untuk Buyer" class="form-control" id="noteForBuyer" name="txaNoteBuyer" style="width: 400px;margin-top: 10px;"><?php echo $param[0]['NOTE_BUYER']?></textarea>
		      	<center>
		      </div>
		    </div>

<script type="text/javascript">
	$( document ).ready(function() {
	$('.selectBuyer').select2({
		  placeholder: 'Pilih',
		  allowClear: true,
		});
})
</script>