<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Training</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/MasterTraining');?>">
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
						<b>Form Edit Master Training</b>
					</div>
					
					<div class="box-body">
					<form method="post" action="<?php echo base_url('ADMPelatihan/MasterTraining/Update')?>">
					<?php foreach($training as $tm){ ?>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Nama Pelatihan</label>
								<div class="col-lg-8">
									<input name="txtNamaPelatihan" class="form-control toupper" placeholder="Nama Pelatihan" value="<?php echo $tm['training_name'] ?>" required >
									<input type="text" name="txtId" value="<?php echo $tm['training_id'] ?>" hidden>
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Standar Nilai</label>
								<div class="col-lg-8">
									<input name="txtBatas" class="form-control" placeholder="Standar Nilai" value="<?php echo $tm['limit'] ?>" onkeypress="return isNumberKey(event)" required >
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Status Pelatihan</label>
								<div class="col-lg-8">
									<select name="slcStatus" class="select4 form-control" data-placeholder="Status Pelatihan" id="slcStatus" required>
										<?php
											$status1='';$status2='';
											if($tm['status']==0){$status1='selected';}
											elseif($tm['status']==1){$status2='selected';}
										?>
										<option <?php echo $status1 ?> value="0">REGULER</option>
										<option <?php echo $status2 ?> value="1">PAKET</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Kuesioner </label>
								<div class="col-lg-8">
									<select class="form-control select4" name="slcQuestionnaire[]" data-placeholder="Kuesioner" multiple="multiple" required>
										<option></option>
										<?php
											$squestionnaire = explode(',', $tm['questionnaire']);
											foreach($questionnaire as $qs){
													$questopt='';
													if(in_array($qs['questionnaire_id'], $squestionnaire)){$questopt='selected';}
										?>
											<option <?php echo $questopt ?> value="<?php echo $qs['questionnaire_id']?>"><?php echo $qs['questionnaire_title'] ?></option>
										<?php }?>
									</select>
								</div>
							</div>
						</div>
						<hr>
						<?php if($tm['status']==1){?>
							<div class="row" style="margin: 10px 10px">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-heading text-right">
										<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddObjective" title="Tambah Baris" onclick="AddObjective('<?php echo base_url(); ?>')"><i class="fa fa-plus"></i></a>
										<a href="javascript:void(0);" class="btn btn-sm btn-danger" id="DelObjective" title="Hapus Baris" onclick="deleteRow('tblObjective')"><i class="fa fa-remove"></i></a>
										<a id="HiddenDelObjective" onclick="deleteRow('tblParticipant')" hidden >Hidden</a>
									</div>
									<div class="panel-body">
										<div class="table-responsive" >
											<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblObjective" id="tblObjective">
												<thead>
													<tr class="bg-primary">
														<th width="100%">Tujuan Pelatihan</th>
													</tr>
												</thead>
												<tbody id="tbodyObjective">
													<?php foreach($objective as $ob){?>
													<tr class="obclone">
														<td>
															<select class="form-control js-slcObjective" name="slcObjective[]" id="slcObjective">
																	<option selected><?php echo $ob['objective']?></option>
															</select>
														</td>
													</tr>
													<?php }?>
													<tr class="obclone">
														<td>
															<select class="form-control js-slcObjective" name="slcObjective[]" id="slcObjective">
																	<option value=""></option>
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
						<?php }?>

						<hr>
						<div class="form-group">
							<div class="col-lg-10 text-right">
								<a href="javascript:window.history.go(-1);" class="btn btn-primary btn btn-flat">Back</a>
									&nbsp;&nbsp;
								<button type="submit" class="btn btn-success btn btn-flat">Save Data</button>
							</div>
						</div>
					<?php } ?>
					<form>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
