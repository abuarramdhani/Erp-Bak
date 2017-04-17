<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Potongan Dana Pensiun</b></h1>
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
					<b>Potongan Dana Pensiun</b>
		          </div>
		          <div class="box-body">
					<div class="row">
						<div class="row" style="margin: 10px 0px">
							<form method="post" action="<?php echo base_url('PayrollManagement/Report/PotonganDanaPensiun/search')?>" enctype="multipart/form-data">
								<div class="col-lg-2">
									<input name="txtPeriodeHitung" placeholder="Periode" id="txtPeriodeHitung" type="text" class="form-control">
								</div>
								<div class="col-lg-2">
									<button class="btn btn-warning btn-block">Search</button>
								</div>
							</form>
							<div class="col-lg-3">
							</div>
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
										<td width="50px">Total</td>
										<td> :&nbsp</td>
										<td>Rp. '.number_format($total,0,",",".").'</td>
									</tr>
									<tr>
										<td width="50px">PDF</td>
										<td> :&nbsp</td>
										<td><a class="btn btn-xs btn-primary" href="'.site_url('PayrollManagement/Report/PotonganDanaPensiun/GeneratePDF?year='.$year.'&month='.$month).'">'.
											'<span class="fa fa-file-pdf-o"></span></a></td>
									</tr>
								</table>
							</div>';
						}
					?>
		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-reportDanaPensiun" style="font-size:12px;">
		                <thead class="bg-primary">
			                <tr>
			                    <th style="text-align:center"><div style="width:40px"></div>NO</th>
								<th style="text-align:center"><div style="width:100px"></div>No. Induk</th>
								<th style="text-align:center"><div style="width:100px"></div>Nama</th>
								<th style="text-align:center"><div style="width:100px"></div>Seksi</th>
								<th style="text-align:center"><div style="width:100px"></div>No. Rekening</th>
								<th style="text-align:center"><div style="width:100px"></div>Jumlah</th>
			                </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; 
							if(!empty($dana_pensiun)){
								foreach($dana_pensiun as $row) { ?>
								<tr>
									<td align='center'><?php echo $no++;?></td>
									<td align='center'><?php echo $row['no_induk'] ?></td>
									<td align='center'><?php echo $row['nama'] ?></td>
									<td align='center'><?php echo $row['seksi'] ?></td>
									<td align='center'><?php echo $row['norek'] ?></td>
									<td align='center'><?php echo 'Rp. '.number_format($row['jumlah'],0,",",".") ?></td>
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