<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b> <?= strtoupper($Title)?></b></h1>
						
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
								<a href="<?php echo site_url('ManagementOrder/Setting/CreateClassificationGroup/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
									<button type="button" class="btn btn-default btn-sm">
									  <i class="icon-plus icon-2x"></i>
									</button>
								</a>
							</div>
							<div class="box-body">
									<table class="table table-striped table-bordered table-hover text-left table-class-group" id="table-class-group" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="20%"><center>Classification Project</center></th>
												<th width="20%"><center>Total Sub_Class</center></th>
												<th width="10%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody>
											<?php 
												if(!empty($ClassificationGroup)){
													$no = 0;
														foreach($ClassificationGroup as $ClassificationGroup_item){
															$encrypted_string = $this->encrypt->encode($ClassificationGroup_item['classification_group_id']);
															$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
															$no++;
																echo "
																	<tr>
																		<td style='text-align:center;'>".$no."</td>
																		<td style='text-align:center;'>".$ClassificationGroup_item['classification_group']."</td>
																		<td style='text-align:center;'>".$ClassificationGroup_item['total_class']."</td>
																		<td style='text-align:center;'><a href='".site_url('ManagementOrder/Setting/UpdateClassificationGroup/'.$encrypted_string.'')."' title='Update ".$ClassificationGroup_item['classification_group']."'><span class='fa fa-2x fa-edit'></span></a></td>
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
	</div>
</section>