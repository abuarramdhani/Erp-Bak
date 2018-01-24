<section class="content">
	<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Hubungan Kerja</b></h1>
						
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('FixedAsset/DataAssets');?>">
                                <i class="fa fa-bookmark fa-2x"></i>
                                <span ><br /></span>
                            </a>
							
						</div>
					</div>
				</div>
			</div>
			<br />
		<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb text-right">
				<li class ="active"><?php echo date('d F Y') ?></a></li>
				<li class ="active"><span id="clockbox"><?php echo date('H:i:s') ?></span></li>
				<li class ="active">Rekap Bon Pekerja</li>
			</ol>
		</div>
			<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						Rekap Bon Pekerja yang Belum Terbayar 
					</div>
					
					<div class="box-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed" id="wr-rekapbon">
								<thead class="bg-blue">
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">No Induk</th>
										<th class="text-center">Nama</th>
										<th class="text-center">Seksi</th>
										<th class="text-center">No Invoice</th>
										<th class="text-center">Tgl Invoice</th>
										<th class="text-center">Jumlah</th>
										<th class="text-center">Deskripsi</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($bon as $key => $bon_data): ?>
									<tr>
										<td><?php echo $key+1; ?></td>
										<td><?php echo $bon_data['NOIND']; ?></td>
										<td><?php echo $bon_data['NAMA']; ?></td>
										<td>
											<table>
												<tr>
													<td>Dept</td>
													<td>:</td>
													<td><?php echo $bon_data['DEPT']; ?></td>
												</tr>
												<tr>
													<td>Bidang</td>
													<td>:</td>
													<td><?php echo $bon_data['BIDANG']; ?></td>
												</tr>
												<tr>
													<td>Unit</td>
													<td>:</td>
													<td><?php echo $bon_data['UNIT']; ?></td>
												</tr>
												<tr>
													<td>Seksi</td>
													<td>:</td>
													<td><?php echo $bon_data['SEKSI']; ?></td>
												</tr>
											</table>
										</td>
										<td><?php echo $bon_data['INVOICE_NUM']; ?></td>
										<td><?php echo $bon_data['INVOICE_DATE']; ?></td>
										<td><?php echo $bon_data['INVOICE_CURRENCY_CODE'].' '.number_format($bon_data['INVOICE_AMOUNT'], 2, ',', '.'); ?></td>
										<td><?php echo $bon_data['DESCRIPTION']; ?></td>
									</tr>
									<?php endforeach; ?>
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
</section>