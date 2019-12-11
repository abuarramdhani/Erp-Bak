<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right ini_approve"><h1><b><?= $Title ?></b></h1></div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('PolaShiftSeksi/ImportPolaShift');?>">
									<i class="icon-wrench icon-2x"></i>
									<span ><br /></span>
								</a>                             
							</div>
						</div>
					</div>
				</div>
				<br />

				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right"><h1><b></b></h1></div>
						</div>
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-1">
										<div class="form-group">
											<label class="control-label">Seksi</label>
											<label class="control-label">Periode</label>
										</div>
									</div>
									<div class="col-lg-5">
										<div class="form-group">
											<label class="control-label">: <?= $seksi[0]['daftar_tseksi'] ?></label> <br>
											<label class="control-label">: <?= $periode ?></label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<script>
						var arrayJs = <?php echo $arrayJav ?>;
						var tgl_imp = '<?php echo $tgl_imp ?>';
						var periode = '<?php echo $periode ?>';
						var kode_seksi = '<?php echo $kode_seksi ?>';
					</script>
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
											<div class="<?= $calaut ?>">
												<?= $pesan ?>
											</div>
										</div>
										<div class="col-md-12">
											<table>
												<tr>
													<td style="background-color: #8bc34a; width: 30px; height: 30px;"></td>
													<td width="25%" style="padding-left: 10px; font-weight: bold;">Insert</td>
													<td style="background-color: #ffeb3b; width: 30px; height: 30px;"></td>
													<td width="25%" style="padding-left: 10px; font-weight: bold;">Update</td>
													<td style="background-color: #f44336; width: 30px; height: 30px;"></td>
													<td width="25%" style="padding-left: 10px; font-weight: bold;">Delete</td>
												</tr>
											</table>
										</div>
										<div class="col-md-12">
											<h3 style="font-weight: bold;">Data ERP</h3>
											<table class="table table-bordered tabel_polashiftInit">
												<thead>
													<tr>
														<th class="text-center" style="vertical-align: middle;" rowspan="2">No</th>
			                                            <th class="text-center" style="vertical-align: middle;" rowspan="2">Noind</th>
			                                            <th class="text-center" style="vertical-align: middle;" rowspan="2">Nama</th>
			                                            <th class="text-center" style="vertical-align: middle;" colspan="31">Tanggal</th>
													</tr>
													<tr class="">
													<?php for ($i=1; $i <= $tgl_akhir; $i++) { ?>
														<th data-orderable="false" class="text-center ips_head" style="vertical-align: middle;"><?php echo $i ?></th>
													<?php } ?>
													</tr>
												</thead>
												<tbody>
													<?php $n = 1; for($j=0; $j<count($arrayPkj); $j++): ?>
														<tr>
															<td><?php echo $n ?></td>
															<td><?php echo $arrayPkj[$j]['noind'] ?></td>
															<td><?php echo $arrayPkj[$j]['nama'] ?></td>
															<?php for ($i=1; $i <= $tgl_akhir; $i++) { 
																if ($periode == date('Y-m')) {
																	if ($i <= intval(date('d'))) {
																		$color = 'background-color : #546e7a;';
																	}else{
																		$color = '';
																	}
																}
																$v = array_search($i, $arrayPkj[$j]['tgl']); ?>
																<?php if ($v === false): ?>
																	<td class="Erp<?= $arrayPkj[$j]['noind'] ?>" data-tgl="<?= $i; ?>"></td>
																<?php else: ?>
																	<td class="Erp<?= $arrayPkj[$j]['noind'] ?>" data-tgl="<?= $i; ?>"><?php echo $arrayPkj[$j]['shift'][$v] ?></td>
																<?php endif ?>
															<?php } ?>
														</tr>
													<?php $n++; endfor ?>
												</tbody>
											</table>
										</div>
										<div class="col-md-12">
											<h3 style="font-weight: bold;">Data Personalia</h3>
											<table class="table table-bordered tabel_polashiftInit">
												<thead>
													<tr>
														<th class="text-center" style="vertical-align: middle;" rowspan="2">No</th>
			                                            <th class="text-center" style="vertical-align: middle;" rowspan="2">Noind</th>
			                                            <th class="text-center" style="vertical-align: middle;" rowspan="2">Nama</th>
			                                            <th class="text-center" style="vertical-align: middle;" colspan="31">Tanggal</th>
													</tr>
													<tr class="">
													<?php for ($i=1; $i <= $tgl_akhir; $i++) { ?>
														<th data-orderable="false" class="text-center ips_head" style="vertical-align: middle;"><?php echo $i ?></th>
													<?php } ?>
													</tr>
												</thead>
												<tbody>
													<?php $n = 1; for($j=0; $j<count($arrayPkjP); $j++): ?>
														<tr>
															<td><?php echo $n ?></td>
															<td><?php echo $arrayPkjP[$j]['noind'] ?></td>
															<td><?php echo $arrayPkjP[$j]['nama'] ?></td>
															<?php for ($i=1; $i <= $tgl_akhir; $i++) { 
																$v = array_search($i, $arrayPkjP[$j]['tgl']); 
																 ?>
																<?php if ($v === false): ?>
																	<td class="Pers<?= $arrayPkjP[$j]['noind'] ?>"></td>
																<?php else: ?>
																	<td class="Pers<?= $arrayPkjP[$j]['noind'] ?>"><?php echo $arrayPkjP[$j]['shift'][$v] ?></td>
																<?php endif ?>
															<?php } ?>
														</tr>
													<?php $n++; endfor ?>
												</tbody>
											</table>
										</div>
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
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
	<img src="<?php echo site_url('assets/img/gif/loadingtwo.gif');?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>