<style type="text/css">
	.withborder td{
		border: 1px solid black;
		border-collapse: collapse;
	}
	.withborder_nobot td{
		border: 1px solid black;
		border-collapse: collapse;
		border-bottom: none;
	}
	.withborder_nobotup td{
		border: 1px solid black;
		border-collapse: collapse;
		border-bottom: none;
		border-top: none;
	}
	.withborder_noup td{
		border: 1px solid black;
		border-collapse: collapse;
		border-top: none;
	}
	.txtcenter td{
		text-align: center;
	}
	.asheader td{
		padding-top: 5px;
		padding-bottom: 5px;
	}
	.asconten td{
		padding-top: 2px;
		padding-bottom: 2px;
	}
</style>
<?php 
	$checkT = "<p style='font-size: 15px;font-family:helvetica; color: green'>&#10004;</p>";
	$checkF = '<p style="color: red; font-weight: bold;">X</p>';
?>
<div style="width: 100%; height: 100%; border: 0px solid black;" >
	<?php for ($i=1; $i <= $max; $i++) {?>
	<table style="margin-top: 30px; height: 100%">
		<tr>
			<?php 
				for ($j=0; $j < 2; $j++) { 
				$no_pos = (strlen($i) == 1) ? '0'.$i:$i; 
			?>
			<td style="width: 376px;">
				<table border="0" cellspacing="0" cellpadding="0" style="<?=($j==0) ? 'padding-right':'padding-left'; ?>: 15px; height: 100%">
					<tr>
						<td style="width: 50px;">
							<img style="width: 50px;" src="<?=base_url('assets/img/logo.png')?>">
						</td>
						<td colspan="4" style="text-align: center;">
							CHECKLIST MONITORING PATROLI SATPAM<br/>
							POS AMANO NO. <?= $no_pos.'/'.$max ?><br>CV KARYA HIDUP SENTOSA</td>
						<td style="width: 50px;">
							<img style="width: 50px;" src="<?=base_url('assets/img/HSE_LOGO.png')?>">
						</td>
					</tr>
					<tr>
						<td colspan="6">Tanggal : <?= date('d-m-Y', strtotime($tanggal)) ?></td>
					</tr>
					<tr>
						<td colspan="6">
							<table width="100%" border="1" style="border-collapse: collapse;">
								<tr>
									<td style="width: 10px; text-align: center;">No</td>
									<td style="text-align: center;">Indikator</td>
									<td style="width: 25px;text-align: center;">I</td>
									<td style="width: 25px;text-align: center;">II</td>
									<td style="width: 25px;text-align: center;">III</td>
									<td style="width: 25px;text-align: center;">IIII</td>
								</tr>
								<?php 
									$no = 1;
								if (isset($jawaban[$i]) && !empty($jawaban[$i])) {
									$ask = explode(',', $jawaban[$i]['pertanyaan']);
									$jask = count($ask);
									foreach ($ask as $p) {
										?>
										<tr class="withborder txtcenter asconten">
										<td><?=$no?></td>
											<td style="text-align: justify; height: 50px;">
												<?=$pertanyaan[$p]?>
											</td>
											<?php for ($s=1; $s <=4 ; $s++) { ?>
											<td>
												<?php if (isset($jawaban[$i]['jawaban'.$s]) && !empty($jawaban[$i]['jawaban'.$s])): ?>
													<?= ($jawaban[$i]['jawaban'.$s][$no-1] == 1) ? $checkT:$checkF ?>
												<?php endif ?>
											</td>
											<?php } ?>
										</tr>
										<?php 						
										$no++; }
									}
									?>
							</table>
						</td>
					</tr>
					<tr class="withborder" >
						<td colspan="6" style="text-align: justify; height: 50px;">
							<p>
								jika keadaan lingkungan baik, maka jawablah dengan tanda "<i style='font-size: 15px;font-family:helvetica; color: green'>&#10004;</i>" sedangkan jika mendapatkan hal yang menyimpang maka jawablah dengan tanda "<i style="color: red; font-weight: bold;">X</i>", dan tulis penjelasannya pada kolom dibawah ini : 
							</p>
						</td>
					</tr>
					<tr class="withborder_nobotup withborder_noup">
						<td style="height: <?= 50*(7-$no)+600?>px;" colspan="6" valign="top">
							<?php 
								if (isset($temuan[$i]) && !empty($temuan[$i])) {
									$n = 0;
									foreach ($temuan[$i] as $key) {
										echo "<p>Ronde ".$key['ronde'].' : '.$key['deskripsi']."</p>";
										echo "\r\n<p></p>";
										if (!empty($key['attach'])) {
											$ar = explode('|', $key['attach']);
											foreach ($ar as $a) {
												$base = base_url("assets/upload/PatroliSatpam/".$a);
												echo '<img src="'.$base.'"  style="height: 100px; max-width: 150px; margin:5px;">';
											}
										}
										if ($n < count($temuan[$i])-1) {
											echo "<hr>";
										}
										$n++;
									}
								}
							?>
						</td>
					</tr>
				</table>
			</td>
			<?php
				if($j == 0) 
				$i++; 
			} 
			?>
		</tr>
	</table>
	<?php } ?>
</div>