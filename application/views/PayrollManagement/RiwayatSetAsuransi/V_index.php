<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Set Asuransi</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/RiwayatSetAsuransi');?>">
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
                  <a href="<?php echo site_url('PayrollManagement/RiwayatSetAsuransi/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                      <button type="button" class="btn btn-default btn-sm">
                        <i class="icon-plus icon-2x"></i>
                      </button>
                    </a>
                    <b>Set Asuransi</b>
		          </div>
		          <div class="box-body">

		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-riwayatSetAsuransi" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center; width:30px">NO</th>
                            <th style='text-align:center'>ACTION</th>
							<th>Tanggal Berlaku</th>
							<th>Tanggal Tberlaku</th>
							<th>Kd Status Kerja</th>
							<th>JKK</th>
							<th>JKM</th>
							<th>JHT Karyawan</th>
							<th>JHT Perusahaan</th>
							<th>JKN Karyawan</th>
							<th>JKN Perusahaan</th>
							<th>JPN Karyawan</th>
							<th>JPN Perusahaan</th>
							<th>Kode Petugas</th>
							<th>Tanggal Rec</th>

		                  </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; foreach($riwayatSetAsuransi_data as $row) { ?>
							<tr>
							  <td align='center'><?php echo $no++;?></td>
                              <td align='center' width='200px'>
                              	<a href="<?php echo base_url('PayrollManagement/RiwayatSetAsuransi/read/'.$row->id_set_asuransi.''); ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-eye"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/RiwayatSetAsuransi/update/'.$row->id_set_asuransi.''); ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/RiwayatSetAsuransi/delete/'.$row->id_set_asuransi.''); ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-times"></span></a>
                              </td>
							<td><?php echo $row->tgl_berlaku ?></td>
							<td><?php echo $row->tgl_tberlaku ?></td>
							<td><?php echo $row->kd_status_kerja ?></td>
							<td><?php echo $row->jkk ?></td>
							<td><?php echo $row->jkm ?></td>
							<td><?php echo $row->jht_kary ?></td>
							<td><?php echo $row->jht_prshn ?></td>
							<td><?php echo $row->jkn_kary ?></td>
							<td><?php echo $row->jkn_prshn ?></td>
							<td><?php echo $row->jpn_kary ?></td>
							<td><?php echo $row->jpn_prshn ?></td>
							<td><?php echo $row->kd_petugas ?></td>
							<td><?php echo $row->tgl_rec ?></td>

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