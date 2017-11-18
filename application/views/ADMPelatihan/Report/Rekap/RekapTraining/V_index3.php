							<br>
							<br>
							<div class="table-responsive" style="overflow:hidden;">
								<table class="table table-striped table-bordered table-hover text-left" id="tblrecord" style="font-size:14px;table-layout:fixed;width:1080px;">
									<thead class="bg-primary">
										<tr>
											<th width="25%" style="text-align:center; vertical-align: middle;" rowspan="2" colspan="2">
											<?php $checkPoint = 0; foreach ($getsifat as $gs) {
												if ($checkPoint == 0) {
													$checkPoint = 1;
													echo $gs['tanggal1']."<br> s/d <br>".$gs['tanggal2']; 
												}
												}?>
											</th>
											<th width="35%" colspan="2" style="text-align:center;">ORDER</th>
											<th width="35%" colspan="2" style="text-align:center;">TAHUNAN</th>
										</tr>
										<tr>
											<td width="15%" style="text-align:center;"><b>Belum Terlaksana</b></td>
											<td width="15%" style="text-align:center;"><b>Sudah Terlaksana</b></td>
											<td width="15%" style="text-align:center;"><b>Belum Terlaksana</b></td>
											<td width="15%" style="text-align:center;"><b>Sudah Terlaksana</b></td>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($getsifat as $gs) { ?>
											<tr>
												<td width="10%" style="text-align:center;vertical-align: middle;" rowspan="2" class="bg-primary"><b><?php echo $gs['bulan'] ?></b></td>
												<td width="20%" style="text-align:center;" class="bg-primary"><b>TOTAL<b></td>
												<td width="15%"><?php echo $gs['order_bl_terlaksana'] ?></td>
												<td width="15%"><?php echo $gs['order_terlaksana'] ?></td>
												<td width="15%"><?php echo $gs['tahunan_bl_terlaksana'] ?></td>
												<td width="15%"><?php echo $gs['tahunan_terlaksana'] ?></td>
											</tr>
											<tr>
												<td width="20%" style="text-align:center;" class="bg-primary"><b>PERSENTASE<b></td>
												<td width="15%"><?php echo $gs['persentase_order_bl_terlaksana'] ?></td>
												<td width="15%"><?php echo $gs['persentase_order_terlaksana'] ?></td>
												<td width="15%"><?php echo $gs['persentase_tahunan_bl_terlaksana'] ?></td>
												<td width="15%"><?php echo $gs['persentase_tahunan_terlaksana'] ?></td>
											</tr>
										<?php } ?>	
									</tbody>															
								</table>
							</div>