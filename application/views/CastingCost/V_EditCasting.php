
		<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>EDIT DATA CASTING</b></h1>
						
						
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CastingCost/InputCasting');?>">
                                <i class="icon-dollar icon-2x"></i>
                                <span ><br /></span>
                            </a>
							

                            
						</div>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						Form Edit Data casting
					</div>
					<div class="box-body">
					<form id="saveForm" class="form-horizontal" method="post" action="<?php echo base_url('CastingCost/edit/export_excel') ?>">
								<div class="row" style="font-size: 13px">
									<div class="col-lg-12" style="padding-top: 10px">
										<div class="form-group" style="margin: 8 auto" >
											<label class="col-md-4 "><p><i><b> Lengkapi data-data Dibawah ini </b></i></p></label>
											<input  type="hidden" name="txt_date" value="<?php echo $data_input[0]['date_submition'] ;?>" >
											<input type="hidden" name="txt_no_doc" value="<?php echo $data_input[0]['no_document'] ;?>" >
											
										</div>
										<div class="form-group" style="margin: 8 auto;">
											<div class="col-md-4">
											<label ><p><i><b> Tarif Mesin per Jam </b></i></p></label>
											<table  border="1px" style="width: 100%">
												<thead style="background-color: #7ae2b2">
													<tr>
														<td style="padding: 5px; text-align: center;" >Resource </td>
														<td style="padding: 5px; text-align: center;">Cost</td>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($costMachine as $cm) {?>
														<tr>
															<td style="padding: 5px;"><?php echo $cm['resource']; ?> 
																<input type="text" hidden name="resource_machine" value="<?php echo $cm['resource']; ?>">
															</td>
															<td style="padding: 5px;">
																<input  class="form-control format_money"  type="text" name="" value="<?php echo $cm['cost']; ?> "  onchange="save_cost(event, this)">
															</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
											<label ><p><i><b> Catatan : untuk mengedit cost dari data diatas , edit pada kolom cost kemudian tekan tab sampai muncul notifikasi </b></i></p></label>
											</div>
											<div class="col-md-4">
											<label <p><i><b>Tarif Biaya Listrik per Jam</b></i></p></label>
											<table  border="1px" style="width: 100%">
												<thead style="background-color: #29a99d">
													<tr>
														<td style="padding: 5px; text-align: center;" >Resource </td>
														<td style="padding: 5px; text-align: center;">Cost</td>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($costElectric as $ce) {?>
														<tr>
															<td style="padding: 5px;"><?php echo $ce['resource']; ?> 
																<input type="text" hidden name="resource_electric" value="<?php echo $ce['resource']; ?>">
															</td>
															<td style="padding: 5px;">
																<input class="form-control format_money" type="text" name="" value="<?php echo $ce['cost']; ?> " onchange="save_cost2(event, this)">

															</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
											</div>
										</div>
										<div class="form-group" style="margin: 8 auto; margin-top: 20px" >
											<label class="col-md-4 "><p><b><i> Cost Rate Parameter --------------------</i> </b></p></label>
										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Tahun</label>
											<div class="col-md-1">
												<select class="form-control select-2" name="slc_year" data-placeholder ="Pilih Tahun"  style="width: 100px" required>
													<option></option>
													<?php foreach ($year as $y) {?>
														<option value="<?php echo $y['CALENDAR_CODE']; ?>"> <?php echo $y['CALENDAR_CODE']; ?> </option>
													<?php }?>
												</select>
											</div>
											<label class="col-md-2 control-label">Periode</label>
											<div class="col-md-2">
												<select class="form-control select-2" name="slc_period" data-placeholder ="Pilih Periode"  style="width: 100px" required>
													<option></option>
													<?php foreach ($period as $p) {?>
														<option value="<?php echo $p['PERIOD_CODE']; ?>"> <?php echo $p['PERIOD_CODE']; ?> </option>
													<?php }?>
												</select>
											</div>
										</div>
										<div class="form-group" style="margin: 8 auto; margin-bottom: 20px">
											<label class="col-md-2 control-label">Cost Type </label>
											<div class="col-md-1">
												<select class="form-control select-2" data-placeholder ="Pilih Cost Type"  name="slc_cost_type" style="width: 100px ; required">
													<option></option>
													<option value="PMAC" >PMAC</option>
													<option value="STND" >STND</option>
												</select>
											</div>
											<label class="col-md-2 control-label">IO</label>
											<div class="col-md-1">
												<select class="form-control select-2" data-placeholder ="Pilih Io" name="slc_io"  style="width: 100px">
													<option></option>
													<option value="OPM" >OPM</option>
													<option value="OPT" >OPT</option>
												</select>
											</div>
										</div>
										<div class="form-group" style="margin: 8 auto" >
											<label class="col-md-4 "><p><i><b> Data hasil Input --------------------</b></i></p></label>
										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Pemesan</label>
											<div class="col-md-4">
												<input type="text" name="txt_pemesan" class="form-control input-sm" placeholder="Input Nama Pemesan" required
												value="<?php echo $data_input[0]['orderer'] ;?>" >
											</div>
										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Part Number</label>
											<div class="col-md-4">
												<input type="text" name="txt_partNumber" class="form-control input-sm" placeholder="Input Part Number"
												value="<?php echo $data_input[0]['part_number'] ;?>" >
											</div>
										</div>
										<div class="form-group" style="margin: 8 auto; margin-bottom: 20">
											<label class="col-md-2 control-label">Description</label>
											<div class="col-md-4">
												<input type="text" name="txt_description" class="form-control input-sm" placeholder="Input Description"
												value="<?php echo $data_input[0]['description'] ;?>" >
											</div>
										</div>

										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Material Casting</label>
											<div class="col-md-3">
												<input type="text" name="txt_materialCasting" class="form-control input-sm" placeholder="Input Material Casting"
												value="<?php echo $data_input[0]['material_casting'] ;?>" >
											</div>
										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Berat Casting</label>
											<div class="col-md-2">
												<input type="number" name="berat_casting" id="berat_casting" class="form-control input-sm" placeholder="0.00"  step="any"
												value="<?php echo $data_input[0]['casting_weight'] ;?>" >
											</div>
											<label class=" col-md-1 ">Kg</label>
											<label class="col-md-2 control-label">Berat Cairan</label>
											<div class="col-md-2">
												<input type="number" name="berat_cairan" id="berat_cairan" class="form-control input-sm"  readonly placeholder="0.00" step="any" value="<?php echo $data_input[0]['liquid_weight'] ;?>" >
											</div>
											<label class="control-label">Kg</label>

										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Berat Remelt</label>
											<div class="col-md-2">
												<input type="number" name="berat_remelt" id="berat_remelt" class="form-control input-sm" placeholder="0.00" step="any" 
												value="<?php echo $data_input[0]['remelt_weight'] ;?>">
											</div>
											<label class=" col-md-1">Kg</label>
											
											<label class="col-md-2 control-label">Yield Casting</label>
											<div class="col-md-2">
												<input type="Number" name="yield_casting" id="yield_casting" class="form-control input-sm"  readonly placeholder="0" step="any" value="<?php echo $data_input[0]['yield_casting'] ;?>" >
											</div>
											<label class="control-label">%</label>
										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Scrap/Reject</label>
											<div class="col-md-2">
												<input step="any" type="number" name="scrap" class="form-control input-sm" placeholder="0" 
												value="<?php echo $data_input[0]['scrap_reject'] ;?>" >
											</div>
											<label  style="text-align: left;" class=" col-md-2 control-label">%</label>
										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Material Inti</label>
											<div class="col-md-3">
												<input type="text" name="txt_materialInti" class="form-control input-sm" placeholder="Input Material Inti" 
												value="<?php echo $data_input[0]['material_core'] ;?>">
											</div>
										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Berat Inti</label>
											<div class="col-md-2">
												<input type="Number"  name="berat_inti" class="form-control input-sm" placeholder="0.00" step="any" 
												value="<?php echo $data_input[0]['core_weight'] ;?>">
											</div>
											<label style="text-align: left;" class=" col-md-2 control-label">Kg</label>
										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Target Pembuatan Inti</label>
											<div class="col-md-2">
												<input type="Number" name="target_inti" class="form-control input-sm" placeholder="0" step="any" 
												value="<?php echo $data_input[0]['target_core'] ;?>">
											</div>
											<label style="text-align: left;" class=" col-md-2 control-label">Pieces/Shift</label>
										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Mesin Shelcore</label>
											<div class="col-md-3">
												<input type="text" name="txt_mesin_shelcore" class="form-control input-sm" placeholder="Input Mesin Shelcore" 
												value="<?php echo $data_input[0]['shelcore_machine'] ;?>">
											</div>
										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Mesin Moulding</label>
											<div class="col-md-3">
												<input type="text" name="txt_moulding" class="form-control input-sm" placeholder="Input Mesin Shelcore" 
												value="<?php echo $data_input[0]['molding_machine'] ;?>" >
											</div>
										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label"> Basic Tonage (Tonase)  </label>
											<div class="col-md-2">
												<input type="Number" id="basic_tonage" name="basic_tonage" class="form-control input-sm" placeholder="0.00" step="any" 
												value="<?php echo $data_input[0]['basic_tonage'] ;?>">
											</div>
											<label style="text-align: left;" class=" col-md-1 control-label">Kg/Shift</label>
											<label class="col-md-2 control-label">Target Cetak/Shift</label>
											<div class="col-md-2">
												<input type="Number" name="target_pieces" id="target_pieces" class="form-control input-sm" placeholder="0" step="any" value="<?php echo $data_input[0]['target_mold_pieces'] ;?>">
											</div>
											<label style="text-align: left;" class=" col-md-2 ">Pieces/Shift</label>
										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Cavity per Flask</label>
											<div class="col-md-1">
												<input type="Number" name="cavity_flask" id="cavity_flask" class="form-control input-sm" step="any" 
												value="<?php echo $data_input[0]['cavity'] ;?>">
											</div>
											<label style="text-align: left;" class=" col-md-2 control-label">Cavity</label>
											<label class="col-md-2 control-label">Target Cetak/Shift</label>
											<div class="col-md-2">
												<input type="Number" name="target_flask" id="target_flask" class="form-control input-sm" readonly="readonly" placeholder="0" step="any" value="<?php echo $data_input[0]['target_mold_flask'] ;?>" >
											</div>
											<label style="text-align: left;" class=" col-md-2 ">Flask/Shift</label>
										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Berat Pasir Cetak</label>
											<div class="col-md-2">
												<input type="Number" name="berat_pasir" class="form-control input-sm" placeholder="0.00" step="any"
												value="<?php echo $data_input[0]['sand_mold_weight'] ;?>" >
											</div>
											<label style="text-align: left;" class=" col-md-2 control-label">Kg</label>
										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Konsumsi Batu gerinda / Pcs </label>
											<div class="col-md-2">
												<input type="Number" name="batu_gerinda" class="form-control input-sm" placeholder="0" step="any"
												value="<?php echo $data_input[0]['grindstone'] ;?>" >
											</div>
											<label style="text-align: left;" class=" col-md-2 control-label">Pieces</label>
										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Target Grinding / Shift</label>
											<div class="col-md-2">
												<input type="Number" name="target_grinding" class="form-control input-sm " placeholder="0" step="any" 
												value="<?php echo $data_input[0]['target_grinding'] ;?>">
											</div>
											<label style="text-align: left;" class=" col-md-2 control-label">Pieces</label>
										</div>
										<div class="form-group" style="margin: 8 auto">
											<label class="col-md-2 control-label">Waktu Pembuatan Pola </label>
											<div class="col-md-1">
												<input type="Number" name="pembuatan_pola" class="form-control input-sm" placeholder="0"  step="any"
												value="<?php echo $data_input[0]['time_making'] ;?>" >
											</div>
											<label style="text-align: left;" class=" col-md-2 control-label" >Jam</label>
										</div>

												<input type="text" hidden="hidden" name="id" placeholder="0" value="<?php echo $data_input[0]['id'] ;?>"  >
										<div class="form-group" style="margin: 8 auto; margin-top: 25px; margin-bottom: 20px" >
											<div class="col-md-4" style="text-align: right;" >
												<button type="submit" class="btn btn-success glyphicon glyphicon-download" > SAVE </button>
											</div>
											<div class="col-md-6" >
												<!-- <a href="<?php echo base_url('') ?>"><button type="button" class="btn btn-primary glyphicon glyphicon-ok" > CLOSE REQUEST </button></a> -->
											</div>
										</div>

									</div>
								</div>
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


</section>
	</div>
  