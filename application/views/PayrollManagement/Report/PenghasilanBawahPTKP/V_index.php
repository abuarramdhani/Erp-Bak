<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Report Karyawan Berpenghasilan di Bawah PTKP</b></h1>
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
					<b>Karyawan Berpenghasilan di Bawah PTKP</b>
		          </div>
		          <div class="box-body">
		          	<span>Pilih periode tahun: </span>
					<div class="row">
								<div class="row" style="margin: 10px 0px">
									<form method="post" action="<?php echo base_url('PayrollManagement/Report/PenghasilanBawahPTKP/search')?>" enctype="multipart/form-data">
										<div class="col-lg-2" align="center">
											<input name="txtPeriodeTahun" type="number" min="1900" max="2099" step="1" value="<?php echo $current_year ?>" />
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
										<td width="50px">PDF</td>
										<td> :&nbsp</td>
										<td><a class="btn btn-xs btn-primary" href="'.site_url('PayrollManagement/Report/PenghasilanBawahPTKP/GeneratePDF?year='.$year).'">'.
											'<span class="fa fa-file-pdf-o"></span></a></td>
									</tr>
								</table>
							</div>';
						}
					?>
					
		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-dataPenghasilanBawahPTKP" style="font-size:12px;">
		                <thead class="bg-primary">
			                <tr>
			                    <th style="text-align:center"><div style="width:40px"></div>NO</th>
								<th style="text-align:center"><div style="width:100px"></div>No. Induk</th>
								<th style="text-align:center"><div style="width:100px"></div>NPWP</th>
								<th style="text-align:center"><div style="width:100px"></div>Nama</th>														
			                </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; 
							if(!empty($daftar_karyawan)){
								foreach($daftar_karyawan as $row) { ?>
								<tr>
									<td align='center'><?php echo $no++;?></td>
									<td align='center'><?php echo $row['no_induk'] ?></td>
									<td align='center'><?php echo $row['npwp'] ?></td>
									<td align='center'><?php echo $row['nama'] ?></td>
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