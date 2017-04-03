<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Transaksi Rapel</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/TransaksiRapel');?>">
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
                  <a href="<?php echo site_url('PayrollManagement/TransaksiRapel/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                      <button type="button" class="btn btn-default btn-sm">
                        <i class="icon-plus icon-2x"></i>
                      </button>
                    </a>
                    <b>Transaksi Rapel Gaji</b>
		          </div>
		          <div class="box-body">

		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-TransaksiRapel" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center; width:30px"><div style="width:40px"></div>NO</th>
                            <th style='text-align:center'><div style="width:100px"></div>ACTION</th>
							<th><div style="width:100px"></div>ID Rapel</th>
							<th><div style="width:100px"></div>Tahun</th>
							<th><div style="width:100px"></div>Bulan</th>
							<th><div style="width:100px"></div>Noind</th>
							<th><div style="width:100px"></div>Kd Stat Krj</th>
							<th><div style="width:100px"></div>GP Lama</th>
							<th><div style="width:100px"></div>GP Baru</th>
							<th><div style="width:100px"></div>Selisih GP</th>
							<th><div style="width:100px"></div>HTM</th>
							<th><div style="width:100px"></div>Pot Rapel GP</th>
							<th><div style="width:100px"></div>Rapel GP</th>
							<th><div style="width:100px"></div>HTM bln lalu</th>
							<th><div style="width:100px"></div></th>
		                  </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; foreach($TransaksiRapel_data as $row) { ?>
							<tr>
							  <td align='center'><?php echo $no++;?></td>
                              <td align='center' width='200px'>
                              	<a href="<?php echo base_url('PayrollManagement/TransaksiRapel/read/'.$row->id_transaksi_hutang.''); ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-eye"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/TransaksiRapel/update/'.$row->id_transaksi_hutang.''); ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/TransaksiRapel/delete/'.$row->id_transaksi_hutang.''); ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-times"></span></a>
                              </td>
							<td><?php echo $row->id_transaksi_hutang ?></td>
							<td><?php echo $row->no_hutang ?></td>
							<td><?php echo $row->tgl_transaksi ?></td>
							<td><?php echo $row->jenis_transaksi ?></td>
							<td><?php echo $row->jumlah_transaksi ?></td>
							<td><?php echo $row->lunas ?></td>

							</tr>
							<?php } ?>
		                </tbody>                                      
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