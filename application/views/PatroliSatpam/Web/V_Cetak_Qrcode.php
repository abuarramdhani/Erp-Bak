<div style="width: 100%; height: 100%; border:0px solid black; overflow: hidden;">
	<table style="height: 100%" width="100%" border="0">
		<tr>
			<td style="text-align: center;">
				<p style="margin: 0px; font-size: 22px; font-weight: bold;">Pos <?=$pos?></p>
				<p style="margin: 0px; font-size: 22px; font-weight: bold;"><?=$kode?></p>
			</td>
		</tr>
		<tr>
			<td style="height: 385px">
				<img width="100%" src="<?=base_url('PatroliSatpam/web/qrcode_patroli?kode='.rawurlencode($kode))?>">
			</td>
		</tr>
	</table>
</div>