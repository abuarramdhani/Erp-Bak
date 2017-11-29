<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Paket Pelatihan</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/MasterPackage');?>">
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
						<b>View Master Paket Pelatihan</b>
					</div>
					
					<div class="box-body">
						<?php foreach($GetPackage as $gp){ ?>
						<div class="col-lg-offset-2 col-lg-8">
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-4 control-label">Nama Paket Pelatihan</label>
								<div class="col-lg-8">
									<input class="form-control" value="<?php echo $gp['package_name']?>" readonly>
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-4 control-label">Jenis Paket Pelatihan</label>
								<div class="col-lg-3">
									<input class="form-control" value="<?php echo $gp['training_type_description']?>" readonly>
								</div>
								<label class="col-lg-2 control-label" >Peserta</label>
								<div class="col-lg-3">
									<input class="form-control" value="<?php echo $gp['participant_type_description']?>" readonly>
								</div>
							</div>
						</div>
						<?php } ?>
						<hr>
						<div class="row" style="margin: 10px 10px">
							<div class="col-md-12">
								<label> Daftar Pelatihan </label>
								<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;">
									<thead>
										<tr class="bg-primary">
											<th width="10%">No</th>
											<th width="20%">Hari Ke</th>
											<th width="70%">Nama Pelatihan</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=0; foreach($GetPackageTraining as $gpt){ $no++ ?>
										<tr>
											<td><?php echo $no?></td>
											<td><?php echo $gpt['day']?></td>
											<td style="text-align:left;"><?php echo $gpt['training_name']?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>

						<hr>
						<div class="form-group">
							<div class="col-lg-12 text-right">
								<a href="<?php echo site_url('ADMPelatihan/MasterPackage');?>"  class="btn btn-primary btn btn-flat">Back</a>
								&nbsp;&nbsp;
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
			
				
