<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Penjadwalan Paket Pelatihan</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/PenjadwalanPackage');?>">
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
						<b>Form Penjadwalan Paket Pelatihan</b>
					</div>
					<div class="box-body">
						<div class="col-lg-offset-2 col-lg-8">
							<div class="table-responsive" style="overflow:hidden;">
								<table class="table table-striped table-bordered table-hover text-left" id="dataTables-customer" style="font-size:14px;">
									<thead class="bg-primary">
										<tr>
											<th width="5%">NO</th>
											<th width="85%">Nama Paket Pelatihan</th>
											<th width="10%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=0; foreach($GetPackage as $gp){ $no++; ?>
										<tr>
											<td><?php echo $no ?></td>
											<td><?php echo $gp['package_name'] ?></td>
											<td style="text-align:center">
												<a data-toogle="tooltip" title="add new" href="<?php echo site_url('ADMPelatihan/PenjadwalanPackage/Create/'.$gp['package_id']);?>" class="btn btn-flat btn-sm btn-success"><i class="fa fa-plus"></i></a>
											</td>
										</tr>

										<?php } ?>
									</tbody>														
								</table>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
							<div class="col-lg-offset-2 col-lg-8 text-right">
								<a onclick="goBack()" class="btn btn-primary btn btn-flat">Back</a>
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
			
				
