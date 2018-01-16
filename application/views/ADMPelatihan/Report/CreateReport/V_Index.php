<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Ruangan</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
							<a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/Report/CreateReport');?>">
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
						<a href="<?php echo site_url('ADMPelatihan/Report/CreateReport/createReport') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
							<button type="button" class="btn btn-default btn-sm">
							  <i class="icon-plus icon-2x"></i>
							</button>
						</a>
						<b data-toogle="tooltip" title="Halaman membuat report">Create Report</b>
					</div>
					<div class="box-body">
						<div class="table-responsive" style="overflow:hidden;">
							<table class="table table-striped table-bordered table-hover text-left" id="master-index" style="font-size:14px; min-width: 1500px">
								<thead class="bg-primary">
									<tr>
										<th width="5%">NO</th>
										<th width="8%" style="text-align: center;">Action</th>
										<th width="10%">Tanggal Dibuat</th>
										<th width="30%">Nama Training</th>
										<th width="10%">Tanggal Training</th>
										<th width="10%">Jenis Training</th>
										<th width="30%">Pelaksana</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td></td>
										<td style="vertical-align: middle; padding-left: 15px">
											<a style="margin-right:4px" href="" data-placement="bottom" title="Cetak Data" >
												<span class="fa fa-print fa-2x"></span>
											</a>
                                        	<a style="margin-right:4px" href="" data-placement="bottom" title="Edit Data">
                                        		<span class="fa fa-pencil-square-o fa-2x"></span>
                                        	</a>
                                        	<a style="margin-right:4px" href="" href="" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');">
                                        		<span class="fa fa-trash fa-2x"></span>
                                        	</a>
										</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
											
									<!-- MODAL  DELETE-->
									<div class="modal fade modal-danger" id="showModalDel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<div class="col-sm-2"></div>
													<div class="col-sm-8" align="center"><h5><b>PERHATIAN !</b></h5></div>
													<div class="col-sm-2"><h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h5></div>
													<br>
												</div>
												<div class="modal-body" align="center">
													Apakah anda yakin ingin menghapus <b id="data-id">
													</b> dari jadwal pelatihan ? <br>
													<small>*) Data yang sudah dihapus tidak dapat dikembalikan lagi.</small>
													<div class="row">
														<br>
														<a href="" class="btn btn-default"><i class="fa fa-remove"></i> DELETE</a>
													</div>
												</div>
											</div>
										</div>
									</div>
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
			
				
