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
					<h1>MONITORING PAINTING CBO</h1>
				</td>
			</tr>
		</table>
	</div>
<!--table content-->
	<div>
		<table  border="1" style="text-align:center;border-collapse:collapse;width:100%" <!-- class="table table-striped" -->>
			<tr>
					<td style="vertical-align:middle" class="text-center" rowspan="2">
						Tipe
					</td>
					<td  class="text-center" colspan="1">
						Hasil Cat
					</td>
					<td  class="text-center" colspan="2">
						Hasil CBO
					</td>
					<td  class="text-center" colspan="3">
						Repair Proses
					</td>
					<td  class="text-center" colspan="3">
						Repair Material
					</td>
					<td style="vertical-align:middle" class="text-center" rowspan="2" colspan="1">
						Lain-lain
					</td>
				</tr>
				<tr>
					<td colspan="1">
						
					</td>
					<td class="text-center" colspan="1">
						OK
					</td>
					<td  class="text-center" colspan="1">
						Reject
					</td>
					<td  class="text-center" colspan="1">
						Belang
					</td>
					<td  class="text-center" colspan="1">
						Dlewer
					</td>
					<td  class="text-center" colspan="1">
						Kasar Cat
					</td>
					<td  class="text-center" colspan="1">
						Kropos
					</td>
					<td  class="text-center" colspan="1">
						Kasar Spat
					</td>
					<td  class="text-center" colspan="1">
						kasar Mat
					</td>
				</tr>
				<?php $no=1; foreach ($report as $cl) {?>
				<tr row-id="1">
						<td>
						<?php echo $cl['tipe']?>
						</td>
						<td  style="min-width:100px">
						<?php echo $cl['hasil_cat']?>
						</td>
						<td style="min-width:100px">
						<?php echo $cl['ok']?>
						</td>
						<td style="min-width:100px">
						<?php echo $cl['reject']?>
						</td>
						<td style="min-width:100px">
						<?php echo $cl['belang']?>
						</td>
						<td style="min-width:100px">
						<?php echo $cl['dlewer']?>
						</td>
						<td style="min-width:100px">
						<?php echo $cl['kasar_cat']?>
						</td>
						<td style="min-width:100px">
						<?php echo $cl['kropos']?>
						</td>
						<td style="min-width:100px">
						<?php echo $cl['kasar_spat']?>
						</td>
						<td style="min-width:100px">
						<?php echo $cl['kasar_mat']?>
						</td>
						<td style="min-width:100px">
						<?php echo $cl['lain_lain']?>
						</td>
						<? $no++;}; ?>
				</tr>
		</table>
	</div>
</div>