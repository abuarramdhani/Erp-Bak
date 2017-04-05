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
						<b>Form Pembuatan Master Paket Pelatihan</b>
					</div>
					
					<div class="box-body">
					<form method="post" action="<?php echo base_url('ADMPelatihan/MasterPackage/Update')?>">
						<?php foreach($GetPackage as $gp){ ?>
						<input type="text" name="txtPackageId" value="<?php echo $gp['package_id']?>" hidden>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Nama Paket Pelatihan</label>
								<div class="col-lg-6">
									<input name="txtNamaPaket" class="form-control toupper" placeholder="Nama Paket Pelatihan" value="<?php echo $gp['package_name']?>" required >
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Jenis Paket Pelatihan</label>
								<div class="col-lg-2">
									<input class="form-control" value="ORIENTASI" readonly>
								</div>
								<label class="col-lg-1 control-label">Peserta</label>
								<div class="col-lg-3">
									<?php
										$pt1='';$pt2='';$pt3='';
										if($gp['participant_type']== 0){$pt1='checked';}
										if($gp['participant_type']== 1){$pt2='checked';}

									?>
									<input type="radio" name="txtPeserta" value="0" <?php echo $pt1?> > Staff<br>
									<input type="radio" name="txtPeserta" value="1" <?php echo $pt2?> > Non-Staff<br>
								</div>
							</div>
						</div>
						<?php } ?>

						<div class="row" style="margin: 10px 10px">
							<div class="col-md-8">
								<div class="panel panel-default">
									<div class="panel-heading text-right">
										<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddTraining" title="Tambah Baris" onclick="AddTraining('<?php echo base_url(); ?>')"><i class="fa fa-plus"></i></a>
										<a href="javascript:void(0);" class="btn btn-sm btn-danger" id="DelTraining" title="Hapus Baris" onclick="deleteRow('tblTrainingPackage')"><i class="fa fa-remove"></i></a>
									</div>
									<div class="panel-body">
										<div class="table-responsive" >
											<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblTrainingPackage" id="tblTrainingPackage">
												<thead>
													<tr class="bg-primary">
														<th width="20%">Hari Ke</th>
														<th width="80%">Nama Pelatihan</th>
													</tr>
												</thead>
												<tbody id="tbodyTrainingPackage">
													<?php foreach($GetPackageTraining as $gpt){?>
													<tr class="clone">
														<td>
															<input id="day" name="TxtDay[]" class="form-control objective" placeholder="Hari Ke" value="<?php echo $gpt['day'] ?>">
														</td>
														<td>
															<select id="Training" class="form-control select2" name="slcTraining[]" data-placeholder="Pelatihan">
																<option></option>
																<?php foreach($GetTraining as $gt){
																	$opt='';if($gpt['training_id']==$gt['training_id']){$opt='selected';}
																?>
																<option <?php echo $opt ?> value="<?php echo $gt['training_id']?>"><?php echo $gt['training_name']?></option>
																<?php } ?>
															</select>
														</td>
													</tr>
													<?php }?>
													<tr class="clone">
														<td>
															<input id="day" name="TxtDay[]" class="form-control objective" placeholder="Hari Ke">
														</td>
														<td>
															<select id="Training" class="form-control select2" name="slcTraining[]" data-placeholder="Pelatihan">
																<option></option>
																<?php foreach($GetTraining as $gt){?>
																<option value="<?php echo $gt['training_id']?>"><?php echo $gt['training_name']?></option>
																<?php } ?>
															</select>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>

						<hr>
						<div class="form-group">
							<div class="col-lg-8 text-right">
								<a href="<?php echo site_url('ADMPelatihan/MasterPackage');?>"  class="btn btn-primary btn btn-flat">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-success btn btn-flat">Save Data</button>
							</div>
						</div>
					<form>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
