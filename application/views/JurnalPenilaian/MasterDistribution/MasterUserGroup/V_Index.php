 <section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterUnitGroup/modification');?>" class="form-horizontal" enctype="multipart/form-data">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
								<h1><b>Master Unit Group</b></h1>
								</div>
							</div>
							<div class="col-lg-1">
								<div class="text-right hidden-md hidden-sm hidden-xs">
		                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/MasterUnitGroup');?>">
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
									<button type="button" class="btn btn-default btn-sm" style="float: right;" onclick="PenilaianKinerja_tambahUnitGroup()">
										<i class="icon-plus icon-2x"></i>
									</button>
								</div>
								<div class="box-body">
									<div class="panel-body">
										<table class="table">
											<tbody id="daftarUnitGroup">
												<?php
													if(empty($namaUnitGroup))
													{
												?>
												<tr id="unitGroup">
													<div class="row">
														<td style="text-align: center; vertical-align: middle;width:100px;">
															<button type="button" class="btn btn-danger btn-sm PenilaianKinerja-deleteUnitGroup" onclick="PenilaianKinerja_hapusUnitGroup(this)" >
																<i class="fa fa-times"></i>
															</button>
														</td>
														<td>
															<div class="form-group">
																<input type="text" class="form-control hidden" hidden="" name="idUnitGroup[0]" value="-">
																<input type="text" class="form-control txtnamaUnitGroup" placeholder="Nama Unit Group" style="text-transform: uppercase;" name="txtnamaUnitGroup[0]" />
															</div>
															<div class="form-group">
																	<select name="cmbseksiUnitGroup[0][]" class="select2 PenilaianKinerja-daftarSeksi" style="width: 100%" multiple="">
																	</select>
																</div>
														</td>
													</div>
												</tr>
												<?php
													}
													else
													{
														$i = 0;
														foreach ($namaUnitGroup as $namaUG) 
														{
												?>
												<tr id="unitGroup">
													<div class="row">
														<td style="text-align: center; vertical-align: middle;width: 100px;">
															<button type="button" class="btn btn-danger btn-sm PenilaianKinerja-deleteUnitGroup" onclick="hapusUnitGroup('<?php echo $namaUG['id_unit_group'];?>', '<?php echo $namaUG['nama_unit_group'];?>')" data-toggle="modal" data-target="" id="">
																<i class="fa fa-times"></i>
															</button>
														</td>
														<td>
															<div class="form-group">
																<input type="text" class="form-control hidden" hidden="" name="idUnitGroup[<?php echo $i;?>]" value="<?php echo $namaUG['id_unit_group'];?>">
																<input type="text" class="form-control txtnamaUnitGroup" placeholder="Nama Unit Group" style="text-transform: uppercase;" name="txtnamaUnitGroup[<?php echo $i;?>]" value="<?php echo $namaUG['nama_unit_group'];?>" />
															</div>
																<div class="form-group">
																	<select name="cmbseksiUnitGroup[<?php echo $i;?>][]" class="select2 PenilaianKinerja-daftarSeksi" style="width: 100%;" multiple="">
																		<?php
																			foreach ($seksiUnitGroup as $seksiUG) 
																			{
																				if($seksiUG['id_unit_group']==$namaUG['id_unit_group'])
																				{
																		?>
																		<option value="<?php echo $seksiUG['value_seksi_unit_group'];?>" selected="true"><?php echo $seksiUG['nama_seksi_unit_group'];?></option>
																		<?php
																				}
																			}
																		?>
																	</select>
																</div>
														</td>
													</div>
												</tr>														
												<?php
															$i++;
														}
													}
												?>
											</tbody>
										</table>
									</div>
									<div class="panel-footer">
										<div class="row text-right">
											<button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>		
				</div>
			</form>	
		</div>
	</div>
	<div id="hapusUnitGroup" class="modal fade modal-danger" role="dialog">
	    <div class="modal-dialog">
	    	<div class="modal-content">
	    		<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterUnitGroup/delete');?>">
	    			<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					    <h4 class="modal-title">Hapus Unit Group</h4>
	    			</div>
	    			<div class="modal-body">
	    				<h5>
	    					Apakah Anda ingin menghapus data ini?
	    				</h5>
	    				<strong>
	    					<h4>
	    						<center>
	    							Unit Group <b><span id="txtDeleteUnitGroup"></span></b>
	    							<input class="form-control hidden" type="text" name="txtDeleteIDUnitGroup" value="" >
	    						</center>
	    					</h4>
	    				</strong>
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
			
				
