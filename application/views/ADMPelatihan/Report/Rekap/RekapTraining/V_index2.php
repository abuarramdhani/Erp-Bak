							<div class="table-responsive" style="overflow:hidden;">
								<table class="table table-striped table-bordered table-hover text-left" id="tblrecord" style="font-size:14px;table-layout:fixed;width:1080px;">
									<thead class="bg-primary">
										<tr>
											<th width="5%" style="text-align:center;">No</th>
											<th width="10%" style="text-align:center;">Bulan</th>
											<th width="10%" style="text-align:center;">Tahun</th>
											<th >Nama Pelatihan</th>
											<th width="10%" style="text-align:center;">Sudah Terlaksana</th>
											<th width="10%" style="text-align:center;">Belum Terlaksana</th>
										</tr>
									</thead>
									<tbody>
									<?php $no = 0; foreach ($report as $rc) { $no++;
										foreach ($namaTrain as $nt) {
											if ($rc['scheduling_id'] == $nt['scheduling_id']) {			
												?>
												<tr>
													<td width="5%"><?php echo $no ?></td>
													<td width="10%"><?php echo $rc['bulan']; ?></td>
													<td width="10%"><?php echo $rc['tahun']; ?></td>
													<td><?php echo $nt['scheduling_name']?></td>
													<td width="10%"><?php echo $rc['persentase_terlaksana']?></td>
													<td width="10%"><?php echo $rc['persentase_belum']?></td>
												</tr>
											<?php } 
										} 
									}?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="4" style="text-align:center; background: #C2DFFF"><b>Total Rekap Training</b></td>
											<td>
												<?php foreach ($allpercentage as $pr) { 
													echo $pr['persentase_terlaksana'];
												} ?>
											</td>
											<td>
												<?php foreach ($allpercentage as $pr) { 
													echo $pr['persentase_belum'];
												} ?>
											</td>
										</tr>
									</tfoot>															
								</table>
							</div>