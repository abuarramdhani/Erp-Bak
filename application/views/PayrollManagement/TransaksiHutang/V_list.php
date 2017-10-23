<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Transaksi Hutang</b></h1>
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
	      <?php
			$this->load->view('PayrollManagement/V_alert');
		  ?>
	      <div class="row">
	        <div class="col-lg-12">
		        <div class="box box-primary box-solid">
		          <div class="box-header with-border">
                  <a href="<?php echo site_url('PayrollManagement/TransaksiHutang/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                      <button type="button" class="btn btn-default btn-sm">
                        <i class="icon-plus icon-2x"></i>
                      </button>
                    </a>
                    <b>Transaksi Hutang</b>
		          </div>
		          <div class="box-body">

		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-transaksiHutang-list" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th class="text-center"><div style="width:40px"></div>NO</th>
							<th class="text-center"><div style="width:100px"></div>Tanggal angsuran</th>
							<th class="text-center"><div style="width:100px"></div>Jenis Transaksi</th>
							<th class="text-center"><div style="width:100px"></div>Nominal</th>
							<th class="text-center"><div style="width:100px"></div>Lunas</th>

		                  </tr>
		                </thead>
		                <tbody>
							<?php 
								$no = 1; 
								$total = 0;
								foreach($transaksiHutang_data as $row) {
								$total = $total + $row->jumlah_transaksi;
								?>
							<tr>
								<td align='center'><?php echo $no++;?></td>
								<td><?php echo $row->tgl_transaksi ?></td>
								<td><?php echo $row->jenis_transaksi ?></td>
								<td><?php echo number_format((int)$row->jumlah_transaksi,0,",","."); ?></td>
								<td><?php echo $row->lunas; ?></td>
							</tr>
							<?php } ?>
		                </tbody>
						<tfoot>
							<tr>
								<th class="text-center" colspan="3">Total</th>
								<th class="text-right"><?php echo number_format((int)$total,0,",","."); ?></th>
								<th>&nbsp;</th>
							</tr>
						</tfoot>
		              </table>
		            </div>
					 <div class="panel-footer">
                                <div class="row text-right">
                                    <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
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