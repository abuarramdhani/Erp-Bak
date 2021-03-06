<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Report Rincian Hutang</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/HutangKaryawan');?>">
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
                    <b>Rincian Hutang Karyawan</b>
		          </div>
		          <div class="box-body">

		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-hutangKaryawan" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center; width:30px">NO</th>
							<th style='text-align:center'>Nomor Hutang</th>
							<th style='text-align:center'>No Induk</th>
							<th style='text-align:center'>Tanggal Pengajuan</th>
							<th style='text-align:center'>Total Hutang</th>
							<th style='text-align:center'>Jumlah Cicilan</th>
							<th style='text-align:center'>Status Lunas</th>
							<th style='text-align:center'>View</th>
							<th style='text-align:center'>PDF</th>
		                  </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; foreach($hutangKaryawan_data as $row) {
								if($row->status_lunas == 0){
									$status = "belum lunas";
								}else{
									$status = "lunas";
								}
							?>
							<tr>
							  <td align='center'><?php echo $no++;?></td>
							<td align='center'><?php echo $row->no_hutang ?></td>
							<td align='center'><?php echo $row->noind ?></td>
							<td align='center'><?php echo $row->tgl_pengajuan ?></td>
							<td align='right'><?php echo number_format((int)$row->total_hutang) ?></td>
							<td align='center'><?php echo $row->jml_cicilan ?></td>
							<td align='center'><?php echo $status ?></td>
							<td align='center'><a class="btn btn-xs btn-primary" href="<?php echo site_url('PayrollManagement/TransaksiHutang?id='.$row->no_hutang); ?>"><span class="fa fa-search"></span></a></td>
							<td align='center'><a class="btn btn-xs btn-primary" href="<?php echo site_url('PayrollManagement/Report/RincianHutang/GeneratePDF?noind='.$row->noind.'&no_hutang='.$row->no_hutang); ?>"><span class="fa fa-file-pdf-o"></span></a></td>
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