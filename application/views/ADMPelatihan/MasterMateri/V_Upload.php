<section class="content-header">
	<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-11">
				<div class="text-right">
				<h1><b>Master Training Material</b></h1>
				</div>
			</div>
			<div class="col-lg-1">
				<div class="text-right hidden-md hidden-sm hidden-xs">
                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/MasterTrainingMaterial');?>">
                        <i class="icon-wrench icon-2x"></i>
                        <span><br/></span>	
                    </a>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">		
				<div class="box-header with-border">
					<h3 class="box-title">Upload File Materi</h3>
				</div>
				<div class="box-body">
					<form id="formFoto" runat="server" method="post" enctype="multipart/form-data" action="<?php echo base_url('ADMPelatihan/MasterTrainingMaterial/doUpload'); ?>">
						<div class="panel-body">
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-2 control-label">Judul Materi Training</label>
									<div class="col-lg-6">
										<input name="txtNamaMateri" class="form-control toupper" placeholder="Judul Materi Training" required >
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-2 control-label">Browse File</label>
									<div class="col-lg-6">
										<input name="txtFile" type="file" class="form-control toupper" placeholder="cari file" required >
										<p style="margin-top:7px">Format <strong>*.pdf</strong></p>
										<p style="margin-top:7px">Max. size <strong>5Mb</strong></p>
									</div>
								</div>
							</div>
						</div>
						<div class="panel-footer">
							<div class="row text-right">
								<button type="submit" class="btn btn-primary btn-lg btn-rect" title="Simpan file" data-toogle="tooltip" >Simpan</button>
							</div>							
						</div>
					</form>
    			</div>
	    	</div>
	    </div>
	</div>
</section>
<?php echo $konfirmasi; ?>