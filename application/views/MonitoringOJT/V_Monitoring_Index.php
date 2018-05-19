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
											<th style="white-space: nowrap; text-align: center;">Nomor Induk Pekerja</th>
											<th style="white-space: nowrap; text-align: center;">Nama Pekerja</th>
											<th style="white-space: nowrap; text-align: center;">Seksi</th>
											<th style="white-space: nowrap; text-align: center;">Tanggal Masuk</th>
											<th style="white-space: nowrap; text-align: center;">Tanggal Lahir</th>
											<th style="white-space: nowrap; text-align: center;">Latar Belakang Pendidikan</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no 	= 	1;
											foreach ($daftarPekerjaOJT as $pekerja)
											{
												$pekerja_id 	=	$this->general->enkripsi($pekerja['pekerja_id']);
										?>
										<tr>
											<td style="white-space: nowrap; text-align: center; vertical-align: center"><?php echo $no;?></td>
											<td style="white-space: nowrap; text-align: center; vertical-align: center">
												<a alt="Jadwal" title="Jadwal" href="<?php echo base_url('OnJobTraining/Monitoring/scheduling/'.$pekerja_id);?>">
							                    	<i class="fa fa-pencil-square-o fa-2x"></i>
							                    </a>
							                    <a alt="Ubah Status Pekerja Menjadi Keluar" title="Ubah Status Pekerja Menjadi Keluar" onclick="MonitoringOJT_ubahStatusPekerjaKeluar(<?php echo "'".$pekerja_id."'";?>, <?php echo "'".$pekerja['noind']."'";?>)">
							                    	<i class="fa fa-sign-out fa-2x"></i>
							                    </a>
											</td>
											<td style="white-space: nowrap; text-align: center; vertical-align: center">
												<b><?php echo $pekerja['noind'];?></b><br/>
											</td>
											<td style="white-space: nowrap; text-align: justify; vertical-align: center">
												<?php echo trim($pekerja['employee_name']);?>
											</td>
											<td style="white-space: nowrap; text-align: justify; vertical-align: center">
												<?php echo trim($pekerja['section_name']);?>
											</td>
											<td style="white-space: nowrap; text-align: center; vertical-align: center">
												<?php echo $pekerja['tgl_masuk'];?>
											</td>
											<td style="white-space: nowrap; text-align: center; vertical-align: center">
												<?php echo $pekerja['tanggal_lahir'];?>
											</td>
											<td style="white-space: nowrap; text-align: center; vertical-align: center">
												<?php echo $pekerja['jenjang_pendidikan_terakhir'].' '.$pekerja['jurusan'].' - '.$pekerja['institusi_pendidikan'];?>
											</td>

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
	<div id="MonitoringOJT-ubahStatusPekerjaKeluar" class="modal fade" role="dialog">
	  	<div class="modal-dialog modal-lg">
	    	<div class="modal-content">
	      		<form class="form-horizontal" method="post" action="<?php echo base_url('Admin/MenuManagement_insertMenu/');?>" enctype="multipart/form-data">
	        		<div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title">Insert Menu</h4>
			        </div>
	        <div class="modal-body">
	          
	        </div>
	        <div class="modal-footer">
	          	<button type="submit" class="btn btn-success"><i class="fa fa fa-hdd-o"></i> Save</button>
	          	<button type="button" class="btn btn-danger" data-dismiss="modal">&times; Close</button>
	        </div>
	      </form>
	    </div>
	  </div>
	</div>
</section>