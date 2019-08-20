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
						<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/PenjadwalanCatering/Create/'.$encrypted) ?>">
							<div class="box box-primary box-solid">
								<div class="box-header with-border"></div>
								<div class="box-body">
									<div class="form-group">
										<label class="control-label col-lg-4">Tanggal</label>
										<div class="col-lg-4">
											<input type="text" name="txtPeriodePenjadwalanCateringCreate" id="txtPeriodePenjadawalanCateringCreate" class="date form-control" placeholder="Tanggal"  value="" required>
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
													<input type="checkbox" name="checkShift1" value="1"> Shift 1 dan Umum
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12">
													<input type="checkbox" name="checkShift2" value="1"> Shift 2
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12">
													<input type="checkbox" name="checkShift3" value="1"> Shift 3
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-8 text-right">
											<button onclick="goback()" class="btn btn-danger">Batal</button>
											<button type="submit" class="btn btn-primary">Simpan</button>
										</div>
									</div>
									<?php if (isset($hasilcheck)) { ?>
									<div class="form-group">
										<div class="col-lg-12" style="text-align: center">
											<label class="label label-danger" style="font-size: 15pt;"><?php echo $hasilinput['awal']." - ".$hasilinput['akhir']; ?> Data Sudah Ada !</label>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-lg-12">
													<div class="table-responsive">
														<table class="datatable table table-striped table-bordered table-hover text-left">
															<thead class="bg-primary" >
																<tr>
																	<th rowspan="2" style="text-align: center">No</th>
																	<th rowspan="2" style="text-align: center">Tanggal</th>
																	<th colspan="3" style="text-align: center">Lama</th>
																	<th colspan="3" style="text-align: center">Baru</th>
																</tr>
																<tr>
																	<th>Shift 1</th>
																	<th>Shift 2</th>
																	<th>Shift 3</th>
																	<th>Shift 1</th>
																	<th>Shift 2</th>
																	<th>Shift 3</th>
																</tr>
															</thead>
															<tbody>
																<?php $angka=1;foreach ($hasilcheck as $key) { ?>
																	<tr>
																		<td><?php echo $angka ?></td>
																		<td><?php echo $key['fd_tanggal'] ?></td>
																		<td <?php
																		if($key['fs_tujuan_shift1']=='t'){
																			$a = "Kirim";
																		}else{
																			$a = "-";
																		}
																		if($hasilinput['s1']=='1'){
																			$b = "Kirim";
																		}else{
																			$b = "-";
																		}
																		if ($a!==$b) {
																			echo "class='bg-danger'";
																		}

																		 ?>><?php if($key['fs_tujuan_shift1']=='t'){ echo "Kirim";}else{echo "-";} ?></td>
																		<td <?php
																		if($key['fs_tujuan_shift2']=='t'){
																			$a = "Kirim";
																		}else{
																			$a = "-";
																		}
																		if($hasilinput['s2']=='1'){
																			$b = "Kirim";
																		}else{
																			$b = "-";
																		}
																		if ($a!==$b) {
																			echo "class='bg-danger'";
																		}

																		 ?>><?php if($key['fs_tujuan_shift2']=='t'){ echo "Kirim";}else{echo "-";} ?></td>
																		<td <?php
																		if($key['fs_tujuan_shift3']=='t'){
																			$a = "Kirim";
																		}else{
																			$a = "-";
																		}
																		if($hasilinput['s3']=='1'){
																			$b = "Kirim";
																		}else{
																			$b = "-";
																		}
																		if ($a!==$b) {
																			echo "class='bg-danger'";
																		}

																		 ?>><?php if($key['fs_tujuan_shift3']=='t'){ echo "Kirim";}else{echo "-";} ?></td>
																		<td <?php
																		if($key['fs_tujuan_shift1']=='t'){
																			$a = "Kirim";
																		}else{
																			$a = "-";
																		}
																		if($hasilinput['s1']=='1'){
																			$b = "Kirim";
																		}else{
																			$b = "-";
																		}
																		if ($a!==$b) {
																			echo "class='bg-danger'";
																		}

																		 ?>><?php if($hasilinput['s1']=='1'){ echo "Kirim";}else{echo "-";} ?></td>
																		<td <?php
																		if($key['fs_tujuan_shift2']=='t'){
																			$a = "Kirim";
																		}else{
																			$a = "-";
																		}
																		if($hasilinput['s2']=='1'){
																			$b = "Kirim";
																		}else{
																			$b = "-";
																		}
																		if ($a!==$b) {
																			echo "class='bg-danger'";
																		}

																		 ?>><?php if($hasilinput['s2']=='1'){ echo "Kirim";}else{echo "-";} ?></td>
																		<td <?php
																		if($key['fs_tujuan_shift3']=='t'){
																			$a = "Kirim";
																		}else{
																			$a = "-";
																		}
																		if($hasilinput['s3']=='1'){
																			$b = "Kirim";
																		}else{
																			$b = "-";
																		}
																		if ($a!==$b) {
																			echo "class='bg-danger'";
																		}

																		 ?>><?php if($hasilinput['s3']=='1'){ echo "Kirim";}else{echo "-";} ?></td>
																	</tr>
																<?php $angka++;} ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>
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
			var lastday = function(y,month){
				m = new Date(Date.parse(month +"1, 2011")).getMonth();
				return new Date(y,m +1,0).getDate();
			};
			var maxday = lastday('<?php $a = explode(" ",$select["periode"]);echo $a["1"]; ?>','<?php $a = explode(" ",$select["periode"]);echo $a["0"]; ?>')+ " <?php echo $select["periode"] ?>";
			$('#txtPeriodePenjadawalanCateringCreate').daterangepicker({
				"autoUpdateInput": false,
		  		"autoclose": true,
				"todayHiglight": false,
				locale : {
					format: 'DD MMMM YYYY'
				},
				"minDate": '01 <?php echo $select["periode"] ?>',
				"maxDate": maxday,
				"startDate": '01 <?php echo $select["periode"] ?>',
				"endDate": maxday
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
