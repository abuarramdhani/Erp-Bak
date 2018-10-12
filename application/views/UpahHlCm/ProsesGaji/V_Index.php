<body class="hold-transition login-page">
<section class="content">
	<div class="panel-group">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Hitung Gaji</h3>
			</div>
			<div class="panel-body">
				<br>
				<form method="POST" action="<?php echo base_url('HitungHlcm/HitungGaji/getData')?>">
				<div class="row">
					<div class="col-lg-1">
						<label class="control-label">Periode</label>		
					</div>
					<div class="col-lg-3">
						<div class="input-group">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar">
									
								</span>
							</span>
							<input id="periodeGaji" name="periodeData" class="prosesgaji-daterangepicker form-control" placeholder="Periode"></input>		
						</div>
					</div>
					<div class="col-lg-3">
						<select name="lokasi_kerja" class="form-control">
							<option disabled="disabled" selected="selected"><i>Lokasi Kerja</i></option>
							<option value="01">Jogja</option>
							<option value="02">Tuksono</option>
						</select>
					</div>
					<div class="col-lg-3">
						<button type="submit" class="btn btn-primary">Proses</button>
					</div>
				</div>
				</form>
				<br>
				<table id="table_prosesgaji" class="table table-hover table-bordered">
					<thead>
						<tr style="background-color: #00ccff;">
							<th style="text-align: center; vertical-align: middle;" rowspan="2">No</th>
							<th style="text-align: center; vertical-align: middle;" rowspan="2">Nama</th>
							<th style="text-align: center; vertical-align: middle;" rowspan="2">Status</th>
							<th style="text-align: center;" colspan="3">Komponen</th>
							<th style="text-align: center;" colspan="3">Nominal</th>
							<th style="text-align: center; vertical-align: middle;" rowspan="2">Total Gaji</th>
						</tr>
						<tr style="background-color: #00ccff;">
							<th style="text-align: center;">Gaji Pokok</th>
							<th style="text-align: center;">Uang Makan</th>
							<th style="text-align: center;">Lembur</th>
							<th style="text-align: center;">Gaji Pokok</th>
							<th style="text-align: center;">Uang Makan</th>
							<th style="text-align: center;">Lembur</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no=1;
						foreach ($data as $key) {
							$gpokok = $key['gpokok'];
							$um = $key['um'];
							$lembur = $key['lembur'];
							for ($i=0; $i < 8; $i++) { 
								if ($key['lokasi_kerja']==$gaji[$i]['lokasi_kerja'] and $key['kdpekerjaan']==$gaji[$i]['kode_pekerjaan']) {
									$nominalgpokok = $gaji[$i]['nominal'];
								}
								if ($key['lokasi_kerja']==$gaji[$i]['lokasi_kerja']) {
									$nominalum = $gaji[$i]['uang_makan'];
								}
							}
							
							$gajipokok = $gpokok*$nominalgpokok;
							$uangmakan = $um*$nominalum;
							$gajilembur = $lembur*($nominalgpokok/7);
							$total = $gajipokok+$gajilembur+$uangmakan;
							?>
							<tr>
								<td style="text-align: center;"><?php echo $no;?></td>
								<td><?php echo $key['nama'];?></td>
								<td style="text-align: center;"><?php echo $key['pekerjaan'];?></td>
								<td style="text-align: center;"><?php echo $gpokok;?></td>
								<td style="text-align: center;"><?php echo $um;?></td>
								<td style="text-align: center;"><?php echo $lembur;?></td>
								<td style="text-align: center;"><?php echo $gajipokok;?></td>
								<td style="text-align: center;"><?php echo $uangmakan;?></td>
								<td style="text-align: center;"><?php echo $gajilembur;?></td>
								<td style="text-align: center;"><?php echo $total;?></td>
							</tr>
							<?php
							$no++;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
		
</section>
</body>