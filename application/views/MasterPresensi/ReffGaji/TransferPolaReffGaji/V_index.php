<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header">
								<div class="row">
									<div class="col-lg-12 text-right"><h4>TRANSFER POLA REFF GAJI</h4></div>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal</label>
												<div class="col-lg-2">
													<input type="text" class="txtpolareffgaji form-control" name="txttglpolareffgajiawal" id="txttglpolareffgajiawal">
												</div>
												<label class="control-label col-lg-1" style="text-align: center">-</label>
												<div class="col-lg-2">
													<input type="text" class="txtpolareffgaji form-control" name="txttglpolareffgajiakhir" id="txttglpolareffgajiakhir">
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6 col-lg-offset-3">
													<div class="progress">
													  	<div
														  	class="progress-bar progress-bar-striped active"
														  	role="progressbar"
														  	aria-valuenow="40"
														  	aria-valuemin="0"
														  	aria-valuemax="100"
														  	style="width:0%"
														  	id="MPR-transferpolareffgaji-progress">
													    	0%
													  	</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6 pull-right">
													<button type="button" class="btn btn-danger disabled" id="MPR-transferpolareffgaji-submit">
														Transfer
													</button>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 col-lg-offset-2 text-center" id="MPR-transferpolareffgaji-download">

												</div>
											</div>
											<div>
												<input value="0" type="hidden" id="MPR-status-Read">
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$(document).ready(function(){
        setInterval(function(){
						status = $('#MPR-status-Read').val();
						// if(status == 1){
							$.ajax({
               type:'get',
               data: {user: '<?php echo $user; ?>'},
               dataType: 'json',
               url: baseurl + 'MasterPresensi/ReffGaji/TransferPolaReffGaji/cekProgress',
               success: function(data){
               	if (data !== "kosong") {
               		$('#MPR-transferpolareffgaji-progress').attr('aria-valuenow',data);
 	                $('#MPR-transferpolareffgaji-progress').css('width',data+'%');
 	                $('#MPR-transferpolareffgaji-progress').text(data+' %');
               	}
               }
             });
						// }

        },1000);
    });
</script>
