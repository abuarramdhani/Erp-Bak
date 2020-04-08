<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?=$Title ?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-sm hidden-md hidden-xs">
								<a href="" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header">
								
							</div>
							<div class="box-body">
								<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/PenjadwalanOtomatis/Proses') ?>">
									<div class="row">
										<div class="col-lg-12">
											<div class="form-group">
												<label class="control-label col-lg-4">Periode</label>
												<div class="col-lg-4">
													<input type="text" name="txtperiodePenjadwalanOtomatis" id="txtperiodePenjadwalanOtomatis" class="date form-control" placeholder="Bulan Tahun" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Lokasi</label>
												<div class="col-lg-4">
													<select class="select2" name="txtlokasiPenjadwalanOtomatis" style="width: 100%" required>
														<option></option>
														<option value="1">Pusat & Mlati</option>
														<option value="2">Tuksono</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<button class="btn btn-primary" type="submit">Jadwalkan</button>
												</div>
											</div>
											<div class="form-group">
												<?php 
													if (isset($sukses)) { ?>
														<div class="col-lg-12 text-center">
															<label class="label label-success" style="font-size: 20pt;"><?php echo $sukses; ?> Sukses dijadwalkan</label>
														</div>
												<?php } ?>
											</div>
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

	<script type="text/javascript">
		$(function(){
			$('#txtperiodePenjadwalanOtomatis').datepicker({
		      "autoclose": true,
		      "todayHiglight": true,
		      "format":'MM yyyy',
		      "viewMode":'months',
		      "minViewMode":'months',
		      "startDate": '<?php echo $tanggal['0']['tanggal'] ?>' ,
		      "minDate": '<?php echo $tanggal['0']['tanggal'] ?>'
		});
		});
	</script>
</section>