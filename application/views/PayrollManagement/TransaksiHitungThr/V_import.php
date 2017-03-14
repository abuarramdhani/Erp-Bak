<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Transaksi Hitung Thr</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/TransaksiHitungThr');?>">
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
                    <b>Transaksi Hitung Thr</b>
		          </div>
		          <div class="box-body">

		            <div class="table-responsive">
		              <div class="row">
			              <form method="post" action="<?php echo base_url('PayrollManagement/TransaksiHitungThr/upload')?>" enctype="multipart/form-data">
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
					  <form method="post" action="<?php echo base_url('PayrollManagement/TransaksiHitungThr/saveImport')?>">
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
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-transaksiHitungThrImport" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="width:5%" align="center">NO</th>
							<th style="width:15%">Tanggal</th>
							<th style="width:10%">Periode</th>
							<th style="width:20%">Noind</th>
							<th style="width:15%">Kd Status Kerja</th>
							<th style="width:15%">Diangkat</th>
							<th style="width:10%">Lama Thn</th>
							<th style="width:10%">Lama Bln</th>
		                  </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; foreach($data as $row) { ?>
							<tr>
							  <td align='center'><?php echo $no++;?></td>
							  <td><?php echo $row['tanggal'] ?></td>
							  <td><?php echo $row['periode'] ?></td>
							  <td><?php echo $row['noind'] ?></td>
							  <td><?php echo $row['kd_status_kerja'] ?></td>
							  <td><?php echo $row['diangkat'] ?></td>
							  <td><?php echo $row['lama_thn'] ?></td>
							  <td><?php echo $row['lama_bln'] ?></td>
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