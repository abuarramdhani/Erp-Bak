<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Komp Tamb</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/KompTamb');?>">
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
                  <a href="<?php echo site_url('PayrollManagement/KompTamb/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                      <button type="button" class="btn btn-default btn-sm">
                        <i class="icon-plus icon-2x"></i>
                      </button>
                    </a>
                    <b>Komp Tamb</b>
		          </div>
		          <div class="box-body">

		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-kompTamb" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center; width:30px">NO</th>
                            <th style='text-align:center'>ACTION</th>
							<th style='text-align:center'>Periode</th>
							<th style='text-align:center'>Noind</th>
							<th style='text-align:center'>Tambahan</th>
							<th style='text-align:center'>Stat</th>
							<th style='text-align:center'>Desc </th>

		                  </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; $total=0; foreach($kompTamb_data as $row) { 
								$e_id = $this->encrypt->encode($row->id);
								$e_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $e_id);
								$total = $total + $row->tambahan;
							?>
							<tr>
							  <td align='center'><?php echo $no++;?></td>
                              <td align='center' width='200px'>
                              	<a href="<?php echo base_url('PayrollManagement/KompTamb/read/'.$e_id.''); ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-eye"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/KompTamb/update/'.$e_id.''); ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/KompTamb/delete/'.$e_id.''); ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-times"></span></a>
                              </td>
							<td align='center'><?php echo $row->periode ?></td>
							<td align='center'><?php echo $row->noind ?></td>
							<td align='right'><?php echo number_format((int)$row->tambahan,0,",",".") ?></td>
							<td align='center'><?php echo $row->stat ?></td>
							<td><?php echo $row->desc_ ?></td>
							</tr>
							<?php } ?>
		                </tbody>     
						<tfoot>
							<tr>
								<th class="text-center" colspan="4">Total</th>
								<th><?php echo number_format((int)$total,0,",",".") ?></th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
							</tr>
						</tfoot>
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