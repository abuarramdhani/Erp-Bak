<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Penjadwalan</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/Penjadwalan');?>">
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
						<b data-toogle="tooltip" title="Halaman untuk menjadwalkan sebuah pelatihan independen / single training (pelatihan yang tidak terikat dengan pelatihan lainnya).">Penjadwalan</b>
					</div>
					<div class="box-body">
						<div class="col-md-offset-3 col-md-6">
						<div class="table-responsive" style="overflow:hidden;">
							<table class="table table-striped table-bordered table-hover text-left" id="master-index" style="font-size:14px;">
								<thead class="bg-primary">
									<tr>
										<th width="5%" align="center">NO</th>
										<th width="55%">Pelatihan</th>
										<th width="25%">Informasi Peserta</th>
										<th width="10%" align="center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $no=0; foreach($training as $mt){ $no++ ?>
									<tr>
										<td align="center"><?php echo $no ?></td>
										<td><?php echo $mt['training_name']?></td>
										<td></td>
										<td width="10%" align="center">
											<a data-toogle="tooltip" title="add new" href="<?php echo site_url('ADMPelatihan/Penjadwalan/Create/'.$mt['training_id']);?>" class="btn btn-flat btn-sm btn-success"><i class="fa fa-plus"></i></a>
										</td>
									</tr>
									<?php } ?>
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
	</div>
</section>			
			
				
