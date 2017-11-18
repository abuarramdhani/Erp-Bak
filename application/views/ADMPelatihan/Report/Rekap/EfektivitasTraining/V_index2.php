							<div class="table-responsive" style="overflow:hidden;">
								<table class="table table-striped table-bordered table-hover text-left" id="tblrecord" style="font-size:14px;table-layout:fixed;width:1080px;">
									<thead class="bg-primary">
										<tr>
											<th width="7%" style="text-align:center;">No</th>
											<th  width="15%">Tanggal</th>
											<th >Nama Pelatihan</th>
											<th width="10%">Jenis Training</th>
											<th width="8%" style="text-align:center;">Lulus</th>
											<th width="8%" style="text-align:center;">Tidak Lulus</th>
											<th width="8%" style="text-align:center;">Presentase Kelulusan</th>
										</tr>
									</thead>
									<tbody>
									<?php $no=0 ;foreach ($efekTrain as $et) {
										$no++;  ?>
											<tr>
												<td style="text-align:center;"><?php echo $no?></td>
												<td><?php echo $et['training_date']?></td>
												<td><?php echo $et['scheduling_name']?></td>
												<?php 
													$traintype='';
													if ($et['training_type']==1) {$traintype='ORIENTASI' ;}
													if ($et['training_type']==2) {$traintype='NON ORIENTASI' ;}
												?>
												<td width="20%">
														<?php echo $traintype; ?>
												</td>
												<td width="8%" style="text-align:center;"><?php echo $et['kelulusan']?></td>
												<td width="8%" style="text-align:center;"><?php echo $et['ketidak_kelulusan']?></td>
												<?php foreach ($efekTrainall as $eta) { 
													if ($et['scheduling_id']==$eta['scheduling_id']) {
													  ?>
													<td  width="8%" style="text-align:center;">
														 <?php echo $eta['persentase']; ?>
													</td>
												<?php } }?>
											</tr>
									<?php  } ?>
									</tbody>															
								</table>
							</div>