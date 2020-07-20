<html>
<head>
</head>
<body>
<?php
		set_time_limit(0);
		ini_set("memory_limit", "2048M");

	?>
<div style="width: 100%;padding-right: 30px;">
	<table style="width:100%;font-size: 18px;text-align: center;padding-left: 20px;">
	
		<tr>
			<td style="width: 1%" rowspan="2">
				<img style="height: 110px;" src="<?php echo base_url('/assets/img/logo.png') ?>" />
			</td>
			<td style="width: 80%;text-align: center;">DAFTAR HADIR PESERTA</td>
			<td style="width: 1%" rowspan="2">
				<img style="height: 110px;" src="<?php echo base_url('/assets/img/admpelatihan_daftarhadir_tr.png') ?>" />
			</td>
		</tr>
		<tr>
			<td style="text-align: center;"><?php echo $Pelatihan['0']['scheduling_name']?></td>
		</tr>

		
	</table>
	<hr style="height: 5px;" />

<table style="width: 40%">
<tbody>
<tr>
	<td>Tanggal</td>
	<td>:</td>
	<td><?php echo ucwords($Pelatihan['0']['date'])?></td>
</tr>
<tr>
	<td>Waktu</td>
	<td>:</td>
	<td> <?php echo $Pelatihan['0']['start_time']?> WIB - <?php echo $Pelatihan['0']['end_time']?> WIB</td>
</tr>
<tr>
	<td>Ruang</td>
	<td>:</td>
	<td><?php echo $Pelatihan['0']['room']?> </td>
</tr>
</tbody>
</table>


