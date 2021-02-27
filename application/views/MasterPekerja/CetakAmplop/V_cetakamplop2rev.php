<?php
for($i = 0; $i < count($nama); $i++): 
	if($i != 0) echo "<pagebreak />";
?>
<div style="width: 100%; text-align: center; font-weight: bold; border:0px solid black;">
	<div style="text-align: left; border: 1px solid black;  width:<?= $wid2 ?>%;margin:0 auto; padding: 10px;">
		Kepada : <br>
		Yth. Sdr. <?= $nama[$i] ?>
		<br>
		<?= $alamat[$i] ?>
	</div>
	<?php if ($format == 'C4'): ?>
		<br>
	<?php endif ?>
	<div style="text-align: left; border: 1px solid black; width:60%; margin:0 auto; padding: 10px; margin-top: 10px;">
		Dari : <br>
		<?= $pengirim ?>
		<br>
		CV. Karya Hidup Sentosa Jl. Magelang No. 144 Yogyakarta
	</div>
</div>
<?php endfor; ?>
