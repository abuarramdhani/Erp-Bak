<section class="content">
	<div class="inner" >
	  	<div class="row">
	    	<div class="col-lg-12">
	      		<div class="row">
	        		<div class="col-lg-12">
	        			<div class="col-lg-11">
			            	<div class="text-right">
			            		<h1><b>Riwayat Mutasi Pekerja</b></h1>
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
								<b>Laporan Riwayat Mutasi Pekerja</b>
				          	</div>
				          	<div class="box-body">
								<div class="row">
									<div class="row" style="margin: 10px 0px">
										<form method="post" action="<?php echo base_url('PayrollManagement/Report/DataMutasiPekerja/search')?>" enctype="multipart/form-data">			
											<label class="col-lg-1 control-label">Tanggal</label>
											<div class="col-lg-2">
												<input name="TxtStartDate" class="form-control periode_mutasi">
											</div>
											<label class="col-lg-1 control-label" align="center">s/d</label>
											<div class="col-lg-2">
												<input name="TxtEndDate" class="form-control periode_mutasi">
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
										if(!empty($data_mutasi)){
											echo '<div class="row" style="margin: 10px 0px">
												<table>
													<tr>
														<td width="80px">Periode</td>
														<td> :&nbsp</td>
														<td>'.$tgl_awal.' - '.$tgl_akhir.'</td>
													</tr>
													<tr>
														<td width="50px">PDF</td>
														<td> :&nbsp</td>
														<td><a class="btn btn-xs btn-primary" href="'.site_url('PayrollManagement/Report/DataMutasiPekerja/GeneratePDF?awal='.$tgl_awal.'&akhir='.$tgl_akhir).'">'.
															'<span class="fa fa-file-pdf-o"></span></a></td>
													</tr>
												</table>
											</div>';
										}
									}
								?>
					            <div class="table-responsive">
					              	<table class="table table-striped table-bordered table-hover text-left" id="dataTables-reportRiwayatMutasi" style="font-size:12px;">
						                <thead class="bg-primary">
							                <tr>
							                    <th style="text-align:center"><div style="width:5%"></div>NO</th>
												<th style="text-align:center"><div style="width:10%"></div>Tanggal</th>
												<th style="text-align:center"><div style="width:10%"></div>No Induk</th>
												<th style="text-align:center"><div style="width:25%"></div>Nama</th>
												<th style="text-align:center"><div style="width:25%"></div>Seksi Lama</th>
												<th style="text-align:center"><div style="width:25%"></div>Seksi Baru</th>
							                </tr>
						                </thead>
						                <tbody>
											<?php $no = 1; 
											if(!empty($data_mutasi)){
												foreach($data_mutasi as $row) { ?>
												<tr>
													<td align='center'><?php echo $no++;?></td>
													<td align='center'><?php echo $row['tanggal'] ?></td>
													<td align='center'><?php echo $row['no_induk'] ?></td>
													<td align='center'><?php echo $row['nama'] ?></td>
													<td align='center'><?php echo $row['seksi_lama'] ?></td>
													<td align='center'><?php echo $row['seksi_baru'] ?></td>
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