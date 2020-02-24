<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><?=$Title ?></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<div class="row">
									<div class="col-lg-12"></div>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="<?php echo site_url('WorkRelationship/RekapBon/ProsesKeluar') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Periode Pekerja Keluar</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" name="txtTanggalKeluarWR" id="txtTanggalKeluarWR" value="<?php if(isset($tanggal)){echo $tanggal;} ?>">
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<button type="submit" class="btn btn-primary">Rekap</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<?php 
										if (isset($bon) and !empty($bon)) {
											?>
											<table class="table table-bordered table-striped table-condensed" id="wr-rekapbon">
												<thead class="bg-blue">
													<tr>
														<th class="text-center">No</th>
														<th class="text-center">No Induk</th>
														<th class="text-center">Nama</th>
														<th class="text-center">Seksi</th>
														<th class="text-center" style="width: 13%">Jumlah Invoice</th>
														<th class="text-center" style="width: 13%">Jumlah Yang Belum Terbayar</th>
														<th class="text-center">Deskripsi</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($bon as $key => $bon_data): ?>
													<tr>
														<td><?php echo $key+1; ?></td>
														<?php 
															foreach ($pekerja as $key => $pekerja_data) {
																if($bon_data['VENDOR_SITE_CODE'] == $pekerja_data['noind']){
																?>
																	<td><?php echo $pekerja_data['noind']; ?></td>
																	<td><?php echo $pekerja_data['nama']; ?></td>
																	<td><?php echo $pekerja_data['seksi']; ?></td>
																<?php
																}
															}
														?>
														<td><span class="pull-right"><?php echo number_format($bon_data['AMOUNT_IDR'], 2, ',', '.'); ?></span></td>
														<td style="background-color: #FEF8B5;"><span class="pull-right"><?php echo number_format($bon_data['SALDO_PREPAYMENT'], 2, ',', '.'); ?></span></td>
														<td><?php echo $bon_data['DESCRIPTION']; ?></td>
													</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
											<?php 
										}
										?>
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