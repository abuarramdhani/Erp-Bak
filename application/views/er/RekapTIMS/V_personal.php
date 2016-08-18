<?php foreach ($info as $info_item) {

} ?>
<section class="content-header">
	<a class="btn btn-default pull-right" href="<?php echo base_url('RekapTIMSPromosiPekerja/RekapTIMS/export-employee/'.$info_item['nik'])?>">
		<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> EXPORT EXCEL
	</a>
	<h1>
		Rekap TIMS Kebutuhan Promosi Pekerja
	</h1>
</section>
<section class="content">
	<div class="inner" >
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">Employee Info</h3>
		</div>
		<div class="box-body">
			<table class="table no-border">
				<tr>
					<td width="10%"><b>NIK</b></td>
					<td>: 
						<?php 
							echo $info_item['nik']; 	
						?>
					</td>
				</tr>
				<tr>
					<td width="10%"><b>NAMA</b></td>
					<td>: 
						<?php 
							echo $info_item['nama']; 	
						?>
					</td>
				</tr>
				<tr>
					<td width="10%"><b>SEKSI</b></td>
					<td>: 
						<?php
							echo $info_item['seksi']; 	
						?>
					</td>
				</tr>
				<tr>
					<td width="10%"><b>UNIT</b></td>
					<td>: 
						<?php
							echo $info_item['unit']; 	
						?>
					</td>
				</tr>
				<tr>
					<td width="10%"><b>BIDANG</b></td>
					<td>: 
						<?php
							echo $info_item['bidang']; 	
						?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12">
						<div class="box" style="border-top-color: #FAD59B;">
							<div class="box-header with border">
								<h3 class="box-title">Terlambat</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body" style="display: block;">
								<table class="table table-striped table-bordered table-hover data-tims-personal">
									<thead class="bg-primary">
										<tr>
											<td style="text-align:center;">NO</td>
											<td style="text-align:center;">Tanggal</td>
											<td style="text-align:center;">Masuk</td>
											<td style="text-align:center;">Keluar</td>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach ($Terlambat as $T) { ?>
										<tr>
											<td style="text-align:center;"><?php echo $no++; ?></td>
											<td style="text-align:center;"><?php echo date('Y-m-d',strtotime($T['tanggal'])); ?></td>
											<td style="text-align:center;"><?php echo $T['masuk']; ?></td>
											<td style="text-align:center;"><?php echo $T['keluar']; ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Surat Peringatan</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body" style="display: block;">
								<table class="table table-striped table-bordered table-responsive table-hover data-tims-personal">
									<thead class="bg-primary">
										<tr>
											<td style="text-align:center;">NO</td>
											<td style="text-align:center;">Tanggal</td>
											<td style="text-align:center;">Masuk</td>
											<td style="text-align:center;">Keluar</td>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach ($SuratPeringatan as $SP) { ?>
										<tr>
											<td style="text-align:center;"><?php echo $no++; ?></td>
											<td style="text-align:center;"><?php echo date('Y-m-d', strtotime($SP['tanggal'])); ?></td>
											<td style="text-align:center;"><?php echo $SP['masuk']; ?></td>
											<td style="text-align:center;"><?php echo $SP['keluar']; ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Ijin Pribadi</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body" style="display: block;">
								<table class="table table-striped table-bordered table-responsive table-hover data-tims-personal">
									<thead class="bg-primary">
										<tr>
											<td style="text-align:center;">NO</td>
											<td style="text-align:center;">Tanggal</td>
											<td style="text-align:center;">Masuk</td>
											<td style="text-align:center;">Keluar</td>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach ($IjinPribadi as $IPb) { ?>
										<tr>
											<td style="text-align:center;"><?php echo $no++; ?></td>
											<td style="text-align:center;"><?php echo date('Y-m-d', strtotime($IPb['tanggal'])); ?></td>
											<td style="text-align:center;"><?php echo $IPb['masuk']; ?></td>
											<td style="text-align:center;"><?php echo $IPb['keluar']; ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-warning">
							<div class="box-header with-border">
								<h3 class="box-title">Mangkir</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body" style="display: block;">
								<table class="table table-striped table-bordered table-responsive table-hover data-tims-personal">
									<thead class="bg-primary">
										<tr>
											<td style="text-align:center;">NO</td>
											<td style="text-align:center;">Tanggal</td>
											<td style="text-align:center;">Masuk</td>
											<td style="text-align:center;">Keluar</td>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach ($Mangkir as $M) { ?>
										<tr>
											<td style="text-align:center;"><?php echo $no++; ?></td>
											<td style="text-align:center;"><?php echo date('Y-m-d', strtotime($M['tanggal'])); ?></td>
											<td style="text-align:center;"><?php echo $M['masuk']; ?></td>
											<td style="text-align:center;"><?php echo $M['keluar']; ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="box box-success">
							<div class="box-header with-border">
								<h3 class="box-title">Ijin Perusahaan</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body" style="display: block;">
								<table class="table table-striped table-bordered table-responsive table-hover data-tims-personal">
									<thead class="bg-primary">
										<tr>
											<td style="text-align:center;">NO</td>
											<td style="text-align:center;">Tanggal</td>
											<td style="text-align:center;">Masuk</td>
											<td style="text-align:center;">Keluar</td>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach ($IjinPerusahaan as $IP) { ?>
										<tr>
											<td style="text-align:center;"><?php echo $no++; ?></td>
											<td style="text-align:center;"><?php echo date('Y-m-g', strtotime($IP['tanggal'])); ?></td>
											<td style="text-align:center;"><?php echo $IP['masuk']; ?></td>
											<td style="text-align:center;"><?php echo $IP['keluar']; ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
</section>