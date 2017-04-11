<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
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
						<div class="col-lg-11">
							<div class="text-left">
								<b data-toogle="tooltip" title="Daftar pelatihan yang masuk dalam susunan paket pelatihan">Daftar Pelatihan</b>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-left hidden-md hidden-sm hidden-xs">
	                           	<?php if(empty($GetScheduledTraining)){?>
	                           	<a class="btn btn-sm btn-default btn-flat" data-toogle="tooltip" title="Jadwalkan Pelatihan Sekaligus" href="<?php echo site_url('ADMPelatihan/Penjadwalan/CreatebyPackage/'.$id);?>">
	                                <i class="fa fa-plus"></i> Add</i>
	                                <span><br/></span>
	                            </a>
	                            <?php }?>
							</div>
						</div>
					</div>
					<div class="box-body">
						<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;">
							<thead>
								<tr class="bg-primary">
									<th width="5%">No</th>
									<th width="10%">Hari Ke</th>
									<th width="55%">Pelatihan</th>
									<th width="20%">Keterangan</th>
									<th width="10%">Action</th>
									<th><th>
								</tr>
							</thead>
							<tbody id="tbodyParticipant">
								<?php $no=0;foreach($GetPackageTraining as $gpt){ $no++ ?>
								<tr>
									<td><?php echo $no?></td>
									<td><?php echo $gpt['day']?></td>
									<td><?php echo $gpt['training_name']?></td>
									<td>
										<?php
											$ready=0;
											foreach($GetScheduledTraining as $sdt){
												if($gpt['package_training_id']==$sdt['package_training_id']){$ready=1; 
													if($sdt['status']==0){echo '<span class="label label-primary">Sudah Dijadwalkan</span>';}
													elseif($sdt['status']==1){echo '<span class="label label-success">Sudah Terlaksana</span>';}
										?>
												
										<?php }} if($ready==0){ ?>
												<span class="label label-danger">Belum Dijadwalkan</span>
										<?php } ?>
									</td>
									<td>
										<?php
											$ready=0;
											foreach($GetScheduledTraining as $sdt){
												if($gpt['package_training_id']==$sdt['package_training_id']){$ready=1; ?>
												<a href="<?php echo site_url('ADMPelatihan/Record/Detail/'.$sdt['scheduling_id'] )?>" class="btn btn-sm btn-warning btn-flat"><i class="fa fa-search"></i> View</a>
										<?php }} if($ready==0){ ?>
												<a href="<?php echo site_url('ADMPelatihan/Penjadwalan/CreatebyPackageSingle/'.$id.'/'.$gpt['package_training_id'] )?>" data-toogle="tooltip" title="Jadwalkan Pelatihan" class="btn btn-sm btn-success btn-flat"><i class="fa fa-plus"></i> Add</a>
										<?php } ?>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
							<div class="col-lg-12 text-right">
								<a href="<?php echo site_url('ADMPelatihan/PenjadwalanPackage');?>" class="btn btn-primary btn btn-flat">Back</a>
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