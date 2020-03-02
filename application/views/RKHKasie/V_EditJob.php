<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1>
									<b>
										<?= $Title ?>
									</b>
								</h1>
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('ReceivePO/History/');?>">
									<i class="fa fa-list fa-2x">
									</i>
									<span>
										<br />
									</span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info box-solid">
					<nav class="navbar">
                          <div class="container-fluid">
                            <div class="navbar-header">
                            <ul class="nav nav-tabs nav-justified">
                               <li class="active" ><a data-toggle="tab" href="#tambahlane" >TAMBAH LANE</a></li>
                               <li ><a data-toggle="tab"  href="#buatjob">BUAT JOB</a></li>
                               <li><a data-toggle="tab" href="#hapusjob">HAPUS JOB</a></li>
                           </ul>
                       </div>
                   </nav>
	                  <div class="box-body">
	                  	<div class="tab-content">
							 <div id="tambahlane" class="tab-pane fade in active">  
			                    <div class="col-lg-12">
			                        <div class="table-responsive">
			                            <div class="row" style="margin: 1px;">
			                                <div class="col-lg-12">
			                                    <div class="panel-body">
			                                    	<div class="col-md-4"  style="text-align: right;"><b>NOMOR LANE</b></div>
			                                    	<div class="col-md-6" style="text-align: left; width: 30%"><input type="text" class="form-control" name="lane"></div>
			                                    </div>
			                                    <div class="panel-body">
			                                    	<div class="col-md-4"  style="text-align: right;"><b>OPERATOR</b></div>
			                                    	<div class="col-md-6" style="text-align: left; width: 30%"><input type="text" class="form-control" name="operator"></div>
			                                    </div>
			                                    <div class="panel-body">
			                                    	<div class="col-md-12"  style="text-align: center;"><button class="btn btn-danger" style="border-radius: 70px">Tambah</i></button></div>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                    </div>                
		                	</div>
		                	<div id="buatjob" class="tab-pane fade">  
			                    <div class="col-lg-12">
			                        <div class="table-responsive">
			                            <div class="row" style="margin: 1px;">
			                                <div class="col-lg-12">
			                                    <div class="panel-body">
			                                    	<div class="col-md-1"  style="text-align: left;"><b>LANE</b></div>
			                                    	<div class="col-md-4" style="text-align: left; width: 30%"><input type="text" class="form-control" name="pilihlane"></div>
			                                    </div>
			                                    <div class="panel-body">
			                                    	<div class="col-md-1"  style="text-align: left;"><b>PERCENT</b></div>
			                                    	<div class="col-md-4" style="text-align: left; width: 30%"><input type="text" class="form-control" name="precent" readonly="readonly"></div>
			                                    </div>
			                                    <div class="panel-body">
			                                    	<div class="col-md-12">
			                                    		<table class="table table-bordered ">
			                                    			<thead class="bg-yellow">
			                                    				<tr>
			                                    					<th class="text-center">Kode</th>
			                                    					<th class="text-center">Nama Barang</th>
			                                    					<th class="text-center">Qty</th>
			                                    					<th class="text-center">Action</th>
			                                    				</tr>
			                                    			</thead>
			                                    			<tbody id="tambahisi">
			                                    				<tr>
			                                    					<td class="text-center"><input type="text" class="form-control" name="code[]"></td>
			                                    					<td class="text-center"><input type="text" class="form-control" name="namabar[]" readonly="readonly"></td>
			                                    					<td class="text-center"><input type="text" class="form-control" name="quantity[]"></td>
			                                    					<td class="text-center"><a class="btn btn-default btn-sm" onclick="nambahteros()"><i class="fa fa-plus"></i></a></td>
			                                    				</tr>
			                                    			</tbody>
			                                    		</table>
			                                    		
			                                    	</div>
			                                    </div>
			                                    <div class="panel-body">
			                                    	<div class="col-md-12" style="text-align: right">
			                                    		<button class="btn btn-info" style="border-radius: 70px">Tambah</button>
			                                    	</div>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                    </div>                
		                	</div>
		                	   	<div id="hapusjob" class="tab-pane fade">  
			                    <div class="col-lg-12">
			                        <div class="table-responsive">
			                            <div class="row" style="margin: 1px;">
			                                <div class="col-lg-12">
			                                    <div class="panel-body">
			                                    	<div class="col-md-1"  style="text-align: left;"><b> LANE</b></div>
			                                    	<div class="col-md-4" style="text-align: left; width: 30%"><input type="text" class="form-control" name="pilihlane"></div>
			                                    </div>
			                                    <div class="panel-body">
			                                    	<div class="col-md-12">
			                                    		<table class="table table-bordered ">
			                                    			<thead class="bg-teal">
			                                    				<tr>
			                                    					<th class="text-center">No</th>
			                                    					<th class="text-center">No Job</th>
			                                    					<th class="text-center">Kode</th>
			                                    					<th class="text-center">Nama Barang</th>
			                                    					<th class="text-center">Target PPIC</th>
			                                    					<th class="text-center">Target PE</th>
			                                    					<th class="text-center">Presentase Plan</th>
			                                    					<th class="text-center">Action</th>
			                                    				</tr>
			                                    			</thead>
			                                    			<tbody id="tambahisi">
			                                    				<tr>
			                                    					<td class="text-center"><input type="hidden"></td>
			                                    					<td class="text-center"><input type="hidden" name="nojobb[]"></td>
			                                    					<td class="text-center"><input type="hidden" name="kode[]"></td>
			                                    					<td class="text-center"><input type="hidden" name="nambar[]"></td>
			                                    					<td class="text-center"><input type="hidden" name="targetppic[]"></td>
			                                    					<td class="text-center"><input type="hidden" name="targetpe[]"></td>
			                                    					<td class="text-center"><input type="hidden" name="persenplan[]"></td>
			                                    					<td class="text-center"><button class="btn btn-danger btn-xs" onclick="hapusdata(1)">Hapus</button></td>
			                                    				</tr>
			                                    			</tbody>
			                                    		</table>
			                                    		
			                                    	</div>
			                                    </div>
			                                   <!--  <div class="panel-body">
			                                    	<div class="col-md-12" style="text-align: right">
			                                    		<button class="btn btn-success" style="border-radius: 70px">Selesai</button>
			                                    	</div>
			                                    </div> -->
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