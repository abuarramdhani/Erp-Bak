<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Report Riwayat Kenaikan Gaji Karyawan</b></h1>
	            </div>
	          </div>
	          </div>
	        </div>
	      </div>
	      <br/>
	      
	      <div class="row">
	        <div class="col-lg-12">
		        <div class="box box-primary box-solid">
		          <div class="box-header with-border">
					<b>Riwayat Kenaikan Gaji Karyawan</b>
		          </div>
		          <div class="box-body">
					<div class="row">
								<div class="row" style="margin: 10px 0px">
									<form method="post" action="<?php echo base_url('PayrollManagement/Report/RiwayatKenaikanGaji/search')?>" enctype="multipart/form-data">
										<div class="col-lg-2">
											<input name="txtPeriodeHitung" id="txtPeriodeHitung" type="text" class="form-control">
										</div>
										<div class="col-lg-2">
											<button class="btn btn-warning btn-block">Search</button>
										</div>
									</form>
								</div>
					</div>
					<?php if ($ShowPeriod) 
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
										<td><a class="btn btn-xs btn-primary" href="'.site_url('PayrollManagement/Report/RiwayatKenaikanGaji/GeneratePDF?year='.$year.'&month='.$month).'">'.
											'<span class="fa fa-file-pdf-o"></span></a></td>
									</tr>
								</table>
							</div>';
						}
					?>
					
		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-dataRiwayatGaji" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center"><div style="width:40px"></div>NO</th>
							<th style="text-align:center"><div style="width:100px"></div>No. Induk</th>
							<th style="text-align:center"><div style="width:100px"></div>Nama</th>
							<th style="text-align:center"><div style="width:100px"></div>Tgl. Perubahan</th>														
							<th style="text-align:center"><div style="width:100px"></div>GP Sebelum</th>
							<th style="text-align:center"><div style="width:100px"></div>GP Sesudah</th>
							<th style="text-align:center"><div style="width:100px"></div>Selisih</th>
		                  </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; 
							if(!empty($riwayat_gaji)){
								foreach($riwayat_gaji as $row) { ?>
								<tr>
								<td align='center'><?php echo $no++;?></td>
								<td align='center'><?php echo $row['no_induk'] ?></td>
								<td align='center'><?php echo $row['nama'] ?></td>
								<td align='center'><?php echo $row['tgl_berubah'] ?></td>
								<td align='center'><?php echo $row['gaji_lama'] ?></td>
								<td align='center'><?php echo $row['gaji_baru'] ?></td>
								<td align='center'><?php echo $row['selisih'] ?></td>
								</tr>
								<?php }
							} ?>
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