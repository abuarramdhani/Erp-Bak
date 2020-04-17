<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1>
									<b>
										<?=$Title ?>
									</b>
								</h1>
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
													<input type="text" value="<?php echo $seksi['0']['kodesie'] ?>" class="form-control" name="txtKodesie" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Seksi</label>
												<div class="col-lg-4">
													<input type="text" value="<?php echo $seksi['0']['seksi'] ?>" class="form-control" name="txtKodesie" disabled>
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

											<?php if(base_url('')=="http://erp.quick.com/") : ?>
											<?php else: ?>
											<?php endif; ?>
												<button id="showData" class="btn btn-primary"><span style="font-size: 16px;"></span>Show Data</button>
													<button id="presensiH-btnExcel_v1" class="btn btn-success"><span style="font-size: 16px;" class="fa fa-file-excel-o"></span> - Template 1 </button>
													<button id="presensiH-btnExcel_v2" class="btn btn-success"><span style="font-size: 16px;" class="fa fa-file-excel-o"></span> - Template 2</button>
													<button id="presensiH-btnPDF_v1" class="btn btn-info"><span style="font-size: 16px;" class="fa fa-file-pdf-o"></span> - Template 1 </button>
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
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table id="tbl_showdata" class="table table-striped table-bordered table-hovered" width="100%">
											<thead>
												<tr>
													<th>No</th>
													<th>No Induk</th>
													<th style="text-align: center;">Nama</th>
													<th width="11%" style="text-align: center;">Tanggal</th>
													<th width="10%">Shift</th>
													<th width="6%">Point</th>
													<th style="text-align: center;" colspan="<?php echo $max ?>">Waktu</th>
													<th >Keterangan</th>
												</tr>
											</thead>
											<tbody>
											<?php
													$no=1;
													foreach ($pekerja as $key) {
														?>

															<?php
														foreach ($key['data'] as $shi) {

																?>
																<tr>
																	<td style="text-align: center;"><?php echo $no; ?></td>
																	<td style="text-align: center;"><?php echo $key['noind']; ?></td>
																	<td style=""><?php echo $key['nama']; ?></td>
																	<td style="text-align: center;"><?php echo $shi['tgl']; ?></td>
																	<td><?php echo $shi['shift']; ?></td>
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
																			foreach ($shi['wkt'] as $wkt) { ?>
																			<td><?php echo $wkt; ?></td>
																		<?php $angka++;
																			}
																		}else{
																			echo "<td></td>";
																		}

																		if ($angka < $max) {
																			for ($i=0; $i < $max - $angka; $i++) {
																				echo "<td></td>";
																			}
																		}
																	?>
																	<?php if (isset($shi['ket']) and !empty($shi['ket'])) {
																		foreach ($shi['ket'] as $ket) { ?>
																			<td><?php echo $ket; ?></td>
																		<?php }
																		}else{
																			echo "<td></td>";
																		}
																	?>
																</tr>
																<?php
																$no++;

														}
														?>

														<?php
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
	$(document).ready(function(e){
		$('#tbl_showdata').DataTable();
		$("button#showData").on('click',function(){
			$("#form_presensiH").attr('action','<?php echo base_url(); ?>AdmCabang/PresensiHarian/showData');
			$("#form_presensiH").attr('target','');
			$("#form_presensiH").submit()
		})
	})
</script>
