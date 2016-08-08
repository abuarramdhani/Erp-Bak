<section class="content">
	<div class="inner" >
	<div class="box box-info">
	<div style="padding-top: 10px">
		<div class="box-header with-border">
			<h4 class="pull-left"><strong>Rekap TIMS Kebutuhan Promosi Pekerja</strong></h4>
			<a class="btn btn-default pull-right" href="<?php echo base_url('RekapTIMSPromosiPekerja/employee/#')?>">
				<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> EXPORT EXCEL
			</a>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-1">
					<strong>
					NIK
					</strong>
				</div>
				<div class="col-md-3">: 
					<?php foreach ($info as $info_item) {
						echo $info_item['NIK']; 	
					} ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-1">
					<strong>
					Nama
					</strong>
				</div>
				<div class="col-md-3">: 
					<?php foreach ($info as $info_item) {
						echo $info_item['nama']; 	
					} ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-1">
					<strong>
					Seksi
					</strong>
				</div>
				<div class="col-md-3">: 
					<?php foreach ($info as $info_item) {
						echo $info_item['seksi']; 	
					} ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-1">
					<strong>
					Unit
					</strong>
				</div>
				<div class="col-md-3">: 
					<?php foreach ($info as $info_item) {
						echo $info_item['unit']; 	
					} ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-1">
					<strong>
					Bidang
					</strong>
				</div>
				<div class="col-md-3">: 
					<?php foreach ($info as $info_item) {
						echo $info_item['bidang']; 	
					} ?>
				</div>
			</div>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<h4><strong>Terlambat</strong></h4>
					<table style="max-width: 90%" id="personalT" class="table table-striped table-bordered table-hover">
						<thead style="background:#22aadd; color:#FFFFFF;">
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
									<td style="text-align:center;"><?php echo $T['tanggal']; ?></td>
									<td style="text-align:center;"><?php echo $T['masuk']; ?></td>
									<td style="text-align:center;"><?php echo $T['keluar']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="col-md-6">
					<h4><strong>Mangkir</strong></h4>
					<table style="max-width: 90%" id="personalM" class="table table-striped table-bordered table-responsive table-hover ">
						<thead style="background:#22aadd; color:#FFFFFF;">
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
									<td style="text-align:center;"><?php echo $M['tanggal']; ?></td>
									<td style="text-align:center;"><?php echo $M['masuk']; ?></td>
									<td style="text-align:center;"><?php echo $M['keluar']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<h4><strong>Surat Peringatan</strong></h4>
					<table style="max-width: 90%" id="personalSP" class="table table-striped table-bordered table-responsive table-hover ">
						<thead style="background:#22aadd; color:#FFFFFF;">
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
									<td style="text-align:center;"><?php echo $SP['tanggal']; ?></td>
									<td style="text-align:center;"><?php echo $SP['masuk']; ?></td>
									<td style="text-align:center;"><?php echo $SP['keluar']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="col-md-6">
					<h4><strong>Izin Perusahaan</strong></h4>
					<table style="max-width: 90%" id="personalIP" class="table table-striped table-bordered table-responsive table-hover ">
						<thead style="background:#22aadd; color:#FFFFFF;">
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
									<td style="text-align:center;"><?php echo $IP['tanggal']; ?></td>
									<td style="text-align:center;"><?php echo $IP['masuk']; ?></td>
									<td style="text-align:center;"><?php echo $IP['keluar']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<h4><strong>Izin Pribadi</strong></h4>
					<table style="max-width: 90%" id="personalI" class="table table-striped table-bordered table-responsive table-hover ">
						<thead style="background:#22aadd; color:#FFFFFF;">
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
									<td style="text-align:center;"><?php echo $IPb['tanggal']; ?></td>
									<td style="text-align:center;"><?php echo $IPb['masuk']; ?></td>
									<td style="text-align:center;"><?php echo $IPb['keluar']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="box box-info"></div>
	</div>
	</div>
	</div>
</section>