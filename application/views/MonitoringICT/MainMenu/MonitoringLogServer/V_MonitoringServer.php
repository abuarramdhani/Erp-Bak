<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b> Monitoring Log Server</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringServer/Monitoring');?>">
									<i class="icon-desktop icon-2x"></i>
									<span ><br /></span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<a href="<?php echo site_url('MonitoringServer/InputMonitoring') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
									<button type="button" class="btn btn-default btn-sm">
									  <i class="icon-plus icon-2x"></i>
									</button>
								</a>
								Tabel Monitoring Server
							</div>
							<div class="box-body">
								<div class="table-responsive">
									
									<table class="table table-striped table-bordered table-hover text-left" id="tblUser" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="15%"><center>Ruang Server</center></th>
												<th width="20%"><center>Petugas</center></th>
												<th width="15%"><center>Tanggal</center></th>
												<th width="10%"><center>Jam Masuk</center></th>
												<th width="10%"><center>jam Keluar</center></th>
												<th width="15%"><center>Pemberi Izin</center></th>
												<th width="10%"><center></center></th>
											</tr>
										</thead>
										<tbody>
											<?php $num = 1; foreach ($DataMonitoring as $monitoring ) { ?>
											<tr>
												<td style="text-align: center;"><?php echo $num++; ?></td>	
												<td><?php echo $monitoring['ruang_server']; ?></td>	
												<td><?php foreach ( $monitoring['pekerja'] as $pk ) {echo '- '.$pk['petugas'].'<br>';} ?></td>	
												<td><?php echo  date('d F Y',strtotime($monitoring['tanggal'])) ; ?></td>	
												<td><?php echo $monitoring['jam_masuk']; ?></td>	
												<td><?php echo $monitoring['jam_keluar']; ?></td>	
												<td><?php echo $monitoring['pemberi_izin']; ?></td>
												<td style="text-align: center;"><a alt="View Detail" title="View Detail" href="<?php echo base_url("MonitoringServer/Monitoring/Detail/$monitoring[log_id]") ?>"><button  class="btn btn-xs btn-primary"> Detail</button></a></td>	
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
	</div>
</section>