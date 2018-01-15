<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Trainer</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/MasterTrainer');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br/>
			
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<b data-toogle="tooltip" title="Halaman manajemen daftar pelatih/trainer.">Master Trainer</b>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-9">
								<div class="table-responsive" style="overflow:hidden;">
									<table class="table table-striped table-bordered table-hover text-left" id="dataTables-customer" style="font-size:14px;">
										<thead class="bg-primary">
											<tr>
												<th width="5%">NO</th>
												<th width="15%">No. Induk</th>
												<th width="40%">Nama</th>
												<th width="15%">Status</th>
												<th width="25%">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php $no=0; foreach($trainer as $tr){ $no++ ?>
											<tr>
												<td><?php echo $no ?></td>
												<td><?php echo $tr['noind'] ?></td>
												<td><?php echo $tr['trainer_name'] ?></td>
												<td align="center"><?php 
													$status='Trainer Internal';
													if ($tr['trainer_status'] == 0) {
														$status='Trainer Eksternal';
													}
													echo $status;
													?>
												</td>
												<td>
													<a href="<?php echo site_url('ADMPelatihan/MasterTrainer/View/'.$tr['trainer_id']);?>" class="btn btn-xs btn-success"><i class="fa fa-search"></i> View</a>
													<a href="<?php echo site_url('ADMPelatihan/MasterTrainer/Edit/'.$tr['trainer_id']);?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</a>
													<a data-toggle="modal" data-target="<?php echo '#deletealert'.$tr['trainer_id'] ?>" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Delete</a>
												</td>
											</tr>
											
											<div class="modal fade modal-danger" id="<?php echo 'deletealert'.$tr['trainer_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<div class="col-sm-2"></div>
															<div class="col-sm-8" align="center"><h5><b>PERHATIAN !</b></h5></div>
															<div class="col-sm-2"><h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h5></div>
															</br>
														</div>
														<div class="modal-body" align="center">
															Apakah anda yakin ingin menghapus trainer dengan nama <b><?php echo $tr['trainer_name'] ?></b> dari daftar ? <br>
															<small>*) Data yang sudah dihapus tidak dapat dikembalikan lagi.</small>
															<div class="row">
																<br>
																<a href="<?php echo base_url('ADMPelatihan/MasterTrainer/Delete/'.$tr['trainer_id'])?>" class="btn btn-default"><i class="fa fa-remove"></i> DELETE</a>
															</div>
														</div>
													</div>
												</div>
											</div>

											<?php } ?>
										</tbody>																			
									</table>
								</div>
							</div>
							<div class="col-md-3">
								<label><b>Tambah Trainer</b></label>
								<a href="<?php echo base_url('ADMPelatihan/MasterTrainer/CreateInternal/')?>" class="btn btn-block btn-flat btn-social btn-danger"><i class="fa fa-power-off fa-rotate-180"></i> Tambah Trainer Internal</a>
								<a href="<?php echo base_url('ADMPelatihan/MasterTrainer/CreateExternal/')?>" class="btn btn-block btn-flat btn-social btn-primary"><i class="fa fa-user"></i> Tambah Trainer Eksternal</a>
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
			
				
