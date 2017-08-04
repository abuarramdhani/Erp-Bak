						<div class="table-responsive" style="overflow:hidden;">
							<table class="table table-striped table-bordered table-hover text-left" id="tblrecord" style="font-size:14px;table-layout:fixed;">
								<thead class="bg-primary">
									<tr>
										<th width="10%" style="text-align:center;">No</th>
										<th width="30%">Nama Pelatihan</th>
										<th width="20%">Tanggal</th>
										<th width="20%">Nilai</th>
										<th width="20%">Status kelulusan</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=0; foreach($report as $rc){ $no++;
									?>
									<tr>
										<td align="center"><?php echo $no ?></td>
										<td><?php echo $rc['scheduling_name'] ?></td>
										<td><?php echo $rc['date_format'] ?></td>
										<td><?php echo $rc['score_eval3_post1'] ?></td>
										<td><?php echo $rc['standar_kelulusan'] ?></td>
									</tr>
									<?php } ?>
								</tbody>															
							</table>
						</div>
					
