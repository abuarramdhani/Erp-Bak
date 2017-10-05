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
						<b>Form Pembuatan Statement Kuesioner</b>
					</div>
					
					<div class="box-body">
					<form method="post" action="<?php echo base_url('ADMPelatihan/MasterQuestionnaire/AddStatement')?>">
						
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
						
						<?php 
								$no=1;foreach($segment as $sg){
									$placeholder='Pernyataan';
									$inputName='txtStatement'.$sg['segment_id'];
									if($sg['segment_type']==0){
										$placeholder='Pertanyaan Essay';
									}
						?>
						<div class="row" style="margin: 10px 10px">
							<div class="col-md-8">
								<div class="panel panel-default">
									<div class="panel-heading text-right">
										<a href="javascript:void(0);" class="btn btn-sm btn-primary" title="Tambah Baris" onclick="AddStatementC(<?php echo $sg['segment_id'].",'".$inputName."'"; ?>)"><i class="fa fa-plus"></i></a>
										<a href="javascript:void(0);" class="btn btn-sm btn-danger" title="Hapus Baris" onclick="delStatRow('<?php echo $sg['segment_id']; ?>')"><i class="fa fa-remove"></i></a>
									</div>
									<div class="panel-body">
										<div class="table-responsive" >
											<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" id="tblStatement<?php echo $no; ?>">
												<thead>
													<tr class="bg-primary">
														<th width="10%">No</th>
														<th width="90%"><?php echo 'Bagian '.' - '.$sg['segment_description']?></th>
														<!-- <th width="90%"><?php echo 'Bagian '.$no.' - '.$sg['segment_description']?></th> -->
													</tr>
												</thead>
												<tbody id="tbodyStatementC<?php echo $sg['segment_id']; ?>">
													<tr class="clone" >
														<td ><?php echo $no; ?></td>
														<td>
															<input id="idstatement<?php echo $no; ?>" name="txtSegmentId[]" value="<?php echo $sg['segment_id']?>" hidden>
															<input id="statement<?php echo $no; ?>" name="<?php echo $inputName.'[]'; ?>" class="form-control statement" placeholder="<?php echo $placeholder?>">
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
							<div class="col-lg-8 text-right">
							<!-- <a href="javascript:window.history.go(-1);" class="btn btn-primary btn btn-flat">Back</a> -->
									&nbsp;&nbsp;
								<button type="submit" class="btn btn-success btn-flat">Save Data</button>
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
			
				
