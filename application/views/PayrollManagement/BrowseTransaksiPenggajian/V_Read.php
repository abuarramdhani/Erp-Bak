<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Browse Transaksi Penggajian</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/TransaksiHutang');?>">
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
                    <b>Transaksi Penggajian</b>
		          </div>
		          <div class="box-body">
		           <div class="table-responsive"> 
					   <div class="row2">
							<div class="col-md-12">
								<?php foreach($strukData as $row){ ?>				   
									<table class="table table-hover text-left" id="dataTables-transaksiPenggajian" style="font-size:12px;">
										<tbody>
											<tr>
												<th>Noind</th>
												<td>:</td>
												<td><?php echo $row->noind; ?></td>
												<th>Seksi</th>
												<td>:</td>
												<td><?php echo $row->seksi; ?></td>
											</tr>
											<tr>
												<th>Nama</th>
												<td>:</td>
												<td><?php echo $row->nama; ?></td>
												<th>Unit</th>
												<td>:</td>
												<td><?php echo $row->unit; ?></td>
											</tr>
											<tr>
												<th>Periode Gaji</th>
												<td>:</td>
												<td><?php echo $row->tanggal; ?></td>
												<th>Department</th>
												<td>:</td>
												<td><?php echo $row->dept; ?></td>
											</tr>
										</tbody>
									</table>
								<?php } ?>
							</div>
						</div>	
						<div class="row2">
							<div class="col-md-12">
								<div class="box" style="border-top-color: #3c8dbc;">
									<div class="box-header with border" style="background-color: #f8f8f8">
										<h3 class="box-title">Master Gaji</h3>
										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
										</div>
									</div>
									<div class="box-body" style="display: block; background-color: #f8f8f8">
										<table class="table table-hover text-left" id="dataTables-transaksiPenggajian" style="font-size:12px;">
											<tr>
												<th>
													Gaji Pokok (bulan)
												</th>
												<td>
													:
												</td>
												<td style="text-align:right;">
													<?php echo number_format((int)$row->gaji_pokok); ?>
												</td>
												<th>
													Ins. Msk Sore
												</th>
												<td>
													:
												</td>
												<td>
													Gaji Pokok (bulan)
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
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