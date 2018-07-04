							<table class="table table-bordered table-striped table-condensed" id="tbodyevalReaksi">
								<thead class="bg-blue">
									<tr>
										<th width="5%" style="text-align:center;">No</th>
										<th width="60%">Komponen Evaluasi</th>
										<th width="35%%">Rata-rata</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=1; 
										foreach($GetSchName_QuesName_RPT as $sq)
										{ ?>
											<input type="text" name="txtSchId" value="<?php echo $sq['scheduling_id']?>" hidden="true">
											<input type="text" name="txtPckSchId" value="0" hidden="true">
											<?php 
											foreach ($GetSchName_QuesName_segmen as $segmen) {
												if ($sq['scheduling_id'] == $segmen['scheduling_id'] && $sq['questionnaire_id'] == $segmen['questionnaire_id'] && $segmen['segment_type']!='0') 
												{
													$n=0;
													$i=0;
														?>
															<tr>
																<td style="text-align:center;"><?php echo $no++; ?></td>
																<?php
																	echo '<td>'.$segmen['segment_description'].'</td>';
																?>
																<td>
																	<?php 
																		foreach ($t_nilai as $tot) {
																			if ($tot['scheduling_id'] == $segmen['scheduling_id'] && $tot['questionnaire_id'] == $segmen['questionnaire_id'] && $tot['segment_id'] == $segmen['segment_id']) {
																				echo round($tot['f_rata'],2);
																			}
																		}
																	?>
																</td>
															</tr>
														<?php 
													$i++; 
												}
											}
										}
									?>
								</tbody>
							</table>
							<div class="form-group">
								<div class="box-header with-border">
							      <h3 class="box-title" style="margin-top: 20px"></i>   KOMENTAR</h3>
							    </div>
							    <ul style="list-style: disc;">
							    	<?php
							    		echo '<li>'.implode('</li><li>', $komen);
							    		for ($i=0; $i < count($komen) ; $i++) { 
							    			echo ''; //agar bullet hanya sesuai jumlah row
							    		}
							    	?>
							    </ul>
							</div>