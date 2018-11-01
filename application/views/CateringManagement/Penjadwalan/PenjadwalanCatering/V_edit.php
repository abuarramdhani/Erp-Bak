<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right"><h1><b><?=$Title ?></b></h1></div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="<?php echo site_url('CateringManagement/PenjadwalanCatering') ?>" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/PenjadwalanCatering/Edit/'.$encrypted) ?>">
							<div class="box box-primary box-solid">
								<div class="box-header with-border"></div>
								<div class="box-body">
									<div class="form-group">
										<label class="control-label col-lg-4">Tanggal</label>
										<div class="col-lg-4">
											<input type="text" name="txtPeriodePenjadwalanCateringCreate" id="txtPeriodePenjadawalanCateringCreate" class="date form-control" placeholder="Tanggal" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4">Katering</label>
										<div class="col-lg-4">
											<input type="text" name="txtkatering" value="<?php foreach($katering as $key){
												if($key['fs_kd_katering'] == $select['kode']){
													echo $key['fs_kd_katering']." - ".$key['fs_nama_katering'];
												}
											} ?>" class="form-control" disabled>
										</div>
									</div>
									<div class="form-group">
										<label  class="control-label col-lg-4">Shift Yang Dilayani</label>
										<div class="col-lg-4">
											<div class="form-group">
												<div class="col-lg-12">
													<input type="checkbox" name="checkShift1" value="1" <?php if($select['s1']=='Kirim'){echo "checked";} ?>> Shift 1 dan Umum
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12">
													<input type="checkbox" name="checkShift2" value="1" <?php if($select['s2']=='Kirim'){echo "checked";} ?>> Shift 2
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12">
													<input type="checkbox" name="checkShift3" value="1" <?php if($select['s3']=='Kirim'){echo "checked";} ?>> Shift 3
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-8 text-right">
											<button type="submit" class="btn btn-primary">Simpan</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>					
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function(){
			$('#txtPeriodePenjadawalanCateringCreate').daterangepicker({
				"autoUpdateInput": true,
		  		"autoclose": true,
				"todayHiglight": false,
				locale : {
					format: 'DD MMMM YYYY'
				},
				"minDate": '01 <?php echo $select["bulan2"] ?>',
				"maxDate": '<?php echo $select['bulan'] ?>',
				"startDate": '<?php echo $select["awal"] ?>',
				"endDate": '<?php echo $select["akhir"] ?>'
	  		});
			$('input[id="txtPeriodePenjadawalanCateringCreate"]').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('DD MMMM YYYY') + ' - ' + picker.endDate.format('DD MMMM YYYY'));
			});
		  	$('input[id="txtPeriodePenjadawalanCateringCreate"]').on('cancel.daterangepicker', function(ev, picker) {
				$(this).val('');
			});
		});
	</script>
</section>