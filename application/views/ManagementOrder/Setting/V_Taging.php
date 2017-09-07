<!-- Content Header (Page header) -->
<section class="content-header">
<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>SETTING TAG</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ManagementOrder');?>">
                                <i class="fa fa-tag fa-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
 </section>
<section class="content">
	        <div class="row">
            <div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header">
						<div class="form-inline">
						  <div class="form-group">
							<label for="email">New / Edited Tag : </label>
							<input type="hidden" id="txtId" name="txtId" class="form-control" >
							<div id="field_tag">
								<input type="text" id="txtTags" class="form-control field-tag" name="txtTags" autofocus></input>
							</div>
						  </div>
						</div>
					</div>
					<div class="box-body">
						  <div class="tab-content">
							  <div id="menu" class="tab-pane fade in active">
								  <table class="table table-striped table-bordered table-hover" id="table-taging" style="font-size:13px;width:100%;">
										<thead>
											<tr class="bg-primary">
												<th style="text-align:center;width:10%;">No</th>
												<th style="text-align:center;width:80%;">List Tags</th>
												<th style="text-align:center;width:10%;">Act</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if(!empty($taging)){
													$no = 0;
													foreach($taging as $row){
														$no++;
															echo "
																<tr>
																	<td>".$no."</td>
																	<td>".$row['tags']."</td>
																	<td>
																		<a class='btn btn-xs bg-maroon' onclick='removeTag(\"".site_url()."\",\"".$row['id']."\")'><span class='fa fa-remove'></span></a>
																		<a class='btn btn-xs btn-warning' onclick='editTag(\"".$row['tags']."\",\"".$row['id']."\",\"".site_url()."\")'><span class='fa fa-edit'></span></a>
																	</td>
																</tr>
															";
													}
												}
											?>
										</tbody>
									</table>
								</div>
						  </div>
					</div>
				</div>
            </div>
        </div>
</section>
<!-- Modal -->


