<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-5">Periode</label>
												<div class="col-lg-3">
													<select id="MPR-transferreffgaji-periode" class="select2" style="width: 100%">
														<option></option>
														<?php if (isset($cutoff) and !empty($cutoff)) {
															$bulan = array (1 =>   'Januari',
																		'Februari',
																		'Maret',
																		'April',
																		'Mei',
																		'Juni',
																		'Juli',
																		'Agustus',
																		'September',
																		'Oktober',
																		'November',
																		'Desember'
																	);

															foreach ($cutoff as $co) {
																echo "<option value='".$co['per']."'>".$bulan[intval($co['bulan'])]." ".$co['tahun']."</option>";
															}
														} ?>
													</select>
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
														  	id="MPR-transferreffgaji-progress">
													    	0%
													  	</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6 pull-right">
													<button type="button" class="btn btn-primary" id="MPR-transferreffgaji-submit">Transfer</button>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 col-lg-offset-2 text-center" id="MPR-transferreffgaji-download">

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
					if(status == 1){
             $.ajax({
              type:'get',
              data: {user: '<?php echo $user; ?>'},
              dataType: 'json',
              url: baseurl + 'MasterPresensi/ReffGaji/TransferReffGaji/cekProgress',
              success: function(data){
              	if (data !== "kosong") {
              		$('#MPR-transferreffgaji-progress').attr('aria-valuenow',data);
	                $('#MPR-transferreffgaji-progress').css('width',data+'%');
	                $('#MPR-transferreffgaji-progress').text(data+' %');
              	}
              }
            });
					}
        },1000);
    });
</script>
