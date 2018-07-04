							<table class="table table-bordered table-striped table-condensed" style="table-layout: fixed;" name="tbodyevalPembelajaran" id="tbodyevalPembelajaran">
								<thead>
									<tr class="bg-primary">
										<th width="5%" style="text-align:center;">No</th>
										<th width="50%">Nama</th>
										<th >Noind</th>
										<th >Nilai Test</th>
									</tr>
								</thead>
								<tbody id="tbodyEvalPembelajaran">
									<?php 
										$no=1; foreach ($participant as $prt) {	
											if ($prt['status']==1) {	
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
											<?php 
												if ($prt['score_eval2_post']>=$standar_kelulusan) 
												{
													echo $prt['score_eval2_post'];
												}
												elseif ($prt['score_eval2_r1']>=$standar_kelulusan) 
												{
													echo '<font color="red">'.$prt['score_eval2_post'].'</font> /'.$prt['score_eval2_r1'];
												}
												elseif ($prt['score_eval2_r2']>=$standar_kelulusan) 
												{
													echo '<font color="red">'.$prt['score_eval2_post'].'/'.$prt['score_eval2_r1'].'</font> /'.$prt['score_eval2_r2'];
												}
												elseif ($prt['score_eval2_r3']>=$standar_kelulusan) 
												{
													echo '<font color="red">'.$prt['score_eval2_post'].'/'.$prt['score_eval2_r1'].'/'.$prt['score_eval2_r2'].'</font> /'.$prt['score_eval2_r3'];
												}
												else
												{
													echo "-";
												}
											?>
										</td>
									</tr>
									<?php 
											} 
										}
									?>
								</tbody>
							</table>