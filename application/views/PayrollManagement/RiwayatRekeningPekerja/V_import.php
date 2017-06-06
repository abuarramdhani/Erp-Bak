<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Riwayat Rekening Pekerja</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/RiwayatRekeningPekerja');?>">
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
                    <b>Riwayat Rekening Pekerja</b>
		          </div>
		          <div class="box-body">

		            <div class="table-responsive">
		            	<div class="row">
			              	<form method="post" action="<?php echo base_url('PayrollManagement/RiwayatRekeningPekerja/upload')?>" enctype="multipart/form-data">
								<div class="row" style="margin: 10px 0 10px 10px">
									<div class="col-lg-offset-7 col-lg-3">
										<input name="importfile" type="file" class="form-control" readonly required>
									</div>
									<div class=" col-lg-2">
										<button class="btn btn-primary btn-block">Load</button>
									</div>
							</form>
			          	</div>
									<?php
										if (!empty($data)) {
									?>
									<form method="post" action="<?php echo base_url('PayrollManagement/RiwayatRekeningPekerja/saveImport')?>">
										<div class="row" style="margin: 10px 0 10px 10px">
											<div class="col-lg-offset-10 col-lg-2">
												<input type="hidden" name="txtFileName" value="<?php echo $filename; ?>">
												<button class="btn btn-primary btn-block">Import</button>
											</div>
										</div>
									</form>
									<?php
										}
									?>
								</div>
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-riwayatRekeningPekerja" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center; width:30px">NO</th>
							<th>Tgl Berlaku</th>
							<th>Tgl Tberlaku</th>
							<th>Noind</th>
							<th>Kd Bank</th>
							<th>No Rekening</th>
							<th>Nama Pemilik Rekening</th>
							<th>Kode Petugas</th>
							<th>Tgl Record</th>

		                  </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; foreach($data as $row) { ?>
							<tr>
							  <td align='center'><?php echo $no++;?></td>
							<td><?php echo $row['tgl_berlaku']; ?></td>
							<td><?php echo $row['tgl_tberlaku']; ?></td>
							<td><?php echo $row['noind']; ?></td>
							<td><?php echo $row['kd_bank']; ?></td>
							<td><?php echo $row['no_rekening']; ?></td>
							<td><?php echo $row['nama_pemilik_rekening']; ?></td>
							<td><?php echo $row['kode_petugas']; ?></td>
							<td><?php echo $row['tgl_record']; ?></td>

							</tr>
							<?php } ?>
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