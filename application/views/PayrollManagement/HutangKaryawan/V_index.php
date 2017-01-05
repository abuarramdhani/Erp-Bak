<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Hutang Karyawan</b></h1>
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
                  <a href="<?php echo site_url('PayrollManagement/HutangKaryawan/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                      <button type="button" class="btn btn-default btn-sm">
                        <i class="icon-plus icon-2x"></i>
                      </button>
                    </a>
                    <b>Hutang Karyawan</b>
		          </div>
		          <div class="box-body">

		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-hutangKaryawan" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center; width:30px">NO</th>
                            <th style='text-align:center'>ACTION</th>
							<th>Nomor Hutang</th>
							<th>No Induk</th>
							<th>Tanggal Pengajuan</th>
							<th>Total Hutang</th>
							<th>Jumlah Cicilan</th>
							<th>Status Lunas</th>
							<th>Kode Petugas</th>
							<th>Tanggal Record</th>

		                  </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; foreach($hutangKaryawan_data as $row) { ?>
							<tr>
							  <td align='center'><?php echo $no++;?></td>
                              <td align='center' width='200px'>
                              	<a href="<?php echo base_url('PayrollManagement/HutangKaryawan/read/'.$row->no_hutang.''); ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-eye"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/HutangKaryawan/update/'.$row->no_hutang.''); ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/HutangKaryawan/delete/'.$row->no_hutang.''); ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-times"></span></a>
                              </td>
							<td><a href="<?php echo base_url('PayrollManagement/Report/rincianhutang/'.$row->no_hutang)?>"><?php echo $row->no_hutang ?></a></td>
							<td><?php echo $row->noind ?></td>
							<td><?php echo $row->tgl_pengajuan ?></td>
							<td><?php echo $row->total_hutang ?></td>
							<td><?php echo $row->jml_cicilan ?></td>
							<td><?php echo $row->status_lunas ?></td>
							<td><?php echo $row->kode_petugas ?></td>
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