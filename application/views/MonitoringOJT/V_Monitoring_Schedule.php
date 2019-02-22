<section class="content">
	<div class="inner">
		<div class="row">
			<form class="form-horizontal" method="post" action="<?php echo base_url('OnJobTraining/Monitoring/scheduling_save');?>" enctype="multipart/form-data">
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
									<a class="btn btn-default btn-lg" href="<?php echo site_url('OnJobTraining/MasterUndangan');?>">
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
									<h3 class="box-title">Penjadwalan Manual</h3>
								</div>
								<div class="box-body">
									<div class="panel-body">
										<?php
											$pekerja_id;
											$ojt_noind;
											$ojt_nama;
											$ojt_selesai;
											foreach ($getTraineeInfo as $pekerjaOJT)
											{
												$pekerja_id 	=	$this->general->enkripsi($pekerjaOJT['pekerja_id']);
												$ojt_noind 		=	$pekerjaOJT['noind'];
												$ojt_nama 		=	$pekerjaOJT['nama_pekerja_ojt'];
												$ojt_selesai 	=	$pekerjaOJT['selesai'];
										?>
										<div class="form-group">
											<label class="control-label col-lg-4">
												Pekerja
											</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" disabled="" style="width: 100%" value="<?php echo $pekerjaOJT['noind'].' - '.$pekerjaOJT['nama_pekerja_ojt'];?>">
											</div>
										</div>
										<?php
											}
											$indeks 	=	0;
											$semua_proses_selesai 	=	0;
											foreach ($getSchedule as $manualSchedule)
											{
												$id_proses 		=	$this->general->enkripsi($manualSchedule['id_proses']);
										 		$id_orientasi	=	$this->general->enkripsi($manualSchedule['id_orientasi']);
										 		$jadwal 		=	$manualSchedule['tahapan'];

										 		if($manualSchedule['periode']==1 && $manualSchedule['sequence']==1)
										 		{
										?>
										<div class="form-group">
											<label for="txtPenjadwalanManual-TanggalMasuk" class="control-label col-lg-4">
												<?php echo $jadwal;?>
											</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" disabled="" style="text-transform: uppercase; width: 100%" name="txtPenjadwalanManual-TanggalMasuk" id="txtPenjadwalanManual-TanggalMasuk" value="<?php echo $manualSchedule['tgl_awal'].' - '.$manualSchedule['tgl_akhir'];?>">
											</div>
										</div>
										<?php
												}
										 		elseif(!($manualSchedule['periode']==1 && $manualSchedule['sequence']==1))
										 		{
										?>
										<div class="form-group">
											<label for="MonitoringOJT-txtPenjadwalanManual[<?php echo $indeks;?>]" class="control-label col-lg-4">
												<?php echo $jadwal;?>
											</label>
											<div class="col-lg-4">
												<input type="text" class="form-control MonitoringOJT-daterangepicker-noautoupdateinput" style="text-transform: uppercase; width: 100%" name="txtPenjadwalanManual[<?php echo $indeks;?>]" id="MonitoringOJT-txtPenjadwalanManual[<?php echo $indeks;?>]" value="<?php echo $manualSchedule['tgl_awal'].' - '.$manualSchedule['tgl_akhir'];?>">
												<input type="text" class="form-control hidden" name="txtIDProsesPenjadwalan[<?php echo $indeks;?>]" value="<?php echo $id_proses;?>"/>
												<input type="text" class="form-control hidden" name="txtIDOrientasi[<?php echo $indeks;?>]" value="<?php echo $id_orientasi;?>"/>
											</div>
											<label for="MonitoringOJT-prosesSelesai[<?php echo $indeks;?>]" class="col-lg-4">
												<?php
													$checkboxSelesai 	=	"";
													if($manualSchedule['selesai']=='t')
													{
														$checkboxSelesai 	=	"checked";
														$semua_proses_selesai 	=	1;
													}
													else
													{
														$semua_proses_selesai 	=	0;
													}
												?>
												<input type="checkbox" id="MonitoringOJT-prosesSelesai[<?php echo $indeks;?>]" name="chkProsesSelesai[<?php echo $indeks;?>]" <?php echo $checkboxSelesai;?> value="1"/>
												Selesai
											</label>
										</div>
										<?php
													$indeks++;
												}
										 	}
										?>
									</div>
									<div class="panel-footer">
										<div class="row text-right">
											<?php
												if ( $semua_proses_selesai == 1 AND $ojt_selesai == 'f' )
												{
											?>
											<a onclick="MonitoringOJT_ubahStatusPekerjaSelesai(<?php echo "'".$pekerja_id."'";?>, <?php echo "'".$ojt_noind."'";?>, <?php echo "'".$ojt_nama."'";?>)" class="btn btn-warning btn-lg btn-rect"><i class="fa fa-check-square"></i> Ubah Status Pekerja menjadi Selesai OJT</a>
											<?php
												}
											?>
                                            <a href="<?php echo base_url('OnJobTraining/Monitoring');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<form class="form-horizontal" method="post" action="<?php echo base_url('OnJobTraining/Monitoring/pekerja_selesai');?>" enctype="multipart/form-data">
		<div id="MonitoringOJT-ubahStatusPekerjaSelesai" class="modal fade" role="dialog">
		  	<div class="modal-dialog modal-lg">
		    	<div class="modal-content">
		        	<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Ubah Status Pekerja OJT menjadi Selesai</h4>
					</div>
					<div class="modal-body">
						<div class="form-group hidden">
							<label for="MonitoringOJT-scheduling-pekerjaSelesai-txtPekerjaID" class="control-label col-lg-2">Pekerja ID</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" style="width: 100%" name="txtPekerjaID" id="MonitoringOJT-scheduling-pekerjaSelesai-txtPekerjaID" required="" value="">
							</div>
						</div>
						<p>
							Apakah Anda benar-benar akan mengubah status pekerja di bawah ini menjadi <b>selesai masa OJT</b>?<br/>
							<b id="MonitoringOJT-scheduling-pekerjaSelesai-txtNoind"></b> - <b id="MonitoringOJT-scheduling-pekerjaSelesai-txtNama"></b>
						</p>
					</div>
					<div class="modal-footer">
		          		<button type="submit" class="btn btn-success"><i class="fa fa fa-check-square"></i> Ya</button>
		          		<button type="button" class="btn btn-danger" data-dismiss="modal">&times; Tidak</button>
		        	</div>
		    	</div>
			</div>
		</div>
	</form>
</section>