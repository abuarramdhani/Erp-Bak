		 <div style="border-left: 1px solid black;border-right: 1px solid black;background:white">
	 			<div style="padding:15.534px;">
	 				<div style="width:69.15%;float:left">
	 					<table style="width:100%;border-bottom: 1px solid black; font-size: 12px; border-collapse: collapse !important;page-break-inside:avoid;">
	 						<tr>
	 							<th style="padding: 3px;width: 5%;border-left:1px solid black;border-top:1px solid black;">NO</th>
	 							<th style="padding: 3px;width: 40%;border-left:1px solid black;border-top:1px solid black;">
	 								NOMOR FPB <br> (Form Pengiriman Barang)
	 							</th>
	 							<th style="padding: 3px;width: 55%;border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;">KETERANGAN</th>
	 						</tr>

	 						<?php for ($i=0; $i < 10; $i++) { ?>
	 							<tr>
	 								<td style="text-align: center;padding: 3px;border-left:1px solid black;border-top:1px solid black;"><?php echo $i+1 ?></td>
	 								<td style="text-align: center;padding: 3px;border-left:1px solid black;border-top:1px solid black;">
	 									<?php !empty($get['Item'][$i]['DOC_CUSTOM']) ? $z = $get['Item'][$i]['DOC_CUSTOM'] : $z = ''; echo $z; ?>
	 								</td>
	 								<td style="text-align: center;padding: 3px;border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;">
	 									<?php !empty($get['Item'][$i]['DOC_CUSTOM']) ? $z = $get['Item'][$i]['KETERANGAN'] : $z = ''; echo $z; ?>
	 								</td>
	 							</tr>
	 						<?php } ?>

	 					</table>
	 				</div>
	 				<div style="width:30%;margin-left:11px;float:left">
	 					<label><b>Pengiriman melalui :</b></label><br>
	 					<span><?php echo $get['Header'][0]['JENIS_KENDARAAN'] ?></span><br><br>
	 					<label><b>Nomor Polisi :</b></label><br>
	 					<span><?php echo $get['Header'][0]['PLAT_NUMBER'] ?></span> <br><br>
	 					<label><b>Tanggal :</b></label><br>
	 					<span><?php echo date('d-M-Y H:i:s',strtotime($get['Header'][0]['PRINT_DATE'])) ?></span>
	 				</div>
	 			</div>
	 		</div>