<?php
for($i = 0; $i < count($worker); $i++): 
	if($i != 0) echo "<pagebreak />";
	?>
<table width="100%" border="0">
	<tr>
		<td style="width: 50%"></td>
		<td style="width: 50%">
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			<p style= "text-align:justify; font-size: 16px">
				Kepada :<br>
					<strong>Yth. Sdr. <?php echo ucwords(strtolower($worker[$i][0]['nama']));?></strong><br>
				<strong>No Induk : <?php echo $worker[$i][0]['no_induk'];?></strong>
				<br>

				<?php $arr = array('ICT','EDP','PE – DOJO','PIEA','SHE','MAINTENANCE & PA – TKS','CETAKAN – TKS','GD. MATERIAL & BP','GD. PENGADAAN & BLANK MTRL','GD. PROD. & EKSP','GD. PROD. & EKSP – TKS','MAINTENANCE & PA','MAINTENANCE & PA – TKS','PMS JOB ORDER','PMS SPARE PART AP','PMS SPARE PART BDL','PMS SPARE PART ENGINE','SPC CUSTOMER QC'); ?>
				<?php if (in_array(trim($worker[$i][0]['seksi']), $arr)) { ?>
			        <strong>Seksi <?php echo ($worker[$i][0]['seksi']);?></strong>
			        <?php  }else { ?>
			        <strong>Seksi <?php echo ucwords(strtolower($worker[$i][0]['seksi']));?></strong>
			        <?php } ?>
			       <!-- //gimana ya enggal? ifnya , jadi syntaxnya yang benar gmana ya?  aku salah , kenapa nggak jadi ICT ya ?-->
			   
			      <!--<strong>Seksi <?php echo ucwords(strtolower($worker[$i][0]['seksi']));?></strong>-->
				<br>
				<strong>di tempat</strong>
			</p>
		</td>
	</tr>
</table>

<?php endfor; ?>

