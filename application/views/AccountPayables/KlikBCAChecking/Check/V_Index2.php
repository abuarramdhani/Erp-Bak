									<div class=" col-lg-12 table-responsive">
										<table class="table table-striped table-bordered table-hover text-left" id="tblrecordbca" style="font-size: 14px; table-layout: fixed; width: 1600px; margin-left: 0px;">
											<thead class="bg-primary">
												<tr>
													<th width="8%">Tanggal Upload</th>
													<th width="8%">No Referensi</th>
													<th width="10%">No Rekening Pengirim</th>
													<th width="16%">Nama Pengirim</th>
													<th width="10%">No Rekening Penerima</th>
													<th width="16%">Nama Penerima</th>
													<th width="10%">Jumlah</th>
													<th width="14%">Jenis Transfer</th>
													<th width="8%">Oracle checking</th>
												</tr>
											</thead>
											<tbody>
											<?php foreach($bca as $bca_data){?>
												<tr>
													<td><?php echo $bca_data['tanggal']?></td>
													<td><?php echo $bca_data['no_referensi']?></td>
													<td><?php echo $bca_data['no_rek_pengirim']?></td>
													<td><?php echo $bca_data['nama_pengirim']?></td>
													<td><?php echo $bca_data['no_rek_penerima']?></td>
													<td><?php echo $bca_data['nama_penerima']?></td>
													<td align="right" >Rp <?php echo $bca_data['jumlah']?></td>
													<td><?php echo $bca_data['jenis_transfer']?></td>
													<td><?php echo $bca_data['checking_status']?></td>
												</tr>
											<?php }?>
											</tbody>
										</table>
									</div>