<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Kuesioner</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
							<a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/MasterQuestionnaire');?>">
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
						<a href="<?php echo site_url('ADMPelatihan/MasterQuestionnaire/create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
							<button type="button" class="btn btn-default btn-sm">
								<i class="icon-plus icon-2x"></i>
							</button>
						</a>
						<b>Form Edit Master Kuesioner</b>
					</div>
					<div class="box-body">
					<?php 	foreach($title as $questionnaire) 
							{
								foreach($segment_title as $segment)
									{
										$Qs_id=$questionnaire['questionnaire_id'];
										$Sg_id=$segment['segment_id'];
					?>
						<form method="post" action="<?php echo site_url('ADMPelatihan/MasterQuestionnaire/EditSaveStatement')."/".$Qs_id."/".$Sg_id;?>">			
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Judul Kuesioner</label>
								<div class="col-lg-6">
								<input name="txtQuestionnaireId" value="<?php echo $questionnaire['questionnaire_id']; ?>" hidden>
								<input name="txtQuestionnaireName" class="form-control" value="<?php echo $questionnaire['questionnaire_title']; ?>" readonly>
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Segment Kuesioner</label>
								<div class="col-lg-6">
								<input name="txtSegmentId" value="<?php echo $segment['segment_id']; ?>" hidden>
								<input name="txtSegment" class="form-control" value="<?php echo $segment['segment_description']; ?>" readonly>
								</div>
							</div>
						</div>
						<?php 
									}
							}
						?>
						<hr>
							<div class="row" style="margin: 10px 10px">
							<div class="col-md-8">
								<div class="panel panel-default">
									<div class="panel-heading text-right">
										<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddStatement" title="Tambah Baris" onclick="AddStatement('<?php echo base_url(''); ?>')"><i class="fa fa-plus"></i></a>
										<b style="float:left;">Edit Statement</b>
									</div>
									<div class="panel-body">
										<div class="table-responsive" >
										<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblQuestionnaireStatement" id="tblQuestionnaireStatement">
											 <form method="post" action="<?php echo base_url('ADMPelatihan/MasterQuestionnaire/EditStatementAdd')?>">
												<thead>
													<tr class="bg-primary">
														<th width="10%">No</th>
														<th width="90%">Kuisioner</th>
														<th width="30%">Action</th>
													</tr>
												</thead>
												<tbody id="tbodyStatement">
														<?php 
															$no=1;
															foreach($statement as $st){
																$St_id=$st['statement_id'];
														?> 
													<tr class="clone" row-id="<?php echo $no; ?>">
														<td ><?php echo $no; ?></td>
														<td>
															
															<input id="statement<?php echo $no; ?>" name="txtStatement[]" class="form-control statement" value="<?php echo $st['statement_description']?>">
															<input type="hidden" name="idStatement[]" value="<?php echo $st['statement_id'] ?>">
														</td>
														<td>
															<a href="javascript:void(0);" class="btn btn-danger btn-xs" id="DelSegment" title="Hapus Baris" onclick="delSpesifikRowSt(<?php echo $no++.','.$st['statement_id']; ?>)"><i class="fa fa-remove"></i>Delete</a>
														</td>
													</tr>
												<?php } ?> 			
											</form>
										</table>
									</div>
								</div> 
								<br>
						</div>
							</div>
								<div class="form-group">
									<div class="col-lg-8 text-right">
										<a href="javascript:window.history.go(-1);" class="btn btn-primary btn btn-flat">Back</a>
										&nbsp;&nbsp;
										<button type="submit" class="btn btn-success btn-flat">Save Data</button>			
									</div>
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
</section>		