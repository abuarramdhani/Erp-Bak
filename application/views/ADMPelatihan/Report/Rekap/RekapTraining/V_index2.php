							<div class="table-responsive" style="overflow:hidden;">
								<table class="table table-striped table-bordered table-hover text-left" id="tblrecord" style="font-size:14px;table-layout:fixed;width:1080px;">
									<thead class="bg-primary">
										<tr>
											<th width="5%" style="text-align:center;">No</th>
											<th width="20%">Tanggal</th>
											<th >Nama Pelatihan</th>
											<th width="10%">Sifat</th>
											<th width="10%" style="text-align:center;">Sudah Terlaksana</th>
											<th width="10%" style="text-align:center;">Belum Terlaksana</th>
										</tr>
									</thead>
									<tbody>
									<?php $no = 0; foreach ($report as $rc) { $no++;?>
												<tr>
													<td width="5%"><?php echo $no ?></td>
													<td width="20%"><?php echo $rc['training_date']; ?>
													<td><?php echo $rc['scheduling_name']?></td>
													<td width="10%">
														<?php if ($rc['sifat']==1) {
															echo "Order";
														} else {
															echo "Tahunan";
														} ?>		
													</td>
													<td width="10%" style="text-align:center;"><?php echo $rc['persentase_terlaksana']?></td>
													<td width="10%" style="text-align:center;"><?php echo $rc['persentase_belum']?></td>
												</tr>
											<?php 
									}?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="4" style="text-align:center; background: #C8EFFF"><b>Jumlah Training yang Belum/Telah Terlaksana</b></td>
											<td  style="text-align:center;">
												<?php foreach ($allpercentage as $pr) { 
													echo $pr['terlaksana'];
												} ?>
											</td>
											<td  style="text-align:center;">
												<?php foreach ($allpercentage as $pr) { 
													echo $pr['belum_terlaksana'];
												} ?>
											</td>
										</tr>
										<tr  style="text-align:center;"> 
											<td colspan="4" style="text-align:center; background: #C2DFFF"><b>Total Presentase Rekap Training</b></td>
											<td>
												<?php foreach ($allpercentage as $pr) { 
													echo $pr['persentase_terlaksana'];
												} ?>
											</td>
											<td style="text-align:center;">
												<?php foreach ($allpercentage as $pr) { 
													echo $pr['persentase_belum'];
												} ?>
											</td>
										</tr>
									</tfoot>															
								</table>
							</div>