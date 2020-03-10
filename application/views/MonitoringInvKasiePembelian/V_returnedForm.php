    <div class="row">
		      <div class="col-md-12">
		      	<center>
		      		<table>
							<tr>
								<td style="padding-right: 10px">
									<span><label>Invoice ID</label></span>
								</td>
								<td style="padding-bottom:10px">
									<input type="text" class="form-control" value="<?php echo $show[0]['INVOICE_ID']?>" disabled>
								</td>
							</tr>
							<tr>
								<td style="padding-right:10px">
									<span><label>Feedback Returned Invoice</label></span>
								</td>
								<td>
									<textarea id="txaReturnPurc" class="form-control" style="width:300px; margin-bottom:10px"><?php echo $show[0]['NOTE_RETURN_PURC']?></textarea>
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