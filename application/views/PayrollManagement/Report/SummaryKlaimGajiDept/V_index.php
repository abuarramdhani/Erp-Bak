<section class="content">
	<div class="inner" >
	  	<div class="row">
	    	<div class="col-lg-12">
	      		<div class="row">
	        		<div class="col-lg-12">
	        			<div class="col-lg-11">
			            	<div class="text-right">
			            		<h1><b>Summary Gaji Staff per Departemen</b></h1>
			            	</div>
			          	</div>
			          	<div class="col-lg-1">
			            	<div class="text-right hidden-md hidden-sm hidden-xs">
			            		<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/');?>">
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
								<b>Summary Gaji Staff per Department</b>
				          	</div>
				          	<div class="box-body">
								<div class="row">
									<div class="row" style="margin: 10px 0px">
										<form method="post" action="<?php echo base_url('PayrollManagement/Report/SummaryGajiStaff/search')?>" enctype="multipart/form-data">							
											<div class="col-lg-2">
												<input name="txtPeriodeHitung" placeholder="PERIODE" id="txtPeriodeHitung" type="text" class="form-control">
											</div>
											<div class="col-lg-2">
												<button class="btn btn-warning btn-block">Search</button>
											</div>
										</form>
										<div class="col-lg-3"></div>
									</div>
								</div>
								<?php if ($period_shown) 
								{
									echo '<div class="row" style="margin: 10px 0px">
										<table>
											<tr>
												<td width="50px">Periode</td>
												<td> :&nbsp</td>
												<td>'.$year.' - '.$month.'</td>
											</tr>
											<tr>
												<td width="50px">PDF</td>
												<td> :&nbsp</td>
												<td><a class="btn btn-xs btn-primary" href="'.site_url('PayrollManagement/Report/SummaryGajiStaff/GeneratePDF?year='.$year.'&month='.$month).'">'.
													'<span class="fa fa-file-pdf-o"></span></a></td>
											</tr>
										</table>
									</div>';
								}
								?>
					            <div class="table-responsive">
					              	<table class="table table-striped table-bordered table-hover text-left" style="font-size:12px;">
						                <thead class="bg-primary">
							                <tr>
							                    <th style="text-align:center"><div style="width:160px"></div>KOMPONEN</th>
												<th style="text-align:center"><div style="width:120px"></div>KEUANGAN</th>
												<th style="text-align:center"><div style="width:120px"></div>PEMASARAN</th>
												<th style="text-align:center"><div style="width:120px"></div>PRODUKSI</th>
												<th style="text-align:center"><div style="width:120px"></div>PERSONALIA</th>
												<th style="text-align:center"><div style="width:120px"></div>TOTAL</th>
							                </tr>
						                </thead>
						                <tbody>
											<?php $no = 1; 
											if(!empty($summary)){
												$num_components = count($summary);
												for ($i = 0; $i < $num_components; $i++)
												{?>
													<tr>
													<?php 
													for ($j = 0; $j < 6; $j++)
													{
														if ($j == 0)
														{
															echo "<td align='left'><b>".$summary[$i][$j]."</b></td>";
														} else
														{
															echo "<td align='center'>Rp. ".number_format($summary[$i][$j],0,",",".")."</td>";
														}
													}
													?>
													</tr>
											<?php 
												}
											}
											?>
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