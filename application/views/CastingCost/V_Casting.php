<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>INPUT DATA CASTING</b></h1>									
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
						Form Input Data casting
					</div>
					<div class="box-body">
					<form id="saveForm" class="form-horizontal" method="post" action="<?php echo base_url('CastingCost/edit/submit') ?>">
						<div class="row" style="font-size: 13px">
							<div class="col-lg-12" style="padding-top: 10px">
								<div class="form-group" style="margin: 8 auto" >
									<label class="col-md-4 "><p><i><b> Lengkapi data-data Dibawah ini </b></i></p></label>
								</div>
								<div class="form-group" style="margin: 8 auto">
									<label class="col-md-2 control-label">Pemesan</label>
									<div class="col-md-4">
										<input type="text" name="txt_pemesan" class="form-control input-sm" placeholder="Input Nama Pemesan" required >
									</div>
								</div>
								<div class="form-group" style="margin: 8 auto">
									<label class="col-md-2 control-label">Part Number</label>
									<div class="col-md-4">
										<input type="text" name="txt_partNumber" class="form-control input-sm" placeholder="Input Part Number"  required >
									</div>
								</div>
								<div class="form-group" style="margin: 8 auto; margin-bottom: 20">
									<label class="col-md-2 control-label">Description</label>
									<div class="col-md-4">
										<input type="text" name="txt_description" class="form-control input-sm" placeholder="Input Description" required >
									</div>
								</div>

								<div class="form-group" style="margin: 8 auto">
									<label class="col-md-2 control-label">Material Casting</label>
									<div class="col-md-3">
										<select name="txt_materialCasting" class="form-control select-2" data-placeholder="Pilih Salah Satu"required  >
											<option></option>
											<?php foreach ($material as $m) {?>
												<option value="<?php echo $m['FORMULA_NO'] ?>" > <?php echo $m['FORMULA_NO'] ?></option>			
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group" style="margin: 8 auto">
									
									<label class="col-md-2 control-label">Berat Cairan</label>
									<div class="col-md-2">
										<input type="number" name="berat_cairan" id="berat_cairan" class="form-control input-sm number-format"   placeholder="0.00" step="any" required >
									</div>
									<label class=" col-md-1 ">Kg</label>
									
									<label class="col-md-2 control-label">Berat Remelt</label>
									<div class="col-md-2">
										<input type="number" name="berat_remelt" id="berat_remelt" class="form-control input-sm" placeholder="0.00" readonly required >
									</div>
									<label class="control-label">Kg</label>
								</div>
								<div class="form-group" style="margin: 8 auto">
									<label class="col-md-2 control-label">Berat Casting</label>
									<div class="col-md-2">
										<input type="number" name="berat_casting" id="berat_casting" class="form-control input-sm number-format" placeholder="0.00"  step="any" required >
									</div>
									<label class=" col-md-1">Kg</label>
									<label class="col-md-2 control-label">Yield Casting</label>
									<div class="col-md-2">
										<input type="Number" name="yield_casting" id="yield_casting" class="form-control input-sm"  readonly placeholder="0.00" step="any" required >
									</div>
									<label class="control-label">%</label>
								</div>
								<div class="form-group" style="margin: 8 auto">
									<label class="col-md-2 control-label">Scrap/Reject</label>
									<div class="col-md-2">
										<input step="any" type="number" name="scrap" class="form-control input-sm number-format" placeholder="0" required  >
									</div>
									<label  style="text-align: left;" class=" col-md-2 control-label">%</label>
								</div>
								<div class="form-group" style="margin: 8 auto">
									<label class="col-md-2 control-label">Menggunakan Inti?</label>
									<div class="col-md-1">
										<input type="radio" class="core_fiedl" name="core_input" value="yes"><b>  Ya</b> </input>
									</div>
									<div class="col-md-1">
										<input type="radio" class="core_fiedl" name="core_input" value="no"><b>  Tidak</b> </input>
									</div>
								</div>
								<div id="fiedl_core" style="display: none;">
									<div class="form-group" style="margin: 8 auto; margin-top: 20px">
										<label class="col-md-2 control-label">Material Inti</label>
										<div class="col-md-3">
											<input type="text" name="txt_materialInti" class="form-control input-sm" placeholder="Input Material Inti"  >
										</div>
									</div>
									<div class="form-group" style="margin: 8 auto">
										<label class="col-md-2 control-label">Berat Inti</label>
										<div class="col-md-2">
											<input type="Number"  name="berat_inti" class="form-control input-sm number-format" placeholder="0.00" step="any"  >
										</div>
										<label style="text-align: left;" class=" col-md-2 control-label">Kg</label>
									</div>
									<div class="form-group" style="margin: 8 auto">
										<label class="col-md-2 control-label">Target Pembuatan Inti</label>
										<div class="col-md-2">
											<input type="text" onchange="addCommass(event,this)" name="target_inti" class="form-control input-sm" placeholder="0" step="any"  >
										</div>
										<label style="text-align: left;" class=" col-md-2 control-label">Pieces/Shift</label>
									</div>
									<div class="form-group" style="margin: 8 auto">
										<label class="col-md-2 control-label">Mesin Shellcore</label>
										<div class="col-md-3">
											<select style="width: 100%" name="txt_mesin_shelcore"  class="form-control select-2" data-placeholder="Pilih Salah Satu" >
											<option></option>
												<option value="Shellcore Kecil">Shellcore Kecil</option>
												<option value="Shellcore Besar">Shellcore Besar</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group" style="margin: 8 auto; margin-top: 20px">
									<label class="col-md-2 control-label">Mesin Moulding</label>
									<div class="col-md-3">
										<input type="text" name="txt_moulding" class="form-control input-sm" placeholder="Input Mesin Moulding" " required >
									</div>
								</div>
								<div class="form-group" style="margin: 8 auto">
									<label class="col-md-2 control-label"> Basic Tonage (Tonase)  </label>
									<div class="col-md-2">
										<input type="text" onchange="addCommass(event,this)" name="basic_tonage" class="form-control input-sm" placeholder="0" required>
									</div>
									<label style="text-align: left;" class=" col-md-1 control-label">Kg/Shift</label>
									<label class="col-md-2 control-label">Target Cetak/Shift</label>
									<div class="col-md-2">
										<input type="text" onchange="addCommass(event,this)" name="target_pieces" id="target_pieces" class="form-control input-sm"  placeholder="0" required >
									</div>
									<label style="text-align: left;" class="col-md-2 ">Pieces/Shift</label>
								</div>
								<div class="form-group" style="margin: 8 auto">
									<label class="col-md-2 control-label">Cavity per Flask</label>
									<div class="col-md-1">
										<input type="number" name="cavity_flask" id="cavity_flask" class="form-control input-sm number-format" step="any" placeholder="0" required >
									</div>
									<label style="text-align: left;" class=" col-md-2 control-label">Cavity</label>
									<label class="col-md-2 control-label">Target Cetak/Shift</label>
									<div class="col-md-2">
										<input type="Number" name="target_flask" id="target_flask" class="form-control input-sm" readonly="readonly" placeholder="0" step="any" required >
									</div>
									<label style="text-align: left;" class=" col-md-2 ">Flask/Shift</label>
								</div>
								<div class="form-group" style="margin: 8 auto">
									<label class="col-md-2 control-label">Berat Pasir Cetak</label>
									<div class="col-md-2">
										<input onchange="addCommass(event,this)" type="text" name="berat_pasir" class="form-control input-sm" placeholder="0" step="any" required >
									</div>
									<label style="text-align: left;" class=" col-md-2 control-label">Kg</label>
								</div>
								<div class="form-group" style="margin: 8 auto">
									<label class="col-md-2 control-label">Konsumsi Batu gerinda</label>
									<div class="col-md-2">
										<input type="number" name="batu_gerinda" class="form-control input-sm number-format" placeholder="0.00" step="any" required >
									</div>
									<label style="text-align: left;" class=" col-md-2 control-label">Pieces</label>
								</div>
								<div class="form-group" style="margin: 8 auto">
									<label class="col-md-2 control-label">Target Grinding / Shift</label>
									<div class="col-md-2">
										<input onchange="addCommass(event,this)" type="text" name="target_grinding" class="form-control input-sm" placeholder="0" step="any" required >
									</div>
									<label style="text-align: left;" class=" col-md-2 control-label">Pieces</label>
								</div>
								<div class="form-group" style="margin: 8 auto">
									<label class="col-md-2 control-label">Waktu Pembuatan Pola </label>
									<div class="col-md-1">
										<input type="Number" name="pembuatan_pola" class="form-control input-sm number-format" placeholder="0"  step="any"  >
									</div>
									<label style="text-align: left;" class=" col-md-2 control-label" >Jam</label>
								</div>
								<div class="form-group" style="margin: 8 auto; text-align: center;" >
									<div class="col-md-12" >
										<button type="Submit" class="btn btn-primary glyphicon glyphicon-menu-right" > SUBMIT </button>
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
