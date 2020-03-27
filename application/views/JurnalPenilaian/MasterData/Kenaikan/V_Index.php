 <section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterKenaikan/modification');?>" class="form-horizontal" enctype="multipart/form-data">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
								<h1><b>Master Kenaikan Gaji</b></h1>
								</div>
							</div>
							<div class="col-lg-1">
								<div class="text-right hidden-md hidden-sm hidden-xs">
		                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/MasterKenaikan');?>">
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
								</div>
								<div class="box-body">
									<div class="panel-body">
										<table class="table table-bordered table-hover table-striped" id="JurnalPenilaian-masterKenaikan">
											<tr>
												<th style="white-space: nowrap; vertical-align: middle; text-align: center;">Golongan Penilaian \ Golongan Kerja</th>
												<?php
													for ($i=0; $i < count($daftarGolonganKerja); $i++) 
													{ 
												?>
												<th style="white-space: nowrap; vertical-align: middle; text-align: center;"><?php echo $daftarGolonganKerja[$i]['golkerja'];?></th>
												<?php
													}
												?>
											</tr>
											<?php
												for ($j=0; $j < $jumlahGolongan; $j++) 
												{
											?>
											<tr>
												<td style="text-align: center; vertical-align: middle;"><b><?php echo ($j+1);?></b></td>
												<?php
													for ($k=0; $k < count($daftarGolonganKerja); $k++) 
													{ 
												?>
												<td style="text-align: center; vertical-align: middle;">
													<input class="form-control input_money" name="txtKenaikan[<?php echo $j;?>][<?php echo $k;?>]" 
													<?php
														foreach ($tabelKenaikan as $kenaikan) 
														{
															if
															(
																$kenaikan['gol_kerja']==($daftarGolonganKerja[$k]['golkerja'])
																AND 	$kenaikan['gol_nilai']==($j+1)
															)
															{
																if($kenaikan['nominal_kenaikan']<=0)
																{
													?>
													value=""
													<?php
																}
																else
																{
													?>
													value="<?php echo $kenaikan['nominal_kenaikan'];?>"
													<?php
																}
															}
														}
													?> />
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
									<div class="panel-footer">
										<div class="row text-right">
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
<!-- 	<div id="hapusUnitGroup" class="modal fade modal-danger" role="dialog">
	    <div class="modal-dialog">
	    	<div class="modal-content">
	    		<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterUnitGroup/delete');?>">
	    			<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					    <h4 class="modal-title">Hapus Unit Group</h4>
	    			</div>
	    			<div class="modal-body">
	    				<h5>
	    					Apakah Anda ingin menghapus data ini?
	    				</h5>
	    				<strong>
	    					<h4>
	    						<center>
	    							Unit Group <b><span id="txtDeleteUnitGroup"></span></b>
	    							<input class="form-control hidden" type="text" name="txtDeleteIDUnitGroup" value="" >
	    						</center>
	    					</h4>
	    				</strong>
	    				<br/>
	    				<span style="text-align: right;">
	    					<h6>
	    						<i>
	    							Data yang dihapus akan berpengaruh besar pada data lain yang memiliki kaitan.
	    						</i>
	    					</h6>
	    				</span>	    									
    				</div>
    				<div class="modal-footer">
    					<button type="submit" class="btn btn-danger">Delete</button>
    				</div>
    			</form>
    		</div>
    	</div>
   	</div>	 -->
</section>			
			
				
