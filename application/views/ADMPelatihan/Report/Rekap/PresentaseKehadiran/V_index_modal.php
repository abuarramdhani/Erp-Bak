					<!-- Modal Start -->
						<div id="showModParHadir" class="modal fade" tabindex="-1" role="dialog">
						  <div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content" style="align-content: center;">
						      <div class="modal-header">
						        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
						        <h4 class="modal-title"><h3>DAFTAR PESERTA</h3></h4>
						      </div>
						      <div class="modal-body">
						      	<div class="row" id="modalContent" >
						      		<div class="col-lg-12">
						      		<table style="width:100%; padding-left: 15%; align-items: center;" class="table table-bordered table-striped table-hover">
						      			<thead>
						      				<td style="width: 5%">No</td>
						      				<td style="width: 30%">Nama</td>
						      				<td>Seksi</td>
						      				<td style="width: 15%">Kehadiran</td>
						      				<td style="width: 20%">Alasan</td>
						      			</thead>
						      			<tbody>
						      				<?php $no=0; foreach ($modal_part as $participant => $p) {
						      					$no++; ?>
						      					<tr>
						      						<td><?php echo $no; ?></td>
						      						<td><?php echo $p['partisipan']; ?></td>
						      						<td><?php echo $p['section_name']; ?></td>
						      						<td>
						      							<?php 
						      								if ($p['status']==1) {echo " Hadir";}
						      								if ($p['status']==0) {echo " <i>Belum Input Kehadiran</i>";}
						      								if ($p['status']==2) {echo " Tidak Hadir";}
						      							?>
													</td>
						      						<td>
						      							<?php 
						      								if ($p['ket']==NULL) {echo " - ";}
						      								else { echo $p['ket'];}
						      							?>
						      						</td>
						      					</tr>
						      				<?php } ?>
						      			</tbody>
									</table>
						      		</div>
						        </div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
						      </div>
						    </div>
						  </div>
						</div>
					<!-- Modal End -->