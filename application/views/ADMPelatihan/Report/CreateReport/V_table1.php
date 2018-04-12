							<table class="table table-bordered table-striped table-hover table-condensed" style="overflow:scroll; max-height: 500px;max-width: 2000px" id="tbodyevalReaksi">
								<thead class="bg-blue">
									<tr>
										<th style="text-align:center;vertical-align: middle; width: 50px" rowspan="2">No</th>
										<th style="vertical-align: middle;text-align:center; width: 250px" rowspan="2">Komponen Evaluasi</th>
										<th style="vertical-align: middle;text-align:center;" rowspan="2" hidden="true">Id</th>
										<th style="vertical-align: middle;text-align:center;" rowspan="2" hidden="true">Segmen</th>
										<th colspan="<?php echo $jmlrowPck; ?>" style="text-align:center;">Rata-rata</th>
									</tr>
									<tr>
										<?php foreach ($countPel as $ct) {
											foreach ($GetSchName_QuesName_RPTPCK as $sp) { ?>
												<td style="text-align:center;">
													<?php
														echo $sp['scheduling_name'];
													?>
													<input type="text" name="txtSchId[]" value="<?php echo $sp['scheduling_id']?>" hidden="true">
													<input type="text" name="txtPckSchId" value="<?php echo $sp['package_scheduling_id']?>" hidden="true">
												</td>
											<?php }
										} ?>
									</tr>
								</thead>
								<tbody>
								<?php
									$no=1;
									foreach ($justSegmentPck as $jspk) {
										?>
										<tr>
											<td style="text-align:center;"><?php echo $no++; ?></td>
											<td>
												<?php
													echo $jspk['segment_description'];
												?>
											</td>
											<td hidden="true">
												<?php foreach ($GetQueIdReportPaket as $qidp) {
													print_r($qidp);
												} ?>
											</td>
											<td hidden="true">
												<?php
												foreach ($GetSchName_QuesName_RPTPCK as $schid) {
													foreach ($GetSchName_QuesName_segmen as $sgm) {
														if ($schid['scheduling_id'] == $sgm['scheduling_id'] && $jspk['segment_description'] == $sgm['segment_description']) {
															print_r($sgm);
															echo "<br>";
														}
													} 
												}?>
											</td>
											<?php 
											foreach ($GetSchName_QuesName_RPTPCK as $spk) {
												$checkpoint=0;
												foreach ($t_nilai as $tot) {
													if ($jspk['segment_description'] == $tot['segment_description'] && $spk['scheduling_id'] == $tot['scheduling_id']) {
														echo '<td>'.round($tot['f_rata'],2).'</td>';
														$checkpoint++;
													}
												}
												
												if ($checkpoint==0) {
													echo "<td>-</td>";
													$checkpoint++;
												}
											}
											?>
										</tr>
									<?php }?>	
								</tbody>
							</table>