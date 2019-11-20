<style>
	th, td{
		text-align: center;
		vertical-align: middle;
		font-size: 12px;
	}
	.des{
		text-align: justify;
	}
	.button10 {
		background-color: #3c8dbc; 
		color: white; 
		border: 1px solid #3c8dbc ;
	}
</style>

<table id="uwo" class="table table-striped table-bordered table-hover">
	<thead class="btn-info">
		<tr>
			<th>NO</td>
				<th>NO JOB</th>
				<th>ASSY</th>
				<th>DESKRIPSI ASSY</th>
				<th>QTY JOB</th>
				<th>TRANSACT</th>
				<th>TANGGAL TRANSACT</th>
				<th>QTY KEMBALI</th>
				<th>STOK</th>
				<th>STATUS PO </th>
				<th>DELIVER</th>
				<th>VENDOR</th>
				<th>DETAIL</th>
				
			</tr>
		</thead>
		<tbody>
			<?php $no=1;
			foreach ($value as $row) {
				if ($row['QTY_JOB'] == $row['QTY_KEMBALI']) {
					// $tundu= "bg-success";
					$tulisan = 'DONE';
				} else {
					// $tundu ="";
					$tulisan = 'OPEN';
				}
				?>
				<tr >
					<td><?= $no++; ?></td>
					<td><?= $row['NO_JOB'] ?></td>
					<td><?= $row['ASSY'] ?></td>
					<td><?= $row['ASSY_DESC'] ?></td>
					<td><?= $row['QTY_JOB'] ?></td>
					<td></td>
					<td><?= $row['TGL_TRANSACT_MO'] ?></td>
					<td><?= $row['QTY_KEMBALI'] ?></td>
					<td><?= $row['QTY_JOB'] - $row['QTY_KEMBALI'] ?> </td>
					<td><b><?= $tulisan ?></b></td>
					<td><?= $row['DELIVE'] ?></td>
					<td><?= $row['VENDOR_NAME'] ?></td>
					<td><button class=" btn-xs button10 " onclick="intine(this, <?= $no ?>)" >Show</button></td>
				</tr>
				<tr>                             
					<td></td>                             
					<td colspan="12" >                                 
						<div id="detail<?= $no ?>" style="display:none">                                     
							<table class="table table-bordered table-hover table-striped table-responsive " style="width: 100%;">
								<thead class="bg-primary">                                             
									<tr>  
										<th>NO</th>                                          
										<th>NO RECEIPT</th>                                                 
										<th>QTY RECEIPT ASSY</th>                                           
										<th>NO PO </th>                                                 
										<th>TGL RECEIPT</th> 
										<th>NO JOB</th>
										<th>QTY DELIVER</th> 
										<th>DETAIL</th>                                                 
									</tr>                                         
								</thead>                                        
								<tbody>                                         
									<?php $nomor=1; foreach ($row['DETAIL'] as $v) { ?>                                             
										<tr>                                                 
											<td><?= $nomor++ ?> </td>                                                 
											<td><?= $v['NO_RECEIPT'] ?></td>                                                 
											<td><?= $v['QTY_RECEIPT'] ?></td>                                                 
											<td><?= $v['NO_PO'] ?></td>                                                 
											<td><?= $v['TGL_RECEIPT'] ?></td>                                                 
											<td><?= $v['NO_JOB'] ?></td>
											<td><?= $v['SUM_DELIVE'] ?></td>
											<td><button class="btn btn-xs btn-warning " onclick="intinee(this, <?= $no ?>, <?= $nomor?>)" >Show</button></td>
										</tr>
										<tr>                             
											<td></td>                             
											<td colspan="8" >                                 
												<div id="subdetail<?= $no ?><?= $nomor?>" style="display:none">                                     
													<table class="table table-bordered table-hover table-striped table-responsive " style="width: 100%;">                                         
														<thead class="btn-warning">                                             
															<tr>  
																<th>NO</th>                                          
																<th>KOMPONEN</th>                                                 
																<th>DESKRIPSI</th>                                           
																<th>QTY KOMPONEN </th>                                                 
																<th>QTY TRANSACT</th> 
																<th>QTY RECIPT KOMP</th> 
															</tr>                                         
														</thead>                                        
														<tbody>                                         
															<?php $noo=1; foreach ($v['PLUS'] as $vo) { ?>         
																<tr>                                                 
																	<td><?= $noo++ ?></td>                                                 
																	<td><?= $vo['ITEM'] ?></td>                                                 
																	<td><?= $vo['DESCRIPTION'] ?></td>                                            
																	<td><?= $vo['QTY_KOMPONEN'] ?></td>                                 
																	<td><?= $vo['QTY_TRANSACT_KOMP'] ?></td>                                         
																	<td><?= $vo['QTY_RECIPT_KOM'] ?></td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</td>
				</tr>
			<?php } ?>
			<!-- kk -->
		</tbody>
	</table>
