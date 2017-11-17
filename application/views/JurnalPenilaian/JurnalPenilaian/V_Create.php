<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Jurnal Penilaian</b></h1>
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
						<b>Form Pembuatan Penilaian Kinerja</b>
					</div>
					
					<div class="box-body">
					<form method="post" action="<?php echo base_url('PenilaianKinerja/JurnalPenilaianPersonalia/Add')?>">
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Periode</label>
								<div class="col-lg-3">
									<input class="form-control singledatePK" name="txtDate1" placeholder="Tanggal" required >
								</div>
								<label class="col-lg-1 control-label" align="center">-</label>
								<div class="col-lg-3">
									<input class="form-control singledatePK" name="txtDate2" placeholder="Tanggal" required >
								</div>
							</div>
						</div>
						
						<hr>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Departemen </label>
								<div class="col-lg-7">
									<select name="slcDepartemenPK" class="form-control js-slcDepartemenPK">
									</select>
								</div>
							</div>
						</div>

						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Unit </label>
								<div class="col-lg-7">
									<select name="slcUnitPK" class="form-control js-slcUnitPK">
									</select>
								</div>
							</div>
						</div>

						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Seksi </label>
								<div class="col-lg-7">
									<select name="slcSectionPK" class="form-control js-slcSectionPK">
									</select>
								</div>
							</div>
						</div>
						<hr>
						<div class="row" style="margin: 10px 10px">
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-heading text-right">
											<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddPekerja" title="Tambah Baris" onclick="AddPekerja('<?php echo base_url(); ?>')"><i class="fa fa-plus"></i></a>
											<!-- <a href="javascript:void(0);" class="btn btn-sm btn-danger" id="DelParticipant" title="Hapus Baris" onclick="deleteRow('tblPekerja')"><i class="fa fa-remove"></i></a> -->
											<!-- <a id="HiddenDelObjective" onclick="deleteRow('tblParticipant')" hidden >Hidden</a> -->
										</div>
										<div class="panel-body">
											<div class="table-responsive" >
												<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblPekerja">
													<thead>
														<tr class="bg-primary">
															<th width="5%" class="sorting_disabled" rowspan="1" colspan="1" style="width: 48.7778px;">NO</th>
															<th width="90%">Daftar Pekerja</th>
															<th width="10%"></th>
														</tr>
													</thead>
													<tbody id="tbodyPekerja">
														<tr class="clone" row-id="<?php echo $number;?>">
															<td ><?php echo $number;?></td>
															<td>
																<div class="input-group">
																	<div class="input-group-addon">
																		<i class="glyphicon glyphicon-user"></i>
																	</div>
																	<select class="form-control js-slcPekerja" name="slcPekerja[]" required>
																		<option value=""></option>
																	</select>
																</div>
															</td>
															<td>
																<!-- <button type="button" class="btn btn-danger list-del"><i class="fa fa-remove"></i></button> -->
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>

						<div class="form-group">
							<div class="col-lg-10 text-right">
								<a href="<?php echo site_url('ADMPelatihan/MasterTraining');?>"  class="btn btn-primary btn btn-flat">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-success btn btn-flat">Save Data</button>
							</div>
						</div>
						
					<form>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
