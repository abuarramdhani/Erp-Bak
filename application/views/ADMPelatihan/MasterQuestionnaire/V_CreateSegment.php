<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
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
						<b>Form Pembuatan Segment Kuesioner</b>
					</div>
					
					<div class="box-body">
					<form method="post" action="<?php echo base_url('ADMPelatihan/MasterQuestionnaire/AddSegment')?>">
						
						<!-- INPUT GROUP 1 ROW 2 -->
						<?php foreach($questionnaire as $qs) {?>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Judul Kuesioner</label>
								<div class="col-lg-6">
									<input class="form-control" value="<?php echo $qs['questionnaire_title'] ?>" readonly>
									<input name="txtQuestionnaireId" value="<?php echo $qs['questionnaire_id'] ?>" hidden>
								</div>
							</div>
						</div>
						<?php }?>
						<hr>
						<div class="row" style="margin: 10px 10px">
							<div class="col-md-8">
								<div class="panel panel-default">
									<div class="panel-heading text-right">
										<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddSegment" title="Tambah Baris" onclick="AddSegmentCreate('<?php echo base_url(''); ?>')"><i class="fa fa-plus"></i></a>
										<b style="float:left;">Bagian Pilihan</b>
									</div>
									<div class="panel-body">
										<div class="table-responsive" >
											<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblQuestionnaireSegment" id="tblQuestionnaireSegment">
												<thead>
													<tr class="bg-primary">
														<th width="10%">No</th>
														<th width="90%">Nama Bagian</th>
														<th width="20%">Action</th>
													</tr>
												</thead>
												<tbody id="tbodyQuestionnaireSegmentC">
													<?php 
														$no=1;
														foreach($segment as $sg){
														$Sg_id=$sg['segment_id'];
													?>
													<tr class="clone" row-id="<?php echo $no; ?>">
														<td><?php echo $no; ?></td>
														<td>
															<input id="segment" name="txtSegment[]" class="form-control segment" placeholder="Nama Bagian">
															<input type="hidden" name="idSegment[]" value="<?php echo $no ?>">
														</td>
														<td>
															<button type="button" class="btn btn-danger" onclick="deleteRowAjax(<?php echo $no++.','.$pt['participant_id'].','.$rc['scheduling_id']?>)"><i class="fa fa-remove"></i></button>
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
						<hr>
						<div class="row" style="margin: 10px 10px">
							<div class="col-md-8">
								<div class="panel panel-default">
									<div class="panel-heading text-right">
										<a href="javascript:void(0);" class="btn btn-sm btn-primary" title="Tambah Baris" onclick="AddSegmentEssayC()"><i class="fa fa-plus"></i></a>
										<b style="float:left;">Bagian Essay</b>
									</div>
									<div class="panel-body">
										<div class="table-responsive" >
											<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblQuestionnaireSegmentEssay" id="tblQuestionnaireSegmentEssay">
												<thead>
													<tr class="bg-primary">
														<th width="10%">No</th>
														<th width="90%">Nama Bagian</th>
														<th width="20%">Action</th>
													</tr>
												</thead>
												<tbody id="tbodyQuestionnaireSegmentEssay">
													<?php 
														$no=1;
														foreach($segment as $sg){
														$Sg_id=$sg['segment_id'];
													?>
													<tr class="clone" row-id="<?php echo $no; ?>">
														<td><?php echo $no; ?></td>
														<td>
															<input id="segmentessay" name="txtSegmentEssay[]" class="form-control segmentessay" placeholder="Nama Bagian">
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

						<hr>
						<div class="form-group">
							<div class="col-lg-8 text-right">
							<!-- <a href="javascript:window.history.go(-1);" class="btn btn-primary btn btn-flat">Back</a> -->
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
</section>			
			
				
