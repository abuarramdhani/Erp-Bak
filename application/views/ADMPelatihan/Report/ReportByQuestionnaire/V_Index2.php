						<div class="table-responsive" style="overflow:hidden;">
							<table class="table table-striped table-bordered table-hover text-left" id="tblrecord" style="font-size:14px;table-layout:fixed;width:1800px;">
								<thead class="bg-primary">
									<tr>
										<th width="2%" style="text-align:center;">No</th>
										<th width="10%">Nama Pelatihan</th>
										<th width="10%">Kuesioner</th>
										<th width="10%">Sub 1 (Segment)</th>
										<th width="10%">Sub 2 (Presentase hasil Kuesioner)</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=0; foreach($report as $rc){ $no++;
										$strainer = explode(',', $rc['trainer']);
									?>
									<tr>
										<td align="center"><?php echo $no ?></td>
										<td><a href='<?php echo base_url('ADMPelatihan/Record/Detail/'.$rc['scheduling_id']);?>'><?php echo $rc['scheduling_name'] ?></a></td>
										<td><?php echo $rc['training_date'] ?></td>
										<td>
											<?php 
												foreach ($strainer as $st){
													foreach ($trainer as $tr){
														if ($st == $tr['trainer_id']){
															echo '<i class="fa fa-angle-right"></i> '.$tr['trainer_name'].'<br>';
														}
													}
												};
											?>
										</td>
										<td align="center"><?php echo $rc['participant_number'] ?></td>
										<td></td>
										<td></td>
									</tr>
									<?php } ?>
								</tbody>															
							</table>
						</div>