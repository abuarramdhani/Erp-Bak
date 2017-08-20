<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" action="<?= $action ?>" class="form-horizontal">
					<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
					<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
					<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
			<div class="col-lg-12">
				<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
								<h1><b><?= strtoupper($Title)?></b></h1>

								</div>
							</div>
							<div class="col-lg-1 ">
								<div class="text-right hidden-md hidden-sm hidden-xs">
									<a class="btn btn-default btn-lg" href="<?php echo site_url('ManagementOrder/Setting/ClassificationGroup');?>">
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
								<b>Header</b>
							</div>
						<div class="box-body">
							<div class="panel-body">
								<div class="row">
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">List Project Order</label>
											<div class="col-lg-4">
												<select class="form-crontrol select-project" name="txtProject" style="width:100%;">
													<option value=""></option>
												</select>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Classification Project</label>
											<div class="col-lg-4">
												<select class="form-crontrol select-classification" name="txtClassification" id="txtClassification" onChange="changeClassificationProject('<?php echo site_url(); ?>')" style="width:100%;">
													<option value=""></option>
													<?php
														foreach($ClassificationProject as $ClassificationProject_item){
															echo "<option value='".$ClassificationProject_item['classification_group_id']."'>".$ClassificationProject_item['classification_group']."</option>";
														}
													?>
												</select>
											</div>
									</div>
								</div>
								<div class="row">
									<div class="table-responsive"  style="overflow:hidden;">
										<div class="row">
											<div class="col-lg-12" >

												<div class="panel panel-default">
													<div class="panel-body">
														<div class="table-responsive" >
															<table class="table table-bordered table-hover"  id="table_add_classification">
																<thead>
																	<tr class="bg-primary">
																		<th width="5%">No</th>
																		<th width="30%">Schedule</th>
																		<th width="15%">Plan</th>
																		<th width="15%">Action</th>
																	</tr>
																</thead>
																<tbody>
																</tbody>
															</table>
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
											
								</div>
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
									&nbsp;&nbsp;
									<button id="btnMenuGroup" class="btn btn-primary btn-lg btn-rect">Save Data</button>
								</div>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</section>