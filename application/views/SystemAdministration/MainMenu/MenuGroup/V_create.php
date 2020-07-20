<section class="content">
	<div class="inner">
		<div class="row">
			<form method="post" action="<?php echo site_url('SystemAdministration/MenuGroup/CreateMenuGroup') ?>" class="form-horizontal">
				<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
				<input type="hidden" value="<?php echo date("Y-m-d H:i:s") ?>" name="hdnDate" />
				<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
									<h1><b><?= $Title ?></b></h1>

								</div>
							</div>
							<div class="col-lg-1 ">
								<div class="text-right hidden-md hidden-sm hidden-xs">
									<a class="btn btn-default btn-lg" href="<?php echo site_url('SystemAdministration/MenuGroup/'); ?>">
										<i class="icon-wrench icon-2x"></i>
										<span><br /></span>
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
										<div class="row">
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Menu Group Name</label>
												<div class="col-lg-4">
													<input type="text" placeholder="MenuGroupname" name="txtMenuGroupName" class="form-control" required />
												</div>
											</div>
										</div>
										<div class="row">
											<div class="table-responsive" style="overflow:hidden;">
												<div class="row">
													<div class="col-lg-12">

														<div class="panel panel-default">
															<div class="panel-heading text-right">
																<a href="javascript:void(0);" id="addMenu" title="Tambah Baris" onclick="addRowMenu('<?php echo base_url(); ?>')"><img src="<?php echo base_url('assets/img/row_add2.png'); ?>" title="Add Row" alt="Add Row"></a>
																&nbsp;&nbsp;&nbsp;
																<a href="javascript:void(0);" id="delMenu" title="Hapus Baris" onclick="deleteRow('tblMenuGroup')"><img src="<?php echo base_url('assets/img/row_delete.png'); ?>" style="pointer-events:none;cursor: default" title="Delete Row" alt="Delete Row"></a>
															</div>
															<div class="panel-body">
																<div class="table-responsive">
																	<table class="table table-bordered table-hover text-center" style="table-layout: fixed;" name="tblMenuGroup" id="tblMenuGroup">
																		<thead>
																			<tr class="bg-primary">
																				<th width="5%">Sort</th>
																				<th width="5%">Menu Sequence</th>
																				<th width="30%">Menu Name</th>
																				<th width="15%">Menu Prompt</th>
																			</tr>
																		</thead>
																		<tbody id="tbodyMenuGroup">
																			<tr class="clone">
																				<td class="text-center handle">
																					<i class="fa fa-sort"></i>
																				</td>
																				<td>
																					<input readonly type="number" min="0" value="1" placeholder="Menu Sequence" name="txtMenuSequence[]" id="txtMenuSequence" class="form-control" required />
																				</td>
																				<td>
																					<select class="form-control select4" name="slcMenu[]" id="slcMenu">
																						<option value=""></option>
																						<?php foreach ($Menu as $Menu_item) {
																						?>
																							<option value="<?= $Menu_item['menu_id'] ?>"><?= $Menu_item['menu_name'] ?></option>
																						<?php } ?>
																					</select>
																				</td>
																				<td>
																					<input type="text" placeholder="Menu Prompt" name="txtMenuPrompt[]" id="txtMenuPrompt" class="form-control" />
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</div>
																<small class="text-danger">*Drag untuk memindahkan</small>
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
<script>
	const sortSequence = () => {
		let row = $('#tblMenuGroup > tbody > tr')
		let no = 1

		row.each(function() {
			$(this).find('#txtMenuSequence').val(no++)
		})
	}

	$(() => {
		$('tbody').sortable({
			handle: '.handle',
			placeholder: "ui-state-highlight",
			update: sortSequence
		})
	})
</script>