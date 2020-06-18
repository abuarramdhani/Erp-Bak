<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?php echo $Title;?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo base_url('PenilaianKinerja/JurnalPenilaianPersonalia');?>">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Report Penilaian
							</div>
							<div class="box-body">
								<div class="panel-body">
									<div class="row">
										<table class="table table-striped table-bordered table-hover" id="JurnalPenilaian-reportPenilaian">
											<thead>
												<tr>
													<th style="text-align: center">
														No.
													</th>
													<th style="text-align: center;">
														Nomor Induk
													</th>
													<th style="text-align: center;">
														Kodesie
													</th>
													<th style="text-align: center;">
														Operator
													</th>
													<th style="text-align: center;">
														Golongan Pekerjaan
													</th>
													<th style="text-align: center;">
														Golongan Penilaian
													</th>
													<th style="text-align: center;">
														Skor
													</th>
													<th style="text-align: center;">
														NWaktu
													</th>
													<th style="text-align: center;">
														NKemauan
													</th>
													<th style="text-align: center;">
														NPrestasi
													</th>
													<th style="text-align: center;">
														NPerilaku
													</th>
													<th style="text-align: center;">
														NTIM
													</th>
													<th style="text-align: center;">
														NSP
													</th>
													<th style="text-align: center;">
														NilTIM
													</th>
													<th style="text-align: center;">
														NilSP
													</th>
													<th style="text-align: center;">
														Kenaikan
													</th>
													<th style="text-align: center;">
														GPLama
													</th>
													<th style="text-align: center;">
														GPBaru
													</th>
													<th style="text-align: center;">
														Selisih
													</th>
													<th style="text-align: center;">
														Cetak
													</th>
													<th style="text-align: center;">
														Range Bawah
													</th>
													<th style="text-align: center;">
														NKK_A
													</th>
													<th style="text-align: center;">
														KK_M
													</th>
													<th style="text-align: center;">
														NKK_M
													</th>
													<th style="text-align: center;">
														NPK_A
													</th>
													<th style="text-align: center;">
														PK_M
													</th>
													<th style="text-align: center;">
														NPK_M
													</th>
													<th style="text-align: center;">
														&Sigma;SK (hari)
													</th>
													<th style="text-align: center;">
														&Sigma;SK (bulan)
													</th>
													<th style="text-align: center;">
														Pekerjaan
													</th>
													<th style="text-align: center;">
														Departemen
													</th>
													<th style="text-align: center;">
														Bidang
													</th>
													<th style="text-align: center;">
														Unit
													</th>
													<th style="text-align: center;">
														Seksi
													</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$no 	=	1;
													foreach ($daftarEvaluasiSeksi as $hasil) 
													{
												?>
												<tr>
													<td style="text-align: center;"><?php echo $no;?></td>
													<td style="text-align: center;"><?php echo $hasil['noind'];?></td>
													<td style="text-align: center;"><?php echo $hasil['kodesie'];?></td>
													<td><?php echo $hasil['namaopr'];?></td>
													<td style="text-align: center;"><?php echo $hasil['golkerja'];?></td>
													<td style="text-align: center;"><?php echo $hasil['gol_nilai'];?></td>
													<td style="text-align: center;"><?php echo $hasil['total_nilai'];?></td>
													<td style="text-align: center;"><?php echo $hasil['nwaktu'];?></td>
													<td style="text-align: center;"><?php echo $hasil['nkemauan'];?></td>
													<td style="text-align: center;"><?php echo $hasil['nprestasi'];?></td>
													<td style="text-align: center;"><?php echo $hasil['nperilaku'];?></td>
													<td style="text-align: center;"><?php echo $hasil['n_tim'];?></td>
													<td style="text-align: center;"><?php echo $hasil['n_sp'];?></td>
													<td style="text-align: center;"><?php echo $hasil['n_tim_asli'];?></td>
													<td style="text-align: center;"><?php echo $hasil['n_sp_asli'];?></td>
													<td style="text-align: right;"><?php echo $hasil['naik'];?></td>
													<td style="text-align: right;"><?php echo $hasil['gpnaik'];?></td>
													<td style="text-align: right;"><?php echo $hasil['gpbaru'];?></td>
													<td style="text-align: right;"><?php echo $hasil['selisih'];?></td>
													<td style="text-align: center;"><?php echo $hasil['cetak'];?></td>
													<td style="text-align: right;"><?php echo $hasil['rangebwh'];?></td>
													<td style="text-align: center;"><?php echo $hasil['nkk_a'];?></td>
													<td style="text-align: center;"><?php echo $hasil['kk_m'];?></td>
													<td style="text-align: center;"><?php echo $hasil['nkk_m'];?></td>
													<td style="text-align: center;"><?php echo $hasil['npk_a'];?></td>
													<td style="text-align: center;"><?php echo $hasil['pk_m'];?></td>
													<td style="text-align: center;"><?php echo $hasil['npk_m'];?></td>
													<td style="text-align: center;"><?php echo $hasil['total_hari_sk'];?></td>
													<td style="text-align: center;"><?php echo $hasil['total_bulan_sk'];?></td>
													<td><?php echo $hasil['pekerjaan'];?></td>
													<td><?php echo $hasil['dept'];?></td>
													<td><?php echo $hasil['bid'];?></td>
													<td><?php echo $hasil['unit'];?></td>
													<td><?php echo $hasil['seksi'];?></td>
												</tr>
												<?php
														$no++;
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="panel-footer">
									<div class="row text-right">
										<a href="<?php echo base_url('PenilaianKinerja/JurnalPenilaianPersonalia');?>" class="btn btn-primary brn-lg btn-rect">Kembali</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>