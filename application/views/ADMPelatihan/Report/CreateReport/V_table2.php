							<table class="table table-bordered table-striped table-condensed" style="table-layout: fixed;" name="tbodyevalPembelajaran" id="tbodyevalPembelajaran">
								<thead>
									<tr class="bg-primary">
										<th width="5%" style="text-align:center;">No</th>
										<th width="50%">Nama</th>
										<th >Noind</th>
										<th >Post-Test</th>
									</tr>
								</thead>
								<tbody id="tbodyEvalPembelajaran">
										<?php 
											$no=1; foreach ($participant as $prt) {		
										?>
									<tr class="clone" row-id="<?php echo $no; ?>">
										<td style="text-align:center;"><?php echo $no++; ?></td>
										<td>
											<?php echo $prt['participant_name'];?>
										</td>
										<td>
											<?php echo $prt['noind']; ?>
										</td>
										<td>
											<?php if ($prt['score_eval2_post']==NULL) {
												echo "-";
											}else{
												echo $prt['score_eval2_post']; 
											}
											?>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>