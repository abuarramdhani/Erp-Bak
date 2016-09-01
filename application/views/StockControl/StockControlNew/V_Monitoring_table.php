						<table class="table table-hover table-striped table-bordered" id="production_monitoring" style="font-size:12px;">
							<thead class="bg-primary">
								<tr>
									<td rowspan="2" style="text-align: center; vertical-align : middle">
										<div style="width: 20px;">
											<b>NO</b>
										</div>
									</td>
									<td rowspan="2" style="text-align: center; vertical-align : middle">
										<div style="width: 200px;">
											<b>AREA</b>
										</div>
									</td>
									<td colspan="2" style="text-align: center; vertical-align : middle">
										
											<b>SUBASSY</b>
										
									</td>
									<td colspan="2" style="text-align: center; vertical-align : middle">
										
											<b>COMPONENT</b>
										
									</td>
									<td width="50px" rowspan="2" style="text-align: center; vertical-align : middle">
										<div style="width: 50px;">
											<b>QTY NEEDED</b>
										</div>
									</td>
									<td width="75px" rowspan="2" style="text-align: center; vertical-align : middle">
										<div style="width: 75px;">
											<b style="font-size: 9px">QTY SIMULATION</b>
											<input type="text" onkeypress="return isNumberKeyAndComma(event)" name="qty_simulation" id="qty_simulation" class="form-control" style="width: 95%; height: 30px; text-align: center;">
										</div>
									</td>
									<?php
										foreach ($stock_on_date as $sod) {
											$head_name = date('d/m/Y', strtotime($sod['plan_date']));
									?>
									<td width="5%" style="text-align: center; vertical-align : middle">
										<div style="width: 55px;margin: 0 auto">
											<b><?php echo $head_name ?></b>
										</div>
									</td>
									<?php
										}
									?>
								</tr>
								<tr>
									<td style="text-align: center; vertical-align : middle">
										<div style="width: 150px;margin: 0 auto">
											<b>Code</b>
										</div>
									</td>
									<td style="text-align: center; vertical-align : middle">
										<div style="width: 150px;margin: 0 auto">
											<b>Name</b>
										</div>
									</td>
									<td style="text-align: center; vertical-align : middle">
										<div style="width: 150px;margin: 0 auto">
											<b>Code</b>
										</div>
									</td>
									<td style="text-align: center; vertical-align : middle">
										<div style="width: 150px;margin: 0 auto">
											<b>Name</b>
										</div>
									</td>
									<?php
										foreach ($stock_on_date as $sod) {
									?>
									<td style="text-align: center; vertical-align : middle"><div style="width: 55px;margin: 0 auto"><b><?php echo $sod['qty_plan']; ?> Unit</b></div></td>
									<?php
										}
									?>
								</tr>
							</thead>
							<tbody>
								<?php
								if(!(empty($production_list))){
									$no=0;
									foreach($production_list as $pl) { $no++;
								?>
								<tr class="multiple-row">
									<td align="center"><div style="width: 20px"><?php echo $no?></div></td>
									<td align="left"><div style="width: 200px;"><?php echo $pl['area']?></div></td>
									<td align="left"><div style="width: 150px;margin: 0 auto"><b><?php echo $pl['subassy_code']?></b></div></td>
									<td align="left"><div style="width: 150px;margin: 0 auto"><b><?php echo $pl['subassy_desc']?></b></div></td>
									<td align="left"><div style="width: 150px;margin: 0 auto"><b><?php echo $pl['component_code']?></b></div></td>
									<td align="left"><div style="width: 150px;margin: 0 auto"><b><?php echo $pl['component_desc']?></b></div></td>
									<td align="center"><div style="width: 50px;margin: 0 auto"><b><span class="qty-needed"><?php echo $pl['qty_component_needed']?></span></b></div></td>
									<td align="center"><b><div style="width: 75px;margin: 0 auto" class="qty-total"></div></b></td>
									<?php 
										foreach ($stock_on_date as $sod) {
											if (empty(${'data_'.$pl['master_data_id'].'_'.$sod['plan_id']})) {
												$qty = '';
												$status = '';
											}

											foreach (${'data_'.$pl['master_data_id'].'_'.$sod['plan_id']} as $td) {
												$qty = $td['qty'];
												$status = $td['status'];
											}
											if ($status == 'LENGKAP') {
												$style = "border-color: #008d4c ; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px #008d4c;";
											}
											elseif ($status == 'KURANG') {
												$style = "border-color: #d33724 ; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px #d33724;";
											}
											elseif ($status == 'DILENGKAPI') {
												$style = "border-color: #357ca5 ; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px #357ca5;";
											}
											elseif ($status == 'ON PPIC') {
												$style = "border-color: #db8b0b ; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px #db8b0b;";
											}
											elseif ($status == 'DILENGKAPI PPIC') {
												$style = "border-color: #D81B60 ; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px #D81B60;";
											}
											elseif ($status == 'GUDANG READY') {
												$style = "border-color: #39CCCC ; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px #39CCCC;";
											}
											else{
												$style = '';
											}

									?>
									<td align="center">
										<div style="width: 55px;margin: 0 auto">
											<input data-toggle="tooltip" data-placement="top" title="Press Enter to Submit!" class="form-control" style="width: 100%; <?php echo $style ?>" type="text" value="<?php echo $qty; ?>" name="txt_qty_so" onchange="SaveSO('<?php echo $pl['master_data_id']."','".$sod['plan_id'] ?>',this)" />
										</div>
									</td>
									<?php
										}
									?>
								</tr>
								<?php 
									}
								}
								?>
							</tbody>																				
						</table>

						<script type="text/javascript">
							$('#qty_simulation').keyup(simulasi_qty);

							function simulasi_qty() {
								$("#production_monitoring tr").each(function () {
									var $qty = $(this).find('.qty-needed').text();
									var $qty_simulation = $('#qty_simulation').val();
									$qty_simulation = $qty_simulation.replace(/,/g, '.');
									var $total = ($qty * 1) * ($qty_simulation * 1);
									$(this).find('.qty-total').text($total);
								});
							}
							$(document).ready(function () {
								$("input").not($(":button")).keypress(function (evt) {
									if (evt.keyCode == 13) {
										iname = $(this).val();
										if (iname !== 'Submit') {
											var fields = $(this).parents('form:eq(0),body').find('button, input, textarea, select');
											var index = fields.index(this);
											if (index > -1 && (index + 1) < fields.length) {
												fields.eq(index + 1).focus();
											}
											return false;
										}
									}
								});
							});
						</script>