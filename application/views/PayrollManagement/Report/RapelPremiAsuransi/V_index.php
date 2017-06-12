<section class="content">
	<div class="inner" >
	  	<div class="row">
	    	<div class="col-lg-12">
	      		<div class="row">
	        		<div class="col-lg-12">
	        			<div class="col-lg-11">
			            	<div class="text-right">
			            		<h1><b>Rapel Premi Asuransi</b></h1>
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
								<b>Laporan Rapel Premi Asuransi</b>
				          	</div>
				          	<div class="box-body">
								<div class="row">
									<div class="row" style="margin: 10px 0px">
										<form method="post" action="<?php echo base_url('PayrollManagement/Report/RapelPremiAsuransi/search')?>" enctype="multipart/form-data">
											<div class="col-lg-2">
												<input name="txtPeriodeTahun" placeholder="PERIODE" id="txtPeriodeTahun" type="text" class="form-control txtPeriodeTahun">
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
										if(!empty($premi_asuransi)){
											echo '<div class="row" style="margin: 10px 0px">
												<table>
													<tr>
														<td width="80px">Periode</td>
														<td> :&nbsp</td>
														<td>'.$year.'</td>
													</tr>
													<tr>
														<td width="80px">Total</td>
														<td> :&nbsp</td>
														<td>Rp. '.number_format($total['grand_total'],0,",",".").'</td>
													</tr>
													<tr>
														<td width="50px">PDF</td>
														<td> :&nbsp</td>
														<td><a class="btn btn-xs btn-primary" href="'.site_url('PayrollManagement/Report/RapelPremiAsuransi/GeneratePDF?year='.$year).'">'.
															'<span class="fa fa-file-pdf-o"></span></a></td>
													</tr>
												</table>
											</div>';
										}
									}
								?>
					            <div class="table-responsive">
					              	<table class="table table-striped table-bordered table-hover text-left" style="font-size:12px;">
						                <thead class="bg-primary">
							                <tr>
							                    <th style="text-align:center">NO</th>
												<th style="text-align:center">No Induk</th>
												<th style="text-align:center">No KPJ</th>
												<th style="text-align:center">Nama</th>
												<th style="text-align:center">JHT</th>
												<th style="text-align:center">JKK</th>
												<th style="text-align:center">JKM</th>
												<th style="text-align:center">JKN</th>
												<th style="text-align:center">Total</th>
							                </tr>
						                </thead>
						                <tbody>
											<?php $no = 1; 
											if(!empty($premi_asuransi)){
												foreach($premi_asuransi as $row) { ?>
												<tr>
													<td align='center'><?php echo $no++;?></td>
													<td align='center'><?php echo $row['no_induk'] ?></td>
													<td align='center'><?php echo $row['no_kpj'] ?></td>
													<td align='center'><?php echo $row['nama'] ?></td>
													<td align='center'><?php echo 'Rp. '.number_format($row['jht'],0,",",".") ?></td>
													<td align='center'><?php echo 'Rp. '.number_format($row['jkk'],0,",",".") ?></td>
													<td align='center'><?php echo 'Rp. '.number_format($row['jkm'],0,",",".") ?></td>
													<td align='center'><?php echo 'Rp. '.number_format($row['jkn'],0,",",".") ?></td>
													<td align='center'><?php echo 'Rp. '.number_format($row['total'],0,",",".") ?></td>
												</tr>
											<?php 
												}
											}

											if(!empty($total)) {
											?>
												<tr>
													<td align='right' colspan="4"><b>GRAND TOTAL</b></td>
													<td align='center'><?php echo 'Rp. '.number_format($total['total_jht'],0,",",".") ?></td>
													<td align='center'><?php echo 'Rp. '.number_format($total['total_jkk'],0,",",".") ?></td>
													<td align='center'><?php echo 'Rp. '.number_format($total['total_jkm'],0,",",".") ?></td>
													<td align='center'><?php echo 'Rp. '.number_format($total['total_jkn'],0,",",".") ?></td>
													<td align='center'><?php echo 'Rp. '.number_format($total['grand_total'],0,",",".") ?></td>
												</tr>
											<?php
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