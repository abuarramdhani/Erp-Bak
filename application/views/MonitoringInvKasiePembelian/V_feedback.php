    <div class="row">
		      <div class="col-md-12">
		      	<center>
		      		<table>
							<tr>
								<td style="padding-right: 10px">
									<span><label>Invoice ID</label></span>
								</td>
								<td style="padding-bottom:10px">
									<input type="text" class="form-control" value="<?php echo $invoice ?>" disabled>
								</td>
							</tr>
							<tr>
								<td style="padding-right:10px">
									<span><label>Feedback Purchasing</label></span>
								</td>
								<td>
									<textarea id="txaFbPurc" class="form-control" style="width:300px; margin-bottom:10px"><?php echo $feedback[0]['FEEDBACK_PURCHASING']?></textarea>
									<input id="hdnBerkasPurc" type="hidden" value="<?php echo $feedback[0]['STATUS_BERKAS_PURC']?>">
								</td>
							</tr>
						</table>
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