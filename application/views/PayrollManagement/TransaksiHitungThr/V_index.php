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
		          <a href="<?php echo site_url('PayrollManagement/TransaksiHitungThr/import/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Import" title="Import" >
                      <button type="button" class="btn btn-default btn-sm">
                        <i class="icon-file icon-2x"></i>
                      </button>
                    </a>
                  <a href="<?php echo site_url('PayrollManagement/TransaksiHitungThr/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                      <button type="button" class="btn btn-default btn-sm">
                        <i class="icon-plus icon-2x"></i>
                      </button>
                    </a>
                    <b>Transaksi Hitung Thr</b>
		          </div>
		          <div class="box-body">

		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-transaksiHitungThr" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center; width:30px"><div style="width:40px"></div>NO</th>
                            <th style='text-align:center'><div style="width:100px"></div>ACTION</th>
							<th><div style="width:100px">Tanggal</th>
							<th><div style="width:100px">Periode</th>
							<th><div style="width:100px">Noind</th>
							<th><div style="width:100px">Kd Status Kerja</th>
							<th><div style="width:100px">Diangkat</th>
							<th><div style="width:100px">Lama Thn</th>
							<th><div style="width:100px">Lama Bln</th>
							<th><div style="width:100px">Gaji Pokok</th>
							<th><div style="width:100px">THR</th>
							<th><div style="width:100px">Persentase Ubthr</th>
							<th><div style="width:100px">UBTHR</th>
							<th><div style="width:100px">Kode Petugas</th>
							<th><div style="width:100px">Tgl Jam Record</th>

		                  </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; foreach($transaksiHitungThr_data as $row) { ?>
							<tr>
							  <td align='center'><?php echo $no++;?></td>
                              <td align='center' width='200px'>
                              	<a href="<?php echo base_url('PayrollManagement/TransaksiHitungThr/read/'.$row->id_transaksi_thr.''); ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-eye"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/TransaksiHitungThr/update/'.$row->id_transaksi_thr.''); ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/TransaksiHitungThr/delete/'.$row->id_transaksi_thr.''); ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-times"></span></a>
                              </td>
							<td><?php echo $row->tanggal ?></td>
							<td><?php echo $row->periode ?></td>
							<td><?php echo $row->noind ?></td>
							<td><?php echo $row->kd_status_kerja ?></td>
							<td><?php echo $row->diangkat ?></td>
							<td><?php echo $row->lama_thn ?></td>
							<td><?php echo $row->lama_bln ?></td>
							<td><?php echo $row->gaji_pokok ?></td>
							<td><?php echo $row->thr ?></td>
							<td><?php echo $row->persentase_ubthr ?></td>
							<td><?php echo $row->ubthr ?></td>
							<td><?php echo $row->kode_petugas ?></td>
							<td><?php echo $row->tgl_jam_record ?></td>

							</tr>
							<?php } ?>
		                </tbody>                                      
		              </table>
		              <form class="form-inline" method="post" action="<?php echo $action; ?>">
						<div class="form-group">
						  <input type="text" class="form-control" id="txtPeriodeHitung" name="txtPeriodeHitung" placeholder="<?php echo date('Y-m');?>" required>
						</div>
						<button type="submit" class="btn btn-primary">Hitung</button>
					  </form>
		            </div>
		          </div>
		        </div>
	        </div>
	      </div>    
	    </div>    
	  </div>
	</div>
</section>