
							<table class="table table-striped table-bordered table-hover text-left" id="tblrecord" style="font-size:14px;table-layout:fixed;width:1080px;">
								<thead class="bg-primary">
									<tr>
										<th width="5%" style="text-align:center;">No</th>
										<th >Seksi</th>
										<th width="7%" style="text-align:center;">Jumlah Peserta</th>
										<th width="7%" style="text-align:center;">Lihat Peserta</th>
										<th  >Nama Pelatihan</th>
										<th width="8%" style="text-align:center;">Periode</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=0; foreach($report as $rc){ $no++;
									?>
									<tr>
										<td width="5%" align="center"><?php echo $no ?></td>
										<td ><?php echo $rc['section_name'] ?></td>
										<td align="center"><?php echo $rc['jml'] ?></td>
										<td width="7%" style="text-align:center;">
											<a href="javascript:void(0)" class="btn btn-flat btn-sm btn-warning" name="showModPar" onclick="showModPar('<?php echo $rc['scheduling_id']."','".$rc['section_name'] ?>')">
												<i class="fa fa-search"></i>
											</a>
										</td>
										<td><?php echo $rc['nama'] ?></td>
										<td style="text-align:center;"><?php echo $rc['tahun'] ?></td>
									</tr>
									<?php } ?>
								</tbody>															
							</table>
						</div>
					<!-- Modal Start -->
					<div id="showModPar" class="modal fade" tabindex="-1" role="dialog">
					  <div class="modal-dialog modal-md" role="document">
					    <div class="modal-content" style="align-content: center;">
					      <div class="modal-header">
					        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
					        <h4 class="modal-title"><h3>DAFTAR PESERTA</h3></h4>
					      </div>
					      <div class="modal-body">
					      	<div class="row" id="modalContent" >
					      		<div class="col-md-12">
					      		<table style="width:100%; padding-left: 15%; align-items: center;" class="table table-striped table-hover">
					      			<thead>
					      				<td>No</td>
					      				<td>Nama</td>
					      			</thead>
					      			<tbody>
					      			</tbody>
								</table>
					      		</div>
					        </div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					  </div>
					</div>
					<!-- Modal End -->
