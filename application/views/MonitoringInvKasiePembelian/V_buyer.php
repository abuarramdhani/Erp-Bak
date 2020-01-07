    <div class="row">
		      <div class="col-md-12">
		      	<input type="hidden" value="">
		      	<center>
		      		<select id="selectBuyer" name="selectBuyer" class="form-control select2 selectBuyer" style="width:400px;" required="required">
						<option value="" > Pilih  </option>
						<?php foreach ($buyer as $k) { ?>
						<option value="<?php echo $k['NO_INDUK'] ?>"><?php echo $k['NO_INDUK'] ?> - <?php echo $k['NAMA_BUYER'] ?></option>
						<?php } ?>
					</select>
		      	</select>
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