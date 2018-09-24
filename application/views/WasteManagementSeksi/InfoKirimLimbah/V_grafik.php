<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?=$Title; ?></b></h1>
						</div>
						<div class="col-lg-1">
							<a href="<?php echo site_url('WasteManagementSeksi/InfoKirimLimbah') ?>" class="btn btn-default btn-lg">
								<i class="icon-wrench icon-2x"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								
							</div>
							<div class="box-body">
								<form method="POST" action="<?php echo site_url('WasteManagementSeksi/InfoKirimLimbah/Grafik') ?>" class="form-horizontal">
									<div class="panel-body">
										<div class="row">
											
											<div class="form-group">
												<label class="form-label col-lg-2">Periode</label>
											</div>
											<div class="form-group">
												<div class="col-lg-4">
													<input type="text" name="txtPeriodeInfo" id="txtPeriodeInfo" class="date form-control" value="<?php echo $periode; ?>" data-date-format="yyyy-mm-dd" required>
												</div>
											</div>
											<div class="form-group">
												<label class="form-label col-lg-2">Berdasarkan</label>
											</div>
											<div class="form-group">
												<div class="col-lg-4">
													<select class="select select2" name="txtPilihKat" id="txtPilihKat" data-placeholder="Kategori" style="width:100%;">
														<?php 
															if ($kategori == 'seksi') { ?>
																<option value="seksi">Nama Seksi</option>
																<option value="limbah">Jenis Limbah</option>
															<?php }else{ ?>
																<option value="limbah">Jenis Limbah</option>
																<option value="seksi">Nama Seksi</option>
															<?php }
														?>
													
													
												</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-4">
													<select class="select select2 col-lg-8" name="txtValueSek" id="txtValueSek" data-placeholder="Nama Seksi" style="width:100%;" <?php if($kategori !== 'seksi'){echo "disabled";} ?> >
														<?php if($kategori == 'seksi'){ 
															echo "<option value='$value'>$text</option>"; 
															}else{ ?>
															<option></option>
														<?php } ?>
														<?php foreach ($seksi as $key) {
															$a = $key['section_code'];
															$b = $key['section_name'];
															echo "<option value='$a'>$a - $b</option>";
														} 
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-4">
													<select class="select select2" name="txtValueLim" id="txtValueLim" data-placeholder="Jenis Limbah" style="width:100%;"  <?php if($kategori !== 'limbah'){echo "disabled";} ?> >
														<?php if($kategori == 'limbah'){ 
															echo "<option value='$value'>$text</option>"; 
															}else{ ?>
															<option></option>
														<?php } ?>
														<?php foreach ($limbah as $key) {
															$a = $key['id_jenis_limbah'];
															$b = $key['jenis_limbah'];
															$c = $key['kode_limbah'];
															echo "<option value='$a'>$c - $b</option>";
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-4 text-right">
													<input type="hidden" name="txtHiddenValue" id="txtHiddenValue" value="<?php echo $text; ?>">
													<button type="submit" class="btn btn-primary" onclick="showChart();">Proses</button>
												</div>
											</div>
											<div class="form-group">
												<div class="chart-container" style="position: relative;width: 30%;margin: 0 auto;">
													<canvas id="chartInfoLimbahPie"></canvas>
												</div>
												<div class="chart-container" style="position: relative;width: 90%;margin: 0 auto;">
													<canvas id="chartInfoLimbahBar"></canvas>
												</div>
												<div id="colorInfo"></div>
											</div>
											<div class="form-group">
												<div class="panel-body">
													<div class="table-responsive">
														<table class="datatable table table-bordered table-hover table-striped text-left dataTable-limbah">
															<thead class="bg-primary">
																<th>No</th>
																<th><?php if($kategori == 'limbah'){echo "Nama Seksi";}else{echo "Jenis Limbah";} ?></th>
																<th>Berat</th>
															</thead>
															<tbody>
																<?php 
																	$a = 1;
																	foreach ($tabel as $value) {
																		echo "<tr><td>".$a."</td>";
																		if ($kategori == 'limbah') {
																			echo "<td>".$value['section_name']."</td>";
																		}else{
																			echo "<td>".$value['jenis_limbah']."</td>";
																		}
																		echo "<td>".$value['berat']." Kg</td></tr>";
																		$a++;
																	}
																?>
															</tbody>
														</table>
													</div>
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
		</div>
	</div>
<script type="text/javascript">
	$(window).load(function(){
		showChart();
	});
</script>
</section>