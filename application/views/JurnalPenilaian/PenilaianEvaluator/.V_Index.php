 <section class="content">
	<div class="inner" >
		<div class="row">
			<!-- <form method="post" action="<?php echo base_url('PenilaianKinerja/JurnalPenilaianEvaluator/update');?>" class="form-horizontal" enctype="multipart/form-data"> -->
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
								<h1><b>Evaluasi Seksi</b></h1>
								</div>
							</div>
							<div class="col-lg-1">
								<div class="text-right hidden-md hidden-sm hidden-xs">
		                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/JurnalPenilaianEvaluator');?>">
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
							<div class="box box-primary box-solid box-default">
								<div class="box-header with-border">
									<span style="text-align: center;">Pilih unit group</span>
								</div>
								<div class="dix-body">
									<div class="panel-body">
												<div class="btn-group">
													<?php
														foreach ($daftarUnitGroup as $unitGroup) 
														{
													?>
													<a href="#evaluasi-<?php echo $unitGroup['unit_group'];?>" style="text-align: center;" class="btn btn-success btn-lg">
														<?php echo $unitGroup['unit_group'];?>
													</a>
													<?php
														}
													?>
												</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
						foreach ($daftarUnitGroup as $unitGroup) 
						{
					?>
					<div class="row">
						<form method="post" action="<?php echo base_url('PenilaianKinerja/JurnalPenilaianEvaluator/update');?>" class="form-horizontal" enctype="multipart/form-data">
							<div class="col-lg-12">
								<div class="box box-primary box-solid box-default" id="evaluasi-<?php echo $unitGroup['unit_group'];?>">
									<div class="box-header with-border">
										<span>Input Nilai Pekerja Unit Group <b><?php echo $unitGroup['unit_group'];?></b></span>
										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse">
												<i class="fa fa-plus"></i>
											</button>
											</div>
									</div>
									<div class="box-body">
										<div class="panel-body">
											<table class="table table-bordered JurnalPenilaian-evaluasiSeksi">
												<thead>
													<tr>
														<th style="text-align: center; vertical-align: middle; white-space: nowrap;">No.</th>
														<th style="text-align: center; vertical-align: middle; white-space: nowrap;">Nomor Induk</th>
														<th style="text-align: center; vertical-align: middle; white-space: nowrap;">Nama</th>
														<th style="text-align: center; vertical-align: middle; white-space: nowrap;">Kodesie</th>
														<th style="text-align: center; vertical-align: middle; white-space: nowrap;">Unit Group</th>
														<?php
															foreach ($daftarAspek as $aspek) 
															{
														?>
														<th style="text-align: center; vertical-align: middle; white-space: nowrap;">&Sigma;<?php echo strtoupper($aspek['singkatan']);?></th>
														<?php
															}
														?>
														<th style="text-align: center; vertical-align: middle; white-space: nowrap;">&Sigma;SK (hari)</th>
														<th style="text-align: center; vertical-align: middle; white-space: nowrap;">&Sigma;SK (bulan)</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$i = 0;
														foreach ($evaluasiSeksi as $evaluasi) 
														{
															$idEvaluasi 	=	str_replace(array('+','/','='), array('-','_','~'), $this->encryption->encrypt($evaluasi['id_assessment']));
															if($evaluasi['id_unit_group']==$unitGroup['id_unit_group'])
															{
													?>
													<tr>
														<td style="text-align: center; vertical-align: middle; width: 5%"><?php echo ($i+1);?></td>
														<td style="text-align: center; vertical-align: middle; width: 5%">
															<?php echo $evaluasi['noind'];?>
															<input type="text" class="hidden" name="txtIDEvaluasiSeksi[<?php echo $i;?>]" value="<?php echo $idEvaluasi;?>" />
														</td>
														<td style="vertical-align: middle; white-space: nowrap; width: 17%"><?php echo $evaluasi['nama'];?></td>
														<td style="text-align: center; vertical-align: middle; width: 8%"><?php echo $evaluasi['kodesie'];?></td>
														<td style="text-align: center; vertical-align: middle; width: 5%"><?php echo $evaluasi['unit_group'];?></td>
														<?php
																foreach ($daftarAspek as $aspek)
																{
																	$nilai[$aspek['singkatan']]	=	0;

																	$nama 	=	't_'.$aspek['singkatan'];

																	$attrAutoFocus 	=	'';

																	if(!(empty($evaluasi[$nama])))
																	{
																		$nilai[$aspek['singkatan']]	=	$evaluasi[$nama];
																	}

																	if($i == 0 && strtoupper($aspek['singkatan'])=='PWK')
																	{
																		$attrAutoFocus 	= 	'autofocus=""';
																	}

																	if(strtoupper($aspek['singkatan'])=='SP' || strtoupper($aspek['singkatan'])=='TIM')
																	{
														?>
														<td style="text-align: center; vertical-align: middle; width: 10%; max-width: 10%">
															<?php echo $evaluasi[$nama];?>
															<input type="text" class="hidden" name="txttotal<?php echo strtoupper($aspek['singkatan']);?>[<?php echo $i;?>]" value="<?php echo $evaluasi[$nama];?>" style="width: auto"/>
														</td>
														<?php
																	}
																	else
																	{
														?>
														<td style="text-align: center; vertical-align: middle; width: 10%; max-width: 10%">
																<input type="number" class="form-control" min="0" step="0.1" max="100" name="txttotal<?php echo strtoupper($aspek['singkatan']);?>[<?php echo $i;?>]" placeholder="NILAI <?php echo strtoupper($aspek['singkatan']);?>" value="<?php echo $nilai[$aspek['singkatan']];?>" <?php echo $attrAutoFocus;?>  style="width: auto"/>
														</td>
														<?php
																	}
																}
														?>
														<td style="text-align: center; vertical-align: middle; width: 10%; max-width: 10%">
															<?php echo $evaluasi['total_hari_sk'];?>
															<input type="text" class="hidden" name="txttotalHariSK[<?php echo $i;?>]" value="<?php echo $evaluasi['total_hari_sk'];?>" style="width: auto"/>
														</td>
														<td style="text-align: center; vertical-align: middle; width: 10%; max-width: 10%">
															<?php echo $evaluasi['total_bulan_sk'];?>
															<input type="text" class="hidden" name="txttotalBulanSK[<?php echo $i;?>]" value="<?php echo $evaluasi['total_bulan_sk'];?>" style="width: auto"/>
														</td>
														<?php
																$i++;
														?>
														<?php
															}															
														?>											
													</tr>														
													<?php
															
														}
													?>
												</tbody>
											</table>
										</div>
										<div class="panel-footer">
											<div class="row text-right">
												<button href="#btnSimpan" class="btn btn-primary btn-lg btn-rect">Save Data</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<?php
						}
					?>					
				</div>
			<!-- </form>	 -->
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
   	</div> -->	
</section>			
			
				
