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
				   <div class="row">
						    <div class="row" style="margin: 10px 0 10px 0px">
							  <div class="col-lg-5">
							    <b>Daftar nomor induk yang tidak ada di data master pekerja</b>
							  </div>
			          </div>
		            </div>
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-transaksiPenggajian" style="font-size:12px;width:100%;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center; width:30px"><div style="width:40px"></div>NO</th>
                            <th style='text-align:center'><div style="width:100px"></div>Noind</th>
						  </tr>
		                </thead>
		                <tbody>
							<?php
								if(!empty($checkAvailNoind_data)){
									$no = 0;
									foreach($checkAvailNoind_data as $row){
										$no++;
										?>
											<tr>
												<td align='center'><?php echo $no++;?></td>
												<td align='center'><?php echo $row->noind;?></td>
											</tr>
										<?php
									}
								}
							?>
		                </tbody>                                      
		              </table>
					   <div class="row">
			              <form method="post" action="<?php echo base_url('PayrollManagement/BrowseTransaksiPenggajian/Hitung')?>" enctype="multipart/form-data">
						    <div class="row" style="margin: 10px 0 10px 0px">
							  <div class="col-lg-offset-5 col-lg-2">
								<input type="hidden" name="txtYear" id="txtYear" class="form-control" value="<?php echo $varYear ?>" readonly></input>
								<input type="hidden" name="txtMonth" id="txtMonth" class="form-control" value="<?php echo $varMonth ?>" readonly></input>
							    <button class="btn btn-primary btn-block">Hitung</button>
							  </div>
						  </form>
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