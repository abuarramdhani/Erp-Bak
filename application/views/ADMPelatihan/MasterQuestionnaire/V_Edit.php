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
						<form method="post" action="<?php echo site_url('ADMPelatihan/MasterQuestionnaire/editSave/'.$id);?>" onkeypress="return event.keyCode != 13;">					
						<?php foreach($questionnaire as $qs) {?>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Judul Kuesioner</label>
								<div class="col-lg-6">
									<input name="txtQuestionnaireName" class="form-control" value="<?php echo $qs['questionnaire_title'] ?>" >
									<input name="txtQuestionnaireId" value="<?php $Qs_id=$qs['questionnaire_id'];echo $qs['questionnaire_id'] ?>" hidden>
								</div>
							</div>
						</div>
						<?php }?>
						<?php foreach($segment as $sg){?>
						<?php }?>
						<hr>
							<div class="row" style="margin: 10px 10px">
							<div class="col-md-8">
								<div class="panel panel-default">
									<div class="panel-heading text-right">
										<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddSegment" title="Tambah Baris" onclick="AddSegment('edit')"><i class="fa fa-plus"></i></a>
										<b style="float:left;">Edit Segment</b>
									</div>
									<div class="panel-body">
										<div class="table-responsive" >
										<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblQuestionnaireSegment" id="tblQuestionnaireSegment">
											 <form method="post" action="<?php echo base_url('ADMPelatihan/MasterQuestionnaire/Add')?>">
												<thead>
													<tr class="bg-primary">
														<th width="10%">No</th>
														<th width="90%">Kuisioner</th>
														<th width="30%">Action</th>
													</tr>
												</thead>
												<tbody id="tbodyQuestionnaireSegment">
														<?php 
															$no=1;
															foreach($segment as $sg){
															$Sg_id=$sg['segment_id'];
														?>
													<tr class="clone" row-id="<?php echo $no; ?>">
														<td ><?php echo $no; ?></td>
														<td>
															<input id="segment" name="txtSegment[]" class="form-control segment" value="<?php echo $sg['segment_description']?>" onkeyup="insertKuesAjax(event, this)" data-id="<?php echo $sg['segment_id'] ?>" data-toggle="tooltip" data-placement="top" title="Tekan Enter untuk Menyimpan!">
															<input type="hidden" name="idSegment[]" value="<?php echo $sg['segment_id'] ?>">
														</td>
														<td>
															<a href="javascript:void(0);" class="btn btn-danger btn-xs" id="DelSegment" title="Hapus Baris" onclick="delSpesifikRow121(<?php echo $no++.','.$sg['segment_id']; ?>)"><i class="fa fa-remove"></i>Delete</a>
															<a href="<?php echo base_url('ADMPelatihan/MasterQuestionnaire/EditStatement')."/".$Qs_id."/".$Sg_id;?>" data-toggle="modal" data-target="<?php echo base_url('')?>" class="btn btn-xs btn-warning"><i class="fa fa-search"></i></i> Statement</a>
														</td>
													</tr>
													<?php } ?>
												</tbody>
											</form>
										</table>
									</div>
								</div> 
							<br>
						</div>
							</div>
								<div class="form-group">
									<div class="col-lg-8 text-right">
										<a href="<?php echo site_url('ADMPelatihan/MasterQuestionnaire/index');?>" class="btn btn-primary btn btn-flat" class="btn btn-primary btn btn-flat">Back</a>
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