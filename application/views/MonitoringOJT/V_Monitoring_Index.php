<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?php echo $Title;?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('OnJobTraining/Monitoring');?>">
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
								<h3 class="box-title">Monitoring Pekerja OJT D3-S1</h3>
								<a style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Tambah Pekerja" title="Tambah Pekerja" >
                                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#tambahPekerjaOJT"><i class="icon-plus icon-2x"></i></button>
                                </a>
							</div>
							<div class="box-body">
								<table class="table table-bordered" id="MonitoringOJT-monitoringPekerja">
									<thead>
										<tr>
											<th style="white-space: nowrap; text-align: center;">No.</th>
											<th style="white-space: nowrap; text-align: center;">Action</th>
											<th style="white-space: nowrap; text-align: center;">Pekerja</th>
											<!-- <th style="white-space: nowrap; text-align: center;">Seksi</th> -->
											<th style="white-space: nowrap; text-align: center;">Tanggal Masuk</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no 	= 	1;
											foreach ($daftarPekerjaOJT as $pekerja)
											{
										?>
										<tr>
											<td style="white-space: nowrap; text-align: center; vertical-align: center"><?php echo $no;?></td>
											<td style="white-space: nowrap; text-align: center; vertical-align: center">
												<a alt="Schedule" title="Schedule" href="<?php echo base_url('');?>">
							                    	<i class="fa fa-pencil-square-o fa-2x"></i>
							                    </a>
											</td>
											<td style="white-space: nowrap; text-align: center; vertical-align: center"><?php echo $pekerja['noind'];?></td>
											<td style="white-space: nowrap; text-align: center; vertical-align: center"><?php echo $pekerja['tgl_masuk'];?></td>
										</tr>
										<?php
												$no++;
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div id="tambahPekerjaOJT" class="modal fade" role="dialog">
					<form class="form-horizontal" method="post" action="<?php echo base_url('OnJobTraining/Monitoring/tambahPekerja');?>" enctype="multipart/form-data">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
	       	 						<h4 class="modal-title">Tambah Baru Pekerja OJT</h4>
								</div>
								<div class="modal-body">
									<div class="form-group">
										<div class="col-lg-8">
											<select class="select2" style="width: 100%" name="cmbDaftarPekerjaOJT" id="MonitoringOJT-cmbDaftarPekerjaOJT">
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12">
											<select class="select2" style="width: 100%" name="cmbDaftarAtasanPekerja" id="MonitoringOJT-cmbDaftarAtasanPekerja">
											</select>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-success">Tambah</button>
									<button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>