    <div class="row">
		      <div class="col-md-12">
		      	<center>
		      		<table>
							<tr>
								<td style="padding-right: 10px">
									<span><label>Judul Proposal</label></span>
								</td>
								<td style="padding-bottom:10px">
									<input type="text" class="form-control" value="<?php echo $mdl[0]['batch_number'].'.pdf' ?>" disabled>
									<input type="hidden" id="batch_number" class="form-control" value="<?php echo $mdl[0]['batch_number'] ?>">
									<input type="hidden" id="id_proposal" class="form-control" value="<?php echo $mdl[0]['id_proposal'] ?>">
									<input type="hidden" id="status" class="form-control" value="3">
								</td>
							</tr>
							<tr>
								<td style="padding-right:10px">
									<span><label>Feedback Proposal</label></span>
								</td>
								<td>
									<textarea id="textFeedbackAC" class="form-control" style="width:300px; margin-bottom:10px"></textarea>
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