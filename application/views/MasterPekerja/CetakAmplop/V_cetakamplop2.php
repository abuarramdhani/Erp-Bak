<?php
for($i = 0; $i < count($nama); $i++): 
	if($i != 0) echo "<pagebreak />";
?>
<div style="width: 100%; height: 50%;">
	<div style="font-weight: bold; border: 2px solid black; width: <?=$wid?>px; padding: 5px;">
		Kepada : <br>
		Yth. Sdr. <?= $nama[$i] ?>
		<br>
		<?= $alamat[$i] ?>
	</div>
</div>
<sethtmlpagefooter page="ALL">
	<div style="font-weight: bold; border: 2px solid black; width: <?=$wid-50?>px; position: fixed; right: 0mm; bottom: 0mm; padding: 5px;">
		Dari : <br>
		<?= $pengirim ?>
		<br>
		CV. Karya Hidup Sentosa<br>Jl. Magelang No. 144<br>Yogyakarta
	</div>
</sethtmlpagefooter>
<?php endfor; ?>
