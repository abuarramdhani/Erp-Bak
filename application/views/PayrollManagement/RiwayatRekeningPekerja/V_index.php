<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Riwayat Rekening Pekerja</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/RiwayatRekeningPekerja');?>">
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
                  <a href="<?php echo site_url('PayrollManagement/RiwayatRekeningPekerja/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                      <button type="button" class="btn btn-default btn-sm">
                        <i class="icon-plus icon-2x"></i>
                      </button>
                    </a>
                    <b>Riwayat Rekening Pekerja</b>
		          </div>
		          <div class="box-body">
						<div class="row">
			              	<form method="post" action="<?php echo base_url('PayrollManagement/RiwayatRekeningPekerja/upload')?>" enctype="multipart/form-data">
								<div class="row" style="margin: 10px 0 10px 10px">
									<div class="col-lg-offset-7 col-lg-3">
										<input name="importfile" type="file" class="form-control" readonly required>
									</div>
									<div class=" col-lg-2">
										<button class="btn btn-primary btn-block">Load</button>
									</div>
							</form>
			          	</div>
									<?php
										if (!empty($data)) {
									?>
									<form method="post" action="<?php echo base_url('PayrollManagement/RiwayatRekeningPekerja/saveImport')?>">
										<div class="row" style="margin: 10px 0 10px 10px">
											<div class="col-lg-offset-10 col-lg-2">
												<input type="hidden" name="txtFileName" value="<?php echo $filename; ?>">
												<button class="btn btn-primary btn-block">Import</button>
											</div>
										</div>
									</form>
									<?php
										}
									?>
								</div>
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-riwayatRekeningPekerja" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center; width:30px">NO</th>
                            <th style='text-align:center'>ACTION</th>
							<th style='text-align:center'>Tgl Berlaku</th>
							<th style='text-align:center'>Noind</th>
							<th style='text-align:center'>Kd Bank</th>
							<th style='text-align:center'>No Rekening</th>
							<th style='text-align:center'>Nama Pemilik Rekening</th>
		                  </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; foreach($riwayatRekeningPekerja_data as $row) { ?>
							<tr>
							  <td align='center'><?php echo $no++;?></td>
                              <td align='center' width='200px'>
                              	<a href="<?php echo base_url('PayrollManagement/RiwayatRekeningPekerja/read/'.$row->id_riw_rek_pkj.''); ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-eye"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/RiwayatRekeningPekerja/update/'.$row->id_riw_rek_pkj.''); ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o"></span></a>
                              	<a href="<?php echo base_url('PayrollManagement/RiwayatRekeningPekerja/delete/'.$row->id_riw_rek_pkj.''); ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-times"></span></a>
                              </td>
							<td align='center'><?php echo $row->tgl_berlaku ?></td>
							<td align='center'><?php echo $row->noind ?></td>
							<td align='center'><?php echo $row->kd_bank ?></td>
							<td align='center'><?php echo $row->no_rekening ?></td>
							<td><?php echo $row->nama_pemilik_rekening ?></td>
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
</section>