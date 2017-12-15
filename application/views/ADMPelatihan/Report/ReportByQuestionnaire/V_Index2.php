						<div class="table-responsive" style="overflow:scroll; max-height: 500px">
							<table class="table table-striped table-bordered table-hover text-left" id="tblreportque" style="font-size:14px;table-layout:fixed;width:1500px; ">
								<thead class="bg-primary">
									<tr>
										<th width="2%" style="text-align:center;">No</th>
										<th width="10%">Nama Pelatihan</th>
										<th width="5%">Tanggal</th>
										<th width="10%">Trainer</th>
										<th width="10%">Kuesioner</th>
										<th width="10%">Komponen Evaluasi</th>
										<th width="5%">Total</th>
										<th width="5%">Rata-rata</th>
										<th width="5%">Keterangan</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=1; foreach($GetSchName_QuesName as $sq){ 
											$strainer = explode(',', $sq['trainer']);
											$checkpoint_sg_desc = 0;
											foreach ($GetSchName_QuesName_segmen as $segmen) {
												if ($sq['scheduling_id'] == $segmen['scheduling_id'] && $sq['questionnaire_id'] == $segmen['questionnaire_id']) {
											$n=0;
											$i=0;
									?>
										<tr>
											<?php if ($checkpoint_sg_desc == 0) {
												$checkpoint_sch_id = 0;
												foreach ($sgCount as $key => $value) {
													if ($value['scheduling_id']==$segmen['scheduling_id'] && $value['questionnaire_id']==$segmen['questionnaire_id'] && $checkpoint_sch_id == 0) {?>
														<td align="center" rowspan="<?php echo $value['rowspan']; ?>"><?php echo $no++ ?></td>
														<td rowspan="<?php echo $value['rowspan']; ?>"><a href="<?php echo base_url('ADMPelatihan/Report/reportbyquestionnaire_1/'.$sq['scheduling_id'].'/'.$sq['questionnaire_id']);?>" rowspan="<?php echo $value['rowspan']; ?>"><?php echo $sq['scheduling_name']?></a></td>
														<td rowspan="<?php echo $value['rowspan']; ?>" style="min-width: 100px"><?php echo $sq['date']; ?></td>
														<td rowspan="<?php echo $value['rowspan']; ?>" style="min-width: 100px">
														<?php
															foreach ($strainer as $st) {
																foreach ($trainer as $tr) {
																	if ($st==$tr['trainer_id']) {
																		echo $tr['trainer_name'].'<br>';
																	}
																}
															}
														?>
														</td>
														<td rowspan="<?php echo $value['rowspan']; ?>" style="min-width: 100px"><?php echo $sq['questionnaire_title']; ?></td>
													<?php $checkpoint_sch_id = 1;
													}
													$checkpoint_sg_desc = 1;
												}
											} ?>
											<?php
												echo '<td>'.$segmen['segment_description'].'</td>';
											?>
											<td>
												<?php 
													foreach ($t_nilai as $tot) {
														if ($tot['scheduling_id'] == $segmen['scheduling_id'] && $tot['questionnaire_id'] == $segmen['questionnaire_id'] && $tot['segment_id'] == $segmen['segment_id']) {
															echo $tot['f_total'];
														}
													}
												?>
											</td>
											<td>
												<?php 
													foreach ($t_nilai as $tot) {
														if ($tot['scheduling_id'] == $segmen['scheduling_id'] && $tot['questionnaire_id'] == $segmen['questionnaire_id'] && $tot['segment_id'] == $segmen['segment_id']) {
															echo $tot['f_rata'];
														}
													}
												?>
											</td>
											<td>
												<?php
													foreach ($t_nilai as $tot) {
														if ($tot['scheduling_id'] == $segmen['scheduling_id'] && $tot['questionnaire_id'] == $segmen['questionnaire_id'] && $tot['segment_id'] == $segmen['segment_id']) {
															if (1<=$tot['f_rata'] && $tot['f_rata']<=1.74) {echo "Kurang";}
															elseif (1.75<=$tot['f_rata'] && $tot['f_rata']<=2.49) {echo "Sedang";}
															elseif (2.5<=$tot['f_rata'] && $tot['f_rata']<=3.24) {echo "Baik";}
															elseif (3.25<=$tot['f_rata'] && $tot['f_rata']<=4) {echo "Baik Sekali";}
														}
													}
												?>
											</td>
										</tr>
									<?php $i++; }
										}
									}?>
								</tbody>
							</table>
						</div>