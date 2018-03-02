<div style="width:100%;/*border:1px*/ solid #333">
<!--table header-->
	<div style="padding-bottom:20px">
		<table border="1" style="border-collapse:collapse;width:100%" <!-- class="table table-bordered" -->>
			<tr>
				<td width="5%">
					<img src="<?php echo base_url("assets/img/logo.png") ?>" style="width:50px">
				</td>
				<td width="30%" style="font-size:24px;padding-left:5px">
					CV. KARYA HIDUP SENTOSA<br>
					<p style="font-size:12px">Jl. Magelang no.144, Yogyakarta</p>
				</td>
				<td width="65%" style="text-align: center; ">
					<h1>DATABASE ORDER PIEA</h1>
				</td>
			</tr>
		</table>
	</div>
<!--table content-->
	<div>
		<table border="1" style="border-collapse:collapse;width:100%" <!-- class="table table-striped" -->>
			<tr>
				<td style="text-align: center;height:20px;padding:5px;font-weight:bold">NO</td>
				<td style="text-align: center;height:20px;padding:5px;font-weight:bold">TANGGAL</td>
				<td style="text-align: center;height:20px;padding:5px;font-weight:bold">SEKSI</td>
				<td style="text-align: center;height:20px;padding:5px;font-weight:bold">NAMA</td>
				<td style="text-align: center;height:20px;padding:5px;font-weight:bold">ORDER</td>
				<td style="text-align: center;height:20px;padding:5px;font-weight:bold">JENIS ORDER</td>
				<td style="text-align: center;height:20px;padding:5px;font-weight:bold">KETERANGAN</td>
			</tr>
			<?php $no=1; foreach ($report as $cl) {?>
				 <tr>
						<td style="text-align:center;height:25px"><?php echo $no ?></td>
						<td style="text-align:center"><?php echo $cl['tanggal']?></td>
						<td style="text-align:center"><?php echo $cl['seksi']?></td>
						<td style="text-align:center"><?php echo $cl['nama']?></td>
						<td style="text-align:center"><?php echo $cl['order_']?></td>
						<td style="text-align:center"><?php echo $cl['jenis_order']?></td>
						<td style="text-align:left"><?php echo $cl['keterangan']?></td>
				</tr>
			<? $no++;}; ?>
		</table>
	</div>
	<div style="bottom:0;width:100%">
		<div style="width:50%;float:left;height:110px">
			
		</div>
		<div style="width:50%;float:left;">
			<table style="margin-top:60px;width:100%;text-align:center">
				<tr>
					<td colspan="2">Yogyakarta,<?php echo date('d F Y')?></td>
				</tr>
				<tr>
					<td style="height:100px"></td>
					<td style="height:100px"></td>
				</tr>
				<tr >
					<td >(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
					<td>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
				</tr>
				<tr>
					<td>Koor. Bid. PE-RRM-TM</td>
					<td>Kasie PIEA</td>
				</tr>
			</table>
		</div>
	</div>
</div>