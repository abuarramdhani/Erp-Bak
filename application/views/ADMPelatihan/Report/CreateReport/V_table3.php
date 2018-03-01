							<!-- <?php
							echo "<pre>";
							print_r($participantName);
							echo "</pre>";
							?> -->
							<table class="table table-bordered table-striped table-hover table-condensed" style="overflow:scroll; max-height: 500px; max-width: 2000px" name="tbodyevalPembelajaran" id="tbodyevalPembelajaran">
								<thead class="bg-blue">
									<tr>
										<th style="text-align:center;vertical-align: middle; width: 50px" rowspan="2">No</th>
										<th style="text-align:center;vertical-align: middle;width: 300px" rowspan="2">Nama</th>
										<th style="text-align:center;vertical-align: middle; width: 100px" rowspan="2">Noind</th>
										<th colspan="<?php echo $jmlrowPck; ?>" style="text-align:center;vertical-align: middle">Post-Test</th>
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
											foreach ($GetSchName_QuesName_RPTPCK as $spk) {
												$checkpoint=0;
												foreach ($participant as $p) {
													if ($spk['scheduling_id'] == $p['scheduling_id'] && $prt['participant_name'] == $p['participant_name']) {
														echo "<td>".$p['score_eval2_post']."</td>";
														$checkpoint++;
													}
												}

												if ($checkpoint==0) {
													echo "<td>-</td>";
													$checkpoint++;
												}
											}
											?>  										
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>