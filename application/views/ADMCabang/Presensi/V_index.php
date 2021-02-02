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
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" id="form_presensiH" target="_blank" method="post">
											<div class="form-group">
												<label class="control-label col-lg-4">Kodesie</label>
												<div class="col-lg-4">
													<input type="text" value="<?= $seksi['0']['kodesie'] ?>" class="form-control" name="txtKodesie" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Seksi</label>
												<div class="col-lg-4">
													<input type="text" value="<?= $seksi['0']['seksi'] ?>" class="form-control" name="txtKodesie" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Periode</label>
												<div class="col-lg-4">
													<input type="text" class="date form-control" name="txtPeriodePresensiHarian" id="txtPeriodePresensiHarian" autocomplete="off" required>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-10 text-right">
												<?php if(base_url('')=="http://erp.quick.com/") : else: endif; ?>
													<button type="button" id="showData" class="btn btn-primary"><span style="font-size: 16px;"></span>Show Data</button>
													<button type="button" id="presensiH-btnExcel_v1" class="btn btn-success"><span style="font-size: 16px;" class="fa fa-file-excel-o"></span> - Template 1 </button>
													<button type="button" id="presensiH-btnExcel_v2" class="btn btn-success"><span style="font-size: 16px;" class="fa fa-file-excel-o"></span> - Template 2</button>
													<button type="button" id="presensiH-btnPDF_v1" class="btn btn-info"><span style="font-size: 16px;" class="fa fa-file-pdf-o"></span> - Template 1 </button>
													<button id="presensiH-btnPDF_v2" class="btn btn-info"><span style="font-size: 16px;" class="fa fa-file-pdf-o"></span> - Template 2</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php if(!empty($pekerja)) : ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="dataTable table table-striped table-bordered table-hovered tabel_shower table-fit no-footer"width="100%">
												<thead class="bg-primary">
													<tr>
														<th rowspan="2">No</th>
														<th rowspan="2">No Induk</th>
														<th rowspan="2" style="text-align: center;">Nama</th>
														<th rowspan="2" width="11%" style="text-align: center;">Tanggal</th>
														<th rowspan="2" width="10%">Shift</th>
														<th rowspan="2" width="6%">Point</th>
														<th style="text-align: center;" colspan="<?= $max ?>">Waktu</th>
														<th rowspan="2" >Keterangan</th>
													</tr>
													<tr>
														<?php
														$no = 1;
														for ($i=0; $i < $max ; $i++) {
															if ($i <= $max) {
																echo "<th>Waktu ".($i+1)."</th>";
															}
														}
														if ($max == '0') {
															echo "<th>Waktu</th>";
														}
														?>
													</tr>
												</thead>
												<tbody>
												<?php
													foreach ($pekerja as $key) {
														foreach ($key['data'] as $shi) {?>
																<tr>
																	<td style="text-align: center;"><?= $no++; ?></td>
																	<td style="text-align: center;"><?= $key['noind']; ?></td>
																	<td style=""><?= $key['nama']; ?></td>
																	<td data-order="<?= $shi['tgl2']?>" style="text-align: center;"><?= $shi['tgl']; ?></td>
																	

																	<td><?= $shi['shift']; ?></td>
																	<td><?php
																		if (isset($shi['tim']) and !empty($shi['tim'])) {
																			foreach ($shi['tim'] as $tims) {
																				echo $tims;
																			}
																		}
																	 ?></td>
																	<?php
																		$angka = 0;
																		if (isset($shi['wkt']) and !empty($shi['wkt'])) {
																			foreach ($shi['wkt'] as $wkt) {
																				echo "<td>".$wkt."</td>";
																				$angka++;
																			}
																		}else if($max == '0' || $angka = '0'){
																			echo "<td></td>";
																		}

																		if ($angka < $max) {
																			for ($i=0; $i < $max - $angka; $i++) {
																				echo "<td></td>";
																			}
																		}

																		$ketket = '';
																		if (isset($shi['ket']) and !empty($shi['ket'])) {
																			foreach ($shi['ket'] as $ket) {
																					$ketket .= $ket.'<br>';
																			}
																			echo "<td>".$ketket."</td>";
																		}else if(empty($shi['ket'])){
																			echo "<td></td>";
																		} ?>
																	</tr>
																	<?php
																}
															}
														?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> <!-- End Row -->
			<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$(document).ready(function(){
		$('.tabel_shower').dataTable();
		$("button#showData").on('click',function(){
			$("#form_presensiH").attr('action','<?= base_url(); ?>AdmCabang/PresensiHarian');
			$("#form_presensiH").attr('target','');
			$("#form_presensiH").submit()
		})
	})
</script>
