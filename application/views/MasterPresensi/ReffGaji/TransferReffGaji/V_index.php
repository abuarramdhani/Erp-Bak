<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header">
								Pekerja Biasa
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-5">Periode Cutoff</label>
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
											<div class="form-group MPR-transferreffgaji-progress-form-group" style="display: none">
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
											<div class="form-group MPR-transferreffgaji-progress-form-group" style="display: none">
												<div class="col-lg-6 col-lg-offset-3 text-center">
													<h4 id="MPR-transferreffgaji-progress-keterangan"></h4>
												</div>
											</div>
											<div class="form-group MPR-transferreffgaji-submit-form-group">
												<label class="control-label col-lg-5">No. Memo Non-Staff</label>
												<div class="col-lg-3">
													<input type="text" id="txt-MPR-transferreffgaji-memo-nonstaff" class="form-control" placeholder="No. Memo Non-Staff">
												</div>
											</div>
											<div class="form-group MPR-transferreffgaji-submit-form-group">
												<label class="control-label col-lg-5">No. Memo Staff</label>
												<div class="col-lg-3">
													<input type="text" id="txt-MPR-transferreffgaji-memo-staff" class="form-control" placeholder="No. Memo Staff">
												</div>
											</div>
											<div class="form-group MPR-transferreffgaji-submit-form-group">
												<div class="col-lg-6 col-lg-offset-3 text-center">
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
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Pekerja Khusus
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" target="_blank" action="<?php echo site_url('MasterPresensi/ReffGaji/TransferReffGaji/prosesKhusus') ?>">
											<div class="form-group">
												<label class="control-label col-lg-5">Periode Cutoff</label>
												<div class="col-lg-3">
													<select class="select2" name="MPR-transferreffgaji-khusus-periode" style="width: 100%">
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
												<label class="control-label col-lg-5">Pekerja Khusus</label>
												<div class="col-lg-3">
													<select class="select2" data-placeholder="Pekerja Khusus" id="MPR-transferreffgaji-khusus-noind" name="MPR-transferreffgaji-khusus-noind" style="width: 100%"></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-5">Atasan Mengetahui</label>
												<div class="col-lg-3">
													<select class="select2" style="width: 100%" id="MPR-transferreffgaji-khusus-noind-atasan" name="MPR-transferreffgaji-khusus-noind-atasan" data-placeholder="Atasan Mengetahui"></select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-7 text-right">
													<button type="submit" class="btn btn-success"><span class="fa fa-file-excel-o"></span>Export</button>
												</div>
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
				$('.MPR-transferreffgaji-submit-form-group').hide();
				$('.MPR-transferreffgaji-progress-form-group').show();
	            $.ajax({
					type:'get',
					data: {user: '<?php echo $user; ?>'},
					dataType: 'json',
					url: baseurl + 'MasterPresensi/ReffGaji/TransferReffGaji/cekProgress',
					success: function(data){
	              	if (data !== "kosong") {
	              		$('#MPR-transferreffgaji-progress').attr('aria-valuenow',data.progress);
		                $('#MPR-transferreffgaji-progress').css('width',data.progress+'%');
		                $('#MPR-transferreffgaji-progress').text(data.progress+' % ');
		                $('#MPR-transferreffgaji-progress-keterangan').text(data.keterangan);
	              	}
	              }
	            });
			}else{
				$('.MPR-transferreffgaji-progress-form-group').hide();
				$('.MPR-transferreffgaji-submit-form-group').show();
			}
        },1000);
    });
</script>
