							<table class="table table-bordered table-striped table-hover table-condensed" style="overflow:scroll; max-height: 500px; max-width: 2000px" name="tbodyevalPembelajaran" id="tbodyevalPembelajaran">
								<thead class="bg-blue">
									<tr>
										<th style="text-align:center;vertical-align: middle; width: 50px" rowspan="2">No</th>
										<th style="text-align:center;vertical-align: middle;width: 300px" rowspan="2">Nama</th>
										<th style="text-align:center;vertical-align: middle; width: 100px" rowspan="2">Noind</th>
										<th colspan="<?php echo $jmlrowPck; ?>" style="text-align:center;vertical-align: middle">Nilai Test</th>
									</tr>
									<tr>
										<?php foreach ($countPel as $ct) {
											foreach ($GetSchName_QuesName_RPTPCK as $sp) { ?>
												<td style="text-align:center;">
													<?php
														echo $sp['scheduling_name'];
													?>
													<input type="text" name="txtSchId2[]" value="<?php echo $sp['scheduling_id']?>" hidden="true">
													<input type="text" name="txtPckSchId2" value="<?php echo $sp['package_scheduling_id']?>" hidden="true">
												</td>
											<?php }
										} ?>
									</tr>
								</thead>
								<tbody id="tbodyEvalPembelajaran">
									<?php 
										$no=1; foreach ($participantName as $prt) {	
											if ($prt['status'] == 1) {
													
									?>
												<tr class="clone" row-id="<?php echo $no; ?>">
													<td style="text-align:center;"><?php echo $no++; ?></td>
													<td>
														<?php echo $prt['participant_name'];?>
													</td>
													<td style="text-align:center;">
														<?php echo $prt['noind']; ?>
													</td>
														<?php 
														$stafdata = array();
														$nonstafdata = array();
														foreach ($GetSchName_QuesName_RPTPCK as $spk) 
														{
															$checkpoint=0;
															foreach ($participant as $p) 
															{
																// AMBIL STANDAR KELULUSAN STAF DAN NONSTAF-------------------
																$nilai_minimum = explode(',', $spk['standar_kelulusan']);
																$min_s = $nilai_minimum[0];
																$min_n = $nilai_minimum[1];
																// ------------------------------------------------------------
																if ($spk['scheduling_id'] == $p['scheduling_id'] && $prt['participant_name'] == $p['participant_name']) 
																{	
																	// NOMOR INDUK YANG STAF DAN NONSTAFF UNTUK MEMBEDAKAN 
																	$staffCode = array('B', 'D', 'J', 'Q');
																	$indCode = substr($p['noind'], 0, 1);
																	if (in_array($indCode, $staffCode)) 
																	{
																		$a='stafKKM';
																		array_push($stafdata, $p['noind'] );
																	}
																	else
																	{
																		$a='nonstafKKM';
																		array_push($nonstafdata, $p['noind'] );
																	}
																	// --------------------------------------------------------------------------------------------------------------
																	// KONDISI APABILA ADA PESERTA REMIDI
																	// STAF
																	if ($p['score_eval2_post']>=$min_s) 
																	{
																		$nilai_s='<td>'.$p['score_eval2_post'].'</td>';
																	}
																	elseif ($p['score_eval2_r1']>=$min_s)
																	{
																		$nilai_s='<td><font color="red">'.$p['score_eval2_post'].'</font> /'.$p['score_eval2_r1'].'</td>';
																	}
																	elseif ($p['score_eval2_r2']>=$min_s)
																	{
																		$nilai_s='<td><font color="red">'.$p['score_eval2_post'].'/'.$p['score_eval2_r1'].'</font> /'.$p['score_eval2_r2'].'</td>';
																	}
																	elseif ($p['score_eval2_r3']>=$min_s)
																	{
																		$nilai_s='<td><font color="red">'.$p['score_eval2_post'].'/'.$p['score_eval2_r1'].'/'.$p['score_eval2_r2'].'</font> /'.$p['score_eval2_r3'].'</td>';
																	}
																	else
																	{
																		$nilai_s='<td>-</td>';
																	}
																	//NONSTAF---------------------------------------------------------------------------------------------------------
																	if ($p['score_eval2_post']>=$min_n) 
																	{
																		$nilai_n='<td>'.$p['score_eval2_post'].'</td>';
																	}
																	elseif ($p['score_eval2_r1']>=$min_n)
																	{
																		$nilai_n='<td><font color="red">'.$p['score_eval2_post'].'</font> /'.$p['score_eval2_r1'].'</td>';
																	}
																	elseif ($p['score_eval2_r2']>=$min_n)
																	{
																		$nilai_n='<td><font color="red">'.$p['score_eval2_post'].'/'.$p['score_eval2_r1'].'</font> /'.$p['score_eval2_r2'].'</td>';
																	}
																	elseif ($p['score_eval2_r3']>=$min_n)
																	{
																		$nilai_n='<td><font color="red">'.$p['score_eval2_post'].'/'.$p['score_eval2_r1'].'/'.$p['score_eval2_r2'].'</font> /'.$p['score_eval2_r3'].'</td>';
																	}
																	else
																	{
																		$nilai_n='<td>-</td>';
																	}
																	// --------------------------------------------------------------------------------------------------------------
																	// ISI STAFDATA DAN NONSTAFDATA
																	if ($stafdata!=null && $nonstafdata==null) 
																	{
																		echo $nilai_s;
																	} 
																	else 
																	{
																		echo $nilai_n;
																	}
																	// --------------------------------------------------------------------------------------------------------------
																	$checkpoint++;
																}
															}

															if ($checkpoint==0) 
															{
																echo "<td>-</td>";
																$checkpoint++;
															}
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