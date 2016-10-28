						<table class="table table-hover table-striped table-bordered" id="stock-opname-pusat" style="font-size:12px;">
							<thead class="bg-primary">
								<tr>
									<td style="text-align: center; vertical-align : middle" width="5%">
										
											<b>NO</b>
										
									</td>
									<td style="text-align: center; vertical-align : middle;" width="10%">
										
											<b>SUB INVENTORY</b>
										
									</td>
									<td style="text-align: center; vertical-align : middle;" width="10%">
										
											<b>AREA</b>
										
									</td>
									<td style="text-align: center; vertical-align : middle;" width="10%">
										
											<b>LOCATOR</b>
										
									</td>
									<td style="text-align: center; vertical-align : middle;" width="10%">
										
											<b>SAVE LOCATION</b>
										
									</td>
									<td style="text-align: center; vertical-align : middle;" width="10%">
										
											<b>ITEM</b>
										
									</td>
									<td style="text-align: center; vertical-align : middle;" width="15%">
										
											<b>DESKRIPSI</b>
										
									</td>
									<td style="text-align: center; vertical-align : middle;" width="10%">
										
											<b>ON HAND QTY</b>
										
									</td>
									<td style="text-align: center; vertical-align : middle;" width="10%">
										
											<b>UOM</b>
										
									</td>
									<td style="text-align: center; vertical-align : middle;" width="10%">
										
											<b>SO QTY</b>
										
									</td>
								</tr>
							</thead>
							<tbody>
								<?php
								if(!(empty($stock_opname_pusat))){
									$no=0;
									foreach($stock_opname_pusat as $data) { $no++;
								?>
								<tr class="multiple-row">
									<td align="center"><?php echo $no?></td>
									<td align="left"><?php echo $data['sub_inventory']?></td>
									<td align="left"><?php echo $data['area']?></td>
									<td align="left"><?php echo $data['locator']?></td>
									<td align="left"><?php echo $data['saving_place']?></td>
									<td align="left"><a data-toggle="modal" data-target="#update-component" href="#" onclick="update_component(<?php echo $data['master_data_id'];?>)"><?php echo $data['component_code']?></a></td>
									<td align="left"><?php echo $data['component_desc']?></td>
									<td align="left"><?php echo $data['onhand_qty']?></td>
									<td align="left"><?php echo $data['uom']?></td>
									<td align="left"><input data-toggle="tooltip" data-placement="top" title="Press Enter to Submit!" class="form-control" style="width: 100%;" type="text" name="txt_qty_so" onchange="SaveSO_Pusat('<?php echo $data['master_data_id']?>',this)" value="<?php echo $data['so_qty'];?>"></td>
								</tr>
								<?php 
									}
								}

								?>
							</tbody>																				
						</table>

						<div class="modal fade" id="update-component">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<form method="post" action="<?php echo base_url('StockControl/stock-opname-pusat/update_component') ?>">
										<div class="modal-header bg-primary">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title">Update Component</h4>
										</div>
										<div class="modal-body" id="update-form">
											<div id="update-form">
												
											</div>
											<div id="loading" style="width: 10%;margin: 0 auto">
												
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
											<button type="submit" class="btn btn-primary">Update</button>
										</div>
									</form>
								</div>
							</div>
						</div>

						<script type="text/javascript">
							$(document).ready(function () {
								$("input").not($(":button")).keypress(function (evt) {
									if (evt.keyCode == 13) {
										iname = $(this).val();
										if (iname !== 'Submit') {
											var fields = $(this).parents('form:eq(0),body').find('button, input, textarea, select');
											var index = fields.index(this);
											if (index > -1 && (index + 1) < fields.length) {
												fields.eq(index + 1).focus();
												fields.eq(index + 1).select();
											}
											return false;
										}
									}
								});
							});

						</script>