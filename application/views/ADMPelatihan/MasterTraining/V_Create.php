<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Training</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/MasterTraining');?>">
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
						<b>Form Pembuatan Master Training</b>
					</div>
					
					<div class="box-body">
					<form method="post" action="<?php echo base_url('ADMPelatihan/MasterTraining/Add')?>">
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Nama Pelatihan</label>
								<div class="col-lg-8">
									<input name="txtNamaPelatihan" class="form-control toupper" placeholder="Nama Pelatihan" required >
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Standar Nilai</label>
								<div class="col-lg-8">
									<input name="txtBatas" class="form-control"  type="number" placeholder="Standar Nilai" required >
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px" hidden>
							<div class="form-group">
								<label class="col-lg-2 control-label">Status Pelatihan</label>
								<div class="col-lg-8" >
									<select name="slcStatus" class="select4 form-control" data-placeholder="Status Pelatihan" id="slcStatus" value="REGULER" >
										<option></option>
										<option value="0" selected="true">REGULER</option>
										<option value="1">PAKET</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Kuesioner </label>
								<div class="col-lg-8">
									<select class="form-control select4" name="slcQuestionnaire[]" data-placeholder="Kuesioner" multiple="multiple" required>
										<option></option>
										<?php foreach($questionnaire as $qs){?>
										<option value="<?php echo $qs['questionnaire_id']?>"><?php echo $qs['questionnaire_title'] ?></option>
										<?php }?>
									</select>
								</div>
							</div>
						</div>
						<hr>
						
						<!--
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">No. Pelatihan</label>
								<div class="col-lg-6">
									<input name="txtNoPelatihan" class="form-control toupper" placeholder="No. Pelatihan" required >
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Jumlah Peserta</label>
								<div class="col-lg-2">
									<input name="txtJumlahPeserta" class="form-control" placeholder="Jumlah Peserta" onkeypress="return isNumberKey(event)" required >
								</div>
								<label class="col-lg-1 control-label">Peserta</label>
								<div class="col-lg-3">
									<input type="radio" name="txtPeserta" value="0"> Staff<br>
									<input type="radio" name="txtPeserta" value="1"> Non-Staff<br>
									<input type="radio" name="txtPeserta" value="2"> Staff & Non Staff<br>
								</div>
							</div>
						</div>
						-->
						<div class="row" style="margin: 10px 10px">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-heading text-right">
											<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddObjective" title="Tambah Baris" onclick="AddObjective('<?php echo base_url(); ?>')"><i class="fa fa-plus"></i></a>
											<a href="javascript:void(0);" class="btn btn-sm btn-danger" id="DelObjective" title="Hapus Baris" onclick="deleteRow('tblObjective')"><i class="fa fa-remove"></i></a>
											<a id="HiddenDelObjective" onclick="deleteRow('tblParticipant')" hidden >Hidden</a>
										</div>
										<div class="panel-body">
											<div class="table-responsive" >
												<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblObjective" id="tblObjective">
													<form onkeyup="searchHistory(this)">
													<thead>
														<tr class="bg-primary">
															<th width="100%">Tujuan Pelatihan</th>
														</tr>
													</thead>
													<tbody id="tbodyObjective">
														<tr class="obclone">
															<td>
																<select class="form-control js-slcObjective search_form" name="slcObjective[]" id="slcObjective" required>
																</select>
															</td>
														</tr>
													</tbody>
													</form>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						

						<div class="form-group">
							<div class="col-lg-10 text-right">
								<a href="javascript:window.history.go(-1);" class="btn btn-primary btn btn-flat">Back</a>
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
			
				
