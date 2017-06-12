<div class="table-responsive" style="overflow:hidden;">
						<table class="table table-striped table-bordered table-hover text-left" id="tabel-retur-faktur" style="font-size:14px;">
							<thead class="bg-primary">
								<tr>
									<th>FM</th>
									<th><div style="width:120px;">KODE JENIS TRANS</div></th>
									<th><div style="width:100px;">FG PENGGANTI</div></th>
									<th><div style="width:120px">NOMOR FAKTUR</div></th>
									<th><div style="width:80px">MASA PAJAK</div></th>
									<th><div style="width:90px">TAHUN PAJAK</div></th>
									<th><div style="width:120px">TANGGAL FAKTUR</div></th>
									<th><div style="width:100px">NPWP</div></th>
									<th><div style="width:140px">NAMA</div></th>
									<th><div style="width:600px">ALAMAT LENGKAP</div></th>
									<th><div style="width:100px">JUMLAH DPP</div></th>
									<th><div style="width:100px">JUMLAH PPN</div></th>
									<th><div style="width:120px">JUMLAH PPNBM</div></th>
									<th><div style="width:100px;">IS CREDITABLE</div></th>
									<th><div style="width:90px;">KETERANGAN</div></th>
									<th><div style="width:100px;">STATUS FAKTUR</div></th>
									<th><div style="width:160px;">TIPE FAKTUR</div></th>
									<th><div style="width:160px;">KOMENTAR</div></th>
								</tr>
							</thead>
							<tbody>
								<?php
									if(!(empty($FilteredFaktur))){
										$no=0;
										foreach($FilteredFaktur as $FF) { $no++;
											$typ = substr($FF->FAKTUR_PAJAK, 0, 2);
											$alt = substr($FF->FAKTUR_PAJAK, 2, 1);
											$num = substr($FF->FAKTUR_PAJAK, 3);
								?>
								<tr>
									<td><?php echo $FF->FM?></td>
									<td><?php echo $typ?></td>
									<td><?php echo $alt?></td>
									<td><?php echo $num?></td>
									<td><?php echo $FF->MONTH?></td>
									<td><?php echo $FF->YEAR?></td>
									<td><?php echo $FF->FAKTUR_DATE?></td>
									<td><?php echo $FF->NPWP?></td>
									<td><?php echo $FF->NAME?></td>
									<td><?php echo $FF->ADDRESS?></td>
									<td><?php echo $FF->DPP?></td>
									<td><?php echo $FF->PPN?></td>
									<td><?php echo $FF->PPN_BM?></td>
									<td><?php echo $FF->IS_CREDITABLE_FLAG?></td>
									<td><?php echo $FF->DESCRIPTION?></td>
									<td><?php echo $FF->STATUS?></td>
									<td><?php echo $FF->FAKTUR_TYPE?></td>
									<td><?php echo $FF->COMMENTS?></td>
								</tr>
								<?php 
										}
									}
								?>
							</tbody>																			
						</table>
					</div>