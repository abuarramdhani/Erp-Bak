<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" action="<?php echo site_url('SystemAdministration/MenuGroup/UpdateMenuGroup/'.$id."/".$grup_list_id)?>" class="form-horizontal">
					<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
					<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
					<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
			<div class="col-lg-12">
				<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
								<h1><b><?= $Title?></b></h1>

								</div>
							</div>
							<div class="col-lg-1 ">
								<div class="text-right hidden-md hidden-sm hidden-xs">
									<a class="btn btn-default btn-lg" href="<?php echo site_url('SystemAdministration/MenuGroup/');?>">
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
							<?php //print_r($MenuGroup);
								foreach($MenuGroup as $MenuGroup_item){
							?>
							<div class="box-body">
								<div class="panel-body">
									<div class="row">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Menu Group Name</label>
												<div class="col-lg-4">
													<input type="text" placeholder="MenuGroupname" name="txtMenuGroupName" value="<?php echo ($grup_list_id=="")?$MenuGroup_item['classification_group']:$MenuGroup_item['prompt']?>" class="form-control" readonly/>
												</div>
										</div>
									</div>
									<div class="row">
										<div class="table-responsive"  style="overflow:hidden;">
											<div class="row">
												<div class="col-lg-12" >

													<div class="panel panel-default">
														<div class="panel-heading text-right">
															<a href="javascript:void(0);" id="addMenu" title="Tambah Baris" onclick="addRowMenu('<?php echo base_url(); ?>')"><img src="<?php echo base_url('assets/img/row_add2.png');?>" title="Add Row" alt="Add Row" ></a>
															&nbsp;&nbsp;&nbsp;
															<a href="javascript:void(0);" id="delMenu" title="Hapus Baris" onclick="deleteRow('tblMenuGroup')"><img src="<?php echo base_url('assets/img/row_delete.png');?>" style="pointer-events:none;cursor: default" title="Delete Row" alt="Delete Row" ></a>
														</div>
														<div class="panel-body">
															<div class="table-responsive" >
																<table class="table table-bordered table-hover text-center"  style="table-layout: fixed;" name="tblMenuGroup" id="tblMenuGroup">
																	<thead>
																		<tr class="bg-primary">
																			<th width="10%">Menu Sequence</th>
																			<th width="30%">Menu Name</th>
																			<th width="15%">Menu Prompt</th>
																			<th width="15%">Sub Menu</th>
																		</tr>
																	</thead>
																	<tbody id="tbodyMenuGroup">
																		<?php 
																			if(count($MenuGroupList) > 0){
																				foreach($MenuGroupList as $MenuGroupList_item){
																				$encrypted_string = $this->encrypt->encode($MenuGroupList_item['classification_group_list_id']);
																				$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
																		?>
																		<tr  class="clone">
																			<td>
																				<input type="number" min="0" placeholder="Menu Sequence" name="txtMenuSequence[]" id="txtMenuSequence" value="<?=$MenuGroupList_item['classification_sequence']?>" class="form-control" required/>
																				<input type="hidden" name="txtMenuLevel[]" id="txtMenuLevel" value="<?php echo ($grup_list_id=="")?"1":intval($MenuGroup_item['classification_level'])+1;?>" class="form-control" required/>
																				<input type="hidden" name="hdnMenuGroupListId[]" id="hdnMenuGroupListId" value="<?=$MenuGroupList_item['classification_group_list_id']?>" class="form-control" required/>
																			</td>
																			<td>
																				<select class="form-control select2-classification" name="slcMenu[]" id="slcMenu" >
																					<option value=""></option>
																					<?php foreach($Class as $Menu_item){
																					?>
																					<option value="<?=$Menu_item['id']?>" <?php echo ($Menu_item['id']==$MenuGroupList_item['classification_id'])?"selected":""?>><?=$Menu_item['classification']?></option>
																					<?php } ?>
																				</select>
																			</td>
																			<td>
																				<input type="text" placeholder="Menu Prompt" name="txtMenuPrompt[]" id="txtMenuPrompt" value="<?=$MenuGroupList_item['prompt']?>" class="form-control" />
																			</td>
																			<td>
																				<a href="<?php echo base_url('ManagementOrder/Setting/UpdateClassificationGroup/')."/".$id."/".$encrypted_string ?>" title="Add SubMenu <?php echo strtoupper($MenuGroupList_item['prompt']) ?>"><span class="fa fa-2x fa-edit"></span></a>
																			</td>
																		</tr>
																		<?php	} 
																			}else{
																				
																		?>
																		<tr  class="clone">
																			<td>
																				<input type="number" min="0" placeholder="Menu Sequence" name="txtMenuSequence[]" id="txtMenuSequence" class="form-control" required/>
																				<input type="hidden" name="txtMenuLevel[]" id="txtMenuLevel" value="<?php echo ($grup_list_id=="")?"1":intval($MenuGroup_item['classification_level'])+1;?>" class="form-control" required/>
																			</td>
																			<td>
																				<select class="form-control select4" name="slcMenu[]" id="slcMenu" >
																					<option value=""></option>
																					<?php foreach($Class as $Menu_item){
																					?>
																					<option value="<?=$Menu_item['menu_id']?>"><?=$Menu_item['menu_name']?></option>
																					<?php } ?>
																				</select>
																			</td>
																			<td>
																				<input type="text" placeholder="Menu Prompt" name="txtMenuPrompt[]" id="txtMenuPrompt" class="form-control" />
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
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</section>