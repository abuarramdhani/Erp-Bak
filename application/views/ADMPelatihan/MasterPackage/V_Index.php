<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Paket Training</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/MasterPackage');?>">
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
						<a href="<?php echo site_url('ADMPelatihan/MasterPackage/create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
							<button type="button" class="btn btn-default btn-sm">
							  <i class="icon-plus icon-2x"></i>
							</button>
						</a>
						<b data-toogle="tooltip" title="Halaman untuk membuat template paket pelatihan.">Master Paket Training</b>
					</div>
					<div class="box-body">

						<div class="table-responsive" style="overflow:hidden;">
							<table class="table table-striped table-bordered table-hover text-left" id="dataTables-customer" style="font-size:14px;">
								<thead class="bg-primary">
									<tr>
										<th width="5%">NO</th>
										<th width="35%">Nama Paket Pelatihan</th>
										<th width="20%">Jenis Pelatihan</th>
										<th width="10%">Peserta</th>
										<th width="20%">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=0;
										foreach($GetPackage as $gp){
											foreach($TrainingType as $tt){
												if($gp['training_type']==$tt['training_type_id']){
													$trgtype=$tt['training_type_description'];
												}else{
													$trgtype='Orientasi';
												}
											}

											$no++;
											// $trgtype='Orientasi';
											// $ptctype='Staf';
											if($gp['participant_type']==1){
												$ptctype='Non Staf';
											}elseif ($gp['participant_type']==0) {
												$ptctype='Staf';
											}else{
												$ptctype='Staf & Non Staf';
											}
									?>
									<tr>
										<td><?php echo $no ?></td>
										<td><?php echo $gp['package_name'] ?></td>
										<td><?php echo 'pelatihan '.$trgtype ?></td>
										<td ><?php echo $ptctype; ?>
										</td>
										<td>
											<a href="<?php echo base_url('ADMPelatihan/MasterPackage/View/'.$gp['package_id'])?>" class="btn btn-xs btn-warning"><i class="fa fa-search"></i> View</a>
											<a href="<?php echo base_url('ADMPelatihan/MasterPackage/Edit/'.$gp['package_id'])?>" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</a>
											<a data-toggle="modal" data-target="<?php echo '#deletealert'.$gp['package_id'] ?>" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Delete</a>
										</td>
									</tr>
									
									<div class="modal fade modal-danger" id="<?php echo 'deletealert'.$gp['package_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<div class="col-sm-2"></div>
													<div class="col-sm-8" align="center"><h5><b>PERHATIAN !</b></h5></div>
													<div class="col-sm-2"><h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h5></div>
													</br>
												</div>
												<div class="modal-body" align="center">
													Apakah anda yakin ingin menghapus paket <b><?php echo $gp['package_name'] ?></b> ? <br>
													<small>*) Data yang sudah dihapus tidak dapat dikembalikan lagi.</small>
													<div class="row">
														<br>
														<a href="<?php echo base_url('ADMPelatihan/MasterPackage/Delete/'.$gp['package_id'])?>" class="btn btn-default"><i class="fa fa-remove"></i> DELETE</a>
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
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
