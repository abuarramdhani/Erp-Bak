<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>DATA CAT KELUAR</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/List');?>">
                                <i class="fa fa-tint fa-2x"></i>
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
							<b>Insert Data Cat Keluar</b>
						</div>
						<form method="post" action="<?php echo site_url($action)?>" class="form-horizontal" id="form1">	
						<div class="box-body">					
							<tr>
								<div class="col-md-10">
								<div class="col-md-3">
									<label for="norm" class="control-label"><h4 class="box-title">Kode Cat</h4></label>
								</div>
								<div class="col-md-5">	
									<div class="form-group">
										<select name="slcKodeCat" id="slcKodeCat" class="form-control jsKodeCatKeluar" onchange="searchServiceProducts_new('<?php echo base_url();?>');disabledButtonOut()" required>
											<option value="" ></option>
										</select>
									</div>
								</div>
							</div>
							
							<div class="col-md-10">
								<div class="col-md-3">
									<label>
										<h4 class="box-title">Description</h4>
									</label>
								</div>
								<div class="col-md-5">	
									<div class="form-group">
										<input type="text"  class="form-control" onkeyup="disabledButtonOut()" id="txtDescription" name="txtDescription" placeholder="Input Description">
										</input>
									</div><!-- /.form group -->
								</div>
							</div>
							
							<div class="col-md-10" >
								<div class="col-md-8 "  >
								<fieldset class="field_set">
                                    <legend>Tanggal Expired</legend>
                                    <div class="form-group">
                                    <div   id="loading"></div>
                                    <div   id="result_table"></div>
                                    		<div id="eror" ></div>
                                    </div>
								</fieldset>
								</div>
							</div>
							<div class="col-md-10">
								<div class="col-md-3">
									<label>
										<h4 class="box-title">Bukti & No Bukti </h4>
									</label>
								</div>
								<div class="col-md-5">	
									<div class="form-group">
											<input type="text" class="form-control" onkeyup="disabledButtonOut()" id="txtBukti" name="txtBukti" placeholder="Input No Bukti">
										</input>
									</div><!-- /.form group -->
								</div>
							</div>
							<div class="col-md-10">
								<div class="col-md-3">
									<label>
										<h4 class="box-title">Petugas</h4>
									</label>
								</div>
								<div class="col-md-5">	
									<div class="form-group">
													<input type="text" class="form-control" onkeyup="disabledButtonOut()" id="txtPetugas" name="txtPetugas" placeholder="Input Petugas">
										</input>
									</div><!-- /.form group -->
								</div>
							</div>
						</div>
							<div class="box-footer">
								<table align="center">
									<td width="20%"><a href="<?php echo site_url('DataCatKeluar');?>" class="btn btn-primary btn-ls col-md-10" style="background:#2E6DA4;"> BACK </a></td>
									<td width="20%"><a href="<?php echo site_url('BtnTambahDataCatKeluar');?>" class="btn btn-primary btn-ls col-md-10" style="background:#2E6DA4;"> RESET </a></td>
									<td width="20%"><button class="btn btn-primary btn-ls col-md-10" id="txtBtnSave" style="background:#2E6DA4;" type="SUBMIT" name="SUBMIT" id="SUBMIT" disabled> SAVE </button></td>
								</table>
							</div>
						</form>
					</div>
				</div>
			</div>		
		</div>		
	</div>
</div>
</section>			