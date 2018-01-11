<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script> 

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
							<h1><b>Report Pelatihan</b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
	                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/Report/ReportByQuestionnaire');?>">
	                                <i class="icon-wrench icon-2x"></i>
	                                <span><br/></span>	
	                            </a>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<b>Detail Komponen Evaluasi Kuesioner</b>
							</div>
							<div class="box-body">
								<div class="table-responsive" style="overflow:hidden;overflow:scroll;max-height: 380px;">
									<table class="table table-striped table-bordered table-hover text-left" id="tblrecord" style="font-size:14px;width:1800px;">
										<?php 
												$no=0; $no++;
											?>
										<thead>
											<tr class="bg-primary">
												<th>No</th>
												<th>Segmen</th>
												<th>Statement</th>
												<?php foreach($sheet as $se){ ?>
													<td style="min-width:150px;text-align: center;"><?php echo '<b>Subjek - '.$no++.'</b>'; ?></td>
												<?php } ?>
												<th style="min-width: 70px">Total</th>
												<th style="min-width: 70px">Rata-Rata</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$no=1; foreach ($GetSchName_QuesName_detail as $gsq) { ?>
												<input type="text" name="txtID" value="<?php echo $gsq['scheduling_id'];?>" hidden>
											<tr>	
												<?php
												$n=0;
												$i=0;
												foreach($segment as $sg){
													if ($sg['scheduling_id']==$gsq['scheduling_id']) {
														$checkpoint_sg_desc = 0;
														foreach($statement as $st => $val){
															if ($sg['segment_id'] == $val['segment_id']) {
													?>
														<tr>
															<?php if ($checkpoint_sg_desc == 0) {
																foreach ($sgstCount as $key => $value) {
																	if ($value['segment_id'] == $sg['segment_id']) { ?>
																		<td rowspan="<?php echo $value['rowspan']; ?>" align="center" style="max-width: 5px"> <?php echo $no++; ?> </td>
																		<td rowspan="<?php echo $value['rowspan']; ?>" style="min-width: 100px"><?php echo $sg['segment_description']; ?></td>
																	<?php }
																}
																$checkpoint_sg_desc = 1;
															} ?>
															<td style="min-width: 300px"><?php echo $val['statement_description']; ?></td>
															<?php
																$indeks_sheet = 0;
																foreach($sheet as $se){
																	$stj = explode('||', $se['join_input']);
																	$stj_id = explode('||', $se['join_statement_id']);
																	$stj_temp[$i][$indeks_sheet++] = array(
																		'join_statement_id' => $stj_id[$i],
																		'join_input'		=> $stj[$i]
																	);
																if($stj[$i] == 1) echo "<td>1</td>";
																else if($stj[$i] == 2) echo "<td>2</td>";
																else if($stj[$i] == 3) echo "<td>3</td>";
																else if($stj[$i] == 4) echo "<td>4</td>";
																else if(empty($stj[$i]))echo "<td>-</td>";
																else echo '<td style="min-width:150px">'.$stj[$i].'</td>';}
															?>
															<td style="min-width: 70px">
																<?php
																	$total = 0;
																	for ($n=0; $n < count($stj_temp[$i]); $n++) { 
																		$total = $total + $stj_temp[$i][$n]['join_input'];
																	}
																	echo $total;
																?>
															</td>
															<td style="min-width: 70px">
																<?php
																	$total = 0;
																	for ($n=0; $n < count($stj_temp[$i]); $n++) { 
																		$total = $total + $stj_temp[$i][$n]['join_input'];
																		foreach ($GetQuestParticipant as $key => $qp) {
																			$rata_rata = $total/$qp['peserta_kuesioner'];
																		}
																	}
																	echo $rata_rata;
																?>
															</td>
														</tr>
															<?php
																$i++;
															}
														}
													}
													?>
												<?php }
												}
											?>
										</tbody>
									</table>
								</div>

								<hr>
								<div class="form-group">
									<div class="col-lg-12 text-right">
										<a href="<?php echo site_url('ADMPelatihan/Report/ReportByQuestionnaire');?>"  class="btn btn-primary btn btn-flat">Back</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</section>		