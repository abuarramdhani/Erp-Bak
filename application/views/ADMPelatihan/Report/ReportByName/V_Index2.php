						<div class="table-responsive" style="overflow:hidden;">
							<table class="table table-striped table-bordered table-hover text-left" id="tblrecord" style="font-size:14px;table-layout:fixed;width:1800px;">
								<thead class="bg-primary">
									<tr>
										<th width="10%" style="text-align:center;">No</th>
										<th width="30%" style="text-align:center;">Nama Peserta</th>
										<th width="30%" style="text-align:center;">Seksi</th>
										<th width="30%">Nama Pelatihan</th>
										<th width="20%">Tanggal</th>
										<th width="20%">Nilai</th>
										<th width="20%">Keterangan</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=0; foreach($report as $rc){ $no++;
									?>
									<tr>
										<td align="center"><?php echo $no ?></td>
										<td><?php echo $rc['participant_name'] ?></td>
										<td><?php echo $rc['section_name'] ?></td>
										<td><?php echo $rc['scheduling_name'] ?></td>
										<td><?php echo $rc['date_format'] ?></td>
										<td>
											<?php
												echo max($rc['score_eval2_post'],$rc['score_eval2_r1'],$rc['score_eval2_r2'],$rc['score_eval2_r3']); 
											?>
										</td>
										<td>
											<?php
												if ($rc['lulus']==1) {
													echo "LULUS"; 
												 } else {
												 	echo "TIDAK LULUS";
												 }
											?>	
										</td>
									</tr>
									<?php } ?>
								</tbody>															
							</table>
						</div>
					
