<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Kuesioner</b></h1>
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
						<b>Form Input data kuesioner</b>
					</div>
					
					<div class="box-body">
					<?php foreach($training as $tr){ ?>
						<div class="col-md-12" align="center">
							<h3><b><?php echo $tr['scheduling_name']?></b></h3>
						</div>
						<div class="col-md-offset-2 col-md-8">
							<div class="table-responsive" style="overflow:hidden;">
								<table class="table table-striped table-bordered table-hover text-left" id="dataTables-customer" style="font-size:14px;">
									<thead class="bg-primary">
										<tr>
											<th width="5%" align="center">NO</th>
											<th width="75%">Kuesioner</th>
											<th width="15%" align="center">Action</th>
											<th width="10%" align="center">Submitted</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=0; foreach($questionnaire as $qe  => $value){ $no++ ?>
										<tr>
											<td align="center"><?php echo $no ?></td>
											<td><?php echo $value[0]['questionnaire_title']?></td>
											<td width="15%" align="center">
												<?php if($value[0]['jmlinput'] < $tr['participant_number']){
													if ($value[0]['jmlinput'] != NULL) { ?>
														<a data-toogle="tooltip" title="input new" href="<?php echo site_url('ADMPelatihan/InputQuestionnaire/Create/'.$trainingid.'/'.$value[0]['questionnaire_id']);?>" class="btn btn-flat btn-sm btn-success"><i class="fa fa-plus"></i></a>
														<a data-toogle="tooltip" title="view" href="<?php echo site_url('ADMPelatihan/InputQuestionnaire/view/'.$trainingid.'/'.$value[0]['questionnaire_id']);?>" class="btn btn-flat btn-sm btn-warning"><i class="fa fa-search"></i></a>
													<?php }

													else { ?>
														<a data-toogle="tooltip" title="input new" href="<?php echo site_url('ADMPelatihan/InputQuestionnaire/Create/'.$trainingid.'/'.$value[0]['questionnaire_id']);?>" class="btn btn-flat btn-sm btn-success"><i class="fa fa-plus"></i></a>
														<button class="btn btn-flat btn-sm btn-warning" disabled><i class="fa fa-search"></i></button>
													<?php }
													?>
												<?php }
												elseif ($value[0]['jmlinput'] == $tr['participant_number']) { ?>
														<button class="btn btn-flat btn-sm btn-success" disabled><i class="fa fa-plus"></i></button>
														<a data-toogle="tooltip" title="view" href="<?php echo site_url('ADMPelatihan/InputQuestionnaire/view/'.$trainingid.'/'.$value[0]['questionnaire_id']);?>" class="btn btn-flat btn-sm btn-warning"><i class="fa fa-search"></i></a>
												<?php } 
												else{ ?> 
													<button class="btn btn-flat btn-sm btn-success" disabled><i class="fa fa-plus"></i></button>
													<button class="btn btn-flat btn-sm btn-warning" disabled><i class="fa fa-search"></i></button>
												<?php } ?>
											</td>
											<td align="center">
												<?php
												if ($value[0]['jmlinput'] == NULL) {
													echo "0";
												}else{
													echo $value[0]['jmlinput'];
												} ?>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>

						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-6 text-right">
								<a href="<?php echo base_url('ADMPelatihan/Record/Finished')?>" class="btn btn-primary btn btn-flat">Back</a>
							</div>
						</div>
					<?php } ?>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
