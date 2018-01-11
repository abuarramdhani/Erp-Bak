<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Surat Peringatan</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/MasterSuratPeringatan');?>">
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
						<b>Edit Master Surat Peringatan</b>
					</div>
					<?php foreach ($GetSP as $gs) { ?>
					<div class="box-body">
					<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterSuratPeringatan/update/'.$gs['id_sp_dtl'])?>">
					<input name="txtIdSP" value="<?php echo $gs['id_sp_dtl']?>" hidden>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Periode</label>
								<div class="col-lg-3">
									<input class="form-control singledatePK" name="txtDate" placeholder="Tanggal" value="<?php echo $gs['tberlaku']?>" >
								</div>
							</div>
						</div>
						
						<hr>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Nomor SP </label>
								<div class="col-lg-7">
									<input name="txtNoSP" class="form-control" value="<?php echo $gs['sp_num']?>"  >
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Nilai </label>
								<div class="col-lg-7">
									<input name="txtNilai" class="form-control" value="<?php echo $gs['nilai']?>"  type="number" >
								</div>
							</div>
						</div>
					<?php } ?>
						<hr>

						<div class="form-group">
							<div class="col-lg-10 text-right">
								<a href="<?php echo site_url('PenilaianKinerja/MasterSuratPeringatan');?>"  class="btn btn-primary btn btn-flat">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-success btn btn-flat">Save Data</button>
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
</section>			
			
				
