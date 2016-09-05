
<div style="border: 2px solid #b7a96c; height: 100%;background: url('<?php echo base_url()?>assets/img/rb.png');background-size: 100% 100%;
    background-repeat: no-repeat;">
<?php foreach ($Receipt as $rc) {?>
							
								<table style="font-size:14px;margin: 20 30px">
										<?php
											$total = $rc['order_qty']*$rc['order_price'];
											$grand = $total-$rc['fine']-$rc['pph'];
										?>
									<tr>
										<td style="border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000" colspan="2"></td>
										<td>&nbsp;</td>
										<td style="border-top: 1px solid #000;border-left: 1px solid #000" width="21%">&nbsp;NO.</td>
										<td style="border-top: 1px solid #000;" width="2%">:</td>
										<td style="border-top: 1px solid #000;border-right: 1px solid #000" colspan="2"><?php echo $rc['receipt_no'] ?></td>
									</tr>
									<tr>
										<td style="font-size:9px;border-left: 1px solid #000" width="10%" rowspan="2" align="right">
										<b>RICIAN :<br></b>
										CALCULATION :<br>
										(-) FINE :<br>
										(-) PPH :<br>
										TOTAL :<br>
										</td>
										<td style="font-size:9px;border-right: 1px solid #000" width="9%" rowspan="2" align="right">
										<?php echo '<br>'.number_format($total, 0 , ',' , '.' ).'&nbsp;<br>'.number_format($rc['fine'], 0 , ',' , '.' ).'&nbsp;<br>'.number_format($rc['pph'], 0 , ',' , '.' ).'&nbsp;<br>'.number_format($grand, 0 , ',' , '.' ).'&nbsp;' ?>
										</td>
										<td>&nbsp;</td>
										<td style="border-left: 1px solid #000">&nbsp;TELAH DITERIMA DARI</td>
										<td >:</td>
										<td style="border-right: 1px solid #000" colspan="2"><?php echo $rc['receipt_from'] ?></td>
									</tr>
									<tr>
										<td >&nbsp;</td>
										<td style="border-left: 1px solid #000">&nbsp;UANG SEBANYAK</td>
										<td >:</td>
										<td style="border-right: 1px solid #000" colspan="2">Rp <?php echo number_format($rc['payment'], 2 , ',' , '.' ) ?></td>
									</tr>
									<tr>
										<td style="font-size:10px;border-left: 1px solid #000;border-right: 1px solid #000" colspan="2"></td>
										<td>&nbsp;</td>
										<td style="border-left: 1px solid #000">&nbsp;GUNA MEMBAYAR</td>
										<td >:</td>
										<td style="border-right: 1px solid #000" colspan="2"><?php echo $rc['type_description'].' '.$rc['catering_name'].' DARI TANGGAL '.$rc['order_start_date'].' - '.$rc['order_end_date'].' SEBANYAK '.$rc['order_qty'].' BOX @Rp '.$rc['order_price']  ?></td>
									</tr>
									<tr>
										<td style="border-left: 1px solid #000;border-right: 1px solid #000" align="center" colspan="2"></td>
										<td>&nbsp;</td>
										<td style="border-left: 1px solid #000;border-right: 1px solid #000" colspan="4"></td>
									</tr>
									<tr>
										<td style="border-left: 1px solid #000;border-right: 1px solid #000" align="center" colspan="2"><?php echo $rc['short_receipt_date'] ?></td>
										<td>&nbsp;</td>
										<td style="border-left: 1px solid #000"></td>
										<td></td>
										<td width="23%"></td>
										<td align="center" style="border-right: 1px solid #000" width="35%"><?php echo $rc['receipt_place'].', '.$rc['receipt_date'] ?></td>
									</tr>
									<tr>
										<td style="border-left: 1px solid #000;border-right: 1px solid #000" align="center" colspan="2"></td>
										<td>&nbsp;</td>
										<td style="border-left: 1px solid #000" height="30px"></td>
										<td></td>
										<td></td>
										<td align="center" style="vertical-align:top;border-right: 1px solid #000">MENGETAHUI</td>
									</tr>
									<tr>
										<td height="80px" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000" align="center" colspan="2"><?php echo $rc['receipt_signer'] ?></td>
										<td>&nbsp;</td>
										<td colspan="3" style="border-left: 1px solid #000;border-bottom: 1px solid #000;"></td>
										<td align="center" style="border-bottom: 1px solid #000;border-right: 1px solid #000">(..................................)</td>
									</tr>
								</table>
							
						<?php }?>
</div>
