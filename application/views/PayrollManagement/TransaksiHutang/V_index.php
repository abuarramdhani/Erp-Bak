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
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-transaksiHutang" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th class="text-center"><div style="width:40px"></div>NO</th>
                            <th class="text-center"><div style="width:100px"></div>ACTION</th>
							<th class="text-center"><div style="width:100px"></div>Noind</th>
							<th class="text-center"><div style="width:100px"></div>No Hutang</th>
							<th class="text-center"><div style="width:100px"></div>Tanggal Transaksi</th>
							<th class="text-center"><div style="width:100px"></div>Kode Jenis Transaksi</th>
							<th class="text-center"><div style="width:100px"></div>Jumlah Transaksi</th>
							<th class="text-center"><div style="width:100px"></div>Lunas</th>

		                  </tr>
		                </thead>
		                <tbody>
							<?php 
								$no = 1; 
								$total = 0;
								foreach($transaksiHutang_data as $row) {
									$e_id = $this->encrypt->encode($row->no_hutang);
									$e_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $e_id);
									if($row->status_lunas==1){
										$status = "LUNAS";
									}else{
										$status = "-";
									}
								$total = $total + $row->total_hutang;
								?>
							<tr>
							  <td align='center'><?php echo $no++;?></td>
                              <td align='center' width='200px'>
                              	<a href="<?php echo base_url('PayrollManagement/TransaksiHutang/read/'.$e_id.''); ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-eye"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/TransaksiHutang/list_/'.$e_id.''); ?>" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-ol"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/TransaksiHutang/update/'.$e_id.''); ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/TransaksiHutang/delete/'.$e_id.''); ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-times"></span></a>
                              </td>
							<td><?php echo $row->noind ?></td>
							<td><?php echo $row->no_hutang ?></td>
							<td><?php echo $row->tgl_pengajuan ?></td>
							<td><?php echo '-'; ?></td>
							<td><?php echo number_format((int)$row->total_hutang,0,",",".") ?></td>
							<td><?php echo $status ?></td>

							</tr>
							<?php } ?>
		                </tbody>
						<tfoot>
							<tr>
								<th class="text-center" colspan="6">Total</th>
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