<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?=$Title ?></b></h1>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="<?php echo site_url('CateringManagement/PengajuanLibur'); ?>" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/PengajuanLibur/Create/'.$encrypted_link) ?>">
											<?php if (isset($check)) { ?>
												<div class="form-group">
													<div class=" col-lg-12 text-center">
														<label class="label label-danger">Catering Libur atau Catering Pengganti Sudah Ada Pada Tanggal Tersebut !!</label>
													</div>
												</div>
											<?php }
											?>
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal</label>
												<div class="col-lg-4">
													<input type="text" name="txtPengajuanLiburCateringCreate" id="txtPengajuanLiburCateringCreate" class="date form-control" placeholder="Tanggal"  value="" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Catering Libur</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtLiburCatering" style="width: 100%" data-placeholder="Catering Libur" required>
														<option></option>
														<?php foreach ($Catering as $key) { ?>
															<option value="<?php echo $key['fs_kd_katering'] ?>"><?php echo $key['fs_nama_katering'] ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Catering Pengganti</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtPenggantiCatering" style="width: 100%" data-placeholder="Catering Pengganti" required>
														<option></option>
														<?php foreach ($Catering as $key) { ?>
															<option value="<?php echo $key['fs_kd_katering'] ?>"><?php echo $key['fs_nama_katering'] ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<button class="btn btn-primary" type="submit">Tambah</button>
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
	<script type="text/javascript">
		$(function(){
			var lastday = function(y,month){
				m = new Date(Date.parse(month +"1, 2011")).getMonth();
				return new Date(y,m +1,0).getDate();
			};
			var maxday = lastday('<?php $a = explode(" ",$periode);echo $a["1"]; ?>','<?php $a = explode(" ",$periode);echo $a["0"]; ?>')+ " <?php echo $periode ?>";
			$('#txtPengajuanLiburCateringCreate').daterangepicker({
				"autoUpdateInput": true,
		  		"autoclose": true,
				"todayHiglight": false,
				locale : {
					format: 'DD MMMM YYYY'
				},
				"minDate": '01 <?php echo $periode ?>',
				"maxDate": maxday
	  		});
			$('input[id="txtPengajuanLiburCateringCreate"]').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('DD MMMM YYYY') + ' - ' + picker.endDate.format('DD MMMM YYYY'));
			});
		  	$('input[id="txtPengajuanLiburCateringCreate"]').on('cancel.daterangepicker', function(ev, picker) {
				$(this).val('');
			});
		});
	</script>
</section>