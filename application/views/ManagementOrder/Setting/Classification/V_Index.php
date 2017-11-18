<!-- Content Header (Page header) -->
<section class="content-header">
<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b><?= strtoupper($Title) ?></b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('SystemAdministration/User/');?>">
									<i class="icon-wrench icon-2x"></i>
									<span ><br /></span>
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
								<label for="email">New / Edited Classification : </label>
								<input type="hidden" id="txtId" name="txtId" class="form-control" >
								<div id="field_class">
									<input type="text" id="txtClass" class="form-control field-class" name="txtClass" autofocus></input>
								</div>
							  </div>
						</div>
					</div>
					<div class="box-body">
						  <div class="tab-content">
							  <div id="menu" class="tab-pane fade in active">
								  <table class="table table-striped table-bordered table-hover text-left table-class" id="table-class" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th style="text-align:center;width:10%;">No</th>
												<th style="text-align:center;width:80%;">List Tags</th>
												<th style="text-align:center;width:10%;">Act</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if(!empty($data)){
													$no = 0;
													foreach($data as $row){
														$no++;
															echo "
																<tr>
																	<td>".$no."</td>
																	<td>".$row['classification']."</td>
																	<td>
																		<a class='btn btn-xs bg-maroon' onclick='removeClass(\"".site_url()."\",\"".$row['id']."\")'><span class='fa fa-remove'></span></a>
																		<a class='btn btn-xs btn-warning' onclick='editClass(\"".$row['classification']."\",\"".$row['id']."\",\"".site_url()."\")'><span class='fa fa-edit'></span></a>
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


