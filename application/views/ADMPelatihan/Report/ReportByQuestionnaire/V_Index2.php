						<div class="table-responsive" style="overflow:hidden;">
							<table class="table table-striped table-bordered table-hover text-left" id="tblrecord" style="font-size:14px;table-layout:fixed;width:1800px;">
								<thead class="bg-primary">
									<tr>
										<th width="2%" style="text-align:center;">No</th>
										<th width="10%">Nama Pelatihan</th>
										<th width="10%">Kuesioner</th>
										<th width="10%">Komponen Evaluasi</th>
										<th width="5%">Total</th>
										<th width="5%">Rata-rata</th>
										<th width="10%">Keterangan</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=0; foreach($GetSchName_QuesName as $sq){ $no++;
									?>
									<tr>
										<td align="center"><?php echo $no ?></td>
										<td><a href="<?php echo base_url('ADMPelatihan/Report/reportbyquestionnaire_1/'.$sq['scheduling_id'].'/'.$sq['questionnaire_id']);?>"><?php echo $sq['scheduling_name'] ?></a></td>
										<td><?php echo $sq['questionnaire_title'] ?></td>
										<td><?php echo $sq['segment_description']; ?></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>