<section class="content">
	<div class="inner" >
	<div class="row">
		<?php 
		foreach ($Checklist as $Checklist_item): 
				//$tgl2 = $Checklist_item['end_date'];
				//echo $tgl2;
				//if($tgl2 != '')
				//{	$tgl2 = date_format(date_create($Checklist_item['start_date']), 'd-M-Y'); 	}
?>
		<form method="post" action="<?php echo site_url('/CustomerRelationship/Setting/Checklist/PostUpdateToDb/')?>" class="form-horizontal">
				<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
				<input type="hidden" value="<?php echo $Checklist_item['id_checklist'] ?>" name="txtChecklistId" />
				<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
				<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Update Checklist</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CustomerRelationship/Setting/Checklist');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span ><br /></span>
                            </a>
							

                            
						</div>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
							Header
						</div>
					<div class="box-body">
						<div class="panel-body">
								<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Sequence</label>
										<div class="col-lg-8">
											<input type="text" placeholder="Sequence" name="txtNumber" value="<?php echo $Checklist_item['no_urut_checklist'] ?>" class="form-control toupper" />
										</div>
								</div>
								<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Description</label>
										<div class="col-lg-8">
											<textarea type="text" placeholder="Description" name="txtDescription" class="form-control toupper" /><?php echo $Checklist_item['checklist_description'] ?></textarea>
										</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-4" for="dp1">End Date</label>

									<div class="col-lg-4">
										<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtEndDate" value="<?php echo $Checklist_item['end_date'] ?>" class="form-control" data-date-format="dd-M-yyyy" id="dp3" />
									</div>
								</div>
						</div>
						<div class="panel-footer">
							<div class="row text-right">
								<a href="<?php echo site_url('CustomerRelationship/Setting/Checklist');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
								&nbsp;&nbsp;
								<button class="btn btn-primary btn-lg btn-rect">Save Changes</button>
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
		</form>
		<?php endforeach ?>
	</div>
	</div>
</section>