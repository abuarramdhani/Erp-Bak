<section class="content">
	<div class="inner" >
	  	<div class="row">
	    	<div class="col-lg-12">
	      		<div class="row">
	        		<div class="col-lg-12">
	        			<div class="col-lg-11">
			            	<div class="text-right">
			            		<h1><b>Rekap Pembayaran JHT</b></h1>
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
								<b>Rekap Pembayaran JHT</b>
				          	</div>
				          	<div class="box-body">
								<div class="row">
									<div class="row" style="margin: 10px 0px">
										<form method="post" action="<?php echo base_url('PayrollManagement/Report/RekapPembayaranJHT/search')?>" enctype="multipart/form-data">
											<div class="col-lg-2">
								            	<input name="txt_no_induk" class="form-control" style="width:265px;" placeholder="NO INDUK"></input>
											</div>							
											<div class="col-lg-2">
												<input name="txtPeriodeTahun" placeholder="PERIODE" id="txtPeriodeTahun" type="text" class="form-control">
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
										if(!empty($data_karyawan)){
											echo '<div class="row" style="margin: 10px 0px">
												<table>
													<tr>
														<td width="80px">Periode</td>
														<td> :&nbsp</td>
														<td>'.$year.'</td>
													</tr>
													<tr>
														<td width="80px">Nama</td>
														<td> :&nbsp</td>
														<td>'.$data_karyawan['nama'].'</td>
													</tr>
													<tr>
														<td width="80px">No Induk</td>
														<td> :&nbsp</td>
														<td>'.$data_karyawan['no_induk'].'</td>
													</tr>
													<tr>
														<td width="80px">Seksi</td>
														<td> :&nbsp</td>
														<td>'.$data_karyawan['seksi'].'</td>
													</tr>
													<tr>
														<td width="80px">No KPJ</td>
														<td> :&nbsp</td>
														<td>'.$data_karyawan['no_kpj'].'</td>
													</tr>
													<tr>
														<td width="50px">PDF</td>
														<td> :&nbsp</td>
														<td><a class="btn btn-xs btn-primary" href="'.site_url('PayrollManagement/Report/RekapPembayaranJHT/GeneratePDF?no_induk='.$no_induk.'&year='.$year).'">'.
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
							                    <th style="text-align:center"><div style="width:40px"></div>NO</th>
												<th style="text-align:center"><div style="width:100px"></div>Bulan</th>
												<th style="text-align:center"><div style="width:100px"></div>Gaji Pokok</th>
												<th style="text-align:center"><div style="width:100px"></div>Tagihan JHT Karyawan</th>
												<th style="text-align:center"><div style="width:100px"></div>Tagihan JHT Perusahaan</th>
												<th style="text-align:center"><div style="width:100px"></div>Total Tagihan JHT</th>
							                </tr>
						                </thead>
						                <tbody>
											<?php $no = 1; 
											if(!empty($pembayaran_jht)){
												foreach($pembayaran_jht as $row) { ?>
												<tr>
													<td align='center'><?php echo $no++;?></td>
													<td align='center'><?php echo $row['bulan'] ?></td>
													<td align='center'><?php echo 'Rp. '.number_format($row['gaji_pokok'],0,",",".") ?></td>
													<td align='center'><?php echo 'Rp. '.number_format($row['jht_karyawan'],0,",",".") ?></td>
													<td align='center'><?php echo 'Rp. '.number_format($row['jht_perusahaan'],0,",",".") ?></td>
													<td align='center'><?php echo 'Rp. '.number_format($row['total_jht'],0,",",".") ?></td>
												</tr>
											<?php 
												}
											}

											if(!empty($total_pembayaran_jht)) {
											?>
												<tr>
													<td align='right' colspan="3"><b>TOTAL</b></td>
													<td align='center'><?php echo 'Rp. '.number_format($total_pembayaran_jht['jht_karyawan'],0,",",".") ?></td>
													<td align='center'><?php echo 'Rp. '.number_format($total_pembayaran_jht['jht_perusahaan'],0,",",".") ?></td>
													<td align='center'><?php echo 'Rp. '.number_format($total_pembayaran_jht['total_jht'],0,",",".") ?></td>
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