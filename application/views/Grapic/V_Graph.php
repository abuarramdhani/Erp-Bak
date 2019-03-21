<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?=$Title ?></b></h1>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-sm hidden-xs hidden-md">
								<a href="" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<form action="<?php echo base_url('SDM/Graph');?>" method="post">
							<div class="box box-primary box-solid">
								<div class="box-header with-border">

								</div>
								<div class="box-body">

									<div class="form-group">
										<div class="col-lg-3 text-center">
											<label class="control-label">Pilih Data</label>
											<select name="grData" class="form-control grData">
												<option value="1">Semua</option>
												<option value="2">Per Departemen</option>
											</select>
										</div>
										<div class="col-lg-3 text-center">
											<label class="control-label">Pilih Departemen</label>
											<select required="" name="grDept" disabled="" class="grDept form-control">
												<option></option>
											</select>
										</div>
										<div class="col-lg-3 text-center">
											<label class="control-label">Pilih Seksi</label>
											<select required="" name="grSeksi" disabled="" class="grSek form-control">
												<option></option>
											</select>
										</div>
										<div class="col-lg-3 text-center">
											<label class="control-label">Dengan ICT</label>
											<br />
											<input name="grICT" type="checkbox" class="form-control">
										</div>
									</div>
									<!-- <div><input value="<?php echo $ps; ?>"></input></div> -->
								</div>
								<div class="panel-footer">
									<div class="row text-right">
										<button value="true" name="bt_ps" style="margin-right: 20px;" class="btn btn-info btn-md" type="submit">
											Proses
										</button>
									</div>
								</div>
							</div>
						</form>
						<?php if ($proses == 'trueas') { ?>
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<h2 class="box-title">Rekap Efisiensi SDM <?php echo $ICT; ?></h2>
							</div>
							<div class="box-body">
								<table style="overflow-x: scroll; width: 100%; display: block;" class="table table-bordered table-hover text-center">
									<thead style="border-color: black">
										<tr>
											<td style="background-color: #00b300; color: white;">Ket</td>
											<?php $a = 1; foreach ($akhir as $key=>$value) { ?>
											<td style="background-color: <?php if ($a%2 == 0) {
												echo "#FF9900";
											}else{
												echo "#3c8dbc";
											} ?>; color: white;" colspan="<?php echo $value; ?>"><?php echo $key; ?></td>
											<?php $a++;} ?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Tanggal</td>
											<?php foreach ($tgl as $key => $date): ?>
												<td colspan="2"><?php echo $date->format("m.d"); ?></td>	
											<?php endforeach ?>
										</tr>
										<tr>
											<td>Trgt Karyawan</td>
											<?php foreach ($target as $key) { ?>
											<td colspan="2"><?php echo $key; ?></td>
											<input hidden="" class="trgt-karyawan" value="<?php echo $key; ?>">
											<?php } ?>
										</tr>
										<tr>
											<td>Jml Karyawan</td>
											<?php foreach ($karyawan as $key=>$value) { ?>
											<td colspan="2"><?php echo $value; ?></td>
											<?php } ?>
											<!-- jika kolom ada yang kosong -->
											<?php for ($i=$banyak; $i <18 ; $i++) { ?>
											<td colspan="2"></td>
											<?php } ?>
										</tr>
										<tr>
											<td>Trgt Turun Per Bulan</td>
											<td>0</td>
											<td>0%</td>
											<?php for ($i=0; $i < 17; $i++) { ?>
											<td>47</td>
											<td>1,3%</td>
											<?php } ?>
										</tr>
										<tr>
											<td>Jml Turun Per Bulan</td>
											<td>0</td>
											<td>0%</td>
											<?php for ($i=0; $i < $banyak-1 ; $i++) { 
												echo '<td>'.-1*$min[$i].'</td>';
												echo '<td>'.-1*$rateup[$i].'%</td>';
											} ?>
											<?php for ($i=$banyak; $i <18 ; $i++) { ?>
											<td></td>
											<td></td>
											<?php } ?>
										</tr>
										<tr>
											<td>Trgt Turun Akumulasi</td>
											<td>0</td>
											<td>0%</td>
											<?php for ($i=0; $i < 17 ; $i++) { 
												echo '<td>'.-1*$min2[$i].'</td>';
												echo '<td>'.-1*$rateup2[$i].'%</td>';
											} ?>
										</tr>
										<tr>
											<td>Jml Turun Akumulasi</td>
											<td>0</td>
											<td>0%</td>
											<?php for ($i=0; $i < $banyak-1 ; $i++) { 
												echo '<td>'.-1*$min3[$i].'</td>';
												echo '<td>'.-1*$rateup3[$i].'%</td>';
											} ?>
											<?php for ($i=$banyak; $i <18 ; $i++) { ?>
											<td></td>
											<td></td>
											<?php } ?>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<?php } ?>
						<?php if ($proses == 'true' && $dept == 'true') { 
							for ($x=0; $x < $jumlahDept ; $x++) { 
								
							?>
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<h2 class="box-title">Rekap Efisiensi SDM <?php echo $ICT; ?></h2>
							</div>
							<div class="box-body">
								<table style="overflow-x: scroll; width: 100%; display: block;" class="table table-bordered table-hover text-center">
									<thead style="border-color: black">
										<tr>
											<td style="background-color: #00b300; color: white;">Ket</td>
											<?php $a = 1; foreach ($akhir as $key=>$value) { ?>
											<td style="background-color: <?php if ($a%2 == 0) {
												echo "#FF9900";
											}else{
												echo "#3c8dbc";
											} ?>; color: white;" colspan="<?php echo $value; ?>"><?php echo $key; ?></td>
											<?php $a++;} ?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Tanggal</td>
											<?php foreach ($tgl as $key => $date): ?>
												<td colspan="2"><?php echo $date->format("m.d"); ?></td>	
											<?php endforeach ?>
										</tr>
										<tr>
											<td>Trgt Karyawan</td>
											<?php foreach ($target as $key) { ?>
											<td colspan="2"><?php echo $key; ?></td>
											<input hidden="" class="trgt-karyawan" value="<?php echo $key; ?>">
											<?php } ?>
										</tr>
										<tr>
											<td>Jml Karyawan</td>
											<?php foreach ($karyawan as $key=>$value) { ?>
											<td colspan="2"><?php echo $value; ?></td>
											<?php } ?>
											<!-- jika kolom ada yang kosong -->
											<?php for ($i=$banyak; $i <18 ; $i++) { ?>
											<td colspan="2"></td>
											<?php } ?>
										</tr>
										<tr>
											<td>Trgt Turun Per Bulan</td>
											<td>0</td>
											<td>0%</td>
											<?php for ($i=0; $i < 17; $i++) { ?>
											<td>47</td>
											<td>1,3%</td>
											<?php } ?>
										</tr>
										<tr>
											<td>Jml Turun Per Bulan</td>
											<td>0</td>
											<td>0%</td>
											<?php for ($i=0; $i < $banyak-1 ; $i++) { 
												// echo "sfsg".$i;
												$var1 = 'min'.$x;
												$var2 = 'rateup'.$x;
												echo '<td>'.((-1)*${$var1}[$i]).'</td>';
												echo '<td>'.((-1)*${$var2}[$i]).'%</td>';
											} ?>
											<?php for ($i=$banyak; $i <18 ; $i++) { ?>
											<td></td>
											<td></td>
											<?php } ?>
										</tr>
										<tr>
											<td>Trgt Turun Akumulasi</td>
											<td>0</td>
											<td>0%</td>
											<?php for ($i=0; $i < 17 ; $i++) { 
												$var1 = 'min2'.$x;
												$var2 = 'rateup2'.$x;
												echo '<td>'.((-1)*${$var1}[$i]).'</td>';
												echo '<td>'.((-1)*${$var2}[$i]).'%</td>';
											} ?>
										</tr>
										<tr>
											<td>Jml Turun Akumulasi</td>
											<td>0</td>
											<td>0%</td>
											<?php for ($i=0; $i < $banyak-1 ; $i++) { 
												$var1 = 'min3'.$x;
												$var2 = 'rateup3'.$x;
												echo '<td>'.((-1)*${$var1}[$i]).'</td>';
												echo '<td>'.((-1)*${$var2}[$i]).'%</td>';
											} ?>
											<?php for ($i=$banyak; $i <18 ; $i++) { ?>
											<td></td>
											<td></td>
											<?php } ?>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<?php 
						}
							} ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="<?php echo base_url('assets/plugins/html2canvas/html2canvas.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/customGR.js');?>"></script>