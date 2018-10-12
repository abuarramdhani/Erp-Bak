<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Data Server ICT</b></h1>

							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringICT/DataServer');?>">
									<i class="icon-desktop icon-2x"></i>
									<span ><br /></span>
								</a>
							</div>
						</div>
					</div>
					<br />
					<div>
						<div style="margin-right: 10px" class="col-lg-12">
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									Daftar Server
								</div>
								<div align="right" style="margin-right: 10px; margin-top: 10px">
									<a class="btn btn-default btn-md" href="<?php echo site_url('MonitoringICT/DataServer/tambah');?>">
									Tambah
									</a>
								</div>
								
								<div class="box-body">
									<div class="table-responsive">
										<table id="tb_ictserver" class="table table-bordered table-hover">
											<thead>
												<tr class="bg-primary">
													<th style="text-align: center;">No</th>
													<th style="text-align: center;">Hostname</th>
													<th style="text-align: center;">IP Address</th>
													<th style="text-align: center;">Lokasi</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											 	$no = 1;
												foreach ($server as $row) {
												  ?>
												<tr>
													<td style="text-align: center;"><?php echo $no; ?></td>
													<td style="text-align: center;"><?php echo $row['hostname_server']; ?></td>
													<td style="text-align: center;"><?php echo $row['ip_server']; ?></td>
													<td style="text-align: center;"><?php echo $row['id_lokasi_server']; ?></td>
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
					</div>
				</div>
			</div>
		</div>
	</div>
</section>