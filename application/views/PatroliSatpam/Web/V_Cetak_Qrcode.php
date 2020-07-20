<div style="width: 100%; height: 100%; border:0px solid black; overflow: hidden;">
	<table style="height: 100%" width="100%" border="0">
		<tr>
			<td style="text-align: center;">
				<p style="margin: 0px; font-size: 34px; font-weight: bold;">POS <?=$pos?></p>
				<?php 
				if (strlen($kode) > 20) {
					$size = '22px';
				}elseif (strlen($kode) > 11 && strlen($kode) < 21) {
					$size = '26px';
				}
				else{
					$size = '34px';
				}
				?>
				<p style="margin: 0px; font-size: <?=$size?>; font-weight: bold; white-space: nowrap;"><?=$kode?></p>
			</td>
		</tr>
		<tr>
			<td style="height: 385px;">
				<img width="100%" src="<?=base_url('PatroliSatpam/web/qrcode_patroli?kode='.rawurlencode($kode))?>">
			</td>
		</tr>
	</table>
</div>