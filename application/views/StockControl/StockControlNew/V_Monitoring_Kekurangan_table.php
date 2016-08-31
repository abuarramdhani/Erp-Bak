
						<table width="100%" class="table table-hover table-striped table-bordered" id="monitoring-kekurangan" style="font-size:12px;">
							<thead class="bg-primary">
								<tr>
									<td rowspan="2" style="width: 20px;text-align: center; vertical-align : middle">
										<div style="width: 20px;text-align: center;margin: 0 auto">
											<b>NO</b>
										</div>
									</td>
									<!--
									<td rowspan="2" style="width: 95px;text-align: center; vertical-align : middle">
										<div style="width: 95px;text-align: center;margin: 0 auto">
											<b>AREA</b>
										</div>
									</td>
									<td rowspan="2" style="width: 95px;text-align: center; vertical-align : middle">
										<div style="width: 95px;text-align: center;margin: 0 auto">
											<b>SUBASSY</b>
										</div>
									</td>
									-->
									<td rowspan="2" style="width: 95px;text-align: center; vertical-align : middle">
										<div style="width: 95px;text-align: center;margin: 0 auto">
											<b>KODE</b>
										</div>
									</td>
									<td rowspan="2" style="width: 100px;text-align: center; vertical-align : middle">
										<div style="width: 100px;text-align: center;margin: 0 auto">
											<b>KOMPONEN</b>
										</div>
									</td>
									<td rowspan="2" style="width: 30px;text-align: center; vertical-align : middle">
										<div style="width: 30px;text-align: center;margin: 0 auto">
											<b>PER UNIT</b>
										</div>
									</td>
									
								<?php
								if(!(empty($periode))){
									foreach ($periode as $per) {
								?>
									<td colspan="4" style="text-align: center; vertical-align : middle">
										<div>
											<b><?php echo date('Y-m-d', strtotime($per['plan_date'])) ?></b>
										</div>
									</td>
								<?php
									}
								}
								?>
								</tr>
								<tr>
								<?php
									$col = 1;
									if(!(empty($periode))){
									foreach ($periode as $per) {
										$col++;
								?>
									<td style="text-align: center; vertical-align : middle;font-size: 10px">
										
											<b>QTY NEEDED</b>
										
									</td>
									<td style="text-align: center; vertical-align : middle;font-size: 10px">
									
											<b>QTY ACTUAL</b>
									
									</td>
									<td style="text-align: center; vertical-align : middle;background-color: #e9897e;font-size: 10px">
										
											<b>QTY KURANG</b>
										
									</td>
									<td style="text-align: center; vertical-align : middle;font-size: 10px">
										
											<b>STATUS</b>
										
									</td>
								<?php
									}
								}
								?>
								</tr>
							</thead>
							<!-- Versi Datatable -->
							<!--
							<tbody>
								<?php
									$no=1;
									if(!(empty($component_list))){
									foreach ($component_list as $comp) {
								?>
								<tr>
									<td align="center"><?php echo $no; ?></td>
									<td><b><?php echo $comp['area']; ?></b></td>
									<td><b><?php echo $comp['subassy_desc']; ?></b></td>
									<td><?php echo $comp['component_code']; ?></td>
									<td><?php echo $comp['component_desc']; ?></td>
									<td align="center" style="width: 30px;"><div style="width: 30px;text-align: center;margin: 0 auto"><?php echo $comp['qty_component_needed']; ?></div></td>
									<?php
									if(!(empty($periode))){
										foreach ($periode as $per) {
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
									<td align="center"><?php echo $qty_needed?></td>
									<td align="center"><?php echo $qty_actual?></td>
									<td align="center" style="background-color: #FFD1CB"><?php echo $qty_kurang?></td>
									<td align="center"><?php echo $status?></td>
								<?php
										}
									}
									$no++;
									}
								}
								?>
								</tr>
							</tbody>
							-->
							<!-- Versi Datatable.end -->

							<!-- Versi Lain -->
							
							<tbody>
								<?php
								if(!(empty($area_list))){
									foreach ($area_list as $ar) {
								?>
								<tr>
									<td colspan="4" align="center" style="width:240px;background-color: #cecece">
										<div style="width: 240px">
											<b>AREA <?php echo $ar['area']; ?></b>
										</div>
									</td>
									<td style="display: none"></td>
									<td style="display: none"></td>
									<td style="display: none"></td>
									<?php
									if(!(empty($periode))){
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
									if(!(empty($subassy_list))){
										foreach ($subassy_list as $sub) {
											if ($sub['area'] == $ar['area']) {
												if ($sub['subassy_desc'] != '') {
								?>
								<tr>
									<td colspan="4">
										<b><?php 
											$no = 1;
											echo $sub['subassy_desc'];
										?></b>
									</td>
									<td style="display: none"></td>
									<td style="display: none"></td>
									<td style="display: none"></td>
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
											if(!(empty($component_list))){
												foreach ($component_list as $comp) {
													if ($comp['subassy_desc'] == $sub['subassy_desc']) {
								?>
								<tr>
									<td align="center"><?php echo $no; ?></td>
									<td><?php echo $comp['component_code']; ?></td>
									<td><?php echo $comp['component_desc']; ?></td>
									<td align="center" style="width: 30px;"><div style="width: 30px;text-align: center;margin: 0 auto"><?php echo $comp['qty_component_needed']; ?></div></td>
								<?php
													if(!(empty($periode))){
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
																	$status = $tr_status['status_publish'];
																}
								?>
									<td align="center"><?php echo $qty_needed?></td>
									<td align="center"><?php echo $qty_actual?></td>
									<td align="center" style="background-color: #FFD1CB"><?php echo $qty_kurang?></td>
									<td><?php echo $status?></td>
								<?php
															}
														}
														$no++;
								?>
								</tr>
								
								<?php
													}
												}
											}
											}
										}
									}
									}
								}
								?>
							</tbody>
							
							<!--Versi Lain.end-->
						</table>
						