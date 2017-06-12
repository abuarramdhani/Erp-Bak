<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Set Tarif Pekerja Sakit</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/SetTarifPekerjaSakit');?>">
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
                  <a href="<?php echo site_url('PayrollManagement/SetTarifPekerjaSakit/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                      <button type="button" class="btn btn-default btn-sm">
                        <i class="icon-plus icon-2x"></i>
                      </button>
                    </a>
                    <b>Set Tarif Pekerja Sakit</b>
		          </div>
		          <div class="box-body">

		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-settarifpekerjasakit" style="font-size:12px;">
		                <thead class="bg-primary">
							<tr>
								<th style="text-align:center; width:30px">NO</th>
								<th style='text-align:center'>ACTION</th>
								<th style='text-align:center'>Tingkatan</th>
								<th style='text-align:center'>Bulan Awal</th>
								<th style='text-align:center'>Bulan Akhir</th>
								<th style='text-align:center'>Presentase</th>
							</tr>
						
		                </thead>
		                <tbody>
							<?php $no = 1; foreach($settarifpekerjasakit_data as $row) { ?>
							<tr>
								<td align='center'><?php echo $no++;?></td>
								<td align='center' width='200px'>
									<a href="<?php echo base_url('PayrollManagement/SetTarifPekerjaSakit/read/'.$row->kd_tarif.''); ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-eye"></span></a>
									<a href="<?php echo base_url('PayrollManagement/SetTarifPekerjaSakit/update/'.$row->kd_tarif.''); ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o"></span></a>
									<a href="<?php echo base_url('PayrollManagement/SetTarifPekerjaSakit/delete/'.$row->kd_tarif.''); ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-times"></span></a>
								</td>
								<td align='center'><?php echo $row->tingkatan ?></td>
								<td align='center'><?php echo $row->bulan_awal ?></td>
								<td align='center'><?php echo $row->bulan_akhir ?></td>
								<td align='center'><?php echo $row->persentase ?> %</td>
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