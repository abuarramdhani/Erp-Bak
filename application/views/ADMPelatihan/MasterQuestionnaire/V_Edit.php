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
						<b>Master Kuesioner</b>
					</div>
					<div class="box-body">
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
						<br>
						<?php foreach($segment as $sg){?>
						<div class="row" style="margin: 10px 10px">
							<div class="table-responsive col-lg-8" >
								<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;">
									<thead>
										<tr class="bg-primary">
											<th width="10%">No</th>
											<th width="90%"><?php echo $sg['segment_description'] ?></th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$no=0;
											foreach($statement as $st){
												if($sg['segment_id']==$st['segment_id']){ $no++
										?>
										<tr>
											<td><?php echo $no?></td>
											<td style="text-align:left;"><?php echo $st['statement_description']?></td>
										</tr>
										<?php }} ?>
									</tbody>
								</table>
							</div>
						</div>
						<br>
						<?php }?>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
