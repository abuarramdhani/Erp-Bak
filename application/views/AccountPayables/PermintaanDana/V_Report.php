<div class="box-body">
	<fieldset class="row2" style="font-size: 11px;">
		<div class="box-body">
			<div class="row">
				<div class="col-lg-12">
					<h4 class="text-center"><strong>PERMINTAAN DANA KASIR</strong></h4>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-lg-12">
					<table style="font-size: 11px;" width="100%">
						<tr>
							<td width="10%">Kepada</td>
							<td width="2%">&nbsp;:&nbsp;</td>
							<td width="20%">Keuangan</td>
							<td width="20%"></td>
							<td width="47%" class="text-right">Tanggal Dibutuhkan: <?= date("d M Y", strtotime($DemandHeader['NEED_BY_DATE'])) ?></td>
							<td width="1%"></td>
						</tr>
						<tr>
							<td>Dari</td>
							<td>&nbsp;:&nbsp;</td>
							<td>Kasir</td>
						</tr>
					</table>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-lg-12">
					<table style="font-size: 11px;" width="100%">
						<tr>
							<td width="50%">Plafon Operasional (2 Hari)</td>
							<td width="3%">Rp </td>
							<td width="15%" class="text-right"><?= number_format($DemandHeader['CASH_LIMIT'],0,",",".") ?></td>
							<td width="5%"></td>
							<td width="3%"></td>
							<td width="15%"></td>
							<td width="5%"></td>
						</tr>
						<tr>
							<td>Saldo Kas <?= $BalanceDate ?></td>
							<td style="border-bottom: 1px solid #000">Rp </td>
							<td style="border-bottom: 1px solid #000" class="text-right"><?= number_format($DemandHeader['CASH_AMOUNT'],0,",",".") ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><?= ($type <= 0 ? 'Kelebihan' : 'Kekurangan') ?> Dana</td>
							<td></td>
							<td></td>
							<td></td>
							<td>Rp </td>
							<td class="text-right"><?= number_format($LackAmount,0,",",".") ?></td>
							<td></td>
						</tr>
					</table>
				</div>
			</div>
			<br />
			<b>RENCANA PENGELUARAN TAMBAHAN</b>
			<div class="row">
				<div class="col-lg-12">
					<table style="font-size: 11px;" id="tblDemandForFunds" width="100%">
						<tbody>
							<tr>
								<td width="3%"></td>
								<td width="47%"><b>Rencana Pengeluaran</b></td>
								<td width="50%" colspan="6"><b>Estimasi Biaya</b></td>
							</tr>
							<?php $no = 1; foreach ($DemandLine as $value): ?>
							<tr>
								<td><?php echo $no; $no++; ?></td>
								<td><?php echo $value['DESCRIPTION']; ?></td>
								<td width="3%">Rp </td>
								<td width="15%" class="text-right"><?php echo number_format($value['AMOUNT'],0,",","."); ?></td>
								<td width="5%"></td>
								<td width="3%"></td>
								<td width="15%"></td>
								<td width="5%"></td>
							</tr>
							<?php endforeach; ?>
							<br />
							<tr>
								<td width="3%"></td>
								<td width="47%"><b>TOTAL RENCANA PENGELUARAN</b></td>
								<td style="border-top: 1px solid #000"></td>
								<td style="border-top: 1px solid #000"></td>
								<td></td>
								<td style="border-bottom: 1px solid #000">Rp </td>
								<td style="border-bottom: 1px solid #000" class="text-right">
								<?php 
									$total = 0;
									foreach ($DemandLine as $value){
										$total += $value['AMOUNT'];
									}
									echo number_format($total,0,",",".");
								?>
								</td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-lg-12">
					<table style="font-size: 11px;" width="100%">
						<tr>
							<td width="73%"><b>Jumlah Dana Yang Diminta</b></td>
							<td width="3%">Rp </td>
							<td width="15%" class="text-right"><b>
							<?php 
								$total = 0;
								foreach ($DemandLine as $value){
									$total += $value['AMOUNT'];
								}
								if($type <= 0) {
									if($total > $LackAmount) {
										echo number_format((($DemandHeader['CASH_LIMIT']-$DemandHeader['CASH_AMOUNT'])+$total),0,",",".");
									} else {
										echo number_format(0,0,",",".");
									}
								} else {
									echo number_format((($DemandHeader['CASH_LIMIT']-$DemandHeader['CASH_AMOUNT'])+$total),0,",",".");
								}
							?>
							</b></td>
							<td width="5%"></td>
						</tr>
						<tr>
							<td><b>Pembulatan</b></td>
							<td>Rp </td>
							<td class="text-right"><b>
							<?php
								$total = 0;
								foreach ($DemandLine as $value){
									$total += $value['AMOUNT'];
								}
								$endTotal = ($DemandHeader['CASH_LIMIT']-$DemandHeader['CASH_AMOUNT'])+$total;
								$endTotal = round($endTotal, 0);
								$millionVal = substr($endTotal, -7);
								if($millionVal == 5000000) {
									$finalTotal = $endTotal;
								} elseif($millionVal > 5000000) {
									$finalTotal = $endTotal+(10000000-$millionVal);
								} elseif ($millionVal < 5000000) {
									$finalTotal = $endTotal-$millionVal;
								}
								if($TotalDemand != 0) {
									echo number_format($finalTotal,0,",",".");
								} else {
									echo number_format(0,0,",",".");
								}
							?>
							</b></td>
							<td></td>
						</tr>
					</table>
				</div>
			</div>
			<br />
			<br />
			<br />
			<div class="row">
				<div class="col-lg-12">
					<table style="font-size: 11px;" width="100%">
						<tr>
							<td style="padding-bottom: 30px; text-align: center;" width="30%"><?php echo date('d M Y'); ?></td>
							<td style="padding-bottom: 30px; text-align: center;" width="40%">Mengetahui</td>
							<td style="padding-bottom: 30px; text-align: center;" width="30%">Menyetujui</td>
						</tr>
						<tr>
							<td style="text-align: center;" width="30%">Yuning</td>
							<td style="text-align: center;" width="40%">Maya Kristiana</td>
							<td style="text-align: center;" width="30%">Novita Sari</td>
						</tr>
						<tr>
							<td style="text-align: center;" width="30%">Kasir</td>
							<td style="text-align: center;" width="40%">Keuangan</td>
							<td style="text-align: center;" width="30%">Akuntansi</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</fieldset>
</div>