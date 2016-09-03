<?php foreach ($Receipt as $rc) {?>
							<div class="col-md-12">
								<table style="font-size:14px" class="table table-bordered text-left" id="dataTables-customer">
										<?php
											$total = $rc['order_qty']*$rc['order_price'];
											$grand = $total-$rc['fine']-$rc['pph'];
										?>
									<tr>
										<td width="19%"></td>
										<td width="15%">No.</td>
										<td width="2%">:</td>
										<td colspan="2"><?php echo $rc['receipt_no'] ?></td>
									</tr>
									<tr>
										<td style="font-size:9px;">
										rincian : (total-denda-pph)<br>
										<?php echo number_format($total, 0 , ',' , '.' ).' - '.number_format($rc['fine'], 0 , ',' , '.' ).' - '.number_format($rc['pph'], 0 , ',' , '.' ).' = Rp '.number_format($grand, 0 , ',' , '.' ) ?>
										</td>
										<td >TELAH DITERIMA DARI</td>
										<td >:</td>
										<td colspan="2"><?php echo $rc['receipt_from'] ?></td>
									</tr>
									<tr>
										<td style="font-size:9px;">
										bayar : Rp <?php echo number_format($rc['payment'], 0 , ',' , '.' ) ?>
										</td>
										<td >UANG SEBANYAK</td>
										<td >:</td>
										<td colspan="2">Rp <?php echo number_format($rc['payment'], 2 , ',' , '.' ) ?></td>
									</tr>
									<tr>
										<td style="font-size:10px;"></td>
										<td >GUNA MEMBAYAR</td>
										<td >:</td>
										<td colspan="2"><?php echo $rc['order_description'].' DARI TANGGAL '.$rc['order_start_date'].' - '.$rc['order_end_date'].' SEBANYAK '.$rc['order_qty'].' BOX @Rp '.$rc['order_price']  ?></td>
									</tr>
									<tr>
										<td align="center"><?php echo $rc['short_receipt_date'] ?></td>
										<td></td>
										<td></td>
										<td width="32%"></td>
										<td width="32%"><?php echo $rc['receipt_place'].', '.$rc['receipt_date'] ?></td>
									</tr>
									<tr>
										<td align="center"></td>
										<td></td>
										<td></td>
										<td></td>
										<td>MENGETAHUI</td>
									</tr>
									<tr>
										<td align="center"><?php echo $rc['receipt_signer'] ?></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</table>
							</div>
						<?php }?>