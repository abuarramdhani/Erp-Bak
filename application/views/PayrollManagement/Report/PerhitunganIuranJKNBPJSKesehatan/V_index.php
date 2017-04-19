<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Perhitungan Iuran JKN BPJS Kesehatan</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/');?>">
	            		<i class="icon-wrench icon-2x"></i>
	            		<span><br/></span>
	            	</a>
	            </div>
	          </div>
	        </div>
	      </div>
	      <br/>
	      
	      <div class="row">
	        <div class="col-lg-12">
		        <div class="box box-primary box-solid">
		          <div class="box-header with-border">
					<b>Laporan Perhitungan Iuran JKN BPJS Kesehatan</b>
		          </div>
		          <div class="box-body">
					<div class="row">
						<div class="row" style="margin: 10px 0px">
							<form method="post" action="<?php echo base_url('PayrollManagement/Report/PerhitunganIuranJKNBPJSKesehatan/search')?>" enctype="multipart/form-data">
								<div class="col-lg-2">
									<input name="txtPeriodeHitung" placeholder="Periode" id="txtPeriodeHitung" type="text" class="form-control">
								</div>
								<div class="col-lg-2">
									<button class="btn btn-warning btn-block">Search</button>
								</div>
							</form>
							<div class="col-lg-3">
							</div>
						</div>
					</div>
					<?php if ($period_shown) 
						{
							echo '<div class="row" style="margin: 10px 0px">
								<table>
									<tr>
										<td width="50px">Periode</td>
										<td> :&nbsp</td>
										<td>'.$year.' - '.$month.'</td>
									</tr>
									<tr>
										<td width="50px">PDF</td>
										<td> :&nbsp</td>
										<td><a class="btn btn-xs btn-primary" href="'.site_url('PayrollManagement/Report/PerhitunganIuranJKNBPJSKesehatan/GeneratePDF?year='.$year.'&month='.$month).'">'.
											'<span class="fa fa-file-pdf-o"></span></a></td>
									</tr>
								</table>
							</div>';
						}
					?>
		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" style="font-size:12px;">
		                <thead class="bg-primary">
			                <tr>
			                    <th rowspan="2" style="text-align:center; vertical-align: middle;">NO</th>
								<th rowspan="2" style="text-align:center; vertical-align: middle;">Nama</th>
								<th rowspan="2" style="text-align:center; vertical-align: middle;">Gaji Pokok</th>
								<th rowspan="2" style="text-align:center; vertical-align: middle;">Tunjangan Tetap</th>
								<th rowspan="2" style="text-align:center; vertical-align: middle;">Total Gaji</th>
								<th rowspan="2" style="text-align:center; vertical-align: middle;">Gaji untuk Perhitungan</th>
								<th colspan="3" style="text-align:center">Iuran</th>
								<th rowspan="2" style="text-align:center; vertical-align: middle;">Jumlah P/I/S/A</th>
								<th rowspan="2" style="text-align:center; vertical-align: middle;">Kelas Perawatan</th>
			                </tr>
			                <tr>
			                	<th style="text-align:center">Perusahaan</th>
			                	<th style="text-align:center">Karyawan</th>
			                	<th style="text-align:center">Total</th>
			                </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; 
							if(!empty($perhitungan_iuran)){
								foreach($perhitungan_iuran as $row) { ?>
								<tr>
									<td align='center'><?php echo $no++;?></td>
									<td align='center'><?php echo $row['nama'] ?></td>
									<td align='center'><?php echo 'Rp. '.number_format(floatval($row['gaji_pokok']),0,",",".") ?></td>
									<td align='center'><?php echo 'Rp. '.number_format(0,0,",",".") ?></td>
									<td align='center'><?php echo 'Rp. '.number_format(floatval($row['gaji_pokok']),0,",",".") ?></td>
									<td align='center'><?php echo 'Rp. '.number_format(floatval($row['gaji_perhitungan']),0,",",".") ?></td>
									<td align='center'><?php echo 'Rp. '.number_format(floatval($row['iuran_perusahaan']),0,",",".") ?></td>
									<td align='center'><?php echo 'Rp. '.number_format(floatval($row['iuran_karyawan']),0,",",".") ?></td>
									<td align='center'><?php echo 'Rp. '.number_format(floatval($row['iuran_total']),0,",",".") ?></td>
									<td align='center'><?php echo $row['jumlah_pisa'] ?></td>
									<td align='center'><?php echo $row['kelas_perawatan'] ?></td>
								</tr>
							<?php 
								}
							}
							if (!empty($total)) {
							?>	<tr>
									<td colspan="5" align="right"><b>TOTAL</b></td>
									<td align='center'><?php echo 'Rp. '.number_format(floatval($total['total_gaji_perhitungan']),0,",",".") ?></td>									
									<td align='center'><?php echo 'Rp. '.number_format(floatval($total['total_iuran_perusahaan']),0,",",".") ?></td>
									<td align='center'><?php echo 'Rp. '.number_format(floatval($total['total_iuran_karyawan']),0,",",".") ?></td>
									<td align='center'><?php echo 'Rp. '.number_format(floatval($total['total_iuran_total']),0,",",".") ?></td>
								</tr>
							<?php
							}
							?>
		                </tbody>                                      
		              </table>
		            </div>
		          </div>
		        </div>
	        </div>
	      </div>    
	    </div>    
	  </div>
	</div>
</section>