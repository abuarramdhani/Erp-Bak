<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
							<h1><b>Analisa Penggolongan</b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
	                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/JurnalPenilaianPersonalia');?>">
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
							<b data-toogle="tooltip" title="Halaman untuk membuat template penilaian.">Analisa Penggolongan</b>
						</div>
						<div class="box-body">
							<div class="panel-body">
									<table class="table table-striped table-bordered table-hover" id="" style="font-size:14px;">
										<thead class="bg-primary">
											<tr>
												<th colspan="2" style="vertical-align: middle; text-align: center;">Unit Group \ Golongan</th>
												<?php
													for ($a = 0; $a < $jumlahGolongan; $a++) 
													{ 
												?>
												<th style="vertical-align: middle; text-align: center;"><?php echo ($a+1);?></th>
												<?php
													}
												?>
												<th style="vertical-align: middle; text-align: center;">Total</th>
											</tr>
										</thead>
										<tbody>
											<?php
												for ($b=0; $b < count($golonganKerja); $b++)
												{
													$totalPenggolonganRencana 	= 	0;
													$totalPenggolonganHasil 	=	0;
											?>
											<tr>
												<th rowspan="2" class="bg-primary" style="text-align: center; vertical-align: middle;"><?php echo $golonganKerja[$b]['golkerja'];?></th>
												<th>Rencana</th>
												<?php
													for ($c = 0; $c < $jumlahGolongan; $c++) 
													{
														$backgroundColor 	=	'bg-danger';
														if($penggolonganRencana[$b][$c]==$penggolonganHasil[$b][$c])
														{
															$backgroundColor 	=	'bg-success';
														}
												?>
												<td class="<?php echo $backgroundColor;?>" style="text-align: center; vertical-align: middle;"><?php echo $penggolonganRencana[$b][$c];?></td>
												<?php
														$totalPenggolonganRencana	+=	$penggolonganRencana[$b][$c];
													}

													$backgroundColor 	=	'bg-danger';
													if($totalPenggolonganRencana==$totalPenggolonganHasil)
													{
														$backgroundColor 	=	'bg-success';
													}
												?>
												<td class="<?php echo $backgroundColor;?>" style="text-align: center; vertical-align: middle;"><?php echo $totalPenggolonganRencana;?></td>
											</tr>
											<tr>
												<th>Aktual</th>
												<?php
													for ($c = 0; $c < $jumlahGolongan; $c++) 
													{
														$backgroundColor 	=	'bg-danger';
														if($penggolonganRencana[$b][$c]==$penggolonganHasil[$b][$c])
														{
															$backgroundColor 	=	'bg-success';
														}													 
												?>
												<td class="<?php echo $backgroundColor;?>" style="text-align: center; vertical-align: middle;"><?php echo $penggolonganHasil[$b][$c];?></td>
												<?php
														$totalPenggolonganHasil	+=	$penggolonganHasil[$b][$c];
													}

													$backgroundColor 	=	'bg-danger';
													if($totalPenggolonganRencana==$totalPenggolonganHasil)
													{
														$backgroundColor 	=	'bg-success';
													}													
												?>
												<td class="<?php echo $backgroundColor;?>" style="text-align: center; vertical-align: middle;"><?php echo $totalPenggolonganHasil;?></td>											
											</tr>
											<?php
												}
											?>
										</tbody>
									</table>								
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="<?php echo base_url('PenilaianKinerja/JurnalPenilaianPersonalia/');?>" class="btn btn-primary btn-lg btn-rect">Kembali</a>
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
			
				
