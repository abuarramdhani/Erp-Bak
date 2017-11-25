						<div class="table-responsive" style="overflow:hidden;">
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
									<tr>
										<td width="5%" align="center"></td>
										<td ></td>
										<td align="center"></td>
										<td width="7%" style="text-align:center;">
											<a href="javascript:void(0)" class="btn btn-flat btn-sm btn-warning" name="showModPar" onclick="">
												<i class="fa fa-search"></i>
											</a><!-- 
											<button class="btn btn-flat btn-sm btn-warning" data-toggle="tooltip" title="View" onclick="ShowModalPartcpnt('<?php echo $rc['section_name']."','".$rc['tahun']; ?>')"><i class="fa fa-search"></i></</button> -->
										</td>
										<td></td>
										<td style="text-align:center;"></td>
									</tr>
								</tbody>															
							</table>
						</div>
					<!-- Modal Start -->
					<div id="showModPar" class="modal fade" tabindex="-1" role="dialog">
					  <div class="modal-dialog modal-md" role="document">
					    <div class="modal-content" style="align-content: center;">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
