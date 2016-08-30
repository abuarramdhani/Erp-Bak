<div class="row">
	<div class="col-md-12">
		<h3 style="margin: 0 auto">Monitoring Kekurangan Komponen</h3>
	</div>
</div>
						<table class="table table-hover table-striped table-bordered" style="font-size:12px;">
							<thead class="bg-primary">
								<tr>
									<td rowspan="2" style="width: 35px;text-align: center; vertical-align : middle;background-color: #337ab7;">
										<div style="width: 20px;text-align: center">
											<b>NO</b>
										</div>
									</td>
									<td rowspan="2" style="width: 200px;text-align: center; vertical-align : middle;background-color: #337ab7;">
										<div style="width: 200px;text-align: center">
											<b>KODE</b>
										</div>
									</td>
									<td rowspan="2" style="width: 300px;text-align: center; vertical-align : middle;background-color: #337ab7;">
										<div style="width: 300px;text-align: center">
											<b>KOMPONEN</b>
										</div>
									</td>
									<td rowspan="2" style="width: 50px;text-align: center; vertical-align : middle;background-color: #337ab7;">
										<div style="width: 50px;text-align: center;margin: 0 auto">
											<b>PER UNIT</b>
										</div>
									</td>
									
								<?php
									foreach ($periode as $per) {
								?>
									<td colspan="4" width="5%" style="text-align: center; vertical-align : middle;background-color: #337ab7;">
										<div>
											<b><?php echo date('Y-m-d', strtotime($per['plan_date'])) ?></b>
										</div>
									</td>
								<?php
									}
								?>
								</tr>
								<tr>
								<?php
									foreach ($periode as $per) {
								?>
									<td style="text-align: center; vertical-align : middle;background-color: #337ab7;">
										<div style="width: 60px;margin: 0 auto">
											<b>QTY NEEDED</b>
										</div>
									</td>
									<td style="text-align: center; vertical-align : middle;background-color: #337ab7;">
										<div style="width: 60px;margin: 0 auto">
											<b>QTY ACTUAL</b>
										</div>
									</td>
									<td style="text-align: center; vertical-align : middle; background-color: #e9897e">
										<div style="width: 60px;margin: 0 auto">
											<b>QTY KURANG</b>
										</div>
									</td>
									<td style="text-align: center; vertical-align : middle;background-color: #337ab7;"><div style="width: 60px;margin: 0 auto"><b>STATUS</b></div></td>
								<?php
									}
								?>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach ($area_list as $ar) {
								?>
								<tr>
									<td colspan="4" align="center">
										<b>AREA <?php echo $ar['area']; ?></b>
									</td>
									<?php
										foreach ($periode as $per) {
									?>
									<td></td>
									<td></td>
									<td style="background-color: #FFD1CB"></td>
									<td></td>
									<?php
										}
									?>
								</tr>
								<?php
										foreach ($subassy_list as $sub) {
											if ($sub['area'] == $ar['area']) {
												if ($sub['subassy_desc'] != '') {
								?>
								<tr>
									<td colspan="4">
										<b><?php 
											$no = 1;
											echo $sub['subassy_desc'];
											if ($sub['subassy_desc'] == '') {
												echo '&nbsp;';
											}
										?></b>
									</td>
									<?php
										foreach ($periode as $per) {
									?>
									<td></td>
									<td></td>
									<td style="background-color: #FFD1CB"></td>
									<td></td>
									<?php
											}
										}
									?>
								</tr>
								<?php
												foreach ($component_list as $comp) {
													if ($comp['subassy_desc'] == $sub['subassy_desc']) {
								?>
								<tr>
									<td><?php echo $no; ?></td>
									<td><?php echo $comp['component_code']; ?></td>
									<td><?php echo $comp['component_desc']; ?></td>
									<td><?php echo $comp['qty_component_needed']; ?></td>
								<?php
														foreach ($periode as $per) {
															//if ($per['plan_date'] == $comp['plan_date']) {
																${'data_'.$comp['master_data_id'].'_'.$per['plan_id']} = $this->M_stock_control_new->transaction_export($comp['master_data_id'],$per['plan_id']);
																if (empty(${'data_'.$comp['master_data_id'].'_'.$per['plan_id']})) {
																	$qty_needed = '-';
																	$qty_actual = '-';
																	$qty_kurang = '-';
																	$status = '-';
																}
																foreach (${'data_'.$comp['master_data_id'].'_'.$per['plan_id']} as $tr_status) {
																	$qty_needed = $tr_status['qty_plan']*$tr_status['qty_component_needed'];
																	$qty_actual = $tr_status['qty'];
																	$qty_kurang = ($tr_status['qty_plan']*$tr_status['qty_component_needed'])-$tr_status['qty'];
																	$status = $tr_status['status'];
																}
								?>
									<td><?php echo $qty_needed?></td>
									<td><?php echo $qty_actual?></td>
									<td style="background-color: #FFD1CB"><?php echo $qty_kurang?></td>
									<td><?php echo $status?></td>
								<?php
															}
														$no++;
								?>
								</tr>
								
								<?php
													}
												}
											}
										}
								?>
									<tr>
										<td colspan="4">&nbsp;</td>
										<?php
											foreach ($periode as $per) {
										?>
										<td></td>
										<td></td>
										<td style="background-color: #FFD1CB"></td>
										<td></td>
										<?php
											}
										?>
									</tr>
								<?php
									}
								?>
							</tbody>
						</table>