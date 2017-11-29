						<div class="table-responsive" style="overflow:hidden;">
							<table class="table table-striped table-bordered table-hover text-left" id="tblrecord" style="font-size:14px;table-layout:fixed;width:1800px;">
								<thead class="bg-primary">
									<tr>
										<th width="2%" style="text-align:center;">No</th>
										<th width="18%">Nama Pelatihan</th>
										<th width="7%">Tanggal</th>
										<th width="14%">Trainer</th>
										<th width="6%" style="text-align:center;">Jumlah Peserta</th>
										<th width="10%">Nama Paket</th>
										<th width="10%">Tanggal Paket</th>
										<th width="6%">Jumlah Kelulusan</th>
										<th width="6%">Persentase Kelulusan</th>
										<th width="7%">Nilai Tertinggi</th>
										<th width="7%">Nilai Terendah</th>
										<th width="7%">Nilai Rata-rata</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=0; foreach($report as $rc){ $no++;
										$strainer = explode(',', $rc['trainer']);

										//$packagedate=$rc['start_date_format'].' - '.$rc['end_date_format'];
										//if(is_null($rc['start_date_format']) OR is_null($rc['start_date_format'])){$packagedate="";}
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
										<td><?php echo $rc['kelulusan'] ?></td>
										<td><?php $PersentaseKelulusan=$rc['kelulusan']/$rc['participant_number']*100; 
										echo number_format((float)$PersentaseKelulusan, 2, '.', '');
											?> %</td>
										<td><?php echo $rc['nilai_maximum'] ?></td>
										<td><?php echo $rc['nilai_minimum'] ?></td>
										<td><?php echo $rc['nilai_rerata'] ?></td>
									</tr>
									<?php } ?>
								</tbody>															
							</table>
						</div>
					
