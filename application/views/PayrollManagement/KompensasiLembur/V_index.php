<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Kompensasi Lembur</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/TransaksiHutang');?>">
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
                    <b>Kompensasi Lembur</b>
		          </div>
		          <div class="box-body">
		   <!--        <div class="table-responsive">   -->
				    <div class="row">
						 <div class="row" style="margin: 10px 0 10px 0px">
							<form method="post" action="<?php echo base_url('PayrollManagement/KompensasiLembur/check_kompensasi')?>" enctype="multipart/form-data">
							<div class="col-lg-2">
									<input type="text" name="txtPeriodeCheck" id="txtPeriodeCheck" class="form-control" placeholder="[ Periode Hitung ]"></input>
							  </div>
							  <div class=" col-lg-1">
							    <button class="btn btn-primary btn-block">Check</button>
							  </div>
							</form>
							  <div class="col-lg-5">
							  </div>
							<form method="post" action="<?php echo base_url('PayrollManagement/KompensasiLembur/hitung_kompensasi')?>" enctype="multipart/form-data">
							  <div class="col-lg-2">
									<input type="text" name="txtPeriodeTahun" id="txtPeriodeTahun" class="form-control" placeholder="[ Periode Hitung ]"></input>
							  </div>
							  <div class=" col-lg-2">
							    <button class="btn btn-primary btn-block">Proses Hitung</button>
							  </div>
							</form>
						</div>
		            </div>
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-konpensasiLembur" style="font-size:12px;width:100%;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center; width:30px"><div style="width:40px"></div>NO</th>
							<th style='text-align:center;'><div style="width:100px"></div>Nama</th>
                            <th style='text-align:center'><div style="width:100px"></div>Tanggal</th>
							<th style='text-align:center;'><div style="width:100px">Stat.Kerja</div></th>
							<th style='text-align:center;'><div style="width:100px"></div>Seksi</th>
							<th style='text-align:center;'><div style="width:100px;font:red;"></div>Komp. Lembur</th>
						  </tr>
		                </thead>
						<tbody>
							<?php if(!empty($konpensasi_lembur)){
									$no = 0;
									foreach($konpensasi_lembur as $row){
									$no++;
							?>
								<tr>
									<td align='center'><?php echo $no++;?></td>
									<td align='left'><?php echo $row->nama?></td>
									<td align='center'><?php echo $row->tanggal?></td>
									<td align='center'><?php echo $row->kd_status_kerja?></td>
									<td align='center'><?php echo $row->kodesie?></td>
									<td align='center'><?php echo number_format((int)$row->jumlah_konpensasi) ?></td>
								</tr>
							<?php 
									}
								}	
							?>
						</tbody>
						
		              </table>
		      <!--     </div>   -->
		          </div>
		        </div>
	        </div>
	      </div>    
	    </div>    
	  </div>
	</div>
</section>