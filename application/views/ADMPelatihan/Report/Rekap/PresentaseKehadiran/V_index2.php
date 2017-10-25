							<div class="table-responsive" style="overflow:hidden;">
								<table class="table table-striped table-bordered table-hover text-left" id="tblrecord" style="font-size:14px;table-layout:fixed;width:1080px;">
									<thead class="bg-primary">
										<tr>
											<th width="5%" style="text-align:center;">No</th>
											<th width="10%" style="text-align:center;">Bulan</th>
											<th width="10%" style="text-align:center;">Tahun</th>
											<th >Nama Pelatihan</th>
											<th width="8%" style="text-align:center;">Jumlah Peserta</th>
											<th width="8%" style="text-align:center;">Hadir</th>
											<th width="10%" style="text-align:center;">Presentase Kehadiran</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 0; foreach ($prcentpart as $pp) { $no++;
											foreach ($namaTrain as $nt) { 
												if ($pp['scheduling_id'] == $nt['scheduling_id']) {
												?>
													<tr>
														<td><?php echo $no; ?></td>
														<td><?php echo $pp['bulan']; ?></td>
														<td><?php echo $pp['tahun']; ?></td>
														<td><?php echo $nt['scheduling_name']?></td>
														<td style="text-align:center;"><?php echo $pp['participant_number']?></td>
														<td style="text-align:center;"><?php echo $pp['hadir']?></td>
														<td style="text-align:center;">
															<?php if ($pp['persentase_kehadiran']!=NULL) { ?>
																<?php echo $pp['persentase_kehadiran']?>		
															<?php } else{
																echo "0 %";
																} ?>
														</td>
													</tr>
												<?php } 
											}
										} ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="6" style="text-align:center; background: #C2DFFF"><b>Total Presentase Kehadiran</b></td>
												<td style="text-align:center;">
												<?php foreach ($prcentpartall as $pa) { 
													if ($pa['persentase_hadir_total']!= NULL) {?>
															<?php echo $pa['persentase_hadir_total']; ?>		
													<?php } else {
															echo "0 %";
														} 
												}?>
											</td>
										</tr>
									</tfoot>																
								</table>
							</div>