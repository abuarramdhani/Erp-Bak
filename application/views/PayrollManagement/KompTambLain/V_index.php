<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Komp Tamb Lain</b></h1>
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
                  <a href="<?php echo site_url('PayrollManagement/KompTambLain/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                      <button type="button" class="btn btn-default btn-sm">
                        <i class="icon-plus icon-2x"></i>
                      </button>
                    </a>
                    <b>Komp Tamb Lain</b>
		          </div>
		          <div class="box-body">

		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-kompTamb-lain" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center; width:30px">NO</th>
                            <th style='text-align:center'>ACTION</th>
							<th style='text-align:center'>Periode</th>
							<th style='text-align:center'>Noind</th>
							<th style='text-align:center'>Tamb Lain</th>
							<th style='text-align:center'>Pot Lain</th>
							<th style='text-align:center'>Desc </th>

		                  </tr>
		                </thead>
		                <tbody>
							<?php 
								$no = 1; 
								$total_tamb = 0;
								$total_pot = 0;
							
							foreach($KompTambLain_data as $row) { 
								$e_id = $this->encrypt->encode($row->id_komp_pot_tam);
								$e_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $e_id);
								$total_tamb = $total_tamb + $row->tamb_lain;
								$total_pot = $total_pot + $row->pot_lain;
							?>
							<tr>
							  <td align='center'><?php echo $no++;?></td>
                              <td align='center' width='200px'>
                              	<a href="<?php echo base_url('PayrollManagement/KompTambLain/read/'.$e_id.''); ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-eye"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/KompTambLain/update/'.$e_id.''); ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/KompTambLain/delete/'.$e_id.''); ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-times"></span></a>
                              </td>
							<td align='center'><?php echo $row->tanggal ?></td>
							<td align='center'><?php echo $row->noind ?></td>
							<td align='center'><?php echo number_format((int)$row->tamb_lain,0,",","."); ?></td>
							<td align='right'><?php echo number_format((int)$row->pot_lain,0,",","."); ?></td>
							<td><?php echo $row->ket ?></td>
							</tr>
							<?php } ?>
		                </tbody>
						<tfoot>
							<tr>
								<th colspan="4" class="text-center">Total</th>
								<th><?php echo number_format((int)$row->pot_lain,0,",","."); ?></th>
								<th><?php echo number_format((int)$row->pot_lain,0,",","."); ?></th>
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