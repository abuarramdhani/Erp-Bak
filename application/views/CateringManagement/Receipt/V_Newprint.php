<html>
<header>
	<link href="<?php echo base_url('assets/plugins/bootstrap/3.0.0/css/bootstrap.css')?>" rel="stylesheet" type="text/css" />
</header>

<body>
	<div style="margin-left:20px;padding-top:10px;">
		<h4>
			RECEIPT CATERING<br>
			<small style="font-size:10px;">CV.Karya Hidup Sentosa Jl. Magelang No. 144 Yogyakarta 55241</small>
		</h4>
	</div>
	<div style="border-style: double;border-width:1px;width:98%;margin:0 auto;"></div>
	<?php
		$this->load->helper('terbilang_helper');
		foreach ($Receipt as $rc) {
			$total = $rc['order_qty']*$rc['order_price'];
			$grand = $total-$rc['fine']-$rc['pph'];
	?>
	<div style="margin-left:10px;margin-top:10px;">
		<table style="font-size:12px;">
			<tr>
				<td height="15">No.</td>
				<td width="20" style="text-align:center;">:</td>
				<td><?php echo $rc['receipt_no'] ?></td>
			</tr>
			<tr>
				<td>Telah Diterima Dari</td>
				<td width="20" style="text-align:center;">:</td>
				<td><?php echo $rc['receipt_from'] ?></td>
			</tr>
			<tr>
				<td>Guna Pembayaran</td>
				<td width="20" style="text-align:center;">:</td>
				<td><?php echo $rc['type_description'].' '.$rc['catering_name'].' DARI TANGGAL '.$rc['order_start_date'].' - '.$rc['order_end_date'].' SEBANYAK '.$rc['order_qty'].' BOX/PCS @ Rp. '.number_format($rc['order_price'],0,",",".") ?></td>
			</tr>
			<tr>
				<td>Uang Sebanyak</td>
				<td width="20" style="text-align:center;">:</td>
				<td>Rp. <?php  echo number_format($grand,0,",",".")?></td>
			</tr>
			<tr>
				<td>Terbilang</td>
				<td width="20" style="text-align:center;">:</td>
				<td><?php echo ucwords(number_to_words($grand))." Rupiah" ?></td>
			</tr>
		</table>
	</div>
	<div class="row" style="width:100%;">
		<div class="col-md-12">
		<div style="margin-left:10px;margin-top:5px;border:1px solid black;width:27%;float:left;">
			<table style="font-size:10px;margin:3px auto;">
				<tr>
					<td height="15" colspan="3" style="border-bottom:1p solid black;"><b>Rincian Pembayaran</b></td>
				</tr>
				<tr>
					<td>Total Pesanan</td>
					<td width="20" style="text-align:center;">:</td>
					<td style="text-align:right;"><?php echo "Rp. ".number_format($total, 0 , ',' , '.' ) ?></td>
				</tr>
				<tr>
					<td>Total Denda</td>
					<td width="20" style="text-align:center;">:</td>
					<td style="text-align:right;"><?php echo "Rp. ".number_format($rc['fine'], 0 , ',' , '.' ) ?></td>
				</tr>
				<tr>
					<td>Pajak</td>
					<td width="20" style="text-align:center;">:</td>
					<td style="text-align:right;">Rp. <?php  echo number_format($rc['pph'], 0 , ',' , '.' )?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td width="20" style="text-align:center;">( - )</td>
					<td style="text-align:right;">-----------------------------</td>
				</tr>
				<tr>
					<td><b>Total Pembayaran</b></td>
					<td width="20" style="text-align:center;"><b>:</b></td>
					<td style="text-align:right;"><b><?php echo "Rp. ".number_format($grand, 0 , ',' , '.' ) ?></b></td>
				</tr>
			</table>
		</div>
		<div style="margin-left:10px;margin-top:5px;border:1px solid black;width:43%;float:left;">
			<table style="font-size:10px;margin:3px auto;">
				<tr>
					<td height="15" colspan="6" style="border-bottom:1p solid black;"><b>Rincian Denda</b></td>
				</tr>
				<tr>
					<td style="width:30px;text-align:center;">No.</td>
					<td style="width:70px;text-align:center;">Tanggal</td>
					<td style="width:40px;text-align:center;">Qty</td>
					<td style="width:30px;text-align:center;">(%)</td>
					<td style="width:80px;text-align:right;">Harga</td>
					<td style="width:80px;text-align:right;">Total</td>
				</tr>
				<?php $no=0; foreach($ReceiptFine as $rf){ $no++;?>
				<tr>
					<td style="text-align:center;"><?php echo $no; ?></td>
					<td style="text-align:center;"><?php echo $rf['receipt_fine_date'] ?></td>
					<td style="text-align:center;"><?php echo $rf['receipt_fine_qty'] ?></td>
					<td style="text-align:center;"><?php echo $rf['fine_type_percentage'] ?> %</td>
					<td style="text-align:right;"><?php echo number_format($rf['receipt_fine_price'], 0 , ',' , '.' ); ?></td>
					<td style="text-align:right;"><?php echo number_format($rf['fine_nominal'], 0 , ',' , '.' ); ?></td>
				</tr>
				<?php } ?>
			</table>
		</div>
		</div>
	</div>
	<div style="width:100%;">
		<div style="width:40%;float:left;"> 
			<table style="margin:3px auto;font-size:12px;">
				<tr>
					<td style="text-align:center;">&nbsp; </td>
				</tr>
				<tr>
					<td style="text-align:center;">Mengetahui, </td>
				</tr>
				<tr>
					<td style="text-align:center;height:30px;">&nbsp;</td>
				</tr>
				<tr>
					<td style="text-align:center;">( .......................................... )</td>
				</tr>
			</table>
		</div>
		<div style="width:40%;float:right;">
			<table style="margin:3px auto;font-size:12px;">
				<tr>
					<td><?php echo $rc['receipt_place'].', '.$rc['receipt_date'] ?></td>
				</tr>
				<tr>
					<td style="text-align:center;">Pekerja, </td>
				</tr>
				<tr>
					<td style="text-align:center;height:30px;">&nbsp;</td>
				</tr>
				<tr>
					<td style="text-align:center;"><?php echo "(       ".$rc['receipt_signer']."       )"; ?></td>
				</tr>
			</table>
		</div>
	</div>
	<?php } ?>
</body>
</html>