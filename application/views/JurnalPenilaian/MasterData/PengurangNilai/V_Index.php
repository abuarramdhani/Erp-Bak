 <section class="content">
	<div class="inner" >
		<div class="row">
			<!-- <form method="post" action="<?php echo base_url('PenilaianKinerja/MasterPengurangNilai/modification');?>" class="form-horizontal" enctype="multipart/form-data"> -->
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
								<h1><b>Pengurang Nilai</b></h1>
								</div>
							</div>
							<div class="col-lg-1">
								<div class="text-right hidden-md hidden-sm hidden-xs">
		                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/MasterPengurangNilai');?>">
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
							<div class="box box-primary">
								<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterPengurangNilai/SK_modification');?>" class="form-horizontal" enctype="multipart/form-data">
									<div class="box-header with-border">
										<button type="button" class="btn btn-default btn-sm" style="float: right;" onclick="PenilaianKinerja_tambahSKPengurangPrestasi()">
										<i class="icon-plus icon-2x"></i>
										</button>
										<b data-toogle="tooltip" title="Halaman untuk membuat Master TIM.">Master Pengurang Nilai dari Jumlah Hari SK</b>	
									</div>
									<div class="box-body">
										<div class="panel-body">
											<?php
												if(empty($tabelSKPengurangPrestasi))
												{
											?>
											<table class="table table-bordered table-striped table-hover" id="PenilaianKinerja-daftarSKPengurangPrestasi">
												<tr>
													<th>No.</th>
													<th>Batas Bawah Jumlah Hari SK</th>
													<th>Batas Atas Jumlah Hari SK</th>
													<th>Pengurang Nilai</th>
												</tr>
												<tr id="PenilaianKinerja-SKPengurangPrestasi">
													<td style="vertical-align: middle; text-align: center;">
														1
														<input type="text" class="hidden form-control" name="txtIDSKPrestasi[0]" value="-" />
														<br/>
														<button type="button" class="btn btn-danger btn-xs" onclick="PenilaianKinerja_hapusInputBaruSKPengurangPrestasi(this)"><i class="fa fa-times"></i></button>
													</td>
													<td>
														<input type="number" class="form-control" min="0" step="1" value="0" name="txtBatasBawahJumlahSKPrestasi[0]" />
													</td>
													<td>
														<input type="number" class="form-control" min="0" step="1" value="0" name="txtBatasAtasJumlahSKPrestasi[0]" />
													</td>
													<td>
														<input type="number" class="form-control" min="0" step="1" value="0" name="txtPengurangSKPrestasi[0]"></input>
													</td>
												</tr>
											</table>
											<?php
												}
												else
												{
											?>
											<table class="table table-bordered table-striped table-hover" id="PenilaianKinerja-daftarSKPengurangPrestasi">
												<tr>
													<th>No.</th>
													<th>Batas Bawah Jumlah Hari SK</th>
													<th>Batas Atas Jumlah Hari SK</th>
													<th>Pengurang Nilai</th>
												</tr>
												<?php
												$noSKPres 	=	1;
													foreach ($tabelSKPengurangPrestasi as $SKPres) 
													{
														$idSKPres 	=	str_replace(array('+','/','='), array('-','_','~'), $this->encryption->encrypt($SKPres['sk_pres_id']));
												?>
												<tr id="PenilaianKinerja-SKPengurangPrestasi">
													<td style="vertical-align: middle; text-align: center;">
														<?php echo $noSKPres;?>
														<input type="text" class="hidden form-control" name="txtIDSKPrestasi[<?php echo ($noSKPres-1);?>]" value="<?php echo $idSKPres;?>" />
														<br/>
														<button type="button" class="btn btn-danger btn-xs" onclick="PenilaianKinerja_hapusDataSKPengurangPrestasi('<?php echo $idSKPres;?>')"><i class="fa fa-times"></i></button>
													</td>
													<td>
														<input type="number" class="form-control" min="0" step="1" value="<?php echo $SKPres['batas_bawah'];?>" name="txtBatasBawahJumlahSKPrestasi[<?php echo ($noSKPres-1);?>]" />
													</td>
													<td>
														<input type="number" class="form-control" min="0" step="1" value="<?php echo $SKPres['batas_atas'];?>" name="txtBatasAtasJumlahSKPrestasi[<?php echo ($noSKPres-1);?>]" />
													</td>
													<td>
														<input type="number" class="form-control" min="0" step="1" value="<?php echo $SKPres['pengurang'];?>" name="txtPengurangSKPrestasi[<?php echo ($noSKPres-1);?>]"></input>
													</td>
												</tr>
												<?php
														$noSKPres++;
													}
												?>
											</table>											
											<?php
												}
											?>
										</div>
										<div class="panel-footer">
											<div class="row text-right">
												<button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
											</div>											
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-12">
							<div class="box box-primary">
								<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterPengurangNilai/SK_modification');?>" class="form-horizontal" enctype="multipart/form-data">
									<div class="box-header with-border">
										<button type="button" class="btn btn-default btn-sm" style="float: right;" onclick="PenilaianKinerja_tambahSKPengurangKemauan()">
										<i class="icon-plus icon-2x"></i>
										</button>
										<b data-toogle="tooltip" title="Halaman untuk membuat Master TIM.">Master Pengurang Nilai dari Jumlah Bulan SK</b>	
									</div>
									<div class="box-body">
										<div class="panel-body">
											<?php
												if(empty($tabelSKPengurangKemauan))
												{
											?>
											<table class="table table-bordered table-striped table-hover" id="PenilaianKinerja-daftarSKPengurangKemauan">
												<tr>
													<th>No.</th>
													<th>Batas Bawah Jumlah Bulan SK</th>
													<th>Batas Atas Jumlah Bulan SK</th>
													<th>Pengurang Nilai</th>
												</tr>
												<tr id="PenilaianKinerja-SKPengurangKemauan">
													<td style="vertical-align: middle; text-align: center;">
														1
														<input type="text" class="hidden form-control" name="txtIDSKKemauan[0]" value="-" />
														<br/>
														<button type="button" class="btn btn-danger btn-xs" onclick="PenilaianKinerja_hapusInputBaruSKPengurangKemauan(this)"><i class="fa fa-times"></i></button>
													</td>
													<td>
														<input type="number" class="form-control" min="0" step="1" value="0" name="txtBatasBawahJumlahSKKemauan[0]" />
													</td>
													<td>
														<input type="number" class="form-control" min="0" step="1" value="0" name="txtBatasAtasJumlahSKKemauan[0]" />
													</td>
													<td>
														<input type="number" class="form-control" min="0" step="1" value="0" name="txtPengurangSKKemauan[0]"></input>
													</td>
												</tr>
											</table>
											<?php
												}
												else
												{
											?>
											<table class="table table-bordered table-striped table-hover" id="PenilaianKinerja-daftarSKPengurangKemauan">
												<tr>
													<th>No.</th>
													<th>Batas Bawah Jumlah Hari SK</th>
													<th>Batas Atas Jumlah Hari SK</th>
													<th>Pengurang Nilai</th>
												</tr>
												<?php
												$noSKKemauan 	=	1;
													foreach ($tabelSKPengurangKemauan as $SKKemauan) 
													{
														$idSKKemauan 	=	str_replace(array('+','/','='), array('-','_','~'), $this->encryption->encrypt($SKKemauan['sk_kemauan_id']));
												?>
												<tr id="PenilaianKinerja-SKPengurangKemauan">
													<td style="vertical-align: middle; text-align: center;">
														<?php echo $noSKKemauan;?>
														<input type="text" class="hidden form-control" name="txtIDSKKemauan[<?php echo ($noSKKemauan-1);?>]" value="<?php echo $idSKKemauan;?>" />
														<br/>
														<button type="button" class="btn btn-danger btn-xs" onclick="PenilaianKinerja_hapusDataSKPengurangKemauan('<?php echo $idSKKemauan;?>')"><i class="fa fa-times"></i></button>
													</td>
													<td>
														<input type="number" class="form-control" min="0" step="1" value="<?php echo $SKKemauan['bulan_batas_bawah'];?>" name="txtBatasBawahJumlahSKKemauan[<?php echo ($noSKPres-1);?>]" />
													</td>
													<td>
														<input type="number" class="form-control" min="0" step="1" value="<?php echo $SKKemauan['bulan_batas_atas'];?>" name="txtBatasAtasJumlahSKKemauan[<?php echo ($noSKPres-1);?>]" />
													</td>
													<td>
														<input type="number" class="form-control" min="0" step="1" value="<?php echo $SKKemauan['pengurang'];?>" name="txtPengurangSKKemauan[<?php echo ($noSKPres-1);?>]"></input>
													</td>
												</tr>
												<?php
														$noSKKemauan++;
													}
												?>
											</table>											
											<?php
												}
											?>
										</div>
										<div class="panel-footer">
											<div class="row text-right">
												<button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
											</div>											
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

				</div>
			<!-- </form>	 -->
		</div>
	</div>
	<div id="deleteSKPengurangPrestasi" class="modal fade modal-danger" role="dialog">
	    <div class="modal-dialog">
	    	<div class="modal-content">
	    		<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterPengurangNilai/SKPrestasi_delete');?>">
	    			<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					    <h4 class="modal-title">Hapus Data</h4>
	    			</div>
	    			<div class="modal-body">
	    				<h5>
	    					Apakah Anda ingin menghapus data ini?
	    				</h5>	 	    			
	    				<strong>
	    					<h4>
	    						<center>
	    							<input type="text" class="form-control hidden" name="txtIDSKPrestasiDelete" id="txtIDSKPrestasiDelete" value="" >
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
	<div id="deleteSKPengurangKemauan" class="modal fade modal-danger" role="dialog">
	    <div class="modal-dialog">
	    	<div class="modal-content">
	    		<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterPengurangNilai/SKKemauan_delete');?>">
	    			<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					    <h4 class="modal-title">Hapus Data</h4>
	    			</div>
	    			<div class="modal-body">
	    				<h5>
	    					Apakah Anda ingin menghapus data ini?
	    				</h5>	 	    			
	    				<strong>
	    					<h4>
	    						<center>
	    							<input type="text" class="form-control hidden" name="txtIDSKKemauanDelete" id="txtIDSKKemauanDelete" value="" >
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
			
				