<table  style="margin-left: 5px;font-size: 12px;margin-top: 10px;border-collapse: collapse;width: 100%;border: 1px solid black;">
	<thead>
		<tr>
			<th style="border-bottom: 1px solid black;border-right: 1px solid black;height:30px; background-color: yellow; " ><center>NO</center></th>
			<th style="border-bottom: 1px solid black;border-right: 1px solid black;height:30px; background-color: yellow; " ><center>NO INDUK</center></th>
			<th style="border-bottom: 1px solid black;border-right: 1px solid black;height:30px; background-color: yellow; " ><center>NAMA</center></th>
			<th style="border-bottom: 1px solid black;border-right: 1px solid black;height:30px; background-color: yellow; " ><center>SEKSI/UNIT</center></th>
			<th style="border-bottom: 1px solid black;height:30px; background-color: yellow; " ><center>PARAF</center></th>	
        </tr>
        
	</thead>
	<tbody>
		<?php 
		if (isset($peserta) && !empty($peserta)) { // jika ada peserta 
			$nomor = 1;
			foreach ($peserta as $value) {
				?>
				<tr>
				    <tr>
				    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;width: 5%;padding-left: 1px; height: 30px "; ><?php echo $nomor; ?><center></center></td>
					<td style=" border-bottom: 1px solid black;border-right: 1px solid black;width: 10%;padding-left: 5px; "  > <?php echo $value['noind']?><center></center></td>
					<td style="border-bottom: 1px solid black;border-right: 1px solid black;width: 35%;padding-left: 5px; "><?php echo $value['employee_name']?></td>
					<td style="border-bottom: 1px solid black;border-right: 1px solid black;width: 35%;padding-left: 5px; "><?php echo $value['seksi']?></td>
					<?php 
				 if ($nomor%2 != 0) {
						?>
						<td style="border-bottom: 1px solid black;width: 20%;padding-left: 5px ;"><sup style="font-size: 8pt"><?php echo $nomor; ?></sup></td>
						<?php 
					}
				?> 
				<?php 
				 if ($nomor%2 == 0) {
						?>
						<td style=" border-bottom: 1px solid black;width: 20%;padding-left: 5px ;"><sup style="font-size: 8pt"><?php echo $nomor; ?></sup><center></center></td>
						<?php 
					}
				?> 

				</tr>
				<?php
				$nomor++;
			}
			//$nomor--;
			if($nomor < 25){

				for ($i= $nomor; $i <= 25; $i++) { 
					?>
					<tr>

						<td style="border-bottom: 1px solid black;border-right: 1px solid black; width: 5%;padding-left: 1px; height: 30px " ><?php echo $nomor; ?><center></center></td>
						<td style=" border-bottom: 1px solid black;border-right: 1px solid black;width: 10%;padding-left: 1px; "  ></td>
						<td style="border-bottom: 1px solid black;border-right: 1px solid black;width: 35%;padding-left: 5px; "></td>
						<td style="border-bottom: 1px solid black;border-right: 1px solid black;width: 35%;padding-left: 5px; "></td>
                        <?php 
				       if ($nomor%2 != 0) {
						?>
						<td style="border-bottom: 1px solid black;width: 20%;padding-left: 5px ;"><sup style="font-size: 8pt"><?php echo $nomor; ?></sup></td>
						<?php 
					     }
				        ?> 
				      <?php 
				        if ($nomor%2 == 0) {
						?>
						<td style="width: 20%;border-bottom: 1px solid black;padding-left: 5px ;"><sup style="font-size: 8pt"><?php echo $nomor; ?></sup><center></center></td>
						<?php 
					     }
				       ?> 
					</tr>
					<?php
					$nomor++;
				}
			}

		}else{ 
		// jika tidak ada peserta
			$nomor = 1;
			for ($i=0 ; $i <= 25; $i++) { 
				?>
				<tr>
					<td style=" border-bottom: 1px solid black;border-right: 1px solid black;width: 5%;padding-left: 1px; height: 30px " ><?php echo $nomor; ?><center></center></td>
						<td style="border-bottom: 1px solid black;border-right: 1px solid black;width: 10%;padding-left: 1px; "  ></td>
						<td style="border-bottom: 1px solid black;border-right: 1px solid black;width: 35%;padding-left: 5px; "></td>
						<td style="border-bottom: 1px solid black;border-right: 1px solid black;width: 35%;padding-left: 5px; "></td>
                        
						
						<td style="border-bottom: 1px solid black;width: 20%;padding-left: 5px ;"><sup style="font-size: 8pt"><?php echo $nomor; ?></sup><center></center></td>
				</tr>
				<?php
				$nomor++;
			}
		}
		?>
	</tbody>
	<tfoot>
		<tr>
		 <td colspan="4" style="background-color: yellow;height: 30px;border-right: 1px solid black ;"><center>TOTAL</center></td>
		 <td  style="background-color: yellow;"><td>
		</tr>
	</tfoot>
</table>

<br>
<br>
<br>
<br>
<div>
	<div style="float: left;width: 50%;">
		<img style="width: 80%" src="<?php echo base_url('/assets/img/admpelatihan_daftarhadir_ttd.png') ?>" />
	</div>
	<div style="float: left;width: 50%">
		<table style="width:100%;font-size: 12px;text-align: padding-left: 1px;">
			<thead>
				<tr>
					<th style=" border: 1px  solid black;width: 30%;padding-left: 5px;background-color: yellow; height: 30px" ><center>TRAINER</center></th>
					<th style=" border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;background-color: yellow;width: 30%;padding-left: 5px; height: 10px" ><center>PARAF</center></th>
				</tr>
			</thead>
			<tbody>
				<tr>
				<?php 
					if (isset($Pelatihan) && !empty($Pelatihan)) {
						foreach ($Pelatihan as $value) {
							?>
							<td style=" border-left: 1px solid black ;border-bottom: 1px solid black;width: 30%;padding-left: 1px; height: 30px" ><?php echo $value['trainer_name']?><center> </center></td>
			                <td style="border-left: 1px solid black ;border-bottom: 1px solid black;border-right: 1px solid black;width: 25%;padding-left: 1px; "  ></td>
							<?php
						}
					}
					?>
		        </tr>
			</tbody>
		</table>
	</div>
</div>
</div>
</body>
</html>
