 <section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterUnitGroupDistribution/modification');?>" class="form-horizontal" enctype="multipart/form-data">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
								<h1><b>Master Distribution</b></h1>
								</div>
							</div>
							<div class="col-lg-1">
								<div class="text-right hidden-md hidden-sm hidden-xs">
		                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/MasterUnitGroupDistribution');?>">
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
									<?php
										$status_create 	= 	'disabled="true"';
										$status_update 	=	'';
										$status_delete 	=	'';

										if($jumlahGolongan<1)
										{
											$status_create 	= 	'';
											$status_update	=	'disabled="true"';
											$status_delete	=	'disabled="true"';
										}	
									?>
									<span class="box-title">Jumlah Golongan Penilaian</span>
									<button type="button" class="btn btn-default btn-sm" style="float: right;" data-toggle="modal" data-target="#createJumlahGolongan" <?php echo $status_create;?>>
										<i class="icon-plus icon-2x"></i>
									</button>
								</div>
								<div class="box-body">
									<div class="panel-body">
										<table class="table table-bordered table-striped">
											<thead>
												<tr>
													<th style="text-align: center;">Jumlah Golongan Penilaian</th>
													<th style="text-align: center;">Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td style="text-align: center; vertical-align: middle;"><b><h2><?php echo $jumlahGolongan;?></h2></b></td>
													<td style="text-align: center; vertical-align: middle">
														<button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#updateJumlahGolongan" <?php echo $status_update;?> >
															Edit
														</button>
														<button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#deleteJumlahGolongan" <?php echo $status_delete;?> >
															Hapus
														</button>														
													</td>
												</tr>
											</tbody>
										</table>
									</div>
 									<!--<div class="panel-footer">
										<div class="row text-right">
											<button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
										</div>
									</div> -->
								</div>
							</div>

							<?php
								if($jumlahGolongan>0)
								{
							?>
								<div class="box box-primary box-solid">
									<div class="box-header with-border">
										<span class="box-title">Distribusi</span>
									</div>
									<div class="box-body">
										<div class="panel-body">
											<table class="table table-bordered table-striped table-hover">
												<tr>
													<th style="text-align: center; vertical-align: middle;">Golongan Pekerjaan \ Golongan Penilaian</th>
													<?php
														for ($m=1; $m <= $jumlahGolongan ; $m++) 
														{ 

													?>
													<th style="text-align: center; vertical-align: middle;"><?php echo $m;?></th>
													<?php
														}														
													?>
												</tr>
												<?php
													for ($k=0; $k < count($daftarGolonganKerja); $k++)
													{
														$encrypted_string = $this->encrypt->encode($daftarGolonganKerja[$k]['golkerja']);
														$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
												?>
												<tr>
													<th style="text-align: center; vertical-align: middle;"><a href="<?php echo base_url('PenilaianKinerja/MasterUnitGroupDistribution/distribusi_unitGroupEdit'.'/'.$encrypted_string);?>"><?php echo $daftarGolonganKerja[$k]['golkerja'];?></a></th>
													<?php
														for ($l=1; $l <= $jumlahGolongan ; $l++) 
														{
													?>
													<td style="text-align: center; vertical-align: middle;">
														<?php
															for ($m=0; $m < count($daftarDistribusiPekerja); $m++) 
															{ 
																if($daftarDistribusiPekerja[$m]['gol_kerja']==$daftarGolonganKerja[$k]['golkerja'])
																{
																	if($daftarDistribusiPekerja[$m]['gol_num']==$l)
																	{
																		if($daftarDistribusiPekerja[$m]['worker_count']==0)
																		{
																			echo '-';
																		}
																		else
																		{
																			echo $daftarDistribusiPekerja[$m]['worker_count'];
																		}
																	}
																}
															}																
														?>
													</td>
													<?php
														}														
													?>													
												</tr>
												<?php
													}												
												?>
											</table>
										</div>
									</div>
								</div>
							<?php
								}							
							?>

						</div>
					</div>		
				</div>
			</form>	
		</div>
	</div>
	<div id="createJumlahGolongan" class="modal fade modal-success" role="dialog">
	    <div class="modal-dialog">
	    	<div class="modal-content">
	    		<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterUnitGroupDistribution/jumlahGolongan_modification');?>">
	    			<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					    <h4 class="modal-title">Tambah Jumlah Golongan</h4>
	    			</div>
	    			<div class="modal-body">
	    				<strong>
	    					<h4>
	    						<center>
	    							<input class="form-control hidden" type="text" name="txtIDJumlahGolongan" value="<?php echo $idJumlahGolongan;?>" >
	    							<input class="form-control hidden" type="text" name="txtJumlahGolonganLama" value="<?php echo $jumlahGolongan;?>" >
	    							<input type="number" min="0" step="1" class="form-control" name="txtJumlahGolonganBaru" required=""  autofocus="" />
	    						</center>
	    					</h4>
	    				</strong>  									
    				</div>
    				<div class="modal-footer">
    					<button type="submit" class="btn btn-success">Tambah</button>
    				</div>
    			</form>
    		</div>
    	</div>
   	</div>
	<div id="updateJumlahGolongan" class="modal fade modal-warning" role="dialog">
	    <div class="modal-dialog">
	    	<div class="modal-content">
	    		<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterUnitGroupDistribution/jumlahGolongan_modification');?>">
	    			<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					    <h4 class="modal-title">Edit Jumlah Golongan</h4>
	    			</div>
	    			<div class="modal-body">   			
	    				<strong>
	    					<h4>
	    						<center>
	    							<input class="form-control hidden" type="text" name="txtIDJumlahGolongan" value="<?php echo $idJumlahGolongan;?>" >
	    							<input class="form-control hidden" type="text" name="txtJumlahGolonganLama" value="<?php echo $jumlahGolongan;?>" >
	    							<input type="number" min="0" step="1" class="form-control" name="txtJumlahGolonganBaru" required=""  autofocus="" />
	    						</center>
	    					</h4>
	    				</strong>  									
    				</div>
    				<div class="modal-footer">
    					<button type="submit" class="btn btn-warning">Edit</button>
    				</div>
    			</form>
    		</div>
    	</div>
   	</div>
	<div id="deleteJumlahGolongan" class="modal fade modal-danger" role="dialog">
	    <div class="modal-dialog">
	    	<div class="modal-content">
	    		<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterUnitGroupDistribution/jumlahGolongan_delete');?>">
	    			<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					    <h4 class="modal-title">Hapus Jumlah Golongan</h4>
	    			</div>
	    			<div class="modal-body">
	    				<h5>
	    					Apakah Anda ingin menghapus data ini?
	    				</h5>	 	    			
	    				<strong>
	    					<h4>
	    						<center>
	    							<input class="form-control hidden" type="text" name="txtIDJumlahGolongan" value="<?php echo $idJumlahGolongan;?>" >
	    							<input class="form-control hidden" type="text" name="txtJumlahGolonganLama" value="<?php echo $jumlahGolongan;?>" >
	    						</center>
	    					</h4>
	    				</strong>  									
    				</div>
    				<div class="modal-footer">
    					<button type="submit" class="btn btn-danger">Hapus</button>
    				</div>
    			</form>
    		</div>
    	</div>
   	</div>

</section>			
			
				
