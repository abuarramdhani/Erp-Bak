<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Bobot Nilai</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/MasterBobot');?>">
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
						<b>View Master Bobot Nilai</b>
					</div>
					
					<?php foreach ($GetBobot as $gb) {?>
					<div class="box-body">
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Periode</label>
								<div class="col-lg-3">
									<input class="form-control singledatePK" value="<?php echo $gb['tberlaku']; ?>" disabled >
								</div>
							</div>
						</div>
						
						<hr>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Aspek </label>
								<div class="col-lg-7">
									<input name="txtAspek" class="form-control" value="<?php echo $gb['aspek']; ?>" disabled>
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Bobot Nilai </label>
								<div class="col-lg-7">
									<input name="txtBobot" class="form-control" value="<?php echo $gb['bobot']; ?>" type="number" disabled>
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label"> Deskripsi </label>
								<div class="col-lg-7">
									<input name="txtDesc" class="form-control"  value="<?php echo $gb['description']; ?>" disabled>
								</div>
							</div>
						</div>
						<hr>

						<div class="form-group">
							<div class="col-lg-10 text-right">
								<a href="<?php echo site_url('PenilaianKinerja/MasterBobot');?>"  class="btn btn-primary btn btn-flat">Back</a>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
