<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Jurnal Penilaian Personalia</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/JurnalPenilaianPersonalia');?>">
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
						
						<b data-toogle="tooltip" title="Halaman untuk membuat template penilaian.">Penilaian Kinerja</b>
					</div>
					<div class="box-body">
					<div class="row">
							<div class="col-lg-12">
					<?php
						$this->load->view('JurnalPenilaian/V_alert');
					  ?>
					  </div>
					</div>
						<div class="row">
							<div class="col-lg-3">&nbsp;</div>
							<div class="col-lg-6">
							<form method="post" action="<?php echo $action; ?>">
                                <div class="input-group">
                                    <input name="txtPeriode" class="form-control JurnalPenilaian-daterangepicker" type="text"/>
                                    <span class="input-group-btn">
                                        <div class="fileUpload btn btn-block btn-warning">
                                            <span>Create</span>
                                            <input name="file" type="submit" class="upload" required/>
                                        </div>
                                    </span>
                                </div>
                                </form>
                            </div>
						</div>
						<br>
						<div class="row">
							<div class="col-lg-2">
							&nbsp;
							</div>
							<div class="col-lg-8">
								<table class="table table-striped table-bordered table-hover text-left" id="" style="font-size:14px;">
								<thead class="bg-primary">
									<tr>
										<th width="5%" class="text-center">No</th>
										<th width="25%" class="text-center">Periode</th>
										<th width="70%" class="text-center">Process</th>
									</tr>
								</thead>
								<tbody>
									<?php $no=1; foreach($periodicaly as $pc)
										{ 
											$periode 	= 	$pc['periode'];
									?>
									<tr>
										<td align="center"><?php echo $no; ?></td>
										<td align="center"><?php echo $pc['periode']; ?></td>
										<td align="right">
										<a href="<?php echo site_url('PenilaianKinerja/JurnalPenilaianPersonalia/view/'.$pc['periode']) ?>" class="btn btn-xs btn-info" title="Lihat Data"><i class="fa fa-search"></i> View</a>
										<?php
													if($pc['status_konfirmasi']==0)
													{
												?>
												<a href="<?php echo site_url('PenilaianKinerja/JurnalPenilaianEvaluator/index/'.$pc['periode']) ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"></i>Input Nilai</a>
												<?php
													}
													elseif($pc['status_konfirmasi']==1)
													{
												?>
												<a href="<?php echo site_url('PenilaianKinerja/JurnalPenilaianEvaluator/view/'.$pc['periode']) ?>" class="btn btn-xs btn-success" title="Lihat Data"><i class="fa fa-search"></i> View</a>
												<?php
													}

												?>	
												<a href="<?php echo site_url('PenilaianKinerja/JurnalPenilaianPersonalia/analisaGolongan/'.$pc['periode']) ?>" class="btn bg-navy btn-xs"><i class="fa fa-users"></i> Analisa</a>
												<a href="<?php echo site_url('PenilaianKinerja/JurnalPenilaianPersonalia/exportFormSeksi/'.$pc['periode']) ?>" target="_blank" class="btn bg-red btn-xs"><i class="fa fa-file-pdf-o"></i> Form Seksi</a>
												<a href="<?php echo site_url('PenilaianKinerja/JurnalPenilaianPersonalia/exportExcelNilai/'.$pc['periode']) ?>" target="_blank" class="btn btn-success btn-xs"><i class="fa fa-file-excel-o"></i> Report</a>
										<a data-toggle="modal" data-target="" class="btn bg-maroon btn-xs" title="Batalkan penilaian" onclick="hapusJurnalPenilaian('<?php echo $pc['periode'] ?>')"><i class="fa fa-remove"></i> Cancel</a>
										</td>
									</tr>
									<?php $no++; } ?>
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
	</div>
	<div id="hapusJurnalPenilaian" class="modal fade modal-danger" role="dialog">
	    <div class="modal-dialog">
	    	<div class="modal-content">
	    		<form method="post" action="<?php echo base_url('PenilaianKinerja/JurnalPenilaianPersonalia/delete');?>">
	    			<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					    <h4 class="modal-title">Hapus Jurnal Penilaian Periode <span id="labelPeriode"></span></h4>
	    			</div>
	    			<div class="modal-body">
	    				<h5>
	    					Apakah Anda ingin menghapus data ini?
	    					<input type="text" name="periodeJurnalPernilaian" hidden="hidden" id="periodeJurnalPernilaian" value="">
	    				</h5>
	    				<br/>
	    				<span style="text-align: right;">
	    					<h6>
	    						<i>
	    							Data yang dihapus akan berpengaruh besar pada data lain yang memiliki kaitan.
	    						</i>
	    					</h6>
	    				</span>	    									
    				</div>
    				<div class="modal-footer">
    					<button type="submit" class="btn btn-danger">Delete</button>
    				</div>
    			</form>
    		</div>
    	</div>
   	</div>	
</section>			
			
				
