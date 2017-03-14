<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Master Seksi</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterSeksi');?>">
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
                  <a href="<?php echo site_url('PayrollManagement/MasterSeksi/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                      <button type="button" class="btn btn-default btn-sm">
                        <i class="icon-plus icon-2x"></i>
                      </button>
                    </a>
                    <b>Master Seksi</b>
		          </div>
		          <div class="box-body">
					<div class="row">
						<form method="post" action="<?php echo base_url('PayrollManagement/MasterSeksi/import
						')?>" enctype="multipart/form-data">
							<div class="row" style="margin: 10px 10px">
									<div class="col-lg-offset-7 col-lg-3">
										<input name="importfile" type="file" class="form-control" readonly required>
									</div>
									<div class="col-lg-2">
										<button class="btn btn-info btn-block">Import</button>
									</div>
								</div>
						</form>
					</div>
		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-masterSeksi" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center"><div style="width:40px"></div>NO</th>
                            <th style="text-align:center"><div style="width:100px"></div>ACTION</th>
							<th style="text-align:center"><div style="width:80px"></div>Kodesie</th>
							<th style="text-align:center"><div style="width:80px"></div>Dept</th>
							<th style="text-align:center"><div style="width:300px"></div>Bidang</th>
							<th style="text-align:center"><div style="width:300px"></div>Unit</th>
							<th style="text-align:center"><div style="width:400px"></div>Seksi</th>
							<th style="text-align:center"><div style="width:300px"></div>Pekerjaan</th>
							<th style="text-align:center"><div style="width:40px"></div>Golkerja</th>

		                  </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; foreach($masterSeksi_data as $row) { ?>
							<tr>
							  <td align='center'><?php echo $no++;?></td>
                              <td align='center'>
                              	<a href="<?php echo base_url('PayrollManagement/MasterSeksi/read/'.$row->kodesie.''); ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-eye"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/MasterSeksi/update/'.$row->kodesie.''); ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/MasterSeksi/delete/'.$row->kodesie.''); ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-times"></span></a>
                              </td>
							<td><?php echo $row->kodesie ?></td>
							<td><?php echo $row->dept ?></td>
							<td><?php echo $row->bidang ?></td>
							<td><?php echo $row->unit ?></td>
							<td><?php echo $row->seksi ?></td>
							<td><?php echo $row->pekerjaan ?></td>
							<td><?php echo $row->golkerja ?></td>

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