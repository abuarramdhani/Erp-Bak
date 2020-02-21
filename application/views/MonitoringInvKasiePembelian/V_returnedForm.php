    <div class="row">
		      <div class="col-md-12">
		      	<center>
		      		<table>
							<tr>
								<td style="padding-right: 10px">
									<span><label>Invoice ID</label></span>
								</td>
								<td style="padding-bottom:10px">
									<input type="text" class="form-control" disabled>
								</td>
							</tr>
							<tr>
								<td style="padding-right:10px">
									<span><label>Feedback Returned Invoice</label></span>
								</td>
								<td>
									<textarea id="txaFbPurc" class="form-control" style="width:300px; margin-bottom:10px"></textarea>
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