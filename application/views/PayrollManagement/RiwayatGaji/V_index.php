<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Riwayat Gaji</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/RiwayatGaji');?>">
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
                  <a href="<?php echo site_url('PayrollManagement/RiwayatGaji/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                      <button type="button" class="btn btn-default btn-sm">
                        <i class="icon-plus icon-2x"></i>
                      </button>
                    </a>
                    <b>Riwayat Gaji</b>
		          </div>
		          <div class="box-body">
					<div class="row">
						<form method="post" action="<?php echo base_url('PayrollManagement/RiwayatGaji/import')?>" enctype="multipart/form-data">
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
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-riwayatGaji" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center; width:30px">NO</th>
                            <th style='text-align:center'>ACTION</th>
							<th>Tgl Berlaku</th>
							<th>Tgl Tberlaku</th>
							<th>Noind</th>
							<th>Kd Hubungan Kerja</th>
							<th>Kd Status Kerja</th>
							<th>Kd Jabatan</th>
							<th>Gaji Pokok</th>
							<th>I F</th>
							<th>Kd Petugas</th>
							<th>Tgl Record</th>

		                  </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; foreach($riwayatGaji_data as $row) { ?>
							<tr>
							  <td align='center'><?php echo $no++;?></td>
                              <td align='center' width='200px'>
                              	<a href="<?php echo base_url('PayrollManagement/RiwayatGaji/read/'.$row->id_riw_gaji.''); ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-eye"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/RiwayatGaji/update/'.$row->id_riw_gaji.''); ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/RiwayatGaji/delete/'.$row->id_riw_gaji.''); ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-times"></span></a>
                              </td>
							<td><?php echo $row->tgl_berlaku ?></td>
							<td><?php echo $row->tgl_tberlaku ?></td>
							<td><?php echo $row->noind ?></td>
							<td><?php echo $row->kd_hubungan_kerja ?></td>
							<td><?php echo $row->kd_status_kerja ?></td>
							<td><?php echo $row->kd_jabatan ?></td>
							<td><?php echo $row->gaji_pokok ?></td>
							<td><?php echo $row->i_f ?></td>
							<td><?php echo $row->kd_petugas ?></td>
							<td><?php echo $row->tgl_record ?></td>

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